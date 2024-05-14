<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Displays the settings page for registered users and the registration page for guests.

Usage:
	{{usersettings}}
EOD;

// set defaults
$help		??= 0;

if ($help)
{
	$tpl->help	= $this->help($info, 'usersettings');
	return;
}

$mod_selector	= 'o';
$tabs			= [
					''				=> 'UserSettingsGeneral',
					'menu'			=> 'Bookmarks',
					'notification'	=> 'UserSettingsNotifications',
					'extended'		=> 'UserSettingsExtended'
				];
$mode			= $_GET[$mod_selector] ?? (@$_POST['_user_menu'] ? 'menu' : '');

if (!array_key_exists($mode, $tabs))
{
	$mode = '';
}

// reconnect securely in tls mode
$this->http->ensure_tls($this->href());

// hide article H1 header
$this->hide_article_header = true;

// email confirmation
if (isset($_GET['confirm']))
{
	$this->user_email_confirm_check($_GET['confirm']);
}
else if (@$_GET['action'] === 'logout')
{
	$this->logout_user();
	$this->show_must_go_on();
}
else if ($user = $this->get_user())
{
	$email_changed	= false;
	$user			= $this->load_user('', $user['user_id']);
	$action			= $_POST['_action'] ?? null;
	$real_name		= $this->sanitize_text_field(($_POST['real_name'] ?? ''), true);
	$email			= $_POST['email'] ?? '';
	$resend_code	= (int) ($_GET['resend_code'] ?? null);
	$sql			= '';

	$this->set_page_lang($this->user_lang);

	// is user trying to update?
	if ($action == 'user_settings_general')
	{
		$error = '';

		if ($message = $this->validate_email($email, false))
		{
			$error .= $message;
		}

		// check for errors and store
		if ($error)
		{
			$this->set_message($error, 'error');
		}
		else
		{
			$email_changed = ($user['email'] != $email);

			// store if email hasn't been changed otherwise request authorization
			if ($email_changed || $real_name)
			{
				// update users table
				$this->db->sql_query(
					'UPDATE ' . $this->prefix . 'user SET ' .
						'real_name		= ' . $this->db->q(trim($real_name)) . ', ' .
						'email			= ' . $this->db->q($email) . ' ' .
					'WHERE user_id = ' . (int) $user['user_id'] . ' ' .
					'LIMIT 1');

				// log event
				# $this->log(6, Ut::perc_replace($this->_t('LogUserSettingsUpdate', SYSTEM_LANG), $user['user_name']));
			}
		}
	}

	// update changed user settings
	if ($action == 'user_settings_extended')
	{
		$sql =
		'doubleclick_edit	= ' . (int) isset($_POST['doubleclick_edit']) . ', ' .
		'show_comments		= ' . (int) isset($_POST['show_comments']) . ', ' .
		'show_spaces		= ' . (int) isset($_POST['show_spaces']) . ', ' .
		'autocomplete		= ' . (int) isset($_POST['autocomplete']) . ', ' .
		'numerate_links		= ' . (int) isset($_POST['numerate_links']) . ', ' .
		'diff_mode			= ' . (int) $_POST['diff_mode'] . ', ' .
		'dont_redirect		= ' . (int) isset($_POST['dont_redirect']) . ', ' .
		'show_files			= ' . (int) isset($_POST['show_files']) . ', ' .
		'hide_lastsession	= ' . (int) isset($_POST['hide_lastsession']) . ', ' .
		'validate_ip		= ' . (int) isset($_POST['validate_ip']) . ', ' .
		'noid_pubs			= ' . (int) isset($_POST['noid_pubs']) . ', ' .
		'session_length		= ' . (int) @$_POST['session_length'] . ' '; // @ to normalize possible discrepancy
	}
	else if ($action == 'user_settings_notifications')
	{
		$sql =
		'send_watchmail		= ' . (int) isset($_POST['send_watchmail']) . ', ' .
		'allow_intercom		= ' . (int) isset($_POST['allow_intercom']) . ', ' .
		'notify_minor_edit	= ' . (int) isset($_POST['notify_minor_edit']) . ', ' .
		'notify_page		= ' . (int) @$_POST['notify_page'] . ', ' .		// @ to notify possible discrepancy
		'notify_comment		= ' . (int) @$_POST['notify_comment'] . ', ' .	// @ to notify possible discrepancy
		'allow_massemail	= ' . (int) isset($_POST['allow_massemail']) . ' ';
	}
	else if ($action == 'user_settings_general')
	{
		$user_lang	= $this->validate_language($_POST['user_lang']);
		$theme		= $this->validate_theme($_POST['theme']);
		$timezone	= $this->validate_timezone($_POST['timezone']);

		$sql =
		'user_lang			= ' . $this->db->q($user_lang) . ', ' .
		'theme				= ' . $this->db->q($theme) . ', ' .
		'timezone			= ' . $this->db->q($timezone) . ', ' .
		'sorting_comments	= ' . (int) $_POST['sorting_comments'] . ', ' .
		'menu_items			= ' . (int) $_POST['menu_items'] . ', ' .
		'list_count			= ' . (int) $_POST['list_count'] . ' ';
	}

	if ($sql)
	{
		// update user_setting table
		$this->db->sql_query(
			'UPDATE ' . $this->prefix . 'user_setting SET ' .
				$sql .
			'WHERE user_id = ' . (int) $user['user_id'] . ' ' .
			'LIMIT 1');

		// log event
		$this->log(6, Ut::perc_replace($this->_t('LogUserSettingsUpdate', SYSTEM_LANG), $user['user_name']));
	}

	// (re)send email confirmation code
	if ($this->db->enable_email && ($resend_code || $email_changed))
	{
		if ($email_changed)
		{
			$user['email'] = $email;
		}

		$this->notify_email_confirm($user);
	}

	// reload user data
	if ($sql || $resend_code)
	{
		$user = $this->load_user('', $user['user_id']);
		$this->set_user($user);

		$this->set_message($this->_t('UserSettingsStored', @$_POST['user_lang']), 'success');

		// forward
		if ($action == 'user_settings_extended')
		{
			$tab = 'extended';
		}
		else if ($action == 'user_settings_notifications')
		{
			$tab = 'notification';
		}
		else
		{
			$tab = '';
		}

		$this->http->redirect($this->href('', '', [$mod_selector => $tab]));
	}

	// print navigation
	$tpl->h_header	= $this->_t($tabs[$mode]);
	$tpl->h_tabs	= $this->tab_menu($tabs, $mode, '', [], $mod_selector);

	// MENU
	if ($mode == 'menu' || isset($_POST['_user_menu']))
	{
		$tpl->menu_action	= $this->action('menu');
	}
	// NOTIFICATIONS
	else if ($mode == 'notification' || $action == 'user_settings_notifications')
	{
		$tpl->enter('n_');

		$tpl->massemail		= $user['allow_massemail'];

		if ($this->db->enable_email && $this->db->enable_email_notification)
		{
			$tpl->enter('e_');

			$tpl->watchmail		= $user['send_watchmail'];
			$tpl->notifypage	= $user['notify_page'];
			$tpl->notifycomment	= $user['notify_comment'];
			$tpl->intercom		= $user['allow_intercom'];

			// minor edit
			if ($this->page && $this->db->minor_edit)
			{
				$tpl->m_minor	= $user['notify_minor_edit'];
			}

			$tpl->leave();
		}

		$tpl->leave();
	}
	// EXTENDED
	else if ($mode == 'extended' || $action == 'user_settings_extended')
	{
		$tpl->enter('e_');

		$tpl->doubleclick		= $user['doubleclick_edit'];
		$tpl->autocomplete		= $user['autocomplete'];
		$tpl->numerate			= $user['numerate_links'];
		$tpl->showcomments		= $user['show_comments'];
		$tpl->showfiles			= $user['show_files'];
		$tpl->showspaces		= $user['show_spaces'];
		$tpl->noredirect		= $user['dont_redirect'];
		$tpl->validateip		= $user['validate_ip'];
		$tpl->hidesession		= $user['hide_lastsession'];
		$tpl->sessionlength		= $user['session_length'];

		if ($this->db->publish_anonymously)
		{
			$tpl->anon_hidesession	= $user['noid_pubs'];
		}

		$default_mode		= $user['diff_mode'] ?: $this->db->default_diff_mode;
		$diff_modes			= $this->_t('DiffMode');
		$diff_mode_list		= explode(',', $this->db->diff_modes);

		foreach($diff_mode_list as $mode)
		{
			$tpl->o_id		= $mode;
			$tpl->o_mode	= $diff_modes[$mode];
			$tpl->o_sel		= (int) (isset($mode) && $default_mode == $mode);
		}

		$tpl->leave();
	}
	// GENERAL
	else
	{
		// user is logged in, display config form
		$tpl->enter('g_');

		$code = $this->db->load_single(
			'SELECT email_confirm ' .
			'FROM ' . $this->prefix . 'user ' .
			'WHERE user_id = ' . (int) $user['user_id'] . ' ' .
			'LIMIT 1');

		$tpl->user			= $user; // array
		$tpl->userlink		= $this->user_link($user['user_name'], true, false);
		$tpl->realname		= $user['real_name'];
		$tpl->href			= $this->href('', $this->db->password_page);
		$tpl->email			= $user['email'];

		if (!$user['email_confirm'])
		{
			$tpl->confirm	= $this->_t('EmailConfirmed');
			$tpl->icon		= 'btn-tick btn-sm';
		}
		else
		{
			$tpl->confirm	= $this->_t('EmailConfirm');
			$tpl->icon		= 'btn-warning btn-sm';
		}

		if (!$user['email'] || $code['email_confirm'])
		{
			$tpl->verify_href	= $this->href('', '', ['resend_code' => 1]);
		}

		$user_lang			= $user['user_lang'] ?: $this->db->language;
		$tpl->lang			= $this->show_select_lang('user_lang', $user_lang, false);

		$a_theme		= $user['theme'] ?: $this->db->theme;
		$themes			= $this->available_themes();

		foreach ($themes as $theme)
		{
			$tpl->t_theme	= $theme;
			$tpl->t_sel		= (int) (isset($a_theme) && $a_theme == $theme);
		}

		$a_zone			= $user['timezone'] ?: $this->db->timezone;

		foreach ($this->timezone_list() as $offset => $timezone)
		{
			$tpl->z_timezone	= $timezone;
			$tpl->z_sel			= (int) (isset($a_zone) && $a_zone == $offset);
			$tpl->z_offset		= $offset;
		}

		$tpl->sortcomments	= $user['sorting_comments'];
		$tpl->menuitems		= $user['menu_items'];
		$tpl->listcount		= $user['list_count'];

		$tpl->logout		= $this->href('', '', ['action' => 'logout']);

		$percentage			= 0 . '%';
		$upload_quota		= $this->upload_quota($user['user_id']);

		if ($this->db->upload_quota_per_user)
		{
			$tpl->percentage = ' (' . round(($upload_quota / (($this->db->upload_quota_per_user) / 100)) ) . '%)';
		}

		$tpl->userpage		= $this->href('', ($this->db->users_page . '/' . $user['user_name']));
		$tpl->quota			= $this->factor_multiples($upload_quota, 'binary', true, true);
		$tpl->pages			= $this->href('', $this->db->users_page, 'profile=' . $user['user_name'], '', 'pages');
		$tpl->comments		= $this->href('', $this->db->users_page, 'profile=' . $user['user_name'], '', 'comments');
		$tpl->uploads		= $this->href('', $this->db->users_page, 'profile=' . $user['user_name'], '', 'uploads');

		$tpl->leave();
	}
}
else
{
	// user is not logged in
	$this->login_page();
}
