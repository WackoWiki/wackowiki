<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	Uploads files to global or local namespace.

Usage:
	{{upload}}

Options:
	[global=1]
	[maxsize=200]
		forcedly limits maximum size (must be less than in config)
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
	$tpl->help	= $this->help($info, 'upload');
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
	$tpl->enter('u_');

	if ($maxsize)
	{
		$tpl->s_maxsize = floor($maxsize);
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

	$tpl->maxfilesize = $maxfilesize;

	if ($this->db->upload_images_only && !$this->is_admin())
	{
		$allowed_types = implode(', ', self::EXT['bitmap']);
	}

	if ($allowed_types)
	{
		// adds 'accept' attribute depending on config settings
		// https://www.w3.org/TR/html5/forms.html#attr-input-accept
		$tpl->accecpt		= 'accept="' . $accept_types($allowed_types) . '"';
		$tpl->d_allowed		= $allowed_types;
	}

	$tpl->size = $this->factor_multiples($maxfilesize, 'binary', true, true);

	if ($global)
	{
		$tpl->global	= true;
	}
	else
	{
		$tpl->local		= true;
	}

	if ($rename)
	{
		$tpl->rename	= true;
	}

	if (!$hide_description)
	{
		$tpl->desc		= true;
	}

	$tpl->leave(); // u_
}
else
{
	$message		= '<em>' . $this->_t('UploadForbidden') . '</em>';
	$tpl->message	= $this->show_message($message, 'note', false);
}
