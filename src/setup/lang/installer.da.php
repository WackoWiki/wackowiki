<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'da',
'LangLocale'	=> 'da_DK',
'LangName'		=> 'Dansk',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Kategori',
	'groups_page'		=> 'Grupper',
	'users_page'		=> 'Brugere',

	'search_page'		=> 'Søgning',
	'login_page'		=> 'Login',
	'account_page'		=> 'Indstillinger',
	'registration_page'	=> 'Registrering',
	'password_page'		=> 'Password',

	'changes_page'		=> 'Opdateringer',
	'comments_page'		=> 'Kommentarer',
	'index_page'		=> 'Indhold',

	'random_page'		=> 'TilfældigSide',
	#'help_page'			=> 'Hjælp',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',

	// time
	#'date_format'					=> 'dd.MM.yyyy',
	#'time_format'					=> 'HH:mm',
	#'time_format_seconds'			=> 'HH:mm:ss',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki Installation',
'TitleUpdate'					=> 'WackoWiki Update',
'Continue'						=> 'Fortsæt',
'Back'							=> 'Tilbage',
'Recommended'					=> 'anbefales',
'InvalidAction'					=> 'Ugyldig handling',

/*
   Language Selection Page
*/
'lang'							=> 'Sprogkonfiguration',
'PleaseUpgradeToR6'				=> 'Du kører en gammel (før %2) version af WackoWiki (%1). For at opdatere til denne nye version af WackoWiki, skal du først opdatere din installation til %2.',
'UpgradeFromWacko'				=> 'Velkommen til WackoWiki, det ser ud til, at du opgraderer fra WackoWiki %1 til %2.  De næste par sider vil guide dig gennem opgraderingsprocessen.',
'FreshInstall'					=> 'Velkommen til WackoWiki, du er ved at installere WackoWiki %1.  De næste par sider vil guide dig gennem installationsprocessen.',
'PleaseBackup'					=> 'Please, <strong>backup</strong> your database, config file and all changed files such as those which have hacks and patches applied to them before starting upgrade process. This can save you from big headache.',
'LangDesc'						=> 'Vælg venligst et sprog til installationsprocessen. Dette sprog vil også blive brugt som standardsprog i din WackoWiki-installation.',

/*
   System Requirements Page
*/
'version-check'					=> 'Systemkrav',
'PhpVersion'					=> 'PHP Version',
'PhpDetected'					=> 'Detected PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'Database',
'PhpExtensions'					=> 'PHP Extensions',
'Permissions'					=> 'Permissions',
'ReadyToInstall'				=> 'Klar til installation?',
'Requirements'					=> 'Din server skal opfylde nedenstående krav.',
'OK'							=> 'OK',
'Problem'						=> 'Problem',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Din PHP-installation synes at mangle de bemærkede PHP-udvidelser, som kræves af WackoWiki. ',
'PcreWithoutUtf8'				=> 'PCRE er ikke kompileret med UTF-8-understøttelse.',
'NotePermissions'				=> 'This installer will try to write the configuration data to the file %1, located in your WackoWiki directory. In order for this to work, you must make sure the web server has write access to that file.  If you can\'t do this, you will have to edit the file manually (the installer will tell you how).<br><br>See <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'ErrorPermissions'				=> 'Det ser ud til, at installationsprogrammet ikke automatisk kan indstille de nødvendige filtilladelser for at WackoWiki kan fungere korrekt. Du vil senere i installationsprocessen blive bedt om manuelt at konfigurere de nødvendige filtilladelser på din server.',
'ErrorMinPhpVersion'			=> 'PHP-versionen skal være større end <strong>' . PHP_MIN_VERSION . '</strong>, det ser ud til, at din server kører en tidligere version. Du skal opgradere til en nyere PHP-version for at WackoWiki kan fungere korrekt.',
'Ready'							=> 'Tillykke, det ser ud til, at din server kan køre WackoWiki. De næste par sider vil føre dig gennem konfigurationsprocessen.',

/*
   Site Config Page
*/
'config-site'					=> 'Site Configuration',
'SiteName'						=> 'Wiki Name',
'SiteNameDesc'					=> 'Please enter the name of your Wiki site.',
'SiteNameDefault'				=> 'MinWiki',
'HomePage'						=> 'Startside',
'HomePageDesc'					=> 'Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Startside',
'MultiLang'						=> 'Multi Language Mode',
'MultiLangDesc'					=> '"Flersproget" tilstand giver mulighed for at have sider med forskellige sprogindstillinger i en enkelt installation. Når denne tilstand er aktiveret, opretter installationsprogrammet indledende menupunkter for alle sprog, der er tilgængelige i distributionen.',
'AllowedLang'					=> 'Allowed Languages',
'AllowedLangDesc'				=> 'Det anbefales, at du kun vælger det sæt sprog, du ønsker at bruge, ellers er alle sprog valgt.',
'Admin'							=> 'Admin Name',
'AdminDesc'						=> 'Enter the admins username, this should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Brugernavn skal være mellem %1 og %2 tegn langt og brug kun alfanumeriske tegn.',
'NameCamelCaseOnly'				=> 'Brugernavn skal være mellem %1 og %2 tegn langt og WikiNavn formateret.',
'Password'						=> 'Admin Password',
'PasswordDesc'					=> 'Choose a password for the admin with a minimum of %1 characters.',
'PasswordConfirm'				=> 'Repeat Password:',
'Mail'							=> 'Admin Email Address',
'MailDesc'						=> 'Enter the admins email address.',
'Base'							=> 'Base URL',
'BaseDesc'						=> 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>https://example.com/</code></strong></li><li><strong><code>https://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Rewrite Mode',
'RewriteDesc'					=> 'Rewrite mode should be enabled if you are using WackoWiki with URL rewriting.',
'Enabled'						=> 'Enabled:',
'ErrorAdminEmail'				=> 'Du har indtastet en ugyldig e-mailadresse!',
'ErrorAdminPasswordMismatch'	=> 'The passwords do not match!.',
'ErrorAdminPasswordShort'		=> 'Admin-adgangskoden er for kort, minimumslængden er %1 tegn!',
'ModRewriteStatusUnknown'		=> 'The installer cannot verify that mod_rewrite is enabled, however this does not mean it is disabled',

/*
   Database Config Page
*/
'config-database'				=> 'Database Configuration',
'DbDriver'						=> 'Driver',
'DbDriverDesc'					=> 'The database driver you want to use.',
'DbSqlMode'						=> 'SQL mode',
'DbSqlModeDesc'					=> 'The SQL mode you want use.',
'DbVendor'						=> 'Vendor',
'DbVendorDesc'					=> 'The database vendor you use.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'The database charset you want to use.',
'DbEngine'						=> 'Engine',
'DbEngineDesc'					=> 'The database engine you want to use.',
'DbHost'						=> 'Host',
'DbHostDesc'					=> 'The host your database server is running on, usually <code>127.0.0.1</code> or <code>localhost</code> (i.e., the same machine your WackoWiki site is on).',
'DbPort'						=> 'Port (Optional)',
'DbPortDesc'					=> 'The port number your database server is accessible through. Leave it blank to use the default port number.',
'DbName'						=> 'Database Name',
'DbNameDesc'					=> 'The database WackoWiki should use. This database needs to exist already before you continue!',
'DbUser'						=> 'User Name',
'DbUserDesc'					=> 'Name of the user used to connect to your database.',
'DbPassword'					=> 'Password',
'DbPasswordDesc'				=> 'Password of the user used to connect to your database.',
'Prefix'						=> 'Table Prefix',
'PrefixDesc'					=> 'Prefix of all tables used by WackoWiki. This allows you to run multiple WackoWiki installations using the same database by configuring them to use different table prefixes (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'No database driver has been detected, please enable either the mysqli or pdo_mysql extension in your php.ini file.',
'ErrorNoDbDriverSelected'		=> 'No database driver has been selected, please pick one from the list.',
'DeleteTables'					=> 'Slet eksisterende tabeller?',
'DeleteTablesDesc'				=> 'OPMÆRKSOMHED! Hvis du fortsætter med denne indstilling valgt, vil alle nuværende wiki-data blive slettet fra din database. Dette kan ikke fortrydes, medmindre du manuelt gendanner dataene fra en sikkerhedskopi.',
'ConfirmTableDeletion'			=> 'Er du sikker på, at du vil slette alle nuværende wiki-tabeller?',

/*
   Database Installation Page
*/
'install-database'				=> 'Database Installation',
'TestingConfiguration'			=> 'Testing Configuration',
'TestConnectionString'			=> 'Testing database connection settings',
'TestDatabaseExists'			=> 'Checking if the database you specified exists',
'TestDatabaseVersion'			=> 'Checking database minimum version requirements',
'InstallTables'					=> 'Installing Tables',
'ErrorDbConnection'				=> 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDatabaseVersion'			=> 'The database version is %1 but requires at least %2.',
'To'							=> 'to',
'AlterTable'					=> 'Altering %1 table',
'InsertRecord'					=> 'Inserting Record into %1 table',
'RenameTable'					=> 'Renaming %1 table',
'UpdateTable'					=> 'Updating %1 table',
'InstallDefaultData'			=> 'Adding Default Data',
'InstallPagesBegin'				=> 'Adding Default Pages',
'InstallPagesEnd'				=> 'Finished Adding Default Pages',
'InstallSystemAccount'			=> 'Adding <code>System</code> User',
'InstallDeletedAccount'			=> 'Adding <code>Deleted</code> User',
'InstallAdmin'					=> 'Adding Admin User',
'InstallAdminSetting'			=> 'Adding Admin User Preferences',
'InstallAdminGroup'				=> 'Adding Admins Group',
'InstallAdminGroupMember'		=> 'Adding Admins Group Member',
'InstallEverybodyGroup'			=> 'Adding Everybody Group',
'InstallModeratorGroup'			=> 'Adding Moderator Group',
'InstallReviewerGroup'			=> 'Adding Reviewer Group',
'InstallLogoImage'				=> 'Adding Logo Image',
'LogoImage'						=> 'Logo image',
'InstallConfigValues'			=> 'Adding Config Values',
'ConfigValues'					=> 'Config Values',
'ErrorInsertPage'				=> 'Error inserting %1 page',
'ErrorInsertPagePermission'		=> 'Error setting permission for %1 page',
'ErrorInsertDefaultMenuItem'	=> 'Error setting page %1 as default menu item',
'ErrorPageAlreadyExists'		=> 'The %1 page already exists',
'ErrorAlterTable'				=> 'Error altering %1 table',
'ErrorInsertRecord'				=> 'Error Inserting Record into %1 table',
'ErrorRenameTable'				=> 'Error renaming %1 table',
'ErrorUpdatingTable'			=> 'Error updating %1 table',
'CreatingTable'					=> 'Creating %1 table',
'ErrorAlreadyExists'			=> 'The %1 already exists',
'ErrorCreatingTable'			=> 'Error creating %1 table, does it already exist?',
'DeletingTables'				=> 'Deleting Tables',
'DeletingTablesEnd'				=> 'Finished Deleting Tables',
'ErrorDeletingTable'			=> 'Error deleting %1 table. The most likely reason is that the table does not exist, in which case you can ignore this warning.',
'DeletingTable'					=> 'Deleting %1 table',
'NextStep'						=> 'In the next step, the installer will try to write the updated configuration file, %1.  Please make sure the web server has write access to the file, or you will have to edit it manually.  Once again, see  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',

/*
   Write Config Page
*/
'write-config'					=> 'Skriv Config File',
'FinalStep'						=> 'Final Step',
'Writing'						=> 'Writing Configuration File',
'RemovingWritePrivilege'		=> 'Removing Write Privilege',
'InstallationComplete'			=> 'Installation færdig',
'ThatsAll'						=> 'Det er det hele! Du kan nu <a href="%1">se dit WackoWiki-websted</a>.',
'SecurityConsiderations'		=> 'Security Considerations',
'SecurityRisk'					=> 'You are advised to remove write access to %1 now that it\'s been written. Leaving the file writable can be a security risk!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges'			=> 'The configuration file %1 could not be written. You will need to give your web server temporary write access to either your WackoWiki directory, or a blank file called %1<br>%2.<br><br> Don\'t forget to remove write access again later, i.e., <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'If, for any reason, you can\'t do this, you\'ll have to copy the text below into a new file and save/upload it as %1 into the WackoWiki directory. Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'written at ',
'DontChange'					=> 'do not change wacko_version manually!',
'ConfigDescription'				=> 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Prøv igen',

];
