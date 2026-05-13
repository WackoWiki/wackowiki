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
	// Combine all three replacements into a single callback
	$text = preg_replace_callback(
		'/<a .*?href="(https?:\/\/.*?)" class="".*?>(.*?)<\/a>/u',
		function ($m) {
			// Check for date links (second pattern)
			if (preg_match(
				'/^((?:0[1-9]|[12]\d|3[01])[-\/.](?:0[1-9]|1[012])[-\/.](?:19|20)\d{2} [0-2][0-3][-\/.:][0-5]\d)$/u',
				$m[2]
				)) {
					return $m[2]; // keep date text, remove link
				}
				// Check for "create page" links (third pattern)
				if (str_contains($m[0], 'edit?add=1') &&
					str_contains($m[0], 'title="' . $this->_t('CreatePage') . '"')) {
						return ''; // remove entirely
					}
					// Default: convert to "Description (URL)"
					return $m[2] . ' (' . $m[1] . ')';
		},
		$text
		);
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
