<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// shows tree list
// {{tree [page="tag"] [depth=3] [nomark=0] [legend=""]}}
// use [page="/"] to get the entire root

// constants
$limit	= 500;

// input
if (!isset($root) && !isset($page))
					$root	= '/' . $this->page['tag'];
if (!isset($page)) $page = '';
if (!isset($title)) $title = 1;
if ($page)			$root	= $page;
if ($root == '/')	$root	= '';
if ($root)			$root	= $this->unwrap_link($root);

$_root		= $root; // without slash -> LIKE /%
$root		= $root.'/';

if (!isset($depth)) $depth = '';
// TODO: set default depth level via config
// TODO: show missing sublevels
if (!$depth || $depth < 1)
{
	$depth	= 1;
}
else
{
	$depth	= (int) $depth;
}

if (!isset($nomark)) $nomark = '';
if (!isset($legend)) $legend = '';

// collect pages
if ($pages = $this->db->load_all(
	"SELECT page_id, tag, supertag, title ".
	"FROM {$this->db->table_prefix}page ".
	"WHERE comment_on_id = '0' ".
		"AND tag LIKE " . $this->db->q($_root . '/%') . " ".
		"AND deleted <> '1' ".
	"ORDER BY tag", true))
{
	// pick all subpages up to the desired depth level
	if ($depth > 0)
	{
		$max_level = substr_count($root, '/') + $depth;
		reset($pages);
		$_pages = '';

		do
		{
			$k = key($pages);

			if (substr_count($pages[$k]['tag'], '/') < $max_level)
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
			"SELECT {$this->page_meta} ".
			"FROM {$this->db->table_prefix}page ".
			"WHERE page_id IN ('" . implode("', '", $page_ids) . "')", true))
		{
			foreach ($links as $link)
			{
				$this->cache_page($link, 0, 1);

				// cache page_id for for has_access validation in link function
				$this->page_id_cache[$link['tag']] = $link['page_id'];
			}
		}

		// cache acls
		if ($acls = $this->db->load_all(
			"SELECT page_id, privilege, list ".
			"FROM {$this->db->table_prefix}acl ".
			"WHERE page_id IN ( '" . implode("', '", $page_ids) . "' ) ".
				"AND privilege = 'read'", true))
		{
			foreach ($acls as $acl)
			{
				$this->cache_acl($acl['page_id'], 'read', 1, $acl);
			}
		}

		// header
		if ($root)
		{
			if (!$nomark)
			{
				if ($legend)
				{
					$legend = $this->format($legend);
				}
				else
				{
					$legend = $this->_t('TreeClusterTitle');
					$legend = Ut::perc_replace($legend, $this->link('/' . $root, '', rtrim($root, '/'))).':';
				}

				echo '<nav class="layout-box"><p class="layout-box"><span>' . $legend."</span></p>\n";
			}
		}
		else
		{
			if (!$nomark)
			{
				echo '<nav class="layout-box"><p class="layout-box"><span>' . $this->_t('TreeSiteTitle') . "</span></p>\n";
			}
		}

		// tree
		if (count($pages) > $limit)
		{
			echo '<em>' . $this->_t('TreeTooBig') . '</em><br/>';
		}
		else
		{
			// cluster root level
			$root_level = substr_count($root, '/');

			// begin list
			echo '<ul class="tree">' . "\n";

			$i	= 0;
			$ul	= 0;

			# Ut::debug_print_r($pages);

			foreach ($pages as $page)
			{
				// check read privilege and current page tag
				if ($page['tag'] == $root
					|| ($this->db->hide_locked && !$this->has_access('read', $page['page_id'])))
				{
					continue;
				}

				// check page level
				$cur_level	= substr_count($page['tag'], '/');
				if (!isset($prev_level)) $prev_level	= 0;

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

				if ($title == 0) $page['title'] = null;

				if ($this->tag == $page['tag'])
				{
					// do not link the page to itself
					echo isset($page['title']) ? $page['title'] : $page['tag'];
					#echo $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1, '', 0);
				}
				else
				{
					echo $this->link('/' . $page['tag'], '', $page['title'], '', 0, 1, '', 0);
				}

				# if ($cur_level == $root_level && $cur_level < 2)	echo '</strong>';

				// recheck page level
				$prev_level	= substr_count($page['tag'], '/');

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
		$title_empty_tree = $this->_t('TreeEmptyLevels');
		$title_empty_tree = Ut::perc_replace($title_empty_tree, $this->link('/' . $root, '', rtrim($root, '/')));
		echo '<em>' . $title_empty_tree.'</em><br/>';
	}
}
else
{
	if (!$nomark)
	{
		$title_empty_tree = $this->_t('TreeEmpty');
		$title_empty_tree = Ut::perc_replace($title_empty_tree, $this->link('/' . $root, '', rtrim($root, '/')));
		echo '<em>' . $title_empty_tree.'</em><br/>';
	}
}

?>
