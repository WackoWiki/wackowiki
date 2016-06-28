<?php

/*
 * miscellaneous utility functions used throughout wackowiki
 */

/*
 * str_replace('%1', ...) replacer:
 * i.e. perc_replace('one = %1, three = %3, two = %2', 11, 22, 33)
 */
function perc_replace()
{
	$args = func_get_args();
	return preg_replace_callback('/%[1-9]/', function ($x) use ($args) { return ($i = $x[0][1]) < count($args)? $args[$i] : $x[0]; }, $args[0]);
}


// Generate random password of defined $length that satisfie the complexity rules:
// containing n > 0 of uppercase ($uc), lowercase ($lc), digits ($di) and symbols ($sy).
// The password complexity can be defined in $pwd_complexity :
//		$pwd_complexity = 2 -- password consists of uppercase, lowercase, digits
//		$pwd_complexity = 3 -- password consists of uppercase, lowercase, digits and symbols
function random_password($length = 10, $pwd_complexity = 3)
{
	static $syms = [
		'abcdefghijklmnopqrstuvwxyz',
		'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
		'0123456789',
		'-_!@#%^&*(){}[]|~',
	];
	if ($pwd_complexity >= ($n = count($syms)))
	{
		$pwd_complexity = $n - 1;
	} else if ($pwd_complexity < 0)
	{
		$pwd_complexity = 0;
	}

	for (;;)
	{
		$used = [];
		$password = '';
		$complexity = 0;
		for ($i = 0; $i < $length; $i++)
		{
			$class = mt_rand(0, $pwd_complexity);
			$password .= $syms[$class][mt_rand(0, strlen($syms[$class]) - 1)];
			if (!isset($used[$class]))
			{
				$used[$class] = 1;
				++$complexity;
			}
		}
		if ($complexity >= $pwd_complexity)
		{
			return $password;
		}
	}
}

// convert any php value to string
function stringify($x, $compact = 0, $full = 1)
{
	if (is_null($x))				return "NULL";
	if (is_bool($x))				return $x? "true" : "false";
	if (is_int($x) || is_float($x)) return (string) $x;
	if (is_array($x))
	{
		$array = $hash = [];
		$i = 0;
		foreach ($x as $k => $v)
		{
			if (($v = stringify($v, $compact, $full)) === false ||
				($kk = stringify($k, $compact, $full)) === false)
			{
				return false;
			}
			if ($i >= 0)
			{
				if ($i++ === $k)
				{
					$array[] = $v;
				}
				else
				{
					$i = -1;
				}
			}
			$hash[] = $kk . ($compact? '=>' : ' => ') . $v;
		}
		return '[' . implode(($compact? ',' : ', '), ($i >= 0)? $array : $hash) . ']';
	}
	if (is_string($x))
	{
		if (preg_match('/[\x00-\x1f\x7f]/', $x))
		{
		    return '"' . addcslashes($x, "\0..\37\"\\$") . '"';
		}
		else
		{
		    return "'" . addcslashes($x, '\'\\') . "'";
		}
	}
	if (!$full)						return false;
	if (is_object($x))				return '*CLASS:' . get_class($x) . '*';
	if (is_resource($x))			return '*RESOURCE:' . get_resource_type($x) . '*';
	return '*UNKNOWN*';
}

