<?php

/*
	%%(info
		[type="default | error | example | important | note | question | quote | success | warning"]
		[title="Title"]
		[icon=0|1]
		[style="no use"]
		)
	content
	%%
*/

$style_class	= 'info';
$type_class		= '';
$types			= ['default', 'error', 'example', 'important', 'note', 'question', 'quote', 'success', 'warning'];

$options['type']	??= 'default';
$options['title']	??= '';
$options['icon']	??= 1;
$options['style']	??= false;

if (in_array($options['type'], $types))
{
	// info type-* in wacko.css
	$type_class = ' type-' . $options['type'];
}

$title = $options['title'] ?? null;

echo	'<ignore><div class="' . $style_class . $type_class . '">' . "\n";
echo	($options['icon'] ? '<div class="info-content">' : '') . "\n" .
		($title
			? '<p class="info-title">' . Ut::html($title) . '</p>' . "\n"
			: '');
include Ut::join_path(FORMATTER_DIR, 'wiki.php');
echo	($options['icon'] ? '</div>' : '') . "\n";
echo	'</div></ignore>' . "\n";
