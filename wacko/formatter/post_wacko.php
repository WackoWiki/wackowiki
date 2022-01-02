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
	$text);

if (!isset($options['strip_ignore'])) $options['strip_ignore'] = false;
if (!isset($options['strip_notypo'])) $options['strip_notypo'] = false;


if ($options['strip_notypo'])
{
	$text = str_replace(['<!--notypo-->', '<!--/notypo-->'], '', $text);
}

if ($options['strip_ignore'])
{
	$text = str_replace(['<ignore>', '</ignore>'], '', $text);
}

echo $text;
