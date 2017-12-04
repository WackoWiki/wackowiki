<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'					=> 'Hinweis: Es wird empfolen den Zugang zur Site für administrative Wartungsarbeiten zu sperren.',

	'CategoryArray'		=> [
		'basics'		=> 'Grundfunktion',
		'preferences'	=> 'Einstellungen',
		'content'		=> 'Inhalt',
		'users'			=> 'Nutzer',
		'maintenance'	=> 'Wartung',
		'messages'		=> 'Mitteilung',
		'extension'		=> 'Erweiterung',
		'database'		=> 'Datenbank',
	],

	// Admin panel
	'AdminPanel'				=> 'Administrations-Bereich',
	'RecoveryMode'				=> 'Wiederherstellungs-Modus',
	'Authorization'				=> 'Autorisation',
	'AuthorizationTip'			=> 'Bitte gib das Administratorkennwort ein (und stelle sicher, dass Cookies von deinem Browser akzeptiert werden).',
	'NoRecoceryPassword'		=> 'Das Administrator-Passwort wurde nicht gesetzt!',
	'NoRecoceryPasswordTip'		=> 'Hinweis: Das Fehlen eines Administrator-Passworts ist eine Bedrohung für die Sicherheit! Gib das Passwort in der Konfigurationsdatei an und starte das Programm erneut.',

	'ErrorLoadingModule'		=> 'Fehler beim Laden des Admin-Moduls %1: existiert nicht.',

	'FormSave'					=> 'Speichern',
	'FormReset'					=> 'Zurücksetzen',
	'FormUpdate'				=> 'Aktualisieren',

	'ApHomePage'				=> 'Startseite',
	'ApHomePageTip'				=> 'Öffne die Startseite, beende nicht die Verwaltung ',
	'ApLogOut'					=> 'Abmelden',
	'ApLogOutTip'				=> 'Beende die Systemverwaltung',

	'TimeLeft'					=> 'Restzeit:  %1 Minuten',
	'ApVersion'					=> 'Version',

	'SiteOpen'					=> 'öffnen',
	'SiteOpened'				=> 'Website geöffnet',
	'SiteOpenedTip'				=> 'Die Website ist offen',
	'SiteClose'					=> 'schließen',
	'SiteClosed'				=> 'Website geschlossen',
	'SiteClosedTip'				=> 'Die Website ist geschlossen',

	// Generic
	'Cancel'					=> 'Abbrechen',
	'Add'						=> 'Hinzufügen',
	'Edit'						=> 'Bearbeiten',
	'Remove'					=> 'Entfernen',
	'Enabled'					=> 'aktiviert',
	'Disabled'					=> 'deaktiviert',
	'On'						=> 'an',
	'Off'						=> 'aus',
	'Mandatory'					=> 'zwingend',
	'Admin'						=> 'Admin',

	'MiscellaneousSection'		=> 'Sonstiges',
	'MainSection'				=> 'Basic Parameters',

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
		'name'		=> 'Allgemein',
		'title'		=> 'Grundeinstellungen',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Aussehen',
		'title'		=> 'Aussehen-Einstellungen',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-Mail',
		'title'		=> 'E-Mail-Einstellungen',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filter',
		'title'		=> 'Filter-Einstellungen',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatierer',
		'title'		=> 'Formatierungs-Einstellungen',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Mitteilungen',
		'title'		=> 'Einstellungen für Benachrichtigungen',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Seiten',
		'title'		=> 'Seiten und Website-Einstellungen',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Berechtigungen',
		'title'		=> 'Einstellungen für Berechtigungen',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Sicherheit',
		'title'		=> 'Sicherheits-Einstellungen',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'System',
		'title'		=> 'System-Einstellungen',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Hochladen',
		'title'		=> 'Anhang-Einstellungen',
	],

	// Categories module
	'content_categories'		=> [
		'name'		=> 'Kategorien',
		'title'		=> 'Kategorien verwalten',
	],

	// Comments module
	'content_comments'		=> [
		'name'		=> 'Kommentare',
		'title'		=> 'Kommentare verwalten',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Gelöscht',
		'title'		=> 'Neu gelöschte Inhalte',
	],

	// Files module
	'content_files'		=> [
		'name'		=> 'Dateien',
		'title'		=> 'Verwalte hochgeladene Dateien',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menü',
		'title'		=> 'Hinzufügen, Bearbeiten oder Entfernen von Standard-Menüpunkten',
	],

	// Pages module
	'content_pages'		=> [
		'name'		=> 'Seiten',
		'title'		=> 'Seiten verwalten',
	],

	// Polls module
	'content_polls'		=> [
		'name'		=> 'Umfragen',
		'title'		=> 'Bearbeiten, Starten und Stoppen von Abstimmungen',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Datensicherung',
		'title'		=> 'Daten sichern',
	],

	// DB Convert module
	'db_convert'		=> [
		'name'		=> 'Konvertieren',
		'title'		=> 'Konvertieren von Tabellen oder Spalten',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Reperatur',
		'title'		=> 'Datenbank reparieren und optimieren',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Wiederherstellung',
		'title'		=> 'Wiederherstellen von Sicherungsdaten',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Haupt-Menü',
		'title'		=> 'WackoWiki Administration',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inkonsistenzen',
		'title'		=> 'Inkonsistenzen beheben',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Daten-Synchronisation',
		'title'		=> 'Daten synchronisieren',
	],

	// Transliterate module
	'maint_transliterate'		=> [
		'name'		=> 'Transliteration',
		'title'		=> 'Aktualisiere den Supertag in den Datenbankdatensätzen',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Rundmail',
		'title'		=> 'Rundmail senden',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'System-Nachrichten',
		'title'		=> 'System-Nachrichten',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'System-Info',
		'title'		=> 'Systeminformationen',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System-Log',
		'title'		=> 'Protokoll der Systemereignisse',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistik',
		'title'		=> 'Zeige Statistiken',
	],

	// Bad Behavior module
	'badbehavior'		=> [
		'name'		=> 'Bad Behavior',
		'title'		=> 'Bad Behavior',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Freischaltung',
		'title'		=> 'Neu registrierte Benutzer zulassen',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Gruppen',
		'title'		=> 'Gruppen-Verwaltung',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Nutzer',
		'title'		=> 'Nutzer-Verwaltung',
	],


	'PurgeSessions'				=> 'entfernen',
	'PurgeSessionsTip'			=> 'Entferne alle Sitzungen',
	'PurgeSessionsConfirm'		=> 'Bist du dir sicher, daß du alle Sitzungen entfernen willst? Dies wird alle Nuzer abmelden.',
	'PurgeSessionsExplain'		=> 'Entferne alle Sitzungen. Dies wird alle Nuzer abmelden in dem es die auth_token Tabelle leert.',
	'PurgeSessionsDone'			=> 'Sitzungen erfolgreich enfernt.',

	// Basic settings

	'SiteName'					=> 'Name der Seite',
	'SiteNameInfo'				=> 'Der Titel der Seite im HTML-Kopf, erscheint im Browser Titel, Theme Header, bei Email Benachrichtigung, etc.',
	'SiteDesc'					=> 'Beschreibung der Seite',
	'SiteDescInfo'				=> 'Supplement to the title of the site that appears in the pages header to explain in a few words, what this site is about.',
	'AdminName'					=> 'Administrator der Seite',
	'AdminNameInfo'				=> 'User name, which is responsible for overall support of the site. This name is not used to determine access rights, but it is desirable to conform to the name of the chief administrator of the site.',

	'LanguageSection'			=> 'Sprache',
	'DefaultLanguage'			=> 'Default Sprache',
	'DefaultLanguageInfo'		=> 'Specifies the language for mapping unregistered guests, as well as the locale settings and the rules of transliteration of addresses of pages.',
	'MultiLanguage'				=> 'Unterstützung mehrerer Sprachen',
	'MultiLanguageInfo'			=> 'Include a choice of language on the page by page basis.',
	'AllowedLanguages'			=> 'Erlaubte Sprachen',
	'AllowedLanguagesInfo'		=> 'It is recomended to select only the set of languages you want to use, other wise all languages are selected.',

	'CommentSection'			=> 'Kommentare',
	'AllowComments'				=> 'Erlaube Kommentare',
	'AllowCommentsInfo'			=> 'Enable comments for guest or registered users only or disable them on the entire site.',
	'SortingComments'			=> 'Kommentare sortieren',
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
	'HideRevisions'				=> 'Revisionen ausblenden',
	'HideRevisionsInfo'			=> 'Die Standardanzeige der Revisionen der Seite.',
	'TocPanel'					=> 'Inhaltsverzeichnis',
	'TocPanelInfo'				=> 'Die Standardanzeige für das Inhaltsverzeichnis-Panel der Seite a page (may need support in the templates).',
	'SectionsPanel'				=> 'Sections panel',
	'SectionsPanelInfo'			=> 'By default display the panel of adjacent pages (requires support in the templates).',
	'DisplayingSections'		=> 'Displaying sections',
	'DisplayingSectionsInfo'	=> 'When the previous options, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>) or both, and other (<em>tree</em>).',
	'MenuItems'					=> 'Menüpunkte',
	'MenuItemsInfo'				=> 'Default number of shown menu items (may need support in the templates).',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Enable feeds',
	'EnableFeedsInfo'			=> 'Turns on or off RSS feeds for the entire wiki.',
	'XmlSitemap'				=> 'XML Sitemap',
	'XmlSitemapInfo'			=> 'Create an XML file called "sitemap-wackowiki.xml" inside the xml folder. Generate a Sitemaps XML format compatible XML file. You might want to change the path to output it in your root folder as that is one of the requirements i.e. that the XML file is in the root folder.',
	'XmlSitemapTime'			=> 'XML Sitemap generation time',
	'XmlSitemapTimeInfo'		=> 'Generate a Sitemaps only once in this number of days, zero means on every page change.',

	'DiffModeSection'			=> 'Diff Modes',
	'DefaultDiffModeSetting'	=> 'Default diff mode',
	'DefaultDiffModeSettingInfo'=> 'Preselected diff mode.',
	'AllowedDiffMode'			=> 'Allowed Diff modes',
	'AllowedDiffModeInfo'		=> 'It is recomended to select only the set of diff modes you want to use, other wise all diff modes are selected.',

	'EditSummary'				=> 'Edit summary',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Kleine Änderung',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'ReviewSettings'			=> 'Review',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',

	'PublishAnonymously'		=> 'Anonyme Veröffentlichung zulassen',
	'PublishAnonymouslyInfo'	=> 'Erlaubt den Benutzern, vorzugsweise anonym zu veröffentlichen (um den Namen zu verbergen).',
	'DefaultRenameRedirect'		=> 'When renaming put redirection',
	'DefaultRenameRedirectInfo'	=> 'By default, propose to redirect the old address pereimenuemoy page.',
	'StoreDeletedPages'			=> 'Gelöschte Seiten behalten',
	'StoreDeletedPagesInfo'		=> 'When you delete a page, a comment or a file put her in a special section where she had some time (below) will be available for viewing and recovery.',
	'KeepDeletedTime'			=> 'Aufbewahrungszeit für gelöschten Seiten',
	'KeepDeletedTimeInfo'		=> 'The period in days. It makes sense only if the previous option. Zero indicates the eternal possession (in this case the administrator can clear the "cart" manually).',
	'PagesPurgeTime'			=> 'Storage time of page revisions',
	'PagesPurgeTimeInfo'		=> 'Automatically delete the older edition of the number of days. If you enter zero, the old edition will not be removed.',
	'EnableReferrers'			=> 'Enable Referrers',
	'EnableReferrersInfo'		=> 'Ermöglicht das Speichern und Anzeigen externer Referrer.',
	'ReferrersPurgeTime'		=> 'Aufbewahrungszeit der Referrer',
	'ReferrersPurgeTimeInfo'	=> 'Keep history of invoking external pages no more than this number of days. Zero means the perpetual possession, but to actively visit the site this could lead to overcrowding in the database.',
	'AttachmentHandler'			=> 'Enable attachments handler',
	'AttachmentHandlerInfo'		=> 'Allows to show the attachments handler.',
	'SearchEngineVisibility'	=> 'Block search engines (Search Engine Visibility)',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site, It is up to search engines to honor this request.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Aussehen der Webseite ändern',
	'AppearanceSettingsUpdated'	=> 'Aussehen der Webseite wurde aktualisiert.',

	'LogoOff'					=> 'Aus',
	'LogoOnly'					=> 'Logo',
	'LogoAndTitle'				=> 'Logo und Titel',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Site Logo',
	'SiteLogoInfo'				=> 'Das Logo wird normalerweise in der oberen linken Ecke der Anwendung angezeigt. Die maximale Größe beträgt 2 MiB. Optimale Abmessungen sind 255 Pixel breit und 55 Pixel hoch.',
	'LogoDimensions'			=> 'Logo Maße',
	'LogoDimensionsInfo'		=> 'Breite und Höhe des angezeigten Logos.',
	'LogoDisplayMode'			=> 'Logo-Anzeigemodus',
	'LogoDisplayModeInfo'		=> 'Bestimmt wie und ob das Logo angezeigt wird. Standard ist ausgeschaltet.',
	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site Favicon',
	'SiteFaviconInfo'			=> 'Das Verknüpfungssymbol oder Favicon wird in der Adressleiste, den Registerkarten und den Lesezeichen der meisten Browser angezeigt. Dies überschreibt das Favicon deines Themas.',
	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Layout',
	'ThemeInfo'					=> 'Layout, welches die Site standardmäßig verwendet.',
	'ThemesAllowed'				=> 'Zulässige Layouts',
	'ThemesAllowedInfo'			=> 'Wähle die zulässigen Layouts aus, die der Benutzer verwenden kann, andernfalls sind alle verfügbaren Layouts zulässig.',
	'ThemesPerPage'				=> 'Layouts pro Seite',
	'ThemesPerPageInfo'			=> 'Erlaube Layouts pro Seite, welche der Seitenbesitzer über Seiteneigenschaften auswählen kann.',

	// System settings
	'SystemSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'SystemSettingsUpdated'		=> 'Updated system settings',

	'DebugModeSection'			=> 'Debug-Modus',
	'DebugMode'					=> 'Debug-Modus',
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

	'RewriteMode'				=> 'Use <code>mod_rewrite</code>',
	'RewriteModeInfo'			=> 'If your web server supports this feature, turn to get "beautiful" the addresses of pages.<br>
									<span class="cite">The value might be overwritten by the Settings class, despite you turn it off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parameters responsible for Access control and permissions.',
	'PermissionsSettingsUpdated'	=> 'Updated security settings',

	'PermissionsSection'		=> 'Rechte und Privilegien',
	'ReadRights'				=> 'Standard Lese-Rechte',
	'ReadRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine parental rights.',
	'WriteRights'				=> 'Standard Schreib-Rechte',
	'WriteRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine the parental rights.',
	'CommentRights'				=> 'Standard Kommentar-Rechte',
	'CommentRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine the parental rights.',
	'CreateRights'				=> 'Create rights of a sub page by default',
	'CreateRightsInfo'			=> 'Define the tolerance for the establishment of root pages and assign pages for which we can not determine the parental rights.',
	'UploadRights'				=> 'Standard Upload-Rechte',
	'UploadRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine parental rights.',
	'RenameRights'				=> 'Global rename right',
	'RenameRightsInfo'			=> 'List for admission to the possibility of free rename (move) pages.',

	'LockAcl'					=> 'Lock all ACL to read only',
	'LockAclInfo'				=> '<span class="cite">Overwrites the acl settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period for security reasons or as a emergency response.',
	'HideLocked'				=> 'Nicht zugängliche Seiten ausblenden',
	'HideLockedInfo'			=> 'If the user does not have permission to read the page, hide it in different page lists (however the link placed in text, will still be visible).',
	'RemoveOnlyAdmins'			=> 'Nur Administratoren können Seiten löschen',
	'RemoveOnlyAdminsInfo'		=> 'Deny all, except administrators, to delete pages. In the first limit applies to owners of normal pages.',
	'OwnersRemoveComments'		=> 'Seitenbesitzer können Kommentare löschen',
	'OwnersRemoveCommentsInfo'	=> 'Ermöglicht es Seitenbesitzern, Kommentare auf ihren Seiten zu moderieren.',
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
	'EnableCaptcha'				=> 'Aktiviere Captcha',
	'EnableCaptchaInfo'			=> 'If enabled, Captcha will be shown in the following cases or if a security threshold is reached.',
	'CaptchaComment'			=> 'Neuer Kommentar',
	'CaptchaCommentInfo'		=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before posting the comment.',
	'CaptchaPage'				=> 'Neue Seite',
	'CaptchaPageInfo'			=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before creating a new pages.',
	'CaptchaEdit'				=> 'Seite bearbeiten',
	'CaptchaEditInfo'			=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before editing pages.',
	'CaptchaRegistration'		=> 'Registrierung',
	'CaptchaRegistrationInfo'	=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before registering.',

	'TlsSection'				=> 'TLS Settings',
	'TlsConnection'				=> 'TLS-Connection',
	'TlsConnectionInfo'			=> 'Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS-certificate on the server , otherwise you will lose access to the admin panel!</span>',
	'TlsImplicit'				=> 'Forced TLS',
	'TlsImplicitInfo'			=> 'Force client reconnection from HTTP to HTTPS. When this option the customer can view the site for open HTTP-channel.',
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
	'UserPasswordSection'		=> 'Persistence of user passwords',
	'PwdMinChars'				=> 'Minimale Passwortlänge',
	'PwdMinCharsInfo'			=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 12 to 16 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'AdminPwdMinChars'			=> 'Minimale Admin Passwortlänge',
	'AdminPwdMinCharsInfo'		=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 15 to 20 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'PwdCharComplexity'			=> 'Die erforderliche Kennwortkomplexität',
	'PwdCharClasses'	=> [
		'0'		=> 'ungeprüft',
		'1'		=> 'alle Buchstaben + Zahlen',
		'2'		=> 'Groß- und Kleinschreibung + Zahlen',
		'3'		=> 'Groß- und Kleinschreibung + Zahlen + Zeichen',
	],
	'PwdUnlikeLogin'			=> 'zusätzliche Erschwernis',
	'PwdUnlikes'	=> [
		'0'		=> 'ungeprüft',
		'1'		=> 'Passwort darf nicht identisch mit dem Anmeldenamen sein',
		'2'		=> 'Passwort darf nicht den Anmeldenamen enthalten',
	],

	'LoginSection'				=> 'Anmeldung',
	'MaxLoginAttempts'			=> 'Maximale Anzahl von Anmeldeversuchen pro Nutzername',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximale Anzahl von Anmeldeversuchen pro IP-Adresse',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'LogSection'				=> 'Protokolleinstellungen',
	'LogLevel'					=> 'Protokollierung verwenden',
	'LogLevelInfo'				=> 'Die Mindestpriorität der Ereignisse, die im Protokoll aufgezeichnet wurden.',
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
	'LogPurgeTime'				=> 'Aufbewahrungszeit für das Ereignisprotokoll',
	'LogPurgeTimeInfo'			=> 'Entfernt das Ereignisprotokoll nach der angegebenen Anzahl von Tagen.',

	'FormsSection'				=> 'Forms',
	'FormTokenTime'				=> 'Maximale Zeit für die Übermittlung von Formularen',
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
	'AllowRawhtmlInfo'			=> 'Use this option to open a potentially unsafe site.',
	'SafeHtml'					=> 'Filtering HTML',
	'SafeHtmlInfo'				=> 'Blocks dangerous HTML-conservation facilities. Turn off the filter to open the site when the support HTML <span class="underline">very</span> undesirable!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formatter)',
	'X11colors'					=> 'X11 Colors Usage',
	'X11colorsInfo'				=> 'Extents the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code> Unsetting slightly speed up the process of adding comments and save the page.',
	'TikiLinks'					=> 'Disable Tikilinks',
	'TikiLinksInfo'				=> 'Disables linking for <code>Double.CamelCaseWords</code>.',
	'WikiLinks'					=> 'Disable Wikilinks',
	'WikiLinksInfo'				=> 'Disables linking for <code>CamelCaseWords</code>, your CamelCase Words will no longer be linked directly to a new page. This is useful when you work across different namespaces aks clusters. By default it is off.',
	'BracketsLinks'				=> 'Disable bracketslinks',
	'BracketsLinksInfo'			=> 'Disables <code>[[link]]</code> and <code>((link))</code> syntax.',
	'Formatters'				=> 'Disable Formatters',
	'FormattersInfo'			=> 'Disables <code>%%code%%</code> syntax, used for highlighters.',

	'DateFormatsSection'		=> 'Datumsformate',
	'DateFormat'				=> 'Das Format des Datums',
	'DateFormatInfo'			=> '(Tag, Monat, Jahr)',
	'TimeFormat'				=> 'Das Format der Zeit',
	'TimeFormatInfo'			=> '(Stunde, Minute)',
	'TimeFormatSeconds'			=> 'Das Format der genauen Zeit',
	'TimeFormatSecondsInfo'		=> '(Stunden, Minuten, Sekunden)',
	'NameDateMacro'				=> 'Das Format des <code>::@::</code> Makros',
	'NameDateMacroInfo'			=> '(Name, Zeit), e.g. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Zeitzone',
	'TimezoneInfo'				=> 'Timezone to use for displaying times to users who are not logged in (guests). Logged in users set and can change their timezone it in their user settings.',
	'EnableDst'					=> 'Sommerzeit aktivieren',
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
	'YouareHereText'			=> 'Deaktiviert und visualisiert selbstreferenzierende Links',
	'YouareHereTextInfo'		=> 'Visualizing links to the same page, try to <code>&lt;b&gt;####&lt;/b&gt;</code>, all links-to-self became not links, but bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> '',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Anzahl der Datensätze pro Liste',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster Forum',
	'ForumClusterInfo'			=> 'Address of the index (main) page of the forum.',
	'ForumTopics'				=> 'Anzahl der Themen pro Seite',
	'ForumTopicsInfo'			=> 'Number of topics displayed on each page of the list in the forum sections.',
	'CommentsCount'				=> 'Anzahl der Kommentare pro Seite',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page list of comments. This applies to all the comments on the site, and not just posted in the forum.',

	'NewsSection'				=> 'Nachrichten',
	'NewsCluster'				=> 'Cluster for the News',
	'NewsClusterInfo'			=> 'Root cluster for news section.',
	'NewsLevels'				=> 'Depth of news pages from the root cluster',
	'NewsLevelsInfo'			=> 'Regular expression (SQL regexp-slang), specifying the number of intermediate levels of the news root cluster directly to the names of pages of news reports. (e.g. <code>[cluster]/[year]/[month]</code> -> <code>/.+/.+/.+</code>)',

	'LicenseSection'			=> 'Lizenz',
	'DefaultLicense'			=> 'Standard-Lizenz',
	'DefaultLicenseInfo'		=> 'Unter welcher Lizenz sollen deine Inhalte veröffentlicht werden?',

	'ServicePagesSection'		=> 'Service pages',
	'RootPage'					=> 'Startseite',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',
	'PolicyPage'				=> 'Policies and Regulations',
	'PolicyPageinfo'			=> 'The page with the rules of the site.',
	'SearchPage'				=> 'Suche',
	'SearchPageInfo'			=> 'Page with the search form (action <code>{{search}}</code>).',
	'RegistrationPage'			=> 'Register on our site',
	'RegistrationPageInfo'		=> 'Page new user registration (action <code>{{registration}}</code>).',
	'LoginPage'					=> 'Benutzer-Anmeldung',
	'LoginPageInfo'				=> 'Login page on the site (action <code>{{login}}</code>).',
	'SettingsPage'				=> 'Benutzereinstellungen',
	'SettingsPageInfo'			=> 'Page customize the user profile (action <code>{{usersettings}}</code>).',
	'PasswordPage'				=> 'Passwort ändern',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action <code>{{changepassword}}</code>).',
	'UsersPage'					=> 'Benutzerliste',
	'UsersPageInfo'				=> 'Page with a list of registered users (action <code>{{users}}</code>).',
	'CategoryPage'				=> 'Kategorien',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action <code>{{category}}</code>).',
	'TagPage'					=> 'Tag',
	'TagPageInfo'				=> 'Page with a list of tagged pages (action <code>{{tag}}</code>).',
	'GroupsPage'				=> 'Gruppen',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action <code>{{usergroups}}</code>).',
	'ChangesPage'				=> 'Letzte Änderungen',
	'ChangesPageInfo'			=> 'Page with a list of the last modified pages (action <code>{{changes}}</code>).',
	'CommentsPage'				=> 'Letzte Kommentare',
	'CommentsPageInfo'			=> 'Page with a list of recent comment on the page (action <code>{{commented}}</code>).',
	'RemovalsPage'				=> 'Gelöschte Seiten',
	'RemovalsPageInfo'			=> 'Page with a list of recently deleted pages (action <code>{{deleted}}</code>).',
	'WantedPage'				=> 'Wanted pages',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action <code>{{wanted}}</code>).',
	'OrphanedPage'				=> 'Verwaiste Seiten',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related links with the rest (action <code>{{orphaned}}</code>).',
	'TodoPage'					=> 'ToDo',
	'TodoPageInfo'				=> 'Page with a list of To Do (constructed with the help of <code>{{backlinks}}</code> and makro <code>::*::</code>).',
	'SandboxPage'				=> 'Sandkasten',
	'SandboxPageInfo'			=> 'Page where users can be trained in the use of wiki-markup.',
	'WikiDocsPage'				=> 'Wiki-Dokumentation',
	'WikiDocsPageInfo'			=> 'Section of the documentation for using the tool site.',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameters for notifications of the platform.',
	'NotificationSettingsUpdated'	=> 'Updated notification settings',

	'EmailNotification'			=> 'E-Mail-Benachrichtigung',
	'EmailNotificationInfo'		=> 'Allow email notification. Set to ON to enable email notifications, OFF to disable them. Note that disabling email notifications has no effect on emails generated as part of the user signup process.',
	'Autosubscribe'				=> 'Autosubscribe',
	'AutosubscribeInfo'			=> 'Automatically sign a new page in the owner\'s notice of its changes.',

	'NotificationSection'		=> 'Standardeinstellungen für Benutzerbenachrichtigungen',
	'NotifyPageEdit'			=> 'Seitenänderung mitteilen',
	'NotifyPageEditInfo'		=> 'Pending - Sending a email notification only for the first change until the user visits the page again.',
	'NotifyMinorEdit'			=> 'Kleine Änderung mitteilen',
	'NotifyMinorEditInfo'		=> 'Sends notifications also for minor edits.',
	'NotifyNewComment'			=> 'Neuen Kommentar mitteilen',
	'NotifyNewCommentInfo'		=> 'Pending - Sending a email notification only for the first comment until the user visits the page again.',
	'NotifyUserAccount'			=> 'Neues Benutzerkonto mitteilen',
	'NotifyUserAccountInfo'		=> 'The Admin will to be notified when a new user has been created using the "signup form".',


	// Resync settings
	'UserStatsSynched'			=> 'Benutzerstatistiken wurden synchronisiert.',
	'PageStatsSynched'			=> 'Seitenstatistiken wurden synchronisiert.',
	'FeedsUpdated'				=> 'RSS-Feeds aktualisiert.',
	'SiteMapCreated'			=> 'Die neue Version der Sitemap wurde erfolgreich erstellt.',
	'WikiLinksRestored'			=> 'Wiki-Links wiederhergestellt.',

	'UserStats'					=> 'Benutzerstatistik',
	'UserStatsInfo'				=> 'Benutzerstatistiken (Anzahl der Kommentare, besessene Seiten, Revisionen und Dateien) können in einigen Situationen von den tatsächlichen Daten abweichen.<br> Diese Operation ermöglicht das Aktualisieren von Statistiken auf aktuelle tatsächliche Daten der Datenbank.',
	'PageStats'					=> 'Seitenstatistiken',
	'PageStatsInfo'				=> 'Seitenstatistiken (Anzahl der Kommentare, Dateien und Revisionen) können in einigen Situationen von den tatsächlichen Daten abweichen. <br> Diese Operation ermöglicht das Aktualisieren von Statistiken auf aktuelle tatsächliche Daten der Datenbank.',
	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'Im Falle der direkten Bearbeitung von Seiten in der Datenbank spiegelt der Inhalt der RSS-Feeds möglicherweise nicht die vorgenommenen Änderungen wider. <br> Diese Funktion synchronisiert die RSS-Kanäle mit dem aktuellen Zustand der Datenbank.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'Diese Funktion synchronisiert die XML-Sitemap mit dem aktuellen Zustand der Datenbank.',
	'WikiLinksResync'			=> 'Wiki-Links',
	'WikiLinksResyncInfo'		=> 'Führt ein Re-Rendering für alle Intrasite-Links durch und stellt den Inhalt der Tabelle <code> page_link </code> und <code> file_link </code> im Falle einer Beschädigung oder Verlagerung wieder her (dies kann einige Zeit in Anspruch nehmen).',

	// Email settings
	'EmaiSettingsInfo'			=> 'Diese Informationen werden benötigt, um E-Mails an die Benutzer zu senden. Stelle bitte sicher, dass die angegebene Adresse gültig ist; abgewiesene oder nicht zustellbare Nachrichten werden an diese Adresse geschickt. Falls dein Webhosting-Provider keinen PHP-basierten E-Mail-Dienst anbietet, können die Nachrichten auch direkt über SMTP versendet werden. Dies erfordert die Angabe der Adresse eines geeigneten Servers (frage falls nötig deinen Provider). Falls der Server eine Authentifizierung erfordert (und nur, wenn dies der Fall ist), gib den Benutzernamen und das Passwort ein und wähle eine Authentifizierungsmethode aus.',

	'EmailSettingsUpdated'		=> 'E-Mail Einstellungen wurden aktualisiert.',

	'EmailFunctionName'			=> 'Name der E-Mail-Funktion',
	'EmailFunctionNameInfo'		=> 'Die PHP-Funktion, die genutzt wird, um E-Mails zu versenden.',
	'UseSmtpInfo'				=> 'Wähle <code>SMTP</code> aus, wenn du E-Mails über einen SMTP-Server senden möchtest (oder musst), anstatt die PHP-eigene Mail-Funktion zu nutzen.',

	'EnableEmail'				=> 'Aktiviere E-Mail',
	'EnableEmailInfo'			=> 'Aktiviere E-Mail-Funktionalität',

	'FromEmailName'				=> 'Absender',
	'FromEmailNameInfo'			=> 'Absender Name, im Adressfeld <code>Von:</code> der Kopfzeile in E-Mails für alle E-Mail-Benachrichtigungen, die von dieser Seite gesendet werden.',
	'NoReplyEmail'				=> 'No-reply Adresse',
	'NoReplyEmailInfo'			=> 'Diese Adresse, z.B. <code>noreply@example.com</code>, erscheint im Adressfeld <code>Von:</code> der Kopfzeile bei allen E-Mail Benachrichtigungen, die von dieser Seite gesendet werden.',
	'AdminEmail'				=> 'E-Mail Adresse des Seiteninhabers',
	'AdminEmailInfo'			=> 'Diese Adresse ist für Administrationszwecke, wie Benachrichtigung bei neuen Benutzern.',
	'AbuseEmail'				=> 'Dienst bei E-Mail-Missbrauch',
	'AbuseEmailInfo'			=> 'Adresse für dringende Angelegenheiten: Registrierung einer verdächtigen E-Mail, usw. Kann mit der vorherigen übereinstimmen.',

	'SendTestEmail'				=> 'Test-Mail senden',
	'SendTestEmailInfo'			=> 'Sendet eine Test-Mail an die in deinem Benutzerkonto hinterlegte Adresse.',
	'TestEmailSubject'			=> 'Dein Wiki ist für den E-Mail-Versand richtig konfiguriert',
	'TestEmailBody'				=> 'Wenn du diese Nachricht erhältst, ist deine Wiki richtig für den E-Mail-Versand konfiguriert.',
	'TestEmailMessage'			=> 'Die Test-Mail wurde gesendet.<br>Falls du sie nicht erhalten solltest, prüfe bitte deine E-Mail-Konfiguration.',

	'SmtpAutoTls'				=> 'STARTTLS',
	'SmtpAutoTlsInfo'			=> 'Aktiviert Verschlüsselung automatisch, wenn der Server TLS Verschlüsselung anbietet (nach dem Aufbau der Serververbindung), sogar wenn <code>SMTPSecure</code> nicht eingeschaltet wurde.',
	'SmtpConnectionMode'		=> 'Authentifizierungsmethode für SMTP',
	'SmtpConnectionModeInfo'	=> 'Nur benötigt, wenn ein Benutzername/Passwort eingegeben ist. Frage deinen Webhosting-Provider, falls du nicht sicher bist, welche Methode du wählen sollst.',
	'SmtpPassword'				=> 'SMTP-Passwort',
	'SmtpPasswordInfo'			=> 'Gib nur ein Passwort ein, wenn dein SMTP-Server dies erfordert. <em><strong>WARNUNG:</strong> Dieses Passwort wird im Klartext in der Datenbank gespeichert und ist daher für jeden einsehbar, der Zugriff auf die Datenbank oder diese Konfigurationsseite hat.</em>',
	'SmtpPort'					=> 'SMTP-Server-Port',
	'SmtpPortInfo'				=> 'Ändere diese Einstellung nur, wenn du weißt, dass dein SMTP-Server einen anderen Port nutzt. <br>(default: <code>tls</code> auf Port 587 (oder möglicherweise 25) und <code>ssl</code> auf Port 465)',
	'SmtpServer'				=> 'SMTP-Server-Adresse',
	'SmtpServerInfo'			=> 'Beachte, dass du das Protokoll angeben musst, das dein Server verwendet. Wird SSL verwendet, musst du <code>ssl://mail.example.com</code> angeben.',
	'SmtpSettings'				=> 'SMTP-Einstellungen',
	'SmtpUsername'				=> 'SMTP-Benutzername',
	'SmtpUsernameInfo'			=> 'Gib nur einen Benutzernamen ein, wenn dein SMTP-Server dies erfordert.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Hier kannst du die Einstellungen für Dateianhänge und verknüpfte Spezialkategorien vornehmen.',
	'UploadSettingsUpdated'		=> 'Updated upload settings',

	'RightToUpload'				=> 'Berechtigung Dateien hochzuladen',
	'RightToUploadInfo'			=> '<code>admins</code> bedeutet nur Nutzer welche der Admins-Gruppe angehören, können Dateien hochladen. <code>1</code> bedeutet jeder registrierte Benutzer kann Dateien hochladen. <code>0</code> das Hochladen von Dateien ist nicht möglich.',
	'UploadOnlyImages'			=> 'Erlaube nur das Hochladen von Bildern',
	'UploadOnlyImagesInfo'		=> 'Nur Bilder können hochgeladen werden.',
	'FileUploads'				=> 'Dateien hochladen',
	'UploadMaxFilesize'			=> 'Maximale Dateigröße',
	'UploadMaxFilesizeInfo'		=> 'Maximale Größe pro Datei. Die Dateigröße wird nur durch die PHP-Konfiguration beschränkt, wenn 0 als Wert eingestellt wird.',
	'UploadQuota'				=> 'Maximales Kontingent für Dateianhänge',
	'UploadQuotaInfo'			=> 'Maximaler für Dateianhänge verfügbarer Speicherplatz für das gesamte Wiki; 0 bedeutet unbegrenzt.',
	'UploadQuotaUser'			=> 'Speicherkontingent pro Benutzer',
	'UploadQuotaUserInfo'		=> 'Beschränkung des Speicherkontingentes, der von einem Benutzer hochgeladen werden kann, wobei 0 unbegrenzt ist.',
	'CheckMimetype'				=> 'Dateianhänge prüfen',
	'CheckMimetypeInfo'			=> 'Manchen Browsern kann ein fehlerhafter MIME-Typ für hochgeladene Dateien vorgetäuscht werden. Diese Option stellt sicher, dass Dateien, die dieses Verhalten provozieren könnten, abgewiesen werden.',

	'Thumbnails'				=> 'Vorschaubilder',
	'CreateThumbnail'			=> 'Vorschaubild erstellen',
	'CreateThumbnailInfo'		=> 'Vorschaubild in allen möglichen Fällen erstellen.',
	'MaxThumbWidth'				=> 'Maximale Breite der Vorschaubilder in Pixeln',
	'MaxThumbWidthInfo'			=> 'Ein Vorschaubild wird nicht breiter sein als der hier eingestellte Wert.',
	'MinThumbFilesize'			=> 'Minimale Vorschaubild-Dateigröße',
	'MinThumbFilesizeInfo'		=> 'Erstellt keine Vorschaubilder bei Bildern, die kleiner sind als dieser Wert.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Liste der entfernten Seiten und Dateien.
									Finally remove or restore the pages or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Log module
	'LogFilterTip'				=> 'Filtere Ereignisse nach Kriterien',
	'LogLevel'					=> 'Stufe',
	'LogLevelFilters'	=> [
		'1'		=> 'nicht weniger als',
		'2'		=> 'nicht höher als',
		'3'		=> 'gleich',
	],
	'LogNoMatch'				=> 'Keine Ereignisse, die die Kriterien erfüllen',
	'LogDate'					=> 'Datum',
	'LogEvent'					=> 'Ereignis',
	'LogUsername'				=> 'Benutzername',
	'LogLevels'	=> [
		'1'		=> 'kritisch',
		'2'		=> 'höchste',
		'3'		=> 'hoch',
		'4'		=> 'mittel',
		'5'		=> 'niedrig',
		'6'		=> 'unterste',
		'7'		=> 'debugging',
	],

	// Massemail
	'SendToGroup'				=> 'Sende an Nutzergruppe',
	'SendToUser'				=> 'Sende an Nutzer',

	// User approval module
	'UserApproveInfo'			=> 'Schalte neue Benutzer frei, damit sie sich auf der Seite anmelden können.',
	'Approve'					=> 'Zulassen',
	'Deny'						=> 'Ablehnen',
	'Pending'					=> 'Ausstehend',
	'Approved'					=> 'Bestätigt',
	'Denied'					=> 'Abgelehnt',

	// DB Backup module
	'BackupStructure'			=> 'Struktur',
	'BackupData'				=> 'Daten',
	'BackupFolder'				=> 'Ordner',
	'BackupTable'				=> 'Tabelle',
	'BackupCluster'				=> 'Cluster',
	'BackupFiles'				=> 'Dateien',
	'BackupSettings'			=> 'Wähle das gewünsche Datensicherungs-Schema.<br>' .
									'Der Stammcluster wirkt sich nicht auf die Sicherung der globalen Dateisicherung und der Cache-Dateien aus (die Auswahl wird immer vollständig gespeichert).<br>' .
									'<br>' .
									'<strong>Achtung</strong>: Um den Verlust von Informationen aus der Datenbank bei der Angabe des Root-Clusters zu vermeiden, werden die Tabellen aus dieser Sicherung nicht umstrukturiert, '.
									'auch wenn nur die Tabellenstruktur gesichert wird, ohne die Daten zu speichern. '.
									'Um eine vollständige Konvertierung der Tabellen in das Backup-Format vorzunehmen, muss eine <em> vollständigen Datenbanksicherung (Struktur und Daten) ohne Angabe des Clusters</em> gemacht werden.',
	'BackupCompleted'			=> 'Sichern und Archivieren abgeschlossen.<br>' .
									'Die Sicherungspaketdateien wurden im Unterverzeichnis %1 abgelegt.<br>' .
									'Um es herunterzuladen verwende FTP (verändere die Verzeichnisstruktur und die Dateinamen beim Kopieren nicht).<br>' .
									'Um eine Sicherungskopie wiederherzustellen oder ein Paket zu entfernen, gehe zu <a href="?mode=db_restore">Datenbank wiederherstellen</a>.',
	'LogSavedBackup'			=> 'Sicherungskopie gespeichert ##%1##',

	// DB Restore module
	'RestoreInfo'				=> 'Du kannst jedes gefundene Sicherungsspaket wiederherstellen oder vom Server entfernen.',
	'ConfirmDbRestore'			=> 'Möchtest du die Datensicherung wiederherstellen',
	'ConfirmDbRestoreInfo'		=> 'Bitte warte dies kann einige Minuten benötigen.',
	'RestoreWrongVersion'		=> 'WackoWiki Version stimmt nicht überein!',
	'BackupDelete'				=> 'Willst du die Datensicherung wirklich entfernen',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Zusätzliche Otionen zur Daten-Wiederherstellung',
	'RestoreOptionsInfo'		=> '* Vor dem Wiederherstellen der <strong>Cluster-Sicherung</strong>, '.
									'werden die Zieltabellen nicht zerstört (um den Verlust von Informationen aus den Clustern, die nicht gesichert wurden, zu verhindern).. '.
									'Somit werden während des Wiederherstellungsvorgangs doppelte Datensätze auftreten. '.
									'Im normalen Modus werden alle Dateien durch die Datensätze ersetzt (mit SQL-Anweisung <code>REPLACE</code>), '.
									'aber wenn dieses Kontrollkästchen aktiviert ist, werden alle Duplikate übersprungen (die aktuellen Werte der Datensätze werden beibehalten), '.
									'und nur die Datensätze mit neuem Schlüssel werden in die Tabelle aufgenommen (SQL-Anweisung <code>INSERT IGNORE</code>).<br>' .
									'<strong>Hinweis</strong>: Wenn Sie eine vollständige Sicherung der Site wiederherstellen, hat diese Option keinen Zweck.<br>' .
									'<br>' .
									'** Wenn die Sicherung die Benutzerdateien (global und perpage, Cache-Dateien usw.) enthält, '.
									'ersetzen sie im normalen Modus die vorhandenen Dateien mit denselben Namen und werden beim Wiederherstellen in demselben Verzeichnis abgelegt. '.
									'Mit dieser Option kann man die aktuellen Kopien der Dateien speichern und aus einer Sicherung nur neue Dateien (fehlt auf dem Server) wiederherstellen.',
	'IgnoreDuplicatedKeys'		=> 'Ignoriere doppelte Tabellenschlüssel (nicht ersetzen)',
	'IgnoreSameFiles'			=> 'Ignoriere die gleichen Dateien (nicht überschreiben)',
	'NoBackupsAvailable'		=> 'Keien Datensicherung verfügbar.',
	'BackupEntireSite'			=> 'Gesamte Website',
	'BackupRestored'			=> 'Die Datensicherung wurde wiederhergestellt, ein zusammenfassender Bericht ist angefügt. Um die Dateien zu dieser Datensicherung zu löschen, klicke bitte',
	'BackupRemoved'				=> 'Die ausgewählte Datensicherung wurde erfolgreich entfernt.',
	'LogRemovedBackup'			=> 'Sicherungskopie gelöscht ##%1##',

	// User module
	'UsersAdded'				=> 'Benutzer hinzugefügt',
	'UsersDeleteInfo'			=> '[Informationen an Benutzer zur Löschung hier..]',
	'UserEditButton'			=> 'Bearbeiten',
	'UserEnabled'				=> 'Aktiviert',
	'UsersAddNew'				=> 'Füge einen neuen Benutzer hinzu',
	'UsersDelete'				=> 'Bist du dir sicher das du den Benutzer entfernen willst ',
	'UsersDeleted'				=> 'Der Benutzer wurde aus der Datenbank entfernt.',
	'UsersRename'				=> 'Benutzer umbenennen',
	'UsersRenameInfo'			=> '* Hinweise: Die Änderung wirkt sich auf alle Seiten aus, die diesem Benutzer zugeordnet sind.',
	'UsersUpdated'				=> 'Benutzer erfolgreich aktualisiert.',

	'UserName'					=> 'Benutzername',
	'UserRealname'				=> 'Realname',
	'UserEmail'					=> 'E-Mail',
	'UserIP'					=> 'IP',
	'UserLanguage'				=> 'Sprache',
	'UserSignuptime'			=> 'Anmeldung',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'Keine Benutzer, welche diese Kriterien erfüllen.',

	// Groups module
	'GroupsMembersFor'			=> 'Mitglieder der Gruppe',
	'GroupsDescription'			=> 'Beschreibung',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Offen',
	'GroupsActive'				=> 'Aktiv',
	'GroupsTip'					=> 'Klicke um die Gruppe zu bearbeiten',
	'GroupsUpdated'				=> 'Gruppen aktualisiert',
	'GroupsAlreadyExists'		=> 'Diese Gruppe gibt es bereits.',
	'GroupsAdded'				=> 'Gruppe erfolgreich hinzugefügt.',
	'GroupsRenamed'				=> 'Gruppe erfolgreich umbenannt.',
	'GroupsDeleted'				=> 'Die Gruppe und alle Mitglieder wurde aus der Datenbank gelöscht.',
	'GroupsAdd'					=> 'Eine neue Gruppe hinzufügen',
	'GroupsRename'				=> 'Gruppe umbenennen',
	'GroupsRenameInfo'			=> '* Hinweis: Die Änderung wirkt sich auf alle Seiten aus, die dieser Gruppe zugeordnet sind.',
	'GroupsDelete'				=> 'Bist du dir sicher das du die Gruppe entfernen möchtest ',
	'GroupsDeleteInfo'			=> '* Hinweis: Die Änderung wirkt sich auf alle Mitglieder aus, die dieser Gruppe zugeordnet sind.',
	'GroupsStoreButton'			=> 'Speichere Gruppen',
	'GroupsSaveButton'			=> 'Absenden',
	'GroupsCancelButton'		=> 'Abbrechen',
	'GroupsAddButton'			=> 'Hinzufügen',
	'GroupsEditButton'			=> 'Bearbeiten',
	'GroupsRemoveButton'		=> 'Entfernen',
	'GroupsEditInfo'			=> 'Zum Bearbeiten der Gruppen-Liste wähle das Optionsfeld',

	'MembersAddNew'				=> 'Neues Mitglied hinzufügen',
	'MembersAdded'				=> 'Neues Mitglied der Gruppe erfolgreich hinzugefügt.',
	'MembersRemove'				=> 'Bist du dir sicher das du das Mitglied enfernen möchtest ',
	'MembersRemoved'			=> 'Das Mitglied wurde aus der Gruppe entfernt.',
	'MembersDeleteInfo'			=> '* Hinweis: Die Änderung wirkt sich auf alle Mitglieder aus, die dieser Gruppe zugeordnet sind.',

];

?>
