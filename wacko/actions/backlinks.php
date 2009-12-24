<?php

if ($page)
	$tag = $this->UnwrapLink($page);
else
	$tag = $this->getPageTag();

if ($pages = $this->LoadPagesLinkingTo($tag))
{
	if(!$nomark)
	{
		print("<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->GetTranslation("ReferringPages").":</span></p>\n");
	}

	foreach ($pages as $page)
	{
		if ($page["tag"])
		{
			if ($this->config["hide_locked"])
				$access = $this->HasAccess("read",$page["page_id"]);
			else
				$access = true;

			if ($access)
			{
				$lnk = $this->Link("/".$page["tag"]."#".$this->NpjTranslit($tag), "", $page["tag"]);
				if (strpos($lnk, 'span class="missingpage"') === false)
				echo($lnk."<br />\n");
			}
		}
	}

	if(!$nomark)
	{
		echo "</div>\n";
	}
}
else
{
	echo $this->GetTranslation("NoReferringPages");
}
?>