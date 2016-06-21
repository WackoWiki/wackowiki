<?php

// run in tls mode?
if ($config['tls'] == true && (( ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') && !empty($config['tls_proxy'])) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ) ))
{
	$config['base_url'] =	str_replace('http://', 'https://'.($config['tls_proxy'] ? $config['tls_proxy'].'/' : ''), $config['base_url']);
}

require_once('setup/common.php');
global $config;

// If we have any config data in the _POST then it means they have somehow navigated backwards so we should preserve their updated values.
if (isset($_POST['config']))
{
	$config = $_POST['config'];
}

if (!isset($config['language']) || !@file_exists('setup/lang/installer.'.$config['language'].'.php'))
{
	$config['language'] = 'en';
}

global $lang;
require_once('setup/lang/installer.'.$config['language'].'.php');

// HTTP header with right Charset settings
header('Content-Type: text/html; charset='.$lang['Charset']);
?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
   <head>
      <meta charset="<?php echo $lang['Charset']; ?>" />
      <title><?php echo $lang['Title'].': '.WACKO_VERSION.' - '.$lang[$install_action]; ?></title>
      <meta name="robots" content="noindex, nofollow, noarchive" />
      <link rel="stylesheet" href="<?php echo my_location() ?>setup/css/installer.css" />
      <link rel="shortcut icon" href="<?php echo my_location() ?>setup/images/favicon.ico" type="image/x-icon" />
   </head>
   <body>
      <div class="installer">
         <h1><?php echo $lang['Title'];?></h1>
         <h1 class="white">&nbsp;:&nbsp;</h1>
         <h1><?php echo $install_action == 'lang' ? $lang['lang'] : $lang[$install_action]; ?></h1>
         <ul class="menu">
            <li class="<?php echo $install_action == 'lang' ? 'current' : 'item'; ?>"><?php echo $lang['lang']; ?></li>
            <li>&gt;</li>
            <li class="<?php echo $install_action == 'version-check' ? 'current' : 'item'; ?>"><?php echo $lang['version-check']; ?></li>
            <li>&gt;</li>
            <li class="<?php echo $install_action == 'site-config' ? 'current' : 'item'; ?>"><?php echo $lang['site-config']; ?></li>
            <li>&gt;</li>
            <li class="<?php echo $install_action == 'database-config' ? 'current' : 'item'; ?>"><?php echo $lang['database-config']; ?></li>
            <li>&gt;</li>
            <li class="<?php echo $install_action == 'database-install' ? 'current' : 'item'; ?>"><?php echo $lang['database-install']; ?></li>
            <li>&gt;</li>
            <li class="<?php echo $install_action == 'write-config' ? 'current' : 'item'; ?>"><?php echo $lang['write-config']; ?></li>
         </ul>
         <div class="fake_hr">
            <hr />
         </div>