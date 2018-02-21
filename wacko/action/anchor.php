<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($name))		$name	= ''; // depreciated
if ($name)				$href	= $name;

if (!isset($text))	$text = '';
if (!isset($title))	$title = '';

// Param name
if (isset($href))
{
	$text	= str_replace('~', $href, $text);
	$text	= Ut::html($text);
	$title	= Ut::html($title);
	$href	= Ut::html($href);

	echo '<a id="' . $href . '" href="#' . $href . '" title="' . $title . '">' . $text . "</a>\n";
}
