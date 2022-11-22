<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
 shows tree list

 {{tree
	[page="tag"]
	[depth=3]
	[title=1]
	[nomark=0]
	[legend=""]
	[sort="asc|desc"]
	[system=0|1]		// excludes system pages
	[lang="ru"]			// show pages only in specified language
 }}

 use [page="/"] to get the entire root

 */

// constants
$limit	= 500;

// set defaults
$depth		??= '';
$lang		??= '';
$legend		??= '';
$nomark		??= 0;
$page		??= '/' . $this->page['tag'];
$sort		??= '';
$system		??= 0;
$title		??= 1;

$system
	? $user_id		= $this->db->system_user_id
	: $user_id		= null;

if ($lang && !$this->known_language($lang))
{
	$lang = '';
	#$this->set_message($this->_t('FilterLangNotAvailable'));
}

if ($page == '/')		$page	= '';
$tag	= $this->unwrap_link($page);
$root	= $tag . '/';

// TODO: set default depth level via config
// TODO: show missing sublevels
// TODO: add paging
if (!$depth || $depth < 1)
{
	$depth	= 1;
}
else
{
	$depth	= (int) $depth;
}

// collect pages
if ($pages = $this->db->load_all(
	"SELECT page_id, tag, title, page_lang " .
	"FROM " . $this->prefix . "page " .
	"WHERE comment_on_id = 0 " .
		($tag
			? "AND tag LIKE " . $this->db->q($tag . '/%') . " "
			: "") .
		($user_id
			? "AND owner_id <> " . (int) $user_id . " "
			: "") .
		($lang
			? "AND page_lang = " . $this->db->q($lang) . " "
			: "") .
		"AND deleted <> 1 " .
	"ORDER BY tag COLLATE utf8mb4_unicode_520_ci " .
		($sort == 'desc'
			? "DESC"
			: ""), true))
{
	// pick all subpages up to the desired depth level
	if ($depth > 0)
	{
		$max_level = mb_substr_count($root, '/') + $depth;
		reset($pages);
		$_pages = [];

		do
		{
			$k = key($pages);

			if (mb_substr_count($pages[$k]['tag'], '/') < $max_level)
			{
				$_pages[]	= $pages[$k];
				$page_ids[]	= $pages[$k]['page_id'];
			}
		}

		while (false !== next($pages));

		$pages = $_pages;
		unset($_pages);
	}

	// check results for given $depth
	if (!empty($pages))
	{
		// cache links
		if ($links = $this->db->load_all(
			"SELECT {$this->page_meta} " .
			"FROM " . $this->prefix . "page " .
			"WHERE page_id IN (" . $this->ids_string($page_ids) . ")", true))
		{
			foreach ($links as $link)
			{
				$this->page_id_cache[$link['tag']] = $link['page_id'];
				$this->cache_page($link, true);
			}
		}

		// cache acls
		$this->preload_acl($page_ids);

		// header
		if (!$nomark)
		{
			if ($tag)
			{
				if ($legend)
				{
					$legend = $this->format($legend);
				}
				else
				{
					$legend = Ut::perc_replace($this->_t('TreeClusterTitle'), $this->link('/' . $root, '', $tag)) . ':';
				}
			}
			else
			{
				$legend =  $this->_t('TreeSiteTitle');
			}

			echo '<nav class="layout-box"><p><span>' . $legend . "</span></p>\n";
		}

		// tree
		if (count($pages) > $limit)
		{
			echo '<em>' . $this->_t('TreeTooBig') . '</em><br>';
		}
		else
		{
			// cluster root level
			$root_level = mb_substr_count($root, '/');

			// begin list
			echo '<ul class="tree">' . "\n";

			$i	= 0;
			$ul	= 0;

			# Ut::debug_print_r($pages);

			foreach ($pages as $page)
			{
				// check read privilege and current page tag
				if ($page['tag'] == $tag
					|| ($this->db->hide_locked && !$this->has_access('read', $page['page_id'])))
				{
					continue;
				}

				// check page level
				$cur_level	= mb_substr_count($page['tag'], '/');
				$prev_level	??= 0;

				// indents (sublevels)
				if ($i > 0)
				{
					// levels difference
					$diff = $cur_level - $prev_level;

					if ($diff > 0)
					{
						while ($diff > 0)
						{
							echo "\n<ul>\n";	// open nested list
							$diff--;
							$ul++;
						}
					}
					else if ($diff < 0)
					{
						while ($diff < 0)
						{
							echo "\n</ul>\n</li>\n";	// close nested list
							$diff++;
							$ul--;
						}
					}
					else
					{
						echo "</li>\n";
					}
				}

				// begin element
				echo '<li>';

				# if ($cur_level == $root_level && $cur_level < 2)	echo '<strong>';

				// displaying only the last word of tag OR title
				$link_text = ($title == 0)
					? mb_substr($page['tag'], mb_strrpos($page['tag'], '/') + 1)
					: $page['title'];

				if ($this->tag == $page['tag'])
				{
					// do not link the page to itself
					echo $page['title'] ?? $page['tag'];
				}
				else
				{
					echo $this->link('/' . $page['tag'], '', $link_text, '', 0, 1, 0);
				}

				# if ($cur_level == $root_level && $cur_level < 2)	echo '</strong>';

				// recheck page level
				$prev_level	= mb_substr_count($page['tag'], '/');

				$i++;
			}

			// close all opened <ul> tags
			if ($ul > 0)
			{
				while ($ul > 0)
				{
					echo "</ul>\n</li>\n";
					$ul--;
				}
			}
			else
			{
				echo "</li>\n";
			}

			// end list
			echo "</ul>\n";
		}

		// footer
		if (!$nomark)
		{
			echo "</nav>\n";
		}
	}
	else
	{
		// no results in given level $depth
		$empty_tree = Ut::perc_replace($this->_t('TreeEmptyLevels'), $this->link('/' . $root, '', $tag));
		echo '<em>' . $empty_tree . '</em><br>';
	}
}
else
{
	if (!$nomark)
	{
		$empty_tree = Ut::perc_replace($this->_t('TreeEmpty'), $this->link('/' . $root, '', $tag));
		echo '<em>' . $empty_tree . '</em><br>';
	}
}

