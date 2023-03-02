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

// set defaults
$global				??= 0;
$hide_description	??= '';
$maxsize			??= null;

if ($global) $global = 'global';

// check who u are, can u upload?
if ($this->can_upload(true))
{
	if ($maxsize)
	{
		$tpl->u_s_maxsize = floor(1 * $maxsize);
	}

	// if you have no write access and you are not admin, you can upload only "global" file
	if (!(	$this->has_access('read')
		 && $this->has_access('write')
		 && $this->has_access('upload'))
		 && !$this->is_admin())
	{
		$global = 'global';
	}

	$maxfilesize = $this->db->upload_max_size;

	if ($maxsize && ($maxfilesize > 1 * $maxsize))
	{
		$maxfilesize = 1 * $maxsize;
	}

	$tpl->u_maxfilesize = $maxfilesize;

	// adds 'accept' attribute depending on config settings
	// https://www.w3.org/TR/html5/forms.html#attr-input-accept
	if ($this->db->upload_images_only && !$this->is_admin())
	{
		$tpl->u_accecpt = 'accept=".avif,.gif,.jpg,.jxl,.png,.webp,image/avif,image/gif,image/jpeg,image/jxl,image/png,image/webp"';
	}

	$tpl->u_size = $this->binary_multiples($maxfilesize, false, true, true);

	if ($global)
	{
		$tpl->u_global = true;
	}
	else
	{
		$tpl->u_local = true;
	}

	if (!$hide_description)
	{
		$tpl->u_desc = true;
	}
}
else
{
	$message		= '<em>' . $this->_t('UploadForbidden') . '</em>';
	$tpl->message	= $this->show_message($message, 'note', false);
}
