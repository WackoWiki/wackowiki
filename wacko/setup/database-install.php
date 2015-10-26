<?php
@set_time_limit(0);
@ignore_user_abort(true);

function test($text, $condition, $error_text = '', $dblink = '')
{
	global $lang;
	global $config;
	global $dblink;

	echo "            <li>".$text."   ".output_image($condition);

	if(!$condition)
	{
		if($error_text)
		{
			$error_output = "\n".'<ul class="install_error"><li>'.$error_text." <br />";

			if ($config['database_driver'] == 'mysqli_legacy')
			{
				$error_output .= mysqli_error($dblink);
			}

			$error_output .= "</li></ul>";
			echo $error_output;
		}

		echo "</li>\n";
		return false;
	}

	echo "</li>\n";
	return true;
}

function output_error($error_text = '')
{
	echo '<ul class="install_error"><li>'.$error_text."</li></ul>";
}

// TODO: refactoring - same function in wacko class
function random_seed($length, $seed_complexity)
{
	$chars_uc	= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$chars_lc	= 'abcdefghijklmnopqrstuvwxyz';
	$digits		= '0123456789';
	$symbols	= '-_!@#%^&*(){}[]|~'; // removed '$'
	$uc = 0;
	$lc = 0;
	$di = 0;
	$sy = 0;

	if ($seed_complexity == 2)
	{
		$sy = 100;
	}

	while ($uc == 0 || $lc == 0 || $di == 0 || $sy == 0)
	{
		$seed = '';

		for ($i = 0; $i < $length; $i++)
		{
			$k = rand(0, $seed_complexity);  //randomly choose what's next

			if ($k == 0)
			{
				//uppercase
				$seed .= substr(str_shuffle($chars_uc), rand(0, count($chars_uc) - 2), 1);
				$uc++;
			}

			if ($k == 1)
			{
				//lowercase
				$seed .= substr(str_shuffle($chars_lc), rand(0, count($chars_lc) - 2), 1);
				$lc++;
			}

			if ($k == 2)
			{
				//digits
				$seed .= substr(str_shuffle($digits), rand(0, count($digits) - 2), 1);
				$di++;
			}

			if ($k == 3)
			{
				//symbols
				$seed .= substr(str_shuffle($symbols), rand(0, count($symbols) - 2), 1);
				$sy++;
			}
		}
	}

	return $seed;
}

// test configuration
echo "         <h2>".$lang['TestingConfiguration']."</h2>\n";

// Generic Default Inserts
if ($config['system_seed'] == '')
{
	$config['system_seed'] = random_seed(20, 3);
}

$salt_password			= random_seed(10, 3);
$salt_user_form			= random_seed(10, 3);
$password_hashed		= $config['admin_name'].$salt_password.$_POST['password'];
$password_hashed		= password_hash(
								base64_encode(
										hash('sha256', $password_hashed, true)
										),
								PASSWORD_DEFAULT
								);

$config_insert = '';
// set back theme to default, just a precaution
# $config['theme'] = 'default';

// user 'system' holds all default pages
$insert_system				= "INSERT INTO ".$config['table_prefix']."user (user_name, password, salt, email, account_type, signup_time) VALUES ('System', '', '', '', '1', NOW())";
$insert_admin				= "INSERT INTO ".$config['table_prefix']."user (user_name, password, salt, email, signup_time, user_form_salt) VALUES ('".$config['admin_name']."', '".$password_hashed."', '".$salt_password."', '".$config['admin_email']."', NOW(), '".$salt_user_form."')";
$insert_admin_setting		= "INSERT INTO ".$config['table_prefix']."user_setting (user_id, theme, lang) VALUES ((SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), '".$config['theme']."', '".$config['language']."')";

// TODO: for Upgrade insert other aliases also in usergroup table
// $config['aliases'] = array('Admins' => $config['admin_name']);

// default groups
$insert_admin_group			= "INSERT INTO ".$config['table_prefix']."usergroup (group_name, description, moderator_id, created) VALUES ('Admins', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), NOW())";
$insert_admin_group_member	= "INSERT INTO ".$config['table_prefix']."usergroup_member (group_id, user_id) VALUES ((SELECT group_id FROM ".$config['table_prefix']."usergroup WHERE group_name = 'Admins' LIMIT 1), (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1))";

$insert_everybody_group		= "INSERT INTO ".$config['table_prefix']."usergroup (group_name, description, moderator_id, created) VALUES ('Everybody', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), NOW())";
$insert_registered_group	= "INSERT INTO ".$config['table_prefix']."usergroup (group_name, description, moderator_id, created) VALUES ('Registered', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), NOW())";
$insert_moderator_group		= "INSERT INTO ".$config['table_prefix']."usergroup (group_name, description, moderator_id, created) VALUES ('Moderator', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), NOW())";
$insert_reviewer_group		= "INSERT INTO ".$config['table_prefix']."usergroup (group_name, description, moderator_id, created) VALUES ('Reviewer', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), NOW())";

$insert_logo_image			= "INSERT INTO ".$config['table_prefix']."upload (page_id, user_id, file_name, file_description, uploaded_dt, file_size, picture_w, picture_h, file_ext) VALUES ('0', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1),'wacko_logo.png', 'WackoWiki', NOW(), '1580', '108', '50', 'png')";


if (!isset($config['multilanguage']))
{
	$config['multilanguage'] = 0;
}

// inserting secondary config values
$config_db['abuse_email']					= $config['admin_email'];
$config_db['acl_lock']						= $config['acl_lock'];
$config_db['admin_email']					= $config['admin_email'];
$config_db['admin_name']					= $config['admin_name'];
$config_db['allow_email_reuse']				= $config['allow_email_reuse'];
$config_db['allow_persistent_cookie']		= $config['allow_persistent_cookie'];
$config_db['allow_rawhtml']					= $config['allow_rawhtml'];
$config_db['allow_registration']			= $config['allow_registration'];
$config_db['allow_swfobject']				= $config['allow_swfobject'];
$config_db['allow_themes']					= $config['allow_themes'];
$config_db['allow_themes_per_page']			= $config['allow_themes_per_page'];
$config_db['allow_x11colors']				= $config['allow_x11colors'];
$config_db['allowed_languages']				= $config['allowed_languages'];
$config_db['antidupe']						= $config['antidupe'];
$config_db['ap_failed_login_count']			= $config['ap_failed_login_count'];
$config_db['ap_max_login_attempts']			= $config['ap_max_login_attempts'];
$config_db['cache']							= $config['cache'];
$config_db['cache_sql']						= $config['cache_sql'];
$config_db['cache_sql_ttl']					= $config['cache_sql_ttl'];
$config_db['cache_ttl']						= $config['cache_ttl'];
$config_db['captcha_edit_page']				= $config['captcha_edit_page'];
$config_db['captcha_new_comment']			= $config['captcha_new_comment'];
$config_db['captcha_new_page']				= $config['captcha_new_page'];
$config_db['captcha_registration']			= $config['captcha_registration'];
$config_db['category_page']					= $config['category_page'];
$config_db['comments_count']				= $config['comments_count'];
$config_db['comment_delay']					= $config['comment_delay'];
$config_db['cookie_prefix']					= $config['cookie_prefix'];
$config_db['date_format']					= $config['date_format'];
$config_db['date_macro_format']				= $config['date_macro_format'];
$config_db['date_precise_format']			= $config['date_precise_format'];
$config_db['debug']							= $config['debug'];
$config_db['debug_admin_only']				= $config['debug_admin_only'];
$config_db['debug_sql_threshold']			= $config['debug_sql_threshold'];
$config_db['default_comment_acl']			= $config['default_comment_acl'];
$config_db['default_create_acl']			= $config['default_create_acl'];
$config_db['default_read_acl']				= $config['default_read_acl'];
$config_db['default_rename_redirect']		= $config['default_rename_redirect'];
$config_db['default_typografica']			= $config['default_typografica'];
$config_db['default_upload_acl']			= $config['default_upload_acl'];
$config_db['default_write_acl']				= $config['default_write_acl'];
$config_db['disable_autosubscribe']			= $config['disable_autosubscribe'];
$config_db['disable_bracketslinks']			= $config['disable_bracketslinks'];
$config_db['disable_formatters']			= $config['disable_formatters'];
$config_db['disable_npjlinks']				= $config['disable_npjlinks'];
$config_db['disable_safehtml']				= $config['disable_safehtml'];
$config_db['disable_tikilinks']				= $config['disable_tikilinks'];
$config_db['disable_wikilinks']				= $config['disable_wikilinks'];
$config_db['disable_wikiname']				= $config['disable_wikiname'];
$config_db['dst']							= $config['dst'];
$config_db['edit_summary']					= $config['edit_summary'];
$config_db['email_priority']				= $config['email_priority'];
$config_db['email_from']					= $config['email_from'];
$config_db['enable_comments']				= $config['enable_comments'];
$config_db['enable_email']					= $config['enable_email'];
$config_db['enable_email_notification']		= $config['enable_email_notification'];
$config_db['enable_feeds']					= $config['enable_feeds'];
$config_db['enable_security_headers']		= $config['enable_security_headers'];
$config_db['footer_comments']				= $config['footer_comments'];
$config_db['footer_files']					= $config['footer_files'];
$config_db['footer_rating']					= $config['footer_rating'];
$config_db['footer_tags']					= $config['footer_tags'];
$config_db['form_token_sid_guests']			= $config['form_token_sid_guests'];
$config_db['form_token_time']				= $config['form_token_time'];
$config_db['forum_cluster']					= $config['forum_cluster'];
$config_db['forum_topics']					= $config['forum_topics'];
$config_db['groups_page']					= $config['groups_page'];
$config_db['hide_index']					= $config['hide_index'];
$config_db['hide_locked']					= $config['hide_locked'];
$config_db['hide_revisions']				= $config['hide_revisions'];
$config_db['hide_toc']						= $config['hide_toc'];
$config_db['img_create_thumbnail']			= $config['img_create_thumbnail'];
$config_db['img_max_thumb_width']			= $config['img_max_thumb_width'];
$config_db['intercom_delay']				= $config['intercom_delay'];
$config_db['ip_login_limit_max']			= $config['ip_login_limit_max'];
$config_db['keep_deleted_time']				= $config['keep_deleted_time'];
$config_db['language']						= $config['language'];
$config_db['license']						= $config['license'];
$config_db['link_target']					= $config['link_target'];
$config_db['log_default_show']				= $config['log_default_show'];
$config_db['log_level']						= $config['log_level'];
$config_db['log_purge_time']				= $config['log_purge_time'];
$config_db['maint_last_cache']				= NULL; // $config['maint_last_cache'];
$config_db['maint_last_delpages']			= NULL; // $config['maint_last_delpages'];
$config_db['maint_last_log']				= NULL; // $config['maint_last_log'];
$config_db['maint_last_oldpages']			= NULL; // $config['maint_last_oldpages'];
$config_db['maint_last_refs']				= NULL; // $config['maint_last_refs'];
$config_db['maint_last_session']			= NULL; // $config['maint_last_session'];
$config_db['maint_last_xml_sitemap']		= NULL; // $config['maint_last_xml_sitemap'];
$config_db['max_login_attempts']			= $config['max_login_attempts'];
$config_db['meta_description']				= $config['meta_description'];
$config_db['meta_keywords']					= $config['meta_keywords'];
$config_db['minor_edit']					= $config['minor_edit'];
$config_db['multilanguage']					= $config['multilanguage'];
$config_db['name_date_macro']				= $config['name_date_macro'];
$config_db['news_cluster']					= $config['news_cluster'];
$config_db['news_levels']					= $config['news_levels'];
$config_db['noindex']						= $config['noindex'];
$config_db['notify_new_user_account']		= $config['notify_new_user_account'];
$config_db['numerate_links']				= $config['numerate_links'];
$config_db['outlook_workaround']			= $config['outlook_workaround'];
$config_db['owners_can_change_categories']	= $config['owners_can_change_categories'];
$config_db['owners_can_remove_comments']	= $config['owners_can_remove_comments'];
$config_db['pages_purge_time']				= $config['pages_purge_time'];
$config_db['paragrafica']					= $config['paragrafica'];
$config_db['permalink_page']				= $config['permalink_page'];
$config_db['phpmailer']						= $config['phpmailer'];
$config_db['phpmailer_method']				= $config['phpmailer_method'];
$config_db['policy_page']					= $config['policy_page'];
$config_db['publish_anonymously']			= $config['publish_anonymously'];
$config_db['pwd_char_classes']				= $config['pwd_char_classes'];
$config_db['pwd_min_chars']					= $config['pwd_min_chars'];
$config_db['pwd_unlike_login']				= $config['pwd_unlike_login'];
$config_db['rand_seed']						= $config['rand_seed'];
$config_db['rand_seed_last_update']			= $config['rand_seed_last_update'];
$config_db['referrers_purge_time']			= $config['referrers_purge_time'];
$config_db['remove_onlyadmins']				= $config['remove_onlyadmins'];
$config_db['rename_globalacl']				= $config['rename_globalacl'];
$config_db['reverse_proxy']					= $config['reverse_proxy'];
$config_db['reverse_proxy_header']			= $config['reverse_proxy_header'];
$config_db['reverse_proxy_addresses']		= $config['reverse_proxy_addresses'];
$config_db['review']						= $config['review'];
$config_db['revisions_hide_cancel']			= $config['revisions_hide_cancel'];
$config_db['rewrite_mode']					= $config['rewrite_mode'];
$config_db['root_page']						= $config['root_page'];
$config_db['session_length']				= $config['session_length'];
$config_db['session_match_ip']				= $config['session_match_ip'];
$config_db['session_match_useragent']		= $config['session_match_useragent'];
$config_db['session_prefix']				= $config['session_prefix'];
$config_db['session_time_to_update']		= $config['session_time_to_update'];
$config_db['session_use_db']				= $config['session_use_db'];
$config_db['site_desc']						= $config['site_desc'];
$config_db['site_name']						= $config['site_name'];
$config_db['smtp_connection_mode']			= $config['smtp_connection_mode'];
$config_db['smtp_host']						= $config['smtp_host'];
$config_db['smtp_password']					= $config['smtp_password'];
$config_db['smtp_port']						= $config['smtp_port'];
$config_db['smtp_username']					= $config['smtp_username'];
$config_db['show_spaces']					= $config['show_spaces'];
$config_db['sorting_comments']				= $config['sorting_comments'];
$config_db['spam_filter']					= $config['spam_filter'];
$config_db['standard_handlers']				= $config['standard_handlers'];
$config_db['store_deleted_pages']			= $config['store_deleted_pages'];
$config_db['system_message']				= $config['system_message'];
$config_db['tag_page']						= $config['tag_page'];
$config_db['theme']							= $config['theme'];
$config_db['time_format']					= $config['time_format'];
$config_db['time_format_seconds']			= $config['time_format_seconds'];
$config_db['timezone']						= $config['timezone'];
$config_db['tls']							= $config['tls'];
$config_db['tls_implicit']					= $config['tls_implicit'];
$config_db['tls_proxy']						= $config['tls_proxy'];
$config_db['tree_level']					= $config['tree_level'];
$config_db['upload']						= $config['upload'];
$config_db['upload_banned_exts']			= $config['upload_banned_exts'];
$config_db['upload_images_only']			= $config['upload_images_only'];
$config_db['upload_quota']					= $config['upload_quota'];
$config_db['upload_quota_per_user']			= $config['upload_quota_per_user'];
$config_db['upload_max_size']				= $config['upload_max_size'];
$config_db['urls_underscores']				= $config['urls_underscores'];
$config_db['username_chars_min']			= $config['username_chars_min'];
$config_db['username_chars_max']			= $config['username_chars_max'];
$config_db['users_page']					= $config['users_page'];
$config_db['csp']							= $config['csp'];
$config_db['xml_sitemap']					= $config['xml_sitemap'];
$config_db['youarehere_text']				= $config['youarehere_text'];
#$config_db[''] = $config[''];

foreach($config_db as $key => $value)
{
	$config_insert .= "(0, '$key', '$value'),";
}

// to update existing values we use INSERT ... ON DUPLICATE KEY UPDATE: http://dev.mysql.com/doc/refman/5.5/en/insert-on-duplicate.html
$insert_config =	"INSERT INTO ".$config['table_prefix']."config (config_id, config_name, config_value)
						VALUES ".$config_insert."(0, 'maint_last_update', NOW()) ".
					"ON DUPLICATE KEY
						UPDATE
							config_name		= VALUES(config_name),
							config_value	= VALUES(config_value);";

/*
 Setup the tables depending on which database we selected

 mysqli_legacy
 or pdo which is the default clause
 */

$port			= trim($config['database_port']);
$fatal_error	= false;

// check WackoWiki version
if (!isset($config['wacko_version']))
{
	$config['wacko_version'] = '';
}

if (!$version = trim($config['wacko_version']))
{
	$version = '0';
}

if (isset($config['wacko_version']))
{
	if (trim($config['wacko_version']))
	{
		$version = trim($config['wacko_version']);
	}
}

if ($config['database_driver'] == ('mysqli_legacy' || 'mysql_pdo'))
{
	// mariadb / mysql only
	require_once('setup/database_mysql.php');
	require_once('setup/database_mysql_updates.php');
}
/* else if  ($config['database_driver'] == 'pgsql')
{
	require_once('setup/database_pgsql.php');
} */

// add install array for all e.g. mysqli, mysql_pdo, etc.

// delete_tables
//		$value[0] - table name
//		$value[1] - SQL query
$delete_table[]	= array('acl',				$table_acl_drop);
$delete_table[]	= array('auth_token',		$table_auth_token_drop);
$delete_table[]	= array('menu',				$table_menu_drop);
$delete_table[]	= array('cache',			$table_cache_drop);
$delete_table[]	= array('config',			$table_config_drop);
$delete_table[]	= array('usergroup',		$table_usergroup_drop);
$delete_table[]	= array('usergroup_member',	$table_usergroup_member_drop);
$delete_table[]	= array('category',			$table_category_drop);
$delete_table[]	= array('category_page',	$table_category_page_drop);
$delete_table[]	= array('file_link',		$table_file_link_drop);
$delete_table[]	= array('link',				$table_link_drop);
$delete_table[]	= array('log',				$table_log_drop);
$delete_table[]	= array('page',				$table_page_drop);
$delete_table[]	= array('poll',				$table_poll_drop);
$delete_table[]	= array('rating',			$table_rating_drop);
$delete_table[]	= array('referrer',			$table_referrer_drop);
$delete_table[]	= array('revision',			$table_revision_drop);
#$delete_table[]	= array('tag',				$table_tag_drop);
#$delete_table[]	= array('tag_page',			$table_tag_page_drop);
$delete_table[]	= array('upload',			$table_upload_drop);
$delete_table[]	= array('user',				$table_user_drop);
$delete_table[]	= array('user_setting',		$table_user_setting_drop);
$delete_table[]	= array('watch',			$table_watch_drop);
$delete_table[]	= array('word',				$table_word_drop);

// INSTALL
// create tables
//		$value[0] - table name
//		$value[1] - SQL query
$create_table[]	= array('acl',				$table_acl);
$create_table[]	= array('auth_token',		$table_auth_token);
$create_table[]	= array('menu',				$table_menu);
$create_table[]	= array('cache',			$table_cache);
$create_table[]	= array('config',			$table_config);
$create_table[]	= array('usergroup',		$table_usergroup);
$create_table[]	= array('usergroup_member',	$table_usergroup_member);
$create_table[]	= array('category',			$table_category);
$create_table[]	= array('category_page',	$table_category_page);
$create_table[]	= array('file_link',		$table_file_link);
$create_table[]	= array('link',				$table_link);
$create_table[]	= array('log',				$table_log);
$create_table[]	= array('page',				$table_page);
$create_table[]	= array('poll',				$table_poll);
$create_table[]	= array('rating',			$table_rating);
$create_table[]	= array('referrer',			$table_referrer);
$create_table[]	= array('revision',			$table_revision);
#$create_table[]	= array('tag',				$table_tag);
#$create_table[]	= array('tag_page',			$table_tag_page);
$create_table[]	= array('upload',			$table_upload);
$create_table[]	= array('user',				$table_user);
$create_table[]	= array('user_setting',		$table_user_setting);
$create_table[]	= array('watch',			$table_watch);
$create_table[]	= array('word',				$table_word);

// insert_records
//		$value[0] - table name
//		$value[1] - SQL query
//		$value[2] - record
$insert_records[]	= array($lang['InstallingSystemAccount'],	$insert_system,					'system account');
$insert_records[]	= array($lang['InstallingAdmin'],			$insert_admin,					'admin user');
$insert_records[]	= array($lang['InstallingAdminSetting'],	$insert_admin_setting,			'admin user settings');
$insert_records[]	= array($lang['InstallingAdminGroup'],		$insert_admin_group,			'admin group');
$insert_records[]	= array($lang['InstallingAdminGroupMember'],$insert_admin_group_member,		'admin group member');
$insert_records[]	= array($lang['InstallingEverybodyGroup'],	$insert_everybody_group,		'everybody group');
$insert_records[]	= array($lang['InstallingRegisteredGroup'],	$insert_registered_group,		'registered group');
$insert_records[]	= array($lang['InstallingModeratorGroup'],	$insert_moderator_group,		'moderator group');
$insert_records[]	= array($lang['InstallingReviewerGroup'],	$insert_reviewer_group,			'reviewer group');

// UPGRADE
// update tables
//		$value[0] - message
//		$value[1] - table name
//		$value[2] - SQL query
//		$value[3] - error message

// 5.1.0
// cache
$upgrade_5_1_0[]	= array($lang['AlterTable'], 'cache', $alter_cache_r5_1_0, $lang['ErrorAlteringTable']);
$upgrade_5_1_0[]	= array($lang['AlterTable'], 'cache', $alter_cache_r5_1_1, $lang['ErrorAlteringTable']);

// link
$upgrade_5_1_0[]	= array($lang['AlterTable'], 'link', $alter_link_r5_1_0, $lang['ErrorAlteringTable']);

// page
$upgrade_5_1_0[]	= array($lang['AlterTable'], 'page', $alter_page_r5_1_0, $lang['ErrorAlteringTable']);

$upgrade_5_1_0[]	= array($lang['UpdateTable'], 'page', $update_page_r5_1_0, $lang['ErrorUpdatingTable']);

// revision
$upgrade_5_1_0[]	= array($lang['AlterTable'], 'revision', $alter_revision_r5_1_0, $lang['ErrorAlteringTable']);

// upload
$upgrade_5_1_0[]	= array($lang['AlterTable'], 'upload', $alter_upload_r5_1_0, $lang['ErrorAlteringTable']);
$upgrade_5_1_0[]	= array($lang['AlterTable'], 'upload', $alter_upload_r5_1_1, $lang['ErrorAlteringTable']);
$upgrade_5_1_0[]	= array($lang['AlterTable'], 'upload', $alter_upload_r5_1_2, $lang['ErrorAlteringTable']);
$upgrade_5_1_0[]	= array($lang['AlterTable'], 'upload', $alter_upload_r5_1_3, $lang['ErrorAlteringTable']);

// 5.4.0

// auth_token
$upgrade_5_4_0[]	= array($lang['CreatingTable'],	'auth_token',	$table_auth_token_r5_4_0,	$lang['ErrorCreatingTable']);

// cache
$upgrade_5_4_0[]	= array($lang['AlterTable'],	'cache',		$alter_cache_r5_4_0,		$lang['ErrorAlteringTable']);

// category
$upgrade_5_4_0[]	= array($lang['AlterTable'],	'category',		$alter_category_r5_4_0,		$lang['ErrorAlteringTable']);
$upgrade_5_4_0[]	= array($lang['AlterTable'],	'category',		$alter_category_r5_4_1,		$lang['ErrorAlteringTable']);

// config
$upgrade_5_4_0[]	= array($lang['UpdateTable'],	'config',		$update_config_r5_4_0,		$lang['ErrorUpdatingTable']);
$upgrade_5_4_0[]	= array($lang['UpdateTable'],	'config',		$update_config_r5_4_1,		$lang['ErrorUpdatingTable']);
$upgrade_5_4_0[]	= array($lang['UpdateTable'],	'config',		$update_config_r5_4_2,		$lang['ErrorUpdatingTable']);
$upgrade_5_4_0[]	= array($lang['UpdateTable'],	'config',		$update_config_r5_4_3,		$lang['ErrorUpdatingTable']);
$upgrade_5_4_0[]	= array($lang['UpdateTable'],	'config',		$update_config_r5_4_4,		$lang['ErrorUpdatingTable']);

// file link
$upgrade_5_4_0[]	= array($lang['CreatingTable'],	'file_link',	$table_file_link_r5_4_0,		$lang['ErrorCreatingTable']);

//menu
$upgrade_5_4_0[]	= array($lang['AlterTable'],	'menu',			$alter_menu_r5_4_0,			$lang['ErrorAlteringTable']);

// page
$upgrade_5_4_0[]	= array($lang['UpdateTable'],	'page',			$update_page_r5_4_0,		$lang['ErrorUpdatingTable']);
$upgrade_5_4_0[]	= array($lang['UpdateTable'],	'page',			$update_page_r5_4_1,		$lang['ErrorUpdatingTable']);

// referrer
$upgrade_5_4_0[]	= array($lang['AlterTable'],	'referrer',		$alter_referrer_r5_4_0,		$lang['ErrorAlteringTable']);


// revision
$upgrade_5_4_0[]	= array($lang['UpdateTable'],	'revision',		$update_revision_r5_4_0,	$lang['ErrorUpdatingTable']);

// user
$upgrade_5_4_0[]	= array($lang['AlterTable'],	'user',			$alter_user_r5_4_0,			$lang['ErrorAlteringTable']);
$upgrade_5_4_0[]	= array($lang['AlterTable'],	'user',			$alter_user_r5_4_1,			$lang['ErrorAlteringTable']);
$upgrade_5_4_0[]	= array($lang['AlterTable'],	'user',			$alter_user_r5_4_2,			$lang['ErrorAlteringTable']);

// user setting
$upgrade_5_4_0[]	= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_0,	$lang['ErrorAlteringTable']);
$upgrade_5_4_0[]	= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_1,	$lang['ErrorAlteringTable']);
$upgrade_5_4_0[]	= array($lang['AlterTable'],	'user_setting',	$alter_user_setting_r5_4_2,	$lang['ErrorAlteringTable']);

// usergroup
$upgrade_5_4_0[]	= array($lang['AlterTable'],	'usergroup',	$alter_usergroup_r5_4_0,	$lang['ErrorAlteringTable']);

// usergroup
$upgrade_5_4_0[]	= array($lang['CreatingTable'],	'word',			$table_word_r5_4_0,			$lang['ErrorCreatingTable']);

//TODO: if (preg_match('/5\.0\.\d+/i', $version) || $continue == true)
switch($config['database_driver'])
{
	case 'mysqli_legacy':

		if ( !isset ( $config['database_port'] ) )		$config['database_port']	= '3306';
		if (!$port = trim($config['database_port']))	$port						= '3306';

		echo "         <ul>\n";

		if(!test($lang['TestConnectionString'], $dblink = @mysqli_connect($config['database_host'], $config['database_user'], $config['database_password'], null, $port), $lang['ErrorDBConnection']))
		{
			/*
			 There was a problem with the connection string
			 */

			echo "         </ul>\n";
			echo "         <br />\n";

			$fatal_error = true;
		}
		else if(!test($lang['TestDatabaseExists'], @mysqli_select_db($dblink, $config['database_database']), $lang['ErrorDBExists']))
		{
			/*
			 There was a problem with the specified database name
			 */

			echo "         </ul>\n";
			echo "         <br />\n";

			$fatal_error = true;
		}
		else
		{
			/*
			 The connection string and the database name are ok, proceed
			 */
			echo "         </ul>\n";
			echo "         <br />\n";

			if (isset($config['DeleteTables']) && $config['DeleteTables'] == 'on')
			{
				echo "<h2>".$lang['DeletingTables']."</h2>\n";
				echo "            <ol>\n";

				foreach ($delete_table as $param => $value)
				{
					test(str_replace('%1', $value[0], $lang['DeletingTable']), @mysqli_query($dblink, $value[1]), str_replace('%1', $value[0], $lang['ErrorDeletingTable']));

					/* echo '<pre>';
					print_r($value);
					echo '</pre>'; */
				}

				echo "            <li>".$lang['DeletingTablesEnd']."</li>\n";
				echo "         </ol>\n";
				echo "         <br />\n";

				$version = 0;
			}

			switch ($version)
			{
				// new installation
				case '0':
					echo "         <h2>".$lang['InstallingTables']."</h2>\n";
					echo "         <ol>\n";

					foreach ($create_table as $param => $value)
					{
						test(str_replace('%1', $value[0], $lang['CreatingTable']), @mysqli_query($dblink, $value[1]), str_replace('%1', $value[0], $lang['ErrorCreatingTable']));
					}

					foreach ($insert_records as $param => $value)
					{
						test($value[0], @mysqli_query($dblink, $value[1]), str_replace('%1', $value[2], $lang['ErrorAlreadyExists']));
					}

					echo "         </ol>\n";
					echo "         <br />\n";
					echo "         <h2>".$lang['InstallingDefaultData']."</h2>\n";
					echo "         <ul>\n";
					echo "            <li>".$lang['InstallingPagesBegin'];
					require_once('setup/inserts.php');
					echo "</li>\n";
					echo "            <li>".$lang['InstallingPagesEnd']."</li>\n";

					test($lang['InstallingLogoImage'], @mysqli_query($dblink, $insert_logo_image), str_replace('%1', 'logo image', $lang['ErrorAlreadyExists']));
					test($lang['InstallingConfigValues'], @mysqli_query($dblink, $insert_config), str_replace('%1', 'config values', $lang['ErrorAlreadyExists']));
					break;

					/*
					 The funny upgrading stuff. Make sure these are in order!
					 And yes, there are no (switch) breaks here. This is on purpose.
					 */


				// upgrade from R5.0.0 to R5.1.x
				case '5.0.0':
					echo "         <h2>Wacko 5.0.0 ".$lang['To']." ".WACKO_VERSION."</h2>\n";
					echo "         <ol>\n";

					foreach ($upgrade_5_0_0 as $param => $value)
					{
						test(str_replace('%1', $value[1], $value[0]), @mysqli_query($dblink, $value[2]), str_replace('%1', $value[1], $value[3]));
					}

					echo "            </ol>\n";

				// upgrade from R5.1.0 to R5.4.x
				case '5.1.0':
					echo "         <h2>Wacko 5.1.0 ".$lang['To']." ".WACKO_VERSION."</h2>\n";
					echo "         <ol>\n";

					foreach ($upgrade_5_1_0 as $param => $value)
					{
						test(str_replace('%1', $value[1], $value[0]), @mysqli_query($dblink, $value[2]), str_replace('%1', $value[1], $value[3]));
					}

					echo "            </ol>\n";

				// upgrade from R5.1.0 to R5.5.x
				case '5.4.0':
					echo "         <h2>Wacko 5.4.0 ".$lang['To']." ".WACKO_VERSION."</h2>\n";
					echo "         <ol>\n";

					foreach ($upgrade_5_4_0 as $param => $value)
					{
						test(str_replace('%1', $value[1], $value[0]), @mysqli_query($dblink, $value[2]), str_replace('%1', $value[1], $value[3]));
					}

				// inserting config values
				test($lang['InstallingConfigValues'], @mysqli_query($dblink, $insert_config), str_replace('%1', 'config values', $lang['ErrorAlreadyExists']));

				echo "            </ol>\n";
				echo "         <br />\n";
				echo "         <h2>".$lang['InstallingDefaultData']."</h2>\n";
				echo "         <ul>\n";
				echo "            <li>".$lang['InstallingPagesBegin'];
				require_once('setup/inserts.php');
				echo "</li>\n";
				echo "            <li>".$lang['InstallingPagesEnd']."</li>\n";
			}

			echo "         </ul>\n";
		}

		break;

	default:
		$dsn = '';
		switch($config['database_driver'])
		{
			/* case 'sqlite2': */
			case 'mysql_pdo':

				if ($config['database_driver'] == 'mysql_pdo')
				{
					#$config['database_driver'] = 'mysql';
				}

				$dsn = "mysql:host=".$config['database_host'].($config['database_port'] != '' ? ";port=".$config['database_port'] : '').";dbname=".$config['database_database'].($config['database_charset'] != '' ? ";charset=".$config['database_charset'] : '');
				break;
			/* case 'pgsql':
				$dsn = $config['database_driver'].":dbname=".$config['database_database'].";host=".$config['database_host'].($config['database_port'] != "" ? ";port=".$config['database_port'] : "");
				break; */
		}

		echo "         <ul>\n";

		require_once('setup/database-install-pdo.php');

		echo "         </ul>\n";
		echo "         <br />\n";

		if(!$fatal_error)
		{
			if (isset($config['DeleteTables']) && $config['DeleteTables'] == 'on')
			{
				echo "<h2>".$lang['DeletingTables']."</h2>\n";
				echo "            <ol>\n";

				foreach ($delete_table as $value)
				{
					test_pdo(str_replace('%1', $value[0], $lang['DeletingTable']), $value[1], str_replace('%1', $value[0], $lang['ErrorDeletingTable']));
				}

				echo "            <li>".$lang['DeletingTablesEnd']."</li>\n";
				echo "         </ol>\n";
				echo "         <br />\n";

				$version = 0;
			}

			switch ($version)
			{
				// new installation
				case '0':
					echo "         <h2>".$lang['InstallingTables']."</h2>\n";
					echo "         <ol>\n";

					foreach ($create_table as $value)
					{
						test_pdo(str_replace('%1', $value[0], $lang['CreatingTable']), $value[1], str_replace('%1', $value[0], $lang['ErrorCreatingTable']));
					}

					foreach ($insert_records as $param => $value)
					{
						test_pdo($value[0], $value[1], str_replace('%1', $value[2], $lang['ErrorAlreadyExists']));
					}

					echo "         </ol>\n";
					echo "         <br />\n";
					echo "         <h2>".$lang['InstallingDefaultData']."</h2>\n";
					echo "         <ul>\n";
					echo "            <li>".$lang['InstallingPagesBegin'];
					require_once('setup/inserts.php');
					echo "</li>\n";
					echo "            <li>".$lang['InstallingPagesEnd']."</li>\n";

					test_pdo($lang['InstallingLogoImage'], $insert_logo_image, str_replace('%1', 'logo image', $lang['ErrorAlreadyExists']));
					test_pdo($lang['InstallingConfigValues'], $insert_config, str_replace('%1', 'config values', $lang['ErrorAlreadyExists']));
					echo "         </ul>\n";

					break;

					/*
					 The funny upgrading stuff. Make sure these are in order!
					 And yes, there are no (switch) breaks here. This is on purpose.
					 */

				// upgrade from R5.0.0 to R5.1.x
				case '5.0.0':
					echo "         <h2>Wacko 5.0.0 ".$lang['To']." ".WACKO_VERSION."</h2>\n";
					echo "         <ol>\n";

					foreach ($upgrade_5_0_0 as $param => $value)
					{
						test_pdo(str_replace('%1', $value[1], $value[0]), $value[2], str_replace('%1', $value[1], $value[3]));
					}

					echo "            </ol>\n";

				// upgrade from R5.1.0 to R5.4.x
				case '5.1.0':
					echo "         <h2>Wacko 5.1.0 ".$lang['To']." ".WACKO_VERSION."</h2>\n";
					echo "         <ol>\n";

					foreach ($upgrade_5_1_0 as $param => $value)
					{
						test_pdo(str_replace('%1', $value[1], $value[0]), $value[2], str_replace('%1', $value[1], $value[3]));
					}

					echo "            </ol>\n";

				// upgrade from R5.4.0 to R5.5.x
				case '5.4.0':
					echo "         <h2>Wacko 5.4.0 ".$lang['To']." ".WACKO_VERSION."</h2>\n";
					echo "         <ol>\n";

					foreach ($upgrade_5_4_0 as $param => $value)
					{
						test_pdo(str_replace('%1', $value[1], $value[0]), $value[2], str_replace('%1', $value[1], $value[3]));
					}

				// inserting config values
				test_pdo($lang['InstallingConfigValues'], $insert_config, str_replace('%1', 'config values', $lang['ErrorAlreadyExists']));

				echo "            </ol>\n";
				echo "         <br />\n";
				echo "         <h2>".$lang['InstallingDefaultData']."</h2>\n";
				echo "         <ul>\n";
				echo "            <li>".$lang['InstallingPagesBegin'];
				require_once('setup/inserts.php');
				echo "</li>\n";
				echo "            <li>".$lang['InstallingPagesEnd']."</li>\n";
			}

			echo "         </ul>\n";
		}

		break;
}

if(!$fatal_error)
{
?>
<p><?php echo $lang['NextStep'];?></p>
<form action="<?php echo my_location(); ?>?installAction=write-config" method="post">
<?php
	write_config_hidden_nodes(array('DeleteTables' => ''));
?>
	<input type="submit" value="<?php echo $lang['Continue'];?>" class="next" />
</form>
<?php
}
else
{
?>
<input type="submit" value="<?php echo $lang['Back'];?>" class="next" onclick="javascript: history.go(-1);" />
<input type="button" value="<?php echo $lang['TryAgain'];?>" class="next" onClick="window.location.reload( true );" />
<?php
}
?>