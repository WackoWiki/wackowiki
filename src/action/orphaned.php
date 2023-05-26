<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Outputs a list of lost pages (those pages that do not have any links to them) for some cluster.

	By default it is equal to the current page. To display it for all namespaces, use root page="/".

Usage:
	{{orphaned}}

Options:
	[page="Cluster"]
	[max=Number]
EOD;

$load_orphaned_pages = function ($tag, $limit, $deleted = false)
{
	$pagination	= [];
	$pref		= $this->prefix;

	$selector =
		'FROM ' . $pref . 'page p ' .
			'LEFT JOIN ' . $pref . 'page_link l ON ' .
			'(l.to_tag = p.tag) ' .
		'WHERE ' .
			($tag
				? 'p.tag LIKE ' . $this->db->q($tag . '/%') . ' AND '
				: '') .
			'l.to_page_id IS NULL ' .
			($deleted
				? ''
				: 'AND p.deleted <> 1 ') .
			'AND p.comment_on_id = 0 ';

	// count pages
	if ($count = $this->db->load_single(
		'SELECT DISTINCT COUNT(page_id) AS n ' .
		$selector
		, true))
	{
		$pagination = $this->pagination($count['n'], $limit);

		$orphaned = $this->db->load_all(
			'SELECT DISTINCT page_id, owner_id, tag, title ' .
			$selector .
			'ORDER BY tag COLLATE utf8mb4_unicode_520_ci ' .
			$pagination['limit']);

		return [$orphaned, $pagination];
	}
};

// set defaults
$help	??= 0;
$max	??= null;
$page	??= '';

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info, 'action' => 'orphaned']);
	return;
}

$tag	= $page ? $this->unwrap_link($page) : $this->tag;

$user	= $this->get_user();

if ([$pages, $pagination] = $load_orphaned_pages($tag, $max))
{
	if (is_array($pages))
	{
		$page_ids = [];

		foreach ($pages as $page)
		{
			$page_ids[] = (int) $page['page_id'];

			$this->page_id_cache[$page['tag']] = $page['page_id'];
			$this->cache_page($page, true);
		}

		// cache acls
		$this->preload_acl($page_ids);

		$tpl->pagination_text	= $pagination['text'];
		$tpl->offset			= ($pagination['offset'] + 1);

		foreach ($pages as $page)
		{
			if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
			{
				$tpl->l_link = $this->link('/' . $page['tag'], '', '', '', false);
			}
		}
	}
}
else
{
	$tpl->none = true;
}
