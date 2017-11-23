<?php

// Install Query Arrays

// adds install arrays for all e.g. mysqli, mysql_pdo, etc.

// delete_tables
//		$value[0] - table name
//		$value[1] - SQL query
$delete_table[]			= ['acl',					$table_acl_drop];
$delete_table[]			= ['auth_token',			$table_auth_token_drop];
$delete_table[]			= ['menu',					$table_menu_drop];
$delete_table[]			= ['cache',					$table_cache_drop];
$delete_table[]			= ['config',				$table_config_drop];
$delete_table[]			= ['usergroup',				$table_usergroup_drop];
$delete_table[]			= ['usergroup_member',		$table_usergroup_member_drop];
$delete_table[]			= ['category',				$table_category_drop];
$delete_table[]			= ['category_assignment',	$table_category_assignment_drop];
$delete_table[]			= ['file',					$table_file_drop];
$delete_table[]			= ['file_link',				$table_file_link_drop];
$delete_table[]			= ['log',					$table_log_drop];
$delete_table[]			= ['page',					$table_page_drop];
$delete_table[]			= ['page_link',				$table_page_link_drop];
$delete_table[]			= ['poll',					$table_poll_drop];
$delete_table[]			= ['rating',				$table_rating_drop];
$delete_table[]			= ['referrer',				$table_referrer_drop];
$delete_table[]			= ['revision',				$table_revision_drop];
#$delete_table[]		= ['tag',					$table_tag_drop];
#$delete_table[]		= ['tag_assignment',		$table_tag_assignment_drop];
$delete_table[]			= ['user',					$table_user_drop];
$delete_table[]			= ['user_setting',			$table_user_setting_drop];
$delete_table[]			= ['watch',					$table_watch_drop];
$delete_table[]			= ['word',					$table_word_drop];

// INSTALL
// create tables
//		$value[0] - table name
//		$value[1] - SQL query
$create_table[]			= ['acl',					$table_acl];
$create_table[]			= ['auth_token',			$table_auth_token];
$create_table[]			= ['menu',					$table_menu];
$create_table[]			= ['cache',					$table_cache];
$create_table[]			= ['config',				$table_config];
$create_table[]			= ['usergroup',				$table_usergroup];
$create_table[]			= ['usergroup_member',		$table_usergroup_member];
$create_table[]			= ['category',				$table_category];
$create_table[]			= ['category_assignment',	$table_category_assignment];
$create_table[]			= ['file',					$table_file];
$create_table[]			= ['file_link',				$table_file_link];
$create_table[]			= ['log',					$table_log];
$create_table[]			= ['page',					$table_page];
$create_table[]			= ['page_link',				$table_page_link];
$create_table[]			= ['poll',					$table_poll];
$create_table[]			= ['rating',				$table_rating];
$create_table[]			= ['referrer',				$table_referrer];
$create_table[]			= ['revision',				$table_revision];
#$create_table[]		= ['tag',					$table_tag];
#$create_table[]		= ['tag_assignment',		$table_tag_assignment];
$create_table[]			= ['user',					$table_user];
$create_table[]			= ['user_setting',			$table_user_setting];
$create_table[]			= ['watch',					$table_watch];
$create_table[]			= ['word',					$table_word];

// insert_records
//		$value[0] - table name
//		$value[1] - SQL query
//		$value[2] - record
$insert_records[]		= [$lang['InstallingSystemAccount'],		$insert_system,					'system account'];
$insert_records[]		= [$lang['InstallingAdmin'],				$insert_admin,					'admin user'];
$insert_records[]		= [$lang['InstallingAdminSetting'],			$insert_admin_setting,			'admin user settings'];
$insert_records[]		= [$lang['InstallingAdminGroup'],			$insert_admin_group,			'admin group'];
$insert_records[]		= [$lang['InstallingAdminGroupMember'],		$insert_admin_group_member,		'admin group member'];
$insert_records[]		= [$lang['InstallingModeratorGroup'],		$insert_moderator_group,		'moderator group'];
$insert_records[]		= [$lang['InstallingReviewerGroup'],		$insert_reviewer_group,			'reviewer group'];

// UPGRADE
// update tables
//		$value[0] - query type
//		$value[1] - table name
//		$value[2] - SQL query

// 5.1.0 ############
// cache
$upgrade['5.1.0'][]		= ['alter',		'cache',			$alter_cache_r5_1_0];
$upgrade['5.1.0'][]		= ['alter',		'cache',			$alter_cache_r5_1_1];

// file (see 5.4.0)
$upgrade['5.1.0'][]		= ['alter',		'upload',			$alter_file_r5_1_0];
$upgrade['5.1.0'][]		= ['alter',		'upload',			$alter_file_r5_1_1];
$upgrade['5.1.0'][]		= ['alter',		'upload',			$alter_file_r5_1_2];
$upgrade['5.1.0'][]		= ['alter',		'upload',			$alter_file_r5_1_3];

// page
$upgrade['5.1.0'][]		= ['alter',		'page',				$alter_page_r5_1_0];
$upgrade['5.1.0'][]		= ['alter',		'page',				$alter_page_r5_1_1];

$upgrade['5.1.0'][]		= ['update',	'page',				$update_page_r5_1_0];

// page link
$upgrade['5.1.0'][]		= ['alter',		'link',				$alter_page_link_r5_1_0];

// revision
$upgrade['5.1.0'][]		= ['alter',		'revision',			$alter_revision_r5_1_0];

// 5.4.0 ############

// auth_token
$upgrade['5.5.rc'][]	= ['delete',	'auth_token',		$table_auth_token_drop];

$upgrade['5.5.rc'][]	= ['create',	'auth_token',		$table_auth_token_r5_4_0];

// cache
$upgrade['5.4.0'][]		= ['alter',		'cache',			$alter_cache_r5_4_0];
$upgrade['5.4.0'][]		= ['alter',		'cache',			$alter_cache_r5_4_1];

// category
$upgrade['5.4.0'][]		= ['alter',		'category',			$alter_category_r5_4_0];
$upgrade['5.4.0'][]		= ['alter',		'category',			$alter_category_r5_4_1];
$upgrade['5.4.0'][]		= ['alter',		'category',			$alter_category_r5_4_2];

$upgrade['5.5.rc2'][]	= ['alter',		'category',			$alter_category_r5_4_3];

// category assignment
$upgrade['5.5.rc2'][]	= ['rename',	'category_page',	$rename_category_assignment_r5_4_0];

$upgrade['5.5.rc2'][]	= ['alter',		'category_assignment',	$alter_category_assignment_r5_4_0];
$upgrade['5.5.rc2'][]	= ['alter',		'category_assignment',	$alter_category_assignment_r5_4_1];
$upgrade['5.5.rc2'][]	= ['alter',		'category_assignment',	$alter_category_assignment_r5_4_2];
$upgrade['5.5.rc2'][]	= ['alter',		'category_assignment',	$alter_category_assignment_r5_4_3];
$upgrade['5.5.rc2'][]	= ['alter',		'category_assignment',	$alter_category_assignment_r5_4_4];

$upgrade['5.5.rc2'][]	= ['update',	'category_assignment',	$update_category_assignment_r5_4_0];

// config
$upgrade['5.4.0'][]		= ['update',	'config',			$update_config_r5_4_0];
$upgrade['5.4.0'][]		= ['update',	'config',			$update_config_r5_4_1];
$upgrade['5.4.0'][]		= ['update',	'config',			$update_config_r5_4_2];
$upgrade['5.4.0'][]		= ['update',	'config',			$update_config_r5_4_3];
$upgrade['5.4.0'][]		= ['update',	'config',			$update_config_r5_4_4];

// file
$upgrade['5.4.0'][]		= ['alter',		'upload',			$alter_file_r5_4_0];

$upgrade['5.5.rc2'][]	= ['rename',	'file',				$rename_file_r5_4_0];

$upgrade['5.5.rc2'][]	= ['alter',		'file',				$alter_file_r5_4_1];
$upgrade['5.5.rc2'][]	= ['alter',		'file',				$alter_file_r5_4_2];
$upgrade['5.5.rc2'][]	= ['alter',		'file',				$alter_file_r5_4_3];
$upgrade['5.5.rc2'][]	= ['alter',		'file',				$alter_file_r5_4_4];
$upgrade['5.5.rc2'][]	= ['alter',		'file',				$alter_file_r5_4_5];
$upgrade['5.5.rc2'][]	= ['alter',		'file',				$alter_file_r5_4_6];

$upgrade['5.5.rc2'][]	= ['update',	'file',				$update_file_r5_4_0];

// file link
$upgrade['5.4.0'][]		= ['create',	'file_link',		$table_file_link_r5_4_0];

//menu
$upgrade['5.4.0'][]		= ['alter',		'menu',				$alter_menu_r5_4_0];
$upgrade['5.4.0'][]		= ['alter',		'menu',				$alter_menu_r5_4_1];

// page
$upgrade['5.4.0'][]		= ['alter',		'page',				$alter_page_r5_4_0];
$upgrade['5.4.0'][]		= ['update',	'page',				$update_page_r5_4_0];
$upgrade['5.4.0'][]		= ['update',	'page',				$update_page_r5_4_1];
$upgrade['5.4.0'][]		= ['update',	'page',				$update_page_r5_4_2];

$upgrade['5.5.rc'][]	= ['alter',		'page',				$alter_page_r5_4_1];
$upgrade['5.5.rc'][]	= ['alter',		'page',				$alter_page_r5_4_2];
$upgrade['5.5.rc'][]	= ['alter',		'page',				$alter_page_r5_4_3];

$upgrade['5.5.rc2'][]	= ['alter',		'page',				$alter_page_r5_4_4];
$upgrade['5.5.rc2'][]	= ['update',	'page',				$update_page_r5_4_3];
$upgrade['5.5.rc2'][]	= ['update',	'page',				$update_page_r5_4_4];

$upgrade['5.5.0'][]		= ['alter',	'page',					$alter_page_r5_4_5];
$upgrade['5.5.0'][]		= ['alter',	'page',					$alter_page_r5_4_6];

$upgrade['5.5.0'][]		= ['update',	'page',				$update_page_r5_4_5];
$upgrade['5.5.0'][]		= ['update',	'page',				$update_page_r5_4_6];

// page link
$upgrade['5.5.rc2'][]	= ['rename',	'page_link',		$rename_page_link_r5_4_0];


// referrer
$upgrade['5.4.0'][]		= ['alter',		'referrer',			$alter_referrer_r5_4_0];

// revision
$upgrade['5.4.0'][]		= ['alter',		'revision',			$alter_revision_r5_4_0];
$upgrade['5.4.0'][]		= ['update',	'revision',			$update_revision_r5_4_0];

$upgrade['5.5.rc'][]	= ['alter',		'revision',			$alter_revision_r5_4_1];
$upgrade['5.5.rc'][]	= ['alter',		'revision',			$alter_revision_r5_4_2];
$upgrade['5.5.rc'][]	= ['alter',		'revision',			$alter_revision_r5_4_3];
$upgrade['5.5.rc'][]	= ['alter',		'revision',			$alter_revision_r5_4_4];

$upgrade['5.5.rc2'][]	= ['alter',		'revision',			$alter_revision_r5_4_5];
$upgrade['5.5.rc2'][]	= ['update',	'revision',			$update_revision_r5_4_1];

// tag
$upgrade['5.4.0'][]		= ['alter',		'tag',				$alter_tag_r5_4_0];

// user
$upgrade['5.4.0'][]		= ['alter',		'user',				$alter_user_r5_4_0];
$upgrade['5.4.0'][]		= ['alter',		'user',				$alter_user_r5_4_2];
$upgrade['5.4.0'][]		= ['alter',		'user',				$alter_user_r5_4_3];

$upgrade['5.5.beta'][]	= ['alter',		'user',				$alter_user_r5_4_4];
$upgrade['5.5.beta'][]	= ['alter',		'user',				$alter_user_r5_4_5];

// user setting
$upgrade['5.4.0'][]		= ['alter',		'user_setting',		$alter_user_setting_r5_4_0];
$upgrade['5.4.0'][]		= ['alter',		'user_setting',		$alter_user_setting_r5_4_1];
$upgrade['5.4.0'][]		= ['alter',		'user_setting',		$alter_user_setting_r5_4_2];
$upgrade['5.4.0'][]		= ['alter',		'user_setting',		$alter_user_setting_r5_4_3];
$upgrade['5.4.0'][]		= ['alter',		'user_setting',		$alter_user_setting_r5_4_4];

$upgrade['5.5.beta'][]	= ['alter',		'user_setting',		$alter_user_setting_r5_4_5];
$upgrade['5.5.beta'][]	= ['alter',		'user_setting',		$alter_user_setting_r5_4_6];
$upgrade['5.5.beta'][]	= ['alter',		'user_setting',		$alter_user_setting_r5_4_7];

$upgrade['5.5.rc'][]	= ['alter',		'user_setting',		$alter_user_setting_r5_4_8];

$upgrade['5.5.rc3'][]	= ['alter',		'user_setting',		$alter_user_setting_r5_4_9];

$upgrade['5.5.rc3'][]	= ['update',	'user_setting',		$update_user_setting_r5_4_0];

// Make sure these are in order!
$upgrade['5.4.0'][]		= ['update',	'user',				$update_user_r5_4_0];

// usergroup
$upgrade['5.4.0'][]		= ['alter',		'usergroup',		$alter_usergroup_r5_4_0];
$upgrade['5.4.0'][]		= ['alter',		'usergroup',		$alter_usergroup_r5_4_1];

// usergroup
$upgrade['5.4.0'][]		= ['create',	'word',				$table_word_r5_4_0];

// watch
$upgrade['5.5.beta'][]	= ['alter',		'watch',			$alter_watch_r5_4_0];

?>