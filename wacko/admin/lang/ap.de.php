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
	'Enabled'					=> 'aktiviert',
	'Disabled'					=> 'deaktiviert',
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
	'lock'		=> [
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

	// Email settings
	'EmaiSettingsInfo'			=> 'Diese Informationen werden ben�tigt, um E-Mails an die Benutzer zu senden. Stelle bitte sicher, dass die angegebene Adresse g�ltig ist; abgewiesene oder nicht zustellbare Nachrichten werden an diese Adresse geschickt. Falls dein Webhosting-Provider keinen PHP-basierten E-Mail-Dienst anbietet, k�nnen die Nachrichten auch direkt �ber SMTP versendet werden. Dies erfordert die Angabe der Adresse eines geeigneten Servers (frage falls n�tig deinen Provider). Falls der Server eine Authentifizierung erfordert (und nur, wenn dies der Fall ist), gib den Benutzernamen und das Passwort ein und w�hle eine Authentifizierungsmethode aus.',

	'EmailFunctionName'			=> 'Email function name',
	'EmailFunctionNameInfo'		=> 'The email function used to send mails through PHP.',

	'EnableEmail'				=> 'Enable emails',
	'EnableEmailInfo'			=> 'Enabling emails',

	'SendTestEmail'				=> 'Send a test email',
	'SendTestEmailInfo'			=> 'This will send a test email to the address defined in your account.',
	'TestEmailSubject'			=> 'WackoWiki is correctly configured to send emails',
	'TestEmailBody'				=> 'If you received this email, WackoWiki is correctly configured to send emails.',
	'TestEmailMessage'			=> 'The test email has been sent.<br />If you don\'t receive it, please check your emails configuration.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Connection mode for SMTP',
	'SmtpConnectionModeInfo'	=> 'Only used if a username/password is set, ask your provider if you are unsure which method to use.',
	'SmtpPassword'				=> 'SMTP password',
	'SmtpPasswordInfo'			=> 'Only enter a password if your SMTP server requires it.<br /><em><strong>Warning:</strong> This password will be stored as plain text in the database, visible to everybody who can access your database or who can view this configuration page.</em>',
	'SmtpPort'					=> 'SMTP server port',
	'SmtpPortInfo'				=> 'Only change this if you know your SMTP server is on a different port. <br />(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'SMTP server address',
	'SmtpSettings'				=> 'SMTP settings',
	'SmtpUsername'				=> 'SMTP username',
	'SmtpUsernameInfo'			=> 'Only enter a username if your SMTP server requires it.',

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
	'BackupSettings'			=> 'W�hle das gew�nsche Datensicherungs-Schema.<br />' .
									'Der Stammcluster wirkt sich nicht auf die Sicherung der globalen Dateisicherung und der Cache-Dateien aus (die Auswahl wird immer vollst�ndig gespeichert).<br />' .
									'<br />' .
									'<span class="underline">Achtung</span>: Um den Verlust von Informationen aus der Datenbank bei der Angabe des Root-Clusters zu vermeiden, werden die Tabellen aus dieser Sicherung nicht umstrukturiert, '.
									'auch wenn nur die Tabellenstruktur gesichert wird, ohne die Daten zu speichern. '.
									'Um eine vollst�ndige Konvertierung der Tabellen in das Backup-Format vorzunehmen, muss eine <em> vollst�ndigen Datenbanksicherung (Struktur und Daten) ohne Angabe des Clusters</em> gemacht werden.',
	'BackupCompleted'			=> 'Sichern und Archivieren abgeschlossen.<br />' .
									'Die Sicherungspaketdateien wurden im "(date)YYYYMMDD_(time)HHMMSS" benannten Unterverzeichnis unter <code>files/backup</code> abgelegt.<br />' .
									'Um es herunterzuladen verwende FTP (ver�ndere die Verzeichnisstruktur und die Dateinamen beim Kopieren nicht).<br />' .
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
	'RestoreOptionsInfo'		=> '* Vor dem Wiederherstellen der <span class="underline">Cluster-Sicherung</span>, '.
									'werden die Zieltabellen nicht zerst�rt (um den Verlust von Informationen aus den Clustern, die nicht gesichert wurden, zu verhindern).. '.
									'Somit werden w�hrend des Wiederherstellungsvorgangs doppelte Datens�tze auftreten. '.
									'Im normalen Modus werden alle Dateien durch die Datens�tze ersetzt (mit SQL-Anweisung <code>REPLACE</code>), '.
									'aber wenn dieses Kontrollk�stchen aktiviert ist, werden alle Duplikate �bersprungen (die aktuellen Werte der Datens�tze werden beibehalten), '.
									'und nur die Datens�tze mit neuem Schl�ssel werden in die Tabelle aufgenommen (SQL-Anweisung <code>INSERT IGNORE</code>).<br />' .
									'<span class="underline">Hinweis</span>: Wenn Sie eine vollst�ndige Sicherung der Site wiederherstellen, hat diese Option keinen Zweck.<br />' .
									'<br />' .
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
	'UsersDeleteInfo'			=> '[User delete Info here..]',
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