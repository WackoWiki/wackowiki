<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$parser = new PostSafehtml($this, $options);

$text = preg_replace_callback('<!--action:begin-->[^\n]+?<!--action:end-->)/usm', [&$parser, 'postcallback'], $text);

echo($text);

?>