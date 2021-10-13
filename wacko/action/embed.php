<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	Embed Action

	The first three arguments here are required. The rest are optional.

	{{embed
		[url="file:the_movie.mp4"]
		[width="100"]
		[height="100"]
		[align="left|center|right"]
	}}
*/

// set defaults
if (!$url)	$url	= null;
if (!$width)	$width	= 550;
if (!$height)	$height	= 100;
if (!$align)	$align	= null;

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
