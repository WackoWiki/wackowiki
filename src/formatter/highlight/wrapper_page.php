<?php

/*
	%%(Formatter
		wrapper="page"
		[wrapper_width=200])
	content
	%%
*/

// defaults
if (!isset($options['wrapper_width'])) $options['wrapper_width'] = '800';

// output wrapper
$tpl->width		= (int) $options['wrapper_width'];
$tpl->text		= $text;
