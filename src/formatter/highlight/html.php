<?php

/**
 * Highlight HTML Markup
 */

$options['color']['attribute']			= 'html-attr';
$options['color']['attributevalue']		= 'html-attrval';
$options['color']['comment']			= 'html-comment';
$options['color']['entity']				= 'html-entity';
$options['color']['tag']				= 'html-tag';
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
			'<span class="' . $options['color']['comment'] . '">&lt;!--' .
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
			'<span class="' . $options['color']['tag'] . '">&lt;' . $i . '\\1</span>',
			$source);

	$source = str_replace(
			'&lt;/' . $i . '&gt;',
			'<span class="' . $options['color']['tag'] . '">&lt;/' . $i . '&gt;</span>',
			$source);
}

$source = str_replace(
		'/&gt;',
		'<span class="' . $options['color']['tag'] . '">/&gt;</span>',
		$source);

$source = preg_replace(
		'/([[:space:]]|&quot;|\'|\?)&gt;/u',
		'\\1<span class="' . $options['color']['tag'] . '">&gt;</span>',
		$source);

$source = preg_replace(
		'/([a-z-]+)=(&quot;|\')(.*?)\\2/ui',
		'<span class="' . $options['color']['attribute'] . '">$1=</span>' .
		'<span class="' . $options['color']['attributevalue'] . '">$2$3$2</span>',
		$source);

$source = preg_replace(
		'/&amp;([a-z\d]*?;)/ui',
		'&amp;<span class="' . $options['color']['entity'] . '">$1</span>',
		$source);

if ($options['line_numbers'])
{
	$lines		= preg_split("/(\n|<br>)/us", $source);
	$source		= '<ol>';
	$i			= 0;

	foreach ($lines as $line)
	{
		$i += 1;
		$source .= '<li id="l' . $i . '">' . rtrim($line) . '</li>';
	}

	$source .= '</ol>';
}

// output source
$tpl->text = str_replace("\t", '  ', $source);
