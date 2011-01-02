<?php

if (!class_exists('preformatter'))
{
	class preformatter
	{
		var $object;

		function __construct(&$object)
		{
			$this->object = &$object;
			$this->PREREGEXP = "/(\%\%.*?\%\%|\"\".*?\"\"|::(\S)?::".
				($this->object->user_lang != $this->object->page_lang
					? "|\[\[(\S+?)([ \t]+([^\n]+?))?\]\]|\(\((\S+?)([ \t]+([^\n]+?))?\)\)"
					: "").
				")/sm";
		}

		function precallback($things)
		{
			$wacko = &$this->object;

			$thing = $things[1];

			if (preg_match('/^\%\%(.*)\%\%$/s', $thing, $matches))
			{
				return "%%".$matches[1]."%%";
			}
			else if (preg_match('/^\"\"(.*)\"\"$/s', $thing, $matches))
			{
				return "\"\"".$matches[1]."\"\"";
			}
			else if ($thing == ':::::')
			{
				return "((/".$wacko->get_user_name()." ".$wacko->get_user_name().")):";
			}
			else if ($thing == '::::')
			{
				return "((/".$wacko->get_user_name()." ".$wacko->get_user_name()."))";
			}
			else if ($thing == '::@::')
			{
				return sprintf($wacko->config['name_date_macro'], "((/".$wacko->get_user_name()." ".$wacko->get_user_name()."))", date($wacko->config['date_macro_format']));
			}
			else if ($thing == '::+::')
			{
				return date($wacko->config['date_macro_format']);
			}
			else if ((preg_match('/^(\[\[)(.+)(\]\])$/', $thing, $matches)) ||
					(preg_match('/^(\(\()(.+)(\)\))$/', $thing, $matches)))
			{
				list (, $b1, $cont, $b2) = $matches;

				if (preg_match('/\&\#\d+;/', $cont, $matches))
				{
					$thing = $b1.@strtr($cont, $this->object->unicode_entities).' @@'.$this->object->user_lang.$b2;
				}

				return $thing;
			}

			return $thing;
		}
	}
}

$parser	= new preformatter($this);
$text	= preg_replace_callback($parser->PREREGEXP, array(&$parser, 'precallback'), $text);

echo $text;

?>