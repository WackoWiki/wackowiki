<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'utf-8',
'LangISO' => 'es',
'LangName' => 'Español',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// site name
	'site_name'			=> 'MyWikiSite',

	// pages
	'category_page'		=> 'Categoría',
	'groups_page'		=> 'Grupos',
	'users_page'		=> 'Usuarios',

	'search_page'		=> 'Buscar',
	'login_page'		=> 'Conectar',
	'account_page'		=> 'Preferencias',
	'registration_page'	=> 'Registrarse',
	'password_page'		=> 'Password',

	'changes_page'		=> 'UltimasModificaciones',
	'comments_page'		=> 'UltimosComentarios',
	'index_page'		=> 'IndiceDePaginas',

	'random_page'		=> 'PáginaAleatoria',
	#'help_page'			=> 'Ayuda',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',

	// time
	#'date_format'					=> 'd.m.Y',
	#'time_format'					=> 'H:i',
	#'time_format_seconds'			=> 'H:i:s',
],

/*
   Generic Page Text
*/
'Title' => 'Instalación WackoWiki',
'Continue' => 'Continuar',
'Back' => 'Volver',
'Recommended' => 'recomendado',
'InvalidAction' => 'Invalid action',

/*
   Language Selection Page
*/
'lang' => 'Configuración de Idioma',
'PleaseUpgradeToR5' => 'Usted está ejecutando una versión antigua (pre 5.0.0) de WackoWiki. Para actualizar a ésta  versión de WackoWiki debe realizar antes una actualización a versión <code class="version">5.0.x</code>.',
'UpgradeFromWacko' => 'Bienvenido a WackoWiki, aparentemente está actualizando de WackoWiki <code class="version">%1</code> a <code class="version">%2</code>. Las siguientes páginas le guiarán por el proceso de actualización.',
'FreshInstall' => 'Bienvenido a WackoWiki, está a punto de instalar WackoWiki <code class="version">%1</code>. Las siguientes páginas le guiarán por el proceso de actualización.',
'PleaseBackup' => 'Favor, realíce una copia de respaldo de la base de datos, archivos de configuración, y todos los archivos modificados, hackeados o parcheados antes de iniciar el proceso de actualización. Esto le puedo salvar de un gran dolor de cabeza.',
'LangDesc' => 'Favor seleccione un idioma para el proceso de instalación. El idioma tambien será aplicado como idioma por defecto para la instalación de WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'Requerimientos del Sistema',
'PHPVersion' => 'Versión PHP',
'PHPDetected' => 'PHP detectado',
'ModRewrite' => 'Extensión Apache Rewrite (Opcional)',
'ModRewriteInstalled' => 'Extensión Rewrite (mod_rewrite) Instalado?',
'Database' => 'Base de datos',
'PHPExtensions' => 'PHP Extensions',
'Permissions' => 'Permisos',
'ReadyToInstall' => 'Listo para instalar?',
'Requirements' => 'El servidor debe cumplir los requerimientos listados abajo.',
'OK' => 'OK',
'Problem' => 'Problema',
'NotePHPExtensions' => '',
'ErrorPHPExtensions' => 'Su instalación de PHP parece carecer de las extensiones PHP que WackoWiki requiere.',
'PCREwithoutUTF8' => 'PCRE no está compilado con soporte UTF-8.',
'NotePermissions' => 'El instalador intentará guardar los datos de configuración en el archivo %1, ubicado en el directorio de WackoWiki. Para que pueda funcionar esto debe asegurarse que el servidor web tiene permiso de escritura para este archivo. Si no lo logra concederle, deberá editar el archivo manualmente (el instalador le dará indicaciones de como..).<br><br>Véa <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> por más detalles.',
'ErrorPermissions' => 'Parece que el instalador no puede setear los permisos de archivos para el funcionamiento correcto de WackoWiki. Más adelante se le va a pedir de realizar los cambios de permisos necesarios manualmente en el servidor.',
'ErrorMinPHPVersion' => 'La versión PHP debe ser mayor a <strong>' . PHP_MIN_VERSION . '</strong>, el servidor parece tener instalado una versión anterior. PHP se debe actualizar a una versión más nueva para que WackoWiki pueda funcionar correctamente.',
'Ready' => 'Felicidades, su servidor parece ser capaz de ejecutar WackoWiki. Las páginas siguientes le guiarán a través del proceso de configuración.',

/*
   Site Config Page
*/
'site-config' => 'Configuración del sitio',
'SiteName' => 'Nombre Wiki',
'SiteNameDesc' => 'Por favor ingrese el nombre de su sitio Wiki.',
'HomePage' => 'Página de inicio',
'HomePageDesc' => 'Ingrese el nombre de la página de inicio del sitio, esto será la página por defecto que los visitantes verán y debería ser escrito de manera <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">NombreWiki</a>.',
'HomePageDefault' => 'HomePage',
'MultiLang' => 'Modo Multi Idioma',
'MultiLangDesc' => 'Modo Multi-idioma permite con una sola instalación mantener páginas con diferentes preferencias de idioma. Al habilitar este modo, el instalador creará las páginas iniciales en todos los idiomas disponibles en la instalación.',
'AllowedLang' => 'Idiomas permitidos',
'AllowedLangDesc' => 'Se recomienda seleccionar únicamente los idiomas que va a utilizar, sino se selecionarán todos los idiomas.',
'Admin' => 'Nombre de Administrador',
'AdminDesc' => 'Ingrese el nombre de usuario del administrador, esto debería escrito de manera <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">NombreWiki</a> (e.g. <code>WikiAdmin</code>).',
'Password' => 'Contraseña del Administrador',
'PasswordDesc' => 'Elija una contraseña del administrador con un mínimo de %1 caracteres.',
'Password2' => 'Repita la Contraseña:',
'Mail' => 'Email del Administrador',
'MailDesc' => 'Ingrese la dierección email del administrador.',
'Base' => 'URL Base',
'BaseDesc' => 'La URL base del sitio WackoWiki. Se adjuntan los nombres de lás páginas, y si está usando mod_rewrite, la dirección debería terminar con una barra i.e.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => 'Modo Rewrite',
'RewriteDesc' => 'Se debe habilitar Modo Rewrite si está usando WackoWiki con reescritura URL.',
'Enabled' => 'Habilitado:',
'ErrorAdminEmail' => 'La dirección email ingresada no está válida!',
'ErrorAdminPasswordMismatch' => 'Las contraseñas no coinciden!.',
'ErrorAdminPasswordShort' => 'La contraseña del administrador es demasiado corta, longitud mínima es %1 caracteres!',
'WarningRewriteMode' => 'ATENCION!\nLa URL base se ve extraña considerando la configuración de modo rewrite. Generalmente no hay el signo ? en la URL base si el modo rewrite está activado - pero actualmente está presente.\n\nPara continuar usando la configuración actual presione OK.\nPara volver al formulario y modificar los datos de configuración presione CANCEL.\n\nSi tiene la intención de continuar con la configuración actual puede tener problemas con la instalación de WackoWiki.',
'ModRewriteStatusUnknown' => 'El instalador no puede verificar si el modo mod_rewrite está habilitado, sin embargo no quiere decir que está deshabilitado',

'LanguageArray'	=> [
	'bg' => 'búlgaro',
	'da' => 'dandanés',
	'nl' => 'holandés',
	'el' => 'griego',
	'en' => 'inglés',
	'et' => 'estonio',
	'fr' => 'francés',
	'de' => 'alemán',
	'hu' => 'húngaro',
	'it' => 'italiano',
	'pl' => 'polaco',
	'pt' => 'portugués',
	'ru' => 'ruso',
	'es' => 'español',
],

/*
   Database Config Page
*/
'database-config' => 'Configuración de Base de Datos',
'DBDriver' => 'Controlador',
'DBDriverDesc' => 'Controlador de base de datos a utilizar. Debe elegir un controlador legacy si no tiene <a href="https://secure.php.net/pdo" target="_blank">PDO</a> instalado.',
'DBCharset' => 'Charset',
'DBCharsetDesc' => 'El conjunto de caracteres de la base de datos que desea utilizar.',
'DBEngine' => 'Engine',
'DBEngineDesc' => 'El motor de base de datos que desea utilizar.',
'DBHost' => 'Host',
'DBHostDesc' => 'El host del servidor de la base de datos. Generalmente <code>127.0.0.1</code> u <code>localhost</code> (ie, la misma computadora que tambien tiene el sitio WackoWiki).',
'DBPort' => 'Puerto (Opcional)',
'DBPortDesc' => 'Número de puerto para acceder al servidor de base de datos, dejelo en blanco para usar el puerto por defecto.',
'DB' => 'Nombre de base de datos',
'DBDesc' => 'La base de datos usado por WackoWiki. Esta base de datos ya debe estar creada antes de continuar con la instalación!',
'DBUserDesc' => 'Nombre del usuario para la conexión con la base de datos.',
'DBUser' => 'Nombre de usuario',
'DBPasswordDesc' => 'Contraseña del usuario para la conexión con la base de datos.',
'DBPassword' => 'Contraseña',
'PrefixDesc' => 'Prefijo de todas las tablas de WackoWiki. Esto le permite realizar multiples instalaciones de WackoWiki usando una sola base de datos, pero con distintos prefijos de las tablas (e.g. wacko_).',
'Prefix' => 'Prefijo de las tablas',
'ErrorNoDbDriverDetected' => 'No se detectó un controlador de base de datos, por favor habilite la extensión mysql, mysqli o pdo en php.ini.',
'ErrorNoDbDriverSelected' => 'Ningun controlador de base de datos seleccionado, por favor elija uno de la lista.',
'DeleteTables' => 'Eliminar tablas existentes?',
'DeleteTablesDesc' => 'ATENCIÖN! Si procede seleccionando esta opción se eliminarán todos los datos actuales de la base de datos del wiki. No se puede deshacer al no ser que tiene los datos en un backup para recuperarlos manualmente.',
'ConfirmTableDeletion' => 'Está seguro que desea eliminar todas las tablas del wiki actual?',

/*
   Database Installation Page
*/
'database-install' => 'Instalación de base de datos',
'TestingConfiguration' => 'Comprobando la configuración',
'TestConnectionString' => 'Comprobando configuración de la conexión con la base de datos',
'TestDatabaseExists' => 'Verificando si existe la base de datos especificada',
'InstallingTables' => 'Instalando tablas',
'ErrorDBConnection' => 'Ocurrió un problema con la configuración de la conexión con la base de datos, por favor retroceda para verificar.',
'ErrorDBExists' => 'Base de datos no encontrada. Recuerde que debe existir ya, para poder instalar/actualizar WackoWiki!',
'To' => 'a',
'AlterTable' => 'Alterando %1 Tabla',
'InsertRecord' => 'Inserting Record into %1 table',
'RenameTable' => 'Renombrar tabla %1',
'UpdateTable' => 'Actualizar tabla %1',
'InstallingDefaultData' => 'Insertando Datos iniciales',
'InstallingPagesBegin' => 'Agregando Páginas por defecto',
'InstallingPagesEnd' => 'Fin de agregar páginas por defecto',
'InstallingSystemAccount' => 'Agregando usuario <code>System</code>',
'InstallingDeletedAccount' => 'Agregando usuario <code>Deleted</code>',
'InstallingAdmin' => 'Agregando usuario Administrador',
'InstallingAdminSetting' => 'Agregando usuario Administrador',
'InstallingAdminGroup' => 'Agregando grupo Administrador',
'InstallingAdminGroupMember' => 'Agregando miembro del grupo administrador',
'InstallingEverybodyGroup' => 'Agregando grupo Todos',
'InstallingModeratorGroup' => 'Agregando grupo moderador',
'InstallingReviewerGroup' => 'Agregando grupo Reviewer',
'InstallingLogoImage' => 'Agregando Imágen de Logo',
'LogoImage' => 'Imágen de Logo',
'InstallingConfigValues' => 'Agregando valores de configuración',
'ConfigValues' => 'Config Values',
'ErrorInsertingPage' => 'Error al insertar %1 página',
'ErrorInsertingPageReadPermission' => 'Error al establecer permisos de lectura para %1 página',
'ErrorInsertingPageWritePermission' => 'Error al establecer permisos de escritura para %1 página',
'ErrorInsertingPageCommentPermission' => 'Error al establecer permisos de comentario para %1 página',
'ErrorInsertingPageCreatePermission' => 'Error al establecer permisos para página %1 ',
'ErrorInsertingPageUploadPermission' => 'Error al establecer permisos de subida de adjuntos para página %1 ',
'ErrorInsertingDefaultMenuItem' => 'Error al establecer página %1 como ítem predeterminado del menú',
'ErrorPageAlreadyExists' => '%1 página ya existe',
'ErrorAlteringTable' => 'Error alterando %1 tabla',
'ErrorInsertingRecord' => 'Error Inserting Record into %1 table',
'ErrorRenamingTable' => 'Error al renombrar tabla %1 ',
'ErrorUpdatingTable' => 'Error al actualizar tabla %1 ',
'CreatingTable' => 'Creando %1 tabla',
'ErrorAlreadyExists' => '%1 ya existe',
'ErrorCreatingTable' => 'Error al crear %1 tabla, ya existe ?',
'ErrorMovingRevisions' => 'Error al mover datos de revisión',
'MovingRevisions' => 'Moviendo datos a tabla de revisión',
'DeletingTables' => 'Eliminando Tablas',
'DeletingTablesEnd' => 'Tablas eliminados',
'ErrorDeletingTable' => 'Error al eliminar tabla %1, en caso que no existe la tabla puede ignorar esta advertencia.',
'DeletingTable' => 'Eliminando tabla %1 ',

/*
   Write Config Page
*/
'write-config' => 'Guardando Archivo de Configuración',
'FinalStep' => 'Paso Final',
'Writing' => 'Guardando Archivo de Configuración',
'RemovingWritePrivilege' => 'Quitando Privilegios de Escritura',
'InstallationComplete' => 'Instalación completa',
'ThatsAll' => 'Terminó! Ahora puede ingresar <a href="%1">al sitio WackoWiki</a>.',
'SecurityConsiderations' => 'Consideraciones de Seguridad',
'SecurityRisk' => 'Le recomendamos remover el privilegio de escritura para el archivo %1 ya que ahora está guardado. Si el archivo permanece con privilegios de escritura, puede correr un riesgo de seguridad!',
'RemoveSetupDirectory' => 'Debería eliminar ahora el directorio %1 ya que se finalizó la instalación.',
'ErrorGivePrivileges' => 'No fue posible guardar el archivo de configuración %1. Debería dar temporalmente permisos al servidor web para el directorio de WackoWiki, o al menos un archivo en blanco llamado %1<br>%2<br>; no se olvide de remover los privilegios de escritura más adelante, i.e. %3.<br>Si por algun  motivo no lo logra hacer, debería copiar el texto abajo en un archivo nuevo, y guardarlo/subirlo como %1 al directorio de WackoWiki. Hecho esto el sitio WackoWiki debería funcionar. Si continúa con problemas, visite <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'En el paso siguiente el instalador intentará guardar el archivo con las configuraciones actualizadas, %1. Por favor asegurese que el servidor web tenga acceso de escritura al archivo, o lo tendrá que editar manualmente. Vea <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> por detalles.',
'WrittenAt' => 'Guardado ',
'DontChange' => 'no cambie manualmente wacko_version!',
'ConfigDescription' => 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain' => 'Intente de Nuevo',

];
?>
