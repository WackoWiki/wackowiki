<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Outputs a list of the most visited pages.

Usage:
	{{mostpopular}}

Options:
	[max=50]
		maximum number of pages to retrieve
	[page="PageName"]
		page name to start from in the page hierarchy
	[title=1]
		shows the page title
	[nomark=1]
		makes it possible to hide frame around
	[counter=0|1]
		shows page hit counter
	[system=0|1]
		excludes system pages
	[lang="ru"]
		show pages only in specified language
EOD;

// set defaults
$anchor			??= 'mp';
$counter		??= 1;
$help			??= 0;
$lang			??= '';
$legend			??= '';
$max			??= null;
$nomark			??= 0;
$page			??= '';
$system			??= 1;
$title			??= 0;

if ($help)
{
	$tpl->help	= $this->help($info, 'mostpopular');
	return;
}

$tag				= $this->unwrap_link($page);
$prefix				= $this->prefix;

if (!$max)				$max = 25;
if ($max > 500)			$max = 500;

// check for first param (for what mostpopular is built)
if (!empty($page))
{
	$ppage		= '/' . $tag;
	if (!$legend)	$legend = $tag;
}
else
{
	$ppage		= '';
}

$system
	? $user_id		= $this->db->system_user_id
	: $user_id		= null;

$selector =
	'FROM ' . $prefix . 'page ' .
	'WHERE  comment_on_id = 0 ' .
	'AND deleted = 0 ' .
	($tag
		? 'AND tag LIKE ' . $this->db->q($tag . '/%') . ' '
		: '') .
	($user_id
		? 'AND owner_id <> ' . (int) $user_id . ' '
		: '') .
	($lang
		? 'AND page_lang = ' . $this->db->q($lang) . ' '
		: '');

$sql_count	=
	'SELECT COUNT(page_id) AS n ' .
	$selector;

$sql	=
	'SELECT page_id, tag, title, hits, page_lang ' .
	$selector .
	'ORDER BY hits DESC ';

// we're using a parameter token here to sort out multiple instances (must be unique and static)
$param_token	= substr(hash('sha1', $anchor . $page . $nomark . $lang . $max), 0, 8);

$count			= $this->db->load_single($sql_count, true);
$pagination		= $this->pagination($count['n'], $max, 'm', ['#' => $param_token]);
$pages			= $this->db->load_all($sql . $pagination['limit'], true);

$num			= $pagination['offset'] ;

if (!empty($pages))
{
	foreach ($pages as $page)
	{
		$page_ids[] = (int) $page['page_id'];

		$this->page_id_cache[$page['tag']] = $page['page_id'];
		$this->cache_page($page, true);
	}

	// cache acls
	$this->preload_acl($page_ids);

	if (!$nomark)
	{
		$tpl->mark			= true;

		if ($legend)
		{
			$tpl->mark_legend	= $this->link($ppage, '', $legend);
		}

		$tpl->emark			= true;
	}

	$tpl->pagination_text	= $pagination['text'];
	$tpl->token				= $param_token;

	foreach ($pages as $page)
	{
		if ($this->db->hide_locked && !$this->has_access('read', $page['page_id']))
		{
			continue;
		}

		$num++;

		if ($title == 1)
		{
			$_link = $this->link('/' . $page['tag'], '', $page['title'], '', false, true, false);
		}
		else
		{
			$_link = $this->link('/' . $page['tag'], '', $page['tag'], $page['title'], false, true, false);
		}

		$tpl->l_num		= $num;
		$tpl->l_link	= $_link;

		if ($counter)
		{
			$tpl->l_counter_hits	= $page['hits'];
		}
	}
}
