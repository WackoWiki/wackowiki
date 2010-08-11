<?php

// WackoWiki ADMINISTRATION SUBSYSTEM

// ToDo:
// - rewrite backup/restore modules for more granulated backups,
//   and to span very big tables (> 2-5 Mb) across several
//   backup files
// - write modules for users administration (remove, ban and so on)
// - allow multiple admins login with personal credentials in
//   addition to recovery password login (in case of db corruption)

########################################################
##                  Wacko engine init                 ##
########################################################

// initialize engine api
require('classes/init.php');
$init = new Init();

// define settings
$init->Settings(); // populate from config.inc.php
$init->Settings(); // initialize DBAL and populate from config table
$init->DBAL();
$init->Settings('theme_url',	$init->config['base_url'].'themes/'.$init->config['theme'].'/');
$init->Settings('user_table',	$init->config['table_prefix'].'user');

// misc
$init->Session();

// start engine
$cache	= $init->Cache();
$engine	= $init->Engine();

// register locale resources
$init->Engine('res');

// reconnect securely in ssl mode
if ($engine->config['ssl'] == true)
{
	if ( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != "on" && empty($engine->config['ssl_proxy'])) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '443' ))
	{
		$engine->Redirect(str_replace('http://', 'https://'.($engine->config['ssl_proxy'] ? $engine->config['ssl_proxy'].'/' : ''), $engine->config['base_url']).'admin.php');
	}
	else
	{
		$engine->config['base_url'] = str_replace('http://', 'https://'.($engine->config['ssl_proxy'] ? $engine->config['ssl_proxy'].'/' : ''), $engine->config['base_url']);
	}
}

// enable rewrite_mode to avoid href() appends '?page='
if ($engine->config['rewrite_mode'] == false)
{
	$engine->config['rewrite_mode'] = 1;
}

########################################################
##            End admin session and logout            ##
########################################################

if (isset($_GET['action']) && $_GET['action'] == 'logout')
{
	$engine->DeleteCookie('admin');
	$engine->Log(1, $engine->GetTranslation('LogAdminLogout', $engine->config['language']));
	$engine->Redirect(( $engine->config['ssl'] == true ? str_replace('http://', 'https://'.($engine->config['ssl_proxy'] ? $engine->config['ssl_proxy'].'/' : ''), $engine->href()) : $engine->href() ));
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
	echo '<strong>'.$engine->GetTranslation('NoRecoceryPassword').'</strong><br />';
	echo $engine->GetTranslation('NoRecoceryPasswordTip');
	die();
}
else
{
	$pwd = hash('sha1', $engine->config['recovery_password']);
}

// recovery preauthorization
if (isset($_POST['password']))
{
	if (hash('sha1', $_POST['password']) == $pwd)
	{
		$engine->SetSessionCookie('admin', hash('sha1', $_POST['password']), '', ( $engine->config['ssl'] == true ? 1 : 0 ));
		$engine->Log(1, $engine->GetTranslation('LogAdminLoginSuccess', $engine->config['language']));
		$_SESSION['LAST_ACTIVITY'] = time();
		$engine->Redirect('admin.php');
	}
	else
	{
		$engine->Log(1, str_replace('%1', $_POST['password'], $engine->GetTranslation('LogAdminLoginFailed', $engine->config['language'])));
	}
}

// check authorization
$user = "";
if (isset($_COOKIE[$engine->config["session_prefix"].'_'.$engine->config['cookie_prefix'].'admin']) && $_COOKIE[$engine->config["session_prefix"].'_'.$engine->config['cookie_prefix'].'admin'] == $pwd)
{
	$user = array('user_name' => $engine->config['admin_name']);
}

if ($user == false)
{
	header('Content-Type: text/html; charset='.$engine->GetCharset());
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Authorization Admin</title>
	<link href="<?php echo rtrim($engine->config['base_url']); ?>admin/styles/backend.css" rel="stylesheet" type="text/css" media="screen" />
	</head>
	<body>
		<?php
		// here we show messages
		if ($message = $engine->GetMessage()) echo "<div class=\"info\">$message</div>";
		?>

		<strong><?php echo $engine->GetTranslation('Authorization'); ?></strong><br />
		<?php echo $engine->GetTranslation('AuthorizationTip'); ?>
		<br /><br />
		<form action="admin.php" method="post" name="emergency">
			<tt><strong><?php echo $engine->GetTranslation('LoginPassword'); ?>:</strong> <input name="password" type="password" autocomplete="off" value="" />
			<input id="submit" type="submit" value="ok" /></tt>
		</form>
	</body>
	</html>
<?php
	exit;
}
unset($pwd);

// setting temporary admin user context
global $_user;
$_user = $engine->GetUser();
$engine->SetUser($user, 0);

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)) //1800
{
	// last request was more than 15 minutes ago
	$engine->DeleteCookie('admin');
	$engine->Log(1, $engine->GetTranslation('LogAdminLogout', $engine->config['language']));

	//session_destroy();   // destroy session data in storage
	//session_unset();     // unset $_SESSION variable for the runtime
	$engine->SetMessage($engine->GetTranslation("LoggedOut"));
	$engine->Redirect('admin.php');
}

$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

if (!isset($_SESSION['CREATED']))
{
	$_SESSION['CREATED'] = time();
}
else if (time() - $_SESSION['CREATED'] > 1800)
{
	// session started more than 30 minates ago
	session_regenerate_id(true);    // change session ID for the current session an invalidate old session ID
	$_SESSION['CREATED'] = time();  // update creation time
}



########################################################
##                     Page header                    ##
########################################################

header('Content-Type: text/html; charset='.$engine->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>WackoWiki Management System</title>
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
			<a href="<?php echo rtrim($engine->config['base_url']); ?>admin.php"><img src="<?php echo rtrim($engine->config['base_url']); ?>files/wacko4.png" alt="WackoWiki" width="108" height="50"></img></a>
		</div>
		<div id="tools">
			<span style="font-family: 'Lucida Console', 'Courier New', monospace;">

				<?php $time_left = round((1800 - (time() - $_SESSION['CREATED'])) / 60);
				echo "Time left: ".$time_left." minutes"; ?>
				&nbsp;&nbsp;
				<?php echo $engine->ComposeLinkToPage('/', '', rtrim($engine->config['base_url'], '/')); ?>
				&nbsp;&nbsp;
				<?php echo ( $init->IsLocked() === true ? '<strong>site closed</strong>' : 'site opened' ); ?>
				&nbsp;&nbsp;
				version <?php echo $engine->config['wacko_version']; ?>
			</span>
		</div>
		<br style="clear: right" />
		<div id="sections">
			<a href="<?php echo rtrim($engine->config['base_url']); ?>" title="open the home page, you do not quit administration">Home Page</a><a href="<?php echo rtrim($engine->config['base_url']); ?>admin.php?action=logout" title="quit system administration">Log out</a>
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
					echo ( $row['cat'] != $category
						? "</ul>\n</li>\n<li class=\"text submenu2\">".$row['cat']."<ul>\n"
						: "");
					echo ( isset($_REQUEST['mode']) && $_REQUEST['mode'] == $row['mode']
						? "<li class=\"active\">"
						: "<li>" ); ?>
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
if ($message = $engine->GetMessage()) echo "<div class=\"info\">$message</div>";
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
<div id="footer">System <a href="http://wackowiki.org">WackoWiki</a></div>

<?php

// debugging info on script execution time and memory taken
$init->Debug();

?>

</body>
</html>

<?php

########################################################
##             Finishing and cleaning out             ##
########################################################

// getting out of temp context
$engine->SetUser($_user, 0);

?>