<?php

if (!function_exists('links_tree_view'))
{
	function links_tree_view(&$wacko, $node, $level, $indent = 0)
	{
		if ($level > 0)
		{
			if ($indent)
			{
				echo (str_repeat("&nbsp;", $indent * 7)).$wacko->link('/'.$node, '', $node)."<br/>\n";
			}

			$pages = $wacko->load_all(
				"SELECT l.to_tag, l.to_page_id ".
				"FROM ".$wacko->config['table_prefix']."link l, ".$wacko->config['table_prefix']."page a ".
					"INNER JOIN ".$wacko->config['table_prefix']."page b ON (l.from_page_id = b.page_id) ".
				"WHERE b.tag='".quote($wacko->dblink, $node)."' ".
					"AND l.to_page_id = a.page_id ".
				"ORDER BY l.to_tag ASC");

			if (is_array($pages))
			{
				if ($wacko->get_default_bookmarks())
				{
					$head = explode(' / ',str_replace('))', '', str_replace('((', '', $wacko->get_default_bookmarks())));
				}

				foreach ($pages as $page)
				{
					$wacko->cache_page($page['to_tag']);

					// we don't want page from the header. we don't want root_page (!!!!!!!)
					if ((!in_array($node, $head, TRUE) && $wacko->config['root_page'] != $node) || $indent == 0)
					{
						if ($wacko->has_access('read', $page['to_page_id']))
						{
							links_tree_view($wacko, $page['to_tag'], $level - 1, $indent + 1);
						}
					}
				}
			}
		}
	}
}


$root = (isset($vars[0]) ? $vars[0] : null);
if ($root == '/') $root = '';
if (!isset($root)) $root = $this->page['tag'];
$root = $this->unwrap_link($root);
if (!isset($nomark)) $nomark = '';

if (!$nomark)
{
	echo "<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->get_translation('LinksTreeTitle')."</span></p>\n";
}

if (!isset($levels)) $levels = 3;
else $levels = (int)$levels;
if ($levels > 4)
{
	$levels = 4;
	echo "<em>".$this->get_translation('LinksTreeLevel4Warning')."</em><br />";
}

echo $this->link('/'.$root, '', $root)."<br />\n";//<br/>

links_tree_view($this, $root, $levels, 0);

if (!$nomark)
{
	echo "</div>\n";
}

?>