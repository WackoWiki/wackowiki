<?php

// If User has rights to edit page, show Edit link
// {{edit [page="yourPage"] [text="your text"]}}

if (!isset($for)) $for = "";
if (!isset($page)) $page = "";
if (!isset($output)) $output = "";
if (!isset($text)) $text = "";

if ($for) $page=$for;
	$editpage = $this->href("", $page."/edit");
if (!$page)
	{$editpage = $this->href("edit");}
if (!$text)
	$text = $this->GetTranslation("EditText");
	$output .= $this->HasAccess("write") ? "<a href=\"".$editpage."\" accesskey=\"E\" title=\"".$this->GetTranslation("EditTip")."\">".$text."</a>\n" : "";

	echo ($output);

?>