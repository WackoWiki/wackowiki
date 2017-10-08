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

$selected	= '';
$parent_id	= '';
$options	= '';

// redirect to show method if page don't exists
if (!$this->page)
{
	$this->http->redirect($this->href());
}

if ($this->is_owner() || $this->is_admin())
{
	if (isset($_POST))
	{
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

			$this->log(4, 'Updated page categories [[/' . $this->tag . ' ' . $this->page['title'] . ']]');
			$this->set_message($this->_t('CategoriesUpdated'), 'success');
			$this->http->redirect($this->href('properties'));
		}
		else if ($this->is_admin() || $this->db->owners_can_change_categories == true)
		{
			// get categories
			if (isset($_POST['category_id']))
			{
				$word = $this->db->load_single(
					"SELECT category_id, parent_id, category " .
					"FROM " . $this->db->table_prefix . "category " .
					"WHERE category_id = '" . (int) $_POST['category_id'] . "' " .
						"AND category_lang = " . $this->page['page_lang'] . " " .
					"LIMIT 1");
			}

			// add item
			if (isset($_POST['create']) && isset($_POST['category']))
			{
				// do we have identical names?
				if ($this->db->load_single(
					"SELECT category_id " .
					"FROM " . $this->db->table_prefix . "category " .
					"WHERE category = " . $this->db->q($_POST['category']) . " " .
					"LIMIT 1"))
				{
					$this->set_message($this->_t('CategoriesAlreadyExists'));
					$_POST['change_id']	= $_POST['category_id'];
					$_POST['create']	= 1;
				}
				else
				{
					$this->db->sql_query(
						"INSERT INTO " . $this->db->table_prefix . "category SET " .
							($_POST['category_id'] && $_POST['group'] == 1
								? "parent_id = '". (int)($word['parent_id'] != 0
									? $word['parent_id']
									: $word['category_id'] ) . "', "
								: ''
							) .
							"category_lang			= " . $this->db->q($this->page['page_lang']) . ", " .
							"category				= " . $this->db->q($_POST['category']) . ", " .
							"category_description	= " . $this->db->q($_POST['category_description']) . " ");

					$this->set_message($this->_t('CategoriesAdded'), 'success');
					$this->log(4, 'Created a new category //' . $_POST['category'] . '//');
					unset($_POST['create']);
				}

				$this->http->redirect($this->href('categories', '', 'edit'));
			}
			// rename item
			else if (isset($_POST['rename']) && isset($_POST['category']) && isset($_POST['category_id']))
			{
				// do we have identical names?
				if ($this->db->load_single(
					"SELECT category_id " .
					"FROM " . $this->db->table_prefix . "category " .
					"WHERE category = " . $this->db->q($_POST['category']) . " " .
						"AND category_id <> '" . (int) $_POST['category_id'] . "' " .
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
							"category = " . $this->db->q($_POST['category']) . " " .
						"WHERE category_id = '" . (int) $_POST['category_id'] . "' " .
						"LIMIT 1");

					$this->set_message($this->_t('CategoriesRenamed'), 'success');
					$this->log(4, 'Category //' . $word['category'] . '// renamed //' . $_POST['category'] . '//');
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
						"WHERE category_id = '" . (int) $_POST['category_id'] . "' " .
						"LIMIT 1");

					$this->set_message($this->_t('CategoriesUngrouped'), 'success');
					$this->log(4, 'Category //' . $word['category'] . '// debundled');
				}
				else
				{
					$parent = $this->db->load_single(
						"SELECT parent_id, category " .
						"FROM " . $this->db->table_prefix . "category " .
						"WHERE category_id = '" . (int) $_POST['parent_id'] . "' " .
						"LIMIT 1");

					if ($parent['parent_id'] == 0)
					{
						$this->db->sql_query(
							"UPDATE " . $this->db->table_prefix . "category SET " .
								"parent_id = '" . (int) $_POST['parent_id'] . "' " .
							"WHERE category_id = '" . (int) $_POST['category_id'] . "' " .
							"LIMIT 1");

						$this->db->sql_query(
							"UPDATE " . $this->db->table_prefix . "category SET " .
								"parent_id = 0 " .
							"WHERE parent_id = '" . (int) $_POST['category_id'] . "'");

						$this->set_message($this->_t('CategoriesGrouped'), 'success');
						$this->log(4, 'Category //' . $word['category'] . '// grouped with the word //' . $parent['category'] . '//');
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
					"WHERE category_id = '" . (int) $_POST['category_id'] . "'");

				$this->db->sql_query(
					"DELETE FROM " . $this->db->table_prefix . "category_assignment " .
					"WHERE category_id = '" . (int) $_POST['category_id'] . "'");

				$this->db->sql_query(
					"UPDATE " . $this->db->table_prefix . "category SET " .
						"parent_id = 0 " .
					"WHERE parent_id = '" . (int) $_POST['category_id'] . "'");

				$this->set_message($this->_t('CategoriesDeleted'), 'success');
				$this->log(4, 'Category //' . $word['category'] . '// removed from the database');

				$this->http->redirect($this->href('categories', '', 'edit'));
			}
		}

		/////////////////////////////////////////////
		//   edit forms
		/////////////////////////////////////////////

		if ($this->is_admin() || $this->db->owners_can_change_categories == true)
		{
			$edit_header = '<h3>' . $this->_t('CategoriesTip') . "</h3>\n" .
				'<ul class="menu">
					<li><a href="' . $this->href('categories', '', '') . '">' . $this->_t('CategoriesAssign') . '</a></li>
					<li class="active">' . $this->_t('CategoriesEdit') . '</li>' .
				"</ul><br />\n";

			// add new item
			if (isset($_POST['create']))
			{
				if (isset($_POST['change_id']) || isset($_POST['category_id']))
				{
					$word = $this->db->load_single(
						"SELECT category_id, parent_id, category " .
						"FROM " . $this->db->table_prefix . "category " .
						"WHERE category_id = '" . (int) $_POST['change_id'] . "' " .
						"LIMIT 1");

					$parent_id = ($word['parent_id'] == 0 ? $word['category_id'] : $parent_id = $word['parent_id']);
				}

				echo $edit_header;
				echo $this->form_open('add_category', ['page_method' => 'categories']);
				echo '<input type="hidden" name="category_id" value="' . (int) $parent_id . '" />' . "\n";
				echo '<table class="formation">' .
						'<tr>' .
							'<td>' .
								'<label for="new_category">' . $this->_t('CategoriesAdd') . '</label>' .
							'</td>' .
							'<td>' .
								'<input type="text" name="category" id="new_category" value="' . (isset($_POST['category']) ? htmlspecialchars($_POST['category'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) : '' ) . '" size="20" maxlength="100" />' .
							'</td>' .
						'</tr>' .
						'<tr>' .
							'<td>' .
								'<label for="category_description">' . $this->_t('CategoryDescription') . '</label>' .
							'</td>' .
							'<td>' .
								'<textarea id="category_description" name="category_description" rows="4" cols="51" maxlength="250"></textarea>' .
							'</td>' .
						'</tr>'.
						'<tr>' .
							'<td>';

				if ($parent_id)
				{
					echo		'<input type="radio" id="group1" name="group" value="1" checked /> ' .
								'<label for="group1">' . $this->_t('CategoriesAddGrouped') . ' <code>' . $word['category'] . '</code>.</label><br />' .
								'<input type="radio" id="group0" name="group" value="0" /> ' .
								'<label for="group0">' . $this->_t('CategoriesAddGroupedNo') . '</label><br /><br />';
				}

				echo			'<input type="submit" id="submit" name="create" value="' . $this->_t('CategoriesSaveButton') . '" /> ' .
								'<a href="' . $this->href('categories') . '" class="btn_link"><input type="button" id="button" value="' . $this->_t('CategoriesCancelButton') . '" /></a>' .
							'</td>' .
						'</tr>' .
					'</table><br />';
				echo $this->form_close();
			}
			// rename item
			else if (isset($_POST['rename']) && isset($_POST['change_id']))
			{
				if ($word = $this->db->load_single(
					"SELECT category
					FROM " . $this->db->table_prefix . "category
					WHERE category_id = '" . (int) $_POST['change_id'] . "'
					LIMIT 1"))
				{
					echo $edit_header;
					echo $this->form_open('rename_category', ['page_method' => 'categories']);
					echo '<input type="hidden" name="category_id" value="' . (int) $_POST['change_id'] . '" />' . "\n";
					echo '<table class="formation">' .
							'<tr>' .
								'<td>' .
									'<label for="new_name">' . Ut::perc_replace($this->_t('CategoriesRename'), '<code>' . htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) . '</code>') . '</label> ' .
									'<input type="text" name="category" id="new_name" value="' . (isset($_POST['category']) ? htmlspecialchars($_POST['category'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) : htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) ) . '" size="20" maxlength="100" /> '.
									'<input type="submit" name="rename" id="submit_new_name" value="' . $this->_t('CategoriesSaveButton') . '" /> ' .
									'<a href="' . $this->href('categories') . '" class="btn_link"><input type="button" id="button" value="' . $this->_t('CategoriesCancelButton') . '" /></a>' .
									'<br /><small>' . $this->_t('CategoriesRenameInfo') . '</small>' .
								'</td>' .
							'</tr>' .
						'</table><br />';
					echo $this->form_close();
				}
			}
			// (un)group item
			else if (isset($_POST['ugroup']) && isset($_POST['change_id']))
			{
				if ($word = $this->db->load_single(
					"SELECT category_id, parent_id, category, category_lang
					FROM " . $this->db->table_prefix . "category
					WHERE category_id = '" . (int) $_POST['change_id'] . "'
					LIMIT 1"))
				{
					$parents = $this->db->load_all(
						"SELECT category_id, category " .
						"FROM " . $this->db->table_prefix . "category " .
						"WHERE parent_id = 0 " .
							"AND category_lang = " . $this->db->q($word['category_lang']) . " " .
							"AND category_id <> '" . $word['category_id'] . "' " .
						"ORDER BY category ASC");

					foreach ($parents as $parent)
					{
						$options .= '<option value="' . $parent['category_id'] . '" ' . ($word['parent_id'] == $parent['category_id'] ? 'selected' : '') . '>' . htmlspecialchars($parent['category'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) . "</option>\n";
					}

					echo $edit_header;
					echo $this->form_open('group_categories', ['page_method' => 'categories']);
					echo '<input type="hidden" name="category_id" value="' . (int) $_POST['change_id'] . '" />' . "\n" .
						 '<table class="formation">' .
							'<tr>' .
								'<td>' .
									'<label for="">' . Ut::perc_replace($this->_t('CategoriesGroup'), '<code>' . htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) . '</code>') . '</label> ' .
									'<select style="width:100px;" name="parent_id">' .
										'<option value="0">[no group]</option>' .
										$options .
									'</select> ' .
									'<input type="submit" id="submit" name="ugroup" value="' . $this->_t('CategoriesSaveButton') . '" /> ' .
									'<a href="' . $this->href('categories') . '" class="btn_link"><input type="button" id="button" value="' . $this->_t('CategoriesCancelButton') . '" /></a>' .
									'<br /><small>' . $this->_t('CategoriesGroupInfo') . '</small>' .
								'</td>' .
							'</tr>' .
						'</table><br />';
					echo $this->form_close();
				}
			}

			// delete item
			else if (isset($_POST['delete']) && isset($_POST['change_id']) && $_POST['change_id'])
			{
				if ($word = $this->db->load_single(
					"SELECT category
					FROM " . $this->db->table_prefix . "category
					WHERE category_id = '" . (int) $_POST['change_id'] . "'
					LIMIT 1"))
				{
					echo $edit_header;
					echo $this->form_open('remove_category', ['page_method' => 'categories']);
					echo '<input type="hidden" name="category_id" value="' . (int) $_POST['change_id'] . '" />' . "\n" .
						'<table class="formation">' .
							'<tr>' .
								'<td>' .
									'<label for="">' . Ut::perc_replace($this->_t('CategoriesDelete'), '<code>' . htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML5, HTML_ENTITIES_CHARSET) . '</code>') . '</label> ' .
									'<input type="submit" id="submit_delete" name="delete" value="' . $this->_t('DeleteText') . '" /> ' .
									'<a href="' . $this->href('categories') . '" class="btn_link"><input type="button" id="button" value="' . $this->_t('CategoriesCancelButton') . '" /></a>' .
									'<br /><small>' . $this->_t('CategoriesDeleteInfo') . '</small>' .
								'</td>' .
							'</tr>' .
						'</table><br />';
					echo $this->form_close();
				}
			}
			else if (@$_POST && empty($_POST['change_id']))
			{
				// no record selected
				$this->set_message($this->_t('NoCategorySelected'), 'info');
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
					&& ($this->is_admin() || $this->db->owners_can_change_categories == true);

		if (isset($_GET['edit']))
		{
			echo '<h3>' . $this->_t('CategoriesTip') . "</h3>\n";
			echo '<ul class="menu">
					<li><a href="' . $this->href('categories', '', '') . '">' . $this->_t('CategoriesAssign') . '</a></li>
					<li class="active">' . $this->_t('CategoriesEdit') . '</li>' .
				"</ul><br />\n";
		}
		else
		{
			echo '<h3>' .
					$this->_t('CategoriesFor') . ' ' . $this->compose_link_to_page($this->tag, '', '', 0) .
				"</h3>\n";
			echo '<ul class="menu">
					<li class="active">' . $this->_t('CategoriesAssign') . '</li>' .
					($this->is_admin() || $this->db->owners_can_change_categories == true
						? '<li><a href="' . $this->href('categories', '', 'edit') . '">' . $this->_t('CategoriesEdit') . '</a></li>'
						: '') .
				"</ul><br />\n";
		}

		echo $this->form_open('store_categories', ['page_method' => 'categories']);

		echo $this->show_category_form($this->page['page_id'], OBJECT_PAGE, $this->page['page_lang'], $can_edit);

		echo "<br /><br />";
		echo $this->form_close();
	}
}
else
{
	$message = $this->_t('ACLAccessDenied');
	$this->show_message($message, 'info');
}
