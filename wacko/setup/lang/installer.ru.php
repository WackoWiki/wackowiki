<?php
$lang = array(

/*
   Language Settings
*/
"Charset" => "windows-1251",
"LangISO" => "ru",
"LangName" => "Русский",

/*
   Generic Page Text
*/
"Title" => "Установка WackoWiki",
"Continue" => "Продолжить",
"Back" => "Назад",

/*
   Language Selection Page
*/
"Lang" => "Настройки языка",
"LangDesc" => "Пожалуйста, выберите язык. Он будет использоваться в процессе установки, а также станет языком по умолчанию установленной WackoWiki.",

/*
   System Requirements Page
*/
"version-check" => "Системные требования",
"PHPVersion" => "Версия PHP",
"PHPDetected" => "Обнаружен PHP",
"ModRewrite" => "Расширение Apache Rewrite (необязатально)",
"ModRewriteInstalled" => "Модуль перезаписи (mod_rewrite) установлен?",
"Database" => "База данных",
"Permissions" => "Права доступа",
"ReadyToInstall" => "Готовы к установке?",
"Installed" => "Установлена WackoWiki версии ",
"ToUpgrade" => "Приглашаем вас <strong>обновить</strong> вашу WackoWiki до ",
"PleaseBackup" => "Cделайте резервную копию базы данных, конфигурационного файла и других изменённых вами файлов (например, файлов темы) до начала процесса установки. Это может спасти вас от очень неприятных моментов.",
"Fresh" => "Поскольку программа установки не обнаружила существующего файла настроек WackoWiki, предполагается, что это установка с чистого листа. Будет установлена WackoWiki ",
"Requirements" => "Ваш сервер должен соответстовать требованиям, перечисленным ниже.",
"OK" => "OK",
"Problem" => "Проблема",
"NotePermissions" => "Программа установки попытается записать настройки в файл <tt>config.inc.php</tt>, расположеный в каталоге WackoWiki. Чтобы всё прошло успешно, убедитесь, что веб-сервер имеет право на запись в данный файл. Если это невозможно, вам придётся изменить файл вручную (программа установки объяснит, как).<br /><br />См. <a href=\"http://wackowiki.org/Doc/English/Installation\" target=\"_blank\">WackoWiki:DocEnglish/Installation</a>.",
"ErrorPermissions" => "Это может возникнуть, когда программа установки не может автоматически задать права, требуемые для корректной работы WackoWiki. Позже во время установки вам будет предложено настроить вручную требуемые права доступа к файлам на сервере.",
"ErrorMinPHPVersion" => "Версия PHP должна быть больше <strong>4.3.3</strong>, а сервер использует одну из предыдущих версий.  Для корректной работы WackoWiki нужно обновить PHP на одну из последних версий.",
"Ready" => "Поздравляем, ваш сервер готов для запуска WackoWiki. Процесс её настройки займёт несколько следующих страниц.",

/*
   Site Config Page
*/
"site-config" => "Настройки сайта",
"Name" => "Название WackoWiki",
"NameDesc" => "Пожалуйста, введите имя вашего сайта WackoWiki, оно должно быть <a href=\"http://wackowiki.org/Doc/English/WikiName\" title=\"View Help\" target=\"_blank\">ВикиИменем</a>.",
"Home" => "Главная страница",
"HomeDesc" => "Введите имя домашней страницы;&nbsp;&mdash;&nbsp;это будет страница по умолчанию, её пользователи увидят первой при посещении сайта; имя должно <a href=\"http://wackowiki.org/Doc/English/WikiName\" title=\"View Help\" target=\"_blank\">ВикиИменем</a>.",
"MultiLang" => "Режим многоязычности",
"MultiLangDesc" => "Режим многоязычности, позволяющий работать со страницами на разных языках. Если режим включен, то программа установки вставит начальный набор страниц для всех известных ей языков.",
"Admin" => "Admin Name",
"AdminDesc" => "Выберите имя администратора. Должно представлять собой ВикиИмя (без русских букв) <a href=\"http://wackowiki.org/Doc/English/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"Password" => "Пароль администратора",
"PasswordDesc" => "Выберите пароль (не менее пяти символов).",
"Password2" => "Подтверждение пароля:",
"Mail" => "Адрес электронной почты администратора",
"MailDesc" => "Введите адрес электронной почты администратора.",
"Base" => "Базовый URL",
"BaseDesc" => "Базовый URL сайта WackoWiki. К нему будут добавляться имена страниц; если используется mod_rewrite, адрес должен оканчиваться прямой косой чертой, т. е.</p><ul><li><b><i>http://www.wackowiki.org/</i></b></li><li><b><i>http://www.wackowiki.org/wiki/</i></b></li></ul><p class=\"no_top\">Если использование mod_rewrite не планируется, URL должен оканчиваться \"?page=\" т. е.<ul><li><b><i>http://www.wackowiki.org/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/wiki/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/?page=</i></b></li></ul>",
"Rewrite" => "Rewrite-режим",
"RewriteDesc" => "Rewrite-режим должен быть включен, если вы используете mod_rewrite.",
"Enabled" => "Включен:",
"ErrorAdminName" => "Нужно ввести корректное ВикиИмя в качестве имени администратора!",
"ErrorAdminEmail" => "Введите верный адрес электронной почты!",
"ErrorAdminPasswordMismatch" => "Пароли не совпадают. Пожалуйста, повторите ввод пароля администратора",
"ErrorAdminPasswordShort" => "Пароль администратора слишком короткий, минимальная длина&nbsp;&mdash;&nbsp;5 символов!",
"WarningRewriteMode" => "ВНИМАНИЕ!\nНастройки базового URL и Rewrite-режима выглядят подозрительно. Обычно при включенном Rewrite не бывает знака ? в базовом URL, но у вас он есть.\n\nДля продолжения инсталляции с текущими настройками нажмите ОК.\nДля того, чтобы вернуться в форму и всё исправить, нажмите ОТМЕНА.\n\nЕсли вы решили идти дальше, помните, что такое сочетание часто является причиной неработоспособности после инсталляции.",
"ModRewriteStatusUnknown" => "Программа установки не может проверить, включён ли mod_rewrite, но это не означает, что он отключён",

/*
   Database Config Page
*/
"database-config" => "Настройки БД",
"DBDriverDesc" => "Драйвер базы данных, который вы хотите использовать. Нужно выбрать legacy-драйвер, если не используется PHP 5.1 (или старше) с установленным <a href=\"http://de2.php.net/pdo\" target=\"_blank\">PDO</a>.",
"DBDriver" => "Драйвер",
"DBHost" => "Имя сервера",
"DBHostDesc" => "Имя сервера, на котором запущена БД. Обычно \"localhost\" (т. е. та машина, на которую устанавливается WackoWiki).",
"DBPort" => "Порт (необязательно)",
"DBPortDesc" => "Номер порта, по которому доступен сервер БД, для использования порта по умолчанию оставьте пустым.",
"DB" => "Имя базы данных",
"DBDesc" => "База данных, которую будет использовать WackoWiki. Она должна существовать, чтобы установка продолжилась!",
"DBUserDesc" => "Имя пользователя для подключения к базе данных.",
"DBUser" => "Имя пользователя",
"DBPasswordDesc" => "Пароль пользователя для подключения к базе данных.",
"DBPassword" => "Пароль",
"PrefixDesc" => "Префикс всех таблиц, используемых WackoWiki. Это позволит запускать несколько WackoWiki, используя одну БД&nbsp;&mdash;&nbsp;достаточно указать для них разные префиксы таблиц.",
"Prefix" => "Префикс таблиц",
"ErrorNoDbDriverDetected" => "Драйвера баз данных не обнаружены. Пожалуйста, включите использование расширений mysql, mysqli или pdo в файле php.ini.",
"ErrorNoDbDriverSelected" => "Не выбран драйвер базы данных, выберите один из списка.",

/*
   Database Installation Page
*/
"database-install" => "Установка базы данных",
"TestingConfiguration" => "Тестирование настроек",
"TestConnectionString" => "Проверка параметров соединения с БД",
"TestDatabaseExists" => "Проверка существования указанной БД",
"InstallingTables" => "Установка таблиц",
"ErrorDBConnection" => "Произошла ошибка при подключении к БД с указанными параметрами. Пожалуйста, вернитесь и проверьте их правильность.",
"ErrorDBExists" => "Указанная БД не обнаружена. Пожалуйста, удостоверьтесь, что такая БД существует!",
"To" => "->",
"AlterTable" => "Изменение структуры таблицы <tt>%1</tt>",
"AlterUsersTable" => "Изменение структуры таблицы пользователей",
"InstallingDefaultData" => "Добавление данных по умолчанию",
"InstallingPagesBegin" => "Добавление страниц по умолчанию",
"InstallingPagesEnd" => "Добавление страниц по умолчанию завершено",
"InstallingAdmin" => "Добавление пользователя-администратора",
"InstallingLogoImage" => "Добавление картинки логотипа",
"ErrorInsertingPage" => "Ошибка вставки страницы <tt>%1</tt>",
"ErrorInsertingPageReadPermission" => "Ошибка установки прав на чтение страницы <tt>%1</tt>",
"ErrorInsertingPageWritePermission" => "Ошибка установки прав на запись страницы <tt>%1</tt>",
"ErrorInsertingPageCommentPermission" => "Ошибка установки прав на комментирование страницы <tt>%1</tt>",
"ErrorPageAlreadyExists" => "Страница <tt>%1</tt> уже существует",
"ErrorAlteringTable" => "Ошибка изменения структуры таблицы <tt>%1</tt>",
"CreatingTable" => "Создание таблицы <tt>%1</tt>",
"ErrorAlreadyExists" => "<tt>%1</tt> уже существует",
"ErrorCreatingTable" => "Ошибка создания таблицы <tt>%1</tt>, она уже существует?",
"ErrorMovingRevisions" => "Ошибка перемещения данных версий",
"MovingRevisions" => "Перемещение все старых версий в таблицу revisions",
"CleanupScript" => "Попробуйте <a href=\"http://wackowiki.org/Doc/English/CleanupScript\" target=\"_blank\">WackoWiki:DocEnglish/CleanupScript</a>, это ускорит вашу WackoWiki.",

/*
   Write Config Page
*/
"write-config" => "Сохранение конфигурационного файла",
"Writing" => "Сохранение настроек",
"Writing2" => "Сохранение конфигурационного файла",
"RemovingWritePrivilege" => "Удаление привилегий на запись",
"InstallationComplete" => "Ура! Всё прошло успешно. Теперь вы можете <a href=\"%1\">посмотреть свой сайт WackoWiki</a>.",
"SecurityConsiderations" => "Соображения безопасности",
"SecurityRisk" => "Не забудьте убрать права на изменение файла <tt>config.inc.php</tt> веб-сервером. Если этого не сделать, вас смогут взломать!",
"RemoveSetupDirectory" => "Сейчас вы должны удалить каталог \"setup\";&nbsp;&mdash;&nbsp;процесс установки завершён.",
"ErrorGivePrivileges" => "Конфигурационный файл <tt>%1</tt> не может быть сохранён. Нужно временно дать веб-серверу права на запись либо на каталог WackoWiki, либо на пустой файл <tt>config.inc.php</tt> (<tt>touch config.inc.php ; chmod 666 config.inc.php</tt>; не забудьте убрать эти права после установки, т. e. <tt>chmod 644 config.inc.php</tt>). Если, почему-либо вы не можете выставить такие права, придётся скопировать текст, расположенный ниже в новый файл и загрузить его на сервер под именем <tt>config.inc.php</tt> в каталог WackoWiki. После этого ваш сайт должен заработать. Если нет, смотрите <a href=\"http://wackowiki.org/Doc/English/Installation\">WackoWiki:DocEnglish/Installation</a>",
"NextStep" => "На следующем шаге программа установки попробует сохранить обновлённый конфигурационный файл, <tt>config.inc.php</tt>. Пожалуйста, проверьте, что веб-сервер имеет достаточно прав для изменения файла; в противном случае вам придётся сохранить изменения вручную. Не побоимся повториться, см. <a href=\"http://wackowiki.org/Doc/English/Installation\" target=\"_blank\">WackoWiki:DocEnglish/Installation</a>.",
"WrittenAt" => "сохранён ",
"DontChange" => "не меняйте wakka_version вручную!",
"ConfigDescription" => "detailed description http://wackowiki.org/Doc/Russian/FajjlKonfiguracii",
"TryAgain" => "Попытаться снова",

);
?>