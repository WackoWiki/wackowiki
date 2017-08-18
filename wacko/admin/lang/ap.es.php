<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'				=> 'Observación: Antes de realizar actividades de administración se recomienda bloquear el acceso al sitio!',

	'CategoryArray'		=> [
		'basics'		=> 'Funciones básicas',
		'preferences'	=> 'Preferencias',
		'content'		=> 'Contenido',
		'users'			=> 'Ususarios',
		'maintenance'	=> 'Mantenimiento',
		'messages'		=> 'Mensajes',
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

	'ErrorLoadingModule'		=> 'Error cargar admin module %1: no existe.',

	'FormSave'					=> 'Guardar',
	'FormReset'					=> 'Reset',
	'FormUpdate'				=> 'Actualizar',

	'ApHomePage'				=> 'Home Page',
	'ApHomePageTip'				=> 'ir a la página home, sin salir de la administración',
	'ApLogOut'					=> 'Log out',
	'ApLogOutTip'				=> 'salir de la administración del sistema',

	'TimeLeft'					=> 'Tiempo restante:  %1 minutos',
	'ApVersion'					=> 'version',

	'SiteOpen'					=> 'abrir',
	'SiteOpened'				=> 'sitio abierto',
	'SiteOpenedTip'				=> 'El sitio está abierto',
	'SiteClose'					=> 'cerrar',
	'SiteClosed'				=> 'sitio cerrado',
	'SiteClosedTip'				=> 'El sitio está cerrado',

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
		'title'		=> 'parámetros básicos',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Apariencia',
		'title'		=> 'configuración de apariencia',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Email',
		'title'		=> 'configuración Email',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filter',
		'title'		=> 'configuración de Filtros',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'opciones de Formatter',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Notifications',
		'title'		=> 'configuración de notificationes',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Pages',
		'title'		=> 'parámetros de páginas y del sitio',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permissions',
		'title'		=> 'configuración de permisos',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Seguridad',
		'title'		=> 'configuración de seguridad',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Sistema',
		'title'		=> 'configuración del sistema',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Adjuntos',
		'title'		=> 'configuración de adjuntos',
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
		'title'		=> 'aministrar páginas',
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
		'title'		=> 'Mostrar estadísticas',
	],

	// Bad Behavior module
	'badbehavior'		=> [
		'name'		=> 'Bad Behavior',
		'title'		=> 'Mal comportamiento',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Aprobar',
		'title'		=> 'Aprobación de registro de usuario',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Grupos',
		'title'		=> 'Administración de Grupos',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Usuarios',
		'title'		=> 'Administración de Usuarios',
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
	'AppearanceSettingsInfo'	=> 'Configuración predeterminada de visualización para el sitio.',
	'LogoOff'					=> 'off',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo y título',


	// Email settings
	'EmaiSettingsInfo'			=> 'Esta información se usa cuando el Sitio envía emails a sus usuarios. Por favor verifique que la dirección de email ingresada sea válida, cualquier rebote se reenviará a esa dirección. Si su host no provee un servicio de email nativo (utilizable por PHP), entonces use directamente SMTP. Esto requiere la dirección de un servidor apropiado (pregúntele a su ISP de ser necesario). Si (si, y solo si) el servidor requiere autentificación complete el usuario y contraseña. Por favor observe que solo se ofrece autentificación básica, otro tipo de implementación no es posible actualmente.',

	'EmailFunctionName'			=> 'Nombre de la función email',
	'EmailFunctionNameInfo'		=> 'La función empleada por PHP para enviar emails.',
	'UseSmtpInfo'				=> 'Elija <code>SMTP</code> si quiere o necesita enviar emails mediante un servidor específico en lugar de la función de email local.',

	'EnableEmail'				=> 'Habilitar envío de emails',
	'EnableEmailInfo'			=> 'habilitando emails',

	'FromEmailName'				=> 'Nombre remitente',
	'FromEmailNameInfo'			=> 'Nombre del remitente, parte de la cabecera <code>From:</code> en emails para todas las notificaciones de email desde este sitio.',
	'NoReplyEmail'				=> 'dirección no-responder',
	'NoReplyEmailInfo'			=> 'Esta dirección, p.ej. <code>noreply@example.com</code> aparecerá en el campo <code>From:</code> del email en todas las notificaciones de email desde este sitio.',
	'AdminEmail'				=> 'Email del dueño del sitio',
	'AdminEmailInfo'			=> 'Esta dirección es para efectos de administración, por ejemplo notificación de nuevo usuario.',
	'AbuseEmail'				=> 'Email abuse service',
	'AbuseEmailInfo'			=> 'Dirección para asuntos urgentes: registro de un email estraño etc. Puee coincidir con e anterior.',

	'SendTestEmail'				=> 'Enviar un correo electrónico de prueba',
	'SendTestEmailInfo'			=> 'Esto enviará un correo electrónico de prueba a la dirección definida en su cuenta.',
	'TestEmailSubject'			=> 'El Wiki está configurado correctamente para enviar emails',
	'TestEmailBody'				=> 'Si recibió este email su Wiki está configurado correctamente para enviar emails.',
	'TestEmailMessage'			=> 'El correo electrónico de prueba ha sido enviado.<br />Si no lo recibes, por favor revisa tú configuración de mensajes de correo electrónico.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Habilita automáticamente encriptación si el servidor publica encriptación TLS (luego de conectar al servidor), aunque no se haya configurado el modo de conexión para <code>SMTPSecure</code>.',
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
	'UploadQuotaUser'			=> 'Cuota de espacio por usuario',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with 0 being unlimited.',
	'CheckMimetype'				=> 'Comprobar archivos adjuntos',
	'CheckMimetypeInfo'			=> 'Algunos navegadores pueden ser engañados para que asuman un mimetype de archivos subibles incorrecto. Esta opción previene que tales archivos que puedan causar eso sean rechazados.',

	'Thumbnails'				=> 'Thumbnails',
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
									'<span class="underline">Atención</span>: Las tablas de este backup no serán reestructurados para evitar pérdida de información al especificar el cluster de root, '.
									'igual al realizar backup de solamente la estructura de tabla sin guardar los datos. '.
									'Para realizar la conversión completa de las tablas al formato de backup debe realizar <em> el backup completo de base de datos (estructura y datos) sin especificar el cluster</em>.',
	'BackupCompleted'			=> 'Backup y archivación terminado.<br />' .
									'Archivo del backup guardado en subdirectorio %1 en <code>files/backup</code>.<br />' .
									'Use FTP para descargarlo (mantenga la estructura de diretorios y nombres de archivos al copiar).<br />' .
									'Para restaurar una copia del backup o remover un paquete, ingrese en <a href="?mode=db_restore">Restaurar base de datos</a>.',
	'LogSavedBackup'			=> 'Guardado backup de base de datos ##%1##',

	// DB Restore module
	'RestoreInfo'				=> 'Puede restaurar un backup existente o removerlo del servidor.',
	'ConfirmDbRestore'			=> 'Desea restaurar un backup',
	'ConfirmDbRestoreInfo'		=> 'Por favor espere, esto puede durar unos minutos.',
	'RestoreWrongVersion'		=> 'Versión de WackoWiki incorrecta!',
	'BackupDelete'				=> 'Seguro que desea eliminar el backup',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Opciones adicionales de restaurar',
	'RestoreOptionsInfo'		=> '* Antes de restaurar el <span class="underline">cluster backup</span>, '.
									'no se destruyen las tablas de destino (para evitar pérdida de información de los cluster que no tienen backup). '.
									'Por lo tanto habrá registros duplicados durante el proceso de restauración. '.
									'En el modo normal todos se reemplazarán por los registros desde el backup (usando la instrucción SQL <code>REPLACE</code>), '.
									'pero si se marca esta casilla, se omiten todos los duplicados (se mantienen los registros actuales), '.
									'y solamente se agregan en la tabla registros con claves nuevas (instrucción SQL <code>INSERT IGNORE</code>).<br />' .
									'<span class="underline">Observación</span>: Al restaurar el backup completo del sitio esta opción se ignora.<br />' .
									'<br />' .
									'** Si el backup contiene los archivos de usuario (global y por página, archivos cache, etc.), '.
									'en modo normal serán sustituidos al rastaurar con igual nombre y en la misma ubicación de directorio. '.
									'Esta opción permite guardar los archivos actuales y restaurar de un backup solamente los archivos nuevos (que faltan en el servidor).',
	'IgnoreDuplicatedKeys'		=> 'Ignorar claves duplicadas de tabla (no reemplazar)',
	'IgnoreSameFiles'			=> 'Ignorar archivos iguales (no sobreescribir)',
	'NoBackupsAvailable'		=> 'No existe backup.',
	'BackupEntireSite'			=> 'Sitio completo',
	'BackupRestored'			=> 'Se restauró el backup, abajo se adjunta un reporte de resumen. Para eliminar este paquete de backup, presione',
	'BackupRemoved'				=> 'Se eliminó con éxito el backup seleccionado.',
	'LogRemovedBackup'			=> 'Backup de base de datos eliminado ##%1##',

	// User module
	'UsersAdded'				=> 'Usuario agregado',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'UserEditButton'			=> 'Edit',
	'UserEnabled'				=> 'Habilitado',
	'UsersAddNew'				=> 'Nuevo usuario',
	'UsersDelete'				=> 'Está seguro que desea eliminar al usuario ',
	'UsersDeleted'				=> 'Usuario eliminado de la base de datos.',
	'UsersRename'				=> 'Renombrar usuario',
	'UsersRenameInfo'			=> '* Observación: El cambio afectará a todas las páginas asignadas a este usuario.',
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
	'GroupsSaveButton'			=> 'Guardar',
	'GroupsCancelButton'		=> 'Cancelar',
	'GroupsAddButton'			=> 'Agregar',
	'GroupsEditButton'			=> 'Editar',
	'GroupsRemoveButton'		=> 'Remover',
	'GroupsEditInfo'			=> 'Marque el botón de radio para editar la lista de grupos.',

	'MembersAddNew'				=> 'Miembro nuevo',
	'MembersAdded'				=> 'Nuevo miembro agregado al grupo con éxito.',
	'MembersRemove'				=> 'Está seguro que desea remover el miembro ',
	'MembersRemoved'			=> 'Miembro eliminado del grupo.',
	'MembersDeleteInfo'			=> '* Observación: El cambio afectará a todos los miembros asignados al grupo.',

];

?>
