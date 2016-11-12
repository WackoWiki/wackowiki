<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$load_orphaned_pages = function ($tag, $limit, $deleted = 0)
{
	$pagination	= '';
	$pref		= $this->db->table_prefix;

	// count pages
	if ($count_pages = $this->db->load_all(
		"SELECT DISTINCT page_id ".
		"FROM " . $pref . "page p ".
			"LEFT JOIN " . $pref . "page_link l ON ".
			"((l.to_tag = p.tag ".
				"AND l.to_supertag = '') ".
				"OR l.to_supertag = p.supertag) ".
		"WHERE ".
			($tag
				? "p.tag LIKE '" . $this->db->q($tag . '/%') . " AND "
				: "").
			"l.to_page_id IS NULL ".
			($deleted != 1
				? "AND p.deleted <> '1' "
				: "").
			"AND p.comment_on_id = '0' "
		, true));

	if ($count_pages)
	{
		$count		= count($count_pages);
		$pagination = $this->pagination($count, $limit);

		$orphaned = $this->db->load_all(
			"SELECT DISTINCT page_id, tag, title ".
			"FROM " . $pref . "page p ".
				"LEFT JOIN " . $pref . "page_link l ON ".
				"((l.to_tag = p.tag ".
					"AND l.to_supertag = '') ".
					"OR l.to_supertag = p.supertag) ".
			"WHERE ".
				($tag
					? "p.tag LIKE " . $this->db->q($tag . '/%') . " AND "
					: "").
				"l.to_page_id IS NULL ".
				($deleted != 1
					? "AND p.deleted <> '1' "
					: "").
				"AND p.comment_on_id = '0' ".
			"ORDER BY tag ".
			$pagination['limit']);

		return [$orphaned, $pagination];
	}
};

if (!isset($root))
{
	$root = $this->page['tag'];
}
else
{
	$root = $this->unwrap_link($root);
}

if (!isset($max))		$max = null;

$user	= $this->get_user();

if (list ($pages, $pagination) = $load_orphaned_pages($root, $max))
{
	if (is_array($pages))
	{
		$this->print_pagination($pagination);

		echo "<ol>\n";

		//!!!! unoptimized
		if (is_array($pages))
		{
			foreach ($pages as $page)
			{
				if (!$this->db->hide_locked || $this->has_access('read', $page['page_id']))
				{
					// cache page_id for for has_access validation in link function
					$this->page_id_cache[$page['tag']] = $page['page_id'];

					echo '<li>' . $this->link('/' . $page['tag'], '', '', '', 0) . "</li>\n";
				}
			}
		}

		echo "</ol>\n";

		$this->print_pagination($pagination);
	}
}
else
{
	echo $this->show_message($this->_t('NoOrphaned'));
}
