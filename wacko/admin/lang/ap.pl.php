<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'				=> 'Note: Before the administration of technical activities strongly are encouraged to block access to the site!',

	'CategoryArray'		=> [
		'basics'		=> 'Basic functions',
		'preferences'	=> 'Preferences',
		'content'		=> 'Content',
		'users'			=> 'U¿ytkownicy',
		'maintenance'	=> 'Maintenance',
		'messages'		=> 'Messages',
		'extension'		=> 'Extension',
		'database'		=> 'Database',
	],

	// Admin panel
	'AdminPanel'				=> 'Panel administracji',
	'RecoveryMode'				=> 'Tryb odzyskiwania',
	'Authorization'				=> 'Authorization',
	'AuthorizationTip'			=> 'Please enter the administrative password (make also sure that cookies are allowed in your browser).',
	'NoRecoceryPassword'		=> 'The administrative password is not specified!',
	'NoRecoceryPasswordTip'		=> 'Note: The absence of an administrative password is threat to security! Enter your password in the configuration file and run the program again.',

	'ErrorLoadingModule'		=> 'Error loading admin module %1: does not exists.',

	'FormSave'					=> 'Save',
	'FormReset'					=> 'Wyczy¶æ',
	'FormUpdate'				=> 'Aktualizuj',

	'ApHomePage'				=> 'Strona domowa',
	'ApHomePageTip'				=> 'open the home page, you do not quit administration',
	'ApLogOut'					=> 'Wyloguj',
	'ApLogOutTip'				=> 'quit system administration',

	'TimeLeft'					=> 'Time left:  %1 minutes',
	'ApVersion'					=> 'version',

	'SiteOpen'					=> 'open',
	'SiteOpened'				=> 'site opened',
	'SiteOpenedTip'				=> 'The site is open',
	'SiteClose'					=> 'close',
	'SiteClosed'				=> 'site closed',
	'SiteClosedTip'				=> 'The site is closed',

	// Generic
	'Cancel'					=> 'Cancel',
	'Add'						=> 'Add',
	'Edit'						=> 'Edit',
	'Remove'					=> 'Remove',
	'Enabled'					=> 'Odblokuj',
	'Disabled'					=> 'Zablokuj',
	'On'						=> 'w³±czony',
	'Off'						=> 'wy³±czony',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'Admin',

	'MiscellaneousSection'		=> 'Miscellaneous',
	'MainSection'				=> 'Basic Parameters',

	'DirNotWritable'			=> 'The %1 directory is not writable.',

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
		'name'		=> 'Wygl±d',
		'title'		=> 'Appearance settings',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-mail',
		'title'		=> 'Email settings',
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
		'name'		=> 'Powiadomienia',
		'title'		=> 'Notifications settings',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Pages',
		'title'		=> 'Pages and site parameters',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Uprawnienia',
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

	// Categories module
	'content_categories'		=> [
		'name'		=> 'Categories',
		'title'		=> 'Manage categories',
	],

	// Comments module
	'content_comments'		=> [
		'name'		=> 'Comments',
		'title'		=> 'Manage comments',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Deleted',
		'title'		=> 'Newly deleted content',
	],

	// Files module
	'content_files'		=> [
		'name'		=> 'Files',
		'title'		=> 'Manage uploaded files',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Add, edit or remove default menu items',
	],

	// Pages module
	'content_pages'		=> [
		'name'		=> 'Pages',
		'title'		=> 'Manage pages',
	],

	// Polls module
	'content_polls'		=> [
		'name'		=> 'Polls',
		'title'		=> 'Editing, start and stop polls',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Kopia zapasowa',
		'title'		=> 'Backing up data',
	],

	// DB Convert module
	'db_convert'		=> [
		'name'		=> 'Convert',
		'title'		=> 'Converting Tables or Columns',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Repair',
		'title'		=> 'Repair and Optimize Database',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Przywracanie',
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

	// Transliterate module
	'maint_transliterate'		=> [
		'name'		=> 'Transliterate',
		'title'		=> 'Update the supertag in the database records',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Mass email',
		'title'		=> 'Mass email',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'System message',
		'title'		=> 'System messages',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'System Info',
		'title'		=> 'System Informations',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System log',
		'title'		=> 'Log of system events',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statystyki',
		'title'		=> 'Show statistics',
	],

	// Bad Behavior module
	'badbehavior'		=> [
		'name'		=> 'Bad Behavior',
		'title'		=> 'Bad Behavior',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Approve',
		'title'		=> 'User registration approval',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Groups',
		'title'		=> 'Group management',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'U¿ytkownicy',
		'title'		=> 'User management',
	],

	// Main module
	'PurgeSessions'				=> 'purge',
	'PurgeSessionsTip'			=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the auth_token table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Updated basic settings',
	'LogBasicSettingsUpdated'	=> 'Updated basic settings',

	'SiteName'					=> 'Site Name',
	'SiteNameInfo'				=> 'The title of this site, appears on browser title, theme header, email-notification, etc.',
	'SiteDesc'					=> 'Site Description:',
	'SiteDescInfo'				=> 'Supplement to the title of the site that appears in the pages header to explain in a few words, what this site is about.',
	'AdminName'					=> 'Admin of Site',
	'AdminNameInfo'				=> 'User name, which is responsible for overall support of the site. This name is not used to determine access rights, but it is desirable to conform to the name of the chief administrator of the site.',
	'LanguageSection'			=> 'Language',
	'DefaultLanguage'			=> 'Default language',
	'DefaultLanguageInfo'		=> 'Specifies the language for mapping unregistered guests, as well as the locale settings and the rules of transliteration of addresses of pages.',
	'MultiLanguage'				=> 'Multilanguage support',
	'MultiLanguageInfo'			=> 'Enable the ability to select a language on a page-by-page basis.',
	'AllowedLanguages'			=> 'Allowed languages',
	'AllowedLanguagesInfo'		=> 'It is recomended to select only the set of languages you want to use, other wise all languages are selected.',
	'CommentSection'			=> 'Comments',
	'AllowComments'				=> 'Allow comments',
	'AllowCommentsInfo'			=> 'Enable comments for guest or registered users only or disable them on the entire site.',
	'SortingComments'			=> 'Sorting comments',
	'SortingCommentsInfo'		=> 'Changes the order the page comments are presented, either with the most recent OR the oldest comment at the top.',
	'ToolbarSection'			=> 'Toolbar',
	'CommentsPanel'				=> 'Comments panel',
	'CommentsPanelInfo'			=> 'The default display of comments in the bottom of the page.',
	'FilePanel'					=> 'File panel',
	'FilePanelInfo'				=> 'The default display of attachments in the bottom of the page.',
	'RatingPanel'				=> 'Rating panel',
	'RatingPanelInfo'			=> 'The default display of the rating panel in the bottom of the page.',
	'TagsPanel'					=> 'Tags panel',
	'TagsPanelInfo'				=> 'The default display of the tags panel in the bottom of the page.',
	'HideRevisions'				=> 'Hide Revisions',
	'HideRevisionsInfo'			=> 'The default display of revisions of the page.',
	'TocPanel'					=> 'Table of contents panel',
	'TocPanelInfo'				=> 'The default display table of contents panel of a page (may need support in the templates).',
	'SectionsPanel'				=> 'Sections panel',
	'SectionsPanelInfo'			=> 'By default display the panel of adjacent pages (requires support in the templates).',
	'DisplayingSections'		=> 'Displaying sections',
	'DisplayingSectionsInfo'	=> 'When the previous options, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>) or both, and other (<em>tree</em>).',
	'MenuItems'					=> 'Menu items',
	'MenuItemsInfo'				=> 'Default number of shown menu items (may need support in the templates).',
	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Enable feeds',
	'EnableFeedsInfo'			=> 'Turns on or off RSS feeds for the entire wiki.',
	'XmlSitemap'				=> 'XML Sitemap',
	'XmlSitemapInfo'			=> 'Create an XML file called "sitemap-wackowiki.xml" inside the xml folder. Generate a Sitemaps XML format compatible XML file. You might want to change the path to output it in your root folder as that is one of the requirements i.e. that the XML file is in the root folder.',
	'XmlSitemapTime'			=> 'XML Sitemap generation time',
	'XmlSitemapTimeInfo'		=> 'Generates the Sitemap only once in the given number of days, zero means on every page change.',
	'DiffModeSection'			=> 'Diff Modes',
	'DefaultDiffModeSetting'	=> 'Default diff mode',
	'DefaultDiffModeSettingInfo'=> 'Preselected diff mode.',
	'AllowedDiffMode'			=> 'Allowed Diff modes',
	'AllowedDiffModeInfo'		=> 'It is recomended to select only the set of diff modes you want to use, other wise all diff modes are selected.',
	'NotifyDiffMode'			=> 'Notify diff mode',
	'NotifyDiffModeInfo'		=> 'Diff mode used for Notifications in Email body.',

	'EditSummary'				=> 'Edit summary',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Minor edit',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'ReviewSettings'			=> 'Review',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',
	'PublishAnonymously'		=> 'Allow anonymous publishing',
	'PublishAnonymouslyInfo'	=> 'Allow users to published preferably anonymously (to hide the name).',
	'DefaultRenameRedirect'		=> 'When renaming put redirection',
	'DefaultRenameRedirectInfo'	=> 'By default, offer to deliver a redirect to the old address of the page being renamed.',
	'StoreDeletedPages'			=> 'Keep deleted pages',
	'StoreDeletedPagesInfo'		=> 'When you delete a page, a comment or a file put her in a special section where she had some time (below) will be available for viewing and recovery.',
	'KeepDeletedTime'			=> 'Storage time of deleted pages',
	'KeepDeletedTimeInfo'		=> 'The period in days. It makes sense only if the previous option. Zero indicates the eternal possession (in this case the administrator can clear the "cart" manually).',
	'PagesPurgeTime'			=> 'Storage time of page revisions',
	'PagesPurgeTimeInfo'		=> 'Automatically deletes the older versions within the given number of days. If you enter zero, the older versions will not be removed.',
	'EnableReferrers'			=> 'Enable Referrers',
	'EnableReferrersInfo'		=> 'Allows to store and show external referrers.',
	'ReferrersPurgeTime'		=> 'Storage time of referrers',
	'ReferrersPurgeTimeInfo'	=> 'Keep history of invoking external pages no more than this number of days. Zero means the perpetual possession, but to actively visit the site this could lead to overcrowding in the database.',
	'AttachmentHandler'			=> 'Enable attachments handler',
	'AttachmentHandlerInfo'		=> 'Allows to show the attachments handler.',
	'SearchEngineVisibility'	=> 'Block search engines (Search Engine Visibility)',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site, It is up to search engines to honor this request.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Control default display settings for your site.',

	'AppearanceSettingsUpdated'	=> 'Updated appearance settings.',

	'LogoOff'					=> 'off',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo and title',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Site Logo',
	'SiteLogoInfo'				=> 'Your logo will appear typically at the top left corner of the application. Max size is 2 MiB. Optimal dimensions are 255 pixels wide by 55 pixels high.',
	'LogoDimensions'			=> 'Logo dimensions',
	'LogoDimensionsInfo'		=> 'Width and height of the displayed Logo.',
	'LogoDisplayMode'			=> 'Logo display mode',
	'LogoDisplayModeInfo'		=> 'Defines the apearence of the Logo. Default is off.',
	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site Favicon',
	'SiteFaviconInfo'			=> 'Your shortcut icon, or favicon, is displayed in the address bar, tabs and bookmarks of most browsers. This will override the favicon of your theme.',
	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Theme',
	'ThemeInfo'					=> 'Template design the site uses by default.',
	'ThemesAllowed'				=> 'Allowed Themes',
	'ThemesAllowedInfo'			=> 'Select the allowed themes, which the user can choose, otherwise all available themes are allowed.',
	'ThemesPerPage'				=> 'Themes per page',
	'ThemesPerPageInfo'			=> 'Allow themes per page, which the page owner can choose via page properties.',

	// System settings
	'SystemSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'SystemSettingsUpdated'		=> 'Updated system settings',

	'DebugModeSection'			=> 'Debug mode',
	'DebugMode'					=> 'Debug mode',
	'DebugModeInfo'				=> 'Fixation and the withdrawal of telemetry data on the time of the program. Note: the full detail of the regime imposes high demands on available memory, especially in demanding operations such as backup and restore the database.',
	'DebugModes'	=> [
		'0'		=> 'debugging is off',
		'1'		=> 'only the total execution time',
		'2'		=> 'full-time',
		'3'		=> 'full detail (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Threshold performance RDBMS',
	'DebugSqlThresholdInfo'		=> 'In the detailed debug mode to record only the queries take longer than the number of seconds.',
	'DebugAdminOnly'			=> 'Closed diagnosis',
	'DebugAdminOnlyInfo'		=> 'Show debug data of the program (and DBMS) only for the administrator.',

	'CachingSection'			=> 'Caching Options',
	'Cache'						=> 'Cache rendered pages',
	'CacheInfo'					=> 'Save rendered pages in the local cache to speed up the subsequent boot. Valid only for unregistered visitors.',
	'CacheTtl'					=> 'Term relevance cached pages',
	'CacheTtlInfo'				=> 'Cache pages no more than a specified number of seconds.',
	'CacheSql'					=> 'Cache DBMS queries',
	'CacheSqlInfo'				=> 'Maintain a local cache the results of certain resource-SQL-queries.',
	'CacheSqlTtl'				=> 'Term relevance Cache Database',
	'CacheSqlTtlInfo'			=> 'Cache results of SQL-queries for no more than the specified number of seconds. Using the values of more than 1200 is not desirable.',

	'ReverseProxySection'		=> 'Reverse Proxy',
	'ReverseProxy'				=> 'Use Reverse proxy',
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
	'ReverseProxyHeader'		=> 'Reverse proxy header',
	'ReverseProxyHeaderInfo'	=> 'Set this value if your proxy server sends the client IP in a header
									 other than X-Forwarded-For. The "X-Forwarded-For" header is a comma+space separated list of IP
									 addresses, only the last one (the left-most) will be used.',
	'ReverseProxyAddresses'		=> 'reverse_proxy accepts an array of IP addresses',
	'ReverseProxyAddressesInfo'	=> 'Each element of this array is the IP address of any of your reverse
									 proxies. Filling this array WackoWiki will trust the information stored
									 in the X-Forwarded-For headers only if Remote IP address is one of
									 these, that is the request reaches the web server from one of your
									 reverse proxies. Otherwise, the client could directly connect to
									 your web server spoofing the X-Forwarded-For headers.',

	'RewriteMode'					=> 'Use <code>mod_rewrite</code>',
	'RewriteModeInfo'				=> 'If your web server supports this feature, turn to get "beautiful" the addresses of pages.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parameters responsible for Access control and permissions.',
	'PermissionsSettingsUpdated'	=> 'Updated permissions settings',

	'PermissionsSection'		=> 'Rights and privileges',
	'ReadRights'				=> 'Read rights by default',
	'ReadRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine parental rights.',
	'WriteRights'				=> 'Write rights by default',
	'WriteRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine the parental rights.',
	'CommentRights'				=> 'Comment rights by default',
	'CommentRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine the parental rights.',
	'CreateRights'				=> 'Create rights of a sub page by default',
	'CreateRightsInfo'			=> 'Define the tolerance for the establishment of root pages and assign pages for which we can not determine the parental rights.',
	'UploadRights'				=> 'Upload rights by default',
	'UploadRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine parental rights.',
	'RenameRights'				=> 'Global rename right',
	'RenameRightsInfo'			=> 'List for admission to the possibility of free rename (move) pages.',

	'LockAcl'					=> 'Lock all ACL to read only',
	'LockAclInfo'				=> '<span class="cite">Overwrites the acl settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period for security reasons or as a emergency response.',
	'HideLocked'				=> 'Hide inaccessible pages',
	'HideLockedInfo'			=> 'If the user does not have permission to read the page, hide it in different page lists (however the link placed in text, will still be visible).',
	'RemoveOnlyAdmins'			=> 'Only administrators can delete pages',
	'RemoveOnlyAdminsInfo'		=> 'Deny all, except administrators, to delete pages. In the first limit applies to owners of normal pages.',
	'OwnersRemoveComments'		=> 'Owners of pages can delete comments',
	'OwnersRemoveCommentsInfo'	=> 'Allow page owners to moderate comments on their pages.',
	'OwnersEditCategories'		=> 'Owners can edit page categories',
	'OwnersEditCategoriesInfo'	=> 'Allow owners to modify the pages category list of your site (add words, delete words), assigns to a page.',
	'TermHumanModeration'		=> 'Term human moderation',
	'TermHumanModerationInfo'	=> 'Moderators can edit comments, only if they were set up at most as many days ago (this restriction does not apply to the last comment in the topic).',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parameters responsible for the overall safety of the platform, work permits and additional security subsystems.',
	'SecuritySettingsUpdated'	=> 'Updated security settings',

	'AllowRegistration'			=> 'Register online',
	'AllowRegistrationInfo'		=> 'Ongoing registration of users. Disabling the option will prevent free registration, however, the site administrator will be able to register other users on their own.',
	'ApproveNewUser'			=> 'Approve new users',
	'ApproveNewUserInfo'		=> 'Allows Administrators to approve users once they register. Only approved users will be allowed to log in the site.',
	'PersistentCookies'			=> 'Persistent cookies',
	'PersistentCookiesInfo'		=> 'Allow persistent cookies.',
	'AntiDupe'					=> 'Anti-clone',
	'AntiDupeInfo'				=> 'Disable register on the website under the names, <span class="underline">like</span> on the names of existing users (guests also can not use similar names for the signature comments). When this option is checked only <span class="underline">identical</span> names.',
	'DisableWikiName'			=> 'Disable WikiName',
	'DisableWikiNameInfo'		=> 'Disable the the mandatory use of WikiName. Allows to register users with traditional nicknames, not forced NameSurname.',
	'AllowEmailReuse'			=> 'Allow email address re-use',
	'AllowEmailReuseInfo'		=> 'Different users can register with the same e-mail address.',
	'UsernameLength'			=> 'Username length',
	'UsernameLengthInfo'		=> 'Minimum and maximum number of characters in usernames.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Enable Captcha',
	'EnableCaptchaInfo'			=> 'If enabled, Captcha will be shown in the following cases or if a security threshold is reached.',
	'CaptchaComment'			=> 'New comment',
	'CaptchaCommentInfo'		=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before posting the comment.',
	'CaptchaPage'				=> 'New page',
	'CaptchaPageInfo'			=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before creating a new pages.',
	'CaptchaEdit'				=> 'Edit page',
	'CaptchaEditInfo'			=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before editing pages.',
	'CaptchaRegistration'		=> 'Registration',
	'CaptchaRegistrationInfo'	=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before registering.',

	'TlsSection'				=> 'TLS Settings',
	'TlsConnection'				=> 'TLS-Connection',
	'TlsConnectionInfo'			=> 'Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS-certificate on the server, otherwise you will lose access to the admin panel!</span><br>It also determines if the the Cookie Secure Flag is set, the <code>secure</code> flag specifies whether cookies should only be sent over secure connections.',
	'TlsImplicit'				=> 'Forced TLS',
	'TlsImplicitInfo'			=> 'Forcibly reconnect the client from HTTP to HTTPS. With the option disabled, the client can browse the site through an open HTTP channel.',
	'TlsProxy'					=> 'TLS Proxy',
	'TlsProxyInfo'				=> 'Uses the provided TLS Proxy inplace of TLS. E.g. https://<span class="cite">your-https-proxy.tld</span> without ending slash and without https://.',
	'HttpSecurityHeaders'		=> 'HTTP Security Headers',
	'EnableSecurityHeaders'		=> 'Enable Security Headers',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk !',
	'Csp'						=> 'Content-Security-Policy (CSP)',
	'CspInfo'					=> 'Configuring Content Security Policy involves deciding what policies you want to enforce, and then configuring them and using Content-Security-Policy to establish your policy.',
	'CspModes'	=> [
		'0'		=> 'disabled',
		'1'		=> 'strict',
		'2'		=> 'custom',
	],
	'ReferrerPolicy'			=> 'Referrer Policy',
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
	'PwdMinChars'				=> 'Minimum password length',
	'PwdMinCharsInfo'			=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 12 to 16 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'AdminPwdMinChars'			=> 'Minimum Admin password length',
	'AdminPwdMinCharsInfo'		=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 15 to 20 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'PwdCharComplexity'			=> 'The required password complexity',
	'PwdCharClasses'	=> [
		'0'		=> 'not tested',
		'1'		=> 'any letters + numbers',
		'2'		=> 'uppercase and lowercase + numbers',
		'3'		=> 'uppercase and lowercase + numbers + characters',
	],
	'PwdUnlikeLogin'			=> 'Additional complication',
	'PwdUnlikes'	=> [
		'0'		=> 'not tested',
		'1'		=> 'password is not identical to the login',
		'2'		=> 'password does not contain username',
	],

	'LoginSection'				=> 'Login',
	'MaxLoginAttempts'			=> 'Maximum number of login attempts per username',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximum number of login attempts per IP address',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'LogSection'				=> 'Log settings',
	'LogLevel'					=> 'Using logging',
	'LogLevelInfo'				=> 'The minimum priority of the events recorded in the log.',
	'LogThresholds'	=> [
		'0'		=> 'not keep a journal',
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high',
		'4'		=> 'on average',
		'5'		=> 'from low',
		'6'		=> 'the minimum level',
		'7'		=> 'record all',
	],
	'LogDefaultShow'			=> 'Display Log Mode',
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
	'LogPurgeTime'				=> 'Storage time of Log',
	'LogPurgeTimeInfo'			=> 'Remove event log over a given number of days.',

	'FormsSection'				=> 'Forms',
	'FormTokenTime'				=> 'Maximum time to submit forms',
	'FormTokenTimeInfo'			=> 'The time a user has to submit a form (in seconds).<br> Use -1 to disable. Note that a form might become invalid if the session expires, regardless of this setting.',

	'SessionLength'				=> 'Term login cookie',
	'SessionLengthInfo'			=> 'The lifetime of the user cookie login by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of the new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications',
	'IntercomDelayInfo'			=> 'The minimum delay between sending a private message user connection (in seconds).',

	//Formatter settings
	'FormatterSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'FormatterSettingsUpdated'	=> 'Updated formatting settings',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> 'Typographical Proofreader',
	'TypograficaInfo'			=> 'Unsetting slightly speed up the process of adding comments and save the page.',
	'Paragrafica'				=> 'Paragrafica markings',
	'ParagraficaInfo'			=> 'Similar to the previous option, but will lead to disconnection of inoperable automatic table of contents: <code>{{toc}}</code>.',
	'AllowRawhtml'				=> 'Global HTML Support',
	'AllowRawhtmlInfo'			=> 'This option is potentially unsafe for an open site.',
	'SafeHtml'					=> 'Filtering HTML',
	'SafeHtmlInfo'				=> 'Prevents saving of dangerous HTML-objects. Turning off the filter on an open site with HTML support is <span class="underline">extremely</span> undesirable!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formatter)',
	'X11colors'					=> 'X11 Colors Usage',
	'X11colorsInfo'				=> 'Extents the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code>Unsetting slightly speeds up the process of adding comments and saving of pages.',
	'TikiLinks'					=> 'Disable Tikilinks',
	'TikiLinksInfo'				=> 'Disables linking for <code>Double.CamelCaseWords</code>.',
	'WikiLinks'					=> 'Disable Wikilinks',
	'WikiLinksInfo'				=> 'Disables linking for <code>CamelCaseWords</code>, your CamelCase Words will no longer be linked directly to a new page. This is useful when you work across different namespaces aks clusters. By default it is off.',
	'BracketsLinks'				=> 'Disable bracketslinks',
	'BracketsLinksInfo'			=> 'Disables <code>[[link]]</code> and <code>((link))</code> syntax.',
	'Formatters'				=> 'Disable Formatters',
	'FormattersInfo'			=> 'Disables <code>%%code%%</code> syntax, used for highlighters.',

	'DateFormatsSection'		=> 'Date Formats',
	'DateFormat'				=> 'The format of the date',
	'DateFormatInfo'			=> '(day, month, year)',
	'TimeFormat'				=> 'The format of time',
	'TimeFormatInfo'			=> '(hour, minute)',
	'TimeFormatSeconds'			=> 'The format of the exact time',
	'TimeFormatSecondsInfo'		=> '(hours, minutes, seconds)',
	'NameDateMacro'				=> 'The format of the <code>::@::</code> macro',
	'NameDateMacroInfo'			=> '(name, time), e.g. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Timezone',
	'TimezoneInfo'				=> 'Timezone to use for displaying times to users who are not logged in (guests). Logged in users set and can change their timezone it in their user settings.',
	'EnableDst'					=> 'Enable Summer Time/DST',
	'EnableDstInfo'				=> '',

	'LinkTarget'				=> 'Where external links open',
	'LinkTargetInfo'			=> 'Opens each external link in a new browser window. Adds <code>target="_blank"</code> to the link syntax.',
	'Noreferrer'				=> 'noreferrer',
	'NoreferrerInfo'			=> 'Requires that the browser should not send an HTTP referer header if the user follows the hyperlink. Adds <code>rel="noreferrer"</code> to the link syntax.',
	'Nofollow'					=> 'nofollow',
	'NofollowInfo'				=> 'Instruct some search engines that the hyperlink should not influence the ranking of the link\'s target in the search engine\'s index. Adds <code>rel="nofollow"</code> to the link syntax.',
	'UrlsUnderscores'			=> 'Form addresses (URLs) with underscores',
	'UrlsUnderscoresInfo'		=> 'For example <code>http://[..]/WackoWiki</code> becames <code>http://[..]/Wacko_Wiki</code> with this option.',
	'ShowSpaces'				=> 'Show spaces in WikiNames',
	'ShowSpacesInfo'			=> 'Show spaces in WikiNames, e.g. <code>MyName</code> beeing displayed as <code>My Name</code> with this option.',
	'NumerateLinks'				=> 'Numerate links in print view',
	'NumerateLinksInfo'			=> 'Numerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disable and visualize self-referencing links',
	'YouareHereTextInfo'		=> 'Visualizing links to the same page, try to <code>&lt;b&gt;####&lt;/b&gt;</code>, all links-to-self became not links, but bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> '',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Number of items per list',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster Forum',
	'ForumClusterInfo'			=> 'Address of the index (main) page of the forum.',
	'ForumTopics'				=> 'Number of topics per page',
	'ForumTopicsInfo'			=> 'Number of topics displayed on each page of the list in the forum sections.',
	'CommentsCount'				=> 'Number of comments per page',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page list of comments. This applies to all the comments on the site, and not just posted in the forum.',

	'NewsSection'				=> 'Section News',
	'NewsCluster'				=> 'Cluster for the News',
	'NewsClusterInfo'			=> 'Root cluster for news section.',
	'NewsLevels'				=> 'Depth of news pages from the root cluster',
	'NewsLevelsInfo'			=> 'Regular expression (SQL regexp-slang), specifying the number of intermediate levels of the news root cluster directly to the names of pages of news reports. (e.g. <code>[cluster]/[year]/[month]</code> -> <code>/.+/.+/.+</code>)',

	'LicenseSection'			=> 'License',
	'DefaultLicense'			=> 'Default license',
	'DefaultLicenseInfo'		=> 'Under which license should your content be released.',

	'ServicePagesSection'		=> 'Service pages',
	'RootPage'					=> 'Home page',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',
	'PolicyPage'				=> 'Policies and Regulations',
	'PolicyPageinfo'			=> 'The page with the rules of the site.',
	'SearchPage'				=> 'Search',
	'SearchPageInfo'			=> 'Page with the search form (action <code>{{search}}</code>).',
	'RegistrationPage'			=> 'Register on our site',
	'RegistrationPageInfo'		=> 'Page new user registration (action <code>{{registration}}</code>).',
	'LoginPage'					=> 'User login',
	'LoginPageInfo'				=> 'Login page on the site (action <code>{{login}}</code>).',
	'SettingsPage'				=> 'Profile Settings',
	'SettingsPageInfo'			=> 'Page customize the user profile (action <code>{{usersettings}}</code>).',
	'PasswordPage'				=> 'Change Password',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action <code>{{changepassword}}</code>).',
	'UsersPage'					=> 'User list',
	'UsersPageInfo'				=> 'Page with a list of registered users (action <code>{{users}}</code>).',
	'CategoryPage'				=> 'Category',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action <code>{{category}}</code>).',
	'TagPage'					=> 'Tag',
	'TagPageInfo'				=> 'Page with a list of tagged pages (action <code>{{tag}}</code>).',
	'GroupsPage'				=> 'Groups',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action <code>{{usergroups}}</code>).',
	'ChangesPage'				=> 'Recent changes',
	'ChangesPageInfo'			=> 'Page with a list of the last modified pages (action <code>{{changes}}</code>).',
	'CommentsPage'				=> 'Recent comments',
	'CommentsPageInfo'			=> 'Page with a list of recent comment on the page (action <code>{{commented}}</code>).',
	'RemovalsPage'				=> 'Deleted pages',
	'RemovalsPageInfo'			=> 'Page with a list of recently deleted pages (action <code>{{deleted}}</code>).',
	'WantedPage'				=> 'Wanted pages',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action <code>{{wanted}}</code>).',
	'OrphanedPage'				=> 'Orphaned pages',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related links with the rest (action <code>{{orphaned}}</code>).',
	'TodoPage'					=> 'ToDo',
	'TodoPageInfo'				=> 'Page with a list of To Do (constructed with the help of <code>{{backlinks}}</code> and makro <code>::*::</code>).',
	'SandboxPage'				=> 'Sandbox',
	'SandboxPageInfo'			=> 'Page where users can be trained in the use of wiki-markup.',
	'WikiDocsPage'				=> 'Wiki documentation',
	'WikiDocsPageInfo'			=> 'Section of the documentation for using the tool site.',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameters for notifications of the platform.',
	'NotificationSettingsUpdated'	=> 'Updated notification settings',

	'EmailNotification'			=> 'Email Notification',
	'EmailNotificationInfo'		=> 'Allow email notification. Set to ON to enable email notifications, OFF to disable them. Note that disabling email notifications has no effect on emails generated as part of the user signup process.',
	'Autosubscribe'				=> 'Autosubscribe',
	'AutosubscribeInfo'			=> 'Automatically sign a new page in the owner\'s notice of its changes.',

	'NotificationSection'		=> 'Default user notification settings',
	'NotifyPageEdit'			=> 'Notify page edit',
	'NotifyPageEditInfo'		=> 'Pending - Sending a email notification only for the first change until the user visits the page again.',
	'NotifyMinorEdit'			=> 'Notify minor edit',
	'NotifyMinorEditInfo'		=> 'Sends notifications also for minor edits.',
	'NotifyNewComment'			=> 'Notify new comment',
	'NotifyNewCommentInfo'		=> 'Pending - Sending a email notification only for the first comment until the user visits the page again.',

	'NotifyUserAccount'			=> 'Notify new user account',
	'NotifyUserAccountInfo'		=> 'The Admin will to be notified when a new user has been created using the "signup form".',
	'AllowIntercomDefault'		=> 'Allow Intercom',
	'AllowIntercomDefaultInfo'	=> 'Enable this option allows other users sending personal messages to the recipient email-address without disclosing the address.',
	'AllowMassemailDefault'		=> 'Allow Massemail',
	'AllowMassemailDefaultInfo'	=> 'It send only messages to those user who allowed Administrators to email them information.',

	// Resync settings
	'Synchronize'				=> 'synchronizowaæ',
	'UserStatsSynched'			=> 'User Statistics synchronized.',
	'PageStatsSynched'			=> 'Page Statistics synchronized.',
	'FeedsUpdated'				=> 'RSS-feeds updated.',
	'SiteMapCreated'			=> 'The new version of the site map created successfully.',
	'WikiLinksRestored'			=> 'Wiki-links restored.',

	'LogUserStatsSynched'		=> 'Synchronized user statistics',
	'LogPageStatsSynched'		=> 'Synchronized page statistics',
	'LogFeedsUpdated'			=> 'Synchronized RSS feeds',

	'UserStats'					=> 'User Statistics',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'PageStats'					=> 'Page statistics',
	'PageStatsInfo'				=> 'Page statistics (number of comments, files and revisions) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'In the case of direct editing of pages in the database, the content of RSS-feeds may not reflect the changes made. <br>This function synchronizes the RSS-channels with the current state of the database.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'XmlSiteMapPeriod'			=> 'Period %1 days. Last written %2.',
	'XmlSiteMapView'			=> 'Show Sitemap in a new window.',
	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Performs a re-rendering for all intrasite links and restores the contents of the table <code>page_link</code> and <code>file_link</code> in the event of damage or relocation (this can take considerable time).',

	// Email settings
	'EmaiSettingsInfo'			=> 'Te informacje s± u¿ywane przez witrynê podczas wysy³ania e-maili do u¿ytkowników. Sprawd¼ czy podany adres e-mail jest wa¿nym adresem, poniewa¿ wszystkie zwrócone lub niedostarczone wiadomo¶ci bêd± prawdopodobnie odsy³ane na ten adres. Je¶li serwer nie udostêpnia natywnych (opartych na PHP) us³ug e-mail, mo¿na wysy³aæ wiadomo¶ci bezpo¶rednio, u¿ywaj±c protoko³u SMTP. Wymaga to adresu odpowiedniego serwera. Je¶li go nie znasz, zapytaj o niego swojego us³ugodawcê. Je¶li serwer wymaga uwierzytelnienia (i tylko, je¶li wymaga), wprowad¼ nazwê u¿ytkownika, has³o i metodê uwierzytelniania.',

	'EmailSettingsUpdated'		=> 'Updated Email settings',

	'EmailFunctionName'			=> 'Nazwa funkcji',
	'EmailFunctionNameInfo'		=> 'Nazwa funkcji e-maila u¿ywana do wysy³ania maili przez PHP.',
	'UseSmtpInfo'				=> 'Wybierz <code>SMTP</code> , je¶li takie jest twoje ¿yczenie lub trzeba wysy³aæ wiadomo¶ci e-mail przez dany serwer zamiast przez lokaln± funkcjê pocztow±.',

	'EnableEmail'				=> 'E-mail do wszystkich',
	'EnableEmailInfo'			=> 'Enabling emails',

	'FromEmailName'				=> 'From Name',
	'FromEmailNameInfo'			=> 'The sender name, part of <code>From:</code> header in emails for all the email-notification sent from the site.',
	'NoReplyEmail'				=> 'No-reply address',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all your email-notifications sent from the site.',
	'AdminEmail'				=> 'Email of the site owner',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.',

	'SendTestEmail'				=> 'Send a test email',
	'SendTestEmailInfo'			=> 'This will send a test email to the address defined in your account.',
	'TestEmailSubject'			=> 'Your Wiki is correctly configured to send emails',
	'TestEmailBody'				=> 'If you received this email, your Wiki is correctly configured to send emails.',
	'TestEmailMessage'			=> 'The test email has been sent.<br>If you don\'t receive it, please check your emails configuration.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Metoda uwierzytelniania dla SMTP',
	'SmtpConnectionModeInfo'	=> 'Uwierzytelnianie jest u¿ywane tylko wtedy, gdy jest okre¶lona nazwa u¿ytkownika i has³o. Je¶li nie wiesz, jakiej metody u¿yæ, zapytaj swojego dostawcê us³ugi.',
	'SmtpPassword'				=> 'SMTP Has³o',
	'SmtpPasswordInfo'			=> 'Nale¿y wprowadziæ tylko, je¶li serwer SMTP tego wymaga.<br><em><strong>Ostrze¿enie:</strong> Has³o zostanie zapisane w bazie danych jako zwyk³y tekst i bêdzie widoczne dla ka¿dego, kto ma dostêp do bazy danych lub kto mo¿e przegl±daæ tê stronê konfiguracji.</em>',
	'SmtpPort'					=> 'Port serwera',
	'SmtpPortInfo'				=> 'Mo¿na zmieniaæ tylko wtedy, gdy wiadomo, ¿e serwer pracuje na innym porcie. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'SMTP Adres serwera',
	'SmtpServerInfo'			=> 'Note that you have to provide the protocol that your server uses. If you are using SSL, this has to be <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> 'Ustawienia SMTP',
	'SmtpUsername'				=> 'SMTP Nazwa u¿ytkownika',
	'SmtpUsernameInfo'			=> 'Nale¿y wprowadziæ tylko, je¶li serwer SMTP tego wymaga.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Tutaj mo¿na dokonaæ konfiguracji g³ównych ustawieñ za³±czników i powi±zanych z nimi kategorii specjalnych.',
	'UploadSettingsUpdated'		=> 'Updated upload settings',

	'RightToUpload'				=> 'Right to the upload files',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belongig to admins group can upload the files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadOnlyImages'			=> 'Allow only upload of images',
	'UploadOnlyImagesInfo'		=> 'Allow only uploading of image files on the page.',
	'FileUploads'				=> 'File uploads',
	'UploadMaxFilesize'			=> 'Maksymalny rozmiar pliku',
	'UploadMaxFilesizeInfo'		=> 'Maksymalny rozmiar zamieszczanego pliku. Warto¶æ zero (0) - rozmiar zamieszczanego pliku ograniczany jest tylko przez ustawienia PHP.',
	'UploadQuota'				=> 'Rozmiar przestrzeni dyskowej',
	'UploadQuotaInfo'			=> 'Maksymalna przestrzeñ dyskowa dostêpna dla wszystkich za³±czników w tej instalacji Wiki. Warto¶æ zero (0) - brak ograniczenia przestrzeni.',
	'UploadQuotaUser'			=> 'Storage quota per user',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with 0 being unlimited.',
	'CheckMimetype'				=> 'Sprawdzaj pliki za³±cznika',
	'CheckMimetypeInfo'			=> 'Niektóre przegl±darki mog± byæ zmuszane do przybierania nieprawid³owego typu mediów (mimetype) dla wysy³anych plików. Funkcja ta zabezpiecza takie pliki przed odrzuceniem.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Zawsze twórz miniaturê',
	'CreateThumbnailInfo'		=> 'Tworzy miniaturê we wszystkich mo¿liwych sytuacjach. Dziêki tej funkcji miniatura bêdzie wy¶wietlana bezpo¶rednio w po¶cie i u¿ytkownik mo¿e j± klikn±æ, aby zobaczyæ pe³ny obrazek.',
	'MaxThumbWidth'				=> 'Maksymalna szeroko¶æ miniatury w pikselach',
	'MaxThumbWidthInfo'			=> 'Generowana miniatura nie bêdzie mog³a przekroczyæ okre¶lonej tutaj szeroko¶ci.',
	'MinThumbFilesize'			=> 'Minimalny rozmiar pliku miniatury',
	'MinThumbFilesizeInfo'		=> 'Je¶li rozmiar pliku miniatury jest mniejszy ni¿ zdefiniowana tutaj warto¶æ, miniatura nie zostanie utworzona.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'List of removed pages and files.
									Finally remove or restore the pages or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Words that will be automatically censored on your Wiki.',
	'FilterSettingsUpdated'		=> 'Updated spam filter settings',

	'WordCensoringSection'		=> 'Word censoring',
	'SPAMFilter'				=> 'SPAM Filter',
	'SPAMFilterInfo'			=> 'Enabling SPAM Filter',
	'WordList'					=> 'Word list',
	'WordListInfo'				=> 'Word or phrase <code>fragment</code> to be blacklisted (one per line)',

	// DB Convert module
	'Convert'					=> 'convert',
	'NoColumnsToConvert'		=> 'No columns to convert.',
	'NoTablesToConvert'			=> 'No tables to convert.',

	'LogDatabaseConverted'		=> 'Database converted',
	'ConversionTablesOk'		=> 'Conversion of the selected tables successfully.',

	'LogColumsToStrict'			=> 'Converted colums to comply with the SQL strict mode',
	'ConversionColumnsOk'		=> 'Conversion of the selected columns successfully.',

	'ConvertTablesEngine'		=> 'Converting Tables from MyISAM to InnoDB/XtraDB',
	'ConvertTablesEngineInfo'	=> 'If you have existing tables, that you want to convert to InnoDB/XtraDB* for better reliability and scalability, use the following routine. These tables were originally MyISAM, which was formerly the default.',
	'ConvertTablesEngineHint'	=> '* XtraDB is an enhanced version of the InnoDB storage engine, designed to better scale on modern hardware, and it includes a variety of other features useful in high performance environments.<br><br>It is fully backwards compatible, and it identifies itself to MariaDB as "<code>ENGINE=InnoDB</code>" (just like InnoDB), and so can be used as a drop-in replacement for standard InnoDB.',

	'DbVersion'					=> 'Requires at least MySQL 5.6.4, available version',
	'DbEngineOk'				=> 'InnoDB/XtraDB is available.',
	'DbEngineMissing'			=> 'InnoDB / XtraDB is not available.',
	'EngineTable'				=> 'Table',
	'EngineDefault'				=> 'Default',
	'EngineColumn'				=> 'Column',
	'EngineTyp'					=> 'Type',

	'ConvertColumnsToStrict'	=> 'Converting Columns to SQL strict',
	'ConvertTablesStrictInfo'	=> 'If you have existing tables, that you want to convert to comply with the SQL srtict mode, use the following routine.',

	// Log module
	'LogFilterTip'				=> 'Filter events by criteria',
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
	'MassemailInfo'				=> 'Tutaj mo¿esz wys³aæ wiadomo¶æ e-mail do wszystkich u¿ytkowników lub do wszystkich cz³onków konkretnej grupy, która ma w³±czon± <strong>funkcjê odbierania masowych wiadomo¶ci e-mail</strong>. Aby to osi±gn±æ e-mail zostanie wys³any na adres e-maila wykonawczego z ukryt± kopi± (odbiorca nie bêdzie widzia³ adresów innych odbiorców) wys³an± do wszystkich odbiorców. Domy¶lnie ustawionych jest 50 odbiorców. Wys³anie wiadomo¶ci do du¿ej liczby osób mo¿e potrwaæ d³u¿sz± chwilê. Zachowaj cierpliwo¶æ i nie przerywaj tej operacji. Po jej zakoñczeniu zostanie wy¶wietlone powiadomienie.',
	'LogMassemail'				=> 'Messemail send %1 to group / user ',
	'MassemailSend'				=> 'Massemail send',

	'NoEmailMessage'			=> 'Nale¿y wprowadziæ tre¶æ wiadomo¶ci.',
	'NoEmailSubject'			=> 'Nale¿y okre¶liæ temat wiadomo¶ci.',
	'NoEmailRecipient'			=> 'You must specify at least one user or user group.',

	'MessageSubject'			=> 'Subject',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Tre¶æ wiadomo¶ci',
	'YourMessageInfo'			=> 'Tre¶æ wiadomo¶ci musi byæ wpisana zwyk³ym tekstem. Przed wys³aniem wiadomo¶ci wszystkie znaczniki zostan± usuniête.',

	'MessageLanguage'			=> 'Language',
	'MessageLanguageInfo'		=> '',
	'SendMail'					=> 'Send',

	'NoUser'					=> 'No user',
	'NoUserGroup'				=> 'No user group',

	'SendToGroup'				=> 'Wy¶lij do grupy',
	'SendToUser'				=> 'Wy¶lij do u¿ytkowników',
	'SendToUserInfo'			=> 'It send only messages to those user who allowed Administrators to email them information. This option is available in their user settings under Notifications.',

	// System message module
	'SysMsgInfo'				=> '',
	'SysMsgUpdated'				=> 'Updated system message',

	'SysMsgSection'				=> 'System message',
	'SysMsg'					=> 'System message',
	'SysMsgInfo'				=> 'Your text here',

	'SysMsgType'				=> 'Type',
	'SysMsgTypeInfo'			=> 'Message type (CSS).',
	'EnableSysMsg'				=> 'Enable system message',
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
	'BackupCluster'				=> 'Cluster',
	'BackupFiles'				=> 'Files',
	'BackupSettings'			=> 'Specify the desired scheme of Backup.<br>' .
									'The root cluster does not affect the global files backup and cache files backup (being chosen they are always saved in full).<br>' .
									'<br>' .
									'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster the tables from this backup will not be restructured, ' .
									'same when backing up only table structure without saving the data. ' .
									'To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Backing up and archiving completed.<br>' .
									'The Backup package files were stored in the following sub-directory %1.<br>' .
									'To download it use FTP (maintain the directory structure and file names when copying).<br>' .
									'To restore a backup copy or remove a package, go to <a href="%2">Restore database</a>.',
	'LogSavedBackup'			=> 'Saved backup database ##%1##',

	// DB Restore module
	'RestoreInfo'				=> 'You can restore any of the backup packages found or remove it from the server.',
	'ConfirmDbRestore'			=> 'Do you want to restore backup',
	'ConfirmDbRestoreInfo'		=> 'Please wait this can take some minutes.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'BackupDelete'				=> 'Are you sure you want to remove backup',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Additional restore options',
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
	'IgnoreDuplicatedKeys'		=> 'Ignore duplicated table keys (not replace)',
	'IgnoreSameFiles'			=> 'Ignore the same files (not overwrite)',
	'NoBackupsAvailable'		=> 'No backups available.',
	'BackupEntireSite'			=> 'Entire site',
	'BackupRestored'			=> 'The backup is restored, a summary report is attached below. To delete this backup package, click',
	'BackupRemoved'				=> 'The selected backup has been successfully removed.',
	'LogRemovedBackup'			=> 'Removed database backup ##%1##',

	'RestoreStarted'			=> 'Initiated Restoration',
	'RestoreParameters'			=> 'Using parameters',
	'IgnoreDublicatedKeys'		=> 'Ignore dublicated keys',
	'IgnoreDublicatedFiles'		=> 'Ignore dublicated files',
	'SavedCluster'				=> 'Saved cluster',
	'DataProtection'			=> 'Data Protection - %1 omitted',
	'AssumeDropTable'			=> 'Assume %1',
	'RestoreTableStructure'		=> 'Restoring the structure of the table',
	'RunSqlQueries'				=> 'Perform SQL-instructions',
	'CompletedSqlQueries'		=> 'Completed. Processed instructions',
	'NoTableStructure'			=> 'The structure of the tables was not saved - skip',
	'RestoreRecords'			=> 'Restore the contents of tables',
	'ProcessTablesDump'			=> 'Just download and process tables dump',
	'Instruction'				=> 'Instruction',
	'RestoredRecords'			=> 'records',
	'RecordsRestoreDone'		=> 'Completed. Total entries',
	'SkippedRecords'			=> 'Data not saved - skip',
	'RestoringFiles'			=> 'Restoring files',
	'DecompressAndStore'		=> 'Decompress and store the contents of directories',
	'HomonymicFiles'			=> 'homonymic files',
	'RestoreSkip'				=> 'skip',
	'RestoreReplace'			=> 'replace',
	'RestoreFile'				=> 'File',
	'Restored'					=> 'restored',
	'Skipped'					=> 'skipped',
	'FileRestoreDone'			=> 'Completed. Total files',
	'FilesAll'					=> 'all',
	'SkipFiles'					=> 'Files are not stored - skip',
	'RestoreDone'				=> 'RESTORATION COMPLETED',

	'BackupCreationDate'		=> 'Creation Date',
	'BackupPackageContents'		=> 'The contents of the package',
	'BackupRestore'				=> 'restore',
	'BackupRemove'				=> 'remove',
	'RestoreYes'				=> 'yes',
	'RestoreNo'					=> 'no',
	'LogDbRestored'				=> 'Backup ##%1## of the database restored.',

	// User module
	'UsersInfo'					=> 'Here you can change your users information and certain specific options.',

	'UsersAdded'				=> 'User added',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'UserEditButton'			=> 'Edytuj',
	'UserEnabled'				=> 'Enabled',
	'UsersAddNew'				=> 'Add new user',
	'UsersDelete'				=> 'Are you sure you want to remove user ',
	'UsersDeleted'				=> 'The user was deleted from the database.',
	'UsersRename'				=> 'Rename the user',
	'UsersRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that user.',
	'UsersUpdated'				=> 'User successfully updated.',

	'UserName'					=> 'Nazwa u¿ytkownika',
	'UserRealname'				=> 'Realname',
	'UserEmail'					=> 'E-mail',
	'UserIP'					=> 'IP',
	'UserLanguage'				=> 'Jêzyk',
	'UserSignuptime'			=> 'Signuptime',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'No users that meet the criteria',

	// Groups module
	'GroupsInfo'				=> 'From this panel you can administrate all your usergroups. You can delete, create and edit existing groups. Furthermore, you may choose group leaders, toggle open/hidden/closed group status and set the group name and description.',

	'LogMembersUpdated'			=> 'Updated usergroup members',
	'LogMemberAdded'			=> 'Added member ##%1## into group ##%2##',
	'LogMemberRemoved'			=> 'Removed member ##%1## from group ##%2##',
	'LogGroupCreated'			=> 'Created a new group ##%1##',
	'LogGroupRenamed'			=> 'Group ##%1## renamed to ##%2##',
	'LogGroupRemoved'			=> 'Removed group ##%1##',

	'GroupsMembersFor'			=> 'Members for Group',
	'GroupsDescription'			=> 'Opis',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Open',
	'GroupsActive'				=> 'Aktywny',
	'GroupsTip'					=> 'Click to edit Group',
	'GroupsUpdated'				=> 'Groups updated',
	'GroupsAlreadyExists'		=> 'This group already exists.',
	'GroupsAdded'				=> 'Group added successfully.',
	'GroupsRenamed'				=> 'Group successfully renamed.',
	'GroupsDeleted'				=> 'The group was deleted from the database and all pages.',
	'GroupsAdd'					=> 'Add a new group',
	'GroupsRename'				=> 'Rename the group',
	'GroupsRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that group.',
	'GroupsDelete'				=> 'Are you sure you want to remove group ',
	'GroupsDeleteInfo'			=> '* Note: Change will affect all members that are assigned to that group.',
	'GroupsStoreButton'			=> 'Save Groups',
	'GroupsSaveButton'			=> 'Wy¶lij',
	'GroupsCancelButton'		=> 'Anuluj',
	'GroupsAddButton'			=> 'Add',
	'GroupsEditButton'			=> 'Edytuj',
	'GroupsRemoveButton'		=> 'Usuñ',
	'GroupsEditInfo'			=> 'To edit the groups list select the radio button.',

	'MembersAddNew'				=> 'Add new member',
	'MembersAdded'				=> 'Added new member to the group successfully.',
	'MembersRemove'				=> 'Are you sure you want to remove member ',
	'MembersRemoved'			=> 'The member was removed from the group.',
	'MembersDeleteInfo'			=> '* Note: Change will affect all members that are assigned to that group.',

	// Statistics module
	'DbStatSection'				=> 'Database Statistics',
	'DbTable'					=> 'Table',
	'DbRecords'					=> 'Records',
	'DbSize'					=> 'Size',
	'DbIndex'					=> 'Index',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'File system Statistics',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> 'Files',
	'FileSize'					=> 'Size',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Version informations',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Values',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Last update',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Server name',
	'WebServer'					=> 'Web server',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SQLModesGlobal'			=> 'SQL Modes Global',
	'SQLModesSession'			=> 'SQL Modes Session',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memory',
	'UploadFilesizeMax'			=> 'Upload max filesize',
	'PostMaxSize'				=> 'Post max size',
	'MaxExecutionTime'			=> 'Max execution time',
	'SessionPath'				=> 'Session path',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip compression',
	'PHPExtensions'				=> 'PHP extensions',
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

	// Transliterate module
	'TranslitField'				=> 'Transliterate field %1 in table `%2`.',
	'TranslitStart'				=> 'Start',
	'TranslitContinue'			=> 'Continue',
	'TranslitCompleted'			=> 'The update procedure is completed.',


];

?>
