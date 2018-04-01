<?php

if (!defined('IN_WACKO'))
{
	exit;
}

extract(array_merge(['default' => 'wacko', 'source' => $this->tag, 'copy_button' => false], $options));

$div_id = Ut::random_token(10);
echo '<!--notypo-->';

// copy to clipboard
if ($copy_button)
{
	$this->add_html('footer', '<script src="' . $this->db->base_url . 'js/clipboard.min.js" async onload="new ClipboardJS(\'.clipb\')"></script>');

	echo '<button class="clipb" style="margin:5px;" data-clipboard-target="#' . $div_id . '">' .
		$this->_t('SourceCopyToClipboard') .
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
		$text .= "\n\n----\n" . $this->_t('SourceFrom') . '((/' . $source . '))';

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
		echo str_replace("\n", '<br>', Ut::html($text));

		// about the source
		echo "\n\n<br><br><hr>\n\n<p>" .
			$this->_t('SourceFrom') .
				$this->link($source, '', $this->_t('SourceFromLink')) .
				"</p>";
		break;

	case 'simplebr':
		echo Ut::html($text);

		// about the source
		echo "\n\n<hr>\n" . $this->_t('SourceFrom') . $this->href($source);
		break;
}

echo '</pre>';
echo '<!--/notypo-->';
