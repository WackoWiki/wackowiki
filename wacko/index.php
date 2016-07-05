<?php

define('IN_WACKO', true);
require_once('config/constants.php');
require_once('lib/utility.php');
class_autoloader(join_path(CONFIG_DIR, 'autoload.conf'));

$config = new Settings;

$init = new Init($config);

$init->installer(); // install

if ($config->is_locked() || RECOVERY_MODE)
{
	if (!headers_sent())
	{
		header('HTTP/1.1 503 Service Temporarily Unavailable');
	}

	echo 'The site is temporarily unavailable due to system maintenance. Please try again later.';
	exit;
}

$config->ap_mode = false;

// run in tls mode?
if ($config->tls && (( ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') && !empty($config->tls_proxy)) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ) ))
{
	$config->base_url = str_replace('http://', 'https://' . ($config->tls_proxy ? $config->tls_proxy . '/' : ''), $config->base_url);
	$config->theme_url = str_replace('http://', 'https://' . ($config->tls_proxy ? $config->tls_proxy . '/' : ''), $config->theme_url);
}

$http = new Http($config);
$engine = new Wacko($config, $http);

if (!empty($config->ext_bad_behavior))
{
	require_once('lib/bad_behavior/bad-behavior-wackowiki.php');
}

$engine->run();

$http->store_cache();

$init->debug($engine);

// closing tags
if (strpos($init->method, '.xml') === false)
{
	echo "\n</body>\n</html>";
}

// out
if ( !headers_sent() )
{
	header('Cache-Control: public');
	header('Pragma: cache');
}

ob_end_flush();

