<?php

// not a class, just bootstrap code for index.php

if (!defined('IN_WACKO'))
{
	exit;
}

define('WACKO_STARTED', microtime(1));

require_once 'config/constants.php';

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

// set the timezone to whatever date_default_timezone_get() returns.
date_default_timezone_set(@date_default_timezone_get());

ini_set('default_charset', 'UTF-8');

// will compress manually to produce correct Content-Length header
ini_set('zlib.output_compression', 'Off');
ob_start();

// don't let cookies ever interfere with request vars
$_REQUEST = array_merge($_GET, $_POST);

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
