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

	'MiscellaneousSection'		=> 'Разное',
	'MainSection'				=> 'Основные параметры',

	'DirNotWritable'			=> 'The %1 directory is not writable.',

	/**
	 * AP MENU
	 *
	 *	'module_name'		=> [
	 *		'name'		=> 'Module name',
	 *		'title'		=> 'Module title',
	 *	],
	 */

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

	// Main module
	'PurgeSessions'				=> 'удалить',
	'PurgeSessionsTip'			=> 'Удалить все сессии',
	'PurgeSessionsConfirm'		=> 'Уверены в удалении сессий? Это прекратит сессии всех текущих пользователей.',
	'PurgeSessionsExplain'		=> 'Удалить все сессии. Это прекратит сессии всех текущих пользователей с очисткой таблицы auth_token.',
	'PurgeSessionsDone'			=> 'Сессии удалены.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Обновлены базовые параметры',
	'LogBasicSettingsUpdated'	=> 'Обновлены базовые параметры',

	'SiteName'					=> 'Название сайта',
	'SiteNameInfo'				=> 'Заголовок, отображаемый на страницах сайта, в email-уведомлениях и т.д.',
	'SiteDesc'					=> 'Описание сайта',
	'SiteDescInfo'				=> 'Дополнение к заголовку сайта, отображаемое в шапках страниц.',
	'AdminName'					=> 'Имя владельца сайта',
	'AdminNameInfo'				=> 'Имя пользователя, отвечающего за общую поддержку сайта. Это имя не используется для определения прав доступа, но желательно, чтобы оно соответствовало имени главного администратора сайта.',

	'LanguageSection'			=> 'Языковые настройки',
	'DefaultLanguage'			=> 'Язык по умолчанию',
	'DefaultLanguageInfo'		=> 'Определяет язык сообщений при отображении незарегистрированным гостям, а также параметры локали и правила транслитерации адресов страниц.',
	'MultiLanguage'				=> 'Многоязыковая поддержка',
	'MultiLanguageInfo'			=> 'Включить возможность выбора языка на постраничной основе.',
	'AllowedLanguages'			=> 'Allowed languages',
	'AllowedLanguagesInfo'		=> 'It is recomended to select only the set of languages you want to use, other wise all languages are selected.',

	'CommentSection'			=> 'Комментарии',
	'AllowComments'				=> 'Разрешить комментарии',
	'AllowCommentsInfo'			=> 'Enable comments for guest or registered users only or disable them on the entire site.',
	'SortingComments'			=> 'Сортировка комментариев',
	'SortingCommentsInfo'		=> 'Changes the order the page comments are presented, either with the most recent OR the oldest comment at the top.',

	'ToolbarSection'			=> 'Панели',
	'CommentsPanel'				=> 'Панель комментариев',
	'CommentsPanelInfo'			=> 'По умолчанию отображать в нижней части страниц панель комментариев.',
	'FilePanel'					=> 'Панель файлов',
	'FilePanelInfo'				=> 'По умолчанию отображать в нижней части страниц панель прикрепленных файлов.',
	'RatingPanel'				=> 'Панель рейтинга',
	'RatingPanelInfo'			=> 'По умолчанию отображать в нижней части страниц панель рейтинга документа.',
	'TagsPanel'					=> 'Tags panel',
	'TagsPanelInfo'				=> 'The default display of the tags panel in the bottom of the page.',
	'HideRevisions'				=> 'Hide Revisions',
	'HideRevisionsInfo'			=> 'The default display of revisions of the page.',
	'TocPanel'					=> 'Панель оглавления',
	'TocPanelInfo'				=> 'По умолчанию отображать панель оглавления документа (требуется поддержка в шаблоне оформления).',
	'SectionsPanel'				=> 'Панель разделов',
	'SectionsPanelInfo'			=> 'По умолчанию отображать панель соседних документов (требуется поддержка в шаблоне оформления).',
	'DisplayingSections'		=> 'Отображение разделов',
	'DisplayingSectionsInfo'	=> 'При включенной предыдущей опции, следует ли выводить только дочерние страницы (<em>нижние</em>), только соседние (<em>верхние</em>) или и те, и другие (<em>дерево</em>).',
	'MenuItems'					=> 'Menu items',
	'MenuItemsInfo'				=> 'Default number of shown menu items (may need support in the templates).',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Enable feeds',
	'EnableFeedsInfo'			=> 'Turns on or off RSS feeds for the entire wiki.',
	'XmlSitemap'				=> 'XML Sitemap',
	'XmlSitemapInfo'			=> 'Create an XML file called "sitemap-wackowiki.xml" inside the xml folder. Generate a Sitemaps XML format compatible XML file. You might want to change the path to output it in your root folder as that is one of the requirements i.e. that the XML file is in the root folder.',
	'XmlSitemapTime'			=> 'XML Sitemap generation time',
	'XmlSitemapTimeInfo'		=> 'Generates the Sitemap only once in the given number of days, zero means on every page change.',

	'DiffModeSection'			=> 'Diff Modes',
	'DefaultDiffModeSetting'	=> 'Default diff mode',
	'DefaultDiffModeSettingInfo'=> 'Preselected diff mode.',
	'AllowedDiffMode'			=> 'Allowed Diff modes',
	'AllowedDiffModeInfo'		=> 'It is recomended to select only the set of diff modes you want to use, other wise all diff modes are selected.',
	'NotifyDiffMode'			=> 'Notify diff mode',
	'NotifyDiffModeInfo'		=> 'Diff mode used for Notifications in Email body.',

	'EditSummary'				=> 'Edit summary',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Minor edit',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'ReviewSettings'			=> 'Review',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',

	'PublishAnonymously'		=> 'Allow anonymous publishing',
	'PublishAnonymouslyInfo'	=> 'Allow users to published preferably anonymously (to hide the name).',
	'DefaultRenameRedirect'		=> 'При переименовании ставить редирект',
	'DefaultRenameRedirectInfo'	=> 'По умолчанию предлагать поставить редирект по старому адресу переименуемой страницы.',
	'StoreDeletedPages'			=> 'Хранить удаленные страницы',
	'StoreDeletedPagesInfo'		=> 'При удалении страницы (комментария) помещать ее в специальный раздел, где она еще некоторое время (указанное ниже) будет доступна для просмотра и восстановления.',
	'KeepDeletedTime'			=> 'Срок хранения удаленных страниц',
	'KeepDeletedTimeInfo'		=> 'Период в днях. Имеет смысл только при включенной предыдущей опции. Ноль указывает на вечное хранение (при этом администратор может очищать "корзину" вручную).',
	'PagesPurgeTime'			=> 'Срок хранения редакций страниц',
	'PagesPurgeTimeInfo'		=> 'Автоматически удалять редакции старше данного числа дней. Если ввести ноль, старые редакции удаляться не будут.',
	'EnableReferrers'			=> 'Enable Referrers',
	'EnableReferrersInfo'		=> 'Allows to store and show external referrers.',
	'ReferrersPurgeTime'		=> 'Срок хранения реферреров',
	'ReferrersPurgeTimeInfo'	=> 'Хранить историю ссылающихся внешних страниц не более данного числа дней. Ноль означает вечное хранение, однако для активно посещаемого сайта это может привести к переполнению базы данных.',
	'AttachmentHandler'			=> 'Enable attachments handler',
	'AttachmentHandlerInfo'		=> 'Allows to show the attachments handler.',
	'SearchEngineVisibility'	=> 'Block search engines (Search Engine Visibility)',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site, It is up to search engines to honor this request.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Управление стандартными настройками отображения сайта.',
	'AppearanceSettingsUpdated'	=> 'Updated appearance settings.',

	'LogoOff'					=> 'выкл.',
	'LogoOnly'					=> 'логотип',
	'LogoAndTitle'				=> 'логотип и заголовок',

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
	'Theme'						=> 'Тема оформления',
	'ThemeInfo'					=> 'Шаблон оформления сайта, используемый по умолчанию.',
	'ThemesAllowed'				=> 'Allowed Themes',
	'ThemesAllowedInfo'			=> 'Select the allowed themes, which the user can choose, otherwise all available themes are allowed.',
	'ThemesPerPage'				=> 'Themes per page',
	'ThemesPerPageInfo'			=> 'Allow themes per page, which the page owner can choose via page properties.',

	// System settings
	'SystemSettingsInfo'		=> 'Группа параметров, отвечающих за тонкую настройку платформы. Не меняйте их, если не уверены в своих действиях.',
	'SystemSettingsUpdated'		=> 'Updated system settings',

	'DebugModeSection'			=> 'Режим отладки',
	'DebugMode'					=> 'Режим отладки',
	'DebugModeInfo'				=> 'Фиксация и вывод телеметрических данных о времени исполнения программы. Внимание: режим полной детализации накладывает повышенные требования к выделяемой памяти, особенно при ресурсоёмких операциях вроде резервирования и восстановления БД.',
	'DebugModes'	=> [
		'0'		=> 'отладка отключена',
		'1'		=> 'только общее время исполнения',
		'2'		=> 'подробное время исполнения',
		'3'		=> 'полная детализация (СУБД, кэш и пр.)',
	],
	'DebugSqlThreshold'			=> 'Порог исполнения СУБД',
	'DebugSqlThresholdInfo'		=> 'В детализированном режиме отладки фиксировать только запросы, занявшие большее число секунд.',
	'DebugAdminOnly'			=> 'Закрытая диагностика',
	'DebugAdminOnlyInfo'		=> 'Отображать телеметрические данные исполнения программы (и СУБД) только для администратора.',

	'CachingSection'			=> 'Параметры кэширования',
	'Cache'						=> 'Кэшировать рендеринг страниц',
	'CacheInfo'					=> 'Сохранять отрисованные страницы в локальном кэше для ускорения последующей загрузки. Действует только для незарегистрированных посетителей.',
	'CacheTtl'					=> 'Срок актуальности кэша страниц',
	'CacheTtlInfo'				=> 'Кэшировать страницы не более чем на указанное число секунд.',
	'CacheSql'					=> 'Кэшировать запросы СУБД',
	'CacheSqlInfo'				=> 'Сохранять в локальном кэше результаты определенных ресурсоемких SQL-запросов.',
	'CacheSqlTtl'				=> 'Срок актуальности кэша СУБД',
	'CacheSqlTtlInfo'			=> 'Кэшировать результаты SQL-запросов не более чем на указанное число секунд. Использование значений свыше 1200 нежелательно.',

	'ReverseProxySection'		=> 'Reverse Proxy',
	'ReverseProxy'				=> 'Use Reverse proxy',
	'ReverseProxyInfo'			=> 'Enable this setting to determine the correct IP address of the remote
									 client by examining information stored in the X-Forwarded-For headers.
									 X-Forwarded-For headers are a standard mechanism for identifying client
									 systems connecting through a reverse proxy server, such as Squid or
									 Pound. Reverse proxy servers are often used to enhance the performance
									 of heavily visited sites and may also provide other site caching,
									 security or encryption benefits. If this WackoWiki installation operates
									 behind a reverse proxy, this setting should be enabled so that correct
									 IP address information is captured in WackoWiki\'s session management,
									 logging, statistics and access management systems; if you are unsure
									 about this setting, do not have a reverse proxy, or WackoWiki operates in
									 a shared hosting environment, this setting should remain disabled.',
	'ReverseProxyHeader'		=> 'Reverse proxy header',
	'ReverseProxyHeaderInfo'	=> 'Set this value if your proxy server sends the client IP in a header
									 other than X-Forwarded-For. The "X-Forwarded-For" header is a comma+space separated list of IP
									 addresses, only the last one (the left-most) will be used.',
	'ReverseProxyAddresses'		=> 'reverse_proxy accepts an array of IP addresses',
	'ReverseProxyAddressesInfo'	=> 'Each element of this array is the IP address of any of your reverse
									 proxies. Filling this array WackoWiki will trust the information stored
									 in the X-Forwarded-For headers only if Remote IP address is one of
									 these, that is the request reaches the web server from one of your
									 reverse proxies. Otherwise, the client could directly connect to
									 your web server spoofing the X-Forwarded-For headers.',

	'RewriteMode'					=> 'Использовать <code>mod_rewrite</code>',
	'RewriteModeInfo'				=> 'Если веб-сервер поддерживает данную функцию, включите, чтобы получить "красивые" адреса страниц.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parameters responsible for Access control and permissions.',
	'PermissionsSettingsUpdated'	=> 'Updated permissions settings',

	'PermissionsSection'		=> 'Допуски и привилегии',
	'ReadRights'				=> 'Права чтения по умолчанию',
	'ReadRightsInfo'			=> 'Присваиваются создаваемым корневым страницам, а также страницам, для которых не удается определить родительские права.',
	'WriteRights'				=> 'Права записи по умолчанию',
	'WriteRightsInfo'			=> 'Присваиваются создаваемым корневым страницам, а также страницам, для которых не удается определить родительские права.',
	'CommentRights'				=> 'Права комментирования по умолчанию',
	'CommentRightsInfo'			=> 'Присваиваются создаваемым корневым страницам, а также страницам, для которых не удается определить родительские права.',
	'CreateRights'				=> 'Права создания подстраниц по умолчанию',
	'CreateRightsInfo'			=> 'Определяют допуск для создания корневых страниц, а также присваиваются страницам, для которых не удается определить родительские права.',
	'UploadRights'				=> 'Права загрузки файлов по умолчанию',
	'UploadRightsInfo'			=> 'Присваиваются создаваемым корневым страницам, а также страницам, для которых не удается определить родительские права.',
	'RenameRights'				=> 'Право глобального переименования',
	'RenameRightsInfo'			=> 'Список допуска на возможность свободного переименования (переноса) документов.',

	'LockAcl'					=> 'Lock all ACL to read only',
	'LockAclInfo'				=> '<span class="cite">Overwrites the acl settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period for security reasons or as a emergency response.',
	'HideLocked'				=> 'Скрывать недоступные страницы',
	'HideLockedInfo'			=> 'Если пользователь не имеет прав на чтение страницы, скрывать ее в различных списках документов (размещенные в текстах ссылки, однако, будут по-прежнему видны).',
	'RemoveOnlyAdmins'			=> 'Только администраторы могут удалять страницы',
	'RemoveOnlyAdminsInfo'		=> 'Запретить всем, кроме администраторов, удалять страницы сайта. В первую очередь ограничение распространяется на обычных владельцев документов.',
	'OwnersRemoveComments'		=> 'Владельцы страниц могут удалять комментарии',
	'OwnersRemoveCommentsInfo'	=> 'Разрешить владельцам документов модерировать комментарии на своих страницах.',
	'OwnersEditCategories'		=> 'Владельцы страниц могут редактировать ключевые слова',
	'OwnersEditCategoriesInfo'	=> 'Разрешить владельцам документов изменять список ключевых слов сайта (добавлять слова, удалять слова), присваиваемых страницам.',
	'TermHumanModeration'		=> 'Срок прав модерации',
	'TermHumanModerationInfo'	=> 'Модераторы могут редактировать комментарии, только если те были созданы максимум столько дней назад (это ограничение не распространяется на последний комментарий в теме).',

	// Security settings
	'SecuritySettingsInfo'		=> 'Параметры, отвечающие за общую безопасность платформы, допуски и работу дополнительных подсистем безопасности.',
	'SecuritySettingsUpdated'	=> 'Обновлены параметры безопасности',

	'AllowRegistration'			=> 'Регистрация на сайте',
	'AllowRegistrationInfo'		=> 'Открытая регистрация пользователей. Отключение опции запретит свободную регистрацию, однако, администратор сайта сможет регистрировать других пользователей самостоятельно.',
	'ApproveNewUser'			=> 'Approve new users',
	'ApproveNewUserInfo'		=> 'Allows Administrators to approve users once they register. Only approved users will be allowed to log in the site.',
	'PersistentCookies'			=> 'Persistent cookies',
	'PersistentCookiesInfo'		=> 'Allow persistent cookies.',
	'AntiDupe'					=> 'Анти-клон',
	'AntiDupeInfo'				=> 'Запретить регистрироваться на сайте под именами, <span class="underline">похожими</span> на имена существующих пользователей (гости также не смогут использовать похожие имена для подписи комментариев). При отключенной опции проверяются только, <span class="underline">идентичные</span> имена.',
	'DisableWikiName'			=> 'Disable WikiName',
	'DisableWikiNameInfo'		=> 'Disable the the mandatory use of WikiName. Allows to register users with traditional nicknames, not forced NameSurname.',
	'AllowEmailReuse'			=> 'Allow email address re-use',
	'AllowEmailReuseInfo'		=> 'Different users can register with the same e-mail address.',
	'UsernameLength'			=> 'Username length',
	'UsernameLengthInfo'		=> 'Minimum and maximum number of characters in usernames.',

	'CaptchaSection'			=> 'Тест Тьюринга (CAPTCHA)',
	'EnableCaptcha'				=> 'Enable Captcha',
	'EnableCaptchaInfo'			=> 'If enabled, Captcha will be shown in the following cases or if a security threshold is reached.',
	'CaptchaComment'			=> 'New comment',
	'CaptchaCommentInfo'		=> 'В качестве меры защиты от спамовых публикаций требовать от незарегистрированных пользователей однократное решение теста перед размещением комментариев.',
	'CaptchaPage'				=> 'New page',
	'CaptchaPageInfo'			=> 'В качестве меры защиты от спамовых публикаций требовать от незарегистрированных пользователей однократное решение теста перед правкой страниц.',
	'CaptchaEdit'				=> 'Edit page',
	'CaptchaEditInfo'			=> 'В качестве меры защиты от спамовых публикаций требовать от незарегистрированных пользователей однократное решение теста перед правкой страниц.',
	'CaptchaRegistration'		=> 'Registration',
	'CaptchaRegistrationInfo'	=> 'В качестве меры защиты от спамовых публикаций требовать от незарегистрированных пользователей однократное решение теста перед регистрацией',

	'TlsSection'				=> 'Параметры TLS',
	'TlsConnection'				=> 'TLS-подключение',
	'TlsConnectionInfo'			=> 'Использовать TLS-защищенное подключение. <span class="cite">Для активации требуется предварительная установка на сервер SSL-сертификата, иначе вы лишитесь доступа к административной панели!</span><br>Он также определяет, установлен ли защищенный флаг Cookie, the <code>secure</code> флаг указывает, должны ли cookies передаваться только через защищенное соединение.',
	'TlsImplicit'				=> 'Принудительный TLS',
	'TlsImplicitInfo'			=> 'Принудительно переподключать клиента c HTTP на HTTPS. При отключенной опции клиент может просматривать сайт по открытому HTTP-каналу.',
	'TlsProxy'					=> 'TLS Proxy',
	'TlsProxyInfo'				=> 'Uses the provided TLS Proxy inplace of TLS. E.g. https://<span class="cite">your-https-proxy.tld</span> without ending slash and without https://.',
	'HttpSecurityHeaders'		=> 'HTTP Security Headers',
	'EnableSecurityHeaders'		=> 'Enable Security Headers',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk !',
	'Csp'						=> 'Content-Security-Policy (CSP)',
	'CspInfo'					=> 'Configuring Content Security Policy involves deciding what policies you want to enforce, and then configuring them and using Content-Security-Policy to establish your policy.',
	'CspModes'	=> [
		'0'		=> 'disabled',
		'1'		=> 'strict',
		'2'		=> 'custom',
	],
	'ReferrerPolicy'			=> 'Referrer Policy',
	'ReferrerPolicyInfo'		=> 'The Referrer-Policy HTTP header governs which referrer information, sent in the Referer header, should be included with requests made.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> 'Стойкость пользовательских паролей',
	'PwdMinChars'				=> 'Минимальная длина пароля',
	'PwdMinCharsInfo'			=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 12 to 16 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'AdminPwdMinChars'			=> 'Minimum Admin password length',
	'AdminPwdMinCharsInfo'		=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 15 to 20 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'PwdCharComplexity'			=> 'Требуемая сложность пароля',
	'PwdCharClasses'	=> [
		'0'		=> 'не проверяется',
		'1'		=> 'любые буквы + цифры',
		'2'		=> 'заглавные и строчные + цифры',
		'3'		=> 'заглавные и строчные + цифры + символы',
	],
	'PwdUnlikeLogin'			=> 'Дополнительная сложность',
	'PwdUnlikes'	=> [
		'0'		=> 'не проверяется',
		'1'		=> 'пароль не идентичен логину',
		'2'		=> 'пароль не содержит логин',
	],

	'LoginSection'				=> 'Login',
	'MaxLoginAttempts'			=> 'Maximum number of login attempts per username',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximum number of login attempts per IP address',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'LogSection'				=> 'Параметры журнала',
	'LogLevel'					=> 'Режим ведения журнала',
	'LogLevelInfo'				=> 'Минимальный приоритет событий, фиксируемых в логе.',
	'LogThresholds'	=> [
		'0'		=> 'не вести журнал',
		'1'		=> 'только критический уровень',
		'2'		=> 'от наивысшего уровня',
		'3'		=> 'от высокого уровня',
		'4'		=> 'от среднего уровня',
		'5'		=> 'от низкого уровня',
		'6'		=> 'от минимального уровня',
		'7'		=> 'фиксировать всё',
	],
	'LogDefaultShow'			=> 'Режим отображения журнала',
	'LogDefaultShowInfo'		=> 'Минимальный приоритет событий, отображаемых в логе по умолчанию.',
	'LogModes'	=> [
		'1'		=> 'только критический уровень',
		'2'		=> 'от наивысшего уровня',
		'3'		=> 'от высокого уровня',
		'4'		=> 'от среднего уровня',
		'5'		=> 'от низкого уровня',
		'6'		=> 'от минимального уровня',
		'7'		=> 'показывать всё',
	],
	'LogPurgeTime'				=> 'Срок хранения журнала',
	'LogPurgeTimeInfo'			=> 'Удалять события лога, старше данного числа дней.',

	'FormsSection'				=> 'Forms',
	'FormTokenTime'				=> 'Maximum time to submit forms',
	'FormTokenTimeInfo'			=> 'The time a user has to submit a form (in seconds).<br> Use -1 to disable. Note that a form might become invalid if the session expires, regardless of this setting.',

	'SessionLength'				=> 'Срок авторизующего cookie',
	'SessionLengthInfo'			=> 'Время жизни авторизующего пользовательского cookie по умолчанию (в днях).',
	'CommentDelay'				=> 'Анти-флуд для комментариев',
	'CommentDelayInfo'			=> 'Минимальная задержка между публикацией пользователем новых комментариев (в секундах).',
	'IntercomDelay'				=> 'Анти-флуд для личных сообщений',
	'IntercomDelayInfo'			=> 'Минимальная задержка между отправкой пользователем сообщений приватной связи (в секундах).',

	//Formatter settings
	'FormatterSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'FormatterSettingsUpdated'	=> 'Updated formatting settings',

	'TextHandlerSection'		=> 'Обработчики текста',
	'Typografica'				=> 'Типографический корректор',
	'TypograficaInfo'			=> 'Отключение незначительно ускорит процедуру добавления комментариев и сохранения страниц.',
	'Paragrafica'				=> 'Параграфическая разметка',
	'ParagraficaInfo'			=> 'Аналогично предыдущей опции, но отключение приведет к неработоспособности автоматических оглавлений: <code>{{toc}}</code>.',
	'AllowRawhtml'				=> 'Глобальная поддержка HTML',
	'AllowRawhtmlInfo'			=> 'Использование этой опции для открытого сайта потенциально небезопасно.',
	'SafeHtml'					=> 'Фильтрация HTML',
	'SafeHtmlInfo'				=> 'Блокирует сохранение опасных HTML-объектов. Выключать фильтр на открытом сайте при включенной поддержке HTML <span class="underline">крайне</span> нежелательно!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formatter)',
	'X11colors'					=> 'X11 Colors Usage',
	'X11colorsInfo'				=> 'Extents the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code>Unsetting slightly speeds up the process of adding comments and saving of pages.',
	'TikiLinks'					=> 'Disable Tikilinks',
	'TikiLinksInfo'				=> 'Disables linking for <code>Double.CamelCaseWords</code>.',
	'WikiLinks'					=> 'Disable Wikilinks',
	'WikiLinksInfo'				=> 'Disables linking for <code>CamelCaseWords</code>, your CamelCase Words will no longer be linked directly to a new page. This is useful when you work across different namespaces aks clusters. By default it is off.',
	'BracketsLinks'				=> 'Disable bracketslinks',
	'BracketsLinksInfo'			=> 'Disables <code>[[link]]</code> and <code>((link))</code> syntax.',
	'Formatters'				=> 'Disable Formatters',
	'FormattersInfo'			=> 'Disables <code>%%code%%</code> syntax, used for highlighters.',

	'DateFormatsSection'		=> 'Форматы дат',
	'DateFormat'				=> 'Формат даты',
	'DateFormatInfo'			=> '(день, месяц, год)',
	'TimeFormat'				=> 'Формат времени',
	'TimeFormatInfo'			=> '(часы, минуты)',
	'TimeFormatSeconds'			=> 'Формат точного времени',
	'TimeFormatSecondsInfo'		=> '(часы, минуты, секунды)',
	'NameDateMacro'				=> 'Формат макроса <code>::@::</code>',
	'NameDateMacroInfo'			=> '(имя, время), e.g. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Часовой пояс',
	'TimezoneInfo'				=> 'Timezone to use for displaying times to users who are not logged in (guests). Logged in users set and can change their timezone it in their user settings.',
	'EnableDst'					=> 'Enable Summer Time/DST',
	'EnableDstInfo'				=> '',

	'LinkTarget'				=> 'Where external links open',
	'LinkTargetInfo'			=> 'Opens each external link in a new browser window. Adds <code>target="_blank"</code> to the link syntax.',
	'Noreferrer'				=> 'noreferrer',
	'NoreferrerInfo'			=> 'Requires that the browser should not send an HTTP referer header if the user follows the hyperlink. Adds <code>rel="noreferrer"</code> to the link syntax.',
	'Nofollow'					=> 'nofollow',
	'NofollowInfo'				=> 'Instruct some search engines that the hyperlink should not influence the ranking of the link\'s target in the search engine\'s index. Adds <code>rel="nofollow"</code> to the link syntax.',
	'UrlsUnderscores'			=> 'Form addresses (URLs) with underscores',
	'UrlsUnderscoresInfo'		=> 'For example <code>http://[..]/WackoWiki</code> becames <code>http://[..]/Wacko_Wiki</code> with this option.',
	'ShowSpaces'				=> 'Show spaces in WikiNames',
	'ShowSpacesInfo'			=> 'Show spaces in WikiNames, e.g. <code>MyName</code> beeing displayed as <code>My Name</code> with this option.',
	'NumerateLinks'				=> 'Numerate links in print view',
	'NumerateLinksInfo'			=> 'Numerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disable and visualize self-referencing links',
	'YouareHereTextInfo'		=> 'Visualizing links to the same page, try to <code>&lt;b&gt;####&lt;/b&gt;</code>, all links-to-self became not links, but bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> '',
	'PagesSettingsUpdated'		=> 'Обновлены параметры служебных страниц',

	'ListCount'					=> 'Number of items per list',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> 'Параметры форума',
	'ForumCluster'				=> 'Кластер форума',
	'ForumClusterInfo'			=> 'Адрес индексной (главной) страницы форума.',
	'ForumTopics'				=> 'Количество тем на страницу',
	'ForumTopicsInfo'			=> 'Количество тем, отображаемых на каждой странице списка в разделах форума.',
	'CommentsCount'				=> 'Количество комментариев на страницу',
	'CommentsCountInfo'			=> 'Количество комментариев, отображаемых на каждой странице списка комментариев. Это относится ко всем комментариям на сайте, а не только размещенным в форуме.',

	'NewsSection'				=> 'Раздел новостей',
	'NewsCluster'				=> 'Кластер раздела новостей',
	'NewsClusterInfo'			=> 'Корень кластера новостного раздела.',
	'NewsLevels'				=> 'Глубина новостных страниц от корня кластера',
	'NewsLevelsInfo'			=> 'Регулярное выражение (regexp-слэнг SQL), определяющее количество промежуточных разделов от корня новостного кластера непосредственно до имен страниц новостных сообщений. (e.g. <code>[cluster]/[year]/[month]</code> -> <code>/.+/.+/.+</code>)',

	'LicenseSection'			=> 'License',
	'DefaultLicense'			=> 'Default license',
	'DefaultLicenseInfo'		=> 'Under which license should your content be released.',

	'ServicePagesSection'		=> 'Служебные страницы',
	'RootPage'					=> 'Главная страница',
	'RootPageInfo'				=> 'Тэг главной страницы, автоматически открываемой, когда пользователь посещает сайт.',
	'PolicyPage'				=> 'Политика и правила',
	'PolicyPageinfo'			=> 'Страница с правилами сайта.',
	'SearchPage'				=> 'Поиск',
	'SearchPageInfo'			=> 'Страница с формой поиска (действие <code>{{search}}</code>).',
	'RegistrationPage'			=> 'Регистрация на сайте',
	'RegistrationPageInfo'		=> 'Страница регистрации нового пользователя (действие <code>{{registration}}</code>).',
	'LoginPage'					=> 'Вход для пользователей',
	'LoginPageInfo'				=> 'Страница авторизации на сайте (действие <code>{{login}}</code>).',
	'SettingsPage'				=> 'Настройки профиля',
	'SettingsPageInfo'			=> 'Страница настройки пользовательского профиля (действие <code>{{usersettings}}</code>).',
	'PasswordPage'				=> 'Смена пароля',
	'PasswordPageInfo'			=> 'Страница с формой для изменения/запроса пользовательского пароля (действие <code>{{changepassword}}</code>).',
	'UsersPage'					=> 'Список пользователей',
	'UsersPageInfo'				=> 'Страница со списком зарегистрированных пользователей (действие <code>{{users}}</code>).',
	'CategoryPage'				=> 'Category',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action <code>{{category}}</code>).',
	'TagPage'					=> 'Tag',
	'TagPageInfo'				=> 'Page with a list of tagged pages (action <code>{{tag}}</code>).',
	'GroupsPage'				=> 'Список групп',
	'GroupsPageInfo'			=> 'Страница со списком рабочих групп (действие <code>{{usergroups}}</code>).',
	'ChangesPage'				=> 'Последние изменения',
	'ChangesPageInfo'			=> 'Страница со списком последних измененных документов (действие <code>{{changes}}</code>).',
	'CommentsPage'				=> 'Последние комментарии',
	'CommentsPageInfo'			=> 'Страница со списком последних прокомментированных документов (действие <code>{{commented}}</code>).',
	'RemovalsPage'				=> 'Удаленные документы',
	'RemovalsPageInfo'			=> 'Страница со списком недавно удаленных документов (действие <code>{{deleted}}</code>).',
	'WantedPage'				=> 'Пропущенные документы',
	'WantedPageInfo'			=> 'Страница со списком отсутствующих документов, на которые есть ссылки (действие <code>{{wanted}}</code>).',
	'OrphanedPage'				=> 'Забытые документы',
	'OrphanedPageInfo'			=> 'Страница со списком существующих документов, не связанных ссылками с остальными (действие <code>{{orphaned}}</code>).',
	'TodoPage'					=> 'Недоработки',
	'TodoPageInfo'				=> 'Страница со списком To Do (строится с помощью действия <code>{{backlinks}}</code> и макросов <code>::*::</code>).',
	'SandboxPage'				=> 'Песочница',
	'SandboxPageInfo'			=> 'Страница, где пользователи могут потренироваться в использовании wiki-разметки.',
	'WikiDocsPage'				=> 'Документация wiki',
	'WikiDocsPageInfo'			=> 'Раздел документации по работе с инструментами сайта.',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameters for notifications of the platform.',
	'NotificationSettingsUpdated'	=> 'Updated notification settings',

	'EmailNotification'			=> 'Email Notification',
	'EmailNotificationInfo'		=> 'Allow email notification. Set to ON to enable email notifications, OFF to disable them. Note that disabling email notifications has no effect on emails generated as part of the user signup process.',
	'Autosubscribe'				=> 'Автоподписка',
	'AutosubscribeInfo'			=> 'Автоматически подписывать владельца новой страницы на уведомления о ее изменениях.',

	'NotificationSection'		=> 'Default user notification settings',
	'NotifyPageEdit'			=> 'Notify page edit',
	'NotifyPageEditInfo'		=> 'Pending - Sending a email notification only for the first change until the user visits the page again.',
	'NotifyMinorEdit'			=> 'Notify minor edit',
	'NotifyMinorEditInfo'		=> 'Sends notifications also for minor edits.',
	'NotifyNewComment'			=> 'Notify new comment',
	'NotifyNewCommentInfo'		=> 'Pending - Sending a email notification only for the first comment until the user visits the page again.',
	'NotifyUserAccount'			=> 'Notify new user account',
	'NotifyUserAccountInfo'		=> 'The Admin will to be notified when a new user has been created using the "signup form".',


	// Resync settings
	'Synchronize'				=> 'синхронизировать',
	'UserStatsSynched'			=> 'Статистика пользователей синхронизирована.',
	'PageStatsSynched'			=> 'Page Statistics синхронизирована.',
	'FeedsUpdated'				=> 'RSS-каналы обновлены.',
	'SiteMapCreated'			=> 'The new version of the site map created successfully.',
	'WikiLinksRestored'			=> 'Wiki-ссылки восстановлены.',

	'LogUserStatsSynched'		=> 'Статистика пользователей синхронизирована.',
	'LogPageStatsSynched'		=> 'Статистика страниц синхронизирована.',
	'LogFeedsUpdated'			=> 'RSS-каналы обновлены.',

	'UserStats'					=> 'Пользовательская статистика',
	'UserStatsInfo'				=> 'Статистика пользователей (количество комментариев, страниц во владении, revisions и files) в некоторых ситуациях может расходиться с реальными данными. <br>Эта операция позволяет пересчетать статистику по текущим фактическим данным БД.',
	'PageStats'					=> 'Page статистика',
	'PageStatsInfo'				=> 'Page статистика (количество комментариев, files и revisions) в некоторых ситуациях может расходиться с реальными данными. <br>Эта операция позволяет пересчетать статистику по текущим фактическим данным БД.',
	'Feeds'						=> 'RSS-каналы',
	'FeedsInfo'					=> 'В случае прямой правки документов в базе данных, содержание RSS-фидов не отразит сделанных изменений. Данная функция синхронизирует RSS-каналы с текущим состоянием БД.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'WikiLinksResync'			=> 'Wiki-ссылки',
	'WikiLinksResyncInfo'		=> 'Выполняет повторный рендеринг всех внутрисайтовых ссылок и восстанавливает содержимое таблицы <code>page_link</code> и <code>file_link</code> в случае ее порчи или повреждений (может занять значительное время).',

	// Email settings
	'EmaiSettingsInfo'			=> 'Эта информация используется для отправки конференцией email-сообщений пользователям. Удостоверьтесь в правильности указанных email-адресов, все возвращённые или не доставленные сообщения будут, вероятно, отправлены на них. Если ваш сервер не обеспечивает использование встроенной (в PHP) службы email, вы можете отправлять сообщения напрямую с использованием SMTP. Для этого необходим адрес подходящего сервера (если нужно, спросите об этом у провайдера). Если сервер требует аутентификации (и только в этом случае), введите необходимые имя, пароль и метод аутентификации.',

	'EmailSettingsUpdated'		=> 'Updated Email settings',

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
	'UploadSettingsUpdated'		=> 'Updated upload settings',

	'RightToUpload'				=> 'Right to the upload files',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belongig to admins group can upload the files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadOnlyImages'			=> 'Загружать только изображения',
	'UploadOnlyImagesInfo'		=> 'Разрешить загрузку только графических файлов на страницы сайта.',
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

	// Deleted module
	'DeletedObjectsInfo'		=> 'Перечень удаленных документов и файлы, копии которых остались в таблице редакций.
									Окончательно удалить или восстановить документ или файл из базы данных можно, нажав на ссылку <em>Удалить</em>
									в соответствующей строке. (Будьте осторожны, подтверждение на удаление не запрашивается!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Words that will be automatically censored on your Wiki.',
	'FilterSettingsUpdated'		=> 'Updated spam filter settings',

	'WordCensoringSection'		=> 'Word censoring',
	'SPAMFilter'				=> 'SPAM Filter',
	'SPAMFilterInfo'			=> 'Enabling SPAM Filter',
	'WordList'					=> 'Word list',
	'WordListInfo'				=> 'Word or phrase <code>fragment</code> to be blacklisted (one per line)',

	// DB Convert module
	'Convert'					=> 'convert',
	'NoColumnsToConvert'		=> 'No columns to convert.',
	'NoTablesToConvert'			=> 'No tables to convert.',

	'LogDatabaseConverted'		=> 'Database converted',
	'ConversionTablesOk'		=> 'Conversion of the selected tables successfully.',

	'LogColumsToStrict'			=> 'Converted colums to comply with the SQL strict mode',
	'ConversionColumnsOk'		=> 'Conversion of the selected columns successfully.',

	'ConvertTablesEngine'		=> 'Converting Tables from MyISAM to InnoDB/XtraDB',
	'ConvertTablesEngineInfo'	=> 'If you have existing tables, that you want to convert to InnoDB/XtraDB* for better reliability and scalability, use the following routine. These tables were originally MyISAM, which was formerly the default.',
	'ConvertTablesEngineHint'	=> '* XtraDB is an enhanced version of the InnoDB storage engine, designed to better scale on modern hardware, and it includes a variety of other features useful in high performance environments.<br><br>It is fully backwards compatible, and it identifies itself to MariaDB as "<code>ENGINE=InnoDB</code>" (just like InnoDB), and so can be used as a drop-in replacement for standard InnoDB.',

	'DbVersion'					=> 'Requires at least MySQL 5.6.4, available version',
	'DbEngineOk'				=> 'InnoDB/XtraDB is available.',
	'DbEngineMissing'			=> 'InnoDB / XtraDB is not available.',
	'EngineTable'				=> 'Table',
	'EngineDefault'				=> 'Default',
	'EngineColumn'				=> 'Column',
	'EngineTyp'					=> 'Type',

	'ConvertColumnsToStrict'	=> 'Converting Columns to SQL strict',
	'ConvertTablesStrictInfo'	=> 'If you have existing tables, that you want to convert to comply with the SQL srtict mode, use the following routine.',

	// Log module
	'LogFilterTip'				=> 'Отфильтровать события по критериям',
	'LogLevel'					=> 'Уровень',
	'LogLevelFilters'	=> [
		'1'		=> 'не ниже, чем',
		'2'		=> 'не выше, чем',
		'3'		=> 'соответствует',
	],
	'LogNoMatch'				=> 'Нет событий, удовлетворяющих критериям',
	'LogDate'					=> 'Дата',
	'LogEvent'					=> 'Событие',
	'LogUsername'				=> 'Пользователь',
	'LogLevels'	=> [
		'1'		=> 'Критический',
		'2'		=> 'Наивысший',
		'3'		=> 'Высокий',
		'4'		=> 'Средний',
		'5'		=> 'Низкий',
		'6'		=> 'Минимальный',
		'7'		=> 'Отладочный',
	],

	// Massemail module
	'MassemailInfo'				=> 'С помощью этой вики вы можете отправить электронное сообщение всем пользователям или пользователям определённой группы, <strong>имеющим включённую опцию получения электронных сообщений</strong>. Для достижения этого сообщение будет отправлено с электронного адреса администратора и будет снабжено скрытой копией для всех получателей. По умолчанию такое сообщение включает максимум 20 получателей. Если получателей больше, то будет отправлено несколько сообщений. Если вы отправляете сообщение большой группе людей, то это действие может занять некоторое время. Пожалуйста, будьте терпеливы и не останавливайте загрузку страницы после отправки сообщения. Вы будете уведомлены об успешном завершении отправки.',
	'LogMassemail'				=> 'Messemail send %1 to group / user ',
	'MassemailSend'				=> 'Massemail send',

	'NoEmailMessage'			=> 'Необходимо ввести текст сообщения',
	'NoEmailSubject'			=> 'Необходимо указать заголовок сообщения',

	'MessageSubject'			=> 'Subject',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Текст сообщения',
	'YourMessageInfo'			=> 'Можно использовать только обычный текст. Вся разметка будет удалена перед отправкой.',

	'MessageLanguage'			=> 'Language',
	'MessageLanguageInfo'		=> '',
	'SendMail'					=> 'Send',

	'SendToGroup'				=> 'Послать группе',
	'SendToUser'				=> 'Послать пользователю',

	// System message module
	'SysMsgInfo'				=> '',
	'SysMsgUpdated'				=> 'Updated system message',

	'SysMsgSection'				=> 'System message',
	'SysMsg'					=> 'System message',
	'SysMsgInfo'				=> 'Your text here',

	'SysMsgType'				=> 'Type',
	'SysMsgTypeInfo'			=> 'Message type (CSS).',
	'EnableSysMsg'				=> 'Enable system message',
	'EnableSysMsgInfo'			=> 'Show system message.',

	// User approval module
	'ApproveNotExists'			=> 'Please select at least one user via the Set button.',

	'LogUserApproved'			=> 'User ##%1## approved',
	'LogUserBlocked'			=> 'User ##%1## blocked',
	'LogUserDeleted'			=> 'User ##%1## removed from the database',
	'LogUserCreated'			=> 'Created a new user ##%1##',
	'LogUserUpdated'			=> 'Updated User ##%1##',

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
	'BackupSettings'			=> 'Укажите требуемую схему резервирования. ' .
									'Корневой кластер не влияет на резервное копирование глобальных файлов и файлов кэша (при их выборе они всегда сохраняются полностью).<br> ' .
									'<br> ' .
									'<strong>Внимание</strong>: во избежание потери информации из базы данных WackoWiki, при указании корня кластера, таблицы из данной резервной копии не будут реструктуризированы, ' .
									'аналогично, при резервировании только структуры таблицы без сохранения данных. ' .
									'Для полной конвертации таблиц в формат резервной копии необходимо произвести <em>полное резервирование всей базы данных (структура и содержимое) без указания кластера</em>.',
	'BackupCompleted'			=> 'Резервное копирование и архивация завершены.<br>' .
									'Пакет резервной копии сохранен в папке с названием %1.<br>' .
									'Для его получения используйте FTP (не забудьте при копировании сохранять структуру каталогов и имена файлов и директорий).<br>' .
									'Восстановить резервную копию или удалить пакет можно в разделе <a href="%2">Восстановление</a>.',
	'LogSavedBackup'			=> 'Сохранена резервная копия базы данных ##%1##',

	// DB Restore module
	'RestoreInfo'				=> 'Вы можете восстановить любой из найденных резервных пакетов, либо удалить его с сервера.',
	'ConfirmDbRestore'			=> 'Вы хотите восстановить резервную копию',
	'ConfirmDbRestoreInfo'		=> 'Пожалуйста, подождите. Это может занять несколько минут.',
	'RestoreWrongVersion'		=> 'Неправильная версия WackoWiki!',
	'BackupDelete'				=> 'Вы уверены, что хотите удалить резервную копию',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Дополнительные опции для восстановления',
	'RestoreOptionsInfo'		=> '* Перед восстановлением резервной копии <strong>кластера</strong> WackoWiki, ' .
									'целевые таблицы не уничтожаются (дабы предотвратить потерю информации из незарезервированных кластеров). ' .
									'Таким образом, в процессе восстановления будут встречаться дублированные записи. ' .
									'В обычном режиме все они будут заменены записями из резервной копии (с помощью SQL-инструкции <code>REPLACE</code>), <br>' .
									'но если этот флажок установлен, все дубликаты будут пропущены (будут сохранены текущие значения записей), <br>' .
									'а добавлены в таблицу только записи с новыми ключами (SQL-инструкцией <code>INSERT IGNORE</code>).<br>' .
									'<strong>Заметьте</strong>: при восстановлении полной резервной копии сайта эта опция не имеет значения.<br> ' .
									'<br> ' .
									'** Если резервная копия содержит пользовательские файлы (глобальные и постраничные, файлы кэша и пр.), то в обычном режиме при восстановлении они заменят одноименные файлы, размещенные в тех же каталогах. ' .
									'Эта опция позволяет сохранить текущие копии файлов, а восстановить из резервной копии только новые (отсутствующие на сервере) файлы. ',
	'IgnoreDuplicatedKeys'		=> 'Игнорировать дубликатные ключи таблицы (не заменять)',
	'IgnoreSameFiles'			=> 'Игнорировать одноименные файлы (не перезаписывать)',
	'NoBackupsAvailable'		=> 'Резервные копии отсутствуют.',
	'BackupEntireSite'			=> 'Весь сайт',
	'BackupRestored'			=> 'Резервная копия восстановлена, отчет выполнения приложен ниже. Чтобы удалить данную резервную копию, нажмите здесь',
	'BackupRemoved'				=> 'Выбранная резервная копия успешно удалена.',
	'LogRemovedBackup'			=> 'Удалена резервная копия базы данных ##%1##',

	'RestoreStarted'			=> 'НАЧАТО ВОССТАНОВЛЕНИЕ РЕЗЕРВНОЙ КОПИИ',
	'RestoreParameters'			=> 'Используем параметры',
	'IgnoreDublicatedKeys'		=> 'Игнорировать дубликатные ключи',
	'IgnoreDublicatedFiles'		=> 'Игнорировать дубликатные файлы',
	'SavedCluster'				=> 'Сохранен кластер',
	'DataProtection'			=> 'Защита данных - %1 опущен',
	'AssumeDropTable'			=> 'Предполагаем %1',
	'RestoreTableStructure'		=> 'Восстановление структуры таблиц',
	'RunSqlQueries'				=> 'Выполняем SQL-инструкции',
	'CompletedSqlQueries'		=> 'Завершено. Обработано инструкций',
	'NoTableStructure'			=> 'Структура таблиц не сохранена - пропускаем',
	'RestoreRecords'			=> 'Восстановление содержимого таблиц',
	'ProcessTablesDump'			=> 'Загружаем и обрабатываем дамп таблиц',
	'Instruction'				=> 'инструкция',
	'RestoredRecords'			=> 'записей',
	'RecordsRestoreDone'		=> 'Завершено. Итог записей',
	'SkippedRecords'			=> 'Данные не сохранены - пропускаем',
	'RestoringFiles'			=> 'Восстановление файлов',
	'DecompressAndStore'		=> 'Распаковываем и сохраняем содержимое директорий',
	'HomonymicFiles'			=> 'одноименные файлы',
	'RestoreSkip'				=> 'пропускать',
	'RestoreReplace'			=> 'замещать',
	'RestoreFile'				=> 'файлов',
	'Restored'					=> 'записано',
	'Skipped'					=> 'пропущено',
	'FileRestoreDone'			=> 'Завершено. Итог файлов',
	'FilesAll'					=> 'всего',
	'SkipFiles'					=> 'Файлы не сохранены - пропускаем',
	'RestoreDone'				=> 'ВОССТАНОВЛЕНИЕ ЗАВЕРШЕНО',

	'BackupCreationDate'		=> 'Дата создания',
	'BackupPackageContents'		=> 'Содержимое пакета',
	'BackupRestore'				=> 'восстановить',
	'BackupRemove'				=> 'удалить',
	'RestoreYes'				=> 'ДА',
	'RestoreNo'					=> 'НЕТ',
	'LogDbRestored'				=> 'Восстановлена резервная копия базы данных ##%1##.',

	// User module
	'UsersInfo'					=> 'Here you can change your users information and certain specific options.',

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
	'GroupsInfo'				=> 'From this panel you can administrate all your usergroups. You can delete, create and edit existing groups. Furthermore, you may choose group leaders, toggle open/hidden/closed group status and set the group name and description.',

	'LogMembersUpdated'			=> 'Updated usergroup members',
	'LogMemberAdded'			=> 'Added member ##%1## into group ##%2##',
	'LogMemberRemoved'			=> 'Removed member ##%1## from group ##%2##',
	'LogGroupCreated'			=> 'Created a new group ##%1##',
	'LogGroupRenamed'			=> 'Group ##%1## renamed to ##%2##',
	'LogGroupRemoved'			=> 'Removed group ##%1##',

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

	// Statistics module
	'DbStatSection'				=> 'Статистика базы данных',
	'DbTable'					=> 'Таблица',
	'DbRecords'					=> 'Строк',
	'DbSize'					=> 'Объем',
	'DbIndex'					=> 'Индекс',
	'DbOverhead'				=> 'Фрагментация',
	'DbTotal'					=> 'Всего',

	'FileStatSection'			=> 'Статистика файловой системы',
	'FileFolder'				=> 'Каталог',
	'FileFiles'					=> 'Файлов',
	'FileSize'					=> 'Объем',
	'FileTotal'					=> 'Всего',

	// Sysinfo module
	'SysInfo'					=> 'Version informations',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Values',

	'WackoVersion'				=> 'Wacko version',
	'LastWackoUpdate'			=> 'Last update',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Server name',
	'WebServer'					=> 'Web server',
	'DbVersion'					=> 'MariaDB / MySQL version',
	'SQLModesGlobal'			=> 'SQL Modes Global',
	'SQLModesSession'			=> 'SQL Modes Session',
	'PhpVersion'				=> 'PHP Version',
	'MemoryLimit'				=> 'Memory',
	'UploadFilesizeMax'			=> 'Upload max filesize',
	'PostMaxSize'				=> 'Post max size',
	'MaxExecutionTime'			=> 'Max execution time',
	'SessionPath'				=> 'Session path',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip compression',
	'PHPExtensions'				=> 'PHP extensions',
	'ApacheModules'				=> 'Apache modules',

	// DB repair module
	'DbRepairSection'			=> 'Repair Database',
	'DbRepair'					=> 'Repair Database',
	'DbRepairInfo'				=> 'This script can automatically look for some common database problems and repair them. Repairing can take a while, so please be patient.',

	'DbOptimizeRepairSection'	=> 'Repair and Optimize Database',
	'DbOptimizeRepair'			=> 'Repair and Optimize Database',
	'DbOptimizeRepairInfo'		=> 'This script can also attempt to optimize the database. This improves performance in some situations. Repairing and optimizing the database can take a long time and the database will be locked while optimizing.',

	'TableOk'					=> 'The %1 table is okay.',
	'TableNotOk'				=> 'The %1 table is not okay. It is reporting the following error: %2. This script will attempt to repair this table&hellip;',
	'TableRepaired'				=> 'Successfully repaired the %1 table.',
	'TableRepairFailed'			=> 'Failed to repair the %1 table. <br>Error: %2',
	'TableAlreadyOptimized'		=> 'The %1 table is already optimized.',
	'TableOptimized'			=> 'Successfully optimized the %1 table.',
	'TableOptimizeFailed'		=> 'Failed to optimize the %1 table. <br>Error: %2',
	'TableNotRepaired'			=> 'Some database problems could not be repaired.',
	'RepairsComplete'			=> 'Repairs complete',

	// Transliterate module
	'TranslitField'				=> 'Транслитерировать поле %1 в таблице  `%2`.',
	'TranslitStart'				=> 'пуск',
	'TranslitContinue'			=> 'продолжить',
	'TranslitCompleted'			=> 'Процедура обновления завершена.',


];

?>
