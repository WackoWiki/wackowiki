<?php

/**
 * Highlight CSS Code
 */

$options['color']['attribute']			= 'css-attr';
$options['color']['attributevalue']		= 'css-attrval';
$options['color']['comment']			= 'css-comment';
$options['color']['digit']				= 'css-digit';
$options['color']['entity']				= 'css-entity';
$options['color']['tag']				= 'css-tag';
$options['line_numbers']				= $options['numbers'] ?? false;

if(!isset($options['nopre'])) $options['nopre'] = false;

$css = Ut::html($text);
$keywords = [
	'azimuth',
	'background-attachment',
	'background-color',
	'background-image',
	'background-position',
	'background-repeat',
	'border-collapse',
	'border-color',
	'border-spacing',
	'border-style',
	'border-top-color',
	'border-top-style',
	'border-top-width',
	'border-bottom-color',
	'border-bottom-style',
	'border-bottom-width',
	'border-right-color',
	'border-right-style',
	'border-right-width',
	'border-left-color',
	'border-left-style',
	'border-left-width',
	'border-radius',
	'border-width',
	'box-shadow',
	'caption-side',
	'clear',
	'clip',
	'content',
	'counter-increment',
	'counter-reset',
	'cue-after',
	'cue-before',
	'cue',
	'cursor',
	'direction',
	'display',
	'elevation',
	'empty-cells',
	'float',
	'font-family',
	'font-size',
	'font-size-adjust',
	'font-stretch',
	'font-style',
	'font-variant',
	'font-weight',
	'letter-spacing',
	'line-break',
	'line-height',
	'list-style-image',
	'list-style-position',
	'list-style-type',
	'list-style',
	'margin-top',
	'margin-bottom',
	'margin-right',
	'margin-left',
	'marker-offset',
	'marks',
	'max-height',
	'max-width',
	'min-height',
	'min-width',
	'orphans',
	'outline-color',
	'outline-style',
	'outline-width',
	'overflow',
	'padding-top',
	'padding-bottom',
	'padding-right',
	'padding-left',
	'page-break-after',
	'page-break-before',
	'page-break-inside',
	'pause-after',
	'pause-before',
	'pitch-range',
	'play-during',
	'position',
	'quotes',
	'richness',
	'speak-header',
	'speak-numeral',
	'speak-punctuation',
	'speech-rate',
	'src',
	'stress',
	'table-layout',
	'text-align',
	'text-decoration',
	'text-indent',
	'text-shadow',
	'text-transform',
	'unicode-bidi',
	'vertical-align',
	'visibility',
	'voice-family',
	'volume',
	'white-space',
	'widows',
	'word-break',
	'word-spacing',
	'z-index',
];

// These should NOT be followed by a -
$special_keywords = [
	'color',
	'background',
	'border',
	'margin',
	'font',
	'padding',
	'outline',
	'speak',
	'pitch',
	'pause',
	'page',
	'border-top',
	'border-bottom',
	'border-right',
	'border-left'
];

// These should NOT be preceded by a -
$special_keyword2 = [
	'height',
	'left',
	'bottom',
	'top',
	'right',
	'size',
	'width'
];

$css = str_replace(':', '\:', $css);

foreach ($keywords as $i)
{
	$css = str_replace($i, '<span class="##oct##">' . $i . '</span>', $css);
}

foreach ($special_keywords as $i)
{
	$css = str_replace($i . '\:', '<span class="##oct##">' . $i . '</span>\:', $css);
}

foreach ($special_keyword2 as $i)
{
	$css = preg_replace('/[^-y]' . $i . '/u', '<span class="##oct##">' . $i . '</span>', $css);
}

$css = preg_replace('/(\.?)(.*)(\s?\{?)/us', '&nbsp;<span class="##ocv##">$1$2</span>$3', $css);

$css = preg_replace("/(\#[a-fA-F\d]+|\d+(px))/u", '<span class="' . $options['color']['digit'] . '">$1</span>', $css);

$css = str_replace('\:', '<span class="' . $options['color']['attribute'] . '">:</span>', $css);
$css = str_replace('{',  '<span class="' . $options['color']['attribute'] . '">{</span>', $css);
$css = str_replace('}',  '<span class="' . $options['color']['attribute'] . '">}</span>', $css);

$css = preg_replace_callback(
		'!/\*(.*?)\*/!us',
		function ($matches) use ($options)
		{
			return
			'<span class="' . $options['color']['comment'] . '">/*' .
			strip_tags($matches[1]) .
			'*/</span>';
		},
		$css);

$css = str_replace('##oct##', $options['color']['tag'], $css);
$css = str_replace('##ocv##', $options['color']['attributevalue'], $css);

if ($options['line_numbers'])
{
	$lines		= preg_split("/(\n|<br>)/us", $css);
	$css		= '<ol>';

	foreach ($lines as $line)
	{
		$css .= '<li>' . trim($line) . '</li>';
	}

	$css .= '</ol>';
}

// uses nopre option inside html formatter
$tpl->enter($options['nopre'] ? 'include_' : 'pre_');

// output source
$tpl->text = preg_replace('/\&nbsp\;/u', '', str_replace("\t", '	', $css), 1);

$tpl->leave(); // include_ / pre_
