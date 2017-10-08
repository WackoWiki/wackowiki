<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($text))	$text = '';
if (!isset($title))	$title = '';

// Param name
if (isset($href))
{
	$text = str_replace('~', $href, $text);
	$text = htmlspecialchars($text, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);
	$title = htmlspecialchars($title, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);
	$href = htmlspecialchars($href, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);

	echo '<a id="' . $href . '" href="#' . $href . '" title="' . $title . '">' . $text . "</a>\n";
}
