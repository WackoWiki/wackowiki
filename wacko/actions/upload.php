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

<div class="cssform">
  <p>
    <label><?php echo $this->GetResourceValue("UploadFor");?>:</label>
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxfilesize;?>" />
    <input name="file" type="file" />
    &nbsp;(<?php echo $this->GetResourceValue("UploadMax").$this->config["upload_max_size"].$this->GetResourceValue("UploadKB");?>)</p>
  <?php
	if ($global)
	{ ?>
  <p>
  <div>
    <input type="radio" name="_to" disabled="disabled" checked="checked" value="global" id="toUploadGlobalDisabled" />
    <input type="hidden" name="to" value="global" />
    <?php echo $this->GetResourceValue("UploadGlobalText"); ?> </div>
  </p>
  <?php }
	else
	{ ?>
  <p>
  <label for="toUploadGlobal" class="smaller"><?php echo $this->GetResourceValue("UploadGlobalText"); ?></label>
  <input type="radio" name="to" value="global" id="toUploadGlobal" />
  </p>
  <p><label for="toUploadHere" class="smaller"><?php echo $this->GetResourceValue("UploadHereText"); ?></label>
  <input type="radio" name="to" value="here" checked="checked" id="toUploadHere" />
    </p>
  <?php } ?>
  <?php
	if (!$hide_description) { ?>
  <p>
    <label><?php echo $this->GetResourceValue("UploadDesc");?>:&nbsp;</label>
    <input name="description" type="text" size="40" />
  </p>
  <?php } ?>
  <p>
  <div style="padding-top: 5px">
    <input type="submit" value="<?php echo $this->GetResourceValue("UploadButtonText"); ?>" />
  </div>
  </p>
</div>
<?php
	echo $this->FormClose();
}
else
{
	echo "<em>".$this->GetResourceValue("ActionDenied")."</em> ";
}

?>
