<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href('show'));

// deny for comment
if ($this->page['comment_on'])
	$this->Redirect($this->href('', $this->page['comment_on'], 'show_comments=1').'#'.$this->page['tag']);

if ($this->UserIsOwner() || $this->HasAccess("write",$page["tag"]))
{
	if ($_POST)
	{
		$this->SaveMeta($this->GetPageTag(), array("lang"=>$_POST["lang"], "description"=>$_POST["description"], "keywords"=>$_POST["keywords"]));
		$message = $this->GetTranslation("MetaUpdated");

		// redirect back to page
		$this->SetMessage($message."!");
		$this->Redirect($this->Href());
	}
	else
	{
		// load settings

		// show form
		?>
  <h3><?php echo str_replace("%1",$this->Link("/".$this->GetPageTag()),$this->GetTranslation("SettingsFor")); ?></h3>
  <?php echo $this->FormOpen("settings") ?>
  <div class="cssform">
    <p>
      <label for="keywords"><?php echo $this->GetTranslation("Meta1"); ?></label>
      <textarea id="keywords" name="keywords" rows="4" cols="51"><?php echo $this->page["keywords"] ?></textarea>
    </p>
    <p>
      <label for="description"><?php echo $this->GetTranslation("Meta2"); ?></label>
      <textarea id="description" name="description" rows="4" cols="51"><?php echo $this->page["description"] ?></textarea>
    </p>
    <p>
      <label for="lang"><?php echo $this->GetTranslation("SetLang"); ?></label>
      <select id="lang" name="lang">
        <?php
		if (!($clang = $this->page["lang"]))
		$clang = $this->GetConfigValue("language");

		if ($langs = $this->AvailableLanguages())
		{
			foreach ($langs as $lang)
			{
				print("<option value=\"".$lang."\"".($clang==$lang?"selected=\"selected\"":"").">".$lang."</option>\n");
			}
		}
		?>
      </select>
    </p>
    <div class="BewareChangeLang"> <?php echo $this->GetTranslation("BewareChangeLang"); ?></div>
    <p>
      <input class="OkBtn" onmouseover='this.className="OkBtn_";' onmouseout='this.className="OkBtn";' type="submit" align="top" value="<?php echo $this->GetTranslation("MetaStoreButton"); ?>" style="width: 120px" accesskey="s" />
      &nbsp;
      <input class="CancelBtn" onmouseover='this.className="CancelBtn_";' onmouseout='this.className="CancelBtn";' type="button" align="top" value="<?php echo $this->GetTranslation("MetaCancelButton"); ?>" onclick="history.back();" style="width: 120px" />
    </p>
  </div>
  <?php
			print($this->FormClose());
}
?>
  <p><?php echo $this->GetTranslation("SettingsPortal");?></p>
  <ul>
    <li><a href="<?php echo $this->href("edit");?>"><?php echo $this->GetTranslation("SettingsEdit"); ?></a></li>
    <li><a href="<?php echo $this->href("revisions");?>"><?php echo $this->GetTranslation("SettingsRevisions"); ?></a></li>
    <li><a href="<?php echo $this->href("rename");?>"><?php echo $this->GetTranslation("SettingsRename"); ?></a></li>
    <li><a href="<?php echo $this->href("remove");?>"><?php echo $this->GetTranslation("SettingsRemove"); ?></a></li>
    <li><a href="<?php echo $this->href("acls");?>"><?php echo $this->GetTranslation("SettingsAcls"); ?></a></li>
    <li><a href="<?php echo $this->href("upload");?>"><?php echo $this->GetTranslation("SettingsUpload"); ?></a></li>
    <li><a href="<?php echo $this->href("referrers");?>"><?php echo $this->GetTranslation("SettingsReferrers"); ?></a></li>
    <li><a href="<?php echo $this->href("watch");?>"><?php echo $this->GetTranslation("SettingsWatch"); ?></a></li>
    <li><a href="<?php echo $this->href("print");?>"><?php echo $this->GetTranslation("SettingsPrint"); ?></a></li>
    <li><a href="<?php echo $this->href("msword");?>"><?php echo $this->GetTranslation("SettingsMsword"); ?></a></li>
	<li><a href="<?php echo $this->href("latex");?>"><?php echo $this->GetTranslation("SettingsLatex"); ?></a></li>
	<li><a href="<?php echo $this->href("export.xml");?>"><?php echo $this->GetTranslation("SettingsXML"); ?></a></li>
  </ul>

  <?php
}
else
{
   print($this->GetTranslation("ReadAccessDenied"));
}
?>
</div>