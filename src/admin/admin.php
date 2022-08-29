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
	$http->redirect($engine->href('', $db->root_page));
}

// register locale resources
$engine->user_lang		= $engine->get_user_language();
$engine->user_lang_dir	= $engine->get_direction($engine->user_lang);
$engine->set_language($engine->user_lang, true);

// reconnect securely in tls mode
$http->ensure_tls($engine->href('', 'admin.php'));

// clean _POST if no csrf token
$engine->validate_post_token();

########################################################
##            End admin session and logout            ##
########################################################

if (@$_GET['action'] === 'logout')
{
	unset($engine->sess->ap_created, $engine->sess->ap_module);
	$engine->log(1, $engine->_t('LogAdminLogout', SYSTEM_LANG));
	$http->secure_base_url();
	$http->redirect($engine->href('', $db->root_page));
	exit;
}

########################################################
##           Authorization & preparations             ##
########################################################

// missing recovery password
if (!$engine->db->recovery_password)
{
	$engine->http->status(403);
	header('Content-Type: text/html; charset=' . $engine->get_charset());
	?>
	<!DOCTYPE html>
	<html dir="<?php echo $engine->user_lang_dir; ?>" lang="<?php echo $engine->user_lang; ?>">
		<head>
			<title><?php echo $engine->_t('AdminPanel') . ' : ' . $engine->_t('Authorization'); ?></title>
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="robots" content="noindex, nofollow, noarchive">
			<link rel="stylesheet" href="<?php echo $engine->db->base_path; ?>admin/style/backend.css" media="screen">
			<link rel="icon" href="<?php echo $engine->get_favicon(); ?>" type="image/x-icon">
		</head>
		<body>
			<div id="mainwrapper">
				<div id="loginbox">
				<?php
					echo '<strong>' . $engine->_t('NoRecoveryPassword') . '</strong><br><br>';
					echo $engine->_t('NoRecoveryPasswordTip');
				?>
				</div>
			</div>
		</body>
	</html>
	<?php

	die();
}

// recovery preauthorization
if (@$_POST['_action'] === 'ap_login')
{
	if (password_verify(
			base64_encode(
					hash('sha256', $engine->db->system_seed_hash . $_POST['ap_password'], true)
					),
				$engine->db->recovery_password
			)
		)
	{
		$engine->db->cookie_path				= preg_replace('|https?://[^/]+|ui', '', $engine->db->base_url . '');

		$engine->sess->ap_created				=
		$engine->sess->ap_last_activity			= time();
		$engine->sess->ap_failed_login_count	= 0;

		if ($engine->db->ap_failed_login_count > 0)
		{
			$engine->config->set('ap_failed_login_count', 0);
		}

		$engine->log(1, $engine->_t('LogAdminLoginSuccess', SYSTEM_LANG));
		$http->secure_base_url();
		$http->ensure_tls($engine->href('', 'admin.php'));
	}
	else
	{
		$engine->log_user_delay();

		// set default login count
		$engine->sess->ap_failed_login_count ??= 0;

		$engine->config->set('ap_failed_login_count', $engine->db->ap_failed_login_count + 1);
		$engine->log(1, $engine->_t('LogAdminLoginFailed', SYSTEM_LANG));

		++$engine->sess->ap_failed_login_count;

		// RECOVERY_MODE ON || RECOVERY_MODE OFF
		if (   ($engine->sess->ap_failed_login_count >= 4)
			|| ($engine->db->ap_failed_login_count >= $engine->db->ap_max_login_attempts))
		{
			$db->lock(AP_LOCK);
			$engine->log(1, $engine->_t('LogAdminLoginLocked', SYSTEM_LANG));

			$engine->sess->ap_failed_login_count = 0;
		}
	}
}

// check authorization
if (!isset($engine->sess->ap_created))
{
	header('Content-Type: text/html; charset=' . $engine->get_charset());
?>
<!DOCTYPE html>
<html dir="<?php echo $engine->user_lang_dir; ?>" lang="<?php echo $engine->user_lang; ?>">
	<head>
		<title><?php echo $engine->_t('AdminPanel') . ' : ' . $engine->_t('Authorization'); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="noindex, nofollow, noarchive">
		<link rel="stylesheet" href="<?php echo $engine->db->base_path; ?>admin/style/backend.css" media="screen">
		<link rel="icon" href="<?php echo $engine->get_favicon(); ?>" type="image/x-icon">
		<?php if (RECOVERY_MODE) echo '<style>input.verify { display: none; }</style>'; // TODO: fix routing for static files ?>
	</head>
	<body>
		<div id="mainwrapper">
		<?php $engine->output_messages(); ?>
			<div id="loginbox">
				<strong><?php echo $engine->_t('Authorization'); ?></strong><br>
				<?php echo $engine->_t('AuthorizationTip'); ?>
				<br><br>
				<?php echo $engine->form_open('ap_login', ['tag' => 'admin.php']); ?>
					<label for="ap_password"><strong><?php echo $engine->_t('Password'); ?>:</strong></label>
					<?php echo $engine->form_autocomplete_off(); ?>
					<input type="password" name="ap_password" id="ap_password" autocomplete="off" value="" autofocus>
					<button type="submit" id="submit"><?php echo $engine->_t('LoginButton'); ?></button>
				</form>
			</div>
		</div>
	</body>
</html>
<?php
	exit;
}

// setting temporary admin user context
$session_length = 1800; // 1800 -> 30 minutes

if (time() - $engine->sess->ap_last_activity > 900)
{
	// last request was more than 15 minutes ago
	unset($engine->sess->ap_created);
	$engine->log(1, $engine->_t('LogAdminLogout', SYSTEM_LANG));

	$engine->set_message($engine->_t('LoggedOutAuto'));
	$engine->http->redirect($engine->href('', 'admin.php'));
}

$engine->sess->ap_last_activity = time(); // update last activity time stamp

if (time() - $engine->sess->ap_created > $session_length)
{
	$session_expire				= time() + $session_length;
	$engine->sess->ap_created	= time(); // update creation time
}

########################################################
##     Include admin modules and common functions     ##
########################################################
$mode	= $_REQUEST['mode'] ?? null;
$files	= Ut::file_glob('admin/{common,module}/*.php');

if (!isset($engine->sess->ap_module))
{
	foreach ($files as $file_name)
	{
		include $file_name;
	}
}
else if (isset($mode) && in_array('admin/module/' . $mode . '.php', $files))
{
	include 'admin/common/database.php';
	include 'admin/module/' . $mode . '.php';
}
else
{
	include 'admin/module/main.php';
}

########################################################
##     Build menu                                     ##
########################################################

if (isset($engine->sess->ap_module))
{
	$module = $engine->sess->ap_module;
}
else
{
	uasort($module,
		function($a, $b)
		{
			if ((array) $a['order'] < (array) $b['order'])
			{
				return -1;
			}
			else if ((array) $a['order'] > (array) $b['order'])
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
	);

	$engine->sess->ap_module = $module;
}

// add main page to menu
$title = '';
$menu = '<ul><li class="text submenu">' . $engine->_t('CategoryArray')[$module['main']['cat']] .
			($mode == 'main' || (!$_GET && !$_POST)
				? "\n<ul>\n" . '<li class="active">'
				: "\n<ul>\n<li>") .
			'<a href="' . $engine->href() . '" title="' . $engine->_t('main')['title'] . '">' . $engine->_t('main')['name'] . '</a>' .
			"</li>\n";

$category = $module['main']['cat'];

// append modules to menu
foreach ($module as $_mode => $row)
{
	if ($row['status'] === true) // exclude disabled modules
	{
		if ($mode == $_mode || $_mode == 'main')
		{
			$title = $engine->_t('CategoryArray')[$row['cat']] . ' &gt; ' . $engine->_t($_mode)['name'];
		}

		if ($_mode != 'main')
		{
			$menu .= ($row['cat'] != $category
				? "</ul>\n</li>\n" . '<li class="text submenu2">' . $engine->_t('CategoryArray')[$row['cat']] . "<ul>\n"
				: '');

			if ($mode == $_mode)
			{
				$menu .= '<li class="active">';
			}
			else
			{
				$menu .= '<li>';
			}

			$menu .= '<a href="' . $engine->href('', '', ['mode' => $_mode]) . '" title="' . $engine->_t($_mode)['title'] . '">' . $engine->_t($_mode)['name'] . '</a>';
			$menu .= "</li>\n";
		}
		else
		{
			continue;
		}

		$category = $row['cat'];
	}
}

$menu .= "</ul>\n</li>\n</ul>";

unset($category);

########################################################
##                     Page header                    ##
########################################################

header('Content-Type: text/html; charset=' . $engine->get_charset());
?>
<!DOCTYPE html>
<html dir="<?php echo $engine->user_lang_dir; ?>" lang="<?php echo $engine->user_lang; ?>">
	<head>
		<meta charset="<?php echo $engine->get_charset(); ?>">
		<title><?php echo $engine->_t('AdminPanel') . ' : ' . $title; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="noindex, nofollow, noarchive">
		<meta http-equiv="Content-Type" content="text/html;">
		<link rel="stylesheet" href="<?php echo $engine->db->base_path; ?>admin/style/wiki.css" media="screen">
		<link rel="stylesheet" href="<?php echo $engine->db->base_path; ?>admin/style/backend.css" media="screen">
		<link rel="icon" href="<?php echo $engine->get_favicon(); ?>" type="image/x-icon">
	</head>
	<body>
	<div class="wrapper">
	<header id="header">
		<div id="pane">
			<div class="left"></div>
			<div class="middle">
				<h1>
					<a href="<?php echo $engine->href(); ?>" title="<?php echo $engine->_t('AdminPanel'); ?>">
						<?php echo $engine->db->site_name ?? $engine->_t('AdminPanel'); ?>
					</a>
				</h1>
			</div>
			<div id="tools">
				<span>
					<?php
					$time_left = round(($session_length - (time() - $engine->sess->ap_created)) / 60);

					echo (RECOVERY_MODE ? '<strong>' . $engine->_t('RecoveryMode') . '</strong>' : '') . NBSP . NBSP .
						Ut::perc_replace($engine->_t('TimeLeft'), $time_left) . NBSP . NBSP .
						$engine->compose_link_to_page('/', '', $engine->db->base_url, '/') . NBSP . NBSP .
						($db->is_locked() || RECOVERY_MODE ? '<strong>' . $engine->_t('SiteClosed') . '</strong>' : $engine->_t('SiteOpened')) . NBSP . NBSP .
						$engine->_t('ApVersion') . ' ' . $engine->db->wacko_version;
					?>
				</span>
			</div>
			<br style="clear: right;">
			<div id="sections">
				<?php
				echo '<a href="' . $engine->db->base_url . '" title="' . $engine->_t('ApHomePageTip') . '">' . $engine->_t('ApHomePage') . '</a>';
				echo '<a href="' . $engine->href('', '', ['action' => 'logout']) . '" title="' . $engine->_t('ApLogOutTip') . '">' . $engine->_t('ApLogOut') . '</a>';
				?>
			</div>
		</div>
	</header>
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

if (isset($mode) === true && ($_GET || $_POST))
{
	if (function_exists('admin_' . $mode) === true)
	{
		// page context
		$engine->module	= $mode;
		$engine->tag	= $engine->tag = 'admin.php' . ($db->rewrite_mode ? '?' : '&amp;') . 'mode=' . $mode;
		$engine->context[++$engine->current_context] = $engine->tag;

		// module run
		$exec = 'admin_' . $mode;
		$exec($engine, $mode, $tables, $directories);

		$engine->current_context--;
	}
	else
	{
		echo '<br><br><em>' . Ut::perc_replace($engine->_t('ErrorLoadingModule'), '<code>' . $mode . '.php</code>') . '</em>';
	}
}
else if (!($_GET && $_POST))
{
	admin_main($engine, 'main');
}
?>
	<br>
	<!-- end page output -->
		</div>
	</main>
<?php
########################################################
##                     Main Menu                      ##
########################################################
?>
	<nav id="menu">
		<div class="sub">
<?php
			echo $menu;
?>
		</div>
	</nav>
<?php
########################################################
##                     Page footer                    ##
########################################################
?>
	<footer id="footer">System <a href="https://wackowiki.org/">WackoWiki</a></footer>
	<!-- end wrapper -->
	</div>
<?php

// that's all
