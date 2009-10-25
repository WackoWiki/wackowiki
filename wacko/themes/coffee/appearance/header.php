<?php
header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page["lang"] ?>" lang="<?php echo $this->page["lang"] ?>">
<head>
<title><?php echo $this->GetWackoName()." : ".$this->AddSpaces($this->GetPageTag()).($this->method!="show"?" (".$this->method.")":""); ?></title>
<?php if ($this->GetMethod() != 'show' || $this->page["latest"] == "0")
echo "<meta name=\"robots\" content=\"noindex, nofollow\" />\n";?>
<meta name="keywords" content="<?php echo $this->GetKeywords(); ?>" />
<meta name="description"
	content="<?php echo $this->GetDescription(); ?>" />
<meta name="language" content="<?php echo $this->page["lang"] ?>" />
<meta http-equiv="content-type"
	content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->GetConfigValue("theme_url") ?>css/default.css" />
<link rel="shortcut icon"
	href="<?php echo $this->GetConfigValue("theme_url") ?>icons/favicon.ico"
	type="image/x-icon" />
<link rel="alternate" type="application/rss+xml"
	title="<?php echo $this->GetTranslation("RecentChangesRSS");?>"
	href="<?php echo $this->GetConfigValue("root_url");?>xml/changes_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wacko_name")));?>.xml" />
<link rel="alternate" type="application/rss+xml"
	title="<?php echo $this->GetTranslation("RecentCommentsRSS");?>"
	href="<?php echo $this->GetConfigValue("root_url");?>xml/comments_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wacko_name")));?>.xml" />
<link rel="alternate" type="application/rss+xml"
	title="<?php echo $this->GetTranslation("HistoryRevisionsRSS");?><?php echo $this->tag; ?> in RSS"
	href="<?php echo $this->href("revisions.xml");?>" />
<?php
// JS files.
// default.js contains common procedures and should be included everywhere
?>
  <script type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/default.js"></script>
<?php
// protoedit & wikiedit2.js contain classes for WikiEdit editor. We may include them only on method==edit pages
if ($this->method == 'edit')
{
	echo "  <script type=\"text/javascript\" src=\"".$this->GetConfigValue("root_url")."js/protoedit.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->GetConfigValue("root_url")."js/wikiedit2.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->GetConfigValue("root_url")."js/autocomplete.js\"></script>\n";
}
?>
<script type="text/javascript"
	src="<?php echo $this->GetConfigValue("root_url");?>js/swfobject.js"></script>
<script type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/captcha.js"></script>
<?php
if ($user = $this->GetUser())
   {
      if ($user["doubleclickedit"] == "1")
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

<body onload="all_init();">

	<?php echo $this->FormOpen("", $this->GetTranslation("LoginPage"), "post"); ?>
<input type="hidden" name="action" value="login" />

<div class="header">
<div class="user"><?php if ($this->GetUser()) { ?> <span class="nobr"><?php echo $this->GetTranslation("YouAre"); ?>
<img
	src="<?php echo $this->GetConfigValue("theme_url") ?>icons/user.gif"
	width="12" height="12" border="0" style="vertical-align: baseline;"
	alt="" /><?php echo $this->Link($this->GetUserName()) ?></span><br />
<span class="small">( <span class="nobr Tune"><?php echo $this->ComposeLinkToPage($this->GetTranslation("YouArePanelLink"), "", $this->GetTranslation("YouArePanelName"), 0); ?>
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
	href="<?php echo $this->config["base_url"].$this->GetTranslation("TextSearchPage").($this->config["rewrite_mode"] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->GetPageTag()); ?>">...</a>
</div>

</div>

<div class="bookmarks"><?php

echo $this->ComposeLinkToPage($this->config["root_page"]);
echo " | ";
//echo $this->GetBookmarksFormatted();
echo $this->Format($this->GetBookmarksFormatted(), "post_wacko");
//echo $this->Format(implode(" | ", $this->GetBookmarks()));
?> | <?php

if ($this->GetUser()) {
	if (!in_array($this->GetPageSuperTag(),$this->GetBookmarkLinks())) {?>
<a href="<?php echo $this->Href('', '', "addbookmark=yes")?>"><img
	src="<?php echo $this->GetConfigValue("theme_url") ?>icons/bookmark1.gif"
	alt="+" title="<?php echo $this->GetTranslation("AddToBookmarks") ?>" /></a><?php
} else {
	?><a href="<?php echo $this->Href('', '', "removebookmark=yes")?>"><img
	src="<?php echo $this->GetConfigValue("theme_url") ?>icons/bookmark2.gif"
	alt="-"
	title="<?php echo $this->GetTranslation("RemoveFromBookmarks") ?>" /></a><?php
}
} ?></div>

<?php echo $this->FormClose(); ?>
<?php
// here we show messages
if ($message = $this->GetMessage()) echo "<div class=\"info\">$message</div>";
?>