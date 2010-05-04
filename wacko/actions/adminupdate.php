<?php

// status: alpha - just hacked together
//
// for testing and improvement - thought for upgrade routine of the installer

echo "<h2>Migration Routines for R4.3.rc1 to rc2 Upgrade</h2>";

echo "<h3>1. Renames files in \\files\perpage folder to @page_id@filename:</h3>";
if ($this->IsAdmin())
{
	if (!isset($_POST["rename"]))
	{
		echo $this->FormOpen();
		?>
		<input
		type="submit" name="rename"
		value="<?php echo $this->GetTranslation("KeywordsSaveButton");?>" />
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

echo "<h3>2. Migrates user otions to users_settings table:</h3>";
if ($this->IsAdmin())
{
	if (!isset($_POST["migrate_user_otions"]))
	{
		echo $this->FormOpen();
		?>
		<input
		type="submit" name="migrate_user_otions"
		value="<?php echo $this->GetTranslation("KeywordsSaveButton");?>" />
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
					(user_id, doubleclick_edit, show_comments, motto, revisions_count, changes_count, lang, show_spaces, typografica, theme, autocomplete, dont_redirect, send_watchmail, show_files, allow_intercom, hide_lastsession, validate_ip, noid_pubs)
					VALUES ('{$_user['user_id']}', '{$_user['doubleclick_edit']}', '{$_user['show_comments']}', '{$_user['motto']}', '{$_user['revisions_count']}', '{$_user['changes_count']}', '{$_user['lang']}', '{$_user['show_spaces']}', '{$_user['typografica']}', '{$_user['options']['theme']}', '{$_user['options']['autocomplete']}', '{$_user['options']['dont_redirect']}', '{$_user['options']['send_watchmail']}', '{$_user['options']['show_files']}', '{$_user['options']['allow_intercom']}', '{$_user['options']['hide_lastsession']}', '{$_user['options']['validate_ip']}', '{$_user['options']['noid_pubs']}')";
			$this->Query($sql);

			// Bookmarks
			$_bookmarks	= explode("\n", $_user['bookmarks']);

			if ($_bookmarks)
			{
				foreach($_bookmarks as $key => $_bookmark)
				{
					// links ((link desc @@lang))
					$_bookmark = str_replace(array("((/", "((", "))", "[[/", "[[", "]]"), "", $_bookmark);
					$_bookmark = str_replace(" @@", "@@", $_bookmark);

					if (preg_match("/([^\n]+)[\s]{1}([^\n]*)[\s]{1}@@([^\n]*)$/", $_bookmark, $matches))
					{
						list (, $url, $text) = $matches;
						if ($url)
						{
							if (stristr($text, "@@"))
							{
								$t = explode("@@", $text);
								$text = $t[0];
								$lang = $t[1];
							}

							$title = trim(preg_replace("/|__|\[\[|\(\(/","",$text));
							$page_id = $this->GetPageId($url);
							$page_title = $this->GetPageTitle("", $page_id);

							if ( $page_title !== $title )
							{
								$title = $title;
							}
							else
							{
								$title = NULL;
							}
						}
					}
					if (isset($page_id))
					{
						$this->Query(
							"INSERT INTO ".$this->config["table_prefix"]."bookmarks SET ".
							"user_id		= '".quote($this->dblink, $_user["user_id"])."', ".
							"page_id		= '".quote($this->dblink, $page_id)."', ".
							"lang			= '".quote($this->dblink, $lang)."', ".
							"bm_title		= '".quote($this->dblink, $title)."', ".
							"bm_sorting		= '".quote($this->dblink, $key)."' ");
					}
				}
			}

		}

		echo "<br />".$count." user settings inserted.";
	}
}

echo "<h3>2.1 Migrates user bookmarks to bookmarks table [! users_options -> bookmarks][temp for dev branch!]:</h3>";
if ($this->IsAdmin())
{
	if (!isset($_POST["migrate_bookmarks"]))
	{
		echo $this->FormOpen();
		?>
		<input
		type="submit" name="migrate_bookmarks"
		value="<?php echo $this->GetTranslation("KeywordsSaveButton");?>" />
		<?php
		echo $this->FormClose();
	}
	// rename files in \files\perpage folder to @page_id@filename
	else
	{
		$_users = $this->LoadAll(
			"SELECT user_id, bookmarks ".
			"FROM {$this->config['table_prefix']}users_settings ");

		$count = count($_users);

		foreach ($_users as $_user)
		{
			// Bookmarks
			$_bookmarks	= explode("\n", $_user['bookmarks']);

			if ($_bookmarks)
			{
				foreach($_bookmarks as $key => $_bookmark)
				{
					// links ((link desc @@lang))
					$_bookmark = str_replace(array("((/", "((", "))", "[[/", "[[", "]]"), "", $_bookmark);
					$_bookmark = str_replace(" @@", "@@", $_bookmark);

					if (preg_match("/([^\n]+)[\s]{1}([^\n]*)[\s]{1}@@([^\n]*)$/", $_bookmark, $matches))
					{
						list (, $url, $text) = $matches;
						if ($url)
						{
							if (stristr($text, "@@"))
							{
								$t = explode("@@", $text);
								$text = $t[0];
								$lang = $t[1];
							}

							$title = trim(preg_replace("/|__|\[\[|\(\(/","",$text));
							$page_id = $this->GetPageId($url);
							$page_title = $this->GetPageTitle("", $page_id);

							if ( $page_title !== $title )
							{
								$title = $title;
							}
							else
							{
								$title = NULL;
							}
						}
					}
					if (isset($page_id))
					{
						$this->Query(
							"INSERT INTO ".$this->config["table_prefix"]."bookmarks SET ".
							"user_id		= '".quote($this->dblink, $_user["user_id"])."', ".
							"page_id		= '".quote($this->dblink, $page_id)."', ".
							"lang			= '".quote($this->dblink, $lang)."', ".
							"bm_title		= '".quote($this->dblink, $title)."', ".
							"bm_sorting		= '".quote($this->dblink, $key)."' ");
					}
				}
			}

		}

		echo "<br />bookmarks for ".$count." user inserted in bookmarks table.";
	}
}

?>