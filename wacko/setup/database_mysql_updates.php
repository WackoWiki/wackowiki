<?php

/*
	WackoWiki MySQL Table Updates Script

	These are all the updates that need to applied to earlier Wacko version to bring them up to 6.0 specs
*/

$pref		= $config['table_prefix'];
$charset	= 'DEFAULT CHARSET=' . $config['db_charset'];
$collation	= 'COLLATE ' . $config['db_collation'];
$engine		= 'ENGINE=' . $config['db_engine'];

// ACL

// AUTH TOKEN

// CACHE
$alter_cache_r5_5_0 = "ALTER TABLE {$pref}cache CHANGE cache_time cache_time DATETIME NULL DEFAULT NULL";
$alter_cache_r5_5_1 = "ALTER TABLE {$pref}cache CHANGE cache_lang cache_lang VARCHAR(5) NOT NULL DEFAULT ''";
$alter_cache_r5_5_2 = "ALTER TABLE {$pref}cache CHANGE query query VARCHAR(255) NOT NULL DEFAULT ''";

// CATEGORY
$alter_category_r5_5_0 = "ALTER TABLE {$pref}category CHANGE category_lang category_lang VARCHAR(5) NOT NULL DEFAULT ''";

// CATEGORY ASSIGNMENT

// CONFIG

$update_config_r5_5_0 = "UPDATE {$pref}config SET config_value = '" . _quote('addcomment|admin\.php|categories|claim|clone|diff|edit|export\.xml|file|latex|moderate|new|permissions|purge|print|properties|rate|referrers|referrers_sites|remove|rename|review|revisions|revisions\.xml|robots\.txt|sitemap\.xml|show|source|upload|watch|watchers|wordprocessor') . "' WHERE config_name = 'standard_handlers'";
$update_config_r5_5_1 = "DELETE FROM {$pref}config WHERE config_name IN ('antidupe', 'disable_tikilinks', 'outlook_workaround', 'owners_can_change_categories')";

// EXTERNAL LINK

// FILE
$alter_file_r5_5_0 = "ALTER TABLE {$pref}file CHANGE file_lang file_lang VARCHAR(5) NOT NULL DEFAULT ''";
$alter_file_r5_5_1 = "ALTER TABLE {$pref}file CHANGE file_name file_name VARCHAR(255) NOT NULL DEFAULT ''";
$alter_file_r5_5_2 = "ALTER TABLE {$pref}file CHANGE file_description file_description VARCHAR(255) NOT NULL DEFAULT ''";
$alter_file_r5_5_3 = "ALTER TABLE {$pref}file CHANGE author author VARCHAR(255) NOT NULL DEFAULT ''";
$alter_file_r5_5_4 = "ALTER TABLE {$pref}file CHANGE source source VARCHAR(255) NOT NULL DEFAULT ''";
$alter_file_r5_5_5 = "ALTER TABLE {$pref}file DROP hits";

// FILE LINK

// LOG
$alter_log_r5_5_0 = "ALTER TABLE {$pref}log CHANGE log_time log_time DATETIME NULL DEFAULT NULL";

// MENU
$alter_menu_r5_5_0 = "ALTER TABLE {$pref}menu CHANGE menu_lang menu_lang VARCHAR(5) NOT NULL DEFAULT ''";
$alter_menu_r5_5_1 = "ALTER TABLE {$pref}menu CHANGE menu_title menu_title VARCHAR(255) NOT NULL DEFAULT ''";

$update_menu_r5_5_0 = "DELETE FROM {$pref}menu WHERE user_id = (SELECT user_id FROM {$pref}user WHERE user_name = 'System' LIMIT 1) AND NOT menu_lang = '" . _quote($config['language']) . "'";
$update_menu_r5_5_1 = "DELETE m.* FROM {$pref}menu m LEFT JOIN {$pref}page p ON (m.page_id = p.page_id) WHERE p.page_id IS NULL";

// PAGE
$alter_page_r5_5_0 = "ALTER TABLE {$pref}page DROP supertag";
$alter_page_r5_5_1 = "ALTER TABLE {$pref}page CHANGE page_lang page_lang VARCHAR(5) NOT NULL DEFAULT ''";
$alter_page_r5_5_2 = "ALTER TABLE {$pref}page CHANGE tag tag VARCHAR(255) BINARY NOT NULL DEFAULT ''";
$alter_page_r5_5_3 = "ALTER TABLE {$pref}page CHANGE title title VARCHAR(255) NOT NULL DEFAULT ''";
$alter_page_r5_5_4 = "ALTER TABLE {$pref}page CHANGE menu_tag menu_tag VARCHAR(255) NOT NULL DEFAULT ''";
$alter_page_r5_5_5 = "ALTER TABLE {$pref}page CHANGE edit_note edit_note VARCHAR(255) NOT NULL DEFAULT ''";
$alter_page_r5_5_6 = "ALTER TABLE {$pref}page CHANGE description description VARCHAR(255) NOT NULL DEFAULT ''";
$alter_page_r5_5_7 = "ALTER TABLE {$pref}page CHANGE keywords keywords VARCHAR(255) BINARY NOT NULL DEFAULT ''";

$update_page_r5_5_0 = "UPDATE {$pref}page SET body_toc = ''";
$update_page_r5_5_1 = "UPDATE {$pref}page SET body_r = ''";
$update_page_r5_5_2 = "DELETE FROM {$pref}page WHERE owner_id = (SELECT user_id FROM {$pref}user WHERE user_name = 'System' LIMIT 1) AND NOT page_lang = '" . _quote($config['language']) . "'";

// PAGE LINK
$alter_page_link_r5_5_0 = "ALTER TABLE {$pref}page_link DROP to_supertag";
$alter_page_link_r5_5_1 = "ALTER TABLE {$pref}page_link CHANGE to_tag to_tag VARCHAR(255) BINARY NOT NULL DEFAULT ''";

// POLL

// RATING
$alter_rating_r5_5_0 = "ALTER TABLE {$pref}rating CHANGE rating_time rating_time DATETIME NULL DEFAULT NULL";

// REFERRER
$alter_referrer_r5_5_0 = "ALTER TABLE {$pref}referrer CHANGE referrer referrer VARCHAR(2083) NOT NULL DEFAULT ''";

// REVISION
$alter_revision_r5_5_0 = "ALTER TABLE {$pref}revision DROP supertag";
$alter_revision_r5_5_1 = "ALTER TABLE {$pref}revision CHANGE page_lang page_lang VARCHAR(5) NOT NULL DEFAULT ''";
$alter_revision_r5_5_2 = "ALTER TABLE {$pref}revision CHANGE tag tag VARCHAR(255) BINARY NOT NULL DEFAULT ''";
$alter_revision_r5_5_3 = "ALTER TABLE {$pref}revision CHANGE title title VARCHAR(255) NOT NULL DEFAULT ''";
$alter_revision_r5_5_4 = "ALTER TABLE {$pref}revision CHANGE menu_tag menu_tag VARCHAR(255) NOT NULL DEFAULT ''";
$alter_revision_r5_5_5 = "ALTER TABLE {$pref}revision CHANGE edit_note edit_note VARCHAR(255) NOT NULL DEFAULT ''";
$alter_revision_r5_5_6 = "ALTER TABLE {$pref}revision CHANGE description description VARCHAR(255) NOT NULL DEFAULT ''";
$alter_revision_r5_5_7 = "ALTER TABLE {$pref}revision CHANGE keywords keywords VARCHAR(255) BINARY NOT NULL DEFAULT ''";

// TAG

// USER
$alter_user_r5_5_0 = "ALTER TABLE {$pref}user DROP account_lang";
$alter_user_r5_5_1 = "ALTER TABLE {$pref}user DROP fingerprint";
$alter_user_r5_5_2 = "ALTER TABLE {$pref}user CHANGE email email VARCHAR(254) NOT NULL DEFAULT ''";

$insert_user_r5_5_0 = "INSERT INTO {$pref}user (user_name, password, email, account_type, signup_time) VALUES ('Deleted', '', '', '1', UTC_TIMESTAMP())";

// USER SETTING
$alter_user_setting_r5_5_0 = "ALTER TABLE {$pref}user_setting CHANGE user_lang user_lang VARCHAR(5) NOT NULL DEFAULT ''";

$update_user_setting_r5_5_0 = "UPDATE {$pref}user_setting SET theme = 'default'";

// USERGROUP
$alter_usergroup_r5_5_0 = "ALTER TABLE {$pref}usergroup DROP group_lang";

// WATCH
$alter_watch_r5_5_0 = "ALTER TABLE {$pref}watch CHANGE watch_time watch_time DATETIME NULL DEFAULT NULL";

// WORD

