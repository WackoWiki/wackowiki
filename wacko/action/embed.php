<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	Embed Action

	The first three arguments here are required.  The rest are optional.

	{{embed
		[url="file:the_movie.swf"]
		[width="100"]
		[height="100"]

		// Params
		play
		loop
		menu
		quality

	}}
*/
extract([
	'play'		=> '',
	'loop'		=> '',
	'menu'		=> '',
	'quality'	=> '',
	'bgcolor'	=> '',
	'allowfullscreen' => '',
	'url'		=> '',
	'width'		=> '',
	'height'	=> '',
	'name'		=> '',
	'styleclass' => '',
	'align'		=> '',
], EXTR_SKIP);

if (!$width)	$width	= 550;
if (!$height)	$height	= 100;

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

	$tpl->leave();
}
