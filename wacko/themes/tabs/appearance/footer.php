<div class="Footer"><img
   src="<?php echo $this->GetConfigValue("root_url");?>images/z.gif"
   width="5" height="1" alt="" align="left" border="0" /><img
   src="<?php echo $this->GetConfigValue("root_url");?>images/z.gif"
   width="5" height="1" alt="" align="right" border="0" /> <?php $this->EchoTab( $this->href("show"),  $this->GetResourceValue("ShowTip"),
   $this->HasAccess("read") ? $this->GetResourceValue("ShowText") : "",
   $this->method != "show"
   ) ?> <?php $this->EchoTab( $this->href("edit"),  $this->GetResourceValue("EditTip"),
   $this->HasAccess("write") ? $this->GetResourceValue("EditText") : "",
   $this->method != "edit"
   ) ?> <?php $this->EchoTab( $this->href("revisions"),  $this->GetResourceValue("RevisionTip"),
   $this->GetPageTime() ? $this->GetPageTime() : "",
   $this->method != "revisions"
   ) ?> <?php
   // if this page exists
   if ($this->page)
   {
      if($this->HasAccess("write") && $this->GetUser() || $this->IsAdmin())
      {
         $this->EchoTab( $this->href("settings"),  $this->GetResourceValue("SettingsTip"),
         $this->GetResourceValue("EditSettingsText"),
         $this->method != "settings"
         );
      }

      // if owner is current user
      if ($this->UserIsOwner())
      {
         $this->EchoTab( $this->href("acls"),  "".(($this->method=='edit')?"' onclick='return window.confirm(\"".$this->GetResourceValue("EditACLConfirm")."\");":""),
         $this->GetResourceValue("EditACLText"),
         $this->method != "acls"
         );
      }
      if ($this->IsAdmin() || (!$this->GetConfigValue("remove_onlyadmins") && $this->UserIsOwner()))
      {
         $this->EchoTab( $this->href("remove"),  $this->GetResourceValue("DeleteTip")."",
                        '<img src="'.$this->GetConfigValue("theme_url").'icons/del'.($this->method != "remove"?"":"_").'.gif" width="14" height="15" alt="" />'.$this->GetResourceValue("DeleteText"),
         $this->method != "remove",
                        "2a"
                        );
      }
   }
   ?> <?php
   if ($this->GetUser())
   {
      $this->EchoTab( $this->href("referrers"),  $this->GetResourceValue("ReferrersTip"),
      $this->GetResourceValue("ReferrersText"),
      $this->method != "referrers",
         "2"
         );
   }  ?>
<div class="TabSpace">
<div class="TabText" style="padding-left: 10px"><?php
// if this page exists
if ($this->page)
{
   // if owner is current user
   if ($this->UserIsOwner())
   print($this->GetResourceValue("YouAreOwner"));
   else
   if ($owner = $this->GetPageOwner())
   print($this->GetResourceValue("Owner").$this->Link($owner));
   else if (!$this->page["comment_on"])
   print($this->GetResourceValue("Nobody").($this->GetUser() ? " (<a href=\"".$this->href("claim")."\">".$this->GetResourceValue("TakeOwnership")."</a>)" : ""));
}
?></div>
</div>
</div>
</div>
<!-- !! -->
<?php
if ($this->method == "show") {
   ?>
   <?php
   if ($this->HasAccess("read") && $this->GetConfigValue("hide_files") != 1 && ($this->GetConfigValue("hide_files") != 2 || $this->GetUser()))
   {
      // store files display in session
      $tag = $this->GetPageTag();
      if (!isset($_SESSION[$this->config["session_prefix"].'_'."show_files"][$tag]))
      $_SESSION[$this->config["session_prefix"].'_'."show_files"][$tag] = ($this->UserWantsFiles() ? "1" : "0");

      switch($_REQUEST["show_files"])
      {
         case "0":
            $_SESSION[$this->config["session_prefix"].'_'."show_files"][$tag] = 0;
            break;
         case "1":
            $_SESSION[$this->config["session_prefix"].'_'."show_files"][$tag] = 1;
            break;
      }

      // display files!
      if ($this->page && $_SESSION[$this->config["session_prefix"].'_'."show_files"][$tag])
      {
         // display files header
         ?>
<a name="files"></a>
<div id="filesheader"><?php echo $this->GetResourceValue("Files_all") ?>
[<a
   href="<?php echo $this->href("", "", "show_files=0")."\">".$this->GetResourceValue("HideFiles"); ?></a>]
    </div>
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
    <div id="filesheader">
<?php
      if ($this->page["id"])
       $files = $this->LoadAll( "SELECT id FROM ".$this->config["table_prefix"]."upload WHERE ".
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

    </div>
    <?php
  }
}
?>

<?php
if ($this->HasAccess("read") && $this->GetConfigValue("hide_comments") != 1 && ($this->GetConfigValue("hide_comments") != 2 || $this->GetUser()))
{
  // load comments for this page
  $comments = $this->LoadComments($this->tag);

  // store comments display in session
  $tag = $this->GetPageTag();
  if (!isset($_SESSION[$this->config["session_prefix"].'_'."show_comments"][$tag]))
    $_SESSION[$this->config["session_prefix"].'_'."show_comments"][$tag] = ($this->UserWantsComments() ? "1" : "0");

  switch($_REQUEST["show_comments"])
  {
  case "0":
    $_SESSION[$this->config["session_prefix"].'_'."show_comments"][$tag] = 0;
    break;
  case "1":
    $_SESSION[$this->config["session_prefix"].'_'."show_comments"][$tag] = 1;
    break;
  }

  // display comments!
  if ($this->page && $_SESSION[$this->config["session_prefix"].'_'."show_comments"][$tag])
  {
    // display comments header
    ?>
    <a name="comments"></a>
<div id="commentsheader">
<?php echo $this->GetResourceValue("Comments_all") ?> [<a href="<?php echo $this->href("", "", "show_comments=0")."\">".$this->GetResourceValue("HideComments"); ?></a>]
    </div>
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
          "<img src=\"".$this->GetConfigValue("theme_url")."icons/del.gif\" hspace=4 vspace=4 title=\"".$this->GetResourceValue("DeleteText")."\" /></a>".
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
          <textarea name="body" rows="6" style="width: 95%">
</textarea>
<br />
<input type="submit" value="<?php echo $this->GetResourceValue("AttachCommentButton"); ?>" accesskey="s" />
<?php echo $this->FormClose(); ?>
<?php
    }
    print("</div>\n");
  }
  else
  {
    ?>
<div id="commentsheader">
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

    </div>
    <?php
  }
}
?>

<?php } //end of $this->method==show
?>
<!-- !!! -->

<div id="copyright">
  <?php
if ($this->GetUser()){
echo $this->GetResourceValue("PoweredBy")." ".$this->Link("WackoWiki:HomePage", "", "WackoWiki ".$this->GetWackoVersion())." :: Redesign by Mendokusee";
}
?>
</div>
<?php
  if ($this->GetConfigValue("debug")>=2)
  {
    print("<span class=\"debug\"><strong>Query log:</strong><br />\n");
    foreach ($this->queryLog as $query)
    {
      print($query["query"]." (".$query["time"].")<br />\n");
    }
    print("</span>");
  }
//don't place final </body></html> here. Wacko closes HTML automatically.
?>
