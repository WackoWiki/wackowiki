<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href("show"));

// deny for comment
if ($this->page["comment_on"])
	$this->Redirect($this->href("", $this->page["comment_on"], "show_comments=1")."#".$this->page["tag"]);

if ($user = $this->GetUser())
{
	if ($global = $_GET["global"])
	{
		$title = str_replace("%1",$this->href("referrers", "", "global=1"),$this->GetTranslation("DomainsSitesPagesGlobal"));
		$referrers = $this->LoadReferrers();
	}
	else
	{
		$title = str_replace("%1", $this->ComposeLinkToPage($this->GetPageTag()),
		str_replace("%2",
		($this->GetConfigValue("referrers_purge_time") ?
		($this->GetConfigValue("referrers_purge_time") == 1 ?
		$this->GetTranslation("Last24Hours") :
		str_replace("%1",$this->GetConfigValue("referrers_purge_time"),
		$this->GetTranslation("LastDays"))): ""),
		str_replace("%3",$this->href("referrers"),$this->GetTranslation("DomainsSitesPages"))));

		$referrers = $this->LoadReferrers($this->page["id"]);
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
	?>
	  <div class="cssform3">
	    <?php
		foreach ($referrer_sites as $site => $site_count)
		{ ?>
	    <span class="site_count"><?php echo $site_count; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;<?php print((($site != "unknown") ? "<a href=\"http://$site\">$site</a>" : $site)); ?><br />
	    <?php
		}
		?>
	  </div>
	  <?php
	}
	else
	{
		print($this->GetTranslation("NoneReferrers")."<br />\n");
	}

	if ($global)
	{
		print("<br />[".str_replace("%1",$this->href("referrers_sites"),str_replace("%2",$this->GetPageTag(),$this->GetTranslation("ViewReferringSites")))." | ".str_replace("%1",$this->href("referrers"),str_replace("%2",$this->GetPageTag(),$this->GetTranslation("ViewReferrersFor")))."]");
	}
	else
	{
		print("<br />[".str_replace("%1",$this->href("referrers_sites", "", "global=1"),$this->GetTranslation("ViewReferringSitesGlobal")) ." | ".str_replace("%1",$this->href("referrers", "", "global=1"),$this->GetTranslation("ViewReferrersForGlobal"))."]");
	}
}
else
{
	print($this->GetTranslation("ReadAccessDenied"));
}
?>
</div>