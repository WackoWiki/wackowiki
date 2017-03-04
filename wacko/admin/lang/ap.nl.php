<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'				=> 'Note: Before the administration of technical activities strongly are encouraged to block access to the site!',

	'CategoryArray'		=> [
		'basics'		=> 'Basic functions',
		'preferences'	=> 'Voorkeuren',
		'content'		=> 'Content',
		'users'			=> 'Gebruikers',
		'maintenance'	=> 'Onderhoud',
		'messages'		=> 'Messages',
		'extension'		=> 'Extensies',
		'database'		=> 'Database',
	],

	// Admin panel
	'AdminPanel'				=> 'Beheerderspaneel',
	'RecoveryMode'				=> 'Herstelmodus',
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
	'Enabled'					=> 'Inschakelen',
	'Disabled'					=> 'Uitschakelen',
	'On'						=> 'Aan',
	'Off'						=> 'Uit',
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
		'name'		=> 'Uiterlijk',
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
		'name'		=> 'Permissies',
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
		'name'		=> 'Herstellen',
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
		'name'		=> 'Statistieken',
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
		'name'		=> 'Groepen',
		'title'		=> 'Group management',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Users',
		'title'		=> 'User management',
	],

	'LogFilterTip'			=> 'Filter events by criteria',
	'LogLevel'				=> 'Level',
	'LogLevelNotLower'		=> 'not less than',
	'LogLevelNotHigher'		=> 'not higher than',
	'LogLevelEqual'			=> 'equal',
	'LogNoMatch'			=> 'No events that meet the criteria',
	'LogDate'				=> 'Date',
	'LogEvent'				=> 'Event',
	'LogUsername'			=> 'Username',

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
	'EmaiSettingsInfo'			=> 'Deze informatie wordt gebruikt wanneer het site e-mails verstuurt naar je gebruikers. Zorg er voor dat het e-mailadres dat je specificeert geldig is, elk bericht dat niet verstuurd kan worden zal waarschijnlijk hier naar toe verstuurd worden. Als je host geen (PHP gebaseerde) e-mailservice aanbied, dan kan je berichten versturen door gebruik te maken van SMTP. Dit vereist het adres van een server (vraag je provider indien nodig). Als de server authenticatie vereist is (en alleen als het vereist wordt), voer dan de benodigde gebruikersnaam, wachtwoord en authenticatiemethode in.',

	'EmailFunctionName'			=> 'E-mailfunctie-naam',
	'EmailFunctionNameInfo'		=> 'De e-mailfunctie gebruikt om e-mails te versturen via PHP.',
	'UseSmtpInfo'				=> 'Selecteer <code>SMTP</code> als je e-mail wilt versturen via een genoemde server in plaats van de lokale e-mailfunctie.',

	'EnableEmail'				=> 'E-mails inschakelen',
	'EnableEmailInfo'			=> 'E-mails inschakelen',

	'FromEmailName'				=> 'From Name',
	'FromEmailNameInfo'			=> 'The sender name, part of <code>From:</code> header in emails for all the email-notification sent from the site.',
	'NoReplyEmail'				=> 'No-reply address',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all your email-notifications sent from the site.',
	'AdminEmail'				=> 'Email of the site owner',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.',

	'SendTestEmail'				=> 'Test e-mail versturen',
	'SendTestEmailInfo'			=> 'Deze optie verstuurt een test-e-mail naar het e-mailadres dat is opgegeven bij je accountinstellingen.',
	'TestEmailSubject'			=> 'Wiki is correct geconfigureerd om e-mails te versturen',
	'TestEmailBody'				=> 'Als je deze e-mail hebt ontvangen, is je wiki correct geconfigureerd om e-mails te versturen.',
	'TestEmailMessage'			=> 'De test-e-mail is verzonden.<br />Controleer je e-mailconfiguratie als je de test e-mail niet hebt ontvangen.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Authenticatiemethode voor SMTP',
	'SmtpConnectionModeInfo'	=> 'Alleen gebruiken als een gebruikersnaam/wachtwoord ingesteld is, vraag je provider als je niet zeker bent welke methode je moet gebruiken.',
	'SmtpPassword'				=> 'SMTP-wachtwoord',
	'SmtpPasswordInfo'			=> 'Alleen een wachtwoord invoeren als je SMTP-server dit vereist.<br /><em><strong>Waarschuwing:</strong> Dit wachtwoord zal opgeslagen worden als platte tekst in de database, zichtbaar voor iedereen die toegang heeft tot je database of die dit configuratiepagina kan bekijken.</em>',
	'SmtpPort'					=> 'SMTP-serverpoort',
	'SmtpPortInfo'				=> 'Verander dit alleen als je weet dat je SMTP-server op een andere poort draait. <br />(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'SMTP-serveradres',
	'SmtpServerInfo'			=> 'Let op dat je het gebruikte protocol ook opgeeft. Indien je SSL gebruikt, dan is dit <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> 'SMTP-instellingen',
	'SmtpUsername'				=> 'SMTP-gebruikersnaam',
	'SmtpUsernameInfo'			=> 'Voer alleen een gebruikersnaam in als je SMTP-server dit vereist.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Hier kan je de hoofdinstellingen voor bijlagen en bijbehorende speciale categorieën instellen.',
	'FileUploads'				=> 'File uploads',
	'UploadMaxFilesize'			=> 'Maximum bestandsgrootte',
	'UploadMaxFilesizeInfo'		=> 'Maximum grootte van elk bestand, met 0 als ongelimiteerd, bijgevoegd aan een privébericht.',
	'UploadQuota'				=> 'Totaal bijlage quota',
	'UploadQuotaInfo'			=> 'Maximum schijfruimte beschikbaar voor bijlagen van het hele wiki, met 0 als ongelimiteerd.',
	'UploadQuotaUser'			=> 'Storage quota per user',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with 0 being unlimited.',
	'CheckMimetype'				=> 'Controleer bijlage bestanden',
	'CheckMimetypeInfo'			=> 'Sommige browsers kunnen een incorrecte mimetype voor geüploade bestanden aannemen. Deze optie verzekerd je er van dat zulke bestanden die dit veroorzaken worden afgewezen.',

	'CreateThumbnail'			=> 'Miniatuur aanmaken',
	'CreateThumbnailInfo'		=> 'Maakt een miniatuur aan in alle mogelijke situaties.',
	'MaxThumbWidth'				=> 'Maximum miniatuur breedte in pixel',
	'MaxThumbWidthInfo'			=> 'Een aangemaakte miniatuur zal de hier ingestelde breedte niet overschrijden.',
	'MinThumbFilesize'			=> 'Minimum miniatuur bestandsgrootte',
	'MinThumbFilesizeInfo'		=> 'Maakt geen miniatuur aan voor afbeeldingen kleiner dan dit.',

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