<?php

if (!defined('IN_WACKO'))
{
	exit;
}

/*
	https://creativecommons.org/choose/
	https://en.wikipedia.org/wiki/Creative_Commons_license
	https://creativecommons.org/about/downloads - icons
*/

$info = <<<EOD
Description:
	Prints page or file license.

Usage:
	{{license}}

Options:
	[license="CC-BY-SA"]
		some free-form text (wiki-formatting applies) or one of predefined constants:
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
	[license_id=ID]
		assigned db value
	[icon=0|1]
		show license icons
	[intro=0|1]
		show intro text
EOD;

// set defaults
$help		??= 0;
$icon		??= 0;
$intro		??= 1;
$license	??= '';

if ($help)
{
	$tpl->help	= $this->action('help', ['info' => $info, 'action' => 'license']);
	return;
}

// check for license_id
if (empty($license) && !isset($license_id) && $this->db->enable_license)
{
	$license_id	= $this->db->allow_license_per_page
					? ($this->page['license_id'] ?: ($this->db->license ?? ''))
					: ($this->db->license ?? '');
}

if ($license || $license_id)
{
	// id => [abbrivation, meta_id, url]
	$licenses = $this->_t('LicenseIds');

	// get translation arrays
	$meta		= $this->_t('LicenseMeta');
	$text		= $this->_t('LicenseArray');

	$tpl->enter('l_');

	if ($intro)
	{
		$tpl->intro		= true;
	}

	if (empty($license_id))
	{
		$license_id	= array_search($license, array_combine(array_keys($licenses), array_column($licenses, 0)));
	}

	if (isset($licenses[$license_id]))
	{
		if (!empty($licenses[$license_id][2]))
		{
			$lang = '';

			if (preg_match('/https:\/\/creativecommons\.org\//', $licenses[$license_id][2]))
			{
				$lang = 'deed.' . ($this->get_user()['user_lang'] ?? $this->http->user_agent_language());
			}

			$tpl->a_href	= $licenses[$license_id][2] . $lang;
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
