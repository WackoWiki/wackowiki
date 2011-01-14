<!--notypo-->
<?php

$user_name		= '';
$email			= '';
$password		= '';
$confpassword	= '';
$error			= '';
$word_ok		= '';

// reconnect securely in tls mode
if ($this->config['tls'] == true && ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'on' && empty($this->config['tls_proxy'])) || $_SERVER['SERVER_PORT'] != '443' ))
{
	$this->redirect(str_replace('http://', 'https://'.($this->config['tls_proxy'] ? $this->config['tls_proxy'].'/' : ''), $this->href()));
}

// is user trying to confirm email, login or register?
if (isset($_GET['confirm']))
{
	if ($temp = $this->load_single(
		"SELECT user_name, email, email_confirm ".
		"FROM ".$this->config['user_table']." ".
		"WHERE email_confirm = '".quote($this->dblink, $_GET['confirm'])."'"))
	{
		$this->query(
			"UPDATE ".$this->config['user_table']." ".
			"SET email_confirm = '' ".
			"WHERE email_confirm = '".quote($this->dblink, $_GET['confirm'])."'");

		echo "<div class=\"info\">".$this->get_translation('EmailConfirmed')."</div><br />";

		// log event
		$this->log(4, str_replace('%2', $temp['user_name'], str_replace('%1', $temp['email'], $this->get_translation('LogUserEmailActivated', $this->config['language']))));

		unset($temp);
	}
	else
	{
		echo "<div class=\"info\">".str_replace('%1', $this->compose_link_to_page('Settings', '', $this->get_translation('SettingsText'), 0), $this->get_translation('EmailNotConfirmed'))."</div><br />";
	}
}
else if (isset($_POST['action']) && $_POST['action'] == 'login')
{
	// create new account if possible
	if ($this->config['allow_registration'] || $this->is_admin())
	{
		// passing vars from user input
		$user_name		= trim($_POST['name']);
		$email			= trim($_POST['email']);
		$password		= $_POST['password'];
		$confpassword	= $_POST['confpassword'];
		$lang			= $_POST['lang'];
		$complexity		= $this->password_complexity($user_name, $password);

		// Start Registration Captcha

		// Only show captcha if the admin enabled it in the config file
		if(!$this->is_admin() && $this->config['captcha_registration'])
		{
			// Don't load the captcha at all if the GD extension isn't enabled
			if (extension_loaded('gd'))
			{
				// check whether anonymous user
				// anonymous user has no name
				// if false, we assume it's anonymous
				if ($this->get_user_name() == false)
				{
					//anonymous user, check the captcha
					if (!empty($_SESSION['freecap_word_hash']) && !empty($_POST['word']))
					{
						if ($_SESSION['hash_func'](strtolower($_POST['word'])) == $_SESSION['freecap_word_hash'])
						{
							// reset freecap session vars
							// cannot stress enough how important it is to do this
							// defeats re-use of known image with spoofed session id
							$_SESSION['freecap_attempts'] = 0;
							$_SESSION['freecap_word_hash'] = false;

							// now process form
							$word_ok = true;
						}
						else
						{
							$word_ok = false;
						}
					}
					else
					{
						$word_ok = false;
					}

					if (!$word_ok)
					{
						//not the right word
						$error = $this->get_translation('SpamAlert');
						$this->set_message($this->get_translation('SpamAlert'));
					}
				}
			}
		}
		// End Comment Captcha

		if (($word_ok) || $this->is_admin() || !$this->config['captcha_registration'])
		{
			// check if name is WikiName style
			if (!$this->is_wiki_name($user_name))
			{
				$error .= $this->get_translation('MustBeWikiName')." ";
			}
			// if user name already exists
			else if ($this->user_name_exists($user_name) === true)
			{
				$error .= $this->get_translation('RegistrationNameOwned');

				// log event
				$this->log(2, str_replace('%1', $user_name, $this->get_translation('LogUserSimiliarName', $this->config['language'])));
			}
			// no email given
			else if ($email == '')
			{
				$error .= $this->get_translation('SpecifyEmail')." ";
			}
			// invalid email
			else if (!preg_match('/^.+?\@.+$/', $email))
			{
				$error .= $this->get_translation('NotAEmail')." ";
			}
			// confirmed password mismatch
			else if ($confpassword != $password)
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

			// submitting input to DB
			else
			{
				$salt_length = 10;
				$salt = $this->random_password($salt_length, 3);
				$confirm = hash('sha256', $password.$salt.mt_rand().time().mt_rand().$email.mt_rand());
				$password_encrypted = hash('sha256', $user_name.$salt.$_POST['password']);

				// INSERT USER
				$this->query(
					"INSERT INTO ".$this->config['user_table']." ".
					"SET ".
						"signup_time	= NOW(), ".
						"user_name		= '".quote($this->dblink, $user_name)."', ".
						"email			= '".quote($this->dblink, $email)."', ".
						"email_confirm	= '".quote($this->dblink, $confirm)."', ".
						"password		= '".quote($this->dblink, $password_encrypted)."', ".
						"salt			= '".quote($this->dblink, $salt)."'");

				$_user_id = $this->load_single("SELECT user_id FROM ".$this->config['table_prefix']."user WHERE user_name = '".quote($this->dblink, $user_name)."'");

				// INSERT USER Settings
				$this->query(
					"INSERT INTO ".$this->config['table_prefix']."user_setting ".
					"SET ".
						"user_id		= '".quote($this->dblink, $_user_id['user_id'])."', ".
						"typografica	= '".(($this->config['default_typografica'] == 1) ? 1 : 0)."', ".
						"lang			= '".quote($this->dblink, ($lang ? $lang : $this->config['language']))."', ".
						"theme			= '".quote($this->dblink, $this->config['theme'])."', ".
						"send_watchmail	= '".quote($this->dblink, 1)."'");

				// INSERT USER Bookmarks
				#$this->convert_into_bookmark_table($this->get_default_bookmarks($lang), $_user_id['user_id']);

				$subject = 	$this->get_translation('EmailWelcome').
							$this->config['wacko_name'];
				$body = 	$this->get_translation('EmailHello'). $user_name.".\n\n".
							str_replace('%1', $this->config['wacko_name'],
							str_replace('%2', $user_name,
							str_replace('%3', $this->href().
							($this->config['rewrite_mode'] ? "?" : "&amp;")."confirm=".$confirm,
							$this->get_translation('EmailRegistered'))))."\n\n".
							$this->get_translation('EmailGoodbye')."\n".
							$this->config['wacko_name']."\n".
							$this->config['base_url'];
				$this->send_mail($email, $subject, $body);

				// log event
				$this->log(4, str_replace('%2', $email, str_replace('%1', $user_name, $this->get_translation('LogUserRegistered', $this->config['language']))));

				// forward
				$this->set_message($this->get_translation('SiteRegistered').
				$this->config['wacko_name'].". ".
				$this->get_translation('SiteEmailConfirm'));
				$this->context[++$this->current_context] = '';
				$this->redirect($this->href('', $this->get_translation('LoginPage')));
			}
		}
	}
}

if (!isset($_POST['confirm']))
{
	if ($this->config['allow_registration'] || $this->is_admin())
	{
		if ($error)
		{
			$this->set_message($this->format($error));
		}

		echo $this->form_open();
		?>
<input type="hidden"
	name="action" value="login" />
<div class="cssform">
<h3><?php echo $this->format_translation('RegistrationWelcome'); ?></h3>
		<?php

		if ($this->config['multilanguage'])
		{
			?>
<p><label for="lang"><?php echo $this->format_translation('RegistrationLang');?>:</label>
<select id="lang" name="lang">

<?php
$lang = $this->user_agent_language();
$langs = $this->available_languages();
for ($i = 0; $i < count($langs); $i++)
{
	echo "<option value=\"".$langs[$i]."\"".
		($lang == $langs[$i]
			? "selected=\"selected\""
			: (!isset($lang) && $this->config['language'] == $langs[$i]
				? "selected=\"selected\""
				: "")
		).">".$langs[$i]."</option>\n";
}
?>
</select></p>
<?php
		}
		?>
<p><label for="name"><?php echo $this->format_translation('RegistrationName');?>:</label>
<input id="name" name="name" size="27" value="<?php echo htmlspecialchars($user_name); ?>" /></p>
<p><label for="password"><?php echo $this->get_translation('RegistrationPassword');?>:</label>
<input type="password" id="password" name="password" size="24" value="<?php echo $password ?>" />
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
<p><label for="confpassword"><?php echo $this->get_translation('ConfirmPassword');?>:</label>
<input type="password" id="confpassword" name="confpassword" size="24" value="<?php echo $confpassword ?>" /></p>
<p>
<?php
/* TODO: add message -> A valid e-mail address. All e-mails from the system will be sent to this address. The e-mail address is not made public and will only be used if you wish to receive a new password or wish to receive certain news or notifications by e-mail. */ ?>
<label for="email"><?php echo $this->get_translation('Email');?>:</label>
<input id="email" name="email" size="30"
	value="<?php echo htmlspecialchars($email); ?>" /></p>
		<?php
		// captcha code starts

		// Only show captcha if the admin enabled it in the config file
		if ($this->config['captcha_registration'])
		{
			// Don't load the captcha at all if the GD extension isn't enabled
			if (extension_loaded('gd'))
			{
				// check whether anonymous user
				// anonymous user has no name
				// if false, we assume it's anonymous
				if ($this->get_user_name() == false)
				{
					?>
<p><label for="captcha"><?php echo $this->get_translation('Captcha');?>:</label>
<img
	src="<?php echo $this->config['base_url'];?>lib/captcha/freecap.php"
	id="freecap" alt="<?php echo $this->get_translation('Captcha');?>" /> <a
	href="" onclick="this.blur(); new_freecap(); return false;"
	title="<?php echo $this->get_translation('CaptchaReload'); ?>"><img
	src="<?php echo $this->config['base_url'];?>images/reload.png"
	width="18" height="17"
	alt="<?php echo $this->get_translation('CaptchaReload'); ?>" /></a> <br />
<input id="captcha" type="text" name="word" maxlength="6"
	style="width: 273px;" /></p>
					<?php
				}
			}
		}
		// end captcha
		?>
<p><input type="submit" value="<?php echo $this->get_translation('RegistrationButton'); ?>" /></p>
</div>
		<?php
		echo $this->form_close();
	}
	else
	{
		echo($this->get_translation('RegistrationClosed'));
	}
}
?>
<!--/notypo-->