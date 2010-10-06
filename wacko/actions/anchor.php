<?php
// Param name
if(isset($vars[0]))
{
	$href = $vars[0];

	$text = '';
	if(isset($vars['text']))
	{
		if(strpos($vars['text'], '~') !== false)
		{
			$vars['text'] = str_replace('~', $href, $vars['text']);
		}
		$text = htmlspecialchars($vars['text']);
	}

	$title = '';
	if(isset($vars['title']))
	{
		$title = htmlspecialchars($vars['title']);
	}

	$href = htmlspecialchars($href);
	echo "<a name=\"$href\" href=\"#$href\" title=\"$title\">$text</a>\n";
}
?>