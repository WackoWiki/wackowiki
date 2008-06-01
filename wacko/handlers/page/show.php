<div class="pageBefore"><img
	src="<?php echo $this->GetConfigValue("root_url"); ?>images/z.gif"
	width="1" height="1" border="0" alt="" style="display: block"
	align="top" /></div>
<div class="page"><?php
if ($this->HasAccess("read"))
{
	if (!$this->page)
	{
		if (function_exists("virtual")) header("HTTP/1.0 404 Not Found");
		print(str_replace("%1",$this->href("edit","","",1),$this->GetResourceValue("DoesNotExists")));
	}
	else
	{
		// comment header?
		if ($this->page["comment_on"])
		{
			print("<div class=\"commentinfo\">".$this->GetResourceValue("ThisIsCommentOn")." ".$this->ComposeLinkToPage($this->page["comment_on"], "", "", 0).", ".$this->GetResourceValue("PostedBy")." ".($this->IsWikiName($this->page["user"])?$this->Link($this->page["user"]):$this->page["user"])." ".$this->GetResourceValue("At")." ".$this->page["time"]."</div>");
		}

		if ($this->page["latest"] == "N")
		{
			print("<div class=\"revisioninfo\">".
			str_replace("%1",$this->href(),
			str_replace("%2",$this->GetPageTag(),
			str_replace("%3",$this->page["time"],
			$this->GetResourceValue("Revision")))).".</div>");
		}

		$this->Query("UPDATE ".$this->config["table_prefix"]."pages SET hits=hits+1 WHERE supertag='".quote($this->dblink, $this->GetPageSuperTag())."'");

		$this->SetLanguage($this->pagelang);
		if (($this->page["body_r"] == "") ||
		(($this->page["body_toc"] == "") && $this->GetConfigValue("paragrafica")))
		{
			$this->page["body_r"] = $this->Format($this->page["body"], "wacko");
			if ($this->GetConfigValue("paragrafica"))
			{
				$this->page["body_r"]   = $this->Format($this->page["body_r"], "paragrafica");
				$this->page["body_toc"] = $this->body_toc;
			}
			// store to DB
			if ($this->page["latest"] != "N")
			$this->Query("update ".$this->config["table_prefix"]."pages set ".
         "body_r = '".quote($this->dblink, $this->page["body_r"])."', ".
         "body_toc = '".quote($this->dblink, $this->page["body_toc"])."' ".
         "where id = '".quote($this->dblink, $this->page["id"])."' LIMIT 1");
		}

		// display page
		$data = $this->Format($this->page["body_r"], "post_wacko", array("bad"=>"good"));
		$data = $this->NumerateToc( $data ); //  numerate toc if needed
		echo $data;
		$this->SetLanguage($this->userlang);
		?> <script language="JavaScript" type="text/javascript">
   var dbclick = "page";
  </script> <?php

  // if this is an old revision, display some buttons
  if ($this->HasAccess("write") && ($this->page["latest"] == "N"))
  {
  	$latest = $this->LoadPage($this->tag);
  	?> <br />
  	<?php echo $this->FormOpen("edit") ?> <input type="hidden"
	name="previous" value="<?php echo $latest["time"] ?>" /> <input
	type="hidden" name="body"
	value="<?php echo htmlspecialchars($this->page["body"]) ?>" /> <input
	type="submit"
	value="<?php echo $this->GetResourceValue("ReEditOldRevision") ?>" /> <?php echo $this->FormClose(); ?>
  	<?php
}
}
}
else
{
	if (function_exists("virtual")) header("HTTP/1.0 403 Forbidden");
	print($this->GetResourceValue("ReadAccessDenied"));
}
?> <br style="clear: both" />
&nbsp;</div>
<?php
if ($this->GetConfigValue("footer_files")) {

	if ($this->HasAccess("read") && $this->GetConfigValue("hide_files") != 1 && ($this->GetConfigValue("hide_files") != 2 || $this->GetUser()))
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
<div class="filesheader"><?php echo $this->GetResourceValue("Files_all") ?>
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
    <div class="filesheader">
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

    </div>
    <?php
  }
}
}
?>

<?php
if ($this->GetConfigValue("footer_comments")) {
if ($this->HasAccess("read") && $this->GetConfigValue("hide_comments") != 1 && ($this->GetConfigValue("hide_comments") != 2 || $this->GetUser()))
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
    <div class="commentsheader">
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
          print("<a href=\"".$this->href("remove",$comment["tag"])."\"><img src=\"".$this->GetConfigValue("theme_url")."icons/1del.gif\" hspace=4 vspace=4 title=\"".$this->GetResourceValue("DeleteTipComment")."\" alt=\"".$this->GetResourceValue("DeleteText")."\"  align=\"right\" border=\"0\" /></a>");
        if ($comment["body_r"]) $strings = $comment["body_r"];
        else $strings = $this->Format($comment["body"], "wacko");
        print($this->Format($strings,"post_wacko")."\n");
        print("<div class=\"commentinfo\">\n-- ".($this->IsWikiName($comment["user"])?$this->Link("/".$comment["user"],"",$comment["user"]) : $comment["user"])." (".$comment["time"].")\n</div>\n");
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
          <textarea name="body" rows="6" cols="7" style="width: 100%"></textarea><br />
          <input type="submit" value="<?php echo $this->GetResourceValue("AttachCommentButton"); ?>" accesskey="s" />
        <?php echo $this->FormClose(); ?>
      <?php
    }
    print("</div>\n");
  }
  else
  {
    ?>
    <div class="commentsheader">
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
}
?>