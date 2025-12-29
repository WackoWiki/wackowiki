<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Shows most commented pages.

Usage:
	{{mostcommented}}

Options:
	[max=50]
		maximum number of pages to retrieve
	[page="PageName"]
		page name to start from in the page hierarchy
	[title=1]
		shows the page title
	[nomark=1]
		makes it possible to hide frame around
	[lang="ru"]
		show pages only in specified language
EOD;

// set defaults
$help			??= 0;
$lang			??= '';
$legend			??= '';
$max			??= null;
$nomark			??= 0;
$page			??= '';
$title			??= 0;

if ($help)
{
	$tpl->help	= $this->help($info, 'mostcommented');
	return;
}

if (!$max)				$max = 25;
if ($max > 500)			$max = 500;

// check for first param (for what mostpopular is built)
if (!empty($page))
{
	$tag		= $this->unwrap_link($page);
	$ppage		= '/' . $tag;
	if (!$legend) $legend = $tag;
}
else
{
	$ppage		= '';
	$_page		= $this->page;
}

$tag = $this->unwrap_link($page);

$selector =
	'FROM ' . $this->prefix . 'page ' .
	'WHERE comments >= 1 ' .
		'AND comment_on_id = 0 ' .
		'AND deleted = 0 ' .
	($tag
		? 'AND tag LIKE ' . $this->db->q($tag . '/%') . ' '
		: '') .
	($lang
		? 'AND page_lang = ' . $this->db->q($lang) . ' '
		: '');

$sql_count	=
	'SELECT COUNT(page_id) AS n ' .
	$selector;

$sql	=
	'SELECT page_id, tag, title, comments, page_lang ' .
	$selector .
	'ORDER BY comments DESC ';

$count		= $this->db->load_single($sql_count, true);
$pagination	= $this->pagination($count['n'], $max, 'p', []);
$pages		= $this->db->load_all($sql . $pagination['limit'], true);

$num		= $pagination['offset'] ; // + 1

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
		$tpl->mark_legend	= $this->link($ppage, '', $legend);
		$tpl->emark			= true;
	}

	$tpl->pagination_text = $pagination['text'];

	foreach ($pages as $page)
	{
		if ($this->db->hide_locked)
		{
			$access = $this->has_access('read', $page['page_id']);
		}
		else
		{
			$access = true;
		}

		if ($access)
		{
			// print entry
			$num++;

			if ($title == 1)
			{
				$_link = $this->link('/' . $page['tag'], '', $page['title'], '', false, true, false);
			}
			else
			{
				$_link = $this->link('/' . $page['tag'], '', $page['tag'], $page['title'], false, true, false);
			}

			$tpl->l_num			= $num;
			$tpl->l_link		= $_link;
			$tpl->l_comments	= $page['comments'];
			$tpl->l_href		= $this->href('', $page['tag'], ['show_comments' => 1, '#' => 'header-comments']);
		}
	}
}
