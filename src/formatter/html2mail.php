<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($text == '') return;

// remove indent tabs
$text = preg_replace('/\n\\t+/u', "\n", $text);

// remove extra blank lines
$text = preg_replace('/(?:\\n){2,}/u', "\n", $text);

// remove tags <br>
$text = str_replace('<br>', "\n", $text);

// HTML email filters (text/html)
if (isset($options['text_html']))
{
	// convert links to pages in the format "Description (URL)"
	$text = preg_replace('/<a .*?href="(https?:\/\/.*?)" class="".*?>(.*?)<\/a>/u', '$2 ($1)', $text);

	// remove tags from the links that contain dates
	$text = preg_replace('/<a .*?href="https?:\/\/.*?">((?:0[1-9]|[12]\d|3[01])[-\/.](?:0[1-9]|1[012])[-\/.](?:19|20)\d{2} [0-2][0-3][-\/.:][0-5]\d)<\/a>/u', '$1', $text);

	// remove references to the creation of new pages
	$text = preg_replace('/<a .*?href="https?:\/\/.*?edit\\?add=1" title="' . $this->_t('CreatePage') . '">.*?<\/a>/u', '', $text);
}

// sanitizing remaining tags
$text = preg_replace('/<\/?[a-z][a-z\d]*[^<>]*?>|<!--.*?-->/u', '', $text);

// convert html-entities in plain text
$text = html_entity_decode($text, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);

// break up long lines
$text = utf8_wordwrap($text, 74, "\n", 1);

// last filter
$text = trim($text);

echo $text;
