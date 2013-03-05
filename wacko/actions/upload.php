<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	{{upload
		[global=1]
		[maxsize=200]
		[hide_description=1]
	}}
*/

if (!isset($global))			$global = '';
if (!isset($maxsize))			$maxsize = '';
if (!isset($hide_description))	$hide_description = '';

if ($global) $global = 'global';

// we display a form to make an upload

// check who u are, can u upload?
if ($user = $this->get_user())
{
	$user_name	= strtolower($this->get_user_name());
	$registered	= true;
}
else
{
	$user_name		= GUEST;
}

if ($registered
&&
(
($this->config['upload'] === true) || ($this->config['upload'] == 1) ||
($this->check_acl($user_name, $this->config['upload']))
)
&& ($this->has_access('upload') && $this->has_access('write') && $this->has_access('read')) || $this->user_is_owner() || $this->is_admin()
)
{
	// displaying
	echo $this->form_open('upload', '', 'post', '', ' enctype="multipart/form-data" ');

	if ($maxsize)
	{
		echo '<input type="hidden" name="maxsize" value="'.floor(1 * $maxsize).'" />';
	}

	// if you have no write access and you are not admin, you can upload only "global" file
	if (!($this->has_access('write') && $this->has_access('read')))
	{
		if (!$this->is_admin())
		{
			$global = 'global';
		}
	}

	$maxfilesize = $this->config['upload_max_size'];

	if ($maxsize)
	{
		if ($maxfilesize > 1 * $maxsize)
		{
			$maxfilesize = 1 * $maxsize;
		}
	}

	$maxfilesize *= 1024;
?>
<table border="0" >
	<tr>
		<td><label for="FileUpload"><?php echo $this->get_translation('UploadFor');?>:&nbsp;</label>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxfilesize;?>" /></td>
		<td style="white-space: nowrap;"><input name="file" id="FileUpload" type="file" />&nbsp;(<?php echo $this->get_translation('UploadMax').$this->binary_multiples(($this->config['upload_max_size'] * 1024), false, true, true);?>)</td>
	</tr>
	<?php
	if ($global)
	{ ?>
	<tr>
		<td>&nbsp;</td>
		<td>
		<div>
			<input type="radio" name="_to" disabled="disabled" checked="checked" value="global" id="toUploadGlobalDisabled" />
			<input type="hidden" name="to" value="global" /> <?php echo $this->get_translation('UploadGlobalText'); ?>
		</div>
	</tr>
	<?php
	}
	else
	{ ?>
	<tr>
		<td>&nbsp;</td>
		<td>
		<div>
		<input type="radio" name="to" value="global" id="toUploadGlobal" />
		<label for="toUploadGlobal"><?php echo $this->get_translation('UploadGlobalText'); ?></label>
		</div>
		<div>
		<input type="radio" name="to" value="here" checked="checked" id="toUploadHere" />
		<label for="toUploadHere"><?php echo $this->get_translation('UploadHereText'); ?></label>
		</div>
	</td>
	</tr>
	<?php } ?>
	<?php
	if (!$hide_description)
	{ ?>
	<tr>
		<td style="text-align: right"><label for="UploadDesc"><?php echo $this->get_translation('UploadDesc');?>:&nbsp;</label></td>
		<td><input name="description" id="UploadDesc" type="text" size="40" /></td>
	</tr>
	<?php } ?>
	<tr>
		<td>&nbsp;</td>
		<td>
			<div style="padding-top: 5px">
			<input type="submit" value="<?php echo $this->get_translation('UploadButtonText'); ?>" />
			</div>
		</td>
	</tr>
</table>
	<?php
	echo $this->form_close();
}
else
{
	echo "<em>".$this->get_translation('UploadForbidden')."</em> ";
}

?>