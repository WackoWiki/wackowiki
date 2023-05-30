<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Displays a section edit link.

Usage:
	{{editsection}}

Options:
	[page="yourPage"]
	[section=Number]
	[text="your text"]
EOD;

// set defaults
$help		??= 0;
$page		??= '/' . $this->context[$this->current_context];
$section	??= 0;
$text		??= '';

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info, 'action' => 'editsection']);
	return;
}

// ignore static feeds
if ($this->static_feed)
{
	return;
}

if (   ($this->has_access('write') && !isset($this->comment_id))
	|| $this->is_admin()
	|| (isset($this->comment_id) && $this->is_owner($this->comment_id)))
{
	$section	= (int) $section;
	$tag		= $page ? $this->unwrap_link($page) : $this->tag;
	$href		= $this->href('edit', $tag, ['section' => $section]);

	if (!$text)
	{
		$text = $this->_t('EditText');
	}

	$tpl->l_href	= $href;
	$tpl->l_title	= Ut::perc_replace($this->_t('EditSection'), $section);
	$tpl->l_text	= $text;
}
