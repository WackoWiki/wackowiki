<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href('show'));

// deny for comment
if ($this->page['comment_on'])
	$this->Redirect($this->href('', $this->page['comment_on'], 'show_comments=1').'#'.$this->page['tag']);

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
		print(str_replace("%1",$this->href("edit"),$this->GetTranslation("DoesNotExists")));
	}
	else
	{
		if ($_POST["newname"] && $_POST["rename"] == "1")
		{
		
		// rename or massrename
		$need_massrename = 0;
		if ($_POST["massrename"] == "on")  $need_massrename = 1;
		
			// rename
			if ($need_massrename == 0)
			{
						
				$NewName = trim($_POST["newname"], "/");

				$supernewname = $this->NpjTranslit($NewName);

				if (!preg_match("/^([\_\.\-".$this->language["ALPHANUM_P"]."]+)$/", $NewName))
				{
					print($this->GetTranslation("BadName")."<br />\n");
				}
				//     if ($this->supertag == $supernewname)
				else if ($this->tag == $NewName)
				{
					print(str_replace("%1",$this->Link($NewName),$this->GetTranslation("AlreadyNamed"))."<br />\n");
				}
				else
				{
					if ($this->supertag != $supernewname && $page=$this->LoadPage($supernewname, "", LOAD_CACHE, LOAD_META)){
						print(str_replace("%1",$this->Link($NewName),$this->GetTranslation("AlredyExists"))."<br />\n");
					}
					else
					{// Rename page

						$need_redirect = 0;
						if ($_POST["redirect"]=="on")  $need_redirect = 1;

						if ($need_redirect==0)
						if ($this->RemoveReferrers($this->tag))
						print(str_replace("%1",$this->tag,$this->GetTranslation("ReferrersRemoved"))."<br />\n");

						if ($this->RenameLinks($this->tag))
						print(str_replace("%1",$this->tag,$this->GetTranslation("LinksRenamed"))."<br />\n");

						if ($this->RenamePage($this->tag, $NewName, $supernewname))
						print(str_replace("%1",$this->tag,$this->GetTranslation("PageRenamed"))."<br />\n");

						if ($this->RenameAcls($this->tag, $NewName, $supernewname))
						print(str_replace("%1",$this->tag,$this->GetTranslation("AclsRenamed"))."<br />\n");

						if ($this->RenameFiles($this->tag, $NewName, $supernewname))
						print(str_replace("%1",$this->tag,$this->GetTranslation("FilesRenamed"))."<br />\n");

						if ($this->RenameWatches($this->tag, $NewName, $supernewname))
						print("\n");

						if ($this->RenameComments($this->tag, $NewName, $supernewname))
						print("\n");

						$this->ClearCacheWantedPage($NewName);
						$this->ClearCacheWantedPage($supernewname);

						if ($need_redirect==1)
						{
							$this->CacheWantedPage($this->tag);
							$this->CacheWantedPage($this->supertag);

							if ($this->SavePage($this->tag, "{{Redirect page=\"/".$NewName."\"}}"))
							print(str_replace("%1",$this->tag,$this->GetTranslation("RedirectCreated"))."<br />\n");

							$this->ClearCacheWantedPage($this->tag);
							$this->ClearCacheWantedPage($this->supertag);
						}

						print("<br />".$this->GetTranslation("NewNameOfPage").$this->Link("/".$NewName));

					}
				}
			}
			
			//massrename
			if ($need_massrename == 1)
			{
				print "<p><b>".$this->GetTranslation("MassRenaming")."</b><p>";   //!!!
				RecursiveMove($this, $this->tag );
			}
		}
		else
		{
			echo $this->GetTranslation("NewName");
			echo $this->FormOpen("rename");

			?>
  <input type="hidden" name="rename" value="1" />
  <input type="text"
	name="newname" value="<?php echo $this->tag;?>" size="40" />
  <br /><br />
<?php echo "<input type=\"checkbox\" id=\"redirect\" name=\"redirect\" "; if ($this->GetConfigValue("default_rename_redirect")==1){echo "checked=\"checked\"";}; echo " /> <label for=\"redirect\">".$this->GetTranslation("NeedRedirect")."</label>"; ?> <br />
<?php if ($this->CheckACL($user,$this->config["rename_globalacl"]))
		{
			echo "<input type=\"checkbox\" id=\"massrename\" name=\"massrename\" "; echo " /> <label for=\"massrename\">".$this->GetTranslation("SettingsMassRename")."</label>"; 
		}
?> 
<br />
<br />

<?php
		// show backlinks
		if ($pages = $this->LoadPagesLinkingTo($this->getPageTag()))
		{
			print("<br /><div class=\"layout-box\"><p class=\"layout-box\"><span>".$this->GetTranslation("AlertReferringPages").":</span></p>\n");
			foreach ($pages as $page)
			{
				if ($page["tag"])
				{
					if ($this->config["hide_locked"]) $access = $this->HasAccess("read",$page["tag"]);
					else $access = true;
					if ($access)
					{
						echo($this->ComposeLinkToPage($page["tag"])."<br />\n");
					}
				}
			}
			echo "</div>\n";
		}
?>
  <br />
  <br />
  <input name="submit" class="OkBtn_Top"
	onmouseover='this.className=&quot;OkBtn_Top_&quot;;'
	onmouseout='this.className=&quot;OkBtn_Top&quot;;' type="submit" align="top"
	value="<?php echo $this->GetTranslation("RenameButton"); ?>" />
  &nbsp;
  <input
	class="CancelBtn_Top" onmouseover='this.className=&quot;CancelBtn_Top_&quot;;'
	onmouseout='this.className=&quot;CancelBtn_Top&quot;;' type="button" align="top"
	value="<?php echo str_replace("\n"," ",$this->GetTranslation("EditCancelButton")); ?>"
	onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
  <br />
  <br />
  <?php echo $this->FormClose();
   }
  }
}
else
{
  print($this->GetTranslation("NotOwnerAndCantRename"));
}
?> </div>
<?php

function RecursiveMove(&$parent, $root)
{
  $new_root = trim($_POST["newname"], "/");

  if($root == "/" )  exit; // who and where did intend to move root???

  $query = "'".quote($parent->dblink, $parent->NpjTranslit($root))."%'";
  $pages = $parent->LoadAll("SELECT ".$parent->pages_meta." FROM ".
           $parent->config["table_prefix"]."pages WHERE supertag LIKE ".$query.
           ($owner?" AND owner='".quote($parent->dblink, $owner)."'":"").
           " AND comment_on = ''");
  foreach( $pages as $page )
  {
    // $new_name = str_replace( $root, $new_root, $page["tag"] );
    $new_name = preg_replace('/'.preg_quote($root, '/').'/', preg_quote($new_root), $page["tag"], 1);
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
       print($parent->GetTranslation("BadName")."<br />\n");
     }
//     if ($OldPage["supertag"] == $supernewname)
     else if ($OldPage["tag"] == $NewName)
     {
       print(str_replace("%1",$parent->Link($NewName),$parent->GetTranslation("AlreadyNamed"))."<br />\n");
     }
     else
     {
      if ($OldPage["supertag"] != $supernewname && $page=$parent->LoadPage($supernewname, "", LOAD_CACHE, LOAD_META)){
       print(str_replace("%1",$parent->Link($NewName),$parent->GetTranslation("AlredyExists"))."<br />\n");
      }
      else
      {// Rename page

        $need_redirect = 0;
        if ($_POST["redirect"]=="on")  $need_redirect = 1;

        if ($need_redirect==0)
          if ($parent->RemoveReferrers($OldPage["tag"]))
            print("<br />".str_replace("%1",$OldPage["tag"],$parent->GetTranslation("ReferrersRemoved"))."<br />\n");

        if ($parent->RenameLinks($OldPage["tag"]))
          print(str_replace("%1",$OldPage["tag"],$parent->GetTranslation("LinksRenamed"))."<br />\n");

        if ($parent->RenamePage($OldPage["tag"], $NewName, $supernewname))
          print(str_replace("%1",$OldPage["tag"],$parent->GetTranslation("PageRenamed"))."<br />\n");

        if ($parent->RenameAcls($OldPage["tag"], $NewName, $supernewname))
          print(str_replace("%1",$OldPage["tag"],$parent->GetTranslation("AclsRenamed"))."<br />\n");

       if ($parent->RenameFiles($OldPage["tag"], $NewName, $supernewname))
          print(str_replace("%1",$OldPage["tag"],$parent->GetTranslation("FilesRenamed"))."<br />\n");

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
           print(str_replace("%1",$OldPage["tag"],$parent->GetTranslation("RedirectCreated"))."<br />\n");

          $parent->ClearCacheWantedPage($OldPage["tag"]);
          $parent->ClearCacheWantedPage($OldPage["supertag"]);
        }

        print("<br />".$parent->GetTranslation("NewNameOfPage").$parent->Link("/".$NewName));

       }
     }
  }
}

?>
