<?php
// Param name
if($vars[0]) {

	$href = $vars[0];

	$text = '';
	if($vars['text']) {
		if(strpos($vars['text'], "~") !== false) {
			$vars['text'] = str_replace("~", $href, $vars['text']);
		}
		$text = htmlspecialchars($vars['text']);
	}

	$title = '';
	if($vars['title']) {
		$title = htmlspecialchars($vars['title']);
	}

	$href = htmlspecialchars($href);
	echo "<a name=\"$href\" href=\"#$href\" title=\"$title\">$text</a>\n";
}
?>