<?php
$message = $this->GetMessage();
header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page["lang"] ?>" lang="<?php echo $this->page["lang"] ?>">
<head>
<title><?php echo $this->GetWakkaName()." : ".$this->AddSpaces($this->GetPageTag()).($this->method!="show"?" (".$this->method.")":""); ?></title>
<?php if ($this->GetMethod() != 'show' || $this->page["latest"] == "N")
echo "<meta name=\"robots\" content=\"noindex, nofollow\" />\n";?>
<meta name="keywords" content="<?php echo $this->GetKeywords(); ?>" />
<meta name="description"
	content="<?php echo $this->GetDescription(); ?>" />
<meta name="language" content="<?php echo $this->page["lang"] ?>" />
<meta http-equiv="content-type"
	content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
<link rel="stylesheet" type="text/css"
	href="<?php echo $this->GetConfigValue("theme_url") ?>css/wacko.css" />
<link rel="shortcut icon"
	href="<?php echo $this->GetConfigValue("theme_url") ?>icons/favicon.ico"
	type="image/x-icon" />
<link rel="alternate" type="application/rss+xml"
	title="<?php echo $this->GetResourceValue("RecentChangesRSS");?>"
	href="<?php echo $this->GetConfigValue("root_url");?>xml/recentchanges_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name")));?>.xml" />
<link rel="alternate" type="application/rss+xml"
	title="<?php echo $this->GetResourceValue("RecentCommentsRSS");?>"
	href="<?php echo $this->GetConfigValue("root_url");?>xml/recentcomment_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name")));?>.xml" />
<link rel="alternate" type="application/rss+xml"
	title="<?php echo $this->GetResourceValue("HistoryRevisionsRSS");?><?php echo $this->tag; ?> in RSS"
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
if ($user["doubleclickedit"] == "Y") {
	?>
<script type="text/javascript">
                   var edit = "<?php echo $this->href("edit");?>";
  </script>
	<?php }?>
</head>

<body onload="all_init();<?php if ($message) echo "alert('".$message."');";?>">

	<?php echo $this->FormOpen("", $this->GetResourceValue("LoginPage"), "post"); ?>
<input type="hidden" name="action" value="login" />

<div class="header">
<div class="user"><?php if ($this->GetUser()) { ?> <span class="nobr"><?php echo $this->GetResourceValue("YouAre"); ?>
<img
	src="<?php echo $this->GetConfigValue("theme_url") ?>icons/user.gif"
	width="12" height="12" border="0" style="vertical-align: baseline;"
	alt="" /><?php echo $this->Link($this->GetUserName()) ?></span><br />
<span class="small">( <span class="nobr Tune"><?php echo $this->ComposeLinkToPage($this->GetResourceValue("YouArePanelLink"), "", $this->GetResourceValue("YouArePanelName"), 0); ?>
| <a
	onclick="return confirm('<?php echo $this->GetResourceValue("LogoutAreYouSure");?>');"
	href="<?php echo $this->Href("",$this->GetResourceValue("LoginPage")).($this->config["rewrite_mode"] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->SlimUrl($this->tag);?>"><?php echo $this->GetResourceValue("LogoutLink"); ?></a></span>
)</span> <?php } else { ?> <span class="nobr"><input type="hidden"
	name="goback" value="<?php echo $this->SlimUrl($this->tag);?>" /><strong><?php echo $this->GetResourceValue("LoginWelcome") ?>:&nbsp;</strong><input
	type="text" name="name" size="18" class="login" />&nbsp;<?php echo $this->GetResourceValue("LoginPassword") ?>:&nbsp;<input
	type="password" name="password" class="login" size="8" />&nbsp;<input
	type="submit" value="Ok" /></span> <?php } ?></div>
<div class="title"><?php echo $this->config["wakka_name"] ?>: <?php echo $this->GetPagePath(); ?>
<a class="Search"
	title="<?php echo $this->GetResourceValue("SearchTitleTip")?>"
	href="<?php echo $this->config["base_url"].$this->GetResourceValue("TextSearchPage").($this->config["rewrite_mode"] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->GetPageTag()); ?>">...</a>
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
	src="<?php echo $this->GetConfigValue("theme_url") ?>icons/toolbar1.gif"
	alt="+" title="<?php echo $this->GetResourceValue("AddToBookmarks") ?>" /></a><?php
} else {
	?><a href="<?php echo $this->Href('', '', "removebookmark=yes")?>"><img
	src="<?php echo $this->GetConfigValue("theme_url") ?>icons/toolbar2.gif"
	alt="-"
	title="<?php echo $this->GetResourceValue("RemoveFromBookmarks") ?>" /></a><?php
}
} ?></div>

<?php echo $this->FormClose(); ?>