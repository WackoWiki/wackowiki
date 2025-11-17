<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'es',
'LangLocale'	=> 'es_ES',
'LangName'		=> 'Español',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'Categoría',
	'groups_page'		=> 'Grupos',
	'users_page'		=> 'Usuarios',

	'search_page'		=> 'Buscar',
	'login_page'		=> 'Conectar',
	'account_page'		=> 'Preferencias',
	'registration_page'	=> 'Registrarse',
	'password_page'		=> 'Contraseña',

	'whatsnew_page'		=> 'Novedades',
	'changes_page'		=> 'UltimasModificaciones',
	'comments_page'		=> 'UltimosComentarios',
	'index_page'		=> 'IndiceDePaginas',

	'random_page'		=> 'PáginaAleatoria',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'Instalación WackoWiki',
'TitleUpdate'					=> 'Actualización WackoWiki',
'Continue'						=> 'Continuar',
'Back'							=> 'Volver',
'Recommended'					=> 'recomendado',
'InvalidAction'					=> 'Acción no válida',

/*
   Locking Check
 */
'LockAuthorization'				=> 'Autorización',
'LockAuthorizationInfo'			=> 'Por favor, introduzca la contraseña que ha guardado en el archivo %1, que ha colocado temporalmente en su directorio Wacko.',
'LockPassword'					=> 'Contraseña:',
'LockLogin'						=> 'Ingresar',
'LockPasswordInvalid'			=> 'Contraseña no válida.',
'LockedTryLater'				=> 'Este sitio está siendo actualizado. Por favor, inténtalo de nuevo más tarde.',


/*
   Language Selection Page
*/
'lang'							=> 'Configuración de Idioma',
'PleaseUpgradeToR6'				=> 'Usted está ejecutando una versión antigua de WackoWiki %1. Para actualizar a ésta  versión de WackoWiki debe realizar antes una actualización a versión %2.',
'UpgradeFromWacko'				=> 'Bienvenido a WackoWiki, aparentemente está actualizando de WackoWiki %1 a %2. Las siguientes páginas le guiarán por el proceso de actualización.',
'FreshInstall'					=> 'Bienvenido a WackoWiki, está a punto de instalar WackoWiki %1. Las siguientes páginas le guiarán por el proceso de actualización.',
'PleaseBackup'					=> 'Favor, realíce una copia de respaldo de la base de datos, archivos de configuración, y todos los archivos modificados, hackeados o parcheados antes de iniciar el proceso de actualización. Esto le puedo salvar de un gran dolor de cabeza.',
'LangDesc'						=> 'Favor seleccione un idioma para el proceso de instalación. El idioma tambien será aplicado como idioma por defecto para la instalación de WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Requerimientos del Sistema',
'PhpVersion'					=> 'Versión PHP',
'PhpDetected'					=> 'PHP detectado',
'ModRewrite'					=> 'Extensión Apache Rewrite (Opcional)',
'ModRewriteInstalled'			=> 'Extensión Rewrite (mod_rewrite) Instalado?',
'Database'						=> 'Base de datos',
'PhpExtensions'					=> 'Extensiones PHP',
'Permissions'					=> 'Permisos',
'ReadyToInstall'				=> 'Listo para instalar?',
'Requirements'					=> 'El servidor debe cumplir los requerimientos listados abajo.',
'OK'							=> 'Ok',
'Problem'						=> 'Problema',
'Example'						=> 'Ejemplo',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Su instalación de PHP parece carecer de las extensiones PHP que WackoWiki requiere.',
'PcreWithoutUtf8'				=> 'PCRE no está compilado con soporte UTF-8.',
'NotePermissions'				=> 'El instalador intentará guardar los datos de configuración en el archivo %1, ubicado en el directorio de WackoWiki. Para que pueda funcionar esto debe asegurarse que el servidor web tiene permiso de escritura para este archivo. Si no lo logra concederle, deberá editar el archivo manualmente (el instalador le dará indicaciones de como..).<br><br>Véa <a href="https://wackowiki.org/doc/Doc/Español/Instalación" target="_blank">WackoWiki:Doc/Español/Instalación</a> por más detalles.',
'ErrorPermissions'				=> 'Parece que el instalador no puede setear los permisos de archivos para el funcionamiento correcto de WackoWiki. Más adelante se le va a pedir de realizar los cambios de permisos necesarios manualmente en el servidor.',
'ErrorMinPhpVersion'			=> 'La versión de PHP debe ser mayor que %1. Su servidor parece estar ejecutando una versión anterior. Debes actualizar a una versión más reciente de PHP para que WackoWiki funcione correctamente.',
'Ready'							=> 'Felicidades, su servidor parece ser capaz de ejecutar WackoWiki. Las páginas siguientes le guiarán a través del proceso de configuración.',

/*
   Site Config Page
*/
'config-site'					=> 'Configuración del sitio',
'SiteName'						=> 'Nombre Wiki',
'SiteNameDesc'					=> 'Por favor ingrese el nombre de su sitio Wiki.',
'SiteNameDefault'				=> 'MiWiki',
'HomePage'						=> 'Página de inicio',
'HomePageDesc'					=> 'Ingrese el nombre de la página de inicio del sitio, esto será la página por defecto que los visitantes verán y debería ser escrito de manera <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">NombreWiki</a>.',
'HomePageDefault'				=> 'Inicio',
'MultiLang'						=> 'Modo Multi Idioma',
'MultiLangDesc'					=> 'Modo Multi-idioma permite con una sola instalación mantener páginas con diferentes preferencias de idioma. Al habilitar este modo, el instalador creará los elementos del menú iniciales en todos los idiomas disponibles en la instalación.',
'AllowedLang'					=> 'Idiomas permitidos',
'AllowedLangDesc'				=> 'Se recomienda seleccionar únicamente los idiomas que va a utilizar, sino se selecionarán todos los idiomas.',
'AclMode'						=> 'Ajustes de ACL por defecto',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Wiki público (leer para todos, escribir y comentar para usuarios registrados)',
'PrivateWiki'					=> 'Wiki privada (leer, escribir, comentar sólo para usuarios registrados)',
'Admin'							=> 'Nombre de Administrador',
'AdminDesc'						=> 'Ingrese el nombre de usuario del administrador, esto debería escrito de manera <a href="https://wackowiki.org/doc/Doc/Español/PalabraWiki" title="View Help" target="_blank">NombreWiki</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'El nombre de usuario debe tener entre %1 y %2 caracteres de longitud y ser solamente alfanuméricos',
'NameCamelCaseOnly'				=> 'El nombre de usuario debe tener entre %1 y %2 caracteres de longitud and WikiName formatted.',
'Password'						=> 'Contraseña del Administrador',
'PasswordDesc'					=> 'Elija una contraseña del administrador con un mínimo de %1 caracteres.',
'PasswordConfirm'				=> 'Repita la Contraseña:',
'Mail'							=> 'Email del Administrador',
'MailDesc'						=> 'Ingrese la dierección email del administrador.',
'Base'							=> 'URL Base',
'BaseDesc'						=> 'La URL base del sitio WackoWiki. Se adjuntan los nombres de lás páginas, y si está usando mod_rewrite, la dirección debería terminar con una barra i.e.',
'Rewrite'						=> 'Modo Rewrite',
'RewriteDesc'					=> 'Se debe habilitar Modo Rewrite si está usando WackoWiki con reescritura URL.',
'Enabled'						=> 'Habilitado:',
'ErrorAdminEmail'				=> 'La dirección email ingresada no está válida!',
'ErrorAdminPasswordMismatch'	=> 'Las contraseñas no coinciden!.',
'ErrorAdminPasswordShort'		=> 'La contraseña del administrador es demasiado corta, longitud mínima es %1 caracteres!',
'ModRewriteStatusUnknown'		=> 'El instalador no puede verificar si el modo mod_rewrite está habilitado, sin embargo no quiere decir que está deshabilitado',

/*
   Database Config Page
*/
'config-database'				=> 'Configuración de Base de Datos',
'DbDriver'						=> 'Controlador',
'DbDriverDesc'					=> 'Controlador de base de datos a utilizar.',
'DbSqlMode'						=> 'Modo SQL',
'DbSqlModeDesc'					=> 'El modo SQL que desea usar.',
'DbVendor'						=> 'Vendedor',
'DbVendorDesc'					=> 'El proveedor de la base de datos que utiliza.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'El conjunto de caracteres de la base de datos que desea utilizar.',
'DbEngine'						=> 'Motor',
'DbEngineDesc'					=> 'El motor de base de datos que desea utilizar.',
'DbHost'						=> 'Anfitrión',
'DbHostDesc'					=> 'El host del servidor de la base de datos. Generalmente <code>127.0.0.1</code> u <code>localhost</code> (ie, la misma computadora que tambien tiene el sitio WackoWiki).',
'DbPort'						=> 'Puerto (Opcional)',
'DbPortDesc'					=> 'Número de puerto para acceder al servidor de base de datos, dejelo en blanco para usar el puerto por defecto.',
'DbName'						=> 'Nombre de base de datos',
'DbNameDesc'					=> 'La base de datos usado por WackoWiki. Esta base de datos ya debe estar creada antes de continuar con la instalación!',
'DbNameSqliteDesc'				=> 'El directorio de datos y el nombre del archivo SQLite deben usar para WackoWiki.',
'DbNameSqliteHelp'				=> 'SQLite almacena todos los datos en un solo archivo.<br><br>El directorio que especifique debe ser escribible por el servidor web durante la instalación. <br><br>Debería <strong>no</strong> ser accesible a través de la web.<br><br>El programa de instalación creará un <code>adicional. taccess</code> junto con el archivo, pero si esto falla, puede que alguien pueda acceder a su base de datos. <br>Esto incluye datos de usuario (direcciones de correo electrónico, contraseñas cifradas) así como páginas protegidas y otros datos confidenciales almacenados en la wiki. <br><br>Por lo tanto, es recomendable almacenar el archivo de datos en una ubicación completamente diferente por ejemplo en el directorio <code>/var/lib/wackowiki/yourwiki</code>.',
'DbUser'						=> 'Nombre de usuario',
'DbUserDesc'					=> 'Nombre del usuario para la conexión con la base de datos.',
'DbPassword'					=> 'Contraseña',
'DbPasswordDesc'				=> 'Contraseña del usuario para la conexión con la base de datos.',
'Prefix'						=> 'Prefijo de las tablas',
'PrefixDesc'					=> 'Prefijo de todas las tablas de WackoWiki. Esto le permite realizar multiples instalaciones de WackoWiki usando una sola base de datos, pero con distintos prefijos de las tablas (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'No se detectó un controlador de base de datos, por favor habilite la extensión mysqli o pdo_mysql en php.ini.',
'ErrorNoDbDriverSelected'		=> 'Ningun controlador de base de datos seleccionado, por favor elija uno de la lista.',
'DeleteTables'					=> 'Eliminar tablas existentes?',
'DeleteTablesDesc'				=> 'ATENCIÖN! Si procede seleccionando esta opción se eliminarán todos los datos actuales de la base de datos del wiki. No se puede deshacer al no ser que tiene los datos en un backup para recuperarlos manualmente.',
'ConfirmTableDeletion'			=> 'Está seguro que desea eliminar todas las tablas del wiki actual?',

/*
   Database Installation Page
*/
'install-database'				=> 'Instalación de base de datos',
'TestingConfiguration'			=> 'Comprobando la configuración',
'TestConnectionString'			=> 'Comprobando configuración de la conexión con la base de datos',
'TestDatabaseExists'			=> 'Verificando si existe la base de datos especificada',
'TestDatabaseVersion'			=> 'Comprobando los requisitos mínimos de versión de la base de datos',
'SqliteFileExtensionError'		=> 'Por favor, utilice una de las siguientes extensiones de archivo db, sdb, sqlite.',
'SqliteParentUnwritableGroup'	=> 'Cannot create the data directory <code>%1</code>, because the parent directory <code>%2</code> is not writable by the webserver.<br><br>The installer has determined the user your webserver is running as.<br>Make the <code>%3</code> directory writable by it to continue.<br>On a Unix/Linux system do:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> 'Cannot create the data directory <code>%1</code>, because the parent directory <code>%2</code> is not writable by the webserver.<br><br>The installer could not determine the user your webserver is running as.<br>Make the <code>%3</code> directory globally writable by it (and others!) to continue.<br>On a Unix/Linux system do:<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> 'Error al crear el directorio de datos <code>%1</code>.<br>Compruebe la ubicación e inténtelo de nuevo.',
'SqliteDirUnwritable'			=> 'No se puede escribir en el directorio <code>%1</code>.<br>Cambie sus permisos para que el servidor web pueda escribir en él, e inténtelo de nuevo.',
'SqliteReadonly'				=> 'El archivo <code>%1</code> no es escribible.',
'SqliteCantCreateDb'			=> 'No se pudo crear el archivo de base de datos <code>%1</code>.',
'InstallTables'					=> 'Instalando tablas',
'ErrorDbConnection'				=> 'Ocurrió un problema con la configuración de la conexión con la base de datos, por favor retroceda para verificar.',
'ErrorDatabaseVersion'			=> 'La versión de la base de datos es %1 pero requiere al menos %2.',
'To'							=> 'a',
'AlterTable'					=> 'Alterando %1 tabla',
'InsertRecord'					=> 'Insertando el registro en la tabla %1',
'RenameTable'					=> 'Renombrar tabla %1',
'UpdateTable'					=> 'Actualizar tabla %1',
'InstallDefaultData'			=> 'Insertando Datos iniciales',
'InstallPagesBegin'				=> 'Agregando Páginas por defecto',
'InstallPagesEnd'				=> 'Fin de agregar páginas por defecto',
'InstallSystemAccount'			=> 'Agregando usuario <code>System</code>',
'InstallDeletedAccount'			=> 'Agregando usuario <code>Deleted</code>',
'InstallAdmin'					=> 'Agregando usuario Administrador',
'InstallAdminSetting'			=> 'Agregando usuario Administrador',
'InstallAdminGroup'				=> 'Agregando grupo Administrador',
'InstallAdminGroupMember'		=> 'Agregando miembro del grupo administrador',
'InstallEverybodyGroup'			=> 'Agregando grupo Todos',
'InstallModeratorGroup'			=> 'Agregando grupo moderador',
'InstallReviewerGroup'			=> 'Agregando grupo Reviewer',
'InstallLogoImage'				=> 'Agregando Imágen de Logo',
'LogoImage'						=> 'Imágen de Logo',
'InstallConfigValues'			=> 'Agregando valores de configuración',
'ConfigValues'					=> 'Configurar valores',
'ErrorInsertPage'				=> 'Error al insertar %1 página',
'ErrorInsertPagePermission'		=> 'Error al establecer permisos para %1 página',
'ErrorInsertDefaultMenuItem'	=> 'Error al establecer página %1 como ítem predeterminado del menú',
'ErrorPageAlreadyExists'		=> '%1 página ya existe',
'ErrorAlterTable'				=> 'Error alterando %1 tabla',
'ErrorInsertRecord'				=> 'Error insertando el registro en la tabla %1',
'ErrorRenameTable'				=> 'Error al renombrar tabla %1 ',
'ErrorUpdatingTable'			=> 'Error al actualizar tabla %1 ',
'CreatingTable'					=> 'Creando %1 tabla',
'CreatingIndex'					=> 'Creando índice %1',
'CreatingTrigger'				=> 'Creando disparador %1',
'ErrorAlreadyExists'			=> '%1 ya existe',
'ErrorCreatingTable'			=> 'Error al crear %1 tabla, ya existe ?',
'ErrorCreatingIndex'			=> 'Error al crear el índice %1 , ¿ya existe?',
'ErrorCreatingTrigger'			=> 'Error al crear el disparador %1 , ¿ya existe?',
'DeletingTables'				=> 'Eliminando Tablas',
'DeletingTablesEnd'				=> 'Tablas eliminados',
'ErrorDeletingTable'			=> 'Error al eliminar tabla %1, en caso que no existe la tabla puede ignorar esta advertencia.',
'DeletingTable'					=> 'Eliminando tabla %1 ',
'NextStep'						=> 'En el paso siguiente el instalador intentará guardar el archivo con las configuraciones actualizadas, %1. Por favor asegurese que el servidor web tenga acceso de escritura al archivo, o lo tendrá que editar manualmente. Vea <a href="https://wackowiki.org/doc/Doc/Español/Instalación" target="_blank">WackoWiki:Doc/Español/Instalación</a> por detalles.',

/*
   Write Config Page
*/
'write-config'					=> 'Guardando Archivo de Configuración',
'FinalStep'						=> 'Paso Final',
'Writing'						=> 'Guardando Archivo de Configuración',
'RemovingWritePrivilege'		=> 'Quitando Privilegios de Escritura',
'InstallationComplete'			=> 'Instalación completa',
'ThatsAll'						=> 'Terminó! Ahora puede ingresar <a href="%1">al sitio WackoWiki</a>.',
'SecurityConsiderations'		=> 'Consideraciones de Seguridad',
'SecurityRisk'					=> 'Le recomendamos remover el privilegio de escritura para el archivo %1 ya que ahora está guardado. Si el archivo permanece con privilegios de escritura, puede correr un riesgo de seguridad!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'Debería eliminar ahora el directorio %1 ya que se finalizó la instalación.',
'ErrorGivePrivileges'			=> 'No fue posible guardar el archivo de configuración %1. Debería dar temporalmente permisos al servidor web para el directorio de WackoWiki, o al menos un archivo en blanco llamado %1<br>%2<br><br>; no se olvide de remover los privilegios de escritura más adelante, i.e. <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Si por algun  motivo no lo logra hacer, debería copiar el texto abajo en un archivo nuevo, y guardarlo/subirlo como %1 al directorio de WackoWiki. Hecho esto el sitio WackoWiki debería funcionar. Si continúa con problemas, visite <a href="https://wackowiki.org/doc/Doc/Español/Instalación" target="_blank">WackoWiki:Doc/Español/Instalación</a>',
'ErrorPrivilegesUpgrade'		=> 'Hecho esto el sitio WackoWiki debería funcionar. Si continúa con problemas, visite <a href="https://wackowiki.org/doc/Doc/Español/Instalación" target="_blank">WackoWiki:Doc/Español/Instalación</a>',
'WrittenAt'						=> 'Guardado ',
'DontChange'					=> 'no cambie manualmente wacko_version!',
'ConfigDescription'				=> 'descripción detallada https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Intente de Nuevo',

];
