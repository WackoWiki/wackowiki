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
$delete_table[]			= ['referrer',				$tbl_referrer_drop];
$delete_table[]			= ['revision',				$tbl_revision_drop];
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
$create_table[]			= ['referrer',				$tbl_referrer];
$create_table[]			= ['revision',				$tbl_revision];
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


// 6.0 ############

// acl
$upgrade['6.1.11'][]	= ['alter',		'acl',				$alter_acl_r6_0_1];

// bad behaviour
$upgrade['6.1.13'][]	= ['delete',	'bad_behavior',		$delete_bad_behavior_r6_1_0];

// cache
$upgrade['6.1.22'][]	= ['create',	'cache',			$tbl_cache_r6_0_0];

$upgrade['6.1.9'][]		= ['alter',		'cache',			$alter_cache_r6_0_1];
$upgrade['6.1.21'][]	= ['alter',		'cache',			$alter_cache_r6_0_2];
$upgrade['6.1.22'][]	= ['alter',		'cache',			$alter_cache_r6_0_3];

// category
$upgrade['6.1.23'][]	= ['alter',		'category',			$alter_category_r6_0_1];
$upgrade['6.1.23'][]	= ['alter',		'category',			$alter_category_r6_0_2];

// config
$upgrade['6.1.21'][]	= ['update',	'config',			$update_config_r6_0_1];

// file
$upgrade['6.1.5'][]		= ['alter',		'file',				$alter_file_r6_0_1];
$upgrade['6.1.5'][]		= ['alter',		'file',				$alter_file_r6_0_2];
$upgrade['6.1.9'][]		= ['alter',		'file',				$alter_file_r6_0_3];
$upgrade['6.1.17'][]	= ['alter',		'file',				$alter_file_r6_0_4];
$upgrade['6.1.18'][]	= ['alter',		'file',				$alter_file_r6_0_5];
$upgrade['6.1.18'][]	= ['alter',		'file',				$alter_file_r6_0_6];

// log

// menu
$upgrade['6.1.4'][]		= ['alter',		'menu',				$alter_menu_r6_0_1];
$upgrade['6.1.4'][]		= ['alter',		'menu',				$alter_menu_r6_0_2];
$upgrade['6.1.4'][]		= ['alter',		'menu',				$alter_menu_r6_0_3];
$upgrade['6.1.4'][]		= ['alter',		'menu',				$alter_menu_r6_0_4];

// page
$upgrade['6.1.2'][]		= ['alter',		'page',				$alter_page_r6_0_1];
$upgrade['6.1.16'][]	= ['alter',		'page',				$alter_page_r6_0_2];

$upgrade['6.1.9'][]		= ['update',	'page',				$update_page_r6_0_1];
$upgrade['6.1.9'][]		= ['update',	'page',				$update_page_r6_0_2];
$upgrade['6.1.14'][]	= ['update',	'page',				$update_page_r6_x_0];

// page link

// poll
$upgrade['6.1.2'][]		= ['delete',	'poll',				$delete_poll_r6_0_1];

// rating
$upgrade['6.1.2'][]		= ['delete',	'rating',			$delete_rating_r6_0_1];

// referrer
$upgrade['6.1.9'][]		= ['alter',		'referrer',			$alter_referrer_r6_0_1];

// revision

// user
$upgrade['6.1.3'][]		= ['alter',		'user',				$alter_user_r6_0_1];

// user setting
$upgrade['6.1.3'][]		= ['alter',		'user_settings',	$alter_user_setting_r6_0_1];
$upgrade['6.1.3'][]		= ['alter',		'user_settings',	$alter_user_setting_r6_0_2];
$upgrade['6.1.3'][]		= ['alter',		'user_settings',	$alter_user_setting_r6_0_3];
$upgrade['6.1.26'][]	= ['alter',		'user_settings',	$alter_user_setting_r6_0_4];

$upgrade['6.1.3'][]		= ['update',	'user_settings',	$update_user_setting_r6_0_1];

// usergroup

// usergroup member
$upgrade['6.1.11'][]	= ['alter',		'usergroup_member',	$alter_usergroup_member_r6_0_1];

// watch
$upgrade['6.1.4'][]		= ['alter',		'watch',			$alter_watch_r6_0_1];
$upgrade['6.1.4'][]		= ['alter',		'watch',			$alter_watch_r6_0_2];

