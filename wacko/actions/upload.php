<?php
/*
 {{Upload
 [global=1]
 [maxsize="200"]
 [hide_description=1]
 }}
 */
 
if (!isset($global)) $global = "";
if (!isset($maxsize)) $maxsize = "";
if (!isset($hide_description)) $hide_description = "";

if ($global) $global = "global";

// we display a form to make an upload

// check who u are, can u upload?
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
{
	// displaying
	echo $this->FormOpen("upload", "", "post", "", " enctype='multipart/form-data' ");

	if ($maxsize)
	echo "<input type=\"hidden\" name=\"maxsize\" value=\"".floor(1 * $maxsize)."\" />";

	// if you have no write access and you are not admin, you can upload only "global" file
	if (!($this->HasAccess("write") && $this->HasAccess("read")))
	if (!$this->IsAdmin())
	$global = "global";

	$maxfilesize = $this->config["upload_max_size"];

	if ($maxsize)
		if ($maxfilesize > 1 * $maxsize) 
			$maxfilesize = 1 * $maxsize;

	$maxfilesize *= 1024;
	?>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><label for="FileUpload"><?php echo $this->GetTranslation("UploadFor");?>:&nbsp;</label>
		<input type="hidden" name="MAX_FILE_SIZE"
			value="<?php echo $maxfilesize;?>" /></td>
		<td style="white-space: nowrap;"><input name="file" id="FileUpload" type="file" />&nbsp;(<?php echo $this->GetTranslation("UploadMax").$this->config["upload_max_size"].$this->GetTranslation("UploadKB");?>)</td>
	</tr>
	<?php
	if ($global)
	{ ?>
	<tr>
		<td>&nbsp;</td>
		<td>
		<div>
		<input type="radio" name="_to" disabled="disabled" checked="checked" value="global" id="toUploadGlobalDisabled" /> 
		<input type="hidden" name="to" value="global" /> <?php echo $this->GetTranslation("UploadGlobalText"); ?>
		</div>
	
	</tr>
	<?php }
	else
	{ ?>
	<tr>
		<td>&nbsp;</td>
		<td>
		<div>
		<input type="radio" name="to" value="global" id="toUploadGlobal" />
		<label for="toUploadGlobal"><?php echo $this->GetTranslation("UploadGlobalText"); ?></label>
		</div>
		<div>
		<input type="radio" name="to" value="here" checked="checked" id="toUploadHere" />
		<label for="toUploadHere"><?php echo $this->GetTranslation("UploadHereText"); ?></label>
		</div>
	</td>
	</tr>
	<?php } ?>
	<?php
	if (!$hide_description) { ?>
	<tr>
		<td style="text-align: right"><label for="UploadDesc"><?php echo $this->GetTranslation("UploadDesc");?>:&nbsp;</label></td>
		<td><input name="description" id="UploadDesc" type="text" size="40" /></td>
	</tr>
	<?php } ?>
	<tr>
		<td>&nbsp;</td>
		<td>
			<div style="padding-top: 5px">
			<input type="submit" value="<?php echo $this->GetTranslation("UploadButtonText"); ?>" />
			</div>
		</td>
	</tr>
</table>
	<?php
	echo $this->FormClose();
}
else
{
	echo "<em>".$this->GetTranslation("ActionDenied")."</em> ";
}

?>