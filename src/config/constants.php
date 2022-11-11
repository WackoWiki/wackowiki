<?php

if (!defined('IN_WACKO'))
{
	exit;
}

const CONFIG_DIR					= 'config';				// NB hardcoded as config/constants.php for bootstrap
const CONFIG_FILE					= 'config/config.php';
const CONFIG_DEFAULTS				= 'config/config_defaults.php';
const SITE_LOCK						= 'config/lock';
const AP_LOCK						= 'config/lock_ap';

const ACTION_DIR					= 'action';
const LANG_DIR						= 'lang';
const FORMATTER_DIR					= 'formatter';
const HANDLER_DIR					= 'handler';
const IMAGE_DIR						= 'image';
const THEME_DIR						= 'theme';
const THUMB_DIR						= 'file/thumb';
const UPLOAD_GLOBAL_DIR				= 'file/global';
const UPLOAD_PER_PAGE_DIR			= 'file/perpage';
const UPLOAD_BACKUP_DIR				= 'file/backup';
const XML_DIR						= 'xml';

const CACHE_CONFIG_DIR				= '_cache/config';
const CACHE_FEED_DIR				= '_cache/feed';
const CACHE_PAGE_DIR				= '_cache/page';
const CACHE_SQL_DIR					= '_cache/query';
const CACHE_TEMPLATE_DIR			= '_cache/template';
const CACHE_SESSION_DIR				= '/tmp';				// '/tmp', '_cache/session'

const CHMOD_SAFE					= 0640;					// better to use 0600 in production
const CHMOD_FILE					= 0644;					// file creation mode
const CHMOD_DIR						= 0755;					// directory creation mode

const SITEMAP_XML					= 'sitemap.xml';

const HTTP_403						= 'image/upload403.svg';
const HTTP_404						= 'image/upload404.svg';

const DAYSECS						= 86400;				// 24 * 60 * 60

const BACKUP_COMPRESSION_RATE		= 9;					// gzip compression rate
const BACKUP_MEMORY_STEP			= 1048576;				// max bytes to process per cycle (make sure it's at least 10 times less than PHP memory limit!)
const BACKUP_FILE_LOG				= 'backup.log';			// backup log filename
const BACKUP_FILE_STRUCTURE			= 'structure.sql';		// tables structure filename
const BACKUP_FILE_DUMP_SUFFIX		= '.dat.gz';			// tables dump filename suffix
const BACKUP_FILE_GZIP_SUFFIX		= '.gz';				// regular compressed files suffix

const GLOB_ALL						= '{,.}*';				// for glob()
const ADD_NO_DIV					= '*';					// for Wacko::method()
const SYSTEM_LANG					= -1;					// for Wacko::_t()

const AUTH_TOKEN					= 'Auth';
const GUEST							= 'guest@wacko';
const INTERCOM_MAX_SIZE				= 262144;

const LOAD_NOCACHE					= 0;
const LOAD_CACHE					= 1;
const LOAD_ALL						= 0;
const LOAD_META						= 1;

const MENU_AUTO						= 0;
const MENU_USER						= 1;
const MENU_DEFAULT					= 2;

const LINK_PAGE						= 0;
const LINK_FILE						= 1;
const LINK_EXTERNAL					= 2;

const OBJECT_PAGE					= 1;
const OBJECT_FILE					= 2;
const OBJECT_REVISION				= 3;

const NBSP							= ' ';					// \u{00A0} No-Break Space (NBSP)

const RECOVERY_MODE					= 0;					// 1 - restore database
const AUTO_REWRITE					= 1;					// 0 - off, turns off auto rewrite for debugging,
															//		with mode_rewrite still active on your webserver,
															//		you're also required to deactivate the rules in the .htaccess file

const SQL_MODE_STRICT				= 'TRADITIONAL,NO_ENGINE_SUBSTITUTION,ONLY_FULL_GROUP_BY';
const SQL_MODE_PERMISSIVE			= 'NO_ENGINE_SUBSTITUTION,NO_AUTO_CREATE_USER';

// Do not change these three lines, PLEASE-PLEASE. In fact, don't change anything! Ever!
const WACKO_VERSION					= '6.0.33';
const HTML_ENTITIES_CHARSET			= 'UTF-8';
const XML_HTMLSAX3					= 'lib/HTMLSax3/';

const WACKO_ENV						= 4;					// Environment: 1 - development, 2 - test, 3 - stage, 4 - production
const HTML_FILTERING				= null;					// safehtml, htmlpurifier

const ACTION4DIFF					= 'anchor, toc';		// allowed actions in DIFF

const DB_MIN_VERSION				= ['mariadb' => '10.2.2', 'mysql' => '5.7.7'];

const PHP_MIN_VERSION				= '7.3.0';				// minimum required PHP version
const PHP_MAX_VERSION				= '8.0';				// maximum required PHP version
const PHP_ERROR_REPORTING			= 0;					// PHP error reporting: 0 - off, 6 - all
