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
	$where = '';
	$order = '';
	$group = '';
	$orderuser = '';
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

		#$this->log(4, "Updated group members ");
		#$this->set_message($this->get_translation('GroupsUpdated'));

	}
	else
	{
		// get group
		if (isset($_GET['group_id']) || isset($_POST['addmember'])|| isset($_POST['removemember']))
		{
			$group_id = (isset($_GET['group_id']) ? $_GET['group_id'] : $_POST['group_id']);

			// add member
			if (isset($_POST['addmember']) && isset($_POST['newmember']))
			{
				// do we have identical names?
				if ($engine->load_single(
				"SELECT group_id FROM {$engine->config['table_prefix']}group ".
				"WHERE group_name = '".quote($engine->dblink, $_POST['newname'])."' ".
				"LIMIT 1"))
				{
					$engine->set_message($engine->get_translation('GroupsAlreadyExists'));
					$_POST['change'] = $_POST['group_id'];
					$_POST['create'] = 1;
				}
				else
				{
					$engine->query(
						"INSERT INTO {$engine->config['table_prefix']}group_member SET ".
							"group_id	= '".quote($engine->dblink, $_POST['group_id'])."', ".
							"user_id	= '".quote($engine->dblink, (int)$_POST['newmember'])."'");

					$engine->set_message($engine->get_translation('GroupsAdded'));
					$engine->log(4, "Created a new group //'{$_POST['newname']}'//");
					unset($_POST['addmember']);
				}
			}

			// delete member
			else if (isset($_POST['removemember']) && isset($_POST['member_id']))
			{
				$engine->query(
					"DELETE FROM {$engine->config['table_prefix']}group_member ".
					"WHERE group_id = '".quote($engine->dblink, $_POST['group_id'])."' ".
						"AND user_id = '".quote($engine->dblink, $_POST['member_id'])."'");

				$engine->set_message($engine->get_translation('GroupsDeleted'));
				$engine->log(4, "Group //'{$group['group_name']}'// removed from the database");
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
				echo '<tr><td><label for="newmember">'.$engine->get_translation('MembersAddNew').'</label></td>'.
					'<td><select id="newmember" name="newmember">';?>
						<option value=""></option>
						<?php
						if ($users = $engine->load_users())
						{
							foreach($users as $user)
							{
								echo "<option value=\"".htmlspecialchars($user['user_id'])."\">".$user['user_name']."</option>\n";
							}
						}

				echo '</select></td></tr>';
				echo '<tr><td><br /><input id="submit" type="submit" name="addmember" value="'.$engine->get_translation('GroupsSaveButton').'" /> '.
					'<input id="button" type="button" value="'.$engine->get_translation('GroupsCancelButton').'" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
					'</td></tr>';
				echo '</table><br />';
				echo "</form>";
			}

			// remove member
			if (isset($_POST['removemember']) && isset($_POST['changemember']))
			{
				if ($member = $engine->load_single("SELECT user_name FROM {$engine->config['table_prefix']}user WHERE user_id = '".quote($engine->dblink, $_POST['changemember'])."' LIMIT 1"))
				{
					echo "<form action=\"admin.php\" method=\"post\" name=\"groups\">";
					echo "<input type=\"hidden\" name=\"group_id\" value=\"$group_id\" />";
					echo "<input type=\"hidden\" name=\"mode\" value=\"groups\" />";
					echo '<input type="hidden" name="member_id" value="'.htmlspecialchars($_POST['changemember']).'" />'."\n";
					echo '<table class="formation">';
					echo '<tr><td><label for="">'.$engine->get_translation('MembersRemove').' \'<tt>'.htmlspecialchars($member['user_name']).'</tt>\'?</label> '.
						'<input id="submit" type="submit" name="removemember" value="yes" style="width:40px;" /> '.
						'<input id="button" type="button" value="no" style="width:40px;" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
						'<br /><small>'.$engine->get_translation('MembersDeleteInfo').'</small>'.
						'</td></tr>';
					echo '</table><br />';
					echo "</form>";
				}
			}

		}

		// add group
		if (isset($_POST['create']) && isset($_POST['newname']))
		{
			// do we have identical names?
			if ($engine->load_single(
			"SELECT group_id FROM {$engine->config['table_prefix']}group ".
			"WHERE group_name = '".quote($engine->dblink, $_POST['newname'])."' ".
			"LIMIT 1"))
			{
				$engine->set_message($engine->get_translation('GroupsAlreadyExists'));
				$_POST['change'] = $_POST['group_id'];
				$_POST['create'] = 1;
			}
			else
			{
				$engine->query(
					"INSERT INTO {$engine->config['table_prefix']}group SET ".
						"created		= NOW(), ".
						"description	= '".quote($engine->dblink, $_POST['description'])."', ".
						"moderator		= '".quote($engine->dblink, (int)$_POST['moderator'])."', ".
						"group_name		= '".quote($engine->dblink, $_POST['newname'])."', ".
						"open			= '".quote($engine->dblink, (int)$_POST['open'])."', ".
						"active			= '".quote($engine->dblink, (int)$_POST['active'])."'");

				$engine->set_message($engine->get_translation('GroupsAdded'));
				$engine->log(4, "Created a new group //'{$_POST['newname']}'//");
				unset($_POST['create']);
			}
		}
		// edit group
		else if (isset($_POST['edit']) && isset($_POST['group_id']) && (isset($_POST['newname']) || isset($_POST['moderator'])))
		{
			// do we have identical names?
			if ($engine->load_single(
			"SELECT group_id FROM {$engine->config['table_prefix']}group ".
			"WHERE group_name = '".quote($engine->dblink, $_POST['newname'])."' AND group_id <> '".quote($engine->dblink, $_POST['group_id'])."' ".
			"LIMIT 1"))
			{
				$engine->set_message($engine->get_translation('GroupsAlreadyExists'));
				$_POST['change'] = $_POST['group_id'];
				$_POST['edit'] = 1;
			}
			else
			{
				$engine->query(
					"UPDATE {$engine->config['table_prefix']}group SET ".
					"group_name		= '".quote($engine->dblink, $_POST['newname'])."', ".
					"description	= '".quote($engine->dblink, $_POST['newdescription'])."', ".
					"moderator		= '".quote($engine->dblink, (int)$_POST['moderator'])."', ".
					"open			= '".quote($engine->dblink, (int)$_POST['open'])."', ".
					"active			= '".quote($engine->dblink, (int)$_POST['active'])."' ".
					"WHERE group_id = '".quote($engine->dblink, $_POST['group_id'])."' ".
					"LIMIT 1");


				$engine->set_message($engine->get_translation('GroupsRenamed'));
				$engine->log(4, "Group //'{$group['group_name']}'// renamed //'{$_POST['newname']}'//");
			}
		}
		// delete group
		else if (isset($_POST['delete']) && isset($_POST['group_id']))
		{
			$engine->query(
				"DELETE FROM {$engine->config['table_prefix']}group ".
				"WHERE group_id = '".quote($engine->dblink, $_POST['group_id'])."'");
			$engine->query(
				"DELETE FROM {$engine->config['table_prefix']}group_member ".
				"WHERE group_id = '".quote($engine->dblink, $_POST['group_id'])."'");

			$engine->set_message($engine->get_translation('GroupsDeleted'));
			$engine->log(4, "Group //'{$group['group_name']}'// removed from the database");
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
			echo '<tr><td><label for="newname">'.$engine->get_translation('GroupsAdd').'</label></td>'.
				'<td><input id="newname" name="newname" value="'.( isset($_POST['newname']) ? htmlspecialchars($_POST['newname']) : '' ).'" size="20" maxlength="100" /></td></tr>'.
				'<tr><td><label for="description">'.$engine->get_translation('GroupsDescription').'</label></td>'.
				'<td><input id="description" name="description" value="'.( isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ).'" size="50" maxlength="100" /></td></tr>'.
				'<tr><td><label for="moderator">'.$engine->get_translation('GroupsModerator').'</label></td>'.
				'<td><select id="moderator" name="moderator">';?>
					<option value=""></option>
					<?php
					if ($users = $engine->load_users())
					{
						foreach($users as $user)
						{
							echo "<option value=\"".htmlspecialchars($user['user_id'])."\">".$user['user_name']."</option>\n";
						}
					}

			echo '</select></td></tr>';
			echo '<tr><td><label for="open">'.$engine->get_translation('GroupsOpen').'</label></td>'.
				'<td><input type="checkbox" id="open" name="open" value="1" '. ( !isset($_POST['open']) ? ' checked="checked"' : '' ).' /></td></tr>'.
				'<tr><td><label for="active">'.$engine->get_translation('GroupsActive').'</label></td>'.
				'<td><input type="checkbox" id="active" name="active" value="1" '. ( !isset($_POST['active']) ? ' checked="checked"' : '' ).' /></td></tr>';
			echo '<tr><td><br /><input id="submit" type="submit" name="create" value="'.$engine->get_translation('GroupsSaveButton').'" /> '.
				'<input id="button" type="button" value="'.$engine->get_translation('GroupsCancelButton').'" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
				'</td></tr>';
			echo '</table><br />';
			echo "</form>";
		}
		// edit group
		else if (isset($_POST['edit']) && isset($_POST['change']))
		{
			if ($group = $engine->load_single("SELECT group_name, description, moderator, open, active FROM {$engine->config['table_prefix']}group WHERE group_id = '".quote($engine->dblink, $_POST['change'])."' LIMIT 1"))
			{
				echo "<form action=\"admin.php\" method=\"post\" name=\"groups\">";
				echo "<input type=\"hidden\" name=\"mode\" value=\"groups\" />";
				echo '<input type="hidden" name="group_id" value="'.htmlspecialchars($_POST['change']).'" />'."\n";
				echo '<table class="formation">';
				echo '<tr><td><label for="newname">'.$engine->get_translation('GroupsRename').' \'<tt>'.htmlspecialchars($group['group_name']).'</tt>\' in</label></td>'.
					'<td><input id="newname" name="newname" value="'.( isset($_POST['newname']) ? htmlspecialchars($_POST['newname']) : htmlspecialchars($group['group_name']) ).'" size="20" maxlength="100" /></td></tr>'.
					'<tr><td><label for="newdescription">'.$engine->get_translation('GroupsDescription').'</label></td>'.
					'<td><input id="newdescription" name="newdescription" value="'.( isset($_POST['newdescription']) ? htmlspecialchars($_POST['newdescription']) : htmlspecialchars($group['description']) ).'" size="50" maxlength="100" /></td></tr>'.
					'<tr><td><label for="moderator">'.$engine->get_translation('GroupsModerator').'</label></td>'.
					'<td><select id="moderator" name="moderator">'.
					'<option value=""></option> ';

					if ($users = $engine->load_users())
					{
						foreach($users as $user)
						{
							echo "<option value=\"".$user['user_id']."\" ".($group['moderator'] == $user['user_id'] ? " selected=\"selected\"" : "").">".$user['user_name']."</option>\n";
						}
					}

				echo '</select></td></tr>';
				echo '<tr><td><label for="open">'.$engine->get_translation('GroupsOpen').'</label></td>'.
					'<td><input type="checkbox" id="open" name="open" value="1" '. ( isset($_POST['open']) || $group['open'] == 1 ? ' checked="checked"' : '' ).' /></td></tr>'.
					'<tr><td><label for="active">'.$engine->get_translation('GroupsActive').'</label></td>'.
					'<td><input type="checkbox" id="active" name="active" value="1" '. ( isset($_POST['active']) || $group['active'] == 1 ? ' checked="checked"' : '' ).' /></td></tr>';
				echo '<tr><td><br /><input id="submit" type="submit" name="edit" value="'.$engine->get_translation('GroupsSaveButton').'" /> '.
					'<input id="button" type="button" value="'.$engine->get_translation('GroupsCancelButton').'" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
					'<br /><small>'.$engine->get_translation('GroupsRenameInfo').'</small>'.
					'</td></tr>';
				echo '</table><br />';
				echo "</form>";
			}
		}
		// delete group
		if (isset($_POST['delete']) && isset($_POST['change']))
		{
			if ($group = $engine->load_single("SELECT group_name FROM {$engine->config['table_prefix']}group WHERE group_id = '".quote($engine->dblink, $_POST['change'])."' LIMIT 1"))
			{
				echo "<form action=\"admin.php\" method=\"post\" name=\"groups\">";
				echo "<input type=\"hidden\" name=\"mode\" value=\"groups\" />";
				echo '<input type="hidden" name="group_id" value="'.htmlspecialchars($_POST['change']).'" />'."\n";
				echo '<table class="formation">';
				echo '<tr><td><label for="">'.$engine->get_translation('GroupsDelete').' \'<tt>'.htmlspecialchars($group['group_name']).'</tt>\'?</label> '.
					'<input id="submit" type="submit" name="delete" value="yes" style="width:40px;" /> '.
					'<input id="button" type="button" value="no" style="width:40px;" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
					'<br /><small>'.$engine->get_translation('GroupsDeleteInfo').'</small>'.
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
		$group = $engine->load_single(
			"SELECT group_id, moderator, group_name FROM {$engine->config['table_prefix']}group ".
			"WHERE group_id = '".quote($engine->dblink, $group_id)."' ".
			"LIMIT 1");

		echo "<h2>".$engine->get_translation('GroupsMembers').": ".$group['group_name']."</h2>";

		$members = $engine->load_all(
			"SELECT m.user_id, user_name FROM {$engine->config['table_prefix']}group g ".
				"INNER JOIN {$engine->config['table_prefix']}group_member m ON (g.group_id = m.group_id) ".
				"INNER JOIN {$engine->config['table_prefix']}user u ON (m.user_id = u.user_id) ".
			"WHERE g.group_id = '".quote($engine->dblink, $group_id)."' ");
?>
		<form action="admin.php" method="post" name="groups">
		<input type="hidden" name="mode" value="groups" />
		<input type="hidden" name="group_id" value="<?php echo $group_id; ?>" />

		<table border="0" cellspacing="5" cellpadding="3" class="formation">
		<tr>
			<th style="width:5px;"></th>
			<th style="width:5px;">ID</th>
			<th style="width:20px;"><a href="?mode=groups&order=<?php echo $orderuser; ?>">Username</a></th>
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

		echo '<br /><input id="button" type="submit" name="addmember" value="'.$engine->get_translation('GroupsAddButton').'" /> ';
		echo '<input id="button" type="submit" name="removemember" value="'.$engine->get_translation('GroupsRemoveButton').'" /> ';
		echo '<input id="button" type="button" value="'.$engine->get_translation('GroupsCancelButton').'" onclick="document.location=\''.addslashes($engine->href()).'\';" />';
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
		$count = $engine->load_single(
			"SELECT COUNT(group_name) AS n ".
			"FROM {$engine->config['table_prefix']}group ".
			( $where ? $where : '' )
			);

		$pagination	= $engine->pagination($count['n'], $limit, 'p', 'mode=groups&order='.htmlspecialchars(isset($_GET['order']) && $_GET['order']), '', 'admin.php');

		$users = $engine->load_all(
			"SELECT g.*, u.user_name ".
			"FROM {$engine->config['table_prefix']}group g ".
				"LEFT OUTER JOIN {$engine->config['table_prefix']}user u ON (g.moderator = u.user_id) ".

			( $where ? $where : '' ).
			( $order ? $order : 'ORDER BY group_id DESC ' ).
			"LIMIT {$pagination['offset']}, $limit");

	/////////////////////////////////////////////
	//   print list
	/////////////////////////////////////////////

	?>
		<form action="admin.php" method="post" name="groups">
		<input type="hidden" name="mode" value="groups" />

			<?php if (isset($pagination['text'])) echo '<div class="right">'.( $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '&nbsp;' ).'</div>'."\n"; ?>
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
			<?php if (isset($pagination['text'])) echo '<div class="right">'.( $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '' ).'</div>'."\n";

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

			echo '<br /><input id="button" type="submit" name="create" value="'.$engine->get_translation('GroupsAddButton').'" /> ';
			echo '<input id="button" type="submit" name="edit" value="'.$engine->get_translation('GroupsEditButton').'" /> ';
			echo '<input id="button" type="submit" name="delete" value="'.$engine->get_translation('GroupsRemoveButton').'" /> ';
		 ?>
		</form>

<?php
	}
}

?>