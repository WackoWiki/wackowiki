<?php

// Removes all the basic wiki-markup, giving a simple text.
// Formatter is most suitable for the purification of the text after
// Replace the bbcode on wacko-syntax.

if ($text == '') return;

	// ignore the slashes and the long dash in the title, in yurlah and pgp headers
	$text = preg_replace('/====(.*?)\/\/(.*?)\/\/(.*?)====/',	'\\1@@@@\\2@@@@\\3',	$text);
	$text = preg_replace('/(http:|https:|ftp:|nntp:)\/\//',		'\\1@@@@',				$text);
	$text = preg_replace('/-{5}([A-Z ]+?)-{5}/',				'&&&&&\\1&&&&&',		$text);

	// Cut a simple counting
	$text = str_replace('**',	'',  $text);
	$text = str_replace('//',	'',  $text);
	$text = str_replace('__',	'',  $text);
	$text = str_replace('----',	'',  $text);
	$text = str_replace('---',	'',  $text);
	$text = str_replace('##',	'',  $text);
	$text = str_replace('¹¹',	'',  $text);
	$text = str_replace('++',	'',  $text);
	$text = str_replace('??',	'',  $text);
	$text = str_replace('""',	'',  $text);
	$text = str_replace('~',	'',  $text);
	$text = str_replace('>>>',	'',  $text);
	$text = str_replace('>>',	'',  $text);
	$text = str_replace('<<<',	'',  $text);
	$text = str_replace('<<',	'',  $text);
	$text = str_replace('%%',	'',  $text);
	$text = str_replace('======',	'',  $text);
	$text = str_replace('=====',	'',  $text);
	$text = str_replace('====',	'',  $text);
	$text = str_replace('===',	'',  $text);
	$text = str_replace('<[',	'"', $text);
	$text = str_replace(']>',	'"', $text);
	$text = str_replace('#||',	'"', $text);
	$text = str_replace('||#',	'"', $text);
	$text = str_replace('#|',	'"', $text);
	$text = str_replace('|#',	'"', $text);
	$text = str_replace('||',	'',  $text);

	// Cut headlines h1
	$text = preg_replace('/==.+?==[\s]*/', '', $text);

	// return slash and dash
	$text = str_replace('@@@@',  '//',		$text);
	$text = str_replace('&&&&&', '-----',	$text);

	// cut or parse a complex layout
	$text = preg_replace('/!!(?:\\([\\w]+?\\))*(.+?)!!/',	'\\1',	$text); // !!(color)text!!
	$text = preg_replace('/\\^\\^([^\\s]+?)\\^\\^/',		'^\\1',	$text); // ^^123^^
	$text = preg_replace('/{{.+?}}[\s]*/',					'',		$text); // {{action}}
	$text = preg_replace('/[\n]{2,}/',						"\n\n",	$text); // more than two transfers
	$text = preg_replace('/\\n[ ]{1}/',						'',		$text); // gap in the beginning of the line
	$text = preg_replace('/--([^ ])/',						'[\\1',	$text); // strikethrough; not to be confused with the long dashes
	$text = preg_replace('/([^ ])--/',						'\\1]',	$text); // strikethrough; not to be confused with the long dashes

	// Links
	$text = preg_replace('/(?:\\[\\[|\\(\\()([^\\s]+?) (.*?)(?:\\]\\]|\\)\\))/',	'\\2 (\\1)',	$text); // complex
	$text = preg_replace('/(?:\\[\\[|\\(\\()([^\\s]+?)(?:\\]\\]|\\)\\))/',			'\\1',			$text); // simple

echo $text;

?>