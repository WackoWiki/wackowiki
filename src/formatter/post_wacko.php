<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$parser = new PostWacko($this, $options);

$text = preg_replace_callback(
	'/(<!--link:begin-->(\S+?)([^\n]*?)==([^\n]*?)<!--link:end-->|' .
	  '<!--imglink:begin-->([^\n]+)==(file:[^\n]+)<!--imglink:end-->|' .
	  '<!--action:begin-->[^\n]+?<!--action:end-->)/usm',
	[&$parser, 'postcallback'],
	($text ?? ''));

$options['strip_marker'] ??= false;

if ($options['strip_marker'])
{
	// remove formater marker tags
	$text = str_replace(
		[
			'<!--noinclude-->',
			'<!--/noinclude-->',
			'<!--notypo-->',
			'<!--/notypo-->',
			'<ignore>',
			'</ignore>',
		],
		'',
		$text);
}

echo $text;