<?php

// keywords tags tagging annotation
// ToDo:
//	- multilevel hierarchical categories (first we need to
//	  find a way to unwrap table-structured SQL data array
//	  into a tree-structured multilevel array)
//	localize message sets

?>
<div id="page">
<h3><?php echo $this->GetTranslation("KeywordsFor")." ".$this->ComposeLinkToPage($this->tag, "", "", 0) ?></h3>
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
		$this->SetMessage($this->GetTranslation('KeywordsUpdated'));
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
				$this->SetMessage($this->GetTranslation('KeywordsAlreadyExists'));
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
				$this->SetMessage($this->GetTranslation('KeywordsAdded'));
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
				$this->SetMessage($this->GetTranslation('KeywordsAlreadyExists'));
				$_POST['change'] = $_POST['id'];
				$_POST['rename'] = 1;
			}
			else
			{
				$this->Query(
					"UPDATE {$this->config['table_prefix']}keywords ".
					"SET keyword = '".quote($this->dblink, $_POST['newname'])."' ".
					"WHERE keyword_id = '".quote($this->dblink, $_POST['id'])."'");
				$this->SetMessage($this->GetTranslation('KeywordsRenamed'));
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
				$this->SetMessage($this->GetTranslation('KeywordsUngrouped'));
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
					$this->SetMessage($this->GetTranslation('KeywordsGrouped'));
					$this->Log(4, "Keyword //'{$word['keyword']}'// grouped with the word //'{$parent['keyword']}'//");
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
				"DELETE FROM {$this->config['table_prefix']}keywords ".
				"WHERE keyword_id = '".quote($this->dblink, $_POST['id'])."'");
			$this->Query(
				"DELETE FROM {$this->config['table_prefix']}keywords_pages ".
				"WHERE keyword_id = '".quote($this->dblink, $_POST['id'])."'");
			$this->Query(
				"UPDATE {$this->config['table_prefix']}keywords ".
				"SET parent = 0 ".
				"WHERE parent = '".quote($this->dblink, $_POST['id'])."'");
			$this->SetMessage($this->GetTranslation('KeywordsDeleted'));
			$this->Log(4, "Keyword //'{$word['keyword']}'// removed from the database");
		}
	}
	
	/////////////////////////////////////////////
	//   building list
	/////////////////////////////////////////////
	
	// load keywords for the page's particular language
	$keywords = $this->GetKeywordsList($this->page['lang'], 0);
	
	// get currently selected keyword_ids
	$_selected = $this->LoadAll(
				"SELECT keyword_id FROM {$this->config['table_prefix']}keywords_pages ".
				"WHERE page_id = '".$this->page['page_id']."'");

	// exploding keywords into array
	foreach ($_selected as $key => &$val)
	{
		if (is_array($val))
		{
			$selected[$key] = $val['keyword_id'];
			# unset($selected[$key]);
		}
	}
	$selected = $selected;

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
			echo '<tr><td><label for="">'.
				$this->GetTranslation('KeywordsAdd').'</label> '.
				'<input name="newname" value="'.( $_POST['newname'] ? htmlspecialchars($_POST['newname']) : '' ).'" size="20" maxlength="100" /><br /> ';
			if ($group)
			{
				echo '<small><input type="radio" id="group1" name="group" value="1" checked="checked" /> <label for="group1">'.$this->GetTranslation('KeywordsAddGrouped').' \'<tt>'.$word['keyword'].'</tt>\'.</label></small><br />';
				echo '<small><input type="radio" id="group0" name="group" value="0" /> <label for="group0">'.$this->GetTranslation('KeywordsAddGroupedNo').'</label></small><br />';
			}
			echo '<input id="submit" type="submit" name="create" value="'.$this->GetTranslation('KeywordsSaveButton').'" /> '.
				'<input id="button" type="button" value="'.$this->GetTranslation('KeywordsCancelButton').'" onclick="document.location=\''.addslashes($this->href('keywords')).'\';" />'.
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
				echo '<tr><td><label for="">'.
					$this->GetTranslation('KeywordsRename').' \'<tt>'.htmlspecialchars($word['keyword']).'</tt>\' in</label> '.
					'<input name="newname" value="'.( $_POST['newname'] ? htmlspecialchars($_POST['newname']) : htmlspecialchars($word['keyword']) ).'" size="20" maxlength="100" /> '.
					'<input id="submit" type="submit" name="rename" value="'.$this->GetTranslation('KeywordsSaveButton').'" /> '.
					'<input id="button" type="button" value="'.$this->GetTranslation('KeywordsCancelButton').'" onclick="document.location=\''.addslashes($this->href('keywords')).'\';" />'.
					'<br /><small>'.$this->GetTranslation('KeywordsRenameInfo').'</small>'.
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
				echo '<tr><td><label for="">'.
					$this->GetTranslation('KeywordsGroup').' \'<tt>'.htmlspecialchars($word['keyword']).'</tt>\' with</label> '.
					'<select style="width:100px;" name="parent">'.
						'<option value="0">[no group]</option>'.
						$options.
					'</select> '.
					'<input id="submit" type="submit" name="ugroup" value="'.$this->GetTranslation('KeywordsSaveButton').'" /> '.
					'<input id="button" type="button" value="'.$this->GetTranslation('KeywordsCancelButton').'" onclick="document.location=\''.addslashes($this->href('keywords')).'\';" />'.
					'<br /><small>'.$this->GetTranslation('KeywordsGroupInfo').'</small>'.
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
				echo '<tr><td><label for="">'.
					$this->GetTranslation('KeywordsDelete').' \'<tt>'.htmlspecialchars($word['keyword']).'</tt>\'?</label> '.
					'<input id="submit" type="submit" name="delete" value="yes" style="width:40px;" /> '.
					'<input id="button" type="button" value="no" style="width:40px;" onclick="document.location=\''.addslashes($this->href('keywords')).'\';" />'.
					'<br /><small>'.$this->GetTranslation('KeywordsDeleteInfo').'</small>'.
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
	if (is_array($keywords))
	{
		foreach ($keywords as $id => $word)
		{
			if ($n++ > 0) echo '<hr />';
			echo '<input type="radio" name="change" value="'.$id.'" /><input type="checkbox" id="keyword'.$id.'" name="keyword'.$id.'|'.$word['parent'].'" value="set"'.(is_array($selected) ? ( in_array($id, $selected) ? ' checked="checked"' : '') : '').' /> <label for="keyword'.$id.'"><strong>'.htmlspecialchars($word['keyword']).'</strong></label>'."\n";
			
			if ($word['childs'] == true) foreach ($word['childs'] as $id => $word)
			{
				if ($i++ < 1) echo '<br /><div class="indent">';
				echo '<span class="nobr"><input type="radio" name="change" value="'.$id.'" /><input type="checkbox" id="keyword'.$id.'" name="keyword'.$id.'|'.$word['parent'].'" value="set"'.(is_array($selected) ? ( in_array($id, $selected) ? ' checked="checked"' : '') : '').' /><label for="keyword'.$id.'">'.htmlspecialchars($word['keyword']).'</label>&nbsp;&nbsp;&nbsp;</span>'."\n";
			}
			
			if ($i > 0) echo "</div>\n";
			else echo "<br />\n";
			$i = 0;
		}
	
		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////
		
		echo '<br />';
		echo '<input id="submit" type="submit" name="save" value="'.$this->GetTranslation('KeywordsStoreButton').'" /> ';
		echo '<input id="button" type="button" value="'.$this->GetTranslation('KeywordsCancelButton').'" onclick="history.back();" /> ';
		echo '<small><br />'.$this->GetTranslation('KeywordsStoreInfo').'<br /><br /></small> ';
	}
	else
	{
		echo $this->GetTranslation('NoKeywordsForThisLanguage').'<br /><br /><br />'; // Availability depends on the page language and your access rights, additionally you need also the right to create new ones.
		echo '<input id="button" type="button" value="'.$this->GetTranslation('KeywordsCancelButton').'" onclick="history.back();" /><br /><br /> ';
	}
	
	if ($this->IsAdmin() || $this->config['owners_can_change_keywords'] == true)
	{
		echo '<input id="button" type="submit" name="create" value="'.$this->GetTranslation('KeywordsAddButton').'" /> ';
		echo '<input id="button" type="submit" name="rename" value="'.$this->GetTranslation('KeywordsRenameButton').'" /> ';
		echo '<input id="button" type="submit" name="ugroup" value="'.$this->GetTranslation('KeywordsGroupButton').'" /> ';
		echo '<input id="button" type="submit" name="delete" value="'.$this->GetTranslation('KeywordsRemoveButton').'" /> ';
		echo '<small><br />'.$this->GetTranslation('KeywordsEditInfo').'</small> ';
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