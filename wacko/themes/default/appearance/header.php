<?php
/*
 Default theme.
 Common header file.
*/

// HTTP header with right Charset settings
header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page["lang"] ?>" lang="<?php echo $this->page["lang"] ?>">
<head>
	<title><?php echo $this->GetWackoName()." : ".$this->AddSpaces($this->GetPageTag()).($this->method != "show" ? " (".$this->method.")" : "");?></title>
<?php
// We don't need search robots to index subordinate pages
if ($this->GetMethod() != 'show' || $this->page["latest"] == "0")
	echo "	<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
?>
	<meta name="keywords" content="<?php echo $this->GetKeywords(); ?>" />
	<meta name="description" content="<?php echo $this->GetDescription(); ?>" />
	<meta name="language" content="<?php echo $this->page["lang"] ?>" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->GetConfigValue("theme_url") ?>css/default.css" />
	<link media="print" rel="stylesheet" type="text/css" href="<?php echo $this->GetConfigValue("theme_url") ?>css/print.css" />
	<link rel="shortcut icon" href="<?php echo $this->GetConfigValue("theme_url") ?>icons/favicon.ico" type="image/x-icon" />
	<link title="<?php echo $this->GetConfigValue("root_page");?>" href="<?php echo $this->GetConfigValue("base_url");?>" rel="start"/>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentChangesRSS");?>" href="<?php echo $this->GetConfigValue("root_url");?>xml/changes_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wacko_name")));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentCommentsRSS");?>" href="<?php echo $this->GetConfigValue("root_url");?>xml/comments_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wacko_name")));?>.xml" />
	<?php if ($this->GetConfigValue("news_cluster")) {?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentNewsRSS");?>" href="<?php echo $this->GetConfigValue("root_url");?>xml/news_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wacko_name")));?>.xml" />
	<?php } ?>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("HistoryRevisionsRSS");?><?php echo $this->tag; ?>" href="<?php echo $this->href("revisions.xml");?>" />
<?php
// JS files.
// default.js contains common procedures and should be included everywhere
?>
	<script type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/default.js"></script>
<?php
// autocomplete.js, protoedit & wikiedit2.js contain classes for WikiEdit editor. We may include them only on method==edit pages.
if ($this->method == 'edit')
{
	echo "  <script type=\"text/javascript\" src=\"".$this->GetConfigValue("root_url")."js/protoedit.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->GetConfigValue("root_url")."js/wikiedit2.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->GetConfigValue("root_url")."js/autocomplete.js\"></script>\n";
}
?>
	<script type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/captcha.js"></script>
<?php
// Doubleclick edit feature.
// Enabled only for registered users who don't swith it off (requires class=page in show handler).
if ($user = $this->GetUser())
{
	if ($user["doubleclick_edit"] == "1")
	{
?>
	<script type="text/javascript">
	var edit = "<?php echo $this->href("edit");?>";
	</script>
<?php
	}
}
else if($this->HasAccess("write"))
{
?>

	<script type="text/javascript">
	var edit = "<?php echo $this->href("edit");?>";
	</script>
<?php
}
?>
</head>
<?php
// all_init() initializes all js features:
//	* WikiEdit
//	* Doubleclick editing
//	* Smooth scrolling

?>
<body onload="all_init();">
<div id="mainwrapper">
	<div id="header">
		<div id="header-main">
			<div id="header-top">
			<strong><?php echo $this->config["wacko_name"] ?>: </strong><?php echo $this->GetPagePath(); ?> <a class="Search" title="<?php echo $this->GetTranslation("SearchTitleTip")?>" href="<?php echo $this->config["base_url"].$this->GetTranslation("TextSearchPage").($this->config["rewrite_mode"] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->GetPageTag()); ?>">...</a>
		</div>
		<div id="login">
<?php
// If user are logged, Wacko shows "You are UserName"
if ($this->GetUser())
{ ?> <span class="nobr"><?php echo $this->GetTranslation("YouAre")." ".$this->Link($this->GetUserName()) ?></span><small> ( <span class="nobr Tune"><?php
echo $this->ComposeLinkToPage($this->GetTranslation("YouArePanelLink"), "", $this->GetTranslation("YouArePanelAccount"), 0); ?>
 | <a onclick="return confirm('<?php echo $this->GetTranslation("LogoutAreYouSure");?>');" href="<?php echo $this->Href("",$this->GetTranslation("LoginPage")).($this->config["rewrite_mode"] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->SlimUrl($this->tag);?>"><?php echo $this->GetTranslation("LogoutLink"); ?></a></span>
)</small>
<?php
// Else Wacko shows login's controls
}
else
{
	// Show Register / Login link
	echo "<ul>\n<li>".$this->ComposeLinkToPage($this->GetTranslation("LoginPage").($this->config["rewrite_mode"] ? "?" : "&amp;")."goback=".$this->SlimUrl($this->tag), "", $this->GetTranslation("LoginPage"), 0)."</li>\n";
	echo "<li>".$this->ComposeLinkToPage($this->GetTranslation("RegistrationPage"), "", $this->GetTranslation("RegistrationPage"), 0)."</li>\n";
	// echo "<li>".$this->ComposeLinkToPage($this->GetTranslation("RegistrationPage"), "", $this->GetTranslation("Help"), 0)."</li>\n</ul>";
}

// End if
?></div>
		</div>
<div id="navigation">
<?php
// Outputs Bookmarks AKA QuickLinks
	echo '<div id="usermenu">';
		echo "<ol>\n";
		// Main page
		echo "<li>".$this->ComposeLinkToPage($this->config["root_page"])."</li>\n";
		echo "<li>";
		// Bookmarks
		$formatedBMs = $this->Format($this->GetBookmarksFormatted(), "post_wacko");
		$formatedBMs = str_replace ("\n", "</li>\n<li>", $formatedBMs);
		echo $formatedBMs;

		echo "</li>\n";

		if ($this->GetUser())
		{
			// Here Wacko determines what it should show: "add to Bookmarks" or "remove from Bookmarks" icon
			if (!in_array($this->tag, $this->GetBookmarkLinks()))
				echo '<li><a href="'. $this->Href('', '', "addbookmark=yes")
					.'"><img src="'. $this->GetConfigValue("theme_url")
					.'icons/bookmark1.gif" alt="+" title="'.
					$this->GetTranslation("AddToBookmarks") .'"/></a></li>';
			else
				echo '<li><a href="'. $this->Href('', '', "removebookmark=yes")
					.'"><img src="'. $this->GetConfigValue("theme_url")
					.'icons/bookmark2.gif" alt="-" title="'.
					$this->GetTranslation("RemoveFromBookmarks") .'"/></a></li>';
			}
	echo "\n</ol></div>";
?>
<div id="search">
<?php
// Opens Search form
echo $this->FormOpen("", $this->GetTranslation("TextSearchPage"), "get");

// Searchbar
?>
<span class="search nobr"><label for="phrase"><?php echo $this->GetTranslation("SearchText"); ?></label><input
	type="text" name="phrase" id="phrase" size="20" /><input class="submitinput" type="submit" title="<?php echo $this->GetTranslation("SearchButtonText") ?>" alt="<?php echo $this->GetTranslation("SearchButtonText") ?>" value="<?php echo $this->GetTranslation("SearchButtonText") ?>"/></span>
<?php

// Search form close
echo $this->FormClose();
?>
</div>
</div>
</div>
<div id="content">
<?php
// here we show messages
if ($message = $this->GetMessage()) echo "<div class=\"info\">$message</div>";
?>