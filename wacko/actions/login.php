<!--notypo-->
<?php

$error = '';
$output = '';

// reconnect securely in tls mode
#if ($this->config['tls'] == true && $this->config['tls_implicit'] == true && ( ($_SERVER['HTTPS'] != 'on' && empty($this->config['tls_proxy'])) || $_SERVER['SERVER_PORT'] != '443' ))
if ($this->config['tls'] == true && ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'on' && empty($this->config['tls_proxy'])) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '443' ) ))
{
	$this->redirect(str_replace('http://', 'https://'.(!empty($this->config['tls_proxy']) ? $this->config['tls_proxy'].'/' : ''), $this->href('', $this->get_translation('LoginPage'), "goback=".stripslashes($_GET['goback']))));
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

if (isset($_GET['action']) && $_GET['action'] == 'logout')
{
	$this->log(5, str_replace('%1', $this->get_user_name(), $this->get_translation('LogUserLoggedOut', $this->config['language'])));
	$this->logout_user();
	$this->set_bookmarks(BM_DEFAULT);
	$this->set_message($this->get_translation('LoggedOut'));
	$this->context[++$this->current_context] = '';

	if ($_GET['goback'] != '')
	{
		$this->redirect($this->href('', stripslashes($_GET['goback']), 'cache='.rand(0,1000)));
	}
	else
	{
		$this->redirect($this->href('', '', 'cache='.rand(0,1000)));
	}
}
else if ($user = $this->get_user())
{
	// user is logged in; display logout form
	echo $this->form_open();
	?>

<input type="hidden" name="action" value="logout" />
<div class="cssform">
  <h3><?php echo $this->get_translation('Hello').", ".$this->compose_link_to_page($user['user_name']) ?>!</h3>
<?php
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
?>
  <p>
    <input type="button" value="<?php echo $this->get_translation('LogoutButton'); ?>"
			onclick="document.location='<?php echo $this->href('', '', 'action=logout'); ?>'" />
  </p>
  <p>
		<?php echo $this->compose_link_to_page($this->get_translation('AccountLink'), '', $this->get_translation('AccountText'), 0); ?> | <a href="?action=clearcookies"><?php echo $this->get_translation('ClearCookies'); ?></a>
  </p>
</div>
<?php
	echo $this->form_close();
}
else
{
	// user is not logged in
	$focus = 0;

	// is user trying to log in or register?
	if (isset($_POST['action']) && $_POST['action'] == 'login')
	{
		// if user name already exists, check password
		if ($existing_user = $this->load_user($_POST['name']))
		{
			// check for disabled account
			if (($existing_user['enabled'] == false) || $existing_user['account_type'] != 0 )
			{
				$error = $this->get_translation('AccountDisabled');
			}
			else
			{
				// check for old md5 password
				if (strlen($existing_user['password']) < 64)
				{
					if (strlen($existing_user['password']) == 32)
					{
						$_processed_password = hash('md5', $_POST['password']);
					}
					if (strlen($existing_user['password']) == 40) // only for dev versions
					{
						$_processed_password = hash('sha1', $_POST['name'].$existing_user['salt'].$_POST['password']);
					}
					if ($existing_user['password'] == $_processed_password)
					{
						$salt		= $this->random_password(10, 3);
						$password	= hash('sha256', $_POST['name'].$salt.$_POST['password']);

						// update database with the sha256 password for future logins
						$this->query("UPDATE ".$this->config['table_prefix']."user SET ".
									"password	= '".$password."', ".
									"salt		= '".$salt."' ".
									"WHERE user_name = '".$_POST['name']."'");
					}
				}
				else
				{
					$_processed_password = hash('sha256', $_POST['name'].$existing_user['salt'].$_POST['password']);
				}

				// check password
				if ($existing_user['password'] == $_processed_password)
				{
					// define session duration in days
					$_session = isset($_POST['session']) ? $_POST['session'] : null;

					switch ($_session)
					{
						case '1d':
							$session = 1;
							break;
						case '7d':
							$session = 7;
							break;
						case '30d':
							$session = 30;
							break;
						default:
							$session = $this->config['session_expiration'];
					}

					$_persistent = isset($_POST['persistent']) ? $_POST['persistent'] : 0;

					$this->log_user_in($existing_user, $_persistent, $session);
					$this->set_user($existing_user, 1);
					$this->update_session_time($existing_user);
					$this->set_bookmarks(BM_USER);
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

					if ($_POST['goback'] != '')
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
					$error	= $this->get_translation('WrongPassword');
					$name	= $_POST['name'];
					$focus	= 1;

					$this->set_failed_user_login_count($existing_user['user_id']);

					// log failed attempt
					$this->log(2, str_replace('%1', $_POST['name'], $this->get_translation('LogUserLoginFailed', $this->config['language'])));
				}
			}
		}
	}

	if ($error)
	{
		# $this->set_message($error);
		echo '<div class="error">'.$this->Format($error).'</div>';
	}

	echo $this->form_open();
	?>
<input type="hidden" name="action" value="login" />
<input type="hidden" name="goback" value="<?php echo (isset($_GET['goback']) ? stripslashes($_GET['goback']) : '');?>" />
<div class="cssform">
	<h3><?php echo $this->get_translation('LoginWelcome'); ?></h3>
	<p>
		<label for="name"><?php echo $this->format_translation('LoginName');?>:</label>
		<input id="name" name="name" size="25" maxlength="25" value="<?php echo isset($name) ? $name : ''; ?>" tabindex="1" />
	</p>
	<p>
		<label for="password"><?php echo $this->get_translation('LoginPassword');?>:</label>
		<input id="password" type="password" name="password" size="25" tabindex="2" autocomplete="off" />
	</p>
</div>
<?php
/*
	<p>
		<label for=""><?php echo $this->get_translation('SessionDuration');?>:</label>
		<small>
			<input id="1d" name="session" value="1d" type="radio" /><label for="1d">1 day</label> &nbsp;&nbsp;
			<input id="7d" name="session" value="7d" type="radio" /><label for="7d">7 days</label> &nbsp;&nbsp;
			<input id="30d" name="session" value="30d" type="radio" checked="checked" /><label for="30d">30 days</label>
		</small>
	</p>
	*/
?>
<div class="cssform">
	<p>
		<input id="persistent" name="persistent" value="1" type="checkbox" tabindex="3"/>
		<label for="persistent"><?php echo $this->get_translation('PersistentCookie'); ?></label>
	</p>
	<p>
		<input type="submit" value="<?php echo $this->get_translation('LoginButton'); ?>" tabindex="4" />
		&nbsp;&nbsp;&nbsp;<small><a href="?action=clearcookies">Delete all cookies</a></small>
	</p>
	<p><?php echo $this->format_translation('ForgotLink'); ?></p>
	<p><?php echo $this->format_translation('LoginWelcome2'); ?></p>
</div>
<script type="text/javascript">
	document.getElementById("f<?php echo $focus;?>").focus();
</script>
<?php
	echo $this->form_close();
}
?>
<!--/notypo-->