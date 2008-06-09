<div class="pageBefore"><img
	src="<?php echo $this->GetConfigValue("root_url"); ?>images/z.gif"
	width="1" height="1" alt="" style="border-width:0px; display: block; vertical-align:top" /></div>
<div class="page"><?php

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
<br />

		<?php echo $this->FormOpen("settings") ?>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top" style="padding-right: 20px"><?php echo $this->GetResourceValue("meta1"); ?>:<br />
		<textarea name="keywords" rows="4" cols="51"><?php echo $this->page["keywords"] ?></textarea>
		</td>
		<td valign="top" style="padding-right: 20px"><?php echo $this->GetResourceValue("meta2"); ?>:<br />
		<textarea name="description" rows="4" cols="51"><?php echo $this->page["description"] ?></textarea>
		</td>
	</tr>
</table>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="middle" nowrap="nowrap"><br />
		<?php echo $this->GetResourceValue("SetLang"); ?>: <select name="lang">
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
		</select></td>
		<td valign="bottom">
		<div
			style="border: 1px solid red; background-color: #DDDDDD; padding: 3px 7px; margin-left: 10px;">
			<?php echo $this->GetResourceValue("BewareChangeLang"); ?></div>
		</td>
	</tr>
	<tr>
		<td colspan="3"><br />
		<input class="OkBtn" onmouseover='this.className="OkBtn_";'
			onmouseout='this.className="OkBtn";' type="submit" align="top"
			value="<?php echo $this->GetResourceValue("MetaStoreButton"); ?>"
			style="width: 120px" accesskey="s" /> <img
			src="<?php echo $this->GetConfigValue("root_url");?>images/z.gif"
			width="100" height="1" alt="" border="0" /> <input class="CancelBtn"
			onmouseover='this.className="CancelBtn_";'
			onmouseout='this.className="CancelBtn";' type="button" align="top"
			value="<?php echo $this->GetResourceValue("MetaCancelButton"); ?>"
			onclick="history.back();" style="width: 120px" /></td>
	</tr>
</table>
			<?php
			print($this->FormClose());
}
?>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td colspan="3"><br />
		<?php echo $this->GetResourceValue("SettingsPortal");?>
		<ul>
			<li><a
				href="<?php echo $this->href("edit"     )."\">".$this->GetResourceValue("SettingsEdit"     ); ?></a></li>
<li><a href="<?php echo $this->href("revisions")."\">".$this->GetResourceValue("SettingsRevisions"); ?></a></li>
<li><a href="<?php echo $this->href("rename"   )."\">".$this->GetResourceValue("SettingsRename"   ); ?></a>
<ul><li><a href="<?php echo $this->href("massrename" )."\">".$this->GetResourceValue("SettingsMassRename" ); ?></a></li></ul></li>
<li><a href="<?php echo $this->href("remove"   )."\">".$this->GetResourceValue("SettingsRemove"   ); ?></a></li>
<li><a href="<?php echo $this->href("acls"     )."\">".$this->GetResourceValue("SettingsAcls"     ); ?></a>
<ul><li><a href="<?php echo $this->href("massacls" )."\">".$this->GetResourceValue("SettingsMassAcls" ); ?></a></li></ul></li>
<li><a href="<?php echo $this->href("upload"   )."\">".$this->GetResourceValue("SettingsUpload"   ); ?></a></li>
<li><a href="<?php echo $this->href("referrers")."\">".$this->GetResourceValue("SettingsReferrers"); ?></a></li>
<li><a href="<?php echo $this->href("watch"    )."\">".$this->GetResourceValue("SettingsWatch"    ); ?></a></li>
<li><a href="<?php echo $this->href("print"    )."\">".$this->GetResourceValue("SettingsPrint"    ); ?></a></li>
<li><a href="<?php echo $this->href("msword"   )."\">".$this->GetResourceValue("SettingsMsword"   ); ?></a></li>
</ul>
        </td>
      </tr>
    </table>
<?php
}
else
{
   print($this->GetResourceValue("ReadAccessDenied"));
}
?>
</div>