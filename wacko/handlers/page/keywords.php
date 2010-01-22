<?php

// keywords tags tagging annotation
// ToDo:
//	- multilevel hierarchical categories (first we need to
//	  find a way to unwrap table-structured SQL data array
//	  into a tree-structured multilevel array)
//

?>
<div id="page">
<h3>Keywords for <?php echo $this->ComposeLinkToPage($this->tag, "", "", 0) ?></h3>
<br />
<?php

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href("show"));

if ($this->UserIsOwner() || $this->IsAdmin())
{
	/////////////////////////////////////////////
	//   list change/update
	/////////////////////////////////////////////
	
	// update keywords list for the current page
	if (isset($_POST['save']))
	{
		// clear old list
		$this->RemoveKeywords($this->tag);
		
		// save new list
		$this->SaveKeywordsList($this->page["page_id"]);
		
		$this->Log(4, "Updated page keywords [[/{$this->tag} {$this->page['title']}]]");
		$this->SetMessage('Page Keywords updated.');
		$this->Redirect($this->href('settings'));
	}
	else if ($this->IsAdmin() || $this->config['owners_can_change_keywords'] == true)
	{
		// get keyword
		if ($_POST['id'])
		{
			$word = $this->LoadSingle(
				"SELECT keyword_id, parent, keyword FROM {$this->config['table_prefix']}keywords ".
				"WHERE keyword_id = '".quote($this->dblink, $_POST['id'])."'");
		}
		
		// add item
		if (isset($_POST['create']) && $_POST['newname'])
		{
			// do we have identical names?
			if ($this->LoadSingle(
			"SELECT keyword_id FROM {$this->config['table_prefix']}keywords ".
			"WHERE keyword = '".quote($this->dblink, $_POST['newname'])."'"))
			{
				$this->SetMessage('This keyword is already there.');
				$_POST['change'] = $_POST['id'];
				$_POST['create'] = 1;
			}
			else
			{
				$this->Query(
					"INSERT INTO {$this->config['table_prefix']}keywords SET ".
						( $_POST['id'] && $_POST['group'] == 1
							? "parent = '".quote($this->dblink, (int)( $word['parent'] != 0 ? $word['parent'] : $word['keyword_id'] ))."', "
							: ''
						).
						"lang = '".quote($this->dblink, $this->page['lang'])."', ".
						"keyword = '".quote($this->dblink, $_POST['newname'])."'");
				$this->SetMessage('Keyword added successfully.');
				$this->Log(4, "Created a new keyword //'{$_POST['newname']}'//");
				unset($_POST['create']);
			}
		}
		// rename item
		else if (isset($_POST['rename']) && $_POST['newname'] && $_POST['id'])
		{
			// do we have identical names?
			if ($this->LoadSingle(
			"SELECT keyword_id FROM {$this->config['table_prefix']}keywords ".
			"WHERE keyword = '".quote($this->dblink, $_POST['newname'])."' AND keyword_id <> '".quote($this->dblink, $_POST['id'])."'"))
			{
				$this->SetMessage('This keyword is already there.');
				$_POST['change'] = $_POST['id'];
				$_POST['rename'] = 1;
			}
			else
			{
				$this->Query(
					"UPDATE {$this->config['table_prefix']}keywords ".
					"SET keyword = '".quote($this->dblink, $_POST['newname'])."' ".
					"WHERE keyword_id = '".quote($this->dblink, $_POST['id'])."'");
				$this->SetMessage('Keyword successfully renamed.');
				$this->Log(4, "Keyword //'{$word['keyword']}'// renamed //'{$_POST['newname']}'//");
			}
		}
		// (un)group item
		else if (isset($_POST['ugroup']) && isset($_POST['parent']) && $_POST['id'])
		{
			// in or out?
			if ($_POST['parent'] == 0)
			{
				$this->Query(
					"UPDATE {$this->config['table_prefix']}keywords ".
					"SET parent = 0 ".
					"WHERE keyword_id = '".quote($this->dblink, $_POST['id'])."'");
				$this->SetMessage('Keyword debundled successfully.');
				$this->Log(4, "Keyword //'{$word['keyword']}'// debundled");
			}
			else
			{
				$parent = $this->LoadSingle(
					"SELECT parent, keyword FROM {$this->config['table_prefix']}keywords ".
					"WHERE keyword_id = '".quote($this->dblink, $_POST['parent'])."'");
				
				if ($parent['parent'] == 0)
				{
					$this->Query(
						"UPDATE {$this->config['table_prefix']}keywords ".
						"SET parent = '".quote($this->dblink, $_POST['parent'])."' ".
						"WHERE keyword_id = '".quote($this->dblink, $_POST['id'])."'");
					$this->Query(
						"UPDATE {$this->config['table_prefix']}keywords ".
						"SET parent = 0 ".
						"WHERE parent = '".quote($this->dblink, $_POST['id'])."'");
					$this->SetMessage('The keyword entered in the new group.');
					$this->Log(4, "Keyword //'{$word['keyword']}'// grouped with the word //'{$parent['keyword']}'//");
				}
				else
				{
					$this->SetMessage('Multilevel grouping keywords is not possible.');
				}
			}
		}
		// delete item
		else if (isset($_POST['delete']) && $_POST['id'])
		{
			$this->Query(
				"DELETE FROM {$this->config['table_prefix']}keywords ".
				"WHERE keyword_id = '".quote($this->dblink, $_POST['id'])."'");
			$this->Query(
				"DELETE FROM {$this->config['table_prefix']}keywords_pages ".
				"WHERE keyword_id = '".quote($this->dblink, $_POST['id'])."'");
			$this->Query(
				"UPDATE {$this->config['table_prefix']}keywords ".
				"SET parent = 0 ".
				"WHERE parent = '".quote($this->dblink, $_POST['id'])."'");
			$this->SetMessage('The keyword was deleted from the database and all pages.');
			$this->Log(4, "Keyword //'{$word['keyword']}'// removed from the database");
		}
	}
	
	/////////////////////////////////////////////
	//   building list
	/////////////////////////////////////////////
	
	// load keywords for the page's particular language
	$keywords = $this->GetKeywordsList($this->page['lang'], 0);
	
	// get currently selected words
	$selected = explode(' ', $this->page['keywords']);
	
	/////////////////////////////////////////////
	//   edit forms
	/////////////////////////////////////////////
	
	if ($this->IsAdmin() || $this->config['owners_can_change_keywords'] == true)
	{
		// add new item
		if (isset($_POST['create']))
		{
			if ($_POST['change'] || $_POST['id'])
			{
				$word = $this->LoadSingle(
					"SELECT keyword_id, parent, keyword FROM {$this->config['table_prefix']}keywords ".
					"WHERE keyword_id = '".quote($this->dblink, $_POST['change'])."'");
				$group = ( $word['parent'] == 0 ? $word['keyword_id'] : $group = $word['parent'] );
			}
			
			echo $this->FormOpen('keywords');
			echo '<input type="hidden" name="id" value="'.htmlspecialchars($group).'" />'."\n";
			echo '<table class="formation">';
			echo '<tr><td>'.
				'Add a new keyword: '.
				'<input name="newname" value="'.( $_POST['newname'] ? htmlspecialchars($_POST['newname']) : '' ).'" size="20" maxlength="100" /><br /> ';
			if ($group)
			{
				echo '<small><input type="radio" id="group1" name="group" value="1" checked="checked" /> <label for="group1">Grouped with the keyword <em>\''.$word['keyword'].'\'</em>.</label></small><br />';
				echo '<small><input type="radio" id="group0" name="group" value="0" /> <label for="group0">No group.</label></small><br />';
			}
			echo '<input id="submit" type="submit" name="create" value="done" /> '.
				'<input id="button" type="button" value="'.$this->GetTranslation('ACLCancelButton').'" onclick="document.location=\''.addslashes($this->href('keywords')).'\';" />'.
				'</td></tr>';
			echo '</table><br />';
			echo $this->FormClose();
		}
		// rename item
		else if (isset($_POST['rename']) && $_POST['change'])
		{
			if ($word = $this->LoadSingle("SELECT keyword FROM {$this->config['table_prefix']}keywords WHERE keyword_id = '".quote($this->dblink, $_POST['change'])."'"))
			{
				echo $this->FormOpen('keywords');
				echo '<input type="hidden" name="id" value="'.htmlspecialchars($_POST['change']).'" />'."\n";
				echo '<table class="formation">';
				echo '<tr><td>'.
					'Rename a keyword <em>\''.htmlspecialchars($word['keyword']).'\'</em> in '.
					'<input name="newname" value="'.( $_POST['newname'] ? htmlspecialchars($_POST['newname']) : htmlspecialchars($word['keyword']) ).'" size="20" maxlength="100" /> '.
					'<input id="submit" type="submit" name="rename" value="done" /> '.
					'<input id="button" type="button" value="'.$this->GetTranslation('ACLCancelButton').'" onclick="document.location=\''.addslashes($this->href('keywords')).'\';" />'.
					'<br /><small>* Note: Change will affect all pages that are assigned to that keyword.</small>'.
					'</td></tr>';
				echo '</table><br />';
				echo $this->FormClose();
			}
		}
		// (un)group item
		else if (isset($_POST['ugroup']) && $_POST['change'])
		{
			if ($word = $this->LoadSingle("SELECT keyword FROM {$this->config['table_prefix']}keywords WHERE keyword_id = '".quote($this->dblink, $_POST['change'])."'"))
			{
				$parents = $this->LoadAll(
					"SELECT keyword_id, keyword ".
					"FROM {$this->config['table_prefix']}keywords ".
					"WHERE parent = 0 ".
					"ORDER BY keyword ASC");
				
				foreach ($parents as $parent)
				{
					$options .= '<option value="'.$parent['keyword_id'].'">'.htmlspecialchars($parent['keyword']).'</option>';
				}
				
				echo $this->FormOpen('keywords');
				echo '<input type="hidden" name="id" value="'.htmlspecialchars($_POST['change']).'" />'."\n";
				echo '<table class="formation">';
				echo '<tr><td>'.
					'Group keywords <em>\''.htmlspecialchars($word['keyword']).'\'</em> with '.
					'<select style="width:100px;" name="parent">'.
						'<option value="0">[no group]</option>'.
						$options.
					'</select> '.
					'<input id="submit" type="submit" name="ugroup" value="done" /> '.
					'<input id="button" type="button" value="'.$this->GetTranslation('ACLCancelButton').'" onclick="document.location=\''.addslashes($this->href('keywords')).'\';" />'.
					'<br /><small>* Select <em>[no group]</em>, to debundled keyword.</small>'.
					'</td></tr>';
				echo '</table><br />';
				echo $this->FormClose();
			}
		}
		// delete item
		if (isset($_POST['delete']) && $_POST['change'])
		{
			if ($word = $this->LoadSingle("SELECT keyword FROM {$this->config['table_prefix']}keywords WHERE keyword_id = '".quote($this->dblink, $_POST['change'])."'"))
			{
				echo $this->FormOpen('keywords');
				echo '<input type="hidden" name="id" value="'.htmlspecialchars($_POST['change']).'" />'."\n";
				echo '<table class="formation">';
				echo '<tr><td>'.
					'Are you sure you want to remove keyword <em>\''.htmlspecialchars($word['keyword']).'\'</em>? '.
					'<input id="submit" type="submit" name="delete" value="yes" style="width:40px;" /> '.
					'<input id="button" type="button" value="no" style="width:40px;" onclick="document.location=\''.addslashes($this->href('keywords')).'\';" />'.
					'<br /><small>* Note: Change will affect all pages that are assigned to that keyword. If the word has a sub-category, they will not be deleted, but only debundled.</small>'.
					'</td></tr>';
				echo '</table><br />';
				echo $this->FormClose();
			}
		}
	}
	
	/////////////////////////////////////////////
	//   print list
	/////////////////////////////////////////////
	
	echo $this->FormOpen('keywords');
	
	// print keywords list
	foreach ($keywords as $id => $word)
	{
		if ($n++ > 0) echo '<hr />';
		echo '<input type="radio" name="change" value="'.$id.'" /><input type="checkbox" id="keyword'.$id.'" name="keyword'.$id.'|'.$word['parent'].'" value="set"'.( in_array($id, $selected) ? ' checked="checked"' : '' ).' /> <label for="keyword'.$id.'"><strong>'.htmlspecialchars($word['keyword']).'</strong></label>'."\n";
		
		if ($word['childs'] == true) foreach ($word['childs'] as $id => $word)
		{
			if ($i++ < 1) echo '<br /><div class="indent">';
			echo '<span class="nobr"><input type="radio" name="change" value="'.$id.'" /><input type="checkbox" id="keyword'.$id.'" name="keyword'.$id.'|'.$word['parent'].'" value="set"'.( in_array($id, $selected) ? ' checked="checked"' : '' ).' /><label for="keyword'.$id.'">'.htmlspecialchars($word['keyword']).'</label>&nbsp;&nbsp;&nbsp;</span>'."\n";
		}
		
		if ($i > 0) echo "</div>\n";
		else echo "<br />\n";
		$i = 0;
	}
	
	/////////////////////////////////////////////
	//   control buttons
	/////////////////////////////////////////////
	
	echo '<br />';
	echo '<input id="submit" type="submit" name="save" value="'.$this->GetTranslation('ACLStoreButton').'" /> ';
	echo '<input id="button" type="button" value="'.$this->GetTranslation('ACLCancelButton').'" onclick="history.back();" /> ';
	echo '<small><br />To assign keywords to a page select the checkboxes.<br /><br /></small> ';
	
	if ($this->IsAdmin() || $this->config['owners_can_change_keywords'] == true)
	{
		echo '<input id="button" type="submit" name="create" value="add" /> ';
		echo '<input id="button" type="submit" name="rename" value="rename" /> ';
		echo '<input id="button" type="submit" name="ugroup" value="group" /> ';
		echo '<input id="button" type="submit" name="delete" value="remove" /> ';
		echo '<small><br />To edit the keyword list select the radio button.</small> ';
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