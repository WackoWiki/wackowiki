<?php
/*
 Wacko Wiki MySQL Table Updates Script

 These are all the updates that need to applied to earlier Wacko version to bring them up to 4.3 specs
 */

// ACL
$alter_acls_r2_1 = "ALTER TABLE ".$config["table_prefix"]."acls ADD supertag VARCHAR(250) NOT NULL DEFAULT '', CHANGE page_tag page_tag VARCHAR(250) NOT NULL, ADD INDEX(supertag)";
$alter_acls_r3_1 = "ALTER TABLE ".$config["table_prefix"]."acls CHANGE page_tag page_tag VARCHAR(250) BINARY NOT NULL";
$alter_acls_r4_2 = "ALTER TABLE ".$config["table_prefix"]."acls ADD page_id INT(10) UNSIGNED NOT NULL AFTER page_tag";
$alter_acls_r4_2_1 = "ALTER TABLE ".$config["table_prefix"]."acls CHANGE privilege privilege VARCHAR(10) NOT NULL";

$update_acls_r4_2 = "UPDATE ".$config["table_prefix"]."acls AS acls, (SELECT id, tag FROM ".$config["table_prefix"]."pages) AS pages SET acls.page_id = pages.id WHERE acls.page_tag = pages.tag";

// CACHE
$alter_cache_r4_2 = "ALTER TABLE ".$config["table_prefix"]."cache ADD time TIMESTAMP NOT NULL, ADD INDEX timestamp (time)";

// LINKS
$alter_links_r2_1 = "ALTER TABLE ".$config["table_prefix"]."links CHANGE from_tag from_tag VARCHAR(250) NOT NULL, CHANGE to_tag to_tag VARCHAR(250) NOT NULL";
$alter_links_r3_1 = "ALTER TABLE ".$config["table_prefix"]."links CHANGE from_tag from_tag CHAR(250) BINARY NOT NULL";
$alter_links_r3_2 = "ALTER TABLE ".$config["table_prefix"]."links CHANGE to_tag to_tag CHAR(250) BINARY NOT NULL";
$alter_links_r3_3 = "ALTER TABLE ".$config["table_prefix"]."links ADD to_supertag VARCHAR(250) NOT NULL";
$alter_links_r4_2 = "ALTER TABLE ".$config["table_prefix"]."links ADD id INT(10) UNSIGNED NOT NULL auto_increment FIRST, ADD PRIMARY KEY (id)";
$alter_links_r4_2_1 = "ALTER TABLE ".$config["table_prefix"]."links ADD from_page_id INT(10) UNSIGNED NOT NULL AFTER from_tag";
$alter_links_r4_2_2 = "ALTER TABLE ".$config["table_prefix"]."links ADD to_page_id INT(10) UNSIGNED NOT NULL AFTER to_tag";

$update_links_r4_2 = "UPDATE ".$config["table_prefix"]."links AS links, (SELECT id, tag FROM ".$config["table_prefix"]."pages) AS pages SET links.from_page_id = pages.id WHERE links.from_tag = pages.tag";
$update_links_r4_2_1 = "UPDATE ".$config["table_prefix"]."links AS links, (SELECT id, tag FROM ".$config["table_prefix"]."pages) AS pages SET links.to_page_id = pages.id WHERE links.to_tag = pages.tag";

// LOG
$table_log_r4_2 = "CREATE TABLE ".$config["table_prefix"]."log (".
				"id INT(10) UNSIGNED NOT NULL auto_increment,".
				"time TIMESTAMP NOT NULL,".
				"level TINYINT(1) NOT NULL,".
				"user VARCHAR(100) NOT NULL,".
				"ip VARCHAR(15) NOT NULL,".
				"message TEXT NOT NULL,".
				"PRIMARY KEY (id),".
				"KEY idx_level (level),".
				"KEY idx_user (user),".
				"KEY idx_ip (ip),".
				"KEY idx_time (time)".
			") TYPE=MyISAM";

// PAGES
$alter_pages_r0_1 = "ALTER TABLE ".$config["table_prefix"]."pages ADD body_r TEXT NOT NULL DEFAULT '' AFTER body";
$alter_pages_r2_1 = "ALTER TABLE ".$config["table_prefix"]."pages ADD supertag VARCHAR(250) NOT NULL DEFAULT '' after tag, CHANGE tag tag VARCHAR(250) NOT NULL, ADD INDEX supertag (supertag)";
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
$alter_pages_r3_10 = "ALTER TABLE ".$config["table_prefix"]."pages ADD description VARCHAR(250) NOT NULL DEFAULT ''";
$alter_pages_r3_11 = "ALTER TABLE ".$config["table_prefix"]."pages ADD keywords VARCHAR(250) BINARY NOT NULL DEFAULT ''";
$alter_pages_r3_12 = "ALTER TABLE ".$config["table_prefix"]."pages ADD body_toc TEXT NOT NULL DEFAULT '' AFTER body_r";
$alter_pages_r4_2 = "ALTER TABLE ".$config["table_prefix"]."pages MODIFY COLUMN tag VARCHAR(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";
$alter_pages_r4_2_1 = "ALTER TABLE ".$config["table_prefix"]."pages ADD created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER supertag, ADD INDEX idx_created (created), DROP INDEX idx_latest";
$alter_pages_r4_2_2 = "ALTER TABLE ".$config["table_prefix"]."pages MODIFY COLUMN body MEDIUMTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";
$alter_pages_r4_2_3 = "ALTER TABLE ".$config["table_prefix"]."pages MODIFY COLUMN body_r MEDIUMTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";
$alter_pages_r4_2_4 = "ALTER TABLE ".$config["table_prefix"]."pages ADD title VARCHAR(100) NOT NULL DEFAULT '' AFTER lang, ADD INDEX idx_title (title), ADD edit_note VARCHAR(100) NOT NULL DEFAULT '' AFTER user";
$alter_pages_r4_2_5 = "ALTER TABLE ".$config["table_prefix"]."pages CHANGE hits hits INT(11) UNSIGNED NOT NULL DEFAULT '0'";
$alter_pages_r4_2_6 = "ALTER TABLE ".$config["table_prefix"]."pages ADD owner_id INT(10) UNSIGNED NOT NULL AFTER id";
$alter_pages_r4_2_7 = "ALTER TABLE ".$config["table_prefix"]."pages ADD user_id INT(10) UNSIGNED NOT NULL AFTER owner_id";
$alter_pages_r4_2_8 = "ALTER TABLE ".$config["table_prefix"]."pages CHANGE latest latest ENUM('Y', 'N') NOT NULL DEFAULT 'Y'";
$alter_pages_r4_2_9 = "ALTER TABLE ".$config["table_prefix"]."pages CHANGE lang lang VARCHAR(2) NOT NULL DEFAULT ''";
$alter_pages_r4_2_10 = "ALTER TABLE ".$config["table_prefix"]."pages ADD minor_edit TINYINT(1) UNSIGNED DEFAULT '0' AFTER edit_note, ADD INDEX idx_minor_edit (minor_edit)";

$update_pages_r3_1 = "UPDATE ".$config["table_prefix"]."pages SET body_r=''";
$update_pages_r3_2 = "UPDATE ".$config["table_prefix"]."pages SET body_toc=''";
$update_pages_r4_2 = "UPDATE ".$config["table_prefix"]."pages SET body_r=''";
$update_pages_r4_2_1 = "UPDATE ".$config["table_prefix"]."pages AS pages, (SELECT id, name FROM ".$config["table_prefix"]."users) AS users SET pages.owner_id = users.id WHERE pages.owner = users.name";
$update_pages_r4_2_2 = "UPDATE ".$config["table_prefix"]."pages AS pages, (SELECT id, name FROM ".$config["table_prefix"]."users) AS users SET pages.user_id = users.id WHERE pages.user = users.name";

// PAGEWATCHES
$table_pagewatches_r0 = "CREATE TABLE ".$config["table_prefix"]."pagewatches (".
                        "id INT(10) NOT NULL auto_increment, ".
                        "user VARCHAR(80) NOT NULL DEFAULT '', ".
                        "tag VARCHAR(50) binary NOT NULL DEFAULT '', ".
                        "time TIMESTAMP NOT NULL, ".
                        "PRIMARY KEY (id)) TYPE=MyISAM";

$alter_pagewatches_r2_1 = "ALTER TABLE ".$config["table_prefix"]."pagewatches CHANGE tag tag VARCHAR(250) NOT NULL";
$alter_pagewatches_r3_1 = "ALTER TABLE ".$config["table_prefix"]."pagewatches CHANGE tag tag VARCHAR(250) BINARY NOT NULL";
$alter_pagewatches_r4_2 = "ALTER TABLE ".$config["table_prefix"]."pagewatches CHANGE id id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";
$alter_pagewatches_r4_2_1 = "ALTER TABLE ".$config["table_prefix"]."pagewatches ADD user_id INT(10) UNSIGNED NOT NULL AFTER user";
$alter_pagewatches_r4_2_2 = "ALTER TABLE ".$config["table_prefix"]."pagewatches ADD page_id INT(10) UNSIGNED NOT NULL AFTER tag";

$update_pagewatches_r4_2 = "UPDATE ".$config["table_prefix"]."pagewatches AS pagewatches, (SELECT id, name FROM ".$config["table_prefix"]."users) AS users SET pagewatches.user_id = users.id WHERE pagewatches.user = users.name";
$update_pagewatches_r4_2_1 = "UPDATE ".$config["table_prefix"]."pagewatches AS pagewatches, (SELECT id, tag FROM ".$config["table_prefix"]."pages) AS pages SET pagewatches.page_id = pages.id WHERE pagewatches.tag = pages.tag";

// REFERRERS
$alter_referrers_r2_1 = "ALTER TABLE ".$config["table_prefix"]."referrers CHANGE page_tag page_tag VARCHAR(250) NOT NULL";
$alter_referrers_r3_1 = "ALTER TABLE ".$config["table_prefix"]."referrers CHANGE page_tag page_tag CHAR(250) BINARY NOT NULL";
$alter_referrers_r4_2 = "ALTER TABLE ".$config["table_prefix"]."referrers DROP INDEX idx_page_tag, CHANGE page_tag page_id INT(10) UNSIGNED NOT NULL DEFAULT '0', ADD INDEX idx_page_id (page_id)";

// REVISIONS
$table_revisions_r2 = "CREATE TABLE ".$config["table_prefix"]."revisions (".
                     "id INT(10) UNSIGNED NOT NULL auto_increment,".
                     "tag VARCHAR(250) NOT NULL DEFAULT '',".
                     "supertag VARCHAR(250) NOT NULL DEFAULT '',".
                     "time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
                     "body TEXT NOT NULL,".
                     "body_r TEXT NOT NULL,".
                     "owner VARCHAR(50) NOT NULL DEFAULT '',".
                     "user VARCHAR(50) NOT NULL DEFAULT '',".
                     "latest ENUM('Y','N') NOT NULL DEFAULT 'N',".
                     "handler VARCHAR(30) NOT NULL DEFAULT 'page',".
                     "comment_on VARCHAR(50) NOT NULL DEFAULT '',".
                     "PRIMARY KEY (id),".
                     "KEY idx_tag (tag),".
                     "KEY idx_supertag (supertag),".
                     "KEY idx_time (time),".
                     "KEY idx_latest (latest),".
                     "KEY idx_comment_on (comment_on),".
                     "KEY supertag (supertag)".
                     ") TYPE=MyISAM;";

$alter_revisions_r3_1 = "ALTER TABLE ".$config["table_prefix"]."revisions CHANGE tag tag VARCHAR(250) BINARY NOT NULL";
$alter_revisions_r3_2 = "ALTER TABLE ".$config["table_prefix"]."revisions CHANGE comment_on comment_on VARCHAR(250) BINARY NOT NULL";
$alter_revisions_r3_3 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD super_comment_on VARCHAR(250) NOT NULL AFTER comment_on";
$alter_revisions_r3_4 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD lang VARCHAR(10) NOT NULL";
$alter_revisions_r3_5 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD description VARCHAR(250) NOT NULL DEFAULT ''";
$alter_revisions_r3_6 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD keywords VARCHAR(250) BINARY NOT NULL DEFAULT ''";
$alter_revisions_r4_2_1 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER supertag, DROP INDEX idx_latest";
$alter_revisions_r4_2_2 = "ALTER TABLE ".$config["table_prefix"]."revisions MODIFY COLUMN body MEDIUMTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";
$alter_revisions_r4_2_3 = "ALTER TABLE ".$config["table_prefix"]."revisions MODIFY COLUMN body_r MEDIUMTEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL";
$alter_revisions_r4_2_4 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD title VARCHAR(100) NOT NULL DEFAULT '' AFTER lang, ADD edit_note VARCHAR(100) NOT NULL DEFAULT '' AFTER user";
$alter_revisions_r4_2_5 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD owner_id INT(10) UNSIGNED NOT NULL AFTER id";
$alter_revisions_r4_2_6 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD user_id INT(10) UNSIGNED NOT NULL AFTER owner_id";
$alter_revisions_r4_2_7 = "ALTER TABLE ".$config["table_prefix"]."revisions CHANGE lang lang VARCHAR(2) NOT NULL DEFAULT ''";
$alter_revisions_r4_2_8 = "ALTER TABLE ".$config["table_prefix"]."revisions ADD minor_edit TINYINT(1) UNSIGNED DEFAULT '0' AFTER edit_note, ADD INDEX idx_minor_edit (minor_edit)";

$insert_revisions_r2_1 = "INSERT INTO ".$config["table_prefix"]."revisions ( id, tag, supertag, time, body, body_r, owner, user, latest, handler, comment_on ) SELECT id, tag, supertag, time, body, body_r, owner, user, latest, handler, comment_on FROM ".$config["table_prefix"]."pages WHERE latest='N';";

$update_revisions_r4_2 = "UPDATE ".$config["table_prefix"]."revisions AS revisions, (SELECT id, name FROM ".$config["table_prefix"]."users) AS users SET revisions.owner_id = users.id WHERE revisions.owner = users.name";
$update_revisions_r4_2_1 = "UPDATE ".$config["table_prefix"]."revisions AS revisions, (SELECT id, name FROM ".$config["table_prefix"]."users) AS users SET revisions.user_id = users.id WHERE revisions.user = users.name";

// UPLOAD
$alter_upload_r4_2 = "ALTER TABLE ".$config["table_prefix"]."upload CHANGE id id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
																	CHANGE page_id page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
																	CHANGE filesize filesize INT(10) UNSIGNED NOT NULL DEFAULT '0',
																	CHANGE picture_w picture_w INT(10) UNSIGNED NOT NULL DEFAULT '0',
																	CHANGE picture_h picture_h INT(10) UNSIGNED NOT NULL DEFAULT '0',
																	ADD user_id INT(10) UNSIGNED NOT NULL AFTER page_id,
																	DROP INDEX user_id,
																	ADD INDEX idx_user_id (user_id)";

$alter_upload_r4_2_1 = "ALTER TABLE ".$config["table_prefix"]."upload DROP user";

$update_upload_r4_2 = "UPDATE ".$config["table_prefix"]."upload AS upload, (SELECT id, name FROM ".$config["table_prefix"]."users) AS users SET upload.user_id = users.id WHERE upload.user = users.name";

// USERS
$alter_users_r0_1 = "ALTER TABLE ".$config["table_prefix"]."users ADD bookmarks TEXT NOT NULL DEFAULT '', ADD lang VARCHAR(20) NOT NULL DEFAULT '', ADD show_spaces ENUM('Y','N') NOT NULL DEFAULT 'Y'";
$alter_users_r2_1 = "ALTER TABLE ".$config["table_prefix"]."users ADD showdatetime ENUM('Y','N') NOT NULL DEFAULT 'Y', ADD typografica ENUM('Y','N') NOT NULL DEFAULT 'Y'";
$alter_users_r3_1 = "ALTER TABLE ".$config["table_prefix"]."users ADD more TEXT NOT NULL";
$alter_users_r3_2 = "ALTER TABLE ".$config["table_prefix"]."users ADD changepassword VARCHAR(100) NOT NULL";
$alter_users_r3_3 = "ALTER TABLE ".$config["table_prefix"]."users ADD email_confirm VARCHAR(100) NOT NULL";
$alter_users_r4_2 = "ALTER TABLE ".$config["table_prefix"]."users ADD id INT(10) UNSIGNED NOT NULL auto_increment FIRST, DROP PRIMARY KEY, ADD PRIMARY KEY (id)";
$alter_users_r4_2_1 = "ALTER TABLE ".$config["table_prefix"]."users CHANGE lang lang VARCHAR(2) NOT NULL DEFAULT ''";
$alter_users_r4_2_2 = "ALTER TABLE ".$config["table_prefix"]."users CHANGE doubleclickedit doubleclickedit TINYINT(1) NOT NULL DEFAULT '1'";

?>