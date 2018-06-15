<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
print page or file license.
	{{license [license="CC-BY-SA"] [license_id=ID] [icon=0|1]}
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
	icon		= show license icons
	intro		= show intro text

	https://creativecommons.org/choose/
	https://en.wikipedia.org/wiki/Creative_Commons_license
	https://creativecommons.org/about/downloads - icons
*/
if (!isset($intro))			$intro		= 1;
if (!isset($license))		$license	= '';
if (!isset($icon))			$icon		= 0;
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
	$licenses = [
		'1'		=> ['CC-BY-ND',		2,	'https://creativecommons.org/licenses/by-nd/4.0/'],
		'2'		=> ['CC-BY-NC-SA',	2,	'https://creativecommons.org/licenses/by-nc-sa/4.0/'],
		'3'		=> ['CC-BY-NC-ND',	2,	'https://creativecommons.org/licenses/by-nc-nd/4.0/'],
		'4'		=> ['CC-BY-SA',		2,	'https://creativecommons.org/licenses/by-sa/4.0/'],
		'5'		=> ['CC-BY-NC',		2,	'https://creativecommons.org/licenses/by-nc/4.0/'],
		'6'		=> ['CC-BY',		2,	'https://creativecommons.org/licenses/by/4.0/'],
		'7'		=> ['CC-ZERO',		1,	'https://creativecommons.org/publicdomain/zero/1.0/'],
		'8'		=> ['GNU-FDL',		2,	'https://www.gnu.org/licenses/fdl.html'],
		'9'		=> ['PD',			1,	'https://creativecommons.org/publicdomain/mark/1.0/'],
		'10'	=> ['CR',			3,	''],
	];
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
	$meta		= $this->_t('LicenseMeta');
	$text		= $this->_t('LicenseArray');

	$tpl->enter('l_');

	if ($intro)
	{
		$tpl->intro		= true;
	}

	if (empty($license_id))
	{
		$license_id	= $abbreviation[$license];
	}

	if (isset($licenses[$license_id]))
	{
		if (!empty($licenses[$license_id][2]))
		{
			$tpl->a_href	= $licenses[$license_id][2];
			$tpl->ea		= true;
		}

		if ($icon)
		{
			$tpl->i_abbr	= $licenses[$license_id][0];
			$tpl->i_text	= $text[$license_id];
		}

		$tpl->text	= $text[$license_id];
		$tpl->meta	= $meta[$licenses[$license_id][1]];

		// TODO: rel="license"
		#$this->link($licenses[$license][1], '', $text[$license]) . '<br>' .
	}
	else
	{
		// free-form text
		$tpl->text	= $this->format($this->format($license, 'wacko'), 'post_wacko');
	}

	$tpl->leave();
}

