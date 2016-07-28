<?php

/*
 * assorted utility functions used throughout wackowiki
 */

if (!defined('IN_WACKO'))
{
	exit;
}

class Ut
{
	static function untag($xml, $tag)
	{
		$z = strpos ($xml, "<$tag>");

		if ($z !== false)
		{
			$z += strlen ($tag) + 2;
			$z2 = strpos ($xml, "</$tag>");

			if ($z2 !== false)
			{
				$final = substr ($xml, $z, $z2 - $z);

				if (strpos($final, '<![CDATA[') === 0)
				{
					$final = substr($final, 9);
					$final = substr($final, 0, strlen($final) - 3);
				}

				return $final;
			}
		}

		return '';
	}

	/*
	 * str_replace('%1', ...) replacer:
	 * e.g. perc_replace('one = %1, three = %3, two = %2', 11, 22, 33)
	 */
	static function perc_replace()
	{
		$args = func_get_args();
		return preg_replace_callback('/%[1-9]/', function ($x) use ($args) { return ($i = $x[0][1]) < count($args)? $args[$i] : $x[0]; }, $args[0]);
	}

	// Generate random token of defined $length that satisfy the complexity rules:
	// containing n > 0 of uppercase ($uc), lowercase ($lc), digits ($di) and symbols ($sy).
	// The token complexity can be defined in $token_complexity :
	//		$token_complexity = 2 -- token consists of uppercase, lowercase, digits
	//		$token_complexity = 3 -- token consists of uppercase, lowercase, digits and symbols
	// default complexity is safe alphanumeric
	static function random_token($length = 10, $token_complexity = 2)
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
			$used		= [];
			$token		= '';
			$complexity	= 0;

			for ($i = 0; $i < $length; $i++)
			{
				$class = Ut::rand(0, $token_complexity);
				$token .= $syms[$class][Ut::rand(0, strlen($syms[$class]) - 1)];

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
	static function stringify($x, $compact = 0, $full = 1)
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
				if (($v = Ut::stringify($v, $compact, $full)) === false)
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
					$k = Ut::stringify($k);
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
	static function debug_print_r($array)
	{
		echo '<pre>';
		print_r($array);
		echo '</pre>';
	}

	static function dbg()
	{
		static $running = 1;

		if ($running)
		{
			$trace = debug_backtrace();
			$callee = (strpos($trace[0]['file'], 'class/ut.php') !== false)? $trace[1] : $trace[0];
			$dir = dirname(dirname(__FILE__)) . '/';
			$tag = str_replace($dir, '', $callee['file']) . ':' . $callee['line'] . ': ';

			$args = func_get_args();

			foreach ($args as &$arg)
			{
				if (!is_string($arg) || $arg === '' || preg_match('/[\x00-\x1f\x7f]/', $arg))
				{
					$arg = Ut::stringify($arg);
				}
			}

			$running = @file_put_contents('DEBUG', date('ymdHis ') . $tag . implode(' ', $args) . "\n", FILE_APPEND);
		}
	}

	static function backtrace($trace = null)
	{
		$trace or $trace = debug_backtrace();

		$list = [];
		$dir = dirname(dirname(__FILE__)) . '/';
		foreach ($trace as $i => $frame)
		{
			if (isset($frame['function']) && $i)
			{
				$list[] = (isset($frame['class'])? $frame['class'] . '::' : '') . $frame['function'];
			}

			if (isset($frame['file']))
			{
				$list[] = str_replace($dir, '', $frame['file']) . ':' . $frame['line'];
			}
		}

		return implode(' -> ', array_reverse($list));
	}

	// helper for error diags in classes: return file:line from where class method called from out of class
	static function callee($class_filter)
	{
		$bt = debug_backtrace();
		$dir = dirname(dirname(__FILE__)) . '/';
		$res = '?';
		foreach ($bt as $frame)
		{
			if (fnmatch($class_filter, (string) @$frame['class']) && isset($frame['file']))
			{
				$res = str_replace($dir, '', $frame['file']) . ':' . $frame['line'];
			}
		}
		return $res;
	}

	// join_path('/home/sts', 'dev/', './a.c')  ==> '/home/sts/dev/a.c'
	// removes .. from path - if .. is a first element in result - return FALSE
	// never emits trailing /
	static function join_path()
	{
		$args = func_get_args();

		if (count($args) == 1 && is_array($args[0]))
		{
			$args = $args[0];
		}

		$parts		= [];
		$absolute	= -1;

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

	// file_glob($directory, '{,.}*') --> returns list of all files (not directories)
	static function file_glob()
	{
		return array_filter(Ut::expand_braces(Ut::join_path(func_get_args())),
			function ($x)
			{
				return substr($x, -1) != '/';
			});
	}

	static function expand_braces($text)
	{
		if (preg_match('/^(.*?)\{([^{}]*)\}(.*)$/', $text, $match))
		{
			$res = [];
			foreach (explode(',', $match[2]) as $part)
			{
				$res = array_merge($res, Ut::expand_braces($match[1] . $part . $match[3]));
			}
			return $res;
		}
		return (array) glob($text, GLOB_MARK | GLOB_NOSORT);
	}

	// delete all (or older than $ttl seconds) files in directory
	static function purge_directory($directory, $ttl = 0)
	{
		$n		= 0;
		$past	= time() - $ttl;

		clearstatcache();

		foreach (Ut::file_glob($directory, GLOB_ALL) as $file)
		{
			if ((!$ttl || filemtime($file) < $past) && unlink($file))
			{
				++$n;
			}
		}

		return $n;
	}

	static function html($string, $double_encode = true)
	{
		return htmlspecialchars($string, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET, $double_encode);
	}

	static function serialize($data, $options = 0)
	{
		if (!($text = json_encode($data, $options | JSON_UNESCAPED_SLASHES)))
		{
			// json_encode can fail due to utf8 miscoding, so fallback..
			$text = serialize($data);
		}
		return $text;
	}

	static function unserialize($text)
	{
		return 
			(substr($text, 1, 1) === ':' && ctype_lower($text[0]))
				? unserialize($text)
				: json_decode($text, true);
	}

	static function random_bytes($length)
	{
		if ($length <= 0)
		{
			return '';
		}

		if (function_exists('random_bytes'))
		{
			$bytes = @random_bytes($length); // we can live with bad randomness source exception
			if ($bytes)
			{
				return $bytes;
			}
		}

		$sha = '';

		if (function_exists('openssl_random_pseudo_bytes'))
		{
			$sha = openssl_random_pseudo_bytes($length, $strong);
			if ($sha && $strong)
			{
				return $sha;
			}
		}

		if (($fp = @fopen('/dev/urandom', 'rb')))
		{
			$sha .= fread($fp, $length);
			fclose($fp);
		}

		$sha .= microtime(1);

		if (function_exists('mcrypt_create_iv'))
		{
			$sha .= mcrypt_create_iv(21, MCRYPT_DEV_URANDOM);
		}

		$rnd = '';
		for ($i = 0; $i < $length; $i++)
		{
			$sha  = hash('sha256', $sha . mt_rand());
			$rnd .= chr(hexdec(substr($sha, mt_rand(0, 62), 2)));
		}

		return $rnd;
	}

	static function is_empty($val)
	{
		return $val === '' || $val === null || $val === false;
	}

	static function intval($number, $fail_open = false)
	{
		if (is_numeric($number))
		{
			$number += 0;
		}

		if (is_float($number) && $number > ~PHP_INT_MAX && $number < PHP_INT_MAX)
		{
			$number = (int) $number;
		}

		if (is_int($number))
		{
			return $number;
		}

		if ($fail_open)
		{
			return (int) $number;
		}

		throw new TypeError('Expected an integer');
	}

	// from Random_* Compatibility Library 
	// Copyright (c) 2015 Paragon Initiative Enterprises
	static function rand($min, $max)
	{
		$min = Ut::intval($min);
		$max = Ut::intval($max);
		
		if ($min > $max)
		{
			throw new Error('Minimum value must be less than or equal to the maximum value');
		}

		$range = $max - $min;

		if ($range == 0)
		{
			return $min;
		}

		if (!is_int($range))
		{
			$bytes = PHP_INT_SIZE;
			$mask = ~0;
			$valueShift = 0;
		}
		else
		{
			$bits = $bytes = $mask = 0;
			while ($range > 0)
			{
				if ($bits % 8 === 0)
				{
				   ++$bytes;
				}
				++$bits;
				$range >>= 1;
				$mask = ($mask << 1) | 1;
			}
			$valueShift = $min;
		}

		$attempts = 0;
		do
		{
			if ($attempts++ > 128)
			{
				throw new Exception('RNG is broken - too many rejections');
			}

			$randomByteString = Ut::random_bytes($bytes);

			$val = 0;
			for ($i = 0; $i < $bytes; ++$i)
			{
				$val |= ($val << 8) ^ ord($randomByteString[$i]);
			}

			$val &= $mask;
			$val += $valueShift;

		}
		while (!is_int($val) || $val > $max || $val < $min);

		return $val;
	}

	// rfc822/rfc1123 UTC date format used everywhere in http
	// current time by default, or looong ago date for -1
	static function http_date($time = null)
	{
		return gmdate('D, d M Y H:i:s',
			Ut::is_empty($time)? time() : ($time < 0? 444444444 : $time)) . ' GMT';
	}

	static function http64_encode($data)
	{
		return strtr(rtrim(base64_encode($data), '='), '+/', '-_');
	}

	static function http64_decode($data)
	{
		return base64_decode(strtr($data, '-_', '+/'));
	}

	// used to demange href()-built links for use out of html context (e.g. plain text emails)
	static function amp_decode($text)
	{
		return str_replace('&amp;', '&', $text);
	}

	static function strip_spaces($text)
	{
		return str_replace([' ', "\t", "\r", "\n", "\x0b", "\0"], '', $text);
	}
}
