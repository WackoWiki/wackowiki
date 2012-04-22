<?php

/*
	Wacko Wiki MySQL Table Updates Script

	These are all the updates that need to applied to earlier Wacko version to bring them up to 5.0 specs
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

/* $table_word_r4_3 = "CREATE TABLE {$pref}word (".
					"word_id MEDIUMINT(8) UNSIGNED NOT NULL AUTO_INCREMENT,".
					"word VARCHAR(255) NOT NULL DEFAULT '',".
					"replacement VARCHAR(255) NOT NULL DEFAULT '',".
					"PRIMARY KEY (word_id)".
				") {$engine} COMMENT='' {$charset}"; */

?>