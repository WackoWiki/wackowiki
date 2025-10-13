<?php

if (!defined('IN_WACKO'))
{
	exit('No direct script access allowed');
}

// Import the PHPMailer class into the global namespace
use PHPMailer\ {
	PHPMailer\PHPMailer,
	PHPMailer\Exception
};

class Email
{
	// VARIABLES
	public $engine;

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
	// $xtra_headers		- (array) insert additional mail headers
	function send_mail($email_to, $name_to, $subject, $body, $email_from = '', $xtra_headers = []): void
	{
		if (!$this->engine->db->enable_email || ( !$email_to || !$subject || !$body) )
		{
			return;
		}

		if (!$email_from)
		{
			$email_from = $this->engine->db->noreply_email;
		}

		$name_from		= $this->engine->db->email_from;

		// use PHPMailer class
		$this->php_mailer($email_to, $name_to, $email_from, $name_from, $subject, $body, $xtra_headers);
	}

	function php_mailer($email_to, $name_to, $email_from, $name_from, $subject, $body, $xtra_headers = ''): bool
	{
		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

		$mail->setLanguage($this->engine->db->language, 'language/');

		// Select the method to send mail
		switch ($this->engine->db->phpmailer_method)
		{
			case 'mail':
				$mail->isMail();
				break;

			case 'sendmail':
				$mail->isSendmail();
				break;

			case 'smtp':
				$mail->isSMTP();

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

			$mail->addCustomHeader('X-Wacko: ' . $this->engine->db->base_url);
			$mail->addCustomHeader('Auto-Submitted: auto-generated');	// RFC3834
			$mail->addCustomHeader('X-Auto-Response-Suppress: All');	// Microsoft Exchange

			if(!empty($this->engine->db->abuse_email))
			{
				$mail->Sender		= $this->engine->db->abuse_email;	// 'return-path' header
			}

			# $mail->addReplyTo('name@example.com', 'First Last');		//
			$mail->setFrom($email_from, $name_from);
			$mail->addAddress($email_to, $name_to);
			# $mail->addBCC($email_to, $name_to);

			$mail->isHTML(false);										// set email format to plain
			$mail->ContentType	= 'text/plain';
			$mail->WordWrap		= 80;
			$mail->Priority		= $this->engine->db->email_priority;	// Urgent = 1, Not Urgent = 5, Disable = 0
			$mail->CharSet		= 'utf-8';

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
						$mail->addCustomHeader( "$key: $value" );
					}
				}
			}

			$mail->send();

			$send_ok = true;
		}

		catch (Exception $e)
		{
			echo $e->errorMessage(); // Pretty error messages from PHPMailer
			$send_ok = false;
		}

		return $send_ok;
	}
}
