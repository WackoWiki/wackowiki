<?php

if (!defined('IN_WACKO'))
{
	exit;
}

?>
<!--notypo-->
<?php

$error		= '';
$output		= '';
$user_name	= '';

// disable server cache for page
$this->no_cache(false);

// reconnect securely in tls mode
#if ($this->config['tls'] == true && $this->config['tls_implicit'] == true && ( ($_SERVER['HTTPS'] != 'on' && empty($this->config['tls_proxy'])) || $_SERVER['SERVER_PORT'] != '443' ))
if ($this->config['tls'] == true
&& ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'on' && empty($this->config['tls_proxy'])) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '443' ) ))
{
	$this->redirect(str_replace('http://', 'https://'.(!empty($this->config['tls_proxy']) ? $this->config['tls_proxy'].'/' : ''), $this->href('', $this->get_translation('LoginPage'), "goback=".stripslashes(htmlspecialchars($_GET['goback'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) )) ));
}

// actions
if (isset($_GET['action']) && $_GET['action'] == 'clearcookies')
{
	foreach ($_COOKIE as $name => $value)
	{
		$this->delete_cookie($name, false, false);
	}

	$_POST['action'] = 'logout';
	$this->redirect($this->href('', '', 'cache='.rand(0, 1000)));
}

// hide article H1 header
$this->config['hide_article_header'] = true;

// logout
if (isset($_GET['action']) && $_GET['action'] == 'logout')
{
	$this->log(5, str_replace('%1', $this->get_user_name(), $this->get_translation('LogUserLoggedOut', $this->config['language'])));
	$this->log_user_out();
	$this->set_menu(MENU_DEFAULT);
	$this->set_message($this->get_translation('LoggedOut')); // TODO: message is reset with session before it it can display the message set after the redirect
	$this->context[++$this->current_context] = '';

	if (!empty($_GET['goback']))
	{
		$this->redirect($this->href('', stripslashes(htmlspecialchars($_GET['goback'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)), 'cache='.rand(0, 1000)));
	}
	else
	{
		$this->redirect($this->href('', '', 'cache='.rand(0, 1000)));
	}
}
// logged in
else if ($user = $this->get_user())
{
	// user is logged in; display logout form
	echo $this->form_open('logout');

	echo '<input type="hidden" name="action" value="logout" />';
	echo '<div class="cssform">';
	echo '<h3>'.$this->get_translation('Hello').", ".$this->compose_link_to_page($this->config['users_page'].'/'.$user['user_name'], '', $user['user_name']).'!</h3>';

	if ($this->get_cookie('auth'))
	{
		if ($user['last_visit'] == true)
		{
			$output .= $this->get_translation('LastVisit').' <code>'. $this->get_time_formatted($user['last_visit']).'</code>.<br />';
		}

		$output .= $this->get_translation('SessionEnds').' <code>';

		$cookie = explode(';', $this->get_cookie('auth'));

		// session expiry date
		$output .= $this->get_unix_time_formatted($cookie[2]).'</code> ';
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
		$output .= $this->get_translation('BindSessionIp').' '. ( $user['validate_ip'] == 1 ? $this->get_translation('BindSessionIpOn').' <code>'.$user['ip'].'</code>)' : '<code>Off</code>' ).'.<br />';

		if ($this->config['tls'] == true || $this->config['tls_proxy'] == true)
		{
			$output .= $this->get_translation('TrafficProtection').' <code>'. ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? $_SERVER['SSL_CIPHER'].' ('.$_SERVER['SSL_PROTOCOL'].')' : 'no' ).'</code>.';
		}

		$this->set_message($output);
	}

	echo '<p><a href="'.$this->href('', '', 'action=logout').'" style="text-decoration: none;"><input type="button" class="CancelBtn" value="'.$this->get_translation('LogoutButton').'"/></a></p>';
	echo '<p>'.$this->compose_link_to_page($this->get_translation('AccountLink'), '', $this->get_translation('AccountText'), 0).' | <a href="'.$this->href('', '', 'action=clearcookies').'">'.$this->get_translation('ClearCookies').'</a></p>';
	echo '</div>';

	echo $this->form_close();
}
// login
else
{
	// user is not logged in

	// is user trying to log in or register?
	if (isset($_POST['action']) && $_POST['action'] == 'login')
	{
		// check form token
		if (!$this->validate_form_token('login'))
		{
			$error .= $this->get_translation('FormInvalid');
		}

		$_user_name = isset($_POST['user_name']) ? $_POST['user_name'] : '';

		// if user name already exists, check password
		if ($existing_user = $this->load_user($_user_name))
		{
			// check for disabled account
			if (($existing_user['enabled'] == false) || $existing_user['account_type'] != 0 )
			{
				if ($existing_user['account_status'] == 1)
				{
					$error .= $this->get_translation('UserApprovalPending');
				}
				else
				{
					$error .= $this->get_translation('AccountDisabled');
				}
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
						$error .= $this->get_translation('CaptchaFailed');
					}
				}
				// End Registration Captcha

				$_SESSION['failed_login_count'] = $existing_user['failed_login_count'];

				if (!$error)
				{
					$_password = isset($_POST['password']) ? $_POST['password'] : '';

					// check for old md5 password
					if (strlen($existing_user['password']) == 32 || strlen($existing_user['password']) == 64)
					{
						if (strlen($existing_user['password']) == 32)
						{
							$_processed_password = hash('md5', $_password);
						}

						// check for old sha256 password
						else if (strlen($existing_user['password']) == 64)
						{
							// load old salt
							$password_salt = $this->load_single(
												"SELECT salt ".
													"FROM ".$this->config['user_table']." ".
													"WHERE user_name = '".quote($this->dblink, $_user_name)."' ".
													"LIMIT 1");
							$_processed_password = hash('sha256', $_user_name.$password_salt['salt'].$_password);
						}

						// rehash password
						if ($existing_user['password'] == $_processed_password)
						{
							$_processed_password	= $_user_name.$_password;
							$password_hash	= password_hash(
													base64_encode(
															hash('sha256', $_processed_password, true)
															),
													PASSWORD_DEFAULT
													);

							// update database with the sha256 password for future logins
							$this->sql_query(
								"UPDATE ".$this->config['table_prefix']."user SET ".
									"password	= '".quote($this->dblink, $password_hash)."', ".
									"salt		= '' ".
								"WHERE user_name = '".quote($this->dblink, $_user_name)."'");

							// reload user with updated user password hash
							$existing_user = $this->load_user($_user_name);
						}
					}
					else
					{
						$_processed_password = $_user_name.$_password;
					}

					// check password
					if (password_verify(
							base64_encode(
									hash('sha256', $_processed_password, true)
									),
								$existing_user['password']
							)
						)
					{
						// define session duration in days
						if (!empty($existing_user['session_length']))
						{
							$session_length = $existing_user['session_length'];
						}
						else
						{
							$session_length = $this->config['session_length'];
						}

						$_persistent = isset($_POST['persistent']) ? $_POST['persistent'] : 0;

						$this->log_user_in($existing_user, $_persistent, $session_length);
						$this->set_user($existing_user, 1);
						$this->set_menu(MENU_USER);
						$this->context[++$this->current_context] = '';

						// TODO: merge into one function? 3 updates
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
							$this->redirect($this->href('', stripslashes(htmlspecialchars($_POST['goback'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)), 'cache='.rand(0, 1000)));
						}
						else
						{
							$this->redirect($this->href('', '', 'cache='.rand(0, 1000)));
						}
					}
					else
					{
						$error		.= $this->get_translation('WrongPassword');

						$this->set_failed_user_login_count($existing_user['user_id']);

						// log failed attempt
						$this->log(2, str_replace('%1', $_user_name, $this->get_translation('LogUserLoginFailed', $this->config['language'])));
					}
				}
			}
		}
	}

	$_failed_login_count = isset($_SESSION['failed_login_count']) ? $_SESSION['failed_login_count'] : 0;

	if ($error)
	{
		$message = $this->format($error);
		$this->show_message($message, 'error');
	}
	else if($this->config['max_login_attempts'] && $_failed_login_count >= $this->config['max_login_attempts'])
	{
		$message = $this->get_translation('LoginAttemtsExceeded');
		$this->show_message($message, 'error');
	}

	echo '<div class="cssform">'."\n";
	echo '<h3>'.$this->get_translation('LoginWelcome').'</h3>'."\n";

	echo $this->form_open('login', '', '', true);
	echo '<input type="hidden" name="action" value="login" />'."\n";
	echo '<input type="hidden" name="goback" value="'.(isset($_GET['goback']) ? stripslashes(htmlspecialchars($_GET['goback'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET)) : '').'" />'."\n";

	echo '<p>';
	echo '<label for="user_name">'.$this->format_translation('LoginName').':</label>';
	echo '<input type="text" id="user_name" name="user_name" size="25" maxlength="25" value="'.(isset($_user_name) ? $_user_name : '').'" tabindex="1" required autofocus />'."\n";
	echo '</p>'."\n";

	echo '<p>';
	echo '<label for="password">'.$this->get_translation('LoginPassword').':</label>'."\n";
	echo '<input type="password" id="password" name="password" size="25" tabindex="2" autocomplete="off" required />'."\n";
	echo '</p>';

	if ($this->config['allow_persistent_cookie'])
	{
		echo '<p>'."\n";
		echo '<input type="checkbox" id="persistent" name="persistent" value="1" tabindex="3"/>'."\n";
		echo '<label for="persistent">'.$this->get_translation('PersistentCookie').'</label>'."\n";
		echo '</p>'."\n";
	}

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
	echo '<input type="submit" class="OkBtn" value="'.$this->get_translation('LoginButton').'" tabindex="4" />'."\n";
	#echo '&nbsp;&nbsp;&nbsp;<small><a href="?action=clearcookies">'.$this->get_translation('ClearCookies').'</a></small>';
	echo '</p>'."\n";
	echo '<p>'.$this->format_translation('ForgotLink').'</p>'."\n";

	if ($this->config['allow_registration'] == true)
	{
		echo '<p>'.$this->format_translation('LoginWelcome2').'</p>'."\n";
	}

	echo $this->form_close();
	echo '</div>'."\n";
}
?>
<!--/notypo-->