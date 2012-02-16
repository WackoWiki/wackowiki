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

	if (isset($_POST['recovery_password']) && !empty($_POST['recovery_password']))
	{
		// passing vars from user input
		$user_name		= $this->get_user_name();
		$password		= $_POST['recovery_password'];
		$confpassword	= $_POST['confpassword'];
		$lang			= (isset($_POST['lang']) ? $_POST['lang'] : '');
		#$timezone		= trim($_POST['timezone']);
		$complexity		= $this->password_complexity($user_name, $password);

		// confirmed password mismatch
		if ($confpassword != $password)
		{
			$error .= $this->get_translation('PasswordsDidntMatch')." ";
		}
		// spaces in password
		else if (preg_match('/ /', $password))
		{
			$error .= $this->get_translation('SpacesArentAllowed')." ";
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
			echo '<div class="notice">';
			echo '\'recovery_password\' => \''.hash('sha256', $this->config['system_seed'].$password).'\','."<br /><br />";
			echo '</div>';
		}
	}

	if ($error)
	{
		$this->set_message($this->format($error));
	}

	echo '<h2>Generate the pasword hash for your recovery_password </h2>';

	echo $this->form_open('', '', 'post');

	echo '<p><label for="password">'.$this->get_translation('RegistrationPassword').':</label>';
	echo '<input type="password" id="recovery_password" name="recovery_password" size="24" value="'.$password.'" />';

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
	echo '</p>';

	echo '<p><label for="confpassword">'.$this->get_translation('ConfirmPassword').':</label>';
	echo '<input type="password" id="confpassword" name="confpassword" size="24" value="'.$confpassword.'" /></p>';

	?>
	<input name="preview" type="submit" value="<?php echo $this->get_translation('CreatePageButton'); ?>" />
	<?php

	echo $this->form_close();
}

?>