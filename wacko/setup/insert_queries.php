<?php

// Install Query Arrays

// adds install arrays for all e.g. mysqli, mysql_pdo, etc.

// delete_tables
//		$value[0] - table name
//		$value[1] - SQL query
$delete_table[]			= array('acl',				$table_acl_drop);
$delete_table[]			= array('auth_token',		$table_auth_token_drop);
$delete_table[]			= array('menu',				$table_menu_drop);
$delete_table[]			= array('cache',			$table_cache_drop);
$delete_table[]			= array('config',			$table_config_drop);
$delete_table[]			= array('usergroup',		$table_usergroup_drop);
$delete_table[]			= array('usergroup_member',	$table_usergroup_member_drop);
$delete_table[]			= array('category',			$table_category_drop);
$delete_table[]			= array('category_page',	$table_category_page_drop);
$delete_table[]			= array('file_link',		$table_file_link_drop);
$delete_table[]			= array('link',				$table_link_drop);
$delete_table[]			= array('log',				$table_log_drop);
$delete_table[]			= array('page',				$table_page_drop);
$delete_table[]			= array('poll',				$table_poll_drop);
$delete_table[]			= array('rating',			$table_rating_drop);
$delete_table[]			= array('referrer',			$table_referrer_drop);
$delete_table[]			= array('revision',			$table_revision_drop);
#$delete_table[]		= array('tag',				$table_tag_drop);
#$delete_table[]		= array('tag_page',			$table_tag_page_drop);
$delete_table[]			= array('upload',			$table_upload_drop);
$delete_table[]			= array('user',				$table_user_drop);
$delete_table[]			= array('user_setting',		$table_user_setting_drop);
$delete_table[]			= array('watch',			$table_watch_drop);
$delete_table[]			= array('word',				$table_word_drop);

// INSTALL
// create tables
//		$value[0] - table name
//		$value[1] - SQL query
$create_table[]			= array('acl',				$table_acl);
$create_table[]			= array('auth_token',		$table_auth_token);
$create_table[]			= array('menu',				$table_menu);
$create_table[]			= array('cache',			$table_cache);
$create_table[]			= array('config',			$table_config);
$create_table[]			= array('usergroup',		$table_usergroup);
$create_table[]			= array('usergroup_member',	$table_usergroup_member);
$create_table[]			= array('category',			$table_category);
$create_table[]			= array('category_page',	$table_category_page);
$create_table[]			= array('file_link',		$table_file_link);
$create_table[]			= array('link',				$table_link);
$create_table[]			= array('log',				$table_log);
$create_table[]			= array('page',				$table_page);
$create_table[]			= array('poll',				$table_poll);
$create_table[]			= array('rating',			$table_rating);
$create_table[]			= array('referrer',			$table_referrer);
$create_table[]			= array('revision',			$table_revision);
#$create_table[]		= array('tag',				$table_tag);
#$create_table[]		= array('tag_page',			$table_tag_page);
$create_table[]			= array('upload',			$table_upload);
$create_table[]			= array('user',				$table_user);
$create_table[]			= array('user_setting',		$table_user_setting);
$create_table[]			= array('watch',			$table_watch);
$create_table[]			= array('word',				$table_word);

// insert_records
//		$value[0] - table name
//		$value[1] - SQL query
//		$value[2] - record
$insert_records[]		= array($lang['InstallingSystemAccount'],	$insert_system,					'system account');
$insert_records[]		= array($lang['InstallingAdmin'],			$insert_admin,					'admin user');
$insert_records[]		= array($lang['InstallingAdminSetting'],	$insert_admin_setting,			'admin user settings');
$insert_records[]		= array($lang['InstallingAdminGroup'],		$insert_admin_group,			'admin group');
$insert_records[]		= array($lang['InstallingAdminGroupMember'],$insert_admin_group_member,		'admin group member');
$insert_records[]		= array($lang['InstallingEverybodyGroup'],	$insert_everybody_group,		'everybody group');
$insert_records[]		= array($lang['InstallingRegisteredGroup'],	$insert_registered_group,		'registered group');
$insert_records[]		= array($lang['InstallingModeratorGroup'],	$insert_moderator_group,		'moderator group');
$insert_records[]		= array($lang['InstallingReviewerGroup'],	$insert_reviewer_group,			'reviewer group');

// UPGRADE
// update tables
//		$value[0] - message
//		$value[1] - table name
//		$value[2] - SQL query
//		$value[3] - error message

// 5.1.0 ############
// cache
$upgrade['5.1.0'][]		= array($lang['AlterTable'],	'cache',		$alter_cache_r5_1_0,		$lang['ErrorAlteringTable']);
$upgrade['5.1.0'][]		= array($lang['AlterTable'],	'cache',		$alter_cache_r5_1_1,		$lang['ErrorAlteringTable']);

// link
$upgrade['5.1.0'][]		= array($lang['AlterTable'],	'link',			$alter_link_r5_1_0,			$lang['ErrorAlteringTable']);

// page
$upgrade['5.1.0'][]		= array($lang['AlterTable'],	'page',			$alter_page_r5_1_0,			$lang['ErrorAlteringTable']);

$upgrade['5.1.0'][]		= array($lang['UpdateTable'],	'page',			$update_page_r5_1_0,		$lang['ErrorUpdatingTable']);

// revision
$upgrade['5.1.0'][]		= array($lang['AlterTable'],	'revision',		$alter_revision_r5_1_0,		$lang['ErrorAlteringTable']);

// upload
$upgrade['5.1.0'][]		= array($lang['AlterTable'],	'upload',		$alter_upload_r5_1_0,		$lang['ErrorAlteringTable']);
$upgrade['5.1.0'][]		= array($lang['AlterTable'],	'upload',		$alter_upload_r5_1_1,		$lang['ErrorAlteringTable']);
$upgrade['5.1.0'][]		= array($lang['AlterTable'],	'upload',		$alter_upload_r5_1_2,		$lang['ErrorAlteringTable']);
$upgrade['5.1.0'][]		= array($lang['AlterTable'],	'upload',		$alter_upload_r5_1_3,		$lang['ErrorAlteringTable']);

// 5.4.0 ############

// auth_token
$upgrade['5.4.0'][]		= array($lang['CreatingTable'],	'auth_token',	$table_auth_token_r5_4_0,	$lang['ErrorCreatingTable']);

// cache
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'cache',		$alter_cache_r5_4_0,		$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'cache',		$alter_cache_r5_4_1,		$lang['ErrorAlteringTable']);

// category
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'category',		$alter_category_r5_4_0,		$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'category',		$alter_category_r5_4_1,		$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'category',		$alter_category_r5_4_2,		$lang['ErrorAlteringTable']);

// config
$upgrade['5.4.0'][]		= array($lang['UpdateTable'],	'config',		$update_config_r5_4_0,		$lang['ErrorUpdatingTable']);
$upgrade['5.4.0'][]		= array($lang['UpdateTable'],	'config',		$update_config_r5_4_1,		$lang['ErrorUpdatingTable']);
$upgrade['5.4.0'][]		= array($lang['UpdateTable'],	'config',		$update_config_r5_4_2,		$lang['ErrorUpdatingTable']);
$upgrade['5.4.0'][]		= array($lang['UpdateTable'],	'config',		$update_config_r5_4_3,		$lang['ErrorUpdatingTable']);
$upgrade['5.4.0'][]		= array($lang['UpdateTable'],	'config',		$update_config_r5_4_4,		$lang['ErrorUpdatingTable']);

// file link
$upgrade['5.4.0'][]		= array($lang['CreatingTable'],	'file_link',	$table_file_link_r5_4_0,	$lang['ErrorCreatingTable']);

//menu
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'menu',			$alter_menu_r5_4_0,			$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'menu',			$alter_menu_r5_4_1,			$lang['ErrorAlteringTable']);

// page
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'page',			$alter_page_r5_4_0,			$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['UpdateTable'],	'page',			$update_page_r5_4_0,		$lang['ErrorUpdatingTable']);
$upgrade['5.4.0'][]		= array($lang['UpdateTable'],	'page',			$update_page_r5_4_1,		$lang['ErrorUpdatingTable']);
$upgrade['5.4.0'][]		= array($lang['UpdateTable'],	'page',			$update_page_r5_4_2,		$lang['ErrorUpdatingTable']);

// referrer
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'referrer',		$alter_referrer_r5_4_0,		$lang['ErrorAlteringTable']);


// revision
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'revision',		$alter_revision_r5_4_0,		$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['UpdateTable'],	'revision',		$update_revision_r5_4_0,	$lang['ErrorUpdatingTable']);

// tag
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'tag',			$alter_tag_r5_4_0,			$lang['ErrorAlteringTable']);

// upload
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'upload',		$alter_upload_r5_4_0,		$lang['ErrorAlteringTable']);

// user
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'user',			$alter_user_r5_4_0,			$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'user',			$alter_user_r5_4_1,			$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'user',			$alter_user_r5_4_2,			$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'user',			$alter_user_r5_4_3,			$lang['ErrorAlteringTable']);

$upgrade['5.5.beta'][]	= array($lang['AlterTable'],	'user',			$alter_user_r5_4_4,			$lang['ErrorAlteringTable']);

// user setting
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_0,	$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_1,	$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_2,	$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_3,	$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_4,	$lang['ErrorAlteringTable']);

$upgrade['5.5.beta'][]	= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_5,	$lang['ErrorAlteringTable']);
$upgrade['5.5.beta'][]	= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_6,	$lang['ErrorAlteringTable']);
$upgrade['5.5.beta'][]	= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_7,	$lang['ErrorAlteringTable']);

// Make sure these are in order!
$upgrade['5.4.0'][]		= array($lang['UpdateTable'],	'user',			$update_user_r5_4_0,		$lang['ErrorUpdatingTable']);

// usergroup
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'usergroup',	$alter_usergroup_r5_4_0,	$lang['ErrorAlteringTable']);
$upgrade['5.4.0'][]		= array($lang['AlterTable'],	'usergroup',	$alter_usergroup_r5_4_1,	$lang['ErrorAlteringTable']);

// usergroup
$upgrade['5.4.0'][]		= array($lang['CreatingTable'],	'word',			$table_word_r5_4_0,			$lang['ErrorCreatingTable']);


?>