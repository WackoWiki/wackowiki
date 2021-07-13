<?php

// run in tls mode?
if ($config['tls'] && ((isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ))
{
	$config['base_url'] =	str_replace('http://', 'https://', $config['base_url']);
}

require_once 'setup/common.php';
global $config;

// If we have any config data in the _POST then it means they have somehow navigated backwards so we should preserve their updated values.
if (isset($_POST['config']))
{
	$config_parameters = $_POST['config'];
	$config = array_merge ($config, $config_parameters);
}

if (!isset($config['language']) || !@file_exists('setup/lang/installer.' . $config['language'] . '.php'))
{
	$config['language'] = 'en';
}

$separator =
'<div class="fake_hr_separator">
	<hr>
</div>';

global $lang;
require_once 'setup/lang/installer.' . $config['language'] . '.php';

// set default install action
$lang[$install_action] ??= '';

// HTTP header with right Charset settings
header('Content-Type: text/html; charset=' . $lang['Charset']);
?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
	<head>
		<meta charset="<?php echo $lang['Charset']; ?>">
		<title><?php echo $lang['Title'] . ': ' . WACKO_VERSION . ' - ' . $lang[$install_action]; ?></title>
		<meta name="robots" content="noindex, nofollow, noarchive">
		<link rel="stylesheet" href="<?php echo my_location() ?>setup/css/installer.css">
		<link rel="shortcut icon" href="<?php echo my_location() ?>setup/images/favicon.ico" type="image/x-icon">
	</head>
	<body>
		<div class="installer">
			<h1><?php echo $lang['Title'];?><span class="white"> : </span><?php echo $lang[$install_action]; ?></h1>
			<ul class="menu">
			<?php
				$actions	= ['lang', 'version-check', 'config-site', 'config-database', 'install-database', 'write-config'];
				$next		= '';

				foreach ($actions as $i => $action)
				{
					if ($i > 0)
					{
						$next = '<span>&gt; </span>';
					}

					echo '<li class="' . ($install_action == $action ? 'current' : 'item') . '">' . $next . $lang[$action] . '</li>' . "\n";
				}
			?>
			</ul>
			<div class="fake_hr">
				<hr>
			</div>
