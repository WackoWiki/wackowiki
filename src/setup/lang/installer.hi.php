<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'hi',
'LangLocale'	=> 'hi_IN',
'LangName'		=> 'हिन्दी',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'वर्ग',
	'groups_page'		=> 'समूह',
	'users_page'		=> 'उपयोगकर्ताओं',

	'search_page'		=> 'खोजें',
	'login_page'		=> 'प्रवेश',
	'account_page'		=> 'स्थापनायें',
	'registration_page'	=> 'पंजीकरण',
	'password_page'		=> 'कूटशब्द',

	'whatsnew_page'		=> 'WhatsNew',
	'changes_page'		=> 'RecentChanges',
	'comments_page'		=> 'हालकीटिप्पणियाँ',
	'index_page'		=> 'PageIndex',

	'random_page'		=> 'यादृच्छिकपृष्ठ',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki Installation',
'TitleUpdate'					=> 'WackoWiki Update',
'Continue'						=> 'जारी रखें',
'Back'							=> 'वापस',
'Recommended'					=> 'recommended',
'InvalidAction'					=> 'Invalid action',

/*
   Locking Check
 */
'LockAuthorization'				=> 'Authorization',
'LockAuthorizationInfo'			=> 'Please enter the password you saved in the file %1, which you temporarily placed in your Wacko directory.',
'LockPassword'					=> 'कूटशब्द:',
'LockLogin'						=> 'प्रवेश',
'LockPasswordInvalid'			=> 'Invalid password.',
'LockedTryLater'				=> 'This site is currently being upgraded. Please try again later.',


/*
   Language Selection Page
*/
'lang'							=> 'Language Configuration',
'PleaseUpgradeToR6'				=> 'You appear to be running an old release of WackoWiki %1. To update to this release of WackoWiki, you must first update your installation to %2.',
'UpgradeFromWacko'				=> 'Welcome to WackoWiki! It appears that you are upgrading from WackoWiki %1 to %2.  The next few pages will guide you through the upgrade process.',
'FreshInstall'					=> 'Welcome to WackoWiki! You are about to install WackoWiki %1.  The next few pages will guide you through the installation process.',
'PleaseBackup'					=> 'कृपया, अपग्रेड प्रक्रिया शुरू करने से पहले अपने डेटाबेस, कॉन्फ़िगरेशन फ़ाइल और सभी परिवर्तित फ़ाइलों जैसे कि जिन पर स्थानीय हैक और पैच लागू किए गए हैं, का <strong>बैकअप</strong> लें। यह आपको एक बड़ी सिरदर्द से बचा सकता है।',
'LangDesc'						=> 'Please choose a language for the installation process. This language will also be used as the default language of your WackoWiki installation.',

/*
   System Requirements Page
*/
'version-check'					=> 'System Requirements',
'PhpVersion'					=> 'PHP Version',
'PhpDetected'					=> 'Detected PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'डेटाबेस',
'PhpExtensions'					=> 'PHP विस्तार',
'Permissions'					=> 'अनुमतियाँ',
'ReadyToInstall'				=> 'Ready to Install?',
'Requirements'					=> 'Your server must meet the requirements listed below.',
'OK'							=> 'OK',
'Problem'						=> 'Problem',
'Example'						=> 'Example',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'ऐसा प्रतीत होता है कि आपके PHP इंस्टॉलेशन में संकेतित PHP एक्सटेंशन गायब हैं, जो WackoWiki के लिए आवश्यक हैं।',
'PcreWithoutUtf8'				=> 'PCRE is not compiled with UTF-8 support.',
'NotePermissions'				=> 'This installer will try to write the configuration data to the file %1, located in your WackoWiki directory. In order for this to work, you must make sure the web server has write access to that file.  If you can\'t do this, you will have to edit the file manually (the installer will tell you how).<br><br>See <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'ErrorPermissions'				=> 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly. You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPhpVersion'			=> 'The PHP version must be greater than %1. Your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready'							=> 'Congratulations, it appears that your server is capable of running WackoWiki. The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'config-site'					=> 'Site Configuration',
'SiteName'						=> 'विकि का नाम',
'SiteNameDesc'					=> 'Please enter the name of your Wiki site.',
'SiteNameDefault'				=> 'मेरा विकि',
'HomePage'						=> 'मुख पृष्ठ',
'HomePageDesc'					=> 'Enter the name you would like your home page to have. This will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'मुखपृष्ठ',
'MultiLang'						=> 'Multi Language Mode',
'MultiLangDesc'					=> 'Multilingual mode allows you to have pages with different language settings within a single installation. When this mode is enabled, the installer creates initial menu items for all languages available in the distribution.',
'AllowedLang'					=> 'Allowed Languages',
'AllowedLangDesc'				=> 'यह अनुशंसा की जाती है कि आप केवल उन्हीं भाषाओं का चयन करें जिन्हें आप उपयोग करना चाहते हैं, अन्यथा सभी भाषाएँ चयनित हो जाएंगी।',
'AclMode'						=> 'डिफ़ॉल्ट ACL सेटिंग्स',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'सार्वजनिक विकि (सभी के लिए पढ़ें, पंजीकृत उपयोगकर्ताओं के लिए लिखें और टिप्पणी करें)',
'PrivateWiki'					=> 'निजी विकि (केवल पंजीकृत उपयोगकर्ताओं के लिए पढ़ें, लिखें, टिप्पणी करें)',
'Admin'							=> 'Admin Name',
'AdminDesc'						=> 'Enter the admin\'s username. This should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'उपयोगकर्ता नाम %1 और %2 अक्षरों के बीच होना चाहिए और केवल अल्फ़ान्यूमेरिक अक्षरों का उपयोग करना चाहिए। बड़े अक्षर ठीक हैं।',
'NameCamelCaseOnly'				=> 'Username must be between %1 and %2 chars long and WikiName formatted.',
'Password'						=> 'Admin Password',
'PasswordDesc'					=> 'Choose a password for the admin with a minimum of %1 characters.',
'PasswordConfirm'				=> 'Repeat Password:',
'Mail'							=> 'Admin Email Address',
'MailDesc'						=> 'व्यवस्थापक का ईमेल पता दर्ज करें।',
'Base'							=> 'Base URL',
'BaseDesc'						=> 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash, i.e.',
'Rewrite'						=> 'Rewrite Mode',
'RewriteDesc'					=> 'Rewrite mode should be enabled if you are using WackoWiki with URL rewriting.',
'Enabled'						=> 'Enabled:',
'ErrorAdminEmail'				=> 'You have entered an invalid email address!',
'ErrorAdminPasswordMismatch'	=> 'The passwords do not match!.',
'ErrorAdminPasswordShort'		=> 'एडमिन पासवर्ड बहुत छोटा है! न्यूनतम लंबाई %1 वर्ण है।',
'ModRewriteStatusUnknown'		=> 'इंस्टॉलर यह सत्यापित नहीं कर सकता कि mod_rewrite सक्षम है। हालाँकि, इसका मतलब यह नहीं है कि यह अक्षम है।',

/*
   Database Config Page
*/
'config-database'				=> 'डेटाबेस सेटिंग',
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
'DbHost'						=> 'डेटाबेस होस्ट',
'DbHostDesc'					=> 'वह होस्ट जिस पर आपका डेटाबेस सर्वर चल रहा है, आमतौर पर <code>127.0.0.1</code> या <code>localhost</code> (अर्थात, वही मशीन जिस पर आपकी WackoWiki साइट है)।',
'DbPort'						=> 'डेटाबेस पोर्ट (Optional)',
'DbPortDesc'					=> 'The port number your database server is accessible through. Leave it blank to use the default port number.',
'DbName'						=> 'डेटाबेस का नाम',
'DbNameDesc'					=> 'The database WackoWiki should use. This database needs to exist already before you continue!',
'DbNameSqliteDesc'				=> 'The data directory and file name SQLite should use for WackoWiki.',
'DbNameSqliteHelp'				=> 'SQLite stores all data in a single file.<br><br>The directory you specify must be writable by the web server during installation. <br><br>It should <strong>not</strong> be accessible via the web.<br><br>The installation programme will create an additional <code>.htaccess</code> file along with the file, but if this fails, someone may be able to access your database. <br>This includes user data (email addresses, hashed passwords) as well as protected pages and other confidential data stored in the wiki. <br><br>It is therefore advisable to store the data file in a completely different location, for example in the directory <code>/var/lib/wackowiki/yourwiki</code>.',
'DbUser'						=> 'डेटाबेस सदस्यनाम',
'DbUserDesc'					=> 'Name of the user used to connect to your database.',
'DbPassword'					=> 'कूटशब्द',
'DbPasswordDesc'				=> 'Password of the user used to connect to your database.',
'Prefix'						=> 'Table Prefix',
'PrefixDesc'					=> 'Prefix of all tables used by WackoWiki. This allows you to run multiple WackoWiki installations using the same database by configuring them to use different table prefixes (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'No database driver has been detected, please enable either the mysqli or pdo_mysql extension in your php.ini file.',
'ErrorNoDbDriverSelected'		=> 'No database driver has been selected, please pick one from the list.',
'DeleteTables'					=> 'Delete Existing Tables?',
'DeleteTablesDesc'				=> 'ध्यान दें! यदि आप इस विकल्प को चुनकर आगे बढ़ते हैं तो आपके डेटाबेस से सभी मौजूदा विकी डेटा मिटा दिए जाएँगे। जब तक आप बैकअप से डेटा को मैन्युअल रूप से पुनर्स्थापित नहीं करते, तब तक इसे पूर्ववत नहीं किया जा सकता।',
'ConfirmTableDeletion'			=> 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'install-database'				=> 'Database Installation',
'TestingConfiguration'			=> 'Testing Configuration',
'TestConnectionString'			=> 'Testing database connection settings',
'TestDatabaseExists'			=> 'Checking if the database you specified exists',
'TestDatabaseVersion'			=> 'Checking database minimum version requirements',
'SqliteFileExtensionError'		=> 'कृपया निम्नलिखित फ़ाइल एक्सटेंशनों में से किसी एक का उपयोग करें: db, sdb, sqlite।',
'SqliteParentUnwritableGroup'	=> 'डेटा डिरेक्ट्री <code>%1</code> को बनाया नहीं जा सकता, क्योंकि जनक डिरोक्ट्री <code>%2</code> में वेब-सर्वर को लिखने की अनुमति नहीं है।<br><br>इंस्टॉलर ने उस सदस्य का पता लगा लिया है जिसके रूप में आपका वेब-सर्वर चल रहा है।<br>आगे बढ़ने के लिए <code>%3</code> डिरेक्ट्री में इसे लिखने की अनुमति दें।<br>Unix/Linux सिस्टम पर यह चलाएँ:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> 'डेटा डिरेक्ट्री <code>%1</code> को बनाया नहीं जा सकता, क्योंकि जनक डिरोक्ट्री <code>%2</code> में वेब-सर्वर को लिखने की अनुमति नहीं है।<br><br>इंस्टॉलर ने उस सदस्य का पता लगा लिया है जिसके रूप में आपका वेब-सर्वर चल रहा है।<br>आगे बढ़ने के लिए <code>%3</code> डिरेक्ट्री में इसे (और दूसरे सर्वरों को भी!) लिखने की अनुमति दें।<br>Unix/Linux सिस्टम पर यह चलाएँ:<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> 'डेटा डिरेक्ट्री <code>%1</code> बनाते समय त्रुटि हुई।\nस्थान को जाँचकर पुनः प्रयास करें।',
'SqliteDirUnwritable'			=> 'डिरेक्ट्री <code>%1</code> में लिखा न जा सका।\nइसकी अनुमतियाँ बदलें ताकि वेब-सर्वर इसमें लिख सके, और पुनः प्रयास करें।',
'SqliteReadonly'				=> 'फ़ाइल <code>%1</code> में लिखा नहीं जा सकता।',
'SqliteCantCreateDb'			=> 'डेटाबेस फ़ाइल <code>%1</code> बनाया न जा सका।',
'InstallTables'					=> 'Installing Tables',
'ErrorDbConnection'				=> 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDatabaseVersion'			=> 'The database version is %1 but requires at least %2.',
'To'							=> 'को',
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
'CreatingIndex'					=> 'Creating %1 index',
'CreatingTrigger'				=> 'Creating %1 trigger',
'ErrorAlreadyExists'			=> 'The %1 already exists',
'ErrorCreatingTable'			=> 'Error creating %1 table, does it already exist?',
'ErrorCreatingIndex'			=> 'Error creating %1 index, does it already exist?',
'ErrorCreatingTrigger'			=> 'Error creating %1 trigger, does it already exist?',
'DeletingTables'				=> 'Deleting Tables',
'DeletingTablesEnd'				=> 'Finished Deleting Tables',
'ErrorDeletingTable'			=> 'Error deleting %1 table. The most likely reason is that the table does not exist, in which case you can ignore this warning.',
'DeletingTable'					=> 'Deleting %1 table',
'NextStep'						=> 'In the next step, the installer will try to write the updated configuration file, %1.  Please make sure the web server has write access to the file, or you will have to edit it manually.  Once again, see  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',

/*
   Write Config Page
*/
'write-config'					=> 'Write Config File',
'FinalStep'						=> 'Final Step',
'Writing'						=> 'Writing Configuration File',
'RemovingWritePrivilege'		=> 'Removing Write Privilege',
'InstallationComplete'			=> 'Installation Complete',
'ThatsAll'						=> 'That\'s all! You can now <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations'		=> 'Security Considerations',
'SecurityRisk'					=> 'You are advised to remove write access to %1 now that it\'s been written. Leaving the file writable can be a security risk!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges'			=> 'The configuration file %1 could not be written. You will need to give your web server temporary write access to either your WackoWiki directory, or a blank file called %1<br>%2.<br><br> Don\'t forget to remove write access again later, i.e., <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'If, for any reason, you can\'t do this, you\'ll have to copy the text below into a new file and save/upload it as %1 into the WackoWiki directory. Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'written at ',
'DontChange'					=> 'do not change wacko_version manually!',
'ConfigDescription'				=> 'detailed description: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Try Again',

];
