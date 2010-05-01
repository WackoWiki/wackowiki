<?php

// status: alpha - just hacked together
//
// for testing and improvement - thought for upgrade routine of the installer

echo "Renames files in \\files\perpage folder to @page_id@filename:<br /><br />";
if ($this->IsAdmin())
{
	if (!isset($_POST["rename"]))
	{
		echo $this->FormOpen();
		?>
		<input
		type="submit" name="rename"
		value="<?php echo $this->GetTranslation("RenameButton");?>" />
		<?php
		echo $this->FormClose();
	}
	// rename files in \files\perpage folder to @page_id@filename
	else
	{
		@set_time_limit(0);

		$files = $this->LoadAll(
			"SELECT u.page_id, filename, supertag ".
			"FROM {$this->config['table_prefix']}upload u ".
			"INNER JOIN ".$this->config["table_prefix"]."pages p ON (u.page_id = p.page_id) ".
			"WHERE u.page_id != '0'");

		$dir = $this->config["upload_path_per_page"]."/";
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
					if($file != "." && $file != "..")
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

echo "<b>Migrates user otions to users_settings table</b>:<br /><br />";
if ($this->IsAdmin())
{
	if (!isset($_POST["migrate_user_otions"]))
	{
		echo $this->FormOpen();
		?>
		<input
		type="submit" name="migrate_user_otions"
		value="<?php echo $this->GetTranslation("RenameButton");?>" />
		<?php
		echo $this->FormClose();
	}
	// rename files in \files\perpage folder to @page_id@filename
	else
	{
		$_users = $this->LoadAll(
			"SELECT user_id, doubleclick_edit, show_comments, bookmarks, motto, revisions_count, changes_count, lang, show_spaces, typografica, more ".
			"FROM {$this->config['table_prefix']}users ");

		$count = count($_users);

		foreach ($_users as $_user)
		{
			$_user['options'] = $this->DecomposeOptions($_user["more"]);
			// user_id, doubleclick_edit, show_comments, bookmarks, motto, revisions_count, changes_count, lang, show_spaces, typografica
			// $_user['options'] : theme, autocomplete, dont_redirect, send_watchmail, show_files, allow_intercom, hide_lastsession, validate_ip, noid_pubs

			$sql =	"INSERT INTO {$this->config['table_prefix']}users_settings
					(user_id, doubleclick_edit, show_comments, bookmarks, motto, revisions_count, changes_count, lang, show_spaces, typografica, theme, autocomplete, dont_redirect, send_watchmail, show_files, allow_intercom, hide_lastsession, validate_ip, noid_pubs)
					VALUES ('{$_user['user_id']}', '{$_user['doubleclick_edit']}', '{$_user['show_comments']}', '{$_user['bookmarks']}', '{$_user['motto']}', '{$_user['revisions_count']}', '{$_user['changes_count']}', '{$_user['lang']}', '{$_user['show_spaces']}', '{$_user['typografica']}', '{$_user['options']['theme']}', '{$_user['options']['autocomplete']}', '{$_user['options']['dont_redirect']}', '{$_user['options']['send_watchmail']}', '{$_user['options']['show_files']}', '{$_user['options']['allow_intercom']}', '{$_user['options']['hide_lastsession']}', '{$_user['options']['validate_ip']}', '{$_user['options']['noid_pubs']}')";
			$this->Query($sql);
		}

		echo "<br />".$count." user settings inserted.";
	}
}

?>