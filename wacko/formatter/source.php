<?php

if (!defined('IN_WACKO'))
{
	exit;
}

extract(array_merge(['default' => 'wacko', 'source' => $this->tag, 'copy_button' => false], $options));

$div_id = "document_source_" . hash('sha1', $source);
echo '<!--notypo-->';

// copy to clipboard is implemented only for MSIE for now
if ($copy_button)
{
	echo '<button id="button_'.$div_id.'" style="margin:5px" onclick="
		ta  = document.getElementById(\'textarea_'.$div_id.'\');
		div = document.getElementById(\''.$div_id.'\');
		ta.value = div.innerText;
		range = ta.createTextRange();
		range.execCommand(\'Copy\');
		this.style.backgroundColor=\'#ffffdd\';
		setTimeout(\'document.getElementById(\''+this.id+'\').style.backgroundColor = \'#dddddd\';\', 100);
		">'. $this->get_translation('SourceCopyToClipboard').'</button>';
	echo '<textarea style="display:none" id="textarea_'.$div_id.'" ></textarea>';
}

echo '<pre id="' . $div_id . '" class="code" style="padding:5px">';

switch ($default)
{
	case 'wacko':
		// strip comments
		$text = preg_replace('/(\n?)%%\((comment)\).*?%%([\n\r]*)/ims', '', $text);

		$text = Ut::html($text);

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
