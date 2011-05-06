<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// status: beta
//
// for testing and improvement - thought as upgrade routine for the installer

echo '<h2>Upgrade Utilities</h2>';
echo 'Recent Wacko version '.$this->format('**!!(green)'.$this->config['wacko_version'].'!!**', 'wacko');
echo '<h3>Migration Routines for R4.3 to R5.0.rc1 Upgrade</h3>';

########################################################
##            RENAME files to @page_id@file_name      ##
########################################################

if ($this->is_admin())
{
	echo "<h4>1. Renames files in \\files\perpage folder to @page_id@file_name:</h4>";

	if (!isset($_POST['rename']))
	{
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
		echo "<table><tr><th>old name</th><th></th><th>new name</th></tr>";

		foreach ($files as $file)
		{
			// rename from @PageSupertag@SubPage@file_name to @page_id@file_name
			$old_name	= '@'.str_replace('/', '@', $file['supertag']).'@';
			$new_name	= '@'.$file['page_id'].'@';
			$file_name	= $file['file_name'];

			if($handle = opendir($dir))
			{
				while(false !== ($file = readdir($handle)))
				{
					if($file != '.' && $file != '..')
					{
						if ($file == $old_name.$file_name)
						{
							rename($dir.$file, $dir.$new_name.$file_name);

							echo "<tr><td>".$old_name."".$file_name."</td><td> </td><td>".$new_name."".$file_name."</td></tr>";
						}
					}
				}

				closedir($handle);
			}
		}

		echo "</table>";
		echo "<br />Files renamed";
	}
}

########################################################
##            Move global files to /files/global      ##
########################################################

if ($this->is_admin())
{
	echo "<h4>2. Move global files from \\files to \\files\global folder:</h4>";

	if (!isset($_POST['move']))
	{
		echo $this->form_open();
		?>
		<input type="submit" name="move"  value="<?php echo $this->get_translation('CategoriesSaveButton');?>" />
		<?php
		echo $this->form_close();
	}
	// move global files from \\files to \\files\global folder
	else if (isset($_POST['move']))
	{
		@set_time_limit(0);

		$files = $this->load_all(
			"SELECT page_id, file_name ".
			"FROM {$this->config['table_prefix']}upload ".
			"WHERE page_id = '0'");

		echo "<table><tr><th>old dir</th><th></th><th>new dir</th></tr>";

		foreach ($files as $file)
		{
			// move from /file/file_name to /file/global/file_name
			$new_dir		= $this->config['upload_path'].'/';
			$new_subfolder	= 'global';
			$old_dir		= substr($new_dir, 0, -(strlen($new_subfolder) + 1));
			$file_name		= $file['file_name'];

			if($handle = opendir($old_dir))
			{
				while(false !== ($file = readdir($handle)))
				{
					if($file != '.' && $file != '..')
					{
						$pos = stristr($file, $file_name);

						if ($pos !== false)
						{
							rename($old_dir.$file, $new_dir.$file);

							echo "<tr><td>".$old_dir.$file_name."</td><td> </td><td>".$new_dir.$file_name."</td></tr>";
						}
					}
				}

				closedir($handle);
			}
		}

		echo "</table>";
		echo "<br />Files moved";
	}
}

########################################################
##            MIGRATE user settings                   ##
########################################################

// requires the old 4.3 user table

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

if (!function_exists('convert_into_menu_table'))
{
	function convert_into_menu_table(&$wacko, $menu, $user_id)
	{
		// bookmarks
		$_menu	= explode("\n", $menu);

		if ($_menu)
		{
			foreach($_menu as $key => $menu_item)
			{
				// links ((link desc @@lang))
				if ((preg_match('/^\[\[(\S+)(\s+(.+))?\]\]$/', $menu_item, $matches)) ||
					(preg_match('/^\(\((\S+)(\s+(.+))?\)\)$/', $menu_item, $matches)) ||
					(preg_match('/^(\S+)(\s+(.+))?$/', $menu_item, $matches)) ) // without brackets at last!
				{
					#$wacko->debug_print_r($matches);
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
							$t				= explode('@@', $text);
							$text			= $t[0];
							$menu_item_lang	= $t[1];
						}

						$title			= trim(preg_replace('/|__|\[\[|\(\(/', '', $text));
						$page_id		= $wacko->get_page_id($url);
						$page_title		= $wacko->get_page_title('', $page_id);

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
					$wacko->sql_query(
						"INSERT INTO ".$wacko->config['table_prefix']."menu SET ".
						"user_id			= '".quote($wacko->dblink, $user_id)."', ".
						"page_id			= '".quote($wacko->dblink, $page_id)."', ".
						"lang				= '".quote($wacko->dblink, (isset($menu_item_lang) ? $menu_item_lang : '') )."', ".
						"menu_title			= '".quote($wacko->dblink, $title)."', ".
						"menu_position		= '".quote($wacko->dblink, ($key + 1))."' ");
				}

				$menu_item_lang = '';
			}
		}
	}
}

if ($this->is_admin())
{
	echo "<h4>3. Migrates user options to user_setting table:</h4>";

	if (!isset($_POST['migrate_user_otions']))
	{
		echo $this->form_open();
		?>
		<input type="submit" name="migrate_user_otions" value="<?php echo $this->get_translation('CategoriesSaveButton');?>" />
		<?php
		echo $this->form_close();
	}
	// migrates user settings to 'user_setting' table
	else if (isset($_POST['migrate_user_otions']))
	{
		$_users = $this->load_all(
			"SELECT user_id, doubleclick_edit, show_comments, bookmarks, revisions_count, changes_count, lang, show_spaces, typografica, more ".
			"FROM {$this->config['table_prefix']}user ".
			"WHERE user_name NOT LIKE '{$this->config['admin_name']}'");

		$count = count($_users);

		foreach ($_users as $_user)
		{
			$_user['options'] = decompose_options($_user['more']);
			// user_id, doubleclick_edit, show_comments, bookmarks, revisions_count, changes_count, lang, show_spaces, typografica
			// $_user['options'] : theme, autocomplete, dont_redirect, send_watchmail, show_files, allow_intercom, hide_lastsession, validate_ip, noid_pubs

			if (!isset($_user['options']['theme']) || $_user['options']['theme'] == '')
			{
				$_user['options']['theme'] = $this->config['theme'];
			}

			$sql =	"INSERT INTO {$this->config['table_prefix']}user_setting SET ".
				"user_id			= '".quote($this->dblink, isset($_user['user_id']) ? $_user['user_id'] : '')."', ".
				"doubleclick_edit	= '".quote($this->dblink, isset($_user['doubleclick_edit']) ? $_user['doubleclick_edit'] : '')."', ".
				"show_comments		= '".quote($this->dblink, isset($_user['show_comments']) ? $_user['show_comments'] : '')."', ".
				"revisions_count	= '".quote($this->dblink, isset($_user['revisions_count']) ? $_user['revisions_count'] : '')."', ".
				"changes_count		= '".quote($this->dblink, isset($_user['changes_count']) ? $_user['changes_count'] : '')."', ".
				"lang				= '".quote($this->dblink, isset($_user['lang']) ? $_user['lang'] : '')."', ".
				"show_spaces		= '".quote($this->dblink, isset($_user['show_spaces']) ? $_user['show_spaces'] : '')."', ".
				"typografica		= '".quote($this->dblink, isset($_user['typografica']) ? $_user['typografica'] : '')."', ".
				"theme				= '".quote($this->dblink, isset($_user['options']['theme']) ? $_user['options']['theme'] : 'default')."', ".
				"autocomplete		= '".quote($this->dblink, isset($_user['options']['autocomplete']) ? $_user['options']['autocomplete'] : '')."', ".
				"dont_redirect		= '".quote($this->dblink, isset($_user['options']['dont_redirect']) ? $_user['options']['dont_redirect'] : '')."', ".
				"send_watchmail		= '".quote($this->dblink, isset($_user['options']['send_watchmail']) ? $_user['options']['send_watchmail'] : '')."', ".
				"show_files			= '".quote($this->dblink, isset($_user['options']['show_files']) ? $_user['options']['show_files'] : '')."'";

			$this->sql_query($sql);

			// bookmarks
			convert_into_menu_table($this, $_user['bookmarks'], $_user['user_id']);
		}

		echo "<br />".$count." user settings inserted.";
		echo "<br />bookmarks inserted in new menu table.";

		// DROP obsolete fields in user table after successful data migration
		$sql_drop_1 = "ALTER TABLE ".$this->config['table_prefix']."user DROP changes_count";
		$sql_drop_2 = "ALTER TABLE ".$this->config['table_prefix']."user DROP doubleclick_edit";
		$sql_drop_3 = "ALTER TABLE ".$this->config['table_prefix']."user DROP show_comments";
		$sql_drop_4 = "ALTER TABLE ".$this->config['table_prefix']."user DROP bookmarks";
		$sql_drop_5 = "ALTER TABLE ".$this->config['table_prefix']."user DROP lang";
		$sql_drop_6 = "ALTER TABLE ".$this->config['table_prefix']."user DROP show_spaces";
		$sql_drop_7 = "ALTER TABLE ".$this->config['table_prefix']."user DROP typografica";
		$sql_drop_8 = "ALTER TABLE ".$this->config['table_prefix']."user DROP more";
		$sql_drop_9 = "ALTER TABLE ".$this->config['table_prefix']."user DROP motto";
		$sql_drop_10 = "ALTER TABLE ".$this->config['table_prefix']."user DROP revisions_count";

		$this->sql_query($sql_drop_1);
		$this->sql_query($sql_drop_2);
		$this->sql_query($sql_drop_3);
		$this->sql_query($sql_drop_4);
		$this->sql_query($sql_drop_5);
		$this->sql_query($sql_drop_6);
		$this->sql_query($sql_drop_7);
		$this->sql_query($sql_drop_8);
		$this->sql_query($sql_drop_9);
		$this->sql_query($sql_drop_10);

		echo "<br />DROPed obsolete fields in user table after successful data migration.";
	}
}

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

			$this->log(1, 'Synchronized user statistics');

			echo	'<p><em>User Statistics synchronized.</em></p><br />';

	}
}

########################################################
##            Move user pages into user name space    ##
########################################################

if ($this->is_admin())
{
	if (!function_exists('recursive_move'))
	{
		function recursive_move(&$parent, $root, $new_root)
		{
			#$new_root = trim($_POST['newname'], '/');

			if($root == '/')
			{
				exit; // who and where did intend to move root???
			}

			// FIXME: missing $owner_id
			if (!isset($owner_id)) $owner_id = '';

			$query = "'".quote($parent->dblink, $parent->translit($root))."%'";
			$pages = $parent->load_all(
				"SELECT page_id, tag, supertag ".
				"FROM ".$parent->config['table_prefix']."page ".
				"WHERE supertag LIKE ".$query.
				($owner_id
					? " AND owner_id ='".quote($parent->dblink, $owner_id)."'"
					: "").
				" AND comment_on_id = '0'");

			echo "<ol>";

			foreach( $pages as $page )
			{
				echo "<li><b>".$page['tag']."</b>\n";

				// $new_name = str_replace( $root, $new_root, $page['tag'] );
				$new_name = preg_replace('/'.preg_quote($root, '/').'/', preg_quote($new_root), $page['tag'], 1);
				move( $parent, $page, $new_name );

				echo "</li>\n";
			}

			echo "</ol>\n";
		}
	}

	if (!function_exists('move'))
	{
		function move(&$parent, $old_page, $new_name )
		{
			$supernewname = $parent->translit($new_name);

			echo "<ul>";

			if (!preg_match('/^([\_\.\-'.$parent->language['ALPHANUM_P'].']+)$/', $new_name))
			{
				echo "<li>".$parent->get_translation('BadName')."</li>\n";
			}
			//     if ($old_page['supertag'] == $supernewname)
			else if ($old_page['tag'] == $new_name)
			{
				echo "<li>".str_replace('%1', $parent->link($new_name), $parent->get_translation('AlreadyNamed'))."</li>\n";
			}
			else
			{
				if ($old_page['supertag'] != $supernewname && $page=$parent->load_page($supernewname, 0, '', LOAD_CACHE, LOAD_META))
				{
					echo "<li>".str_replace('%1', $parent->link($new_name), $parent->get_translation('AlredyExists'))."</li>\n";
				}
				else
				{
					// Rename page
					$need_redirect = 0;

					if (isset($_POST['redirect']) && $_POST['redirect'] == 'on')
					{
						$need_redirect = 1;
					}

					if ($need_redirect == 0)
					{
						if ($parent->remove_referrers($old_page['tag']))
						{
							echo "<li>".str_replace('%1', $old_page['tag'], $parent->get_translation('ReferrersRemoved'))."</li>\n";
						}

						if ($parent->rename_page($old_page['tag'], $new_name, $supernewname))
						{
							echo "<li>".str_replace('%1', $old_page['tag'], $parent->get_translation('PageRenamed'))."</li>\n";
						}

						$parent->clear_cache_wanted_page($new_name);
						$parent->clear_cache_wanted_page($supernewname);
					}
					if ($need_redirect == 1)
					{
						$parent->cache_wanted_page($old_page['tag']);
						$parent->cache_wanted_page($old_page['supertag']);

						if ($parent->save_page($old_page['tag'], '', '{{redirect page="/'.$new_name.'"}}'))
						{
							echo "<li>".str_replace('%1', $old_page['tag'], $parent->get_translation('RedirectCreated'))."</li>\n";
						}

						$parent->clear_cache_wanted_page($old_page['tag']);
						$parent->clear_cache_wanted_page($old_page['supertag']);
					}

					echo "<li>".$parent->get_translation('NewNameOfPage').$parent->link('/'.$new_name)."</li>\n";

					// log event
					$parent->log(3, str_replace('%2', $new_name, str_replace('%1', $old_page['tag'], $parent->get_translation('LogRenamedPage', $parent->config['language']))).( $need_redirect == 1 ? $parent->get_translation('LogRenamedPage2', $parent->config['language']) : '' ));
				}
			}

			echo "</ul>";
		}
	}

	echo "<h4>5. Moves users pages into user name space: ".$this->config['users_page'].'/'."</h4>";

	if (!isset($_POST['userspace']))
	{
		echo $this->form_open();
		?>
		<input type="submit" name="userspace"  value="<?php echo $this->get_translation('CategoriesSaveButton');?>" />
		<?php
		echo $this->form_close();
	}
	// rename files in \files\perpage folder to @page_id@file_name
	else if (isset($_POST['userspace']))
	{
		$pages = $this->load_all(
			"SELECT p.tag ".
			"FROM {$this->config['table_prefix']}page p ".
			"INNER JOIN ".$this->config['table_prefix']."user u ON (u.user_id = p.owner_id) ".
			"WHERE p.tag = u.user_name");

		$namespace = $this->config['users_page'].'/';


		foreach ($pages as $page)
		{

			// rename from /UserName to /Users/UserName
			recursive_move($this, $page['tag'], $namespace.$page['tag']);
		}

		echo "<br />Moved user pages into user name space";
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
		<input type="submit" name="set_version_id"  value="<?php echo $this->get_translation('CategoriesSaveButton');?>" />
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

# postponed -> R4.5

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

					$this->sql_query($sql);
				}
			}
		}

		echo '<br />'.$old_acl_count.' acl and '.$privilege_count.' privilege settings inserted.';
	}
}*/

?>