<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$error = '';

?>
<!--notypo-->
<?php

// reconnect securely in tls mode
if ($this->config['tls'] == true && ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'on' && empty($this->config['tls_proxy'])) || $_SERVER['SERVER_PORT'] != '443' ))
{
	$this->redirect(str_replace('http://', 'https://'.($this->config['tls_proxy'] ? $this->config['tls_proxy'].'/' : ''), $this->href()));
}

if (isset($_GET['secret_code']) || isset($_POST['secret_code']))
{
	// Password forgotten. Provided secret code
	if (isset($_GET['secret_code']))
	{
		$code = $_GET['secret_code'];
	}
	elseif (isset($_POST['secret_code']))
	{
		$code = $_POST['secret_code'];
	}

	$user = $this->load_single(
		"SELECT user_id, user_name ".
		"FROM ".$this->config['user_table']." ".
		"WHERE change_password='".quote($this->dblink, $code)."' ".
		"LIMIT 1");

	if ($user)
	{
		if (isset($_POST['newpassword']))
		{
			//Password forgotten. Provided secret code and new password. Change password.
			$new_password	= $_POST['newpassword'];
			$conf_password	= $_POST['confpassword'];

			// check all conditions
			$complexity		= $this->password_complexity($user['user_name'], $new_password);

			// confirmed password mismatch
			if ($conf_password != $new_password)
			{
				$error = $this->get_translation('PasswordsDidntMatch');
			}
			// spaces in password
			else if (preg_match('/ /', $new_password))
			{
				$error = $this->get_translation('SpacesArentAllowed');
			}
			// password complexity validation
			else if ($complexity > 0)
			{
				if ($complexity >= 5)
				{
					$error .= $this->get_translation('PwdCplxWeak')." ";
					$complexity -= 5;
				}
				if ($complexity >= 2)
				{
					$error .= $this->get_translation('PwdCplxShort')." ";
					$complexity -= 2;
				}
				if ($complexity >= 1)
				{
					$error .= $this->get_translation('PwdCplxEquals')." ";
					$complexity -= 1;
				}
			}
			else
			{
				$salt_length		= 10;
				$salt				= $this->random_password($salt_length, 3);
				$password_encrypted	= hash('sha256', $user['user_name'].$salt.$new_password);

				$this->sql_query(
					"UPDATE ".$this->config['user_table']." SET ".
						"password			= '".quote($this->dblink, $password_encrypted)."', ".
						"salt				= '".quote($this->dblink, $salt)."', ".
						"change_password	= '' ".
					"WHERE user_id = '".quote($this->dblink, $user['user_id'])."' ".
					"LIMIT 1");

				// log event
				$this->log(3, str_replace('%1', $user['user_name'], $this->get_translation('LogUserPasswordRecovered', $this->config['language'])));

				// forward
				$this->set_message($this->get_translation('PasswordChanged'));
				$this->redirect($this->href('', $this->get_translation('LoginPage'), 'cache='.rand(0,1000)));
			}

			if ($error)
			{
				$this->set_message($error);
			}
		}
		else
		{
			//Password forgotten. Provided secret code only. Print password change form.
			echo $this->form_open();
			echo "<input type=\"hidden\" name=\"secret_code\" value=\"".$code."\" />";
			?>

			<div class="cssform">
				<h3><?php echo $this->format( str_replace('%1', $user['user_name'], $this->get_translation('YouWantChangePasswordForUser'))); ?></h3>
				<p>
					<label for="newpassword"><?php echo $this->get_translation('NewPassword');?>:</label>
					<input type="password" id="newpassword" name="newpassword" size="24" />
				</p>
				<p>
					<label for="confpassword"><?php echo $this->get_translation('ConfirmPassword');?>:</label>
					<input type="password" id="confpassword" name="confpassword" size="24" />
					<?php
					if ($this->config['pwd_char_classes'] > 0)
					{
						$pwd_cplx_text = $this->get_translation('PwdCplxDesc4');

						if ($this->config['pwd_char_classes'] == 1)
						{
							$pwd_cplx_text .= $this->get_translation('PwdCplxDesc41');
						}
						else if ($this->config['pwd_char_classes'] == 2)
						{
							$pwd_cplx_text .= $this->get_translation('PwdCplxDesc42');
						}
						else if ($this->config['pwd_char_classes'] == 3)
						{
							$pwd_cplx_text .= $this->get_translation('PwdCplxDesc43');
						}

						$pwd_cplx_text .= ". ".$this->get_translation('PwdCplxDesc5');
					}

					echo "<br /><small>".
						 $this->get_translation('PwdCplxDesc1').
						 str_replace('%1', $this->config['pwd_min_chars'],
							$this->get_translation('PwdCplxDesc2')).
						 ($this->config['pwd_unlike_login'] > 0
							? ", ".$this->get_translation('PwdCplxDesc3')
							: "").
						 ($this->config['pwd_char_classes'] > 0
							? ", ".$pwd_cplx_text
							: "")."</small>";
					?>
				</p>
				<p>
				<input class="OkBtn" type="submit" value="<?php echo $this->get_translation('RegistrationButton'); ?>" />
				</p>
			</div>
			<?php
			echo $this->form_close();
		}
	}
	else
	{
		echo $this->set_message($this->get_translation('WrongCode'));
	}
}
// is user trying to update?
else if (!isset($forgot) && $user = $this->get_user())
{
	// is user trying to update?
	if (isset($_POST['action']) && $_POST['action'] == 'change')
	{
		//Simple change password
		$password		= $_POST['password'];
		$new_password	= $_POST['newpassword'];
		$conf_password	= $_POST['confpassword'];

		// check all conditions
		$complexity		= $this->password_complexity($user['user_name'], $new_password);

		// wrong current password
		if (hash('sha256', $user['user_name'].$user['salt'].$password) != $user['password'])
		{
			$error = $this->get_translation('WrongPassword');
			// log event
			$this->log(3, str_replace('%1', $user['user_name'], $this->get_translation('LogUserPasswordMismatch', $this->config['language'])));
		}
		// confirmed password mismatch
		else if ($conf_password != $new_password)
		{
			$error = $this->get_translation('PasswordsDidntMatch');
		}
		// spaces in password
		else if (preg_match('/ /', $new_password))
		{
			$error = $this->get_translation('SpacesArentAllowed');
		}
		// password complexity validation
		else if ($complexity > 0)
		{
			if ($complexity >= 5)
			{
				$error .= $this->get_translation('PwdCplxWeak')." ";
				$complexity -= 5;
			}
			if ($complexity >= 2)
			{
				$error .= $this->get_translation('PwdCplxShort')." ";
				$complexity -= 2;
			}
			if ($complexity >= 1)
			{
				$error .= $this->get_translation('PwdCplxEquals')." ";
				$complexity -= 1;
			}
		}
		else
		{
			$salt_length		= 10;
			$salt				= $this->random_password($salt_length, 3);
			$password_encrypted	= hash('sha256', $user['user_name'].$salt.$new_password);

			// store new password
			$this->sql_query(
				"UPDATE ".$this->config['user_table']." SET ".
					"password			= '".quote($this->dblink, $password_encrypted)."', ".
					"salt				= '".quote($this->dblink, $salt)."' ".
				"WHERE user_id = '".quote($this->dblink, $user['user_id'])."' ".
				"LIMIT 1");

			// reinitialize user session
			$this->logout_user();
			$this->set_menu(MENU_DEFAULT);
			$this->context[++$this->current_context] = '';

			// log event
			$this->log(3, str_replace('%1', $user['user_name'], $this->get_translation('LogUserPasswordChanged', $this->config['language'])));

			// forward
			$this->set_message($this->get_translation('PasswordChanged'));
			$this->redirect($this->href('', $this->get_translation('LoginPage'), 'cache='.rand(0,1000)));
		}
	}

	//Print simple change password form
	echo $this->form_open();

	if (isset($error))
	{
		$this->set_message($this->format($error));
	}
	?>
	<input type="hidden" name="action" value="change" />
	<div class="cssform">
		<h3><?php echo $this->format_translation('YouWantChangePassword'); ?></h3>
		<p>
			<label for="password"><?php echo $this->get_translation('CurrentPassword');?>:</label>
			<input type="password" id="password" name="password" size="24" />
		</p>
		<p>
			<label for="newpassword"><?php echo $this->get_translation('NewPassword');?>:</label>
			<input type="password" id="newpassword" name="newpassword" size="24" />
			<?php
			if ($this->config['pwd_char_classes'] > 0)
			{
				$pwd_cplx_text = $this->get_translation('PwdCplxDesc4');

				if 		($this->config['pwd_char_classes'] == 1)
				{
					$pwd_cplx_text .= $this->get_translation('PwdCplxDesc41');
				}
				else if ($this->config['pwd_char_classes'] == 2)
				{
					$pwd_cplx_text .= $this->get_translation('PwdCplxDesc42');
				}
				else if ($this->config['pwd_char_classes'] == 3)
				{
					$pwd_cplx_text .= $this->get_translation('PwdCplxDesc43');
				}

				$pwd_cplx_text .= ". ".$this->get_translation('PwdCplxDesc5');
			}

			echo "<br /><small>".
				$this->get_translation('PwdCplxDesc1').
				str_replace('%1', $this->config['pwd_min_chars'],
					$this->get_translation('PwdCplxDesc2')).
				($this->config['pwd_unlike_login'] > 0
					? ", ".$this->get_translation('PwdCplxDesc3')
					: "").
				($this->config['pwd_char_classes'] > 0
					? ", ".$pwd_cplx_text
					: "")."</small>";
			?>
		</p>
		<p>
			<label for="confpassword"><?php echo $this->get_translation('ConfirmPassword');?>:</label>
			<input type="password" id="confpassword" name="confpassword" size="24" />
		</p>
		<p>
			<input class="OkBtn" type="submit" value="<?php echo $this->get_translation('RegistrationButton'); ?>" />
		</p>
	</div>
<?php
	echo $this->form_close();
}
//Password forgotten. Send mail
else
{
	if (isset($_POST['action']) && $_POST['action'] == 'send')
	{
		$user_name	= str_replace(' ', '', $_POST['user_name']);
		$email		= str_replace(' ', '', $_POST['email']);
		$user		= $this->load_single(
			"SELECT user_id, user_name, email, password, email_confirm ".
			"FROM ".$this->config['user_table']." ".
			"WHERE user_name = '".quote($this->dblink, $user_name)."' ".
				"AND email = '".quote($this->dblink, $email)."' ".
			"LIMIT 1");

		if ($user)
		{
			if ($this->config['enable_email'] == true && $user['email_confirm'] == '')
			{
				$code = hash('sha256', $user['password'].date("D d M Y H:i:s").$user['email'].mt_rand());

				$subject =	$this->get_translation('EmailForgotSubject').
							$this->config['site_name'];
				$body	=	$this->get_translation('EmailHello'). $user_name.".\n\n".
							str_replace('%1', $this->config['site_name'],
							str_replace('%2', $user['user_name'],
							str_replace('%3', $this->href().
							($this->config['rewrite_mode'] ? "?" : "&amp;")."secret_code=".$code,
							$this->get_translation('EmailForgotMessage'))))."\n";
				$body.=	"\n".$this->get_translation('EmailGoodbye').
							"\n".$this->config['site_name'].
							"\n".$this->config['base_url'];

				// update table
				$this->sql_query(
					"UPDATE ".$this->config['user_table']." SET ".
						"change_password = '".quote($this->dblink, $code)."' ".
					"WHERE user_name = '".quote($this->dblink, $user['user_name'])."' ".
					"LIMIT 1");

				// send code
				$this->send_mail($user['email'], $subject, $body);

				// count attempt
				$this->set_lost_password_count($user['user_id']);

				// log event
				$this->log(3, str_replace('%2', $user['email'], str_replace('%1', $user['user_name'], $this->get_translation('LogUserPasswordReminded', $this->config['language']))));

				$this->set_message($this->get_translation('CodeWasSent'));
				$this->redirect($this->href('', $this->get_translation('LoginPage')));

			}
			else
			{
				$error = $this->get_translation('NotConfirmedEmail');
			}
		}
		else
		{
			$error = $this->get_translation('UserNotFound');
		}
	}

	// View password forgot form
	if (isset($error) || (isset($_POST['action']) && $_POST['action'] != 'send') || (!isset($_POST['action'])) )
	{
		if (isset($error))
		{
			$this->set_message($error);
		}

		//View password forgot form
		echo $this->form_open();
?>
		<input type="hidden" name="action" value="send" />

		<h3><?php echo $this->format_translation('ForgotMain'); ?></h3>
		<p><?php echo $this->format_translation('ForgotComment'); ?></p>
		<div class="cssform">
		<p>
			<label for="user_name"><?php echo $this->format_translation('UserName'); ?>:</label>
			<input type="text" id="user_name" name="user_name" size="24" /><br />
			<label for="email"><?php echo $this->format_translation('Email'); ?>:</label>
			<input type="text" id="email" name="email" size="24" />
		</p>
		<p>
			<input class="OkBtn" type="submit" value="<?php echo $this->get_translation('SendButton'); ?>" />
		</p>
		</div>
		<?php
		echo $this->form_close();
	}
}

?>
<!--/notypo-->