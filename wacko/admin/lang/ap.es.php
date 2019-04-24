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
	'On'						=> 'On',
	'Off'						=> 'Off',
	'Mandatory'					=> 'Obligatorio',
	'Admin'						=> 'Admin',

	'MiscellaneousSection'		=> 'Miscel�neo',
	'MainSection'				=> 'Par�metros b�sicos',

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
		'name'		=> 'Notificaciones',
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
		'title'		=> 'Contenido recientemente eliminado',
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
		'title'		=> 'Sincronizaci�n de datos',
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
	'SiteNameInfo'				=> 'El t�tulo de este sitio, aparece en el t�tulo del navegador, encabezado del tema, notificaci�n por correo electr�nico, etc.',
	'SiteDesc'					=> 'Descripci�n del sitio:',
	'SiteDescInfo'				=> 'Suplemento al t�tulo del sitio que aparece en la cabecera de las p�ginas para explicar en pocas palabras de qu� se trata este sitio.',
	'AdminName'					=> 'Admin of Site',
	'AdminNameInfo'				=> 'Nombre de usuario, que es responsable del soporte general del sitio. Este nombre no se utiliza para determinar los derechos de acceso, pero es deseable que se corresponda con el nombre del administrador jefe del sitio.',
	'LanguageSection'			=> 'Idioma',
	'DefaultLanguage'			=> 'Idioma por defecto',
	'DefaultLanguageInfo'		=> 'Especifica el idioma de los mensajes que se muestran a los invitados no registrados, as� como la configuraci�n de la ubicaci�n y las reglas de transliteraci�n de direcciones de p�gina.',
	'MultiLanguage'				=> 'Soporte multilenguaje',
	'MultiLanguageInfo'			=> 'Permita la posibilidad de seleccionar un idioma p�gina por p�gina.',
	'AllowedLanguages'			=> 'Idiomas permitidos',
	'AllowedLanguagesInfo'		=> 'Se recomienda seleccionar s�lo el conjunto de idiomas que desea utilizar, de lo contrario se seleccionan todos los idiomas.',
	'CommentSection'			=> 'Comentarios',
	'AllowComments'				=> 'Permitir comentarios',
	'AllowCommentsInfo'			=> 'Habilitar comentarios s�lo para usuarios invitados o registrados o deshabilitarlos en todo el sitio.',
	'SortingComments'			=> 'Ordenar comentarios',
	'SortingCommentsInfo'		=> 'Cambia el orden en que se presentan los comentarios de la p�gina, ya sea con el comentario m�s reciente O el m�s antiguo en la parte superior.',
	'ToolbarSection'			=> 'Toolbar',
	'CommentsPanel'				=> 'Panel de comentarios',
	'CommentsPanelInfo'			=> 'La visualizaci�n por defecto de los comentarios en la parte inferior de la p�gina.',
	'FilePanel'					=> 'Panel de archivos',
	'FilePanelInfo'				=> 'La visualizaci�n predeterminada de los archivos adjuntos en la parte inferior de la p�gina.',
	'RatingPanel'				=> 'Rating panel',
	'RatingPanelInfo'			=> 'La pantalla predeterminada del panel de clasificaci�n en la parte inferior de la p�gina.',
	'TagsPanel'					=> 'Panel de etiquetas',
	'TagsPanelInfo'				=> 'La visualizaci�n por defecto del panel de etiquetas en la parte inferior de la p�gina.',

	'NavigationSection'			=> 'Navegaci�n',
	'HideRevisions'				=> 'Suprimir revisiones',
	'HideRevisionsInfo'			=> 'La visualizaci�n por defecto de las revisiones de la p�gina.',
	'ShowPermalink'				=> 'Mostrar Permalink',
	'ShowPermalinkInfo'			=> 'La visualizaci�n por defecto del enlace permanente para la versi�n actual de la p�gina.',
	'TocPanel'					=> 'Panel de contenido',
	'TocPanelInfo'				=> 'The default display table of contents panel of a page (may need support in the templates).',
	'SectionsPanel'				=> 'Sections panel',
	'SectionsPanelInfo'			=> 'By default display the panel of adjacent pages (requires support in the templates).',
	'DisplayingSections'		=> 'Displaying sections',
	'DisplayingSectionsInfo'	=> 'When the previous options, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>) or both, and other (<em>tree</em>).',
	'MenuItems'					=> 'Menu items',
	'MenuItemsInfo'				=> 'Default number of shown menu items (may need support in the templates).',
	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Enable feeds',
	'EnableFeedsInfo'			=> 'Turns on or off RSS feeds for the entire wiki.',
	'XmlSitemap'				=> 'XML Sitemap',
	'XmlSitemapInfo'			=> 'Create an XML file called %1 inside the xml folder. Generate a Sitemaps XML format compatible XML file. You might want to change the path to output it in your root folder as that is one of the requirements i.e. that the XML file is in the root folder. On the other hand you can also add the path to the sitemap in the robots.txt file in your root directory as follows:',
	'XmlSitemapTime'			=> 'Tiempo de generaci�n de sitemaps XML',
	'XmlSitemapTimeInfo'		=> 'Genera el Sitemap s�lo una vez en el n�mero de d�as dado, cero significa en cada cambio de p�gina.',
	'DiffModeSection'			=> 'Modos Diff',
	'DefaultDiffModeSetting'	=> 'Default diff mode',
	'DefaultDiffModeSettingInfo'=> 'Modo diff preseleccionado.',
	'AllowedDiffMode'			=> 'Modos de Diff permitidos',
	'AllowedDiffModeInfo'		=> 'Se recomienda seleccionar s�lo el conjunto de modos diff que desea utilizar, de lo contrario se seleccionan todos los modos diff.',
	'NotifyDiffMode'			=> 'Notificar modo diff',
	'NotifyDiffModeInfo'		=> 'Modo diff utilizado para las notificaciones en el cuerpo del correo electr�nico.',

	'EditingSection'			=> 'Editing',
	'EditSummary'				=> 'Resumen de edici�n',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Minor edit',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'ReviewSettings'			=> 'Review',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',
	'PublishAnonymously'		=> 'Permitir publicaci�n an�nima',
	'PublishAnonymouslyInfo'	=> 'Permitir que los usuarios publiquen preferiblemente de forma an�nima (para ocultar el nombre de usuario).',

	'DefaultRenameRedirect'		=> 'Al renombrar poner redirecci�n',
	'DefaultRenameRedirectInfo'	=> 'De forma predeterminada, ofrezca establecer una redirecci�n a la direcci�n anterior de la p�gina a la que se est� cambiando el nombre.',
	'StoreDeletedPages'			=> 'Mantener p�ginas eliminadas',
	'StoreDeletedPagesInfo'		=> 'Cuando elimine una p�gina, un comentario o un archivo, gu�rdelo en una secci�n especial, donde estar� disponible para su revisi�n y recuperaci�n durante m�s tiempo (como se describe a continuaci�n).',
	'KeepDeletedTime'			=> 'Tiempo de almacenamiento de las p�ginas borradas',
	'KeepDeletedTimeInfo'		=> 'El per�odo en d�as. S�lo tiene sentido con la opci�n anterior. Cero indica la posesi�n eterna (en este caso el administrador puede borrar el "carrito" manualmente).',
	'PagesPurgeTime'			=> 'Tiempo de almacenamiento de las revisiones de p�gina',
	'PagesPurgeTimeInfo'		=> 'Borra autom�ticamente las versiones anteriores dentro del n�mero de d�as dado. Si introduce cero, las versiones anteriores no se eliminar�n.',
	'EnableReferrers'			=> 'Habilitar referenciadores',
	'EnableReferrersInfo'		=> 'Permite almacenar y mostrar referencias externas.',
	'ReferrersPurgeTime'		=> 'Tiempo de almacenamiento de los referidos.',
	'ReferrersPurgeTimeInfo'	=> 'Keep history of invoking external pages no more than this number of days. Zero means the perpetual possession, but to actively visit the site this could lead to overcrowding in the database.',
	'AttachmentHandler'			=> 'Habilitar el manejador de archivos adjuntos',
	'AttachmentHandlerInfo'		=> 'Permite mostrar el manejador de archivos adjuntos.',
	'SearchEngineVisibility'	=> 'Bloquear los motores de b�squeda (Search Engine Visibility)',
	'SearchEngineVisibilityInfo'=> 'Bloquee los motores de b�squeda, pero permita que los visitantes normales. Anula la configuraci�n de la p�gina. <br>Desalentar a los motores de b�squeda para que no indexen este sitio, es responsabilidad de los motores de b�squeda cumplir con esta petici�n.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Configuraci�n predeterminada de visualizaci�n para el sitio.',
	'AppearanceSettingsUpdated'	=> 'Updated appearance settings.',

	'LogoOff'					=> 'Off',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo y t�tulo',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Logo del sitio',
	'SiteLogoInfo'				=> 'Su logotipo aparecer� normalmente en la esquina superior izquierda de la aplicaci�n. El tama�o m�ximo es de 2 MiB. Las dimensiones �ptimas son 255 p�xeles de ancho por 55 p�xeles de alto.',
	'LogoDimensions'			=> 'Dimensiones del logo',
	'LogoDimensionsInfo'		=> 'Ancho y alto del Logo mostrado.',
	'LogoDisplayMode'			=> 'Modo de visualizaci�n del logo',
	'LogoDisplayModeInfo'		=> 'Define la apariencia del Logotipo. El valor predeterminado est� desactivado.',
	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Sitio Favicon',
	'SiteFaviconInfo'			=> 'El icono de acceso directo, o favicon, se muestra en la barra de direcciones, pesta�as y marcadores de la mayor�a de los navegadores. Esto invalidar� el favicon de su tema.',
	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Tema',
	'ThemeInfo'					=> 'El dise�o de la plantilla que el sitio utiliza por defecto.',
	'ThemesAllowed'				=> 'Temas permitidos',
	'ThemesAllowedInfo'			=> 'Seleccione los temas permitidos, que el usuario puede elegir, de lo contrario se permiten todos los temas disponibles.',
	'ThemesPerPage'				=> 'Temas por p�gina',
	'ThemesPerPageInfo'			=> 'Permitir temas por p�gina, que el propietario de la p�gina puede elegir a trav�s de las propiedades de la p�gina.',

	// System settings
	'SystemSettingsInfo'		=> 'Grupo de par�metros responsables de la plataforma de ajuste fino. No los cambie a menos que tenga confianza en sus acciones.',
	'SystemSettingsUpdated'		=> 'Actualizaci�n de la configuraci�n del sistema',

	'DebugModeSection'			=> 'Modo de depuraci�n',
	'DebugMode'					=> 'Modo de depuraci�n',
	'DebugModeInfo'				=> 'Fixation and the withdrawal of telemetry data on the time of the program. Note: the full detail of the regime imposes high demands on available memory, especially in demanding operations such as backup and restore the database.',
	'DebugModes'	=> [
		'0'		=> 'debugging is off',
		'1'		=> 'only the total execution time',
		'2'		=> 'full-time',
		'3'		=> 'full detail (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Threshold performance RDBMS',
	'DebugSqlThresholdInfo'		=> 'In the detailed debug mode to record only the queries take longer than the number of seconds.',
	'DebugAdminOnly'			=> 'Diagn�stico cerrado',
	'DebugAdminOnlyInfo'		=> 'Mostrar los datos de depuraci�n del programa (y del SGBD) s�lo para el administrador.',

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
	'AnonymizeIpInfo'			=> 'Anonimizar direcciones IP donde sea aplicable como p�gina, revisi�n o referencias.',

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
	'SessionStorageInfo'			=> 'Esta opci�n define d�nde se almacenan los datos de la sesi�n. De forma predeterminada, se selecciona el almacenamiento de archivos o de sesiones de base de datos.',
	'SessionModes'	=> [
		'1'		=> 'Archivo',
		'2'		=> 'Base de datos',
	],

	'RewriteMode'					=> 'Usar <code>mod_rewrite</code>',
	'RewriteModeInfo'				=> 'If your web server supports this feature, turn to get "beautiful" the addresses of pages.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Par�metros responsables del control de acceso y permisos.',
	'PermissionsSettingsUpdated'	=> 'Configuraci�n de permisos actualizada',

	'PermissionsSection'		=> 'Derechos y privilegios',
	'ReadRights'				=> 'Derechos de lectura por defecto',
	'ReadRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine parental rights.',
	'WriteRights'				=> 'Derechos de escritura por defecto',
	'WriteRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine the parental rights.',
	'CommentRights'				=> 'Derechos de comentario por defecto',
	'CommentRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine the parental rights.',
	'CreateRights'				=> 'Crear derechos de una subp�gina por defecto',
	'CreateRightsInfo'			=> 'Define the tolerance for the establishment of root pages and assign pages for which we can not determine the parental rights.',
	'UploadRights'				=> 'Derechos de carga por defecto',
	'UploadRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine parental rights.',
	'RenameRights'				=> 'Global rename right',
	'RenameRightsInfo'			=> 'List for admission to the possibility of free rename (move) pages.',

	'LockAcl'					=> 'Lock all ACL to read only',
	'LockAclInfo'				=> '<span class="cite">Overwrites the acl settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period for security reasons or as a emergency response.',
	'HideLocked'				=> 'Esconder p�ginas inaccesibles',
	'HideLockedInfo'			=> 'Si el usuario no tiene permiso para leer la p�gina, oc�ltela en diferentes listas de p�ginas (sin embargo, el enlace colocado en el texto, seguir� siendo visible).',
	'RemoveOnlyAdmins'			=> 'S�lo los administradores pueden eliminar p�ginas',
	'RemoveOnlyAdminsInfo'		=> 'Denegar todas las p�ginas, excepto los administradores, para eliminarlas. En el primer l�mite se aplica a los propietarios de p�ginas normales.',
	'OwnersRemoveComments'		=> 'Los propietarios de las p�ginas pueden eliminar comentarios',
	'OwnersRemoveCommentsInfo'	=> 'Permite a los propietarios de p�ginas moderar los comentarios en sus p�ginas.',
	'OwnersEditCategories'		=> 'Owners can edit page categories',
	'OwnersEditCategoriesInfo'	=> 'Allow owners to modify the pages category list of your site (add words, delete words), assigns to a page.',
	'TermHumanModeration'		=> 'Term human moderation',
	'TermHumanModerationInfo'	=> 'Moderators can edit comments, only if they were set up at most as many days ago (this restriction does not apply to the last comment in the topic).',

	'UserCanDeleteAccount'		=> 'Permitir a los usuarios eliminar sus propias cuentas',

	// Security settings
	'SecuritySettingsInfo'		=> 'Par�metros responsables de la seguridad general de la plataforma, restricciones de seguridad y subsistemas de seguridad adicionales.',
	'SecuritySettingsUpdated'	=> 'Configuraci�n de seguridad actualizada',

	'AllowRegistration'			=> 'Reg�strese en l�nea',
	'AllowRegistrationInfo'		=> 'Registro continuo de usuarios. Desactivar la opci�n evitar� el registro gratuito, sin embargo, el administrador del sitio podr� registrar a otros usuarios por su cuenta.',
	'ApproveNewUser'			=> 'Aprobar nuevos usuarios',
	'ApproveNewUserInfo'		=> 'Permite a los administradores aprobar a los usuarios una vez que se registran. S�lo los usuarios aprobados podr�n iniciar sesi�n en el sitio.',
	'PersistentCookies'			=> 'Cookies persistentes',
	'PersistentCookiesInfo'		=> 'Permitir cookies persistentes.',
	'AntiDupe'					=> 'Anti-clone',
	'AntiDupeInfo'				=> 'Disable register on the website under the names, <span class="underline">like</span> on the names of existing users (guests also can not use similar names for the signature comments). When this option is checked only <span class="underline">identical</span> names.',
	'DisableWikiName'			=> 'Desactivar NombreWiki',
	'DisableWikiNameInfo'		=> 'Desactivar el uso obligatorio de NombreWiki. Permite registrar usuarios con apodos tradicionales, no forzado NameSurname.',
	'AllowEmailReuse'			=> 'Permitir la reutilizaci�n de la direcci�n de correo electr�nico',
	'AllowEmailReuseInfo'		=> 'Diferentes usuarios pueden registrarse con la misma direcci�n de correo electr�nico.',
	'UsernameLength'			=> 'Longitud del nombre de usuario',
	'UsernameLengthInfo'		=> 'N�mero m�nimo y m�ximo de caracteres en los nombres de usuario.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Habilitar Captcha',
	'EnableCaptchaInfo'			=> 'Si est� habilitado, Captcha se mostrar� en los siguientes casos o si se alcanza un umbral de seguridad.',
	'CaptchaComment'			=> 'Nuevo comentario',
	'CaptchaCommentInfo'		=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before posting the comment.',
	'CaptchaPage'				=> 'Nueva p�gina',
	'CaptchaPageInfo'			=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before creating a new pages.',
	'CaptchaEdit'				=> 'Editar p�gina',
	'CaptchaEditInfo'			=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before editing pages.',
	'CaptchaRegistration'		=> 'Inscripciones',
	'CaptchaRegistrationInfo'	=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before registering.',

	'TlsSection'				=> 'TLS Settings',
	'TlsConnection'				=> 'TLS-Connection',
	'TlsConnectionInfo'			=> 'Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS-certificate on the server, otherwise you will lose access to the admin panel!</span><br>It also determines if the the Cookie Secure Flag is set, the <code>secure</code> flag specifies whether cookies should only be sent over secure connections.',
	'TlsImplicit'				=> 'Mandatory TLS',
	'TlsImplicitInfo'			=> 'Reconectar por la fuerza el cliente de HTTP a HTTPS. Con la opci�n desactivada, el cliente puede navegar por el sitio a trav�s de un canal HTTP abierto.',

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
	'PwdMinChars'				=> 'Longitud m�nima de la contrase�a',
	'PwdMinCharsInfo'			=> 'Las contrase�as m�s largas son necesariamente m�s seguras que las m�s cortas (por ejemplo, de 12 a 16 caracteres). <br>Se recomienda el uso de frases de contrase�a en lugar de contrase�as.',
	'AdminPwdMinChars'			=> 'Longitud m�nima de la contrase�a de administrador',
	'AdminPwdMinCharsInfo'		=> 'Las contrase�as m�s largas son necesariamente m�s seguras que las m�s cortas (por ejemplo, de 15 a 20 caracteres). <br>Se recomienda el uso de frases de contrase�a en lugar de contrase�as.',
	'PwdCharComplexity'			=> 'La complejidad de la contrase�a requerida',
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
	'MaxLoginAttempts'			=> 'N�mero m�ximo de intentos de inicio de sesi�n por nombre de usuario',
	'MaxLoginAttemptsInfo'		=> 'El n�mero de intentos de inicio de sesi�n permitidos para una sola cuenta antes de que se active la tarea anti-spambot. Introduzca 0 para evitar que se active la tarea anti-spambot para cuentas de usuario distintas.',
	'IpLoginLimitMax'			=> 'N�mero m�ximo de intentos de inicio de sesi�n por direcci�n IP',
	'IpLoginLimitMaxInfo'		=> 'El umbral de intentos de inicio de sesi�n permitido desde una �nica direcci�n IP antes de que se active una tarea anti-spambot. Introduzca 0 para evitar que la tarea anti-spambot sea activada por las direcciones IP.',

	'LogSection'				=> 'Log settings',
	'LogLevel'					=> 'Using logging',
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
	'LogDefaultShowInfo'		=> 'Los eventos de prioridad m�nima visualizados en el log por defecto.',
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
	'FormTokenTime'				=> 'Tiempo m�ximo para enviar formularios',
	'FormTokenTimeInfo'			=> 'The time a user has to submit a form (in seconds).<br> Use -1 to disable. Note that a form might become invalid if the session expires, regardless of this setting.',

	'SessionLength'				=> 'Term login cookie',
	'SessionLengthInfo'			=> 'The lifetime of the user cookie login by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of the new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications',
	'IntercomDelayInfo'			=> 'The minimum delay between sending a private message user connection (in seconds).',
	'RegistrationDelay'			=> 'Time threshold for registering',
	'RegistrationDelayInfo'		=> 'El umbral de tiempo m�nimo para rellenar el formulario de registro para distinguir a los robots de los humanos (en segundos).',

	//Formatter settings
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
	'TikiLinks'					=> 'Disable Tikilinks',
	'TikiLinksInfo'				=> 'Disables linking for <code>Double.CamelCaseWords</code>.',
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

	'LinkTarget'				=> 'Where external links open',
	'LinkTargetInfo'			=> 'Opens each external link in a new browser window. Adds <code>target="_blank"</code> to the link syntax.',
	'Noreferrer'				=> 'noreferrer',
	'NoreferrerInfo'			=> 'Requires that the browser should not send an HTTP referer header if the user follows the hyperlink. Adds <code>rel="noreferrer"</code> to the link syntax.',
	'Nofollow'					=> 'nofollow',
	'NofollowInfo'				=> 'Instruct some search engines that the hyperlink should not influence the ranking of the link\'s target in the search engine\'s index. Adds <code>rel="nofollow"</code> to the link syntax.',
	'UrlsUnderscores'			=> 'Form addresses (URLs) with underscores',
	'UrlsUnderscoresInfo'		=> 'For example <code>http://[..]/WackoWiki</code> becames <code>http://[..]/Wacko_Wiki</code> with this option.',
	'ShowSpaces'				=> 'Show spaces in WikiNames',
	'ShowSpacesInfo'			=> 'Show spaces in WikiNames, e.g. <code>MyName</code> beeing displayed as <code>My Name</code> with this option.',
	'NumerateLinks'				=> 'Numerate links in print view',
	'NumerateLinksInfo'			=> 'Numerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disable and visualize self-referencing links',
	'YouareHereTextInfo'		=> 'Visualizing links to the same page, try to <code>&lt;b&gt;####&lt;/b&gt;</code>, all links-to-self became not links, but bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> '',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Number of items per list',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster Forum',
	'ForumClusterInfo'			=> 'Address of the index (main) page of the forum.',
	'ForumTopics'				=> 'Number of topics per page',
	'ForumTopicsInfo'			=> 'Number of topics displayed on each page of the list in the forum sections.',
	'CommentsCount'				=> 'Number of comments per page',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page list of comments. This applies to all the comments on the site, and not just posted in the forum.',

	'NewsSection'				=> 'Section News',
	'NewsCluster'				=> 'Cluster for the News',
	'NewsClusterInfo'			=> 'Root cluster for news section.',
	'NewsLevels'				=> 'Depth of news pages from the root cluster',
	'NewsLevelsInfo'			=> 'Regular expression (SQL regexp-slang), specifying the number of intermediate levels of the news root cluster directly to the names of pages of news reports. (e.g. <code>[cluster]/[year]/[month]</code> -> <code>/.+/.+/.+</code>)',

	'LicenseSection'			=> 'Licencia',
	'DefaultLicense'			=> 'Licencia por defecto',
	'DefaultLicenseInfo'		=> 'Under which license should your content be released.',

	'EnableLicense'				=> 'Habilitar licencia',
	'EnableLicenseInfo'			=> 'Habilitar para mostrar informaci�n de licencia.',
	'LicensePerPage'			=> 'License per page',
	'LicensePerPageInfo'		=> 'Allow license per page, which the page owner can choose via page properties.',

	'ServicePagesSection'		=> 'Service pages',
	'RootPage'					=> 'Home page',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',

	'PrivacyPage'				=> 'Privacy Policy',
	'PrivacyPageInfo'			=> 'The page with the Privacy Policy of the site.',

	'TermsPage'					=> 'Policies and Regulations',
	'TermsPageInfo'				=> 'The page with the rules of the site.',

	'SearchPage'				=> 'Buscar',
	'SearchPageInfo'			=> 'Page with the search form (action <code>{{search}}</code>).',
	'RegistrationPage'			=> 'Register on our site',
	'RegistrationPageInfo'		=> 'Page new user registration (action <code>{{registration}}</code>).',
	'LoginPage'					=> 'User login',
	'LoginPageInfo'				=> 'Login page on the site (action <code>{{login}}</code>).',
	'SettingsPage'				=> 'User Settings',
	'SettingsPageInfo'			=> 'Page customize the user profile (action <code>{{usersettings}}</code>).',
	'PasswordPage'				=> 'Change Password',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action <code>{{changepassword}}</code>).',
	'UsersPage'					=> 'Lista de usuarios',
	'UsersPageInfo'				=> 'Page with a list of registered users (action <code>{{users}}</code>).',
	'CategoryPage'				=> 'Category',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action <code>{{category}}</code>).',
	'TagPage'					=> 'Tag',
	'TagPageInfo'				=> 'Page with a list of tagged pages (action <code>{{tag}}</code>).',
	'GroupsPage'				=> 'Grupos',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action <code>{{usergroups}}</code>).',
	'ChangesPage'				=> 'Recent changes',
	'ChangesPageInfo'			=> 'Page with a list of the last modified pages (action <code>{{changes}}</code>).',
	'CommentsPage'				=> 'Recent comments',
	'CommentsPageInfo'			=> 'Page with a list of recent comment on the page (action <code>{{commented}}</code>).',
	'RemovalsPage'				=> 'P�ginas eliminadas',
	'RemovalsPageInfo'			=> 'Page with a list of recently deleted pages (action <code>{{deleted}}</code>).',
	'WantedPage'				=> 'Wanted pages',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action <code>{{wanted}}</code>).',
	'OrphanedPage'				=> 'Orphaned pages',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related links with the rest (action <code>{{orphaned}}</code>).',
	'SandboxPage'				=> 'Sandbox',
	'SandboxPageInfo'			=> 'Page where users can be trained in the use of wiki-markup.',
	'HelpPage'					=> 'Ayuda',
	'HelpPageInfo'				=> 'The documentation section for working with site tools.',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Par�metros para las notificaciones de la plataforma.',
	'NotificationSettingsUpdated'	=> 'Configuraci�n de notificaci�n actualizada',

	'EmailNotification'			=> 'Notificaci�n por correo electr�nico',
	'EmailNotificationInfo'		=> 'Permitir notificaci�n por correo electr�nico. Seleccione ON para habilitar las notificaciones por correo electr�nico y OFF para deshabilitarlas. Tenga en cuenta que la desactivaci�n de las notificaciones de correo electr�nico no tiene ning�n efecto en los correos electr�nicos generados como parte del proceso de registro de usuarios.',
	'Autosubscribe'				=> 'Autosuscripci�n',
	'AutosubscribeInfo'			=> 'Permitir notificaci�n por correo electr�nico. Seleccione ON para habilitar las notificaciones por correo electr�nico y OFF para deshabilitarlas. Firmar autom�ticamente una nueva p�gina en el aviso del propietario de sus cambios.',

	'NotificationSection'		=> 'Configuraci�n predeterminada de notificaci�n al usuario',
	'NotifyPageEdit'			=> 'Notificar la edici�n de la p�gina',
	'NotifyPageEditInfo'		=> 'Pendiente - Enviar una notificaci�n por correo electr�nico s�lo para el primer cambio hasta que el usuario vuelva a visitar la p�gina.',
	'NotifyMinorEdit'			=> 'Notificar a un menor de edad',
	'NotifyMinorEditInfo'		=> 'Env�a notificaciones tambi�n para ediciones menores.',
	'NotifyNewComment'			=> 'Notificar nuevo comentario',
	'NotifyNewCommentInfo'		=> 'Pendiente - Env�o de una notificaci�n por correo electr�nico s�lo para el primer comentario hasta que el usuario vuelva a visitar la p�gina.',

	'NotifyUserAccount'			=> 'Notificar una nueva cuenta de usuario',
	'NotifyUserAccountInfo'		=> 'El administrador ser� notificado cuando un nuevo usuario haya sido creado usando el formulario de registro.',
	'NotifyUpload'				=> 'Notificar la carga de archivos',
	'NotifyUploadInfo'			=> 'Los Moderadores ser�n notificados cuando un archivo haya sido cargado.',

	'PersonalMessagesSection'	=> 'Mensajes personales',
	'AllowIntercomDefault'		=> 'Allow Intercom',
	'AllowIntercomDefaultInfo'	=> 'Habilitar esta opci�n permite a otros usuarios enviar mensajes personales a la direcci�n de correo electr�nico del destinatario sin revelar la direcci�n.',
	'AllowMassemailDefault'		=> 'Allow Massemail',
	'AllowMassemailDefaultInfo'	=> 'Env�a s�lo mensajes a aquellos usuarios que permitieron a los administradores enviarles informaci�n por correo electr�nico.',

	// Resync settings
	'Synchronize'				=> 'Sincronizar',
	'UserStatsSynched'			=> 'Estad�sticas de usuario sincronizadas.',
	'PageStatsSynched'			=> 'Estad�sticas de p�gina sincronizadas.',
	'FeedsUpdated'				=> 'RSS-feeds actualizados.',
	'SiteMapCreated'			=> 'La nueva versi�n del mapa del sitio creado con �xito.',
	'WikiLinksRestored'			=> 'Wiki-enlaces restaurados.',

	'LogUserStatsSynched'		=> 'Estad�sticas de usuarios sincronizadas',
	'LogPageStatsSynched'		=> 'Estad�sticas de p�gina sincronizadas',
	'LogFeedsUpdated'			=> 'Synchronized RSS feeds',
	'LogPageBodySynched'		=> 'Reparsed page body and links',

	'UserStats'					=> 'Estad�sticas de usuarios',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'PageStats'					=> 'Estad�sticas de p�gina',
	'PageStatsInfo'				=> 'Page statistics (number of comments, files and revisions) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'In the case of direct editing of pages in the database, the content of RSS-feeds may not reflect the changes made. <br>This function synchronizes the RSS-channels with the current state of the database.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'Esta funci�n sincroniza el XML-Sitemap con el estado actual de la base de datos.',
	'XmlSiteMapPeriod'			=> 'Period %1 days. Last written %2.',
	'XmlSiteMapView'			=> 'Show Sitemap in a new window.',
	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Performs a re-rendering for all intrasite links and restores the contents of the table <code>page_link</code> and <code>file_link</code> in the event of damage or relocation (this can take considerable time).',
	'RecompilePage'				=> 'Volver a compilar todas las p�ginas (extremadamente caro)',
	'ResyncOptions'				=> 'Opciones adicionales',

	// Email settings
	'EmaiSettingsInfo'			=> 'Esta informaci�n se usa cuando el Sitio env�a emails a sus usuarios. Por favor verifique que la direcci�n de email ingresada sea v�lida, cualquier rebote se reenviar� a esa direcci�n. Si su host no provee un servicio de email nativo (utilizable por PHP), entonces use directamente SMTP. Esto requiere la direcci�n de un servidor apropiado (preg�ntele a su ISP de ser necesario). Si (si, y solo si) el servidor requiere autentificaci�n complete el usuario y contrase�a. Por favor observe que solo se ofrece autentificaci�n b�sica, otro tipo de implementaci�n no es posible actualmente.',

	'EmailSettingsUpdated'		=> 'Configuraci�n de correo electr�nico actualizada',

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
	'TestEmailMessage'			=> 'El correo electr�nico de prueba ha sido enviado.<br>Si no lo recibes, por favor revisa t� configuraci�n de mensajes de correo electr�nico.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Habilita autom�ticamente encriptaci�n si el servidor publica encriptaci�n TLS (luego de conectar al servidor), aunque no se haya configurado el modo de conexi�n para <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'M�todo de autentificaci�n para SMTP',
	'SmtpConnectionModeInfo'	=> 'Solo usado si se configura usuario/contrase�a, preg�ntele a su ISP si no est� seguro de cual m�todo usar.',
	'SmtpPassword'				=> 'Contrase�a SMTP',
	'SmtpPasswordInfo'			=> 'Introduzca una contrase�a solo si su servidor SMTP lo requiere.<br><em><strong>ADVERTENCIA:</strong> Esta contrase�a ser� guardada como texto plano en la base de datos y ser� visible para cualquiera que tenga acceso a la misma o que pueda ver esta p�gina de configuraci�n.</em>',
	'SmtpPort'					=> 'Puerto servidor SMTP',
	'SmtpPortInfo'				=> 'C�mbielo solo si sabe que su servidor SMTP est� en un puerto diferente. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Direcci�n servidor SMTP',
	'SmtpServerInfo'			=> 'Ten en cuenta que debes proporcionar el protocolo que utiliza tu servidor. Si est�s utilizando SSL, tiene que ser <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> 'Configuraci�n SMTP',
	'SmtpUsername'				=> 'Usuario SMTP',
	'SmtpUsernameInfo'			=> 'Solo introduzca un usuario si su servidor SMTP lo requiere.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Aqu� puedes configurar los principales par�metros para archivos adjuntos y las categor�as especiales asociadas.',
	'UploadSettingsUpdated'		=> 'Configuraci�n de carga actualizada',

	'RightToUpload'				=> 'Derecho a cargar archivos',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belongig to admins group can upload the files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadOnlyImages'			=> 'Permitir s�lo la carga de im�genes',
	'UploadOnlyImagesInfo'		=> 'Permitir s�lo la carga de archivos de imagen en la p�gina.',
	'FileUploads'				=> 'Carga de archivos',
	'UploadMaxFilesize'			=> 'Tama�o m�ximo',
	'UploadMaxFilesizeInfo'		=> 'Tama�o m�ximo de cada archivo. Si este valor es 0, el tama�o del archivo para subir s�lo estar� limitado por la configuraci�n de PHP.',
	'UploadQuota'				=> 'M�ximo total para adjuntos',
	'UploadQuotaInfo'			=> 'M�ximo en disco disponible para adjuntos en todo el sitio, <code>0</code> significa ilimitado.',
	'UploadQuotaUser'			=> 'Cuota de espacio por usuario',
	'UploadQuotaUserInfo'		=> 'Restricci�n de la cuota de almacenamiento que puede ser cargada por un usuario, siendo <code>0</code> ilimitado.',
	'CheckMimetype'				=> 'Comprobar archivos adjuntos',
	'CheckMimetypeInfo'			=> 'Algunos navegadores pueden ser enga�ados para que asuman un mimetype de archivos subibles incorrecto. Esta opci�n previene que tales archivos que puedan causar eso sean rechazados.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Crear vista en miniatura',
	'CreateThumbnailInfo'		=> 'Crear vista en miniatura siempre que sea posible.',
	'MaxThumbWidth'				=> 'Ancho m�ximo de la vista en miniatura en p�xeles',
	'MaxThumbWidthInfo'			=> 'La mini-imagen generada no exceder� este ancho.',
	'MinThumbFilesize'			=> 'Tama�o m�nimo para vista en miniatura',
	'MinThumbFilesizeInfo'		=> 'No crear vista en miniatura para im�genes m�s peque�as que esto.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Lista de p�ginas y archivos eliminados.
									Finally remove or restore the pages or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Palabras que ser�n autom�ticamente censuradas en su Wiki.',
	'FilterSettingsUpdated'		=> 'Configuraci�n actualizada del filtro de spam',

	'WordCensoringSection'		=> 'Censura de palabras',
	'SPAMFilter'				=> 'Filtro de SPAM',
	'SPAMFilterInfo'			=> 'Habilitaci�n del Filtro de SPAM',
	'WordList'					=> 'Lista de palabras',
	'WordListInfo'				=> 'Palabra o frase <code>fragmento</code> a incluir en la lista negra (una por l�nea)',

	// DB Convert module
	'Convert'					=> 'Convert',
	'NoColumnsToConvert'		=> 'No columns to convert.',
	'NoTablesToConvert'			=> 'No tables to convert.',

	'LogDatabaseConverted'		=> 'Database converted',
	'ConversionTablesOk'		=> 'Conversion of the selected tables successfully.',

	'LogColumsToStrict'			=> 'Converted colums to comply with the SQL strict mode',
	'ConversionColumnsOk'		=> 'Conversion of the selected columns successfully.',

	'ConvertTablesEngine'		=> 'Converting Tables from MyISAM to InnoDB/XtraDB',
	'ConvertTablesEngineInfo'	=> 'If you have existing tables, that you want to convert to InnoDB/XtraDB* for better reliability and scalability, use the following routine. These tables were originally MyISAM, which was formerly the default.',
	'ConvertTablesEngineHint'	=> '* XtraDB is an enhanced version of the InnoDB storage engine, designed to better scale on modern hardware, and it includes a variety of other features useful in high performance environments.<br><br>It is fully backwards compatible, and it identifies itself to MariaDB as "<code>ENGINE=InnoDB</code>" (just like InnoDB), and so can be used as a drop-in replacement for standard InnoDB.',

	'DbVersion'					=> 'Requires at least MySQL 5.6.4, available version',
	'DbEngineOk'				=> 'InnoDB/XtraDB is available.',
	'DbEngineMissing'			=> 'InnoDB / XtraDB is not available.',
	'EngineTable'				=> 'Table',
	'EngineDefault'				=> 'Default',
	'EngineColumn'				=> 'Column',
	'EngineTyp'					=> 'Type',

	'ConvertColumnsToStrict'	=> 'Converting Columns to SQL strict',
	'ConvertTablesStrictInfo'	=> 'If you have existing tables, that you want to convert to comply with the SQL srtict mode, use the following routine.',

	// Log module
	'LogFilterTip'				=> 'Filtrar eventos por criterios',
	'LogLevel'					=> 'Nivel',
	'LogLevelFilters'	=> [
		'1'		=> 'no menos que',
		'2'		=> 'no m�s que',
		'3'		=> 'igual',
	],
	'LogNoMatch'				=> 'No hay coincidencias',
	'LogDate'					=> 'Fecha',
	'LogEvent'					=> 'Evento',
	'LogUsername'				=> 'Nombre de usuario',
	'LogLevels'	=> [
		'1'		=> 'cr�tico',
		'2'		=> 'm�s alto',
		'3'		=> 'alto',
		'4'		=> 'medio',
		'5'		=> 'bajo',
		'6'		=> 'm�s bajo',
		'7'		=> 'depuraci�n',
	],

	// Massemail module
	'MassemailInfo'				=> 'Desde aqu� puedes enviar un email a todos los usuarios, o a los usuarios de un grupo espec�fico. Para esto se enviar� un email a la direcci�n administrativa proporcionada, con copia oculta a todos los receptores. Si el grupo de personas es muy grande, por favor se paciente despu�s de pulsar en "Enviar" y no detengas el proceso por la mitad. Es normal que enviar un email masivo lleve alg�n tiempo, ser�s notificado cuando se complete el proceso',
	'LogMassemail'				=> 'Messemail send %1 to group / user ',
	'MassemailSend'				=> 'Massemail send',

	'NoEmailMessage'			=> 'Tienes que introducir un mensaje.',
	'NoEmailSubject'			=> 'Tienes que especificar un tema para su mensaje.',
	'NoEmailRecipient'			=> 'You must specify at least one user or user group.',

	'MassemailSection'			=> 'Mass email',
	'MessageSubject'			=> 'Sujeto',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Su mensaje',
	'YourMessageInfo'			=> 'Por favor, ten en cuenta que solo puede insertarse texto plano. Se eliminar� cualquier c�digo antes de enviar.',

	'MessageLanguage'			=> 'Idioma',
	'MessageLanguageInfo'		=> '',
	'SendMail'					=> 'Enviar',

	'NoUser'					=> 'No user',
	'NoUserGroup'				=> 'No user group',

	'SendToGroup'				=> 'Enviar a grupo',
	'SendToUser'				=> 'Enviar a usuario',
	'SendToUserInfo'			=> 'Env�a s�lo mensajes a aquellos usuarios que permitieron a los administradores enviarles informaci�n por correo electr�nico. Esta opci�n est� disponible en sus opciones de usuario en Notificaciones.',

	// System message module
	'SysMsgInfo'				=> '',
	'SysMsgUpdated'				=> 'Mensaje de sistema actualizado',

	'SysMsgSection'				=> 'Mensaje de sistema',
	'SysMsg'					=> 'Mensaje de sistema',
	'SysMsgInfo'				=> 'Su texto aqu�',

	'SysMsgType'				=> 'Type',
	'SysMsgTypeInfo'			=> 'Message type (CSS).',
	'EnableSysMsg'				=> 'Habilitar mensaje de sistema',
	'EnableSysMsgInfo'			=> 'Mostrar mensaje de sistema.',

	// User approval module
	'ApproveNotExists'			=> 'Please select at least one user via the Set button.',

	'LogUserApproved'			=> 'User ##%1## approved',
	'LogUserBlocked'			=> 'User ##%1## blocked',
	'LogUserDeleted'			=> 'User ##%1## removed from the database',
	'LogUserCreated'			=> 'Created a new user ##%1##',
	'LogUserUpdated'			=> 'Updated User ##%1##',

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
									'<strong>Atenci�n</strong>: Las tablas de este backup no ser�n reestructurados para evitar p�rdida de informaci�n al especificar el cluster de root, ' .
									'igual al realizar backup de solamente la estructura de tabla sin guardar los datos. ' .
									'Para realizar la conversi�n completa de las tablas al formato de backup debe realizar <em> el backup completo de base de datos (estructura y datos) sin especificar el cluster</em>.',
	'BackupCompleted'			=> 'Backup y archivaci�n terminado.<br>' .
									'Archivo del backup guardado en subdirectorio %1.<br>' .
									'Use FTP para descargarlo (mantenga la estructura de diretorios y nombres de archivos al copiar).<br>' .
									'Para restaurar una copia del backup o remover un paquete, ingrese en <a href="%2">Restaurar base de datos</a>.',
	'LogSavedBackup'			=> 'Guardado backup de base de datos ##%1##',
	'Backup'					=> 'Backup',

	// DB Restore module
	'RestoreInfo'				=> 'Puede restaurar un backup existente o removerlo del servidor.',
	'ConfirmDbRestore'			=> 'Desea restaurar un backup',
	'ConfirmDbRestoreInfo'		=> 'Por favor espere, esto puede durar unos minutos.',
	'RestoreWrongVersion'		=> 'Versi�n de WackoWiki incorrecta!',
	'BackupDelete'				=> 'Seguro que desea eliminar el backup',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Opciones adicionales de restaurar',
	'RestoreOptionsInfo'		=> '* Antes de restaurar el <strong>cluster backup</strong>, ' .
									'no se destruyen las tablas de destino (para evitar p�rdida de informaci�n de los cluster que no tienen backup). ' .
									'Por lo tanto habr� registros duplicados durante el proceso de restauraci�n. ' .
									'En el modo normal todos se reemplazar�n por los registros desde el backup (usando la instrucci�n SQL <code>REPLACE</code>), ' .
									'pero si se marca esta casilla, se omiten todos los duplicados (se mantienen los registros actuales), ' .
									'y solamente se agregan en la tabla registros con claves nuevas (instrucci�n SQL <code>INSERT IGNORE</code>).<br>' .
									'<strong>Observaci�n</strong>: Al restaurar el backup completo del sitio esta opci�n se ignora.<br>' .
									'<br>' .
									'** Si el backup contiene los archivos de usuario (global y por p�gina, archivos cache, etc.), ' .
									'en modo normal ser�n sustituidos al rastaurar con igual nombre y en la misma ubicaci�n de directorio. ' .
									'Esta opci�n permite guardar los archivos actuales y restaurar de un backup solamente los archivos nuevos (que faltan en el servidor).',
	'IgnoreDuplicatedKeys'		=> 'Ignorar claves duplicadas de tabla (no reemplazar)',
	'IgnoreSameFiles'			=> 'Ignorar archivos iguales (no sobreescribir)',
	'NoBackupsAvailable'		=> 'No existe backup.',
	'BackupEntireSite'			=> 'Sitio completo',
	'BackupRestored'			=> 'Se restaur� el backup, abajo se adjunta un reporte de resumen. Para eliminar este paquete de backup, presione',
	'BackupRemoved'				=> 'Se elimin� con �xito el backup seleccionado.',
	'LogRemovedBackup'			=> 'Backup de base de datos eliminado ##%1##',

	'RestoreStarted'			=> 'Initiated Restoration',
	'RestoreParameters'			=> 'Using parameters',
	'IgnoreDublicatedKeys'		=> 'Ignore dublicated keys',
	'IgnoreDublicatedFiles'		=> 'Ignore dublicated files',
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
	'FilesAll'					=> 'all',
	'SkipFiles'					=> 'Files are not stored - skip',
	'RestoreDone'				=> 'RESTORATION COMPLETED',

	'BackupCreationDate'		=> 'Creation Date',
	'BackupPackageContents'		=> 'The contents of the package',
	'BackupRestore'				=> 'Restore',
	'BackupRemove'				=> 'Remove',
	'RestoreYes'				=> 's�',
	'RestoreNo'					=> 'no',
	'LogDbRestored'				=> 'Backup ##%1## of the database restored.',

	// User module
	'UsersInfo'					=> 'Aqu� puede cambiar la informaci�n de sus usuarios y ciertas opciones espec�ficas.',

	'UsersAdded'				=> 'Usuario agregado',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'UserEditButton'			=> 'Edit',
	'UserEnabled'				=> 'Habilitado',
	'UsersAddNew'				=> 'Nuevo usuario',
	'UsersDelete'				=> 'Est� seguro que desea eliminar al usuario %1',
	'UsersDeleted'				=> 'Usuario %1 eliminado de la base de datos.',
	'UsersRename'				=> 'Renombrar usuario %1 a',
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
	'GroupsInfo'				=> 'Desde este panel puedes administrar todos tus grupos de usuarios. Puede borrar, crear y editar grupos existentes. Adem�s, puede elegir l�deres de grupo, alternar entre estado de grupo abierto/oculto/cerrado y establecer el nombre y la descripci�n del grupo.',

	'LogMembersUpdated'			=> 'Miembros actualizados del grupo de usuarios',
	'LogMemberAdded'			=> 'Added member ##%1## into group ##%2##',
	'LogMemberRemoved'			=> 'Removed member ##%1## from group ##%2##',
	'LogGroupCreated'			=> 'Created a new group ##%1##',
	'LogGroupRenamed'			=> 'Group ##%1## renamed to ##%2##',
	'LogGroupRemoved'			=> 'Removed group ##%1##',

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
	'GroupsDeleted'				=> 'Grupo %1 eliminado de la base de datos y de todas las p�ginas.',
	'GroupsAdd'					=> 'Agregar grupo nuevo',
	'GroupsRename'				=> 'Renombrar el grupo %1',
	'GroupsRenameInfo'			=> '* Observaci�n: El cambio afectar� a todas las p�ginas con el grupo asignado.',
	'GroupsDelete'				=> 'Est� seguro que desea eliminar el grupo ',
	'GroupsDeleteInfo'			=> '* Observaci�n: El cambio afectar� a todas los miembros del grupo.',
	'GroupsIsSystem'			=> 'El grupo %1 pertenece al sistema y no se puede eliminar.',
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

	// Statistics module
	'DbStatSection'				=> 'Estad�sticas de base de datos',
	'DbTable'					=> 'Table',
	'DbRecords'					=> 'Records',
	'DbSize'					=> 'Size',
	'DbIndex'					=> 'Index',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'Sistema de archivos Estad�sticas',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> 'Files',
	'FileSize'					=> 'Size',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Version informations',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Values',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> '�ltima actualizaci�n',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Server name',
	'WebServer'					=> 'Web server',
	'HTTPProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SQLModesGlobal'			=> 'SQL Modes Global',
	'SQLModesSession'			=> 'SQL Modes Session',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memory',
	'UploadFilesizeMax'			=> 'Upload max filesize',
	'PostMaxSize'				=> 'Post max size',
	'MaxExecutionTime'			=> 'Max execution time',
	'SessionPath'				=> 'Session path',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip compression',
	'PHPExtensions'				=> 'PHP extensions',
	'ApacheModules'				=> 'Apache modules',

	// DB repair module
	'DbRepairSection'			=> 'Reparar base de datos',
	'DbRepair'					=> 'Reparar base de datos',
	'DbRepairInfo'				=> 'Este script puede buscar autom�ticamente algunos problemas comunes de la base de datos y repararlos. La reparaci�n puede llevar un tiempo, as� que por favor, tenga paciencia.',

	'DbOptimizeRepairSection'	=> 'Reparaci�n y optimizaci�n de la base de datos',
	'DbOptimizeRepair'			=> 'Reparaci�n y optimizaci�n de la base de datos',
	'DbOptimizeRepairInfo'		=> 'Este script tambi�n puede intentar optimizar la base de datos. Esto mejora el rendimiento en algunas situaciones. La reparaci�n y optimizaci�n de la base de datos puede llevar mucho tiempo y la base de datos se bloquear� mientras se optimiza.',

	'TableOk'					=> 'La tabla de %1 est� bien.',
	'TableNotOk'				=> 'The %1 table is not okay. It is reporting the following error: %2. This script will attempt to repair this table&hellip;',
	'TableRepaired'				=> 'Repar� con �xito la tabla de %1.',
	'TableRepairFailed'			=> 'No se repar� la tabla de %1. <br>Error: %2',
	'TableAlreadyOptimized'		=> 'La tabla %1 ya est� optimizada.',
	'TableOptimized'			=> 'Optimizaci�n exitosa de la tabla %1.',
	'TableOptimizeFailed'		=> 'No se pudo optimizar la tabla de %1. <br>Error: %2',
	'TableNotRepaired'			=> 'Algunos problemas de la base de datos no pudieron ser reparados.',
	'RepairsComplete'			=> 'Reparaciones completas',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Mostrar y corregir inconsistencias, borrar o asignar registros hu�rfanos a un nuevo usuario/valor.',
	'Inconsistencies'			=> 'Inconsistencias',
	'CheckDatabase'				=> 'Base de datos',
	'CheckDatabaseInfo'			=> 'Verifica si hay inconsistencias de registro en la base de datos.',
	'CheckFiles'				=> 'Files',
	'CheckFilesInfo'			=> 'Checks for abandoned files, files with no reference left in the file table.',
	'Records'					=> 'Records',
	'InconsistenciesNone'		=> 'No se han encontrado inconsistencias en los datos.',
	'InconsistenciesDone'		=> 'Inconsistencias de datos resueltas.',
	'InconsistenciesRemoved'	=> 'Removed inconsistencies',
	'Check'						=> 'Check',
	'Solve'						=> 'Solve',

	// Transliterate module
	'TranslitField'				=> 'Transliterar el campo %1 en la tabla `%2`.',
	'TranslitStart'				=> 'Inicio',
	'TranslitContinue'			=> 'Continuar',
	'TranslitCompleted'			=> 'El proceso de actualizaci�n ha finalizado.',

	// Bad Behavior module
	'BbInfo'					=> 'Detecta y bloquea los accesos no deseados a la Web, niega el acceso automatizado de los robots de spam <br>Para m�s informaci�n, por favor visite la p�gina principal de %1.',
	'BbEnable'					=> 'Activar Bad Behavior',
	'BbEnableInfo'				=> 'All other settings can be changed in the config folder %1.',
	'BbStats'					=> 'Bad Behavior ha bloqueado %1 intentos de acceso en los �ltimos 7 d�as.',

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
	'BbIP'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbRecordsAll'				=> 'Displaying all %1 records',
	'BbShowBlocked'				=> 'Show Blocked',
	'BbShowPermitted'			=> 'Show Permitted',
	'BbIPDateStatus'			=> 'IP/Date/Status',
	'BbHeaders'					=> 'Headers',
	'BbEntity'					=> 'Entity',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Options saved.',
	'BbWhitelistHint'			=> 'Inappropriate whitelisting WILL expose you to spam, or cause Bad Behavior to stop functioning entirely! DO NOT WHITELIST unless you are 100% CERTAIN that you should.',
	'BbIPAddress'				=> 'IP Address',
	'BbIPAddressInfo'			=> 'IP address or CIDR format address ranges to be whitelisted (one per line)',
	'BbURL'						=> 'URL',
	'BbURLInfo'					=> 'URL fragments beginning with the / after your web site hostname (one per line)',
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

?>
