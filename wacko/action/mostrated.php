<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// set defaults
$nomark		??= 0;
$top		??= 5;
$bottom		??= 5;

if ($top > 20)			$top	= 20;
if ($bottom > 20)		$bottom	= 20;

// min votes to be included in the list
$min = 3;

// max positive rating
if (isset($top))
{
	$pages = $this->db->load_all(
		"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.page_lang, MAX(r.value) AS rate, " .
			"r.voters AS votes, (r.value / r.voters) AS ratio " .
		"FROM " . $this->db->table_prefix . "page AS p, " . $this->db->table_prefix . "rating AS r " .
		"WHERE p.deleted <> 1 " .
			"AND p.page_id = r.page_id " .
			"AND r.voters >= " . (int) $min . " " .
			"AND r.value > 0 " .
		"GROUP BY p.tag " .
		"ORDER BY ratio DESC, votes DESC " .
		"LIMIT " . (int) $top, true);

	$tpl->enter('top_');

	if (!$nomark)
	{
		$tpl->mark			= true;
		$tpl->emark			= true;
	}

	if ($pages)
	{
		foreach ($pages as $page)
		{
			$page_ids[] = (int) $page['page_id'];

			$this->page_id_cache[$page['tag']] = $page['page_id'];
			$this->cache_page($page, true);
		}

		// cache acls
		$this->preload_acl($page_ids);

		foreach ($pages as $page)
		{
			if ($this->db->hide_locked && !$this->has_access('read', $page['page_id']))
			{
				continue;
			}

			$tpl->n_l_num		= $num;
			$tpl->n_l_link		= $this->compose_link_to_page($page['tag'], '', $page['title']);
			$tpl->n_l_rating	= round($page['rate'] / $page['votes'], 2);
		}
	}
	else
	{
		$tpl->none = true;
	}

	$tpl->leave(); // top_
}

// max negative rating
if (isset($bottom))
{
	$pages = $this->db->load_all(
		"SELECT p.page_id, p.owner_id, p.user_id, p.tag, p.title, p.page_lang, MAX(r.value) AS rate, " .
			"r.voters AS votes, (r.value / r.voters) AS ratio " .
		"FROM " . $this->db->table_prefix . "page AS p, " . $this->db->table_prefix . "rating AS r " .
		"WHERE p.deleted <> 1 " .
			"AND p.page_id = r.page_id " .
			"AND r.voters >= " . (int) $min . " " .
			"AND r.value < 0 " .
		"GROUP BY p.tag " .
		"ORDER BY ratio DESC, votes DESC " .
		"LIMIT " . (int) $bottom, true);

	$tpl->enter('bottom_');

	if (!$nomark)
	{
		$tpl->mark			= true;
		$tpl->emark			= true;
	}

	if ($pages)
	{
		foreach ($pages as $page)
		{
			$page_ids[] = (int) $page['page_id'];

			$this->page_id_cache[$page['tag']] = $page['page_id'];
			$this->cache_page($page, true);
		}

		// cache acls
		$this->preload_acl($page_ids);

		foreach ($pages as $page)
		{
			if ($this->db->hide_locked && !$this->has_access('read', $page['page_id']))
			{
				continue;
			}

			$tpl->n_l_link		= $this->compose_link_to_page($page['tag'], '', $page['title']);
			$tpl->n_l_rating	= round($page['rate'] / $page['votes'], 2);
		}
	}
	else
	{
		$tpl->none = true;
	}

	$tpl->leave(); // bottom_
}
