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
			return sprintf($wacko->db->name_date_macro, '((user:' . $wacko->get_user_name() . ' ' . $wacko->get_user_name() . '))', date($wacko->db->date_format . ' ' . $wacko->db->time_format));
		}
		else if ($thing == '::+::')
		{
			return date($wacko->db->date_format . ' ' . $wacko->db->time_format);
		}
		// depreciated unicode entities replacement, e.g. ((Link Description @@ru))
		/* else if (  preg_match('/^(\[\[)(.+)(\]\])$/u', $thing, $matches)
				|| preg_match('/^(\(\()(.+)(\)\))$/u', $thing, $matches))
		{
			list (, $b1, $cont, $b2) = $matches;

			if (preg_match('/\&\#\d+;/u', $cont, $matches))
			{
				$thing = $b1 . @strtr($cont, $this->object->unicode_entities) . ' @@' . $this->object->user_lang . $b2;
			}

			return $thing;
		} */

		return $thing;
	}
}

?>
