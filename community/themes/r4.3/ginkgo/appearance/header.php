<?php
/*
Ginko theme.
Common header file.
Commented by Roman Ivanov.
*/

// Wacko can show message (by javascript) 
  $message = $this->GetMessage();

// HTTP header with right Charset settings
  header("Content-Type: text/html; charset=".$this->GetCharset());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->page["lang"] ?>" lang="<?php echo $this->page["lang"] ?>">
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
<link rel="stylesheet" type="text/css" href="<?php echo $this->GetConfigValue("theme_url") ?>css/wakka.css" />
<link rel="shortcut icon" href="<?php echo $this->GetConfigValue("theme_url") ?>icons/favicon.ico" type="image/x-icon" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetResourceValue("RecentChangesRSS");?>" href="<?php echo $this->GetConfigValue("root_url");?>xml/recentchanges_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name")));?>.xml" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetResourceValue("RecentCommentsRSS");?>" href="<?php echo $this->GetConfigValue("root_url");?>xml/recentcomment_<?php echo preg_replace("/[^a-zA-Z0-9]/", "", strtolower($this->GetConfigValue("wakka_name")));?>.xml" />
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->GetResourceValue("HistoryRevisionsRSS");?><?php echo $this->tag; ?>" href="<?php echo $this->href("revisions.xml");?>" />
<?php 
// Three JS files.
// default.js contains common procedures and should be included everywhere
// protoedit & wikiedit2.js contain classes for WikiEdit editor. We may include them only on method==edit pages
?>
<script type="text/javascript" src="<?php echo $this->GetConfigValue("root_url"); ?>js/default.js"></script>
<script type="text/javascript" src="<?php echo $this->GetConfigValue("root_url"); ?>js/protoedit.js"></script>
<script type="text/javascript" src="<?php echo $this->GetConfigValue("root_url"); ?>js/wikiedit2.js"></script>
<script type="text/javascript" src="<?php echo $this->GetConfigValue("root_url"); ?>js/autocomplete.js"></script>
<script type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/swfobject.js"></script>
<script type="text/javascript" src="<?php echo $this->GetConfigValue("root_url");?>js/captcha.js"></script>
<?php 
// Doubleclick edit feature.
// Enabled only for registered users who don't swith it off.
if ($user = $this->GetUser()) 
if ($user["doubleclickedit"] == "Y") {?>
<script type="text/javascript">
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="378" valign="bottom" nowrap="nowrap"><span class="main"><a href="<?php echo $this->GetConfigValue("root_url")?>"class="main"><?php echo $this->config["wakka_name"] ?></a></span></td>
    <td width="100%"><?php 
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
        <span><?php echo $this->GetResourceValue("SearchText") ?>
        <input type="text" name="phrase" size="15" style="border: none; border-bottom: 1px solid #CCCCAA; padding: 0px; margin: 0px;" />
        </span></div>
      <?php 

// Search form close
echo $this->FormClose(); 
?></td>
  </tr>
  <tr>
    <td valign="top"><div class="tagline">Placeholder</div></td>
    <td width="100%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#5C743D"></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#85a43c"></td>
  </tr>
  <tr bgcolor="#85a43c">
    <td height="20" colspan="2"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><div class="navText"><strong><?php echo $this->ComposeLinkToPage($this->config["root_page"]);?>:</strong> <?php echo $this->GetPagePath(); ?> <a title="<?php echo $this->GetResourceValue("SearchTitleTip")?>" 
     href="<?php echo $this->config["base_url"].$this->GetResourceValue("TextSearchPage").($this->config["rewrite_mode"] ? "?" : "&amp;");?>phrase=<?php echo urlencode($this->GetPageTag()); ?>">...</a></div></td>
          <td align="right"><?php 
// If user are logged, Wacko shows "You are UserName" 
if ($this->GetUser()) {
?>
            <span class="nobr"><?php echo $this->GetResourceValue("YouAre")." ".$this->Link($this->GetUserName()) ?></span> <small>( <span class="nobr Tune">
            <?php 
      echo $this->ComposeLinkToPage($this->GetResourceValue("YouArePanelLink"), "", $this->GetResourceValue("YouArePanelName"), 0); ?>
            | <a onclick="return confirm('<?php echo $this->GetResourceValue("LogoutAreYouSure");?>');" href="<?php echo $this->Href("",$this->GetResourceValue("LoginPage")).($this->config["rewrite_mode"] ? "?" : "&amp;");?>action=logout&amp;goback=<?php echo $this->SlimUrl($this->tag);?>"><?php echo $this->GetResourceValue("LogoutLink"); ?></a></span> )</small>
            <?php 
// Else Wacko shows login's controls
} 
// End if  
?></td>
        </tr>
        <?php 
// Closing Login form, If user are logged
if ($this->GetUser()) {
echo $this->FormClose(); 
} 
// End if  
?>
      </table></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#99CC66"></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#5C743D"></td>
  </tr>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
  <td valign="top" class="left" width="185" nowrap="nowrap"><table width="185" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr align="left">
        <td><div>
            <?php
		# echo '<br />';				
        # echo "<hr color=#CCCCCC noshade size=1 />";
		echo '<div class="leftNav"><ul class="leftNav"><li>';  

// Bookmarks
$BMs = $this->GetBookmarks();
$formatedBMs =  $this->Format($this->Format(implode("| ", $BMs), "wacko"), "post_wacko");
$formatedBMs = str_replace ( "| ", "</li><li>\n", $formatedBMs );
echo $formatedBMs;
echo "</li></ul></div>";
        # echo "<hr color=#CCCCCC noshade size=1 />";
		echo '<br />';	
       if ($this->GetUser()) {
			if (!in_array($this->GetPageSuperTag(),$this->GetBookmarkLinks())) {?>
            <a href="<?php echo $this->Href('', '', "addbookmark=yes")?>"> <img src="<?php echo $this->GetConfigValue("theme_url") ?>icons/toolbar1.gif" border="0" align="bottom" style="vertical-align: middle; "/> <?php echo $this->GetResourceValue("Bookmarks"); ?> </a>
            <?php } else { ?>
            <a href="<?php echo $this->Href('', '', "removebookmark=yes")?>"> <img src="<?php echo $this->GetConfigValue("theme_url") ?>icons/toolbar2.gif" border="0" align="bottom" style="vertical-align: middle; "/> <?php echo $this->GetResourceValue("Bookmarks"); 
?> </a>
            <?php 
}
echo "<hr noshade=\"noshade\" size=\"1\" />";	
echo "<div class=\"copyright\">";
print $this->Format( '{{hits}} Aufrufe' );
echo "</div>";
}
?>
            <div>
              <?php 
        					#    if ($this->UserIsOwner()) {
		                    #   		echo "<hr color=#CCCCCC noshade size=1 />";
							#		print($this->GetResourceValue("YouAreOwner"));
							#    } else {
		                    #  		echo "<hr noshade=\"noshade\" size=\"1\" />";
							#    	if ($owner = $this->GetPageOwner()) {
							#        print($this->GetResourceValue("Owner").$this->Link($owner));
							#      } else if (!$this->page["comment_on"]) {
							#        print($this->GetResourceValue("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetResourceValue("TakeOwnership")."</a>)" : ""));
							#      }
								
							# }
							# echo '<br />';
							?>
            </div>
          </div></td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table></td>
  <td>