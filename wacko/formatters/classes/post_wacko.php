<?php
class post_wacko
{
	var $object;

	function post_wacko( &$object, &$options )
	{
		$this->object  = &$object;
		$this->options = &$options;
		$this->actions = explode(", ", ACTIONS4DIFF);
	}

	function postcallback($things)
	{
		$lang = '';
		$thing = $things[1];

		$wacko = &$this->object;

		// forced links ((link link == desc desc))
		if (preg_match("/^<!--link:begin-->([^\n]+)==([^\n]*)<!--link:end-->$/", $thing, $matches))
		{
			list (, $url, $text) = $matches;
			if ($url)
			{
				$url = str_replace(" ", "", $url);
				$text=trim(preg_replace("/<!--markup:1:[\w]+-->|__|\[\[|\(\(/","",$text));
				if (stristr($text,"@@"))
				{
					$t = explode("@@", $text);
					$text = $t[0];
					$lang = $t[1];
				}
				return $wacko->Link($url, "", $text, 1, 1, $lang);
			}
			else
			return "";
		}
		// actions
		else if (preg_match("/^<!--action:begin-->\s*([^\n]+?)<!--action:end-->$/s", $thing, $matches))
		{
			if ($matches[1] && (!$this->options["diff"] || in_array(strtolower($matches[1]),$this->actions)))
			{
				// check for action' parameters
				$sep = strpos( $matches[1], " " );
				if ($sep === false)
				{
					$action = $matches[1];
					$params = array();
				}
				else
				{
					$action = substr( $matches[1], 0, $sep );
					$p = " ".substr( $matches[1], $sep )." ";
					$paramcount = preg_match_all( "/(([^\s=]+)(\=((\"(.*?)\")|([^\"\s]+)))?)\s/", $p,
					$matches, PREG_SET_ORDER );
					$params = array();  $c=0;
					foreach( $matches as $m )
					{
						$value = $m[3]?($m[5]?$m[6]:$m[7]):"1";
						$params[$c] = $value;
						$params[ $m[2] ] = $value;
						$c++;
					}
				}
				return $wacko->Action($action, $params);
			}
			else if ($this->options["diff"])
			return "{{".$matches[1]."}}";
			else
			return "{{}}";
		}
		// if we reach this point, it must have been an accident.
		return $thing;
	}
}

?>