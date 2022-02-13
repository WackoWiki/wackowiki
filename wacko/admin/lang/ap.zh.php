<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'					=> '注意：建议暂时禁止访问该站点以进行管理维护。',

	'CategoryArray'		=> [
		'basics'		=> '基本功能',
		'preferences'	=> '偏好',
		'content'		=> '内容',
		'users'			=> '用户',
		'maintenance'	=> '维护',
		'messages'		=> '消息',
		'extension'		=> '扩展',
		'database'		=> '数据库',
	],

	// Admin panel
	'AdminPanel'				=> '管理面板',
	'RecoveryMode'				=> '恢复模式',
	'Authorization'				=> '身份认证',
	'AuthorizationTip'			=> '请输入管理密码 （同时确保您的浏览器中允许的 cookie）。',
	'NoRecoveryPassword'		=> '未指定管理密码 ！',
	'NoRecoveryPasswordTip'		=> '注意：没有管理密码会对安全构成威胁！请在配置文件中输入您的密码，然后再次运行程序。',

	'ErrorLoadingModule'		=> '加载管理模块 %1时出错：不存在。',

	'ApHomePage'				=> '主页',
	'ApHomePageTip'				=> '打开主页，您不会退出管理',
	'ApLogOut'					=> '退出',
	'ApLogOutTip'				=> '退出管理',

	'TimeLeft'					=> '剩余时间:  %1 分钟',
	'ApVersion'					=> '版本',

	'SiteOpen'					=> '打开',
	'SiteOpened'				=> '站点已开启',
	'SiteOpenedTip'				=> '该站点已启用',
	'SiteClose'					=> '关闭',
	'SiteClosed'				=> '网站已关闭',
	'SiteClosedTip'				=> '网站已关闭',

	// Generic
	'Cancel'					=> '取消',
	'Add'						=> '添加',
	'Edit'						=> '編輯',
	'Remove'					=> '删除',
	'Enabled'					=> '启用',
	'Disabled'					=> '禁用',
	'Mandatory'					=> '必填',
	'Admin'						=> '管理',

	'MiscellaneousSection'		=> '杂项',
	'MainSection'				=> '常规',

	'DirNotWritable'			=> '%1 目录不可写.',

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
		'name'		=> '基本',
		'title'		=> '基本设置',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> '外观',
		'title'		=> '外观设置',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> '电子邮件',
		'title'		=> '邮件设置',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> '过滤',
		'title'		=> '过滤设置',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> '格式化',
		'title'		=> '格式化选项',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> '通知',
		'title'		=> '通知设置',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> '页面',
		'title'		=> '页面和站点参数',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> '权限',
		'title'		=> '权限设置',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> '安全',
		'title'		=> '安全子项设置',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> '系统',
		'title'		=> '系统选项',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> '上传',
		'title'		=> '附件设置',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> '刪除',
		'title'		=> '新删除的内容',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> '菜单',
		'title'		=> '添加、编辑或删除默认菜单项',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> '备份',
		'title'		=> '正在备份数据',
	],

	// DB Convert module
	'db_convert'		=> [
		'name'		=> '转换',
		'title'		=> '转换表或列',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> '修复',
		'title'		=> '修复和优化数据库',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> '恢复',
		'title'		=> '正在恢复备份数据',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> '主菜单',
		'title'		=> 'WackoWiki 管理',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> '不一致',
		'title'		=> '修复数据不一致问题',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> '数据同步',
		'title'		=> '正在同步',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> '群发邮件',
		'title'		=> '群发邮件',
	],

	// System message module
	'messages'		=> [
		'name'		=> '系统消息',
		'title'		=> '系统消息',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> '系统信息',
		'title'		=> '系统信息',
	],

	// System log module
	'system_log'		=> [
		'name'		=> '系统日志',
		'title'		=> '系统事件记录',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> '统计',
		'title'		=> '显示统计信息',
	],

	// Bad Behavior module
	'tool_badbehavior'		=> [
		'name'		=> '错误行为',
		'title'		=> '错误行为',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> '审核',
		'title'		=> '用户注册审核',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> '群组',
		'title'		=> '组管理',
	],

	// User module
	'user_users'		=> [
		'name'		=> '用户',
		'title'		=> '用户管理',
	],

	// Main module
	'PurgeSessions'				=> '清除',
	'PurgeSessionsTip'			=> '清除所有会话',
	'PurgeSessionsConfirm'		=> '您确定要清除所有会话吗？这将注销所有用户。',
	'PurgeSessionsExplain'		=> '清除所有会话。这将通过截断auth_token 表来注销所有用户。',
	'PurgeSessionsDone'			=> '会话已成功清除。',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> '已更新基本设置',
	'LogBasicSettingsUpdated'	=> '已更新基本设置',

	'SiteName'					=> '站点名称',
	'SiteNameInfo'				=> '网站名称将显示在浏览器标题、主题标题、电子邮件通知等。',
	'SiteDesc'					=> '站点描述',
	'SiteDescInfo'				=> '补充页面头部中显示的站点标题，用几个字解释这个站点是什么。',
	'AdminName'					=> '站点管理',
	'AdminNameInfo'				=> '用户名，负责网站的整体支持。 此名称不用于确定访问权限，但最好与站点首席管理员的名称一致。',

	'LanguageSection'			=> '语言',
	'DefaultLanguage'			=> '默认语言',
	'DefaultLanguageInfo'		=> '指定未注册访客以及区域设置中显示的消息语言。',
	'MultiLanguage'				=> '多语言支持',
	'MultiLanguageInfo'			=> '启用按页面选择语言的功能。',
	'AllowedLanguages'			=> '允许使用的语言',
	'AllowedLanguagesInfo'		=> '建议仅选择您要使用的语言集，否则选择所有语言。',

	'CommentSection'			=> '评论',
	'AllowComments'				=> '允许评论',
	'AllowCommentsInfo'			=> '仅为访客或注册用户启用评论或在整个站点禁用它们。',
	'SortingComments'			=> '评论排序',
	'SortingCommentsInfo'		=> '更改页面评论的顺序，或者是最新的或是最老的评论在顶部。',

	'ToolbarSection'			=> '工具栏',
	'CommentsPanel'				=> '评论面板',
	'CommentsPanelInfo'			=> '附件默认显示在页面底部。',
	'FilePanel'					=> '文件面板',
	'FilePanelInfo'				=> '附件默认显示在页面底部。',
	'TagsPanel'					=> '标签面板',
	'TagsPanelInfo'				=> '标签面板默认显示在页面底部。',

	'NavigationSection'			=> '导航',
	'ShowPermalink'				=> '显示永久链接',
	'ShowPermalinkInfo'			=> '当前版本的永久链接默认显示.',
	'TocPanel'					=> '目录面板',
	'TocPanelInfo'				=> '页面的默认显示目录面板（可能需要模板支持）。',
	'SectionsPanel'				=> '区段面板',
	'SectionsPanelInfo'			=> '默认显示相邻页面的面板（需要模板支持）。',
	'DisplayingSections'		=> '显示部分',
	'DisplayingSectionsInfo'	=> '当上一个选项时，是否只显示页面的子页面(<em>较低</em>) 只有邻居(<em>顶部</em>)或两者和其他(<em>tree</em>)。',
	'MenuItems'					=> '菜单项',
	'MenuItemsInfo'				=> '默认显示菜单项数量 (可能需要模板中的支持)。',

	'HandlerSection'			=> '处理器',
	'HideRevisions'				=> '隐藏修订版本',
	'HideRevisionsInfo'			=> '默认显示页面的修订版。',
	'AttachmentHandler'			=> '启用附件处理程序',
	'AttachmentHandlerInfo'		=> '允许显示附件处理程序。',
	'SourceHandler'				=> '启用源代码处理器',
	'SourceHandlerInfo'			=> '允许显示源代码处理器。',
	'ExportHandler'				=> '启用 XML 导出处理器',
	'ExportHandlerInfo'			=> '允许显示附件处理程序。',

	'FeedsSection'				=> '订阅',
	'EnableFeeds'				=> '启用Feeds',
	'EnableFeedsInfo'			=> '打开或关闭整个维基的 RSS 源.',

	'XmlSitemap'				=> 'XML 网站地图',
	'XmlSitemapInfo'			=> '在 xml 文件夹中创建名为 %1 的 XML 文件。 您可以在您的根目录中的 roots.txt 文件中将路径添加到站点地图：',
	'XmlSitemapGz'				=> 'XML 网站地图压缩',
	'XmlSitemapGzInfo'			=> '如果你愿意，你可以使用 gzip 压缩你的站点地图文本文件，以减少你的带宽要求。',
	'XmlSitemapTime'			=> 'XML 网站地图生成时间',
	'XmlSitemapTimeInfo'		=> '在给定的天数内仅生成一次站点地图，零表示每次页面更改均生成。',

	'SearchSection'				=> '搜尋',
	'OpenSearch'				=> '开放搜索',
	'OpenSearchInfo'			=> '在XML文件夹中创建OpenSearch描述文件，并在HTML标题中启用搜索插件的Autodiscovery。',
	'SearchEngineVisibility'	=> '屏蔽搜索引擎 (搜索引擎可见性)',
	'SearchEngineVisibilityInfo'=> '屏蔽搜索引擎，但允许正常访客。覆盖页面设置。 <br>阻止搜索引擎索引此站点。它取决于搜索引擎来满足此请求。',

	'DiffModeSection'			=> '差异模式',
	'DefaultDiffModeSetting'	=> '默认差异模式',
	'DefaultDiffModeSettingInfo'=> '预选的差异模式。',
	'AllowedDiffMode'			=> '允许的差异模式',
	'AllowedDiffModeInfo'		=> '建议仅选择您要使用的差异模式集，否则将选择所有差异模式。',
	'NotifyDiffMode'			=> '通知差异模式',
	'NotifyDiffModeInfo'		=> '用于电子邮件正文中通知的差异模式。',

	'EditingSection'			=> '编辑中',
	'EditSummary'				=> '簡述您的修改',
	'EditSummaryInfo'			=> '在编辑模式下显示修改摘要。',
	'MinorEdit'					=> '這是一個細微的更改v',
	'MinorEditInfo'				=> '在编辑模式下启用次要的编辑选项。',
	'ReviewSettings'			=> '审阅',
	'ReviewSettingsInfo'		=> '在编辑模式下启用次要的编辑选项。',
	'PublishAnonymously'		=> '允许匿名发布',
	'PublishAnonymouslyInfo'	=> '允许用户匿名发布(隐藏名称)。',

	'DefaultRenameRedirect'		=> '重命名时重定向',
	'DefaultRenameRedirectInfo'	=> '默认情况下，要设置重定向到重定向页面的旧地址。',
	'StoreDeletedPages'			=> '保留已删除页面',
	'StoreDeletedPagesInfo'		=> '当您删除一个页面、一个评论或一个文件时，将其保留在一个特殊的章节中。 如上文所述，将在更长的时间内进行审查和追回(见下文)。',
	'KeepDeletedTime'			=> '已删除页面的存储时间',
	'KeepDeletedTimeInfo'		=> 'The period in days. It makes sense only with the previous option. Zero indicates the eternal possession (in this case the administrator can clear the "cart" manually).',
	'PagesPurgeTime'			=> '页面修订的存储时间',
	'PagesPurgeTimeInfo'		=> '在给定天数内自动删除旧版本。如果您输入零，旧版本将不会被删除。',
	'EnableReferrers'			=> '启用来源项',
	'EnableReferrersInfo'		=> '允许存储和显示外部引用。',
	'ReferrersPurgeTime'		=> '引用的存储时间',
	'ReferrersPurgeTimeInfo'	=> '保持引用外部页面的历史不超过给定的天数。 零意味着永久存储，但对于一个积极访问的站点，这可能导致数据库溢出。',
	'EnableCounters'			=> '点击计数器',
	'EnableCountersInfo'		=> '允许每个页面点击计数器并允许显示简单的统计数据。页面所有者的视图不被计数。',

	// Appearance settings
	'AppearanceSettingsInfo'	=> '控制网站默认显示设置。',
	'AppearanceSettingsUpdated'	=> '更新外观设置。',

	'LogoOff'					=> '关闭',
	'LogoOnly'					=> '网站标志(Logo)',
	'LogoAndTitle'				=> 'LOGO和标题',

	'LogoSection'				=> '标识logo',
	'SiteLogo'					=> '站点LOGO',
	'SiteLogoInfo'				=> '您的LOGO一般会出现在左上角。 最大2 MiB。最优尺寸为 255 X55 像素。',
	'LogoDimensions'			=> 'LOGO尺寸',
	'LogoDimensionsInfo'		=> '显示的 Logo 的宽度和高度',
	'LogoDisplayMode'			=> 'LOGO显示模式',
	'LogoDisplayModeInfo'		=> '定义Logo的外观。默认关闭。',
	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> '网站Favicon',
	'SiteFaviconInfo'			=> '您的快捷图标或收藏夹显示在大多数浏览器的地址栏、标签和书签中。这将覆盖您主题的图标。',
	'SiteFaviconTooBig'			=> 'Favicon is bigger than 64 × 64px.',
	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Theme',
	'ThemeInfo'					=> 'Template design the site uses by default.',
	'ResetUserTheme'			=> 'Reset all user themes',
	'ResetUserThemeInfo'		=> 'Resets all user themes. Warning: This action will set back all user selected themes to the global default theme.',
	'SetBackUserTheme'			=> 'Set back all user themes to %1 theme.',
	'ThemesAllowed'				=> 'Allowed Themes',
	'ThemesAllowedInfo'			=> 'Select the allowed themes, which the user can choose, otherwise all available themes are allowed.',
	'ThemesPerPage'				=> 'Themes per page',
	'ThemesPerPageInfo'			=> 'Allow themes per page, which the page owner can choose via page properties.',
	'ThemeColor'				=> '地址栏的主题颜色',
	'ThemeColorInfo'			=> '浏览器会根据所提供的CSS颜色来设置每个页面的地址栏颜色。',

	// System settings
	'SystemSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'SystemSettingsUpdated'		=> 'Updated system settings',

	'DebugModeSection'			=> 'Debug mode',
	'DebugMode'					=> 'Debug mode',
	'DebugModeInfo'				=> 'Fixation and the withdrawal of telemetry data on the time of the program. Note: the full detail of the regime imposes high demands on available memory, especially in demanding operations such as backup and restore the database.',
	'DebugModes'	=> [
		'0'		=> 'debugging is off',
		'1'		=> 'only the total execution time',
		'2'		=> 'full-time',
		'3'		=> 'full detail (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Threshold performance RDBMS',
	'DebugSqlThresholdInfo'		=> 'In the detailed debug mode to record only the queries take longer than the number of seconds.',
	'DebugAdminOnly'			=> '已关闭的诊断程序',
	'DebugAdminOnlyInfo'		=> '仅为管理员显示程序的调试数据 (和 DBMS)。',

	'CachingSection'			=> '缓存设置',
	'Cache'						=> '缓存已呈现页面',
	'CacheInfo'					=> '在本地缓存中保存呈现的页面以加速后续引导。仅对未注册访客有效。',
	'CacheTtl'					=> '字段相关缓存页面',
	'CacheTtlInfo'				=> '缓存页面不超过指定的秒数。',
	'CacheSql'					=> '缓存 DBMS 查询',
	'CacheSqlInfo'				=> '保持本地缓存某些资源 SQL 查询的结果。',
	'CacheSqlTtl'				=> '字段相关缓存数据库',
	'CacheSqlTtlInfo'			=> '缓存不超过指定秒数的 SQL 查询结果。使用超过 1200 的值是不可取的。',

	'PrivacySection'			=> '隐私政策',
	'AnonymizeIp'				=> '匿名用户 IP 地址',
	'AnonymizeIpInfo'			=> '匿名IP地址，如页面、修订或推荐。',

	'ReverseProxySection'		=> '反向代理',
	'ReverseProxy'				=> '使用反向代理',
	'ReverseProxyInfo'			=> '启用此设置以确定远程的正确 IP 地址客户端通过检查存储在 X-Forwarded-For 标头中的信息。X-Forwarded-For 标头是识别客户端的标准机制通过反向代理服务器连接的系统，例如 Squid 或磅。 反向代理服务器通常用于增强性能访问量大的站点，还可能提供其他站点缓存，安全或加密的好处。 如果此 WackoWiki 安装运行在反向代理之后，应启用此设置，以便正确IP 地址信息在 WackoWiki 的会话管理中捕获，日志、统计和访问管理系统； 如果你不确定关于这个设置，没有反向代理，或者 ackoWiki 在共享主机环境，此设置应保持禁用状态。',
	'ReverseProxyHeader'		=> '反向代理标头',
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

	'SessionSection'				=> 'Session handling',
	'SessionStorage'				=> 'Session storage',
	'SessionStorageInfo'			=> '此选项定义会话数据存储的位置。默认情况下选择文件或数据库会话存储。',
	'SessionModes'	=> [
		'1'		=> '文件',
		'2'		=> '数据库',
	],

	'RewriteMode'					=> '使用 <code>mod_rewrite</code>',
	'RewriteModeInfo'				=> '如果您的网络服务器支持此功能，请转而获取“漂亮”的页面地址。<br>
<span class="cite">该值可能在运行时被设置类覆盖，无论它是否被关闭，如果 HTTP_MOD_REWRITE 是打开的。',

	// Permissions settings
	'PermissionsSettingsInfo'		=> '负责进出控制和权限的参数。',
	'PermissionsSettingsUpdated'	=> '已更新权限设置',

	'PermissionsSection'		=> '权利和豁免',
	'ReadRights'				=> '默认阅读权利',
	'ReadRightsInfo'			=> '他们被分配到创建的根页以及不能确定上级权利的页面。',
	'WriteRights'				=> '默认阅读权利',
	'WriteRightsInfo'			=> '他们被分配到创建的根页以及不能确定上级权利的页面。',
	'CommentRights'				=> '默认阅读权利',
	'CommentRightsInfo'			=> '他们被分配到创建的根页以及不能确定上级权利的页面。',
	'CreateRights'				=> '默认创建子页面的权限',
	'CreateRightsInfo'			=> 'Define the right for creating root pages and assign them to pages for which parental rights cannot be defined.',
	'UploadRights'				=> '默认上传权限',
	'UploadRightsInfo'			=> '他们被分配到创建的根页以及不能确定上级权利的页面。',
	'RenameRights'				=> 'Global rename right',
	'RenameRightsInfo'			=> 'The list of permissions to freely rename (move) pages.',

	'LockAcl'					=> 'Lock all ACL to read only',
	'LockAclInfo'				=> '<span class="cite">Overwrites the acl settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period for security reasons or as a emergency response.',
	'HideLocked'				=> 'Hide inaccessible pages',
	'HideLockedInfo'			=> 'If the user does not have permission to read the page, hide it in different page lists (however the link placed in text, will still be visible).',
	'RemoveOnlyAdmins'			=> 'Only administrators can delete pages',
	'RemoveOnlyAdminsInfo'		=> 'Deny all, except administrators, to delete pages. In the first limit applies to owners of normal pages.',
	'OwnersRemoveComments'		=> 'Owners of pages can delete comments',
	'OwnersRemoveCommentsInfo'	=> 'Allow page owners to moderate comments on their pages.',
	'OwnersEditCategories'		=> 'Owners can edit page categories',
	'OwnersEditCategoriesInfo'	=> 'Allow owners to modify the pages category list of your site (add words, delete words), assigns to a page.',
	'TermHumanModeration'		=> 'Term human moderation',
	'TermHumanModerationInfo'	=> 'Moderators can only edit comments if they were created no more than this number of days ago (this limitation does not apply to the last comment in the topic).',

	'UserCanDeleteAccount'		=> 'Allow users to delete their accounts',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parameters responsible for the overall safety of the platform, safety restrictions and additional security subsystems.',
	'SecuritySettingsUpdated'	=> 'Updated security settings',

	'AllowRegistration'			=> 'Register online',
	'AllowRegistrationInfo'		=> 'Open user registration. Disabling this option will prevent free registration, however, the site administrator will be able to register other users himself.',
	'ApproveNewUser'			=> 'Approve new users',
	'ApproveNewUserInfo'		=> 'Allows Administrators to approve users once they register. Only approved users will be allowed to log in the site.',
	'PersistentCookies'			=> 'Persistent cookies',
	'PersistentCookiesInfo'		=> 'Allow persistent cookies.',
	'DisableWikiName'			=> 'Disable WikiName',
	'DisableWikiNameInfo'		=> 'Disable the the mandatory use of WikiName. Allows to register users with traditional nicknames, not forced NameSurname.',
	'AllowEmailReuse'			=> 'Allow email address re-use',
	'AllowEmailReuseInfo'		=> 'Different users can register with the same e-mail address.',
	'UsernameLength'			=> 'Username length',
	'UsernameLengthInfo'		=> 'Minimum and maximum number of characters in usernames.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Enable Captcha',
	'EnableCaptchaInfo'			=> 'If enabled, Captcha will be shown in the following cases or if a security threshold is reached.',
	'CaptchaComment'			=> 'New comment',
	'CaptchaCommentInfo'		=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before posting the comment.',
	'CaptchaPage'				=> 'New page',
	'CaptchaPageInfo'			=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before creating a new pages.',
	'CaptchaEdit'				=> 'Edit page',
	'CaptchaEditInfo'			=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before editing pages.',
	'CaptchaRegistration'		=> '註冊',
	'CaptchaRegistrationInfo'	=> 'As a measure of protection against spam publications require unregistered users a single solution of the test before registering.',

	'TlsSection'				=> 'TLS Settings',
	'TlsConnection'				=> 'TLS-Connection',
	'TlsConnectionInfo'			=> 'Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS-certificate on the server, otherwise you will lose access to the admin panel!</span><br>It also determines if the the Cookie Secure Flag is set, the <code>secure</code> flag specifies whether cookies should only be sent over secure connections.',
	'TlsImplicit'				=> 'Mandatory TLS',
	'TlsImplicitInfo'			=> 'Forcibly reconnect the client from HTTP to HTTPS. With the option disabled, the client can browse the site through an open HTTP channel.',

	'HttpSecurityHeaders'		=> 'HTTP Security Headers',
	'EnableSecurityHeaders'		=> 'Enable Security Headers',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk !',
	'Csp'						=> 'Content-Security-Policy (CSP)',
	'CspInfo'					=> 'Configuring Content Security Policy involves deciding what policies you want to enforce, and then configuring them and using Content-Security-Policy to establish your policy.',
	'PolicyModes'	=> [
		'0'		=> 'disabled',
		'1'		=> 'strict',
		'2'		=> 'custom',
	],
	'PermissionsPolicy'			=> 'Permissions Policy',
	'PermissionsPolicyInfo'		=> 'The HTTP Permissions-Policy header provides a mechanism to explicitly enable or disable various powerful browser features.',
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

	'UserPasswordSection'		=> 'Persistence of user passwords',
	'PwdMinChars'				=> 'Minimum password length',
	'PwdMinCharsInfo'			=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 12 to 16 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'AdminPwdMinChars'			=> 'Minimum Admin password length',
	'AdminPwdMinCharsInfo'		=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 15 to 20 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'PwdCharComplexity'			=> 'The required password complexity',
	'PwdCharClasses'	=> [
		'0'		=> 'not tested',
		'1'		=> 'any letters + numbers',
		'2'		=> 'uppercase and lowercase + numbers',
		'3'		=> 'uppercase and lowercase + numbers + characters',
	],
	'PwdUnlikeLogin'			=> 'Additional complication',
	'PwdUnlikes'	=> [
		'0'		=> 'not tested',
		'1'		=> 'password is not identical to the login',
		'2'		=> 'password does not contain username',
	],

	'LoginSection'				=> '登录',
	'MaxLoginAttempts'			=> 'Maximum number of login attempts per username',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximum number of login attempts per IP address',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'LogSection'				=> 'Log settings',
	'LogLevelUsage'				=> 'Using logging',
	'LogLevelInfo'				=> 'The minimum priority of the events recorded in the log.',
	'LogThresholds'	=> [
		'0'		=> 'not keep a journal',
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high',
		'4'		=> 'on average',
		'5'		=> 'from low',
		'6'		=> 'the minimum level',
		'7'		=> 'record all',
	],
	'LogDefaultShow'			=> 'Display Log Mode',
	'LogDefaultShowInfo'		=> 'The minimum priority events displayed in the log by default.',
	'LogModes'	=> [
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high-level',
		'4'		=> 'the average',
		'5'		=> 'from a low',
		'6'		=> 'from the minimum level',
		'7'		=> 'show all',
	],
	'LogPurgeTime'				=> 'Storage time of Log',
	'LogPurgeTimeInfo'			=> 'Remove event log over a given number of days.',

	'FormsSection'				=> 'Forms',
	'FormTokenTime'				=> 'Maximum time to submit forms',
	'FormTokenTimeInfo'			=> 'The time a user has to submit a form (in seconds).<br> Note that a form might become invalid if the session expires, regardless of this setting.',

	'SessionLength'				=> 'Term login cookie',
	'SessionLengthInfo'			=> 'The lifetime of the user cookie login by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of the new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications',
	'IntercomDelayInfo'			=> 'The minimum delay between sending a private message user connection (in seconds).',
	'RegistrationDelay'			=> 'Time threshold for registering',
	'RegistrationDelayInfo'		=> 'The minimum time threshold for filling out the registration form to tell away bots from humans (in seconds).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'FormatterSettingsUpdated'	=> 'Updated formatting settings',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> 'Typographical Proofreader',
	'TypograficaInfo'			=> 'Unsetting slightly speed up the process of adding comments and save the page.',
	'Paragrafica'				=> 'Paragrafica markings',
	'ParagraficaInfo'			=> 'Similar to the previous option, but will lead to disconnection of inoperable automatic table of contents: <code>{{toc}}</code>.',
	'AllowRawhtml'				=> 'Global HTML Support',
	'AllowRawhtmlInfo'			=> 'This option is potentially unsafe for an open site.',
	'SafeHtml'					=> 'Filtering HTML',
	'SafeHtmlInfo'				=> 'Prevents saving of dangerous HTML-objects. Turning off the filter on an open site with HTML support is <span class="underline">extremely</span> undesirable!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formatter)',
	'X11colors'					=> 'X11 Colors Usage',
	'X11colorsInfo'				=> 'Extents the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code>Unsetting slightly speeds up the process of adding comments and saving of pages.',
	'WikiLinks'					=> 'Disable Wikilinks',
	'WikiLinksInfo'				=> 'Disables linking for <code>CamelCaseWords</code>, your CamelCase Words will no longer be linked directly to a new page. This is useful when you work across different namespaces aks clusters. By default it is off.',
	'BracketsLinks'				=> 'Disable bracketslinks',
	'BracketsLinksInfo'			=> 'Disables <code>[[link]]</code> and <code>((link))</code> syntax.',
	'Formatters'				=> 'Disable Formatters',
	'FormattersInfo'			=> 'Disables <code>%%code%%</code> syntax, used for highlighters.',

	'DateFormatsSection'		=> 'Date Formats',
	'DateFormat'				=> 'The format of the date',
	'DateFormatInfo'			=> '(day, month, year)',
	'TimeFormat'				=> 'The format of time',
	'TimeFormatInfo'			=> '(hour, minute)',
	'TimeFormatSeconds'			=> 'The format of the exact time',
	'TimeFormatSecondsInfo'		=> '(hours, minutes, seconds)',
	'NameDateMacro'				=> 'The format of the <code>::@::</code> macro',
	'NameDateMacroInfo'			=> '(name, time), e.g. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> '时区',
	'TimezoneInfo'				=> 'Timezone to use for displaying times to users who are not logged in (guests). Logged in users set and can change their timezone it in their user settings.',

	'Canonical'					=> 'Use fully canonical URLs',
	'CanonicalInfo'				=> 'All links are created as absolute URLs in the form %1. URLs relative to the server root in the form %2 should be preferred.',
	'LinkTarget'				=> 'Where external links open',
	'LinkTargetInfo'			=> 'Opens each external link in a new browser window. Adds <code>target="_blank"</code> to the link syntax.',
	'Noreferrer'				=> 'noreferrer',
	'NoreferrerInfo'			=> 'Requires that the browser should not send an HTTP referer header if the user follows the hyperlink. Adds <code>rel="noreferrer"</code> to the link syntax.',
	'Nofollow'					=> 'nofollow',
	'NofollowInfo'				=> 'Tells search engines that the hyperlinks should not affect the page ranking of the target page in the search engine index. Adds <code>rel="nofollow"</code> to the link syntax.',
	'UrlsUnderscores'			=> 'Form addresses (URLs) with underscores',
	'UrlsUnderscoresInfo'		=> 'For example %1 becames %2 with this option.',
	'ShowSpaces'				=> 'Show spaces in WikiNames',
	'ShowSpacesInfo'			=> 'Show spaces in WikiNames, e.g. <code>MyName</code> being displayed as <code>My Name</code> with this option.',
	'NumerateLinks'				=> 'Numerate links in print view',
	'NumerateLinksInfo'			=> 'Numerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disable and visualize self-referencing links',
	'YouareHereTextInfo'		=> 'Visualizing links to the same page, try to <code>&lt;b&gt;####&lt;/b&gt;</code>, all links-to-self became not links, but bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Here you can set or change the system base pages used within the Wiki. Please ensure you not forget to create or change the corresponding pages in the Wiki according your settings here.',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Number of items per list',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster Forum',
	'ForumClusterInfo'			=> 'Root cluster for forum section (action %1).',
	'ForumTopics'				=> 'Number of topics per page',
	'ForumTopicsInfo'			=> 'Number of topics displayed on each page of the list in the forum sections (action %1).',
	'CommentsCount'				=> 'Number of comments per page',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page list of comments. This applies to all the comments on the site, and not just posted in the forum.',

	'NewsSection'				=> 'Section News',
	'NewsCluster'				=> 'Cluster for the News',
	'NewsClusterInfo'			=> 'Root cluster for news section (action %1).',
	'NewsStructure'				=> 'News cluster structure',
	'NewsStructureInfo'			=> 'Stores the articles optionally in sub-clusters by year/month or week (e.g. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'License',
	'DefaultLicense'			=> 'Default license',
	'DefaultLicenseInfo'		=> 'Under which license should your content be released.',
	'EnableLicense'				=> 'Enable License',
	'EnableLicenseInfo'			=> 'Enable to show license information.',
	'LicensePerPage'			=> 'License per page',
	'LicensePerPageInfo'		=> 'Allow license per page, which the page owner can choose via page properties.',

	'ServicePagesSection'		=> 'Service pages',
	'RootPage'					=> 'Home page',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',

	'PrivacyPage'				=> 'Privacy Policy',
	'PrivacyPageInfo'			=> 'The page with the Privacy Policy of the site.',

	'TermsPage'					=> 'Policies and Regulations',
	'TermsPageInfo'				=> 'The page with the rules of the site.',

	'SearchPage'				=> '搜尋',
	'SearchPageInfo'			=> 'Page with the search form (action %1).',
	'RegistrationPage'			=> '註冊',
	'RegistrationPageInfo'		=> 'Page new user registration (action %1).',
	'LoginPage'					=> 'User login',
	'LoginPageInfo'				=> 'Login page on the site (action %1).',
	'SettingsPage'				=> 'User Settings',
	'SettingsPageInfo'			=> 'Page customize the user profile (action %1).',
	'PasswordPage'				=> 'Change Password',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action %1).',
	'UsersPage'					=> 'User list',
	'UsersPageInfo'				=> 'Page with a list of registered users (action %1).',
	'CategoryPage'				=> '分类',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action %1).',
	'TagPage'					=> 'Tag',
	'TagPageInfo'				=> 'Page with a list of tagged pages (action %1).',
	'GroupsPage'				=> '群组',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action %1).',
	'ChangesPage'				=> 'Recent changes',
	'ChangesPageInfo'			=> 'Page with a list of the last modified pages (action %1).',
	'CommentsPage'				=> 'Recent comments',
	'CommentsPageInfo'			=> 'Page with a list of recent comment on the page (action %1).',
	'RemovalsPage'				=> 'Deleted pages',
	'RemovalsPageInfo'			=> 'Page with a list of recently deleted pages (action %1).',
	'WantedPage'				=> 'Wanted pages',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action %1).',
	'OrphanedPage'				=> 'Orphaned pages',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related links with the rest (action %1).',
	'SandboxPage'				=> 'Sandbox',
	'SandboxPageInfo'			=> 'Page where users can be trained in the use of wiki-markup.',
	'HelpPage'					=> '帮助',
	'HelpPageInfo'				=> 'The documentation section for working with site tools.',
	'IndexPage'					=> 'Index',
	'IndexPageInfo'				=> 'Page with a list of all pages (action %1).',
	'RandomPage'				=> 'Random',
	'RandomPageInfo'			=> 'Loads a random page (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameters for notifications of the platform.',
	'NotificationSettingsUpdated'	=> 'Updated notification settings',

	'EmailNotification'			=> 'Email Notification',
	'EmailNotificationInfo'		=> 'Allow email notification. Set to ON to enable email notifications, OFF to disable them. Note that disabling email notifications has no effect on emails generated as part of the user signup process.',
	'Autosubscribe'				=> 'Autosubscribe',
	'AutosubscribeInfo'			=> 'Automatically sign a new page in the owner\'s notice of its changes.',

	'NotificationSection'		=> 'Default user notification settings',
	'NotifyPageEdit'			=> 'Notify page edit',
	'NotifyPageEditInfo'		=> 'Pending - Sending a email notification only for the first change until the user visits the page again.',
	'NotifyMinorEdit'			=> 'Notify minor edit',
	'NotifyMinorEditInfo'		=> 'Sends notifications also for minor edits.',
	'NotifyNewComment'			=> 'Notify new comment',
	'NotifyNewCommentInfo'		=> 'Pending - Sending a email notification only for the first comment until the user visits the page again.',

	'NotifyUserAccount'			=> 'Notify new user account',
	'NotifyUserAccountInfo'		=> 'The Admin will to be notified when a new user has been created using the signup form.',
	'NotifyUpload'				=> 'Notify file upload',
	'NotifyUploadInfo'			=> 'The Moderators will to be notified when a file has been uploaded.',

	'PersonalMessagesSection'	=> 'Personal messages',
	'AllowIntercomDefault'		=> 'Allow Intercom',
	'AllowIntercomDefaultInfo'	=> 'Enable this option allows other users sending personal messages to the recipient email-address without disclosing the address.',
	'AllowMassemailDefault'		=> 'Allow Massemail',
	'AllowMassemailDefaultInfo'	=> 'It send only messages to those user who allowed Administrators to email them information.',

	// Resync settings
	'Synchronize'				=> 'Synchronize',
	'UserStatsSynched'			=> 'User Statistics synchronized.',
	'PageStatsSynched'			=> 'Page Statistics synchronized.',
	'FeedsUpdated'				=> 'RSS-feeds updated.',
	'SiteMapCreated'			=> 'The new version of the site map created successfully.',
	'ParseNextBatch'			=> 'Parse next batch of pages:',
	'WikiLinksRestored'			=> 'Wiki-links restored.',

	'LogUserStatsSynched'		=> 'Synchronized user statistics',
	'LogPageStatsSynched'		=> 'Synchronized page statistics',
	'LogFeedsUpdated'			=> 'Synchronized RSS feeds',
	'LogPageBodySynched'		=> 'Reparsed page body and links',

	'UserStats'					=> 'User Statistics',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'PageStats'					=> 'Page statistics',
	'PageStatsInfo'				=> 'Page statistics (number of comments, files and revisions) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'In the case of direct editing of pages in the database, the content of RSS-feeds may not reflect the changes made. <br>This function synchronizes the RSS-channels with the current state of the database.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'XmlSiteMapPeriod'			=> 'Period %1 days. Last written %2.',
	'XmlSiteMapView'			=> 'Show Sitemap in a new window.',

	'ReparseBody'				=> 'Reparse all pages',
	'ReparseBodyInfo'			=> 'Empties <code>body_r</code> in page table, so that each page gets rendered again on the next page view. This may be useful if you modified the formatter or changed the domain of your wiki.',
	'PreparsedBodyPurged'		=> 'Emptied <code>body_r</code> field in page table.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Performs a re-rendering for all intrasite links and restores the contents of the table <code>page_link</code> and <code>file_link</code> in the event of damage or relocation (this can take considerable time).',
	'RecompilePage'				=> 'Re-compiling all pages (extremely costly)',
	'ResyncOptions'				=> 'Additional options',
	'RecompilePageLimit'		=> 'Number of pages to parse at once.',

	// Email settings
	'EmaiSettingsInfo'			=> 'This information is used when the engine sends emails to your users. Please ensure the email address you specify is valid, any bounced or undeliverable messages will likely be sent to that address. If your host does not provide a native (PHP based) email service you can instead send messages directly using SMTP. This requires the address of an appropriate server (ask your provider if necessary). If the server requires authentication (and only if it does) enter the necessary username, password and authentication method.',

	'EmailSettingsUpdated'		=> 'Updated Email settings',

	'EmailFunctionName'			=> 'Email function name',
	'EmailFunctionNameInfo'		=> 'The email function used to send mails through PHP.',
	'UseSmtpInfo'				=> 'Select <code>SMTP</code> if you want or have to send email via a named server instead of the local mail function.',

	'EnableEmail'				=> 'Enable emails',
	'EnableEmailInfo'			=> 'Enabling emails',

	'FromEmailName'				=> 'From Name',
	'FromEmailNameInfo'			=> 'The sender name, part of <code>From:</code> header in emails for all the email-notification sent from the site.',
	'NoReplyEmail'				=> 'No-reply address',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all your email-notifications sent from the site.',
	'AdminEmail'				=> 'Email of the site owner',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.',

	'SendTestEmail'				=> 'Send a test email',
	'SendTestEmailInfo'			=> 'This will send a test email to the address defined in your account.',
	'TestEmailSubject'			=> 'Your Wiki is correctly configured to send emails',
	'TestEmailBody'				=> 'If you received this email, your Wiki is correctly configured to send emails.',
	'TestEmailMessage'			=> 'The test email has been sent.<br>If you don\'t receive it, please check your emails configuration.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Connection mode for SMTP',
	'SmtpConnectionModeInfo'	=> 'Only used if a username/password is set, ask your provider if you are unsure which method to use.',
	'SmtpPassword'				=> 'SMTP password',
	'SmtpPasswordInfo'			=> 'Only enter a password if your SMTP server requires it.<br><em><strong>Warning:</strong> This password will be stored as plain text in the database, visible to everybody who can access your database or who can view this configuration page.</em>',
	'SmtpPort'					=> 'SMTP server port',
	'SmtpPortInfo'				=> 'Only change this if you know your SMTP server is on a different port. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'SMTP server address',
	'SmtpServerInfo'			=> 'Note that you have to provide the protocol that your server uses. If you are using SSL, this has to be <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> 'SMTP settings',
	'SmtpUsername'				=> 'SMTP username',
	'SmtpUsernameInfo'			=> 'Only enter a username if your SMTP server requires it.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Here you can configure the main settings for attachments and the associated special categories.',
	'UploadSettingsUpdated'		=> 'Updated upload settings',

	'RightToUpload'				=> 'Right to the upload files',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belonging to the admins group can upload  files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadOnlyImages'			=> 'Allow only upload of images',
	'UploadOnlyImagesInfo'		=> 'Allow only uploading of image files on the page.',
	'FileUploads'				=> 'File uploads',
	'UploadMaxFilesize'			=> 'Maximum file size',
	'UploadMaxFilesizeInfo'		=> 'Maximum size of each file. If this value is 0, the uploadable filesize is only limited by your PHP configuration.',
	'UploadQuota'				=> 'Total attachment quota',
	'UploadQuotaInfo'			=> 'Maximum drive space available for attachments for the whole wiki, with <code>0</code> being unlimited.',
	'UploadQuotaUser'			=> 'Storage quota per user',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with <code>0</code> being unlimited.',
	'CheckMimetype'				=> 'Check attachment files',
	'CheckMimetypeInfo'			=> 'Some browsers can be tricked to assume an incorrect mimetype for uploaded files. This option ensures that such files likely to cause this are rejected.',
	'TranslitFileName'			=> 'Transliterate file names',
	'TranslitFileNameInfo'		=> 'If it is applicable and there is no need to have Unicode characters, it is highly recommended to only accept Alpha-Numeric characters.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Create thumbnail',
	'CreateThumbnailInfo'		=> 'Create a thumbnail in all possible situations.',
	'MaxThumbWidth'				=> 'Maximum thumbnail width in pixel',
	'MaxThumbWidthInfo'			=> 'A generated thumbnail will not exceed the width set here.',
	'MinThumbFilesize'			=> 'Minimum thumbnail file size',
	'MinThumbFilesizeInfo'		=> 'Do not create a thumbnail for images smaller than this.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'List of removed pages, revisions and files.
									Finally remove or restore the pages, revisions or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Words that will be automatically censored on your Wiki.',
	'FilterSettingsUpdated'		=> 'Updated spam filter settings',

	'WordCensoringSection'		=> 'Word censoring',
	'SPAMFilter'				=> 'SPAM Filter',
	'SPAMFilterInfo'			=> 'Enabling SPAM Filter',
	'WordList'					=> 'Word list',
	'WordListInfo'				=> 'Word or phrase <code>fragment</code> to be blacklisted (one per line)',

	// DB Convert module
	'NoColumnsToConvert'		=> 'No columns to convert.',
	'NoTablesToConvert'			=> 'No tables to convert.',

	'LogDatabaseConverted'		=> 'Database converted',
	'ConversionTablesOk'		=> 'Conversion of the selected tables successfully.',

	'LogColumnsToStrict'		=> 'Converted columns to comply with the SQL strict mode',
	'ConversionColumnsOk'		=> 'Conversion of the selected columns successfully.',

	'ConvertTablesEngine'		=> 'Converting Tables from MyISAM to InnoDB',
	'ConvertTablesEngineInfo'	=> 'If you have existing tables, that you want to convert to InnoDB for better reliability and scalability, use the following routine. These tables were originally MyISAM, which was formerly the default.',

	'DbVersionMin'				=> 'Requires at least MySQL 5.6.4, available version',
	'DbEngineOk'				=> 'InnoDB is available.',
	'DbEngineMissing'			=> 'InnoDB is not available.',
	'EngineTable'				=> 'Table',
	'EngineDefault'				=> 'Default',
	'EngineColumn'				=> 'Column',
	'EngineTyp'					=> 'Type',

	'ConvertColumnsToStrict'	=> 'Converting Columns to SQL strict',
	'ConvertTablesStrictInfo'	=> 'If you have existing tables, that you want to convert to comply with the SQL strict mode, use the following routine.',

	// Log module
	'LogFilterTip'				=> 'Filter events by criteria',
	'LogLevel'					=> 'Level',
	'LogLevelFilters'	=> [
		'1'		=> 'not less than',
		'2'		=> 'not higher than',
		'3'		=> 'equal',
	],
	'LogNoMatch'				=> 'No events that meet the criteria',
	'LogDate'					=> 'Date',
	'LogEvent'					=> 'Event',
	'LogUsername'				=> '用户名',
	'LogLevels'	=> [
		'1'		=> 'critical',
		'2'		=> 'highest',
		'3'		=> 'high',
		'4'		=> 'medium',
		'5'		=> 'low',
		'6'		=> 'lowest',
		'7'		=> 'debugging',
	],

	// Massemail module
	'MassemailInfo'				=> 'Here you can email a message to either all of your users or all users of a specific group having the option to receive mass emails enabled. To achieve this an email will be sent out to the administrative email address supplied, with a blind carbon copy sent to all recipients. The default setting is to only include 20 recipients in such an email, for more recipients more emails will be sent. If you are emailing a large group of people please be patient after submitting and do not stop the page halfway through. It is normal for a mass emailing to take a long time, you will be notified when the script has completed.',
	'LogMassemail'				=> 'Messemail send %1 to group / user ',
	'MassemailSend'				=> 'Massemail send',

	'NoEmailMessage'			=> 'You must enter a message.',
	'NoEmailSubject'			=> 'You must specify a subject for your message.',
	'NoEmailRecipient'			=> 'You must specify at least one user or user group.',

	'MassemailSection'			=> 'Mass email',
	'MessageSubject'			=> '主题',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Your message',
	'YourMessageInfo'			=> 'Please note that you may enter only plain text. All markup will be removed before sending.',

	'NoUser'					=> 'No user',
	'NoUserGroup'				=> 'No user group',

	'SendToGroup'				=> 'Send to group',
	'SendToUser'				=> 'Send to user',
	'SendToUserInfo'			=> 'It send only messages to those user who allowed Administrators to email them information. This option is available in their user settings under Notifications.',

	// System message module
	'SystemMessageInfo'			=> '',
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

	'UserApproveInfo'			=> 'Approve new users before they are able to login to the site.',
	'Approve'					=> 'Approve',
	'Deny'						=> 'Deny',
	'Pending'					=> 'Pending',
	'Approved'					=> 'Approved',
	'Denied'					=> 'Denied',

	// DB Backup module
	'BackupStructure'			=> 'Structure',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Folder',
	'BackupTable'				=> 'Table',
	'BackupCluster'				=> 'Cluster',
	'BackupFiles'				=> '文件',
	'BackupSettings'			=> 'Specify the desired scheme of Backup.<br>' .
									'The root cluster does not affect the global files backup and cache files backup (being chosen they are always saved in full).<br>' .
									'<br>' .
									'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster the tables from this backup will not be restructured, ' .
									'same when backing up only table structure without saving the data. ' .
									'To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Backing up and archiving completed.<br>' .
									'The Backup package files were stored in the sub-directory %1.<br>' .
									'To download it use FTP (maintain the directory structure and file names when copying).<br>' .
									'To restore a backup copy or remove a package, go to <a href="%2">Restore database</a>.',
	'LogSavedBackup'			=> 'Saved backup database ##%1##',
	'Backup'					=> 'Backup',

	// DB Restore module
	'RestoreInfo'				=> 'You can restore any of the backup packages found or remove it from the server.',
	'ConfirmDbRestore'			=> 'Do you want to restore backup %1?',
	'ConfirmDbRestoreInfo'		=> 'Please wait this can take some minutes.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'DirectoryNotExecutable'	=> 'The %1 directory is not executable.',
	'BackupDelete'				=> 'Are you sure you want to remove backup %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Additional restore options',
	'RestoreOptionsInfo'		=> '* Before restoring the <strong>cluster backup</strong>, ' .
									'the target tables are not deleted (to prevent loss of information from the clusters that have not been backed up). ' .
									'Thus, during the recovery process duplicate records will occur. ' .
									'In normal mode, all of them will be replaced by the records form backup (using SQL-instruction <code>REPLACE</code>), ' .
									'but if this checkbox is checked, all duplicates are skipped (the current values of records will be kept), ' .
									'and only the records with new keys are added to the table (SQL-instruction <code>INSERT IGNORE</code>).<br>' .
									'<strong>Notice</strong>: When restore complete backup of the site, this option has no value.<br>' .
									'<br>' .
									'** If the backup contains the user files (global and perpage, cache files, etc.), ' .
									'in normal mode they replace the existing files with the same names and are placed in the same directory when being restored. ' .
									'This option allows you to save the current copies of the files and restore from a backup only new files (missing on the server).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignore duplicated table keys (not replace)',
	'IgnoreSameFiles'			=> 'Ignore same files (not overwrite)',
	'NoBackupsAvailable'		=> 'No backups available.',
	'BackupEntireSite'			=> 'Entire site',
	'BackupRestored'			=> 'The backup is restored, a summary report is attached below. To delete this backup package, click',
	'BackupRemoved'				=> 'The selected backup has been successfully removed.',
	'LogRemovedBackup'			=> 'Removed database backup ##%1##',

	'RestoreStarted'			=> 'Initiated Restoration',
	'RestoreParameters'			=> 'Using parameters',
	'IgnoreDuplicatedKeys'		=> 'Ignore duplicated keys',
	'IgnoreDuplicatedFiles'		=> 'Ignore duplicated files',
	'SavedCluster'				=> 'Saved cluster',
	'DataProtection'			=> 'Data Protection - %1 omitted',
	'AssumeDropTable'			=> 'Assume %1',
	'RestoreTableStructure'		=> 'Restoring the structure of the table',
	'RunSqlQueries'				=> 'Perform SQL-instructions',
	'CompletedSqlQueries'		=> 'Completed. Processed instructions',
	'NoTableStructure'			=> 'The structure of the tables was not saved - skip',
	'RestoreRecords'			=> 'Restore the contents of tables',
	'ProcessTablesDump'			=> 'Just download and process tables dump',
	'Instruction'				=> 'Instruction',
	'RestoredRecords'			=> 'records',
	'RecordsRestoreDone'		=> 'Completed. Total entries',
	'SkippedRecords'			=> 'Data not saved - skip',
	'RestoringFiles'			=> 'Restoring files',
	'DecompressAndStore'		=> 'Decompress and store the contents of directories',
	'HomonymicFiles'			=> 'homonymic files',
	'RestoreSkip'				=> 'skip',
	'RestoreReplace'			=> 'replace',
	'RestoreFile'				=> '文件',
	'Restored'					=> 'restored',
	'Skipped'					=> 'skipped',
	'FileRestoreDone'			=> 'Completed. Total files',
	'FilesAll'					=> '全部',
	'SkipFiles'					=> 'Files are not stored - skip',
	'RestoreDone'				=> 'RESTORATION COMPLETED',

	'BackupCreationDate'		=> 'Creation Date',
	'BackupPackageContents'		=> 'The contents of the package',
	'BackupRestore'				=> '恢复',
	'BackupRemove'				=> '删除',
	'RestoreYes'				=> 'Yes',
	'RestoreNo'					=> 'No',
	'LogDbRestored'				=> 'Backup ##%1## of the database restored.',

	// User module
	'UsersInfo'					=> 'Here you can change your users information and certain specific options.',

	'UsersAdded'				=> 'User added',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> '編輯',
	'UsersAddNew'				=> 'Add new user',
	'UsersDelete'				=> 'Are you sure you want to remove user %1?',
	'UsersDeleted'				=> 'The user %1 was deleted from the database.',
	'UsersRename'				=> 'Rename the user %1 to',
	'UsersRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that user.',
	'UsersUpdated'				=> 'User successfully updated.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Signuptime',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'No users that meet the criteria',

	'UserAccountNotify'			=> 'Notify user',
	'UserNotifySignup'			=> 'inform the user about the new account',
	'UserVerifyEmail'			=> 'set email confirm token and add link for email verification',
	'UserReVerifyEmail'			=> 'Re-send email confirm token',

	// Groups module
	'GroupsInfo'				=> 'From this panel you can administrate all your usergroups. You can delete, create and edit existing groups. Furthermore, you may choose group leaders, toggle open/hidden/closed group status and set the group name and description.',

	'LogMembersUpdated'			=> 'Updated usergroup members',
	'LogMemberAdded'			=> 'Added member ##%1## to group ##%2##',
	'LogMemberRemoved'			=> 'Removed member ##%1## from group ##%2##',
	'LogGroupCreated'			=> 'Created a new group ##%1##',
	'LogGroupRenamed'			=> 'Group ##%1## renamed to ##%2##',
	'LogGroupRemoved'			=> 'Removed group ##%1##',

	'GroupsMembersFor'			=> 'Members for Group',
	'GroupsDescription'			=> '描述',
	'GroupsModerator'			=> '版主',
	'GroupsOpen'				=> 'Open',
	'GroupsActive'				=> 'Active',
	'GroupsTip'					=> 'Click to edit Group',
	'GroupsUpdated'				=> 'Groups updated',
	'GroupsAlreadyExists'		=> 'This group already exists.',
	'GroupsAdded'				=> 'Group added successfully.',
	'GroupsRenamed'				=> 'Group successfully renamed.',
	'GroupsDeleted'				=> 'The group %1 was deleted from the database and all pages.',
	'GroupsAdd'					=> 'Add a new group',
	'GroupsRename'				=> 'Rename the group %1 to',
	'GroupsRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that group.',
	'GroupsDelete'				=> 'Are you sure you want to remove group %1?',
	'GroupsDeleteInfo'			=> '* Note: Change will affect all members that are assigned to that group.',
	'GroupsIsSystem'			=> 'The group %1 belongs to the system and cannot be removed.',
	'GroupsStoreButton'			=> 'Save Groups',
	'GroupsEditInfo'			=> 'To edit the groups list select the radio button.',

	'GroupAddMember'			=> 'Add member',
	'GroupRemoveMember'			=> 'Remove Member',
	'GroupAddNew'				=> 'Add group',
	'GroupEdit'					=> 'Edit Group',
	'GroupDelete'				=> 'Remove Group',

	'MembersAddNew'				=> 'Add new member',
	'MembersAdded'				=> 'Added new member to the group successfully.',
	'MembersRemove'				=> 'Are you sure you want to remove member %1?',
	'MembersRemoved'			=> 'The member was removed from the group.',
	'MembersDeleteInfo'			=> '* Note: Change will affect all members that are assigned to that group.',

	// Statistics module
	'DbStatSection'				=> 'Database Statistics',
	'DbTable'					=> 'Table',
	'DbRecords'					=> 'Records',
	'DbSize'					=> '大小',
	'DbIndex'					=> 'Index',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'File system Statistics',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> '文件',
	'FileSize'					=> '大小',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Version informations',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Values',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Last update',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Server name',
	'WebServer'					=> 'Web server',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'SQL Modes Global',
	'SqlModesSession'			=> 'SQL Modes Session',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memory',
	'UploadFilesizeMax'			=> 'Upload max filesize',
	'PostMaxSize'				=> 'Post max size',
	'MaxExecutionTime'			=> 'Max execution time',
	'SessionPath'				=> 'Session path',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip compression',
	'PhpExtensions'				=> 'PHP extensions',
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

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Show and fix inconsistencies, delete or assign orphaned records to a new user / value.',
	'Inconsistencies'			=> 'Inconsistencies',
	'CheckDatabase'				=> '数据库',
	'CheckDatabaseInfo'			=> 'Checks for record inconsistencies in the database.',
	'CheckFiles'				=> '文件',
	'CheckFilesInfo'			=> 'Checks for abandoned files, files with no reference left in the file table.',
	'Records'					=> 'Records',
	'InconsistenciesNone'		=> 'No Data Inconsistencies found.',
	'InconsistenciesDone'		=> 'Data Inconsistencies solved.',
	'InconsistenciesRemoved'	=> 'Removed inconsistencies',
	'Check'						=> 'Check',
	'Solve'						=> 'Solve',

	// Bad Behavior module
	'BbInfo'					=> 'Detects and blocks unwanted Web accesses, deny automated spambots access<br>For more information please visit the %1 homepage.',
	'BbEnable'					=> 'Enable Bad Behavior',
	'BbEnableInfo'				=> 'All other settings can be changed in the config folder %1.',
	'BbStats'					=> 'Bad Behavior has blocked %1 access attempts in the last 7 days.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Log',
	'BbSettings'				=> '设置',
	'BbWhitelist'				=> 'Whitelist',

	// --> Log
	'BbHits'					=> 'Hits',
	'BbRecordsFiltered'			=> 'Displaying %1 of %2 records filtered by',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Blocked',
	'BbPermitted'				=> 'Permitted',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Displaying all %1 records',
	'BbShow'					=> 'Show',
	'BbIpDateStatus'			=> 'IP/Date/Status',
	'BbHeaders'					=> 'Headers',
	'BbEntity'					=> 'Entity',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Options saved.',
	'BbWhitelistHint'			=> 'Inappropriate whitelisting WILL expose you to spam, or cause Bad Behavior to stop functioning entirely! DO NOT WHITELIST unless you are 100% CERTAIN that you should.',
	'BbIpAddress'				=> 'IP Address',
	'BbIpAddressInfo'			=> 'IP address or CIDR format address ranges to be whitelisted (one per line)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL fragments beginning with the / after your web site hostname (one per line)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'User agent strings to be whitelisted (one per line)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Updated Bad Behavior settings',
	'BbLogRequest'				=> 'Logging HTTP request',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (recommended)',
	'BbLogOff'					=> 'Do not log (not recommended)',
	'BbSecurity'				=> 'Security',
	'BbStrict'					=> 'Strict checking',
	'BbStrictInfo'				=> 'blocks more spam but may block some people',
	'BbOffsiteForms'			=> 'Allow form postings from other web sites',
	'BbOffsiteFormsInfo'		=> 'required for OpenID; increases spam received',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'To use Bad Behavior\'s http:BL features you must have an %1',
	'BbHttpblKey'				=> 'http:BL Access Key',
	'BbHttpblThreat'			=> 'Minimum Threat Level (25 is recommended)',
	'BbHttpblMaxage'			=> 'Maximum Age of Data (30 is recommended)',
	'BbReverseProxy'			=> 'Reverse Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'If you are using Bad Behavior behind a reverse proxy, load balancer, HTTP accelerator, content cache or similar technology, enable the Reverse Proxy option.<br>' .
									'If you have a chain of two or more reverse proxies between your server and the public Internet, you must specify <em>all</em> of the IP address ranges (in CIDR format) of all of your proxy servers, load balancers, etc. Otherwise, Bad Behavior may be unable to determine the client\'s true IP address.<br>' .
									'In addition, your reverse proxy servers must set the IP address of the Internet client from which they received the request in an HTTP header. If you don\'t specify a header, %1 will be used. Most proxy servers already support X-Forwarded-For and you would then only need to ensure that it is enabled on your proxy servers. Some other header names in common use include %2 and %3.',
	'BbReverseProxyEnable'		=> 'Enable Reverse Proxy',
	'BbReverseProxyHeader'		=> 'Header containing Internet clients IP address',
	'BbReverseProxyAddresses'	=> 'IP address or CIDR format address ranges for your proxy servers (one per line)',

];
