<?php
$lang = [

/*
   Language Settings
*/
'Charset'		=> 'utf-8',
'LangISO'		=> 'ru',
'LangLocale'	=> 'ru_RU',
'LangName'		=> 'Русский',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Категории',
	'groups_page'		=> 'Группы',
	'users_page'		=> 'Пользователи',

	'search_page'		=> 'Поиск',
	'login_page'		=> 'Вход',
	'account_page'		=> 'Настройки',
	'registration_page'	=> 'Регистрация',
	'password_page'		=> 'Пароль',

	'changes_page'		=> 'Изменения',
	'comments_page'		=> 'НовыеКомментарии',
	'index_page'		=> 'Каталог',

	'random_page'		=> 'СлучайнаяСтраница',
	#'help_page'			=> 'Помощь',
	#'terms_page'		=> 'УсловияИспользования',
	#'privacy_page'		=> 'Конфиденциальность',

	// time
	#'date_format'					=> 'd.m.Y',
	#'time_format'					=> 'H:i',
	#'time_format_seconds'			=> 'H:i:s',
],

/*
   Generic Page Text
*/
'Title'							=> 'Установка WackoWiki',
'Continue'						=> 'Продолжить',
'Back'							=> 'Назад',
'Recommended'					=> 'рекомендуемый',
'InvalidAction'					=> 'Недопустимое действие',

/*
   Language Selection Page
*/
'lang'							=> 'Выбор языка',
'PleaseUpgradeToR6'				=> 'Вы используете доисторическую (до %1) версию WackoWiki. Для обновления до текущей версии сперва необходим отдельный апгрейд до %2.',
'UpgradeFromWacko'				=> 'Добро пожаловать в WackoWiki! Сейчас начнётся обновление WackoWiki с %1 до %2.  Процесс обновления займёт несколько следующих страниц.',
'FreshInstall'					=> 'Добро пожаловать в WackoWiki! Всё готово для установки WackoWiki %1.  Процесс установки займёт несколько следующих страниц.',
'PleaseBackup'					=> 'Сделайте резервную копию базы данных, конфигурационного файла и других изменённых вами файлов (например, файлов темы) до начала процесса установки. Это может спасти Вас от очень неприятных моментов.',
'LangDesc'						=> 'Пожалуйста, выберите язык. Он будет использоваться в процессе установки, а также станет языком по умолчанию установленной WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Системные требования',
'PhpVersion'					=> 'Версия PHP',
'PhpDetected'					=> 'Обнаружен PHP',
'ModRewrite'					=> 'Расширение Apache Rewrite (необязательно)',
'ModRewriteInstalled'			=> 'Модуль перезаписи (mod_rewrite) установлен?',
'Database'						=> 'База данных',
'PhpExtensions'					=> 'PHP Расширения',
'Permissions'					=> 'Права доступа',
'ReadyToInstall'				=> 'Готовы к установке?',
'Requirements'					=> 'Ваш сервер должен соответствовать требованиям, перечисленным ниже.',
'OK'							=> 'ОК',
'Problem'						=> 'Проблема',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Ваша установка PHP не содержит расширения PHP, необходимые для работы WackoWiki.',
'PcreWithoutUtf8'				=> 'PCRE не скомпилирован с поддержкой UTF-8.',
'NotePermissions'				=> 'Программа установки попытается записать настройки в файл %1, расположенный в каталоге WackoWiki. Чтобы всё прошло успешно, убедитесь, что веб-сервер имеет право на запись в данный файл. Если это невозможно, вам придётся изменить файл вручную (программа установки объяснит, как).<br><br>См. <a href="https://wackowiki.org/doc/Doc/Русский/Инсталляция" target="_blank">WackoWiki:Doc/Русский/Инсталляция</a>.',
'ErrorPermissions'				=> 'Она может возникнуть, когда программа установки не может автоматически задать права, требуемые для корректной работы WackoWiki. Позже во время установки вам будет предложено настроить вручную требуемые права доступа к файлам на сервере.',
'ErrorMinPhpVersion'			=> 'Версия PHP должна быть больше <strong>' . PHP_MIN_VERSION . '</strong>, а сервер использует одну из предыдущих версий.  Для корректной работы WackoWiki нужно обновить PHP на одну из последних версий.',
'Ready'							=> 'Поздравляем, ваш сервер готов для запуска WackoWiki. Процесс её настройки займёт несколько следующих страниц.',

/*
   Site Config Page
*/
'config-site'					=> 'Настройки сайта',
'SiteName'						=> 'Название Wiki',
'SiteNameDesc'					=> 'Пожалуйста, введите имя вашего сайта Wiki.',
'SiteNameDefault'				=> 'МояВики',
'HomePage'						=> 'Главная страница',
'HomePageDesc'					=> 'Введите имя домашней страницы — это будет страница по умолчанию, пользователи увидят её первой при посещении сайта; имя должно <a href="https://wackowiki.org/doc/Doc/Русский/ВикиИмя" title="View Help" target="_blank">ВикиИменем</a>.',
'HomePageDefault'				=> 'Главная',
'MultiLang'						=> 'Режим многоязычности',
'MultiLangDesc'					=> 'Режим многоязычности позволяет держать страницы на разных языках в одной вики. Если режим включён, программа установки создаст начальные пункты меню для всех языков, включённых в дистрибутив.',
'AllowedLang'					=> 'Разрешенные языки',
'AllowedLangDesc'				=> 'Рекомендуется выбрать набор языков, который вы намерены использовать, иначе будут выбраны все.',
'Admin'							=> 'Имя администратора',
'AdminDesc'						=> 'Введите имя администратора, оно должно быть <a href="https://wackowiki.org/doc/Doc/Русский/ВикиИмя" title="View Help" target="_blank">ВикиИменем</a> (без русских букв) (например, <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Имя пользователя должно быть от %1 до %2 знаков и должно содержать только буквы.',
'NameCamelCaseOnly'				=> 'Имя пользователя должно быть от %1 до %2 знаков и выглядеть как ВикиИмя.',
'Password'						=> 'Пароль администратора',
'PasswordDesc'					=> 'Введите пароль (не менее %1 символов).',
'PasswordConfirm'				=> 'Подтверждение пароля:',
'Mail'							=> 'Адрес электронной почты администратора',
'MailDesc'						=> 'Введите адрес электронной почты администратора.',
'Base'							=> 'Базовый URL',
'BaseDesc'						=> 'Базовый URL сайта WackoWiki. К нему будут добавляться имена страниц; если используется mod_rewrite, адрес должен оканчиваться прямой косой чертой, т. е.</p><ul><li><strong><code>https://example.com/</code></strong></li><li><strong><code>https://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Rewrite-режим',
'RewriteDesc'					=> 'Rewrite-режим должен быть включён, если вы используете mod_rewrite.',
'Enabled'						=> 'Включён:',
'ErrorAdminEmail'				=> 'Введите правильный адрес электронной почты!',
'ErrorAdminPasswordMismatch'	=> 'Пароли не совпадают. Пожалуйста, повторите ввод пароля администратора',
'ErrorAdminPasswordShort'		=> 'Пароль администратора слишком короткий, минимальная длина - %1 символов!',
'ModRewriteStatusUnknown'		=> 'Программа установки не может проверить, включён ли mod_rewrite, но это не означает, что он отключён',

/*
   Database Config Page
*/
'config-database'				=> 'Настройки базы данных',
'DbDriver'						=> 'Драйвер',
'DbDriverDesc'					=> 'Драйвер базы данных, который вы хотите использовать.',
'DbCharset'						=> 'Кодировка',
'DbCharsetDesc'					=> 'Кодировка записей базы данных.',
'DbEngine'						=> 'Движок базы данных',
'DbEngineDesc'					=> 'Движок базы данных который будет использован.',
'DbHost'						=> 'Имя сервера',
'DbHostDesc'					=> 'Имя сервера, на котором запущена БД. Обычно <code>127.0.0.1</code> или <code>localhost</code> (т. е. та машина, на которую устанавливается WackoWiki).',
'DbPort'						=> 'Порт (необязательно)',
'DbPortDesc'					=> 'Номер порта, по которому доступен сервер БД, для использования порта по умолчанию оставьте пустым.',
'DbName'						=> 'Имя базы данных',
'DbNameDesc'					=> 'База данных, которую будет использовать WackoWiki. Она должна существовать, чтобы установка продолжилась!',
'DbUser'						=> 'Имя пользователя базы данных',
'DbUserDesc'					=> 'Имя пользователя для подключения к базе данных.',
'DbPassword'					=> 'Пароль',
'DbPasswordDesc'				=> 'Пароль пользователя для подключения к базе данных.',
'Prefix'						=> 'Префикс таблиц',
'PrefixDesc'					=> 'Префикс всех таблиц, используемых WackoWiki. Это позволит запускать несколько WackoWiki, используя одну БД — достаточно указать для них разные префиксы таблиц (например, wacko_).',
'ErrorNoDbDriverDetected'		=> 'Драйвера баз данных не обнаружены. Пожалуйста, включите использование расширений mysqli или pdo_mysql в файле php.ini.',
'ErrorNoDbDriverSelected'		=> 'Не выбран драйвер базы данных, выберите один из списка.',
'DeleteTables'					=> 'Удалить существующие таблицы?',
'DeleteTablesDesc'				=> 'ВНИМАНИЕ! Включение этого режима приведёт к удалению всех существующих данных из базы вики. Отменить это действие не удастся, данные могут быть восстановлены только вручную из резервной копии.',
'ConfirmTableDeletion'			=> 'Вы уверены, что хотите удалить все существующие таблицы вики?',

/*
   Database Installation Page
*/
'install-database'				=> 'Установка базы данных',
'TestingConfiguration'			=> 'Тестирование настроек',
'TestConnectionString'			=> 'Проверка параметров соединения с БД',
'TestDatabaseExists'			=> 'Проверка существования указанной БД',
'TestDatabaseVersion'			=> 'Проверка версии СУБД',
'InstallTables'					=> 'Установка таблиц',
'ErrorDbConnection'				=> 'Произошла ошибка при подключении к БД с указанными параметрами. Пожалуйста, вернитесь и проверьте их правильность.',
'ErrorDbExists'					=> 'Указанная БД не обнаружена. Пожалуйста, удостоверьтесь, что такая БД существует!',
'ErrorDatabaseVersion'			=> 'Установлена СУБД версии %1, тогда как требуется, как минимум, версия %2.',
'To'							=> '->',
'AlterTable'					=> 'Изменение структуры таблицы %1',
'InsertRecord'					=> 'Вставка записи в таблицу %1',
'RenameTable'					=> 'Переименование таблицы %1',
'UpdateTable'					=> 'Обновление таблицы %1',
'InstallDefaultData'			=> 'Добавление данных по умолчанию',
'InstallPagesBegin'				=> 'Добавление страниц по умолчанию',
'InstallPagesEnd'				=> 'Добавление страниц по умолчанию завершено',
'InstallSystemAccount'			=> 'Добавление супер-пользователя <code>System</code>',
'InstallDeletedAccount'			=> 'Добавление супер-пользователя <code>Deleted</code>',
'InstallAdmin'					=> 'Добавление пользователя-администратора',
'InstallAdminSetting'			=> 'Добавление пользователя-администратора',
'InstallAdminGroup'				=> 'Добавление группы Admins',
'InstallAdminGroupMember'		=> 'Добавление участников в группу Admins',
'InstallEverybodyGroup'			=> 'Добавление группы Everybody',
'InstallModeratorGroup'			=> 'Добавление группы Moderator',
'InstallReviewerGroup'			=> 'Добавление группы Reviewer',
'InstallLogoImage'				=> 'Добавление картинки логотипа',
'LogoImage'						=> 'картинки логотипа',
'InstallConfigValues'			=> 'Добавление параметров конфигурации',
'ConfigValues'					=> 'Параметры конфигурации',
'ErrorInsertPage'				=> 'Ошибка вставки страницы %1',
'ErrorInsertPagePermission'		=> 'Ошибка установки прав страницы %1',
'ErrorInsertDefaultMenuItem'	=> 'Ошибка установки страницы %1как пункта меню по умолчанию',
'ErrorPageAlreadyExists'		=> 'Страница %1 уже существует',
'ErrorAlterTable'				=> 'Ошибка изменения структуры таблицы %1',
'ErrorInsertRecord'				=> 'Ошибка вставки записи в таблицу %1',
'ErrorRenameTable'				=> 'Ошибка переименования таблицы %1',
'ErrorUpdatingTable'			=> 'Ошибка обновления таблицы %1',
'CreatingTable'					=> 'Создание таблицы %1',
'ErrorAlreadyExists'			=> '%1 уже существует',
'ErrorCreatingTable'			=> 'Ошибка создания таблицы %1, она уже существует?',
'DeletingTables'				=> 'Удаление таблиц',
'DeletingTablesEnd'				=> 'Удаление таблиц завершено',
'ErrorDeletingTable'			=> 'Ошибка удаления таблицы %1, вероятная причина — отсутствие таблицы в базе, в этом случае предупреждение можно проигнорировать.',
'DeletingTable'					=> 'Удаление таблицы %1',

/*
   Write Config Page
*/
'write-config'					=> 'Сохранение конфигурационного файла',
'FinalStep'						=> 'Последний шаг',
'Writing'						=> 'Сохранение конфигурационного файла',
'RemovingWritePrivilege'		=> 'Удаление привилегий на запись',
'InstallationComplete'			=> 'Установка завершена',
'ThatsAll'						=> 'Ура! Всё прошло успешно. Теперь вы можете <a href="%1">посмотреть свой сайт WackoWiki</a>.',
'SecurityConsiderations'		=> 'Соображения безопасности',
'SecurityRisk'					=> 'Не забудьте убрать права на изменение файла %1 веб-сервером. Если этого не сделать, вас смогут взломать!<br>Выполните команду:<br>%2',
'RemoveSetupDirectory'			=> 'Сейчас вы должны удалить каталог %1 — процесс установки завершён.',
'ErrorGivePrivileges'			=> 'Конфигурационный файл %1 не может быть сохранён. Нужно временно дать веб-серверу права на запись либо на каталог WackoWiki, либо на пустой файл %1<br>%2<br>Не забудьте убрать эти права после установки командой:<br>%3<br>Если, почему-либо вы не можете выставить такие права, придётся скопировать текст, расположенный ниже в новый файл и загрузить его на сервер под именем %1 в каталог WackoWiki. После этого ваш сайт должен заработать. Если нет, смотрите <a href="https://wackowiki.org/doc/Doc/Русский/Инсталляция" target="_blank">WackoWiki:Doc/Русский/Инсталляция</a>',
'NextStep'						=> 'На следующем шаге программа установки попробует сохранить обновлённый конфигурационный файл, %1. Пожалуйста, проверьте, что веб-сервер имеет достаточно прав для изменения файла; в противном случае вам придётся сохранить изменения вручную. Не побоимся повториться, см. <a href="https://wackowiki.org/doc/Doc/Русский/Инсталляция" target="_blank">WackoWiki:Doc/Русский/Инсталляция</a>.',
'WrittenAt'						=> 'сохранён ',
'DontChange'					=> 'не меняйте wacko_version вручную!',
'ConfigDescription'				=> 'подробное описание https://wackowiki.org/doc/Doc/Русский/ФайлКонфигурации',
'TryAgain'						=> 'Попытаться снова',

];