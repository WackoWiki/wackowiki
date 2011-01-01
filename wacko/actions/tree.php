<?php

// shows tree list
// {{tree [page="tag"] [depth="3"] [nomark="0"] [legend=""]}}
// use [page="/"] to get the entire root

// constants
$limit	= 500;
$style	= 'ul';

// input
if (!isset($root) && !isset($page))
					$root	= '/'.$this->page['tag'];
if (!isset($page)) $page = '';
if ($page)			$root	= $page;
if ($root == '/')	$root	= '';
if ($root)			$root	= $this->unwrap_link($root).'/';

if (!isset($depth)) $depth = '';
if (!$depth || $depth < 1)
{
	$depth	= 1;
}
else
{
	$depth	= (int)$depth;;
}

if (!isset($nomark)) $nomark = '';
if (!isset($legend)) $legend = '';

// collect pages
if ($pages = $this->load_all(
	"SELECT page_id, tag, supertag, title ".
	"FROM {$this->config['table_prefix']}page ".
	"WHERE comment_on_id = '0' ".
		"AND tag LIKE '".quote($this->dblink, $root)."%' ".
	"ORDER BY tag", 1))
{
	// pick all subpages up to the desired depth level
	if ($depth > 0)
	{
		$maxlevel = substr_count($root, '/') + $depth;
		reset($pages);
		$_pages = '';

		do
		{
			$k = key($pages);

			if (substr_count($pages[$k]['tag'], '/') < $maxlevel)
			{
				$_pages[]	= $pages[$k];
				$acl_str[]	= $pages[$k]['page_id'];
				$sup_str[]	= $pages[$k]['supertag'];
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
		if ($links = $this->load_all(
		"SELECT {$this->pages_meta} ".
		"FROM {$this->config['table_prefix']}page ".
		"WHERE supertag IN ( '".implode("', '", $sup_str)."' )", 1))
		{
			for ($i = 0; $i < count($links); $i++)
			{
				$this->cache_page($links[$i], 0, 1);
			}
		}

		// cache acls
		if ($acls = $this->load_all(
		"SELECT * FROM {$this->config['table_prefix']}acl ".
		"WHERE page_id IN ( '".implode("', '", $acl_str)."' ) AND privilege = 'read'", 1))
		{
			for ($i = 0; $i < count($acls); $i++)
			{
				$this->cache_acl($acls[$i]['page_id'], "read", 1, $acls[$i]);
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
					$legend = $this->get_translation('TreeClusterTitle');
					$legend = str_replace('%1', $this->link('/'.$root, '', rtrim($root, '/')), $legend).':';
				}

				echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$legend."</span></p>\n";
			}
		}
		else
		{
			if (!$nomark)
			{
				echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->get_translation('TreeSiteTitle')."</span></p>\n";
			}
		}

		// tree
		if (count($pages) > $limit)
		{
			echo '<em>'.$this->get_translation('TreeTooBig').'</em><br/>';
		}
		else
		{
			// cluster root level
			$rootlevel = substr_count($root, '/');

			// begin list
			echo "<ul class=\"tree\">\n";

			$i	= 0;
			$ul	= 0;
			foreach ($pages as $page)
			{
				// check read privilege and current page tag
				if ($page['tag'] == $root ||
				($this->config['hide_locked'] && !$this->has_access('read', $page['page_id'])))
				{
					continue;
				}

				// check page level
				$curlevel	= substr_count($page['tag'], '/');

				// indents (sublevels)
				if ($i > 0)
				{
					// levels difference
					$diff = $curlevel - $prevlevel;

					if ($diff > 0)
					{
						while ($diff > 0)
						{
							echo "<ul>\n";	// open indent
							$diff--;
							$ul++;
						}
					}
					else if ($diff < 0)
					{
						while ($diff < 0)
						{
							echo "</ul>\n";	// close indent
							$diff++;
							$ul--;
						}
					}
				}

				// begin element
				echo '<li>';

				# if ($curlevel == $rootlevel && $curlevel < 2)	echo '<strong>';

				if ($this->tag == $page['tag'])
				{
					// do not link the page to itself
					echo isset($page['title']) ? $page['title'] : $page['tag'];
					#echo $this->link('/'.$page['tag'], '', $page['title'], '', 0, 1, '', 0);
				}
				else
				{
					echo $this->link('/'.$page['tag'], '', $page['title'], '', 0, 1, '', 0);
				}

				# if ($curlevel == $rootlevel && $curlevel < 2)	echo '</strong>';

				echo "</li>\n";

				// recheck page level
				$prevlevel	= substr_count($page['tag'], '/');

				$i++;
			}

			// close all opened <ul> tags
			if ($ul > 0)
			{
				while ($ul > 0)
				{
					echo "</ul>\n";
					$ul--;
				}
			}

			// end list
			echo "</ul>\n";
		}
		// footer
		if (!$nomark)
		{
			echo "</div>\n";
		}
	}
	else
	{
		// no results in given level $depth
		$title_empty_tree = $this->get_translation('TreeEmptyLevels');
		$title_empty_tree = str_replace('%1', $this->link('/'.$root, '', rtrim($root, '/')), $title_empty_tree);
		echo '<em>'.$title_empty_tree.'</em><br/>';
	}
}
else
{
	if (!$nomark)
	{
		$title_empty_tree = $this->get_translation('TreeEmpty');
		$title_empty_tree = str_replace('%1', $this->link('/'.$root, '', rtrim($root, '/')), $title_empty_tree);
		echo '<em>'.$title_empty_tree.'</em><br/>';
	}
}

?>