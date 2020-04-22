<?php

/*
	Wacko Wiki MySQL Table Updates Script

	These are all the updates that need to applied to earlier Wacko version to bring them up to 6.0 specs
*/

$pref		= $config['table_prefix'];
$charset	= 'DEFAULT CHARSET=' . $config['database_charset'];
$collation	= 'COLLATE ' . $config['database_collation'];
$engine		= 'ENGINE=' . $config['database_engine'];

// ACL

// AUTH TOKEN

// CACHE

// CATEGORY

// CATEGORY ASSIGNMENT

// CONFIG

$update_config_r5_5_0 = "UPDATE {$pref}config SET config_value = '" . _quote('addcomment|admin\.php|categories|claim|clone|diff|edit|export\.xml|file|latex|moderate|new|permissions|purge|print|properties|rate|referrers|referrers_sites|remove|rename|review|revisions|revisions\.xml|robots\.txt|sitemap\.xml|show|source|upload|watch|watchers|wordprocessor') . "' WHERE config_name = 'standard_handlers'";
$update_config_r5_5_1 = "DELETE FROM {$pref}config WHERE config_name IN ('antidupe', 'disable_tikilinks')";

// EXTERNAL LINK

// FILE

// FILE LINK

// LOG

// MENU

$update_menu_r5_5_0 = "DELETE FROM {$pref}menu WHERE user_id = (SELECT user_id FROM {$pref}user WHERE user_name = 'System' LIMIT 1) AND NOT menu_lang = '" . _quote($config['language']) . "'";
$update_menu_r5_5_1 = "DELETE m.* FROM {$pref}menu m LEFT JOIN {$pref}page p ON (m.page_id = p.page_id) WHERE p.page_id IS NULL";

// PAGE
$alter_page_r5_5_0 = "ALTER TABLE {$pref}page DROP supertag";
$alter_page_r5_5_1 = "ALTER TABLE {$pref}page CHANGE tag tag VARCHAR(250) BINARY NOT NULL DEFAULT ''";

$update_page_r5_5_0 = "UPDATE {$pref}page SET body_toc = ''";
$update_page_r5_5_1 = "UPDATE {$pref}page SET body_r = ''";
$update_page_r5_5_2 = "DELETE FROM {$pref}page WHERE owner_id = (SELECT user_id FROM {$pref}user WHERE user_name = 'System' LIMIT 1) AND NOT page_lang = '" . _quote($config['language']) . "'";

// PAGE LINK

$alter_page_link_r5_5_0 = "ALTER TABLE {$pref}page_link DROP to_supertag";

// POLL

// RATING

// REFERRER

// REVISION
$alter_revision_r5_5_0 = "ALTER TABLE {$pref}revision DROP supertag";

// TAG

// USER
$insert_user_r5_5_0 = "INSERT INTO {$pref}user (user_name, account_lang, password, email, account_type, signup_time) VALUES ('Deleted', '" . _quote($config['language']) . "', '', '', '1', UTC_TIMESTAMP())";

// USER SETTING

$update_user_setting_r5_5_0 = "UPDATE {$pref}user_setting SET theme = 'default'";

// USERGROUP

// WATCH

// WORD

