<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'				=> 'Note: Before the administration of technical activities strongly are encouraged to block access to the site!',

	'CategoryArray'		=> [
		'basics'		=> 'Basic functions',
		'preferences'	=> 'Preferences',
		'content'		=> 'Content',
		'users'			=> 'Users',
		'maintenance'	=> 'Maintenance',
		'messages'		=> 'Messages',
		'extension'		=> 'Extension',
		'database'		=> 'Database',
	],

	// Admin panel
	'AdminPanel'				=> 'Panel de Control de Administración',
	'RecoveryMode'				=> 'Modo de recuperación',
	'Authorization'				=> 'Autorización',
	'AuthorizationTip'			=> 'Por favor ingrese la contraseña del administrador (asegúrese que su navegador permita cookies).',
	'NoRecoceryPassword'		=> 'Contraseña administrativa no especificada!',
	'NoRecoceryPasswordTip'		=> 'Observación: La falta de una contraseña administrativa es un riesgo de seguridad! Ingrese la contraseña en el archivo de configuración y vuelva a ejecutar el programa.',

	'ErrorLoadingModule'		=> 'Error loading admin module %1: does not exists.',

	'FormSave'					=> 'Save',
	'FormReset'					=> 'Reset',
	'FormUpdate'				=> 'Update',

	'ApHomePage'				=> 'Home Page',
	'ApHomePageTip'				=> 'open the home page, you do not quit administration',
	'ApLogOut'					=> 'Log out',
	'ApLogOutTip'				=> 'quit system administration',

	'TimeLeft'					=> 'Time left:  %1 minutes',
	'ApVersion'					=> 'version',

	'SiteOpen'					=> 'open',
	'SiteOpened'				=> 'site opened',
	'SiteOpenedTip'				=> 'The site is open',
	'SiteClose'					=> 'close',
	'SiteClosed'				=> 'site closed',
	'SiteClosedTip'				=> 'The site is closed',

	// Generic
	'Cancel'					=> 'Cancel',
	'Add'						=> 'Add',
	'Edit'						=> 'Edit',
	'Remove'					=> 'Remove',
	'Enabled'					=> 'Habilitar',
	'Disabled'					=> 'Deshabilitar',
	'On'						=> 'on',
	'Off'						=> 'off',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'Admin',

	// MENU
	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Basic',
		'title'		=> 'Basic parameters',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Apariencia',
		'title'		=> 'Appearance settings',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Email',
		'title'		=> 'Email settings',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filter',
		'title'		=> 'Filter settings',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'Formatting options',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Notifications',
		'title'		=> 'Notifications settings',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Pages',
		'title'		=> 'Pages and site parameters',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permissions',
		'title'		=> 'Permissions settings',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Security',
		'title'		=> 'Security subsystems settings',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'System',
		'title'		=> 'System options',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Upload',
		'title'		=> 'Attachment settings',
	],

	// Categories module
	'content_categories'		=> [
		'name'		=> 'Categories',
		'title'		=> 'Manage categories',
	],

	// Comments module
	'content_comments'		=> [
		'name'		=> 'Comments',
		'title'		=> 'Manage comments',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Deleted',
		'title'		=> 'Newly deleted content',
	],

	// Files module
	'content_files'		=> [
		'name'		=> 'Files',
		'title'		=> 'Manage uploaded files',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Add, edit or remove default menu items',
	],

	// Pages module
	'content_pages'		=> [
		'name'		=> 'Pages',
		'title'		=> 'Manage pages',
	],

	// Polls module
	'content_polls'		=> [
		'name'		=> 'Polls',
		'title'		=> 'Editing, start and stop polls',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Backup',
		'title'		=> 'Backing up data',
	],

	// DB Convert module
	'db_convert'		=> [
		'name'		=> 'Convert',
		'title'		=> 'Converting Tables or Columns',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Repair',
		'title'		=> 'Repair and Optimize Database',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Restore',
		'title'		=> 'Restoring backup data',
	],

	// Dashboard module
	'lock'		=> [
		'name'		=> 'Main Menu',
		'title'		=> 'WackoWiki Administration',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inconsistencies',
		'title'		=> 'Fixing Data Inconsistencies',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Data Synchronization',
		'title'		=> 'Synchronizing data',
	],

	// Transliterate module
	'maint_transliterate'		=> [
		'name'		=> 'Transliterate',
		'title'		=> 'Update the supertag in the database records',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Mass email',
		'title'		=> 'Mass email',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'System message',
		'title'		=> 'System messages',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'System Info',
		'title'		=> 'System Informations',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System log',
		'title'		=> 'Log of system events',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistics',
		'title'		=> 'Show statistics',
	],

	// Bad Behavior module
	'badbehavior'		=> [
		'name'		=> 'Bad Behavior',
		'title'		=> 'Bad Behavior',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Approve',
		'title'		=> 'User registration approval',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Groups',
		'title'		=> 'Group management',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Users',
		'title'		=> 'User management',
	],

	'LogFilterTip'				=> 'Filtrar eventos por criterios',
	'LogLevel'					=> 'Nivel',
	'LogLevelNotLower'			=> 'no menos que',
	'LogLevelNotHigher'			=> 'no más que',
	'LogLevelEqual'				=> 'igual',
	'LogNoMatch'				=> 'No hay coincidencias',
	'LogDate'					=> 'Fecha',
	'LogEvent'					=> 'Evento',
	'LogUsername'				=> 'Nombre de usuario',

	'PurgeSessions'				=> 'purge',
	'PurgeSessionsTip'			=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the auth_token table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// Basic settings


	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Control default display settings for your site.',
	'LogoOff'					=> 'off',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo and title',


	// Email settings
	'EmaiSettingsInfo'			=> 'Esta información se usa cuando el Sitio envía emails a sus usuarios. Por favor verifique que la dirección de email ingresada sea válida, cualquier rebote se reenviará a esa dirección. Si su host no provee un servicio de email nativo (utilizable por PHP), entonces use directamente SMTP. Esto requiere la dirección de un servidor apropiado (pregúntele a su ISP de ser necesario). Si (si, y solo si) el servidor requiere autentificación complete el usuario y contraseña. Por favor observe que solo se ofrece autentificación básica, otro tipo de implementación no es posible actualmente.',

	'EmailFunctionName'			=> 'Nombre de la función email',
	'EmailFunctionNameInfo'		=> 'La función empleada por PHP para enviar emails.',
	'UseSmtpInfo'				=> 'Elija <code>SMTP</code> si quiere o necesita enviar emails mediante un servidor específico en lugar de la función de email local.',

	'EnableEmail'				=> 'Habilitar envío de emails',
	'EnableEmailInfo'			=> 'Enabling emails',

	'FromEmailName'				=> 'From Name',
	'FromEmailNameInfo'			=> 'The sender name, part of <code>From:</code> header in emails for all the email-notification sent from the site.',
	'NoReplyEmail'				=> 'No-reply address',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all your email-notifications sent from the site.',
	'AdminEmail'				=> 'Email of the site owner',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.',

	'SendTestEmail'				=> 'Enviar un correo electrónico de prueba',
	'SendTestEmailInfo'			=> 'Esto enviará un correo electrónico de prueba a la dirección definida en su cuenta.',
	'TestEmailSubject'			=> 'Your Wiki is correctly configured to send emails',
	'TestEmailBody'				=> 'If you received this email, your Wiki is correctly configured to send emails.',
	'TestEmailMessage'			=> 'El correo electrónico de prueba ha sido enviado.<br />Si no lo recibes, por favor revisa tú configuración de mensajes de correo electrónico.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Método de autentificación para SMTP',
	'SmtpConnectionModeInfo'	=> 'Solo usado si se configura usuario/contraseña, pregúntele a su ISP si no está seguro de cual método usar.',
	'SmtpPassword'				=> 'Contraseña SMTP',
	'SmtpPasswordInfo'			=> 'Introduzca una contraseña solo si su servidor SMTP lo requiere.<br /><em><strong>ADVERTENCIA:</strong> Esta contraseña será guardada como texto plano en la base de datos y será visible para cualquiera que tenga acceso a la misma o que pueda ver esta página de configuración.</em>',
	'SmtpPort'					=> 'Puerto servidor SMTP',
	'SmtpPortInfo'				=> 'Cámbielo solo si sabe que su servidor SMTP está en un puerto diferente. <br />(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Dirección servidor SMTP',
	'SmtpServerInfo'			=> 'Ten en cuenta que debes proporcionar el protocolo que utiliza tu servidor. Si estás utilizando SSL, tiene que ser <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> 'Configuración SMTP',
	'SmtpUsername'				=> 'Usuario SMTP',
	'SmtpUsernameInfo'			=> 'Solo introduzca un usuario si su servidor SMTP lo requiere.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Aquí puedes configurar los principales parámetros para archivos adjuntos y las categorías especiales asociadas.',
	'FileUploads'				=> 'File uploads',
	'UploadMaxFilesize'			=> 'Tamaño máximo',
	'UploadMaxFilesizeInfo'		=> 'Tamaño máximo de cada archivo. Si este valor es 0, el tamaño del archivo para subir sólo estará limitado por la configuración de PHP.',
	'UploadQuota'				=> 'Máximo total para adjuntos',
	'UploadQuotaInfo'			=> 'Máximo en disco disponible para adjuntos en todo el sitio, 0 significa ilimitado.',
	'UploadQuotaUser'			=> 'Storage quota per user',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with 0 being unlimited.',
	'CheckMimetype'				=> 'Comprobar archivos adjuntos',
	'CheckMimetypeInfo'			=> 'Algunos navegadores pueden ser engañados para que asuman un mimetype de archivos subibles incorrecto. Esta opción previene que tales archivos que puedan causar eso sean rechazados.',

	'CreateThumbnail'			=> 'Crear vista en miniatura',
	'CreateThumbnailInfo'		=> 'Crear vista en miniatura siempre que sea posible.',
	'MaxThumbWidth'				=> 'Ancho máximo de la vista en miniatura en píxeles',
	'MaxThumbWidthInfo'			=> 'La mini-imagen generada no excederá este ancho.',
	'MinThumbFilesize'			=> 'Tamaño mínimo para vista en miniatura',
	'MinThumbFilesizeInfo'		=> 'No crear vista en miniatura para imágenes más pequeñas que esto.',

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
	'SendToUser'				=> 'Send to user',

	// User approval module
	'UserApproveInfo'			=> 'Approve new users before they are able to login to the site.',
	'Approve'					=> 'Approve',
	'Deny'						=> 'Deny',
	'Pending'					=> 'Pending',
	'Approved'					=> 'Approved',
	'Denied'					=> 'Denied',

	// DB Backup module
	'BackupStructure'			=> 'Structure',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Folder',
	'BackupTable'				=> 'Table',
	'BackupCluster'				=> 'Cluster',
	'BackupFiles'				=> 'Files',
	'BackupSettings'			=> 'Specify the desired scheme of Backup.<br />' .
									'The root cluster does not affect the global files backup and cache files backup (being chosen they are always saved in full).<br />' .
									'<br />' .
									'<span class="underline">Attention</span>: To avoid loss of information from the database when specifying the root cluster the tables from this backup will not be restructured, '.
									'same when backing up only table structure without saving the data. '.
									'To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Backing up and archiving completed.<br />' .
									'Backup package files stored in the %1 named sub-directory of <code>files/backup</code> directory.<br />' .
									'To download it use FTP (maintain the directory structure and file names when copying).<br />' .
									'To restore a backup copy or remove a package, go to <a href="?mode=db_restore">Restore database</a>.',
	'LogSavedBackup'			=> 'Saved backup database ##%1##',

	// DB Restore module
	'RestoreInfo'				=> 'You can restore any of the backup packages found or remove it from the server.',
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
									'and only the records with new keys are added to the table (SQL-instruction <code>INSERT IGNORE</code>).<br />' .
									'<span class="underline">Notice</span>: When restore complete backup of the site, this option has no value.<br />' .
									'<br />' .
									'** If the backup contains the user files (global and perpage, cache files, etc.), '.
									'in normal mode they replace the existing files with the same names and are placed in the same directory when being restored. '.
									'This option allows you to save the current copies of the files and restore from a backup only new files (missing on the server).',
	'IgnoreDuplicatedKeys'		=> 'Ignore duplicated table keys (not replace)',
	'IgnoreSameFiles'			=> 'Ignore the same files (not overwrite)',
	'NoBackupsAvailable'		=> 'No backups available.',
	'BackupEntireSite'			=> 'Entire site',
	'BackupRestored'			=> 'The backup is restored, a summary report is attached below. To delete this backup package, click',
	'BackupRemoved'				=> 'The selected backup has been successfully removed.',
	'LogRemovedBackup'			=> 'Removed database backup ##%1##',

	// User module
	'UsersAdded'				=> 'User added',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'UserEditButton'			=> 'Edit',
	'UserEnabled'				=> 'Habilitado',
	'UsersAddNew'				=> 'Nuevo usuario',
	'UsersDelete'				=> 'Está seguro que desea eliminar al usuario ',
	'UsersDeleted'				=> 'Usuario eliminado de la base de datos.',
	'UsersRename'				=> 'Renombrar usuario',
	'UsersRenameInfo'			=> '* Observación: El cambio afectará a todas las páginas asignadas a este usuario.',
	'UsersUpdated'				=> 'Usuario actualizado satisfactoriamente.',

	'UserName'					=> 'Username',
	'UserRealname'				=> 'Realname',
	'UserEmail'					=> 'Email',
	'UserIP'					=> 'IP',
	'UserLanguage'				=> 'Language',
	'UserSignuptime'			=> 'Signuptime',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'No users that meet the criteria',

	// Groups module
	'GroupsMembersFor'			=> 'Miembros del grupo',
	'GroupsDescription'			=> 'Descripción',
	'GroupsModerator'			=> 'Moderador',
	'GroupsOpen'				=> 'Abierto',
	'GroupsActive'				=> 'Activo',
	'GroupsTip'					=> 'Presione para editar el grupo',
	'GroupsUpdated'				=> 'Grupos actualizados',
	'GroupsAlreadyExists'		=> 'El grupo ya existe.',
	'GroupsAdded'				=> 'Grupo agregado con éxito.',
	'GroupsRenamed'				=> 'Grupo renombrado exitosamente.',
	'GroupsDeleted'				=> 'Grupo eliminado de la base de datos y de todas las páginas.',
	'GroupsAdd'					=> 'Agregar grupo nuevo',
	'GroupsRename'				=> 'Renombrar el grupo',
	'GroupsRenameInfo'			=> '* Observación: El cambio afectará a todas las páginas con el grupo asignado.',
	'GroupsDelete'				=> 'Está seguro que desea eliminar el grupo ',
	'GroupsDeleteInfo'			=> '* Observación: El cambio afectará a todas los miembros del grupo.',
	'GroupsStoreButton'			=> 'Guardar Grupos',
	'GroupsSaveButton'			=> 'GUardar',
	'GroupsCancelButton'		=> 'Cancelar',
	'GroupsAddButton'			=> 'Agregar',
	'GroupsEditButton'			=> 'Editar',
	'GroupsRemoveButton'		=> 'Remover',
	'GroupsEditInfo'			=> 'Marque el botón de radio para editar la lista de grupos.',

	'MembersAddNew'				=> 'Miembro nuevo',
	'MembersAdded'				=> 'Added new member to the group successfully.',
	'MembersRemove'				=> 'Está seguro que desea remover el miembro ',
	'MembersRemoved'			=> 'Miembro eliminado del grupo.',
	'MembersDeleteInfo'			=> '* Observación: El cambio afectará a todos los miembros asignados al grupo.',

];

?>