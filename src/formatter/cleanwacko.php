<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Removes all the basic wiki-markup, giving a simple text.
// Formatter is most suitable for the purification of the text after
// replace the bbcode on wacko-syntax.

if ($text == '')
{
	return;
}

$text = str_replace(
	[
		'**', '//', '__', '----', '---', '##', '++', '??', '""', '~',
		'>>>', '>>', '<<<', '<<', '%%', '``',
		'======', '=====', '====', '===',
		'<[', ']>', '#||', '||#', '#|', '|#',
		'||', '*|', '|*',
	],
	[
		'', '', '', '', '', '', '', '', '', '',
		'', '', '', '', '', '',
		'', '', '', '',
		'"', '"', '"', '"', '"', '"',
		'', '', '',
	],
	$text
	);

// ---- Complex layout cleanup ----
$text = preg_replace('/!!(?:\\([\\w]+?\\))*(.+?)!!/u',		'\\1',	$text); // !!(color)text!!
$text = preg_replace('/\\^\\^(\S+?)\\^\\^/u',				'^\\1',	$text); // ^^123^^
$text = preg_replace('/{{.+?}}[\s]*/u',						'',		$text); // {{action}}
$text = preg_replace('/[\n]{2,}/u',							"\n\n",	$text); // more than two transfers
$text = preg_replace('/\\n[ ]{1}/u',						'',		$text); // gap at beginning of line
$text = preg_replace('/--([^ ])/u',							'[\\1',	$text); // strikethrough left
$text = preg_replace('/([^ ])--/u',							'\\1]',	$text); // strikethrough right

// ---- Links ----
$text = preg_replace_callback(
	'/
		(?:\[\[|\(\()
		(\S+?)
		\s+
		(.*?)
		(?:]]|\)\))
	|
		(?:\[\[|\(\()
		(\S+?)
		(?:]]|\)\))
	/ux',
	function ($m) {
		if ($m[1] && $m[2]) {
			// Complex link: [[url desc]] or ((url desc))
			return $m[2] . ' (' . $m[1] . ')';
		}
		if (isset($m[4]) && $m[4]) {
			// Simple link: [[url]] or ((url))
			return $m[4];
		}
		return $m[0];
	},
	$text
	);

echo $text;
