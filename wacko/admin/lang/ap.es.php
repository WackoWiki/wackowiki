<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = array(
	'ApTestText' => 'Ap Test Text',
	'MainNote' => 'Note: Before the administration of technical activities strongly are encouraged to block access to the site!',

	'Authorization'			=> 'Autorización',
	'AuthorizationTip'		=> 'Por favor ingrese la contraseña del administrador (asegúrese que su navegador permita cookies).',
	'NoRecoceryPassword'	=> 'Contraseña administrativa no especificada!',
	'NoRecoceryPasswordTip'	=> 'Observación: La falta de una contraseña administrativa es un riesgo de seguridad! Ingrese la contraseña en el archivo de configuración y vuelva a ejecutar el programa.',

	'LogFilterTip'			=> 'Filtrar eventos por criterios',
	'LogLevel'				=> 'Nivel',
	'LogLevelNotLower'		=> 'no menos que',
	'LogLevelNotHigher'		=> 'no más que',
	'LogLevelEqual'			=> 'igual',
	'LogNoMatch'			=> 'No hay coincidencias',
	'LogDate'				=> 'Fecha',
	'LogEvent'				=> 'Evento',
	'LogUsername'			=> 'Nombre de usuario',

	'PurgeSessions'				=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the session table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// log
	'LogLevel1'					=> 'crítico',
	'LogLevel2'					=> 'más alto',
	'LogLevel3'					=> 'alto',
	'LogLevel4'					=> 'medio',
	'LogLevel5'					=> 'bajo',
	'LogLevel6'					=> 'más bajo',
	'LogLevel7'					=> 'depuración',

	// Massemail
	'SendToGroup'				=> 'Send to group',

	// db restore module
	'ConfirmDbRestore'			=> 'Do you want to restore backup',
	'ConfirmDbRestoreInfo'		=> 'Please wait this can take some minutes.',
	'BackupDelete'				=> 'Are you sure you want to remove backup',
	'BackupDeleteInfo'			=> '',

);

?>