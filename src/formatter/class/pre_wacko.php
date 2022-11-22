<?php

/**
 * Preformat text before when saving page: resolves macros and some more
 */

class PreFormatter
{
	public $object;
	public string $PRE_REGEX;

	function __construct(&$object)
	{
		$this->object		= &$object;
		$this->PRE_REGEX	=
			'/(' .
			// formatter  %%...%% and ``...``
			'``.*?``|' .
			'\%\%.*?\%\%|' .
			// escaped  ""...""
			'\"\".*?\"\"|' .
			// macro  ::...::
			'::(\S)?::' .
			')/usm';
	}

	function precallback($things)
	{
		$wacko = &$this->object;

		$thing = $things[1];

		// formatter text  ``...``
		if (  preg_match('/^``(.*)``$/us', $thing, $matches))
		{
			return '``' . $matches[1] . '``';
		}
		// formatter text  %%...%%
		else if (preg_match('/^\%\%(.*)\%\%$/us', $thing, $matches))
		{
			return '%%' . $matches[1] . '%%';
		}
		// escaped  ""...""
		else if (preg_match('/^\"\"(.*)\"\"$/us', $thing, $matches))
		{
			return '""' . $matches[1] . '""';
		}
		// macro  :::::
		else if ($thing == ':::::')
		{
			return '((user:' . $wacko->get_user_name() . ' ' . $wacko->get_user_name() . ')):';
		}
		// macro  ::::
		else if ($thing == '::::')
		{
			return '((user:' . $wacko->get_user_name() . ' ' . $wacko->get_user_name() . '))';
		}
		// macro  ::@::
		else if ($thing == '::@::')
		{
			return sprintf($wacko->db->name_date_macro, '((user:' . $wacko->get_user_name() . ' ' . $wacko->get_user_name() . '))', date($wacko->db->date_format . ' ' . $wacko->db->time_format));
		}
		// macro  ::+::
		else if ($thing == '::+::')
		{
			return date($wacko->db->date_format . ' ' . $wacko->db->time_format);
		}

		return $thing;
	}
}
