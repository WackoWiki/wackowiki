<?php

// If User has rights to edit page, show Edit link
// {{edit [page="yourPage"] [text="your text"]}}

if (!isset($for)) $for = '';
if (!isset($page)) $page = '';
if (!isset($output)) $output = '';
if (!isset($text)) $text = '';

if ($for) $page=$for;
	$editpage = $this->href('', $page.'/edit');
if (!$page)
	{$editpage = $this->href('edit');}
if (!$text)
	$text = $this->get_translation('EditText');
	$output .= $this->has_access('write') ? "<a href=\"".$editpage."\" accesskey=\"E\" title=\"".$this->get_translation('EditTip')."\">".$text."</a>\n" : "";

	echo ($output);

?>