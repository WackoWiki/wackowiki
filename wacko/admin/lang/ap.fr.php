<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [
	'MainNote'					=> 'Note: Before the administration of technical activities strongly are encouraged to block access to the site!',

	'CategoryArray'		=> [
		'basics'		=> 'Fonctions de base',
		'preferences'	=> 'Pr�f�rences',
		'content'		=> 'Contenu',
		'users'			=> 'Utilisateurs',
		'maintenance'	=> 'Maintenance',
		'messages'		=> 'Messages',
		'extension'		=> 'Extension',
		'database'		=> 'Base de donn�es',
	],

	// Admin panel
	'AdminPanel'				=> 'Panneau de contr�le d\'administration',
	'RecoveryMode'				=> 'Mode de r�cup�ration',
	'Authorization'				=> 'Autorisation',
	'AuthorizationTip'			=> 'Merci d&rsquo;indiquer le mot de passe d&rsquo;administration (assurez-vous �galement que les cookies soient autoris�s par votre navigateur).',
	'NoRecoceryPassword'		=> 'le mot de passe d&rsquo;administration n&rsquo;est pas sp�cifi� !',
	'NoRecoceryPasswordTip'		=> 'Note&nbsp;: l&rsquo; absence de mot de passe d&rsquo;administration constitue une menace pour la s�curit� ! Saisissez votre mot de passe dans le fichier de configuration et ex�cutez le programme de nouveau.',

	'ErrorLoadingModule'		=> 'Erreur de chargement du module admin %1 : n\'existe pas.',

	'FormSave'					=> 'Enregistrer',
	'FormReset'					=> 'Reset',
	'FormUpdate'				=> 'Mise � jour',

	'ApHomePage'				=> 'Page d\'accueil',
	'ApHomePageTip'				=> 'ouvrir la page d\'accueil, vous ne quittez pas l\'administration',
	'ApLogOut'					=> 'D�connexion',
	'ApLogOutTip'				=> 'quitter l\'administration du syst�me',

	'TimeLeft'					=> 'Temps restant : %1 minutes',
	'ApVersion'					=> 'version',

	'SiteOpen'					=> 'Open',
	'SiteOpened'				=> 'site opened',
	'SiteOpenedTip'				=> 'The site is open',
	'SiteClose'					=> 'Close',
	'SiteClosed'				=> 'site closed',
	'SiteClosedTip'				=> 'The site is closed',

	// Generic
	'Cancel'					=> 'Annuler',
	'Add'						=> 'Ajouter',
	'Edit'						=> 'Modifier',
	'Remove'					=> 'Enlever',
	'Enabled'					=> 'Activ�',
	'Disabled'					=> 'D�sactiv�',
	'On'						=> 'On',
	'Off'						=> 'Off',
	'Mandatory'					=> 'Obligatoire',
	'Admin'						=> 'Admin',

	'MiscellaneousSection'		=> 'Divers',
	'MainSection'				=> 'Param�tres de base',

	'DirNotWritable'			=> 'Le r�pertoire %1 n\'est pas accessible en �criture.',

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
		'name'		=> 'Basic',
		'title'		=> 'Param�tres de base',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Apparence',
		'title'		=> 'Param�tres d\'apparence',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Email',
		'title'		=> 'Param�tres d\'e-mail',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtre',
		'title'		=> 'Param�tres du filtre',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'Options de formatage',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Notifications',
		'title'		=> 'Param�tres des notifications',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Pages',
		'title'		=> 'Pages et param�tres du site',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permissions',
		'title'		=> 'Param�tres des permissions',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'S�curit�',
		'title'		=> 'Param�tres des sous-syst�mes de s�curit�',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Syst�me',
		'title'		=> 'Options du syst�me',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'T�l�charger',
		'title'		=> 'Param�tres des pi�ces jointes',
	],

	// Categories module
	'content_categories'		=> [
		'name'		=> 'Cat�gories',
		'title'		=> 'G�rer les cat�gories',
	],

	// Comments module
	'content_comments'		=> [
		'name'		=> 'Commentaires',
		'title'		=> 'G�rer les commentaires',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Supprim�',
		'title'		=> 'Contenu r�cemment supprim�',
	],

	// Files module
	'content_files'		=> [
		'name'		=> 'Fichiers',
		'title'		=> 'G�rer les fichiers t�l�charg�s',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Ajouter, modifier ou supprimer des �l�ments de menu par d�faut',
	],

	// Pages module
	'content_pages'		=> [
		'name'		=> 'Pages',
		'title'		=> 'G�rer les pages',
	],

	// Polls module
	'content_polls'		=> [
		'name'		=> 'Polls',
		'title'		=> 'Editing, start and stop polls',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Sauvegarde',
		'title'		=> 'Sauvegarde des donn�es',
	],

	// DB Convert module
	'db_convert'		=> [
		'name'		=> 'Convertir',
		'title'		=> 'Conversion de tables ou de colonnes',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'R�paration',
		'title'		=> 'R�parer et optimiser la base de donn�es',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Restaurer',
		'title'		=> 'Restauration des donn�es de sauvegarde',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Menu principal',
		'title'		=> 'WackoWiki Administration',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Incoh�rences',
		'title'		=> 'Correction des incoh�rences dans les donn�es',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Synchronisation des donn�es',
		'title'		=> 'Synchronisation des donn�es',
	],

	// Transliterate module
	'maint_transliterate'		=> [
		'name'		=> 'Translitt�ratie',
		'title'		=> 'Mettre � jour le supertag dans les enregistrements de la base de donn�es',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Courriel de masse',
		'title'		=> 'Courriel de masse',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Message syst�me',
		'title'		=> 'Message du syst�me',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Info syst�me',
		'title'		=> 'Informations sur le syst�me',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Journal syst�me',
		'title'		=> 'Journal des �v�nements du syst�me',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistiques',
		'title'		=> 'Afficher les statistiques',
	],

	// Bad Behavior module
	'badbehavior'		=> [
		'name'		=> 'Bad Behavior',
		'title'		=> 'Bad Behavior',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Approuver',
		'title'		=> 'Approbation de l\'enregistrement de l\'utilisateur',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Groupes',
		'title'		=> 'Gestion du groupe',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Utilisateurs',
		'title'		=> 'Gestion des utilisateurs',
	],

	// Main module
	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'Purger toutes les sessions',
	'PurgeSessionsConfirm'		=> '�tes-vous s�r de vouloir purger toutes les sessions ? Tous les utilisateurs seront d�connect�s.',
	'PurgeSessionsExplain'		=> 'Purgez toutes les sessions. Tous les utilisateurs seront d�connect�s en tronquant la table auth_token.',
	'PurgeSessionsDone'			=> 'Sessions purg�es avec succ�s.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Mise � jour des r�glages de base',
	'LogBasicSettingsUpdated'	=> 'Mise � jour des r�glages de base',

	'SiteName'					=> 'Nom du site',
	'SiteNameInfo'				=> 'Le titre de ce site, appara�t sur le titre du navigateur, l\'en-t�te du th�me, l\'avis par courriel, etc.',
	'SiteDesc'					=> 'Description du site:',
	'SiteDescInfo'				=> 'Compl�ment au titre du site qui appara�t dans l\'en-t�te des pages pour expliquer en quelques mots, en quoi consiste ce site.',
	'AdminName'					=> 'Admin du site',
	'AdminNameInfo'				=> 'Nom d\'utilisateur, qui est responsable du support global du site. Ce nom n\'est pas utilis� pour d�terminer les droits d\'acc�s, mais il est souhaitable de se conformer au nom de l\'administrateur en chef du site.',
	'LanguageSection'			=> 'Langue',
	'DefaultLanguage'			=> 'Langue par d�faut',
	'DefaultLanguageInfo'		=> 'Specifies the language for mapping unregistered guests, as well as the locale settings and the rules of transliteration of addresses of pages.',
	'MultiLanguage'				=> 'Support multilingue',
	'MultiLanguageInfo'			=> 'Permet de s�lectionner une langue page par page.',
	'AllowedLanguages'			=> 'Langues autoris�es',
	'AllowedLanguagesInfo'		=> 'Il est recommand� de ne s�lectionner que l\'ensemble des langues que vous souhaitez utiliser, sinon toutes les langues sont s�lectionn�es.',
	'CommentSection'			=> 'Comments',
	'AllowComments'				=> 'Permettre les commentaires',
	'AllowCommentsInfo'			=> 'Activer les commentaires pour les utilisateurs invit�s ou enregistr�s uniquement ou les d�sactiver sur l\'ensemble du site.',
	'SortingComments'			=> 'Tri des commentaires',
	'SortingCommentsInfo'		=> 'Modifie l\'ordre dans lequel les commentaires de la page sont pr�sent�s, soit avec le commentaire le plus r�cent OU le plus ancien en haut.',
	'ToolbarSection'			=> 'Barre d\'outils',
	'CommentsPanel'				=> 'Comments panel',
	'CommentsPanelInfo'			=> 'L\'affichage par d�faut des commentaires en bas de la page.',
	'FilePanel'					=> 'Panneau de fichiers',
	'FilePanelInfo'				=> 'L\'affichage par d�faut des fichiers joints en bas de la page.',
	'RatingPanel'				=> 'Panneau d\'�valuation',
	'RatingPanelInfo'			=> 'L\'affichage par d�faut du panneau de notation en bas de la page.',
	'TagsPanel'					=> 'Tags panel',
	'TagsPanelInfo'				=> 'The default display of the tags panel in the bottom of the page.',

	'NavigationSection'			=> 'Navigation',
	'HideRevisions'				=> 'Masquer r�visions',
	'HideRevisionsInfo'			=> 'L\'affichage par d�faut des r�visions de la page.',
	'ShowPermalink'				=> 'Afficher le lien permanent',
	'ShowPermalinkInfo'			=> 'L\'affichage par d�faut du permalien pour la version actuelle de la page.',
	'TocPanel'					=> 'Table des mati�res panneau',
	'TocPanelInfo'				=> 'La table des mati�res par d�faut d\'une page (peut n�cessiter un support dans les mod�les).',
	'SectionsPanel'				=> 'Panneau des sections',
	'SectionsPanelInfo'			=> 'Par d�faut, affiche le panneau des pages adjacentes (n�cessite une prise en charge dans les mod�les).',
	'DisplayingSections'		=> 'Affichage des sections',
	'DisplayingSectionsInfo'	=> 'When the previous options, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>) or both, and other (<em>tree</em>).',
	'MenuItems'					=> '�l�ments du menu',
	'MenuItemsInfo'				=> 'Nombre par d�faut d\'�l�ments de menu affich�s (peut avoir besoin d\'aide dans les mod�les).',
	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Activer les flux',
	'EnableFeedsInfo'			=> 'Active ou d�sactive les flux RSS pour l\'ensemble du wiki.',
	'XmlSitemap'				=> 'XML Sitemap',
	'XmlSitemapInfo'			=> 'Create an XML file called %1 inside the xml folder. Generate a Sitemaps XML format compatible XML file. You might want to change the path to output it in your root folder as that is one of the requirements i.e. that the XML file is in the root folder. On the other hand you can also add the path to the sitemap in the robots.txt file in your root directory as follows:',
	'XmlSitemapTime'			=> 'XML Sitemap generation time',
	'XmlSitemapTimeInfo'		=> 'G�n�re le Sitemap une seule fois dans le nombre de jours donn�, z�ro signifie � chaque changement de page.',
	'DiffModeSection'			=> 'Diff Modes',
	'DefaultDiffModeSetting'	=> 'Mode diff par d�faut',
	'DefaultDiffModeSettingInfo'=> 'Mode diff pr�s�lectionn�.',
	'AllowedDiffMode'			=> 'Modes Diff autoris�s',
	'AllowedDiffModeInfo'		=> 'Il est recommand� de ne s�lectionner que l\'ensemble des modes de diff que vous souhaitez utiliser, sinon tous les modes de diff sont s�lectionn�s.',
	'NotifyDiffMode'			=> 'Notify diff mode',
	'NotifyDiffModeInfo'		=> 'Mode Diff utilis� pour les notifications dans le corps de l\'email.',

	'EditingSection'			=> 'Editing',
	'EditSummary'				=> 'Edit summary',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> '�dition mineure',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'ReviewSettings'			=> 'Review',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',
	'PublishAnonymously'		=> 'Allow anonymous publishing',
	'PublishAnonymouslyInfo'	=> 'Allow users to published preferably anonymously (to hide the name).',

	'DefaultRenameRedirect'		=> 'When renaming put redirection',
	'DefaultRenameRedirectInfo'	=> 'By default, offer to set a redirect to the old address of the page being renamed.',
	'StoreDeletedPages'			=> 'Conserver les pages supprim�es',
	'StoreDeletedPagesInfo'		=> 'When you delete a page, a comment or a file put her in a special section where she had some time (below) will be available for viewing and recovery.',
	'KeepDeletedTime'			=> 'Storage time of deleted pages',
	'KeepDeletedTimeInfo'		=> 'The period in days. It makes sense only if the previous option. Zero indicates the eternal possession (in this case the administrator can clear the "cart" manually).',
	'PagesPurgeTime'			=> 'Storage time of page revisions',
	'PagesPurgeTimeInfo'		=> 'Automatically deletes the older versions within the given number of days. If you enter zero, the older versions will not be removed.',
	'EnableReferrers'			=> 'Enable Referrers',
	'EnableReferrersInfo'		=> 'Allows to store and show external referrers.',
	'ReferrersPurgeTime'		=> 'Storage time of referrers',
	'ReferrersPurgeTimeInfo'	=> 'Keep history of invoking external pages no more than this number of days. Zero means the perpetual possession, but to actively visit the site this could lead to overcrowding in the database.',
	'AttachmentHandler'			=> 'Activer le gestionnaire de pi�ces jointes',
	'AttachmentHandlerInfo'		=> 'Allows to show the attachments handler.',
	'SearchEngineVisibility'	=> 'Block search engines (Search Engine Visibility)',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site, It is up to search engines to honor this request.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Control default display settings for your site.',
	'AppearanceSettingsUpdated'	=> 'Mise � jour des param�tres d\'apparence.',

	'LogoOff'					=> 'D�sactiv�',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo et titre',

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
	'DebugAdminOnly'			=> 'Closed diagnosis',
	'DebugAdminOnlyInfo'		=> 'Show debug data of the program (and DBMS) only for the administrator.',

	'CachingSection'			=> 'Caching Options',
	'Cache'						=> 'Cache rendered pages',
	'CacheInfo'					=> 'Save rendered pages in the local cache to speed up the subsequent boot. Valid only for unregistered visitors.',
	'CacheTtl'					=> 'Term relevance cached pages',
	'CacheTtlInfo'				=> 'Cache pages no more than a specified number of seconds.',
	'CacheSql'					=> 'Cache DBMS queries',
	'CacheSqlInfo'				=> 'Maintain a local cache the results of certain resource-SQL-queries.',
	'CacheSqlTtl'				=> 'Term relevance Cache Database',
	'CacheSqlTtlInfo'			=> 'Cache results of SQL-queries for no more than the specified number of seconds. Using the values of more than 1200 is not desirable.',

	'PrivacySection'			=> 'Privacy',
	'AnonymizeIp'				=> 'Anonymize users IP addresses',
	'AnonymizeIpInfo'			=> 'Anonymize IP addresses where applicable like page, revision or referrers.',

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

	'SessionSection'				=> 'Session handling',
	'SessionStorage'				=> 'Session storage',
	'SessionStorageInfo'			=> 'This option defines where the the session data is stored. By default either file or database session storage is selected.',
	'SessionModes'	=> [
		'1'		=> 'File',
		'2'		=> 'Database',
	],

	'RewriteMode'					=> 'Use <code>mod_rewrite</code>',
	'RewriteModeInfo'				=> 'If your web server supports this feature, turn to get "beautiful" the addresses of pages.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parameters responsible for Access control and permissions.',
	'PermissionsSettingsUpdated'	=> 'Updated permissions settings',

	'PermissionsSection'		=> 'Rights and privileges',
	'ReadRights'				=> 'Read rights by default',
	'ReadRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine parental rights.',
	'WriteRights'				=> 'Write rights by default',
	'WriteRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine the parental rights.',
	'CommentRights'				=> 'Comment rights by default',
	'CommentRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine the parental rights.',
	'CreateRights'				=> 'Create rights of a sub page by default',
	'CreateRightsInfo'			=> 'Define the tolerance for the establishment of root pages and assign pages for which we can not determine the parental rights.',
	'UploadRights'				=> 'Upload rights by default',
	'UploadRightsInfo'			=> 'Typically used for putting the root pages, and pages for which we can not determine parental rights.',
	'RenameRights'				=> 'Global rename right',
	'RenameRightsInfo'			=> 'List for admission to the possibility of free rename (move) pages.',

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
	'TermHumanModerationInfo'	=> 'Moderators can edit comments, only if they were set up at most as many days ago (this restriction does not apply to the last comment in the topic).',

	'UserCanDeleteAccount'		=> 'Utilisateurs autoris�s � supprimer leur compte',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parameters responsible for the overall safety of the platform, work permits and additional security subsystems.',
	'SecuritySettingsUpdated'	=> 'Updated security settings',

	'AllowRegistration'			=> 'Register online',
	'AllowRegistrationInfo'		=> 'Ongoing registration of users. Disabling the option will prevent free registration, however, the site administrator will be able to register other users on their own.',
	'ApproveNewUser'			=> 'Approve new users',
	'ApproveNewUserInfo'		=> 'Allows Administrators to approve users once they register. Only approved users will be allowed to log in the site.',
	'PersistentCookies'			=> 'Persistent cookies',
	'PersistentCookiesInfo'		=> 'Allow persistent cookies.',
	'AntiDupe'					=> 'Anti-clone',
	'AntiDupeInfo'				=> 'Disable register on the website under the names, <span class="underline">like</span> on the names of existing users (guests also can not use similar names for the signature comments). When this option is checked only <span class="underline">identical</span> names.',
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
	'CaptchaRegistration'		=> 'Registration',
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

	'LoginSection'				=> 'Login',
	'MaxLoginAttempts'			=> 'Maximum number of login attempts per username',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximum number of login attempts per IP address',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'LogSection'				=> 'Log settings',
	'LogLevel'					=> 'Using logging',
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
	'FormTokenTimeInfo'			=> 'The time a user has to submit a form (in seconds).<br> Use -1 to disable. Note that a form might become invalid if the session expires, regardless of this setting.',

	'SessionLength'				=> 'Term login cookie',
	'SessionLengthInfo'			=> 'The lifetime of the user cookie login by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of the new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications',
	'IntercomDelayInfo'			=> 'The minimum delay between sending a private message user connection (in seconds).',
	'RegistrationDelay'			=> 'Time threshold for registering',
	'RegistrationDelayInfo'		=> 'The minimum time threshold for filling out the registration form to tell away bots from humans (in seconds).',

	//Formatter settings
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
	'TikiLinks'					=> 'Disable Tikilinks',
	'TikiLinksInfo'				=> 'Disables linking for <code>Double.CamelCaseWords</code>.',
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
	'Timezone'					=> 'Timezone',
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
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Number of items per list',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster Forum',
	'ForumClusterInfo'			=> 'Address of the index (main) page of the forum.',
	'ForumTopics'				=> 'Number of topics per page',
	'ForumTopicsInfo'			=> 'Number of topics displayed on each page of the list in the forum sections.',
	'CommentsCount'				=> 'Number of comments per page',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page list of comments. This applies to all the comments on the site, and not just posted in the forum.',

	'NewsSection'				=> 'Section News',
	'NewsCluster'				=> 'Cluster for the News',
	'NewsClusterInfo'			=> 'Root cluster for news section.',
	'NewsLevels'				=> 'Depth of news pages from the root cluster',
	'NewsLevelsInfo'			=> 'Regular expression (SQL regexp-slang), specifying the number of intermediate levels of the news root cluster directly to the names of pages of news reports. (e.g. <code>[cluster]/[year]/[month]</code> -> <code>/.+/.+/.+</code>)',

	'LicenseSection'			=> 'Licence',
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

	'SearchPage'				=> 'Search',
	'SearchPageInfo'			=> 'Page with the search form (action <code>{{search}}</code>).',
	'RegistrationPage'			=> 'Register on our site',
	'RegistrationPageInfo'		=> 'Page new user registration (action <code>{{registration}}</code>).',
	'LoginPage'					=> 'User login',
	'LoginPageInfo'				=> 'Login page on the site (action <code>{{login}}</code>).',
	'SettingsPage'				=> 'Profile Settings',
	'SettingsPageInfo'			=> 'Page customize the user profile (action <code>{{usersettings}}</code>).',
	'PasswordPage'				=> 'Change Password',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action <code>{{changepassword}}</code>).',
	'UsersPage'					=> 'User list',
	'UsersPageInfo'				=> 'Page with a list of registered users (action <code>{{users}}</code>).',
	'CategoryPage'				=> 'Category',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action <code>{{category}}</code>).',
	'TagPage'					=> 'Tag',
	'TagPageInfo'				=> 'Page with a list of tagged pages (action <code>{{tag}}</code>).',
	'GroupsPage'				=> 'Groups',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action <code>{{usergroups}}</code>).',
	'ChangesPage'				=> 'Recent changes',
	'ChangesPageInfo'			=> 'Page with a list of the last modified pages (action <code>{{changes}}</code>).',
	'CommentsPage'				=> 'Recent comments',
	'CommentsPageInfo'			=> 'Page with a list of recent comment on the page (action <code>{{commented}}</code>).',
	'RemovalsPage'				=> 'Deleted pages',
	'RemovalsPageInfo'			=> 'Page with a list of recently deleted pages (action <code>{{deleted}}</code>).',
	'WantedPage'				=> 'Wanted pages',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action <code>{{wanted}}</code>).',
	'OrphanedPage'				=> 'Orphaned pages',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related links with the rest (action <code>{{orphaned}}</code>).',
	'SandboxPage'				=> 'Sandbox',
	'SandboxPageInfo'			=> 'Page where users can be trained in the use of wiki-markup.',
	'HelpPage'					=> 'Aide',
	'HelpPageInfo'				=> 'The documentation section for working with site tools.',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Param�tres pour les notifications de la plate-forme.',
	'NotificationSettingsUpdated'	=> 'Param�tres de notification mis � jour',

	'EmailNotification'			=> 'Notification par courriel',
	'EmailNotificationInfo'		=> 'Autoriser la notification par e-mail. R�gl� sur ON pour activer les notifications par e-mail, OFF pour les d�sactiver. Notez que la d�sactivation des notifications par e-mail n\'a aucun effet sur les e-mails g�n�r�s dans le cadre du processus d\'inscription de l\'utilisateur.',
	'Autosubscribe'				=> 'Autosubscribe',
	'AutosubscribeInfo'			=> 'Automatically sign a new page in the owner\'s notice of its changes.',

	'NotificationSection'		=> 'Param�tres de notification par d�faut de l\'utilisateur',
	'NotifyPageEdit'			=> 'Notifier l\'�dition de la page',
	'NotifyPageEditInfo'		=> 'En attente - Envoi d\'une notification par e-mail uniquement pour le premier changement jusqu\'� ce que l\'utilisateur visite � nouveau la page.',
	'NotifyMinorEdit'			=> 'Notifier les modifications mineures',
	'NotifyMinorEditInfo'		=> 'Envoie �galement des notifications pour des modifications mineures.',
	'NotifyNewComment'			=> 'Notifier un nouveau commentaire',
	'NotifyNewCommentInfo'		=> 'En attente - Envoi d\'une notification par e-mail uniquement pour le premier commentaire jusqu\'� ce que l\'utilisateur visite � nouveau la page.',

	'NotifyUserAccount'			=> 'Notifier un nouveau compte d\'utilisateur',
	'NotifyUserAccountInfo'		=> 'L\'administrateur sera averti lorsqu\'un nouvel utilisateur a �t� cr�� � l\'aide du formulaire d\'inscription.',
	'NotifyUpload'				=> 'Notifier le t�l�chargement de fichiers',
	'NotifyUploadInfo'			=> 'TLes mod�rateurs seront avertis lorsqu\'un fichier a �t� t�l�charg�.',

	'PersonalMessagesSection'	=> 'Messages personnels',
	'AllowIntercomDefault'		=> 'Autoriser l\'intercom',
	'AllowIntercomDefaultInfo'	=> 'Activer cette option permet aux autres utilisateurs d\'envoyer des messages personnels � l\'adresse e-mail du destinataire sans divulguer l\'adresse.',
	'AllowMassemailDefault'		=> 'Autoriser le courrier de masse',
	'AllowMassemailDefaultInfo'	=> 'Il n\'envoie que des messages aux utilisateurs qui ont autoris� les administrateurs � leur envoyer des informations par e-mail.',

	// Resync settings
	'Synchronize'				=> 'synchroniser',
	'UserStatsSynched'			=> 'Statistiques utilisateur synchronis�es.',
	'PageStatsSynched'			=> 'Page Statistics synchronized.',
	'FeedsUpdated'				=> 'RSS-feeds updated.',
	'SiteMapCreated'			=> 'The new version of the site map created successfully.',
	'WikiLinksRestored'			=> 'Wiki-links restored.',

	'LogUserStatsSynched'		=> 'Statistiques utilisateur synchronis�es',
	'LogPageStatsSynched'		=> 'Statistiques de page synchronis�es',
	'LogFeedsUpdated'			=> 'Flux RSS synchronis�s',
	'LogPageBodySynched'		=> 'Reparsed page body and links',

	'UserStats'					=> 'Statistiques utilisateur',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'PageStats'					=> 'Statistiques des pages',
	'PageStatsInfo'				=> 'Page statistics (number of comments, files and revisions) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'In the case of direct editing of pages in the database, the content of RSS-feeds may not reflect the changes made. <br>This function synchronizes the RSS-channels with the current state of the database.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'XmlSiteMapPeriod'			=> 'Period %1 days. Last written %2.',
	'XmlSiteMapView'			=> 'Show Sitemap in a new window.',
	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Performs a re-rendering for all intrasite links and restores the contents of the table <code>page_link</code> and <code>file_link</code> in the event of damage or relocation (this can take considerable time).',
	'RecompilePage'				=> 'Recompiler toutes les pages (extr�mement cher)',
	'ResyncOptions'				=> 'Options additionelles',

	// Email settings
	'EmaiSettingsInfo'			=> 'Ces informations sont utilis�es lors de l\'envoi de courriers �lectroniques � vos utilisateurs. Veuillez vous assurer que l\'adresse de courrier �lectronique sp�cifi�e est correcte car les messages refus�s ou �chou�s seront probablement retourn�s � cette adresse. Si votre h�bergeur ne fournit aucun service d\'envoi de courriers �lectroniques en PHP par d�faut, vous pouvez envoyer directement des messages en utilisant le protocole SMTP. Cela demande l\'adresse d\'un serveur appropri� (si besoin, demandez cette information � votre h�bergeur internet). Si le serveur exige une authentification (et seulement dans ce cas), saisissez le nom d\'utilisateur, le mot de passe et la m�thode d\'authentification n�cessaire.',

	'EmailSettingsUpdated'		=> 'Mise � jour des param�tres de courriel',

	'EmailFunctionName'			=> 'Nom de la fonction de la messagerie �lectronique',
	'EmailFunctionNameInfo'		=> 'Le nom de la fonction PHP utilis�e par la messagerie �lectronique afin d\'envoyer des courriels.',
	'UseSmtpInfo'				=> 'Activez cette option si vous souhaitez envoyer les courriels par un serveur SMTP au lieu d\'utiliser la fonction locale de la messagerie �lectronique.',

	'EnableEmail'				=> 'Activer les emails',
	'EnableEmailInfo'			=> 'Activation des emails',

	'FromEmailName'				=> 'From nom',
	'FromEmailNameInfo'			=> 'Le nom de l\'exp�diteur, partie de <code>From:</code>en-t�te dans les courriels pour toutes les notifications par courriel envoy�es � partir du site.',
	'NoReplyEmail'				=> 'No-reply adress',
	'NoReplyEmailInfo'			=> 'Cette adresse, par exemple <code>noreply@example.com</code>, appara�tra dans le champ <code>From:</code> email address de toutes vos notifications par e-mail envoy�es depuis le site.',
	'AdminEmail'				=> 'Email du propri�taire du site',
	'AdminEmailInfo'			=> 'Cette adresse est utilis�e � des fins d\'administration, comme la notification d\'un nouvel utilisateur.',
	'AbuseEmail'				=> 'Email abuse service',
	'AbuseEmailInfo'			=> 'R�pondre aux demandes urgentes : inscription � un courrier �lectronique �tranger, etc. Elle peut co�ncider avec la pr�c�dente.',

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
	'UploadSettingsUpdated'		=> 'Mise � jour des param�tres de t�l�chargement',

	'RightToUpload'				=> 'Droit aux fichiers t�l�charg�s',
	'RightToUploadInfo'			=> '<code>admins</code> signifie que seuls les utilisateurs appartenant au groupe admins peuvent t�l�charger les fichiers. <code>1</code> signifie que le t�l�chargement est ouvert aux utilisateurs enregistr�s. <code>0</code> signifie que le t�l�chargement est d�sactiv�.',
	'UploadOnlyImages'			=> 'Autoriser uniquement le t�l�chargement d\'images',
	'UploadOnlyImagesInfo'		=> 'Autoriser uniquement le t�l�chargement de fichiers image sur la page.',
	'FileUploads'				=> 'T�l�chargements de fichiers',
	'UploadMaxFilesize'			=> 'Taille maximale des pi�ces jointes',
	'UploadMaxFilesizeInfo'		=> 'La taille maximale des pi�ces jointes. Si cette valeur est r�gl�e sur 0, la taille ne sera limit�e que par votre configuration de PHP.',
	'UploadQuota'				=> 'Quota maximal des pi�ces jointes',
	'UploadQuotaInfo'			=> 'L\'espace de stockage maximal allou� � la totalit� des pi�ces jointes transf�r�es sur le forum. R�glez cette valeur sur 0 si vous ne souhaitez pas limiter cet espace.',
	'UploadQuotaUser'			=> 'Quota de stockage par utilisateur',
	'UploadQuotaUserInfo'		=> 'Restriction sur le quota de stockage qui peut �tre t�l�charg� par un utilisateur, 0 �tant illimit�.',
	'CheckMimetype'				=> 'V�rifier les pi�ces jointes',
	'CheckMimetypeInfo'			=> 'Certains navigateurs internet peuvent faire erreur en attribuant un type MIME incorrect aux fichiers transf�r�s. Cette option permet de rejeter les fichiers qui pr�sentent un risque de provoquer cette erreur.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'G�n�rer des miniatures',
	'CreateThumbnailInfo'		=> 'G�n�re des miniatures dans toutes les situations possibles.',
	'MaxThumbWidth'				=> 'Largeur maximale des miniatures',
	'MaxThumbWidthInfo'			=> 'Les miniatures g�n�r�es ne d�passeront pas la largeur de cette valeur.',
	'MinThumbFilesize'			=> 'Taille minimale des miniatures',
	'MinThumbFilesizeInfo'		=> 'Si la taille des images est inf�rieure � cette valeur, ces derni�res ne seront pas miniaturis�es.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'List of removed pages and files.
									Finally remove or restore the pages or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Mots qui seront automatiquement censur�s sur votre Wiki.',
	'FilterSettingsUpdated'		=> 'Mise � jour des param�tres du filtre anti-spam',

	'WordCensoringSection'		=> 'Censure des mots',
	'SPAMFilter'				=> 'SPAM Filter',
	'SPAMFilterInfo'			=> 'Activation du filtre anti-spam',
	'WordList'					=> 'Liste de mots',
	'WordListInfo'				=> 'Mot ou phrase <code>fragment</code> � mettre sur liste noire (un par ligne)',

	// DB Convert module
	'Convert'					=> 'Convertir',
	'NoColumnsToConvert'		=> 'Aucune colonne � convertir.',
	'NoTablesToConvert'			=> 'Pas de tables � convertir.',

	'LogDatabaseConverted'		=> 'Base de donn�es convertie',
	'ConversionTablesOk'		=> 'Conversion des tables s�lectionn�es avec succ�s.',

	'LogColumsToStrict'			=> 'Colonnes converties pour se conformer au mode strict SQL',
	'ConversionColumnsOk'		=> 'Conversion des colonnes s�lectionn�es avec succ�s.',

	'ConvertTablesEngine'		=> 'Conversion des tables de MyISAM en InnoDB/XtraDB',
	'ConvertTablesEngineInfo'	=> 'If you have existing tables, that you want to convert to InnoDB/XtraDB* for better reliability and scalability, use the following routine. These tables were originally MyISAM, which was formerly the default.',
	'ConvertTablesEngineHint'	=> '* XtraDB is an enhanced version of the InnoDB storage engine, designed to better scale on modern hardware, and it includes a variety of other features useful in high performance environments.<br><br>It is fully backwards compatible, and it identifies itself to MariaDB as "<code>ENGINE=InnoDB</code>" (just like InnoDB), and so can be used as a drop-in replacement for standard InnoDB.',

	'DbVersion'					=> 'Requires at least MySQL 5.6.4, available version',
	'DbEngineOk'				=> 'InnoDB/XtraDB est disponible.',
	'DbEngineMissing'			=> 'InnoDB/XtraDB  n\'est pas disponible.',
	'EngineTable'				=> 'Table',
	'EngineDefault'				=> 'Default',
	'EngineColumn'				=> 'Colonne',
	'EngineTyp'					=> 'Type',

	'ConvertColumnsToStrict'	=> 'Conversion des colonnes en SQL strict',
	'ConvertTablesStrictInfo'	=> 'Si vous avez des tables existantes, que vous voulez convertir pour vous conformer au mode SQL srtict, utilisez la routine suivante.',

	// Log module
	'LogFilterTip'				=> 'Filtrer les �v�nements par crit�re',
	'LogLevel'					=> 'Niveau',
	'LogLevelFilters'	=> [
		'1'		=> 'pas moins de',
		'2'		=> 'pas plus de',
		'3'		=> '�gal',
	],
	'LogNoMatch'				=> 'Aucun �v�nement ne r�pond aux crit�res',
	'LogDate'					=> 'Date',
	'LogEvent'					=> '�v�nement',
	'LogUsername'				=> 'Nom d&rsquo;utilisateur',
	'LogLevels'	=> [
		'1'		=> 'critique',
		'2'		=> 'le plus �lev�',
		'3'		=> '�lev�',
		'4'		=> 'moyen',
		'5'		=> 'bas',
		'6'		=> 'le plus bas',
		'7'		=> 'd�bogage',
	],

	// Massemail module
	'MassemailInfo'				=> 'Vous pouvez envoyer sur cette page un courriel � la totalit� des utilisateurs ou aux utilisateurs d\'un groupe d\'utilisateurs sp�cifique <strong>qui acceptent la r�ception de courriels de masse</strong>. Pour ce faire, un courriel sera envoy� � l\'adresse de courriel renseign�e par les administrateurs et une copie sera adress�e � tous les destinataires. Le r�glage par d�faut est limit� � 20 destinataires par courriel, mais si ce nombre est d�pass�, des courriels suppl�mentaires seront envoy�s. Sachez �galement que plus les destinataires sont nombreux, plus le temps d\'ex�cution est important. Il est normal que l\'envoi d\'un courriel de masse prenne un certain temps, veillez � ne pas vous d�placer sur une autre page tant que l\'op�ration n\'est pas totalement termin�e.',
	'LogMassemail'				=> 'Messemail send %1 to group / user ',
	'MassemailSend'				=> 'Massemail send',

	'NoEmailMessage'			=> 'Vous devez saisir un message.',
	'NoEmailSubject'			=> 'Vous devez saisir le sujet de votre message.',
	'NoEmailRecipient'			=> 'You must specify at least one user or user group.',

	'MassemailSection'			=> 'Courriel de masse',
	'MessageSubject'			=> 'Sujet',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Votre message',
	'YourMessageInfo'			=> 'Le message ne doit contenir que du texte brut. Toutes les balises seront automatiquement supprim�es.',

	'MessageLanguage'			=> 'Langue',
	'MessageLanguageInfo'		=> '',
	'SendMail'					=> 'Envoyer',

	'NoUser'					=> 'No user',
	'NoUserGroup'				=> 'No user group',

	'SendToGroup'				=> 'Envoyer � un groupe d\'utilisateurs',
	'SendToUser'				=> 'Envoyer � des utilisateurs',
	'SendToUserInfo'			=> 'Il n\'envoie que des messages aux utilisateurs qui ont autoris� les administrateurs � leur envoyer des informations par e-mail. Cette option est disponible dans leurs param�tres utilisateur sous notifications.',

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
	'ApproveNotExists'			=> 'Veuillez s�lectionner au moins un utilisateur � l\'aide du bouton D�finir.',

	'LogUserApproved'			=> 'User ##%1## approved',
	'LogUserBlocked'			=> 'User ##%1## blocked',
	'LogUserDeleted'			=> 'User ##%1## removed from the database',
	'LogUserCreated'			=> 'Created a new user ##%1##',
	'LogUserUpdated'			=> 'Updated User ##%1##',

	'UserApproveInfo'			=> 'Approuver les nouveaux utilisateurs avant qu\'ils ne puissent se connecter au site.',
	'Approve'					=> 'Approuver',
	'Deny'						=> 'Refuser',
	'Pending'					=> 'En attente',
	'Approved'					=> 'Approuv�',
	'Denied'					=> 'Refus�',

	// DB Backup module
	'BackupStructure'			=> 'Structure',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Folder',
	'BackupTable'				=> 'Table',
	'BackupCluster'				=> 'Cluster',
	'BackupFiles'				=> 'Fichiers',
	'BackupSettings'			=> 'Sp�cifiez le sch�ma de sauvegarde souhait�.<br>' .
									'The root cluster does not affect the global files backup and cache files backup (being chosen they are always saved in full).<br>' .
									'<br>' .
									'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster the tables from this backup will not be restructured, ' .
									'same when backing up only table structure without saving the data. ' .
									'To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Sauvegarde et archivage termin�s.<br>' .
									'Les fichiers du package de sauvegarde ont �t� stock�s dans le sous-r�pertoire %1 suivant.<br>' .
									'Pour le t�l�charger, utilisez FTP (g�rez la structure des r�pertoires et les noms de fichiers lors de la copie).<br>' .
									'Pour restaurer une copie de sauvegarde ou supprimer un paquet, allez � <a href="%2">Restaurer la base de donn�es</a>.',
	'LogSavedBackup'			=> 'Saved backup database ##%1##',
	'Backup'					=> 'Sauvegarde',

	// DB Restore module
	'RestoreInfo'				=> 'You can restore any of the backup packages found or remove it from the server.',
	'ConfirmDbRestore'			=> 'Do you want to restore backup',
	'ConfirmDbRestoreInfo'		=> 'Please wait this can take some minutes.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'BackupDelete'				=> 'Are you sure you want to remove backup',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Autres options de restauration',
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
	'IgnoreDuplicatedKeys'		=> 'Ignore duplicated table keys (not replace)',
	'IgnoreSameFiles'			=> 'Ignore the same files (not overwrite)',
	'NoBackupsAvailable'		=> 'No backups available.',
	'BackupEntireSite'			=> 'Entire site',
	'BackupRestored'			=> 'The backup is restored, a summary report is attached below. To delete this backup package, click',
	'BackupRemoved'				=> 'The selected backup has been successfully removed.',
	'LogRemovedBackup'			=> 'Removed database backup ##%1##',

	'RestoreStarted'			=> 'Initiated Restoration',
	'RestoreParameters'			=> 'Using parameters',
	'IgnoreDublicatedKeys'		=> 'Ignore dublicated keys',
	'IgnoreDublicatedFiles'		=> 'Ignore dublicated files',
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
	'RestoreFile'				=> 'File',
	'Restored'					=> 'restored',
	'Skipped'					=> 'skipped',
	'FileRestoreDone'			=> 'Completed. Total files',
	'FilesAll'					=> 'all',
	'SkipFiles'					=> 'Files are not stored - skip',
	'RestoreDone'				=> 'RESTORATION COMPLETED',

	'BackupCreationDate'		=> 'Date de cr�ation',
	'BackupPackageContents'		=> 'Le contenu du paquet',
	'BackupRestore'				=> 'Restaurer',
	'BackupRemove'				=> 'Enlever',
	'RestoreYes'				=> 'si',
	'RestoreNo'					=> 'non',
	'LogDbRestored'				=> 'Sauvegarde ##%1## de la base de donn�es restaur�e.',

	// User module
	'UsersInfo'					=> 'Here you can change your users information and certain specific options.',

	'UsersAdded'				=> 'Utilisateur ajout�',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'UserEditButton'			=> '�diter',
	'UserEnabled'				=> 'En fonction',
	'UsersAddNew'				=> 'Ajouter un utilisateur',
	'UsersDelete'				=> '�tes-vous s�r de vouloir supprimer un utilisateur %1 ',
	'UsersDeleted'				=> 'L&rsquo;utilisateur %1 a �t� supprim� de la base de donn�es.',
	'UsersRename'				=> 'Renommer l&rsquo;utilisateur %1 en',
	'UsersRenameInfo'			=> '* Note&nbsp;: les modifications affecteront toutes les pages affect�es � cet utilisateur.',
	'UsersUpdated'				=> 'Utilisateur effectivement actualis�.',

	'UserName'					=> 'Nom d\'utilisateur',
	'UserRealname'				=> 'Realname',
	'UserEmail'					=> 'Email',
	'UserIP'					=> 'IP',
	'UserLanguage'				=> 'La langue',
	'UserSignuptime'			=> 'Temps d\'inscription',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'Aucun utilisateur ne r�pond aux crit�res',

	// Groups module
	'GroupsInfo'				=> 'From this panel you can administrate all your usergroups. You can delete, create and edit existing groups. Furthermore, you may choose group leaders, toggle open/hidden/closed group status and set the group name and description.',

	'LogMembersUpdated'			=> 'Updated usergroup members',
	'LogMemberAdded'			=> 'Added member ##%1## into group ##%2##',
	'LogMemberRemoved'			=> 'Removed member ##%1## from group ##%2##',
	'LogGroupCreated'			=> 'Created a new group ##%1##',
	'LogGroupRenamed'			=> 'Group ##%1## renamed to ##%2##',
	'LogGroupRemoved'			=> 'Removed group ##%1##',

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
	'GroupsDeleted'				=> 'Le groupe %1 a �t� supprim� de la base de donn�es et de toutes les pages.',
	'GroupsAdd'					=> 'Ajouter un groupe',
	'GroupsRename'				=> 'Renommer le groupe %1',
	'GroupsRenameInfo'			=> '* Note&nbsp;: la modification affectera toutes les pages affect�es au groupe.',
	'GroupsDelete'				=> '�tes-vous s�r(e) de vouloir supprimer le groupe %1',
	'GroupsDeleteInfo'			=> '* Note&nbsp;: la modification affectera tous les membres du groupe.',
	'GroupsIsSystem'			=> 'Le groupe %1 appartient au syst�me et ne peut pas �tre supprim�.',
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

	// Statistics module
	'DbStatSection'				=> 'Statistiques de la base de donn�es',
	'DbTable'					=> 'Table',
	'DbRecords'					=> 'Records',
	'DbSize'					=> 'Size',
	'DbIndex'					=> 'Index',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'File system Statistics',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> 'Files',
	'FileSize'					=> 'Size',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Version informations',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Values',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Derni�re mise � jour',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Server name',
	'WebServer'					=> 'Web server',
	'HTTPProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SQLModesGlobal'			=> 'SQL Modes Global',
	'SQLModesSession'			=> 'SQL Modes Session',
	'PhpVersion'				=> 'PHP',
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

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Show and fix inconsistencies, delete or assign orphaned records to a new user / value.',
	'Inconsistencies'			=> 'Incoh�rences',
	'CheckDatabase'				=> 'Database',
	'CheckDatabaseInfo'			=> 'Checks for record inconsistencies in the database.',
	'CheckFiles'				=> 'Files',
	'CheckFilesInfo'			=> 'Checks for abandoned files, files with no reference left in the file table.',
	'Records'					=> 'Records',
	'InconsistenciesNone'		=> 'No Data Inconsistencies found.',
	'InconsistenciesDone'		=> 'Les incoh�rences dans les donn�es ont �t� r�solues.',
	'InconsistenciesRemoved'	=> 'Correction des incoh�rences',
	'Check'						=> 'v�rifier',
	'Solve'						=> 'Solve',

	// Transliterate module
	'TranslitField'				=> 'Transliterate field %1 in table `%2`.',
	'TranslitStart'				=> 'Start',
	'TranslitContinue'			=> 'Continue',
	'TranslitCompleted'			=> 'The update procedure is completed.',

	// Bad Behavior module
	'BbInfo'					=> 'Detects and blocks unwanted Web accesses, deny automated spambots access<br>For more information please visit the %1 homepage.',
	'BbEnable'					=> 'Enable Bad Behavior',
	'BbEnableInfo'				=> 'All other settings can be changed in the config folder %1.',
	'BbStats'					=> 'Bad Behavior has blocked %1 access attempts in the last 7 days.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Log',
	'BbSettings'				=> 'Settings',
	'BbWhitelist'				=> 'Whitelist',

	// --> Log
	'BbHits'					=> 'Hits',
	'BbRecordsFiltered'			=> 'Displaying %1 of %2 records filtered by',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Blocked',
	'BbPermitted'				=> 'Permitted',
	'BbIP'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbRecordsAll'				=> 'Displaying all %1 records',
	'BbShowBlocked'				=> 'Show Blocked',
	'BbShowPermitted'			=> 'Show Permitted',
	'BbIPDateStatus'			=> 'IP/Date/Status',
	'BbHeaders'					=> 'Headers',
	'BbEntity'					=> 'Entity',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Options saved.',
	'BbWhitelistHint'			=> 'Inappropriate whitelisting WILL expose you to spam, or cause Bad Behavior to stop functioning entirely! DO NOT WHITELIST unless you are 100% CERTAIN that you should.',
	'BbIPAddress'				=> 'IP Address',
	'BbIPAddressInfo'			=> 'IP address or CIDR format address ranges to be whitelisted (one per line)',
	'BbURL'						=> 'URL',
	'BbURLInfo'					=> 'URL fragments beginning with the / after your web site hostname (one per line)',
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

?>
