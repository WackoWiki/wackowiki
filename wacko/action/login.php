<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// reconnect securely in tls mode
$this->http->ensure_tls($this->href());

$this->no_way_back = true; // prevent goback'ing that page

// actions
if (@$_GET['action'] === 'clearcookies')
{
	foreach ($_COOKIE as $name => $dummy)
	{
		$this->sess->unsetcookie($name);
	}

	$this->login_page();
}

// hide article H1 header
$this->hide_article_header = true;

// logout
if (@$_GET['action'] === 'logout')
{
	$this->context[++$this->current_context] = ''; // TODO ?!
	$this->log_user_out();
	$this->go_back($this->db->root_page);
}

if (($user = $this->get_user()))
{
	// user is logged in; display logout form
	$tpl->u_href = $this->href();
	$tpl->u_link = $this->compose_link_to_page($this->db->users_page . '/' . $user['user_name'], '', $user['user_name']);

	$message = null;

	if (!$this->db->is_null_date($user['last_visit']))
	{
		$message .= $this->_t('LastVisit') .
			' <code>' .
			$this->get_time_formatted($user['last_visit']) .
			'</code>' . "<br />\n";
	}

	// Only allow your session to be used from this IP address.
	$message .= $this->_t('BindSessionIp') . ' '.
		($user['validate_ip']? $this->_t('BindSessionIpOn') . ' ' : '') .
		'<code>' .
		($user['validate_ip']? $user['ip'] : 'Off') .
		'</code>' . "<br />\n";

	if ($this->db->tls || $this->db->tls_proxy)
	{
		$message .= $this->_t('TrafficProtection') .
			' <code>' .
			(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? $_SERVER['SSL_CIPHER'] . ' (' . $_SERVER['SSL_PROTOCOL'] . ')' : 'no' ) .
			'</code>' . "<br />\n";
	}

	if (!empty($message))
	{
		$this->set_message($message);
	}

	$tpl->u_logout = $this->href('', '', 'action=logout');
	$tpl->u_account = $this->compose_link_to_page($this->_t('AccountLink'), '', $this->_t('AccountText'), 0);
	$tpl->u_cookies = $this->href('', '', 'action=clearcookies');
}
else // login
{
	// user is not logged in
	$logins = &$this->sess->sticky_login_count;
	isset($logins) or $logins = 0;

	if (@$_POST['_action'] === 'login')
	{
		++$logins;

		$user_name = Ut::strip_spaces($_POST['user_name']);
		$password = $_POST['password'];

		if ($this->sess->login_captcha && !$this->validate_captcha())
		{
			$error = $this->_t('CaptchaFailed');
		}
		else
		{
			// let's begin pessimistically ;)
			$error = $this->_t('LoginIncorrect');

			// if user name already exists, check password
			// check email dummy field in search for bots
			if (!$_POST['email'] && ($user = $this->load_user($user_name)))
			{
				if (($n = $user['failed_login_count']) > $logins)
				{
					$logins = $n;
				}

				// check for old password formats
				if (($n = strlen($user['password'])) == 32 || $n == 64)
				{
					if ($n == 32)
					{
						$hash = hash('md5', $password);
					}
					else
					{
						// check for old sha256 password
						// load old salt
						$salt = $this->db->load_single(
							"SELECT salt " .
							"FROM " . $this->db->user_table . " " .
							"WHERE user_name = " . $this->db->q($user_name) . " " .
							"LIMIT 1");
						$hash = hash('sha256', $user_name . $salt['salt'] . $password);
					}

					// rehash password
					if ($user['password'] == $hash)
					{
						$user['password'] = $hash = $this->password_hash($user, $password);

						// update database with the sha256 password for future logins
						$this->db->sql_query(
							"UPDATE " . $this->db->table_prefix . "user SET " .
								"password	= " . $this->db->q($hash) . ", " .
								"salt		= '' " .
							"WHERE user_name = " . $this->db->q($user_name));
					}
				}

				// check password
				if (!$this->password_verify($user, $password))
				{
					$this->set_failed_user_login_count($user['user_id']);
				}
				else
				{
					$logins = 0;

					// check for disabled account
					if (!$user['enabled'] || $user['account_type'])
					{
						$error = $this->_t(($user['account_status'] == 1)? 'UserApprovalPending' : 'AccountDisabled');
					}
					else
					{
						$this->log_user_in($user, isset($_POST['persistent']));
						$this->context[++$this->current_context] = ''; // STS what for?

						$this->log(3, Ut::perc_replace($this->_t('LogUserLoginOK', SYSTEM_LANG), $user['user_name']));

						$this->go_back($this->db->users_page . '/' . $user['user_name']);
					}
				}
			}
		}

		$this->sess->login_username = $user_name;
		$this->log(2, Ut::perc_replace($this->_t('LogUserLoginFailed', SYSTEM_LANG), $user_name));
		$this->set_message($error, 'error');
		$this->login_page();
	}

	$this->sess->login_captcha = 0;

	if ($logins)
	{
		$this->log_user_delay();

		if ($this->db->max_login_attempts && $logins > $this->db->max_login_attempts && ($cap = $this->show_captcha()))
		{
			$tpl->l_toomuch = true;
			$tpl->l_show_captcha = $cap;
			$this->sess->login_captcha = 1;
		}
	}

	$tpl->l_href = $this->href();
	$tpl->l_username = @$this->sess->login_username;

	if ($this->db->allow_registration)
	{
		$tpl->l_welcome = true;
	}
}
