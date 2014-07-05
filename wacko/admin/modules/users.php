<?php

if (!defined('IN_WACKO'))
{
	exit;
}

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
	$where = '';
	$order = '';
?>
	<h1><?php echo $module['title']; ?></h1>
	<br />
	<p>
		Here you can change your users information and certain specific options.
	</p>
	<br />
<?php

	/////////////////////////////////////////////
	//   list change/update
	/////////////////////////////////////////////

	// update users list
	if (isset($_POST['save']))
	{

		#$engine->log(4, "Updated usergroup members ");
		#$engine->set_message($engine->get_translation('GroupsUpdated'));

	}
	else
	{
		// get user
		if (isset($_GET['user_id']) || isset($_POST['user_id']))
		{
			$user_id = (isset($_GET['user_id']) ? $_GET['user_id'] : $_POST['user_id']);

			$user = $engine->load_single(
				"SELECT u.user_name, u.real_name, u.email, p.theme, p.lang, u.enabled ".
				"FROM {$engine->config['table_prefix']}user u ".
					"LEFT JOIN ".$engine->config['table_prefix']."user_setting p ON (u.user_id = p.user_id) ".
				"WHERE u.user_id = '".quote($engine->dblink, $user_id)."' ".
					"AND u.account_type = '0' ".
				"LIMIT 1");
		}

		// add user
		if (isset($_POST['create']) && isset($_POST['newname']))
		{
			// do we have identical names?
			if ($engine->load_single(
			"SELECT user_id FROM {$engine->config['table_prefix']}user ".
			"WHERE user_name = '".quote($engine->dblink, $_POST['newname'])."' ".
			"LIMIT 1"))
			{
				$engine->set_message($engine->get_translation('UsersAlreadyExists'));
				$_POST['change'] = $_POST['user_id'];
				$_POST['create'] = 1;
			}
			else
			{
				$engine->sql_query(
					"INSERT INTO {$engine->config['table_prefix']}user SET ".
						"signup_time		= NOW(), ".
						"email	= '".quote($engine->dblink, $_POST['email'])."', ".
						"real_name		= '".quote($engine->dblink, $_POST['newrealname'])."', ".
						"enabled			= '".quote($engine->dblink, (int)$_POST['enabled'])."', ".
						"user_name		= '".quote($engine->dblink, $_POST['newname'])."'");

				// get new user_id
				$_user_id = $engine->load_single(
					"SELECT user_id ".
					"FROM ".$engine->config['table_prefix']."user ".
					"WHERE user_name = '".quote($engine->dblink, $user_name)."' ".
					"LIMIT 1");

				// INSERT user settings
				$engine->sql_query(
					"INSERT INTO ".$engine->config['table_prefix']."user_setting ".
					"SET ".
						"user_id		= '".quote($engine->dblink, $_user_id['user_id'])."', ".
						"typografica	= '".(($engine->config['default_typografica'] == 1) ? 1 : 0)."', ".
						"lang			= '".quote($engine->dblink, ($lang ? $lang : $engine->config['language']))."', ".
						"theme			= '".quote($engine->dblink, $engine->config['theme'])."', ".
						"send_watchmail	= '".quote($engine->dblink, 1)."'");

				$engine->set_message($engine->get_translation('UsersAdded'));
				$engine->log(4, "Created a new user //'{$_POST['newname']}'//");
				unset($_POST['create']);
			}
		}
		// edit user
		else if (isset($_POST['edit']) && isset($_POST['user_id']) && (isset($_POST['newname']) || isset($_POST['moderator'])))
		{
			// do we have identical names?
			if ($engine->load_single(
			"SELECT user_id FROM {$engine->config['table_prefix']}user ".
			"WHERE user_name = '".quote($engine->dblink, $_POST['newname'])."' AND user_id <> '".quote($engine->dblink, $_POST['user_id'])."' ".
			"LIMIT 1"))
			{
				$engine->set_message($engine->get_translation('UsersAlreadyExists'));
				$_POST['change'] = $_POST['user_id'];
				$_POST['edit'] = 1;
			}
			else
			{
				$engine->sql_query(
					"UPDATE {$engine->config['table_prefix']}user SET ".
					"user_name		= '".quote($engine->dblink, $_POST['newname'])."', ".
					"email	= '".quote($engine->dblink, $_POST['newemail'])."', ".
					"real_name		= '".quote($engine->dblink, $_POST['newrealname'])."', ".
					"enabled		= '".quote($engine->dblink, (int)$_POST['enabled'])."' ".
					"WHERE user_id = '".quote($engine->dblink, $_POST['user_id'])."' ".
					"LIMIT 1");

				$engine->sql_query(
					"UPDATE {$engine->config['table_prefix']}user_setting SET ".
					"lang		= '".quote($engine->dblink, $_POST['lang'])."' ".
					"WHERE user_id = '".quote($engine->dblink, $_POST['user_id'])."' ".
					"LIMIT 1");

				$engine->set_message($engine->get_translation('UsersRenamed'));
				$engine->log(4, "User //'{$user['user_name']}'// renamed //'{$_POST['newname']}'//");
			}
		}
		// delete user
		// TODO: reassign acls pages and revisions, delete user page
		else if (isset($_POST['delete']) && isset($_POST['user_id']))
		{
			$engine->sql_query(
				"DELETE FROM {$engine->config['table_prefix']}user ".
				"WHERE user_id = '".quote($engine->dblink, $_POST['user_id'])."'");
			$engine->sql_query(
				"DELETE FROM {$engine->config['table_prefix']}user_setting ".
				"WHERE user_id = '".quote($engine->dblink, $_POST['user_id'])."'");
			$engine->sql_query(
				"DELETE FROM {$engine->config['table_prefix']}usergroup_member ".
				"WHERE user_id = '".quote($engine->dblink, $_POST['user_id'])."'");
			$engine->sql_query(
				"DELETE FROM {$engine->config['table_prefix']}menu ".
				"WHERE user_id = '".quote($engine->dblink, $_POST['user_id'])."'");
			$engine->sql_query(
				"DELETE FROM {$engine->config['table_prefix']}watch ".
				"WHERE user_id = '".quote($engine->dblink, $_POST['user_id'])."'");

			$engine->set_message($engine->get_translation('UsersDeleted'));
			$engine->log(4, "User //'{$user['user_name']}'// removed from the database");
		}
	}

	/////////////////////////////////////////////
	//   edit forms
	/////////////////////////////////////////////

	// add new user
	if (isset($_POST['create']))
	{
		echo '<form action="admin.php" method="post" name="users">';
		echo '<input type="hidden" name="mode" value="users" />';
		echo '<h2>'.$engine->get_translation('UsersAddNew').'</h2>';
		echo '<table class="formation">';
		echo '<tr><td><label for="newname">'.$engine->get_translation('UserName').'</label></td>'.
			'<td><input id="newname" name="newname" value="'.( isset($_POST['newname']) ? htmlspecialchars($_POST['newname'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '' ).'" size="20" maxlength="100" /></td></tr>'.
			'<tr><td><label for="newrealname">'.$engine->get_translation('RealName').'</label></td>'.
			'<td><input id="newrealname" name="newrealname" value="'.( isset($_POST['newrealname']) ? htmlspecialchars($_POST['newrealname'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '' ).'" size="20" maxlength="100" /></td></tr>'.
			'<tr><td><label for="email">'.$engine->get_translation('Email').'</label></td>'.
			'<td><input id="email" name="email" value="'.( isset($_POST['email']) ? htmlspecialchars($_POST['email'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '' ).'" size="50" maxlength="100" /></td></tr>'.
			'<tr><td><label for="lang">'.$engine->get_translation('YourLanguage').'</label></td>'.
			'<td><select id="lang" name="lang">';?>
				<option value=""></option>
				<?php
				if ($langs = $engine->available_languages())
				{
					for ($i = 0; $i < count($langs); $i++)
					{
						echo "<option value=\"".$langs[$i]."\" ".($user['lang'] == $langs[$i] ? " selected=\"selected\"" : "").">".$langs[$i]."</option>\n";
					}
				}

		echo '</select></td></tr>';
		echo '<tr><td><label for="enabled">'.$engine->get_translation('UserEnabled').'</label></td>'.
			'<td><input type="checkbox" id="enabled" name="enabled" value="1" '. ( !isset($_POST['enabled']) ? ' checked="checked"' : '' ).' /></td></tr>';
		echo '<tr><td><br /><input id="submit" type="submit" name="create" value="'.$engine->get_translation('GroupsSaveButton').'" /> '.
			'<input id="button" type="button" value="'.$engine->get_translation('GroupsCancelButton').'" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
			'</td></tr>';
		echo '</table><br />';
		echo '</form>';
	}
	// edit user
	else if (isset($_POST['edit']) && isset($_POST['change']))
	{
		if ($user = $engine->load_single(
			"SELECT u.user_name, u.real_name, u.email, p.lang, u.enabled ".
			"FROM {$engine->config['table_prefix']}user u ".
				"LEFT JOIN ".$engine->config['table_prefix']."user_setting p ON (u.user_id = p.user_id) ".
			"WHERE u.user_id = '".quote($engine->dblink, $_POST['change'])."' ".
				"AND u.account_type = '0' ".
			"LIMIT 1"))
		{
			echo '<form action="admin.php" method="post" name="users">';
			echo '<input type="hidden" name="mode" value="users" />';
			echo '<input type="hidden" name="user_id" value="'.htmlspecialchars($_POST['change'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" />'."\n";
			echo '<table class="formation">';
			echo '<tr><td><label for="newname">'.$engine->get_translation('UsersRename').' \'<code>'.htmlspecialchars($user['user_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'</code>\' in</label></td>'.
				'<td><input id="newname" name="newname" value="'.( isset($_POST['newname']) ? htmlspecialchars($_POST['newname'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : htmlspecialchars($user['user_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) ).'" size="20" maxlength="100" /></td></tr>'.
				'<tr><td><label for="newrealname">'.$engine->get_translation('RealName').'</label> '.
				'<td><input id="newrealname" name="newrealname" value="'.( isset($_POST['newrealname']) ? htmlspecialchars($_POST['newrealname'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : htmlspecialchars($user['real_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) ).'" size="50" maxlength="100" /></td></tr>'.
				'</td></tr>'.
				'<tr><td><label for="newemail">'.$engine->get_translation('Email').'</label> '.
				'<td><input id="newemail" name="newemail" value="'.( isset($_POST['newdescription']) ? htmlspecialchars($_POST['newemail'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : htmlspecialchars($user['email'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) ).'" size="50" maxlength="100" /></td></tr>'.
				'<tr><td><label for="lang">'.$engine->get_translation('YourLanguage').'</label></td>'.
				'<td><select id="lang" name="lang">';?>
					<option value=""></option>
					<?php
					if ($langs = $engine->available_languages())
					{
						for ($i = 0; $i < count($langs); $i++)
						{
							echo "<option value=\"".$langs[$i]."\" ".($user['lang'] == $langs[$i] ? " selected=\"selected\"" : "").">".$langs[$i]."</option>\n";
						}
					}

				echo '</select></td></tr>';
				echo '<tr><td><label for="enabled">'.$engine->get_translation('UserEnabled').'</label></td>'.
					'<td><input type="checkbox" id="enabled" name="enabled" value="1" '. ( isset($_POST['enabled']) || $user['enabled'] == 1  ? ' checked="checked"' : '' ).' /></td></tr>';
				echo '<tr><td><br /><input id="submit" type="submit" name="edit" value="'.$engine->get_translation('GroupsSaveButton').'" /> '.
				'<input id="button" type="button" value="'.$engine->get_translation('GroupsCancelButton').'" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
				'<br /><small>'.$engine->get_translation('UsersRenameInfo').'</small>'.
				'</td></tr>';
			echo '</table><br />';
			echo '</form>';
		}
	}

	// delete user
	if (isset($_POST['delete']) && isset($_POST['change']))
	{
		if ($user = $engine->load_single("SELECT user_name FROM {$engine->config['table_prefix']}user WHERE user_id = '".quote($engine->dblink, $_POST['change'])."' LIMIT 1"))
		{
			echo '<form action="admin.php" method="post" name="users">';
			echo '<input type="hidden" name="mode" value="users" />';
			echo '<input type="hidden" name="user_id" value="'.htmlspecialchars($_POST['change'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'" />'."\n";
			echo '<table class="formation">';
			echo '<tr><td><label for="">'.$engine->get_translation('UsersDelete').' \'<code>'.htmlspecialchars($user['user_name'], ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET).'</code>\'?</label> '.
				'<input id="submit" type="submit" name="delete" value="yes" style="width:40px;" /> '.
				'<input id="button" type="button" value="no" style="width:40px;" onclick="document.location=\''.addslashes($engine->href()).'\';" />'.
				'<br /><small>'.$engine->get_translation('UsersDeleteInfo').'</small>'.
				'</td></tr>';
			echo '</table><br />';
			echo '</form>';
		}
	}

	// get user
	if (isset($_GET['user_id']))
	{
		echo "<h2>".$user['user_name']."</h2>";
		// user data
		?>
		<form action="admin.php" method="post" name="users">
		<input type="hidden" name="mode" value="users" />
		<input type="hidden" name="user_id" value="<?php echo $group_id; ?>" />

		<table style="padding: 3px;" class="formation">
		<?php

			echo '<tr class="lined">'."\n".
					'<th valign="top" align="center">'.$engine->get_translation('UserName').'</th>'.
					'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;"><strong>'.$user['user_name'].'</strong></td>'.
				'</tr>'.
				'<tr class="lined">'."\n".
					'<th valign="top" align="center">'.$engine->get_translation('RealName').'</th>'.
					'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;">'.$user['real_name'].'</td>'.
				'</tr>'.

				'<tr class="lined">'."\n".
					'<th valign="top" align="center">'.$engine->get_translation('YourEmail').'</th>'.
					'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;">'.$user['email'].'</td>'.
				'</tr>'.
				'<tr class="lined">'."\n".
					'<th valign="top" align="center">'.$engine->get_translation('YourLanguage').'</th>'.
					'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;">'.$user['lang'].'</td>'.
				'</tr>'.
				'<tr class="lined">'."\n".
					'<th valign="top" align="center">'.$engine->get_translation('ChooseTheme').'</th>'.
					'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;">'.$user['theme'].'</td>'.
				'</tr>'.
				'<tr class="lined">'."\n".
					'<th valign="top" align="center">'.$engine->get_translation('UserEnabled').'</th>'.
					'<td valign="top" align="center" style="padding-left:5px; padding-right:5px;">'.$user['enabled'].'</td>'.
				'</tr>';
?>
		</table>
		<?php

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

		echo '<br /><input id="button" type="submit" name="edit" value="'.$engine->get_translation('GroupsEditButton').'" /> ';
		echo '<input id="button" type="submit" name="removemember" value="'.$engine->get_translation('GroupsRemoveButton').'" /> ';
		echo '<input id="button" type="button" value="'.$engine->get_translation('GroupsCancelButton').'" onclick="document.location=\''.addslashes($engine->href()).'\';" />';
?>
		</form>
<?php
	}
	else
	{
		// set signuptime ordering
		if (isset($_GET['order']) && $_GET['order'] == 'signup_asc')
		{
			$order		= 'ORDER BY signup_time ASC ';
			$signup_time	= 'signup_desc';
		}
		else if (isset($_GET['order']) && $_GET['order'] == 'signup_desc')
		{
			$order		= 'ORDER BY signup_time DESC ';
			$signup_time	= 'signup_asc';
		}
		else
		{
			$signup_time	= 'signup_asc';
		}

		// set sessiontime ordering
		if (isset($_GET['order']) && $_GET['order'] == 'session_asc')
		{
			$order		= 'ORDER BY session_time ASC ';
			$session_time	= 'session_desc';
		}
		else if (isset($_GET['order']) && $_GET['order'] == 'session_desc')
		{
			$order		= 'ORDER BY session_time DESC ';
			$session_time	= 'session_asc';
		}
		else
		{
			$session_time	= 'session_asc';
		}

		// set total_pages ordering
		if (isset($_GET['order']) && $_GET['order'] == 'total_pages_asc')
		{
			$order		= 'ORDER BY total_pages ASC ';
			$orderpages	= 'total_pages_desc';
		}
		else if (isset($_GET['order']) && $_GET['order'] == 'total_pages_desc')
		{
			$order		= 'ORDER BY total_pages DESC ';
			$orderpages	= 'total_pages_asc';
		}
		else
		{
			$orderpages	= 'total_pages_asc';
		}

		// set total_comments ordering
		if (isset($_GET['order']) && $_GET['order'] == 'total_comments_asc')
		{
			$order		= 'ORDER BY total_comments ASC ';
			$ordercomments	= 'total_comments_desc';
		}
		else if (isset($_GET['order']) && $_GET['order'] == 'total_comments_desc')
		{
			$order		= 'ORDER BY total_comments DESC ';
			$ordercomments	= 'total_comments_asc';
		}
		else
		{
			$ordercomments	= 'total_comments_asc';
		}

		// set total_revisions ordering
		if (isset($_GET['order']) && $_GET['order'] == 'total_revisions_asc')
		{
			$order		= 'ORDER BY total_revisions ASC ';
			$orderrevisions	= 'total_revisions_desc';
		}
		else if (isset($_GET['order']) && $_GET['order'] == 'total_revisions_desc')
		{
			$order		= 'ORDER BY total_revisions DESC ';
			$orderrevisions	= 'total_revisions_asc';
		}
		else
		{
			$orderrevisions	= 'total_revisions_asc';
		}

		// set total_uploads ordering
		if (isset($_GET['order']) && $_GET['order'] == 'total_uploads_asc')
		{
			$order		= 'ORDER BY total_uploads ASC ';
			$orderuploads	= 'total_uploads_desc';
		}
		else if (isset($_GET['order']) && $_GET['order'] == 'total_uploads_desc')
		{
			$order		= 'ORDER BY total_uploads DESC ';
			$orderuploads	= 'total_uploads_asc';
		}
		else
		{
			$orderuploads	= 'total_uploads_asc';
		}

		// set user_name ordering
		if (isset($_GET['order']) && $_GET['order'] == 'user_asc')
		{
			$order		= 'ORDER BY user_name DESC ';
			$orderuser	= 'user_desc';
		}
		else if (isset($_GET['order']) && $_GET['order'] == 'user_desc')
		{
			$order		= 'ORDER BY user_name ASC ';
			$orderuser	= 'user_asc';
		}
		else
		{
			$orderuser	= 'user_desc';
		}

		// set real_name ordering
		if (isset($_GET['order']) && $_GET['order'] == 'name_asc')
		{
			$order		= 'ORDER BY real_name DESC ';
			$ordername	= 'name_desc';
		}
		else if (isset($_GET['order']) && $_GET['order'] == 'name_desc')
		{
			$order		= 'ORDER BY real_name ASC ';
			$ordername	= 'name_asc';
		}
		else
		{
			$ordername	= 'name_desc';
		}

		// filter by lang
		if (isset($_GET['lang']))
		{
			$where = "WHERE p.lang = '".quote($engine->dblink, $_GET['lang'])."' ";
		}

		// entries to display
		$limit = 100;

		// collecting data
		$count = $engine->load_single(
			"SELECT COUNT(user_name) AS n ".
			"FROM {$engine->config['table_prefix']}user u ".
				"LEFT JOIN ".$engine->config['table_prefix']."user_setting p ON (u.user_id = p.user_id) ".
			( $where ? $where : '' )
			);

		$order_pagination	= isset($_GET['order']) ? $_GET['order'] : '';
		$pagination			= $engine->pagination($count['n'], $limit, 'p', 'mode=users&order='.isset($order_pagination) ? htmlspecialchars($order_pagination, ENT_COMPAT | ENT_HTML401, HTML_ENTITIES_CHARSET) : '', '', 'admin.php');

		$users = $engine->load_all(
			"SELECT u.*, p.lang ".
			"FROM {$engine->config['table_prefix']}user u ".
				"LEFT JOIN ".$engine->config['table_prefix']."user_setting p ON (u.user_id = p.user_id) ".
			( $where ? $where : '' ).
			( $where ? 'AND ' : "WHERE ").
				"u.account_type = '0' ".
			( $order ? $order : 'ORDER BY u.user_id DESC ' ).
			"LIMIT {$pagination['offset']}, $limit");
?>
		<form action="admin.php" method="post" name="users">
		<input type="hidden" name="mode" value="users" />

			<?php

			/////////////////////////////////////////////
			//   control buttons
			/////////////////////////////////////////////

			$control_buttons = '<br /><input id="button" type="submit" name="create" value="'.$engine->get_translation('GroupsAddButton').'" /> ';
			$control_buttons .=  '<input id="button" type="submit" name="edit" value="'.$engine->get_translation('GroupsEditButton').'" /> ';
			$control_buttons .=  '<input id="button" type="submit" name="delete" value="'.$engine->get_translation('GroupsRemoveButton').'" /> ';

			echo $control_buttons;

			if (isset($pagination['text']))
			{
				echo '<div class="right">'.( $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '&nbsp;' ).'</div>'."\n";
			} ?>
			<table style="padding: 3px;" class="formation">
				<tr>
					<th style="width:5px;"></th>
					<th style="width:5px;">ID</th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderuser; ?>">Username</a></th>
					<th style="width:150px;"><a href="?mode=users&order=<?php echo $ordername; ?>">Realname</a></th>
					<th>Email</th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderpages; ?>">Pages</a></th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $ordercomments; ?>">Comments</a></th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderrevisions; ?>">Revisions</a></th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $orderuploads; ?>">Uploads</a></th>
					<th style="width:20px;">Language</th>
					<th style="width:20px;">Enabled</th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $signup_time; ?>">Signuptime</a></th>
					<th style="width:20px;"><a href="?mode=users&order=<?php echo $session_time; ?>">Sessiontime</a></th>
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
						'<td valign="top" align="center">'.$row['total_uploads'].'</td>'.
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
			<?php if (isset($pagination['text']))
			{
				echo '<div class="right">'.( $pagination['text'] == true ? '<small>'.$pagination['text'].'</small>' : '' ).'</div>'."\n";
			}

		/////////////////////////////////////////////
		//   control buttons
		/////////////////////////////////////////////

		echo $control_buttons;
?>
		</form>

<?php
	}
}

?>