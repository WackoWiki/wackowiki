<?php

$this->use_class('post_wacko', 'formatters/classes/');

$parser = new post_wacko($this, $options);

$text = preg_replace_callback('/(<!--link:begin-->(\S+?)([^\n]*?)==([^\n]*?)<!--link:end-->|'.
							  '<!--imglink:begin-->([^\n]+)==(file:[^\n]+)<!--imglink:end-->|'.
							  '<!--action:begin-->[^\n]+?<!--action:end-->)/sm',

array( &$parser, 'postcallback'), $text);

if (!isset($options['stripnotypo'])) $options['stripnotypo'] = '';

if ($options['stripnotypo'])
{
	$text = str_replace('<!--notypo-->', '', $text);
	$text = str_replace('<!--/notypo-->', '', $text);
}

echo $text;

?>