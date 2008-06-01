<a href="<?php
//you can click comments inside from bookmarks or wikipages
//{{comments [page="CommentThisPage"] [text="your text"]}}
if ($for) $page=$for; 
if (!$page) {$page = "";}
$output .= $this->href("", $page, "show_comments=1#comments")."\">";
 if (!$text)
 $output .= $this->GetResourceValue("ShowComments"); 
 else
 $output .= $text; 
echo ($output);
?></a>