<?php

/*
	%%(Formatter
		wrapper="page")
	content
	%%
*/

if (!isset($options['wrapper_width'])) $options['wrapper_width'] = '800';

echo	'<div style="width:' . (int) $options['wrapper_width'] . 'px">' . "\n" .
			$text .
		"</div>\n";
