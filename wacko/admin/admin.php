<?php

if (!defined('IN_WACKO'))
{
	exit;
}


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

// clean _POST if no csrf token
$engine->validate_post_token();

########################################################
##            End admin session and logout            ##
########################################################

if (@$_GET['action'] === 'logout')
{
	unset($engine->sess->ap_created);
	$engine->log(1, $engine->_t('LogAdminLogout', SYSTEM_LANG));
	$http->secure_base_url();
	$http->redirect($engine->href());
	exit;
}

########################################################
##           Authorization & preparations             ##
########################################################

// recovery password
if (!$engine->db->recovery_password)
{
	echo '<strong>' . $engine->_t('NoRecoceryPassword') . '</strong><br />';
	echo $engine->_t('NoRecoceryPasswordTip');

	die();
}

// recovery preauthorization
if (@$_POST['_action'] === 'emergency')
{
	if (password_verify(
			base64_encode(
					hash('sha256', $engine->db->system_seed . $_POST['ap_password'], true)
					),
				$engine->db->recovery_password
			)
		)
	{
		$engine->db->cookie_path				= preg_replace('|https?://[^/]+|i', '', $engine->db->base_url.'');

		$engine->sess->ap_created				=
		$engine->sess->ap_last_activity			= time();
		$engine->sess->ap_failed_login_count	= 0;

		if ($engine->db->ap_failed_login_count > 0)
		{
			$engine->config->set('ap_failed_login_count', 0);
		}

		$engine->log(1, $engine->_t('LogAdminLoginSuccess', SYSTEM_LANG));
		$http->secure_base_url();
		$http->ensure_tls($db->base_url . 'admin.php');
	}
	else
	{
		$engine->log_user_delay();
		if (!isset($engine->sess->ap_failed_login_count))
		{
			$engine->sess->ap_failed_login_count = 0;
		}

		$engine->config->set('ap_failed_login_count', $engine->db->ap_failed_login_count + 1);
		$engine->log(1, $engine->_t('LogAdminLoginFailed', SYSTEM_LANG));

		++$engine->sess->ap_failed_login_count;

		// RECOVERY_MODE ON || RECOVERY_MODE OFF
		if (($engine->sess->ap_failed_login_count >= 4) || ($engine->db->ap_failed_login_count >= $engine->db->ap_max_login_attempts))
		{
			$db->lock(AP_LOCK);
			$engine->log(1, $engine->_t('LogAdminLoginLocked', SYSTEM_LANG));

			$engine->sess->ap_failed_login_count = 0;
		}
	}
}

// check authorization
$user		= '';
$_title		= '';

if (!isset($engine->sess->ap_created))
{
	header('Content-Type: text/html; charset=' . $engine->get_charset());
?>
	<!DOCTYPE html>
	<html>
	<head>
	<title>Authorization Admin</title>
	<meta name="robots" content="noindex, nofollow, noarchive" />
	<link href="<?php echo rtrim($engine->db->base_url); ?>admin/style/backend.css" rel="stylesheet" media="screen" />
	</head>
	<body>
<?php
		// here we show messages
		$engine->output_messages();
?>
		<div id="loginbox">
			<strong><?php echo $engine->_t('Authorization'); ?></strong><br />
			<?php echo $engine->_t('AuthorizationTip'); ?>
			<br /><br />
			<?php
			echo $engine->form_open('emergency', ['tag' => 'admin.php']);
			// <form action="admin.php" method="post" name="emergency"> -- by STS
			?>
				<label for="ap_password"><strong><?php echo $engine->_t('LoginPassword'); ?>:</strong></label>
				<input type="password" name="ap_password" id="ap_password" autocomplete="off" value="" />
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
	$engine->log(1, $engine->_t('LogAdminLogout', SYSTEM_LANG));

	$engine->set_message($engine->_t('LoggedOutAuto'));
	$engine->http->redirect('admin.php');
}

$engine->sess->ap_last_activity = time(); // update last activity time stamp

if (time() - $engine->sess->ap_created > $session_length)
{
	$session_expire			= time() + $session_length;
	// session started more than 30 minutes(default $session_length) ago  // TODO: $session_time missing!
	// STS no op now.
	// $engine->restart_user_session($user, $session_expire); // TODO: we need extra user session here, hence we need a auth_token table
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
##     Build menu                                     ##
########################################################

$menu = '<ul><li class="text submenu">' . $engine->_t('CategoryArray')[$module['lock']['cat']].
			(isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'lock' || (!$_GET && !$_POST)
				? "\n<ul>\n" . '<li class="active">'
				: "\n<ul>\n<li>").
			'<a href="admin.php" title="' . $module['lock']['title'] . '">' . $module['lock']['name'] . '</a>' . 
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
			$menu .= ($row['cat'] != $category
						? "</ul>\n</li>\n" . '<li class="text submenu2">' . $engine->_t('CategoryArray')[$row['cat']] . "<ul>\n"
						: '');

			if (isset($_REQUEST['mode']) && $_REQUEST['mode'] == $row['mode'])
			{
				$menu .= '<li class="active">';
				$_title = $row['cat'] . ' &gt; ' . $row['name'];
			}
			else
			{
				$menu .= '<li>';
			}

			$menu .= '<a href="?mode=' . $row['mode'] . '" title="' . $row['title'] . '">' . $row['name'] . '</a>';
			$menu .= "</li>\n";
		}
		else
		{
			continue;
		}
	}

	$category = $row['cat'];
}

$menu .= "</ul>\n</li>\n</ul>";

unset($category);

########################################################
##                     Page header                    ##
########################################################

header('Content-Type: text/html; charset=' . $engine->get_charset());
?>
<!DOCTYPE html>
<html>
<head>
<title>WackoWiki Management System <?php echo ': ' . $_title; ?></title>
<meta name="robots" content="noindex, nofollow, noarchive" />
<meta http-equiv="Content-Type" content="text/html; "/>
<link href="<?php echo rtrim($engine->db->base_url); ?>admin/style/wiki.css" rel="stylesheet" media="screen" />
<link href="<?php echo rtrim($engine->db->base_url); ?>admin/style/backend.css" rel="stylesheet" media="screen" />

</head>
<body>
<header id="header">
	<div id="pane">
		<div class="left"></div>
		<div class="middle">
			<a href="<?php echo rtrim($engine->db->base_url); ?>admin.php"><img src="<?php echo rtrim($engine->db->base_url) . 'image/'; ?>wacko_logo.png" alt="WackoWiki" width="108" height="50"></a>
		</div>
		<div id="tools">
			<span>
				<?php echo (RECOVERY_MODE === true ? '<strong>RECOVERY_MODE</strong>' : ''); ?>
				&nbsp;&nbsp;
				<?php $time_left = round(($session_length - (time() - $engine->sess->ap_created)) / 60);
				echo Ut::perc_replace($engine->_t('TimeLeft'), $time_left); ?>
				&nbsp;&nbsp;
				<?php echo $engine->compose_link_to_page('/', '', rtrim($engine->db->base_url, '/')); ?>
				&nbsp;&nbsp;
				<?php echo ($db->is_locked() ? '<strong>' . $engine->_t('SiteClosed') . '</strong>' : $engine->_t('SiteOpened')); ?>
				&nbsp;&nbsp;
				<?php echo $engine->_t('ApVersion') . ' ' . $engine->db->wacko_version; ?>
			</span>
		</div>
		<br style="clear: right" />
		<div id="sections">
			<a href="<?php echo rtrim($engine->db->base_url) . '" title="' . $engine->_t('ApHomePageTip') . '">' . $engine->_t('ApHomePage') . '</a>'; ?>
			<a href="<?php echo rtrim($engine->db->base_url) . 'admin.php?action=logout" title="' . $engine->_t('ApLogOutTip')  . '">' . $engine->_t('ApLogOut')  . '</a>'; ?>
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
			echo $menu;
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
	if (function_exists('admin_' . $_REQUEST['mode']) === true)
	{
		// page context
		$engine->tag = $engine->supertag = 'admin.php?mode=' . $_REQUEST['mode'];
		$engine->context[++$engine->current_context] = $engine->tag;

		// module run
		$exec = 'admin_' . $_REQUEST['mode'];
		$exec($engine, $module[$_REQUEST['mode']]);

		$engine->current_context--;
	}
	else
	{
		echo '<br /><br /><em>' . Ut::perc_replace($engine->_t('ErrorLoadingModule'), '<code>' . $_REQUEST['mode'] . '.php</code>') . '</em>';
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

// that's all
