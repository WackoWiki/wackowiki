<?php
$lang = array(

/*
   Generic Page Text
*/
"Title" => "WackoWiki Installation",
"Continue" => "Continue",
"Back" => "Back",

/*
   Language Selection Page
*/
"Lang" => "Language Configuration",
"LangDesc" => "Please choose a language for the installation process. This language will also be used as the default language of your WackoWiki installation.",

/*
   System Requirements Page
*/
"version-check" => "System Requirements",
"PHPVersion" => "PHP Version",
"PHPDetected" => "Detected PHP",
"ModRewrite" => "Apache Rewrite Extension (Optional)",
"ModRewriteInstalled" => "Rewrite Extension (mod_rewrite) Installed?",
"Database" => "Database",
"Permissions" => "Permissions",
"ReadyToInstall" => "Ready to Install?",
"Installed" => "Your installed WackoWiki is reporting itself as ",
"ToUpgrade" => "You are about to <strong>upgrade</strong> to WackoWiki ",
"PleaseBackup" => "Please, backup your database, config file and all changed files such as those which have hacks and patches applied to them before starting upgrade process. This can save you from big headache.",
"Fresh" => "Since there is no existing WackoWiki configuration file, this is probably a fresh WackoWiki install. You are about to install WackoWiki ",
"Requirements" => "Your server must meet the requirements listed below.",
"OK" => "OK",
"Problem" => "Problem",
"NotePermissions" => "This installer will try to write the configuration data to the file <tt>wakka.config.php</tt>, located in your WackoWiki directory. In order for this to work, you must make sure the web server has write access to that file.  If you can't do this, you will have to edit the file manually (the installer will tell you how).<br /><br />See <a href=\"http://wackowiki.de/Archiv/DocEnglish/Installation\" target=\"_blank\">WackoWiki:DocEnglish/Installation</a> for details.",
"ErrorPermissions" => "It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.",
"ErrorMinPHPVersion" => "The PHP Version must be greater than <strong>4.3.3</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.",
"Ready" => "Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.",

/*
   Site Config Page
*/
"site-config" => "Site Configuration",
"Name" => "WackoWiki Name",
"NameDesc" => "Please enter the name of your WackoWiki site, this should be a <a href=\"http://wackowiki.de/Archiv/DocEnglish/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"Home" => "Home Page",
"HomeDesc" => "Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href=\"http://wackowiki.de/Archiv/DocEnglish/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"MultiLang" => "Multi Language Mode",
"MultiLangDesc" => "Multilanguage mode allows to have pages with different language settings within single installation. If this mode is enabled, installer will create initial pages for all languages available in distribution.",
"Admin" => "Admin Name",
"AdminDesc" => "Enter the admins username, this should be a <a href=\"http://wackowiki.de/Archiv/DocEnglish/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"Password" => "Admin Password",
"PasswordDesc" => "Choose a password for the admin with a minimum of 5 characters.",
"Password2" => "Repeat Password:",
"Mail" => "Admin Email Address",
"MailDesc" => "Enter the admins email address.",
"Base" => "Base URL",
"BaseDesc" => "Your WackoWiki sites base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><b><i>http://www.wackowiki.de/</i></b></li><li><b><i>http://www.wackowiki.de/wiki/</i></b></li></ul><p class=\"no_top\">If you are not going to use mod_rewrite then the URL should end with \"?page=\" i.e.<ul><li><b><i>http://www.wackowiki.de/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.de/wiki/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.de/?page=</i></b></li><li><b><i>http://www.wackowiki.de?page=</i></b></li></ul>",
"Rewrite" => "Rewrite Mode",
"RewriteDesc" => "Rewrite mode should be enabled if you are using WackoWiki with URL rewriting.",
"Enabled" => "Enabled:",
"ErrorAdminName" => "The admin name must be a WikiName!",
"ErrorAdminEmail" => "You have entered an invalid email address!",
"ErrorAdminPasswordMismatch" => "The passwords do not match!.",
"ErrorAdminPasswordShort" => "The admin password is too short, the minimum length is 5 characters!",
"WarningRewriteMode" => "ATTENTION!\nYour base URL and rewrite-mode settings looks suspicious. Usually there is no ? mark in the base URL if rewrite-mode is set - but in your case there is one.\n\nTo continue with these settings click OK.\nTo return to the form and change your settings click CANCEL.\n\nIf you are about to proceed with these settings, please note that they COULD cause problems with your WackoWiki installation.",
"ModRewriteStatusUnknown" => "The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled",

/*
   Database Config Page
*/
"database-config" => "Database Configuration",
"DBDriverDesc" => "The database driver you want to use.  You must choose a legacy driver if you do not have PHP5.1 (or greater) and <a href=\"http://de2.php.net/pdo\" target=\"_blank\">PDO</a> installed.",
"DBDriver" => "Driver",
"DBHost" => "Host",
"DBHostDesc" => "The host your database server is running on. Usually \"localhost\" (ie, the same machine your WackoWiki site is on).",
"DBPort" => "Port (Optional)",
"DBPortDesc" => "The port number your database server is accessable through, leave it blank to use the default port number.",
"DB" => "Database Name",
"DBDesc" => "The database WackoWiki should use. This database needs to exist already once you continue!",
"DBUserDesc" => "Name and password of the user used to connect to your database.",
"DBUser" => "User Name",
"DBPasswordDesc" => "Name and password of the user used to connect to your database.",
"DBPassword" => "Password",
"PrefixDesc" => "Prefix of all tables used by WackoWiki. This allows you to run multiple WackoWiki installations using the same database by configuring them to use different table prefixes.",
"Prefix" => "Table Prefix",
"ErrorNoDbDriverDetected" => "No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.",
"ErrorNoDbDriverSelected" => "No database driver has been selected, please pick one from the list.",

/*
   Database Installation Page
*/
"database-install" => "Database Installation",
"TestingConfiguration" => "Testing Configuration",
"TestConnectionString" => "Testing database connection settings",
"TestDatabaseExists" => "Checking if the database you specified exists",
"InstallingTables" => "Installing Tables",
"ErrorDBConnection" => "There was a problem with the database connection details you specified, please go back and check they are correct.",
"ErrorDBExists" => "The database you configured was not found. Remember, it needs to exist before you can install/upgrade WackoWiki!",
"To" => "to",
"AlterTable" => "Altering %1 Table",
"AlterUsersTable" => "Altering Users Table",
"InstallingDefaultData" => "Adding Default Data",
"InstallingPagesBegin" => "Adding Default Pages",
"InstallingPagesEnd" => "Finished Adding Default Pages",
"InstallingAdmin" => "Adding Admin User",
"InstallingLogoImage" => "Adding Logo Image",
"ErrorInsertingPage" => "Error inserting %1 page",
"ErrorInsertingPageReadPermission" => "Error setting read permission for %1 page",
"ErrorInsertingPageWritePermission" => "Error setting write permission for %1 page",
"ErrorInsertingPageCommentPermission" => "Error setting comment permissions for %1 page",
"ErrorPageAlreadyExists" => "The %1 page already exists",
"ErrorAlteringTable" => "Error altering %1 table",
"CreatingTable" => "Creating %1 table",
"ErrorAlreadyExists" => "The %1 already exists",
"ErrorCreatingTable" => "Error creating %1 table, does it already exist?",
"ErrorMovingRevisions" => "Error moving revision data",
"MovingRevisions" => "Moving data to revisions table",
"CleanupScript" => "If you'll use <a href=\"http://wackowiki.de/Archiv/DocEnglish/CleanupScript\" target=\"_blank\">WackoWiki:DocEnglish/CleanupScript</a>, you will speedup your Wacko.",

/*
   Write Config Page
*/
"write-config" => "Write Config File",
"Writing" => "Writing Configuration",
"Writing2" => "Writing Configuration File",
"RemovingWritePrivilege" => "Removing Write Privilege",
"InstallationComplete" => "That's all! You can now <a href=\"%1\">view your WackoWiki site</a>.",
"SecurityConsiderations" => "Security Considerations",
"SecurityRisk" => "You are advised to remove write access to <tt>wakka.config.php</tt> again now that it's been written. Leaving the file writable can be a security risk!",
"RemoveSetupDirectory" => "You should delete the \"setup\" directory now that the installation process has been completed.",
"ErrorGivePrivileges" => "The configuration file %1 could not be written. You will need to give your web server temporary write access to either your WackoWiki directory, or a blank file called <tt>wakka.config.php</tt> (<tt>touch wakka.config.php ; chmod 666 wakka.config.php</tt>; don't forget to remove write access again later, ie <tt>chmod 644 wakka.config.php</tt>). If, for any reason, you can't do this, you'll have to copy the text below into a new file and save/upload it as <tt>wakka.config.php</tt> into the WackoWiki directory. Once you've done this, your WackoWiki site should work. If not, please visit <a href=\"http://wackowiki.de/Archiv/DocEnglish/Installation\">WackoWiki:DocEnglish/Installation</a>",
"NextStep" => "In the next step, the installer will try to write the updated configuration file, <tt>wakka.config.php</tt>.  Please make sure the web server has write access to the file, or you will have to edit it manually.  Once again, see  <a href=\"http://wackowiki.de/Archiv/DocEnglish/Installation\" target=\"_blank\">WackoWiki:DocEnglish/Installation</a> for details.",
"WrittenAt" => "written at ",
"DontChange" => "do not change wakka_version manually!",
"TryAgain" => "Try Again",

);
?>