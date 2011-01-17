<?php

/*

########################################################
##              Email Constructor                     ##
########################################################

*/

class Email
{
	// VARIABLES
	var $engine;
	var $charset;

	// CONSTRUCTOR
	function __construct(&$engine)
	{
		$this->engine = & $engine;
		$this->engine->load_translation($this->engine->config['language']);
		$this->charset = $this->engine->languages[$this->engine->config['language']]['charset'];
	}

	function php_mailer($email_to, $name_to, $email_from, $name_from, $subject, $body, $charset = '', $xtra_headers = '')
	{
		$this->engine->use_class('PHPMailer', 'lib/phpmailer/', 'class.phpmailer');

		$mail = new PHPMailer(true); // the true param means it will throw exceptions on errors, which we need to catch

		$mail->SetLanguage($this->engine->config['language'], 'language/');

		// Select the method to send mail
		switch( $this->engine->config['phpmailer_method'] )
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

				if ( !$this->engine->is_blank( $this->engine->config['smtp_username'] ) )
				{
					// Use SMTP Authentication
					$mail->SMTPAuth = true;
					$mail->Username = $this->engine->config['smtp_username'];
					$mail->Password = $this->engine->config['smtp_password'];
				}

				if ( !$this->engine->is_blank( $this->engine->config['smtp_connection_mode'] ) )
				{
					$mail->SMTPSecure = $this->engine->config['smtp_connection_mode'];
				}

				$mail->Port = $this->engine->config['smtp_port'];

				break;
		}

		try
		{
			$mail->Host			= $this->engine->config['smtp_host'];		// SMTP server

			$mail->AddCustomHeader( "X-Wacko: ".$this->engine->config['base_url']."" );

			#$mail->Sender		= $this->engine->config['abuse_email'];
			#$mail->AddReplyTo('name@yourdomain.com', 'First Last');
			$mail->SetFrom($email_from, $name_from);
			$mail->AddAddress($email_to, $name_to);

			$mail->IsHTML(false);		// set email format to HTML
			$mail->ContentType	= 'text/plain';
			$mail->WordWrap		= 80;
			$mail->Priority		= $this->engine->config['email_priority'];	// Urgent = 1, Not Urgent = 5, Disable = 0
			$mail->CharSet		= $charset;

			$mail->Subject		= $subject;
			$mail->Body			= $body;

			if( isset( $xtra_headers ) && is_array( $xtra_headers ) )
			{
				foreach( $xtra_headers as $key => $value )
				{
					$mail->AddCustomHeader( "$key: $value" );
				}
			}

			$mail->Send();

			/*if(!$mail->Send())
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

}

?>