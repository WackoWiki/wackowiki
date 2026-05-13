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

$text = preg_replace_callback(
	'/
		(==== .*? \/\/ .*? \/\/ .*? ====)  |   # group 1: ====text//text//text====
		((?:http|https|ftp|nntp):\/\/)      |   # group 2: protocol://
		(-{5} [A-Z ]+? -{5})                |   # group 3: -----TITLE-----
	/ux',
	function ($m) {
		if ($m[1]) {
			// Replace inner // with @@@@
			return str_replace('//', '@@@@', $m[1]);
		}
		if ($m[2]) {
			// Replace :// with :@@@@
			return str_replace('://', ':@@@@', $m[2]);
		}
		if ($m[3]) {
			// Replace ----- ----- with &&&&& ... &&&&&
			return str_replace('-----', '&&&&&', $m[3]);
		}
		return $m[0];
	},
	$text
	);

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

// ---- Restore protected parts ----
$text = str_replace('@@@@', '//', $text);
$text = str_replace('&&&&&', '-----', $text);

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
		if ($m[4]) {
			// Simple link: [[url]] or ((url))
			return $m[4];
		}
		return $m[0];
	},
	$text
	);

echo $text;
