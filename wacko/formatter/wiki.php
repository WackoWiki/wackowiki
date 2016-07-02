<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$text = $this->format($text, 'wacko');
//$text = $this->format($text, 'post_wacko');
//echo $text;
include(join_path(FORMATTER_DIR, 'post_wacko.php'));

?>
