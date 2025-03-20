<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'zh',
'LangLocale'	=> 'zh_CN',
'LangName'		=> '简体中文',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> '分类',
	'groups_page'		=> '用户组',
	'users_page'		=> '用户',

	'search_page'		=> '搜索',
	'login_page'		=> '登录',
	'account_page'		=> '帐户',
	'registration_page'	=> '创建账户',
	'password_page'		=> '密码',

	'changes_page'		=> '最近更改',
	'comments_page'		=> '最近评论',
	'index_page'		=> '页面索引',

	'random_page'		=> '随机条目',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki 配置',
'TitleUpdate'					=> 'WackoWiki 更新',
'Continue'						=> '继续',
'Back'							=> '后退',
'Recommended'					=> '建议',
'InvalidAction'					=> '无效操作',

/*
   Language Selection Page
*/
'lang'							=> '语言设置',
'PleaseUpgradeToR6'				=> '你正在运行一个旧版本（前 %2）。 若要更新到 当前版本，您必须先更新您的安装包到 %2。',
'UpgradeFromWacko'				=> '欢迎使用 WackoWiki，看来您正在从 WackoWiki %1 升级到 %2。 下面的几页将引导您完成升级过程。',
'FreshInstall'					=> '欢迎使用 WackoWiki，即将安装 WackoWiki %1。下面几个页面将引导您完成安装过程。',
'PleaseBackup'					=> '请 <strong>备份</strong> 您的数据库 配置文件和所有更改过的文件，例如那些在开始升级之前自己修改的文件。 请务必备份，这可以将您从懊恼后悔中解救出来。',
'LangDesc'						=> '请选择在安装过程中使用的语言。这个语言也会成为网站的默认语言，不过以后也可以随时更改。',

/*
   System Requirements Page
*/
'version-check'					=> '系统要求',
'PhpVersion'					=> 'PHP 版本',
'PhpDetected'					=> '检测到的 PHP',
'ModRewrite'					=> 'Apache Rewrite Extension （可选）',
'ModRewriteInstalled'			=> '重写扩展 (mod_rewrite) 已安装？',
'Database'						=> '数据库',
'PhpExtensions'					=> 'PHP扩展',
'Permissions'					=> '权限',
'ReadyToInstall'				=> '准备好安装吗？',
'Requirements'					=> '您的服务器必须满足下面列出的要求。',
'OK'							=> '确定',
'Problem'						=> '问题',
'Example'						=> '示例',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> '你的PHP安装似乎缺少WackoWiki所需要的PHP扩展。',
'PcreWithoutUtf8'				=> 'PHP的PCRE模块在编译时可能没有包含PCRE_UTF8支持。',
'NotePermissions'				=> '此安装程序将尝试将配置数据写入你的WackoWiki 目录中的文件 %1。 为了使此文件生效，您必须确保网页服务器能够写入该文件。 如果您不能这样做，您将需要手动编辑文件 （安装程序将告诉您如何操作）。<br><br>详情请参阅 <a href="https://wackowiki.org/doc/Doc/简体中文/安装指南" target="_blank">WackoWiki:Doc/简体中文/安装指南</a>',
'ErrorPermissions'				=> '看起来安装程序无法自动设置WackoWiki所需的文件权限。 您将在稍后被提示手动配置您服务器上所需的文件权限。',
'ErrorMinPhpVersion'			=> 'PHP 版本必须大于 %1。您的服务器似乎正在运行早期版本。 您必须升级到 WackoWiki 的最新PHP 版本才能正常工作。',
'Ready'							=> '恭喜，您的服务器似乎能够运行 WackoWiki。下面的几个页面将带你完成配置过程。',

/*
   Site Config Page
*/
'config-site'					=> '设置网站',
'SiteName'						=> 'Wiki 名称',
'SiteNameDesc'					=> '请输入您的 Wiki 站点名称。',
'SiteNameDefault'				=> '我的Wiki',
'HomePage'						=> '主页',
'HomePageDesc'					=> '输入您想要的主页名称。 这将是用户访问您的网站时将会看到的默认页面，并且应该是 <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>。',
'HomePageDefault'				=> '首页',
'MultiLang'						=> '多语言模式',
'MultiLangDesc'					=> '多语言模式允许您在单个安装中拥有不同语言设置的页面。 启用此模式时，安装程序会分别为所有支持的语言创建初始菜单项。',
'AllowedLang'					=> '允许的语言',
'AllowedLangDesc'				=> '建议仅选择您要使用的语言集，否则选择所有语言。',
'AclMode'							=> '默认 ACL 设置',
'AclModeDesc'							=> '',
'PublicWiki'							=> '公开维基(为每个人阅读，为注册用户撰写和评论)',
'PrivateWiki'							=> '私有维基(只为注册用户读取、写入、评论)',
'Admin'							=> '管理员用户名',
'AdminDesc'						=> '输入管理员用户名，这应该是 <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">Wikiname</a> (e.g. <code>WikiAdmin</code>)。',
'NameAlphanumOnly'				=> '用户名必须 %1 - %2 字符并且是字母数字组合',
'NameCamelCaseOnly'				=> '用户名的长度必须在%1到%2个字符之间，并且为WikiName的格式。',
'Password'						=> '管理员密码',
'PasswordDesc'					=> '为管理员设置密码至少 %1 个字符。',
'PasswordConfirm'				=> '确认管理员密码：',
'Mail'							=> '管理员邮箱地址',
'MailDesc'						=> '输入管理员邮箱地址。',
'Base'							=> '基础 URL',
'BaseDesc'						=> '您的 WackoWiki 站点URL。 页面名称被附加到它，所以如果你正在使用 mod_rewrite 地址，应该以前方的slash结尾，即：',
'Rewrite'						=> '重写模式',
'RewriteDesc'					=> '如果您使用 WackoWiki 并重写URL，应该启用重写模式。',
'Enabled'						=> '启用：',
'ErrorAdminEmail'				=> '您输入的 email 地址无效。',
'ErrorAdminPasswordMismatch'	=> '您输入的两个密码不一致。',
'ErrorAdminPasswordShort'		=> '您输入的密码太短，请输入最少 %1 个字符。',
'ModRewriteStatusUnknown'		=> '安装程序无法验证mod_rewrite已启用，但这并不意味着它已被禁用',

/*
   Database Config Page
*/
'config-database'				=> '数据库配置',
'DbDriver'						=> '驱动',
'DbDriverDesc'					=> '您想要使用的数据库驱动程序。',
'DbSqlMode'						=> 'SQL mode',
'DbSqlModeDesc'					=> 'The SQL mode you want use.',
'DbVendor'						=> 'Vendor',
'DbVendorDesc'					=> 'The database vendor you use.',
'DbCharset'						=> '字符集',
'DbCharsetDesc'					=> '您想要使用的数据库字符集。',
'DbEngine'						=> '存储引擎',
'DbEngineDesc'					=> '您想要使用的数据库引擎。',
'DbHost'						=> '数据库主机',
'DbHostDesc'					=> '您的数据库服务器正在运行的主机。通常 <code>127.0.0.1</code> or <code>localhost</code> （ie, 是您WackoWiki 网站开通的同一机器）。',
'DbPort'						=> '数据库端口 （可选）',
'DbPortDesc'					=> '您的数据库服务器可以通过端口号访问。留空则使用默认端口号。',
'DbName'						=> '数据库名称',
'DbNameDesc'					=> 'WackoWiki 数据库将要使用。请确定数据库已经建立完毕！',
'DbUser'						=> '数据库用户名',
'DbUserDesc'					=> '用于连接您的数据库的用户名称。',
'DbPassword'					=> '数据库密码',
'DbPasswordDesc'				=> '用来连接数据库的用户密码。',
'Prefix'						=> '数据库表前缀',
'PrefixDesc'					=> 'WackoWiki使用的所有数据表前缀。 这允许您使用相同的数据库运行多个WackoWiki 安装，配置它们使用不同的表前缀（例如wacko_）。',
'ErrorNoDbDriverDetected'		=> '没有检测到数据库驱动程序，请在您的 php.ini 文件中启用 mysqli 或 pdo_mysql 扩展。',
'ErrorNoDbDriverSelected'		=> '没有选择数据库驱动程序，请从列表中选择一个。',
'DeleteTables'					=> '删除现有的数据表？',
'DeleteTablesDesc'				=> '注意！如果您继续选择此选项，所有当前已存在的数据将从数据库中删除。 除非您从已经备份的文件中手动还原数据，否则无法撤消。',
'ConfirmTableDeletion'			=> '您确定要删除所有当前已存在的数据表？',

/*
   Database Installation Page
*/
'install-database'				=> '数据库安装',
'TestingConfiguration'			=> '测试配置',
'TestConnectionString'			=> '测试数据库连接设置',
'TestDatabaseExists'			=> '检查您指定的数据库是否存在',
'TestDatabaseVersion'			=> '检查数据库最低版本要求',
'InstallTables'					=> '安装数据表',
'ErrorDbConnection'				=> '您指定的数据库连接出现问题，请返回并检查它们是否正确。',
'ErrorDatabaseVersion'			=> '数据库版本是 %1 ，但至少需要 %2。',
'To'							=> '到',
'AlterTable'					=> '正在更改 %1 表',
'InsertRecord'					=> '插入记录到 %1 表',
'RenameTable'					=> '正在重命名 %1 表',
'UpdateTable'					=> '正在更新 %1 表格',
'InstallDefaultData'			=> '正在添加默认数据',
'InstallPagesBegin'				=> '添加默认页面',
'InstallPagesEnd'				=> '已完成默认页面添加',
'InstallSystemAccount'			=> '添加 <code>系统</code> 用户',
'InstallDeletedAccount'			=> '添加 <code>已删除</code> 用户',
'InstallAdmin'					=> '添加管理员用户',
'InstallAdminSetting'			=> '增加管理员用户首选项',
'InstallAdminGroup'				=> '添加管理员组',
'InstallAdminGroupMember'		=> '添加管理员组成员',
'InstallEverybodyGroup'			=> '添加通用组',
'InstallModeratorGroup'			=> '添加版主组',
'InstallReviewerGroup'			=> '添加审核组',
'InstallLogoImage'				=> '添加徽标图像',
'LogoImage'						=> 'Logo图片',
'InstallConfigValues'			=> '添加配置值',
'ConfigValues'					=> '配置值',
'ErrorInsertPage'				=> '插入 %1 页面时出错',
'ErrorInsertPagePermission'		=> '设置 %1 页面权限时出错',
'ErrorInsertDefaultMenuItem'	=> '设置页面 %1 为默认菜单项时出错',
'ErrorPageAlreadyExists'		=> '%1 页面已存在',
'ErrorAlterTable'				=> '修改 %1 表时出错',
'ErrorInsertRecord'				=> '插入记录到 %1 表时出错',
'ErrorRenameTable'				=> '重命名 %1 表时出错',
'ErrorUpdatingTable'			=> '更新 %1 表时出错',
'CreatingTable'					=> '正在创建 %1 表',
'ErrorAlreadyExists'			=> '%1 已存在',
'ErrorCreatingTable'			=> '创建 %1 表时出错，它是否已经存在？',
'DeletingTables'				=> '删除表',
'DeletingTablesEnd'				=> '删除数据表',
'ErrorDeletingTable'			=> '删除 %1 表时出错，最可能的原因是表不存在，在这种情况下您可以忽略此警告。',
'DeletingTable'					=> '正在删除 %1 表',
'NextStep'						=> '此安装程序将尝试将配置数据写入你的WackoWiki 目录中的文件 %1。 为了使此文件生效，您必须确保网页服务器能够写入该文件。 如果您不能这样做，您将需要手动编辑文件 （安装程序将告诉您如何操作）。<br><br>详情请参阅 <a href="https://wackowiki.org/doc/Doc/简体中文/安装指南" target="_blank">WackoWiki:Doc/简体中文/安装指南</a>',

/*
   Write Config Page
*/
'write-config'					=> '写入配置文件',
'FinalStep'						=> '最后一步',
'Writing'						=> '写入配置文件',
'RemovingWritePrivilege'		=> '移除写入权限',
'InstallationComplete'			=> '安装完成',
'ThatsAll'						=> '万事大吉！你现在可以 <a href="%1">查看你的 WackoWiki 网站</a>。',
'SecurityConsiderations'		=> '安全考虑因素',
'SecurityRisk'					=> '建议移除已写入的对 %1 的写权限。 文件可写入可能是一个安全风险！<br> %2',
'RemoveSetupDirectory'			=> '现在安装过程已经完成，您应该删除 %1 目录。',
'ErrorGivePrivileges'			=> '无法写入配置文件 %1 。 您需要给予您的 web 服务器临时写入访问您的 WackoWiki 目录的权限。 或者一个名为 %1的空白文件<br>%2<br><br>; 不要忘记在稍后再次移除写入权限。<br>%3<br><br>',
'ErrorPrivilegesInstall'		=> '如果出于任何原因你不能这样做， 您必须将下面的文本复制到一个新文件并保存/上传为 %1 到 WackoWiki 目录。 一旦你完成了这个操作，你的 WackoWiki 网站应该正常工作。如果没有，请访问 <a href="https://wackowiki.org/doc/Doc/简体中文/安装指南" target="_blank">WackoWiki:Doc/简体中文/安装指南</a>',
'ErrorPrivilegesUpgrade'		=> '一旦你完成了这个操作，你的 WackoWiki 网站应该正常工作。如果没有，请访问 <a href="https://wackowiki.org/doc/Doc/简体中文/安装指南" target="_blank">WackoWiki:Doc/简体中文/安装指南</a>',
'WrittenAt'						=> '写入 ',
'DontChange'					=> '不要手动更改 wacko_version ！',
'ConfigDescription'				=> '详细描述 https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> '请重试',

];
