<?php

$hl = new Text_Highlighter();

if ($options['_default'])
{
	$language	= $options['_default'];
	$numbers	= (bool) $options['numbers'];
	$start		= (int)($options['start'] ?? 1);

	$hl =& Text_Highlighter::factory(strtoupper($language), ['numbers' => $numbers, 'numbers_start' => $start]);

	if (!is_object($hl))
	{
		echo $hl;
	}
	else
	{
		echo '<!--notypo-->';
		// Highlighter class adds a <pre> tag wrapper
		echo $hl->highlight($text);
		echo '<!--/notypo-->';
	}
}
else
{
	echo Ut::html($text);
}
