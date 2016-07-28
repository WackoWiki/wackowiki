<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo "<!--notypo-->\n";
$include_tail = "<!--/notypo-->\n";

$user_name		= '';
$real_name		= '';
$email			= '';
$user_lang		= '';
$password		= '';
$conf_password	= '';
$error			= '';
$message		= '';
$word_ok		= '';

// reconnect securely in tls mode
$this->http->ensure_tls($this->href());

// is user trying to confirm email, login or register?
if (isset($_GET['confirm']))
{
	$confirm_hash = $this->db->q(hash_hmac('sha256', $_GET['confirm'], $this->db->system_seed));

	if (($temp = $this->db->load_single(
		"SELECT user_name, email ".
		"FROM ".$this->db->user_table." ".
		"WHERE email_confirm = ".$confirm_hash." ".
		"LIMIT 1")))
	{
		$this->db->sql_query(
			"UPDATE ".$this->db->user_table." SET ".
				"email_confirm = '' ".
			"WHERE email_confirm = ".$confirm_hash." ".
			"LIMIT 1");

		// cache handling
		$this->http->invalidate_page($this->supertag);

		// log event
		$this->log(4, Ut::perc_replace($this->_t('LogUserEmailActivated', SYSTEM_LANG), $temp['email'], $temp['user_name']));

		$message = $this->_t('EmailConfirmed');
		$this->set_message($message, 'success');
	}
	else
	{
		$message = Ut::perc_replace($this->_t('EmailNotConfirmed'), $this->compose_link_to_page('Settings', '', $this->_t('SettingsText'), 0));
		$this->set_message($message, 'error');
	}

	$this->http->redirect($this->href('', $this->_t('LoginPage'), 'cache='.Ut::random_token(5)));
}
else if (@$_POST['_action'] === 'register')
{
	// create new account if possible
	if ($this->db->allow_registration || $this->is_admin())
	{
		// passing vars from user input
		$user_name		= Ut::strip_spaces($_POST['user_name']);
		$email			= Ut::strip_spaces($_POST['email']);
		$password		= $_POST['password'];
		$conf_password	= $_POST['conf_password'];
		$user_lang		= (isset($_POST['user_lang']) ? $_POST['user_lang'] : $this->db->language);
		$complexity		= $this->password_complexity($user_name, $password);

		if (!$this->is_admin() && $this->db->captcha_registration && !$this->validate_captcha())
		{
			$error .= $this->_t('CaptchaFailed');
		}

		if ((!$error) || $this->is_admin() || !$this->config['captcha_registration'])
		{
			// strip \-\_\'\.\/\\
			$user_name	= str_replace('-',	'',		$user_name);
			$user_name	= str_replace('.',	'',		$user_name);
			#$user_name	= str_replace('/',	'',		$user_name); // TODO: check with valid user name vs strip -> usabilitiy?
			$user_name	= str_replace("'",	'',		str_replace('\\', '', str_replace('_', '', $user_name)));

			// check if name is WikiName style
			if (!$this->is_wiki_name($user_name) && $this->config['disable_wikiname'] === false)
			{
				$error .= $this->_t('MustBeWikiName')." ";
			}
			else if (strlen($user_name) < $this->config['username_chars_min'])
			{
				$error .= Ut::perc_replace($this->_t('NameTooShort'), 0, $this->config['username_chars_min'])." ";
			}
			else if (strlen($user_name) > $this->config['username_chars_max'])
			{
				$error .= Ut::perc_replace($this->_t('NameTooLong'), 0, $this->config['username_chars_max'])." ";
			}
			// check if valid user name (and disallow '/')
			else if (!preg_match('/^(['.$this->language['ALPHANUM_P'].']+)$/', $user_name) || preg_match('/\//', $user_name))
			{
				$error .= $this->_t('InvalidUserName')." ";
			}
			// check if reserved word
			else if (($result = $this->validate_reserved_words($user_name)))
			{
				$error .= Ut::perc_replace($this->_t('UserReservedWord'), $result);
			}
			// if user name already exists
			else if ($this->user_name_exists($user_name) === true)
			{
				$error .= $this->_t('RegistrationUserNameOwned');

				// log event
				$this->log(2, Ut::perc_replace($this->_t('LogUserSimiliarName', $this->config['language']), $user_name));
			}
			// no email given
			else if ($email == '')
			{
				$error .= $this->_t('SpecifyEmail')." ";
			}
			// invalid email
			else if (!$this->validate_email($email))
			{
				$error .= $this->_t('NotAEmail')." ";
			}
			// no email reuse allowed
			else if (!$this->config['allow_email_reuse'] && $this->email_exists($email))
			{
				$error .= $this->_t('EmailTaken')." ";
			}
			// confirmed password mismatch
			else if ($conf_password != $password)
			{
				$error .= $this->_t('PasswordsDidntMatch')." ";
			}
			// password complexity validation
			else if ($complexity)
			{
				$error .= $complexity;
			}

			// submitting input to DB
			else
			{
				$confirm			= Ut::random_token(21);
				$user_ip			= $this->get_user_ip();

				// set new user approval
				if ($this->db->approve_new_user)
				{
					$account_status		= 1;
					$account_enabled	= 0;
					$waiting_approval	= Ut::perc_replace($this->_t('UserWaitingApproval'), SYSTEM_LANG);
					$requires_approval	= Ut::perc_replace($this->_t('UserRequiresApproval'), SYSTEM_LANG);
				}
				else
				{
					$account_status		= 0;
					$account_enabled	= 1;
					$waiting_approval	= $this->_t('EmailRegisteredLogin');
					$requires_approval	= '';
				}

				// INSERT user
				$this->db->sql_query(
					"INSERT INTO ".$this->config['user_table']." ".
					"SET ".
						"signup_time	= UTC_TIMESTAMP(), ".
						"user_name		= ".$this->db->q($user_name).", ".
						"account_lang	= ".$this->db->q($user_lang? $user_lang : $this->db->language).", ".
						"email			= ".$this->db->q($email).", ".
						"email_confirm	= ".$this->db->q(hash_hmac('sha256', $confirm, $this->db->system_seed)).", ".
						"password		= ".$this->db->q($this->password_hash(['user_name' => $user_name], $password)).", ".
						"account_status	= '".(int) $account_status."', ".
						"enabled		= '".(int) $account_enabled."', ".
						"user_ip		= ".$this->db->q($user_ip)." ");

				// get new user_id
				$_user_id = $this->db->load_single(
					"SELECT user_id ".
					"FROM ".$this->db->table_prefix."user ".
					"WHERE user_name = ".$this->db->q($user_name)." ".
					"LIMIT 1");

				// INSERT user settings
				$this->db->sql_query(
					"INSERT INTO ".$this->config['table_prefix']."user_setting ".
					"SET ".
						"user_id			= '".(int)$_user_id['user_id']."', ".
						"typografica		= '".(($this->config['default_typografica'] == 1) ? 1 : 0)."', ".
						"user_lang			= ".$this->db->q(($user_lang ? $user_lang : $this->config['language'])).", ".
						"theme				= ".$this->db->q($this->config['theme']).", ".
						"notify_minor_edit	= '".(int)$this->config['notify_minor_edit']."', ".
						"notify_page		= '".(int)$this->config['notify_page']."', ".
						"notify_comment		= '".(int)$this->config['notify_comment']."', ".
						"sorting_comments	= '".(int)$this->config['sorting_comments']."', ".
						"send_watchmail		= '1'");

				// INSERT user menu items

				if (!$this->db->approve_new_user)
				{
					$this->add_user_page($user_name, $user_lang);
				}

				// send email
				if ($this->db->enable_email)
				{
					// 1. Send signup email to new user
					$save = $this->set_language($user_lang, true);

					$subject =	$this->_t('EmailWelcome') . $this->db->site_name;
					$body =		Ut::perc_replace($this->_t('EmailRegistered'),
									$this->db->site_name, $user_name, $this->href('', '', 'confirm=' . $confirm)) . "\n\n".
								$waiting_approval . "\n\n".
								$this->_t('EmailRegisteredIgnore') . "\n\n";

					$this->send_user_email($user_name, $email, $subject, $body, $user_lang);
					$this->set_language($save, true);

					// 2. notify admin a new user has signed-up
					if ($this->config['notify_new_user_account'])
					{
						/* TODO: set user language for email encoding */
						$lang_admin = $this->config['language'];
						$save = $this->set_language($lang_admin, true);

						$subject	=	$this->_t('NewAccountSubject');
						$body		=	$this->_t('NewAccountSignupInfo') . "\n\n".
										$this->_t('NewAccountUsername') . ' ' .	$user_name . "\n".
										$this->_t('RegistrationLang') . ' ' .	$user_lang . "\n".
										$this->_t('NewAccountEmail') . ' ' .	$email . "\n".
										$this->_t('NewAccountIP') . ' ' .		$user_ip . "\n\n".
										$requires_approval . "\n\n";

						$this->send_user_email('WikiAdmin' ,$this->db->admin_email, $subject, $body, $lang_admin);
						$this->set_language($save, true);
					}
				}

				// log event
				$this->log(4, Ut::perc_replace($this->_t('LogUserRegistered', SYSTEM_LANG), $user_name, $email));

				// forward
				$this->set_message(
					$this->_t('SiteRegistered').
					'&laquo;'.$this->config['site_name'].'&raquo;. <br /><br />'.
					$this->_t('SiteEmailConfirm'));

				$this->context[++$this->current_context] = '';
				$this->http->redirect($this->href('', $this->_t('LoginPage'), 'cache='.Ut::random_token(5)));
			}
		}
	}
}

if (!isset($_GET['confirm']))
{
	if ( ($this->config['allow_registration'] && !$this->get_user())
		|| $this->is_admin() )
	{
		if ($error)
		{
			$this->set_message($this->format($error), 'error');
		}

		echo '<div class="cssform">';

		if ($this->db->approve_new_user)
		{
			$this->show_message($this->_t('UserApprovalInfo'), 'hint');
		}

		echo $this->form_open('register');

		echo '<h3>'.$this->format_t('RegistrationWelcome').'</h3>';

		if ($this->config['multilanguage'])
		{
			echo '<p><label for="user_lang">'.$this->format_t('RegistrationLang').':</label>';
			echo '<select id="user_lang" name="user_lang">';

			$languages	= $this->_t('LanguageArray');
			$user_lang	= $this->user_agent_language();
			$langs		= $this->available_languages();

			foreach ($langs as $lang)
			{
				echo '<option value="'.$lang.'"'.
					($user_lang == $lang
						? 'selected="selected"'
						: (!isset($user_lang) && $this->config['language'] == $lang
							? 'selected="selected"'
							: '')
					).'>'.$languages[$lang].' ('.$lang.")</option>\n";
			}

			echo '</select></p>';
		}

		echo '<p><label for="user_name">'.$this->format_t('UserName').':</label>';
		echo '<input type="text" id="user_name" name="user_name" size="25" maxlength="80" value="'.htmlspecialchars($user_name, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" autocomplete="off" required autofocus />';

		if ($this->config['disable_wikiname'] === false)
		{
			echo '<br /><small>'.
			Ut::perc_replace($this->_t('NameCamelCaseOnly'),
				$this->config['username_chars_min'],
				$this->config['username_chars_max']).
			'</small>';
			echo "</p>\n";
		}
		else
		{
			echo '<br /><small>'.
			Ut::perc_replace($this->_t('NameAlphanumOnly'),
				$this->config['username_chars_min'],
				$this->config['username_chars_max']).
			'</small>';
			echo "</p>\n";
		}

		echo '<p><label for="password">'.$this->_t('RegistrationPassword').':</label>';
		echo '<input type="password" id="password" name="password" size="24" value="'.$password.'" autocomplete="off" required />';
		echo $this->show_password_complexity();
		echo "</p>\n";

		echo '<p><label for="conf_password">'.$this->_t('ConfirmPassword').':</label>';
		echo '<input type="password" id="conf_password" name="conf_password" size="24" value="'.$conf_password.'" autocomplete="off" /></p>';

		echo '<p>';
		echo '<label for="email">'.$this->_t('Email').':</label>';
		echo '<input type="email" id="email" name="email" size="30" value="'.htmlspecialchars($email, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" required />';
		echo '<small> <a title="'.$this->_t('RegistrationEmailInfo').'">(?)</a></small></p>';

		/*if ($this->config['policy_page'])
		{
			echo '<p>';
			echo '<label for="terms_of_use">'.$this->_t('TermsOfUse').':</label>';
			echo '<input type="checkbox" id="terms_of_use" name="terms_of_use" value="1" />';
			echo '<small> '.$this->_t('AcceptTermsOfUse').' '.$this->config['site_name'].' <a href="'.htmlspecialchars($this->href('', $this->config['policy_page']), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'">'.$this->_t('TermsOfUse').'</a><br /></small></p>';
		}*/

		if ($this->db->captcha_registration)
		{
			echo '<p>';
			echo $this->show_captcha();
			echo "</p>\n";
		}

		echo '<p><input type="submit" class="OkBtn" value="'.$this->_t('RegistrationButton').'" /></p>';

		echo $this->form_close();
		echo "</div>\n";
	}
	else
	{
		$this->show_message($this->_t('RegistrationClosed'), 'hint');
	}
}
