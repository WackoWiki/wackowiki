<?php

/*
 Most Popular Pages Action

 All arguments are optional, the "dontrecurse" argument is only used when the "for" argument is used and even then it's still optional

 {{mostpopular
 [max="50"] // maximum number of pages to retrieve
 [for|page="PageName"] // page name to start from in the page hierarchy
 [nomark="1"] // makes it possible to hide frame around
 [dontrecurse="true|false"] // if set to true the list will only include pages that are direct children of the "for" page
 }}
 */

// TODO: should also work with parameter 'page', but didn't

if (!isset($for)) $for = "";
if (!isset($page)) $page = "";
if (!isset($nomark)) $nomark = "";
if (!isset($max)) $max = "";
if (!isset($title)) $title = "";

if (!$max)  $max = 25;
if ($max > 500) $max = 500;

// check for first param (for what mostpopular is built)
if ($for) $page = $for;
if ($page)
{
	$page = $this->UnwrapLink($page);
	$ppage = "/".$page;
	$context = $page;
	$_page = $this->LoadPage($page);
	if (!$title) $title = $page;
	$link = $this->Href("",$_page["tag"]);
}
else
{
	$page = ""; $ppage="";
	$context = $this->tag;
	$_page = $this->page;
	$link = "";
}

if(!$nomark)
{
	print("<div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->GetTranslation("MostPopularPages").": ".$this->Link($ppage, "", $title)."</span></p>\n");
}

if(!$for)
{
	$pages = $this->LoadAll("SELECT page_id, tag, hits FROM ".$this->config["table_prefix"]."page ORDER BY hits DESC LIMIT ".$max);
}
else
{
	$for = $this->UnwrapLink($for);

	if(!$dontrecurse || strtolower($dontrecurse) == 'false')
	{
		// We want to recurse and include all the sub pages of sub pages (and so on) in the listing
		$pages = $this->LoadAll("SELECT DISTINCT page_id, tag, hits FROM ".$this->config["table_prefix"]."page, ".$this->config["table_prefix"]."link WHERE tag <> '".$for."' AND tag = to_tag AND INSTR(from_tag, '".$for."') = 1 AND INSTR(to_tag, '".$for."') = 1 ORDER BY hits DESC LIMIT ".$max);
	}
	else
	{
		// The only pages we want to display are those directly under the selected page, not their kids and grandkids
		$pages = $this->LoadAll("SELECT DISTINCT page_id, tag, hits FROM ".$this->config["table_prefix"]."page, ".$this->config["table_prefix"]."link WHERE tag <> '".$for."' AND tag = to_tag AND from_tag = '".$for."' AND INSTR(to_tag, '".$for."') = 1 ORDER BY hits DESC LIMIT ".$max);
	}
}

$num = 0;

print("<table>");
foreach ($pages as $page)
{
	if ($num < $max)
	{
		if ($this->config["hide_locked"]) $access = $this->HasAccess("read",$page["page_id"]);
		else $access = true;
		if ($access)
		{
			// print entry
			$num++;
			print("<tr><td>&nbsp;&nbsp;".$num.".&nbsp;".$this->Link("/".$page["tag"],"",$page["tag"])."</td><td>".
			$this->GetTranslation("Shown")."</td><td>".
			$page["hits"]."</td></tr>\n");
		}
	}
}
print("</table>");

if(!$nomark)
{
	echo "</div>\n";
}

?>