<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Basic functions',
		'preferences'	=> 'Preferences',
		'content'		=> 'Content',
		'users'			=> 'Потребители',
		'maintenance'	=> 'Поддръжка',
		'messages'		=> 'Messages',
		'extension'		=> 'Разширения',
		'database'		=> 'База данни',
	],

	// Admin panel
	'AdminPanel'				=> 'Администраторски контролен панел',
	'RecoveryMode'				=> 'Режим на възстановяване',
	'Authorization'				=> 'Authorization',
	'AuthorizationTip'			=> 'Please enter the administrative password (make sure that cookies are allowed in your browser).',
	'NoRecoveryPassword'		=> 'Административната парола не е зададена!',
	'NoRecoveryPasswordTip'		=> 'Забележка: Липсата на административна парола е заплаха за сигурността! Въведете хеш паролата си в конфигурационния файл и стартирайте програмата отново.',

	'ErrorLoadingModule'		=> 'Error loading admin module %1: does not exist.',

	'ApHomePage'				=> 'Главна страница',
	'ApHomePageTip'				=> 'Open the home page, you do not quit system administration',
	'ApLogOut'					=> 'Log out',
	'ApLogOutTip'				=> 'Quit system administration and log out of site',

	'TimeLeft'					=> 'Time left:  %1 minutes',
	'ApVersion'					=> 'версия',

	'SiteOpen'					=> 'Open',
	'SiteOpened'				=> 'site opened',
	'SiteOpenedTip'				=> 'The site is open',
	'SiteClose'					=> 'Close',
	'SiteClosed'				=> 'site closed',
	'SiteClosedTip'				=> 'The site is closed',

	'System'					=> 'System',

	// Generic
	'Cancel'					=> 'Отмени',
	'Add'						=> 'Добави',
	'Edit'						=> 'Редактиране',
	'Remove'					=> 'Изртиване',
	'Enabled'					=> 'Включено',
	'Disabled'					=> 'Изключено',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'Admin',
	'Min'						=> 'Min',
	'Max'						=> 'Max',

	'MiscellaneousSection'		=> 'Miscellaneous',
	'MainSection'				=> 'General Options',

	'DirNotWritable'			=> 'The %1 directory is not writable.',
	'FileNotWritable'			=> 'The %1 file is not writable.',

	/**
	 * AP MENU
	 *
	 *	'module_name'		=> [
	 *		'name'		=> 'Module name',
	 *		'title'		=> 'Module title',
	 *	],
	 */

	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Basic',
		'title'		=> 'Basic parameters',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Appearance',
		'title'		=> 'Appearance settings',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Email',
		'title'		=> 'Email настройки',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Syndication',
		'title'		=> 'Syndication settings',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filter',
		'title'		=> 'Filter settings',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'Formatting options',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Notifications',
		'title'		=> 'Notifications settings',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Pages',
		'title'		=> 'Pages and site parameters',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Права',
		'title'		=> 'Permissions settings',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Security',
		'title'		=> 'Security subsystems settings',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'System',
		'title'		=> 'System options',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Upload',
		'title'		=> 'Attachment settings',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Deleted',
		'title'		=> 'Newly deleted content',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Add, edit or remove default menu items',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Backup',
		'title'		=> 'Backing up data',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Repair',
		'title'		=> 'Repair and Optimize Database',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Възстановяване',
		'title'		=> 'Restoring backup data',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Main Menu',
		'title'		=> 'WackoWiki Administration',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inconsistencies',
		'title'		=> 'Fixing Data Inconsistencies',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Data Synchronization',
		'title'		=> 'Synchronizing data',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Масов email',
		'title'		=> 'Масов email',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'System message',
		'title'		=> 'System messages',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'System Info',
		'title'		=> 'System Information',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System log',
		'title'		=> 'Log of system events',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Статистика',
		'title'		=> 'Show statistics',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Bad Behaviour',
		'title'		=> 'Bad Behaviour',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Approve',
		'title'		=> 'User registration approval',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Групи',
		'title'		=> 'Group management',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Потребители',
		'title'		=> 'User management',
	],

	// Main module
	'MainNote'					=> 'Note: It is recommended that access to the site be temporarily blocked for administrative maintenance.',

	'PurgeSessions'				=> 'Изчистване',
	'PurgeSessionsTip'			=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the auth_token table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Updated basic settings',
	'LogBasicSettingsUpdated'	=> 'Updated basic settings',

	'SiteName'					=> 'Site name:',
	'SiteNameInfo'				=> 'The title of this site. Appears on browser title, theme header, email-notification, etc.',
	'SiteDesc'					=> 'Site description:',
	'SiteDescInfo'				=> 'Supplement to the title of the site that appears in the pages header. Explains, in a few words, what this site is about.',
	'AdminName'					=> 'Admin of site:',
	'AdminNameInfo'				=> 'User name of individual who is responsible for overall support of the site. This name is not used to determine access rights, but it is desirable that it conforms to the name of the chief administrator of the site.',

	'LanguageSection'			=> 'Език',
	'DefaultLanguage'			=> 'Default language:',
	'DefaultLanguageInfo'		=> 'Specifies the language of messages displayed to unregistered guests, as well as the locale settings.',
	'MultiLanguage'				=> 'Multilanguage support:',
	'MultiLanguageInfo'			=> 'Enable the ability to select a language on a page-by-page basis.',
	'AllowedLanguages'			=> 'Allowed languages:',
	'AllowedLanguagesInfo'		=> 'It is recommended to select only the set of languages you want to use, otherwise all languages are selected.',

	'CommentSection'			=> 'Коментари',
	'AllowComments'				=> 'Allow comments:',
	'AllowCommentsInfo'			=> 'Enable comments for guests or registered users only, or disable them on the entire site.',
	'SortingComments'			=> 'Sorting comments:',
	'SortingCommentsInfo'		=> 'Changes the order the page comments are presented, either with the most recent OR the oldest comment at the top.',

	'ToolbarSection'			=> 'Toolbar',
	'CommentsPanel'				=> 'Comments panel:',
	'CommentsPanelInfo'			=> 'The default display of comments at the bottom of the page.',
	'FilePanel'					=> 'File panel:',
	'FilePanelInfo'				=> 'The default display of attachments at the bottom of the page.',
	'TagsPanel'					=> 'Tags panel:',
	'TagsPanelInfo'				=> 'The default display of the tags panel at the bottom of the page.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Show permalink:',
	'ShowPermalinkInfo'			=> 'The default display of the permalink for the current version of the page.',
	'TocPanel'					=> 'Table of contents panel:',
	'TocPanelInfo'				=> 'The default display table of contents panel of a page (may need support in the templates).',
	'SectionsPanel'				=> 'Sections panel:',
	'SectionsPanelInfo'			=> 'By default, display the panel of adjacent pages (requires support in the templates).',
	'DisplayingSections'		=> 'Displaying sections:',
	'DisplayingSectionsInfo'	=> 'When the previous options are set, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>), both, or other (<em>tree</em>).',
	'MenuItems'					=> 'Menu items:',
	'MenuItemsInfo'				=> 'Default number of shown menu items (may need support in the templates).',

	'HandlerSection'			=> 'Handlers',
	'HideRevisions'				=> 'Hide revisions:',
	'HideRevisionsInfo'			=> 'The default display of revisions of the page.',
	'AttachmentHandler'			=> 'Enable attachments handler:',
	'AttachmentHandlerInfo'		=> 'Permits display of the attachments handler.',
	'SourceHandler'				=> 'Enable source handler:',
	'SourceHandlerInfo'			=> 'Permits the display of the source handler.',
	'ExportHandler'				=> 'Enable XML export handler:',
	'ExportHandlerInfo'			=> 'Permits the display of the XML export handler.',

	'DiffModeSection'			=> 'Diff Modes',
	'DefaultDiffModeSetting'	=> 'Default diff mode:',
	'DefaultDiffModeSettingInfo'=> 'Preselected diff mode.',
	'AllowedDiffMode'			=> 'Allowed diff modes:',
	'AllowedDiffModeInfo'		=> 'It is recommended to select only the set of diff modes you want to use, otherwise all diff modes are selected.',
	'NotifyDiffMode'			=> 'Notify diff mode:',
	'NotifyDiffModeInfo'		=> 'Diff mode used for notifications in the email body.',

	'EditingSection'			=> 'Editing',
	'EditSummary'				=> 'Edit summary:',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Малка промяна:',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'SectionEdit'				=> 'Редактиране на раздела:',
	'SectionEditInfo'			=> 'Позволява редактиране само на раздел от страница.',
	'ReviewSettings'			=> 'Review:',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',
	'PublishAnonymously'		=> 'Allow anonymous publishing:',
	'PublishAnonymouslyInfo'	=> 'Allow users to publish anonymously (to hide the name).',

	'DefaultRenameRedirect'		=> 'When renaming, create redirection:',
	'DefaultRenameRedirectInfo'	=> 'By default, offer to set a redirect to the old address of the page being renamed.',
	'StoreDeletedPages'			=> 'Keep deleted pages:',
	'StoreDeletedPagesInfo'		=> 'When you delete a page, a comment or a file, keep it in a special section, where it will be available for review and recovery for some period of time (as described below).',
	'KeepDeletedTime'			=> 'Storage time of deleted pages:',
	'KeepDeletedTimeInfo'		=> 'The period in days. It makes sense only with the previous option. Use zero to ensure entities are never deleted (in this case the administrator can clear the "cart" manually).',
	'PagesPurgeTime'			=> 'Storage time of page revisions:',
	'PagesPurgeTimeInfo'		=> 'Automatically deletes the older versions within the given number of days. If you enter zero, the older versions will not be removed.',
	'EnableReferrers'			=> 'Enable referrers:',
	'EnableReferrersInfo'		=> 'Permits creation and display of external referrers.',
	'ReferrersPurgeTime'		=> 'Storage time of referrers:',
	'ReferrersPurgeTimeInfo'	=> 'Съхранявайте историята на препращането на външни страници не повече от определен брой дни. Нулата означава вечно съхранение, но за активно посещаван сайт това може да доведе до препълване на база данни.',
	'EnableCounters'			=> 'Hit Counters:',
	'EnableCountersInfo'		=> 'Allows per page hit counters and enables display of simple statistics. Views of the page owner are not counted.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Control default web syndication settings for your site.',
	'SyndicationSettingsUpdated'	=> 'Updated syndication settings.',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Enable feeds:',
	'EnableFeedsInfo'			=> 'Включва или изключва RSS емисии за цялата уики.',
	'XmlChangeLink'				=> 'Changes feed link mode:',
	'XmlChangeLinkInfo'			=> 'Defines where the XML Changes feed items links to.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'изглед на разликите',
		'2'		=> 'текущата страница',
		'3'		=> 'списък на версиите',
		'4'		=> 'променената страница',
	],

	'XmlSitemap'				=> 'XML sitemap:',
	'XmlSitemapInfo'			=> 'Creates an XML file called %1 inside the xml folder. You can add the path to the sitemap in the robots.txt file in your root directory as follows:',
	'XmlSitemapGz'				=> 'XML sitemap compression:',
	'XmlSitemapGzInfo'			=> 'If you would like, you may compress your sitemap text file using gzip to reduce your bandwidth requirement.',
	'XmlSitemapTime'			=> 'XML sitemap generation time:',
	'XmlSitemapTimeInfo'		=> 'Генерира Sitemap само веднъж за дадения брой дни, нула означава всяка промяна на страницата.',

	'SearchSection'				=> 'Търси',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Създава файла с описанието на OpenSearch в папката XML и активира функцията за автоматично откриване на приставката за търсене в заглавието на HTML.',
	'SearchEngineVisibility'	=> 'Block search engines (search engine visibility):',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site. It is up to search engines to honor this request.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Control default display settings for your site.',
	'AppearanceSettingsUpdated'	=> 'Updated appearance settings.',

	'LogoOff'					=> 'Изключено',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo and title',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Site logo:',
	'SiteLogoInfo'				=> 'Your logo will typically appear at the top left corner of the application. Max size is 2 MiB. Optimal dimensions are 255 pixels wide by 55 pixels high.',
	'LogoDimensions'			=> 'Logo dimensions:',
	'LogoDimensionsInfo'		=> 'Width and height of the displayed logo.',
	'LogoDisplayMode'			=> 'Logo display mode:',
	'LogoDisplayModeInfo'		=> 'Defines the appearance of the logo. Default is off.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site favicon:',
	'SiteFaviconInfo'			=> 'Your shortcut icon, or favicon, is displayed in the address bar, tabs and bookmarks of most browsers. This will override the favicon of your theme.',
	'SiteFaviconTooBig'			=> 'Favicon е по-голям от  64 × 64px.',
	'ThemeColor'				=> 'Цвят на темата за адресната лента:',
	'ThemeColorInfo'			=> 'Браузърът ще зададе цвета на адресната лента на всяка страница в съответствие с предоставения CSS цвят.',

	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Theme:',
	'ThemeInfo'					=> 'Template design the site uses by default.',
	'ThemesAllowed'				=> 'Allowed Themes:',
	'ThemesAllowedInfo'			=> 'Select the allowed themes, which the user can choose; otherwise, all available themes are allowed.',
	'ThemesPerPage'				=> 'Themes per page:',
	'ThemesPerPageInfo'			=> 'Allow themes per page, which the page owner can choose via page properties.',

	// System settings
	'SystemSettingsInfo'		=> 'Group of parameters responsible for fine-tuning the site. Do not change them unless you are confident in their actions.',
	'SystemSettingsUpdated'		=> 'Updated system settings',

	'DebugModeSection'			=> 'Debug Mode',
	'DebugMode'					=> 'Debug mode:',
	'DebugModeInfo'				=> 'Extracting and outputting telemetry data about the application\'s execution time. Attention: Full detail mode imposes higher requirements to the allocated memory, especially for resource-intensive operations, such as database backup and restore.',
	'DebugModes'	=> [
		'0'		=> 'debugging is off',
		'1'		=> 'only the total execution time',
		'2'		=> 'full-time',
		'3'		=> 'full detail (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Threshold performance RDBMS:',
	'DebugSqlThresholdInfo'		=> 'In detailed debug mode, report only the queries that take longer than the number of seconds specified.',
	'DebugAdminOnly'			=> 'Closed diagnosis:',
	'DebugAdminOnlyInfo'		=> 'Show debug data of the program (and DBMS) only for the administrator.',

	'CachingSection'			=> 'Caching Options',
	'Cache'						=> 'Cache rendered pages:',
	'CacheInfo'					=> 'Save rendered pages in the local cache to speed up the subsequent boot. Valid only for unregistered visitors.',
	'CacheTtl'					=> 'Time-to-live for cached pages:',
	'CacheTtlInfo'				=> 'Cache pages no more than a specified number of seconds.',
	'CacheSql'					=> 'Cache DBMS queries:',
	'CacheSqlInfo'				=> 'Maintain a local cache of the results of certain resource-related SQL queries.',
	'CacheSqlTtl'				=> 'Time-to-live for cached SQL queries:',
	'CacheSqlTtlInfo'			=> 'Cache results of SQL queries for no more than the specified number of seconds. Values greater than 1200 are not desirable.',

	'LogSection'				=> 'Log Settings',
	'LogLevelUsage'				=> 'Use logging:',
	'LogLevelUsageInfo'			=> 'The minimum priority of the events recorded in the log.',
	'LogThresholds'	=> [
		'0'		=> 'do not keep a journal',
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high',
		'4'		=> 'on average',
		'5'		=> 'from low',
		'6'		=> 'the minimum level',
		'7'		=> 'record all',
	],
	'LogDefaultShow'			=> 'Display log mode:',
	'LogDefaultShowInfo'		=> 'The minimum priority events displayed in the log by default.',
	'LogModes'	=> [
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high-level',
		'4'		=> 'the average',
		'5'		=> 'from a low',
		'6'		=> 'from the minimum level',
		'7'		=> 'show all',
	],
	'LogPurgeTime'				=> 'Storage time of Log:',
	'LogPurgeTimeInfo'			=> 'Remove event log after the specified number of days.',

	'PrivacySection'			=> 'Privacy',
	'AnonymizeIp'				=> 'Anonymize users\' IP addresses:',
	'AnonymizeIpInfo'			=> 'Anonymize IP addresses where applicable (i.e., page, revision or referrers).',

	'ReverseProxySection'		=> 'Reverse Proxy',
	'ReverseProxy'				=> 'Use reverse proxy:',
    'ReverseProxyInfo'			=> 
    'Enable this setting to determine the correct IP address of the remote client by examining information stored in the X-Forwarded-For headers.  X-Forwarded-For headers are a standard mechanism for identifying client systems connecting through a reverse proxy server, such as Squid or Pound. Reverse proxy servers are often used to enhance the performance of heavily visited sites and may also provide other site caching, security or encryption benefits. If this WackoWiki installation operates behind a reverse proxy, this setting should be enabled so that correct IP address information is captured in WackoWiki\'s session management, logging, statistics and access management systems; if you are unsure about this setting, do not have a reverse proxy, or WackoWiki operates in a shared hosting environment, this setting should remain disabled.',
	'ReverseProxyHeader'		=> 'Reverse proxy header:',
	'ReverseProxyHeaderInfo'	=> 'Задайте тази стойност, ако вашият прокси сървър изпраща IP адреса на клиента в заглавие,
									различно от X-Forwarded-For. Заглавието "X-Forwarded-For" представлява списък от IP адреси,
									разделени със запетая + интервал, като ще бъде използван само последният (най-левият).',
	'ReverseProxyAddresses'		=> 'reverse_proxy accepts an array of IP addresses:',
	'ReverseProxyAddressesInfo'	=> 'Each element of this array is the IP address of any of your reverse
									 proxies. If using this array, WackoWiki will trust the information stored
									 in the X-Forwarded-For headers only if the Remote IP address is one of
									 these, that is, the request reaches the web server from one of your
									 reverse proxies. Otherwise, the client could directly connect to
									 your web server by spoofing the X-Forwarded-For headers.',

	'SessionSection'				=> 'Session Handling',
	'SessionStorage'				=> 'Session storage:',
	'SessionStorageInfo'			=> 'This option defines where the the session data is stored. By default, either file or database session storage is selected.',
	'SessionModes'	=> [
		'1'		=> 'Файла',
		'2'		=> 'База данни',
	],
	'SessionNotice'					=> 'Показване на причината за прекратяване на сесията:',
	'SessionNoticeInfo'				=> 'Посочва причината за прекратяване на сесията.',
	'LoginNotice'					=> 'Известие за влизане:',
	'LoginNoticeInfo'				=> 'Показва известие за влизане в системата.',

	'RewriteMode'					=> 'Use <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'If your web server supports this feature, enable to "beautify" the page URLs.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parameters responsible for Access control and permissions.',
	'PermissionsSettingsUpdated'	=> 'Updated permissions settings',

	'PermissionsSection'		=> 'Rights and Privileges',
	'ReadRights'				=> 'Read rights by default:',
	'ReadRightsInfo'			=> 'Default assigned to the created root pages, as well as pages for which parent ACLs cannot be defined.',
	'WriteRights'				=> 'Write rights by default:',
	'WriteRightsInfo'			=> 'Default assigned to the created root pages, as well as pages for which parent ACLs cannot be defined.',
	'CommentRights'				=> 'Comment rights by default:',
	'CommentRightsInfo'			=> 'Default assigned to the created root pages, as well as pages for which parent ACLs cannot be defined.',
	'CreateRights'				=> 'Create rights of a sub page by default:',
	'CreateRightsInfo'			=> 'Default assigned to the created sub pages.',
	'UploadRights'				=> 'Upload rights by default:',
	'UploadRightsInfo'			=> 'Default upload rights.',
	'RenameRights'				=> 'Global rename right:',
	'RenameRightsInfo'			=> 'The list of permissions to freely rename (move) pages.',

	'LockAcl'					=> 'Lock all ACLs to read only:',
	'LockAclInfo'				=> '<span class="cite">Overwrites the ACL settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period of time for security reasons, or as a emergency response to an exploit or vulnerability.',
	'HideLocked'				=> 'Hide inaccessible pages:',
	'HideLockedInfo'			=> 'If the user does not have permission to read the page, hide it in different page lists (however the link placed in text will still be visible).',
	'RemoveOnlyAdmins'			=> 'Only administrators can delete pages:',
	'RemoveOnlyAdminsInfo'		=> 'Deny all, except administrators, the ability to delete pages. The first limit applies to owners of normal pages.',
	'OwnersRemoveComments'		=> 'Owners of pages can delete comments:',
	'OwnersRemoveCommentsInfo'	=> 'Allow page owners to moderate comments on their pages.',
	'OwnersEditCategories'		=> 'Owners can edit page categories:',
	'OwnersEditCategoriesInfo'	=> 'Allow owners to modify the pages category list of your site (add words, delete words), assigns to a page.',
	'TermHumanModeration'		=> 'Human moderation expiration:',
	'TermHumanModerationInfo'	=> 'Модераторите могат да редактират коментари само ако са създадени преди повече от този брой дни (това ограничение не важи за последния коментар в темата).',

	'UserCanDeleteAccount'		=> 'Потребителите могат да изтриват профилите си',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parameters responsible for the overall safety of the platform, safety restrictions and additional security subsystems.',
	'SecuritySettingsUpdated'	=> 'Updated security settings',

	'AllowRegistration'			=> 'Register online:',
	'AllowRegistrationInfo'		=> 'Отворена регистрация на потребителя. Деактивирането на тази опция ще предотврати безплатна регистрация, обаче администраторът на сайта ще може сам да регистрира други потребители.',
	'ApproveNewUser'			=> 'Approve new users:',
	'ApproveNewUserInfo'		=> 'Allows administrators to approve users once they register. Only approved users will be allowed to log in the site.',
	'PersistentCookies'			=> 'Persistent cookies:',
	'PersistentCookiesInfo'		=> 'Allow persistent cookies.',
	'DisableWikiName'			=> 'Disable WikiName:',
	'DisableWikiNameInfo'		=> 'Disable the the mandatory use of a WikiName for users. Permits user registration with traditional nicknames instead of forced CamelCase-formatted names (i.e., NameSurname).',
	'UsernameLength'			=> 'Username length:',
	'UsernameLengthInfo'		=> 'Minimum and maximum number of characters in usernames.',

	'EmailSection'				=> 'Email',
	'AllowEmailReuse'			=> 'Allow email address re-use:',
	'AllowEmailReuseInfo'		=> 'Different users can register with the same email address.',
	'EmailConfirmation'			=> 'Наложете потвърждение по имейл:',
	'EmailConfirmationInfo'		=> 'Изисква от потребителя да потвърди своя имейл адрес, преди да влезе в системата.',
	'AllowedEmailDomains'		=> 'Разрешени имейл домейни:',
	'AllowedEmailDomainsInfo'	=> 'Позволените имейл домейни се разделят със запетая, например <code>example.com, local.lan</code> и т.н., в противен случай всички имейл домейни са разрешени.',
	'ForbiddenEmailDomains'		=> 'Забранени имейл домейни:',
	'ForbiddenEmailDomainsInfo'	=> 'Забранени имейл домейни, разделени със запетая, например ##example.com, local.lan## и т.н. (ефективен само ако списъкът с разрешени имейл домейни е празен)',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Enable captcha:',
	'EnableCaptchaInfo'			=> 'If enabled, captcha will be shown in the following cases, or if a security threshold is reached.',
	'CaptchaComment'			=> 'New comment:',
	'CaptchaCommentInfo'		=> 'As protection against spam, unregistered users must complete captcha before comment will be posted.',
	'CaptchaPage'				=> 'New page:',
	'CaptchaPageInfo'			=> 'As protection against spam, unregistered users must complete captcha before creating a new page.',
	'CaptchaEdit'				=> 'Edit page:',
	'CaptchaEditInfo'			=> 'As protection against spam, unregistered users must complete captcha before editing pages.',
	'CaptchaRegistration'		=> 'Регистрация:',
	'CaptchaRegistrationInfo'	=> 'As protection against spam, unregistered users must complete captcha before registering.',

	'TlsSection'				=> 'TLS Settings',
	'TlsConnection'				=> 'TLS connection:',
	'TlsConnectionInfo'			=> 'Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS certificate on the server, otherwise you will lose access to the admin panel!</span><br>It also determines if the the Cookie Secure Flag is set: The <code>secure</code> flag specifies whether cookies should only be sent over secure connections.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Forcibly reconnect the client from HTTP to HTTPS. With the option disabled, the client can browse the site through an open HTTP channel.',

	'HttpSecurityHeaders'		=> 'HTTP Security Headers',
	'EnableSecurityHeaders'		=> 'Enable security headers:',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk!',
	'Csp'						=> 'Content security policy (CSP):',
	'CspInfo'					=> 'Configuring CSP involves deciding what policies you want to enforce, and then configuring them and using Content-Security-Policy to establish your policy.',
	'PolicyModes'	=> [
		'0'		=> 'disabled',
		'1'		=> 'strict',
		'2'		=> 'custom',
	],
	'PermissionsPolicy'			=> 'Permissions policy:',
	'PermissionsPolicyInfo'		=> 'Заглавието HTTP Permissions-Policy предоставя механизъм за изрично разрешаване или забраняване на различни мощни функции на браузъра.',
	'ReferrerPolicy'			=> 'Referrer policy:',
	'ReferrerPolicyInfo'		=> 'The Referrer-Policy HTTP header governs which referrer information, sent in the Referer header, should be included in responses.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> 'Persistence of User Passwords',
	'PwdMinChars'				=> 'Minimum password length:',
	'PwdMinCharsInfo'			=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 12 to 16 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'AdminPwdMinChars'			=> 'Minimum admin password length:',
	'AdminPwdMinCharsInfo'		=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 15 to 20 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'PwdCharComplexity'			=> 'The required password complexity:',
	'PwdCharClasses'	=> [
		'0'		=> 'not tested',
		'1'		=> 'any letters + numbers',
		'2'		=> 'uppercase and lowercase + numbers',
		'3'		=> 'uppercase and lowercase + numbers + characters',
	],
	'PwdUnlikeLogin'			=> 'Additional complication:',
	'PwdUnlikes'	=> [
		'0'		=> 'not tested',
		'1'		=> 'password is not identical to the login',
		'2'		=> 'password does not contain username',
	],

	'LoginSection'				=> 'Вход',
	'MaxLoginAttempts'			=> 'Maximum number of login attempts per username:',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximum number of login attempts per IP address:',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'FormsSection'				=> 'Forms',
	'FormTokenTime'				=> 'Maximum time to submit forms:',
	'FormTokenTimeInfo'			=> 'Времето, което потребителят трябва да изпрати формуляр (в секунди). <br> Обърнете внимание, че формуляр може да стане невалиден, ако сесията изтече, независимо от тази настройка.',

	'SessionLength'				=> 'Session cookie expiration:',
	'SessionLengthInfo'			=> 'The lifetime of the user session cookie by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments:',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications:',
	'IntercomDelayInfo'			=> 'The minimum delay between sending private messages (in seconds).',
	'RegistrationDelay'			=> 'Time threshold for registering:',
	'RegistrationDelayInfo'		=> 'The minimum time threshold between registration form submissions to discourage registration bots (in seconds).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Group of parameters responsible for fine-tuning the site. Do not change them unless you are confident in their actions.',
	'FormatterSettingsUpdated'	=> 'Updated formatting settings',

	'TextHandlerSection'		=> 'Text Handler:',
	'Typografica'				=> 'Typographical proofreader:',
	'TypograficaInfo'			=> 'Disabling this option will speed up the processes of adding comments and saving pages.',
	'Paragrafica'				=> 'Paragrafica markings:',
	'ParagraficaInfo'			=> 'Similar to the previous option, but will lead to disconnection of inoperable automatic table of contents (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Global HTML support:',
	'AllowRawhtmlInfo'			=> 'This option is potentially unsafe for an open site.',
	'SafeHtml'					=> 'Filtering HTML:',
	'SafeHtmlInfo'				=> 'Prevents saving of dangerous HTML objects. Turning off the filter on an open site with HTML support is <span class="underline">extremely</span> undesirable!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formatter)',
	'X11colors'					=> 'X11 colors usage:',
	'X11colorsInfo'				=> 'Extends the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code>Disabling this option speeds up the processes of adding comments and saving pages.',
	'WikiLinks'					=> 'Disable wiki links:',
	'WikiLinksInfo'				=> 'Деактивира свързването за <code>CamelCaseWords</code>, вашите CamelCase Words вече няма да бъдат свързвани директно към нова страница. Това е полезно, когато работите в различни пространства от имена aks клъстери. По подразбиране е изключено.',
	'BracketsLinks'				=> 'Disable bracketed links:',
	'BracketsLinksInfo'			=> 'Disables <code>[[link]]</code> and <code>((link))</code> syntax.',
	'Formatters'				=> 'Disable formatters:',
	'FormattersInfo'			=> 'Disables <code>%%code%%</code> syntax, used for highlighters.',

	'DateFormatsSection'		=> 'Date Formats',
	'DateFormat'				=> 'The format of the date:',
	'DateFormatInfo'			=> '(day, month, year)',
	'TimeFormat'				=> 'The format of time:',
	'TimeFormatInfo'			=> '(hour, minute)',
	'TimeFormatSeconds'			=> 'The format of the exact time:',
	'TimeFormatSecondsInfo'		=> '(hours, minutes, seconds)',
	'NameDateMacro'				=> 'The format of the <code>::@::</code> macro:',
	'NameDateMacroInfo'			=> '(name, time), e.g. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Времева зона:',
	'TimezoneInfo'				=> 'Времева зона, която да се използва за показване на времето на потребители, които не са влезли в системата (гости). Влезлите в системата потребители задават и могат да променят часовата си зона в потребителските си настройки.',

	'Canonical'					=> 'Ползване на напълно уеднаквени URL адреси:',
	'CanonicalInfo'				=> 'Всички връзки са създадени като абсолютни URL адреси във формата %1. Трябва да се предпочитат URL адреси, свързани с корена на сървъра във формата %2.',
	'LinkTarget'				=> 'Where external links open:',
	'LinkTargetInfo'			=> 'Отваря всяка външна връзка в нов прозорец на браузъра. Добавя <code>target="_blank"</code> към синтаксиса на връзката.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Requires that the browser should not send an HTTP referer header if the user follows the hyperlink. Adds <code>rel="noreferrer"</code> to the link syntax.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Инструктирайте някои търсачки, че хипервръзката не трябва да влияе на класирането на целта за връзки в индекса на търсачките. Добавя <code>rel="nofollow"</code> към синтаксиса на връзката.',
	'UrlsUnderscores'			=> 'Form addresses (URLs) with underscores:',
	'UrlsUnderscoresInfo'		=> 'For example, %1 becames %2 with this option.',
	'ShowSpaces'				=> 'Покажи празните символи в УикиИмента:',
	'ShowSpacesInfo'			=> 'Show spaces in WikiNames, e.g. <code>MyName</code> being displayed as <code>My Name</code> with this option.',
	'NumerateLinks'				=> 'Enumerate links in print view:',
	'NumerateLinksInfo'			=> 'Enumerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disable and visualize self-referencing links:',
	'YouareHereTextInfo'		=> 'Visualize links to the same page, using <code>&lt;b&gt;####&lt;/b&gt;</code>. All links to self lose link formatting, but are displayed as bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Тук можете да зададете или промените основните системни страници, използвани в Wiki. Моля, уверете се, че не забравяте да създадете или да промените съответните страници в Wiki според вашите настройки тук.',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Number of items per list:',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest, or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster forum:',
	'ForumClusterInfo'			=> 'Root cluster for forum section (action %1).',
	'ForumTopics'				=> 'Number of topics per page:',
	'ForumTopicsInfo'			=> 'Number of topics displayed on each page of the list in the forum sections (action %1).',
	'CommentsCount'				=> 'Number of comments per page:',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page\'s list of comments. This applies to all the comments on the site, not just those posted in the forum.',

	'NewsSection'				=> 'Section News',
	'NewsCluster'				=> 'Cluster for the news:',
	'NewsClusterInfo'			=> 'Root cluster for news section (action %1).',
	'NewsStructure'				=> 'News cluster structure:',
	'NewsStructureInfo'			=> 'Stores the articles optionally in sub-clusters by year/month or week (e.g. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Лиценза',
	'DefaultLicense'			=> 'Default license:',
	'DefaultLicenseInfo'		=> 'Under which license your content can be released.',
	'EnableLicense'				=> 'Enable license:',
	'EnableLicenseInfo'			=> 'Enable to show license information.',
	'LicensePerPage'			=> 'License per page:',
	'LicensePerPageInfo'		=> 'Allow license per page, which the page owner can choose via page properties.',

	'ServicePagesSection'		=> 'Service Pages',
	'RootPage'					=> 'Home page:',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',

	'PrivacyPage'				=> 'Поверителност:',
	'PrivacyPageInfo'			=> 'The page with the Privacy Policy of the site.',

	'TermsPage'					=> 'Policies and regulations:',
	'TermsPageInfo'				=> 'The page with the rules of the site.',

	'SearchPage'				=> 'Търси:',
	'SearchPageInfo'			=> 'Page with the search form (action %1).',
	'RegistrationPage'			=> 'Регистрация:',
	'RegistrationPageInfo'		=> 'Page for new user registration (action %1).',
	'LoginPage'					=> 'User login:',
	'LoginPageInfo'				=> 'Login page on the site (action %1).',
	'SettingsPage'				=> 'User Settings:',
	'SettingsPageInfo'			=> 'Page to customize the user profile (action %1).',
	'PasswordPage'				=> 'Change Password:',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action %1).',
	'UsersPage'					=> 'User list:',
	'UsersPageInfo'				=> 'Page with a list of registered users (action %1).',
	'CategoryPage'				=> 'Категория:',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action %1).',
	'GroupsPage'				=> 'Групи:',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action %1).',
	'ChangesPage'				=> 'Recent changes:',
	'ChangesPageInfo'			=> 'Page with a list of the last modified pages (action %1).',
	'CommentsPage'				=> 'Recent comments:',
	'CommentsPageInfo'			=> 'Page with a list of recent comments on the page (action %1).',
	'RemovalsPage'				=> 'Deleted pages:',
	'RemovalsPageInfo'			=> 'Page with a list of recently deleted pages (action %1).',
	'WantedPage'				=> 'Wanted pages:',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action %1).',
	'OrphanedPage'				=> 'Orphaned pages:',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related via links to any other page (action %1).',
	'SandboxPage'				=> 'Sandbox:',
	'SandboxPageInfo'			=> 'Page where users can practice their wiki markup skills.',
	'HelpPage'					=> 'Помогне:',
	'HelpPageInfo'				=> 'The documentation section for working with site tools.',
	'IndexPage'					=> 'Каталог:',
	'IndexPageInfo'				=> 'Страница със списък на всички страници (action %1).',
	'RandomPage'				=> 'Случаен:',
	'RandomPageInfo'			=> 'Зарежда произволна страница (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameters for notifications of the platform.',
	'NotificationSettingsUpdated'	=> 'Updated notification settings',

	'EmailNotification'			=> 'Email notification:',
	'EmailNotificationInfo'		=> 'Allow email notification. Set to Enabled to enable email notifications, Disabled to disable them. Note that disabling email notifications has no effect on emails generated as part of the user signup process.',
	'Autosubscribe'				=> 'Autosubscribe:',
	'AutosubscribeInfo'			=> 'Automatically notify owner of page changes.',

	'NotificationSection'		=> 'Default User Notification Settings',
	'NotifyPageEdit'			=> 'Notify page edit:',
	'NotifyPageEditInfo'		=> 'Pending - Send an email notification only for the first change until the user visits the page again.',
	'NotifyMinorEdit'			=> 'Notify minor edit:',
	'NotifyMinorEditInfo'		=> 'Sends notifications also for minor edits.',
	'NotifyNewComment'			=> 'Notify new comment:',
	'NotifyNewCommentInfo'		=> 'Pending - Send an email notification only for the first comment until the user visits the page again.',

	'NotifyUserAccount'			=> 'Notify new user account:',
	'NotifyUserAccountInfo'		=> 'The Admin will to be notified when a new user has been created using the signup form.',
	'NotifyUpload'				=> 'Notify file upload:',
	'NotifyUploadInfo'			=> 'The Moderators will to be notified when a file has been uploaded.',

	'PersonalMessagesSection'	=> 'Лични съобщения',
	'AllowIntercomDefault'		=> 'Allow intercom:',
	'AllowIntercomDefaultInfo'	=> 'Enabling this option allows other users to send personal messages to the recipient\'s email address without disclosing the address.',
	'AllowMassemailDefault'		=> 'Allow mass email:',
	'AllowMassemailDefaultInfo'	=> 'Only send messages to those users who have permitted administrators to email them information.',

	// Resync settings
	'Synchronize'				=> 'синхронизирам',
	'UserStatsSynched'			=> 'User Statistics synchronized.',
	'PageStatsSynched'			=> 'Page Statistics synchronized.',
	'FeedsUpdated'				=> 'RSS-feeds updated.',
	'SiteMapCreated'			=> 'The new version of the site map created successfully.',
	'ParseNextBatch'			=> 'Parse next batch of pages:',
	'WikiLinksRestored'			=> 'Wiki-links restored.',

	'LogUserStatsSynched'		=> 'Synchronized user statistics',
	'LogPageStatsSynched'		=> 'Synchronized page statistics',
	'LogFeedsUpdated'			=> 'Synchronized RSS feeds',
	'LogPageBodySynched'		=> 'Reparsed page body and links',

	'UserStats'					=> 'User statistics',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to match actual data contained in the database.',
	'PageStats'					=> 'Page statistics',
	'PageStatsInfo'				=> 'Page statistics (number of comments, files and revisions) may differ in some situations from actual data. <br>This operation allows updating statistics to match actual data contained in database.',

	'AttachmentsInfo'			=> 'Актуализира хеша на файла за всички прикачени файлове в базата данни.',
	'AttachmentsSynched'		=> 'Повторна проверка на всички прикачени файлове',
	'LogAttachmentsSynched'		=> 'Повторна проверка на всички прикачени файлове',

	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'In the case of direct editing of pages in the database, the content of RSS-feeds may not reflect the changes made. <br>This function synchronizes the RSS-channels with the current state of the database.',
	'XmlSiteMap'				=> 'XML Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'XmlSiteMapPeriod'			=> 'Period %1 days. Last written %2.',
	'XmlSiteMapView'			=> 'Show Sitemap in a new window.',

	'ReparseBody'				=> 'Reparse all pages',
	'ReparseBodyInfo'			=> 'Empties <code>body_r</code> in page table, so that each page gets rendered again on the next page view. This may be useful if you modified the formatter or changed the domain of your wiki.',
	'PreparsedBodyPurged'		=> 'Emptied <code>body_r</code> field in page table.',

	'WikiLinksResync'			=> 'Wiki links',
	'WikiLinksResyncInfo'		=> 'Performs a re-rendering for all intrasite links and restores the contents of the <code>page_link</code> and <code>file_link</code> tables in the event of damage or relocation (this can take considerable time).',
	'RecompilePage'				=> 'Преизграждане на всички страници (изключително скъпо)',
	'ResyncOptions'				=> 'Допълнителни опции',
	'RecompilePageLimit'		=> 'Number of pages to parse at once.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Тази информация се използва от форума при изпращане на email-и до други потребители. Уверете се че email адреса, който сте въвели е валиден, повредените и неполучените съобщения ще бъдат изпращани на този адрес. Ако хостинга ви не позволява използването на php базираната mail(); функция, можете да използвате директно SMTP.',

	'EmailSettingsUpdated'		=> 'Updated Email settings',

	'EmailFunctionName'			=> 'Email функция име:',
	'EmailFunctionNameInfo'		=> 'Функцията използвана за изпращане на съобщения чрез PHP.',
	'UseSmtpInfo'				=> 'Избери <code>SMTP</code>, ако искаш или трябва да изпращат email адреси през именован сървър вместо локалната mail функция.',

	'EnableEmail'				=> 'Enable emails:',
	'EnableEmailInfo'			=> 'Enable sending of emails.',

	'EmailIdentitySettings'		=> 'Уебсайт Имейли Идентичност',
	'FromEmailName'				=> 'From Name:',
	'FromEmailNameInfo'			=> 'The sender name that is use for the <code>From:</code> header for all email notifications sent from the site.',
	'EmailSubjectPrefix'		=> 'Префикс на предмета:',
	'EmailSubjectPrefixInfo'	=> 'Алтернативен префикс на темата на имейла, например <code>[Префикс] Тема</code>. Ако не е дефиниран, се използва евентуално по-дългото Име на сайта %1 като префикс.',

	'NoReplyEmail'				=> 'No-reply address:',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all email notifications sent from the site.',
	'AdminEmail'				=> 'Email of the site owner:',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service:',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may be the same as the site owner email.',

	'SendTestEmail'				=> 'Send a test email',
	'SendTestEmailInfo'			=> 'This will send a test email to the address defined in your account.',
	'TestEmailSubject'			=> 'Your Wiki is correctly configured to send emails',
	'TestEmailBody'				=> 'If you received this email, your Wiki is correctly configured to send emails.',
	'TestEmailMessage'			=> 'The test email has been sent.<br>If you don\'t receive it, please check your email configuration settings.',

	'SmtpSettings'				=> 'SMTP Settings',
	'SmtpAutoTls'				=> 'Opportunistic TLS:',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Автентичност SMTP:',
	'SmtpConnectionModeInfo'	=> 'Only used if a username/password is required. Ask your provider if you are unsure which method to use.',
	'SmtpPassword'				=> 'SMTP парола:',
	'SmtpPasswordInfo'			=> 'Въведи парола само ако SMTP сървъра я изисква. <em><strong>Важно:</strong> паролата се запазва като прост текст в базата данни.</em>',
	'SmtpPort'					=> 'SMTP сървър порт:',
	'SmtpPortInfo'				=> 'Промени само, ако знаеш че SMTP е на друг порт. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'SMTP сървър адрес:',
	'SmtpServerInfo'			=> 'Note that you have to provide the protocol that your server uses. If you are using SSL, this has to be <code>ssl://mail.example.com</code>',
	'SmtpUsername'				=> 'SMTP име:',
	'SmtpUsernameInfo'			=> 'Въведи името само ако SMTP го изисква.',

	// Upload settings
	'UploadSettingsInfo'		=> 'От тук можете да конфигурирате главните настройки за прикачените файлове.',
	'UploadSettingsUpdated'		=> 'Updated upload settings',

	'FileUploadsSection'		=> 'File Uploads',
	'RegisteredUsers'			=> 'регистрирани потребители',
	'RightToUpload'				=> 'Permissions to upload files:',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belonging to the admins group can upload  files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadMaxFilesize'			=> 'Максимален размер на файла:',
	'UploadMaxFilesizeInfo'		=> 'Максимален размер на всеки файл, ако поставите 0, размера ще се ограничава от настройките на PHP-то.',
	'UploadQuota'				=> 'Обща квота на прикачените файлове:',
	'UploadQuotaInfo'			=> 'Максимален размер на всички прикачени файлове, <code>0</code> е неограничен. %1 used.',
	'UploadQuotaUser'			=> 'Storage quota per user:',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with <code>0</code> being unlimited.',

	'FileTypes'					=> 'Файлови формати',
	'UploadOnlyImages'			=> 'Allow only upload of images:',
	'UploadOnlyImagesInfo'		=> 'Allow only uploading of image files on the page.',
	'AllowedUploadExts'			=> 'Разрешени файлови формати:',
	'AllowedUploadExtsInfo'		=> 'Разрешени разширения за качване на файлове, разделени със запетая, например <code>png, ogg, mp4</code>, в противен случай всички незабранени разширения на файлове са разрешени.<br>Трябва да ограничите списъка с разрешените типове файлове до необходимия минимум, необходим за функционалността на съдържанието на сайта ви.',
	'CheckMimetype'				=> 'Провери прикачените файлове:',
	'CheckMimetypeInfo'			=> 'При някои браузъри може да има проблем с MIME типовете. Тази опция оправя този проблем.',
	'SvgSanitizer'				=> 'SVG sanitizer:',
	'SvgSanitizerInfo'			=> 'Това дава възможност за обработка на качените SVG файлове, за да се предотврати качването на уязвими SVG/XML файлове.',
	'TranslitFileName'			=> 'Транслитериране на имената на файловете:',
	'TranslitFileNameInfo'		=> 'Ако е приложимо и не е необходимо да има символи Unicode, силно препоръчително е да се приемат само алфа-цифрови символи.',
	'TranslitCaseFolding'		=> 'Преобразувайте имената на файловете в малки букви:',
	'TranslitCaseFoldingInfo'	=> 'Тази опция е ефективна само при активна транслитерация.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Създай галерия:',
	'CreateThumbnailInfo'		=> 'Създай галерия за всички възможни ситуации.',
	'JpegQuality'				=> 'Качество на JPEG::',
	'JpegQualityInfo'			=> 'Качество при мащабиране на миниатюра JPEG. То трябва да бъде между 1 и 100, като 100 означава 100% качество.',
	'MaxImageArea'				=> 'Maximum image area:',
	'MaxImageAreaInfo'			=> 'Максималният брой пиксели, които може да има едно изходно изображение. Това осигурява ограничение на използването на паметта от страна на декомпресията на мащабатора на изображения. <br><code>-1</code> означава, че няма да се проверява размерът на изображението, преди да се опита да го мащабира. <code>0</code> означава, че той ще определи стойността автоматично.',
	'MaxThumbWidth'				=> 'Максимална ширина на галерия:',
	'MaxThumbWidthInfo'			=> 'Генерираната галерия няма да превиши ширината тук.',
	'MinThumbFilesize'			=> 'Минимален размер на галерията:',
	'MinThumbFilesizeInfo'		=> 'Не създавайте галерия на изображения по-малки от размера тук.',
	'MaxImageWidth'				=> 'Ограничение на размера на изображението на страниците:',
	'MaxImageWidthInfo'			=> 'Максималната ширина на изображението на страниците, в противен случай се генерира умалена миниатюра.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'List of removed pages, revisions and files.
									Remove or restore the pages, revisions or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Words that will be automatically censored on your Wiki.',
	'FilterSettingsUpdated'		=> 'Updated spam filter settings',

	'WordCensoringSection'		=> 'Word Censoring',
	'SPAMFilter'				=> 'Spam filter:',
	'SPAMFilterInfo'			=> 'Enabling Spam Filter',
	'WordList'					=> 'Word list:',
	'WordListInfo'				=> 'Word or phrase <code>fragment</code> to be blacklisted (one per line)',

	// Log module
	'LogFilterTip'				=> 'Filter events by criteria:',
	'LogLevel'					=> 'Level',
	'LogLevelFilters'	=> [
		'1'		=> 'not less than',
		'2'		=> 'not higher than',
		'3'		=> 'equal',
	],
	'LogNoMatch'				=> 'No events that meet the criteria',
	'LogDate'					=> 'Date',
	'LogEvent'					=> 'Event',
	'LogUsername'				=> 'Username',
	'LogLevels'	=> [
		'1'		=> 'critical',
		'2'		=> 'highest',
		'3'		=> 'high',
		'4'		=> 'medium',
		'5'		=> 'low',
		'6'		=> 'lowest',
		'7'		=> 'debugging',
	],

	// Massemail module
	'MassemailInfo'				=> 'Here you can email a message to either (1) all of your users or (2) all users of a specific group who have enabled receiving of mass emails. An email will be sent out to the administrative email address supplied, with a blind carbon copy (BCC) sent to all recipients. The default setting is to include a maximum of 20 recipients in such an email. If there are more than 20 recipients, additional emails will be sent. If you are emailing a large group of people, please be patient after submitting and do not stop the page halfway through. It is normal for a mass emailing to take a long time. You will be notified when the script has completed.',
	'LogMassemail'				=> 'Mass email send %1 to group / user ',
	'MassemailSend'				=> 'Mass email send',

	'NoEmailMessage'			=> 'Трябва да въведете съобщение.',
	'NoEmailSubject'			=> 'Трябва да въведете заглавие на съобщението си.',
	'NoEmailRecipient'			=> 'You must specify at least one user or user group.',

	'MassemailSection'			=> 'Масов email',
	'MessageSubject'			=> 'Заглавие:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Your message:',
	'YourMessageInfo'			=> 'Please note that you may enter only plaintext. All markup will be removed before sending.',

	'NoUser'					=> 'No user',
	'NoUserGroup'				=> 'No user group',

	'SendToGroup'				=> 'Изпрати на група:',
	'SendToUser'				=> 'Изпрати на потребители:',
	'SendToUserInfo'			=> 'Only users who permit administrators to email them information will receive mass emails. This option is available in their user settings under Notifications.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Updated system message',

	'SysMsgSection'				=> 'System Message',
	'SysMsg'					=> 'System message:',
	'SysMsgInfo'				=> 'Your text here',

	'SysMsgType'				=> 'Type:',
	'SysMsgTypeInfo'			=> 'Message type (CSS).',
	'SysMsgAudience'			=> 'Audience:',
	'SysMsgAudienceInfo'		=> 'Audience the system message is shown to.',
	'EnableSysMsg'				=> 'Enable system message:',
	'EnableSysMsgInfo'			=> 'Show system message.',

	// User approval module
	'ApproveNotExists'			=> 'Please select at least one user via the Set button.',

	'LogUserApproved'			=> 'User ##%1## approved',
	'LogUserBlocked'			=> 'User ##%1## blocked',
	'LogUserDeleted'			=> 'User ##%1## removed from the database',
	'LogUserCreated'			=> 'Created a new user ##%1##',
	'LogUserUpdated'			=> 'Updated User ##%1##',

	'UserApproveInfo'			=> 'Approve new users before they are able to login to the site.',
	'Approve'					=> 'Approve',
	'Deny'						=> 'Deny',
	'Pending'					=> 'Pending',
	'Approved'					=> 'Approved',
	'Denied'					=> 'Denied',

	// DB Backup module
	'BackupStructure'			=> 'Structure',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Folder',
	'BackupTable'				=> 'Table',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'Файлове',
	'BackupNote'				=> 'Забележка:',
	'BackupSettings'			=> 'Specify the desired scheme of backup.<br>' .
    	'The root cluster does not affect the global files backup and cache files backup (if chosen, they are always saved in full).<br>' .  '<br>' .
		'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster, the tables from this backup will not be restructured, same as when backing up only table structure without saving the data. To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Backing up and archiving completed.<br>' .
    	'The Backup package files were stored in the sub-directory %1.<br>. To download it use FTP (maintain the directory structure and file names when copying).<br> To restore a backup copy or remove a package, go to <a href="%2">Restore database</a>.',
	'LogSavedBackup'			=> 'Saved backup database ##%1##',
	'Backup'					=> 'Backup',
	'CantReadFile'				=> 'Can\'t read file %1.',

	// DB Restore module
	'RestoreInfo'				=> 'You can restore any of the backup packages found, or remove them from the server.',
	'ConfirmDbRestore'			=> 'Искате ли да възстановите архивното копиране %1?',
	'ConfirmDbRestoreInfo'		=> 'Моля, изчакайте това може да отнеме няколко минути.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'DirectoryNotExecutable'	=> 'Директорията %1 не е изпълнима.',
	'BackupDelete'				=> 'Сигурни ли сте, че искате да премахнете архивното копие %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Additional restore options:',
	'RestoreOptionsInfo'		=> '* Before restoring the <strong>cluster backup</strong>, ' .
									'the target tables are not deleted (to prevent loss of information from the clusters that have not been backed up). ' .
									'Thus, during the recovery process duplicate records will occur. ' .
									'In normal mode, all of them will be replaced by the records form backup (using SQL <code>REPLACE</code>), ' .
									'but if this checkbox is checked, all duplicates are skipped (the current values of records will be kept), ' .
									'and only the records with new keys are added to the table (SQL <code>INSERT IGNORE</code>).<br>' .
									'<strong>Notice</strong>: When restore complete backup of the site, this option has no value.<br>' .
									'<br>' .
									'** If the backup contains the user files (global and perpage, cache files, etc.), ' .
									'in normal mode they replace the existing files with the same names and are placed in the same directory when being restored. ' .
									'This option allows you to save the current copies of the files and restore from a backup only new files (missing on the server).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignore duplicated table keys (not replace)',
	'IgnoreSameFiles'			=> 'Ignore same files (not overwrite)',
	'NoBackupsAvailable'		=> 'No backups available.',
	'BackupEntireSite'			=> 'Entire site',
	'BackupRestored'			=> 'The backup is restored, a summary report is attached below. To delete this backup package, click',
	'BackupRemoved'				=> 'The selected backup has been successfully removed.',
	'LogRemovedBackup'			=> 'Removed database backup ##%1##',

	'RestoreStarted'			=> 'Initiated Restoration',
	'RestoreParameters'			=> 'Using parameters',
	'IgnoreDuplicatedKeys'		=> 'Ignore duplicated keys',
	'IgnoreDuplicatedFiles'		=> 'Ignore duplicated files',
	'SavedCluster'				=> 'Saved cluster',
	'DataProtection'			=> 'Data Protection - %1 omitted',
	'AssumeDropTable'			=> 'Assume %1',
	'RestoreTableStructure'		=> 'Restoring the structure of the table',
	'RunSqlQueries'				=> 'Perform SQL instructions:',
	'CompletedSqlQueries'		=> 'Completed. Processed instructions:',
	'NoTableStructure'			=> 'The structure of the tables was not saved - skip',
	'RestoreRecords'			=> 'Restore the contents of tables',
	'ProcessTablesDump'			=> 'Just download and process table dumps',
	'Instruction'				=> 'Instruction',
	'RestoredRecords'			=> 'records:',
	'RecordsRestoreDone'		=> 'Completed. Total entries:',
	'SkippedRecords'			=> 'Data not saved - skip',
	'RestoringFiles'			=> 'Restoring files',
	'DecompressAndStore'		=> 'Decompress and store the contents of directories',
	'HomonymicFiles'			=> 'homonymic files',
	'RestoreSkip'				=> 'skip',
	'RestoreReplace'			=> 'replace',
	'RestoreFile'				=> 'Файла:',
	'RestoredFiles'				=> 'restored:',
	'SkippedFiles'				=> 'skipped:',
	'FileRestoreDone'			=> 'Completed. Total files:',
	'FilesAll'					=> 'all:',
	'SkipFiles'					=> 'Files are not stored - skip',
	'RestoreDone'				=> 'RESTORATION COMPLETED',

	'BackupCreationDate'		=> 'Creation Date',
	'BackupPackageContents'		=> 'The contents of the package',
	'BackupRestore'				=> 'Възстановяване',
	'BackupRemove'				=> 'Премахни',
	'RestoreYes'				=> 'Yes',
	'RestoreNo'					=> 'No',
	'LogDbRestored'				=> 'Backup ##%1## of the database restored.',

	'BackupArchived'			=> 'Архивирано е резервно копие %1.',
	'BackupArchiveExists'		=> 'Архивът на резервно копие %1 вече съществува.',
	'LogBackupArchived'			=> 'Архивирано е резервно копие ##%1##.',

	// User module
	'UsersInfo'					=> 'Here you can change your users information and certain specific options.',

	'UsersAdded'				=> 'User added',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> 'Промени',
	'UsersAddNew'				=> 'Add new user',
	'UsersDelete'				=> 'Наистина ли искате да премахнете потребител %1?',
	'UsersDeleted'				=> 'The user %1 was deleted from the database.',
	'UsersRename'				=> 'Rename the user %1 to',
	'UsersRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that user.',
	'UsersUpdated'				=> 'User successfully updated.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Signuptime',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'No users that meet the criteria',

	'UserAccountNotify'			=> 'Уведомяване на потребителя',
	'UserNotifySignup'			=> 'информирайте потребителя за новия акаунт',
	'UserVerifyEmail'			=> 'задайте маркера за потвърждение на имейл и добавете връзка за потвърждаване на имейл',
	'UserReVerifyEmail'			=> 'Re-send email confirm token',

	// Groups module
	'GroupsInfo'				=> 'From this panel you can administrate all your usergroups. You can delete, create and edit existing groups. Furthermore, you may choose group leaders, toggle open/hidden/closed group status and set the group name and description.',

	'LogMembersUpdated'			=> 'Updated usergroup members',
	'LogMemberAdded'			=> 'Added member ##%1## to group ##%2##',
	'LogMemberRemoved'			=> 'Removed member ##%1## from group ##%2##',
	'LogGroupCreated'			=> 'Created a new group ##%1##',
	'LogGroupRenamed'			=> 'Group ##%1## renamed to ##%2##',
	'LogGroupRemoved'			=> 'Removed group ##%1##',

	'GroupsMembersFor'			=> 'Members for Group',
	'GroupsDescription'			=> 'Описание',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Open',
	'GroupsActive'				=> 'Active',
	'GroupsTip'					=> 'Click to edit Group',
	'GroupsUpdated'				=> 'Groups updated',
	'GroupsAlreadyExists'		=> 'This group already exists.',
	'GroupsAdded'				=> 'Group added successfully.',
	'GroupsRenamed'				=> 'Group successfully renamed.',
	'GroupsDeleted'				=> 'The group %1 and all associated pages were deleted from the database.',
	'GroupsAdd'					=> 'Add a new group',
	'GroupsRename'				=> 'Rename the group %1 to',
	'GroupsRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that group.',
	'GroupsDelete'				=> 'Сигурни ли сте, че искате да премахнете група %1?',
	'GroupsDeleteInfo'			=> '* Note: Change will affect all members that are assigned to that group.',
	'GroupsIsSystem'			=> 'The group %1 belongs to the system and cannot be removed.',
	'GroupsStoreButton'			=> 'Save Groups',
	'GroupsEditInfo'			=> 'To edit the groups list select the radio button.',

	'GroupAddMember'			=> 'Add member',
	'GroupRemoveMember'			=> 'Remove Member',
	'GroupAddNew'				=> 'Add group',
	'GroupEdit'					=> 'Edit Group',
	'GroupDelete'				=> 'Remove Group',

	'MembersAddNew'				=> 'Add new member',
	'MembersAdded'				=> 'Added new member to the group successfully.',
	'MembersRemove'				=> 'Are you sure you want to remove member %1?',
	'MembersRemoved'			=> 'The member was removed from the group.',

	// Statistics module
	'DbStatSection'				=> 'Database Statistics',
	'DbTable'					=> 'Table',
	'DbRecords'					=> 'Records',
	'DbSize'					=> 'Size',
	'DbIndex'					=> 'Каталог',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'File system Statistics',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> 'Файлове',
	'FileSize'					=> 'Size',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Version information:',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Values',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Last update',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Server name',
	'WebServer'					=> 'Web server',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'SQL Modes Global',
	'SqlModesSession'			=> 'SQL Modes Session',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memory',
	'UploadFilesizeMax'			=> 'Upload max filesize',
	'PostMaxSize'				=> 'Post max size',
	'MaxExecutionTime'			=> 'Max execution time',
	'SessionPath'				=> 'Session path',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip compression',
	'PhpExtensions'				=> 'PHP extensions',
	'ApacheModules'				=> 'Apache modules',

	// DB repair module
	'DbRepairSection'			=> 'Repair Database',
	'DbRepair'					=> 'Repair Database',
	'DbRepairInfo'				=> 'This script can automatically look for some common database problems and repair them. Repairing can take a while, so please be patient.',

	'DbOptimizeRepairSection'	=> 'Repair and Optimize Database',
	'DbOptimizeRepair'			=> 'Repair and Optimize Database',
	'DbOptimizeRepairInfo'		=> 'This script can also attempt to optimize the database. This improves performance in some situations. Repairing and optimizing the database can take a long time and the database will be locked while optimizing.',

	'TableOk'					=> 'The %1 table is okay.',
	'TableNotOk'				=> 'The %1 table is not okay. It is reporting the following error: %2. This script will attempt to repair this table&hellip;',
	'TableRepaired'				=> 'Successfully repaired the %1 table.',
	'TableRepairFailed'			=> 'Failed to repair the %1 table. <br>Error: %2',
	'TableAlreadyOptimized'		=> 'The %1 table is already optimized.',
	'TableOptimized'			=> 'Successfully optimized the %1 table.',
	'TableOptimizeFailed'		=> 'Failed to optimize the %1 table. <br>Error: %2',
	'TableNotRepaired'			=> 'Some database problems could not be repaired.',
	'RepairsComplete'			=> 'Repairs complete',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Show and fix inconsistencies, delete or assign orphaned records to a new user / value.',
	'Inconsistencies'			=> 'Inconsistencies',
	'CheckDatabase'				=> 'База данни',
	'CheckDatabaseInfo'			=> 'Checks for record inconsistencies in the database.',
	'CheckFiles'				=> 'Файлове',
	'CheckFilesInfo'			=> 'Checks for abandoned files, files with no reference left in the file table.',
	'Records'					=> 'Records',
	'InconsistenciesNone'		=> 'No Data Inconsistencies found.',
	'InconsistenciesDone'		=> 'Data Inconsistencies solved.',
	'InconsistenciesRemoved'	=> 'Removed inconsistencies',
	'Check'						=> 'Check',
	'Solve'						=> 'Solve',

	// Bad Behaviour module
	'BbInfo'					=> 'Detects and blocks unwanted web accesses, deny automated spambots access.<br>For more information, please visit the %1 homepage.',
	'BbEnable'					=> 'Enable Bad Behaviour:',
	'BbEnableInfo'				=> 'All other settings can be changed in the config folder %1.',
	'BbStats'					=> 'Bad Behaviour has blocked %1 access attempts in the last 7 days.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Log',
	'BbSettings'				=> 'Настройки',
	'BbWhitelist'				=> 'Whitelist',

	// --> Log
	'BbHits'					=> 'Hits',
	'BbRecordsFiltered'			=> 'Displaying %1 of %2 records filtered by',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Blocked',
	'BbPermitted'				=> 'Permitted',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Displaying all %1 records',
	'BbShow'					=> 'Show',
	'BbIpDateStatus'			=> 'IP/Date/Status',
	'BbHeaders'					=> 'Headers',
	'BbEntity'					=> 'Entity',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Options saved.',
	'BbWhitelistHint'			=> 'Inappropriate whitelisting WILL expose you to spam, or cause Bad Behaviour to stop functioning entirely! DO NOT WHITELIST unless you are 100% CERTAIN that you should.',
	'BbIpAddress'				=> 'IP Address',
	'BbIpAddressInfo'			=> 'IP address or CIDR format address ranges to be whitelisted (one per line)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL fragments beginning with the / after your web site hostname (one per line)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'User agent strings to be whitelisted (one per line)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Updated Bad Behaviour settings',
	'BbLogRequest'				=> 'Logging HTTP request',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (recommended)',
	'BbLogOff'					=> 'Do not log (not recommended)',
	'BbSecurity'				=> 'Security',
	'BbStrict'					=> 'Strict checking',
	'BbStrictInfo'				=> 'blocks more spam but may block some people',
	'BbOffsiteForms'			=> 'Allow form postings from other web sites',
	'BbOffsiteFormsInfo'		=> 'required for OpenID; increases spam received',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'To use Bad Behaviour\'s http:BL features you must have an %1',
	'BbHttpblKey'				=> 'http:BL Access Key',
	'BbHttpblThreat'			=> 'Minimum Threat Level (25 is recommended)',
	'BbHttpblMaxage'			=> 'Maximum Age of Data (30 is recommended)',
	'BbReverseProxy'			=> 'Reverse Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'If you are using Bad Behaviour behind a reverse proxy, load balancer, HTTP accelerator, content cache or similar technology, enable the Reverse Proxy option.<br>' .
									'If you have a chain of two or more reverse proxies between your server and the public Internet, you must specify <em>all</em> of the IP address ranges (in CIDR format) of all of your proxy servers, load balancers, etc. Otherwise, Bad Behaviour may be unable to determine the client\'s true IP address.<br>' .
									'In addition, your reverse proxy servers must set the IP address of the Internet client from which they received the request in an HTTP header. If you don\'t specify a header, %1 will be used. Most proxy servers already support X-Forwarded-For and you would then only need to ensure that it is enabled on your proxy servers. Some other header names in common use include %2 and %3.',
	'BbReverseProxyEnable'		=> 'Enable Reverse Proxy',
	'BbReverseProxyHeader'		=> 'Header containing Internet clients IP address',
	'BbReverseProxyAddresses'	=> 'IP address or CIDR format address ranges for your proxy servers (one per line)',

];
