<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Creates an anchor to which you can link from any page.

Usage:
	{{anchor href="anchor"}}

Options:
	[text="Index"]
	[title="Title"]
EOD;

$name		??= ''; // deprecated, legacy support
if ($name)	$href	= $name;

// set defaults
$help		??= 0;
$text		??= '';
$title		??= '';

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info, 'action' => 'anchor']);
	return;
}

// Param name
if (isset($href))
{
	$text		= str_replace('~', $href, $text);

	$tpl->href	= $href;
	$tpl->text	= $text;
	$tpl->title	= $title;
}
