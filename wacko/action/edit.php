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

$href = $this->href('edit', $page);

if (!$page)
{
	$href = $this->href('edit');
}

if (!$text)
{
	$text = $this->_t('EditText');
}

if ($this->has_access('write'))
{
	$tpl->l_href	= $href;
	$tpl->l_text	= $text;
}
