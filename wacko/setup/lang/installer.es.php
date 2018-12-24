<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'iso-8859-1',
'LangISO' => 'es',
'LangName' => 'Espa�ol',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// site name
	'site_name'			=> 'MyWikiSite',

	// pages
	'category_page'		=> 'Categor�a',
	'groups_page'		=> 'Grupos',
	'users_page'		=> 'Usuarios',

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
'Title' => 'Instalaci�n WackoWiki',
'Continue' => 'Continuar',
'Back' => 'Volver',
'Recommended' => 'recomendado',
'InvalidAction' => 'Invalid action',

/*
   Language Selection Page
*/
'lang' => 'Configuraci�n de Idioma',
'PleaseUpgradeToR5' => 'Usted est� ejecutando una versi�n antigua (pre 5.0.0) de WackoWiki. Para actualizar a �sta  versi�n de WackoWiki debe realizar antes una actualizaci�n a versi�n <code class="version">5.0.x</code>.',
'UpgradeFromWacko' => 'Bienvenido a WackoWiki, aparentemente est� actualizando de WackoWiki <code class="version">%1</code> a <code class="version">%2</code>. Las siguientes p�ginas le guiar�n por el proceso de actualizaci�n.',
'FreshInstall' => 'Bienvenido a WackoWiki, est� a punto de instalar WackoWiki <code class="version">%1</code>. Las siguientes p�ginas le guiar�n por el proceso de actualizaci�n.',
'PleaseBackup' => 'Favor, real�ce una copia de respaldo de la base de datos, archivos de configuraci�n, y todos los archivos modificados, hackeados o parcheados antes de iniciar el proceso de actualizaci�n. Esto le puedo salvar de un gran dolor de cabeza.',
'LangDesc' => 'Favor seleccione un idioma para el proceso de instalaci�n. El idioma tambien ser� aplicado como idioma por defecto para la instalaci�n de WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'Requerimientos del Sistema',
'PHPVersion' => 'Versi�n PHP',
'PHPDetected' => 'PHP detectado',
'ModRewrite' => 'Extensi�n Apache Rewrite (Opcional)',
'ModRewriteInstalled' => 'Extensi�n Rewrite (mod_rewrite) Instalado?',
'Database' => 'Base de datos',
'PHPExtensions' => 'PHP Extensions',
'Permissions' => 'Permisos',
'ReadyToInstall' => 'Listo para instalar?',
'Requirements' => 'El servidor debe cumplir los requerimientos listados abajo.',
'OK' => 'OK',
'Problem' => 'Problema',
'NotePHPExtensions' => '',
'ErrorPHPExtensions' => 'Your PHP installation appears to be missing the noted PHP extensions which are required by WackoWiki.',
'PCREwithoutUTF8' => 'PCRE no est� compilado con soporte UTF-8.',
'NotePermissions' => 'El instalador intentar� guardar los datos de configuraci�n en el archivo %1, ubicado en el directorio de WackoWiki. Para que pueda funcionar esto debe asegurarse que el servidor web tiene permiso de escritura para este archivo. Si no lo logra concederle, deber� editar el archivo manualmente (el instalador le dar� indicaciones de como..).<br><br>V�a <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> por m�s detalles.',
'ErrorPermissions' => 'Parece que el instalador no puede setear los permisos de archivos para el funcionamiento correcto de WackoWiki. M�s adelante se le va a pedir de realizar los cambios de permisos necesarios manualmente en el servidor.',
'ErrorMinPHPVersion' => 'La versi�n PHP debe ser mayor a <strong>' . PHP_MIN_VERSION . '</strong>, el servidor parece tener instalado una versi�n anterior. PHP se debe actualizar a una versi�n m�s nueva para que WackoWiki pueda funcionar correctamente.',
'Ready' => 'Felicidades, su servidor parece ser capaz de ejecutar WackoWiki. Las p�ginas siguientes le guiar�n a trav�s del proceso de configuraci�n.',

/*
   Site Config Page
*/
'site-config' => 'Configuraci�n del sitio',
'SiteName' => 'Nombre Wiki',
'SiteNameDesc' => 'Por favor ingrese el nombre de su sitio Wiki.',
'HomePage' => 'P�gina de inicio',
'HomePageDesc' => 'Ingrese el nombre de la p�gina de inicio del sitio, esto ser� la p�gina por defecto que los visitantes ver�n y deber�a ser escrito de manera <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">NombreWiki</a>.',
'HomePageDefault' => 'HomePage',
'MultiLang' => 'Modo Multi Idioma',
'MultiLangDesc' => 'Modo Multi-idioma permite con una sola instalaci�n mantener p�ginas con diferentes preferencias de idioma. Al habilitar este modo, el instalador crear� las p�ginas iniciales en todos los idiomas disponibles en la instalaci�n.',
'AllowedLang' => 'Idiomas permitidos',
'AllowedLangDesc' => 'Se recomienda seleccionar �nicamente los idiomas que va a utilizar, sino se selecionar�n todos los idiomas.',
'Admin' => 'Nombre de Administrador',
'AdminDesc' => 'Ingrese el nombre de usuario del administrador, esto deber�a escrito de manera <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">NombreWiki</a> (e.g. <code>WikiAdmin</code>).',
'Password' => 'Contrase�a del Administrador',
'PasswordDesc' => 'Elija una contrase�a del administrador con un m�nimo de %1 caracteres.',
'Password2' => 'Repita la Contrase�a:',
'Mail' => 'Email del Administrador',
'MailDesc' => 'Ingrese la dierecci�n email del administrador.',
'Base' => 'URL Base',
'BaseDesc' => 'La URL base del sitio WackoWiki. Se adjuntan los nombres de l�s p�ginas, y si est� usando mod_rewrite, la direcci�n deber�a terminar con una barra i.e.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => 'Modo Rewrite',
'RewriteDesc' => 'Se debe habilitar Modo Rewrite si est� usando WackoWiki con reescritura URL.',
'Enabled' => 'Habilitado:',
'ErrorAdminEmail' => 'La direcci�n email ingresada no est� v�lida!',
'ErrorAdminPasswordMismatch' => 'Las contrase�as no coinciden!.',
'ErrorAdminPasswordShort' => 'La contrase�a del administrador es demasiado corta, longitud m�nima es %1 caracteres!',
'WarningRewriteMode' => 'ATENCION!\nLa URL base se ve extra�a considerando la configuraci�n de modo rewrite. Generalmente no hay el signo ? en la URL base si el modo rewrite est� activado - pero actualmente est� presente.\n\nPara continuar usando la configuraci�n actual presione OK.\nPara volver al formulario y modificar los datos de configuraci�n presione CANCEL.\n\nSi tiene la intenci�n de continuar con la configuraci�n actual puede tener problemas con la instalaci�n de WackoWiki.',
'ModRewriteStatusUnknown' => 'El instalador no puede verificar si el modo mod_rewrite est� habilitado, sin embargo no quiere decir que est� deshabilitado',

'LanguageArray'	=> [
	'bg' => 'b�lgaro',
	'da' => 'dandan�s',
	'nl' => 'holand�s',
	'el' => 'griego',
	'en' => 'ingl�s',
	'et' => 'estonio',
	'fr' => 'franc�s',
	'de' => 'alem�n',
	'hu' => 'h�ngaro',
	'it' => 'italiano',
	'pl' => 'polaco',
	'pt' => 'portugu�s',
	'ru' => 'ruso',
	'es' => 'espa�ol',
],

/*
   Database Config Page
*/
'database-config' => 'Configuraci�n de Base de Datos',
'DBDriver' => 'Controlador',
'DBDriverDesc' => 'Controlador de base de datos a utilizar. Debe elegir un controlador legacy si no tiene <a href="http://de2.php.net/pdo" target="_blank">PDO</a> instalado.',
'DBCharset' => 'Charset',
'DBCharsetDesc' => 'The database charset you want to use.',
'DBEngine' => 'Engine',
'DBEngineDesc' => 'The database engine you want to use. You must choose MyISAM engine if you do not have at least MariaDB 10 or MySql 5.6 (or greater) and InnoDB support available.',
'DBHost' => 'Host',
'DBHostDesc' => 'El host del servidor de la base de datos. Generalmente <code>127.0.0.1</code> u <code>localhost</code> (ie, la misma computadora que tambien tiene el sitio WackoWiki).',
'DBPort' => 'Puerto (Opcional)',
'DBPortDesc' => 'N�mero de puerto para acceder al servidor de base de datos, dejelo en blanco para usar el puerto por defecto.',
'DB' => 'Nombre de base de datos',
'DBDesc' => 'La base de datos usado por WackoWiki. Esta base de datos ya debe estar creada antes de continuar con la instalaci�n!',
'DBUserDesc' => 'Nombre del usuario para la conexi�n con la base de datos.',
'DBUser' => 'Nombre de usuario',
'DBPasswordDesc' => 'Contrase�a del usuario para la conexi�n con la base de datos.',
'DBPassword' => 'Contrase�a',
'PrefixDesc' => 'Prefijo de todas las tablas de WackoWiki. Esto le permite realizar multiples instalaciones de WackoWiki usando una sola base de datos, pero con distintos prefijos de las tablas (e.g. wacko_).',
'Prefix' => 'Prefijo de las tablas',
'ErrorNoDbDriverDetected' => 'No se detect� un controlador de base de datos, por favor habilite la extensi�n mysql, mysqli o pdo en php.ini.',
'ErrorNoDbDriverSelected' => 'Ningun controlador de base de datos seleccionado, por favor elija uno de la lista.',
'DeleteTables' => 'Eliminar tablas existentes?',
'DeleteTablesDesc' => 'ATENCI�N! Si procede seleccionando esta opci�n se eliminar�n todos los datos actuales de la base de datos del wiki. No se puede deshacer al no ser que tiene los datos en un backup para recuperarlos manualmente.',
'ConfirmTableDeletion' => 'Est� seguro que desea eliminar todas las tablas del wiki actual?',

/*
   Database Installation Page
*/
'database-install' => 'Instalaci�n de base de datos',
'TestingConfiguration' => 'Comprobando la configuraci�n',
'TestConnectionString' => 'Comprobando configuraci�n de la conexi�n con la base de datos',
'TestDatabaseExists' => 'Verificando si existe la base de datos especificada',
'InstallingTables' => 'Instalando tablas',
'ErrorDBConnection' => 'Ocurri� un problema con la configuraci�n de la conexi�n con la base de datos, por favor retroceda para verificar.',
'ErrorDBExists' => 'Base de datos no encontrada. Recuerde que debe existir ya, para poder instalar/actualizar WackoWiki!',
'To' => 'a',
'AlterTable' => 'Alterando <code>%1</code> Tabla',
'RenameTable' => 'Renaming <code>%1</code> Table',
'UpdateTable' => 'Updating <code>%1</code> Table',
'InstallingDefaultData' => 'Insertando Datos iniciales',
'InstallingPagesBegin' => 'Agregando P�ginas por defecto',
'InstallingPagesEnd' => 'Fin de agregar p�ginas por defecto',
'InstallingSystemAccount' => 'Agregando usuario <code>System</code>',
'InstallingDeletedAccount' => 'Agregando usuario <code>Deleted</code>',
'InstallingAdmin' => 'Agregando usuario Administrador',
'InstallingAdminSetting' => 'Agregando usuario Administrador',
'InstallingAdminGroup' => 'Agregando grupo Administrador',
'InstallingAdminGroupMember' => 'Agregando miembro del grupo administrador',
'InstallingEverybodyGroup' => 'Agregando grupo Todos',
'InstallingModeratorGroup' => 'Agregando grupo moderador',
'InstallingReviewerGroup' => 'Agregando grupo Reviewer',
'InstallingLogoImage' => 'Agregando Im�gen de Logo',
'InstallingConfigValues' => 'Agregando valores de configuraci�n',
'ErrorInsertingPage' => 'Error al insertar <code>%1</code> p�gina',
'ErrorInsertingPageReadPermission' => 'Error al establecer permisos de lectura para <code>%1</code> p�gina',
'ErrorInsertingPageWritePermission' => 'Error al establecer permisos de escritura para <code>%1</code> p�gina',
'ErrorInsertingPageCommentPermission' => 'Error al establecer permisos de comentario para <code>%1</code> p�gina',
'ErrorInsertingPageCreatePermission' => 'Error al establecer permisos para p�gina <code>%1</code> ',
'ErrorInsertingPageUploadPermission' => 'Error al establecer permisos de subida de adjuntos para p�gina <code>%1</code> ',
'ErrorInsertingDefaultMenuItem' => 'Error al establecer p�gina <code>%1</code> como �tem predeterminado del men�',
'ErrorPageAlreadyExists' => '<code>%1</code> p�gina ya existe',
'ErrorAlteringTable' => 'Error alterando <code>%1</code> tabla',
'ErrorRenamingTable' => 'Error al renombrar tabla <code>%1</code> ',
'ErrorUpdatingTable' => 'Error al actualizar tabla <code>%1</code> ',
'CreatingTable' => 'Creando <code>%1</code> tabla',
'ErrorAlreadyExists' => '<code>%1</code> ya existe',
'ErrorCreatingTable' => 'Error al crear <code>%1</code> tabla, ya existe ?',
'ErrorMovingRevisions' => 'Error al mover datos de revisi�n',
'MovingRevisions' => 'Moviendo datos a tabla de revisi�n',
'DeletingTables' => 'Eliminando Tablas',
'DeletingTablesEnd' => 'Tablas eliminados',
'ErrorDeletingTable' => 'Error al eliminar tabla <code>%1</code>, en caso que no existe la tabla puede ignorar esta advertencia.',
'DeletingTable' => 'Eliminando tabla <code>%1</code> ',

/*
   Write Config Page
*/
'write-config' => 'Guardando Archivo de Configuraci�n',
'FinalStep' => 'Paso Final',
'Writing' => 'Guardando Archivo de Configuraci�n',
'RemovingWritePrivilege' => 'Quitando Privilegios de Escritura',
'InstallationComplete' => 'Instalaci�n completa',
'ThatsAll' => 'Termin�! Ahora puede ingresar <a href="%1">al sitio WackoWiki</a>.',
'SecurityConsiderations' => 'Consideraciones de Seguridad',
'SecurityRisk' => 'Le recomendamos remover el privilegio de escritura para el archivo %1 ya que ahora est� guardado. Si el archivo permanece con privilegios de escritura, puede correr un riesgo de seguridad!',
'RemoveSetupDirectory' => 'Deber�a eliminar ahora el directorio <code>setup/</code> ya que se finaliz� la instalaci�n.',
'ErrorGivePrivileges' => 'No fue posible guardar el archivo de configuraci�n %1. Deber�a dar temporalmente permisos al servidor web para el directorio de WackoWiki, o al menos un archivo en blanco llamado %1<br>%2<br>; no se olvide de remover los privilegios de escritura m�s adelante, i.e. %3.<br>Si por algun  motivo no lo logra hacer, deber�a copiar el texto abajo en un archivo nuevo, y guardarlo/subirlo como %1 al directorio de WackoWiki. Hecho esto el sitio WackoWiki deber�a funcionar. Si contin�a con problemas, visite <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'En el paso siguiente el instalador intentar� guardar el archivo con las configuraciones actualizadas, %1. Por favor asegurese que el servidor web tenga acceso de escritura al archivo, o lo tendr� que editar manualmente. Vea <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> por detalles.',
'WrittenAt' => 'Guardado ',
'DontChange' => 'no cambie manualmente wacko_version!',
'ConfigDescription' => 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain' => 'Intente de Nuevo',

];
?>
