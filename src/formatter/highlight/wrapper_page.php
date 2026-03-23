<?php

/*
	%%(Formatter
		wrapper="page"
		[wrapper_width=px|%|em|rem]
		[col=2|3|4|5])
	content
	%%
*/

// defaults
$options['wrapper_width']	??= '800px';
$options['col']				??= false;

if (!preg_match('/^(?:\d+|0\.\d+)(?:px|%|em|rem)$/', $options['wrapper_width']))
{
	// legacy fallback
	$options['wrapper_width'] = (int) $options['wrapper_width'] . 'px';
}

$col_class	= $options['col'] ? 'wrapper-col' . (int) $options['col'] : '';

// output wrapper
$tpl->width		= $options['wrapper_width'];
$tpl->class_col	= $col_class;
$tpl->text		= $text;