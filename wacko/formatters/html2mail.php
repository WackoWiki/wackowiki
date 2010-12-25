<?php

if ($text == '') return;

// remove tags <br />
$text = str_replace('<br />', '', $text);
// convert links to pages in the format "Description (URL)"
$text = preg_replace('/<a .*?href="(http:\/\/.*?)" class="".*?>(.*?)<\/a>/', '$2 ($1)', $text);
// remove tags from the links that contain dates
$text = preg_replace('/<a .*?href="http:\/\/.*?">((?:0[1-9]|[12][0-9]|3[01])[-\/.](?:0[1-9]|1[012])[-\/.](?:19|20)[0-9]{2} [0-2][0-3][-\/.:][0-5][0-9])<\/a>/', '$1', $text);
// remove references to the creation of new pages
$text = preg_replace('/<a .*?href="http:\/\/.*?edit\\?add=1" title=".*\[create\]">.*?<\/a>/', '', $text);
// replace the tags around the header at the asterisk
$text = preg_replace('/<b>(Added:)<\/b>|<b>(Removed:)<\/b>/', '**$1$2**', $text);
// sanitizing remaining tags
$text = preg_replace('/<\/?[a-z][a-z0-9]*[^<>]*?>|<!--.*?-->/', '', $text);
		// remove extra blank lines
		//$text = preg_replace('/(?:\\n){2,}/', '\n', $text);
// convert html-entities in plain text
$text = html_entity_decode($text);
$text = str_replace('&ndash;', '-', $text);
$text = str_replace('&mdash;', '--', $text);
// break up long lines
$text = wordwrap($text, 74, "\n", 1);

echo $text;

?>