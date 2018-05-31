<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
print page or file license.
	{{license [license="CC-BY-SA"] license_id=[ID]}
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
if (empty($license) && !isset($license_id) && $this->db->enable_license)
{
	$license_id	= $this->db->allow_license_per_page
					? ($this->page['license_id'] ?: ($this->db->license ?? ''))
					: ($this->db->license ?? '');
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
	// TODO:	wacko.all.php ($wacko_all_resource[]) is not available,
	//			when page_lang != user_lang, why?
	$licenses		= $this->_t('LicenseIds');
	$text			= $this->_t('LicenseArray');

	if (empty($license_id))
	{
		$license_id	= $abbreviation[$license];
	}

	if (isset($licenses[$license_id]))
	{
		if (!empty($licenses[$license_id][1]))
		{
			$tpl->l_a_href	= $licenses[$license_id][1];
			$tpl->l_ea		= true;
		}

		$tpl->l_i_abbr	= $licenses[$license_id][0];
		$tpl->l_text	= $text[$license_id];

		// TODO: rel="license"
		#$this->link($licenses[$license][1], '', $text[$license]) . '<br>' .
	}
	else
	{
		// free-form text
		$tpl->l_text	= $this->format($this->format($license, 'wacko'), 'post_wacko');
	}
}

