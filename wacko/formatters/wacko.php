<?php

$this->UseClass("WackoFormatter", "formatters/classes/");

$text = str_replace("\r", "", $text);
$text = "\177\n".$text."\n";

$parser = &new WackoFormatter( $this );

$this->headerCount = 0;
$text = preg_replace_callback($parser->NOTLONGREGEXP, array( &$parser, "WackoPreprocess"), $text);
$texts = explode("\xa5\xa5", $text);
$wtext = $texts[0];
for ($i=2;$i<count($texts);$i=$i+2)
$wtext = $wtext."\xa6".$texts[$i];
$wtext = preg_replace_callback($parser->MOREREGEXP, array( &$parser, "WackoMiddleprocess"), $wtext);
$wtext = preg_replace_callback($parser->LONGREGEXP, array( &$parser, "WackoCallback"), $wtext);
$wtexts = explode("\xa6", $wtext);
$text = "";
for ($i=0;$i<count($wtexts);$i++)
$text = $text.$wtexts[$i].$texts[2*$i+1];

//$text = implode("", $texts);
$text = str_replace("\177"."<br />\n","",$text);
$text = str_replace("\177"."","",$text);

// we're cutting the last <br />
$text = preg_replace("/<br \/>$/", "", $text);//trim($text));

// close all open tables
$opens = preg_match_all("/<table/", $text, $matches);
$closes = preg_match_all("/<\/table/", $text, $matches);
if (1*$closes < 1*$opens)
for ($i=0;$i<(1*$opens - 1*$closes);$i++) $text .= "</table>";

print($text);

?>