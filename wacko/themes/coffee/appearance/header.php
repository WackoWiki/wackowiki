<?php
/*
 Coffee theme.
 Common header file.
*/

// HTTP header with right Charset settings
header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page["lang"] ?>" lang="<?php echo $this->page["lang"] ?>">
<head>
	<title><?php echo htmlspecialchars($this->config["wacko_name"])." : ".$this->AddSpaces($this->tag).($this->method != "show" ? " (".$this->method.")" : "");?></title>
<?php
// We don't need search robots to index subordinate pages
if ($this->method != 'show' || $this->page["latest"] == "0" || $this->page["noindex"] == "1")
	echo "	<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
?>
	<meta name="keywords" content="<?php echo $this->GetKeywords(); ?>" />
	<meta name="description" content="<?php echo $this->GetDescription(); ?>" />
	<meta name="language" content="<?php echo $this->page["lang"] ?>" />
	<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config["theme_url"] ?>css/default.css" />
	<?php if ($this->config["allow_x11colors"]) {?>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->config["base_url"] ?>themes/_common/X11colors.css" />
	<?php } ?>
	<link media="print" rel="stylesheet" type="text/css" href="<?php echo $this->config["theme_url"] ?>css/print.css" />
	<link rel="shortcut icon" href="<?php echo $this->config["theme_url"] ?>icons/favicon.ico" type="image/x-icon" />
	<link title="<?php echo $this->config["root_page"];?>" href="<?php echo $this->config["base_url"];?>" rel="start"/>
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentChangesRSS");?>" href="<?php echo $this->config["base_url"];?>xml/changes_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config["wacko_name"]));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentCommentsRSS");?>" href="<?php echo $this->config["base_url"];?>xml/comments_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config["wacko_name"]));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentNewsRSS");?>" href="<?php echo $this->config["base_url"];?>xml/news_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config["wacko_name"]));?>.xml" />
	<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("HistoryRevisionsRSS");?><?php echo $this->tag; ?>" href="<?php echo $this->href("revisions.xml");?>" />
<?php
// JS files.
// default.js contains common procedures and should be included everywhere
?>
	<script type="text/javascript" src="<?php echo $this->config["base_url"];?>js/default.js"></script>
<?php
// load swfobject with flash action (e.g. $this->config["allow_swfobject"] = 1), by default it is set off
if ($this->config["allow_swfobject"])
{
	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/swfobject.js\"></script>\n";
}
// autocomplete.js, protoedit & wikiedit2.js contain classes for WikiEdit editor. We may include them only on method==edit pages.
if ($this->method == 'edit')
{
	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/protoedit.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/wikiedit2.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/autocomplete.js\"></script>\n";
}
?>
<script type="text/javascript" src="<?php echo $this->config["base_url"];?>js/captcha.js"></script>
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
else if ($this->HasAccess("write"))
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

	<?php echo $this->FormOpen("", $this->GetTranslation("LoginPage"), "post"); ?>
<input type="hidden" name="action" value="login" />

<div class="header">
<div class="user"><?php if ($this->GetUser()) { ?> <span class="nobr"><?php echo $this->GetTranslation("YouAre"); ?>
<img
	src="<?php echo $this->config["theme_url"] ?>icons/user.gif"
	width="12" height="12" border="0" style="vertical-align: baseline;"
	alt="" /><?php echo $this->Link($this->GetUserName()) ?></span><br />
<span class="small">( <span class="nobr Tune"><?php echo $this->ComposeLinkToPage($this->GetTranslation("YouArePanelLink"), "", $this->GetTranslation("YouArePanelAccount"), 0); ?>
| <a
	onclick="return confirm('<?php echo $this->GetTranslation("LogoutAreYouSure");?>');"
	href="<?php echo $this->Href("",$this->GetTranslation("LoginPage")).($this->config["rewrite_mode"] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->SlimUrl($this->tag);?>"><?php echo $this->GetTranslation("LogoutLink"); ?></a></span>
)</span> <?php } else { ?> <span class="nobr"><input type="hidden"
	name="goback" value="<?php echo $this->SlimUrl($this->tag);?>" /><strong><?php echo $this->GetTranslation("LoginWelcome") ?>:&nbsp;</strong><input
	type="text" name="name" size="18" class="login" />&nbsp;<?php echo $this->GetTranslation("LoginPassword") ?>:&nbsp;<input
	type="password" name="password" class="login" size="8" />&nbsp;<input
	type="submit" value="Ok" /></span> <?php } ?></div>
<div class="title"><?php echo $this->config["wacko_name"] ?>: <?php echo $this->GetPagePath(); ?>
<a class="Search"
	title="<?php echo $this->GetTranslation("SearchTitleTip")?>"
	href="<?php echo $this->config["base_url"].$this->GetTranslation("TextSearchPage").($this->config["rewrite_mode"] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->tag); ?>">...</a>
</div>
</div>

<div class="bookmarks"><?php
	echo '<div id="bookmarks">';
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
					.'"><img src="'. $this->config["theme_url"]
					.'icons/bookmark1.gif" alt="+" title="'.
					$this->GetTranslation("AddToBookmarks") .'"/></a></li>';
			else
				echo '<li><a href="'. $this->Href('', '', "removebookmark=yes")
					.'"><img src="'. $this->config["theme_url"]
					.'icons/bookmark2.gif" alt="-" title="'.
					$this->GetTranslation("RemoveFromBookmarks") .'"/></a></li>';
			}
	echo "\n</ol></div>"; ?><br style="clear: both;"></div>

<?php echo $this->FormClose(); ?>
<?php
// here we show messages
if ($message = $this->GetMessage()) echo "<div class=\"info\">$message</div>";
?>