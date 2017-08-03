<?php

if (!defined('IN_WACKO'))
{
	exit;
}

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

$this->no_way_back = true; // prevent goback'ing that page

// is user trying to confirm email, login or register?
if (isset($_GET['confirm']))
{
	$this->user_email_confirm_check($_GET['confirm']);
	$this->http->invalidate_page($this->supertag);
	$this->login_page();
}

if (@$_POST['_action'] === 'register' && ($this->db->allow_registration || $this->is_admin()))
{
	// create new account if possible
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

	if ((!$error) || $this->is_admin() || !$this->db->captcha_registration)
	{
		// strip \-\_\'\.\/\\
		$user_name	= str_replace(['-', '.', /* '/', */ "'", '\\', '_'], '', $user_name);

		// check if name is WikiName style
		if (!$this->is_wiki_name($user_name) && $this->db->disable_wikiname === false)
		{
			$error .= $this->_t('MustBeWikiName') . " ";
		}
		else if (strlen($user_name) < $this->db->username_chars_min)
		{
			$error .= Ut::perc_replace($this->_t('NameTooShort'), 0, $this->db->username_chars_min) . " ";
		}
		else if (strlen($user_name) > $this->db->username_chars_max)
		{
			$error .= Ut::perc_replace($this->_t('NameTooLong'), 0, $this->db->username_chars_max) . " ";
		}
		// check if valid user name (and disallow '/')
		else if (!preg_match('/^([' . $this->language['ALPHANUM_P'] . ']+)$/', $user_name) || preg_match('/\//', $user_name))
		{
			$error .= $this->_t('InvalidUserName') . " ";
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
			$this->log(2, Ut::perc_replace($this->_t('LogUserSimiliarName', SYSTEM_LANG), $user_name));
		}
		// no email given
		else if ($email == '')
		{
			$error .= $this->_t('SpecifyEmail') . " ";
		}
		// invalid email
		else if (!$this->validate_email($email))
		{
			$error .= $this->_t('NotAEmail') . " ";
		}
		// no email reuse allowed
		else if (!$this->db->allow_email_reuse && $this->email_exists($email))
		{
			$error .= $this->_t('EmailTaken') . " ";
		}
		// confirmed password mismatch
		else if ($conf_password != $password)
		{
			$error .= $this->_t('PasswordsDidntMatch') . " ";
		}
		// password complexity validation
		else if ($complexity)
		{
			$error .= $complexity;
		}

		// submitting input to DB
		else
		{
			$user_ip			= $this->get_user_ip();

			// set new user approval
			if ($this->db->approve_new_user)
			{
				$account_status		= 1;
				$account_enabled	= 0;
			}
			else
			{
				$account_status		= 0;
				$account_enabled	= 1;
			}

			// INSERT user
			$this->db->sql_query(
				"INSERT INTO " . $this->db->user_table . " " .
				"SET " .
					"signup_time	= UTC_TIMESTAMP(), " .
					"user_name		= " . $this->db->q($user_name) . ", " .
					"account_lang	= " . $this->db->q($user_lang? $user_lang : $this->db->language) . ", " .
					"email			= " . $this->db->q($email) . ", " .
					"password		= " . $this->db->q($this->password_hash(['user_name' => $user_name], $password)) . ", " .
					"account_status	= '" . (int) $account_status . "', " .
					"enabled		= '" . (int) $account_enabled . "', " .
					"user_ip		= " . $this->db->q($user_ip) . " ");

			// get new user_id
			$_user_id = $this->db->load_single(
				"SELECT user_id " .
				"FROM " . $this->db->table_prefix . "user " .
				"WHERE user_name = " . $this->db->q($user_name) . " " .
				"LIMIT 1");

			$user_id = $_user_id['user_id'];

			// INSERT user settings
			$this->db->sql_query(
				"INSERT INTO " . $this->db->table_prefix . "user_setting " .
				"SET " .
					"user_id			= '" . (int) $user_id . "', " .
					"typografica		= '" . (($this->db->default_typografica == 1) ? 1 : 0) . "', " .
					"user_lang			= " . $this->db->q(($user_lang ? $user_lang : $this->db->language)) . ", " .
					"list_count			= '" . (int) $this->db->list_count . "', " .
					"theme				= " . $this->db->q($this->db->theme) . ", " .
					"diff_mode			= '" . (int) $this->db->default_diff_mode . "', " .
					"notify_minor_edit	= '" . (int) $this->db->notify_minor_edit . "', " .
					"notify_page		= '" . (int) $this->db->notify_page . "', " .
					"notify_comment		= '" . (int) $this->db->notify_comment . "', " .
					"sorting_comments	= '" . (int) $this->db->sorting_comments . "', " .
					"send_watchmail		= '1'");

			// INSERT user menu items
			// -> set_menu function will prepopulate user menu with default menu items

			if (!$this->db->approve_new_user)
			{
				$this->add_user_page($user_name, $user_lang);
			}

			// send email
			if ($this->db->enable_email)
			{
				// 1. Send signup email to new user
				$new_user = [
					'user_id'		=> $user_id,
					'user_name'		=> $user_name,
					'email'			=> $email,
					'user_lang'		=> $user_lang,
					'user_ip'		=> $user_ip
				];

				$this->notify_user_signup($new_user);

				// 2. notify admin a new user has signed-up
				if ($this->db->notify_new_user_account)
				{
					$this->notify_new_account($new_user);
				}
			}

			// log event
			$this->log(4, Ut::perc_replace($this->_t('LogUserRegistered', SYSTEM_LANG), $user_name, $email));

			// forward
			$this->set_message(
				$this->_t('SiteRegistered') .
				'&laquo;' . $this->db->site_name . '&raquo;. <br /><br />' .
				$this->_t('SiteEmailConfirm'));

			$this->context[++$this->current_context] = '';
			$this->login_page();
		}
	}

	$this->set_message($this->format($error), 'error');
}

// enough for POSTs
$_POST and $this->show_must_go_on();


if (!(($this->db->allow_registration && !$this->get_user()) || $this->is_admin()))
{
	$tpl->closed = true;
}
else
{
	$tpl->r_form = $this->href();

	$tpl->r_approve = !!$this->db->approve_new_user;

	if ($this->db->multilanguage)
	{
		$languages	= $this->_t('LanguageArray');
		$sel		= $this->user_agent_language();

		foreach ($this->available_languages() as $lang)
		{
			$tpl->r_multi_l_lang		= $lang;
			$tpl->r_multi_l_name		= $languages[$lang];
			$tpl->r_multi_l_selected	= ($sel == $lang);
		}
	}

	$tpl->r_autocomplete	= $this->form_autocomplete_off();
	$tpl->r_username		= $user_name;
	$tpl->r_password 		= $password;
	$tpl->r_confpassword	= $conf_password;
	$tpl->r_only			=
		Ut::perc_replace($this->_t($this->db->disable_wikiname? 'NameAlphanumOnly' : 'NameCamelCaseOnly'),
			$this->db->username_chars_min,
			$this->db->username_chars_max);
	$tpl->r_complexity		= $this->show_password_complexity();
	$tpl->r_email			= $email;

	if ($this->db->policy_page)
	{
		// $tpl->r_policy_href = $this->href('', $this->db->policy_page);
	}

	if ($this->db->captcha_registration)
	{
		$tpl->r_captcha_show = $this->show_captcha();
	}
}
