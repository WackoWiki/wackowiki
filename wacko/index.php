<?php

define('IN_WACKO', true);

require_once('lib/utility.php');
class_autoloader('config/autoload.conf');

$config = new Settings;

$init = new Init($config);

$init->installer(); // install

if ($init->is_locked() || RECOVERY_MODE)
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

// misc
$init->request();
$init->session();
$init->http_security_headers();

// engine start
$init->cache();
$init->cache('check');
$init->engine();

if (!empty($config->ext_bad_behavior))
{
	require_once('lib/bad_behavior/bad-behavior-wackowiki.php');
}

// execute and cache
$init->engine('run');
$init->cache('store');
$init->debug();

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
