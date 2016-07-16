<?php

// not a class, just bootstrap code for index.php and admin.php

if (!defined('IN_WACKO'))
{
	exit;
}

require_once('config/constants.php');

// Compatibility with the password_* functions that ship with PHP 5.5
if (version_compare(PHP_VERSION, '5.5.0') < 0)
{
	require_once('lib/php_compatibility/password_compat.php');
}

// setting PHP error reporting
switch (PHP_ERROR_REPORTING)
{
	case 0:		error_reporting(0); break;
	case 1:		error_reporting(E_ERROR | E_WARNING | E_PARSE); break;
	case 2:		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); break;
	case 3:		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); break;
	case 4:		error_reporting(E_ALL ^ E_NOTICE); break;
	case 5:		error_reporting(E_ALL); break;
	case 6:		error_reporting(-1); break; // uber all
	default:	error_reporting(E_ALL);
}

//  setting default timezone
if (function_exists('date_default_timezone_set') && function_exists('date_default_timezone_get'))
{
	// Set the timezone to whatever date_default_timezone_get() returns.
	date_default_timezone_set(@date_default_timezone_get());
}

// gzip_compression
if (ini_get('zlib.output_compression'))
{
	ob_start();
}
else if (function_exists('ob_gzhandler'))
{
	ob_start('ob_gzhandler');
}

// don't let cookies ever interfere with request vars
$_REQUEST = array_merge($_GET, $_POST);

if (strstr($_SERVER['SERVER_SOFTWARE'], 'IIS'))
{
	$_SERVER['REQUEST_URI'] = $_SERVER['PATH_INFO'];
}

// install php class autoloader
spl_autoload_register(function($name)
{
	static $map;

	if (!isset($map))
	{
		foreach (file(CONFIG_DIR . '/autoload.conf') as $line)
		{
			if (($line = trim($line)) && ctype_alpha($line[0]))
			{
				$line = preg_split('/\s+/', $line);
				$file = array_shift($line);

				if (file_exists($file))
				{
					foreach ($line as $class)
					{
						$map[$class] = $file;
					}
				}
			}
		}
	}

	if (array_key_exists($name, $map))
	{
		require_once $map[$name];
	}
});

