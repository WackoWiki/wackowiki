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

// test configuration
print("         <h2>".$lang["TestingConfiguration"]."</h2>\n");

// Generic Default Inserts
$insert_admin = "INSERT INTO ".$config["table_prefix"]."users (user_name, password, email, signuptime, lang) VALUES ('".$config["admin_name"]."', md5('".$_POST["password"]."'), '".$config["admin_email"]."', NOW(), '".$config["language"]."')";
// TODO: for Upgrade insert other aliases also in groups table
// $config["aliases"] = array("Admins" => $config["admin_name"]);
$insert_admin_group = "INSERT INTO ".$config["table_prefix"]."groups (group_name, description, moderator, members, created) VALUES ('Admins', '', '".$config["admin_email"]."', '".$config["admin_name"]."', NOW())";

$insert_logo_image = "INSERT INTO ".$config["table_prefix"]."upload (page_id, user_id, filename, description, uploaded_dt, filesize, picture_w, picture_h, file_ext) VALUES ('0', (SELECT user_id FROM ".$config["table_prefix"]."users WHERE user_name = '".$config["admin_name"]."' LIMIT 1),'wacko4.gif', 'WackoWiki', NOW(), '1580', '108', '50', 'gif')";
$insert_config = "INSERT INTO ".$config["table_prefix"]."config (config_id, config_name, value) VALUES
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
					test(str_replace("%1", "page", $lang["DeletingTable"]), @mysql_query($table_pages_drop, $dblink), str_replace("%1", "page", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "revision", $lang["DeletingTable"]), @mysql_query($table_revisions_drop, $dblink), str_replace("%1", "revision", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "acl", $lang["DeletingTable"]), @mysql_query($table_acls_drop, $dblink), str_replace("%1", "acl", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "link tracking", $lang["DeletingTable"]), @mysql_query($table_links_drop, $dblink), str_replace("%1", "link", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "referrer", $lang["DeletingTable"]), @mysql_query($table_referrers_drop, $dblink), str_replace("%1", "referrer", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "user", $lang["DeletingTable"]), @mysql_query($table_users_drop, $dblink), str_replace("%1", "user", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "watches", $lang["DeletingTable"]), @mysql_query($table_watches_drop, $dblink), str_replace("%1", "watches", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "upload", $lang["DeletingTable"]), @mysql_query($table_upload_drop, $dblink), str_replace("%1", "upload", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "cache", $lang["DeletingTable"]), @mysql_query($table_cache_drop, $dblink), str_replace("%1", "cache", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "log", $lang["DeletingTable"]), @mysql_query($table_log_drop, $dblink), str_replace("%1", "log", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "groups", $lang["DeletingTable"]), @mysql_query($table_groups_drop, $dblink), str_replace("%1", "groups", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "rating", $lang["DeletingTable"]), @mysql_query($table_rating_drop, $dblink), str_replace("%1", "rating", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "config", $lang["DeletingTable"]), @mysql_query($table_config_drop, $dblink), str_replace("%1", "config", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "keywords", $lang["DeletingTable"]), @mysql_query($table_keywords_drop, $dblink), str_replace("%1", "keywords", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "keywords_pages", $lang["DeletingTable"]), @mysql_query($table_keywords_pages_drop, $dblink), str_replace("%1", "keywords_pages", $lang["ErrorDeletingTable"]));
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
					test(str_replace("%1","page",$lang["CreatingTable"]), @mysql_query($table_pages, $dblink), str_replace("%1","page",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","revision",$lang["CreatingTable"]), @mysql_query($table_revisions, $dblink), str_replace("%1","revision",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","acl",$lang["CreatingTable"]), @mysql_query($table_acls, $dblink), str_replace("%1","acl",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","link tracking",$lang["CreatingTable"]), @mysql_query($table_links, $dblink), str_replace("%1","link",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","referrer",$lang["CreatingTable"]), @mysql_query($table_referrers, $dblink), str_replace("%1","referrer",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","user",$lang["CreatingTable"]), @mysql_query($table_users, $dblink), str_replace("%1","user",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","watches",$lang["CreatingTable"]), @mysql_query($table_watches, $dblink), str_replace("%1","watches",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","upload",$lang["CreatingTable"]), @mysql_query($table_upload, $dblink), str_replace("%1","upload",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","cache",$lang["CreatingTable"]), @mysql_query($table_cache, $dblink), str_replace("%1","cache",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","log",$lang["CreatingTable"]), @mysql_query($table_log, $dblink), str_replace("%1","log",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","groups",$lang["CreatingTable"]), @mysql_query($table_groups, $dblink), str_replace("%1","groups",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","rating",$lang["CreatingTable"]), @mysql_query($table_rating, $dblink), str_replace("%1","rating",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","config",$lang["CreatingTable"]), @mysql_query($table_config, $dblink), str_replace("%1","config",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","keywords",$lang["CreatingTable"]), @mysql_query($table_keywords, $dblink), str_replace("%1","keywords",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","keywords_pages",$lang["CreatingTable"]), @mysql_query($table_keywords_pages, $dblink), str_replace("%1","keywords_pages",$lang["ErrorCreatingTable"]));

					test($lang["InstallingAdmin"], @mysql_query($insert_admin, $dblink), str_replace("%1","admin user",$lang["ErrorAlreadyExists"]));
					test($lang["InstallingAdminGroup"], @mysql_query($insert_admin_group, $dblink), str_replace("%1","admin group",$lang["ErrorAlreadyExists"]));
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

				//from R4.2 to R4.3.rc1
				case "R4.2":
					print("         <h2>Wacko R4.2 ".$lang["To"]." R4.3.rc1</h2>\n");
					print("         <ul>\n");

					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_1, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_2, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_1, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_2, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));

					test($lang["InstallingLogoImage"], @mysql_query($insert_logo_image, $dblink), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));

				//from R4.3.rc1 to R4.3.rc2
				case "R4.3":
					print("         <h2>Wacko R4.3.rc1 ".$lang["To"]." R4.3.rc2</h2>\n");
					print("         <ul>\n");
					// ! new user_id first
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_1, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_2, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_3, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_4, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_5, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_6, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_7, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_8, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_9, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_10, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_11, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_12, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_13, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","users",$lang["UpdateTable"]), @mysql_query($update_users_r4_2, $dblink), str_replace("%1", "users", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","users",$lang["UpdateTable"]), @mysql_query($update_users_r4_2_1, $dblink), str_replace("%1", "users", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","users",$lang["UpdateTable"]), @mysql_query($update_users_r4_2_2, $dblink), str_replace("%1", "users", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","users",$lang["UpdateTable"]), @mysql_query($update_users_r4_2_4, $dblink), str_replace("%1", "users", $lang["ErrorUpdatingTable"]));

					// rename id after upate!
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_14, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_15, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","acls",$lang["AlterTable"]), @mysql_query($alter_acls_r4_2, $dblink), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","acls",$lang["AlterTable"]), @mysql_query($alter_acls_r4_2_1, $dblink), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","acls",$lang["UpdateTable"]), @mysql_query($update_acls_r4_2, $dblink), str_replace("%1", "acls", $lang["ErrorUpdatingTable"]));

					// Drop obsolete fields
					test(str_replace("%1","acls",$lang["AlterTable"]), @mysql_query($alter_acls_r4_2_2, $dblink), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","acls",$lang["AlterTable"]), @mysql_query($alter_acls_r4_2_3, $dblink), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","acls",$lang["AlterTable"]), @mysql_query($alter_acls_r4_2_4, $dblink), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","acls",$lang["AlterTable"]), @mysql_query($alter_acls_r4_2_5, $dblink), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","cache",$lang["AlterTable"]), @mysql_query($alter_cache_r4_2, $dblink), str_replace("%1", "cache", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","config",$lang["CreatingTable"]), @mysql_query($table_config_r4_2, $dblink), str_replace("%1", "config", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","groups",$lang["CreatingTable"]), @mysql_query($table_groups_r4_2, $dblink), str_replace("%1", "groups", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","keywords",$lang["CreatingTable"]), @mysql_query($table_keywords_r4_2, $dblink), str_replace("%1", "keywords", $lang["ErrorCreatingTable"]));
					test(str_replace("%1","keywords_pages",$lang["CreatingTable"]), @mysql_query($table_keywords_pages_r4_2, $dblink), str_replace("%1", "keywords_pages", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r4_2, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r4_2_1, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r4_2_2, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","links",$lang["UpdateTable"]), @mysql_query($update_links_r4_2, $dblink), str_replace("%1", "links", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","links",$lang["UpdateTable"]), @mysql_query($update_links_r4_2_1, $dblink), str_replace("%1", "links", $lang["ErrorUpdatingTable"]));

					// drop last!
					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r4_2_3, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r4_2_4, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r4_2_5, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","log",$lang["CreatingTable"]), @mysql_query($table_log_r4_2, $dblink), str_replace("%1", "log", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_3, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_4, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_5, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_6, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_7, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_8, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_9, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_10, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_11, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","pages",$lang["UpdateTable"]), @mysql_query($update_pages_r4_2, $dblink), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","pages",$lang["UpdateTable"]), @mysql_query($update_pages_r4_2_1, $dblink), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","pages",$lang["UpdateTable"]), @mysql_query($update_pages_r4_2_2, $dblink), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","pages",$lang["UpdateTable"]), @mysql_query($update_pages_r4_2_3, $dblink), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","pages",$lang["UpdateTable"]), @mysql_query($update_pages_r4_2_4, $dblink), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","pages",$lang["UpdateTable"]), @mysql_query($update_pages_r4_2_5, $dblink), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","pages",$lang["UpdateTable"]), @mysql_query($update_pages_r4_2_6, $dblink), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","pages",$lang["UpdateTable"]), @mysql_query($update_pages_r4_2_7, $dblink), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));

					// drop last!
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_12, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_13, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_14, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_15, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_16, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_17, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_18, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_19, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_20, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_21, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","watches",$lang["AlterTable"]), @mysql_query($alter_watches_r4_2, $dblink), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","watches",$lang["AlterTable"]), @mysql_query($alter_watches_r4_2_1, $dblink), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","watches",$lang["AlterTable"]), @mysql_query($alter_watches_r4_2_2, $dblink), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","watches",$lang["UpdateTable"]), @mysql_query($update_watches_r4_2, $dblink), str_replace("%1", "watches", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","watches",$lang["UpdateTable"]), @mysql_query($update_watches_r4_2_1, $dblink), str_replace("%1", "watches", $lang["ErrorUpdatingTable"]));

					// drop last!
					test(str_replace("%1","watches",$lang["AlterTable"]), @mysql_query($alter_watches_r4_2_3, $dblink), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","watches",$lang["AlterTable"]), @mysql_query($alter_watches_r4_2_4, $dblink), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","watches",$lang["AlterTable"]), @mysql_query($alter_watches_r4_2_5, $dblink), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));

					// rename
					test(str_replace("%1","watches",$lang["AlterTable"]), @mysql_query($rename_watches_r4_2, $dblink), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","rating",$lang["CreatingTable"]), @mysql_query($table_rating_r4_2, $dblink), str_replace("%1", "rating", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","referrers",$lang["AlterTable"]), @mysql_query($alter_referrers_r4_2, $dblink), str_replace("%1", "referrers", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_3, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_4, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_5, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_6, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_7, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_8, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_9, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_10, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_13, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysql_query($update_revisions_r4_2, $dblink), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysql_query($update_revisions_r4_2_1, $dblink), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysql_query($update_revisions_r4_2_2, $dblink), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysql_query($update_revisions_r4_2_3, $dblink), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysql_query($update_revisions_r4_2_4, $dblink), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));

					// drop last!
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_11, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_12, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_14, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_15, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_16, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_17, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_18, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_19, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","upload",$lang["AlterTable"]), @mysql_query($alter_upload_r4_2, $dblink), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","upload",$lang["UpdateTable"]), @mysql_query($update_upload_r4_2, $dblink), str_replace("%1", "upload", $lang["ErrorUpdatingTable"]));

					// drop last!
					test(str_replace("%1","upload",$lang["AlterTable"]), @mysql_query($alter_upload_r4_2_1, $dblink), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","upload",$lang["AlterTable"]), @mysql_query($alter_upload_r4_2_2, $dblink), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));

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
							test(str_replace("%1", "page", $lang["DeletingTable"]), @mysqli_query($dblink, $table_pages_drop), str_replace("%1", "page", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "revision", $lang["DeletingTable"]), @mysqli_query($dblink, $table_revisions_drop), str_replace("%1", "revision", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "acl", $lang["DeletingTable"]), @mysqli_query($dblink, $table_acls_drop), str_replace("%1", "acl", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "link tracking", $lang["DeletingTable"]), @mysqli_query($dblink, $table_links_drop), str_replace("%1", "link", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "referrer", $lang["DeletingTable"]), @mysqli_query($dblink, $table_referrers_drop), str_replace("%1", "referrer", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "user", $lang["DeletingTable"]), @mysqli_query($dblink, $table_users_drop), str_replace("%1", "user", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "watches", $lang["DeletingTable"]), @mysqli_query($dblink, $table_watches_drop), str_replace("%1", "watches", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "upload", $lang["DeletingTable"]), @mysqli_query($dblink, $table_upload_drop), str_replace("%1", "upload", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "cache", $lang["DeletingTable"]), @mysqli_query($dblink, $table_cache_drop), str_replace("%1", "cache", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "log", $lang["DeletingTable"]), @mysqli_query($dblink, $table_log_drop), str_replace("%1", "log", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "groups", $lang["DeletingTable"]), @mysqli_query($dblink, $table_groups_drop), str_replace("%1", "groups", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "rating", $lang["DeletingTable"]), @mysqli_query($dblink, $table_rating_drop), str_replace("%1", "rating", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "config", $lang["DeletingTable"]), @mysqli_query($dblink, $table_config_drop), str_replace("%1", "config", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "keywords", $lang["DeletingTable"]), @mysqli_query($dblink, $table_keywords_drop), str_replace("%1", "keywords", $lang["ErrorDeletingTable"]));
							test(str_replace("%1", "keywords_pages", $lang["DeletingTable"]), @mysqli_query($dblink, $table_keywords_pages_drop), str_replace("%1", "keywords_pages", $lang["ErrorDeletingTable"]));
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
								test(str_replace("%1","page",$lang["CreatingTable"]), @mysqli_query($dblink, $table_pages), str_replace("%1","page",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","revision",$lang["CreatingTable"]), @mysqli_query($dblink, $table_revisions), str_replace("%1","revision",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","acl",$lang["CreatingTable"]), @mysqli_query($dblink, $table_acls), str_replace("%1","acl",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","link tracking",$lang["CreatingTable"]), @mysqli_query($dblink, $table_links), str_replace("%1","link",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","referrer",$lang["CreatingTable"]), @mysqli_query($dblink, $table_referrers), str_replace("%1","referrer",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","user",$lang["CreatingTable"]), @mysqli_query($dblink, $table_users), str_replace("%1","user",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","watches",$lang["CreatingTable"]), @mysqli_query($dblink, $table_watches), str_replace("%1","watches",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","upload",$lang["CreatingTable"]), @mysqli_query($dblink, $table_upload), str_replace("%1","upload",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","cache",$lang["CreatingTable"]), @mysqli_query($dblink, $table_cache), str_replace("%1","cache",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","log",$lang["CreatingTable"]), @mysqli_query($dblink, $table_log), str_replace("%1","log",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","groups",$lang["CreatingTable"]), @mysqli_query($dblink, $table_groups), str_replace("%1","groups",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","rating",$lang["CreatingTable"]), @mysqli_query($dblink, $table_rating), str_replace("%1","rating",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","config",$lang["CreatingTable"]), @mysqli_query($dblink, $table_config), str_replace("%1","config",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","keywords",$lang["CreatingTable"]), @mysqli_query($dblink, $table_keywords), str_replace("%1","keywords",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","keywords_pages",$lang["CreatingTable"]), @mysqli_query($dblink, $table_keywords_pages), str_replace("%1","keywords_pages",$lang["ErrorCreatingTable"]));

								test($lang["InstallingAdmin"], @mysqli_query($dblink, $insert_admin), str_replace("%1","admin user",$lang["ErrorAlreadyExists"]));
								test($lang["InstallingAdminGroup"], @mysqli_query($dblink, $insert_admin_group), str_replace("%1","admin group",$lang["ErrorAlreadyExists"]));
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

							//from R4.2 to R4.3.rc1
							case "R4.2":
								print("         <h2>Wacko R4.2 ".$lang["To"]." R4.3.rc1</h2>\n");
								print("         <ul>\n");

								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_1), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_2), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_2), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_3), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));

								test($lang["InstallingLogoImage"], @mysqli_query($dblink, $insert_logo_image), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));

							//from R4.3.rc1 to R4.3.rc2
							case "R4.3":
								print("         <h2>Wacko R4.3.rc1 ".$lang["To"]." R4.3.rc2</h2>\n");
								print("         <ul>\n");

								// ! new user_id first
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_1), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_2), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_3), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_4), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_5), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_6), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_7), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_8), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_9), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_10), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_11), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_12), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_13), str_replace("%1", "users", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","users",$lang["UpdateTable"]), @mysqli_query($dblink, $update_users_r4_2), str_replace("%1", "users", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","users",$lang["UpdateTable"]), @mysqli_query($dblink, $update_users_r4_2_1), str_replace("%1", "users", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","users",$lang["UpdateTable"]), @mysqli_query($dblink, $update_users_r4_2_2), str_replace("%1", "users", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","users",$lang["UpdateTable"]), @mysqli_query($dblink, $update_users_r4_2_4), str_replace("%1", "users", $lang["ErrorUpdatingTable"]));

								// rename id after upate!
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_14), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_15), str_replace("%1", "users", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","acls",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acls_r4_2), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","acls",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acls_r4_2_1), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","acls",$lang["UpdateTable"]), @mysqli_query($dblink, $update_acls_r4_2), str_replace("%1", "acls", $lang["ErrorUpdatingTable"]));

								// Drop obsolete fields
								test(str_replace("%1","acls",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acls_r4_2_2), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","acls",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acls_r4_2_3), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","acls",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acls_r4_2_4), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","acls",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acls_r4_2_5), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","cache",$lang["AlterTable"]), @mysqli_query($dblink, $alter_cache_r4_2), str_replace("%1", "cache", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","config",$lang["CreatingTable"]), @mysqli_query($dblink, $table_config_r4_2), str_replace("%1", "config", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","groups",$lang["CreatingTable"]), @mysqli_query($dblink, $table_groups_r4_2), str_replace("%1", "groups", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","keywords",$lang["CreatingTable"]), @mysqli_query($dblink, $table_keywords_r4_2), str_replace("%1", "keywords", $lang["ErrorCreatingTable"]));
								test(str_replace("%1","keywords_pages",$lang["CreatingTable"]), @mysqli_query($dblink, $table_keywords_pages_r4_2), str_replace("%1", "keywords_pages", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r4_2), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r4_2_1), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r4_2_2), str_replace("%1", "links", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","links",$lang["UpdateTable"]), @mysqli_query($dblink, $update_links_r4_2), str_replace("%1", "links", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","links",$lang["UpdateTable"]), @mysqli_query($dblink, $update_links_r4_2_1), str_replace("%1", "links", $lang["ErrorUpdatingTable"]));

								// drop last!
								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r4_2_3), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r4_2_4), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r4_2_5), str_replace("%1", "links", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","log",$lang["CreatingTable"]), @mysqli_query($dblink, $table_log_r4_2), str_replace("%1", "log", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_3), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_4), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_5), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_6), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_7), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_8), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_9), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_10), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_11), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","pages",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pages_r4_2), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","pages",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pages_r4_2_1), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","pages",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pages_r4_2_2), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","pages",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pages_r4_2_3), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","pages",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pages_r4_2_4), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","pages",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pages_r4_2_5), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","pages",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pages_r4_2_6), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","pages",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pages_r4_2_7), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));

								// drop last!
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_12), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_13), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_14), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_15), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_16), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_17), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_18), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_19), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_20), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_21), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","watches",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watches_r4_2), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","watches",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watches_r4_2_1), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","watches",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watches_r4_2_2), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","watches",$lang["UpdateTable"]), @mysqli_query($dblink, $update_watches_r4_2), str_replace("%1", "watches", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","watches",$lang["UpdateTable"]), @mysqli_query($dblink, $update_watches_r4_2_1), str_replace("%1", "watches", $lang["ErrorUpdatingTable"]));

								// drop last!
								test(str_replace("%1","watches",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watches_r4_2_3), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","watches",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watches_r4_2_4), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","watches",$lang["AlterTable"]), @mysqli_query($dblink, $alter_watches_r4_2_5), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));

								// rename
								test(str_replace("%1","watches",$lang["AlterTable"]), @mysqli_query($dblink, $rename_watches_r4_2), str_replace("%1", "watches", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","rating",$lang["CreatingTable"]), @mysqli_query($dblink, $table_rating_r4_2), str_replace("%1", "rating", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","referrers",$lang["AlterTable"]), @mysqli_query($dblink, $alter_referrers_r4_2), str_replace("%1", "referrers", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_3), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_4), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_5), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_6), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_7), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_8), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_9), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_10), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_13), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysqli_query($dblink, $update_revisions_r4_2), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysqli_query($dblink, $update_revisions_r4_2_1), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysqli_query($dblink, $update_revisions_r4_2_2), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysqli_query($dblink, $update_revisions_r4_2_3), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysqli_query($dblink, $update_revisions_r4_2_4), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));

								// drop last!
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_11), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_12), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_14), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_15), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_16), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_17), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_18), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_19), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","upload",$lang["AlterTable"]), @mysqli_query($dblink, $alter_upload_r4_2), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","upload",$lang["UpdateTable"]), @mysqli_query($dblink, $update_upload_r4_2), str_replace("%1", "upload", $lang["ErrorUpdatingTable"]));
								// drop last!
								test(str_replace("%1","upload",$lang["AlterTable"]), @mysqli_query($dblink, $alter_upload_r4_2_1), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","upload",$lang["AlterTable"]), @mysqli_query($dblink, $alter_upload_r4_2_2), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));

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
										$dsn = $config["database_driver"].":dbname=//".$config["database_host"].($config["database_port"] != "" ? ":".$config["database_port"] : "")."/".$config["database_database"];
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
										testPDO(str_replace("%1", "page", $lang["DeletingTable"]), $table_pages_drop, str_replace("%1", "page", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "revision", $lang["DeletingTable"]), $table_revisions_drop, str_replace("%1", "revision", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "acl", $lang["DeletingTable"]), $table_acls_drop, str_replace("%1", "acl", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "link tracking", $lang["DeletingTable"]), $table_links_drop, str_replace("%1", "link", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "referrer", $lang["DeletingTable"]), $table_referrers_drop, str_replace("%1", "referrer", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "user", $lang["DeletingTable"]), $table_users_drop, str_replace("%1", "user", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "watches", $lang["DeletingTable"]), $table_watches_drop, str_replace("%1", "watches", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "upload", $lang["DeletingTable"]), $table_upload_drop, str_replace("%1", "upload", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "cache", $lang["DeletingTable"]), $table_cache_drop, str_replace("%1", "cache", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "log", $lang["DeletingTable"]), $table_log_drop, str_replace("%1", "log", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "groups", $lang["DeletingTable"]), $table_groups_drop, str_replace("%1", "groups", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "rating", $lang["DeletingTable"]), $table_rating_drop, str_replace("%1", "rating", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "config", $lang["DeletingTable"]), $table_config_drop, str_replace("%1", "config", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "keywords", $lang["DeletingTable"]), $table_keywords_drop, str_replace("%1", "keywords", $lang["ErrorDeletingTable"]));
										testPDO(str_replace("%1", "keywords_pages", $lang["DeletingTable"]), $table_keywords_pages_drop, str_replace("%1", "keywords_pages", $lang["ErrorDeletingTable"]));

										print("            <li>".$lang["DeletingTablesEnd"]."</li>\n");
										print("         </ul>\n");
										print("         <br />\n");
									}

									// No need to check the past versions since PDO SQL is only officially supported in this release (v4.3)
									print("         <h2>".$lang["InstallingTables"]."</h2>\n");
									print("         <ul>\n");
									testPDO(str_replace("%1","page",$lang["CreatingTable"]), $table_pages, str_replace("%1","page",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","revision",$lang["CreatingTable"]), $table_revisions, str_replace("%1","revision",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","acl",$lang["CreatingTable"]), $table_acls, str_replace("%1","acl",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","link tracking",$lang["CreatingTable"]), $table_links, str_replace("%1","link",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","referrer",$lang["CreatingTable"]), $table_referrers, str_replace("%1","referrer",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","user",$lang["CreatingTable"]), $table_users, str_replace("%1","user",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","watches",$lang["CreatingTable"]), $table_watches, str_replace("%1","watches",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","upload",$lang["CreatingTable"]), $table_upload, str_replace("%1","upload",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","cache",$lang["CreatingTable"]), $table_cache, str_replace("%1","cache",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","log",$lang["CreatingTable"]), $table_log, str_replace("%1","log",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","groups",$lang["CreatingTable"]), $table_groups, str_replace("%1","groups",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","rating",$lang["CreatingTable"]), $table_rating, str_replace("%1","rating",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","config",$lang["CreatingTable"]), $table_config, str_replace("%1","config",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","keywords",$lang["CreatingTable"]), $table_keywords, str_replace("%1","keywords",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","keywords_pages",$lang["CreatingTable"]), $table_keywords_pages, str_replace("%1","keywords_pages",$lang["ErrorCreatingTable"]));

									testPDO($lang["InstallingAdmin"], $insert_admin, str_replace("%1","admin user",$lang["ErrorAlreadyExists"]));
									testPDO($lang["InstallingAdminGroup"], $insert_admin_group, str_replace("%1","admin group",$lang["ErrorAlreadyExists"]));
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