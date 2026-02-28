<?php

/*
	%%(Formatter
		wrapper="page"
		[wrapper_width=px|%|em|rem])
	content
	%%
*/

// defaults
$options['wrapper_width']	??= '800px';

if (!preg_match('/^(?:\d+|0\.\d+)(?:px|%|em|rem)$/', $options['wrapper_width']))
{
	// legacy fallback
	$options['wrapper_width'] = (int) $options['wrapper_width'] . 'px';
}

// output wrapper
$tpl->width		= $options['wrapper_width'];
$tpl->text		= $text;