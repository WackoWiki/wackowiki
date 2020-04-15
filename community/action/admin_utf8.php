<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
## WackoWiki UTF-8 Conversion Routines					##
##########################################################
/*
 * status: stable
 * https://wackowiki.org/doc/Dev/Release/R6.0/Upgrade/DatabaseConversion
 * modify the script for your needs, please conribute your improvements
 *
 * place the script under action/admin_utf8.php
 * call the action via {{admin_utf8}} as Administrator
 *
 * 1. Pre-Upgrade Routines for R6.x
 *    1.0. Alter tables to work without key prefixes longer than 767 bytes
 *    1.1. Convert all tables based on charset to utf8mb4
 *    1.2. Convert all cross charset records
 * 2. Post-Upgrade Routines for R6.x
 *    2.1. Reset upsized TEXT columns back to TEXT or MEDIUMTEXT
 *    2.2. Convert HTML entities to their corresponding Unicode characters
 *    2.3. Remove column 'converted' from tables
 */

/* TODO:
 * set progress in config
 * add check to analyzed the database prior to show the suggested actions
 * currently it uses only the Mysqli API to update the cross charset records
 */

$prefix			= $this->db->table_prefix;
$charset		= 'utf8mb4';
$collation		= 'utf8mb4_unicode_520_ci';		// Unicode (UCA 5.2.0), case-insensitive, https://dev.mysql.com/doc/refman/8.0/en/charset-collation-names.html

// get MariaDB / MySQL version
$_db_version	= $this->db->load_single("SELECT version()");
$db_version		= $_db_version['version()'];
$large_prefix	= false;

echo '<h1>Unicode conversion utilities</h1>';

$info[] = ['WackoWiki version', $this->format('**!!(green)' . $this->db->wacko_version . '!!**', 'wacko')];
$info[] = ['MariaDB / MySQL version', $db_version];
$info[] = ['Database charset', $this->db->database_charset];
$info[] = ['Database collation', $this->db->database_collation];

echo '<table style="max-width:800px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation lined">' . "\n";

foreach ($info as $value)
{
	echo '<tr>' .
			'<td class="label"><strong>' . $value[0] . '</strong></td>' .
			'<td> </td>' .
			'<td>' . $value[1] . '</td>' . "\n";
}

echo '</table>' . "\n";

echo '<h2>1. Pre-Upgrade Routines for R6.x</h2>';

if ($this->is_admin())
{
	// MySQL versions prior to 5.7.7 or MariaDB 10.2.2 do not support index key prefixes up to 3072 bytes by default.
	$min_db_version = preg_match('/MariaDB/', $db_version, $matches)
		? '10.2.2'
		: '5.7.7';

	if (version_compare($db_version, $min_db_version , '>='))
	{
		$large_prefix = true;
	}

	if (! $large_prefix)
	{
		echo '<h3>1.0. Alter tables to work without key prefixes longer than 767 bytes:</h3>';

		if (!isset($_POST['set_large_prefix_tables']))
		{
			echo $this->form_open('large_prefix');
			echo '<input type="submit" name="set_large_prefix_tables" value="' . $this->_t('UpdateButton') . '">';
			echo $this->form_close();
		}
		else if (isset($_POST['set_large_prefix_tables']))
		{
			$results =
				'<strong>' . date('H:i:s') . ' - ' . 'Alter tables started' . "\n" .
				'================================================</strong>' . "\n";

			$results .=
				'<strong>' . 'VARCHAR(191): ' . "\n" .
				'Tables:  file, page, page_link and revision:</strong>' . "\n\n";

			$this->db->sql_query("
				ALTER TABLE {$prefix}file
					CHANGE file_name file_name VARCHAR(191) COLLATE {$collation} NOT NULL DEFAULT '';");

			$this->db->sql_query("
				ALTER TABLE {$prefix}page
					CHANGE title title VARCHAR(191) COLLATE {$collation} NOT NULL DEFAULT '',
					CHANGE tag tag VARCHAR(191) COLLATE {$collation} NOT NULL DEFAULT '';");

			$this->db->sql_query("
				ALTER TABLE {$prefix}page_link
					CHANGE to_tag to_tag VARCHAR(191) COLLATE {$collation} NOT NULL DEFAULT '';");

			$this->db->sql_query("
				ALTER TABLE {$prefix}revision
					CHANGE title title VARCHAR(191) COLLATE {$collation} NOT NULL DEFAULT '',
					CHANGE tag tag VARCHAR(191) COLLATE {$collation} NOT NULL DEFAULT '';");

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
	##	Convert charset for tables						  ##
	########################################################

	echo '<h3>1.1. Convert database and tables based on charset to ' . $charset . ':</h3>';

	if (!isset($_POST['set_charset_tables']))
	{
		echo $this->form_open('charset_tables');
		echo '<input type="submit" name="set_charset_tables" value="' . $this->_t('UpdateButton') . '">';
		echo $this->form_close();
	}
	else if (isset($_POST['set_charset_tables']))
	{
		$tables = [
			'acl',
			'auth_token',
			'cache',
			'category',
			'category_assignment',
			'config',
			'external_link',
			'file',
			'file_link',
			'log',
			'menu',
			'page',
			'page_link',
			'poll',
			'rating',
			'referrer',
			'revision',
			'user',
			'usergroup',
			'usergroup_member',
			'user_setting',
			'watch',
			'word',
		];

		$results =
			'<strong>' . date('H:i:s') . ' - ' . 'Table conversion started' . "\n" .
			'================================================</strong>' . "\n";

		$results .=
			'<strong>' . 'Charset: ' . $charset . "\n" .
			'Collation: ' . ' ' . $collation . ':</strong>' . "\n\n";

		// Database
		$this->db->sql_query("ALTER DATABASE {$this->db->database_database} CHARACTER SET = {$charset} COLLATE = '{$collation}';");

		// Tables
		foreach ($tables as $table)
		{
			$this->db->sql_query("ALTER TABLE " . $prefix . $table . " DEFAULT CHARACTER SET {$charset} COLLATE {$collation};");
			$this->db->sql_query("ALTER TABLE " . $prefix . $table . " CONVERT TO CHARACTER SET {$charset} COLLATE {$collation};");
			// B: convert records in a different charset -> see next routine
			// C: HTML entities  -> see post upgrade routine
			// TODO: convert mojibake
			// TODO: deal with old supertag links

			$results .=
				"\t" . '<strong>' . date('H:i:s') . ' - ' . $table."\n" .
				"\t" . '------------------------------------------------</strong>' . "\n";
		}

		$results .=
			'<strong>' . date('H:i:s') . ' - ' . 'Tables converted.' . "\n" .
			'================================================</strong>' . "\n";

		echo
			'<div class="code">' .
				'<pre>' . $results . '</pre>' .
			'</div><br>';
	}

	########################################################
	##	Convert strings of cross charset records          ##
	########################################################

	if ($this->db->database_charset != 'utf8mb4')
	{
		echo '<h3>1.2. Convert all cross charset records</h3>';

		if (!isset($_POST['set_charset_record']))
		{
			echo $this->form_open('charset_records');
			echo '<input type="submit" name="set_charset_record" value="' . $this->_t('UpdateButton') . '">';
			echo $this->form_close();
		}
		else if (isset($_POST['set_charset_record']))
		{
			# set_time_limit(3600);

			// iso-8859-1 -> windows-1252
			$_charset	= [
				'bg'	=> 'windows-1251',
				'da'	=> 'windows-1252',
				'de'	=> 'windows-1252',
				'el'	=> 'iso-8859-7',
				'en'	=> 'windows-1252',
				'es'	=> 'windows-1252',
				'et'	=> 'windows-1257',
				'fr'	=> 'windows-1252',
				'hu'	=> 'iso-8859-2',
				'it'	=> 'windows-1252',
				'nl'	=> 'windows-1252',
				'pl'	=> 'iso-8859-2',
				'pt'	=> 'windows-1252',
				'ru'	=> 'windows-1251',
			];

			// selects the subset of languages to convert according your 'database_charset'
			if ($this->db->database_charset == 'latin1')		// Latin1	(iso-8859-1)
			{
				$_lang_set = "'bg', 'el', 'et', 'hu', 'pl', 'ru'";
			}
			else if ($this->db->database_charset == 'latin2')	// Latin2	(iso-8859-2)
			{
				$_lang_set = "'bg', 'da', 'de', 'el', 'en', 'es', 'et', 'fr', 'it', 'nl', 'pt', 'ru'";
			}
			else if ($this->db->database_charset == 'cp1251')	// Kyrillic	(windows-1251)
			{
				$_lang_set = "'da', 'de', 'el', 'en', 'es', 'et', 'fr', 'hu', 'it', 'nl', 'pl', 'pt'";
			}
			else if ($this->db->database_charset == 'cp1257')	// Baltic	(windows-1257)
			{
				$_lang_set = "'bg', 'da', 'de', 'el', 'en', 'es', 'fr', 'hu', 'it', 'nl', 'pl', 'pt', 'ru'";
			}
			else if ($this->db->database_charset == 'greek')	// Greek	(iso-8859-7)
			{
				$_lang_set = "'bg', 'da', 'de', 'en', 'es', 'et', 'fr', 'hu', 'it', 'nl', 'pl', 'pt', 'ru'";
			}

			/* Tables: sets value 1 in converted record to avoid double conversion
			 *		1 - utf8
			 *		2 - HTML entities
			 *		3 - mojibake
			 */
			$tables = [
				'category',
				'file',
				'menu',
				'page',
				'revision',
				'user',
				'usergroup',
			];

			// add field 'converted'
			foreach ($tables as $table)
			{
				$this->db->sql_query("ALTER TABLE " . $prefix . $table . " ADD converted TINYINT(1) UNSIGNED NOT NULL DEFAULT '0';");
			}

			#########################################################################################################################
			// DATABASE utf8mb4 link
			$sql_modes	= !empty($this->db->sql_mode_strict) ? SQL_MODE_STRICT : SQL_MODE_PERMISSIVE;
			$dblink		= mysqli_connect($this->db->database_host, $this->db->database_user, $this->db->database_password, null, $this->db->database_port);

			mysqli_select_db($dblink, $this->db->database_database);
			mysqli_set_charset($dblink, $charset);
			mysqli_query($dblink, "SET SESSION sql_mode='$sql_modes'");

			#########################################################################################################################

			$results =
				'<strong>' . date('H:i:s') . ' - ' . 'Tables record conversion started ' . "\n" .
				'================================================</strong>' . "\n";

			## 1 .CATEGORIES ##

			if ($categories = $this->db->load_all(
				"SELECT category_id, category, category_description, category_lang " .
				"FROM {$prefix}category " .
				"WHERE " .
					"category_lang IN (" . $_lang_set . ") " .
					"AND converted <> 1 ")
			)
			{
				$total = 0;
				$results .=
					"\t" . '<strong>' . date('H:i:s') . ' - ' . 'category' . "\n" .
					"\t" . '------------------------------------------------</strong>' . "\n";

				foreach($categories as $category)
				{
					$category_name			= iconv($_charset[$category['category_lang']], 'UTF-8', $category['category']);
					$category_description	= iconv($_charset[$category['category_lang']], 'UTF-8', $category['category_description']);

					#echo $category_name . '<br>';

					// update catagory
					mysqli_query($dblink,
						"UPDATE {$prefix}category SET " .
							"category				= " . $this->db->q($category_name) . ", " .
							"category_description	= " . $this->db->q($category_description) . ", " .
							"converted				= 1 " .
						"WHERE category_id = " . (int) $category['category_id'] . " " .
						"LIMIT 1");

					# echo mysqli_error($dblink) . '<br>';
					$total++;
				}

				$results .= "\t" . '<strong>' . date('H:i:s') . ' - ' . 'Records converted' . ': ' . $total . '</strong>' . "\n\n\n";
			}

			## 2. FILES ##

			if ($files = $this->db->load_all(
				"SELECT file_id, file_name, file_description, caption, file_lang " .
				"FROM {$prefix}file " .
				"WHERE " .
					"file_lang IN (" . $_lang_set . ") " .
					"AND converted <> 1 ")
			)
			{
				$total = 0;
				$results .=
					"\t" . '<strong>' . date('H:i:s') . ' - ' . 'file' . "\n" .
					"\t" . '------------------------------------------------</strong>' . "\n";

				foreach($files as $file)
				{
					$file_description	= iconv($_charset[$file['file_lang']], 'UTF-8', $file['file_description']);
					$caption			= iconv($_charset[$file['file_lang']], 'UTF-8', $file['caption']);

					# echo $file['file_name'] . '<br>';

					// update file meta data
					mysqli_query($dblink,
						"UPDATE {$prefix}file SET " .
							"file_description	= " . $this->db->q($file_description) . ", " .
							"caption			= " . $this->db->q($caption) . ", " .
							"converted			= 1 " .
						"WHERE file_id = " . (int) $file['file_id'] . " " .
						"LIMIT 1");

					# echo mysqli_error($dblink) . '<br>';
					$total++;
				}

				$results .= "\t" . '<strong>' . date('H:i:s') . ' - ' . 'Records converted' . ': ' . $total . '</strong>' . "\n\n\n";
			}

			## 3. MENU ##

			if ($items = $this->db->load_all(
				"SELECT menu_id, menu_title, menu_lang " .
				"FROM {$prefix}menu " .
				"WHERE " .
					"menu_lang IN (" . $_lang_set . ") " .
					"AND converted <> 1 ")
			)
			{
				$total = 0;
				$results .=
					"\t" . '<strong>' . date('H:i:s') . ' - ' . 'menu' . "\n" .
					"\t" . '------------------------------------------------</strong>' . "\n";

				foreach($items as $item)
				{
					$menu_title	= iconv($_charset[$item['menu_lang']], 'UTF-8', $item['menu_title']);

					# echo $menu_title . '<br>';

					// update menu title
					mysqli_query($dblink,
						"UPDATE {$prefix}menu SET " .
							"menu_title	= " . $this->db->q($menu_title) . ", " .
							"converted			= 1 " .
						"WHERE menu_id = " . (int) $item['menu_id'] . " " .
						"LIMIT 1");

					# echo mysqli_error($dblink) . '<br>';
					$total++;
				}

				$results .= "\t" . '<strong>' . date('H:i:s') . ' - ' . 'Records converted' . ': ' . $total . '</strong>' . "\n\n\n";
			}

			## 4. PAGES ##

			if ($pages = $this->db->load_all(
				"SELECT page_id, tag, title, body, edit_note, description, keywords, page_lang " .
				"FROM {$prefix}page " .
				"WHERE " .
					"page_lang IN (" . $_lang_set . ") " .
					"AND converted <> 1 ")
			)
			{
				$total = 0;
				$results .=
					"\t" . '<strong>' . date('H:i:s') . ' - ' . 'page' . "\n" .
					"\t" . '------------------------------------------------</strong>' . "\n";

				foreach($pages as $page)
				{
					$tag			= iconv($_charset[$page['page_lang']], 'UTF-8', $page['tag']);
					$title			= iconv($_charset[$page['page_lang']], 'UTF-8', $page['title']);
					$body			= iconv($_charset[$page['page_lang']], 'UTF-8', $page['body']);
					$edit_note		= iconv($_charset[$page['page_lang']], 'UTF-8', $page['edit_note']);
					$description	= iconv($_charset[$page['page_lang']], 'UTF-8', $page['description']);
					$keywords		= iconv($_charset[$page['page_lang']], 'UTF-8', $page['keywords']);

					# echo $tag . '<br>';

					// update current page copy
					mysqli_query($dblink,
						"UPDATE {$prefix}page SET " .
							"tag			= " . $this->db->q($tag) . ", " .
							"title			= " . $this->db->q($title) . ", " .
							"body			= " . $this->db->q($body) . ", " .
							"edit_note		= " . $this->db->q($edit_note) . ", " .
							"description	= " . $this->db->q($description) . ", " .
							"keywords		= " . $this->db->q($keywords) . ", " .
							"converted		= 1 " .
						"WHERE page_id = " . (int) $page['page_id'] . " " .
						"LIMIT 1");

					# echo mysqli_error($dblink) . '<br>';
					$total++;
				}

				$results .= "\t" . '<strong>' . date('H:i:s') . ' - ' . 'Records converted' . ': ' . $total . '</strong>' . "\n\n\n";
			}

			## 5. REVISIONS ##

			if ($revisions = $this->db->load_all(
				"SELECT revision_id, tag, title, body, edit_note, description, keywords, page_lang " .
				"FROM {$prefix}revision " .
				"WHERE " .
					"page_lang IN (" . $_lang_set . ") " .
					"AND converted <> 1 ")
			)
			{
				$total = 0;
				$results .=
					"\t" . '<strong>' . date('H:i:s') . ' - ' . 'revision' . "\n" .
					"\t" . '------------------------------------------------</strong>' . "\n";

				foreach($revisions as $revision)
				{
					$tag			= iconv($_charset[$revision['page_lang']], 'UTF-8', $revision['tag']);
					$title			= iconv($_charset[$revision['page_lang']], 'UTF-8', $revision['title']);
					$body			= iconv($_charset[$revision['page_lang']], 'UTF-8', $revision['body']);
					$edit_note		= iconv($_charset[$revision['page_lang']], 'UTF-8', $revision['edit_note']);
					$description	= iconv($_charset[$revision['page_lang']], 'UTF-8', $revision['description']);
					$keywords		= iconv($_charset[$revision['page_lang']], 'UTF-8', $revision['keywords']);

					# echo $revision['revision_id'] . ': ' . $tag . '<br>';

					// update revision
					mysqli_query($dblink,
						"UPDATE {$prefix}revision SET " .
							"tag			= " . $this->db->q($tag) . ", " .
							"title			= " . $this->db->q($title) . ", " .
							"body			= " . $this->db->q($body) . ", " .
							"edit_note		= " . $this->db->q($edit_note) . ", " .
							"description	= " . $this->db->q($description) . ", " .
							"keywords		= " . $this->db->q($keywords) . ", " .
							"converted		= 1 " .
						"WHERE revision_id = " . (int) $revision['revision_id'] . " " .
						"LIMIT 1");

					# echo mysqli_error($dblink) . '<br>';
					$total++;
				}

				$results .= "\t" . '<strong>' . date('H:i:s') . ' - ' . 'Records converted' . ': ' . $total . '</strong>' . "\n\n\n";
			}

			## 6. USERS ##

			if ($users = $this->db->load_all(
				"SELECT user_id, user_name, real_name, account_lang " .
				"FROM {$prefix}user " .
				"WHERE " .
					"account_lang IN (" . $_lang_set . ") " .
					"AND converted <> 1 ")
			)
			{
				$total = 0;
				$results .=
					"\t" . '<strong>' . date('H:i:s') . ' - ' . 'user' . "\n" .
					"\t" . '------------------------------------------------</strong>' . "\n";

				foreach($users as $user)
				{
					$user_name	= iconv($_charset[$user['account_lang']], 'UTF-8', $user['user_name']);
					$real_name	= iconv($_charset[$user['account_lang']], 'UTF-8', $user['real_name']);

					# echo $user_name . '<br>';

					// update user
					mysqli_query($dblink,
						"UPDATE {$prefix}user SET " .
							"user_name	= " . $this->db->q($user_name) . ", " .
							"real_name	= " . $this->db->q($real_name) . ", " .
							"converted	= 1 " .
						"WHERE user_id = " . (int) $user['user_id'] . " " .
						"LIMIT 1");

					# echo mysqli_error($dblink) . '<br>';
					$total++;
				}

				$results .= "\t" . '<strong>' . date('H:i:s') . ' - ' . 'Records converted' . ': ' . $total . '</strong>' . "\n\n\n";
			}

			## 7. USERGROUPS ##

			if ($usergroups = $this->db->load_all(
				"SELECT group_id, group_name, description, group_lang " .
				"FROM {$prefix}usergroup " .
				"WHERE " .
					"group_lang IN (" . $_lang_set . ") " .
					"AND converted <> 1 ")
			)
			{
				$total = 0;
				$results .=
					"\t" . '<strong>' . date('H:i:s') . ' - ' . 'usergroup' . "\n" .
					"\t" . '------------------------------------------------</strong>' . "\n";

				foreach($usergroups as $group)
				{
					$group_name		= iconv($_charset[$group['group_lang']], 'UTF-8', $group['group_name']);
					$description	= iconv($_charset[$group['group_lang']], 'UTF-8', $group['description']);

					# echo $group_name . '<br>';

					// update user group
					mysqli_query($dblink,
						"UPDATE {$prefix}usergroup SET " .
							"group_name		= " . $this->db->q($group_name) . ", " .
							"description	= " . $this->db->q($description) . ", " .
							"converted		= 1 " .
						"WHERE group_id = " . (int) $group['group_id'] . " " .
						"LIMIT 1");

					# echo mysqli_error($dblink) . '<br>';
					$total++;
				}

				$results .= "\t" . '<strong>' . date('H:i:s') . ' - ' . 'Records converted' . ': ' . $total . '</strong>' . "\n\n\n";
			}

			$results .=
				'<strong>' . date('H:i:s') . ' - ' . 'Tables records converted.' . "\n" .
				'================================================</strong>' . "\n";

			echo
				'<div class="code">' .
					'<pre>' . $results . '</pre>' .
				'</div><br>';
		}
	}

	echo '<h2>2. Post-Upgrade Routines for R6.x</h2>';

	echo '<h3>2.1. Reset upsized TEXT columns back to TEXT or MEDIUMTEXT:</h3>';

	if (!isset($_POST['reset_text_column']))
	{
		echo $this->form_open('reset_text');
		echo '<input type="submit" name="reset_text_column" value="' . $this->_t('UpdateButton') . '">';
		echo $this->form_close();
	}
	else if (isset($_POST['reset_text_column']))
	{
		/*
		 * tables having converted to utf8mb4 auto upsized the TEXT columns to avoid unsufficient storage
		 *		TEXT -> MEDIUMTEXT -> LONGTEXT
		 * most of these columns store Latin1 strings and do not require that storage size, set them back to default size
		 *		LONGTEXT -> MEDIUMTEXT -> TEXT
		*/
		$sql = [
			"ALTER TABLE {$prefix}acl CHANGE list list TEXT COLLATE {$collation} NOT NULL AFTER privilege;",
			"ALTER TABLE {$prefix}config CHANGE config_value config_value TEXT COLLATE {$collation} NULL AFTER config_name;",
			"ALTER TABLE {$prefix}external_link CHANGE link link TEXT COLLATE {$collation} NOT NULL AFTER page_id;",
			"ALTER TABLE {$prefix}file CHANGE caption caption TEXT COLLATE {$collation} NOT NULL AFTER file_description;",
			"ALTER TABLE {$prefix}log CHANGE message message TEXT COLLATE {$collation} NOT NULL AFTER ip;",
			"ALTER TABLE {$prefix}page CHANGE body body MEDIUMTEXT COLLATE {$collation} NOT NULL AFTER modified,
				CHANGE body_r body_r MEDIUMTEXT COLLATE {$collation} NOT NULL AFTER body,
				CHANGE body_toc body_toc TEXT COLLATE {$collation} NOT NULL AFTER body_r;",
			"ALTER TABLE {$prefix}referrer CHANGE user_agent user_agent TEXT COLLATE {$collation} NOT NULL AFTER ip;",
			"ALTER TABLE {$prefix}revision CHANGE body body MEDIUMTEXT COLLATE {$collation} NOT NULL AFTER modified,
				CHANGE body_r body_r MEDIUMTEXT COLLATE {$collation} NOT NULL AFTER body;",
		];

		$results =
			'<strong>' . date('H:i:s') . ' - ' . 'Started conversion of TEXT columns' . "\n" .
			'================================================</strong>' . "\n";

		// reset TEXT columns
		foreach ($sql as $query)
		{
			$this->db->sql_query($query);
		}

		$results .=
			'<strong>' . date('H:i:s') . ' - ' . 'Reset converted TEXT columns' . "\n" .
			'================================================</strong>' . "\n";

		echo
			'<div class="code">' .
				'<pre>' . $results . '</pre>' .
			'</div><br>';
	}

	if (version_compare($this->db->wacko_version, '6.0.beta1' , '>='))
	{
		echo '<h3>2.2. Convert HTML entities to their corresponding Unicode characters:</h3>';

		if (!isset($_POST['convert_html_entities']))
		{
			echo $this->form_open('html_entities');
			echo '<input type="submit" name="convert_html_entities" value="' . $this->_t('UpdateButton') . '">';
			echo $this->form_close();
		}
		else if (isset($_POST['convert_html_entities']))
		{
			# set_time_limit(3600);

			$convert_entities = function($input)
			{
				return preg_replace_callback('/(&#[0-9]+;)/', function($m) { return mb_convert_encoding($m[1], 'UTF-8', 'HTML-ENTITIES'); }, $input);
			};

			/* Tables: sets value 1 in converted record to avoid double conversion
			 *		1 - utf8
			 *		2 - HTML entities
			 *		3 - mojibake
			 */
			$tables = [
				'file',
				'page',
				'revision',
			];

			// add field 'converted'
			foreach ($tables as $table)
			{
				$this->db->sql_query("ALTER TABLE " . $prefix . $table . " ADD converted TINYINT(1) UNSIGNED NOT NULL DEFAULT '0';");
			}

			$results =
				'<strong>' . date('H:i:s') . ' - ' . 'Tables record conversion started ' . "\n" .
				'================================================</strong>' . "\n";

			## 1. FILES ##

			if ($files = $this->db->load_all(
				"SELECT file_id, file_name, file_description, caption " .
				"FROM {$prefix}file " .
				"WHERE converted <> 2 ")
			)
			{
				$total = 0;
				$results .=
					"\t" . '<strong>' . date('H:i:s') . ' - ' . 'file' . "\n" .
					"\t" . '------------------------------------------------</strong>' . "\n";

				foreach($files as $file)
				{
					$file_description	= $convert_entities($file['file_description']);
					$caption			= $convert_entities($file['caption']);

					# echo $file['file_name'] . '<br>';

					// update file meta data
					$this->db->sql_query(
						"UPDATE {$prefix}file SET " .
							"file_description	= " . $this->db->q($file_description) . ", " .
							"caption			= " . $this->db->q($caption) . ", " .
							"converted			= 2 " .
						"WHERE file_id = " . (int) $file['file_id'] . " " .
						"LIMIT 1");

					$total++;
				}

				$results .= "\t" . '<strong>' . date('H:i:s') . ' - ' . 'Records converted' . ': ' . $total . '</strong>' . "\n\n\n";
			}

			## 2. PAGES ##

			if ($pages = $this->db->load_all(
				"SELECT page_id, title, body, edit_note, description, keywords " .
				"FROM {$prefix}page " .
				"WHERE converted <> 2 ")
			)
			{
				$total = 0;
				$results .=
					"\t" . '<strong>' . date('H:i:s') . ' - ' . 'page' . "\n" .
					"\t" . '------------------------------------------------</strong>' . "\n";

				foreach($pages as $page)
				{
					$title			= $convert_entities($page['title']);
					$body			= $convert_entities($page['body']);
					$edit_note		= $convert_entities($page['edit_note']);
					$description	= $convert_entities($page['description']);
					$keywords		= $convert_entities($page['keywords']);

					# echo $tag . '<br>';

					// update current page copy
					$this->db->sql_query(
						"UPDATE {$prefix}page SET " .
							"title			= " . $this->db->q($title) . ", " .
							"body			= " . $this->db->q($body) . ", " .
							"edit_note		= " . $this->db->q($edit_note) . ", " .
							"description	= " . $this->db->q($description) . ", " .
							"keywords		= " . $this->db->q($keywords) . ", " .
							"converted		= 2 " .
						"WHERE page_id = " . (int) $page['page_id'] . " " .
						"LIMIT 1");

					$total++;
				}

				$results .= "\t" . '<strong>' . date('H:i:s') . ' - ' . 'Records converted' . ': ' . $total . '</strong>' . "\n\n\n";
			}

			## 3. REVISIONS ##

			if ($revisions = $this->db->load_all(
				"SELECT revision_id, title, body, edit_note, description, keywords " .
				"FROM {$prefix}revision " .
				"WHERE converted <> 2 ")
			)
			{
				$total = 0;
				$results .=
					"\t" . '<strong>' . date('H:i:s') . ' - ' . 'revision' . "\n" .
					"\t" . '------------------------------------------------</strong>' . "\n";

				foreach($revisions as $revision)
				{
					$title			= $convert_entities($revision['title']);
					$body			= $convert_entities($revision['body']);
					$edit_note		= $convert_entities($revision['edit_note']);
					$description	= $convert_entities($revision['description']);
					$keywords		= $convert_entities($revision['keywords']);

					# echo $revision['revision_id'] . ': ' . $tag . '<br>';

					// update revision
					$this->db->sql_query(
						"UPDATE {$prefix}revision SET " .
							"title			= " . $this->db->q($title) . ", " .
							"body			= " . $this->db->q($body) . ", " .
							"edit_note		= " . $this->db->q($edit_note) . ", " .
							"description	= " . $this->db->q($description) . ", " .
							"keywords		= " . $this->db->q($keywords) . ", " .
							"converted		= 2 " .
						"WHERE revision_id = " . (int) $revision['revision_id'] . " " .
						"LIMIT 1");

					$total++;
				}

				$results .= "\t" . '<strong>' . date('H:i:s') . ' - ' . 'Records converted' . ': ' . $total . '</strong>' . "\n\n\n";
			}

			$results .=
				'<strong>' . date('H:i:s') . ' - ' . 'Tables records converted.' . "\n" .
				'================================================</strong>' . "\n";

			echo
				'<div class="code">' .
					'<pre>' . $results . '</pre>' .
				'</div><br>';
		}

		echo '<h3>2.3. Remove column \'converted\' from tables:</h3>';

		if (!isset($_POST['remove_converted_column']))
		{
			echo $this->form_open('converted_column');
			echo '<input type="submit" name="remove_converted_column" value="' . $this->_t('UpdateButton') . '">';
			echo $this->form_close();
		}
		else if (isset($_POST['remove_converted_column']))
		{
			// tables having 'converted' column to avoid double conversion
			$tables = [
				'category',
				'file',
				'menu',
				'page',
				'revision',
				'user',
				'usergroup',
			];

			// drop field 'converted'
			foreach ($tables as $table)
			{
				$this->db->sql_query("ALTER TABLE " . $prefix . $table . " DROP converted;");
			}

			$results =
				'<strong>' . date('H:i:s') . ' - ' . 'Droped column \'converted\' from tables' . "\n" .
				'================================================</strong>' . "\n";

			echo
				'<div class="code">' .
					'<pre>' . $results . '</pre>' .
				'</div><br>';
		}
	}
}