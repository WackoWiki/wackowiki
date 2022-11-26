<?php

// WackoWiki Wrapper for Highlight.js
// https://wackowiki.org/doc/Dev/PatchesHacks/Highlight.js

/*
	%%(hljs [language])
	content
	%%

	requires Highlight.js script <https://highlightjs.org/>
	The Highlight.js script must be loaded once either via the {{math}} action or the theme header.
*/

// comment this out when you've set this statically in the theme header
if (!isset($this->hljs))
{
	$this->hljs			= true;
	$tpl->action_name	= 'hljs';
}

if ($options['_default'])
{
	$language	= $options['_default'];

	if (!empty($language))
	{
		$class = match ($language)
		{
			'nohighlight'		=> 'nohighlight',
			default				=> 'language-' . $language
		};
	}

	if ($class)
	{
		$tpl->class = ' class="' . $class . '"';
	}
}

$tpl->text = Ut::html($text);
