<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// enables you to click comments inside from wikipages
//{{comment [page="CommentThisPage"] [text="your text"]}}

if (!isset($for))		$for	= ''; // depreciated
if ($for)				$page = $for;

if (!isset($page))		$page	= '';
if (!isset($output))	$output	= '';
if (!isset($text))		$text	= '';

if (!$page) {$page = '';}
{
	$output .= $this->href('', $page, ['show_comments' => 1, '#' => 'header-comments']) . '">';
}

if (!$text)
{
	$output .= $this->_t('ShowComments');
}
else
{
	$output .= $text;
}

echo '<a href="' . ($output) . "</a>\n";

?>