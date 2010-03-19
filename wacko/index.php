<?php

// initialize engine api
require('classes/init.php');
$init = new Init();

// define settings
$init->Settings();	// populate from config.inc.php
$init->Settings();	// initialize DBAL and populate from config table
$init->DBAL();
$init->Settings('theme_url',	$init->config['base_url'].'themes/'.$init->config['theme'].'/');
$init->Settings('user_table',	$init->config['table_prefix'].'users');

if ($init->IsLocked() === true)
{
	header('HTTP/1.1 503 Service Temporarily Unavailable');
	echo "The site is temporaily unavailable due to system maintenance. Please try again later.";
	exit;
}

// misc
$init->Request();
$init->Session();

// engine start
$cache	= $init->Cache();
$init->Cache('check');
$engine	= $init->Engine();
$init->Cache('log');

// execute and cache
$init->Engine('run');
$init->Cache('store');
$init->Debug();

// closing tags
if (strpos($init->method, '.xml') === false)
	echo "\n</body>\n</html>";

// out
header('Cache-Control: public');
header('Pragma: cache');
ob_end_flush();

?>
