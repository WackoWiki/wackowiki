<?php

/*
	Wacko Wiki MySQL Table Updates Script

	These are all the updates that need to applied to earlier Wacko version to bring them up to 4.3 specs
*/

$pref = $config["table_prefix"];

// ACL
$alter_acl_r4_3 = "ALTER TABLE {$pref}acls ADD page_id INT(10) UNSIGNED NOT NULL AFTER page_tag";
$alter_acl_r4_3_1 = "ALTER TABLE {$pref}acls CHANGE privilege privilege VARCHAR(10) NOT NULL";
$alter_acl_r4_3_2 = "ALTER TABLE {$pref}acls DROP PRIMARY KEY";
$alter_acl_r4_3_3 = "ALTER TABLE {$pref}acls ADD UNIQUE idx_page_id (page_id,privilege)";
$alter_acl_r4_3_4 = "ALTER TABLE {$pref}acls DROP page_tag";
$alter_acl_r4_3_5 = "ALTER TABLE {$pref}acls DROP supertag";

$update_acl_r4_3 = "UPDATE {$pref}acls AS acls, (SELECT id, tag FROM {$pref}pages) AS pages SET acls.page_id = pages.id WHERE acls.page_tag = pages.tag";

// BOOKMARK
$table_bookmark_r4_3 = "CREATE TABLE {$pref}bookmark (".
					"bookmark_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"user_id INT(10) UNSIGNED NOT NULL,".
					"page_id INT(10) UNSIGNED NOT NULL,".
					"lang VARCHAR(2) NOT NULL,".
					"bm_title VARCHAR(100) NOT NULL,".
					"bm_position SMALLINT(2) UNSIGNED NOT NULL,".
					"PRIMARY KEY (bookmark_id),".
					"UNIQUE KEY idx_user_id (user_id,page_id)".
				") TYPE=MyISAM;";

// CACHE
$alter_cache_r4_3 = "ALTER TABLE {$pref}cache ADD cache_time TIMESTAMP NOT NULL, ADD INDEX timestamp (cache_time)";
$alter_cache_r4_3_1 = "ALTER TABLE {$pref}cache ADD lang VARCHAR(2) NOT NULL AFTER query";

// CATEGORY
$table_category_r4_3 = "CREATE TABLE {$pref}category (".
					"category_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"parent INT(10) UNSIGNED NOT NULL,".
					"lang VARCHAR(2) NOT NULL,".
					"category VARCHAR(100) NOT NULL,".
					"PRIMARY KEY (category_id),".
					"UNIQUE KEY idx_category (lang,category)".
				") TYPE=MyISAM";

$table_category_page_r4_3 = "CREATE TABLE {$pref}category_page (".
						"category_id INT(10) UNSIGNED NOT NULL,".
						"page_id INT(10) UNSIGNED NOT NULL,".
						"UNIQUE KEY idx_pageword (category_id,page_id)".
					") ENGINE=MyISAM";

// CONFIG
$table_config_r4_3 = "CREATE TABLE {$pref}config (".
					"config_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"config_name VARCHAR(100) NOT NULL DEFAULT '',".
					"value TEXT,".
					// "updated TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,".
					"PRIMARY KEY (config_id),".
					"UNIQUE KEY idx_config_name (config_name)".
				") TYPE=MyISAM";

// GROUP
$table_group_r4_3 = "CREATE TABLE {$pref}group (".
					"group_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"group_name VARCHAR(100) NOT NULL,".
					"description VARCHAR(255) NOT NULL,".
					"moderator INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"created DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,".
					"open TINYINT(1) UNSIGNED NOT NULL,".
					"active TINYINT(1) UNSIGNED NOT NULL,".
					// "special TINYINT(1) UNSIGNED NOT NULL,".
					"PRIMARY KEY (group_id),".
					"UNIQUE KEY idx_name (group_name)".
				") TYPE=MyISAM";

$table_group_member_r4_3 = "CREATE TABLE {$pref}group_member (".
					"group_id INTEGER(10) UNSIGNED NOT NULL,".
					"user_id INTEGER(10) UNSIGNED NOT NULL,".
					"UNIQUE KEY idx_group_id (group_id, user_id)".
				")ENGINE=MyISAM";

// LINK
$alter_link_r4_3 = "ALTER TABLE {$pref}links ADD id INT(10) UNSIGNED NOT NULL auto_increment FIRST, ADD PRIMARY KEY (id)";
$alter_link_r4_3_1 = "ALTER TABLE {$pref}links ADD from_page_id INT(10) UNSIGNED NOT NULL AFTER from_tag";
$alter_link_r4_3_2 = "ALTER TABLE {$pref}links ADD to_page_id INT(10) UNSIGNED NOT NULL AFTER from_page_id";
$alter_link_r4_3_3 = "ALTER TABLE {$pref}links DROP from_tag";
$alter_link_r4_3_4 = "ALTER TABLE {$pref}links DROP INDEX from_tag, ADD INDEX from_tag (from_page_id, to_tag (78))";
$alter_link_r4_3_5 = "ALTER TABLE {$pref}links ADD INDEX idx_from_page_id (from_page_id)";

$update_link_r4_3 = "UPDATE {$pref}links AS links, (SELECT id, tag FROM {$pref}pages) AS pages SET links.from_page_id = pages.id WHERE links.from_tag = pages.tag";
$update_link_r4_3_1 = "UPDATE {$pref}links AS links, (SELECT id, tag FROM {$pref}pages) AS pages SET links.to_page_id = pages.id WHERE links.to_tag = pages.tag";

// LOG
$table_log_r4_3 = "CREATE TABLE {$pref}log (".
				"log_id INT(10) UNSIGNED NOT NULL auto_increment,".
				"log_time TIMESTAMP NOT NULL,".
				"level TINYINT(1) NOT NULL,".
				"user VARCHAR(100) NOT NULL,".
				"ip VARCHAR(15) NOT NULL,".
				"message TEXT NOT NULL,".
				"PRIMARY KEY (log_id),".
				"KEY idx_level (level),".
				"KEY idx_user (user),".
				"KEY idx_ip (ip),".
				"KEY idx_time (log_time)".
			") TYPE=MyISAM";

// PAGE
$alter_page_r4_2_1 = "ALTER TABLE {$pref}pages MODIFY COLUMN body MEDIUMTEXT NOT NULL";
$alter_page_r4_2_2 = "ALTER TABLE {$pref}pages MODIFY COLUMN body_r MEDIUMTEXT NOT NULL";
$alter_page_r4_3_3 = "ALTER TABLE {$pref}pages ADD created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER supertag, ADD INDEX idx_created (created), DROP INDEX idx_latest";
$alter_page_r4_3_4 = "ALTER TABLE {$pref}pages ADD title VARCHAR(100) NOT NULL DEFAULT '' AFTER supertag, ADD INDEX idx_title (title), ADD edit_note VARCHAR(100) NOT NULL DEFAULT '' AFTER user";
$alter_page_r4_3_5 = "ALTER TABLE {$pref}pages CHANGE hits hits INT(11) UNSIGNED NOT NULL DEFAULT '0'";
$alter_page_r4_3_6 = "ALTER TABLE {$pref}pages ADD owner_id INT(10) UNSIGNED NOT NULL AFTER id, ADD INDEX idx_owner_id (owner_id)";
$alter_page_r4_3_7 = "ALTER TABLE {$pref}pages ADD user_id INT(10) UNSIGNED NOT NULL AFTER owner_id, ADD INDEX idx_user_id (user_id)";
$alter_page_r4_3_8 = "ALTER TABLE {$pref}pages CHANGE latest latest TINYINT(1) NOT NULL DEFAULT '1'";
$alter_page_r4_3_9 = "ALTER TABLE {$pref}pages CHANGE lang lang VARCHAR(2) NOT NULL DEFAULT ''";
$alter_page_r4_3_10 = "ALTER TABLE {$pref}pages ADD minor_edit TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER edit_note, ADD INDEX idx_minor_edit (minor_edit)";
$alter_page_r4_3_11 = "ALTER TABLE {$pref}pages ADD comment_on_id INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER super_comment_on, ADD INDEX idx_comment_on_id (comment_on_id)";
$alter_page_r4_3_12 = "ALTER TABLE {$pref}pages DROP comment_on";
$alter_page_r4_3_13 = "ALTER TABLE {$pref}pages DROP super_comment_on";
$alter_page_r4_3_14 = "ALTER TABLE {$pref}pages ADD comments INT(4) UNSIGNED NOT NULL DEFAULT '0' AFTER comment_on_id";
$alter_page_r4_3_15 = "ALTER TABLE {$pref}pages DROP owner";
$alter_page_r4_3_16 = "ALTER TABLE {$pref}pages DROP user";
$alter_page_r4_3_17 = "ALTER TABLE {$pref}pages ADD ip VARCHAR(15) NOT NULL AFTER minor_edit";
$alter_page_r4_3_18 = "ALTER TABLE {$pref}pages CHANGE id page_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";
$alter_page_r4_3_19 = "ALTER TABLE {$pref}pages CHANGE time modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'";
$alter_page_r4_3_20 = "ALTER TABLE {$pref}pages DROP INDEX idx_time, ADD INDEX idx_modified (modified)";
$alter_page_r4_3_21 = "ALTER TABLE {$pref}pages ADD commented DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER title, ADD INDEX idx_commented (commented)";
$alter_page_r4_3_22 = "ALTER TABLE {$pref}pages ADD hide_comments TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_23 = "ALTER TABLE {$pref}pages ADD hide_files TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_24 = "ALTER TABLE {$pref}pages ADD hide_rating TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_25 = "ALTER TABLE {$pref}pages ADD hide_toc TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_26 = "ALTER TABLE {$pref}pages ADD hide_index TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_27 = "ALTER TABLE {$pref}pages ADD lower_index TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_28 = "ALTER TABLE {$pref}pages ADD upper_index TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_29 = "ALTER TABLE {$pref}pages ADD allow_rawhtml TINYINT(1) UNSIGNED DEFAULT NULL";
$alter_page_r4_3_30 = "ALTER TABLE {$pref}pages ADD disable_safehtml TINYINT(1) UNSIGNED DEFAULT NULL";

$update_page_r4_3 = "UPDATE {$pref}pages SET body_r=''";
$update_page_r4_3_1 = "UPDATE {$pref}pages AS pages, (SELECT user_id, user_name FROM {$pref}users) AS users SET pages.owner_id = users.user_id WHERE pages.owner = users.user_name";
$update_page_r4_3_2 = "UPDATE {$pref}pages AS pages, (SELECT user_id, user_name FROM {$pref}users) AS users SET pages.user_id = users.user_id WHERE pages.user = users.user_name";
$update_page_r4_3_3 = "UPDATE {$pref}pages AS pages, (SELECT id, tag FROM {$pref}pages) AS pages2 SET pages.comment_on_id = pages2.id WHERE pages.comment_on = pages2.tag";
$update_page_r4_3_4 = "UPDATE {$pref}pages AS pages, (SELECT comment_on_id, COUNT(comment_on_id) as n FROM {$pref}pages WHERE comment_on_id != '0' GROUP BY comment_on_id) AS comments_on SET pages.comments = comments_on.n WHERE pages.id = comments_on.comment_on_id";
$update_page_r4_3_5 = "UPDATE {$pref}pages as pages, (SELECT tag, MIN(time) AS oldest FROM wacko_revisions GROUP BY tag) AS revisions SET pages.created = revisions.oldest WHERE pages.tag = revisions.tag AND pages.created IS NULL";
$update_page_r4_3_6 = "UPDATE {$pref}pages as pages SET pages.created = pages.time WHERE pages.id = pages.id AND pages.created IS NULL";
$update_page_r4_3_7 = "UPDATE {$pref}pages as pages SET minor_edit = '0' WHERE pages.minor_edit IS NULL";

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
				") TYPE=MyISAM";

// RATING
$table_rating_r4_3 = "CREATE TABLE {$pref}rating (".
					"page_id int(10) UNSIGNED NOT NULL,".
					"value INT(11) NOT NULL,".
					"voters INT(10) UNSIGNED NOT NULL,".
					"rating_time TIMESTAMP NOT NULL,".
					"PRIMARY KEY (page_id),".
					"KEY idx_voters_rate (voters)".
				") TYPE=MyISAM";

// REFERRER
$alter_referrer_r4_3 = "ALTER TABLE {$pref}referrers DROP INDEX idx_page_tag, CHANGE page_tag page_id INT(10) UNSIGNED NOT NULL DEFAULT '0', ADD INDEX idx_page_id (page_id)";
$alter_referrer_r4_3_1 = "ALTER TABLE {$pref}referrers CHANGE time referrer_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'";

// REVISION
$alter_revision_r4_2_1 = "ALTER TABLE {$pref}revisions MODIFY COLUMN body MEDIUMTEXT NOT NULL";
$alter_revision_r4_2_2 = "ALTER TABLE {$pref}revisions MODIFY COLUMN body_r MEDIUMTEXT NOT NULL";
$alter_revision_r4_3_3 = "ALTER TABLE {$pref}revisions ADD created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER supertag, DROP INDEX idx_latest";
$alter_revision_r4_3_4 = "ALTER TABLE {$pref}revisions ADD title VARCHAR(100) NOT NULL DEFAULT '' AFTER supertag, ADD edit_note VARCHAR(100) NOT NULL DEFAULT '' AFTER user";
$alter_revision_r4_3_5 = "ALTER TABLE {$pref}revisions ADD owner_id INT(10) UNSIGNED NOT NULL AFTER id, ADD INDEX idx_owner_id (owner_id)";
$alter_revision_r4_3_6 = "ALTER TABLE {$pref}revisions ADD user_id INT(10) UNSIGNED NOT NULL AFTER owner_id, ADD INDEX idx_user_id (user_id)";
$alter_revision_r4_3_7 = "ALTER TABLE {$pref}revisions CHANGE lang lang VARCHAR(2) NOT NULL DEFAULT ''";
$alter_revision_r4_3_8 = "ALTER TABLE {$pref}revisions ADD minor_edit TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER edit_note, ADD INDEX idx_minor_edit (minor_edit)";
$alter_revision_r4_3_9 = "ALTER TABLE {$pref}revisions CHANGE latest latest TINYINT(1) NOT NULL DEFAULT '0'";
$alter_revision_r4_3_10 = "ALTER TABLE {$pref}revisions ADD comment_on_id INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER super_comment_on";
$alter_revision_r4_3_11 = "ALTER TABLE {$pref}revisions DROP comment_on";
$alter_revision_r4_3_12 = "ALTER TABLE {$pref}revisions DROP super_comment_on";
$alter_revision_r4_3_13 = "ALTER TABLE {$pref}revisions ADD page_id INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER id";
$alter_revision_r4_3_14 = "ALTER TABLE {$pref}revisions DROP owner";
$alter_revision_r4_3_15 = "ALTER TABLE {$pref}revisions DROP user";
$alter_revision_r4_3_16 = "ALTER TABLE {$pref}revisions ADD ip VARCHAR(15) NOT NULL AFTER minor_edit";
$alter_revision_r4_3_17 = "ALTER TABLE {$pref}revisions CHANGE id revision_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";
$alter_revision_r4_3_18 = "ALTER TABLE {$pref}revisions CHANGE time modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'";
$alter_revision_r4_3_19 = "ALTER TABLE {$pref}revisions DROP INDEX idx_time , ADD INDEX idx_modified ( modified )";

$update_revision_r4_3 = "UPDATE {$pref}revisions AS revisions, (SELECT user_id, user_name FROM {$pref}users) AS users SET revisions.owner_id = users.user_id WHERE revisions.owner = users.user_name";
$update_revision_r4_3_1 = "UPDATE {$pref}revisions AS revisions, (SELECT user_id, user_name FROM {$pref}users) AS users SET revisions.user_id = users.user_id WHERE revisions.user = users.user_name";
$update_revision_r4_3_2 = "UPDATE {$pref}revisions SET latest = '0'";
$update_revision_r4_3_3 = "UPDATE {$pref}revisions AS revisions, (SELECT id, tag FROM {$pref}pages) AS pages SET revisions.page_id = pages.id WHERE revisions.tag = pages.tag";
# $update_revision_r4_3_x = "UPDATE {$pref}revisions AS revisions, (SELECT id, tag FROM {$pref}pages) AS pages2 SET revisions.comment_on_id = pages2.id WHERE revisions.comment_on = pages2.tag";
$update_revision_r4_3_4 = "UPDATE {$pref}revisions revisions AS revisions SET minor_edit = '0' WHERE revisions.minor_edit IS NULL";

// UPLOAD
$alter_upload_r4_3 = "ALTER TABLE {$pref}upload CHANGE id id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
																	CHANGE page_id page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
																	CHANGE filesize filesize INT(10) UNSIGNED NOT NULL DEFAULT '0',
																	CHANGE picture_w picture_w INT(10) UNSIGNED NOT NULL DEFAULT '0',
																	CHANGE picture_h picture_h INT(10) UNSIGNED NOT NULL DEFAULT '0',
																	ADD user_id INT(10) UNSIGNED NOT NULL AFTER page_id,
																	ADD hits INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER file_ext,
																	DROP INDEX user_id,
																	ADD INDEX idx_user_id (user_id)";

$alter_upload_r4_3_1 = "ALTER TABLE {$pref}upload DROP user";
$alter_upload_r4_3_2 = "ALTER TABLE {$pref}upload CHANGE id upload_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";

$update_upload_r4_3 = "UPDATE {$pref}upload AS upload, (SELECT user_id, user_name FROM {$pref}users) AS users SET upload.user_id = users.user_id WHERE upload.user = users.user_name";

// USER
$alter_user_r4_3 = "ALTER TABLE {$pref}users ADD id INT(10) UNSIGNED NOT NULL auto_increment FIRST, DROP PRIMARY KEY, ADD PRIMARY KEY (id)";
$alter_user_r4_3_1 = "ALTER TABLE {$pref}users CHANGE lang lang VARCHAR(2) NOT NULL DEFAULT ''";
$alter_user_r4_3_2 = "ALTER TABLE {$pref}users CHANGE doubleclickedit doubleclick_edit TINYINT(1) NOT NULL DEFAULT '1'";
$alter_user_r4_3_3 = "ALTER TABLE {$pref}users CHANGE show_comments show_comments TINYINT(1) NOT NULL DEFAULT '0'";
$alter_user_r4_3_4 = "ALTER TABLE {$pref}users CHANGE show_spaces show_spaces TINYINT(1) NOT NULL DEFAULT '1'";
$alter_user_r4_3_5 = "ALTER TABLE {$pref}users DROP showdatetime";
$alter_user_r4_3_6 = "ALTER TABLE {$pref}users CHANGE typografica typografica TINYINT(1) NOT NULL DEFAULT '1'";
$alter_user_r4_3_7 = "ALTER TABLE {$pref}users ADD total_pages INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER email_confirm";
$alter_user_r4_3_8 = "ALTER TABLE {$pref}users ADD total_revisions INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER total_pages";
$alter_user_r4_3_9 = "ALTER TABLE {$pref}users ADD total_comments INT(10) UNSIGNED NOT NULL DEFAULT '0' AFTER total_revisions";
$alter_user_r4_3_10 = "ALTER TABLE {$pref}users CHANGE name user_name VARCHAR(80) NOT NULL DEFAULT '', DROP INDEX idx_name, ADD UNIQUE idx_user_name (user_name)";
$alter_user_r4_3_11 = "ALTER TABLE {$pref}users ADD real_name VARCHAR(80) NOT NULL DEFAULT '' AFTER user_name";
$alter_user_r4_3_12 = "ALTER TABLE {$pref}users ADD session_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER email_confirm";
$alter_user_r4_3_13 = "ALTER TABLE {$pref}users ADD session_expire INT(10) UNSIGNED NOT NULL AFTER session_time";
$alter_user_r4_3_14 = "ALTER TABLE {$pref}users CHANGE id user_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";
$alter_user_r4_3_15 = "ALTER TABLE {$pref}users ADD enabled TINYINT(1) UNSIGNED NOT NULL DEFAULT '1' AFTER email, ADD INDEX idx_enabled (enabled)";
$alter_user_r4_3_16 = "ALTER TABLE {$pref}users CHANGE password password VARCHAR(40) NOT NULL DEFAULT ''";
$alter_user_r4_3_17 = "ALTER TABLE {$pref}users CHANGE signuptime signup_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00'";
$alter_user_r4_3_18 = "ALTER TABLE {$pref}users CHANGE changepassword change_password VARCHAR(40) NOT NULL";
$alter_user_r4_3_19 = "ALTER TABLE {$pref}users CHANGE revisioncount revisions_count INT(10) UNSIGNED NOT NULL DEFAULT '20'";
$alter_user_r4_3_20 = "ALTER TABLE {$pref}users CHANGE changescount changes_count INT(10) UNSIGNED NOT NULL DEFAULT '50'";
$alter_user_r4_3_21 = "ALTER TABLE {$pref}users ADD salt VARCHAR(40) NOT NULL DEFAULT '' AFTER password";
$alter_user_r4_3_22 = "ALTER TABLE {$pref}users DROP motto";
$alter_user_r4_3_23 = "ALTER TABLE {$pref}users DROP revisions_count";
$alter_user_r4_3_24 = "ALTER TABLE {$pref}users DROP changes_count";
$alter_user_r4_3_25 = "ALTER TABLE {$pref}users DROP doubleclick_edit";
$alter_user_r4_3_26 = "ALTER TABLE {$pref}users DROP show_comments";
$alter_user_r4_3_27 = "ALTER TABLE {$pref}users DROP bookmarks";
$alter_user_r4_3_28 = "ALTER TABLE {$pref}users DROP lang";
$alter_user_r4_3_29 = "ALTER TABLE {$pref}users DROP show_spaces";
$alter_user_r4_3_30 = "ALTER TABLE {$pref}users DROP typografica";
$alter_user_r4_3_31 = "ALTER TABLE {$pref}users DROP more";

$update_user_r4_3 = "UPDATE {$pref}users SET doubleclick_edit = '0' WHERE doubleclick_edit = '2'";
$update_user_r4_3_1 = "UPDATE {$pref}users SET show_comments = '0' WHERE show_comments = '2'";
$update_user_r4_3_2 = "UPDATE {$pref}users SET show_spaces = '0' WHERE show_spaces = '2'";
$update_user_r4_3_4 = "UPDATE {$pref}users SET typografica = '0' WHERE typografica = '2'";

// USER SETTING
$table_user_setting_r4_3 = "CREATE TABLE {$pref}user_setting (".
					"setting_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"user_id INT(10) UNSIGNED NOT NULL,".
					"theme VARCHAR(20) DEFAULT NULL,".
					"lang VARCHAR(2) DEFAULT NULL,".
					"motto TEXT,".
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
					"allow_intercom TINYINT(1) UNSIGNED DEFAULT NULL,".
					"hide_lastsession TINYINT(1) UNSIGNED DEFAULT NULL,".
					"validate_ip TINYINT(1) UNSIGNED DEFAULT NULL,".
					"noid_pubs TINYINT(1) UNSIGNED DEFAULT NULL,".
					"timezone VARCHAR(32) DEFAULT NULL,".
					"PRIMARY KEY (setting_id),".
					"UNIQUE KEY idx_user_id (user_id),".
					"KEY idx_send_watchmail (send_watchmail)".
				") TYPE=MyISAM";

// WATCH
$alter_watch_r4_3 = "ALTER TABLE {$pref}pagewatches CHANGE id id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";
$alter_watch_r4_3_1 = "ALTER TABLE {$pref}pagewatches ADD user_id INT(10) UNSIGNED NOT NULL AFTER user";
$alter_watch_r4_3_2 = "ALTER TABLE {$pref}pagewatches ADD page_id INT(10) UNSIGNED NOT NULL AFTER tag";
$alter_watch_r4_3_3 = "ALTER TABLE {$pref}pagewatches DROP user";
$alter_watch_r4_3_4 = "ALTER TABLE {$pref}pagewatches DROP tag";
$alter_watch_r4_3_5 = "ALTER TABLE {$pref}pagewatches CHANGE id watch_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT";
$alter_watch_r4_3_6 = "ALTER TABLE {$pref}pagewatches CHANGE time watch_time TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP";

$update_watch_r4_3 = "UPDATE {$pref}pagewatches AS pagewatches, (SELECT user_id, user_name FROM {$pref}users) AS users SET pagewatches.user_id = users.user_id WHERE pagewatches.user = users.name";
$update_watch_r4_3_1 = "UPDATE {$pref}pagewatches AS pagewatches, (SELECT id, tag FROM {$pref}pages) AS pages SET pagewatches.page_id = pages.id WHERE pagewatches.tag = pages.tag";

$rename_watch_r4_3 = "RENAME TABLE {$pref}pagewatches TO {$pref}watch";

?>