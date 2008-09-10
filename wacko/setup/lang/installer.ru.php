<?php
$lang = array(

/*
   Language Settings
*/
"Charset" => "windows-1251",
"LangISO" => "ru",
"LangName" => "Russian",

/*
   Generic Page Text
*/
"Title" => "Инсталляция WackoWiki",
"Continue" => "Продолжить",
"Back" => "Назад",

/*
   Language Selection Page
*/
"Lang" => "Настройки языка",
"LangDesc" => "Выберите язык. Он будет использоваться в процессе инсталляции, а также станет языком по умолчанию в устновленной WackoWiki.",

/*
   System Requirements Page
*/
"version-check" => "System Requirements",
"PHPVersion" => "PHP Version",
"PHPDetected" => "Detected PHP",
"ModRewrite" => "Apache Rewrite Extension (Optional)",
"ModRewriteInstalled" => "Rewrite Extension (mod_rewrite) Installed?",
"Database" => "Database",
"Permissions" => "Permissions",
"ReadyToInstall" => "Ready to Install?",
"Installed" => "Установлена WackoWiki версии ",
"ToUpgrade" => "Приглашаем Вас <strong>обновить</strong> Вашу WackoWiki до ",
"PleaseBackup" => "Пожалуйста, сделайте резервную копию вашей базы данных, конфигурационного файла и других изменённых вами файлов (например, файлов темы), пока ещё НЕ ПОЗДНО. Это может спасти Вас от очень неприятных моментов.",
"Fresh" => "Поскольку программа установки не обнаружила следов существующей Ваки, то, вероятно, это инсталляция, а не обновление. Вы собираетесь установить WackoWiki ",
"Requirements" => "Your server must meet the requirements listed below.",
"OK" => "OK",
"Problem" => "Problem",
"NotePermissions" => "Программа установки попытается записать настройки в файл <tt>wakka.config.php</tt>, расположеный в корне папки, в которую Вы устанавливаете WackoWiki. Чтобы всё прошло успешно, удостоверьтесь, что веб-сервер имеет достаточно прав для изменения этого файла! Если почему-либо этого достичь не удаётся, Вам придётся изменить этот файл вручную.<br /><br />См. <a href=\"http://wackowiki.org/Archiv/DocEnglish/Installation\" target=\"_blank\">WackoWiki:DocEnglish/Installation</a>.",
"ErrorPermissions" => "It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.",
"ErrorMinPHPVersion" => "The PHP Version must be greater than <strong>4.3.3</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.",
"Ready" => "Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.",

/*
   Site Config Page
*/
"site-config" => "Настройки сайта",
"Name" => "Укажите имя Ваки",
"NameDesc" => "Имя вашей Ваки. Обычно представляет собой ВикиИмя и выглядит ПримерноВотТак. <a href=\"http://wackowiki.org/Archiv/DocEnglish/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"Home" => "Главная страница",
"HomeDesc" => "Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href=\"http://wackowiki.org/Archiv/DocEnglish/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"MultiLang" => "Режим &laquo;многоязычности&raquo;",
"MultiLangDesc" => "Режим &laquo;многоязычности&raquo;, позволяющий работать со страницами на разных языках. Если режим включен, то инсталлятор вставит начальный набор страниц для всех известных ему языков.",
"Admin" => "Admin Name",
"AdminDesc" => "Выберите имя администратора. Должно представлять собой ВикиИмя (без русских букв) <a href=\"http://wackowiki.org/Archiv/DocEnglish/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"Password" => "Admin Password",
"PasswordDesc" => "Выберите пароль (не менее пяти символов).",
"Password2" => "Подтверждение пароля:",
"Mail" => "Admin Email Address",
"MailDesc" => "Enter the admins email address.",
"Base" => "Базовый URL",
"BaseDesc" => "Your WackoWiki sites base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><b><i>http://www.wackowiki.org/</i></b></li><li><b><i>http://www.wackowiki.org/wiki/</i></b></li></ul><p class=\"no_top\">If you are not going to use mod_rewrite then the URL should end with \"?page=\" i.e.<ul><li><b><i>http://www.wackowiki.org/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/wiki/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/?page=</i></b></li><li><b><i>http://www.wackowiki.org?page=</i></b></li></ul>",
"Rewrite" => "Rewrite-режим",
"RewriteDesc" => "Rewrite-режим должен быть включен, если вы используете mod_rewrite.",
"Enabled" => "Включен:",
"ErrorAdminName" => "Вы должны ввести корректное ВикиИмя в качестве имени администратора!",
"ErrorAdminEmail" => "Введите верный адрес электронной почты!",
"ErrorAdminPasswordMismatch" => "Пароли не совпадают, пожалуйста, повторите ввод пароля администратора!",
"ErrorAdminPasswordShort" => "The admin Пароль слишком короткий, the minimum length is 5 characters!",
"WarningRewriteMode" => "ВНИМАНИЕ!\nНастройки базового URL и Rewrite-режима выглядят подозрительно. Обычно при включенном Rewrite не бывает знака ? в базовом URL, но у вас он есть.\n\nДля продолжения инсталляции с текущими настройками нажмите ОК.\nДля того, чтобы вернуться в форму и всё исправить, нажмите ОТМЕНА.\n\nЕсли вы решили идти дальше, помните, что такое сочетание часто является причиной неработоспособности после инсталляции.",
"ModRewriteStatusUnknown" => "The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled",

/*
   Database Config Page
*/
"database-config" => "Настройки БД",
"DBDriverDesc" => "The database driver you want to use.  You must choose a legacy driver if you do not have PHP5.1 (or greater) and <a href=\"http://de2.php.net/pdo\" target=\"_blank\">PDO</a> installed.",
"DBDriver" => "Driver",
"DBHost" => "Host",
"DBHostDesc" => "The host your database server is running on. Usually \"localhost\" (ie, the same machine your WackoWiki site is on).",
"DBPort" => "Port (Optional)",
"DBPortDesc" => "The port number your database server is accessable through, leave it blank to use the default port number.",
"DB" => "Database Name",
"DBDesc" => "The database WackoWiki should use. This database needs to exist already once you continue!",
"DBUserDesc" => "Name and password of the user used to connect to your database.",
"DBUser" => "User Name",
"DBPasswordDesc" => "Name and password of the user used to connect to your database.",
"DBPassword" => "Password",
"PrefixDesc" => "Префикс всех таблиц, используемых Wacko. Это повзволяет вам запускать несколько WackoWiki, используя одну БД&nbsp;&mdash;&nbsp;вы всего лишь должны указать для них различные префиксы.",
"Prefix" => "Префикс таблиц",
"ErrorNoDbDriverDetected" => "No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.",
"ErrorNoDbDriverSelected" => "No database driver has been selected, please pick one from the list.",

/*
   Database Installation Page
*/
"database-install" => "Database Installation",
"TestingConfiguration" => "Тестирование настроек",
"TestConnectionString" => "Проверка параметров соединения с БД",
"TestDatabaseExists" => "Checking if the database you specified exists",
"InstallingTables" => "Installing Tables",
"ErrorDBConnection" => "There was a problem with the database connection details you specified, please go back and check they are correct.",
"ErrorDBExists" => "Указанная Вами БД не обнаружена. Пожалуйста, удостоверьтесь, что такая БД существует!",
"To" => "->",
"AlterTable" => "Altering %1 Table",
"AlterUsersTable" => "Altering Users Table",
"InstallingDefaultData" => "Adding Default Data",
"InstallingPagesBegin" => "Adding Default Pages",
"InstallingPagesEnd" => "Finished Adding Default Pages",
"InstallingAdmin" => "Добавляем административного пользователя",
"InstallingLogoImage" => "Adding Logo Image",
"ErrorInsertingPage" => "Error inserting %1 page",
"ErrorInsertingPageReadPermission" => "Error setting read permission for %1 page",
"ErrorInsertingPageWritePermission" => "Error setting write permission for %1 page",
"ErrorInsertingPageCommentPermission" => "Error setting comment permissions for %1 page",
"ErrorPageAlreadyExists" => "The %1 page already exists",
"ErrorAlteringTable" => "Error altering %1 table",
"CreatingTable" => "Создаём таблицу %1",
"ErrorAlreadyExists" => "The %1 already exists",
"ErrorCreatingTable" => "Error creating %1 table, does it already exist?",
"ErrorMovingRevisions" => "Error moving revision data",
"MovingRevisions" => "Перемещаем все старые версии в таблицу revisions",
"CleanupScript" => "If you'll use <a href=\"http://wackowiki.org/Archiv/DocEnglish/CleanupScript\" target=\"_blank\">WackoWiki:DocEnglish/CleanupScript</a>, you will speedup your Wacko.",

/*
   Write Config Page
*/
"write-config" => "Write Config File",
"Writing" => "Сохраняем настройки",
"Writing2" => "Сохраняем конфигурационный файл",
"RemovingWritePrivilege" => "Removing Write Privilege",
"InstallationComplete" => "Ура! Всё прошло успешно. Теперь Вы можете <a href=\"%1\">view your WackoWiki site</a>.",
"SecurityConsiderations" => "Security Considerations",
"SecurityRisk" => "Не забудьте убрать права на изменение файла <tt>wakka.config.php</tt> веб-сервером. Если Вы этого не сделаете, Вас смогут \"взломать\"!",
"RemoveSetupDirectory" => "You should delete the \"setup\" directory now that the installation process has been completed.",
"ErrorGivePrivileges" => "Конфигурационный файл %1 не может быть сохранён. Вы временно должны дать веб-серверу права на запись либо на папку, в которую установлена WackoWiki, либо на пустой файл <tt>wakka.config.php</tt> (<tt>touch wakka.config.php ; chmod 666 wakka.config.php</tt>; не забудьте убрать эти права после установки, т.e. <tt>chmod 644 wakka.config.php</tt>). Если, почему-либо, Вы не можете выставить такие права, Вам придётся скопировать текст, расположенный ниже в новый файл и загрузить его на сервер под именем <tt>wakka.config.php</tt> в папку Ваки. После этого Ваш сайт должен заработать. В случае возникновения проблем, обращайтесь на <a href=\"http://wackowiki.org/Archiv/DocEnglish/Installation\">WackoWiki:DocEnglish/Installation</a>",
"NextStep" => "На следующем шаге инсталлятор попробует сохранить обновлённый конфигурационный файл, <tt>wakka.config.php</tt>. Пожалуйста, проверьте, что веб-сервер имеет достаточно прав для изменения файла; в противном случае Вам придётся сохранить изменения вручную. Не побоимся повториться, см. <a href=\"http://wackowiki.org/Archiv/DocEnglish/Installation\" target=\"_blank\">WackoWiki:DocEnglish/Installation</a>.",
"WrittenAt" => "сохранен ",
"DontChange" => "не меняйте wakka_version вручную!",
"TryAgain" => "Попытаться снова",

// O L D
/*

"pleaseConfigure" => "Пожалуйста, настройте вашу WackoWiki ниже.",
"Installing Stuff" => "Инсталлируем",
"Looking for database..." => "Проверка БД...",
"pages alter" => "Немного изменяем структуру таблицы pages...",
"useralter" => "Немного изменяем структуру таблицы user...",
"Already exists?" => "Уже существет?",
"Adding some pages..." => "Добавляем начальный набор страниц...",
"And table..." => "И таблицу %1 (подождите немного!)...",
"return" => "вернуться на Вашу Ваку",
#"mysqlHostDesc" => "Узел (hostname), на котором работает СУБД MySQL. Обычно \"localhost\".",
#"mysqlHost" => "Узел MySQL",
#"dbDesc" => "База данных MySQL, которую должна использовать WackoWiki. Такая база данных уже должна существовать!",
#"db" => "БД MySQL",
#"mysqlPasswDesc" => "Имя пользователя и пароль для доступа к БД MySQL.",
#"mysqlUser" => "Пользователь MySQL",
#"mysqlPassw" => "Пароль MySQL",
"homeDesc" => "Главная страница вашей инсталляции WackoWiki. Должна представлять собой ВикиИмя.",
"baseDesc" => "Базовый URL вашей инсталляции WackoWiki. Имена страниц присоединяются к нему, поэтому он должен включать параметр \"?page=\", если Вы почему-либо не можете использовать mod_rewrite.",
"AdminConf" => "Настройки аккаунта администратора",
"admin" => "Имя",
"password" => "Пароль",
"mailDesc" => "Адрес электронной почты администратора.",
"adding pages" => "Добавляем новые страницы...",
"Doubles" => "Попробуйте <a href=\"http://wackowiki.org/WackoDokumentacija/CleanupScript\" target=\"_blank\">WackoWiki:WackoДокументация/CleanupScript</a>, это ускорит вашу Ваку.",
"newinstall" => "Поскольку это новая установка, инсталлятор попробовал сам предположить необходимые значения. Изменяйте их, только если вы понимаете, что делаете!",
"apply rights" => "Попытка установить права доступа на папку ",
"apply rights yourself" => "Вы должны самостоятельно установить доступ на запись на папку ",
*/

);
?>