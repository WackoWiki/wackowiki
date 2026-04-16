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


// BAD BEHAVIOUR


// CACHE


// CATEGORY


// CATEGORY ASSIGNMENT

// CONFIG
$update_config_r6_1_1 = "DELETE FROM {$pref}config WHERE config_name IN ('disable_npjlinks', 'session_prefix')";

// EXTERNAL LINK

// FILE


// FILE LINK

// LOG

// MENU


// PAGE


#$update_page_r6_x_0 = "UPDATE {$pref}page SET body_toc = ''";
#$update_page_r6_x_1 = "UPDATE {$pref}page SET body_r = ''";


// PAGE LINK


// REFERRER


// REVISION


// USER


// USER SETTING
$alter_user_setting_r6_2_1 = "ALTER TABLE {$pref}user_setting ADD editor_height INT(10) UNSIGNED NOT NULL DEFAULT '400' AFTER validate_ip";
$alter_user_setting_r6_2_2 = "ALTER TABLE {$pref}user_setting ADD autosave_draft TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER editor_height";
$alter_user_setting_r6_2_3 = "ALTER TABLE {$pref}user_setting ADD dark_mode TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER editor_height";

// USERGROUP

// USERGROUP MEMBER


// WATCH


// WORD

