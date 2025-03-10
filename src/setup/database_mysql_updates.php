<?php

/*
	WackoWiki MySQL Table Updates Script

	These are all the updates that need to applied to earlier Wacko version to bring them up to 6.1 specs
*/

$pref		= $config['table_prefix'];
$charset	= 'DEFAULT CHARSET=' . $config['db_charset'];
$collation	= 'COLLATE ' . $config['db_collation'];
$engine		= 'ENGINE=' . $config['db_engine'];

// ACL
$alter_acl_r6_0_1 = "ALTER TABLE {$pref}acl ADD acl_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (acl_id)";

// AUTH TOKEN


// BAD BEHAVIOUR
$delete_bad_behavior_r6_1_0 = "DROP TABLE {$pref}bad_behavior";

// CACHE
$tbl_cache_r6_0_0 = "CREATE TABLE IF NOT EXISTS {$pref}cache (
						cache_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
						hash CHAR(40) NOT NULL DEFAULT '',
						method VARCHAR(20) NOT NULL DEFAULT '',
						query VARCHAR(255) NOT NULL DEFAULT '',
						cache_lang VARCHAR(5) NOT NULL DEFAULT '',
						cache_time DATETIME NULL DEFAULT NULL,
						PRIMARY KEY (cache_id),
						INDEX idx_hash (hash),
						KEY idx_cache_time (cache_time)
					) {$engine} COMMENT='' {$charset} {$collation}";

$alter_cache_r6_0_1 = "ALTER TABLE {$pref}cache CHANGE query query VARCHAR(255) NOT NULL DEFAULT ''";
$alter_cache_r6_0_2 = "ALTER TABLE {$pref}cache CHANGE name hash CHAR(40) NOT NULL DEFAULT ''";
$alter_cache_r6_0_3 = "ALTER TABLE {$pref}cache DROP INDEX name, ADD INDEX idx_hash (hash)";

// CATEGORY
$alter_category_r6_0_1 = "ALTER TABLE {$pref}category CHANGE category_description category_description TEXT NOT NULL";
$alter_category_r6_0_2 = "ALTER TABLE {$pref}category CHANGE category category VARCHAR(255) NOT NULL DEFAULT ''";

// CATEGORY ASSIGNMENT

// CONFIG
$update_config_r6_0_1 = "DELETE FROM {$pref}config WHERE config_name IN ('default_typografica', 'dst', 'ext_bad_behavior', 'footer_rating', 'img_create_thumbnail', 'img_max_thumb_width', 'rename_globalacl', 'tag_page')";

// EXTERNAL LINK

// FILE
$alter_file_r6_0_1 = "ALTER TABLE {$pref}file CHANGE uploaded_dt created DATETIME NULL DEFAULT NULL";
$alter_file_r6_0_2 = "ALTER TABLE {$pref}file CHANGE modified_dt modified DATETIME NULL DEFAULT NULL";
$alter_file_r6_0_3 = "ALTER TABLE {$pref}file CHANGE caption caption TEXT NULL DEFAULT NULL";
$alter_file_r6_0_4 = "ALTER TABLE {$pref}file ADD INDEX idx_file_name (file_name)";
$alter_file_r6_0_5 = "ALTER TABLE {$pref}file ADD file_hash CHAR(40) NOT NULL DEFAULT '' AFTER mime_type";
$alter_file_r6_0_6 = "ALTER TABLE {$pref}file ADD INDEX idx_file_hash (file_hash)";

// FILE LINK

// LOG

// MENU
$alter_menu_r6_0_1 = "ALTER TABLE {$pref}menu DROP INDEX idx_user_id, ADD UNIQUE idx_menu (user_id, page_id, menu_lang)";
$alter_menu_r6_0_2 = "ALTER TABLE {$pref}menu ADD INDEX idx_user_id (user_id)";
$alter_menu_r6_0_3 = "ALTER TABLE {$pref}menu ADD INDEX idx_page_id (page_id)";
$alter_menu_r6_0_4 = "ALTER TABLE {$pref}menu ADD INDEX idx_lang (menu_lang)";

// PAGE
$alter_page_r6_0_1 = "ALTER TABLE {$pref}page DROP footer_rating";
$alter_page_r6_0_2 = "ALTER TABLE {$pref}page ADD typografica TINYINT(1) UNSIGNED NULL DEFAULT NULL AFTER disable_safehtml";

$update_page_r6_x_0 = "UPDATE {$pref}page SET body_toc = ''";
#$update_page_r6_x_1 = "UPDATE {$pref}page SET body_r = ''";
$update_page_r6_0_1 = "UPDATE {$pref}page SET body = REPLACE(body, '[[fn ', '[[^ ');";
$update_page_r6_0_2 = "UPDATE {$pref}page SET body = REPLACE(body, '((fn ', '((^ ');";

// PAGE LINK

// POLL
$delete_poll_r6_0_1 = "DROP TABLE {$pref}poll";

// RATING
$delete_rating_r6_0_1 = "DROP TABLE {$pref}rating";

// REFERRER
$alter_referrer_r6_0_1 = "ALTER TABLE {$pref}referrer CHANGE user_agent user_agent TEXT NULL DEFAULT NULL";

// REVISION

// TAG

// USER
$alter_user_r6_0_1 = "ALTER TABLE {$pref}user CHANGE lost_password_request_count password_request_count SMALLINT(6) UNSIGNED NOT NULL DEFAULT '0'";

// USER SETTING
$alter_user_setting_r6_0_1 = "ALTER TABLE {$pref}user_setting DROP typografica";
$alter_user_setting_r6_0_2 = "ALTER TABLE {$pref}user_setting DROP dst";
$alter_user_setting_r6_0_3 = "ALTER TABLE {$pref}user_setting CHANGE timezone timezone VARCHAR(100) NOT NULL DEFAULT 'UTC'";
$alter_user_setting_r6_0_4 = "ALTER TABLE {$pref}user_setting ADD date_preference VARCHAR(10) NOT NULL DEFAULT 'default' AFTER timezone";

$update_user_setting_r6_0_1 = "UPDATE {$pref}user_setting SET timezone = 'UTC'";

// USERGROUP

// USERGROUP MEMBER
$alter_usergroup_member_r6_0_1 = "ALTER TABLE {$pref}usergroup_member ADD member_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (member_id)";

// WATCH
$alter_watch_r6_0_1 = "ALTER TABLE {$pref}watch ADD INDEX idx_user_id (user_id)";
$alter_watch_r6_0_2 = "ALTER TABLE {$pref}watch ADD INDEX idx_page_id (page_id)";

// WORD

