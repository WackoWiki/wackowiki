<?php

if (($topic == 1) || ($title == 1)) $mode = "topic"; else $mode = "full";
if ($_REQUEST["topic"] == "on") $mode = "topic";
//if (!$delim) $delim="---";
if (!in_array($style,array("br","ul","ol","comma"))) $style="ol";
$i = 0;
if ($filter!="pages") $filter = "all";

if ($vars[0] != "") $phrase = $vars[0]; else { $phrase=""; $form=1; }

if ($form)
{
	echo $this->FormOpen("", "", "get") ?>

<label for="searchfor"><?php echo $this->GetTranslation("SearchFor");?></label>:&nbsp;<br />
<input name="phrase" id="searchfor" size="40"
			value="<?php echo htmlspecialchars($_REQUEST["phrase"]) ?>" /> <input
			type="submit"
			value="<?php echo $this->GetTranslation("SearchButtonText"); ?>" />
			<br />
	<input type="checkbox" name="topic"
		<?php if ($mode == "topic") echo "CHECKED"; ?> id="checkboxSearch" />
		<label for="checkboxSearch"><?php echo $this->GetTranslation("TopicSearchText"); ?></label>
		
		<?php
		echo $this->FormClose();
}

if ($phrase == "") $phrase = $_REQUEST["phrase"];
if ($phrase)
{
	if ($form) print "<br />";

	if (strlen($phrase)>2)
	{

		if ($mode == "topic") $results = $this->TagSearch($phrase);
		else $results = $this->FullTextSearch($phrase, ($filter=="all"?0:1));
		$phrase = htmlspecialchars($phrase);
		if ($results)
		{
			if (!$nomark) print(  "<div class=\"layout-box\"><p class=\"layout-box\"><span>".
			$this->GetTranslation(($mode=="topic"?"Topic":"")."SearchResults").
              " \"$phrase\":</span></p>");
			if ($style=="ul") print "<ul class=\"SearchResults\">\n";
			if ($style=="ol") print "<ol class=\"SearchResults\">\n";

			foreach ($results as $page)
			if (!$this->config["hide_locked"] || $this->HasAccess("read",$page["tag"]) )
			{
				// Don't show it if it's a comment and we're hiding comments from this user
				if($page["comment_on"] == '' || ($page["comment_on"] != '' && $this->UserAllowedComments()))
				{
					if ($style=="ul" || $style=="ol") print "<li>";
					if ($style=="comma" && $i>0) print ",\n";

					print($this->Link("/".$page["tag"],"",$page["tag"]));

					if ($style=="br") print "<br />\n";
					if ($style=="ul" || $style=="ol") print "</li>\n";
					$i++;
				}
			}

			if ($style=="ul") print "</ul>";
			if ($style=="ol") print "</ol>";
			if (!$nomark) print("</div>");
		}
		else
		if (!$nomark) echo $this->GetTranslation("NoResultsFor")."\"$phrase\".";
	}
	else
	if (!$nomark) echo $this->GetTranslation("NoResultsFor")."\"$phrase\".";
}

?>