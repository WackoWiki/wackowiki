<?php
$lang = array(

/*
   Language Settings
*/
'Charset' => 'windows-1251',
'LangISO' => 'bg',
'LangName' => 'Bulgarian',

/*
   Generic Page Text
*/
'Title' => 'Инсталация на WackoWiki',
'Continue' => 'Продължение',
'Back' => 'Back',

/*
   Language Selection Page
*/
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <tt>%1</tt> to <tt>%2</tt>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <tt>%1</tt>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Моля, съхранете си копие на базата данни (БД) от, конфигурационния файл и другите, променени от вас файлове (например,  теми),  докато още НЕ Е КЪСНО!',
'Lang' => 'Езикови настройки',
'LangDesc' => 'Изберете език. Той ще се използува за инсталацията, а също и ще стане език по подразбиране на новия WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'System Requirements',
'PHPVersion' => 'PHP Version',
'PHPDetected' => 'Detected PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Extension (mod_rewrite) Installed?',
'Database' => 'Database',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Ready to Install?',
'Requirements' => 'Your server must meet the requirements listed below.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePermissions' => 'Програмата за инсталиране ще опита да запише настройките във файл <tt>config.php</tt>, разположен в главната директория, където е WackoWiki. За да стане това, този файл трябва да е достъпен за запис чрез системата сървър/скрипт! За да няма проблеми, трябва сега временно да се променят правата за достъп до (мястото на) този файл.<br /><br />Вж. <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPHPVersion' => 'The PHP Version must be greater than <strong>5.2.0</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'site-config' => 'Настройки на сайта',
'Name' => 'Посочете името на УакоУики',
'NameDesc' => 'Име на вашия WackoWiki. Трябва да е от типа УикиИме и изглежда ПримерноЕтоТака. <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'Home' => 'Главна страница',
'HomeDesc' => 'Главна страница на WackoWiki.  Трябва да е  с <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">УикиИме</a>.',
'HomeDefault' => 'HomePage',
'MultiLang' => '&laquo;Многоезичен&raquo; режим',
'MultiLangDesc' => '&laquo;Многоезичен&raquo; режим, позволяващ работа на няколко езика. Ако е включен, инсталаторът ще инициализира страници на няколко различни езика.',
'Admin' => 'Име',
'AdminDesc' => 'Изберете име. Нещо от тип <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (без кирилица).',
'Password' => 'Име Парола',
'PasswordDesc' => 'Изберете парола ( 8 и повече символа )',
'Password2' => 'Подтвърждение на паролата:',
'Mail' => 'Admin Email Address',
'MailDesc' => 'Адрес на електронната поща (email) на администратора.',
'Base' => 'Базов URL',
'BaseDesc' => 'Базов URL  на вашата инсталация на  WackoWiki. Имената на страниците се присъединяват към него с forward slash, ако не може да се ползва mod_rewrite i.e.</p><ul><li><b><i>http://wackowiki.org/</i></b></li><li><b><i>http://wackowiki.org/wiki/</i></b></li></ul>',
'Rewrite' => 'Rewrite-режим',
'RewriteDesc' => 'Rewrite-режим трябва да е включен, ако ползвате mod_rewrite.',
'Enabled' => 'Включен:',
'ErrorAdminName' => 'Изберете валидно WackoWiki име!',
'ErrorAdminEmail' => 'Въведете истински адрес!',
'ErrorAdminPasswordMismatch' => 'Паролата на администратора не съвпадна нещо!',
'ErrorAdminPasswordShort' => 'The admin много е кратка, the minimum length is 8 characters!',
'WarningRewriteMode' => 'ВНИМАНИЕ!\nНастройки базового URL и Rewrite-режима выглядят подозрительно. Обычно при включенном Rewrite не бывает знака ? в базовом URL, но у вас он есть.\n\nДля продолжения инсталляции с текущими настройками нажмите ОК.\nДля того, чтобы вернуться в форму и всё исправить, нажмите ОТМЕНА.\n\nЕсли вы решили идти дальше, помните, что такое сочетание часто является причиной неработоспособности после инсталляции.',
'ModRewriteStatusUnknown' => 'The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled',

/*
   Database Config Page
*/
'database-config' => 'Настройка на БД',
'DBDriverDesc' => 'The database driver you want to use.  You must choose a legacy driver if you do not have PHP5.1 (or greater) and <a href="http://de2.php.net/pdo" target="_blank">PDO</a> installed.',
'DBDriver' => 'Driver',
'DBHost' => 'Име (hostname) на БД',
'DBHostDesc' => 'The host your database server is running on. Usually "localhost" (ie, the same machine your WackoWiki site is on).',
'DBPort' => 'Port (Optional)',
'DBPortDesc' => 'The port number your database server is accessable through, leave it blank to use the default port number.',
'DB' => 'БД',
'DBDesc' => 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DBUserDesc' => 'Name of the user used to connect to your database.',
'DBUser' => 'Име (username)',
'DBPasswordDesc' => 'Password of the user used to connect to your database.',
'DBPassword' => 'Паролa (password)',
'PrefixDesc' => 'Префикс на таблиците на Wacko. Това дава възможност за няколко WackoWiki на една БД, само чрез различни префикси (e.g. wacko_).',
'Prefix' => 'Префикс на таблиците',
'ErrorNoDbDriverDetected' => 'No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.',
'ErrorNoDbDriverSelected' => 'No database driver has been selected, please pick one from the list.',
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'database-install' => 'Database Installation',
'TestingConfiguration' => 'Тест на настройките',
'TestConnectionString' => 'Проверка на връзката с БД',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'InstallingTables' => 'Installing Tables',
'ErrorDBConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDBExists' => 'Не е открита такава БД. Проверете дали е създадена предварително!',
'To' => '->',
'AlterTable' => 'Altering <tt>%1</tt> Table',
'RenameTable' => 'Renaming <tt>%1</tt> Table',
'UpdateTable' => 'Updating <tt>%1</tt> Table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Adding System User',
'InstallingAdmin' => 'Добавяме административен потребител',
'InstallingAdminSetting' => 'Добавяме административен потребител',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingRegisteredGroup' => 'Adding Registered Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Adding Logo Image',
'InstallingConfigValues' => 'Adding Config Values',
'ErrorInsertingPage' => 'Error inserting <tt>%1</tt> page',
'ErrorInsertingPageReadPermission' => 'Error setting read permission for <tt>%1</tt> page',
'ErrorInsertingPageWritePermission' => 'Error setting write permission for <tt>%1</tt> page',
'ErrorInsertingPageCommentPermission' => 'Error setting comment permissions for <tt>%1</tt> page',
'ErrorInsertingPageCreatePermission' => 'Error setting create permissions for <tt>%1</tt> page',
'ErrorInsertingPageUploadPermission' => 'Error setting upload permissions for <tt>%1</tt> page',
'ErrorInsertingDefaultBookmark' => 'Error setting page <tt>%1</tt> as default bookmark',
'ErrorPageAlreadyExists' => 'The <tt>%1</tt> page already exists',
'ErrorAlteringTable' => 'Error altering <tt>%1</tt> table',
'ErrorRenamingTable' => 'Error renaming <tt>%1</tt> table',
'ErrorUpdatingTable' => 'Error updating <tt>%1</tt> table',
'CreatingTable' => 'Създаваме таблица <tt>%1</tt>',
'ErrorAlreadyExists' => 'The <tt>%1</tt> already exists',
'ErrorCreatingTable' => 'Error creating <tt>%1</tt> table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Преместваме старите версии в таблица revisions',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting <tt>%1</tt> table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting <tt>%1</tt> table',

/*
   Write Config Page
*/
'write-config' => 'Write Config File',
'FinalStep' => 'Final Step',
'Writing' => 'Запис на конфигурационния файл',
'RemovingWritePrivilege' => 'Removing Write Privilege',
'InstallationComplete' => 'Installation Complete',
'ThatsAll' => 'Ура! Изглежда успешно. Сега можете <a href="%1">WackoWiki site</a>.',
'SecurityConsiderations' => 'Security Considerations',
'SecurityRisk' => 'Не забравяйте накрая да промените обратно правата за достъп на <tt>config.php</tt> на сървъра. Въпрос на "сигурност"!',
'RemoveSetupDirectory' => 'You should delete the "setup" directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'Конфигурационния файл <tt>%1</tt> не може да се запише. Трябва сега временно да се променят правата за достъп до (мястото на) този файл или да се направи празен файл <tt>config.php</tt> (<tt>touch config.php ; chmod 666 config.php</tt>; не забравяйте накрая да забраните обратно правата, т.e. <tt>chmod 644 config.php</tt>). Ако нещо не става, ще трябва да копирате и запишете следващия текст в нов празен файл на вашия компютър и после да го прехвърлите с име <tt>config.php</tt> на сървъра в главната директория на Wacko. При проблеми, вижте (англ.) <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> или (руски) <a href="http://wackowiki.org/Doc/English/Installation">WackoWiki:Документация/Установка</a>',
'NextStep' => 'На следващата стъпка, инсталаторът ще опита да запише обновения конфигурационния файл, <tt>config.php</tt>. Кофигурационният файл <tt>config.php</tt> се  разполага в главната директория, където е WackoWiki. За да стане промяната, този файл трябва да е достъпен за запис чрез системата сървър/скрипт! За да няма проблеми, трябва сега временно да се променят правата за достъп до този файл. В противен случай ще трябва да допишете промените на ръка. Отново, погледнете за подробности, малко е на английски, но все пак <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'WrittenAt' => 'записан ',
'DontChange' => 'не променяйте wacko_version ръчно!',
'ConfigDescription' => 'detailed description http://wackowiki.org/Doc/English/Configuration',
'TryAgain' => 'Нов опит',
'RemoveWakkaConfigFile' => 'WackoWiki uses a newer config file than your previous WakkaWiki installation.  The old file could not be automatically removed by the system and so it is recommended that you manually delete the file <tt>wakka.config.php</tt>.',
'DeletingWakkaConfigFile' => 'Deleting Obsolete Wakka Configuration File',

);
?>