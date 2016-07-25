<?php

// push-style (with pull methods for e.g. csrf & i18n) lazy topo-ordered incremental building template engine for WackoWiki

// TODO:

if (!defined('IN_WACKO'))
{
	exit;
}

// templatest compiler and factory

class Templatest
{
	const CODE_VERSION = 2; // to not read incompatible cached data
	private static $store = [];
	private static $filetimes;
	private static $filecount;
	private static $fileidx;
	private static $error;

	static function read($filename, $cache_dir = null)
	{
		$cache = &static::$store[$filename];

		TemplatestFilters::init();

		if (!isset($cache))
		{
			if ($cache_dir)
			{
				$cachefile = Ut::join_path($cache_dir, strtr($filename, '/', ':'));

				clearstatcache();

				// read cache file only if w-bits set - 'turn cache off' feature
				if ((@fileperms($cachefile) & 0222)
					&& ($text = file_get_contents($cachefile))
					&& ($cache = Ut::unserialize($text)))
				{
					if (@$cache[3] != static::CODE_VERSION)
					{
						$cache = null;
					}
					else
					{
						foreach ($cache[2] as $one)
						{
							list ($fname, $ftime) = $one;
							if (!($mtime = @filemtime($fname)) || $mtime != $ftime)
							{
								$cache = null;
								break;
							}
						}
					}
				}
			}

			if (!isset($cache))
			{
				static::$filecount = 0;
				static::$error = 
				static::$fileidx =
				static::$filetimes = [];

				$store = static::parse_file($filename);

				if (!static::$error && !isset($store[0]))
				{
					static::$error[] = 'no main template found';
				}

				// store file meta-info
				$store[1] = $filename;
				$store[2] = static::$filetimes;
				$store[3] = static::CODE_VERSION;

				static::inline_definitions($store);

				foreach ($store as &$meta)
				{
					if (isset($meta['text']))
					{
						static::compile($meta, $store);
					}
				}

				if (static::$error)
				{
					static::aband(implode(', ', static::$error) . ' in ' . $filename);
				}

				// patches & default encodings
				if (isset($store['setup']))
				{
					foreach ($store['setup'] as $one)
					{
						switch ($one[0])
						{
							case 'escape':
								list ($_dummy, $loc, $mode, $patname) = $one;
								foreach ($store as $name => &$pat)
								{
									if (isset($pat['chunks']) && (isset($pat['escape'])? $name === $patname : !$patname))
									{
										$pat['escape'] = $mode;
									}
								}
								break;

							case 'patch':
								list ($_dummy, $loc, $patname, $varname, $value) = $one;
								static::patch($store, $patname, $varname, $value, $loc);
								break;
						}
					}

					unset($store['setup']);
				}

				static::inline_static_subs($store);
				static::inline_defaults($store);

				// cache to file
				// we won't write cache if w-bits is off, per-file 'turn cache off' feature
				if (isset($cachefile) && (!@file_exists($cachefile) || (@fileperms($cachefile) & 0222)))
				{
					$text = Ut::serialize($store);
					file_put_contents($cachefile, $text);
					chmod($cachefile, 0640);
				}

				// cache to factory
				$cache = $store;
			}
		}

		return new TemplatestUser($cache, $cache[0]);
	}

	private static function parse_file($file, $level = 0)
	{
		if ($level > 4)
		{
			static::$error[] = 'too deep template inclusion';
			return [];
		}

		if (!(@is_file($file) && @is_readable($file)))
		{
			static::$error[] = 'template file ' . $file . ' not found';
			return [];
		}

		if (isset(static::$fileidx[$file]))
		{
			$fileidx = static::$fileidx[$file];
		}
		else
		{
			$fileidx = static::$fileidx[$file] = static::$filecount++;
			static::$filetimes[$fileidx] = [$file, filemtime($file)];
		}

		$part = '';
		$store['setup'] = [];
		foreach (file($file) as $lineno => $line)
		{
			if (preg_match('/^\h*\[\h*=+\h*([a-z][a-z0-9]*)\h*=+\h*\]\h*$/i', $line, $match))
			{
				if (!$part && !$level)
				{
					$store[0] = $match[1]; // save first ("main") pattern name in [0]
				}
				$part = $match[1];
				$store[$part]['text'] = [];
				$store[$part]['file'] = $fileidx;
				$store[$part]['line'] = $lineno + 1;
			}
			else if ($part)
			{
				$store[$part]['text'][] = [$lineno + 1, str_replace("\r", '', $line)];
			}
			else
			{
				$act = static::split_tag($line, false);
				$n = count($act);
				// TODO err diags?
				switch ((string) @$act[0])
				{
					case '.escape':
						if ($n == 2 || $n == 3)
						{
							$store['setup'][] = ['escape', $file . ':' . ($lineno + 1), $act[1], @$act[2]];
						}
						break;

					case '.patch':
						if ($n == 4)
						{
							$store['setup'][] = ['patch', $file . ':' . ($lineno + 1), $act[1], $act[2], $act[3]];
						}
						break;

					case '.include':
						if ($n == 2)
						{
							$incl = static::parse_file(Ut::join_path(dirname($file), $act[1]), $level + 1);
							$setup = array_merge($store['setup'], $incl['setup']);
							$store = array_merge($store, $incl);
							$store['setup'] = $setup;
						}
						break;
				}
			}
		}

		return $store;
	}

	private static function inline_definitions(&$store)
	{
		// [ ==== abc def
		//   ....
		// ===== ]
		while (!isset($stable))
		{
			$stable = 0;
			foreach ($store as &$meta)
			{
				if (isset($meta['text']))
				{
					foreach ($meta['text'] as $i => &$numline)
					{
						list ($lineno, $line) = $numline;
						if (preg_match('/^(\h*)\[\h*=+\h*(([a-z][a-z0-9]*)(\h+([a-z][a-z0-9]*))?\b.*?)\h*=+\h*$/i', $line, $match))
						{
							$patname = (isset($match[5]) && $match[5])? $match[5] : $match[3];
							if (isset($store[$patname]))
							{
								static::$error[] = 'double-defined pattern ' . $patname . ' at ' . $store[2][$meta['file']][0] . ':' . $lineno;
							}
							else
							{
								$first = $match;
								$firstline = $i;
								$firstlineno = $lineno;
							}
						}
						else if (preg_match('/^\h*=+\h*\]\h*$/i', $line, $match) && isset($first))
						{
							$replace = $first[1] . "[ '''''' " . $first[2] . " '''''' ]\n";
							$piece = array_splice($meta['text'], $firstline, $i + 1 - $firstline, [[$firstlineno, $replace]]);
							$store[$patname]['text'] = array_slice($piece, 1, -1);
							$store[$patname]['file'] = $meta['file'];
							$store[$patname]['line'] = $firstlineno;
							unset($first);
							unset($stable);
							break;
						}
					}
				}
			}
		}
	}

	private static function compile(&$meta, &$store)
	{
		$text = '';
		$eolpos = 0;
		foreach ($meta['text'] as $numline)
		{
			list ($lineno, $line) = $numline;
			$text .= $line;
			$linepos[$lineno] = ($eolpos += strlen($line));
		}
		unset($meta['text']);

		// pre-compile common \h prefix
		$meta['prefix'] = static::compute_prefix($text);

		$chunks = [];
		$static = 1;
		$offset = 0;
		$chunk = 0; // sorry php, we need to track index instead of using [] appendage

		// if no matches - page is static
		if (preg_match_all('/\[\h*(\'+)(.+?)(\'+)\h*\]/s', $text, $matches, PREG_OFFSET_CAPTURE|PREG_SET_ORDER))
		{
			foreach ($matches as $m)
			{
				// skip tags with unequal amount of lead/trail quotes
				if ($m[1][0] !== $m[3][0])
				{
					continue;
				}

				// offset before and after tag
				$until = $m[0][1];
				$next = $m[0][1] + strlen($m[0][0]);

				// span horizontal spaces around ['...'] tag to find out block or inline usage
				for ($beg = $until; $beg > $offset && ($text[$beg - 1] === ' ' || $text[$beg - 1] === "\t"); --$beg);
				for ($end = $next; isset($text[$end]) && ($text[$end] === ' ' || $text[$end] === "\t"); ++$end);

				if ((!$beg || $text[$beg - 1] === "\n") && (!isset($text[$end]) || $text[$end] === "\n"))
				{
					// block usage - single tag on line with possible whitespace prefix
					$block = substr($text, $beg, $until - $beg);
					$until = $beg;
					$next = $end + 1;
				}
				else
				{
					// inline usage
					$block = false;
				}

				// save static text chunk if not empty
				if ($offset < $until)
				{
					$chunks[$chunk++] = substr($text, $offset, $until - $offset);
				}
				$offset = $next;

				$tag = trim($m[2][0]);
				$pipe = static::split_tag($tag);

				// skip comments and empty tags
				if (!$pipe || !$pipe[0])
				{
					continue;
				}

				// emit placeholder for var/sub/pull patch-ins
				$chunks[$placement = $chunk++] = '';

				// find out line number of tag for diags
				foreach ($linepos as $lineno => $offs)
				{
					if ($until < $offs)
					{
						break;
					}
				}

				$loc = static::$filetimes[$meta['file']][0] . ':' . $lineno;

				$arg = (array) array_shift($pipe);
				$arg0 = (string) $arg[0];
				$narg = count($arg);

				// sugar: var.idx  became  var | .idx
				if ($narg == 1 && ($i = strpos($arg0, '.')) > 0)
				{
					array_unshift($pipe, [substr($arg0, $i)]);
					$arg0 = substr($arg0, 0, $i);
				}

				// common prefix for all actions
				$set = [$placement, $lineno, $block, $pipe];

				$static = 0;
				if ($narg >= 1 && preg_match('/^(\w+):$/', $arg0, $match))
				{
					// pullAction: name
					$set[] = $match[1];
					$set[] = array_slice($arg, 1);
					$meta['pull'][] = $set;
				}
				else if (($narg == 1 && isset($store[$arg0])) || ($narg == 2 && isset($store[$arg[1]])))
				{
					// pattern call, named or not
					$name = $arg0;
					$pat = $arg[$narg - 1];

					if (isset($meta['var'][$name]))
					{
						static::$error[] = 'cannot redefine variable ' . $name . ' at ' . $loc;
					}

					$set[] = $pat;
					$set[] = false;
					$meta['sub'][$name][] = $set;
				}
				else if ($narg == 1 && $arg0 && ctype_alnum($arg0) && ctype_alpha($arg0[0]))
				{
					// variable
					if (isset($meta['sub'][$arg0]))
					{
						static::$error[] = 'cannot redefine subpattern ' . $arg0 . ' at ' . $loc;
					}

					$meta['var'][$arg0][] = $set;
				}
				else
				{
					static::$error[] = 'invalid tag \'' . $tag . '\' at ' . $loc;
				}
			}
		}

		// plain text tail
		if ($offset < strlen($text))
		{
			$chunks[$chunk] = substr($text, $offset);
		}

		$meta['chunks'] = $chunks;
		$static and $meta['static'] = 1;
	}

	public static function set(&$store, &$tpl, $sub, $text, $prefix0 = null, $static = false)
	{
		if ($text === false || $text === null)
		{
			return;
		}

		list ($place, $lineno, $block, $pipe) = $sub;
		$loc = $store[2][$tpl['file']][0] . ':' . $lineno;

		$filter = -1;
		foreach ($pipe as $act)
		{
			$filter = array_shift($act) ?: '';
			if (strpos($filter, '.') !== false)
			{
				array_unshift($act, $filter);
				$filter = 'index';
			}
			else if (!$filter || $filter == 'raw')
			{
				$filter = 'escape';
				array_unshift($act, 'raw');
			}

			if (isset(TemplatestFilters::$filters[$filter]))
			{
				array_unshift($act, $text, $block !== false, $loc);
				$text = call_user_func_array(TemplatestFilters::$filters[$filter], $act);
				if ($text === false || $text === null)
				{
					return;
				}
			}
			else
			{
				trigger_error('unknown filter ' . $filter . ' at ' . $loc, E_USER_WARNING);
			}
		}

		// if last filter is not escape and we set data (not subpattern) - do default escaping
		if ($filter != 'escape' && $filter != 'e' && !isset($prefix0))
		{
			$text = call_user_func(TemplatestFilters::$filters['escape'], $text, $block !== false, $loc, @$tpl['escape'] ?: 'html');
		}

		if ($block !== false)
		{
			$prefix = !Ut::is_empty($prefix0)? $prefix0 : static::compute_prefix($text);

			$lines = explode("\n", $text);
			foreach ($lines as &$line)
			{
				if (strlen($line) > $prefix)
				{
					$line = $block . substr($line, $prefix);
				}
				else
				{
					$line = '';
				}
			}
			$text = implode("\n", $lines);

			if (substr($text, -1) !== "\n")
			{
				$text .= "\n";
			}
		}
		else
		{
			// TODO STS how to trim non-blocks or not?
			// $text = str_replace([\r"\n", '', $text);
			if (substr($text, -1) === "\n")
			{
				$text = substr($text, 0, -1);
			}
		}

		if (isset($prefix0) && isset($tpl['sets'][$place]))
		{
			// precomputed prefix is known for patterns only. so append, for auto-commit
			$tpl['chunks'][$place] .= $text;
		}
		else
		{
			// vars & pulls
			$tpl['chunks'][$place] = $text;
		}

		if (!$static)
		{
			$tpl['sets'][$place] = 1;
		}
	}

	private static function inline_static_subs(&$store)
	{
		// inline static subpatterns
		while (!isset($stable))
		{
			$stable = 0;
			foreach ($store as $name => &$pat)
			{
				if (isset($pat['sub']))
				{
					foreach ($pat['sub'] as $subname => &$sublist)
					{
						foreach ($sublist as $i => &$sub)
						{
							$incl = $store[$sub[4]];

							if (isset($incl['static']))
							{
								static::set($store, $pat, $sub, implode('', $incl['chunks']), $incl['prefix'], 1);

								unset($sublist[$i]);
								if (!$sublist)
								{
									unset($pat['sub'][$subname]);
									if (!$pat['sub'])
									{
										unset($pat['sub']);
										if (!(@$pat['var'] || @$pat['pull']))
										{
											$pat['static'] = 2;
										}
									}
								}

								unset($stable);
							}
						}
					}
				}
			}
		}
	}

	private static function inline_defaults(&$store)
	{
		foreach ($store as $name => &$pat)
		{
			foreach (['sub', 'var'] as $what)
			{
				if (isset($pat[$what]))
				{
					foreach ($pat[$what] as $sublist)
					{
						foreach ($sublist as $sub)
						{
							foreach ($sub[3] as $act)
							{
								if (count($act) == 2 && $act[0] === 'default')
								{
									static::set($store, $pat, $sub, $act[1], null, 1);
								}
							}
						}
					}
				}
			}
		}
	}

	static function patch(&$store, $patname, $varname, $value, $loc)
	{
		if (!isset($store[$patname]['chunks']))
		{
			trigger_error('unknown pattern ' . $patname . ' at ' . $loc, E_USER_WARNING);
		}
		else
		{
			$pat = &$store[$patname];

			if (!isset($pat['var'][$varname]))
			{
				trigger_error('unknown variable ' . $varname . ' at ' . $loc, E_USER_WARNING);
			}
			else
			{
				foreach ($pat['var'][$varname] as &$var)
				{
					Templatest::set($store, $pat, $var, $value, null, 1);
				}
			}
		}
	}

	// find largest common whitespace prefix of pattern, for auto-indent
	private static function compute_prefix($text)
	{
		if (!preg_match_all('/^\h*/m', $text, $prefixes)) // always match at least one time, btw
		{
			return 0;
		}

		$prefixes = $prefixes[0];
		$base = array_shift($prefixes);
		$prefix = strlen($base);
		foreach ($prefixes as $one)
		{
			// nice hack to find index of first differing char in two strings
			if (($diff = strspn($base ^ $one, "\0")) < $prefix)
			{
				$prefix = $diff;
			}
		}

		return $prefix;
	}

	// split tag - var | join ", " | raw | - into arg pipe list
	private static function split_tag($tag, $piping = true)
	{
		$split = preg_match_all('/"(?:\\\\.|[^\\\\"])*"|\'(?:\\\\.|[^\\\\\'])*\'|\||[^\s\|\'"]+/', $tag, $matches)? $matches[0] : [];

		foreach ($split as $i => &$one)
		{
			if ($one[0] == '#' || !strncmp($one, '//', 2))
			{
				$split = array_slice($split, 0, $i);
			}
			else if ($one[0] == '"')
			{
				$one = stripcslashes(substr($one, 1, -1));
			}
			else if ($one[0] == "'")
			{
				$one = str_replace(['\\\\', '\\\''], ['\\', '\''], substr($one, 1, -1));
			}
		}

		if (!$piping)
		{
			return $split;
		}

		$start = 0;
		$n = count($split);
		for ($i = 0; $i < $n; ++$i)
		{
			if ($split[$i] === '|')
			{
				$args[] = array_slice($split, $start, $i - $start);
				$start = $i + 1;
			}
		}
		$args[] = array_slice($split, $start, $n - $start);

		return $args;
	}

	private static function aband($str)
	{
		die('templatest: ' . $str . "\n");
	}
}
