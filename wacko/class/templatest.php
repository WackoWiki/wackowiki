<?php

// - patch in .tpl

if (!defined('IN_WACKO'))
{
	exit;
}

// templatest compiler and factory

class Templatest
{
	private static $store = [];
	private static $filetimes;
	private static $error;

	static function read($filename)
	{
		$cache = &static::$store[$filename];

		TemplatestFilters::init();

		if (!isset($cache))
		{
			$cachefile = strtr($filename, '/', ':') . '.cache'; // TODO path

			clearstatcache();

			// do not read stale or non-writable cachefile
			if (($cachetime = @filemtime($cachefile))
				&& (fileperms($cachefile) & 0222)
				&& ($text = file_get_contents($cachefile))
				&& ($cache = Ut::unserialize($text)))
			{
				foreach ($cache[2] as $fname => $ftim)
				{
					if (@filemtime($fname) >= $cachetime)
					{
						$cache = null;
						break;
					}
				}
			}

			if (!isset($cache))
			{
				static::$error = 
				static::$filetimes = [];

				$store = static::parse_file($filename);

				if (!static::$error && !isset($store[0]))
				{
					static::$error[] = 'no main template found';
				}

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
											Templatest::set($pat, $var, $value, null, 1);
										}
									}
								}
								break;
						}
					}

					unset($store['setup']);
				}

				static::inline_static_subs($store);
				static::inline_defaults($store);

				// store file meta-info
				$store[1] = $filename;
				$store[2] = static::$filetimes;

				// cache to file
				if (!@file_exists($cachefile) || (@fileperms($cachefile) & 0222))
				{
					$text = Ut::serialize($store);
					// unable to write cache file considered are 'turn config caching off' feature
					@file_put_contents($cachefile, $text);
					@chmod($cachefile, 0640);
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

		static::$filetimes[$file] = filemtime($file);

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
				$store[$part]['text'] = '';
				$store[$part]['file'] = $file;
				$store[$part]['line'] = $lineno + 1;
			}
			else if ($part)
			{
				$store[$part]['text'] .= str_replace("\r", '', $line);
				$store[$part]['pos'][$lineno + 1] = strlen($store[$part]['text']);
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

	private static function compile(&$meta, &$store)
	{
		$text = $meta['text'];

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
				foreach ($meta['pos'] as $lineno => $offs)
				{
					if ($until < $offs)
					{
						break;
					}
				}

				$loc = $meta['file'] . ':' . $lineno;

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
				$set = [$placement, $loc, $block, $pipe];

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

		unset($meta['text']);
		unset($meta['pos']);
	}

	public static function set(&$tpl, $sub, $text, $prefix0 = null, $static = false)
	{
		list ($place, $loc, $block, $pipe) = $sub;

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
			}
			else
			{
				trigger_error('unknown filter ' . $filter . ' at ' . $loc, E_USER_WARNING);
			}
		}

		// if last filter is not escape and we set data (not subpattern) - do default escaping
		if ($filter != 'escape' && !isset($prefix0))
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

	private static function inline_static_subs(&$tpl)
	{
		// inline static subpatterns
		while (!isset($stable))
		{
			$stable = 0;
			foreach ($tpl as $name => &$pat)
			{
				if (isset($pat['sub']))
				{
					foreach ($pat['sub'] as $subname => &$sublist)
					{
						foreach ($sublist as $i => &$sub)
						{
							$incl = $tpl[$sub[4]];

							if (isset($incl['static']))
							{
								static::set($pat, $sub, implode('', $incl['chunks']), $incl['prefix'], 1);

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

	private static function inline_defaults(&$tpl)
	{
		foreach ($tpl as $name => &$pat)
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
									static::set($pat, $sub, $act[1], null, 1);
								}
							}
						}
					}
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
