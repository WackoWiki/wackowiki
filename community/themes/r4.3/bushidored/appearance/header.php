<?php
/*
Bushido Alfeld e.V. theme
created by yourhp.de

Common header file.

*/

// Wacko can show message (by javascript) 
  $message = $this->GetMessage();

// HTTP header with right Charset settings
  header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>
<?php 
// Echoes Title of the page.
  echo $this->GetWakkaName()." : ".$this->AddSpaces($this->GetPageTag()).($this->method!="show"?" (".$this->method.")":""); 
?>
</title>
<?php 
// We don't need search robots to index subordinate pages
  if ($this->GetMethod() != 'show' || $this->page["latest"] == "N")
     echo "<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
?>
<meta name="keywords" content="<?php echo $this->GetKeywords(); ?>" />
<meta name="description" content="<?php echo $this->GetDescription(); ?>" />
<meta http-equiv="content-type" content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->GetConfigValue("theme_url") ?>css/wakkastyle.css" />
<link rel="shortcut icon" href="<?php echo $this->GetConfigValue("theme_url") ?>icons/wacko.ico" type="image/x-icon" />
<link rel="alternate" type="application/rss+xml" title="RecentChanges in RSS" href="<?php echo $this->GetConfigValue("root_url");?>xml/recentchanges_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name")));?>.xml" />
<link rel="alternate" type="application/rss+xml" title="History/revisions of <?php echo $this->tag; ?> in RSS" href="<?php echo $this->href("revisions.xml");?>" />
<?php 
// Three JS files.
// default.js contains common procedures and should be included everywhere
// protoedit & wikiedit2.js contain classes for WikiEdit editor. We may include them only on method==edit pages
?>
<script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/default.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/protoedit.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/wikiedit2.js"></script>
<?php 
// Doubleclick edit feature.
// Enabled only for registered users who don't swith it off.
if ($user = $this->GetUser()) 
if ($user["doubleclickedit"] == "Y") {?>
<script language="JavaScript" type="text/javascript">
   var edit = "<?php echo $this->href("edit");?>";
  </script>
<?php }
?>
</head>
<?php
// all_init() initializes all js features:
//   * WikiEdit
//   * Doubleclick editing
//   * Smooth scrolling
// Also, here we show message (see beginning of this file)
?>
<body onload="all_init();<?php if ($message) echo "alert('".$message."');";?>">
<div id="container">
<?php
// Outputs page title
?>
<div id="header">
  <h1>&nbsp;</h1>
</div>
<div id="navigation">
  <?php 
// Outputs Bookmarks AKA QuickLinks
  // Main page
  echo $this->ComposeLinkToPage($this->config["root_page"]); ?>
  <br />
  <?php 
  // All user's Bookmarks
  echo $this->Format(implode( "\n", $this->GetBookmarks())); ?>
  <br />
  <?php 
  // Here Wacko determines what it should show: "add to Bookmarks" or "remove from Bookmarks" icon
if ($this->GetUser()) 
{
 if (!in_array($this->GetPageSuperTag(),$this->GetBookmarkLinks()))
 {?>
  <a href="<?php echo $this->Href('', '', "addbookmark=yes")?>"><img src="<?php echo $this->GetConfigValue("theme_url") ?>icons/toolbar1.gif" alt="+" title="<?php echo $this->GetResourceValue("AddToBookmarks") ?>" border="0" align="middle" /></a> <br />
  <?php 
 } else { ?>
  <a href="<?php echo $this->Href('', '', "removebookmark=yes")?>"><img src="<?php echo $this->GetConfigValue("theme_url") ?>icons/toolbar2.gif" alt="-" title="<?php echo $this->GetResourceValue("RemoveFromBookmarks") ?>" border="0" align="middle" /></a> <br />
  <?php 
 }
} 

// If user are logged, Wacko shows "You are UserName" 
if ($this->GetUser()) { ?>
  <span class="nobr"><?php echo $this->GetResourceValue("YouAre")." ".$this->Link($this->GetUserName()) ?></span><br />
  <small>( <span class="nobr Tune">
  <?php 
      echo $this->ComposeLinkToPage($this->GetResourceValue("YouArePanelLink"), "", $this->GetResourceValue("YouArePanelName"), 0); ?>
  | <a onclick="return confirm('<?php echo $this->GetResourceValue("LogoutAreYouSure");?>');" href="<?php echo $this->Href("",$this->GetResourceValue("LoginPage")).($this->config["rewrite_mode"] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->SlimUrl($this->tag);?>"><?php echo $this->GetResourceValue("LogoutLink"); ?></a></span> )</small>
  <?php 
// Else Wacko shows login's controls
} else { 
?>
  <div class="nobr"> <br />
    <?php 
// Begin Login form
echo $this->FormOpen("", $this->GetResourceValue("LoginPage"), "post"); ?>
    <input type="hidden" name="action" value="login" />
    <input type="hidden" name="goback" value="<?php echo $this->SlimUrl($this->tag);?>" />
    <?php echo $this->GetResourceValue("LoginWelcome") ?>:<br />
    <input type="text" name="name" size="18" class="login" alt="username" />
    <br />
    <?php echo $this->GetResourceValue("LoginPassword") ?>:<br />
    <input type="password" name="password" class="login" size="8" alt="password" />
    <br />
    <input type="image" src="<?php echo $this->GetConfigValue("theme_url") ?>icons/login.gif" alt=">>>" align="top" />
    <?php // Closing Login form
echo $this->FormClose(); 
?>
  </div>
  <?php 
}
// End if 
?>
  <br />
  <hr width="80%" noshade="noshade" />
  <?php 
// If this page exists
if ($this->page)
{
 // If owner is current user
 if ($this->UserIsOwner())
 {
   print($this->GetResourceValue("YouAreOwner")."<br /> \n");

   // Rename link
   print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetResourceValue("RenameText")."\" alt=\"".$this->GetResourceValue("RenameText")."\" align=\"middle\" border=\"0\" />&nbsp;".$this->GetResourceValue("RenameText")."</a><br /> \n");
//   if (!$this->GetConfigValue("remove_onlyadmins") || $this->IsAdmin()) print(" <a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1del.gif\" title=\"".$this->GetResourceValue("DeleteTip")."\" alt=\"".$this->GetResourceValue("DeleteText")."\" align=\"middle\" border=\"0\" /></a>");

   //Edit ACLs link
   print("<a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetResourceValue("EditACLConfirm")."');\"":"").">".$this->GetResourceValue("EditACLText")."</a>");
 }
 // If owner is NOT current user
 else
 {
   // Show Owner of this page
   if ($owner = $this->GetPageOwner())
   {
     print($this->GetResourceValue("Owner").$this->Link($owner));
   } else if (!$this->page["comment_on"]) {
     print($this->GetResourceValue("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetResourceValue("TakeOwnership")."</a>)" : ""));
   }
 }
// If User has rights to edit page, show Edit link
echo $this->HasAccess("write") ? "<br /><a href=\"".$this->href("edit")."\" accesskey=\"E\" title=\"".$this->GetResourceValue("EditTip")."\">".$this->GetResourceValue("EditText")."</a>" : "";
?>
  <br />
  <?php
// Watch/Unwatch icon
echo ($this->IsWatched($this->GetUserName(), $this->GetPageTag()) ? "<a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1unvisibl.gif\" title=\"".$this->GetResourceValue("RemoveWatch")."\" alt=\"".$this->GetResourceValue("RemoveWatch")."\"  align=\"middle\" border=\"0\" />&nbsp;".$this->GetResourceValue("RemoveWatch")."</a>" : "<a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/visibl.gif\" title=\"".$this->GetResourceValue("SetWatch")."\" alt=\"".$this->GetResourceValue("SetWatch")."\"  align=\"middle\" border=\"0\" />&nbsp;".$this->GetResourceValue("SetWatch")."</a>" );
?>
  <br />
  <?php 
 // Rename link
 if ($this->CheckACL($this->GetUserName(),$this->config["rename_globalacl"]) && !$this->UserIsOwner())
 {
   print("<a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetResourceValue("RenameText")."\" alt=\"".$this->GetResourceValue("RenameText")."\" align=\"middle\" border=\"0\" />&nbsp;".$this->GetResourceValue("RenameText")."</a><br />");
 }
 // Page  settings link
 print("<a href=\"".$this->href("settings"). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetResourceValue("EditACLConfirm")."');\"":"").">".$this->GetResourceValue("SettingsText")."</a><br />");
// print("<a href=\"".$this->href("referrers")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/referer.gif\" title=\"".$this->GetResourceValue("ReferrersTip")."\" alt=\"".$this->GetResourceValue("ReferrersText")."\" border=\"0\" align=\"middle\" /></a> |");
}
// Print icon
echo"<a href=\"".$this->href("print")."\" target=\"_new\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1print.gif\" title=\"".$this->GetResourceValue("PrintVersion")."\" alt=\"".$this->GetResourceValue("PrintVersion")."\"  align=\"middle\" border=\"0\" />&nbsp;".$this->GetResourceValue("PrintVersion")."</a><br />";
// Remove link (shows only for Admins)
if ($this->IsAdmin()){
	print("<a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1del.gif\" title=\"".$this->GetResourceValue("DeleteTip")."\" alt=\"".$this->GetResourceValue("DeleteText")."\"  align=\"middle\" border=\"0\" />&nbsp;".$this->GetResourceValue("DeleteTip")."</a>");
}
// Searchbar
// Opens Search form
echo $this->FormOpen("", $this->GetResourceValue("TextSearchPage"), "get"); ?>
  <p><?php echo $this->GetResourceValue("SearchText") ?><br />
    <input type="text" name="phrase" size="15" class="searchbar" alt="searchbar" />
  </p>
  <?php 
// Search form close
echo $this->FormClose(); 
?>
</div>
<div id="content">
<div id="text">
<div class="Text">
<span class="main"><?php echo $this->config["wakka_name"] ?>:</span> <?php echo $this->GetPagePath(); ?> <a class="Search" title="<?php echo $this->GetConfigValue("search_title_help")?>" 
     href="<?php echo $this->config["base_url"].$this->GetResourceValue("TextSearchPage").($this->config["rewrite_mode"] ? "?" : "&amp;") ?>phrase=<?php echo urlencode($this->GetPageTag()); ?>">...</a>