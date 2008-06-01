<?php
// contributed by Nekipelov Alex (mailto:nalex <AT> pisem.net)
?>
<div class="pageBefore"><img
	src="<?php echo $this->GetConfigValue("root_url"); ?>images/z.gif"
	width="1" height="1" border="0" alt="" style="display: block"
	align="top" /></div>
<div class="page"><?php
if ($user = $this->GetUser())
{
	$user = strtolower($this->GetUserName());
	$registered = true;
}
else
$user = "guest@wacko";

if ($registered
&&
($this->CheckACL($user,$this->config["rename_globalacl"]) || strtolower($this->GetPageOwner($this->tag)) == $user)
)
{
	if (!$this->page)
	{
		print(str_replace("%1",$this->href("edit"),$this->GetResourceValue("DoesNotExists")));
	}
	else
	{
		if ($_POST["newname"] && $_POST["rename"]=="1")
		{
			print "<p><b>".$this->GetResourceValue("MassRenaming")."</b><p>";   //!!!
			RecursiveMove($this, $this->tag );
		}
		else
		{
			echo $this->GetResourceValue("MassNewName");
			echo $this->FormOpen("massrename");

			?> <input type="hidden" name="rename" value="1" /> <input type="text"
	name="newname" value="<?php echo $this->tag;?>" size="40" /><br />
			<?php echo "<input type=\"checkbox\" id=\"ch1\" name=\"redirect\"  /> <label for=\"ch1\">".$this->GetResourceValue("MassNeedRedirect")."</label>"; ?>
<br />
<br />

<br />
<input name="submit" class="OkBtn_Top"
	onmouseover='this.className="OkBtn_Top_";'
	onmouseout='this.className="OkBtn_Top";' type="submit" align="top"
	value="<?php echo $this->GetResourceValue("RenameButton"); ?>" /> <img
	src="<?php echo $this->GetConfigValue("root_url");?>images/z.gif"
	width="100" height="1" alt="" border="0" /> <input
	class="CancelBtn_Top" onmouseover='this.className="CancelBtn_Top_";'
	onmouseout='this.className="CancelBtn_Top";' type="button" align="top"
	value="<?php echo str_replace("\n"," ",$this->GetResourceValue("EditCancelButton")); ?>"
	onclick="document.location='<?php echo addslashes($this->href(""))?>';" /><br />
<br />
[<a
	href="<?php echo $this->href("rename" )."\">".$this->GetResourceValue("SettingsRename" ); ?></a>]<br />
<?php echo $this->FormClose();
   }
  }
}
else
{
  print($this->GetResourceValue("NotOwnerAndCantRename"));
}
?>
</div>

<?php

function RecursiveMove(&$parent, $root)
{
  $new_root = trim($_POST["newname"], "/");

  if($root == "/" )  exit; // who and where did intend to move root???

  $query = "'".quote($parent->dblink, $parent->NpjTranslit($root))."%'";
  $pages = $parent->LoadAll("select ".$parent->pages_meta." from ".
           $parent->config["table_prefix"]."pages where supertag like ".$query.
           ($owner?" AND owner='".quote($parent->dblink, $owner)."'":"").
           " and comment_on = ''");
  foreach( $pages as $page )
  {
    $new_name = str_replace( $root, $new_root, $page["tag"] );
    Move( $parent, $page, $new_name );
  }
}

function Move(&$parent, $OldPage, $NewName )
{
//     $NewName = trim($_POST["newname"], "/");
  $user = $parent->GetUser();
  if (($parent->CheckACL($user,$parent->config["rename_globalacl"])
     || strtolower($parent->GetPageOwner($OldPage["tag"])) == $user))
  {
     $supernewname = $parent->NpjTranslit($NewName);

     if (!preg_match("/^([\_\.\-".$parent->language["ALPHANUM_P"]."]+)$/", $NewName))
     {
       print($parent->GetResourceValue("BadName")."<br />\n");
     }
//     if ($OldPage["supertag"] == $supernewname)
     else if ($OldPage["tag"] == $NewName)
     {
       print(str_replace("%1",$parent->Link($NewName),$parent->GetResourceValue("AlredyNamed"))."<br />\n");
     }
     else
     {
      if ($OldPage["supertag"] != $supernewname && $page=$parent->LoadPage($supernewname, "", LOAD_CACHE, LOAD_META)){
       print(str_replace("%1",$parent->Link($NewName),$parent->GetResourceValue("AlredyExists"))."<br />\n");
      }
      else
      {// Rename page

        $need_redirect = 0;
        if ($_POST["redirect"]=="on")  $need_redirect = 1;

        if ($need_redirect==0)
          if ($parent->RemoveReferrers($OldPage["tag"]))
            print("<br />".str_replace("%1",$OldPage["tag"],$parent->GetResourceValue("ReferrersRemoved"))."<br />\n");

        if ($parent->RenameLinks($OldPage["tag"]))
          print(str_replace("%1",$OldPage["tag"],$parent->GetResourceValue("LinksRenamed"))."<br />\n");

        if ($parent->RenamePage($OldPage["tag"], $NewName, $supernewname))
          print(str_replace("%1",$OldPage["tag"],$parent->GetResourceValue("PageRenamed"))."<br />\n");

        if ($parent->RenameAcls($OldPage["tag"], $NewName, $supernewname))
          print(str_replace("%1",$OldPage["tag"],$parent->GetResourceValue("AclsRenamed"))."<br />\n");

       if ($parent->RenameFiles($OldPage["tag"], $NewName, $supernewname))
          print(str_replace("%1",$OldPage["tag"],$parent->GetResourceValue("FilesRenamed"))."<br />\n");

        if ($parent->RenameWatches($OldPage["tag"], $NewName, $supernewname))
          print("\n");

        if ($parent->RenameComments($OldPage["tag"], $NewName, $supernewname))
          print("\n");

        $parent->ClearCacheWantedPage($NewName);
        $parent->ClearCacheWantedPage($supernewname);

        if ($need_redirect==1)
        {
          $parent->CacheWantedPage($OldPage["tag"]);
          $parent->CacheWantedPage($OldPage["supertag"]);

          if ($parent->SavePage($OldPage["tag"], "{{Redirect page=\"/".$NewName."\"}}"))
           print(str_replace("%1",$OldPage["tag"],$parent->GetResourceValue("RedirectCreated"))."<br />\n");

          $parent->ClearCacheWantedPage($OldPage["tag"]);
          $parent->ClearCacheWantedPage($OldPage["supertag"]);
        }

        print("<br />".$parent->GetResourceValue("NewNameOfPage").$parent->Link("/".$NewName));

       }
     }
  }
}
?>