<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = array(
	'ApTestText'				=> 'Admin Panel Dummy Test Text',
	'MainNote'					=> 'Hinweis: Before the administration of technical activities strongly are encouraged to block access to the site!',

	// Admin panel
	'Authorization'				=> 'Autorisation',
	'AuthorizationTip'			=> 'Bitte gib das Administratorkennwort ein (und stelle sicher, dass Cookies von Deinem Browser akzeptiert werden).',
	'NoRecoceryPassword'		=> 'Das Administrator-Passwort wurde nicht gesetzt!',
	'NoRecoceryPasswordTip'		=> 'Hinweis: Das Fehlen eines Administrator-Passworts ist eine Bedrohung f�r die Sicherheit! Gib das Passwort in der Konfigurationsdatei an und starte das Programm erneut.',

	'LogFilterTip'				=> 'Filtere Ereignisse nach Kriterien',
	'LogLevel'					=> 'Stufe',
	'LogLevelNotLower'			=> 'nicht weniger als',
	'LogLevelNotHigher'			=> 'nicht h�her als',
	'LogLevelEqual'				=> 'gleich',
	'LogNoMatch'				=> 'Keine Ereignisse, die die Kriterien erf�llen',
	'LogDate'					=> 'Datum',
	'LogEvent'					=> 'Ereignis',
	'LogUsername'				=> 'Benutzername',

	'PurgeSessions'				=> 'Entferne alle Sitzungen',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the session table.',
	'PurgeSessionsDone'			=> 'Sitzungen erfolgreich enfernt.',

	// log
	'LogLevel1'					=> 'kritisch',
	'LogLevel2'					=> 'h�chste',
	'LogLevel3'					=> 'hoch',
	'LogLevel4'					=> 'mittel',
	'LogLevel5'					=> 'niedrig',
	'LogLevel6'					=> 'unterste',
	'LogLevel7'					=> 'debugging',

	// Massemail
	'SendToGroup'				=> 'Send to group',
	'SendToUser'				=> 'Send to user',

	// User approval module
	'UserApproveInfo'			=> 'Approve new users before they are able to login to the site.',
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
	'BackupSettings'			=> 'W�hle das gew�nsche Datensicherungs-Schema.<br />'.
									'The root cluster does not affect the global files backup and cache files backup (being chosen they are always saved in full).<br />'.
									'<br />'.
									'<span class="underline">Attention</span>: To avoid loss of information from the database when specifying the root cluster the tables from this backup will not be restructured, '.
									'same when backing up only table structure without saving the data. '.
									'To make a complete conversion of the tables to the backup format you must make eine <em> vollst�ndigen Datenbanksicherung (Struktur und Daten) ohne Angabe des Clusters</em>.',
	'BackupCompleted'			=> 'Sichern und Archivieren abgeschlossen.<br />'.
									'Backup package files stored in the "(date)YYYYMMDD_(time)HHMMSS" benannten Unterverzeichnis unter <code>files/backup</code> directory.<br />'.
									'Um es herunterzuladen verwende FTP (ver�ndere die Verzeichnisstruktur und die Dateinamen beim Kopieren nicht).<br />'.
									'Um eine Sicherungskopie wiederherzustellen oder ein Paket zu entfernen, gehe zu <a href="?mode=db_restore">Restore database</a>.',

	// DB Restore module
	'RestoreInfo'				=> 'Du kannst jedes gefundene Sicherungsspaket wiederherstellen oder vom Server entfernen.',
	'ConfirmDbRestore'			=> 'M�chtest du die Datensicherung wiederherstellen',
	'ConfirmDbRestoreInfo'		=> 'Bitte warte dies kann einige Minuten ben�tigen.',
	'RestoreWrongVersion'		=> 'WackoWiki Version stimmt nicht �berein!',
	'BackupDelete'				=> 'Willst du die Datensicherung wirklich entfernen',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Zus�tzliche Otionen zur Daten-Wiederherstellung',
	'RestoreOptionsInfo'		=> '* Before restoring the <span class="underline">cluster backup</span>, '.
									'the target tables are not destroyed (to prevent loss of information from the clusters that have not been backed up). '.
									'Thus, during the recovery process duplicate records will occur. '.
									'In normal mode, all of them will be replaced by the records form backup (using SQL-instruction <code>REPLACE</code>), '.
									'but if this checkbox is checked, all duplicates are skipped (the current values of records will be kept), '.
									'and only the records with new keys are added to the table (SQL-instruction <code>INSERT IGNORE</code>).<br />'.
									'<span class="underline">Notice</span>: When restore complete backup of the site, this option has no value.<br />'.
									'<br />'.
									'** If the backup contains the user files (global and perpage, cache files, etc.), '.
									'in normal mode they replace the existing files with the same names and are placed in the same directory when being restored. '.
									'This option allows you to save the current copies of the files and restore from a backup only new files (missing on the server).',
	'IgnoreDuplicatedKeys'		=> 'Ignore duplicated table keys (not replace)',
	'IgnoreSameFiles'			=> 'Ignore the same files (not overwrite)',
	'NoBackupsAvailable'		=> 'Keien Datensicherung verf�gbar.',
	'BackupEntireSite'			=> 'Gesamte Website',
	'BackupRestored'			=> 'Die Datensicherung wurde wiederhergestellt, ein zusammenfassender Bericht ist angef�gt. Um die Dateien zu dieser Datensicherung zu l�schen, klicke bitte',
	'BackupRemoved'				=> 'Die ausgew�hlte Datensicherung wurde erfolgreich entfernt.',

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

);

?>