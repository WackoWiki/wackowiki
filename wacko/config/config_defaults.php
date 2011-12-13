<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Default configuration values

$wacko_config_defaults = array(
	'database_driver' => '',
	'database_host' => 'localhost',
	'database_port' => '',
	'database_database' => 'wacko',
	'database_user' => '',
	'database_password' => '',
	'database_collation' => 0,

	'table_prefix' => 'wacko_',
	'cookie_prefix' => 'wacko_',
	'session_expiration' => 30, // cookie_expire_days
	'session_prefix' => 'wacko5',

	'root_page' => 'HomePage',
	'site_name' => 'MyWackoSite',
	'site_desc' => 'Cover what you do best. Link to the rest!',
	'base_url' => ($_SERVER['SERVER_PORT'] == 443 ? 'https' : 'http').'://'.$_SERVER['SERVER_NAME'].
		($_SERVER['SERVER_PORT'] != 80 ? ':'.$_SERVER['SERVER_PORT'] : '').
		preg_replace('/(\?|&)installAction=site-config/','',$_SERVER['REQUEST_URI']),
	'rewrite_mode' => ($found_rewrite_extension ? '1' : '0'),
	'tls' => 0,
	'tls_implicit' => 0,
	'tls_proxy' => '',

	'reverse_proxy' => 0,
	'reverse_proxy_header' => '',
	'reverse_proxy_addresses' => array(), // array('a.b.c.d', ...)

	'classes_path' => 'classes',
	'action_path' => 'actions',
	'handler_path' => 'handlers',

	'phpmailer' => 0,
	'phpmailer_method' => 'mail',

	'smtp_host' => 'localhost',
	'smtp_username' => '',
	'smtp_password' => '',
	'smtp_port' => 25,
	'smtp_connection_mode' => '',
	'email_priority' => 3,

	'email_from' => 'WackoWiki',
	'enable_email' => 1,
	'enable_email_notification' => 1,

	'limit_email_domain' => '',
	'check_mx_record' => 0,
	'validate_email' => 1,
	'notify_new_user_created' => 1,
	'allow_email_reuse' => 0,

	'language' => 'en',
	'multilanguage' => 0,

	'theme' => 'default',
	'allow_themes' => 0,
	'allow_themes_per_page' => 0,
	'allow_swfobject' => 0,

	'header_action' => 'header',
	'footer_action' => 'footer',

	'edit_summary' => 0,
	'minor_edit' => 0,
	'review' => 0,

	'enable_comments' => 1,
	'hide_revisions' => 0,

	'hide_toc' => 0,
	'hide_index' => 0,
	'tree_level' => 1,

	'footer_comments' => 1,
	'footer_files' => 1,
	'footer_rating' => 0,

	'revisions_hide_cancel' => 0,

	'show_spaces' => 1,
	'numerate_links' => 1,

	'allow_x11colors' => 0,
	'default_typografica' => 1,
	'paragrafica' => 1,

	'disable_tikilinks' => 1,
	'disable_bracketslinks' => 0,
	'disable_wikilinks' => 1,
	'disable_npjlinks' => 0,
	'disable_formatters' => 0,

	'youarehere_text' => '',
	'hide_locked' => 1,
	'noindex' => 0,
	'allow_rawhtml' => 1,
	'disable_safehtml' => 0,
	'urls_underscores' => 0,

	'groups_page' => 'Groups',
	'users_page' => 'Users',
	'category_page' => 'Category',
	'tag_page' => 'Tag',
	'permalink_page' => 'Permalink',
	'policy_page' => '',
	'license' => '',

	'default_write_acl' => '$',
	'default_read_acl' => '*',
	'default_comment_acl' => '$',
	'default_create_acl' => '$',
	'default_upload_acl' => 'Admins',

	'rename_globalacl' => 'Admins',
	'acl_lock' => 0,
	'owners_can_change_categories' => 1,
	'remove_onlyadmins' => 0,
	'owners_can_remove_comments' => 1,
	'store_deleted_pages' => 1,
	'default_rename_redirect' => 1,

	'publish_anonymously' => 0,

	'allow_registration' => 1,
	'disable_autosubscribe' => 0,
	'disable_wikiname' => 1,
	'username_chars_min' => 3,
	'username_chars_max' => 20,

	'standard_handlers' => 'addcomment|categories|claim|clone|diff|edit|latex|msword|new|permissions|print|properties|rate|referrers|referrers_sites|remove|rename|review|revisions|revisions\.xml|show|source|watch',

	'upload' => 'admins',
	'upload_images_only' => 0,
	'upload_max_size' => 256,
	'upload_quota_per_user' => 500000,
	'upload_path' => 'files/global',
	'upload_path_per_page' => 'files/perpage',
	'upload_banned_exts' => 'php|cgi|js|php|php3|php4|php5|pl|ssi|jsp|phtm|phtml|shtm|shtml|xhtm|xht|asp|aspx|htw|ida|idq|cer|cdx|asa|htr|idc|stm|printer|asax|ascx|ashx|asmx|axd|vdisco|rem|soap|config|cs|csproj|vb|vbproj|webinfo|licx|resx|resources',

	'upload_path_backup'	=> 'files/backup',

	'outlook_workaround' => 1,
	'enable_feeds' => 1,

	'forum_cluster' => 'Forum',
	'forum_topics' => 10,
	'comments_count' => 10,

	'news_cluster' => '',
	'news_levels' => '',

	'meta_description' => '',
	'meta_keywords' => '',

	'noindex' => 0,
	'xml_sitemap' => 0,

	'cache' => 0,
	'cache_dir' => '_cache/',
	'cache_ttl' => 600,

	'cache_sql' => 0,
	'cache_sql_ttl' => 600,

	'spam_filter' => 1,
	'comment_delay' => 30,
	'intercom_delay' => 30,
	'moders_can_edit' => 3,

	'pwd_unlike_login' => 1,
	'pwd_char_classes' => 0,
	'pwd_min_chars' => 9,

	'max_failed_login_count' => 8,

	'captcha_new_comment' => 1,
	'captcha_new_page' => 1,
	'captcha_edit_page' => 1,
	'captcha_registration' => 1,

	'form_token_time' => 7200,
	'max_login_attempts' => 3,
	'ip_login_limit_max' => 50,

	'session_encrypt_cookie' => 0,
	'antidupe' => 0,
	'session_match_ip' => false,
	'session_match_useragent' => true,
	'session_use_db' => false,
	'session_time_to_update' => 300,

	'enable_security_headers' => 1,
	'x_frame_option' => '',
	'x_csp' => '',

	'system_seed' => '', // installer autogenerate random one
	'recovery_password' => '',

	'date_format' => 'd.m.Y',
	'time_format' => 'H:i:s',
	'time_format_seconds' => 'H:i',
	'name_date_macro' => '%s (%s)',
	'date_macro_format' => 'd.m.Y H:i',
	'date_precise_format' => 'd.m.Y H:i:s',
	'timezone' => 0.00,
	'dst' => 0,

	'debug' => 0,
	'debug_admin_only' => 0,
	'debug_sql_threshold' => 0,

	'log_default_show' => 1,
	'log_level' => 0,
	'log_purge_time' => 0,

	'referrers_purge_time' => 1,
	'pages_purge_time' => 0,
	'keep_deleted_time' => 0,
);

?>