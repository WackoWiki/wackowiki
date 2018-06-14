<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'windows-1251',
'LangISO' => 'ru',
'LangName' => 'Русский',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// site name
	'site_name'			=> 'MyWikiSite',

	// pages
	'category_page'		=> 'Категории',
	'groups_page'		=> 'Группы',
	'users_page'		=> 'Пользователи',

	'help_page'			=> 'Помощь',
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
'Title' => 'Установка WackoWiki',
'Continue' => 'Продолжить',
'Back' => 'Назад',
'Recommended' => 'рекомендуемый',
'InvalidAction' => 'Недопустимое действие',

/*
   Language Selection Page
*/
'lang' => 'Выбор языка',
'PleaseUpgradeToR5' => 'Вы используете доисторическую (до 5.0.0) версию WackoWiki. Для обновления до текущей версии сперва необходим отдельный апгрейд до <code class="version">5.0.x</code>.',
'UpgradeFromWacko' => 'Добро пожаловать в WackoWiki! Сейчас начнётся обновление WackoWiki с <code class="version">%1</code> до <code class="version">%2</code>.  Процесс обновления займёт несколько следующих страниц.',
'FreshInstall' => 'Добро пожаловать в WackoWiki! Всё готово для установки WackoWiki <code class="version">%1</code>.  Процесс установки займёт несколько следующих страниц.',
'PleaseBackup' => 'Сделайте резервную копию базы данных, конфигурационного файла и других изменённых вами файлов (например, файлов темы) до начала процесса установки. Это может спасти Вас от очень неприятных моментов.',
'LangDesc' => 'Пожалуйста, выберите язык. Он будет использоваться в процессе установки, а также станет языком по умолчанию установленной WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'Системные требования',
'PHPVersion' => 'Версия PHP',
'PHPDetected' => 'Обнаружен PHP',
'ModRewrite' => 'Расширение Apache Rewrite (необязательно)',
'ModRewriteInstalled' => 'Модуль перезаписи (mod_rewrite) установлен?',
'Database' => 'База данных',
'PHPExtensions' => 'PHP Расширения',
'Permissions' => 'Права доступа',
'ReadyToInstall' => 'Готовы к установке?',
'Requirements' => 'Ваш сервер должен соответствовать требованиям, перечисленным ниже.',
'OK' => 'OK',
'Problem' => 'Проблема',
'NotePHPExtensions' => '',
'ErrorPHPExtensions' => 'Ваша инсталляция PHP не поддерживает PHP Расширения необходимые для работы WackoWiki.',
'NotePermissions' => 'Программа установки попытается записать настройки в файл %1, расположенный в каталоге WackoWiki. Чтобы всё прошло успешно, убедитесь, что веб-сервер имеет право на запись в данный файл. Если это невозможно, вам придётся изменить файл вручную (программа установки объяснит, как).<br><br>См. <a href="https://wackowiki.org/doc/Doc/Russian/Installjacija" target="_blank">WackoWiki:Doc/Russian/Инсталляция</a>.',
'ErrorPermissions' => 'Она может возникнуть, когда программа установки не может автоматически задать права, требуемые для корректной работы WackoWiki. Позже во время установки вам будет предложено настроить вручную требуемые права доступа к файлам на сервере.',
'ErrorMinPHPVersion' => 'Версия PHP должна быть больше <strong>' . PHP_MIN_VERSION . '</strong>, а сервер использует одну из предыдущих версий.  Для корректной работы WackoWiki нужно обновить PHP на одну из последних версий.',
'Ready' => 'Поздравляем, ваш сервер готов для запуска WackoWiki. Процесс её настройки займёт несколько следующих страниц.',

/*
   Site Config Page
*/
'site-config' => 'Настройки сайта',
'SiteName' => 'Название WackoWiki',
'SiteNameDesc' => 'Пожалуйста, введите имя вашего сайта Wiki.',
'HomePage' => 'Главная страница',
'HomePageDesc' => 'Введите имя домашней страницы&nbsp;&mdash; это будет страница по умолчанию, пользователи увидят её первой при посещении сайта; имя должно <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">ВикиИменем</a>.',
'HomePageDefault' => 'Главная',
'MultiLang' => 'Режим многоязычности',
'MultiLangDesc' => 'Режим многоязычности позволяет держать страницы на разных языках в одной вики. Если режим включён, программа установки создаст начальные страницы для всех языков, включённых в дистрибутив.',
'AllowedLang' => 'Разрешенные языки',
'AllowedLangDesc' => 'Рекомендуется выбрать набор языков, который вы намерены использовать, иначе будут выбраны все.',
'Admin' => 'Имя администратора',
'AdminDesc' => 'Введите имя администратора, оно должно быть <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">ВикиИменем</a> (без русских букв) (например, WikiAdmin).',
'Password' => 'Пароль администратора',
'PasswordDesc' => 'Введите пароль (не менее %1 символов).',
'Password2' => 'Подтверждение пароля:',
'Mail' => 'Адрес электронной почты администратора',
'MailDesc' => 'Введите адрес электронной почты администратора.',
'Base' => 'Базовый URL',
'BaseDesc' => 'Базовый URL сайта WackoWiki. К нему будут добавляться имена страниц; если используется mod_rewrite, адрес должен оканчиваться прямой косой чертой, т.&nbsp;е.</p><ul><li><strong><em>http://example.com/</em></strong></li><li><strong><em>http://example.com/wiki/</em></strong></li></ul>',
'Rewrite' => 'Rewrite-режим',
'RewriteDesc' => 'Rewrite-режим должен быть включён, если вы используете mod_rewrite.',
'Enabled' => 'Включён:',
'ErrorAdminEmail' => 'Введите правильный адрес электронной почты!',
'ErrorAdminPasswordMismatch' => 'Пароли не совпадают. Пожалуйста, повторите ввод пароля администратора',
'ErrorAdminPasswordShort' => 'Пароль администратора слишком короткий, минимальная длина - 9 символов!',
'WarningRewriteMode' => 'ВНИМАНИЕ!\nНастройки базового URL и Rewrite-режима выглядят подозрительно. Обычно при включённом Rewrite не бывает знака ? в базовом URL, но у вас он есть.\n\nДля продолжения установки с текущими параметрами нажмите ОК.\nДля того, чтобы вернуться в форму и всё исправить, нажмите ОТМЕНА.\n\nЕсли вы решили идти дальше, помните, что такое сочетание часто является причиной неработоспособности после установки.',
'ModRewriteStatusUnknown' => 'Программа установки не может проверить, включён ли mod_rewrite, но это не означает, что он отключён',

'LanguageArray'	=> [
	'bg' => 'болгарский',
	'da' => 'датский',
	'nl' => 'нидерландский',
	'el' => 'греческий',
	'en' => 'английский',
	'et' => 'эстонский',
	'fr' => 'французский',
	'de' => 'немецкий',
	'hu' => 'венгерский',
	'it' => 'итальянский',
	'pl' => 'польский',
	'pt' => 'португальский',
	'ru' => 'русский',
	'es' => 'испанский',
],

/*
   Database Config Page
*/
'database-config' => 'Настройки базы данных',
'DBDriver' => 'Драйвер',
'DBDriverDesc' => 'Драйвер базы данных, который вы хотите использовать. Нужно выбрать legacy-драйвер, если не используется установленным <a href="http://de2.php.net/pdo" target="_blank">PDO</a>.',
'DBCharset' => 'Кодировка',
'DBCharsetDesc' => 'Кодировка записей базы данных.',
'DBEngine' => 'Движок базы данных',
'DBEngineDesc' => 'Движок базы данных который будет использован. Вы должны выбрать движок MyISAM Если не имеется минимум MariaDB 10 или MySql 5.6 (или выше) с поддержкой InnoDB.',
'DBHost' => 'Имя сервера',
'DBHostDesc' => 'Имя сервера, на котором запущена БД. Обычно "127.0.0.1" или "localhost" (т. е. та машина, на которую устанавливается WackoWiki).',
'DBPort' => 'Порт (необязательно)',
'DBPortDesc' => 'Номер порта, по которому доступен сервер БД, для использования порта по умолчанию оставьте пустым.',
'DB' => 'Имя базы данных',
'DBDesc' => 'База данных, которую будет использовать WackoWiki. Она должна существовать, чтобы установка продолжилась!',
'DBUserDesc' => 'Имя пользователя для подключения к базе данных.',
'DBUser' => 'Имя пользователя базы данных',
'DBPasswordDesc' => 'Пароль пользователя для подключения к базе данных.',
'DBPassword' => 'Пароль',
'PrefixDesc' => 'Префикс всех таблиц, используемых WackoWiki. Это позволит запускать несколько WackoWiki, используя одну БД&nbsp;&mdash; достаточно указать для них разные префиксы таблиц (например, wacko_).',
'Prefix' => 'Префикс таблиц',
'ErrorNoDbDriverDetected' => 'Драйвера баз данных не обнаружены. Пожалуйста, включите использование расширений mysql, mysqli или pdo в файле php.ini.',
'ErrorNoDbDriverSelected' => 'Не выбран драйвер базы данных, выберите один из списка.',
'DeleteTables' => 'Удалить существующие таблицы?',
'DeleteTablesDesc' => 'ВНИМАНИЕ! Включение этого режима приведёт к удалению всех существующих данных из базы вики. Отменить это действие не удастся, данные могут быть восстановлены только вручную из резервной копии.',
'ConfirmTableDeletion' => 'Вы уверены, что хотите удалить все существующие таблицы вики?',

/*
   Database Installation Page
*/
'database-install' => 'Установка базы данных',
'TestingConfiguration' => 'Тестирование настроек',
'TestConnectionString' => 'Проверка параметров соединения с БД',
'TestDatabaseExists' => 'Проверка существования указанной БД',
'InstallingTables' => 'Установка таблиц',
'ErrorDBConnection' => 'Произошла ошибка при подключении к БД с указанными параметрами. Пожалуйста, вернитесь и проверьте их правильность.',
'ErrorDBExists' => 'Указанная БД не обнаружена. Пожалуйста, удостоверьтесь, что такая БД существует!',
'To' => '->',
'AlterTable' => 'Изменение структуры таблицы <code>%1</code>',
'RenameTable' => 'Переименование таблицы <code>%1</code>',
'UpdateTable' => 'Обновление таблицы <code>%1</code>',
'InstallingDefaultData' => 'Добавление данных по умолчанию',
'InstallingPagesBegin' => 'Добавление страниц по умолчанию',
'InstallingPagesEnd' => 'Добавление страниц по умолчанию завершено',
'InstallingSystemAccount' => 'Добавление супер-пользователя System',
'InstallingAdmin' => 'Добавление пользователя-администратора',
'InstallingAdminSetting' => 'Добавление пользователя-администратора',
'InstallingAdminGroup' => 'Добавление группы Admins',
'InstallingAdminGroupMember' => 'Добавление участников в группу Admins',
'InstallingEverybodyGroup' => 'Добавление группы Everybody',
'InstallingModeratorGroup' => 'Добавление группы Moderator',
'InstallingReviewerGroup' => 'Добавление группы Reviewer',
'InstallingLogoImage' => 'Добавление картинки логотипа',
'InstallingConfigValues' => 'Добавление параметров конфигурации',
'ErrorInsertingPage' => 'Ошибка вставки страницы <code>%1</code>',
'ErrorInsertingPageReadPermission' => 'Ошибка установки прав на чтение страницы <code>%1</code>',
'ErrorInsertingPageWritePermission' => 'Ошибка установки прав на запись страницы <code>%1</code>',
'ErrorInsertingPageCommentPermission' => 'Ошибка установки прав на комментирование страницы <code>%1</code>',
'ErrorInsertingPageCreatePermission' => 'Ошибка установки прав на создание страницы<code>%1</code>',
'ErrorInsertingPageUploadPermission' => 'Ошибка установки прав на загрузку файлов на страницы <code>%1</code>',
'ErrorInsertingDefaultMenuItem' => 'Ошибка установки страницы <code>%1</code>как пункта меню по умолчанию',
'ErrorPageAlreadyExists' => 'Страница <code>%1</code> уже существует',
'ErrorAlteringTable' => 'Ошибка изменения структуры таблицы <code>%1</code>',
'ErrorRenamingTable' => 'Ошибка переименования таблицы <code>%1</code>',
'ErrorUpdatingTable' => 'Ошибка обновления таблицы <code>%1</code>',
'CreatingTable' => 'Создание таблицы <code>%1</code>',
'ErrorAlreadyExists' => '<code>%1</code> уже существует',
'ErrorCreatingTable' => 'Ошибка создания таблицы <code>%1</code>, она уже существует?',
'ErrorMovingRevisions' => 'Ошибка перемещения данных версий',
'MovingRevisions' => 'Перемещение все старых версий в таблицу revisions',
'DeletingTables' => 'Удаление таблиц',
'DeletingTablesEnd' => 'Удаление таблиц завершено',
'ErrorDeletingTable' => 'Ошибка удаления таблицы <code>%1</code>, вероятная причина&nbsp;&mdash; отсутствие таблицы в базе, в этом случае предупреждение можно проигнорировать.',
'DeletingTable' => 'Удаление таблицы <code>%1</code>',

/*
   Write Config Page
*/
'write-config' => 'Сохранение конфигурационного файла',
'FinalStep' => 'Последний шаг',
'Writing' => 'Сохранение конфигурационного файла',
'RemovingWritePrivilege' => 'Удаление привилегий на запись',
'InstallationComplete' => 'Установка завершена',
'ThatsAll' => 'Ура! Всё прошло успешно. Теперь вы можете <a href="%1">посмотреть свой сайт WackoWiki</a>.',
'SecurityConsiderations' => 'Соображения безопасности',
'SecurityRisk' => 'Не забудьте убрать права на изменение файла %1 веб-сервером. Если этого не сделать, вас смогут взломать!',
'RemoveSetupDirectory' => 'Сейчас вы должны удалить каталог <code>setup/</code>&nbsp;&mdash; процесс установки завершён.',
'ErrorGivePrivileges' => 'Конфигурационный файл %1 не может быть сохранён. Нужно временно дать веб-серверу права на запись либо на каталог WackoWiki, либо на пустой файл %1<br>%2<br>; не забудьте убрать эти права после установки, т.&nbsp;e. %3.<br>Если, почему-либо вы не можете выставить такие права, придётся скопировать текст, расположенный ниже в новый файл и загрузить его на сервер под именем %1 в каталог WackoWiki. После этого ваш сайт должен заработать. Если нет, смотрите <a href="https://wackowiki.org/doc/Doc/Russian/Installjacija">WackoWiki:Doc/Russian/Инсталляция</a>',
'NextStep' => 'На следующем шаге программа установки попробует сохранить обновлённый конфигурационный файл, %1. Пожалуйста, проверьте, что веб-сервер имеет достаточно прав для изменения файла; в противном случае вам придётся сохранить изменения вручную. Не побоимся повториться, см. <a href="https://wackowiki.org/doc/Doc/Russian/Installjacija" target="_blank">WackoWiki:Doc/Russian/Инсталляция</a>.',
'WrittenAt' => 'сохранён ',
'DontChange' => 'не меняйте wacko_version вручную!',
'ConfigDescription' => 'подробное описание https://wackowiki.org/doc/Doc/Russian/FajjlKonfiguracii',
'TryAgain' => 'Попытаться снова',

];
?>
