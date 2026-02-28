<?php

/*
	%%(Formatter
		wrapper="box"
		[wrapper_align="left | center | right"]
		[wrapper_width="px|%|em|rem"]
		[wrapper_title="Title"]
		[wrapper_type="default | error | example | important | note | question | quote | success | warning"]
		[col=2|3|4|5]
		[clear])
	content
	%%
*/

$align_class	= '';
$type_class		= '';
$types			= ['default', 'error', 'example', 'important', 'note', 'question', 'quote', 'success', 'warning'];

// defaults
$options['wrapper_type']	??= 'default';
$options['wrapper_title']	??= null;
$options['wrapper_align']	??= 'right';
$options['wrapper_width']	??= '250px';
$options['clear']			??= false;
$options['col']				??= false;

if (in_array($options['wrapper_align'], ['center', 'left', 'right']))
{
	// wrapper-* align in wacko.css
	$align_class = ' wrapper-' . $options['wrapper_align'];
}

if (in_array($options['wrapper_type'], $types))
{
	// wrapper type-* in wacko.css
	$type_class = ' type-' . $options['wrapper_type'];
}

if (!preg_match('/^(?:\d+|0\.\d+)(?:px|%|em|rem)$/', $options['wrapper_width']))
{
	// legacy fallback
	$options['wrapper_width'] = (int) $options['wrapper_width'] . 'px';
}

$col_class	= $options['col'] ? ' wrapper-col' . (int) $options['col'] : '';

// output wrapper
$tpl->type		= $type_class;
$tpl->align		= $align_class;
$tpl->col		= $col_class;
$tpl->width		= $options['wrapper_width'];
$tpl->t_title	= $options['wrapper_title'] ?? null;
$tpl->text		= $text;

if ($options['clear'])
{
	$tpl->clear = true;
}