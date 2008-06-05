<?php
/*
Samsra theme.

Common header file.

Commented by Roman Ivanov.
*/

// Wacko can show message (by javascript) 
  $message = $this->GetMessage();

// HTTP header with right Charset settings
  header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title><?php 
// Echoes Title of the page.
  echo $this->GetWakkaName()." : ".$this->AddSpaces($this->GetPageTag()).($this->method!="show"?" (".$this->method.")":""); 
?></title>
<?php 
// We don't need search robots to index subordinate pages
  if ($this->GetMethod() != 'show' || $this->page["latest"] == "N")
     echo "<meta name=\"robots\" content=\"noindex, nofollow\" />\n";
?>
  <meta name="keywords" content="<?php echo $this->GetKeywords(); ?>" />
  <meta name="description" content="<?php echo $this->GetDescription(); ?>" />
  <meta http-equiv="content-type" content="text/html; charset=<?php echo $this->GetCharset(); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo $this->GetConfigValue("theme_url") ?>css/wakka.css" />
  <link rel="shortcut icon" href="<?php echo $this->GetConfigValue("theme_url") ?>icons/wacko.ico" type="image/x-icon" />
  <link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetResourceValue("RecentChangesRSS");?>" href="<?php echo $this->GetConfigValue("root_url");?>xml/recentchanges_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name")));?>.xml" />
  <link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetResourceValue("RecentCommentsRSS");?>" href="<?php echo $this->GetConfigValue("root_url");?>xml/recentcomment_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name")));?>.xml" />
  <link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetResourceValue("HistoryRevisionsRSS");?><?php echo $this->tag; ?> in RSS" href="<?php echo $this->href("revisions.xml");?>" />
<?php 
// Three JS files.
// default.js contains common procedures and should be included everywhere
// protoedit & wikiedit2.js contain classes for WikiEdit editor. We may include them only on method==edit pages
?>
  <script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/default.js"></script>
  <script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/protoedit.js"></script>
  <script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/wikiedit2.js"></script>
  <script language="JavaScript" type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/autocomplete.js"></script>
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


<div class="header">
<?php
// Outputs page title
?>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr>
  		<td>
<!-- <h1>-->  
     <span class="main"><?php echo $this->config["wakka_name"] ?>:</span>
     <span class="pagetitle"><?php echo $this->GetPagePath(); ?></span>
     <a class="Search" title="<?php echo $this->GetConfigValue("search_title_help")?>" 
     href="<?php echo $this->config["base_url"].$this->GetResourceValue("TextSearchPage").($this->config["rewrite_mode"] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->GetPageTag()); ?>">...</a><br />
<!-- </h1> -->  
</td><td>
<?php 
/*
Samsra theme.

Commented by Roman Ivanov.
*/

// Opens Search form
echo $this->FormOpen("", $this->GetResourceValue("TextSearchPage"), "get"); ?>
<div align="right">
<?php 
// Searchbar
?>
  <span><?php echo $this->GetResourceValue("SearchText") ?><input type="text" name="phrase" size="15" style="border: none; border-bottom: 1px solid #CCCCAA; padding: 0px; margin: 0px;" /><input  class="submitinput" type="submit" value="&raquo;" alt="<?php echo $this->GetResourceValue("SearchButtonText"); ?>!" title="<?php echo $this->GetResourceValue("SearchButtonText"); ?>!" /></span>
</div>
<?php 

// Search form close
echo $this->FormClose(); 
?>
</td>
	</tr>
</table>
<?php 
// Begin Login form
echo $this->FormOpen("", $this->GetResourceValue("LoginPage"), "post"); ?>
      <input type="hidden" name="action" value="login" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> 
      <?php 
// Outputs Bookmarks AKA QuickLinks
  // Main page
  echo $this->ComposeLinkToPage($this->config["root_page"]); ?>
|
<?php 
  // All user's Bookmarks
  echo $this->Format($this->GetBookmarksFormatted(), "post_wacko"); ?>
|
<?php 
  // Here Wacko determines what it should show: "add to Bookmarks" or "remove from Bookmarks" icon
if ($this->GetUser()) 
{
 if (!in_array($this->GetPageSuperTag(),$this->GetBookmarkLinks()))
 {?>
<a href="<?php echo $this->Href('', '', "addbookmark=yes")?>"><img src="<?php echo $this->GetConfigValue("theme_url") ?>icons/toolbar1.gif" alt="+" title="<?php echo $this->GetResourceValue("AddToBookmarks") ?>" /></a>
<?php 
 } else { ?>
<a href="<?php echo $this->Href('', '', "removebookmark=yes")?>"><img src="<?php echo $this->GetConfigValue("theme_url") ?>icons/toolbar2.gif" alt="-" title="<?php echo $this->GetResourceValue("RemoveFromBookmarks") ?>" /></a><?php  }
} ?></td>
    <td align="right"><?php 


// If user are logged, Wacko shows "You are UserName" 
if ($this->GetUser()) { ?>
      <span class="nobr"><?php echo $this->GetResourceValue("YouAre")." ".$this->Link($this->GetUserName()) ?></span> <small>( <span class="nobr Tune">
      <?php 
      echo $this->ComposeLinkToPage($this->GetResourceValue("YouArePanelLink"), "", $this->GetResourceValue("YouArePanelName"), 0); ?>
| <a onclick="return confirm('<?php echo $this->GetResourceValue("LogoutAreYouSure");?>');" href="<?php echo $this->Href("",$this->GetResourceValue("LoginPage")).($this->config["rewrite_mode"] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->SlimUrl($this->tag);?>"><?php echo $this->GetResourceValue("LogoutLink"); ?></a></span> )</small>
      <?php 
// Else Wacko shows login's controls
} else { 
?>
      <span class="nobr">
      <input type="hidden" name="goback" value="<?php echo $this->SlimUrl($this->tag);?>" 
/>
      <strong><?php echo $this->GetResourceValue("LoginWelcome") ?>:&nbsp;</strong>
      <input 
type="text" name="name" size="18" class="login" />
      &nbsp;
      <?php 
echo $this->GetResourceValue("LoginPassword") ?>
      :&nbsp;
      <input type="password" name="password"  
class="login" size="8" />
      &nbsp;
      <input name="image" type="image" 
src="<?php echo $this->GetConfigValue("theme_url") ?>icons/login.gif" alt=">>>" align="top" />
      </span>
      <?php 
}
// End if 
?></td>
  </tr>
</table>
<?php 
// Closing Login form
echo $this->FormClose(); 
?>
</div>



