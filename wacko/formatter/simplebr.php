<?php

if (!defined('IN_WACKO'))
{
	exit;
}

//!!! much room for optimization :-)

$text = preg_replace ('/ {2, }/', ' ', $text);

$trans = [
	"\r" => '',
	"\n" => '<br />',
	'|' => '&#124;'
	];

$text = strtr ($text, $trans);
/*
if (!$options['no<p>'])
  $text = str_replace ('<br /><br />', '<p>', $text );
*/

include 'rawhtml.php';
// echo "simplebr: " . $this->format($text, 'rawhtml');

?>