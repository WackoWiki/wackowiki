<?php

/*
	%%(Formatter
		wrapper="text"
		[wrapper_align= "left | center | right | justify")]
		[clear])
	content
	%%
*/

$align_class = '';

if (!isset($options['wrapper_align']))	$options['wrapper_align']	= 'right';
if (!isset($options['clear']))			$options['clear']			= false;

if (in_array($options['wrapper_align'], ['center', 'justify', 'left', 'right']))
{
	if ($options['wrapper_align'] != 'justify')
	{
		// wrapper-* align in wacko.css
		$align_class = 'wrapper-' . $options['wrapper_align'];
	}

	$text_align		= $options['wrapper_align'];
}

echo	'<div class="' . $align_class . '" style="text-align: ' . $text_align . ';">' . "\n" .
			$text .
		"</div>\n";

if ($options['clear'])
{
	echo '<span class="clearfix"></span>';
}
