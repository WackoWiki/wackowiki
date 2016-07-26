<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// generates the hash for a new recovery_password
// {{admin_recovery}}
// 'recovery_password' => 'add hash here',

if ($this->is_admin())
{
	$error			= '';

	if (@$_POST['_action'] === 'generate_hash')
	{
		// passing vars from user input
		$user_name		= $this->get_user_name();
		$tpl->password =
		$password		= $_POST['recovery_password'];
		$tpl->confpassword =
		$confpassword	= $_POST['confpassword'];
		$complexity		= $this->password_complexity($user_name, $password);

		// confirmed password mismatch
		if ($confpassword != $password)
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
			$password_hashed	= $this->config['system_seed'] . $password;

			$tpl->generated_hash = password_hash(
					base64_encode(
							hash('sha256', $password_hashed, true)
							),
					PASSWORD_DEFAULT
					);
		}
	}

	if ($error)
	{
		$this->set_message($this->format($error), 'error');
	}

	$tpl->href = $this->href();

	$tpl->complexity = $this->show_password_complexity();
}
