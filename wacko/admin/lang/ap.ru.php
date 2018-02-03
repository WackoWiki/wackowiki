<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'					=> '��������: ����� ����������� ����������� �/��� ���������������� ����������� <strong>������������</strong> ������������� ������� ������ � �����!',

	'CategoryArray'		=> [
		'basics'		=> '������� �������',
		'preferences'	=> '���������',
		'content'		=> '�������',
		'users'			=> '�������������',
		'maintenance'	=> '������������',
		'messages'		=> '���������',
		'extension'		=> '����������',
		'database'		=> '���� ������',
	],

	// Admin panel
	'AdminPanel'				=> '����������������� ������',
	'RecoveryMode'				=> '����� ��������������',
	'Authorization'				=> '�����������',
	'AuthorizationTip'			=> '����������, ������� ���������������� ������ (��������� �����, ��� cookies � ����� �������� ���������).',
	'NoRecoceryPassword'		=> '���������������� ������ �� �����!',
	'NoRecoceryPasswordTip'		=> '��������: ���������� ����������������� ������ ������������ ������ ��� ������������! ������� ������ � ����� �������� � ��������� ��������� ��������.',

	'ErrorLoadingModule'		=> '������ �������� ����������������� ������ %1: ������ �� ����������.',

	'FormSave'					=> '���������',
	'FormReset'					=> '��������',
	'FormUpdate'				=> '��������',

	'ApHomePage'				=> '������� �������� �����',
	'ApHomePageTip'				=> '������� ������� �������� �����, �� �������� ����� �����������������',
	'ApLogOut'					=> '�����',
	'ApLogOutTip'				=> '��������� ����������������� �������',

	'TimeLeft'					=> '�������� �������:  %1 �����',
	'ApVersion'					=> '������',

	'SiteOpen'					=> '�������',
	'SiteOpened'				=> '���� ������',
	'SiteOpenedTip'				=> '���� ������',
	'SiteClose'					=> '�������',
	'SiteClosed'				=> '���� ������',
	'SiteClosedTip'				=> '���� ������',

	// Generic
	'Cancel'					=> '������',
	'Add'						=> '��������',
	'Edit'						=> '�������������',
	'Remove'					=> '�������',
	'Enabled'					=> '��������',
	'Disabled'					=> '���������',
	'On'						=> '���.',
	'Off'						=> '����.',
	'Mandatory'					=> '������������',
	'Admin'						=> '�������������',

	'MiscellaneousSection'		=> '������',
	'MainSection'				=> '�������� ���������',

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
		'name'		=> '�������',
		'title'		=> '�������� ���������',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> '������� ���',
		'title'		=> '��������� �������� ����',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Email',
		'title'		=> '��������� Email',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> '������',
		'title'		=> '��������� �������',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> '���������',
		'title'		=> '��������� ��������������',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> '�����������',
		'title'		=> '��������� �����������',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> '��������',
		'title'		=> '������ � ��������� ��������� �������',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> '����������',
		'title'		=> '��������� ����������',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> '������������',
		'title'		=> '��������� ��������� ������������',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> '���������',
		'title'		=> '��������� ���������',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> '��������',
		'title'		=> '��������� ����������� ������',
	],

	// Categories module
	'content_categories'		=> [
		'name'		=> '���������',
		'title'		=> '���������� �����������',
	],

	// Comments module
	'content_comments'		=> [
		'name'		=> '�����������',
		'title'		=> '���������� ������������',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> '��������� ���������',
		'title'		=> '���������� ������� ������� ��������� ����������',
	],

	// Files module
	'content_files'		=> [
		'name'		=> '���������� �����',
		'title'		=> '���������� ����������� �������',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> '����',
		'title'		=> '����������, �������������� ��� �������� ������� ������������ ����',
	],

	// Pages module
	'content_pages'		=> [
		'name'		=> '��������',
		'title'		=> '���������� ����������',
	],

	// Polls module
	'content_polls'		=> [
		'name'		=> '���������� ��������',
		'title'		=> '��������������, ������ � ��������� �������',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> '��������� �����������',
		'title'		=> '��������� ����������� ������',
	],

	// DB Convert module
	'db_convert'		=> [
		'name'		=> '��������������',
		'title'		=> '�������������� ������ ��� ��������',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> '�������������� ������',
		'title'		=> '�������������� � ����������� ���� ������ ',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> '�������������� ����',
		'title'		=> '�������������� ��������� ����� ������',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> '������� ����',
		'title'		=> '���������� WackoWiki',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> '��������������',
		'title'		=> '����������� ��������� ����������� ������',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> '������������� ������',
		'title'		=> '������������� ���� ������',
	],

	// Transliterate module
	'maint_transliterate'		=> [
		'name'		=> '��������������',
		'title'		=> '���������� ������� supertag � ������� ���� ������',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> '�������� ��������',
		'title'		=> '�������� �������� Email',
	],

	// System message module
	'messages'		=> [
		'name'		=> '��������� ���������',
		'title'		=> '��������� ���������',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> '�������� � �������',
		'title'		=> '�������� � �������',
	],

	// System log module
	'system_log'		=> [
		'name'		=> '��������� ������',
		'title'		=> '������ ��������� �������',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> '����������',
		'title'		=> '���������� �������',
	],

	// Bad Behavior module
	'badbehavior'		=> [
		'name'		=> '������ ���������',
		'title'		=> '�������������� ����������',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> '������������� �����������',
		'title'		=> '������������� ����������� �������������',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> '������',
		'title'		=> '���������� ��������',
	],

	// User module
	'user_users'		=> [
		'name'		=> '������������',
		'title'		=> '���������� ��������������',
	],

	// Main module
	'PurgeSessions'				=> '�������',
	'PurgeSessionsTip'			=> '������� ��� ������',
	'PurgeSessionsConfirm'		=> '������� � �������� ������? ��� ��������� ������ ���� ������� �������������.',
	'PurgeSessionsExplain'		=> '������� ��� ������. ��� ��������� ������ ���� ������� ������������� � �������� ������� auth_token.',
	'PurgeSessionsDone'			=> '������ �������.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> '��������� ������� ���������',
	'LogBasicSettingsUpdated'	=> '��������� ������� ���������',

	'SiteName'					=> '�������� �����',
	'SiteNameInfo'				=> '���������, ������������ �� ��������� �����, � email-������������ � �.�.',
	'SiteDesc'					=> '�������� �����',
	'SiteDescInfo'				=> '���������� � ��������� �����, ������������ � ������ �������.',
	'AdminName'					=> '��� ��������� �����',
	'AdminNameInfo'				=> '��� ������������, ����������� �� ����� ��������� �����. ��� ��� �� ������������ ��� ����������� ���� �������, �� ����������, ����� ��� ��������������� ����� �������� �������������� �����.',

	'LanguageSection'			=> '�������� ���������',
	'DefaultLanguage'			=> '���� �� ���������',
	'DefaultLanguageInfo'		=> '���������� ���� ��������� ��� ����������� �������������������� ������, � ����� ��������� ������ � ������� �������������� ������� �������.',
	'MultiLanguage'				=> '������������� ���������',
	'MultiLanguageInfo'			=> '�������� ����������� ������ ����� �� ������������ ������.',
	'AllowedLanguages'			=> 'Allowed languages',
	'AllowedLanguagesInfo'		=> 'It is recomended to select only the set of languages you want to use, other wise all languages are selected.',

	'CommentSection'			=> '�����������',
	'AllowComments'				=> '��������� �����������',
	'AllowCommentsInfo'			=> 'Enable comments for guest or registered users only or disable them on the entire site.',
	'SortingComments'			=> '���������� ������������',
	'SortingCommentsInfo'		=> 'Changes the order the page comments are presented, either with the most recent OR the oldest comment at the top.',

	'ToolbarSection'			=> '������',
	'CommentsPanel'				=> '������ ������������',
	'CommentsPanelInfo'			=> '�� ��������� ���������� � ������ ����� ������� ������ ������������.',
	'FilePanel'					=> '������ ������',
	'FilePanelInfo'				=> '�� ��������� ���������� � ������ ����� ������� ������ ������������� ������.',
	'RatingPanel'				=> '������ ��������',
	'RatingPanelInfo'			=> '�� ��������� ���������� � ������ ����� ������� ������ �������� ���������.',
	'TagsPanel'					=> 'Tags panel',
	'TagsPanelInfo'				=> 'The default display of the tags panel in the bottom of the page.',
	'HideRevisions'				=> 'Hide Revisions',
	'HideRevisionsInfo'			=> 'The default display of revisions of the page.',
	'TocPanel'					=> '������ ����������',
	'TocPanelInfo'				=> '�� ��������� ���������� ������ ���������� ��������� (��������� ��������� � ������� ����������).',
	'SectionsPanel'				=> '������ ��������',
	'SectionsPanelInfo'			=> '�� ��������� ���������� ������ �������� ���������� (��������� ��������� � ������� ����������).',
	'DisplayingSections'		=> '����������� ��������',
	'DisplayingSectionsInfo'	=> '��� ���������� ���������� �����, ������� �� �������� ������ �������� �������� (<em>������</em>), ������ �������� (<em>�������</em>) ��� � ��, � ������ (<em>������</em>).',
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
	'DefaultRenameRedirect'		=> '��� �������������� ������� ��������',
	'DefaultRenameRedirectInfo'	=> '�� ��������� ���������� ��������� �������� �� ������� ������ ������������� ��������.',
	'StoreDeletedPages'			=> '������� ��������� ��������',
	'StoreDeletedPagesInfo'		=> '��� �������� �������� (�����������) �������� �� � ����������� ������, ��� ��� ��� ��������� ����� (��������� ����) ����� �������� ��� ��������� � ��������������.',
	'KeepDeletedTime'			=> '���� �������� ��������� �������',
	'KeepDeletedTimeInfo'		=> '������ � ����. ����� ����� ������ ��� ���������� ���������� �����. ���� ��������� �� ������ �������� (��� ���� ������������� ����� ������� "�������" �������).',
	'PagesPurgeTime'			=> '���� �������� �������� �������',
	'PagesPurgeTimeInfo'		=> '������������� ������� �������� ������ ������� ����� ����. ���� ������ ����, ������ �������� ��������� �� �����.',
	'EnableReferrers'			=> 'Enable Referrers',
	'EnableReferrersInfo'		=> 'Allows to store and show external referrers.',
	'ReferrersPurgeTime'		=> '���� �������� ����������',
	'ReferrersPurgeTimeInfo'	=> '������� ������� ����������� ������� ������� �� ����� ������� ����� ����. ���� �������� ������ ��������, ������ ��� ������� ����������� ����� ��� ����� �������� � ������������ ���� ������.',
	'AttachmentHandler'			=> 'Enable attachments handler',
	'AttachmentHandlerInfo'		=> 'Allows to show the attachments handler.',
	'SearchEngineVisibility'	=> 'Block search engines (Search Engine Visibility)',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site, It is up to search engines to honor this request.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> '���������� ������������ ����������� ����������� �����.',
	'AppearanceSettingsUpdated'	=> 'Updated appearance settings.',

	'LogoOff'					=> '����.',
	'LogoOnly'					=> '�������',
	'LogoAndTitle'				=> '������� � ���������',

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
	'Theme'						=> '���� ����������',
	'ThemeInfo'					=> '������ ���������� �����, ������������ �� ���������.',
	'ThemesAllowed'				=> 'Allowed Themes',
	'ThemesAllowedInfo'			=> 'Select the allowed themes, which the user can choose, otherwise all available themes are allowed.',
	'ThemesPerPage'				=> 'Themes per page',
	'ThemesPerPageInfo'			=> 'Allow themes per page, which the page owner can choose via page properties.',

	// System settings
	'SystemSettingsInfo'		=> '������ ����������, ���������� �� ������ ��������� ���������. �� ������� ��, ���� �� ������� � ����� ���������.',
	'SystemSettingsUpdated'		=> 'Updated system settings',

	'DebugModeSection'			=> '����� �������',
	'DebugMode'					=> '����� �������',
	'DebugModeInfo'				=> '�������� � ����� ��������������� ������ � ������� ���������� ���������. ��������: ����� ������ ����������� ����������� ���������� ���������� � ���������� ������, �������� ��� ����������� ��������� ����� �������������� � �������������� ��.',
	'DebugModes'	=> [
		'0'		=> '������� ���������',
		'1'		=> '������ ����� ����� ����������',
		'2'		=> '��������� ����� ����������',
		'3'		=> '������ ����������� (����, ��� � ��.)',
	],
	'DebugSqlThreshold'			=> '����� ���������� ����',
	'DebugSqlThresholdInfo'		=> '� ���������������� ������ ������� ����������� ������ �������, �������� ������� ����� ������.',
	'DebugAdminOnly'			=> '�������� �����������',
	'DebugAdminOnlyInfo'		=> '���������� ��������������� ������ ���������� ��������� (� ����) ������ ��� ��������������.',

	'CachingSection'			=> '��������� �����������',
	'Cache'						=> '���������� ��������� �������',
	'CacheInfo'					=> '��������� ������������ �������� � ��������� ���� ��� ��������� ����������� ��������. ��������� ������ ��� �������������������� �����������.',
	'CacheTtl'					=> '���� ������������ ���� �������',
	'CacheTtlInfo'				=> '���������� �������� �� ����� ��� �� ��������� ����� ������.',
	'CacheSql'					=> '���������� ������� ����',
	'CacheSqlInfo'				=> '��������� � ��������� ���� ���������� ������������ ������������ SQL-��������.',
	'CacheSqlTtl'				=> '���� ������������ ���� ����',
	'CacheSqlTtlInfo'			=> '���������� ���������� SQL-�������� �� ����� ��� �� ��������� ����� ������. ������������� �������� ����� 1200 ������������.',

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

	'RewriteMode'					=> '������������ <code>mod_rewrite</code>',
	'RewriteModeInfo'				=> '���� ���-������ ������������ ������ �������, ��������, ����� �������� "��������" ������ �������.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parameters responsible for Access control and permissions.',
	'PermissionsSettingsUpdated'	=> 'Updated permissions settings',

	'PermissionsSection'		=> '������� � ����������',
	'ReadRights'				=> '����� ������ �� ���������',
	'ReadRightsInfo'			=> '������������� ����������� �������� ���������, � ����� ���������, ��� ������� �� ������� ���������� ������������ �����.',
	'WriteRights'				=> '����� ������ �� ���������',
	'WriteRightsInfo'			=> '������������� ����������� �������� ���������, � ����� ���������, ��� ������� �� ������� ���������� ������������ �����.',
	'CommentRights'				=> '����� ��������������� �� ���������',
	'CommentRightsInfo'			=> '������������� ����������� �������� ���������, � ����� ���������, ��� ������� �� ������� ���������� ������������ �����.',
	'CreateRights'				=> '����� �������� ���������� �� ���������',
	'CreateRightsInfo'			=> '���������� ������ ��� �������� �������� �������, � ����� ������������� ���������, ��� ������� �� ������� ���������� ������������ �����.',
	'UploadRights'				=> '����� �������� ������ �� ���������',
	'UploadRightsInfo'			=> '������������� ����������� �������� ���������, � ����� ���������, ��� ������� �� ������� ���������� ������������ �����.',
	'RenameRights'				=> '����� ����������� ��������������',
	'RenameRightsInfo'			=> '������ ������� �� ����������� ���������� �������������� (��������) ����������.',

	'LockAcl'					=> 'Lock all ACL to read only',
	'LockAclInfo'				=> '<span class="cite">Overwrites the acl settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period for security reasons or as a emergency response.',
	'HideLocked'				=> '�������� ����������� ��������',
	'HideLockedInfo'			=> '���� ������������ �� ����� ���� �� ������ ��������, �������� �� � ��������� ������� ���������� (����������� � ������� ������, ������, ����� ��-�������� �����).',
	'RemoveOnlyAdmins'			=> '������ �������������� ����� ������� ��������',
	'RemoveOnlyAdminsInfo'		=> '��������� ����, ����� ���������������, ������� �������� �����. � ������ ������� ����������� ���������������� �� ������� ���������� ����������.',
	'OwnersRemoveComments'		=> '��������� ������� ����� ������� �����������',
	'OwnersRemoveCommentsInfo'	=> '��������� ���������� ���������� ������������ ����������� �� ����� ���������.',
	'OwnersEditCategories'		=> '��������� ������� ����� ������������� �������� �����',
	'OwnersEditCategoriesInfo'	=> '��������� ���������� ���������� �������� ������ �������� ���� ����� (��������� �����, ������� �����), ������������� ���������.',
	'TermHumanModeration'		=> '���� ���� ���������',
	'TermHumanModerationInfo'	=> '���������� ����� ������������� �����������, ������ ���� �� ���� ������� �������� ������� ���� ����� (��� ����������� �� ���������������� �� ��������� ����������� � ����).',

	// Security settings
	'SecuritySettingsInfo'		=> '���������, ���������� �� ����� ������������ ���������, ������� � ������ �������������� ��������� ������������.',
	'SecuritySettingsUpdated'	=> '��������� ��������� ������������',

	'AllowRegistration'			=> '����������� �� �����',
	'AllowRegistrationInfo'		=> '�������� ����������� �������������. ���������� ����� �������� ��������� �����������, ������, ������������� ����� ������ �������������� ������ ������������� ��������������.',
	'ApproveNewUser'			=> 'Approve new users',
	'ApproveNewUserInfo'		=> 'Allows Administrators to approve users once they register. Only approved users will be allowed to log in the site.',
	'PersistentCookies'			=> 'Persistent cookies',
	'PersistentCookiesInfo'		=> 'Allow persistent cookies.',
	'AntiDupe'					=> '����-����',
	'AntiDupeInfo'				=> '��������� ���������������� �� ����� ��� �������, <span class="underline">��������</span> �� ����� ������������ ������������� (����� ����� �� ������ ������������ ������� ����� ��� ������� ������������). ��� ����������� ����� ����������� ������, <span class="underline">����������</span> �����.',
	'DisableWikiName'			=> 'Disable WikiName',
	'DisableWikiNameInfo'		=> 'Disable the the mandatory use of WikiName. Allows to register users with traditional nicknames, not forced NameSurname.',
	'AllowEmailReuse'			=> 'Allow email address re-use',
	'AllowEmailReuseInfo'		=> 'Different users can register with the same e-mail address.',
	'UsernameLength'			=> 'Username length',
	'UsernameLengthInfo'		=> 'Minimum and maximum number of characters in usernames.',

	'CaptchaSection'			=> '���� �������� (CAPTCHA)',
	'EnableCaptcha'				=> 'Enable Captcha',
	'EnableCaptchaInfo'			=> 'If enabled, Captcha will be shown in the following cases or if a security threshold is reached.',
	'CaptchaComment'			=> 'New comment',
	'CaptchaCommentInfo'		=> '� �������� ���� ������ �� �������� ���������� ��������� �� �������������������� ������������� ����������� ������� ����� ����� ����������� ������������.',
	'CaptchaPage'				=> 'New page',
	'CaptchaPageInfo'			=> '� �������� ���� ������ �� �������� ���������� ��������� �� �������������������� ������������� ����������� ������� ����� ����� ������� �������.',
	'CaptchaEdit'				=> 'Edit page',
	'CaptchaEditInfo'			=> '� �������� ���� ������ �� �������� ���������� ��������� �� �������������������� ������������� ����������� ������� ����� ����� ������� �������.',
	'CaptchaRegistration'		=> 'Registration',
	'CaptchaRegistrationInfo'	=> '� �������� ���� ������ �� �������� ���������� ��������� �� �������������������� ������������� ����������� ������� ����� ����� ������������',

	'TlsSection'				=> '��������� TLS',
	'TlsConnection'				=> 'TLS-�����������',
	'TlsConnectionInfo'			=> '������������ TLS-���������� �����������. <span class="cite">��� ��������� ��������� ��������������� ��������� �� ������ SSL-�����������, ����� �� �������� ������� � ���������������� ������!</span><br>�� ����� ����������, ���������� �� ���������� ���� Cookie, the <code>secure</code> ���� ���������, ������ �� cookies ������������ ������ ����� ���������� ����������.',
	'TlsImplicit'				=> '�������������� TLS',
	'TlsImplicitInfo'			=> '������������� �������������� ������� c HTTP �� HTTPS. ��� ����������� ����� ������ ����� ������������� ���� �� ��������� HTTP-������.',
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

	'UserPasswordSection'		=> '��������� ���������������� �������',
	'PwdMinChars'				=> '����������� ����� ������',
	'PwdMinCharsInfo'			=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 12 to 16 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'AdminPwdMinChars'			=> 'Minimum Admin password length',
	'AdminPwdMinCharsInfo'		=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 15 to 20 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'PwdCharComplexity'			=> '��������� ��������� ������',
	'PwdCharClasses'	=> [
		'0'		=> '�� �����������',
		'1'		=> '����� ����� + �����',
		'2'		=> '��������� � �������� + �����',
		'3'		=> '��������� � �������� + ����� + �������',
	],
	'PwdUnlikeLogin'			=> '�������������� ���������',
	'PwdUnlikes'	=> [
		'0'		=> '�� �����������',
		'1'		=> '������ �� ��������� ������',
		'2'		=> '������ �� �������� �����',
	],

	'LoginSection'				=> 'Login',
	'MaxLoginAttempts'			=> 'Maximum number of login attempts per username',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximum number of login attempts per IP address',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'LogSection'				=> '��������� �������',
	'LogLevel'					=> '����� ������� �������',
	'LogLevelInfo'				=> '����������� ��������� �������, ����������� � ����.',
	'LogThresholds'	=> [
		'0'		=> '�� ����� ������',
		'1'		=> '������ ����������� �������',
		'2'		=> '�� ���������� ������',
		'3'		=> '�� �������� ������',
		'4'		=> '�� �������� ������',
		'5'		=> '�� ������� ������',
		'6'		=> '�� ������������ ������',
		'7'		=> '����������� ��',
	],
	'LogDefaultShow'			=> '����� ����������� �������',
	'LogDefaultShowInfo'		=> '����������� ��������� �������, ������������ � ���� �� ���������.',
	'LogModes'	=> [
		'1'		=> '������ ����������� �������',
		'2'		=> '�� ���������� ������',
		'3'		=> '�� �������� ������',
		'4'		=> '�� �������� ������',
		'5'		=> '�� ������� ������',
		'6'		=> '�� ������������ ������',
		'7'		=> '���������� ��',
	],
	'LogPurgeTime'				=> '���� �������� �������',
	'LogPurgeTimeInfo'			=> '������� ������� ����, ������ ������� ����� ����.',

	'FormsSection'				=> 'Forms',
	'FormTokenTime'				=> 'Maximum time to submit forms',
	'FormTokenTimeInfo'			=> 'The time a user has to submit a form (in seconds).<br> Use -1 to disable. Note that a form might become invalid if the session expires, regardless of this setting.',

	'SessionLength'				=> '���� ������������� cookie',
	'SessionLengthInfo'			=> '����� ����� ������������� ����������������� cookie �� ��������� (� ����).',
	'CommentDelay'				=> '����-���� ��� ������������',
	'CommentDelayInfo'			=> '����������� �������� ����� ����������� ������������� ����� ������������ (� ��������).',
	'IntercomDelay'				=> '����-���� ��� ������ ���������',
	'IntercomDelayInfo'			=> '����������� �������� ����� ��������� ������������� ��������� ��������� ����� (� ��������).',

	//Formatter settings
	'FormatterSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'FormatterSettingsUpdated'	=> 'Updated formatting settings',

	'TextHandlerSection'		=> '����������� ������',
	'Typografica'				=> '��������������� ���������',
	'TypograficaInfo'			=> '���������� ������������� ������� ��������� ���������� ������������ � ���������� �������.',
	'Paragrafica'				=> '��������������� ��������',
	'ParagraficaInfo'			=> '���������� ���������� �����, �� ���������� �������� � ������������������� �������������� ����������: <code>{{toc}}</code>.',
	'AllowRawhtml'				=> '���������� ��������� HTML',
	'AllowRawhtmlInfo'			=> '������������� ���� ����� ��� ��������� ����� ������������ �����������.',
	'SafeHtml'					=> '���������� HTML',
	'SafeHtmlInfo'				=> '��������� ���������� ������� HTML-��������. ��������� ������ �� �������� ����� ��� ���������� ��������� HTML <span class="underline">������</span> ������������!',

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

	'DateFormatsSection'		=> '������� ���',
	'DateFormat'				=> '������ ����',
	'DateFormatInfo'			=> '(����, �����, ���)',
	'TimeFormat'				=> '������ �������',
	'TimeFormatInfo'			=> '(����, ������)',
	'TimeFormatSeconds'			=> '������ ������� �������',
	'TimeFormatSecondsInfo'		=> '(����, ������, �������)',
	'NameDateMacro'				=> '������ ������� <code>::@::</code>',
	'NameDateMacroInfo'			=> '(���, �����), e.g. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> '������� ����',
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
	'PagesSettingsUpdated'		=> '��������� ��������� ��������� �������',

	'ListCount'					=> 'Number of items per list',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> '��������� ������',
	'ForumCluster'				=> '������� ������',
	'ForumClusterInfo'			=> '����� ��������� (�������) �������� ������.',
	'ForumTopics'				=> '���������� ��� �� ��������',
	'ForumTopicsInfo'			=> '���������� ���, ������������ �� ������ �������� ������ � �������� ������.',
	'CommentsCount'				=> '���������� ������������ �� ��������',
	'CommentsCountInfo'			=> '���������� ������������, ������������ �� ������ �������� ������ ������������. ��� ��������� �� ���� ������������ �� �����, � �� ������ ����������� � ������.',

	'NewsSection'				=> '������ ��������',
	'NewsCluster'				=> '������� ������� ��������',
	'NewsClusterInfo'			=> '������ �������� ���������� �������.',
	'NewsLevels'				=> '������� ��������� ������� �� ����� ��������',
	'NewsLevelsInfo'			=> '���������� ��������� (regexp-����� SQL), ������������ ���������� ������������� �������� �� ����� ���������� �������� ��������������� �� ���� ������� ��������� ���������. (e.g. <code>[cluster]/[year]/[month]</code> -> <code>/.+/.+/.+</code>)',

	'LicenseSection'			=> 'License',
	'DefaultLicense'			=> 'Default license',
	'DefaultLicenseInfo'		=> 'Under which license should your content be released.',

	'ServicePagesSection'		=> '��������� ��������',
	'RootPage'					=> '������� ��������',
	'RootPageInfo'				=> '��� ������� ��������, ������������� �����������, ����� ������������ �������� ����.',
	'PolicyPage'				=> '�������� � �������',
	'PolicyPageinfo'			=> '�������� � ��������� �����.',
	'SearchPage'				=> '�����',
	'SearchPageInfo'			=> '�������� � ������ ������ (�������� <code>{{search}}</code>).',
	'RegistrationPage'			=> '����������� �� �����',
	'RegistrationPageInfo'		=> '�������� ����������� ������ ������������ (�������� <code>{{registration}}</code>).',
	'LoginPage'					=> '���� ��� �������������',
	'LoginPageInfo'				=> '�������� ����������� �� ����� (�������� <code>{{login}}</code>).',
	'SettingsPage'				=> '��������� �������',
	'SettingsPageInfo'			=> '�������� ��������� ����������������� ������� (�������� <code>{{usersettings}}</code>).',
	'PasswordPage'				=> '����� ������',
	'PasswordPageInfo'			=> '�������� � ������ ��� ���������/������� ����������������� ������ (�������� <code>{{changepassword}}</code>).',
	'UsersPage'					=> '������ �������������',
	'UsersPageInfo'				=> '�������� �� ������� ������������������ ������������� (�������� <code>{{users}}</code>).',
	'CategoryPage'				=> 'Category',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action <code>{{category}}</code>).',
	'TagPage'					=> 'Tag',
	'TagPageInfo'				=> 'Page with a list of tagged pages (action <code>{{tag}}</code>).',
	'GroupsPage'				=> '������ �����',
	'GroupsPageInfo'			=> '�������� �� ������� ������� ����� (�������� <code>{{usergroups}}</code>).',
	'ChangesPage'				=> '��������� ���������',
	'ChangesPageInfo'			=> '�������� �� ������� ��������� ���������� ���������� (�������� <code>{{changes}}</code>).',
	'CommentsPage'				=> '��������� �����������',
	'CommentsPageInfo'			=> '�������� �� ������� ��������� ������������������� ���������� (�������� <code>{{commented}}</code>).',
	'RemovalsPage'				=> '��������� ���������',
	'RemovalsPageInfo'			=> '�������� �� ������� ������� ��������� ���������� (�������� <code>{{deleted}}</code>).',
	'WantedPage'				=> '����������� ���������',
	'WantedPageInfo'			=> '�������� �� ������� ������������� ����������, �� ������� ���� ������ (�������� <code>{{wanted}}</code>).',
	'OrphanedPage'				=> '������� ���������',
	'OrphanedPageInfo'			=> '�������� �� ������� ������������ ����������, �� ��������� �������� � ���������� (�������� <code>{{orphaned}}</code>).',
	'TodoPage'					=> '�����������',
	'TodoPageInfo'				=> '�������� �� ������� To Do (�������� � ������� �������� <code>{{backlinks}}</code> � �������� <code>::*::</code>).',
	'SandboxPage'				=> '���������',
	'SandboxPageInfo'			=> '��������, ��� ������������ ����� ��������������� � ������������� wiki-��������.',
	'WikiDocsPage'				=> '������������ wiki',
	'WikiDocsPageInfo'			=> '������ ������������ �� ������ � ������������� �����.',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameters for notifications of the platform.',
	'NotificationSettingsUpdated'	=> 'Updated notification settings',

	'EmailNotification'			=> 'Email Notification',
	'EmailNotificationInfo'		=> 'Allow email notification. Set to ON to enable email notifications, OFF to disable them. Note that disabling email notifications has no effect on emails generated as part of the user signup process.',
	'Autosubscribe'				=> '������������',
	'AutosubscribeInfo'			=> '������������� ����������� ��������� ����� �������� �� ����������� � �� ����������.',

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
	'Synchronize'				=> '����������������',
	'UserStatsSynched'			=> '���������� ������������� ����������������.',
	'PageStatsSynched'			=> 'Page Statistics ����������������.',
	'FeedsUpdated'				=> 'RSS-������ ���������.',
	'SiteMapCreated'			=> 'The new version of the site map created successfully.',
	'WikiLinksRestored'			=> 'Wiki-������ �������������.',

	'LogUserStatsSynched'		=> '���������� ������������� ����������������.',
	'LogPageStatsSynched'		=> '���������� ������� ����������������.',
	'LogFeedsUpdated'			=> 'RSS-������ ���������.',

	'UserStats'					=> '���������������� ����������',
	'UserStatsInfo'				=> '���������� ������������� (���������� ������������, ������� �� ��������, revisions � files) � ��������� ��������� ����� ����������� � ��������� �������. <br>��� �������� ��������� ����������� ���������� �� ������� ����������� ������ ��.',
	'PageStats'					=> 'Page ����������',
	'PageStatsInfo'				=> 'Page ���������� (���������� ������������, files � revisions) � ��������� ��������� ����� ����������� � ��������� �������. <br>��� �������� ��������� ����������� ���������� �� ������� ����������� ������ ��.',
	'Feeds'						=> 'RSS-������',
	'FeedsInfo'					=> '� ������ ������ ������ ���������� � ���� ������, ���������� RSS-����� �� ������� ��������� ���������. ������ ������� �������������� RSS-������ � ������� ���������� ��.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'WikiLinksResync'			=> 'Wiki-������',
	'WikiLinksResyncInfo'		=> '��������� ��������� ��������� ���� �������������� ������ � ��������������� ���������� ������� <code>page_link</code> � <code>file_link</code> � ������ �� ����� ��� ����������� (����� ������ ������������ �����).',

	// Email settings
	'EmaiSettingsInfo'			=> '��� ���������� ������������ ��� �������� ������������ email-��������� �������������. �������������� � ������������ ��������� email-�������, ��� ������������ ��� �� ������������ ��������� �����, ��������, ���������� �� ���. ���� ��� ������ �� ������������ ������������� ���������� (� PHP) ������ email, �� ������ ���������� ��������� �������� � �������������� SMTP. ��� ����� ��������� ����� ����������� ������� (���� �����, �������� �� ���� � ����������). ���� ������ ������� �������������� (� ������ � ���� ������), ������� ����������� ���, ������ � ����� ��������������.',

	'EmailSettingsUpdated'		=> 'Updated Email settings',

	'EmailFunctionName'			=> '��� ������� email',
	'EmailFunctionNameInfo'		=> '������� email, ������������ ��� �������� ��������� ����� PHP.',
	'UseSmtpInfo'				=> '�������� <code>SMTP</code>, ���� ������ ��� ������ ���������� email-��������� ����� ������ ������ ��������� ������� mail.',

	'EnableEmail'				=> '��������� email-���������',
	'EnableEmailInfo'			=> '��������� �������� email-��������� ������',

	'FromEmailName'				=> '��� ����������� ��-���������',
	'FromEmailNameInfo'			=> '��� ����������� ������������ � ���� <code>From:</code> �� ���� email-������������, ���������� ������.',
	'NoReplyEmail'				=> '����� ����������� ��-���������',
	'NoReplyEmailInfo'			=> '����� ����������� ��-���������, �������� <code>noreply@example.com</code>, ������������ � ���� <code>From:</code> �� ���� email-������������, ���������� ������.',
	'AdminEmail'				=> '�������� email-�����',
	'AdminEmailInfo'			=> '���� ����� ������������ ��� ���������������� �����, �������� ����������� ����� �������������.',
	'AbuseEmail'				=> 'Email-����� ��� �����',
	'AbuseEmailInfo'			=> '��� �������� �� ������� �������: ����������� � ������ email � �.�. ����� ��������� � ����������.',

	'SendTestEmail'				=> '��������� �������� email-���������',
	'SendTestEmailInfo'			=> '����� ���������� �������� email-��������� �� �����, ��������� � ����� ������� ������.',
	'TestEmailSubject'			=> 'WackoWiki �������� ��� �������� email-���������',
	'TestEmailBody'				=> '���� �� �������� ��� ������, ������ WackoWiki ��������� �������� ��� �������� email-���������.',
	'TestEmailMessage'			=> '�������� email-��������� ����������.<br>���� �� �� �������� �������� email-���������, ��������� ��������� �����.',

	'SmtpAutoTls'				=> '������������������ TLS',
	'SmtpAutoTlsInfo'			=> '������������� �������� ����������, ���� ������ ������������ TLS-����������. ���� ���� �� �� ������� ����� ���������� ��� <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> '����� �������������� ��� SMTP',
	'SmtpConnectionModeInfo'	=> '������������ ������ � ������, ���� ������ ���/������. �������� � ������ ����������, ���� �� �������, ����� ����� �������������� ������������.',
	'SmtpPassword'				=> '������ SMTP',
	'SmtpPasswordInfo'			=> '������� ������, ������ ���� SMTP ������� �����.<br><em><strong>��������:</strong> ���� ������ ����� ������� � ���� ������ � ��������������� ���� � ����� ����� ����, ��� ����� ������ � ��� ��� � ���� �������� ��������.</em>',
	'SmtpPort'					=> '���� ������� SMTP',
	'SmtpPortInfo'				=> '��������� ���� ������ � ��� ������, ���� ��� ����� ��������, ��� ������ ���������� ������ ����. <br>(����������: <code>tls</code> ���� 587 (��� 25) � <code>ssl</code> ���� 465)',
	'SmtpServer'				=> '����� ������� SMTP',
	'SmtpServerInfo'			=> '������, ��� ���������� ��������� �������� ��� ���������� � �������� SMTP. ��������: <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> '��������� SMTP',
	'SmtpUsername'				=> '��� ������������ SMTP',
	'SmtpUsernameInfo'			=> '������� ��� ������ � ������, ���� ������ SMTP ������� �����.',

	// Upload settings
	'UploadSettingsInfo'		=> '����� �� ������ ��������� �������� ��������� �������� � ��������� � ���� ����������� ���������.',
	'UploadSettingsUpdated'		=> 'Updated upload settings',

	'RightToUpload'				=> 'Right to the upload files',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belongig to admins group can upload the files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadOnlyImages'			=> '��������� ������ �����������',
	'UploadOnlyImagesInfo'		=> '��������� �������� ������ ����������� ������ �� �������� �����.',
	'FileUploads'				=> '�������� ������',
	'UploadMaxFilesize'			=> '������������ ������ �����',
	'UploadMaxFilesizeInfo'		=> '������������ ������ ������� ������������ �����. ���� �������� ����� 0, ������ ����� ��������� ������ ������������� PHP.',
	'UploadQuota'				=> '����� ����� ��������',
	'UploadQuotaInfo'			=> '����������� ��������� �������� ������������ ��� ��������. �������� 0 ������������� ��������������� �������.',
	'UploadQuotaUser'			=> '����� �� ��������� ����� ������, ����������� �������������',
	'UploadQuotaUserInfo'		=> '����������� ���������� ������ ������, ������� ����� ��������� ���� ������������, 0 �������� ���������� �����������.',
	'CheckMimetype'				=> '��������� ��������',
	'CheckMimetypeInfo'			=> '��������� �������� ����� ���� �������� ��� ����������� MIME-���� ����������� ������. ��������� ������ ����� �����������, ��� ����� �����, ��������� �����, ����� ����������� �� ����� ��������.',

	'Thumbnails'				=> '���������',
	'CreateThumbnail'			=> '��������� ���������',
	'CreateThumbnailInfo'		=> '��� ��������� ����� ��� ����������� �������� ����� ����������� ��������� �� ���� ��������� ���������.',
	'MaxThumbWidth'				=> '������������ ������ ��������',
	'MaxThumbWidthInfo'			=> '������ ����������� �������� �� ����� ��������� ���������� ����� �������.',
	'MinThumbFilesize'			=> '����������� ������ ������ ��� ��������',
	'MinThumbFilesizeInfo'		=> '��������� �� ����� ����������� ��� �������� ������ ���������� �������.',

	// Deleted module
	'DeletedObjectsInfo'		=> '�������� ��������� ���������� � �����, ����� ������� �������� � ������� ��������.
									������������ ������� ��� ������������ �������� ��� ���� �� ���� ������ �����, ����� �� ������ <em>�������</em>
									� ��������������� ������. (������ ���������, ������������� �� �������� �� �������������!)',

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
	'LogFilterTip'				=> '������������� ������� �� ���������',
	'LogLevel'					=> '�������',
	'LogLevelFilters'	=> [
		'1'		=> '�� ����, ���',
		'2'		=> '�� ����, ���',
		'3'		=> '�������������',
	],
	'LogNoMatch'				=> '��� �������, ��������������� ���������',
	'LogDate'					=> '����',
	'LogEvent'					=> '�������',
	'LogUsername'				=> '������������',
	'LogLevels'	=> [
		'1'		=> '�����������',
		'2'		=> '���������',
		'3'		=> '�������',
		'4'		=> '�������',
		'5'		=> '������',
		'6'		=> '�����������',
		'7'		=> '����������',
	],

	// Massemail module
	'MassemailInfo'				=> '� ������� ���� ���� �� ������ ��������� ����������� ��������� ���� ������������� ��� ������������� ����������� ������, <strong>������� ���������� ����� ��������� ����������� ���������</strong>. ��� ���������� ����� ��������� ����� ���������� � ������������ ������ �������������� � ����� �������� ������� ������ ��� ���� �����������. �� ��������� ����� ��������� �������� �������� 20 �����������. ���� ����������� ������, �� ����� ���������� ��������� ���������. ���� �� ����������� ��������� ������� ������ �����, �� ��� �������� ����� ������ ��������� �����. ����������, ������ ��������� � �� �������������� �������� �������� ����� �������� ���������. �� ������ ���������� �� �������� ���������� ��������.',
	'LogMassemail'				=> 'Messemail send %1 to group / user ',
	'MassemailSend'				=> 'Massemail send',

	'NoEmailMessage'			=> '���������� ������ ����� ���������',
	'NoEmailSubject'			=> '���������� ������� ��������� ���������',

	'MessageSubject'			=> 'Subject',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> '����� ���������',
	'YourMessageInfo'			=> '����� ������������ ������ ������� �����. ��� �������� ����� ������� ����� ���������.',

	'MessageLanguage'			=> 'Language',
	'MessageLanguageInfo'		=> '',
	'SendMail'					=> 'Send',

	'SendToGroup'				=> '������� ������',
	'SendToUser'				=> '������� ������������',

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

	'UserApproveInfo'			=> '��������������� ����� �������������.',
	'Approve'					=> '���������',
	'Deny'						=> '��������',
	'Pending'					=> '������� �������',
	'Approved'					=> '��������',
	'Denied'					=> '��������',

	// DB Backup module
	'BackupStructure'			=> '���������',
	'BackupData'				=> '������',
	'BackupFolder'				=> '�������',
	'BackupTable'				=> '�������',
	'BackupCluster'				=> '�������',
	'BackupFiles'				=> '�����',
	'BackupSettings'			=> '������� ��������� ����� ��������������. ' .
									'�������� ������� �� ������ �� ��������� ����������� ���������� ������ � ������ ���� (��� �� ������ ��� ������ ����������� ���������).<br> ' .
									'<br> ' .
									'<strong>��������</strong>: �� ��������� ������ ���������� �� ���� ������ WackoWiki, ��� �������� ����� ��������, ������� �� ������ ��������� ����� �� ����� �������������������, ' .
									'����������, ��� �������������� ������ ��������� ������� ��� ���������� ������. ' .
									'��� ������ ����������� ������ � ������ ��������� ����� ���������� ���������� <em>������ �������������� ���� ���� ������ (��������� � ����������) ��� �������� ��������</em>.',
	'BackupCompleted'			=> '��������� ����������� � ��������� ���������.<br>' .
									'����� ��������� ����� �������� � ����� � ��������� %1.<br>' .
									'��� ��� ��������� ����������� FTP (�� �������� ��� ����������� ��������� ��������� ��������� � ����� ������ � ����������).<br>' .
									'������������ ��������� ����� ��� ������� ����� ����� � ������� <a href="%2">��������������</a>.',
	'LogSavedBackup'			=> '��������� ��������� ����� ���� ������ ##%1##',

	// DB Restore module
	'RestoreInfo'				=> '�� ������ ������������ ����� �� ��������� ��������� �������, ���� ������� ��� � �������.',
	'ConfirmDbRestore'			=> '�� ������ ������������ ��������� �����',
	'ConfirmDbRestoreInfo'		=> '����������, ���������. ��� ����� ������ ��������� �����.',
	'RestoreWrongVersion'		=> '������������ ������ WackoWiki!',
	'BackupDelete'				=> '�� �������, ��� ������ ������� ��������� �����',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> '�������������� ����� ��� ��������������',
	'RestoreOptionsInfo'		=> '* ����� ��������������� ��������� ����� <strong>��������</strong> WackoWiki, ' .
									'������� ������� �� ������������ (���� ������������� ������ ���������� �� ������������������� ���������). ' .
									'����� �������, � �������� �������������� ����� ����������� ������������� ������. ' .
									'� ������� ������ ��� ��� ����� �������� �������� �� ��������� ����� (� ������� SQL-���������� <code>REPLACE</code>), <br>' .
									'�� ���� ���� ������ ����������, ��� ��������� ����� ��������� (����� ��������� ������� �������� �������), <br>' .
									'� ��������� � ������� ������ ������ � ������ ������� (SQL-����������� <code>INSERT IGNORE</code>).<br>' .
									'<strong>��������</strong>: ��� �������������� ������ ��������� ����� ����� ��� ����� �� ����� ��������.<br> ' .
									'<br> ' .
									'** ���� ��������� ����� �������� ���������������� ����� (���������� � ������������, ����� ���� � ��.), �� � ������� ������ ��� �������������� ��� ������� ����������� �����, ����������� � ��� �� ���������. ' .
									'��� ����� ��������� ��������� ������� ����� ������, � ������������ �� ��������� ����� ������ ����� (������������� �� �������) �����. ',
	'IgnoreDuplicatedKeys'		=> '������������ ����������� ����� ������� (�� ��������)',
	'IgnoreSameFiles'			=> '������������ ����������� ����� (�� ��������������)',
	'NoBackupsAvailable'		=> '��������� ����� �����������.',
	'BackupEntireSite'			=> '���� ����',
	'BackupRestored'			=> '��������� ����� �������������, ����� ���������� �������� ����. ����� ������� ������ ��������� �����, ������� �����',
	'BackupRemoved'				=> '��������� ��������� ����� ������� �������.',
	'LogRemovedBackup'			=> '������� ��������� ����� ���� ������ ##%1##',

	'RestoreStarted'			=> '������ �������������� ��������� �����',
	'RestoreParameters'			=> '���������� ���������',
	'IgnoreDublicatedKeys'		=> '������������ ����������� �����',
	'IgnoreDublicatedFiles'		=> '������������ ����������� �����',
	'SavedCluster'				=> '�������� �������',
	'DataProtection'			=> '������ ������ - %1 ������',
	'AssumeDropTable'			=> '������������ %1',
	'RestoreTableStructure'		=> '�������������� ��������� ������',
	'RunSqlQueries'				=> '��������� SQL-����������',
	'CompletedSqlQueries'		=> '���������. ���������� ����������',
	'NoTableStructure'			=> '��������� ������ �� ��������� - ����������',
	'RestoreRecords'			=> '�������������� ����������� ������',
	'ProcessTablesDump'			=> '��������� � ������������ ���� ������',
	'Instruction'				=> '����������',
	'RestoredRecords'			=> '�������',
	'RecordsRestoreDone'		=> '���������. ���� �������',
	'SkippedRecords'			=> '������ �� ��������� - ����������',
	'RestoringFiles'			=> '�������������� ������',
	'DecompressAndStore'		=> '������������� � ��������� ���������� ����������',
	'HomonymicFiles'			=> '����������� �����',
	'RestoreSkip'				=> '����������',
	'RestoreReplace'			=> '��������',
	'RestoreFile'				=> '������',
	'Restored'					=> '��������',
	'Skipped'					=> '���������',
	'FileRestoreDone'			=> '���������. ���� ������',
	'FilesAll'					=> '�����',
	'SkipFiles'					=> '����� �� ��������� - ����������',
	'RestoreDone'				=> '�������������� ���������',

	'BackupCreationDate'		=> '���� ��������',
	'BackupPackageContents'		=> '���������� ������',
	'BackupRestore'				=> '������������',
	'BackupRemove'				=> '�������',
	'RestoreYes'				=> '��',
	'RestoreNo'					=> '���',
	'LogDbRestored'				=> '������������� ��������� ����� ���� ������ ##%1##.',

	// User module
	'UsersInfo'					=> 'Here you can change your users information and certain specific options.',

	'UsersAdded'				=> '������������ ��������',
	'UsersDeleteInfo'			=> '�������� ������������',
	'UserEditButton'			=> '�������������',
	'UserEnabled'				=> '��������',
	'UsersAddNew'				=> '�������� ������ ������������',
	'UsersDelete'				=> '�� �������, ��� ������ ������� ������������ ',
	'UsersDeleted'				=> '������������ ��� ������ �� ���� ������.',
	'UsersRename'				=> '������������� ������������',
	'UsersRenameInfo'			=> '* ��������: ��������� �������� ��� �������� ����� ������������.',
	'UsersUpdated'				=> '������������ ������� ��������.',

	'UserName'					=> '��� ������������',
	'UserRealname'				=> '��������� ���',
	'UserEmail'					=> 'Email',
	'UserIP'					=> 'IP',
	'UserLanguage'				=> '����',
	'UserSignuptime'			=> '���� �����������',
	'UserActions'				=> '��������',
	'NoMatchingUser'			=> '��� �������������, ��������������� �������� ���������',

	// Groups module
	'GroupsInfo'				=> 'From this panel you can administrate all your usergroups. You can delete, create and edit existing groups. Furthermore, you may choose group leaders, toggle open/hidden/closed group status and set the group name and description.',

	'LogMembersUpdated'			=> 'Updated usergroup members',
	'LogMemberAdded'			=> 'Added member ##%1## into group ##%2##',
	'LogMemberRemoved'			=> 'Removed member ##%1## from group ##%2##',
	'LogGroupCreated'			=> 'Created a new group ##%1##',
	'LogGroupRenamed'			=> 'Group ##%1## renamed to ##%2##',
	'LogGroupRemoved'			=> 'Removed group ##%1##',

	'GroupsMembersFor'			=> '��������� ������',
	'GroupsDescription'			=> '��������',
	'GroupsModerator'			=> '���������',
	'GroupsOpen'				=> '��������',
	'GroupsActive'				=> '��������',
	'GroupsTip'					=> '������������� ������',
	'GroupsUpdated'				=> '������ ���������',
	'GroupsAlreadyExists'		=> '��� ������ ��� ����������.',
	'GroupsAdded'				=> '������ ���������.',
	'GroupsRenamed'				=> '������ �������������.',
	'GroupsDeleted'				=> '������ ������� �� ���� ������ � ���� �������.',
	'GroupsAdd'					=> '�������� ����� ������',
	'GroupsRename'				=> '������� ������',
	'GroupsRenameInfo'			=> '* ��������: ��������� �������� ��� �������� �������������, �������� � ������.',
	'GroupsDelete'				=> '�� �������, ��� ������ ������� ������ ',
	'GroupsDeleteInfo'			=> '* ��������: ��������� �������� ���� �������������, �������� � ������.',
	'GroupsStoreButton'			=> '��������� ������',
	'GroupsSaveButton'			=> '���������',
	'GroupsCancelButton'		=> '��������',
	'GroupsAddButton'			=> '��������',
	'GroupsEditButton'			=> '��������',
	'GroupsRemoveButton'		=> '�������',
	'GroupsEditInfo'			=> '��� �������������� ������ ����� �������� �����-������.',

	'MembersAddNew'				=> '�������� ������ ���������',
	'MembersAdded'				=> '�������� �������� � ������.',
	'MembersRemove'				=> '����� ����� �� �������� ��������� ',
	'MembersRemoved'			=> '�������� �� ������ ������.',
	'MembersDeleteInfo'			=> '* ��������: ��������� �������� ���� �������������, �������� � ������.',

	// Statistics module
	'DbStatSection'				=> '���������� ���� ������',
	'DbTable'					=> '�������',
	'DbRecords'					=> '�����',
	'DbSize'					=> '�����',
	'DbIndex'					=> '������',
	'DbOverhead'				=> '������������',
	'DbTotal'					=> '�����',

	'FileStatSection'			=> '���������� �������� �������',
	'FileFolder'				=> '�������',
	'FileFiles'					=> '������',
	'FileSize'					=> '�����',
	'FileTotal'					=> '�����',

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
	'TranslitField'				=> '����������������� ���� %1 � �������  `%2`.',
	'TranslitStart'				=> '����',
	'TranslitContinue'			=> '����������',
	'TranslitCompleted'			=> '��������� ���������� ���������.',


];

?>
