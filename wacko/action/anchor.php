<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	{{anchor
		[href="anchor"]
		[text="Index"]
		[title="Title"]
	}}
*/

$name		??= ''; // depreciated, legacy support
if ($name)	$href	= $name;

// set defaults
$text		??= '';
$title		??= '';

// Param name
if (isset($href))
{
	$text		= str_replace('~', $href, $text);

	$tpl->href	= $href;
	$tpl->text	= $text;
	$tpl->title	= $title;
}
