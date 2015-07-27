<?php

if (!defined('IN_WACKO'))
{
	exit;
}

define('BACKUP_COMPRESSION_RATE',		9);					// gzip compression rate
define('BACKUP_MEMORY_STEP',			1048576);			// max bytes to process per cycle (make sure it's at least 10 times less than PHP memory limit!)
define('BACKUP_FILE_LOG',				'backup.log');		// backup log filename
define('BACKUP_FILE_STRUCTURE',			'structure.sql');	// tables structure filename
define('BACKUP_FILE_DUMP_SUFFIX',		'.dat.gz');			// tables dump filename suffix
define('BACKUP_FILE_GZIP_SUFFIX',		'.gz');				// regular compressed files suffix
define('CACHE_CONFIG_DIR',				'config/');
define('CACHE_FEED_DIR',				'feeds/');
define('CACHE_PAGE_DIR',				'pages/');
define('CACHE_SQL_DIR',					'queries/');
define('GUEST',							'guest@wacko');
define('INTERCOM_MAX_SIZE',				262144);
define('LOAD_NOCACHE',					0);
define('LOAD_CACHE',					1);
define('LOAD_ALL',						0);
define('LOAD_META',						1);
define('MENU_AUTO',						0);
define('MENU_USER',						1);
define('MENU_DEFAULT',					2);
define('RECOVERY_MODE',					0);		// restore database
define('SESSION_HANDLER_ID',			'sid');
define('SESSION_HANDLER_PATH',			null);	// if you are using specific path (instead of system default /tmp) for session variables storing, define it here
define('SQL_NULLDATE',					'0000-00-00 00:00:00');
define('SQL_DATE_FORMAT',				'Y-m-d H:i:s');
define('TRANSLIT_DONTCHANGE',			0);
define('TRANSLIT_LOWERCASE',			1);
define('TRANSLIT_LOAD',					0);
define('TRANSLIT_DONTLOAD',				1);
define('CSP_CUSTOM',					null); // Content-Security-Policy "Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src *;"

// do not change this three lines, PLEASE-PLEASE. In fact, don't change anything! Ever!
define('WACKO_VERSION',					'5.4.0');
define('HTML_ENTITIES_CHARSET',			'ISO-8859-1'); // ISO-8859-1, cp1251
define('XML_HTMLSAX3',					'lib/HTMLSax3/');

define('ACTIONS4DIFF',					'anchor, toc'); //allowed actions in DIFF
define('PHP_MIN_VERSION',				'5.4.0'); //minimum required PHP version
define('PHP_ERROR_REPORTING',			5); // PHP error reporting: 0 - off, 5 - all

?>