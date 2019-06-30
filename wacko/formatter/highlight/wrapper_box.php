<?php

/*
	%%(Formatter
		wrapper="box"
		[wrapper_align="left | center | right")]
		[wrapper_width="pixel"]
		[clear])
	content
	%%
*/

$align_class = '';

if (!isset($options['wrapper_align']))	$options['wrapper_align']	= 'right';
if (!isset($options['wrapper_width']))	$options['wrapper_width']	= 250;
if (!isset($options['clear']))			$options['clear']			= false;

if (in_array($options['wrapper_align'], ['center', 'left', 'right']))
{
	// wrapper-* align in wacko.css
	$align_class = ' wrapper-' . $options['wrapper_align'];
}

echo	'<aside class="action' . $align_class . '" style="width: ' . (int) $options['wrapper_width'] . 'px;">' . "\n" .
			'<div class="action-content">' . "\n" .
				$text.
			"</div>\n" .
		"</aside>\n";

if ($options['clear'])
{
	echo '<span class="clearfix"></span>';
}
