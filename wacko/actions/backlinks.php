<?php

if ($page)
	$tag = $this->UnwrapLink($page);
else
	$tag = $this->getPageTag();

if ($pages = $this->LoadPagesLinkingTo($tag))
{
	if(!$nomark)
	{
		print("<fieldset><legend>".$this->GetTranslation("ReferringPages").":</legend>\n");
	}

	foreach ($pages as $page)
	{
		if ($page["tag"])
		{
			if ($this->config["hide_locked"]) $access = $this->HasAccess("read",$page["tag"]);
			else $access = true;
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
		echo "</fieldset>\n";
	}
}
else
{
	echo $this->GetTranslation("NoReferringPages");
}
?>
