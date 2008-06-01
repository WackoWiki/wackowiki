<div class="footer"><?php
// Revisions link
echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetResourceValue("RevisionTip")."\">".$this->GetPageTime()."</a> |\n" : "";

// If this page exists
if ($this->page)
{
	// Show Owner of this page
	if($owner = $this->GetPageOwner())
	{
		print($this->GetResourceValue("Owner").$this->Link($owner));
	}
	else if(!$this->page["comment_on"])
	{
		print($this->GetResourceValue("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetResourceValue("TakeOwnership")."</a>)" : ""));
	}
}
?></div>
<div class="copyright"><?php
if($this->GetUser())
{
	echo $this->GetResourceValue("PoweredBy")." ".$this->Link("WackoWiki:WackoWiki", "", "WackoWiki ".$this->GetWackoVersion());
}
?></div>

<?php
//Debug Querylog.
if($this->GetConfigValue("debug")>=2)
{
	print("<span style=\"font-size: 11px; color: #888888\">");
	print("<strong>Query log:</strong><br />\n");
	foreach ($this->queryLog as $query)
	{
		print($query["query"]." (".$query["time"].")<br />\n");
		$zz++;
	}
	print("<b>total: $zz</b>");
	print("</span>");
}

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>