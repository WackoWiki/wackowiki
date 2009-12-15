<?php

// constants
$limit	= 500;
$style	= 'ul';

// input
if (!isset($root) && !isset($page))
					$root	= '/'.$this->page['tag'];
if (!isset($page)) $page = "";
if ($page)			$root	= $page;
if ($root == '/')	$root	= '';
if ($root)			$root	= $this->UnwrapLink($root).'/';

if (!isset($depth)) $depth = "";
if (!$depth || $depth < 1)
					$depth	= 1;
else				$depth	= (int)$depth;;

if (!isset($nomark)) $nomark = "";
if (!isset($title)) $title = "";

// collect pages
if ($pages = $this->LoadAll(
	"SELECT id, tag, supertag, title ".
	"FROM {$this->config['table_prefix']}pages ".
	"WHERE comment_on_id = '0' ".
		"AND tag LIKE '".quote($this->dblink, $root)."%' ".
	"ORDER BY tag", 1))
{
	// pick all subpages up to the desired depth level
	if ($depth > 0)
	{
		$maxlevel = substr_count($root, '/') + $depth;
		reset($pages);

		do
		{
			$k = key($pages);

			if (substr_count($pages[$k]['tag'], '/') < $maxlevel)
			{
				$_pages[]	= $pages[$k];
				$acl_str[]	= $pages[$k]['tag'];
				$sup_str[]	= $pages[$k]['supertag'];
			}
		}
		while (false !== next($pages));

		$pages = $_pages;
		unset($_pages);
	}

	// cache links
	if ($links = $this->LoadAll(
	"SELECT {$this->pages_meta} ".
	"FROM {$this->config['table_prefix']}pages ".
	"WHERE supertag IN ( '".implode("', '", $sup_str)."' )", 1))
	{
		for ($i = 0; $i < count($links); $i++)
		{
			$this->CachePage($links[$i], 1);
		}
	}

	// cache acls
	if ($acls = $this->LoadAll(
	"SELECT * FROM {$this->config['table_prefix']}acls ".
	"WHERE tag IN ( '".implode("', '", $acl_str)."' )", 1))
	{
		for ($i = 0; $i < count($acls); $i++)
		{
			$this->CacheACL($acls[$i]['tag'], 1, $acls[$i]);
		}
	}

	// header
	if ($root)
	{
		if (!$nomark)
		{
			if ($title)
			{
				$title = $this->Format($title);
			}
			else
			{
				$title = $this->GetTranslation('TreeClusterTitle');
				$title = str_replace('%1', $this->Link('/'.$root, '', rtrim($root, '/')), $title).':';
			}

			echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$title."</span></p>\n";
		}
	}
	else
	{
		if (!$nomark)
			echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->GetTranslation("TreeSiteTitle")."</span></p>\n";
	}

	// tree
	if (count($pages) > $limit)
	{
		echo '<small><em>'.$this->GetTranslation('TreeTooBig').'</em></small><br/>';
	}
	else
	{
		// cluster root level
		$rootlevel = substr_count($root, '/');

		// begin list
		echo "<ul>\n";

		$i	= 0;
		$ul	= 0;
		foreach ($pages as $page)
		{
			// check read privilege and current page tag
			if ($page['tag'] == $root ||
			($this->config['hide_locked'] && !$this->HasAccess('read', $page['id'])))
				continue;

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
			if ($curlevel == $rootlevel && $curlevel < 2)	echo '<strong>';
			if ($this->tag == $page['tag'])					echo '<em>';

			echo $this->Link('/'.$page['tag'], '', $page['title'], 0, 1, '', 0);

			// end element
			if ($this->tag == $page['tag'])					echo '</em>';
			if ($curlevel == $rootlevel && $curlevel < 2)	echo '</strong>';
			echo "</li>\n";


			// recheck page level
			$prevlevel	= substr_count($page['tag'], '/');

			$i++;
		}

		// close all opened <ul> tags
		if ($ul > 0) while ($ul > 0)
		{
			echo "</ul>\n";
			$ul--;
		}

		// end list
		echo "</ul>\n";
	}
}
else
{
	if (!$nomark) echo '<small><em>'.$this->GetTranslation('TreeEmpty').'</em></small><br/>';
}

// footer
if (!$nomark) echo "</div>\n";

?>