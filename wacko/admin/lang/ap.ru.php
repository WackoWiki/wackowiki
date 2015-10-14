<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = array(
	'ApTestText' => 'Ap Test Text',
	'MainNote' => 'Внимание: перед проведением технических административных мероприятий <span class="underline">настоятельно</span> рекомендуется закрыть доступ к сайту!',

	// Admin panel
	'Authorization'				=> 'Авторизация',
	'AuthorizationTip'			=> 'Пожалуйста, укажите административный пароль (убедитесь также, что cookies в вашем браузере разрешены).',
	'NoRecoceryPassword'		=> 'Административный пароль не задан!',
	'NoRecoceryPasswordTip'		=> 'Внимание: отсутствие административного пароля представляет угрозу для безопасности! Укажите пароль в файле настроек и запустите программу повторно.',

	'LogFilterTip'				=> 'Filter events by criteria',
	'LogLevel'					=> 'Level',
	'LogLevelNotLower'			=> 'not less than',
	'LogLevelNotHigher'			=> 'not higher than',
	'LogLevelEqual'				=> 'equal',
	'LogNoMatch'				=> 'No events that meet the criteria',
	'LogDate'					=> 'Date',
	'LogEvent'					=> 'Event',
	'LogUsername'				=> 'Username',

	'PurgeSessions'				=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the session table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// log
	'LogLevel1'					=> 'Критический',
	'LogLevel2'					=> 'Наивысший',
	'LogLevel3'					=> 'Высокий',
	'LogLevel4'					=> 'Средний',
	'LogLevel5'					=> 'Низкий',
	'LogLevel6'					=> 'Минимальный',
	'LogLevel7'					=> 'Отладочный',

	// Massemail
	'SendToGroup'				=> 'Send to group',

	// db restore module
	'ConfirmDbRestore'			=> 'Do you want to restore backup',
	'ConfirmDbRestoreInfo'		=> 'Please wait this can take some minutes.',
	'BackupDelete'				=> 'Are you sure you want to remove backup',
	'BackupDeleteInfo'			=> '',

);

?>