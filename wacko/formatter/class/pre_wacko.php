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
			')/sm';
	}

	function precallback($things)
	{
		$wacko = &$this->object;

		$thing = $things[1];

		if (preg_match('/^\%\%(.*)\%\%$/s', $thing, $matches))
		{
			return '%%' . $matches[1] . '%%';
		}
		else if (preg_match('/^\"\"(.*)\"\"$/s', $thing, $matches))
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
		else if (  preg_match('/^(\[\[)(.+)(\]\])$/', $thing, $matches)
				|| preg_match('/^(\(\()(.+)(\)\))$/', $thing, $matches))
		{
			list (, $b1, $cont, $b2) = $matches;

			if (preg_match('/\&\#\d+;/', $cont, $matches))
			{
				$thing = $b1 . @strtr($cont, $this->object->unicode_entities) . ' @@' . $this->object->user_lang . $b2;
			}

			return $thing;
		}

		return $thing;
	}
}
