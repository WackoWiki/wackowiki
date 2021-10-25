<?php

const IN_WACKO = 'wacko';
include 'lib/mb_extends/mb_extends.php';
include 'class/init.php';

$db = new Settings;

if ($db->ext_bad_behavior)
{
	include 'lib/bad_behavior/bad-behavior-wackowiki.php'; // uses $db
}

$http = new Http($db);

$router = new UriRouter($db, $http);
$route = $router->run(['_install' => (int)(!isset($db->wacko_version) || version_compare($db->wacko_version, WACKO_VERSION, '<'))]);

$db->ap_mode = ($route['route'] === 'admin');

if (($db->is_locked($db->ap_mode? AP_LOCK : SITE_LOCK) && !isset($route['unlock'])) || (!$db->ap_mode && RECOVERY_MODE))
{
	$http->status(503);
	echo 'The site is temporarily unavailable due to system maintenance. Please try again later.';
	exit;
}

if (isset($route['session']))
{
	$http->http_security_headers();
	$http->session($route['session']);
}

if (isset($route['engine']))
{
	$engine = new Wacko($db, $http);
	$http->sess && $engine->session_notice($http->sess->message());
}

switch ($route['route'])
{
	case 'install':
		Installer::run($db);
		// NEVER BEEN HERE

	case 'static':
		$http->sendfile($route['static'], null, $route['age']);
		$http->terminate();

	case 'freecap':
		$http->no_cache();
		$sess = & $http->sess;
		include 'lib/captcha/freecap.php';
		$http->terminate();

	case 'admin':
		include 'admin/admin.php';
		break;

	case 'wacko':
		$http->check_cache($route['page'], $route['method']);
		$engine->run($route['page'], $route['method']);
		$http->store_cache();
		break;
}

include 'class/final.php';
