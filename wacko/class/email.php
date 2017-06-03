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
	//
	// $email_to			- recipient address
	// $name_to				- recipient name
	// $subject, $message	- self-explaining
	// $email_from			- place specific address into the 'From:' field
	// $charset				- send message in specific charset (w/o actual re-encoding)
	// $xtra_headers		- (array) insert additional mail headers
	function send_mail($email_to, $name_to, $subject, $body, $email_from = '', $charset = '', $xtra_headers = [])
	{
		if (!$this->engine->db->enable_email || ( !$email_to || !$subject || !$body) )
		{
			return;
		}

		if (empty($charset))
		{
			$charset = $this->engine->get_charset();
		}

		if (!$email_from)
		{
			$email_from = $this->engine->db->noreply_email;
		}

		$name_from		= $this->engine->db->email_from;

		// use PHPMailer class
		$this->php_mailer($email_to, $name_to, $email_from, $name_from, $subject, $body, $charset, $xtra_headers);
	}

	function php_mailer($email_to, $name_to, $email_from, $name_from, $subject, $body, $charset = '', $xtra_headers = '')
	{
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
				# $mail->SMTPDebug	= 2;	// enables SMTP debug information (for testing)

				if (!Ut::is_blank($this->engine->db->smtp_username))
				{
					// Use SMTP Authentication
					$mail->SMTPAuth = true;
					$mail->Username = $this->engine->db->smtp_username;
					$mail->Password = $this->engine->db->smtp_password;
				}

				if (!Ut::is_blank($this->engine->db->smtp_connection_mode))
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
			$mail->Host			= $this->engine->db->smtp_host;			// SMTP server

			$mail->AddCustomHeader('X-Wacko: ' . $this->engine->db->base_url);
			$mail->AddCustomHeader('Auto-Submitted: auto-generated');	// RFC3834
			$mail->AddCustomHeader('X-Auto-Response-Suppress: All');	// Microsoft Exchange

			# $mail->Sender		= $this->engine->db->abuse_email;		// 'return-path' header
			# $mail->AddReplyTo('name@example.com', 'First Last');		//
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

			/* if (!$mail->Send())
			{
				$message = "Mailer Error: " . $mail->ErrorInfo;
				$this->engine->log(4, $message);
				exit;
			}
			else
			{
				$message = "Message has been sent.";
				$this->engine->log(5, $message);
			} */

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
}
