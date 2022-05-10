<?php

/*
 WackoWiki MySQL Table Creation Script

 see https://wackowiki.org/doc/Dev/Database
 TODO: add COMMENT 'field description'
 */

$pref		= $config['table_prefix'];
$charset	= 'DEFAULT CHARSET=' . $config['db_charset'];
$collation	= 'COLLATE ' . $config['db_collation'];
$engine		= 'ENGINE=' . $config['db_engine'];

$tbl_acl =
	"CREATE TABLE {$pref}acl (
		page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		privilege VARCHAR(10) NOT NULL DEFAULT '',
		list TEXT NOT NULL,
		UNIQUE KEY idx_page_id (page_id, privilege)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_auth_token =
	"CREATE TABLE {$pref}auth_token (
		auth_token_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		selector CHAR(12) NOT NULL DEFAULT '',
		token CHAR(64) NOT NULL DEFAULT '',
		user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		token_expires DATETIME NULL DEFAULT NULL,
		PRIMARY KEY (auth_token_id),
		UNIQUE KEY idx_selector (selector),
		KEY idx_user_id (user_id)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_cache =
	"CREATE TABLE {$pref}cache (
		cache_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		name CHAR(40) NOT NULL DEFAULT '',
		method VARCHAR(20) NOT NULL DEFAULT '',
		query VARCHAR(100) NOT NULL DEFAULT '',
		cache_lang VARCHAR(5) NOT NULL DEFAULT '',
		cache_time DATETIME NULL DEFAULT NULL,
		PRIMARY KEY (cache_id),
		INDEX (name),
		KEY idx_cache_time (cache_time)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_category =
	"CREATE TABLE {$pref}category (
		category_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		parent_id INT(10) UNSIGNED NOT NULL DEFAULT 0,
		category_lang VARCHAR(5) NOT NULL DEFAULT '',
		category VARCHAR(100) NOT NULL DEFAULT '',
		category_description VARCHAR(255) NOT NULL DEFAULT '',
		PRIMARY KEY (category_id),
		UNIQUE KEY idx_category (category_lang, category)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_category_assignment =
	"CREATE TABLE {$pref}category_assignment (
		assignment_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		category_id INT(10) unsigned NOT NULL DEFAULT 0,
		object_type_id INT(10) unsigned NOT NULL DEFAULT 0,
		object_id INT(10) unsigned NOT NULL DEFAULT 0,
		PRIMARY KEY (assignment_id),
		KEY idx_category_id (category_id),
		KEY idx_object_id (object_id),
		KEY idx_object_type_id (object_type_id),
		UNIQUE KEY idx_assignment (category_id, object_type_id, object_id)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_config =
	"CREATE TABLE {$pref}config (
		config_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		config_name VARCHAR(100) NOT NULL DEFAULT '',
		config_value TEXT,
		PRIMARY KEY (config_id),
		UNIQUE KEY idx_config_name (config_name)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_external_link =
	"CREATE TABLE {$pref}external_link (
		link_id INT(10) UNSIGNED NOT NULL  AUTO_INCREMENT,
		page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		link TEXT NOT NULL,
		PRIMARY KEY (link_id),
		KEY idx_page_id (page_id)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_file =
	"CREATE TABLE {$pref}file (
		file_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		file_name VARCHAR(255) NOT NULL DEFAULT '',
		file_lang VARCHAR(5) NOT NULL DEFAULT '',
		file_description VARCHAR(255) NOT NULL DEFAULT '',
		caption TEXT DEFAULT NULL,
		author VARCHAR(255) NOT NULL DEFAULT '',
		source VARCHAR(255) NOT NULL DEFAULT '',
		source_url VARCHAR(255) NOT NULL DEFAULT '',
		license_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		created DATETIME NULL DEFAULT NULL,
		modified DATETIME NULL DEFAULT NULL,
		file_size INT(10) UNSIGNED NOT NULL DEFAULT '0',
		picture_w INT(10) UNSIGNED NOT NULL DEFAULT '0',
		picture_h INT(10) UNSIGNED NOT NULL DEFAULT '0',
		file_ext VARCHAR(10) NOT NULL DEFAULT '',
		mime_type VARCHAR(255) NOT NULL DEFAULT '',
		deleted TINYINT(1) UNSIGNED NULL DEFAULT '0',
		PRIMARY KEY (file_id),
		UNIQUE idx_page_id (page_id, file_name),
		KEY idx_page_id_2 (page_id, created),
		KEY idx_deleted (deleted),
		KEY idx_user_id (user_id)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_file_link =
	"CREATE TABLE {$pref}file_link (
		file_link_id INT(10) UNSIGNED NOT NULL  AUTO_INCREMENT,
		page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		file_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		PRIMARY KEY (file_link_id),
		KEY idx_page_id (page_id),
		KEY idx_file_id (file_id)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_log =
	"CREATE TABLE {$pref}log (
		log_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		log_time DATETIME NULL DEFAULT NULL,
		level TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		ip VARCHAR(45) NOT NULL DEFAULT '',
		message TEXT NOT NULL,
		PRIMARY KEY (log_id),
		KEY idx_level (level),
		KEY idx_user_id (user_id),
		KEY idx_ip (ip),
		KEY idx_time (log_time)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_menu =
	"CREATE TABLE {$pref}menu (
		menu_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		menu_lang VARCHAR(5) NOT NULL DEFAULT '',
		menu_title VARCHAR(255) NOT NULL DEFAULT '',
		menu_position SMALLINT(2) UNSIGNED NOT NULL DEFAULT '0',
		PRIMARY KEY (menu_id),
		KEY idx_user_id (user_id),
		KEY idx_page_id (page_id),
		KEY idx_lang (menu_lang),
		UNIQUE KEY idx_menu (user_id, page_id, menu_lang)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_page =
	"CREATE TABLE {$pref}page (
		page_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		version_id INT(10) UNSIGNED NOT NULL DEFAULT '1',
		owner_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		tag VARCHAR(255) BINARY NOT NULL DEFAULT '',
		title VARCHAR(255) NOT NULL DEFAULT '',
		menu_tag VARCHAR(255) NOT NULL DEFAULT '',
		depth INT(10) UNSIGNED NOT NULL DEFAULT '0',
		parent_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		created DATETIME NULL DEFAULT NULL,
		modified DATETIME NULL DEFAULT NULL,
		body MEDIUMTEXT NOT NULL,
		body_r MEDIUMTEXT NOT NULL,
		body_toc TEXT NOT NULL,
		formatting VARCHAR(20) NOT NULL DEFAULT 'wacko',
		edit_note VARCHAR(255) NOT NULL DEFAULT '',
		minor_edit TINYINT(1) UNSIGNED DEFAULT '0',
		page_size INT(10) UNSIGNED NOT NULL DEFAULT '0',
		license_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		reviewed TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		reviewed_time DATETIME NULL DEFAULT NULL,
		reviewer_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		ip VARCHAR(45) NOT NULL DEFAULT '',
		latest TINYINT(1) UNSIGNED DEFAULT '1',
		handler VARCHAR(30) NOT NULL DEFAULT 'page',
		comment_on_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		comments INT(4) UNSIGNED NOT NULL DEFAULT '0',
		files INT(4) UNSIGNED NOT NULL DEFAULT '0',
		revisions INT(10) UNSIGNED NOT NULL DEFAULT '0',
		hits INT(10) UNSIGNED NOT NULL DEFAULT '0',
		theme VARCHAR(20) DEFAULT NULL,
		page_lang VARCHAR(5) NOT NULL DEFAULT '',
		commented DATETIME NULL DEFAULT NULL,
		description VARCHAR(255) NOT NULL DEFAULT '',
		keywords VARCHAR(255) BINARY NOT NULL DEFAULT '',
		footer_comments TINYINT(1) UNSIGNED NULL DEFAULT NULL,
		footer_files TINYINT(1) UNSIGNED NULL DEFAULT NULL,
		hide_toc TINYINT(1) UNSIGNED NULL DEFAULT NULL,
		hide_index TINYINT(1) UNSIGNED NULL DEFAULT NULL,
		tree_level TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		show_menu_tag TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		allow_rawhtml TINYINT(1) UNSIGNED NULL DEFAULT NULL,
		disable_safehtml TINYINT(1) UNSIGNED NULL DEFAULT NULL,
		noindex TINYINT(1) UNSIGNED NULL DEFAULT '0',
		deleted TINYINT(1) UNSIGNED NULL DEFAULT '0',
		PRIMARY KEY (page_id),
		KEY idx_user_id (user_id),
		KEY idx_owner_id (owner_id),
		FULLTEXT KEY body (body),
		UNIQUE KEY idx_tag (tag),
		KEY idx_depth(depth),
		KEY idx_created (created),
		KEY idx_modified (modified),
		KEY idx_minor_edit (minor_edit),
		KEY idx_deleted (deleted),
		KEY idx_reviewed (reviewed),
		KEY idx_comment_on_id (comment_on_id),
		KEY idx_commented (commented),
		KEY idx_title (title)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_page_link =
	"CREATE TABLE {$pref}page_link (
		link_id INT(10) UNSIGNED NOT NULL  AUTO_INCREMENT,
		from_page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		to_page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		to_tag VARCHAR(255) BINARY NOT NULL DEFAULT '',
		PRIMARY KEY (link_id),
		KEY idx_from_tag (from_page_id, to_tag),
		KEY idx_from_page_id (from_page_id),
		KEY idx_to (to_tag)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_referrer =
	"CREATE TABLE {$pref}referrer (
		referrer_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		referrer VARCHAR(2083) NOT NULL DEFAULT '',
		referrer_time DATETIME DEFAULT NULL,
		ip VARCHAR(45) NOT NULL DEFAULT '',
		user_agent TEXT DEFAULT NULL,
		PRIMARY KEY (referrer_id),
		KEY idx_page_id (page_id),
		KEY idx_referrer_time (referrer_time)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_revision =
	"CREATE TABLE {$pref}revision (
		revision_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		version_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		owner_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		tag VARCHAR(255) BINARY NOT NULL DEFAULT '',
		title VARCHAR(255) NOT NULL DEFAULT '',
		menu_tag VARCHAR(255) NOT NULL DEFAULT '',
		created DATETIME NULL DEFAULT NULL,
		modified DATETIME NULL DEFAULT NULL,
		body MEDIUMTEXT NOT NULL,
		body_r MEDIUMTEXT NOT NULL,
		formatting VARCHAR(20) NOT NULL DEFAULT '',
		edit_note VARCHAR(255) NOT NULL DEFAULT '',
		minor_edit TINYINT(1) UNSIGNED DEFAULT '0',
		page_size INT(10) UNSIGNED NOT NULL DEFAULT '0',
		reviewed TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		reviewed_time DATETIME NULL DEFAULT NULL,
		reviewer_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		latest TINYINT(1) UNSIGNED DEFAULT '0',
		ip VARCHAR(45) NOT NULL DEFAULT '',
		handler VARCHAR(30) NOT NULL DEFAULT 'page',
		comment_on_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		page_lang VARCHAR(5) NOT NULL DEFAULT '',
		description VARCHAR(255) NOT NULL DEFAULT '',
		keywords VARCHAR(255) BINARY NOT NULL DEFAULT '',
		deleted TINYINT(1) UNSIGNED NULL DEFAULT '0',
		PRIMARY KEY (revision_id),
		KEY idx_page_id (page_id),
		KEY idx_version_id (version_id),
		KEY idx_owner_id (owner_id),
		KEY idx_user_id (user_id),
		KEY idx_tag (tag),
		KEY idx_modified (modified),
		KEY idx_minor_edit (minor_edit),
		KEY idx_deleted (deleted),
		KEY idx_reviewed (reviewed),
		KEY idx_comment_on_id (comment_on_id)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_tag =
	"CREATE TABLE {$pref}tag (
		tag_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		tag_lang VARCHAR(5) NOT NULL DEFAULT '',
		tag_name VARCHAR(100) NOT NULL DEFAULT '',
		date_created DATETIME NULL DEFAULT NULL,
		date_updated DATETIME NULL DEFAULT NULL,
		PRIMARY KEY (tag_id),
		KEY idx_tag_name (tag_name)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_tag_assignment =
	"CREATE TABLE {$pref}tag_assignment (
		assignment_id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		tag_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		date_attached DATETIME NULL DEFAULT NULL,
		object_type_id INT(10) unsigned NOT NULL DEFAULT 0,
		object_id INT(10) unsigned NOT NULL DEFAULT 0,
		PRIMARY KEY (assignment_id),
		KEY idx_tag_id (tag_id),
		KEY idx_object_id (object_id),
		KEY idx_object_type_id (object_type_id),
		UNIQUE KEY idx_assignment (tag_id, object_type_id, object_id)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_user =
	"CREATE TABLE {$pref}user (
		user_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		user_name VARCHAR(80) NOT NULL DEFAULT '',
		real_name VARCHAR(80) NOT NULL DEFAULT '',
		password VARCHAR(255) NOT NULL DEFAULT '',
		email VARCHAR(254) NOT NULL DEFAULT '',
		account_status TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		account_type TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		enabled TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
		signup_time DATETIME NULL DEFAULT NULL,
		change_password VARCHAR(64) NOT NULL DEFAULT '',
		user_ip VARCHAR(45) NOT NULL DEFAULT '',
		email_confirm VARCHAR(64) NOT NULL DEFAULT '',
		last_visit DATETIME NULL DEFAULT NULL,
		last_mark DATETIME NULL DEFAULT NULL,
		login_count INT(10) UNSIGNED NOT NULL DEFAULT '0',
		password_request_count SMALLINT(6) UNSIGNED NOT NULL DEFAULT '0',
		failed_login_count SMALLINT(6) UNSIGNED NOT NULL DEFAULT '0',
		total_pages INT(10) UNSIGNED NOT NULL DEFAULT '0',
		total_revisions INT(10) UNSIGNED NOT NULL DEFAULT '0',
		total_comments INT(10) UNSIGNED NOT NULL DEFAULT '0',
		total_uploads INT(10) UNSIGNED NOT NULL DEFAULT '0',
		PRIMARY KEY (user_id),
		UNIQUE KEY idx_user_name (user_name),
		KEY idx_account_type (account_type),
		KEY idx_enabled (enabled),
		KEY idx_signup_time (signup_time)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_user_setting =
	"CREATE TABLE {$pref}user_setting (
		setting_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		theme VARCHAR(20) DEFAULT NULL,
		user_lang VARCHAR(5) NOT NULL DEFAULT '',
		list_count INT(10) UNSIGNED NOT NULL DEFAULT '50',
		menu_items INT(2) UNSIGNED NOT NULL DEFAULT '5',
		dont_redirect TINYINT(1) UNSIGNED DEFAULT NULL,
		send_watchmail TINYINT(1) UNSIGNED DEFAULT NULL,
		show_files TINYINT(1) UNSIGNED DEFAULT NULL,
		show_comments TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
		doubleclick_edit TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
		show_spaces TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
		autocomplete TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		numerate_links TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
		diff_mode TINYINT(1) UNSIGNED NOT NULL DEFAULT '3',
		notify_minor_edit TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
		notify_page TINYINT(1) UNSIGNED NOT NULL DEFAULT '2',
		notify_comment TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
		allow_intercom TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		allow_massemail TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		hide_lastsession TINYINT(1) UNSIGNED DEFAULT NULL,
		validate_ip TINYINT(1) UNSIGNED DEFAULT NULL,
		noid_pubs TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		session_length TINYINT(3) UNSIGNED DEFAULT NULL,
		timezone VARCHAR(100) NOT NULL DEFAULT 'UTC',
		sorting_comments TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		PRIMARY KEY (setting_id),
		UNIQUE KEY idx_user_id (user_id),
		KEY idx_send_watchmail (send_watchmail)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_usergroup =
	"CREATE TABLE {$pref}usergroup (
		group_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		group_name VARCHAR(100) NOT NULL DEFAULT '',
		description VARCHAR(255) NOT NULL DEFAULT '',
		moderator_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		created DATETIME NULL DEFAULT NULL,
		is_system TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		open TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		active TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		PRIMARY KEY (group_id),
		UNIQUE KEY idx_name (group_name)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_usergroup_member =
	"CREATE TABLE {$pref}usergroup_member (
		group_id INTEGER(10) UNSIGNED NOT NULL DEFAULT '0',
		user_id INTEGER(10) UNSIGNED NOT NULL DEFAULT '0',
		UNIQUE KEY idx_group_id (group_id, user_id)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_watch =
	"CREATE TABLE {$pref}watch (
		watch_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
		user_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		page_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		comment_id INT(10) UNSIGNED NOT NULL DEFAULT '0',
		pending TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
		watch_time DATETIME NULL DEFAULT NULL,
		PRIMARY KEY (watch_id),
		KEY idx_user_id (user_id),
		KEY idx_page_id (page_id)
	) {$engine} COMMENT='' {$charset} {$collation}";

$tbl_word =
	"CREATE TABLE {$pref}word (
		word_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
		word VARCHAR(255) NOT NULL DEFAULT '',
		replacement VARCHAR(255) NOT NULL DEFAULT '',
		PRIMARY KEY (word_id)
	) {$engine} COMMENT='' {$charset} {$collation}";

/*
 Wacko Wiki MySQL Table Deletion Script
*/

$tbl_acl_drop					= "DROP TABLE IF EXISTS {$pref}acl";
$tbl_auth_token_drop			= "DROP TABLE IF EXISTS {$pref}auth_token";
$tbl_menu_drop					= "DROP TABLE IF EXISTS {$pref}menu";
$tbl_cache_drop					= "DROP TABLE IF EXISTS {$pref}cache";
$tbl_config_drop				= "DROP TABLE IF EXISTS {$pref}config";
$tbl_category_drop				= "DROP TABLE IF EXISTS {$pref}category";
$tbl_category_assignment_drop	= "DROP TABLE IF EXISTS {$pref}category_assignment";
$tbl_external_link_drop			= "DROP TABLE IF EXISTS {$pref}external_link";
$tbl_file_drop					= "DROP TABLE IF EXISTS {$pref}file";
$tbl_file_link_drop				= "DROP TABLE IF EXISTS {$pref}file_link";
$tbl_log_drop					= "DROP TABLE IF EXISTS {$pref}log";
$tbl_page_drop					= "DROP TABLE IF EXISTS {$pref}page";
$tbl_page_link_drop				= "DROP TABLE IF EXISTS {$pref}page_link";
$tbl_referrer_drop				= "DROP TABLE IF EXISTS {$pref}referrer";
$tbl_revision_drop				= "DROP TABLE IF EXISTS {$pref}revision";
$tbl_tag_drop					= "DROP TABLE IF EXISTS {$pref}tag";
$tbl_tag_assignment_drop		= "DROP TABLE IF EXISTS {$pref}tag_assignment";
$tbl_user_drop					= "DROP TABLE IF EXISTS {$pref}user";
$tbl_user_setting_drop			= "DROP TABLE IF EXISTS {$pref}user_setting";
$tbl_usergroup_drop				= "DROP TABLE IF EXISTS {$pref}usergroup";
$tbl_usergroup_member_drop		= "DROP TABLE IF EXISTS {$pref}usergroup_member";
$tbl_watch_drop					= "DROP TABLE IF EXISTS {$pref}watch";
$tbl_word_drop					= "DROP TABLE IF EXISTS {$pref}word";
