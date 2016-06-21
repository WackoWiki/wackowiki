<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$text = $this->format($text, 'wacko');
//$text = $this->format($text, 'post_wacko');
//echo $text;
include($this->config['formatter_path'].'/post_wacko.php');

?>