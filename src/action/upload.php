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

$info = <<<EOD
Description:
	Uploads files to global or local namespace.

Usage:
	{{upload}}

Options:
	[global=1]
	[maxsize=200]
	[hide_description=1]
EOD;

// set defaults
$global				??= 0;
$help				??= 0;
$hide_description	??= '';
$maxsize			??= null;
$rename				??= 0;

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info]);
	return;
}

$maxsize	= (int) $maxsize;

if ($global)
{
	$global = true;
}

// functions
$accept_types = function($types)
{
	$accept_types = array_map('trim', explode(',', $types));

	foreach($accept_types as $type)
	{
		if ($this->validate_extension($type))
		{
			$result[] = '.' . $type;
		}
	}

	return implode(',', $result);
};

// check who u are, can u upload?
if ($this->can_upload(true))
{
	if ($maxsize)
	{
		$tpl->u_s_maxsize = floor($maxsize);
	}

	// if you have no write access, and you are not admin, you can upload only "global" file
	if (!(	$this->has_access('read')
		 && $this->has_access('write')
		 && $this->has_access('upload'))
		 && !$this->is_admin())
	{
		$global = true;
	}

	$maxfilesize	= $this->get_max_upload_size();
	$allowed_types	= $this->db->upload_allowed_exts ?? '';

	if ($maxsize && ($maxfilesize > $maxsize))
	{
		$maxfilesize = $maxsize;
	}

	$tpl->u_maxfilesize = $maxfilesize;

	if ($this->db->upload_images_only && !$this->is_admin())
	{
		$allowed_types = implode(', ' , self::EXT['bitmap']);
	}

	if ($allowed_types)
	{
		// adds 'accept' attribute depending on config settings
		// https://www.w3.org/TR/html5/forms.html#attr-input-accept
		$tpl->u_accecpt = 'accept="' . $accept_types($allowed_types) . '"';
		$tpl->u_d_allowed = $allowed_types;
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

	if ($rename)
	{
		$tpl->u_rename = true;
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
