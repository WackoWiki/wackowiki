<?php

// yaur -- yet another uri router

if (!defined('IN_WACKO'))
{
	exit;
}
// Import the Hashids class into the global namespace
use Hashids\Hashids;

class UriRouter
{
	const CODE_VERSION	= 2; // to not read incompatible cached data
	const GLOBALS		= ['G' => '_GET', 'P' => '_POST', 'S' => '_SERVER'];
	private $config		= [];
	private $db;
	private $http;

	public function __construct(&$db, &$http)
	{
		$this->db	= & $db;
		$this->http	= & $http;

		$conf_file	= Ut::join_path(CONFIG_DIR, 'router.conf');
		$cache_file	= Ut::join_path(CACHE_CONFIG_DIR, 'router.conf');

		clearstatcache();

		if (!($conftime = @filemtime($conf_file)))
		{
			$this->aband($conf_file . ' not found');
		}

		// do not read stale or non-writable cachefile
		if (!((@filemtime($cache_file) >= $conftime)
			&& is_writable($cache_file)
			&& ($text = file_get_contents($cache_file))
			&& ($this->config = Ut::unserialize($text))
			&& array_shift($this->config) == self::CODE_VERSION))
		{
			// gather all method handlers available for {method} macro
			$methods = [];

			foreach (Ut::file_glob(HANDLER_DIR, '*/[!_]*.php') as $method)
			{
				$methods[] = pathinfo($method, PATHINFO_FILENAME);
			}

			# Ut::dbg('methods', $methods);

			$this->config = $this->read_config($conf_file, ['method' => implode('|', $methods)]);

			// cache to file
			$text = Ut::serialize(array_merge([self::CODE_VERSION], $this->config));
			// unable to write cache file considered are 'turn config caching off' feature
			@file_put_contents($cache_file, $text);
			@chmod($cache_file, CHMOD_SAFE);
		}
	}

	public function run($vars = [])
	{
		// predefined vars
		$vars['_uri']		= explode('?', $this->http->request_uri)[0];
		$vars['_method']	= $_SERVER['REQUEST_METHOD'];
		$vars['_rewrite']	= $this->db->rewrite_mode;
		$vars['_tls']		= $this->http->tls_session;
		$vars['_ip']		= $this->http->ip;

		// populate router's environment
		$env = ['vars' => $vars, 'changed' => []];

		foreach (self::GLOBALS as $varname)
		{
			$env[$varname] = $GLOBALS[$varname]; // $$varname don't work for _GET & others...
		}

		# Ut::dbg(array_diff_key($env, ['_SERVER' => 0]));
		$this->route($env);
		# Ut::dbg('->', array_diff_key($env, ['_SERVER' => 0]));

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
			# Ut::dbg('_GET', $_GET);
		}

		return $vars;
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
					if (preg_match('#\D#', (string) $var))
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
						$val = preg_replace_callback('#@?(\$[a-j\d])|@?\$\{([\w&]+)\}|\$\$|\$\@#',
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

					// pre-comparison func
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

								$ids = $hashids->decode(preg_replace('#[^a-zA-Z\d]+#', '', $var));

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

							$ok = ((bool) $ok) === ($op == '~');
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
						if ($repl = @$re_place[strtolower($x[3])])
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
					if (!preg_match('#^(\$[a-j\d]|[\w&]+)(:(\w+))?(\?=?|==?|![~=]?|[<>]=|[-=~<>])(.*)$#', $one, $match) ||
						(($match[2] == '!' || $match[2] == '-' || $match[2] == '?') && $match[3] !== ''))
					{
						$this->aband($prefix . 'invalid action "' . $one . '"');
					}

					list ($dummy, $var, $dummy2, $func, $op, $val) = $match;

					if (($op == '~' || $op == '!~')
						&& !(preg_match('/^(hashid:[1-9])$/', $val) || @preg_match($val, '') !== false))
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

				$config[] = [$regex, $actions, $lineno];
			}
		}

		if (!isset($config))
		{
			$this->aband($file . ': empty config');
		}

		if (!$config[0][0])
		{
			$this->aband($file . ':' . $config[0][2] . ': first rule must have regex');
		}

		return $config;
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
		else if ($varname = @self::GLOBALS[$var[0]])
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
