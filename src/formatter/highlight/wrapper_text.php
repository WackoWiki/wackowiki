<?php

/*
	%%(Formatter
		wrapper="text"
		[wrapper_align="left | center | right | justify"]
		[col=2|3|4|5]
		[clear])
	content
	%%
*/

$align_class = '';

// defaults
$options['wrapper_align']	??= 'left';
$options['clear']			??= false;
$options['col']				??= false;

if (in_array($options['wrapper_align'], ['center', 'justify', 'left', 'right']))
{
	if ($options['wrapper_align'] != 'justify')
	{
		// wrapper-* align in wacko.css
		$align_class = 'wrapper-' . $options['wrapper_align'];
	}

	$text_align		= ' style="text-align: ' . $options['wrapper_align'] . ';"';
}

$col_class	= $options['col'] ? ' wrapper-col' . (int) $options['col'] : '';

// output wrapper
$tpl->align		= $align_class;
$tpl->txtalign	= $text_align;
$tpl->col		= $col_class;
$tpl->text		= $text;
$tpl->clear		= $options['clear'];