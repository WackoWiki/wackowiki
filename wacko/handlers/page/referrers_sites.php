<div class="pageBefore"><img
	src="<?php echo $this->GetConfigValue("root_url"); ?>images/z.gif"
	width="1" height="1" alt="" style="border-width:0px; display: block; vertical-align:top" /></div>
<div class="page"><?php
if ($global = $_GET["global"])
{
	$title = str_replace("%1",$this->href("referrers", "", "global=1"),$this->GetResourceValue("Domains/SitesPages(Global)"));
	$referrers = $this->LoadReferrers();
}
else
{
	$title = str_replace("%1", $this->ComposeLinkToPage($this->GetPageTag()),
	str_replace("%2",
	($this->GetConfigValue("referrers_purge_time") ?
	($this->GetConfigValue("referrers_purge_time") == 1 ?
	$this->getResourceValue("Last24Hours") :
	str_replace("%1",$this->GetConfigValue("referrers_purge_time"),
	$this->GetResourceValue("LastDays"))): ""),
	str_replace("%3",$this->href("referrers"),$this->GetResourceValue("Domains/SitesPages"))));

	$referrers = $this->LoadReferrers($this->GetPageTag());
}

print("<strong>$title</strong><br /><br />\n");
if ($referrers)
{
	for ($a = 0; $a < count($referrers); $a++)
	{
		$temp_parse_url = parse_url($referrers[$a]["referrer"]);
		$temp_parse_url = ($temp_parse_url["host"] != "") ? strtolower(preg_replace("/^www\./Ui", "", $temp_parse_url["host"])) : "unknown";

		if (isset($referrer_sites["$temp_parse_url"]))
		{
			$referrer_sites["$temp_parse_url"] += $referrers[$a]["num"];
		}
		else
		{
			$referrer_sites["$temp_parse_url"] = $referrers[$a]["num"];
		}
	}

	array_multisort($referrer_sites, SORT_DESC, SORT_NUMERIC);
	reset($referrer_sites);

	print("<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\n");
	foreach ($referrer_sites as $site => $site_count)
	{
		print("<tr>");
		print("<td width=\"30\" align=\"right\" valign=\"top\" style=\"padding-right: 10px\">$site_count</td>");
		print("<td valign=\"top\">" . (($site != "unknown") ? "<a href=\"http://$site\">$site</a>" : $site) . "</td>");
		print("</tr>\n");
	}
	print("</table>\n");
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
	print("<br />[".str_replace("%1",$this->href("referrers_sites", "", "global=1"),$this->GetResourceValue("ViewReferringSites(Global)")) ." | ".str_replace("%1",$this->href("referrers", "", "global=1"),$this->GetResourceValue("ViewReferrersFor(Global)"))."]");
}

?></div>
