<div class="pageBefore">&nbsp;</div>
<div class="page"><?php
if ($user = $this->GetUser())
{
	if ($global = $_GET["global"])
	{
		$title = str_replace("%1", $this->href("referrers_sites", "", "global=1"), $this->GetResourceValue("ExternalPagesGlobal"));
		$referrers = $this->LoadReferrers();
	}
	else
	{
		$title = $this->getResourceValue("ReferringPages").":";
		print("<strong>$title</strong><br /><br />\n");

		if ($pages = $this->LoadPagesLinkingTo($this->getPageTag())) {
			foreach ($pages as $page) {
				$links[] = $this->Link("/".$page["tag"]);
			}
			print(implode("<br />\n", $links)."<p></p>");
		} else {
			print($this->getResourceValue("NoReferringPages")."<p></p>");
		}

		$title = str_replace("%1", $this->ComposeLinkToPage($this->GetPageTag()),
		str_replace("%2",
		($this->GetConfigValue("referrers_purge_time") ?
		($this->GetConfigValue("referrers_purge_time") == 1 ?
		$this->getResourceValue("Last24Hours") :
		str_replace("%1",$this->GetConfigValue("referrers_purge_time"),
		$this->GetResourceValue("LastDays"))): ""),
		str_replace("%3",$this->href("referrers_sites"),$this->GetResourceValue("ExternalPages"))));

		$referrers = $this->LoadReferrers($this->GetPageTag());
	}

	print("<strong>$title</strong><br /><br />\n");
	if ($referrers)
	{
		{
			print("<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n");
			foreach ($referrers as $referrer)
			{
				print("<tr>");
				print("<td width=\"30\" align=\"right\" valign=\"top\" style=\"padding-right: 10px\">".$referrer["num"]."</td>");
				print("<td valign=\"top\"><a href=\"".$referrer["referrer"]."\">".htmlspecialchars($referrer["referrer"])."</a></td>");
				print("</tr>\n");
			}
			print("</table>\n");
		}
	}
	else
	{
		print($this->GetResourceValue("NoneReferrers")."<br />\n");
	}

	if ($global)
	{
		print("<br />[".str_replace("%1",$this->href("referrers_sites"),str_replace("%2",$this->GetPageTag(),$this->GetResourceValue("ViewReferringSites")))." | ".str_replace("%1",$this->href("referrers"),str_replace("%2",$this->GetPageTag(),$this->GetResourceValue("ViewReferrersFor")))."]");
	}
	else
	{
		print("<br />[".str_replace("%1",$this->href("referrers_sites", "", "global=1"),$this->GetResourceValue("ViewReferringSitesGlobal")) ." | ".str_replace("%1",$this->href("referrers", "", "global=1"),$this->GetResourceValue("ViewReferrersForGlobal"))."]");
	}
}
else
{
	print($this->GetResourceValue("ReadAccessDenied"));
}
?></div>