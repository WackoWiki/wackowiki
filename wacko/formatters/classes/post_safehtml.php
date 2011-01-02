<?php

class post_safehtml
{
	var $object;

	function __construct( &$object, &$options )
	{
		$this->object  = &$object;
		$this->options = &$options;

		if ($this->options['feed'])
		{
			$this->actions = explode(', ', ACTIONS4DIFF);
		}
	}

	function postcallback($things)
	{
		$thing	= $things[1];
		$wacko	= &$this->object;

		// forced links ((link link == desc desc))
		if (preg_match('/^<!--link:begin-->([^\n]+)==([^\n]*)<!--link:end-->$/', $thing, $matches))
		{
/*
			list (, $url, $text) = $matches;

			if ($url)
			{
				$url	= str_replace(' ', '%20', trim($url));
				$text	= trim(preg_replace('/<!--markup:1:[\w]+-->|__|\[\[|\(\(/', '', $text));
				return $wacko->link($url, ($this->options["feed"] ? "no404" : ''), $text);
			}
			else
			{
				return '';
			}
*/
		}
		// actions
		else if (preg_match('/^<!--action:begin-->\s*([^\n]+?)<!--action:end-->$/s', $thing, $matches))
		{
			// disassembly of the parameters
			$p			= ' '.$matches[1].' ';
			$paramcount	= preg_match_all( '/(([^\s=]+)(\=((\"(.*?)\")|([^\"\s]+)))?)\s/', $p, $matches, PREG_SET_ORDER );
			$params		= array();
			$c			=0;

			foreach( $matches as $m )
			{
				$value				= isset($m[3]) && $m[3] ? ($m[5] ? $m[6] : $m[7]) : '1';
				$params[$c]			= $value;
				$params[ $m[2] ]	= $value;
				$c++;
			}

			$action = $params['name'];

			if ($action && (!$this->options['feed'] || in_array(strtolower($action), $this->actions)))
			{
				if ($action == $params[0])
				{
					$params[0] = $params[1];
				}

				return $wacko->action($action, $params);
			}
			else if ($this->options['feed'])
			{
				return '';
			}
			else
			{
				return $thing;
			}
		}

		// if we reach this point, it must have been an accident.
		return $thing;
	}
}

?>