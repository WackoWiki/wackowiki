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
				#$mail->SMTPKeepAlive = true;

				#$mail->SMTPDebug	= false;	// enables SMTP debug information (for testing)

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

				$mail->Port = $this->engine->db->smtp_port;

				break;
		}

		try
		{
			$mail->Host			= $this->engine->db->smtp_host;		// SMTP server

			$mail->AddCustomHeader('X-Wacko: '.$this->engine->db->base_url.'');

			#$mail->Sender		= $this->engine->db->abuse_email;
			#$mail->AddReplyTo('name@example.com', 'First Last');
			$mail->SetFrom($email_from, $name_from);
			$mail->AddAddress($email_to, $name_to);
			#$mail->AddBCC($email_to, $name_to);

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
