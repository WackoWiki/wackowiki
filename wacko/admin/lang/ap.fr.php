<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'					=> 'Note: Before the administration of technical activities strongly are encouraged to block access to the site!',

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
	'AdminPanel'				=> 'Panneau de contr�le d\'administration',
	'RecoveryMode'				=> 'Mode de r�cup�ration',
	'Authorization'				=> 'Autorisation',
	'AuthorizationTip'			=> 'Merci d&rsquo;indiquer le mot de passe d&rsquo;administration (assurez-vous �galement que les cookies soient autoris�s par votre navigateur).',
	'NoRecoceryPassword'		=> 'le mot de passe d&rsquo;administration n&rsquo;est pas sp�cifi� !',
	'NoRecoceryPasswordTip'		=> 'Note&nbsp;: l&rsquo; absence de mot de passe d&rsquo;administration constitue une menace pour la s�curit� ! Saisissez votre mot de passe dans le fichier de configuration et ex�cutez le programme de nouveau.',

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
		'name'		=> 'Apparence',
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
	'main'		=> [
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

	'LogFilterTip'				=> 'Filtrer les �v�nements par crit�re',
	'LogLevel'					=> 'Niveau',
	'LogLevelNotLower'			=> 'pas moins de',
	'LogLevelNotHigher'			=> 'pas plus de ',
	'LogLevelEqual'				=> '�gal',
	'LogNoMatch'				=> 'Aucun �v�nement ne r�pond aux crit�res',
	'LogDate'					=> 'Date',
	'LogEvent'					=> '�v�nement',
	'LogUsername'				=> 'Nom d&rsquo;utilisateur',

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
	'UserStatsSynched'			=> 'User Statistics synchronized.',
	'PageStatsSynched'			=> 'Page Statistics synchronized.',
	'FeedsUpdated'				=> 'RSS-feeds updated.',
	'SiteMapCreated'			=> 'The new version of the site map created successfully.',
	'WikiLinksRestored'			=> 'Wiki-links restored.',

	'UserStats'					=> 'User Statistics',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'PageStats'					=> 'Page statistics',
	'PageStatsInfo'				=> 'Page statistics (number of comments, files and revisions) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'In the case of direct editing of pages in the database, the content of RSS-feeds may not reflect the changes made. <br>This function synchronizes the RSS-channels with the current state of the database.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'WikiLinks'					=> 'Wiki-links',
	'WikiLinksInfo'				=> 'Performs a re-rendering for all intrasite links and restores the contents of the table <code>page_link</code> and <code>file_link</code> in the event of damage or relocation (this can take considerable time).',

	// Email settings
	'EmaiSettingsInfo'			=> 'Ces informations sont utilis�es lors de l\'envoi de courriers �lectroniques � vos utilisateurs. Veuillez vous assurer que l\'adresse de courrier �lectronique sp�cifi�e est correcte car les messages refus�s ou �chou�s seront probablement retourn�s � cette adresse. Si votre h�bergeur ne fournit aucun service d\'envoi de courriers �lectroniques en PHP par d�faut, vous pouvez envoyer directement des messages en utilisant le protocole SMTP. Cela demande l\'adresse d\'un serveur appropri� (si besoin, demandez cette information � votre h�bergeur internet). Si le serveur exige une authentification (et seulement dans ce cas), saisissez le nom d\'utilisateur, le mot de passe et la m�thode d\'authentification n�cessaire.',
	
    'EmailSettingsUpdated'	    => 'Updated Email settings',
        
	'EmailFunctionName'			=> 'Nom de la fonction de la messagerie �lectronique',
	'EmailFunctionNameInfo'		=> 'Le nom de la fonction PHP utilis�e par la messagerie �lectronique afin d\'envoyer des courriels.',
	'UseSmtpInfo'				=> 'Activez cette option si vous souhaitez envoyer les courriels par un serveur SMTP au lieu d\'utiliser la fonction locale de la messagerie �lectronique.',

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

	'SendTestEmail'				=> 'Envoyer un courriel de test',
	'SendTestEmailInfo'			=> 'Cela enverra un courriel de test � l\'adresse de courriel sp�cifi�e dans votre compte.',
	'TestEmailSubject'			=> 'Votre Wiki est correctement configur� pour envoyer des courriels',
	'TestEmailBody'				=> 'La r�ception de ce courriel signifie que la messagerie �lectronique de Wiki est correctement configur�e.',
	'TestEmailMessage'			=> 'Le courriel de test a �t� envoy�.<br>Si vous ne le recevez pas, veuillez v�rifier votre configuration des courriels.',

	'SmtpAutoTls'				=> 'Opportunistic TLS',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'M�thode d\'authentification du protocole SMTP',
	'SmtpConnectionModeInfo'	=> 'N\'est utilis�e que si un nom d\'utilisateur et un mot de passe ont �t� renseign�s. Veuillez demander cette information � votre h�bergeur internet si vous n\'�tes pas certain de la m�thode � utiliser.',
	'SmtpPassword'				=> 'Mot de passe SMTP',
	'SmtpPasswordInfo'			=> 'Ne saisissez un mot de passe que si votre serveur SMTP le demande.<br><em><strong>Attention :</strong> ce mot de passe sera stock� en texte brut dans la base de donn�es et sera visible � tous ceux qui ont acc�s � votre base de donn�es et � cette page de configuration.</em>',
	'SmtpPort'					=> 'Port du serveur SMTP',
	'SmtpPortInfo'				=> 'Ne modifiez ce dernier que si votre serveur SMTP utilise un port diff�rent dont vous avez connaissance. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Adresse du serveur SMTP',
	'SmtpServerInfo'			=> 'Veuillez noter que vous devez renseigner le protocole utilis� par le serveur. Si vous utilisez SSL, cela ressemblera � <code>ssl://mail.example.com</code>',
	'SmtpSettings'				=> 'R�glages du protocole SMTP',
	'SmtpUsername'				=> 'Nom d\'utilisateur SMTP',
	'SmtpUsernameInfo'			=> 'Ne saisissez un nom d\'utilisateur que si votre serveur SMTP le demande.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Vous pouvez configurer sur cette page les r�glages relatifs aux pi�ces jointes et � leurs cat�gories sp�ciales.',
	'FileUploads'				=> 'File uploads',
	'UploadMaxFilesize'			=> 'Taille maximale des pi�ces jointes',
	'UploadMaxFilesizeInfo'		=> 'La taille maximale des pi�ces jointes. Si cette valeur est r�gl�e sur 0, la taille ne sera limit�e que par votre configuration de PHP.',
	'UploadQuota'				=> 'Quota maximal des pi�ces jointes',
	'UploadQuotaInfo'			=> 'L\'espace de stockage maximal allou� � la totalit� des pi�ces jointes transf�r�es sur le forum. R�glez cette valeur sur 0 si vous ne souhaitez pas limiter cet espace.',
	'UploadQuotaUser'			=> 'Storage quota per user',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with 0 being unlimited.',
	'CheckMimetype'				=> 'V�rifier les pi�ces jointes',
	'CheckMimetypeInfo'			=> 'Certains navigateurs internet peuvent faire erreur en attribuant un type MIME incorrect aux fichiers transf�r�s. Cette option permet de rejeter les fichiers qui pr�sentent un risque de provoquer cette erreur.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'G�n�rer des miniatures',
	'CreateThumbnailInfo'		=> 'G�n�re des miniatures dans toutes les situations possibles.',
	'MaxThumbWidth'				=> 'Largeur maximale des miniatures',
	'MaxThumbWidthInfo'			=> 'Les miniatures g�n�r�es ne d�passeront pas la largeur de cette valeur.',
	'MinThumbFilesize'			=> 'Taille minimale des miniatures',
	'MinThumbFilesizeInfo'		=> 'Si la taille des images est inf�rieure � cette valeur, ces derni�res ne seront pas miniaturis�es.',

	// log
	'LogLevel1'					=> 'critique',
	'LogLevel2'					=> 'le plus �lev�',
	'LogLevel3'					=> '�lev�',
	'LogLevel4'					=> 'moyen',
	'LogLevel5'					=> 'bas',
	'LogLevel6'					=> 'le plus bas',
	'LogLevel7'					=> 'd�bogage',

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
	'BackupSettings'			=> 'Specify the desired scheme of Backup.<br>' .
									'The root cluster does not affect the global files backup and cache files backup (being chosen they are always saved in full).<br>' .
									'<br>' .
									'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster the tables from this backup will not be restructured, '.
									'same when backing up only table structure without saving the data. '.
									'To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Backing up and archiving completed.<br>' .
									'Backup package files stored in the %1 named sub-directory of <code>files/backup</code> directory.<br>' .
									'To download it use FTP (maintain the directory structure and file names when copying).<br>' .
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
	'RestoreOptionsInfo'		=> '* Before restoring the <strong>cluster backup</strong>, '.
									'the target tables are not destroyed (to prevent loss of information from the clusters that have not been backed up). '.
									'Thus, during the recovery process duplicate records will occur. '.
									'In normal mode, all of them will be replaced by the records form backup (using SQL-instruction <code>REPLACE</code>), '.
									'but if this checkbox is checked, all duplicates are skipped (the current values of records will be kept), '.
									'and only the records with new keys are added to the table (SQL-instruction <code>INSERT IGNORE</code>).<br>' .
									'<strong>Notice</strong>: When restore complete backup of the site, this option has no value.<br>' .
									'<br>' .
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
	'UserEnabled'				=> 'En fonction',
	'UsersAddNew'				=> 'Ajouter un utilisateur',
	'UsersDelete'				=> '�tes-vous s�r de vouloir supprimer un utilisateur ',
	'UsersDeleted'				=> 'L&rsquo;utilisateur a �t� supprim� de la base de donn�es.',
	'UsersRename'				=> 'Renommer l&rsquo;utilisateur',
	'UsersRenameInfo'			=> '* Note&nbsp;: les modifications affecteront toutes les pages affect�es � cet utilisateur.',
	'UsersUpdated'				=> 'Utilisateur effectivement actualis�.',

	'UserName'					=> 'Username',
	'UserRealname'				=> 'Realname',
	'UserEmail'					=> 'Email',
	'UserIP'					=> 'IP',
	'UserLanguage'				=> 'Language',
	'UserSignuptime'			=> 'Signuptime',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'No users that meet the criteria',

	// Groups module
	'GroupsMembersFor'			=> 'Membres du groupe',
	'GroupsDescription'			=> 'Description',
	'GroupsModerator'			=> 'Mod�rateur',
	'GroupsOpen'				=> 'Ouvert',
	'GroupsActive'				=> 'Actif',
	'GroupsTip'					=> 'Cliquer pour modifier le groupe',
	'GroupsUpdated'				=> 'Groupes modifi�s',
	'GroupsAlreadyExists'		=> 'Ce groupe existe d�j�.',
	'GroupsAdded'				=> 'Groupe effectivement ajout�.',
	'GroupsRenamed'				=> 'Groupe effectivement renomm�.',
	'GroupsDeleted'				=> 'le groupe a �t� supprim� de la base de donn�es et de toutes les pages.',
	'GroupsAdd'					=> 'Ajouter un groupe',
	'GroupsRename'				=> 'Renommer le groupe',
	'GroupsRenameInfo'			=> '* Note&nbsp;: la modification affectera toutes les pages affect�es au groupe.',
	'GroupsDelete'				=> '�tes-vous s�r(e) de vouloir supprimer le groupe ',
	'GroupsDeleteInfo'			=> '* Note&nbsp;: la modification affectera tous les membres du groupe.',
	'GroupsStoreButton'			=> 'Sauvegarder les  groupes',
	'GroupsSaveButton'			=> 'Sauvegarder',
	'GroupsCancelButton'		=> 'Annuler',
	'GroupsAddButton'			=> 'Ajouter',
	'GroupsEditButton'			=> 'Modifier',
	'GroupsRemoveButton'		=> 'Effacer',
	'GroupsEditInfo'			=> 'Pour modifier la liste des groupes utilisez le bouton radio.',

	'MembersAddNew'				=> 'Ajouter un membre',
	'MembersAdded'				=> 'Added new member to the group successfully.',
	'MembersRemove'				=> '�tes-vous s�r de vouloir �ter le membre ',
	'MembersRemoved'			=> 'Le membre a �t� �t� du groupe.',
	'MembersDeleteInfo'			=> '* Note&nbsp;: Les modifications affecteront tous les membres de ce groupe.',

];

?>
