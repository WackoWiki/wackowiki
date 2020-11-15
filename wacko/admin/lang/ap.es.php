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
	'NoRecoveryPassword'		=> 'Contraseña administrativa no especificada!',
	'NoRecoveryPasswordTip'		=> 'Observación: La falta de una contraseña administrativa es un riesgo de seguridad! Ingrese la contraseña en el archivo de configuración y vuelva a ejecutar el programa.',

	'ErrorLoadingModule'		=> 'Error cargar admin module %1: no existe.',

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
	'Mandatory'					=> 'Obligatorio',
	'Admin'						=> 'Admin',

	'MiscellaneousSection'		=> 'Misceláneo',
	'MainSection'				=> 'Parámetros básicos',

	'DirNotWritable'			=> 'El directorio %1 no es escribible.',

	/**
	 * AP MENU
	 *
	 *	'module_name'		=> [
	 *		'name'		=> 'Module name',
	 *		'title'		=> 'Module title',
	 *	],
	 */

	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Basic',
		'title'		=> 'Parámetros básicos',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Apariencia',
		'title'		=> 'Configuración de apariencia',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Email',
		'title'		=> 'Configuración Email',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filter',
		'title'		=> 'Configuración de Filtros',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'Opciones de Formatter',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Notificaciones',
		'title'		=> 'Configuración de notificationes',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Pages',
		'title'		=> 'Parámetros de páginas y del sitio',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permissions',
		'title'		=> 'Configuración de permisos',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Seguridad',
		'title'		=> 'Configuración de seguridad',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Sistema',
		'title'		=> 'Configuración del sistema',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Adjuntos',
		'title'		=> 'Configuración de adjuntos',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Eliminar',
		'title'		=> 'Contenido recientemente eliminado',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Agregar, editar o eliminar itemes del menu',
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
		'title'		=> 'Sincronización de datos',
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
	'tool_badbehavior'		=> [
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

	// Main module
	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the auth_token table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Updated basic settings',
	'LogBasicSettingsUpdated'	=> 'Updated basic settings',

	'SiteName'					=> 'Nombre del sitio',
	'SiteNameInfo'				=> 'El título de este sitio, aparece en el título del navegador, encabezado del tema, notificación por correo electrónico, etc.',
	'SiteDesc'					=> 'Descripción del sitio:',
	'SiteDescInfo'				=> 'Suplemento al título del sitio que aparece en la cabecera de las páginas para explicar en pocas palabras de qué se trata este sitio.',
	'AdminName'					=> 'Admin of Site',
	'AdminNameInfo'				=> 'Nombre de usuario, que es responsable del soporte general del sitio. Este nombre no se utiliza para determinar los derechos de acceso, pero es deseable que se corresponda con el nombre del administrador jefe del sitio.',
	'LanguageSection'			=> 'Idioma',
	'DefaultLanguage'			=> 'Idioma por defecto',
	'DefaultLanguageInfo'		=> 'Especifica el idioma de los mensajes que se muestran a los invitados no registrados, así como la configuración de la ubicación.',
	'MultiLanguage'				=> 'Soporte multilenguaje',
	'MultiLanguageInfo'			=> 'Permita la posibilidad de seleccionar un idioma página por página.',
	'AllowedLanguages'			=> 'Idiomas permitidos',
	'AllowedLanguagesInfo'		=> 'Se recomienda seleccionar sólo el conjunto de idiomas que desea utilizar, de lo contrario se seleccionan todos los idiomas.',
	'CommentSection'			=> 'Comentarios',
	'AllowComments'				=> 'Permitir comentarios',
	'AllowCommentsInfo'			=> 'Habilitar comentarios sólo para usuarios invitados o registrados o deshabilitarlos en todo el sitio.',
	'SortingComments'			=> 'Ordenar comentarios',
	'SortingCommentsInfo'		=> 'Cambia el orden en que se presentan los comentarios de la página, ya sea con el comentario más reciente O el más antiguo en la parte superior.',
	'ToolbarSection'			=> 'Toolbar',
	'CommentsPanel'				=> 'Panel de comentarios',
	'CommentsPanelInfo'			=> 'La visualización por defecto de los comentarios en la parte inferior de la página.',
	'FilePanel'					=> 'Panel de archivos',
	'FilePanelInfo'				=> 'La visualización predeterminada de los archivos adjuntos en la parte inferior de la página.',
	'RatingPanel'				=> 'Rating panel',
	'RatingPanelInfo'			=> 'La pantalla predeterminada del panel de clasificación en la parte inferior de la página.',
	'TagsPanel'					=> 'Panel de etiquetas',
	'TagsPanelInfo'				=> 'La visualización por defecto del panel de etiquetas en la parte inferior de la página.',

	'NavigationSection'			=> 'Navegación',
	'ShowPermalink'				=> 'Mostrar Permalink',
	'ShowPermalinkInfo'			=> 'La visualización por defecto del enlace permanente para la versión actual de la página.',
	'TocPanel'					=> 'Panel de contenido',
	'TocPanelInfo'				=> 'The default display table of contents panel of a page (may need support in the templates).',
	'SectionsPanel'				=> 'Sections panel',
	'SectionsPanelInfo'			=> 'By default display the panel of adjacent pages (requires support in the templates).',
	'DisplayingSections'		=> 'Displaying sections',
	'DisplayingSectionsInfo'	=> 'When the previous options, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>) or both, and other (<em>tree</em>).',
	'MenuItems'					=> 'Menu items',
	'MenuItemsInfo'				=> 'Default number of shown menu items (may need support in the templates).',

	'HandlerSection'			=> 'Handler',
	'HideRevisions'				=> 'Suprimir revisiones',
	'HideRevisionsInfo'			=> 'La visualización por defecto de las revisiones de la página.',
	'AttachmentHandler'			=> 'Habilitar el manejador de archivos adjuntos',
	'AttachmentHandlerInfo'		=> 'Permite mostrar el manejador de archivos adjuntos.',
	'SourceHandler'				=> 'Enable source handler',
	'SourceHandlerInfo'			=> 'Allows to show the source handler.',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Enable feeds',
	'EnableFeedsInfo'			=> 'Activa o desactiva las fuentes RSS de toda la wiki.',
	'XmlSitemap'				=> 'XML Sitemap',
	'XmlSitemapInfo'			=> 'Create an XML file called %1 inside the xml folder. Generate a Sitemaps XML format compatible XML file. You might want to change the path to output it in your root folder as that is one of the requirements i.e. that the XML file is in the root folder. On the other hand you can also add the path to the sitemap in the robots.txt file in your root directory as follows:',
	'XmlSitemapTime'			=> 'Tiempo de generación de sitemaps XML',
	'XmlSitemapTimeInfo'		=> 'Genera el Sitemap sólo una vez en el número de días dado, cero significa en cada cambio de página.',
	'DiffModeSection'			=> 'Modos Diff',
	'DefaultDiffModeSetting'	=> 'Default diff mode',
	'DefaultDiffModeSettingInfo'=> 'Modo diff preseleccionado.',
	'AllowedDiffMode'			=> 'Modos de Diff permitidos',
	'AllowedDiffModeInfo'		=> 'Se recomienda seleccionar sólo el conjunto de modos diff que desea utilizar, de lo contrario se seleccionan todos los modos diff.',
	'NotifyDiffMode'			=> 'Notificar modo diff',
	'NotifyDiffModeInfo'		=> 'Modo diff utilizado para las notificaciones en el cuerpo del correo electrónico.',

	'EditingSection'			=> 'Editing',
	'EditSummary'				=> 'Resumen de edición',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Minor edit',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'ReviewSettings'			=> 'Review',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',
	'PublishAnonymously'		=> 'Permitir publicación anónima',
	'PublishAnonymouslyInfo'	=> 'Permitir que los usuarios publiquen preferiblemente de forma anónima (para ocultar el nombre de usuario).',

	'DefaultRenameRedirect'		=> 'Al renombrar poner redirección',
	'DefaultRenameRedirectInfo'	=> 'De forma predeterminada, ofrezca establecer una redirección a la dirección anterior de la página a la que se está cambiando el nombre.',
	'StoreDeletedPages'			=> 'Mantener páginas eliminadas',
	'StoreDeletedPagesInfo'		=> 'Cuando elimine una página, un comentario o un archivo, guárdelo en una sección especial, donde estará disponible para su revisión y recuperación durante más tiempo (como se describe a continuación).',
	'KeepDeletedTime'			=> 'Tiempo de almacenamiento de las páginas borradas',
	'KeepDeletedTimeInfo'		=> 'El período en días. Sólo tiene sentido con la opción anterior. Cero indica la posesión eterna (en este caso el administrador puede borrar el "carrito" manualmente).',
	'PagesPurgeTime'			=> 'Tiempo de almacenamiento de las revisiones de página',
	'PagesPurgeTimeInfo'		=> 'Borra automáticamente las versiones anteriores dentro del número de días dado. Si introduce cero, las versiones anteriores no se eliminarán.',
	'EnableReferrers'			=> 'Habilitar referenciadores',
	'EnableReferrersInfo'		=> 'Permite almacenar y mostrar referencias externas.',
	'ReferrersPurgeTime'		=> 'Tiempo de almacenamiento de los referidos.',
	'ReferrersPurgeTimeInfo'	=> 'Mantener el historial de remisión de páginas externas no más allá de un número determinado de días. Cero significa almacenamiento eterno, pero para un sitio visitado activamente esto puede llevar a un desbordamiento de la base de datos.',
	'SearchEngineVisibility'	=> 'Bloquear los motores de búsqueda (Search Engine Visibility)',
	'SearchEngineVisibilityInfo'=> 'Bloquee los motores de búsqueda, pero permita que los visitantes normales. Anula la configuración de la página. <br>Desalentar a los motores de búsqueda para que no indexen este sitio, es responsabilidad de los motores de búsqueda cumplir con esta petición.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Configuración predeterminada de visualización para el sitio.',
	'AppearanceSettingsUpdated'	=> 'Updated appearance settings.',

	'LogoOff'					=> 'Off',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo y título',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Logo del sitio',
	'SiteLogoInfo'				=> 'Su logotipo aparecerá normalmente en la esquina superior izquierda de la aplicación. El tamaño máximo es de 2 MiB. Las dimensiones óptimas son 255 píxeles de ancho por 55 píxeles de alto.',
	'LogoDimensions'			=> 'Dimensiones del logo',
	'LogoDimensionsInfo'		=> 'Ancho y alto del Logo mostrado.',
	'LogoDisplayMode'			=> 'Modo de visualización del logo',
	'LogoDisplayModeInfo'		=> 'Define la apariencia del Logotipo. El valor predeterminado está desactivado.',
	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Sitio Favicon',
	'SiteFaviconInfo'			=> 'El icono de acceso directo, o favicon, se muestra en la barra de direcciones, pestañas y marcadores de la mayoría de los navegadores. Esto invalidará el favicon de su tema.',
	'SiteFaviconTooBig'			=> 'Favicon es más grande que 64 × 64px.',
	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Tema',
	'ThemeInfo'					=> 'El diseño de la plantilla que el sitio utiliza por defecto.',
	'ThemesAllowed'				=> 'Temas permitidos',
	'ThemesAllowedInfo'			=> 'Seleccione los temas permitidos, que el usuario puede elegir, de lo contrario se permiten todos los temas disponibles.',
	'ThemesPerPage'				=> 'Temas por página',
	'ThemesPerPageInfo'			=> 'Permitir temas por página, que el propietario de la página puede elegir a través de las propiedades de la página.',

	// System settings
	'SystemSettingsInfo'		=> 'Grupo de parámetros responsables de la plataforma de ajuste fino. No los cambie a menos que tenga confianza en sus acciones.',
	'SystemSettingsUpdated'		=> 'Actualización de la configuración del sistema',

	'DebugModeSection'			=> 'Modo de depuración',
	'DebugMode'					=> 'Modo de depuración',
	'DebugModeInfo'				=> 'Fixation and the withdrawal of telemetry data on the time of the program. Note: the full detail of the regime imposes high demands on available memory, especially in demanding operations such as backup and restore the database.',
	'DebugModes'	=> [
		'0'		=> 'debugging is off',
		'1'		=> 'only the total execution time',
		'2'		=> 'full-time',
		'3'		=> 'full detail (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Threshold performance RDBMS',
	'DebugSqlThresholdInfo'		=> 'In the detailed debug mode to record only the queries take longer than the number of seconds.',
	'DebugAdminOnly'			=> 'Diagnóstico cerrado',
	'DebugAdminOnlyInfo'		=> 'Mostrar los datos de depuración del programa (y del SGBD) sólo para el administrador.',

	'CachingSection'			=> 'Cache options',
	'Cache'						=> 'Cache rendered pages',
	'CacheInfo'					=> 'Save rendered pages in the local cache to speed up the subsequent boot. Valid only for unregistered visitors.',
	'CacheTtl'					=> 'Term relevance cached pages',
	'CacheTtlInfo'				=> 'Cache pages no more than a specified number of seconds.',
	'CacheSql'					=> 'Cache DBMS queries',
	'CacheSqlInfo'				=> 'Maintain a local cache the results of certain resource-SQL-queries.',
	'CacheSqlTtl'				=> 'Term relevance Cache Database',
	'CacheSqlTtlInfo'			=> 'Cache results of SQL-queries for no more than the specified number of seconds. Using the values of more than 1200 is not desirable.',

	'PrivacySection'			=> 'Privacidad',
	'AnonymizeIp'				=> 'Anonimizar las direcciones IP de los usuarios',
	'AnonymizeIpInfo'			=> 'Anonimizar direcciones IP donde sea aplicable como página, revisión o referencias.',

	'ReverseProxySection'		=> 'Reverse Proxy',
	'ReverseProxy'				=> 'Use Reverse proxy',
	'ReverseProxyInfo'			=> 'Enable this setting to determine the correct IP address of the remote
									 client by examining information stored in the X-Forwarded-For headers.
									 X-Forwarded-For headers are a standard mechanism for identifying client
									 systems connecting through a reverse proxy server, such as Squid or
									 Pound. Reverse proxy servers are often used to enhance the performance
									 of heavily visited sites and may also provide other site caching,
									 security or encryption benefits. If this WackoWiki installation operates
									 behind a reverse proxy, this setting should be enabled so that correct
									 IP address information is captured in WackoWiki\'s session management,
									 logging, statistics and access management systems; if you are unsure
									 about this setting, do not have a reverse proxy, or WackoWiki operates in
									 a shared hosting environment, this setting should remain disabled.',
	'ReverseProxyHeader'		=> 'Reverse proxy header',
	'ReverseProxyHeaderInfo'	=> 'Set this value if your proxy server sends the client IP in a header
									 other than X-Forwarded-For. The "X-Forwarded-For" header is a comma+space separated list of IP
									 addresses, only the last one (the left-most) will be used.',
	'ReverseProxyAddresses'		=> 'reverse_proxy accepts an array of IP addresses',
	'ReverseProxyAddressesInfo'	=> 'Each element of this array is the IP address of any of your reverse
									 proxies. Filling this array WackoWiki will trust the information stored
									 in the X-Forwarded-For headers only if Remote IP address is one of
									 these, that is the request reaches the web server from one of your
									 reverse proxies. Otherwise, the client could directly connect to
									 your web server spoofing the X-Forwarded-For headers.',

	'SessionSection'				=> 'Manejo de sesiones',
	'SessionStorage'				=> 'Almacenamiento de sesiones',
	'SessionStorageInfo'			=> 'Esta opción define dónde se almacenan los datos de la sesión. De forma predeterminada, se selecciona el almacenamiento de archivos o de sesiones de base de datos.',
	'SessionModes'	=> [
		'1'		=> 'Archivo',
		'2'		=> 'Base de datos',
	],

	'RewriteMode'					=> 'Usar <code>mod_rewrite</code>',
	'RewriteModeInfo'				=> 'If your web server supports this feature, turn to get "beautiful" the addresses of pages.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parámetros responsables del control de acceso y permisos.',
	'PermissionsSettingsUpdated'	=> 'Configuración de permisos actualizada',

	'PermissionsSection'		=> 'Derechos y privilegios',
	'ReadRights'				=> 'Derechos de lectura por defecto',
	'ReadRightsInfo'			=> 'Se asignan a las páginas raíz creadas, así como a las páginas para las que no se pueden definir los derechos parentales.',
	'WriteRights'				=> 'Derechos de escritura por defecto',
	'WriteRightsInfo'			=> 'Se asignan a las páginas raíz creadas, así como a las páginas para las que no se pueden definir los derechos parentales.',
	'CommentRights'				=> 'Derechos de comentario por defecto',
	'CommentRightsInfo'			=> 'Se asignan a las páginas raíz creadas, así como a las páginas para las que no se pueden definir los derechos parentales.',
	'CreateRights'				=> 'Crear derechos de una subpágina por defecto',
	'CreateRightsInfo'			=> 'Defina el derecho a crear páginas raíz y asígnelas a páginas para las que no se pueden definir derechos parentales.',
	'UploadRights'				=> 'Derechos de carga por defecto',
	'UploadRightsInfo'			=> 'Se asignan a las páginas raíz creadas, así como a las páginas para las que no se pueden definir los derechos parentales.',
	'RenameRights'				=> 'Global rename right',
	'RenameRightsInfo'			=> 'The list of permissions to freely rename (move) pages.',

	'LockAcl'					=> 'Lock all ACL to read only',
	'LockAclInfo'				=> '<span class="cite">Overwrites the acl settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period for security reasons or as a emergency response.',
	'HideLocked'				=> 'Esconder páginas inaccesibles',
	'HideLockedInfo'			=> 'Si el usuario no tiene permiso para leer la página, ocúltela en diferentes listas de páginas (sin embargo, el enlace colocado en el texto, seguirá siendo visible).',
	'RemoveOnlyAdmins'			=> 'Sólo los administradores pueden eliminar páginas',
	'RemoveOnlyAdminsInfo'		=> 'Denegar todas las páginas, excepto los administradores, para eliminarlas. En el primer límite se aplica a los propietarios de páginas normales.',
	'OwnersRemoveComments'		=> 'Los propietarios de las páginas pueden eliminar comentarios',
	'OwnersRemoveCommentsInfo'	=> 'Permite a los propietarios de páginas moderar los comentarios en sus páginas.',
	'OwnersEditCategories'		=> 'Owners can edit page categories',
	'OwnersEditCategoriesInfo'	=> 'Allow owners to modify the pages category list of your site (add words, delete words), assigns to a page.',
	'TermHumanModeration'		=> 'Term human moderation',
	'TermHumanModerationInfo'	=> 'Los moderadores sólo pueden editar los comentarios si se crearon hace no más de este número de días (esta limitación no se aplica al último comentario del tema).',

	'UserCanDeleteAccount'		=> 'Permitir a los usuarios eliminar sus propias cuentas',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parámetros responsables de la seguridad general de la plataforma, restricciones de seguridad y subsistemas de seguridad adicionales.',
	'SecuritySettingsUpdated'	=> 'Configuración de seguridad actualizada',

	'AllowRegistration'			=> 'Regístrese en línea',
	'AllowRegistrationInfo'		=> 'Abrir registro de usuario. Al desactivar esta opción se impedirá el registro gratuito, sin embargo, el administrador del sitio podrá registrar a otros usuarios él mismo.',
	'ApproveNewUser'			=> 'Aprobar nuevos usuarios',
	'ApproveNewUserInfo'		=> 'Permite a los administradores aprobar a los usuarios una vez que se registran. Sólo los usuarios aprobados podrán iniciar sesión en el sitio.',
	'PersistentCookies'			=> 'Cookies persistentes',
	'PersistentCookiesInfo'		=> 'Permitir cookies persistentes.',
	'DisableWikiName'			=> 'Desactivar NombreWiki',
	'DisableWikiNameInfo'		=> 'Desactivar el uso obligatorio de NombreWiki. Permite registrar usuarios con apodos tradicionales, no forzado NameSurname.',
	'AllowEmailReuse'			=> 'Permitir la reutilización de la dirección de correo electrónico',
	'AllowEmailReuseInfo'		=> 'Diferentes usuarios pueden registrarse con la misma dirección de correo electrónico.',
	'UsernameLength'			=> 'Longitud del nombre de usuario',
	'UsernameLengthInfo'		=> 'Número mínimo y máximo de caracteres en los nombres de usuario.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Habilitar Captcha',
	'EnableCaptchaInfo'			=> 'Si está habilitado, Captcha se mostrará en los siguientes casos o si se alcanza un umbral de seguridad.',
	'CaptchaComment'			=> 'Nuevo comentario',
	'CaptchaCommentInfo'		=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before posting the comment.',
	'CaptchaPage'				=> 'Nueva página',
	'CaptchaPageInfo'			=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before creating a new pages.',
	'CaptchaEdit'				=> 'Editar página',
	'CaptchaEditInfo'			=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before editing pages.',
	'CaptchaRegistration'		=> 'Inscripciones',
	'CaptchaRegistrationInfo'	=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before registering.',

	'TlsSection'				=> 'TLS Settings',
	'TlsConnection'				=> 'TLS-Connection',
	'TlsConnectionInfo'			=> 'Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS-certificate on the server, otherwise you will lose access to the admin panel!</span><br>It also determines if the the Cookie Secure Flag is set, the <code>secure</code> flag specifies whether cookies should only be sent over secure connections.',
	'TlsImplicit'				=> 'Mandatory TLS',
	'TlsImplicitInfo'			=> 'Reconectar por la fuerza el cliente de HTTP a HTTPS. Con la opción desactivada, el cliente puede navegar por el sitio a través de un canal HTTP abierto.',

	'HttpSecurityHeaders'		=> 'HTTP Security Headers',
	'EnableSecurityHeaders'		=> 'Enable Security Headers',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk !',
	'Csp'						=> 'Content-Security-Policy (CSP)',
	'CspInfo'					=> 'Configuring Content Security Policy involves deciding what policies you want to enforce, and then configuring them and using Content-Security-Policy to establish your policy.',
	'CspModes'	=> [
		'0'		=> 'disabled',
		'1'		=> 'strict',
		'2'		=> 'custom',
	],
	'ReferrerPolicy'			=> 'Referrer Policy',
	'ReferrerPolicyInfo'		=> 'The Referrer-Policy HTTP header governs which referrer information, sent in the Referer header, should be included with requests made.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> 'Persistence of user passwords',
	'PwdMinChars'				=> 'Longitud mínima de la contraseña',
	'PwdMinCharsInfo'			=> 'Las contraseñas más largas son necesariamente más seguras que las más cortas (por ejemplo, de 12 a 16 caracteres). <br>Se recomienda el uso de frases de contraseña en lugar de contraseñas.',
	'AdminPwdMinChars'			=> 'Longitud mínima de la contraseña de administrador',
	'AdminPwdMinCharsInfo'		=> 'Las contraseñas más largas son necesariamente más seguras que las más cortas (por ejemplo, de 15 a 20 caracteres). <br>Se recomienda el uso de frases de contraseña en lugar de contraseñas.',
	'PwdCharComplexity'			=> 'La complejidad de la contraseña requerida',
	'PwdCharClasses'	=> [
		'0'		=> 'not tested',
		'1'		=> 'any letters + numbers',
		'2'		=> 'uppercase and lowercase + numbers',
		'3'		=> 'uppercase and lowercase + numbers + characters',
	],
	'PwdUnlikeLogin'			=> 'Additional complication',
	'PwdUnlikes'	=> [
		'0'		=> 'not tested',
		'1'		=> 'password is not identical to the login',
		'2'		=> 'password does not contain username',
	],

	'LoginSection'				=> 'Conectar',
	'MaxLoginAttempts'			=> 'Número máximo de intentos de inicio de sesión por nombre de usuario',
	'MaxLoginAttemptsInfo'		=> 'El número de intentos de inicio de sesión permitidos para una sola cuenta antes de que se active la tarea anti-spambot. Introduzca 0 para evitar que se active la tarea anti-spambot para cuentas de usuario distintas.',
	'IpLoginLimitMax'			=> 'Número máximo de intentos de inicio de sesión por dirección IP',
	'IpLoginLimitMaxInfo'		=> 'El umbral de intentos de inicio de sesión permitido desde una única dirección IP antes de que se active una tarea anti-spambot. Introduzca 0 para evitar que la tarea anti-spambot sea activada por las direcciones IP.',

	'LogSection'				=> 'Log settings',
	'LogLevelUsage'				=> 'Using logging',
	'LogLevelInfo'				=> 'The minimum priority of the events recorded in the log.',
	'LogThresholds'	=> [
		'0'		=> 'not keep a journal',
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high',
		'4'		=> 'on average',
		'5'		=> 'from low',
		'6'		=> 'the minimum level',
		'7'		=> 'record all',
	],
	'LogDefaultShow'			=> 'Display Log Mode',
	'LogDefaultShowInfo'		=> 'Los eventos de prioridad mínima visualizados en el log por defecto.',
	'LogModes'	=> [
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high-level',
		'4'		=> 'the average',
		'5'		=> 'from a low',
		'6'		=> 'from the minimum level',
		'7'		=> 'show all',
	],
	'LogPurgeTime'				=> 'Tiempo de almacenamiento del log',
	'LogPurgeTimeInfo'			=> 'Remove event log over a given number of days.',

	'FormsSection'				=> 'Forms',
	'FormTokenTime'				=> 'Tiempo máximo para enviar formularios',
	'FormTokenTimeInfo'			=> 'El tiempo que un usuario tiene para enviar un formulario (en segundos).<br> Tenga en cuenta que un formulario puede ser inválido si la sesión expira, independientemente de esta configuración.',

	'SessionLength'				=> 'Term login cookie',
	'SessionLengthInfo'			=> 'The lifetime of the user cookie login by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of the new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications',
	'IntercomDelayInfo'			=> 'The minimum delay between sending a private message user connection (in seconds).',
	'RegistrationDelay'			=> 'Time threshold for registering',
	'RegistrationDelayInfo'		=> 'El umbral de tiempo mínimo para rellenar el formulario de registro para distinguir a los robots de los humanos (en segundos).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'FormatterSettingsUpdated'	=> 'Updated formatting settings',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> 'Typographical Proofreader',
	'TypograficaInfo'			=> 'Unsetting slightly speed up the process of adding comments and save the page.',
	'Paragrafica'				=> 'Paragrafica markings',
	'ParagraficaInfo'			=> 'Similar to the previous option, but will lead to disconnection of inoperable automatic table of contents: <code>{{toc}}</code>.',
	'AllowRawhtml'				=> 'Global HTML Support',
	'AllowRawhtmlInfo'			=> 'This option is potentially unsafe for an open site.',
	'SafeHtml'					=> 'Filtering HTML',
	'SafeHtmlInfo'				=> 'Prevents saving of dangerous HTML-objects. Turning off the filter on an open site with HTML support is <span class="underline">extremely</span> undesirable!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formatter)',
	'X11colors'					=> 'X11 Colors Usage',
	'X11colorsInfo'				=> 'Extents the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code>Unsetting slightly speeds up the process of adding comments and saving of pages.',
	'WikiLinks'					=> 'Disable Wikilinks',
	'WikiLinksInfo'				=> 'Disables linking for <code>CamelCaseWords</code>, your CamelCase Words will no longer be linked directly to a new page. This is useful when you work across different namespaces aks clusters. By default it is off.',
	'BracketsLinks'				=> 'Disable bracketslinks',
	'BracketsLinksInfo'			=> 'Disables <code>[[link]]</code> and <code>((link))</code> syntax.',
	'Formatters'				=> 'Disable Formatters',
	'FormattersInfo'			=> 'Disables <code>%%code%%</code> syntax, used for highlighters.',

	'DateFormatsSection'		=> 'Date Formats',
	'DateFormat'				=> 'The format of the date',
	'DateFormatInfo'			=> '(day, month, year)',
	'TimeFormat'				=> 'The format of time',
	'TimeFormatInfo'			=> '(hour, minute)',
	'TimeFormatSeconds'			=> 'The format of the exact time',
	'TimeFormatSecondsInfo'		=> '(hours, minutes, seconds)',
	'NameDateMacro'				=> 'The format of the <code>::@::</code> macro',
	'NameDateMacroInfo'			=> '(name, time), e.g. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Timezone',
	'TimezoneInfo'				=> 'Timezone to use for displaying times to users who are not logged in (guests). Logged in users set and can change their timezone it in their user settings.',
	'EnableDst'					=> 'Enable Summer Time/DST',
	'EnableDstInfo'				=> '',

	'Canonical'					=> 'Usar URLs totalmente canónicas',
	'CanonicalInfo'				=> 'Todos los enlaces se crean como URLs absolutos en la forma %1. Los URLs relativos a la raíz del servidor en la forma %2 deben ser preferidos.',
	'LinkTarget'				=> 'Where external links open',
	'LinkTargetInfo'			=> 'Abre cada enlace externo en una nueva ventana del navegador. Añade <code>target="_blank"</code> a la sintaxis del enlace.',
	'Noreferrer'				=> 'noreferrer',
	'NoreferrerInfo'			=> 'Requiere que el navegador no envíe un encabezado de referencia HTTP si el usuario sigue el hipervínculo. Añade <code>rel="noreferrer"</code> a la sintaxis del enlace.',
	'Nofollow'					=> 'nofollow',
	'NofollowInfo'				=> 'Instruct some search engines that the hyperlink should not influence the ranking of the links target in the search engines index. Adds <code>rel="nofollow"</code> to the link syntax.',
	'UrlsUnderscores'			=> 'Form addresses (URLs) with underscores',
	'UrlsUnderscoresInfo'		=> 'For example %1 becames %2 with this option.',
	'ShowSpaces'				=> 'Show spaces in WikiNames',
	'ShowSpacesInfo'			=> 'Show spaces in WikiNames, e.g. <code>MyName</code> being displayed as <code>My Name</code> with this option.',
	'NumerateLinks'				=> 'Numerate links in print view',
	'NumerateLinksInfo'			=> 'Numerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disable and visualize self-referencing links',
	'YouareHereTextInfo'		=> 'Visualizing links to the same page, try to <code>&lt;b&gt;####&lt;/b&gt;</code>, all links-to-self became not links, but bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Aquí puedes establecer o cambiar las páginas base del sistema que se usan en el Wiki. Por favor, asegúrese de no olvidar crear o cambiar las páginas correspondientes en el Wiki de acuerdo a su configuración aquí.',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Number of items per list',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> 'Foro Opciones',
	'ForumCluster'				=> 'Cluster Forum',
	'ForumClusterInfo'			=> 'Root cluster for forum section (action %1).',
	'ForumTopics'				=> 'Número de temas por página',
	'ForumTopicsInfo'			=> 'Número de temas mostrados en cada página de la lista en las secciones del foro.',
	'CommentsCount'				=> 'Número de comentarios por página',
	'CommentsCountInfo'			=> 'Número de comentarios mostrados en cada página de la lista de comentarios. Esto se aplica a todos los comentarios en el sitio, y no sólo a los publicados en el foro.',

	'NewsSection'				=> 'Section News',
	'NewsCluster'				=> 'Cluster for the News',
	'NewsClusterInfo'			=> 'Root cluster for news section (action %1).',
	'NewsLevels'				=> 'Depth of news pages from the root cluster',
	'NewsLevelsInfo'			=> 'Regular expression (SQL regexp-slang), specifying the number of intermediate levels of the news root cluster directly to the names of pages of news reports. (e.g. <code>[cluster]/[year]/[month]</code> -> <code>/.+/.+/.+</code>)',

	'LicenseSection'			=> 'Licencia',
	'DefaultLicense'			=> 'Licencia por defecto',
	'DefaultLicenseInfo'		=> 'Under which license should your content be released.',

	'EnableLicense'				=> 'Habilitar licencia',
	'EnableLicenseInfo'			=> 'Habilitar para mostrar información de licencia.',
	'LicensePerPage'			=> 'License per page',
	'LicensePerPageInfo'		=> 'Allow license per page, which the page owner can choose via page properties.',

	'ServicePagesSection'		=> 'Service pages',
	'RootPage'					=> 'Página principal',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',

	'PrivacyPage'				=> 'Privacy Policy',
	'PrivacyPageInfo'			=> 'La página con la Política de Privacidad del sitio.',

	'TermsPage'					=> 'Policies and Regulations',
	'TermsPageInfo'				=> 'The page with the rules of the site.',

	'SearchPage'				=> 'Buscar',
	'SearchPageInfo'			=> 'Page with the search form (action %1).',
	'RegistrationPage'			=> 'Registration',
	'RegistrationPageInfo'		=> 'Page new user registration (action %1).',
	'LoginPage'					=> 'User login',
	'LoginPageInfo'				=> 'Página de acceso al sitio (action %1).',
	'SettingsPage'				=> 'User Settings',
	'SettingsPageInfo'			=> 'Página personalizar el perfil de usuario (action %1).',
	'PasswordPage'				=> 'Cambiar Contraseña',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action %1).',
	'UsersPage'					=> 'Lista de usuarios',
	'UsersPageInfo'				=> 'Página con una lista de usuarios registrados (action %1).',
	'CategoryPage'				=> 'Categoría',
	'CategoryPageInfo'			=> 'Página con una lista de páginas categorizadas (action %1).',
	'TagPage'					=> 'Tag',
	'TagPageInfo'				=> 'Page with a list of tagged pages (action %1).',
	'GroupsPage'				=> 'Grupos',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action %1).',
	'ChangesPage'				=> 'Modificaciones recientes',
	'ChangesPageInfo'			=> 'Página con una lista de las últimas páginas modificadas (action %1).',
	'CommentsPage'				=> 'Últimos comentarios',
	'CommentsPageInfo'			=> 'Página con una lista de comentarios recientes en la página (action %1).',
	'RemovalsPage'				=> 'Páginas eliminadas',
	'RemovalsPageInfo'			=> 'Página con una lista de páginas eliminadas recientemente (action %1).',
	'WantedPage'				=> 'Wanted pages',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action %1).',
	'OrphanedPage'				=> 'Orphaned pages',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related links with the rest (action %1).',
	'SandboxPage'				=> 'Sandbox',
	'SandboxPageInfo'			=> 'Page where users can be trained in the use of wiki-markup.',
	'HelpPage'					=> 'Ayuda',
	'HelpPageInfo'				=> 'The documentation section for working with site tools.',
	'IndexPage'					=> 'Index',
	'IndexPageInfo'				=> 'Página con una lista de todas las páginas (action %1).',
	'RandomPage'				=> 'Aleatoria',
	'RandomPageInfo'			=> 'Carga una página aleatoria (action %1).',



	// Notification settings
	'NotificationSettingsInfo'	=> 'Parámetros para las notificaciones de la plataforma.',
	'NotificationSettingsUpdated'	=> 'Configuración de notificación actualizada',

	'EmailNotification'			=> 'Notificación por correo electrónico',
	'EmailNotificationInfo'		=> 'Permitir notificación por correo electrónico. Seleccione ON para habilitar las notificaciones por correo electrónico y OFF para deshabilitarlas. Tenga en cuenta que la desactivación de las notificaciones de correo electrónico no tiene ningún efecto en los correos electrónicos generados como parte del proceso de registro de usuarios.',
	'Autosubscribe'				=> 'Autosuscripción',
	'AutosubscribeInfo'			=> 'Permitir notificación por correo electrónico. Seleccione ON para habilitar las notificaciones por correo electrónico y OFF para deshabilitarlas. Firmar automáticamente una nueva página en el aviso del propietario de sus cambios.',

	'NotificationSection'		=> 'Configuración predeterminada de notificación al usuario',
	'NotifyPageEdit'			=> 'Notificar la edición de la página',
	'NotifyPageEditInfo'		=> 'Pendiente - Enviar una notificación por correo electrónico sólo para el primer cambio hasta que el usuario vuelva a visitar la página.',
	'NotifyMinorEdit'			=> 'Notificar a un menor de edad',
	'NotifyMinorEditInfo'		=> 'Envía notificaciones también para ediciones menores.',
	'NotifyNewComment'			=> 'Notificar nuevo comentario',
	'NotifyNewCommentInfo'		=> 'Pendiente - Envío de una notificación por correo electrónico sólo para el primer comentario hasta que el usuario vuelva a visitar la página.',

	'NotifyUserAccount'			=> 'Notificar una nueva cuenta de usuario',
	'NotifyUserAccountInfo'		=> 'El administrador será notificado cuando un nuevo usuario haya sido creado usando el formulario de registro.',
	'NotifyUpload'				=> 'Notificar la carga de archivos',
	'NotifyUploadInfo'			=> 'Los Moderadores serán notificados cuando un archivo haya sido cargado.',

	'PersonalMessagesSection'	=> 'Mensajes personales',
	'AllowIntercomDefault'		=> 'Permitir intercomunicación',
	'AllowIntercomDefaultInfo'	=> 'Habilitar esta opción permite a otros usuarios enviar mensajes personales a la dirección de correo electrónico del destinatario sin revelar la dirección.',
	'AllowMassemailDefault'		=> 'Permitir correo masivo',
	'AllowMassemailDefaultInfo'	=> 'Envía sólo mensajes a aquellos usuarios que permitieron a los administradores enviarles información por correo electrónico.',

	// Resync settings
	'Synchronize'				=> 'Sincronizar',
	'UserStatsSynched'			=> 'Estadísticas de usuario sincronizadas.',
	'PageStatsSynched'			=> 'Estadísticas de página sincronizadas.',
	'FeedsUpdated'				=> 'RSS-feeds actualizados.',
	'SiteMapCreated'			=> 'La nueva versión del mapa del sitio creado con éxito.',
	'ParseNextBatch'			=> 'Parse next batch of pages:',
	'WikiLinksRestored'			=> 'Wiki-enlaces restaurados.',

	'LogUserStatsSynched'		=> 'Estadísticas de usuarios sincronizadas',
	'LogPageStatsSynched'		=> 'Estadísticas de página sincronizadas',
	'LogFeedsUpdated'			=> 'Canales RSS sincronizados',
	'LogPageBodySynched'		=> 'Reparsed page body and links',

	'UserStats'					=> 'Estadísticas de usuarios',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'PageStats'					=> 'Estadísticas de página',
	'PageStatsInfo'				=> 'Las estadísticas de página (número de comentarios, archivos y revisiones) pueden diferir en algunas situaciones de los datos reales. <br>Esta operación permite actualizar las estadísticas a los datos actuales de la base de datos.',
	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'En el caso de la edición directa de las páginas de la base de datos, el contenido de las fuentes RSS puede no reflejar los cambios realizados. <br>Esta función sincroniza los canales RSS con el estado actual de la base de datos.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'Esta función sincroniza el XML-Sitemap con el estado actual de la base de datos.',
	'XmlSiteMapPeriod'			=> 'Period %1 days. Last written %2.',
	'XmlSiteMapView'			=> 'Show Sitemap in a new window.',

	'ReparseBody'				=> 'Reparse all pages',
	'ReparseBodyInfo'			=> 'Empties <code>body_r</code> in page table, so that each page gets rendered again on the next page view. This may be useful if you modified the formatter or changed the domain of your wiki.',
	'PreparsedBodyPurged'		=> 'Emptied <code>body_r</code> field in page table.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Realiza una re-renderización para todos los enlaces dentro del sitio y restaura el contenido de la tabla <code>page_link</code> y <code>file_link</code> en caso de daño o reubicación (esto puede llevar un tiempo considerable).',
	'RecompilePage'				=> 'Volver a compilar todas las páginas (extremadamente caro)',
	'ResyncOptions'				=> 'Opciones adicionales',
	'RecompilePageLimit'		=> 'Number of pages to parse at once.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Esta información se usa cuando el Sitio envía emails a sus usuarios. Por favor verifique que la dirección de email ingresada sea válida, cualquier rebote se reenviará a esa dirección. Si su host no provee un servicio de email nativo (utilizable por PHP), entonces use directamente SMTP. Esto requiere la dirección de un servidor apropiado (pregúntele a su ISP de ser necesario). Si (si, y solo si) el servidor requiere autentificación complete el usuario y contraseña. Por favor observe que solo se ofrece autentificación básica, otro tipo de implementación no es posible actualmente.',

	'EmailSettingsUpdated'		=> 'Configuración de correo electrónico actualizada',

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
	'TestEmailMessage'			=> 'El correo electrónico de prueba ha sido enviado.<br>Si no lo recibes, por favor revisa tú configuración de mensajes de correo electrónico.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Habilita automáticamente encriptación si el servidor publica encriptación TLS (luego de conectar al servidor), aunque no se haya configurado el modo de conexión para <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Método de autentificación para SMTP',
	'SmtpConnectionModeInfo'	=> 'Solo usado si se configura usuario/contraseña, pregúntele a su ISP si no está seguro de cual método usar.',
	'SmtpPassword'				=> 'Contraseña SMTP',
	'SmtpPasswordInfo'			=> 'Introduzca una contraseña solo si su servidor SMTP lo requiere.<br><em><strong>ADVERTENCIA:</strong> Esta contraseña será guardada como texto plano en la base de datos y será visible para cualquiera que tenga acceso a la misma o que pueda ver esta página de configuración.</em>',
	'SmtpPort'					=> 'Puerto servidor SMTP',
	'SmtpPortInfo'				=> 'Cámbielo solo si sabe que su servidor SMTP está en un puerto diferente. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Dirección servidor SMTP',
	'SmtpServerInfo'			=> 'Ten en cuenta que debes proporcionar el protocolo que utiliza tu servidor. Si estás utilizando SSL, tiene que ser <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> 'Configuración SMTP',
	'SmtpUsername'				=> 'Usuario SMTP',
	'SmtpUsernameInfo'			=> 'Solo introduzca un usuario si su servidor SMTP lo requiere.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Aquí puedes configurar los principales parámetros para archivos adjuntos y las categorías especiales asociadas.',
	'UploadSettingsUpdated'		=> 'Configuración de carga actualizada',

	'RightToUpload'				=> 'Derecho a cargar archivos',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belonging to the admins group can upload  files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadOnlyImages'			=> 'Permitir sólo la carga de imágenes',
	'UploadOnlyImagesInfo'		=> 'Permitir sólo la carga de archivos de imagen en la página.',
	'FileUploads'				=> 'Carga de archivos',
	'UploadMaxFilesize'			=> 'Tamaño máximo',
	'UploadMaxFilesizeInfo'		=> 'Tamaño máximo de cada archivo. Si este valor es 0, el tamaño del archivo para subir sólo estará limitado por la configuración de PHP.',
	'UploadQuota'				=> 'Máximo total para adjuntos',
	'UploadQuotaInfo'			=> 'Máximo en disco disponible para adjuntos en todo el sitio, <code>0</code> significa ilimitado.',
	'UploadQuotaUser'			=> 'Cuota de espacio por usuario',
	'UploadQuotaUserInfo'		=> 'Restricción de la cuota de almacenamiento que puede ser cargada por un usuario, siendo <code>0</code> ilimitado.',
	'CheckMimetype'				=> 'Comprobar archivos adjuntos',
	'CheckMimetypeInfo'			=> 'Algunos navegadores pueden ser engañados para que asuman un mimetype de archivos subibles incorrecto. Esta opción previene que tales archivos que puedan causar eso sean rechazados.',
	'TranslitFileName'			=> 'Transliterate file names',
	'TranslitFileNameInfo'		=> 'Si es aplicable y no hay necesidad de tener caracteres Unicode, se recomienda encarecidamente aceptar sólo caracteres alfanuméricos.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Crear vista en miniatura',
	'CreateThumbnailInfo'		=> 'Crear vista en miniatura siempre que sea posible.',
	'MaxThumbWidth'				=> 'Ancho máximo de la vista en miniatura en píxeles',
	'MaxThumbWidthInfo'			=> 'La mini-imagen generada no excederá este ancho.',
	'MinThumbFilesize'			=> 'Tamaño mínimo para vista en miniatura',
	'MinThumbFilesizeInfo'		=> 'No crear vista en miniatura para imágenes más pequeñas que esto.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Lista de páginas y archivos eliminados.
									Finally remove or restore the pages or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Palabras que serán automáticamente censuradas en su Wiki.',
	'FilterSettingsUpdated'		=> 'Configuración actualizada del filtro de spam',

	'WordCensoringSection'		=> 'Censura de palabras',
	'SPAMFilter'				=> 'Filtro de SPAM',
	'SPAMFilterInfo'			=> 'Habilitación del Filtro de SPAM',
	'WordList'					=> 'Lista de palabras',
	'WordListInfo'				=> 'Palabra o frase <code>fragmento</code> a incluir en la lista negra (una por línea)',

	// DB Convert module
	'Convert'					=> 'Convertir',
	'NoColumnsToConvert'		=> 'No hay columnas que convertir.',
	'NoTablesToConvert'			=> 'No hay tablas que convertir.',

	'LogDatabaseConverted'		=> 'Base de datos convertida',
	'ConversionTablesOk'		=> 'Conversión de las tablas seleccionadas con éxito.',

	'LogColumnsToStrict'		=> 'Converted columns to comply with the SQL strict mode',
	'ConversionColumnsOk'		=> 'Conversion of the selected columns successfully.',

	'ConvertTablesEngine'		=> 'Conversión de tablas de MyISAM a InnoDB',
	'ConvertTablesEngineInfo'	=> 'Si tiene tablas existentes que desea convertir a InnoDB para una mayor fiabilidad y escalabilidad, utilice la siguiente rutina. Estas tablas eran originalmente MyISAM, que antes era la tabla por defecto.',

	'DbVersionMin'				=> 'Requiere al menos MySQL 5.6.4, versión disponible',
	'DbEngineOk'				=> 'InnoDB está disponible.',
	'DbEngineMissing'			=> 'InnoDB no está disponible.',
	'EngineTable'				=> 'Tabla',
	'EngineDefault'				=> 'Default',
	'EngineColumn'				=> 'Column',
	'EngineTyp'					=> 'Type',

	'ConvertColumnsToStrict'	=> 'Conversión de columnas a SQL estricto',
	'ConvertTablesStrictInfo'	=> 'Si tiene tablas existentes que desea convertir para cumplir con el modo SQL srtict, utilice la siguiente rutina.',

	// Log module
	'LogFilterTip'				=> 'Filtrar eventos por criterios',
	'LogLevel'					=> 'Nivel',
	'LogLevelFilters'	=> [
		'1'		=> 'no menos que',
		'2'		=> 'no más que',
		'3'		=> 'igual',
	],
	'LogNoMatch'				=> 'No hay coincidencias',
	'LogDate'					=> 'Fecha',
	'LogEvent'					=> 'Evento',
	'LogUsername'				=> 'Nombre de usuario',
	'LogLevels'	=> [
		'1'		=> 'crítico',
		'2'		=> 'más alto',
		'3'		=> 'alto',
		'4'		=> 'medio',
		'5'		=> 'bajo',
		'6'		=> 'más bajo',
		'7'		=> 'depuración',
	],

	// Massemail module
	'MassemailInfo'				=> 'Desde aquí puedes enviar un email a todos los usuarios, o a los usuarios de un grupo específico. Para esto se enviará un email a la dirección administrativa proporcionada, con copia oculta a todos los receptores. Si el grupo de personas es muy grande, por favor se paciente después de pulsar en "Enviar" y no detengas el proceso por la mitad. Es normal que enviar un email masivo lleve algún tiempo, serás notificado cuando se complete el proceso',
	'LogMassemail'				=> 'Envío de mensajes %1 al grupo/usuario ',
	'MassemailSend'				=> 'Envío de correo masivo',

	'NoEmailMessage'			=> 'Tienes que introducir un mensaje.',
	'NoEmailSubject'			=> 'Tienes que especificar un tema para su mensaje.',
	'NoEmailRecipient'			=> 'Debe especificar por lo menos un usuario o grupo de usuarios.',

	'MassemailSection'			=> 'Correo electrónico masivo',
	'MessageSubject'			=> 'Sujeto',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Su mensaje',
	'YourMessageInfo'			=> 'Por favor, ten en cuenta que solo puede insertarse texto plano. Se eliminará cualquier código antes de enviar.',

	'NoUser'					=> 'No user',
	'NoUserGroup'				=> 'No user group',

	'SendToGroup'				=> 'Enviar a grupo',
	'SendToUser'				=> 'Enviar a usuario',
	'SendToUserInfo'			=> 'Envía sólo mensajes a aquellos usuarios que permitieron a los administradores enviarles información por correo electrónico. Esta opción está disponible en sus opciones de usuario en Notificaciones.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Mensaje de sistema actualizado',

	'SysMsgSection'				=> 'Mensaje de sistema',
	'SysMsg'					=> 'Mensaje de sistema',
	'SysMsgInfo'				=> 'Su texto aquí',

	'SysMsgType'				=> 'Type',
	'SysMsgTypeInfo'			=> 'Message type (CSS).',
	'EnableSysMsg'				=> 'Habilitar mensaje de sistema',
	'EnableSysMsgInfo'			=> 'Mostrar mensaje de sistema.',

	// User approval module
	'ApproveNotExists'			=> 'Por favor, seleccione al menos un usuario a través del botón Set.',

	'LogUserApproved'			=> 'Usuario ##%1## aprobado',
	'LogUserBlocked'			=> 'Usuario ##%1## bloqueado',
	'LogUserDeleted'			=> 'Usuario ##%1## eliminado de la base de datos',
	'LogUserCreated'			=> 'Creado un nuevo usuario ##%1##',
	'LogUserUpdated'			=> 'Usuario actualizado ##%1##',

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
	'BackupSettings'			=> 'Indique el esquema de backup deseado.<br>' .
									'El cluster de root no afecta al backup global de archivos y al backup de archivos de cache (al seleccionar siempre se guardan por completo).<br>' .
									'<br>' .
									'<strong>Atención</strong>: Las tablas de este backup no serán reestructurados para evitar pérdida de información al especificar el cluster de root, ' .
									'igual al realizar backup de solamente la estructura de tabla sin guardar los datos. ' .
									'Para realizar la conversión completa de las tablas al formato de backup debe realizar <em> el backup completo de base de datos (estructura y datos) sin especificar el cluster</em>.',
	'BackupCompleted'			=> 'Backup y archivación terminado.<br>' .
									'Archivo del backup guardado en subdirectorio %1.<br>' .
									'Use FTP para descargarlo (mantenga la estructura de diretorios y nombres de archivos al copiar).<br>' .
									'Para restaurar una copia del backup o remover un paquete, ingrese en <a href="%2">Restaurar base de datos</a>.',
	'LogSavedBackup'			=> 'Guardado backup de base de datos ##%1##',
	'Backup'					=> 'Backup',

	// DB Restore module
	'RestoreInfo'				=> 'Puede restaurar un backup existente o removerlo del servidor.',
	'ConfirmDbRestore'			=> '¿Desea restaurar la copia de seguridad %1?',
	'ConfirmDbRestoreInfo'		=> 'Por favor espere, esto puede durar unos minutos.',
	'RestoreWrongVersion'		=> 'Versión de WackoWiki incorrecta!',
	'BackupDelete'				=> '¿Está seguro de que desea eliminar la copia de seguridad %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Opciones adicionales de restaurar',
	'RestoreOptionsInfo'		=> '* Antes de restaurar el <strong>cluster backup</strong>, ' .
									'no se destruyen las tablas de destino (para evitar pérdida de información de los cluster que no tienen backup). ' .
									'Por lo tanto habrá registros duplicados durante el proceso de restauración. ' .
									'En el modo normal todos se reemplazarán por los registros desde el backup (usando la instrucción SQL <code>REPLACE</code>), ' .
									'pero si se marca esta casilla, se omiten todos los duplicados (se mantienen los registros actuales), ' .
									'y solamente se agregan en la tabla registros con claves nuevas (instrucción SQL <code>INSERT IGNORE</code>).<br>' .
									'<strong>Observación</strong>: Al restaurar el backup completo del sitio esta opción se ignora.<br>' .
									'<br>' .
									'** Si el backup contiene los archivos de usuario (global y por página, archivos cache, etc.), ' .
									'en modo normal serán sustituidos al rastaurar con igual nombre y en la misma ubicación de directorio. ' .
									'Esta opción permite guardar los archivos actuales y restaurar de un backup solamente los archivos nuevos (que faltan en el servidor).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignorar claves duplicadas de tabla (no reemplazar)',
	'IgnoreSameFiles'			=> 'Ignorar archivos iguales (no sobreescribir)',
	'NoBackupsAvailable'		=> 'No existe backup.',
	'BackupEntireSite'			=> 'Sitio completo',
	'BackupRestored'			=> 'Se restauró el backup, abajo se adjunta un reporte de resumen. Para eliminar este paquete de backup, presione',
	'BackupRemoved'				=> 'Se eliminó con éxito el backup seleccionado.',
	'LogRemovedBackup'			=> 'Backup de base de datos eliminado ##%1##',

	'RestoreStarted'			=> 'Initiated Restoration',
	'RestoreParameters'			=> 'Using parameters',
	'IgnoreDuplicatedKeys'		=> 'Ignore duplicated keys',
	'IgnoreDuplicatedFiles'		=> 'Ignore duplicated files',
	'SavedCluster'				=> 'Saved cluster',
	'DataProtection'			=> 'Data Protection - %1 omitted',
	'AssumeDropTable'			=> 'Assume %1',
	'RestoreTableStructure'		=> 'Restoring the structure of the table',
	'RunSqlQueries'				=> 'Perform SQL-instructions',
	'CompletedSqlQueries'		=> 'Completed. Processed instructions',
	'NoTableStructure'			=> 'The structure of the tables was not saved - skip',
	'RestoreRecords'			=> 'Restore the contents of tables',
	'ProcessTablesDump'			=> 'Just download and process tables dump',
	'Instruction'				=> 'Instruction',
	'RestoredRecords'			=> 'records',
	'RecordsRestoreDone'		=> 'Completed. Total entries',
	'SkippedRecords'			=> 'Data not saved - skip',
	'RestoringFiles'			=> 'Restoring files',
	'DecompressAndStore'		=> 'Decompress and store the contents of directories',
	'HomonymicFiles'			=> 'homonymic files',
	'RestoreSkip'				=> 'skip',
	'RestoreReplace'			=> 'replace',
	'RestoreFile'				=> 'File',
	'Restored'					=> 'restored',
	'Skipped'					=> 'skipped',
	'FileRestoreDone'			=> 'Completed. Total files',
	'FilesAll'					=> 'todo',
	'SkipFiles'					=> 'Files are not stored - skip',
	'RestoreDone'				=> 'RESTAURACIÓN REALIZADA',

	'BackupCreationDate'		=> 'Fecha de creación',
	'BackupPackageContents'		=> 'El contenido del paquete',
	'BackupRestore'				=> 'Restaurar',
	'BackupRemove'				=> 'Eliminar',
	'RestoreYes'				=> 'sí',
	'RestoreNo'					=> 'No',
	'LogDbRestored'				=> 'Copia de seguridad ##%1## de la base de datos restaurada.',

	// User module
	'UsersInfo'					=> 'Aquí puede cambiar la información de sus usuarios y ciertas opciones específicas.',

	'UsersAdded'				=> 'Usuario agregado',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> 'Edit',
	'UserEnabled'				=> 'Habilitado',
	'UsersAddNew'				=> 'Nuevo usuario',
	'UsersDelete'				=> '¿Estás seguro de que quieres eliminar el usuario %1?',
	'UsersDeleted'				=> 'Usuario %1 eliminado de la base de datos.',
	'UsersRename'				=> 'Renombrar usuario %1 a',
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

	'UserAccountNotify'			=> 'Notificar al usuario',
	'UserNotifySignup'			=> 'informar al usuario sobre la nueva cuenta',
	'UserVerifyEmail'			=> 'configurar el token de confirmación de correo electrónico y añadir un enlace para la verificación del correo electrónico',
	'UserReVerifyEmail'			=> 'Reenviar el token de confirmación del correo electrónico',

	// Groups module
	'GroupsInfo'				=> 'Desde este panel puedes administrar todos tus grupos de usuarios. Puede borrar, crear y editar grupos existentes. Además, puede elegir líderes de grupo, alternar entre estado de grupo abierto/oculto/cerrado y establecer el nombre y la descripción del grupo.',

	'LogMembersUpdated'			=> 'Miembros actualizados del grupo de usuarios',
	'LogMemberAdded'			=> 'Añadido miembro ##%1## al grupo ##%2##',
	'LogMemberRemoved'			=> 'Eliminado miembro ##%1## del grupo ##%2##',
	'LogGroupCreated'			=> 'Creó un nuevo grupo ##%1##',
	'LogGroupRenamed'			=> 'Group ##%1## renamed to ##%2##',
	'LogGroupRemoved'			=> 'Grupo eliminado ##%1##',

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
	'GroupsDeleted'				=> 'Grupo %1 eliminado de la base de datos y de todas las páginas.',
	'GroupsAdd'					=> 'Agregar grupo nuevo',
	'GroupsRename'				=> 'Renombrar el grupo %1',
	'GroupsRenameInfo'			=> '* Observación: El cambio afectará a todas las páginas con el grupo asignado.',
	'GroupsDelete'				=> 'Está seguro que desea eliminar el grupo %1?',
	'GroupsDeleteInfo'			=> '* Observación: El cambio afectará a todas los miembros del grupo.',
	'GroupsIsSystem'			=> 'El grupo %1 pertenece al sistema y no se puede eliminar.',
	'GroupsStoreButton'			=> 'Guardar Grupos',
	'GroupsEditInfo'			=> 'Marque el botón de radio para editar la lista de grupos.',

	'GroupAddMember'			=> 'Añadir miembro',
	'GroupRemoveMember'			=> 'Eliminar miembro',
	'GroupAddNew'				=> 'Añadir grupo',
	'GroupEdit'					=> 'Tratar grupo',
	'GroupDelete'				=> 'Eliminar grupo',

	'MembersAddNew'				=> 'Miembro nuevo',
	'MembersAdded'				=> 'Nuevo miembro agregado al grupo con éxito.',
	'MembersRemove'				=> 'Está seguro que desea remover el miembro %1?',
	'MembersRemoved'			=> 'Miembro eliminado del grupo.',
	'MembersDeleteInfo'			=> '* Observación: El cambio afectará a todos los miembros asignados al grupo.',

	// Statistics module
	'DbStatSection'				=> 'Estadísticas de base de datos',
	'DbTable'					=> 'Table',
	'DbRecords'					=> 'Records',
	'DbSize'					=> 'Size',
	'DbIndex'					=> 'Index',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'Sistema de archivos Estadísticas',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> 'Files',
	'FileSize'					=> 'Size',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Version informations',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Values',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Última actualización',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Server name',
	'WebServer'					=> 'Web server',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'SQL Modes Global',
	'SqlModesSession'			=> 'SQL Modes Session',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memory',
	'UploadFilesizeMax'			=> 'Upload max filesize',
	'PostMaxSize'				=> 'Post max size',
	'MaxExecutionTime'			=> 'Max execution time',
	'SessionPath'				=> 'Session path',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip compression',
	'PhpExtensions'				=> 'PHP extensions',
	'ApacheModules'				=> 'Apache modules',

	// DB repair module
	'DbRepairSection'			=> 'Reparar base de datos',
	'DbRepair'					=> 'Reparar base de datos',
	'DbRepairInfo'				=> 'Este script puede buscar automáticamente algunos problemas comunes de la base de datos y repararlos. La reparación puede llevar un tiempo, así que por favor, tenga paciencia.',

	'DbOptimizeRepairSection'	=> 'Reparación y optimización de la base de datos',
	'DbOptimizeRepair'			=> 'Reparación y optimización de la base de datos',
	'DbOptimizeRepairInfo'		=> 'Este script también puede intentar optimizar la base de datos. Esto mejora el rendimiento en algunas situaciones. La reparación y optimización de la base de datos puede llevar mucho tiempo y la base de datos se bloqueará mientras se optimiza.',

	'TableOk'					=> 'La tabla de %1 está bien.',
	'TableNotOk'				=> 'The %1 table is not okay. It is reporting the following error: %2. This script will attempt to repair this table&hellip;',
	'TableRepaired'				=> 'Reparó con éxito la tabla de %1.',
	'TableRepairFailed'			=> 'No se reparó la tabla de %1. <br>Error: %2',
	'TableAlreadyOptimized'		=> 'La tabla %1 ya está optimizada.',
	'TableOptimized'			=> 'Optimización exitosa de la tabla %1.',
	'TableOptimizeFailed'		=> 'No se pudo optimizar la tabla de %1. <br>Error: %2',
	'TableNotRepaired'			=> 'Algunos problemas de la base de datos no pudieron ser reparados.',
	'RepairsComplete'			=> 'Reparaciones completas',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Mostrar y corregir inconsistencias, borrar o asignar registros huérfanos a un nuevo usuario/valor.',
	'Inconsistencies'			=> 'Inconsistencias',
	'CheckDatabase'				=> 'Base de datos',
	'CheckDatabaseInfo'			=> 'Verifica si hay inconsistencias de registro en la base de datos.',
	'CheckFiles'				=> 'Ficheros',
	'CheckFilesInfo'			=> 'Busca ficheros abandonados, ficheros sin referencia en la tabla de ficheros.',
	'Records'					=> 'Registros',
	'InconsistenciesNone'		=> 'No se han encontrado inconsistencias en los datos.',
	'InconsistenciesDone'		=> 'Inconsistencias de datos resueltas.',
	'InconsistenciesRemoved'	=> 'Eliminadas las inconsistencias',
	'Check'						=> 'Verificar',
	'Solve'						=> 'Resolver',

	// Bad Behavior module
	'BbInfo'					=> 'Detecta y bloquea los accesos no deseados a la Web, niega el acceso automatizado de los robots de spam <br>Para más información, por favor visite la página principal de %1.',
	'BbEnable'					=> 'Activar Bad Behavior',
	'BbEnableInfo'				=> 'All other settings can be changed in the config folder %1.',
	'BbStats'					=> 'Bad Behavior ha bloqueado %1 intentos de acceso en los últimos 7 días.',

	'BbSummary'					=> 'Resumen',
	'BbLog'						=> 'Log',
	'BbSettings'				=> 'Settings',
	'BbWhitelist'				=> 'Whitelist',

	// --> Log
	'BbHits'					=> 'Hits',
	'BbRecordsFiltered'			=> 'Displaying %1 of %2 records filtered by',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Blocked',
	'BbPermitted'				=> 'Permitted',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbRecordsAll'				=> 'Displaying all %1 records',
	'BbShow'					=> 'Show',
	'BbIpDateStatus'			=> 'IP/Date/Status',
	'BbHeaders'					=> 'Headers',
	'BbEntity'					=> 'Entity',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Options saved.',
	'BbWhitelistHint'			=> 'Inappropriate whitelisting WILL expose you to spam, or cause Bad Behavior to stop functioning entirely! DO NOT WHITELIST unless you are 100% CERTAIN that you should.',
	'BbIpAddress'				=> 'IP Address',
	'BbIpAddressInfo'			=> 'IP address or CIDR format address ranges to be whitelisted (one per line)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL fragments beginning with the / after your web site hostname (one per line)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'User agent strings to be whitelisted (one per line)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Updated Bad Behavior settings',
	'BbLogRequest'				=> 'Logging HTTP request',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (recommended)',
	'BbLogOff'					=> 'Do not log (not recommended)',
	'BbSecurity'				=> 'Security',
	'BbStrict'					=> 'Strict checking',
	'BbStrictInfo'				=> 'blocks more spam but may block some people',
	'BbOffsiteForms'			=> 'Allow form postings from other web sites',
	'BbOffsiteFormsInfo'		=> 'required for OpenID; increases spam received',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'To use Bad Behavior\'s http:BL features you must have an %1',
	'BbHttpblKey'				=> 'http:BL Access Key',
	'BbHttpblThreat'			=> 'Minimum Threat Level (25 is recommended)',
	'BbHttpblMaxage'			=> 'Maximum Age of Data (30 is recommended)',
	'BbReverseProxy'			=> 'Reverse Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'If you are using Bad Behavior behind a reverse proxy, load balancer, HTTP accelerator, content cache or similar technology, enable the Reverse Proxy option.<br>' .
									'If you have a chain of two or more reverse proxies between your server and the public Internet, you must specify <em>all</em> of the IP address ranges (in CIDR format) of all of your proxy servers, load balancers, etc. Otherwise, Bad Behavior may be unable to determine the client\'s true IP address.<br>' .
									'In addition, your reverse proxy servers must set the IP address of the Internet client from which they received the request in an HTTP header. If you don\'t specify a header, %1 will be used. Most proxy servers already support X-Forwarded-For and you would then only need to ensure that it is enabled on your proxy servers. Some other header names in common use include %2 and %3.',
	'BbReverseProxyEnable'		=> 'Enable Reverse Proxy',
	'BbReverseProxyHeader'		=> 'Header containing Internet clients IP address',
	'BbReverseProxyAddresses'	=> 'IP address or CIDR format address ranges for your proxy servers (one per line)',


];
