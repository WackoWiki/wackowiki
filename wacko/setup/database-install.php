<?php
@set_time_limit(0);
@ignore_user_abort(true);

function test($text, $condition, $errorText = '')
{
	global $lang;
	print("            <li>".$text."   ".output_image($condition));

	if(!$condition)
	{
		if($errorText)
		{
			print("<ul class=\"install_error\"><li>".$errorText."</li></ul>");
		}

		print("</li>\n");
		return false;
	}

	print("</li>\n");
	return true;
}

function output_error($errorText = '')
{
	print("<ul class=\"install_error\"><li>".$errorText."</li></ul>");
}

function random_seed($length, $seed_complexity)
{
	$chars_uc = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$chars_lc = 'abcdefghijklmnopqrstuvwxyz';
	$digits = '0123456789';
	$symbols = '-_!@#%^&*(){}[]|~'; // removed '$'
	$uc = 0;
	$lc = 0;
	$di = 0;
	$sy = 0;

	if ($seed_complexity == 2) $sy = 100;

	while ($uc == 0 || $lc == 0 || $di == 0 || $sy == 0)
	{
		$seed = '';
		for ($i = 0; $i < $length; $i++)
		{
			$k = rand(0, $seed_complexity);  //randomly choose what's next
			if ($k == 0)
			{
				//uppercase
				$seed .= substr(str_shuffle($chars_uc), rand(0, sizeof($chars_uc) - 2), 1);
				$uc++;
			}
			if ($k == 1)
			{
				//lowercase
				$seed .= substr(str_shuffle($chars_lc), rand(0, sizeof($chars_lc) - 2), 1);
				$lc++;
			}
			if ($k == 2)
			{
				//digits
				$seed .= substr(str_shuffle($digits), rand(0, sizeof($digits) - 2), 1);
				$di++;
			}
			if ($k == 3)
			{
				//symbols
				$seed .= substr(str_shuffle($symbols), rand(0, sizeof($symbols) - 2), 1);
				$sy++;
			}
		}
	}

	return $seed;
}

// test configuration
print("         <h2>".$lang['TestingConfiguration']."</h2>\n");

// Generic Default Inserts
if ($config['system_seed'] == '')
	$config['system_seed'] = random_seed(20, 3);

$salt = random_seed(10, 3);
$password_encrypted = hash('sha256', $config['admin_name'].$salt.$_POST['password']);

$config_insert = '';

// system holds all default pages
$insert_system = "INSERT INTO ".$config['table_prefix']."user (user_name, password, salt, email, account_type, signup_time) VALUES ('System', '', '', '', '1', '')";
$insert_admin = "INSERT INTO ".$config['table_prefix']."user (user_name, password, salt, email, signup_time) VALUES ('".$config['admin_name']."', '".$password_encrypted."', '".$salt."', '".$config['admin_email']."', NOW())";
$insert_admin_setting = "INSERT INTO ".$config['table_prefix']."user_setting (user_id, theme, lang) VALUES ((SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), '".$config['theme']."', '".$config['language']."')";
// TODO: for Upgrade insert other aliases also in group table
// $config['aliases'] = array('Admins' => $config['admin_name']);


$insert_admin_group = "INSERT INTO ".$config['table_prefix']."group (group_name, description, moderator, created) VALUES ('Admins', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), NOW())";
$insert_admin_group_member = "INSERT INTO ".$config['table_prefix']."group_member (group_id, user_id) VALUES ((SELECT group_id FROM ".$config['table_prefix']."group WHERE group_name = 'Admins' LIMIT 1), (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1))";

$insert_everybody_group = "INSERT INTO ".$config['table_prefix']."group (group_name, description, moderator, created) VALUES ('Everybody', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), NOW())";
$insert_registered_group = "INSERT INTO ".$config['table_prefix']."group (group_name, description, moderator, created) VALUES ('Registered', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), NOW())";
$insert_moderator_group = "INSERT INTO ".$config['table_prefix']."group (group_name, description, moderator, created) VALUES ('Moderator', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), NOW())";
$insert_reviewer_group = "INSERT INTO ".$config['table_prefix']."group (group_name, description, moderator, created) VALUES ('Reviewer', '', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1), NOW())";

$insert_logo_image = "INSERT INTO ".$config['table_prefix']."upload (page_id, user_id, file_name, description, uploaded_dt, file_size, picture_w, picture_h, file_ext) VALUES ('0', (SELECT user_id FROM ".$config['table_prefix']."user WHERE user_name = '".$config['admin_name']."' LIMIT 1),'wacko4.png', 'WackoWiki', NOW(), '1580', '108', '50', 'png')";

// inserting config values
$config_db['abuse_email'] = $config['admin_email'];
$config_db['admin_email'] = $config['admin_email'];
$config_db['admin_name'] = $config['admin_name'];
$config_db['allow_rawhtml'] = $config['allow_rawhtml'];
$config_db['allow_registration'] = $config['allow_registration'];
$config_db['allow_swfobject'] = $config['allow_swfobject'];
$config_db['allow_themes'] = $config['allow_themes'];
$config_db['allow_themes_per_page'] = $config['allow_themes_per_page'];
$config_db['allow_x11colors'] = $config['allow_x11colors'];
$config_db['antidupe'] = $config['antidupe'];
$config_db['cache'] = $config['cache'];
$config_db['cache_sql'] = $config['cache_sql'];
$config_db['cache_sql_ttl'] = $config['cache_sql_ttl'];
$config_db['cache_ttl'] = $config['cache_ttl'];
$config_db['captcha_edit_page'] = $config['captcha_edit_page'];
$config_db['captcha_new_comment'] = $config['captcha_new_comment'];
$config_db['captcha_new_page'] = $config['captcha_new_page'];
$config_db['captcha_registration'] = $config['captcha_registration'];
$config_db['comments_count'] = $config['comments_count'];
$config_db['comment_delay'] = $config['comment_delay'];
$config_db['cookie_prefix'] = $config['cookie_prefix'];
$config_db['session_expiration'] = $config['session_expiration'];
$config_db['date_format'] = $config['date_format'];
$config_db['date_macro_format'] = $config['date_macro_format'];
$config_db['date_precise_format'] = $config['date_precise_format'];
$config_db['debug'] = $config['debug'];
$config_db['debug_admin_only'] = $config['debug_admin_only'];
$config_db['debug_sql_threshold'] = $config['debug_sql_threshold'];
$config_db['default_comment_acl'] = $config['default_comment_acl'];
$config_db['default_create_acl'] = $config['default_create_acl'];
$config_db['default_read_acl'] = $config['default_read_acl'];
$config_db['default_rename_redirect'] = $config['default_rename_redirect'];
$config_db['default_typografica'] = $config['default_typografica'];
$config_db['default_upload_acl'] = $config['default_read_acl'];
$config_db['default_write_acl'] = $config['default_write_acl'];
$config_db['disable_autosubscribe'] = $config['disable_autosubscribe'];
$config_db['disable_bracketslinks'] = $config['disable_bracketslinks'];
$config_db['disable_formatters'] = $config['disable_formatters'];
$config_db['disable_npjlinks'] = $config['disable_npjlinks'];
$config_db['disable_safehtml'] = $config['disable_safehtml'];
$config_db['disable_tikilinks'] = $config['disable_tikilinks'];
$config_db['disable_wikilinks'] = $config['disable_wikilinks'];
$config_db['edit_summary'] = $config['edit_summary'];
$config_db['email_priority'] = $config['email_priority'];
$config_db['footer_comments'] = $config['footer_comments'];
$config_db['footer_files'] = $config['footer_files'];
$config_db['forum_cluster'] = $config['forum_cluster'];
$config_db['forum_topics'] = $config['forum_topics'];
$config_db['hide_comments'] = $config['hide_comments'];
$config_db['hide_files'] = $config['hide_files'];
$config_db['hide_index'] = $config['hide_index'];
$config_db['hide_locked'] = $config['hide_locked'];
$config_db['hide_rating'] = $config['hide_rating'];
$config_db['hide_revisions'] = $config['hide_revisions'];
$config_db['hide_toc'] = $config['hide_toc'];
$config_db['keep_deleted_time'] = $config['keep_deleted_time'];
$config_db['language'] = $config['language'];
$config_db['license'] = $config['license'];
$config_db['log_default_show'] = $config['log_default_show'];
$config_db['log_level'] = $config['log_level'];
$config_db['log_purge_time'] = $config['log_purge_time'];
$config_db['meta_description'] = $config['meta_description'];
$config_db['meta_keywords'] = $config['meta_keywords'];
$config_db['minor_edit'] = $config['minor_edit'];
$config_db['multilanguage'] = $config['multilanguage'];
$config_db['name_date_macro'] = $config['name_date_macro'];
$config_db['news_cluster'] = $config['news_cluster'];
$config_db['news_levels'] = $config['news_levels'];
$config_db['noindex'] = $config['noindex'];
$config_db['numerate_links'] = $config['numerate_links'];
$config_db['outlook_workaround'] = $config['outlook_workaround'];
$config_db['owners_can_change_categories'] = $config['owners_can_change_categories'];
$config_db['owners_can_remove_comments'] = $config['owners_can_remove_comments'];
$config_db['pages_purge_time'] = $config['pages_purge_time'];
$config_db['paragrafica'] = $config['paragrafica'];
$config_db['permalink_page'] = $config['permalink_page'];
$config_db['phpmailer'] = $config['phpmailer'];
$config_db['phpmailer_method'] = $config['phpmailer_method'];
$config_db['policy_page'] = $config['policy_page'];
$config_db['pwd_char_classes'] = $config['pwd_char_classes'];
$config_db['pwd_min_chars'] = $config['pwd_min_chars'];
$config_db['pwd_unlike_login'] = $config['pwd_unlike_login'];
$config_db['referrers_purge_time'] = $config['referrers_purge_time'];
$config_db['remove_onlyadmins'] = $config['remove_onlyadmins'];
$config_db['rename_globalacl'] = $config['rename_globalacl'];
$config_db['review'] = $config['review'];
$config_db['revisions_hide_cancel'] = $config['revisions_hide_cancel'];
$config_db['rewrite_mode'] = $config['rewrite_mode'];
$config_db['root_page'] = $config['root_page'];
$config_db['session_match_ip'] = $config['session_match_ip'];
$config_db['session_match_useragent'] = $config['session_match_useragent'];
$config_db['session_prefix'] = $config['session_prefix'];
$config_db['session_time_to_update'] = $config['session_time_to_update'];
$config_db['session_use_db'] = $config['session_use_db'];
$config_db['smtp_connection_mode'] = $config['smtp_connection_mode'];
$config_db['smtp_host'] = $config['smtp_host'];
$config_db['smtp_password'] = $config['smtp_password'];
$config_db['smtp_port'] = $config['smtp_port'];
$config_db['smtp_username'] = $config['smtp_username'];
$config_db['show_spaces'] = $config['show_spaces'];
$config_db['spam_filter'] = $config['spam_filter'];
$config_db['tls'] = $config['tls'];
$config_db['tls_implicit'] = $config['tls_implicit'];
$config_db['tls_proxy'] = $config['tls_proxy'];
$config_db['standard_handlers'] = $config['standard_handlers'];
$config_db['store_deleted_pages'] = $config['store_deleted_pages'];
$config_db['session_encrypt_cookie'] = $config['session_encrypt_cookie'];
$config_db['theme'] = $config['theme'];
$config_db['time_format'] = $config['time_format'];
$config_db['time_format_seconds'] = $config['time_format_seconds'];
$config_db['tree_level'] = $config['tree_level'];
$config_db['upload'] = $config['upload'];
$config_db['upload_banned_exts'] = $config['upload_banned_exts'];
$config_db['upload_images_only'] = $config['upload_images_only'];
$config_db['upload_quota_per_user'] = $config['upload_quota_per_user'];
$config_db['upload_max_size'] = $config['upload_max_size'];
$config_db['urls_underscores'] = $config['urls_underscores'];
$config_db['users_page'] = $config['users_page'];
$config_db['wacko_desc'] = $config['wacko_desc'];
$config_db['wacko_name'] = $config['wacko_name'];
$config_db['xml_sitemap'] = $config['xml_sitemap'];
$config_db['youarehere_text'] = $config['youarehere_text'];
#$config_db[''] = $config[''];

foreach($config_db as $key => $value)
{
	$config_insert .= "(0, '$key', '$value'),";
}

$insert_config = "INSERT INTO ".$config['table_prefix']."config (config_id, config_name, value) VALUES
	".$config_insert."
	(0, 'maint_last_cache', NULL),
	(0, 'maint_last_log', NULL),
	(0, 'maint_last_refs', NULL),
	(0, 'maint_last_delpages', NULL),
	(0, 'maint_last_oldpages', NULL);";

/*
 Setup the tables depending on which database we selected

 mysql_legacy
 mysqli_legacy
 or pdo which is the default clause
 */
$port = trim($config['database_port']);

$fatal_error = false;

switch($config['database_driver'])
{
	case 'mysql_legacy':
		require_once('setup/database_mysql.php');
		require_once('setup/database_mysql_updates.php');

		print("         <ul>\n");

		if(!test($lang['TestConnectionString'], $dblink = @mysql_connect($config['database_host'].($port == '' ? '' : ':'.$port), $config['database_user'], $config['database_password']), $lang['ErrorDBConnection']))
		{
			/*
			 There was a problem with the connection string
			 */

			print("         </ul>\n");
			print("         <br />\n");

			$fatal_error = true;
		}
		else if(!test($lang['TestDatabaseExists'], @mysql_select_db($config['database_database'], $dblink), $lang['ErrorDBExists']))
		{
			/*
			 There was a problem with the specified database name
			 */

			print("         </ul>\n");
			print("         <br />\n");

			$fatal_error = true;
		}
		else
		{
			/*
			 The connection string and the database name are ok, proceed
			 */
			print("         </ul>\n");
			print("         <br />\n");

			if ( !isset ( $config['wacko_version'] ) ) $config['wacko_version'] = '';
			if (!$version = trim($config['wacko_version'])) $version = '0';
			if ( isset ( $config['wacko_version'] ) )
			if ( trim ( $config['wacko_version'] ) ) $version = trim($config['wacko_version']);

			if ($config['DeleteTables'] == 'on')
			{
					print("<h2>".$lang['DeletingTables']."</h2>\n");
					print("            <ul>\n");
					test(str_replace('%1', 'acl', $lang['DeletingTable']), @mysql_query($table_acl_drop, $dblink), str_replace('%1', 'acl', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'bookmark', $lang['DeletingTable']), @mysql_query($table_bookmark_drop, $dblink), str_replace('%1', 'bookmark', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'cache', $lang['DeletingTable']), @mysql_query($table_cache_drop, $dblink), str_replace('%1', 'cache', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'config', $lang['DeletingTable']), @mysql_query($table_config_drop, $dblink), str_replace('%1', 'config', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'group', $lang['DeletingTable']), @mysql_query($table_group_drop, $dblink), str_replace('%1', 'group', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'group_member', $lang['DeletingTable']), @mysql_query($table_group_member_drop, $dblink), str_replace('%1', 'group_member', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'category', $lang['DeletingTable']), @mysql_query($table_category_drop, $dblink), str_replace('%1', 'category', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'category_page', $lang['DeletingTable']), @mysql_query($table_category_page_drop, $dblink), str_replace('%1', 'category_page', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'link', $lang['DeletingTable']), @mysql_query($table_link_drop, $dblink), str_replace('%1', 'link', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'log', $lang['DeletingTable']), @mysql_query($table_log_drop, $dblink), str_replace('%1', 'log', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'page', $lang['DeletingTable']), @mysql_query($table_page_drop, $dblink), str_replace('%1', 'page', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'poll', $lang['DeletingTable']), @mysql_query($table_poll_drop, $dblink), str_replace('%1', 'poll', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'rating', $lang['DeletingTable']), @mysql_query($table_rating_drop, $dblink), str_replace('%1', 'rating', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'referrer', $lang['DeletingTable']), @mysql_query($table_referrer_drop, $dblink), str_replace('%1', 'referrer', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'revision', $lang['DeletingTable']), @mysql_query($table_revision_drop, $dblink), str_replace('%1', 'revision', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'upload', $lang['DeletingTable']), @mysql_query($table_upload_drop, $dblink), str_replace('%1', 'upload', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'user', $lang['DeletingTable']), @mysql_query($table_user_drop, $dblink), str_replace('%1', 'user', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'user_setting', $lang['DeletingTable']), @mysql_query($table_user_setting_drop, $dblink), str_replace('%1', 'user_setting', $lang['ErrorDeletingTable']));
					test(str_replace('%1', 'watch', $lang['DeletingTable']), @mysql_query($table_watch_drop, $dblink), str_replace('%1', 'watch', $lang['ErrorDeletingTable']));
					print("            <li>".$lang['DeletingTablesEnd']."</li>\n");
					print("         </ul>\n");
					print("         <br />\n");
					$version = 0;
			}

			switch ($version)
			{
				// new installation
				case '0':
					print("<h2>".$lang['InstallingTables']."</h2>\n");
					print("            <ul>\n");
					test(str_replace('%1', 'acl', $lang['CreatingTable']), @mysql_query($table_acl, $dblink), str_replace('%1', 'acl', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'bookmark', $lang['CreatingTable']), @mysql_query($table_bookmark, $dblink), str_replace('%1', 'bookmark', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'cache', $lang['CreatingTable']), @mysql_query($table_cache, $dblink), str_replace('%1', 'cache', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'config', $lang['CreatingTable']), @mysql_query($table_config, $dblink), str_replace('%1', 'config', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'group', $lang['CreatingTable']), @mysql_query($table_group, $dblink), str_replace('%1', 'group', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'group_member', $lang['CreatingTable']), @mysql_query($table_group_member, $dblink), str_replace('%1', 'group_member', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'category', $lang['CreatingTable']), @mysql_query($table_category, $dblink), str_replace('%1', 'category', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'category_page', $lang['CreatingTable']), @mysql_query($table_category_page, $dblink), str_replace('%1', 'category_page', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'link', $lang['CreatingTable']), @mysql_query($table_link, $dblink), str_replace('%1', 'link', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'log', $lang['CreatingTable']), @mysql_query($table_log, $dblink), str_replace('%1', 'log', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'page', $lang['CreatingTable']), @mysql_query($table_page, $dblink), str_replace('%1', 'page', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'poll', $lang['CreatingTable']), @mysql_query($table_poll, $dblink), str_replace('%1', 'poll', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'rating', $lang['CreatingTable']), @mysql_query($table_rating, $dblink), str_replace('%1', 'rating', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'referrer', $lang['CreatingTable']), @mysql_query($table_referrer, $dblink), str_replace('%1', 'referrer', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'revision', $lang['CreatingTable']), @mysql_query($table_revision, $dblink), str_replace('%1', 'revision', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'upload', $lang['CreatingTable']), @mysql_query($table_upload, $dblink), str_replace('%1', 'upload', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'user', $lang['CreatingTable']), @mysql_query($table_user, $dblink), str_replace('%1', 'user', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'user_setting', $lang['CreatingTable']), @mysql_query($table_user_setting, $dblink), str_replace('%1', 'user_setting', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'watch', $lang['CreatingTable']), @mysql_query($table_watch, $dblink), str_replace('%1', 'watch', $lang['ErrorCreatingTable']));

					test($lang['InstallingSystemAccount'], @mysql_query($insert_system, $dblink), str_replace('%1', 'system account', $lang['ErrorAlreadyExists']));
					test($lang['InstallingAdmin'], @mysql_query($insert_admin, $dblink), str_replace('%1', 'admin user', $lang['ErrorAlreadyExists']));
					test($lang['InstallingAdminSetting'], @mysql_query($insert_admin_setting, $dblink), str_replace('%1', 'admin user settings', $lang['ErrorAlreadyExists']));
					test($lang['InstallingAdminGroup'], @mysql_query($insert_admin_group, $dblink), str_replace('%1', 'admin group', $lang['ErrorAlreadyExists']));
					test($lang['InstallingAdminGroupMember'], @mysql_query($insert_admin_group_member, $dblink), str_replace('%1', 'admin group member', $lang['ErrorAlreadyExists']));

					test($lang['InstallingEverybodyGroup'], @mysql_query($insert_everybody_group, $dblink), str_replace('%1', 'everybody group', $lang['ErrorAlreadyExists']));
					test($lang['InstallingRegisteredGroup'], @mysql_query($insert_registered_group, $dblink), str_replace('%1', 'registered group', $lang['ErrorAlreadyExists']));
					test($lang['InstallingModeratorGroup'], @mysql_query($insert_moderator_group, $dblink), str_replace('%1', 'moderator group', $lang['ErrorAlreadyExists']));
					test($lang['InstallingReviewerGroup'], @mysql_query($insert_reviewer_group, $dblink), str_replace('%1', 'reviewer group', $lang['ErrorAlreadyExists']));
					print("            </ul>\n");
					print("            <br />\n");
					print("            <h2>".$lang['InstallingDefaultData']."</h2>\n");
					print("            <ul>\n");
					print("               <li>".$lang['InstallingPagesBegin']);
					require_once('setup/inserts.php');
					print("</li>\n");
					print("            <li>".$lang['InstallingPagesEnd']."</li>\n");

					test($lang['InstallingLogoImage'], @mysql_query($insert_logo_image, $dblink), str_replace('%1', 'logo image', $lang['ErrorAlreadyExists']));
					test($lang['InstallingConfigValues'], @mysql_query($insert_config, $dblink), str_replace('%1', 'config values', $lang['ErrorAlreadyExists']));

					break;

					/*
					 The funny upgrading stuff. Make sure these are in order!
					 And yes, there are no (switch) breaks here. This is on purpose.
					 */

				// upgrade from R4.2 to R4.3.rc1
				case 'R4.2':
					print("         <h2>Wacko R4.2 ".$lang['To']." R4.3.rc1</h2>\n");
					print("         <ul>\n");

					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_2_1, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_2_2, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_2_1, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_2_2, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));

					test($lang['InstallingLogoImage'], @mysql_query($insert_logo_image, $dblink), str_replace('%1',"logo image",$lang['ErrorAlreadyExists']));

				// upgrade from R4.3.rc1 to R4.4.rc1
				case 'R4.3':
					print("         <h2>Wacko R4.3.rc1 ".$lang['To']." R4.4.rc1</h2>\n");
					print("         <ul>\n");

					// rename tables
					test(str_replace('%1', 'acl', $lang['RenameTable']), @mysql_query($rename_acl_r4_3_1, $dblink), str_replace('%1', 'acl', $lang['ErrorRenamingTable']));
					test(str_replace('%1', 'link', $lang['RenameTable']), @mysql_query($rename_link_r4_3_1, $dblink), str_replace('%1', 'link', $lang['ErrorRenamingTable']));
					test(str_replace('%1', 'page', $lang['RenameTable']), @mysql_query($rename_page_r4_2_1, $dblink), str_replace('%1', 'page', $lang['ErrorRenamingTable']));
					test(str_replace('%1', 'referrer', $lang['RenameTable']), @mysql_query($rename_referrer_r4_3_1, $dblink), str_replace('%1', 'referrer', $lang['ErrorRenamingTable']));
					test(str_replace('%1', 'revision', $lang['RenameTable']), @mysql_query($rename_revision_r4_2_1, $dblink), str_replace('%1', 'revision', $lang['ErrorRenamingTable']));
					test(str_replace('%1', 'user', $lang['RenameTable']), @mysql_query($rename_user_r4_3_1, $dblink), str_replace('%1', 'user', $lang['ErrorRenamingTable']));
					test(str_replace('%1', 'watch', $lang['RenameTable']), @mysql_query($rename_watch_r4_3_1, $dblink), str_replace('%1', 'watch', $lang['ErrorRenamingTable']));

					// ! new user_id first
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_1, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_2, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_3, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_4, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_5, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_6, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_7, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_8, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_9, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_10, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_11, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_12, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_13, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_14, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'user', $lang['UpdateTable']), @mysql_query($update_user_r4_3, $dblink), str_replace('%1', 'user', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'user', $lang['UpdateTable']), @mysql_query($update_user_r4_3_1, $dblink), str_replace('%1', 'user', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'user', $lang['UpdateTable']), @mysql_query($update_user_r4_3_2, $dblink), str_replace('%1', 'user', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'user', $lang['UpdateTable']), @mysql_query($update_user_r4_3_4, $dblink), str_replace('%1', 'user', $lang['ErrorUpdatingTable']));

					// rename id after upate!
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_15, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_16, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_17, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_18, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_19, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_20, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_21, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_22, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_23, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_24, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'user', $lang['AlterTable']), @mysql_query($alter_user_r4_3_25, $dblink), str_replace('%1', 'user', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'acl', $lang['AlterTable']), @mysql_query($alter_acl_r4_3_1, $dblink), str_replace('%1', 'acl', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'acl', $lang['AlterTable']), @mysql_query($alter_acl_r4_3_2, $dblink), str_replace('%1', 'acl', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'acl', $lang['UpdateTable']), @mysql_query($update_acl_r4_3, $dblink), str_replace('%1', 'acl', $lang['ErrorUpdatingTable']));

					// Drop obsolete fields
					test(str_replace('%1', 'acl', $lang['AlterTable']), @mysql_query($alter_acl_r4_3_3, $dblink), str_replace('%1', 'acl', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'acl', $lang['AlterTable']), @mysql_query($alter_acl_r4_3_4, $dblink), str_replace('%1', 'acl', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'acl', $lang['AlterTable']), @mysql_query($alter_acl_r4_3_5, $dblink), str_replace('%1', 'acl', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'acl', $lang['AlterTable']), @mysql_query($alter_acl_r4_3_6, $dblink), str_replace('%1', 'acl', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'bookmark', $lang['CreatingTable']), @mysql_query($table_bookmark_r4_3, $dblink), str_replace('%1', 'bookmark', $lang['ErrorCreatingTable']));

					test(str_replace('%1', 'cache', $lang['AlterTable']), @mysql_query($alter_cache_r4_3, $dblink), str_replace('%1', 'cache', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'cache', $lang['AlterTable']), @mysql_query($alter_cache_r4_3_1, $dblink), str_replace('%1', 'cache', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'config', $lang['CreatingTable']), @mysql_query($table_config_r4_3, $dblink), str_replace('%1', 'config', $lang['ErrorCreatingTable']));

					test(str_replace('%1', 'group', $lang['CreatingTable']), @mysql_query($table_group_r4_3, $dblink), str_replace('%1', 'group', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'group_member', $lang['CreatingTable']), @mysql_query($table_group_member_r4_3, $dblink), str_replace('%1', 'group_member', $lang['ErrorCreatingTable']));

					test(str_replace('%1', 'category', $lang['CreatingTable']), @mysql_query($table_category_r4_3, $dblink), str_replace('%1', 'category', $lang['ErrorCreatingTable']));
					test(str_replace('%1', 'category_page', $lang['CreatingTable']), @mysql_query($table_category_page_r4_3, $dblink), str_replace('%1', 'category_page', $lang['ErrorCreatingTable']));

					test(str_replace('%1', 'link', $lang['AlterTable']), @mysql_query($alter_link_r4_3_1, $dblink), str_replace('%1', 'link', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'link', $lang['AlterTable']), @mysql_query($alter_link_r4_3_2, $dblink), str_replace('%1', 'link', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'link', $lang['AlterTable']), @mysql_query($alter_link_r4_3_3, $dblink), str_replace('%1', 'link', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'link', $lang['UpdateTable']), @mysql_query($update_link_r4_3, $dblink), str_replace('%1', 'link', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'link', $lang['UpdateTable']), @mysql_query($update_link_r4_3_1, $dblink), str_replace('%1', 'link', $lang['ErrorUpdatingTable']));

					// drop last!
					test(str_replace('%1', 'link', $lang['AlterTable']), @mysql_query($alter_link_r4_3_4, $dblink), str_replace('%1', 'link', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'link', $lang['AlterTable']), @mysql_query($alter_link_r4_3_5, $dblink), str_replace('%1', 'link', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'link', $lang['AlterTable']), @mysql_query($alter_link_r4_3_6, $dblink), str_replace('%1', 'link', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'log', $lang['CreatingTable']), @mysql_query($table_log_r4_3, $dblink), str_replace('%1', 'log', $lang['ErrorCreatingTable']));

					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_3, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_4, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_5, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_6, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_7, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_8, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_9, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_10, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_11, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'page', $lang['UpdateTable']), @mysql_query($update_page_r4_3, $dblink), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'page', $lang['UpdateTable']), @mysql_query($update_page_r4_3_1, $dblink), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'page', $lang['UpdateTable']), @mysql_query($update_page_r4_3_2, $dblink), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'page', $lang['UpdateTable']), @mysql_query($update_page_r4_3_3, $dblink), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'page', $lang['UpdateTable']), @mysql_query($update_page_r4_3_4, $dblink), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'page', $lang['UpdateTable']), @mysql_query($update_page_r4_3_5, $dblink), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'page', $lang['UpdateTable']), @mysql_query($update_page_r4_3_6, $dblink), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'page', $lang['UpdateTable']), @mysql_query($update_page_r4_3_7, $dblink), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));

					// drop last!
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_12, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_13, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_14, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_15, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_16, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_17, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_18, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_19, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_20, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_21, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_22, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_23, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_24, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_25, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_26, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_27, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_28, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_29, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_30, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_31, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_32, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_33, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_34, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'page', $lang['AlterTable']), @mysql_query($alter_page_r4_3_35, $dblink), str_replace('%1', 'page', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'page', $lang['UpdateTable']), @mysql_query($update_page_r4_3_8, $dblink), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'page', $lang['UpdateTable']), @mysql_query($update_page_r4_3_9, $dblink), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'page', $lang['UpdateTable']), @mysql_query($update_page_r4_3_10, $dblink), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));

					test(str_replace('%1', 'poll', $lang['CreatingTable']), @mysql_query($table_poll_r4_3, $dblink), str_replace('%1', 'poll', $lang['ErrorCreatingTable']));

					test(str_replace('%1', 'watch', $lang['AlterTable']), @mysql_query($alter_watch_r4_3_1, $dblink), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'watch', $lang['AlterTable']), @mysql_query($alter_watch_r4_3_2, $dblink), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'watch', $lang['AlterTable']), @mysql_query($alter_watch_r4_3_3, $dblink), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'watch', $lang['UpdateTable']), @mysql_query($update_watch_r4_3, $dblink), str_replace('%1', 'watch', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'watch', $lang['UpdateTable']), @mysql_query($update_watch_r4_3_1, $dblink), str_replace('%1', 'watch', $lang['ErrorUpdatingTable']));

					// drop last!
					test(str_replace('%1', 'watch', $lang['AlterTable']), @mysql_query($alter_watch_r4_3_4, $dblink), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'watch', $lang['AlterTable']), @mysql_query($alter_watch_r4_3_5, $dblink), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'watch', $lang['AlterTable']), @mysql_query($alter_watch_r4_3_6, $dblink), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'watch', $lang['AlterTable']), @mysql_query($alter_watch_r4_3_7, $dblink), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'rating', $lang['CreatingTable']), @mysql_query($table_rating_r4_3, $dblink), str_replace('%1', 'rating', $lang['ErrorCreatingTable']));

					test(str_replace('%1', 'referrer', $lang['AlterTable']), @mysql_query($alter_referrer_r4_3_1, $dblink), str_replace('%1', 'referrer', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'referrer', $lang['AlterTable']), @mysql_query($alter_referrer_r4_3_2, $dblink), str_replace('%1', 'referrer', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_3, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_4, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_5, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_6, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_7, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_8, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_9, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_10, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_13, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'revision', $lang['UpdateTable']), @mysql_query($update_revision_r4_3, $dblink), str_replace('%1', 'revision', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'revision', $lang['UpdateTable']), @mysql_query($update_revision_r4_3_1, $dblink), str_replace('%1', 'revision', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'revision', $lang['UpdateTable']), @mysql_query($update_revision_r4_3_2, $dblink), str_replace('%1', 'revision', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'revision', $lang['UpdateTable']), @mysql_query($update_revision_r4_3_3, $dblink), str_replace('%1', 'revision', $lang['ErrorUpdatingTable']));
					test(str_replace('%1', 'revision', $lang['UpdateTable']), @mysql_query($update_revision_r4_3_4, $dblink), str_replace('%1', 'revision', $lang['ErrorUpdatingTable']));

					// drop last!
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_11, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_12, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_14, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_15, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_16, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_17, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_18, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_19, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_20, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_21, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_22, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'revision', $lang['AlterTable']), @mysql_query($alter_revision_r4_3_23, $dblink), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'revision', $lang['UpdateTable']), @mysql_query($update_revision_r4_3_5, $dblink), str_replace('%1', 'revision', $lang['ErrorUpdatingTable']));

					test(str_replace('%1', 'upload', $lang['AlterTable']), @mysql_query($alter_upload_r4_3, $dblink), str_replace('%1', 'upload', $lang['ErrorAlteringTable']));

					test(str_replace('%1', 'upload', $lang['UpdateTable']), @mysql_query($update_upload_r4_3, $dblink), str_replace('%1', 'upload', $lang['ErrorUpdatingTable']));

					// drop last!
					test(str_replace('%1', 'upload', $lang['AlterTable']), @mysql_query($alter_upload_r4_3_1, $dblink), str_replace('%1', 'upload', $lang['ErrorAlteringTable']));
					test(str_replace('%1', 'upload', $lang['AlterTable']), @mysql_query($alter_upload_r4_3_2, $dblink), str_replace('%1', 'upload', $lang['ErrorAlteringTable']));

					// inserting config values
					test($lang['InstallingConfigValues'], @mysql_query($insert_config, $dblink), str_replace('%1', 'config values', $lang['ErrorAlreadyExists']));
					test($lang['InstallingSystemAccount'], @mysql_query($insert_system, $dblink), str_replace('%1', 'system account', $lang['ErrorAlreadyExists']));
			}
			print("            </ul>\n");
		}
		break;
				case 'mysqli_legacy':
					require_once('setup/database_mysql.php');
					require_once('setup/database_mysql_updates.php');

					if ( !isset ( $config['database_port'] ) ) $config['database_port'] = '3306';
					if (!$port = trim($config['database_port'])) $port = '3306';

					print("         <ul>\n");

					if(!test($lang['TestConnectionString'], $dblink = @mysqli_connect($config['database_host'], $config['database_user'], $config['database_password'], null, $port), $lang['ErrorDBConnection']))
					{
						/*
						 There was a problem with the connection string
						 */

						print("         </ul>\n");
						print("         <br />\n");

						$fatal_error = true;
					}
					else if(!test($lang['TestDatabaseExists'], @mysqli_select_db($dblink, $config['database_database']), $lang['ErrorDBExists']))
					{
						/*
						 There was a problem with the specified database name
						 */

						print("         </ul>\n");
						print("         <br />\n");

						$fatal_error = true;
					}
					else
					{
						/*
						 The connection string and the database name are ok, proceed
						 */
						print("         </ul>\n");
						print("         <br />\n");


						if ( !isset( $config['wacko_version'] ) ) $config['wacko_version'] = '0';
						if (!$version = trim($config['wacko_version'])) $version = '0';
						if (trim($config['wacko_version'])) $version = trim($config['wacko_version']);

						if ($config['DeleteTables'] == 'on')
						{
							print("<h2>".$lang['DeletingTables']."</h2>\n");
							print("            <ul>\n");
							test(str_replace('%1', 'acl', $lang['DeletingTable']), @mysqli_query($dblink, $table_acl_drop), str_replace('%1', 'acl', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'bookmark', $lang['DeletingTable']), @mysqli_query($dblink, $table_bookmark_drop), str_replace('%1', 'bookmark', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'cache', $lang['DeletingTable']), @mysqli_query($dblink, $table_cache_drop), str_replace('%1', 'cache', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'config', $lang['DeletingTable']), @mysqli_query($dblink, $table_config_drop), str_replace('%1', 'config', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'group', $lang['DeletingTable']), @mysqli_query($dblink, $table_group_drop), str_replace('%1', 'group', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'group_member', $lang['DeletingTable']), @mysqli_query($dblink, $table_group_member_drop), str_replace('%1', 'group_member', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'category', $lang['DeletingTable']), @mysqli_query($dblink, $table_category_drop), str_replace('%1', 'category', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'category_page', $lang['DeletingTable']), @mysqli_query($dblink, $table_category_page_drop), str_replace('%1', 'category_page', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'link', $lang['DeletingTable']), @mysqli_query($dblink, $table_link_drop), str_replace('%1', 'link', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'log', $lang['DeletingTable']), @mysqli_query($dblink, $table_log_drop), str_replace('%1', 'log', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'page', $lang['DeletingTable']), @mysqli_query($dblink, $table_page_drop), str_replace('%1', 'page', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'poll', $lang['DeletingTable']), @mysqli_query($dblink, $table_poll_drop), str_replace('%1', 'poll', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'rating', $lang['DeletingTable']), @mysqli_query($dblink, $table_rating_drop), str_replace('%1', 'rating', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'referrer', $lang['DeletingTable']), @mysqli_query($dblink, $table_referrer_drop), str_replace('%1', 'referrer', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'revision', $lang['DeletingTable']), @mysqli_query($dblink, $table_revision_drop), str_replace('%1', 'revision', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'upload', $lang['DeletingTable']), @mysqli_query($dblink, $table_upload_drop), str_replace('%1', 'upload', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'user', $lang['DeletingTable']), @mysqli_query($dblink, $table_user_drop), str_replace('%1', 'user', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'user_setting', $lang['DeletingTable']), @mysqli_query($dblink, $table_user_setting_drop), str_replace('%1', 'user_setting', $lang['ErrorDeletingTable']));
							test(str_replace('%1', 'watch', $lang['DeletingTable']), @mysqli_query($dblink, $table_watch_drop), str_replace('%1', 'watch', $lang['ErrorDeletingTable']));
							print("            <li>".$lang['DeletingTablesEnd']."</li>\n");
							print("         </ul>\n");
							print("         <br />\n");
							$version = 0;
						}

						switch ($version)
						{
							// new installation
							case '0':
								print("         <h2>".$lang['InstallingTables']."</h2>\n");
								print("         <ul>\n");
								test(str_replace('%1', 'acl', $lang['CreatingTable']), @mysqli_query($dblink, $table_acl), str_replace('%1', 'acl', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'bookmark', $lang['CreatingTable']), @mysqli_query($dblink, $table_bookmark), str_replace('%1', 'bookmark', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'cache', $lang['CreatingTable']), @mysqli_query($dblink, $table_cache), str_replace('%1', 'cache', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'config', $lang['CreatingTable']), @mysqli_query($dblink, $table_config), str_replace('%1', 'config', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'group', $lang['CreatingTable']), @mysqli_query($dblink, $table_group), str_replace('%1', 'group', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'group_member', $lang['CreatingTable']), @mysqli_query($dblink, $table_group_member), str_replace('%1', 'group_member', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'category', $lang['CreatingTable']), @mysqli_query($dblink, $table_category), str_replace('%1', 'category', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'category_page', $lang['CreatingTable']), @mysqli_query($dblink, $table_category_page), str_replace('%1', 'category_page', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'link', $lang['CreatingTable']), @mysqli_query($dblink, $table_link), str_replace('%1', 'link', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'log', $lang['CreatingTable']), @mysqli_query($dblink, $table_log), str_replace('%1', 'log', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'page', $lang['CreatingTable']), @mysqli_query($dblink, $table_page), str_replace('%1', 'page', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'poll', $lang['CreatingTable']), @mysqli_query($dblink, $table_poll), str_replace('%1', 'poll', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'rating', $lang['CreatingTable']), @mysqli_query($dblink, $table_rating), str_replace('%1', 'rating', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'referrer', $lang['CreatingTable']), @mysqli_query($dblink, $table_referrer), str_replace('%1', 'referrer', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'revision', $lang['CreatingTable']), @mysqli_query($dblink, $table_revision), str_replace('%1', 'revision', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'upload', $lang['CreatingTable']), @mysqli_query($dblink, $table_upload), str_replace('%1', 'upload', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'user', $lang['CreatingTable']), @mysqli_query($dblink, $table_user), str_replace('%1', 'user', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'user_setting', $lang['CreatingTable']), @mysqli_query($dblink, $table_user_setting), str_replace('%1', 'user_setting', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'watch', $lang['CreatingTable']), @mysqli_query($dblink, $table_watch), str_replace('%1', 'watch', $lang['ErrorCreatingTable']));

								test($lang['InstallingSystemAccount'], @mysqli_query($dblink, $insert_system), str_replace('%1', 'system account', $lang['ErrorAlreadyExists']));
								test($lang['InstallingAdmin'], @mysqli_query($dblink, $insert_admin), str_replace('%1', 'admin user', $lang['ErrorAlreadyExists']));
								test($lang['InstallingAdminSetting'], @mysqli_query($dblink, $insert_admin_setting), str_replace('%1', 'admin user settings', $lang['ErrorAlreadyExists']));
								test($lang['InstallingAdminGroup'], @mysqli_query($dblink, $insert_admin_group), str_replace('%1', 'admin group', $lang['ErrorAlreadyExists']));
								test($lang['InstallingAdminGroupMember'], @mysqli_query($dblink, $insert_admin_group_member), str_replace('%1', 'admin group member', $lang['ErrorAlreadyExists']));

								test($lang['InstallingEverybodyGroup'], @mysqli_query($dblink, $insert_everybody_group), str_replace('%1', 'everybody group', $lang['ErrorAlreadyExists']));
								test($lang['InstallingRegisteredGroup'], @mysqli_query($dblink, $insert_registered_group), str_replace('%1', 'registered group', $lang['ErrorAlreadyExists']));
								test($lang['InstallingModeratorGroup'], @mysqli_query($dblink, $insert_moderator_group), str_replace('%1', 'moderator group', $lang['ErrorAlreadyExists']));
								test($lang['InstallingReviewerGroup'], @mysqli_query($dblink, $insert_reviewer_group), str_replace('%1', 'reviewer group', $lang['ErrorAlreadyExists']));
								print("         </ul>\n");
								print("         <br />\n");
								print("         <h2>".$lang['InstallingDefaultData']."</h2>\n");
								print("         <ul>\n");
								print("            <li>".$lang['InstallingPagesBegin']);
								require_once('setup/inserts.php');
								print("</li>\n");
								print("            <li>".$lang['InstallingPagesEnd']."</li>\n");

								test($lang['InstallingLogoImage'], @mysqli_query($dblink, $insert_logo_image), str_replace('%1', 'logo image', $lang['ErrorAlreadyExists']));
								test($lang['InstallingConfigValues'], @mysqli_query($dblink, $insert_config), str_replace('%1', 'config values', $lang['ErrorAlreadyExists']));
								break;

								/*
								 The funny upgrading stuff. Make sure these are in order!
								 And yes, there are no (switch) breaks here. This is on purpose.
								 */

							// upgrade from R4.2 to R4.3.rc1
							case 'R4.2':
								print("         <h2>Wacko R4.2 ".$lang['To']." R4.3.rc1</h2>\n");
								print("         <ul>\n");

								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_2_1), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_2_2), str_replace('%1', 'page', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_2_2), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_2_3), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));

								test($lang['InstallingLogoImage'], @mysqli_query($dblink, $insert_logo_image), str_replace('%1',"logo image",$lang['ErrorAlreadyExists']));

							// upgrade from R4.3.rc1 to R4.4.rc1
							case 'R4.3':
								print("         <h2>Wacko R4.3.rc1 ".$lang['To']." R4.4.rc1</h2>\n");
								print("         <ul>\n");

								// rename tables
								test(str_replace('%1', 'acl', $lang['RenameTable']), @mysqli_query($dblink, $rename_acl_r4_3_1), str_replace('%1', 'acl', $lang['ErrorRenamingTable']));
								test(str_replace('%1', 'link', $lang['RenameTable']), @mysqli_query($dblink, $rename_link_r4_3_1), str_replace('%1', 'link', $lang['ErrorRenamingTable']));
								test(str_replace('%1', 'page', $lang['RenameTable']), @mysqli_query($dblink, $rename_page_r4_2_1), str_replace('%1', 'page', $lang['ErrorRenamingTable']));
								test(str_replace('%1', 'referrer', $lang['RenameTable']), @mysqli_query($dblink, $rename_referrer_r4_3_1), str_replace('%1', 'referrer', $lang['ErrorRenamingTable']));
								test(str_replace('%1', 'revision', $lang['RenameTable']), @mysqli_query($dblink, $rename_revision_r4_2_1), str_replace('%1', 'revision', $lang['ErrorRenamingTable']));
								test(str_replace('%1', 'user', $lang['RenameTable']), @mysqli_query($dblink, $rename_user_r4_3_1), str_replace('%1', 'user', $lang['ErrorRenamingTable']));
								test(str_replace('%1', 'watch', $lang['RenameTable']), @mysqli_query($dblink, $rename_watch_r4_3_1), str_replace('%1', 'watch', $lang['ErrorRenamingTable']));

								// ! new user_id first
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_1), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_2), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_3), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_4), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_5), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_6), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_7), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_8), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_9), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_10), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_11), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_12), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_13), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_14), str_replace('%1', 'user', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'user', $lang['UpdateTable']), @mysqli_query($dblink, $update_user_r4_3), str_replace('%1', 'user', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'user', $lang['UpdateTable']), @mysqli_query($dblink, $update_user_r4_3_1), str_replace('%1', 'user', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'user', $lang['UpdateTable']), @mysqli_query($dblink, $update_user_r4_3_2), str_replace('%1', 'user', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'user', $lang['UpdateTable']), @mysqli_query($dblink, $update_user_r4_3_4), str_replace('%1', 'user', $lang['ErrorUpdatingTable']));

								// rename id after upate!
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_15), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_16), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_17), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_18), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_19), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_20), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_21), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_22), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_23), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_24), str_replace('%1', 'user', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'user', $lang['AlterTable']), @mysqli_query($dblink, $alter_user_r4_3_25), str_replace('%1', 'user', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'acl', $lang['AlterTable']), @mysqli_query($dblink, $alter_acl_r4_3_1), str_replace('%1', 'acl', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'acl', $lang['AlterTable']), @mysqli_query($dblink, $alter_acl_r4_3_2), str_replace('%1', 'acl', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'acl', $lang['UpdateTable']), @mysqli_query($dblink, $update_acl_r4_3), str_replace('%1', 'acl', $lang['ErrorUpdatingTable']));

								// Drop obsolete fields
								test(str_replace('%1', 'acl', $lang['AlterTable']), @mysqli_query($dblink, $alter_acl_r4_3_3), str_replace('%1', 'acl', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'acl', $lang['AlterTable']), @mysqli_query($dblink, $alter_acl_r4_3_4), str_replace('%1', 'acl', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'acl', $lang['AlterTable']), @mysqli_query($dblink, $alter_acl_r4_3_5), str_replace('%1', 'acl', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'acl', $lang['AlterTable']), @mysqli_query($dblink, $alter_acl_r4_3_6), str_replace('%1', 'acl', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'bookmark', $lang['CreatingTable']), @mysqli_query($dblink, $table_bookmark_r4_3), str_replace('%1', 'bookmark', $lang['ErrorCreatingTable']));

								test(str_replace('%1', 'cache', $lang['AlterTable']), @mysqli_query($dblink, $alter_cache_r4_3), str_replace('%1', 'cache', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'cache', $lang['AlterTable']), @mysqli_query($dblink, $alter_cache_r4_3_1), str_replace('%1', 'cache', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'config', $lang['CreatingTable']), @mysqli_query($dblink, $table_config_r4_3), str_replace('%1', 'config', $lang['ErrorCreatingTable']));

								test(str_replace('%1', 'group', $lang['CreatingTable']), @mysqli_query($dblink, $table_group_r4_3), str_replace('%1', 'group', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'group_member', $lang['CreatingTable']), @mysqli_query($dblink, $table_group_member_r4_3), str_replace('%1', 'group_member', $lang['ErrorCreatingTable']));

								test(str_replace('%1', 'category', $lang['CreatingTable']), @mysqli_query($dblink, $table_category_r4_3), str_replace('%1', 'category', $lang['ErrorCreatingTable']));
								test(str_replace('%1', 'category_page', $lang['CreatingTable']), @mysqli_query($dblink, $table_category_page_r4_3), str_replace('%1', 'category_page', $lang['ErrorCreatingTable']));

								test(str_replace('%1', 'link', $lang['AlterTable']), @mysqli_query($dblink, $alter_link_r4_3_1), str_replace('%1', 'link', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'link', $lang['AlterTable']), @mysqli_query($dblink, $alter_link_r4_3_2), str_replace('%1', 'link', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'link', $lang['AlterTable']), @mysqli_query($dblink, $alter_link_r4_3_3), str_replace('%1', 'link', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'link', $lang['UpdateTable']), @mysqli_query($dblink, $update_link_r4_3), str_replace('%1', 'link', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'link', $lang['UpdateTable']), @mysqli_query($dblink, $update_link_r4_3_1), str_replace('%1', 'link', $lang['ErrorUpdatingTable']));

								// drop last!
								test(str_replace('%1', 'link', $lang['AlterTable']), @mysqli_query($dblink, $alter_link_r4_3_4), str_replace('%1', 'link', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'link', $lang['AlterTable']), @mysqli_query($dblink, $alter_link_r4_3_5), str_replace('%1', 'link', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'link', $lang['AlterTable']), @mysqli_query($dblink, $alter_link_r4_3_6), str_replace('%1', 'link', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'log', $lang['CreatingTable']), @mysqli_query($dblink, $table_log_r4_3), str_replace('%1', 'log', $lang['ErrorCreatingTable']));

								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_3), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_4), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_5), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_6), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_7), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_8), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_9), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_10), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_11), str_replace('%1', 'page', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'page', $lang['UpdateTable']), @mysqli_query($dblink, $update_page_r4_3), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'page', $lang['UpdateTable']), @mysqli_query($dblink, $update_page_r4_3_1), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'page', $lang['UpdateTable']), @mysqli_query($dblink, $update_page_r4_3_2), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'page', $lang['UpdateTable']), @mysqli_query($dblink, $update_page_r4_3_3), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'page', $lang['UpdateTable']), @mysqli_query($dblink, $update_page_r4_3_4), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'page', $lang['UpdateTable']), @mysqli_query($dblink, $update_page_r4_3_5), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'page', $lang['UpdateTable']), @mysqli_query($dblink, $update_page_r4_3_6), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'page', $lang['UpdateTable']), @mysqli_query($dblink, $update_page_r4_3_7), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));

								// drop last!
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_12), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_13), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_14), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_15), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_16), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_17), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_18), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_19), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_20), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_21), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_22), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_23), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_24), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_25), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_26), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_27), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_28), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_29), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_30), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_31), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_32), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_33), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_34), str_replace('%1', 'page', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'page', $lang['AlterTable']), @mysqli_query($dblink, $alter_page_r4_3_35), str_replace('%1', 'page', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'page', $lang['UpdateTable']), @mysqli_query($dblink, $update_page_r4_3_8), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'page', $lang['UpdateTable']), @mysqli_query($dblink, $update_page_r4_3_9), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'page', $lang['UpdateTable']), @mysqli_query($dblink, $update_page_r4_3_10), str_replace('%1', 'page', $lang['ErrorUpdatingTable']));

								test(str_replace('%1', 'poll', $lang['CreatingTable']), @mysqli_query($dblink, $table_poll_r4_3), str_replace('%1', 'poll', $lang['ErrorCreatingTable']));

								test(str_replace('%1', 'watch', $lang['AlterTable']), @mysqli_query($dblink, $alter_watch_r4_3_1), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'watch', $lang['AlterTable']), @mysqli_query($dblink, $alter_watch_r4_3_2), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'watch', $lang['AlterTable']), @mysqli_query($dblink, $alter_watch_r4_3_3), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'watch', $lang['UpdateTable']), @mysqli_query($dblink, $update_watch_r4_3), str_replace('%1', 'watch', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'watch', $lang['UpdateTable']), @mysqli_query($dblink, $update_watch_r4_3_1), str_replace('%1', 'watch', $lang['ErrorUpdatingTable']));

								// drop last!
								test(str_replace('%1', 'watch', $lang['AlterTable']), @mysqli_query($dblink, $alter_watch_r4_3_4), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'watch', $lang['AlterTable']), @mysqli_query($dblink, $alter_watch_r4_3_5), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'watch', $lang['AlterTable']), @mysqli_query($dblink, $alter_watch_r4_3_6), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'watch', $lang['AlterTable']), @mysqli_query($dblink, $alter_watch_r4_3_7), str_replace('%1', 'watch', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'rating', $lang['CreatingTable']), @mysqli_query($dblink, $table_rating_r4_3), str_replace('%1', 'rating', $lang['ErrorCreatingTable']));

								test(str_replace('%1', 'referrer', $lang['AlterTable']), @mysqli_query($dblink, $alter_referrer_r4_3_1), str_replace('%1', 'referrer', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'referrer', $lang['AlterTable']), @mysqli_query($dblink, $alter_referrer_r4_3_2), str_replace('%1', 'referrer', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_3), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_4), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_5), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_6), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_7), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_8), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_9), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_10), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_13), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'revision', $lang['UpdateTable']), @mysqli_query($dblink, $update_revision_r4_3), str_replace('%1', 'revision', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'revision', $lang['UpdateTable']), @mysqli_query($dblink, $update_revision_r4_3_1), str_replace('%1', 'revision', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'revision', $lang['UpdateTable']), @mysqli_query($dblink, $update_revision_r4_3_2), str_replace('%1', 'revision', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'revision', $lang['UpdateTable']), @mysqli_query($dblink, $update_revision_r4_3_3), str_replace('%1', 'revision', $lang['ErrorUpdatingTable']));
								test(str_replace('%1', 'revision', $lang['UpdateTable']), @mysqli_query($dblink, $update_revision_r4_3_4), str_replace('%1', 'revision', $lang['ErrorUpdatingTable']));

								// drop last!
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_11), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_12), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_14), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_15), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_16), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_17), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_18), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_19), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_20), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_21), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_22), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'revision', $lang['AlterTable']), @mysqli_query($dblink, $alter_revision_r4_3_23), str_replace('%1', 'revision', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'revision', $lang['UpdateTable']), @mysqli_query($dblink, $update_revision_r4_3_5), str_replace('%1', 'revision', $lang['ErrorUpdatingTable']));

								test(str_replace('%1', 'upload', $lang['AlterTable']), @mysqli_query($dblink, $alter_upload_r4_3), str_replace('%1', 'upload', $lang['ErrorAlteringTable']));

								test(str_replace('%1', 'upload', $lang['UpdateTable']), @mysqli_query($dblink, $update_upload_r4_3), str_replace('%1', 'upload', $lang['ErrorUpdatingTable']));
								// drop last!
								test(str_replace('%1', 'upload', $lang['AlterTable']), @mysqli_query($dblink, $alter_upload_r4_3_1), str_replace('%1', 'upload', $lang['ErrorAlteringTable']));
								test(str_replace('%1', 'upload', $lang['AlterTable']), @mysqli_query($dblink, $alter_upload_r4_3_2), str_replace('%1', 'upload', $lang['ErrorAlteringTable']));

								// inserting config values
								test($lang['InstallingConfigValues'], @mysqli_query($dblink, $insert_config), str_replace('%1', 'config values', $lang['ErrorAlreadyExists']));
								test($lang['InstallingSystemAccount'], @mysqli_query($dblink, $insert_system), str_replace('%1', 'system account', $lang['ErrorAlreadyExists']));

						}
						print("         </ul>\n");
					}
					break;
							default:
								$dsn = '';
								switch($config['database_driver'])
								{
									case 'firebird':
										$dsn = $config['database_driver'].":dbname=".$config['database_host'].":".$config['database_database'].($config['database_port'] != "" ? ";port=".$config['database_port'] : "");
										break;
									case 'ibm':
										$dsn = $config['database_driver'].":DATABASE=".$config['database_host'].";HOSTNAME=".$config['database_database'].($config['database_port'] != "" ? ";PORT=".$config['database_port'] : "");
										break;
									case 'informix':
										$dsn = $config['database_driver'].":database=".$config['database_host'].";host=".$config['database_database'].($config['database_port'] != "" ? ";service=".$config['database_port'] : "");
										break;
									case 'oci':
										require_once('setup/database_oracle.php');
										$dsn = $config['database_driver'].":dbname=".$config['database_database'];
										break;
									case 'sqlite':
									case 'sqlite2':
									case 'mysql_pdo':
										require_once('setup/database_mysql.php');
										$dsn = $config['database_driver'].":dbname=".$config['database_database'].";host=".$config['database_host'].($config['database_port'] != "" ? ";port=".$config['database_port'] : "");
										break;
									case 'mssql':
										require_once('setup/database_mysql.php');
										$dsn = $config['database_driver'].":host=".$config['database_host'].($config['database_port'] != "" ? ",".$config['database_port'] : "").";dbname=".$config['database_database'];
										print($dsn);
										break;
									case 'pgsql':
										require_once('setup/database_pgsql.php');
										$dsn = $config['database_driver'].":dbname=".$config['database_database'].";host=".$config['database_host'].($config['database_port'] != "" ? ";port=".$config['database_port'] : "");
										break;
								}

								print("         <ul>\n");
								/*
									PHP4 doesn't support try/catch blocks so we put the PDO code in a seperate file.
									Since we don't support PDO in PHP4 they can never come down this route without PHP5.
									i.e. they don't see this as a selection on the previous page.
								*/
								require_once('setup/database-install-pdo.php');
								print("         </ul>\n");
								print("         <br />\n");

								if(!$fatal_error)
								{
									if ($config['DeleteTables'] == 'on')
									{
										print("<h2>".$lang['DeletingTables']."</h2>\n");
										print("            <ul>\n");
										test_pdo(str_replace('%1', 'acl', $lang['DeletingTable']), $table_acl_drop, str_replace('%1', 'acl', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'bookmark', $lang['DeletingTable']), $table_bookmark_drop, str_replace('%1', 'bookmark', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'cache', $lang['DeletingTable']), $table_cache_drop, str_replace('%1', 'cache', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'config', $lang['DeletingTable']), $table_config_drop, str_replace('%1', 'config', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'group', $lang['DeletingTable']), $table_group_drop, str_replace('%1', 'group', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'group_member', $lang['DeletingTable']), $table_group_member_drop, str_replace('%1', 'group_member', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'category', $lang['DeletingTable']), $table_category_drop, str_replace('%1', 'category', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'category_page', $lang['DeletingTable']), $table_category_page_drop, str_replace('%1', 'category_page', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'link', $lang['DeletingTable']), $table_link_drop, str_replace('%1', 'link', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'log', $lang['DeletingTable']), $table_log_drop, str_replace('%1', 'log', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'page', $lang['DeletingTable']), $table_page_drop, str_replace('%1', 'page', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'poll', $lang['DeletingTable']), $table_poll_drop, str_replace('%1', 'poll', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'rating', $lang['DeletingTable']), $table_rating_drop, str_replace('%1', 'rating', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'referrer', $lang['DeletingTable']), $table_referrer_drop, str_replace('%1', 'referrer', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'revision', $lang['DeletingTable']), $table_revision_drop, str_replace('%1', 'revision', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'upload', $lang['DeletingTable']), $table_upload_drop, str_replace('%1', 'upload', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'user', $lang['DeletingTable']), $table_user_drop, str_replace('%1', 'user', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'user_setting', $lang['DeletingTable']), $table_user_setting_drop, str_replace('%1', 'user_setting', $lang['ErrorDeletingTable']));
										test_pdo(str_replace('%1', 'watch', $lang['DeletingTable']), $table_watch_drop, str_replace('%1', 'watch', $lang['ErrorDeletingTable']));
										print("            <li>".$lang['DeletingTablesEnd']."</li>\n");
										print("         </ul>\n");
										print("         <br />\n");
									}

									// No need to check the past versions since PDO SQL is only officially supported in this release (v4.3)
									print("         <h2>".$lang['InstallingTables']."</h2>\n");
									print("         <ul>\n");
									test_pdo(str_replace('%1', 'acl', $lang['CreatingTable']), $table_acl, str_replace('%1', 'acl', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'bookmark', $lang['CreatingTable']), $table_bookmark, str_replace('%1', 'bookmark', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'cache', $lang['CreatingTable']), $table_cache, str_replace('%1', 'cache', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'config', $lang['CreatingTable']), $table_config, str_replace('%1', 'config', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'group', $lang['CreatingTable']), $table_group, str_replace('%1', 'group', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'group_member', $lang['CreatingTable']), $table_group_member, str_replace('%1', 'group_member', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'category', $lang['CreatingTable']), $table_category, str_replace('%1', 'category', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'category_page', $lang['CreatingTable']), $table_category_page, str_replace('%1', 'category_page', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'link', $lang['CreatingTable']), $table_link, str_replace('%1', 'link', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'log', $lang['CreatingTable']), $table_log, str_replace('%1', 'log', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'page', $lang['CreatingTable']), $table_page, str_replace('%1', 'page', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'poll', $lang['CreatingTable']), $table_poll, str_replace('%1', 'poll', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'rating', $lang['CreatingTable']), $table_rating, str_replace('%1', 'rating', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'referrer', $lang['CreatingTable']), $table_referrer, str_replace('%1', 'referrer', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'revision', $lang['CreatingTable']), $table_revision, str_replace('%1', 'revision', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'upload', $lang['CreatingTable']), $table_upload, str_replace('%1', 'upload', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'user', $lang['CreatingTable']), $table_user, str_replace('%1', 'user', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'user_setting', $lang['CreatingTable']), $table_user_setting, str_replace('%1', 'user_setting', $lang['ErrorCreatingTable']));
									test_pdo(str_replace('%1', 'watch', $lang['CreatingTable']), $table_watch, str_replace('%1', 'watch', $lang['ErrorCreatingTable']));

									test_pdo($lang['InstallingSystemAccount'], $insert_system, str_replace('%1', 'system account', $lang['ErrorAlreadyExists']));
									test_pdo($lang['InstallingAdmin'], $insert_admin, str_replace('%1', 'admin user', $lang['ErrorAlreadyExists']));
									test_pdo($lang['InstallingAdminSetting'], $insert_admin_setting, str_replace('%1', 'admin user settings', $lang['ErrorAlreadyExists']));
									test_pdo($lang['InstallingAdminGroup'], $insert_admin_group, str_replace('%1', 'admin group', $lang['ErrorAlreadyExists']));
									test_pdo($lang['InstallingAdminGroupMember'], $insert_admin_group_member, str_replace('%1', 'admin group member', $lang['ErrorAlreadyExists']));

									test_pdo($lang['InstallingEverybodyGroup'], $insert_everybody_group, str_replace('%1', 'everybody group', $lang['ErrorAlreadyExists']));
									test_pdo($lang['InstallingRegisteredGroup'], $insert_registered_group, str_replace('%1', 'registered group', $lang['ErrorAlreadyExists']));
									test_pdo($lang['InstallingModeratorGroup'], $insert_moderator_group, str_replace('%1', 'moderator group', $lang['ErrorAlreadyExists']));
									test_pdo($lang['InstallingReviewerGroup'], $insert_reviewer_group, str_replace('%1', 'reviewer group', $lang['ErrorAlreadyExists']));
									print("         </ul>\n");
									print("         <br />\n");
									print("         <h2>".$lang['InstallingDefaultData']."</h2>\n");
									print("         <ul>\n");
									print("            <li>".$lang['InstallingPagesBegin']);
									require_once('setup/inserts.php');
									print("</li>\n");
									print("            <li>".$lang['InstallingPagesEnd']."</li>\n");

									test_pdo($lang['InstallingLogoImage'], $insert_logo_image, str_replace('%1', 'logo image', $lang['ErrorAlreadyExists']));
									test_pdo($lang['InstallingConfigValues'], $insert_config, str_replace('%1', 'config values', $lang['ErrorAlreadyExists']));
									print("         </ul>\n");
								}
								break;
}

if(!$fatal_error)
{
?>
<p><?php echo $lang['NextStep'];?></p>
<form action="<?php echo myLocation(); ?>?installAction=write-config" method="post">
<?php
	writeConfigHiddenNodes(array('DeleteTables' => ''));
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