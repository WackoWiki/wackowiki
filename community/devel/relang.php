#!/usr/local/bin/php
<?php

/*
 * ./relang.php wacko.en.php wacko.bg.php wacko.da.php wacko.de.php wacko.el.php wacko.es.php wacko.et.php wacko.fr.php wacko.hu.php \
 * 			wacko.it.php wacko.nl.php wacko.pl.php wacko.pt.php wacko.ru.php
 *
 * all changes in en.php (first file) will be moved to other files.
 * all deletions will be made.
 * all additions will be made.
 * all reordering will be made (but values remain localized if already was)
 * incl. comments! :)
 *
 * no need to sync ALL languages manually - just edit english and push changes to other langs
 * (new messages will be english, though, and if translation is available but you change %1 or other
 * formatting - be aware: it is better to remove it, resync to other langs, than add new, resync again.
 * translation would be lost, though)
 *
 * enjoy! /sts
 *
 *//// NB /*...*/ comments in language files not supported!

$wacko = '/home/sts/ww/main/wacko/'; // <---- up yours!

require_once $wacko . 'lib/utility.php';
function v($x) { echo stringify($x) . "\n"; }

define('IN_WACKO', 1);
require_once $wacko . 'config/constants.php';
require_once $wacko . 'lib/php-diff/Diff.php';

function parse($fname)
{
	static $defvar = false;

	if (($file = file_get_contents($fname)) === false) die("no $fname\n");

	if (!preg_match('/\$([\w_]+)\s*=\s*array\s*\(/', $file, $match))
	{
		if (!$defvar) die("no var in $fname\n");
		$var = $defvar;
	}
	else
	{
		$var = $match[1];
		if ($defvar && $defvar != $var) die("invalid var $var in $fname\n");
		$defvar = $var;
	}

	ob_start();
	include $fname;
	if (!isset($$var)) die("no var in $fname");
	ob_end_clean();
	$var = &$$var;

	$cur = 0;
	$accum = '';
	$cmt = 0;
	foreach (explode("\n", $file) as $line)
	{
		$block = 0;
		if (preg_match('/^\s*["\']([^"\']+)[\'"]\s*=>/', $line, $match))
		{
			if (array_key_exists($match[1], $var))
			{
				if ($accum)
				{
					if (is_string($cur))
					{
						if (array_key_exists($cur, $data)) die("dupe $cur in $fname\n");
						$data[$cur] = $accum;
					}
					else
					{
						$data['#' . $cmt++] = $accum;
					}
				}
				$cur = $match[1];
				$accum = '';
			}
			else
			{
				$block = 1;
			}
		}

		$accum .= $line . "\n";

		if (is_string($cur) && !$block)
		{
			$clean = rtrim(preg_replace_callback('#\'(\\\\\'|\\\\\\\\|[^\'])*\'|"(\\\\"|\\\\\\\\|[^"])*"|//.*$#',
				function ($x)
				{
					if ($x[0][0] == '"' || $x[0][0] == "'") return $x[0];
					return '';
			}, $line));

			if (substr($clean, -1) == ',')
			{
				if (array_key_exists($cur, $data)) die("dupe $cur in $fname\n");
				$data[$cur] = $accum;
				$accum = '';
				$cur = 0;
			}
		}
	}

	if ($accum)
	{
		if (is_string($cur))
		{
			if (array_key_exists($cur, $data)) die("dupe $cur in $fname\n");
			$data[$cur] = $accum;
		}
		else
		{
			$data['#' . $cmt] = $accum;
		}
	}

	return $data;
}

$a1 = parse($argv[1]);

for ($arg = 2; isset($argv[$arg]); ++$arg)
{
	$b1 = parse($argv[$arg]);

	$cache = [];
	$a = $b = [];

	foreach ($a1 as $key => $data)
	{
		if ($key[0] == '#')
		{
			if (trim($data))
			{
				$key = hash('sha1', $data);
				$cache[$key] = $data;
			}
			else
			{
				$key = '';
			}
		}
		$a[] = $key;
	}

	foreach ($b1 as $key => $data)
	{
		if ($key[0] == '#')
		{
			if (trim($data))
			{
				$key = hash('sha1', $data);
				$cache[$key] = $data;
			}
			else
			{
				$key = '';
			}
		}
		$b[] = $key;
	}


	$output = '';
	$diff = new Diff($b, $a, ['context' => 1000000, 'ignoreWhitespace' => true]);

	foreach ($diff->getGroupedOpcodes() as $group)
	{
		$lastItem = count($group)-1;
		$i1 = $group[0][1];
		$i2 = $group[$lastItem][2];
		$j1 = $group[0][3];
		$j2 = $group[$lastItem][4];

		if ($i1 == 0 && $i2 == 0)
		{
			$i1 = -1;
			$i2 = -1;
		}

		foreach ($group as $code)
		{
			list($tag, $i1, $i2, $j1, $j2) = $code;
			if ($tag == 'equal')
			{
				foreach ($diff->GetB($j1, $j2) as $line)
				{
					$output .= !$line? "\n"
						: (array_key_exists($line, $cache)? $cache[$line]
						: $b1[$line]);
				}
			}
			else if ($tag == 'replace' || $tag == 'insert')
			{
				foreach ($diff->GetB($j1, $j2) as $line)
				{
					$output .= !$line? "\n"
						: (array_key_exists($line, $cache)? $cache[$line]
						: (array_key_exists($line, $b1)? $b1[$line]
						: $a1[$line]));
				}
			}
		}
	}

	if ($output)
		file_put_contents($argv[$arg], trim($output));
}
