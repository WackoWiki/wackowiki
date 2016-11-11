<?php

if (!defined('IN_WACKO'))
{
	exit('No direct script access allowed');
}

/*

########################################################
##              Email Constructor                     ##
########################################################

*/

class Email
{
	// VARIABLES
	var $engine;

	// CONSTRUCTOR
	function __construct(&$engine)
	{
		$this->engine = & $engine;
		$this->engine->load_translation($this->engine->db->language);
	}

	// MAILER
	// $email_to			- recipient address
	// $subject, $message	- self-explaining
	// $email_from			- place specific address into the 'From:' field
	// $charset				- send message in specific charset (w/o actual re-encoding)
	// $xtra_headers		- (array) insert additional mail headers
	// $supress_tls			- don't change all http links to https links in the message body
	function send_mail($email_to, $subject, $body, $email_from = '', $charset = '', $xtra_headers = [], $supress_tls = false)
	{
		if (!$this->engine->db->enable_email || ( !$email_to || !$subject || !$body) )
		{
			return;
		}

		if (empty($charset))
		{
			$charset = $this->engine->get_charset();
		}

		$name_to		= '';

		if (preg_match('/^([^<>]*)<([^<>]*)>$/', $email_to, $match))
		{
			$email_to	= trim($match[2]);
			$name_to	= trim($match[1]);
		}

		if (!$email_from)
		{
			$email_from = $this->engine->db->noreply_email;
		}

		$name_from		= $this->engine->db->email_from;

		// in tls mode substitute protocol name in links substrings
		if ($this->engine->db->tls && !$supress_tls)
		{
			$body = str_replace('http://', 'https://' . ($this->engine->db->tls_proxy ? $this->engine->db->tls_proxy . '/' : ''), $body);
		}

		// use PHPMailer class
		if ($this->engine->db->phpmailer)
		{
			// $this->engine->db->phpMailer_method
			$this->php_mailer($email_to, $name_to, $email_from, $name_from, $subject, $body, $charset, $xtra_headers);
		}
		else
		{
			// use PHP mail() function
			$header = [];
			$header[] = 'From: =?' . $charset . "?B?" . base64_encode($this->engine->db->site_name) . "?= <" . $this->engine->db->noreply_email;
			$header[] = 'X-Mailer: PHP/' . phpversion(); // mailer
			$header[] = 'X-Priority: 3'; // 1 urgent, 3 normal
			$header[] = 'X-Wacko: ' . $this->engine->db->base_url;
			$header[] = 'Content-Type: text/plain; charset=' . $charset;

			foreach ($xtra_headers as $name => $value)
			{
				$header[] = $name . ': ' . $value;
			}

			$headers	= implode("\r\n", $header);
			$subject	= ($subject ? "=?".$charset . "?B?" . base64_encode($subject) . "?=" : '');
			$body		= wordwrap($body, 74, "\n", 0);

			@mail($email_to, $subject, $body, $headers);
		}
	}

	function php_mailer($email_to, $name_to, $email_from, $name_from, $subject, $body, $charset = '', $xtra_headers = '')
	{
		require_once 'lib/phpmailer/PHPMailerAutoload.php';

		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

		$mail->SetLanguage($this->engine->db->language, 'language/');

		// Select the method to send mail
		switch ($this->engine->db->phpmailer_method)
		{
			case 'mail':
				$mail->IsMail();
				break;

			case 'sendmail':
				$mail->IsSendmail();
				break;

			case 'smtp':
				$mail->IsSMTP();

				// SMTP collection is always kept alive
				# $mail->SMTPKeepAlive = true;

				// Enable SMTP debugging
				// 0 = off (for production use)
				// 1 = client messages
				// 2 = client and server messages
				 $mail->SMTPDebug	= 2;	// enables SMTP debug information (for testing)

				if (!$this->is_blank($this->engine->db->smtp_username))
				{
					// Use SMTP Authentication
					$mail->SMTPAuth = true;
					$mail->Username = $this->engine->db->smtp_username;
					$mail->Password = $this->engine->db->smtp_password;
				}

				if (!$this->is_blank($this->engine->db->smtp_connection_mode))
				{
					$mail->SMTPSecure = $this->engine->db->smtp_connection_mode;
				}

				if ($this->engine->db->smtp_auto_tls)
				{
					$mail->SMTPAutoTLS = true;
				}

				$mail->Port = $this->engine->db->smtp_port;

				break;
		}

		try
		{
			$mail->Host			= $this->engine->db->smtp_host;		// SMTP server

			$mail->AddCustomHeader('X-Wacko: ' . $this->engine->db->base_url);

			# $mail->Sender		= $this->engine->db->abuse_email;
			# $mail->AddReplyTo('name@example.com', 'First Last');
			$mail->SetFrom($email_from, $name_from);
			$mail->AddAddress($email_to, $name_to);
			# $mail->AddBCC($email_to, $name_to);

			$mail->IsHTML(false);		// set email format to plain
			$mail->ContentType	= 'text/plain';
			$mail->WordWrap		= 80;
			$mail->Priority		= $this->engine->db->email_priority;	// Urgent = 1, Not Urgent = 5, Disable = 0
			$mail->CharSet		= $charset;

			$mail->Subject		= $subject;
			$mail->Body			= $body;

			if (isset($xtra_headers) && is_array($xtra_headers))
			{
				foreach ($xtra_headers as $key => $value)
				{
					if (!strcasecmp($key, 'Message-ID'))
					{
						$mail->MessageID = $value;
					}
					else
					{
						$mail->AddCustomHeader( "$key: $value" );
					}
				}
			}

			$mail->Send();

			/*if (!$mail->Send())
			{
				$message = "Mailer Error: " . $mail->ErrorInfo;
				$this->log(1, $message);
				exit;
			}*/

			$send_ok = true;
		}

		catch (phpmailerException $e)
		{
			echo $e->errorMessage(); //Pretty error messages from PHPMailer
			$send_ok = false;
		}

		catch (Exception $e)
		{
			echo $e->getMessage(); //Boring error messages from anything else!
			$send_ok = false;
		}
		// end

		return $send_ok;
	}

	// checks if the parameter is an empty string or a string containing only whitespace
	function is_blank($str)
	{
		return ctype_space($str) || $str === '';
	}

}
