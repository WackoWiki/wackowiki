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
	'Enabled'					=> 'aktiviert',
	'Disabled'					=> 'deaktiviert',
	'On'						=> 'on',
	'Off'						=> 'off',
	'Mandatory'					=> 'zwingend',
	'Admin'						=> 'Admin',

	// MENU
	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Allgemein',
		'title'		=> 'Grundeinstellungen',
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
		'title'		=> 'Sicherheits-Untersysteme-Einstellungen',
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
	'lock'		=> [
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
		'title'		=> 'Rundmail',
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
	'LogLevelNotHigher'			=> 'nicht höher als',
	'LogLevelEqual'				=> 'gleich',
	'LogNoMatch'				=> 'Keine Ereignisse, die die Kriterien erfüllen',
	'LogDate'					=> 'Datum',
	'LogEvent'					=> 'Ereignis',
	'LogUsername'				=> 'Benutzername',

	'PurgeSessions'				=> 'entfernen',
	'PurgeSessionsTip'			=> 'Entferne alle Sitzungen',
	'PurgeSessionsConfirm'		=> 'Bist du dir sicher, daß du alle Sitzungen entfernen willst? Dies wird alle Nuzer abmelden.',
	'PurgeSessionsExplain'		=> 'Entferne alle Sitzungen. Dies wird alle Nuzer abmelden in dem es die auth_token Tabelle leert.',
	'PurgeSessionsDone'			=> 'Sitzungen erfolgreich enfernt.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Diese Informationen werden benötigt, um E-Mails an die Benutzer zu senden. Stelle bitte sicher, dass die angegebene Adresse gültig ist; abgewiesene oder nicht zustellbare Nachrichten werden an diese Adresse geschickt. Falls dein Webhosting-Provider keinen PHP-basierten E-Mail-Dienst anbietet, können die Nachrichten auch direkt über SMTP versendet werden. Dies erfordert die Angabe der Adresse eines geeigneten Servers (frage falls nötig deinen Provider). Falls der Server eine Authentifizierung erfordert (und nur, wenn dies der Fall ist), gib den Benutzernamen und das Passwort ein und wähle eine Authentifizierungsmethode aus.',

	'EmailFunctionName'			=> 'Name der E-Mail-Funktion',
	'EmailFunctionNameInfo'		=> 'Die PHP-Funktion, die genutzt wird, um E-Mails zu versenden.',
	'UseSmtpInfo'				=> 'Wähle <code>SMTP</code> aus, wenn du E-Mails über einen SMTP-Server senden möchtest (oder musst), anstatt die PHP-eigene Mail-Funktion zu nutzen.',

	'EnableEmail'				=> 'Aktiviere E-Mail',
	'EnableEmailInfo'			=> 'Aktiviere E-Mail-Funktionalität',

	'FromEmailName'				=> 'From Name',
	'FromEmailNameInfo'			=> 'The sender name, part of <code>From:</code> header in emails for all the email-notification sent from the site.',
	'NoReplyEmail'				=> 'No-reply address',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all your email-notifications sent from the site.',
	'AdminEmail'				=> 'Email of the site owner',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.',

	'SendTestEmail'				=> 'Test-Mail senden',
	'SendTestEmailInfo'			=> 'Sendet eine Test-Mail an die in deinem Benutzerkonto hinterlegte Adresse.',
	'TestEmailSubject'			=> 'Dein Wiki ist für den E-Mail-Versand richtig konfiguriert',
	'TestEmailBody'				=> 'Wenn du diese Nachricht erhältst, ist deine Wiki richtig für den E-Mail-Versand konfiguriert.',
	'TestEmailMessage'			=> 'Die Test-Mail wurde gesendet.<br />Falls du sie nicht erhalten solltest, prüfe bitte deine E-Mail-Konfiguration.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Authentifizierungsmethode für SMTP',
	'SmtpConnectionModeInfo'	=> 'Nur benötigt, wenn ein Benutzername/Passwort eingegeben ist. Frage deinen Webhosting-Provider, falls du nicht sicher bist, welche Methode du wählen sollst.',
	'SmtpPassword'				=> 'SMTP-Passwort',
	'SmtpPasswordInfo'			=> 'Gib nur ein Passwort ein, wenn dein SMTP-Server dies erfordert. <em><strong>WARNUNG:</strong> Dieses Passwort wird im Klartext in der Datenbank gespeichert und ist daher für jeden einsehbar, der Zugriff auf die Datenbank oder diese Konfigurationsseite hat.</em>',
	'SmtpPort'					=> 'SMTP-Server-Port',
	'SmtpPortInfo'				=> 'Ändere diese Einstellung nur, wenn du weißt, dass dein SMTP-Server einen anderen Port nutzt. <br />(default: <code>tls</code> auf Port 587 (oder möglicherweise 25) und <code>ssl</code> auf Port 465)',
	'SmtpServer'				=> 'SMTP-Server-Adresse',
	'SmtpServerInfo'			=> 'Beachte, dass du das Protokoll angeben musst, das dein Server verwendet. Wird SSL verwendet, musst du <code>ssl://mail.example.com</code> angeben.',
	'SmtpSettings'				=> 'SMTP-Einstellungen',
	'SmtpUsername'				=> 'SMTP-Benutzername',
	'SmtpUsernameInfo'			=> 'Gib nur einen Benutzernamen ein, wenn dein SMTP-Server dies erfordert.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Hier kannst du die Einstellungen für Dateianhänge und verknüpfte Spezialkategorien vornehmen.',
	'FileUploads'				=> 'File uploads',
	'UploadMaxFilesize'			=> 'Maximale Dateigröße',
	'UploadMaxFilesizeInfo'		=> 'Maximale Größe pro Datei. Die Dateigröße wird nur durch die PHP-Konfiguration beschränkt, wenn 0 als Wert eingestellt wird.',
	'UploadQuota'				=> 'Maximales Kontingent für Dateianhänge',
	'UploadQuotaInfo'			=> 'Maximaler für Dateianhänge verfügbarer Speicherplatz für das gesamte Wiki; 0 bedeutet unbegrenzt.',
	'UploadQuotaUser'			=> 'Storage quota per user',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with 0 being unlimited.',
	'CheckMimetype'				=> 'Dateianhänge prüfen',
	'CheckMimetypeInfo'			=> 'Manchen Browsern kann ein fehlerhafter MIME-Typ für hochgeladene Dateien vorgetäuscht werden. Diese Option stellt sicher, dass Dateien, die dieses Verhalten provozieren könnten, abgewiesen werden.',

	'CreateThumbnail'			=> 'Vorschaubild erstellen',
	'CreateThumbnailInfo'		=> 'Vorschaubild in allen möglichen Fällen erstellen.',
	'MaxThumbWidth'				=> 'Maximale Breite der Vorschaubilder in Pixeln',
	'MaxThumbWidthInfo'			=> 'Ein Vorschaubild wird nicht breiter sein als der hier eingestellte Wert.',
	'MinThumbFilesize'			=> 'Minimale Vorschaubild-Dateigröße',
	'MinThumbFilesizeInfo'		=> 'Erstellt keine Vorschaubilder bei Bildern, die kleiner sind als dieser Wert.',

	// log
	'LogLevel1'					=> 'kritisch',
	'LogLevel2'					=> 'höchste',
	'LogLevel3'					=> 'hoch',
	'LogLevel4'					=> 'mittel',
	'LogLevel5'					=> 'niedrig',
	'LogLevel6'					=> 'unterste',
	'LogLevel7'					=> 'debugging',

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
	'BackupSettings'			=> 'Wähle das gewünsche Datensicherungs-Schema.<br />' .
									'Der Stammcluster wirkt sich nicht auf die Sicherung der globalen Dateisicherung und der Cache-Dateien aus (die Auswahl wird immer vollständig gespeichert).<br />' .
									'<br />' .
									'<span class="underline">Achtung</span>: Um den Verlust von Informationen aus der Datenbank bei der Angabe des Root-Clusters zu vermeiden, werden die Tabellen aus dieser Sicherung nicht umstrukturiert, '.
									'auch wenn nur die Tabellenstruktur gesichert wird, ohne die Daten zu speichern. '.
									'Um eine vollständige Konvertierung der Tabellen in das Backup-Format vorzunehmen, muss eine <em> vollständigen Datenbanksicherung (Struktur und Daten) ohne Angabe des Clusters</em> gemacht werden.',
	'BackupCompleted'			=> 'Sichern und Archivieren abgeschlossen.<br />' .
									'Die Sicherungspaketdateien wurden im "(date)YYYYMMDD_(time)HHMMSS" benannten Unterverzeichnis unter <code>files/backup</code> abgelegt.<br />' .
									'Um es herunterzuladen verwende FTP (verändere die Verzeichnisstruktur und die Dateinamen beim Kopieren nicht).<br />' .
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
	'RestoreOptionsInfo'		=> '* Vor dem Wiederherstellen der <span class="underline">Cluster-Sicherung</span>, '.
									'werden die Zieltabellen nicht zerstört (um den Verlust von Informationen aus den Clustern, die nicht gesichert wurden, zu verhindern).. '.
									'Somit werden während des Wiederherstellungsvorgangs doppelte Datensätze auftreten. '.
									'Im normalen Modus werden alle Dateien durch die Datensätze ersetzt (mit SQL-Anweisung <code>REPLACE</code>), '.
									'aber wenn dieses Kontrollkästchen aktiviert ist, werden alle Duplikate übersprungen (die aktuellen Werte der Datensätze werden beibehalten), '.
									'und nur die Datensätze mit neuem Schlüssel werden in die Tabelle aufgenommen (SQL-Anweisung <code>INSERT IGNORE</code>).<br />' .
									'<span class="underline">Hinweis</span>: Wenn Sie eine vollständige Sicherung der Site wiederherstellen, hat diese Option keinen Zweck.<br />' .
									'<br />' .
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
	'UsersDeleteInfo'			=> '[User delete Info here..]',
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