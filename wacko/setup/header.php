<?php

// run in tls mode?
if ($config['tls'] == true && (( ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') && !empty($config['tls_proxy'])) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ) ))
{
	$config['base_url'] =	str_replace('http://', 'https://'.($config['tls_proxy'] ? $config['tls_proxy'].'/' : ''), $config['base_url']);
}

function my_location()
{
	global $config;

	// run in tls mode?
	if ( ($config['tls'] == true
		&& ( ( ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' )
				&& !empty($config['tls_proxy']) )
			|| ( isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ) ) )
		|| ( ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' )
			|| ( isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ) )
	)
	{
		$config['base_url'] =	str_replace('http://', 'https://'.($config['tls_proxy'] ? $config['tls_proxy'].'/' : ''), $config['base_url']);
	}

	list($url, ) = explode('?', $config['base_url']);
	return $url;
}

// Draws a tick or cross next to a result
function output_image($ok)
{
	global $lang;
	return '<img src="'.my_location().'setup/image/spacer.png" width="20" height="20" alt="'.($ok ? $lang['OK'] : $lang['Problem']).'" title="'.($ok ? $lang['OK'] : $lang['Problem']).'" class="tickcross '.($ok ? 'tick' : 'cross').'" />';
}

function is__writable($path)
{
	// http://uk2.php.net/manual/en/function.is-writable.php
	// legolas558 d0t users dot sf dot net - 02-Mar-2007 08:18
	// Will work in despite of Windows ACLs bug
	// NOTE: use a trailing slash for folders!!!
	// see http://bugs.php.net/bug.php?id=27609
	// see http://bugs.php.net/bug.php?id=30931

	if($path{strlen($path) - 1} == '/') // recursively return a temporary file path
	{
		return is__writable($path.uniqid(mt_rand()).'.tmp');
	}
	else if (is_dir($path))
	{
		return is__writable($path.'/'.uniqid(mt_rand()).'.tmp');
	}

	// check tmp file for read/write capabilities
	$rm	= file_exists($path);
	$f	= @fopen($path, 'a');

	if ($f === false)
	{
		return false;
	}

	fclose($f);

	if(!$rm)
	{
		unlink($path);
	}

	return true;
}

function write_config_hidden_nodes($skip_values)
{
	global $config;

	$config_parameters = array_diff_key($config, $skip_values, array('aliases' => ''));

	if (is_array($config_parameters))
	{
		foreach ($config_parameters as $key => $value)
		{
			if (is_array($value))
			{
				$value = implode(',', $value);
			}

			echo '   <input type="hidden" name="config['.$key.']" value="'.$value.'" />' . "\n";
		}
	}
}

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
?>

<?php

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