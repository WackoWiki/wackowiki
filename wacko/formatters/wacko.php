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

$text	= str_replace("\177"."<br />\n", '', $text);
$text	= str_replace("\177"."", '', $text);

// we're cutting the last <br />
$text	= preg_replace('/<br \/>$/', '', $text);

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

//format footnote content
if (!empty($parser->auto_fn['content']))
{
	$footnotes = '';

	foreach ($parser->auto_fn['content'] as $footnote_no => $footnote)
	{
		$footnote = preg_replace_callback($parser->LONGREGEXP, array(&$parser, 'wacko_callback'), $footnote);
		$footnotes .= '<dt>[<a title="footnote '.$footnote_no.' ref" href="#footnote-'.$footnote_no.'-ref">'.$footnote_no.'</a>]</dt><dd id="footnote-'.$footnote_no.'">'.$footnote."</dd>\n";
	}

	// write the footnotes
	$text .= "<br /><br /><div class=\"layout-box\" id=\"footnotes\"><p class=\"layout-box\"><span>".$this->get_translation('Footnotes').":</span></p>\n".$footnotes."</div><br />";

	$parser->auto_fn['content'] = '';
}

echo $text;

?>