<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<!--notypo-->
<?php

$error = '';
$output = '';
$user_name = '';

// reconnect securely in tls mode
#if ($this->config['tls'] == true && $this->config['tls_implicit'] == true && ( ($_SERVER['HTTPS'] != 'on' && empty($this->config['tls_proxy'])) || $_SERVER['SERVER_PORT'] != '443' ))
if ($this->config['tls'] == true && ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'on' && empty($this->config['tls_proxy'])) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '443' ) ))
{
	$this->redirect(str_replace('http://', 'https://'.(!empty($this->config['tls_proxy']) ? $this->config['tls_proxy'].'/' : ''), $this->href('', $this->get_translation('LoginPage'), "goback=".stripslashes(htmlspecialchars($_GET['goback']) )) ));
}

// actions
if (isset($_GET['action']) && $_GET['action'] == 'clearcookies')
{
	foreach ($_COOKIE as $name => $value)
	{
		$this->delete_cookie($name, false, false);
	}

	$_POST['action'] = 'logout';
}

// logout
if (isset($_GET['action']) && $_GET['action'] == 'logout')
{
	$this->log(5, str_replace('%1', $this->get_user_name(), $this->get_translation('LogUserLoggedOut', $this->config['language'])));
	$this->logout_user();
	$this->set_menu(MENU_DEFAULT);
	$this->set_message($this->get_translation('LoggedOut'));
	$this->context[++$this->current_context] = '';

	if (!empty($_GET['goback']))
	{
		$this->redirect($this->href('', stripslashes(htmlspecialchars($_GET['goback'])), 'cache='.rand(0,1000)));
	}
	else
	{
		$this->redirect($this->href('', '', 'cache='.rand(0,1000)));
	}
}
// logged in
else if ($user = $this->get_user())
{
	// user is logged in; display logout form
	echo $this->form_open();

	echo '<input type="hidden" name="action" value="logout" />';
	echo '<div class="cssform">';
	echo '<h3>'.$this->get_translation('Hello').", ".$this->compose_link_to_page($this->config['users_page'].'/'.$user['user_name'], '', $user['user_name']).'!</h3>';

	if ($user['session_time'] == true)
	{
		$output .= $this->get_translation('LastVisit').' <tt>'. $this->get_time_string_formatted($user['session_time'])."</tt>.<br />";
	}

	$output .= $this->get_translation('SessionEnds').' <tt>';

	$cookie = explode(';', $this->get_cookie('auth'));
	// session expiry date
	$output .= $this->get_unix_time_formatted($cookie[2]).'</tt> ';
	// session time left
	$time_diff = $cookie[2] - time();

	if ($time_diff > 2 * 24 * 3600)
	{
		$output .= '(in '.ceil($time_diff / 24 / 3600).' days).';
	}
	else if ($time_diff > 5 * 3600)
	{
		$output .= '(in '.ceil($time_diff / 3600).' hours).';
	}
	else
	{
		$output .= '(in '.ceil($time_diff / 60).' minutes).';
	}

	$output .= '<br />';

	// Only allow your session to be used from this IP address.
	$output .= $this->get_translation('BindSessionIp').' '. ( $user['validate_ip'] == 1 ? $this->get_translation('BindSessionIpOn').' <tt>'.$user['ip'].'</tt>)' : '<tt>Off</tt>' ).".<br />";

	if ($this->config['tls'] == true || $this->config['tls_proxy'] == true)
	{
		$output .= $this->get_translation('TrafficProtection').' <tt>'. ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? $_SERVER['SSL_CIPHER'].' ('.$_SERVER['SSL_PROTOCOL'].')' : 'no' )."</tt>.";
	}

	$this->set_message($output);

	echo "<p><input class=\"CancelBtn\" type=\"button\" value=\"".$this->get_translation('LogoutButton')."\" onclick=\"document.location='".$this->href('', '', 'action=logout')."'\" /></p>";
	echo '<p>'.$this->compose_link_to_page($this->get_translation('AccountLink'), '', $this->get_translation('AccountText'), 0).' | <a href="?action=clearcookies">'.$this->get_translation('ClearCookies').'</a></p>';
	echo '</div>';

	echo $this->form_close();
}
// login
else
{
	// user is not logged in
	$focus = 0;

	// is user trying to log in or register?
	if (isset($_POST['action']) && $_POST['action'] == 'login')
	{
		// if user name already exists, check password
		if ($existing_user = $this->load_user($_POST['user_name']))
		{
			// check for disabled account
			if (($existing_user['enabled'] == false) || $existing_user['account_type'] != 0 )
			{
				$error = $this->get_translation('AccountDisabled');
			}
			else
			{
				// Start Login Captcha, if there are too much login attempts (max_login_attempts)

				// Only show captcha if the admin enabled it in the config file
				if($this->config['max_login_attempts'] && $existing_user['failed_login_count'] >= $this->config['max_login_attempts'] + 1)
				{
					// captcha validation
					if ($this->validate_captcha() === false)
					{
						$error = $this->get_translation('CaptchaFailed');
					}
				}
				// End Registration Captcha

				$_SESSION['failed_login_count'] = $existing_user['failed_login_count'];

				if (!$error)
				{
					// check for old md5 password
					if (strlen($existing_user['password']) < 64)
					{
						if (strlen($existing_user['password']) == 32)
						{
							$_processed_password = hash('md5', $_POST['password']);
						}
						else if (strlen($existing_user['password']) == 40) // only for dev versions / can be removed after successful migration of all passwords
						{
							$_processed_password = hash('sha1', $_POST['user_name'].$existing_user['salt'].$_POST['password']);
						}

						if ($existing_user['password'] == $_processed_password)
						{
							$salt		= $this->random_password(10, 3);
							$password	= hash('sha256', $_POST['user_name'].$salt.$_POST['password']);

							// update database with the sha256 password for future logins
							$this->sql_query(
								"UPDATE ".$this->config['table_prefix']."user SET ".
									"password	= '".quote($this->dblink, $password)."', ".
									"salt		= '".quote($this->dblink, $salt)."' ".
								"WHERE user_name = '".quote($this->dblink, $_POST['user_name'])."'");
						}
					}
					else
					{
						$_processed_password = hash('sha256', $_POST['user_name'].$existing_user['salt'].$_POST['password']);
					}

					// check password
					if ($existing_user['password'] == $_processed_password)
					{
						// define session duration in days
						$_session = isset($_POST['session']) ? $_POST['session'] : null;

						if (!empty($existing_user['session_expiration']))
						{
							$session = $existing_user['session_expiration'];
						}
						else
						{
							$session = $this->config['session_expiration'];
						}

						$_persistent = isset($_POST['persistent']) ? $_POST['persistent'] : 0;

						$this->log_user_in($existing_user, $_persistent, $session);
						$this->set_user($existing_user, 1);
						$this->update_session_time($existing_user);
						$this->set_menu(MENU_USER);
						$this->context[++$this->current_context] = '';

						$this->login_count($existing_user['user_id']);
						$this->reset_failed_user_login_count($existing_user['user_id']);
						$this->reset_lost_password_count($existing_user['user_id']);

						$this->log(3, str_replace('%1', $existing_user['user_name'], $this->get_translation('LogUserLoginOK', $this->config['language'])));

						// run in tls mode?
						if ($this->config['tls'] == true)
						{
							$this->config['base_url'] = str_replace('http://', 'https://'.($this->config['tls_proxy'] ? $this->config['tls_proxy'].'/' : ''), $this->config['base_url']);
						}

						if (!empty($_POST['goback']))
						{
							$this->redirect($this->href('', stripslashes($_POST['goback']), 'cache='.rand(0,1000)));
						}
						else
						{
							$this->redirect($this->href('', '', 'cache='.rand(0,1000)));
						}
					}
					else
					{
						$error		= $this->get_translation('WrongPassword');
						$user_name	= $_POST['user_name'];
						$focus		= 1;

						$this->set_failed_user_login_count($existing_user['user_id']);

						// log failed attempt
						$this->log(2, str_replace('%1', $_POST['user_name'], $this->get_translation('LogUserLoginFailed', $this->config['language'])));
					}
				}
			}
		}
	}

	$_failed_login_count = isset($_SESSION['failed_login_count']) ? $_SESSION['failed_login_count'] : 0;

	if ($error)
	{
		# $this->set_message($error);
		echo '<div class="error">'.$this->format($error).'</div>';
	}
	else if($this->config['max_login_attempts'] && $_failed_login_count >= $this->config['max_login_attempts'])
	{
		echo '<div class="error">'.$this->get_translation('LoginAttemtsExceeded').'</div>';
	}

	echo '<div class="cssform">'."\n";
	echo '<h3>'.$this->get_translation('LoginWelcome').'</h3>'."\n";

	echo $this->form_open();
	echo '<input type="hidden" name="action" value="login" />'."\n";
	echo '<input type="hidden" name="goback" value="'.(isset($_GET['goback']) ? stripslashes(htmlspecialchars($_GET['goback'])) : '').'" />'."\n";
	echo '<p>';
	echo '<label for="user_name">'.$this->format_translation('LoginName').':</label>';
	echo '<input id="user_name" name="user_name" size="25" maxlength="25" value="'.(isset($user_name) ? $user_name : '').'" tabindex="1" />'."\n";
	echo '</p>'."\n";
	echo '<p>';
	echo '<label for="password">'.$this->get_translation('LoginPassword').':</label>'."\n";
	echo '<input id="password" type="password" name="password" size="25" tabindex="2" autocomplete="off" />'."\n";
	echo '</p>';
	echo '<p>'."\n";
	echo '<input id="persistent" name="persistent" value="1" type="checkbox" tabindex="3"/>'."\n";
	echo '<label for="persistent">'.$this->get_translation('PersistentCookie').'</label>'."\n";
	echo '</p>'."\n";

	// captcha code starts

	// Only show captcha if the admin enabled it in the config file
	if($this->config['max_login_attempts'] && $_failed_login_count >= $this->config['max_login_attempts'])
	{
		echo '<p>';
		$this->show_captcha();
		echo '</p>';
	}
	// end captcha

	echo '<p>'."\n";
	echo '<input class="OkBtn" type="submit" value="'.$this->get_translation('LoginButton').'" tabindex="4" />'."\n";
	#echo '&nbsp;&nbsp;&nbsp;<small><a href="?action=clearcookies">Delete all cookies</a></small>';
	echo '</p>'."\n";
	echo '<p>'.$this->format_translation('ForgotLink').'</p>'."\n";

	if ($this->config['allow_registration'] == true)
	{
		echo '<p>'.$this->format_translation('LoginWelcome2').'</p>'."\n";
	}

	echo '<script type="text/javascript">';
	echo '	document.getElementById("f'.$focus.'").focus();';
	echo '</script>';

	echo $this->form_close();
	echo '</div>'."\n";
}
?>
<!--/notypo-->