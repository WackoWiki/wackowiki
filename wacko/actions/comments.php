<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// enables you to click comments inside from wikipages
//{{comments [page="CommentThisPage"] [text="your text"]}}

if (!isset($for)) $for = '';
if (!isset($page)) $page = '';
if (!isset($output)) $output = '';
if (!isset($text)) $text = '';

if ($for) $page=$for;
if (!$page) {$page = '';}
	$output .= $this->href('', $page, 'show_comments=1#comments')."\">";
if (!$text)
	$output .= $this->get_translation('ShowComments');
else
	$output .= $text;

echo "<a href=\"".($output)."</a>\n";

?>