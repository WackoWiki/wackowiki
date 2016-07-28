<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo "<!--notypo-->\n";
$include_tail = "<!--/notypo-->\n";

$this->no_way_back = true; // prevent goback'ing that page

// reconnect securely in tls mode
$this->http->ensure_tls($this->href());

// get secret_code from _GET from user-supplied link, or from _POST from our reset_password form
if (($code = @$_REQUEST['secret_code']))
{
	// Password forgotten. Provided secret code

	$user = $this->db->load_single(
		"SELECT user_id, user_name ".
		"FROM ".$this->db->user_table." ".
		"WHERE change_password = ".$this->db->q(hash_hmac('sha256', $code, $this->db->system_seed))." ".
		"LIMIT 1");

	if ($user)
	{
		if (@$_POST['_action'] === 'reset_password')
		{
			// Password forgotten. Provided secret code and new password. Change password.
			$new_password	= $_POST['new_password'];
			$conf_password	= $_POST['conf_password'];

			// check all conditions
			$complexity		= $this->password_complexity($user['user_name'], $new_password);

			// confirmed password mismatch
			if ($conf_password !== $new_password)
			{
				$error = $this->_t('PasswordsDidntMatch');
			}
			// password complexity validation
			else if ($complexity)
			{
				$error = $complexity;
			}
			else
			{
				$this->db->sql_query(
					"UPDATE ".$this->config['user_table']." SET ".
						"password			= ".$this->db->q($this->password_hash($user, $new_password)).", ".
						"change_password	= '' ".
					"WHERE user_id = '".$user['user_id']."' ".
					"LIMIT 1");

				// log event
				$this->log(3, Ut::perc_replace($this->_t('LogUserPasswordRecovered', SYSTEM_LANG), $user['user_name']));

				// forward
				$this->set_message($this->_t('PasswordChanged'), 'success');
				$this->login_page();
				// NEVER BEEN HERE
			}

			$this->set_message($error, 'error');
		}
		else
		{
			// Password forgotten. Provided secret code only. Show password change form.
			echo $this->form_open('reset_password');
			echo '<input type="hidden" name="secret_code" value="'.$code.'" />';
			?>

			<div class="cssform">
				<h3><?php echo $this->format(Ut::perc_replace($this->_t('YouWantChangePasswordForUser'), $user['user_name'])); ?></h3>
				<p>
					<label for="new_password"><?php echo $this->_t('NewPassword');?>:</label>
					<input type="password" id="new_password" name="new_password" size="24" />
				</p>
				<p>
					<label for="conf_password"><?php echo $this->_t('ConfirmPassword');?>:</label>
					<input type="password" id="conf_password" name="conf_password" size="24" />
					<?php
					echo $this->show_password_complexity();
					?>
				</p>
				<p>
				<input type="submit" class="OkBtn" value="<?php echo $this->_t('RegistrationButton'); ?>" />
				</p>
			</div>
			<?php
			echo $this->form_close();
		}
	}
	else
	{
		echo $this->set_message($this->_t('WrongCode'), 'error');
	}
}
else if (($user = $this->get_user()))
{
	// user logged in: change password
	if (@$_POST['_action'] === 'change_password')
	{
		// simple change password
		$password		= $_POST['password'];
		$new_password	= $_POST['new_password'];
		$conf_password	= $_POST['conf_password'];

		// check all conditions
		$complexity		= $this->password_complexity($user['user_name'], $new_password);

		// wrong current password
		if (!$this->password_verify($user, $password))
		{
			$this->log_user_delay();
			$error = $this->_t('WrongPassword');
			// log event
			$this->log(3, Ut::perc_replace($this->_t('LogUserPasswordMismatch', SYSTEM_LANG), $user['user_name']));
		}
		// confirmed password mismatch
		else if ($conf_password != $new_password)
		{
			$error = $this->_t('PasswordsDidntMatch');
		}
		// password complexity validation
		else if ($complexity)
		{
			$error = $complexity;
		}
		else
		{
			// store new password
			$this->db->sql_query(
				"UPDATE ".$this->config['user_table']." SET ".
					"change_password	= '', ".
					"password = ".$this->db->q($this->password_hash($user, $new_password))." ".
				"WHERE user_id = '".$user['user_id']."' ".
				"LIMIT 1");

			// reinitialize user session
			$this->log_user_out();
			$this->set_menu(MENU_DEFAULT);
			$this->context[++$this->current_context] = '';

			// log event
			$this->log(3, Ut::perc_replace($this->_t('LogUserPasswordChanged', SYSTEM_LANG), $user['user_name']));

			// forward
			$this->set_message($this->_t('PasswordChanged'), 'success');
			$this->login_page();
			// NEVER BEEN HERE
		}

		$this->set_message($this->format($error), 'error');
	}

	// print simple change password form
	echo $this->form_open('change_password');

	?>
	<div class="cssform">
		<h3><?php echo $this->format_t('YouWantChangePassword'); ?></h3>
		<p>
			<label for="password"><?php echo $this->_t('CurrentPassword');?>:</label>
			<input type="password" id="password" name="password" size="24" />
		</p>
		<p>
			<label for="new_password"><?php echo $this->_t('NewPassword');?>:</label>
			<input type="password" id="new_password" name="new_password" size="24" />
			<?php
			echo $this->show_password_complexity();
			?>
		</p>
		<p>
			<label for="conf_password"><?php echo $this->_t('ConfirmPassword');?>:</label>
			<input type="password" id="conf_password" name="conf_password" size="24" />
		</p>
		<p>
			<input type="submit" class="OkBtn" value="<?php echo $this->_t('RegistrationButton'); ?>" />
		</p>
	</div>
<?php
	echo $this->form_close();
}
else
{
	// guest user, password forgotten, send mail
	if (@$_POST['_action'] === 'forgot_password')
	{
		$user_name	= Ut::strip_spaces($_POST['user_name']);
		$email		= Ut::strip_spaces($_POST['email']);
		$user		= $this->db->load_single(
						"SELECT u.user_id, u.user_name, u.email, u.email_confirm, s.user_lang ".
						"FROM ".$this->config['user_table']." u ".
							"LEFT JOIN ".$this->config['table_prefix']."user_setting s ON (u.user_id = s.user_id) ".
						"WHERE u.user_name = ".$this->db->q($user_name)." ".
							"AND u.email = ".$this->db->q($email)." ".
						"LIMIT 1");

		if ($user)
		{
			if ($this->db->enable_email && !$user['email_confirm'])
			{
				$code		= Ut::random_token(21);
				$code_hash	= hash_hmac('sha256', $code, $this->db->system_seed);

				$save = $this->set_language($user['user_lang'], true);
				$subject	=	$this->_t('EmailForgotSubject') . $this->config['site_name'];
				$body		=	Ut::perc_replace($this->_t('EmailForgotMessage'),
									$this->config['site_name'],
									$user['user_name'],
									$this->href('', '', 'secret_code=' . $code)) . "\n\n";

				// update table
				$this->db->sql_query(
					"UPDATE {$this->db->user_table} SET ".
						"lost_password_request_count = lost_password_request_count + 1, ". // value unused
						"change_password = ".$this->db->q($code_hash)." ".
					"WHERE user_id = '".(int)$user['user_id']."' ".
					"LIMIT 1");

				// send code
				$this->send_user_email($user_name, $user['email'], $subject, $body, $user['user_lang']);
				$this->set_language($save, true);

				// log event
				$this->log(3, Ut::perc_replace($this->_t('LogUserPasswordReminded', SYSTEM_LANG), $user['user_name'], $user['email']));

				$this->set_message($this->_t('CodeWasSent'), 'success');
				$this->http->redirect($this->href('', $this->_t('LoginPage')));
				// NEVER BEEN HERE
			}
			else
			{
				$error = $this->_t('NotConfirmedEmail');
			}
		}
		else
		{
			$error = $this->_t('UserNotFound');
		}

		$this->set_message($error, 'error');
	}

	// view password forgot form

	// view password forgot form
	echo $this->form_open('forgot_password');
?>

	<h3><?php echo $this->format_t('ForgotPassword'); ?></h3>
	<p><?php echo $this->format_t('ForgotPasswordHint'); ?></p>
	<div class="cssform">
	<p>
		<label for="user_name"><?php echo $this->format_t('UserName'); ?>:</label>
		<input type="text" id="user_name" name="user_name" size="25" maxlength="80" /><br />
		<label for="email"><?php echo $this->format_t('Email'); ?>:</label>
		<input type="text" id="email" name="email" size="24" />
	</p>
	<p>
		<input type="submit" class="OkBtn" value="<?php echo $this->_t('SendButton'); ?>" />
	</p>
	</div>
	<?php
	echo $this->form_close();
}
