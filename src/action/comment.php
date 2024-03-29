<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Sets a link to the comments of a page.

Usage:
	{{comment}}

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
	$tpl->help	= $this->help($info, 'comment');
	return;
}

$tag	= $page ? $this->unwrap_link($page) : $this->tag;

$tpl->href	= $this->href('', $tag, ['show_comments' => 1, '#' => 'header-comments']);

if (!$text)
{
	$tpl->text	= $this->_t('ShowComments');
}
else
{
	$tpl->text	= $text;
}
