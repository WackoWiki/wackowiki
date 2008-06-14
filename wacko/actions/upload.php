<?php
/*
 {{Upload
 [global=1]
 [maxsize="200"]
 [hide_description=1]
 }}
 */
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
	echo "<input type=\"hidden\" name=\"maxsize\" value=\"".floor(1*$maxsize)."\" />";

	// if you have no write access and you are not admin, you can upload only "global" file
	if (!($this->HasAccess("write") && $this->HasAccess("read")))
	if (!$this->IsAdmin())
	$global = "global";

	$maxfilesize = $this->config["upload_max_size"];
	if ($maxsize)
	if ($maxfilesize > 1*$maxsize) $maxfilesize = 1*$maxsize;
	$maxfilesize*=1024;
	?>
<table border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td><?php echo $this->GetResourceValue("UploadFor");?>:&nbsp;
		<input type="hidden" name="MAX_FILE_SIZE"
			value="<?php echo $maxfilesize;?>" /></td>
		<td style="white-space: nowrap;"><input name="file" type="file" />&nbsp;(<?php echo $this->GetResourceValue("UploadMax").$this->config["upload_max_size"].$this->GetResourceValue("UploadKB");?>)</td>
	</tr>
	<?php
	if ($global)
	{ ?>
	<tr>
		<td>&nbsp;</td>
		<td style="font-size: 11px">
		<div><input type="radio" name="_to" disabled="disabled"
			checked="checked" value="global" id="toUploadGlobalDisabled" /> <input
			type="hidden" name="to" value="global" /> <?php echo $this->GetResourceValue("UploadGlobalText"); ?>
		</div>
	
	</tr>
	<?php }
	else
	{ ?>
	<tr>
		<td>&nbsp;</td>
		<td style="font-size: 11px">
		<div><input type="radio" name="to" value="global" id="toUploadGlobal" />
		<label for="toUploadGlobal"><?php echo $this->GetResourceValue("UploadGlobalText"); ?></label>
		</div>
		<div><input type="radio" name="to" value="here" checked="checked"
			id="toUploadHere" /> <label for="toUploadHere"><?php echo $this->GetResourceValue("UploadHereText"); ?></label>
		</div>
	</td>
	</tr>
	<?php } ?>
	<?php
	if (!$hide_description) { ?>
	<tr>
		<td style="font-size: 11px; text-align: right"><?php echo $this->GetResourceValue("UploadDesc");?>:&nbsp;</td>
		<td><input name="description" type="text" size="40" /></td>
	</tr>
	<?php } ?>
	<tr>
		<td>&nbsp;</td>
		<td>
		<div style="padding-top: 5px"><input type="submit"
			value="<?php echo $this->GetResourceValue("UploadButtonText"); ?>" />
		</div>
		</td>

	</tr>
</table>
	<?php
	echo $this->FormClose();
}
else
{
	echo "<em>".$this->GetResourceValue("ActionDenied")."</em> ";
}

?>