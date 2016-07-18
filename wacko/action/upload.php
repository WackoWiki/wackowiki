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
if ($this->can_upload(true) === true)
{
	// displaying
	echo $this->form_open('upload', ['page_method' => 'upload', 'form_more' => ' enctype="multipart/form-data" ']);

	if ($maxsize)
	{
		echo '<input type="hidden" name="maxsize" value="'.floor(1 * $maxsize).'" />';
	}

	// if you have no write access and you are not admin, you can upload only "global" file
	if (!($this->has_access('read') && $this->has_access('write') && $this->has_access('upload')))
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

?>
<table >
	<tr>
		<td>
			<label for="file_upload"><?php echo $this->get_translation('UploadFor');?>:&nbsp;</label>
			<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $maxfilesize;?>" />
		</td>
		<td style="white-space: nowrap;">
			<input type="file" name="file" id="file_upload" />&nbsp;(<?php echo $this->get_translation('UploadMax').$this->binary_multiples(($this->config['upload_max_size']), false, true, true);?>)
		</td>
	</tr>
	<?php
	if ($global)
	{ ?>
	<tr>
		<td>&nbsp;</td>
		<td>
			<div>
				<input type="radio" name="_to" disabled="disabled" checked="checked" value="global" id="upload_global_disabled" />
				<input type="hidden" name="to" value="global" /> <?php echo $this->get_translation('UploadGlobalText'); ?>
			</div>
		</td>
	</tr>
	<?php
	}
	else
	{ ?>
	<tr>
		<td>&nbsp;</td>
		<td>
			<div>
				<input type="radio" name="to" value="global" id="upload_global" />
				<label for="upload_global"><?php echo $this->get_translation('UploadGlobalText'); ?></label>
			</div>
			<div>
				<input type="radio" name="to" value="here" checked="checked" id="upload_to_page" />
				<label for="upload_to_page"><?php echo $this->get_translation('UploadHereText'); ?></label>
			</div>
		</td>
	</tr>
	<?php } ?>
	<?php
	if (!$hide_description)
	{ ?>
	<tr>
		<td style="text-align: right">
			<label for="upload_desc"><?php echo $this->get_translation('UploadDesc');?>:&nbsp;</label>
		</td>
		<td>
			<input type="text" name="file_description" id="upload_desc" size="60" maxlength="250"/>
		</td>
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
<input type="hidden" name="upload" value="1" />
	<?php
	echo $this->form_close();
}
else
{
	echo '<em>'.$this->get_translation('UploadForbidden').'</em>';
}

?>
