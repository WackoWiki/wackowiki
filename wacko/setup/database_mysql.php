<?php

/*
 Wacko Wiki MySQL Table Creation Script

 TODO: add COMMENT 'field description'
 */

$pref		= $config['table_prefix'];
$charset	= 'DEFAULT CHARSET=utf8';
$engine		= 'ENGINE='.$config['database_engine'];

$table_acl = "CREATE TABLE {$pref}acl (".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"privilege VARCHAR(10) NOT NULL DEFAULT '',".
					"list TEXT NOT NULL,".
					"UNIQUE KEY idx_page_id (page_id,privilege)".
				") {$engine} COMMENT='' {$charset}";

$table_cache = "CREATE TABLE {$pref}cache (".
					"name VARCHAR(32) NOT NULL DEFAULT '',".
					"method VARCHAR(20) NOT NULL DEFAULT '',".
					"query VARCHAR(100) NOT NULL DEFAULT '',".
					"lang VARCHAR(2) NOT NULL DEFAULT '',".
					"cache_time TIMESTAMP NOT NULL,".
					"INDEX (name),".
					"KEY idx_cache_time (cache_time)".
				") {$engine} COMMENT='' {$charset}";

$table_category = "CREATE TABLE {$pref}category (".
					"category_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"parent INT(10) UNSIGNED NOT NULL DEFAULT 0,".
					"lang VARCHAR(2) NOT NULL DEFAULT '',".
					"category VARCHAR(100) NOT NULL DEFAULT '',".
					"PRIMARY KEY (category_id),".
					"UNIQUE KEY idx_category (lang, category)".
				") {$engine} COMMENT='' {$charset}";

$table_category_page = "CREATE TABLE {$pref}category_page (".
						"category_id INT(10) unsigned NOT NULL DEFAULT 0,".
						"page_id INT(10) unsigned NOT NULL DEFAULT 0,".
						"UNIQUE KEY idx_pageword (category_id, page_id)".
					") {$engine} COMMENT='' {$charset}";

$table_config = "CREATE TABLE {$pref}config (".
					"config_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"config_name VARCHAR(100) NOT NULL DEFAULT '',".
					"config_value TEXT,".
					// "updated TIMESTAMP NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,".
					"PRIMARY KEY (config_id),".
					"UNIQUE KEY idx_config_name (config_name)".
				") {$engine} COMMENT='' {$charset}";

$table_link = "CREATE TABLE {$pref}link (".
					"link_id INT(10) UNSIGNED NOT NULL  AUTO_INCREMENT,".
					"from_page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"to_page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"to_tag VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"to_supertag VARCHAR(250) NOT NULL DEFAULT '',".
					"PRIMARY KEY (link_id),".
					"KEY idx_from_tag (from_page_id, to_tag(78)),".
					"KEY idx_from_page_id (from_page_id),".
					"KEY idx_to (to_tag)".
				") {$engine} COMMENT='' {$charset}";

$table_log = "CREATE TABLE {$pref}log (".
					"log_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"log_time TIMESTAMP NOT NULL,".
					"level TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"ip VARCHAR(15) NOT NULL DEFAULT '',".
					"message TEXT NOT NULL,".
					"PRIMARY KEY (log_id),".
					"KEY idx_level (level),".
					"KEY idx_user_id (user_id),".
					"KEY idx_ip (ip),".
					"KEY idx_time (log_time)".
				") {$engine} COMMENT='' {$charset}";

$table_menu = "CREATE TABLE {$pref}menu (".
					"menu_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"lang VARCHAR(2) NOT NULL DEFAULT '',".
					"menu_title VARCHAR(100) NOT NULL DEFAULT '',".
					"menu_position SMALLINT(2) UNSIGNED NOT NULL DEFAULT '0',".
					"PRIMARY KEY (menu_id),".
					"UNIQUE KEY idx_user_id (user_id, page_id)".
				") {$engine} COMMENT='' {$charset}";

$table_page = "CREATE TABLE {$pref}page (".
					"page_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"owner_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"title VARCHAR(100) NOT NULL DEFAULT '',".
					"tag VARCHAR(250) NOT NULL DEFAULT '',".
					"supertag VARCHAR(250) NOT NULL DEFAULT '',".
					"menu_tag VARCHAR(250) NOT NULL DEFAULT '',".
					"depth INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"parent_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"body MEDIUMTEXT NOT NULL,".
					"body_r MEDIUMTEXT NOT NULL,".
					"body_toc TEXT NOT NULL,".
					"formatting VARCHAR(20) NOT NULL DEFAULT 'wacko',".
					"edit_note VARCHAR(100) NOT NULL DEFAULT '',".
					"minor_edit TINYINT(1) UNSIGNED DEFAULT '0',".
					"reviewed TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"reviewed_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"reviewer_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"ip VARCHAR(15) NOT NULL DEFAULT '',".
					"latest TINYINT(1) UNSIGNED DEFAULT '1',".
					"handler VARCHAR(30) NOT NULL DEFAULT 'page',".
					"comment_on_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"comments INT(4) UNSIGNED NOT NULL DEFAULT '0',".
					"hits INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"theme VARCHAR(20) DEFAULT NULL,".
					"lang VARCHAR(2) NOT NULL DEFAULT '',".
					"commented DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"description VARCHAR(250) NOT NULL DEFAULT '',".
					"keywords VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"footer_comments TINYINT(1) UNSIGNED NULL DEFAULT NULL,".
					"footer_files TINYINT(1) UNSIGNED NULL DEFAULT NULL,".
					"footer_rating TINYINT(1) UNSIGNED NULL DEFAULT NULL,".
					"hide_toc TINYINT(1) UNSIGNED NULL DEFAULT NULL,".
					"hide_index TINYINT(1) UNSIGNED NULL DEFAULT NULL,".
					"tree_level TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"show_menu_tag TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"allow_rawhtml TINYINT(1) UNSIGNED NULL DEFAULT NULL,".
					"disable_safehtml TINYINT(1) UNSIGNED NULL DEFAULT NULL,".
					"noindex TINYINT(1) UNSIGNED NULL DEFAULT '0',".
					"deleted TINYINT(1) UNSIGNED NULL DEFAULT '0',".
					"PRIMARY KEY (page_id),".
					"KEY idx_user_id (user_id),".
					"KEY idx_owner_id (owner_id),".
					($config['database_engine'] == "MyISAM" ? "FULLTEXT KEY body (body)," : ""). // InnoDb up to MySql 5.6: #1214 - The used table type doesn't support FULLTEXT indexes
					"UNIQUE KEY idx_tag (tag),".
					"KEY idx_supertag (supertag),".
					"KEY idx_depth(depth),".
					"KEY idx_created (created),".
					"KEY idx_modified (modified),".
					"KEY idx_minor_edit (minor_edit),".
					"KEY idx_deleted (deleted),".
					"KEY idx_reviewed (reviewed),".
					"KEY idx_comment_on_id (comment_on_id),".
					"KEY idx_commented (commented),".
					"KEY idx_title (title)".
				") {$engine} COMMENT='' {$charset}";

$table_poll = "CREATE TABLE {$pref}poll (".
					"poll_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"v_id TINYINT(3) UNSIGNED NOT NULL DEFAULT '0',".
					"text VARCHAR(255) NOT NULL DEFAULT '',".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"plural TINYINT(1) NOT NULL DEFAULT '0',".
					"votes SMALLINT(5) UNSIGNED NOT NULL DEFAULT '0',".
					"start DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"end DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"KEY idx_poll_id (poll_id),".
					"KEY idx_time_frame (start,end)".
				") {$engine} COMMENT='' {$charset}";

$table_rating = "CREATE TABLE {$pref}rating (".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"value INT(11) NOT NULL DEFAULT '0',".
					"voters INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"rating_time TIMESTAMP NOT NULL,".
					"PRIMARY KEY (page_id),".
					"KEY idx_voters_rate (voters)".
				") {$engine} COMMENT='' {$charset}";

$table_referrer = "CREATE TABLE {$pref}referrer (".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"referrer VARCHAR(255) NOT NULL DEFAULT '',".
					"referrer_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"KEY idx_page_id (page_id),".
					"KEY idx_referrer_time (referrer_time)".
				") {$engine} COMMENT='' {$charset}";

$table_revision = "CREATE TABLE {$pref}revision (".
					"revision_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"version_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"owner_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"title VARCHAR(100) NOT NULL DEFAULT '',".
					"tag VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"supertag VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"menu_tag VARCHAR(250) NOT NULL DEFAULT '',".
					"created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"modified DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"body MEDIUMTEXT NOT NULL,".
					"body_r MEDIUMTEXT NOT NULL,".
					"formatting VARCHAR(20) DEFAULT NULL DEFAULT '',".
					"edit_note VARCHAR(100) NOT NULL DEFAULT '',".
					"minor_edit TINYINT(1) UNSIGNED DEFAULT '0',".
					"reviewed TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"reviewed_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"reviewer_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"latest TINYINT(1) UNSIGNED DEFAULT '0',".
					"ip VARCHAR(15) NOT NULL DEFAULT '',".
					"handler VARCHAR(30) NOT NULL DEFAULT 'page',".
					"comment_on_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"lang VARCHAR(2) NOT NULL DEFAULT '',".
					"description VARCHAR(250) NOT NULL DEFAULT '',".
					"keywords VARCHAR(250) BINARY NOT NULL DEFAULT '',".
					"deleted TINYINT(1) UNSIGNED NULL DEFAULT '0',".
					"PRIMARY KEY (revision_id),".
					"KEY idx_user_id (user_id),".
					"KEY idx_owner_id (owner_id),".
					"KEY idx_tag (tag),".
					"KEY idx_supertag (supertag),".
					"KEY idx_modified (modified),".
					"KEY idx_minor_edit (minor_edit),".
					"KEY idx_deleted (deleted),".
					"KEY idx_reviewed (reviewed),".
					"KEY idx_comment_on_id (comment_on_id)".
				") {$engine} COMMENT='' {$charset}";

/*$table_session = "CREATE TABLE {$pref}session (".
					"session_id VARCHAR( 40 ) DEFAULT '0' NOT NULL ,".
					"ip_address VARCHAR( 16 ) DEFAULT '0' NOT NULL ,".
					"user_agent VARCHAR( 50 ) NOT NULL ,".
					"last_activity INT( 10 ) unsigned DEFAULT 0 NOT NULL ,".
					"user_data text NOT NULL ,".
					"PRIMARY KEY ( session_id )".
				") {$engine} COMMENT='' {$charset}";*/

$table_tag = "CREATE TABLE {$pref}tag (".
					"tag_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"lang VARCHAR(2) NOT NULL DEFAULT '',".
					"tag_name VARCHAR(100) NOT NULL DEFAULT '',".
					"date_created DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"date_updated DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"PRIMARY KEY (tag_id),".
					"KEY idx_tag_name (tag_name)".
				") {$engine} COMMENT='' {$charset}";

$table_tag_page = "CREATE TABLE {$pref}tag_page (".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"tag_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"date_attached DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"PRIMARY KEY (page_id, tag_id),".
					"KEY idx_tag_id (tag_id)".
				") {$engine} COMMENT='' {$charset}";

$table_upload = "CREATE TABLE {$pref}upload (".
					"upload_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"file_name VARCHAR(250) NOT NULL DEFAULT '',".
					"lang VARCHAR(2) NOT NULL DEFAULT '',".
					"description VARCHAR(250) NOT NULL DEFAULT '',".
					"uploaded_dt DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"file_size INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"picture_w INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"picture_h INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"file_ext VARCHAR(10) NOT NULL DEFAULT '',".
					"hits INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"deleted TINYINT(1) UNSIGNED NULL DEFAULT '0',".
					"PRIMARY KEY (upload_id),".
					"KEY idx_page_id (page_id, file_name),".
					"KEY idx_page_id_2 (page_id, uploaded_dt),".
					"KEY idx_deleted (deleted),".
					"KEY idx_user_id (user_id)".
				") {$engine} COMMENT='' {$charset}";

$table_user = "CREATE TABLE {$pref}user (".
					"user_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"user_name VARCHAR(80) NOT NULL DEFAULT '',".
					"real_name VARCHAR(80) NOT NULL DEFAULT '',".
					"password VARCHAR(64) NOT NULL DEFAULT '',".
					"salt VARCHAR(40) NOT NULL DEFAULT '',".
					"email VARCHAR(100) NOT NULL DEFAULT '',".
					"account_type TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"enabled TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"signup_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"change_password VARCHAR(64) NOT NULL DEFAULT '',".
					"email_confirm VARCHAR(64) NOT NULL DEFAULT '',".
					"session_time DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"session_expire INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"last_mark DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',".
					"login_count INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"lost_password_request_count SMALLINT(6) UNSIGNED NOT NULL DEFAULT '0',".
					"failed_login_count SMALLINT(6) UNSIGNED NOT NULL DEFAULT '0',".
					"total_pages INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"total_revisions INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"total_comments INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"total_uploads INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"fingerprint VARCHAR(40),".
					"PRIMARY KEY (user_id),".
					"UNIQUE KEY idx_user_name (user_name),".
					"KEY idx_account_type (account_type),".
					"KEY idx_enabled (enabled),".
					"KEY idx_signup_time (signup_time)".
				") {$engine} COMMENT='' {$charset}";

$table_user_setting = "CREATE TABLE {$pref}user_setting (".
					"setting_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"theme VARCHAR(20) DEFAULT NULL DEFAULT '',".
					"lang VARCHAR(2) DEFAULT NULL DEFAULT '',".
					"changes_count INT(10) UNSIGNED NOT NULL DEFAULT '50',".
					"revisions_count INT(10) UNSIGNED NOT NULL DEFAULT '20',".
					"dont_redirect TINYINT(1) UNSIGNED DEFAULT NULL,".
					"send_watchmail TINYINT(1) UNSIGNED DEFAULT NULL,".
					"show_files TINYINT(1) UNSIGNED DEFAULT NULL,".
					"show_comments TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"doubleclick_edit TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"show_spaces TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"typografica TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"autocomplete TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"numerate_links TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',".
					"allow_intercom TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"allow_massemail TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"hide_lastsession TINYINT(1) UNSIGNED DEFAULT NULL,".
					"validate_ip TINYINT(1) UNSIGNED DEFAULT NULL,".
					"noid_pubs TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"session_expiration TINYINT(3) UNSIGNED DEFAULT NULL,".
					"timezone DECIMAL(5,2) NOT NULL DEFAULT '0.00',".
					"dst TINYINT(1) UNSIGNED DEFAULT '0' NOT NULL,".
					"PRIMARY KEY (setting_id),".
					"UNIQUE KEY idx_user_id (user_id),".
					"KEY idx_send_watchmail (send_watchmail)".
				") {$engine} COMMENT='' {$charset}";

$table_usergroup = "CREATE TABLE {$pref}usergroup (".
					"group_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"group_name VARCHAR(100) NOT NULL DEFAULT '',".
					"description VARCHAR(255) NOT NULL DEFAULT '',".
					"moderator INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"created DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,".
					"is_system TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"open TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"active TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',".
					"PRIMARY KEY (group_id),".
					"UNIQUE KEY idx_name (group_name)".
				") {$engine} COMMENT='' {$charset}";

$table_usergroup_member = "CREATE TABLE {$pref}usergroup_member (".
					"group_id INTEGER(10) UNSIGNED NOT NULL DEFAULT '0',".
					"user_id INTEGER(10) UNSIGNED NOT NULL DEFAULT '0',".
					"UNIQUE KEY idx_group_id (group_id, user_id)".
				") {$engine} COMMENT='' {$charset}";

$table_watch = "CREATE TABLE {$pref}watch (".
					"watch_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"comment_id INT(10) UNSIGNED NOT NULL DEFAULT '0',".
					"watch_time TIMESTAMP NOT NULL,".
					"PRIMARY KEY (watch_id)".
				") {$engine} COMMENT='' {$charset}";

/* $table_word = "CREATE TABLE {$pref}word (".
					"word_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"word VARCHAR(255) NOT NULL DEFAULT '',".
					"replacement VARCHAR(255) NOT NULL DEFAULT '',".
					"PRIMARY KEY (word_id)".
				") {$engine} COMMENT='' {$charset}"; */

/*
 Wacko Wiki MySQL Table Deletion Script
*/

$table_acl_drop					= "DROP TABLE {$pref}acl";
$table_menu_drop				= "DROP TABLE {$pref}menu";
$table_cache_drop				= "DROP TABLE {$pref}cache";
$table_config_drop				= "DROP TABLE {$pref}config";
$table_category_drop			= "DROP TABLE {$pref}category";
$table_category_page_drop		= "DROP TABLE {$pref}category_page";
$table_link_drop				= "DROP TABLE {$pref}link";
$table_log_drop					= "DROP TABLE {$pref}log";
$table_page_drop				= "DROP TABLE {$pref}page";
$table_poll_drop				= "DROP TABLE {$pref}poll";
$table_rating_drop				= "DROP TABLE {$pref}rating";
$table_referrer_drop			= "DROP TABLE {$pref}referrer";
$table_revision_drop			= "DROP TABLE {$pref}revision";
/*$table_session_drop			= "DROP TABLE {$pref}session";*/
$table_tag_drop					= "DROP TABLE {$pref}tag";
$table_tag_page_drop			= "DROP TABLE {$pref}tag_page";
$table_upload_drop				= "DROP TABLE {$pref}upload";
$table_user_drop				= "DROP TABLE {$pref}user";
$table_user_setting_drop		= "DROP TABLE {$pref}user_setting";
$table_usergroup_drop			= "DROP TABLE {$pref}usergroup";
$table_usergroup_member_drop	= "DROP TABLE {$pref}usergroup_member";
$table_watch_drop				= "DROP TABLE {$pref}watch";
/* $table_word_drop				= "DROP TABLE {$pref}word"; */

?>