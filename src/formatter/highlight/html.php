<?php
/**
 * Highlight HTML Markup
 *
 * @author Davey Shafik <davey@php.net>
 * @copyright Copyright 2003 Davey Shafik and Synaptic Media. All Rights Reserved.
 */
$options['color']['tags']				= '#000080';
$options['color']['attributes']			= '#800000';
$options['color']['other']				= '#A6A6A6';
$options['color']['comment']			= 'gray';
$options['color']['attributevalues']	= 'blue';
$options['color']['entities']			= 'orange';
$options['line_numbers']				= $options['numbers'] ?? false;

$html_tags = [
	'!DOCTYPE',
	'a',
	'abbr',
	'acronym',
	'address',
	'applet',
	'area',
	'article',
	'aside',
	'audio',
	'b',
	'base',
	'basefont',
	'bgsound',
	'bdi',
	'bdo',
	'big',
	'blink',
	'blockquote',
	'body',
	'br',
	'button',
	'canvas',
	'caption',
	'center',
	'cite',
	'code',
	'col',
	'colgroup',
	'comment',
	'datalist',
	'dd',
	'del',
	'details',
	'dfn',
	'dir',
	'div',
	'dl',
	'dt',
	'em',
	'embed',
	'fieldset',
	'figcaption',
	'figure',
	'font',
	'footer',
	'form',
	'frame',
	'frameset',
	'h',
	'h1',
	'h2',
	'h3',
	'h4',
	'h5',
	'h6',
	'head',
	'header',
	'hgroup',
	'hr',
	'hta:application',
	'html',
	'i',
	'iframe',
	'img',
	'input',
	'ins',
	'isindex',
	'kbd',
	'keygen',
	'label',
	'legend',
	'li',
	'link',
	'listing',
	'main',
	'map',
	'mark',
	'marquee',
	'menu',
	'meta',
	'meter',
	'multicol',
	'nav',
	'nextid',
	'nobr',
	'noframes',
	'noscript',
	'object',
	'ol',
	'optgroup',
	'option',
	'output',
	'p',
	'param',
	'plaintext',
	'pre',
	'progress',
	'q',
	'ruby',
	'rp',
	'rt',
	's',
	'samp',
	'script',
	'section',
	'select',
	'server',
	'small',
	'sound',
	'spacer',
	'span',
	'strike',
	'strong',
	'style',
	'sub',
	'summary',
	'sup',
	'svg',
	'table',
	'tbody',
	'td',
	'template',
	'textarea',
	'textflow',
	'tfoot',
	'th',
	'thead',
	'time',
	'title',
	'tr',
	'track',
	'tt',
	'u',
	'ul',
	'var',
	'video',
	'wbr',
	'xmp'
	];

$source = Ut::html($text);

$source = preg_replace_callback(
		'/&lt;!--(.*?)--&gt;/us',
		function ($matches) use ($options)
		{
			return
			'<span style="color: ' . $options['color']['comment'] . ';">&lt;!--' .
			str_replace('&lt;',	'&lt;<!-- -->',
			str_replace('=',	'=<!-- -->',
			$matches[1])) .
			'--&gt;</span>';
		},
	$source);

$source = preg_replace_callback(
		'/(&lt;style.*?&gt;)(.*?)&lt;\/style&gt;/us',
		function ($matches)
		{
			return
			$matches[1] .
			$this->format($matches[2], 'highlight/css', ['nopre' => true, 'notypo' => false]) .
			'&lt;/style&gt;';
		},
	$source);

foreach ($html_tags as $i)
{
	$source = preg_replace(
			'/&lt;' . $i . '(&gt;|[[:space:]])/u',
			'<span style="color: ' . $options['color']['tags'] . ';font-weight:bold;">&lt;' . $i . '\\1</span>',
			$source);

	$source = str_replace(
			'&lt;/' . $i . '&gt;',
			'<span style="color: ' . $options['color']['tags'] . ';font-weight:bold;">&lt;/' . $i . '&gt;</span>',
			$source);
}

$source = str_replace(
		'/&gt;',
		'<span style="color: ' . $options['color']['tags'] . ';font-weight:bold;">/&gt;</span>',
		$source);

$source = preg_replace(
		'/([[:space:]]|&quot;|\'|\?)&gt;/u',
		'\\1<span style="color: ' . $options['color']['tags'] . ';font-weight:bold;">&gt;</span>',
		$source);

$source = preg_replace(
		'/([a-z-]+)=(&quot;|\')(.*?)\\2/ui',
		'<span style="color: ' . $options['color']['attributes'] . ';font-weight:bold;">$1=</span><span style="color: ' .
		$options['color']['attributevalues'] . ';">$2$3$2</span>', $source);
		$source = preg_replace("/&amp;([a-z\d]*?;)/ui", '&amp;<span style="color: ' . $options['color']['entities'] . ';">$1</span>', $source);

if ($options['line_numbers'])
{
	$lines		= preg_split("/(\n|<br \/>)/us", $source);
	$source		= '<ol>';
	$i			= 0;

	foreach ($lines as $line)
	{
		$i += 1;
		$source .= '<li id="l' . $i . '">' . rtrim($line) . "</li>";
	}

	$source .= '</ol>';
}

// output source
$tpl->text = str_replace("\t", "  ", $source);
