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
 * no need to sync ALL languages manually - just edit english and push
 * changes to other langs (new messages will be english, though, and if
 * translation is available but you change %1 or other formatting - be
 * aware: it is better to remove it, resync to other langs, than add
 * new, resync again. translation would be lost, though)
 *
 * you can massively rename resource names, without losing available localizations:
 * use meta-comment in parent (first in cmd line) file:
	// RENAME OldTag NewTag
	'NewTag' => ...
 * note that resource himself must be manually renamed in parent.
 * after running 'relang wacko.en.php wacko.??.php' then - RENAME comment will be stripped from .en. too
 * NB sorry "feature": if RENAMEs is the only change requested - nothing
 * will be done except cutting it from parent file. just make one spare
 * change (insert empty line) - run relang - than remove empty line -
 * re-run relang :)
 *
 * enjoy! /sts
 *
 *//// NB /*...*/ comments in language files not supported!

$wacko = __DIR__ . '/../../wacko/'; // <---- up yours!

if (count(@$argv) < 3)
{
	die("usage: relang.php parent.lang.php other.lang.php [....]\n");
}

const IN_WACKO = 1;
require_once $wacko . 'class/ut.php';
function v($x) { echo Ut::stringify($x) . "\n"; }

require_once $wacko . 'config/constants.php';
require_once $wacko . 'lib/php-diff/Diff.php';

$renames = [];

function parse($fname)
{
	global $contents;
	static $defvar = false;

	if (($contents = file_get_contents($fname)) === false) die("no $fname\n");
	$contents = trim($contents);

	$parent = 0;
	if (!preg_match('/\$([\w_]+)\s*=\s*\[/', $contents, $match))
	{
		if (!$defvar) die("no var in $fname\n");
		$var = $defvar;
	}
	else
	{
		$var = $match[1];
		if ($defvar)
		{
			if ($defvar != $var) die("invalid var $var in $fname\n");
		}
		else
		{
			$parent = 1;
			$defvar = $var;
		}
	}

	ob_start();
	include $fname;
	if (!isset($$var)) die("no var in $fname");
	ob_end_clean();
	$var = &$$var;

	$cur = 0;
	$accum = '';
	$cmt = 0;
	foreach (explode("\n", $contents) as $line)
	{
		if ($parent && preg_match('#^\s*//\s*RENAME\s+(\S+)\s+(\S+)\s*$#', $line, $match))
		{
			global $renames;
			$renames[$match[1]] = $match[2];
			continue;
		}

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

			if (str_ends_with($clean, ','))
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

function renamer($line, $from, $to)
{
	if (!preg_match('/^(\s*["\'])([^"\']+)([\'"]\s*=>.*$)/Ds', $line, $match) || $match[2] !== $from)
	{
		die("rename $from line mismatch: $line\n");
	}
	return $match[1] . $to . $match[3];
}

$a1 = parse($argv[1]);

// $renames maps old -> new
// $rerenames maps new -> old
$rerenames = array_flip($renames);
foreach ($renames as $old => $new)
{
	if (isset($a1[$old]))		die("renamed $old found in {$argv[1]}\n");
	if (!isset($a1[$new]))		die("new renamed $new not found in {$argv[1]}\n");
}

$cache1 = [];
$a = [];

foreach ($a1 as $key => $data)
{
	if ($key[0] == '#')
	{
		if (trim($data))
		{
			$key = hash('sha1', $data);
			$cache1[$key] = $data;
		}
		else
		{
			$key = '';
		}
	}
	$a[] = $key;
}

for ($arg = 2; isset($argv[$arg]); ++$arg)
{
	$b1 = parse($argv[$arg]);

	$cache = $cache1;
	$b = [];

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
		else
		{
			if (isset($renames[$key]))
			{
				$key = $renames[$key];
			}
		}
		$b[] = $key;
	}

	$diff = new Diff($b, $a, ['context' => 1000000]);

	if (($edits = $diff->getGroupedOpcodes()))
	{
		$output = '';
		foreach ($edits as $group)
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
				[$tag, $i1, $i2, $j1, $j2] = $code;
				if ($tag == 'equal')
				{
					foreach ($diff->GetB($j1, $j2) as $line)
					{
						$output .= !$line
							? "\n"
							: ($cache[$line] ?? ((($old = @$rerenames[$line]) && isset($b1[$old]))
								? renamer($b1[$old], $old, $line)
								: $b1[$line]));
					}
				}
				else if ($tag == 'replace' || $tag == 'insert')
				{
					foreach ($diff->GetB($j1, $j2) as $line)
					{
						$output .= !$line
							? "\n"
							: ($cache[$line] ?? ($b1[$line] ?? $a1[$line]));
							// : ((($old = @$rerenames[$line]) && isset($b1[$old]))? renamer($b1[$old], $old, $line)
					}
				}
			}
		}

		$output = trim($output);
		if (str_ends_with($output, '?>'))
		{
			$output = trim(substr($output, 0, -2));
		}

		if ($output != $contents)
		{
			@rename($argv[$arg], $argv[$arg] . '.orig');
			file_put_contents($argv[$arg], $output . "\n");
		}
		// else - no changes
	}
}
