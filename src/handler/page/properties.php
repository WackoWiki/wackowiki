<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$this->ensure_page();

$tpl->head = Ut::perc_replace($this->_t('PropertiesFor'), $this->compose_link_to_page($this->tag, '', ''));

// STS write? really?
if (!($this->is_owner() || $this->is_admin() || $this->has_access('write', $this->page['page_id'])))
{
	$this->set_message($this->_t('AclAccessDenied'), 'error');
	$this->show_must_go_on();
}

$mode			= '';
$action			= $_POST['_action'] ?? null;
$custom_menus	= $this->db->custom_menus ?? false;

if ($action === 'extended_properties')
{
	$mode = 'extended';
	$this->db->sql_query(
		"UPDATE " . $this->prefix . "page SET " .
			"footer_comments	= " . (int) $_POST['footer_comments'] . ", " .
			"footer_files		= " . (int) $_POST['footer_files'] . ", " .
			($custom_menus
				?	"hide_toc			= " . (int) $_POST['hide_toc'] . ", " .
					"hide_index			= " . (int) $_POST['hide_index'] . ", " .
					"tree_level			= " . (int) $_POST['tree_level'] . ", "
				:	"") .
			($this->is_admin()
				?	"allow_rawhtml		= " . (int) $_POST['allow_rawhtml'] . ", " .
					"disable_safehtml	= " . (int) $_POST['disable_safehtml'] . ", "
				:	"") .
			"typografica		= " . (int) $_POST['typografica'] . ", " .
			"noindex			= " . (int) $_POST['noindex'] . " " .
		"WHERE page_id = " . (int) $this->page['page_id'] . " " .
		"LIMIT 1");
}

if ($action === 'general_properties')
{
	$page_lang		= $this->validate_language($_POST['page_lang']);
	// accepts also empty theme (uses then global theme)
	$theme			= $_POST['theme'] ? $this->validate_theme($_POST['theme']) : '';

	#$menu_tag		= $this->sanitize_text_field($_POST['menu_tag'], true);
	$title			= $this->sanitize_text_field($_POST['title'], true);
	$keywords		= $this->sanitize_text_field($_POST['keywords'], true);
	$description	= $this->sanitize_text_field($_POST['description'], true);

	$this->db->sql_query(
		"UPDATE " . $this->prefix . "page SET " .
			"page_lang			= " . $this->db->q($page_lang) . ", " .
			"theme				= " . $this->db->q($theme) . ", " .
			"license_id			= " . (int) ($_POST['license'] ?? '') . ", " .
			// menu_tag: unused currently, for use in custom theme menus
			# "menu_tag			= " . $this->db->q($menu_tag) . ", " .
			# "show_menu_tag	= " . (int) $_POST['show_menu_tag'] . ", " .
			"title				= " . $this->db->q($title) . ", " .
			"keywords			= " . $this->db->q($keywords) . ", " .
			"description		= " . $this->db->q($description) . " " .
		"WHERE page_id = " . (int) $this->page['page_id'] . " " .
		"LIMIT 1");
}

if ($_POST)
{
	// log event
	$this->log(4, Ut::perc_replace($this->_t('LogPagePropertiesUpdated', SYSTEM_LANG), $this->tag . ' ' . ($_POST['title'] ?? $this->page['title'])));

	// reload page
	$this->set_message($this->_t('MetaUpdated'), 'success');
	$this->http->redirect($this->href('properties', '', $mode));
}

// show form

// EXTENDED
if (isset($_GET['extended']))
{
	// load settings (shows only if owner is current user or Admin)
	if ($this->is_owner() || $this->is_admin())
	{
		$tpl->enter('e_x_');
		$tpl->comments		= (int) $this->db->footer_comments;
		$tpl->files			= (int) $this->db->footer_files;

		// hide_toc, hide_index, tree_level: used in custom theme menus
		if ($custom_menus)
		{
			$tpl->custom_hidetoc	= (int) $this->db->hide_toc;
			$tpl->custom_hideindex	= (int) $this->db->hide_index;
			$tpl->custom_treelevel	= (int) $this->db->tree_level;
		}

		$tpl->typografica	= (int) $this->page['typografica'];
		$tpl->noindex		= (int) $this->page['noindex'];

		if ($this->is_admin())
		{
			$tpl->html_raw	= (int) $this->db->allow_rawhtml;
			$tpl->html_safe	= (int) $this->db->disable_safehtml;
		}

		$tpl->leave(); // e_x_
	}
	else
	{
		$tpl->e = true;
	}
}
// GENERAL
else
{
	// show form
	// load settings (shows only if owner is current user or Admin)
	if ($this->is_owner() || $this->is_admin())
	{
		$tpl->enter('g_f_');
		$tpl->page = $this->page;

		if ($categories = $this->action('categories', ['list' => 0, 'nomark' => 1, 'label' => 0], true))
		{
			$tpl->categories_html = $categories;
		}

		$langs = $this->http->available_languages();

		if (!($clang = $this->page['page_lang']) || !isset($langs[$clang]))
		{
			$this->set_message(Ut::perc_replace($this->_t('NeedToChangeLang'), '<code>' . $clang . '</code>'), 'error');
			$clang = $this->db->language;
		}

		$languages = $this->_t('LanguageArray');

		foreach ($langs as $lang)
		{
			$tpl->o_lang	= $lang;
			$tpl->o_name	= $languages[$lang];
			$tpl->o_sel		= (int) ($clang == $lang);
		}

		if ($this->db->allow_themes_per_page)
		{
			foreach ($this->available_themes() as $theme)
			{
				$tpl->themes_o_theme	= $theme;
				$tpl->themes_o_sel		= (int) (isset($this->page['theme']) && $this->page['theme'] == $theme);
			}
		}

		if ($this->db->enable_license && $this->db->allow_license_per_page)
		{
			foreach ($this->_t('LicenseArray') as $offset => $license)
			{
				$tpl->licenses_o_license	= '[' . $this->_t('LicenseIds')[$offset][0] . '] ' . $license;
				$tpl->licenses_o_id			= $offset;
				$tpl->licenses_o_sel		= (int) (isset($this->page['license_id']) && $this->page['license_id'] == $offset);
			}
		}

		$tpl->leave(); // g_f_
	}
	else
	{
		$tpl->g_w_page = $this->page;
	}
}

$tpl->page		= $this->page;
$tpl->owner		= $this->user_link($this->page['owner_name'], true, false);
$tpl->bodylen	= $this->binary_multiples($this->page['page_size'], false, true, true);
$tpl->bodyrlen	= $this->binary_multiples(strlen($this->page['body_r']), false, true, true);
$tpl->version	= $this->page['version_id'];


$watchers = $this->db->load_single(
		"SELECT COUNT(page_id) AS n " .
		"FROM " . $this->prefix . "watch " .
		"WHERE page_id = {$this->page['page_id']} " .
		"LIMIT 1", true);

$tpl->wat_number	= $watchers['n'];

$tpl->i = true; // turn on icon

// rename link (shows only if owner is current user or Admin)
// ACL link (shows only if owner is current user or Admin)
if ($this->is_owner() || $this->is_admin())
{
	$tpl->rename_i	= true;
	$tpl->perm_i	= true;
}

// remove link (shows only for page owner if allowed or Admin)
if (($this->is_owner() && !$this->db->remove_onlyadmins) || $this->is_admin())
{
	$tpl->remove_i = true;
}

// moderate link (shows only if current user is Moderator or Admin)
if ($this->is_moderator() || $this->is_admin())
{
	$tpl->moder_i = true;
}

if (((	$this->db->export_handler == 2 && $this->get_user())
	||	$this->db->export_handler == 1))
{
	$tpl->export_i = true;
}

$tpl->watched = (int) $this->is_watched;
