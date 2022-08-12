<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'					=> 'Observación: Antes de realizar actividades de administración se recomienda bloquear el acceso al sitio!',

	'CategoryArray'		=> [
		'basics'		=> 'Funciones básicas',
		'preferences'	=> 'Preferencias',
		'content'		=> 'Contenido',
		'users'			=> 'Usuarios',
		'maintenance'	=> 'Mantenimiento',
		'messages'		=> 'Mensajes',
		'extension'		=> 'Extension',
		'database'		=> 'Base de datos',
	],

	// Admin panel
	'AdminPanel'				=> 'Panel de Control de Administración',
	'RecoveryMode'				=> 'Modo de recuperación',
	'Authorization'				=> 'Autorización',
	'AuthorizationTip'			=> 'Por favor ingrese la contraseña del administrador (asegúrese que su navegador permita cookies).',
	'NoRecoveryPassword'		=> 'Contraseña administrativa no especificada!',
	'NoRecoveryPasswordTip'		=> 'Observación: La falta de una contraseña administrativa es un riesgo de seguridad! Ingrese la contraseña en el archivo de configuración y vuelva a ejecutar el programa.',

	'ErrorLoadingModule'		=> 'Error cargar admin module %1: no existe.',

	'ApHomePage'				=> 'Página de inicio',
	'ApHomePageTip'				=> 'ir a la página home, sin salir de la administración',
	'ApLogOut'					=> 'Desconectar',
	'ApLogOutTip'				=> 'salir de la administración del sistema',

	'TimeLeft'					=> 'Tiempo restante:  %1 minutos',
	'ApVersion'					=> 'versión',

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
		'name'		=> 'Primario',
		'title'		=> 'Parámetros básicos',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Apariencia',
		'title'		=> 'Configuración de apariencia',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Correo',
		'title'		=> 'Configuración Correo',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtros',
		'title'		=> 'Configuración de Filtros',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formateador',
		'title'		=> 'Opciones de Formato',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Notificaciones',
		'title'		=> 'Configuración de notificationes',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Páginas',
		'title'		=> 'Parámetros de páginas y del sitio',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permisos',
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
		'name'		=> 'Menú',
		'title'		=> 'Agregar, editar o eliminar itemes del menu',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Respaldo',
		'title'		=> 'Copia de seguridad de datos',
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
		'title'		=> 'Administración WackoWiki',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inconsistencias',
		'title'		=> 'Reparando inconsistencias de datos',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Sincronización',
		'title'		=> 'Sincronización de datos',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Correo Electrónico',
		'title'		=> 'Correo masivo',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Mensajes del Sistema',
		'title'		=> 'Mostrar Mensajes',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'System Info',
		'title'		=> 'System Information',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Registro del Sistema',
		'title'		=> 'Log de eventos del sistema',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Estadísticas',
		'title'		=> 'Mostrar estadísticas',
	],

	// Bad Behavior module
	'tool_badbehavior'		=> [
		'name'		=> 'Mal comportamiento',
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
	'PurgeSessions'				=> 'Purga',
	'PurgeSessionsTip'			=> 'Purgar todas las sesiones',
	'PurgeSessionsConfirm'		=> '¿Estás seguro de que deseas purgar todas las sesiones? Esto cerrará la sesión de todos los usuarios.',
	'PurgeSessionsExplain'		=> 'Purga todas las sesiones. Esto cerrará la sesión de todos los usuarios truncando la tabla auth_token.',
	'PurgeSessionsDone'			=> 'Sesiones purgadas con éxito.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Configuración básica actualizada',
	'LogBasicSettingsUpdated'	=> 'Configuración básica actualizada',

	'SiteName'					=> 'Nombre del sitio:',
	'SiteNameInfo'				=> 'El título de este sitio, aparece en el título del navegador, encabezado del tema, notificación por correo electrónico, etc.',
	'SiteDesc'					=> 'Descripción del sitio:',
	'SiteDescInfo'				=> 'Suplemento al título del sitio que aparece en la cabecera de las páginas para explicar en pocas palabras de qué se trata este sitio.',
	'AdminName'					=> 'Administrador del sitio:',
	'AdminNameInfo'				=> 'Nombre de usuario, que es responsable del soporte general del sitio. Este nombre no se utiliza para determinar los derechos de acceso, pero es deseable que se corresponda con el nombre del administrador jefe del sitio.',

	'LanguageSection'			=> 'Idioma',
	'DefaultLanguage'			=> 'Idioma por defecto:',
	'DefaultLanguageInfo'		=> 'Especifica el idioma de los mensajes que se muestran a los invitados no registrados, así como la configuración de la ubicación.',
	'MultiLanguage'				=> 'Soporte multilenguaje:',
	'MultiLanguageInfo'			=> 'Permita la posibilidad de seleccionar un idioma página por página.',
	'AllowedLanguages'			=> 'Idiomas permitidos:',
	'AllowedLanguagesInfo'		=> 'Se recomienda seleccionar sólo el conjunto de idiomas que desea utilizar, de lo contrario se seleccionan todos los idiomas.',

	'CommentSection'			=> 'Comentarios',
	'AllowComments'				=> 'Permitir comentarios:',
	'AllowCommentsInfo'			=> 'Habilitar comentarios sólo para usuarios invitados o registrados o deshabilitarlos en todo el sitio.',
	'SortingComments'			=> 'Ordenar comentarios:',
	'SortingCommentsInfo'		=> 'Cambia el orden en que se presentan los comentarios de la página, ya sea con el comentario más reciente O el más antiguo en la parte superior.',

	'ToolbarSection'			=> 'Barra de herramientas',
	'CommentsPanel'				=> 'Panel de comentarios:',
	'CommentsPanelInfo'			=> 'La visualización por defecto de los comentarios en la parte inferior de la página.',
	'FilePanel'					=> 'Panel de archivos:',
	'FilePanelInfo'				=> 'La visualización predeterminada de los archivos adjuntos en la parte inferior de la página.',
	'TagsPanel'					=> 'Panel de etiquetas:',
	'TagsPanelInfo'				=> 'La visualización por defecto del panel de etiquetas en la parte inferior de la página.',

	'NavigationSection'			=> 'Navegación',
	'ShowPermalink'				=> 'Mostrar enlace permanente:',
	'ShowPermalinkInfo'			=> 'La visualización por defecto del enlace permanente para la versión actual de la página.',
	'TocPanel'					=> 'Panel de contenido:',
	'TocPanelInfo'				=> 'El panel de tabla de contenido de visualización predeterminado de una página (puede necesitar soporte en las plantillas).',
	'SectionsPanel'				=> 'Panel de secciones:',
	'SectionsPanelInfo'			=> 'Por defecto muestra el panel de páginas adyacentes (requiere soporte en las plantillas).',
	'DisplayingSections'		=> 'Visualización de secciones:',
	'DisplayingSectionsInfo'	=> 'Cuando las opciones anteriores, si mostrar solo subpáginas de la página (<em>inferior</em>), solo vecino (<em>superior</em>) o ambos, y otro (<em>árbol</em>).',
	'MenuItems'					=> 'Elementos de menú:',
	'MenuItemsInfo'				=> 'Número predeterminado de elementos de menú mostrados (puede necesitar soporte en las plantillas).',

	'HandlerSection'			=> 'Manipulador',
	'HideRevisions'				=> 'Suprimir revisiones:',
	'HideRevisionsInfo'			=> 'La visualización por defecto de las revisiones de la página.',
	'AttachmentHandler'			=> 'Habilitar el manejador de archivos adjuntos:',
	'AttachmentHandlerInfo'		=> 'Permite mostrar el manejador de archivos adjuntos.',
	'SourceHandler'				=> 'Habilitar el controlador de origen:',
	'SourceHandlerInfo'			=> 'Permite mostrar el controlador de origen.',
	'ExportHandler'				=> 'Habilitar el controlador de exportación XML:',
	'ExportHandlerInfo'			=> 'Permite mostrar el controlador de exportación XML.',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Habilitar feeds:',
	'EnableFeedsInfo'			=> 'Activa o desactiva las fuentes Sindicación RSS de toda la wiki.',

	'XmlSitemap'				=> 'Mapa del sitio XML:',
	'XmlSitemapInfo'			=> 'Cree un archivo XML llamado %1 dentro de la carpeta xml. Genere un archivo XML compatible con el formato XML de mapa del sitio. Es posible que desee cambiar la ruta para generarlo en su carpeta raíz, ya que ese es uno de los requisitos, es decir, que el archivo XML esté en la carpeta raíz. Por otro lado, también puede agregar la ruta al mapa del sitio en el archivo robots.txt en su directorio raíz de la siguiente manera:',
	'XmlSitemapGz'				=> 'Compresión XML Sitemap:',
	'XmlSitemapGzInfo'			=> 'Si lo desea, puede comprimir su archivo de texto de Sitemap usando gzip para reducir su ancho de banda.',
	'XmlSitemapTime'			=> 'Tiempo de generación de mapa del sitio XML:',
	'XmlSitemapTimeInfo'		=> 'Genera el mapa del sitio sólo una vez en el número de días dado, cero significa en cada cambio de página.',

	'SearchSection'				=> 'Buscar',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Crea el archivo de descripción de OpenSearch en la carpeta XML y habilita el Autodiscovery del plugin de búsqueda en la cabecera HTML.',
	'SearchEngineVisibility'	=> 'Bloquear los motores de búsqueda (Search Engine Visibility):',
	'SearchEngineVisibilityInfo'=> 'Bloquee los motores de búsqueda, pero permita que los visitantes normales. Anula la configuración de la página. <br>Desalentar a los motores de búsqueda para que no indexen este sitio, es responsabilidad de los motores de búsqueda cumplir con esta petición.',

	'DiffModeSection'			=> 'Modos de Diferencia',
	'DefaultDiffModeSetting'	=> 'Modo diferencial predeterminado:',
	'DefaultDiffModeSettingInfo'=> 'Modo diff preseleccionado.',
	'AllowedDiffMode'			=> 'Modos de Diff permitidos:',
	'AllowedDiffModeInfo'		=> 'Se recomienda seleccionar sólo el conjunto de modos diff que desea utilizar, de lo contrario se seleccionan todos los modos diff.',
	'NotifyDiffMode'			=> 'Notificar modo diff:',
	'NotifyDiffModeInfo'		=> 'Modo diff utilizado para las notificaciones en el cuerpo del correo electrónico.',

	'EditingSection'			=> 'Edición',
	'EditSummary'				=> 'Resumen de edición:',
	'EditSummaryInfo'			=> 'Muestra un resumen de cambios en el modo de edición.',
	'MinorEdit'					=> 'Edición menor:',
	'MinorEditInfo'				=> 'Habilita la opción de edición menor en el modo de edición.',
	'ReviewSettings'			=> 'Revisión:',
	'ReviewSettingsInfo'		=> 'Habilita la opción de revisión en el modo de edición.',
	'PublishAnonymously'		=> 'Permitir publicación anónima:',
	'PublishAnonymouslyInfo'	=> 'Permitir que los usuarios publiquen preferiblemente de forma anónima (para ocultar el nombre de usuario).',

	'DefaultRenameRedirect'		=> 'Al renombrar poner redirección:',
	'DefaultRenameRedirectInfo'	=> 'De forma predeterminada, ofrezca establecer una redirección a la dirección anterior de la página a la que se está cambiando el nombre.',
	'StoreDeletedPages'			=> 'Mantener páginas eliminadas:',
	'StoreDeletedPagesInfo'		=> 'Cuando elimine una página, un comentario o un archivo, guárdelo en una sección especial, donde estará disponible para su revisión y recuperación durante más tiempo (como se describe a continuación).',
	'KeepDeletedTime'			=> 'Tiempo de almacenamiento de las páginas borradas:',
	'KeepDeletedTimeInfo'		=> 'El período en días. Sólo tiene sentido con la opción anterior. Cero indica la posesión eterna (en este caso el administrador puede borrar el "carrito" manualmente).',
	'PagesPurgeTime'			=> 'Tiempo de almacenamiento de las revisiones de página:',
	'PagesPurgeTimeInfo'		=> 'Borra automáticamente las versiones anteriores dentro del número de días dado. Si introduce cero, las versiones anteriores no se eliminarán.',
	'EnableReferrers'			=> 'Habilitar referenciadores:',
	'EnableReferrersInfo'		=> 'Permite almacenar y mostrar referencias externas.',
	'ReferrersPurgeTime'		=> 'Tiempo de almacenamiento de los referidos:',
	'ReferrersPurgeTimeInfo'	=> 'Mantener el historial de remisión de páginas externas no más allá de un número determinado de días. Cero significa almacenamiento eterno, pero para un sitio visitado activamente esto puede llevar a un desbordamiento de la base de datos.',
	'EnableCounters'			=> 'Hit Counters:',
	'EnableCountersInfo'		=> 'Permite el recuento de visitas por página y permite la visualización de estadísticas sencillas. No se cuentan las llamadas del propietario de la página.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Configuración predeterminada de visualización para el sitio.',
	'AppearanceSettingsUpdated'	=> 'Configuración de apariencia actualizada.',

	'LogoOff'					=> 'Apagado',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo y título',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Logo del sitio:',
	'SiteLogoInfo'				=> 'Su logotipo aparecerá normalmente en la esquina superior izquierda de la aplicación. El tamaño máximo es de 2 MiB. Las dimensiones óptimas son 255 píxeles de ancho por 55 píxeles de alto.',
	'LogoDimensions'			=> 'Dimensiones del logo:',
	'LogoDimensionsInfo'		=> 'Ancho y alto del Logo mostrado.',
	'LogoDisplayMode'			=> 'Modo de visualización del logo:',
	'LogoDisplayModeInfo'		=> 'Define la apariencia del Logotipo. El valor predeterminado está desactivado.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Sitio Favicon:',
	'SiteFaviconInfo'			=> 'El icono de acceso directo, o favicon, se muestra en la barra de direcciones, pestañas y marcadores de la mayoría de los navegadores. Esto invalidará el favicon de su tema.',
	'SiteFaviconTooBig'			=> 'Favicon es más grande que 64 × 64px.',
	'ThemeColor'				=> 'Color del tema para la barra de direcciones:',
	'ThemeColorInfo'			=> 'El navegador establecerá el color de la barra de direcciones de cada página de acuerdo con el color CSS proporcionado.',

	'LayoutSection'				=> 'Diseño',
	'Theme'						=> 'Tema:',
	'ThemeInfo'					=> 'El diseño de la plantilla que el sitio utiliza por defecto.',
	'ThemesAllowed'				=> 'Temas permitidos:',
	'ThemesAllowedInfo'			=> 'Seleccione los temas permitidos, que el usuario puede elegir, de lo contrario se permiten todos los temas disponibles.',
	'ThemesPerPage'				=> 'Temas por página:',
	'ThemesPerPageInfo'			=> 'Permitir temas por página, que el propietario de la página puede elegir a través de las propiedades de la página.',

	// System settings
	'SystemSettingsInfo'		=> 'Grupo de parámetros responsables de la plataforma de ajuste fino. No los cambie a menos que tenga confianza en sus acciones.',
	'SystemSettingsUpdated'		=> 'Actualización de la configuración del sistema',

	'DebugModeSection'			=> 'Modo de depuración',
	'DebugMode'					=> 'Modo de depuración:',
	'DebugModeInfo'				=> 'Fijación y retirada de datos de telemetría en el momento del programa. Nota: el detalle completo del régimen impone altas exigencias a la memoria disponible, especialmente en operaciones exigentes como hacer copias de seguridad y restaurar la base de datos.',
	'DebugModes'	=> [
		'0'		=> 'la depuración está desactivada',
		'1'		=> 'solo el tiempo total de ejecución',
		'2'		=> 'tiempo completo',
		'3'		=> 'detalle completo (DBMS, caché, etc.)',
	],
	'DebugSqlThreshold'			=> 'Rendimiento del umbral RDBMS:',
	'DebugSqlThresholdInfo'		=> 'En el modo de depuración detallado, registrar solo las consultas que tardan más segundos.',
	'DebugAdminOnly'			=> 'Diagnóstico cerrado:',
	'DebugAdminOnlyInfo'		=> 'Mostrar los datos de depuración del programa (y del SGBD) sólo para el administrador.',

	'CachingSection'			=> 'Opciones de caché',
	'Cache'						=> 'Caché de páginas renderizadas:',
	'CacheInfo'					=> 'Guarde las páginas renderizadas en la caché local para acelerar el arranque posterior. Válido solo para visitantes no registrados.',
	'CacheTtl'					=> 'Términos de relevancia en las páginas en caché:',
	'CacheTtlInfo'				=> 'Almacene las páginas en caché no más de un número específico de segundos.',
	'CacheSql'					=> 'Caché de consultas DBMS:',
	'CacheSqlInfo'				=> 'Mantener un caché local de los resultados de ciertas consultas de recursos SQL.',
	'CacheSqlTtl'				=> 'Base de datos de caché de relevancia del término:',
	'CacheSqlTtlInfo'			=> 'Almacene en caché los resultados de las consultas SQL durante no más de la cantidad de segundos especificada. No es deseable utilizar valores superiores a 1200.',

	'LogSection'				=> 'Configuración de Log',
	'LogLevelUsage'				=> 'Usando el Log:',
	'LogLevelUsageInfo'			=> 'La prioridad mínima de los eventos registrados en el Log.',
	'LogThresholds'	=> [
		'0'		=> 'no llevar un diario',
		'1'		=> 'solo el nivel critico',
		'2'		=> 'desde el más alto nivel',
		'3'		=> 'desde lo alto',
		'4'		=> 'de media',
		'5'		=> 'desde abajo',
		'6'		=> 'el nivel mínimo',
		'7'		=> 'grabar todo',
	],
	'LogDefaultShow'			=> 'Modo de registro de pantalla:',
	'LogDefaultShowInfo'		=> 'Los eventos de prioridad mínima visualizados en el log por defecto.',
	'LogModes'	=> [
		'1'		=> 'solo el nivel critico',
		'2'		=> 'desde el más alto nivel',
		'3'		=> 'desde lo alto',
		'4'		=> 'la media',
		'5'		=> 'desde abajo',
		'6'		=> 'desde el nivel mínimol',
		'7'		=> 'mostrar todo',
	],
	'LogPurgeTime'				=> 'Tiempo de almacenamiento del log:',
	'LogPurgeTimeInfo'			=> 'Eliminar el registro de eventos durante un número determinado de días.',

	'PrivacySection'			=> 'Privacidad',
	'AnonymizeIp'				=> 'Anonimizar las direcciones IP de los usuarios:',
	'AnonymizeIpInfo'			=> 'Anonimizar direcciones IP donde sea aplicable como página, revisión o referencias.',

	'ReverseProxySection'		=> 'Proxy inverso',
	'ReverseProxy'				=> 'Usar proxy inverso:',
	'ReverseProxyInfo'			=> 'Habilite esta configuración para determinar la dirección IP correcta del control remoto
									cliente examinando la información almacenada en los encabezados X-Fordered-For.
									Los encabezados X-Fordered-For son un mecanismo estándar para identificar los sistemas cliente
									que se conectan a través de un servidor proxy inverso, como Squid o Pound. Los servidores
									proxy inversos se utilizan a menudo para mejorar el rendimiento de sitios muy visitados y
									también pueden proporcionar otros beneficios de cifrado, seguridad o almacenamiento en caché
									del sitio. Si esta instalación de WackoWiki opera detrás de un proxy inverso, esta configuración
									debe estar habilitada para que la información correcta de la dirección IP sea capturada en los
									sistemas de administración de sesión, registro, estadísticas y administración de acceso de
									WackoWiki; Si no está seguro de esta configuración, no tiene un proxy inverso o WackoWiki
									funciona en un entorno de alojamiento compartido, esta configuración debe permanecer desactivada.',
	'ReverseProxyHeader'		=> 'Encabezado de proxy inverso:',
	'ReverseProxyHeaderInfo'	=> 'Establezca este valor si su servidor proxy envía la IP del cliente en un encabezado que no sea X-Fordered-For.
									El encabezado "X-Fordered-For" es una lista de direcciones IP separadas por coma+espacio, solo se utilizará
									la última (la más a la izquierda).',
	'ReverseProxyAddresses'		=> 'reverse_proxy acepta una matriz de direcciones IP:',
	'ReverseProxyAddressesInfo'	=> 'El elemento de esta matriz es la dirección IP de cualquiera de sus proxies inversos. Al llenar esta matriz,
									WackoWiki confiará en la información almacenada en los encabezados X-Forwarded-For solo si la dirección IP remota
									es una de estas, es decir, la solicitud llega al servidor web desde uno de sus proxies inversos. De lo contrario,
									el cliente podría conectarse directamente a su servidor web falsificando los encabezados X-Fordered-For.',

	'SessionSection'				=> 'Manejo de sesiones',
	'SessionStorage'				=> 'Almacenamiento de sesiones:',
	'SessionStorageInfo'			=> 'Esta opción define dónde se almacenan los datos de la sesión. De forma predeterminada, se selecciona el almacenamiento de archivos o de sesiones de base de datos.',
	'SessionModes'	=> [
		'1'		=> 'Archivo',
		'2'		=> 'Base de datos',
	],
	'SessionNotice'					=> 'Mostrar la causa de finalización de la sesión:',
	'SessionNoticeInfo'				=> 'Indica la causa de la finalización de la sesión.',

	'RewriteMode'					=> 'Usar <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Si su servidor web admite esta función, gire para obtener "hermosas" las direcciones de las páginas.<br>
										<span class="cite">La clase de configuración puede sobrescribir el valor en tiempo de ejecución, independientemente de si está apagado, si HTTP_MOD_REWRITE está encendido.</span>',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parámetros responsables del control de acceso y permisos.',
	'PermissionsSettingsUpdated'	=> 'Configuración de permisos actualizada',

	'PermissionsSection'		=> 'Derechos y privilegios',
	'ReadRights'				=> 'Derechos de lectura por defecto:',
	'ReadRightsInfo'			=> 'Se asignan a las páginas raíz creadas, así como a las páginas para las que no se pueden definir los derechos parentales.',
	'WriteRights'				=> 'Derechos de escritura por defecto:',
	'WriteRightsInfo'			=> 'Se asignan a las páginas raíz creadas, así como a las páginas para las que no se pueden definir los derechos parentales.',
	'CommentRights'				=> 'Derechos de comentario por defecto:',
	'CommentRightsInfo'			=> 'Se asignan a las páginas raíz creadas, así como a las páginas para las que no se pueden definir los derechos parentales.',
	'CreateRights'				=> 'Crear derechos de una subpágina por defecto:',
	'CreateRightsInfo'			=> 'Defina el derecho a crear páginas raíz y asígnelas a páginas para las que no se pueden definir derechos parentales.',
	'UploadRights'				=> 'Derechos de carga por defecto:',
	'UploadRightsInfo'			=> 'Se asignan a las páginas raíz creadas, así como a las páginas para las que no se pueden definir los derechos parentales.',
	'RenameRights'				=> 'Cambio de nombre global a la derecha:',
	'RenameRightsInfo'			=> 'La lista de permisos para cambiar el nombre (mover) páginas libremente.',

	'LockAcl'					=> 'Bloquear todas las ACL para solo lectura:',
	'LockAclInfo'				=> '<span class="cite">Sobrescribe la configuración de acl para que todas las páginas sean de solo lectura.</span><br>Esto puede ser útil si un proyecto está terminado, desea una edición cercana durante un período por razones de seguridad o como respuesta de emergencia.',
	'HideLocked'				=> 'Esconder páginas inaccesibles:',
	'HideLockedInfo'			=> 'Si el usuario no tiene permiso para leer la página, ocúltela en diferentes listas de páginas (sin embargo, el enlace colocado en el texto, seguirá siendo visible).',
	'RemoveOnlyAdmins'			=> 'Sólo los administradores pueden eliminar páginas:',
	'RemoveOnlyAdminsInfo'		=> 'Denegar todas las páginas, excepto los administradores, para eliminarlas. En el primer límite se aplica a los propietarios de páginas normales.',
	'OwnersRemoveComments'		=> 'Los propietarios de las páginas pueden eliminar comentarios:',
	'OwnersRemoveCommentsInfo'	=> 'Permite a los propietarios de páginas moderar los comentarios en sus páginas.',
	'OwnersEditCategories'		=> 'Los propietarios pueden editar categorías de página:',
	'OwnersEditCategoriesInfo'	=> 'Permita que los propietarios modifiquen la lista de categorías de páginas de su sitio (agregar palabras, eliminar palabras), asigna a una página.',
	'TermHumanModeration'		=> 'Término moderación humana:',
	'TermHumanModerationInfo'	=> 'Los moderadores sólo pueden editar los comentarios si se crearon hace no más de este número de días (esta limitación no se aplica al último comentario del tema).',

	'UserCanDeleteAccount'		=> 'Permitir a los usuarios eliminar sus propias cuentas',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parámetros responsables de la seguridad general de la plataforma, restricciones de seguridad y subsistemas de seguridad adicionales.',
	'SecuritySettingsUpdated'	=> 'Configuración de seguridad actualizada',

	'AllowRegistration'			=> 'Regístrese en línea:',
	'AllowRegistrationInfo'		=> 'Abrir registro de usuario. Al desactivar esta opción se impedirá el registro gratuito, sin embargo, el administrador del sitio podrá registrar a otros usuarios él mismo.',
	'ApproveNewUser'			=> 'Aprobar nuevos usuarios:',
	'ApproveNewUserInfo'		=> 'Permite a los administradores aprobar a los usuarios una vez que se registran. Sólo los usuarios aprobados podrán iniciar sesión en el sitio.',
	'PersistentCookies'			=> 'Cookies persistentes:',
	'PersistentCookiesInfo'		=> 'Permitir cookies persistentes.',
	'DisableWikiName'			=> 'Desactivar NombreWiki:',
	'DisableWikiNameInfo'		=> 'Desactivar el uso obligatorio de NombreWiki. Permite registrar usuarios con apodos tradicionales, no forzado NameSurname.',
	'AllowEmailReuse'			=> 'Permitir la reutilización de la dirección de correo electrónico:',
	'AllowEmailReuseInfo'		=> 'Diferentes usuarios pueden registrarse con la misma dirección de correo electrónico.',
	'AllowedEmailDomains'		=> 'Allowed email domains:',
	'AllowedEmailDomainsInfo'	=> 'Allowed email domains comma separated, e.g. <code>example.com, local.lan</code> etc., other wise all email domains are allowed.',
	'UsernameLength'			=> 'Longitud del nombre de usuario:',
	'UsernameLengthInfo'		=> 'Número mínimo y máximo de caracteres en los nombres de usuario.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Habilitar Captcha:',
	'EnableCaptchaInfo'			=> 'Si está habilitado, Captcha se mostrará en los siguientes casos o si se alcanza un umbral de seguridad.',
	'CaptchaComment'			=> 'Nuevo comentario:',
	'CaptchaCommentInfo'		=> 'Como medida de protección contra las publicaciones spam, los usuarios no registrados requieren una única solución de la prueba antes de publicar el comentario.',
	'CaptchaPage'				=> 'Nueva página:',
	'CaptchaPageInfo'			=> 'Como medida de protección contra las publicaciones no deseadas, los usuarios no registrados requieren una única solución de prueba antes de crear una nueva página.',
	'CaptchaEdit'				=> 'Editar página:',
	'CaptchaEditInfo'			=> 'Como medida de protección contra las publicaciones no deseadas, los usuarios no registrados requieren una única solución de prueba antes de editar las páginas.',
	'CaptchaRegistration'		=> 'Inscripciones:',
	'CaptchaRegistrationInfo'	=> 'Como medida de protección contra las publicaciones no deseadas, los usuarios no registrados requieren una única solución de prueba antes de registrarse.',

	'TlsSection'				=> 'Configuración de TLS',
	'TlsConnection'				=> 'Conexión TLS:',
	'TlsConnectionInfo'			=> 'Utilice una conexión protegida por TLS. <span class="cite">Active el certificado TLS preinstalado requerido en el servidor; de lo contrario, perderá el acceso al panel de administración.</span><br>También determina si el indicador de seguridad de cookies está configurado, el código <code>seguro</code> marca especifica si las cookies solo deben enviarse a través de conexiones seguras.',
	'TlsImplicit'				=> 'TLS obligatorio:',
	'TlsImplicitInfo'			=> 'Reconectar por la fuerza el cliente de HTTP a HTTPS. Con la opción desactivada, el cliente puede navegar por el sitio a través de un canal HTTP abierto.',

	'HttpSecurityHeaders'		=> 'Encabezados de seguridad HTTP',
	'EnableSecurityHeaders'		=> 'Habilitar encabezados de seguridad:',
	'EnableSecurityHeadersinfo'	=> 'Establezca encabezados de seguridad (fractura de marcos, protección contra clickjacking/XSS/CSRF).<br>CSP puede causar problemas en determinadas situaciones (por ejemplo, durante el desarrollo) o cuando se utilizan complementos que dependen de recursos alojados externamente, como imágenes o scripts.<br>¡Deshabilitar la política de seguridad de contenido es un riesgo de seguridad!',
	'Csp'						=> 'Política de seguridad de contenido (CSP):',
	'CspInfo'					=> 'La configuración de la Política de seguridad de contenido implica decidir qué políticas desea aplicar, y luego configurarlas y utilizar Content-Security-Policy para establecer su política.',
	'PolicyModes'	=> [
		'0'		=> 'inhabilitar',
		'1'		=> 'estricta',
		'2'		=> 'personalizada',
	],
	'PermissionsPolicy'			=> 'Permissions Policy:',
	'PermissionsPolicyInfo'		=> 'La cabecera HTTP Permissions-Policy proporciona un mecanismo para habilitar o deshabilitar explícitamente varias funciones potentes del navegador.',
	'ReferrerPolicy'			=> 'Política de referencias:',
	'ReferrerPolicyInfo'		=> 'El encabezado HTTP Referrer-Policy gobierna qué información de referencia, enviada en el encabezado Referer, debe incluirse con las solicitudes realizadas.',
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

	'UserPasswordSection'		=> 'Persistencia de las contraseñas de los usuarios',
	'PwdMinChars'				=> 'Longitud mínima de la contraseña:',
	'PwdMinCharsInfo'			=> 'Las contraseñas más largas son necesariamente más seguras que las más cortas (por ejemplo, de 12 a 16 caracteres). <br>Se recomienda el uso de frases de contraseña en lugar de contraseñas.',
	'AdminPwdMinChars'			=> 'Longitud mínima de la contraseña de administrador:',
	'AdminPwdMinCharsInfo'		=> 'Las contraseñas más largas son necesariamente más seguras que las más cortas (por ejemplo, de 15 a 20 caracteres). <br>Se recomienda el uso de frases de contraseña en lugar de contraseñas.',
	'PwdCharComplexity'			=> 'La complejidad de la contraseña requerida:',
	'PwdCharClasses'	=> [
		'0'		=> 'no probado',
		'1'		=> 'cualquier letra + números',
		'2'		=> 'mayúsculas y minúsculas + números',
		'3'		=> 'mayúsculas y minúsculas + números + caracteres',
	],
	'PwdUnlikeLogin'			=> 'Complicación adicional:',
	'PwdUnlikes'	=> [
		'0'		=> 'no probado',
		'1'		=> 'la contraseña no es idéntica al inicio de sesión',
		'2'		=> 'la contraseña no contiene nombre de usuario',
	],

	'LoginSection'				=> 'Conectar',
	'MaxLoginAttempts'			=> 'Número máximo de intentos de inicio de sesión por nombre de usuario:',
	'MaxLoginAttemptsInfo'		=> 'El número de intentos de inicio de sesión permitidos para una sola cuenta antes de que se active la tarea anti-spambot. Introduzca 0 para evitar que se active la tarea anti-spambot para cuentas de usuario distintas.',
	'IpLoginLimitMax'			=> 'Número máximo de intentos de inicio de sesión por dirección IP:',
	'IpLoginLimitMaxInfo'		=> 'El umbral de intentos de inicio de sesión permitido desde una única dirección IP antes de que se active una tarea anti-spambot. Introduzca 0 para evitar que la tarea anti-spambot sea activada por las direcciones IP.',

	'FormsSection'				=> 'Formularios',
	'FormTokenTime'				=> 'Tiempo máximo para enviar formularios:',
	'FormTokenTimeInfo'			=> 'El tiempo que un usuario tiene para enviar un formulario (en segundos).<br> Tenga en cuenta que un formulario puede ser inválido si la sesión expira, independientemente de esta configuración.',

	'SessionLength'				=> 'Cookie de inicio de sesión de término:',
	'SessionLengthInfo'			=> 'La duración del inicio de sesión de la cookie del usuario de forma predeterminada (en días).',
	'CommentDelay'				=> 'Anti-flood para comentarios:',
	'CommentDelayInfo'			=> 'La demora mínima entre la publicación de los comentarios del nuevo usuario (en segundos).',
	'IntercomDelay'				=> 'Anti-flood para comunicaciones personales:',
	'IntercomDelayInfo'			=> 'El retraso mínimo entre el envío de una conexión de usuario de mensaje privado (en segundos).',
	'RegistrationDelay'			=> 'Umbral de tiempo para registrarse:',
	'RegistrationDelayInfo'		=> 'El umbral de tiempo mínimo para rellenar el formulario de registro para distinguir a los robots de los humanos (en segundos).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Grupo de parámetros responsables de la plataforma de puesta a punto. No los cambie a menos que tenga confianza en sus acciones.',
	'FormatterSettingsUpdated'	=> 'Configuración de formato actualizada',

	'TextHandlerSection'		=> 'Manejador de texto',
	'Typografica'				=> 'Corrector tipográfico:',
	'TypograficaInfo'			=> 'El desajuste acelera ligeramente el proceso de añadir comentarios y guardar la página.',
	'Paragrafica'				=> 'Marcas paragrafica:',
	'ParagraficaInfo'			=> 'Similar a la opción anterior, pero provocará la desconexión de la tabla de contenido automática inoperable: <code>{{toc}}</code>.',
	'AllowRawhtml'				=> 'Soporte global de HTML:',
	'AllowRawhtmlInfo'			=> 'Esta opción es potencialmente insegura para un sitio abierto.',
	'SafeHtml'					=> 'Filtrado de HTML:',
	'SafeHtmlInfo'				=> 'Evita guardar objetos HTML peligrosos. ¡Desactivar el filtro en un sitio abierto con soporte HTML es <span class = "underline">extremadamente</span>indeseable!',

	'WackoFormatterSection'		=> 'Formateador de texto Wiki (formateador Wacko)',
	'X11colors'					=> 'Uso de colores X11:',
	'X11colorsInfo'				=> 'Extiende los colores disponibles para <code>??(color) background ??</code> y <code>!!(color) text !!</code> Desconfigurar acelera ligeramente el proceso de agregar comentarios y guardar páginas.',
	'WikiLinks'					=> 'Desactivar Wikilinks:',
	'WikiLinksInfo'				=> 'Desactiva la vinculación para <code>CamelCaseWords</code>, sus CamelCase Words ya no estarán vinculadas directamente a una nueva página. Esto es útil cuando trabaja en diferentes espacios de nombres aks clústeres. Por defecto está desactivado.',
	'BracketsLinks'				=> 'Deshabilitar los vínculos entre corchetes:',
	'BracketsLinksInfo'			=> 'Desactiva la sintaxis <code>[[link]]</code> y <code>((link))</code>.',
	'Formatters'				=> 'Deshabilitar formateadores:',
	'FormattersInfo'			=> 'Deshabilita la sintaxis <code>%%code%%</code>, que se usa para resaltadores.',

	'DateFormatsSection'		=> 'Formatos de fecha',
	'DateFormat'				=> 'El formato de la fecha:',
	'DateFormatInfo'			=> '(día, mes, año)',
	'TimeFormat'				=> 'El formato de la hora:',
	'TimeFormatInfo'			=> '(hora, minuto)',
	'TimeFormatSeconds'			=> 'El formato de la hora exacta:',
	'TimeFormatSecondsInfo'		=> '(horas, minutos, segundos)',
	'NameDateMacro'				=> 'El formato de la macro <code>::@::</code>:',
	'NameDateMacroInfo'			=> '(nombre, hora), p. ej. <code>Nombre de usuario (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Zona horaria:',
	'TimezoneInfo'				=> 'Zona horaria que se utilizará para mostrar las horas a los usuarios que no han iniciado sesión (invitados). Los usuarios que iniciaron sesión configuraron y pueden cambiar su zona horaria en la configuración de usuario.',

	'Canonical'					=> 'Usar URLs totalmente canónicas:',
	'CanonicalInfo'				=> 'Todos los enlaces se crean como URLs absolutos en la forma %1. Los URLs relativos a la raíz del servidor en la forma %2 deben ser preferidos.',
	'LinkTarget'				=> 'Donde se abren los enlaces externos:',
	'LinkTargetInfo'			=> 'Abre cada enlace externo en una nueva ventana del navegador. Añade <code>target="_blank"</code> a la sintaxis del enlace.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Requiere que el navegador no envíe un encabezado de referencia HTTP si el usuario sigue el hipervínculo. Añade <code>rel="noreferrer"</code> a la sintaxis del enlace.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Indique a algunos motores de búsqueda que el hipervínculo no debe influir en la clasificación de los enlaces objetivo en el índice de los motores de búsqueda. Agrega <code>rel="nofollow"</code> a la sintaxis del enlace.',
	'UrlsUnderscores'			=> 'Direcciones de formulario (URL) con guiones bajos:',
	'UrlsUnderscoresInfo'		=> 'Por ejemplo, %1 se convierte en %2 con esta opción.',
	'ShowSpaces'				=> 'Mostrar espacios en WikiNames:',
	'ShowSpacesInfo'			=> 'Mostrar espacios en WikiNames, p. Ej. <code>MiNombre</code> se muestra como <code>Mi Nombre</code> con esta opción.',
	'NumerateLinks'				=> 'Numerosos enlaces en la vista de impresión:',
	'NumerateLinksInfo'			=> 'Numera y enumera todos los enlaces en la parte inferior de la vista de impresión con esta opción.',
	'YouareHereText'			=> 'Deshabilitar y visualizar enlaces de autorreferencia:',
	'YouareHereTextInfo'		=> 'Visualizando enlaces a la misma página, intente <code>&lt;b&gt;####&lt;/b&gt;</code>, todos los enlaces a uno mismo no se convirtieron en enlaces, sino en texto en negrita.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Aquí puedes establecer o cambiar las páginas base del sistema que se usan en el Wiki. Por favor, asegúrese de no olvidar crear o cambiar las páginas correspondientes en el Wiki de acuerdo a su configuración aquí.',
	'PagesSettingsUpdated'		=> 'Páginas base de configuración actualizadas',

	'ListCount'					=> 'Número de elementos por lista:',
	'ListCountInfo'				=> 'Número de elementos que se muestran en cada lista para invitados o como valor predeterminado para nuevos usuarios.',

	'ForumSection'				=> 'Foro Opciones',
	'ForumCluster'				=> 'Foro de clúster:',
	'ForumClusterInfo'			=> 'Clúster raíz para la sección del foro (action %1).',
	'ForumTopics'				=> 'Número de temas por página:',
	'ForumTopicsInfo'			=> 'Número de temas mostrados en cada página de la lista en las secciones del foro.',
	'CommentsCount'				=> 'Número de comentarios por página:',
	'CommentsCountInfo'			=> 'Número de comentarios mostrados en cada página de la lista de comentarios. Esto se aplica a todos los comentarios en el sitio, y no sólo a los publicados en el foro.',

	'NewsSection'				=> 'Sección de Noticias',
	'NewsCluster'				=> 'Clúster de noticias:',
	'NewsClusterInfo'			=> 'Clúster raíz de la sección de noticias (action %1).',
	'NewsStructure'				=> 'Estructura del clúster de noticias:',
	'NewsStructureInfo'			=> 'Almacena los artículos opcionalmente en subclústeres por año/mes o semana (por ejemplo, <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licencia',
	'DefaultLicense'			=> 'Licencia por defecto:',
	'DefaultLicenseInfo'		=> '¿Bajo qué licencia se debe publicar su contenido?.',
	'EnableLicense'				=> 'Habilitar licencia:',
	'EnableLicenseInfo'			=> 'Habilitar para mostrar información de licencia.',
	'LicensePerPage'			=> 'Licencia por página:',
	'LicensePerPageInfo'		=> 'Permitir licencia por página, que el propietario de la página puede elegir a través de las propiedades de la página.',

	'ServicePagesSection'		=> 'Páginas de servicio',
	'RootPage'					=> 'Página principal:',
	'RootPageInfo'				=> 'Etiqueta de su página principal, se abre automáticamente cuando un usuario visita su sitio.',

	'PrivacyPage'				=> 'Política de privacidad:',
	'PrivacyPageInfo'			=> 'La página con la Política de Privacidad del sitio.',

	'TermsPage'					=> 'Políticas y regulaciones:',
	'TermsPageInfo'				=> 'La página con las reglas del sitio.',

	'SearchPage'				=> 'Buscar:',
	'SearchPageInfo'			=> 'Página con el formulario de búsqueda (action %1).',
	'RegistrationPage'			=> 'Registro:',
	'RegistrationPageInfo'		=> 'Página de registro de nuevo usuario (action %1).',
	'LoginPage'					=> 'Inicio de sesión de usuario:',
	'LoginPageInfo'				=> 'Página de acceso al sitio (action %1).',
	'SettingsPage'				=> 'Ajustes de usuario:',
	'SettingsPageInfo'			=> 'Página personalizar el perfil de usuario (action %1).',
	'PasswordPage'				=> 'Cambiar Contraseña:',
	'PasswordPageInfo'			=> 'Página con un formulario para cambiar / consultar la contraseña del usuario (action %1).',
	'UsersPage'					=> 'Lista de usuarios:',
	'UsersPageInfo'				=> 'Página con una lista de usuarios registrados (action %1).',
	'CategoryPage'				=> 'Categoría:',
	'CategoryPageInfo'			=> 'Página con una lista de páginas categorizadas (action %1).',
	'TagPage'					=> 'Etiqueta:',
	'TagPageInfo'				=> 'Página con una lista de páginas etiquetadas (action %1).',
	'GroupsPage'				=> 'Grupos:',
	'GroupsPageInfo'			=> 'Página con lista de grupos de trabajo (action %1).',
	'ChangesPage'				=> 'Modificaciones recientes:',
	'ChangesPageInfo'			=> 'Página con una lista de las últimas páginas modificadas (action %1).',
	'CommentsPage'				=> 'Últimos comentarios:',
	'CommentsPageInfo'			=> 'Página con una lista de comentarios recientes en la página (action %1).',
	'RemovalsPage'				=> 'Páginas eliminadas:',
	'RemovalsPageInfo'			=> 'Página con una lista de páginas eliminadas recientemente (action %1).',
	'WantedPage'				=> 'Páginas buscadas:',
	'WantedPageInfo'			=> 'Página con una lista de páginas faltantes a las que se hace referencia (action %1).',
	'OrphanedPage'				=> 'Páginas huérfanas:',
	'OrphanedPageInfo'			=> 'Las páginas con una lista de páginas existentes no son enlaces relacionados con el resto (action %1).',
	'SandboxPage'				=> 'Sandbox:',
	'SandboxPageInfo'			=> 'Página donde los usuarios pueden ser entrenados en el uso del marcado wiki.',
	'HelpPage'					=> 'Ayuda:',
	'HelpPageInfo'				=> 'La sección de documentación para trabajar con herramientas del sitio.',
	'IndexPage'					=> 'Índice:',
	'IndexPageInfo'				=> 'Página con una lista de todas las páginas (action %1).',
	'RandomPage'				=> 'Aleatoria:',
	'RandomPageInfo'			=> 'Carga una página aleatoria (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parámetros para las notificaciones de la plataforma.',
	'NotificationSettingsUpdated'	=> 'Configuración de notificación actualizada',

	'EmailNotification'			=> 'Notificación por correo electrónico:',
	'EmailNotificationInfo'		=> 'Permitir notificación por correo electrónico. Seleccione ON para habilitar las notificaciones por correo electrónico y OFF para deshabilitarlas. Tenga en cuenta que la desactivación de las notificaciones de correo electrónico no tiene ningún efecto en los correos electrónicos generados como parte del proceso de registro de usuarios.',
	'Autosubscribe'				=> 'Autosuscripción:',
	'AutosubscribeInfo'			=> 'Permitir notificación por correo electrónico. Seleccione ON para habilitar las notificaciones por correo electrónico y OFF para deshabilitarlas. Firmar automáticamente una nueva página en el aviso del propietario de sus cambios.',

	'NotificationSection'		=> 'Configuración predeterminada de notificación al usuario',
	'NotifyPageEdit'			=> 'Notificar la edición de la página:',
	'NotifyPageEditInfo'		=> 'Pendiente - Enviar una notificación por correo electrónico sólo para el primer cambio hasta que el usuario vuelva a visitar la página.',
	'NotifyMinorEdit'			=> 'Notificar a un menor de edad:',
	'NotifyMinorEditInfo'		=> 'Envía notificaciones también para ediciones menores.',
	'NotifyNewComment'			=> 'Notificar nuevo comentario:',
	'NotifyNewCommentInfo'		=> 'Pendiente - Envío de una notificación por correo electrónico sólo para el primer comentario hasta que el usuario vuelva a visitar la página.',

	'NotifyUserAccount'			=> 'Notificar una nueva cuenta de usuario:',
	'NotifyUserAccountInfo'		=> 'El administrador será notificado cuando un nuevo usuario haya sido creado usando el formulario de registro.',
	'NotifyUpload'				=> 'Notificar la carga de archivos:',
	'NotifyUploadInfo'			=> 'Los Moderadores serán notificados cuando un archivo haya sido cargado.',

	'PersonalMessagesSection'	=> 'Mensajes personales',
	'AllowIntercomDefault'		=> 'Permitir intercomunicación:',
	'AllowIntercomDefaultInfo'	=> 'Habilitar esta opción permite a otros usuarios enviar mensajes personales a la dirección de correo electrónico del destinatario sin revelar la dirección.',
	'AllowMassemailDefault'		=> 'Permitir correo masivo:',
	'AllowMassemailDefaultInfo'	=> 'Envía sólo mensajes a aquellos usuarios que permitieron a los administradores enviarles información por correo electrónico.',

	// Resync settings
	'Synchronize'				=> 'Sincronizar',
	'UserStatsSynched'			=> 'Estadísticas de usuario sincronizadas.',
	'PageStatsSynched'			=> 'Estadísticas de página sincronizadas.',
	'FeedsUpdated'				=> 'RSS-feeds actualizados.',
	'SiteMapCreated'			=> 'La nueva versión del mapa del sitio creado con éxito.',
	'ParseNextBatch'			=> 'Analizar el siguiente lote de páginas:',
	'WikiLinksRestored'			=> 'Wiki-enlaces restaurados.',

	'LogUserStatsSynched'		=> 'Estadísticas de usuarios sincronizadas',
	'LogPageStatsSynched'		=> 'Estadísticas de página sincronizadas',
	'LogFeedsUpdated'			=> 'Canales RSS sincronizados',
	'LogPageBodySynched'		=> 'Cuerpo de la página y enlaces',

	'UserStats'					=> 'Estadísticas de usuarios',
	'UserStatsInfo'				=> 'Las estadísticas del usuario (número de comentarios, páginas propias, revisiones y archivos) pueden diferir en algunas situaciones de los datos reales. <br>Esta operación permite actualizar las estadísticas a los datos reales actuales de la base de datos.',
	'PageStats'					=> 'Estadísticas de página',
	'PageStatsInfo'				=> 'Las estadísticas de página (número de comentarios, archivos y revisiones) pueden diferir en algunas situaciones de los datos reales. <br>Esta operación permite actualizar las estadísticas a los datos actuales de la base de datos.',
	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'En el caso de la edición directa de las páginas de la base de datos, el contenido de las fuentes RSS puede no reflejar los cambios realizados. <br>Esta función sincroniza los canales RSS con el estado actual de la base de datos.',
	'XmlSiteMap'				=> 'Mapa del sitio XML',
	'XmlSiteMapInfo'			=> 'Esta función sincroniza el mapa del sitio XML con el estado actual de la base de datos.',
	'XmlSiteMapPeriod'			=> 'Período %1 días. Último escrito %2.',
	'XmlSiteMapView'			=> 'Mostrar mapa del sitio en una nueva ventana.',

	'ReparseBody'				=> 'Analizar todas las páginas',
	'ReparseBodyInfo'			=> 'Vacía <code>body_r</code> en la tabla de páginas, de modo que cada página se vuelva a representar en la siguiente vista de página. Esto puede ser útil si modificó el formateador o cambió el dominio de su wiki.',
	'PreparsedBodyPurged'		=> 'Campo <code>body_r</code> vacío en la tabla de páginas.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Realiza una re-renderización para todos los enlaces dentro del sitio y restaura el contenido de la tabla <code>page_link</code> y <code>file_link</code> en caso de daño o reubicación (esto puede llevar un tiempo considerable).',
	'RecompilePage'				=> 'Volver a compilar todas las páginas (extremadamente caro)',
	'ResyncOptions'				=> 'Opciones adicionales',
	'RecompilePageLimit'		=> 'Número de páginas para analizar a la vez.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Esta información se usa cuando el Sitio envía emails a sus usuarios. Por favor verifique que la dirección de email ingresada sea válida, cualquier rebote se reenviará a esa dirección. Si su host no provee un servicio de email nativo (utilizable por PHP), entonces use directamente SMTP. Esto requiere la dirección de un servidor apropiado (pregúntele a su ISP de ser necesario). Si (si, y solo si) el servidor requiere autentificación complete el usuario y contraseña. Por favor observe que solo se ofrece autentificación básica, otro tipo de implementación no es posible actualmente.',

	'EmailSettingsUpdated'		=> 'Configuración de correo electrónico actualizada',

	'EmailFunctionName'			=> 'Nombre de la función email:',
	'EmailFunctionNameInfo'		=> 'La función empleada por PHP para enviar emails.',
	'UseSmtpInfo'				=> 'Elija <code>SMTP</code> si quiere o necesita enviar emails mediante un servidor específico en lugar de la función de email local.',

	'EnableEmail'				=> 'Habilitar envío de emails:',
	'EnableEmailInfo'			=> 'habilitando emails',

	'FromEmailName'				=> 'Nombre remitente:',
	'FromEmailNameInfo'			=> 'Nombre del remitente, parte de la cabecera <code>From:</code> en emails para todas las notificaciones de email desde este sitio.',
	'NoReplyEmail'				=> 'dirección no-responder:',
	'NoReplyEmailInfo'			=> 'Esta dirección, p.ej. <code>noreply@example.com</code> aparecerá en el campo <code>From:</code> del email en todas las notificaciones de email desde este sitio.',
	'AdminEmail'				=> 'Email del dueño del sitio:',
	'AdminEmailInfo'			=> 'Esta dirección es para efectos de administración, por ejemplo notificación de nuevo usuario.',
	'AbuseEmail'				=> 'Email abuse service:',
	'AbuseEmailInfo'			=> 'Dirección para asuntos urgentes: registro de un email estraño etc. Puee coincidir con e anterior.',

	'SendTestEmail'				=> 'Enviar un correo electrónico de prueba',
	'SendTestEmailInfo'			=> 'Esto enviará un correo electrónico de prueba a la dirección definida en su cuenta.',
	'TestEmailSubject'			=> 'El Wiki está configurado correctamente para enviar emails',
	'TestEmailBody'				=> 'Si recibió este email su Wiki está configurado correctamente para enviar emails.',
	'TestEmailMessage'			=> 'El correo electrónico de prueba ha sido enviado.<br>Si no lo recibes, por favor revisa tú configuración de mensajes de correo electrónico.',

	'SmtpSettings'				=> 'Configuración SMTP',
	'SmtpAutoTls'				=> 'TLS oportunista:',
	'SmtpAutoTlsInfo'			=> 'Habilita automáticamente encriptación si el servidor publica encriptación TLS (luego de conectar al servidor), aunque no se haya configurado el modo de conexión para <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Método de autentificación para SMTP:',
	'SmtpConnectionModeInfo'	=> 'Solo usado si se configura usuario/contraseña, pregúntele a su ISP si no está seguro de cual método usar.',
	'SmtpPassword'				=> 'Contraseña SMTP:',
	'SmtpPasswordInfo'			=> 'Introduzca una contraseña solo si su servidor SMTP lo requiere.<br><em><strong>ADVERTENCIA:</strong> Esta contraseña será guardada como texto plano en la base de datos y será visible para cualquiera que tenga acceso a la misma o que pueda ver esta página de configuración.</em>',
	'SmtpPort'					=> 'Puerto servidor SMTP:',
	'SmtpPortInfo'				=> 'Cámbielo solo si sabe que su servidor SMTP está en un puerto diferente. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Dirección servidor SMTP:',
	'SmtpServerInfo'			=> 'Ten en cuenta que debes proporcionar el protocolo que utiliza tu servidor. Si estás utilizando SSL, tiene que ser <code>ssl://mail.example.com</code>',
	'SmtpUsername'				=> 'Usuario SMTP:',
	'SmtpUsernameInfo'			=> 'Solo introduzca un usuario si su servidor SMTP lo requiere.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Aquí puedes configurar los principales parámetros para archivos adjuntos y las categorías especiales asociadas.',
	'UploadSettingsUpdated'		=> 'Configuración de carga actualizada',

	'FileUploadsSection'		=> 'Carga de archivos',
	'RightToUpload'				=> 'Derecho a cargar archivos:',
	'RightToUploadInfo'			=> '<code>admins</code> significa que solo los usuarios que pertenecen al grupo de administradores pueden cargar archivos. <code>1</code> significa que la carga está abierta a usuarios registrados. <code>0</code> significa que la carga está deshabilitada.',
	'UploadOnlyImages'			=> 'Permitir sólo la carga de imágenes:',
	'UploadOnlyImagesInfo'		=> 'Permitir sólo la carga de archivos de imagen en la página.',
	'UploadMaxFilesize'			=> 'Tamaño máximo:',
	'UploadMaxFilesizeInfo'		=> 'Tamaño máximo de cada archivo. Si este valor es 0, el tamaño del archivo para subir sólo estará limitado por la configuración de PHP.',
	'UploadQuota'				=> 'Máximo total para adjuntos:',
	'UploadQuotaInfo'			=> 'Máximo en disco disponible para adjuntos en todo el sitio, <code>0</code> significa ilimitado.',
	'UploadQuotaUser'			=> 'Cuota de espacio por usuario:',
	'UploadQuotaUserInfo'		=> 'Restricción de la cuota de almacenamiento que puede ser cargada por un usuario, siendo <code>0</code> ilimitado.',
	'CheckMimetype'				=> 'Comprobar archivos adjuntos:',
	'CheckMimetypeInfo'			=> 'Algunos navegadores pueden ser engañados para que asuman un mimetype de archivos subibles incorrecto. Esta opción previene que tales archivos que puedan causar eso sean rechazados.',
	'TranslitFileName'			=> 'Transliterar nombres de archivo:',
	'TranslitFileNameInfo'		=> 'Si es aplicable y no hay necesidad de tener caracteres Unicode, se recomienda encarecidamente aceptar sólo caracteres alfanuméricos.',

	'Thumbnails'				=> 'Miniaturas',
	'CreateThumbnail'			=> 'Crear vista en miniatura:',
	'CreateThumbnailInfo'		=> 'Crear vista en miniatura siempre que sea posible.',
	'MaxThumbWidth'				=> 'Ancho máximo de la vista en miniatura en píxeles:',
	'MaxThumbWidthInfo'			=> 'La mini-imagen generada no excederá este ancho.',
	'MinThumbFilesize'			=> 'Tamaño mínimo para vista en miniatura:',
	'MinThumbFilesizeInfo'		=> 'No crear vista en miniatura para imágenes más pequeñas que esto.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Lista de páginas, revisiones y archivos eliminados.
									Finalmente elimine o restaure las páginas, revisiones o archivos de la base de datos haciendo clic en el enlace <em>Remove</em>
									or <em>Restore</em> en la fila correspondiente. (¡Tenga cuidado, no se solicita confirmación de eliminación!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Palabras que serán automáticamente censuradas en su Wiki.',
	'FilterSettingsUpdated'		=> 'Configuración actualizada del filtro de spam',

	'WordCensoringSection'		=> 'Censura de palabras',
	'SPAMFilter'				=> 'Filtro de SPAM:',
	'SPAMFilterInfo'			=> 'Habilitación del Filtro de SPAM',
	'WordList'					=> 'Lista de palabras:',
	'WordListInfo'				=> 'Palabra o frase <code>fragmento</code> a incluir en la lista negra (una por línea)',

	// Log module
	'LogFilterTip'				=> 'Filtrar eventos por criterios:',
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

	'NoUser'					=> 'Sin usuario',
	'NoUserGroup'				=> 'Sin grupo de usuarios',

	'SendToGroup'				=> 'Enviar a grupo',
	'SendToUser'				=> 'Enviar a usuario',
	'SendToUserInfo'			=> 'Envía sólo mensajes a aquellos usuarios que permitieron a los administradores enviarles información por correo electrónico. Esta opción está disponible en sus opciones de usuario en Notificaciones.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Mensaje de sistema actualizado',

	'SysMsgSection'				=> 'Mensaje de sistema',
	'SysMsg'					=> 'Mensaje de sistema',
	'SysMsgInfo'				=> 'Su texto aquí',

	'SysMsgType'				=> 'Tipo',
	'SysMsgTypeInfo'			=> 'Tipo de mensaje (CSS).',
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
	'BackupCluster'				=> 'Clúster',
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
	'DirectoryNotExecutable'	=> 'El directorio %1 no es ejecutable.',
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

	'RestoreStarted'			=> 'Restauración iniciada',
	'RestoreParameters'			=> 'Usando parámetros',
	'IgnoreDuplicatedKeys'		=> 'Ignorar claves duplicadas',
	'IgnoreDuplicatedFiles'		=> 'Ignorar archivos duplicados',
	'SavedCluster'				=> 'Clúster guardado',
	'DataProtection'			=> 'Protección de datos: %1 omitido',
	'AssumeDropTable'			=> 'Asumir %1',
	'RestoreTableStructure'		=> 'Restaurando la estructura de la tabla',
	'RunSqlQueries'				=> 'Realizar instrucciones SQL',
	'CompletedSqlQueries'		=> 'Terminado. Instrucciones procesadas',
	'NoTableStructure'			=> 'La estructura de las tablas no se guardó - omitir',
	'RestoreRecords'			=> 'Restaurar el contenido de las tablas',
	'ProcessTablesDump'			=> 'Simplemente descargue y procese el volcado de tablas',
	'Instruction'				=> 'Instrucción',
	'RestoredRecords'			=> 'registros',
	'RecordsRestoreDone'		=> 'Terminado. Entradas totales',
	'SkippedRecords'			=> 'Datos no guardados - omitir',
	'RestoringFiles'			=> 'Restaurando archivos',
	'DecompressAndStore'		=> 'Descomprime y almacena el contenido de directorios',
	'HomonymicFiles'			=> 'archivos homonímicos',
	'RestoreSkip'				=> 'omitir',
	'RestoreReplace'			=> 'reemplazar',
	'RestoreFile'				=> 'Archivo',
	'Restored'					=> 'restaurada',
	'Skipped'					=> 'omitida',
	'FileRestoreDone'			=> 'Terminado. Archivos totales',
	'FilesAll'					=> 'todo',
	'SkipFiles'					=> 'Los archivos no se almacenan - omitir',
	'RestoreDone'				=> 'RESTAURACIÓN REALIZADA',

	'BackupCreationDate'		=> 'Fecha de creación',
	'BackupPackageContents'		=> 'El contenido del paquete',
	'BackupRestore'				=> 'Restaurar',
	'BackupRemove'				=> 'Eliminar',
	'RestoreYes'				=> 'Sí',
	'RestoreNo'					=> 'No',
	'LogDbRestored'				=> 'Copia de seguridad ##%1## de la base de datos restaurada.',

	// User module
	'UsersInfo'					=> 'Aquí puede cambiar la información de sus usuarios y ciertas opciones específicas.',

	'UsersAdded'				=> 'Usuario agregado',
	'UsersDeleteInfo'			=> '[El usuario puede borrar la información aquí..]',
	'EditButton'				=> 'Editar',
	'UsersAddNew'				=> 'Nuevo usuario',
	'UsersDelete'				=> '¿Estás seguro de que quieres eliminar el usuario %1?',
	'UsersDeleted'				=> 'Usuario %1 eliminado de la base de datos.',
	'UsersRename'				=> 'Renombrar usuario %1 a',
	'UsersRenameInfo'			=> '* Observación: El cambio afectará a todas las páginas asignadas a este usuario.',
	'UsersUpdated'				=> 'Usuario actualizado satisfactoriamente.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Hora de registro',
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
	'LogGroupRenamed'			=> 'Grupo ##%1## renombrado a ##%2##',
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

	// Statistics module
	'DbStatSection'				=> 'Estadísticas de base de datos',
	'DbTable'					=> 'Tabla',
	'DbRecords'					=> 'Registros',
	'DbSize'					=> 'Tamaño',
	'DbIndex'					=> 'Índice',
	'DbOverhead'				=> 'Gastos generales',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'Sistema de archivos Estadísticas',
	'FileFolder'				=> 'Carpeta',
	'FileFiles'					=> 'Archivos',
	'FileSize'					=> 'Tamaño',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Información de la versión:',
	'SysParameter'				=> 'Parámetro',
	'SysValues'					=> 'Valores',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Última actualización',
	'ServerOS'					=> 'Sistema Operativo',
	'ServerName'				=> 'Nombre del servidor',
	'WebServer'					=> 'Servidor web',
	'HttpProtocol'				=> 'Protocolo HTTP',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'Modos de SQL Global',
	'SqlModesSession'			=> 'Sesión de modos SQL',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memoria',
	'UploadFilesizeMax'			=> 'Subir el tamaño máximo de los archivos',
	'PostMaxSize'				=> 'Publicar tamaño máximo',
	'MaxExecutionTime'			=> 'Tiempo máximo de ejecución',
	'SessionPath'				=> 'Ruta de la sesión',
	'PhpDefaultCharset'			=> 'Conjunto de caracteres predeterminado de PHP',
	'GZipCompression'			=> 'Compresión GZip',
	'PhpExtensions'				=> 'Extensiones de PHP',
	'ApacheModules'				=> 'Módulos de Apache',

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
	'BbEnableInfo'				=> 'Todas las demás configuraciones se pueden cambiar en la carpeta de configuración %1.',
	'BbStats'					=> 'Bad Behavior ha bloqueado %1 intentos de acceso en los últimos 7 días.',

	'BbSummary'					=> 'Resumen',
	'BbLog'						=> 'Log',
	'BbSettings'				=> 'Configuraciones',
	'BbWhitelist'				=> 'Lista blanca',

	// --> Log
	'BbHits'					=> 'Hits',
	'BbRecordsFiltered'			=> 'Displaying %1 of %2 records filtered by',
	'BbStatus'					=> 'Estado',
	'BbBlocked'					=> 'Bloqueada',
	'BbPermitted'				=> 'Permitted',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Mostrando todos los registros %1',
	'BbShow'					=> 'Mostrar',
	'BbIpDateStatus'			=> 'IP/Fecha/Estado',
	'BbHeaders'					=> 'Encabezados',
	'BbEntity'					=> 'Entidad',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Opciones guardadas.',
	'BbWhitelistHint'			=> '¡Las listas blancas inapropiadas lo expondrán a spam o harán que Mal comportamiento deje de funcionar por completo! NO HAGA UNA LISTA BLANCA a menos que esté 100% SEGURO de que debe hacerlo.',
	'BbIpAddress'				=> 'Dirección IP',
	'BbIpAddressInfo'			=> 'La dirección IP o los rangos de direcciones en formato CIDR se incluirán en la lista blanca (uno por línea)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'Fragmentos de URL que comienzan con / después del nombre de host de su sitio web (uno por línea)',
	'BbUserAgent'				=> 'Agente de usuario',
	'BbUserAgentInfo'			=> 'Cadenas de agentes de usuario que se incluirán en la lista blanca (una por línea)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Configuración actualizada de mal comportamiento',
	'BbLogRequest'				=> 'Registro de solicitud HTTP',
	'BbLogVerbose'				=> 'Verbosa',
	'BbLogNormal'				=> 'Normal (recomendada)',
	'BbLogOff'					=> 'No inicie sesión (no recomendada)',
	'BbSecurity'				=> 'Seguridad',
	'BbStrict'					=> 'Control estricto',
	'BbStrictInfo'				=> 'bloquea más spam, pero puede bloquear a algunas personas',
	'BbOffsiteForms'			=> 'Permitir publicaciones de formularios desde otros sitios web',
	'BbOffsiteFormsInfo'		=> 'requerido para OpenID; aumenta el spam recibido',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Usar malos comportamientos http:BL características que debe tener un %1',
	'BbHttpblKey'				=> 'http:BL Llave de acceso',
	'BbHttpblThreat'			=> 'Nivel mínimo de amenaza (se recomienda 25)',
	'BbHttpblMaxage'			=> 'Antigüedad máxima de los datos (se recomienda 30)',
	'BbReverseProxy'			=> 'Proxy inverso/equilibrador de carga',
	'BbReverseProxyInfo'		=> 'Si utiliza un comportamiento incorrecto detrás de un proxy inverso, equilibrador de carga, acelerador HTTP, caché de contenido o tecnología similar, habilite la opción Proxy inverso.<br>' .
									'Si tiene una cadena de dos o más proxies inversos entre su servidor y la Internet pública, debe especificar <em>todos</em> los rangos de direcciones IP (en formato CIDR) de todos sus servidores proxy, balanceadores de carga, etc. De lo contrario, es posible que Bad Behavior no pueda determinar la verdadera dirección IP del cliente<br>' .
									'Además, sus servidores proxy inversos deben establecer la dirección IP del cliente de Internet desde el que recibieron la solicitud en un encabezado HTTP. Si no especifica un encabezado, se usará %1. La mayoría de los servidores proxy ya son compatibles con X-Fordered-For y solo necesitará asegurarse de que esté habilitado en sus servidores proxy. Algunos otros nombres de encabezados de uso común incluyen %2 y %3.',
	'BbReverseProxyEnable'		=> 'Habilitar proxy inverso',
	'BbReverseProxyHeader'		=> 'Encabezado que contiene la dirección IP de los clientes de Internet',
	'BbReverseProxyAddresses'	=> 'Dirección IP o rangos de direcciones en formato CIDR para sus servidores proxy (uno por línea)',

];
