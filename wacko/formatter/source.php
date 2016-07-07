<?php

if (!defined('IN_WACKO'))
{
	exit;
}

extract(array_merge(['default' => 'wacko', 'source' => $this->tag, 'copy_button' => false], $options));

$div_id = Ut::random_token(13, 2);
echo '<!--notypo-->';

// copy to clipboard is implemented only for MSIE for now
if ($copy_button)
{
	$this->add_html_head('<script type="text/javascript" src="' . $this->config['base_url'] . 'js/clipboard.min.js" async onload="new Clipboard(\'.clipb\')"></script>' . "\n");

	echo '<button class="clipb" style="margin:5px" data-clipboard-target="#' . $div_id . '">'.
		$this->get_translation('SourceCopyToClipboard').
		'</button>';
}

echo '<pre id="' . $div_id . '" class="code" style="padding:5px">';

switch ($default)
{
	case 'wacko':
		// strip comments
		$text = preg_replace('/(\n?)%%\((comment)\).*?%%([\n\r]*)/ims', '', $text);

		$text = Ut::html($text, false);

		// insert about the source
		$text .= "\n\n----\n" . $this->get_translation('SourceFrom') . '((/' . $source . '))';

		// prepare a text to the conclusion
		$text = preg_replace_callback('/^ +/m',
			function ($matches)
			{
				$m = strlen($matches[0]);
				return str_repeat('&nbsp; ', $m >> 1) . (($m & 1)? '&nbsp;' : '');
			},
			$text);

		echo $this->format($text, 'simplebr', ['no<p>' => 1]);
		break;

	case 'rawhtml':
		echo str_replace("\n", '<br />', Ut::html($text));

		// about the source
		echo "\n\n<br /><br /><hr />\n\n<p>".
			$this->get_translation('SourceFrom').
				$this->link($source, '', $this->get_translation('SourceFromLink')).
				"</p>";
		break;

	case 'simplebr':
		echo Ut::html($text);

		// about the source
		echo "\n\n<hr />\n" . $this->get_translation('SourceFrom') . $this->href($source);
		break;
}

echo '</pre>';
echo '<!--/notypo-->';
