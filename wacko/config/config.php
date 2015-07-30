<?php
// config.php written at Sat Mar 28 00:21:16 2015
// detailed description http://wackowiki.sourceforge.net/doc/Doc/English/Configuration
// do not change wacko_version manually!

$wacko_config = array(
	'base_url' => 'http://localhost/workspace/dev/wacko/',
	'database_charset' => 'latin1',
	'database_collation' => '0',
	'database_driver' => 'mysql_pdo',
	'database_engine' => 'InnoDB',
	'database_host' => 'localhost',
	'database_port' => '3306',
	'database_database' => 'dev',
	'database_user' => 'root',
	'database_password' => '',
	'table_prefix' => 'wacko_',
	'system_seed' => 'c-&P[(1wN#Nj625*mYE4',
	'recovery_password' => '6827e60fcb69bff2667cf8fcc37540dd0a86c0567afa15c021052e159263f095',
	'cache_dir' => '_cache/',
	'classes_path' => 'class',
	'action_path' => 'action',
	'handler_path' => 'handler',
	'theme_path' => 'theme',
	'formatter_path' => 'formatter',
	'upload_path' => 'files/global',
	'upload_path_per_page' => 'files/perpage',
	'upload_path_backup' => 'files/backup',
	'header_action' => 'header',
	'footer_action' => 'footer',
	'wacko_version' => '5.4.0',
);

?>