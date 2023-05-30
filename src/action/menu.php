<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$info = <<<EOD
Description:
	To edit and customize your bookmarks.

Usage:
	{{menu}}

Options:
	[system=1]
		Global default bookmarks are displayed for administrators to edit.
EOD;

$menu_sorting = function ($a, $b)
{
	if ($a['menu_position'] == $b['menu_position'])
	{
		return 0;
	}

	return ($a['menu_position'] < $b['menu_position'])
		? -1
		: 1;
};

$load_user_menu = function ($user_id, $lang = '')
{
	return $this->db->load_all(
		'SELECT p.tag, p.title, m.menu_id, m.user_id, m.menu_title, m.menu_lang, m.menu_position ' .
		'FROM ' . $this->prefix . 'menu m ' .
			'LEFT JOIN ' . $this->prefix . 'page p ON (m.page_id = p.page_id) ' .
		'WHERE m.user_id = ' . (int) $user_id . ' ' .
			($lang
				? 'AND m.menu_lang = ' . $this->db->q($lang) . ' '
				: '') .
		'ORDER BY m.menu_position', false);
};

// set defaults
$help			??= 0;
$system			??= 0;

if ($help)
{
	$tpl->help	= $this->help($info, 'menu');
	return;
}

$default_menu	= false;
$menu_lang		= '';
$message		= '';
$prefix			= $this->prefix;
$user			= [];

// get default menu items
if ($this->is_admin() && $system)
{
	$_user_id		= $this->db->system_user_id;
	$default_menu	= true;

	$menu_lang = ($this->db->multilanguage? @$_REQUEST['menu_lang'] : '');

	if (!$this->known_language($menu_lang))
	{
		$menu_lang = $this->db->language;
	}
}
else
{
	$user		= $this->get_user();
	$_user_id	= $user['user_id'];
}

/// Processing of our special form
if (isset($_POST['_user_menu']))
{
	$_menu		= $load_user_menu($_user_id, $menu_lang);
	$a			= $_menu;
	$b			= [];

	foreach ($a as $k => $v)
	{
		$b[$k]['user_id']		= $v['user_id'];
		$b[$k]['menu_id']		= $v['menu_id'];
		$b[$k]['menu_position']	= $v['menu_position'];
		$b[$k]['menu_title']	= $v['menu_title'];
		$b[$k]['tag']			= $v['tag'];
	}

	$this->data['user_menu'] = & $b;

	if (isset($_POST['update_menu']))
	{
		// reposition
		$data = [];

		foreach ($this->data['user_menu'] as $k => $item)
		{
			$data[] = [
				'menu_id'		=> $item['menu_id'],
				'menu_position'	=> 1 * $_POST['pos_' . $item['menu_id']]
			];
		}

		usort ($data, $menu_sorting);

		foreach ($data as $k => $item)
		{
			$data[$k]['menu_position'] = $k + 1;
		}

		// save
		foreach ($data as $item)
		{
			$menu_title		= $this->sanitize_text_field($_POST['title_' . $item['menu_id']], true);
			$menu_title		= mb_substr(trim($menu_title), 0, 250);

			$this->db->sql_query(
				'UPDATE ' . $prefix . 'menu SET ' .
					'menu_position	= ' . (int) $item['menu_position'] . ', ' .
					'menu_title		= ' . $this->db->q($menu_title) . ' ' .
				'WHERE menu_id		= ' . (int) $item['menu_id'] . ' ' .
				'LIMIT 1');
		}
	}
	else if (isset($_POST['add_menu_item']))
	{
		// process input
		if (!empty($_POST['tag']))
		{
			$new_tag = utf8_trim($_POST['tag'], '/ ');
			$new_tag = trim($new_tag); // again, strip whitespace

			// check target page existence
			if ($page = $this->load_page($new_tag, 0, null, LOAD_CACHE, LOAD_META))
			{
				$_page_id		= $this->get_page_id($new_tag);
				$_user_lang		= $_POST['lang_new'] ?? $user['user_lang'];

				// check existing page read access
				if ($this->has_access('read', $_page_id))
				{
					// check if menu item already exists
					if ($this->db->load_single(
						'SELECT menu_id ' .
						'FROM ' . $prefix . 'menu ' .
						'WHERE user_id = ' . (int) $_user_id . ' ' .
							($default_menu
								? 'AND menu_lang = ' . $this->db->q($_user_lang) . ' '
								: '') .
							'AND page_id = ' . (int) $_page_id. ' ' .
						'LIMIT 1'))
					{
						$message .= $this->_t('BookmarkAlreadyExists');
					}
					else
					{
						// writing new menu item
						$_menu_position = $this->db->load_all(
							'SELECT menu_id ' .
							'FROM ' . $prefix . 'menu ' .
							'WHERE user_id = ' . (int) $_user_id . ' ' .
								($default_menu
									? 'AND menu_lang = ' . $this->db->q($_user_lang) . ' '
									: '')
								, false);

						$_menu_lang			= (($_user_lang != $page['page_lang']) && $default_menu === false
												? $page['page_lang']
												: $_user_lang);
						$_menu_item_count	= count($_menu_position);

						$this->db->sql_query(
							'INSERT INTO ' . $prefix . 'menu SET ' .
								'user_id			= ' . (int) $_user_id . ', ' .
								'page_id			= ' . (int) $_page_id. ', ' .
								'menu_lang			= ' . $this->db->q($_menu_lang) . ', ' .
								'menu_position		= ' . (int)($_menu_item_count + 1));

						#$message .= $this->_t('MenuItemAdded'); // TODO: msg set
					}
				}
				else
				{
					// no access rights
					$message .= $this->_t('ReadAccessDenied');
				}
			}
			else
			{
				// page does not exit
				$message .= $this->_t('DoesNotExists');
			}
		}
		else
		{
			// no page given
			#$message .= $this->_t('PageAlreadyExistsEditDenied');
		}

		$this->set_message($message);
	}
	else if (isset($_POST['delete_menu_item']))
	{
		$menu_ids = [];

		foreach ($this->data['user_menu'] as $item)
		{
			if (isset($_POST['delete_' . $item['menu_id']]))
			{
				$menu_ids[] = $item['menu_id'];
			}
		}

		if (!empty($menu_ids))
		{
			$this->db->sql_query(
				'DELETE ' .
				'FROM ' . $prefix . 'menu ' .
				'WHERE menu_id IN (' . $this->ids_string($menu_ids) . ')');
		}
	}

	// purge SQL queries cache
	$this->config->invalidate_sql_cache();

	// update user menu
	$this->set_menu(MENU_USER, true);
}

if ($_user_id)
{
	$_menu = $load_user_menu($_user_id, $menu_lang);

	// display form
	if ($_menu)
	{
		$tpl->enter('bm_');

		if ($default_menu)
		{
			$tpl->lang_select	= $this->show_select_lang('menu_lang', $menu_lang, true);
		}

		$tpl->enter('l_');

		foreach ($_menu as $menu_item)
		{
			$tpl->menuid	= $menu_item['menu_id'];
			$tpl->position	= $menu_item['menu_position'];
			$tpl->menutitle	= $menu_item['menu_title'];
			$tpl->tag		= $menu_item['tag'];
			$tpl->title		= $menu_item['title'];
		}

		$tpl->leave(); // l_
		$tpl->leave(); // bm_
	}
	else
	{
		$tpl->none = true;
	}

	if ($default_menu)
	{
		$tpl->enter('default_');

		$tpl->lang_select	= $this->show_select_lang('lang_new', $menu_lang, false);
		$tpl->menulang		= $menu_lang;

		$tpl->leave(); // default_
	}
}
