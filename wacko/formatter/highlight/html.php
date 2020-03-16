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
$options['line_numbers']				= false;

$html_tags = [
	'!DOCTYPE',
	'a',
	'abbr',
	'acronym',
	'address',
	'applet',
	'area',
	'article', // HTML5
	'aside', // HTML5
	'audio', // HTML5
	'b',
	'base',
	'basefont',
	'bgsound',
	'bdi', // HTML5
	'bdo',
	'big',
	'blink',
	'blockquote',
	'body',
	'br',
	'button',
	'canvas', // HTML5
	'caption',
	'center',
	'cite',
	'code',
	'col',
	'colgroup',
	'comment',
	'datalist', // HTML5
	'dd',
	'del',
	'details', // HTML5
	'dfn',
	'dir',
	'div',
	'dl',
	'dt',
	'em',
	'embed',
	'fieldset',
	'figcaption', // HTML5
	'figure', // HTML5
	'font',
	'footer', // HTML5
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
	'header', // HTML5
	'hgroup', // HTML5
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
	'keygen', // HTML5
	'label',
	'legend',
	'li',
	'link',
	'listing',
	'main', // HTML5
	'map',
	'mark',
	'marquee',
	'menu',
	'meta',
	'meter', // HTML5
	'multicol',
	'nav', // HTML5
	'nextid',
	'nobr',
	'noframes',
	'noscript',
	'object',
	'ol',
	'optgroup',
	'option',
	'output', // HTML5
	'p',
	'param',
	'plaintext',
	'pre',
	'progress', // HTML5
	'q',
	'ruby', // HTML5
	'rp', // HTML5
	'rt', // HTML5
	's',
	'samp',
	'script',
	'section', // HTML5
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
	'summary', // HTML5
	'sup',
	'svg', // HTML5
	'table',
	'tbody',
	'td',
	'template', // HTML5
	'textarea',
	'textflow',
	'tfoot',
	'th',
	'thead',
	'time', // HTML5
	'title',
	'tr',
	'track', // HTML5
	'tt',
	'u',
	'ul',
	'var',
	'video', // HTML5
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
			$source = preg_replace("/&amp;([a-z0-9]*?;)/ui", '&amp;<span style="color: ' . $options['color']['entities'] . ';">$1</span>', $source);

	if ($options['line_numbers'] == true)
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

	echo '<!--notypo-->';
	echo '<pre class="code">';
	echo str_replace("\t", "  ", $source);
	echo "</pre>";
	echo '<!--/notypo-->';
