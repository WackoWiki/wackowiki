<?php
@set_time_limit(0);
@ignore_user_abort(true);

function test($text, $condition, $errorText = "")
{
	global $lang;
	print("            <li>".$text."   ".output_image($condition));

	if(!$condition)
	{
		if($errorText)
		{
			print("<ul class=\"install_error\"><li>".$errorText."</li></ul>");
		}

		print("</li>\n");
		return false;
	}

	print("</li>\n");
	return true;
}

function outputError($errorText = "")
{
	print("<ul class=\"install_error\"><li>".$errorText."</li></ul>");
}

function RandomSeed($length, $seed_complexity)
{
	$chars_uc = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$chars_lc = 'abcdefghijklmnopqrstuvwxyz';
	$digits = '0123456789';
	$symbols = '-_!@#%^&*(){}[]|~'; // removed '$'
	$uc = 0;
	$lc = 0;
	$di = 0;
	$sy = 0;

	if ($seed_complexity == 2) $sy = 100;

	while ($uc == 0 || $lc == 0 || $di == 0 || $sy == 0)
	{
		$seed = '';
		for ($i = 0; $i < $length; $i++)
		{
			$k = rand(0, $seed_complexity);  //randomly choose what's next
			if ($k == 0)
			{
				//uppercase
				$seed .= substr(str_shuffle($chars_uc), rand(0, sizeof($chars_uc) - 2), 1);
				$uc++;
			}
			if ($k == 1)
			{
				//lowercase
				$seed .= substr(str_shuffle($chars_lc), rand(0, sizeof($chars_lc) - 2), 1);
				$lc++;
			}
			if ($k == 2)
			{
				//digits
				$seed .= substr(str_shuffle($digits), rand(0, sizeof($digits) - 2), 1);
				$di++;
			}
			if ($k == 3)
			{
				//symbols
				$seed .= substr(str_shuffle($symbols), rand(0, sizeof($symbols) - 2), 1);
				$sy++;
			}
		}
	}

	return $seed;
}

// test configuration
print("         <h2>".$lang["TestingConfiguration"]."</h2>\n");

// Generic Default Inserts
if ( ( $config["system_seed"] == "") )
	$config["system_seed"] = RandomSeed(20, 3);

$salt = RandomSeed(4, 3);
$password_encrypted = sha1($config["admin_name"].$salt.$_POST["password"]);
$insert_admin = "INSERT INTO ".$config["table_prefix"]."user (user_name, password, salt, email, signup_time, lang) VALUES ('".$config["admin_name"]."', '".$password_encrypted."', '".$salt."', '".$config["admin_email"]."', NOW())";
$insert_admin_setting = "INSERT INTO ".$config["table_prefix"]."user_setting (user_id, lang) VALUES ((SELECT user_id FROM ".$config["table_prefix"]."user WHERE user_name = '".$config["admin_name"]."' LIMIT 1), '".$config["language"]."')";
// TODO: for Upgrade insert other aliases also in group table
// $config["aliases"] = array("Admins" => $config["admin_name"]);


$insert_admin_group = "INSERT INTO ".$config["table_prefix"]."group (group_name, description, moderator, created) VALUES ('Admins', '', (SELECT user_id FROM ".$config["table_prefix"]."user WHERE user_name = '".$config["admin_name"]."' LIMIT 1), NOW())";
$insert_admin_group_member = "INSERT INTO ".$config["table_prefix"]."group_member (group_id, user_id) VALUES ((SELECT group_id FROM ".$config["table_prefix"]."group WHERE group_name = 'Admins' LIMIT 1), (SELECT user_id FROM ".$config["table_prefix"]."user WHERE user_name = '".$config["admin_name"]."' LIMIT 1))";

$insert_logo_image = "INSERT INTO ".$config["table_prefix"]."upload (page_id, user_id, filename, description, uploaded_dt, filesize, picture_w, picture_h, file_ext) VALUES ('0', (SELECT user_id FROM ".$config["table_prefix"]."user WHERE user_name = '".$config["admin_name"]."' LIMIT 1),'wacko4.gif', 'WackoWiki', NOW(), '1580', '108', '50', 'gif')";

// inserting config values
$configDb['abuse_email'] = $config['abuse_email'];
$configDb['admin_email'] = $config['admin_email'];
$configDb['admin_name'] = $config['admin_name'];
$configDb['allow_rawhtml'] = $config['allow_rawhtml'];
$configDb['allow_registration'] = $config['allow_registration'];
$configDb['allow_swfobject'] = $config['allow_swfobject'];
$configDb['allow_themes'] = $config['allow_themes'];
$configDb['allow_x11colors'] = $config['allow_x11colors'];
$configDb['antidupe'] = $config['antidupe'];
$configDb['cache'] = $config['cache'];
$configDb['cache_sql'] = $config['cache_sql'];
$configDb['cache_sql_ttl'] = $config['cache_sql_ttl'];
$configDb['cache_ttl'] = $config['cache_ttl'];
$configDb['captcha_edit_page'] = $config['captcha_edit_page'];
$configDb['captcha_new_comment'] = $config['captcha_new_comment'];
$configDb['captcha_new_page'] = $config['captcha_new_page'];
$configDb['captcha_registration'] = $config['captcha_registration'];
$configDb['comments_count'] = $config['comments_count'];
$configDb['cookie_prefix'] = $config['cookie_prefix'];
$configDb['cookie_session'] = $config['cookie_session'];
$configDb['date_format'] = $config['date_format'];
$configDb['date_macro_format'] = $config['date_macro_format'];
$configDb['date_precise_format'] = $config['date_precise_format'];
$configDb['debug'] = $config['debug'];
$configDb['debug_admin_only'] = $config['debug_admin_only'];
$configDb['debug_sql_threshold'] = $config['debug_sql_threshold'];
$configDb['default_comment_acl'] = $config['default_comment_acl'];
$configDb['default_create_acl'] = $config['default_create_acl'];
$configDb['default_read_acl'] = $config['default_read_acl'];
$configDb['default_rename_redirect'] = $config['default_rename_redirect'];
$configDb['default_typografica'] = $config['default_typografica'];
$configDb['default_write_acl'] = $config['default_write_acl'];
$configDb['disable_autosubscribe'] = $config['disable_autosubscribe'];
$configDb['disable_bracketslinks'] = $config['disable_bracketslinks'];
$configDb['disable_formatters'] = $config['disable_formatters'];
$configDb['disable_npjlinks'] = $config['disable_npjlinks'];
$configDb['disable_safehtml'] = $config['disable_safehtml'];
$configDb['disable_tikilinks'] = $config['disable_tikilinks'];
$configDb['disable_wikilinks'] = $config['disable_wikilinks'];
$configDb['edit_summary'] = $config['edit_summary'];
$configDb['footer_comments'] = $config['footer_comments'];
$configDb['footer_files'] = $config['footer_files'];
$configDb['forum_cluster'] = $config['forum_cluster'];
$configDb['forum_topics'] = $config['forum_topics'];
$configDb['hide_comments'] = $config['hide_comments'];
$configDb['hide_files'] = $config['hide_files'];
$configDb['hide_index'] = $config['hide_index'];
$configDb['hide_locked'] = $config['hide_locked'];
$configDb['hide_rating'] = $config['hide_rating'];
$configDb['hide_toc'] = $config['hide_toc'];
$configDb['keep_deleted_time'] = $config['keep_deleted_time'];
$configDb['language'] = $config['language'];
$configDb['log_default_show'] = $config['log_default_show'];
$configDb['log_min_level'] = $config['log_min_level'];
$configDb['log_purge_time'] = $config['log_purge_time'];
$configDb['lower_index'] = $config['lower_index'];
$configDb['meta_description'] = $config['meta_description'];
$configDb['meta_keywords'] = $config['meta_keywords'];
$configDb['minor_edit'] = $config['minor_edit'];
$configDb['multilanguage'] = $config['multilanguage'];
$configDb['name_date_macro'] = $config['name_date_macro'];
$configDb['news_cluster'] = $config['news_cluster'];
$configDb['news_levels'] = $config['news_levels'];
$configDb['outlook_workaround'] = $config['outlook_workaround'];
$configDb['owners_can_change_categories'] = $config['owners_can_change_categories'];
$configDb['owners_can_remove_comments'] = $config['owners_can_remove_comments'];
$configDb['pages_purge_time'] = $config['pages_purge_time'];
$configDb['paragrafica'] = $config['paragrafica'];
$configDb['policy_page'] = $config['policy_page'];
$configDb['pwd_char_classes'] = $config['pwd_char_classes'];
$configDb['pwd_min_chars'] = $config['pwd_min_chars'];
$configDb['pwd_unlike_login'] = $config['pwd_unlike_login'];
$configDb['referrers_purge_time'] = $config['referrers_purge_time'];
$configDb['remove_onlyadmins'] = $config['remove_onlyadmins'];
$configDb['rename_globalacl'] = $config['rename_globalacl'];
$configDb['revisions_hide_cancel'] = $config['revisions_hide_cancel'];
$configDb['rewrite_mode'] = $config['rewrite_mode'];
$configDb['root_page'] = $config['root_page'];
$configDb['session_prefix'] = $config['session_prefix'];
$configDb['show_spaces'] = $config['show_spaces'];
$configDb['spam_filter'] = $config['spam_filter'];
$configDb['ssl'] = $config['ssl'];
$configDb['ssl_implicit'] = $config['ssl_implicit'];
$configDb['ssl_proxy'] = $config['ssl_proxy'];
$configDb['standard_handlers'] = $config['standard_handlers'];
$configDb['store_deleted_pages'] = $config['store_deleted_pages'];
$configDb['strong_cookies'] = $config['strong_cookies'];
$configDb['theme'] = $config['theme'];
$configDb['time_format'] = $config['time_format'];
$configDb['time_format_seconds'] = $config['time_format_seconds'];
$configDb['upload'] = $config['upload'];
$configDb['upload_banned_exts'] = $config['upload_banned_exts'];
$configDb['upload_images_only'] = $config['upload_images_only'];
$configDb['upload_max_per_user'] = $config['upload_max_per_user'];
$configDb['upload_max_size'] = $config['upload_max_size'];
$configDb['upper_index'] = $config['upper_index'];
$configDb['urls_underscores'] = $config['urls_underscores'];
$configDb['users_page'] = $config['users_page'];
$configDb['wacko_desc'] = $config['wacko_desc'];
$configDb['wacko_name'] = $config['wacko_name'];
$configDb['xml_sitemap'] = $config['xml_sitemap'];
$configDb['youarehere_text'] = $config['youarehere_text'];
#$configDb[''] = $config[''];

foreach($configDb as $key => $value)
{
	$config_insert .= "(0, '$key', '$value'),";
}

$insert_config = "INSERT INTO ".$config["table_prefix"]."config (config_id, config_name, value) VALUES
	".$config_insert."
	(0, 'maint_last_cache', NULL),
	(0, 'maint_last_log', NULL),
	(0, 'maint_last_refs', NULL),
	(0, 'maint_last_delpages', NULL),
	(0, 'maint_last_oldpages', NULL);";

/*
 Setup the tables depending on which database we selected

 mysql_legacy
 mysqli_legacy
 or pdo which is the default clause
 */
$port = trim($config["database_port"]);

$fatal_error = false;

switch($config["database_driver"])
{
	case "mysql_legacy":
		require_once("setup/database_mysql.php");
		require_once("setup/database_mysql_updates.php");

		print("         <ul>\n");

		if(!test($lang["TestConnectionString"], $dblink = @mysql_connect($config["database_host"].($port == "" ? '' : ':'.$port), $config["database_user"], $config["database_password"]), $lang["ErrorDBConnection"]))
		{
			/*
			 There was a problem with the connection string
			 */

			print("         </ul>\n");
			print("         <br />\n");

			$fatal_error = true;
		}
		else if(!test($lang["TestDatabaseExists"], @mysql_select_db($config["database_database"], $dblink), $lang["ErrorDBExists"]))
		{
			/*
			 There was a problem with the specified database name
			 */

			print("         </ul>\n");
			print("         <br />\n");

			$fatal_error = true;
		}
		else
		{
			/*
			 The connection string and the database name are ok, proceed
			 */
			print("         </ul>\n");
			print("         <br />\n");

			if ( !isset ( $config["wacko_version"] ) ) $config["wacko_version"] = "";
			if (!$version = trim($config["wacko_version"])) $version = "0";
			if ( isset ( $config["wacko_version"] ) )
			if ( trim ( $config["wacko_version"] ) ) $version = trim($config["wacko_version"]);

			if ($config["DeleteTables"] == "on")
			{
					print("<h2>".$lang["DeletingTables"]."</h2>\n");
					print("            <ul>\n");
					test(str_replace("%1", "acl", $lang["DeletingTable"]), @mysql_query($table_acl_drop, $dblink), str_replace("%1", "acl", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "bookmark", $lang["DeletingTable"]), @mysql_query($table_bookmark_drop, $dblink), str_replace("%1", "bookmark", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "cache", $lang["DeletingTable"]), @mysql_query($table_cache_drop, $dblink), str_replace("%1", "cache", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "config", $lang["DeletingTable"]), @mysql_query($table_config_drop, $dblink), str_replace("%1", "config", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "group", $lang["DeletingTable"]), @mysql_query($table_group_drop, $dblink), str_replace("%1", "group", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "group_member", $lang["DeletingTable"]), @mysql_query($table_group_member_drop, $dblink), str_replace("%1", "group_member", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "category", $lang["DeletingTable"]), @mysql_query($table_category_drop, $dblink), str_replace("%1", "category", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "category_page", $lang["DeletingTable"]), @mysql_query($table_category_page_drop, $dblink), str_replace("%1", "category_page", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "link", $lang["DeletingTable"]), @mysql_query($table_link_drop, $dblink), str_replace("%1", "link", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "log", $lang["DeletingTable"]), @mysql_query($table_log_drop, $dblink), str_replace("%1", "log", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "page", $lang["DeletingTable"]), @mysql_query($table_page_drop, $dblink), str_replace("%1", "page", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "poll", $lang["DeletingTable"]), @mysql_query($table_poll_drop, $dblink), str_replace("%1", "poll", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "rating", $lang["DeletingTable"]), @mysql_query($table_rating_drop, $dblink), str_replace("%1", "rating", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "referrer", $lang["DeletingTable"]), @mysql_query($table_referrer_drop, $dblink), str_replace("%1", "referrer", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "revision", $lang["DeletingTable"]), @mysql_query($table_revision_drop, $dblink), str_replace("%1", "revision", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "upload", $lang["DeletingTable"]), @mysql_query($table_upload_drop, $dblink), str_replace("%1", "upload", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "user", $lang["DeletingTable"]), @mysql_query($table_user_drop, $dblink), str_replace("%1", "user", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "user_setting", $lang["DeletingTable"]), @mysql_query($table_user_setting_drop, $dblink), str_replace("%1", "user_setting", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "watch", $lang["DeletingTable"]), @mysql_query($table_watch_drop, $dblink), str_replace("%1", "watch", $lang["ErrorDeletingTable"]));
					print("            <li>".$lang["DeletingTablesEnd"]."</li>\n");
					print("         </ul>\n");
					print("         <br />\n");
					$version = 0;
			}

			switch ($version)
			{
				// new installation
				case "0":
					print("<h2>".$lang["InstallingTables"]."</h2>\n");
					print("            <ul>\n");
					test(str_replace("%1","acl",$lang["CreatingTable"]), @mysql_query($table_acl, $dblink), str_replace("%1","acl",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","bookmark",$lang["CreatingTable"]), @mysql_query($table_bookmark, $dblink), str_replace("%1","bookmark",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","cache",$lang["CreatingTable"]), @mysql_query($table_cache, $dblink), str_replace("%1","cache",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","config",$lang["CreatingTable"]), @mysql_query($table_config, $dblink), str_replace("%1","config",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","group",$lang["CreatingTable"]), @mysql_query($table_group, $dblink), str_replace("%1","group",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","group_member",$lang["CreatingTable"]), @mysql_query($table_group_member, $dblink), str_replace("%1","group_member",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","category",$lang["CreatingTable"]), @mysql_query($table_category, $dblink), str_replace("%1","category",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","category_page",$lang["CreatingTable"]), @mysql_query($table_category_page, $dblink), str_replace("%1","category_page",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","link",$lang["CreatingTable"]), @mysql_query($table_link, $dblink), str_replace("%1","link",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","log",$lang["CreatingTable"]), @mysql_query($table_log, $dblink), str_replace("%1","log",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","page",$lang["CreatingTable"]), @mysql_query($table_page, $dblink), str_replace("%1","page",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","poll",$lang["CreatingTable"]), @mysql_query($table_poll, $dblink), str_replace("%1","poll",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","rating",$lang["CreatingTable"]), @mysql_query($table_rating, $dblink), str_replace("%1","rating",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","referrer",$lang["CreatingTable"]), @mysql_query($table_referrer, $dblink), str_replace("%1","referrer",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","revision",$lang["CreatingTable"]), @mysql_query($table_revision, $dblink), str_replace("%1","revision",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","upload",$lang["CreatingTable"]), @mysql_query($table_upload, $dblink), str_replace("%1","upload",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","user",$lang["CreatingTable"]), @mysql_query($table_user, $dblink), str_replace("%1","user",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","user_setting",$lang["CreatingTable"]), @mysql_query($table_user_setting, $dblink), str_replace("%1","user_setting",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","watch",$lang["CreatingTable"]), @mysql_query($table_watch, $dblink), str_replace("%1","watch",$lang["ErrorCreatingTable"]));

					test($lang["InstallingAdmin"], @mysql_query($insert_admin, $dblink), str_replace("%1","admin user",$lang["ErrorAlreadyExists"]));
					test($lang["InstallingAdminSetting"], @mysql_query($insert_admin_setting, $dblink), str_replace("%1","admin user settings",$lang["ErrorAlreadyExists"]));
					test($lang["InstallingAdminGroup"], @mysql_query($insert_admin_group, $dblink), str_replace("%1","admin group",$lang["ErrorAlreadyExists"]));
					test($lang["InstallingAdminGroupMember"], @mysql_query($insert_admin_group_member, $dblink), str_replace("%1","admin group member",$lang["ErrorAlreadyExists"]));
					print("            </ul>\n");
					print("            <br />\n");
					print("            <h2>".$lang["InstallingDefaultData"]."</h2>\n");
					print("            <ul>\n");
					print("               <li>".$lang["InstallingPagesBegin"]);
					require_once("setup/inserts.php");
					print("</li>\n");
					print("            <li>".$lang["InstallingPagesEnd"]."</li>\n");

					test($lang["InstallingLogoImage"], @mysql_query($insert_logo_image, $dblink), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));
					test($lang["InstallingConfigValues"], @mysql_query($insert_config, $dblink), str_replace("%1","config values",$lang["ErrorAlreadyExists"]));

					break;

					/*
					 The funny upgrading stuff. Make sure these are in order!
					 And yes, there are no (switch) breaks here. This is on purpose.
					 */

				// upgrade from R4.2 to R4.3.rc1
				case "R4.2":
					print("         <h2>Wacko R4.2 ".$lang["To"]." R4.3.rc1</h2>\n");
					print("         <ul>\n");

					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_2_1, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_2_2, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_2_1, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_2_2, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));

					test($lang["InstallingLogoImage"], @mysql_query($insert_logo_image, $dblink), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));

				// upgrade from R4.3.rc1 to R4.4.rc1
				case "R4.3":
					print("         <h2>Wacko R4.3.rc1 ".$lang["To"]." R4.4.rc1</h2>\n");
					print("         <ul>\n");
					// ! new user_id first
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_1, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_2, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_3, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_4, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_5, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_6, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_7, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_8, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_9, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_10, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_11, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_12, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_13, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","user",$lang["UpdateTable"]), @mysql_query($update_user_r4_3, $dblink), str_replace("%1", "user", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","user",$lang["UpdateTable"]), @mysql_query($update_user_r4_3_1, $dblink), str_replace("%1", "user", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","user",$lang["UpdateTable"]), @mysql_query($update_user_r4_3_2, $dblink), str_replace("%1", "user", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","user",$lang["UpdateTable"]), @mysql_query($update_user_r4_3_4, $dblink), str_replace("%1", "user", $lang["ErrorUpdatingTable"]));

					// rename id after upate!
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_14, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_15, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_16, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_17, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_18, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_19, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_20, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","user",$lang["AlterTable"]), @mysql_query($alter_user_r4_3_21, $dblink), str_replace("%1", "user", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","acl",$lang["AlterTable"]), @mysql_query($alter_acl_r4_3, $dblink), str_replace("%1", "acl", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","acl",$lang["AlterTable"]), @mysql_query($alter_acl_r4_3_1, $dblink), str_replace("%1", "acl", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","acl",$lang["UpdateTable"]), @mysql_query($update_acl_r4_3, $dblink), str_replace("%1", "acl", $lang["ErrorUpdatingTable"]));

					// Drop obsolete fields
					test(str_replace("%1","acl",$lang["AlterTable"]), @mysql_query($alter_acl_r4_3_2, $dblink), str_replace("%1", "acl", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","acl",$lang["AlterTable"]), @mysql_query($alter_acl_r4_3_3, $dblink), str_replace("%1", "acl", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","acl",$lang["AlterTable"]), @mysql_query($alter_acl_r4_3_4, $dblink), str_replace("%1", "acl", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","acl",$lang["AlterTable"]), @mysql_query($alter_acl_r4_3_5, $dblink), str_replace("%1", "acl", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","bookmark",$lang["CreatingTable"]), @mysql_query($table_bookmark_r4_3, $dblink), str_replace("%1", "bookmark", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","cache",$lang["AlterTable"]), @mysql_query($alter_cache_r4_3, $dblink), str_replace("%1", "cache", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","cache",$lang["AlterTable"]), @mysql_query($alter_cache_r4_3_1, $dblink), str_replace("%1", "cache", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","config",$lang["CreatingTable"]), @mysql_query($table_config_r4_3, $dblink), str_replace("%1", "config", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","group",$lang["CreatingTable"]), @mysql_query($table_group_r4_3, $dblink), str_replace("%1", "group", $lang["ErrorCreatingTable"]));
					test(str_replace("%1","group_member",$lang["CreatingTable"]), @mysql_query($table_group_member_r4_3, $dblink), str_replace("%1", "group_member", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","category",$lang["CreatingTable"]), @mysql_query($table_category_r4_3, $dblink), str_replace("%1", "category", $lang["ErrorCreatingTable"]));
					test(str_replace("%1","category_page",$lang["CreatingTable"]), @mysql_query($table_category_page_r4_3, $dblink), str_replace("%1", "category_page", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","link",$lang["AlterTable"]), @mysql_query($alter_link_r4_3, $dblink), str_replace("%1", "link", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","link",$lang["AlterTable"]), @mysql_query($alter_link_r4_3_1, $dblink), str_replace("%1", "link", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","link",$lang["AlterTable"]), @mysql_query($alter_link_r4_3_2, $dblink), str_replace("%1", "link", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","link",$lang["UpdateTable"]), @mysql_query($update_link_r4_3, $dblink), str_replace("%1", "link", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","link",$lang["UpdateTable"]), @mysql_query($update_link_r4_3_1, $dblink), str_replace("%1", "link", $lang["ErrorUpdatingTable"]));

					// drop last!
					test(str_replace("%1","link",$lang["AlterTable"]), @mysql_query($alter_link_r4_3_3, $dblink), str_replace("%1", "link", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","link",$lang["AlterTable"]), @mysql_query($alter_link_r4_3_4, $dblink), str_replace("%1", "link", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","link",$lang["AlterTable"]), @mysql_query($alter_link_r4_3_5, $dblink), str_replace("%1", "link", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","log",$lang["CreatingTable"]), @mysql_query($table_log_r4_3, $dblink), str_replace("%1", "log", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_3, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_4, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_5, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_6, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_7, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_8, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_9, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_10, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_11, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","page",$lang["UpdateTable"]), @mysql_query($update_page_r4_3, $dblink), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","page",$lang["UpdateTable"]), @mysql_query($update_page_r4_3_1, $dblink), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","page",$lang["UpdateTable"]), @mysql_query($update_page_r4_3_2, $dblink), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","page",$lang["UpdateTable"]), @mysql_query($update_page_r4_3_3, $dblink), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","page",$lang["UpdateTable"]), @mysql_query($update_page_r4_3_4, $dblink), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","page",$lang["UpdateTable"]), @mysql_query($update_page_r4_3_5, $dblink), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","page",$lang["UpdateTable"]), @mysql_query($update_page_r4_3_6, $dblink), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","page",$lang["UpdateTable"]), @mysql_query($update_page_r4_3_7, $dblink), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));

					// drop last!
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_12, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_13, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_14, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_15, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_16, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_17, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_18, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_19, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_20, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_21, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_22, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_23, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_24, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_25, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_26, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_27, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_28, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_29, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","page",$lang["AlterTable"]), @mysql_query($alter_page_r4_3_30, $dblink), str_replace("%1", "page", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","poll",$lang["CreatingTable"]), @mysql_query($table_poll_r4_3, $dblink), str_replace("%1", "poll", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","watch",$lang["AlterTable"]), @mysql_query($alter_watch_r4_3, $dblink), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","watch",$lang["AlterTable"]), @mysql_query($alter_watch_r4_3_1, $dblink), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","watch",$lang["AlterTable"]), @mysql_query($alter_watch_r4_3_2, $dblink), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","watch",$lang["UpdateTable"]), @mysql_query($update_watch_r4_3, $dblink), str_replace("%1", "watch", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","watch",$lang["UpdateTable"]), @mysql_query($update_watch_r4_3_1, $dblink), str_replace("%1", "watch", $lang["ErrorUpdatingTable"]));

					// drop last!
					test(str_replace("%1","watch",$lang["AlterTable"]), @mysql_query($alter_watch_r4_3_3, $dblink), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","watch",$lang["AlterTable"]), @mysql_query($alter_watch_r4_3_4, $dblink), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","watch",$lang["AlterTable"]), @mysql_query($alter_watch_r4_3_5, $dblink), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","watch",$lang["AlterTable"]), @mysql_query($alter_watch_r4_3_6, $dblink), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));

					// rename
					test(str_replace("%1","watch",$lang["AlterTable"]), @mysql_query($rename_watch_r4_3, $dblink), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","rating",$lang["CreatingTable"]), @mysql_query($table_rating_r4_3, $dblink), str_replace("%1", "rating", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","referrer",$lang["AlterTable"]), @mysql_query($alter_referrer_r4_3, $dblink), str_replace("%1", "referrer", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","referrer",$lang["AlterTable"]), @mysql_query($alter_referrer_r4_3_1, $dblink), str_replace("%1", "referrer", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_3, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_4, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_5, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_6, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_7, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_8, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_9, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_10, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_13, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","revision",$lang["UpdateTable"]), @mysql_query($update_revision_r4_3, $dblink), str_replace("%1", "revision", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","revision",$lang["UpdateTable"]), @mysql_query($update_revision_r4_3_1, $dblink), str_replace("%1", "revision", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","revision",$lang["UpdateTable"]), @mysql_query($update_revision_r4_3_2, $dblink), str_replace("%1", "revision", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","revision",$lang["UpdateTable"]), @mysql_query($update_revision_r4_3_3, $dblink), str_replace("%1", "revision", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","revision",$lang["UpdateTable"]), @mysql_query($update_revision_r4_3_4, $dblink), str_replace("%1", "revision", $lang["ErrorUpdatingTable"]));

					// drop last!
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_11, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_12, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_14, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_15, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_16, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_17, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_18, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["AlterTable"]), @mysql_query($alter_revision_r4_3_19, $dblink), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","upload",$lang["AlterTable"]), @mysql_query($alter_upload_r4_3, $dblink), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","upload",$lang["UpdateTable"]), @mysql_query($update_upload_r4_3, $dblink), str_replace("%1", "upload", $lang["ErrorUpdatingTable"]));

					// drop last!
					test(str_replace("%1","upload",$lang["AlterTable"]), @mysql_query($alter_upload_r4_3_1, $dblink), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","upload",$lang["AlterTable"]), @mysql_query($alter_upload_r4_3_2, $dblink), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));

					// inserting config values
					test($lang["InstallingConfigValues"], @mysql_query($insert_config, $dblink), str_replace("%1","config values",$lang["ErrorAlreadyExists"]));
			}
			print("            </ul>\n");
		}
		break;
				case "mysqli_legacy":
					require_once("setup/database_mysql.php");
					require_once("setup/database_mysql_updates.php");

					if ( !isset ( $config["database_port"] ) ) $config["database_port"] = "3306";
					if (!$port = trim($config["database_port"])) $port = "3306";

					print("         <ul>\n");

					if(!test($lang["TestConnectionString"], $dblink = @mysqli_connect($config["database_host"], $config["database_user"], $config["database_password"], null, $port), $lang["ErrorDBConnection"]))
					{
						/*
						 There was a problem with the connection string
						 */

						print("         </ul>\n");
						print("         <br />\n");

						$fatal_error = true;
					}
					else if(!test($lang["TestDatabaseExists"], @mysqli_select_db($dblink, $config["database_database"]), $lang["ErrorDBExists"]))
					{
						/*
						 There was a problem with the specified database name
						 */

						print("         </ul>\n");
						print("         <br />\n");

						$fatal_error = true;
					}
					else
					{
						/*
						 The connection string and the database name are ok, proceed
						 */
						print("         </ul>\n");
						print("         <br />\n");


						if ( !isset( $config["wacko_version"] ) ) $config["wacko_version"] = "0";
						if (!$version = trim($config["wacko_version"])) $version = "0";
						if (trim($config["wacko_version"])) $version = trim($config["wacko_version"]);

						if ($config["DeleteTables"] == "on")
						{
							print("<h2>".$lang["DeletingTables"]."</h2>\n");
							print("            <ul>\n");
							test(str_replace("%1", "acl", $lang["DeletingTable"]), @mysqli_query($dblink, $table_acl_drop), str_replace("%1", "acl", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "bookmark", $lang["DeletingTable"]), @mysqli_query($dblink, $table_bookmarks_drop), str_replace("%1", "bookmark", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "cache", $lang["DeletingTable"]), @mysqli_query($dblink, $table_cache_drop), str_replace("%1", "cache", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "config", $lang["DeletingTable"]), @mysqli_query($dblink, $table_config_drop), str_replace("%1", "config", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "group", $lang["DeletingTable"]), @mysqli_query($dblink, $table_group_drop), str_replace("%1", "group", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "group_member", $lang["DeletingTable"]), @mysqli_query($dblink, $table_group_member_drop), str_replace("%1", "group_member", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "category", $lang["DeletingTable"]), @mysqli_query($dblink, $table_category_drop), str_replace("%1", "category", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "category_page", $lang["DeletingTable"]), @mysqli_query($dblink, $table_category_page_drop), str_replace("%1", "category_page", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "link", $lang["DeletingTable"]), @mysqli_query($dblink, $table_link_drop), str_replace("%1", "link", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "log", $lang["DeletingTable"]), @mysqli_query($dblink, $table_log_drop), str_replace("%1", "log", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "page", $lang["DeletingTable"]), @mysqli_query($dblink, $table_page_drop), str_replace("%1", "page", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "poll", $lang["DeletingTable"]), @mysqli_query($dblink, $table_poll_drop), str_replace("%1", "poll", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "rating", $lang["DeletingTable"]), @mysqli_query($dblink, $table_rating_drop), str_replace("%1", "rating", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "referrer", $lang["DeletingTable"]), @mysqli_query($dblink, $table_referrer_drop), str_replace("%1", "referrer", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "revision", $lang["DeletingTable"]), @mysqli_query($dblink, $table_revision_drop), str_replace("%1", "revision", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "upload", $lang["DeletingTable"]), @mysqli_query($dblink, $table_upload_drop), str_replace("%1", "upload", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "user", $lang["DeletingTable"]), @mysqli_query($dblink, $table_user_drop), str_replace("%1", "user", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "user_setting", $lang["DeletingTable"]), @mysqli_query($dblink, $table_user_setting_drop), str_replace("%1", "user_setting", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "watch", $lang["DeletingTable"]), @mysqli_query($dblink, $table_watch_drop), str_replace("%1", "watch", $lang["ErrorDeletingTable"]));
							print("            <li>".$lang["DeletingTablesEnd"]."</li>\n");
							print("         </ul>\n");
							print("         <br />\n");
							$version = 0;
						}

						switch ($version)
						{
							// new installation
							case "0":
								print("         <h2>".$lang["InstallingTables"]."</h2>\n");
								print("         <ul>\n");
								test(str_replace("%1","acl",$lang["CreatingTable"]), @mysqli_query($dblink, $table_acl), str_replace("%1","acl",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","bookmark",$lang["CreatingTable"]), @mysqli_query($dblink, $table_bookmark), str_replace("%1","bookmark",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","cache",$lang["CreatingTable"]), @mysqli_query($dblink, $table_cache), str_replace("%1","cache",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","config",$lang["CreatingTable"]), @mysqli_query($dblink, $table_config), str_replace("%1","config",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","group",$lang["CreatingTable"]), @mysqli_query($dblink, $table_group), str_replace("%1","group",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","group_member",$lang["CreatingTable"]), @mysqli_query($dblink, $table_group_member), str_replace("%1","group_member",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","category",$lang["CreatingTable"]), @mysqli_query($dblink, $table_category), str_replace("%1","category",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","category_page",$lang["CreatingTable"]), @mysqli_query($dblink, $table_category_page), str_replace("%1","category_page",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","link",$lang["CreatingTable"]), @mysqli_query($dblink, $table_link), str_replace("%1","link",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","log",$lang["CreatingTable"]), @mysqli_query($dblink, $table_log), str_replace("%1","log",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","page",$lang["CreatingTable"]), @mysqli_query($dblink, $table_page), str_replace("%1","page",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","poll",$lang["CreatingTable"]), @mysqli_query($dblink, $table_poll), str_replace("%1","poll",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","rating",$lang["CreatingTable"]), @mysqli_query($dblink, $table_rating), str_replace("%1","rating",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","referrer",$lang["CreatingTable"]), @mysqli_query($dblink, $table_referrer), str_replace("%1","referrer",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","revision",$lang["CreatingTable"]), @mysqli_query($dblink, $table_revision), str_replace("%1","revision",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","upload",$lang["CreatingTable"]), @mysqli_query($dblink, $table_upload), str_replace("%1","upload",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","user",$lang["CreatingTable"]), @mysqli_query($dblink, $table_user), str_replace("%1","user",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","user_setting",$lang["CreatingTable"]), @mysqli_query($dblink, $table_user_setting), str_replace("%1","user_setting",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","watch",$lang["CreatingTable"]), @mysqli_query($dblink, $table_watch), str_replace("%1","watch",$lang["ErrorCreatingTable"]));

								test($lang["InstallingAdmin"], @mysqli_query($dblink, $insert_admin), str_replace("%1","admin user",$lang["ErrorAlreadyExists"]));
								test($lang["InstallingAdminSetting"], @mysqli_query($dblink, $insert_admin_setting), str_replace("%1","admin user settings",$lang["ErrorAlreadyExists"]));
								test($lang["InstallingAdminGroup"], @mysqli_query($dblink, $insert_admin_group), str_replace("%1","admin group",$lang["ErrorAlreadyExists"]));
								test($lang["InstallingAdminGroupMember"], @mysqli_query($dblink, $insert_admin_group_member), str_replace("%1","admin group member",$lang["ErrorAlreadyExists"]));
								print("         </ul>\n");
								print("         <br />\n");
								print("         <h2>".$lang["InstallingDefaultData"]."</h2>\n");
								print("         <ul>\n");
								print("            <li>".$lang["InstallingPagesBegin"]);
								require_once("setup/inserts.php");
								print("</li>\n");
								print("            <li>".$lang["InstallingPagesEnd"]."</li>\n");

								test($lang["InstallingLogoImage"], @mysqli_query($dblink, $insert_logo_image), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));
								test($lang["InstallingConfigValues"], @mysqli_query($dblink, $insert_config), str_replace("%1","config values",$lang["ErrorAlreadyExists"]));
								break;

								/*
								 The funny upgrading stuff. Make sure these are in order!
								 And yes, there are no (switch) breaks here. This is on purpose.
								 */

							// upgrade from R4.2 to R4.3.rc1
							case "R4.2":
								print("         <h2>Wacko R4.2 ".$lang["To"]." R4.3.rc1</h2>\n");
								print("         <ul>\n");

								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_2_1), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_2_2), str_replace("%1", "page", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_2_2), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_2_3), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));

								test($lang["InstallingLogoImage"], @mysqli_query($dblink, $insert_logo_image), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));

							// upgrade from R4.3.rc1 to R4.4.rc1
							case "R4.3":
								print("         <h2>Wacko R4.3.rc1 ".$lang["To"]." R4.4.rc1</h2>\n");
								print("         <ul>\n");

								// ! new user_id first
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_1), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_2), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_3), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_4), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_5), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_6), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_7), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_8), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_9), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_10), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_11), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_12), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_13), str_replace("%1", "user", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","user",$lang["UpdateTable"]), @mysqli_query($dblink, $update_user_r4_3), str_replace("%1", "user", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","user",$lang["UpdateTable"]), @mysqli_query($dblink, $update_user_r4_3_1), str_replace("%1", "user", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","user",$lang["UpdateTable"]), @mysqli_query($dblink, $update_user_r4_3_2), str_replace("%1", "user", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","user",$lang["UpdateTable"]), @mysqli_query($dblink, $update_user_r4_3_4), str_replace("%1", "user", $lang["ErrorUpdatingTable"]));

								// rename id after upate!
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_14), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_15), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_16), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_17), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_18), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_19), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_20), str_replace("%1", "user", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","user",$lang["AlterTable"]), @mysqli_query($dblink, $alter_user_r4_3_21), str_replace("%1", "user", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","acl",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acl_r4_3), str_replace("%1", "acl", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","acl",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acl_r4_3_1), str_replace("%1", "acl", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","acl",$lang["UpdateTable"]), @mysqli_query($dblink, $update_acl_r4_3), str_replace("%1", "acl", $lang["ErrorUpdatingTable"]));

								// Drop obsolete fields
								test(str_replace("%1","acl",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acl_r4_3_2), str_replace("%1", "acl", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","acl",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acl_r4_3_3), str_replace("%1", "acl", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","acl",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acl_r4_3_4), str_replace("%1", "acl", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","acl",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acl_r4_3_5), str_replace("%1", "acl", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","bookmark",$lang["CreatingTable"]), @mysqli_query($dblink, $table_bookmark_r4_3), str_replace("%1", "bookmark", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","cache",$lang["AlterTable"]), @mysqli_query($dblink, $alter_cache_r4_3), str_replace("%1", "cache", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","cache",$lang["AlterTable"]), @mysqli_query($dblink, $alter_cache_r4_3_1), str_replace("%1", "cache", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","config",$lang["CreatingTable"]), @mysqli_query($dblink, $table_config_r4_3), str_replace("%1", "config", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","group",$lang["CreatingTable"]), @mysqli_query($dblink, $table_group_r4_3), str_replace("%1", "group", $lang["ErrorCreatingTable"]));
								test(str_replace("%1","group_member",$lang["CreatingTable"]), @mysqli_query($dblink, $table_group_member_r4_3), str_replace("%1", "group_member", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","category",$lang["CreatingTable"]), @mysqli_query($dblink, $table_category_r4_3), str_replace("%1", "category", $lang["ErrorCreatingTable"]));
								test(str_replace("%1","category_page",$lang["CreatingTable"]), @mysqli_query($dblink, $table_category_page_r4_3), str_replace("%1", "category_page", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","link",$lang["AlterTable"]), @mysqli_query($dblink, $alter_link_r4_3), str_replace("%1", "link", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","link",$lang["AlterTable"]), @mysqli_query($dblink, $alter_link_r4_3_1), str_replace("%1", "link", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","link",$lang["AlterTable"]), @mysqli_query($dblink, $alter_link_r4_3_2), str_replace("%1", "link", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","link",$lang["UpdateTable"]), @mysqli_query($dblink, $update_link_r4_3), str_replace("%1", "link", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","link",$lang["UpdateTable"]), @mysqli_query($dblink, $update_link_r4_3_1), str_replace("%1", "link", $lang["ErrorUpdatingTable"]));

								// drop last!
								test(str_replace("%1","link",$lang["AlterTable"]), @mysqli_query($dblink, $alter_link_r4_3_3), str_replace("%1", "link", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","link",$lang["AlterTable"]), @mysqli_query($dblink, $alter_link_r4_3_4), str_replace("%1", "link", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","link",$lang["AlterTable"]), @mysqli_query($dblink, $alter_link_r4_3_5), str_replace("%1", "link", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","log",$lang["CreatingTable"]), @mysqli_query($dblink, $table_log_r4_3), str_replace("%1", "log", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_3), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_4), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_5), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_6), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_7), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_8), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_9), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_10), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_11), str_replace("%1", "page", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","page",$lang["UpdateTable"]), @mysqli_query($dblink, $update_page_r4_3), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","page",$lang["UpdateTable"]), @mysqli_query($dblink, $update_page_r4_3_1), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","page",$lang["UpdateTable"]), @mysqli_query($dblink, $update_page_r4_3_2), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","page",$lang["UpdateTable"]), @mysqli_query($dblink, $update_page_r4_3_3), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","page",$lang["UpdateTable"]), @mysqli_query($dblink, $update_page_r4_3_4), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","page",$lang["UpdateTable"]), @mysqli_query($dblink, $update_page_r4_3_5), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","page",$lang["UpdateTable"]), @mysqli_query($dblink, $update_page_r4_3_6), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","page",$lang["UpdateTable"]), @mysqli_query($dblink, $update_page_r4_3_7), str_replace("%1", "page", $lang["ErrorUpdatingTable"]));

								// drop last!
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_12), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_13), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_14), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_15), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_16), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_17), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_18), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_19), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_20), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_21), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_22), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_23), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_24), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_25), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_26), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_27), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_28), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_29), str_replace("%1", "page", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","page",$lang["AlterTable"]), @mysqli_query($dblink, $alter_page_r4_3_30), str_replace("%1", "page", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","poll",$lang["CreatingTable"]), @mysqli_query($dblink, $table_poll_r4_3), str_replace("%1", "poll", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","watch",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watch_r4_3), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","watch",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watch_r4_3_1), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","watch",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watch_r4_3_2), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","watch",$lang["UpdateTable"]), @mysqli_query($dblink, $update_watch_r4_3), str_replace("%1", "watch", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","watch",$lang["UpdateTable"]), @mysqli_query($dblink, $update_watch_r4_3_1), str_replace("%1", "watch", $lang["ErrorUpdatingTable"]));

								// drop last!
								test(str_replace("%1","watch",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watch_r4_3_3), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","watch",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watch_r4_3_4), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","watch",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watch_r4_3_5), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","watch",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watch_r4_3_6), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));

								// rename
								test(str_replace("%1","watch",$lang["AlterTable"]), @mysqli_query($dblink, $rename_watch_r4_3), str_replace("%1", "watch", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","rating",$lang["CreatingTable"]), @mysqli_query($dblink, $table_rating_r4_3), str_replace("%1", "rating", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","referrer",$lang["AlterTable"]), @mysqli_query($dblink, $alter_referrer_r4_3), str_replace("%1", "referrer", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","referrer",$lang["AlterTable"]), @mysqli_query($dblink, $alter_referrer_r4_3_1), str_replace("%1", "referrer", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_3), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_4), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_5), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_6), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_7), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_8), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_9), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_10), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_13), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","revision",$lang["UpdateTable"]), @mysqli_query($dblink, $update_revision_r4_3), str_replace("%1", "revision", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","revision",$lang["UpdateTable"]), @mysqli_query($dblink, $update_revision_r4_3_1), str_replace("%1", "revision", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","revision",$lang["UpdateTable"]), @mysqli_query($dblink, $update_revision_r4_3_2), str_replace("%1", "revision", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","revision",$lang["UpdateTable"]), @mysqli_query($dblink, $update_revision_r4_3_3), str_replace("%1", "revision", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","revision",$lang["UpdateTable"]), @mysqli_query($dblink, $update_revision_r4_3_4), str_replace("%1", "revision", $lang["ErrorUpdatingTable"]));

								// drop last!
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_11), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_12), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_14), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_15), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_16), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_17), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_18), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revision_r4_3_19), str_replace("%1", "revision", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","upload",$lang["AlterTable"]), @mysqli_query($dblink, $alter_upload_r4_3), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","upload",$lang["UpdateTable"]), @mysqli_query($dblink, $update_upload_r4_3), str_replace("%1", "upload", $lang["ErrorUpdatingTable"]));
								// drop last!
								test(str_replace("%1","upload",$lang["AlterTable"]), @mysqli_query($dblink, $alter_upload_r4_3_1), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","upload",$lang["AlterTable"]), @mysqli_query($dblink, $alter_upload_r4_3_2), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));

								// inserting config values
								test($lang["InstallingConfigValues"], @mysqli_query($dblink, $insert_config), str_replace("%1","config values",$lang["ErrorAlreadyExists"]));

						}
						print("         </ul>\n");
					}
					break;
							default:
								$dsn = "";
								switch($config["database_driver"])
								{
									case "firebird":
										$dsn = $config["database_driver"].":dbname=".$config["database_host"].":".$config["database_database"].($config["database_port"] != "" ? ";port=".$config["database_port"] : "");
										break;
									case "ibm":
										$dsn = $config["database_driver"].":DATABASE=".$config["database_host"].";HOSTNAME=".$config["database_database"].($config["database_port"] != "" ? ";PORT=".$config["database_port"] : "");
										break;
									case "informix":
										$dsn = $config["database_driver"].":database=".$config["database_host"].";host=".$config["database_database"].($config["database_port"] != "" ? ";service=".$config["database_port"] : "");
										break;
									case "oci":
										require_once("setup/database_oracle.php");
										$dsn = $config["database_driver"].":dbname=".$config["database_database"];
										break;
									case "sqlite":
									case "sqlite2":
									case "mysql":
										require_once("setup/database_mysql.php");
										$dsn = $config["database_driver"].":dbname=".$config["database_database"].";host=".$config["database_host"].($config["database_port"] != "" ? ";port=".$config["database_port"] : "");
										break;
									case "mssql":
										require_once("setup/database_mysql.php");
										$dsn = $config["database_driver"].":host=".$config["database_host"].($config["database_port"] != "" ? ",".$config["database_port"] : "").";dbname=".$config["database_database"];
										print($dsn);
										break;
									case "pgsql":
										require_once("setup/database_pgsql.php");
										$dsn = $config["database_driver"].":dbname=".$config["database_database"].";host=".$config["database_host"].($config["database_port"] != "" ? ";port=".$config["database_port"] : "");
										break;
								}

								print("         <ul>\n");
								/*
									PHP4 doesn't support try/catch blocks so we put the PDO code in a seperate file.
									Since we don't support PDO in PHP4 they can never come down this route without PHP5.
									i.e. they don't see this as a selection on the previous page.
								*/
								require_once("setup/database-install-pdo.php");
								print("         </ul>\n");
								print("         <br />\n");

								if(!$fatal_error)
								{
									if ($config["DeleteTables"] == "on")
									{
										print("<h2>".$lang["DeletingTables"]."</h2>\n");
										print("            <ul>\n");
										testPDO(str_replace("%1", "acl", $lang["DeletingTable"]), $table_acl_drop, str_replace("%1", "acl", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "bookmark", $lang["DeletingTable"]), $table_bookmark_drop, str_replace("%1", "bookmark", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "cache", $lang["DeletingTable"]), $table_cache_drop, str_replace("%1", "cache", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "config", $lang["DeletingTable"]), $table_config_drop, str_replace("%1", "config", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "group", $lang["DeletingTable"]), $table_group_drop, str_replace("%1", "group", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "group_member", $lang["DeletingTable"]), $table_group_member_drop, str_replace("%1", "group_member", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "category", $lang["DeletingTable"]), $table_category_drop, str_replace("%1", "category", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "category_page", $lang["DeletingTable"]), $table_category_page_drop, str_replace("%1", "category_page", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "link", $lang["DeletingTable"]), $table_link_drop, str_replace("%1", "link", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "log", $lang["DeletingTable"]), $table_log_drop, str_replace("%1", "log", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "page", $lang["DeletingTable"]), $table_page_drop, str_replace("%1", "page", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "poll", $lang["DeletingTable"]), $table_poll_drop, str_replace("%1", "poll", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "rating", $lang["DeletingTable"]), $table_rating_drop, str_replace("%1", "rating", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "referrer", $lang["DeletingTable"]), $table_referrer_drop, str_replace("%1", "referrer", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "revision", $lang["DeletingTable"]), $table_revision_drop, str_replace("%1", "revision", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "upload", $lang["DeletingTable"]), $table_upload_drop, str_replace("%1", "upload", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "user", $lang["DeletingTable"]), $table_user_drop, str_replace("%1", "user", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "user_setting", $lang["DeletingTable"]), $table_user_setting_drop, str_replace("%1", "user_setting", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "watch", $lang["DeletingTable"]), $table_watch_drop, str_replace("%1", "watch", $lang["ErrorDeletingTable"]));
										print("            <li>".$lang["DeletingTablesEnd"]."</li>\n");
										print("         </ul>\n");
										print("         <br />\n");
									}

									// No need to check the past versions since PDO SQL is only officially supported in this release (v4.3)
									print("         <h2>".$lang["InstallingTables"]."</h2>\n");
									print("         <ul>\n");
									testPDO(str_replace("%1","acl",$lang["CreatingTable"]), $table_acl, str_replace("%1","acl",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","bookmark",$lang["CreatingTable"]), $table_bookmark, str_replace("%1","bookmark",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","cache",$lang["CreatingTable"]), $table_cache, str_replace("%1","cache",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","config",$lang["CreatingTable"]), $table_config, str_replace("%1","config",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","group",$lang["CreatingTable"]), $table_group, str_replace("%1","group",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","group_member",$lang["CreatingTable"]), $table_group_member, str_replace("%1","group_member",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","category",$lang["CreatingTable"]), $table_category, str_replace("%1","category",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","category_page",$lang["CreatingTable"]), $table_category_page, str_replace("%1","category_page",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","link",$lang["CreatingTable"]), $table_link, str_replace("%1","link",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","log",$lang["CreatingTable"]), $table_log, str_replace("%1","log",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","page",$lang["CreatingTable"]), $table_page, str_replace("%1","page",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","poll",$lang["CreatingTable"]), $table_poll, str_replace("%1","poll",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","rating",$lang["CreatingTable"]), $table_rating, str_replace("%1","rating",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","referrer",$lang["CreatingTable"]), $table_referrer, str_replace("%1","referrer",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","revision",$lang["CreatingTable"]), $table_revision, str_replace("%1","revision",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","upload",$lang["CreatingTable"]), $table_upload, str_replace("%1","upload",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","user",$lang["CreatingTable"]), $table_user, str_replace("%1","user",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","user_setting",$lang["CreatingTable"]), $table_user_setting, str_replace("%1","user_setting",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","watch",$lang["CreatingTable"]), $table_watch, str_replace("%1","watch",$lang["ErrorCreatingTable"]));

									testPDO($lang["InstallingAdmin"], $insert_admin, str_replace("%1","admin user",$lang["ErrorAlreadyExists"]));
									testPDO($lang["InstallingAdminSetting"], $insert_admin_setting, str_replace("%1","admin user settings",$lang["ErrorAlreadyExists"]));
									testPDO($lang["InstallingAdminGroup"], $insert_admin_group, str_replace("%1","admin group",$lang["ErrorAlreadyExists"]));
									testPDO($lang["InstallingAdminGroupMember"], $insert_admin_group_member, str_replace("%1","admin group member",$lang["ErrorAlreadyExists"]));
									print("         </ul>\n");
									print("         <br />\n");
									print("         <h2>".$lang["InstallingDefaultData"]."</h2>\n");
									print("         <ul>\n");
									print("            <li>".$lang["InstallingPagesBegin"]);
									require_once("setup/inserts.php");
									print("</li>\n");
									print("            <li>".$lang["InstallingPagesEnd"]."</li>\n");

									testPDO($lang["InstallingLogoImage"], $insert_logo_image, str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));
									testPDO($lang["InstallingConfigValues"], $insert_config, str_replace("%1","config values",$lang["ErrorAlreadyExists"]));
									print("         </ul>\n");
								}
								break;
}

if(!$fatal_error)
{
?>
<p><?php echo $lang["NextStep"];?></p>
<form action="<?php echo myLocation(); ?>?installAction=write-config" method="post">
<?php
	writeConfigHiddenNodes(array('DeleteTables' => ''));
?>
	<input type="submit" value="<?php echo $lang["Continue"];?>" class="next" />
</form>
<?php
}
else
{
?>
<input type="submit" value="<?php echo $lang["Back"];?>" class="next" onclick="javascript: history.go(-1);" />
<input type="button" value="<?php echo $lang["TryAgain"];?>" class="next" onClick="window.location.reload( true );" />
<?php
}
?>