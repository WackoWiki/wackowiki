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

define('IN_WACKO', 'admin');
require_once 'class/init.php';

$db = $config = new Settings;

if ($db->ext_bad_behavior)
{
	require_once('lib/bad_behavior/bad-behavior-wackowiki.php'); // uses $db
}

$http = new Http($db, false); // false -- do not process wiki request

$engine = new Wacko($db, $http);

// redirect, send them home [disabled for recovery mode!]
if (!($engine->is_admin() || $db->is_locked() || RECOVERY_MODE))
{
	$http->secure_base_url();
	$http->redirect($engine->href());
}

// register locale resources
$engine->set_language($db->language, true);

// reconnect securely in tls mode
$http->ensure_tls($db->base_url . 'admin.php');

########################################################
##            End admin session and logout            ##
########################################################

if (@$_GET['action'] === 'logout')
{
	unset($engine->sess->ap_created);
	$engine->log(1, $engine->get_translation('LogAdminLogout', $engine->config['language']));
	$http->secure_base_url();
	$http->redirect($engine->href());
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
				$engine->db->recovery_password
			)
		)
	{
		$engine->config['cookie_path']	= preg_replace('|https?://[^/]+|i', '', $engine->config['base_url'].'');

		$engine->sess->ap_created			=
		$engine->sess->ap_last_activity		= time();
		$engine->sess->ap_failed_login_count	= 0;

		if ($engine->config['ap_failed_login_count'] > 0)
		{
			$engine->config->set('ap_failed_login_count', 0);
		}

		$engine->log(1, $engine->get_translation('LogAdminLoginSuccess', $engine->config['language']));
		$http->secure_base_url();
		$http->ensure_tls($db->base_url . 'admin.php');
	}
	else
	{
		if (!isset($engine->sess->ap_failed_login_count))
		{
			$engine->sess->ap_failed_login_count = 0;
		}

		$engine->config->set('ap_failed_login_count', $engine->config['ap_failed_login_count'] + 1);
		$engine->log(1, $engine->get_translation('LogAdminLoginFailed', $engine->config['language']));

		++$engine->sess->ap_failed_login_count;

		// RECOVERY_MODE ON || RECOVERY_MODE OFF
		if (($engine->sess->ap_failed_login_count >= 4) || ($engine->config['ap_failed_login_count'] >= $engine->config['ap_max_login_attempts']))
		{
			$db->lock(AP_LOCK);
			$engine->log(1, $engine->get_translation('LogAdminLoginLocked', $engine->config['language']));

			$engine->sess->ap_failed_login_count = 0;
		}
	}
}

// check authorization
$user			= '';
$_title			= '';

if (!isset($engine->sess->ap_created))
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

// setting temporary admin user context
$session_length = 1800; // 1800 -> 30 minutes

if (time() - $engine->sess->ap_last_activity > 900) //1800
{
	// last request was more than 15 minutes ago
	unset($engine->sess->ap_created);
	$engine->log(1, $engine->get_translation('LogAdminLogout', $engine->config['language']));

	$engine->set_message($engine->get_translation('LoggedOutAuto'));
	$engine->redirect('admin.php');
}

$engine->sess->ap_last_activity = time(); // update last activity time stamp

if (time() - $engine->sess->ap_created > $session_length)
{
	$session_expire			= time() + $session_length;
	// session started more than 30 minutes(default $session_length) ago  // TODO: $session_time missing!
	$engine->restart_user_session($user, $session_expire); // TODO: we need extra user session here, hence we need a auth_token table
	$engine->sess->ap_created = time();  // update creation time
}

########################################################
##     Include admin modules and common functions     ##
########################################################

foreach (Ut::file_glob('admin/{common,module}/*.php') as $filename)
{
	include $filename;
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
				<?php $time_left = round(($session_length - (time() - $engine->sess->ap_created)) / 60);
				echo "Time left: ".$time_left." minutes"; ?>
				&nbsp;&nbsp;
				<?php echo $engine->compose_link_to_page('/', '', rtrim($engine->config['base_url'], '/')); ?>
				&nbsp;&nbsp;
				<?php echo ($db->is_locked() ? '<strong>site closed</strong>' : 'site opened'); ?>
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
Diag::debug($db, $http, $engine);


?>

</body>
</html>

<?php

########################################################
##             Finishing and cleaning out             ##
########################################################

// getting out of temp context
