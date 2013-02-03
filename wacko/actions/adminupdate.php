<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// status: beta
//
// for testing and improvement - thought as upgrade routine for the installer

echo '<h2>Upgrade Utilities</h2>';

if ($this->is_admin())
{
	echo 'Recent Wacko version '.$this->format('**!!(green)'.$this->config['wacko_version'].'!!**', 'wacko');
	echo '<h3>Routines for R5.0</h3>';


	########################################################
	##            UPDATE user statistics                  ##
	########################################################

	if ($this->is_admin())
	{
		echo "<h4>4. Update User statistics:</h4>";

		if (!isset($_POST['build_user_stats']))
		{
			echo $this->form_open();
			?>
			<input type="submit" name="build_user_stats" value="<?php echo $this->get_translation('CategoriesSaveButton');?>" />
			<?php
			echo $this->form_close();
		}
		// updates user statistics in 'user' table
		else if (isset($_POST['build_user_stats']))
		{
			// total pages in ownership
			$users = $this->load_all(
				"SELECT p.owner_id, COUNT(p.tag) AS n ".
				"FROM {$this->config['table_prefix']}page AS p, {$this->config['user_table']} AS u ".
				"WHERE p.owner_id = u.user_id AND p.comment_on_id = '0' ".
				"GROUP BY p.owner_id");

			foreach ($users as $user)
			{
				$this->sql_query(
					"UPDATE {$this->config['user_table']} ".
					"SET total_pages = ".(int)$user['n']." ".
					"WHERE user_id = '".quote($this->dblink, $user['owner_id'])."' ".
					"LIMIT 1");
			}

			// total comments posted
			$users = $this->load_all(
				"SELECT p.user_id, COUNT(p.tag) AS n ".
				"FROM {$this->config['table_prefix']}page AS p, {$this->config['user_table']} AS u ".
				"WHERE p.owner_id = u.user_id AND p.comment_on_id <> '0' ".
				"GROUP BY p.user_id");

			foreach ($users as $user)
			{
				$this->sql_query(
					"UPDATE {$this->config['user_table']} ".
					"SET total_comments = ".(int)$user['n']." ".
					"WHERE user_id = '".quote($this->dblink, $user['user_id'])."' ".
					"LIMIT 1");
			}

			// total revisions made
			$users = $this->load_all(
				"SELECT r.user_id, COUNT(r.tag) AS n ".
				"FROM {$this->config['table_prefix']}revision AS r, {$this->config['user_table']} AS u ".
				"WHERE r.owner_id = u.user_id AND r.comment_on_id = '0' ".
				"GROUP BY r.user_id");

			foreach ($users as $user)
			{
				$this->sql_query(
					"UPDATE {$this->config['user_table']} ".
					"SET total_revisions = ".(int)$user['n']." ".
					"WHERE user_id = '".quote($this->dblink, $user['user_id'])."' ".
					"LIMIT 1");
			}

			// total files uploaded
			$users = $this->load_all(
				"SELECT u.user_id, COUNT(f.upload_id) AS n ".
				"FROM {$this->config['table_prefix']}upload f, {$this->config['user_table']} AS u ".
				"WHERE f.user_id = u.user_id ".
				"GROUP BY f.user_id");

			foreach ($users as $user)
			{
				$this->sql_query(
					"UPDATE {$this->config['user_table']} ".
					"SET total_uploads = ".(int)$user['n']." ".
					"WHERE user_id = '".quote($this->dblink, $user['user_id'])."' ".
					"LIMIT 1");
			}

			$this->log(1, 'Synchronized user statistics');

			echo	'<p><em>User Statistics synchronized.</em></p><br />';

		}
	}


	########################################################
	##            Set page title based on tag             ##
	########################################################

	if ($this->is_admin())
	{
		echo "<h4>6. Set page title based on tag if empty:</h4>";

		if (!isset($_POST['set_title']))
		{
			echo $this->form_open();
			?>
			<input type="submit" name="set_title"  value="<?php echo $this->get_translation('CategoriesSaveButton');?>" />
			<?php
			echo $this->form_close();
		}
		// move global files from \\files to \\files\global folder
		else if (isset($_POST['set_title']))
		{
			$pages = $this->load_all(
				"SELECT page_id, tag, lang ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE title = ''");

			if (!empty($pages))
			{
				echo "<table><tr><th>page_id</th><th>tag</th><th>new title</th></tr>";

				foreach ($pages as $page)
				{
					$this->load_translation($page['lang']);
					$this->set_translation ($page['lang']);
					$this->set_page_lang($page['lang']);
					// tag to title
					$title = $this->add_spaces_title(trim(substr($page['tag'], strrpos($page['tag'], '/')), '/'));

					$this->sql_query(
						"UPDATE {$this->config['table_prefix']}page ".
						"SET title = '".quote($this->dblink, $title)."' ".
						"WHERE page_id = '".quote($this->dblink, $page['page_id'])."' ".
						"LIMIT 1");

					echo "<tr><td>".$page['page_id']."</td><td>".$page['tag']."</td><td>".$title."</td></tr>";
				}

				$this->load_translation($this->user_lang);
				$this->set_translation($this->user_lang);
				$this->set_language($this->user_lang);

				echo "</table>";
				echo "<br />Titles set";
			}
			else
			{
				echo "No empty title field found.";
			}
		}
	}

	########################################################
	##            Set depth based on tag                  ##
	########################################################

	if ($this->is_admin())
	{
		echo "<h4>7. Set page depth based on tag:</h4>";

		if (!isset($_POST['set_depth']))
		{
			echo $this->form_open();
			?>
			<input type="submit" name="set_depth"  value="<?php echo $this->get_translation('CategoriesSaveButton');?>" />
			<?php
			echo $this->form_close();
		}
		// move global files from \\files to \\files\global folder
		else if (isset($_POST['set_depth']))
		{
			$pages = $this->load_all(
				"SELECT page_id, tag ".
				"FROM {$this->config['table_prefix']}page ".
				"WHERE comment_on_id = '0'");

			if (!empty($pages))
			{
				echo "<table><tr><th>page_id</th><th>tag</th><th>depth</th></tr>";

				foreach ($pages as $page)
				{
					// determine the depth
					$_depth_array	= explode('/', $page['tag']);
					$depth			= count( $_depth_array );

					$this->sql_query(
						"UPDATE {$this->config['table_prefix']}page ".
						"SET depth = '".quote($this->dblink, $depth)."' ".
						"WHERE page_id = '".quote($this->dblink, $page['page_id'])."' ".
						"LIMIT 1");

					echo "<tr><td>".$page['page_id']."</td><td>".$page['tag']."</td><td>".$depth."</td></tr>";
				}

				echo "</table>";
				echo "<br />Depth set";
			}
			else
			{
				echo "No pages found.";
			}
		}
	}

	########################################################
	##            Set version_id for revision             ##
	########################################################

	if ($this->is_admin())
	{
		echo "<h4>8. Set version_id:</h4>";

		if (!isset($_POST['set_version_id']))
		{
			echo $this->form_open();
			?>
			<input type="submit" name="set_version_id" value="<?php echo $this->get_translation('CategoriesSaveButton');?>" />
			<?php
			echo $this->form_close();
		}
		// move global files from \\files to \\files\global folder
		else if (isset($_POST['set_version_id']))
		{
			$pages = $this->load_all(
				"SELECT page_id ".
				"FROM {$this->config['table_prefix']}revision ".
				"GROUP BY page_id");

			if (!empty($pages))
			{
				echo "<table><tr><th>page_id</th><th>revision_id</th><th>version</th></tr>";

				foreach ($pages as $page)
				{
					$_revisions = $this->load_all(
						"SELECT revision_id, page_id ".
						"FROM {$this->config['table_prefix']}revision ".
						"WHERE page_id = '".quote($this->dblink, $page['page_id'])."' ".
						"ORDER BY modified DESC");

					$t = count($_revisions);

					foreach ($_revisions as $_revision)
					{
						$version_id = $t--;

						$this->sql_query(
							"UPDATE {$this->config['table_prefix']}revision ".
							"SET version_id = '".quote($this->dblink, $version_id)."' ".
							"WHERE revision_id = '".quote($this->dblink, $_revision['revision_id'])."' ".
							"LIMIT 1");

						echo "<tr><td>".$_revision['page_id']."</td><td>".$_revision['revision_id']."</td><td>".$version_id."</td></tr>";
					}
				}

				echo "</table>";
				echo "<br />Version_id set in revisions";
			}
			else
			{
				echo "No pages found.";
			}
		}
	}

	########################################################
	##            MIGRATE ACLs to new scheme              ##
	########################################################

	# postponed -> R5.1

	// rename the old 'acl' table to 'acl_old' first
	/*
	if ($this->is_admin())
	{
		if (!isset($_POST['migrate_acls']))
		{
			echo "<h3>7. Migrates acls to new scheme:</h3>";
			echo $this->form_open();
			?>
			<input type="submit" name="migrate_acls" value="<?php echo $this->get_translation('CategoriesSaveButton');?>" />
			<?php
			echo $this->form_close();
		}
		// migrate acls to new acl and acl_privilege table
		else if (isset($_POST['migrate_acls']))
		{
			// load old ACLs
			$_acls = $this->load_all(
				"SELECT page_id, privilege, list ".
				"FROM {$this->config['table_prefix']}acl_old ");

			$old_acl_count = count($_acls);

			foreach ($_acls as $_acl)
			{
				echo $_acl['privilege'].'<br />';
				// get object_right_id (e.g. 'write' -> 1, 'read' -> 2)
				$_object_right_id = $this->load_single(
					"SELECT object_right_id ".
					"FROM {$this->config['table_prefix']}acl_right ".
					"WHERE object_right = '{$_acl['privilege']}'
					");
				$object_right_id = $_object_right_id['object_right_id'];

				// get object_type_id (e.g. 'page' -> 1) / there is only 'page' so far
				$_object_type_id = $this->load_single(
					"SELECT object_type_id ".
					"FROM {$this->config['table_prefix']}acl_type ".
					"WHERE object_type = 'page'
					");
				$object_type_id = $_object_type_id['object_type_id'];

				// INSERT rights in 'acl' table
				$sql =	"INSERT INTO {$this->config['table_prefix']}acl
						(object_id, object_type_id, object_right_id)
						VALUES ('{$_acl['page_id']}', '{$object_type_id}', '{$object_right_id}')";

				$this->sql_query($sql);

				// get new created $acl_id
				$acl_id = $this->load_single(
					"SELECT acl_id ".
					"FROM {$this->config['table_prefix']}acl ".
					"WHERE object_id = '{$_acl['page_id']}' ".
						"AND object_type_id = '{$object_type_id}' ".
						"AND object_right_id = '{$object_right_id}'
					");
				$acl_id = $acl_id['acl_id'];

				// get user and usergroup privileges
				$privileges	= explode("\n", $_acl['list']);
				$this->debug_print_r($privileges);

				foreach ($privileges as $privilege)
				{
					if (!empty($privilege))
					{
						$grant_id		= '';
						$grant_type_id	= '';
						$deny			= '';

						#$privilege = (string)$privilege;
						// look for '!' prefix, if true set $deny to true and remove it
						if ($privilege[0] == '!')
						{
							$deny = 1;
							$privilege = substr($privilege, 1);
						}
						else
						{
							$deny = 0;
						}

						echo $privilege.'<br />';
						// is group?
						// 1. default groups
						// 1.1 Everybody
						if ($privilege == '*')
						{
							$_grant_id = $this->load_single(
								"SELECT group_id ".
								"FROM {$this->config['table_prefix']}usergroup ".
								"WHERE group_name = 'Everybody'
								");
							$grant_id = $_grant_id['group_id'];
							$grant_type_id = 1;
						}
						// 1.2 Registered
						else if  ($privilege == '$')
						{
							$_grant_id = $this->load_single(
								"SELECT group_id ".
								"FROM {$this->config['table_prefix']}usergroup ".
								"WHERE group_name = 'Registered'
								");
							$grant_id = $_grant_id['group_id'];
							$grant_type_id = 1;
						}
						// 1.3 Admins
						else if  ($privilege == 'Admins')
						{
							$_grant_id = $this->load_single(
								"SELECT group_id ".
								"FROM {$this->config['table_prefix']}usergroup ".
								"WHERE group_name = 'Admins'
								");
							$grant_id = $_grant_id['group_id'];
							$grant_type_id = 1;
						}
						else
						{
							// 2. non default groups
							if (!isset($this->groups))
							{
								$_groups = $this->load_all(
									"SELECT group_name ".
									"FROM {$this->config['table_prefix']}usergroup ");

								foreach ($_groups as $_group)
								{
									$groups[] = $_group['group_name'];
								}
								$this->groups = $groups;
							}

							$this->debug_print_r($groups);

							if (in_array($privilege, $this->groups))
							{
								$grant_id = $this->load_single(
									"SELECT group_id ".
									"FROM {$this->config['table_prefix']}usergroup ".
									"WHERE group_name = '{$privilege}'
									");
								$grant_id		= $grant_id['group_id'];
								$grant_type_id	= 1;
							}
							else
							{
								// 3. users
								if (!isset($this->users))
								{
									$_users = $this->load_all(
									"SELECT user_name ".
									"FROM {$this->config['table_prefix']}user ");

									foreach ($_users as $_user)
									{
										$users[] = $_user['user_name'];
									}
									$this->users = $users;
								}

								$this->debug_print_r($users);

								if (in_array($privilege, $this->users))
								{
									$_grant_id = $this->load_single(
										"SELECT user_id ".
										"FROM {$this->config['table_prefix']}user ".
										"WHERE user_name = '{$privilege}'
										");
									$grant_id		= $_grant_id['user_id'];
									$grant_type_id	= 2;
								}
							}
						}

						// INSERT privileges in 'acl_privilege' table
						$sql =	"INSERT INTO {$this->config['table_prefix']}acl_privilege
								(acl_id, grant_type_id, grant_id, deny)
								VALUES ('{$acl_id}', '{$grant_type_id}', '{$grant_id}', '{$deny}')";

						$this->sql_query($sql);
					}
				}
			}

			echo '<br />'.$old_acl_count.' acl and '.$privilege_count.' privilege settings inserted.';
		}
	*/
}

?>