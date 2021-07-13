<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// enables you to click comments inside from wikipages
//{{comment [page="CommentThisPage"] [text="your text"]}}

$page	??= '';
$text	??= '';

if (!$page) {$page = '';}

$tpl->href	= $this->href('', $page, ['show_comments' => 1, '#' => 'header-comments']);

if (!$text)
{
	$tpl->text	= $this->_t('ShowComments');
}
else
{
	$tpl->text	= $text;
}
