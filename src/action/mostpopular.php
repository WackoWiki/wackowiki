<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
 Most Popular Pages Action

 All arguments are optional, the "dontrecurse" argument is only used when the "page" argument is used and even then it's still optional

 {{mostpopular
	[max=50]					// maximum number of pages to retrieve
	[page="PageName"]			// page name to start from in the page hierarchy
	[title=1]					// shows the page title
	[nomark=1]					// makes it possible to hide frame around
	[dontrecurse="true|false"]	// if set to true the list will only include pages that are direct children of the "page" cluster
	[counter=0|1]				// shows page hit counter
	[system=0|1]				// excludes system pages
	[lang="ru"]					// show pages only in specified language
 }}
 */

if (!isset($system))		$system = 1;
if (!isset($page))			$page = '';
if (!isset($nomark))		$nomark = 0;
if (!isset($lang))			$lang = '';
if (!isset($max))			$max = null;
if (!isset($legend))		$legend = '';
if (!isset($title))			$title = 0;
if (!isset($dontrecurse))	$dontrecurse = false;
if (!isset($counter))		$counter = 1;

$prefix			= $this->db->table_prefix;

if (!$max)				$max = 25;
if ($max > 500)			$max = 500;

// check for first param (for what mostpopular is built)
if (!empty($page))
{
	$tag		= $this->unwrap_link($page);
	$ppage		= '/' . $tag;
	if (!$legend)	$legend = $tag;
}
else
{
	$page		= '';
	$ppage		= '';
}

$system
	? $user_id		= $this->db->system_user_id
	: $user_id		= null;

if (!$page)
{
	$selector =
		"FROM " . $prefix . "page " .
		"WHERE  comment_on_id = 0 " .
		"AND deleted = 0 " .
		($user_id
			? "AND owner_id <> " . (int) $user_id . " "
			: "") .
		($lang
			? "AND page_lang = " . $this->db->q($lang) . " "
			: "");

	$sql_count	=
		"SELECT COUNT(page_id) AS n " .
		$selector;

	$sql	=
		"SELECT page_id, tag, title, hits, page_lang " .
		$selector .
		"ORDER BY hits DESC ";
}
else
{
	$tag = $this->unwrap_link($page);

	// $recurse
	//	true	- recurses and includes all the sub pages of sub pages (and so on) in the listing
	//	false	- display only pages directly under the selected page, not their kids and grandkids
	(!$dontrecurse || $dontrecurse == 'false')
		? $recurse = true
		: $recurse = false;

	$selector =
		"FROM " . $prefix . "page a, " . $prefix . "page_link l " .
			"INNER JOIN " . $prefix . "page b ON (l.from_page_id = b.page_id) " .
			"INNER JOIN " . $prefix . "page c ON (l.to_page_id = c.page_id) " .
		"WHERE a.comment_on_id = 0 " .
			"AND a.deleted = 0 " .
			"AND a.tag <> " . $this->db->q($tag) . " " .
			"AND a.tag = c.tag " .
			($recurse
				? "AND INSTR(b.tag, " . $this->db->q($tag) . ") = 1 "
				: "AND b.tag = " . $this->db->q($tag) . " ") .
			"AND INSTR(c.tag, " . $this->db->q($tag) . ") = 1 " .
			($user_id
				? "AND a.owner_id <> " . (int) $user_id . " "
				: "") .
			($lang
				? "AND a.page_lang = " . $this->db->q($lang) . " "
				: "");

	$sql_count	=
		"SELECT COUNT(DISTINCT a.page_id) AS n " .
		$selector;

	$sql	=
		"SELECT DISTINCT a.page_id, a.owner_id, a.user_id, a.tag, a.title, a.hits, a.page_lang " .
		$selector .
		"ORDER BY a.hits DESC ";
}

$count		= $this->db->load_single($sql_count, true);
$pagination	= $this->pagination($count['n'], $max, 'm', []);
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
		if ($this->db->hide_locked && !$this->has_access('read', $page['page_id']))
		{
			continue;
		}

		$num++;

		if ($title == 1)
		{
			$_link = $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1, 0);
		}
		else
		{
			$_link = $this->link('/' . $page['tag'], '', $page['tag'], $page['title'], 0, 1, 0);
		}

		$tpl->l_num		= $num;
		$tpl->l_link	= $_link;

		if ($counter)
		{
			$tpl->l_counter_hits	= $page['hits'];
		}
	}
}
