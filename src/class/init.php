<?php

// not a class, just bootstrap code for index.php

if (!defined('IN_WACKO'))
{
	exit;
}

define('WACKO_STARTED', microtime(1));

require_once 'config/constants.php';

// setting PHP error reporting
$mode = match(PHP_ERROR_REPORTING) {
	0		=> 0,
	1		=> E_ERROR | E_WARNING | E_PARSE,
	2		=> E_ERROR | E_WARNING | E_PARSE | E_NOTICE,
	3		=> E_ALL ^ (E_NOTICE | E_WARNING),
	4		=> E_ALL ^ E_NOTICE,
	5		=> E_ALL,
	6		=> -1, // uber all
	default	=> E_ALL,
};

error_reporting($mode);

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
