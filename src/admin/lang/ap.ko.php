<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> '기본 기능',
		'preferences'	=> '환경설정',
		'content'		=> '콘텐츠',
		'users'			=> '사용자',
		'maintenance'	=> '유지',
		'messages'		=> '메시지',
		'extension'		=> '확장 기능',
		'database'		=> '데이터베이스',
	],

	// Admin panel
	'AdminPanel'				=> '관리자 제어판',
	'RecoveryMode'				=> '복구 모드',
	'Authorization'				=> '권한 부여',
	'AuthorizationTip'			=> '관리자 비밀번호를 입력해 주세요 (브라우저에서 쿠키가 허용되어 있는지 확인해 주세요).',
	'NoRecoveryPassword'		=> '관리자 비밀번호가 지정되지 않았습니다!',
	'NoRecoveryPasswordTip'		=> '참고: 관리 비밀번호가 없으면 보안에 위협이 됩니다! 구성 파일에 비밀번호 해시를 입력하고 프로그램을 다시 실행하세요.',

	'ErrorLoadingModule'		=> '관리자 모듈 %1을 로드하는 중 오류 발생: 해당 모듈이 존재하지 않습니다.',

	'ApHomePage'				=> '홈페이지',
	'ApHomePageTip'				=> 'open the home page, you do not quit administration',
	'ApLogOut'					=> '로그아웃',
	'ApLogOutTip'				=> '시스템 관리 종료',

	'TimeLeft'					=> '남은 시간:  %1분',
	'ApVersion'					=> '버전',

	'SiteOpen'					=> 'Open',
	'SiteOpened'				=> 'site opened',
	'SiteOpenedTip'				=> 'The site is open',
	'SiteClose'					=> 'Close',
	'SiteClosed'				=> 'site closed',
	'SiteClosedTip'				=> 'The site is closed',

	'System'					=> '시스템',

	// Generic
	'Cancel'					=> '취소',
	'Add'						=> '추가',
	'Edit'						=> '편집',
	'Remove'					=> '제거',
	'Enabled'					=> '사용',
	'Disabled'					=> '비활성화됨',
	'Mandatory'					=> '필수적인',
	'Admin'						=> '관리',
	'Min'						=> 'Min',
	'Max'						=> 'Max',

	'MiscellaneousSection'		=> 'Miscellaneous',
	'MainSection'				=> '일반 옵션',

	'DirNotWritable'			=> '%1 디렉터리에 쓰기 권한이 없습니다.',
	'FileNotWritable'			=> '%1 파일에 쓰기 권한이 없습니다.',

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
		'name'		=> '기본',
		'title'		=> '기본 설정',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> '보이기',
		'title'		=> '외관 설정',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> '이메일 주소',
		'title'		=> '이메일 설정',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> '신디케이트 조직',
		'title'		=> '신디케이션',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> '필터',
		'title'		=> '필터 설정',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> '포맷터',
		'title'		=> '서식 옵션',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> '알림',
		'title'		=> '알림 설정',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> '페이지',
		'title'		=> '페이지 및 사이트 매개변수',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> '사용자 권한',
		'title'		=> '권한 설정',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> '보안',
		'title'		=> '보안 하위 시스템 설정',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> '시스템',
		'title'		=> '시스템 옵션',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> '올리기',
		'title'		=> '첨부 파일 설정',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> '삭제됨',
		'title'		=> '새로 삭제된 콘텐츠',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> '메뉴',
		'title'		=> '기본 메뉴 항목을 추가, 편집 또는 삭제합니다',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> '지원',
		'title'		=> '데이터 백업',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> '수리하다',
		'title'		=> '데이터베이스 복구 및 최적화',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> '복구',
		'title'		=> '백업 데이터 복원 중',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> '재생 메뉴',
		'title'		=> 'WackoWiki 관리자',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> '불일치',
		'title'		=> '데이터 불일치 수정',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> '데이터 동기화',
		'title'		=> '데이터 동기화',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> '회람',
		'title'		=> '대량 이메일',
	],

	// System message module
	'messages'		=> [
		'name'		=> '시스템 메시지',
		'title'		=> '시스템 메시지',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> '시스템 정보',
		'title'		=> '시스템 정보',
	],

	// System log module
	'system_log'		=> [
		'name'		=> '시스템 로그',
		'title'		=> '시스템 이벤트 로그',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> '통계',
		'title'		=> '통계 보기',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Bad Behaviour',
		'title'		=> 'Bad Behaviour',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> '승인',
		'title'		=> '사용자 등록 승인',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> '그룹',
		'title'		=> '그룹 관리',
	],

	// User module
	'user_users'		=> [
		'name'		=> '사용자',
		'title'		=> '사용자 관리',
	],

	// Main module
	'MainNote'					=> 'Note: It is recommended that access to the site be temporarily blocked for administrative maintenance.',

	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the auth_token table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> '기본 설정이 업데이트되었습니다',
	'LogBasicSettingsUpdated'	=> '기본 설정이 업데이트되었습니다',

	'SiteName'					=> 'Site Name:',
	'SiteNameInfo'				=> '이 사이트의 제목입니다. 브라우저 제목, 테마 헤더, 이메일 알림 등에 표시됩니다.',
	'SiteDesc'					=> 'Site description:',
	'SiteDescInfo'				=> 'Supplement to the title of the site that appears in the pages header. Explains, in a few words, what this site is about.',
	'AdminName'					=> 'Admin of site:',
	'AdminNameInfo'				=> 'User name of individual who is responsible for overall support of the site. This name is not used to determine access rights, but it is desirable that it conforms to the name of the chief administrator of the site.',

	'LanguageSection'			=> '언어',
	'DefaultLanguage'			=> 'Default language:',
	'DefaultLanguageInfo'		=> 'Specifies the language of messages displayed to unregistered guests, as well as the locale settings.',
	'MultiLanguage'				=> 'Multilanguage support:',
	'MultiLanguageInfo'			=> 'Enable the ability to select a language on a page-by-page basis.',
	'AllowedLanguages'			=> 'Allowed languages:',
	'AllowedLanguagesInfo'		=> 'It is recommended to select only the set of languages you want to use, otherwise all languages are selected.',

	'CommentSection'			=> '댓글',
	'AllowComments'				=> 'Allow comments:',
	'AllowCommentsInfo'			=> 'Enable comments for guests or registered users only, or disable them on the entire site.',
	'SortingComments'			=> 'Sorting comments:',
	'SortingCommentsInfo'		=> 'Changes the order the page comments are presented, either with the most recent OR the oldest comment at the top.',
	'CommentsOffset'			=> '댓글 페이지:',
	'CommentsOffsetInfo'		=> '기본적으로 표시되는 댓글 페이지',

	'ToolbarSection'			=> 'Toolbar',
	'CommentsPanel'				=> 'Comments panel:',
	'CommentsPanelInfo'			=> 'The default display of comments at the bottom of the page.',
	'FilePanel'					=> 'File panel:',
	'FilePanelInfo'				=> 'The default display of attachments at the bottom of the page.',
	'TagsPanel'					=> 'Tags panel:',
	'TagsPanelInfo'				=> 'The default display of the tags panel at the bottom of the page.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Show permalink:',
	'ShowPermalinkInfo'			=> 'The default display of the permalink for the current version of the page.',
	'TocPanel'					=> 'Table of contents panel:',
	'TocPanelInfo'				=> 'The default display table of contents panel of a page (may need support in the templates).',
	'SectionsPanel'				=> 'Sections panel:',
	'SectionsPanelInfo'			=> 'By default, display the panel of adjacent pages (requires support in the templates).',
	'DisplayingSections'		=> 'Displaying sections:',
	'DisplayingSectionsInfo'	=> 'When the previous options are set, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>), both, or other (<em>tree</em>).',
	'MenuItems'					=> 'Menu items:',
	'MenuItemsInfo'				=> 'Default number of shown menu items (may need support in the templates).',

	'HandlerSection'			=> 'Handlers',
	'HideRevisions'				=> 'Hide revisions:',
	'HideRevisionsInfo'			=> 'The default display of revisions of the page.',
	'AttachmentHandler'			=> 'Enable attachments handler:',
	'AttachmentHandlerInfo'		=> 'Permits display of the attachments handler.',
	'SourceHandler'				=> 'Enable source handler:',
	'SourceHandlerInfo'			=> 'Permits the display of the source handler.',
	'ExportHandler'				=> 'Enable XML export handler:',
	'ExportHandlerInfo'			=> 'Permits the display of the XML export handler.',

	'DiffModeSection'			=> 'Diff Modes',
	'DefaultDiffModeSetting'	=> 'Default diff mode:',
	'DefaultDiffModeSettingInfo'=> 'Preselected diff mode.',
	'AllowedDiffMode'			=> 'Allowed diff modes:',
	'AllowedDiffModeInfo'		=> 'It is recommended to select only the set of diff modes you want to use, otherwise all diff modes are selected.',
	'NotifyDiffMode'			=> 'Notify diff mode:',
	'NotifyDiffModeInfo'		=> 'Diff mode used for notifications in the email body.',

	'EditingSection'			=> 'Editing',
	'EditSummary'				=> '편집 요약:',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> '사소한 바뀜:',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'SectionEdit'				=> '섹션 편집:',
	'SectionEditInfo'			=> '페이지의 섹션만 편집할 수 있습니다.',
	'ReviewSettings'			=> 'Review:',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',
	'PublishAnonymously'		=> 'Allow anonymous publishing:',
	'PublishAnonymouslyInfo'	=> 'Allow users to publish anonymously (to hide the name).',

	'DefaultRenameRedirect'		=> 'When renaming, create redirection:',
	'DefaultRenameRedirectInfo'	=> 'By default, offer to set a redirect to the old address of the page being renamed.',
	'StoreDeletedPages'			=> 'Keep deleted pages:',
	'StoreDeletedPagesInfo'		=> 'When you delete a page, a comment or a file, keep it in a special section, where it will be available for review and recovery for some period of time (as described below).',
	'KeepDeletedTime'			=> 'Storage time of deleted pages:',
	'KeepDeletedTimeInfo'		=> 'The period in days. It makes sense only with the previous option. Use zero to ensure entities are never deleted (in this case the administrator can clear the "cart" manually).',
	'PagesPurgeTime'			=> 'Storage time of page revisions:',
	'PagesPurgeTimeInfo'		=> 'Automatically deletes the older versions within the given number of days. If you enter zero, the older versions will not be removed.',
	'EnableReferrers'			=> 'Enable referrers:',
	'EnableReferrersInfo'		=> 'Permits creation and display of external referrers.',
	'ReferrersPurgeTime'		=> 'Storage time of referrers:',
	'ReferrersPurgeTimeInfo'	=> 'Keep the history of referring external pages no longer than a given number of days. Use zero to ensure referrers are never deleted (but for an actively visited site, this can lead to database overflow).',
	'EnableCounters'			=> 'Hit Counters:',
	'EnableCountersInfo'		=> 'Allows per page hit counters and enables display of simple statistics. Views of the page owner are not counted.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Control default web syndication settings for your site.',
	'SyndicationSettingsUpdated'	=> 'Updated syndication settings.',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Enable feeds:',
	'EnableFeedsInfo'			=> 'Turns RSS feeds on or off for the entire wiki.',
	'XmlChangeLink'				=> 'Changes feed link mode:',
	'XmlChangeLinkInfo'			=> 'Defines where the XML Changes feed items links to.',
	'XmlChangeLinkMode'			=> [
		'1'		=> '차이 보기',
		'2'		=> '현재 문서',
		'3'		=> '판의 목록',
		'4'		=> '개정된 문서',
	],

	'XmlSitemap'				=> 'XML sitemap:',
	'XmlSitemapInfo'			=> 'Creates an XML file called %1 inside the xml folder. You can add the path to the sitemap in the robots.txt file in your root directory as follows:',
	'XmlSitemapGz'				=> 'XML sitemap compression:',
	'XmlSitemapGzInfo'			=> 'If you would like, you may compress your sitemap text file using gzip to reduce your bandwidth requirement.',
	'XmlSitemapTime'			=> 'XML sitemap generation time:',
	'XmlSitemapTimeInfo'		=> 'Generates the sitemap only once in the given number of days. Set to zero to generate on every page change.',

	'SearchSection'				=> '검색',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Creates the OpenSearch description file in the XML folder and enables Autodiscovery of search plugin in the HTML header.',
	'SearchEngineVisibility'	=> 'Block search engines (search engine visibility):',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site. It is up to search engines to honor this request.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Control default display settings for your site.',
	'AppearanceSettingsUpdated'	=> 'Updated appearance settings.',

	'LogoOff'					=> '끄기',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo and title',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Site logo:',
	'SiteLogoInfo'				=> 'Your logo will typically appear at the top left corner of the application. Max size is 2 MiB. Optimal dimensions are 255 pixels wide by 55 pixels high.',
	'LogoDimensions'			=> 'Logo dimensions:',
	'LogoDimensionsInfo'		=> 'Width and height of the displayed logo.',
	'LogoDisplayMode'			=> 'Logo display mode:',
	'LogoDisplayModeInfo'		=> 'Defines the appearance of the logo. Default is off.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site favicon:',
	'SiteFaviconInfo'			=> 'Your shortcut icon, or favicon, is displayed in the address bar, tabs and bookmarks of most browsers. This will override the favicon of your theme.',
	'SiteFaviconTooBig'			=> 'Favicon is bigger than 64 × 64 px.',
	'ThemeColor'				=> '주소 표시줄의 테마 색상:',
	'ThemeColorInfo'			=> '브라우저는 제공된 CSS 색상에 따라 모든 페이지의 주소 표시줄 색상을 설정합니다.',

	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Theme:',
	'ThemeInfo'					=> 'Template design the site uses by default.',
	'ResetUserTheme'			=> 'Reset all user themes:',
	'ResetUserThemeInfo'		=> 'Resets all user themes. Warning: This action will revert all user-selected themes to the global default theme.',
	'SetBackUserTheme'			=> 'Revert all user themes to %1 theme.',
	'ThemesAllowed'				=> 'Allowed Themes:',
	'ThemesAllowedInfo'			=> 'Select the allowed themes, which the user can choose; otherwise, all available themes are allowed.',
	'ThemesPerPage'				=> 'Themes per page:',
	'ThemesPerPageInfo'			=> 'Allow themes per page, which the page owner can choose via page properties.',

	// System settings
	'SystemSettingsInfo'		=> 'Group of parameters responsible for fine-tuning the site. Do not change them unless you are confident in their actions.',
	'SystemSettingsUpdated'		=> 'Updated system settings',

	'DebugModeSection'			=> 'Debug Mode',
	'DebugMode'					=> 'Debug mode:',
	'DebugModeInfo'				=> 'Extracting and outputting telemetry data about the application\'s execution time. Attention: Full detail mode imposes higher requirements to the allocated memory, especially for resource-intensive operations, such as database backup and restore.',
	'DebugModes'	=> [
		'0'		=> 'debugging is off',
		'1'		=> 'only the total execution time',
		'2'		=> 'full-time',
		'3'		=> 'full detail (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Threshold performance RDBMS:',
	'DebugSqlThresholdInfo'		=> 'In detailed debug mode, report only the queries that take longer than the number of seconds specified.',
	'DebugAdminOnly'			=> 'Closed diagnosis:',
	'DebugAdminOnlyInfo'		=> 'Show debug data of the program (and DBMS) only for the administrator.',

	'CachingSection'			=> 'Caching Options',
	'Cache'						=> 'Cache rendered pages:',
	'CacheInfo'					=> 'Save rendered pages in the local cache to speed up the subsequent boot. Valid only for unregistered visitors.',
	'CacheTtl'					=> 'Time-to-live for cached pages:',
	'CacheTtlInfo'				=> 'Cache pages no more than a specified number of seconds.',
	'CacheSql'					=> 'Cache DBMS queries:',
	'CacheSqlInfo'				=> 'Maintain a local cache of the results of certain resource-related SQL queries.',
	'CacheSqlTtl'				=> 'Time-to-live for cached SQL queries:',
	'CacheSqlTtlInfo'			=> 'Cache results of SQL queries for no more than the specified number of seconds. Values greater than 1200 are not desirable.',

	'LogSection'				=> 'Log Settings',
	'LogLevelUsage'				=> 'Use logging:',
	'LogLevelUsageInfo'			=> 'The minimum priority of the events recorded in the log.',
	'LogThresholds'	=> [
		'0'		=> 'do not keep a journal',
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high',
		'4'		=> 'on average',
		'5'		=> 'from low',
		'6'		=> 'the minimum level',
		'7'		=> 'record all',
	],
	'LogDefaultShow'			=> 'Display log mode:',
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
	'LogPurgeTime'				=> 'Storage time of Log:',
	'LogPurgeTimeInfo'			=> 'Remove event log after the specified number of days.',

	'PrivacySection'			=> '개인정보처리방침',
	'AnonymizeIp'				=> 'Anonymize users\' IP addresses:',
	'AnonymizeIpInfo'			=> 'Anonymize IP addresses where applicable (i.e., page, revision or referrers).',

	'ReverseProxySection'		=> 'Reverse Proxy',
	'ReverseProxy'				=> 'Use reverse proxy:',
	'ReverseProxyInfo'			=> 'Enable this setting to determine the correct IP address of the remote client by examining information stored in the X-Forwarded-For headers.  X-Forwarded-For headers are a standard mechanism for identifying client systems connecting through a reverse proxy server, such as Squid or Pound. Reverse proxy servers are often used to enhance the performance of heavily visited sites and may also provide other site caching, security or encryption benefits. If this WackoWiki installation operates behind a reverse proxy, this setting should be enabled so that correct IP address information is captured in WackoWiki\'s session management, logging, statistics and access management systems; if you are unsure about this setting, do not have a reverse proxy, or WackoWiki operates in a shared hosting environment, this setting should remain disabled.',
	'ReverseProxyHeader'		=> 'Reverse proxy header:',
	'ReverseProxyHeaderInfo'	=> 'Set this value if your proxy server sends the client IP in a header
									 other than X-Forwarded-For. The "X-Forwarded-For" header is a comma-delimited list of IP
									 addresses; only the last one (the left-most) will be used.',
	'ReverseProxyAddresses'		=> 'reverse_proxy accepts an array of IP addresses:',
	'ReverseProxyAddressesInfo'	=> 'Each element of this array is the IP address of any of your reverse
									 proxies. If using this array, WackoWiki will trust the information stored
									 in the X-Forwarded-For headers only if the Remote IP address is one of
									 these, that is, the request reaches the web server from one of your
									 reverse proxies. Otherwise, the client could directly connect to
									 your web server by spoofing the X-Forwarded-For headers.',

	'SessionSection'				=> 'Session Handling',
	'SessionStorage'				=> 'Session storage:',
	'SessionStorageInfo'			=> 'This option defines where the the session data is stored. By default, either file or database session storage is selected.',
	'SessionModes'	=> [
		'1'		=> '파일',
		'2'		=> '데이터베이스',
	],
	'SessionNotice'					=> '세션 종료 원인 표시:',
	'SessionNoticeInfo'				=> '세션 종료의 원인을 나타냅니다.',
	'LoginNotice'					=> '로그인 알림:',
	'LoginNoticeInfo'				=> '로그인 알림: 로그인 알림을 표시합니다.',

	'RewriteMode'					=> 'Use <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'If your web server supports this feature, enable to "beautify" the page URLs.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parameters responsible for Access control and permissions.',
	'PermissionsSettingsUpdated'	=> 'Updated permissions settings',

	'PermissionsSection'		=> 'Rights and Privileges',
	'ReadRights'				=> 'Read rights by default:',
	'ReadRightsInfo'			=> 'Default assigned to the created root pages, as well as pages for which parent ACLs cannot be defined.',
	'WriteRights'				=> 'Write rights by default:',
	'WriteRightsInfo'			=> 'Default assigned to the created root pages, as well as pages for which parent ACLs cannot be defined.',
	'CommentRights'				=> 'Comment rights by default:',
	'CommentRightsInfo'			=> 'Default assigned to the created root pages, as well as pages for which parent ACLs cannot be defined.',
	'CreateRights'				=> 'Create rights of a sub page by default:',
	'CreateRightsInfo'			=> 'Default assigned to the created sub pages.',
	'UploadRights'				=> 'Upload rights by default:',
	'UploadRightsInfo'			=> 'Default upload rights.',
	'RenameRights'				=> 'Global rename right:',
	'RenameRightsInfo'			=> 'The list of permissions to freely rename (move) pages.',

	'LockAcl'					=> 'Lock all ACLs to read only:',
	'LockAclInfo'				=> '<span class="cite">Overwrites the ACL settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period of time for security reasons, or as a emergency response to an exploit or vulnerability.',
	'HideLocked'				=> 'Hide inaccessible pages:',
	'HideLockedInfo'			=> 'If the user does not have permission to read the page, hide it in different page lists (however the link placed in text will still be visible).',
	'RemoveOnlyAdmins'			=> 'Only administrators can delete pages:',
	'RemoveOnlyAdminsInfo'		=> 'Deny all, except administrators, the ability to delete pages. The first limit applies to owners of normal pages.',
	'OwnersRemoveComments'		=> 'Owners of pages can delete comments:',
	'OwnersRemoveCommentsInfo'	=> 'Allow page owners to moderate comments on their pages.',
	'OwnersEditCategories'		=> 'Owners can edit page categories:',
	'OwnersEditCategoriesInfo'	=> 'Allow owners to modify the pages category list of your site (add words, delete words), assigns to a page.',
	'TermHumanModeration'		=> 'Human moderation expiration:',
	'TermHumanModerationInfo'	=> 'Moderators can only edit comments if they were created no more than this number of days ago (this limitation does not apply to the last comment in the topic).',

	'UserCanDeleteAccount'		=> 'Allow users to delete their accounts',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parameters responsible for the overall safety of the platform, safety restrictions and additional security subsystems.',
	'SecuritySettingsUpdated'	=> 'Updated security settings',

	'AllowRegistration'			=> 'Register online:',
	'AllowRegistrationInfo'		=> 'Open user registration. Disabling this option will prevent free registration, however, the site administrator will still be able to register users.',
	'ApproveNewUser'			=> 'Approve new users:',
	'ApproveNewUserInfo'		=> 'Allows administrators to approve users once they register. Only approved users will be allowed to log in the site.',
	'PersistentCookies'			=> 'Persistent cookies:',
	'PersistentCookiesInfo'		=> 'Allow persistent cookies.',
	'DisableWikiName'			=> 'Disable WikiName:',
	'DisableWikiNameInfo'		=> 'Disable the the mandatory use of a WikiName for users. Permits user registration with traditional nicknames instead of forced CamelCase-formatted names (i.e., NameSurname).',
	'UsernameLength'			=> 'Username length:',
	'UsernameLengthInfo'		=> 'Minimum and maximum number of characters in usernames.',

	'EmailSection'				=> '이메일 주소',
	'AllowEmailReuse'			=> 'Allow email address re-use:',
	'AllowEmailReuseInfo'		=> 'Different users can register with the same email address.',
	'EmailConfirmation'			=> '전자 메일 확인을 적용합니다:',
	'EmailConfirmationInfo'		=> '사용자가 로그인하기 전에 전자 메일 주소를 확인하도록 요구합니다.',
	'AllowedEmailDomains'		=> '허용된 전자 메일 도메인::',
	'AllowedEmailDomainsInfo'	=> '쉼표로 구분된 허용된 이메일 도메인(예: <code>example.com, local.lan</code> 등), 그렇지 않으면 모든 이메일 도메인이 허용됩니다.',
	'ForbiddenEmailDomains'		=> '금지된 이메일 도메인:',
	'ForbiddenEmailDomainsInfo'	=> '쉼표로 구분된 금지 이메일 도메인(예: <code>example.com, local.lan</code> 등). 허용된 이메일 도메인 목록이 비어 있는 경우에만 유효합니다.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Enable captcha:',
	'EnableCaptchaInfo'			=> 'If enabled, captcha will be shown in the following cases, or if a security threshold is reached.',
	'CaptchaComment'			=> 'New comment:',
	'CaptchaCommentInfo'		=> 'As protection against spam, unregistered users must complete captcha before comment will be posted.',
	'CaptchaPage'				=> 'New page:',
	'CaptchaPageInfo'			=> 'As protection against spam, unregistered users must complete captcha before creating a new page.',
	'CaptchaEdit'				=> 'Edit page:',
	'CaptchaEditInfo'			=> 'As protection against spam, unregistered users must complete captcha before editing pages.',
	'CaptchaRegistration'		=> '계정 만들기',
	'CaptchaRegistrationInfo'	=> 'As protection against spam, unregistered users must complete captcha before registering.',

	'TlsSection'				=> 'TLS Settings',
	'TlsConnection'				=> 'TLS connection:',
	'TlsConnectionInfo'			=> 'Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS certificate on the server, otherwise you will lose access to the admin panel!</span><br>It also determines if the the Cookie Secure Flag is set: The <code>secure</code> flag specifies whether cookies should only be sent over secure connections.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Forcibly reconnect the client from HTTP to HTTPS. With the option disabled, the client can browse the site through an open HTTP channel.',

	'HttpSecurityHeaders'		=> 'HTTP Security Headers',
	'EnableSecurityHeaders'		=> 'Enable security headers:',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk!',
	'Csp'						=> 'Content security policy (CSP):',
	'CspInfo'					=> 'Configuring CSP involves deciding what policies you want to enforce, and then configuring them and using Content-Security-Policy to establish your policy.',
	'PolicyModes'	=> [
		'0'		=> '비활성화됨',
		'1'		=> 'strict',
		'2'		=> 'custom',
	],
	'PermissionsPolicy'			=> 'Permissions policy:',
	'PermissionsPolicyInfo'		=> 'The HTTP Permissions-Policy header provides a mechanism to explicitly enable or disable various powerful browser features.',
	'ReferrerPolicy'			=> 'Referrer policy:',
	'ReferrerPolicyInfo'		=> 'The Referrer-Policy HTTP header governs which referrer information, sent in the Referer header, should be included in responses.',
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

	'UserPasswordSection'		=> 'Persistence of User Passwords',
	'PwdMinChars'				=> 'Minimum password length:',
	'PwdMinCharsInfo'			=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 12 to 16 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'AdminPwdMinChars'			=> 'Minimum admin password length:',
	'AdminPwdMinCharsInfo'		=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 15 to 20 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'PwdCharComplexity'			=> 'The required password complexity:',
	'PwdCharClasses'	=> [
		'0'		=> 'not tested',
		'1'		=> 'any letters + numbers',
		'2'		=> 'uppercase and lowercase + numbers',
		'3'		=> 'uppercase and lowercase + numbers + characters',
	],
	'PwdUnlikeLogin'			=> 'Additional complication:',
	'PwdUnlikes'	=> [
		'0'		=> 'not tested',
		'1'		=> 'password is not identical to the login',
		'2'		=> 'password does not contain username',
	],

	'LoginSection'				=> '로그인',
	'MaxLoginAttempts'			=> 'Maximum number of login attempts per username:',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximum number of login attempts per IP address:',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'FormsSection'				=> 'Forms',
	'FormTokenTime'				=> 'Maximum time to submit forms:',
	'FormTokenTimeInfo'			=> 'The time a user has to submit a form (in seconds).<br> Note that a form might become invalid if the session expires, regardless of this setting.',

	'SessionLength'				=> 'Session cookie expiration:',
	'SessionLengthInfo'			=> 'The lifetime of the user session cookie by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments:',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications:',
	'IntercomDelayInfo'			=> 'The minimum delay between sending private messages (in seconds).',
	'RegistrationDelay'			=> 'Time threshold for registering:',
	'RegistrationDelayInfo'		=> 'The minimum time threshold for filling out the registration form to tell away bots from humans (in seconds).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Group of parameters responsible for fine-tuning the site. Do not change them unless you are confident in their actions.',
	'FormatterSettingsUpdated'	=> 'Updated formatting settings',

	'TextHandlerSection'		=> 'Text Handler:',
	'Typografica'				=> 'Typographical proofreader:',
	'TypograficaInfo'			=> 'Disabling this option will speed up the processes of adding comments and saving pages.',
	'Paragrafica'				=> 'Paragrafica markings:',
	'ParagraficaInfo'			=> 'Similar to the previous option, but will lead to disconnection of inoperable automatic table of contents (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Global HTML support:',
	'AllowRawhtmlInfo'			=> 'This option is potentially unsafe for an open site.',
	'SafeHtml'					=> 'Filtering HTML:',
	'SafeHtmlInfo'				=> 'Prevents saving of dangerous HTML objects. Turning off the filter on an open site with HTML support is <span class="underline">extremely</span> undesirable!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formatter)',
	'X11colors'					=> 'X11 colors usage:',
	'X11colorsInfo'				=> 'Extends the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code>Disabling this option speeds up the processes of adding comments and saving pages.',
	'WikiLinks'					=> 'Disable wiki links:',
	'WikiLinksInfo'				=> 'Disables linking for <code>CamelCaseWords</code>: Your CamelCase words will no longer be linked directly to a new page. This is useful when you work across different namespaces/clusters. By default it is off.',
	'BracketsLinks'				=> 'Disable bracketed links:',
	'BracketsLinksInfo'			=> 'Disables <code>[[link]]</code> and <code>((link))</code> syntax.',
	'Formatters'				=> 'Disable Formatters:',
	'FormattersInfo'			=> 'Disables <code>%%code%%</code> syntax, used for highlighters.',

	'DateFormatsSection'		=> 'Date Formats',
	'DateFormat'				=> 'The format of the date:',
	'DateFormatInfo'			=> '(day, month, year)',
	'TimeFormat'				=> 'The format of time:',
	'TimeFormatInfo'			=> '(hour, minute)',
	'TimeFormatSeconds'			=> 'The format of the exact time:',
	'TimeFormatSecondsInfo'		=> '(hours, minutes, seconds)',
	'NameDateMacro'				=> 'The format of the <code>::@::</code> macro:',
	'NameDateMacroInfo'			=> '(name, time), e.g. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> '시간대:',
	'TimezoneInfo'				=> 'Timezone to use for displaying times to users who are not logged in (guests). Logged-in users can change their timezone in their user settings.',
	'AmericanDate'					=> '미국 날짜:',
	'AmericanDateInfo'				=> '영어의 기본으로 미국 날짜 형식을 사용합니다.',

	'Canonical'					=> 'Use fully-canonical URLs:',
	'CanonicalInfo'				=> 'All links are created as absolute URLs in the form %1. URLs relative to the server root in the form %2 should be preferred.',
	'LinkTarget'				=> 'Where external links open:',
	'LinkTargetInfo'			=> 'Opens each external link in a new browser window. Adds <code>target="_blank"</code> to the link syntax.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Requires that the browser should not send an HTTP referer header if the user follows the hyperlink. Adds <code>rel="noreferrer"</code> to the link syntax.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Tells search engines that the hyperlinks should not affect the page ranking of the target page in the search engine index. Adds <code>rel="nofollow"</code> to the link syntax.',
	'UrlsUnderscores'			=> 'Form addresses (URLs) with underscores:',
	'UrlsUnderscoresInfo'		=> 'For example, %1 becames %2 with this option.',
	'ShowSpaces'				=> 'Show spaces in WikiNames:',
	'ShowSpacesInfo'			=> 'Show spaces in WikiNames, e.g. <code>MyName</code> being displayed as <code>My Name</code> with this option.',
	'NumerateLinks'				=> 'Enumerate links in print view:',
	'NumerateLinksInfo'			=> 'Enumerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disable and visualize self-referencing links:',
	'YouareHereTextInfo'		=> 'Visualize links to the same page, using <code>&lt;b&gt;####&lt;/b&gt;</code>. All links to self lose link formatting, but are displayed as bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> '여기에서 Wiki 내에서 사용되는 시스템 기본 페이지를 설정하거나 변경할 수 있습니다. 여기 설정에 따라 Wiki에서 해당 페이지를 생성하거나 변경하는 것을 잊지 마십시오.',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Number of items per list:',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest, or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster Forum:',
	'ForumClusterInfo'			=> 'Root cluster for forum section (action %1).',
	'ForumTopics'				=> 'Number of topics per page:',
	'ForumTopicsInfo'			=> 'Number of topics displayed on each page of the list in the forum sections (action %1).',
	'CommentsCount'				=> 'Number of comments per page:',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page\'s list of comments. This applies to all the comments on the site, not just those posted in the forum.',

	'NewsSection'				=> 'Section News',
	'NewsCluster'				=> 'Cluster for the news:',
	'NewsClusterInfo'			=> 'Root cluster for news section (action %1).',
	'NewsStructure'				=> 'News cluster structure:',
	'NewsStructureInfo'			=> 'Stores the articles optionally in sub-clusters by year/month or week (e.g. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> '라이선스',
	'DefaultLicense'			=> 'Default license:',
	'DefaultLicenseInfo'		=> 'Under which license your content can be released.',
	'EnableLicense'				=> 'Enable license:',
	'EnableLicenseInfo'			=> 'Enable to show license information.',
	'LicensePerPage'			=> 'License per page:',
	'LicensePerPageInfo'		=> 'Allow license per page, which the page owner can choose via page properties.',

	'ServicePagesSection'		=> 'Service Pages',
	'RootPage'					=> '홈페이지:',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',

	'PrivacyPage'				=> '개인정보처리방침:',
	'PrivacyPageInfo'			=> 'The page with the Privacy Policy of the site.',

	'TermsPage'					=> 'Policies and regulations:',
	'TermsPageInfo'				=> 'The page with the rules of the site.',

	'SearchPage'				=> '검색:',
	'SearchPageInfo'			=> 'Page with the search form (action %1).',
	'RegistrationPage'			=> '계정 만들기:',
	'RegistrationPageInfo'		=> 'Page for new user registration (action %1).',
	'LoginPage'					=> '사용자 로그인:',
	'LoginPageInfo'				=> 'Login page on the site (action %1).',
	'SettingsPage'				=> '사용자 설정:',
	'SettingsPageInfo'			=> 'Page to customize the user profile (action %1).',
	'PasswordPage'				=> '비밀번호 변경:',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action %1).',
	'UsersPage'					=> 'User list:',
	'UsersPageInfo'				=> 'Page with a list of registered users (action %1).',
	'CategoryPage'				=> '카테고리:',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action %1).',
	'GroupsPage'				=> '그룹:',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action %1).',
	'WhatsNewPage'				=> '새로운 소식:',
	'WhatsNewPageInfo'			=> '새로 추가되거나 삭제되거나 변경된 페이지, 새 첨부 파일 및 댓글 목록이 있는 페이지입니다. (작업 %1).',
	'ChangesPage'				=> '최근 바뀜:',
	'ChangesPageInfo'			=> 'Page with a list of the last modified pages (action %1).',
	'CommentsPage'				=> '최근 댓글 목록:',
	'CommentsPageInfo'			=> 'Page with a list of recent comments on the page (action %1).',
	'RemovalsPage'				=> 'Deleted pages:',
	'RemovalsPageInfo'			=> 'Page with a list of recently deleted pages (action %1).',
	'WantedPage'				=> 'Wanted pages:',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action %1).',
	'OrphanedPage'				=> 'Orphaned pages:',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related via links to any other page (action %1).',
	'SandboxPage'				=> '샌드박스:',
	'SandboxPageInfo'			=> 'Page where users can practice their wiki markup skills.',
	'HelpPage'					=> '도움말:',
	'HelpPageInfo'				=> 'The documentation section for working with site tools.',
	'IndexPage'					=> '색인:',
	'IndexPageInfo'				=> 'Page with a list of all pages (action %1).',
	'RandomPage'				=> '무작위:',
	'RandomPageInfo'			=> 'Loads a random page (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameters for notifications of the platform.',
	'NotificationSettingsUpdated'	=> 'Updated notification settings',

	'EmailNotification'			=> 'Email notification:',
	'EmailNotificationInfo'		=> 'Allow email notification. Set to Enabled to enable email notifications, Disabled to disable them. Note that disabling email notifications has no effect on emails generated as part of the user signup process.',
	'Autosubscribe'				=> 'Autosubscribe:',
	'AutosubscribeInfo'			=> 'Automatically notify owner of page changes.',

	'NotificationSection'		=> 'Default User Notification Settings',
	'NotifyPageEdit'			=> 'Notify page edit:',
	'NotifyPageEditInfo'		=> 'Pending - Send an email notification only for the first change until the user visits the page again.',
	'NotifyMinorEdit'			=> 'Notify minor edit:',
	'NotifyMinorEditInfo'		=> 'Sends notifications also for minor edits.',
	'NotifyNewComment'			=> 'Notify new comment:',
	'NotifyNewCommentInfo'		=> 'Pending - Send an email notification only for the first comment until the user visits the page again.',

	'NotifyUserAccount'			=> 'Notify new user account:',
	'NotifyUserAccountInfo'		=> 'The Admin will to be notified when a new user has been created using the signup form.',
	'NotifyUpload'				=> 'Notify file upload:',
	'NotifyUploadInfo'			=> 'The Moderators will to be notified when a file has been uploaded.',

	'PersonalMessagesSection'	=> 'Personal Messages',
	'AllowIntercomDefault'		=> 'Allow intercom:',
	'AllowIntercomDefaultInfo'	=> 'Enabling this option allows other users to send personal messages to the recipient\'s email address without disclosing the address.',
	'AllowMassemailDefault'		=> 'Allow mass email:',
	'AllowMassemailDefaultInfo'	=> 'Only send messages to those users who have permitted administrators to email them information.',

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

	'UserStats'					=> 'User statistics',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to match actual data contained in the database.',
	'PageStats'					=> 'Page statistics',
	'PageStatsInfo'				=> 'Page statistics (number of comments, files and revisions) may differ in some situations from actual data. <br>This operation allows updating statistics to match actual data contained in database.',

	'AttachmentsInfo'			=> '데이터베이스의 모든 첨부 파일에 대한 파일 해시를 업데이트합니다.',
	'AttachmentsSynched'		=> '모든 첨부 파일 해시 재해시',
	'LogAttachmentsSynched'		=> '모든 첨부 파일 해시 재해시',

	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'In the case of direct editing of pages in the database, the content of RSS-feeds may not reflect the changes made. <br>This function synchronizes the RSS-channels with the current state of the database.',
	'XmlSiteMap'				=> 'XML Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'XmlSiteMapPeriod'			=> 'Period %1 days. Last written %2.',
	'XmlSiteMapView'			=> 'Show Sitemap in a new window.',

	'ReparseBody'				=> 'Reparse all pages',
	'ReparseBodyInfo'			=> 'Empties <code>body_r</code> in page table, so that each page gets rendered again on the next page view. This may be useful if you modified the formatter or changed the domain of your wiki.',
	'PreparsedBodyPurged'		=> 'Emptied <code>body_r</code> field in page table.',

	'WikiLinksResync'			=> 'Wiki links',
	'WikiLinksResyncInfo'		=> 'Performs a re-rendering for all intrasite links and restores the contents of the <code>page_link</code> and <code>file_link</code> tables in the event of damage or relocation (this can take considerable time).',
	'RecompilePage'				=> 'Re-compiling all pages (extremely costly)',
	'ResyncOptions'				=> '추가 옵션',
	'RecompilePageLimit'		=> 'Number of pages to parse at once.',

	// Email settings
	'EmaiSettingsInfo'			=> 'This information is used when the engine sends emails to your users. Please ensure the email address you specify is valid, any bounced or undeliverable messages will likely be sent to that address. If your host does not provide a native (PHP based) email service you can instead send messages directly using SMTP. This requires the address of an appropriate server (ask your provider if necessary). If the server requires authentication (and only if it does) enter the necessary username, password and authentication method.',

	'EmailSettingsUpdated'		=> 'Updated Email settings',

	'EmailFunctionName'			=> 'Email function name:',
	'EmailFunctionNameInfo'		=> 'The email function used to send mails through PHP.',
	'UseSmtpInfo'				=> 'Select <code>SMTP</code> if you want to, or have to, send email via a named server instead of via the local mail function.',

	'EnableEmail'				=> 'Enable emails:',
	'EnableEmailInfo'			=> 'Enable sending of emails.',

	'EmailIdentitySettings'		=> '웹사이트 이메일 신원',
	'FromEmailName'				=> 'From name:',
	'FromEmailNameInfo'			=> 'The sender name that is use for the <code>From:</code> header for all email notifications sent from the site.',
	'EmailSubjectPrefix'		=> '제목 접두사:',
	'EmailSubjectPrefixInfo'	=> '대체 이메일 제목 접두사(예: <code>[접두사] 주제</code>)입니다. 정의되지 않은 경우 기본 접두사는 사이트 이름입니다: %1.',

	'NoReplyEmail'				=> 'No-reply address:',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all email notifications sent from the site.',
	'AdminEmail'				=> 'Email of the site owner:',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service:',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may be the same as the site owner email.',

	'SendTestEmail'				=> '테스트 메일 보내기',
	'SendTestEmailInfo'			=> 'This will send a test email to the address defined in your account.',
	'TestEmailSubject'			=> 'Your Wiki is correctly configured to send emails',
	'TestEmailBody'				=> 'If you received this email, your Wiki is correctly configured to send emails.',
	'TestEmailMessage'			=> 'The test email has been sent.<br>If you don\'t receive it, please check your email configuration settings.',

	'SmtpSettings'				=> 'SMTP Settings',
	'SmtpAutoTls'				=> 'Opportunistic TLS:',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Connection mode for SMTP:',
	'SmtpConnectionModeInfo'	=> 'Only used if a username/password is required. Ask your provider if you are unsure which method to use.',
	'SmtpPassword'				=> 'SMTP password:',
	'SmtpPasswordInfo'			=> 'Only enter a password if your SMTP server requires it.<br><em><strong>Warning:</strong> This password will be stored as plaintext in the database, visible to everybody who can access your database or who can view this configuration page.</em>',
	'SmtpPort'					=> 'SMTP server port:',
	'SmtpPortInfo'				=> 'Only change this if you know your SMTP server is on a different port. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465).',
	'SmtpServer'				=> 'SMTP server address:',
	'SmtpServerInfo'			=> 'Note that you have to provide the protocol that your server uses. If you are using SSL, this has to be <code>ssl://mail.example.com</code>.',
	'SmtpUsername'				=> 'SMTP username:',
	'SmtpUsernameInfo'			=> 'Only enter a username if your SMTP server requires it.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Here you can configure the main settings for attachments and the associated special categories.',
	'UploadSettingsUpdated'		=> 'Updated upload settings',

	'FileUploadsSection'		=> 'File Uploads',
	'RegisteredUsers'			=> '등록된 사용자',
	'RightToUpload'				=> 'Permissions to upload files:',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belonging to the admins group can upload  files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadMaxFilesize'			=> 'Maximum file size:',
	'UploadMaxFilesizeInfo'		=> 'Maximum size of each file. If this value is 0, the maximum uploadable filesize is only limited by your PHP configuration.',
	'UploadQuota'				=> 'Total attachment quota:',
	'UploadQuotaInfo'			=> 'Maximum drive space available for attachments for the whole wiki, with <code>0</code> being unlimited. %1 used.',
	'UploadQuotaUser'			=> 'Storage quota per user:',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with <code>0</code> being unlimited.',

	'FileTypes'					=> 'File Types',
	'UploadOnlyImages'			=> 'Allow only upload of images:',
	'UploadOnlyImagesInfo'		=> 'Allow only uploading of image files on the page.',
	'AllowedUploadExts'			=> '허용된 파일 형식:',
	'AllowedUploadExtsInfo'		=> '파일 업로드에 허용되는 확장자는 쉼표로 구분된 파일 확장자(예: <code>png, ogg, mp4</code>)이며, 그 외에는 금지된 파일 확장자가 아닌 모든 파일 확장자가 허용됩니다.<br>업로드된 파일 형식 허용 목록을 사이트 콘텐츠 기능에 필요한 최소한의 파일로 제한해야 합니다.',
	'CheckMimetype'				=> 'Check MIME type:',
	'CheckMimetypeInfo'			=> 'Some browsers can be tricked to assume an incorrect mimetype for uploaded files. This option ensures that such files likely to cause this are rejected.',
	'SvgSanitizer'				=> 'SVG sanitizer:',
	'SvgSanitizerInfo'			=> '이렇게 하면 업로드된 SVG 파일을 살균하여 SVG/XML에 취약한 파일이 업로드되는 것을 방지할 수 있습니다.',
	'TranslitFileName'			=> '파일 이름을 음역합니다:',
	'TranslitFileNameInfo'		=> '해당되는 경우 유니코드 문자가 필요하지 않은 경우에는 영숫자 문자만 허용하는 것이 좋습니다.',
	'TranslitCaseFolding'		=> '파일 이름을 소문자로 변환합니다:',
	'TranslitCaseFoldingInfo'	=> '이 옵션은 음역이 활성화된 경우에만 유효합니다.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Create thumbnail:',
	'CreateThumbnailInfo'		=> 'Create a thumbnail in all possible situations.',
	'JpegQuality'				=> 'JPEG 품질:',
	'JpegQualityInfo'			=> 'JPEG 섬네일 크기 조정 시 품질입니다. 이 값은 1에서 100 사이여야 하며 100은 100% 품질을 나타냅니다.',
	'MaxImageArea'				=> 'Maximum image area:',
	'MaxImageAreaInfo'			=> '소스 이미지가 가질 수 있는 최대 픽셀 수입니다. 이는 이미지 스케일러의 압축 해제 측에 대한 메모리 사용량 제한을 제공합니다. <br><code>-1</code>은 이미지 크기를 확인하기 전에 스케일링을 시도하지 않음을 의미합니다. <code>0</code>은 값을 자동으로 결정한다는 의미입니다.',
	'MaxThumbWidth'				=> 'Maximum thumbnail width in pixels:',
	'MaxThumbWidthInfo'			=> 'A generated thumbnail will not exceed the width set here.',
	'MinThumbFilesize'			=> 'Minimum thumbnail file size:',
	'MinThumbFilesizeInfo'		=> 'Do not create a thumbnail for images smaller than this.',
	'MaxImageWidth'				=> '페이지의 이미지 크기 제한:',
	'MaxImageWidthInfo'			=> '페이지에서 이미지가 가질 수 있는 최대 너비이며, 그렇지 않으면 축소된 썸네일이 생성됩니다.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'List of removed pages, revisions and files.
									Remove or restore the pages, revisions or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Words that will be automatically censored on your Wiki.',
	'FilterSettingsUpdated'		=> 'Updated spam filter settings',

	'WordCensoringSection'		=> 'Word Censoring',
	'SPAMFilter'				=> 'Spam filter:',
	'SPAMFilterInfo'			=> 'Enabling Spam Filter',
	'WordList'					=> 'Word list:',
	'WordListInfo'				=> 'Word or phrase <code>fragment</code> to be blacklisted (one per line)',

	// Log module
	'LogFilterTip'				=> 'Filter events by criteria:',
	'LogLevel'					=> 'Level',
	'LogLevelFilters'	=> [
		'1'		=> 'not less than',
		'2'		=> 'not higher than',
		'3'		=> 'equal',
	],
	'LogNoMatch'				=> 'No events that meet the criteria',
	'LogDate'					=> 'Date',
	'LogEvent'					=> 'Event',
	'LogUsername'				=> '사용자 이름',
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
	'MassemailInfo'				=> 'Here you can email a message to either (1) all of your users or (2) all users of a specific group who have enabled receiving of mass emails. An email will be sent out to the administrative email address supplied, with a blind carbon copy (BCC) sent to all recipients. The default setting is to include a maximum of 20 recipients in such an email. If there are more than 20 recipients, additional emails will be sent. If you are emailing a large group of people, please be patient after submitting and do not stop the page halfway through. It is normal for a mass emailing to take a long time. You will be notified when the script has completed.',
	'LogMassemail'				=> 'Mass email send %1 to group / user ',
	'MassemailSend'				=> 'Mass email send',

	'NoEmailMessage'			=> 'You must enter a message.',
	'NoEmailSubject'			=> 'You must specify a subject for your message.',
	'NoEmailRecipient'			=> 'You must specify at least one user or user group.',

	'MassemailSection'			=> 'Mass email',
	'MessageSubject'			=> '제목:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Your message:',
	'YourMessageInfo'			=> 'Please note that you may enter only plaintext. All markup will be removed before sending.',

	'NoUser'					=> 'No user',
	'NoUserGroup'				=> 'No user group',

	'SendToGroup'				=> 'Send to group:',
	'SendToUser'				=> 'Send to user:',
	'SendToUserInfo'			=> 'Only users who permit administrators to email them information will receive mass emails. This option is available in their user settings under Notifications.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Updated system message',

	'SysMsgSection'				=> 'System Message',
	'SysMsg'					=> 'System message:',
	'SysMsgInfo'				=> 'Your text here',

	'SysMsgType'				=> 'Type:',
	'SysMsgTypeInfo'			=> 'Message type (CSS).',
	'SysMsgAudience'			=> 'Audience:',
	'SysMsgAudienceInfo'		=> 'Audience the system message is shown to.',
	'EnableSysMsg'				=> 'Enable system message:',
	'EnableSysMsgInfo'			=> 'Show system message.',

	// User approval module
	'ApproveNotExists'			=> 'Please select at least one user via the Set button.',

	'LogUserApproved'			=> 'User ##%1## approved',
	'LogUserBlocked'			=> 'User ##%1## blocked',
	'LogUserDeleted'			=> 'User ##%1## removed from the database',
	'LogUserCreated'			=> 'Created a new user ##%1##',
	'LogUserUpdated'			=> 'Updated User ##%1##',
	'LogUserPasswordReset'		=> '사용자 ##%1##의 비밀번호가 성공적으로 재설정되었습니다.',

	'UserApproveInfo'			=> 'Approve new users before they are able to login to the site.',
	'Approve'					=> '승인',
	'Deny'						=> '거절',
	'Pending'					=> 'Pending',
	'Approved'					=> 'Approved',
	'Denied'					=> 'Denied',

	// DB Backup module
	'BackupStructure'			=> 'Structure',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Folder',
	'BackupTable'				=> 'Table',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> '파일',
	'BackupNote'				=> '참고:',
	'BackupSettings'			=> 'Specify the desired scheme of backup.<br>' .
    	'The root cluster does not affect the global files backup and cache files backup (if chosen, they are always saved in full).<br>' .  '<br>' .
		'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster, the tables from this backup will not be restructured, same as when backing up only table structure without saving the data. To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Backing up and archiving completed.<br>' .
    	'백업 패키지 파일은 %1 하위 디렉터리에 저장되었습니다.<br>FTP를 사용하여 다운로드하세요(복사 시 디렉터리 구조와 파일 이름을 유지하세요).<br>백업 복사본을 복원하거나 패키지를 제거하려면 <a href="%2">데이터베이스 복원</a>으로 이동하세요.',
	'LogSavedBackup'			=> 'Saved backup database ##%1##',
	'Backup'					=> 'Backup',
	'CantReadFile'				=> 'Can\'t read file %1.',

	// DB Restore module
	'RestoreInfo'				=> 'You can restore any of the backup packages found, or remove them from the server.',
	'ConfirmDbRestore'			=> 'Do you want to restore backup %1?',
	'ConfirmDbRestoreInfo'		=> 'Please wait, this can take some time.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'DirectoryNotExecutable'	=> 'The %1 directory is not executable.',
	'BackupDelete'				=> 'Are you sure you want to remove backup %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Additional restore options:',
	'RestoreOptionsInfo'		=> '* Before restoring the <strong>cluster backup</strong>, ' .
									'the target tables are not deleted (to prevent loss of information from the clusters that have not been backed up). ' .
									'Thus, during the recovery process duplicate records will occur. ' .
									'In normal mode, all of them will be replaced by the records form backup (using SQL <code>REPLACE</code>), ' .
									'but if this checkbox is checked, all duplicates are skipped (the current values of records will be kept), ' .
									'and only the records with new keys are added to the table (SQL <code>INSERT IGNORE</code>).<br>' .
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

	'DbEngineInvalid'			=> '유효하지 않은 데이터베이스 엔진, %1을 기대함',
	'RestoreStarted'			=> 'Initiated Restoration',
	'RestoreParameters'			=> 'Using parameters',
	'IgnoreDuplicatedKeys'		=> 'Ignore duplicated keys',
	'IgnoreDuplicatedFiles'		=> 'Ignore duplicated files',
	'SavedCluster'				=> 'Saved cluster',
	'DataProtection'			=> 'Data Protection - %1 omitted',
	'AssumeDropTable'			=> 'Assume %1',
	'RestoreSQLiteDatabase'		=> 'SQLite 데이터베이스 복원',
	'SQLiteDatabaseRestored'	=> '다음 위치에서 데이터베이스가 성공적으로 복원되었습니다:',
	'RestoreTableStructure'		=> 'Restoring the structure of the table',
	'RunSqlQueries'				=> 'Perform SQL instructions:',
	'CompletedSqlQueries'		=> 'Completed. Processed instructions:',
	'NoTableStructure'			=> 'The structure of the tables was not saved - skip',
	'RestoreRecords'			=> 'Restore the contents of tables',
	'ProcessTablesDump'			=> 'Just download and process table dumps',
	'Instruction'				=> 'Instruction',
	'RestoredRecords'			=> 'records:',
	'RecordsRestoreDone'		=> 'Completed. Total entries:',
	'SkippedRecords'			=> 'Data not saved - skip',
	'RestoringFiles'			=> 'Restoring files',
	'DecompressAndStore'		=> 'Decompress and store the contents of directories',
	'HomonymicFiles'			=> 'homonymic files',
	'RestoreSkip'				=> 'skip',
	'RestoreReplace'			=> '찾아 바꾸기',
	'RestoreFile'				=> '파일:',
	'RestoredFiles'				=> 'restored:',
	'SkippedFiles'				=> 'skipped:',
	'FileRestoreDone'			=> 'Completed. Total files:',
	'FilesAll'					=> '전체:',
	'SkipFiles'					=> 'Files are not stored - skip',
	'RestoreDone'				=> 'RESTORATION COMPLETED',

	'BackupCreationDate'		=> 'Creation Date',
	'BackupPackageContents'		=> 'The contents of the package',
	'BackupRestore'				=> '복구',
	'BackupRemove'				=> '제거',
	'RestoreYes'				=> 'Yes',
	'RestoreNo'					=> 'No',
	'LogDbRestored'				=> 'Backup ##%1## of the database restored.',

	'BackupArchived'			=> '백업 %1을(를) 보관했습니다.',
	'BackupArchiveExists'		=> '백업 아카이브 %1이(가) 이미 있습니다.',
	'LogBackupArchived'			=> '백업 ##%1##을(를) 보관했습니다.',

	// User module
	'UsersInfo'					=> 'Here you can change your users\' information and certain specific options.',

	'UsersAdded'				=> 'User added',
	'UsersDeleteInfo'			=> 'Delete user:',
	'EditButton'				=> '편집',
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
	'GroupsDescription'			=> '설명',
	'GroupsModerator'			=> '사회자',
	'GroupsOpen'				=> 'Open',
	'GroupsActive'				=> 'Active',
	'GroupsTip'					=> 'Click to edit Group',
	'GroupsUpdated'				=> 'Groups updated',
	'GroupsAlreadyExists'		=> 'This group already exists.',
	'GroupsAdded'				=> 'Group added successfully.',
	'GroupsRenamed'				=> 'Group successfully renamed.',
	'GroupsDeleted'				=> 'The group %1 and all associated pages were deleted from the database.',
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

	// Statistics module
	'DbStatSection'				=> 'Database Statistics',
	'DbTable'					=> 'Table',
	'DbRecords'					=> 'Records',
	'DbSize'					=> '크기',
	'DbIndex'					=> '색인',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'File system Statistics',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> '파일',
	'FileSize'					=> '크기',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Version informations:',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Values',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Last update',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Server name',
	'WebServer'					=> 'Web server',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> '데이터베이스',
	'SqlModesGlobal'			=> 'SQL Modes Global',
	'SqlModesSession'			=> 'SQL Modes Session',
	'IcuVersion'				=> 'ICU',
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
	'CheckDatabase'				=> '데이터베이스',
	'CheckDatabaseInfo'			=> 'Checks for record inconsistencies in the database.',
	'CheckFiles'				=> '파일',
	'CheckFilesInfo'			=> 'Checks for abandoned files, files with no reference left in the file table.',
	'Records'					=> 'Records',
	'InconsistenciesNone'		=> 'No Data Inconsistencies found.',
	'InconsistenciesDone'		=> 'Data Inconsistencies solved.',
	'InconsistenciesRemoved'	=> 'Removed inconsistencies',
	'Check'						=> 'Check',
	'Solve'						=> 'Solve',

	// Bad Behaviour module
	'BbInfo'					=> 'Detects and blocks unwanted web accesses, deny automated spambots access.<br>For more information, please visit the %1 homepage.',
	'BbEnable'					=> 'Enable Bad Behaviour:',
	'BbEnableInfo'				=> 'All other settings can be changed in the config folder %1.',
	'BbStats'					=> 'Bad Behaviour has blocked %1 access attempts in the last 7 days.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Log',
	'BbSettings'				=> '설정',
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
	'BbShow'					=> '표시하기',
	'BbIpDateStatus'			=> 'IP/Date/Status',
	'BbHeaders'					=> 'Headers',
	'BbEntity'					=> 'Entity',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Options saved.',
	'BbWhitelistHint'			=> 'Inappropriate whitelisting WILL expose you to spam, or cause Bad Behaviour to stop functioning entirely! DO NOT WHITELIST unless you are 100% CERTAIN that you should.',
	'BbIpAddress'				=> 'IP Address',
	'BbIpAddressInfo'			=> 'IP address or CIDR format address ranges to be whitelisted (one per line)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL fragments beginning with the / after your web site hostname (one per line)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'User agent strings to be whitelisted (one per line)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Updated Bad Behaviour settings',
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
	'BbHttpblInfo'				=> 'To use Bad Behaviour\'s http:BL features you must have an %1',
	'BbHttpblKey'				=> 'http:BL Access Key',
	'BbHttpblThreat'			=> 'Minimum Threat Level (25 is recommended)',
	'BbHttpblMaxage'			=> 'Maximum Age of Data (30 is recommended)',
	'BbReverseProxy'			=> 'Reverse Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'If you are using Bad Behaviour behind a reverse proxy, load balancer, HTTP accelerator, content cache or similar technology, enable the Reverse Proxy option.<br>' .
									'If you have a chain of two or more reverse proxies between your server and the public Internet, you must specify <em>all</em> of the IP address ranges (in CIDR format) of all of your proxy servers, load balancers, etc. Otherwise, Bad Behaviour may be unable to determine the client\'s true IP address.<br>' .
									'In addition, your reverse proxy servers must set the IP address of the Internet client from which they received the request in an HTTP header. If you don\'t specify a header, %1 will be used. Most proxy servers already support X-Forwarded-For and you would then only need to ensure that it is enabled on your proxy servers. Some other header names in common use include %2 and %3.',
	'BbReverseProxyEnable'		=> 'Enable Reverse Proxy',
	'BbReverseProxyHeader'		=> 'Header containing Internet clients IP address',
	'BbReverseProxyAddresses'	=> 'IP address or CIDR format address ranges for your proxy servers (one per line)',

];
