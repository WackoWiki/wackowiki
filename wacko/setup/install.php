<?php
@set_time_limit(0);
@ignore_user_abort(true);

// test configuration
print("<strong>".$lang["Testing Configuration"]."</strong><br />\n");

/*
   These are the table creation statements for the 4.2 tables
*/
$table_pages = "CREATE TABLE ".$config2["table_prefix"]."pages (".
                 "id int(10) unsigned NOT NULL auto_increment,".
                 "tag varchar(250) character set latin1 collate latin1_swedish_ci NOT NULL default '',".
                 "supertag varchar(250) NOT NULL default '',".
                 "time datetime NOT NULL default '0000-00-00 00:00:00',".
                 "body text NOT NULL,".
                 "body_r text NOT NULL,".
                 "body_toc text NOT NULL,".
                 "owner varchar(50) NOT NULL default '',".
                 "user varchar(50) NOT NULL default '',".
                 "latest enum('Y','N') NOT NULL default 'N',".
                 "handler varchar(30) NOT NULL default 'page', ".
                 "comment_on varchar(250) binary NOT NULL default '', ".
                 "super_comment_on varchar(250) NOT NULL default '', ".
                 "hits int(11) NOT NULL default '0', ".
                 "lang varchar(20) NOT NULL default '', ".
                 "description varchar(250) NOT NULL default '',".
                 "keywords varchar(250) binary NOT NULL default '',".
                 "PRIMARY KEY  (id),".
                 "FULLTEXT KEY body (body),".
                 "UNIQUE KEY idx_tag (tag),".
                 "KEY idx_supertag (supertag),".
                 "KEY idx_time (time),".
                 "KEY idx_latest (latest),".
                 "KEY idx_comment_on (comment_on), ".
                 "KEY idx_super_comment_on (super_comment_on) ".
               ") TYPE=MyISAM;";

$table_revisions = "CREATE TABLE ".$config2["table_prefix"]."revisions (".
                    "id int(10) unsigned NOT NULL auto_increment,".
                    "tag varchar(250) binary NOT NULL default '',".
                    "supertag varchar(250) binary NOT NULL default '',".
                    "time datetime NOT NULL default '0000-00-00 00:00:00',".
                    "body text NOT NULL,".
                    "body_r text NOT NULL,".
                    "owner varchar(50) NOT NULL default '',".
                    "user varchar(50) NOT NULL default '',".
                    "latest enum('Y','N') NOT NULL default 'N',".
                    "handler varchar(30) NOT NULL default 'page',".
                    "comment_on varchar(250) binary NOT NULL default '',".
                    "super_comment_on varchar(250) NOT NULL default '', ".
                    "lang varchar(20) NOT NULL default '', ".
                    "description varchar(250) NOT NULL default '',".
                    "keywords varchar(250) binary NOT NULL default '',".
                    "PRIMARY KEY  (id), ".
                    "KEY idx_tag (tag), ".
                    "KEY idx_supertag (supertag), ".
                    "KEY idx_time (time), ".
                    "KEY idx_latest (latest), ".
                    "KEY idx_comment_on (comment_on) ".
                  ") TYPE=MyISAM;";

$table_acls = "CREATE TABLE ".$config2["table_prefix"]."acls (".
                 "page_tag varchar(250) binary NOT NULL default '',".
                 "supertag varchar(250) NOT NULL default '',".
                 "privilege varchar(20) NOT NULL default '',".
                 "list text NOT NULL,".
                 "PRIMARY KEY  (page_tag,privilege),".
                 "KEY supertag (supertag)".
                 ") TYPE=MyISAM";

$table_links = "CREATE TABLE ".$config2["table_prefix"]."links (".
                 "from_tag varchar(250) binary NOT NULL default '',".
                 "to_tag varchar(250) binary NOT NULL default '',".
                 "to_supertag VARCHAR(250) NOT NULL, ".
                 "KEY from_tag (from_tag,to_tag(78)),".
                 "KEY idx_from (from_tag),".
                 "KEY idx_to (to_tag)".
               ") TYPE=MyISAM";

$table_referrers = "CREATE TABLE ".$config2["table_prefix"]."referrers (".
                    "page_tag char(250) binary NOT NULL default '',".
                    "referrer char(150) NOT NULL default '',".
                    "time datetime NOT NULL default '0000-00-00 00:00:00',".
                    "KEY idx_page_tag (page_tag),".
                    "KEY idx_time (time)".
                  ") TYPE=MyISAM";

$table_users = "CREATE TABLE ".$config2["table_prefix"]."users (".
                 "name varchar(80) NOT NULL default '',".
                 "password varchar(32) NOT NULL default '',".
                 "email varchar(50) NOT NULL default '',".
                 "motto text NOT NULL,".
                 "revisioncount int(10) unsigned NOT NULL default '20',".
                 "changescount int(10) unsigned NOT NULL default '50',".
                 "doubleclickedit enum('Y','N') NOT NULL default 'Y',".
                 "signuptime datetime NOT NULL default '0000-00-00 00:00:00',".
                 "show_comments enum('Y','N') NOT NULL default 'N',".
                 "bookmarks text NOT NULL,".
                 "lang varchar(20) NOT NULL default '',".
                 "show_spaces enum('Y','N') NOT NULL default 'Y',".
                 "showdatetime enum('Y','N') NOT NULL default 'Y',".
                 "typografica enum('Y','N') NOT NULL default 'Y',".
                 "more text NOT NULL,".
                 "changepassword VARCHAR(100) NOT NULL,".
                 "email_confirm varchar(40) NOT NULL default '',".
                 "PRIMARY KEY  (name),".
                 "KEY idx_name (name),".
                 "KEY idx_signuptime (signuptime)".
               ") TYPE=MyISAM";

$table_pagewatches = "CREATE TABLE ".$config2["table_prefix"]."pagewatches (".
                        "id int(10) NOT NULL auto_increment, ".
                        "user varchar(80) NOT NULL default '', ".
                        "tag varchar(250) binary NOT NULL default '', ".
                        "time timestamp(14) NOT NULL, ".
                        "PRIMARY KEY  (id)) TYPE=MyISAM";

$table_upload = "CREATE TABLE ".$config2["table_prefix"]."upload (".
                  "id int(11) NOT NULL auto_increment, ".
                  "page_id int(11) NOT NULL default '0', ".
                  "filename varchar(250) NOT NULL default '', ".
                  "description varchar(250) NOT NULL default '', ".
                  "uploaded_dt datetime NOT NULL default '0000-00-00 00:00:00', ".
                  "filesize int(11) NOT NULL default '0', ".
                  "picture_w int(11) NOT NULL default '0', ".
                  "picture_h int(11) NOT NULL default '0', ".
                  "file_ext varchar(10) NOT NULL default '', ".
                  "user varchar(80) NOT NULL default '0', ".
                  "PRIMARY KEY  (id), ".
                  "KEY page_id (page_id,filename), ".
                  "KEY page_id_2 (page_id,uploaded_dt), ".
                  "KEY user_id (user,page_id)) TYPE=MyISAM";

$table_cache = "CREATE TABLE ".$config2["table_prefix"]."cache (".
                  "name VARCHAR( 32 ) NOT NULL, ".
                  "method VARCHAR( 20 ) NOT NULL, ".
                  "query VARCHAR( 100 ) NOT NULL, ".
                  "INDEX (name)) TYPE=MyISAM";

$insert_admin = "insert into ".$config2["table_prefix"]."users set name = '".$config["admin_name"]."', password = md5('".$_POST["password"]."'), email = '".$config["admin_email"]."', signuptime = now()";

/*
   These are all the updates that need to applied to earlier Wacko version to bring them up to 4.2 specs
*/

$table_pagewatches_r0 = "CREATE TABLE ".$config2["table_prefix"]."pagewatches (".
                        "id int(10) NOT NULL auto_increment, ".
                        "user varchar(80) NOT NULL default '', ".
                        "tag varchar(50) binary NOT NULL default '', ".
                        "time timestamp(14) NOT NULL, ".
                        "PRIMARY KEY  (id)) TYPE=MyISAM";

$table_revisions_r2 = "CREATE TABLE ".$config2["table_prefix"]."revisions (".
                     "id int(10) unsigned NOT NULL auto_increment,".
                     "tag varchar(250) NOT NULL default '',".
                     "supertag varchar(250) NOT NULL default '',".
                     "time datetime NOT NULL default '0000-00-00 00:00:00',".
                     "body text NOT NULL,".
                     "body_r text NOT NULL,".
                     "owner varchar(50) NOT NULL default '',".
                     "user varchar(50) NOT NULL default '',".
                     "latest enum('Y','N') NOT NULL default 'N',".
                     "handler varchar(30) NOT NULL default 'page',".
                     "comment_on varchar(50) NOT NULL default '',".
                     "PRIMARY KEY  (id),".
                     "KEY idx_tag (tag),".
                     "KEY idx_supertag (supertag),".
                     "KEY idx_time (time),".
                     "KEY idx_latest (latest),".
                     "KEY idx_comment_on (comment_on),".
                     "KEY supertag (supertag)".
                     ") TYPE=MyISAM;";

$insert_revisions_r2_1 = "INSERT INTO ".$config2["table_prefix"]."revisions ( id, tag, supertag, time, body, body_r, owner, user, latest, handler, comment_on ) SELECT id, tag, supertag, time, body, body_r, owner, user, latest, handler, comment_on FROM ".$config2["table_prefix"]."pages WHERE latest='N';";

$alter_pages_r0_1 = "alter table ".$config2["table_prefix"]."pages add body_r text not null default '' after body";
$alter_pages_r2_1 = "alter table ".$config2["table_prefix"]."pages add supertag VARCHAR(250) NOT NULL default '' after tag, CHANGE tag tag VARCHAR(250) NOT NULL, ADD INDEX supertag (supertag)";
$alter_pages_r2_2 = "alter table ".$config2["table_prefix"]."pages DROP INDEX idx_tag, ADD UNIQUE idx_tag (tag)";
$alter_pages_r3_1 = "ALTER TABLE ".$config2["table_prefix"]."pages DROP INDEX fts";
$alter_pages_r3_2 = "ALTER TABLE ".$config2["table_prefix"]."pages DROP INDEX body";
$alter_pages_r3_3 = "ALTER TABLE ".$config2["table_prefix"]."pages DROP INDEX tag";
$alter_pages_r3_4 = "ALTER TABLE ".$config2["table_prefix"]."pages ADD FULLTEXT (body)";
$alter_pages_r3_5 = "ALTER TABLE ".$config2["table_prefix"]."pages CHANGE tag tag VARCHAR(250) BINARY NOT NULL";
$alter_pages_r3_6 = "ALTER TABLE ".$config2["table_prefix"]."pages CHANGE comment_on comment_on VARCHAR(250) BINARY NOT NULL";
$alter_pages_r3_7 = "ALTER TABLE ".$config2["table_prefix"]."pages ADD hits INT DEFAULT '0' NOT NULL";
$alter_pages_r3_8 = "ALTER TABLE ".$config2["table_prefix"]."pages ADD super_comment_on VARCHAR(250) NOT NULL AFTER comment_on";
$alter_pages_r3_9 = "ALTER TABLE ".$config2["table_prefix"]."pages ADD lang VARCHAR(10) NOT NULL";
$alter_pages_r3_10 = "ALTER TABLE ".$config2["table_prefix"]."pages ADD description varchar(250) NOT NULL default ''";
$alter_pages_r3_11 = "ALTER TABLE ".$config2["table_prefix"]."pages ADD keywords varchar(250) binary NOT NULL default ''";
$alter_pages_r3_12 = "ALTER TABLE ".$config2["table_prefix"]."pages add body_toc text not null default '' after body_r";
$alter_pages_r4_3 = "ALTER TABLE ".$config2["table_prefix"]."pages MODIFY COLUMN tag VARCHAR(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";

$update_pages_r3_1 = "UPDATE ".$config2["table_prefix"]."pages SET body_r=''";
$update_pages_r3_2 = "UPDATE ".$config2["table_prefix"]."pages SET body_toc=''";

$alter_users_r0_1 = "alter table ".$config2["table_prefix"]."users ADD bookmarks text not null default '', add lang varchar(20) NOT NULL default '', add show_spaces enum('Y','N') NOT NULL default 'Y'";
$alter_users_r2_1 = "alter table ".$config2["table_prefix"]."users ADD showdatetime enum('Y','N') NOT NULL default 'Y', add typografica enum('Y','N') NOT NULL default 'Y'";
$alter_users_r3_1 = "ALTER TABLE ".$config2["table_prefix"]."users ADD more TEXT NOT NULL";
$alter_users_r3_2 = "ALTER TABLE ".$config2["table_prefix"]."users ADD changepassword VARCHAR(100) NOT NULL";
$alter_users_r3_3 = "ALTER TABLE ".$config2["table_prefix"]."users ADD email_confirm VARCHAR(100) NOT NULL";

$alter_acls_r2_1 = "ALTER TABLE ".$config2["table_prefix"]."acls ADD supertag VARCHAR(250) NOT NULL default '', CHANGE page_tag page_tag VARCHAR(250) NOT NULL, ADD INDEX(supertag)";
$alter_acls_r3_1 = "ALTER TABLE ".$config2["table_prefix"]."acls CHANGE page_tag page_tag VARCHAR(250) BINARY NOT NULL";

$alter_links_r2_1 = "alter table ".$config2["table_prefix"]."links CHANGE from_tag from_tag VARCHAR(250) NOT NULL, CHANGE to_tag to_tag VARCHAR(250) NOT NULL";
$alter_links_r3_1 = "ALTER TABLE ".$config2["table_prefix"]."links CHANGE from_tag from_tag CHAR(250) BINARY NOT NULL";
$alter_links_r3_2 = "ALTER TABLE ".$config2["table_prefix"]."links CHANGE to_tag to_tag CHAR(250) BINARY NOT NULL";
$alter_links_r3_3 = "ALTER TABLE ".$config2["table_prefix"]."links ADD to_supertag VARCHAR(250) NOT NULL";

$alter_referrers_r2_1 = "alter table ".$config2["table_prefix"]."referrers CHANGE page_tag page_tag VARCHAR(250) NOT NULL";
$alter_referrers_r3_1 = "ALTER TABLE ".$config2["table_prefix"]."referrers CHANGE page_tag page_tag CHAR(250) BINARY NOT NULL";

$alter_pagewatches_r2_1 = "alter table ".$config2["table_prefix"]."pagewatches CHANGE tag tag VARCHAR(250) NOT NULL";
$alter_pagewatches_r3_1 = "ALTER TABLE ".$config2["table_prefix"]."pagewatches CHANGE tag tag VARCHAR(250) BINARY NOT NULL";

$alter_revisions_r3_1 = "ALTER TABLE ".$config2["table_prefix"]."revisions CHANGE tag tag VARCHAR(250) BINARY NOT NULL";
$alter_revisions_r3_2 = "ALTER TABLE ".$config2["table_prefix"]."revisions CHANGE comment_on comment_on VARCHAR(250) BINARY NOT NULL";
$alter_revisions_r3_3 = "ALTER TABLE ".$config2["table_prefix"]."revisions ADD super_comment_on VARCHAR(250) NOT NULL AFTER comment_on";
$alter_revisions_r3_4 = "ALTER TABLE ".$config2["table_prefix"]."revisions ADD lang VARCHAR(10) NOT NULL";
$alter_revisions_r3_5 = "ALTER TABLE ".$config2["table_prefix"]."revisions ADD description varchar(250) NOT NULL default ''";
$alter_revisions_r3_6 = "ALTER TABLE ".$config2["table_prefix"]."revisions ADD keywords varchar(250) binary NOT NULL default ''";

$insert_logo_image = "INSERT INTO ".$config2["table_prefix"]."upload (id, page_id, filename, description, uploaded_dt, filesize, picture_w, picture_h, file_ext, user) VALUES ('1', '0','wacko4.gif', 'WackoWiki', now(), '1580', '108', '50', 'gif', '".$config2["admin_name"]."')";

/*
   Setup the tables depending on which database we selected

   mysql_legacy
   mysqli_legacy
   or pdo which is the default clause
*/
$port = trim($wakkaConfig["database_port"]);

switch($config2["database_driver"])
   {
      case "mysql_legacy":
         test($lang["TestSql"], $dblink = @mysql_connect($config2["database_host"].($port == "" ? '' : ':'.$port), $config2["database_user"], $config2["database_password"]));
         test($lang["Looking for database..."], @mysql_select_db($config2["database_database"], $dblink), $lang["DBError"]);
         print("<br />\n");

         if (!$version = trim($wakkaConfig["wakka_version"])) $version = "0";
         if (trim($wakkaConfig["wacko_version"])) $version = trim($wakkaConfig["wacko_version"]);
         switch ($version)
            {
               // new installation
               case "0":
                  print("<strong>".$lang["Installing Stuff"]."</strong><br />\n");
                  test(str_replace("%1","page",$lang["Creating table..."]), @mysql_query($table_pages, $dblink), $lang["Already exists?"], 0);
                  test(str_replace("%1","revision",$lang["Creating table..."]), @mysql_query($table_revisions, $dblink), $lang["Already exists?"], 0);
                  test(str_replace("%1","ACL",$lang["Creating table..."]), @mysql_query($table_acls, $dblink), $lang["Already exists?"], 0);
                  test(str_replace("%1","link tracking",$lang["Creating table..."]), @mysql_query($table_links, $dblink), $lang["Already exists?"], 0);
                  test(str_replace("%1","referrer",$lang["Creating table..."]), @mysql_query($table_referrers, $dblink), $lang["Already exists?"], 0);
                  test(str_replace("%1","user",$lang["Creating table..."]), @mysql_query($table_users, $dblink), $lang["Already exists?"], 0);
                  test(str_replace("%1","watches",$lang["Creating table..."]), @mysql_query($table_pagewatches, $dblink), $lang["Already exists?"], 0);
                  test(str_replace("%1","upload",$lang["Creating table..."]), @mysql_query($table_upload, $dblink), $lang["Already exists?"], 0);
                  test(str_replace("%1","cache",$lang["Creating table..."]), @mysql_query($table_cache, $dblink), $lang["Already exists?"], 0);
                  test($lang["adding admin"], @mysql_query($insert_admin, $dblink), $lang["Hmm!"], 0);
                  test($lang["Adding some pages..."], 1);
                  require("setup/inserts.php");
                  break;

               /*
                  The funny upgrading stuff. Make sure these are in order!
                  And yes, there are no (switch) breaks here. This is on purpose.
               */

               // from 0.1 to 0.1.1
               case "0.1":
                  print("<strong>0.1 ".$lang["to"]." 0.1.1</strong><br />\n");
                  test($lang["pages alter"], @mysql_query($alter_pages_r0_1, $dblink), $lang["Hmm!"], 0);

               // from 0.1.1 to 0.1.2
               case "0.1.1":
                  print("<strong>0.1.1 ".$lang["to"]."o 0.1.2</strong><br />\n");
                  test($lang["0.1.1"], 1);

               // from Wakka 0.1.2 or Wacko R1
               case "0.1.2":
               case "0.1.3-dev":
                  print("<strong>0.1.2 ".$lang["to"]." Wacko R2</strong><br />\n");
                  test($lang["useralter"], @mysql_query($alter_users_r0_1, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","watches",$lang["Creating table..."]), @mysql_query($table_pagewatches_r0, $dblink), $lang["Already exists?"], 0);
                  test($lang["Claiming all your base..."], 1);

               // from Wacko R2
               case "R2":
                  print("<strong>Wacko R2 ".$lang["to"]." R3</strong><br />\n");
                  test($lang["useralter"], @mysql_query($alter_users_r2_1, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysql_query($alter_pages_r2_1, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","acls",$lang["And table..."]), @mysql_query($alter_acls_r2_1, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","links",$lang["And table..."]), @mysql_query($alter_links_r2_1, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","referrers",$lang["And table..."]), @mysql_query($alter_referrers_r2_1, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","watches",$lang["And table..."]), @mysql_query($alter_pagewatches_r2_1, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","revision",$lang["Creating table..."]), @mysql_query($table_revisions_r2, $dblink), $lang["Already exists?"], 0);
                  test($lang["Moving data to revisions table..."], @mysql_query($insert_revisions_r2_1, $dblink), $lang["VeryBad"], 0);
                  test($lang["pages alter"], @mysql_query($alter_pages_r2_2, $dblink), $lang["Doubles"], 0);

                  test($lang["Adding some pages..."], 1);
                  require("setup/inserts.php");

               // from Wacko R3
               case "R3":
                  print("<strong>Wacko R3/3.5 ".$lang["to"]." R4</strong><br />\n");
                  test($lang["useralter"], @mysql_query($alter_users_r3_1, $dblink), $lang["Hmm!"], 0);
                  test($lang["useralter"], @mysql_query($alter_users_r3_2, $dblink), $lang["Hmm!"], 0);
                  test($lang["useralter"], @mysql_query($alter_users_r3_3, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @mysql_query($alter_revisions_r3_1, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @mysql_query($alter_revisions_r3_2, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @mysql_query($alter_revisions_r3_3, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @mysql_query($alter_revisions_r3_4, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @mysql_query($alter_revisions_r3_5, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @mysql_query($alter_revisions_r3_6, $dblink), $lang["Hmm!"], 0);

                  test(str_replace("%1","links",$lang["And table..."]), @mysql_query($alter_links_r3_1, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","links",$lang["And table..."]), @mysql_query($alter_links_r3_2, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","links",$lang["And table..."]), @mysql_query($alter_links_r3_3, $dblink), $lang["Hmm!"], 0);

                  test(str_replace("%1","acls",$lang["And table..."]), @mysql_query($alter_acls_r3_1, $dblink), $lang["Hmm!"], 0);

                  test(str_replace("%1","pagewatches",$lang["And table..."]), @mysql_query($alter_pagewatches_r3_1, $dblink), $lang["Hmm!"], 0);

                  test(str_replace("%1","referrers",$lang["And table..."]), @mysql_query($alter_referrers_r3_1, $dblink), $lang["Hmm!"], 0);

                  @mysql_query($alter_pages_r3_1, $dblink);
                  @mysql_query($alter_pages_r3_2, $dblink);
                  @mysql_query($alter_pages_r3_3, $dblink);

                  test(str_replace("%1","pages",$lang["And table..."]), @mysql_query($alter_pages_r3_4, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysql_query($alter_pages_r3_5, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysql_query($alter_pages_r3_6, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysql_query($alter_pages_r3_7, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysql_query($alter_pages_r3_8, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysql_query($alter_pages_r3_9, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysql_query($alter_pages_r3_10, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysql_query($alter_pages_r3_11, $dblink), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysql_query($alter_pages_r3_12, $dblink), $lang["Hmm!"], 0);

                  test(str_replace("%1","upload",$lang["Creating table..."]), @mysql_query($table_upload, $dblink), $lang["Already exists?"], 0);

                  test("", @mysql_query($update_pages_r3_1, $dblink), "", 0);
                  test("", @mysql_query($update_pages_r3_2, $dblink), "", 0);

               //from R4 beta
               case "R4":
                  print("<strong>Wacko R4 beta ".$lang["to"]." R4 RC1</strong><br />\n");
                  test(str_replace("%1","cache",$lang["Creating table..."]), @mysql_query($table_cache, $dblink), $lang["Already exists?"], 0);

               //from R4 release candidat
               case "R4 RC1":
                  print("<strong>Wacko R4 RC1 ".$lang["to"]." R4.0</strong><br />\n");

               //from R4.0 to R4.2
               case "R4.0":
                  print("<strong>Wacko R4.0 ".$lang["to"]." R4.2</strong><br />\n");

               //from R4.2 to R4.3
               case "R4.2":
                  print("<strong>Wacko R4.2 ".$lang["to"]." R4.3</strong><br />\n");
                  test(str_replace("%1","pages",$lang["And table..."]), @mysql_query($alter_pages_r4_3, $dblink), $lang["Hmm!"], 0);
            }

         test($lang["adding logo image..."], @mysql_query($insert_logo_image, $dblink), $lang["Already exists?"], 0);
         break;
      case "mysqli_legacy":
         test($lang["TestSql"], $dblink = @mysqli_connect($config2["database_host"].($port == "" ? '' : ':'.$port), $config2["database_user"], $config2["database_password"]));
         test($lang["Looking for database..."], @mysqli_select_db($dblink, $config2["database_database"]), $lang["DBError"]);
         print("<br />\n");

         if (!$version = trim($wakkaConfig["wakka_version"])) $version = "0";
         if (trim($wakkaConfig["wacko_version"])) $version = trim($wakkaConfig["wacko_version"]);
         switch ($version)
            {
               // new installation
               case "0":
                  print("<strong>".$lang["Installing Stuff"]."</strong><br />\n");
                  test(str_replace("%1","page",$lang["Creating table..."]), @mysqli_query($dblink, $table_pages), $lang["Already exists?"], 0);
                  test(str_replace("%1","revision",$lang["Creating table..."]), @mysqli_query($dblink, $table_revisions), $lang["Already exists?"], 0);
                  test(str_replace("%1","ACL",$lang["Creating table..."]), @mysqli_query($dblink, $table_acls), $lang["Already exists?"], 0);
                  test(str_replace("%1","link tracking",$lang["Creating table..."]), @mysqli_query($dblink, $table_links), $lang["Already exists?"], 0);
                  test(str_replace("%1","referrer",$lang["Creating table..."]), @mysqli_query($dblink, $table_referrers), $lang["Already exists?"], 0);
                  test(str_replace("%1","user",$lang["Creating table..."]), @mysqli_query($dblink, $table_users), $lang["Already exists?"], 0);
                  test(str_replace("%1","watches",$lang["Creating table..."]), @mysqli_query($dblink, $table_pagewatches), $lang["Already exists?"], 0);
                  test(str_replace("%1","upload",$lang["Creating table..."]), @mysqli_query($dblink, $table_upload), $lang["Already exists?"], 0);
                  test(str_replace("%1","cache",$lang["Creating table..."]), @mysqli_query($dblink, $table_cache), $lang["Already exists?"], 0);
                  test($lang["adding admin"], @mysqli_query($dblink, $insert_admin), $lang["Hmm!"], 0);
                  test($lang["Adding some pages..."], 1);
                  require("setup/inserts.php");
                  break;

               /*
                  The funny upgrading stuff. Make sure these are in order!
                  And yes, there are no (switch) breaks here. This is on purpose.
               */

               // from 0.1 to 0.1.1
               case "0.1":
                  print("<strong>0.1 ".$lang["to"]." 0.1.1</strong><br />\n");
                  test($lang["pages alter"], @mysqli_query($dblink, $alter_pages_r0_1), $lang["Hmm!"], 0);

               // from 0.1.1 to 0.1.2
               case "0.1.1":
                  print("<strong>0.1.1 ".$lang["to"]."o 0.1.2</strong><br />\n");
                  test($lang["0.1.1"], 1);

               // from Wakka 0.1.2 or Wacko R1
               case "0.1.2":
               case "0.1.3-dev":
                  print("<strong>0.1.2 ".$lang["to"]." Wacko R2</strong><br />\n");
                  test($lang["useralter"], @mysqli_query($dblink, $alter_users_r0_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","watches",$lang["Creating table..."]), @mysqli_query($dblink, $table_pagewatches_r0), $lang["Already exists?"], 0);
                  test($lang["Claiming all your base..."], 1);

               // from Wacko R2
               case "R2":
                  print("<strong>Wacko R2 ".$lang["to"]." R3</strong><br />\n");
                  test($lang["useralter"], @mysqli_query($dblink, $alter_users_r2_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysqli_query($dblink, $alter_pages_r2_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","acls",$lang["And table..."]), @mysqli_query($dblink, $alter_acls_r2_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","links",$lang["And table..."]), @mysqli_query($dblink, $alter_links_r2_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","referrers",$lang["And table..."]), @mysqli_query($dblink, $alter_referrers_r2_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","watches",$lang["And table..."]), @mysqli_query($dblink, $alter_pagewatches_r2_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","revision",$lang["Creating table..."]), @mysqli_query($dblink, $table_revisions_r2), $lang["Already exists?"], 0);
                  test($lang["Moving data to revisions table..."], @mysqli_query($dblink, $insert_revisions_r2_1), $lang["VeryBad"], 0);
                  test($lang["pages alter"], @mysqli_query($dblink, $alter_pages_r2_2), $lang["Doubles"], 0);

                  test($lang["Adding some pages..."], 1);
                  require("setup/inserts.php");

               // from Wacko R3
               case "R3":
                  print("<strong>Wacko R3/3.5 ".$lang["to"]." R4</strong><br />\n");
                  test($lang["useralter"], @mysqli_query($dblink, $alter_users_r3_1), $lang["Hmm!"], 0);
                  test($lang["useralter"], @mysqli_query($dblink, $alter_users_r3_2), $lang["Hmm!"], 0);
                  test($lang["useralter"], @mysqli_query($dblink, $alter_users_r3_3), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @mysqli_query($dblink, $alter_revisions_r3_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @mysqli_query($dblink, $alter_revisions_r3_2), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @mysqli_query($dblink, $alter_revisions_r3_3), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @mysqli_query($dblink, $alter_revisions_r3_4), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @mysqli_query($dblink, $alter_revisions_r3_5), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @mysqli_query($dblink, $alter_revisions_r3_6), $lang["Hmm!"], 0);

                  test(str_replace("%1","links",$lang["And table..."]), @mysqli_query($dblink, $alter_links_r3_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","links",$lang["And table..."]), @mysqli_query($dblink, $alter_links_r3_2), $lang["Hmm!"], 0);
                  test(str_replace("%1","links",$lang["And table..."]), @mysqli_query($dblink, $alter_links_r3_3), $lang["Hmm!"], 0);

                  test(str_replace("%1","acls",$lang["And table..."]), @mysqli_query($dblink, $alter_acls_r3_1), $lang["Hmm!"], 0);

                  test(str_replace("%1","pagewatches",$lang["And table..."]), @mysqli_query($dblink, $alter_pagewatches_r3_1), $lang["Hmm!"], 0);

                  test(str_replace("%1","referrers",$lang["And table..."]), @mysqli_query($dblink, $alter_referrers_r3_1), $lang["Hmm!"], 0);

                  @mysqli_query($dblink, $alter_pages_r3_1);
                  @mysqli_query($dblink, $alter_pages_r3_2);
                  @mysqli_query($dblink, $alter_pages_r3_3);

                  test(str_replace("%1","pages",$lang["And table..."]), @mysqli_query($dblink, $alter_pages_r3_4), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysqli_query($dblink, $alter_pages_r3_5), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysqli_query($dblink, $alter_pages_r3_6), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysqli_query($dblink, $alter_pages_r3_7), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysqli_query($dblink, $alter_pages_r3_8), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysqli_query($dblink, $alter_pages_r3_9), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysqli_query($dblink, $alter_pages_r3_10), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysqli_query($dblink, $alter_pages_r3_11), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @mysqli_query($dblink, $alter_pages_r3_12), $lang["Hmm!"], 0);

                  test(str_replace("%1","upload",$lang["Creating table..."]), @mysqli_query($dblink, $table_upload), $lang["Already exists?"], 0);

                  test("", @mysqli_query($dblink, $update_pages_r3_1), "", 0);
                  test("", @mysqli_query($dblink, $update_pages_r3_2), "", 0);

               //from R4 beta
               case "R4":
                  print("<strong>Wacko R4 beta ".$lang["to"]." R4 RC1</strong><br />\n");
                  test(str_replace("%1","cache",$lang["Creating table..."]), @mysqli_query($dblink, $table_cache), $lang["Already exists?"], 0);

               //from R4 release candidat
               case "R4 RC1":
                  print("<strong>Wacko R4 RC1 ".$lang["to"]." R4.0</strong><br />\n");

               //from R4.0 to R4.2
               case "R4.0":
                  print("<strong>Wacko R4.0 ".$lang["to"]." R4.2</strong><br />\n");

               //from R4.2 to R4.3
               case "R4.2":
                  print("<strong>Wacko R4.2 ".$lang["to"]." R4.3</strong><br />\n");
                  test(str_replace("%1","pages",$lang["And table..."]), @mysqli_query($dblink, $alter_pages_r4_3), $lang["Hmm!"], 0);
            }

         test($lang["adding logo image..."], @mysqli_query($dblink, $insert_logo_image), $lang["Already exists?"], 0);
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
               default:
                  $dsn = $config2["database_driver"].":dbname=".$config2["database_database"].";host=".$config2["database_host"].($config2["database_port"] != "" ? ";port=".$config2["database_port"] : "");
            }

         // PHP4 doesn't support try/catch blocks
          /*try
             {*/
               $dblink = @new PDO($dsn, $config2["database_user"], $config2["database_password"]);
               test($lang["TestSql"], true);
            /*}
          catch(PDOException $e)
             {
               test($lang["TestSql"], false, "PDO DSN Error: ".$dsn);
             }*/

         print("<br />\n");

         if (!$version = trim($wakkaConfig["wakka_version"])) $version = "0";
         if (trim($wakkaConfig["wacko_version"])) $version = trim($wakkaConfig["wacko_version"]);
         switch ($version)
            {
               // new installation
               case "0":
                  print("<strong>".$lang["Installing Stuff"]."</strong><br />\n");
                  test(str_replace("%1","page",$lang["Creating table..."]), @$dblink->query($table_pages), $lang["Already exists?"], 0);
                  test(str_replace("%1","revision",$lang["Creating table..."]), @$dblink->query($table_revisions), $lang["Already exists?"], 0);
                  test(str_replace("%1","ACL",$lang["Creating table..."]), @$dblink->query($table_acls), $lang["Already exists?"], 0);
                  test(str_replace("%1","link tracking",$lang["Creating table..."]), @$dblink->query($table_links), $lang["Already exists?"], 0);
                  test(str_replace("%1","referrer",$lang["Creating table..."]), @$dblink->query($table_referrers), $lang["Already exists?"], 0);
                  test(str_replace("%1","user",$lang["Creating table..."]), @$dblink->query($table_users), $lang["Already exists?"], 0);
                  test(str_replace("%1","watches",$lang["Creating table..."]), @$dblink->query($table_pagewatches), $lang["Already exists?"], 0);
                  test(str_replace("%1","upload",$lang["Creating table..."]), @$dblink->query($table_upload), $lang["Already exists?"], 0);
                  test(str_replace("%1","cache",$lang["Creating table..."]), @$dblink->query($table_cache), $lang["Already exists?"], 0);
                  test($lang["adding admin"], @$dblink->query($insert_admin), $lang["Hmm!"], 0);
                  test($lang["Adding some pages..."], 1);
                  require("setup/inserts.php");
                  break;

               /*
                  The funny upgrading stuff. Make sure these are in order!
                  And yes, there are no (switch) breaks here. This is on purpose.
               */

               // from 0.1 to 0.1.1
               case "0.1":
                  print("<strong>0.1 ".$lang["to"]." 0.1.1</strong><br />\n");
                  test($lang["pages alter"], @$dblink->query($alter_pages_r0_1), $lang["Hmm!"], 0);

               // from 0.1.1 to 0.1.2
               case "0.1.1":
                  print("<strong>0.1.1 ".$lang["to"]."o 0.1.2</strong><br />\n");
                  test($lang["0.1.1"], 1);

               // from Wakka 0.1.2 or Wacko R1
               case "0.1.2":
               case "0.1.3-dev":
                  print("<strong>0.1.2 ".$lang["to"]." Wacko R2</strong><br />\n");
                  test($lang["useralter"], @$dblink->query($alter_users_r0_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","watches",$lang["Creating table..."]), @$dblink->query($table_pagewatches_r0), $lang["Already exists?"], 0);
                  test($lang["Claiming all your base..."], 1);

               // from Wacko R2
               case "R2":
                  print("<strong>Wacko R2 ".$lang["to"]." R3</strong><br />\n");
                  test($lang["useralter"], @$dblink->query($alter_users_r2_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @$dblink->query($alter_pages_r2_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","acls",$lang["And table..."]), @$dblink->query($alter_acls_r2_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","links",$lang["And table..."]), @$dblink->query($alter_links_r2_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","referrers",$lang["And table..."]), @$dblink->query($alter_referrers_r2_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","watches",$lang["And table..."]), @$dblink->query($alter_pagewatches_r2_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","revision",$lang["Creating table..."]), @$dblink->query($table_revisions_r2), $lang["Already exists?"], 0);
                  test($lang["Moving data to revisions table..."], @$dblink->query($insert_revisions_r2_1), $lang["VeryBad"], 0);
                  test($lang["pages alter"], @$dblink->query($alter_pages_r2_2), $lang["Doubles"], 0);

                  test($lang["Adding some pages..."], 1);
                  require("setup/inserts.php");

               // from Wacko R3
               case "R3":
                  print("<strong>Wacko R3/3.5 ".$lang["to"]." R4</strong><br />\n");
                  test($lang["useralter"], @$dblink->query($alter_users_r3_1), $lang["Hmm!"], 0);
                  test($lang["useralter"], @$dblink->query($alter_users_r3_2), $lang["Hmm!"], 0);
                  test($lang["useralter"], @$dblink->query($alter_users_r3_3), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @$dblink->query($alter_revisions_r3_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @$dblink->query($alter_revisions_r3_2), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @$dblink->query($alter_revisions_r3_3), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @$dblink->query($alter_revisions_r3_4), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @$dblink->query($alter_revisions_r3_5), $lang["Hmm!"], 0);
                  test(str_replace("%1","revisions",$lang["And table..."]), @$dblink->query($alter_revisions_r3_6), $lang["Hmm!"], 0);

                  test(str_replace("%1","links",$lang["And table..."]), @$dblink->query($alter_links_r3_1), $lang["Hmm!"], 0);
                  test(str_replace("%1","links",$lang["And table..."]), @$dblink->query($alter_links_r3_2), $lang["Hmm!"], 0);
                  test(str_replace("%1","links",$lang["And table..."]), @$dblink->query($alter_links_r3_3), $lang["Hmm!"], 0);

                  test(str_replace("%1","acls",$lang["And table..."]), @$dblink->query($alter_acls_r3_1), $lang["Hmm!"], 0);

                  test(str_replace("%1","pagewatches",$lang["And table..."]), @$dblink->query($alter_pagewatches_r3_1), $lang["Hmm!"], 0);

                  test(str_replace("%1","referrers",$lang["And table..."]), @$dblink->query($alter_referrers_r3_1), $lang["Hmm!"], 0);

                  @$dblink->query($alter_pages_r3_1);
                  @$dblink->query($alter_pages_r3_2);
                  @$dblink->query($alter_pages_r3_3);

                  test(str_replace("%1","pages",$lang["And table..."]), @$dblink->query($alter_pages_r3_4), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @$dblink->query($alter_pages_r3_5), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @$dblink->query($alter_pages_r3_6), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @$dblink->query($alter_pages_r3_7), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @$dblink->query($alter_pages_r3_8), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @$dblink->query($alter_pages_r3_9), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @$dblink->query($alter_pages_r3_10), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @$dblink->query($alter_pages_r3_11), $lang["Hmm!"], 0);
                  test(str_replace("%1","pages",$lang["And table..."]), @$dblink->query($alter_pages_r3_12), $lang["Hmm!"], 0);

                  test(str_replace("%1","upload",$lang["Creating table..."]), @$dblink->query($table_upload), $lang["Already exists?"], 0);

                  test("", @$dblink->query($update_pages_r3_1), "", 0);
                  test("", @$dblink->query($update_pages_r3_2), "", 0);

               //from R4 beta
               case "R4":
                  print("<strong>Wacko R4 beta ".$lang["to"]." R4 RC1</strong><br />\n");
                  test(str_replace("%1","cache",$lang["Creating table..."]), @$dblink->query($table_cache), $lang["Already exists?"], 0);

               //from R4 release candidat
               case "R4 RC1":
                  print("<strong>Wacko R4 RC1 ".$lang["to"]." R4.0</strong><br />\n");

               //from R4.0 to R4.2
               case "R4.0":
                  print("<strong>Wacko R4.0 ".$lang["to"]." R4.2</strong><br />\n");

               //from R4.2 to R4.3
               case "R4.2":
                  print("<strong>Wacko R4.2 ".$lang["to"]." R4.3</strong><br />\n");
                  test(str_replace("%1","pages",$lang["And table..."]), @$dblink->query($alter_pages_r4_3), $lang["Hmm!"], 0);
            }

         test($lang["adding logo image..."], @$dblink->query($insert_logo_image), $lang["Already exists?"], 0);
         break;
   }
?>

<p>
   <?php echo $lang["NextStep"];?> <tt><?php echo $wakkaConfigLocation ?></tt>.
   <?php echo $lang["MakeWrite"];?>.
   <?php echo $lang["ForDetailsSee"];?>.
</p>

<form action="<?php echo myLocation(); ?>?installAction=writeconfig" method="post">
   <input type="hidden" name="config_s" value="<?php echo htmlspecialchars(serialize($config)) ?>" />
   <input type="hidden" name="config[language]" value="<?php echo $config["language"]; ?>" />
   <input type="submit" value="<?php echo $lang["Continue"];?>" />
</form>