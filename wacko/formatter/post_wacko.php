<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$parser = new PostWacko($this, $options);

$text = preg_replace_callback('/(<!--link:begin-->(\S+?)([^\n]*?)==([^\n]*?)<!--link:end-->|' .
							  '<!--imglink:begin-->([^\n]+)==(file:[^\n]+)<!--imglink:end-->|' .
							  '<!--action:begin-->[^\n]+?<!--action:end-->)/sm',

[&$parser, 'postcallback'], $text);

if (!isset($options['stripnotypo'])) $options['stripnotypo'] = '';

if ($options['stripnotypo'])
{
	$text = str_replace('<!--notypo-->', '', $text);
	$text = str_replace('<!--/notypo-->', '', $text);
}

echo $text;

?>