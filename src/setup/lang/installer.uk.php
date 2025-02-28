<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'uk',
'LangLocale'	=> 'uk_UA',
'LangName'		=> 'Ukrainian',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Категорія',
	'groups_page'		=> 'Групи',
	'users_page'		=> 'Спільноти',

	'search_page'		=> 'Пошук',
	'login_page'		=> 'Логін',
	'account_page'		=> 'Налаштування',
	'registration_page'	=> 'Реєстрація',
	'password_page'		=> 'Пароль',

	'changes_page'		=> 'Останні зміни',
	'comments_page'		=> 'Нещодавно коментовані',
	'index_page'		=> 'PageIndex',

	'random_page'		=> 'Рандомпаж',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',

	// time
	#'date_format'					=> 'dd.MM.yyyy',
	#'time_format'					=> 'HH:mm',
	#'time_format_seconds'			=> 'HH:mm:ss',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'Встановлення WackoWiki',
'TitleUpdate'					=> 'Оновлення WackoWiki',
'Continue'						=> 'Продовжити',
'Back'							=> 'Back',
'Recommended'					=> 'рекомендовано',
'InvalidAction'					=> 'Неправильна дія',

/*
   Language Selection Page
*/
'lang'							=> 'Мова конфігурації',
'PleaseUpgradeToR6'				=> 'Схоже, ви використовуєте старий (pre %2) реліз WackoWiki (%1). Щоб оновити цю версію WackoWiki, вам необхідно спочатку оновити інсталяцію на %2.',
'UpgradeFromWacko'				=> 'Ласкаво просимо до WackoWiki! Схоже, що ви оновлюєтесь з WackoWiki %1 до %2. Наступні кілька сторінок будуть проходити через процес оновлення.',
'FreshInstall'					=> 'Ласкаво просимо до WackoWiki! Ви збираєтеся встановити WackoWiki %1. Наступні сторінки будуть направлені вам через процес встановлення.',
'PleaseBackup'					=> 'Будь ласка, <strong>зробіть резервну копію</strong>
 вашої бази даних, конфігураційного файлу та всіх змінених файлів, наприклад, тих, до яких 
до яких застосовано локальні хаки та патчі, перед початком процесу оновлення 
перед початком процесу оновлення. Це може вберегти вас від великого головного болю.',
'LangDesc'						=> 'Будь ласка, виберіть мову для установки процесу. Ця мова також буде використовуватися як мова за замовчуванням для вашої установки WackoWiki інсталяції.',

/*
   System Requirements Page
*/
'version-check'					=> 'Системні вимоги',
'PhpVersion'					=> 'Версія PHP',
'PhpDetected'					=> 'Виявлений PHP',
'ModRewrite'					=> 'Розширення Apache Rewrite (необов\'язково)',
'ModRewriteInstalled'			=> 'Встановлено розширення (mod_rewrite)?',
'Database'						=> 'База даних',
'PhpExtensions'					=> 'Розширення PHP',
'Permissions'					=> 'Дозволи',
'ReadyToInstall'				=> 'Готові до встановлення?',
'Requirements'					=> 'Ваш сервер повинен відповідати вимогам, вказаним нижче.',
'OK'							=> 'Гаразд',
'Problem'						=> 'Проблема',
'Example'						=> 'Приклад',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'У вашій PHP установці відсутні показані PHP-розширення, які потрібні WackoWiki.',
'PcreWithoutUtf8'				=> 'PCRE не скомпільовано за допомогою підтримки UTF-8.',
'NotePermissions'				=> 'Цей інсталятор спробує записати дані конфігурації у файл %1, розміщені у вашій теці WackoWiki Для того, щоб це працювало, ви повинні переконатися, що веб-сервер має доступ на запис до цього файлу. Якщо Ви не можете цього зробити, Вам доведеться відредагувати файл вручну (програма установки покаже Вам).<br><br>Дивіться <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/install</a> для деталей.',
'ErrorPermissions'				=> 'Здається, що інсталятор не може автоматично встановити необхідні дозволи для WackoWiki працювати правильно. Вам буде запропоновано пізніше в процесі встановлення, щоб вручну налаштувати необхідні дозволи на ваш сервер.',
'ErrorMinPhpVersion'			=> 'Версія PHP повинна бути більшою за %1. Схоже, що Ваш сервер працює більш ранньою версією. Для коректної роботи необхідно оновити PHP до новішої версії WackoWiki',
'Ready'							=> 'Вітаємо, схоже, що ваш сервер здатний запустити WackoWiki. Наступні сторінки проведуть вас у процесі конфігурації.',

/*
   Site Config Page
*/
'config-site'					=> 'Конфігурація сайту',
'SiteName'						=> 'Назва Вікі',
'SiteNameDesc'					=> 'Будь ласка, введіть ім\'я вашого вікі-сайту.',
'SiteNameDefault'				=> 'MyWikiSite',
'HomePage'						=> 'Домашня сторінка',
'HomePageDesc'					=> 'Введіть ім\'я, яке б ви хотіли мати домашню сторінку. Це будуть користувачі сторінок за промовчанням при відвідуванні вашого сайту і повинні бути <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Домашня сторінка',
'MultiLang'						=> 'Багатомовний режим',
'MultiLangDesc'					=> 'Багатомовний режим дозволяє мати сторінки з різними налаштуваннями мови в межах одного встановлення. Коли цей режим увімкнено, інсталятор створює елементи початкового меню для всіх мов, доступних у дистрибутиві.',
'AllowedLang'					=> 'Дозволені мови',
'AllowedLangDesc'				=> 'Рекомендується обрати тільки набір мов, якими ви хочете користуватися, в іншому випадку обрані всі мови.',
'Admin'							=> 'Ім&#039;я адміністратора',
'AdminDesc'						=> 'Введіть ім\'я користувача адміністратора. Це має бути <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (наприклад, <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Ім’я користувача має містити від %1 до %2 символів і використовувати лише буквено-цифрові символи. Великі символи допустимі.',
'NameCamelCaseOnly'				=> 'Ім\'я користувача повинно бути між символами %1 та %2 довгою та графіком WikiName формату.',
'Password'						=> 'Пароль адміністратора',
'PasswordDesc'					=> 'Виберіть пароль для адміністратора з мінімальним кількістю %1 символів.',
'PasswordConfirm'				=> 'Повтор Паролю:',
'Mail'							=> 'Ел. пошта адміністратора',
'MailDesc'						=> 'Введіть адресу електронної пошти адміністратора.',
'Base'							=> 'Базова URL-адреса',
'BaseDesc'						=> 'Ваша URL-адреса базового сайту WackoWiki Імена сторінок додаються до неї, тому якщо ви використовуєте mod_rewrite адресу повинен закінчуватися вперед косою риском, тобто якщо ви використовуєте mod_rewrite.',
'Rewrite'						=> 'Режим перезапису',
'RewriteDesc'					=> 'Режим перезапису повинен бути ввімкнений, якщо ви використовуєте WackoWiki з перезаписом URL на сторінках сайту.',
'Enabled'						=> 'Увімкнено:',
'ErrorAdminEmail'				=> 'Ви ввели недійсну електронну адресу!',
'ErrorAdminPasswordMismatch'	=> 'Ці паролі не співпадають!.',
'ErrorAdminPasswordShort'		=> 'Пароль адміністратора занадто короткий! Мінімальна довжина - %1 символів.',
'ModRewriteStatusUnknown'		=> 'Інсталятор не може перевірити, що mod_rewrite увімкнений. Це, однак, не означає, що його вимкнено.',

/*
   Database Config Page
*/
'config-database'				=> 'Налаштування бази даних',
'DbDriver'						=> 'Драйвер',
'DbDriverDesc'					=> 'Драйвер баз даних, який ви хочете використовувати.',
'DbSqlMode'						=> 'Режим SQL',
'DbSqlModeDesc'					=> 'Режим SQL, який ви хочете використовувати.',
'DbVendor'						=> 'Постачальник',
'DbVendorDesc'					=> 'Виробник бази даних, який ви використовуєте.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'Кодування бази даних, яке ви хочете використовувати.',
'DbEngine'						=> 'Двигун',
'DbEngineDesc'					=> 'Движок бази даних, який ви хочете використовувати.',
'DbHost'						=> 'Хост',
'DbHostDesc'					=> 'Сервер працює на сервері бази даних, зазвичай <code>127.0.0.1</code> або <code>localhost</code> (тобто та ж машина, на якій працює ваш сайт WackoWiki готово).',
'DbPort'						=> 'Порт (необов\'язково)',
'DbPortDesc'					=> 'Номер порту доступний до сервера бази даних. Залиште поле порожнім, щоб використовувати номер порту за замовчуванням.',
'DbName'						=> 'Ім\'я бази даних',
'DbNameDesc'					=> 'База даних WackoWiki повинна використовувати цю базу даних. Вона потребує наявності перед тим як продовжити!',
'DbUser'						=> 'Ім\'я користувача',
'DbUserDesc'					=> 'Ім\'я користувача, що використовується для підключення до вашої бази даних.',
'DbPassword'					=> 'Пароль',
'DbPasswordDesc'				=> 'Пароль користувача, що використовується для підключення до бази даних.',
'Prefix'						=> 'Префікс таблиці',
'PrefixDesc'					=> 'Префікс всіх таблиць, що використовуються WackoWiki. Це дозволяє запустити кілька налаштувань WackoWiki з тією ж базою даних, настроюючи їх для використання різних префіксів таблиці (наприклад, wacko_).',
'ErrorNoDbDriverDetected'		=> 'Драйвер бази даних не виявлено, будь ласка, увімкніть або mysqli, або розширення pdo_mysql у файлі php.ini.',
'ErrorNoDbDriverSelected'		=> 'Не було обрано драйвера бази даних, будь ласка, виберіть його зі списку.',
'DeleteTables'					=> 'Видалити існуючі таблиці?',
'DeleteTablesDesc'				=> 'УВАГА! Якщо ви продовжите цю опцію, всі поточні вікі-дані будуть стерті з вашої бази даних. Це не можна зробити, і вам знадобиться вручну відновити дані з резервної копії.',
'ConfirmTableDeletion'			=> 'Ви впевнені, що хочете видалити всі поточні таблиці вікі?',

/*
   Database Installation Page
*/
'install-database'				=> 'Встановлення бази даних',
'TestingConfiguration'			=> 'Конфігурація тестування',
'TestConnectionString'			=> 'Тестування параметрів підключення до бази даних',
'TestDatabaseExists'			=> 'Перевірка, чи існує база даних, яку ви вказали',
'TestDatabaseVersion'			=> 'Перевірка вимог до мінімальної версії бази даних',
'InstallTables'					=> 'Встановлення таблиць',
'ErrorDbConnection'				=> 'Виникла проблема з деталями підключення бази даних, будь ласка, поверніться назад і перевірте, що вони правильні.',
'ErrorDatabaseVersion'			=> 'Версія бази даних %1, але потребує мінімум %2.',
'To'							=> 'по',
'AlterTable'					=> 'Зміна таблиці %1',
'InsertRecord'					=> 'Додавання запису в таблицю %1',
'RenameTable'					=> 'Перейменування таблиці %1',
'UpdateTable'					=> 'Оновлення таблиці %1',
'InstallDefaultData'			=> 'Додавання стандартних даних',
'InstallPagesBegin'				=> 'Додавання сторінок за замовчуванням',
'InstallPagesEnd'				=> 'Завершене додавання типових сторінок',
'InstallSystemAccount'			=> 'Adding <code>System</code> User',
'InstallDeletedAccount'			=> 'Adding <code>Deleted</code> User',
'InstallAdmin'					=> 'Додавання користувача з правами адміністратора',
'InstallAdminSetting'			=> 'Налаштування користувача додавання адміна',
'InstallAdminGroup'				=> 'Додавання групи адмінів',
'InstallAdminGroupMember'		=> 'Додавання учасника групи адмінів',
'InstallEverybodyGroup'			=> 'Додавання групи всіх',
'InstallModeratorGroup'			=> 'Додавання модератора',
'InstallReviewerGroup'			=> 'Додавання групи рецензентів',
'InstallLogoImage'				=> 'Додавання зображення логотипу',
'LogoImage'						=> 'Зображення логотипу',
'InstallConfigValues'			=> 'Додавання значень конфігурації',
'ConfigValues'					=> 'Значення конфігурації',
'ErrorInsertPage'				=> 'Помилка додавання сторінки %1',
'ErrorInsertPagePermission'		=> 'Error setting permission for %1 page',
'ErrorInsertDefaultMenuItem'	=> 'Помилка при налаштуванні сторінки %1 як елемент меню за замовчуванням',
'ErrorPageAlreadyExists'		=> 'Сторінка %1 вже існує',
'ErrorAlterTable'				=> 'Error altering %1 table',
'ErrorInsertRecord'				=> 'Помилка введення запису в таблицю %1',
'ErrorRenameTable'				=> 'Error renaming %1 table',
'ErrorUpdatingTable'			=> 'Помилка оновлення таблиці %1',
'CreatingTable'					=> 'Створення таблиці %1',
'ErrorAlreadyExists'			=> 'The %1 already exists',
'ErrorCreatingTable'			=> 'Помилка створення таблиць %1 , чи вона вже існує?',
'DeletingTables'				=> 'Видалення таблиць',
'DeletingTablesEnd'				=> 'Видалення таблиць завершено',
'ErrorDeletingTable'			=> 'Помилка видалення таблиці %1 . Найвірогідніша причина полягає в тому, що таблиці не існує, і в такому випадку ви можете проігнорувати це попередження.',
'DeletingTable'					=> 'Видалення таблиці %1',
'NextStep'						=> 'У наступному кроці інсталятор спробує записати оновлений файл конфігурації, %1. Переконайтеся, що веб-сервер має доступ на запис до файлу, або ви повинні відредагувати його вручну. Знову ж таки, перегляньте  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Встановлення</a> для деталей.',

/*
   Write Config Page
*/
'write-config'					=> 'Запис файлу конфігурації',
'FinalStep'						=> 'Фінальний крок',
'Writing'						=> 'Створення файлу конфігурації',
'RemovingWritePrivilege'		=> 'Видалення привілеїв',
'InstallationComplete'			=> 'Встановлення завершено',
'ThatsAll'						=> 'That\'s all! You can now <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations'		=> 'Застереження щодо безпеки',
'SecurityRisk'					=> 'Рекомендується скасувати доступ для запису до %1 після його запису. Залишення файлу доступним для запису може бути ризиком для безпеки!<br>тобто. %2',
'RemoveSetupDirectory'			=> 'Ви повинні видалити теку %1 зараз, щоб інсталяцію було завершено.',
'ErrorGivePrivileges'			=> 'The configuration file %1 could not be written. You will need to give your web server temporary write access to either your WackoWiki directory, or a blank file called %1<br>%2.<br><br> Don\'t forget to remove write access again later, i.e., <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Якщо, з будь-якої причини, ви не можете зробити це, Вам потрібно буде скопіювати текст нижче у новий файл і зберегти/завантажити його як %1 в WackoWiki теку. Як тільки ви зробите це, ваш сайт WackoWiki повинен працювати. Якщо ні, будь ласка, відвідайте <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Як тільки ви зробите це, ваш сайт WackoWiki повинен працювати. Якщо ні, будь ласка, відвідайте <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'записано в ',
'DontChange'					=> 'не змінювати wacko_version вручну!',
'ConfigDescription'				=> 'детальний опис: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Спробуйте ще раз',

];
