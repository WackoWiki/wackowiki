<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$parser = new post_safehtml($this, &$options);

$text = preg_replace_callback('<!--action:begin-->[^\n]+?<!--action:end-->)/sm', [&$parser, 'postcallback'], $text);

echo($text);

?>
