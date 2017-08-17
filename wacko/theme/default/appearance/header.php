<?php
/*
 Default theme.
 Common header file.
*/

if (!defined('IN_WACKO'))
{
	exit;
}

require Ut::join_path(THEME_DIR, '_common/_header.php');

// site logo and title
if ($this->db->site_logo && $this->db->logo_display >= 1)
{
	$tpl->site_logo			= true;
	$tpl->site_logo_path	= $this->db->base_url . Ut::join_path(IMAGE_DIR, $this->db->site_logo);
}
else
{
	$tpl->site_logo			= false;
}

if ($this->db->logo_display == 0
	|| $this->db->logo_display == 2
	#|| (!$this->db->site_logo && $this->db->logo_display >= 1)
)
{
	$tpl->site_title		= true;
}
else
{
	$tpl->site_title		= false;
}

if (@$this->page['tag'] == $this->db->root_page)
{
	$tpl->site_link			= false;
}
else
{
	$tpl->site_link			= true;
}

// if user are logged, shows "You are UserName"
if (($logged_in = $this->get_user()))
{
	$tpl->uare_link		= $this->link($this->db->users_page . '/' . $this->get_user_name(), '', $this->get_user_name());
	$tpl->uare_account	= $this->compose_link_to_page($this->_t('AccountLink'), '', $this->_t('AccountText'), 0);
	$tpl->uare_logout	= $this->href('', $this->_t('LoginPage'), ['action' => 'logout']);
}
// else shows login's controls
else
{
	// show register / login link
	$tpl->login_link	= $this->compose_link_to_page($this->_t('LoginPage'), '', $this->_t('LoginPage'), 0, '');

	if ($this->db->allow_registration)
	{
		$tpl->login_reg_link = $this->compose_link_to_page($this->_t('RegistrationPage'), '', $this->_t('RegistrationPage'), 0);
	}
	// show help link
	//  "<li>" . $this->compose_link_to_page($this->_t('HelpPage'), "", $this->_t('Help'), 0) . "</li>\n";
}

$max_items = $logged_in ? $logged_in['menu_items'] : $this->db->menu_items;
$i = 0;

$tpl->enter('menu_');

foreach ((array) $this->get_menu() as $menu_item)
{
	if ($i++ == $max_items)
	{
		// start dropdown menu for bookmarks over max_items
		$tpl->leave();
		$tpl->enter('dropmenu_menu_');
	}

	$tpl->commit = true;

	if ($this->page['page_id'] == $menu_item[0])
	{
		$tpl->active_item	= $menu_item[1];
	}
	else
	{
		$tpl->item_link		= $this->format($menu_item[2], 'post_wacko');
	}
}

$tpl->leave();

if ($logged_in)
{
	// determines what it should show: "add to menu" or "remove from menu" icon
	if (!in_array($this->page['page_id'], (array) $this->get_menu_links()))
	{
		$tpl->addmark_href		= $this->href('', '', ['addbookmark' => 1]);
	}
	else if (!$this->get_menu_default())
	{
		$tpl->removemark_href	= $this->href('', '', ['removebookmark' => 1]);
	}
}

// defining tabs constructor
//		$image = 0 text only, 1 image only, 2 image and text
$echo_tab = function ($method, $hint, $title, $image, $tab_class = '', $access_key = '', $params = null) use (&$tpl)
{
	$tpl->class = $tab_class ?: ('m-' . $method);

	if (!strncmp($this->method, $method, strlen($method))) // STS why?!
	{
		$tpl->active = ' active';
		$tpl->enter('in_');
	}
	else
	{
		$tpl->enter('out_');
		$tpl->method	= ($method == 'show' ? '.' : $this->href($method));
		$tpl->hint		= $this->_t($hint);
		$tpl->params	= $params;

		if ($access_key !== '')
		{
			$tpl->key = $access_key;
		}
	}

	$image == 1 or $tpl->t_title = $this->_t($title);
	$image == 0 or $tpl->t_im_title = $this->_t($title);
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

	if (!$this->count_revisions($this->page['page_id'], 0, $this->is_admin()))
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

	// show more tab
	$tpl->leave();
	$tpl->enter('droptab_tab_');

	// display more icon and text
	//  '<li class="sublist"><a href="#" id="more-icon"><img src="' . $this->db->theme_url . 'icon/more.png" title="' . $this->_t('PageHandlerMoreTip') . '" alt="' . $this->_t('PageHandlerMoreTip') . '" /> ' . $this->_t('PageHandlerMoreTip') . "</a> \n";
	// only display 'more' text that shows handler list on hover

	// print tab
	if ($readable)
	{
		$echo_tab('print', 'PrintVersion', 'PrintText', 2, '', 'v', ' target="_blank"');
	}

	// create tab
	if ($this->has_access('create') || $this->is_admin())
	{
		$echo_tab('new', 'CreateNewPageTip', 'CreateNewPageText', 2, '', 'n');
	}

	// clone tab
	if ($this->has_access('create') || $this->is_admin())
	{
		$echo_tab('clone', 'ClonePage', 'CloneText', 2, '', '');
	}

	// remove tab
	if (($this->is_admin()
		|| (!$this->db->remove_onlyadmins
			&& ($this->forum ? $this->is_owner() && (int) $this->page['comments'] == 0 : $this->is_owner()))))
	{
		$echo_tab('remove', 'DeleteTip', 'DeleteText', 2, '', '');
	}

	// rename tab
	if ($this->is_admin() || ($this->is_owner()
		&& (!$this->forum || (int) $this->page['comments'] != 0)))
	{
		$echo_tab('rename', 'RenameTip', 'RenameText', 2, '', '');
	}

	// moderation tab
	if ($readable && $this->is_moderator())
	{
		$echo_tab('moderate', 'ModerateTip', 'ModerateText', 2, '', 'm');
	}

	// permissions tab
	if (!$this->forum && ($this->is_admin() || $this->is_owner()))
	{
		$echo_tab('permissions', 'ACLTip', 'ACLText', 2, '', 'a');
	}

	// categories tab
	if ($this->is_admin() || $this->is_owner())
	{
		$echo_tab('categories', 'CategoriesTip', 'CategoriesText', 2, '', 'c');
	}

	// referrers tab
	$echo_tab('referrers', 'ReferrersTip', 'ReferrersText', 2, '', 'l');

	// watch tab
		// ($this->forum === false && $this->page && ($this->is_admin() || $this->is_owner())) ? ($this->is_watched === true ? $this->_t('UnWatchText') : $this->_t('WatchText') ) : '',
	if ($logged_in)
	{
		if ($this->is_watched)
		{
			$echo_tab('watch', 'RemoveWatch', 'UnWatchText', 2, 'watch-off', 'w');
		}
		else
		{
			$echo_tab('watch', 'SetWatch', 'WatchText', 2, 'watch-on', 'w');
		}
	}

	// review tab
	if (!$this->forum && $readable && $this->db->review && $this->is_reviewer())
	{
		if ($this->page['reviewed'])
		{
			$echo_tab('review', 'RemoveReview', 'Reviewed', 2, 'review2', 'z');
		}
		else
		{
			$echo_tab('review', 'SetReview', 'Review', 2, 'review1', 'z');
		}
	}

	// attachments tab
	if (!$this->forum && $readable)
	{
		$echo_tab('attachments', 'FilesTip', 'FilesText', 2, '', 'f');
	}

	// upload tab
	if (!$this->forum && $this->has_access('upload'))
	{
		$echo_tab('upload', 'UploadFiles', 'UploadFile', 2, '', 'u');
	}
}
$tpl->leave();

$tpl->search		= $this->href('', $this->_t('SearchPage'));
$tpl->breadcrumbs	= $this->get_page_path($titles = false, ' &gt; ', true, true);
// '<br />' . $this->get_user_trail($titles = true, ' &gt; ', true, $size = 8);

if (!isset($this->sess->php_version))
{
	if (version_compare(PHP_VERSION, PHP_MIN_VERSION) < 0)
	{
		$this->set_message($this->_t('ErrorMinPHPVersion'), 'error');
	}

	$this->sess->php_version = 1;
}

// here we show messages
foreach ($this->output_messages(false) as $message)
{
	$tpl->msg_one_data = $message;
}
