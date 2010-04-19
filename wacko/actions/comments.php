<?php

//you can click comments inside from bookmarks or wikipages
//{{comments [page="CommentThisPage"] [text="your text"]}}

$for = "";
$page = "";
$output = "";
$text = "";

if ($for) $page=$for;
if (!$page) {$page = "";}
	$output .= $this->href("", $page, "show_comments=1#comments")."\">";
if (!$text)
	$output .= $this->GetTranslation("ShowComments");
else
	$output .= $text;

echo "<a href=\"".($output)."</a>\n";

?>