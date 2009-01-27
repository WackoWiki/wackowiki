<?php 
/*
Default theme.
Common footer file.

Updated by Pavel Fedotov.
*/
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="1" align="left" valign="top" background="<?php echo $this->GetConfigValue("theme_url")."icons/bottom_line.gif"; ?>"><img src="<?php echo $this->GetConfigValue("theme_url")."icons/bottom_line.gif"; ?>" width="61" height="41"></td>
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#990000">

<!-- !! -->
<?php
  if ($this->method == "show") {
?>
<?php
if ($this->HasAccess("read") && $this->GetConfigValue("hide_files") != 1)
{
  // store files display in session
  $tag = $this->GetPageTag();
  if (!isset($_SESSION["show_files"][$tag]))
    $_SESSION["show_files"][$tag] = ($this->UserWantsFiles() ? "1" : "0");
    
  switch($_REQUEST["show_files"])
  {
  case "0":
    $_SESSION["show_files"][$tag] = 0;
    break;
  case "1":
    $_SESSION["show_files"][$tag] = 1;
    break;
  }
  
  // display files!
  if ($this->page && $_SESSION["show_files"][$tag])
  {
    // display files header
    ?>
    <a name="files"></a>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="29" bgcolor="#6E0000">
    <div id="filesheader">
      <?php echo $this->GetResourceValue("Files_all") ?> [<a href="<?php echo $this->href("", "", "show_files=0")."\">".$this->GetResourceValue("HideFiles"); ?></a>]
    </div>
	</td>
        </tr>
        <tr>
          <td height="1" align="left" valign="top" background="<?php echo $this->GetConfigValue("theme_url")."icons/border_line.gif"; ?>"><img src="<?php echo $this->GetConfigValue("theme_url")."icons/border_line.gif"; ?>" width="4" height="5"></td>
        </tr>
      </table>
    <?php
    
    echo "<div class=\"files\">";
    echo $this->Action("files",array("nomark"=>1));
    echo "</div>";
    // display form
    print("<div class=\"filesform\">\n");
    if ($user = $this->GetUser())
    { 
      $user = strtolower($this->GetUserName());
      $registered = true;
    }
    else
      $user = "guest@wacko";

    if ($registered 
        && 
        (
         ($this->config["upload"] === true) || ($this->config["upload"] == "1") ||
         ($this->CheckACL($user,$this->config["upload"]))
        )
       )  
    echo $this->Action("upload",array("nomark"=>1));
    print("</div>\n");
  }
  else
  {
    ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="29" bgcolor="#6E0000">
    <div id="filesheader">
    <?php
      if ($this->page["id"])
       $files = $this->LoadAll( "select id from ".$this->config["table_prefix"]."upload where ".
                             " page_id = '". quote($this->dblink, $this->page["id"]) ."'");
      else $files = array();

      switch (count($files))
      {
      case 0:
        print($this->GetResourceValue("Files_0"));       
        break;
      case 1:
        print($this->GetResourceValue("Files_1"));
        break;
      default:
        print(str_replace("%1",count($files), $this->GetResourceValue("Files_n")));
      }
    ?>
    
    [<a href="<?php echo $this->href("", "", "show_files=1#files")."\">".$this->GetResourceValue("ShowFiles"); ?></a>]

    </div>	</td>
        </tr>
        <tr>
          <td height="1" align="left" valign="top" background="<?php echo $this->GetConfigValue("theme_url")."icons/border_line.gif"; ?>"><img src="<?php echo $this->GetConfigValue("theme_url")."icons/border_line.gif"; ?>" width="4" height="5"></td>
        </tr>
      </table>
    <?php
  }
}
?>

<?php
if ($this->HasAccess("read") && $this->GetConfigValue("hide_comments") != 1)
{
  // load comments for this page
  $comments = $this->LoadComments($this->tag);
  
  // store comments display in session
  $tag = $this->GetPageTag();
  if (!isset($_SESSION["show_comments"][$tag]))
    $_SESSION["show_comments"][$tag] = ($this->UserWantsComments() ? "1" : "0");
    
  switch($_REQUEST["show_comments"])
  {
  case "0":
    $_SESSION["show_comments"][$tag] = 0;
    break;
  case "1":
    $_SESSION["show_comments"][$tag] = 1;
    break;
  }
  
  // display comments!
  if ($this->page && $_SESSION["show_comments"][$tag])
  {
    // display comments header
    ?>
    <a name="comments"></a>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="29" bgcolor="#6E0000">    <div id="commentsheader">
      <?php echo $this->GetResourceValue("Comments_all") ?> [<a href="<?php echo $this->href("", "", "show_comments=0")."\">".$this->GetResourceValue("HideComments"); ?></a>]
    </div></td>
        </tr>
        <tr>
          <td height="1" align="left" valign="top" background="<?php echo $this->GetConfigValue("theme_url")."icons/border_line.gif"; ?>"><img src="<?php echo $this->GetConfigValue("theme_url")."icons/border_line.gif"; ?>" width="4" height="5"></td>
        </tr>
      </table>
    <?php
    
    // display comments themselves
    if ($comments)
    {
      foreach ($comments as $comment)
      {
        print("<a name=\"".$comment["tag"]."\"></a>\n");
        print("<div class=\"comment\">\n");
        $del = "";
        if ($this->IsAdmin() || $this->UserIsOwner($comment["tag"]) || ($this->GetConfigValue("owners_can_remove_comments") && $this->UserIsOwner($this->GetPageTag()))) 
          print("<div style=\"float:right;\" style='background:#ffcfa8; border: solid 1px; border-color:#cccccc'>".
          "<a href=\"".$this->href("remove",$comment["tag"])."\" title=\"".$this->GetResourceValue("DeleteTip")."\">".
          "<img src=\"".$this->GetConfigValue("theme_url")."icons/del.gif\" hspace=4 vspace=4 title=\"".$this->GetResourceValue("DeleteText")."\"  align=\"absmiddle\" border=\"0\" /></a>".
          "</div>");
        print($this->Format($comment["body"])."\n");
        print("<div class=\"commentinfo\">\n-- ".($this->IsWikiName($comment["user"])?$this->Link("/".$comment["user"],"",$comment["user"]):$comment["user"])." (".$comment["time"].")\n</div>\n");
        print("</div>\n");
      }
    }
    
    // display comment form
    print("<div class=\"commentform\">\n");
    if ($this->HasAccess("comment"))
    {
      ?>
        <?php echo $this->GetResourceValue("AttachComment"); ?><br />
        <?php echo $this->FormOpen("addcomment"); ?>
          <textarea name="body" rows="6" style="width: 95%"></textarea><br />
          <input type="submit" value="<?php echo $this->GetResourceValue("AttachCommentButton"); ?>" accesskey="s" />
        <?php echo $this->FormClose(); ?>
      <?php
    }
    print("</div>\n");
  }
  else
  {
    ?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="29" bgcolor="#6E0000">    <div id="commentsheader">
    <?php
      switch (count($comments))
      {
      case 0:
        print($this->GetResourceValue("Comments_0"));       
        break;
      case 1:
        print($this->GetResourceValue("Comments_1"));
        break;
      default:
        print(str_replace("%1",count($comments), $this->GetResourceValue("Comments_n")));
      }
    ?>
    
    [<a href="<?php echo $this->href("", "", "show_comments=1#comments")."\">".$this->GetResourceValue("ShowComments"); ?></a>]

    </div></td>
        </tr>
        <tr>
          <td height="1" align="left" valign="top" background="<?php echo $this->GetConfigValue("theme_url")."icons/border_line.gif"; ?>"><img src="<?php echo $this->GetConfigValue("theme_url")."icons/border_line.gif"; ?>" width="4" height="5"></td>
        </tr>
      </table>
    <?php
  }
}
?>

<?php } //end of $this->method==show
?>
<!-- !!! -->
<?php 
// Opens Search form
echo $this->FormOpen("", $this->GetResourceValue("TextSearchPage"), "get"); ?>
<div class="footer">
<?php

// If User has rights to edit page, show Edit link
echo $this->HasAccess("write") ? "<a href=\"".$this->href("edit")."\" accesskey=\"E\" title=\"".$this->GetResourceValue("EditTip")."\">".$this->GetResourceValue("EditText")."</a> |\n" : "";

// Revisions link
echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetResourceValue("RevisionTip")."\">".$this->GetPageTime()."</a> |\n" : "";

// If this page exists
if ($this->page)
{
 // If owner is current user
 if ($this->UserIsOwner())
 {
   print($this->GetResourceValue("YouAreOwner"));

   // Rename link
   print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetResourceValue("RenameText")."\" alt=\"".$this->GetResourceValue("RenameText")."\" align=\"middle\" border=\"0\" /></a>");
//   if (!$this->GetConfigValue("remove_onlyadmins") || $this->IsAdmin()) print(" <a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1del.gif\" title=\"".$this->GetResourceValue("DeleteTip")."\" alt=\"".$this->GetResourceValue("DeleteText")."\" align=\"middle\" border=\"0\" /></a>");

   //Edit ACLs link
   print(" | <a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetResourceValue("EditACLConfirm")."');\"":"").">".$this->GetResourceValue("EditACLText")."</a>");
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

 // Rename link
 if ($this->CheckACL($this->GetUserName(),$this->config["rename_globalacl"]) && !$this->UserIsOwner())
 {
   print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetResourceValue("RenameText")."\" alt=\"".$this->GetResourceValue("RenameText")."\" align=\"middle\" border=\"0\" /></a>");
 }

 // Remove link (shows only for Admins)
 if ($this->IsAdmin())
 {
   print(" <a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1del.gif\" title=\"".$this->GetResourceValue("DeleteTip")."\" alt=\"".$this->GetResourceValue("DeleteText")."\"  align=\"middle\" border=\"0\" /></a>");
 }

 // Page  settings link
 print(" | <a href=\"".$this->href("settings"). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetResourceValue("EditACLConfirm")."');\"":"").">".$this->GetResourceValue("SettingsText")."</a> | ");
// print("<a href=\"".$this->href("referrers")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/referer.gif\" title=\"".$this->GetResourceValue("ReferrersTip")."\" alt=\"".$this->GetResourceValue("ReferrersText")."\" border=\"0\" align=\"middle\" /></a> |");
}
?>
<?php 
// Watch/Unwatch icon
echo ($this->IsWatched($this->GetUserName(), $this->GetPageTag()) ? "<a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1unvisibl.gif\" title=\"".$this->GetResourceValue("RemoveWatch")."\" alt=\"".$this->GetResourceValue("RemoveWatch")."\"  align=\"middle\" border=\"0\" /></a>" : "<a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/visibl.gif\" title=\"".$this->GetResourceValue("SetWatch")."\" alt=\"".$this->GetResourceValue("SetWatch")."\"  align=\"middle\" border=\"0\" /></a>" ) 
?> | 
<?php 
// Print icon
echo"<a href=\"".$this->href("print")."\" target=\"_new\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1print.gif\" title=\"".$this->GetResourceValue("PrintVersion")."\" alt=\"".$this->GetResourceValue("PrintVersion")."\"  align=\"middle\" border=\"0\" /></a>";

// Searchbar
?> | 
  <span class="searchbar nobr"><?php echo $this->GetResourceValue("SearchText") ?><input type="text" name="phrase" size="15" style="border: none; border-bottom: 1px solid #CCCCAA; padding: 0px; margin: 0px;" /></span>
<?php 

// Search form close
echo $this->FormClose();
?>
</div>
<div class="copyright"><?php 
if ($this->GetUser()){
	echo $this->GetResourceValue("PoweredBy")." ".$this->Link("WackoWiki:HomePage", "", "WackoWiki ".$this->GetWackoVersion());
}
?>
</div>
	  </td>
  </tr>
</table>

<?php

//Debug Querylog.
if ($this->GetConfigValue("debug")>=2)
{
	print("<span class=\"debug\">");
	print("<strong>Query log:</strong><br />\n");
	foreach ($this->queryLog as $query)
	{
		print($query["query"]." (".$query["time"].")<br />\n");
		$zz++;
	}
	print("<b>total: $zz</b>");
	print("</span>");
}

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>