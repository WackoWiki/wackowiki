<?php

define('IN_WACKO', 'wacko');
require_once 'class/init.php';

$db = new Settings;

if (!isset($db->wacko_version) || version_compare($db->wacko_version, WACKO_VERSION, '<'))
{
	Installer::run($db);
	// NEVER BEEN HERE
}

if ($db->ext_bad_behavior)
{
	require_once 'lib/bad_behavior/bad-behavior-wackowiki.php'; // uses $db
}

$http = new Http($db);

$router = new UriRouter($db);
$route = $router->run(['_tls' => $http->tls_session, '_ip' => $http->real_ip]);

$db->ap_mode = ($route['route'] === 'admin');

if ($db->is_locked($db->ap_mode? AP_LOCK : SITE_LOCK) || (!$db->ap_mode && RECOVERY_MODE))
{
	$http->status(503);
	echo 'The site is temporarily unavailable due to system maintenance. Please try again later.';
	exit;
}

if (isset($route['session']))
{
	$http->http_security_headers();
	$http->session();
}

if (isset($route['engine']))
{
	$engine = new Wacko($db, $http);
}

switch ($route['route'])
{
case 'static':
	$http->sendfile($route['static']);
	$http->terminate();

case 'admin':
	$config = & $db;
	include 'admin/admin.php';
	break;

case 'wacko':
	$http->check_cache($route['page'], $route['method']);
	$engine->run($route['page'], $route['method']);
	$http->store_cache();
	break;
}

finalize($db, $http, $engine);
