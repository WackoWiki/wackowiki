<?php

if (!defined('IN_WACKO'))
{
	exit;
}

echo "<!--notypo-->\n";
$include_tail = "<!--/notypo-->\n";

// reconnect securely in tls mode
$param = isset($_GET['goback'])?  'goback=' . rawurlencode($_GET['goback']) : '';
$this->http->ensure_tls($this->href('', '', $param));
// was: $this->http->ensure_tls($this->href('', $this->_t('LoginPage'), "goback=".stripslashes(htmlspecialchars($_GET['goback'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) )));

$uncache = 'cache=' . Ut::random_token(5);

// actions
if (@$_GET['action'] === 'clearcookies')
{
	foreach ($_COOKIE as $name => $value)
	{
		$this->delete_cookie($name, false);
	}

	$this->http->redirect($this->href('', '', $uncache));
}

// hide article H1 header
$this->hide_article_header = true;

// logout
if (@$_GET['action'] === 'logout')
{
	$this->log(5, Ut::perc_replace($this->_t('LogUserLoggedOut', SYSTEM_LANG), $this->get_user_name()));
	$this->log_user_out();
	$this->set_menu(MENU_DEFAULT);
	$this->set_message($this->_t('LoggedOut'), 'success');
	$this->context[++$this->current_context] = '';

	$this->http->redirect($this->href('', @$_GET['goback'], $uncache));
}

if (($user = $this->get_user()))
{
	// user is logged in; display logout form
	echo $this->form_open('logout', ['form_method' => 'get']); // STS TODO refactor

	echo '<input type="hidden" name="action" value="logout" />';
	echo '<div class="cssform">';
	echo '<h3>'.$this->_t('Hello').", ".$this->compose_link_to_page($this->db->users_page.'/'.$user['user_name'], '', $user['user_name']).'!</h3>';

	if ($user['last_visit'] != SQL_DATE_NULL)
	{
		$this->set_message($this->_t('LastVisit') .
			' <code>' .
			$this->get_time_formatted($user['last_visit']) .
			'</code>');
	}

	/* STS meaning lost, seems like to be removed -- better add printing of latest security log
	$cookie = explode(';', $this->get_cookie(AUTH_TOKEN));

	$this->set_message($this->_t('SessionEnds') .
		' <code>' .
		$this->get_unix_time_formatted($cookie[2]) .  // session expiry date
		'</code> ' .
		'(' . $this->get_time_interval($cookie[2] - time(), true) . ')'); // session time left
	*/

	// Only allow your session to be used from this IP address.
	$this->set_message($this->_t('BindSessionIp') . ' '.
		($user['validate_ip']? $this->_t('BindSessionIpOn') . ' ' : '') .
		'<code>' .
		($user['validate_ip']? $user['ip'] : 'Off') .
		'</code>');

	if ($this->db->tls || $this->db->tls_proxy)
	{
		$this->set_message($this->_t('TrafficProtection') .
			' <code>' .
			( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? $_SERVER['SSL_CIPHER'].' ('.$_SERVER['SSL_PROTOCOL'].')' : 'no' ) .
			'</code>');
	}

	echo '<p><a href="' . $this->href('', '', 'action=logout') . '" style="text-decoration: none;">';
	echo '<input type="button" class="CancelBtn" value="' . $this->_t('LogoutButton') . '"/></a></p>';
	echo '<p>' . $this->compose_link_to_page($this->_t('AccountLink'), '', $this->_t('AccountText'), 0) .
		' | <a href="' . $this->href('', '', 'action=clearcookies') . '">' . $this->_t('ClearCookies') . '</a></p>';
	echo '</div>';

	echo $this->form_close();
}
else // login
{
	// user is not logged in
	$error = '';

	// is user trying to log in or register?
	if (@$_POST['_action'] === 'login')
	{
		$_user_name = Ut::strip_spaces($_POST['user_name']);

		// if user name already exists, check password
		if (($existing_user = $this->load_user($_user_name)))
		{
			// check for disabled account
			if (!$existing_user['enabled'] || $existing_user['account_type'])
			{
				if ($existing_user['account_status'] == 1)
				{
					$error .= $this->_t('UserApprovalPending');
				}
				else
				{
					$error .= $this->_t('AccountDisabled');
				}
			}
			else
			{
				// Start Login Captcha, if there are too much login attempts (max_login_attempts)
				if ($this->db->max_login_attempts && $existing_user['failed_login_count'] >= $this->db->max_login_attempts + 1)
				{
					if (!$this->validate_captcha())
					{
						$error .= $this->_t('CaptchaFailed');
					}
				}

				$this->sess->failed_login_count = $existing_user['failed_login_count'];

				if (!$error)
				{
					$_password = $_POST['password'];

					// check for old password formats
					$oldlen = strlen($existing_user['password']);
					if ($oldlen == 32 || $oldlen == 64)
					{
						if ($oldlen == 32)
						{
							$hash = hash('md5', $_password);
						}
						// check for old sha256 password
						else
						{
							// load old salt
							$password_salt = $this->db->load_single(
												"SELECT salt ".
													"FROM ".$this->db->user_table." ".
													"WHERE user_name = ".$this->db->q($_user_name)." ".
													"LIMIT 1");
							$hash = hash('sha256', $_user_name.$password_salt['salt'].$_password);
						}

						// rehash password
						if ($existing_user['password'] == $hash)
						{
							$hash = $this->password_hash($existing_user, $_password);

							// update database with the sha256 password for future logins
							$this->db->sql_query(
								"UPDATE ".$this->db->table_prefix."user SET ".
									"password	= ".$this->db->q($hash).", ".
									"salt		= '' ".
								"WHERE user_name = ".$this->db->q($_user_name));

							$existing_user['password'] = $hash;
						}
					}

					// check password
					if ($this->password_verify($existing_user, $_password))
					{
						$this->log_user_in($existing_user, isset($_POST['persistent']));
						$this->set_user($existing_user);
						$this->context[++$this->current_context] = '';

						$this->log(3, Ut::perc_replace($this->_t('LogUserLoginOK', SYSTEM_LANG), $existing_user['user_name']));

						// run in tls mode?
						if ($this->db->tls)
						{
							$this->http->secure_base_url();
						}

						$this->http->redirect($this->href('', @$_GET['goback'], $uncache));
					}
					else
					{
						$error .= $this->_t('WrongPassword');
						$this->log_user_delay();

						$this->set_failed_user_login_count($existing_user['user_id']);

						// log failed attempt
						$this->log(2, Ut::perc_replace($this->_t('LogUserLoginFailed', SYSTEM_LANG), $_user_name));
					}
				}
			}
		}
	}

	$_failed_login_count = isset($this->sess->failed_login_count) ? $this->sess->failed_login_count : 0;

	if ($error)
	{
		$this->show_message($this->format($error), 'error');
	}
	else if ($this->db->max_login_attempts && $_failed_login_count >= $this->db->max_login_attempts)
	{
		$this->show_message($this->_t('LoginAttemtsExceeded'), 'error');
	}

	echo '<div class="cssform">'."\n";
	echo '<h3>'.$this->_t('LoginWelcome').'</h3>'."\n";

	echo $this->form_open('login');
	echo '<input type="hidden" name="goback" value="' . Ut::html(@$_GET['goback']) . '" />' . "\n";

	echo '<p>';
	echo '<label for="user_name">'.$this->format_t('LoginName').':</label>';
	echo '<input type="text" id="user_name" name="user_name" size="25" maxlength="80" value="' . @$_user_name . '" tabindex="1" required autofocus />' . "\n";
	echo '</p>' . "\n";

	echo '<p>';
	echo '<label for="password">'.$this->_t('LoginPassword').':</label>'."\n";
	echo '<input type="password" id="password" name="password" size="25" tabindex="2" autocomplete="off" required />'."\n";
	echo '</p>';

	echo '<p>'."\n";
	echo '<input type="checkbox" id="persistent" name="persistent" tabindex="3"/>'."\n";
	echo '<label for="persistent">'.$this->_t('PersistentCookie').'</label>'."\n";
	echo '</p>'."\n";

	if ($this->db->max_login_attempts && $_failed_login_count >= $this->db->max_login_attempts)
	{
		echo '<p>';
		echo $this->show_captcha();
		echo '</p>';
	}

	echo '<p>'."\n";
	echo '<input type="submit" class="OkBtn" value="'.$this->_t('LoginButton').'" tabindex="4" />'."\n";
	// echo '&nbsp;&nbsp;&nbsp;<small><a href="?action=clearcookies">'.$this->_t('ClearCookies').'</a></small>';
	echo '</p>'."\n";
	echo '<p>'.$this->format_t('ForgotLink').'</p>'."\n";

	if ($this->db->allow_registration)
	{
		echo '<p>'.$this->format_t('LoginWelcome2').'</p>'."\n";
	}

	echo $this->form_close();
	echo '</div>'."\n";
}
