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

// CATEGORY

// CATEGORY ASSIGNMENT

// CONFIG
#$update_config_r6_x_0 = "UPDATE {$pref}config SET config_value = '" . _quote('addcomment|admin\.php|categories|claim|clone|diff|edit|export\.xml|file|latex|moderate|new|permissions|purge|print|properties|rate|referrers|referrers_sites|remove|rename|review|revisions|revisions\.xml|robots\.txt|sitemap\.xml|show|source|upload|watch|watchers|wordprocessor') . "' WHERE config_name = 'standard_handlers'";
#$update_config_r6_x_1 = "DELETE FROM {$pref}config WHERE config_name IN ('antidupe', 'disable_tikilinks', 'outlook_workaround', 'owners_can_change_categories')";

// EXTERNAL LINK

// FILE

// FILE LINK

// LOG

// MENU

// PAGE
#$alter_page_r6_x_y = "ALTER TABLE {$pref}page CHANGE ...";

#$update_page_r6_x_0 = "UPDATE {$pref}page SET body_toc = ''";
#$update_page_r6_x_1 = "UPDATE {$pref}page SET body_r = ''";

// PAGE LINK

// POLL

// RATING

// REFERRER

// REVISION

// TAG

// USER

// USER SETTING

// USERGROUP

// WATCH

// WORD

