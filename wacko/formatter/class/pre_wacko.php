<?php

/**
 * Preformat text before when saving page: resolves macros and some more
 */

class PreFormatter
{
	var $object;

	function __construct(&$object)
	{
		$this->object		= &$object;
		$this->PREREGEXP	= '/(\%\%.*?\%\%|\"\".*?\"\"|::(\S)?::' .
			(isset($this->object->user_lang) && isset($this->object->page_lang)
			 && $this->object->user_lang != $this->object->page_lang
				? '|\[\[(\S+?)([ \t]+([^\n]+?))?\]\]|\(\((\S+?)([ \t]+([^\n]+?))?\)\)'
				: '') .
			')/usm';
	}

	function precallback($things)
	{
		$wacko = &$this->object;

		$thing = $things[1];

		if (preg_match('/^\%\%(.*)\%\%$/us', $thing, $matches))
		{
			return '%%' . $matches[1] . '%%';
		}
		else if (preg_match('/^\"\"(.*)\"\"$/us', $thing, $matches))
		{
			return '""' . $matches[1] . '""';
		}
		else if ($thing == ':::::')
		{
			return '((user:' . $wacko->get_user_name() . ' ' . $wacko->get_user_name() . ')):';
		}
		else if ($thing == '::::')
		{
			return '((user:' . $wacko->get_user_name() . ' ' . $wacko->get_user_name() . '))';
		}
		else if ($thing == '::@::')
		{
			return sprintf($wacko->db->name_date_macro, '((user:' . $wacko->get_user_name() . ' ' . $wacko->get_user_name() . '))', $wacko->date_format(time(), $wacko->db->date_format . ' ' . $wacko->db->time_format));
		}
		else if ($thing == '::+::')
		{
			return $wacko->date_format(time(), $wacko->db->date_format . ' ' . $wacko->db->time_format);
		}

		return $thing;
	}
}
