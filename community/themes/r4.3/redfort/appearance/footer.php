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
      <?php echo $this->GetTranslation("Files_all") ?> [<a href="<?php echo $this->href("", "", "show_files=0")."\">".$this->GetTranslation("HideFiles"); ?></a>]
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
        print($this->GetTranslation("Files_0"));
        break;
      case 1:
        print($this->GetTranslation("Files_1"));
        break;
      default:
        print(str_replace("%1",count($files), $this->GetTranslation("Files_n")));
      }
    ?>

    [<a href="<?php echo $this->href("", "", "show_files=1#files")."\">".$this->GetTranslation("ShowFiles"); ?></a>]

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
  $comments = $this->LoadComments($this->GetPageId());

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
      <?php echo $this->GetTranslation("Comments_all") ?> [<a href="<?php echo $this->href("", "", "show_comments=0")."\">".$this->GetTranslation("HideComments"); ?></a>]
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
        if ($this->IsAdmin() || $this->UserIsOwner($comment["id"]) || ($this->GetConfigValue("owners_can_remove_comments") && $this->UserIsOwner($this->GetPageId())))
          print("<div style=\"float:right;\" style='background:#ffcfa8; border: solid 1px; border-color:#cccccc'>".
          "<a href=\"".$this->href("remove",$comment["tag"])."\" title=\"".$this->GetTranslation("DeleteTip")."\">".
          "<img src=\"".$this->GetConfigValue("theme_url")."icons/delete.gif\" hspace=4 vspace=4 title=\"".$this->GetTranslation("DeleteText")."\"  align=\"absmiddle\" border=\"0\" /></a>".
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
        <?php echo $this->GetTranslation("AddComment"); ?><br />
        <?php echo $this->FormOpen("addcomment"); ?>
          <textarea name="body" rows="6" style="width: 95%"></textarea><br />
          <input type="submit" value="<?php echo $this->GetTranslation("AddCommentButton"); ?>" accesskey="s" />
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
        print($this->GetTranslation("Comments_0"));
        break;
      case 1:
        print($this->GetTranslation("Comments_1"));
        break;
      default:
        print(str_replace("%1",count($comments), $this->GetTranslation("Comments_n")));
      }
    ?>

    [<a href="<?php echo $this->href("", "", "show_comments=1#comments")."\">".$this->GetTranslation("ShowComments"); ?></a>]

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
echo $this->FormOpen("", $this->GetTranslation("TextSearchPage"), "get"); ?>
<div class="footer">
<?php

// If User has rights to edit page, show Edit link
echo $this->HasAccess("write") ? "<a href=\"".$this->href("edit")."\" accesskey=\"E\" title=\"".$this->GetTranslation("EditTip")."\">".$this->GetTranslation("EditText")."</a> |\n" : "";

// Revisions link
echo $this->GetPageTime() ? "<a href=\"".$this->href("revisions")."\" title=\"".$this->GetTranslation("RevisionTip")."\">".$this->GetPageTimeFormatted()."</a> |\n" : "";

// If this page exists
if ($this->page)
{
 // If owner is current user
 if ($this->UserIsOwner())
 {
   print($this->GetTranslation("YouAreOwner"));

   // Rename link
   print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetTranslation("RenameText")."\" alt=\"".$this->GetTranslation("RenameText")."\" align=\"middle\" border=\"0\" /></a>");
//   if (!$this->GetConfigValue("remove_onlyadmins") || $this->IsAdmin()) print(" <a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/delete.gif\" title=\"".$this->GetTranslation("DeleteTip")."\" alt=\"".$this->GetTranslation("DeleteText")."\" align=\"middle\" border=\"0\" /></a>");

   //Edit ACLs link
   print(" | <a href=\"".$this->href("acls")."\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("EditACLText")."</a>");
 }
 // If owner is NOT current user
 else
 {
   // Show Owner of this page
   if ($owner = $this->GetPageOwner())
   {
     print($this->GetTranslation("Owner").$this->Link($owner));
   } else if (!$this->page["comment_on_id"]) {
     print($this->GetTranslation("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetTranslation("TakeOwnership")."</a>)" : ""));
   }
 }

 // Rename link
 if ($this->CheckACL($this->GetUserName(),$this->config["rename_globalacl"]) && !$this->UserIsOwner())
 {
   print(" <a href=\"".$this->href("rename")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/rename.gif\" title=\"".$this->GetTranslation("RenameText")."\" alt=\"".$this->GetTranslation("RenameText")."\" align=\"middle\" border=\"0\" /></a>");
 }

 // Remove link (shows only for Admins)
 if ($this->IsAdmin())
 {
   print(" <a href=\"".$this->href("remove")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/delete.gif\" title=\"".$this->GetTranslation("DeleteTip")."\" alt=\"".$this->GetTranslation("DeleteText")."\"  align=\"middle\" border=\"0\" /></a>");
 }

 // Page  settings link
 print(" | <a href=\"".$this->href("settings"). "\"".(($this->method=='edit')?" onclick=\"return window.confirm('".$this->GetTranslation("EditACLConfirm")."');\"":"").">".$this->GetTranslation("SettingsText")."</a> | ");
// print("<a href=\"".$this->href("referrers")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/referer.gif\" title=\"".$this->GetTranslation("ReferrersTip")."\" alt=\"".$this->GetTranslation("ReferrersText")."\" border=\"0\" align=\"middle\" /></a> |");
}
?>
<?php
// Watch/Unwatch icon
echo ($this->IsWatched($this->GetUserId(), $this->GetPageId()) ? "<a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/unwatch.gif\" title=\"".$this->GetTranslation("RemoveWatch")."\" alt=\"".$this->GetTranslation("RemoveWatch")."\"  align=\"middle\" border=\"0\" /></a>" : "<a href=\"".$this->href("watch")."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/watch.gif\" title=\"".$this->GetTranslation("SetWatch")."\" alt=\"".$this->GetTranslation("SetWatch")."\"  align=\"middle\" border=\"0\" /></a>" )
?> |
<?php
// Print icon
echo"<a href=\"".$this->href("print")."\" target=\"_new\"><img src=\"".$this->GetConfigValue("theme_url")."icons/print.gif\" title=\"".$this->GetTranslation("PrintVersion")."\" alt=\"".$this->GetTranslation("PrintVersion")."\"  align=\"middle\" border=\"0\" /></a>";

// Searchbar
?> |
  <span class="searchbar nobr"><?php echo $this->GetTranslation("SearchText") ?><input type="text" name="phrase" size="15" style="border: none; border-bottom: 1px solid #CCCCAA; padding: 0px; margin: 0px;" /></span>
<?php

// Search form close
echo $this->FormClose();
?>
</div>
<div id="credits"><?php
if ($this->GetUser()){
	echo $this->GetTranslation("PoweredBy")." ".$this->Link("WackoWiki:HomePage", "", "WackoWiki ".$this->GetWackoVersion());
}
?>
</div>
	  </td>
  </tr>
</table>

<?php

// Don't place final </body></html> here. Wacko closes HTML automatically.
?>