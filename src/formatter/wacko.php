<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$text	= str_replace("\r", '', $text);
$text	= "\u{2592}\n" . $text . "\n";

$parser	= new WackoFormatter($this);

$this->header_count		= 0;
$this->section_count	= 0;

$text	= preg_replace_callback($parser->PRE_REGEX, [&$parser, 'wacko_preprocess'], $text);
$texts	= explode('<!--escaped-->', $text);
$wtext	= $texts[0];

for ($i = 2; $i < count($texts); $i = $i + 2)
{
	$wtext = $wtext . "\u{00FE}\u{00A6}" . $texts[$i];
}

$wtext	= preg_replace_callback($parser->MIDDLE_REGEX, [&$parser, 'wacko_middleprocess'], $wtext);
$wtext	= preg_replace_callback($parser->LONG_REGEX,   [&$parser, 'wacko_callback'],      $wtext);
$wtexts	= explode("\u{00FE}\u{00A6}", $wtext);
$text	= '';

for ($i = 0; $i < count($wtexts); $i++)
{
	$text = $text .
			($wtexts[$i]			?? '') .
			($texts[2 * $i + 1]		?? '');
}

$text	= str_replace("\u{2592}" . "<br>\n", '', $text);
$text	= str_replace("\u{2592}", '', $text);

// we're cutting the last <br>
$text	= preg_replace('/<br>$/u', '', $text);

// close all open tables
$opens	= preg_match_all('/<table/u', $text, $matches);
$closes	= preg_match_all('/<\/table/u', $text, $matches);

if (1 * $closes < 1 * $opens)
{
	$text .= str_repeat('</table>', (1 * $opens - 1 * $closes));
}

// format footnote content
if (!empty($parser->auto_fn['content']))
{
	$footnotes = '';

	foreach ($parser->auto_fn['content'] as $fn_no => $fn)
	{
		$footnote	 =	preg_replace_callback($parser->LONG_REGEX, [&$parser, 'wacko_callback'], $fn);
		$footnotes	.=	'<dt>[<a title="footnote ' . $fn_no . ' ref" href="#footnote-' . $fn_no . '-ref">' . $fn_no . "</a>]</dt>\n" .
							'<dd id="footnote-' . $fn_no . '">' . $footnote . "</dd>\n";
	}

	// write the footnotes
	$text .=	'<br><br>' .
				'<div class="layout-box" id="footnotes">
					<p><span>' . $this->_t('Footnotes') . "</span></p>\n" .
					"<dl>\n" .
						$footnotes.
					"</dl>\n" .
				'</div>' .
				'<br>';

	$parser->auto_fn['content'] = null;
}

echo $text;
