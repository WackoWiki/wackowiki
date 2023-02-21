<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$user_name		= '';
$email			= '';
$user_lang		= '';
$password		= '';
$conf_password	= '';
$error			= '';

// reconnect securely in tls mode
$this->http->ensure_tls($this->href());

$this->no_way_back = true; // prevent goback'ing that page

// is user trying to confirm email, login or register?
if (isset($_GET['confirm']))
{
	$this->user_email_confirm_check($_GET['confirm']);
	$this->http->invalidate_page($this->tag);
	$this->login_page();
}

if (@$_POST['_action'] === 'register' && ($this->db->allow_registration || $this->is_admin()))
{
	// create new account if possible
	// passing vars from user input
	$user_name		= $this->sanitize_username(($_POST['user_name'] ?? ''));
	$email			= Ut::strip_spaces(($_POST['email'] ?? ''));
	$password		= (string) ($_POST['password'] ?? '');
	$conf_password	= (string) ($_POST['conf_password'] ?? '');
	$user_lang		= $this->validate_language($_POST['user_lang'] ?? '');
	$complexity		= $this->password_complexity($user_name, $password);

	if (isset($this->sess->registration_delay)
		&& ($tdiff = time() - $this->sess->registration_delay) < $this->db->registration_delay)
	{
		// mitigate bots from creating accounts
		$this->sess->registration_delay	= time();

		$error .= Ut::perc_replace($this->_t('RegistrationThreshold'), $this->db->registration_delay);
		$this->log(2, Ut::perc_replace($this->_t('LogRegisterTiming', SYSTEM_LANG), $this->db->registration_delay, $tdiff));
	}

	if (!$this->is_admin() && $this->db->captcha_registration && !$this->validate_captcha())
	{
		$error .= $this->_t('CaptchaFailed');
	}

	if ((!$error) || $this->is_admin() || !$this->db->captcha_registration)
	{
		if ($message = $this->validate_username($user_name))
		{
			$error .= $message;
		}
		else if ($message = $this->validate_email($email))
		{
			$error .= $message;
		}
		// confirmed password mismatch
		else if ($conf_password != $password)
		{
			$error .= $this->_t('PasswordsDidntMatch') . ' ';
		}
		// password complexity validation
		else if ($complexity)
		{
			$error .= $complexity;
		}

		// submitting input to DB
		else
		{
			$user_ip			= $this->http->ip;

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
				"INSERT INTO " . $this->prefix . "user " .
				"SET " .
					"signup_time		= UTC_TIMESTAMP(), " .
					"user_name			= " . $this->db->q($user_name) . ", " .
					"email				= " . $this->db->q($email) . ", " .
					"password			= " . $this->db->q($this->password_hash(['user_name' => $user_name], $password)) . ", " .
					"account_status		= " . (int) $account_status . ", " .
					"enabled			= " . (int) $account_enabled . ", " .
					"user_ip			= " . $this->db->q($user_ip) . " ");

			// get new user_id
			$_user_id = $this->db->load_single(
				"SELECT user_id " .
				"FROM " . $this->prefix . "user " .
				"WHERE user_name = " . $this->db->q($user_name) . " " .
				"LIMIT 1");

			$user_id = $_user_id['user_id'];

			// INSERT user settings
			$this->db->sql_query(
				"INSERT INTO " . $this->prefix . "user_setting " .
				"SET " .
					"user_id			= " . (int) $user_id . ", " .
					"user_lang			= " . $this->db->q($user_lang) . ", " .
					"list_count			= " . (int) $this->db->list_count . ", " .
					"theme				= " . $this->db->q($this->db->theme) . ", " .
					"diff_mode			= " . (int) $this->db->default_diff_mode . ", " .
					"notify_minor_edit	= " . (int) $this->db->notify_minor_edit . ", " .
					"notify_page		= " . (int) $this->db->notify_page . ", " .
					"notify_comment		= " . (int) $this->db->notify_comment . ", " .
					"sorting_comments	= " . (int) $this->db->sorting_comments . ", " .
					"allow_intercom		= " . (int) $this->db->allow_intercom . ", " .
					"allow_massemail	= " . (int) $this->db->allow_massemail . ", " .
					"send_watchmail		= 1");

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
				Ut::perc_replace($this->_t('SiteRegistered'), '«' . $this->db->site_name . '»') .
				'<br><br>' .
				$this->_t('SiteEmailConfirm'));

			if ($this->db->approve_new_user)
			{
				// notify the user that the account still needs approval
				$this->set_message($this->_t('UserApprovalHint'), 'hint');
			}

			$this->context[++$this->current_context] = '';
			$this->login_page();
		}
	}

	// fetch fields
	$this->sess->r_user_name	= $user_name;
	$this->sess->r_email		= $email;

	$this->set_message($error, 'error');
}

// enough for POSTs
$_POST && $this->show_must_go_on();


if (!(($this->db->allow_registration && !$this->get_user()) || $this->is_admin()))
{
	$tpl->closed = true;
}
else
{
	if (!empty($this->sess->r_user_name))
	{
		$user_name					= $this->sess->r_user_name;
		$this->sess->r_user_name	= '';
	}

	if (!empty($this->sess->r_email))
	{
		$email						= $this->sess->r_email;
		$this->sess->r_email		= '';
	}

	// show registration form
	$tpl->enter('r_');

	// for timing method to mitigate bots from creating accounts
	$this->sess->registration_delay	= time();

	$tpl->form		= $this->href();
	$tpl->approve	= (bool) $this->db->approve_new_user;

	if ($this->db->multilanguage)
	{
		$languages	= $this->_t('LanguageArray');
		$sel		= $this->http->user_agent_language();

		foreach ($this->http->available_languages() as $lang)
		{
			$tpl->multi_l_lang		= $lang;
			$tpl->multi_l_name		= $languages[$lang];
			$tpl->multi_l_selected	= ($sel == $lang);
		}
	}

	$tpl->autocomplete	= $this->form_autocomplete_off();
	$tpl->username		= $user_name;
	$tpl->pattern		= self::PATTERN['USER_NAME'];
	$tpl->password 		= $password;
	$tpl->confpassword	= $conf_password;
	$tpl->only			=
		Ut::perc_replace($this->_t($this->db->disable_wikiname? 'NameAlphanumOnly' : 'NameCamelCaseOnly'),
			$this->db->username_chars_min,
			$this->db->username_chars_max);
	$tpl->complexity	= $this->show_password_complexity();
	$tpl->email			= $email;

	if ($this->db->terms_page)
	{
		# $tpl->terms_href = $this->href('', $this->db->terms_page);
	}

	if ($this->db->captcha_registration)
	{
		$tpl->captcha_show = $this->show_captcha();
	}

	$tpl->leave();
}
