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
			$NewName = trim($_POST["newname"], "/");

			$supernewname = $this->NpjTranslit($NewName);

			if (!preg_match("/^([\_\.\-".$this->language["ALPHANUM_P"]."]+)$/", $NewName))
			{
				print($this->GetResourceValue("BadName")."<br />\n");
			}
			//     if ($this->supertag == $supernewname)
			else if ($this->tag == $NewName)
			{
				print(str_replace("%1",$this->Link($NewName),$this->GetResourceValue("AlredyNamed"))."<br />\n");
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

			?> <input type="hidden" name="rename" value="1" /> <input type="text"
	name="newname" value="<?php echo $this->tag;?>" size="40" /><br />
			<?php echo "<input type=\"checkbox\" id=\"ch1\" name=\"redirect\" "; if ($this->GetConfigValue("default_rename_redirect")==1){echo "checked ";}; echo " /> <label for=\"ch1\">".$this->GetResourceValue("NeedRedirect")."</label>"; ?>
<br />
<br />
<br />
			<?php
			if ($pages = $this->LoadPagesLinkingTo($this->getPageTag()))
			{
				print("<fieldset><legend>".$this->GetResourceValue("AlertReferringPages").":</legend>\n");
				foreach ($pages as $page)
				{
					echo($this->ComposeLinkToPage($page["tag"])."<br />\n");
				}
				echo "</fieldset>\n";
			}
			?> <br />
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
	href="<?php echo $this->href("massrename" )."\">".$this->GetResourceValue("SettingsMassRename" ); ?></a>]<br />
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