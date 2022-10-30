<?php

/*
	%%(Formatter
		wrapper="shade"
		[wrapper_title="Title"]
		[wrapper_type="default | error | example | important | note | question | quote | success | warning"]
		[col=2|3|4|5])
	content
	%%
*/

$type_class		= '';
$types			= ['default', 'error', 'example', 'important', 'note', 'question', 'quote', 'success', 'warning'];

// defaults
$options['wrapper_type']	??= 'default';
$options['wrapper_title']	??= null;
$options['col']				??= false;

if (in_array($options['wrapper_type'], $types))
{
	// wrapper type-* in wacko.css
	$type_class = ' type-' . $options['wrapper_type'];
}

$col_class	= $options['col'] ? ' wrapper-col' . (int) $options['col'] : '';

// output wrapper
$tpl->type		= $type_class;
$tpl->col		= $col_class;
$tpl->t_title	= $options['wrapper_title'] ?? null;
$tpl->text		= $text;