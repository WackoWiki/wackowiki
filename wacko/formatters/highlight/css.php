<?php
/**
 * Highlight CSS Code
 *
 * @author Davey Shafik <davey@php.net>
 * @copyright Copyright 2003 Davey Shafik and Synaptic Media. All Rights Reserved.
 */
$options['color']['tags'] = "red";
$options['color']['attributes'] = "#800000";
$options['color']['other'] = "#A6A6A6";
$options['color']['comment'] = "gray";
$options['color']['attributevalues'] = "blue";
$options['color']['entities'] = "orange";
$options['color']['digits'] = "green";
$options['line_numbers'] = false;
if (isset($options['notypo']) && $options['notypo'] !== false) $options['notypo'] = true;

$css = htmlspecialchars($text);
$keywords = array(
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
	'border-width',
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
	'word-spacing',
	'z-index',
);

// These should NOT be followed by a -
$special_keywords = array(	'color',
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
	);
	// These should NOT be preceeded by a -
	$special_keyword2 = array(	'height',
	'left',
	'bottom',
	'top',
	'right',
	'size',
	'width'
	);

	$css = str_replace(":","\:",$css);

	foreach($keywords as $i)
	{
		$css = str_replace($i,'<span style="color: ##oct##;">' .$i. '</span>',$css);
	}

	foreach($special_keywords as $i)
	{
		$css = str_replace($i . '\:','<span style="color: ##oct##;">' .$i. '</span>\:',$css);
	}

	foreach($special_keyword2 as $i)
	{
		$css = preg_replace(
		'/[^-y]' . $i . '/',
		'<span style="color: ##oct##;">' .$i. '</span>',
		$css);
	}

	$css = preg_replace('/(\.?)(.*)(\s?\{?)/s', "&nbsp;<span style=\"color: ##ocv##;\">$1$2</span>$3", $css);

	$css = preg_replace("/(\#[0-9a-fA-F]+|\d+(px))/", "<span style=\"color: ".$options['color']['digits'].";\">$1</span>",$css);

	$css = str_replace("\:","<span style=\"color: ".$options['color']['attributes']."; font-weight: bold;\">:</span>",$css);
	$css = str_replace("{", "<span style=\"color: ".$options['color']['attributes']."; font-weight: bold;\">{</span>",$css);
	$css = str_replace("}", "<span style=\"color: ".$options['color']['attributes']."; font-weight: bold;\">}</span>",$css);

	$css = preg_replace(
				 '!/\*(.*?)\*/!es',
				 '"<span style=\"color: '.$options['color']['comment'].';\">/*".strip_tags("$1")."*/</span>"',
	$css);

	$css = str_replace("##oct##", $options['color']['tags'], $css);
	$css = str_replace("##ocv##", $options['color']['attributevalues'], $css);

	if ($options['line_numbers'] == true) {
		$lines = preg_split("/(\n|<br \/>)/s",$css);
		$source = '<ol>';
		$i = 0;
		foreach ($lines as $line)
		{
			$i += 1;
			$source .= '<li id="l' .$i. '">' .trim($line). "</li>";
		}
		$source .= '</ol>';
	}

	if (isset($options['notypo'])) echo "<!--no"."typo-->";
	if (!isset($options['nopre'])) echo "<pre class=\"code\">";
	echo preg_replace("/\&nbsp\;/", "", str_replace("\t","	",$css), 1);
	if (!isset($options['nopre'])) echo "</pre>";
	if (isset($options['notypo'])) echo "<!--/no"."typo-->";

	?>
