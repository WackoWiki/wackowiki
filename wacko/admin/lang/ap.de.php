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

	// MENU
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

	'LogFilterTip'				=> 'Filtere Ereignisse nach Kriterien',
	'LogLevel'					=> 'Stufe',
	'LogLevelNotLower'			=> 'nicht weniger als',
	'LogLevelNotHigher'			=> 'nicht h�her als',
	'LogLevelEqual'				=> 'gleich',
	'LogNoMatch'				=> 'Keine Ereignisse, die die Kriterien erf�llen',
	'LogDate'					=> 'Datum',
	'LogEvent'					=> 'Ereignis',
	'LogUsername'				=> 'Benutzername',

	'PurgeSessions'				=> 'entfernen',
	'PurgeSessionsTip'			=> 'Entferne alle Sitzungen',
	'PurgeSessionsConfirm'		=> 'Bist du dir sicher, da� du alle Sitzungen entfernen willst? Dies wird alle Nuzer abmelden.',
	'PurgeSessionsExplain'		=> 'Entferne alle Sitzungen. Dies wird alle Nuzer abmelden in dem es die auth_token Tabelle leert.',
	'PurgeSessionsDone'			=> 'Sitzungen erfolgreich enfernt.',

	// Basic settings
	'ConfigBasicSection'		=> 'Grundlegende Parameter',
	'SiteName'					=> 'Name der Seite',
	'SiteNameInfo'				=> 'Der Titel der Seite im HTML-Kopf, erscheint im Browser Titel, Theme Header, bei Email Benachrichtigung, etc.',
	'SiteDesc'					=> 'Beschreibung der Seite',
	'SiteDescInfo'				=> 'Supplement to the title of the site that appears in the pages header to explain in a few words, what this site is about.',
	'AdminName'					=> 'Administrator der Seite',
	'AdminNameInfo'				=> 'User name, which is responsible for overall support of the site. This name is not used to determine access rights, but it is desirable to conform to the name of the chief administrator of the site.',
	'LanguageSection'			=> 'Sprache',
	'DefaultLanguage'			=> 'Default Sprache',
	'DefaultLanguageInfo'		=> 'Specifies the language for mapping unregistered guests, as well as the locale settings and the rules of transliteration of addresses of pages.',
	'MultiLanguage'				=> 'Multilanguage Unterst�tzung',
	'MultiLanguageInfo'			=> 'Include a choice of language on the page by page basis.',
	'AllowedLanguages'			=> 'Allowed languages',
	'AllowedLanguagesInfo'		=> 'It is recomended to select only the set of languages you want to use, other wise all languages are selected.',
	'CommentSection'			=> 'Kommentare',
	'AllowComment'				=> 'Erlaube Kommentare',
	'AllowCommentInfo'			=> 'Enable comments for guest or registered users only or disable them on the entire site.',
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
	'TOC_Panel'					=> 'Table of contents panel',
	'TOC_PanelInfo'				=> 'The default display table of contents panel of a page (may need support in the templates).',
	'SectionsPanel'				=> 'Sections panel',
	'SectionsPanelInfo'			=> 'By default display the panel of adjacent pages (requires support in the templates).',
	'DisplayingSections'		=> 'Displaying sections',
	'DisplayingSectionsInfo'	=> 'When the previous options, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>) or both, and other (<em>tree</em>).',
	'MenuItems'					=> 'Menu items',
	'MenuItemsInfo'				=> 'Default number of shown menu items (may need support in the templates).',
	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Enable feeds',
	'EnableFeedsInfo'			=> 'Turns on or off RSS feeds for the entire wiki.',
	'XML_Sitemap'				=> 'XML Sitemap',
	'XML_SitemapInfo'			=> 'Create an XML file called "sitemap-wackowiki.xml" inside the xml folder. Generate a Sitemaps XML format compatible XML file. You might want to change the path to output it in your root folder as that is one of the requirements i.e. that the XML file is in the root folder.',
	'XML_SitemapTime'			=> 'XML Sitemap generation time',
	'XML_SitemapTimeInfo'		=> 'Generate a Sitemaps only once in this number of days, zero means on every page change.',
	'DiffModeSection'			=> 'Diff Modes',
	'DefaultDiffModeSetting'	=> 'Default diff mode',
	'DefaultDiffModeSettingInfo'=> 'Preselected diff mode.',
	'AllowedDiffMode'			=> 'Allowed Diff modes',
	'AllowedDiffModeInfo'		=> 'It is recomended to select only the set of diff modes you want to use, other wise all diff modes are selected.',
	'MiscellaneousSection'		=> 'Miscellaneous',
	'EditSummary'				=> 'Edit summary',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Minor edit',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'ReviewSettings'			=> 'Review',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',
	'Autosubscribe'				=> 'Autosubscribe',
	'AutosubscribeInfo'			=> 'Automatically sign a new page in the owner\'s notice of its changes.',
	'PublishAnonymously'		=> 'Allow anonymous publishing',
	'PublishAnonymouslyInfo'	=> 'Allow users to published preferably anonymously (to hide the name).',
	'DefaultRenameRedirect'		=> 'When renaming put redirection',
	'DefaultRenameRedirectInfo'	=> 'By default, propose to redirect the old address pereimenuemoy page.',
	'StoreDeletedPages'			=> 'Keep deleted pages',
	'StoreDeletedPagesInfo'		=> 'When you delete a page (the comment) put her in a special section where she had some time (below) will be available for viewing and recovery.',
	'KeepDeletedTime'			=> 'Storage time of deleted pages',
	'KeepDeletedTimeInfo'		=> 'The period in days. It makes sense only if the previous option. Zero indicates the eternal possession (in this case the administrator can clear the "cart" manually).',
	'PagesPurgeTime'			=> 'Storage time of page revisions',
	'PagesPurgeTimeInfo'		=> 'Automatically delete the older edition of the number of days. If you enter zero, the old edition will not be removed.',
	'EnableReferrers'			=> 'Enable Referrers',
	'EnableReferrersInfo'		=> 'Allows to store and show external referrers.',
	'ReferrersPurgeTime'		=> 'Storage time of referrers',
	'ReferrersPurgeTimeInfo'	=> 'Keep history of invoking external pages no more than this number of days. Zero means the perpetual possession, but to actively visit the site this could lead to overcrowding in the database.',
	'AttachmentHandler'			=> 'Enable attachments handler',
	'AttachmentHandlerInfo'		=> 'Allows to show the attachments handler.',
	'SearchEngineVisibility'	=> 'Block search engines (Search Engine Visibility)',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site, It is up to search engines to honor this request.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Aussehen der Webseite �ndern',
	'LogoOff'					=> 'Aus',
	'LogoOnly'					=> 'Logo',
	'LogoAndTitle'				=> 'Logo und Titel',

	'AppearanceSettingsUpdated'	=> 'Aussehen der Webseite wurde aktualisiert.',
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


	// Resync settings
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
	'WikiLinks'					=> 'Wiki-Links',
	'WikiLinksInfo'				=> 'F�hrt ein Re-Rendering f�r alle Intrasite-Links durch und stellt den Inhalt der Tabelle <code> page_link </code> und <code> file_link </code> im Falle einer Besch�digung oder Verlagerung wieder her (dies kann einige Zeit in Anspruch nehmen).',

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

	// log
	'LogLevel1'					=> 'kritisch',
	'LogLevel2'					=> 'h�chste',
	'LogLevel3'					=> 'hoch',
	'LogLevel4'					=> 'mittel',
	'LogLevel5'					=> 'niedrig',
	'LogLevel6'					=> 'unterste',
	'LogLevel7'					=> 'debugging',

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
									'<strong>Achtung</strong>: Um den Verlust von Informationen aus der Datenbank bei der Angabe des Root-Clusters zu vermeiden, werden die Tabellen aus dieser Sicherung nicht umstrukturiert, '.
									'auch wenn nur die Tabellenstruktur gesichert wird, ohne die Daten zu speichern. '.
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
	'RestoreOptionsInfo'		=> '* Vor dem Wiederherstellen der <strong>Cluster-Sicherung</strong>, '.
									'werden die Zieltabellen nicht zerst�rt (um den Verlust von Informationen aus den Clustern, die nicht gesichert wurden, zu verhindern).. '.
									'Somit werden w�hrend des Wiederherstellungsvorgangs doppelte Datens�tze auftreten. '.
									'Im normalen Modus werden alle Dateien durch die Datens�tze ersetzt (mit SQL-Anweisung <code>REPLACE</code>), '.
									'aber wenn dieses Kontrollk�stchen aktiviert ist, werden alle Duplikate �bersprungen (die aktuellen Werte der Datens�tze werden beibehalten), '.
									'und nur die Datens�tze mit neuem Schl�ssel werden in die Tabelle aufgenommen (SQL-Anweisung <code>INSERT IGNORE</code>).<br>' .
									'<strong>Hinweis</strong>: Wenn Sie eine vollst�ndige Sicherung der Site wiederherstellen, hat diese Option keinen Zweck.<br>' .
									'<br>' .
									'** Wenn die Sicherung die Benutzerdateien (global und perpage, Cache-Dateien usw.) enth�lt, '.
									'ersetzen sie im normalen Modus die vorhandenen Dateien mit denselben Namen und werden beim Wiederherstellen in demselben Verzeichnis abgelegt. '.
									'Mit dieser Option kann man die aktuellen Kopien der Dateien speichern und aus einer Sicherung nur neue Dateien (fehlt auf dem Server) wiederherstellen.',
	'IgnoreDuplicatedKeys'		=> 'Ignoriere doppelte Tabellenschl�ssel (nicht ersetzen)',
	'IgnoreSameFiles'			=> 'Ignoriere die gleichen Dateien (nicht �berschreiben)',
	'NoBackupsAvailable'		=> 'Keien Datensicherung verf�gbar.',
	'BackupEntireSite'			=> 'Gesamte Website',
	'BackupRestored'			=> 'Die Datensicherung wurde wiederhergestellt, ein zusammenfassender Bericht ist angef�gt. Um die Dateien zu dieser Datensicherung zu l�schen, klicke bitte',
	'BackupRemoved'				=> 'Die ausgew�hlte Datensicherung wurde erfolgreich entfernt.',
	'LogRemovedBackup'			=> 'Sicherungskopie gel�scht ##%1##',

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

];

?>
