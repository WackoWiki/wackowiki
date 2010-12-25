<?php

$output = '';

$options['default']		= '';
$options['source']		= $this->tag;
$options['copy_button']	= false;
$options['no<p>']		= true;

if (empty($options['default'])) $options['default'] = 'wacko';

// -------------------------------------------------------------------------------------
if (!function_exists('formatter_source_callback'))
{
	function formatter_source_callback($matches)
	{
		$m		= $matches[1];
		$nbsp	= "&nbsp;";
		$result	= '';

		for( $i = strlen($m); $i > 0; $i-- )
		{
			$result .= $nbsp;
		}

		return $result;
	}
}
// -------------------------------------------------------------------------------------

if ($options['default'] == 'wacko')
{
	// cut comments
	$text = preg_replace( "/(\n?)%%\((c|comments)\).*?%%([\n\r]*)/ims", '', $text );

	// insert about the source
	$text = $text.="\n\n----\n".$this->get_translation('SourceFrom')."((".$options['source']."))";

	// prepare a text to the conclusion
	$output = htmlspecialchars( $text );
	$output = preg_replace_callback("/^( +)/mi", "formatter_source_callback", $output);
	$output = $this->format( $output, 'simplebr', null, 0, array('no<p>' => 1) );
}
else
	if ($options['default'] == 'rawhtml')
	{
		// insert about the source
		$text = $text.="\n\n<br /><br /><hr />\n\n<p>".
			$this->get_translation('SourceFrom').
				$this->link($options['source'], '', $this->get_translation('SourceFromLink')).
				"</p>";

		$output = htmlspecialchars( $text );
		$output = str_replace("\n", "<br />", $output);
	}
	else if ($options['default'] == 'simplebr')
	{
		// insert about the source
		$text = $text.="\n\n<hr />\n".$this->get_translation('SourceFrom').
		$this->href($options['source']);

		$output = htmlspecialchars( $text );
	}

$div_id = "document_source_".md5($options['source']);
echo "<!--no"."typo-->";

// copy to clipboard is implemented only for MSIE for now
if ($options['copy_button'])
{
	echo "<button id=\"button_$div_id\" style=\"margin:5px\" onclick=\"
		ta  = document.getElementById('textarea_$div_id');
		div = document.getElementById('$div_id');
		ta.value = div.innerText;
		range = ta.createTextRange();
		range.execCommand('Copy');
		this.style.backgroundColor='#ffffdd';
		setTimeout('document.getElementById(\''+this.id+'\').style.backgroundColor = \'#dddddd\';', 100);
		\">". $this->get_translation("SourceCopyToClipboard")."</button>";
	echo "<textarea style=\"display:none\" id=\"textarea_$div_id\" ></textarea>";
}

echo "<div id=\"$div_id\" class=\"code\" style='padding:5px'>";
echo $output;
echo "</div>";

echo "<!--/no"."typo-->";

?>