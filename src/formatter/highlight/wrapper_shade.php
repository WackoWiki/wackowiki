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

if (!isset($options['wrapper_type']))	$options['wrapper_type']	= 'default';
if (!isset($options['wrapper_title']))	$options['wrapper_title']	= null;
if (!isset($options['col']))			$options['col']				= false;

if (in_array($options['wrapper_type'], $types))
{
	// wrapper type-* in wacko.css
	$type_class = ' type-' . $options['wrapper_type'];
}

$col_class	= $options['col'] ? ' wrapper-col' . (int) $options['col'] : '';
$title		= $options['wrapper_title'] ?? null;

// output wrapper
echo	'<ignore><div class="wrapper' . $type_class . '">' . "\n" .
			($title
				? '<p class="wrapper-title">' . Ut::html($title) . '</p>' . "\n"
				: '') .
			'<div class="wrapper-content' . $col_class . '">' . "\n" .
				$text .
			"</div>\n" .
		"</div></ignore>\n";
