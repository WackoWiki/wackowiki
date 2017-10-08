<?php
require_once 'lib/Text_Highlighter/Highlighter.php';

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
	echo htmlspecialchars($text, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);
}
?>