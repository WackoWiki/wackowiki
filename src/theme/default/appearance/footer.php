<?php
/*
 Default theme.
 Common footer file.
 */

if (!defined('IN_WACKO'))
{
	exit;
}

// user lang dir
if ($this->languages[$this->page_lang]['dir'] != $this->user_lang_dir)
{
	$tpl->dir	= ' dir="' . $this->user_lang_dir . '"';
}

// if user has rights to edit page, show Edit link
if ($this->has_access('write') && $this->method != 'edit')
{
	$tpl->edit_href = $this->href('edit');
}

if ($this->page && $this->has_access('read'))
{
	if ($mtime = $this->page['modified'])
	{
		// revisions link
		if ($this->hide_revisions)
		{
			$tpl->modHide_time = $mtime;
		}
		else
		{
			$tpl->mod_time = $mtime;
			$tpl->mod_revisions = $this->href('revisions');
		}
	}

	// show owner of this page
	if ($owner = $this->get_page_owner())
	{
		if ($owner == 'System')
		{
			$tpl->owner_name = $owner;
		}
		else
		{
			$tpl->owner_link = $this->user_link($owner, true, false);
		}
	}
	else if (!$this->page['comment_on_id'])
	{
		if ($this->get_user())
		{
			$tpl->claim_take_href = $this->href('claim');
		}
		else
		{
			$tpl->claim = true;
		}
	}

	// permalink
	if ($this->method == 'show')
	{
		$tpl->perma_link = $this->action('hashid');
	}
}

$tpl->enter('credits_');

if ($this->get_user())
{
	$tpl->by_home = $this->link('WackoWiki:HomePage', '', 'WackoWiki');

	// STS: no need to add to config_default, it's private -dev feature
	if ($this->is_admin())
	{
		$tpl->by_version	= $this->get_wacko_version();
		$tpl->by_patchlevel	= @$this->db->wacko_patchlevel;
	}
}

// comment this out for not showing privacy link at the bottom of your pages
if ($this->db->license)
{
	#$tpl->license_text = $this->_t('License')[$this->db->license];
	#$tpl->license_text = $this->action('authors');
	$tpl->license_text = $this->action('license', ['intro' => 0]);
}

// comment this out for not showing help link at the bottom of your pages
if ($this->db->help_page)
{
	$tpl->help_href = $this->href('', $this->db->help_page);
}

// comment this out for not showing privacy link at the bottom of your pages
if ($this->db->privacy_page)
{
	$tpl->privacy_href = $this->href('', $this->db->privacy_page);
}

// comment this out for not showing website tos link at the bottom of your pages
if ($this->db->terms_page)
{
	$tpl->terms_href = $this->href('', $this->db->terms_page);
}

$tpl->leave(); // credits

// load scripts
$tpl->f_additions = $this->get_html_addition('footer');
