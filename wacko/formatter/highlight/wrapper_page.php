<?php

/*
	%%(Formatter
		wrapper="page"
		[wrapper_width=200])
	content
	%%
*/

$options['wrapper_width']	??= '800';

// output wrapper
echo	'<ignore><div style="width: ' . (int) $options['wrapper_width'] . 'px">' . "\n" .
			$text .
		'</div></ignore>' . "\n";