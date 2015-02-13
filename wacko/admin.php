<?php

// WackoWiki ADMINISTRATION SUBSYSTEM

// TODO:
// - rewrite backup/restore modules for more granulated backups,
//   and to span very big tables (> 2-5 Mb) across several
//   backup files
// - write modules for users administration (remove, ban and so on)
// - allow multiple admins login with personal credentials in
//   addition to recovery password login (in case of db corruption)

########################################################
##                  Wacko engine init                 ##
########################################################

define('IN_WACKO', true);

// initialize engine api
require('classes/init.php');
$init = new init();

// define settings
if ($cached_config = $init->load_cached_settings('config'))
{
	$init->config = $cached_config;	// retrieving from cache
}
else
{
	$init->settings();	// populate from config.php
	$init->settings();	// initialize DBAL and populate from config table.
}

$init->dbal();
$init->settings('theme_url',	$init->config['base_url'].'themes/'.$init->config['theme'].'/');
$init->settings('user_table',	$init->config['table_prefix'].'user');
$init->settings('cookie_hash',	hash('sha1', $init->config['base_url'].$init->config['system_seed']));
$init->settings('ap_mode',		true);


$init->settings('cookie_path',	preg_replace('|https?://[^/]+|i', '', $init->config['base_url'].''));

if ($init->is_locked('lock_ap') === true)
{
	if (!headers_sent())
	{
		header('HTTP/1.1 503 Service Temporarily Unavailable');
	}

	echo "The site is temporarily unavailable due to system maintenance. Please try again later.";
	exit;
}

// misc
$init->session();

// engine start
$cache	= $init->cache();
$engine	= $init->engine();

// register locale resources
$init->engine('lang');

// reconnect securely in tls mode
if ($engine->config['tls'] == true)
{
	if ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'on' && empty($engine->config['tls_proxy'])) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '443' ))
	{
		$engine->redirect(str_replace('http://', 'https://'.($engine->config['tls_proxy'] ? $engine->config['tls_proxy'].'/' : ''), $engine->config['base_url']).'admin.php');
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
	$engine->log(1, $engine->get_translation('LogAdminLogout', $engine->config['language']));
	$engine->redirect(( $engine->config['tls'] == true ? str_replace('http://', 'https://'.($engine->config['tls_proxy'] ? $engine->config['tls_proxy'].'/' : ''), $engine->href()) : $engine->href() ));
	exit;
}

########################################################
##     Include admin modules and common functions     ##
########################################################

$dirs = array(
	'admin/common',
	'admin/modules'
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
##           Authorization & preparations             ##
########################################################

// recovery password
if ($engine->config['recovery_password'] == false)
{
	echo '<strong>'.$engine->get_translation('NoRecoceryPassword').'</strong><br />';
	echo $engine->get_translation('NoRecoceryPasswordTip');
	die();
}
else
{
	$_processed_password = $engine->config['recovery_password'];
}

// recovery preauthorization
if (isset($_POST['password']))
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

	if (hash('sha256', $engine->config['system_seed'].$_POST['password']) == $_processed_password)
	{
		$engine->config['cookie_path']	= preg_replace('|https?://[^/]+|i', '', $engine->config['base_url'].'');
		$engine->set_session_cookie('admin', hash('sha256', hash('sha256', $engine->config['system_seed'].$_POST['password']).$engine->config['base_url']), '', ( $engine->config['tls'] == true ? 1 : 0 ));
		$_SESSION['created']			= time();
		$_SESSION['last_activity']		= time();
		$_SESSION['failed_login_count']	= 0;

		if ($engine->config['ap_failed_login_count'] > 0)
		{
			$engine->set_config('ap_failed_login_count', 0, '', true);
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

		$engine->set_config('ap_failed_login_count', $engine->config['ap_failed_login_count'] + 1, '', true);

		$engine->log(1, str_replace('%1', $_POST['password'], $engine->get_translation('LogAdminLoginFailed', $engine->config['language'])));

		$_SESSION['failed_login_count'] = $_SESSION['failed_login_count'] + 1;

		if (($_SESSION['failed_login_count'] >= 3) || ($engine->config['ap_failed_login_count'] >= $engine->config['ap_max_login_attempts']))
		{
			$init->lock('lock_ap');
			$engine->log(1, $engine->get_translation('LogAdminLoginLocked', $engine->config['language']));
			$_SESSION['failed_login_count'] = 0;
		}
	}
}

// check authorization
$user = '';

if (isset($_COOKIE[$engine->config['cookie_prefix'].'admin'.'_'.$engine->config['cookie_hash']]) && $_COOKIE[$engine->config['cookie_prefix'].'admin'.'_'.$engine->config['cookie_hash']] == hash('sha256', $_processed_password.$engine->config['base_url']))
{
	$user = array('user_name' => $engine->config['admin_name']);
}

if ($user == false)
{
	header('Content-Type: text/html; charset='.$engine->get_charset());
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Authorization Admin</title>
	<meta name="robots" content="noindex, nofollow, noarchive" />
	<link href="<?php echo rtrim($engine->config['base_url']); ?>admin/styles/backend.css" rel="stylesheet" type="text/css" media="screen" />
	</head>
	<body>
<?php
		// here we show messages
		if ($message = $engine->get_message())
		{
			$engine->show_message($message, 'info');
		}
?>
		<div id="loginbox">
			<strong><?php echo $engine->get_translation('Authorization'); ?></strong><br />
			<?php echo $engine->get_translation('AuthorizationTip'); ?>
			<br /><?php #echo $engine->charset; // XXX: only for testing ?><br />
			<form action="admin.php" method="post" name="emergency">
				<label for="password"><strong><?php echo $engine->get_translation('LoginPassword'); ?>:</strong></label>
				<input name="password" id="password" type="password" autocomplete="off" value="" />
<?php
				// captcha code starts

				// Only show captcha if the admin enabled it in the config file
				#if($engine->config['ap_max_login_attempts'] && $engine->config['ap_failed_login_count'] >= $engine->config['max_login_attempts'])
				#{
					#echo '<p>';
					#echo '<br />';
					#$engine->show_captcha(false);
					#echo '</p>';
				#}
				// end captcha
?>
				<input id="submit" type="submit" value="ok" />
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
$_user = $engine->get_user();
$engine->set_user($user, 0);

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
else if (time() - $_SESSION['created'] > 1800)
{
	// session started more than 30 minates ago
	$engine->restart_user_session(); // TODO: we need extra user session here, hence we need a session table
	//session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
	$_SESSION['created'] = time();  // update creation time
}

########################################################
##                     Page header                    ##
########################################################

header('Content-Type: text/html; charset='.$engine->get_charset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>WackoWiki Management System</title>
<meta name="robots" content="noindex, nofollow, noarchive" />
<meta http-equiv="Content-Type" content="text/html; "/>
<link href="<?php echo rtrim($engine->config['base_url']); ?>admin/styles/atom.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo rtrim($engine->config['base_url']); ?>admin/styles/wiki.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo rtrim($engine->config['base_url']); ?>admin/styles/backend.css" rel="stylesheet" type="text/css" media="screen" />

</head>
<body>
<div id="header">
	<div id="pane">
		<div class="left"></div>
		<div class="middle">
			<a href="<?php echo rtrim($engine->config['base_url']); ?>admin.php"><img src="<?php echo rtrim($engine->config['base_url']).$engine->config['upload_path'].'/'; ?>wacko_logo.png" alt="WackoWiki" width="108" height="50"></a>
		</div>
		<div id="tools">
			<span>
				<?php $time_left = round((1800 - (time() - $_SESSION['created'])) / 60);
				echo "Time left: ".$time_left." minutes"; ?>
				&nbsp;&nbsp;
				<?php echo $engine->compose_link_to_page('/', '', rtrim($engine->config['base_url'], '/')); ?>
				&nbsp;&nbsp;
				<?php echo ( $init->is_locked() === true ? '<strong>site closed</strong>' : 'site opened' ); ?>
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
</div>

<?php

########################################################
##                     Main Menu                      ##
########################################################

?>
	<div id="menu" class="menu">
		<div class="sub">
			<ul>
			<li class="text submenu"><?php echo $module['lock']['cat']; ?>
			<?php echo ( isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'lock' || (!$_GET && !$_POST)
				? "\n<ul>\n<li class=\"active\">"
				: "\n<ul>\n<li>" ); ?>
			<a href="admin.php">
			<?php echo $module['lock']['name']; ?></a>
			<?php echo "</li>\n";

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
				if ($row['mode'] != 'lock')
				{
					echo ($row['cat'] != $category
						? "</ul>\n</li>\n<li class=\"text submenu2\">".$row['cat']."<ul>\n"
						: '');
					echo (isset($_REQUEST['mode']) && $_REQUEST['mode'] == $row['mode']
						? '<li class="active">'
						: "<li>"); ?>
					<a href="?mode=<?php echo $row['mode']; ?>" title="<?php echo $row['title']; ?>"><?php echo $row['name']; ?></a>
					<?php echo "</li>\n";
				}
				else
				{
					continue;
				}

				$category = $row['cat'];
			}

			unset($category);

?>
</ul></li></ul></div>
	</div>
<?php

########################################################
##                  Execute module                    ##
########################################################

?>

<div id="content">
<div id="page">
<?php
// here we show messages
if ($message = $engine->get_message())
{
	$engine->show_message($message, 'info');
}
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
</div>
<?php /*
<div id="tabs">
	<div class="controls"></div>
</div>
*/ ?>
<div id="footer">System <a href="http://wackowiki.sourceforge.net/">WackoWiki</a></div>

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
$engine->set_user($_user, 0);

?>