<div id="page">
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href('show'));

// deny for comment
if ($this->page['comment_on_id'])
	$this->Redirect($this->href('', $this->GetCommentOnTag($this->page["comment_on_id"]), 'show_comments=1').'#'.$this->page['tag']);

if ($this->UserIsOwner() || $this->HasAccess("write",$page["tag"]))
{
	if ($_POST)
	{
		$this->SaveMeta($this->GetPageTag(), array(
			"lang" => $_POST["lang"],
			"title" => $_POST["title"],
			"description" => $_POST["description"],
			"keywords" => $_POST["keywords"]
		));

		// log event
		$this->Log(4, str_replace("%1", $this->tag." ".$_POST["title"], $this->GetTranslation("LogPageMetaUpdated")));

		// redirect back to page
		$this->SetMessage($this->GetTranslation("MetaUpdated")."!");
		$this->Redirect($this->Href());
	}
	else
	{
		// load settings

		// show form
		?>
  <h3><?php echo str_replace("%1",$this->Link("/".$this->GetPageTag()),$this->GetTranslation("SettingsFor")); ?></h3>
<?php
	// load settings (shows only if owner is current user or Admin)
	if ($this->UserIsOwner() || $this->IsAdmin())
	{
?>
<?php echo $this->FormOpen("settings") ?>
<div class="cssform">
	<p>
		<label for="title"><?php echo $this->GetTranslation("MetaTitle"); ?></label>
		<input id="title" name="title" value="<?php echo $this->page["title"] ?>" size="60" maxlength="100" />
	</p>
	<p>
		<label for="keywords"><?php echo $this->GetTranslation("MetaKeywords"); ?></label>
		<textarea id="keywords" name="keywords" rows="4" cols="51"><?php echo $this->page["keywords"] ?></textarea>
	</p>
	<p>
		<label for="description"><?php echo $this->GetTranslation("MetaDescription"); ?></label>
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
				print("<option value=\"".$lang."\"".($clang==$lang ? "selected=\"selected\"" : "").">".$lang."</option>\n");
			}
		}
		?>
		</select>
	</p>
	<div class="BewareChangeLang"> <?php echo $this->GetTranslation("BewareChangeLang"); ?></div>
	<p>
		<input type="submit" value="<?php echo $this->GetTranslation("MetaStoreButton"); ?>" style="width: 120px" accesskey="s" />
		&nbsp;
		<input type="button" value="<?php echo $this->GetTranslation("MetaCancelButton"); ?>" onclick="history.back();" style="width: 120px" />
	</p>
</div>
<?php
	print($this->FormClose());
		}
	else
	{
	echo ($this->GetTranslation("MetaKeywords").": ".$this->page["keywords"]."<br />".
	$this->GetTranslation("MetaDescription").": ".$this->page["description"]."<br />".
	$this->GetTranslation("SetLang").": ".$this->page["lang"]);
	}
}
?>
<p><?php echo $this->GetTranslation("SettingsPortal");?></p>
<ul>
	<li><a href="<?php echo $this->href("edit");?>"><?php echo $this->GetTranslation("SettingsEdit"); ?></a></li>
	<li><a href="<?php echo $this->href("revisions");?>"><?php echo $this->GetTranslation("SettingsRevisions"); ?></a></li>
	<?php
	// Rename link (shows only if owner is current user or Admin)
	if ($this->UserIsOwner() || $this->IsAdmin())
	{
	echo("<li><a href=\"".$this->href("rename")."\">".$this->GetTranslation("SettingsRename")."</a>
	</li>");
	}
	?>
<?php // Remove link (shows only for page owner if allowed)
	if ($this->UserIsOwner() && !$this->GetConfigValue("remove_onlyadmins") || $this->IsAdmin())
	{
		echo("<li><a href=\"".$this->href("remove")."\">".$this->GetTranslation("SettingsRemove")."</a></li>");
		echo("<li><a href=\"".$this->href("purge")."\">".$this->GetTranslation("SettingsPurge")."</a></li>");
	}
	?>
<?php
	// ACL link (shows only if owner is current user or Admin)
	if ($this->UserIsOwner() || $this->IsAdmin())
	{
	echo("<li><a href=\"".$this->href("acls")."\">".$this->GetTranslation("SettingsAcls")."</a></li>");
	}
	?>
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
<br />
</div>