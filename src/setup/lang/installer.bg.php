<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'bg',
'LangLocale'	=> 'bg_BG',
'LangName'		=> 'Bulgarian',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'Категория',
	'groups_page'		=> 'Групи',
	'users_page'		=> 'Потребители',

	'search_page'		=> 'Търсене',
	'login_page'		=> 'Влизане',
	'account_page'		=> 'Настройки',
	'registration_page'	=> 'Регистрация',
	'password_page'		=> 'Парола',

	'whatsnew_page'		=> 'WhatsNew',
	'changes_page'		=> 'ПоследниПромени',
	'comments_page'		=> 'НовиКоментари',
	'index_page'		=> 'Каталог',

	'random_page'		=> 'СлучайнаСтраница',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'Инсталация на WackoWiki',
'TitleUpdate'					=> 'WackoWiki Update',
'Continue'						=> 'Продължение',
'Back'							=> 'Обратно',
'Recommended'					=> 'препоръчва',
'InvalidAction'					=> 'Invalid action',

/*
   Language Selection Page
*/
'lang'							=> 'Езикови настройки',
'PleaseUpgradeToR6'				=> 'Използвате стара версия на WackoWiki %1. За да актуализирате до тази нова версия на WackoWiki, първо трябва да актуализирате инсталацията си до %2.',
'UpgradeFromWacko'				=> 'Добре дошли в WackoWiki, изглежда, че преминавате от WackoWiki %1 към %2.  Следващите няколко страници ще ви преведат през процеса на обновяване.',
'FreshInstall'					=> 'Добре дошли в WackoWiki, предстои ви да инсталирате WackoWiki %1.  Следващите няколко страници ще ви преведат през процеса на инсталиране.',
'PleaseBackup'					=> 'Моля, съхранете си копие на базата данни (БД) от, конфигурационния файл и другите, променени от вас файлове (например,  теми),  докато още НЕ Е КЪСНО!',
'LangDesc'						=> 'Изберете език. Той ще се използува за инсталацията, а също и ще стане език по подразбиране на новия WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Системни изисквания',
'PhpVersion'					=> 'PHP Version',
'PhpDetected'					=> 'Detected PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'База данни',
'PhpExtensions'					=> 'PHP Extensions',
'Permissions'					=> 'Права',
'ReadyToInstall'				=> 'Ready to Install?',
'Requirements'					=> 'Вашият сървър трябва да отговаря на изброените по-долу изисквания.',
'OK'							=> 'OK',
'Problem'						=> 'Проблем',
'Example'						=> 'Example',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Изглежда, че във вашата PHP инсталация липсват отбелязаните PHP разширения, които се изискват от WackoWiki. ',
'PcreWithoutUtf8'				=> 'Модулът PCRE на PHP изглежда е компилиран без поддръжка на PCRE_UTF8.',
'NotePermissions'				=> 'Програмата за инсталиране ще опита да запише настройките във файл %1, разположен в главната директория, където е WackoWiki. За да стане това, този файл трябва да е достъпен за запис чрез системата сървър/скрипт! За да няма проблеми, трябва сега временно да се променят правата за достъп до (мястото на) този файл.<br><br>Вж. <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'ErrorPermissions'				=> 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPhpVersion'			=> 'The PHP version must be greater than %1. Your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready'							=> 'Поздравления, изглежда, че вашият сървър може да работи с WackoWiki. Следващите няколко страници ще ви преведат през процеса на конфигуриране.',

/*
   Site Config Page
*/
'config-site'					=> 'Настройки на сайта',
'SiteName'						=> 'Посочете името на УакоУики',
'SiteNameDesc'					=> 'Име на вашия Wiki.',
'SiteNameDefault'				=> 'МоетоУики',
'HomePage'						=> 'Главна страница',
'HomePageDesc'					=> 'Главна страница на WackoWiki.  Трябва да е  с <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">УикиИме</a>.',
'HomePageDefault'				=> 'HomePage',
'MultiLang'						=> '«Многоезичен» режим',
'MultiLangDesc'					=> 'Многоезичен режим, позволяващ работа на няколко езика. Ако е включен, инсталаторът ще инициализира елементи от менюто на няколко различни езика.',
'AllowedLang'					=> 'Allowed Languages',
'AllowedLangDesc'				=> 'Препоръчително е да изберете само набора от езици, които искате да използвате, в противен случай се избират всички езици.',
'AclMode'						=> 'Default ACL settings',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Public Wiki (read for everyone, write and comment for registered users)',
'PrivateWiki'					=> 'Private Wiki (read, write, comment for registered users only)',
'Admin'							=> 'Име',
'AdminDesc'						=> 'Изберете име. Нещо от тип <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (без кирилица).',
'NameAlphanumOnly'				=> 'Потребителското име трябва да е м/у %1 и %2 символа дълго и да използва само alphanumeric.',
'NameCamelCaseOnly'				=> 'Потребителското име трябва да е м/у %1 и %2 символа дълго and WikiName formatted.',
'Password'						=> 'Име Парола',
'PasswordDesc'					=> 'Изберете парола ( 9 и повече символа )',
'PasswordConfirm'				=> 'Подтвърждение на паролата:',
'Mail'							=> 'Admin Email Address',
'MailDesc'						=> 'Адрес на електронната поща (email) на администратора.',
'Base'							=> 'Базов URL',
'BaseDesc'						=> 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash, i.e.',
'Rewrite'						=> 'Rewrite-режим',
'RewriteDesc'					=> 'Rewrite-режим трябва да е включен, ако ползвате mod_rewrite.',
'Enabled'						=> 'Включен:',
'ErrorAdminEmail'				=> 'Въведете истински адрес!',
'ErrorAdminPasswordMismatch'	=> 'Паролата на администратора не съвпадна нещо!',
'ErrorAdminPasswordShort'		=> 'The admin много е кратка, минималната дължина е %1 символа!',
'ModRewriteStatusUnknown'		=> 'The installer cannot verify that mod_rewrite is enabled, however this does not mean it is disabled',

/*
   Database Config Page
*/
'config-database'				=> 'Настройка на БД',
'DbDriver'						=> 'Driver',
'DbDriverDesc'					=> 'The database driver you want to use.',
'DbSqlMode'						=> 'SQL mode',
'DbSqlModeDesc'					=> 'The SQL mode you want use.',
'DbVendor'						=> 'Vendor',
'DbVendorDesc'					=> 'The database vendor you use.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'The database charset you want to use.',
'DbEngine'						=> 'Engine',
'DbEngineDesc'					=> 'The database engine you want to use.',
'DbHost'						=> 'Име (hostname) на БД',
'DbHostDesc'					=> 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort'						=> 'Port (Optional)',
'DbPortDesc'					=> 'The port number your database server is accessible through, leave it blank to use the default port number.',
'DbName'						=> 'БД',
'DbNameDesc'					=> 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DbUser'						=> 'Име (username)',
'DbUserDesc'					=> 'Name of the user used to connect to your database.',
'DbPassword'					=> 'Паролa (password)',
'DbPasswordDesc'				=> 'Password of the user used to connect to your database.',
'Prefix'						=> 'Префикс на таблиците',
'PrefixDesc'					=> 'Префикс на таблиците на Wacko. Това дава възможност за няколко WackoWiki на една БД, само чрез различни префикси (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'No database driver has been detected, please enable either the mysqli or pdo_mysql extension in your php.ini file.',
'ErrorNoDbDriverSelected'		=> 'No database driver has been selected, please pick one from the list.',
'DeleteTables'					=> 'Изтриване на съществуващи таблици?',
'DeleteTablesDesc'				=> 'ВНИМАНИЕ! Ако продължите с тази опция, всички текущи данни за уикито ще бъдат изтрити от базата данни. Това не може да бъде отменено, освен ако не възстановите ръчно данните от резервно копие.',
'ConfirmTableDeletion'			=> 'Сигурни ли сте, че искате да изтриете всички текущи уикитаблици?',

/*
   Database Installation Page
*/
'install-database'				=> 'Database Installation',
'TestingConfiguration'			=> 'Тест на настройките',
'TestConnectionString'			=> 'Проверка на връзката с БД',
'TestDatabaseExists'			=> 'Checking if the database you specified exists',
'TestDatabaseVersion'			=> 'Checking database minimum version requirements',
'InstallTables'					=> 'Installing Tables',
'ErrorDbConnection'				=> 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDatabaseVersion'			=> 'The database version is %1 but requires at least %2.',
'To'							=> '->',
'AlterTable'					=> 'Altering %1 table',
'InsertRecord'					=> 'Inserting Record into %1 table',
'RenameTable'					=> 'Renaming %1 table',
'UpdateTable'					=> 'Updating %1 table',
'InstallDefaultData'			=> 'Adding Default Data',
'InstallPagesBegin'				=> 'Adding Default Pages',
'InstallPagesEnd'				=> 'Finished Adding Default Pages',
'InstallSystemAccount'			=> 'Adding <code>System</code> User',
'InstallDeletedAccount'			=> 'Adding <code>Deleted</code> User',
'InstallAdmin'					=> 'Добавяме административен потребител',
'InstallAdminSetting'			=> 'Добавяме административен потребител',
'InstallAdminGroup'				=> 'Adding Admins Group',
'InstallAdminGroupMember'		=> 'Adding Admins Group Member',
'InstallEverybodyGroup'			=> 'Adding Everybody Group',
'InstallModeratorGroup'			=> 'Adding Moderator Group',
'InstallReviewerGroup'			=> 'Adding Reviewer Group',
'InstallLogoImage'				=> 'Adding Logo Image',
'LogoImage'						=> 'Logo image',
'InstallConfigValues'			=> 'Adding Config Values',
'ConfigValues'					=> 'Config Values',
'ErrorInsertPage'				=> 'Error inserting %1 page',
'ErrorInsertPagePermission'		=> 'Error setting permission for %1 page',
'ErrorInsertDefaultMenuItem'	=> 'Error setting page %1 as default menu item',
'ErrorPageAlreadyExists'		=> 'The %1 page already exists',
'ErrorAlterTable'				=> 'Error altering %1 table',
'ErrorInsertRecord'				=> 'Error Inserting Record into %1 table',
'ErrorRenameTable'				=> 'Error renaming %1 table',
'ErrorUpdatingTable'			=> 'Error updating %1 table',
'CreatingTable'					=> 'Създаваме таблица %1',
'ErrorAlreadyExists'			=> 'The %1 already exists',
'ErrorCreatingTable'			=> 'Error creating %1 table, does it already exist?',
'DeletingTables'				=> 'Deleting Tables',
'DeletingTablesEnd'				=> 'Finished Deleting Tables',
'ErrorDeletingTable'			=> 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable'					=> 'Deleting %1 table',
'NextStep'						=> 'На следващата стъпка, инсталаторът ще опита да запише обновения конфигурационния файл, %1. Кофигурационният файл %1 се  разполага в главната директория, където е WackoWiki. За да стане промяната, този файл трябва да е достъпен за запис чрез системата сървър/скрипт! За да няма проблеми, трябва сега временно да се променят правата за достъп до този файл. В противен случай ще трябва да допишете промените на ръка. Отново, погледнете за подробности, малко е на английски, но все пак <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',

/*
   Write Config Page
*/
'write-config'					=> 'Write Config File',
'FinalStep'						=> 'Final Step',
'Writing'						=> 'Запис на конфигурационния файл',
'RemovingWritePrivilege'		=> 'Removing Write Privilege',
'InstallationComplete'			=> 'Installation Complete',
'ThatsAll'						=> 'Ура! Изглежда успешно. Сега можете <a href="%1">да видите своя сайт WackoWiki</a>.',
'SecurityConsiderations'		=> 'Security Considerations',
'SecurityRisk'					=> 'Не забравяйте накрая да промените обратно правата за достъп на %1 на сървъра. Въпрос на "сигурност"!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges'			=> 'Конфигурационния файл %1 не може да се запише. Трябва сега временно да се променят правата за достъп до (мястото на) този файл или да се направи празен файл %1<br>%2<br><br>; не забравяйте накрая да забраните обратно правата, т.e. <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Ако нещо не става, ще трябва да копирате и запишете следващия текст в нов празен файл на вашия компютър и после да го прехвърлите с име %1 на сървъра в главната директория на Wacko. При проблеми, вижте (англ.) <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> или (руски) <a href="https://wackowiki.org/doc/Doc/Русский/Инсталляция">WackoWiki:Doc/Русский/Инсталляция</a>',
'ErrorPrivilegesUpgrade'		=> 'Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'записан ',
'DontChange'					=> 'не променяйте wacko_version ръчно!',
'ConfigDescription'				=> 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Нов опит',

];
