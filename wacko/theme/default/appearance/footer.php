<?php
/*
 Default theme.
 Common footer file.
 */

if (!defined('IN_WACKO'))
{
	exit;
}

// If User has rights to edit page, show Edit link
if ($this->has_access('write') && $this->method != 'edit')
{
	$tpl->edit_href = $this->href('edit');
}

if ($this->page && $this->has_access('read'))
{
	if (($mtime = $this->page['modified']))
	{
		// Revisions link
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

	// Show Owner of this page
	if ($owner = $this->get_page_owner())
	{
		if ($owner == 'System')
		{
			$tpl->owner_name = $owner;
		}
		else
		{
			$tpl->owner_link = $this->user_link($owner, '', true, false);
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

	// Permalink
	$tpl->perma_link = $this->action('hashid');
}

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
if ($this->db->privacy_page)
{
	$tpl->privacy_url = $this->href('', $this->db->privacy_page);
}

// comment this out for not showing website tos link at the bottom of your pages
if ($this->db->terms_page)
{
	$tpl->terms_url = $this->href('', $this->db->terms_page);
}

// load scripts
$tpl->f_additions = $this->get_html_addition('footer');
