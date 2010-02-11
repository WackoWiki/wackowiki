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
$init->Settings();
$init->Settings();
$init->DBAL();
$init->Settings('root_url',		(preg_replace("#/[^/]*$#","/",$init->config['base_url'])));
$init->Settings('theme_url',	$init->config['root_url'].'themes/'.$init->config['theme'].'/');
$init->Settings('user_table',	$init->config['table_prefix'].'users');

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
	if ($_SERVER['HTTPS'] != 'on')
	{
		$engine->Redirect(str_replace('http://', 'https://', $engine->config['base_url']).'admin.php');
	}
	else
	{
		$engine->config['base_url'] = str_replace('http://', 'https://', $engine->config['base_url']);
		$engine->config['root_url'] = str_replace('http://', 'https://', $engine->config['root_url']);
	}
}

########################################################
##            End admin session and logout            ##
########################################################

if ($_GET['action'] == 'logout')
{
	$engine->DeleteCookie('admin');
	$engine->Log(1, $engine->GetTranslation('LogAdminLogout'));
	$engine->Redirect(( $engine->config['ssl'] == true ? str_replace('http://', 'https://', $engine->href()) : $engine->href() ));
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
	die('<strong>The administrative password is not specified!</strong><br />'.
		'Note: the absence of an administrative password is '.
		'threat to security! Enter your password in the configuration file '.
		'and run the program again.');
}
else
{
	$pwd = md5($engine->config['recovery_password']);
}

// recovery preauthorization
if ($_POST['password'])
{
	if (md5($_POST['password']) == $pwd)
	{
		$engine->SetSessionCookie('admin', md5($_POST['password']), '', ( $engine->config['ssl'] == true ? 1 : 0 ));
		$engine->Log(1, $engine->GetTranslation('LogAdminLoginSuccess'));
		$engine->Redirect('admin.php');
	}
	else
	{
		$engine->Log(1, str_replace('%1', $_POST['password'], $engine->GetTranslation('LogAdminLoginFailed')));
	}
}

// check authorization
if ($_COOKIE[$engine->config["session_prefix"].'_'.$engine->config['cookie_prefix'].'admin']  == $pwd)
{
	$user = array('name' => $engine->config['admin_name']);
}

if ($user == false)
{
	header('Content-Type: text/html; charset='.$engine->GetCharset());
?>
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Authorization Admin</title>
	<link href="<?php echo rtrim($engine->config['base_url']); ?>admin/styles/backend.css" rel="stylesheet" type="text/css" media="screen" />
	</head>
	<body>
		<strong>Authorization</strong><br />
		Please enter the administrative password (make also sure
		that cookies are allowed in your browser).<br /><br />
		<form action="admin.php" method="post" name="emergency">
			<tt><strong>Password:</strong> <input name="password" type="password" autocomplete="off" value="" />
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
			<a href="<?php echo rtrim($engine->config['base_url']); ?>admin.php"><img src="<?php echo rtrim($engine->config['base_url']); ?>files/wacko4.gif" alt="WackoWiki" width="108" height="50"></img></a>
		</div>
		<div id="tools">
			<span style="font-family: 'Lucida Console', 'Courier New', monospace;">
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
	<div id="menu_bookmarks" class="menu">
		<div class="sub">
			<ul>
			<li class="text submenu"><?php echo $module['lock']['cat']; ?>
			<?php echo ( $_REQUEST['mode'] == 'lock' || (!$_GET && !$_POST)
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
					echo ( $_REQUEST['mode'] == $row['mode']
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