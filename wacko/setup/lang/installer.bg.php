<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'utf-8',
'LangISO' => 'bg',
'LangName' => 'Bulgarian',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages
	'category_page'		=> 'Category',
	'groups_page'		=> 'Groups',
	'users_page'		=> 'Users',

	'search_page'		=> 'Търсене',
	'login_page'		=> 'влизане',
	'account_page'		=> 'Settings',
	'registration_page'	=> 'Регистрация',
	'password_page'		=> 'Password',

	'changes_page'		=> 'ПоследниПромени',
	'comments_page'		=> 'НовиКоментари',
	'index_page'		=> 'Каталог',

	'random_page'		=> 'СлучайнаСтраница',
	#'help_page'			=> 'Помощ',
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
'Title' => 'Инсталация на WackoWiki',
'Continue' => 'Продължение',
'Back' => 'Back',
'Recommended' => 'препоръчва',
'InvalidAction' => 'Invalid action',

/*
   Language Selection Page
*/
'lang' => 'Езикови настройки',
'PleaseUpgradeToR5' => 'You aware to be running an old (pre %1) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to <code class="version">%2</code>.',
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <code class="version">%1</code> to <code class="version">%2</code>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <code class="version">%1</code>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Моля, съхранете си копие на базата данни (БД) от, конфигурационния файл и другите, променени от вас файлове (например,  теми),  докато още НЕ Е КЪСНО!',
'LangDesc' => 'Изберете език. Той ще се използува за инсталацията, а също и ще стане език по подразбиране на новия WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'System Requirements',
'PhpVersion' => 'PHP Version',
'PhpDetected' => 'Detected PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Extension (mod_rewrite) Installed?',
'Database' => 'Database',
'PhpExtensions' => 'PHP Extensions',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Ready to Install?',
'Requirements' => 'Your server must meet the requirements listed below.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePhpExtensions' => '',
'ErrorPhpExtensions' => 'Your PHP installation appears to be missing the noted PHP extensions which are required by WackoWiki.',
'PcreWithoutUtf8' => 'PCRE is not compiled with UTF-8 support.',
'NotePermissions' => 'Програмата за инсталиране ще опита да запише настройките във файл %1, разположен в главната директория, където е WackoWiki. За да стане това, този файл трябва да е достъпен за запис чрез системата сървър/скрипт! За да няма проблеми, трябва сега временно да се променят правата за достъп до (мястото на) този файл.<br><br>Вж. <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPhpVersion' => 'The PHP Version must be greater than <strong>' . PHP_MIN_VERSION . '</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'config-site' => 'Настройки на сайта',
'SiteName' => 'Посочете името на УакоУики',
'SiteNameDesc' => 'Име на вашия Wiki.',
'HomePage' => 'Главна страница',
'HomePageDesc' => 'Главна страница на WackoWiki.  Трябва да е  с <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">УикиИме</a>.',
'HomePageDefault' => 'HomePage',
'MultiLang' => '«Многоезичен» режим',
'MultiLangDesc' => 'Многоезичен режим, позволяващ работа на няколко езика. Ако е включен, инсталаторът ще инициализира елементи от менюто на няколко различни езика.',
'AllowedLang' => 'Allowed Languages',
'AllowedLangDesc' => 'It is recommended to select only the set of languages you want to use, other wise all languages are selected.',
'Admin' => 'Име',
'AdminDesc' => 'Изберете име. Нещо от тип <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (без кирилица).',
'Password' => 'Име Парола',
'PasswordDesc' => 'Изберете парола ( 9 и повече символа )',
'Password2' => 'Подтвърждение на паролата:',
'Mail' => 'Admin Email Address',
'MailDesc' => 'Адрес на електронната поща (email) на администратора.',
'Base' => 'Базов URL',
'BaseDesc' => 'Базов URL  на вашата инсталация на  WackoWiki. Имената на страниците се присъединяват към него с forward slash, ако не може да се ползва mod_rewrite i.e.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => 'Rewrite-режим',
'RewriteDesc' => 'Rewrite-режим трябва да е включен, ако ползвате mod_rewrite.',
'Enabled' => 'Включен:',
'ErrorAdminEmail' => 'Въведете истински адрес!',
'ErrorAdminPasswordMismatch' => 'Паролата на администратора не съвпадна нещо!',
'ErrorAdminPasswordShort' => 'The admin много е кратка, the minimum length is %1 characters!',
'WarningRewriteMode' => 'ВНИМАНИЕ!\nНастройки базового URL и Rewrite-режима выглядят подозрительно. Обычно при включенном Rewrite не бывает знака ? в базовом URL, но у вас он есть.\n\nДля продолжения инсталляции с текущими настройками нажмите ОК.\nДля того, чтобы вернуться в форму и всё исправить, нажмите ОТМЕНА.\n\nЕсли вы решили идти дальше, помните, что такое сочетание часто является причиной неработоспособности после инсталляции.',
'ModRewriteStatusUnknown' => 'The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled',

'LanguageArray'	=> [
	'bg' => 'bulgarian',
	'da' => 'danish',
	'nl' => 'dutch',
	'el' => 'greek',
	'en' => 'english',
	'et' => 'estonian',
	'fr' => 'french',
	'de' => 'german',
	'hu' => 'hungarian',
	'it' => 'italian',
	'pl' => 'polish',
	'pt' => 'portuguese',
	'ru' => 'russian',
	'es' => 'spanish',
],

/*
   Database Config Page
*/
'config-database' => 'Настройка на БД',
'DbDriver' => 'Driver',
'DbDriverDesc' => 'The database driver you want to use. You must choose a legacy driver if you do not have <a href="https://secure.php.net/pdo" target="_blank">PDO</a> installed.',
'DbCharset' => 'Charset',
'DbCharsetDesc' => 'The database charset you want to use.',
'DbEngine' => 'Engine',
'DbEngineDesc' => 'The database engine you want to use.',
'DbHost' => 'Име (hostname) на БД',
'DbHostDesc' => 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort' => 'Port (Optional)',
'DbPortDesc' => 'The port number your database server is accessible through, leave it blank to use the default port number.',
'Db' => 'БД',
'DbDesc' => 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DbUserDesc' => 'Name of the user used to connect to your database.',
'DbUser' => 'Име (username)',
'DbPasswordDesc' => 'Password of the user used to connect to your database.',
'DbPassword' => 'Паролa (password)',
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
'install-database' => 'Database Installation',
'TestingConfiguration' => 'Тест на настройките',
'TestConnectionString' => 'Проверка на връзката с БД',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'TestDatabaseVersion' => 'Checking database minimum version requirements',
'InstallingTables' => 'Installing Tables',
'ErrorDbConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDbExists' => 'Не е открита такава БД. Проверете дали е създадена предварително!',
'ErrorDatabaseVersion' => 'The database version is %1 but requires at least %2.',
'To' => '->',
'AlterTable' => 'Altering %1 table',
'InsertRecord' => 'Inserting Record into %1 table',
'RenameTable' => 'Renaming %1 table',
'UpdateTable' => 'Updating %1 table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Adding <code>System</code> User',
'InstallingDeletedAccount' => 'Adding <code>Deleted</code> User',
'InstallingAdmin' => 'Добавяме административен потребител',
'InstallingAdminSetting' => 'Добавяме административен потребител',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Adding Logo Image',
'LogoImage' => 'Logo image',
'InstallingConfigValues' => 'Adding Config Values',
'ConfigValues' => 'Config Values',
'ErrorInsertingPage' => 'Error inserting %1 page',
'ErrorInsertingPagePermission' => 'Error setting permission for %1 page',
'ErrorInsertingDefaultMenuItem' => 'Error setting page %1 as default menu item',
'ErrorPageAlreadyExists' => 'The %1 page already exists',
'ErrorAlteringTable' => 'Error altering %1 table',
'ErrorInsertingRecord' => 'Error Inserting Record into %1 table',
'ErrorRenamingTable' => 'Error renaming %1 table',
'ErrorUpdatingTable' => 'Error updating %1 table',
'CreatingTable' => 'Създаваме таблица %1',
'ErrorAlreadyExists' => 'The %1 already exists',
'ErrorCreatingTable' => 'Error creating %1 table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Преместваме старите версии в таблица revisions',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting %1 table',

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
'SecurityRisk' => 'Не забравяйте накрая да промените обратно правата за достъп на %1 на сървъра. Въпрос на "сигурност"!<br>i.e. %2',
'RemoveSetupDirectory' => 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'Конфигурационния файл %1 не може да се запише. Трябва сега временно да се променят правата за достъп до (мястото на) този файл или да се направи празен файл %1<br>%2<br>; не забравяйте накрая да забраните обратно правата, т.e. %3.<br>Ако нещо не става, ще трябва да копирате и запишете следващия текст в нов празен файл на вашия компютър и после да го прехвърлите с име %1 на сървъра в главната директория на Wacko. При проблеми, вижте (англ.) <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> или (руски) <a href="https://wackowiki.org/doc/Doc/English/Installation">WackoWiki:Документация/Установка</a>',
'NextStep' => 'На следващата стъпка, инсталаторът ще опита да запише обновения конфигурационния файл, %1. Кофигурационният файл %1 се  разполага в главната директория, където е WackoWiki. За да стане промяната, този файл трябва да е достъпен за запис чрез системата сървър/скрипт! За да няма проблеми, трябва сега временно да се променят правата за достъп до този файл. В противен случай ще трябва да допишете промените на ръка. Отново, погледнете за подробности, малко е на английски, но все пак <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'WrittenAt' => 'записан ',
'DontChange' => 'не променяйте wacko_version ръчно!',
'ConfigDescription' => 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain' => 'Нов опит',

];
