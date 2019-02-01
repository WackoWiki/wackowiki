<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$text = $this->format($text, 'wacko');

echo $text;

// prevents parsing links and actions dynamically
# include Ut::join_path(FORMATTER_DIR, 'post_wacko.php');
