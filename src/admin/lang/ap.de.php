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
	'NoRecoveryPassword'		=> 'Das Administrator-Passwort wurde nicht gesetzt!',
	'NoRecoveryPasswordTip'		=> 'Hinweis: Das Fehlen eines Administrator-Passworts ist eine Bedrohung für die Sicherheit! Gib das Passwort in der Konfigurationsdatei an und starte das Programm erneut.',

	'ErrorLoadingModule'		=> 'Fehler beim Laden des Admin-Moduls %1: existiert nicht.',

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
	'Mandatory'					=> 'zwingend',
	'Admin'						=> 'Admin',

	'MiscellaneousSection'		=> 'Sonstiges',
	'MainSection'				=> 'Grundeinstellungen',

	'DirNotWritable'			=> 'Das Verzeichis %1 ist nicht schreibbar.',

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

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Gelöscht',
		'title'		=> 'Neu gelöschte Inhalte',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menü',
		'title'		=> 'Hinzufügen, Bearbeiten oder Entfernen von Standard-Menüpunkten',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Datensicherung',
		'title'		=> 'Daten sichern',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Reparatur',
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
	'tool_badbehavior'		=> [
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

	// Main module
	'PurgeSessions'				=> 'entfernen',
	'PurgeSessionsTip'			=> 'Entferne alle Sitzungen',
	'PurgeSessionsConfirm'		=> 'Bist du dir sicher, daß du alle Sitzungen entfernen willst? Dies wird alle Nuzer abmelden.',
	'PurgeSessionsExplain'		=> 'Entferne alle Sitzungen. Dies wird alle Nuzer abmelden in dem es die auth_token Tabelle leert.',
	'PurgeSessionsDone'			=> 'Sitzungen erfolgreich enfernt.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Grundeinstellungen aktualisiert',
	'LogBasicSettingsUpdated'	=> 'Grundeinstellungen aktualisiert',

	'SiteName'					=> 'Name der Seite:',
	'SiteNameInfo'				=> 'Der Seitentitel erscheint in der Titelleiste des Browsers, Theme Header, Email-Benachrichtigung, etc.',
	'SiteDesc'					=> 'Beschreibung der Seite:',
	'SiteDescInfo'				=> 'Ergänzung zum Titel der Website, die im Seitenkopf erscheint, um in wenigen Worten zu erklären, worum es in dieser Seite geht.',
	'AdminName'					=> 'Administrator der Seite:',
	'AdminNameInfo'				=> 'Benutzername, der insgesamt für die Webseite verantwortlich ist. Dieser Name wird nicht verwendet, um Zugriffsrechte zu bestimmen, aber es ist wünschenswert, dass er dem Namen des Hauptadministrators der Webseite entspricht.',

	'LanguageSection'			=> 'Sprache',
	'DefaultLanguage'			=> 'Standard-Sprache:',
	'DefaultLanguageInfo'		=> 'Definiert die Spracheinstellung für (nicht registrierte) Gäste sowie die Gebietsschemaeinstellungen.',
	'MultiLanguage'				=> 'Unterstützung mehrerer Sprachen:',
	'MultiLanguageInfo'			=> 'Enthält eine Auswahl an Sprachen auf Seitenbasis.',
	'AllowedLanguages'			=> 'Erlaubte Sprachen:',
	'AllowedLanguagesInfo'		=> 'Es wird empfohlen, nur die Sprachen auszuwählen, die man verwenden möchte. Andernfalls sind alle Sprachen ausgewählt.',

	'CommentSection'			=> 'Kommentare',
	'AllowComments'				=> 'Kommentare aktivieren:',
	'AllowCommentsInfo'			=> 'Aktivieren von Kommentaren für Gäste, registrierte Benutzer oder deaktivieren auf der gesamten Website.',
	'SortingComments'			=> 'Kommentare sortieren:',
	'SortingCommentsInfo'		=> 'Ändern der Reihenfolge, in der die Seitenkommentare angezeigt werden, entweder mit dem neuesten oder dem ältesten Kommentar oben.',

	'ToolbarSection'			=> 'Werkzeugleisten',
	'CommentsPanel'				=> 'Kommentare:',
	'CommentsPanelInfo'			=> 'Die Standardanzeige von Kommentaren im unteren Bereich der Seite.',
	'FilePanel'					=> 'Dateien:',
	'FilePanelInfo'				=> 'Die Standardanzeige von Anhängen im unteren Bereich der Seite.',
	'TagsPanel'					=> 'Schlagworte:',
	'TagsPanelInfo'				=> 'Die Standardanzeige für Schlagworte im unteren Bereich der Seite.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Zeige Permalink:',
	'ShowPermalinkInfo'			=> 'Die Standardanzeige des Permalinks für die aktuelle Version der Seite.',
	'TocPanel'					=> 'Inhaltsverzeichnis:',
	'TocPanelInfo'				=> 'Die Standardanzeige für das Inhaltsverzeichnis-Fenster der Seite (setzt die Unterstützung durch das Layout vorraus).',
	'SectionsPanel'				=> 'Bereichsanzeige (Seitenbaum):',
	'SectionsPanelInfo'			=> 'Das Fenster zeigt standardmäßig benachbarte Seiten im Namensraum an (setzt die Unterstützung durch das Layout voraus).',
	'DisplayingSections'		=> 'Angezeigte Bereiche:',
	'DisplayingSectionsInfo'	=> 'Wenn die vorherige Option aktiviert ist, werden nur untergeordnete Seiten (<em> untere </em>), nur benachbarte (<em> obere </em>) oder beide (<em> Baum </em>) ausgegeben.',
	'MenuItems'					=> 'Menüpunkte:',
	'MenuItemsInfo'				=> 'Standardanzahl der angezeigten Menüelemente (setzt die Unterstützung durch das Layout vorraus).',

	'HandlerSection'			=> 'Handler',
	'HideRevisions'				=> 'Seitenversionen ausblenden:',
	'HideRevisionsInfo'			=> 'Die Standardanzeige der Seitenversionen.',
	'AttachmentHandler'			=> 'Datei-Handler aktivieren:',
	'AttachmentHandlerInfo'		=> 'Erlaubt das Anzeigen des Datei-Handlers für Gäste oder registrierte Benutzer.',
	'SourceHandler'				=> 'Quelltext-Handler aktivieren:',
	'SourceHandlerInfo'			=> 'Erlaubt das Anzeigen des Quelltext-Handlers für Gäste oder registrierte Benutzer.',
	'ExportHandler'				=> 'XML-Export-Handler aktivieren:',
	'ExportHandlerInfo'			=> 'Erlaubt das Anzeigen des XML-Export-Handler.',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Aktiviere Feeds:',
	'EnableFeedsInfo'			=> 'Aktiviert oder deaktiviert RSS-Feeds für das gesamte Wiki.',

	'XmlSitemap'				=> 'XML-Sitemap:',
	'XmlSitemapInfo'			=> 'Erstellt eine XML-Datei namens %1. Der Pfad zur Sitemap kann in der robots.txt-Datei im Stammverzeichnis wie folgt hinzufügt werden:',
	'XmlSitemapGz'				=> 'XML-Sitemap-Komprimierung:',
	'XmlSitemapGzInfo'			=> 'Wenn gewünscht, kann man die Sitemap-Textdatei mit gzip komprimieren, um den Bandbreitenbedarf zu verringern.',
	'XmlSitemapTime'			=> 'XML-Sitemap-Erstellungszeit:',
	'XmlSitemapTimeInfo'		=> 'Erzeugt die Sitemap nur einmal in der angegebenen Anzahl von Tagen, Null bedeutet bei jeder Seitenänderung.',

	'SearchSection'				=> 'Suche',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Legt die OpenSearch-Beschreibungsdatei im XML-Ordner an und aktiviert die automatische Erkennung des Such-Plugins im HTML-Header.',
	'SearchEngineVisibility'	=> 'Suchmaschinen blockieren (Suchmaschinen-Sichtbarkeit):',
	'SearchEngineVisibilityInfo'=> 'Suchmaschinen blockieren, aber normale Besucher erlauben. Überschreibt die Seiteneinstellungen. Hiermit wird erklärt, keine Indexierung durch Suchmaschinen zu erlauben.',

	'DiffModeSection'			=> 'Diff-Modi',
	'DefaultDiffModeSetting'	=> 'Standard Diff-Modus:',
	'DefaultDiffModeSettingInfo'=> 'Vorausgewählter Diff-Modus.',
	'AllowedDiffMode'			=> 'Zugelassene Diff-Modi:',
	'AllowedDiffModeInfo'		=> 'Es wird empfohlen, nur die Modi auszuwählen, welche man verwenden möchte. Andernfalls werden alle Diff-Modi ausgewählt.',
	'NotifyDiffMode'			=> 'Diff-Modus für Benachrichtigungen:',
	'NotifyDiffModeInfo'		=> 'Diff-Modus für Benachrichtigungen im E-Mail-Textkörper.',

	'EditingSection'			=> 'Bearbeitung',
	'EditSummary'				=> 'Änderungszusammenfassung aktivieren:',
	'EditSummaryInfo'			=> 'Zeigt Kommentarfeld für die Zusammenfassung von Änderungen im Bearbeitungsmodus.',
	'MinorEdit'					=> 'Kleine Änderung:',
	'MinorEditInfo'				=> 'Aktiviert die Option "Kleine Änderung" im Bearbeitungsmodus.',
	'ReviewSettings'			=> 'Änderungen überprüfen:',
	'ReviewSettingsInfo'		=> 'Aktiviert die Option Änderungen durch einen "Reviewer" zu prüfen. In der Gruppenverwaltung muss mindestens ein "Reviewer" zugeordnet sein (WackoWiki Administration: Nutzer > Gruppen > Reviewer > hinzufügen).',
	'PublishAnonymously'		=> 'Anonyme Veröffentlichung zulassen:',
	'PublishAnonymouslyInfo'	=> 'Erlaubt den Benutzern, vorzugsweise anonym zu veröffentlichen (um den Namen zu verbergen).',

	'DefaultRenameRedirect'		=> 'Bei Umbenennung einer Seite eine Umleitung setzen:',
	'DefaultRenameRedirectInfo'	=> 'Standardmäßig erfolgt eine Umleitung an die alte Adresse der umbenannten Seite.',
	'StoreDeletedPages'			=> 'Gelöschte Seiten behalten:',
	'StoreDeletedPagesInfo'		=> 'Wenn eine Seite, einen Kommentar oder eine Datei gelöscht wird, steht diese noch in einen gesonderten Bereich für eine bestimmte Zeit (siehe nächster Punkt) zur die Wiederherstellung und Anzeige zur Verfügung.',
	'KeepDeletedTime'			=> 'Aufbewahrungszeit für gelöschten Seiten:',
	'KeepDeletedTimeInfo'		=> 'Der Zeitraum in Tagen. Dies macht nur mit der vorherigen Option Sinn. Null bedeutet unbegrenzte Aufbewahrungszeit (in diesem Fall kann der Administrator diese manuell im Verwaltungs-Panel löschen).',
	'PagesPurgeTime'			=> 'Aufbewahrungszeit der Seiten-Revisionen:',
	'PagesPurgeTimeInfo'		=> 'Löscht automatisch die älteren Versionen innerhalb der angegebenen Anzahl von Tagen. Wenn Sie Null eingeben, werden die älteren Versionen nicht entfernt.',
	'EnableReferrers'			=> 'Erlaube Referrer:',
	'EnableReferrersInfo'		=> 'Ermöglicht das Speichern und Anzeigen externer Verweise.',
	'ReferrersPurgeTime'		=> 'Aufbewahrungszeit der Verweise:',
	'ReferrersPurgeTimeInfo'	=> 'Verlauf der Aufrufe externer Seiten nicht länger als diese Anzahl von Tagen aufbewahren. Null bedeutet unbegrenzte Aufbewahrungszeit, aber die Seite aktiv zu besuchen, kann zu einer hohen Auslastung der Datenbank führen.',
	'EnableCounters'			=> 'Seitenzugriffszähler:',
	'EnableCountersInfo'		=> 'Erlaubt die Zählung der Zugriffe pro Seite und ermöglicht die Anzeige von einfachen Statistiken. Aufrufe des Seitenbesitzers werden nicht gezählt.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Die Darstellung der Webseite ändern',
	'AppearanceSettingsUpdated'	=> 'Aussehen der Webseite wurde aktualisiert.',

	'LogoOff'					=> 'Aus',
	'LogoOnly'					=> 'Logo',
	'LogoAndTitle'				=> 'Logo und Titel',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Website-Logo:',
	'SiteLogoInfo'				=> 'Das Logo wird normalerweise in der oberen linken Ecke der Anwendung angezeigt. Die maximale Größe beträgt 2 MiB. Optimale Abmessungen sind 255 Pixel breit und 55 Pixel hoch.',
	'LogoDimensions'			=> 'Logo Maße:',
	'LogoDimensionsInfo'		=> 'Breite und Höhe des angezeigten Logos.',
	'LogoDisplayMode'			=> 'Logo-Anzeigemodus:',
	'LogoDisplayModeInfo'		=> 'Bestimmt wie und ob das Logo angezeigt wird. Standard ist ausgeschaltet.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Website-Favicon:',
	'SiteFaviconInfo'			=> 'Das Verknüpfungssymbol oder Favicon wird in der Adressleiste, den Registerkarten und den Lesezeichen der meisten Browser angezeigt. Dies überschreibt das Favicon deines Themas.',
	'SiteFaviconTooBig'			=> 'Favicon ist größer als 64 × 64px.',
	'ThemeColor'				=> 'Themenfarbe für die Adressleiste:',
	'ThemeColorInfo'			=> 'Der Browser setzt die Farbe der Adressleiste auf allen Seiten entsprechend der angegebenen CSS-Farbe. ',

	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Layout:',
	'ThemeInfo'					=> 'Layout, welches die Site standardmäßig verwendet.',
	'ThemesAllowed'				=> 'Zulässige Layouts:',
	'ThemesAllowedInfo'			=> 'Wähle die zulässigen Layouts aus, die der Benutzer verwenden kann, andernfalls sind alle verfügbaren Layouts zulässig.',
	'ThemesPerPage'				=> 'Layouts pro Seite:',
	'ThemesPerPageInfo'			=> 'Erlaube Layouts pro Seite, welche der Seitenbesitzer über Seiteneigenschaften auswählen kann.',

	// System settings
	'SystemSettingsInfo'		=> 'Systemeinstellungen der Webseite. Verändere hier nichts, außer wenn Du sicher über die Folgen bist.',
	'SystemSettingsUpdated'		=> 'Systemeinstellungen  aktualisiert',
	'DebugModeSection'			=> 'Debug-Modus',
	'DebugMode'					=> 'Debug-Modus:',
	'DebugModeInfo'				=> 'An- und Abschaltung der Ausgabe von Telemetriedaten über die Programmlaufzeit. Achtung: Der Modus für alle Details stellt höhere Anforderungen an den zugewiesenen Speicher, insbesondere bei ressourcenintensiven Vorgängen wie dem Sichern und Wiederherstellen der Datenbank.',
	'DebugModes'	=> [
		'0'		=> 'Debug-Modus ist deaktiviert',
		'1'		=> 'nur die Gesamtausführungszeit',
		'2'		=> 'alle Zeiten',
		'3'		=> 'alle Details (DBMS, Cache, usw.)',
	],
	'DebugSqlThreshold'			=> 'RDBMS Schwellenwert:',
	'DebugSqlThresholdInfo'		=> 'Im erweiterten Debug-Modus werden nur die Abfragen aufgezeichnet, welche die Anzahl der hier ausgewiesen Sekunden überschreiten.',
	'DebugAdminOnly'			=> 'Geschlossene Diagnose:',
	'DebugAdminOnlyInfo'		=> 'Zeigt die Telemetriedaten der Anwendung (und des DBMS) nur dem Administrator.',

	'CachingSection'			=> 'Zwischenspeicher-Optionen',
	'Cache'						=> 'Gerenderte Seiten zwischenspeichern:',
	'CacheInfo'					=> 'Gerenderte Seiten zwischenspeichern, um nachfolgende Seitenaufrufe zu beschleunigen. Nur gültig für nicht angemeldete Nutzer.',
	'CacheTtl'					=> 'Aufbewahrungsdauer zwischenspeicherter Seiten:',
	'CacheTtlInfo'				=> 'Speichere Seiten nicht länger als die angegebene Anzahl von Sekunden zwischen.',
	'CacheSql'					=> 'SQL-Abfragen zwischenspeichern:',
	'CacheSqlInfo'				=> 'Einen lokalen Zwischenspeicher mit Ergebnissen aus bestimmten Datenbankabfragen (resource-SQL-queries) behalten.',
	'CacheSqlTtl'				=> 'Aufbewahrungsdauer zwischengespeicherter SQL-Abfragen:',
	'CacheSqlTtlInfo'			=> 'Speichere Ergebnisse der SQL-Abfragen nicht länger als die angegebene Anzahl von Sekunden zwischen. Einen Wert >1200 zu verwenden ist ungünstig.',

	'LogSection'				=> 'Protokolleinstellungen',
	'LogLevelUsage'				=> 'Protokollierung verwenden:',
	'LogLevelUsageInfo'			=> 'Die Mindestpriorität für Ereignisse, die im Protokoll aufgezeichnet werden.',
	'LogThresholds'	=> [
		'0'		=> 'keine Protokollierung',
		'1'		=> 'nur kritische Stufe',
		'2'		=> 'höchste Stufe',
		'3'		=> 'hoch',
		'4'		=> 'mittel',
		'5'		=> 'niedrig',
		'6'		=> 'niedrigste Stufe',
		'7'		=> 'alles aufzeichnen',
	],
	'LogDefaultShow'			=> 'Angezeigter Log-Modus:',
	'LogDefaultShowInfo'		=> 'Die Mindestpriorität für Ereignisse die standardmäßig im Log angezeigt werden .',
	'LogModes'	=> [
		'1'		=> 'nur kritische Stufe',
		'2'		=> 'höchste Stufe',
		'3'		=> 'hohes Stufe',
		'4'		=> 'mittel',
		'5'		=> 'niedrig',
		'6'		=> 'niedrigste Stufe',
		'7'		=> 'zeige alle',
	],
	'LogPurgeTime'				=> 'Aufbewahrungszeit für das Ereignisprotokoll:',
	'LogPurgeTimeInfo'			=> 'Entfernt das Ereignisprotokoll nach der angegebenen Anzahl von Tagen.',

	'PrivacySection'			=> 'Datenschutz',
	'AnonymizeIp'				=> 'Anonymisiere Benutzer IP-Adressen:',
	'AnonymizeIpInfo'			=> 'Anonymisiert IP-Adressen wo möglich, wie Bearbeitung der Seite, Revisionen oder Referrers.',

	'ReverseProxySection'		=> 'Reverse-Proxy',
	'ReverseProxy'				=> 'Nutze Reverse-Proxy:',
	'ReverseProxyInfo'			=> 'Aktivieren Sie diese Einstellung, um die korrekte IP-Adresse des Remote-
									 Clients zu ermitteln, indem Sie die in den X-Forwarded-For-Headern
									 gespeicherten Informationen untersuchen. X-Forwarded-For-Header sind ein
									 Standardmechanismus zum Identifizieren von Client-Systemen, die über einen
									 Reverse-Proxy-Server wie Squid oder Pound verbunden sind. Reverse-Proxy-Server
									 werden häufig verwendet, um die Leistung stark frequentierter Websites zu
									 verbessern, und bieten möglicherweise auch andere Vorteile für lokale
									 Zwischenspeicherung (Cache), Sicherheit oder Verschlüsselung.
									 Wenn diese WackoWiki-Installation hinter einem Reverse-Proxy ausgeführt wird,
									 sollte diese Einstellung aktiviert sein, damit die korrekten
									 IP-Adressinformationen in WackoWiki\'s Sitzungsmanagement-, Protokollierungs-,
									 Statistik- und Zugriffsverwaltungssystemen erfasst werden.
									 Wenn Sie sich bei dieser Einstellung nicht sicher sind, keinen Reverse-Proxy
									 haben oder WackoWiki in einer Shared-Hosting-Umgebung betreiben,
									 sollte diese Einstellung deaktiviert bleiben.',
	'ReverseProxyHeader'		=> 'Reverse-Proxy-Header:',
	'ReverseProxyHeaderInfo'	=> 'Setzen Sie diesen Wert nur, wenn Ihr Proxy-Server die Client-IP
									 nicht mit X-Forwarded-For-Header sendet. Der Header "X-Forwarded-For"
									 ist eine durch Komma + Leerzeichen getrennte Liste von IP-Adressen,
									 wobei nur der letzte (der linke) verwendet.',
	'ReverseProxyAddresses'		=> 'Reverse-Proxy IP-Adressliste:',
	'ReverseProxyAddressesInfo'	=> 'Jedes Element dieser Liste ist eine IP-Adresse eines zu verwendenden
									 Reverse-Proxy. WackoWiki wird diesen, im X-Forwarded-For Header zu speichernden,
									 Informationen nur vertrauen, wenn die Anfrage den Webserver über die
									 entfernte IP-Adresse eines gelisteten Reverse-Proxies erreicht. Ansonsten könnte
									 der Client sich direkt mit Deinem Webserver verbinden und den X-Forwarded-For Header täuschen.',

	'SessionSection'				=> 'Sitzungsbehandlung',
	'SessionStorage'				=> 'Sitzungsspeicher:',
	'SessionStorageInfo'			=> 'Diese Option definiert, wo die Sitzungsdaten gespeichert werden. Standardmäßig ist entweder der Speicher für Datei- oder Datenbanksitzungen ausgewählt.',
	'SessionModes'	=> [
		'1'		=> 'Datei',
		'2'		=> 'Datenbank',
	],
	'SessionNotice'					=> 'Zeige Ursache für Sitzungsabbruch:',
	'SessionNoticeInfo'				=> 'Gibt die Ursache für die Beendigung der Sitzung an.',

	'RewriteMode'					=> 'Verwende <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Wenn der Webserver diese Funktion unterstützt, aktiviere sie, um "schöne" Seitenadressen zu erhalten.<br>
									<span class="cite">Der Wert wird möglicherweise zur Laufzeit von der Settings-Klasse überschrieben, obwohl er deaktiviert ist, wenn HTTP_MOD_REWRITE aktiviert ist.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Einstellungen für Zugriffsteuerung und Berechtigungen.',
	'PermissionsSettingsUpdated'	=> 'Berechtigungen aktualisiert',

	'PermissionsSection'		=> 'Rechte und Privilegien',
	'ReadRights'				=> 'Standard-Leserechte:',
	'ReadRightsInfo'			=> 'Diese werden sowohl den erstellten Wurzelseiten als auch Seiten zugeordnet, für die keine Elternrechte definiert werden können.',
	'WriteRights'				=> 'Standard-Schreibrechte:',
	'WriteRightsInfo'			=> 'Diese werden sowohl den erstellten Wurzelseiten als auch Seiten zugeordnet, für die keine Elternrechte definiert werden können.',
	'CommentRights'				=> 'Standard-Kommentarrechte:',
	'CommentRightsInfo'			=> 'Diese werden sowohl den erstellten Wurzelseiten als auch Seiten zugeordnet, für die keine Elternrechte definiert werden können.',
	'CreateRights'				=> 'Standard-Rechte zum Erstellen von Unterseiten:',
	'CreateRightsInfo'			=> 'Hiermit wird die Berechtigung für die Erstellung von Wurzelseiten festgelegt und auch Seiten zugeordnet, für die keine Elternrechte definiert werden können.',
	'UploadRights'				=> 'Standard-Rechte für das Hochladen von Dateien:',
	'UploadRightsInfo'			=> 'Diese werden sowohl den erstellten Wurzelseiten als auch Seiten zugeordnet, für die keine Elternrechte definiert werden können.',
	'RenameRights'				=> 'Globale Berechtigung Seiten umzubenennen:',
	'RenameRightsInfo'			=> 'Liste von Benutzern mit Berechtigung, Seiten umzubenennen (zu verschieben).',

	'LockAcl'					=> 'Beschränke alle Berechtigungen auf Nur Lesen:',
	'LockAclInfo'				=> '<span class="cite">Überschreibt die Berechtigungen für alle Seiten zu Nur Lesen.</span><br>Dies kann nützlich sein, wenn ein Projekt beendet wurde oder aus Sicherheitsgründen die Bearbeitung von Seiten zeitweise ausgesetzt werden muss oder als Notfallmaßnahme.',
	'HideLocked'				=> 'Nicht zugängliche Seiten ausblenden:',
	'HideLockedInfo'			=> 'Wenn der Benutzer nicht berechtigt ist, eine Seite zu lesen, blenden sie in verschiedenen Seitenlisten aus (der im Text platzierte Link ist jedoch weiterhin sichtbar).',
	'RemoveOnlyAdmins'			=> 'Nur Administratoren können Seiten löschen:',
	'RemoveOnlyAdminsInfo'		=> 'Verbietet allen Benutzern, außer Administratoren, Seiten zu löschen. Wird zuerst auf Besitzer normaler Seiten angewendet.',
	'OwnersRemoveComments'		=> 'Seitenbesitzer können Kommentare löschen:',
	'OwnersRemoveCommentsInfo'	=> 'Ermöglicht es Seitenbesitzern, Kommentare auf ihren Seiten zu moderieren.',
	'OwnersEditCategories'		=> 'Seitenbesitzer können Seitenkategorien bearbeiten:',
	'OwnersEditCategoriesInfo'	=> 'Erlaubt es den Seitenbesitzern die Kageorien-Liste, welche den Seiten zugewiesen ist, zu ändern (Wörter hinzufügen, umbenennen oder löschen)',
	'TermHumanModeration'		=> 'Zeit zur Moderation:',
	'TermHumanModerationInfo'	=> 'Moderatoren können Kommentare nur innerhalb dieser Anzahl von Tagen nach deren Erstellung bearbeiten (diese Einschränkung gilt nicht für den letzten Kommentar zum Thema)',

	'UserCanDeleteAccount'		=> 'Benutzer dürfen ihre Konten löschen',

	// Security settings
	'SecuritySettingsInfo'		=> 'Gesamte Sicherheitseinstellungen für die Platform, Benutzersicherheit und Sicherheitsteilsysteme.',
	'SecuritySettingsUpdated'	=> 'Sicherheitseinstellungen aktualisiert',

	'AllowRegistration'			=> 'Online registrieren:',
	'AllowRegistrationInfo'		=> 'Öffnen der Benutzerregistrierung. Das Deaktivieren der Option verhindert die freie Registrierung. Der Site-Administrator kann jedoch andere Benutzer selbst registrieren.',
	'ApproveNewUser'			=> 'Neue Nutzer bestätigen:',
	'ApproveNewUserInfo'		=> 'Ermöglicht Administratoren, Benutzer nach der Registrierung zuzulassen. Nur zugelassene Benutzer dürfen sich auf der Site anmelden.',
	'PersistentCookies'			=> 'Dauerhafte Cookies:',
	'PersistentCookiesInfo'		=> 'Erlaube dauerhafte Cookies.',
	'DisableWikiName'			=> 'Deaktiviere WikiName:',
	'DisableWikiNameInfo'		=> 'Deaktiviert die die obligatorische Verwendung von WikiNamen. Ermöglicht die Registrierung von Benutzern mit traditionellen Spitznamen, NameVorname ist nicht zwingend.',
	'AllowEmailReuse'			=> 'Erlaubt die Wiederverwendung von E-Mail-Adressen:',
	'AllowEmailReuseInfo'		=> 'Verschiedene Benutzer können sich mit derselben E-Mail-Adresse registrieren.',
	'AllowedEmailDomains'		=> 'Allowed email domains:',
	'AllowedEmailDomainsInfo'	=> 'Allowed email domains comma separated, e.g. <code>example.com, local.lan</code> etc., other wise all email domains are allowed.',
	'UsernameLength'			=> 'Länge von Benutzernamen:',
	'UsernameLengthInfo'		=> 'Mindestens erforderliche und maximal zulässige Zeichenanzahl in Benutzernamen.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Aktiviere Captcha:',
	'EnableCaptchaInfo'			=> 'Aktiviert eine Sicherheitsabfrage zum Schutz vor SPAM auf der gesamten Website.',
	'CaptchaComment'			=> 'Neuer Kommentar:',
	'CaptchaCommentInfo'		=> 'Wenn aktiviert, wird für nicht registrierte Benutzer eine Sicherheitsabfrage (Captcha) vor der Veröffentlichung von Kommentaren erforderlich.',
	'CaptchaPage'				=> 'Neue Seite:',
	'CaptchaPageInfo'			=> 'Wenn aktiviert, wird für nicht registrierte Benutzer eine Sicherheitsabfrage (Captcha) vor der Erstellung von neuen Seiten erforderlich.',
	'CaptchaEdit'				=> 'Seite bearbeiten:',
	'CaptchaEditInfo'			=> 'Wenn aktiviert, wird für nicht registrierte Benutzer eine Sicherheitsabfrage (Captcha) vor der Bearbeitung von Seiten erforderlich.',
	'CaptchaRegistration'		=> 'Registrierung:',
	'CaptchaRegistrationInfo'	=> 'Wenn aktiviert, wird für nicht registrierte Benutzer eine Sicherheitsabfrage (Captcha) vor der Registrierung  erforderlich.',

	'TlsSection'				=> 'TLS-Einstellungen',
	'TlsConnection'				=> 'TLS-Verwendung:',
	'TlsConnectionInfo'			=> 'Verwende eine TLS-gesicherte Verbindung. <span class = "cite"> Dazu ist es erforderlich, ein TLS-Zertifikat auf dem Server zu installieren, sonst besteht kein Zugriff auf den Admin-Bereich!</span><br>Es legt auch fest, ob der Cookie Secure Flag gesetzt ist, der <code>secure</code> Flag definiert, ob Cookies nur über sichere Verbindungen geschickt werden sollen.',
	'TlsImplicit'				=> 'TLS erzwingen:',
	'TlsImplicitInfo'			=> 'Erzwingt erneute Verbindung des Clients von HTTP zu HTTPS. Wenn die Option deaktiviert ist, kann der Client die die Webseite über einen verschlüsselten HTTPS-Kanal übertragen.',

	'HttpSecurityHeaders'		=> 'HTTP-Security-Header',
	'EnableSecurityHeaders'		=> 'Security-Header aktivieren:',
	'EnableSecurityHeadersinfo'	=> 'Aktiviert Security-Header (frame busting, clickjacking/XSS/CSRF-Schutz). <br> Diese Content Security Policy (CSP) kann in bestimmten Situationen (z. B. während der Entwicklung) oder bei Verwendung von Plugins, die auf extern gehostete Ressourcen wie Bilder oder Skripts angewiesen sind, Probleme verursachen. <br> Das Deaktivieren der CSP ist ein Sicherheitsrisiko!',
	'Csp'						=> 'Content-Security-Policy (CSP):',
	'CspInfo'					=> 'Zur Etablierung von Sicherheitsrichtlinien gegen schadhafte Inhalte gehört zu entscheiden, welche einzelnen Richtlinien geschaffen werden sollen, diese zu gestalten und festzuschreiben.',
	'PolicyModes'	=> [
		'0'		=> 'deaktiviert',
		'1'		=> 'strikt',
		'2'		=> 'benutzerdefiniert',
	],
	'PermissionsPolicy'			=> 'Permissions Policy:',
	'PermissionsPolicyInfo'		=> 'Der HTTP Permissions-Policy-Header bietet einen Mechanismus zum expliziten Aktivieren oder Deaktivieren verschiedener leistungsstarker Browserfunktionen.',
	'ReferrerPolicy'			=> 'Referrer Policy:',
	'ReferrerPolicyInfo'		=> 'Der Referrer-Policy-HTTP-Header bestimmt, welche Referrer-Informationen, die im Referer-Header gesendet werden, in die Anfragen aufgenommen werden sollen.',
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

	'UserPasswordSection'		=> 'Passwortschutz-Einstellungen',
	'PwdMinChars'				=> 'Minimale Passwortlänge:',
	'PwdMinCharsInfo'			=> 'Längere Passwörter bieten notwendigerweise mehr Schutz als kürzere Passwörter (z.B. 12 bis 16 Zeichen).<br>Anstelle eines einzelnen Passwortes wird die Verwendung einer Passphrase empfohlen.',
	'AdminPwdMinChars'			=> 'Minimale Admin Passwortlänge:',
	'AdminPwdMinCharsInfo'		=> 'Längere Passwörter bieten notwendigerweise mehr Schutz als kürzere Passwörter (z.B. 15 bis 20 Zeichen).<br>Anstelle eines einzelnen Passwortes wird die Verwendung einer Passphrase empfohlen.',
	'PwdCharComplexity'			=> 'Die erforderliche Kennwortkomplexität:',
	'PwdCharClasses'	=> [
		'0'		=> 'ungeprüft',
		'1'		=> 'alle Buchstaben + Zahlen',
		'2'		=> 'Groß- und Kleinschreibung + Zahlen',
		'3'		=> 'Groß- und Kleinschreibung + Zahlen + Zeichen',
	],
	'PwdUnlikeLogin'			=> 'zusätzliche Erschwernis:',
	'PwdUnlikes'	=> [
		'0'		=> 'ungeprüft',
		'1'		=> 'Passwort darf nicht identisch mit dem Anmeldenamen sein',
		'2'		=> 'Passwort darf nicht den Anmeldenamen enthalten',
	],

	'LoginSection'				=> 'Anmeldung',
	'MaxLoginAttempts'			=> 'Maximale Anzahl von Anmeldeversuchen pro Nutzername:',
	'MaxLoginAttemptsInfo'		=> 'Anzahl der zulässigen Login-Versuche je Benutzerkonto bevor der SPAM-Schutz ausgelöst wird. Wenn 0 eingetragen: kein SPAM-Schutz für die Anmeldung je Benutzer.',
	'IpLoginLimitMax'			=> 'Maximale Anzahl von Anmeldeversuchen pro IP-Adresse:',
	'IpLoginLimitMaxInfo'		=> 'Anzahl der zulässigen Login-Versuche von einer einzelnen IP-Adresse aus, bevor der SPAM-Schutz ausgelöst wird. Wenn 0 eingetragen: kein SPAM-Schutz für die Anmeldung je IP-Adresse.',

	'FormsSection'				=> 'Formulare',
	'FormTokenTime'				=> 'Maximale Zeit für die Übermittlung von Formularen:',
	'FormTokenTimeInfo'			=> 'Die Zeit, die ein Benutzer für das Senden eines Formulares hat (in Sekunden).<br> Beachte: Ein Formular wird unabhängig von dieser Einstellung ungültig, wenn die Sitzung (Session) abläuft.',

	'SessionLength'				=> 'Aufbewahrungsdauer Login-Cookie:',
	'SessionLengthInfo'			=> 'Die standardmäßige Lebensdauer des Anmelde-Cookies von Benutzern (in Tagen).',
	'CommentDelay'				=> 'Anti-Flut für Kommentare:',
	'CommentDelayInfo'			=> 'Mindestwartezeit zwischen der Veröffentlichung von neuen Benutzerkommentaren (in Sekunden).',
	'IntercomDelay'				=> 'Anti-Flut für persönliche Mitteilungen:',
	'IntercomDelayInfo'			=> 'Mindestwartezeit zwischen dem Senden einer persönlicher Nachricht (in Sekunden).',
	'RegistrationDelay'			=> 'Mindestdauer für die Registrierung:',
	'RegistrationDelayInfo'		=> 'Die minimale Zeitschwelle für das Ausfüllen des Registrierungsformulars, um Bots von Menschen zu unterscheiden (in Sekunden).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Gruppe von Parametern, die für die Feinabstimmung der Plattform verantwortlich sind. Ändere sie nicht, es sei denn, du bist mit ihrer Funktionsweise vertraut.',
	'FormatterSettingsUpdated'	=> 'Formatierungseinstellungen aktualisiert',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> 'Typografischer Korrektor:',
	'TypograficaInfo'			=> 'Durch das Deaktivieren wird der Vorgang des Hinzufügens von Kommentaren und des Speicherns von Seiten geringfügig beschleunigt.',
	'Paragrafica'				=> 'Paragrafica Markierungen:',
	'ParagraficaInfo'			=> 'Ähnlich wie bei der vorherigen Option, jedoch wird die Deaktivierung zu einer Fehlfunktion des automatischen Inhaltsverzeichnisses führen: <code>{{toc}}</code>.',
	'AllowRawhtml'				=> 'Globale HTML-Unterstützung:',
	'AllowRawhtmlInfo'			=> 'Die Verwendung dieser Option für eine offene Site ist möglicherweise unsicher.',
	'SafeHtml'					=> 'HTML filtern:',
	'SafeHtmlInfo'				=> 'Verhindert das Speichern gefährlicher HTML-Objekte. Das Deaktivieren des Filters auf einer offnen Website mit HTML-Unterstützung ist <span class="underline">extrem</span> unerwünscht!',

	'WackoFormatterSection'		=> 'Wiki Text Formatierer (Wacko Formatierer)',
	'X11colors'					=> 'X11 Farben Verwendung:',
	'X11colorsInfo'				=> 'Erweitert die verfügbaren Farben für <code>??(Farbe) Hintergrund??</code> und <code>!!(Farbe) Text!!</code>. Durch das Deaktivieren wird der Vorgang des Hinzufügens von Kommentaren und des Speicherns von Seiten geringfügig beschleunigt.',
	'WikiLinks'					=> 'Deaktiviere Wikilinks:',
	'WikiLinksInfo'				=> 'Deaktiviert die Verlinkung von <code>CamelCaseWords</code>, deine CamelCase Wörter werden nicht mehr direkt auf eine neue Seite verlink. Dies ist nützlich, wenn man über verschiedene Namensräume, also Cluster, hinweg arbeitet. Standardmäßig ist es ausgeschaltet.',
	'BracketsLinks'				=> 'Deaktiviere Bracketslinks:',
	'BracketsLinksInfo'			=> 'Deaktiviert <code>[[link]]</code> und <code>((link))</code> Syntax.',
	'Formatters'				=> 'Deaktiviere Formatierer:',
	'FormattersInfo'			=> 'Deaktiviert <code>%%code%%</code> Syntax, verwendet für Textauszeichner.',

	'DateFormatsSection'		=> 'Datumsformate',
	'DateFormat'				=> 'Das Format des Datums:',
	'DateFormatInfo'			=> '(Tag, Monat, Jahr)',
	'TimeFormat'				=> 'Das Format der Zeit:',
	'TimeFormatInfo'			=> '(Stunde, Minute)',
	'TimeFormatSeconds'			=> 'Das Format der genauen Zeit:',
	'TimeFormatSecondsInfo'		=> '(Stunden, Minuten, Sekunden)',
	'NameDateMacro'				=> 'Das Format des <code>::@::</code> Makros:',
	'NameDateMacroInfo'			=> '(Name, Zeit), e.g. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Zeitzone:',
	'TimezoneInfo'				=> 'Zeitzone für die Anzeige von Zeiten für Benutzer, die nicht angemeldet sind (Gäste). Angemeldete Benutzer können ihre Zeitzone in ihren Benutzereinstellungen einstellen und ändern.',

	'Canonical'					=> 'Links immer mit vollständigen URLs erzeugen:',
	'CanonicalInfo'				=> 'Alle Links werden als absolute URLs in der Form %1 erstellt. URLs relativ zur Server-Root in der Form %2 sollten bevorzugt werden.',
	'LinkTarget'				=> 'Wo externe Links geöffnet werden:',
	'LinkTargetInfo'			=> 'Öffnet jeden externen Link in einem neuen Browserfenster. Fügt <code>target="_blank"</code> zum Link-Syntax hinzu.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Setzt voraus, dass der Browser, wenn der Benutzer den Hyperlink folgt keine Referrer-Header sendet. Fügt <code>rel="noreferrer"</code> zum Link-Syntax hinzu.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Weist Suchmaschinen an, daß die Hyperlinks sich nicht auf das Seiten-Ranking der Zielseite im Suchmaschinenindex auswirken sollen. Fügt <code>rel="nofollow"</code> zum Link-Syntax hinzu.',
	'UrlsUnderscores'			=> 'Bildet Adressen (URLs) mit Unterstrichen:',
	'UrlsUnderscoresInfo'		=> 'Beispielsweise %1 wird zu %2 mit dieser Option.',
	'ShowSpaces'				=> 'Zeigt Leerzeichen in WikiNamen:',
	'ShowSpacesInfo'			=> 'Zeigt Leerzeichen in WikiNamen, e.g. <code>MyName</code> wird angezeigt als <code>My Name</code> mit dieser Option.',
	'NumerateLinks'				=> 'Nummeriert die Links in der Druckansicht:',
	'NumerateLinksInfo'			=> 'Nummeriert und listet alle Links am Fuß der Seite in der Druckansicht mit dieser Option.',
	'YouareHereText'			=> 'Deaktiviert und visualisiert selbstreferenzierende Links:',
	'YouareHereTextInfo'		=> 'Visualisiert Links zur selben Seite, bspw. <code>&lt;b&gt;####&lt;/b&gt;</code>, alle Links auf sich selbst werden nicht als Link, sondern als fetter Text dargestellt.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Hier kann man die im Wiki verwendeten System-Basisseiten einstellen oder ändern. Bitte vergiss nicht, die entsprechenden Seiten im Wiki gemäß der Einstellungen hier anzulegen oder zu ändern.',
	'PagesSettingsUpdated'		=> 'Einstellungen der Basisseiten aktualisiert',

	'ListCount'					=> 'Anzahl der Datensätze pro Liste:',
	'ListCountInfo'				=> 'Anzahl der Zeilen, die in jeder Liste für Gäste angezeigt werden, oder als Standardwert für neue Benutzer.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster Forum:',
	'ForumClusterInfo'			=> 'Root-Cluster für den Forumbereich (Aktion %1).',
	'ForumTopics'				=> 'Anzahl der Themen pro Seite:',
	'ForumTopicsInfo'			=> 'Anzahl der Themen, die auf jeder Seite der Liste in den Forumsabschnitten angezeigt werden (Aktion %1).',
	'CommentsCount'				=> 'Anzahl der Kommentare pro Seite:',
	'CommentsCountInfo'			=> 'Die Anzahl der Kommentare, welche auf jeder Seite der in der Kommentarliste angezeigt werden. Dies gilt für alle Kommentare auf der Website und nicht nur für die im Forum.',

	'NewsSection'				=> 'Nachrichten',
	'NewsCluster'				=> 'Nachrichten-Cluster:',
	'NewsClusterInfo'			=> 'Root-Cluster für den Nachrichtenbereich (Aktion %1).',
	'NewsStructure'				=> 'Aufbau des Nachrichten-Clusters:',
	'NewsStructureInfo'			=> 'Legt die Beiträge wahlweise in Sub-Cluster nach Jahr/Monat oder Woche ab. (e.g. <code>[Cluster]/[Jahr]/[Monat]</code>).',

	'LicenseSection'			=> 'Lizenz',
	'DefaultLicense'			=> 'Standard-Lizenz:',
	'DefaultLicenseInfo'		=> 'Unter welcher Lizenz sollen deine Inhalte veröffentlicht werden?',
	'EnableLicense'				=> 'Aktiviere Lizenz:',
	'EnableLicenseInfo'			=> 'Aktivieren, um Lizenzinformationen anzuzeigen.',
	'LicensePerPage'			=> 'Lizenz pro Seite:',
	'LicensePerPageInfo'		=> 'Erlaube Lizenz pro Seite, die der Seitenbesitzer über Seiteneigenschaften auswählen kann.',

	'ServicePagesSection'		=> 'Standardseiten',
	'RootPage'					=> 'Hauptseite:',
	'RootPageInfo'				=> 'Der Tag der Hauptseite, welcher automatisch aufgerufen wird, wenn ein Nutzer die Website besucht.',

	'PrivacyPage'				=> 'Datenschutzerklärung:',
	'PrivacyPageInfo'			=> 'Seite mit der Datenschutzerklärung der Website.',

	'TermsPage'					=> 'Nutzungsbedingungen:',
	'TermsPageInfo'				=> 'Seite mit den Nutzungsbedingungen der Website.',

	'SearchPage'				=> 'Suche:',
	'SearchPageInfo'			=> 'Seite mit dem Suchformular (Aktion %1).',
	'RegistrationPage'			=> 'Registrierung:',
	'RegistrationPageInfo'		=> 'Seite für neue Benutzerregistrierung (Aktion %1).',
	'LoginPage'					=> 'Benutzer-Anmeldung:',
	'LoginPageInfo'				=> 'Seite zur Anmeldung (Aktion %1).',
	'SettingsPage'				=> 'Benutzereinstellungen:',
	'SettingsPageInfo'			=> 'Seite zum Anpassen des Benutzerprofils (Aktion %1).',
	'PasswordPage'				=> 'Passwort ändern:',
	'PasswordPageInfo'			=> 'Seite mit dem Formular zum Ändern und Zurücksetzen des Benutzerpasswortes (Aktion %1).',
	'UsersPage'					=> 'Benutzerliste:',
	'UsersPageInfo'				=> 'Seite mit einer Liste der registrierten Benutzer (Aktion %1).',
	'CategoryPage'				=> 'Kategorien:',
	'CategoryPageInfo'			=> 'Seite mit einer Liste von kategorisierten Seiten (Aktion %1).',
	'TagPage'					=> 'Schlagworte:',
	'TagPageInfo'				=> 'Seite mit einer Liste von verschlagworteten Seiten (Aktion %1).',
	'GroupsPage'				=> 'Gruppen:',
	'GroupsPageInfo'			=> 'Seite mit einer Liste von Arbeitsgruppen (Aktion %1).',
	'ChangesPage'				=> 'Letzte Änderungen:',
	'ChangesPageInfo'			=> 'Seite mit einer Liste der zuletzt geänderten Seiten (Aktion %1).',
	'CommentsPage'				=> 'Letzte Kommentare:',
	'CommentsPageInfo'			=> 'Seite mit einer Liste der letzten Kommentare auf der Seite (Aktion %1).',
	'RemovalsPage'				=> 'Gelöschte Seiten:',
	'RemovalsPageInfo'			=> 'Seite mit einer Liste der zuletzt gelöschten Seiten (Aktion %1).',
	'WantedPage'				=> 'Gewünschte Seiten:',
	'WantedPageInfo'			=> 'Seite mit einer Liste der fehlenden Seiten, auf die verwiesen wird (Aktion %1).',
	'OrphanedPage'				=> 'Verwaiste Seiten:',
	'OrphanedPageInfo'			=> 'Seite mit einer Liste der vorhandenen Seiten welche von anderen Seiten nicht verlinkt wurden (Aktion %1).',
	'SandboxPage'				=> 'Sandkasten:',
	'SandboxPageInfo'			=> 'Seite, auf der Benutzer die Verwendung des Wiki-Markups üben können.',
	'HelpPage'					=> 'Hilfe:',
	'HelpPageInfo'				=> 'Die Dokumentation zum Arbeiten mit den Website-Werkzeugen.',
	'IndexPage'					=> 'Index:',
	'IndexPageInfo'				=> 'Seite mit einer Liste aller Seiten (Aktion %1).',
	'RandomPage'				=> 'Zufall:',
	'RandomPageInfo'			=> 'Lädt eine zufällige Seite (Aktion %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameter für Benachrichtigungen des Systems.',
	'NotificationSettingsUpdated'	=> 'Benachrichtigungseinstellungen aktualisiert',

	'EmailNotification'			=> 'E-Mail-Benachrichtigung:',
	'EmailNotificationInfo'		=> 'E-Mail-Benachrichtigung zulassen. Wähle EIN, um E-Mail-Benachrichtigungen zu aktivieren, und AUS, um sie zu deaktivieren. Beachte, dass die Deaktivierung von E-Mail-Benachrichtigungen keine Auswirkungen auf E-Mails hat, die im Rahmen des Benutzeranmeldungsvorgangs generiert werden.',
	'Autosubscribe'				=> 'Automatisch abonnieren:',
	'AutosubscribeInfo'			=> 'Aktiviert die automatischen Benachrichtigung für den Seitenbesitzer bei Änderungen.',

	'NotificationSection'		=> 'Benachrichtigungen',
	'NotifyPageEdit'			=> 'Seitenänderung mitteilen:',
	'NotifyPageEditInfo'		=> 'Ausstehend - Es wird nur für die erste Änderung einer beobachteten Seite eine Benachrichtigung gesendet. Die Benachrichtigung wird automatisch wieder aktiviert, wenn die aktuelle Version der Seite aufgerufen wird.',
	'NotifyMinorEdit'			=> 'Kleine Änderung mitteilen:',
	'NotifyMinorEditInfo'		=> 'Sende Mitteilungen auch bei kleinen Änderungen.',
	'NotifyNewComment'			=> 'Neuen Kommentar mitteilen:',
	'NotifyNewCommentInfo'		=> 'Ausstehend - Es wird nur für den ersten Kommentar einer beobachteten Seite eine Benachrichtigung gesendet. Die Benachrichtigung wird automatisch wieder aktiviert, wenn die aktuelle Version der Seite aufgerufen wird.',

	'NotifyUserAccount'			=> 'Neues Benutzerkonto mitteilen:',
	'NotifyUserAccountInfo'		=> 'Der Administrator wird benachrichtigt, wenn ein neuer Benutzer über das Anmelde-Formular erstellt wurde.',
	'NotifyUpload'				=> 'Benachrichtigung bei Datei-Upload:',
	'NotifyUploadInfo'			=> 'Die Moderatoren werden benachrichtigt, wenn eine Datei hochgeladen wurde.',

	'PersonalMessagesSection'	=> 'Persönliche Mitteilungen',
	'AllowIntercomDefault'		=> 'Erlaube Intercom:',
	'AllowIntercomDefaultInfo'	=> 'Ermöglicht das Senden von persönlichen Nachrichten an die E-Mail-Adresse des Empfänger ohne Offenlegung seiner Adresse.',
	'AllowMassemailDefault'		=> 'Erlaube Rundmail:',
	'AllowMassemailDefaultInfo'	=> 'Er sendet nur Nachrichten an die Benutzer, die den Administratoren das Senden von Informationen per E-Mail gestattet haben.',

	// Resync settings
	'Synchronize'				=> 'Synchronisieren',
	'UserStatsSynched'			=> 'Benutzerstatistiken wurden synchronisiert.',
	'PageStatsSynched'			=> 'Seitenstatistiken wurden synchronisiert.',
	'FeedsUpdated'				=> 'RSS-Feeds aktualisiert.',
	'SiteMapCreated'			=> 'Die neue Version der Sitemap wurde erfolgreich erstellt.',
	'ParseNextBatch'			=> 'Folgesatz von Seiten parsen:',
	'WikiLinksRestored'			=> 'Wiki-Links wiederhergestellt.',

	'LogUserStatsSynched'		=> 'Benutzerstatistiken synchronisiert',
	'LogPageStatsSynched'		=> 'Seitenstatistiken synchronisiert',
	'LogFeedsUpdated'			=> 'RSS-Feeds synchronisiert',
	'LogPageBodySynched'		=> 'Seitenkörper und Links repariert',

	'UserStats'					=> 'Benutzerstatistik',
	'UserStatsInfo'				=> 'Benutzerstatistiken (Anzahl der Kommentare, besessene Seiten, Revisionen und Dateien) können in einigen Situationen von den tatsächlichen Daten abweichen.<br> Diese Operation ermöglicht das Aktualisieren von Statistiken auf aktuelle tatsächliche Daten der Datenbank.',
	'PageStats'					=> 'Seitenstatistiken',
	'PageStatsInfo'				=> 'Seitenstatistiken (Anzahl der Kommentare, Dateien und Revisionen) können in einigen Situationen von den tatsächlichen Daten abweichen. <br> Diese Operation ermöglicht das Aktualisieren von Statistiken auf aktuelle tatsächliche Daten der Datenbank.',
	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'Im Falle der direkten Bearbeitung von Seiten in der Datenbank spiegelt der Inhalt der RSS-Feeds möglicherweise nicht die vorgenommenen Änderungen wider. <br> Diese Funktion synchronisiert die RSS-Kanäle mit dem aktuellen Zustand der Datenbank.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'Diese Funktion synchronisiert die XML-Sitemap mit dem aktuellen Zustand der Datenbank.',
	'XmlSiteMapPeriod'			=> 'Dauer %1 Tage. Zuletzt erstellt %2.',
	'XmlSiteMapView'			=> 'Zeigt die Sitemap in einem neuen Fenster.',

	'ReparseBody'				=> 'Alle Seiten erneut parsen',
	'ReparseBodyInfo'			=> 'Leert <code>body_r</code> in der Tabelle page, so dass jede Seite bei der nächsten Seitenansicht erneut gerendert wird. Dies kann nützlich sein, wenn der Formatierer modifiziert oder die Domäne des Wikis geändert wurde.',
	'PreparsedBodyPurged'		=> 'Feld <code>body_r</code> in Tabelle page geleert.',

	'WikiLinksResync'			=> 'Wiki-Links',
	'WikiLinksResyncInfo'		=> 'Führt ein Re-Rendering für alle Intrasite-Links durch und stellt den Inhalt der Tabelle <code>page_link</code> und <code>file_link</code> im Falle einer Beschädigung oder Verlagerung wieder her (dies kann einige Zeit in Anspruch nehmen).',
	'RecompilePage'				=> 'Alle Seiten neu kompilieren (extrem teuer)',
	'ResyncOptions'				=> 'Zusätzliche Otionen',
	'RecompilePageLimit'		=> 'Anzahl der auf einmal zu parsenden Seiten.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Diese Informationen werden benötigt, um E-Mails an die Benutzer zu senden. Stelle bitte sicher, dass die angegebene Adresse gültig ist; abgewiesene oder nicht zustellbare Nachrichten werden an diese Adresse geschickt. Falls dein Webhosting-Provider keinen PHP-basierten E-Mail-Dienst anbietet, können die Nachrichten auch direkt über SMTP versendet werden. Dies erfordert die Angabe der Adresse eines geeigneten Servers (frage falls nötig deinen Provider). Falls der Server eine Authentifizierung erfordert (und nur, wenn dies der Fall ist), gib den Benutzernamen und das Passwort ein und wähle eine Authentifizierungsmethode aus.',

	'EmailSettingsUpdated'		=> 'E-Mail Einstellungen wurden aktualisiert.',

	'EmailFunctionName'			=> 'Verwendete E-Mail-Funktion:',
	'EmailFunctionNameInfo'		=> 'Die PHP-Funktion, welche genutzt wird, um E-Mails zu versenden.',
	'UseSmtpInfo'				=> 'Wähle <code>SMTP</code> aus, wenn du E-Mails über einen SMTP-Server senden möchtest (oder musst), anstatt die PHP-eigene Mail-Funktion zu nutzen.',

	'EnableEmail'				=> 'Aktiviere E-Mail:',
	'EnableEmailInfo'			=> 'Aktiviere E-Mail-Funktionalität',

	'FromEmailName'				=> 'Absender:',
	'FromEmailNameInfo'			=> 'Absender Name, im Adressfeld <code>Von:</code> der Kopfzeile in E-Mails für alle E-Mail-Benachrichtigungen, die von dieser Seite gesendet werden.',
	'NoReplyEmail'				=> 'No-reply Adresse:',
	'NoReplyEmailInfo'			=> 'Diese Adresse, z.B. <code>noreply@example.com</code>, erscheint im Adressfeld <code>Von:</code> der Kopfzeile bei allen E-Mail Benachrichtigungen, die von dieser Seite gesendet werden.',
	'AdminEmail'				=> 'E-Mail Adresse des Seiteninhabers:',
	'AdminEmailInfo'			=> 'Diese Adresse ist für Administrationszwecke, wie Benachrichtigung bei neuen Benutzern.',
	'AbuseEmail'				=> 'Dienst bei E-Mail-Missbrauch:',
	'AbuseEmailInfo'			=> 'Adresse für dringende Angelegenheiten: Registrierung einer verdächtigen E-Mail, usw. Kann mit der vorherigen übereinstimmen.',

	'SendTestEmail'				=> 'Test-Mail senden',
	'SendTestEmailInfo'			=> 'Sendet eine Test-Mail an die in deinem Benutzerkonto hinterlegte Adresse.',
	'TestEmailSubject'			=> 'Dein Wiki ist für den E-Mail-Versand richtig konfiguriert',
	'TestEmailBody'				=> 'wenn du diese Nachricht erhältst, ist deine Wiki richtig für den E-Mail-Versand konfiguriert.',
	'TestEmailMessage'			=> 'Eine Test-E-Mail wurde gesendet.<br>Falls du sie nicht erhalten solltest, prüfe bitte deine E-Mail-Einstellungen.',

	'SmtpSettings'				=> 'SMTP-Einstellungen',
	'SmtpAutoTls'				=> 'STARTTLS:',
	'SmtpAutoTlsInfo'			=> 'Aktiviert Verschlüsselung automatisch, wenn der Server TLS Verschlüsselung anbietet (nach dem Aufbau der Serververbindung), sogar wenn <code>SMTPSecure</code> nicht eingeschaltet wurde.',
	'SmtpConnectionMode'		=> 'Authentifizierungsmethode für SMTP:',
	'SmtpConnectionModeInfo'	=> 'Nur benötigt, wenn ein Benutzername/Passwort eingegeben ist. Frage deinen Webhosting-Provider, falls du nicht sicher bist, welche Methode du wählen sollst.',
	'SmtpPassword'				=> 'SMTP-Passwort:',
	'SmtpPasswordInfo'			=> 'Gib nur ein Passwort ein, wenn dein SMTP-Server dies erfordert. <em><strong>WARNUNG:</strong> Dieses Passwort wird im Klartext in der Datenbank gespeichert und ist daher für jeden einsehbar, der Zugriff auf die Datenbank oder diese Konfigurationsseite hat.</em>',
	'SmtpPort'					=> 'SMTP-Server-Port:',
	'SmtpPortInfo'				=> 'Ändere diese Einstellung nur, wenn du weißt, dass dein SMTP-Server einen anderen Port nutzt. <br>(default: <code>tls</code> auf Port 587 (oder möglicherweise 25) und <code>ssl</code> auf Port 465)',
	'SmtpServer'				=> 'SMTP-Server-Adresse:',
	'SmtpServerInfo'			=> 'Beachte, dass du das Protokoll angeben musst, das dein Server verwendet. Wird SSL verwendet, musst du <code>ssl://mail.example.com</code> angeben.',
	'SmtpUsername'				=> 'SMTP-Benutzername:',
	'SmtpUsernameInfo'			=> 'Gib nur einen Benutzernamen ein, wenn dein SMTP-Server dies erfordert.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Hier können die Einstellungen für Dateianhänge und damit verknüpfte Kategorien angepasst werden.',
	'UploadSettingsUpdated'		=> 'Einstellungen für Dateianhänge aktualisiert',

	'FileUploadsSection'		=> 'Dateien hochladen',
	'RightToUpload'				=> 'Berechtigung Dateien hochzuladen:',
	'RightToUploadInfo'			=> '<code>admins</code> bedeutet nur Nutzer welche der Admins-Gruppe angehören, können Dateien hochladen. <code>1</code> bedeutet jeder registrierte Benutzer kann Dateien hochladen. <code>0</code> das Hochladen von Dateien ist nicht möglich.',
	'UploadOnlyImages'			=> 'Erlaube nur das Hochladen von Bildern:',
	'UploadOnlyImagesInfo'		=> 'Nur Bilder können hochgeladen werden.',
	'UploadMaxFilesize'			=> 'Maximale Dateigröße:',
	'UploadMaxFilesizeInfo'		=> 'Maximale Größe pro Datei. Die Dateigröße wird nur durch die PHP-Konfiguration beschränkt, wenn 0 als Wert eingestellt wird.',
	'UploadQuota'				=> 'Maximales Kontingent für Dateianhänge:',
	'UploadQuotaInfo'			=> 'Maximaler für Dateianhänge verfügbarer Speicherplatz für das gesamte Wiki; <code>0</code> bedeutet unbegrenzt.',
	'UploadQuotaUser'			=> 'Speicherkontingent pro Benutzer:',
	'UploadQuotaUserInfo'		=> 'Beschränkung des Speicherkontingentes, der von einem Benutzer hochgeladen werden kann, wobei <code>0</code> unbegrenzt ist.',
	'CheckMimetype'				=> 'Dateianhänge prüfen:',
	'CheckMimetypeInfo'			=> 'Manchen Browsern kann ein fehlerhafter MIME-Typ für hochgeladene Dateien vorgetäuscht werden. Diese Option stellt sicher, dass Dateien, die dieses Verhalten provozieren könnten, abgewiesen werden.',
	'TranslitFileName'			=> 'Translitieren der Dateinamen:',
	'TranslitFileNameInfo'		=> 'Soweit dies möglich ist und keine Unicode-Zeichen erforderlich sind, wird dringend empfohlen, nur alphanumerische Zeichen zu akzeptieren.',

	'Thumbnails'				=> 'Vorschaubilder',
	'CreateThumbnail'			=> 'Vorschaubild erstellen:',
	'CreateThumbnailInfo'		=> 'Vorschaubild in allen möglichen Fällen erstellen.',
	'MaxThumbWidth'				=> 'Maximale Breite der Vorschaubilder in Pixeln:',
	'MaxThumbWidthInfo'			=> 'Ein Vorschaubild wird nicht breiter sein als der hier eingestellte Wert.',
	'MinThumbFilesize'			=> 'Minimale Vorschaubild-Dateigröße:',
	'MinThumbFilesizeInfo'		=> 'Erstellt keine Vorschaubilder bei Bildern, die kleiner sind als dieser Wert.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Liste der entfernten Seiten, Revisionen und Dateien.
									Um die Seiten, Revisionen und Dateien endgültig aus der Datenbank zu löschen oder wiederherzustellen klicke in der entsprechenden Zeile auf <em>Entfernen</em> oder <em>Wiederherstellen</em>.
									(Achtung, es ist keine Löschbestätigung erforderlich!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Wörter, die automatisch in deinem Wiki zensiert werden.',
	'FilterSettingsUpdated'		=> 'Die Einstellungen für den Spamfilter wurden aktualisiert',

	'WordCensoringSection'		=> 'Wort zensieren',
	'SPAMFilter'				=> 'Spamfilter:',
	'SPAMFilterInfo'			=> 'Spamfilter aktivieren',
	'WordList'					=> 'Wortliste:',
	'WordListInfo'				=> 'Wort oder Phrase <code>fragment</code> welches auf die schwarze Liste gesetzt wird (eins pro Zeile)',

	// Log module
	'LogFilterTip'				=> 'Filtere Ereignisse nach Kriterien:',
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

	// Massemail module
	'MassemailInfo'				=> 'Hier kannst du eine Nachricht per E-Mail an alle Mitglieder des Wikis oder einer spezifischen Gruppe senden, <strong>sofern diese den Erhalt von Informationen per E-Mail zugelassen haben</strong>. Dazu wird eine E-Mail an die festgelegte administrative E-Mail-Adresse verschickt und alle Empfänger als Blindkopie (BCC) hinzugefügt. Standardmäßig wird pro 20 Empfänger eine solche E-Mail versandt; bei mehreren Empfängern werden mehrere E-Mails versandt. Bitte habe nach dem Absenden Geduld, wenn du eine Nachricht an eine große Gruppe schickst und breche den Vorgang nicht ab. Bei einer Massen-E-Mail ist es normal, dass ihr Versand länger dauert. Du wirst benachrichtigt, sobald der Vorgang abgeschlossen wurde.',
	'LogMassemail'				=> 'Rundmail gesendet %1 an Gruppe / Nutzer ',
	'MassemailSend'				=> 'Rundmail gesendet',

	'NoEmailMessage'			=> 'Du musst eine Nachricht angeben.',
	'NoEmailSubject'			=> 'Du musst einen Betreff für die Nachricht angeben.',
	'NoEmailRecipient'			=> 'Du musst mindestens einen Benutzer oder eine Benutzergruppe angeben.',

	'MassemailSection'			=> 'Rundmail',
	'MessageSubject'			=> 'Betreff',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Deine Nachricht',
	'YourMessageInfo'			=> 'Bitte beachte, dass du nur reinen Text verwenden kannst. Alle Auszeichnungen werden vor dem Versand entfernt.',

	'NoUser'					=> 'kein Benutzer',
	'NoUserGroup'				=> 'keine Benutzergruppe',

	'SendToGroup'				=> 'Sende an Nutzergruppe',
	'SendToUser'				=> 'Sende an Nutzer',
	'SendToUserInfo'			=> 'Es sendet nur Nachrichten an diejenigen Benutzer, die es Administratoren erlaubt haben, ihnen Informationen per E-Mail zu senden. Diese Option ist in den Benutzereinstellungen unter Benachrichtigungen verfügbar.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'System-Mitteilung aktualisiert',

	'SysMsgSection'				=> 'System-Mitteilung',
	'SysMsg'					=> 'System-Mitteilung',
	'SysMsgInfo'				=> 'Dein Text hier',

	'SysMsgType'				=> 'Typ',
	'SysMsgTypeInfo'			=> 'Mitteilungtyp (CSS).',
	'EnableSysMsg'				=> 'Aktiviere System-Mitteilung',
	'EnableSysMsgInfo'			=> 'Zeige System-Mitteilung.',

	// User approval module
	'ApproveNotExists'			=> 'Bitte wähle mindestens einen Benutzer über die Schaltfläche Setzen aus.',

	'LogUserApproved'			=> 'Benutzer ##%1## zugelassen',
	'LogUserBlocked'			=> 'Benutzer ##%1## gesperrt',
	'LogUserDeleted'			=> 'Benutzer ##%1## aus der Datenbank entfernt',
	'LogUserCreated'			=> 'Neuer Benutzer ##%1## erstellt',
	'LogUserUpdated'			=> 'Benutzer ##%1## aktualisiert',

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
									'Der Root-Cluster hat keinen Einfluss auf die Sicherung globaler Dateien und die Sicherung von Cache-Dateien (die Auswahl wird immer vollständig gespeichert).<br>' .
									'<br>' .
									'<strong>Achtung</strong>: Um den Verlust von Informationen aus der Datenbank bei der Angabe des Root-Clusters zu vermeiden, werden die Tabellen aus dieser Sicherung nicht umstrukturiert, ' .
									'auch wenn nur die Tabellenstruktur gesichert wird, ohne die Daten zu speichern. ' .
									'Um eine vollständige Konvertierung der Tabellen in das Backup-Format vorzunehmen, muss eine <em> vollständigen Datenbanksicherung (Struktur und Daten) ohne Angabe des Clusters</em> gemacht werden.',
	'BackupCompleted'			=> 'Sichern und Archivieren abgeschlossen.<br>' .
									'Die Sicherungspaketdateien wurden im Unterverzeichnis %1 abgelegt.<br>' .
									'Um es herunterzuladen verwende FTP (verändere die Verzeichnisstruktur und die Dateinamen beim Kopieren nicht).<br>' .
									'Um eine Sicherungskopie wiederherzustellen oder ein Paket zu entfernen, gehe zu <a href="%2">Datenbank wiederherstellen</a>.',
	'LogSavedBackup'			=> 'Sicherungskopie gespeichert ##%1##',
	'Backup'					=> 'Datensicherung',

	// DB Restore module
	'RestoreInfo'				=> 'Du kannst jedes der gefundenen Sicherungspakete wiederherstellen oder vom Server entfernen.',
	'ConfirmDbRestore'			=> 'Möchtest du die Datensicherung %1 wiederherstellen?',
	'ConfirmDbRestoreInfo'		=> 'Bitte warte, dies kann einige Minuten benötigen.',
	'RestoreWrongVersion'		=> 'WackoWiki Version stimmt nicht überein!',
	'DirectoryNotExecutable'	=> 'Das Verzeichnis %1 ist nicht ausführbar.',
	'BackupDelete'				=> 'Willst du die Datensicherung %1 wirklich entfernen?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Zusätzliche Otionen zur Daten-Wiederherstellung',
	'RestoreOptionsInfo'		=> '* Vor dem Wiederherstellen der <strong>Cluster-Sicherung</strong>, ' .
									'werden die Zieltabellen nicht gelöscht (um den Verlust von Informationen aus den Clustern, die nicht gesichert wurden, zu verhindern).. ' .
									'Somit werden während des Wiederherstellungsvorgangs doppelte Datensätze auftreten. ' .
									'Im normalen Modus werden alle Dateien durch die Datensätze ersetzt (mit SQL-Anweisung <code>REPLACE</code>), ' .
									'aber wenn dieses Kontrollkästchen aktiviert ist, werden alle Duplikate übersprungen (die aktuellen Werte der Datensätze werden beibehalten), ' .
									'und nur die Datensätze mit neuem Schlüssel werden in die Tabelle aufgenommen (SQL-Anweisung <code>INSERT IGNORE</code>).<br>' .
									'<strong>Hinweis</strong>: Wenn eine vollständige Sicherung der Site wiederherstellt wird, hat diese Option keine Zweck.<br>' .
									'<br>' .
									'** Wenn die Sicherung die Benutzerdateien (global und perpage, Cache-Dateien usw.) enthält, ' .
									'ersetzen sie im normalen Modus die vorhandenen Dateien mit denselben Namen und werden beim Wiederherstellen in demselben Verzeichnis abgelegt. ' .
									'Mit dieser Option kann man die aktuellen Kopien der Dateien speichern und aus einer Sicherung nur neue Dateien (auf dem Server nicht vorhandene) wiederherstellen.',
	'IgnoreDuplicatedKeysNr'	=> 'Ignoriere doppelte Tabellenschlüssel (nicht ersetzen)',
	'IgnoreSameFiles'			=> 'Ignoriere die gleichen Dateien (nicht überschreiben)',
	'NoBackupsAvailable'		=> 'Keien Datensicherung verfügbar.',
	'BackupEntireSite'			=> 'Gesamte Website',
	'BackupRestored'			=> 'Die Datensicherung wurde wiederhergestellt, ein zusammenfassender Bericht ist angefügt. Um die Dateien zu dieser Datensicherung zu löschen, klicke bitte',
	'BackupRemoved'				=> 'Die ausgewählte Datensicherung wurde erfolgreich entfernt.',
	'LogRemovedBackup'			=> 'Sicherungskopie gelöscht ##%1##',

	'RestoreStarted'			=> 'Beginne mit Wiederherstellung der Datensicherung',
	'RestoreParameters'			=> 'Verwendete Parameter',
	'IgnoreDuplicatedKeys'		=> 'Ignoriere doppelte Schlüssel',
	'IgnoreDuplicatedFiles'		=> 'Ignoriere doppelte Dateien',
	'SavedCluster'				=> 'Gespeicherter Cluster',
	'DataProtection'			=> 'Datenschutz - %1 weggelassen',
	'AssumeDropTable'			=> 'Nehme %1',
	'RestoreTableStructure'		=> 'Wiederherstellen der Struktur der Tabelle',
	'RunSqlQueries'				=> 'Führe SQL-Anweisungen aus',
	'CompletedSqlQueries'		=> 'Abgeschlossen. Verarbeitete Anweisungen',
	'NoTableStructure'			=> 'Die Struktur der Tabellen wurde nicht gespeichert - überspringen',
	'RestoreRecords'			=> 'Tabelleninhalte wiederherstellen',
	'ProcessTablesDump'			=> 'Tabellen-Dump entpacken und verarbeiten',
	'Instruction'				=> 'Anweisung',
	'RestoredRecords'			=> 'Datensätze',
	'RecordsRestoreDone'		=> 'Abgeschlossen. Gesamtzahl der Datensätze',
	'SkippedRecords'			=> 'Daten nicht gespeichert - übersprungen',
	'RestoringFiles'			=> 'Dateien wiederherstellen',
	'DecompressAndStore'		=> 'Entpake und speichere Inhalte der Verzeichnisse',
	'HomonymicFiles'			=> 'gleichnamige Dateien',
	'RestoreSkip'				=> 'überspringen',
	'RestoreReplace'			=> 'ersetzen',
	'RestoreFile'				=> 'Datei',
	'Restored'					=> 'wiederhergestellt',
	'Skipped'					=> 'übersprungen',
	'FileRestoreDone'			=> 'Abgeschlossen. Gesamtzahl der Dateien',
	'FilesAll'					=> 'alle',
	'SkipFiles'					=> 'Dateien nicht gespeichert - übersprungen',
	'RestoreDone'				=> 'WIEDERHERSTELLUNG ABGESCHLOSSEN',

	'BackupCreationDate'		=> 'Erstellungsdatum',
	'BackupPackageContents'		=> 'Der Inhalt des Pakets',
	'BackupRestore'				=> 'Wiederherstellen',
	'BackupRemove'				=> 'Entfernen',
	'RestoreYes'				=> 'Ja',
	'RestoreNo'					=> 'Nein',
	'LogDbRestored'				=> 'Sicherung ##%1## der Datenbank wiederhergestellt.',

	// User module
	'UsersInfo'					=> 'Hier können Benutzerinformationen und bestimmte spezifische Optionen geändert werden.',

	'UsersAdded'				=> 'Benutzer hinzugefügt',
	'UsersDeleteInfo'			=> '[Informationen zur Löschung eines Benutzers hier...]',
	'EditButton'				=> 'Bearbeiten',
	'UsersAddNew'				=> 'Füge einen neuen Benutzer hinzu',
	'UsersDelete'				=> 'Bist du dir sicher das du den Benutzer %1 entfernen willst?',
	'UsersDeleted'				=> 'Der Benutzer %1 wurde aus der Datenbank entfernt.',
	'UsersRename'				=> 'Benutzer %1 umbenennen zu',
	'UsersRenameInfo'			=> '* Hinweise: Die Änderung wirkt sich auf alle Seiten aus, die diesem Benutzer zugeordnet sind.',
	'UsersUpdated'				=> 'Benutzer erfolgreich aktualisiert.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Anmeldung',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'Keine Benutzer, welche diese Kriterien erfüllen.',

	'UserAccountNotify'			=> 'Benutzer benachrichtigen',
	'UserNotifySignup'			=> 'den Benutzer über das neue Konto informieren',
	'UserVerifyEmail'			=> 'setze E-Mail-Bestätigungstoken und füge einen Link zur E-Mail-Verifizierung hinzu',
	'UserReVerifyEmail'			=> 'Sende E-Mail-Bestätigungstoken erneut',

	// Groups module
	'GroupsInfo'				=> 'Benutzergruppen verwalten. Hier können Gruppen erstellt, bearbeitet und gelöscht werden. Darüber hinaus lässt sich ein Gruppenleiter auswählen, der Status der Gruppe ändern und der Gruppenname und die Beschreibung festlegen.',

	'LogMembersUpdated'			=> 'Gruppenmitglieder aktualisiert',
	'LogMemberAdded'			=> 'Gruppenmitglied ##%1## zu Gruppe ##%2## hinzugefügt',
	'LogMemberRemoved'			=> 'Gruppenmitglied ##%1## aus Gruppe ##%2## entfernt',
	'LogGroupCreated'			=> 'Neue Gruppe ##%1## erstellt',
	'LogGroupRenamed'			=> 'Gruppe ##%1## zu ##%2## umbenannt',
	'LogGroupRemoved'			=> 'Gruppe ##%1## entfernt',

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
	'GroupsDeleted'				=> 'Die Gruppe %1 und alle Mitglieder wurde aus der Datenbank gelöscht.',
	'GroupsAdd'					=> 'Eine neue Gruppe hinzufügen',
	'GroupsRename'				=> 'Gruppe %1 umbenennen zu',
	'GroupsRenameInfo'			=> '* Hinweis: Die Änderung wirkt sich auf alle Seiten aus, die dieser Gruppe zugeordnet sind.',
	'GroupsDelete'				=> 'Bist du dir sicher das du die Gruppe %1 entfernen möchtest?',
	'GroupsDeleteInfo'			=> '* Hinweis: Die Änderung wirkt sich auf alle Mitglieder aus, die dieser Gruppe zugeordnet sind.',
	'GroupsIsSystem'			=> 'Die Gruppe %1 gehört zum System und kann nicht entfernt werden.',
	'GroupsStoreButton'			=> 'Speichere Gruppen',
	'GroupsEditInfo'			=> 'Zum Bearbeiten der Gruppen-Liste wähle das Optionsfeld',

	'GroupAddMember'			=> 'Mitglied hinzufügen',
	'GroupRemoveMember'			=> 'Mitglied entfernen',
	'GroupAddNew'				=> 'Gruppe hinzufügen',
	'GroupEdit'					=> 'Gruppe bearbeiten',
	'GroupDelete'				=> 'Gruppe entfernen',

	'MembersAddNew'				=> 'Neues Mitglied hinzufügen',
	'MembersAdded'				=> 'Neues Mitglied der Gruppe erfolgreich hinzugefügt.',
	'MembersRemove'				=> 'Bist du dir sicher das du das Mitglied %1 enfernen möchtest?',
	'MembersRemoved'			=> 'Das Mitglied wurde aus der Gruppe entfernt.',

	// Statistics module
	'DbStatSection'				=> 'Datenbank-Statistik',
	'DbTable'					=> 'Tabelle',
	'DbRecords'					=> 'Datensätze',
	'DbSize'					=> 'Größe',
	'DbIndex'					=> 'Index',
	'DbOverhead'				=> 'Überhang',
	'DbTotal'					=> 'Gesamt',

	'FileStatSection'			=> 'Dateisystem-Statistik',
	'FileFolder'				=> 'Ordner',
	'FileFiles'					=> 'Dateien',
	'FileSize'					=> 'Größe',
	'FileTotal'					=> 'Gesamt',

	// Sysinfo module
	'SysInfo'					=> 'Versionsinformationen:',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Werte',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Letzte Aktualisierung',
	'ServerOS'					=> 'Betriebssystem',
	'ServerName'				=> 'Servername',
	'WebServer'					=> 'Webserver',
	'HttpProtocol'				=> 'HTTP-Protokoll',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'SQL Modes Global',
	'SqlModesSession'			=> 'SQL Modes Session',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Speicher',
	'UploadFilesizeMax'			=> 'Upload max filesize',
	'PostMaxSize'				=> 'Post max size',
	'MaxExecutionTime'			=> 'Max execution time',
	'SessionPath'				=> 'Session path',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip compression',
	'PhpExtensions'				=> 'PHP Erweiterungen',
	'ApacheModules'				=> 'Apache Module',

	// DB repair module
	'DbRepairSection'			=> 'Datenbank reparieren',
	'DbRepair'					=> 'Datenbank reparieren',
	'DbRepairInfo'				=> 'Dieses Skript kann automatisch nach einigen häufigen Datenbankproblemen suchen und sie reparieren. Das Reparieren kann eine Weile dauern, seien Sie also bitte geduldig.',

	'DbOptimizeRepairSection'	=> 'Datenbank reparieren und optimieren',
	'DbOptimizeRepair'			=> 'Datenbank reparieren und optimieren',
	'DbOptimizeRepairInfo'		=> 'Dieses Skript kann auch versuchen, die Datenbank zu optimieren. Dies verbessert die Leistung in einigen Situationen. Das Reparieren und Optimieren der Datenbank kann sehr lange dauern und die Datenbank wird während der Optimierung gesperrt.',

	'TableOk'					=> 'Die Tabelle %1 ist in Ordnung.',
	'TableNotOk'				=> 'Die %1-Tabelle ist nicht in Ordnung. Es meldet den folgenden Fehler: %2. Dieses Skript wird versuchen, diese Tabelle zu reparieren&hellip;',
	'TableRepaired'				=> 'Die %1-Tabelle wurde erfolgreich repariert.',
	'TableRepairFailed'			=> 'Die %1-Tabelle konnte nicht repariert werden. <br>Fehler: %2',
	'TableAlreadyOptimized'		=> 'Die Tabelle %1 ist bereits optimiert.',
	'TableOptimized'			=> 'Die %1-Tabelle wurde erfolgreich optimiert.',
	'TableOptimizeFailed'		=> 'Fehler beim Optimieren der %1-Tabelle. <br>Fehler: %2',
	'TableNotRepaired'			=> 'Einige Datenbankprobleme konnten nicht repariert werden.',
	'RepairsComplete'			=> 'Reparaturen abgeschlossen',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Inkonsistenzen anzeigen und beheben, verwaiste Datensätze löschen oder einem neuen Benutzer / Wert zuweisen.',
	'Inconsistencies'			=> 'Inkonsistenzen',
	'CheckDatabase'				=> 'Datenbank',
	'CheckDatabaseInfo'			=> 'Prüft auf Datensatzinkonsistenzen in der Datenbank.',
	'CheckFiles'				=> 'Dateien',
	'CheckFilesInfo'			=> 'Sucht nach nicht mehr verwendeten Dateien, Dateien ohne Referenz in der Dateitabelle.',
	'Records'					=> 'Datensätze',
	'InconsistenciesNone'		=> 'Keine Daten-Inkonsistenzen gefunden.',
	'InconsistenciesDone'		=> 'Dateninkonsistenzen behoben.',
	'InconsistenciesRemoved'	=> 'Inkonsistenzen beseitigt',
	'Check'						=> 'Prüfen',
	'Solve'						=> 'Beheben',

	// Bad Behavior module
	'BbInfo'					=> 'Erkennt und blockiert unerwünschte Webzugriffe, verweigert automatisierten Spambots den Zugriff.<br>Für weitere Informationen besuche die %1 Webseite.',
	'BbEnable'					=> 'Bad Behavior aktivieren',
	'BbEnableInfo'				=> 'Alle anderen Einstellungen können im Konfigurationsordner geändert werden. %1.',
	'BbStats'					=> 'Bad Behavior hat in den letzten 7 Tagen %1 Zugriffsversuche blockiert.',

	'BbSummary'					=> 'Zusammenfassung',
	'BbLog'						=> 'Log',
	'BbSettings'				=> 'Einstellungen',
	'BbWhitelist'				=> 'Whitelist',

	// --> Log
	'BbHits'					=> 'Zugriffe',
	'BbRecordsFiltered'			=> 'Anzeige von %1 von %2 Datensätzen, gefiltert nach',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Gesperrt',
	'BbPermitted'				=> 'Zugelassen',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Alle %1-Datensätze anzeigen',
	'BbShow'					=> 'Anzeigen',
	'BbIpDateStatus'			=> 'IP/Datum/Status',
	'BbHeaders'					=> 'Headers',
	'BbEntity'					=> 'Entität',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Einstellungen gespeichert.',
	'BbWhitelistHint'			=> 'Unsachgemäßes Whitelisting wird zu Spam führen oder dazu, dass Bad Behavior nicht mehr funktioniert! NICHT WEISSLISTEN, es sei denn, es besteht eine 100%ige Sicherheit, dass es erforderlich ist.',
	'BbIpAddress'				=> 'IP-Adresse',
	'BbIpAddressInfo'			=> 'IP-Adressbereiche oder Adressbereiche im CIDR-Format, welche auf die Whitelist gesetzt werden sollen (einer pro Zeile).',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL-Fragmente, die mit dem / nach dem Hostnamen Ihrer Website beginnen (eines pro Zeile).',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'User-Agent Zeichenketten, die auf die Whitelist gesetzt werden sollen (eine pro Zeile).',

	// --> Settings
	'BbSettingsUpdated'			=> 'Updated Bad Behavior settings',
	'BbLogRequest'				=> 'HTTP-Request protokollieren',
	'BbLogVerbose'				=> 'Umfassend',
	'BbLogNormal'				=> 'Normal (empfohlen)',
	'BbLogOff'					=> 'Nicht protokollieren (nicht empfohlen)',
	'BbSecurity'				=> 'Sicherheit',
	'BbStrict'					=> 'Strenge Prüfung',
	'BbStrictInfo'				=> 'Blockiert mehr Spam, kann aber einige Nutzer aussperren.',
	'BbOffsiteForms'			=> 'Formularpostings von anderen Websites zulassen',
	'BbOffsiteFormsInfo'		=> 'erforderlich für OpenID; erhöht den Spam-Eingang.',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Um die http:BL-Funktionen von Bad Behavior nutzen zu können, benötigt man einen %1',
	'BbHttpblKey'				=> 'http:BL Zugangsschlüssel',
	'BbHttpblThreat'			=> 'Minimale Bedrohungsstufe (25 wird empfohlen)',
	'BbHttpblMaxage'			=> 'Maximales Alter der Daten (30 wird empfohlen)',
	'BbReverseProxy'			=> 'Reverse-Proxy/Load-Balancer',
	'BbReverseProxyInfo'		=> 'Aktivieren die Option Reverse-Proxy, wenn Bad Behavior hinter einem Reverse-Proxy, Load-Balancer, HTTP-Accelerator, Content-Cache oder einer ähnlichen Technologie verwendet wird.<br>' .
									'Wenn eine Reihe von zwei oder mehr Reverse-Proxies zwischen dem Server und dem öffentlichen Internet sind, müssen <em>alle</em> IP-Adressbereiche (im CIDR-Format) aller Ihrer Proxy-Server, Load-Balancer usw. angeben. Andernfalls kann Bad Behavior möglicherweise nicht in Stande sein, die wahre IP-Adresse des Clients zu bestimmen.<br>' .
									'Zusätzlich müssen Ihre Reverse-Proxy-Server die IP-Adresse des Internet-Clients, von dem sie die Anfrage erhalten haben, in dem HTTP-Header angeben. Wenn Sie keinen Header angeben, wird %1 verwendet. Die meisten Proxy-Server unterstützen bereits X-Forwarded-For und Sie müssen dann nur noch sicherstellen, dass es auf Ihren Proxy-Servern aktiviert ist.  Einige andere häufig verwendete Header-Namen sind unter anderem %2 und %3.',
	'BbReverseProxyEnable'		=> 'Reverse-Proxy aktivieren',
	'BbReverseProxyHeader'		=> 'Kopfzeile mit der IP-Adresse des Internet-Clients',
	'BbReverseProxyAddresses'	=> 'IP-Adressbereiche oder Adressbereiche im CIDR-Format für die Proxy-Server (eine pro Zeile)',

];
