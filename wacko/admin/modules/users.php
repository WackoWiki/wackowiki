<?php

########################################################
##   Users                                            ##
########################################################

$module['users'] = array(
		'order'	=> 5,
		'cat'	=> 'Users',
		'mode'	=> 'users',
		'name'	=> 'Users',
		'title'	=> 'User management',
	);

########################################################

function admin_users(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
<?php

	/////////////////////////////////////////////
	//   list change/update
	/////////////////////////////////////////////

	// update users list
	if (isset($_POST['save']))
	{

		#$this->Log(4, "Updated group members ");
		#$this->SetMessage($this->GetTranslation('GroupsUpdated'));

	}
	else
	{
		// get user
		if ($_POST['id'])
		{
			$group = $engine->LoadSingle(
				"SELECT user_id, moderator, user_name FROM {$engine->config['table_prefix']}users ".
				"WHERE user_id = '".quote($engine->dblink, $_POST['id'])."' ".
				"LIMIT 1");
		}

		// add user
		if (isset($_POST['create']) && $_POST['newname'])
		{
			// do we have identical names?
			if ($engine->LoadSingle(
			"SELECT user_id FROM {$engine->config['table_prefix']}users ".
			"WHERE user_name = '".quote($engine->dblink, $_POST['newname'])."' ".
			"LIMIT 1"))
			{
				$engine->SetMessage($engine->GetTranslation('GroupsAlreadyExists'));
				$_POST['change'] = $_POST['id'];
				$_POST['create'] = 1;
			}
			else
			{
				$engine->Query(
					"INSERT INTO {$engine->config['table_prefix']}users SET ".
						"signup_time		= NOW(), ".
						"email	= '".quote($engine->dblink, $_POST['email'])."', ".
						"lang			= '".quote($engine->dblink, (int)$_POST['lang'])."', ".
						"user_name		= '".quote($engine->dblink, $_POST['newname'])."'");

				$engine->SetMessage($engine->GetTranslation('GroupsAdded'));
				$engine->Log(4, "Created a new user //'{$_POST['newname']}'//");
				unset($_POST['create']);
			}
		}
		// rename user
		else if (isset($_POST['rename']) && $_POST['id'] && ($_POST['newname'] || $_POST['moderator']))
		{
			// do we have identical names?
			if ($engine->LoadSingle(
			"SELECT user_id FROM {$engine->config['table_prefix']}users ".
			"WHERE user_name = '".quote($engine->dblink, $_POST['newname'])."' AND user_id <> '".quote($engine->dblink, $_POST['id'])."' ".
			"LIMIT 1"))
			{
				$engine->SetMessage($engine->GetTranslation('GroupsAlreadyExists'));
				$_POST['change'] = $_POST['id'];
				$_POST['rename'] = 1;
			}
			else
			{
				$engine->Query(
					"UPDATE {$engine->config['table_prefix']}users SET ".
					"user_name		= '".quote($engine->dblink, $_POST['newname'])."', ".
					"email	= '".quote($engine->dblink, $_POST['newemail'])."', ".
					"moderator		= '".quote($engine->dblink, (int)$_POST['moderator'])."' ".
					"WHERE user_id = '".quote($engine->dblink, $_POST['id'])."' ".
					"LIMIT 1");


				$engine->SetMessage($engine->GetTranslation('GroupsRenamed'));
				$engine->Log(4, "User //'{$group['user_name']}'// renamed //'{$_POST['newname']}'//");
			}
		}
		// delete user
		else if (isset($_POST['delete']) && $_POST['id'])
		{
			$engine->Query(
				"DELETE FROM {$engine->config['table_prefix']}users ".
				"WHERE user_id = '".quote($engine->dblink, $_POST['id'])."'");
			$engine->Query(
				"DELETE FROM {$engine->config['table_prefix']}groups_members ".
				"WHERE user_id = '".quote($engine->dblink, $_POST['id'])."'");

			$engine->SetMessage($engine->GetTranslation('GroupsDeleted'));
			$engine->Log(4, "User //'{$group['user_name']}'// removed from the database");
		}
	}

	/////////////////////////////////////////////
	//   edit forms
	/////////////////////////////////////////////

		// add new user
		if (isset($_POST['create']))
		{
			echo "<form action=\"admin.php\" method=\"post\" name=\"users\">";
			echo "<input type=\"hidden\" name=\"mode\" value=\"users\" />";
			echo '<table class="formation">';
			echo '<tr><td><label for="newname">'.$engine->GetTranslation('GroupsAdd').'</label></td>'.
				'<td><input id="newname" name="newname" value="'.( $_POST['newname'] ? htmlspecialchars($_POST['newname']) : '' ).'" size="20" maxlength="100" /></td></tr>'.
				'<tr><td><label for="email">'.$engine->GetTranslation('GroupsDescription').'</label></td>'.
				'<td><input id="email" name="email" value="'.( $_POST['email'] ? htmlspecialchars($_POST['email']) : '' ).'" size="50" maxlength="100" /></td></tr>'.
				'<tr><td><label for="lang">'.$engine->GetTranslation('GroupsModerator').'</label></td>'.
				'<td><select id="lang" name="lang">';?>
					<option value=""></option>
					<?php
					if ($langss = $engine->AvailableLanguages())
					{
						foreach($langs as $lang)
						{
							print("<option value=\"".htmlspecialchars($lang["user_id"])."\">".$user["user_name"]."</option>\n");
						}
					}

			echo '</select></td></tr>';
			echo '<tr><td><br /><input id="submit" type="submit" name="create" value="'.$engine->GetTranslation('GroupsSaveButton').'" /> '.
				'<input id="button" type="button" value="'.$engine->GetTranslation('GroupsCancelButton').'" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
				'</td></tr>';
			echo '</table><br />';
			echo "</form>";
		}
		// rename user
		else if (isset($_POST['rename']) && $_POST['change'])
		{
			if ($group = $engine->LoadSingle("SELECT user_name, email, lang FROM {$engine->config['table_prefix']}users WHERE user_id = '".quote($engine->dblink, $_POST['change'])."' LIMIT 1"))
			{
				echo "<form action=\"admin.php\" method=\"post\" name=\"users\">";
				echo "<input type=\"hidden\" name=\"mode\" value=\"users\" />";
				echo '<input type="hidden" name="id" value="'.htmlspecialchars($_POST['change']).'" />'."\n";
				echo '<table class="formation">';
				echo '<tr><td><label for="newname">'.$engine->GetTranslation('GroupsRename').' \'<tt>'.htmlspecialchars($group['user_name']).'</tt>\' in</label></td>'.
					'<td><input id="newname" name="newname" value="'.( $_POST['newname'] ? htmlspecialchars($_POST['newname']) : htmlspecialchars($group['user_name']) ).'" size="20" maxlength="100" /></td></tr>'.
					'<tr><td><label for="newemail">'.$engine->GetTranslation('GroupsDescription').'</label> '.
					'<td><input id="newemail" name="newemail" value="'.( $_POST['newdescription'] ? htmlspecialchars($_POST['newemail']) : htmlspecialchars($group['email']) ).'" size="50" maxlength="100" /></td></tr>'.
					'<tr><td><label for="moderator">'.$engine->GetTranslation('GroupsModerator').'</label> '.
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
		// delete user
		if (isset($_POST['delete']) && $_POST['change'])
		{
			if ($group = $engine->LoadSingle("SELECT user_name FROM {$engine->config['table_prefix']}users WHERE user_id = '".quote($engine->dblink, $_POST['change'])."' LIMIT 1"))
			{
				echo "<form action=\"admin.php\" method=\"post\" name=\"users\">";
				echo "<input type=\"hidden\" name=\"mode\" value=\"users\" />";
				echo '<input type="hidden" name="id" value="'.htmlspecialchars($_POST['change']).'" />'."\n";
				echo '<table class="formation">';
				echo '<tr><td><label for="">'.$engine->GetTranslation('GroupsDelete').' \'<tt>'.htmlspecialchars($group['user_name']).'</tt>\'?</label> '.
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

	// get user
	if ($_GET['user_id'] )
	{
		// user data
		echo '';
		echo "";
	}
	else
	{
		// set signup_time ordering
		if ($_GET['order'] == 'signup_asc')
		{
			$order		= 'ORDER BY signup_time ASC ';
			$signup_time	= 'signup_desc';
		}
		else if ($_GET['order'] == 'signup_desc')
		{
			$order		= 'ORDER BY signup_time DESC ';
			$signup_time	= 'signup_asc';
		}
		else
		{
			$signup_time	= 'signup_asc';
		}

		// set total_pages ordering
		if ($_GET['order'] == 'total_pages_asc')
		{
			$order		= 'ORDER BY total_pages ASC ';
			$orderpages	= 'total_pages_desc';
		}
		else if ($_GET['order'] == 'total_pages_desc')
		{
			$order		= 'ORDER BY total_pages DESC ';
			$orderpages	= 'total_pages_asc';
		}
		else
		{
			$orderpages	= 'total_pages_asc';
		}

		// set total_comments ordering
		if ($_GET['order'] == 'total_comments_asc')
		{
			$order		= 'ORDER BY total_comments ASC ';
			$ordercomments	= 'total_comments_desc';
		}
		else if ($_GET['order'] == 'total_comments_desc')
		{
			$order		= 'ORDER BY total_comments DESC ';
			$ordercomments	= 'total_comments_asc';
		}
		else
		{
			$ordercomments	= 'total_comments_asc';
		}

		// set total_revisions ordering
		if ($_GET['order'] == 'total_revisions_asc')
		{
			$order		= 'ORDER BY total_revisions ASC ';
			$orderrevisions	= 'total_revisions_desc';
		}
		else if ($_GET['order'] == 'total_revisions_desc')
		{
			$order		= 'ORDER BY total_revisions DESC ';
			$orderrevisions	= 'total_revisions_asc';
		}
		else
		{
			$orderrevisions	= 'total_revisions_asc';
		}

		// set user_name ordering
		if ($_GET['order'] == 'user_asc')
		{
			$order		= 'ORDER BY user_name DESC ';
			$orderuser	= 'user_desc';
		}
		else if ($_GET['order'] == 'user_desc')
		{
			$order		= 'ORDER BY user_name ASC ';
			$orderuser	= 'user_asc';
		}
		else
		{
			$orderuser	= 'user_desc';
		}

		// set real_name ordering
		if ($_GET['order'] == 'name_asc')
		{
			$order		= 'ORDER BY real_name DESC ';
			$ordername	= 'name_desc';
		}
		else if ($_GET['order'] == 'name_desc')
		{
			$order		= 'ORDER BY real_name ASC ';
			$ordername	= 'name_asc';
		}
		else
		{
			$ordername	= 'name_desc';
		}

		// filter by lang
		if ($_GET['lang'])
		{
			$where = "WHERE lang = '".quote($engine->dblink, $_GET['lang'])."' ";
		}

		// entries to display
		$limit = 100;

		// collecting data
		$count = $engine->LoadSingle(
			"SELECT COUNT(user_name) AS n ".
			"FROM {$engine->config['table_prefix']}users ".
			( $where ? $where : '' )
			);

		$pagination	= $engine->Pagination($count['n'], $limit, 'p', 'mode=users&order='.htmlspecialchars($_GET['order']), '', 'admin.php');

		$users = $engine->LoadAll(
			"SELECT * ".
			"FROM {$engine->config['table_prefix']}users ".

			( $where ? $where : '' ).
			( $order ? $order : 'ORDER BY user_id DESC ' ).
			"LIMIT {$pagination['offset']}, $limit");
	?>
		<form action="admin.php" method="post" name="users">
		<input type="hidden" name="mode" value="users" />

			<?php echo '<div class="right">'.( $pagination['text'] == true ? '<small><small>'.$pagination['text'].'</small></small>' : '&nbsp;' ).'</div>'."\n"; ?>
			<table border="0" cellspacing="5" cellpadding="3" class="formation">
				<tr>
					<th style="width:5px;"></th>
					<th style="width:5px;">ID</th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderuser; ?>">Username</a></th>
					<th style="width:150px;"><a href="?mode=users&order=<?php echo $ordername; ?>">Realname</a></th>
					<th>Email</th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderpages; ?>">Pages</a></th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $ordercomments; ?>">Comments</a></th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderrevisions; ?>">Revisions</a></th>
					<th style="width:20px;">Language</th>
					<th style="width:20px;">Active</th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $signup_time; ?>">signup_time</a></th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderlevel; ?>">Sessiontime</a></th>
				</tr>
	<?php
		if ($users)
		{
			foreach ($users as $row)
			{
				echo '<tr class="lined">'."\n".
						'<td valign="top" align="center"><input type="radio" name="change" value="'.$row['user_id'].'" /></td>'.
						'<td valign="top" align="center">'.$row['user_id'].'</td>'.
						'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;"><strong><a href="?mode=users&user_id='.$row['user_id'].'">'.$row['user_name'].'</a></strong></td>'.
						'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;">'.$row['real_name'].'</td>'.
						'<td valign="top">'.$row['email'].'</td>'.
						'<td valign="top" align="center">'.$row['total_pages'].'</td>'.
						'<td valign="top" align="center">'.$row['total_comments'].'</td>'.
						'<td valign="top" align="center">'.$row['total_revisions'].'</td>'.
						'<td valign="top" align="center"><small><a href="?mode=users&lang='.$row['lang'].'">'.$row['lang'].'</a></small></td>'.
						'<td valign="top" align="center">'.$row['enabled'].'</td>'.
						'<td valign="top" align="center"><small>'.date($engine->config['date_precise_format'], strtotime($row['signup_time'])).'</small></td>'.
						'<td valign="top" align="center"><small>'.date($engine->config['date_precise_format'], strtotime($row['session_time'])).'</small></td>'.
					'</tr>';
			}
		}
		else
		{
			echo '<tr><td colspan="5" align="center"><br /><em>No users that meet the criteria</em></td></tr>';
		}
	?>
			</table>
			<?php echo '<div class="right">'.( $pagination['text'] == true ? '<small><small>'.$pagination['text'].'</small></small>' : '' ).'</div>'."\n";

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