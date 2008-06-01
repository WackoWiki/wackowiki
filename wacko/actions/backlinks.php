<?php

if ($vars[0])
$tag = $this->UnwrapLink( $vars[0] );
else
$tag = $this->getPageTag();

if ($pages = $this->LoadPagesLinkingTo($tag))
{
	if(!$nomark)
	{
		print("<fieldset><legend>".$this->GetResourceValue("ReferringPages").":</legend>\n");
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
	echo $this->GetResourceValue("NoReferringPages");
}
?>
