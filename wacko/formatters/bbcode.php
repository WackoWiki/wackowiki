<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->use_class('bbcode', 'formatters/classes/');

$parser = new bbcode($this);

$text	= preg_replace_callback($parser->template, array(&$parser, 'wrapper'), $text);

echo $text;


?>