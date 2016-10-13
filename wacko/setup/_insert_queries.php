<?php

// Install Query Arrays

// adds install arrays for all e.g. mysqli, mysql_pdo, etc.

// delete_tables
//		$value[0] - table name
//		$value[1] - SQL query
$delete_table[]			= ['acl',				$table_acl_drop];
$delete_table[]			= ['auth_token',		$table_auth_token_drop];
$delete_table[]			= ['menu',				$table_menu_drop];
$delete_table[]			= ['cache',				$table_cache_drop];
$delete_table[]			= ['config',			$table_config_drop];
$delete_table[]			= ['usergroup',			$table_usergroup_drop];
$delete_table[]			= ['usergroup_member',	$table_usergroup_member_drop];
$delete_table[]			= ['category',			$table_category_drop];
$delete_table[]			= ['category_page',		$table_category_page_drop];
$delete_table[]			= ['file_link',			$table_file_link_drop];
$delete_table[]			= ['log',				$table_log_drop];
$delete_table[]			= ['page',				$table_page_drop];
$delete_table[]			= ['page_link',			$table_page_link_drop];
$delete_table[]			= ['poll',				$table_poll_drop];
$delete_table[]			= ['rating',			$table_rating_drop];
$delete_table[]			= ['referrer',			$table_referrer_drop];
$delete_table[]			= ['revision',			$table_revision_drop];
#$delete_table[]		= ['tag',				$table_tag_drop];
#$delete_table[]		= ['tag_page',			$table_tag_page_drop];
$delete_table[]			= ['upload',			$table_upload_drop];
$delete_table[]			= ['user',				$table_user_drop];
$delete_table[]			= ['user_setting',		$table_user_setting_drop];
$delete_table[]			= ['watch',				$table_watch_drop];
$delete_table[]			= ['word',				$table_word_drop];

// INSTALL
// create tables
//		$value[0] - table name
//		$value[1] - SQL query
$create_table[]			= ['acl',				$table_acl];
$create_table[]			= ['auth_token',		$table_auth_token];
$create_table[]			= ['menu',				$table_menu];
$create_table[]			= ['cache',				$table_cache];
$create_table[]			= ['config',			$table_config];
$create_table[]			= ['usergroup',			$table_usergroup];
$create_table[]			= ['usergroup_member',	$table_usergroup_member];
$create_table[]			= ['category',			$table_category];
$create_table[]			= ['category_page',		$table_category_page];
$create_table[]			= ['file_link',			$table_file_link];
$create_table[]			= ['log',				$table_log];
$create_table[]			= ['page',				$table_page];
$create_table[]			= ['page_link',			$table_page_link];
$create_table[]			= ['poll',				$table_poll];
$create_table[]			= ['rating',			$table_rating];
$create_table[]			= ['referrer',			$table_referrer];
$create_table[]			= ['revision',			$table_revision];
#$create_table[]		= ['tag',				$table_tag];
#$create_table[]		= ['tag_page',			$table_tag_page];
$create_table[]			= ['upload',			$table_upload];
$create_table[]			= ['user',				$table_user];
$create_table[]			= ['user_setting',		$table_user_setting];
$create_table[]			= ['watch',				$table_watch];
$create_table[]			= ['word',				$table_word];

// insert_records
//		$value[0] - table name
//		$value[1] - SQL query
//		$value[2] - record
$insert_records[]		= [$lang['InstallingSystemAccount'],	$insert_system,					'system account'];
$insert_records[]		= [$lang['InstallingAdmin'],			$insert_admin,					'admin user'];
$insert_records[]		= [$lang['InstallingAdminSetting'],		$insert_admin_setting,			'admin user settings'];
$insert_records[]		= [$lang['InstallingAdminGroup'],		$insert_admin_group,			'admin group'];
$insert_records[]		= [$lang['InstallingAdminGroupMember'],	$insert_admin_group_member,		'admin group member'];
$insert_records[]		= [$lang['InstallingEverybodyGroup'],	$insert_everybody_group,		'everybody group'];
$insert_records[]		= [$lang['InstallingRegisteredGroup'],	$insert_registered_group,		'registered group'];
$insert_records[]		= [$lang['InstallingModeratorGroup'],	$insert_moderator_group,		'moderator group'];
$insert_records[]		= [$lang['InstallingReviewerGroup'],	$insert_reviewer_group,			'reviewer group'];

// UPGRADE
// update tables
//		$value[0] - message
//		$value[1] - table name
//		$value[2] - SQL query
//		$value[3] - error message

// 5.1.0 ############
// cache
$upgrade['5.1.0'][]		= [$lang['AlterTable'],		'cache',		$alter_cache_r5_1_0,		$lang['ErrorAlteringTable']];
$upgrade['5.1.0'][]		= [$lang['AlterTable'],		'cache',		$alter_cache_r5_1_1,		$lang['ErrorAlteringTable']];

// page
$upgrade['5.1.0'][]		= [$lang['AlterTable'],		'page',			$alter_page_r5_1_0,			$lang['ErrorAlteringTable']];

$upgrade['5.1.0'][]		= [$lang['UpdateTable'],	'page',			$update_page_r5_1_0,		$lang['ErrorUpdatingTable']];

// page link
$upgrade['5.1.0'][]		= [$lang['AlterTable'],		'link',			$alter_page_link_r5_1_0,	$lang['ErrorAlteringTable']];

// revision
$upgrade['5.1.0'][]		= [$lang['AlterTable'],		'revision',		$alter_revision_r5_1_0,		$lang['ErrorAlteringTable']];

// upload
$upgrade['5.1.0'][]		= [$lang['AlterTable'],		'upload',		$alter_upload_r5_1_0,		$lang['ErrorAlteringTable']];
$upgrade['5.1.0'][]		= [$lang['AlterTable'],		'upload',		$alter_upload_r5_1_1,		$lang['ErrorAlteringTable']];
$upgrade['5.1.0'][]		= [$lang['AlterTable'],		'upload',		$alter_upload_r5_1_2,		$lang['ErrorAlteringTable']];
$upgrade['5.1.0'][]		= [$lang['AlterTable'],		'upload',		$alter_upload_r5_1_3,		$lang['ErrorAlteringTable']];

// 5.4.0 ############

// auth_token
$upgrade['5.5.rc'][]	= [$lang['DeletingTable'],	'auth_token',	$table_auth_token_drop,		$lang['ErrorDeletingTable']];

$upgrade['5.5.rc'][]	= [$lang['CreatingTable'],	'auth_token',	$table_auth_token_r5_4_0,	$lang['ErrorCreatingTable']];

// cache
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'cache',		$alter_cache_r5_4_0,		$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'cache',		$alter_cache_r5_4_1,		$lang['ErrorAlteringTable']];

// category
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'category',		$alter_category_r5_4_0,		$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'category',		$alter_category_r5_4_1,		$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'category',		$alter_category_r5_4_2,		$lang['ErrorAlteringTable']];

$upgrade['5.5.rc2'][]	= [$lang['AlterTable'],		'category',		$alter_category_r5_4_3,		$lang['ErrorAlteringTable']];

// config
$upgrade['5.4.0'][]		= [$lang['UpdateTable'],	'config',		$update_config_r5_4_0,		$lang['ErrorUpdatingTable']];
$upgrade['5.4.0'][]		= [$lang['UpdateTable'],	'config',		$update_config_r5_4_1,		$lang['ErrorUpdatingTable']];
$upgrade['5.4.0'][]		= [$lang['UpdateTable'],	'config',		$update_config_r5_4_2,		$lang['ErrorUpdatingTable']];
$upgrade['5.4.0'][]		= [$lang['UpdateTable'],	'config',		$update_config_r5_4_3,		$lang['ErrorUpdatingTable']];
$upgrade['5.4.0'][]		= [$lang['UpdateTable'],	'config',		$update_config_r5_4_4,		$lang['ErrorUpdatingTable']];

// file link
$upgrade['5.4.0'][]		= [$lang['CreatingTable'],	'file_link',	$table_file_link_r5_4_0,	$lang['ErrorCreatingTable']];

//menu
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'menu',			$alter_menu_r5_4_0,			$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'menu',			$alter_menu_r5_4_1,			$lang['ErrorAlteringTable']];

// page
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'page',			$alter_page_r5_4_0,			$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['UpdateTable'],	'page',			$update_page_r5_4_0,		$lang['ErrorUpdatingTable']];
$upgrade['5.4.0'][]		= [$lang['UpdateTable'],	'page',			$update_page_r5_4_1,		$lang['ErrorUpdatingTable']];
$upgrade['5.4.0'][]		= [$lang['UpdateTable'],	'page',			$update_page_r5_4_2,		$lang['ErrorUpdatingTable']];

$upgrade['5.5.rc'][]	= [$lang['AlterTable'],		'page',			$alter_page_r5_4_1,			$lang['ErrorAlteringTable']];
$upgrade['5.5.rc'][]	= [$lang['AlterTable'],		'page',			$alter_page_r5_4_2,			$lang['ErrorAlteringTable']];
$upgrade['5.5.rc'][]	= [$lang['AlterTable'],		'page',			$alter_page_r5_4_3,			$lang['ErrorAlteringTable']];

$upgrade['5.5.rc2'][]	= [$lang['AlterTable'],		'page',			$alter_page_r5_4_4,			$lang['ErrorAlteringTable']];
$upgrade['5.5.rc2'][]	= [$lang['UpdateTable'],	'page',			$update_page_r5_4_3,		$lang['ErrorUpdatingTable']];
$upgrade['5.5.rc2'][]	= [$lang['UpdateTable'],	'page',			$update_page_r5_4_4,		$lang['ErrorUpdatingTable']];

// page link
$upgrade['5.5.rc2'][]	= [$lang['RenameTable'],	'page_link',	$rename_page_link_r5_4_0,	$lang['ErrorRenamingTable']];


// referrer
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'referrer',		$alter_referrer_r5_4_0,		$lang['ErrorAlteringTable']];

// revision
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'revision',		$alter_revision_r5_4_0,		$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['UpdateTable'],	'revision',		$update_revision_r5_4_0,	$lang['ErrorUpdatingTable']];

$upgrade['5.5.rc'][]	= [$lang['AlterTable'],		'revision',		$alter_revision_r5_4_1,		$lang['ErrorAlteringTable']];
$upgrade['5.5.rc'][]	= [$lang['AlterTable'],		'revision',		$alter_revision_r5_4_2,		$lang['ErrorAlteringTable']];
$upgrade['5.5.rc'][]	= [$lang['AlterTable'],		'revision',		$alter_revision_r5_4_3,		$lang['ErrorAlteringTable']];
$upgrade['5.5.rc'][]	= [$lang['AlterTable'],		'revision',		$alter_revision_r5_4_4,		$lang['ErrorAlteringTable']];

$upgrade['5.5.rc2'][]	= [$lang['AlterTable'],		'revision',		$alter_revision_r5_4_5,		$lang['ErrorAlteringTable']];
$upgrade['5.5.rc2'][]	= [$lang['UpdateTable'],	'revision',		$update_revision_r5_4_1,	$lang['ErrorUpdatingTable']];

// tag
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'tag',			$alter_tag_r5_4_0,			$lang['ErrorAlteringTable']];

// upload
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'upload',		$alter_upload_r5_4_0,		$lang['ErrorAlteringTable']];

// user
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'user',			$alter_user_r5_4_0,			$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'user',			$alter_user_r5_4_2,			$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'user',			$alter_user_r5_4_3,			$lang['ErrorAlteringTable']];

$upgrade['5.5.beta'][]	= [$lang['AlterTable'],		'user',			$alter_user_r5_4_4,			$lang['ErrorAlteringTable']];
$upgrade['5.5.beta'][]	= [$lang['AlterTable'],		'user',			$alter_user_r5_4_5,			$lang['ErrorAlteringTable']];

// user setting
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'user_setting',	$alter_user_setting_r5_4_0,	$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'user_setting',	$alter_user_setting_r5_4_1,	$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'user_setting',	$alter_user_setting_r5_4_2,	$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'user_setting',	$alter_user_setting_r5_4_3,	$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'user_setting',	$alter_user_setting_r5_4_4,	$lang['ErrorAlteringTable']];

$upgrade['5.5.beta'][]	= [$lang['AlterTable'],		'user_setting',	$alter_user_setting_r5_4_5,	$lang['ErrorAlteringTable']];
$upgrade['5.5.beta'][]	= [$lang['AlterTable'],		'user_setting',	$alter_user_setting_r5_4_6,	$lang['ErrorAlteringTable']];
$upgrade['5.5.beta'][]	= [$lang['AlterTable'],		'user_setting',	$alter_user_setting_r5_4_7,	$lang['ErrorAlteringTable']];

$upgrade['5.5.rc'][]	= [$lang['AlterTable'],		'user_setting',	$alter_user_setting_r5_4_8,	$lang['ErrorAlteringTable']];

// Make sure these are in order!
$upgrade['5.4.0'][]		= [$lang['UpdateTable'],	'user',			$update_user_r5_4_0,		$lang['ErrorUpdatingTable']];

// usergroup
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'usergroup',	$alter_usergroup_r5_4_0,	$lang['ErrorAlteringTable']];
$upgrade['5.4.0'][]		= [$lang['AlterTable'],		'usergroup',	$alter_usergroup_r5_4_1,	$lang['ErrorAlteringTable']];

// usergroup
$upgrade['5.4.0'][]		= [$lang['CreatingTable'],	'word',			$table_word_r5_4_0,			$lang['ErrorCreatingTable']];

// watch
$upgrade['5.5.beta'][]	= [$lang['AlterTable'],		'watch',		$alter_watch_r5_4_0,		$lang['ErrorAlteringTable']];

?>