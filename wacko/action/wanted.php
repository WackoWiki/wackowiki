<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!function_exists('load_wanted'))
{
	function load_wanted(&$wacko, $for = '', $limit = 50, $deleted = 0)
	{
		$limit		= (int) $limit;
		$pagination	= '';
		$pref		= $wacko->config['table_prefix'];

		// count pages
		if ($count_pages = $wacko->load_all(
				"SELECT DISTINCT l.to_tag AS wanted_tag ".
				"FROM ".$pref."link l ".
					"LEFT JOIN ".$pref."page p ON ".
					"((l.to_tag = p.tag ".
						"AND l.to_supertag = '') ".
						"OR l.to_supertag = p.supertag) ".
				"WHERE ".
					($for
						? "l.to_tag LIKE '".quote($this->dblink, $for)."/%' AND "
						: "").
					"p.tag is NULL GROUP BY wanted_tag "
			, true));

		if ($count_pages)
		{
			$count		= count($count_pages);
			$pagination = $wacko->pagination($count, $limit);

			$wanted = $wacko->load_all(
					"SELECT DISTINCT l.to_tag AS wanted_tag ".
					"FROM ".$pref."link l ".
						"LEFT JOIN ".$pref."page p ON ".
						"((l.to_tag = p.tag ".
							"AND l.to_supertag = '') ".
							"OR l.to_supertag = p.supertag) ".
					"WHERE ".
						($for
							? "l.to_tag LIKE '".quote($this->dblink, $for)."/%' AND "
							: "").
						"p.tag is NULL GROUP BY wanted_tag ".
					"ORDER BY wanted_tag ASC ".
					"LIMIT {$pagination['offset']}, {$limit}");

			return array($wanted, $pagination);
		}

	}
}

if (!isset($root)) $root = $this->unwrap_link($vars[0]);

if (!isset($root))
{
	$root = $this->page['tag'];
}
else
{
	$root = $this->unwrap_link($root);
}

if ($linking_to = (isset($_GET['linking_to']) ? $_GET['linking_to'] : ''))
{
	if ($pages = $this->load_pages_linking_to($linking_to, $root))
	{
		echo $this->get_translation('PagesLinkingTo')." ".$this->link($linking_to).":<br />\n";
		echo "<ul>\n";

		foreach ($pages as $page)
		{
			if (!$this->config['hide_locked'] || $this->has_access('read', $page['page_id']))
			{
				echo "<li>".$this->link('/'.$page['tag'], '', '/'.$page['tag'])."</li>\n";
			}
		}

		echo "</ul>\n";
	}
	else
	{
		echo "<em>".$this->get_translation('NoPageLinkingTo')." ".$this->link($linking_to).".</em>";
	}
}
else
{
	$for	= $root;

	if (!isset($max))		$max = null;

	$user	= $this->get_user();
	$max	= $this->get_list_count($max);

	if (list ($pages, $pagination) = load_wanted($this, $root, (int)$max))
	{
		if (is_array($pages))
		{
			// pagination
			if (isset($pagination['text']))
			{
				echo '<span class="pagination">'.$pagination['text']."</span><br />\n";
			}

			echo "<ol>\n";

			foreach($pages as $page)
			{
				$page_parent = substr($page['wanted_tag'], 0, strrpos($page['wanted_tag'], '/'));

				if(!$this->config['hide_locked'] || $this->has_access('read', $page_parent))
				{
					// update the referrer count for the WantedPage, we need to take pages the user is not allowed to view out of the total
					$count = 0;

					if($referring_pages = $this->load_pages_linking_to($page['wanted_tag'], $root))
					{
						foreach ($referring_pages as $referrer_page)
						{
							if(!$this->config['hide_locked'] || $this->has_access('read', $referrer_page['tag']))
							{
								$count++;
							}
						}
					}

					// If no pages are referring to the WantedPage it means the referrers are all locked so don't show the link at all
					if($count > 0)
					{
						echo '<li>'.$this->link('/'.$page['wanted_tag']).' (<a href="'.$this->href('', '', 'linking_to='.$page['wanted_tag']).'">'.$count."</a>)</li>\n";
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
		echo $this->get_translation('NoWantedPages');
	}
}

?>