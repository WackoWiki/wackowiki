<?php

/**
 * This formatter resolves links and executes actions.
 */

class PostWacko
{
	var $object;

	function __construct(&$object, &$options)
	{
		$this->object	= &$object;
		$this->options	= &$options;
		$this->action	= explode(', ', ACTION4DIFF);
	}

	function postcallback($things)
	{
		$matches	= [];
		$thing		= $things[1];

		$wacko		= &$this->object;

		// forced links ((link link == desc desc))
		if (preg_match('/^<!--link:begin-->([^\n]+)==([^\n]*)<!--link:end-->$/u', $thing, $matches))
		{
			[, $url, $text] = $matches;

			if ($url)
			{
				$url	= str_replace(' ', '%20', trim($url));
				$text	= trim(preg_replace('/<!--markup:1:[\w]+-->|__|\[\[|\(\(/u', '', $text));

				return $wacko->link($url, '', $text, '', 1, 1);
			}
			else
			{
				return '';
			}
		}
		// image links
		else if (preg_match('/^<!--imglink:begin-->([^\n]+)==(file:[^\n]+)<!--imglink:end-->$/u', $thing, $matches))
		{
			[, $url, $img] = $matches;

			if ($url && $img)
			{
				$url	= str_replace(' ', '', $url);
				$url	= $wacko->link($url, '', '', '', 1, 1);

				if (!$url = preg_replace('/.*href="(.*?)".*|.*src="(.*?)".*/u', '\\1\\2', $url))
				{
					return $url;
				}

				$img	= str_replace(' ', '', $img);
				$img	= trim(preg_replace('/<!--imgprelink:[\w]+-->|__|\[\*\[|\(\*\(/u', '', $img));
				$img	= $wacko->link($img, '', '', '', 1, 1);

				return '<a href="' . $url . '">' . $img . '</a>';
			}
			else
			{
				return '';
			}
		}
		// actions
		else if (preg_match('/^<!--action:begin-->\s*([^\n]+?)<!--action:end-->$/us', $thing, $matches))
		{
			// check for action parameters
			$sep = mb_strpos($matches[1], ' ');

			if ($sep === false)
			{
				$action	= $matches[1];
				$params	= [];
			}
			else
			{
				$action		= mb_substr($matches[1], 0, $sep);
				$p			= ' ' . mb_substr($matches[1], $sep) . ' ';
				$paramcount	= preg_match_all('/(([^\s=]+)(\=((\"(.*?)\")|([^\"\s]+)))?)\s/u', $p, $_matches, PREG_SET_ORDER);
				$params		= [];
				$c			= 0;

				foreach ($_matches as $m)
				{
					$value			= isset($m[3]) && $m[3] ? ($m[5] ? $m[6] : $m[7]) : 1;
					$params[$c]		= $value;
					$params[$m[2]]	= $value;
					$c++;
				}
			}

			if ($action && (!isset($this->options['diff']) || in_array(mb_strtolower($action), $this->action)))
			{
				return $wacko->action($action, $params);
			}
			else if (isset($this->options['diff']))
			{
				return '{{' . $matches[1] . '}}';
			}
			else
			{
				return '{{}}';
			}
		}

		// if we reach this point, it must have been an accident.
		return $thing;
	}
}
