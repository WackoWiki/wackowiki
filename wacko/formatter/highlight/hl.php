<?php

$hl = new Text_Highlighter();

if ($options['_default'])
{
	$hl =& Text_Highlighter::factory(strtoupper($options['_default']), ['numbers' => false]);

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
