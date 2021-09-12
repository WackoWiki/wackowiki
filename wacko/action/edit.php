<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// If user has rights to edit page, show Edit link
// {{edit [page="yourPage"] [text="your text"]}}

// set defaults
$page	??= '';
$text	??= '';

$tag	= $page ? $this->unwrap_link($page) : $this->tag;

$href	= $this->href('edit', $tag);

if (!$text)
{
	$text = $this->_t('EditText');
}

if ($this->has_access('write'))
{
	$tpl->l_href	= $href;
	$tpl->l_text	= $text;
}
