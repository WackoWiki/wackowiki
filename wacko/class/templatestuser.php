<?php

// TODO:
// - error diags: find $loc from debug_backtrace

if (!defined('IN_WACKO'))
{
	exit;
}

class TemplatestUser 
{
	private $store;
	private $main;
	private $pulls = [];
	private $root;

	function __construct($template, $main)
	{
		if (!isset($template[$main]['chunks']))
		{
			die('instantiating unknown pattern ' . $main . ' from file ' . $template[1]);
		}

		$this->store = $template;
		$this->main = $main;

		$tpl = $this->store[$main];
		if (isset($tpl['static']))
		{
			$root['chunks'][0] = implode('', $tpl['chunks']);
		}
		else
		{
			$root['chunks'][0] = '';
			$root['sub'][''][0] = [0, 'ROOT', false, [], $main, $tpl]; // TODO ROOT?
		}

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
		if (!isset($this->store[$name]['chunks']))
		{
			die('instantiating unknown pattern ' . $name . ' in file ' . $this->store[1]);
		}

		$clone = new TemplatestUser($this->store, $name);
		$clone->pulls = $this->pulls;
		return $clone;
	}

	private function commit($pat)
	{
		if (isset($pat['pull']))
		{
			foreach ($pat['pull'] as $pull)
			{
				list ($_place, $loc, $block, $_pipe, $id, $args) = $pull;

				if (!isset($this->pulls[$id]))
				{
					die('using unknown pull ' . $id . ': at ' . $loc);
				}

				array_unshift($args, $block !== false, $loc);
				Templatest::set($pat, $pull, call_user_func_array($this->pulls[$id], $args));
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
						Templatest::set($pat, $sub, $this->commit($data), $data['prefix']);
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
			$name = $path[$i++];
			if (!is_string($name))
			{
				return 'template set needs string as name';
			}

			if (!($pat = &$sub[5]))
			{
				// instantiate pattern
				$pat = $this->store[$sub[4]];
			}

			if (isset($pat['sub'][$name]))
			{
				if (!isset($path[$i]))
				{
					return 'template set subpattern ' . $name . ' last in path';
				}

				foreach ($pat['sub'][$name] as &$sub)
				{
					if (($err = $rec($pat, $sub, $i)))
					{
						return $err;
					}
				}
			}
			else if (isset($pat['var'][$name]))
			{
				if (isset($path[$i]))
				{
					return 'template set variable ' . $name . ' not last in path';
				}

				if (isset($pat['set'][$name]))
				{
					// auto-commit on repeated setting
					Templatest::set($super, $sub, $this->commit($pat), $pat['prefix']);

					// re-instantiate pattern
					$pat = $this->store[$sub[4]];
				}

				$pat['set'][$name] = 1;

				foreach ($pat['var'][$name] as &$var)
				{
					Templatest::set($pat, $var, $value);
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

	// patch static pattern base
	function patch($patname, $varname, $value)
	{
		Templatest::patch($this->store, $patname, $varname, $value, $this->store[1]);
	}
}
