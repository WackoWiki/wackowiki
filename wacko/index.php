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

$engine = new Wacko($db, $http);
$engine->run();

$http->store_cache();

Diag::debug($db, $http, $engine);

// closing tags
if (strpos($http->method, '.xml') === false)
{
	echo "\n</body>\n</html>";
}

if (!headers_sent())
{
	header('Cache-Control: public');
	header('Pragma: cache');
}

ob_end_flush();
