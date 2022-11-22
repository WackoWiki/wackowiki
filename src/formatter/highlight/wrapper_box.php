<?php

/*
	%%(Formatter
		wrapper="box"
		[wrapper_align="left | center | right"]
		[wrapper_width="pixel"]
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
if (!isset($options['wrapper_type']))	$options['wrapper_type']	= 'default';
if (!isset($options['wrapper_title']))	$options['wrapper_title']	= null;
if (!isset($options['wrapper_align']))	$options['wrapper_align']	= 'right';
if (!isset($options['wrapper_width']))	$options['wrapper_width']	= 250;
if (!isset($options['clear']))			$options['clear']			= false;
if (!isset($options['col']))			$options['col']				= false;

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

$col_class	= $options['col'] ? ' wrapper-col' . (int) $options['col'] : '';

// output wrapper
$tpl->type		= $type_class;
$tpl->align		= $align_class;
$tpl->col		= $col_class;
$tpl->width		= (int) $options['wrapper_width'];
$tpl->t_title	= $options['wrapper_title'] ?? null;
$tpl->text		= $text;

if ($options['clear'])
{
	$tpl->clear = true;
}
