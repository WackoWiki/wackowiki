<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Displays change password forms: password change and forgotten password reset.

Usage:
	{{changepassword}}

Options:
	[forgot=1]
EOD;

// set defaults
$help	??= 0;

if ($help)
{
	$tpl->help	= $this->help($info, 'changepassword');
	return;
}

$this->no_way_back = true; // prevent goback'ing that page

// reconnect securely in tls mode
$this->http->ensure_tls($this->href());

$prefix		= $this->prefix;

if ($code = (string) ($_REQUEST['secret_code'] ?? null))
{
	$user = $this->db->load_single(
		'SELECT user_id, user_name ' .
		'FROM ' . $prefix . 'user ' .
		'WHERE change_password = ' . $this->db->q(hash_hmac('sha256', $code, $this->db->system_seed_hash)) . ' ' .
		'LIMIT 1');

	if (!$user)
	{
		$this->set_message($this->_t('WrongCode'), 'error');
	}
}
else
{
	$user = $this->get_user();
}

$action = $_POST['_action'] ?? null;

// both change password forms processed here: usual password change, and forgotten password reset
if ($action === 'change_password' && $user)
{
	if (!$code && !$this->password_verify($user, $_POST['password']))
	{
		// wrong current password
		$error = $this->_t('WrongPassword');
		$this->login_delay();
		$this->log(3, Ut::perc_replace($this->_t('LogUserPasswordMismatch', SYSTEM_LANG), $user['user_name']));
	}
	else
	{
		$new_password	= $_POST['new_password'];
		$conf_password	= $_POST['conf_password'];
		$complexity		= $this->password_complexity($user['user_name'], $new_password);

		if ($conf_password != $new_password)
		{
			$error = $this->_t('PasswordsDidntMatch');
		}
		else if ($complexity)
		{
			$error = $complexity;
		}
		else
		{
			$this->db->sql_query(
				'UPDATE ' . $prefix . 'user SET ' .
					"change_password	= '', " .
					'password			= ' . $this->db->q($this->password_hash($user, $new_password)) . ' ' .
				'WHERE user_id = ' . (int) $user['user_id'] . ' ' .
				'LIMIT 1');

			$diag = $code? 'LogUserPasswordRecovered' : 'LogUserPasswordChanged';
			$this->log(3, Ut::perc_replace($this->_t($diag, SYSTEM_LANG), $user['user_name']));
			$this->set_message($this->_t('PasswordChanged'), 'success');

			$this->logout_user();
			$this->context[++$this->current_context] = ''; // STS what's that?!
			$this->login_page();
			// NEVER BEEN HERE
		}
	}

	$this->set_message($error, 'error');
}

// guest user, password forgotten, send mail
if ($action === 'forgot_password')
{
	$user_name	= Ut::strip_spaces($_POST['user_name']);
	$email		= Ut::strip_spaces($_POST['email']);
	$user		= $this->db->load_single(
					'SELECT u.user_id, u.user_name, u.email, u.email_confirm, s.user_lang ' .
					'FROM ' . $prefix . 'user u ' .
						'LEFT JOIN ' . $prefix . 'user_setting s ON (u.user_id = s.user_id) ' .
					'WHERE u.user_name = ' . $this->db->q($user_name) . ' ' .
						'AND u.email = ' . $this->db->q($email) . ' ' .
					'LIMIT 1');

	if (!$user)
	{
		$error = $this->_t('UserNotFound');
	}
	else if (!$this->db->enable_email || $user['email_confirm'])
	{
		$error = $this->_t('NotConfirmedEmail');
	}
	else
	{
		$code		= Ut::random_token(21);
		$code_hash	= hash_hmac('sha256', $code, $this->db->system_seed_hash);

		// update table
		$this->db->sql_query(
			'UPDATE ' . $prefix . 'user SET ' .
				'password_request_count	= password_request_count + 1, ' . // value unused
				'change_password		= ' . $this->db->q($code_hash) . ' ' .
			'WHERE user_id = ' . (int) $user['user_id'] . ' ' .
			'LIMIT 1');

		// send code
		$this->notify_password_reset($user, $code);

		// log event
		$this->log(3, Ut::perc_replace($this->_t('LogUserPasswordReminded', SYSTEM_LANG), $user['user_name'], $user['email']));

		$this->set_message($this->_t('CodeWasSent'), 'success');
		$this->login_page();
		// NEVER BEEN HERE
	}

	$this->set_message($error, 'error');
}

// POST processing complete, let's enforce GET method
$_POST && $this->show_must_go_on($code? ['secret_code' => $code] : []);

if ($user)
{
	// check for members of Admins group
	$is_admin = false;

	if ($this->is_admin())
	{
		$is_admin = true;
	}
	else if (isset($this->db->groups['Admins']) && is_array($this->db->groups['Admins']))
	{
		if (in_array($user['user_id'], $this->db->groups['Admins']))
		{
			$is_admin = true;
		}
	}

	// a. change password
	$tpl->enter('c_');

	if ($code)
	{
		$tpl->title			= $this->format(Ut::perc_replace($this->_t('ChangePasswordForUser'), $user['user_name']));
		$tpl->secret_code	= $code;
	}
	else
	{
		$tpl->title			= $this->format_t('YouWantChangePassword');
		$tpl->current		= true;
	}

	$tpl->autocomplete		= $this->form_autocomplete_off();
	$tpl->complexity		= $this->show_password_complexity();
	$tpl->minchars			= $is_admin ? $this->db->pwd_admin_min_chars : $this->db->pwd_min_chars;
	$tpl->form				= $this->href();

	$tpl->leave(); // c_
}
else
{
	// b. reset forgotten password
	$tpl->f_form			= $this->href();
	$tpl->f_pattern			= self::PATTERN['USER_NAME'];
	$tpl->f_only			=
		Ut::perc_replace($this->_t($this->db->disable_wikiname? 'NameAlphanumOnly' : 'NameCamelCaseOnly'),
			$this->db->username_chars_min,
			$this->db->username_chars_max);
}
