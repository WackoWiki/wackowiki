<?php
/*
 INI formatter
 */

$options['line_numbers'] = $options['numbers'] ?? false;

$text = Ut::html($text);

$text = preg_replace('/([=,\|]+)/um',				'<span class="ini-1">\\1</span>', $text);
$text = preg_replace('/^([;#].+)$/um',				'<span class="ini-2">\\1</span>', $text);
$text = preg_replace('/([^\d\w#;:>])([;#].+)$/um',	'<span class="ini-2">\\2</span>', $text);
$text = preg_replace('/^(\[.*\])/um',				'<span class="ini-3">\\1</span>', $text);

if ($options['line_numbers'])
{
	$lines		= preg_split("/(\n|<br>)/us", $text);
	$text		= '<ol>';

	foreach ($lines as $line)
	{
		$text .= '<li>' . trim($line) . '</li>';
	}

	$text .= '</ol>';
}

// output source
$tpl->text = $text;
