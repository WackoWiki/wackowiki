<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Default configuration values

// DO NOT EDIT HERE; instead make changes in config.php or config table.
// These default settings are used when config.php is not present.

$wacko_config_defaults = [
	'db_driver'						=> '',
	'db_host'						=> 'localhost',
	'db_port'						=> '',
	'db_name'						=> 'wacko',
	'db_user'						=> '',
	'db_password'					=> '',
	'db_collation'					=> 'utf8mb4_unicode_520_ci',
	'db_charset'					=> 'utf8mb4',
	'db_engine'						=> 'InnoDB',

	'session_store'					=> 1,
	'sql_mode_strict'				=> 0,

	'table_prefix'					=> 'wacko_',

	'root_page'						=> 'HomePage',
	'site_name'						=> 'MyWikiSite',
	'site_desc'						=> 'Cover what you do best. Link to the rest.',
	'base_url'						=> ($_SERVER['SERVER_PORT'] == 443
											? 'https'
											: 'http'
										) . '://' .
										$_SERVER['SERVER_NAME'] .
										(!in_array($_SERVER['SERVER_PORT'], [80, 443])
											? ':' . $_SERVER['SERVER_PORT']
											: ''
										) .
										(($path = str_replace('//', '/', trim(strtr(dirname($_SERVER['SCRIPT_NAME']), '\\', '/'), '/')))
											? '/' . $path
											: ''
										) . '/' ,
	'canonical'						=> 0,
	'rewrite_mode'					=> ($found_rewrite_extension ? 1 : 0),
	'tls'							=> 0,
	'tls_implicit'					=> 0,
	'cookie_prefix'					=> '',

	'reverse_proxy'					=> 0,
	'reverse_proxy_header'			=> '',
	'reverse_proxy_addresses'		=> '',	// 'a.b.c.d', ...'

	'phpmailer_method'				=> 'mail',

	'smtp_host'						=> 'localhost',
	'smtp_username'					=> '',
	'smtp_password'					=> '',
	'smtp_port'						=> 587,
	'smtp_connection_mode'			=> '',
	'smtp_auto_tls'					=> 0,
	'email_priority'				=> 3,

	'email_from'					=> 'WackoWiki',
	'enable_email'					=> 1,
	'enable_email_notification'		=> 1,

	'notify_minor_edit'				=> 1,
	'notify_page'					=> 2,
	'notify_comment'				=> 1,
	'notify_new_user_account'		=> 1,
	'notify_upload'					=> 1,

	'allow_massemail'				=> 0,
	'allow_intercom'				=> 0,

	'allowed_email_domains'			=> '',
	'check_mx_record'				=> 0,
	'validate_email'				=> 1,
	'email_pattern'					=> '',

	'approve_new_user'				=> 0,
	'allow_email_reuse'				=> 0,

	'language'						=> 'en',
	'multilanguage'					=> 0,
	'allowed_languages'				=> 0,

	'theme'							=> 'default',
	'allow_themes'					=> 0,
	'allow_themes_per_page'			=> 0,
	'theme_color'					=> '',

	'site_logo'						=> 'wacko_logo.png',
	'logo_display'					=> 0,
	'logo_height'					=> 50,
	'logo_width'					=> 108,
	'site_favicon'					=> '',

	'max_page_size'					=> 2048 * 1024,
	'edit_summary'					=> 0,
	'minor_edit'					=> 0,
	'section_edit'					=> 0,
	'review'						=> 0,

	'enable_comments'				=> 1,
	'hide_revisions'				=> 0,
	'show_permalink'				=> 1,
	'diff_modes'					=> '0,1,2,3,4,5',
	'default_diff_mode'				=> 3,
	'notify_diff_mode'				=> 2,

	'hide_toc'						=> 0,
	'hide_index'					=> 0,
	'tree_level'					=> 1,

	'footer_comments'				=> 1,
	'footer_files'					=> 1,
	'footer_tags'					=> 1,

	'show_spaces'					=> 1,
	'numerate_links'				=> 0,

	'allow_x11colors'				=> 0,
	'typografica'					=> 0,
	'paragrafica'					=> 1,

	'disable_bracketslinks'			=> 0,
	'disable_wikilinks'				=> 1,
	'disable_formatters'			=> 0,

	'youarehere_text'				=> '',
	'hide_locked'					=> 1,
	'allow_rawhtml'					=> 1,
	'disable_safehtml'				=> 0,
	'urls_underscores'				=> 0,
	'link_target'					=> 0,
	'noreferrer'					=> 0,
	'nofollow'						=> 0,

	'license'						=> '',
	'enable_license'				=> 0,
	'allow_license_per_page'		=> 0,

	// default pages (replaced by lang value in installer.<lang>.php)
	'groups_page'					=> 'Groups',
	'users_page'					=> 'Users',
	'category_page'					=> 'Category',

	'help_page'						=> '',	// Help
	'terms_page'					=> '',	// Terms
	'privacy_page'					=> '',	// Privacy

	'sandbox'						=> '',
	'comments_page'					=> '',
	'changes_page'					=> '',
	'index_page'					=> 'Index',
	'random_page'					=> 'Random',
	'removals_page'					=> '',
	'wanted_page'					=> '',
	'orphaned_page'					=> '',
	'search_page'					=> 'Search',
	'login_page'					=> 'Login',
	'account_page'					=> 'Account',
	'registration_page'				=> 'Registration',
	'password_page'					=> 'Password',

	// special namespaces (clusters)
	'forum_cluster'					=> 'Forum',
	'forum_topics'					=> 10,
	'comments_count'				=> 10,
	'list_count'					=> 50,
	'menu_items'					=> 5,

	'news_cluster'					=> 'News',
	'news_levels'					=> '',
	'news_structure'				=> '',

	'default_write_acl'				=> '$',
	'default_read_acl'				=> '*',
	'default_comment_acl'			=> '$',
	'default_create_acl'			=> '$',
	'default_upload_acl'			=> 'Admins',

	'rename_global_acl'				=> 'Admins',
	'acl_lock'						=> 0,
	'categories_handler'			=> 1,
	'remove_onlyadmins'				=> 0,
	'owners_can_remove_comments'	=> 1,
	'user_can_delete_account'		=> 0,
	'store_deleted_pages'			=> 1,
	'default_rename_redirect'		=> 0,

	'publish_anonymously'			=> 0,

	'allow_registration'			=> 0,
	'autosubscribe'					=> 1,
	'disable_wikiname'				=> 1,
	'username_chars_min'			=> 3,
	'username_chars_max'			=> 20,

	'standard_handlers'				=> 'addcomment|admin\.php|attachments|categories|claim|clone|diff|edit|export\.xml|file|latex|moderate|new|permissions|purge|print|properties|rate|referrers|referrers_sites|remove|rename|review|revisions|revisions\.xml|robots\.txt|sitemap\.xml|show|source|upload|watch|watchers|wordprocessor',

	'upload'						=> 'admins',
	'upload_images_only'			=> 1,
	'upload_max_size'				=> 512000,
	'upload_quota'					=> 0,
	'upload_quota_per_user'			=> 104857600,
	'upload_translit'				=> 1,
	'upload_allowed_exts'			=> '',
	'upload_banned_exts'			=> 'asa|asax|ascx|ashx|asmx|asp|aspx|axd|bat|cdx|cer|cgi|cmd|com|config|cpl|csproj|cs|dll|exe|htm|html|htr|htw|ida|idc|idq|jhtml|js|jsb|jsp|licx|mht|mhtml|msi|phar|php|php3|php4|php5|php7|pht|phtm|phtml|pif|pl|printer|py|rem|resources|resx|scr|shtm|shtml|soap|ssi|stm|vb|vbproj|vbs|vdisco|vxd|webinfo|xap|xht|xhtm|xhtml',

	'check_mimetype'				=> 1,
	'mime_type_exclusions'			=> [
											// HTML may contain cookie-stealing JavaScript and web bugs
											'text/html',
											// similarly with JavaScript itself
											'application/javascript', 'text/javascript', 'text/x-javascript', 'application/x-shellscript',
											// PHP scripts may execute arbitrary code on the server
											'application/x-php', 'text/x-php',
											// other types that may be interpreted by some servers
											'text/x-python', 'text/x-perl', 'text/x-bash', 'text/x-sh', 'text/x-csh',
											// client-side hazards on Internet Explorer
											'text/scriptlet', 'application/x-msdownload',
											// Windows metafile, client-side vulnerability on some systems
											'application/x-msmetafile',
										],

	'img_create_thumbnail'			=> 0,
	'img_max_thumb_width'			=> 150,

	'enable_feeds'					=> 1,

	'noindex'						=> 0,
	'opensearch'					=> 0,

	'xml_sitemap'					=> 0,
	'xml_sitemap_gz'				=> 0,
	'xml_sitemap_time'				=> 1,

	'cache'							=> 0,
	'cache_ttl'						=> 600,

	'cache_sql'						=> 0,
	'cache_sql_ttl'					=> 600,

	'spam_filter'					=> 1,
	'sorting_comments'				=> 0,

	'registration_delay'			=> 10,
	'comment_delay'					=> 30,
	'intercom_delay'				=> 30,
	'moders_can_edit'				=> 3,

	'pwd_unlike_login'				=> 1,
	'pwd_char_classes'				=> 0,
	'pwd_min_chars'					=> 10,
	'pwd_admin_min_chars'			=> 15,


	'system_message'				=> '',
	'system_message_type'			=> '',

	'enable_captcha'				=> 1,
	'captcha_new_comment'			=> 1,
	'captcha_new_page'				=> 1,
	'captcha_edit_page'				=> 1,
	'captcha_registration'			=> 1,

	'max_login_attempts'			=> 3,
	'ip_login_limit_max'			=> 50,	// not in use
	'anonymize_ip'					=> 0,

	'ap_failed_login_count'			=> 0,
	'ap_max_login_attempts'			=> 4,

	'session_length'				=> 30,	// cookie_expire_days
	'session_notice'				=> 0,	// session termination notice
	'allow_persistent_cookie'		=> 1,

	'enable_security_headers'		=> 1,
	'csp'							=> 1,
	'permissions_policy'			=> 1,
	'referrer_policy'				=> 7,

	'form_token_time'				=> 7200,

	'system_seed'					=> '',	// installer autogenerates random one
	'hashid_seed'					=> '',	// installer autogenerates random one
	'recovery_password'				=> '',
	'trusted_domains'				=> '',	// not in use

	'date_format'					=> 'dd.MM.yyyy',
	'time_format'					=> 'HH:mm',
	'time_format_seconds'			=> 'HH:mm:ss',
	'name_date_macro'				=> '%s (%s)',
	'timezone'						=> 'UTC',

	'debug'							=> 0,
	'debug_admin_only'				=> 0,
	'debug_sql_threshold'			=> 0,

	'log_default_show'				=> 1,
	'log_level'						=> 0,
	'log_purge_time'				=> 0,

	'enable_referrers'				=> 0,
	'attachments_handler'			=> 2,
	'export_handler'				=> 2,
	'source_handler'				=> 1,

	'referrers_purge_time'			=> 1,
	'pages_purge_time'				=> 0,
	'keep_deleted_time'				=> 0,
	'enable_counters'				=> 1,

	// enable extensions
	'ext_bad_behaviour'				=> 0,
];
