<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Creates a link to the edit handler, if the user has the right to edit the given page.

Usage:
	{{edit}}

Options:
	[page="PageName"]
	[text="your text"]
EOD;

// set defaults
$help	??= 0;
$page	??= '';
$text	??= '';

if ($help)
{
	$tpl->help	= $this->help($info, 'edit');
	return;
}

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
