<?php
require_once('lib/Text_Highlighter/Highlighter.php');

if ($options['_default'])
{
	$hl =& Text_Highlighter::factory(strtoupper($options['_default']), array('numbers' => false));

	if (!is_object($hl))
	{
		echo $hl;
	}
	else
	{
		echo '<!--no'.'typo-->';

		// Highlighter class adds already a <pre> tag wrapper
		echo #'<pre class="code">'.
					$hl->highlight($text).
			#'</pre>'.
			'';
		echo '<!--/no'.'typo-->';
	}
}
else
{
	echo htmlspecialchars($text, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);
}
?>