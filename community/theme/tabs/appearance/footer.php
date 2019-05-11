<?php

// defining tabs constructor
//	$image = 0 text only, 1 image only, 2 image and text
$echo_tab = function ($method, $hint, $title, $image, $tab_class = '', $access_key = '', $bonus = '', $params = null) use (&$tpl)
{
	# $tpl->class = $tab_class ?: ('m-' . $method);

	if (!strncmp($this->method, $method, strlen($method))) // STS why?!
	{
		$tpl->xsize		= 8;
		$tpl->ysize		= 30;
		$tpl->bonus		=  $bonus;
		$tpl->class		=  'Selected';

		# $tpl->active = ' active';
		$tpl->enter('in_');
	}
	else
	{
		$tpl->xsize		= 7;
		$tpl->ysize		= 25;
		$tpl->bonus		=  $bonus;
		$tpl->bonus1	=  $bonus == "2a" ? 'del' : '1';
		$tpl->bonus2	=  $bonus == "2a" ? 'del' : '';
		$tpl->appendix	= 1;

		$tpl->enter('out_');
		$tpl->method	= ($method == 'show' ? $this->href() : $this->href($method));
		$tpl->hint		= $this->_t($hint);

		$tpl->params	= $params;

		if ($access_key !== '')
		{
			$tpl->key = $access_key;
		}
	}

	$tpl->title		= $this->_t($title);

	# $image == 1 or $tpl->t_title	= $this->_t($title);
	# $image == 0 or $tpl->t_im_title	= $this->_t($title);
	$tpl->leave();
};



$tpl->enter('tab_');

$echo_tab('show', 'ShowTip', 'ShowText', 1, '', 'v');

if (!$this->page)
{
	if ($this->has_access('create') || $this->is_admin())
	{
		$echo_tab('edit', 'EditTip', 'EditText', 1, '', 'e');
		$echo_tab('new', 'CreateNewPageTip', 'CreateNewPageText', 1, '', 'n');
	}
}
else
{

	$readable = $this->has_access('read');

	// edit or source tab
	if ($this->is_admin()
		|| ($this->forum
			? ($this->is_owner() || $this->is_moderator()) && (int) $this->page['comments'] == 0
			: $this->has_access('write')))
	{
		$echo_tab('edit', 'EditTip', 'EditText', 1, '', 'e');
	}
	else if ($readable)
	{
		$echo_tab('source', 'SourceTip', 'SourceText', 1, '', 'e');
	}

	/*
	 * too expensive query for every page call
	 *	- adds now real revision count to page table or just check $this->page['version_id'] > 1
	 *	- update revision count if revisions were be purged manually or by time
	if (!$this->count_revisions($this->page['page_id'], 0, $this->is_admin()))*/
	if (!$this->page['revisions'])
	{
		// no revisions - nothing to show
		$this->hide_revisions = -1;
	}

	// revisions tab
	if (!$this->forum && $readable && !$this->hide_revisions)
	{
		$echo_tab('revisions', 'RevisionTip', 'RevisionText', 1, '', 'r');
	}

	// properties tab
	if (!$this->forum && ($this->is_owner()) || $this->is_admin())
	{
		$echo_tab('properties', 'PropertiesTip', 'PropertiesText', 1, '', 's');
	}

	// permissions tab
	if (!$this->forum && ($this->is_owner() || $this->is_admin()))
	{
		$echo_tab('permissions', 'ACLTip', 'ACLText', 2, '', 'a');
	}

	// remove tab
	if ($this->is_admin()
		|| (!$this->db->remove_onlyadmins
			&& ($this->forum ? $this->is_owner() && (int) $this->page['comments'] == 0 : $this->is_owner())))
	{
		$echo_tab('remove', 'DeleteTip', 'DeleteText', 2, '', '', '2a');
	}

	// create tab
	if ($this->has_access('create') || $this->is_admin())
	{
		$echo_tab('new', 'CreateNewPageTip', 'CreateNewPageText', 2, '', 'n', '2');
	}

	// referrers tab
	$echo_tab('referrers', 'ReferrersTip', 'ReferrersText', 2, '', 'l', '2');
}

$tpl->leave();




// if this page exists
if ($this->page && $this->has_access('read'))
{
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

// load scripts
$tpl->f_additions = $this->get_html_addition('footer');





?>
<!-- !! -->
<?php
if ($this->method == 'show')
{
	// files code starts
	if ($this->has_access('read') && $this->db->footer_files == 1 || ($this->db->footer_files == 2 && $this->get_user()))
	{
		require_once Ut::join_path(HANDLER_DIR, 'page/_files.php');
	}

	// comments form output  starts
	if ($this->has_access('read') && ($this->db->footer_comments == 1 || ($this->db->footer_comments == 2 && $this->get_user()) ) && $this->user_allowed_comments())
	{
		require_once Ut::join_path(HANDLER_DIR, 'page/_comments.php');
	}

	// rating form output begins
	if ($this->has_access('read') && $this->page && $this->db->footer_rating == 1 || ($this->db->footer_rating == 2 && $this->get_user()))
	{
		require_once Ut::join_path(HANDLER_DIR, 'page/_rating.php');
	}

} //end of $this->method==show
?>
<!-- !!! -->


<?php

// don't place final </body></html> here. Wacko closes HTML automatically.

?>
