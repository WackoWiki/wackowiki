<?php

class RawHtmlFormatter
{
	var $object;

	function __construct( &$object )
	{
		$this->object = &$object;
	}

	function process($things)
	{
		$thing = $things[1];
		$wacko = &$this->object;

		if (preg_match('/^<format ([^>]*?)>(.*?)<\/format>$/s', $thing, $matches))
		{
			$code		= preg_replace('/<br *\/?>/', "\n", $matches[2]);
			$p			= ' '.$matches[1].' ';
			$paramcount	= preg_match_all('/(([^\s=]+)(\=((\"(.*?)\")|([^\"\s]+)))?)\s/', $p, $matches, PREG_SET_ORDER);
			$params		= array();
			$c			= 0;

			foreach( $matches as $m )
			{
				$value				= isset($m[3]) && $m[3] ? ($m[5] ? $m[6] : $m[7]) : "1";
				$params[$c]			= $value;
				$params[ $m[2] ]	= $value;
				$c++;
			}

			$language = $params['name'];
			$formatter = strtolower($language);

			if ($formatter == "\xF1")	$formatter = 'c';
			if ($formatter == 'c')		$formatter = 'comments';
			if ($formatter == '')		$formatter = 'code';

			$output .= $wacko->format(trim($code), $formatter);

			return $output;
		}

		// if we reach this point, it must have been an accident.
		return $thing;
	}
}

?>