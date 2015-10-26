<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!function_exists('load_orphaned_pages'))
{
	function load_orphaned_pages(&$engine, $for = '', $limit = 50, $deleted = 0)
	{
		$limit		= (int) $limit;
		$pagination	= '';
		$pref		= $engine->config['table_prefix'];

		// count pages
		if ($count_pages = $engine->load_all(
			"SELECT DISTINCT page_id ".
			"FROM ".$pref."page p ".
				"LEFT JOIN ".$pref."link l ON ".
				"((l.to_tag = p.tag ".
					"AND l.to_supertag = '') ".
					"OR l.to_supertag = p.supertag) ".
			"WHERE ".
				($for
					? "p.tag LIKE '".quote($engine->dblink, $for)."/%' AND "
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
			$pagination = $engine->pagination($count, $limit);

			$orphaned = $engine->load_all(
				"SELECT DISTINCT page_id, tag, title ".
				"FROM ".$pref."page p ".
					"LEFT JOIN ".$pref."link l ON ".
					"((l.to_tag = p.tag ".
						"AND l.to_supertag = '') ".
						"OR l.to_supertag = p.supertag) ".
				"WHERE ".
					($for
						? "p.tag LIKE '".quote($engine->dblink, $for)."/%' AND "
						: "").
					"l.to_page_id IS NULL ".
					($deleted != 1
						? "AND p.deleted <> '1' "
						: "").
					"AND p.comment_on_id = '0' ".
				"ORDER BY tag ".
				"LIMIT {$pagination['offset']}, {$limit}");

			return array($orphaned, $pagination);
		}
	}
}

if (!isset($root))
{
	$root = $this->page['tag'];
}
else
{
	$root = $this->unwrap_link($root);
}

if ($user = $this->get_user())
{
	$usermax = $user['list_count'];

	if ($usermax == 0)
	{
		$usermax = 10;
	}
}
else
{
	$usermax = 50;
}

if (!isset($max) || $usermax < $max)
{
	$max = $usermax;
}

if ($max > 100)
{
	$max	= 100;
}

if (list ($pages, $pagination) = load_orphaned_pages($this, $root, (int)$max))
{
	if (is_array($pages))
	{
		// pagination
		if (isset($pagination['text']))
		{
			echo '<span class="pagination">'.$pagination['text']."</span><br />\n";
		}

		echo "<ol>\n";

		//!!!! unoptimized
		if (is_array($pages))
		{
			foreach ($pages as $page)
			{
				if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id']))
				{
					// cache page_id for for has_access validation in link function
					$this->page_id_cache[$page['tag']] = $page['page_id'];

					echo '<li>'.$this->link('/'.$page['tag'], '', '', '', 0)."</li>\n";
				}
			}
		}

		echo "</ol>\n";

		// pagination
		if (isset($pagination['text']))
		{
			echo '<br /><span class="pagination">'.$pagination['text']."</span>\n";
		}
	}
}
else
{
	echo $this->get_translation('NoOrphaned');
}

?>