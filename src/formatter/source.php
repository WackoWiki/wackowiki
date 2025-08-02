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
	$this->add_html('footer', '<script src="' . $this->db->base_path . 'js/clipboard.min.js" async onload="new ClipboardJS(\'.clipb\')"></script>');

	echo '<button type="button" class="clipb" data-clipboard-target="#' . $div_id . '">' .
		$this->_t('SourceCopyToClipboard') .
		'</button>';
}

echo '<pre id="' . $div_id . '" class="code source-handler">';

switch ($default)
{
	case 'wacko':
		// strip comments
		$text = preg_replace('/\n?(%%\(comment\).*?%%|``\(comment\).*?``)([\n\r]*)/uims', '', $text);
		$text = Ut::html($text, false);

		// prepare a text to the conclusion
		$text = preg_replace_callback('/^ +/um',
			function ($matches)
			{
				$m = mb_strlen($matches[0]);
				return str_repeat('&nbsp; ', $m >> 1) . (($m & 1)? '&nbsp;' : '');
			},
			$text);

		echo $text;
		break;

	case 'rawhtml':
		echo str_replace("\n", '<br>', Ut::html($text));
		break;
}

echo '</pre>';
echo '<!--/notypo-->';
