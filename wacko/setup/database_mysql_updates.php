<?php

/*
	Wacko Wiki MySQL Table Updates Script

	These are all the updates that need to applied to earlier Wacko version to bring them up to 5.0 specs
*/

$pref		= $config['table_prefix'];
$charset	= 'DEFAULT CHARSET=utf8';
$engine		= 'ENGINE='.$config['database_engine'];

// ACL
$rename_acl_r4_3_1 = "RENAME TABLE {$pref}acls TO {$pref}acl";

$alter_acl_r4_3_0 = "ALTER TABLE {$pref}acl CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
$alter_acl_r4_3_1 = "ALTER TABLE {$pref}acl ADD page_id INT(10) UNSIGNED NOT NULL AFTER page_tag";
$alter_acl_r4_3_2 = "ALTER TABLE {$pref}acl CHANGE privilege privilege VARCHAR(10) NOT NULL";
$alter_acl_r4_3_3 = "ALTER TABLE {$pref}acl DROP PRIMARY KEY";
$alter_acl_r4_3_4 = "ALTER TABLE {$pref}acl ADD UNIQUE idx_page_id (page_id,privilege)";
$alter_acl_r4_3_5 = "ALTER TABLE {$pref}acl DROP page_tag";
$alter_acl_r4_3_6 = "ALTER TABLE {$pref}acl DROP supertag";

$update_acl_r4_3_1 = "UPDATE {$pref}acl AS acl, (SELECT id, tag FROM {$pref}page) AS pages SET acl.page_id = pages.id WHERE acl.page_tag = pages.tag";

// CACHE
$alter_cache_r4_3_0 = "ALTER TABLE {$pref}cache CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
$alter_cache_r4_3_1 = "ALTER TABLE {$pref}cache ADD cache_time TIMESTAMP NOT NULL, ADD INDEX timestamp (cache_time)";
$alter_cache_r4_3_2 = "ALTER TABLE {$pref}cache ADD lang VARCHAR(2) NOT NULL AFTER query";

// CATEGORY
$table_category_r4_3 = "CREATE TABLE {$pref}category (".
					"category_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"parent INT(10) UNSIGNED NOT NULL,".
					"lang VARCHAR(2) NOT NULL,".
					"category VARCHAR(100) NOT NULL,".
					"PRIMARY KEY (category_id),".
					"UNIQUE KEY idx_category (lang,category)".
				") {$engine} COMMENT='' {$charset}";

$table_category_page_r4_3 = "CREATE TABLE {$pref}category_page (".
						"category_id INT(10) UNSIGNED NOT NULL,".
						"page_id INT(10) UNSIGNED NOT NULL,".
						"UNIQUE KEY idx_pageword (category_id,page_id)".
					") {$engine} COMMENT='' {$charset}";

// CONFIG
$table_config_r4_3 = "CREATE TABLE {$pref}config (".
					"config_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"config_name VARCHAR(100) NOT NULL DEFAULT '',".
					"config_value TEXT,".
					// "updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,".
					"PRIMARY KEY (config_id),".
					"UNIQUE KEY idx_config_name (config_name)".
				") {$engine} COMMENT='' {$charset}";

// GROUP
$table_group_r4_3 = "CREATE TABLE {$pref}group (".
					"group_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"group_name VARCHAR(100) NOT NULL,".
					"description VARCHAR(255) NOT NULL,".
					"moderator INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"created DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,".
					"is_system TINYINT(1) UNSIGNED NOT NULL,".
					"open TINYINT(1) UNSIGNED NOT NULL,".
					"active TINYINT(1) UNSIGNED NOT NULL,".
					// "special TINYINT(1) UNSIGNED NOT NULL,".
					"PRIMARY KEY (group_id),".
					"UNIQUE KEY idx_name (group_name)".
				") {$engine} COMMENT='' {$charset}";

$table_group_member_r4_3 = "CREATE TABLE {$pref}group_member (".
					"group_id INTEGER(10) UNSIGNED NOT NULL,".
					"user_id INTEGER(10) UNSIGNED NOT NULL,".
					"UNIQUE KEY idx_group_id (group_id, user_id)".
				") {$engine} COMMENT='' {$charset}";

// LINK
$rename_link_r4_3_1 = "RENAME TABLE {$pref}links TO {$pref}link";

// this is necessary to prevent: #1071 – Specified key was too long; max key length is 1000 bytes
$alter_link_r4_3_0 = "ALTER TABLE {$pref}link DROP INDEX from_tag,
						ADD INDEX `from_tag` ( `from_tag` , `to_tag` ( 78 ) ),
						CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
$alter_link_r4_3_1 = "ALTER TABLE {$pref}link ADD id INT(10) UNSIGNED NOT NULL auto_increment FIRST, ADD PRIMARY KEY (id)";
$alter_link_r4_3_2 = "ALTER TABLE {$pref}link ADD from_page_id INT(10) UNSIGNED NOT NULL AFTER from_tag";
$alter_link_r4_3_3 = "ALTER TABLE {$pref}link ADD to_page_id INT(10) UNSIGNED NOT NULL AFTER from_page_id";
$alter_link_r4_3_4 = "ALTER TABLE {$pref}link DROP from_tag";
$alter_link_r4_3_5 = "ALTER TABLE {$pref}link DROP INDEX from_tag, ADD INDEX from_tag (from_page_id, to_tag (78))";
$alter_link_r4_3_6 = "ALTER TABLE {$pref}link ADD INDEX idx_from_page_id (from_page_id)";

$update_link_r4_3_1 = "UPDATE {$pref}link AS link, (SELECT id, tag FROM {$pref}page) AS pages SET link.from_page_id = pages.id WHERE link.from_tag = pages.tag";
$update_link_r4_3_2 = "UPDATE {$pref}link AS link, (SELECT id, tag FROM {$pref}page) AS pages SET link.to_page_id = pages.id WHERE link.to_tag = pages.tag";

// LOG
$table_log_r4_3 = "CREATE TABLE {$pref}log (".
					"log_id INT(10) UNSIGNED NOT NULL auto_increment,".
					"log_time TIMESTAMP NOT NULL,".
					"level TINYINT(1) UNSIGNED NOT NULL,".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"ip VARCHAR(15) NOT NULL,".
					"message TEXT NOT NULL,".
					"PRIMARY KEY (log_id),".
					"KEY idx_level (level),".
					"KEY idx_user_id (user_id),".
					"KEY idx_ip (ip),".
					"KEY idx_time (log_time)".
				") {$engine} COMMENT='' {$charset}";

// MENU
$table_menu_r4_3 = "CREATE TABLE {$pref}menu (".
					"menu_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"user_id INT(10) UNSIGNED NOT NULL,".
					"page_id INT(10) UNSIGNED NOT NULL,".
					"lang VARCHAR(2) NOT NULL,".
					"menu_title VARCHAR(100) NOT NULL,".
					"menu_position SMALLINT(2) UNSIGNED NOT NULL,".
					"PRIMARY KEY (menu_id),".
					"UNIQUE KEY idx_user_id (user_id,page_id)".
				") {$engine} COMMENT='' {$charset};";

// PAGE
$rename_page_r4_3_1 = "RENAME TABLE {$pref}pages TO {$pref}page";

$alter_page_r4_2_1 = "ALTER TABLE {$pref}pages MODIFY COLUMN body MEDIUMTEXT NOT NULL";
$alter_page_r4_2_2 = "ALTER TABLE {$pref}pages MODIFY COLUMN body_r MEDIUMTEXT NOT NULL";

$alter_page_r4_3_0 = "ALTER TABLE {$pref}page CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
$alter_page_r4_3_3 = "ALTER TABLE {$pref}page ADD created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER supertag, ADD INDEX idx_created (created), DROP INDEX idx_latest";
$alter_page_r4_3_4 = "ALTER TABLE {$pref}page ADD title VARCHAR(100) NOT NULL DEFAULT '' AFTER supertag, ADD INDEX idx_title (title), ADD edit_note VARCHAR(100) NOT NULL DEFAULT '' AFTER user";
$alter_page_r4_3_5 = "ALTER TABLE {$pref}page CHANGE hits hits INT(11) UNSIGNED NOT NULL DEFAULT '0'";
$alter_page_r4_3_6 = "ALTER TABLE {$pref}page ADD owner_id INT(10) UNSIGNED NOT NULL AFTER id, ADD INDEX idx_owner_id (owner_id)";
$alter_page_r4_3_7 = "ALTER TABLE {$pref}page ADD user_id INT(10) UNSIGNED NOT NULL AFTER owner_id, ADD INDEX idx_user_id (user_id)";
$alter_page_r4_3_8 = "ALTER TABLE {$pref}page CHANGE latest latest TINYINT(1) NOT NULL DEFAULT '1'";
$alter_page_r4_3_9 = "ALTER TABLE {$pref}page CHANGE lang lang VARCHAR(2) NOT NULL DEFAULT ''";
$alter_page_r4_3_10 = "ALTER TABLE {$pref}page ADD minor_edit TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER edit_note, ADD INDEX idx_minor_edit (minor_edit)";
$alter_page_r4_3_11 = "ALTER TABLE {$pref}page ADD comment_on_id INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER super_comment_on, ADD INDEX idx_comment_on_id (comment_on_id)";
$alter_page_r4_3_12 = "ALTER TABLE {$pref}page ADD comments INT(4) UNSIGNED NOT NULL DEFAULT '0' AFTER comment_on_id";
$alter_page_r4_3_13 = "ALTER TABLE {$pref}page DROP comment_on";
$alter_page_r4_3_14 = "ALTER TABLE {$pref}page DROP super_comment_on";
$alter_page_r4_3_15 = "ALTER TABLE {$pref}page DROP owner";
$alter_page_r4_3_16 = "ALTER TABLE {$pref}page DROP user";
$alter_page_r4_3_17 = "ALTER TABLE {$pref}page ADD ip VARCHAR(15) NOT NULL AFTER minor_edit";
$alter_page_r4_3_18 = "ALTER TABLE {$pref}page CHANGE id page_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";
$alter_page_r4_3_19 = "ALTER TABLE {$pref}page CHANGE time modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'";
$alter_page_r4_3_20 = "ALTER TABLE {$pref}page DROP INDEX idx_time, ADD INDEX idx_modified (modified)";
$alter_page_r4_3_21 = "ALTER TABLE {$pref}page ADD commented DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER title, ADD INDEX idx_commented (commented)";
$alter_page_r4_3_22 = "ALTER TABLE {$pref}page ADD footer_comments TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_23 = "ALTER TABLE {$pref}page ADD footer_files TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_24 = "ALTER TABLE {$pref}page ADD footer_rating TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_25 = "ALTER TABLE {$pref}page ADD hide_toc TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_26 = "ALTER TABLE {$pref}page ADD hide_index TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_27 = "ALTER TABLE {$pref}page ADD reviewed TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER hide_index";
$alter_page_r4_3_28 = "ALTER TABLE {$pref}page ADD tree_level TINYINT(1) UNSIGNED NOT NULL DEFAULT '0'";
$alter_page_r4_3_29 = "ALTER TABLE {$pref}page ADD allow_rawhtml TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_30 = "ALTER TABLE {$pref}page ADD disable_safehtml TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_31 = "ALTER TABLE {$pref}page ADD noindex TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_32 = "ALTER TABLE {$pref}page ADD theme VARCHAR(20) DEFAULT NULL AFTER hits";
$alter_page_r4_3_33 = "ALTER TABLE {$pref}page ADD formatting VARCHAR(20) NOT NULL DEFAULT 'wacko' AFTER body_r";
$alter_page_r4_3_34 = "ALTER TABLE {$pref}page ADD reviewer_id INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER reviewed";
$alter_page_r4_3_35 = "ALTER TABLE {$pref}page ADD reviewed_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER reviewed";
$alter_page_r4_3_36 = "ALTER TABLE {$pref}page ADD menu_tag VARCHAR(250) NOT NULL DEFAULT '' AFTER supertag";
$alter_page_r4_3_37 = "ALTER TABLE {$pref}page ADD depth INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER menu_tag, ADD INDEX idx_depth(depth)";
$alter_page_r4_3_38 = "ALTER TABLE {$pref}page ADD parent_id INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER depth";
$alter_page_r4_3_39 = "ALTER TABLE {$pref}page ADD show_menu_tag TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER tree_level";
$alter_page_r4_3_40 = "ALTER TABLE {$pref}page ADD deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER noindex";

$update_page_r4_3_1 = "UPDATE {$pref}page SET body_r=''";

// FIXME: breaks somewhat the naming rules
$update_page_r4_3_2_1 = "DELETE {$pref}link.* FROM {$pref}link INNER JOIN {$pref}page ON ({$pref}link.to_tag = {$pref}page.tag) WHERE {$pref}page.user = 'WackoInstaller'";
$update_page_r4_3_2_2 = "DELETE {$pref}acl.* FROM {$pref}page INNER JOIN {$pref}acl ON ({$pref}page.id = {$pref}acl.page_id) WHERE {$pref}page.user = 'WackoInstaller'";
$update_page_r4_3_2_3 = "DELETE {$pref}watch.* FROM {$pref}page INNER JOIN {$pref}watch ON ({$pref}page.tag = {$pref}watch.tag) WHERE {$pref}page.user = 'WackoInstaller'";
$update_page_r4_3_2_4 = "DELETE {$pref}referrer.* FROM {$pref}referrer INNER JOIN {$pref}page ON ({$pref}referrer.page_tag = {$pref}page.tag) WHERE {$pref}page.user = 'WackoInstaller'";
$update_page_r4_3_2_5 = "DELETE {$pref}page.* FROM {$pref}page WHERE {$pref}page.user = 'WackoInstaller'";

$update_page_r4_3_4 = "UPDATE {$pref}page AS page, (SELECT user_id, user_name FROM {$pref}user) AS users SET page.owner_id = users.user_id WHERE page.owner = users.user_name";
$update_page_r4_3_5 = "UPDATE {$pref}page AS page, (SELECT user_id, user_name FROM {$pref}user) AS users SET page.user_id = users.user_id WHERE page.user = users.user_name";
$update_page_r4_3_6 = "UPDATE {$pref}page AS page, (SELECT id, tag FROM {$pref}page) AS pages2 SET page.comment_on_id = pages2.id WHERE page.comment_on = pages2.tag";
$update_page_r4_3_7 = "UPDATE {$pref}page AS page, (SELECT comment_on_id, COUNT(comment_on_id) as n FROM {$pref}page WHERE comment_on_id != '0' GROUP BY comment_on_id) AS comments_on SET page.comments = comments_on.n WHERE page.id = comments_on.comment_on_id";
$update_page_r4_3_8 = "UPDATE {$pref}page AS page, (SELECT tag, MIN(time) AS oldest FROM {$pref}revision GROUP BY tag) AS revisions SET page.created = revisions.oldest WHERE page.tag = revisions.tag AND page.created IS NULL";
$update_page_r4_3_9 = "UPDATE {$pref}page AS page SET page.created = page.time WHERE page.created IS NULL";
$update_page_r4_3_10 = "UPDATE {$pref}page AS page SET minor_edit = '0' WHERE page.minor_edit IS NULL";
$update_page_r4_3_11 = "UPDATE {$pref}page SET formatting = 'wacko' WHERE formatting IS NULL";
$update_page_r4_3_12 = "UPDATE {$pref}page AS page SET reviewed = '0' WHERE page.reviewed IS NULL";
$update_page_r4_3_13 = "UPDATE {$pref}page AS page SET tree_level = '0' WHERE page.tree_level IS NULL";

// POLL
$table_poll_r4_3 = "CREATE TABLE {$pref}poll (".
					"poll_id INT(10) UNSIGNED NOT NULL,".
					"v_id TINYINT(3) UNSIGNED NOT NULL,".
					"text VARCHAR(255) NOT NULL,".
					"user_id INT(10) UNSIGNED NOT NULL,".
					"plural TINYINT(1) NOT NULL,".
					"votes SMALLINT(5) UNSIGNED NOT NULL,".
					"start DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"end DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"KEY idx_poll_id (poll_id),".
					"KEY idx_time_frame (start,end)".
				") {$engine} COMMENT='' {$charset}";

// RATING
$table_rating_r4_3 = "CREATE TABLE {$pref}rating (".
					"page_id int(10) UNSIGNED NOT NULL,".
					"value INT(11) NOT NULL,".
					"voters INT(10) UNSIGNED NOT NULL,".
					"rating_time TIMESTAMP NOT NULL,".
					"PRIMARY KEY (page_id),".
					"KEY idx_voters_rate (voters)".
				") {$engine} COMMENT='' {$charset}";

// REFERRER
$rename_referrer_r4_3_1 = "RENAME TABLE {$pref}referrers TO {$pref}referrer";

$alter_referrer_r4_3_0 = "ALTER TABLE {$pref}referrer CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
$alter_referrer_r4_3_1 = "ALTER TABLE {$pref}referrer DROP INDEX idx_page_tag, CHANGE page_tag page_id INT(10) UNSIGNED NOT NULL DEFAULT '0', ADD INDEX idx_page_id (page_id)";
$alter_referrer_r4_3_2 = "ALTER TABLE {$pref}referrer CHANGE time referrer_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'";
$alter_referrer_r4_3_3 = "ALTER TABLE {$pref}referrer CHANGE referrer referrer VARCHAR(255) NOT NULL DEFAULT ''";

// REVISION
$rename_revision_r4_3_1 = "RENAME TABLE {$pref}revisions TO {$pref}revision";

$alter_revision_r4_2_1 = "ALTER TABLE {$pref}revisions MODIFY COLUMN body MEDIUMTEXT NOT NULL";
$alter_revision_r4_2_2 = "ALTER TABLE {$pref}revisions MODIFY COLUMN body_r MEDIUMTEXT NOT NULL";

$alter_revision_r4_3_0 = "ALTER TABLE {$pref}revision CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
$alter_revision_r4_3_1 = "ALTER TABLE {$pref}revision ADD created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER supertag, DROP INDEX idx_latest";
$alter_revision_r4_3_2 = "ALTER TABLE {$pref}revision ADD title VARCHAR(100) NOT NULL DEFAULT '' AFTER supertag, ADD edit_note VARCHAR(100) NOT NULL DEFAULT '' AFTER user";
$alter_revision_r4_3_3 = "ALTER TABLE {$pref}revision ADD owner_id INT(10) UNSIGNED NOT NULL AFTER id, ADD INDEX idx_owner_id (owner_id)";
$alter_revision_r4_3_4 = "ALTER TABLE {$pref}revision ADD user_id INT(10) UNSIGNED NOT NULL AFTER owner_id, ADD INDEX idx_user_id (user_id)";
$alter_revision_r4_3_5 = "ALTER TABLE {$pref}revision CHANGE lang lang VARCHAR(2) NOT NULL DEFAULT ''";
$alter_revision_r4_3_6 = "ALTER TABLE {$pref}revision ADD minor_edit TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER edit_note, ADD INDEX idx_minor_edit (minor_edit)";
$alter_revision_r4_3_7 = "ALTER TABLE {$pref}revision CHANGE latest latest TINYINT(1) NOT NULL DEFAULT '0'";
$alter_revision_r4_3_8 = "ALTER TABLE {$pref}revision ADD comment_on_id INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER super_comment_on";
$alter_revision_r4_3_9 = "ALTER TABLE {$pref}revision DROP comment_on";
$alter_revision_r4_3_10 = "ALTER TABLE {$pref}revision DROP super_comment_on";
$alter_revision_r4_3_11 = "ALTER TABLE {$pref}revision ADD page_id INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER id";
$alter_revision_r4_3_12 = "ALTER TABLE {$pref}revision DROP owner";
$alter_revision_r4_3_13 = "ALTER TABLE {$pref}revision DROP user";
$alter_revision_r4_3_14 = "ALTER TABLE {$pref}revision ADD ip VARCHAR(15) NOT NULL AFTER minor_edit";
$alter_revision_r4_3_15 = "ALTER TABLE {$pref}revision CHANGE id revision_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";
$alter_revision_r4_3_16 = "ALTER TABLE {$pref}revision CHANGE time modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'";
$alter_revision_r4_3_17 = "ALTER TABLE {$pref}revision DROP INDEX idx_time , ADD INDEX idx_modified ( modified )";
$alter_revision_r4_3_18 = "ALTER TABLE {$pref}revision ADD formatting VARCHAR(20) DEFAULT NULL AFTER body_r";
$alter_revision_r4_3_19 = "ALTER TABLE {$pref}revision ADD reviewed TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER minor_edit, ADD INDEX idx_reviewed (reviewed)";
$alter_revision_r4_3_20 = "ALTER TABLE {$pref}revision ADD reviewer_id INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER reviewed";
$alter_revision_r4_3_21 = "ALTER TABLE {$pref}revision ADD reviewed_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER reviewed";
$alter_revision_r4_3_22 = "ALTER TABLE {$pref}revision ADD menu_tag VARCHAR(250) NOT NULL DEFAULT '' AFTER supertag";
$alter_revision_r4_3_23 = "ALTER TABLE {$pref}revision ADD version_id INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER page_id";
$alter_revision_r4_3_24 = "ALTER TABLE {$pref}revision ADD deleted TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER keywords";

$update_revision_r4_3_1 = "UPDATE {$pref}revision AS revisions, (SELECT user_id, user_name FROM {$pref}user) AS users SET revisions.owner_id = users.user_id WHERE revisions.owner = users.user_name";
$update_revision_r4_3_2 = "UPDATE {$pref}revision AS revisions, (SELECT user_id, user_name FROM {$pref}user) AS users SET revisions.user_id = users.user_id WHERE revisions.user = users.user_name";
$update_revision_r4_3_3 = "UPDATE {$pref}revision SET latest = '0'";
$update_revision_r4_3_4 = "UPDATE {$pref}revision AS revisions, (SELECT page_id, tag FROM {$pref}page) AS pages SET revisions.page_id = pages.page_id WHERE revisions.tag = pages.tag";
# $update_revision_r4_3_x = "UPDATE {$pref}revision AS revisions, (SELECT page_id, tag FROM {$pref}page) AS pages2 SET revisions.comment_on_id = pages2.page_id WHERE revisions.comment_on = pages2.tag";
$update_revision_r4_3_5 = "UPDATE {$pref}revision AS revisions SET minor_edit = '0' WHERE revisions.minor_edit IS NULL";
$update_revision_r4_3_6 = "UPDATE {$pref}revision SET formatting = 'wacko' WHERE formatting IS NULL";

// TAG
$table_tag_r4_3 = "CREATE TABLE {$pref}tag (".
						"tag_id INT(10) unsigned NOT NULL AUTO_INCREMENT,".
						"user_id INT(10) unsigned NOT NULL DEFAULT '0',".
						"lang VARCHAR(2) NOT NULL,".
						"tag_name VARCHAR(100) NOT NULL DEFAULT '',".
						"date_created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
						"date_updated DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
						"PRIMARY KEY (tag_id),".
						"KEY idx_tag_name (tag_name)".
					") {$engine} COMMENT='' {$charset}";

$table_tag_page_r4_3 = "CREATE TABLE {$pref}tag_page (".
						"page_id INT(10) unsigned NOT NULL DEFAULT '0',".
						"tag_id INT(10) unsigned NOT NULL DEFAULT '0',".
						"user_id INT(10) unsigned NOT NULL DEFAULT '0',".
						"date_attached DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
						"PRIMARY KEY (page_id, tag_id),".
						"KEY idx_tag_id (tag_id)".
					") {$engine} COMMENT='' {$charset}";

// UPLOAD
$alter_upload_r4_3_0 = "ALTER TABLE {$pref}upload CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
$alter_upload_r4_3_1 = "ALTER TABLE {$pref}upload CHANGE id id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
							CHANGE page_id page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
							CHANGE filename file_name VARCHAR(250) NOT NULL DEFAULT '',
							CHANGE filesize file_size INT(10) UNSIGNED NOT NULL DEFAULT '0',
							CHANGE picture_w picture_w INT(10) UNSIGNED NOT NULL DEFAULT '0',
							CHANGE picture_h picture_h INT(10) UNSIGNED NOT NULL DEFAULT '0',
							ADD user_id INT(10) UNSIGNED NOT NULL AFTER page_id,
							ADD hits INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER file_ext,
							DROP INDEX user_id,
							ADD INDEX idx_user_id (user_id)";

$alter_upload_r4_3_2 = "ALTER TABLE {$pref}upload DROP user";
$alter_upload_r4_3_3 = "ALTER TABLE {$pref}upload CHANGE id upload_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";

$update_upload_r4_3_1 = "UPDATE {$pref}upload AS upload, (SELECT user_id, user_name FROM {$pref}user) AS users SET upload.user_id = users.user_id WHERE upload.user = users.user_name";

// USER
$rename_user_r4_3_1 = "RENAME TABLE {$pref}users TO {$pref}user";

$alter_user_r4_3_0 = "ALTER TABLE {$pref}user CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
$alter_user_r4_3_1 = "ALTER TABLE {$pref}user ADD id INT(10) UNSIGNED NOT NULL auto_increment FIRST, DROP PRIMARY KEY, ADD PRIMARY KEY (id)";
$alter_user_r4_3_2 = "ALTER TABLE {$pref}user CHANGE lang lang VARCHAR(2) NOT NULL DEFAULT ''";
$alter_user_r4_3_3 = "ALTER TABLE {$pref}user CHANGE doubleclickedit doubleclick_edit TINYINT(1) NOT NULL DEFAULT '1'";
$alter_user_r4_3_4 = "ALTER TABLE {$pref}user CHANGE show_comments show_comments TINYINT(1) NOT NULL DEFAULT '0'";
$alter_user_r4_3_5 = "ALTER TABLE {$pref}user CHANGE show_spaces show_spaces TINYINT(1) NOT NULL DEFAULT '1'";
$alter_user_r4_3_6 = "ALTER TABLE {$pref}user DROP showdatetime";
$alter_user_r4_3_7 = "ALTER TABLE {$pref}user CHANGE typografica typografica TINYINT(1) NOT NULL DEFAULT '1'";
$alter_user_r4_3_8 = "ALTER TABLE {$pref}user ADD total_pages INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER email_confirm";
$alter_user_r4_3_9 = "ALTER TABLE {$pref}user ADD total_revisions INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER total_pages";
$alter_user_r4_3_10 = "ALTER TABLE {$pref}user ADD total_comments INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER total_revisions";
$alter_user_r4_3_11 = "ALTER TABLE {$pref}user CHANGE name user_name VARCHAR(80) NOT NULL DEFAULT '', DROP INDEX idx_name, ADD UNIQUE idx_user_name (user_name)";
$alter_user_r4_3_12 = "ALTER TABLE {$pref}user ADD real_name VARCHAR(80) NOT NULL DEFAULT '' AFTER user_name";
$alter_user_r4_3_13 = "ALTER TABLE {$pref}user ADD session_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER email_confirm";
$alter_user_r4_3_14 = "ALTER TABLE {$pref}user ADD session_expire INT(10) UNSIGNED NOT NULL AFTER session_time";
$alter_user_r4_3_15 = "ALTER TABLE {$pref}user CHANGE id user_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";
$alter_user_r4_3_16 = "ALTER TABLE {$pref}user ADD enabled TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' AFTER email, ADD INDEX idx_enabled (enabled)";
$alter_user_r4_3_17 = "ALTER TABLE {$pref}user CHANGE password password VARCHAR(64) NOT NULL DEFAULT ''";
$alter_user_r4_3_18 = "ALTER TABLE {$pref}user CHANGE signuptime signup_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'";
$alter_user_r4_3_19 = "ALTER TABLE {$pref}user CHANGE changepassword change_password VARCHAR(64) NOT NULL";
$alter_user_r4_3_20 = "ALTER TABLE {$pref}user CHANGE revisioncount revisions_count INT(10) UNSIGNED NOT NULL DEFAULT '20'";
$alter_user_r4_3_21 = "ALTER TABLE {$pref}user CHANGE changescount changes_count INT(10) UNSIGNED NOT NULL DEFAULT '50'";
$alter_user_r4_3_22 = "ALTER TABLE {$pref}user ADD salt VARCHAR(40) NOT NULL DEFAULT '' AFTER password";
$alter_user_r4_3_23 = "ALTER TABLE {$pref}user ADD account_type TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER email, ADD INDEX idx_account_type (account_type)";
$alter_user_r4_3_24 = "ALTER TABLE {$pref}user ADD last_mark DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER session_expire";
$alter_user_r4_3_25 = "ALTER TABLE {$pref}user CHANGE email_confirm email_confirm VARCHAR(64) NOT NULL DEFAULT ''";
$alter_user_r4_3_26 = "ALTER TABLE {$pref}user ADD login_count INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER last_mark";
$alter_user_r4_3_27 = "ALTER TABLE {$pref}user ADD lost_password_request_count SMALLINT(6) UNSIGNED NOT NULL DEFAULT '0' AFTER login_count";
$alter_user_r4_3_28 = "ALTER TABLE {$pref}user ADD failed_login_count SMALLINT(6) UNSIGNED NOT NULL DEFAULT '0' AFTER lost_password_request_count";
$alter_user_r4_3_29 = "ALTER TABLE {$pref}user ADD fingerprint VARCHAR(40) AFTER total_comments";
$alter_user_r4_3_30 = "ALTER TABLE {$pref}user CHANGE email email VARCHAR(100) NOT NULL DEFAULT ''";
$alter_user_r4_3_31 = "ALTER TABLE {$pref}user ADD total_uploads INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER total_comments";

// see adminupdate action which will do this after successful data migration
#$alter_user_r4_3_31 = "ALTER TABLE {$pref}user DROP changes_count";
#$alter_user_r4_3_32 = "ALTER TABLE {$pref}user DROP doubleclick_edit";
#$alter_user_r4_3_33 = "ALTER TABLE {$pref}user DROP show_comments";
#$alter_user_r4_3_34 = "ALTER TABLE {$pref}user DROP bookmarks";
#$alter_user_r4_3_35 = "ALTER TABLE {$pref}user DROP lang";
#$alter_user_r4_3_36 = "ALTER TABLE {$pref}user DROP show_spaces";
#$alter_user_r4_3_37 = "ALTER TABLE {$pref}user DROP typografica";
#$alter_user_r4_3_38 = "ALTER TABLE {$pref}user DROP more";
#$alter_user_r4_3_39 = "ALTER TABLE {$pref}user DROP motto";
#$alter_user_r4_3_40 = "ALTER TABLE {$pref}user DROP revisions_count";

$update_user_r4_3_1 = "UPDATE {$pref}user SET doubleclick_edit = '0' WHERE doubleclick_edit = '2'";
$update_user_r4_3_2 = "UPDATE {$pref}user SET show_comments = '0' WHERE show_comments = '2'";
$update_user_r4_3_3 = "UPDATE {$pref}user SET show_spaces = '0' WHERE show_spaces = '2'";
$update_user_r4_3_4 = "UPDATE {$pref}user SET typografica = '0' WHERE typografica = '2'";

// USER SETTING
$table_user_setting_r4_3 = "CREATE TABLE {$pref}user_setting (".
					"setting_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"user_id INT(10) UNSIGNED NOT NULL,".
					"theme VARCHAR(20) DEFAULT NULL,".
					"lang VARCHAR(2) DEFAULT NULL,".
					"changes_count INTEGER(10) UNSIGNED NOT NULL DEFAULT '50',".
					"revisions_count INTEGER(10) UNSIGNED NOT NULL DEFAULT '20',".
					"dont_redirect TINYINT(1) UNSIGNED DEFAULT NULL,".
					"send_watchmail TINYINT(1) UNSIGNED DEFAULT NULL,".
					"show_files TINYINT(1) UNSIGNED DEFAULT NULL,".
					"show_comments TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"doubleclick_edit TINYINT(1) UNSIGNED  NOT NULL DEFAULT '1',".
					"show_spaces TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"typografica TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"autocomplete TINYINT(1) UNSIGNED DEFAULT NULL,".
					"numerate_links TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"allow_intercom TINYINT(1) UNSIGNED DEFAULT NULL,".
					"hide_lastsession TINYINT(1) UNSIGNED DEFAULT NULL,".
					"validate_ip TINYINT(1) UNSIGNED DEFAULT NULL,".
					"noid_pubs TINYINT(1) UNSIGNED DEFAULT NULL,".
					"session_expiration TINYINT(3) UNSIGNED DEFAULT NULL,".
					"timezone VARCHAR(32) DEFAULT NULL,".
					"PRIMARY KEY (setting_id),".
					"UNIQUE KEY idx_user_id (user_id),".
					"KEY idx_send_watchmail (send_watchmail)".
				") {$engine} COMMENT='' {$charset}";
$alter_user_setting_r4_3_1 = "ALTER TABLE {$pref}user_setting ADD allow_massemail TINYINT(1) UNSIGNED DEFAULT '0' AFTER allow_intercom".

// WATCH
$rename_watch_r4_3_1 = "RENAME TABLE {$pref}pagewatches TO {$pref}watch";

$alter_watch_r4_3_0 = "ALTER TABLE {$pref}watch CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci";
$alter_watch_r4_3_1 = "ALTER TABLE {$pref}watch CHANGE id id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";
$alter_watch_r4_3_2 = "ALTER TABLE {$pref}watch ADD user_id INT(10) UNSIGNED NOT NULL AFTER user";
$alter_watch_r4_3_3 = "ALTER TABLE {$pref}watch ADD page_id INT(10) UNSIGNED NOT NULL AFTER tag";
$alter_watch_r4_3_4 = "ALTER TABLE {$pref}watch DROP user";
$alter_watch_r4_3_5 = "ALTER TABLE {$pref}watch DROP tag";
$alter_watch_r4_3_6 = "ALTER TABLE {$pref}watch CHANGE id watch_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";
$alter_watch_r4_3_7 = "ALTER TABLE {$pref}watch CHANGE time watch_time TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";
$alter_watch_r4_3_8 = "ALTER TABLE {$pref}watch ADD comment_id INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER page_id";

$update_watch_r4_3_1 = "UPDATE {$pref}watch AS watch, (SELECT user_id, user_name FROM {$pref}user) AS user SET watch.user_id = user.user_id WHERE watch.user = user.user_name";
$update_watch_r4_3_2 = "UPDATE {$pref}watch AS watch, (SELECT page_id, tag FROM {$pref}page) AS page SET watch.page_id = page.page_id WHERE watch.tag = page.tag";

/* $table_word_r4_3 = "CREATE TABLE {$pref}word (".
					"word_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"word VARCHAR(255) NOT NULL DEFAULT '',".
					"replacement VARCHAR(255) NOT NULL DEFAULT '',".
					"PRIMARY KEY (word_id)".
				") {$engine} COMMENT='' {$charset}"; */

?>