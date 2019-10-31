<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if ($text == '') return;

// remove indent tabs
$text = preg_replace('/\n\\t+/', "\n", $text);

// remove extra blank lines
$text = preg_replace('/(?:\\n){2,}/', "\n", $text);

// remove tags <br>
#$text = str_replace('<br>', '', $text);
$text = preg_replace('/<br>/', "\n", $text);

// convert links to pages in the format "Description (URL)"
$text = preg_replace('/<a .*?href="(https?:\/\/.*?)" class="".*?>(.*?)<\/a>/', '$2 ($1)', $text);

// remove tags from the links that contain dates
#$text = preg_replace('/<a .*?href="http:\/\/.*?">((?:0[1-9]|[12][0-9]|3[01])[-\/.](?:0[1-9]|1[012])[-\/.](?:19|20)[0-9]{2} [0-2][0-3][-\/.:][0-5][0-9])<\/a>/', '$1', $text);

// remove references to the creation of new pages
# $text = preg_replace('/<a .*?href="https?:\/\/.*?edit\\?add=1" title=".*\[create\]">.*?<\/a>/', '', $text); // only source

// replace the tags around the header with the double asterisk
$text = preg_replace('/<strong>(' . $this->_t('SimpleDiffAdditions') . ')<\/strong>|<strong>(' . $this->_t('SimpleDiffDeletions') . ')<\/strong>/u', '** $1$2 **', $text);

// sanitizing remaining tags
$text = preg_replace('/<\/?[a-z][a-z0-9]*[^<>]*?>|<!--.*?-->/', '', $text);

// convert html-entities in plain text
$text = html_entity_decode($text, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET);
$text = str_replace('&ndash;', '-', $text);
$text = str_replace('&mdash;', '--', $text);

// break up long lines
$text = utf8_wordwrap($text, 74, "\n", 1);

// last filter
$text = trim($text);

echo $text;
