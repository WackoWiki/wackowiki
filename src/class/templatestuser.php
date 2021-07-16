<?php

// TODO:
// ? if not sets in instantiated subpat - do not emit it

if (!defined('IN_WACKO'))
{
	exit;
}

class TemplatestUser extends TemplatestSetter
{
	private $main;
	private $pulls = [];
	private $sets = [];
	private $chroot = '';
	private $stack = [];
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
				[$_place, $lineno, $block, $_pipe, $id, $args] = $pull;
				$loc = $this->store[2][$pat['file']][0] . ':' . $lineno;

				if (!(isset($this->pulls[$id]) && is_callable($this->pulls[$id])))
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
					if ($data = $sub[5])
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
		$this->__set(func_get_args());
	}

	// __get/__set helper for generation internal tags:
	// keeping stack of simple context name prefixes
	function enter($base)
	{
		$i = count($this->stack);
		$this->stack[] = $this->chroot;
		$this->chroot .= $base;
		return $i;
	}

	function leave($to = null)
	{
		do
		{
			$this->chroot = array_pop($this->stack);
		}
		while ($this->stack && isset($to) && count($this->stack) > $to);
	}

	function __get($name)
	{
		return (int) @$this->sets[$this->chroot . $name];
	}

	function __set($name, $value)
	{
		$this->set($this->chroot . $name, $value);
	}

	// set(['a', 'b'], 'text')
	// set('a', 'b_b2', 'text')
	// set('a_b', 'text')
	function set()
	{
		if (!isset($this->root['sub']))
		{
			return $this->error('nothing to set in pattern ', $this->main);
		}

		$args = func_get_args();

		if (($nargs = count($args)) == 1 && is_array($args[0]))
		{
			$args = $args[0];
			$nargs = count($args);
		}

		if (!$nargs)
		{
			return;
		}

		$value = $args[$nargs - 1];

		if ($value === false || $value === null)
		{
			return; // skip if value is empty
		}

		$rec = function (&$super, &$sub, $args, $path = '') use (&$rec)
		{
			if (!($pat = &$sub[5]))
			{
				// instantiate pattern
				$pat = $this->store[$sub[4]];
				$this->increment_sets($path);
			}

			for (;;)
			{
				$name = array_shift($args);
				if (!$args)
				{
					// path exhausted, only value remains, so we instructed to assign into sub!
					$err = null;

					if (is_array($name))
					{
						foreach ($name as $i => $value)
						{
							if (is_string($i))
							{
								$err = $rec($super, $sub, [$i, $value], $path);
							}
							else
							{
								$err = $rec($super, $sub, [$value], $path);
							}
							if ($err)
							{
								break;
							}
						}
					}
					// $tpl->sub = true; -- just to instantiate subpattern
					else if ($name !== true)
					{
						$err = "`$path' do not reference variable";
					}

					return $err;
				}

				if (is_array($name))
				{
					$args = array_merge($name, $args);
				}
				else if (is_string($name))
				{
					if (str_contains($name, '_'))
					{
						$args = array_merge(explode('_', $name), $args);
					}
					else if ($name)
					{
						break;
					}
				}
				else
				{
					return "`$path' variable " . Ut::stringify($name) . ' must be string';
				}
			}

			$path1 = ($path? $path . '_' : '') . $name;

			if (isset($pat['sub'][$name]))
			{
				foreach ($pat['sub'][$name] as &$child)
				{
					if ($err = $rec($pat, $child, $args, $path1))
					{
						return $err;
					}
				}
			}
			else if (isset($pat['var'][$name]))
			{
				if (isset($args[1]))
				{
					return "`$path1' variable trailed by " . Ut::stringify(array_slice($args, 0, -1));
				}

				if (isset($pat['set'][$name]))
				{
					// auto-commit on repeated setting
					$this->assign($super, $sub, $this->commit($pat), $pat['prefix']);

					// re-instantiate pattern
					$pat = $this->store[$sub[4]];
					$this->increment_sets($path);
				}

				$pat['set'][$name] = 1;

				foreach ($pat['var'][$name] as &$var)
				{
					$this->assign($pat, $var, $args[0]);
				}
			}
			else
			{
				return "`$path1' variable undeclared";
			}
		};

		// main show
		if ($err = $rec($this->root, $this->root['sub'][''][0], $args))
		{
			$this->error('template set: ', $err);
		}
	}

	private function increment_sets($var)
	{
		$n = (int) @$this->sets[$var];

		if ($lvar = strlen($var))
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
