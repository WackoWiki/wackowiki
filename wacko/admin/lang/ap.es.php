<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'				=> 'Observaci�n: Antes de realizar actividades de administraci�n se recomienda bloquear el acceso al sitio!',

	'CategoryArray'		=> [
		'basics'		=> 'Funciones b�sicas',
		'preferences'	=> 'Preferencias',
		'content'		=> 'Contenido',
		'users'			=> 'Ususarios',
		'maintenance'	=> 'Mantenimiento',
		'messages'		=> 'Mensajes',
		'extension'		=> 'Extension',
		'database'		=> 'Database',
	],

	// Admin panel
	'AdminPanel'				=> 'Panel de Control de Administraci�n',
	'RecoveryMode'				=> 'Modo de recuperaci�n',
	'Authorization'				=> 'Autorizaci�n',
	'AuthorizationTip'			=> 'Por favor ingrese la contrase�a del administrador (aseg�rese que su navegador permita cookies).',
	'NoRecoceryPassword'		=> 'Contrase�a administrativa no especificada!',
	'NoRecoceryPasswordTip'		=> 'Observaci�n: La falta de una contrase�a administrativa es un riesgo de seguridad! Ingrese la contrase�a en el archivo de configuraci�n y vuelva a ejecutar el programa.',

	'ErrorLoadingModule'		=> 'Error cargar admin module %1: no existe.',

	'FormSave'					=> 'Guardar',
	'FormReset'					=> 'Reset',
	'FormUpdate'				=> 'Actualizar',

	'ApHomePage'				=> 'Home Page',
	'ApHomePageTip'				=> 'ir a la p�gina home, sin salir de la administraci�n',
	'ApLogOut'					=> 'Log out',
	'ApLogOutTip'				=> 'salir de la administraci�n del sistema',

	'TimeLeft'					=> 'Tiempo restante:  %1 minutos',
	'ApVersion'					=> 'version',

	'SiteOpen'					=> 'abrir',
	'SiteOpened'				=> 'sitio abierto',
	'SiteOpenedTip'				=> 'El sitio est� abierto',
	'SiteClose'					=> 'cerrar',
	'SiteClosed'				=> 'sitio cerrado',
	'SiteClosedTip'				=> 'El sitio est� cerrado',

	// Generic
	'Cancel'					=> 'Cancelar',
	'Add'						=> 'Agregar',
	'Edit'						=> 'Editar',
	'Remove'					=> 'Remover',
	'Enabled'					=> 'Habilitar',
	'Disabled'					=> 'Deshabilitar',
	'On'						=> 'on',
	'Off'						=> 'off',
	'Mandatory'					=> 'Obligatorio',
	'Admin'						=> 'Admin',

	// MENU
	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Basic',
		'title'		=> 'par�metros b�sicos',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Apariencia',
		'title'		=> 'configuraci�n de apariencia',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Email',
		'title'		=> 'configuraci�n Email',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filter',
		'title'		=> 'configuraci�n de Filtros',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'opciones de Formatter',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Notifications',
		'title'		=> 'configuraci�n de notificationes',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Pages',
		'title'		=> 'par�metros de p�ginas y del sitio',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permissions',
		'title'		=> 'configuraci�n de permisos',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Seguridad',
		'title'		=> 'configuraci�n de seguridad',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Sistema',
		'title'		=> 'configuraci�n del sistema',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Adjuntos',
		'title'		=> 'configuraci�n de adjuntos',
	],

	// Categories module
	'content_categories'		=> [
		'name'		=> 'Categorias',
		'title'		=> 'configurar categorias',
	],

	// Comments module
	'content_comments'		=> [
		'name'		=> 'Comentarios',
		'title'		=> 'configurar comentarios',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Eliminar',
		'title'		=> 'Newly deleted content',
	],

	// Files module
	'content_files'		=> [
		'name'		=> 'Archivos',
		'title'		=> 'administrar archivos adjuntos',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Agregar, editar o eliminar itemes del menu',
	],

	// Pages module
	'content_pages'		=> [
		'name'		=> 'Paginas',
		'title'		=> 'aministrar p�ginas',
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
		'title'		=> 'Convertir tablas o columnas',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Reparar',
		'title'		=> 'Reparar y optimizar base de datos',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Restaurar',
		'title'		=> 'Restaurar datos de backup',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Menu Principal',
		'title'		=> 'WackoWiki Administration',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inconsistencias',
		'title'		=> 'Reparando inconsistencias de datos',
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
		'title'		=> 'Mensajes del sistema',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'System Info',
		'title'		=> 'System Information',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System log',
		'title'		=> 'Log de eventos del sistema',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistics',
		'title'		=> 'Mostrar estad�sticas',
	],

	// Bad Behavior module
	'badbehavior'		=> [
		'name'		=> 'Bad Behavior',
		'title'		=> 'Mal comportamiento',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Aprobar',
		'title'		=> 'Aprobaci�n de registro de usuario',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Grupos',
		'title'		=> 'Administraci�n de Grupos',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Usuarios',
		'title'		=> 'Administraci�n de Usuarios',
	],

	'LogFilterTip'				=> 'Filtrar eventos por criterios',
	'LogLevel'					=> 'Nivel',
	'LogLevelNotLower'			=> 'no menos que',
	'LogLevelNotHigher'			=> 'no m�s que',
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
	'AppearanceSettingsInfo'	=> 'Configuraci�n predeterminada de visualizaci�n para el sitio.',
	'LogoOff'					=> 'off',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo y t�tulo',


	// Email settings
	'EmaiSettingsInfo'			=> 'Esta informaci�n se usa cuando el Sitio env�a emails a sus usuarios. Por favor verifique que la direcci�n de email ingresada sea v�lida, cualquier rebote se reenviar� a esa direcci�n. Si su host no provee un servicio de email nativo (utilizable por PHP), entonces use directamente SMTP. Esto requiere la direcci�n de un servidor apropiado (preg�ntele a su ISP de ser necesario). Si (si, y solo si) el servidor requiere autentificaci�n complete el usuario y contrase�a. Por favor observe que solo se ofrece autentificaci�n b�sica, otro tipo de implementaci�n no es posible actualmente.',

	'EmailFunctionName'			=> 'Nombre de la funci�n email',
	'EmailFunctionNameInfo'		=> 'La funci�n empleada por PHP para enviar emails.',
	'UseSmtpInfo'				=> 'Elija <code>SMTP</code> si quiere o necesita enviar emails mediante un servidor espec�fico en lugar de la funci�n de email local.',

	'EnableEmail'				=> 'Habilitar env�o de emails',
	'EnableEmailInfo'			=> 'habilitando emails',

	'FromEmailName'				=> 'Nombre remitente',
	'FromEmailNameInfo'			=> 'Nombre del remitente, parte de la cabecera <code>From:</code> en emails para todas las notificaciones de email desde este sitio.',
	'NoReplyEmail'				=> 'direcci�n no-responder',
	'NoReplyEmailInfo'			=> 'Esta direcci�n, p.ej. <code>noreply@example.com</code> aparecer� en el campo <code>From:</code> del email en todas las notificaciones de email desde este sitio.',
	'AdminEmail'				=> 'Email del due�o del sitio',
	'AdminEmailInfo'			=> 'Esta direcci�n es para efectos de administraci�n, por ejemplo notificaci�n de nuevo usuario.',
	'AbuseEmail'				=> 'Email abuse service',
	'AbuseEmailInfo'			=> 'Direcci�n para asuntos urgentes: registro de un email estra�o etc. Puee coincidir con e anterior.',

	'SendTestEmail'				=> 'Enviar un correo electr�nico de prueba',
	'SendTestEmailInfo'			=> 'Esto enviar� un correo electr�nico de prueba a la direcci�n definida en su cuenta.',
	'TestEmailSubject'			=> 'El Wiki est� configurado correctamente para enviar emails',
	'TestEmailBody'				=> 'Si recibi� este email su Wiki est� configurado correctamente para enviar emails.',
	'TestEmailMessage'			=> 'El correo electr�nico de prueba ha sido enviado.<br />Si no lo recibes, por favor revisa t� configuraci�n de mensajes de correo electr�nico.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Habilita autom�ticamente encriptaci�n si el servidor publica encriptaci�n TLS (luego de conectar al servidor), aunque no se haya configurado el modo de conexi�n para <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'M�todo de autentificaci�n para SMTP',
	'SmtpConnectionModeInfo'	=> 'Solo usado si se configura usuario/contrase�a, preg�ntele a su ISP si no est� seguro de cual m�todo usar.',
	'SmtpPassword'				=> 'Contrase�a SMTP',
	'SmtpPasswordInfo'			=> 'Introduzca una contrase�a solo si su servidor SMTP lo requiere.<br /><em><strong>ADVERTENCIA:</strong> Esta contrase�a ser� guardada como texto plano en la base de datos y ser� visible para cualquiera que tenga acceso a la misma o que pueda ver esta p�gina de configuraci�n.</em>',
	'SmtpPort'					=> 'Puerto servidor SMTP',
	'SmtpPortInfo'				=> 'C�mbielo solo si sabe que su servidor SMTP est� en un puerto diferente. <br />(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Direcci�n servidor SMTP',
	'SmtpServerInfo'			=> 'Ten en cuenta que debes proporcionar el protocolo que utiliza tu servidor. Si est�s utilizando SSL, tiene que ser <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> 'Configuraci�n SMTP',
	'SmtpUsername'				=> 'Usuario SMTP',
	'SmtpUsernameInfo'			=> 'Solo introduzca un usuario si su servidor SMTP lo requiere.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Aqu� puedes configurar los principales par�metros para archivos adjuntos y las categor�as especiales asociadas.',
	'FileUploads'				=> 'File uploads',
	'UploadMaxFilesize'			=> 'Tama�o m�ximo',
	'UploadMaxFilesizeInfo'		=> 'Tama�o m�ximo de cada archivo. Si este valor es 0, el tama�o del archivo para subir s�lo estar� limitado por la configuraci�n de PHP.',
	'UploadQuota'				=> 'M�ximo total para adjuntos',
	'UploadQuotaInfo'			=> 'M�ximo en disco disponible para adjuntos en todo el sitio, 0 significa ilimitado.',
	'UploadQuotaUser'			=> 'Cuota de espacio por usuario',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with 0 being unlimited.',
	'CheckMimetype'				=> 'Comprobar archivos adjuntos',
	'CheckMimetypeInfo'			=> 'Algunos navegadores pueden ser enga�ados para que asuman un mimetype de archivos subibles incorrecto. Esta opci�n previene que tales archivos que puedan causar eso sean rechazados.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Crear vista en miniatura',
	'CreateThumbnailInfo'		=> 'Crear vista en miniatura siempre que sea posible.',
	'MaxThumbWidth'				=> 'Ancho m�ximo de la vista en miniatura en p�xeles',
	'MaxThumbWidthInfo'			=> 'La mini-imagen generada no exceder� este ancho.',
	'MinThumbFilesize'			=> 'Tama�o m�nimo para vista en miniatura',
	'MinThumbFilesizeInfo'		=> 'No crear vista en miniatura para im�genes m�s peque�as que esto.',

	// log
	'LogLevel1'					=> 'cr�tico',
	'LogLevel2'					=> 'm�s alto',
	'LogLevel3'					=> 'alto',
	'LogLevel4'					=> 'medio',
	'LogLevel5'					=> 'bajo',
	'LogLevel6'					=> 'm�s bajo',
	'LogLevel7'					=> 'depuraci�n',

	// Massemail
	'SendToGroup'				=> 'Enviar a grupo',
	'SendToUser'				=> 'Enviar a usuario',

	// User approval module
	'UserApproveInfo'			=> 'Aprobar nuevos usuarios antes de permitir su login al sitio.',
	'Approve'					=> 'Aprobar',
	'Deny'						=> 'Rechazar',
	'Pending'					=> 'Pendiente',
	'Approved'					=> 'Aprobado',
	'Denied'					=> 'Rechazado',

	// DB Backup module
	'BackupStructure'			=> 'Estructura',
	'BackupData'				=> 'Datos',
	'BackupFolder'				=> 'Carpeta',
	'BackupTable'				=> 'Tabla',
	'BackupCluster'				=> 'Cluster',
	'BackupFiles'				=> 'Archivos',
	'BackupSettings'			=> 'Indique el esquema de backup deseado.<br />' .
									'El cluster de root no afecta al backup global de archivos y al backup de archivos de cache (al seleccionar siempre se guardan por completo).<br />' .
									'<br />' .
									'<span class="underline">Atenci�n</span>: Las tablas de este backup no ser�n reestructurados para evitar p�rdida de informaci�n al especificar el cluster de root, '.
									'igual al realizar backup de solamente la estructura de tabla sin guardar los datos. '.
									'Para realizar la conversi�n completa de las tablas al formato de backup debe realizar <em> el backup completo de base de datos (estructura y datos) sin especificar el cluster</em>.',
	'BackupCompleted'			=> 'Backup y archivaci�n terminado.<br />' .
									'Archivo del backup guardado en subdirectorio %1 en <code>files/backup</code>.<br />' .
									'Use FTP para descargarlo (mantenga la estructura de diretorios y nombres de archivos al copiar).<br />' .
									'Para restaurar una copia del backup o remover un paquete, ingrese en <a href="?mode=db_restore">Restaurar base de datos</a>.',
	'LogSavedBackup'			=> 'Guardado backup de base de datos ##%1##',

	// DB Restore module
	'RestoreInfo'				=> 'Puede restaurar un backup existente o removerlo del servidor.',
	'ConfirmDbRestore'			=> 'Desea restaurar un backup',
	'ConfirmDbRestoreInfo'		=> 'Por favor espere, esto puede durar unos minutos.',
	'RestoreWrongVersion'		=> 'Versi�n de WackoWiki incorrecta!',
	'BackupDelete'				=> 'Seguro que desea eliminar el backup',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Opciones adicionales de restaurar',
	'RestoreOptionsInfo'		=> '* Antes de restaurar el <span class="underline">cluster backup</span>, '.
									'no se destruyen las tablas de destino (para evitar p�rdida de informaci�n de los cluster que no tienen backup). '.
									'Por lo tanto habr� registros duplicados durante el proceso de restauraci�n. '.
									'En el modo normal todos se reemplazar�n por los registros desde el backup (usando la instrucci�n SQL <code>REPLACE</code>), '.
									'pero si se marca esta casilla, se omiten todos los duplicados (se mantienen los registros actuales), '.
									'y solamente se agregan en la tabla registros con claves nuevas (instrucci�n SQL <code>INSERT IGNORE</code>).<br />' .
									'<span class="underline">Observaci�n</span>: Al restaurar el backup completo del sitio esta opci�n se ignora.<br />' .
									'<br />' .
									'** Si el backup contiene los archivos de usuario (global y por p�gina, archivos cache, etc.), '.
									'en modo normal ser�n sustituidos al rastaurar con igual nombre y en la misma ubicaci�n de directorio. '.
									'Esta opci�n permite guardar los archivos actuales y restaurar de un backup solamente los archivos nuevos (que faltan en el servidor).',
	'IgnoreDuplicatedKeys'		=> 'Ignorar claves duplicadas de tabla (no reemplazar)',
	'IgnoreSameFiles'			=> 'Ignorar archivos iguales (no sobreescribir)',
	'NoBackupsAvailable'		=> 'No existe backup.',
	'BackupEntireSite'			=> 'Sitio completo',
	'BackupRestored'			=> 'Se restaur� el backup, abajo se adjunta un reporte de resumen. Para eliminar este paquete de backup, presione',
	'BackupRemoved'				=> 'Se elimin� con �xito el backup seleccionado.',
	'LogRemovedBackup'			=> 'Backup de base de datos eliminado ##%1##',

	// User module
	'UsersAdded'				=> 'Usuario agregado',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'UserEditButton'			=> 'Edit',
	'UserEnabled'				=> 'Habilitado',
	'UsersAddNew'				=> 'Nuevo usuario',
	'UsersDelete'				=> 'Est� seguro que desea eliminar al usuario ',
	'UsersDeleted'				=> 'Usuario eliminado de la base de datos.',
	'UsersRename'				=> 'Renombrar usuario',
	'UsersRenameInfo'			=> '* Observaci�n: El cambio afectar� a todas las p�ginas asignadas a este usuario.',
	'UsersUpdated'				=> 'Usuario actualizado satisfactoriamente.',

	'UserName'					=> 'Nombre de usuario',
	'UserRealname'				=> 'Nombre real',
	'UserEmail'					=> 'Email',
	'UserIP'					=> 'IP',
	'UserLanguage'				=> 'Idioma',
	'UserSignuptime'			=> 'Signuptime',
	'UserActions'				=> 'Acciones',
	'NoMatchingUser'			=> 'No hay usuarios con este criterio',

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
	'GroupsSaveButton'			=> 'Guardar',
	'GroupsCancelButton'		=> 'Cancelar',
	'GroupsAddButton'			=> 'Agregar',
	'GroupsEditButton'			=> 'Editar',
	'GroupsRemoveButton'		=> 'Remover',
	'GroupsEditInfo'			=> 'Marque el bot�n de radio para editar la lista de grupos.',

	'MembersAddNew'				=> 'Miembro nuevo',
	'MembersAdded'				=> 'Nuevo miembro agregado al grupo con �xito.',
	'MembersRemove'				=> 'Est� seguro que desea remover el miembro ',
	'MembersRemoved'			=> 'Miembro eliminado del grupo.',
	'MembersDeleteInfo'			=> '* Observaci�n: El cambio afectar� a todos los miembros asignados al grupo.',

];

?>
