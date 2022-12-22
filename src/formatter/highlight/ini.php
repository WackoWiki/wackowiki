<?php
/*
 INI formatter
 */

$text = htmlspecialchars($text, ENT_QUOTES, HTML_ENTITIES_CHARSET);

$text = preg_replace('/([=,\|]+)/um',				'<span class="ini-1">\\1</span>', $text);
$text = preg_replace('/^([;#].+)$/um',				'<span class="ini-2">\\1</span>', $text);
$text = preg_replace('/([^\d\w#;:>])([;#].+)$/um',	'<span class="ini-2">\\2</span>', $text);
$text = preg_replace('/^(\[.*\])/um',				'<strong class="ini-3">\\1</strong>', $text);

// output source
$tpl->text = $text;
