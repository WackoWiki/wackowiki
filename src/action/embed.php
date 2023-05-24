<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	Embed Action
*/

$info = <<<EOD
Description:
	Embeds an external application or interactive content, like PDF or videos.

	The CSP directives must allow the selected source.

Usage:
	{{embed url="https://example.com/embed/zhec4tHwLzo"}}

Options:
	[width="400"]
	[height="300"]
	[align="left|center|right"]
EOD;

// set defaults
$align		??= null;
$height		??= 385;
$help		??= 0;
$url		??= null;
$width		??= 640;

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info]);
	return;
}

if (!$url)
{
	$tpl->none = true;
}
else
{
	$tpl->enter('embed_');

	$tpl->url		= $url;
	$tpl->width		= (int) $width;
	$tpl->height	= (int) $height;

	if (in_array($align, ['left', 'center', 'right']))
	{
		$tpl->align = ' class="media-' . $align . '"';
	}

	$tpl->leave();
}
