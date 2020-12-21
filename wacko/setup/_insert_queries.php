<?php

// Install Query Arrays

// adds install arrays for all e.g. mysqli, mysql_pdo, etc.

// delete_tables
//		$value[0] - table name
//		$value[1] - SQL query
$delete_table[]			= ['acl',					$tbl_acl_drop];
$delete_table[]			= ['auth_token',			$tbl_auth_token_drop];
$delete_table[]			= ['menu',					$tbl_menu_drop];
$delete_table[]			= ['cache',					$tbl_cache_drop];
$delete_table[]			= ['config',				$tbl_config_drop];
$delete_table[]			= ['category',				$tbl_category_drop];
$delete_table[]			= ['category_assignment',	$tbl_category_assignment_drop];
$delete_table[]			= ['external_link',			$tbl_external_link_drop];
$delete_table[]			= ['file',					$tbl_file_drop];
$delete_table[]			= ['file_link',				$tbl_file_link_drop];
$delete_table[]			= ['log',					$tbl_log_drop];
$delete_table[]			= ['page',					$tbl_page_drop];
$delete_table[]			= ['page_link',				$tbl_page_link_drop];
$delete_table[]			= ['poll',					$tbl_poll_drop];
$delete_table[]			= ['rating',				$tbl_rating_drop];
$delete_table[]			= ['referrer',				$tbl_referrer_drop];
$delete_table[]			= ['revision',				$tbl_revision_drop];
#$delete_table[]		= ['tag',					$tbl_tag_drop];
#$delete_table[]		= ['tag_assignment',		$tbl_tag_assignment_drop];
$delete_table[]			= ['user',					$tbl_user_drop];
$delete_table[]			= ['user_setting',			$tbl_user_setting_drop];
$delete_table[]			= ['usergroup',				$tbl_usergroup_drop];
$delete_table[]			= ['usergroup_member',		$tbl_usergroup_member_drop];
$delete_table[]			= ['watch',					$tbl_watch_drop];
$delete_table[]			= ['word',					$tbl_word_drop];

// INSTALL
// create tables
//		$value[0] - table name
//		$value[1] - SQL query
$create_table[]			= ['acl',					$tbl_acl];
$create_table[]			= ['auth_token',			$tbl_auth_token];
$create_table[]			= ['menu',					$tbl_menu];
$create_table[]			= ['cache',					$tbl_cache];
$create_table[]			= ['config',				$tbl_config];
$create_table[]			= ['category',				$tbl_category];
$create_table[]			= ['category_assignment',	$tbl_category_assignment];
$create_table[]			= ['external_link',			$tbl_external_link];
$create_table[]			= ['file',					$tbl_file];
$create_table[]			= ['file_link',				$tbl_file_link];
$create_table[]			= ['log',					$tbl_log];
$create_table[]			= ['page',					$tbl_page];
$create_table[]			= ['page_link',				$tbl_page_link];
$create_table[]			= ['poll',					$tbl_poll];
$create_table[]			= ['rating',				$tbl_rating];
$create_table[]			= ['referrer',				$tbl_referrer];
$create_table[]			= ['revision',				$tbl_revision];
#$create_table[]		= ['tag',					$tbl_tag];
#$create_table[]		= ['tag_assignment',		$tbl_tag_assignment];
$create_table[]			= ['user',					$tbl_user];
$create_table[]			= ['user_setting',			$tbl_user_setting];
$create_table[]			= ['usergroup',				$tbl_usergroup];
$create_table[]			= ['usergroup_member',		$tbl_usergroup_member];
$create_table[]			= ['watch',					$tbl_watch];
$create_table[]			= ['word',					$tbl_word];

// insert_records
//		$value[0] - record type
//		$value[1] - SQL query
//		$value[2] - record
$insert_records[]		= [$lang['InstallSystemAccount'],		$insert_user_system,			'system account'];
$insert_records[]		= [$lang['InstallDeletedAccount'],		$insert_user_deleted,			'deleted account'];
$insert_records[]		= [$lang['InstallAdmin'],				$insert_admin,					'admin user'];
$insert_records[]		= [$lang['InstallAdminSetting'],		$insert_admin_setting,			'admin user settings'];
$insert_records[]		= [$lang['InstallAdminGroup'],			$insert_admin_group,			'admin group'];
$insert_records[]		= [$lang['InstallAdminGroupMember'],	$insert_admin_group_member,		'admin group member'];
$insert_records[]		= [$lang['InstallModeratorGroup'],		$insert_moderator_group,		'moderator group'];
$insert_records[]		= [$lang['InstallReviewerGroup'],		$insert_reviewer_group,			'reviewer group'];

// UPGRADE
// update tables
//		$value[0] - query type
//		$value[1] - table name
//		$value[2] - SQL query


// 5.5 ############

// cache
$upgrade['6.0.8'][]		= ['alter',		'cache',			$alter_cache_r5_5_0];
$upgrade['6.0.11'][]	= ['alter',		'cache',			$alter_cache_r5_5_1];

// category
$upgrade['6.0.10'][]	= ['alter',		'category',			$alter_category_r5_5_0];

// config
$upgrade['5.5.17'][]	= ['update',	'config',			$update_config_r5_5_0];
$upgrade['6.0.11'][]	= ['update',	'config',			$update_config_r5_5_1];

// file
$upgrade['6.0.10'][]	= ['alter',		'file',				$alter_file_r5_5_0];

// log
$upgrade['6.0.8'][]		= ['alter',		'log',				$alter_log_r5_5_0];

// menu
$upgrade['6.0.10'][]	= ['alter',		'menu',				$alter_menu_r5_5_0];
$upgrade['5.5.17'][]	= ['update',	'menu',				$update_menu_r5_5_0];

// page
$upgrade['5.5.17'][]	= ['alter',		'page',				$alter_page_r5_5_0];
$upgrade['6.0.5'][]		= ['alter',		'page',				$alter_page_r5_5_1];
$upgrade['6.0.10'][]	= ['alter',		'page',				$alter_page_r5_5_2];

$upgrade['5.5.17'][]	= ['update',	'page',				$update_page_r5_5_2];

$upgrade['6.0.2'][]		= ['update',	'page',				$update_page_r5_5_0];
$upgrade['6.0.2'][]		= ['update',	'page',				$update_page_r5_5_1];

// keep this order, after $update_page_r5_5_2!
$upgrade['5.5.17'][]	= ['update',	'menu',				$update_menu_r5_5_1];

// page link
$upgrade['5.5.17'][]	= ['alter',		'page_link',		$alter_page_link_r5_5_0];

// rating
$upgrade['6.0.8'][]		= ['alter',		'rating',			$alter_rating_r5_5_0];

// revision
$upgrade['5.5.17'][]	= ['alter',		'revision',			$alter_revision_r5_5_0];
$upgrade['6.0.11'][]	= ['alter',		'revision',			$alter_revision_r5_5_1];
// user
$upgrade['6.0.0'][]		= ['insert',	'user',				$insert_user_r5_5_0];
$upgrade['6.0.7'][]		= ['alter',		'user',				$alter_user_r5_5_0];
$upgrade['6.0.8'][]		= ['alter',		'user',				$alter_user_r5_5_1];

// user settings
$upgrade['6.0.10'][]	= ['alter',		'user_settings',	$alter_user_setting_r5_5_0];

// usergroup
$upgrade['6.0.7'][]		= ['alter',		'usergroup',		$alter_usergroup_r5_5_0];

// watch
$upgrade['6.0.8'][]		= ['alter',		'watch',			$alter_watch_r5_5_0];
