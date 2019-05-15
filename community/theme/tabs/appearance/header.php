<?php
/*
 Tabs theme.
 Common header file.
*/

// TODO: isset($meta_title) ... else ... in common _header.php
#$meta_title = (isset($this->page['title']) ? $this->page['title'] : $this->add_spaces($this->tag)).($this->method != 'show' ? ' (' . $this->method . ')' : '') . " (@".htmlspecialchars($this->db->site_name, ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) . ")";

require (Ut::join_path(THEME_DIR, '_common/_header.php'));

$this->db->footer_inside = 0;

 if (!$this->get_user()) $tpl->LoggedOut = 'LoggedOut';

// if user are logged, shows "You are UserName"
if (($logged_in = $this->get_user()))
{
	$tpl->uare_link		= $this->link($this->db->users_page . '/' . $this->get_user_name(), '', $this->get_user_name());
	$tpl->uare_account	= $this->compose_link_to_page($this->_t('AccountLink'), '', $this->_t('AccountText'), $this->_t('AccountTip'));
	$tpl->uare_logout	= $this->href('', $this->_t('LoginPage'), ['action' => 'logout']);

	if ($this->is_admin())
	{
		$tpl->uare_ap_link	= $this->href('', 'admin.php', [], false, '', false);
	}
}
// else shows login's controls
else
{
	// show register / login link
	$tpl->login_link	= $this->compose_link_to_page($this->_t('LoginPage'), '', $this->_t('LoginPage'), '');

	if ($this->db->allow_registration)
	{
		$tpl->login_reg_link = $this->compose_link_to_page($this->_t('RegistrationPage'), '', $this->_t('RegistrationPage'));
	}
}

// default menu
$max_items = $this->db->menu_items;
$i = 0;

$tpl->enter('menu_');

foreach ((array) $this->get_default_menu($logged_in['user_lang']) as $menu_item)
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
		$tpl->item_link		= $this->format($this->format($menu_item[2]), 'post_wacko'); // TODO: put default menu in session next to user menu! -> format($menu_item[2])
	}
}

$tpl->leave();

// user menu
$max_items = $logged_in['menu_items'];
$i = 0;

$tpl->enter('menu2_');

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


if ($this->method == 'edit') $tpl->edit = true;

if ($logged_in)
{
	$tpl->enter('u_');

	$tpl->watch = ($this->is_watched ? $this->_t('RemoveWatch') : $this->_t('SetWatch'));

	// determines what it should show: "add to menu" or "remove from menu" icon
	if (!in_array($this->page['page_id'], (array) $this->get_menu_links()))
	{
		$tpl->addmark_href		= $this->href('', '', ['addbookmark' => 1]);
	}
	else if (!$this->get_menu_default())
	{
		$tpl->removemark_href	= $this->href('', '', ['removebookmark' => 1]);
	}

	$tpl->leave();
}


$tpl->pagepath = (isset($this->page['title']) ? $this->page['title'] : $this->get_page_path());

if (($this->method != 'edit') || !$this->has_access('write'))
{
	$tpl->noedit = true;
}



$tpl->search		= $this->href('', $this->_t('SearchPage'));
$tpl->breadcrumbs	= $this->get_page_path(false, ' &gt; ', true, true);
# $tpl->usertrail	= $this->get_user_trail(true, ' &gt; ', true, $size = 8);

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
	// do not cache pages with notices!
	$this->http->no_cache(false);

	$tpl->msg_one_data = $message;
}

