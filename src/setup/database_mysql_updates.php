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

// CACHE
$alter_cache_r6_0_1 = "ALTER TABLE {$pref}cache CHANGE query query VARCHAR(255) NOT NULL DEFAULT ''";

// CATEGORY

// CATEGORY ASSIGNMENT

// CONFIG
$update_config_r6_0_1 = "DELETE FROM {$pref}config WHERE config_name IN ('dst', 'footer_rating', 'rename_globalacl')";

// EXTERNAL LINK

// FILE
$alter_file_r6_0_1 = "ALTER TABLE {$pref}file CHANGE uploaded_dt created DATETIME NULL DEFAULT NULL";
$alter_file_r6_0_2 = "ALTER TABLE {$pref}file CHANGE modified_dt modified DATETIME NULL DEFAULT NULL";
$alter_file_r6_0_3 = "ALTER TABLE {$pref}file CHANGE caption caption TEXT NULL DEFAULT NULL";

// FILE LINK

// LOG

// MENU
$alter_menu_r6_0_1 = "ALTER TABLE {$pref}menu DROP INDEX idx_user_id, ADD UNIQUE idx_menu (user_id, page_id, menu_lang) USING BTREE";
$alter_menu_r6_0_2 = "ALTER TABLE {$pref}menu ADD INDEX idx_user_id (user_id)";
$alter_menu_r6_0_3 = "ALTER TABLE {$pref}menu ADD INDEX idx_page_id (page_id)";
$alter_menu_r6_0_4 = "ALTER TABLE {$pref}menu ADD INDEX idx_lang (menu_lang)";

// PAGE
$alter_page_r6_0_1 = "ALTER TABLE {$pref}page DROP footer_rating";

#$update_page_r6_x_0 = "UPDATE {$pref}page SET body_toc = ''";
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

$update_user_setting_r6_0_1 = "UPDATE {$pref}user_setting SET timezone = 'UTC'";

// USERGROUP

// USERGROUP MEMBER
$alter_usergroup_member_r6_0_1 = "ALTER TABLE {$pref}usergroup_member ADD member_id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (member_id)";

// WATCH
$alter_watch_r6_0_1 = "ALTER TABLE {$pref}watch ADD INDEX idx_user_id (user_id)";
$alter_watch_r6_0_2 = "ALTER TABLE {$pref}watch ADD INDEX idx_page_id (page_id)";

// WORD

