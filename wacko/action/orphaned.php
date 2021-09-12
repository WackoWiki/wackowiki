<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$load_orphaned_pages = function ($tag, $limit, $deleted = 0)
{
	$pagination	= [];
	$pref		= $this->db->table_prefix;

	$selector =
		"FROM " . $pref . "page p " .
			"LEFT JOIN " . $pref . "page_link l ON " .
			"(l.to_tag = p.tag) " .
		"WHERE " .
			($tag
				? "p.tag LIKE " . $this->db->q($tag . '/%') . " AND "
				: "") .
			"l.to_page_id IS NULL " .
			($deleted != 1
				? "AND p.deleted <> 1 "
				: "") .
			"AND p.comment_on_id = 0 ";

	// count pages
	if ($count = $this->db->load_single(
		"SELECT DISTINCT COUNT(page_id) AS n " .
		$selector
		, true));

	if ($count)
	{
		$pagination = $this->pagination($count['n'], $limit);

		$orphaned = $this->db->load_all(
			"SELECT DISTINCT page_id, owner_id, tag, title " .
			$selector .
			"ORDER BY tag " .
			$pagination['limit']);

		return [$orphaned, $pagination];
	}
};

// set defaults
$max	??= null;
$page	??= '';

$tag	= $page ? $this->unwrap_link($page) : $this->tag;

$user	= $this->get_user();

if ([$pages, $pagination] = $load_orphaned_pages($tag, $max))
{
	if (is_array($pages))
	{
		$page_ids = [];

		foreach ($pages as $page)
		{
			$this->cache_page($page, true);
			$page_ids[] = (int) $page['page_id'];
			// cache page_id for for has_access validation in link function
			$this->page_id_cache[$page['tag']] = $page['page_id'];
		}

		// cache acls
		$this->preload_acl($page_ids);

		$tpl->pagination_text	= $pagination['text'];
		$tpl->offset			= ($pagination['offset'] + 1);

		foreach ($pages as $page)
		{
			if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
			{
				$tpl->l_link = $this->link('/' . $page['tag'], '', '', '', 0);
			}
		}
	}
}
else
{
	$tpl->none = true;
}
