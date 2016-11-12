<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// If User has rights to edit page, show Edit link
// {{edit [page="yourPage"] [text="your text"]}}

if (!isset($for))		$for = ''; // depreciated
if ($for)				$page = $for;

if (!isset($page))		$page = '';
if (!isset($output))	$output = '';
if (!isset($text))		$text = '';

$editpage = $this->href('', $page.'/edit');

if (!$page)
{
	$editpage = $this->href('edit');
}

if (!$text)
{
	$text = $this->_t('EditText');
}

$output .= $this->has_access('write') ? '<a href="' . $editpage . '" accesskey="E" title="' . $this->_t('EditTip') . '">' . $text . "</a>\n" : '';

echo $output;

?>