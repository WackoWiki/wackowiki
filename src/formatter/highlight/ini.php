<?php
/*
 INI formatter by NonTroppo (originally by Rijk van Geijtenbeek)
 */

$text = htmlspecialchars($text, ENT_QUOTES, HTML_ENTITIES_CHARSET);

$text = preg_replace('/([=,\|]+)/um',				'<span style="color: #4400DD;">\\1</span>', $text);
$text = preg_replace('/^([;#].+)$/um',				'<span style="color: #226622;">\\1</span>', $text);
$text = preg_replace('/([^\d\w#;:>])([;#].+)$/um',	'<span style="color: #226622;">\\2</span>', $text);
$text = preg_replace('/^(\[.*\])/um',				'<strong style="color: #AA0000; background: #EEE0CC;">\\1</strong>', $text);

// output source
$tpl->text = $text;
