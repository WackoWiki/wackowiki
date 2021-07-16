<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// enables you to click comments inside from wikipages
// {{comment [page="CommentThisPage"] [text="your text"]}}

// set defaults
$page	??= '';
$text	??= '';

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
