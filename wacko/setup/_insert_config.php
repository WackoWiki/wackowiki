<?php

$config_db		= [];
$config_insert	= '';

// set back theme to default, just a precaution
# $config['theme'] = 'default';

if (!isset($config['allowed_languages']))
{
	$config['allowed_languages'] = '';
}

if (!isset($config['multilanguage']))
{
	$config['multilanguage'] = 0;
}

if (!isset($config['rewrite_mode']))
{
	$config['rewrite_mode'] = 0;
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
$config_db['allow_themes']					= $config['allow_themes'];
$config_db['allow_themes_per_page']			= $config['allow_themes_per_page'];
$config_db['allow_x11colors']				= $config['allow_x11colors'];
$config_db['allowed_languages']				= $config['allowed_languages'];
$config_db['antidupe']						= $config['antidupe'];
$config_db['ap_failed_login_count']			= $config['ap_failed_login_count'];
$config_db['ap_max_login_attempts']			= $config['ap_max_login_attempts'];
$config_db['approve_new_user']				= $config['approve_new_user'];
$config_db['cache']							= $config['cache'];
$config_db['cache_sql']						= $config['cache_sql'];
$config_db['cache_sql_ttl']					= $config['cache_sql_ttl'];
$config_db['cache_ttl']						= $config['cache_ttl'];
$config_db['captcha_edit_page']				= $config['captcha_edit_page'];
$config_db['captcha_new_comment']			= $config['captcha_new_comment'];
$config_db['captcha_new_page']				= $config['captcha_new_page'];
$config_db['captcha_registration']			= $config['captcha_registration'];
$config_db['category_page']					= $config['category_page'];
$config_db['check_mimetype']				= $config['check_mimetype'];
$config_db['comments_count']				= $config['comments_count'];
$config_db['comment_delay']					= $config['comment_delay'];
$config_db['csp']							= $config['csp'];
$config_db['date_format']					= $config['date_format'];
$config_db['debug']							= $config['debug'];
$config_db['debug_admin_only']				= $config['debug_admin_only'];
$config_db['debug_sql_threshold']			= $config['debug_sql_threshold'];
$config_db['default_comment_acl']			= $config['default_comment_acl'];
$config_db['default_create_acl']			= $config['default_create_acl'];
$config_db['default_diff_mode']				= $config['default_diff_mode'];
$config_db['default_read_acl']				= $config['default_read_acl'];
$config_db['default_rename_redirect']		= $config['default_rename_redirect'];
$config_db['default_typografica']			= $config['default_typografica'];
$config_db['default_upload_acl']			= $config['default_upload_acl'];
$config_db['default_write_acl']				= $config['default_write_acl'];
$config_db['diff_modes']					= $config['diff_modes'];
$config_db['disable_autosubscribe']			= $config['disable_autosubscribe'];
$config_db['disable_bracketslinks']			= $config['disable_bracketslinks'];
$config_db['disable_formatters']			= $config['disable_formatters'];
$config_db['disable_safehtml']				= $config['disable_safehtml'];
$config_db['disable_tikilinks']				= $config['disable_tikilinks'];
$config_db['disable_wikilinks']				= $config['disable_wikilinks'];
$config_db['disable_wikiname']				= $config['disable_wikiname'];
$config_db['dst']							= $config['dst'];
$config_db['edit_summary']					= $config['edit_summary'];
$config_db['email_priority']				= $config['email_priority'];
$config_db['email_from']					= $config['email_from'];
$config_db['enable_captcha']				= $config['enable_captcha'];
$config_db['enable_comments']				= $config['enable_comments'];
$config_db['enable_email']					= $config['enable_email'];
$config_db['enable_email_notification']		= $config['enable_email_notification'];
$config_db['enable_feeds']					= $config['enable_feeds'];
$config_db['enable_referrers']				= $config['enable_referrers'];
$config_db['enable_security_headers']		= $config['enable_security_headers'];
$config_db['enable_system_message']			= 1;
$config_db['ext_bad_behavior']				= $config['ext_bad_behavior'];
$config_db['footer_comments']				= $config['footer_comments'];
$config_db['footer_files']					= $config['footer_files'];
$config_db['footer_rating']					= $config['footer_rating'];
$config_db['footer_tags']					= $config['footer_tags'];
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
$config_db['list_count']					= $config['list_count'];
$config_db['log_default_show']				= $config['log_default_show'];
$config_db['log_level']						= $config['log_level'];
$config_db['log_purge_time']				= $config['log_purge_time'];
$config_db['site_logo']						= $config['site_logo'];
$config_db['logo_display']					= $config['logo_display'];
$config_db['logo_height']					= $config['logo_height'];
$config_db['logo_width']					= $config['logo_width'];
$config_db['maint_last_cache']				= 1;
$config_db['maint_last_delpages']			= 1;
$config_db['maint_last_log']				= 1;
$config_db['maint_last_oldpages']			= 1;
$config_db['maint_last_refs']				= 1;
$config_db['maint_last_session']			= 1;
$config_db['maint_last_xml_sitemap']		= 1;
$config_db['max_login_attempts']			= $config['max_login_attempts'];
$config_db['menu_items']					= $config['menu_items'];
$config_db['meta_description']				= $config['meta_description'];
$config_db['meta_keywords']					= $config['meta_keywords'];
$config_db['minor_edit']					= $config['minor_edit'];
$config_db['multilanguage']					= $config['multilanguage'];
$config_db['name_date_macro']				= $config['name_date_macro'];
$config_db['news_cluster']					= $config['news_cluster'];
$config_db['news_levels']					= $config['news_levels'];
$config_db['nofollow']						= $config['nofollow'];
$config_db['noindex']						= $config['noindex'];
$config_db['noreferrer']					= $config['noreferrer'];
$config_db['noreply_email']					= !empty($config['noreply_email'])? $config['noreply_email'] : $config['admin_email'];
$config_db['notify_comment']				= $config['notify_comment'];
$config_db['notify_minor_edit']				= $config['notify_minor_edit'];
$config_db['notify_new_user_account']		= $config['notify_new_user_account'];
$config_db['notify_page']					= $config['notify_page'];
$config_db['notify_upload']					= $config['notify_upload'];
$config_db['numerate_links']				= $config['numerate_links'];
$config_db['outlook_workaround']			= $config['outlook_workaround'];
$config_db['owners_can_change_categories']	= $config['owners_can_change_categories'];
$config_db['owners_can_remove_comments']	= $config['owners_can_remove_comments'];
$config_db['pages_purge_time']				= $config['pages_purge_time'];
$config_db['paragrafica']					= $config['paragrafica'];
$config_db['phpmailer_method']				= $config['phpmailer_method'];
$config_db['policy_page']					= $config['policy_page'];
$config_db['publish_anonymously']			= $config['publish_anonymously'];
$config_db['pwd_admin_min_chars']			= $config['pwd_admin_min_chars'];
$config_db['pwd_char_classes']				= $config['pwd_char_classes'];
$config_db['pwd_min_chars']					= $config['pwd_min_chars'];
$config_db['pwd_unlike_login']				= $config['pwd_unlike_login'];
$config_db['referrers_purge_time']			= $config['referrers_purge_time'];
$config_db['remove_onlyadmins']				= $config['remove_onlyadmins'];
$config_db['rename_globalacl']				= $config['rename_globalacl'];
$config_db['reverse_proxy']					= $config['reverse_proxy'];
$config_db['reverse_proxy_header']			= $config['reverse_proxy_header'];
$config_db['reverse_proxy_addresses']		= $config['reverse_proxy_addresses'];
$config_db['review']						= $config['review'];
$config_db['rewrite_mode']					= $config['rewrite_mode'];
$config_db['root_page']						= $config['root_page'];
$config_db['session_length']				= $config['session_length'];
$config_db['session_match_ip']				= $config['session_match_ip'];
$config_db['session_match_useragent']		= $config['session_match_useragent'];
$config_db['site_desc']						= $config['site_desc'];
$config_db['site_favicon']					= $config['site_favicon'];
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
$config_db['system_message_type']			= $config['system_message_type'];
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
$config_db['xml_sitemap']					= $config['xml_sitemap'];
$config_db['xml_sitemap_time']				= $config['xml_sitemap_time'];
$config_db['xml_sitemap_update']			= null;
$config_db['youarehere_text']				= $config['youarehere_text'];
#$config_db[''] = $config[''];

foreach ($config_db as $key => $value)
{
	$config_insert .= "(0, '$key', '$value'),";
}

// to update existing values we use INSERT ... ON DUPLICATE KEY UPDATE: http://dev.mysql.com/doc/refman/5.5/en/insert-on-duplicate.html
$insert_config =	"INSERT INTO " . $config['table_prefix'] . "config (config_id, config_name, config_value)
						VALUES " . $config_insert."(0, 'maint_last_update', UTC_TIMESTAMP()) " .
					"ON DUPLICATE KEY
						UPDATE
							config_name		= VALUES(config_name),
							config_value	= VALUES(config_value);";

