<?php

$this->use_class('rawhtmlformatter', 'formatters/classes/');

$parser = new RawHtmlFormatter( $this );

$text = preg_replace_callback('/(<format [^>]*?>.*?<\/format>|<a [^>]*>)/ism', array( &$parser, 'process'), $text);

//$text = $this->Format($text, "safehtml");
//echo "rawhtml: ".$text;
include('safehtml.php');

?>