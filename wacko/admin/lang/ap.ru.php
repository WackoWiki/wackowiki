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

	// MENU
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

	'LogFilterTip'				=> '������������� ������� �� ���������',
	'LogLevel'					=> '�������',
	'LogLevelNotLower'			=> '�� ����, ���',
	'LogLevelNotHigher'			=> '�� ����, ���',
	'LogLevelEqual'				=> '�������������',
	'LogNoMatch'				=> '��� �������, ��������������� ���������',
	'LogDate'					=> '����',
	'LogEvent'					=> '�������',
	'LogUsername'				=> '������������',

	'PurgeSessions'				=> '�������',
	'PurgeSessionsTip'			=> '������� ��� ������',
	'PurgeSessionsConfirm'		=> '������� � �������� ������? ��� ��������� ������ ���� ������� �������������.',
	'PurgeSessionsExplain'		=> '������� ��� ������. ��� ��������� ������ ���� ������� ������������� � �������� ������� auth_token.',
	'PurgeSessionsDone'			=> '������ �������.',

	// Basic settings


	// Appearance settings
	'AppearanceSettingsInfo'	=> '���������� ������������ ����������� ����������� �����.',
	'LogoOff'					=> '����.',
	'LogoOnly'					=> '�������',
	'LogoAndTitle'				=> '������� � ���������',

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
	'UserStatsSynched'			=> '���������� ������������� ����������������.',
	'PageStatsSynched'			=> 'Page Statistics ����������������.',
	'FeedsUpdated'				=> 'RSS-������ ���������.',
	'SiteMapCreated'			=> 'The new version of the site map created successfully.',
	'WikiLinksRestored'			=> 'Wiki-������ �������������.',

	'UserStats'					=> '���������������� ����������',
	'UserStatsInfo'				=> '���������� ������������� (���������� ������������, ������� �� ��������, revisions � files) � ��������� ��������� ����� ����������� � ��������� �������. <br>��� �������� ��������� ����������� ���������� �� ������� ����������� ������ ��.',
	'PageStats'					=> 'Page ����������',
	'PageStatsInfo'				=> 'Page ���������� (���������� ������������, files � revisions) � ��������� ��������� ����� ����������� � ��������� �������. <br>��� �������� ��������� ����������� ���������� �� ������� ����������� ������ ��.',
	'Feeds'						=> 'RSS-������',
	'FeedsInfo'					=> '� ������ ������ ������ ���������� � ���� ������, ���������� RSS-����� �� ������� ��������� ���������. ������ ������� �������������� RSS-������ � ������� ���������� ��.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'WikiLinks'					=> 'Wiki-������',
	'WikiLinksInfo'				=> '��������� ��������� ��������� ���� �������������� ������ � ��������������� ���������� ������� <code>page_link</code> � <code>file_link</code> � ������ �� ����� ��� ����������� (����� ������ ������������ �����).',

	// Email settings
	'EmaiSettingsInfo'			=> '��� ���������� ������������ ��� �������� ������������ email-��������� �������������. �������������� � ������������ ��������� email-�������, ��� ������������ ��� �� ������������ ��������� �����, ��������, ���������� �� ���. ���� ��� ������ �� ������������ ������������� ���������� (� PHP) ������ email, �� ������ ���������� ��������� �������� � �������������� SMTP. ��� ����� ��������� ����� ����������� ������� (���� �����, �������� �� ���� � ����������). ���� ������ ������� �������������� (� ������ � ���� ������), ������� ����������� ���, ������ � ����� ��������������.',
	
    'EmailSettingsUpdated'	    => 'Updated Email settings',

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

	// log
	'LogLevel1'					=> '�����������',
	'LogLevel2'					=> '���������',
	'LogLevel3'					=> '�������',
	'LogLevel4'					=> '�������',
	'LogLevel5'					=> '������',
	'LogLevel6'					=> '�����������',
	'LogLevel7'					=> '����������',

	// Massemail
	'SendToGroup'				=> '������� ������',
	'SendToUser'				=> '������� ������������',

	// User approval module
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
	'BackupSettings'			=> '������� ��������� ����� ��������������. '.
									'�������� ������� �� ������ �� ��������� ����������� ���������� ������ � ������ ���� (��� �� ������ ��� ������ ����������� ���������).<br> '.
									'<br> '.
									'<strong>��������</strong>: �� ��������� ������ ���������� �� ���� ������ WackoWiki, ��� �������� ����� ��������, ������� �� ������ ��������� ����� �� ����� �������������������, '.
									'����������, ��� �������������� ������ ��������� ������� ��� ���������� ������. '.
									'��� ������ ����������� ������ � ������ ��������� ����� ���������� ���������� <em>������ �������������� ���� ���� ������ (��������� � ����������) ��� �������� ��������</em>.',
	'BackupCompleted'			=> '��������� ����������� � ��������� ���������.<br>' .
									'����� ��������� ����� �������� � ����� � ��������� %1 � ����� <code>files/backup</code>.<br>' .
									'��� ��� ��������� ����������� FTP (�� �������� ��� ����������� ��������� ��������� ��������� � ����� ������ � ����������).<br>' .
									'������������ ��������� ����� ��� ������� ����� ����� � ������� <a href="?mode=db_restore">��������������</a>.',
	'LogSavedBackup'			=> '��������� ��������� ����� ���� ������ ##%1##',

	// DB Restore module
	'RestoreInfo'				=> '�� ������ ������������ ����� �� ��������� ��������� �������, ���� ������� ��� � �������.',
	'ConfirmDbRestore'			=> '�� ������ ������������ ��������� �����',
	'ConfirmDbRestoreInfo'		=> '����������, ���������. ��� ����� ������ ��������� �����.',
	'RestoreWrongVersion'		=> '������������ ������ WackoWiki!',
	'BackupDelete'				=> '�� �������, ��� ������ ������� ��������� �����',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> '�������������� ����� ��� ��������������',
	'RestoreOptionsInfo'		=> '* ����� ��������������� ��������� ����� <strong>��������</strong> WackoWiki, '.
									'������� ������� �� ������������ (���� ������������� ������ ���������� �� ������������������� ���������). '.
									'����� �������, � �������� �������������� ����� ����������� ������������� ������. '.
									'� ������� ������ ��� ��� ����� �������� �������� �� ��������� ����� (� ������� SQL-���������� <code>REPLACE</code>), <br>' .
									'�� ���� ���� ������ ����������, ��� ��������� ����� ��������� (����� ��������� ������� �������� �������), <br>' .
									'� ��������� � ������� ������ ������ � ������ ������� (SQL-����������� <code>INSERT IGNORE</code>).<br>' .
									'<strong>��������</strong>: ��� �������������� ������ ��������� ����� ����� ��� ����� �� ����� ��������.<br> '.
									'<br> '.
									'** ���� ��������� ����� �������� ���������������� ����� (���������� � ������������, ����� ���� � ��.), �� � ������� ������ ��� �������������� ��� ������� ����������� �����, ����������� � ��� �� ���������. '.
									'��� ����� ��������� ��������� ������� ����� ������, � ������������ �� ��������� ����� ������ ����� (������������� �� �������) �����. ',
	'IgnoreDuplicatedKeys'		=> '������������ ����������� ����� ������� (�� ��������)',
	'IgnoreSameFiles'			=> '������������ ����������� ����� (�� ��������������)',
	'NoBackupsAvailable'		=> '��������� ����� �����������.',
	'BackupEntireSite'			=> '���� ����',
	'BackupRestored'			=> '��������� ����� �������������, ����� ���������� �������� ����. ����� ������� ������ ��������� �����, ������� �����',
	'BackupRemoved'				=> '��������� ��������� ����� ������� �������.',
	'LogRemovedBackup'			=> '������� ��������� ����� ���� ������ ##%1##',

	// User module
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

];

?>
