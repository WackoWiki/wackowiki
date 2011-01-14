<?php

// status: alpha
//
// for testing and improvement - thought for upgrade routine of the installer

echo "<h2>Upgrade Utilities -> Migration Routines for R4.3.rc1 to R4.4.rc1 Upgrade</h2>";
echo 'Recent Wacko version '.$this->format('**!!(green)'.$this->config['wacko_version'].'!!**', 'wacko');

########################################################
##            RENAME files to @page_id@file_name      ##
########################################################

if ($this->is_admin())
{
	if (!isset($_POST['rename']))
	{
		echo "<h3>1. Renames files in \\files\perpage folder to @page_id@file_name:</h3>";
		echo $this->form_open();
		?>
		<input type="submit" name="rename"  value="<?php echo $this->get_translation('CategoriesSaveButton');?>" />
		<?php
		echo $this->form_close();
	}
	// rename files in \files\perpage folder to @page_id@file_name
	else if (isset($_POST['rename']))
	{
		@set_time_limit(0);

		$files = $this->load_all(
			"SELECT u.page_id, file_name, supertag ".
			"FROM {$this->config['table_prefix']}upload u ".
			"INNER JOIN ".$this->config['table_prefix']."page p ON (u.page_id = p.page_id) ".
			"WHERE u.page_id != '0'");

		$dir = $this->config['upload_path_per_page']."/";
		echo "<table><th>old name</th><th></th><th>new name</th>";

		foreach ($files as $file)
		{
			// rename from @PageSupertag@SubPage@file_name to @page_id@file_name
			$old_name = '@'.str_replace('/', '@', $file['supertag']).'@';
			$new_name = '@'.$file['page_id'].'@';
			$file_name = $file['file_name'];

			if($handle = opendir($dir))
			{
				while(false !== ($file = readdir($handle)))
				{
					if($file != '.' && $file != '..')
					{
						$pos = stristr($file, $old_name);
						if ($pos !== false)
						{
							rename($dir.$file, $dir.$new_name.substr($file, strlen($old_name)));
						}
					}
				}
				closedir($handle);

				echo "<tr><td>".$old_name."".$file_name."</td><td> </td><td>".$new_name."".$file_name."</td></tr>";
			}
		}
		echo "</table>";
		echo "<br />Files renamed";
	}
}

########################################################
##            MIGRATE user settings                   ##
########################################################

if (!function_exists('decompose_options'))
{
	function decompose_options($more)
	{
		$optionSplitter			= "\n";		// if you change this two symbols, settings for all users will be lost.
		$valueSplitter			= "=";

		$b		= array();
		$opts	= explode($optionSplitter, $more);

		foreach ($opts as $o)
		{
			$params			= explode($valueSplitter, trim($o));
			$b[$params[0]]	= (isset($params[1]) ? $params[1] : null) ;
		}
		return $b;
	}
}

if (!function_exists('convert_into_bookmark_table'))
{
	function convert_into_bookmark_table($bookmarks, $user_id)
	{
		// bookmarks
		$_bookmarks	= explode("\n", $bookmarks);

		if ($_bookmarks)
		{
			foreach($_bookmarks as $key => $_bookmark)
			{
				// links ((link desc @@lang))
				if ((preg_match('/^\[\[(\S+)(\s+(.+))?\]\]$/', $_bookmark, $matches)) ||
					(preg_match('/^\(\((\S+)(\s+(.+))?\)\)$/', $_bookmark, $matches)) ||
					(preg_match('/^(\S+)(\s+(.+))?$/', $_bookmark, $matches)) ) // without brackets at last!
				{
					list (, $url, $text) = $matches;

					if ($url)
					{
						$url = str_replace(' ', '', $url);

						if ($url[0] == '/')
						{
							$url		= substr($url, 1);
						}

						if (stristr($text, '@@'))
						{
							$t			= explode('@@', $text);
							$text		= $t[0];
							$bm_lang	= $t[1];
						}

						$title			= trim(preg_replace('/|__|\[\[|\(\(/', '', $text));
						$page_id		= $this->get_page_id($url);
						$page_title		= $this->get_page_title('', $page_id);

						if ($page_title !== $title)
						{
							$title		= $title;
						}
						else
						{
							$title		= null;
						}
					}
				}

				if (isset($page_id))
				{
					$this->query(
						"INSERT INTO ".$this->config['table_prefix']."bookmark SET ".
						"user_id			= '".quote($this->dblink, $user_id)."', ".
						"page_id			= '".quote($this->dblink, $page_id)."', ".
						"lang				= '".quote($this->dblink, $bm_lang)."', ".
						"bm_title			= '".quote($this->dblink, $title)."', ".
						"bm_position		= '".quote($this->dblink, ($key + 1))."' ");
				}

				$bm_lang = '';
			}
		}
	}
}

if ($this->is_admin())
{
	if (!isset($_POST['migrate_user_otions']))
	{
		echo "<h3>2. Migrates user options to user_setting table:</h3>";
		echo $this->form_open();
		?>
		<input type="submit" name="migrate_user_otions" value="<?php echo $this->get_translation('CategoriesSaveButton');?>" />
		<?php
		echo $this->form_close();
	}
	// rename files in \files\perpage folder to @page_id@file_name
	else if (isset($_POST['migrate_user_otions']))
	{
		$_users = $this->load_all(
			"SELECT user_id, doubleclick_edit, show_comments, bookmarks, revisions_count, changes_count, lang, show_spaces, typografica, more ".
			"FROM {$this->config['table_prefix']}user ");

		$count = count($_users);

		foreach ($_users as $_user)
		{
			$_user['options'] = decompose_options($_user['more']);
			// user_id, doubleclick_edit, show_comments, bookmarks, revisions_count, changes_count, lang, show_spaces, typografica
			// $_user['options'] : theme, autocomplete, dont_redirect, send_watchmail, show_files, allow_intercom, hide_lastsession, validate_ip, noid_pubs

			$sql =	"INSERT INTO {$this->config['table_prefix']}user_setting
					(user_id, doubleclick_edit, show_comments, revisions_count, changes_count, lang, show_spaces, typografica, theme, autocomplete, dont_redirect, send_watchmail, show_files, allow_intercom, hide_lastsession, validate_ip, noid_pubs)
					VALUES ('{$_user['user_id']}', '{$_user['doubleclick_edit']}', '{$_user['show_comments']}', '{$_user['revisions_count']}', '{$_user['changes_count']}', '{$_user['lang']}', '{$_user['show_spaces']}', '{$_user['typografica']}', '{$_user['options']['theme']}', '{$_user['options']['autocomplete']}', '{$_user['options']['dont_redirect']}', '{$_user['options']['send_watchmail']}', '{$_user['options']['show_files']}', '{$_user['options']['allow_intercom']}', '{$_user['options']['hide_lastsession']}', '{$_user['options']['validate_ip']}', '{$_user['options']['noid_pubs']}')";
			$this->query($sql);

			// Bookmarks
			convert_into_bookmark_table($_user['bookmarks'], $_user['user_id']);
		}

		echo "<br />".$count." user settings inserted.";
	}
}

########################################################
##            MIGRATE ACLs to new scheme              ##
########################################################

if ($this->is_admin())
{
	if (!isset($_POST['migrate_acls']))
	{
		echo "<h3>3. Migrates acls to new scheme:</h3>";
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
				"SELECT acl_right_id ".
				"FROM {$this->config['table_prefix']}acl_right ".
				"WHERE object_right = '{$_acl['privilege']}'
				");
			$object_right_id = $_object_right_id['acl_right_id'];

			// get object_type_id (e.g. 'page' -> 1) / there is only 'page' so far
			$_object_type_id = $this->load_single(
				"SELECT acl_type_id ".
				"FROM {$this->config['table_prefix']}acl_type ".
				"WHERE object_type = 'page'
				");
			$object_type_id = $_object_type_id['acl_type_id'];

			// INSERT rights in 'acl' table
			$sql =	"INSERT INTO {$this->config['table_prefix']}acl
					(object_id, object_type_id, object_right_id)
					VALUES ('{$_acl['page_id']}', '{$object_type_id}', '{$object_right_id}')";

			$this->query($sql);

			// get new created $acl_id
			$acl_id = $this->load_single(
				"SELECT acl_id ".
				"FROM {$this->config['table_prefix']}acl ".
				"WHERE object_id = '{$_acl['page_id']}' ".
					"AND object_type_id = '{$object_type_id}' ".
					"AND object_right_id = '{$object_right_id}'
				");
			$acl_id = $acl_id['acl_id'];

			// get user and group privileges
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
							"FROM {$this->config['table_prefix']}group ".
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
							"FROM {$this->config['table_prefix']}group ".
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
							"FROM {$this->config['table_prefix']}group ".
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
								"FROM {$this->config['table_prefix']}group ");

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
								"FROM {$this->config['table_prefix']}group ".
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

					$this->query($sql);
				}
			}
		}

		echo '<br />'.$old_acl_count.' acl and '.$privilege_count.' privilege settings inserted.';
	}
}

?>