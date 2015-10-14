<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = array(
	'ApTestText' => 'Ap Test Text',
	'MainNote' => 'Hinweis: Before the administration of technical activities strongly are encouraged to block access to the site!',

	'Authorization'				=> 'Autorisation',
	'AuthorizationTip'			=> 'Bitte gib das Administratorkennwort ein (und stelle sicher, dass Cookies von Deinem Browser akzeptiert werden).',
	'NoRecoceryPassword'		=> 'Das Administrator-Passwort wurde nicht gesetzt!',
	'NoRecoceryPasswordTip'		=> 'Hinweis: Das Fehlen eines Administrator-Passworts ist eine Bedrohung für die Sicherheit! Gib das Passwort in der Konfigurationsdatei an und starte das Programm erneut.',

	'LogFilterTip'				=> 'Filtere Ereignisse nach Kriterien',
	'LogLevel'					=> 'Stufe',
	'LogLevelNotLower'			=> 'nicht weniger als',
	'LogLevelNotHigher'			=> 'nicht höher als',
	'LogLevelEqual'				=> 'gleich',
	'LogNoMatch'				=> 'Keine Ereignisse, die die Kriterien erfüllen',
	'LogDate'					=> 'Datum',
	'LogEvent'					=> 'Ereignis',
	'LogUsername'				=> 'Benutzername',

	'PurgeSessions'				=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the session table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// log
	'LogLevel1'					=> 'kritisch',
	'LogLevel2'					=> 'höchste',
	'LogLevel3'					=> 'hoch',
	'LogLevel4'					=> 'mittel',
	'LogLevel5'					=> 'niedrig',
	'LogLevel6'					=> 'unterste',
	'LogLevel7'					=> 'debugging',

	// Massemail
	'SendToGroup'				=> 'Send to group',

	// db restore module
	'ConfirmDbRestore'			=> 'Do you want to restore backup',
	'ConfirmDbRestoreInfo'		=> 'Please wait this can take some minutes.',
	'BackupDelete'				=> 'Are you sure you want to remove backup',
	'BackupDeleteInfo'			=> '',
);

?>