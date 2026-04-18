<?php

/*
	WackoWiki SQLite Table Updates Script

	These are all the updates that need to applied to earlier Wacko version to bring them up to 6.1 specs
*/

$pref		= $config['table_prefix'];


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
$alter_user_setting_r6_2_1 = "ALTER TABLE {$pref}user_setting ADD COLUMN editor_height INTEGER NOT NULL DEFAULT 400";
$alter_user_setting_r6_2_2 = "ALTER TABLE {$pref}user_setting ADD COLUMN autosave_draft TINYINT NOT NULL DEFAULT 0";
$alter_user_setting_r6_2_3 = "ALTER TABLE {$pref}user_setting ADD COLUMN dark_mode TINYINT NOT NULL DEFAULT 0";
$alter_user_setting_r6_2_4 = "ALTER TABLE {$pref}user_setting ADD COLUMN syntax_highlighting TINYINT NOT NULL DEFAULT 1";
$alter_user_setting_r6_2_5 = "ALTER TABLE {$pref}user_setting ADD COLUMN live_preview TINYINT NOT NULL DEFAULT 0";

// USERGROUP

// USERGROUP MEMBER


// WATCH


// WORD

