<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'utf-8',
'LangISO' => 'hu',
'LangName' => 'Magyar',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages
	'category_page'		=> 'Kategória',
	'groups_page'		=> 'Csoportok',
	'users_page'		=> 'Felhasználók',

	'search_page'		=> 'Keresés',
	'login_page'		=> 'Bejelentkezés',
	'account_page'		=> 'Beállítások',
	'registration_page'	=> 'Regisztráció',
	'password_page'		=> 'Jelszó',

	'changes_page'		=> 'FrissVáltoztatások',
	'comments_page'		=> 'UtolsóMegjegyzések',
	'index_page'		=> 'OldalIndex',

	'random_page'		=> 'LapTalálomra',
	#'help_page'		=> 'Segítség',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',

	// time
	#'date_format'					=> 'd.m.Y',
	#'time_format'					=> 'H:i',
	#'time_format_seconds'			=> 'H:i:s',
],

/*
   Generic Page Text
*/
'Title' => 'WackoWiki Telepítés',
'Continue' => 'Folytatni',
'Back' => 'Vissza',
'Recommended' => 'ajánlott',
'InvalidAction' => 'Invalid action',

/*
   Language Selection Page
*/
'lang' => 'Nyelvi beállítások',
'PleaseUpgradeToR5' => 'You aware to be running an old (pre %1) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to %2.',
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki %1 to %2.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki %1.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Please, <strong>backup</strong> your database, config file and all changed files such as those which have hacks and patches applied to them before starting upgrade process. This can save you from big headache.',
'LangDesc' => 'Please choose a language for the installation process. This language will also be used as the default language of your WackoWiki installation.',

/*
   System Requirements Page
*/
'version-check' => 'Rendszerkövetelmények',
'PhpVersion' => 'PHP Version',
'PhpDetected' => 'Detected PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Extension (mod_rewrite) Installed?',
'Database' => 'Adatbázis',
'PhpExtensions' => 'PHP Extensions',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Ready to Install?',
'Requirements' => 'Your server must meet the requirements listed below.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePhpExtensions' => '',
'ErrorPhpExtensions' => 'Your PHP installation appears to be missing the noted PHP extensions which are required by WackoWiki.',
'PcreWithoutUtf8' => 'PCRE is not compiled with UTF-8 support.',
'NotePermissions' => 'This installer will try to write the configuration data to the file %1, located in your WackoWiki directory. In order for this to work, you must make sure the web server has write access to that file.  If you can\'t do this, you will have to edit the file manually (the installer will tell you how).<br><br>See <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly. You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPhpVersion' => 'The PHP Version must be greater than <strong>' . PHP_MIN_VERSION . '</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki. The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'config-site' => 'Site Configuration',
'SiteName' => 'Wiki Name',
'SiteNameDesc' => 'Please enter the name of your Wiki site.',
'HomePage' => 'Home Page',
'HomePageDesc' => 'Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault' => 'HomePage',
'MultiLang' => 'Multi Language Mode',
'MultiLangDesc' => 'Multilanguage mode allows to have pages with different language settings within single installation. If this mode is enabled, installer will create initial menu items for all languages available in distribution.',
'AllowedLang' => 'Allowed Languages',
'AllowedLangDesc' => 'It is recommended to select only the set of languages you want to use, other wise all languages are selected.',
'Admin' => 'Admin Name',
'AdminDesc' => 'Enter the admins username, this should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'Password' => 'Admin Password',
'PasswordDesc' => 'Choose a password for the admin with a minimum of %1 characters.',
'Password2' => 'Repeat Password:',
'Mail' => 'Admin Email Address',
'MailDesc' => 'Enter the admins email address.',
'Base' => 'Base URL',
'BaseDesc' => 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => 'Rewrite Mode',
'RewriteDesc' => 'Rewrite mode should be enabled if you are using WackoWiki with URL rewriting.',
'Enabled' => 'Enabled:',
'ErrorAdminEmail' => 'You have entered an invalid email address!',
'ErrorAdminPasswordMismatch' => 'The passwords do not match!.',
'ErrorAdminPasswordShort' => 'The admin password is too short, the minimum length is %1 characters!',
'WarningRewriteMode' => 'ATTENTION!\nYour base URL and rewrite-mode settings looks suspicious. Usually there is no ? mark in the base URL if rewrite-mode is set - but in your case there is one.\n\nTo continue with these settings click OK.\nTo return to the form and change your settings click CANCEL.\n\nIf you are about to proceed with these settings, please note that they COULD cause problems with your WackoWiki installation.',
'ModRewriteStatusUnknown' => 'The installer cannot verify that mod_rewrite is enabled, however this does not mean it is disabled',

'LanguageArray'	=> [
	'bg' => 'bulgarian',
	'da' => 'danish',
	'nl' => 'dutch',
	'el' => 'greek',
	'en' => 'english',
	'et' => 'estonian',
	'fr' => 'french',
	'de' => 'german',
	'hu' => 'hungarian',
	'it' => 'italian',
	'pl' => 'polish',
	'pt' => 'portuguese',
	'ru' => 'russian',
	'es' => 'spanish',
],

/*
   Database Config Page
*/
'config-database' => 'Adatbázis konfiguráció',
'DbDriver' => 'Driver',
'DbDriverDesc' => 'The database driver you want to use. You must choose a legacy driver if you do not have <a href="https://secure.php.net/pdo" target="_blank">PDO</a> installed.',
'DbCharset' => 'Charset',
'DbCharsetDesc' => 'The database charset you want to use.',
'DbEngine' => 'Engine',
'DbEngineDesc' => 'The database engine you want to use.',
'DbHost' => 'Host',
'DbHostDesc' => 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort' => 'Port (Optional)',
'DbPortDesc' => 'The port number your database server is accessible through, leave it blank to use the default port number.',
'Db' => 'Adatbázis név',
'DbDesc' => 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DbUserDesc' => 'Name of the user used to connect to your database.',
'DbUser' => 'User Name',
'DbPasswordDesc' => 'Password of the user used to connect to your database.',
'DbPassword' => 'Password',
'PrefixDesc' => 'Prefix of all tables used by WackoWiki. This allows you to run multiple WackoWiki installations using the same database by configuring them to use different table prefixes (e.g. wacko_).',
'Prefix' => 'Table Prefix',
'ErrorNoDbDriverDetected' => 'No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.',
'ErrorNoDbDriverSelected' => 'No database driver has been selected, please pick one from the list.',
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'install-database' => 'Adatbázis telepítés',
'TestingConfiguration' => 'Testing Configuration',
'TestConnectionString' => 'Testing database connection settings',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'TestDatabaseVersion' => 'Checking database minimum version requirements',
'InstallingTables' => 'Táblák telepítése',
'ErrorDbConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDbExists' => 'The database you configured was not found. Remember, it needs to exist before you can install/upgrade WackoWiki!',
'ErrorDatabaseVersion' => 'The database version is %1 but requires at least %2.',
'To' => 'to',
'AlterTable' => 'Altering %1 table',
'InsertRecord' => 'Inserting Record into %1 table',
'RenameTable' => 'Renaming %1 table',
'UpdateTable' => 'Updating %1 table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Adding <code>System</code> User',
'InstallingDeletedAccount' => 'Adding <code>Deleted</code> User',
'InstallingAdmin' => 'Adding Admin User',
'InstallingAdminSetting' => 'Adding Admin User Preferences',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Adding Logo Image',
'LogoImage' => 'Logo image',
'InstallingConfigValues' => 'Adding Config Values',
'ConfigValues' => 'Config Values',
'ErrorInsertingPage' => 'Error inserting %1 page',
'ErrorInsertingPagePermission' => 'Error setting permission for %1 page',
'ErrorInsertingDefaultMenuItem' => 'Error setting page %1 as default menu item',
'ErrorPageAlreadyExists' => 'The %1 page already exists',
'ErrorAlteringTable' => 'Error altering %1 table',
'ErrorInsertingRecord' => 'Error Inserting Record into %1 table',
'ErrorRenamingTable' => 'Error renaming %1 table',
'ErrorUpdatingTable' => 'Error updating %1 table',
'CreatingTable' => 'Creating %1 table',
'ErrorAlreadyExists' => 'The %1 already exists',
'ErrorCreatingTable' => 'Error creating %1 table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Moving data to revisions table',
'DeletingTables' => 'Táblázatok törlése',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config' => 'Write Config File',
'FinalStep' => 'Final Step',
'Writing' => 'Writing Configuration File',
'RemovingWritePrivilege' => 'Removing Write Privilege',
'InstallationComplete' => 'Telepítés befejezve',
'ThatsAll' => 'That\'s all! You can now <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations' => 'Security Considerations',
'SecurityRisk' => 'You are advised to remove write access to %1 again now that it\'s been written. Leaving the file writable can be a security risk!<br>i.e. %2',
'RemoveSetupDirectory' => 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'The configuration file %1 could not be written. You will need to give your web server temporary write access to either your WackoWiki directory, or a blank file called %1<br>%2<br>; don\'t forget to remove write access again later, i.e. %3.<br>If, for any reason, you can\'t do this, you\'ll have to copy the text below into a new file and save/upload it as %1 into the WackoWiki directory. Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'In the next step, the installer will try to write the updated configuration file, %1.  Please make sure the web server has write access to the file, or you will have to edit it manually.  Once again, see  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'WrittenAt' => 'written at ',
'DontChange' => 'do not change wacko_version manually!',
'ConfigDescription' => 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain' => 'Próbáld újra',

];
