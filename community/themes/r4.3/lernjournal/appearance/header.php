<?php
/*
lernjournal theme.
*/

// HTTP header with right Charset settings
  header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page["lang"] ?>" lang="<?php echo $this->page["lang"] ?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>
<?php
// Echoes Title of the page.
  echo $this->GetWackoName()." : ".$this->AddSpaces($this->GetPageTag()).($this->method!="show"?" (".$this->method.")":"");
?>
</title>
<?php
// We don't need search robots to index subordinate pages
  if ($this->method != 'show' || $this->page["latest"] == "1")
     echo "<meta name=\"robots\" content=\"index, follow\" />\n";
?>
<meta name="Keywords" content="<?php echo $this->GetKeywords(); ?>" />
<meta name="Description" content="<?php echo $this->GetDescription(); ?>" />
<meta name="language" content="<?php echo $this->page["lang"] ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->config["theme_url"] ?>css/default.css" />
<link href="<?php echo $this->config["theme_url"] ?>css/layout.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config["theme_url"] ?>css/fontdesign.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $this->config["theme_url"] ?>css/sidenote.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="<?php echo $this->config["theme_url"] ?>icons/wacko.ico" type="image/x-icon" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentChangesRSS");?>" href="<?php echo $this->config["base_url"];?>xml/changes_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config["wacko_name"]));?>.xml" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("RecentCommentsRSS");?>" href="<?php echo $this->config["base_url"];?>xml/comments_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->config["wacko_name"]));?>.xml" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetTranslation("HistoryRevisionsRSS");?><?php echo $this->tag; ?>" href="<?php echo $this->href("revisions.xml");?>" />
<?php
// JS files.
// default.js contains common procedures and should be included everywhere
?>
  <script type="text/javascript" src="<?php echo $this->config["base_url"];?>js/default.js"></script>
<?php
// protoedit & wikiedit2.js contain classes for WikiEdit editor. We may include them only on method==edit pages
if ($this->method == 'edit')
{
	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/protoedit.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/wikiedit2.js\"></script>\n";
	echo "  <script type=\"text/javascript\" src=\"".$this->config["base_url"]."js/autocomplete.js\"></script>\n";
}
?>
  <script type="text/javascript" src="<?php echo $this->config["base_url"];?>js/swfobject.js"></script>
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
<body onload="all_init();">
<div id="head">
  <div id="wikititle"><?php echo $this->config["wacko_name"] ?></div>
  <?php
// Searchbar
echo $this->FormOpen("", $this->GetTranslation("TextSearchPage"), "get"); ?>
  <div id="search"><?php echo $this->GetTranslation("SearchText") ?><input name="phrase" type="text" size="12" style="border: none; padding: 0px; margin: 0px;" /></div>
  <?php
// Search form close
echo $this->FormClose();
?>
</div>
<div id="container">
<div id="navi">
  <?php
// Outputs Bookmarks AKA QuickLinks
  // Main page
  echo $this->ComposeLinkToPage($this->config["root_page"]); ?><br />
  <?php
  // All user's Bookmarks
  echo $this->Format(implode( "\n", $this->GetBookmarks())); ?><br />
  <?php
  // Here Wacko determines what it should show: "add to Bookmarks" or "remove from Bookmarks" icon
if ($this->GetUser())
{
 if (!in_array($this->tag, $this->GetBookmarkLinks()))
 {?>
  <a href="<?php echo $this->Href('', '', "addbookmark=yes")?>"><img src="<?php echo $this->config["theme_url"] ?>icons/bookmark1.gif" alt="+" title="<?php echo $this->GetTranslation("AddToBookmarks") ?>" border="0" align="middle" /></a><br />
  <?php
 } else { ?>
  <a href="<?php echo $this->Href('', '', "removebookmark=yes")?>"><img src="<?php echo $this->config["theme_url"] ?>icons/bookmark2.gif" alt="-" title="<?php echo $this->GetTranslation("RemoveFromBookmarks") ?>" border="0" align="middle" /></a><br />
  <?php
 }
}
?>
  <hr noshade="noshade" />
  <?php
// If user are logged, Wacko shows "You are UserName"
if ($this->GetUser()) { ?>
  <?php echo $this->GetTranslation("YouAre")." ".$this->Link($this->GetUserName()) ?><br />
  <small>
  <?php
      echo $this->ComposeLinkToPage($this->GetTranslation("YouArePanelLink"), "", $this->GetTranslation("YouArePanelAccount"), 0); ?><br />
  <a onclick="return confirm('<?php echo $this->GetTranslation("LogoutAreYouSure");?>');" href="<?php echo $this->Href("",$this->GetTranslation("LoginPage")).($this->config["rewrite_mode"] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->SlimUrl($this->tag);?>"><?php echo $this->GetTranslation("LogoutLink"); ?></a></small>
  <?php
// Else Wacko shows login's controls
} else {
?><br />
  <?php
// Begin Login form
echo $this->FormOpen("", $this->GetTranslation("LoginPage"), "post"); ?>
  <input type="hidden" name="action" value="login" />
  <input type="hidden" name="goback" value="<?php echo $this->SlimUrl($this->tag);?>" />
  <?php echo $this->GetTranslation("LoginWelcome") ?>:<br />
  <input type="text" name="name" size="12" class="login" alt="username" /><br />
  <?php echo $this->GetTranslation("LoginPassword") ?>:<br />
  <input type="password" name="password" class="login" size="8" alt="password" />
  <input type="image" src="<?php echo $this->config["theme_url"] ?>icons/login.gif" alt=">>>" align="top" />
  <?php // Closing Login form
echo $this->FormClose();
?>
  <?php
}
// End if
?>
  <hr noshade="noshade" /><br />
  <?php
// If this page exists
if ($this->page)
{
 // If owner is current user
 if ($this->UserIsOwner())
 {
   print($this->GetTranslation("YouAreOwner")."<br /> \n");

   // Rename link: Hinzugefügt: if ($this->IsAdmin())
 if ($this->IsAdmin())  {
 print(" <a href=\"".$this->href("rename")."\">".$this->GetTranslation("RenameText")."</a><br /> \n");}

   //Edit ACLs link
   print("<a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("EditACLText")."</a>");
 }
 // If owner is NOT current user
 else
 {
   // Show Owner of this page
   if ($owner = $this->GetPageOwner())
   {
     print($this->GetTranslation("Owner").": ".$this->Link($owner));
   } else if (!$this->page["comment_on_id"]) {
     print($this->GetTranslation("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetTranslation("TakeOwnership")."</a>)" : ""));
   }
 }
// If User has rights to edit page, show Edit link
echo $this->HasAccess("write") ? "<br /><a href=\"".$this->href("edit")."\" accesskey=\"E\" title=\"".$this->GetTranslation("EditTip")."\"><strong>".$this->GetTranslation("EditText")."</strong></a>" : "";
?><br />
  <?php
// Watch/Unwatch icon
echo ($this->iswatched === true ? "<a href=\"".$this->href("watch")."\">".$this->GetTranslation("RemoveWatch")."</a>" : "<a href=\"".$this->href("watch")."\">".$this->GetTranslation("SetWatch")."</a>" );
?><br />
  <?php
 // Rename link
 if ($this->CheckACL($this->GetUserName(),$this->config["rename_globalacl"]) && !$this->UserIsOwner())
 {
   print("<a href=\"".$this->href("rename")."\">".$this->GetTranslation("RenameText")."</a><br />");
 }
 // Page  settings link
 print("<a href=\"".$this->href("settings"). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("SettingsText")."</a><br />");
}
// Remove link (shows only for Admins)
if ($this->IsAdmin()){
	print("<a href=\"".$this->href("remove")."\">".$this->GetTranslation("DeleteTip")."</a><br />");
}
?>
<?php
// Print icon
echo"<a href=\"".$this->href("print")."\" target=\"_new\"><img src=\"".$this->config["theme_url"]."icons/print.gif\" title=\"".$this->GetTranslation("PrintVersion")."\" alt=\"".$this->GetTranslation("PrintVersion")."\"  align=\"middle\" border=\"0\" /></a>";

?>

<hr noshade="noshade" />
<?php
// Revisions link
echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetTranslation("RevisionTip")."\">".$this->GetPageTimeFormatted()."</a>\n" : "";
?>
</div>
<div id="content">
<span class="loc"><strong><?php echo $this->config["wacko_name"] ?>:</strong> <?php echo $this->GetPagePath(); ?><a title="<?php echo $this->GetTranslation("SearchTitleTip")?>" href="<?php echo $this->config["base_url"].$this->GetTranslation("TextSearchPage").($this->config["rewrite_mode"] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->GetPageTag()); ?>">...</a></span> <?php # if (mysql_num_rows(mysql_query("SELECT status FROM ".$this->config["table_prefix"]."mail where UserTo='".$this->GetUserName()."' and folder='inbox' and status='nicht gelesen' and viewrecipient='Y' LIMIT 1"))!=0) {echo "&nbsp;&nbsp;&nbsp;<img src=\"images/newmessage1.gif\" alt=\"Neue Nachricht\" width=\"18\" height=\"18\" /> <a href='index.php?page=WikiMessenger' title='Du hast mindestens eine neue Nachricht erhalten.'><font color=orangered><strong>&nbsp;Neue Nachricht</strong></font></a>";} ?>

<?php # if ($user = $this->GetUser()) { include("actions/popupchat.php"); } ?>
<?php
// here we show messages
if ($message = $this->GetMessage()) echo "<div class=\"info\">$message</div>";
?>