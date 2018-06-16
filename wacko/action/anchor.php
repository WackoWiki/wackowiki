<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($name))		$name	= ''; // depreciated, legacy support
if ($name)				$href	= $name;

if (!isset($text))	$text = '';
if (!isset($title))	$title = '';

// Param name
if (isset($href))
{
	$text		= str_replace('~', $href, $text);

	$tpl->text	= $text;
	$tpl->title	= $title;
	$tpl->href	= $href;
}
