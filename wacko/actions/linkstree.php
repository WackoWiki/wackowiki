<?php

if (!function_exists('links_tree_view')){

	function links_tree_view(&$wacko, $node,$level,$indent=0)
	{
		if ($level>0)
		{

			if ($indent)
			print((str_repeat("&nbsp;",$indent*7)).$wacko->Link("/".$node, "", $node)."<br/>\n");

			$pages = $wacko->LoadAll("select to_tag from ".$wacko->config["table_prefix"]."links, ".$wacko->config["table_prefix"]."pages where from_tag='".quote($this->dblink, $node)."' AND ".$wacko->config["table_prefix"]."links.to_tag = ".$wacko->config["table_prefix"]."pages.tag order by to_tag asc");

			if (is_array($pages))
			{

				$head=split(" :: ",str_replace("]]", "", str_replace("[[", "", $wacko->GetConfigValue("navigation_links"))));

				foreach ($pages as $page)
				{
					$wacko->CachePage($page["to_tag"]);

					// we don't want page from the header. we don't want root_page (!!!!!!!)
					if ((!in_array($node, $head, TRUE) && $wacko->GetConfigValue("root_page")!=$node) || $indent==0)
					{
						if ($wacko->HasAccess("read",$page["to_tag"]))
						links_tree_view($wacko, $page["to_tag"], $level-1, $indent+1);
					}
				}
			}
		}
	}
}

$root = $vars[0];
if ($root == "/") $root = "";
if (!($root)) $root = $this->page["tag"];
$root = $this->UnwrapLink($root);

if (!$nomark){
	print("<fieldset><legend>".$this->GetResourceValue("LinksTree:Title")."</legend>\n");
}

if (!$levels) $levels=3;
else $levels=(int)$levels;
if ($levels>4){
	$levels = 4;
	print("<em>".$this->GetResourceValue("LinksTree:Level>4 warning")."</em><br />");
}

print($this->Link($root)."<br />\n");//<br/>

links_tree_view($this,$root,$levels,0);

if (!$nomark){
	print("</fieldset>\n");
}

?>