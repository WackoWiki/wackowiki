<?php

/*
	Wacko Wiki MySQL Table Updates Script

	These are all the updates that need to applied to earlier Wacko version to bring them up to 5.1 specs
*/

$pref		= $config['table_prefix'];
$charset	= 'DEFAULT CHARSET=utf8';
$engine		= 'ENGINE='.$config['database_engine'];

// ACL

// CACHE

// CATEGORY

// CONFIG

// LINK

// LOG

// MENU

// PAGE
$update_page_r5_0_1 = "UPDATE {$pref}page SET body_r = ''";
$update_page_r5_0_2 = "UPDATE {$pref}page SET body_toc = ''";
$update_page_r5_1_0 = "UPDATE {$pref}page AS page SET noindex = '0' WHERE page.noindex IS NULL";


// POLL

// RATING

// REFERRER

// REVISION

// TAG

// UPLOAD

// USER

// USER SETTING

// USERGROUP

// WATCH

/* $table_word_r5_0 = "CREATE TABLE {$pref}word (".
					"word_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"word VARCHAR(255) NOT NULL DEFAULT '',".
					"replacement VARCHAR(255) NOT NULL DEFAULT '',".
					"PRIMARY KEY (word_id)".
				") {$engine} COMMENT='' {$charset}"; */

?>