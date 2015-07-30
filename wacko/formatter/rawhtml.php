<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->use_class('rawhtmlformatter', $this->config['formatter_path'].'/classes/');

$parser = new RawHtmlFormatter( $this );

$text = preg_replace_callback('/(<format [^>]*?>.*?<\/format>|<a [^>]*>)/ism', array( &$parser, 'process'), $text);

//$text = $this->format($text, "safehtml");
//echo "rawhtml: ".$text;
include('safehtml.php');

?>