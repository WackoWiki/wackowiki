<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'					=> 'Внимание: перед проведением технических и/или административных мероприятий <strong>настоятельно</strong> рекомендуется закрыть доступ к сайту!',

	'CategoryArray'		=> [
		'basics'		=> 'Базовые функции',
		'preferences'	=> 'Настройки',
		'content'		=> 'Контент',
		'users'			=> 'Пользователей',
		'maintenance'	=> 'Обслуживание',
		'messages'		=> 'Сообщения',
		'extension'		=> 'Расширения',
		'database'		=> 'База данных',
	],

	// Admin panel
	'AdminPanel'				=> 'Администраторский раздел',
	'RecoveryMode'				=> 'Режим восстановления',
	'Authorization'				=> 'Авторизация',
	'AuthorizationTip'			=> 'Пожалуйста, укажите административный пароль (убедитесь также, что cookies в вашем браузере разрешены).',
	'NoRecoceryPassword'		=> 'Административный пароль не задан!',
	'NoRecoceryPasswordTip'		=> 'Внимание: отсутствие административного пароля представляет угрозу для безопасности! Укажите пароль в файле настроек и запустите программу повторно.',

	'ErrorLoadingModule'		=> 'Ошибка загрузки административного модуля %1: модуль не существует.',

	'FormSave'					=> 'сохранить',
	'FormReset'					=> 'сбросить',
	'FormUpdate'				=> 'обновить',

	'ApHomePage'				=> 'главная страница сайта',
	'ApHomePageTip'				=> 'открыть главную страницу сайта, не завершая сеанс администрирования',
	'ApLogOut'					=> 'выход',
	'ApLogOutTip'				=> 'завершить администрирование системы',

	'TimeLeft'					=> 'Осталось времени:  %1 минут',
	'ApVersion'					=> 'версия',

	'SiteOpen'					=> 'открыть',
	'SiteOpened'				=> 'сайт открыт',
	'SiteOpenedTip'				=> 'Сайт открыт',
	'SiteClose'					=> 'закрыть',
	'SiteClosed'				=> 'сайт закрыт',
	'SiteClosedTip'				=> 'Сайт закрыт',

	// Generic
	'Cancel'					=> 'Отмена',
	'Add'						=> 'Добавить',
	'Edit'						=> 'Редактировать',
	'Remove'					=> 'Удалить',
	'Enabled'					=> 'Включено',
	'Disabled'					=> 'Выключено',
	'On'						=> 'Вкл.',
	'Off'						=> 'Выкл.',
	'Mandatory'					=> 'Обязательное',
	'Admin'						=> 'Администратор',

	// MENU
	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Базовые',
		'title'		=> 'Основные параметры',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Внешний вид',
		'title'		=> 'Параметры внешнего вида',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Email',
		'title'		=> 'Настройки Email',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Фильтр',
		'title'		=> 'Настройки фильтра',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Форматтер',
		'title'		=> 'Настройки форматирования',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Уведомления',
		'title'		=> 'Настройки уведомлений',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Страницы',
		'title'		=> 'Адреса и параметры служебных страниц',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Разрешения',
		'title'		=> 'Настройки разрешений',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Безопасность',
		'title'		=> 'Настройка подсистем безопасности',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Служебные',
		'title'		=> 'Служебные параметры',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Загрузка',
		'title'		=> 'Настройки загруженных файлов',
	],

	// Categories module
	'content_categories'		=> [
		'name'		=> 'Категории',
		'title'		=> 'Управление категориями',
	],

	// Comments module
	'content_comments'		=> [
		'name'		=> 'Комментарии',
		'title'		=> 'Управление комментариям',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Удаленные документы',
		'title'		=> 'Управление копиями недавно удаленных документов',
	],

	// Files module
	'content_files'		=> [
		'name'		=> 'Глобальные файлы',
		'title'		=> 'Управление глобальными файлами',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Меню',
		'title'		=> 'Добавление, редактирование или удаление пунктов стандартного меню',
	],

	// Pages module
	'content_pages'		=> [
		'name'		=> 'Страницы',
		'title'		=> 'Управление страницами',
	],

	// Polls module
	'content_polls'		=> [
		'name'		=> 'Управление опросами',
		'title'		=> 'Редактирование, запуск и остановка опросов',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Резервное копирование',
		'title'		=> 'Резервное копирование данных',
	],

	// DB Convert module
	'db_convert'		=> [
		'name'		=> 'Преобразование',
		'title'		=> 'Преобразование таблиц или столбцов',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Восстановление таблиц',
		'title'		=> 'Восстановление и оптимизация базы данных ',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Восстановление базы',
		'title'		=> 'Восстановление резервной копии данных',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Главное меню',
		'title'		=> 'Управление WackoWiki',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Несоответствия',
		'title'		=> 'Исправление нарушений целостности данных',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Синхронизация данных',
		'title'		=> 'Синхронизация базы данных',
	],

	// Transliterate module
	'maint_transliterate'		=> [
		'name'		=> 'Транслитерация',
		'title'		=> 'Обновление столбца supertag в записях базы данных',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Массовая рассылка',
		'title'		=> 'Массовая рассылка Email',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Системные сообщения',
		'title'		=> 'Системные сообщения',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Сведения о системе',
		'title'		=> 'Сведения о системе',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Системный журнал',
		'title'		=> 'Журнал системных событий',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Статистика',
		'title'		=> 'Статистика системы',
	],

	// Bad Behavior module
	'badbehavior'		=> [
		'name'		=> 'Плохое поведение',
		'title'		=> 'Подозрительная активность',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Подтверждение регистраций',
		'title'		=> 'Подтверждение регистраций пользователей',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Группы',
		'title'		=> 'Управление группами',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Пользователи',
		'title'		=> 'Управление пользователями',
	],

	'LogFilterTip'				=> 'Отфильтровать события по критериям',
	'LogLevel'					=> 'Уровень',
	'LogLevelNotLower'			=> 'не ниже, чем',
	'LogLevelNotHigher'			=> 'не выше, чем',
	'LogLevelEqual'				=> 'соответствует',
	'LogNoMatch'				=> 'Нет событий, удовлетворяющих критериям',
	'LogDate'					=> 'Дата',
	'LogEvent'					=> 'Событие',
	'LogUsername'				=> 'Пользователь',

	'PurgeSessions'				=> 'удалить',
	'PurgeSessionsTip'			=> 'Удалить все сессии',
	'PurgeSessionsConfirm'		=> 'Уверены в удалении сессий? Это прекратит сессии всех текущих пользователей.',
	'PurgeSessionsExplain'		=> 'Удалить все сессии. Это прекратит сессии всех текущих пользователей с очисткой таблицы auth_token.',
	'PurgeSessionsDone'			=> 'Сессии удалены.',

	// Basic settings


	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Управление стандартными настройками отображения сайта.',
	'LogoOff'					=> 'выкл.',
	'LogoOnly'					=> 'логотип',
	'LogoAndTitle'				=> 'логотип и заголовок',

	'AppearanceSettingsUpdated'	=> 'Updated appearance settings.',
	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Site Logo',
	'SiteLogoInfo'				=> 'Your logo will appear typically at the top left corner of the application. Max size is 2 MiB. Optimal dimensions are 255 pixels wide by 55 pixels high.',
	'LogoDimensions'			=> 'Logo dimensions',
	'LogoDimensionsInfo'		=> 'Width and height of the displayed Logo.',
	'LogoDisplayMode'			=> 'Logo display mode',
	'LogoDisplayModeInfo'		=> 'Defines the apearence of the Logo. Default is off.',
	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site Favicon',
	'SiteFaviconInfo'			=> 'Your shortcut icon, or favicon, is displayed in the address bar, tabs and bookmarks of most browsers. This will override the favicon of your theme.',
	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Theme',
	'ThemeInfo'					=> 'Template design the site uses by default.',
	'ThemesAllowed'				=> 'Allowed Themes',
	'ThemesAllowedInfo'			=> 'Select the allowed themes, which the user can choose, otherwise all available themes are allowed.',
	'ThemesPerPage'				=> 'Themes per page',
	'ThemesPerPageInfo'			=> 'Allow themes per page, which the page owner can choose via page properties.',


	// Resync settings
	'UserStatsSynched'			=> 'Статистика пользователей синхронизирована.',
	'PageStatsSynched'			=> 'Page Statistics синхронизирована.',
	'FeedsUpdated'				=> 'RSS-каналы обновлены.',
	'SiteMapCreated'			=> 'The new version of the site map created successfully.',
	'WikiLinksRestored'			=> 'Wiki-ссылки восстановлены.',

	'UserStats'					=> 'Пользовательская статистика',
	'UserStatsInfo'				=> 'Статистика пользователей (количество комментариев, страниц во владении, revisions и files) в некоторых ситуациях может расходиться с реальными данными. <br>Эта операция позволяет пересчетать статистику по текущим фактическим данным БД.',
	'PageStats'					=> 'Page статистика',
	'PageStatsInfo'				=> 'Page статистика (количество комментариев, files и revisions) в некоторых ситуациях может расходиться с реальными данными. <br>Эта операция позволяет пересчетать статистику по текущим фактическим данным БД.',
	'Feeds'						=> 'RSS-каналы',
	'FeedsInfo'					=> 'В случае прямой правки документов в базе данных, содержание RSS-фидов не отразит сделанных изменений. Данная функция синхронизирует RSS-каналы с текущим состоянием БД.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'WikiLinks'					=> 'Wiki-ссылки',
	'WikiLinksInfo'				=> 'Выполняет повторный рендеринг всех внутрисайтовых ссылок и восстанавливает содержимое таблицы <code>page_link</code> и <code>file_link</code> в случае ее порчи или повреждений (может занять значительное время).',

	// Email settings
	'EmaiSettingsInfo'			=> 'Эта информация используется для отправки конференцией email-сообщений пользователям. Удостоверьтесь в правильности указанных email-адресов, все возвращённые или не доставленные сообщения будут, вероятно, отправлены на них. Если ваш сервер не обеспечивает использование встроенной (в PHP) службы email, вы можете отправлять сообщения напрямую с использованием SMTP. Для этого необходим адрес подходящего сервера (если нужно, спросите об этом у провайдера). Если сервер требует аутентификации (и только в этом случае), введите необходимые имя, пароль и метод аутентификации.',
	
    'EmailSettingsUpdated'	    => 'Updated Email settings',

	'EmailFunctionName'			=> 'Имя функции email',
	'EmailFunctionNameInfo'		=> 'Функция email, используемая для отправки сообщений через PHP.',
	'UseSmtpInfo'				=> 'Выберите <code>SMTP</code>, если хотите или должны отправлять email-сообщения через сервер вместо локальной функции mail.',

	'EnableEmail'				=> 'Разрешить email-сообщения',
	'EnableEmailInfo'			=> 'Разрешить отправку email-сообщений сайтом',

	'FromEmailName'				=> 'Имя отправителя по-умолчанию',
	'FromEmailNameInfo'			=> 'Имя отправителя отображается в поле <code>From:</code> во всех email-уведомлениях, посылаемых сайтом.',
	'NoReplyEmail'				=> 'Адрес отправителя по-умолчанию',
	'NoReplyEmailInfo'			=> 'Адрес отправителя по-умолчанию, например <code>noreply@example.com</code>, отображается в поле <code>From:</code> во всех email-уведомлениях, посылаемых сайтом.',
	'AdminEmail'				=> 'Обратный email-адрес',
	'AdminEmailInfo'			=> 'Этот адрес используется для административных целей, например уведомления новых пользователей.',
	'AbuseEmail'				=> 'Email-адрес для жалоб',
	'AbuseEmailInfo'			=> 'Для запросов по срочным поводам: регистрация с чужого email и т.д. Может совпадать с предыдущим.',

	'SendTestEmail'				=> 'Отправить тестовое email-сообщение',
	'SendTestEmailInfo'			=> 'Будет отправлено тестовое email-сообщение на адрес, указанный в вашей учётной записи.',
	'TestEmailSubject'			=> 'WackoWiki настроен для отправки email-сообщений',
	'TestEmailBody'				=> 'Если вы получили это письмо, значит WackoWiki правильно настроен для отправки email-сообщений.',
	'TestEmailMessage'			=> 'Тестовое email-сообщение отправлено.<br>Если вы не получили тестовое email-сообщение, проверьте настройки почты.',

	'SmtpAutoTls'				=> 'Оппортунистический TLS',
	'SmtpAutoTlsInfo'			=> 'Автоматически включает шифрование, если сервер поддерживает TLS-шифрование. Даже если вы не указали режим соединения для <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Метод аутентификации для SMTP',
	'SmtpConnectionModeInfo'	=> 'Используется только в случае, если заданы имя/пароль. Спросите у своего провайдера, если не уверены, какой метод аутентификации использовать.',
	'SmtpPassword'				=> 'Пароль SMTP',
	'SmtpPasswordInfo'			=> 'Введите пароль, только если SMTP требует этого.<br><em><strong>Внимание:</strong> этот пароль будет сохранён в базе данных в незашифрованном виде и будет виден всем, кто имеет доступ к ней или к этой странице настроек.</em>',
	'SmtpPort'					=> 'Порт сервера SMTP',
	'SmtpPortInfo'				=> 'Изменяйте порт только в том случае, если вам точно известно, что сервер использует другой порт. <br>(стандартно: <code>tls</code> порт 587 (или 25) и <code>ssl</code> порт 465)',
	'SmtpServer'				=> 'Адрес сервера SMTP',
	'SmtpServerInfo'			=> 'Учтите, что необходимо указывать протокол для соединения с сервером SMTP. Например: <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> 'Настройки SMTP',
	'SmtpUsername'				=> 'Имя пользователя SMTP',
	'SmtpUsernameInfo'			=> 'Введите имя только в случае, если сервер SMTP требует этого.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Здесь вы можете настроить основные параметры вложений и связанных с ними специальных категорий.',
	'FileUploads'				=> 'Загрузка файлов',
	'UploadMaxFilesize'			=> 'Максимальный размер файла',
	'UploadMaxFilesizeInfo'		=> 'Максимальный размер каждого загружаемого файла. Если значение равно 0, размер файла ограничен только конфигурацией PHP.',
	'UploadQuota'				=> 'Общая квота вложений',
	'UploadQuotaInfo'			=> 'Максимально доступное дисковое пространство для вложений. Значение 0 соответствует неограниченному размеру.',
	'UploadQuotaUser'			=> 'Квота на суммарный объем файлов, загруженных пользователем',
	'UploadQuotaUserInfo'		=> 'Ограничение суммарного объема файлов, который может загружать один пользователь, 0 означает отсутствие ограничения.',
	'CheckMimetype'				=> 'Проверять вложения',
	'CheckMimetypeInfo'			=> 'Некоторые браузеры могут быть обмануты при определении MIME-типа загружаемых файлов. Включение данной опции гарантирует, что такие файлы, вероятнее всего, будут отклоняться во время загрузки.',

	'Thumbnails'				=> 'Миниатюры',
	'CreateThumbnail'			=> 'Создавать миниатюры',
	'CreateThumbnailInfo'		=> 'При включении опции для загружаемых рисунков будут создаваться миниатюры во всех возможных ситуациях.',
	'MaxThumbWidth'				=> 'Максимальная ширина миниатюр',
	'MaxThumbWidthInfo'			=> 'Ширина создаваемых миниатюр не будет превышать указанного здесь размера.',
	'MinThumbFilesize'			=> 'Минимальный размер файлов для миниатюр',
	'MinThumbFilesizeInfo'		=> 'Миниатюры не будут создаваться для рисунков меньше указанного размера.',

	// log
	'LogLevel1'					=> 'Критический',
	'LogLevel2'					=> 'Наивысший',
	'LogLevel3'					=> 'Высокий',
	'LogLevel4'					=> 'Средний',
	'LogLevel5'					=> 'Низкий',
	'LogLevel6'					=> 'Минимальный',
	'LogLevel7'					=> 'Отладочный',

	// Massemail
	'SendToGroup'				=> 'Послать группе',
	'SendToUser'				=> 'Послать пользователю',

	// User approval module
	'UserApproveInfo'			=> 'Санкционировать новых пользователей.',
	'Approve'					=> 'Допустить',
	'Deny'						=> 'Отказать',
	'Pending'					=> 'Ожидает решения',
	'Approved'					=> 'Одобрено',
	'Denied'					=> 'Отказано',

	// DB Backup module
	'BackupStructure'			=> 'Структура',
	'BackupData'				=> 'Данные',
	'BackupFolder'				=> 'Каталог',
	'BackupTable'				=> 'Таблица',
	'BackupCluster'				=> 'Кластер',
	'BackupFiles'				=> 'Файлы',
	'BackupSettings'			=> 'Укажите требуемую схему резервирования. '.
									'Корневой кластер не влияет на резервное копирование глобальных файлов и файлов кэша (при их выборе они всегда сохраняются полностью).<br> '.
									'<br> '.
									'<strong>Внимание</strong>: во избежание потери информации из базы данных WackoWiki, при указании корня кластера, таблицы из данной резервной копии не будут реструктуризированы, '.
									'аналогично, при резервировании только структуры таблицы без сохранения данных. '.
									'Для полной конвертации таблиц в формат резервной копии необходимо произвести <em>полное резервирование всей базы данных (структура и содержимое) без указания кластера</em>.',
	'BackupCompleted'			=> 'Резервное копирование и архивация завершены.<br>' .
									'Пакет резервной копии сохранен в папке с названием %1 в папке <code>files/backup</code>.<br>' .
									'Для его получения используйте FTP (не забудьте при копировании сохранять структуру каталогов и имена файлов и директорий).<br>' .
									'Восстановить резервную копию или удалить пакет можно в разделе <a href="?mode=db_restore">Восстановление</a>.',
	'LogSavedBackup'			=> 'Сохранена резервная копия базы данных ##%1##',

	// DB Restore module
	'RestoreInfo'				=> 'Вы можете восстановить любой из найденных резервных пакетов, либо удалить его с сервера.',
	'ConfirmDbRestore'			=> 'Вы хотите восстановить резервную копию',
	'ConfirmDbRestoreInfo'		=> 'Пожалуйста, подождите. Это может занять несколько минут.',
	'RestoreWrongVersion'		=> 'Неправильная версия WackoWiki!',
	'BackupDelete'				=> 'Вы уверены, что хотите удалить резервную копию',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Дополнительные опции для восстановления',
	'RestoreOptionsInfo'		=> '* Перед восстановлением резервной копии <strong>кластера</strong> WackoWiki, '.
									'целевые таблицы не уничтожаются (дабы предотвратить потерю информации из незарезервированных кластеров). '.
									'Таким образом, в процессе восстановления будут встречаться дублированные записи. '.
									'В обычном режиме все они будут заменены записями из резервной копии (с помощью SQL-инструкции <code>REPLACE</code>), <br>' .
									'но если этот флажок установлен, все дубликаты будут пропущены (будут сохранены текущие значения записей), <br>' .
									'а добавлены в таблицу только записи с новыми ключами (SQL-инструкцией <code>INSERT IGNORE</code>).<br>' .
									'<strong>Заметьте</strong>: при восстановлении полной резервной копии сайта эта опция не имеет значения.<br> '.
									'<br> '.
									'** Если резервная копия содержит пользовательские файлы (глобальные и постраничные, файлы кэша и пр.), то в обычном режиме при восстановлении они заменят одноименные файлы, размещенные в тех же каталогах. '.
									'Эта опция позволяет сохранить текущие копии файлов, а восстановить из резервной копии только новые (отсутствующие на сервере) файлы. ',
	'IgnoreDuplicatedKeys'		=> 'Игнорировать дубликатные ключи таблицы (не заменять)',
	'IgnoreSameFiles'			=> 'Игнорировать одноименные файлы (не перезаписывать)',
	'NoBackupsAvailable'		=> 'Резервные копии отсутствуют.',
	'BackupEntireSite'			=> 'Весь сайт',
	'BackupRestored'			=> 'Резервная копия восстановлена, отчет выполнения приложен ниже. Чтобы удалить данную резервную копию, нажмите здесь',
	'BackupRemoved'				=> 'Выбранная резервная копия успешно удалена.',
	'LogRemovedBackup'			=> 'Удалена резервная копия базы данных ##%1##',

	// User module
	'UsersAdded'				=> 'Пользователь добавлен',
	'UsersDeleteInfo'			=> 'Удаление пользователя',
	'UserEditButton'			=> 'Редактировать',
	'UserEnabled'				=> 'Включено',
	'UsersAddNew'				=> 'Добавить нового пользователя',
	'UsersDelete'				=> 'Вы уверены, что хотите удалить пользователя ',
	'UsersDeleted'				=> 'Пользователь был удален из базы данных.',
	'UsersRename'				=> 'Переименовать пользователя',
	'UsersRenameInfo'			=> '* Внимание: Изменения затронут все страницы этого пользователя.',
	'UsersUpdated'				=> 'Пользователь успешно обновлен.',

	'UserName'					=> 'Имя пользователя',
	'UserRealname'				=> 'Настоящее имя',
	'UserEmail'					=> 'Email',
	'UserIP'					=> 'IP',
	'UserLanguage'				=> 'Язык',
	'UserSignuptime'			=> 'Дата регистрации',
	'UserActions'				=> 'Действия',
	'NoMatchingUser'			=> 'Нет пользователей, соответствующих заданным критериям',

	// Groups module
	'GroupsMembersFor'			=> 'Участники группы',
	'GroupsDescription'			=> 'Описание',
	'GroupsModerator'			=> 'Модератор',
	'GroupsOpen'				=> 'Открытая',
	'GroupsActive'				=> 'Активная',
	'GroupsTip'					=> 'Редактировать группу',
	'GroupsUpdated'				=> 'Группы обновлены',
	'GroupsAlreadyExists'		=> 'Эта группа уже существует.',
	'GroupsAdded'				=> 'Группа добавлена.',
	'GroupsRenamed'				=> 'Группы переименована.',
	'GroupsDeleted'				=> 'Группа удалена из базы данных и всех страниц.',
	'GroupsAdd'					=> 'Добавить новую группу',
	'GroupsRename'				=> 'Удалить группу',
	'GroupsRenameInfo'			=> '* Внимание: Изменения затронут все страницы пользователей, входящих в группу.',
	'GroupsDelete'				=> 'Вы уверены, что хотите удалить группу ',
	'GroupsDeleteInfo'			=> '* Внимание: Изменения затронут всех пользователей, входящих в группу.',
	'GroupsStoreButton'			=> 'Сохранить группы',
	'GroupsSaveButton'			=> 'Отправить',
	'GroupsCancelButton'		=> 'Отменить',
	'GroupsAddButton'			=> 'Добавить',
	'GroupsEditButton'			=> 'Изменить',
	'GroupsRemoveButton'		=> 'Удалить',
	'GroupsEditInfo'			=> 'Для редактирования списка групп выберите радио-кнопку.',

	'MembersAddNew'				=> 'Добавить нового участника',
	'MembersAdded'				=> 'Участник добавлен в группу.',
	'MembersRemove'				=> 'Даете добро на удаление участника ',
	'MembersRemoved'			=> 'Участник из группы удален.',
	'MembersDeleteInfo'			=> '* Внимание: Изменения затронут всех пользователей, входящих в группу.',

];

?>
