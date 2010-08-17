<?php

// initialize engine api
require('classes/init.php');
$init = new Init();

// define settings
$init->Settings();	// populate from config.inc.php
$init->Settings();	// initialize DBAL and populate from config table
$init->DBAL();
$init->Settings('theme_url',	$init->config['base_url'].'themes/'.$init->config['theme'].'/');
$init->Settings('user_table',	$init->config['table_prefix'].'user');
$init->Settings('cookie_hash',	hash('sha1', $init->config['base_url'].$init->config['system_seed']));
// run in ssl mode?
echo "<br />base_url 1: ".$init->config['base_url'];
if ($init->config['ssl'] == true && (( ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") && !empty($init->config['ssl_proxy'])) || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443') ) ))
{
	$init->Settings('base_url',	str_replace("http://", "https://".($init->config['ssl_proxy'] ? $init->config['ssl_proxy'].'/' : ''), $init->config['base_url']));
}
$init->Settings('cookie_path',	preg_replace('|https?://[^/]+|i', '', $init->config['base_url'].''));
echo "<br />base_url 2: ".$init->config['base_url'];
echo "<br />cookie_path 1".$init->config['cookie_path']."<br />";

if ($init->IsLocked() === true)
{
	header('HTTP/1.1 503 Service Temporarily Unavailable');
	echo "The site is temporarily unavailable due to system maintenance. Please try again later.";
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
