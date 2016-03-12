<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = array(
	'ApTestText'			=> 'Ap Test Text',
	'MainNote'				=> 'Note: Before the administration of technical activities strongly are encouraged to block access to the site!',

	'Authorization'			=> 'Autorizaci�n',
	'AuthorizationTip'		=> 'Por favor ingrese la contrase�a del administrador (aseg�rese que su navegador permita cookies).',
	'NoRecoceryPassword'	=> 'Contrase�a administrativa no especificada!',
	'NoRecoceryPasswordTip'	=> 'Observaci�n: La falta de una contrase�a administrativa es un riesgo de seguridad! Ingrese la contrase�a en el archivo de configuraci�n y vuelva a ejecutar el programa.',

	'LogFilterTip'			=> 'Filtrar eventos por criterios',
	'LogLevel'				=> 'Nivel',
	'LogLevelNotLower'		=> 'no menos que',
	'LogLevelNotHigher'		=> 'no m�s que',
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
	'LogLevel1'					=> 'cr�tico',
	'LogLevel2'					=> 'm�s alto',
	'LogLevel3'					=> 'alto',
	'LogLevel4'					=> 'medio',
	'LogLevel5'					=> 'bajo',
	'LogLevel6'					=> 'm�s bajo',
	'LogLevel7'					=> 'depuraci�n',

	// Massemail
	'SendToGroup'				=> 'Send to group',

	// DB Backup module
	'BackupStructure'			=> 'Structure',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Folder',
	'BackupTable'				=> 'Table',
	'BackupCluster'				=> 'Cluster',
	'BackupFiles'				=> 'Files',
	'BackupSettings'			=> 'Specify the desired scheme of Backup.<br />'.
									'The root cluster does not affect the global files backup and cache files backup (being chosen they are always saved in full).<br />'.
									'<br />'.
									'<span class="underline">Attention</span>: To avoid loss of information from the database when specifying the root cluster the tables from this backup will not be restructured, '.
									'same when backing up only table structure without saving the data. '.
									'To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and contents) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Backing up and archiving completed.<br />'.
									'Backup package files stored in the "(date)YYYYMMDD_(time)HHMMSS" named sub-directory of <code>files/backup</code> directory.<br />'.
									'To download it use FTP (maintain the directory structure and file names when copying).<br />'.
									'To restore a backup copy or remove a package, go to <a href="?mode=db_restore">Restore database</a>.',

	// DB Restore module
	'ConfirmDbRestore'			=> 'Do you want to restore backup',
	'ConfirmDbRestoreInfo'		=> 'Please wait this can take some minutes.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'BackupDelete'				=> 'Are you sure you want to remove backup',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Additional restore options',
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
	'NoBackupsAvailable'		=> 'No backups available.',
	'BackupEntireSite'			=> 'Entire site',
	'BackupRestored'			=> 'The backup is restored, a summary report is attached below. To delete this backup package, click',
	'BackupRemoved'				=> 'The selected backup has been successfully removed.',

	// User module
	'UsersAdded'				=> 'User added',
	'UsersDeleteInfo'			=> '[User delete Info here..]',

	'UserEnabled'				=> 'Habilitado',
	'UsersAddNew'				=> 'Nuevo usuario',
	'UsersDelete'				=> 'Est� seguro que desea eliminar al usuario ',
	'UsersDeleted'				=> 'Usuario eliminado de la base de datos.',
	'UsersRename'				=> 'Renombrar usuario',
	'UsersRenameInfo'			=> '* Observaci�n: El cambio afectar� a todas las p�ginas asignadas a este usuario.',
	'UsersRenamed'				=> 'Usuario renombrado con �xito.',

	// Groups module
	'GroupsMembersFor'			=> 'Miembros del grupo',
	'GroupsDescription'			=> 'Descripci�n',
	'GroupsModerator'			=> 'Moderador',
	'GroupsOpen'				=> 'Abierto',
	'GroupsActive'				=> 'Activo',
	'GroupsTip'					=> 'Presione para editar el grupo',
	'GroupsUpdated'				=> 'Grupos actualizados',
	'GroupsAlreadyExists'		=> 'El grupo ya existe.',
	'GroupsAdded'				=> 'Grupo agregado con �xito.',
	'GroupsRenamed'				=> 'Grupo renombrado exitosamente.',
	'GroupsDeleted'				=> 'Grupo eliminado de la base de datos y de todas las p�ginas.',
	'GroupsAdd'					=> 'Agregar grupo nuevo',
	'GroupsRename'				=> 'Renombrar el grupo',
	'GroupsRenameInfo'			=> '* Observaci�n: El cambio afectar� a todas las p�ginas con el grupo asignado.',
	'GroupsDelete'				=> 'Est� seguro que desea eliminar el grupo ',
	'GroupsDeleteInfo'			=> '* Observaci�n: El cambio afectar� a todas los miembros del grupo.',
	'GroupsStoreButton'			=> 'Guardar Grupos',
	'GroupsSaveButton'			=> 'GUardar',
	'GroupsCancelButton'		=> 'Cancelar',
	'GroupsAddButton'			=> 'Agregar',
	'GroupsEditButton'			=> 'Editar',
	'GroupsRemoveButton'		=> 'Remover',
	'GroupsEditInfo'			=> 'Marque el bot�n de radio para editar la lista de grupos.',

	'MembersAddNew'				=> 'Miembro nuevo',
	'MembersAdded'				=> 'Added new member to the group successfully.',
	'MembersRemove'				=> 'Est� seguro que desea remover el miembro ',
	'MembersRemoved'			=> 'Miembro eliminado del grupo.',
	'MembersDeleteInfo'			=> '* Observaci�n: El cambio afectar� a todos los miembros asignados al grupo.',

);

?>