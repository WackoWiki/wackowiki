<?php

define('IN_WACKO', 'wacko');
require_once 'class/init.php';

$config = new Settings;

if (!isset($config->wacko_version) || version_compare($config->wacko_version, WACKO_VERSION, '<'))
{
	new Installer;
	// NEVER BEEN HERE
}

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

Diag::debug($config, $http, $engine);

// closing tags
if (strpos($http->method, '.xml') === false)
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

