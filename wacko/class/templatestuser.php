<?php

// TODO:
// - error diags: find $loc from debug_backtrace
// - if not sets in instantiated subpat - do not emit it
// + __get to return how many times IT was set

if (!defined('IN_WACKO'))
{
	exit;
}

class TemplatestUser extends TemplatestSetter
{
	private $main;
	private $pulls = [];
	private $sets = [];
	private $root;

	function __construct($template, $main)
	{
		if (!isset($template[$main]['chunks']))
		{
			die('instantiating unknown pattern ' . $main . ' from file ' . $template[1]);
		}

		parent::__construct($template);

		$this->main = $main;

		$tpl = $this->store[$main];
		if (isset($tpl['static']))
		{
			$root['chunks'][0] = implode('', $tpl['chunks']);
		}
		else
		{
			$root['chunks'][0] = '';
			$root['sub'][''][0] = [0, 0, '', [], $main, null];
		}
		$root['file'] = 0;

		$this->root = $root;
	}

	// add pull function
	// pull_function($is_block, $call_location[, ...args])
	function pull($id, $func)
	{
		$this->pulls[$id] = $func;
	}

	// clone by pattern name
	function __call($name, $args)
	{
		$clone = new TemplatestUser($this->store, $name);
		$clone->pulls = $this->pulls;
		$clone->setEncoding($this->getEncoding());
		$clone->setFilters($this->getFilters());
		return $clone;
	}

	private function commit($pat)
	{
		if (isset($pat['pull']))
		{
			foreach ($pat['pull'] as $pull)
			{
				list ($_place, $lineno, $block, $_pipe, $id, $args) = $pull;
				$loc = $this->store[2][$pat['file']][0] . ':' . $lineno;

				if (!isset($this->pulls[$id]))
				{
					die('using unknown pull ' . $id . ': at ' . $loc);
				}

				// single place from where pull: handlers called
				array_unshift($args, $block !== false, $loc);
				$this->assign($pat, $pull, call_user_func_array($this->pulls[$id], $args));
			}
		}

		if (isset($pat['sub']))
		{
			foreach ($pat['sub'] as $subs)
			{
				foreach ($subs as $sub)
				{
					if (($data = $sub[5]))
					{
						$this->assign($pat, $sub, $this->commit($data), $data['prefix']);
					}
				}
			}
		}

		return implode('', $pat['chunks']);
	}

	function __toString()
	{
		return $this->commit($this->root);
	}

	function __invoke()
	{
		$this->set(func_get_args());
	}

	function __get($name)
	{
		return (int) @$this->sets[$name];
	}

	function __set($name, $value)
	{
		$path = explode('_', $name);
		foreach ($path as $part)
		{
			if (!$part || !ctype_alpha($part[0]))
			{
				$path = [];
				break;
			}
		}

		if (($n = count($path)) < 1)
		{
			trigger_error('invalid template variable ' . $name, E_USER_WARNING);
			return;
		}

		$this->set($path, $value);

	}

	// set(['a', 'b'], 'text')
	// set('a', 'b', 'text')
	// set('a.b', 'text')
	function set()
	{
		if (!isset($this->root['sub']))
		{
			trigger_error('nothing to set in pattern ' . $this->main, E_USER_WARNING);
			return;
		}

		$args = func_get_args();
		if (count($args) == 1 && is_array($args[0]))
		{
			$args = $args[0];
		}

		if (($nargs = count($args)) < 2)
		{
			trigger_error('template set need > 1 args', E_USER_WARNING);
			return;
		}

		$value = $args[$nargs - 1];
		if ($value === false || $value === null)
		{
			return;
		}

		if ($nargs == 2)
		{
			$path = is_array($args[0])? $args[0] : explode('.', $args[0]);
		}
		else
		{
			$path = array_slice($args, 0, $nargs - 1);
		}

		$rec = function (&$super, &$sub, $i) use (&$rec, $value, $path)
		{
			if (!($pat = &$sub[5]))
			{
				// instantiate pattern
				$pat = $this->store[$sub[4]];
				$this->increment_sets($path, $i);
			}

			if (!isset($path[$i]))
			{
				// $tpl->sub = true; -- just to instantiate subpattern
				return ($value === true)? null : 'template set ' . implode('.', $path) . ' do not reference variable';
			}

			$name = $path[$i];
			if (!is_string($name))
			{
				return 'template set name ' . Ut::stringify($name) . ' must be string';
			}

			if (isset($pat['sub'][$name]))
			{
				foreach ($pat['sub'][$name] as &$sub)
				{
					if (($err = $rec($pat, $sub, $i + 1)))
					{
						return $err;
					}
				}
			}
			else if (isset($pat['var'][$name]))
			{
				if (isset($path[$i + 1]))
				{
					return 'template set variable ' . $name . ' not last in path ' . implode('.', $path);
				}

				if (isset($pat['set'][$name]))
				{
					// auto-commit on repeated setting
					$this->assign($super, $sub, $this->commit($pat), $pat['prefix']);

					// re-instantiate pattern
					$pat = $this->store[$sub[4]];
					$this->increment_sets($path, $i);
				}

				$pat['set'][$name] = 1;

				foreach ($pat['var'][$name] as &$var)
				{
					$this->assign($pat, $var, $value);
				}
			}
			else
			{
				return 'template set unknown variable ' . $name;
			}
		};

		// main show
		if (($err = $rec($this->root, $this->root['sub'][''][0], 0)))
		{
			trigger_error($err, E_USER_WARNING);
		}
	}

	private function increment_sets($path, $i)
	{
		$var = implode('_', array_slice($path, 0, $i));
		$n = (int) @$this->sets[$var];

		if (($lvar = strlen($var)))
		{
			foreach ($this->sets as $svar => $scnt)
			{
				if (!strncmp($var . '_', $svar, $lvar + 1))
				{
					unset($this->sets[$svar]);
				}
			}
		}
		else
		{
			$this->sets = [];
		}

		$this->sets[$var] = $n + 1;
	}
}
