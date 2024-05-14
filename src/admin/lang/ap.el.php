<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Βασικές λειτουργίες',
		'preferences'	=> 'Προτιμήσεις',
		'content'		=> 'Περιεχόμενο',
		'users'			=> 'Μέλη',
		'maintenance'	=> 'Συντήρηση',
		'messages'		=> 'Μηνύματα',
		'extension'		=> 'Επεκτάσεις',
		'database'		=> 'Βάση δεδομένων',
	],

	// Admin panel
	'AdminPanel'				=> 'Πίνακας Ελέγχου Διαχειριστή',
	'RecoveryMode'				=> 'Λειτουργία ανάκτησης',
	'Authorization'				=> 'Εξουσιοδότηση',
	'AuthorizationTip'			=> 'Please enter the administrative password (make sure that cookies are allowed in your browser).',
	'NoRecoveryPassword'		=> 'Ο κωδικός πρόσβασης διαχειριστή δεν έχει καθοριστεί!',
	'NoRecoveryPasswordTip'		=> 'Σημείωση: Η απουσία κωδικού πρόσβασης διαχειριστή αποτελεί απειλή για την ασφάλεια! Εισάγετε το hash του κωδικού πρόσβασης στο αρχείο ρυθμίσεων και εκτελέστε ξανά το πρόγραμμα.',

	'ErrorLoadingModule'		=> 'Error loading admin module %1: does not exist.',

	'ApHomePage'				=> 'Αρχική Σελίδα',
	'ApHomePageTip'				=> 'Open the home page, you do not quit system administration',
	'ApLogOut'					=> 'Αποσύνδεση',
	'ApLogOutTip'				=> 'εγκατάλειψη διαχείρισης συστήματος',

	'TimeLeft'					=> 'Χρόνος που απομένει:  %1 λεπτά',
	'ApVersion'					=> 'έκδοση',

	'SiteOpen'					=> 'Άνοιγμα',
	'SiteOpened'				=> 'ο ιστότοπος άνοιξε',
	'SiteOpenedTip'				=> 'Ο ιστότοπος είναι ανοιχτός',
	'SiteClose'					=> 'Κλείσιμο',
	'SiteClosed'				=> 'ο ιστότοπος έκλεισε',
	'SiteClosedTip'				=> 'Ο ιστότοπος είναι κλειστός',

	'System'					=> 'System',

	// Generic
	'Cancel'					=> 'Ακύρωση',
	'Add'						=> 'Προσθήκη',
	'Edit'						=> 'Επεξεργασία',
	'Remove'					=> 'Αφαίρεση',
	'Enabled'					=> 'Ενεργοποίηση',
	'Disabled'					=> 'Απενεργοποιημένο',
	'Mandatory'					=> 'Υποχρεωτικό',
	'Admin'						=> 'Διαχειριστής',
	'Min'						=> 'Min',
	'Max'						=> 'Max',

	'MiscellaneousSection'		=> 'Διάφορα',
	'MainSection'				=> 'General Options',

	'DirNotWritable'			=> 'Ο κατάλογος %1 δεν είναι εγγράψιμος.',
	'FileNotWritable'			=> 'The %1 file is not writable.',

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
		'name'		=> 'Βασικό',
		'title'		=> 'Basic settings',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Εμφάνιση',
		'title'		=> 'Ρυθμίσεις εμφάνισης',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-mail',
		'title'		=> 'Ρυθμίσεις Email',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Syndication',
		'title'		=> 'Ρυθμίσεις σύνδεσης',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Φίλτρο',
		'title'		=> 'Ρυθμίσεις φίλτρου',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'Formatting options',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Ειδοποιήσεις',
		'title'		=> 'Notifications settings',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Σελίδες',
		'title'		=> 'Pages and site parameters',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Προσβάσεις',
		'title'		=> 'Permissions settings',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Ασφάλεια',
		'title'		=> 'Security subsystems settings',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Σύστημα',
		'title'		=> 'System options',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Ανέβασμα',
		'title'		=> 'Attachment settings',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Deleted',
		'title'		=> 'Newly deleted content',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Μενού',
		'title'		=> 'Add, edit or remove default menu items',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Backup',
		'title'		=> 'Backing up data',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Επισκευή',
		'title'		=> 'Repair and Optimize Database',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Επαναφορά',
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
		'name'		=> 'Συγχρονισμός Δεδομένων',
		'title'		=> 'Synchronizing data',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Mass email',
		'title'		=> 'Mass email',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Μήνυμα συστήματος',
		'title'		=> 'Μηνύματα συστήματος',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'System Info',
		'title'		=> 'System Information',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System Log',
		'title'		=> 'Log of system events',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Στατιστικά',
		'title'		=> 'Show statistics',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Bad Behaviour',
		'title'		=> 'Bad Behaviour',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Approve',
		'title'		=> 'User registration approval',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Ομάδες',
		'title'		=> 'Group management',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Χρήστες',
		'title'		=> 'User management',
	],

	// Main module
	'MainNote'					=> 'Note: It is recommended that access to the site be temporarily blocked for administrative maintenance.',

	'PurgeSessions'				=> 'Εκκαθάριση',
	'PurgeSessionsTip'			=> 'Purge all sessions',
	'PurgeSessionsConfirm'		=> 'Are you sure you wish to purge all sessions? This will log out all users.',
	'PurgeSessionsExplain'		=> 'Purge all sessions. This will log out all users by truncating the auth_token table.',
	'PurgeSessionsDone'			=> 'Sessions successfully purged.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Updated basic settings',
	'LogBasicSettingsUpdated'	=> 'Updated basic settings',

	'SiteName'					=> 'Site name:',
	'SiteNameInfo'				=> 'The title of this site. Appears on browser title, theme header, email-notification, etc.',
	'SiteDesc'					=> 'Site description:',
	'SiteDescInfo'				=> 'Supplement to the title of the site that appears in the pages header. Explains, in a few words, what this site is about.',
	'AdminName'					=> 'Admin of site:',
	'AdminNameInfo'				=> 'User name of individual who is responsible for overall support of the site. This name is not used to determine access rights, but it is desirable that it conforms to the name of the chief administrator of the site.',

	'LanguageSection'			=> 'Γλώσσα',
	'DefaultLanguage'			=> 'Προεπιλεγμένη γλώσσα:',
	'DefaultLanguageInfo'		=> 'Specifies the language of messages displayed to unregistered guests, as well as the locale settings.',
	'MultiLanguage'				=> 'Multilanguage support:',
	'MultiLanguageInfo'			=> 'Enable the ability to select a language on a page-by-page basis.',
	'AllowedLanguages'			=> 'Επιτρεπόμενες γλώσσες:',
	'AllowedLanguagesInfo'		=> 'Συνιστάται να επιλέξετε μόνο το σύνολο των γλωσσών που θέλετε να χρησιμοποιήσετε, άλλες σοφές επιλέγονται όλες οι γλώσσες.',

	'CommentSection'			=> 'Σχόλια',
	'AllowComments'				=> 'Allow comments:',
	'AllowCommentsInfo'			=> 'Enable comments for guests or registered users only, or disable them on the entire site.',
	'SortingComments'			=> 'Sorting comments:',
	'SortingCommentsInfo'		=> 'Changes the order the page comments are presented, either with the most recent OR the oldest comment at the top.',

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
	'EditSummary'				=> 'Σύνοψη επεξεργασίας:',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Μικρή αλλαγή:',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'SectionEdit'				=> 'Επεξεργασία τμήματος:',
	'SectionEditInfo'			=> 'Επιτρέπει την επεξεργασία μόνο ενός τμήματος μιας σελίδας.',
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
	'EnableFeedsInfo'			=> 'Ενεργοποιεί ή απενεργοποιεί τις τροφοδοσίες RSS για ολόκληρο το wiki.',
	'XmlChangeLink'				=> 'Changes feed link mode:',
	'XmlChangeLinkInfo'			=> 'Defines where the XML Changes feed items links to.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'προβολή αλλαγών',
		'2'		=> 'τρέχουσα σελίδα',
		'3'		=> 'εκδόσεις σελίδας',
		'4'		=> 'τροποποιημένη σελίδα',
	],

	'XmlSitemap'				=> 'XML sitemap:',
	'XmlSitemapInfo'			=> 'Creates an XML file called %1 inside the xml folder. You can add the path to the sitemap in the robots.txt file in your root directory as follows:',
	'XmlSitemapGz'				=> 'XML sitemap compression:',
	'XmlSitemapGzInfo'			=> 'If you would like, you may compress your sitemap text file using gzip to reduce your bandwidth requirement.',
	'XmlSitemapTime'			=> 'XML sitemap generation time:',
	'XmlSitemapTimeInfo'		=> 'Δημιουργεί το Χάρτη ιστοτόπου μόνο μία φορά στον δεδομένο αριθμό ημερών, μηδέν μέσα σε κάθε σελίδα αλλαγή.',

	'SearchSection'				=> 'Αναζήτηση',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Δημιουργεί το αρχείο περιγραφής OpenSearch στο φάκελο XML και ενεργοποιεί την αυτόματη ανακάλυψη του πρόσθετου αναζήτησης στην επικεφαλίδα HTML.',
	'SearchEngineVisibility'	=> 'Block search engines (search engine visibility):',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site. It is up to search engines to honor this request.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Control default display settings for your site.',
	'AppearanceSettingsUpdated'	=> 'Updated appearance settings.',

	'LogoOff'					=> 'Κλειστό',
	'LogoOnly'					=> 'λογότυπο',
	'LogoAndTitle'				=> 'λογότυπο και τίτλος',

	'LogoSection'				=> 'Λογότυπο',
	'SiteLogo'					=> 'Site logo:',
	'SiteLogoInfo'				=> 'Your logo will typically appear at the top left corner of the application. Max size is 2 MiB. Optimal dimensions are 255 pixels wide by 55 pixels high.',
	'LogoDimensions'			=> 'Logo dimensions:',
	'LogoDimensionsInfo'		=> 'Width and height of the displayed logo.',
	'LogoDisplayMode'			=> 'Logo display mode:',
	'LogoDisplayModeInfo'		=> 'Defines the appearance of the logo. Default is off.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site favicon:',
	'SiteFaviconInfo'			=> 'Your shortcut icon, or favicon, is displayed in the address bar, tabs and bookmarks of most browsers. This will override the favicon of your theme.',
	'SiteFaviconTooBig'			=> 'Το Favicon είναι μεγαλύτερο από 64 × 64px.',
	'ThemeColor'				=> 'Χρώμα θέματος για τη γραμμή διευθύνσεων:',
	'ThemeColorInfo'			=> 'Το πρόγραμμα περιήγησης θα ορίσει το χρώμα της γραμμής διευθύνσεων κάθε σελίδας σύμφωνα με το παρεχόμενο χρώμα CSS.',

	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Θέμα:',
	'ThemeInfo'					=> 'Template design the site uses by default.',
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

	'PrivacySection'			=> 'Privacy',
	'AnonymizeIp'				=> 'Anonymize users\' IP addresses:',
	'AnonymizeIpInfo'			=> 'Anonymize IP addresses where applicable (i.e., page, revision or referrers).',

	'ReverseProxySection'		=> 'Reverse Proxy',
	'ReverseProxy'				=> 'Use reverse proxy:',
    'ReverseProxyInfo'			=> 
    'Enable this setting to determine the correct IP address of the remote client by examining information stored in the X-Forwarded-For headers.  X-Forwarded-For headers are a standard mechanism for identifying client systems connecting through a reverse proxy server, such as Squid or Pound. Reverse proxy servers are often used to enhance the performance of heavily visited sites and may also provide other site caching, security or encryption benefits. If this WackoWiki installation operates behind a reverse proxy, this setting should be enabled so that correct IP address information is captured in WackoWiki\'s session management, logging, statistics and access management systems; if you are unsure about this setting, do not have a reverse proxy, or WackoWiki operates in a shared hosting environment, this setting should remain disabled.',
	'ReverseProxyHeader'		=> 'Reverse proxy header:',
	'ReverseProxyHeaderInfo'	=> 'Ορίστε αυτήν την τιμή εάν ο διακομιστής μεσολάβησης στέλνει την IP του πελάτη
									σε μια κεφαλίδα διαφορετική από την X-Forwarded-For. Η επικεφαλίδα "X-Forwarded-For"
									είναι μια λίστα διευθύνσεων IP που διαχωρίζεται με κόμμα και κενό, και μόνο η τελευταία (η πιο αριστερή) θα χρησιμοποιηθεί.',
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
		'1'		=> 'Αρχείο',
		'2'		=> 'Βάση δεδομένων',
	],
	'SessionNotice'					=> 'Εμφάνιση αιτίας τερματισμού συνόδου:',
	'SessionNoticeInfo'				=> 'Υποδεικνύει την αιτία τερματισμού της συνόδου.',
	'LoginNotice'					=> 'Ειδοποίηση σύνδεσης:',
	'LoginNoticeInfo'				=> 'Εμφανίζει μια ειδοποίηση σύνδεσης.',

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
	'TermHumanModerationInfo'	=> 'Οι επόπτες μπορούν να επεξεργαστούν σχόλια μόνο εάν δημιουργήθηκαν πριν από αυτόν τον αριθμό ημερών (αυτός ο περιορισμός δεν ισχύει για το τελευταίο σχόλιο στο θέμα).',

	'UserCanDeleteAccount'		=> 'Allow users to delete their accounts',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parameters responsible for the overall safety of the platform, safety restrictions and additional security subsystems.',
	'SecuritySettingsUpdated'	=> 'Updated security settings',

	'AllowRegistration'			=> 'Register online:',
	'AllowRegistrationInfo'		=> 'Άνοιγμα εγγραφής χρήστη. Η απενεργοποίηση αυτής της επιλογής θα αποτρέψει την δωρεάν εγγραφή, ωστόσο, ο διαχειριστής του ιστότοπου θα μπορεί να εγγράψει ο ίδιος άλλους χρήστες.',
	'ApproveNewUser'			=> 'Approve new users:',
	'ApproveNewUserInfo'		=> 'Allows administrators to approve users once they register. Only approved users will be allowed to log in the site.',
	'PersistentCookies'			=> 'Persistent cookies:',
	'PersistentCookiesInfo'		=> 'Allow persistent cookies.',
	'DisableWikiName'			=> 'Disable WikiName:',
	'DisableWikiNameInfo'		=> 'Disable the the mandatory use of a WikiName for users. Permits user registration with traditional nicknames instead of forced CamelCase-formatted names (i.e., NameSurname).',
	'UsernameLength'			=> 'Username length:',
	'UsernameLengthInfo'		=> 'Minimum and maximum number of characters in usernames.',

	'EmailSection'				=> 'Email',
	'AllowEmailReuse'			=> 'Allow email address re-use:',
	'AllowEmailReuseInfo'		=> 'Different users can register with the same email address.',
	'EmailConfirmation'			=> 'Επιβολή επιβεβαίωσης μέσω email:',
	'EmailConfirmationInfo'		=> 'Απαιτεί από τον χρήστη να επιβεβαιώσει τη διεύθυνση ηλεκτρονικού ταχυδρομείου του πριν συνδεθεί.',
	'AllowedEmailDomains'		=> 'Επιτρεπόμενοι τομείς ηλεκτρονικού ταχυδρομείου:',
	'AllowedEmailDomainsInfo'	=> 'Επιτρεπόμενοι τομείς ηλεκτρονικού ταχυδρομείου διαχωρισμένοι με κόμμα, π.χ. <code>example.com, local.lan</code> κ.λπ., διαφορετικά επιτρέπονται όλοι οι τομείς ηλεκτρονικού ταχυδρομείου.',
	'ForbiddenEmailDomains'		=> 'Απαγορευμένοι τομείς ηλεκτρονικού ταχυδρομείου:',
	'ForbiddenEmailDomainsInfo'	=> 'Απαγορευμένοι τομείς ηλεκτρονικού ταχυδρομείου διαχωρισμένοι με κόμμα, π.χ. <code>example.com, local.lan</code> κ.λπ. (μόνο αν η λίστα των επιτρεπόμενων τομέων ηλεκτρονικού ταχυδρομείου είναι κενή)',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Enable captcha:',
	'EnableCaptchaInfo'			=> 'If enabled, captcha will be shown in the following cases, or if a security threshold is reached.',
	'CaptchaComment'			=> 'New comment:',
	'CaptchaCommentInfo'		=> 'As protection against spam, unregistered users must complete captcha before comment will be posted.',
	'CaptchaPage'				=> 'New page:',
	'CaptchaPageInfo'			=> 'As protection against spam, unregistered users must complete captcha before creating a new page.',
	'CaptchaEdit'				=> 'Edit page:',
	'CaptchaEditInfo'			=> 'As protection against spam, unregistered users must complete captcha before editing pages.',
	'CaptchaRegistration'		=> 'Εγγραφή:',
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
		'0'		=> 'disabled',
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

	'LoginSection'				=> 'Σύνδεση',
	'MaxLoginAttempts'			=> 'Maximum number of login attempts per username:',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximum number of login attempts per IP address:',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'FormsSection'				=> 'Forms',
	'FormTokenTime'				=> 'Maximum time to submit forms:',
	'FormTokenTimeInfo'			=> 'Η ώρα που ο χρήστης πρέπει να υποβάλει μια φόρμα (σε δευτερόλεπτα). <br> Λάβετε υπόψη ότι μια φόρμα ενδέχεται να καταστεί άκυρη εάν λήξει η περίοδος σύνδεσης, ανεξάρτητα από αυτήν τη ρύθμιση.',

	'SessionLength'				=> 'Session cookie expiration:',
	'SessionLengthInfo'			=> 'The lifetime of the user session cookie by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments:',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications:',
	'IntercomDelayInfo'			=> 'The minimum delay between sending private messages (in seconds).',
	'RegistrationDelay'			=> 'Time threshold for registering:',
	'RegistrationDelayInfo'		=> 'The minimum time threshold between registration form submissions to discourage registration bots (in seconds).',

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
	'Formatters'				=> 'Disable formatters:',
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
	'Timezone'					=> 'Ωρολογιακή ζώνη:',
	'TimezoneInfo'				=> 'Χρονοζώνη που θα χρησιμοποιείται για την εμφάνιση των ωρών σε χρήστες που δεν είναι συνδεδεμένοι (επισκέπτες). Οι συνδεδεμένοι χρήστες ορίζουν και μπορούν να αλλάξουν τη ζώνη ώρας στις ρυθμίσεις χρήστη.',

	'Canonical'					=> 'Πλήρη και κανονικοποιημένα URLs:',
	'CanonicalInfo'				=> 'Όλοι οι σύνδεσμοι δημιουργούνται ως απόλυτα URL με τη μορφή %1. Οι διευθύνσεις URL που σχετίζονται με τη ρίζα του διακομιστή με τη μορφή %2 θα πρέπει να προτιμώνται.',
	'LinkTarget'				=> 'Where external links open:',
	'LinkTargetInfo'			=> 'Ανοίγει κάθε εξωτερικό σύνδεσμο σε ένα νέο παράθυρο του προγράμματος περιήγησης. Προσθέτει <code>target="_ blank"</code> στη σύνταξη του συνδέσμου.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Requires that the browser should not send an HTTP referer header if the user follows the hyperlink. Adds <code>rel="noreferrer"</code> to the link syntax.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Διδάξτε σε ορισμένες μηχανές αναζήτησης ότι ο υπερσύνδεσμος δεν πρέπει να επηρεάζει την κατάταξη του στόχου συνδέσμων στο ευρετήριο των μηχανών αναζήτησης. Προσθέτει <code>rel="nofollow"</code> στη σύνταξη του συνδέσμου.',
	'UrlsUnderscores'			=> 'Form addresses (URLs) with underscores:',
	'UrlsUnderscoresInfo'		=> 'For example, %1 becames %2 with this option.',
	'ShowSpaces'				=> 'Εμφάνιση κενών στα WikiNames:',
	'ShowSpacesInfo'			=> 'Show spaces in WikiNames, e.g. <code>MyName</code> being displayed as <code>My Name</code> with this option.',
	'NumerateLinks'				=> 'Enumerate links in print view:',
	'NumerateLinksInfo'			=> 'Enumerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disable and visualize self-referencing links:',
	'YouareHereTextInfo'		=> 'Visualize links to the same page, using <code>&lt;b&gt;####&lt;/b&gt;</code>. All links to self lose link formatting, but are displayed as bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Εδώ μπορείτε να ορίσετε ή να αλλάξετε τις βασικές σελίδες του συστήματος που χρησιμοποιούνται στο Wiki.',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Number of items per list:',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest, or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster forum:',
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

	'LicenseSection'			=> 'Άδεια',
	'DefaultLicense'			=> 'Default license:',
	'DefaultLicenseInfo'		=> 'Under which license your content can be released.',
	'EnableLicense'				=> 'Enable license:',
	'EnableLicenseInfo'			=> 'Enable to show license information.',
	'LicensePerPage'			=> 'License per page:',
	'LicensePerPageInfo'		=> 'Allow license per page, which the page owner can choose via page properties.',

	'ServicePagesSection'		=> 'Service Pages',
	'RootPage'					=> 'Home page:',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',

	'PrivacyPage'				=> 'Πολιτική προσωπικών δεδομένων:',
	'PrivacyPageInfo'			=> 'The page with the Privacy Policy of the site.',

	'TermsPage'					=> 'Policies and regulations:',
	'TermsPageInfo'				=> 'The page with the rules of the site.',

	'SearchPage'				=> 'Αναζήτηση:',
	'SearchPageInfo'			=> 'Page with the search form (action %1).',
	'RegistrationPage'			=> 'Εγγραφή:',
	'RegistrationPageInfo'		=> 'Page for new user registration (action %1).',
	'LoginPage'					=> 'User login:',
	'LoginPageInfo'				=> 'Login page on the site (action %1).',
	'SettingsPage'				=> 'User Settings:',
	'SettingsPageInfo'			=> 'Page to customize the user profile (action %1).',
	'PasswordPage'				=> 'Change Password:',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action %1).',
	'UsersPage'					=> 'User list:',
	'UsersPageInfo'				=> 'Page with a list of registered users (action %1).',
	'CategoryPage'				=> 'Κατηγορία:',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action %1).',
	'GroupsPage'				=> 'Ομάδες:',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action %1).',
	'ChangesPage'				=> 'Recent changes:',
	'ChangesPageInfo'			=> 'Page with a list of the last modified pages (action %1).',
	'CommentsPage'				=> 'Recent comments:',
	'CommentsPageInfo'			=> 'Page with a list of recent comments on the page (action %1).',
	'RemovalsPage'				=> 'Deleted pages:',
	'RemovalsPageInfo'			=> 'Page with a list of recently deleted pages (action %1).',
	'WantedPage'				=> 'Wanted pages:',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action %1).',
	'OrphanedPage'				=> 'Orphaned pages:',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related via links to any other page (action %1).',
	'SandboxPage'				=> 'Sandbox:',
	'SandboxPageInfo'			=> 'Page where users can practice their wiki markup skills.',
	'HelpPage'					=> 'Βοήθεια:',
	'HelpPageInfo'				=> 'The documentation section for working with site tools.',
	'IndexPage'					=> 'Index:',
	'IndexPageInfo'				=> 'Σελίδα με λίστα όλων των σελίδων (action %1).',
	'RandomPage'				=> 'Τυχαία:',
	'RandomPageInfo'			=> 'Φορτώνει μια τυχαία σελίδα (action %1).',


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

	'PersonalMessagesSection'	=> 'Προσωπικά μηνύματα',
	'AllowIntercomDefault'		=> 'Allow intercom:',
	'AllowIntercomDefaultInfo'	=> 'Enabling this option allows other users to send personal messages to the recipient\'s email address without disclosing the address.',
	'AllowMassemailDefault'		=> 'Allow mass email:',
	'AllowMassemailDefaultInfo'	=> 'Only send messages to those users who have permitted administrators to email them information.',

	// Resync settings
	'Synchronize'				=> 'συγχρονίζω',
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

	'AttachmentsInfo'			=> 'Ενημερώνει το hash του αρχείου για όλα τα συνημμένα αρχεία στη βάση δεδομένων.',
	'AttachmentsSynched'		=> 'Επανέκδοση όλων των συνημμένων αρχείων',
	'LogAttachmentsSynched'		=> 'Επανέκδοση όλων των συνημμένων αρχείων',

	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'In the case of direct editing of pages in the database, the content of RSS-feeds may not reflect the changes made. <br>This function synchronizes the RSS-channels with the current state of the database.',
	'XmlSiteMap'				=> 'XML Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'XmlSiteMapPeriod'			=> 'Period %1 days. Last written %2.',
	'XmlSiteMapView'			=> 'Show Sitemap in a new window.',

	'ReparseBody'				=> 'Reparse all pages',
	'ReparseBodyInfo'			=> 'Empties <code>body_r</code> in page table, so that each page gets rendered again on the next page view. This may be useful if you modified the formatter or changed the domain of your wiki.',
	'PreparsedBodyPurged'		=> 'Emptied <code>body_r</code> field in page table.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Performs a re-rendering for all intrasite links and restores the contents of the <code>page_link</code> and <code>file_link</code> tables in the event of damage or relocation (this can take considerable time).',
	'RecompilePage'				=> 'Ανασυγκρότηση όλων των σελίδων (εξαιρετικά δαπανηρή)',
	'ResyncOptions'				=> 'Επιπλέον επιλογές',
	'RecompilePageLimit'		=> 'Number of pages to parse at once.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Αυτές οι πληροφορίες χρησιμοποιούνται όταν το σύστημα συζητήσεων στέλνει μηνύματα ηλεκτρονικού ταχυδρομείου στα μέλη σας. Παρακαλώ βεβαιωθείτε ότι η διεύθυνση ηλεκτρονικού ταχυδρομείου που έχετε ορίσει είναι έγκυρη, όλα τα απαγορευμένα ή μη απεσταλμένα μηνύματα μηνύματα κατά πάσα πιθανότητα θα αποστέλλονται σε αυτή τη διεύθυνση. Εάν ο πάροχος φιλοξενίας σας δεν παρέχει μια μητρική (βασισμένη σε PHP) υπηρεσία ηλεκτρονικού ταχυδρομείου, μπορείτε αντί αυτού να στέλνετε μηνύματα απευθείας με χρήση του SMTP. Αυτό απαιτεί τη διεύθυνση ενός κατάλληλου διακομιστή (ρωτήστε τον πάροχο σας εάν είναι απαραίτητο). Εάν ο διακομιστής απαιτεί πιστοποίηση (και μόνο εάν το κάνει) εισάγετε τα απαιτούμενα όνομα χρήστη, κωδικό πρόσβασης και μέθοδο πιστοποίησης.',

	'EmailSettingsUpdated'		=> 'Updated Email settings',

	'EmailFunctionName'			=> 'Όνομα λειτουργίας ηλεκτρονικού ταχυδρομείου:',
	'EmailFunctionNameInfo'		=> 'Η λειτουργία ηλεκτρονικού ταχυδρομείου που χρησιμοποιείται για την αποστολή ηλεκτρονικών μηνυμάτων μέσω της PHP.',
	'UseSmtpInfo'				=> 'Επιλέξτε <code>SMTP</code> εάν θέλετε ή πρέπει να στείλετε μήνυμα ηλεκτρονικού ταχυδρομείου μέσω ενός έγκυρου διακομιστή (SMTP), αντί της λειτουργίας τοπικού ταχυδρομείου (λειτουργία PHP).',

	'EnableEmail'				=> 'Enable emails:',
	'EnableEmailInfo'			=> 'Enable sending of emails.',

	'EmailIdentitySettings'		=> 'Ιστοσελίδα Emails Ταυτότητα',
	'FromEmailName'				=> 'From name:',
	'FromEmailNameInfo'			=> 'The sender name that is use for the <code>From:</code> header for all email notifications sent from the site.',
	'EmailSubjectPrefix'		=> 'Πρόθεμα υποκειμένου:',
	'EmailSubjectPrefixInfo'	=> 'Θέμα: Εναλλακτικό πρόθεμα θέματος ηλεκτρονικού ταχυδρομείου, π.χ. <code>[Πρόθεμα] Θέμα</code>. Εάν δεν οριστεί, το προεπιλεγμένο πρόθεμα είναι το Όνομα τοποθεσίας: %1.',

	'NoReplyEmail'				=> 'No-reply address:',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all email notifications sent from the site.',
	'AdminEmail'				=> 'Email of the site owner:',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service:',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may be the same as the site owner email.',

	'SendTestEmail'				=> 'Αποστολή δοκιμαστικού μηνύματος ηλεκτρονικού ταχυδρομείου',
	'SendTestEmailInfo'			=> 'Αυτό θα αποστείλει ένα δοκιμαστικό μήνυμα ηλεκτρονικού ταχυδρομείου στη διεύθυνση που ορίστηκε στο λογαριασμό σας.',
	'TestEmailSubject'			=> 'Το WackoWiki είναι σωστά ρυθμισμένο για την αποστολή μηνυμάτων ηλεκτρονικού ταχυδρομείου',
	'TestEmailBody'				=> 'Αν λάβατε αυτό το μήνυμα ηλεκτρονικού ταχυδρομείου, το WackoWiki είναι σωστά ρυθμισμένο για την αποστολή μηνυμάτων ηλεκτρονικού ταχυδρομείου.',
	'TestEmailMessage'			=> 'Το δοκιμαστικό μήνυμα ηλεκτρονικού ταχυδρομείου στάλθηκε.<br>Αν δεν το λάβατε, παρακαλούμε ελέγξτε τις ρυθμίσεις του ηλεκτρονικού ταχυδρομείου.',

	'SmtpSettings'				=> 'Ρυθμίσεις SMTP',
	'SmtpAutoTls'				=> 'Opportunistic TLS:',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Μέθοδος πιστοποίησης για SMTP:',
	'SmtpConnectionModeInfo'	=> 'Χρησιμοποιείται μόνο εάν έχει οριστεί το όνομα χρήστη / κωδικός πρόσβασης, ρωτήστε τον πάροχο σας εάν δεν είστε βέβαιοι ποια μέθοδο θα χρησιμοποιήσετε.',
	'SmtpPassword'				=> 'Κωδικός πρόσβασης SMTP:',
	'SmtpPasswordInfo'			=> 'Εισάγετε ένα κωδικό πρόσβασης μόνο εάν ο διακομιστής SMTP το απαιτεί. <em><strong>ΠΡΟΕΙΔΟΠΟΙΗΣΗ:</strong> Αυτός ο κωδικός πρόσβασης θα αποθηκευτεί σαν απλό κείμενο στη βάση δεδομένων, ορατός σε όποιον μπορεί να έχει πρόσβαση στη βάση δεδομένων σας ή που μπορεί να προβάλει αυτή τη σελίδα ρυθμίσεων.</em>',
	'SmtpPort'					=> 'Θύρα διακομιστή SMTP:',
	'SmtpPortInfo'				=> 'Αλλάξτε το μόνο εάν γνωρίζετε ότι ο διακομιστής SMTP είναι σε μια διαφορετική θύρα. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Διεύθυνση διακομιστή SMTP:',
	'SmtpServerInfo'			=> 'Σημει΄ψστε ότι πρέπει να περέχετε και το πρωτόκολλο που χρησιμοποιεί ο διακομιστής σας. Αν χρησιμοποιείται SSL, πρέπει να το γράψετε <code>ssl://mail.example.com</code>',
	'SmtpUsername'				=> 'Όνομα χρήστη SMTP:',
	'SmtpUsernameInfo'			=> 'Εισάγετε ένα όνομα χρήστη μόνο εάν ο διακομιστής SMTP το απαιτεί.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Εδώ μπορείτε να διαμορφώσετε τις προεπιλεγμένες ρυθμίσεις για τα συνημμένα και τις σχετικές ειδικές κατηγορίες.',
	'UploadSettingsUpdated'		=> 'Updated upload settings',

	'FileUploadsSection'		=> 'File Uploads',
	'RegisteredUsers'			=> 'εγγεγραμμένοι χρήστες',
	'RightToUpload'				=> 'Permissions to upload files:',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belonging to the admins group can upload  files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadMaxFilesize'			=> 'Μέγιστο μέγεθος αρχείου:',
	'UploadMaxFilesizeInfo'		=> 'Μέγιστο μέγεθος του κάθε αρχείου. Εάν η τιμή είναι 0, το μέγεθος του προς φόρτωση αρχείου περιορίζεται μόνο από τις ρυθμίσεις του PHP σας.',
	'UploadQuota'				=> 'Συνολική ποσόστωση συνημμένων:',
	'UploadQuotaInfo'			=> 'Μέγιστος διαθέσιμος χώρος στη μονάδα δίσκου για ολόκληρo το σύστημα συζητήσεων, με <code>0</code> είναι απεριόριστος. %1 used.',
	'UploadQuotaUser'			=> 'Storage quota per user:',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with <code>0</code> being unlimited.',

	'FileTypes'					=> 'File Types',
	'UploadOnlyImages'			=> 'Allow only upload of images:',
	'UploadOnlyImagesInfo'		=> 'Allow only uploading of image files on the page.',
	'AllowedUploadExts'			=> 'Επιτρεπτοί τύποι αρχείων:',
	'AllowedUploadExtsInfo'		=> 'Επιτρεπόμενες επεκτάσεις για τη μεταφόρτωση αρχείων, με διαχωρισμό με κόμμα, π.χ. <code>png, ogg, mp4</code>, διαφορετικά επιτρέπονται όλες οι μη απαγορευμένες επεκτάσεις αρχείων.<br>Θα πρέπει να περιορίσετε τη λίστα των επιτρεπόμενων τύπων αρχείων που μεταφορτώνονται στο ελάχιστο που απαιτείται για τη λειτουργικότητα του περιεχομένου του ιστότοπού σας.',
	'CheckMimetype'				=> 'Έλεγχος αρχείων συνημμένων:',
	'CheckMimetypeInfo'			=> 'Ορισμένα προγράμματα περιήγησης μπορεί να εξαπατηθούν και να υποθέσουν ένα ανακριβές είδος κωδικοποίησης για τα φορτώσιμα αρχεία. Αυτή η επιλογή εξασφαλίζει ότι τέτοια αρχεία που είναι πιθανό να προκαλέσουν αυτό, να απορρίπτονται.',
	'SvgSanitizer'				=> 'SVG sanitizer:',
	'SvgSanitizerInfo'			=> 'Αυτό επιτρέπει την εξυγίανση των αρχείων SVG που μεταφορτώνονται για να αποτρέψει τη μεταφόρτωση ευάλωτων αρχείων SVG/XML.',
	'TranslitFileName'			=> 'Μεταγραφή ονομάτων αρχείων:',
	'TranslitFileNameInfo'		=> 'Συνιστάται ιδιαίτερα να δέχεστε μόνο αλφαριθμητικούς χαρακτήρες.',
	'TranslitCaseFolding'		=> 'Μετατροπή ονομάτων αρχείων σε πεζά:',
	'TranslitCaseFoldingInfo'	=> 'Αυτή η επιλογή είναι αποτελεσματική μόνο με ενεργή μεταγραφή.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Δημιουργία μικρογραφίας:',
	'CreateThumbnailInfo'		=> 'Δημιουργία μιας μικρογραφίας σε όλες τις δυνατές θέσεις.',
	'JpegQuality'				=> 'Ποιότητα JPEG:',
	'JpegQualityInfo'			=> 'Ποιότητα κατά την κλιμάκωση μιας μικρογραφίας JPEG. Θα πρέπει να κυμαίνεται μεταξύ 1 και 100, με το 100 να υποδηλώνει ποιότητα 100%.',
	'MaxImageArea'				=> 'Maximum Image Area:',
	'MaxImageAreaInfo'			=> 'Ο μέγιστος αριθμός εικονοστοιχείων που μπορεί να έχει μια αρχική εικόνα. Αυτό παρέχει ένα όριο στη χρήση μνήμης για την πλευρά της αποσυμπίεσης του κλιμακωτή εικόνας. <br><code>-1</code> σημαίνει ότι δεν θα ελέγχει το μέγεθος της εικόνας πριν επιχειρήσει να την κλιμακώσει. Το <code>0</code> σημαίνει ότι θα καθορίσει την τιμή αυτόματα.',
	'MaxThumbWidth'				=> 'Μέγιστο πλάτος μικρογραφίας σε εικονοστοιχεία:',
	'MaxThumbWidthInfo'			=> 'Μια μικρογραφία που δημιουργείται δεν θα υπερβαίνει το πλάτος που καθορίζεται εδώ.',
	'MinThumbFilesize'			=> 'Ελάχιστο μέγεθος αρχείου μικρογραφίας:',
	'MinThumbFilesizeInfo'		=> 'Να μη δημιουργείται μικρογραφία για εικόνες μικρότερες από αυτό.',
	'MaxImageWidth'				=> 'Όριο μεγέθους εικόνας στις σελίδες:',
	'MaxImageWidthInfo'			=> 'Διαφορετικά, δημιουργείται μια μικρογραφία σε μικρότερη κλίμακα.',

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
	'LogUsername'				=> 'Όνομα χρήστη',
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
	'MassemailInfo'				=> 'Εδώ μπορείτε να στείλετε ένα μήνυμα είτε σε όλα τα μέλη σας είτε σε όλα τα μέλη μιας συγκεκριμένης ομάδας <strong>που έχουν την επιλογή να λαμβάνουν μαζικά μηνύματα ηλεκτρονικού ταχυδρομείου ενεργοποιημένη</strong>. Για να επιτευχθεί αυτό, ένα μήνυμα ηλεκτρονικού ταχυδρομείου θα αποσταλεί στη διεύθυνση ηλεκτρονικού ταχυδρομείου του διαχειριστή που παρέσχατε, με την οποία ένα τυφλό πιστό αντίγραφο θα αποσταλεί σε όλους τους παραλήπτες. Η προεπιλεγμένη ρύθμιση είναι να συμπεριλάβει μόνο 20 παραλήπτες σε ένα τέτοιο ηλεκτρονικό ταχυδρομείο, για περισσότερους παραλήπτες θα σταλούν περισσότερα μηνύματα ηλεκτρονικού ταχυδρομείου. Εάν στέλνετε ηλεκτρονικό ταχυδρομείο σε μια μεγάλη ομάδα ατόμων, παρακαλώ να είστε υπομονετικοί μετά την υποβολή και μη διακόψετε τη σελίδα κατά τη διάρκεια της αποστολής. Είναι φυσιολογικό για μια μαζική αποστολή μηνύματος ηλεκτρονικού ταχυδρομείου να πάρει πολύ χρόνο, θα ενημερωθείτε όταν το σενάριο έχει ολοκληρωθεί.',
	'LogMassemail'				=> 'Mass email send %1 to group / user ',
	'MassemailSend'				=> 'Mass email send',

	'NoEmailMessage'			=> 'Πρέπει να εισάγετε κάποιο κείμενο.',
	'NoEmailSubject'			=> 'Πρέπει να ορίσετε ένα θέμα για το μήνυμά σας.',
	'NoEmailRecipient'			=> 'You must specify at least one user or user group.',

	'MassemailSection'			=> 'Mass email',
	'MessageSubject'			=> 'Θέμα:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Your message:',
	'YourMessageInfo'			=> 'Σημειώστε ότι μπορείτε να γράψετε μόνο απλό κείμενο. Οτιδήποτε άλλο θα αφαιρεθεί πριν την αποστολή.',

	'NoUser'					=> 'No user',
	'NoUserGroup'				=> 'No user group',

	'SendToGroup'				=> 'Αποστολή σε ομάδα:',
	'SendToUser'				=> 'Αποστολή σε μέλη:',
	'SendToUserInfo'			=> 'Only users who permit Administrators to email them information will receive mass emails. This option is available in their user settings under Notifications.',

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
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'Αρχεία',
	'BackupNote'				=> 'Προσοχή:',
	'BackupSettings'			=> 'Specify the desired scheme of backup.<br>' .
    	'The root cluster does not affect the global files backup and cache files backup (if chosen, they are always saved in full).<br>' .  '<br>' .
		'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster, the tables from this backup will not be restructured, same as when backing up only table structure without saving the data. To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Backing up and archiving completed.<br>' .
    	'The Backup package files were stored in the sub-directory %1.<br>. To download it use FTP (maintain the directory structure and file names when copying).<br> To restore a backup copy or remove a package, go to <a href="%2">Restore database</a>.',
	'LogSavedBackup'			=> 'Saved backup database ##%1##',
	'Backup'					=> 'Backup',
	'CantReadFile'				=> 'Can\'t read file %1.',

	// DB Restore module
	'RestoreInfo'				=> 'You can restore any of the backup packages found, or remove them from the server.',
	'ConfirmDbRestore'			=> 'Θέλετε να επαναφέρετε το αντίγραφο ασφαλείας %1;',
	'ConfirmDbRestoreInfo'		=> 'Περιμένετε να διαρκέσει μερικά λεπτά.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'DirectoryNotExecutable'	=> 'Ο κατάλογος %1 δεν είναι εκτελέσιμος.',
	'BackupDelete'				=> 'Είστε βέβαιοι ότι θέλετε να καταργήσετε το backup %1?',
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

	'RestoreStarted'			=> 'Initiated Restoration',
	'RestoreParameters'			=> 'Using parameters',
	'IgnoreDuplicatedKeys'		=> 'Ignore duplicated keys',
	'IgnoreDuplicatedFiles'		=> 'Ignore duplicated files',
	'SavedCluster'				=> 'Saved cluster',
	'DataProtection'			=> 'Data Protection - %1 omitted',
	'AssumeDropTable'			=> 'Assume %1',
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
	'RestoreReplace'			=> 'replace',
	'RestoreFile'				=> 'Αρχείο:',
	'RestoredFiles'				=> 'restored:',
	'SkippedFiles'				=> 'skipped:',
	'FileRestoreDone'			=> 'Completed. Total files:',
	'FilesAll'					=> 'all:',
	'SkipFiles'					=> 'Files are not stored - skip',
	'RestoreDone'				=> 'RESTORATION COMPLETED',

	'BackupCreationDate'		=> 'Creation Date',
	'BackupPackageContents'		=> 'The contents of the package',
	'BackupRestore'				=> 'Επαναφορά',
	'BackupRemove'				=> 'Αφαίρεση',
	'RestoreYes'				=> 'Yes',
	'RestoreNo'					=> 'No',
	'LogDbRestored'				=> 'Backup ##%1## of the database restored.',

	'BackupArchived'			=> 'Το αντίγραφο ασφαλείας %1 αρχειοθετήθηκε.',
	'BackupArchiveExists'		=> 'Το αρχείο αντιγράφων ασφαλείας %1 υπάρχει ήδη.',
	'LogBackupArchived'			=> 'Το αντίγραφο ασφαλείας ##%1## αρχειοθετήθηκε.',

	// User module
	'UsersInfo'					=> 'Here you can change your users information and certain specific options.',

	'UsersAdded'				=> 'User added',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> 'Επεξεργασία',
	'UsersAddNew'				=> 'Add new user',
	'UsersDelete'				=> 'Είστε βέβαιοι ότι θέλετε να καταργήσετε το χρήστη %1;',
	'UsersDeleted'				=> 'The user %1 was deleted from the database.',
	'UsersRename'				=> 'Rename the user %1 to',
	'UsersRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that user.',
	'UsersUpdated'				=> 'User successfully updated.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Signuptime',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'No users that meet the criteria',

	'UserAccountNotify'			=> 'Ειδοποίηση χρήστη',
	'UserNotifySignup'			=> 'ενημερώστε το χρήστη σχετικά με το νέο λογαριασμό',
	'UserVerifyEmail'			=> 'ορίστε το διακριτικό σήματος ηλεκτρονικού ταχυδρομείου και προσθέστε το σύνδεσμο για επαλήθευση μέσω ηλεκτρονικού ταχυδρομείου',
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
	'GroupsDescription'			=> 'Περιγραφή',
	'GroupsModerator'			=> 'Moderator',
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
	'GroupsDelete'				=> 'Είστε βέβαιοι ότι θέλετε να καταργήσετε την ομάδα %1?',
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
	'DbSize'					=> 'Μέγεθος',
	'DbIndex'					=> 'Index',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'File system Statistics',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> 'Αρχεία',
	'FileSize'					=> 'Μέγεθος',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Version information:',
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
	'CheckDatabase'				=> 'Βάση δεδομένων',
	'CheckDatabaseInfo'			=> 'Checks for record inconsistencies in the database.',
	'CheckFiles'				=> 'Αρχεία',
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
	'BbSettings'				=> 'Ρυθμίσεις',
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
