<?php

// WackoWiki ADMINISTRATION SUBSYSTEM

// TODO:
// - rewrite backup/restore modules for more granulated backups,
//   and to span very big tables (> 2-5 Mb) across several
//   backup files
// - write modules for users administration (remove, ban and so on)
// - allow multiple admins login with personal credentials in
//   addition to recovery password login (in case of db corruption -> recoverymode)

########################################################
##                  Wacko engine init                 ##
########################################################

define('IN_WACKO', true);

require_once('lib/utility.php');
class_autoloader('config/autoload.conf');

// define settings
$config = new Settings(!RECOVERY_MODE);

// initialize engine api
$init = new Init($config);

if ($init->is_locked('lock_ap'))
{
	if (!headers_sent())
	{
		header('HTTP/1.1 503 Service Temporarily Unavailable');
	}

	echo 'The site is temporarily unavailable due to system maintenance. Please try again later.';
	exit;
}

$config->ap_mode = true;

// misc
$init->session();
$init->http_security_headers();

// engine start
$init->cache();
$engine	= $init->engine();

if (!empty($config->ext_bad_behavior))
{
	require_once('lib/bad_behavior/bad-behavior-wackowiki.php');
}

// redirect, send them home [disabled for recovery mode!]
if ((!$engine->is_admin()
		#&& (!$init->is_locked() === true && !isset($_COOKIE[$engine->config['cookie_prefix'].'admin'.'_'.$engine->config['cookie_hash']]) ) )
		&& (!$init->is_locked() === true ) )
	&& !RECOVERY_MODE)
{
	if (!headers_sent())
	{
		header('HTTP/1.1 404 Not Found');
	}

	$engine->redirect(( $config->tls ? str_replace('http://', 'https://'.($config->tls_proxy ? $config->tls_proxy.'/' : ''), $engine->href()) : $engine->href() ));
}

// register locale resources
$init->engine('lang');

// reconnect securely in tls mode
if ($config->tls)
{
	if ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'on' && empty($config->tls_proxy)) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '443' ))
	{
		$engine->redirect(str_replace('http://', 'https://'.($config->tls_proxy ? $config->tls_proxy.'/' : ''), $config->base_url).'admin.php');
	}
	else
	{
		$engine->config['base_url'] = str_replace('http://', 'https://'.($engine->config['tls_proxy'] ? $engine->config['tls_proxy'].'/' : ''), $engine->config['base_url']);
	}
}

########################################################
##            End admin session and logout            ##
########################################################

if (isset($_GET['action']) && $_GET['action'] == 'logout')
{
	$engine->delete_cookie('admin', true, true);
	$engine->set_user($_user, 0);
	$engine->log(1, $engine->get_translation('LogAdminLogout', $engine->config['language']));
	$engine->redirect(( $engine->config['tls'] == true ? str_replace('http://', 'https://'.($engine->config['tls_proxy'] ? $engine->config['tls_proxy'].'/' : ''), $engine->href()) : $engine->href() ));
	exit;
}

########################################################
##           Authorization & preparations             ##
########################################################

// recovery password
if (!$engine->config['recovery_password'])
{
	echo '<strong>'.$engine->get_translation('NoRecoceryPassword').'</strong><br />';
	echo $engine->get_translation('NoRecoceryPasswordTip');

	die();
}

$_processed_password = $engine->config['recovery_password'];

// recovery preauthorization
if (isset($_POST['ap_password']))
{
	// Start Login Captcha, if there are too much login attempts (max_login_attempts)

	// Only show captcha if the admin enabled it in the config file
	/* if($engine->config['ap_max_login_attempts'] && $engine->config['ap_failed_login_count'] >= $engine->config['ap_max_login_attempts'] + 1)
	{
		// captcha validation
		if ($engine->validate_captcha() === false)
		{
			$error = $engine->get_translation('CaptchaFailed');
		}
	} */
	// End Registration Captcha

	if (password_verify(
			base64_encode(
					hash('sha256', $engine->config['system_seed'].$_POST['ap_password'], true)
					),
				$_processed_password
			)
		)
	{
		$engine->config['cookie_path']	= preg_replace('|https?://[^/]+|i', '', $engine->config['base_url'].'');
		$engine->set_cookie('admin', hash('sha256', $_processed_password.$engine->config['base_url']), '', false, ( $engine->config['tls'] == true ? 1 : 0 ));

		$_SESSION['created']			= time();
		$_SESSION['last_activity']		= time();
		$_SESSION['failed_login_count']	= 0;

		if ($engine->config['ap_failed_login_count'] > 0)
		{
			$engine->config->set('ap_failed_login_count', 0);
		}

		$engine->log(1, $engine->get_translation('LogAdminLoginSuccess', $engine->config['language']));
		$engine->redirect(( $engine->config['tls'] == true ? str_replace('http://', 'https://'.($engine->config['tls_proxy'] ? $engine->config['tls_proxy'].'/' : ''), $engine->href('admin.php')) : $engine->href('admin.php') ));
	}
	else
	{
		if (!isset($_SESSION['failed_login_count']))
		{
			$_SESSION['failed_login_count'] = 0;
		}

		$engine->config->set('ap_failed_login_count', $engine->config['ap_failed_login_count'] + 1);
		$engine->log(1, $engine->get_translation('LogAdminLoginFailed', $engine->config['language']));

		$_SESSION['failed_login_count'] = $_SESSION['failed_login_count'] + 1;

		// RECOVERY_MODE ON || RECOVERY_MODE OFF
		if (($_SESSION['failed_login_count'] >= 4) || ($engine->config['ap_failed_login_count'] >= $engine->config['ap_max_login_attempts']))
		{
			$init->lock('lock_ap');
			$engine->log(1, $engine->get_translation('LogAdminLoginLocked', $engine->config['language']));

			$_SESSION['failed_login_count'] = 0;
		}
	}
}

// check authorization
$user			= '';
$authorization	= false;
$_title			= '';

if (isset($_COOKIE[$engine->config['cookie_prefix'].'admin'.'_'.$engine->config['cookie_hash']])
	&& $_COOKIE[$engine->config['cookie_prefix'].'admin'.'_'.$engine->config['cookie_hash']] == hash('sha256', $_processed_password.$engine->config['base_url']))
{
	#$user = array('user_name' => $engine->config['admin_name']);
	$authorization = true;
}

if ($authorization == false)
{
	header('Content-Type: text/html; charset='.$engine->get_charset());
?>
	<!DOCTYPE html>
	<html>
	<head>
	<title>Authorization Admin</title>
	<meta name="robots" content="noindex, nofollow, noarchive" />
	<link href="<?php echo rtrim($engine->config['base_url']); ?>admin/style/backend.css" rel="stylesheet" media="screen" />
	</head>
	<body>
<?php
		// here we show messages
		$engine->output_messages();
?>
		<div id="loginbox">
			<strong><?php echo $engine->get_translation('Authorization'); ?></strong><br />
			<?php echo $engine->get_translation('AuthorizationTip'); ?>
			<br /><?php #echo $engine->charset; // XXX: only for testing ?><br />
			<?php
			#$engine->form_open('emergency');
			?>
			<form action="admin.php" method="post" name="emergency">
				<label for="ap_password"><strong><?php echo $engine->get_translation('LoginPassword'); ?>:</strong></label>
				<input type="password" name="ap_password" id="ap_password" autocomplete="off" value="" />
<?php
				// captcha code starts

				// Only show captcha if the admin enabled it in the config file
				/* if($engine->config['ap_max_login_attempts'] && $engine->config['ap_failed_login_count'] >= $engine->config['max_login_attempts'])
				{
					echo '<p>';
					echo '<br />';
					$engine->show_captcha(false);
					echo '</p>';
				} */
				// end captcha
?>
				<input type="submit" id="submit" value="ok" />
			</form>
		</div>
	</body>
	</html>
<?php
	exit;
}

unset($_processed_password);

// setting temporary admin user context
global $_user;
$session_length = 1800; // 1800 -> 30 minutes
#$_user = $engine->get_user();
#$engine->set_user($user, 0);

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 900)) //1800
{
	// last request was more than 15 minutes ago
	$engine->delete_cookie('admin', true, true);
	$engine->log(1, $engine->get_translation('LogAdminLogout', $engine->config['language']));

	//session_destroy();   // destroy session data in storage
	//session_unset();     // unset $_SESSION variable for the runtime
	$engine->set_message($engine->get_translation('LoggedOutAuto'));
	$engine->redirect('admin.php');
}

$_SESSION['last_activity'] = time(); // update last activity time stamp

if (!isset($_SESSION['created']))
{
	$_SESSION['created'] = time();
}
else if (time() - $_SESSION['created'] > $session_length)
{
	$session_expire			= time() + $session_length;
	// session started more than 30 minutes(default $session_length) ago  // TODO: $session_time missing!
	$engine->restart_user_session($user, $session_expire); // TODO: we need extra user session here, hence we need a auth_token table
	//session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
	$_SESSION['created'] = time();  // update creation time
}

########################################################
##     Include admin modules and common functions     ##
########################################################

$dirs = array(
	'admin/common',
	'admin/module'
	);

foreach ($dirs as $dir)
{
	if ($dh = opendir($dir))
	{
		while (false !== ($filename = readdir($dh)))
		{
			if (is_dir($dir.'/'.$filename) !== true && substr($filename, -4) == '.php')
			{
				include($dir.'/'.$filename);
			}
		}

		closedir($dh);
	}
}

########################################################
##     Build menue                                    ##
########################################################

$menue = '<ul><li class="text submenu">'.$module['lock']['cat'].
			(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'lock' || (!$_GET && !$_POST)
				? "\n<ul>\n".'<li class="active">'
				: "\n<ul>\n<li>").
			'<a href="admin.php">'.$module['lock']['name'].'</a>'.
			"</li>\n";

$category = $module['lock']['cat'];

uasort($module,
		create_function(
			'$a, $b',
			'if ((array)$a["order"] < (array)$b["order"])
				return -1;
			else if ((array)$a["order"] > (array)$b["order"])
				return 1;
			else
				return 0;')
);

foreach ($module as $row)
{
	if ($row['status'] === true)
	{
		if ($row['mode'] != 'lock')
		{
			$menue .= ($row['cat'] != $category
						? "</ul>\n</li>\n".'<li class="text submenu2">'.$row['cat']."<ul>\n"
						: '');

			if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == $row['mode'])
			{
				$menue .= '<li class="active">';
				$_title = $row['cat'].' &gt; '.$row['name'];
			}
			else
			{
				$menue .= '<li>';
			}

			$menue .= '<a href="?mode='.$row['mode'].'" title="'.$row['title'].'">'.$row['name'].'</a>';
			$menue .= "</li>\n";
		}
		else
		{
			continue;
		}
	}

	$category = $row['cat'];
}

$menue .= "</ul>\n</li>\n</ul>";

unset($category);

########################################################
##                     Page header                    ##
########################################################

header('Content-Type: text/html; charset='.$engine->get_charset());
?>
<!DOCTYPE html>
<html>
<head>
<title>WackoWiki Management System <?php echo ': '.$_title; ?></title>
<meta name="robots" content="noindex, nofollow, noarchive" />
<meta http-equiv="Content-Type" content="text/html; "/>
<link href="<?php echo rtrim($engine->config['base_url']); ?>admin/style/atom.css" rel="stylesheet" media="screen" />
<link href="<?php echo rtrim($engine->config['base_url']); ?>admin/style/wiki.css" rel="stylesheet" media="screen" />
<link href="<?php echo rtrim($engine->config['base_url']); ?>admin/style/backend.css" rel="stylesheet" media="screen" />

</head>
<body>
<header id="header">
	<div id="pane">
		<div class="left"></div>
		<div class="middle">
			<a href="<?php echo rtrim($engine->config['base_url']); ?>admin.php"><img src="<?php echo rtrim($engine->config['base_url']).'image/'; ?>wacko_logo.png" alt="WackoWiki" width="108" height="50"></a>
		</div>
		<div id="tools">
			<span>
				<?php echo (RECOVERY_MODE === true ? '<strong>RECOVERY_MODE</strong>' : ''); ?>
				&nbsp;&nbsp;
				<?php $time_left = round(($session_length - (time() - $_SESSION['created'])) / 60);
				echo "Time left: ".$time_left." minutes"; ?>
				&nbsp;&nbsp;
				<?php echo $engine->compose_link_to_page('/', '', rtrim($engine->config['base_url'], '/')); ?>
				&nbsp;&nbsp;
				<?php echo ($init->is_locked() ? '<strong>site closed</strong>' : 'site opened'); ?>
				&nbsp;&nbsp;
				version <?php echo $engine->config['wacko_version']; ?>
			</span>
		</div>
		<br style="clear: right" />
		<div id="sections">
			<a href="<?php echo rtrim($engine->config['base_url']); ?>" title="open the home page, you do not quit administration">Home Page</a>
			<a href="<?php echo rtrim($engine->config['base_url']); ?>admin.php?action=logout" title="quit system administration">Log out</a>
		</div>
	</div>
</header>

<?php

########################################################
##                     Main Menu                      ##
########################################################

?>
	<nav id="menu" class="menu">
		<div class="sub">
<?php
			echo $menue;
?>
		</div>
	</nav>
<?php

########################################################
##                  Execute module                    ##
########################################################

?>

<main id="content">
	<div id="page">
<?php
// here we show messages
$engine->output_messages();

?>
<!-- begin page output -->

<?php

if (isset($_REQUEST['mode']) === true && ($_GET || $_POST))
{
	if (function_exists('admin_'.$_REQUEST['mode']) === true)
	{
		// page context
		$engine->tag = $engine->supertag = 'admin.php?mode='.$_REQUEST['mode'];
		$engine->context[++$engine->current_context] = $engine->tag;

		// module run
		$exec = 'admin_'.$_REQUEST['mode'];
		$exec($engine, $module[$_REQUEST['mode']]);

		$engine->current_context--;
	}
	else
	{
		echo '<em><br /><br />Error loading admin module "'.$_REQUEST['mode'].'.php": does not exists.</em>';
	}
}
else if (!($_GET && $_POST))
{
	$exec = 'admin_lock';
	$exec($engine, $module['lock']);
}

########################################################
##                     Page footer                    ##
########################################################

?>

<br />
<!-- end page output -->
	</div>
</main>
<?php /*
<div id="tabs">
	<div class="controls"></div>
</div>
*/ ?>
<footer id="footer">System <a href="http://wackowiki.sourceforge.net/">WackoWiki</a></footer>

<?php

// debugging info on script execution time and memory taken
$init->debug();

?>

</body>
</html>

<?php

########################################################
##             Finishing and cleaning out             ##
########################################################

// getting out of temp context
#$engine->set_user($_user, 0);
