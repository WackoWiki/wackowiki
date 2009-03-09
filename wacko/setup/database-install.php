<?php
@set_time_limit(0);
@ignore_user_abort(true);

function test($text, $condition, $errorText = "")
{
	GLOBAL $lang;
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
$insert_admin = "INSERT INTO ".$config2["table_prefix"]."users (name, password, email, signuptime, lang) VALUES ('".$config["admin_name"]."', md5('".$_POST["password"]."'), '".$config["admin_email"]."', now(), '".$config["language"]."')";
$insert_logo_image = "INSERT INTO ".$config2["table_prefix"]."upload (page_id, filename, description, uploaded_dt, filesize, picture_w, picture_h, file_ext, user) VALUES ('0','wacko4.gif', 'WackoWiki', now(), '1580', '108', '50', 'gif', '".$config2["admin_name"]."')";

/*
 Setup the tables depending on which database we selected

 mysql_legacy
 mysqli_legacy
 or pdo which is the default clause
 */
$port = trim($config2["database_port"]);

$fatal_error = false;

switch($config2["database_driver"])
{
	case "mysql_legacy":
		require_once("setup/database_mysql.php");
		require_once("setup/database_mysql_updates.php");

		print("         <ul>\n");

		if(!test($lang["TestConnectionString"], $dblink = @mysql_connect($config2["database_host"].($port == "" ? '' : ':'.$port), $config2["database_user"], $config2["database_password"]), $lang["ErrorDBConnection"]))
		{
			/*
			 There was a problem with the connection string
			 */

			print("         </ul>\n");
			print("         <br />\n");

			$fatal_error = true;
		}
		else if(!test($lang["TestDatabaseExists"], @mysql_select_db($config2["database_database"], $dblink), $lang["ErrorDBExists"]))
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

			if ( !isset ( $wackoConfig["wakka_version"] ) ) $wackoConfig["wakka_version"] = "";
			if (!$version = trim($wackoConfig["wakka_version"])) $version = "0";
			if ( isset ( $wackoConfig["wacko_version"] ) )
			if ( trim ( $wackoConfig["wacko_version"] ) ) $version = trim($wackoConfig["wacko_version"]);

			switch ($version)
			{
				// new installation
				case "0":
					print("<h2>".$lang["InstallingTables"]."</h2>\n");
					print("            <ul>\n");
					test(str_replace("%1","page",$lang["CreatingTable"]), @mysql_query($table_pages, $dblink), str_replace("%1","page",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","revision",$lang["CreatingTable"]), @mysql_query($table_revisions, $dblink), str_replace("%1","revision",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","ACL",$lang["CreatingTable"]), @mysql_query($table_acls, $dblink), str_replace("%1","ACL",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","link tracking",$lang["CreatingTable"]), @mysql_query($table_links, $dblink), str_replace("%1","link",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","referrer",$lang["CreatingTable"]), @mysql_query($table_referrers, $dblink), str_replace("%1","referrer",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","user",$lang["CreatingTable"]), @mysql_query($table_users, $dblink), str_replace("%1","user",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","watches",$lang["CreatingTable"]), @mysql_query($table_pagewatches, $dblink), str_replace("%1","watches",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","upload",$lang["CreatingTable"]), @mysql_query($table_upload, $dblink), str_replace("%1","upload",$lang["ErrorCreatingTable"]));
					test(str_replace("%1","cache",$lang["CreatingTable"]), @mysql_query($table_cache, $dblink), str_replace("%1","cache",$lang["ErrorCreatingTable"]));
					print("         </ul>\n");
					print("         <br />\n");
					print("         <h2>".$lang["InstallingDefaultData"]."</h2>\n");
					print("         <ul>\n");
					print("            <li>".$lang["InstallingPagesBegin"]);
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
					test($lang["AlterUsersTable"], @mysql_query($alter_users_r0_1, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","watches",$lang["CreatingTable"]), @mysql_query($table_pagewatches_r0, $dblink), str_replace("%1","watches",$lang["ErrorCreatingTable"]));

					// from Wacko R2
				case "R2":
					print("         <h2>Wacko R2 ".$lang["To"]." R3</h2>\n");
					print("         <ul>\n");
					test($lang["AlterUsersTable"], @mysql_query($alter_users_r2_1, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
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
					test($lang["AlterUsersTable"], @mysql_query($alter_users_r3_1, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test($lang["AlterUsersTable"], @mysql_query($alter_users_r3_2, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
					test($lang["AlterUsersTable"], @mysql_query($alter_users_r3_3, $dblink), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
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
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_3, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_3_2, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","pages",$lang["AlterTable"]), @mysql_query($alter_pages_r4_3_3, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_3_2, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test(str_replace("%1","revisions",$lang["AlterTable"]), @mysql_query($alter_revisions_r4_3_3, $dblink), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
					test($lang["InstallingLogoImage"], @mysql_query($insert_logo_image, $dblink), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));
			}
			print("            </ul>\n");
		}
		break;
				case "mysqli_legacy":
					require_once("setup/database_mysql.php");
					require_once("setup/database_mysql_updates.php");
					
					if ( !isset ( $wackoConfig["database_port"] ) ) $wackoConfig["database_port"] = "3306";
					if (!$port = trim($wackoConfig["database_port"])) $port = "3306";

					print("         <ul>\n");

					if(!test($lang["TestConnectionString"], $dblink = @mysqli_connect($config2["database_host"], $config2["database_user"], $config2["database_password"], null, $port), $lang["ErrorDBConnection"]))
					{
						/*
						 There was a problem with the connection string
						 */

						print("         </ul>\n");
						print("         <br />\n");

						$fatal_error = true;
					}
					else if(!test($lang["TestDatabaseExists"], @mysqli_select_db($dblink, $config2["database_database"]), $lang["ErrorDBExists"]))
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

						if (!$version = trim($wackoConfig["wakka_version"])) $version = "0";
						if (trim($wackoConfig["wacko_version"])) $version = trim($wackoConfig["wacko_version"]);
						switch ($version)
						{
							// new installation
							case "0":
								print("         <h2>".$lang["InstallingTables"]."</h2>\n");
								print("         <ul>\n");
								test(str_replace("%1","page",$lang["CreatingTable"]), @mysqli_query($dblink, $table_pages), str_replace("%1","page",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","revision",$lang["CreatingTable"]), @mysqli_query($dblink, $table_revisions), str_replace("%1","revision",$lang["ErrorCreatingTable"]));
								test(str_replace("%1","ACL",$lang["CreatingTable"]), @mysqli_query($dblink, $table_acls), str_replace("%1","ACL",$lang["ErrorCreatingTable"]));
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
								test($lang["AlterUsersTable"], @mysqli_query($dblink, $alter_users_r0_1), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","watches",$lang["CreatingTable"]), @mysqli_query($dblink, $table_pagewatches_r0), str_replace("%1","watches",$lang["ErrorCreatingTable"]));

								// from Wacko R2
							case "R2":
								print("         <h2>Wacko R2 ".$lang["To"]." R3</h2>\n");
								print("         <ul>\n");
								test($lang["AlterUsersTable"], @mysqli_query($dblink, $alter_users_r2_1), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
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
								test($lang["AlterUsersTable"], @mysqli_query($dblink, $alter_users_r3_1), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test($lang["AlterUsersTable"], @mysqli_query($dblink, $alter_users_r3_2), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
								test($lang["AlterUsersTable"], @mysqli_query($dblink, $alter_users_r3_3), str_replace("%1", "users", $lang["ErrorAlteringTable"]));
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
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_3), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_3_2), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","pages",$lang["AlterTable"]), @mysqli_query($dblink, $alter_pages_r4_3_3), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_3_2), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test(str_replace("%1","revisions",$lang["AlterTable"]), @mysqli_query($dblink, $alter_revisions_r4_3_3), str_replace("%1", "pages", $lang["ErrorAlteringTable"]));
								test($lang["InstallingLogoImage"], @mysqli_query($dblink, $insert_logo_image), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));
						}
						print("         </ul>\n");
					}
					break;
							default:
								$dsn = "";
								switch($config2["database_driver"])
								{
									case "firebird":
										$dsn = $config2["database_driver"].":dbname=".$config2["database_host"].":".$config2["database_database"].($config2["database_port"] != "" ? ";port=".$config2["database_port"] : "");
										break;
									case "ibm":
										$dsn = $config2["database_driver"].":DATABASE=".$config2["database_host"].";HOSTNAME=".$config2["database_database"].($config2["database_port"] != "" ? ";PORT=".$config2["database_port"] : "");
										break;
									case "informix":
										$dsn = $config2["database_driver"].":database=".$config2["database_host"].";host=".$config2["database_database"].($config2["database_port"] != "" ? ";service=".$config2["database_port"] : "");
										break;
									case "oci":
										$dsn = $config2["database_driver"].":dbname=//".$config2["database_host"].($config2["database_port"] != "" ? ":".$config2["database_port"] : "")."/".$config2["database_database"];
										break;
									case "sqlite":
									case "sqlite2":
									case "mysql":
										require_once("setup/database_mysql.php");
										$dsn = $config2["database_driver"].":dbname=".$config2["database_database"].";host=".$config2["database_host"].($config2["database_port"] != "" ? ";port=".$config2["database_port"] : "");
										break;
									case "mssql":
										require_once("setup/database_mysql.php");
										$dsn = $config2["database_driver"].":host=".$config2["database_host"].($config2["database_port"] != "" ? ",".$config2["database_port"] : "").";dbname=".$config2["database_database"];
										print($dsn);
										break;
									case "pgsql":
										require_once("setup/database_pgsql.php");
										$dsn = $config2["database_driver"].":dbname=".$config2["database_database"].";host=".$config2["database_host"].($config2["database_port"] != "" ? ";port=".$config2["database_port"] : "");
										break;
								}

								print("         <ul>\n");
								// PHP4 doesn't support try/catch blocks
								require_once("setup/database-install-pdo.php");
								print("         </ul>\n");
								print("         <br />\n");

								if(!$fatal_error)
								{
									// No need to check the past versions since PDO SQL is only officially supported in this release (v4.3)
									print("         <h2>".$lang["InstallingTables"]."</h2>\n");
									print("         <ul>\n");
									test(str_replace("%1","page",$lang["CreatingTable"]), @$dblink->query($table_pages), str_replace("%1","page",$lang["ErrorCreatingTable"]));
									test(str_replace("%1","revision",$lang["CreatingTable"]), @$dblink->query($table_revisions), str_replace("%1","revision",$lang["ErrorCreatingTable"]));
									test(str_replace("%1","ACL",$lang["CreatingTable"]), @$dblink->query($table_acls), str_replace("%1","ACL",$lang["ErrorCreatingTable"]));
									test(str_replace("%1","link tracking",$lang["CreatingTable"]), @$dblink->query($table_links), str_replace("%1","link",$lang["ErrorCreatingTable"]));
									test(str_replace("%1","referrer",$lang["CreatingTable"]), @$dblink->query($table_referrers), str_replace("%1","referrer",$lang["ErrorCreatingTable"]));
									test(str_replace("%1","user",$lang["CreatingTable"]), @$dblink->query($table_users), str_replace("%1","user",$lang["ErrorCreatingTable"]));
									test(str_replace("%1","watches",$lang["CreatingTable"]), @$dblink->query($table_pagewatches), str_replace("%1","watches",$lang["ErrorCreatingTable"]));
									test(str_replace("%1","upload",$lang["CreatingTable"]), @$dblink->query($table_upload), str_replace("%1","upload",$lang["ErrorCreatingTable"]));
									test(str_replace("%1","cache",$lang["CreatingTable"]), @$dblink->query($table_cache), str_replace("%1","cache",$lang["ErrorCreatingTable"]));
									print("         </ul>\n");
									print("         <br />\n");
									print("         <h2>".$lang["InstallingDefaultData"]."</h2>\n");
									print("         <ul>\n");
									print("            <li>".$lang["InstallingPagesBegin"]);
									require_once("setup/inserts.php");
									print("</li>\n");
									print("            <li>".$lang["InstallingPagesEnd"]."</li>\n");
									test($lang["InstallingAdmin"], @$dblink->query($insert_admin), str_replace("%1","admin user",$lang["ErrorAlreadyExists"]));
									test($lang["InstallingLogoImage"], @$dblink->query($insert_logo_image), str_replace("%1","logo image",$lang["ErrorAlreadyExists"]));
									print("         </ul>\n");
								}
								break;
}

if(!$fatal_error)
{
	?>
<p><?php echo $lang["NextStep"];?></p>
<form action="<?php echo myLocation(); ?>?installAction=write-config"
	method="post"><input type="hidden" name="config[language]"
	value="<?php echo $config["language"];?>" /> <input type="hidden"
	name="config[multilanguage]"
	value="<?php echo $config["multilanguage"];?>" /> <input type="hidden"
	name="config[admin_name]" value="<?php echo $config["admin_name"];?>" />
<input type="hidden" name="password"
	value="<?php echo $_POST["password"];?>" /> <input type="hidden"
	name="config[admin_email]" value="<?php echo $config["admin_email"];?>" />
<input type="hidden" name="config[base_url]"
	value="<?php echo $config["base_url"];?>" /> <input type="hidden"
	name="config[rewrite_mode]"
	value="<?php echo $config["rewrite_mode"];?>" /> <input type="hidden"
	name="config[cache]" value="<?php echo $config["cache"];?>" /> <input
	type="hidden" name="config_s"
	value="<?php echo htmlspecialchars(serialize($config)) ?>" /> <input
	type="submit" value="<?php echo $lang["Continue"];?>" class="next" /></form>
	<?php
}
else
{
	?>
<input
	type="submit" value="<?php echo $lang["Back"];?>" class="next"
	onclick="javascript: history.go(-1);" />
	<?php
}
?>
