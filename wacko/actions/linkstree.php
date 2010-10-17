<?php

if (!isset($nomark)) $nomark = '';

if (!function_exists('links_tree_view'))
{
	function links_tree_view(&$wacko, $node, $level, $indent = 0)
	{
		if ($level > 0)
		{
			if ($indent)
			print((str_repeat("&nbsp;",$indent*7)).$wacko->link('/'.$node, '', $node)."<br/>\n");

			$pages = $wacko->load_all(
				"SELECT to_tag ".
				"FROM ".$wacko->config['table_prefix']."link, ".$wacko->config['table_prefix']."page ".
				"WHERE from_tag='".quote($wacko->dblink, $node)."' ".
					"AND ".$wacko->config['table_prefix']."link.to_tag = ".$wacko->config['table_prefix']."page.tag ".
				"ORDER BY to_tag ASC");

			if (is_array($pages))
			{
				if (isset($wacko->config['default_bookmarks']))
					$head = explode(" / ",str_replace("))", "", str_replace("((", "", $wacko->config['default_bookmarks'])));

				foreach ($pages as $page)
				{
					$wacko->cache_page($page['to_tag']);

					// we don't want page from the header. we don't want root_page (!!!!!!!)
					if ((!in_array($node, $head, TRUE) && $wacko->config['root_page'] != $node) || $indent == 0)
					{
						if ($wacko->has_access('read', $page['to_tag']))
						links_tree_view($wacko, $page['to_tag'], $level - 1, $indent + 1);
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

if (!$nomark)
{
	print("<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->get_translation('LinksTreeTitle')."</span></p>\n");
}

if (!isset($levels)) $levels = 3;
else $levels = (int)$levels;
if ($levels > 4)
{
	$levels = 4;
	print("<em>".$this->get_translation('LinksTreeLevel4Warning')."</em><br />");
}

print($this->link('/'.$root, '', $root)."<br />\n");//<br/>

links_tree_view($this, $root, $levels, 0);

if (!$nomark)
{
	print("</div>\n");
}

?>