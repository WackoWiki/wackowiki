<?php

/*
 WackoWiki SQLite Table Creation Script

 see https://wackowiki.org/doc/Dev/Database
 use the heredoc syntax
 https://sqlite.org/lang_keywords.html
 */

$pref		= $config['table_prefix'];

$tbl_acl = <<<STR
	CREATE TABLE "{$pref}acl" (
		"acl_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"page_id" INTEGER NOT NULL DEFAULT '0' ,
		"privilege" VARCHAR(10) NOT NULL DEFAULT '' ,
		"list" TEXT NOT NULL
	);
	CREATE UNIQUE INDEX "acl_idx_page_id" ON "{$pref}acl" ("page_id", "privilege");
	STR;

$tbl_auth_token = <<<STR
	CREATE TABLE "{$pref}auth_token" (
		"auth_token_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"selector" CHARACTER(12) NOT NULL DEFAULT '' ,
		"token" CHARACTER(64) NOT NULL DEFAULT '' ,
		"user_id" INTEGER NOT NULL DEFAULT '0' ,
		"token_expires" DATETIME NULL
	);
	CREATE UNIQUE INDEX "auth_token_idx_selector" ON "{$pref}auth_token" ("selector");
	CREATE INDEX "auth_token_idx_user_id" ON "{$pref}auth_token" ("user_id");
	STR;

$tbl_cache = <<<STR
	CREATE TABLE "{$pref}cache" (
		"cache_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"hash" CHARACTER(40) NOT NULL DEFAULT '' ,
		"method" VARCHAR(20) NOT NULL DEFAULT '' ,
		"query" VARCHAR(255) NOT NULL DEFAULT '' ,
		"cache_lang" VARCHAR(5) NOT NULL DEFAULT '' ,
		"cache_time" DATETIME NULL
	);
	CREATE INDEX "cache_idx_cache_time" ON "{$pref}cache" ("cache_time");
	CREATE INDEX "cache_idx_hash" ON "{$pref}cache" ("hash");
	STR;

$tbl_category = <<<STR
	CREATE TABLE "{$pref}category" (
		"category_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"parent_id" INTEGER NOT NULL DEFAULT '0' ,
		"category_lang" VARCHAR(5) NOT NULL DEFAULT '' ,
		"category" VARCHAR(255) NOT NULL DEFAULT '' ,
		"category_description" TEXT NOT NULL
	);
	CREATE UNIQUE INDEX "category_idx_category" ON "{$pref}category" ("category_lang", "category");
	STR;

$tbl_category_assignment = <<<STR
	CREATE TABLE "{$pref}category_assignment" (
		"assignment_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"category_id" INTEGER NOT NULL DEFAULT '0' ,
		"object_type_id" INTEGER NOT NULL DEFAULT '0' ,
		"object_id" INTEGER NOT NULL DEFAULT '0'
	);
	CREATE UNIQUE INDEX "category_assignment_idx_assignment" ON "{$pref}category_assignment" ("category_id", "object_type_id", "object_id");
	CREATE INDEX "category_assignment_idx_category_id" ON "{$pref}category_assignment" ("category_id");
	CREATE INDEX "category_assignment_idx_object_id" ON "{$pref}category_assignment" ("object_id");
	CREATE INDEX "category_assignment_idx_object_type_id" ON "{$pref}category_assignment" ("object_type_id");
	STR;

$tbl_config = <<<STR
	CREATE TABLE "{$pref}config" (
		"config_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"config_name" VARCHAR(100) NOT NULL DEFAULT '' ,
		"config_value" TEXT NULL
	);
	CREATE UNIQUE INDEX "config_idx_config_name" ON "{$pref}config" ("config_name");
	STR;

$tbl_external_link = <<<STR
	CREATE TABLE "{$pref}external_link" (
		"link_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"page_id" INTEGER NOT NULL DEFAULT '0' ,
		"link" TEXT NOT NULL
	);
	CREATE INDEX "external_link_idx_page_id" ON "{$pref}external_link" ("page_id");
	STR;

$tbl_file = <<<STR
	CREATE TABLE "{$pref}file" (
		"file_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"page_id" INTEGER NOT NULL DEFAULT '0' ,
		"user_id" INTEGER NOT NULL DEFAULT '0' ,
		"file_name" VARCHAR(255) NOT NULL DEFAULT '' ,
		"file_lang" VARCHAR(5) NOT NULL DEFAULT '' ,
		"file_description" VARCHAR(255) NOT NULL DEFAULT '' ,
		"caption" TEXT NULL  ,
		"author" VARCHAR(255) NOT NULL DEFAULT '' ,
		"source" VARCHAR(255) NOT NULL DEFAULT '' ,
		"source_url" VARCHAR(255) NOT NULL DEFAULT '' ,
		"license_id" INTEGER NOT NULL DEFAULT '0' ,
		"created" DATETIME NULL  ,
		"modified" DATETIME NULL  ,
		"file_size" INTEGER NOT NULL DEFAULT '0' ,
		"picture_w" INTEGER NOT NULL DEFAULT '0' ,
		"picture_h" INTEGER NOT NULL DEFAULT '0' ,
		"file_ext" VARCHAR(10) NOT NULL DEFAULT '' ,
		"mime_type" VARCHAR(255) NOT NULL DEFAULT '' ,
		"file_hash" CHARACTER(40) NOT NULL DEFAULT '' ,
		"deleted" TINYINT NULL DEFAULT '0'
	);
	CREATE INDEX "file_idx_deleted" ON "{$pref}file" ("deleted");
	CREATE INDEX "file_idx_file_hash" ON "{$pref}file" ("file_hash");
	CREATE INDEX "file_idx_file_name" ON "{$pref}file" ("file_name");
	CREATE UNIQUE INDEX "file_idx_page_id" ON "{$pref}file" ("page_id", "file_name");
	CREATE INDEX "file_idx_page_id_2" ON "{$pref}file" ("page_id", "created");
	CREATE INDEX "file_idx_user_id" ON "{$pref}file" ("user_id");
	STR;

$tbl_file_link = <<<STR
	CREATE TABLE "{$pref}file_link" (
		"file_link_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"page_id" INTEGER NOT NULL DEFAULT '0' ,
		"file_id" INTEGER NOT NULL DEFAULT '0'
	);
	CREATE INDEX "file_link_idx_file_id" ON "{$pref}file_link" ("file_id");
	CREATE INDEX "file_link_idx_page_id" ON "{$pref}file_link" ("page_id");
	STR;

$tbl_log = <<<STR
	CREATE TABLE "{$pref}log" (
		"log_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"log_time" DATETIME NULL  ,
		"level" TINYINT NOT NULL DEFAULT '0' ,
		"user_id" INTEGER NOT NULL DEFAULT '0' ,
		"ip" VARCHAR(45) NOT NULL DEFAULT '' ,
		"message" TEXT NOT NULL
	);
	CREATE INDEX "log_idx_ip" ON "{$pref}log" ("ip");
	CREATE INDEX "log_idx_level" ON "{$pref}log" ("level");
	CREATE INDEX "log_idx_time" ON "{$pref}log" ("log_time");
	CREATE INDEX "log_idx_user_id" ON "{$pref}log" ("user_id");
	STR;

$tbl_menu = <<<STR
	CREATE TABLE "{$pref}menu" (
		"menu_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"user_id" INTEGER NOT NULL DEFAULT '0' ,
		"page_id" INTEGER NOT NULL DEFAULT '0' ,
		"menu_lang" VARCHAR(5) NOT NULL DEFAULT '' ,
		"menu_title" VARCHAR(255) NOT NULL DEFAULT '' ,
		"menu_position" SMALLINT NOT NULL DEFAULT '0'
	);
	CREATE INDEX "menu_idx_lang" ON "{$pref}menu" ("menu_lang");
	CREATE UNIQUE INDEX "menu_idx_menu" ON "{$pref}menu" ("user_id", "page_id", "menu_lang");
	CREATE INDEX "menu_idx_page_id" ON "{$pref}menu" ("page_id");
	CREATE INDEX "menu_idx_user_id" ON "{$pref}menu" ("user_id");
	STR;

$tbl_page = <<<STR
	CREATE TABLE "{$pref}page" (
		"page_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"version_id" INTEGER NOT NULL DEFAULT '1' ,
		"owner_id" INTEGER NOT NULL DEFAULT '0' ,
		"user_id" INTEGER NOT NULL DEFAULT '0' ,
		"tag" VARCHAR(255) NOT NULL DEFAULT '' ,
		"title" VARCHAR(255) NOT NULL DEFAULT '' ,
		"menu_tag" VARCHAR(255) NOT NULL DEFAULT '' ,
		"depth" INTEGER NOT NULL DEFAULT '0' ,
		"parent_id" INTEGER NOT NULL DEFAULT '0' ,
		"created" DATETIME NULL  ,
		"modified" DATETIME NULL  ,
		"body" TEXT NOT NULL  ,
		"body_r" TEXT NOT NULL  ,
		"body_toc" TEXT NOT NULL  ,
		"formatting" VARCHAR(20) NOT NULL DEFAULT 'wacko' ,
		"edit_note" VARCHAR(255) NOT NULL DEFAULT '' ,
		"minor_edit" TINYINT NULL DEFAULT '0' ,
		"page_size" INTEGER NOT NULL DEFAULT '0' ,
		"license_id" INTEGER NOT NULL DEFAULT '0' ,
		"reviewed" TINYINT NOT NULL DEFAULT '0' ,
		"reviewed_time" DATETIME NULL  ,
		"reviewer_id" INTEGER NOT NULL DEFAULT '0' ,
		"ip" VARCHAR(45) NOT NULL DEFAULT '' ,
		"latest" TINYINT NULL DEFAULT '1' ,
		"handler" VARCHAR(30) NOT NULL DEFAULT 'page' ,
		"comment_on_id" INTEGER NOT NULL DEFAULT '0' ,
		"comments" INTEGER NOT NULL DEFAULT '0' ,
		"files" INTEGER NOT NULL DEFAULT '0' ,
		"revisions" INTEGER NOT NULL DEFAULT '0' ,
		"hits" INTEGER NOT NULL DEFAULT '0' ,
		"theme" VARCHAR(20) NULL  ,
		"page_lang" VARCHAR(5) NOT NULL DEFAULT '' ,
		"commented" DATETIME NULL  ,
		"description" VARCHAR(255) NOT NULL DEFAULT '' ,
		"keywords" VARCHAR(255) NOT NULL DEFAULT '' ,
		"footer_comments" TINYINT NULL  ,
		"footer_files" TINYINT NULL  ,
		"hide_toc" TINYINT NULL  ,
		"hide_index" TINYINT NULL  ,
		"tree_level" TINYINT NOT NULL DEFAULT '0' ,
		"show_menu_tag" TINYINT NOT NULL DEFAULT '0' ,
		"allow_rawhtml" TINYINT NULL  ,
		"disable_safehtml" TINYINT NULL  ,
		"typografica" TINYINT NULL  ,
		"noindex" TINYINT NULL DEFAULT '0' ,
		"deleted" TINYINT NULL DEFAULT '0'
	);
	CREATE INDEX "page_idx_comment_on_id" ON "{$pref}page" ("comment_on_id");
	CREATE INDEX "page_idx_commented" ON "{$pref}page" ("commented");
	CREATE INDEX "page_idx_created" ON "{$pref}page" ("created");
	CREATE INDEX "page_idx_deleted" ON "{$pref}page" ("deleted");
	CREATE INDEX "page_idx_depth" ON "{$pref}page" ("depth");
	CREATE INDEX "page_idx_minor_edit" ON "{$pref}page" ("minor_edit");
	CREATE INDEX "page_idx_modified" ON "{$pref}page" ("modified");
	CREATE INDEX "page_idx_owner_id" ON "{$pref}page" ("owner_id");
	CREATE INDEX "page_idx_reviewed" ON "{$pref}page" ("reviewed");
	CREATE UNIQUE INDEX "page_idx_tag" ON "{$pref}page" ("tag");
	CREATE INDEX "page_idx_title" ON "{$pref}page" ("title");
	CREATE INDEX "page_idx_user_id" ON "{$pref}page" ("user_id");
	CREATE VIRTUAL TABLE {$pref}page_fts USING fts5(
		title, 
		body,
		content='{$pref}page', 
		content_rowid='page_id'
	);
	STR;

$tbl_page_link = <<<STR
	CREATE TABLE "{$pref}page_link" (
		"link_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"from_page_id" INTEGER NOT NULL DEFAULT '0' ,
		"to_page_id" INTEGER NOT NULL DEFAULT '0' ,
		"to_tag" VARCHAR(255) NOT NULL DEFAULT ''
	);
	CREATE INDEX "page_link_idx_from_page_id" ON "{$pref}page_link" ("from_page_id");
	CREATE INDEX "page_link_idx_from_tag" ON "{$pref}page_link" ("from_page_id", "to_tag");
	CREATE INDEX "page_link_idx_to" ON "{$pref}page_link" ("to_tag");
	STR;

$tbl_referrer = <<<STR
	CREATE TABLE "{$pref}referrer" (
		"referrer_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"page_id" INTEGER NOT NULL DEFAULT '0' ,
		"referrer" VARCHAR(2083) NOT NULL DEFAULT '' ,
		"referrer_time" DATETIME NULL  ,
		"ip" VARCHAR(45) NOT NULL DEFAULT '' ,
		"user_agent" TEXT NULL
	);
	CREATE INDEX "referrer_idx_referrer_time" ON "{$pref}referrer" ("referrer_time");
	CREATE INDEX "referrer_idx_page_id" ON "{$pref}referrer" ("page_id");
	STR;

$tbl_revision = <<<STR
	CREATE TABLE "{$pref}revision" (
		"revision_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"page_id" INTEGER NOT NULL DEFAULT '0' ,
		"version_id" INTEGER NOT NULL DEFAULT '0' ,
		"owner_id" INTEGER NOT NULL DEFAULT '0' ,
		"user_id" INTEGER NOT NULL DEFAULT '0' ,
		"tag" VARCHAR(255) NOT NULL DEFAULT '' ,
		"title" VARCHAR(255) NOT NULL DEFAULT '' ,
		"menu_tag" VARCHAR(255) NOT NULL DEFAULT '' ,
		"created" DATETIME NULL  ,
		"modified" DATETIME NULL  ,
		"body" TEXT NOT NULL  ,
		"body_r" TEXT NOT NULL  ,
		"formatting" VARCHAR(20) NOT NULL DEFAULT '' ,
		"edit_note" VARCHAR(255) NOT NULL DEFAULT '' ,
		"minor_edit" TINYINT NULL DEFAULT '0' ,
		"page_size" INTEGER NOT NULL DEFAULT '0' ,
		"reviewed" TINYINT NOT NULL DEFAULT '0' ,
		"reviewed_time" DATETIME NULL  ,
		"reviewer_id" INTEGER NOT NULL DEFAULT '0' ,
		"latest" TINYINT NULL DEFAULT '0' ,
		"ip" VARCHAR(45) NOT NULL DEFAULT '' ,
		"handler" VARCHAR(30) NOT NULL DEFAULT 'page' ,
		"comment_on_id" INTEGER NOT NULL DEFAULT '0' ,
		"page_lang" VARCHAR(5) NOT NULL DEFAULT '' ,
		"description" VARCHAR(255) NOT NULL DEFAULT '' ,
		"keywords" VARCHAR(255) NOT NULL DEFAULT '' ,
		"deleted" TINYINT NULL DEFAULT '0'
	);
	CREATE INDEX "revision_idx_comment_on_id" ON "{$pref}revision" ("comment_on_id");
	CREATE INDEX "revision_idx_deleted" ON "{$pref}revision" ("deleted");
	CREATE INDEX "revision_idx_minor_edit" ON "{$pref}revision" ("minor_edit");
	CREATE INDEX "revision_idx_modified" ON "{$pref}revision" ("modified");
	CREATE INDEX "revision_idx_owner_id" ON "{$pref}revision" ("owner_id");
	CREATE INDEX "revision_idx_page_id" ON "{$pref}revision" ("page_id");
	CREATE INDEX "revision_idx_reviewed" ON "{$pref}revision" ("reviewed");
	CREATE INDEX "revision_idx_tag" ON "{$pref}revision" ("tag");
	CREATE INDEX "revision_idx_user_id" ON "{$pref}revision" ("user_id");
	CREATE INDEX "revision_idx_version_id" ON "{$pref}revision" ("version_id");
	STR;

$tbl_user = <<<STR
	CREATE TABLE "{$pref}user" (
		"user_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"user_name" VARCHAR(80) NOT NULL DEFAULT '' ,
		"real_name" VARCHAR(80) NOT NULL DEFAULT '' ,
		"password" VARCHAR(255) NOT NULL DEFAULT '' ,
		"email" VARCHAR(254) NOT NULL DEFAULT '' ,
		"account_status" TINYINT NOT NULL DEFAULT '0' ,
		"account_type" TINYINT NOT NULL DEFAULT '0' ,
		"enabled" TINYINT NOT NULL DEFAULT '1' ,
		"signup_time" DATETIME NULL  ,
		"change_password" VARCHAR(64) NOT NULL DEFAULT '' ,
		"user_ip" VARCHAR(45) NOT NULL DEFAULT '' ,
		"email_confirm" VARCHAR(64) NOT NULL DEFAULT '' ,
		"last_visit" DATETIME NULL  ,
		"last_mark" DATETIME NULL  ,
		"login_count" INTEGER NOT NULL DEFAULT '0' ,
		"password_request_count" SMALLINT NOT NULL DEFAULT '0' ,
		"failed_login_count" SMALLINT NOT NULL DEFAULT '0' ,
		"total_pages" INTEGER NOT NULL DEFAULT '0' ,
		"total_revisions" INTEGER NOT NULL DEFAULT '0' ,
		"total_comments" INTEGER NOT NULL DEFAULT '0' ,
		"total_uploads" INTEGER NOT NULL DEFAULT '0'
	);
	CREATE INDEX "user_idx_account_type" ON "{$pref}user" ("account_type");
	CREATE INDEX "user_idx_enabled" ON "{$pref}user" ("enabled");
	CREATE INDEX "user_idx_signup_time" ON "{$pref}user" ("signup_time");
	CREATE UNIQUE INDEX "user_idx_user_name" ON "{$pref}user" ("user_name");
	STR;

$tbl_user_setting = <<<STR
	CREATE TABLE "{$pref}user_setting" (
		"setting_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"user_id" INTEGER NOT NULL DEFAULT '0' ,
		"theme" VARCHAR(20) NULL  ,
		"user_lang" VARCHAR(5) NOT NULL DEFAULT '' ,
		"list_count" INTEGER NOT NULL DEFAULT '50' ,
		"menu_items" INTEGER NOT NULL DEFAULT '5' ,
		"dont_redirect" TINYINT NULL  ,
		"send_watchmail" TINYINT NULL  ,
		"show_files" TINYINT NULL  ,
		"show_comments" TINYINT NOT NULL DEFAULT '1' ,
		"doubleclick_edit" TINYINT NOT NULL DEFAULT '1' ,
		"show_spaces" TINYINT NOT NULL DEFAULT '1' ,
		"autocomplete" TINYINT NOT NULL DEFAULT '0' ,
		"numerate_links" TINYINT NOT NULL DEFAULT '1' ,
		"diff_mode" TINYINT NOT NULL DEFAULT '3' ,
		"notify_minor_edit" TINYINT NOT NULL DEFAULT '1' ,
		"notify_page" TINYINT NOT NULL DEFAULT '2' ,
		"notify_comment" TINYINT NOT NULL DEFAULT '1' ,
		"allow_intercom" TINYINT NOT NULL DEFAULT '0' ,
		"allow_massemail" TINYINT NOT NULL DEFAULT '0' ,
		"hide_lastsession" TINYINT NULL  ,
		"validate_ip" TINYINT NULL  ,
		"noid_pubs" TINYINT NOT NULL DEFAULT '0' ,
		"session_length" TINYINT NULL  ,
		"timezone" VARCHAR(100) NOT NULL DEFAULT 'UTC' ,
		"date_preference" VARCHAR(10) NULL DEFAULT 'default' ,
		"sorting_comments" TINYINT NOT NULL DEFAULT '0' ,
		"comments_offset" TINYINT NOT NULL DEFAULT '0'
	);
	CREATE INDEX "user_setting_idx_send_watchmail" ON "{$pref}user_setting" ("send_watchmail");
	CREATE UNIQUE INDEX "user_setting_idx_user_id" ON "{$pref}user_setting" ("user_id");
	STR;

$tbl_usergroup = <<<STR
	CREATE TABLE "{$pref}usergroup" (
		"group_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"group_name" VARCHAR(100) NOT NULL DEFAULT '' ,
		"description" VARCHAR(255) NOT NULL DEFAULT '' ,
		"moderator_id" INTEGER NOT NULL DEFAULT '0' ,
		"created" DATETIME NULL  ,
		"is_system" TINYINT NOT NULL DEFAULT '0' ,
		"open" TINYINT NOT NULL DEFAULT '0' ,
		"active" TINYINT NOT NULL DEFAULT '0'
	);
	CREATE UNIQUE INDEX "usergroup_idx_name" ON "{$pref}usergroup" ("group_name");
	STR;

$tbl_usergroup_member = <<<STR
	CREATE TABLE "{$pref}usergroup_member" (
		"group_member_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"group_id" INTEGER NOT NULL DEFAULT '0' ,
		"user_id" INTEGER NOT NULL DEFAULT '0'
	);
	CREATE UNIQUE INDEX "usergroup_member_idx_group_id" ON "{$pref}usergroup_member" ("group_id", "user_id");
	STR;

$tbl_watch = <<<STR
	CREATE TABLE "{$pref}watch" (
		"watch_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"user_id" INTEGER NOT NULL DEFAULT '0' ,
		"page_id" INTEGER NOT NULL DEFAULT '0' ,
		"comment_id" INTEGER NOT NULL DEFAULT '0' ,
		"pending" TINYINT NOT NULL DEFAULT '0' ,
		"watch_time" DATETIME NULL
	);
	CREATE INDEX "watch_idx_user_id" ON "{$pref}watch" ("user_id");
	CREATE INDEX "watch_idx_page_id" ON "{$pref}watch" ("page_id");
	STR;

$tbl_word = <<<STR
	CREATE TABLE "{$pref}word" (
		"word_id" INTEGER PRIMARY KEY AUTOINCREMENT,
		"word" VARCHAR(255) NOT NULL DEFAULT '' ,
		"replacement" VARCHAR(255) NOT NULL DEFAULT ''
	);
	STR;


$create_trigger['page_ai'] = <<<STR
	CREATE TRIGGER {$pref}page_ai AFTER INSERT ON {$pref}page
	BEGIN
		INSERT INTO {$pref}page_fts (rowid, title, body)
		VALUES (new.page_id, new.title, new.body);
	END;
	STR;

$create_trigger['page_ad'] = <<<STR
	CREATE TRIGGER {$pref}page_ad AFTER DELETE ON {$pref}page
	BEGIN
		INSERT INTO {$pref}page_fts ({$pref}page_fts, rowid, title, body)
		VALUES ('delete', old.page_id, old.title, old.body);
	END;
	STR;

$create_trigger['page_au'] = <<<STR
	CREATE TRIGGER {$pref}page_au AFTER UPDATE ON {$pref}page
	BEGIN
		INSERT INTO {$pref}page_fts (rowid, title, body)
		VALUES (new.page_id, new.title, new.body);
	END;
	STR;

/*
 Wacko Wiki SQLite Table Deletion Script
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
$tbl_user_drop					= "DROP TABLE IF EXISTS {$pref}user";
$tbl_user_setting_drop			= "DROP TABLE IF EXISTS {$pref}user_setting";
$tbl_usergroup_drop				= "DROP TABLE IF EXISTS {$pref}usergroup";
$tbl_usergroup_member_drop		= "DROP TABLE IF EXISTS {$pref}usergroup_member";
$tbl_watch_drop					= "DROP TABLE IF EXISTS {$pref}watch";
$tbl_word_drop					= "DROP TABLE IF EXISTS {$pref}word";
