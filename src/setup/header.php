<?php

// run in tls mode?
if ($config['tls'] && (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443'))
{
	$config['base_url']	= str_replace('http://', 'https://', $config['base_url']);
}

require_once 'setup/common.php';
global $config;

// If we have any config data in the _POST then it means they have somehow navigated backwards so we should preserve their updated values.
if (isset($_POST['config']))
{
	$config_parameters	= $_POST['config'];
	$config				= array_merge ($config, $config_parameters);
}

if (   !isset($config['language'])
	|| !preg_match('/^([a-z]{2}(-[a-z]{2})?)$/', $config['language'])
	|| !@file_exists('setup/lang/installer.' . $config['language'] . '.php'))
{
	$config['language'] = 'en';
}

$separator =
'<div class="fake_hr_separator">
	<hr>
</div>';

global $lang;
require_once 'setup/lang/installer.all.php';
require_once 'setup/lang/installer.' . $config['language'] . '.php';
$lang				= array_merge ($lang, $lang_all);

// set default install action
if (!isset($lang[$install_action])) $lang[$install_action] = '';

// HTTP header with right Charset settings
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html dir="<?php echo $lang['LangDir']; ?>" lang="<?php echo $config['language']; ?>">
	<head>
		<meta charset="utf-8">
		<title><?php echo $lang['Title'] . ': ' . WACKO_VERSION . ' - ' . $lang[$install_action]; ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="noindex, nofollow, noarchive">
		<link rel="stylesheet" href="<?php echo $base_path ?>setup/css/installer.css">
		<link rel="shortcut icon" href="<?php echo $base_path ?>setup/images/favicon.ico" type="image/x-icon">
	</head>
	<body>
		<div class="installer">
			<h1><?php echo $lang['Title'];?><span class="white"> : </span><?php echo $lang[$install_action]; ?></h1>
			<ul class="menu">
			<?php
				$next = '';

				foreach (ACTIONS as $i => $action)
				{
					if ($i > 0)
					{
						$next = '<span>&gt; </span>';
					}

					echo
						'<li class="' . ($install_action == $action ? 'current' : 'item') . '">' .
							$next . $lang[$action] .
						'</li>' . "\n";
				}
			?>
			</ul>
			<div class="fake_hr">
				<hr>
			</div>
