<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$rh->use_class('post_safehtml', $this->config['formatter_path'].'/class/');

$parser = new post_safehtml($this, &$options);

$text = preg_replace_callback('<!--action:begin-->[^\n]+?<!--action:end-->)/sm', array( &$parser, 'postcallback'), $text);

echo($text);

?>