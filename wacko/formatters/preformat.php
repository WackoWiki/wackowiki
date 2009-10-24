<?php

if (!class_exists("preformatter"))
{
	class preformatter
	{
		var $object;

		function preformatter(&$object)
		{
			$this->object = &$object;
			$this->PREREGEXP = "/(\%\%.*?\%\%|\"\".*?\"\"|::(\S)?::".
				($this->object->userlang != $this->object->pagelang
					? "|\[\[(\S+?)([ \t]+([^\n]+?))?\]\]|\(\((\S+?)([ \t]+([^\n]+?))?\)\)"
					: "").
				")/sm";
		}

		function precallback($things)
		{
			$wacko = &$this->object;

			$thing = $things[1];

			if (preg_match("/^\%\%(.*)\%\%$/s", $thing, $matches))
			{
				return "%%".$matches[1]."%%";
			}
			else if (preg_match("/^\"\"(.*)\"\"$/s", $thing, $matches))
			{
				return "\"\"".$matches[1]."\"\"";
			}
			else if ($thing == ":::::")
			{
				return "((/".$wacko->GetUserName()." ".$wacko->GetUserName().")):";
			}
			else if ($thing == "::::")
			{
				return "((/".$wacko->GetUserName()." ".$wacko->GetUserName()."))";
			}
			else if ($thing == "::@::")
			{
				return sprintf($wacko->config["name_date_macro"], "((/".$wacko->GetUserName()." ".$wacko->GetUserName()."))", date($wacko->config["date_macro_format"]));
			}
			else if ($thing == "::+::")
			{
				return date($wacko->config["date_macro_format"]);
			}
			else if ((preg_match("/^(\[\[)(.+)(\]\])$/", $thing, $matches)) ||
					(preg_match("/^(\(\()(.+)(\)\))$/", $thing, $matches)))
			{
				list (, $b1, $cont, $b2) = $matches;
				if (preg_match("/\&\#\d+;/", $cont, $matches))
				{
					$thing = $b1.@strtr($cont, $this->object->unicode_entities)." @@".$this->object->userlang.$b2;
				}
				return $thing;
			}
			return $thing;
		}
	}
}

$parser = new preformatter($this);

$text = preg_replace_callback($parser->PREREGEXP, array(&$parser, "precallback"), $text);

print($text);

?>