<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<!--notypo-->
<?php

$user_name		= '';
$real_name		= '';
$email			= '';
$lang			= '';
$password		= '';
$confpassword	= '';
$error			= '';
$word_ok		= '';

$this->no_cache(false);

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
			"WHERE email_confirm = '".quote($this->dblink, hash('sha256', $_GET['confirm'].hash('sha256', $this->config['system_seed'])))."' ".
			"LIMIT 1"))
	{
		$this->sql_query(
			"UPDATE ".$this->config['user_table']." ".
			"SET email_confirm = '' ".
			"WHERE email_confirm = '".quote($this->dblink, hash('sha256', $_GET['confirm'].hash('sha256', $this->config['system_seed'])))."'");

		$this->show_message($this->get_translation('EmailConfirmed'));

		// cache handling
		if ($this->config['cache'])
		{
			$this->cache->invalidate_page_cache($this->tag);
			$this->cache->invalidate_page_cache($this->supertag);
		}
		// log event
		$this->log(4, str_replace('%2', $temp['user_name'], str_replace('%1', $temp['email'], $this->get_translation('LogUserEmailActivated', $this->config['language']))));

		unset($temp);
	}
	else
	{
		$this->show_message(str_replace('%1', $this->compose_link_to_page('Settings', '', $this->get_translation('SettingsText'), 0), $this->get_translation('EmailNotConfirmed')))."</div><br />";
	}
}
else if (isset($_POST['action']) && $_POST['action'] == 'register')
{
	// create new account if possible
	if ($this->config['allow_registration'] || $this->is_admin())
	{
		// check form token
		if (!$this->validate_form_token('register'))
		{
			$error .= $this->get_translation('FormInvalid');
		}

		// passing vars from user input
		$user_name		= trim($_POST['user_name']);
		#$real_name		= trim($_POST['real_name']);
		$email			= trim($_POST['email']);
		$password		= $_POST['password'];
		$confpassword	= $_POST['confpassword'];
		$lang			= (isset($_POST['user_lang']) ? $_POST['user_lang'] : $this->config['language']);
		#$timezone		= trim($_POST['timezone']);
		$complexity		= $this->password_complexity($user_name, $password);

		// Start Registration Captcha

		// Only show captcha if the admin enabled it in the config
		if(!$this->is_admin() && $this->config['captcha_registration'])
		{
			// captcha validation
			if ($this->validate_captcha() === false)
			{
				$error = $this->get_translation('CaptchaFailed');
			}
		}
		// End Registration Captcha

		if ((!$error) || $this->is_admin() || !$this->config['captcha_registration'])
		{
			// strip \-\_\'\.\/\\
			$user_name	= str_replace('-',		'',		$user_name);
			$user_name	= str_replace('.',		'',		$user_name);
			#$user_name	= str_replace('/',		'',		$user_name); // TODO: check with valid user name vs strip -> usabilitiy?
			$user_name = str_replace("'", '', str_replace('\\', '', str_replace('_', '', $user_name)));

			// check if name is WikiName style
			if (!$this->is_wiki_name($user_name) && $this->config['disable_wikiname'] === false)
			{
				$error .= $this->get_translation('MustBeWikiName')." ";
			}
			else if (strlen($user_name) < $this->config['username_chars_min'])
			{
				$error .= str_replace('%2', $this->config['username_chars_min'],
						$this->get_translation('NameTooShort'))." ";
			}
			else if (strlen($user_name) > $this->config['username_chars_max'])
			{
				$error .= str_replace('%2', $this->config['username_chars_min'],
						$this->get_translation('NameTooLong'))." ";
			}
			// check if valid user name (and disallow '/')
			else if (!preg_match('/^(['.$this->language['ALPHANUM_P'].']+)$/', $user_name) || preg_match('/\//', $user_name))
			{
				$error .= $this->get_translation('InvalidUserName')." ";
			}
			// check if reserved word
			else if($result = $this->validate_reserved_words($user_name))
			{
				$error .= str_replace('%1', $result, $this->get_translation('UserReservedWord'));
			}
			// if user name already exists
			else if ($this->user_name_exists($user_name) === true)
			{
				$error .= $this->get_translation('RegistrationUserNameOwned');

				// log event
				$this->log(2, str_replace('%1', $user_name, $this->get_translation('LogUserSimiliarName', $this->config['language'])));
			}
			// no email given
			else if ($email == '')
			{
				$error .= $this->get_translation('SpecifyEmail')." ";
			}
			// invalid email
			else if (!$this->validate_email($email))
			{
				$error .= $this->get_translation('NotAEmail')." ";
			}
			// no email reuse allowed
			else if ($this->config['allow_email_reuse'] == 0 && $this->email_exists($email) === true)
			{
				$error .= $this->get_translation('EmailTaken')." ";
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
				$salt_length		= 10;
				$salt_user_form		= $this->random_password($salt_length, 3);
				$confirm			= hash('sha256', $password.mt_rand().time().mt_rand().$email.mt_rand());
				$confirm_hash		= hash('sha256', $confirm.hash('sha256', $this->config['system_seed']));
				$password_hashed	= $user_name.$password;

				$password_hashed	= password_hash(
										base64_encode(
												hash('sha256', $password_hashed, true)
												),
										PASSWORD_DEFAULT
										);

				/* $timezone			= date('Z') / 3600;
				$is_dst				= date('I');

				if ($this->config['timezone'] == $timezone || $this->config['timezone'] == ($timezone - 1))
				{
					$timezone = ($is_dst) ? $timezone - 1 : $timezone;

					if (!isset($this->get_translation['TzZoneArray'][(string) $timezone]))
					{
						$timezone = $this->config['timezone'];
					}
				}
				else
				{
					$timezone	= $this->config['timezone'];
					$is_dst		= $this->config['dst'];
				} */

				// set new user approval
				if ($this->config['approve_new_user'] == true)
				{
					$account_status		= 1;
					$account_enabled	= 0;
					$waiting_approval	= $this->get_translation('UserWaitingApproval');
					$requires_approval	= $this->get_translation('UserRequiresApproval');
				}
				else
				{
					$account_status		= 0;
					$account_enabled	= 1;
					$waiting_approval	= '';
					$requires_approval	= '';

				}

				// INSERT user
				$this->sql_query(
					"INSERT INTO ".$this->config['user_table']." ".
					"SET ".
						"signup_time	= NOW(), ".
						"user_name		= '".quote($this->dblink, $user_name)."', ".
						#"real_name		= '".quote($this->dblink, $real_name)."', ".
						"account_lang	= '".quote($this->dblink, ($lang ? $lang : $this->config['language']))."', ".
						"email			= '".quote($this->dblink, $email)."', ".
						"email_confirm	= '".quote($this->dblink, $confirm_hash)."', ".
						"password		= '".quote($this->dblink, $password_hashed)."', ".
						"account_status	= '".quote($this->dblink, $account_status)."', ".
						"enabled		= '".quote($this->dblink, $account_enabled)."', ".
						"user_form_salt	= '".quote($this->dblink, $salt_user_form)."'");

				// get new user_id
				$_user_id = $this->load_single(
					"SELECT user_id ".
					"FROM ".$this->config['table_prefix']."user ".
					"WHERE user_name = '".quote($this->dblink, $user_name)."' ".
					"LIMIT 1");

				// INSERT user settings
				$this->sql_query(
					"INSERT INTO ".$this->config['table_prefix']."user_setting ".
					"SET ".
						"user_id		= '".(int)$_user_id['user_id']."', ".
						"typografica	= '".(($this->config['default_typografica'] == 1) ? 1 : 0)."', ".
						"user_lang		= '".quote($this->dblink, ($lang ? $lang : $this->config['language']))."', ".
						"theme			= '".quote($this->dblink, $this->config['theme'])."', ".
						#"timezone		= '".quote($this->dblink, ($timezone ? $timezone : (float)$this->config['timezone']))."', ".
						#"dst			= '".quote($this->dblink, ($dst ? $dst : (int)$this->config['dst']))."', ".
						"send_watchmail	= '".quote($this->dblink, 1)."'");

				// INSERT user menu items


				// add your user page template here
				$user_page_template	= '**((user:'.$user_name.' '.$user_name.'))** ('.$this->format('::+::', 'pre_wacko').')';
				$change_summary		= $this->get_translation('NewUserAccount'); //'auto created';

				// add user page
				$this->save_page($this->config['users_page'].'/'.$user_name, '', $user_page_template, $change_summary, '', '', '', '', ($lang ? $lang : $this->config['language']), '', $user_name, true);

				// send email
				if ($this->config['enable_email'] == true)
				{
					// 1. Send signup email to new user
					/* TODO: set user language for email encoding */
					$this->load_translation($lang);
					$this->set_translation ($lang);
					$this->set_language ($lang);

					$subject =	$this->get_translation('EmailWelcome').
								$this->config['site_name'];
					$body =		$this->get_translation('EmailHello'). $user_name.",\n\n".
								str_replace('%1', $this->config['site_name'],
								str_replace('%2', $user_name,
								str_replace('%3', $this->href('', '', 'confirm='.$confirm),
								$this->get_translation('EmailRegistered'))))."\n\n".
								$waiting_approval."\n\n".
								$this->get_translation('EmailDoNotReply')."\n\n".
								$this->get_translation('EmailGoodbye')."\n".
								$this->config['site_name']."\n".
								$this->config['base_url'];

					$this->send_mail($email, $subject, $body);
					unset($subject, $body);

					// 2. notify admin a new user has signed-up
					if ($this->config['notify_new_user_account'])
					{
						/* TODO: set user language for email encoding */
						$lang_admin = $this->config['language'];
						$this->load_translation($lang_admin);
						$this->set_translation ($lang_admin);
						$this->set_language ($lang_admin);

						$subject =	'['.$this->config['site_name'].'] '.$this->get_translation('NewAccountSubject');
						$body =		$this->get_translation('NewAccountSignupInfo')."\n\n".
									$this->get_translation('NewAccountUsername').' '.$user_name."\n".
									$this->get_translation('NewAccountEmail').' '.$email."\n".
									$this->get_translation('NewAccountIP').' '.$this->ip_address()."\n\n".
									$requires_approval."\n\n".
									$this->get_translation('NewAccountDoNotReply')."\n\n".
									$this->config['site_name']."\n".
									$this->config['base_url'];

						$this->send_mail($this->config['admin_email'], $subject, $body);
					}

					$this->load_translation($this->user_lang);
					$this->set_translation($this->user_lang);
					$this->set_language($this->user_lang);
				}

				// log event
				$this->log(4, str_replace('%2', $email, str_replace('%1', $user_name, $this->get_translation('LogUserRegistered', $this->config['language']))));

				// forward
				$this->set_message(
					$this->get_translation('SiteRegistered').
					$this->config['site_name'].'. <br /><br />'.
					$this->get_translation('SiteEmailConfirm'));

				$this->context[++$this->current_context] = '';
				$this->redirect($this->href('', $this->get_translation('LoginPage'), 'cache='.rand(0,1000)));
			}
		}
	}
}

if (!isset($_GET['confirm']))
{
	if ($this->config['allow_registration'] || $this->is_admin())
	{
		if ($error)
		{
			$this->set_message($this->format($error));
		}

		echo '<div class="cssform">';

		if ($this->config['approve_new_user'] == true)
		{
			$this->show_message($this->get_translation('UserApprovalInfo'), 'hint');
		}

		echo $this->form_open('register', '', '', true);

		echo '<input type="hidden" name="action" value="register" />';

		echo '<h3>'.$this->format_translation('RegistrationWelcome').'</h3>';

		if ($this->config['multilanguage'])
		{
			echo '<p><label for="user_lang">'.$this->format_translation('RegistrationLang').':</label>';
			echo '<select id="user_lang" name="user_lang">';

			$languages	= $this->get_translation('LanguageArray');
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

		echo '<p><label for="user_name">'.$this->format_translation('UserName').':</label>';
		echo '<input type="text" id="user_name" name="user_name" size="27" value="'.htmlspecialchars($user_name, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" autocomplete="off" required autofocus />';

		if ($this->config['disable_wikiname'] === false)
		{
			echo "<br /><small>".
			str_replace('%1', $this->config['username_chars_min'],
			str_replace('%2', $this->config['username_chars_max'],
			$this->get_translation('NameCamelCaseOnly'))).
			"</small>";
			echo '</p>';
		}
		else
		{
			echo "<br /><small>".
			str_replace('%1', $this->config['username_chars_min'],
			str_replace('%2', $this->config['username_chars_max'],
			$this->get_translation('NameAlphanumOnly'))).
			"</small>";
			echo '</p>';
		}

		#echo '<p><label for="real_name">'.$this->format_translation('RegistrationRealName').':</label>';
		#echo '<input type="text" id="real_name" name="real_name" size="27" value="'.htmlspecialchars($real_name, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" /></p>';
		echo '<p><label for="password">'.$this->get_translation('RegistrationPassword').':</label>';
		echo '<input type="password" id="password" name="password" size="24" value="'.$password.'" autocomplete="off" required />';
		echo $this->show_password_complexity();
		echo '</p>';

		echo '<p><label for="confpassword">'.$this->get_translation('ConfirmPassword').':</label>';
		echo '<input type="password" id="confpassword" name="confpassword" size="24" value="'.$confpassword.'" autocomplete="off" /></p>';

		echo '<p>';
		echo '<label for="email">'.$this->get_translation('Email').':</label>';
		echo '<input type="email" id="email" name="email" size="30" value="'.htmlspecialchars($email, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" required />';
		echo '<small> <a title="'.$this->get_translation('RegistrationEmailInfo').'">(?)</a></small></p>';

		/*if ($this->config['policy_page'])
		{
			echo '<p>';
			echo '<label for="terms_of_use">'.$this->get_translation('TermsOfUse').':</label>';
			echo '<input type="checkbox" id="terms_of_use" name="terms_of_use" value="1" />';
			echo '<small> '.$this->get_translation('AcceptTermsOfUse').' '.$this->config['site_name'].' <a href="'.htmlspecialchars($this->href('', $this->config['policy_page']), ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'">'.$this->get_translation('TermsOfUse').'</a><br /></small></p>';
		}*/

		// captcha code starts

		// Only show captcha if the admin enabled it in the config file
		if ($this->config['captcha_registration'])
		{
			echo '<p>';
			$this->show_captcha();
			echo '</p>';
		}
		// end captcha

		echo '<p><input type="submit" class="OkBtn" value="'.$this->get_translation('RegistrationButton').'" /></p>';

		echo $this->form_close();
		echo '</div>';
	}
	else
	{
		echo($this->get_translation('RegistrationClosed'));
	}
}
?>
<!--/notypo-->