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

// AUTH TOKEN

// CACHE

// CATEGORY

// CATEGORY ASSIGNMENT

// CONFIG
$update_config_r6_0_1 = "DELETE FROM {$pref}config WHERE config_name IN ('footer_rating', 'dst')";

// EXTERNAL LINK

// FILE

// FILE LINK

// LOG

// MENU

// PAGE
$alter_page_r6_0_1 = "ALTER TABLE {$pref}page DROP footer_rating";

#$update_page_r6_x_0 = "UPDATE {$pref}page SET body_toc = ''";
#$update_page_r6_x_1 = "UPDATE {$pref}page SET body_r = ''";

// PAGE LINK

// POLL
$delete_poll_r6_0_1 = "DROP TABLE {$pref}poll";

// RATING
$delete_rating_r6_0_1 = "DROP TABLE {$pref}rating";

// REFERRER

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

// WATCH

// WORD

