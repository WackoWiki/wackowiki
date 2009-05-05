<?php
/*
 Wacko Wiki MySQL Table Updates Script

 These are all the updates that need to applied to earlier Wacko version to bring them up to 4.3 specs
 */

$table_pagewatches_r0 = "CREATE TABLE ".$config["table_prefix"]."pagewatches (".
                        "id int(10) NOT NULL auto_increment, ".
                        "user varchar(80) NOT NULL default '', ".
                        "tag varchar(50) binary NOT NULL default '', ".
                        "time timestamp(14) NOT NULL, ".
                        "PRIMARY KEY  (id)) TYPE=MyISAM";

$table_revisions_r2 = "CREATE TABLE ".$config["table_prefix"]."revisions (".
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

$insert_revisions_r2_1 = "INSERT INTO ".$config["table_prefix"]."revisions ( id, tag, supertag, time, body, body_r, owner, user, latest, handler, comment_on ) SELECT id, tag, supertag, time, body, body_r, owner, user, latest, handler, comment_on FROM ".$config["table_prefix"]."pages WHERE latest='N';";

$alter_pages_r0_1 = "ALTER TABLE ".$config["table_prefix"]."pages ADD body_r text NOT NULL default '' AFTER body";
$alter_pages_r2_1 = "ALTER TABLE ".$config["table_prefix"]."pages ADD supertag VARCHAR(250) NOT NULL default '' after tag, CHANGE tag tag VARCHAR(250) NOT NULL, ADD INDEX supertag (supertag)";
$alter_pages_r2_2 = "ALTER TABLE ".$config["table_prefix"]."pages DROP INDEX idx_tag, ADD UNIQUE idx_tag (tag)";
$alter_pages_r3_1 = "ALTER TABLE ".$config["table_prefix"]."pages DROP INDEX fts";
$alter_pages_r3_2 = "ALTER TABLE ".$config["table_prefix"]."pages DROP INDEX body";
$alter_pages_r3_3 = "ALTER TABLE ".$config["table_prefix"]."pages DROP INDEX tag";
$alter_pages_r3_4 = "ALTER TABLE ".$config["table_prefix"]."pages ADD FULLTEXT (body)";
$alter_pages_r3_5 = "ALTER TABLE ".$config["table_prefix"]."pages CHANGE tag tag VARCHAR(250) BINARY NOT NULL";
$alter_pages_r3_6 = "ALTER TABLE ".$config["table_prefix"]."pages CHANGE comment_on comment_on VARCHAR(250) BINARY NOT NULL";
$alter_pages_r3_7 = "ALTER TABLE ".$config["table_prefix"]."pages ADD hits INT DEFAULT '0' NOT NULL";
$alter_pages_r3_8 = "ALTER TABLE ".$config["table_prefix"]."pages ADD super_comment_on VARCHAR(250) NOT NULL AFTER comment_on";
$alter_pages_r3_9 = "ALTER TABLE ".$config["table_prefix"]."pages ADD lang VARCHAR(10) NOT NULL";
$alter_pages_r3_10 = "ALTER TABLE ".$config["table_prefix"]."pages ADD description varchar(250) NOT NULL default ''";
$alter_pages_r3_11 = "ALTER TABLE ".$config["table_prefix"]."pages ADD keywords varchar(250) BINARY NOT NULL default ''";
$alter_pages_r3_12 = "ALTER TABLE ".$config["table_prefix"]."pages ADD body_toc text NOT NULL default '' AFTER body_r";
$alter_pages_r4_2 = "ALTER TABLE ".$config["table_prefix"]."pages MODIFY COLUMN tag VARCHAR(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";
$alter_pages_r4_2_1 = "ALTER TABLE ".$config["table_prefix"]."pages ADD created datetime NOT NULL default '0000-00-00 00:00:00' AFTER supertag, ADD INDEX idx_created (created)";
$alter_pages_r4_2_2 = "ALTER TABLE ".$config["table_prefix"]."pages MODIFY COLUMN body MEDIUMTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";
$alter_pages_r4_2_3 = "ALTER TABLE ".$config["table_prefix"]."pages MODIFY COLUMN body_r MEDIUMTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";

$update_pages_r3_1 = "UPDATE ".$config["table_prefix"]."pages SET body_r=''";
$update_pages_r3_2 = "UPDATE ".$config["table_prefix"]."pages SET body_toc=''";
$update_pages_r4_2 = "UPDATE ".$config["table_prefix"]."pages SET body_r=''";

$alter_users_r0_1 = "ALTER TABLE ".$config["table_prefix"]."users ADD bookmarks text NOT NULL default '', ADD lang VARCHAR(20) NOT NULL default '', ADD show_spaces enum('Y','N') NOT NULL default 'Y'";
$alter_users_r2_1 = "ALTER TABLE ".$config["table_prefix"]."users ADD showdatetime enum('Y','N') NOT NULL default 'Y', ADD typografica enum('Y','N') NOT NULL default 'Y'";
$alter_users_r3_1 = "ALTER TABLE ".$config["table_prefix"]."users ADD more TEXT NOT NULL";
$alter_users_r3_2 = "ALTER TABLE ".$config["table_prefix"]."users ADD changepassword VARCHAR(100) NOT NULL";
$alter_users_r3_3 = "ALTER TABLE ".$config["table_prefix"]."users ADD email_confirm VARCHAR(100) NOT NULL";

$alter_acls_r2_1 = "ALTER TABLE ".$config["table_prefix"]."acls ADD supertag VARCHAR(250) NOT NULL default '', CHANGE page_tag page_tag VARCHAR(250) NOT NULL, ADD INDEX(supertag)";
$alter_acls_r3_1 = "ALTER TABLE ".$config["table_prefix"]."acls CHANGE page_tag page_tag VARCHAR(250) BINARY NOT NULL";

$alter_links_r2_1 = "ALTER TABLE ".$config["table_prefix"]."links CHANGE from_tag from_tag VARCHAR(250) NOT NULL, CHANGE to_tag to_tag VARCHAR(250) NOT NULL";
$alter_links_r3_1 = "ALTER TABLE ".$config["table_prefix"]."links CHANGE from_tag from_tag CHAR(250) BINARY NOT NULL";
$alter_links_r3_2 = "ALTER TABLE ".$config["table_prefix"]."links CHANGE to_tag to_tag CHAR(250) BINARY NOT NULL";
$alter_links_r3_3 = "ALTER TABLE ".$config["table_prefix"]."links ADD to_supertag VARCHAR(250) NOT NULL";

$alter_referrers_r2_1 = "ALTER TABLE ".$config["table_prefix"]."referrers CHANGE page_tag page_tag VARCHAR(250) NOT NULL";
$alter_referrers_r3_1 = "ALTER TABLE ".$config["table_prefix"]."referrers CHANGE page_tag page_tag CHAR(250) BINARY NOT NULL";

$alter_pagewatches_r2_1 = "ALTER TABLE ".$config["table_prefix"]."pagewatches CHANGE tag tag VARCHAR(250) NOT NULL";
$alter_pagewatches_r3_1 = "ALTER TABLE ".$config["table_prefix"]."pagewatches CHANGE tag tag VARCHAR(250) BINARY NOT NULL";

$alter_revisions_r3_1 = "ALTER TABLE ".$config["table_prefix"]."revisions CHANGE tag tag VARCHAR(250) BINARY NOT NULL";
$alter_revisions_r3_2 = "ALTER TABLE ".$config["table_prefix"]."revisions CHANGE comment_on comment_on VARCHAR(250) BINARY NOT NULL";
$alter_revisions_r3_3 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD super_comment_on VARCHAR(250) NOT NULL AFTER comment_on";
$alter_revisions_r3_4 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD lang VARCHAR(10) NOT NULL";
$alter_revisions_r3_5 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD description VARCHAR(250) NOT NULL default ''";
$alter_revisions_r3_6 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD keywords VARCHAR(250) BINARY NOT NULL default ''";
$alter_revisions_r4_2_1 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD created datetime NOT NULL default '0000-00-00 00:00:00' AFTER supertag";
$alter_revisions_r4_2_2 = "ALTER TABLE ".$config["table_prefix"]."revisions MODIFY COLUMN body MEDIUMTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";
$alter_revisions_r4_2_3 = "ALTER TABLE ".$config["table_prefix"]."revisions MODIFY COLUMN body_r MEDIUMTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";

?>