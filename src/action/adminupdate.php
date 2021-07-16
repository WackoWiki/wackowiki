<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// status: beta
//
// for testing and improvement - thought as upgrade routine for the installer

$prefix			= $this->db->table_prefix;
$charset		= 'utf8mb4';
$collation		= 'utf8mb4_unicode_520_ci';		// Unicode (UCA 5.2.0), case-insensitive, https://dev.mysql.com/doc/refman/8.0/en/charset-collation-names.html

// get MariaDB / MySQL version
$_db_version	= $this->db->load_single("SELECT version()");
$db_version		= $_db_version['version()'];

echo '<h2>Upgrade Utilities</h2>';

$info[] = ['WackoWiki version', $this->format('**!!(green)' . $this->db->wacko_version . '!!**', 'wacko')];
$info[] = ['MariaDB / MySQL version', $db_version];
$info[] = ['Database charset', $this->db->db_charset];
$info[] = ['Database collation', $this->db->db_collation];

echo '<table style="max-width:800px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation lined">' . "\n";

foreach ($info as $value)
{
	echo '<tr>' .
			'<td class="label"><strong>' . $value[0] . '</strong></td>' .
			'<td> </td>' .
			'<td>' . $value[1] . '</td>' . "\n";
}

echo '</table>' . "\n";

if ($this->is_admin())
{
	echo '<h3>Routines for R5.x</h3>';

	########################################################
	##            Set page title based on tag             ##
	########################################################

	echo '<h4>1. Set page title based on tag if empty</h4>';

	if (!isset($_POST['set_title']))
	{
		echo $this->form_open('set_title');
		echo '<button type="submit" name="set_title">' . $this->_t('SubmitButton') . '</button>';
		echo $this->form_close();
	}
	else if (isset($_POST['set_title']))
	{
		$pages = $this->db->load_all(
			"SELECT page_id, tag, page_lang " .
			"FROM {$prefix}page " .
			"WHERE title = ''");

		if (!empty($pages))
		{
			echo '<table>
					<tr>
						<th>page_id</th>
						<th>tag</th>
						<th>new title</th>
					</tr>' . "\n";

			foreach ($pages as $page)
			{
				$lang = $page['page_lang'];
				if ($this->known_language($lang))
				{
					$this->load_translation($lang);
					$this->set_translation($lang);
					$this->set_page_lang($lang);
					// tag to title
					$title = $this->create_title_from_tag($page['tag']);

					$this->db->sql_query(
						"UPDATE {$prefix}page " .
						"SET title = " . $this->db->q($title) . " " .
						"WHERE page_id = " . (int) $page['page_id'] . " " .
						"LIMIT 1");

					echo '<tr>
							<td>' . $page['page_id'] . '</td>
							<td>' . $page['tag'] . '</td>
							<td>' . $title . '</td>
						</tr>' . "\n";
				}
			}

			$this->load_translation($this->user_lang);
			$this->set_translation($this->user_lang);
			$this->set_language($this->user_lang);

			echo '</table>';
			echo '<br>Titles set';
		}
		else
		{
			echo 'No empty title field found.';
		}
	}

	########################################################
	##            Set depth based on tag                  ##
	########################################################

	echo '<h4>2. Set page depth and parent_id based on tag</h4>';

	if (!isset($_POST['set_depth']))
	{
		echo $this->form_open('set_depth');
		echo '<button type="submit" name="set_depth">' . $this->_t('SubmitButton') . '</button>';
		echo $this->form_close();
	}
	else if (isset($_POST['set_depth']))
	{
		$pages = $this->db->load_all(
			"SELECT page_id, tag " .
			"FROM {$prefix}page " .
			"WHERE comment_on_id = 0");

		if (!empty($pages))
		{
			echo '<table>
					<tr>
						<th>page_id</th>
						<th>tag</th>
						<th>depth</th>
						<th>parent_id</th>
					</tr>' . "\n";

			foreach ($pages as $page)
			{
				// determine the depth
				$_depth_array	= explode('/', $page['tag']);
				$depth			= count( $_depth_array );

				$parent_id		= $this->get_parent_id($page['tag']);

				$this->db->sql_query(
					"UPDATE {$prefix}page SET " .
						"depth		= " . (int) $depth . ", " .
						"parent_id	= " . (int) $parent_id . " " .
					"WHERE page_id = " . (int) $page['page_id'] . " " .
					"LIMIT 1");

				echo '<tr>
						<td>' . $page['page_id'] . '</td>
						<td>' . $page['tag'] . '</td>
						<td>' . $depth . '</td>
						<td>' . $parent_id . '</td>
					</tr>' . "\n";
			}

			echo '</table>';
			echo '<br>Depth set';
		}
		else
		{
			echo 'No pages found.';
		}
	}

	########################################################
	##            Set version_id for revision             ##
	########################################################

	echo '<h4>3. Set version_id for revisions</h4>';

	if (!isset($_POST['set_version_id']))
	{
		echo $this->form_open('set_version_id');
		echo '<button type="submit" name="set_version_id">' . $this->_t('SubmitButton') . '</button>';
		echo $this->form_close();
	}
	else if (isset($_POST['set_version_id']))
	{
		$pages = $this->db->load_all(
			"SELECT page_id " .
			"FROM {$prefix}revision " .
			"GROUP BY page_id");

		if (!empty($pages))
		{
			echo '<table>
					<tr>
						<th>page_id</th>
						<th>revision_id</th>
						<th>version</th>
					</tr>' . "\n";

			foreach ($pages as $page)
			{
				$_revisions = $this->db->load_all(
					"SELECT revision_id, page_id " .
					"FROM {$prefix}revision " .
					"WHERE page_id = " . (int) $page['page_id'] . " " .
					"ORDER BY modified DESC");

				$t = count($_revisions);

				foreach ($_revisions as $_revision)
				{
					$version_id = $t--;

					$this->db->sql_query(
						"UPDATE {$prefix}revision SET " .
							"version_id = " . (int) $version_id . " " .
						"WHERE revision_id = " . (int) $_revision['revision_id'] . " " .
						"LIMIT 1");

					echo '<tr>
							<td>' . $_revision['page_id'] . '</td>
							<td>' . $_revision['revision_id'] . '</td>
							<td>' . $version_id . '</td>
						</tr>' . "\n";
				}
			}

			echo '</table>';
			echo '<br>Version_id set in revisions';
		}
		else
		{
			echo 'No pages found.';
		}
	}

	########################################################
	##            Set missing ACL sets                    ##
	########################################################

	echo '<h4>4. Set missing ACL permissions</h4>';

	if (!isset($_POST['set_missing_permissions']))
	{
		echo $this->form_open('set_missing_permissions');
		echo '<button type="submit" name="set_missing_permissions">' .  $this->_t('UpdateButton') . '</button>';
		echo $this->form_close();
	}
	else if (isset($_POST['set_missing_permissions']))
	{
		$pages = $this->db->load_all(
			"SELECT
				p.page_id, p.tag, COUNT(*) AS n
			FROM
				{$prefix}page p
				LEFT JOIN {$prefix}acl a ON (p.page_id = a.page_id)
			GROUP BY p.page_id
			HAVING COUNT(p.page_id) < 5
			ORDER BY p.page_id ASC");

		if (!empty($pages))
		{
			echo '<table>
					<tr>
						<th>page_id</th>
						<th>tag</th>
						<th>sets</th>
					</tr>' . "\n";

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

				echo '<tr>
						<td>' . $page['page_id'] . '</td>
						<td>' . $page['tag'] . '</td>
						<td>' . $page['n'] . '</td>
					</tr>
					<tr>
						<td>create: ' . $acl['create']['list'] . '</td>
						<td>upload: ' . $acl['upload']['list'] . '</td>
						<td>' . $page['n'] . '</td>
					</tr>' . "\n";
			}

			echo '</table>';
			echo '<br>Missing permissions set.';
		}
		else
		{
			echo 'No pages with missing permissions found.';
		}
	}

	echo '<h3>Routines for R6.x</h3>';

	########################################################
	##            Set VARCHAR(191) legacy fields back     ##
	########################################################

	$large_prefix	= false;

	// MySQL versions prior to 5.7.7 or MariaDB 10.2.2 do not support index key prefixes up to 3072 bytes by default.
	$min_db_version = preg_match('/MariaDB/', $db_version, $matches)
		? '10.2.2'
		: '5.7.7';

	if (version_compare($db_version, $min_db_version , '>='))
	{
		$large_prefix = true;
	}

	if ($large_prefix)
	{
		echo '<h4>1. Alter tables to work with key prefixes longer than 767 bytes</h4>';

		if (!isset($_POST['set_large_prefix_tables']))
		{
			echo $this->form_open('large_prefix');
			echo '<button type="submit" name="set_large_prefix_tables">' . $this->_t('UpdateButton') . '</button>';
			echo $this->form_close();
		}
		else if (isset($_POST['set_large_prefix_tables']))
		{
			$results =
				'<strong>' . date('H:i:s') . ' - ' . 'Alter tables started' . "\n" .
				'================================================</strong>' . "\n";

			$results .=
				'<strong>' . 'VARCHAR(250): ' . "\n" .
				'Tables:  file, page, page_link and revision:</strong>' . "\n\n";

			$this->db->sql_query("
				ALTER TABLE {$prefix}file
					CHANGE file_name file_name VARCHAR(250) COLLATE {$collation} NOT NULL DEFAULT '';");

			$this->db->sql_query("
				ALTER TABLE {$prefix}page
					CHANGE title title VARCHAR(250) COLLATE {$collation} NOT NULL DEFAULT '',
					CHANGE tag tag VARCHAR(250) COLLATE {$collation} NOT NULL DEFAULT '';");

			$this->db->sql_query("
				ALTER TABLE {$prefix}page_link
					CHANGE to_tag to_tag VARCHAR(250) COLLATE {$collation} NOT NULL DEFAULT '';");

			$this->db->sql_query("
				ALTER TABLE {$prefix}revision
					CHANGE title title VARCHAR(250) COLLATE {$collation} NOT NULL DEFAULT '',
					CHANGE tag tag VARCHAR(250) COLLATE {$collation} NOT NULL DEFAULT '';");

			$results .=
				'<strong>' . date('H:i:s') . ' - ' . 'Tables altered.' . "\n" .
				'================================================</strong>' . "\n";

			echo
				'<div class="code">' .
					'<pre>' . $results . '</pre>' .
				'</div><br>';
		}
	}

	########################################################
	##            Replace legacy format passwords         ##
	########################################################

	echo '<h4>2. Reset and regenerate the password & password hash for legacy password formats</h4>';

	/* replaces legacy format password with a random new password hash
	 *
	 * This only affects wikis that were already in use before R5.5.
	 * This mainly serves the purpose that these password hashes are not exploitable for bad actors.
	 *
	 * Affected users must use the password recovery function to reset their password,
	 * this is however only possible for users with a confirmed email address.
	 *
	 * TODO:
	 * add deactivate accounts option
	 *		$user['enabled'] = 0
	 *		$user['account_status'] = 2 (denied /disabled)
	 * add option to inform users about password reset
	 */

	$users = $this->db->load_all(
		"SELECT user_id, user_name, LENGTH(password) AS password, email, email_confirm, signup_time, last_visit, total_pages, total_revisions, total_comments, total_uploads " .
		"FROM " . $this->db->user_table . " " .
		"WHERE  LENGTH(password) = 32 OR LENGTH(password) = 64");

	if ($users)
	{
		echo '<table class="usertable">' . "\n";
		echo
			'<tr class="userrow">
				<th>user_id</th>
				<th>user_name</th>
				<th>algo</th>
				<th>email</th>
				<th>email_confirm</th>
				<th>signup_time</th>
				<th>last_visit</th>
				<th>pages</th>
				<th>revisions</th>
				<th>comments</th>
				<th>uploads</th>
			</tr>' . "\n";

		foreach ($users as $user)
		{
			// check for old password formats
			if ($user['password'] == 32)
			{
				$algo = 'md5';
			}
			else
			{
				$algo = 'sha256';
			}

			if (isset($_POST['reset_password']))
			{
				// generate random password
				$password	= Ut::random_token(20, 3);
				$hash		= $this->password_hash($user, $password);

				// update database with the new password hash
				$this->db->sql_query(
					"UPDATE " . $this->db->table_prefix . "user SET " .
						"password	= " . $this->db->q($hash) . " " .
					"WHERE user_id = " . (int) $user['user_id']);
			}
			else
			{
				// show affected users
				echo
					'<tr class="userrow">
						<td>' . $user['user_id'] .	'</td>
						<td>' . $user['user_name'] . '</td>
						<td>' . $algo . '</td>
						<td>' . $user['email'] . '</td>
						<td>' . ($user['email_confirm'] ? 'No' : 'Yes') . '</td>
						<td>' . $user['signup_time'] . '</td>
						<td>' . $user['last_visit'] . '</td>
						<td>' . $user['total_pages'] . '</td>
						<td>' . $user['total_revisions'] . '</td>
						<td>' . $user['total_comments'] . '</td>
						<td>' . $user['total_uploads'] . '</td>
					</tr>' . "\n";
			}
		}

		echo '</table>' . "\n";

		if (isset($_POST['reset_password']))
		{
			// remove obsolete salt field
			$this->db->sql_query(
				"ALTER TABLE " . $this->db->table_prefix . "user DROP salt");
		}
		else
		{
			echo $this->form_open('reset_password');
			echo '<button type="submit" name="reset_password">' . $this->_t('ResetButton') . '</button>' . "\n";
			echo $this->form_close();
		}
	}
	else
	{
		echo 'All good. No legacy password hashes found.';
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
			echo '<h3>7. Migrates acls to new scheme:</h3>';
			echo $this->form_open('migrate_acls');
			echo '<button type="submit" name="migrate_acls">' . $this->_t('SubmitButton') . '</button>';
			echo $this->form_close();
		}
		// migrate acls to new acl and acl_privilege table
		else if (isset($_POST['migrate_acls']))
		{
			// load old ACLs
			$_acls = $this->db->load_all(
				"SELECT page_id, privilege, list " .
				"FROM {$prefix}acl_old ");

			$old_acl_count = count($_acls);

			foreach ($_acls as $_acl)
			{
				echo $_acl['privilege'] . '<br>';
				// get object_right_id (e.g. 'write' -> 1, 'read' -> 2)
				$_object_right_id = $this->db->load_single(
					"SELECT object_right_id " .
					"FROM {$prefix}acl_right " .
					"WHERE object_right = '{$_acl['privilege']}'
					");
				$object_right_id = $_object_right_id['object_right_id'];

				// get object_type_id (e.g. 'page' -> 1) / there is only 'page' so far
				$_object_type_id = $this->db->load_single(
					"SELECT object_type_id " .
					"FROM {$prefix}acl_type " .
					"WHERE object_type = 'page'
					");
				$object_type_id = $_object_type_id['object_type_id'];

				// INSERT rights in 'acl' table
				$sql =	"INSERT INTO {$prefix}acl
						(object_id, object_type_id, object_right_id)
						VALUES ('{$_acl['page_id']}', '{$object_type_id}', '{$object_right_id}')";

				$this->db->sql_query($sql);

				// get new created $acl_id
				$acl_id = $this->db->load_single(
					"SELECT acl_id " .
					"FROM {$prefix}acl " .
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
							$privilege = mb_substr($privilege, 1);
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
								"FROM {$prefix}usergroup " .
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
								"FROM {$prefix}usergroup " .
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
								"FROM {$prefix}usergroup " .
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
									"FROM {$prefix}usergroup ");

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
									"FROM {$prefix}usergroup " .
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
									"FROM {$prefix}user ");

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
										"FROM {$prefix}user " .
										"WHERE user_name = '{$privilege}'
										");
									$grant_id		= $_grant_id['user_id'];
									$grant_type_id	= 2;
								}
							}
						}

						// INSERT privileges in 'acl_privilege' table
						$sql =	"INSERT INTO {$prefix}acl_privilege
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

