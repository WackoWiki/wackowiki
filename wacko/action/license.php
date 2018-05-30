<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
print page or file license.
	{{license [license="CC-BY-NC-SA"] license_id=[ID]}
	license	= some free-form text (wiki-formatting applies) or one of predefined constants:
				- CC-BY-ND			(CreativeCommons-Attribution-NoDerivatives)
				- CC-BY-NC-SA		(CreativeCommons-Attribution-NonCommercial-ShareAlike)
				- CC-BY-NC-ND		(CreativeCommons-Attribution-Non-Commercial No Derivatives)
				- CC-BY-SA			(CreativeCommons-Attribution-ShareAlike)
				- CC-BY-NC			(CreativeCommons-Attribution Non-Commercial)
				- CC-BY				(CreativeCommons-Attribution)
				- CC-Zero			(CreativeCommons-Zero / public domain)
				- GNU-FDL			(GNU Free Documentation License)
				- PD				(Public Domain)
				- CR				(All Rights Reserved)
	license_id	= assigned db value

	https://creativecommons.org/choose/
	https://en.wikipedia.org/wiki/Creative_Commons_license
*/

if (!isset($license))		$license	= '';
#if (!isset($license_id))	$license_id	= '';

// check for license_id
if (empty($license) && !isset($license_id))
{
	$license_id	= $this->page['license_id'] ?? $this->db->license ?? '';
}

if ($license || $license_id)
{
	// license names and links to texts
	$abbreviation = [
		'CC-BY-ND'		=> 1,
		'CC-BY-NC-SA'	=> 2,
		'CC-BY-NC-ND'	=> 3,
		'CC-BY-SA'		=> 4,
		'CC-BY-NC'		=> 5,
		'CC-BY'			=> 6,
		'CC-ZERO'		=> 7,
		'GNU-FDL'		=> 8,
		'PD'			=> 9,
		'CR'			=> 10,
	];
	$licenses		= $this->_t('LicenseIds');
	$text			= $this->_t('LicenseArray');

	if (empty($license_id))
	{
		$license_id	= $abbreviation[$license];
	}

	if (isset($licenses[$license_id]))
	{
		$icons		= '<img src="' . $this->db->base_url . Ut::join_path(IMAGE_DIR, 'spacer.png') . '" alt="' . $text[$license_id] . '" title="' . $text[$license_id] . '" class="license-' . $licenses[$license_id][0] . '">';
		// constant license
		$license	= $this->_t('DistributedUnder') . '<br>' .

		// TODO: rel="license"
		#$this->link($licenses[$license][1], '', $text[$license]) . '<br>' .
		// TODO: add margin-left: 5px; to span
		'<a rel="license" href="' . $licenses[$license_id][1] . '">' . $icons . '<span>' . $text[$license_id] . '</span></a>';
	}
	else
	{
		// free-form text
		$license = $this->format($this->format($license, 'wacko'), 'post_wacko');
	}

	$output[] = $license;

	// print results
	if ($output)
	{
		echo implode('<br>', $output);
	}
}

