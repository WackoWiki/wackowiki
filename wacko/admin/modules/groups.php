<?php

########################################################
##   User Groups                                      ##
########################################################

$module['groups'] = array(
		'order'	=> 5,
		'cat'	=> 'Users',
		'mode'	=> 'groups',
		'name'	=> 'Groups',
		'title'	=> 'Group management',
	);

########################################################

function admin_groups(&$engine, &$module)
{
	$where = "";
	$order = "";
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php

	/////////////////////////////////////////////
	//   list change/update
	/////////////////////////////////////////////

	// update groups list
	if (isset($_POST['save']))
	{

		#$this->Log(4, "Updated group members ");
		#$this->SetMessage($this->GetTranslation('GroupsUpdated'));

	}
	else
	{
		// get group
		if (isset($_GET['group_id']) || isset($_POST['addmember'])|| isset($_POST['removemember']))
		{
			$group_id = ($_GET['group_id'] ? $_GET['group_id'] : $_POST['group_id']);

			// add member
			if (isset($_POST['addmember']) && isset($_POST['newmember']))
			{
				// do we have identical names?
				if ($engine->LoadSingle(
				"SELECT group_id FROM {$engine->config['table_prefix']}groups ".
				"WHERE group_name = '".quote($engine->dblink, $_POST['newname'])."' ".
				"LIMIT 1"))
				{
					$engine->SetMessage($engine->GetTranslation('GroupsAlreadyExists'));
					$_POST['change'] = $_POST['id'];
					$_POST['create'] = 1;
				}
				else
				{
					$engine->Query(
						"INSERT INTO {$engine->config['table_prefix']}groups_members SET ".
							"group_id	= '".quote($engine->dblink, $_POST['group_id'])."', ".
							"user_id	= '".quote($engine->dblink, (int)$_POST['newmember'])."'");

					$engine->SetMessage($engine->GetTranslation('GroupsAdded'));
					$engine->Log(4, "Created a new group //'{$_POST['newname']}'//");
					unset($_POST['addmember']);
				}
			}

			// delete member
			else if (isset($_POST['removemember']) && $_POST['member_id'])
			{
				$engine->Query(
					"DELETE FROM {$engine->config['table_prefix']}groups_members ".
					"WHERE group_id = '".quote($engine->dblink, $_POST['group_id'])."' ".
						"AND user_id = '".quote($engine->dblink, $_POST['member_id'])."'");

				$engine->SetMessage($engine->GetTranslation('GroupsDeleted'));
				$engine->Log(4, "Group //'{$group['group_name']}'// removed from the database");
			}

			/////////////////////////////////////////////
			//   edit forms
			/////////////////////////////////////////////

			// add new member
			if (isset($_POST['addmember']))
			{
				echo "<form action=\"admin.php\" method=\"post\" name=\"groups\">";
				echo "<input type=\"hidden\" name=\"group_id\" value=\"$group_id\" />";
				echo "<input type=\"hidden\" name=\"mode\" value=\"groups\" />";
				echo '<table class="formation">';
				echo '<tr><td><label for="newmember">'.$engine->GetTranslation('MembersAddNew').'</label></td>'.
					'<td><select id="newmember" name="newmember">';?>
						<option value=""></option>
						<?php
						if ($users = $engine->LoadUsers())
						{
							foreach($users as $user)
							{
								print("<option value=\"".htmlspecialchars($user["user_id"])."\">".$user["user_name"]."</option>\n");
							}
						}

				echo '</select></td></tr>';
				echo '<tr><td><br /><input id="submit" type="submit" name="addmember" value="'.$engine->GetTranslation('GroupsSaveButton').'" /> '.
					'<input id="button" type="button" value="'.$engine->GetTranslation('GroupsCancelButton').'" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
					'</td></tr>';
				echo '</table><br />';
				echo "</form>";
			}

			// remove member
			if (isset($_POST['removemember']) && $_POST['changemember'])
			{
				if ($member = $engine->LoadSingle("SELECT user_name FROM {$engine->config['table_prefix']}users WHERE user_id = '".quote($engine->dblink, $_POST['changemember'])."' LIMIT 1"))
				{
					echo "<form action=\"admin.php\" method=\"post\" name=\"groups\">";
					echo "<input type=\"hidden\" name=\"group_id\" value=\"$group_id\" />";
					echo "<input type=\"hidden\" name=\"mode\" value=\"groups\" />";
					echo '<input type="hidden" name="member_id" value="'.htmlspecialchars($_POST['changemember']).'" />'."\n";
					echo '<table class="formation">';
					echo '<tr><td><label for="">'.$engine->GetTranslation('MembersRemove').' \'<tt>'.htmlspecialchars($member['user_name']).'</tt>\'?</label> '.
						'<input id="submit" type="submit" name="removemember" value="yes" style="width:40px;" /> '.
						'<input id="button" type="button" value="no" style="width:40px;" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
						'<br /><small>'.$engine->GetTranslation('MembersDeleteInfo').'</small>'.
						'</td></tr>';
					echo '</table><br />';
					echo "</form>";
				}
			}

		}

		// add group
		if (isset($_POST['create']) && $_POST['newname'])
		{
			// do we have identical names?
			if ($engine->LoadSingle(
			"SELECT group_id FROM {$engine->config['table_prefix']}groups ".
			"WHERE group_name = '".quote($engine->dblink, $_POST['newname'])."' ".
			"LIMIT 1"))
			{
				$engine->SetMessage($engine->GetTranslation('GroupsAlreadyExists'));
				$_POST['change'] = $_POST['id'];
				$_POST['create'] = 1;
			}
			else
			{
				$engine->Query(
					"INSERT INTO {$engine->config['table_prefix']}groups SET ".
						"created		= NOW(), ".
						"description	= '".quote($engine->dblink, $_POST['description'])."', ".
						"moderator		= '".quote($engine->dblink, (int)$_POST['moderator'])."', ".
						"group_name		= '".quote($engine->dblink, $_POST['newname'])."'");

				$engine->SetMessage($engine->GetTranslation('GroupsAdded'));
				$engine->Log(4, "Created a new group //'{$_POST['newname']}'//");
				unset($_POST['create']);
			}
		}
		// rename group
		else if (isset($_POST['rename']) && $_POST['id'] && ($_POST['newname'] || $_POST['moderator']))
		{
			// do we have identical names?
			if ($engine->LoadSingle(
			"SELECT group_id FROM {$engine->config['table_prefix']}groups ".
			"WHERE group_name = '".quote($engine->dblink, $_POST['newname'])."' AND group_id <> '".quote($engine->dblink, $_POST['id'])."' ".
			"LIMIT 1"))
			{
				$engine->SetMessage($engine->GetTranslation('GroupsAlreadyExists'));
				$_POST['change'] = $_POST['id'];
				$_POST['rename'] = 1;
			}
			else
			{
				$engine->Query(
					"UPDATE {$engine->config['table_prefix']}groups SET ".
					"group_name		= '".quote($engine->dblink, $_POST['newname'])."', ".
					"description	= '".quote($engine->dblink, $_POST['newdescription'])."', ".
					"moderator		= '".quote($engine->dblink, (int)$_POST['moderator'])."' ".
					"WHERE group_id = '".quote($engine->dblink, $_POST['id'])."' ".
					"LIMIT 1");


				$engine->SetMessage($engine->GetTranslation('GroupsRenamed'));
				$engine->Log(4, "Group //'{$group['group_name']}'// renamed //'{$_POST['newname']}'//");
			}
		}
		// delete group
		else if (isset($_POST['delete']) && $_POST['id'])
		{
			$engine->Query(
				"DELETE FROM {$engine->config['table_prefix']}groups ".
				"WHERE group_id = '".quote($engine->dblink, $_POST['id'])."'");
			$engine->Query(
				"DELETE FROM {$engine->config['table_prefix']}groups_members ".
				"WHERE group_id = '".quote($engine->dblink, $_POST['id'])."'");

			$engine->SetMessage($engine->GetTranslation('GroupsDeleted'));
			$engine->Log(4, "Group //'{$group['group_name']}'// removed from the database");
		}
	}

	/////////////////////////////////////////////
	//   edit forms
	/////////////////////////////////////////////

		// add new group
		if (isset($_POST['create']))
		{
			echo "<form action=\"admin.php\" method=\"post\" name=\"groups\">";
			echo "<input type=\"hidden\" name=\"mode\" value=\"groups\" />";
			echo '<table class="formation">';
			echo '<tr><td><label for="newname">'.$engine->GetTranslation('GroupsAdd').'</label></td>'.
				'<td><input id="newname" name="newname" value="'.( $_POST['newname'] ? htmlspecialchars($_POST['newname']) : '' ).'" size="20" maxlength="100" /></td></tr>'.
				'<tr><td><label for="description">'.$engine->GetTranslation('GroupsDescription').'</label></td>'.
				'<td><input id="description" name="description" value="'.( $_POST['description'] ? htmlspecialchars($_POST['description']) : '' ).'" size="50" maxlength="100" /></td></tr>'.
				'<tr><td><label for="moderator">'.$engine->GetTranslation('GroupsModerator').'</label></td>'.
				'<td><select id="moderator" name="moderator">';?>
					<option value=""></option>
					<?php
					if ($users = $engine->LoadUsers())
					{
						foreach($users as $user)
						{
							print("<option value=\"".htmlspecialchars($user["user_id"])."\">".$user["user_name"]."</option>\n");
						}
					}

			echo '</select></td></tr>';
			echo '<tr><td><br /><input id="submit" type="submit" name="create" value="'.$engine->GetTranslation('GroupsSaveButton').'" /> '.
				'<input id="button" type="button" value="'.$engine->GetTranslation('GroupsCancelButton').'" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
				'</td></tr>';
			echo '</table><br />';
			echo "</form>";
		}
		// rename group
		else if (isset($_POST['rename']) && $_POST['change'])
		{
			if ($group = $engine->LoadSingle("SELECT group_name, description, moderator FROM {$engine->config['table_prefix']}groups WHERE group_id = '".quote($engine->dblink, $_POST['change'])."' LIMIT 1"))
			{
				echo "<form action=\"admin.php\" method=\"post\" name=\"groups\">";
				echo "<input type=\"hidden\" name=\"mode\" value=\"groups\" />";
				echo '<input type="hidden" name="id" value="'.htmlspecialchars($_POST['change']).'" />'."\n";
				echo '<table class="formation">';
				echo '<tr><td><label for="newname">'.$engine->GetTranslation('GroupsRename').' \'<tt>'.htmlspecialchars($group['group_name']).'</tt>\' in</label></td>'.
					'<td><input id="newname" name="newname" value="'.( $_POST['newname'] ? htmlspecialchars($_POST['newname']) : htmlspecialchars($group['group_name']) ).'" size="20" maxlength="100" /></td></tr>'.
					'<tr><td><label for="newdescription">'.$engine->GetTranslation('GroupsDescription').'</label></td>'.
					'<td><input id="newdescription" name="newdescription" value="'.( $_POST['newdescription'] ? htmlspecialchars($_POST['newdescription']) : htmlspecialchars($group['description']) ).'" size="50" maxlength="100" /></td></tr>'.
					'<tr><td><label for="moderator">'.$engine->GetTranslation('GroupsModerator').'</label></td>'.
					'<td><select id="moderator" name="moderator">'.
					'<option value=""></option> ';

					if ($users = $engine->LoadUsers())
					{
						foreach($users as $user)
						{
							print("<option value=\"".$user["user_id"]."\" ".($group["moderator"] == $user["user_id"] ? " selected=\"selected\"" : "").">".$user["user_name"]."</option>\n");
						}
					}

				echo '</select></td></tr>'.
					'<tr><td><br /><input id="submit" type="submit" name="rename" value="'.$engine->GetTranslation('GroupsSaveButton').'" /> '.
					'<input id="button" type="button" value="'.$engine->GetTranslation('GroupsCancelButton').'" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
					'<br /><small>'.$engine->GetTranslation('GroupsRenameInfo').'</small>'.
					'</td></tr>';
				echo '</table><br />';
				echo "</form>";
			}
		}
		// delete group
		if (isset($_POST['delete']) && $_POST['change'])
		{
			if ($group = $engine->LoadSingle("SELECT group_name FROM {$engine->config['table_prefix']}groups WHERE group_id = '".quote($engine->dblink, $_POST['change'])."' LIMIT 1"))
			{
				echo "<form action=\"admin.php\" method=\"post\" name=\"groups\">";
				echo "<input type=\"hidden\" name=\"mode\" value=\"groups\" />";
				echo '<input type="hidden" name="id" value="'.htmlspecialchars($_POST['change']).'" />'."\n";
				echo '<table class="formation">';
				echo '<tr><td><label for="">'.$engine->GetTranslation('GroupsDelete').' \'<tt>'.htmlspecialchars($group['group_name']).'</tt>\'?</label> '.
					'<input id="submit" type="submit" name="delete" value="yes" style="width:40px;" /> '.
					'<input id="button" type="button" value="no" style="width:40px;" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
					'<br /><small>'.$engine->GetTranslation('GroupsDeleteInfo').'</small>'.
					'</td></tr>';
				echo '</table><br />';
				echo "</form>";
			}
		}
?>
<?php

	/////////////////////////////////////////////
	//   building lists
	/////////////////////////////////////////////

	// get group
	if (isset($_GET['group_id']) || isset($_POST['group_id']))
	{
		$group = $engine->LoadSingle(
			"SELECT group_id, moderator, group_name FROM {$engine->config['table_prefix']}groups ".
			"WHERE group_id = '".quote($engine->dblink, $group_id)."' ".
			"LIMIT 1");

		echo "<h2>".$engine->GetTranslation('GroupsMembers').": ".$group['group_name']."</h2>";

		$members = $engine->LoadAll(
			"SELECT m.user_id, user_name FROM {$engine->config['table_prefix']}groups g ".
				"INNER JOIN {$engine->config['table_prefix']}groups_members m ON (g.group_id = m.group_id) ".
				"INNER JOIN {$engine->config['table_prefix']}users u ON (m.user_id = u.user_id) ".
			"WHERE g.group_id = '".quote($engine->dblink, $group_id)."' ");
?>
		<form action="admin.php" method="post" name="groups">
		<input type="hidden" name="mode" value="groups" />
		<input type="hidden" name="group_id" value="<?php echo $group_id; ?>" />

		<table border="0" cellspacing="5" cellpadding="3" class="formation">
		<tr>
			<th style="width:5px;"></th>
			<th style="width:5px;">ID</th>
			<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderuser; ?>">Username</a></th>
		</tr>
<?php
		foreach ($members as $member)
		{
			echo '<tr class="lined">'."\n".
			'<td valign="top" align="center"><input type="radio" name="changemember" value="'.$member['user_id'].'" /></td>'.
					'<td valign="top" align="center">'.$member['user_id'].'</td>'.
					'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;"><strong><a href="?mode=users&user_id='.$member['user_id'].'">'.$member['user_name'].'</a></strong></td>'.
			'</tr>';
		}
			?>
		</table>
		<?php

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

		echo '<br /><input id="button" type="submit" name="addmember" value="'.$engine->GetTranslation('GroupsAddButton').'" /> ';
		echo '<input id="button" type="submit" name="removemember" value="'.$engine->GetTranslation('GroupsRemoveButton').'" /> ';
		echo '<input id="button" type="button" value="'.$engine->GetTranslation('GroupsCancelButton').'" onclick="document.location=\''.addslashes($engine->href()).'\';" />';
	 ?>
		</form>
		<?php
	}
	else
	{
		// set created ordering
		if (isset($_GET['order']) && $_GET['order'] == 'created_asc')
		{
			$order		= 'ORDER BY g.created ASC ';
			$created	= 'created_desc';
		}
		else if (isset($_GET['order']) && $_GET['order'] == 'created_desc')
		{
			$order		= 'ORDER BY g.created DESC ';
			$created	= 'created_asc';
		}
		else
		{
			$created	= 'created_asc';
		}

		// set group ordering
		if (isset($_GET['order']) && $_GET['order'] == 'group_asc')
		{
			$order		= 'ORDER BY g.group_name DESC ';
			$ordergroup	= 'user_desc';
		}
		else if (isset($_GET['order']) && $_GET['order'] == 'group_desc')
		{
			$order		= 'ORDER BY g.group_name ASC ';
			$ordergroup	= 'group_asc';
		}
		else
		{
			$ordergroup	= 'group_desc';
		}

		// filter by lang
		if (isset($_GET['moderator']))
		{
			$where = "WHERE g.moderator = '".quote($engine->dblink, $_GET['moderator'])."' ";
		}

		// entries to display
		$limit = 100;

		// collecting data
		$count = $engine->LoadSingle(
			"SELECT COUNT(group_name) AS n ".
			"FROM {$engine->config['table_prefix']}groups ".
			( $where ? $where : '' )
			);

		$pagination	= $engine->Pagination($count['n'], $limit, 'p', 'mode=groups&order='.htmlspecialchars($_GET['order']), '', 'admin.php');

		$users = $engine->LoadAll(
			"SELECT g.*, u.user_name ".
			"FROM {$engine->config['table_prefix']}groups g ".
				"LEFT OUTER JOIN {$engine->config['table_prefix']}users u ON (g.moderator = u.user_id) ".

			( $where ? $where : '' ).
			( $order ? $order : 'ORDER BY group_id DESC ' ).
			"LIMIT {$pagination['offset']}, $limit");

	/////////////////////////////////////////////
	//   print list
	/////////////////////////////////////////////

	?>
		<form action="admin.php" method="post" name="groups">
		<input type="hidden" name="mode" value="groups" />

			<?php if ((isset($pagination['text'])) && $pagination['text'] == true ) echo '<div class="right">'.( $pagination['text'] == true ? '<small><small>'.$pagination['text'].'</small></small>' : '&nbsp;' ).'</div>'."\n"; ?>
			<table border="0" cellspacing="5" cellpadding="3" class="formation">
				<tr>
					<th style="width:5px;"></th>
					<th style="width:5px;">ID</th>
					<th style="width:20px;"><a href="?mode=groups&order=<?php echo $ordergroup; ?>">Group</a></th>
					<th>Description</th>
					<th style="width:20px;">Moderator</th>
					<th style="width:20px;">Open</th>
					<th style="width:20px;">Active</th>
					<th style="width:20px;"><a href="?mode=groups&order=<?php echo $created; ?>">Created</a></th>
				</tr>
	<?php
		if ($users)
		{
			foreach ($users as $row)
			{
				echo '<tr class="lined">'."\n".
						'<td valign="top" align="center"><input type="radio" name="change" value="'.$row['group_id'].'" /></td>'.
						'<td valign="top" align="center">'.$row['group_id'].'</td>'.
						'<td valign="top" align="left" style="padding-left:5px; padding-right:5px;"><strong><a href="?mode=groups&group_id='.$row['group_id'].'">'.$row['group_name'].'</a></strong></td>'.
						'<td valign="top">'.$row['description'].'</td>'.
						'<td valign="top" align="center"><small><a href="?mode=groups&moderator='.$row['moderator'].'">'.$row['user_name'].'</a></small></td>'.
						'<td valign="top" align="center">'.$row['open'].'</td>'.
						'<td valign="top" align="center">'.$row['active'].'</td>'.
						'<td valign="top" align="center"><small>'.date($engine->config['date_precise_format'], strtotime($row['created'])).'</small></td>'.
					'</tr>';
			}
		}
		else
		{
			echo '<tr><td colspan="5" align="center"><br /><em>No groups that meet the criteria</em></td></tr>';
		}
	?>
			</table>
			<?php if ((isset($pagination['text'])) && $pagination['text'] == true ) echo '<div class="right">'.( $pagination['text'] == true ? '<small><small>'.$pagination['text'].'</small></small>' : '' ).'</div>'."\n";

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

			echo '<br /><input id="button" type="submit" name="create" value="'.$engine->GetTranslation('GroupsAddButton').'" /> ';
			echo '<input id="button" type="submit" name="rename" value="'.$engine->GetTranslation('GroupsRenameButton').'" /> ';
			echo '<input id="button" type="submit" name="delete" value="'.$engine->GetTranslation('GroupsRemoveButton').'" /> ';
		 ?>
		</form>

<?php
	}
}

?>