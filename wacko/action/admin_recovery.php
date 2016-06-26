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
	$output			= '';
	$error			= '';
	$password		= '';
	$confpassword	= '';

	if (isset($_POST['recovery_password']) && !empty($_POST['recovery_password']))
	{
		// passing vars from user input
		$user_name		= $this->get_user_name();
		$password		= $_POST['recovery_password'];
		$confpassword	= $_POST['confpassword'];
		#$lang			= (isset($_POST['user_lang']) ? $_POST['user_lang'] : '');
		#$timezone		= trim($_POST['timezone']);
		$complexity		= $this->password_complexity($user_name, $password);

		// confirmed password mismatch
		if ($confpassword != $password)
		{
			$error .= $this->get_translation('PasswordsDidntMatch').' ';
		}
		// password complexity validation
		else if ($complexity)
		{
			$error .= $complexity;
		}
		else
		{
			$password_hashed	= $this->config['system_seed'].$password;
			$password_hashed	= password_hash(
					base64_encode(
							hash('sha256', $password_hashed, true)
							),
					PASSWORD_DEFAULT
					);

			echo '<div class="notice">';
			echo '\'recovery_password\' => \''.$password_hashed.'\','.'<br /><br />';
			echo '</div>';
		}
	}

	if ($error)
	{
		$message = $this->format($error);
		$this->set_message($message, 'error');
	}

	echo '<h2>Generate the password hash for your recovery_password</h2>';

	echo $this->form_open('generate_hash', '', 'post');

	echo '<p><label for="password">'.$this->get_translation('RegistrationPassword').':</label>';
	echo '<input type="password" id="recovery_password" name="recovery_password" size="24" value="'.$password.'" />';

	echo $this->show_password_complexity();
	echo '</p>';

	echo '<p><label for="confpassword">'.$this->get_translation('ConfirmPassword').':</label>';
	echo '<input type="password" id="confpassword" name="confpassword" size="24" value="'.$confpassword.'" /></p>';

	?>
	<input type="submit" name="preview" value="<?php echo $this->get_translation('CreatePageButton'); ?>" />
	<?php

	echo $this->form_close();
}

?>
