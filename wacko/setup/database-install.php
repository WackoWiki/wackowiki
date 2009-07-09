<?php
@set_time_limit(0);
@ignore_user_abort(true);

function test($text, $condition, $errorText = "")
   {
      global $lang;
      print("            <li>".$text." - ".output_image($condition));

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
$insert_admin = "INSERT INTO ".$config["table_prefix"]."users (name, password, email, signuptime, lang) VALUES ('".$config["admin_name"]."', md5('".$_POST["password"]."'), '".$config["admin_email"]."', NOW(), '".$config["language"]."')";
// TODO: user table lookup user_id WHERE name = '".$config["admin_name"]."'
$insert_logo_image = "INSERT INTO ".$config["table_prefix"]."upload (page_id, user_id, filename, description, uploaded_dt, filesize, picture_w, picture_h, file_ext) VALUES ('0', '1','wacko4.gif', 'WackoWiki', NOW(), '1580', '108', '50', 'gif')";

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

			if ( !isset ( $config["wakka_version"] ) ) $config["wakka_version"] = "";
			if (!$version = trim($config["wakka_version"])) $version = "0";
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
					test(str_replace("%1", "watches", $lang["DeletingTable"]), @mysql_query($table_pagewatches_drop, $dblink), str_replace("%1", "watches", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "upload", $lang["DeletingTable"]), @mysql_query($table_upload_drop, $dblink), str_replace("%1", "upload", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "cache", $lang["DeletingTable"]), @mysql_query($table_cache_drop, $dblink), str_replace("%1", "cache", $lang["ErrorDeletingTable"]));
					test(str_replace("%1", "log", $lang["DeletingTable"]), @mysql_query($table_log_drop, $dblink), str_replace("%1", "log", $lang["ErrorDeletingTable"]));
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
					test(str_replace("%1","watches",$lang["CreatingTable"]), @mysql_query($table_pagewatches, $dblink), str_replace("%1","watches",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","upload",$lang["CreatingTable"]), @mysql_query($table_upload, $dblink), str_replace("%1","upload",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","cache",$lang["CreatingTable"]), @mysql_query($table_cache, $dblink), str_replace("%1","cache",$lang["ErrorCreatingTable"]));
					print("            </ul>\n");
					print("            <br />\n");
					print("            <h2>".$lang["InstallingDefaultData"]."</h2>\n");
					print("            <ul>\n");
					print("               <li>".$lang["InstallingPagesBegin"]);
					require_once("setup/inserts.php");
					print("</li>\n");
					print("            <li>".$lang["InstallingPagesEnd"]."</li>\n");
					test($lang["InstallingAdmin"], @mysql_query($insert_admin, $dblink), str_replace("%1","admin user",$lang["ErrorAlreadyExists"]));
					test($lang["InstallingLogoImage"], @mysql_query($insert_logo_image, $dblink), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));
					break;

					/*
					 The funny upgrading stuff. Make sure these are in order!
					 And yes, there are no (switch) breaks here. This is on purpose.
					 */

				// from 0.1 to 0.1.1
				case "0.1":
					print("         <h2>0.1 ".$lang["To"]." 0.1.1</h2>\n");
					print("         <ul>\n");
					test(str_replace("%1", "pages", $lang["AlterTable"]), @mysql_query($alter_pages_r0_1, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));

				// from 0.1.1 to 0.1.2
				case "0.1.1":
					print("         <h2>0.1.1 ".$lang["To"]." 0.1.2</h2>\n");
					print("         <ul>\n");
					test($lang["0.1.1"], 1);

				// from Wakka 0.1.2 or Wacko R1
				case "0.1.2":
				case "0.1.3-dev":
					print("         <h2>0.1.2 ".$lang["To"]." Wacko R2</h2>\n");
					print("         <ul>\n");
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r0_1, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","watches",$lang["CreatingTable"]), @mysql_query($table_pagewatches_r0, $dblink), str_replace("%1","watches",$lang["ErrorCreatingTable"]));

				// from Wacko R2
				case "R2":
					print("         <h2>Wacko R2 ".$lang["To"]." R3</h2>\n");
					print("         <ul>\n");
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r2_1, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r2_1, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","acls",$lang["AlterTable"]), @mysql_query($alter_acls_r2_1, $dblink), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r2_1, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","referrers",$lang["AlterTable"]), @mysql_query($alter_referrers_r2_1, $dblink), str_replace("%1", "referrers", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","watches",$lang["AlterTable"]), @mysql_query($alter_pagewatches_r2_1, $dblink), str_replace("%1", "pagewatches", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revision",$lang["CreatingTable"]), @mysql_query($table_revisions_r2, $dblink), str_replace("%1","revisions",$lang["ErrorCreatingTable"]));
					test($lang["MovingRevisions"], @mysql_query($insert_revisions_r2_1, $dblink), $lang["ErrorMovingRevisions"]);
					test(str_replace("%1", "pages", $lang["AlterTable"]), @mysql_query($alter_pages_r2_2, $dblink), $lang["CleanupScript"]);
					print("         </ul>\n");
					print("         <br />\n");
					print("         <h2>".$lang["InstallingDefaultData"]."</h2>\n");
					print("         <ul>\n");
					print("            <li>".$lang["InstallingPagesBegin"]);
					require_once("setup/inserts.php");
					print("</li>\n");
					print("            <li>".$lang["InstallingPagesEnd"]."</li>\n");

				// from Wacko R3
				case "R3":
					print("         <h2>Wacko R3/3.5 ".$lang["To"]." R4</h2>\n");
					print("         <ul>\n");
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r3_1, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r3_2, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r3_3, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r3_1, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r3_2, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r3_3, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r3_4, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r3_5, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r3_6, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r3_1, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r3_2, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r3_3, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","acls",$lang["AlterTable"]), @mysql_query($alter_acls_r3_1, $dblink), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","pagewatches",$lang["AlterTable"]), @mysql_query($alter_pagewatches_r3_1, $dblink), str_replace("%1", "pagewatches", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","referrers",$lang["AlterTable"]), @mysql_query($alter_referrers_r3_1, $dblink), str_replace("%1", "referrers", $lang["ErrorAlteringTable"]));

					@mysql_query($alter_pages_r3_1, $dblink);
					@mysql_query($alter_pages_r3_2, $dblink);
					@mysql_query($alter_pages_r3_3, $dblink);

					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r3_4, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r3_5, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r3_6, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r3_7, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r3_8, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r3_9, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r3_10, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r3_11, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r3_12, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","upload",$lang["CreatingTable"]), @mysql_query($table_upload, $dblink), str_replace("%1","upload",$lang["ErrorCreatingTable"]));

					test("", @mysql_query($update_pages_r3_1, $dblink), "");
					test("", @mysql_query($update_pages_r3_2, $dblink), "");

				//from R4 beta
				case "R4":
					print("         <h2>Wacko R4 beta ".$lang["To"]." R4 RC1</h2>\n");
					print("         <ul>\n");
					test(str_replace("%1","cache",$lang["CreatingTable"]), @mysql_query($table_cache, $dblink), str_replace("%1","cache",$lang["ErrorCreatingTable"]));

				//from R4 release candidat
				case "R4 RC1":
					print("         <h2>Wacko R4 RC1 ".$lang["To"]." R4.0</h2>\n");
					print("         <ul>\n");

				//from R4.0 to R4.2
				case "R4.0":
					print("         <h2>Wacko R4.0 ".$lang["To"]." R4.2</h2>\n");
					print("         <ul>\n");

				//from R4.2 to R4.3
				case "R4.2":
					print("         <h2>Wacko R4.2 ".$lang["To"]." R4.3</h2>\n");
					print("         <ul>\n");
					// ! new user_id first
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","users",$lang["AlterTable"]), @mysql_query($alter_users_r4_2_1, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					
					test(str_replace("%1","acls",$lang["AlterTable"]), @mysql_query($alter_acls_r4_2, $dblink), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","acls",$lang["AlterTable"]), @mysql_query($alter_acls_r4_2_1, $dblink), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
					
					test(str_replace("%1","acls",$lang["UpdateTable"]), @mysql_query($update_acls_r4_2, $dblink), str_replace("%1", "acls", $lang["ErrorUpdatingTable"]));

					test(str_replace("%1","cache",$lang["AlterTable"]), @mysql_query($alter_cache_r4_2, $dblink), str_replace("%1", "cache", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r4_2, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r4_2_1, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","links",$lang["AlterTable"]), @mysql_query($alter_links_r4_2_2, $dblink), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","links",$lang["UpdateTable"]), @mysql_query($update_links_r4_2, $dblink), str_replace("%1", "links", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","links",$lang["UpdateTable"]), @mysql_query($update_links_r4_2_1, $dblink), str_replace("%1", "links", $lang["ErrorUpdatingTable"]));
					
					test(str_replace("%1","log",$lang["CreatingTable"]), @mysql_query($table_log_r4_2, $dblink), str_replace("%1", "log", $lang["ErrorCreatingTable"]));

					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_1, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_2, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_3, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_4, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_5, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_6, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_7, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_8, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_2_9, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","pages",$lang["UpdateTable"]), @mysql_query($update_pages_r4_2, $dblink), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","pages",$lang["UpdateTable"]), @mysql_query($update_pages_r4_2_1, $dblink), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","pages",$lang["UpdateTable"]), @mysql_query($update_pages_r4_2_2, $dblink), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));

					test(str_replace("%1","pagewatches",$lang["AlterTable"]), @mysql_query($alter_pagewatches_r4_2, $dblink), str_replace("%1", "pagewatches", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pagewatches",$lang["AlterTable"]), @mysql_query($alter_pagewatches_r4_2_1, $dblink), str_replace("%1", "pagewatches", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pagewatches",$lang["AlterTable"]), @mysql_query($alter_pagewatches_r4_2_2, $dblink), str_replace("%1", "pagewatches", $lang["ErrorAlteringTable"]));
					
					test(str_replace("%1","pagewatches",$lang["UpdateTable"]), @mysql_query($update_pagewatches_r4_2, $dblink), str_replace("%1", "pagewatches", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","pagewatches",$lang["UpdateTable"]), @mysql_query($update_pagewatches_r4_2_1, $dblink), str_replace("%1", "pagewatches", $lang["ErrorUpdatingTable"]));
					
					test(str_replace("%1","referrers",$lang["AlterTable"]), @mysql_query($alter_referrers_r4_2, $dblink), str_replace("%1", "referrers", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_1, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_2, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_3, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_4, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_5, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_6, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_2_7, $dblink), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));

					test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysql_query($update_revisions_r4_2, $dblink), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));
					test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysql_query($update_revisions_r4_2_1, $dblink), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));
					
					test(str_replace("%1","upload",$lang["AlterTable"]), @mysql_query($alter_upload_r4_2, $dblink), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));
					
					test(str_replace("%1","upload",$lang["UpdateTable"]), @mysql_query($update_upload_r4_2, $dblink), str_replace("%1", "upload", $lang["ErrorUpdatingTable"]));
					// !
					test(str_replace("%1","upload",$lang["AlterTable"]), @mysql_query($alter_upload_r4_2_1, $dblink), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));
					
					test($lang["InstallingLogoImage"], @mysql_query($insert_logo_image, $dblink), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));


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

                  if ( !isset( $config["wakka_version"] ) ) $config["wakka_version"] = "0";
                  if ( !isset( $config["wacko_version"] ) ) $config["wacko_version"] = "0";
						if (!$version = trim($config["wakka_version"])) $version = "0";
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
                        test(str_replace("%1", "watches", $lang["DeletingTable"]), @mysqli_query($dblink, $table_pagewatches_drop), str_replace("%1", "watches", $lang["ErrorDeletingTable"]));
                        test(str_replace("%1", "upload", $lang["DeletingTable"]), @mysqli_query($dblink, $table_upload_drop), str_replace("%1", "upload", $lang["ErrorDeletingTable"]));
                        test(str_replace("%1", "cache", $lang["DeletingTable"]), @mysqli_query($dblink, $table_cache_drop), str_replace("%1", "cache", $lang["ErrorDeletingTable"]));
                        test(str_replace("%1", "log", $lang["DeletingTable"]), @mysqli_query($dblink, $table_log_drop), str_replace("%1", "log", $lang["ErrorDeletingTable"]));
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
								test(str_replace("%1","watches",$lang["CreatingTable"]), @mysqli_query($dblink, $table_pagewatches), str_replace("%1","watches",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","upload",$lang["CreatingTable"]), @mysqli_query($dblink, $table_upload), str_replace("%1","upload",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","cache",$lang["CreatingTable"]), @mysqli_query($dblink, $table_cache), str_replace("%1","cache",$lang["ErrorCreatingTable"]));
								print("         </ul>\n");
								print("         <br />\n");
								print("         <h2>".$lang["InstallingDefaultData"]."</h2>\n");
								print("         <ul>\n");
								print("            <li>".$lang["InstallingPagesBegin"]);
								require_once("setup/inserts.php");
								print("</li>\n");
								print("            <li>".$lang["InstallingPagesEnd"]."</li>\n");
								test($lang["InstallingAdmin"], @mysqli_query($dblink, $insert_admin), str_replace("%1","admin user",$lang["ErrorAlreadyExists"]));
								test($lang["InstallingLogoImage"], @mysqli_query($dblink, $insert_logo_image), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));
								break;

								/*
								 The funny upgrading stuff. Make sure these are in order!
								 And yes, there are no (switch) breaks here. This is on purpose.
								 */

							// from 0.1 to 0.1.1
							case "0.1":
								print("         <h2>0.1 ".$lang["To"]." 0.1.1</h2>\n");
								print("         <ul>\n");
								test(str_replace("%1", "pages", $lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r0_1), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));

							// from 0.1.1 to 0.1.2
							case "0.1.1":
								print("         <h2>0.1.1 ".$lang["To"]." 0.1.2</h2>\n");
								print("         <ul>\n");
								test($lang["0.1.1"], 1);

							// from Wakka 0.1.2 or Wacko R1
							case "0.1.2":
							case "0.1.3-dev":
								print("         <h2>0.1.2 ".$lang["To"]." Wacko R2</h2>\n");
								print("         <ul>\n");
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r0_1), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","watches",$lang["CreatingTable"]), @mysqli_query($dblink, $table_pagewatches_r0), str_replace("%1","watches",$lang["ErrorCreatingTable"]));

							// from Wacko R2
							case "R2":
								print("         <h2>Wacko R2 ".$lang["To"]." R3</h2>\n");
								print("         <ul>\n");
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r2_1), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r2_1), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","acls",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acls_r2_1), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r2_1), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","referrers",$lang["AlterTable"]), @mysqli_query($dblink, $alter_referrers_r2_1), str_replace("%1", "referrers", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","watches",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pagewatches_r2_1), str_replace("%1", "pagewatches", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revision",$lang["CreatingTable"]), @mysqli_query($dblink, $table_revisions_r2), str_replace("%1","revision",$lang["ErrorCreatingTable"]));
								test($lang["MovingRevisions"], @mysqli_query($dblink, $insert_revisions_r2_1), $lang["ErrorMovingRevisions"]);
								test(str_replace("%1", "pages", $lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r2_2), $lang["CleanupScript"]);
								print("         </ul>\n");
								print("         <br />\n");
								print("         <h2>".$lang["InstallingDefaultData"]."</h2>\n");
								print("         <ul>\n");
								print("            <li>".$lang["InstallingPagesBegin"]);
								require_once("setup/inserts.php");
								print("</li>\n");
								print("            <li>".$lang["InstallingPagesEnd"]."</li>\n");

							// from Wacko R3
							case "R3":
								print("         <h2>Wacko R3/3.5 ".$lang["To"]." R4</h2>\n");
								print("         <ul>\n");
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r3_1), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r3_2), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r3_3), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r3_1), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r3_2), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r3_3), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r3_4), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r3_5), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r3_6), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r3_1), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r3_2), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r3_3), str_replace("%1", "links", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","acls",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acls_r3_1), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","pagewatches",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pagewatches_r3_1), str_replace("%1", "pagewatches", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","referrers",$lang["AlterTable"]), @mysqli_query($dblink, $alter_referrers_r3_1), str_replace("%1", "referrers", $lang["ErrorAlteringTable"]));

								@mysqli_query($dblink, $alter_pages_r3_1);
								@mysqli_query($dblink, $alter_pages_r3_2);
								@mysqli_query($dblink, $alter_pages_r3_3);

								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r3_4), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r3_5), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r3_6), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r3_7), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r3_8), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r3_9), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r3_10), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r3_11), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r3_12), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","upload",$lang["CreatingTable"]), @mysqli_query($dblink, $table_upload), str_replace("%1","upload",$lang["ErrorCreatingTable"]));

								test("", @mysqli_query($dblink, $update_pages_r3_1), "");
								test("", @mysqli_query($dblink, $update_pages_r3_2), "");

							//from R4 beta
							case "R4":
								print("         <h2>Wacko R4 beta ".$lang["To"]." R4 RC1</h2>\n");
								print("         <ul>\n");
								test(str_replace("%1","cache",$lang["CreatingTable"]), @mysqli_query($dblink, $table_cache), str_replace("%1","cache",$lang["ErrorCreatingTable"]));

							//from R4 release candidat
							case "R4 RC1":
								print("         <h2>Wacko R4 RC1 ".$lang["To"]." R4.0</h2>\n");
								print("         <ul>\n");

							//from R4.0 to R4.2
							case "R4.0":
								print("         <h2>Wacko R4.0 ".$lang["To"]." R4.2</h2>\n");
								print("         <ul>\n");

							//from R4.2 to R4.3
							case "R4.2":
								print("         <h2>Wacko R4.2 ".$lang["To"]." R4.3</h2>\n");
								print("         <ul>\n");
								// ! new user_id first
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","users",$lang["AlterTable"]), @mysqli_query($dblink, $alter_users_r4_2_1), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								
								test(str_replace("%1","acls",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acls_r4_2), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","acls",$lang["AlterTable"]), @mysqli_query($dblink, $alter_acls_r4_2_1), str_replace("%1", "acls", $lang["ErrorAlteringTable"]));
								
								test(str_replace("%1","acls",$lang["UpdateTable"]), @mysqli_query($dblink, $update_acls_r4_2), str_replace("%1", "acls", $lang["ErrorUpdatingTable"]));
								
								test(str_replace("%1","cache",$lang["AlterTable"]), @mysqli_query($dblink, $alter_cache_r4_2), str_replace("%1", "cache", $lang["ErrorAlteringTable"]));
								
								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r4_2), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r4_2_1), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","links",$lang["AlterTable"]), @mysqli_query($dblink, $alter_links_r4_2_2), str_replace("%1", "links", $lang["ErrorAlteringTable"]));
								
								test(str_replace("%1","links",$lang["UpdateTable"]), @mysqli_query($dblink, $update_links_r4_2), str_replace("%1", "links", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","links",$lang["UpdateTable"]), @mysqli_query($dblink, $update_links_r4_2_1), str_replace("%1", "links", $lang["ErrorUpdatingTable"]));

								test(str_replace("%1","log",$lang["CreatingTable"]), @mysqli_query($dblink, $table_log_r4_2), str_replace("%1", "log", $lang["ErrorCreatingTable"]));

								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_1), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_2), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_3), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_4), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_5), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_6), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_7), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_8), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_2_9), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));

								test(str_replace("%1","pages",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pages_r4_2), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","pages",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pages_r4_2_1), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","pages",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pages_r4_2_2), str_replace("%1", "pages", $lang["ErrorUpdatingTable"]));
								
								test(str_replace("%1","pagewatches",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pagewatches_r4_2), str_replace("%1", "pagewatches", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pagewatches",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pagewatches_r4_2_1), str_replace("%1", "pagewatches", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pagewatches",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pagewatches_r4_2_2), str_replace("%1", "pagewatches", $lang["ErrorAlteringTable"]));
								
								test(str_replace("%1","pagewatches",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pagewatches_r4_2), str_replace("%1", "pagewatches", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","pagewatches",$lang["UpdateTable"]), @mysqli_query($dblink, $update_pagewatches_r4_2_1), str_replace("%1", "pagewatches", $lang["ErrorUpdatingTable"]));
								
								test(str_replace("%1","referrers",$lang["AlterTable"]), @mysqli_query($dblink, $alter_referrers_r4_2), str_replace("%1", "referrers", $lang["ErrorAlteringTable"]));
								
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_1), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_2), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_3), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_4), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_5), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_6), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_2_7), str_replace("%1", "revisions", $lang["ErrorAlteringTable"]));
								
								test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysqli_query($dblink, $update_revisions_r4_2), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));
								test(str_replace("%1","revisions",$lang["UpdateTable"]), @mysqli_query($dblink, $update_revisions_r4_2_1), str_replace("%1", "revisions", $lang["ErrorUpdatingTable"]));
								
								test(str_replace("%1","upload",$lang["AlterTable"]), @mysqli_query($dblink, $alter_upload_r4_2), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));
								
								test(str_replace("%1","upload",$lang["UpdateTable"]), @mysqli_query($dblink, $update_upload_r4_2), str_replace("%1", "upload", $lang["ErrorUpdatingTable"]));
								// !
								test(str_replace("%1","upload",$lang["AlterTable"]), @mysqli_query($dblink, $alter_upload_r4_2_1), str_replace("%1", "upload", $lang["ErrorAlteringTable"]));
								
								test($lang["InstallingLogoImage"], @mysqli_query($dblink, $insert_logo_image), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));
								
								test("", @mysqli_query($dblink, $update_pages_r4_2), "");
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
                                 testPDO(str_replace("%1", "watches", $lang["DeletingTable"]), $table_pagewatches_drop, str_replace("%1", "watches", $lang["ErrorDeletingTable"]));
                                 testPDO(str_replace("%1", "upload", $lang["DeletingTable"]), $table_upload_drop, str_replace("%1", "upload", $lang["ErrorDeletingTable"]));
                                 testPDO(str_replace("%1", "cache", $lang["DeletingTable"]), $table_cache_drop, str_replace("%1", "cache", $lang["ErrorDeletingTable"]));
                                 testPDO(str_replace("%1", "log", $lang["DeletingTable"]), $table_log_drop, str_replace("%1", "log", $lang["ErrorDeletingTable"]));
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
									testPDO(str_replace("%1","watches",$lang["CreatingTable"]), $table_pagewatches, str_replace("%1","watches",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","upload",$lang["CreatingTable"]), $table_upload, str_replace("%1","upload",$lang["ErrorCreatingTable"]));
									testPDO(str_replace("%1","cache",$lang["CreatingTable"]), $table_cache, str_replace("%1","cache",$lang["ErrorCreatingTable"]));
									print("         </ul>\n");
									print("         <br />\n");
									print("         <h2>".$lang["InstallingDefaultData"]."</h2>\n");
									print("         <ul>\n");
									print("            <li>".$lang["InstallingPagesBegin"]);
									require_once("setup/inserts.php");
									print("</li>\n");
									print("            <li>".$lang["InstallingPagesEnd"]."</li>\n");
									testPDO($lang["InstallingAdmin"], $insert_admin, str_replace("%1","admin user",$lang["ErrorAlreadyExists"]));
									testPDO($lang["InstallingLogoImage"], $insert_logo_image, str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));
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