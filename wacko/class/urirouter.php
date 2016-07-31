<?php

// yaur -- yet another uri router

if (!defined('IN_WACKO'))
{
	exit;
}

class UriRouter
{
	const GLOBALS = ['G' => '_GET', 'P' => '_POST', 'S' => '_SERVER'];
	private $config = [];
	private $db;

	public function __construct(&$db)
	{
		$this->db = & $db;

		$conffile = Ut::join_path(CONFIG_DIR, 'router.conf');
		$cachefile = Ut::join_path(CACHE_CONFIG_DIR, 'router.conf');

		clearstatcache();

		if (!($conftime = @filemtime($conffile)))
		{
			$this->aband($conffile . ' not found');
		}

		// do not read stale or non-writable cachefile
		if (!((@filemtime($cachefile) >= $conftime)
			&& is_writable($cachefile)
			&& ($text = file_get_contents($cachefile))
			&& ($this->config = Ut::unserialize($text))))
		{
			// gather all method handlers available for {method} macro
			$methods = [];
			foreach (Ut::file_glob(HANDLER_DIR, '*/[!_]*.php') as $method)
			{
				$methods[] = pathinfo($method, PATHINFO_FILENAME);
			}
			// Ut::dbg('methods', $methods);

			$this->read_config($conffile, ['method' => implode('|', $methods)]);

			// cache to file
			$text = Ut::serialize($this->config);
			// unable to write cache file considered are 'turn config caching off' feature
			@file_put_contents($cachefile, $text);
			@chmod($cachefile, SAFE_CHMOD);
		}
	}

	public function run($vars = [])
	{
		// predefined vars
		$vars['_uri']		= $this->uri_path();
		$vars['_method']	= $_SERVER['REQUEST_METHOD'];
		$vars['_rewrite']	= $this->db->rewrite_mode;

		// populate router's environment
		$env = ['vars' => $vars, 'changed' => []];
		foreach (self::GLOBALS as $varname)
		{
			$env[$varname] = $GLOBALS[$varname]; // $$varname don't work for _GET & others...
		}

		//Ut::dbg(array_diff_key($env, ['_SERVER'=>0]));
		$this->route($env);
		//Ut::dbg('->', array_diff_key($env, ['_SERVER'=>0]));

		$vars = $env['vars'];

		if ($vars['_ok'])
		{
			// backpatch changes into http superglobals
			foreach ($env['changed'] as $varname => $patch)
			{
				if (in_array($varname, self::GLOBALS))
				{
					foreach ($patch as $varidx => $val)
					{
						if ($val === null)
						{
							unset($GLOBALS[$varname][$varidx]);
						}
						else
						{
							$GLOBALS[$varname][$varidx] = $val;
						}
					}
				}
			}
			//Ut::dbg('_GET', $_GET);
		}

		return $vars;
	}

	private function uri_path()
	{
		$script = $_SERVER['SCRIPT_NAME'];
		if (($base = strrpos($script, '/')) === false)
		{
			$this->aband('invalid _SERVER[SCRIPT_NAME]: ' . $script);
		}

		$uri = $_SERVER['REQUEST_URI'];
		if (($i = strpos($uri, '?')) !== false)
		{
			$uri = substr($uri, 0, $i);
		}
		$uri = rawurldecode($uri); // %xx not decoded in REQUEST_URI yet

		if (!strncmp($uri, $script, $base + 1))
		{
			$uri = substr($uri, $base);
		}

		// remove .. path elements
		$uri = preg_replace('#(^|/)\.\.(/|$)#', '/', $uri);

		// remove starting/trailing slashes, and minimize multi-slashes
		$uri = preg_replace_callback('#^/+|/+$|(/{2,})|\s+#',
			function ($x)
			{
				return @$x[1]? '/' : '';
			}, $uri);

		return $uri;
	}

	private function route(&$env)
	{
		$match = 0;
		foreach ($this->config as $line)
		{
			list ($regex, $actions, $lineno) = $line;

			$err = -1;
			if ($regex? ($err = preg_match($regex, $env['vars']['_uri'], $match)) : $match)
			{
				if ($err == 1)
				{
					$env['match'] = $match;
				}
				$backtrack = $env;
				$env['sub'] = [];
				foreach ($env['match'] as $var => $val)
				{
					if (preg_match('#[^\d]#', $var))
					{
						list ($varname, $varidx) = $this->parse_var($var);
						$env[$varname][$varidx] = $val;
						$env['changed'][$varname][$varidx] = $val;
					}
				}
				$env['vars']['_line'] = $lineno;

				foreach ($actions as $action)
				{
					list ($varname, $varidx, $func, $op, $val) = $action;

					if ($op == '?=' && isset($env[$varname][$varidx])) // assign if unset
					{
						continue;
					}

					if ($op == '-') // unset
					{
						unset($env[$varname][$varidx]);
						$env['changed'][$varname][$varidx] = null;
						continue;
					}

					// substitute vars into value
					if (strpos($val, '$') !== false)
					{
						$val = preg_replace_callback('#@?(\$[0-9a-j])|@?\$\{([\w&]+)\}|\$\$|\$\@#',
							function ($x) use (&$env)
							{
								if ($x[0] == '$$' || $x[0] == '$@')
								{
									return $x[0][1];
								}

								list ($varname, $varidx) = $this->parse_var((@$x[1] !== '')? $x[1] : $x[2]);

								if (isset($env[$varname][$varidx]))
								{
									return $env[$varname][$varidx];
								}

								return ($x[0][0] == '@')? '' : ($env = 0);
							}, $val);

						if (!$env)
						{
							break; // substitution failed - unset var used
						}
					}

					// assignments
					if ($op == '!' || $op == '?=' || $op == '=')
					{
						if ($varname == 'vars' && $varidx == 'dbg')
						{
							Diag::dbg('urirouter:', $lineno, $val);
							continue;
						}
						switch ($func)
						{
							case 'tolower':
								$val = strtolower($val);
								break;
							case 'toupper':
								$val = strtoupper($val);
								break;
							case 'int':
								$val = (int) $val;
								break;
						}
						$env[$varname][$varidx] = $val;
						$env['changed'][$varname][$varidx] = $val;
						continue;
					}

					// read var for comparison
					if (isset($env[$varname][$varidx]))
					{
						$var = $env[$varname][$varidx];
					}
					else
					{
						$env = 0;
						break;	// fail - unset var
					}

					// pre-comaprison func
					switch ($func)
					{
						case 'int':
							$var = (int) $var;
							$val = (int) $val;
							break;
					}

					$ok = 0;
					switch ($op)
					{
						case '?': // isset
							$ok = 1;
							break;

						case '~':
						case '!~':
							$exp = explode(':', $val, 2);
							if ($exp[0] == 'hashid')
							{
								static $hashids;
								$seed = $this->db->hashid_seed;
								if (!isset($hashids))
								{
									$hashids = new Hashids($seed);
								}
								$ids = $hashids->decode(preg_replace('#[^a-zA-Z0-9]+#', '', $var));
								if (($n = count($ids)) == $exp[1] + 1)
								{
									$match2 = array_slice($ids, 0, $n - 1);
									$hash = ($n == 2)? $ids[0] . $seed : implode($seed, $match2);
									sscanf(hash('sha1', $hash), '%7x', $cksum);

									if ($ids[$n - 1] == $cksum)
									{
										$ok = 1;
									}
								}
							}
							else
							{
								$ok = preg_match($val, $var, $match2);
							}
							if ($ok && $op == '~')
							{
								$env['sub'] = $match2;
							}
							$ok = (!!$ok) === ($op == '~');
							break;

						case '==':
							$ok = ($var == $val);
							break;

						case '!=':
							$ok = ($var != $val);
							break;

						case '<':
							$ok = ($var < $val);
							break;

						case '>':
							$ok = ($var > $val);
							break;

						case '>=':
							$ok = ($var >= $val);
							break;

						case '<=':
							$ok = ($var <= $val);
							break;
					}
					if (!$ok)
					{
						$env = 0;
						break;
					}
				}

				if (!$env)
				{
					$env = $backtrack; // failed rule
				}
				else if (@$env['vars']['_ok'])
				{
					return;
				}
				else if (@$env['vars']['_next'])
				{
					$env['vars']['_next'] = 0;
					$match = 0;
				}
			}
			else if ($err === false)
			{
				$this->aband('regex match failed: ' . $regex);
			}
			else
			{
				$match = 0;
			}
		}

		$env['vars']['_ok'] = false;
	}

	private function read_config($file, $re_place)
	{
		$lineno = 0;

		foreach (file($file) as $line)
		{
			$prefix = $file . ':' . ++$lineno . ': ';

			// define {} macros
			if (preg_match('/^\s*define\s*\{([^}\s]*)\}\s*(\S+)/', $line, $match))
			{
				$re_place[$match[1]] = $match[2];
				continue;
			}

			$line = preg_split('/[\s]+/', $line); // line started with \s is continuation

			// remove //-comments
			$nf = count($line);
			foreach ($line as $i => $one)
			{
				if (!strncmp($one, '//', 2))
				{
					$nf = $i;
					break;
				}
			}

			// remove trailing empty field
			while ($nf && !$line[$nf - 1])
			{
				--$nf;
			}

			if ($nf)
			{
				// replace {...} tags
				$regex = preg_replace_callback('#\{((\w+?)[:=])?([^}\d]*)\}#',
					function ($x) use (&$re_place)
					{
						if (($repl = @$re_place[strtolower($x[3])]))
						{
							return '(' . (empty($x[2])? '' : '?P<' . $x[2] . '>') . $repl . ')';
						}
						return $x[0];
					}, $line[0]);

				// check main regex for validity
				if ($regex && @preg_match($regex, '') === false)
				{
					$this->aband($prefix . 'invalid regex ' . $regex);
				}

				// compile
				$actions = [];
				foreach (array_slice($line, 1, $nf - 1) as &$one)
				{
					if (!preg_match('#^(\$[0-9a-j]|[\w&]+)(:(\w+))?(\?=?|==?|![~=]?|[<>]=|[-=~<>])(.*)$#', $one, $match) ||
						(($match[2] == '!' || $match[2] == '-' || $match[2] == '?') && $match[3] !== ''))
					{
						$this->aband($prefix . 'invalid action "' . $one . '"');
					}

					list ($dummy, $var, $dummy2, $func, $op, $val) = $match;

					if (($op == '~' || $op == '!~') &&
						!(preg_match('/^(hashid:[1-9])$/', $val) || @preg_match($val, '') !== false))
					{
						$this->aband($prefix . 'invalid pattern ' . $val);
					}

					if ($op == '!')
					{
						$val = 1;
					}

					list ($varname, $varidx) = $this->parse_var($var);

					$actions[] = [$varname, $varidx, $func, $op, $val];
				}

				$this->config[] = [$regex, $actions, $lineno];
			}
		}

		if (!$this->config)
		{
			$this->aband($file . ': empty config');
		}

		if (!$this->config[0][0])
		{
			$this->aband($file . ':' . $this->config[0][2] . ': first rule must have regex');
		}
	}

	private function parse_var($var)
	{
		if ($var[0] == '$' && ctype_digit($var[1]))
		{
			$varidx = (int) $var[1];
			$varname = 'match';
		}
		else if ($var[0] == '$')
		{
			$varidx = ord($var[1]) - ord('a');
			$varname = 'sub'; // submatch
		}
		else if (($varname = @self::GLOBALS[$var[0]]))
		{
			$varidx = substr($var, 1);	 // _GET/etc vars
		}
		else
		{
			$varidx = $var;
			$varname = 'vars';
		}

		return [$varname, $varidx];
	}

	private function aband($str)
	{
		die('urirouter: ' . $str . "\n");
	}
}
