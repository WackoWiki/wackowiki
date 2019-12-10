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
	echo 'Recent Wacko version ' . $this->format('**!!(green)' . $this->db->wacko_version . '!!**', 'wacko');
	echo '<h3>Routines for R5.x</h3>';

	########################################################
	##            Set page title based on tag             ##
	########################################################

	if ($this->is_admin())
	{
		echo "<h4>6. Set page title based on tag if empty:</h4>";

		if (!isset($_POST['set_title']))
		{
			echo $this->form_open('set_title');
			?>
			<input type="submit" name="set_title"  value="<?php echo $this->_t('CategoriesSaveButton');?>">
			<?php
			echo $this->form_close();
		}
		else if (isset($_POST['set_title']))
		{
			$pages = $this->db->load_all(
				"SELECT page_id, tag, page_lang " .
				"FROM " . $this->db->table_prefix . "page " .
				"WHERE title = ''");

			if (!empty($pages))
			{
				echo "<table><tr><th>page_id</th><th>tag</th><th>new title</th></tr>";

				foreach ($pages as $page)
				{
					$lang = $page['page_lang'];
					if ($this->known_language($lang))
					{
						$this->load_translation($lang);
						$this->set_translation($lang);
						$this->set_page_lang($lang);
						// tag to title
						$title = $this->add_spaces_title(trim(substr($page['tag'], mb_strrpos($page['tag'], '/')), '/'));

						$this->db->sql_query(
							"UPDATE " . $this->db->table_prefix . "page " .
							"SET title = " . $this->db->q($title) . " " .
							"WHERE page_id = " . (int) $page['page_id'] . " " .
							"LIMIT 1");

						echo "<tr><td>" . $page['page_id'] . "</td><td>" . $page['tag'] . "</td><td>" . $title . "</td></tr>";
					}
				}

				$this->load_translation($this->user_lang);
				$this->set_translation($this->user_lang);
				$this->set_language($this->user_lang);

				echo "</table>";
				echo "<br>Titles set";
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
		echo "<h4>7. Set page depth and parent_id based on tag:</h4>";

		if (!isset($_POST['set_depth']))
		{
			echo $this->form_open('set_depth');
			?>
			<input type="submit" name="set_depth"  value="<?php echo $this->_t('CategoriesSaveButton');?>">
			<?php
			echo $this->form_close();
		}
		else if (isset($_POST['set_depth']))
		{
			$pages = $this->db->load_all(
				"SELECT page_id, tag " .
				"FROM " . $this->db->table_prefix . "page " .
				"WHERE comment_on_id = 0");

			if (!empty($pages))
			{
				echo "<table><tr><th>page_id</th><th>tag</th><th>depth</th><th>parent_id</th></tr>";

				foreach ($pages as $page)
				{
					// determine the depth
					$_depth_array	= explode('/', $page['tag']);
					$depth			= count( $_depth_array );

					$parent_id		= $this->get_parent_id($page['tag']);

					$this->db->sql_query(
						"UPDATE " . $this->db->table_prefix . "page SET " .
							"depth		= " . (int) $depth . ", " .
							"parent_id	= " . (int) $parent_id . " " .
						"WHERE page_id = " . (int) $page['page_id'] . " " .
						"LIMIT 1");

					echo "<tr><td>" . $page['page_id'] . "</td><td>" . $page['tag'] . "</td><td>" . $depth . "</td><td>" . $parent_id . "</td></tr>";
				}

				echo "</table>";
				echo "<br>Depth set";
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
		echo "<h4>8. Set version_id for revisions:</h4>";

		if (!isset($_POST['set_version_id']))
		{
			echo $this->form_open('set_version_id');
			?>
			<input type="submit" name="set_version_id" value="<?php echo $this->_t('CategoriesSaveButton');?>">
			<?php
			echo $this->form_close();
		}
		else if (isset($_POST['set_version_id']))
		{
			$pages = $this->db->load_all(
				"SELECT page_id " .
				"FROM " . $this->db->table_prefix . "revision " .
				"GROUP BY page_id");

			if (!empty($pages))
			{
				echo "<table><tr><th>page_id</th><th>revision_id</th><th>version</th></tr>";

				foreach ($pages as $page)
				{
					$_revisions = $this->db->load_all(
						"SELECT revision_id, page_id " .
						"FROM " . $this->db->table_prefix . "revision " .
						"WHERE page_id = " . (int) $page['page_id'] . " " .
						"ORDER BY modified DESC");

					$t = count($_revisions);

					foreach ($_revisions as $_revision)
					{
						$version_id = $t--;

						$this->db->sql_query(
							"UPDATE " . $this->db->table_prefix . "revision SET " .
								"version_id = " . (int) $version_id . " " .
							"WHERE revision_id = " . (int) $_revision['revision_id'] . " " .
							"LIMIT 1");

						echo "<tr><td>" . $_revision['page_id'] . "</td><td>" . $_revision['revision_id'] . "</td><td>" . $version_id . "</td></tr>";
					}
				}

				echo "</table>";
				echo '<br>Version_id set in revisions';
			}
			else
			{
				echo 'No pages found.';
			}
		}
	}

	########################################################
	##            Set missing ACL sets                    ##
	########################################################

	if ($this->is_admin())
	{
		echo "<h4>8. Set missing ACL permissions:</h4>";

		if (!isset($_POST['set_missing_permissions']))
		{
			echo $this->form_open('set_missing_permissions');
			?>
			<input type="submit" name="set_missing_permissions" value="<?php echo $this->_t('UpdateButton');?>">
			<?php
			echo $this->form_close();
		}
		else if (isset($_POST['set_missing_permissions']))
		{
			$pages = $this->db->load_all(
				"SELECT
					p.page_id, p.tag, COUNT(*) AS n
				FROM
					" . $this->db->table_prefix . "page p
					LEFT JOIN " . $this->db->table_prefix . "acl a ON (p.page_id = a.page_id)
				GROUP BY p.page_id
				HAVING COUNT(p.page_id) < 5
				ORDER BY p.page_id ASC");

			if (!empty($pages))
			{
				echo "<table><tr><th>page_id</th><th>tag</th><th>sets</th></tr>";

				foreach ($pages as $page)
				{
					$acl	= [];
					// load acls
					$acl['read']	= $this->load_acl($page['page_id'], 'read',		1, 0);
					$acl['write']	= $this->load_acl($page['page_id'], 'write',	1, 0);
					$acl['comment']	= $this->load_acl($page['page_id'], 'comment',	1, 0);
					$acl['create']	= $this->load_acl($page['page_id'], 'create',	1, 0);
					$acl['upload']	= $this->load_acl($page['page_id'], 'upload',	1, 0);

					// saving acls
					$this->save_acl($page['page_id'], 'read',		$acl['read']['list']);
					$this->save_acl($page['page_id'], 'write',		$acl['write']['list']);
					$this->save_acl($page['page_id'], 'comment',	$acl['comment']['list']);
					$this->save_acl($page['page_id'], 'create',		$acl['create']['list']);
					$this->save_acl($page['page_id'], 'upload',		$acl['upload']['list']);

					echo "<tr><td>" . $page['page_id'] . "</td><td>" . $page['tag'] . "</td><td>" . $page['n'] . "</td></tr>";
					echo "<tr><td>create: " . $acl['create']['list'] . "</td><td>upload: " . $acl['upload']['list'] . "</td><td>" . $page['n'] . "</td></tr>";
				}

				echo "</table>";
				echo '<br>Missing permissions set.';
			}
			else
			{
				echo 'No pages with missing permissions found.';
			}
		}
	}

	########################################################
	##            MIGRATE ACLs to new scheme              ##
	########################################################

	# postponed -> R7.1

	// rename the old 'acl' table to 'acl_old' first
	/*
	if ($this->is_admin())
	{
		if (!isset($_POST['migrate_acls']))
		{
			echo "<h3>7. Migrates acls to new scheme:</h3>";
			echo $this->form_open('migrate_acls');
			?>
			<input type="submit" name="migrate_acls" value="<?php echo $this->_t('CategoriesSaveButton');?>">
			<?php
			echo $this->form_close();
		}
		// migrate acls to new acl and acl_privilege table
		else if (isset($_POST['migrate_acls']))
		{
			// load old ACLs
			$_acls = $this->db->load_all(
				"SELECT page_id, privilege, list " .
				"FROM " . $this->db->table_prefix . "acl_old ");

			$old_acl_count = count($_acls);

			foreach ($_acls as $_acl)
			{
				echo $_acl['privilege'] . '<br>';
				// get object_right_id (e.g. 'write' -> 1, 'read' -> 2)
				$_object_right_id = $this->db->load_single(
					"SELECT object_right_id " .
					"FROM " . $this->db->table_prefix . "acl_right " .
					"WHERE object_right = '{$_acl['privilege']}'
					");
				$object_right_id = $_object_right_id['object_right_id'];

				// get object_type_id (e.g. 'page' -> 1) / there is only 'page' so far
				$_object_type_id = $this->db->load_single(
					"SELECT object_type_id " .
					"FROM " . $this->db->table_prefix . "acl_type " .
					"WHERE object_type = 'page'
					");
				$object_type_id = $_object_type_id['object_type_id'];

				// INSERT rights in 'acl' table
				$sql =	"INSERT INTO " . $this->db->table_prefix . "acl
						(object_id, object_type_id, object_right_id)
						VALUES ('{$_acl['page_id']}', '{$object_type_id}', '{$object_right_id}')";

				$this->db->sql_query($sql);

				// get new created $acl_id
				$acl_id = $this->db->load_single(
					"SELECT acl_id " .
					"FROM " . $this->db->table_prefix . "acl " .
					"WHERE object_id = '{$_acl['page_id']}' " .
						"AND object_type_id = '{$object_type_id}' " .
						"AND object_right_id = '{$object_right_id}'
					");
				$acl_id = $acl_id['acl_id'];

				// get user and usergroup privileges
				$privileges	= explode("\n", $_acl['list']);
				Ut::debug_print_r($privileges);

				foreach ($privileges as $privilege)
				{
					if (!empty($privilege))
					{
						$grant_id		= '';
						$grant_type_id	= '';
						$deny			= '';

						#$privilege = (string) $privilege;
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

						echo $privilege . '<br>';
						// is group?
						// 1. default groups
						// 1.1 Everybody
						if ($privilege == '*')
						{
							$_grant_id = $this->db->load_single(
								"SELECT group_id " .
								"FROM " . $this->db->table_prefix . "usergroup " .
								"WHERE group_name = 'Everybody'
								");
							$grant_id = $_grant_id['group_id'];
							$grant_type_id = 1;
						}
						// 1.2 Registered
						else if  ($privilege == '$')
						{
							$_grant_id = $this->db->load_single(
								"SELECT group_id " .
								"FROM " . $this->db->table_prefix . "usergroup " .
								"WHERE group_name = 'Registered'
								");
							$grant_id = $_grant_id['group_id'];
							$grant_type_id = 1;
						}
						// 1.3 Admins
						else if  ($privilege == 'Admins')
						{
							$_grant_id = $this->db->load_single(
								"SELECT group_id " .
								"FROM " . $this->db->table_prefix . "usergroup " .
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
								$_groups = $this->db->load_all(
									"SELECT group_name " .
									"FROM " . $this->db->table_prefix . "usergroup ");

								foreach ($_groups as $_group)
								{
									$groups[] = $_group['group_name'];
								}
								$this->groups = $groups;
							}

							Ut::debug_print_r($groups);

							if (in_array($privilege, $this->groups))
							{
								$grant_id = $this->db->load_single(
									"SELECT group_id " .
									"FROM " . $this->db->table_prefix . "usergroup " .
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
									$_users = $this->db->load_all(
									"SELECT user_name " .
									"FROM " . $this->db->table_prefix . "user ");

									foreach ($_users as $_user)
									{
										$users[] = $_user['user_name'];
									}
									$this->users = $users;
								}

								Ut::debug_print_r($users);

								if (in_array($privilege, $this->users))
								{
									$_grant_id = $this->db->load_single(
										"SELECT user_id " .
										"FROM " . $this->db->table_prefix . "user " .
										"WHERE user_name = '{$privilege}'
										");
									$grant_id		= $_grant_id['user_id'];
									$grant_type_id	= 2;
								}
							}
						}

						// INSERT privileges in 'acl_privilege' table
						$sql =	"INSERT INTO " . $this->db->table_prefix . "acl_privilege
								(acl_id, grant_type_id, grant_id, deny)
								VALUES ('{$acl_id}', '{$grant_type_id}', '{$grant_id}', '{$deny}')";

						$this->db->sql_query($sql);
					}
				}
			}

			echo '<br>' . $old_acl_count . ' acl and ' . $privilege_count . ' privilege settings inserted.';
		}
	*/
}

