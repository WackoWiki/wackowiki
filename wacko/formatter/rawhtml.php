<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$parser = new RawHtmlFormatter( $this );

$text = preg_replace_callback('/(<format [^>]*?>.*?<\/format>|<a [^>]*>)/ism', [&$parser, 'process'], $text);

//$text = $this->format($text, 'safehtml');
//echo 'rawhtml: '.$text;
include 'safehtml.php';

?>
