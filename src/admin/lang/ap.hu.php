<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'					=> 'Note: Before the administration of technical activities strongly are encouraged to block access to the site!',

	'CategoryArray'		=> [
		'basics'		=> 'Basic functions',
		'preferences'	=> 'Preferenciák',
		'content'		=> 'Tartalom',
		'users'			=> 'Felhasználók',
		'maintenance'	=> 'Karbantartás',
		'messages'		=> 'Üzenetek',
		'extension'		=> 'Kiterjesztés',
		'database'		=> 'Adatbázis',
	],

	// Admin panel
	'AdminPanel'				=> 'Adminisztrátori vezérlőpult',
	'RecoveryMode'				=> 'Recovery Mode',
	'Authorization'				=> 'Authorization',
	'AuthorizationTip'			=> 'Kérjük, adja meg az adminisztrátori jelszót (győződjön meg arról is, hogy a böngészőben engedélyezik a sütik használatát).',
	'NoRecoveryPassword'		=> 'Az adminisztrációs jelszó nincs megadva!',
	'NoRecoveryPasswordTip'		=> 'Megjegyzés: Az adminisztrációs jelszó hiánya veszélyezteti a biztonságot! Írja be jelszavát a konfigurációs fájlba, és futtassa újra a programot.',

	'ErrorLoadingModule'		=> 'Error loading admin module %1: does not exists.',

	'ApHomePage'				=> 'Címlap',
	'ApHomePageTip'				=> 'open the home page, you do not quit administration',
	'ApLogOut'					=> 'Kilépés',
	'ApLogOutTip'				=> 'quit system administration',

	'TimeLeft'					=> 'Hátralévő idő:  %1 perc',
	'ApVersion'					=> 'verzió',

	'SiteOpen'					=> 'Nyitott',
	'SiteOpened'				=> 'site opened',
	'SiteOpenedTip'				=> 'The site is open',
	'SiteClose'					=> 'Bezár',
	'SiteClosed'				=> 'site closed',
	'SiteClosedTip'				=> 'The site is closed',

	// Generic
	'Cancel'					=> 'Mégse',
	'Add'						=> 'Hozzáadás',
	'Edit'						=> 'Szerkesztés',
	'Remove'					=> 'Eltávolítás',
	'Enabled'					=> 'Engedélyezett',
	'Disabled'					=> 'Tiltott',
	'Mandatory'					=> 'Kötelező',
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
		'name'		=> 'Alapvető',
		'title'		=> 'Alapparaméterek',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Kinézet',
		'title'		=> 'Kinézet beállítások',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-mail',
		'title'		=> 'E-mail beállítások',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Szűrő',
		'title'		=> 'Szűrőbeállítások',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'Formatting options',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Értesítések',
		'title'		=> 'Értesítések beállításai',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Oldalak',
		'title'		=> 'Oldalak és webhelyparaméterek',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Jogosultságok',
		'title'		=> 'Permissions settings',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Biztonság',
		'title'		=> 'Biztonsági alrendszerek beállításai',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Rendszer',
		'title'		=> 'Rendszeropciók',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Feltöltés',
		'title'		=> 'Melléklet beállításai',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Törölve',
		'title'		=> 'Újonnan törölt tartalom',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menü',
		'title'		=> 'Alapértelmezett menüelemek hozzáadása, szerkesztése vagy eltávolítása',
	],

	// Polls module
	'content_polls'		=> [
		'name'		=> 'Polls',
		'title'		=> 'Editing, start and stop polls',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Kimentés',
		'title'		=> 'Adatok biztonsági mentése',
	],

	// DB Convert module
	'db_convert'		=> [
		'name'		=> 'Átalakítás',
		'title'		=> 'Converting Tables or Columns',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Javítás',
		'title'		=> 'Javítás és optimalizálás adatbázisban',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Visszaállítás',
		'title'		=> 'Visszaállítása mentési adatok',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Főmenü',
		'title'		=> 'WackoWiki adminisztráció',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Következetlenségek',
		'title'		=> 'Az adatok ellentmondásainak kijavítása',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Adatok szinkronizálása',
		'title'		=> 'Adatok szinkronizálása',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Mass email',
		'title'		=> 'Mass email',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Rendszerüzenet',
		'title'		=> 'Rendszerüzenetek',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Rendszer információ',
		'title'		=> 'Rendszer információ',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Rendszernapló',
		'title'		=> 'A rendszeresemények naplója',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statisztika',
		'title'		=> 'Statisztikák megjelenítése',
	],

	// Bad Behavior module
	'tool_badbehavior'		=> [
		'name'		=> 'Bad Behavior',
		'title'		=> 'Bad Behavior',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Jóváhagy',
		'title'		=> 'Felhasználói regisztráció jóváhagyása',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Csoportok',
		'title'		=> 'Csoportok kezelése',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Felhasználók',
		'title'		=> 'Felhasználók kezelése',
	],

	// Main module
	'PurgeSessions'				=> 'Purge',
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

	'LanguageSection'			=> 'Nyelv',
	'DefaultLanguage'			=> 'Alapértelmezett nyelv',
	'DefaultLanguageInfo'		=> 'Specifies the language of messages displayed to unregistered guests, as well as the locale settings.',
	'MultiLanguage'				=> 'Multilanguage support',
	'MultiLanguageInfo'			=> 'Enable the ability to select a language on a page-by-page basis.',
	'AllowedLanguages'			=> 'Engedélyezett nyelvek',
	'AllowedLanguagesInfo'		=> 'Javasoljuk, hogy csak azt a nyelvkészletet válassza, amelyet használni szeretne, egyébként minden nyelvet kiválasztva.',

	'CommentSection'			=> 'Hozzászólások',
	'AllowComments'				=> 'Hozzászólások engedélyezése',
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

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Show Permalink',
	'ShowPermalinkInfo'			=> 'The default display of the permalink for the current version of the page.',
	'TocPanel'					=> 'Table of contents panel',
	'TocPanelInfo'				=> 'The default display table of contents panel of a page (may need support in the templates).',
	'SectionsPanel'				=> 'Sections panel',
	'SectionsPanelInfo'			=> 'By default display the panel of adjacent pages (requires support in the templates).',
	'DisplayingSections'		=> 'Displaying sections',
	'DisplayingSectionsInfo'	=> 'When the previous options, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>) or both, and other (<em>tree</em>).',
	'MenuItems'					=> 'Menu items',
	'MenuItemsInfo'				=> 'Default number of shown menu items (may need support in the templates).',

	'HandlerSection'			=> 'Handler',
	'HideRevisions'				=> 'Hide Revisions',
	'HideRevisionsInfo'			=> 'The default display of revisions of the page.',
	'AttachmentHandler'			=> 'Enable attachments handler',
	'AttachmentHandlerInfo'		=> 'Allows to show the attachments handler.',
	'SourceHandler'				=> 'Enable source handler',
	'SourceHandlerInfo'			=> 'Allows to show the source handler.',
	'ExportHandler'				=> 'Enable XML export handler',
	'ExportHandlerInfo'			=> 'Allows to show the XML export handler.',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Enable feeds',
	'EnableFeedsInfo'			=> 'Az RSS-hírcsatornák be- és kikapcsolása a teljes wiki számára.',

	'XmlSitemap'				=> 'XML Sitemap',
	'XmlSitemapInfo'			=> 'Creates an XML file called %1 inside the xml folder. You can add the path to the sitemap in the robots.txt file in your root directory as follows:',
	'XmlSitemapGz'				=> 'XML Sitemap compression',
	'XmlSitemapGzInfo'			=> 'If you would like, you may compress your Sitemap text file using gzip to reduce your bandwidth requirement.',
	'XmlSitemapTime'			=> 'XML Sitemap generation time',
	'XmlSitemapTimeInfo'		=> 'A webhelytérképet csak egyszer generálja az adott napszámban, nulla azt jelenti, hogy minden oldalváltozáson megy végbe.',

	'SearchSection'				=> 'Keresés',
	'OpenSearch'				=> 'OpenSearch',
	'OpenSearchInfo'			=> 'Létrehozza az OpenSearch leíró fájlt az XML mappában, és engedélyezi a keresési bővítmény automatikus felfedezését a HTML fejlécben.',
	'SearchEngineVisibility'	=> 'Block search engines (Search Engine Visibility)',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site, It is up to search engines to honor this request.',

	'DiffModeSection'			=> 'Diff Modes',
	'DefaultDiffModeSetting'	=> 'Default diff mode',
	'DefaultDiffModeSettingInfo'=> 'Preselected diff mode.',
	'AllowedDiffMode'			=> 'Allowed Diff modes',
	'AllowedDiffModeInfo'		=> 'It is recommended to select only the set of diff modes you want to use, other wise all diff modes are selected.',
	'NotifyDiffMode'			=> 'Notify diff mode',
	'NotifyDiffModeInfo'		=> 'Diff mode used for notifications in the email body.',

	'EditingSection'			=> 'Editing',
	'EditSummary'				=> 'A változások összefoglalása',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Apróbb változások',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'ReviewSettings'			=> 'Review',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',
	'PublishAnonymously'		=> 'Allow anonymous publishing',
	'PublishAnonymouslyInfo'	=> 'Allow users to published preferably anonymously (to hide the name).',

	'DefaultRenameRedirect'		=> 'When renaming put redirection',
	'DefaultRenameRedirectInfo'	=> 'By default, offer to set a redirect to the old address of the page being renamed.',
	'StoreDeletedPages'			=> 'Keep deleted pages',
	'StoreDeletedPagesInfo'		=> 'When you delete a page, a comment or a file, keep it in a special section, where it will be available for review and recovery for some more time (as described below).',
	'KeepDeletedTime'			=> 'Storage time of deleted pages',
	'KeepDeletedTimeInfo'		=> 'The period in days. It makes sense only with the previous option. Zero indicates the eternal possession (in this case the administrator can clear the "cart" manually).',
	'PagesPurgeTime'			=> 'Storage time of page revisions',
	'PagesPurgeTimeInfo'		=> 'Automatically deletes the older versions within the given number of days. If you enter zero, the older versions will not be removed.',
	'EnableReferrers'			=> 'Enable Referrers',
	'EnableReferrersInfo'		=> 'Allows to store and show external referrers.',
	'ReferrersPurgeTime'		=> 'Storage time of referrers',
	'ReferrersPurgeTimeInfo'	=> 'Tartsa a hivatkozott külső oldalak történetét nem több, mint egy megadott napnál. A nulla az örök tárolást jelenti, de egy aktívan meglátogatott webhelyhez ez az adatbázis túlcsordulásához vezethet.',
	'EnableCounters'			=> 'Hit Counters',
	'EnableCountersInfo'		=> 'Allows per page hit counters and enables display of simple statistics. Views of the page owner are not counted.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Állítsa be a webhely alapértelmezett kinézet beállításait.',
	'AppearanceSettingsUpdated'	=> 'Frissített kinézet beállítások.',

	'LogoOff'					=> 'ki',
	'LogoOnly'					=> 'logó',
	'LogoAndTitle'				=> 'logó és cím',

	'LogoSection'				=> 'Logó',
	'SiteLogo'					=> 'Site Logo',
	'SiteLogoInfo'				=> 'Logója általában az alkalmazás bal felső sarkában jelenik meg. A maximális méret 2 MiB. Optimális méretei 255 pixel széles 55 képpont magas.',
	'LogoDimensions'			=> 'Logó méretek',
	'LogoDimensionsInfo'		=> 'Szélessége és magassága a megjelenített Logó.',
	'LogoDisplayMode'			=> 'Logó megjelenítési mód',
	'LogoDisplayModeInfo'		=> 'Meghatározza a logó megjelenését. Alapban ki van kapcsolva.',
	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Favicon webhely',
	'SiteFaviconInfo'			=> 'A parancsikon favicon megjelenik a legtöbb böngésző címsorában, lapjain és könyvjelzőiben. Ez felülírja a favicon a témát.',
	'SiteFaviconTooBig'			=> 'A Favicon nagyobb, mint 64 × 64px.',
	'LayoutSection'				=> 'Elrendezés',
	'Theme'						=> 'Sablon',
	'ThemeInfo'					=> 'A webhely alapértelmezés szerint használt sablontervezése.',
	'ThemesAllowed'				=> 'Engedélyezett sablonok',
	'ThemesAllowedInfo'			=> 'Válassza ki a megengedett sablonok, amelyeket a felhasználó választhat, különben az összes elérhető sablonok engedélyezett.',
	'ThemesPerPage'				=> 'Sablonok oldalanként',
	'ThemesPerPageInfo'			=> 'Engedélyezzen sablonokat oldalanként, amelyeket az oldal tulajdonosa az oldal tulajdonságain keresztül választhat ki.',
	'ThemeColor'				=> 'Theme color for address bar',
	'ThemeColorInfo'			=> 'A böngésző minden oldal címsorának színét a megadott CSS-színnek megfelelően állítja be.',

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

	'PrivacySection'			=> 'Privacy',
	'AnonymizeIp'				=> 'Anonymize users IP addresses',
	'AnonymizeIpInfo'			=> 'Anonymize IP addresses where applicable like page, revision or referrers.',

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
	'ReverseProxyHeaderInfo'	=> 'Állítsa be ezt az értéket, ha a proxykiszolgáló az ügyfél IP-címét az X-Forwarded-For
									fejléctől eltérő fejlécben küldi. Az "X-Forwarded-For" fejléc egy vesszővel és szóközzel
									elválasztott IP-címek listája, csak az utolsó (a bal szélső) kerül felhasználásra.',
	'ReverseProxyAddresses'		=> 'reverse_proxy accepts an array of IP addresses',
	'ReverseProxyAddressesInfo'	=> 'Each element of this array is the IP address of any of your reverse
									 proxies. Filling this array WackoWiki will trust the information stored
									 in the X-Forwarded-For headers only if Remote IP address is one of
									 these, that is the request reaches the web server from one of your
									 reverse proxies. Otherwise, the client could directly connect to
									 your web server spoofing the X-Forwarded-For headers.',

	'SessionSection'				=> 'Session handling',
	'SessionStorage'				=> 'Session storage',
	'SessionStorageInfo'			=> 'This option defines where the the session data is stored. By default either file or database session storage is selected.',
	'SessionModes'	=> [
		'1'		=> 'Fájl',
		'2'		=> 'Adatbázis',
	],
	'SessionNotice'					=> 'Munkamenet befejezésének okának megjelenítése',
	'SessionNoticeInfo'				=> 'A munkamenet befejezésének okát jelzi.',

	'RewriteMode'					=> 'Use <code>mod_rewrite</code>',
	'RewriteModeInfo'				=> 'If your web server supports this feature, turn to get "beautiful" the addresses of pages.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parameters responsible for Access control and permissions.',
	'PermissionsSettingsUpdated'	=> 'Updated permissions settings',

	'PermissionsSection'		=> 'Rights and privileges',
	'ReadRights'				=> 'Read rights by default',
	'ReadRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'WriteRights'				=> 'Write rights by default',
	'WriteRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'CommentRights'				=> 'Comment rights by default',
	'CommentRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'CreateRights'				=> 'Create rights of a sub page by default',
	'CreateRightsInfo'			=> 'Define the right for creating root pages and assign them to pages for which parental rights cannot be defined.',
	'UploadRights'				=> 'Upload rights by default',
	'UploadRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'RenameRights'				=> 'Global rename right',
	'RenameRightsInfo'			=> 'The list of permissions to freely rename (move) pages.',

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
	'TermHumanModerationInfo'	=> 'A moderátorok csak akkor módosíthatják a megjegyzéseket, ha csak ennyi nappal ezelőtt hozták létre őket (ez a korlátozás nem vonatkozik a téma utolsó megjegyzésére).',

	'UserCanDeleteAccount'		=> 'Engedélyezi, hogy a felhasználók törölhessék a saját fiókjukat',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parameters responsible for the overall safety of the platform, safety restrictions and additional security subsystems.',
	'SecuritySettingsUpdated'	=> 'Updated security settings',

	'AllowRegistration'			=> 'Register online',
	'AllowRegistrationInfo'		=> 'Nyissa meg a felhasználói regisztrációt. Ennek a lehetőségnek a letiltása megakadályozza az ingyenes regisztrációt, azonban a webhely adminisztrátora maga regisztrálhatja a többi felhasználót.',
	'ApproveNewUser'			=> 'Approve new users',
	'ApproveNewUserInfo'		=> 'Allows Administrators to approve users once they register. Only approved users will be allowed to log in the site.',
	'PersistentCookies'			=> 'Persistent cookies',
	'PersistentCookiesInfo'		=> 'Allow persistent cookies.',
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
	'CaptchaRegistration'		=> 'Regisztráció',
	'CaptchaRegistrationInfo'	=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before registering.',

	'TlsSection'				=> 'TLS Settings',
	'TlsConnection'				=> 'TLS-Connection',
	'TlsConnectionInfo'			=> 'Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS-certificate on the server, otherwise you will lose access to the admin panel!</span><br>It also determines if the the Cookie Secure Flag is set, the <code>secure</code> flag specifies whether cookies should only be sent over secure connections.',
	'TlsImplicit'				=> 'Mandatory TLS',
	'TlsImplicitInfo'			=> 'Forcibly reconnect the client from HTTP to HTTPS. With the option disabled, the client can browse the site through an open HTTP channel.',

	'HttpSecurityHeaders'		=> 'HTTP Security Headers',
	'EnableSecurityHeaders'		=> 'Enable Security Headers',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk !',
	'Csp'						=> 'Content-Security-Policy (CSP)',
	'CspInfo'					=> 'Configuring Content Security Policy involves deciding what policies you want to enforce, and then configuring them and using Content-Security-Policy to establish your policy.',
	'PolicyModes'	=> [
		'0'		=> 'tiltott',
		'1'		=> 'strict',
		'2'		=> 'custom',
	],
	'PermissionsPolicy'			=> 'Permissions Policy',
	'PermissionsPolicyInfo'		=> 'The HTTP Permissions-Policy header provides a mechanism to explicitly enable or disable various powerful browser features.',
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

	'LoginSection'				=> 'Bejelentkezés',
	'MaxLoginAttempts'			=> 'Maximum number of login attempts per username',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximum number of login attempts per IP address',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'LogSection'				=> 'Log settings',
	'LogLevelUsage'				=> 'Using logging',
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
	'FormTokenTimeInfo'			=> 'Annak ideje, amikor a felhasználónak el kell küldenie az űrlapot (másodpercben). <br> Vegye figyelembe, hogy az űrlap érvénytelenné válhat, ha a munkamenet lejár, a beállítástól függetlenül.',

	'SessionLength'				=> 'Term login cookie',
	'SessionLengthInfo'			=> 'The lifetime of the user cookie login by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of the new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications',
	'IntercomDelayInfo'			=> 'The minimum delay between sending a private message user connection (in seconds).',
	'RegistrationDelay'			=> 'Time threshold for registering',
	'RegistrationDelayInfo'		=> 'The minimum time threshold for filling out the registration form to tell away bots from humans (in seconds).',

	// Formatter settings
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
	'Timezone'					=> 'Időzóna',
	'TimezoneInfo'				=> 'Időzóna, amelyet a be nem jelentkezett felhasználók (vendégek) számára megjelenítendő időpontokhoz használnak. A bejelentkezett felhasználók a felhasználói beállításaikban beállíthatják és megváltoztathatják az időzónát.',
	'EnableDst'					=> 'Enable Summer Time/DST',
	'EnableDstInfo'				=> '',

	'Canonical'					=> 'Teljesen kanonikus URL-ek használata',
	'CanonicalInfo'				=> 'Az összes hivatkozás abszolút URL-ként jön létre a %1 formában. A %2 formában a kiszolgáló gyökéréhez viszonyított URL-eket kell előnyben részesíteni.',
	'LinkTarget'				=> 'Where external links open',
	'LinkTargetInfo'			=> 'Minden külső linket megnyit egy új böngészőablakban. A <code>target="_blank"</code> ájlt hozzáadja a link szintaxisához.',
	'Noreferrer'				=> 'noreferrer',
	'NoreferrerInfo'			=> 'Requires that the browser should not send an HTTP referer header if the user follows the hyperlink. Adds <code>rel="noreferrer"</code> to the link syntax.',
	'Nofollow'					=> 'nofollow',
	'NofollowInfo'				=> 'Utasítsa néhány keresőmotorot, hogy a hiperhivatkozás ne befolyásolja a linkek céljának rangsorolását a keresőmotorok indexében. <code>rel="nofollow"</code> hozzáad a hivatkozás szintaxisához.',
	'UrlsUnderscores'			=> 'Form addresses (URLs) with underscores',
	'UrlsUnderscoresInfo'		=> 'For example %1 becames %2 with this option.',
	'ShowSpaces'				=> 'Show spaces in WikiNames',
	'ShowSpacesInfo'			=> 'Show spaces in WikiNames, e.g. <code>MyName</code> being displayed as <code>My Name</code> with this option.',
	'NumerateLinks'				=> 'Numerate links in print view',
	'NumerateLinksInfo'			=> 'Numerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disable and visualize self-referencing links',
	'YouareHereTextInfo'		=> 'Visualizing links to the same page, try to <code>&lt;b&gt;####&lt;/b&gt;</code>, all links-to-self became not links, but bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Itt állíthatja be vagy módosíthatja a Wikiben használt rendszer alapoldalakat. Kérjük, ne felejtse el létrehozni vagy megváltoztatni a Wiki megfelelő oldalait az itt megadott beállításoknak megfelelően.',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Number of items per list',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster Forum',
	'ForumClusterInfo'			=> 'Root cluster for forum section (action %1).',
	'ForumTopics'				=> 'Number of topics per page',
	'ForumTopicsInfo'			=> 'Number of topics displayed on each page of the list in the forum sections (action %1).',
	'CommentsCount'				=> 'Number of comments per page',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page list of comments. This applies to all the comments on the site, and not just posted in the forum.',

	'NewsSection'				=> 'Section News',
	'NewsCluster'				=> 'Cluster for the News',
	'NewsClusterInfo'			=> 'Root cluster for news section (action %1).',
	'NewsStructure'				=> 'News cluster structure',
	'NewsStructureInfo'			=> 'Stores the articles optionally in sub-clusters by year/month or week (e.g. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Engedély',
	'DefaultLicense'			=> 'Default license',
	'DefaultLicenseInfo'		=> 'Under which license should your content be released.',
	'EnableLicense'				=> 'Enable License',
	'EnableLicenseInfo'			=> 'Enable to show license information.',
	'LicensePerPage'			=> 'License per page',
	'LicensePerPageInfo'		=> 'Allow license per page, which the page owner can choose via page properties.',

	'ServicePagesSection'		=> 'Service pages',
	'RootPage'					=> 'Home page',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',

	'PrivacyPage'				=> 'Adatvédelmi irányelvek',
	'PrivacyPageInfo'			=> 'The page with the Privacy Policy of the site.',

	'TermsPage'					=> 'Policies and Regulations',
	'TermsPageInfo'				=> 'The page with the rules of the site.',

	'SearchPage'				=> 'Keresés',
	'SearchPageInfo'			=> 'Page with the search form (action %1).',
	'RegistrationPage'			=> 'Regisztráció',
	'RegistrationPageInfo'		=> 'Page new user registration (action %1).',
	'LoginPage'					=> 'User login',
	'LoginPageInfo'				=> 'Login page on the site (action %1).',
	'SettingsPage'				=> 'User Settings',
	'SettingsPageInfo'			=> 'Page customize the user profile (action %1).',
	'PasswordPage'				=> 'Change Password',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action %1).',
	'UsersPage'					=> 'User list',
	'UsersPageInfo'				=> 'Page with a list of registered users (action %1).',
	'CategoryPage'				=> 'Kategória',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action %1).',
	'TagPage'					=> 'Címke',
	'TagPageInfo'				=> 'Page with a list of tagged pages (action %1).',
	'GroupsPage'				=> 'Csoportok',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action %1).',
	'ChangesPage'				=> 'Friss változások',
	'ChangesPageInfo'			=> 'Page with a list of the last modified pages (action %1).',
	'CommentsPage'				=> 'Recent comments',
	'CommentsPageInfo'			=> 'Page with a list of recent comment on the page (action %1).',
	'RemovalsPage'				=> 'Deleted pages',
	'RemovalsPageInfo'			=> 'Page with a list of recently deleted pages (action %1).',
	'WantedPage'				=> 'Wanted pages',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action %1).',
	'OrphanedPage'				=> 'Orphaned pages',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related links with the rest (action %1).',
	'SandboxPage'				=> 'Sandbox',
	'SandboxPageInfo'			=> 'Page where users can be trained in the use of wiki-markup.',
	'HelpPage'					=> 'Segítség',
	'HelpPageInfo'				=> 'The documentation section for working with site tools.',
	'IndexPage'					=> 'Index',
	'IndexPageInfo'				=> 'Oldal az összes oldal listájával (action %1).',
	'RandomPage'				=> 'Lap találomra',
	'RandomPageInfo'			=> 'Véletlenszerű oldalt tölt be (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameters for notifications of the platform.',
	'NotificationSettingsUpdated'	=> 'Updated notification settings',

	'EmailNotification'			=> 'Email Notification',
	'EmailNotificationInfo'		=> 'Allow email notification. Set to ON to enable email notifications, OFF to disable them. Note that disabling email notifications has no effect on emails generated as part of the user signup process.',
	'Autosubscribe'				=> 'Autosubscribe',
	'AutosubscribeInfo'			=> 'Automatically sign a new page in the owner\'s notice of its changes.',

	'NotificationSection'		=> 'Default user notification settings',
	'NotifyPageEdit'			=> 'Notify page edit',
	'NotifyPageEditInfo'		=> 'Függőben - Sending a email notification only for the first change until the user visits the page again.',
	'NotifyMinorEdit'			=> 'Notify minor edit',
	'NotifyMinorEditInfo'		=> 'Sends notifications also for minor edits.',
	'NotifyNewComment'			=> 'Notify new comment',
	'NotifyNewCommentInfo'		=> 'Függőben - Sending a email notification only for the first comment until the user visits the page again.',

	'NotifyUserAccount'			=> 'Notify new user account',
	'NotifyUserAccountInfo'		=> 'The Admin will to be notified when a new user has been created using the signup form.',
	'NotifyUpload'				=> 'Notify file upload',
	'NotifyUploadInfo'			=> 'The Moderators will to be notified when a file has been uploaded.',

	'PersonalMessagesSection'	=> 'Személyes üzenetek',
	'AllowIntercomDefault'		=> 'Allow Intercom',
	'AllowIntercomDefaultInfo'	=> 'Enable this option allows other users sending personal messages to the recipient email-address without disclosing the address.',
	'AllowMassemailDefault'		=> 'Allow Massemail',
	'AllowMassemailDefaultInfo'	=> 'It send only messages to those user who allowed Administrators to email them information.',

	// Resync settings
	'Synchronize'				=> 'szinkronizálni',
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
	'RecompilePage'				=> 'Minden oldal újra összeállítása (rendkívül költséges)',
	'ResyncOptions'				=> 'További beállítások',
	'RecompilePageLimit'		=> 'Number of pages to parse at once.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Az alábbi információkat használja a fórum e-mailek küldésekor. Kérünk, győződj meg róla, hogy az e-mail cím, amit megadsz, helyes, mivel minden nem kézbesíthető levél erre a címre fog menni. Ha a tárhelyszolgáltatód nem biztosítja a natív (PHP alapú) e-mail küldést, használhatsz helyette SMTP-t. Ehhez szükség van egy megfelelő szerver címére (ha szükséges, kérdezd meg a szolgáltatód). Ha (és csak ha) a szerver megköveteli az azonosítást, add meg a szükséges felhasználónevet, jelszót és azonosítási módot.',

	'EmailSettingsUpdated'		=> 'Frissített e-mail beállítások',

	'EmailFunctionName'			=> 'E-mail függvény neve',
	'EmailFunctionNameInfo'		=> 'A függvény neve, amivel e-mailt lehet küldeni PHP-n keresztül.',
	'UseSmtpInfo'				=> '<code>SMTP</code> Állítsd igenre, ha a helyi mail függvény helyett egy meghatározott szerveren keresztül szeretnéd az e-maileket kiküldeni.',

	'EnableEmail'				=> 'Enable emails',
	'EnableEmailInfo'			=> 'Enabling emails',

	'FromEmailName'				=> 'From Name',
	'FromEmailNameInfo'			=> 'The sender name, part of <code>From:</code> header in emails for all the email-notification sent from the site.',
	'NoReplyEmail'				=> 'No-reply address',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all your email-notifications sent from the site.',
	'AdminEmail'				=> 'Email of the site owner',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.',

	'SendTestEmail'				=> 'Küldjön teszt e-mailt',
	'SendTestEmailInfo'			=> 'This will send a test email to the address defined in your account.',
	'TestEmailSubject'			=> 'Your Wiki is correctly configured to send emails',
	'TestEmailBody'				=> 'If you received this email, your Wiki is correctly configured to send emails.',
	'TestEmailMessage'			=> 'The test email has been sent.<br>If you don\'t receive it, please check your emails configuration.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'SMTP azonosítási mód',
	'SmtpConnectionModeInfo'	=> 'Csak akkor van használva, ha egy felhasználónév/jelszó páros meg van adva. Ha nem vagy biztos benne, melyik módot használd, kérdezd meg a szolgáltatódat.',
	'SmtpPassword'				=> 'SMTP jelszó',
	'SmtpPasswordInfo'			=> 'Csak akkor adj meg jelszót, ha a használt SMTP szerver megköveteli.<br><em><strong>Figyelmeztetés:</strong> Ez a jelszó az adatbázisban sima szövegként kerül tárolásra, így bárki által hozzáférhető, aki hozzáfér az adatbázishoz vagy látja ezt a beállítás oldalt.</em>',
	'SmtpPort'					=> 'SMTP szerver port',
	'SmtpPortInfo'				=> 'Csak akkor változtasd meg, ha tudod, hogy az SMTP szerver más porton van. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'SMTP szerver cím',
	'SmtpServerInfo'			=> 'Note that you have to provide the protocol that your server uses. If you are using SSL, this has to be <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> 'SMTP beállítások',
	'SmtpUsername'				=> 'SMTP felhasználónév',
	'SmtpUsernameInfo'			=> 'Csak akkor adj meg felhasználónevet, ha a használt SMTP szerver megköveteli.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Itt a csatolmányok főbb beállításait adhatod meg, valamint a speciális kategóriák egyedi opcióit módosíthatod.',
	'UploadSettingsUpdated'		=> 'Frissített feltöltési beállítások',

	'RightToUpload'				=> 'Fájlok feltöltési joga',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belonging to the admins group can upload  files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadOnlyImages'			=> 'Csak képek feltöltését engedélyezze',
	'UploadOnlyImagesInfo'		=> 'Csak képfájlok feltöltését engedélyezze az oldalon.',
	'FileUploads'				=> 'Fájl feltöltése',
	'UploadMaxFilesize'			=> 'Maximális állományméret',
	'UploadMaxFilesizeInfo'		=> 'Legfeljebb ekkorák lehetnek az állományok. A 0 érték kikapcsolja a korlátozást.',
	'UploadQuota'				=> 'Csatolmányok tárhelye',
	'UploadQuotaInfo'			=> 'Az egész fórumon a csatolmányok legfeljebb ekkora helyet foglalhatnak el összesen. A <code>0</code> érték kikapcsolja a korlátozást.',
	'UploadQuotaUser'			=> 'Tárolási kvóta felhasználónként',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with <code>0</code> being unlimited.',
	'CheckMimetype'				=> 'Csatolt állományok ellenőrzése',
	'CheckMimetypeInfo'			=> 'Néhány böngésző rávehető, hogy a feltöltött állományokhoz helytelen MIME típust állapítson meg. Ezzel a beállítással az ennek okozására hajlamos állományok visszautasításra kerülnek.',
	'TranslitFileName'			=> 'Transliterate file names',
	'TranslitFileNameInfo'		=> 'Ha alkalmazható, és nincs szükség Unicode karakterekre, akkor nagyon ajánlott csak alfa-numerikus karaktereket elfogadni.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Kiskép készítése',
	'CreateThumbnailInfo'		=> 'Minden lehetséges esetben készítsen kisképet.',
	'MaxThumbWidth'				=> 'Maximális kiskép szélesség pixelben',
	'MaxThumbWidthInfo'			=> 'A generált kiskép nem fogja túllépni az itt megadott szélességet.',
	'MinThumbFilesize'			=> 'Maximális kiskép állományméret',
	'MinThumbFilesizeInfo'		=> 'Ennél kisebb képeknél nem lesz kiskép készítve.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'List of removed pages, revisions and files.
									Finally remove or restore the pages, revisions or files from the database by clicking on the link <em>Remove</em>
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
	'NoColumnsToConvert'		=> 'No columns to convert.',
	'NoTablesToConvert'			=> 'No tables to convert.',

	'LogDatabaseConverted'		=> 'Database converted',
	'ConversionTablesOk'		=> 'Conversion of the selected tables successfully.',

	'LogColumnsToStrict'		=> 'Converted columns to comply with the SQL strict mode',
	'ConversionColumnsOk'		=> 'Conversion of the selected columns successfully.',

	'ConvertTablesEngine'		=> 'Converting Tables from MyISAM to InnoDB',
	'ConvertTablesEngineInfo'	=> 'If you have existing tables, that you want to convert to InnoDB for better reliability and scalability, use the following routine. These tables were originally MyISAM, which was formerly the default.',

	'DbVersionMin'				=> 'Requires at least MySQL 5.6.4, available version',
	'DbEngineOk'				=> 'InnoDB is available.',
	'DbEngineMissing'			=> 'InnoDB is not available.',
	'EngineTable'				=> 'Table',
	'EngineDefault'				=> 'Alapértelmezés',
	'EngineColumn'				=> 'Column',
	'EngineTyp'					=> 'Type',

	'ConvertColumnsToStrict'	=> 'Converting Columns to SQL strict',
	'ConvertTablesStrictInfo'	=> 'If you have existing tables, that you want to convert to comply with the SQL strict mode, use the following routine.',

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
	'LogUsername'				=> 'Felhasználónév',
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
	'MassemailInfo'				=> 'Itt egy e-mailt küldhetsz az összes olyan felhasználónak vagy egy meghatározott csoport olyan tagjainak, <strong>akinek be van kapcsolva a csoport e-mail fogadása beállítása</strong>. Ez a következő módon fog történni: a megadott adminisztrációs e-mail címre egy e-mail kerül kiküldésre, és a címzettek titkos másolatot kapnak ebből a levélből. Az alap beállítás szerint egy levélben csak 50 címzett fog szerepelni, több címzettnél több e-mail kerül kiküldésre. Ha sok embernek küldesz e-mailt, az űrlap elküldése után, kérünk, légy türelmes, ne szakítsd meg az oldal töltését félúton. Teljesen normális, hogy a csoportos e-mail küldése hosszú ideig tart; amint a szkript befejezte futását, értesítve leszel.',
	'LogMassemail'				=> 'Messemail send %1 to group / user ',
	'MassemailSend'				=> 'Massemail send',

	'NoEmailMessage'			=> 'Meg kell adnod az üzenetet.',
	'NoEmailSubject'			=> 'Meg kell adnod az üzenet témáját.',
	'NoEmailRecipient'			=> 'You must specify at least one user or user group.',

	'MassemailSection'			=> 'Mass email',
	'MessageSubject'			=> 'Téma',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Your message',
	'YourMessageInfo'			=> 'Kérjük, vedd figyelembe, csak sima szöveget adhatsz meg. Az elküldés előtt minden kód eltávolításra kerül.',

	'NoUser'					=> 'No user',
	'NoUserGroup'				=> 'No user group',

	'SendToGroup'				=> 'Címzett csoport',
	'SendToUser'				=> 'Címzett felhasználók',
	'SendToUserInfo'			=> 'It send only messages to those user who allowed Administrators to email them information. This option is available in their user settings under Notifications.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Updated system message',

	'SysMsgSection'				=> 'Rendszerüzenet',
	'SysMsg'					=> 'Rendszerüzenet',
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
	'Approve'					=> 'Jóváhagy',
	'Deny'						=> 'Deny',
	'Pending'					=> 'Függőben',
	'Approved'					=> 'Engedélyezve',
	'Denied'					=> 'Denied',

	// DB Backup module
	'BackupStructure'			=> 'Structure',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Folder',
	'BackupTable'				=> 'Table',
	'BackupCluster'				=> 'Cluster',
	'BackupFiles'				=> 'Fájlok',
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
	'Backup'					=> 'Kimentés',

	// DB Restore module
	'RestoreInfo'				=> 'You can restore any of the backup packages found or remove it from the server.',
	'ConfirmDbRestore'			=> 'Vissza szeretné állítani az %1 biztonsági mentést?',
	'ConfirmDbRestoreInfo'		=> 'Kérjük, várjon, ez néhány percet vehet igénybe.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'DirectoryNotExecutable'	=> 'A %1 könyvtár nem futtatható.',
	'BackupDelete'				=> 'Biztosan el akarja távolítani az %1 biztonsági mentést?',
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
	'RestoreFile'				=> 'Fájl',
	'Restored'					=> 'restored',
	'Skipped'					=> 'skipped',
	'FileRestoreDone'			=> 'Completed. Total files',
	'FilesAll'					=> 'mind',
	'SkipFiles'					=> 'Files are not stored - skip',
	'RestoreDone'				=> 'RESTORATION COMPLETED',

	'BackupCreationDate'		=> 'Creation Date',
	'BackupPackageContents'		=> 'The contents of the package',
	'BackupRestore'				=> 'Visszaállítás',
	'BackupRemove'				=> 'Eltávolítás',
	'RestoreYes'				=> 'Igen',
	'RestoreNo'					=> 'Nem',
	'LogDbRestored'				=> 'Backup ##%1## of the database restored.',

	// User module
	'UsersInfo'					=> 'Here you can change your users information and certain specific options.',

	'UsersAdded'				=> 'User added',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> 'Szerkesztés',
	'UsersAddNew'				=> 'Add new user',
	'UsersDelete'				=> 'Biztosan el akarja távolítani az %1 felhasználót?',
	'UsersDeleted'				=> 'The user %1 was deleted from the database.',
	'UsersRename'				=> 'Rename the user %1 to',
	'UsersRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that user.',
	'UsersUpdated'				=> 'User successfully updated.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Signuptime',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'No users that meet the criteria',

	'UserAccountNotify'			=> 'Értesítse a felhasználót',
	'UserNotifySignup'			=> 'tájékoztassa a felhasználót az új fiókról',
	'UserVerifyEmail'			=> 'állítsa be az e-mail megerősítő tokent és adjon hozzá linket az e-mail ellenőrzéséhez',
	'UserReVerifyEmail'			=> 'E-mail újraküldése megerősítés token',

	// Groups module
	'GroupsInfo'				=> 'From this panel you can administrate all your usergroups. You can delete, create and edit existing groups. Furthermore, you may choose group leaders, toggle open/hidden/closed group status and set the group name and description.',

	'LogMembersUpdated'			=> 'Updated usergroup members',
	'LogMemberAdded'			=> 'Added member ##%1## to group ##%2##',
	'LogMemberRemoved'			=> 'Removed member ##%1## from group ##%2##',
	'LogGroupCreated'			=> 'Created a new group ##%1##',
	'LogGroupRenamed'			=> 'Group ##%1## renamed to ##%2##',
	'LogGroupRemoved'			=> 'Removed group ##%1##',

	'GroupsMembersFor'			=> 'Members for Group',
	'GroupsDescription'			=> 'Leírás',
	'GroupsModerator'			=> 'Moderátor',
	'GroupsOpen'				=> 'Nyitott',
	'GroupsActive'				=> 'Aktív',
	'GroupsTip'					=> 'Click to edit Group',
	'GroupsUpdated'				=> 'Groups updated',
	'GroupsAlreadyExists'		=> 'This group already exists.',
	'GroupsAdded'				=> 'Group added successfully.',
	'GroupsRenamed'				=> 'Group successfully renamed.',
	'GroupsDeleted'				=> 'The group %1 was deleted from the database and all pages.',
	'GroupsAdd'					=> 'Add a new group',
	'GroupsRename'				=> 'Rename the group %1 to',
	'GroupsRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that group.',
	'GroupsDelete'				=> 'Biztosan el akarja távolítani a %1 csoportot?',
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
	'DbSize'					=> 'Méret',
	'DbIndex'					=> 'Index',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'File system Statistics',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> 'Fájlok',
	'FileSize'					=> 'Méret',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Version informations',
	'SysParameter'				=> 'Paraméter',
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
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memory',
	'UploadFilesizeMax'			=> 'Upload max filesize',
	'PostMaxSize'				=> 'Post max size',
	'MaxExecutionTime'			=> 'Max execution time',
	'SessionPath'				=> 'Session path',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip compression',
	'PhpExtensions'				=> 'PHP-kiterjesztések',
	'ApacheModules'				=> 'Apache modules',

	// DB repair module
	'DbRepairSection'			=> 'Javítási adatbázis',
	'DbRepair'					=> 'Javítási adatbázis',
	'DbRepairInfo'				=> 'This script can automatically look for some common database problems and repair them. Repairing can take a while, so please be patient.',

	'DbOptimizeRepairSection'	=> 'Javítás és optimalizálás adatbázisban',
	'DbOptimizeRepair'			=> 'Javítás és optimalizálás adatbázisban',
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
	'Inconsistencies'			=> 'Következetlenségek',
	'CheckDatabase'				=> 'Adatbázis',
	'CheckDatabaseInfo'			=> 'Checks for record inconsistencies in the database.',
	'CheckFiles'				=> 'Fájlok',
	'CheckFilesInfo'			=> 'Checks for abandoned files, files with no reference left in the file table.',
	'Records'					=> 'Records',
	'InconsistenciesNone'		=> 'No Data Inconsistencies found.',
	'InconsistenciesDone'		=> 'Data Inconsistencies solved.',
	'InconsistenciesRemoved'	=> 'Removed inconsistencies',
	'Check'						=> 'Check',
	'Solve'						=> 'Solve',

	// Bad Behavior module
	'BbInfo'					=> 'Detects and blocks unwanted Web accesses, deny automated spambots access<br>For more information please visit the %1 homepage.',
	'BbEnable'					=> 'Enable Bad Behavior',
	'BbEnableInfo'				=> 'All other settings can be changed in the config folder %1.',
	'BbStats'					=> 'Bad Behavior has blocked %1 access attempts in the last 7 days.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Log',
	'BbSettings'				=> 'Beállítások',
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
	'BbShow'					=> 'Megjelenítés',
	'BbIpDateStatus'			=> 'IP/Date/Status',
	'BbHeaders'					=> 'Headers',
	'BbEntity'					=> 'Entity',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Options saved.',
	'BbWhitelistHint'			=> 'Inappropriate whitelisting WILL expose you to spam, or cause Bad Behavior to stop functioning entirely! DO NOT WHITELIST unless you are 100% CERTAIN that you should.',
	'BbIpAddress'				=> 'IP Address',
	'BbIpAddressInfo'			=> 'IP address or CIDR format address ranges to be whitelisted (one per line)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL fragments beginning with the / after your web site hostname (one per line)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'User agent strings to be whitelisted (one per line)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Updated Bad Behavior settings',
	'BbLogRequest'				=> 'Logging HTTP request',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (recommended)',
	'BbLogOff'					=> 'Do not log (not recommended)',
	'BbSecurity'				=> 'Biztonság',
	'BbStrict'					=> 'Strict checking',
	'BbStrictInfo'				=> 'blocks more spam but may block some people',
	'BbOffsiteForms'			=> 'Allow form postings from other web sites',
	'BbOffsiteFormsInfo'		=> 'required for OpenID; increases spam received',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'To use Bad Behavior\'s http:BL features you must have an %1',
	'BbHttpblKey'				=> 'http:BL Access Key',
	'BbHttpblThreat'			=> 'Minimum Threat Level (25 is recommended)',
	'BbHttpblMaxage'			=> 'Maximum Age of Data (30 is recommended)',
	'BbReverseProxy'			=> 'Reverse Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'If you are using Bad Behavior behind a reverse proxy, load balancer, HTTP accelerator, content cache or similar technology, enable the Reverse Proxy option.<br>' .
									'If you have a chain of two or more reverse proxies between your server and the public Internet, you must specify <em>all</em> of the IP address ranges (in CIDR format) of all of your proxy servers, load balancers, etc. Otherwise, Bad Behavior may be unable to determine the client\'s true IP address.<br>' .
									'In addition, your reverse proxy servers must set the IP address of the Internet client from which they received the request in an HTTP header. If you don\'t specify a header, %1 will be used. Most proxy servers already support X-Forwarded-For and you would then only need to ensure that it is enabled on your proxy servers. Some other header names in common use include %2 and %3.',
	'BbReverseProxyEnable'		=> 'Enable Reverse Proxy',
	'BbReverseProxyHeader'		=> 'Header containing Internet clients IP address',
	'BbReverseProxyAddresses'	=> 'IP address or CIDR format address ranges for your proxy servers (one per line)',

];
