<?php
$lang = array(

/*
   Language
*/
'Charset' => 'iso-8859-1',
'LangISO' => 'es',
'LangName' => 'Español',

/*
   Generic Page Text
*/
'Title' => 'Instalación WackoWiki',
'Continue' => 'Continuar',
'Back' => 'Volver',

/*
   Language Selection Page
*/
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <tt>%1</tt> to <tt>%2</tt>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <tt>%1</tt>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Favor, realíce una copia de respaldo de la base de datos, archivos de configuración, y todos los archivos modificados, hackeados o parcheados antes de iniciar el proceso de actualización. Esto le puedo salvar de un gran dolor de cabeza.',
'Lang' => 'Configuración de Idioma',
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
'Permissions' => 'Permisos',
'ReadyToInstall' => 'Listo para instalar?',
'Requirements' => 'El servidor debe cumplir los requerimientos listados abajo.',
'OK' => 'OK',
'Problem' => 'Problema',
'NotePermissions' => 'El instalador intentará guardar los datos de configuración en el archivo <tt>config.php</tt>, ubicado en el directorio de WackoWiki. Para que pueda funcionar esto debe asegurarse que el servidor web tiene permiso de escritura para este archivo. Si no lo logra concederle, deberá editar el archivo manualmente (el instalador le dará indicaciones de como..).<br /><br />Véa <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> por más detalles.',
'ErrorPermissions' => 'Parece que el instalador no puede setear los permisos de archivos para el funcionamiento correcto de WackoWiki. Más adelante se le va a pedir de realizar los cambios de permisos necesarios manualmente en el servidor.',
'ErrorMinPHPVersion' => 'La versión PHP debe ser mayor a <strong>5.2.0</strong>, el servidor parece tener instalado una versión anterior. PHP se debe actualizar a una versión más nueva para que WackoWiki pueda funcionar correctamente.',
'Ready' => 'Felicidades, su servidor parece ser capaz de ejecutar WackoWiki. Las páginas siguientes le guiarán a través del proceso de configuración.',

/*
   Site Config Page
*/
'site-config' => 'Configuración del sitio',
'Name' => 'Nombre WackoWiki',
'NameDesc' => 'Por favor ingrese el nombre de su sitio WackoWiki, lo debe escribir de manera <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">NombreWiki</a>.',
'Home' => 'Página de inicio',
'HomeDesc' => 'Ingrese el nombre de la página de inicio del sitio, esto será la página por defecto que los visitantes verán y debería ser escrito de manera <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">NombreWiki</a>.',
'HomeDefault' => 'HomePage',
'MultiLang' => 'Modo Multi Idioma',
'MultiLangDesc' => 'Modo Multi-idioma permite con una sola instalación mantener páginas con diferentes preferencias de idioma. Al habilitar este modo, el instalador creará las páginas iniciales en todos los idiomas disponibles en la instalación.',
'Admin' => 'Nombre de Administrador',
'AdminDesc' => 'Ingrese el nombre de usuario del administrador, esto debería escrito de manera <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">NombreWiki</a> (e.g. WikiAdmin).',
'Password' => 'Contraseña del Administrador',
'PasswordDesc' => 'Elija una contraseña del administrador con un mínimo de 8 caracteres.',
'Password2' => 'Repita la Contraseña:',
'Mail' => 'Email del Administrador',
'MailDesc' => 'Ingrese la dierección email del administrador.',
'Base' => 'URL Base',
'BaseDesc' => 'La URL base del sitio WackoWiki. Se adjuntan los nombres de lás páginas, y si está usando mod_rewrite, la dirección debería terminar con una barra i.e.</p><ul><li><b><i>http://wackowiki.org/</i></b></li><li><b><i>http://wackowiki.org/wiki/</i></b></li></ul>',
'Rewrite' => 'Modo Rewrite',
'RewriteDesc' => 'Se debe habilitar Modo Rewrite si está usando WackoWiki con reescritura URL.',
'Enabled' => 'Habilitado:',
'ErrorAdminName' => 'El nombre de administrador debe ser nombre tipo WikiName!',
'ErrorAdminEmail' => 'La dirección email ingresada no está válida!',
'ErrorAdminPasswordMismatch' => 'Las contraseñas no coinciden!.',
'ErrorAdminPasswordShort' => 'La contraseña del administrador es demasiado corta, longitud mínima es 8 caracteres!',
'WarningRewriteMode' => 'ATENCION!\nLa URL base se ve extraña considerando la configuración de modo rewrite. Generalmente no hay el signo ? en la URL base si el modo rewrite está activado - pero actualmente está presente.\n\nPara continuar usando la configuración actual presione OK.\nPara volver al formulario y modificar los datos de configuraciíon presione CANCEL.\n\nSi tiene la intención de continuar con la configuración actual puede tener problemas con la instalación de WackoWiki.',
'ModRewriteStatusUnknown' => 'El instalador no puede verificar si el modo mod_rewrite está habilitado, sin embargo no quiere decir que está deshabilitado',

/*
   Database Config Page
*/
'database-config' => 'Configuración de Base de Datos',
'DBDriverDesc' => 'Controlador de base de datos a utilizar. Debe elegir un controlador legacy si no tiene PHP5.1 (o mayor) y <a href="http://de2.php.net/pdo" target="_blank">PDO</a> instalado.',
'DBDriver' => 'Controlador',
'DBHost' => 'Host',
'DBHostDesc' => 'El host del servidor de la base de datos. Generalmente "localhost" (ie, la misma computadora que tambien tiene el sitio WackoWiki).',
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
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

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
'AlterTable' => 'Alterando <tt>%1</tt> Tabla',
'RenameTable' => 'Renaming <tt>%1</tt> Table',
'UpdateTable' => 'Updating <tt>%1</tt> Table',
'InstallingDefaultData' => 'Insertando Datos iniciales',
'InstallingPagesBegin' => 'Agregando Páginas por defecto',
'InstallingPagesEnd' => 'Fin de agregar páginas por defecto',
'InstallingSystemAccount' => 'Adding System User',
'InstallingAdmin' => 'Agregando usuario Administrador',
'InstallingAdminSetting' => 'Agregando usuario Administrador',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingRegisteredGroup' => 'Adding Registered Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Agregando Imágen de Logo',
'InstallingConfigValues' => 'Adding Config Values',
'ErrorInsertingPage' => 'Error al insertar <tt>%1</tt> página',
'ErrorInsertingPageReadPermission' => 'Error al establecer permisos de lectura para <tt>%1</tt> página',
'ErrorInsertingPageWritePermission' => 'Error al establecer permisos de escritura para <tt>%1</tt> página',
'ErrorInsertingPageCommentPermission' => 'Error al establecer permisos de comentario para <tt>%1</tt> página',
'ErrorInsertingPageCreatePermission' => 'Error setting create permissions for <tt>%1</tt> page',
'ErrorInsertingPageUploadPermission' => 'Error setting upload permissions for <tt>%1</tt> page',
'ErrorInsertingDefaultBookmark' => 'Error setting page <tt>%1</tt> as default bookmark',
'ErrorPageAlreadyExists' => '<tt>%1</tt> página ya existe',
'ErrorAlteringTable' => 'Error alterando <tt>%1</tt> tabla',
'ErrorRenamingTable' => 'Error renaming <tt>%1</tt> table',
'ErrorUpdatingTable' => 'Error updating <tt>%1</tt> table',
'CreatingTable' => 'Creando <tt>%1</tt> tabla',
'ErrorAlreadyExists' => '<tt>%1</tt> ya existe',
'ErrorCreatingTable' => 'Error al crear <tt>%1</tt> tabla, ya existe ?',
'ErrorMovingRevisions' => 'Error al mover datos de revisión',
'MovingRevisions' => 'Moviendo datos a tabla de revisión',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting <tt>%1</tt> table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting <tt>%1</tt> table',

/*
   Write Config Page
*/
'write-config' => 'Guardando Archivo de Configuración',
'FinalStep' => 'Final Step',
'Writing' => 'Guardando Archivo de Configuración',
'RemovingWritePrivilege' => 'Quitando Privilegios de Escritura',
'InstallationComplete' => 'Instalación completa',
'ThatsAll' => 'Terminó! Ahora puede ingresar <a href="%1">al sitio WackoWiki</a>.',
'SecurityConsiderations' => 'Consideraciones de Seguridad',
'SecurityRisk' => 'Le recomendamos remover el privilegio de escritura para el archivo <tt>config.php</tt> ya que ahora está guardado. Si el archivo permanece con privilegios de escritura, puede correr un riesgo de seguridad!',
'RemoveSetupDirectory' => 'Debería eliminar ahora el directorio "setup" ya que se finalizó la instalación.',
'ErrorGivePrivileges' => 'No fue posible guardar el archivo de configuración <tt>%1</tt>. Debería dar temporalmente permisos al servidor web para el directorio de WackoWiki, o al menos un archivo en blanco llamado <tt>config.php</tt> (<tt>touch config.php ; chmod 666 config.php</tt>; no se olvide de remover los privilegios de escritura más adelante, ie <tt>chmod 644 config.php</tt>). Si por algun  motivo no lo logra hacer, debería copiar el texto abajo en un archivo nuevo, y guardarlo/subirlo como <tt>config.php</tt> al directorio de WackoWiki. Hecho esto el sitio WackoWiki debería funcionar. Si continúa con problemas, visite <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'En el paso siguiente el instalador intentará guardar el archivo con las configuraciones actualizadas, <tt>config.php</tt>. Por favor asegurese que el servidor web tenga acceso de escritura al archivo, o lo tendrá que editar manualmente. Vea <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> por detalles.',
'WrittenAt' => 'Guardado ',
'DontChange' => 'no cambie manualmente wacko_version!',
'ConfigDescription' => 'detailed description http://wackowiki.org/Doc/English/Configuration',
'TryAgain' => 'Intente de Nuevo',
'RemoveWakkaConfigFile' => 'WackoWiki uses a newer config file than your previous WakkaWiki installation.  The old file could not be automatically removed by the system and so it is recommended that you manually delete the file <tt>wakka.config.php</tt>.',
'DeletingWakkaConfigFile' => 'Deleting Obsolete Wakka Configuration File',

);
?>
