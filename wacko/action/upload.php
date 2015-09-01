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
if ($this->can_upload() === true)
{
	// displaying
	echo $this->form_open('upload', 'upload', 'post', true, '', ' enctype="multipart/form-data" ');

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
<table >
	<tr>
		<td><label for="FileUpload"><?php echo $this->get_translation('UploadFor');?>:&nbsp;</label>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxfilesize;?>" /></td>
		<td style="white-space: nowrap;"><input type="file" name="file" id="FileUpload" />&nbsp;(<?php echo $this->get_translation('UploadMax').$this->binary_multiples(($this->config['upload_max_size'] * 1024), false, true, true);?>)</td>
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
		<td><input name="file_description" id="UploadDesc" type="text" size="40" /></td>
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
	echo '<em>'.$this->get_translation('UploadForbidden').'</em>';
}

?>