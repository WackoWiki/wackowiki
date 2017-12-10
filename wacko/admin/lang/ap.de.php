<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'					=> 'Hinweis: Es wird empfolen den Zugang zur Site f�r administrative Wartungsarbeiten zu sperren.',

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
	'NoRecoceryPasswordTip'		=> 'Hinweis: Das Fehlen eines Administrator-Passworts ist eine Bedrohung f�r die Sicherheit! Gib das Passwort in der Konfigurationsdatei an und starte das Programm erneut.',

	'ErrorLoadingModule'		=> 'Fehler beim Laden des Admin-Moduls %1: existiert nicht.',

	'FormSave'					=> 'Speichern',
	'FormReset'					=> 'Zur�cksetzen',
	'FormUpdate'				=> 'Aktualisieren',

	'ApHomePage'				=> 'Startseite',
	'ApHomePageTip'				=> '�ffne die Startseite, beende nicht die Verwaltung ',
	'ApLogOut'					=> 'Abmelden',
	'ApLogOutTip'				=> 'Beende die Systemverwaltung',

	'TimeLeft'					=> 'Restzeit:  %1 Minuten',
	'ApVersion'					=> 'Version',

	'SiteOpen'					=> '�ffnen',
	'SiteOpened'				=> 'Website ge�ffnet',
	'SiteOpenedTip'				=> 'Die Website ist offen',
	'SiteClose'					=> 'schlie�en',
	'SiteClosed'				=> 'Website geschlossen',
	'SiteClosedTip'				=> 'Die Website ist geschlossen',

	// Generic
	'Cancel'					=> 'Abbrechen',
	'Add'						=> 'Hinzuf�gen',
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
		'title'		=> 'Einstellungen f�r Benachrichtigungen',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Seiten',
		'title'		=> 'Seiten und Website-Einstellungen',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Berechtigungen',
		'title'		=> 'Einstellungen f�r Berechtigungen',
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
		'name'		=> 'Gel�scht',
		'title'		=> 'Neu gel�schte Inhalte',
	],

	// Files module
	'content_files'		=> [
		'name'		=> 'Dateien',
		'title'		=> 'Verwalte hochgeladene Dateien',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Men�',
		'title'		=> 'Hinzuf�gen, Bearbeiten oder Entfernen von Standard-Men�punkten',
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
		'name'		=> 'Haupt-Men�',
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
		'title'		=> 'Aktualisiere den Supertag in den Datenbankdatens�tzen',
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
	'PurgeSessionsConfirm'		=> 'Bist du dir sicher, da� du alle Sitzungen entfernen willst? Dies wird alle Nuzer abmelden.',
	'PurgeSessionsExplain'		=> 'Entferne alle Sitzungen. Dies wird alle Nuzer abmelden in dem es die auth_token Tabelle leert.',
	'PurgeSessionsDone'			=> 'Sitzungen erfolgreich enfernt.',

	// Basic settings

	'SiteName'					=> 'Name der Seite',
	'SiteNameInfo'				=> 'Der Titel der Seite im HTML-Kopf, erscheint im Browser Titel, Theme Header, bei Email Benachrichtigung, etc.',
	'SiteDesc'					=> 'Beschreibung der Seite',
	'SiteDescInfo'				=> 'Erg�nzung zum Titel der Website, die im Seitenkopf erscheint, um in wenigen Worten zu erkl�ren, worum es in dieser Seite geht.',
	'AdminName'					=> 'Administrator der Seite',
	'AdminNameInfo'				=> 'User name, which is responsible for overall support of the site. This name is not used to determine access rights, but it is desirable to conform to the name of the chief administrator of the site.',

	'LanguageSection'			=> 'Sprache',
	'DefaultLanguage'			=> 'Standard Sprache',
	'DefaultLanguageInfo'		=> 'Specifies the language for mapping unregistered guests, as well as the locale settings and the rules of transliteration of addresses of pages.',
	'MultiLanguage'				=> 'Unterst�tzung mehrerer Sprachen',
	'MultiLanguageInfo'			=> 'Enth�lt eine Auswahl an Sprachen auf Seitenbasis.',
	'AllowedLanguages'			=> 'Erlaubte Sprachen',
	'AllowedLanguagesInfo'		=> 'Es wird empfohlen, nur die Sprachen auszuw�hlen, die man verwenden m�chte. Andernfalls sind alle Sprachen ausgew�hlt.',

	'CommentSection'			=> 'Kommentare',
	'AllowComments'				=> 'Erlaube Kommentare',
	'AllowCommentsInfo'			=> 'Aktiviere Kommentare f�r G�ste, registrierte Benutzer oder deaktivieren sie auf der gesamten Website.',
	'SortingComments'			=> 'Kommentare sortieren',
	'SortingCommentsInfo'		=> '�ndert die Reihenfolge, in der die Seitenkommentare angezeigt werden, entweder mit dem neuesten oder dem �ltesten Kommentar oben.',

	'ToolbarSection'			=> 'Werkzeugleiste',
	'CommentsPanel'				=> 'Kommentarleiste',
	'CommentsPanelInfo'			=> 'Die Standardanzeige von Kommentaren im unteren Bereich der Seite.',
	'FilePanel'					=> 'Dateileiste',
	'FilePanelInfo'				=> 'Die Standardanzeige von Anh�ngen im unteren Bereich der Seite.',
	'RatingPanel'				=> 'Rating panel',
	'RatingPanelInfo'			=> 'The default display of the rating panel in the bottom of the page.',
	'TagsPanel'					=> 'Tags panel',
	'TagsPanelInfo'				=> 'The default display of the tags panel in the bottom of the page.',
	'HideRevisions'				=> 'Revisionen ausblenden',
	'HideRevisionsInfo'			=> 'Die Standardanzeige der Revisionen der Seite.',
	'TocPanel'					=> 'Inhaltsverzeichnis',
	'TocPanelInfo'				=> 'Die Standardanzeige f�r das Inhaltsverzeichnis-Fenster der Seite (setzt die Unterst�tzung durch das Layout vorraus).',
	'SectionsPanel'				=> 'Bereichsanzeige',
	'SectionsPanelInfo'			=> 'Das Fenster zeigt standardm��ig benachbarte Seiten an (setzt die Unterst�tzung durch das Layout vorraus).',
	'DisplayingSections'		=> 'Angezeigte Bereiche',
	'DisplayingSectionsInfo'	=> 'When the previous options, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>) or both, and other (<em>Baum</em>).',
	'MenuItems'					=> 'Men�punkte',
	'MenuItemsInfo'				=> 'Standardanzahl der angezeigten Men�elemente (setzt die Unterst�tzung durch das Layout vorraus).',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Aktiviere Feeds',
	'EnableFeedsInfo'			=> 'Aktiviert oder deaktiviert RSS-Feeds f�r das gesamte Wiki.',
	'XmlSitemap'				=> 'XML Sitemap',
	'XmlSitemapInfo'			=> 'Erstellt eine XML-Datei namens "sitemap-wackowiki.xml" im XML-Ordner. Generate a Sitemaps XML format compatible XML file. You might want to change the path to output it in your root folder as that is one of the requirements i.e. that the XML file is in the root folder.',
	'XmlSitemapTime'			=> 'XML Sitemap Erstellungszeit',
	'XmlSitemapTimeInfo'		=> 'Erzeugt die Sitemap nur einmal in der angegebenen Anzahl von Tagen, Null bedeutet bei jeder Seiten�nderung.',

	'DiffModeSection'			=> 'Diff-Modi',
	'DefaultDiffModeSetting'	=> 'Standard Diff-Modus',
	'DefaultDiffModeSettingInfo'=> 'Vorausgew�hlter Diff-Modus.',
	'AllowedDiffMode'			=> 'Zugelassene Diff-Modi',
	'AllowedDiffModeInfo'		=> 'Es wird empfohlen, nur die Modi auszuw�hlen, welche man verwenden m�chte. Andernfalls werden alle Diff-Modi ausgew�hlt.',

	'EditSummary'				=> 'Edit summary',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Kleine �nderung',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'ReviewSettings'			=> '�berpr�fen',
	'ReviewSettingsInfo'		=> 'Aktiviert die �berpr�fungsoption im Bearbeitungsmodus.',

	'PublishAnonymously'		=> 'Anonyme Ver�ffentlichung zulassen',
	'PublishAnonymouslyInfo'	=> 'Erlaubt den Benutzern, vorzugsweise anonym zu ver�ffentlichen (um den Namen zu verbergen).',
	'DefaultRenameRedirect'		=> 'Bei Umbenennung einer Seite eine Umleitung setzen',
	'DefaultRenameRedirectInfo'	=> 'By default, offer to deliver a redirect to the old address of the page being renamed.',
	'StoreDeletedPages'			=> 'Gel�schte Seiten behalten',
	'StoreDeletedPagesInfo'		=> 'Wenn eine Seite, einen Kommentar oder eine Datei gel�scht wird, steht diese noch in einen gesonderten Bereich f�r eine bestimmte Zeit (siehe n�chster Punkt) zur die Wiederherstellung und Anzeige zur Verf�gung.',
	'KeepDeletedTime'			=> 'Aufbewahrungszeit f�r gel�schten Seiten',
	'KeepDeletedTimeInfo'		=> 'Der Zeitraum in Tagen. Dies macht nur mit der vorherigen Option Sinn. Null bedeutet unbegrenzte Aufbewahrungszeit (in diesem Fall kann der Administrator diese manuell im Verwaltungs-Panel l�schen).',
	'PagesPurgeTime'			=> 'Aufbewahrungszeit der Seiten-Revisionen',
	'PagesPurgeTimeInfo'		=> 'L�scht automatisch die �lteren Versionen innerhalb der angegebenen Anzahl von Tagen. Wenn Sie Null eingeben, werden die �lteren Versionen nicht entfernt.',
	'EnableReferrers'			=> 'Enable Referrers',
	'EnableReferrersInfo'		=> 'Erm�glicht das Speichern und Anzeigen externer Verweise.',
	'ReferrersPurgeTime'		=> 'Aufbewahrungszeit der Verweise',
	'ReferrersPurgeTimeInfo'	=> 'Keep history of invoking external pages no more than this number of days. Zero means the perpetual possession, but to actively visit the site this could lead to overcrowding in the database.',
	'AttachmentHandler'			=> 'Enable attachments handler',
	'AttachmentHandlerInfo'		=> 'Allows to show the attachments handler.',
	'SearchEngineVisibility'	=> 'Suchmaschinen blockieren (Suchmaschinen-Sichtbarkeit)',
	'SearchEngineVisibilityInfo'=> 'Suchmaschinen blockieren, aber normale Besucher erlauben. �berschreibt die Seiteneinstellungen. <br>Discourage search engines from indexing this site, It is up to search engines to honor this request.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Aussehen der Webseite �ndern',
	'AppearanceSettingsUpdated'	=> 'Aussehen der Webseite wurde aktualisiert.',

	'LogoOff'					=> 'Aus',
	'LogoOnly'					=> 'Logo',
	'LogoAndTitle'				=> 'Logo und Titel',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Site Logo',
	'SiteLogoInfo'				=> 'Das Logo wird normalerweise in der oberen linken Ecke der Anwendung angezeigt. Die maximale Gr��e betr�gt 2 MiB. Optimale Abmessungen sind 255 Pixel breit und 55 Pixel hoch.',
	'LogoDimensions'			=> 'Logo Ma�e',
	'LogoDimensionsInfo'		=> 'Breite und H�he des angezeigten Logos.',
	'LogoDisplayMode'			=> 'Logo-Anzeigemodus',
	'LogoDisplayModeInfo'		=> 'Bestimmt wie und ob das Logo angezeigt wird. Standard ist ausgeschaltet.',
	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site Favicon',
	'SiteFaviconInfo'			=> 'Das Verkn�pfungssymbol oder Favicon wird in der Adressleiste, den Registerkarten und den Lesezeichen der meisten Browser angezeigt. Dies �berschreibt das Favicon deines Themas.',
	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Layout',
	'ThemeInfo'					=> 'Layout, welches die Site standardm��ig verwendet.',
	'ThemesAllowed'				=> 'Zul�ssige Layouts',
	'ThemesAllowedInfo'			=> 'W�hle die zul�ssigen Layouts aus, die der Benutzer verwenden kann, andernfalls sind alle verf�gbaren Layouts zul�ssig.',
	'ThemesPerPage'				=> 'Layouts pro Seite',
	'ThemesPerPageInfo'			=> 'Erlaube Layouts pro Seite, welche der Seitenbesitzer �ber Seiteneigenschaften ausw�hlen kann.',

	// System settings
	'SystemSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'SystemSettingsUpdated'		=> 'Systemeinstellungen  aktualisiert',

	'DebugModeSection'			=> 'Debug-Modus',
	'DebugMode'					=> 'Debug-Modus',
	'DebugModeInfo'				=> 'An- und Abschaltung zur Ausgabe von Telemetriedaten �ber die Programmlaufzeit. Achtung: Der Modus f�r alle Details stellt h�here Anforderungen an den zugewiesenen Speicher, insbesondere bei ressourcenintensiven Vorg�ngen wie dem Sichern und Wiederherstellen der Datenbank.',
	'DebugModes'	=> [
		'0'		=> 'Debug-Modus ist deaktiviert',
		'1'		=> 'nur die Gesamtausf�hrungszeit',
		'2'		=> 'alle Zeiten',
		'3'		=> 'alle Details (DBMS, Cache, usw.)',
	],
	'DebugSqlThreshold'			=> 'Threshold performance RDBMS',
	'DebugSqlThresholdInfo'		=> 'Im ausf�hrlichen Debug-Modus werden nur die Abfragen aufgezeichnet, welche l�nger ben�tigen als die Anzahl der hier ausgewiesen Sekunden.',
	'DebugAdminOnly'			=> 'Geschlossene Diagnose',
	'DebugAdminOnlyInfo'		=> 'Zeigt die Debug-Daten des Programms (und des DBMS) nur dem Administrator.',

	'CachingSection'			=> 'Caching-Optionen',
	'Cache'						=> 'Cache rendered pages',
	'CacheInfo'					=> 'Save rendered pages in the local cache to speed up the subsequent boot. Valid only for unregistered visitors.',
	'CacheTtl'					=> 'Term relevance cached pages',
	'CacheTtlInfo'				=> 'Cache pages no more than a specified number of seconds.',
	'CacheSql'					=> 'Cache-DBMS-Abfragen',
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

	'RewriteMode'				=> 'Verwende <code>mod_rewrite</code>',
	'RewriteModeInfo'			=> 'Wenn der Webserver diese Funktion unterst�tzt, aktivieren sie, um "sch�ne" Seitenadressen zu erhalten.<br>
									<span class="cite">The value might be overwritten by the Settings class, despite you turn it off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parameters responsible for Access control and permissions.',
	'PermissionsSettingsUpdated'	=> 'Berechtigungen aktualisiert',

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
	'HideLocked'				=> 'Nicht zug�ngliche Seiten ausblenden',
	'HideLockedInfo'			=> 'If the user does not have permission to read the page, hide it in different page lists (however the link placed in text, will still be visible).',
	'RemoveOnlyAdmins'			=> 'Nur Administratoren k�nnen Seiten l�schen',
	'RemoveOnlyAdminsInfo'		=> 'Deny all, except administrators, to delete pages. In the first limit applies to owners of normal pages.',
	'OwnersRemoveComments'		=> 'Seitenbesitzer k�nnen Kommentare l�schen',
	'OwnersRemoveCommentsInfo'	=> 'Erm�glicht es Seitenbesitzern, Kommentare auf ihren Seiten zu moderieren.',
	'OwnersEditCategories'		=> 'Owners can edit page categories',
	'OwnersEditCategoriesInfo'	=> 'Allow owners to modify the pages category list of your site (add words, delete words), assigns to a page.',
	'TermHumanModeration'		=> 'Term human moderation',
	'TermHumanModerationInfo'	=> 'Moderators can edit comments, only if they were set up at most as many days ago (this restriction does not apply to the last comment in the topic).',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parameters responsible for the overall safety of the platform, work permits and additional security subsystems.',
	'SecuritySettingsUpdated'	=> 'Sicherheitseinstellungen aktualisiert',

	'AllowRegistration'			=> 'Register online',
	'AllowRegistrationInfo'		=> 'Ongoing registration of users. Disabling the option will prevent free registration, however, the site administrator will be able to register other users on their own.',
	'ApproveNewUser'			=> 'Neue Nutzer best�tigen',
	'ApproveNewUserInfo'		=> 'Erm�glicht Administratoren, Benutzer nach der Registrierung zuzulassen. Nur zugelassene Benutzer d�rfen sich auf der Site anmelden.',
	'PersistentCookies'			=> 'Persistent cookies',
	'PersistentCookiesInfo'		=> 'Allow persistent cookies.',
	'AntiDupe'					=> 'Anti-clone',
	'AntiDupeInfo'				=> 'Disable register on the website under the names, <span class="underline">like</span> on the names of existing users (guests also can not use similar names for the signature comments). When this option is checked only <span class="underline">identical</span> names.',
	'DisableWikiName'			=> 'Deaktiviere WikiName',
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
	'PwdMinChars'				=> 'Minimale Passwortl�nge',
	'PwdMinCharsInfo'			=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 12 to 16 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'AdminPwdMinChars'			=> 'Minimale Admin Passwortl�nge',
	'AdminPwdMinCharsInfo'		=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 15 to 20 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'PwdCharComplexity'			=> 'Die erforderliche Kennwortkomplexit�t',
	'PwdCharClasses'	=> [
		'0'		=> 'ungepr�ft',
		'1'		=> 'alle Buchstaben + Zahlen',
		'2'		=> 'Gro�- und Kleinschreibung + Zahlen',
		'3'		=> 'Gro�- und Kleinschreibung + Zahlen + Zeichen',
	],
	'PwdUnlikeLogin'			=> 'zus�tzliche Erschwernis',
	'PwdUnlikes'	=> [
		'0'		=> 'ungepr�ft',
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
	'LogLevelInfo'				=> 'Die Mindestpriorit�t der Ereignisse, die im Protokoll aufgezeichnet wurden.',
	'LogThresholds'	=> [
		'0'		=> 'keine Protokollierung',
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high',
		'4'		=> 'im Mittel',
		'5'		=> 'from low',
		'6'		=> 'the minimum level',
		'7'		=> 'alles aufzeichnen',
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
		'7'		=> 'zeige alle',
	],
	'LogPurgeTime'				=> 'Aufbewahrungszeit f�r das Ereignisprotokoll',
	'LogPurgeTimeInfo'			=> 'Entfernt das Ereignisprotokoll nach der angegebenen Anzahl von Tagen.',

	'FormsSection'				=> 'Formulare',
	'FormTokenTime'				=> 'Maximale Zeit f�r die �bermittlung von Formularen',
	'FormTokenTimeInfo'			=> 'The time a user has to submit a form (in seconds).<br> Use -1 to disable. Note that a form might become invalid if the session expires, regardless of this setting.',

	'SessionLength'				=> 'Term login cookie',
	'SessionLengthInfo'			=> 'The lifetime of the user cookie login by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of the new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications',
	'IntercomDelayInfo'			=> 'The minimum delay between sending a private message user connection (in seconds).',

	//Formatter settings
	'FormatterSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'FormatterSettingsUpdated'	=> 'Formatierungseinstellungen aktualisiert',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> 'Typografischer Korrektor',
	'TypograficaInfo'			=> 'Durch das Deaktivieren wird der Vorgang des Hinzuf�gens von Kommentaren und des Speicherns von Seiten geringf�gig beschleunigt.',
	'Paragrafica'				=> 'Paragrafica Markierungen',
	'ParagraficaInfo'			=> '�hnlich wie bei der vorherigen Option, jedoch wird die Deaktivierung zu einer Fehlfunktion des automatischen Inhaltsverzeichnisses f�hren: <code>{{toc}}</code>.',
	'AllowRawhtml'				=> 'Globale HTML-Unterst�tzung',
	'AllowRawhtmlInfo'			=> 'Die Verwendung dieser Option f�r eine offene Site ist m�glicherweise unsicher.',
	'SafeHtml'					=> 'HTML filtern',
	'SafeHtmlInfo'				=> 'Verhindert das Speichern gef�hrlicher HTML-Objekte. Das Deaktivieren des Filters auf einer offnen Website mit HTML-Unterst�tzung ist <span class="underline">extrem</span> unerw�nscht!',

	'WackoFormatterSection'		=> 'Wiki Text Formatierer (Wacko Formatierer)',
	'X11colors'					=> 'X11 Farben Verwendung',
	'X11colorsInfo'				=> 'Erweitert die verf�gbaren Farben f�r <code>??(Farbe) Hintergrund??</code> und <code>!!(Farbe) Text!!</code>. Durch das Deaktivieren wird der Vorgang des Hinzuf�gens von Kommentaren und des Speicherns von Seiten geringf�gig beschleunigt.',
	'TikiLinks'					=> 'Deaktiviere Tikilinks',
	'TikiLinksInfo'				=> 'Deaktiviert die Verlinkung von <code>Double.CamelCaseWords</code>.',
	'WikiLinks'					=> 'Deaktiviere Wikilinks',
	'WikiLinksInfo'				=> 'Deaktiviert die Verlinkung von <code>CamelCaseWords</code>, deine CamelCase W�rter werden nicht mehr direkt auf eine neue Seite verlink. Dies ist n�tzlich, wenn man �ber verschiedene Namensr�ume, also Cluster, hinweg arbeitet. Standardm��ig ist es ausgeschaltet.',
	'BracketsLinks'				=> 'Deaktiviere Bracketslinks',
	'BracketsLinksInfo'			=> 'Deaktiviert <code>[[link]]</code> und <code>((link))</code> Syntax.',
	'Formatters'				=> 'Deaktiviere Formatierer',
	'FormattersInfo'			=> 'Deaktiviert <code>%%code%%</code> Syntax, verwendet f�r Textauszeichner.',

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

	'LinkTarget'				=> 'Wo externe Links ge�ffnet werden',
	'LinkTargetInfo'			=> '�ffnet jeden externen Link in einem neuen Browserfenster. F�gt <code>target="_blank"</code> zum Link-Syntax hinzu.',
	'Noreferrer'				=> 'noreferrer',
	'NoreferrerInfo'			=> 'Setzt voraus, dass der Browser, wenn der Benutzer den Hyperlink folgt keine Referrer-Header sendet. F�gt <code>rel="noreferrer"</code> zum Link-Syntax hinzu.',
	'Nofollow'					=> 'nofollow',
	'NofollowInfo'				=> 'Instruct some search engines that the hyperlink should not influence the ranking of the link\'s target in the search engine\'s index. Adds <code>rel="nofollow"</code> to the link syntax.',
	'UrlsUnderscores'			=> 'Bilded Adressen (URLs) mit Unterstrichen',
	'UrlsUnderscoresInfo'		=> 'Beispielsweise <code>http://[..]/WackoWiki</code> wird zu <code>http://[..]/Wacko_Wiki</code> mit dieser Option.',
	'ShowSpaces'				=> 'Zeigt Leerzeichen in WikiNames',
	'ShowSpacesInfo'			=> 'Zeigt Leerzeichen in WikiNames, e.g. <code>MyName</code> wird angezeigt als <code>My Name</code> mit dieser Option.',
	'NumerateLinks'				=> 'Nummeriert die Links in der Druckansicht',
	'NumerateLinksInfo'			=> 'Nummeriert und listet alle Links am Fu� der Seite in der Druckansicht mit dieser Option.',
	'YouareHereText'			=> 'Deaktiviert und visualisiert selbstreferenzierende Links',
	'YouareHereTextInfo'		=> 'Visualizing links to the same page, try to <code>&lt;b&gt;####&lt;/b&gt;</code>, all links-to-self became not links, but bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> '',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Anzahl der Datens�tze pro Liste',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster Forum',
	'ForumClusterInfo'			=> 'Address of the index (main) page of the forum.',
	'ForumTopics'				=> 'Anzahl der Themen pro Seite',
	'ForumTopicsInfo'			=> 'Number of topics displayed on each page of the list in the forum sections.',
	'CommentsCount'				=> 'Anzahl der Kommentare pro Seite',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page list of comments. This applies to all the comments on the site, and not just posted in the forum.',

	'NewsSection'				=> 'Nachrichten',
	'NewsCluster'				=> 'Nachrichten Cluster',
	'NewsClusterInfo'			=> 'Root-Cluster f�r den Nachrichtenbereich.',
	'NewsLevels'				=> 'Tiefe der Nachrichtenseiten aus dem Root-Cluster',
	'NewsLevelsInfo'			=> 'Regular expression (SQL regexp-slang), specifying the number of intermediate levels of the news root cluster directly to the names of pages of news reports. (e.g. <code>[cluster]/[year]/[month]</code> -> <code>/.+/.+/.+</code>)',

	'LicenseSection'			=> 'Lizenz',
	'DefaultLicense'			=> 'Standard-Lizenz',
	'DefaultLicenseInfo'		=> 'Unter welcher Lizenz sollen deine Inhalte ver�ffentlicht werden?',

	'ServicePagesSection'		=> 'Service pages',
	'RootPage'					=> 'Startseite',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',
	'PolicyPage'				=> 'Policies and Regulations',
	'PolicyPageinfo'			=> 'The page with the rules of the site.',
	'SearchPage'				=> 'Suche',
	'SearchPageInfo'			=> 'Seite mit dem Suchformular (Aktion <code>{{search}}</code>).',
	'RegistrationPage'			=> 'Register on our site',
	'RegistrationPageInfo'		=> 'Seite f�r neue Benutzerregistrierung (Aktion <code>{{registration}}</code>).',
	'LoginPage'					=> 'Benutzer-Anmeldung',
	'LoginPageInfo'				=> 'Login page on the site (Aktion <code>{{login}}</code>).',
	'SettingsPage'				=> 'Benutzereinstellungen',
	'SettingsPageInfo'			=> 'Seite zum Anpassen des Benutzerprofils (Aktion <code>{{usersettings}}</code>).',
	'PasswordPage'				=> 'Passwort �ndern',
	'PasswordPageInfo'			=> 'Seite mit dem Formular zum �ndern und Zur�cksetzen des Benutzerpasswortes (Aktion <code>{{changepassword}}</code>).',
	'UsersPage'					=> 'Benutzerliste',
	'UsersPageInfo'				=> 'Seite mit einer Liste der registrierten Benutzer (Aktion <code>{{users}}</code>).',
	'CategoryPage'				=> 'Kategorien',
	'CategoryPageInfo'			=> 'Seite mit einer Liste von kategorisierten Seiten (Aktion <code>{{category}}</code>).',
	'TagPage'					=> 'Tag',
	'TagPageInfo'				=> 'Page with a list of tagged pages (Aktion <code>{{tag}}</code>).',
	'GroupsPage'				=> 'Gruppen',
	'GroupsPageInfo'			=> 'Seite mit einer Liste von Arbeitsgruppen (Aktion <code>{{usergroups}}</code>).',
	'ChangesPage'				=> 'Letzte �nderungen',
	'ChangesPageInfo'			=> 'Seite mit einer Liste der zuletzt ge�nderten Seiten (Aktion <code>{{changes}}</code>).',
	'CommentsPage'				=> 'Letzte Kommentare',
	'CommentsPageInfo'			=> 'Seite mit einer Liste der letzten Kommentare auf der Seite (Aktion <code>{{commented}}</code>).',
	'RemovalsPage'				=> 'Gel�schte Seiten',
	'RemovalsPageInfo'			=> 'Seite mit einer Liste der zuletzt gel�schten Seiten (Aktion <code>{{deleted}}</code>).',
	'WantedPage'				=> 'Gew�nschte Seiten',
	'WantedPageInfo'			=> 'Seite mit einer Liste der fehlenden Seiten, auf die verwiesen wird (Aktion <code>{{wanted}}</code>).',
	'OrphanedPage'				=> 'Verwaiste Seiten',
	'OrphanedPageInfo'			=> 'Seite mit einer Liste der vorhandenen Seiten welche von anderen Seiten nicht verlinkt wurden (Aktion <code>{{orphaned}}</code>).',
	'TodoPage'					=> 'ToDo',
	'TodoPageInfo'				=> 'Page with a list of To Do (constructed with the help of <code>{{backlinks}}</code> and makro <code>::*::</code>).',
	'SandboxPage'				=> 'Sandkasten',
	'SandboxPageInfo'			=> 'Seite, auf der Benutzer die Verwendung des Wiki-Markups �ben k�nnen.',
	'WikiDocsPage'				=> 'Wiki-Dokumentation',
	'WikiDocsPageInfo'			=> 'Section of the documentation for using the tool site.',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameters for notifications of the platform.',
	'NotificationSettingsUpdated'	=> 'Updated notification settings',

	'EmailNotification'			=> 'E-Mail-Benachrichtigung',
	'EmailNotificationInfo'		=> 'E-Mail-Benachrichtigung zulassen. W�hle EIN, um E-Mail-Benachrichtigungen zu aktivieren, und AUS, um sie zu deaktivieren. Beachte, dass die Deaktivierung von E-Mail-Benachrichtigungen keine Auswirkungen auf E-Mails hat, die im Rahmen des Benutzeranmeldungsvorgangs generiert wurden.',
	'Autosubscribe'				=> 'Autosubscribe',
	'AutosubscribeInfo'			=> 'Automatically sign a new page in the owner\'s notice of its changes.',

	'NotificationSection'		=> 'Standardeinstellungen f�r Benutzerbenachrichtigungen',
	'NotifyPageEdit'			=> 'Seiten�nderung mitteilen',
	'NotifyPageEditInfo'		=> 'Pending - Sending a email notification only for the first change until the user visits the page again.',
	'NotifyMinorEdit'			=> 'Kleine �nderung mitteilen',
	'NotifyMinorEditInfo'		=> 'Sende Mitteilungen auch bei kleinen �nderungen.',
	'NotifyNewComment'			=> 'Neuen Kommentar mitteilen',
	'NotifyNewCommentInfo'		=> 'Pending - Sending a email notification only for the first comment until the user visits the page again.',
	'NotifyUserAccount'			=> 'Neues Benutzerkonto mitteilen',
	'NotifyUserAccountInfo'		=> 'The Admin will to be notified when a new user has been created using the "signup form".',


	// Resync settings
	'Synchronize'				=> 'Synchronisieren',
	'UserStatsSynched'			=> 'Benutzerstatistiken wurden synchronisiert.',
	'PageStatsSynched'			=> 'Seitenstatistiken wurden synchronisiert.',
	'FeedsUpdated'				=> 'RSS-Feeds aktualisiert.',
	'SiteMapCreated'			=> 'Die neue Version der Sitemap wurde erfolgreich erstellt.',
	'WikiLinksRestored'			=> 'Wiki-Links wiederhergestellt.',

	'UserStats'					=> 'Benutzerstatistik',
	'UserStatsInfo'				=> 'Benutzerstatistiken (Anzahl der Kommentare, besessene Seiten, Revisionen und Dateien) k�nnen in einigen Situationen von den tats�chlichen Daten abweichen.<br> Diese Operation erm�glicht das Aktualisieren von Statistiken auf aktuelle tats�chliche Daten der Datenbank.',
	'PageStats'					=> 'Seitenstatistiken',
	'PageStatsInfo'				=> 'Seitenstatistiken (Anzahl der Kommentare, Dateien und Revisionen) k�nnen in einigen Situationen von den tats�chlichen Daten abweichen. <br> Diese Operation erm�glicht das Aktualisieren von Statistiken auf aktuelle tats�chliche Daten der Datenbank.',
	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'Im Falle der direkten Bearbeitung von Seiten in der Datenbank spiegelt der Inhalt der RSS-Feeds m�glicherweise nicht die vorgenommenen �nderungen wider. <br> Diese Funktion synchronisiert die RSS-Kan�le mit dem aktuellen Zustand der Datenbank.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'Diese Funktion synchronisiert die XML-Sitemap mit dem aktuellen Zustand der Datenbank.',
	'WikiLinksResync'			=> 'Wiki-Links',
	'WikiLinksResyncInfo'		=> 'F�hrt ein Re-Rendering f�r alle Intrasite-Links durch und stellt den Inhalt der Tabelle <code> page_link </code> und <code> file_link </code> im Falle einer Besch�digung oder Verlagerung wieder her (dies kann einige Zeit in Anspruch nehmen).',

	// Email settings
	'EmaiSettingsInfo'			=> 'Diese Informationen werden ben�tigt, um E-Mails an die Benutzer zu senden. Stelle bitte sicher, dass die angegebene Adresse g�ltig ist; abgewiesene oder nicht zustellbare Nachrichten werden an diese Adresse geschickt. Falls dein Webhosting-Provider keinen PHP-basierten E-Mail-Dienst anbietet, k�nnen die Nachrichten auch direkt �ber SMTP versendet werden. Dies erfordert die Angabe der Adresse eines geeigneten Servers (frage falls n�tig deinen Provider). Falls der Server eine Authentifizierung erfordert (und nur, wenn dies der Fall ist), gib den Benutzernamen und das Passwort ein und w�hle eine Authentifizierungsmethode aus.',

	'EmailSettingsUpdated'		=> 'E-Mail Einstellungen wurden aktualisiert.',

	'EmailFunctionName'			=> 'Name der E-Mail-Funktion',
	'EmailFunctionNameInfo'		=> 'Die PHP-Funktion, die genutzt wird, um E-Mails zu versenden.',
	'UseSmtpInfo'				=> 'W�hle <code>SMTP</code> aus, wenn du E-Mails �ber einen SMTP-Server senden m�chtest (oder musst), anstatt die PHP-eigene Mail-Funktion zu nutzen.',

	'EnableEmail'				=> 'Aktiviere E-Mail',
	'EnableEmailInfo'			=> 'Aktiviere E-Mail-Funktionalit�t',

	'FromEmailName'				=> 'Absender',
	'FromEmailNameInfo'			=> 'Absender Name, im Adressfeld <code>Von:</code> der Kopfzeile in E-Mails f�r alle E-Mail-Benachrichtigungen, die von dieser Seite gesendet werden.',
	'NoReplyEmail'				=> 'No-reply Adresse',
	'NoReplyEmailInfo'			=> 'Diese Adresse, z.B. <code>noreply@example.com</code>, erscheint im Adressfeld <code>Von:</code> der Kopfzeile bei allen E-Mail Benachrichtigungen, die von dieser Seite gesendet werden.',
	'AdminEmail'				=> 'E-Mail Adresse des Seiteninhabers',
	'AdminEmailInfo'			=> 'Diese Adresse ist f�r Administrationszwecke, wie Benachrichtigung bei neuen Benutzern.',
	'AbuseEmail'				=> 'Dienst bei E-Mail-Missbrauch',
	'AbuseEmailInfo'			=> 'Adresse f�r dringende Angelegenheiten: Registrierung einer verd�chtigen E-Mail, usw. Kann mit der vorherigen �bereinstimmen.',

	'SendTestEmail'				=> 'Test-Mail senden',
	'SendTestEmailInfo'			=> 'Sendet eine Test-Mail an die in deinem Benutzerkonto hinterlegte Adresse.',
	'TestEmailSubject'			=> 'Dein Wiki ist f�r den E-Mail-Versand richtig konfiguriert',
	'TestEmailBody'				=> 'Wenn du diese Nachricht erh�ltst, ist deine Wiki richtig f�r den E-Mail-Versand konfiguriert.',
	'TestEmailMessage'			=> 'Die Test-Mail wurde gesendet.<br>Falls du sie nicht erhalten solltest, pr�fe bitte deine E-Mail-Konfiguration.',

	'SmtpAutoTls'				=> 'STARTTLS',
	'SmtpAutoTlsInfo'			=> 'Aktiviert Verschl�sselung automatisch, wenn der Server TLS Verschl�sselung anbietet (nach dem Aufbau der Serververbindung), sogar wenn <code>SMTPSecure</code> nicht eingeschaltet wurde.',
	'SmtpConnectionMode'		=> 'Authentifizierungsmethode f�r SMTP',
	'SmtpConnectionModeInfo'	=> 'Nur ben�tigt, wenn ein Benutzername/Passwort eingegeben ist. Frage deinen Webhosting-Provider, falls du nicht sicher bist, welche Methode du w�hlen sollst.',
	'SmtpPassword'				=> 'SMTP-Passwort',
	'SmtpPasswordInfo'			=> 'Gib nur ein Passwort ein, wenn dein SMTP-Server dies erfordert. <em><strong>WARNUNG:</strong> Dieses Passwort wird im Klartext in der Datenbank gespeichert und ist daher f�r jeden einsehbar, der Zugriff auf die Datenbank oder diese Konfigurationsseite hat.</em>',
	'SmtpPort'					=> 'SMTP-Server-Port',
	'SmtpPortInfo'				=> '�ndere diese Einstellung nur, wenn du wei�t, dass dein SMTP-Server einen anderen Port nutzt. <br>(default: <code>tls</code> auf Port 587 (oder m�glicherweise 25) und <code>ssl</code> auf Port 465)',
	'SmtpServer'				=> 'SMTP-Server-Adresse',
	'SmtpServerInfo'			=> 'Beachte, dass du das Protokoll angeben musst, das dein Server verwendet. Wird SSL verwendet, musst du <code>ssl://mail.example.com</code> angeben.',
	'SmtpSettings'				=> 'SMTP-Einstellungen',
	'SmtpUsername'				=> 'SMTP-Benutzername',
	'SmtpUsernameInfo'			=> 'Gib nur einen Benutzernamen ein, wenn dein SMTP-Server dies erfordert.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Hier kannst du die Einstellungen f�r Dateianh�nge und verkn�pfte Spezialkategorien vornehmen.',
	'UploadSettingsUpdated'		=> 'Updated upload settings',

	'RightToUpload'				=> 'Berechtigung Dateien hochzuladen',
	'RightToUploadInfo'			=> '<code>admins</code> bedeutet nur Nutzer welche der Admins-Gruppe angeh�ren, k�nnen Dateien hochladen. <code>1</code> bedeutet jeder registrierte Benutzer kann Dateien hochladen. <code>0</code> das Hochladen von Dateien ist nicht m�glich.',
	'UploadOnlyImages'			=> 'Erlaube nur das Hochladen von Bildern',
	'UploadOnlyImagesInfo'		=> 'Nur Bilder k�nnen hochgeladen werden.',
	'FileUploads'				=> 'Dateien hochladen',
	'UploadMaxFilesize'			=> 'Maximale Dateigr��e',
	'UploadMaxFilesizeInfo'		=> 'Maximale Gr��e pro Datei. Die Dateigr��e wird nur durch die PHP-Konfiguration beschr�nkt, wenn 0 als Wert eingestellt wird.',
	'UploadQuota'				=> 'Maximales Kontingent f�r Dateianh�nge',
	'UploadQuotaInfo'			=> 'Maximaler f�r Dateianh�nge verf�gbarer Speicherplatz f�r das gesamte Wiki; 0 bedeutet unbegrenzt.',
	'UploadQuotaUser'			=> 'Speicherkontingent pro Benutzer',
	'UploadQuotaUserInfo'		=> 'Beschr�nkung des Speicherkontingentes, der von einem Benutzer hochgeladen werden kann, wobei 0 unbegrenzt ist.',
	'CheckMimetype'				=> 'Dateianh�nge pr�fen',
	'CheckMimetypeInfo'			=> 'Manchen Browsern kann ein fehlerhafter MIME-Typ f�r hochgeladene Dateien vorget�uscht werden. Diese Option stellt sicher, dass Dateien, die dieses Verhalten provozieren k�nnten, abgewiesen werden.',

	'Thumbnails'				=> 'Vorschaubilder',
	'CreateThumbnail'			=> 'Vorschaubild erstellen',
	'CreateThumbnailInfo'		=> 'Vorschaubild in allen m�glichen F�llen erstellen.',
	'MaxThumbWidth'				=> 'Maximale Breite der Vorschaubilder in Pixeln',
	'MaxThumbWidthInfo'			=> 'Ein Vorschaubild wird nicht breiter sein als der hier eingestellte Wert.',
	'MinThumbFilesize'			=> 'Minimale Vorschaubild-Dateigr��e',
	'MinThumbFilesizeInfo'		=> 'Erstellt keine Vorschaubilder bei Bildern, die kleiner sind als dieser Wert.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Liste der entfernten Seiten und Dateien.
									Finally remove or restore the pages or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'W�rter, die automatisch in deinem Wiki zensiert werden.',
	'FilterSettingsUpdated'		=> 'Die Einstellungen f�r den Spamfilter wurden aktualisiert',

	'WordCensoringSection'		=> 'Wort zensieren',
	'SPAMFilter'				=> 'Spamfilter',
	'SPAMFilterInfo'			=> 'Spamfilter aktivieren',
	'WordList'					=> 'Wortliste',
	'WordListInfo'				=> 'Wort oder Phrase <code>fragment</code> welches auf die schwarze Liste gesetzt wird (eins pro Zeile)',

	// DB Convert module
	'Convert'					=> 'Konvertieren',
	'NoColumnsToConvert'		=> 'Keine Spalten zum Konvertieren.',
	'NoTablesToConvert'			=> 'Keine Tabellen zum Konvertieren.',

	'LogDatabaseConverted'		=> 'Datenbank konvertiert',
	'ConversionTablesOk'		=> 'Konvertierung der ausgew�hlten Tabellen erfolgreich.',

	'LogColumsToStrict'			=> 'Converted colums to comply with the SQL strict mode',
	'ConversionColumnsOk'		=> 'Konvertierung der ausgew�hlten Spalten erfolgreich.',

	'ConvertTablesEngine'		=> 'Konvertiere Tabellen von MyISAM zu InnoDB/XtraDB',
	'ConvertTablesEngineInfo'	=> 'If you have existing tables, that you want to convert to InnoDB/XtraDB* for better reliability and scalability, use the following routine. These tables were originally MyISAM, which was formerly the default.',
	'ConvertTablesEngineHint'	=> '* XtraDB is an enhanced version of the InnoDB storage engine, designed to better scale on modern hardware, and it includes a variety of other features useful in high performance environments.<br><br>It is fully backwards compatible, and it identifies itself to MariaDB as "<code>ENGINE=InnoDB</code>" (just like InnoDB), and so can be used as a drop-in replacement for standard InnoDB.',

	'DbVersion'					=> 'Erfordert mindestens MySQL 5.6.4, verf�gbare Version',
	'DbEngineOk'				=> 'InnoDB/XtraDB ist verf�gbar.',
	'DbEngineMissing'			=> 'InnoDB / XtraDB ist nicht verf�gbar.',
	'EngineTable'				=> 'Tabelle',
	'EngineDefault'				=> 'Standard',
	'EngineColumn'				=> 'Spalte',
	'EngineTyp'					=> 'Typ',

	'ConvertColumnsToStrict'	=> 'Konvertiere Spalten f�r den SQL-Strikt-Modus',
	'ConvertTablesStrictInfo'	=> 'If you have existing tables, that you want to convert to comply with the SQL srtict mode, use the following routine.',

	// Log module
	'LogFilterTip'				=> 'Filtere Ereignisse nach Kriterien',
	'LogLevel'					=> 'Stufe',
	'LogLevelFilters'	=> [
		'1'		=> 'nicht weniger als',
		'2'		=> 'nicht h�her als',
		'3'		=> 'gleich',
	],
	'LogNoMatch'				=> 'Keine Ereignisse, die die Kriterien erf�llen',
	'LogDate'					=> 'Datum',
	'LogEvent'					=> 'Ereignis',
	'LogUsername'				=> 'Benutzername',
	'LogLevels'	=> [
		'1'		=> 'kritisch',
		'2'		=> 'h�chste',
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
	'UserApproveInfo'			=> 'Schalte neue Benutzer frei, damit sie sich auf der Seite anmelden k�nnen.',
	'Approve'					=> 'Zulassen',
	'Deny'						=> 'Ablehnen',
	'Pending'					=> 'Ausstehend',
	'Approved'					=> 'Best�tigt',
	'Denied'					=> 'Abgelehnt',

	// DB Backup module
	'BackupStructure'			=> 'Struktur',
	'BackupData'				=> 'Daten',
	'BackupFolder'				=> 'Ordner',
	'BackupTable'				=> 'Tabelle',
	'BackupCluster'				=> 'Cluster',
	'BackupFiles'				=> 'Dateien',
	'BackupSettings'			=> 'W�hle das gew�nsche Datensicherungs-Schema.<br>' .
									'Der Stammcluster wirkt sich nicht auf die Sicherung der globalen Dateisicherung und der Cache-Dateien aus (die Auswahl wird immer vollst�ndig gespeichert).<br>' .
									'<br>' .
									'<strong>Achtung</strong>: Um den Verlust von Informationen aus der Datenbank bei der Angabe des Root-Clusters zu vermeiden, werden die Tabellen aus dieser Sicherung nicht umstrukturiert, ' .
									'auch wenn nur die Tabellenstruktur gesichert wird, ohne die Daten zu speichern. ' .
									'Um eine vollst�ndige Konvertierung der Tabellen in das Backup-Format vorzunehmen, muss eine <em> vollst�ndigen Datenbanksicherung (Struktur und Daten) ohne Angabe des Clusters</em> gemacht werden.',
	'BackupCompleted'			=> 'Sichern und Archivieren abgeschlossen.<br>' .
									'Die Sicherungspaketdateien wurden im Unterverzeichnis %1 abgelegt.<br>' .
									'Um es herunterzuladen verwende FTP (ver�ndere die Verzeichnisstruktur und die Dateinamen beim Kopieren nicht).<br>' .
									'Um eine Sicherungskopie wiederherzustellen oder ein Paket zu entfernen, gehe zu <a href="?mode=db_restore">Datenbank wiederherstellen</a>.',
	'LogSavedBackup'			=> 'Sicherungskopie gespeichert ##%1##',

	// DB Restore module
	'RestoreInfo'				=> 'Du kannst jedes gefundene Sicherungsspaket wiederherstellen oder vom Server entfernen.',
	'ConfirmDbRestore'			=> 'M�chtest du die Datensicherung wiederherstellen',
	'ConfirmDbRestoreInfo'		=> 'Bitte warte dies kann einige Minuten ben�tigen.',
	'RestoreWrongVersion'		=> 'WackoWiki Version stimmt nicht �berein!',
	'BackupDelete'				=> 'Willst du die Datensicherung wirklich entfernen',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Zus�tzliche Otionen zur Daten-Wiederherstellung',
	'RestoreOptionsInfo'		=> '* Vor dem Wiederherstellen der <strong>Cluster-Sicherung</strong>, ' .
									'werden die Zieltabellen nicht zerst�rt (um den Verlust von Informationen aus den Clustern, die nicht gesichert wurden, zu verhindern).. ' .
									'Somit werden w�hrend des Wiederherstellungsvorgangs doppelte Datens�tze auftreten. ' .
									'Im normalen Modus werden alle Dateien durch die Datens�tze ersetzt (mit SQL-Anweisung <code>REPLACE</code>), ' .
									'aber wenn dieses Kontrollk�stchen aktiviert ist, werden alle Duplikate �bersprungen (die aktuellen Werte der Datens�tze werden beibehalten), ' .
									'und nur die Datens�tze mit neuem Schl�ssel werden in die Tabelle aufgenommen (SQL-Anweisung <code>INSERT IGNORE</code>).<br>' .
									'<strong>Hinweis</strong>: Wenn Sie eine vollst�ndige Sicherung der Site wiederherstellen, hat diese Option keinen Zweck.<br>' .
									'<br>' .
									'** Wenn die Sicherung die Benutzerdateien (global und perpage, Cache-Dateien usw.) enth�lt, ' .
									'ersetzen sie im normalen Modus die vorhandenen Dateien mit denselben Namen und werden beim Wiederherstellen in demselben Verzeichnis abgelegt. ' .
									'Mit dieser Option kann man die aktuellen Kopien der Dateien speichern und aus einer Sicherung nur neue Dateien (fehlt auf dem Server) wiederherstellen.',
	'IgnoreDuplicatedKeys'		=> 'Ignoriere doppelte Tabellenschl�ssel (nicht ersetzen)',
	'IgnoreSameFiles'			=> 'Ignoriere die gleichen Dateien (nicht �berschreiben)',
	'NoBackupsAvailable'		=> 'Keien Datensicherung verf�gbar.',
	'BackupEntireSite'			=> 'Gesamte Website',
	'BackupRestored'			=> 'Die Datensicherung wurde wiederhergestellt, ein zusammenfassender Bericht ist angef�gt. Um die Dateien zu dieser Datensicherung zu l�schen, klicke bitte',
	'BackupRemoved'				=> 'Die ausgew�hlte Datensicherung wurde erfolgreich entfernt.',
	'LogRemovedBackup'			=> 'Sicherungskopie gel�scht ##%1##',

	'RestoreStarted'			=> 'Initiated Restoration',
	'RestoreParameters'			=> 'Verwendete Parameter',
	'IgnoreDublicatedKeys'		=> 'Ignore dublicated keys',
	'IgnoreDublicatedFiles'		=> 'Ignore dublicated files',
	'SavedCluster'				=> 'Gespeicherter Cluster',
	'DataProtection'			=> 'Data Protection - %1 omitted',
	'AssumeDropTable'			=> 'Assume %1',
	'RestoreTableStructure'		=> 'Wiederherstellen der Struktur der Tabelle',
	'RunSqlQueries'				=> 'F�hre SQL-Anweisungen aus',
	'CompletedSqlQueries'		=> 'Abgeschlossen. Verarbeitete Anweisungen',
	'NoTableStructure'			=> 'Die Struktur der Tabellen wurde nicht gespeichert - �berspringen',
	'RestoreRecords'			=> 'Tabelleninhalte wiederherstellen',
	'ProcessTablesDump'			=> 'Just download and process tables dump',
	'Instruction'				=> 'Anweisung',
	'RestoredRecords'			=> 'Datens�tze',
	'RecordsRestoreDone'		=> 'Abgeschlossen. Gesamtzahl der Datens�tze',
	'SkippedRecords'			=> 'Daten nicht gespeichert - �bersprungen',
	'RestoringFiles'			=> 'Dateien wiederherstellen',
	'DecompressAndStore'		=> 'Decompress and store the contents of directories',
	'HomonymicFiles'			=> 'gleichnamige Dateien',
	'RestoreSkip'				=> '�berspringen',
	'RestoreReplace'			=> 'ersetzen',
	'RestoreFile'				=> 'Datei',
	'Restored'					=> 'wiederhergestellt',
	'Skipped'					=> '�bersprungen',
	'FileRestoreDone'			=> 'Abgeschlossen. Gesamtzahl der Dateien',
	'FilesAll'					=> 'alle',
	'SkipFiles'					=> 'Dateien nicht gespeichert - �bersprungen',
	'RestoreDone'				=> 'RESTORATION COMPLETED',

	'BackupCreationDate'		=> 'Erstellungsdatum',
	'BackupPackageContents'		=> 'The contents of the package',
	'BackupRestore'				=> 'wiederherstellen',
	'BackupRemove'				=> 'entfernen',
	'RestoreYes'				=> 'ja',
	'RestoreNo'					=> 'nein',
	'LogDbRestored'				=> 'Backup ##%1## of the database restored.',

	// User module
	'UsersAdded'				=> 'Benutzer hinzugef�gt',
	'UsersDeleteInfo'			=> '[Informationen an Benutzer zur L�schung hier..]',
	'UserEditButton'			=> 'Bearbeiten',
	'UserEnabled'				=> 'Aktiviert',
	'UsersAddNew'				=> 'F�ge einen neuen Benutzer hinzu',
	'UsersDelete'				=> 'Bist du dir sicher das du den Benutzer entfernen willst ',
	'UsersDeleted'				=> 'Der Benutzer wurde aus der Datenbank entfernt.',
	'UsersRename'				=> 'Benutzer umbenennen',
	'UsersRenameInfo'			=> '* Hinweise: Die �nderung wirkt sich auf alle Seiten aus, die diesem Benutzer zugeordnet sind.',
	'UsersUpdated'				=> 'Benutzer erfolgreich aktualisiert.',

	'UserName'					=> 'Benutzername',
	'UserRealname'				=> 'Realname',
	'UserEmail'					=> 'E-Mail',
	'UserIP'					=> 'IP',
	'UserLanguage'				=> 'Sprache',
	'UserSignuptime'			=> 'Anmeldung',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'Keine Benutzer, welche diese Kriterien erf�llen.',

	// Groups module
	'GroupsMembersFor'			=> 'Mitglieder der Gruppe',
	'GroupsDescription'			=> 'Beschreibung',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Offen',
	'GroupsActive'				=> 'Aktiv',
	'GroupsTip'					=> 'Klicke um die Gruppe zu bearbeiten',
	'GroupsUpdated'				=> 'Gruppen aktualisiert',
	'GroupsAlreadyExists'		=> 'Diese Gruppe gibt es bereits.',
	'GroupsAdded'				=> 'Gruppe erfolgreich hinzugef�gt.',
	'GroupsRenamed'				=> 'Gruppe erfolgreich umbenannt.',
	'GroupsDeleted'				=> 'Die Gruppe und alle Mitglieder wurde aus der Datenbank gel�scht.',
	'GroupsAdd'					=> 'Eine neue Gruppe hinzuf�gen',
	'GroupsRename'				=> 'Gruppe umbenennen',
	'GroupsRenameInfo'			=> '* Hinweis: Die �nderung wirkt sich auf alle Seiten aus, die dieser Gruppe zugeordnet sind.',
	'GroupsDelete'				=> 'Bist du dir sicher das du die Gruppe entfernen m�chtest ',
	'GroupsDeleteInfo'			=> '* Hinweis: Die �nderung wirkt sich auf alle Mitglieder aus, die dieser Gruppe zugeordnet sind.',
	'GroupsStoreButton'			=> 'Speichere Gruppen',
	'GroupsSaveButton'			=> 'Absenden',
	'GroupsCancelButton'		=> 'Abbrechen',
	'GroupsAddButton'			=> 'Hinzuf�gen',
	'GroupsEditButton'			=> 'Bearbeiten',
	'GroupsRemoveButton'		=> 'Entfernen',
	'GroupsEditInfo'			=> 'Zum Bearbeiten der Gruppen-Liste w�hle das Optionsfeld',

	'MembersAddNew'				=> 'Neues Mitglied hinzuf�gen',
	'MembersAdded'				=> 'Neues Mitglied der Gruppe erfolgreich hinzugef�gt.',
	'MembersRemove'				=> 'Bist du dir sicher das du das Mitglied enfernen m�chtest ',
	'MembersRemoved'			=> 'Das Mitglied wurde aus der Gruppe entfernt.',
	'MembersDeleteInfo'			=> '* Hinweis: Die �nderung wirkt sich auf alle Mitglieder aus, die dieser Gruppe zugeordnet sind.',

	// Statistics module
	'DbStatSection'				=> 'Datenbank-Statistik',
	'DbTable'					=> 'Tabelle',
	'DbRecords'					=> 'Datens�tze',
	'DbSize'					=> 'Gr��e',
	'DbIndex'					=> 'Index',
	'DbOverhead'				=> '�berhang',
	'DbTotal'					=> 'Gesamt',

	'FileStatSection'			=> 'Dateisystem-Statistik',
	'FileFolder'				=> 'Ordner',
	'FileFiles'					=> 'Dateien',
	'FileSize'					=> 'Gr��e',
	'FileTotal'					=> 'Gesamt',
];

?>
