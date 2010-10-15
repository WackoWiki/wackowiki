<?php

$this->use_class('wackoformatter', 'formatters/classes/');

$text	= str_replace("\r", '', $text);
$text	= "\177\n".$text."\n";

$parser	= new WackoFormatter($this);

$this->header_count = 0;

$text	= preg_replace_callback($parser->NOTLONGREGEXP, array(&$parser, 'wacko_preprocess'), $text);
$texts	= explode('<!--escaped-->', $text);
$wtext	= $texts[0];

for ($i = 2; $i < count($texts); $i = $i + 2)
{
	$wtext = $wtext."\xa6".$texts[$i];
}

$wtext	= preg_replace_callback($parser->MOREREGEXP, array(&$parser, 'wacko_middleprocess'), $wtext);
$wtext	= preg_replace_callback($parser->LONGREGEXP, array(&$parser, 'wacko_callback'), $wtext);
$wtexts	= explode("\xa6", $wtext);
$text	= '';

for ($i = 0; $i < count($wtexts); $i++)
{
	$text = $text.((isset($wtexts[$i])) ? $wtexts[$i] : '').((isset($texts[2 * $i + 1])) ? $texts[2 * $i + 1] : '');
}

//$text	= implode('', $texts);
$text	= str_replace("\177"."<br />\n", '', $text);
$text	= str_replace("\177"."", '', $text);

// we're cutting the last <br />
$text	= preg_replace('/<br \/>$/', '', $text); //trim($text));

// close all open tables
$opens	= preg_match_all('/<table/', $text, $matches);
$closes	= preg_match_all('/<\/table/', $text, $matches);

if (1 * $closes < 1 * $opens)
{
	for ($i = 0; $i < (1 * $opens - 1 * $closes); $i++)
	{
		$text .= '</table>';
	}
}

print($text);

?>