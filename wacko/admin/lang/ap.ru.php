<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'					=> 'Внимание: перед проведением технических административных мероприятий <span class="underline">настоятельно</span> рекомендуется закрыть доступ к сайту!',

	'CategoryArray'		=> [
		'basics'		=> 'Базовые функции',
		'preferences'	=> 'Настройки',
		'content'		=> 'Контент',
		'users'			=> 'Пользователей',
		'maintenance'	=> 'Обслуживание',
		'messages'		=> 'Messages',
		'extension'		=> 'Extension',
		'database'		=> 'База данных',
	],

	// Admin panel
	'AdminPanel'				=> 'Администраторский раздел',
	'Authorization'				=> 'Авторизация',
	'AuthorizationTip'			=> 'Пожалуйста, укажите административный пароль (убедитесь также, что cookies в вашем браузере разрешены).',
	'NoRecoceryPassword'		=> 'Административный пароль не задан!',
	'NoRecoceryPasswordTip'		=> 'Внимание: отсутствие административного пароля представляет угрозу для безопасности! Укажите пароль в файле настроек и запустите программу повторно.',

	'ErrorLoadingModule'		=> 'Error loading admin module %1: does not exists.',

	'FormSave'					=> 'Save',
	'FormReset'					=> 'Reset',
	'FormUpdate'				=> 'Update',

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
	'Enabled'					=> 'Enabled',
	'Disabled'					=> 'Disabled',
	'On'						=> 'on',
	'Off'						=> 'off',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'Admin',

	// MENU
	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Базовые',
		'title'		=> 'Основные параметры',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Email',
		'title'		=> 'Email settings',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filter',
		'title'		=> 'Filter settings',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'Formatting options',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Notifications',
		'title'		=> 'Notifications settings',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Страницы',
		'title'		=> 'Адреса и параметры служебных страниц',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permissions',
		'title'		=> 'Permissions settings',
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
		'name'		=> 'Upload',
		'title'		=> 'Attachment settings',
	],

	// Categories module
	'content_categories'		=> [
		'name'		=> 'Categories',
		'title'		=> 'Manage categories',
	],

	// Comments module
	'content_comments'		=> [
		'name'		=> 'Comments',
		'title'		=> 'Manage comments',
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
		'title'		=> 'Add, edit or remove default menu items',
	],

	// Pages module
	'content_pages'		=> [
		'name'		=> 'Страницы',
		'title'		=> 'Manage pages',
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
		'name'		=> 'Convert',
		'title'		=> 'Converting Tables or Columns',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Repair',
		'title'		=> 'Repair and Optimize Database',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Восстановление базы',
		'title'		=> 'Восстановление резервных данных',
	],

	// Dashboard module
	'lock'		=> [
		'name'		=> 'Главное меню',
		'title'		=> 'Управление WackoWiki',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inconsistencies',
		'title'		=> 'Fixing Data Inconsistencies',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Синхронизация данных',
		'title'		=> 'Синхронизация базы данных',
	],

	// Transliterate module
	'maint_transliterate'		=> [
		'name'		=> 'Transliterate',
		'title'		=> 'Update the supertag in the database records',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Mass email',
		'title'		=> 'Mass email',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'System message',
		'title'		=> 'System messages',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'System Info',
		'title'		=> 'System Informations',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Системный журнал',
		'title'		=> 'Журнал системных событий',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistics',
		'title'		=> 'Show statistics',
	],

	// Bad Behavior module
	'badbehavior'		=> [
		'name'		=> 'Bad Behavior',
		'title'		=> 'Bad Behavior',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Approve',
		'title'		=> 'User registration approval',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Групп',
		'title'		=> 'Group management',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Пользователей',
		'title'		=> 'User management',
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

	'PurgeSessions'				=> 'очистить',
	'PurgeSessionsTip'			=> 'Прочистить все сессии',
	'PurgeSessionsConfirm'		=> 'Увереный в прочистке сессий? Это прекратит сессии всех текущих пользователей.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the auth_token table.',
	'PurgeSessionsDone'			=> 'Сессии прочищены.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Эта информация используется для отправки конференцией email-сообщений пользователям. Удостоверьтесь в правильности указанных email-адресов, все возвращённые или не доставленные сообщения будут, вероятно, отправлены на них. Если ваш сервер не обеспечивает использование встроенной (в PHP) службы email, вы можете отправлять сообщения напрямую с использованием SMTP. Для этого необходим адрес подходящего сервера (если нужно, спросите об этом у провайдера). Если сервер требует аутентификации (и только в этом случае), введите необходимые имя, пароль и метод аутентификации.',

	'EmailFunctionName'			=> 'Имя функции email',
	'EmailFunctionNameInfo'		=> 'Функция email, используемая для отправки сообщений через PHP.',
	'UseSmtpInfo'				=> 'Выберите <code>SMTP</code>, если хотите или должны отправлять email-сообщения через сервер вместо локальной функции mail.',

	'EnableEmail'				=> 'Разрешить email-сообщения',
	'EnableEmailInfo'			=> 'Enabling emails',

	'FromEmailName'				=> 'From Name',
	'FromEmailNameInfo'			=> 'The sender name, part of <code>From:</code> header in emails for all the email-notification sent from the site.',
	'NoReplyEmail'				=> 'No-reply address',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all your email-notifications sent from the site.',
	'AdminEmail'				=> 'Обратный email-адрес',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.',

	'SendTestEmail'				=> 'Отправить тестовое email-сообщение',
	'SendTestEmailInfo'			=> 'Будет отправлено тестовое email-сообщение на адрес, указанный в вашей учётной записи.',
	'TestEmailSubject'			=> 'WackoWiki настроен для отправки email-сообщений',
	'TestEmailBody'				=> 'Если вы получили это письмо, значит WackoWiki правильно настроен для отправки email-сообщений.',
	'TestEmailMessage'			=> 'Тестовое email-сообщение отправлено.<br />Если вы не получили тестовое email-сообщение, проверьте настройки почты.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Метод аутентификации для SMTP',
	'SmtpConnectionModeInfo'	=> 'Используется только в случае, если заданы имя/пароль. Спросите у своего провайдера, если не уверены, какой метод аутентификации использовать.',
	'SmtpPassword'				=> 'Пароль SMTP',
	'SmtpPasswordInfo'			=> 'Введите пароль, только если SMTP требует этого.<br /><em><strong>Внимание:</strong> этот пароль будет сохранён в базе данных в незашифрованном виде и будет виден всем, кто имеет доступ к ней или к этой странице настроек.</em>',
	'SmtpPort'					=> 'Порт сервера SMTP',
	'SmtpPortInfo'				=> 'Изменяйте порт только в том случае, если вам точно известно, что сервер использует другой порт. <br />(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Адрес сервера SMTP',
	'SmtpServerInfo'			=> 'Учтите, что необходимо указывать протокол для соединения с сервером SMTP. Например: <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> 'Настройки SMTP',
	'SmtpUsername'				=> 'Имя пользователя SMTP',
	'SmtpUsernameInfo'			=> 'Введите имя только в случае, если сервер SMTP требует этого.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Здесь вы можете настроить основные параметры вложений и связанных с ними специальных категорий.',
	'FileUploads'				=> 'File uploads',
	'UploadMaxFilesize'			=> 'Максимальный размер файла',
	'UploadMaxFilesizeInfo'		=> 'Максимальный размер каждого загружаемого файла. Если значение равно 0, размер файла ограничен только конфигурацией PHP.',
	'UploadQuota'				=> 'Общая квота вложений',
	'UploadQuotaInfo'			=> 'Максимально доступное дисковое пространство для вложений. Значение 0 соответствует неограниченному размеру.',
	'UploadQuotaUser'			=> 'Storage quota per user',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with 0 being unlimited.',
	'CheckMimetype'				=> 'Проверять вложения',
	'CheckMimetypeInfo'			=> 'Некоторые браузеры могут быть обмануты при определении MIME-типа загружаемых файлов. Включение данной опции гарантирует, что такие файлы, вероятнее всего, будут отклоняться во время загрузки.',

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
	'SendToGroup'				=> 'Send to group',
	'SendToUser'				=> 'Send to user',

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
									'Корневой кластер не влияет на резервное копирование глобальных файлов и файлов кэша (при их выборе они всегда сохраняются полностью).<br /> '.
									'<br /> '.
									'<span class="underline">Внимание</span>: во избежание потери информации из базы данных WackoWiki, при указании корня кластера, таблицы из данной резервной копии не будут реструктуризированы, '.
									'аналогично, при резервировании только структуры таблицы без сохранения данных. '.
									'Для полной конвертации таблиц в формат резервной копии необходимо произвести <em>полное резервирование всей базы данных (структура и содержимое) без указания кластера</em>.',
	'BackupCompleted'			=> 'Резервное копирование и архивация завершены.<br />' .
									'Пакет резервной копии сохранен в папке с названием "(дата)ГГГГММДД_(время)ЧЧММСС" в папке files/backup.<br />' .
									'Для его получения используйте FTP (не забудьте при копировании сохранять структуру каталогов и имена файлов и директорий).<br />' .
									'Восстановить резервную копию или удалить пакет можно в разделе <a href="?mode=db_restore">Восстановление</a>.',
	'LogSavedBackup'			=> 'Saved backup database ##%1##',

	// DB Restore module
	'RestoreInfo'				=> 'Вы можете восстановить любой из найденных резервных пакетов, либо удалить его с сервера.',
	'ConfirmDbRestore'			=> 'Do you want to restore backup',
	'ConfirmDbRestoreInfo'		=> 'Please wait this can take some minutes.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'BackupDelete'				=> 'Are you sure you want to remove backup',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Дополнительные опции для восстановления',
	'RestoreOptionsInfo'		=> '* Перед восстановлением резервной копии <span class="underline">кластера</span> WackoWiki, '.
									'целевые таблицы не уничтожаются (дабы предотвратить потерю информации из незарезервированных кластеров). '.
									'Таким образом, в процессе восстановления будут встречаться дублированные записи. '.
									'В обычном режиме все они будут заменены записями из резервной копии (с помощью SQL-инструкции <code>REPLACE</code>), <br />' .
									'но если этот флажок установлен, все дубликаты будут пропущены (будут сохранены текущие значения записей), <br />' .
									'а добавлены в таблицу только записи с новыми ключами (SQL-инструкцией <code>INSERT IGNORE</code>).<br />' .
									'<span class="underline">Заметьте</span>: при восстановлении полной резервной копии сайта эта опция не имеет значения.<br /> '.
									'<br /> '.
									'** Если резервная копия содержит пользовательские файлы (глобальные и постраничные, файлы кэша и пр.), то в обычном режиме при восстановлении они заменят одноименные файлы, размещенные в тех же каталогах. '.
									'Эта опция позволяет сохранить текущие копии файлов, а восстановить из резервной копии только новые (отсутствующие на сервере) файлы. ',
	'IgnoreDuplicatedKeys'		=> 'Игнорировать дубликатные ключи таблицы (не заменять)',
	'IgnoreSameFiles'			=> 'Игнорировать одноименные файлы (не перезаписывать)',
	'NoBackupsAvailable'		=> 'No backups available.',
	'BackupEntireSite'			=> 'Весь сайт',
	'BackupRestored'			=> 'Резервная копия восстановлена, отчет выполнения приложен ниже. Чтобы удалить данную резервную копию, нажмите здесь',
	'BackupRemoved'				=> 'Выбранная резервная копия успешно удалена.',
	'LogRemovedBackup'			=> 'Removed database backup ##%1##',

	// User module
	'UsersAdded'				=> 'Пользователь добавлен',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'UserEditButton'			=> 'Edit',
	'UserEnabled'				=> 'Включено',
	'UsersAddNew'				=> 'Добавить нового пользователя',
	'UsersDelete'				=> 'Are you sure you want to remove user ',
	'UsersDeleted'				=> 'The user was deleted from the database.',
	'UsersRename'				=> 'Rename the user',
	'UsersRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that user.',
	'UsersUpdated'				=> 'User successfully updated.',

	'UserName'					=> 'Username',
	'UserRealname'				=> 'Realname',
	'UserEmail'					=> 'Email',
	'UserIP'					=> 'IP',
	'UserLanguage'				=> 'Language',
	'UserSignuptime'			=> 'Signuptime',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'No users that meet the criteria',

	// Groups module
	'GroupsMembersFor'			=> 'Участники группы',
	'GroupsDescription'			=> 'Описание',
	'GroupsModerator'			=> 'Модератор',
	'GroupsOpen'				=> 'Open',
	'GroupsActive'				=> 'Active',
	'GroupsTip'					=> 'Редактировать группу',
	'GroupsUpdated'				=> 'Группы обновлены',
	'GroupsAlreadyExists'		=> 'Эта группа уже cуществует.',
	'GroupsAdded'				=> 'Группа добавлена.',
	'GroupsRenamed'				=> 'Группы переименована.',
	'GroupsDeleted'				=> 'Группа удалена из базы данных и всех страниц.',
	'GroupsAdd'					=> 'Добавить новую группу',
	'GroupsRename'				=> 'Удалить группу',
	'GroupsRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that group.',
	'GroupsDelete'				=> 'Are you sure you want to remove group ',
	'GroupsDeleteInfo'			=> '* Note: Change will affect all members that are assigned to that group.',
	'GroupsStoreButton'			=> 'Сохранить группы',
	'GroupsSaveButton'			=> 'Submit',
	'GroupsCancelButton'		=> 'Отменить',
	'GroupsAddButton'			=> 'Добавить',
	'GroupsEditButton'			=> 'Изменить',
	'GroupsRemoveButton'		=> 'Удалить',
	'GroupsEditInfo'			=> 'Для редактирования списка групп выберите радио-кнопку.',

	'MembersAddNew'				=> 'Добавить нового участника',
	'MembersAdded'				=> 'Участник добавлен в группу.',
	'MembersRemove'				=> 'Даете добро на удаление участника ',
	'MembersRemoved'			=> 'Участник из группы удален.',
	'MembersDeleteInfo'			=> '* Note: Change will affect all members that are assigned to that group.',

];

?>
