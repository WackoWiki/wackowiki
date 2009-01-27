<div class="page">
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
		print(str_replace("%1",$this->href("edit"),$this->GetResourceValue("DoesNotExists")));
	}
	else
	{
		if ($_POST["newname"] && $_POST["rename"]=="1")
		{
			$NewName = trim($_POST["newname"], "/");

			$supernewname = $this->NpjTranslit($NewName);

			if (!preg_match("/^([\_\.\-".$this->language["ALPHANUM_P"]."]+)$/", $NewName))
			{
				print($this->GetResourceValue("BadName")."<br />\n");
			}
			//     if ($this->supertag == $supernewname)
			else if ($this->tag == $NewName)
			{
				print(str_replace("%1",$this->Link($NewName),$this->GetResourceValue("AlreadyNamed"))."<br />\n");
			}
			else
			{
				if ($this->supertag != $supernewname && $page=$this->LoadPage($supernewname, "", LOAD_CACHE, LOAD_META)){
					print(str_replace("%1",$this->Link($NewName),$this->GetResourceValue("AlredyExists"))."<br />\n");
				}
				else
				{// Rename page

					$need_redirect = 0;
					if ($_POST["redirect"]=="on")  $need_redirect = 1;

					if ($need_redirect==0)
					if ($this->RemoveReferrers($this->tag))
					print(str_replace("%1",$this->tag,$this->GetResourceValue("ReferrersRemoved"))."<br />\n");

					if ($this->RenameLinks($this->tag))
					print(str_replace("%1",$this->tag,$this->GetResourceValue("LinksRenamed"))."<br />\n");

					if ($this->RenamePage($this->tag, $NewName, $supernewname))
					print(str_replace("%1",$this->tag,$this->GetResourceValue("PageRenamed"))."<br />\n");

					if ($this->RenameAcls($this->tag, $NewName, $supernewname))
					print(str_replace("%1",$this->tag,$this->GetResourceValue("AclsRenamed"))."<br />\n");

					if ($this->RenameFiles($this->tag, $NewName, $supernewname))
					print(str_replace("%1",$this->tag,$this->GetResourceValue("FilesRenamed"))."<br />\n");

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
						print(str_replace("%1",$this->tag,$this->GetResourceValue("RedirectCreated"))."<br />\n");

						$this->ClearCacheWantedPage($this->tag);
						$this->ClearCacheWantedPage($this->supertag);
					}

					print("<br />".$this->GetResourceValue("NewNameOfPage").$this->Link("/".$NewName));

				}
			}

		}
		else
		{
			echo $this->GetResourceValue("NewName");
			echo $this->FormOpen("rename");

			?>
  <input type="hidden" name="rename" value="1" />
  <input type="text"
	name="newname" value="<?php echo $this->tag;?>" size="40" />
  <br />
<?php echo "<input type=\"checkbox\" id=\"redirect\" name=\"redirect\" "; if ($this->GetConfigValue("default_rename_redirect")==1){echo "checked=\"checked\"";}; echo " /> <label for=\"redirect\">".$this->GetResourceValue("NeedRedirect")."</label>"; ?> <br />
  <br />
<?php
		// show backlinks
		if ($pages = $this->LoadPagesLinkingTo($this->getPageTag()))
		{
			print("<br /><fieldset><legend>".$this->GetResourceValue("AlertReferringPages").":</legend>\n");
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
			echo "</fieldset>\n";
		}
?>
  <br />
  <br />
  <input name="submit" class="OkBtn_Top"
	onmouseover='this.className=&quot;OkBtn_Top_&quot;;'
	onmouseout='this.className=&quot;OkBtn_Top&quot;;' type="submit" align="top"
	value="<?php echo $this->GetResourceValue("RenameButton"); ?>" />
  &nbsp;
  <input
	class="CancelBtn_Top" onmouseover='this.className=&quot;CancelBtn_Top_&quot;;'
	onmouseout='this.className=&quot;CancelBtn_Top&quot;;' type="button" align="top"
	value="<?php echo str_replace("\n"," ",$this->GetResourceValue("EditCancelButton")); ?>"
	onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
  <br />
  <br />
  [<a	href="<?php echo $this->href("massrename" );?>"><?php echo $this->GetResourceValue("SettingsMassRename" ); ?></a>]<br />
  <?php echo $this->FormClose();
   }
  }
}
else
{
  print($this->GetResourceValue("NotOwnerAndCantRename"));
}
?> </div>
