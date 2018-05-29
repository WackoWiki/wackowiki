<?php

if (!defined('IN_WACKO'))
{
	exit;
}

define('CONFIG_DIR',					'config');			// NB hardcoded as config/constants.php for bootstrap
define('CONFIG_FILE',					'config/config.php');
define('CONFIG_DEFAULTS',				'config/config_defaults.php');
define('SITE_LOCK',						'config/lock');
define('AP_LOCK',						'config/lock_ap');

define('ACTION_DIR',					'action');
define('LANG_DIR',						'lang');
define('FORMATTER_DIR',					'formatter');
define('HANDLER_DIR',					'handler');
define('IMAGE_DIR',						'image');
define('THEME_DIR',						'theme');
define('THUMB_DIR',						'file/thumb');
define('UPLOAD_GLOBAL_DIR',				'file/global');
define('UPLOAD_PER_PAGE_DIR',			'file/perpage');
define('UPLOAD_BACKUP_DIR',				'file/backup');
define('XML_DIR',						'xml');

define('CACHE_CONFIG_DIR',				'_cache/config');
define('CACHE_FEED_DIR',				'_cache/feed');
define('CACHE_PAGE_DIR',				'_cache/page');
define('CACHE_SQL_DIR',					'_cache/query');
define('CACHE_TEMPLATE_DIR',			'_cache/template');
define('CACHE_SESSION_DIR',				'/tmp');			// '_cache/session'
define('SAFE_CHMOD',					0640);				// better to use 0600 in production

define('SITEMAP_XML',					'sitemap.xml');

define('HTTP_403',						'image/upload403.svg');
define('HTTP_404',						'image/upload404.svg');

define('DAYSECS',						86400);				// 24 * 60 * 60

define('BACKUP_COMPRESSION_RATE',		9);					// gzip compression rate
define('BACKUP_MEMORY_STEP',			1048576);			// max bytes to process per cycle (make sure it's at least 10 times less than PHP memory limit!)
define('BACKUP_FILE_LOG',				'backup.log');		// backup log filename
define('BACKUP_FILE_STRUCTURE',			'structure.sql');	// tables structure filename
define('BACKUP_FILE_DUMP_SUFFIX',		'.dat.gz');			// tables dump filename suffix
define('BACKUP_FILE_GZIP_SUFFIX',		'.gz');				// regular compressed files suffix

define('GLOB_ALL',						'{,.}*');			// for glob()
define('ADD_NO_DIV',					'*');				// for Wacko::method()
define('SYSTEM_LANG',					-1);				// for Wacko::_t()

define('AUTH_TOKEN',					'Auth');
define('GUEST',							'guest@wacko');
define('INTERCOM_MAX_SIZE',				262144);

define('LOAD_NOCACHE',					0);
define('LOAD_CACHE',					1);
define('LOAD_ALL',						0);
define('LOAD_META',						1);

define('MENU_AUTO',						0);
define('MENU_USER',						1);
define('MENU_DEFAULT',					2);

define('LINK_PAGE',						0);
define('LINK_FILE',						1);
define('LINK_EXTERNAL',					2);

define('OBJECT_PAGE',					1);
define('OBJECT_FILE',					2);

define('RECOVERY_MODE',					0);					// 1 - restore database
define('AUTO_REWRITE',					1);					// 0 - off, turns off auto rewrite for debugging,
															//		with mode_rewrite still active on your webserver,
															//		you're also required to deactivate the rules in the .htaccess file

define('SQL_MODE_STRICT',				'TRADITIONAL,NO_ENGINE_SUBSTITUTION,ONLY_FULL_GROUP_BY');
define('SQL_MODE_PERMISSIVE',			'NO_ENGINE_SUBSTITUTION,NO_AUTO_CREATE_USER');

define('TRANSLIT_DONTCHANGE',			0);
define('TRANSLIT_LOWERCASE',			1);
define('TRANSLIT_LOAD',					0);
define('TRANSLIT_DONTLOAD',				1);

// do not change this three lines, PLEASE-PLEASE. In fact, don't change anything! Ever!
define('WACKO_VERSION',					'5.5.5');
define('HTML_ENTITIES_CHARSET',			'ISO-8859-1');		// ISO-8859-1, cp1251
define('XML_HTMLSAX3',					'lib/HTMLSax3/');

define('HTML_FILTERING',				null);				// safehtml, htmlpurifier

define('ACTION4DIFF',					'anchor, toc');		// allowed actions in DIFF

define('PHP_MIN_VERSION',				'7.0.0');			// minimum required PHP version
define('PHP_MAX_VERSION',				'7.2.0');			// maximum required PHP version
define('PHP_ERROR_REPORTING',			0);					// PHP error reporting: 0 - off, 6 - all
