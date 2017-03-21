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

echo '<h3>';
echo $this->_t('CategoriesFor') . ' ' . $this->compose_link_to_page($this->tag, '', '', 0);
echo "</h3>\n<br />\n";

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
			$this->remove_categories($this->tag);

			// save new list
			$this->save_categories_list($this->page['page_id']);

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
					$_POST['change_id'] = $_POST['category_id'];
					$_POST['create'] = 1;
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

				$this->http->redirect($this->href('categories'));
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
					$_POST['change_id'] = $_POST['category_id'];
					$_POST['rename'] = 1;
				}
				else
				{
					$this->db->sql_query(
						"UPDATE " . $this->db->table_prefix . "category SET " .
							"category = " . $this->db->q($_POST['category']) . " " .
						"WHERE category_id = '" . (int) $_POST['category_id'] . "' " .
						"LIMIT 1");

					$this->set_message($this->_t('CategoriesRenamed'));
					$this->log(4, 'Category //' . $word['category'] . '// renamed //' . $_POST['category'] . '//');
				}

				$this->http->redirect($this->href('categories'));
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

					$this->set_message($this->_t('CategoriesUngrouped'));
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

						$this->set_message($this->_t('CategoriesGrouped'));
						$this->log(4, 'Category //' . $word['category'] . '// grouped with the word //' . $parent['category'] . '//');
					}
					else
					{
						$this->set_message($this->_t('NoMultilevelGrouping'));
					}
				}

				$this->http->redirect($this->href('categories'));
			}
			// delete item
			else if (isset($_POST['delete']) && isset($_POST['category_id']))
			{
				$this->db->sql_query(
					"DELETE FROM " . $this->db->table_prefix . "category " .
					"WHERE category_id = '" . (int) $_POST['category_id'] . "'");

				$this->db->sql_query(
					"DELETE FROM " . $this->db->table_prefix . "category_page " .
					"WHERE category_id = '" . (int) $_POST['category_id'] . "'");

				$this->db->sql_query(
					"UPDATE " . $this->db->table_prefix . "category SET " .
						"parent_id = 0 " .
					"WHERE parent_id = '" . (int) $_POST['category_id'] . "'");

				$this->set_message($this->_t('CategoriesDeleted'));
				$this->log(4, 'Category //' . $word['category'] . '// removed from the database');

				$this->http->redirect($this->href('categories'));
			}
		}

		/////////////////////////////////////////////
		//   building list
		/////////////////////////////////////////////

		// load categories for the page's particular language
		$categories = $this->get_categories_list($this->page['page_lang'], 0);

		// get currently selected category_ids
		$_selected = $this->db->load_all(
			"SELECT category_id " .
			"FROM " . $this->db->table_prefix . "category_page " .
			"WHERE page_id = '" . $this->page['page_id'] . "'");

		// exploding categories into array
		foreach ($_selected as $key => &$val)
		{
			if (is_array($val))
			{
				$selected[$key] = $val['category_id'];
				# unset($selected[$key]);
			}
		}

		/////////////////////////////////////////////
		//   edit forms
		/////////////////////////////////////////////

		if ($this->is_admin() || $this->db->owners_can_change_categories == true)
		{
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

				echo $this->form_open('add_category', ['page_method' => 'categories']);
				echo '<input type="hidden" name="category_id" value="' . (int) $parent_id . '" />' . "\n";
				echo '<table class="formation">';
				echo '<tr><td><label for="new_category">' . $this->_t('CategoriesAdd') . '</label></td>' .
					'<td><input type="text" name="category" id="new_category" value="' . (isset($_POST['category']) ? htmlspecialchars($_POST['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '' ) . '" size="20" maxlength="100" /></td></tr>';
				echo '<tr><td><label for="category_description">' . $this->_t('CategoryDescription') . '</label></td>' .
					'<td><textarea id="category_description" name="category_description" rows="4" cols="51" maxlength="250"></textarea></td></tr>';

				echo '<tr><td>';

				if ($parent_id)
				{
					echo '<small><input type="radio" id="group1" name="group" value="1" checked /> <label for="group1">' . $this->_t('CategoriesAddGrouped') . ' \'<code>' . $word['category'] . '</code>\'.</label></small><br />';
					echo '<small><input type="radio" id="group0" name="group" value="0" /> <label for="group0">' . $this->_t('CategoriesAddGroupedNo') . '</label></small><br /><br />';
				}

				echo '<input type="submit" id="submit" name="create" value="' . $this->_t('CategoriesSaveButton') . '" /> '.
					 '<a href="' . $this->href('categories') . '" style="text-decoration: none;"><input type="button" id="button" value="' . $this->_t('CategoriesCancelButton') . '" /></a>' .
					 '</td></tr>';
				echo '</table><br />';
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
					echo $this->form_open('rename_category', ['page_method' => 'categories']);
					echo '<input type="hidden" name="category_id" value="' . (int) $_POST['change_id'] . '" />' . "\n";
					echo '<table class="formation">';
					echo '<tr><td><label for="new_name">' .
						$this->_t('CategoriesRename') . ' \'<code>' . htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</code>\' in</label> ' .
						'<input type="text" name="category" id="new_name" value="' . (isset($_POST['category']) ? htmlspecialchars($_POST['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) ) . '" size="20" maxlength="100" /> '.
						'<input type="submit" id="submit" name="rename" value="' . $this->_t('CategoriesSaveButton') . '" /> ' .
						'<a href="' . $this->href('categories') . '" style="text-decoration: none;"><input type="button" id="button" value="' . $this->_t('CategoriesCancelButton') . '" /></a>' .
						'<br /><small>' . $this->_t('CategoriesRenameInfo') . '</small>' .
						'</td></tr>';
					echo '</table><br />';
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
						$options .= '<option value="' . $parent['category_id'] . '" ' . ($word['parent_id'] == $parent['category_id'] ? 'selected' : '') . '>' . htmlspecialchars($parent['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</option>';
					}

					echo $this->form_open('group_categories', ['page_method' => 'categories']);
					echo '<input type="hidden" name="category_id" value="' . (int) $_POST['change_id'] . '" />' . "\n";
					echo '<table class="formation">';
					echo '<tr><td><label for="">' .
						$this->_t('CategoriesGroup') . ' \'<code>' . htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</code>\' with</label> ' .
						'<select style="width:100px;" name="parent_id">' .
							'<option value="0">[no group]</option>' .
							$options.
						'</select> '.
						'<input type="submit" id="submit" name="ugroup" value="' . $this->_t('CategoriesSaveButton') . '" /> '.
						'<a href="' . $this->href('categories') . '" style="text-decoration: none;"><input type="button" id="button" value="' . $this->_t('CategoriesCancelButton') . '" /></a>' .
						'<br /><small>' . $this->_t('CategoriesGroupInfo') . '</small>' .
						'</td></tr>';
					echo '</table><br />';
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
					echo $this->form_open('remove_category', ['page_method' => 'categories']);
					echo '<input type="hidden" name="category_id" value="' . (int) $_POST['change_id'] . '" />' . "\n";
					echo '<table class="formation">';
					echo '<tr><td><label for="">' .
						$this->_t('CategoriesDelete') . ' \'<code>' . htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</code>\'?</label> '.
						'<input type="submit" id="submit" name="delete" value="' . $this->_t('DeleteText') . '" /> '.
						'<a href="' . $this->href('categories') . '" style="text-decoration: none;"><input type="button" id="button" value="' . $this->_t('CategoriesCancelButton') . '" /></a>' .
						'<br /><small>' . $this->_t('CategoriesDeleteInfo') . '</small>' .
						'</td></tr>';
					echo '</table><br />';
					echo $this->form_close();
				}
			}
			else if (@$_POST && empty($_POST['change_id']))
			{
				// no record selected
				$this->set_message($this->_t('NoCategorySelected'), 'info');
				$this->http->redirect($this->href('categories'));
			}
		}
	}

	/////////////////////////////////////////////
	//   print list
	/////////////////////////////////////////////

	if (!$_POST)
	{
		echo $this->form_open('store_categories', ['page_method' => 'categories']);

		// print categories list
		if (is_array($categories))
		{
			$i = '';

			echo '<ul class="ul_list hide_radio">' . "\n";

			foreach ($categories as $category_id => $word)
			{
				# if ($n++ > 0) echo '<hr />';
				echo '<li class="lined"><span class="">' . "\n\t";
				echo ($this->is_admin() || $this->db->owners_can_change_categories == true
						? '<input type="radio" name="change_id" value="' . $category_id . '" />'
						: '') .
					'<input type="checkbox" id="category' . $category_id . '" name="category' . $category_id . '|' . $word['parent_id'] . '" value="set"' . (is_array($selected) ? ( in_array($category_id, $selected) ? ' checked' : '') : '') . ' /> ' . "\n\t" .
					'<label for="category' . $category_id . '"><strong>' . htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</strong></label></span>' . "\n";

				if (isset($word['childs']) && $word['childs'] == true)
				{
					foreach ($word['childs'] as $category_id => $word)
					{
						if ($i++ < 1)
						{
							echo "\t<ul>\n";
						}

						echo "\t\t" . '<li><span class="nobr">' . "\n\t\t\t" .
								($this->is_admin() || $this->db->owners_can_change_categories == true
									? '<input type="radio" name="change_id" value="' . $category_id . '" />' . "\n\t\t\t"
									: '') .
								'<input type="checkbox" id="category' . $category_id . '" name="category' . $category_id . '|' . $word['parent_id'] . '" value="set"' . (is_array($selected) ? (in_array($category_id, $selected) ? ' checked' : '') : '') . ' />' . "\n\t\t\t" .
								'<label for="category' . $category_id . '">' . htmlspecialchars($word['category'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</label></span>' . "\n\t\t" .
							'&nbsp;&nbsp;&nbsp;</li>' . "\n";
					}
				}

				if ($i > 0)
				{
					echo "\t</ul>\n</li>\n";
				}
				else
				{
					echo "</li>\n";
				}

				$i = 0;
			}

			echo "</ul>\n";

			/////////////////////////////////////////////
			//   control buttons
			/////////////////////////////////////////////

			echo '<br />';
			echo '<input type="submit" id="submit" name="save" value="' . $this->_t('CategoriesStoreButton') . '" /> ';
			echo '<a href="' . $this->href('') . '" style="text-decoration: none;"><input type="button" id="button" value="' . $this->_t('CategoriesCancelButton') . '"/></a> ';
			echo '<small><br />' . $this->_t('CategoriesStoreInfo') . '<br /><br /></small> ';
		}
		else
		{
			// availability depends on the page language and your access rights
			// additionally you need also the right to create new categories
			echo $this->_t('NoCategoriesForThisLanguage') . '<br /><br /><br />';
			echo '<a href="' . $this->href('') . '" style="text-decoration: none;"><input type="button" id="button" value="' . $this->_t('CategoriesCancelButton') . '" /></a><br /><br /> ';
		}

		if ($this->is_admin() || $this->db->owners_can_change_categories == true)
		{
			#echo '<hr />';
			echo '<input type="submit" id="add-button" name="create" value="' . $this->_t('CategoriesAddButton') . '" /> ';
			echo '<input type="submit" id="rename-button" name="rename" value="' . $this->_t('CategoriesRenameButton') . '" /> ';
			echo '<input type="submit" id="group-button" name="ugroup" value="' . $this->_t('CategoriesGroupButton') . '" /> ';
			echo '<input type="submit" id="remove-button" name="delete" value="' . $this->_t('CategoriesRemoveButton') . '" /> ';
			echo '<small><br />' . $this->_t('CategoriesEditInfo') . '</small> ';
		}

		echo "<br /><br />";
		echo $this->form_close();
	}
}
else
{
	$message = $this->_t('ACLAccessDenied');
	$this->show_message($message, 'info');
}
