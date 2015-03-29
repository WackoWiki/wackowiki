<?php

if (!defined('IN_WACKO'))
{
	exit;
}

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

		$text = htmlspecialchars($vars['text'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);
	}

	$title = '';

	if(isset($vars['title']))
	{
		$title = htmlspecialchars($vars['title'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);
	}

	$href = htmlspecialchars($href, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET);
	echo '<a id="'.$href.'" href="#'.$href.'" title="'.$title.'">'.$text.'</a>'."\n";
}

?>