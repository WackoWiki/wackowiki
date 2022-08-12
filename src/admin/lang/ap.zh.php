<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'					=> '建议暂时阻止对该站点的访问以进行管理维护。',

	'CategoryArray'		=> [
		'basics'		=> '基本功能',
		'preferences'	=> '首选项',
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
	'Authorization'				=> '认证',
	'AuthorizationTip'			=> '请输入管理密码（同时确保浏览器中允许使用cookie）。',
	'NoRecoveryPassword'		=> '未指定管理密码！',
	'NoRecoveryPasswordTip'		=> '注意：缺少管理密码会对安全造成威胁！在配置文件中输入密码，然后再次运行该程序。',

	'ErrorLoadingModule'		=> '加载管理模块 %1 时出错：不存在。',

	'ApHomePage'				=> '首页',
	'ApHomePageTip'				=> '打开主页，您不会退出管理',
	'ApLogOut'					=> '退出',
	'ApLogOutTip'				=> '退出系统管理',

	'TimeLeft'					=> '剩余时间：%1 分钟',
	'ApVersion'					=> '版本',

	'SiteOpen'					=> '开放',
	'SiteOpened'				=> '站点已开放',
	'SiteOpenedTip'				=> '站点开放',
	'SiteClose'					=> '关闭',
	'SiteClosed'				=> '站点已关闭',
	'SiteClosedTip'				=> '站点已关闭',

	// Generic
	'Cancel'					=> '取消',
	'Add'						=> '添加',
	'Edit'						=> '编辑',
	'Remove'					=> '删除',
	'Enabled'					=> '启用',
	'Disabled'					=> '无效的',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> '管理',

	'MiscellaneousSection'		=> '杂项',
	'MainSection'				=> '通用选项',

	'DirNotWritable'			=> '%1 目录不可写。',

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
		'name'		=> '筛选',
		'title'		=> '筛选设置',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> '格式化程序',
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
		'title'		=> '安全子系统设置',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> '系统',
		'title'		=> '系统设置',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> '上传',
		'title'		=> '附件设置',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> '已删除',
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
		'title'		=> '备份数据',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> '修复',
		'title'		=> '修复和优化数据库',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> '恢复',
		'title'		=> '恢复备份数据',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> '主菜单',
		'title'		=> 'WackoWiki 管理',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> '不一致',
		'title'		=> '修复数据不一致',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> '数据同步',
		'title'		=> '同步数据',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> '群发电子邮件',
		'title'		=> '群发电子邮件',
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
		'title'		=> '系统事件日志',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> '统计数据',
		'title'		=> '显示统计数据',
	],

	// Bad Behavior module
	'tool_badbehavior'		=> [
		'name'		=> '不良行为',
		'title'		=> '不良行为',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> '批准',
		'title'		=> '用户注册审批',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> '用户组',
		'title'		=> '用户组管理',
	],

	// User module
	'user_users'		=> [
		'name'		=> '用户',
		'title'		=> '用户管理',
	],

	// Main module
	'PurgeSessions'				=> '清除',
	'PurgeSessionsTip'			=> '清除所有会话',
	'PurgeSessionsConfirm'		=> '您确定要清除所有会话吗？ 这将注销所有用户。',
	'PurgeSessionsExplain'		=> '清除所有会话。 这将通过截断 auth_token 表来注销所有用户。',
	'PurgeSessionsDone'			=> '会话已成功清除。',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> '更新了基本设置',
	'LogBasicSettingsUpdated'	=> '更新了基本设置',

	'SiteName'					=> '站点名称：',
	'SiteNameInfo'				=> '该网站的标题，出现在浏览器标题、主题标题、电子邮件通知等上面。',
	'SiteDesc'					=> '网站说明：',
	'SiteDescInfo'				=> '对出现在页面标题中的网站标题的补充，用几句话解释这个网站的内容。',
	'AdminName'					=> '网站管理员：',
	'AdminNameInfo'				=> '用户名，负责网站的整体支持。 此名称不用于确定访问权限，但最好与站点首席管理员的名称一致。',

	'LanguageSection'			=> '语言',
	'DefaultLanguage'			=> '默认语言：',
	'DefaultLanguageInfo'		=> '指定显示给未注册客人的消息的语言以及区域设置。',
	'MultiLanguage'				=> '多语言支持：',
	'MultiLanguageInfo'			=> '启用逐页选择语言的功能。',
	'AllowedLanguages'			=> '允许的语言：',
	'AllowedLanguagesInfo'		=> '建议仅选择您要使用的语言集，否则选择所有语言。',

	'CommentSection'			=> '评论',
	'AllowComments'				=> '允许评论：',
	'AllowCommentsInfo'			=> '仅对访客或注册用户启用评论，或在整个站点上禁用它们。',
	'SortingComments'			=> '评论排序：',
	'SortingCommentsInfo'		=> '更改页面评论的显示顺序，最新或最旧的评论位于顶部。',

	'ToolbarSection'			=> '工具栏',
	'CommentsPanel'				=> '评论面板：',
	'CommentsPanelInfo'			=> '默认在页面底部显示评论。',
	'FilePanel'					=> '文件面板：',
	'FilePanelInfo'				=> '默认在页面底部显示附件。',
	'TagsPanel'					=> '标签面板：',
	'TagsPanelInfo'				=> '标签面板默认显示在页面底部。',

	'NavigationSection'			=> '导航',
	'ShowPermalink'				=> '显示固定链接：',
	'ShowPermalinkInfo'			=> '当前版本页面的永久链接的默认显示。',
	'TocPanel'					=> '目录面板：',
	'TocPanelInfo'				=> '页面的默认显示目录面板（可能需要模板支持）。',
	'SectionsPanel'				=> '部分面板：',
	'SectionsPanelInfo'			=> '默认显示相邻页面的面板（需要模板支持）。',
	'DisplayingSections'		=> '显示部分：',
	'DisplayingSectionsInfo'	=> '前面的选项时，是否只显示页面的子页面（<em>lower</em>），只显示邻居（<em>top</em>）或两者，以及其他（<em>tree</em>）',
	'MenuItems'					=> '菜单项：',
	'MenuItemsInfo'				=> '显示的菜单项的默认数量（可能需要模板中的支持）。',

	'HandlerSection'			=> '处理程序',
	'HideRevisions'				=> '隐藏修订：',
	'HideRevisionsInfo'			=> '页面修订的默认显示。',
	'AttachmentHandler'			=> '启用附件处理程序：',
	'AttachmentHandlerInfo'		=> '允许显示附件处理程序。',
	'SourceHandler'				=> '启用源处理程序：',
	'SourceHandlerInfo'			=> '允许显示源处理程序。',
	'ExportHandler'				=> '启用 XML 导出处理程序：',
	'ExportHandlerInfo'			=> '允许显示 XML 导出处理程序。',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> '打开feeds：',
	'EnableFeedsInfo'			=> '打开或关闭整个 wiki 的 RSS 源。',

	'XmlSitemap'				=> 'XML 站点地图：',
	'XmlSitemapInfo'			=> '在 xml 文件夹中创建一个名为 %1 的 XML 文件。 您可以在根目录的 robots.txt 文件中添加站点地图的路径，如下所示：',
	'XmlSitemapGz'				=> 'XML 站点地图压缩：',
	'XmlSitemapGzInfo'			=> '如果您愿意，您可以使用 gzip 压缩您的站点地图文本文件以减少您的带宽需求。',
	'XmlSitemapTime'			=> 'XML 站点地图生成时间：',
	'XmlSitemapTimeInfo'		=> '在给定的天数内仅生成一次站点地图，零表示每次页面更改。',

	'SearchSection'				=> '搜索',
	'OpenSearch'				=> '打开搜索：',
	'OpenSearchInfo'			=> '在XML文件夹中创建OpenSearch描述文件，并在HTML标题中启用搜索插件的Autodiscovery。',
	'SearchEngineVisibility'	=> '阻止搜索引擎（搜索引擎可见性）：',
	'SearchEngineVisibilityInfo'=> '阻止搜索引擎，但允许普通访问者。 覆盖页面设置。 <br>劝阻搜索引擎对该网站编制索引，搜索引擎应遵守此请求。',

	'DiffModeSection'			=> '差异模式',
	'DefaultDiffModeSetting'	=> '默认差异模式：',
	'DefaultDiffModeSettingInfo'=> '预选的差异模式。',
	'AllowedDiffMode'			=> '允许的差异模式：',
	'AllowedDiffModeInfo'		=> '建议仅选择您要使用的差异模式集，否则将选择所有差异模式。',
	'NotifyDiffMode'			=> '通知差异模式：',
	'NotifyDiffModeInfo'		=> '用于电子邮件正文中通知的差异模式。',

	'EditingSection'			=> '编辑中',
	'EditSummary'				=> '简述您的修改：',
	'EditSummaryInfo'			=> '在编辑模式下显示更改摘要。',
	'MinorEdit'					=> '这是一个细微的更改：',
	'MinorEditInfo'				=> '在编辑模式下启用次要编辑选项。',
	'ReviewSettings'			=> '审查：',
	'ReviewSettingsInfo'		=> '在编辑模式下启用审阅选项。',
	'PublishAnonymously'		=> '允许匿名发布：',
	'PublishAnonymouslyInfo'	=> '允许用户最好匿名发布（隐藏名称）。',

	'DefaultRenameRedirect'		=> '放置重定向时重命名：',
	'DefaultRenameRedirectInfo'	=> '默认情况下，提供设置重定向到被重命名页面的旧地址。',
	'StoreDeletedPages'			=> '保留已删除的页面：',
	'StoreDeletedPagesInfo'		=> '当您删除页面、评论或文件时，请将其保存在特殊部分中，以便在一段时间内进行查看和恢复（如下所述）。',
	'KeepDeletedTime'			=> '已删除页面的留存时间：',
	'KeepDeletedTimeInfo'		=> '天数。 只有使用前一个选项才有意义。 零表示永久拥有（在这种情况下，管理员可以手动清除“购物车”）。',
	'PagesPurgeTime'			=> '页面修订的存储时间：',
	'PagesPurgeTimeInfo'		=> '在给定的天数内自动删除旧版本。 如果输入零，则不会删除旧版本。',
	'EnableReferrers'			=> '启用推荐人：',
	'EnableReferrersInfo'		=> '允许存储和显示外部推荐人。',
	'ReferrersPurgeTime'		=> '推荐人的存储时间：',
	'ReferrersPurgeTimeInfo'	=> '保持引用外部页面的历史不超过给定的天数。 零意味着永久存储，但对于积极访问的站点，这可能导致数据库溢出。',
	'EnableCounters'			=> '计数器：',
	'EnableCountersInfo'		=> '允许每页点击计数器并启用简单统计信息的显示。 不计算页面所有者的浏览量。',

	// Appearance settings
	'AppearanceSettingsInfo'	=> '控制站点的默认显示设置。',
	'AppearanceSettingsUpdated'	=> '外观设置已更新',

	'LogoOff'					=> 'logo关闭',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo和title',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> '站点Logo：',
	'SiteLogoInfo'				=> '您的徽标通常会出现在应用程序的左上角。 最大大小为 2 MiB。 最佳尺寸为 255 像素宽 x 55 像素高。',
	'LogoDimensions'			=> 'Logo尺寸：',
	'LogoDimensionsInfo'		=> '显示的 Logo 的宽度和高度。',
	'LogoDisplayMode'			=> 'Logo显示模式：',
	'LogoDisplayModeInfo'		=> '定义 Logo 的外观。 默认为关闭。',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> '站点Favicon：',
	'SiteFaviconInfo'			=> '您的快捷方式图标或网站图标显示在大多数浏览器的地址栏、选项卡和书签中。 这将覆盖您主题的图标。',
	'SiteFaviconTooBig'			=> 'Favicon 大于 64 × 64px。',
	'ThemeColor'				=> '地址栏的主题颜色：',
	'ThemeColorInfo'			=> '浏览器会根据所提供的CSS颜色来设置每个页面的地址栏颜色。',

	'LayoutSection'				=> '布局',
	'Theme'						=> '主题：',
	'ThemeInfo'					=> '网站默认使用的模板设计。',
	'ResetUserTheme'			=> '重置所有用户主题：',
	'ResetUserThemeInfo'		=> '重置所有用户主题。 警告：此操作会将所有用户选择的主题设置为全局默认主题。',
	'SetBackUserTheme'			=> '将所有用户主题设置回 %1 主题。',
	'ThemesAllowed'				=> '允许的主题：',
	'ThemesAllowedInfo'			=> '选择允许的主题，用户可以选择，否则允许所有可用的主题。',
	'ThemesPerPage'				=> '每页主题：',
	'ThemesPerPageInfo'			=> '允许每个页面的主题，页面所有者可以通过页面属性进行选择。',

	// System settings
	'SystemSettingsInfo'		=> '负责微调平台的参数组。 除非你对他们的行为有信心，否则不要改变他们。',
	'SystemSettingsUpdated'		=> '更新了系统设置',

	'DebugModeSection'			=> '调试模式',
	'DebugMode'					=> '调试模式：',
	'DebugModeInfo'				=> '程序时间的固定和遥测数据的撤回。 注意：该机制的全部细节对可用内存提出了很高的要求，尤其是在备份和恢复数据库等要求苛刻的操作中。',
	'DebugModes'	=> [
		'0'		=> '调试关闭',
		'1'		=> '仅总执行时间',
		'2'		=> '所有时间',
		'3'		=> '完整的细节 (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> '阈值性能 RDBMS：',
	'DebugSqlThresholdInfo'		=> '在详细调试模式下只记录查询所花费的时间超过了秒数。',
	'DebugAdminOnly'			=> '封闭式诊断：',
	'DebugAdminOnlyInfo'		=> '仅为管理员显示程序（和 DBMS）的调试数据。',

	'CachingSection'			=> '缓存选项',
	'Cache'						=> '缓存渲染页面：',
	'CacheInfo'					=> '将渲染的页面保存在本地缓存中以加快后续启动。 仅对未注册的访客有效。',
	'CacheTtl'					=> '词条相关缓存页面：',
	'CacheTtlInfo'				=> '缓存页面不超过指定的秒数。',
	'CacheSql'					=> '缓存 DBMS 查询：',
	'CacheSqlInfo'				=> '维护本地缓存某些资源 SQL 查询的结果。',
	'CacheSqlTtl'				=> '词条相关缓存数据库：',
	'CacheSqlTtlInfo'			=> '将 SQL 查询的结果缓存不超过指定的秒数。 使用超过 1200 的值是不可取的。',

	'LogSection'				=> '日志设置',
	'LogLevelUsage'				=> '使用日志记录：',
	'LogLevelUsageInfo'			=> '日志中记录的事件的最低优先级。',
	'LogThresholds'	=> [
		'0'		=> '不记录日志',
		'1'		=> '仅临界水平',
		'2'		=> '从最高级别',
		'3'		=> 'from high',
		'4'		=> '平均',
		'5'		=> 'from low',
		'6'		=> '最低级别',
		'7'		=> '记录所有',
	],
	'LogDefaultShow'			=> '显示日志模式：',
	'LogDefaultShowInfo'		=> '默认情况下显示在日志中的最低优先级事件。',
	'LogModes'	=> [
		'1'		=> '临界水平',
		'2'		=> 'from the highest level',
		'3'		=> 'from high-level',
		'4'		=> 'the average',
		'5'		=> 'from a low',
		'6'		=> 'from the minimum level',
		'7'		=> '显示所有',
	],
	'LogPurgeTime'				=> '日志存储时间：',
	'LogPurgeTimeInfo'			=> '删除给定天数外的事件日志。',

	'PrivacySection'			=> '隐私',
	'AnonymizeIp'				=> '匿名用户 IP 地址：',
	'AnonymizeIpInfo'			=> '在适用的情况下匿名 IP 地址，例如页面、修订版或引用者。',

	'ReverseProxySection'		=> '反向代理',
	'ReverseProxy'				=> '使用反向代理：',
	'ReverseProxyInfo'			=> '启用此设置以确定远程的正确 IP 地址客户端通过检查存储在 X-Forwarded-For 标头中的信息。X-Forwarded-For 标头是识别客户端的标准机制通过反向代理服务器连接的系统，例如 Squid 或磅。 反向代理服务器通常用于增强性能访问量大的站点，还可能提供其他站点缓存，安全或加密的好处。 如果此 WackoWiki 安装运行在反向代理之后，应启用此设置，以便正确IP 地址信息在 WackoWiki 的会话管理中捕获，日志、统计和访问管理系统； 如果你不确定关于这个设置，没有反向代理，或者 WackoWiki 在共享主机环境，此设置应保持禁用状态。',
	'ReverseProxyHeader'		=> '反向代理标头：',
	'ReverseProxyHeaderInfo'	=> '果您的代理服务器在 X-Forwarded-For 以外的标头中发送客户端 IP，请设置此值。 “X-Forwarded-For”标头是一个逗号+空格分隔的 IP 地址列表，仅使用最后一个（最左侧）。',
	'ReverseProxyAddresses'		=> 'reverse_proxy 接受 IP 地址数组：',
	'ReverseProxyAddressesInfo'	=> '这个数组的每个元素都是你任何反向的 IP 地址代理。 填充此数组 WackoWiki 将信任存储的信息仅当远程 IP 地址是其中之一时，才在 X-Forwarded-For 标头中这些，即请求从您的其中一个到达 Web 服务器反向代理。否则，客户端可以直接连接到您的网络服务器欺骗了 X-Forwarded-For 标头。',

	'SessionSection'				=> '会话处理',
	'SessionStorage'				=> '会话存储：',
	'SessionStorageInfo'			=> '此选项定义会话数据的存储位置。 默认情况下，选择文件或数据库会话存储。',
	'SessionModes'	=> [
		'1'		=> '文件',
		'2'		=> '数据库',
	],
	'SessionNotice'					=> '显示会话终止原因：',
	'SessionNoticeInfo'				=> '表示会话终止的原因。',

	'RewriteMode'					=> '使用 <code>mod_rewrite</code>：',
	'RewriteModeInfo'				=> '如果您的网络服务器支持此功能，请转而获取“漂亮”的页面地址。<br> <span class="cite">该值可能会在运行时被设置类覆盖，无论是否关闭， 如果 HTTP_MOD_REWRITE 开启。',

	// Permissions settings
	'PermissionsSettingsInfo'		=> '负责访问控制和权限的参数。',
	'PermissionsSettingsUpdated'	=> '更新了权限设置',

	'PermissionsSection'		=> '权利和权限',
	'ReadRights'				=> '默认读取权限：',
	'ReadRightsInfo'			=> '它们被分配给创建的根页面，以及无法定义父权限的页面。',
	'WriteRights'				=> '默认写权限：',
	'WriteRightsInfo'			=> '它们被分配给创建的根页面，以及无法定义父权限的页面。',
	'CommentRights'				=> '默认评论权限：',
	'CommentRightsInfo'			=> '它们被分配给创建的根页面，以及无法定义父权限的页面。',
	'CreateRights'				=> '默认创建子页面权限：',
	'CreateRightsInfo'			=> '定义创建根页面的权限并将其分配给无法定义父权限的页面。',
	'UploadRights'				=> '默认上传权限：',
	'UploadRightsInfo'			=> '它们被分配给创建的根页面，以及无法定义父权限的页面。',
	'RenameRights'				=> '全局重命名权限：',
	'RenameRightsInfo'			=> '自由重命名（移动）页面的权限列表。',

	'LockAcl'					=> '锁定所有 ACL 为只读：',
	'LockAclInfo'				=> '<span class="cite">覆盖所有页面的 acl 设置为只读。</span><br>如果项目已完成，出于安全原因或紧急情况需要关闭编辑一段时间，这可能很有用。',
	'HideLocked'				=> '隐藏无法访问的页面：',
	'HideLockedInfo'			=> '如果用户无权阅读该页面，则将其隐藏在不同的页面列表中（但是放置在文本中的链接仍然可见）。',
	'RemoveOnlyAdmins'			=> '只有管理员可以删除页面：',
	'RemoveOnlyAdminsInfo'		=> '拒绝除管理员以外的所有人删除页面。 在第一个限制适用于普通页面的所有者。',
	'OwnersRemoveComments'		=> '页面所有者可以删除评论：',
	'OwnersRemoveCommentsInfo'	=> '允许页面所有者在他们的页面上审核评论。',
	'OwnersEditCategories'		=> '所有者可以编辑页面类别：',
	'OwnersEditCategoriesInfo'	=> '允许所有者修改您网站的页面类别列表（添加单词，删除单词），分配给页面。',
	'TermHumanModeration'		=> '词条人为节制：',
	'TermHumanModerationInfo'	=> '版主只能编辑创建时间不超过此天数的评论（此限制不适用于主题中的最后一条评论）。',

	'UserCanDeleteAccount'		=> '许用户删除他们的帐户',

	// Security settings
	'SecuritySettingsInfo'		=> '负责平台整体安全、安全限制和附加安全子系统的参数。',
	'SecuritySettingsUpdated'	=> '更新了安全设置',

	'AllowRegistration'			=> '在线注册：',
	'AllowRegistrationInfo'		=> '打开用户注册。 禁用此选项将阻止免费注册，但是，站点管理员将能够自己注册其他用户。',
	'ApproveNewUser'			=> '审批新用户：',
	'ApproveNewUserInfo'		=> '允许管理员在用户注册后批准用户。 只有获得批准的用户才能登录该站点。',
	'PersistentCookies'			=> '持久性cookies：',
	'PersistentCookiesInfo'		=> '允许持久性 cookie。',
	'DisableWikiName'			=> '禁用 WikiName：',
	'DisableWikiNameInfo'		=> '禁用 WikiName 的强制使用。 允许使用传统昵称注册用户，而不是强制 NameSurname。',
	'AllowEmailReuse'			=> '允许电子邮件地址重复使用：',
	'AllowEmailReuseInfo'		=> '不同的用户可以使用相同的电子邮件地址注册。',
	'AllowedEmailDomains'		=> 'Allowed email domains:',
	'AllowedEmailDomainsInfo'	=> 'Allowed email domains comma separated, e.g. <code>example.com, local.lan</code> etc., other wise all email domains are allowed.',
	'UsernameLength'			=> '用户名长度：',
	'UsernameLengthInfo'		=> '用户名中的最小和最大字符数。',

	'CaptchaSection'			=> '验证码',
	'EnableCaptcha'				=> '启用验证码：',
	'EnableCaptchaInfo'			=> '如果启用，验证码将在以下情况下或达到安全阈值时显示。',
	'CaptchaComment'			=> '新评论：',
	'CaptchaCommentInfo'		=> '作为防止垃圾邮件发布的一项措施，在发布评论之前，未注册用户需要一个单一的测试解决方案。',
	'CaptchaPage'				=> '新页面：',
	'CaptchaPageInfo'			=> '作为防止垃圾邮件发布的一项措施，要求未注册用户在创建新页面之前进行单一的测试解决方案。',
	'CaptchaEdit'				=> '编辑页面：',
	'CaptchaEditInfo'			=> '作为一种防止垃圾邮件发布的措施，在编辑页面之前，未注册用户需要一个单一的测试解决方案。',
	'CaptchaRegistration'		=> '注册：',
	'CaptchaRegistrationInfo'	=> '作为防止垃圾邮件发布的一项措施，未注册用户在注册前需要一个单一的测试解决方案。',

	'TlsSection'				=> 'TLS设置',
	'TlsConnection'				=> 'TLS-连接：',
	'TlsConnectionInfo'			=> '使用 TLS 安全连接。 <span class="cite">在服务器上激活所需的预装TLS证书，否则您将无法访问管理面板！</span><br>它还确定是否设置了Cookie安全标志， <code>secure</code> 标志指定cookie 是否应该只通过安全连接发送。',
	'TlsImplicit'				=> '强制 TLS：',
	'TlsImplicitInfo'			=> '强制将客户端从 HTTP 重新连接到 HTTPS。 禁用该选项后，客户端可以通过开放的 HTTP 通道浏览站点。',

	'HttpSecurityHeaders'		=> 'HTTP 安全标头',
	'EnableSecurityHeaders'		=> '启用HTTP 安全标头：',
	'EnableSecurityHeadersinfo'	=> '设置安全标头（帧破坏、点击劫持/XSS/CSRF 保护）。 <br>CSP 可能会在某些情况下（例如在开发期间）或在使用依赖于外部托管资源（例如图像或脚本）的插件时引起问题。 <br>禁用内容安全策略是一种安全风险！',
	'Csp'						=> '内容安全策略 (CSP)：',
	'CspInfo'					=> '配置内容安全策略涉及决定您要执行哪些策略，然后配置它们并使用 Content-Security-Policy 来建立您的策略。',
	'PolicyModes'	=> [
		'0'		=> '禁用',
		'1'		=> '严格的',
		'2'		=> '自定义',
	],
	'PermissionsPolicy'			=> '许可策略：',
	'PermissionsPolicyInfo'		=> 'HTTP Permissions-Policy 标头提供了一种机制来显式启用或禁用各种强大的浏览器功能。',
	'ReferrerPolicy'			=> '推荐人策略：',
	'ReferrerPolicyInfo'		=> 'Referrer-Policy HTTP 标头控制在Referer 标头中发送的哪些引荐来源信息应该包含在发出的请求中。',
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

	'UserPasswordSection'		=> '用户密码的持久性',
	'PwdMinChars'				=> '最小密码长度：',
	'PwdMinCharsInfo'			=> '较长的密码必然比较短的密码（例如 12 到 16 个字符）更安全。<br>鼓励使用密码短语而不是密码。',
	'AdminPwdMinChars'			=> '最小管理员密码长度：',
	'AdminPwdMinCharsInfo'		=> '较长的密码必然比较短的密码（例如 15 到 20 个字符）更安全。<br>鼓励使用密码短语而不是密码。',
	'PwdCharComplexity'			=> '所需的密码复杂性：',
	'PwdCharClasses'	=> [
		'0'		=> '未测试',
		'1'		=> '任何字母+数字',
		'2'		=> '大写和小写+数字',
		'3'		=> '大小写+数字+字符',
	],
	'PwdUnlikeLogin'			=> '其他复杂情况：',
	'PwdUnlikes'	=> [
		'0'		=> '未测试',
		'1'		=> '密码与登录名不同',
		'2'		=> '密码不包含用户名',
	],

	'LoginSection'				=> '登录',
	'MaxLoginAttempts'			=> '每个用户名的最大登录尝试次数：',
	'MaxLoginAttemptsInfo'		=> '在触发反垃圾邮件任务之前，单个帐户允许的登录尝试次数。 输入 0 以防止针对不同的用户帐户触发反垃圾邮件机器人任务。',
	'IpLoginLimitMax'			=> '每个 IP 地址的最大登录尝试次数：',
	'IpLoginLimitMaxInfo'		=> '在触发反垃圾邮件任务之前允许从单个 IP 地址登录尝试的阈值。 输入 0 以防止 IP 地址触发反垃圾邮件任务。',

	'FormsSection'				=> '表单',
	'FormTokenTime'				=> '提交表单的最长时：',
	'FormTokenTimeInfo'			=> '用户必须提交表单的时间（以秒为单位）。<br>请注意，如果会话过期，表单可能会变为无效，无论此设置如何。',

	'SessionLength'				=> '登录 cookie期限：',
	'SessionLengthInfo'			=> '默认情况下，用户 cookie 登录的生命周期（以天为单位）。',
	'CommentDelay'				=> '防止洪水式评论：',
	'CommentDelayInfo'			=> '发布新评论之间的最小延迟（以秒为单位）。',
	'IntercomDelay'				=> '防止洪水式个人交流：',
	'IntercomDelayInfo'			=> '发送私人消息用户连接之间的最小延迟（以秒为单位）。',
	'RegistrationDelay'			=> '注册时间阈值：',
	'RegistrationDelayInfo'		=> '填写注册表以将机器人与人类区分开来的最短时间阈值（以秒为单位）。',

	// Formatter settings
	'FormatterSettingsInfo'		=> '负责微调平台的参数组。 除非你对他们的行为有信心，否则不要改变他们。',
	'FormatterSettingsUpdated'	=> '更新了格式设置',

	'TextHandlerSection'		=> '文本处理程序',
	'Typografica'				=> '排版校对器：',
	'TypograficaInfo'			=> '取消设置会稍微加快添加评论和保存页面的过程。',
	'Paragrafica'				=> '段落标记：',
	'ParagraficaInfo'			=> '与上一个选项类似，但会导致无法操作的自动目录断开连接：<code>{{toc}}</code>。',
	'AllowRawhtml'				=> '全局HTML 支持：',
	'AllowRawhtmlInfo'			=> '对于开放站点，此选项可能不安全。',
	'SafeHtml'					=> '过滤 HTML：',
	'SafeHtmlInfo'				=> '防止保存危险的 HTML 对象。 在支持 HTML 的开放站点上关闭过滤器是<span class="underline">非常</span>不可取的！',

	'WackoFormatterSection'		=> 'Wiki 文本格式化程序（Wacko 格式化程序）',
	'X11colors'					=> 'X11 颜色使用：',
	'X11colorsInfo'				=> '扩展 <code>??(color) background??</code> 和 <code>!!(color) text!!</code> 的可用颜色！',
	'WikiLinks'					=> '禁用 Wikilinks：',
	'WikiLinksInfo'				=> '禁用 <code>CamelCaseWords</code> 的链接，您的 CamelCase Words 将不再直接链接到新页面。 当您跨不同的命名空间和集群工作时，这很有用。 默认情况下它是关闭的。',
	'BracketsLinks'				=> '禁用括号链接：',
	'BracketsLinksInfo'			=> '禁用 <code>[[link]]</code> 和 <code>((link))</code> 语法。',
	'Formatters'				=> '禁用格式化程序：',
	'FormattersInfo'			=> '禁用 <code>%%code%%</code> 语法，用于高亮。',

	'DateFormatsSection'		=> '日期格式',
	'DateFormat'				=> '日期的格式：',
	'DateFormatInfo'			=> '（日月年）',
	'TimeFormat'				=> '时间格式：',
	'TimeFormatInfo'			=> '（小时，分钟）',
	'TimeFormatSeconds'			=> '准确时间的格式：',
	'TimeFormatSecondsInfo'		=> '（小时、分钟、秒）',
	'NameDateMacro'				=> '<code>::@::</code>宏格式：',
	'NameDateMacroInfo'			=> '（姓名，时间），例如 <code>用户名 (17.11.2016 16:48)</code>',
	'Timezone'					=> '时区：',
	'TimezoneInfo'				=> '用于向未登录的用户（来宾）显示时间的时区。 登录用户设置并可以在其用户设置中更改其时区。',

	'Canonical'					=> '使用完全规范的 URL：',
	'CanonicalInfo'				=> '所有链接都创建为 %1 格式的绝对 URL。 应首选格式为 %2 的相对于服务器根目录的 URL。',
	'LinkTarget'				=> '打开外部链接的位置：',
	'LinkTargetInfo'			=> '在新的浏览器窗口中打开每个外部链接。 将 <code>target="_blank"</code> 添加到链接语法中。',
	'Noreferrer'				=> '无推荐人：',
	'NoreferrerInfo'			=> '如果用户跟随超链接，则要求浏览器不应发送 HTTP 引用标头。 将 <code>rel="noreferrer"</code> 添加到链接语法中。',
	'Nofollow'					=> '不关注：',
	'NofollowInfo'				=> '告诉搜索引擎，超链接不应该影响目标页面在搜索引擎索引中的页面排名。 将 <code>rel="nofollow"</code> 添加到链接语法中。',
	'UrlsUnderscores'			=> '带下划线的表单地址 (URL)：',
	'UrlsUnderscoresInfo'		=> '例如 %1 使用此选项变为 %2。',
	'ShowSpaces'				=> '在 WikiNames 中显示空格：',
	'ShowSpacesInfo'			=> '在 WikiNames 中显示空格，例如 <code>MyName</code> 使用此选项显示为 <code>MyName</code>。',
	'NumerateLinks'				=> '在打印视图中计算链接：',
	'NumerateLinksInfo'			=> '使用此选项枚举并列出打印视图底部的所有链接。',
	'YouareHereText'			=> '禁用和可视化自引用链接：',
	'YouareHereTextInfo'		=> '可视化指向同一页面的链接，尝试 <code>&lt;b&gt;####&lt;/b&gt;</code>，所有指向自我的链接都不是链接，而是粗体文本。',

	// Pages settings
	'PagesSettingsInfo'			=> '您可以在此处设置或更改 Wiki 中使用的系统基本页面。 请确保您不要忘记根据您在此处的设置在 Wiki 中创建或更改相应的页面。',
	'PagesSettingsUpdated'		=> '更新了设置基础页面',

	'ListCount'					=> '每个列表的项目数：',
	'ListCountInfo'				=> '每个列表上显示的项目数，用于访客或作为新用户的默认值。',

	'ForumSection'				=> '论坛选项',
	'ForumCluster'				=> '集群选项：',
	'ForumClusterInfo'			=> '论坛部分的根集群 （操作 %1）。',
	'ForumTopics'				=> '每页的主题数：',
	'ForumTopicsInfo'			=> '在论坛部分列表的每一页上显示的主题数（操作 %1）。',
	'CommentsCount'				=> '每页评论数：',
	'CommentsCountInfo'			=> '每页评论列表中显示的评论数。 这适用于网站上的所有评论，而不仅仅是发布在论坛上。',

	'NewsSection'				=> '新闻部分',
	'NewsCluster'				=> '新闻集群：',
	'NewsClusterInfo'			=> '新闻部分的根集群（操作 %1）。',
	'NewsStructure'				=> '闻集群结构：',
	'NewsStructureInfo'			=> '可选择按年/月或周将文章存储在子集群中（例如 <code>[cluster]/[year]/[month]</code>）。',

	'LicenseSection'			=> '许可',
	'DefaultLicense'			=> '默认许可证：',
	'DefaultLicenseInfo'		=> '您的内容应在何种许可下发布。',
	'EnableLicense'				=> '启用许可证：',
	'EnableLicenseInfo'			=> '启用以显示许可证信息。',
	'LicensePerPage'			=> '每页许可：',
	'LicensePerPageInfo'		=> '允许每页许可证，页面所有者可以通过页面属性进行选择。',

	'ServicePagesSection'		=> '服务页面',
	'RootPage'					=> '主页：',
	'RootPageInfo'				=> '主页的标签，当用户访问您的网站时自动打开。',

	'PrivacyPage'				=> '隐私政策：',
	'PrivacyPageInfo'			=> '带有网站隐私政策的页面。',

	'TermsPage'					=> '政策法规：',
	'TermsPageInfo'				=> '包含网站规则的页面。',

	'SearchPage'				=> '搜索：',
	'SearchPageInfo'			=> '带有搜索表单的页面（操作 %1）。',
	'RegistrationPage'			=> '注册：',
	'RegistrationPageInfo'		=> '新用户注册页面（操作 %1）。',
	'LoginPage'					=> '用户登录：',
	'LoginPageInfo'				=> '站点上的登录页面（操作 %1）。',
	'SettingsPage'				=> '用户设置：',
	'SettingsPageInfo'			=> '用户自定义配置页面（操作 %1）。',
	'PasswordPage'				=> '更改密码：',
	'PasswordPageInfo'			=> '带有用于更改/查询用户密码的表单的页面（操作 %1）。',
	'UsersPage'					=> '用户列表：',
	'UsersPageInfo'				=> '包含注册用户列表的页面（操作 %1）。',
	'CategoryPage'				=> '分类：',
	'CategoryPageInfo'			=> '包含分类列表的页面（操作 %1）。',
	'TagPage'					=> 'Tag:',
	'TagPageInfo'				=> '带有Tag列表的页面（操作 %1）。',
	'GroupsPage'				=> '用户组：',
	'GroupsPageInfo'			=> '包含用户组列表的页面（操作 %1）。',
	'ChangesPage'				=> '动态：',
	'ChangesPageInfo'			=> '带有最后修改动态的页面（操作 %1）。',
	'CommentsPage'				=> '最近评论：',
	'CommentsPageInfo'			=> '包含最近评论列表的页面（操作 %1）。',
	'RemovalsPage'				=> '已删除页面：',
	'RemovalsPageInfo'			=> '包含最近删除页面列表的页面（操作 %1）。',
	'WantedPage'				=> '缺失页面：',
	'WantedPageInfo'			=> '包含引用的缺失页面列表的页面（操作 %1）。',
	'OrphanedPage'				=> '孤立页面：',
	'OrphanedPageInfo'			=> '包含现有页面列表的页面与其余页面没有相关链接（操作 %1）。',
	'SandboxPage'				=> '沙盒：',
	'SandboxPageInfo'			=> '可以培训用户使用 wiki 标记的页面。',
	'HelpPage'					=> '帮助：',
	'HelpPageInfo'				=> '使用站点工具的文档部分。',
	'IndexPage'					=> '索引：',
	'IndexPageInfo'				=> '包含所有页面列表的页面（操作 %1）。',
	'RandomPage'				=> '随机：',
	'RandomPageInfo'			=> '加载一个随机页面（操作 %1）。',


	// Notification settings
	'NotificationSettingsInfo'	=> '用于平台通知的参数。',
	'NotificationSettingsUpdated'	=> '更新通知设置',

	'EmailNotification'			=> '电子邮件通知：',
	'EmailNotificationInfo'		=> '允许电子邮件通知。 设置为 ON 以启用电子邮件通知，设置为 OFF 以禁用它们。 请注意，禁用电子邮件通知对作为用户注册过程的一部分生成的电子邮件没有影响。',
	'Autosubscribe'				=> '自动订阅：',
	'AutosubscribeInfo'			=> '在所有者的更改通知中自动订阅新页面。',

	'NotificationSection'		=> '默认用户通知设置',
	'NotifyPageEdit'			=> '页面编辑通知：',
	'NotifyPageEditInfo'		=> '待定 - 仅在用户再次访问该页面之前，仅针对第一次更改发送电子邮件通知。',
	'NotifyMinorEdit'			=> '次要编辑通知：',
	'NotifyMinorEditInfo'		=> '发送用于次要编辑的通知。',
	'NotifyNewComment'			=> '新评论通知：',
	'NotifyNewCommentInfo'		=> '待处理 - 仅针对第一个评论发送电子邮件通知，直到用户再次访问该页面。',

	'NotifyUserAccount'			=> '新用户帐户通知：',
	'NotifyUserAccountInfo'		=> '当使用注册表单创建新用户时，将通知管理员。',
	'NotifyUpload'				=> '文件上传通知：',
	'NotifyUploadInfo'			=> '上传文件时将通知版主。',

	'PersonalMessagesSection'	=> '个人信息',
	'AllowIntercomDefault'		=> '允许内部通话：',
	'AllowIntercomDefaultInfo'	=> '启用此选项允许其他用户在不透露地址的情况下向收件人电子邮件地址发送个人消息。',
	'AllowMassemailDefault'		=> '允许群发：',
	'AllowMassemailDefaultInfo'	=> '它只向那些允许管理员通过电子邮件向他们发送信息的用户发送消息。 ',

	// Resync settings
	'Synchronize'				=> '同步',
	'UserStatsSynched'			=> '同步用户统计。',
	'PageStatsSynched'			=> '页面统计信息同步。',
	'FeedsUpdated'				=> 'RSS-feeds已更新。',
	'SiteMapCreated'			=> '新版站点地图创建成功。',
	'ParseNextBatch'			=> '解析下一批页面：',
	'WikiLinksRestored'			=> '已恢复 Wiki 链接。',

	'LogUserStatsSynched'		=> '同步用户统计',
	'LogPageStatsSynched'		=> '同步页面统计',
	'LogFeedsUpdated'			=> '同步 RSS feeds',
	'LogPageBodySynched'		=> '重新解析的页面正文和链接',

	'UserStats'					=> '用户统计',
	'UserStatsInfo'				=> '在某些情况下，用户统计数据（评论数、拥有的页面、修订和文件）可能与实际数据不同。 <br>此操作允许将统计信息更新为数据库的当前实际数据。',
	'PageStats'					=> '页面统计',
	'PageStatsInfo'				=> '在某些情况下，页面统计数据（评论、文件和修订的数量）可能与实际数据不同。 <br>此操作允许将统计信息更新为数据库的当前实际数据。',
	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> '在直接编辑数据库中的页面的情况下，RSS 提要的内容可能不会反映所做的更改。 <br>此功能将 RSS 频道与数据库的当前状态同步。',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> '此函数将 XML-Sitemap 与数据库的当前状态同步。',
	'XmlSiteMapPeriod'			=> '期间 %1 天。 上次写入 %2。',
	'XmlSiteMapView'			=> '在新窗口中显示站点地图。',

	'ReparseBody'				=> '重新解析所有页面',
	'ReparseBodyInfo'			=> '清空页表中的 <code>body_r</code>，以便在下一个页面视图中再次呈现每个页面。 如果您修改了格式化程序或更改了 wiki 的域，这可能会很有用。',
	'PreparsedBodyPurged'		=> '清空页表中的 <code>body_r</code> 字段。',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> '对所有站点内链接执行重新渲染，并在损坏或重新定位时恢复表 <code>page_link</code> 和 <code>file_link</code> 的内容（这可能需要相当长的时间）。',
	'RecompilePage'				=> '重新编译所有页面（非常昂贵）',
	'ResyncOptions'				=> '其他选项',
	'RecompilePageLimit'		=> '一次要解析的页面数。',

	// Email settings
	'EmaiSettingsInfo'			=> '当引擎向您的用户发送电子邮件时会使用此信息。 请确保您指定的电子邮件地址有效，任何被退回或无法送达的邮件都可能会发送到该地址。 如果您的主机不提供本机（基于 PHP）的电子邮件服务，您可以改为使用 SMTP 直接发送消息。 这需要适当服务器的地址（如有必要，请咨询您的提供商）。 如果服务器需要身份验证（并且仅在需要身份验证的情况下），请输入必要的用户名、密码和身份验证方法。',

	'EmailSettingsUpdated'		=> '已更新电子邮件设置',

	'EmailFunctionName'			=> '电子邮件函数名称：',
	'EmailFunctionNameInfo'		=> '用于通过 PHP 发送邮件的 email 函数。',
	'UseSmtpInfo'				=> '如果您希望或必须通过指定服务器而不是本地邮件功能发送电子邮件，请选择 <code>SMTP</code>。',

	'EnableEmail'				=> '启用电子邮件：',
	'EnableEmailInfo'			=> '启用电子邮件',

	'FromEmailName'				=> 'From Name:',
	'FromEmailNameInfo'			=> '发件人姓名，电子邮件中 <code>From:</code> 标头的一部分，用于从站点发送的所有电子邮件通知。',
	'NoReplyEmail'				=> 'No-reply 地址：',
	'NoReplyEmailInfo'			=> '这个地址，例如 <code>noreply@example.com</code>，将出现在您从该站点发送的所有电子邮件通知的 <code>From:</code> 电子邮件地址字段中。',
	'AdminEmail'				=> '网站所有者的电子邮件：',
	'AdminEmailInfo'			=> '此地址用于管理目的，例如新用户通知。',
	'AbuseEmail'				=> '滥用电子邮件服务：',
	'AbuseEmailInfo'			=> '紧急事项的地址请求：外国电子邮件的注册等。可能与前面的一致。',

	'SendTestEmail'				=> '发送测试电子邮件',
	'SendTestEmailInfo'			=> '这将向您帐户中定义的地址发送一封测试电子邮件。',
	'TestEmailSubject'			=> '您的 Wiki 已正确配置为发送电子邮件',
	'TestEmailBody'				=> '如果您收到此电子邮件，则您的 Wiki 已正确配置为发送电子邮件。',
	'TestEmailMessage'			=> '测试电子邮件已发送。<br>如果您没有收到，请检查您的电子邮件配置。',

	'SmtpSettings'				=> 'SMTP 设置',
	'SmtpAutoTls'				=> '机会性 TLS：',
	'SmtpAutoTlsInfo'			=> '自动启用加密，如果它看到服务器正在广播 TLS 加密（在您连接到服务器之后），即使您没有为 <code>SMTPSecure</code> 设置连接模式。',
	'SmtpConnectionMode'		=> 'SMTP 的连接模式：',
	'SmtpConnectionModeInfo'	=> '仅在设置了用户名/密码时使用，如果您不确定使用哪种方法，请询问您的提供商。',
	'SmtpPassword'				=> 'SMTP 密码：',
	'SmtpPasswordInfo'			=> '仅当您的 SMTP 服务器需要时才输入密码。<br><em><strong>警告：</strong>此密码将以纯文本形式存储在数据库中，对所有可以访问您的数据库或可以查看的人可见 此配置页面。</em>',
	'SmtpPort'					=> 'SMTP 服务器端口：',
	'SmtpPortInfo'				=> '仅当您知道您的 SMTP 服务器在不同的端口上时才更改此设置。 <br>（默认：<code>tls</code> 在端口 587（或可能是 25）和 <code>ssl</code> 在端口 465）',
	'SmtpServer'				=> 'SMTP 服务器地址：',
	'SmtpServerInfo'			=> '请注意，您必须提供服务器使用的协议。 如果您使用 SSL，则必须是 <code>ssl://mail.example.com</code>',
	'SmtpUsername'				=> 'SMTP 用户名：',
	'SmtpUsernameInfo'			=> '仅当您的 SMTP 服务器需要时才输入用户名。',

	// Upload settings
	'UploadSettingsInfo'		=> '您可以在此处配置附件和相关特殊类别的主要设置。',
	'UploadSettingsUpdated'		=> '更新了上传设置',

	'FileUploadsSection'		=> '文件上传',
	'RightToUpload'				=> '上传文件的权限：',
	'RightToUploadInfo'			=> '<code>admins</code> 表示只有属于 admins 组的用户才能上传文件。 <code>1</code> 表示对注册用户开放上传。 <code>0</code> 表示禁止上传。',
	'UploadOnlyImages'			=> '只允许上传图片：',
	'UploadOnlyImagesInfo'		=> '只允许在页面上上传图像文件。',
	'UploadMaxFilesize'			=> '文件大小上限：',
	'UploadMaxFilesizeInfo'		=> '每个文件的最大大小。 如果此值为 0，则可上传的文件大小仅受您的 PHP 配置限制。',
	'UploadQuota'				=> '总附件配额：',
	'UploadQuotaInfo'			=> '整个 wiki 的附件可用的最大驱动器空间，<code>0</code> 是无限的。',
	'UploadQuotaUser'			=> '每个用户的存储配额：',
	'UploadQuotaUserInfo'		=> '限制一个用户可以上传的存储配额，<code>0</code> 无限制。',
	'CheckMimetype'				=> '检查附件文件：',
	'CheckMimetypeInfo'			=> '某些浏览器可能会被欺骗以为上传文件的 mimetype 不正确。 此选项可确保拒绝可能导致此问题的此类文件。',
	'TranslitFileName'			=> '音译文件名：',
	'TranslitFileNameInfo'		=> '如果适用且不需要 Unicode 字符，强烈建议只接受 Alpha-Numeric 字符。',

	'Thumbnails'				=> '缩略图',
	'CreateThumbnail'			=> '创建缩略图：',
	'CreateThumbnailInfo'		=> '在所有可能的情况下创建缩略图。',
	'MaxThumbWidth'				=> '最大缩略图宽度（以像素为单位）：',
	'MaxThumbWidthInfo'			=> '生成的缩略图不会超过此处设置的宽度。',
	'MinThumbFilesize'			=> '最小缩略图文件大小：',
	'MinThumbFilesizeInfo'		=> '不要为小于此大小的图像创建缩略图。',

	// Deleted module
	'DeletedObjectsInfo'		=> '已删除页面、修订和文件的列表。 最后，通过单击相应行中的删除或恢复链接，从数据库中删除或恢复页面、修订或文件。 （注意，不要求删除确认！）',

	// Filter module
	'FilterSettingsInfo'		=> '将在您的 Wiki 上自动审查的词。',
	'FilterSettingsUpdated'		=> '更新了垃圾邮件过滤器设置',

	'WordCensoringSection'		=> '文字审查',
	'SPAMFilter'				=> 'SPAM过滤器：',
	'SPAMFilterInfo'			=> '启用SPAM过滤器',
	'WordList'					=> '单词列表：',
	'WordListInfo'				=> '要列入黑名单的单词或短语 <code>fragment</code>（每行一个）',

	// Log module
	'LogFilterTip'				=> '按条件过滤事件：',
	'LogLevel'					=> '级别',
	'LogLevelFilters'	=> [
		'1'		=> '不小于',
		'2'		=> '不高于',
		'3'		=> '等于',
	],
	'LogNoMatch'				=> '没有符合条件的事件',
	'LogDate'					=> '日期',
	'LogEvent'					=> '事件',
	'LogUsername'				=> '用户名',
	'LogLevels'	=> [
		'1'		=> '紧急',
		'2'		=> '最高',
		'3'		=> '高',
		'4'		=> '中',
		'5'		=> '低级',
		'6'		=> '最低',
		'7'		=> '调试',
	],

	// Massemail module
	'MassemailInfo'				=> '在这里，您可以通过电子邮件将消息发送给您的所有用户或特定组的所有用户，这些用户可以选择接收群发电子邮件。 为此，将向所提供的管理电子邮件地址发送一封电子邮件，并向所有收件人发送一份密件抄送。 默认设置是在此类电子邮件中仅包含 20 个收件人，如果收件人越多，则发送的电子邮件就越多。 如果您要向一大群人发送电子邮件，请在提交后耐心等待，不要中途停止页面。 群发邮件需要很长时间是正常的，脚本完成后会通知您。',
	'LogMassemail'				=> 'Messemail 发送 %1 到组/用户 ',
	'MassemailSend'				=> '群发邮件',

	'NoEmailMessage'			=> '您必须输入一条消息。',
	'NoEmailSubject'			=> '您必须为您的消息指定一个主题。',
	'NoEmailRecipient'			=> '您必须至少指定一个用户或用户组。',

	'MassemailSection'			=> '群发电子邮件',
	'MessageSubject'			=> '主题',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> '你的信息',
	'YourMessageInfo'			=> '请注意，您只能输入纯文本。 发送前将删除所有标记。',

	'NoUser'					=> '没有用户',
	'NoUserGroup'				=> '没有用户组',

	'SendToGroup'				=> '发送到群组',
	'SendToUser'				=> '发送到个人',
	'SendToUserInfo'			=> '它只向那些允许管理员通过电子邮件向他们发送信息的用户发送消息。 此选项在通知下的用户设置中可用。',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> '更新系统消息',

	'SysMsgSection'				=> '系统消息',
	'SysMsg'					=> '系统消息',
	'SysMsgInfo'				=> '你的文本文档',

	'SysMsgType'				=> '类型',
	'SysMsgTypeInfo'			=> '消息类型 (CSS)。',
	'EnableSysMsg'				=> '启用系统消息',
	'EnableSysMsgInfo'			=> '显示系统消息。',

	// User approval module
	'ApproveNotExists'			=> '请通过设置按钮选择至少一位用户。',

	'LogUserApproved'			=> '用户 ##%1## 已批准',
	'LogUserBlocked'			=> '用户 ##%1## 被阻止',
	'LogUserDeleted'			=> '用户 ##%1## 从数据库中删除',
	'LogUserCreated'			=> '创建了一个新用户##%1##',
	'LogUserUpdated'			=> '更新用户 ##%1##',

	'UserApproveInfo'			=> '在新用户能够登录网站之前批准他们。',
	'Approve'					=> '批准',
	'Deny'						=> '拒绝',
	'Pending'					=> '待定',
	'Approved'					=> '已审批',
	'Denied'					=> '已拒绝',

	// DB Backup module
	'BackupStructure'			=> '结构',
	'BackupData'				=> '数据',
	'BackupFolder'				=> '文件夹',
	'BackupTable'				=> '表',
	'BackupCluster'				=> '集群',
	'BackupFiles'				=> '文件',
	'BackupSettings'			=> '指定所需的备份方案。<br>' .
									'根集群不影响全局文件备份和缓存文件备份（被选择它们总是完整保存）。<br>' .
									'<br>' .
									'<strong>注意</strong>：为避免在指定根集群时从数据库中丢失信息，此备份中的表将不会被重组，' .
									'仅备份表结构而不保存数据时相同。 ' .
									'要将表完全转换为备份格式，您必须在不指定集群的情况下进行<em>完整的数据库备份（结构和数据）</em>。',
	'BackupCompleted'			=> '备份和存档已完成。<br>' .
									'备份包文件存储在子目录 %1 中。<br>' .
									'要使用 FTP 下载它（复制时保持目录结构和文件名）。<br>' .
									'要恢复备份副本或删除包，请转到<a href="%2">恢复数据库</a>。',
	'LogSavedBackup'			=> '保存的备份数据库##%1##',
	'Backup'					=> '备份',

	// DB Restore module
	'RestoreInfo'				=> '您可以恢复找到的任何备份包或将其从服务器中删除。',
	'ConfirmDbRestore'			=> '是否要还原备份 %1？',
	'ConfirmDbRestoreInfo'		=> '请稍候，这可能需要几分钟。',
	'RestoreWrongVersion'		=> '错误的 WackoWiki 版本！',
	'DirectoryNotExecutable'	=> '%1 目录不可写。',
	'BackupDelete'				=> '您确定要删除备份 %1 吗？',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> '其他恢复选项',
	'RestoreOptionsInfo'		=> '* 在恢复<strong>集群备份</strong>之前，' .
									'目标表不会被删除（以防止未备份的集群中的信息丢失）。 ' .
									'因此，在恢复过程中会出现重复记录。 ' .
									'在普通模式下，它们都将被备份形式的记录替换（使用SQL指令<code>REPLACE</code>），' .
									'但如果选中此复选框，则会跳过所有重复项（将保留记录的当前值），' .
									'并且只有具有新键的记录才会添加到表中（SQL 指令 <code>INSERT IGNORE</code>）。<br>' .
									'<strong>注意</strong>：当恢复站点的完整备份时，该选项没有任何价值。<br>' .
									'<br>' .
									'** 如果备份包含用户文件（全局和 perpage、缓存文件等），' .
									'在正常模式下，它们会替换现有的同名文件，并在恢复时放置在同一目录中。 ' .
									'此选项允许您保存文件的当前副本并从备份中仅恢复新文件（服务器上丢失）。',
	'IgnoreDuplicatedKeysNr'	=> '忽略重复的表键（不替换）',
	'IgnoreSameFiles'			=> '忽略相同的文件（不覆盖）',
	'NoBackupsAvailable'		=> '没有可用的备份。',
	'BackupEntireSite'			=> '整个网站',
	'BackupRestored'			=> '备份已恢复，下方附有摘要报告。 要删除此备份包，请单击',
	'BackupRemoved'				=> '所选备份已成功删除。',
	'LogRemovedBackup'			=> '删除了数据库备份##%1##',

	'RestoreStarted'			=> '启动恢复',
	'RestoreParameters'			=> '使用参数',
	'IgnoreDuplicatedKeys'		=> '忽略重复的键',
	'IgnoreDuplicatedFiles'		=> '忽略重复的文件',
	'SavedCluster'				=> '保存的集群',
	'DataProtection'			=> '数据保护 - %1 省略',
	'AssumeDropTable'			=> '假设 %1',
	'RestoreTableStructure'		=> '恢复表结构',
	'RunSqlQueries'				=> '执行 SQL 指令',
	'CompletedSqlQueries'		=> '完全的。 处理指令',
	'NoTableStructure'			=> '表的结构未保存 - 跳过',
	'RestoreRecords'			=> '恢复表的内容',
	'ProcessTablesDump'			=> '只需下载并处理表转储',
	'Instruction'				=> '操作说明',
	'RestoredRecords'			=> '记录',
	'RecordsRestoreDone'		=> '完全的。 总条目',
	'SkippedRecords'			=> '数据未保存 - 跳过',
	'RestoringFiles'			=> '恢复文件',
	'DecompressAndStore'		=> '解压并存储目录内容',
	'HomonymicFiles'			=> '同名文件',
	'RestoreSkip'				=> '跳过',
	'RestoreReplace'			=> '替换',
	'RestoreFile'				=> '文件',
	'Restored'					=> '已恢复',
	'Skipped'					=> '已跳过',
	'FileRestoreDone'			=> '完全的。 文件总数',
	'FilesAll'					=> '全部',
	'SkipFiles'					=> '文件未存储 - 跳过',
	'RestoreDone'				=> '修复完成',

	'BackupCreationDate'		=> '创建日期',
	'BackupPackageContents'		=> '封装内容',
	'BackupRestore'				=> '恢复',
	'BackupRemove'				=> '删除',
	'RestoreYes'				=> '是',
	'RestoreNo'					=> '否',
	'LogDbRestored'				=> '备份 ##%1## 的数据库已还原。',

	// User module
	'UsersInfo'					=> '在这里，您可以更改您的用户信息和某些特定选项。',

	'UsersAdded'				=> '已添加用户',
	'UsersDeleteInfo'			=> '[用户在此处删除信息..]',
	'EditButton'				=> '编辑',
	'UsersAddNew'				=> '添加新用户',
	'UsersDelete'				=> '您确定要删除用户 %1 吗？',
	'UsersDeleted'				=> '用户 %1 已从数据库中删除。',
	'UsersRename'				=> '将用户 %1 重命名为',
	'UsersRenameInfo'			=> '* 注意：更改将影响分配给该用户的所有页面。',
	'UsersUpdated'				=> '用户已成功更新。',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> '注册时间',
	'UserActions'				=> '动作',
	'NoMatchingUser'			=> '没有符合条件的用户',

	'UserAccountNotify'			=> '通知用户',
	'UserNotifySignup'			=> '通知用户有关新帐户的信息',
	'UserVerifyEmail'			=> '设置电子邮件确认令牌并添加电子邮件验证链接',
	'UserReVerifyEmail'			=> '重新发送电子邮件确认令牌',

	// Groups module
	'GroupsInfo'				=> '在此面板中，您可以管理所有用户组。 您可以删除、创建和编辑现有组。 此外，您可以选择组长，切换打开/隐藏/关闭组状态并设置组名称和描述。',

	'LogMembersUpdated'			=> '更新用户组成员',
	'LogMemberAdded'			=> '已将成员 ##%1## 添加到用户组 ##%2##',
	'LogMemberRemoved'			=> '从用户组 ##%2## 中删除成员 ##%1##',
	'LogGroupCreated'			=> '创建了一个新用户组##%1##',
	'LogGroupRenamed'			=> '用户组 ##%1## 重命名为 ##%2##',
	'LogGroupRemoved'			=> '用户组 ##%1## 重命名为 ##%2##',

	'GroupsMembersFor'			=> '组成员',
	'GroupsDescription'			=> '描述',
	'GroupsModerator'			=> '版主',
	'GroupsOpen'				=> '开放',
	'GroupsActive'				=> '活动',
	'GroupsTip'					=> '点击编辑用户组',
	'GroupsUpdated'				=> '用户组已更新',
	'GroupsAlreadyExists'		=> '该用户组已存在。',
	'GroupsAdded'				=> '用户组添加成功',
	'GroupsRenamed'				=> '用户组已改名',
	'GroupsDeleted'				=> '用户组 %1 已从数据库和所有页面中删除。',
	'GroupsAdd'					=> '添加一个新用户组',
	'GroupsRename'				=> '将用户组 %1 重命名为',
	'GroupsRenameInfo'			=> '* 注意：更改将影响分配给该用户组的所有页面。',
	'GroupsDelete'				=> '您确定要删除用户组 %1 吗？',
	'GroupsDeleteInfo'			=> '* 注意：更改将影响分配到该用户组的所有成员。',
	'GroupsIsSystem'			=> '用户组 %1 属于系统，无法删除。',
	'GroupsStoreButton'			=> '保存用户组',
	'GroupsEditInfo'			=> '要编辑组列表，请选择单选按钮。',

	'GroupAddMember'			=> '添加成员',
	'GroupRemoveMember'			=> '删除成员',
	'GroupAddNew'				=> '添加用户组',
	'GroupEdit'					=> '编辑用户组',
	'GroupDelete'				=> '删除用户组',

	'MembersAddNew'				=> '添加新成员',
	'MembersAdded'				=> '已成功将新成员添加到用户组。',
	'MembersRemove'				=> '您确定要删除成员 %1 吗？',
	'MembersRemoved'			=> '该成员已从用户组中删除。',

	// Statistics module
	'DbStatSection'				=> '数据库统计',
	'DbTable'					=> '表',
	'DbRecords'					=> '记录',
	'DbSize'					=> '大小',
	'DbIndex'					=> '索引',
	'DbOverhead'				=> '开销',
	'DbTotal'					=> '总数',

	'FileStatSection'			=> '文件系统统计',
	'FileFolder'				=> '文件夹',
	'FileFiles'					=> '文件',
	'FileSize'					=> '大小',
	'FileTotal'					=> '总数',

	// Sysinfo module
	'SysInfo'					=> '版本信息：',
	'SysParameter'				=> '参数',
	'SysValues'					=> '值',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> '最近更新',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Server name',
	'WebServer'					=> 'Web server',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'SQL 模式全局',
	'SqlModesSession'			=> 'SQL 模式会话',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> '内存',
	'UploadFilesizeMax'			=> '上传最大文件大小',
	'PostMaxSize'				=> 'post最大尺寸',
	'MaxExecutionTime'			=> '最长执行时间',
	'SessionPath'				=> '会话路径',
	'PhpDefaultCharset'			=> 'PHP 默认字符集',
	'GZipCompression'			=> 'GZip 压缩',
	'PhpExtensions'				=> 'PHP 扩展',
	'ApacheModules'				=> 'Apache 模块',

	// DB repair module
	'DbRepairSection'			=> '修复数据库',
	'DbRepair'					=> '修复数据库',
	'DbRepairInfo'				=> '该脚本可以自动查找一些常见的数据库问题并进行修复。 修复可能需要一段时间，所以请耐心等待。',

	'DbOptimizeRepairSection'	=> '修复和优化数据库',
	'DbOptimizeRepair'			=> '修复和优化数据库',
	'DbOptimizeRepairInfo'		=> '此脚本还可以尝试优化数据库。 这在某些情况下提高了性能。 修复和优化数据库可能需要很长时间，并且在优化时数据库会被锁定。',

	'TableOk'					=> '%1 表没问题。',
	'TableNotOk'				=> '%1 表不正常。 它报告以下错误：%2。 此脚本将尝试修复此表&hellip;',
	'TableRepaired'				=> '已成功修复 %1 表。',
	'TableRepairFailed'			=> '无法修复 %1 表。 <br>错误：%2',
	'TableAlreadyOptimized'		=> '%1 表已优化。',
	'TableOptimized'			=> '已成功优化 %1 表。',
	'TableOptimizeFailed'		=> '未能优化 %1 表。 <br>错误：%2',
	'TableNotRepaired'			=> '一些数据库问题无法修复。',
	'RepairsComplete'			=> '修复完成',

	// Inconsistencies module
	'InconsistenciesInfo'		=> '显示和修复不一致、删除或将孤立记录分配给新用户/值。',
	'Inconsistencies'			=> '不一致',
	'CheckDatabase'				=> '数据库',
	'CheckDatabaseInfo'			=> '检查数据库中的记录不一致。',
	'CheckFiles'				=> '文件',
	'CheckFilesInfo'			=> '检查放弃的文件，文件表中没有参考的文件。',
	'Records'					=> '记录',
	'InconsistenciesNone'		=> '未发现数据不一致。',
	'InconsistenciesDone'		=> '数据不一致已解决。',
	'InconsistenciesRemoved'	=> '删除了不一致',
	'Check'						=> '检查',
	'Solve'						=> '解决',

	// Bad Behavior module
	'BbInfo'					=> '检测并阻止不需要的 Web 访问，拒绝自动垃圾邮件程序访问<br>有关详细信息，请访问 %1 主页。',
	'BbEnable'					=> '启用不良行为',
	'BbEnableInfo'				=> '所有其他设置都可以在配置文件夹 %1 中更改。',
	'BbStats'					=> '不良行为在过去 7 天内阻止了 %1 次访问尝试。',

	'BbSummary'					=> '摘要',
	'BbLog'						=> '日志',
	'BbSettings'				=> '设置',
	'BbWhitelist'				=> '白名单',

	// --> Log
	'BbHits'					=> '点击量',
	'BbRecordsFiltered'			=> '显示 %1 条记录，共 %2 条记录，筛选条件为',
	'BbStatus'					=> '状态',
	'BbBlocked'					=> '已屏蔽',
	'BbPermitted'				=> '允许',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> '显示所有 %1 记录',
	'BbShow'					=> '显示',
	'BbIpDateStatus'			=> 'IP/日期/状态',
	'BbHeaders'					=> '标头',
	'BbEntity'					=> '实体',

	// --> Whitelist
	'BbOptionsSaved'			=> '选项已保存。',
	'BbWhitelistHint'			=> '不适当的白名单将使您暴露在垃圾邮件中，或导致不良行为完全停止运作！ 除非您 100% 确定您应该列入白名单，否则请勿列入白名单。',
	'BbIpAddress'				=> 'IP地址',
	'BbIpAddressInfo'			=> '要列入白名单的 IP 地址或 CIDR 格式地址范围（每行一个）',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> '在您的网站主机名之后以 / 开头的 URL 片段（每行一个）',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> '要列入白名单的user agent字符串（每行一个）',

	// --> Settings
	'BbSettingsUpdated'			=> '更新了不良行为设置',
	'BbLogRequest'				=> '记录 HTTP 请求',
	'BbLogVerbose'				=> '详细',
	'BbLogNormal'				=> '正常（推荐）',
	'BbLogOff'					=> '不记录（不推荐）',
	'BbSecurity'				=> '安全',
	'BbStrict'					=> '严格检查',
	'BbStrictInfo'				=> '阻止更多垃圾邮件，但可能会阻止某些人',
	'BbOffsiteForms'			=> '允许来自其他网站的表单发布es',
	'BbOffsiteFormsInfo'		=> 'OpenID 需要； 增加收到的垃圾邮件',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> '要使用 Bad Behavior 的 htt安全p:BL 功能，您必须拥有 %1',
	'BbHttpblKey'				=> 'http:BL 访问密钥',
	'BbHttpblThreat'			=> '最低威胁等级（推荐 25）',
	'BbHttpblMaxage'			=> '数据的最大年龄（建议 30）',
	'BbReverseProxy'			=> '反向代理/负载均衡器',
	'BbReverseProxyInfo'		=> '如果您在反向代理、负载平衡器、HTTP 加速器、内容缓存或类似技术后面使用不良行为，请启用反向代理选项。<br>' .
									'如果您的服务器和公共 Internet 之间有两个或多个反向代理链，您必须指定所有代理服务器、负载平衡器的<em>所有</em> IP 地址范围（以 CIDR 格式） 等。否则，Bad Behavior 可能无法确定客户端的真实 IP 地址。<br>' .
									'此外，您的反向代理服务器必须在 HTTP 标头中设置从其接收请求的 Internet 客户端的 IP 地址。 如果您不指定标头，将使用 %1。 大多数代理服务器已经支持 X-Forwarded-For，然后您只需确保在您的代理服务器上启用它。 其他一些常用的标头名称包括 %2 和 %3。',
	'BbReverseProxyEnable'		=> '启用反向代理',
	'BbReverseProxyHeader'		=> '包含 Internet 客户端 IP 地址的标头',
	'BbReverseProxyAddresses'	=> '代理服务器的 IP 地址或 CIDR 格式地址范围（每行一个）',

];
