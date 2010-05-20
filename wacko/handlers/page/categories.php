<?php

// Categories tags tagging annotation
// ToDo:
//	- multilevel hierarchical categories (first we need to
//	  find a way to unwrap table-structured SQL data array
//	  into a tree-structured multilevel array)
//	localize message sets

?>
<div id="page">
<h3><?php echo $this->GetTranslation("CategoriesFor")." ".$this->ComposeLinkToPage($this->tag, "", "", 0) ?></h3>
<br />
<?php

$selected = "";
$group = "";

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href("show"));

if ($this->UserIsOwner() || $this->IsAdmin())
{
	/////////////////////////////////////////////
	//   list change/update
	/////////////////////////////////////////////

	// update Categories list for the current page
	if (isset($_POST['save']))
	{
		// clear old list
		$this->RemoveCategories($this->tag);

		// save new list
		$this->SaveCategoriesList($this->page["page_id"]);

		$this->Log(4, "Updated page categories [[/{$this->tag} {$this->page['title']}]]");
		$this->SetMessage($this->GetTranslation('CategoriesUpdated'));
		$this->Redirect($this->href('properties'));
	}
	else if ($this->IsAdmin() || $this->config['owners_can_change_categories'] == true)
	{
		// get categories
		if (isset($_POST['id']))
		{
			$word = $this->LoadSingle(
				"SELECT category_id, parent, category ".
				"FROM {$this->config['table_prefix']}categories ".
				"WHERE category_id = '".quote($this->dblink, $_POST['id'])."' LIMIT 1");
		}

		// add item
		if (isset($_POST['create']) && isset($_POST['newname']))
		{
			// do we have identical names?
			if ($this->LoadSingle(
			"SELECT category_id ".
			"FROM {$this->config['table_prefix']}categories ".
			"WHERE category = '".quote($this->dblink, $_POST['newname'])."' LIMIT 1"))
			{
				$this->SetMessage($this->GetTranslation('CategoriesAlreadyExists'));
				$_POST['change'] = $_POST['id'];
				$_POST['create'] = 1;
			}
			else
			{
				$this->Query(
					"INSERT INTO {$this->config['table_prefix']}categories SET ".
						( $_POST['id'] && $_POST['group'] == 1
							? "parent = '".quote($this->dblink, (int)( $word['parent'] != 0 ? $word['parent'] : $word['category_id'] ))."', "
							: ''
						).
						"lang = '".quote($this->dblink, $this->page['lang'])."', ".
						"category = '".quote($this->dblink, $_POST['newname'])."'");

				$this->SetMessage($this->GetTranslation('CategoriesAdded'));
				$this->Log(4, "Created a new category //'{$_POST['newname']}'//");
				unset($_POST['create']);
			}
		}
		// rename item
		else if (isset($_POST['rename']) && $_POST['newname'] && $_POST['id'])
		{
			// do we have identical names?
			if ($this->LoadSingle(
			"SELECT category_id ".
			"FROM {$this->config['table_prefix']}categories ".
			"WHERE category = '".quote($this->dblink, $_POST['newname'])."' AND category_id <> '".quote($this->dblink, $_POST['id'])."' LIMIT 1"))
			{
				$this->SetMessage($this->GetTranslation('CategoriesAlreadyExists'));
				$_POST['change'] = $_POST['id'];
				$_POST['rename'] = 1;
			}
			else
			{
				$this->Query(
					"UPDATE {$this->config['table_prefix']}categories ".
					"SET category = '".quote($this->dblink, $_POST['newname'])."' ".
					"WHERE category_id = '".quote($this->dblink, $_POST['id'])."' LIMIT 1");

				$this->SetMessage($this->GetTranslation('CategoriesRenamed'));
				$this->Log(4, "category //'{$word['category']}'// renamed //'{$_POST['newname']}'//");
			}
		}
		// (un)group item
		else if (isset($_POST['ugroup']) && isset($_POST['parent']) && $_POST['id'])
		{
			// in or out?
			if ($_POST['parent'] == 0)
			{
				$this->Query(
					"UPDATE {$this->config['table_prefix']}categories ".
					"SET parent = 0 ".
					"WHERE category_id = '".quote($this->dblink, $_POST['id'])."' LIMIT 1");
				$this->SetMessage($this->GetTranslation('CategoriesUngrouped'));
				$this->Log(4, "Category //'{$word['category']}'// debundled");
			}
			else
			{
				$parent = $this->LoadSingle(
					"SELECT parent, category ".
					"FROM {$this->config['table_prefix']}categories ".
					"WHERE category_id = '".quote($this->dblink, $_POST['parent'])."' LIMIT 1");

				if ($parent['parent'] == 0)
				{
					$this->Query(
						"UPDATE {$this->config['table_prefix']}categories ".
						"SET parent = '".quote($this->dblink, $_POST['parent'])."' ".
						"WHERE category_id = '".quote($this->dblink, $_POST['id'])."' LIMIT 1");
					$this->Query(
						"UPDATE {$this->config['table_prefix']}categories ".
						"SET parent = 0 ".
						"WHERE parent = '".quote($this->dblink, $_POST['id'])."'");
					$this->SetMessage($this->GetTranslation('CategoriesGrouped'));
					$this->Log(4, "Category //'{$word['category']}'// grouped with the word //'{$parent['category']}'//");
				}
				else
				{
					$this->SetMessage($this->GetTranslation('NoMultilevelGrouping'));
				}
			}
		}
		// delete item
		else if (isset($_POST['delete']) && $_POST['id'])
		{
			$this->Query(
				"DELETE FROM {$this->config['table_prefix']}categories ".
				"WHERE category_id = '".quote($this->dblink, $_POST['id'])."'");
			$this->Query(
				"DELETE FROM {$this->config['table_prefix']}categories_pages ".
				"WHERE category_id = '".quote($this->dblink, $_POST['id'])."'");
			$this->Query(
				"UPDATE {$this->config['table_prefix']}categories ".
				"SET parent = 0 ".
				"WHERE parent = '".quote($this->dblink, $_POST['id'])."'");
			$this->SetMessage($this->GetTranslation('CategoriesDeleted'));
			$this->Log(4, "Category //'{$word['category']}'// removed from the database");
		}
	}

	/////////////////////////////////////////////
	//   building list
	/////////////////////////////////////////////

	// load categories for the page's particular language
	$categories = $this->GetCategoriesList($this->page['lang'], 0);

	// get currently selected category_ids
	$_selected = $this->LoadAll(
				"SELECT category_id ".
				"FROM {$this->config['table_prefix']}categories_pages ".
				"WHERE page_id = '".$this->page['page_id']."'");

	// exploding categories into array
	foreach ($_selected as $key => &$val)
	{
		if (is_array($val))
		{
			$selected[$key] = $val['category_id'];
			# unset($selected[$key]);
		}
	}
	$selected = $selected;

	/////////////////////////////////////////////
	//   edit forms
	/////////////////////////////////////////////

	if ($this->IsAdmin() || $this->config['owners_can_change_categories'] == true)
	{
		// add new item
		if (isset($_POST['create']))
		{
			if (isset($_POST['change']) || isset($_POST['id']))
			{
				$word = $this->LoadSingle(
					"SELECT category_id, parent, category ".
					"FROM {$this->config['table_prefix']}categories ".
					"WHERE category_id = '".quote($this->dblink, $_POST['change'])."' LIMIT 1");
				$group = ( $word['parent'] == 0 ? $word['category_id'] : $group = $word['parent'] );
			}

			echo $this->FormOpen('categories');
			echo '<input type="hidden" name="id" value="'.htmlspecialchars($group).'" />'."\n";
			echo '<table class="formation">';
			echo '<tr><td><label for="">'.
				$this->GetTranslation('CategoriesAdd').'</label> '.
				'<input name="newname" value="'.( isset($_POST['newname']) ? htmlspecialchars($_POST['newname']) : '' ).'" size="20" maxlength="100" /><br /> ';
			if ($group)
			{
				echo '<small><input type="radio" id="group1" name="group" value="1" checked="checked" /> <label for="group1">'.$this->GetTranslation('CategoriesAddGrouped').' \'<tt>'.$word['category'].'</tt>\'.</label></small><br />';
				echo '<small><input type="radio" id="group0" name="group" value="0" /> <label for="group0">'.$this->GetTranslation('CategoriesAddGroupedNo').'</label></small><br />';
			}
			echo '<input id="submit" type="submit" name="create" value="'.$this->GetTranslation('CategoriesSaveButton').'" /> '.
				'<input id="button" type="button" value="'.$this->GetTranslation('CategoriesCancelButton').'" onclick="document.location=\''.addslashes($this->href('categories')).'\';" />'.
				'</td></tr>';
			echo '</table><br />';
			echo $this->FormClose();
		}
		// rename item
		else if (isset($_POST['rename']) && $_POST['change'])
		{
			if ($word = $this->LoadSingle("SELECT category FROM {$this->config['table_prefix']}categories WHERE category_id = '".quote($this->dblink, $_POST['change'])."' LIMIT 1"))
			{
				echo $this->FormOpen('categories');
				echo '<input type="hidden" name="id" value="'.htmlspecialchars($_POST['change']).'" />'."\n";
				echo '<table class="formation">';
				echo '<tr><td><label for="">'.
					$this->GetTranslation('CategoriesRename').' \'<tt>'.htmlspecialchars($word['category']).'</tt>\' in</label> '.
					'<input name="newname" value="'.( $_POST['newname'] ? htmlspecialchars($_POST['newname']) : htmlspecialchars($word['category']) ).'" size="20" maxlength="100" /> '.
					'<input id="submit" type="submit" name="rename" value="'.$this->GetTranslation('CategoriesSaveButton').'" /> '.
					'<input id="button" type="button" value="'.$this->GetTranslation('CategoriesCancelButton').'" onclick="document.location=\''.addslashes($this->href('categories')).'\';" />'.
					'<br /><small>'.$this->GetTranslation('CategoriesRenameInfo').'</small>'.
					'</td></tr>';
				echo '</table><br />';
				echo $this->FormClose();
			}
		}
		// (un)group item
		else if (isset($_POST['ugroup']) && $_POST['change'])
		{
			if ($word = $this->LoadSingle("SELECT category_id, parent, category, lang FROM {$this->config['table_prefix']}categories WHERE category_id = '".quote($this->dblink, $_POST['change'])."' LIMIT 1"))
			{
				$parents = $this->LoadAll(
					"SELECT category_id, category ".
					"FROM {$this->config['table_prefix']}categories ".
					"WHERE parent = 0 AND lang = '".$word['lang']."' AND category_id != '".$word['category_id']."' ".
					"ORDER BY category ASC");

				foreach ($parents as $parent)
				{
					$options .= '<option value="'.$parent['category_id'].'" '.($word['parent'] == $parent['category_id'] ? 'selected="selected"' : '').'>'.htmlspecialchars($parent['category']).'</option>';
				}

				echo $this->FormOpen('categories');
				echo '<input type="hidden" name="id" value="'.htmlspecialchars($_POST['change']).'" />'."\n";
				echo '<table class="formation">';
				echo '<tr><td><label for="">'.
					$this->GetTranslation('CategoriesGroup').' \'<tt>'.htmlspecialchars($word['category']).'</tt>\' with</label> '.
					'<select style="width:100px;" name="parent">'.
						'<option value="0">[no group]</option>'.
						$options.
					'</select> '.
					'<input id="submit" type="submit" name="ugroup" value="'.$this->GetTranslation('CategoriesSaveButton').'" /> '.
					'<input id="button" type="button" value="'.$this->GetTranslation('CategoriesCancelButton').'" onclick="document.location=\''.addslashes($this->href('categories')).'\';" />'.
					'<br /><small>'.$this->GetTranslation('CategoriesGroupInfo').'</small>'.
					'</td></tr>';
				echo '</table><br />';
				echo $this->FormClose();
			}
		}
		// delete item
		if (isset($_POST['delete']) && $_POST['change'])
		{
			if ($word = $this->LoadSingle("SELECT category FROM {$this->config['table_prefix']}categories WHERE category_id = '".quote($this->dblink, $_POST['change'])."' LIMIT 1"))
			{
				echo $this->FormOpen('categories');
				echo '<input type="hidden" name="id" value="'.htmlspecialchars($_POST['change']).'" />'."\n";
				echo '<table class="formation">';
				echo '<tr><td><label for="">'.
					$this->GetTranslation('CategoriesDelete').' \'<tt>'.htmlspecialchars($word['category']).'</tt>\'?</label> '.
					'<input id="submit" type="submit" name="delete" value="yes" style="width:40px;" /> '.
					'<input id="button" type="button" value="no" style="width:40px;" onclick="document.location=\''.addslashes($this->href('categories')).'\';" />'.
					'<br /><small>'.$this->GetTranslation('CategoriesDeleteInfo').'</small>'.
					'</td></tr>';
				echo '</table><br />';
				echo $this->FormClose();
			}
		}
	}

	/////////////////////////////////////////////
	//   print list
	/////////////////////////////////////////////

	echo $this->FormOpen('categories');

	// print categories list
	if (is_array($categories))
	{
		$i = "";

		foreach ($categories as $id => $word)
		{
			# if ($n++ > 0) echo '<hr />';
			echo ($this->IsAdmin() || $this->config['owners_can_change_categories'] == true ? '<input type="radio" name="change" value="'.$id.'" />' : '').'<input type="checkbox" id="category'.$id.'" name="category'.$id.'|'.$word['parent'].'" value="set"'.(is_array($selected) ? ( in_array($id, $selected) ? ' checked="checked"' : '') : '').' /> <label for="category'.$id.'"><strong>'.htmlspecialchars($word['category']).'</strong></label>'."\n";

			if (isset($word['childs']) && $word['childs'] == true)
			{
				foreach ($word['childs'] as $id => $word)
				{
					if ($i++ < 1) echo '<br /><div class="indent">';
					echo '<span class="nobr">'.($this->IsAdmin() || $this->config['owners_can_change_categories'] == true ? '<input type="radio" name="change" value="'.$id.'" />' : '').'<input type="checkbox" id="category'.$id.'" name="category'.$id.'|'.$word['parent'].'" value="set"'.(is_array($selected) ? ( in_array($id, $selected) ? ' checked="checked"' : '') : '').' /><label for="category'.$id.'">'.htmlspecialchars($word['category']).'</label>&nbsp;&nbsp;&nbsp;</span>'."\n";
				}
			}

			if ($i > 0)
				echo "</div>\n";
			else
				echo "<br />\n";
			$i = 0;
		}

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

		echo '<br />';
		echo '<input id="submit" type="submit" name="save" value="'.$this->GetTranslation('CategoriesStoreButton').'" /> ';
		echo '<input id="button" type="button" value="'.$this->GetTranslation('CategoriesCancelButton').'" onclick="history.back();" /> ';
		echo '<small><br />'.$this->GetTranslation('CategoriesStoreInfo').'<br /><br /></small> ';
	}
	else
	{
		echo $this->GetTranslation('NoCategoriesForThisLanguage').'<br /><br /><br />'; // Availability depends on the page language and your access rights, additionally you need also the right to create new ones.
		echo '<input id="button" type="button" value="'.$this->GetTranslation('CategoriesCancelButton').'" onclick="history.back();" /><br /><br /> ';
	}

	if ($this->IsAdmin() || $this->config['owners_can_change_categories'] == true)
	{
		echo '<input id="button" type="submit" name="create" value="'.$this->GetTranslation('CategoriesAddButton').'" /> ';
		echo '<input id="button" type="submit" name="rename" value="'.$this->GetTranslation('CategoriesRenameButton').'" /> ';
		echo '<input id="button" type="submit" name="ugroup" value="'.$this->GetTranslation('CategoriesGroupButton').'" /> ';
		echo '<input id="button" type="submit" name="delete" value="'.$this->GetTranslation('CategoriesRemoveButton').'" /> ';
		echo '<small><br />'.$this->GetTranslation('CategoriesEditInfo').'</small> ';
	}
	echo "<br /><br />";
	echo $this->FormClose();
}
else
{
	print($this->GetTranslation('ACLAccessDenied'));
}

?>
</div>