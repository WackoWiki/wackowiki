<div class="pageBefore">&nbsp;</div>
<div class="page">
  <?php

if ($this->UserIsOwner() || $this->HasAccess("write",$page["tag"]))
{
	if ($_POST)
	{
		$this->SaveMeta($this->GetPageTag(), array("lang"=>$_POST["lang"], "description"=>$_POST["description"], "keywords"=>$_POST["keywords"]));
		$message = $this->GetResourceValue("ACLUpdated");

		// redirect back to page
		$this->SetMessage($message."!");
		$this->Redirect($this->Href());
	}
	else
	{
		// load settings

		// show form
		?>
  <h3><?php echo str_replace("%1",$this->Link("/".$this->GetPageTag()),$this->GetResourceValue("SettingsFor")); ?></h3>
  <?php echo $this->FormOpen("settings") ?>
  <div class="cssform">
    <p>
      <label><?php echo $this->GetResourceValue("meta1"); ?></label>
      <textarea name="keywords" rows="4" cols="51"><?php echo $this->page["keywords"] ?></textarea>
    </p>
    <p>
      <label><?php echo $this->GetResourceValue("meta2"); ?></label>
      <textarea name="description" rows="4" cols="51"><?php echo $this->page["description"] ?></textarea>
    </p>
    <p>
      <label> <?php echo $this->GetResourceValue("SetLang"); ?></label>
      <select name="lang">
        <?php
		if (!($clang = $this->page["lang"]))
		$clang = $this->GetConfigValue("language");

		if ($langs = $this->AvailableLanguages())
		{
			foreach ($langs as $lang)
			{
				print("<option value=\"".$lang."\" ".($clang==$lang?"selected=\"selected\"":"").">".$lang."</option>\n");
			}
		}
		?>
      </select>
    </p>
    <div class="BewareChangeLang"> <?php echo $this->GetResourceValue("BewareChangeLang"); ?></div>
    <p>
      <input class="OkBtn" onmouseover='this.className="OkBtn_";' onmouseout='this.className="OkBtn";' type="submit" align="top" value="<?php echo $this->GetResourceValue("MetaStoreButton"); ?>" style="width: 120px" accesskey="s" />
      &nbsp;
      <input class="CancelBtn" onmouseover='this.className="CancelBtn_";' onmouseout='this.className="CancelBtn";' type="button" align="top" value="<?php echo $this->GetResourceValue("MetaCancelButton"); ?>" onclick="history.back();" style="width: 120px" />
    </p>
  </div>
  <?php
			print($this->FormClose());
}
?>
  <p><?php echo $this->GetResourceValue("SettingsPortal");?>
  <ul>
    <li><a href="<?php echo $this->href("edit");?>"><?php echo $this->GetResourceValue("SettingsEdit"); ?></a></li>
    <li><a href="<?php echo $this->href("revisions");?>"><?php echo $this->GetResourceValue("SettingsRevisions"); ?></a></li>
    <li><a href="<?php echo $this->href("rename");?>"><?php echo $this->GetResourceValue("SettingsRename"); ?></a>
      <ul>
        <li><a href="<?php echo $this->href("massrename");?>"><?php echo $this->GetResourceValue("SettingsMassRename"); ?></a></li>
      </ul>
    </li>
    <li><a href="<?php echo $this->href("remove");?>"><?php echo $this->GetResourceValue("SettingsRemove"); ?></a></li>
    <li><a href="<?php echo $this->href("acls");?>"><?php echo $this->GetResourceValue("SettingsAcls"); ?></a>
      <ul>
        <li><a href="<?php echo $this->href("massacls" );?>"><?php echo $this->GetResourceValue("SettingsMassAcls" ); ?></a></li>
      </ul>
    </li>
    <li><a href="<?php echo $this->href("upload");?>"><?php echo $this->GetResourceValue("SettingsUpload"); ?></a></li>
    <li><a href="<?php echo $this->href("referrers");?>"><?php echo $this->GetResourceValue("SettingsReferrers"); ?></a></li>
    <li><a href="<?php echo $this->href("watch");?>"><?php echo $this->GetResourceValue("SettingsWatch"); ?></a></li>
    <li><a href="<?php echo $this->href("print");?>"><?php echo $this->GetResourceValue("SettingsPrint"); ?></a></li>
    <li><a href="<?php echo $this->href("msword");?>"><?php echo $this->GetResourceValue("SettingsMsword"); ?></a></li>
  </ul>
  <?php
}
else
{
   print($this->GetResourceValue("ReadAccessDenied"));
}
?>
  </li>
</div>
