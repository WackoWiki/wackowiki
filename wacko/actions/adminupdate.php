<?php

// status: alpha - just hacked together
//
// for testing and improvement - thought for upgrade routine of the installer
echo "<h2>Upgrade Utilities -> Migration Routines for R4.3.rc1 to R4.4.rc1 Upgrade</h2>";

if ($this->is_admin())
{
	if (!isset($_POST['rename']))
	{
		echo "<h3>1. Renames files in \\files\perpage folder to @page_id@filename:</h3>";

		echo $this->form_open();
		?>
		<input
		type="submit" name="rename"
		value="<?php echo $this->get_translation('KeywordsSaveButton');?>" />
		<?php
		echo $this->form_close();
	}
	// rename files in \files\perpage folder to @page_id@filename
	else if (isset($_POST['rename']))
	{
		@set_time_limit(0);

		$files = $this->load_all(
			"SELECT u.page_id, filename, supertag ".
			"FROM {$this->config['table_prefix']}upload u ".
			"INNER JOIN ".$this->config['table_prefix']."page p ON (u.page_id = p.page_id) ".
			"WHERE u.page_id != '0'");

		$dir = $this->config['upload_path_per_page']."/";
		echo "<table><th>old name</th><th></th><th>new name</th>";

		foreach ($files as $file)
		{
			// rename from @PageSupertag@SubPage@filename to @page_id@filename
			$old_name = '@'.str_replace('/', '@', $file['supertag']).'@';
			$new_name = '@'.$file['page_id'].'@';
			$file_name = $file['filename'];

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

// Migrate User settings
if (!function_exists('DecomposeOptions'))
{
	function DecomposeOptions($more)
	{
		$optionSplitter			= "\n";		// if you change this two symbols, settings for all users will be lost.
		$valueSplitter			= "=";

		$b		= array();
		$opts	= explode($optionSplitter, $more);

		foreach ($opts as $o)
		{
			$params			= explode($valueSplitter, trim($o));
			$b[$params[0]]	= (isset($params[1]) ? $params[1] : NULL) ;
		}
		return $b;
	}
}


if ($this->is_admin())
{
	if (!isset($_POST['migrate_user_otions']))
	{
		echo "<h3>2. Migrates user otions to user_setting table:</h3>";
		echo $this->form_open();
		?>
		<input
		type="submit" name="migrate_user_otions"
		value="<?php echo $this->get_translation('KeywordsSaveButton');?>" />
		<?php
		echo $this->form_close();
	}
	// rename files in \files\perpage folder to @page_id@filename
	else if (isset($_POST['migrate_user_otions']))
	{
		$_users = $this->load_all(
			"SELECT user_id, doubleclick_edit, show_comments, bookmarks, motto, revisions_count, changes_count, lang, show_spaces, typografica, more ".
			"FROM {$this->config['table_prefix']}user ");

		$count = count($_users);

		foreach ($_users as $_user)
		{
			$_user['options'] = $this->DecomposeOptions($_user['more']);
			// user_id, doubleclick_edit, show_comments, bookmarks, motto, revisions_count, changes_count, lang, show_spaces, typografica
			// $_user['options'] : theme, autocomplete, dont_redirect, send_watchmail, show_files, allow_intercom, hide_lastsession, validate_ip, noid_pubs

			$sql =	"INSERT INTO {$this->config['table_prefix']}user_setting
					(user_id, doubleclick_edit, show_comments, motto, revisions_count, changes_count, lang, show_spaces, typografica, theme, autocomplete, dont_redirect, send_watchmail, show_files, allow_intercom, hide_lastsession, validate_ip, noid_pubs)
					VALUES ('{$_user['user_id']}', '{$_user['doubleclick_edit']}', '{$_user['show_comments']}', '{$_user['motto']}', '{$_user['revisions_count']}', '{$_user['changes_count']}', '{$_user['lang']}', '{$_user['show_spaces']}', '{$_user['typografica']}', '{$_user['options']['theme']}', '{$_user['options']['autocomplete']}', '{$_user['options']['dont_redirect']}', '{$_user['options']['send_watchmail']}', '{$_user['options']['show_files']}', '{$_user['options']['allow_intercom']}', '{$_user['options']['hide_lastsession']}', '{$_user['options']['validate_ip']}', '{$_user['options']['noid_pubs']}')";
			$this->query($sql);

			// Bookmarks
			$this->convert_into_bookmark_table($_user['bookmarks'], $_user['user_id']);
		}

		echo "<br />".$count." user settings inserted.";
	}
}

?>