<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$name		??= ''; // depreciated, legacy support
if ($name)	$href	= $name;

// set defaults
$text		??= '';
$title		??= '';

// Param name
if (isset($href))
{
	$text		= str_replace('~', $href, $text);

	$tpl->text	= $text;
	$tpl->title	= $title;
	$tpl->href	= $href;
}
