<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Categories tags tagging annotation labels
// TODO:
//	- multilevel hierarchical categories (first we need to
//	  find a way to unwrap table-structured SQL data array
//	  into a tree-structured multilevel array)
//	- split in functions and move into new class -> tagging for attachments

$parent_id	= '';

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->http->redirect($this->href());
}

if (   $this->is_owner()
	|| $this->is_admin()
	|| ($this->get_user() && $this->db->categories_handler == 2))
{
	// indicate page language, categories were defined per lang
	if ($this->db->multilanguage)
	{
		$languages			= $this->_t('LanguageArray');

		$tpl->l_language	= $languages[$this->page_lang];
		$tpl->l_lang		= $this->page_lang;
		$tpl->l_charset		= $this->get_charset();
	}

	if (isset($_POST))
	{
		$category				= $this->sanitize_text_field(($_POST['category'] ?? ''), true);
		$category_description	= $this->sanitize_text_field(($_POST['category_description'] ?? ''));

		/////////////////////////////////////////////
		//   list change/update
		/////////////////////////////////////////////

		// update Categories list for the current page
		if (isset($_POST['save']))
		{
			// clear old list
			$this->remove_category_assigments($this->page['page_id'], OBJECT_PAGE);

			// save new list
			$this->save_categories_list($this->page['page_id'], OBJECT_PAGE);

			$this->log(4, Ut::perc_replace($this->_t('LogCategoriesUpdated', SYSTEM_LANG), $this->tag . ' ' . $this->page['title']));
			$this->set_message($this->_t('CategoriesUpdated'), 'success');
			$this->http->redirect($this->href('properties'));
		}
		else if ($this->is_admin() || ($this->is_owner() && $this->db->categories_handler))
		{
			// get categories
			if (isset($_POST['category_id']))
			{
				$word = $this->db->load_single(
					"SELECT category_id, parent_id, category " .
					"FROM " . $this->db->table_prefix . "category " .
					"WHERE category_id = " . (int) $_POST['category_id'] . " " .
						"AND category_lang = " . $this->db->q($this->page['page_lang']) . " " .
					"LIMIT 1");
			}

			// add item
			if (isset($_POST['create']) && isset($_POST['category']))
			{
				// do we have identical name for this language?
				if ($this->db->load_single(
					"SELECT category_id " .
					"FROM " . $this->db->table_prefix . "category " .
					"WHERE category = " . $this->db->q($category) . " " .
						"AND category_lang = " . $this->db->q($this->page['page_lang']) . " " .
					"LIMIT 1"))
				{
					$this->set_message($this->_t('CategoriesAlreadyExists'));
					$_POST['change_id']	= $_POST['category_id'];
					$_POST['create']	= 1;
				}
				else
				{
					// save item
					$this->db->sql_query(
						"INSERT INTO " . $this->db->table_prefix . "category SET " .
							($_POST['category_id'] && $_POST['group'] == 1
								? "parent_id = " . ((int) $word['parent_id'] != 0
									? (int) $word['parent_id']
									: (int) $word['category_id'] ) . ", "
								: ''
							) .
							"category_lang			= " . $this->db->q($this->page['page_lang']) . ", " .
							"category				= " . $this->db->q($category) . ", " .
							"category_description	= " . $this->db->q($category_description) . " ");

					$this->set_message(Ut::perc_replace($this->_t('CategoriesAdded'), '<code>' . $category . '</code>'), 'success');
					$this->log(4, Ut::perc_replace($this->_t('LogCategoryCreated', SYSTEM_LANG), $_POST['category']));
					unset($_POST['create']);
				}

				$this->http->redirect($this->href('categories', '', 'edit'));
			}
			// rename item
			else if (isset($_POST['rename']) && isset($_POST['category']) && isset($_POST['category_id']))
			{
				// do we have identical name for this language?
				if ($this->db->load_single(
					"SELECT category_id " .
					"FROM " . $this->db->table_prefix . "category " .
					"WHERE category = " . $this->db->q($category) . " " .
						"AND category_lang = " . $this->db->q($this->page['page_lang']) . " " .
						"AND category_id <> " . (int) $_POST['category_id'] . " " .
					"LIMIT 1"))
				{
					$this->set_message($this->_t('CategoriesAlreadyExists'));
					$_POST['change_id']	= $_POST['category_id'];
					$_POST['rename']	= 1;
				}
				else
				{
					$this->db->sql_query(
						"UPDATE " . $this->db->table_prefix . "category SET " .
							"category				= " . $this->db->q($category) . ", " .
							"category_description	= " . $this->db->q($category_description) . " " .
						"WHERE category_id = " . (int) $_POST['category_id'] . " " .
						"LIMIT 1");

					$this->set_message($this->_t('CategoriesRenamed'), 'success');
					$this->log(4, Ut::perc_replace($this->_t('LogCategoryRenamed', SYSTEM_LANG), $word['category'], $_POST['category']));
				}

				$this->http->redirect($this->href('categories', '', 'edit'));
			}
			// (un)group item
			else if (isset($_POST['ugroup']) && isset($_POST['parent_id']) && isset($_POST['category_id']))
			{
				// in or out?
				if ($_POST['parent_id'] == 0)
				{
					$this->db->sql_query(
						"UPDATE " . $this->db->table_prefix . "category SET " .
							"parent_id = 0 " .
						"WHERE category_id = " . (int) $_POST['category_id'] . " " .
						"LIMIT 1");

					$this->set_message($this->_t('CategoriesUngrouped'), 'success');
					$this->log(4, Ut::perc_replace($this->_t('LogCategoryDebundled', SYSTEM_LANG), $word['category']));
				}
				else
				{
					$parent = $this->db->load_single(
						"SELECT parent_id, category " .
						"FROM " . $this->db->table_prefix . "category " .
						"WHERE category_id = " . (int) $_POST['parent_id'] . " " .
						"LIMIT 1");

					if ($parent['parent_id'] == 0)
					{
						$this->db->sql_query(
							"UPDATE " . $this->db->table_prefix . "category SET " .
								"parent_id = " . (int) $_POST['parent_id'] . " " .
							"WHERE category_id = " . (int) $_POST['category_id'] . " " .
							"LIMIT 1");

						$this->db->sql_query(
							"UPDATE " . $this->db->table_prefix . "category SET " .
								"parent_id = 0 " .
							"WHERE parent_id = " . (int) $_POST['category_id']);

						$this->set_message($this->_t('CategoriesGrouped'), 'success');
						$this->log(4, Ut::perc_replace($this->_t('LogCategoryGrouped', SYSTEM_LANG), $word['category'], $parent['category']));
					}
					else
					{
						$this->set_message($this->_t('NoMultilevelGrouping'));
					}
				}

				$this->http->redirect($this->href('categories', '', 'edit'));
			}
			// delete item
			else if (isset($_POST['delete']) && isset($_POST['category_id']))
			{
				$this->db->sql_query(
					"DELETE FROM " . $this->db->table_prefix . "category " .
					"WHERE category_id = " . (int) $_POST['category_id']);

				$this->db->sql_query(
					"DELETE FROM " . $this->db->table_prefix . "category_assignment " .
					"WHERE category_id = " . (int) $_POST['category_id']);

				$this->db->sql_query(
					"UPDATE " . $this->db->table_prefix . "category SET " .
						"parent_id = 0 " .
					"WHERE parent_id = " . (int) $_POST['category_id']);

				$this->set_message($this->_t('CategoriesDeleted'), 'success');
				$this->log(4, Ut::perc_replace($this->_t('LogCategoryRemoved', SYSTEM_LANG), $word['category']));

				$this->http->redirect($this->href('categories', '', 'edit'));
			}
		}

		/////////////////////////////////////////////
		//   edit forms
		/////////////////////////////////////////////

		if ($this->is_admin() || ($this->is_owner() && $this->db->categories_handler))
		{
			// add new item
			if (isset($_POST['create']))
			{
				if (isset($_POST['change_id']) || isset($_POST['category_id']))
				{
					$word = $this->db->load_single(
						"SELECT category_id, parent_id, category " .
						"FROM " . $this->db->table_prefix . "category " .
						"WHERE category_id = " . (int) $_POST['change_id'] . " " .
						"LIMIT 1");

					$parent_id = ($word['parent_id'] == 0 ? $word['category_id'] : $parent_id = $word['parent_id']);
				}

				$tpl->n_header		= true;
				$tpl->n_parentid	= (int)		$parent_id;
				$tpl->n_category	= (string)	($_POST['category'] ?? '');

				if ($parent_id)
				{
					$tpl->n_p_category = $word['category'];
				}
			}
			// rename item
			else if (isset($_POST['rename']) && isset($_POST['change_id']))
			{
				if ($word = $this->db->load_single(
					"SELECT category, category_description
					FROM " . $this->db->table_prefix . "category
					WHERE category_id = " . (int) $_POST['change_id'] . "
					LIMIT 1"))
				{
					$tpl->r_header		= true;
					$tpl->r_changeid	= (int) $_POST['change_id'];
					$tpl->r_newname		= Ut::perc_replace($this->_t('CategoriesRename'), '<code>' . Ut::html($word['category']) . '</code>');
					$tpl->r_category	= ($_POST['category'] ?? $word['category']);
					$tpl->r_description	= ($_POST['category_description'] ?? $word['category_description']);
				}
			}
			// (un)group item
			else if (isset($_POST['ugroup']) && isset($_POST['change_id']))
			{
				if ($word = $this->db->load_single(
					"SELECT category_id, parent_id, category, category_lang
					FROM " . $this->db->table_prefix . "category
					WHERE category_id = " . (int) $_POST['change_id'] . "
					LIMIT 1"))
				{
					$parents = $this->db->load_all(
						"SELECT category_id, category " .
						"FROM " . $this->db->table_prefix . "category " .
						"WHERE parent_id = 0 " .
							"AND category_lang = " . $this->db->q($word['category_lang']) . " " .
							"AND category_id <> " . (int) $word['category_id'] . " " .
						"ORDER BY category ASC");

					$tpl->g_header		= true;
					$tpl->g_changeid	= (int) $_POST['change_id'];
					$tpl->g_group		=  Ut::perc_replace($this->_t('CategoriesGroup'), '<code>' . Ut::html($word['category']) . '</code>');

					foreach ($parents as $parent)
					{
						$tpl->g_o_id			= $parent['category_id'];
						$tpl->g_o_category		= $parent['category'];
						$tpl->g_o_sel			= (int) ($word['parent_id'] == $parent['category_id']);
					}
				}
			}

			// delete item
			else if (isset($_POST['delete']) && isset($_POST['change_id']) && $_POST['change_id'])
			{
				if ($word = $this->db->load_single(
					"SELECT category
					FROM " . $this->db->table_prefix . "category
					WHERE category_id = " . (int) $_POST['change_id'] . "
					LIMIT 1"))
				{
					$tpl->d_header		= true;
					$tpl->d_changeid	= (int) $_POST['change_id'];
					$tpl->d_category	= Ut::perc_replace($this->_t('CategoriesDelete'), '<code>' . Ut::html($word['category']) . '</code>');
				}
			}
			else if (@$_POST && empty($_POST['change_id']))
			{
				// no record selected
				$this->set_message($this->_t('NoCategorySelected'));
				$this->http->redirect($this->href('categories', '', 'edit'));
			}
		}
	}

	/////////////////////////////////////////////
	//   print list
	/////////////////////////////////////////////

	if (!$_POST)
	{
		$can_edit = isset($_GET['edit'])
					&& ($this->is_admin() || ($this->is_owner() && $this->db->categories_handler));

		if (isset($_GET['edit']))
		{
			$tpl->a_header	= true;
		}
		else
		{
			$tpl->a_h_link	= $this->compose_link_to_page($this->tag, '', '');

			if ($this->is_admin() || $this->db->categories_handler)
			{
				$tpl->a_h_edit_href	= $this->href('categories', '', 'edit');
			}
		}

		$tpl->a_form	= $this->show_category_form($this->page['page_lang'], $this->page['page_id'], OBJECT_PAGE, $can_edit);
	}
}
else
{
	$message		= $this->_t('AclAccessDenied');
	$tpl->denied	= $this->show_message($message, 'note', false);
}
