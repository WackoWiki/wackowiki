<?php

// run in tls mode?
if ($config['tls'] && (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443'))
{
	$config['base_url']	= str_replace('http://', 'https://', $config['base_url']);
}

global $config, $translation;

// If we have any config data in the _POST then it means they have somehow navigated backwards,
// so we should preserve their updated values.
if (isset($_POST['config']))
{
	$config_parameters	= $_POST['config'];
	$config				= array_merge($config, $config_parameters);
}

if (   !isset($config['language'])
	|| !preg_match('/^([a-z]{2}(-[a-z]{2})?)$/', $config['language'])
	|| !@file_exists('setup/lang/installer.' . $config['language'] . '.php'))
{
	$config['language'] = 'en';
}

// the only call
$translation = set_language($config['language']);

$separator	= '<div class="fake_hr_separator"><hr></div>';
$title		= !empty($config['wacko_version']) ? _t('TitleUpdate') : _t('TitleInstallation');

// HTTP header with right Charset settings
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html dir="<?php echo _t('LangDir'); ?>" lang="<?php echo $config['language']; ?>">
	<head>
		<meta charset="utf-8">
		<title><?php echo $title . ': ' . WACKO_VERSION . ' - ' . _t($install_action); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="robots" content="noindex, nofollow, noarchive">
		<link rel="stylesheet" href="<?php echo $base_path ?>setup/css/installer.css">
		<link rel="shortcut icon" href="<?php echo $base_path ?>setup/image/favicon.ico" type="image/x-icon">
	</head>
	<body>
		<div class="installer">
			<h1>
				<?php echo $title;?>
				<span class="white"> : </span><?php echo _t($install_action); ?>
			</h1>
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
						$next . _t($action) .
						'</li>' . "\n";
				}
			?>
			</ul>
			<div class="fake_hr">
				<hr>
			</div>
