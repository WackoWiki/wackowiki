<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	Flash Action

	The first five arguments here are required.  The rest are optional.

	{{flash
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

$url = htmlspecialchars($url, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);

if (!$width)	$width	= 550;
if (!$height)	$height	= 100;

if (!$url)
{
	echo '<p><em>' . $this->_t('FlashNoURL') . "</em></p>\n";
}
else
{
	// echo '<video width="' . $width . '" height="' . $height . '" src="' . $url . '" controls>';
	echo '<embed src="' . $url . '" width="' . $width . '" height="' . $height . '">';
	// echo "</video>\n";
}
