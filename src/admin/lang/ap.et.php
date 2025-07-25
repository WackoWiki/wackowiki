<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Basic functions',
		'preferences'	=> 'Preferences',
		'content'		=> 'Sisu',
		'users'			=> 'Kasutajad',
		'maintenance'	=> 'Hooldamine',
		'messages'		=> 'Sõnumid',
		'extension'		=> 'Extension',
		'database'		=> 'Andmebaas',
	],

	// Admin panel
	'AdminPanel'				=> 'Administraatori juhtpaneel',
	'RecoveryMode'				=> 'Taasterežiim',
	'Authorization'				=> 'Authorization',
	'AuthorizationTip'			=> 'Please enter the administrative password (make also sure that cookies are allowed in your browser).',
	'NoRecoveryPassword'		=> 'Administratiivset parooli ei ole määratud!',
	'NoRecoveryPasswordTip'		=> 'Märkus: Administratiivse parooli puudumine on oht turvalisusele! Sisestage konfiguratsioonifaili oma parooli hash ja käivitage programm uuesti.',

	'ErrorLoadingModule'		=> 'Error loading admin module %1: does not exists.',

	'ApHomePage'				=> 'KoduLeht',
	'ApHomePageTip'				=> 'open the home page, you do not quit administration',
	'ApLogOut'					=> 'Logi välja',
	'ApLogOutTip'				=> 'quit system administration',

	'TimeLeft'					=> 'Time left:  %1 minutes',
	'ApVersion'					=> 'versioon',

	'SiteOpen'					=> 'Ava',
	'SiteOpened'				=> 'site opened',
	'SiteOpenedTip'				=> 'The site is open',
	'SiteClose'					=> 'Sulge',
	'SiteClosed'				=> 'site closed',
	'SiteClosedTip'				=> 'The site is closed',

	'System'					=> 'Süsteem',

	// Generic
	'Cancel'					=> 'Loobun',
	'Add'						=> 'Lisama',
	'Edit'						=> 'Muuda',
	'Remove'					=> 'Eemalda',
	'Enabled'					=> 'Lubatud',
	'Disabled'					=> 'Keelatud',
	'Mandatory'					=> 'Kohustuslik',
	'Admin'						=> 'Admin',
	'Min'						=> 'Min.',
	'Max'						=> 'Maks.',

	'MiscellaneousSection'		=> 'Varia',
	'MainSection'				=> 'Basic Parameters',

	'DirNotWritable'			=> 'Kaust %1 pole kirjutatav.',
	'FileNotWritable'			=> 'Fail %1 ei ole kirjutatav.',

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
		'name'		=> 'Välimus',
		'title'		=> 'Appearance settings',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-post',
		'title'		=> 'E-posti seaded',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Syndication',
		'title'		=> 'Syndication settings',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtreeri',
		'title'		=> 'Filter settings',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'Formatting options',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Teated',
		'title'		=> 'Notifications settings',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Leheküljed',
		'title'		=> 'Pages and site parameters',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Õigused',
		'title'		=> 'Permissions settings',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Turvalisus',
		'title'		=> 'Security subsystems settings',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Süsteem',
		'title'		=> 'System options',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Üleslaadimine',
		'title'		=> 'Attachment settings',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Deleted',
		'title'		=> 'Newly deleted content',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menüü',
		'title'		=> 'Add, edit or remove default menu items',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Varukoopia',
		'title'		=> 'Backing up data',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Paranda',
		'title'		=> 'Repair and Optimize Database',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Taasta',
		'title'		=> 'Restoring backup data',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Peamenüü',
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
		'name'		=> 'Mass email',
		'title'		=> 'Mass email',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Süsteemiteade',
		'title'		=> 'System messages',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Süsteemi Info',
		'title'		=> 'Süsteemi informatsioon',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System log',
		'title'		=> 'Log of system events',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistika',
		'title'		=> 'Kuva statistika',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Bad Behaviour',
		'title'		=> 'Bad Behaviour',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Kiida heaks',
		'title'		=> 'User registration approval',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Grupid',
		'title'		=> 'Group management',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Kasutajad',
		'title'		=> 'Kasutajate haldus',
	],

	// Main module
	'MainNote'					=> 'Note: Before the administration of technical activities strongly are encouraged to block access to the site!',

	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the auth_token table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Updated basic settings',
	'LogBasicSettingsUpdated'	=> 'Updated basic settings',

	'SiteName'					=> 'Site Name:',
	'SiteNameInfo'				=> 'The title of this site, appears on browser title, theme header, email-notification, etc.',
	'SiteDesc'					=> 'Site Description:',
	'SiteDescInfo'				=> 'Supplement to the title of the site that appears in the pages header to explain in a few words, what this site is about.',
	'AdminName'					=> 'Admin of Site:',
	'AdminNameInfo'				=> 'User name, which is responsible for overall support of the site. This name is not used to determine access rights, but it is desirable to conform to the name of the chief administrator of the site.',

	'LanguageSection'			=> 'Keel',
	'DefaultLanguage'			=> 'Default language:',
	'DefaultLanguageInfo'		=> 'Specifies the language of messages displayed to unregistered guests, as well as the locale settings.',
	'MultiLanguage'				=> 'Mitmekeelsuse tugi:',
	'MultiLanguageInfo'			=> 'Enable the ability to select a language on a page-by-page basis.',
	'AllowedLanguages'			=> 'Lubatud keeled:',
	'AllowedLanguagesInfo'		=> 'It is recommended to select only the set of languages you want to use, other wise all languages are selected.',

	'CommentSection'			=> 'Kommentaarid',
	'AllowComments'				=> 'Luba kommentaarid:',
	'AllowCommentsInfo'			=> 'Enable comments for guest or registered users only or disable them on the entire site.',
	'SortingComments'			=> 'Sorting comments:',
	'SortingCommentsInfo'		=> 'Changes the order the page comments are presented, either with the most recent OR the oldest comment at the top.',
	'CommentsOffset'			=> 'Comments page:',
	'CommentsOffsetInfo'		=> 'Comments page to display by default',

	'ToolbarSection'			=> 'Tööriistariba',
	'CommentsPanel'				=> 'Comments panel:',
	'CommentsPanelInfo'			=> 'The default display of comments in the bottom of the page.',
	'FilePanel'					=> 'File panel:',
	'FilePanelInfo'				=> 'The default display of attachments in the bottom of the page.',
	'TagsPanel'					=> 'Tags panel:',
	'TagsPanelInfo'				=> 'The default display of the tags panel in the bottom of the page.',

	'NavigationSection'			=> 'Navigeerimine',
	'ShowPermalink'				=> 'Show Permalink:',
	'ShowPermalinkInfo'			=> 'The default display of the permalink for the current version of the page.',
	'TocPanel'					=> 'Table of contents panel:',
	'TocPanelInfo'				=> 'The default display table of contents panel of a page (may need support in the templates).',
	'SectionsPanel'				=> 'Sections panel:',
	'SectionsPanelInfo'			=> 'By default display the panel of adjacent pages (requires support in the templates).',
	'DisplayingSections'		=> 'Displaying sections:',
	'DisplayingSectionsInfo'	=> 'When the previous options, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>) or both, and other (<em>tree</em>).',
	'MenuItems'					=> 'Menu items:',
	'MenuItemsInfo'				=> 'Default number of shown menu items (may need support in the templates).',

	'HandlerSection'			=> 'Handler',
	'HideRevisions'				=> 'Hide Revisions:',
	'HideRevisionsInfo'			=> 'The default display of revisions of the page.',
	'AttachmentHandler'			=> 'Enable attachments handler:',
	'AttachmentHandlerInfo'		=> 'Allows to show the attachments handler.',
	'SourceHandler'				=> 'Enable source handler:',
	'SourceHandlerInfo'			=> 'Allows to show the source handler.',
	'ExportHandler'				=> 'Enable XML export handler:',
	'ExportHandlerInfo'			=> 'Allows to show the XML export handler.',

	'DiffModeSection'			=> 'Diff Modes',
	'DefaultDiffModeSetting'	=> 'Vaikimisi võrdlusrežiim:',
	'DefaultDiffModeSettingInfo'=> 'Preselected diff mode.',
	'AllowedDiffMode'			=> 'Allowed Diff modes:',
	'AllowedDiffModeInfo'		=> 'It is recommended to select only the set of diff modes you want to use, other wise all diff modes are selected.',
	'NotifyDiffMode'			=> 'Notify diff mode:',
	'NotifyDiffModeInfo'		=> 'Diff mode used for notifications in the email body.',

	'EditingSection'			=> 'Muutmine',
	'EditSummary'				=> 'Redigeeri kokkuvõte:',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Pisimuudatus:',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'SectionEdit'				=> 'Sektsiooni redigeerimine:',
	'SectionEditInfo'			=> 'Võimaldab redigeerida ainult lehekülje osa.',
	'ReviewSettings'			=> 'Review:',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',
	'PublishAnonymously'		=> 'Allow anonymous publishing:',
	'PublishAnonymouslyInfo'	=> 'Allow users to published preferably anonymously (to hide the name).',

	'DefaultRenameRedirect'		=> 'When renaming put redirection:',
	'DefaultRenameRedirectInfo'	=> 'By default, offer to set a redirect to the old address of the page being renamed.',
	'StoreDeletedPages'			=> 'Keep deleted pages:',
	'StoreDeletedPagesInfo'		=> 'When you delete a page, a comment or a file, keep it in a special section, where it will be available for review and recovery for some more time (as described below).',
	'KeepDeletedTime'			=> 'Storage time of deleted pages:',
	'KeepDeletedTimeInfo'		=> 'The period in days. It makes sense only with the previous option. Zero indicates the eternal possession (in this case the administrator can clear the "cart" manually).',
	'PagesPurgeTime'			=> 'Storage time of page revisions:',
	'PagesPurgeTimeInfo'		=> 'Automatically deletes the older versions within the given number of days. If you enter zero, the older versions will not be removed.',
	'EnableReferrers'			=> 'Enable Referrers:',
	'EnableReferrersInfo'		=> 'Allows to store and show external referrers.',
	'ReferrersPurgeTime'		=> 'Storage time of referrers:',
	'ReferrersPurgeTimeInfo'	=> 'Hoidke välistele lehtedele viitamise ajalugu kauem kui etteantud arv päevi. Null tähendab igavest salvestust, kuid aktiivselt külastatud saidi korral võib see põhjustada andmebaasi ületäitumist.',
	'EnableCounters'			=> 'Hit Counters:',
	'EnableCountersInfo'		=> 'Allows per page hit counters and enables display of simple statistics. Views of the page owner are not counted.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Control default web syndication settings for your site.',
	'SyndicationSettingsUpdated'	=> 'Updated syndication settings.',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Enable feeds:',
	'EnableFeedsInfo'			=> 'Lülitab kogu viki RSS-kanalid sisse või välja.',
	'XmlChangeLink'				=> 'Changes feed link mode:',
	'XmlChangeLinkInfo'			=> 'Defines where the XML Changes feed items links to.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'difference view',
		'2'		=> 'the revised page',
		'3'		=> 'list of revisions',
		'4'		=> 'the current page',
	],

	'XmlSitemap'				=> 'XML Sitemap:',
	'XmlSitemapInfo'			=> 'Creates an XML file called %1 inside the xml folder. You can add the path to the sitemap in the robots.txt file in your root directory as follows:',
	'XmlSitemapGz'				=> 'XML Sitemap compression:',
	'XmlSitemapGzInfo'			=> 'If you would like, you may compress your Sitemap text file using gzip to reduce your bandwidth requirement.',
	'XmlSitemapTime'			=> 'XML Sitemap generation time:',
	'XmlSitemapTimeInfo'		=> 'Genereerib saidikaardi ainult üks kord antud päevade arv, null tähendab iga lehe muutmise korral.',

	'SearchSection'				=> 'Otsi',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Loob OpenSearchi kirjeldusfaili XML-kaustas ja lubab otsinguplugina automaatse avastamise HTML-pealkirjas.',
	'SearchEngineVisibility'	=> 'Block search engines (Search Engine Visibility):',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site, it is up to search engines to honor this request.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Control default display settings for your site.',
	'AppearanceSettingsUpdated'	=> 'Updated appearance settings.',

	'LogoOff'					=> 'Off',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo ja pealkiri',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Site Logo:',
	'SiteLogoInfo'				=> 'Your logo will appear typically at the top left corner of the application. Max size is 2 MiB. Optimal dimensions are 255 pixels wide by 55 pixels high.',
	'LogoDimensions'			=> 'Logo dimensions:',
	'LogoDimensionsInfo'		=> 'Width and height of the displayed Logo.',
	'LogoDisplayMode'			=> 'Logo display mode:',
	'LogoDisplayModeInfo'		=> 'Defines the appearance of the Logo. Default is off.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site Favicon:',
	'SiteFaviconInfo'			=> 'Your shortcut icon, or favicon, is displayed in the address bar, tabs and bookmarks of most browsers. This will override the favicon of your theme.',
	'SiteFaviconTooBig'			=> 'Favicon on suurem kui 64 × 64px.',
	'ThemeColor'				=> 'Aadressiriba teemavärv:',
	'ThemeColorInfo'			=> 'Brauser määrab iga lehe aadressiriba värvi vastavalt esitatud CSS-värvile.',

	'LayoutSection'				=> 'Paigutus',
	'Theme'						=> 'Teema:',
	'ThemeInfo'					=> 'Template design the site uses by default.',
	'ResetUserTheme'			=> 'Reset all user themes:',
	'ResetUserThemeInfo'		=> 'Resets all user themes. Warning: This action will revert all user-selected themes to the global default theme.',
	'SetBackUserTheme'			=> 'Revert all user themes to %1 theme.',
	'ThemesAllowed'				=> 'Allowed Themes:',
	'ThemesAllowedInfo'			=> 'Select the allowed themes, which the user can choose, otherwise all available themes are allowed.',
	'ThemesPerPage'				=> 'Themes per page:',
	'ThemesPerPageInfo'			=> 'Allow themes per page, which the page owner can choose via page properties.',

	// System settings
	'SystemSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'SystemSettingsUpdated'		=> 'Updated system settings',

	'DebugModeSection'			=> 'Debug mode',
	'DebugMode'					=> 'Debug mode:',
	'DebugModeInfo'				=> 'Fixation and the withdrawal of telemetry data on the time of the program. Note: the full detail of the regime imposes high demands on available memory, especially in demanding operations such as backup and restore the database.',
	'DebugModes'	=> [
		'0'		=> 'debugging is off',
		'1'		=> 'only the total execution time',
		'2'		=> 'full-time',
		'3'		=> 'full detail (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Threshold performance RDBMS:',
	'DebugSqlThresholdInfo'		=> 'In the detailed debug mode to record only the queries take longer than the number of seconds.',
	'DebugAdminOnly'			=> 'Closed diagnosis:',
	'DebugAdminOnlyInfo'		=> 'Show debug data of the program (and DBMS) only for the administrator.',

	'CachingSection'			=> 'Caching Options',
	'Cache'						=> 'Cache rendered pages:',
	'CacheInfo'					=> 'Save rendered pages in the local cache to speed up the subsequent boot. Valid only for unregistered visitors.',
	'CacheTtl'					=> 'Term relevance cached pages:',
	'CacheTtlInfo'				=> 'Cache pages no more than a specified number of seconds.',
	'CacheSql'					=> 'Cache DBMS queries:',
	'CacheSqlInfo'				=> 'Maintain a local cache the results of certain resource-SQL-queries.',
	'CacheSqlTtl'				=> 'Term relevance Cache Database:',
	'CacheSqlTtlInfo'			=> 'Cache results of SQL-queries for no more than the specified number of seconds. Using the values of more than 1200 is not desirable.',

	'LogSection'				=> 'Log settings',
	'LogLevelUsage'				=> 'Using logging:',
	'LogLevelUsageInfo'			=> 'The minimum priority of the events recorded in the log.',
	'LogThresholds'	=> [
		'0'		=> 'not keep a journal',
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high',
		'4'		=> 'keskmiselt',
		'5'		=> 'from low',
		'6'		=> 'the minimum level',
		'7'		=> 'record all',
	],
	'LogDefaultShow'			=> 'Display Log Mode:',
	'LogDefaultShowInfo'		=> 'The minimum priority events displayed in the log by default.',
	'LogModes'	=> [
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high-level',
		'4'		=> 'keskmine',
		'5'		=> 'from a low',
		'6'		=> 'from the minimum level',
		'7'		=> 'näita kõiki',
	],
	'LogPurgeTime'				=> 'Storage time of Log:',
	'LogPurgeTimeInfo'			=> 'Remove event log over a given number of days.',

	'PrivacySection'			=> 'Privaatsus',
	'AnonymizeIp'				=> 'Anonymize users IP addresses:',
	'AnonymizeIpInfo'			=> 'Anonymize IP addresses where applicable like page, revision or referrers.',

	'ReverseProxySection'		=> 'Reverse Proxy',
	'ReverseProxy'				=> 'Use Reverse proxy:',
	'ReverseProxyInfo'			=> 'Enable this setting to determine the correct IP address of the remote
									 client by examining information stored in the X-Forwarded-For headers.
									 X-Forwarded-For headers are a standard mechanism for identifying client
									 systems connecting through a reverse proxy server, such as Squid or
									 Pound. Reverse proxy servers are often used to enhance the performance
									 of heavily visited sites and may also provide other site caching,
									 security or encryption benefits. If this WackoWiki installation operates
									 behind a reverse proxy, this setting should be enabled so that correct
									 IP address information is captured in WackoWiki\'s session management,
									 logging, statistics and access management systems; if you are unsure
									 about this setting, do not have a reverse proxy, or WackoWiki operates in
									 a shared hosting environment, this setting should remain disabled.',
	'ReverseProxyHeader'		=> 'Reverse proxy header:',
	'ReverseProxyHeaderInfo'	=> 'Määrake see väärtus, kui teie proxy-server saadab kliendi IP-aadressi muus päises
									kui X-Forwarded-For. Pealkiri "X-Forwarded-For" on koma + tühikuga eraldatud IP-aadresside
									nimekiri, millest kasutatakse ainult viimast (vasakpoolseimat).',
	'ReverseProxyAddresses'		=> 'reverse_proxy accepts an array of IP addresses:',
	'ReverseProxyAddressesInfo'	=> 'Each element of this array is the IP address of any of your reverse
									 proxies. Filling this array WackoWiki will trust the information stored
									 in the X-Forwarded-For headers only if Remote IP address is one of
									 these, that is the request reaches the web server from one of your
									 reverse proxies. Otherwise, the client could directly connect to
									 your web server spoofing the X-Forwarded-For headers.',

	'SessionSection'				=> 'Session handling',
	'SessionStorage'				=> 'Session storage:',
	'SessionStorageInfo'			=> 'This option defines where the the session data is stored. By default either file or database session storage is selected.',
	'SessionModes'	=> [
		'1'		=> 'Fail',
		'2'		=> 'Andmebaas',
	],
	'SessionNotice'					=> 'Näita seansi lõpetamise põhjust:',
	'SessionNoticeInfo'				=> 'Näitab sessiooni lõpetamise põhjust.',
	'LoginNotice'					=> 'Sisselogimise teade:',
	'LoginNoticeInfo'				=> 'Kuvab sisselogimise teate.',

	'RewriteMode'					=> 'Use <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'If your web server supports this feature, turn to get "beautiful" the addresses of pages.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parameters responsible for Access control and permissions.',
	'PermissionsSettingsUpdated'	=> 'Updated permissions settings',

	'PermissionsSection'		=> 'Rights and privileges',
	'ReadRights'				=> 'Read rights by default:',
	'ReadRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'WriteRights'				=> 'Write rights by default:',
	'WriteRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'CommentRights'				=> 'Comment rights by default:',
	'CommentRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'CreateRights'				=> 'Create rights of a sub page by default:',
	'CreateRightsInfo'			=> 'Define the right for creating root pages and assign them to pages for which parental rights cannot be defined.',
	'UploadRights'				=> 'Upload rights by default:',
	'UploadRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'RenameRights'				=> 'Global rename right:',
	'RenameRightsInfo'			=> 'The list of permissions to freely rename (move) pages.',

	'LockAcl'					=> 'Lock all ACL to read only:',
	'LockAclInfo'				=> '<span class="cite">Overwrites the acl settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period for security reasons or as a emergency response.',
	'HideLocked'				=> 'Hide inaccessible pages:',
	'HideLockedInfo'			=> 'If the user does not have permission to read the page, hide it in different page lists (however the link placed in text, will still be visible).',
	'RemoveOnlyAdmins'			=> 'Only administrators can delete pages:',
	'RemoveOnlyAdminsInfo'		=> 'Deny all, except administrators, to delete pages. In the first limit applies to owners of normal pages.',
	'OwnersRemoveComments'		=> 'Owners of pages can delete comments:',
	'OwnersRemoveCommentsInfo'	=> 'Allow page owners to moderate comments on their pages.',
	'OwnersEditCategories'		=> 'Owners can edit page categories:',
	'OwnersEditCategoriesInfo'	=> 'Allow owners to modify the pages category list of your site (add words, delete words), assigns to a page.',
	'TermHumanModeration'		=> 'Term human moderation:',
	'TermHumanModerationInfo'	=> 'Moderaatorid saavad kommentaare redigeerida ainult siis, kui need on loodud ainult mitu päeva tagasi (see piirang ei kehti teema viimase kommentaari kohta).',

	'UserCanDeleteAccount'		=> 'Luba kasutajatel kustuta oma konto',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parameters responsible for the overall safety of the platform, safety restrictions and additional security subsystems.',
	'SecuritySettingsUpdated'	=> 'Updated security settings',

	'AllowRegistration'			=> 'Register online:',
	'AllowRegistrationInfo'		=> 'Avage kasutaja registreerimine. Selle valiku keelamine takistab tasuta registreerimist, kuid saidi administraator saab teised kasutajad ise registreerida.',
	'ApproveNewUser'			=> 'Approve new users:',
	'ApproveNewUserInfo'		=> 'Allows Administrators to approve users once they register. Only approved users will be allowed to log in the site.',
	'PersistentCookies'			=> 'Persistent cookies:',
	'PersistentCookiesInfo'		=> 'Allow persistent cookies.',
	'DisableWikiName'			=> 'Disable WikiName:',
	'DisableWikiNameInfo'		=> 'Disable the the mandatory use of WikiName. Allows to register users with traditional nicknames, not forced NameSurname.',
	'UsernameLength'			=> 'Username length:',
	'UsernameLengthInfo'		=> 'Minimum and maximum number of characters in usernames.',

	'EmailSection'				=> 'E-post',
	'AllowEmailReuse'			=> 'Allow email address re-use:',
	'AllowEmailReuseInfo'		=> 'Different users can register with the same e-mail address.',
	'EmailConfirmation'			=> 'Jõustada e-posti kinnitus:',
	'EmailConfirmationInfo'		=> 'Nõuab kasutajalt oma e-posti aadressi kinnitamist enne sisselogimist.',
	'AllowedEmailDomains'		=> 'Lubatud e-posti domeenid:',
	'AllowedEmailDomainsInfo'	=> 'Lubatud e-posti domeenid komadega eraldatud, nt <code>example.com, local.lan</code> jne, muidu on lubatud kõik e-posti domeenid.',
	'ForbiddenEmailDomains'		=> 'Keelatud e-posti domeenid:',
	'ForbiddenEmailDomainsInfo'	=> 'Keelatud e-posti domeenid komadega eraldatud, nt <code>example.com, local.lan</code> jne. (ainult siis, kui lubatud e-posti domeenide nimekiri on tühi)',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Enable Captcha:',
	'EnableCaptchaInfo'			=> 'If enabled, Captcha will be shown in the following cases or if a security threshold is reached.',
	'CaptchaComment'			=> 'Uus kommentaar:',
	'CaptchaCommentInfo'		=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before posting the comment.',
	'CaptchaPage'				=> 'Uus leht:',
	'CaptchaPageInfo'			=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before creating a new pages.',
	'CaptchaEdit'				=> 'Muuda lehte:',
	'CaptchaEditInfo'			=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before editing pages.',
	'CaptchaRegistration'		=> 'Registreerimine:',
	'CaptchaRegistrationInfo'	=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before registering.',

	'TlsSection'				=> 'TLS Settings',
	'TlsConnection'				=> 'TLS-Connection:',
	'TlsConnectionInfo'			=> 'Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS-certificate on the server, otherwise you will lose access to the admin panel!</span><br>It also determines if the the Cookie Secure Flag is set, the <code>secure</code> flag specifies whether cookies should only be sent over secure connections.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Forcibly reconnect the client from HTTP to HTTPS. With the option disabled, the client can browse the site through an open HTTP channel.',

	'HttpSecurityHeaders'		=> 'HTTP Security Headers',
	'EnableSecurityHeaders'		=> 'Enable Security Headers:',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk !',
	'Csp'						=> 'Content-Security-Policy (CSP):',
	'CspInfo'					=> 'Configuring Content Security Policy involves deciding what policies you want to enforce, and then configuring them and using Content-Security-Policy to establish your policy.',
	'PolicyModes'	=> [
		'0'		=> 'keelatud',
		'1'		=> 'range',
		'2'		=> 'kohandatud',
	],
	'PermissionsPolicy'			=> 'Permissions Policy:',
	'PermissionsPolicyInfo'		=> 'The HTTP Permissions-Policy header provides a mechanism to explicitly enable or disable various powerful browser features.',
	'ReferrerPolicy'			=> 'Referrer Policy:',
	'ReferrerPolicyInfo'		=> 'The Referrer-Policy HTTP header governs which referrer information, sent in the Referer header, should be included with requests made.',
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

	'UserPasswordSection'		=> 'Persistence of user passwords',
	'PwdMinChars'				=> 'Minimum password length:',
	'PwdMinCharsInfo'			=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 12 to 16 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'AdminPwdMinChars'			=> 'Minimum Admin password length:',
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

	'LoginSection'				=> 'Logi sisse',
	'MaxLoginAttempts'			=> 'Maximum number of login attempts per username:',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximum number of login attempts per IP address:',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'FormsSection'				=> 'Forms',
	'FormTokenTime'				=> 'Maximum time to submit forms:',
	'FormTokenTimeInfo'			=> 'Aeg, mille jooksul kasutaja peab vormi esitama (sekundites). <br> Pange tähele, et vorm võib seansi lõppedes kehtetuks muutuda, olenemata sellest sättest.',

	'SessionLength'				=> 'Term login cookie:',
	'SessionLengthInfo'			=> 'The lifetime of the user cookie login by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments:',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of the new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications:',
	'IntercomDelayInfo'			=> 'The minimum delay between sending a private message user connection (in seconds).',
	'RegistrationDelay'			=> 'Time threshold for registering:',
	'RegistrationDelayInfo'		=> 'The minimum time threshold for filling out the registration form to tell away bots from humans (in seconds).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'FormatterSettingsUpdated'	=> 'Updated formatting settings',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> 'Typographical Proofreader:',
	'TypograficaInfo'			=> 'Unsetting slightly speed up the process of adding comments and save the page.',
	'Paragrafica'				=> 'Paragrafica markings:',
	'ParagraficaInfo'			=> 'Similar to the previous option, but will lead to disconnection of inoperable automatic table of contents: <code>{{toc}}</code>.',
	'AllowRawhtml'				=> 'Global HTML Support:',
	'AllowRawhtmlInfo'			=> 'This option is potentially unsafe for an open site.',
	'SafeHtml'					=> 'Filtering HTML:',
	'SafeHtmlInfo'				=> 'Prevents saving of dangerous HTML-objects. Turning off the filter on an open site with HTML support is <span class="underline">extremely</span> undesirable!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formatter)',
	'X11colors'					=> 'X11 Colors Usage:',
	'X11colorsInfo'				=> 'Extents the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code>Unsetting slightly speeds up the process of adding comments and saving of pages.',
	'WikiLinks'					=> 'Disable Wikilinks:',
	'WikiLinksInfo'				=> 'Lülitab <code>CamelCaseWords</code> linkimise välja, teie CamelCase Words ei linki enam otse uuele lehele. See on kasulik, kui töötate erinevates nimeruumides aks klastrites. Vaikimisi on see välja lülitatud.',
	'BracketsLinks'				=> 'Disable bracketslinks:',
	'BracketsLinksInfo'			=> 'Disables <code>[[link]]</code> and <code>((link))</code> syntax.',
	'Formatters'				=> 'Disable Formatters:',
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
	'Timezone'					=> 'Ajatsoon:',
	'TimezoneInfo'				=> 'Ajavöönd, mida kasutatakse kellaaegade kuvamiseks kasutajatele, kes ei ole sisse logitud (külalised). Sisselogitud kasutajad määravad ja saavad oma ajavööndit muuta oma kasutaja seadetes.',
	'AmericanDate'					=> 'Ameerika kuupäev:',
	'AmericanDateInfo'				=> 'Kasutab inglise keele vaikimisi ameerika kuupäevavormingut.',

	'Canonical'					=> 'Kasutage täielikult kanoonilisi URL-e:',
	'CanonicalInfo'				=> 'Kõik lingid luuakse absoluutsete URL-idena kujul %1. Eelistada tuleks URL-e serveri juure suhtes vormis %2.',
	'LinkTarget'				=> 'Where external links open:',
	'LinkTargetInfo'			=> 'Avab iga välise lingi uues brauseriaknas. Lisab lingi süntaksile <code>target="_blank"</code>.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Requires that the browser should not send an HTTP referer header if the user follows the hyperlink. Adds <code>rel="noreferrer"</code> to the link syntax.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Juhendage mõnda otsimootorit, et hüperlink ei tohiks mõjutada linkide sihtimist otsingumootorite registris. Lisab lingi süntaksisse <code>rel="nofollow"</code>.',
	'UrlsUnderscores'			=> 'Form addresses (URLs) with underscores:',
	'UrlsUnderscoresInfo'		=> 'For example %1 becames %2 with this option.',
	'ShowSpaces'				=> 'Näita WikiNimedes tühikuid:',
	'ShowSpacesInfo'			=> 'Show spaces in WikiNames, e.g. <code>MyName</code> being displayed as <code>My Name</code> with this option.',
	'NumerateLinks'				=> 'Numerate links in print view:',
	'NumerateLinksInfo'			=> 'Numerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disable and visualize self-referencing links:',
	'YouareHereTextInfo'		=> 'Visualizing links to the same page, try to <code>&lt;b&gt;####&lt;/b&gt;</code>, all links-to-self became not links, but bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Siin saate seadistada või muuta Vikis kasutatavaid süsteemi baaslehti. Veenduge, et te ei unustaks Wiki vastavate lehtede loomist ega nende muutmist vastavalt teie seadetele siin.',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Number of items per list:',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster Forum:',
	'ForumClusterInfo'			=> 'Root cluster for forum section (action %1).',
	'ForumTopics'				=> 'Number of topics per page:',
	'ForumTopicsInfo'			=> 'Number of topics displayed on each page of the list in the forum sections (action %1).',
	'CommentsCount'				=> 'Number of comments per page:',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page list of comments. This applies to all the comments on the site, and not just posted in the forum.',

	'NewsSection'				=> 'Section News',
	'NewsCluster'				=> 'Cluster for the News:',
	'NewsClusterInfo'			=> 'Root cluster for news section (action %1).',
	'NewsStructure'				=> 'News cluster structure:',
	'NewsStructureInfo'			=> 'Stores the articles optionally in sub-clusters by year/month or week (e.g. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Litsents',
	'DefaultLicense'			=> 'Vaikimisi litsents:',
	'DefaultLicenseInfo'		=> 'Under which license should your content be released.',
	'EnableLicense'				=> 'Enable License:',
	'EnableLicenseInfo'			=> 'Enable to show license information.',
	'LicensePerPage'			=> 'License per page:',
	'LicensePerPageInfo'		=> 'Allow license per page, which the page owner can choose via page properties.',

	'ServicePagesSection'		=> 'Service pages',
	'RootPage'					=> 'Home page:',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',

	'PrivacyPage'				=> 'Andmekaitse:',
	'PrivacyPageInfo'			=> 'The page with the Privacy Policy of the site.',

	'TermsPage'					=> 'Policies and Regulations:',
	'TermsPageInfo'				=> 'The page with the rules of the site.',

	'SearchPage'				=> 'Otsi:',
	'SearchPageInfo'			=> 'Page with the search form (action %1).',
	'RegistrationPage'			=> 'Registreerimine:',
	'RegistrationPageInfo'		=> 'Page new user registration (action %1).',
	'LoginPage'					=> 'Kasutajanimi:',
	'LoginPageInfo'				=> 'Login page on the site (action %1).',
	'SettingsPage'				=> 'Kasutaja Seaded:',
	'SettingsPageInfo'			=> 'Page customize the user profile (action %1).',
	'PasswordPage'				=> 'Muuda Parooli:',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action %1).',
	'UsersPage'					=> 'User list:',
	'UsersPageInfo'				=> 'Page with a list of registered users (action %1).',
	'CategoryPage'				=> 'Kategooria:',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action %1).',
	'GroupsPage'				=> 'Grupid:',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action %1).',
	'ChangesPage'				=> 'Viimased muudatused:',
	'ChangesPageInfo'			=> 'Page with a list of the last modified pages (action %1).',
	'CommentsPage'				=> 'Viimased kommentaarid:',
	'CommentsPageInfo'			=> 'Page with a list of recent comment on the page (action %1).',
	'RemovalsPage'				=> 'Deleted pages:',
	'RemovalsPageInfo'			=> 'Page with a list of recently deleted pages (action %1).',
	'WantedPage'				=> 'Wanted pages:',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action %1).',
	'OrphanedPage'				=> 'Orphaned pages:',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related links with the rest (action %1).',
	'SandboxPage'				=> 'Liivakast:',
	'SandboxPageInfo'			=> 'Page where users can be trained in the use of wiki-markup.',
	'HelpPage'					=> 'Abi:',
	'HelpPageInfo'				=> 'The documentation section for working with site tools.',
	'IndexPage'					=> 'Indeks:',
	'IndexPageInfo'				=> 'Lehekülg koos kõigi lehtede loendiga (action %1).',
	'RandomPage'				=> 'Juhuslik:',
	'RandomPageInfo'			=> 'Laadib juhusliku lehe (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameters for notifications of the platform.',
	'NotificationSettingsUpdated'	=> 'Updated notification settings',

	'EmailNotification'			=> 'Email Notification:',
	'EmailNotificationInfo'		=> 'Allow email notification. Set to ON to enable email notifications, OFF to disable them. Note that disabling email notifications has no effect on emails generated as part of the user signup process.',
	'Autosubscribe'				=> 'Autosubscribe:',
	'AutosubscribeInfo'			=> 'Automatically sign a new page in the owner\'s notice of its changes.',

	'NotificationSection'		=> 'Default user notification settings',
	'NotifyPageEdit'			=> 'Notify page edit:',
	'NotifyPageEditInfo'		=> 'Pending - Sending a email notification only for the first change until the user visits the page again.',
	'NotifyMinorEdit'			=> 'Notify minor edit:',
	'NotifyMinorEditInfo'		=> 'Sends notifications also for minor edits.',
	'NotifyNewComment'			=> 'Notify new comment:',
	'NotifyNewCommentInfo'		=> 'Pending - Sending a email notification only for the first comment until the user visits the page again.',

	'NotifyUserAccount'			=> 'Notify new user account:',
	'NotifyUserAccountInfo'		=> 'The Admin will to be notified when a new user has been created using the signup form.',
	'NotifyUpload'				=> 'Notify file upload:',
	'NotifyUploadInfo'			=> 'The Moderators will to be notified when a file has been uploaded.',

	'PersonalMessagesSection'	=> 'Isiklikud sõnumid',
	'AllowIntercomDefault'		=> 'Allow Intercom:',
	'AllowIntercomDefaultInfo'	=> 'Enable this option allows other users sending personal messages to the recipient email-address without disclosing the address.',
	'AllowMassemailDefault'		=> 'Allow Massemail:',
	'AllowMassemailDefaultInfo'	=> 'It send only messages to those user who allowed Administrators to email them information.',

	// Resync settings
	'Synchronize'				=> 'sünkroonida',
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

	'UserStats'					=> 'User Statistics',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'PageStats'					=> 'Page statistics',
	'PageStatsInfo'				=> 'Page statistics (number of comments, files and revisions) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',

	'AttachmentsInfo'			=> 'Uuendab kõigi andmebaasis olevate manuste faili hash\'i.',
	'AttachmentsSynched'		=> 'Kõik faili manused on uuesti üle vaadatud',
	'LogAttachmentsSynched'		=> 'Kõik faili manused on uuesti üle vaadatud',

	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'In the case of direct editing of pages in the database, the content of RSS-feeds may not reflect the changes made. <br>This function synchronizes the RSS-channels with the current state of the database.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'XmlSiteMapPeriod'			=> 'Period %1 days. Last written %2.',
	'XmlSiteMapView'			=> 'Show Sitemap in a new window.',

	'ReparseBody'				=> 'Reparse all pages',
	'ReparseBodyInfo'			=> 'Empties <code>body_r</code> in page table, so that each page gets rendered again on the next page view. This may be useful if you modified the formatter or changed the domain of your wiki.',
	'PreparsedBodyPurged'		=> 'Emptied <code>body_r</code> field in page table.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Performs a re-rendering for all intrasite links and restores the contents of the table <code>page_link</code> and <code>file_link</code> in the event of damage or relocation (this can take considerable time).',
	'RecompilePage'				=> 'Kõigi lehtede uuesti koostamine (väga kallis)',
	'ResyncOptions'				=> 'Additional options',
	'RecompilePageLimit'		=> 'Number of pages to parse at once.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Seda infot kasutatakse, kui foorum saadab e-kirja kasutajale. Palun ole kindel, et siinsisestatud e-postiaadress on kehtiv, kõik tagasipõrkuvad või kohaletoimetamata e-kirjad lähevad sinna. Kui su teenusepakkuja ei paku kohalikku (PHP põhist) e-posti teenust , võid saata sõnumeid otse läbi SMTP. See nõuab serveri aadressi (küsi pakkujalt, kui vaja). Kui server nõuab autentimist, (ja vaid sellisel juhul) sisesta vajalik kasutajanimi, parool ja autentimismeetod.',

	'EmailSettingsUpdated'		=> 'Updated Email settings',

	'EmailFunctionName'			=> 'E-posti funktsiooni nimi:',
	'EmailFunctionNameInfo'		=> 'E-posti funktsioon, mis saadab kirju läbi PHP.',
	'UseSmtpInfo'				=> 'Vali <code>SMTP</code>, kui soovid või pead e-maili saatma oma serverist Wiki e-posti funktsiooni asemel.',

	'EnableEmail'				=> 'Enable emails:',
	'EnableEmailInfo'			=> 'Enabling emails',

	'EmailIdentitySettings'		=> 'Veebisaidi e-kirjad Identiteet',
	'FromEmailName'				=> 'From Name:',
	'FromEmailNameInfo'			=> 'The sender name, part of <code>From:</code> header in emails for all the email-notification sent from the site.',
	'EmailSubjectPrefix'		=> 'Subjekti eesliide:',
	'EmailSubjectPrefixInfo'	=> 'Alternatiivne e-posti teema eesliide, nt <code>[Eesliide] Teema</code>. Kui seda ei ole määratud, on vaikimisi eesliide Site Name: %1.',

	'NoReplyEmail'				=> 'No-reply address:',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all your email-notifications sent from the site.',
	'AdminEmail'				=> 'Email of the site owner:',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service:',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.',

	'SendTestEmail'				=> 'Saada testimiseks e-kiri',
	'SendTestEmailInfo'			=> 'This will send a test email to the address defined in your account.',
	'TestEmailSubject'			=> 'Your Wiki is correctly configured to send emails',
	'TestEmailBody'				=> 'If you received this email, your Wiki is correctly configured to send emails.',
	'TestEmailMessage'			=> 'The test email has been sent.<br>If you don\'t receive it, please check your emails configuration.',

	'SmtpSettings'				=> 'SMTP seaded',
	'SmtpAutoTls'				=> 'Opportunistic TLS:',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Autentimismeetod SMTP jaoks:',
	'SmtpConnectionModeInfo'	=> 'Kasutatakse vaid siis, kui kasutajanimi/parool on määratud, küsi oma teenusepakkujalt, kui sa pole kindel, millist meetodit kasutada.',
	'SmtpPassword'				=> 'SMTP parool:',
	'SmtpPasswordInfo'			=> 'Sisesta parool vaid siis, kui SMTP server seda nõuab..<br><em><strong>HOIATUS:</strong> See parool salvestatakse lihttekstina andmebaasi, ning on nähtav kõigile kes pääsevad ligi sinu foorumi andmebaasile või sellele leheküljele.</em>',
	'SmtpPort'					=> 'SMTP serveri port:',
	'SmtpPortInfo'				=> 'Muuda seda vaid siis, kui tead, et SMTP server jookseb teisel pordil. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'SMTP serveri aadress:',
	'SmtpServerInfo'			=> 'Pane tähele, et sa pead andma protokolli, mida kasutab sinu server. Kui kasutad SSL, siis see peab olema <code>ssl://mail.example.com</code>',
	'SmtpUsername'				=> 'SMTP kasutajanimi:',
	'SmtpUsernameInfo'			=> 'Sisesta kasutajanimi vaid siis, kui server seda nõuab.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Siin saad sa muuta manuste põhiseadeid ja nendega seotud kategooriaid.',
	'UploadSettingsUpdated'		=> 'Updated upload settings',

	'FileUploadsSection'		=> 'File uploads',
	'RegisteredUsers'			=> 'registreeritud kasutajad',
	'RightToUpload'				=> 'Right to the upload files:',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belonging to the admins group can upload  files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadMaxFilesize'			=> 'Maksimaalne failisuurus:',
	'UploadMaxFilesizeInfo'		=> 'MMaksimaalne failisuurus igale failile. 0 tähendab maksimumi puudumist.',
	'UploadQuota'				=> 'Manuseid lubatud:',
	'UploadQuotaInfo'			=> 'Maksimaalne kettaruum, mis on eraldatud terve foorumi manustele. <code>0</code> tähendab maksimumi puudumist. %1 used.',
	'UploadQuotaUser'			=> 'Storage quota per user:',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with <code>0</code> being unlimited.',

	'FileTypes'					=> 'Failitüübid',
	'UploadOnlyImages'			=> 'Allow only upload of images:',
	'UploadOnlyImagesInfo'		=> 'Allow only uploading of image files on the page.',
	'AllowedUploadExts'			=> 'Lubatud failitüübid:',
	'AllowedUploadExtsInfo'		=> 'Lubatud laiendused failide üleslaadimiseks, komadega eraldatud nt <code>png, ogg, mp4</code>, muidu on lubatud kõik mitte keelatud faililaiendid.<br>Sa peaksid piirama üleslaaditavate failitüüpide lubatud failide nimekirja vajaliku miinimumini, mis on vajalik teie saidi sisu funktsionaalsuse jaoks.',
	'CheckMimetype'				=> 'Kontrolli manuseid:',
	'CheckMimetypeInfo'			=> 'Mõndasid veebilehitsejaid saab petta, eeldades, et tegu on vale miimitüübiga. See valik kindlustab, et sellised failid keelatakse.',
	'SvgSanitizer'				=> 'SVG Sanitizer:',
	'SvgSanitizerInfo'			=> 'See võimaldab üleslaaditud SVG-failide puhastamist, et vältida SVG/XML-i haavatavate failide üleslaadimist.',
	'TranslitFileName'			=> 'Failinimede translitereerimine:',
	'TranslitFileNameInfo'		=> 'Kui see on kohaldatav ja Unicode-märke ei ole vaja, on väga soovitatav aktsepteerida ainult tähtnumbrilisi märke.',
	'TranslitCaseFolding'		=> 'Konverteeri failinimed väikesteks tähtedeks:',
	'TranslitCaseFoldingInfo'	=> 'See valik toimib ainult aktiivse translitereerimise korral.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Loo pisipilt:',
	'CreateThumbnailInfo'		=> 'Loo pisipilt igas võimalikus olukorras.',
	'JpegQuality'				=> 'JPEG-kvaliteet:',
	'JpegQualityInfo'			=> 'Kvaliteet JPEG-mõõdupildi skaleerimisel. See peaks olema vahemikus 1 kuni 100, kusjuures 100 tähistab 100% kvaliteeti.',
	'MaxImageArea'				=> 'Maximum Image Area:',
	'MaxImageAreaInfo'			=> 'Maksimaalne pikslite arv, mis allikapildil võib olla. See piirab mälukasutust pildi skaleerija dekompressiooni poolel. <br><code>-1</code> tähendab, et see ei kontrolli pildi suurust enne selle skaleerimise katsetamist. <code>0</code> tähendab, et see määrab selle väärtuse automaatselt.',
	'MaxThumbWidth'				=> 'Maksimaalne pisipildi laius pikslites:',
	'MaxThumbWidthInfo'			=> 'Loodud pisipilt ei ületa siin määratud laiust.',
	'MinThumbFilesize'			=> 'Minimaalne pisipildi failisuurus:',
	'MinThumbFilesizeInfo'		=> 'Ära loo pisipilti piltidele, mis on sellest väiksemad.',
	'MaxImageWidth'				=> 'Pildi suuruse piirang lehekülgedel:',
	'MaxImageWidthInfo'			=> 'Vastasel juhul genereeritakse väiksema suurusega pisipilt.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'List of removed pages, revisions and files.
									Finally remove or restore the pages, revisions or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Words that will be automatically censored on your Wiki.',
	'FilterSettingsUpdated'		=> 'Updated spam filter settings',

	'WordCensoringSection'		=> 'Word censoring',
	'SPAMFilter'				=> 'SPAM Filter:',
	'SPAMFilterInfo'			=> 'Enabling SPAM Filter',
	'WordList'					=> 'Word list:',
	'WordListInfo'				=> 'Word or phrase <code>fragment</code> to be blacklisted (one per line)',

	// Log module
	'LogFilterTip'				=> 'Filter events by criteria:',
	'LogLevel'					=> 'Tase',
	'LogLevelFilters'	=> [
		'1'		=> 'mitte vähem kui',
		'2'		=> 'mitte kõrgem kui',
		'3'		=> 'võrdne',
	],
	'LogNoMatch'				=> 'Ükski sündmus ei vasta sellele kriteeriumile',
	'LogDate'					=> 'Kuupäev',
	'LogEvent'					=> 'Sündmus',
	'LogUsername'				=> 'Kasutajanimi',
	'LogLevels'	=> [
		'1'		=> 'kriitiline',
		'2'		=> 'kõrgeim',
		'3'		=> 'kõrge',
		'4'		=> 'keskmine',
		'5'		=> 'madal',
		'6'		=> 'madalaim',
		'7'		=> 'debugging',
	],

	// Massemail module
	'MassemailInfo'				=> 'Sellel leheküljel saad saata e-kirja kõigile liikmetele või valitud grupile, <strong>millel on valikus lubatud mass e-kiri vastu võtta</strong>. Pimekoopia saadetakse ka administraatori e-posti aadressile. Kui üritad saata kirja väga paljudele liikmetele, siis ära lahku enne lehelt, kui skript on lõpetanud saatmise, sest saatmisega lähebki kaua aega.',
	'LogMassemail'				=> 'Messemail send %1 to group / user ',
	'MassemailSend'				=> 'Massemail send',

	'NoEmailMessage'			=> 'Sa pead sisestama ka sõnumi.',
	'NoEmailSubject'			=> 'Sa pead sisestama ka pealkirja.',
	'NoEmailRecipient'			=> 'You must specify at least one user or user group.',

	'MassemailSection'			=> 'Mass email',
	'MessageSubject'			=> 'Teema:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Sinu sõnum:',
	'YourMessageInfo'			=> 'Sa võid sisestada ainult puhast teksti, kõik koodi märgistused eemaldatakse enne saatmist.',

	'NoUser'					=> 'No user',
	'NoUserGroup'				=> 'No user group',

	'SendToGroup'				=> 'Saada grupile:',
	'SendToUser'				=> 'Saada kasutajatele:',
	'SendToUserInfo'			=> 'It send only messages to those user who allowed Administrators to email them information. This option is available in their user settings under Notifications.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Updated system message',

	'SysMsgSection'				=> 'System message',
	'SysMsg'					=> 'Süsteemiteade:',
	'SysMsgInfo'				=> 'Sinu tekst siia',

	'SysMsgType'				=> 'Liik:',
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
	'LogUserPasswordReset'		=> 'Kasutaja ##%1## parool edukalt lähtestatud',

	'UserApproveInfo'			=> 'Approve new users before they are able to login to the site.',
	'Approve'					=> 'Kiida heaks',
	'Deny'						=> 'Keela',
	'Pending'					=> 'Ootel',
	'Approved'					=> 'Heaks kiidetud',
	'Denied'					=> 'Keelatud',

	// DB Backup module
	'BackupStructure'			=> 'Struktuur',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Kaust',
	'BackupTable'				=> 'Tabel',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'Failid',
	'BackupNote'				=> 'Meeldetuletus:',
	'BackupSettings'			=> 'Specify the desired scheme of Backup.<br>' .
    	'The root cluster does not affect the global files backup and cache files backup (being chosen they are always saved in full).<br>' .  '<br>' .
		'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster the tables from this backup will not be restructured, ',
	'BackupCompleted'			=> 'Backing up and archiving completed.<br>' .
    	'The Backup package files were stored in the sub-directory %1.<br>. To download it use FTP (maintain the directory structure and file names when copying).<br> To restore a backup copy or remove a package, go to <a href="%2">Restore database</a>.',
	'LogSavedBackup'			=> 'Saved backup database ##%1##',
	'Backup'					=> 'Varukoopia',
	'CantReadFile'				=> 'Can\'t read file %1.',

	// DB Restore module
	'RestoreInfo'				=> 'You can restore any of the backup packages found or remove it from the server.',
	'ConfirmDbRestore'			=> 'Kas soovite taastada varukoopia %1?',
	'ConfirmDbRestoreInfo'		=> 'Oodake, see võib võtta mõni minut.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'DirectoryNotExecutable'	=> 'Kataloog %1 ei ole käivitatav.',
	'BackupDelete'				=> 'Kas soovite kindlasti %1 varukoopia eemaldada??',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Additional restore options:',
	'RestoreOptionsInfo'		=> '* Before restoring the <strong>cluster backup</strong>, ' .
									'the target tables are not deleted (to prevent loss of information from the clusters that have not been backed up). ' .
									'Thus, during the recovery process duplicate records will occur. ' .
									'In normal mode, all of them will be replaced by the records form backup (using SQL-instruction <code>REPLACE</code>), ' .
									'but if this checkbox is checked, all duplicates are skipped (the current values of records will be kept), ' .
									'and only the records with new keys are added to the table (SQL-instruction <code>INSERT IGNORE</code>).<br>' .
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
	'RunSqlQueries'				=> 'Perform SQL-instructions:',
	'CompletedSqlQueries'		=> 'Completed. Processed instructions:',
	'NoTableStructure'			=> 'The structure of the tables was not saved - skip',
	'RestoreRecords'			=> 'Restore the contents of tables',
	'ProcessTablesDump'			=> 'Just download and process tables dump',
	'Instruction'				=> 'Instruction',
	'RestoredRecords'			=> 'kirjed:',
	'RecordsRestoreDone'		=> 'Completed. Total entries:',
	'SkippedRecords'			=> 'Data not saved - skip',
	'RestoringFiles'			=> 'Restoring files',
	'DecompressAndStore'		=> 'Decompress and store the contents of directories',
	'HomonymicFiles'			=> 'homonymic files',
	'RestoreSkip'				=> 'jäta vahele',
	'RestoreReplace'			=> 'asenda',
	'RestoreFile'				=> 'Fail:',
	'RestoredFiles'				=> 'restored:',
	'SkippedFiles'				=> 'skipped:',
	'FileRestoreDone'			=> 'Completed. Total files:',
	'FilesAll'					=> 'kõik:',
	'SkipFiles'					=> 'Files are not stored - skip',
	'RestoreDone'				=> 'RESTORATION COMPLETED',

	'BackupCreationDate'		=> 'Loomise kuupäev',
	'BackupPackageContents'		=> 'Paketi sisu',
	'BackupRestore'				=> 'Taasta',
	'BackupRemove'				=> 'Eemalda',
	'RestoreYes'				=> 'Jah',
	'RestoreNo'					=> 'Ei',
	'LogDbRestored'				=> 'Backup ##%1## of the database restored.',

	'BackupArchived'			=> 'Varukoopia %1 arhiveeritud.',
	'BackupArchiveExists'		=> 'Varukoopiaarhiiv %1 on juba olemas.',
	'LogBackupArchived'			=> 'Varukoopia ##%1## arhiveeritud.',

	// User module
	'UsersInfo'					=> 'Here you can change your users information and certain specific options.',

	'UsersAdded'				=> 'Kasutaja on lisatud',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> 'Muuda',
	'UsersAddNew'				=> 'Lisa uus kasutaja',
	'UsersDelete'				=> 'Kas soovite kindlasti kasutaja %1 eemaldada?',
	'UsersDeleted'				=> 'The user %1 was deleted from the database.',
	'UsersRename'				=> 'Rename the user %1 to',
	'UsersRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that user.',
	'UsersUpdated'				=> 'User successfully updated.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Signuptime',
	'UserActions'				=> 'Tegevused',
	'NoMatchingUser'			=> 'No users that meet the criteria',

	'UserAccountNotify'			=> 'Teata kasutajat',
	'UserNotifySignup'			=> 'teavitage kasutajat uuest kontost',
	'UserVerifyEmail'			=> 'määrake e-posti kinnituse märk ja lisage link e-posti kinnitamiseks',
	'UserReVerifyEmail'			=> 'Saada e-posti aadressi kinnitusmärk uuesti',

	// Groups module
	'GroupsInfo'				=> 'From this panel you can administrate all your usergroups. You can delete, create and edit existing groups. Furthermore, you may choose group leaders, toggle open/hidden/closed group status and set the group name and description.',

	'LogMembersUpdated'			=> 'Updated usergroup members',
	'LogMemberAdded'			=> 'Added member ##%1## to group ##%2##',
	'LogMemberRemoved'			=> 'Removed member ##%1## from group ##%2##',
	'LogGroupCreated'			=> 'Created a new group ##%1##',
	'LogGroupRenamed'			=> 'Group ##%1## renamed to ##%2##',
	'LogGroupRemoved'			=> 'Removed group ##%1##',

	'GroupsMembersFor'			=> 'Members for Group',
	'GroupsDescription'			=> 'Kirjeldus',
	'GroupsModerator'			=> 'Moderaator',
	'GroupsOpen'				=> 'Ava',
	'GroupsActive'				=> 'Aktiivne',
	'GroupsTip'					=> 'Click to edit Group',
	'GroupsUpdated'				=> 'Groups updated',
	'GroupsAlreadyExists'		=> 'This group already exists.',
	'GroupsAdded'				=> 'Group added successfully.',
	'GroupsRenamed'				=> 'Group successfully renamed.',
	'GroupsDeleted'				=> 'The group %1 was deleted from the database and all pages.',
	'GroupsAdd'					=> 'Add a new group',
	'GroupsRename'				=> 'Rename the group %1 to',
	'GroupsRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that group.',
	'GroupsDelete'				=> 'Kas soovite kindlasti grupi %1 eemaldada?',
	'GroupsDeleteInfo'			=> '* Note: Change will affect all members that are assigned to that group.',
	'GroupsIsSystem'			=> 'The group %1 belongs to the system and cannot be removed.',
	'GroupsStoreButton'			=> 'Save Groups',
	'GroupsEditInfo'			=> 'To edit the groups list select the radio button.',

	'GroupAddMember'			=> 'Lisa liige',
	'GroupRemoveMember'			=> 'Eemalda liige',
	'GroupAddNew'				=> 'Lisa grupp',
	'GroupEdit'					=> 'Muuda gruppi',
	'GroupDelete'				=> 'Eemalda grupp',

	'MembersAddNew'				=> 'Lisa uus liige',
	'MembersAdded'				=> 'Added new member to the group successfully.',
	'MembersRemove'				=> 'Are you sure you want to remove member %1?',
	'MembersRemoved'			=> 'The member was removed from the group.',

	// Statistics module
	'DbStatSection'				=> 'Andmebaasi statistika',
	'DbTable'					=> 'Tabel',
	'DbRecords'					=> 'Kirjed',
	'DbSize'					=> 'Suurus',
	'DbIndex'					=> 'Indeks',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'Kokku',

	'FileStatSection'			=> 'Failisüsteemi statistika',
	'FileFolder'				=> 'Kaust',
	'FileFiles'					=> 'Failid',
	'FileSize'					=> 'Suurus',
	'FileTotal'					=> 'Kokku',

	// Sysinfo module
	'SysInfo'					=> 'Version informations:',
	'SysParameter'				=> 'Parameeter',
	'SysValues'					=> 'Väärtused',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Viimane uuendus',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Serveri nimi',
	'WebServer'					=> 'Veebiserver',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'SQL Modes Global',
	'SqlModesSession'			=> 'SQL Modes Session',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Mälu',
	'UploadFilesizeMax'			=> 'Upload max filesize',
	'PostMaxSize'				=> 'Post max size',
	'MaxExecutionTime'			=> 'Max execution time',
	'SessionPath'				=> 'Session path',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip compression',
	'PhpExtensions'				=> 'PHP laiendid',
	'ApacheModules'				=> 'Apache modules',

	// DB repair module
	'DbRepairSection'			=> 'Paranda andmebaasi',
	'DbRepair'					=> 'Paranda andmebaasi',
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
	'CheckDatabase'				=> 'Andmebaas',
	'CheckDatabaseInfo'			=> 'Checks for record inconsistencies in the database.',
	'CheckFiles'				=> 'Failid',
	'CheckFilesInfo'			=> 'Checks for abandoned files, files with no reference left in the file table.',
	'Records'					=> 'Kirjed',
	'InconsistenciesNone'		=> 'No Data Inconsistencies found.',
	'InconsistenciesDone'		=> 'Data Inconsistencies solved.',
	'InconsistenciesRemoved'	=> 'Removed inconsistencies',
	'Check'						=> 'Check',
	'Solve'						=> 'Solve',

	// Bad Behaviour module
	'BbInfo'					=> 'Detects and blocks unwanted Web accesses, deny automated spambots access<br>For more information please visit the %1 homepage.',
	'BbEnable'					=> 'Enable Bad Behaviour:',
	'BbEnableInfo'				=> 'All other settings can be changed in the config folder %1.',
	'BbStats'					=> 'Bad Behaviour has blocked %1 access attempts in the last 7 days.',

	'BbSummary'					=> 'Kokkuvõte',
	'BbLog'						=> 'Log',
	'BbSettings'				=> 'Seadistused',
	'BbWhitelist'				=> 'Valge nimekiri',

	// --> Log
	'BbHits'					=> 'Klikke',
	'BbRecordsFiltered'			=> 'Displaying %1 of %2 records filtered by',
	'BbStatus'					=> 'Staatus',
	'BbBlocked'					=> 'Blokeeritud',
	'BbPermitted'				=> 'Lubatud',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Displaying all %1 records',
	'BbShow'					=> 'Näita',
	'BbIpDateStatus'			=> 'IP/Date/Status',
	'BbHeaders'					=> 'Päised',
	'BbEntity'					=> 'Entity',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Valikud on salvestatud.',
	'BbWhitelistHint'			=> 'Inappropriate whitelisting WILL expose you to spam, or cause Bad Behaviour to stop functioning entirely! DO NOT WHITELIST unless you are 100% CERTAIN that you should.',
	'BbIpAddress'				=> 'IP aadress',
	'BbIpAddressInfo'			=> 'IP address or CIDR format address ranges to be whitelisted (one per line)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL fragments beginning with the / after your web site hostname (one per line)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'User agent strings to be whitelisted (one per line)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Updated Bad Behaviour settings',
	'BbLogRequest'				=> 'Logging HTTP request',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Tavaline (soovitatud)',
	'BbLogOff'					=> 'Do not log (not recommended)',
	'BbSecurity'				=> 'Turvalisus',
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
