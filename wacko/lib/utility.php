<?php
/*
 * assorted utility functions used throughout wackowiki
 */

/*
 * str_replace('%1', ...) replacer:
 * e.g. perc_replace('one = %1, three = %3, two = %2', 11, 22, 33)
 */
function perc_replace()
{
	$args = func_get_args();
	return preg_replace_callback('/%[1-9]/', function ($x) use ($args) { return ($i = $x[0][1]) < count($args)? $args[$i] : $x[0]; }, $args[0]);
}

// Generate random token of defined $length that satisfy the complexity rules:
// containing n > 0 of uppercase ($uc), lowercase ($lc), digits ($di) and symbols ($sy).
// The token complexity can be defined in $token_complexity :
//		$token_complexity = 2 -- token consists of uppercase, lowercase, digits
//		$token_complexity = 3 -- token consists of uppercase, lowercase, digits and symbols
function random_token($length = 10, $token_complexity = 3)
{
	static $syms = [
		'abcdefghijklmnopqrstuvwxyz',
		'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
		'0123456789',
		'-_!@#%^&*(){}[]|~',
	];

	if ($token_complexity >= ($n = count($syms)))
	{
		$token_complexity = $n - 1;
	}
	else if ($token_complexity < 0)
	{
		$token_complexity = 0;
	}

	for (;;)
	{
		$used = [];
		$token = '';
		$complexity = 0;

		for ($i = 0; $i < $length; $i++)
		{
			$class = mt_rand(0, $token_complexity);
			$token .= $syms[$class][mt_rand(0, strlen($syms[$class]) - 1)];

			if (!isset($used[$class]))
			{
				$used[$class] = 1;
				++$complexity;
			}
		}

		if ($complexity >= $token_complexity)
		{
			return $token;
		}
	}
}

// convert any php value to string
// can be safely used json-alike:
//		$str = stringify($some, 1, 0); // $full set to 0 to return false if non-serializable data found
//		if ($str === false) error, some non-serializable types found
//		$some = eval("return $str;")
function stringify($x, $compact = 0, $full = 1)
{
	if (is_null($x))				return "NULL";
	if (is_bool($x))				return $x? "true" : "false";
	if (is_int($x) || is_float($x)) return (string) $x;
	if (is_array($x))
	{
		$array = [];
		$i = 0;

		foreach ($x as $k => $v)
		{
			if (($v = stringify($v, $compact, $full)) === false)
			{
				return false;
			}

			// BTW in php array keys can be of integer or string type ONLY
			if (is_int($k))
			{
				if ($i == $k)
				{
					++$i;
					$array[] = $v;
					continue;
				}

				if ($k > $i)
				{
					$i = $k + 1;
				}
			}
			else
			{
				$k = stringify($k);
			}

			$array[] = $k . ($compact? '=>' : ' => ') . $v;
		}

		return '[' . implode(($compact? ',' : ', '), $array) . ']';
	}
	if (is_string($x))
	{
		if (preg_match('/[\x00-\x1f\x7f]/', $x))
		{
			return '"' . addcslashes($x, "\0..\37\"\\$") . '"';
		}
		else
		{
			return "'" . preg_replace('/\\\\(?=[\\\\\'])|\\\\$|\'/', '\\\\\\0', $x) . "'";
		}
	}

	if (!$full)						return false;
	if (is_object($x))				return '*CLASS:' . get_class($x) . '*';
	if (is_resource($x))			return '*RESOURCE:' . get_resource_type($x) . '*';
	return '*UNKNOWN*';
}

// legacy from wacko class
function debug_print_r($array)
{
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}

function dbg()
{
	static $running = 1;

	if ($running)
	{
		$args = func_get_args();

		foreach ($args as &$arg)
		{
			if (!is_string($arg) || $arg === '' || preg_match('/[\x00-\x1f\x7f]/', $arg))
			{
				$arg = stringify($arg);
			}
		}

		$running = @file_put_contents('DEBUG', date('ymdHis ') . implode(' ', $args) . "\n", FILE_APPEND);
	}
}

function class_autoloader($config)
{
	spl_autoload_register(function($name) use ($config)
	{
		static $map;

		if (!isset($map))
		{
			foreach (file($config) as $line)
			{
				if (($line = trim($line)) && ctype_alpha($line[0]))
				{
					$line = preg_split('/\s+/', $line);
					$file = array_shift($line);

					if (@file_exists($file))
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
			require_once($map[$name]);
		}
	});
}

// join_path('/home/sts', 'dev/', './a.c')  ==> '/home/sts/dev/a.c'
// removes .. from path - if .. is a first element in result - return FALSE
// never emits trailing /
function join_path()
{
    $args = func_get_args();
    if (count($args) == 1 && is_array($args[0]))
    {
		$args = $args[0];
    }

    $parts = [];
    $absolute = -1;
    foreach ($args as $arg)
	{
		if ($absolute === -1 && $arg !== '')
		{
			$absolute = ($arg[0] == '/');
		}
        $parts = array_merge($parts, explode('/', $arg));
    }

	$n = count($parts);
	for ($from = $to = 0; $from < $n; )
	{
		if (($part = $parts[$from++]) == '..')
		{
			if (--$to < 0)
			{
				return false;
			}
		}
		else if (!($part === '' || $part === '.' || $part === null || $part === false))
		{
			$parts[$to++] = $part;
		}
	}

    $path = implode('/', array_slice($parts, 0, $to));

	if ($absolute === true)
	{
		$path = '/' . $path;
	}
	else if ($path === '')
	{
		$path = '.';
	}

	return $path;
}

// file_glob($directory, '*') --> returns list of all files (not directories)
function file_glob()
{
	return array_filter((array) glob(join_path(func_get_args()), GLOB_MARK | GLOB_NOSORT),
		function ($x)
		{
			return substr($x, -1) != '/';
		});
}
