<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class TemplatestSetter extends TemplatestFilters
{
	protected $store;

	function __construct(&$store)
	{
		$this->store = &$store;
		parent::__construct();
	}

	function assign(&$tpl, $sub, $text, $prefix0 = null, $static = false)
	{
		if ($text === false || $text === null)
		{
			return;
		}

		list ($place, $lineno, $block, $pipe) = $sub;
		$loc = $this->store[2][$tpl['file']][0] . ':' . $lineno;

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

			$text = $this->call_filter($filter, $text, $block !== false, $loc, $act);
			if ($text === false || $text === null)
			{
				return;
			}
		}

		// if last filter is not escape and we setting data (not subpattern) - do default escaping
		if ($filter != 'escape' && $filter != 'e' && !isset($prefix0))
		{
			$text = $this->call_filter('escape', $text, $block !== false, $loc, [@$tpl['escape'] ?: 'html']);
		}

		// remove \0 \r \v
		$text = Templatest::sanitize($text);

		if ($block !== false)
		{
			// auto-indenting..
			$prefix = !Ut::is_empty($prefix0)? $prefix0 : Templatest::compute_prefix($text);

			if ($prefix || $block)
			{
				$lines = explode("\n", $text);

				foreach ($lines as &$line)
				{
					// all-whitespace lines are converted to empty lines
					if (($ws = strspn($line, " \t")) >= ($strlen = strlen($line)))
					{
						$line = '';
					}
					else if (!$prefix || !$ws)
					{
						$line = $block . $line;
					}
					else if ($ws <= $prefix)
					{
						// protect non-whitespace prefix - this CAN happen for precomputed prefixes
						$line = $block . substr($line, $ws);
					}
					else
					{
						$line = $block . substr($line, $prefix);
					}
				}

				$text = implode("\n", $lines);
			}

			if ($text && substr($text, -1) !== "\n")
			{
				$text .= "\n";
			}
		}
		else
		{
			// when doing inline substitution - all of \n is removed from the subject
			$text = trim($text, "\n");

			// all of whitespace spans with \n in them replaced by single space
			for ($i = 0; ($nl = strpos($text, "\n", $i)) !== false; $i = $pre)
			{
				for ($pre = $nl; $pre > 0 && ctype_space($text[$pre - 1]); --$pre);
				$post = $nl + strspn($text, " \t\n", $nl);
				$text = substr_replace($text, ' ', $pre, $post - $pre);
			}
		}

		if (isset($prefix0) && isset($tpl['sets'][$place]))
		{
			// precomputed prefix is known for patterns only. so append, for auto-commit
			$tpl['chunks'][$place] .= $text;
		}
		else if ($static != 2 || $tpl['chunks'][$place] === '') // do not place defaults in .patch'ed places
		{
			// vars & pulls
			$tpl['chunks'][$place] = $text;
		}

		if (!$static)
		{
			$tpl['sets'][$place] = 1;
		}
	}

	function patch($patname, $varname, $value, $loc)
	{
		if (!isset($this->store[$patname]['chunks']))
		{
			trigger_error('unknown pattern ' . $patname . ' at ' . $loc, E_USER_WARNING);
		}
		else
		{
			$pat = &$this->store[$patname];

			if (!isset($pat['var'][$varname]))
			{
				trigger_error('unknown variable ' . $varname . ' at ' . $loc, E_USER_WARNING);
			}
			else
			{
				foreach ($pat['var'][$varname] as &$var)
				{
					$this->assign($pat, $var, $value, null, 1);
				}
			}
		}
	}
}
