<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// show section edit link
// {{editsection [page="yourPage"] [text="your text"]}}

// set defaults
$page		??= '';
$section	??= 0;
$text		??= '';

if ($this->has_access('write'))
{
	$tag	= $page ? $this->unwrap_link($page) : $this->tag;
	$href	= $this->href('edit', $tag, ['section' => $section]);

	if (!$text)
	{
		$text = $this->_t('EditText');
	}

	$tpl->l_href	= $href;
	$tpl->l_title	= Ut::perc_replace($this->_t('EditSection'), $section);
	$tpl->l_text	= $text;
	$tpl->l_section	= $section;
}
