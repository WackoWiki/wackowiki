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
#$update_config_r6_0_1 = "DELETE FROM {$pref}config WHERE config_name IN ('default_typografica', 'dst')";

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


// USERGROUP

// USERGROUP MEMBER


// WATCH


// WORD

