<?php
// config.php written at 03/26/11 13:33:35
// detailed description http://wackowiki.org/Doc/English/Configuration
// do not change wacko_version manually!

$wacko_config = array(
	'base_url' => 'http://localhost/wacko_fresh/wacko/',
	'database_collation' => '0',
	'database_driver' => 'mysql',
	'database_host' => 'localhost',
	'database_port' => '3306',
	'database_database' => 'fresh',
	'database_user' => 'root',
	'database_password' => '',
	'table_prefix' => 'wacko_',
	'system_seed' => '14@houi1Z&4j63WB0((j',
	'recovery_password' => '',
	'cache_dir' => '_cache/',
	'classes_path' => 'classes',
	'action_path' => 'actions',
	'handler_path' => 'handlers',
	'upload_path' => 'files/global',
	'upload_path_per_page' => 'files/perpage',
	'upload_path_backup' => 'files/backup',
	'header_action' => 'header',
	'footer_action' => 'footer',
	'wacko_version' => 'R5.0.dev',
);

?>