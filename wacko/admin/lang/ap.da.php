<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'				=> 'Note: Before the administration of technical activities strongly are encouraged to block access to the site!',

	'CategoryArray'		=> [
		'basics'		=> 'Basic functions',
		'preferences'	=> 'Preferences',
		'content'		=> 'Content',
		'users'			=> 'Users',
		'maintenance'	=> 'Maintenance',
		'messages'		=> 'Messages',
		'extension'		=> 'Extension',
		'database'		=> 'Database',
	],

	// Admin panel
	'AdminPanel'				=> 'Administratorkontrolpanel',
	'RecoveryMode'				=> 'Gendannelsestilstand',
	'Authorization'				=> 'Authorization',
	'AuthorizationTip'			=> 'Please enter the administrative password (make also sure that cookies are allowed in your browser).',
	'NoRecoceryPassword'		=> 'The administrative password is not specified!',
	'NoRecoceryPasswordTip'		=> 'Note: The absence of an administrative password is threat to security! Enter your password in the configuration file and run the program again.',

	'ErrorLoadingModule'		=> 'Error loading admin module %1: does not exists.',

	'FormSave'					=> 'Save',
	'FormReset'					=> 'Reset',
	'FormUpdate'				=> 'Update',

	'ApHomePage'				=> 'Home Page',
	'ApHomePageTip'				=> 'open the home page, you do not quit administration',
	'ApLogOut'					=> 'Log out',
	'ApLogOutTip'				=> 'quit system administration',

	'TimeLeft'					=> 'Time left:  %1 minutes',
	'ApVersion'					=> 'version',

	'SiteOpen'					=> 'open',
	'SiteOpened'				=> 'site opened',
	'SiteOpenedTip'				=> 'The site is open',
	'SiteClose'					=> 'close',
	'SiteClosed'				=> 'site closed',
	'SiteClosedTip'				=> 'The site is closed',

	// Generic
	'Cancel'					=> 'Cancel',
	'Add'						=> 'Add',
	'Edit'						=> 'Edit',
	'Remove'					=> 'Remove',
	'Enabled'					=> 'Enabled',
	'Disabled'					=> 'Disabled',
	'On'						=> 'on',
	'Off'						=> 'off',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'Admin',

	// MENU
	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Basic',
		'title'		=> 'Basic parameters',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Appearance',
		'title'		=> 'Appearance settings',
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
		'name'		=> 'Pages',
		'title'		=> 'Pages and site parameters',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permissions',
		'title'		=> 'Permissions settings',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Security',
		'title'		=> 'Security subsystems settings',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'System',
		'title'		=> 'System options',
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
		'name'		=> 'Deleted',
		'title'		=> 'Newly deleted content',
	],

	// Files module
	'content_files'		=> [
		'name'		=> 'Files',
		'title'		=> 'Manage uploaded files',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Add, edit or remove default menu items',
	],

	// Pages module
	'content_pages'		=> [
		'name'		=> 'Pages',
		'title'		=> 'Manage pages',
	],

	// Polls module
	'content_polls'		=> [
		'name'		=> 'Polls',
		'title'		=> 'Editing, start and stop polls',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Backup',
		'title'		=> 'Backing up data',
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
		'name'		=> 'Restore',
		'title'		=> 'Restoring backup data',
	],

	// Dashboard module
	'lock'		=> [
		'name'		=> 'Main Menu',
		'title'		=> 'WackoWiki Administration',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inconsistencies',
		'title'		=> 'Fixing Data Inconsistencies',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Data Synchronization',
		'title'		=> 'Synchronizing data',
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
		'name'		=> 'System log',
		'title'		=> 'Log of system events',
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
		'name'		=> 'Groups',
		'title'		=> 'Group management',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Users',
		'title'		=> 'User management',
	],

	'LogFilterTip'				=> 'Filter events by criteria',
	'LogLevel'					=> 'Level',
	'LogLevelNotLower'			=> 'not less than',
	'LogLevelNotHigher'			=> 'not higher than',
	'LogLevelEqual'				=> 'equal',
	'LogNoMatch'				=> 'No events that meet the criteria',
	'LogDate'					=> 'Date',
	'LogEvent'					=> 'Event',
	'LogUsername'				=> 'Username',

	'PurgeSessions'				=> 'purge',
	'PurgeSessionsTip'			=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the auth_token table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// Basic settings


	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Control default display settings for your site.',
	'LogoOff'					=> 'off',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo and title',


	// Email settings
	'EmaiSettingsInfo'			=> 'Disse indstillinger anvendes af webstedet ved forsendelse af emails til tilmeldte brugere. Bemærk venligst at denne emailadresse skal være gyldig, da enhver tilbagesendt eller vildfaren email sandsynligvis vil blive returneret til denne emailaddresse. Hvis din vært ikke lader dig bruge den indbyggede (PHP-baserede) emailservice, kan du i stedet sende emails direkte igennem SMTP. Dette kræver adressen på en passende server (spørg om nødvendigt din vært). Hvis serveren kræver autentifikation (og kun hvis den gør) angives det nødvendige brugernavn, kodeord og autentifikationsmetoden.',

	'EmailFunctionName'			=> 'Navn på emailfunktion',
	'EmailFunctionNameInfo'		=> 'Navnet på den anvendte emailfunktion ved forsendelse af emails gennem PHP.',
	'UseSmtpInfo'				=> 'Vælg <code>SMTP</code>, hvis du vil eller skal bruge en navngiven server til at sende email i stedet for boardets indbyggede emailfunktion.',

	'EnableEmail'				=> 'Boardets emailsystem er',
	'EnableEmailInfo'			=> 'Enabling emails',

	'FromEmailName'				=> 'From Name',
	'FromEmailNameInfo'			=> 'The sender name, part of <code>From:</code> header in emails for all the email-notification sent from the site.',
	'NoReplyEmail'				=> 'No-reply address',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all your email-notifications sent from the site.',
	'AdminEmail'				=> 'Email of the site owner',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.',

	'SendTestEmail'				=> 'Send en test-email',
	'SendTestEmailInfo'			=> 'Der afsendes en test-email til den mailadresse der er angivet for din konto.',
	'TestEmailSubject'			=> 'Din Wiki er opsat korrekt til at sende emails',
	'TestEmailBody'				=> 'Tillykke, da du har modtaget denne email er din Wiki korrekt konfigureret og kan sende emails.',
	'TestEmailMessage'			=> 'Der er netop afsendt en test-email.<br />Modtager du den ikke, bedes du kontrollere dine emailkonfigurationer.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Godkendelsesmetode for SMTP',
	'SmtpConnectionModeInfo'	=> 'Bruges kun, hvis et brugernavn og kodeord er angivet, spørg din vært, hvis du er usikker på hvilken metode, der skal bruges.',
	'SmtpPassword'				=> 'SMTP-kodeord',
	'SmtpPasswordInfo'			=> 'Indtast kun et kodeord, hvis din SMTP-server kræver det.<br /><em><strong>Advarsel:</strong> Kodeordet bliver lagret i databasen i klar og ukrypteret tekst, og vil være synligt for alle med adgang til databasen eller til denne konfigurationsside.</em>',
	'SmtpPort'					=> 'SMTP-serverport',
	'SmtpPortInfo'				=> 'Skift kun denne, hvis du ved, at din SMTP-server benytter en anden port. <br />(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Adresse på SMTP-server',
	'SmtpServerInfo'			=> 'Bemærk at du skal anføre den protokol din server anvender. Hvis der anvendes SSL, anføres <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> 'SMTP-indstillinger',
	'SmtpUsername'				=> 'SMTP-brugernavn',
	'SmtpUsernameInfo'			=> 'Indtast kun et brugernavn, hvis din SMTP-server kræver det.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Her kan du ændre og vedligeholde indstillingerne for vedhæftede filer og tilknyttede specialkategorier.',
	'FileUploads'				=> 'File uploads',
	'UploadMaxFilesize'			=> 'Maksimal filstørrelse',
	'UploadMaxFilesizeInfo'		=> 'Er størrelsen sat til 0, er det alene din interne PHP-konfiguration, der begrænser filstørrelsen.',
	'UploadQuota'				=> 'Den totale kvote for vedhæftede filer',
	'UploadQuotaInfo'			=> 'Maksimum drevplads tilgængelig for vedhæftede filer på hele wiki, 0 betyder ubegrænset.',
	'UploadQuotaUser'			=> 'Storage quota per user',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with 0 being unlimited.',
	'CheckMimetype'				=> 'Kontrol af vedhæftede filer',
	'CheckMimetypeInfo'			=> 'Nogle browsere kan snydes og medfører fejlfortolkning af uploadede filers mimetype. Denne kontrol sikrer afvisning af filer der er årsag hertil.',

	'CreateThumbnail'			=> 'Opret miniature',
	'CreateThumbnailInfo'		=> 'Der oprettes altid en miniature.',
	'MaxThumbWidth'				=> 'Maksimal bredde på miniature i pixels',
	'MaxThumbWidthInfo'			=> 'Miniaturer vil ikke blive oprettet bredere end værdien defineret her.',
	'MinThumbFilesize'			=> 'Grænse for oprettelse af miniature',
	'MinThumbFilesizeInfo'		=> 'Opret ikke miniature for billeder der er mindre end.',

	// log
	'LogLevel1'					=> 'critical',
	'LogLevel2'					=> 'highest',
	'LogLevel3'					=> 'high',
	'LogLevel4'					=> 'medium',
	'LogLevel5'					=> 'low',
	'LogLevel6'					=> 'lowest',
	'LogLevel7'					=> 'debugging',

	// Massemail
	'SendToGroup'				=> 'Send to group',
	'SendToUser'				=> 'Send to user',

	// User approval module
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
	'BackupFiles'				=> 'Files',
	'BackupSettings'			=> 'Specify the desired scheme of Backup.<br />' .
									'The root cluster does not affect the global files backup and cache files backup (being chosen they are always saved in full).<br />' .
									'<br />' .
									'<span class="underline">Attention</span>: To avoid loss of information from the database when specifying the root cluster the tables from this backup will not be restructured, '.
									'same when backing up only table structure without saving the data. '.
									'To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Backing up and archiving completed.<br />' .
									'Backup package files stored in the %1 named sub-directory of <code>files/backup</code> directory.<br />' .
									'To download it use FTP (maintain the directory structure and file names when copying).<br />' .
									'To restore a backup copy or remove a package, go to <a href="?mode=db_restore">Restore database</a>.',
	'LogSavedBackup'			=> 'Saved backup database ##%1##',

	// DB Restore module
	'RestoreInfo'				=> 'You can restore any of the backup packages found or remove it from the server.',
	'ConfirmDbRestore'			=> 'Do you want to restore backup',
	'ConfirmDbRestoreInfo'		=> 'Please wait this can take some minutes.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'BackupDelete'				=> 'Are you sure you want to remove backup',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Additional restore options',
	'RestoreOptionsInfo'		=> '* Before restoring the <span class="underline">cluster backup</span>, '.
									'the target tables are not destroyed (to prevent loss of information from the clusters that have not been backed up). '.
									'Thus, during the recovery process duplicate records will occur. '.
									'In normal mode, all of them will be replaced by the records form backup (using SQL-instruction <code>REPLACE</code>), '.
									'but if this checkbox is checked, all duplicates are skipped (the current values of records will be kept), '.
									'and only the records with new keys are added to the table (SQL-instruction <code>INSERT IGNORE</code>).<br />' .
									'<span class="underline">Notice</span>: When restore complete backup of the site, this option has no value.<br />' .
									'<br />' .
									'** If the backup contains the user files (global and perpage, cache files, etc.), '.
									'in normal mode they replace the existing files with the same names and are placed in the same directory when being restored. '.
									'This option allows you to save the current copies of the files and restore from a backup only new files (missing on the server).',
	'IgnoreDuplicatedKeys'		=> 'Ignore duplicated table keys (not replace)',
	'IgnoreSameFiles'			=> 'Ignore the same files (not overwrite)',
	'NoBackupsAvailable'		=> 'No backups available.',
	'BackupEntireSite'			=> 'Entire site',
	'BackupRestored'			=> 'The backup is restored, a summary report is attached below. To delete this backup package, click',
	'BackupRemoved'				=> 'The selected backup has been successfully removed.',
	'LogRemovedBackup'			=> 'Removed database backup ##%1##',

	// User module
	'UsersAdded'				=> 'User added',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'UserEditButton'			=> 'Edit',
	'UserEnabled'				=> 'Enabled',
	'UsersAddNew'				=> 'Add new user',
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
	'GroupsMembersFor'			=> 'Members for Group',
	'GroupsDescription'			=> 'Description',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Open',
	'GroupsActive'				=> 'Active',
	'GroupsTip'					=> 'Click to edit Group',
	'GroupsUpdated'				=> 'Groups updated',
	'GroupsAlreadyExists'		=> 'This group already exists.',
	'GroupsAdded'				=> 'Group added successfully.',
	'GroupsRenamed'				=> 'Group successfully renamed.',
	'GroupsDeleted'				=> 'The group was deleted from the database and all pages.',
	'GroupsAdd'					=> 'Add a new group',
	'GroupsRename'				=> 'Rename the group',
	'GroupsRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that group.',
	'GroupsDelete'				=> 'Are you sure you want to remove group ',
	'GroupsDeleteInfo'			=> '* Note: Change will affect all members that are assigned to that group.',
	'GroupsStoreButton'			=> 'Save Groups',
	'GroupsSaveButton'			=> 'Submit',
	'GroupsCancelButton'		=> 'Cancel',
	'GroupsAddButton'			=> 'Add',
	'GroupsEditButton'			=> 'Edit',
	'GroupsRemoveButton'		=> 'Remove',
	'GroupsEditInfo'			=> 'To edit the groups list select the radio button.',

	'MembersAddNew'				=> 'Add new member',
	'MembersAdded'				=> 'Added new member to the group successfully.',
	'MembersRemove'				=> 'Are you sure you want to remove member ',
	'MembersRemoved'			=> 'The member was removed from the group.',
	'MembersDeleteInfo'			=> '* Note: Change will affect all members that are assigned to that group.',

];

?>