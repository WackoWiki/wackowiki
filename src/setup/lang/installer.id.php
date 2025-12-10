<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'id',
'LangLocale'	=> 'id_ID',
'LangName'		=> 'Indonesian',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'Kategori',
	'groups_page'		=> 'Kelompok',
	'users_page'		=> 'Pengguna',

	'search_page'		=> 'Cari',
	'login_page'		=> 'Log masuk',
	'account_page'		=> 'Pengaturan',
	'registration_page'	=> 'Registrasi',
	'password_page'		=> 'Kata sandi',

	'whatsnew_page'		=> 'WhatsNew',
	'changes_page'		=> 'RecentChanges',
	'comments_page'		=> 'RecentlyCommented',
	'index_page'		=> 'PageIndex',

	'random_page'		=> 'RandomPage',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki Installation',
'TitleUpdate'					=> 'WackoWiki Update',
'Continue'						=> 'Lanjutkan',
'Back'							=> 'Back',
'Recommended'					=> 'recommended',
'InvalidAction'					=> 'Invalid action',

/*
   Locking Check
 */
'LockAuthorization'				=> 'Otorisasi',
'LockAuthorizationInfo'			=> 'Silakan masukkan kata sandi yang Anda simpan dalam berkas %1.',
'LockPassword'					=> 'Kata sandi:',
'LockLogin'						=> 'Log masuk',
'LockPasswordInvalid'			=> 'Invalid password.',
'LockedTryLater'				=> 'This site is currently being upgraded. Please try again later.',
'EmptyAuthFile'					=> 'Berkas %1 hilang atau kosong. Silakan buat berkas tersebut dan atur kata sandi di dalamnya.',


/*
   Language Selection Page
*/
'lang'							=> 'Language Configuration',
'PleaseUpgradeToR6'				=> 'You appear to be running an old release of WackoWiki %1. To update to this release of WackoWiki, you must first update your installation to %2.',
'UpgradeFromWacko'				=> 'Welcome to WackoWiki! It appears that you are upgrading from WackoWiki %1 to %2.  The next few pages will guide you through the upgrade process.',
'FreshInstall'					=> 'Welcome to WackoWiki! You are about to install WackoWiki %1.  The next few pages will guide you through the installation process.',
'PleaseBackup'					=> 'Please, <strong>backup</strong> your database, config file and all changed files such as those which have local hacks and patches applied to them before starting upgrade process. This can save you from a big headache.',
'LangDesc'						=> 'Please choose a language for the installation process. This language will also be used as the default language of your WackoWiki installation.',

/*
   System Requirements Page
*/
'version-check'					=> 'System Requirements',
'PhpVersion'					=> 'Versi PHP',
'PhpDetected'					=> 'Detected PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'Basis data',
'PhpExtensions'					=> 'Ekstensi PHP',
'Permissions'					=> 'Hak akses',
'ReadyToInstall'				=> 'Ready to Install?',
'Requirements'					=> 'Your server must meet the requirements listed below.',
'OK'							=> 'OK',
'Problem'						=> 'Problem',
'Example'						=> 'Example',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Your PHP installation appears to be missing the indicated PHP extensions, which are required by WackoWiki.',
'PcreWithoutUtf8'				=> 'PCRE is not compiled with UTF-8 support.',
'NotePermissions'				=> 'This installer will try to write the configuration data to the file %1, located in your WackoWiki directory. In order for this to work, you must make sure the web server has write access to that file.  If you can\'t do this, you will have to edit the file manually (the installer will tell you how).<br><br>See <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'ErrorPermissions'				=> 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly. You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPhpVersion'			=> 'The PHP version must be greater than %1. Your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready'							=> 'Congratulations, it appears that your server is capable of running WackoWiki. The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'config-site'					=> 'Site Configuration',
'SiteName'						=> 'Wiki Name',
'SiteNameDesc'					=> 'Please enter the name of your Wiki site.',
'SiteNameDefault'				=> 'MyWikiSite',
'HomePage'						=> 'Halaman Beranda',
'HomePageDesc'					=> 'Enter the name you would like your home page to have. This will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'HomePage',
'MultiLang'						=> 'Multi Language Mode',
'MultiLangDesc'					=> 'Multilingual mode allows you to have pages with different language settings within a single installation. When this mode is enabled, the installer creates initial menu items for all languages available in the distribution.',
'AllowedLang'					=> 'Allowed Languages',
'AllowedLangDesc'				=> 'Disarankan untuk memilih hanya serangkaian bahasa yang ingin Anda gunakan, jika tidak, semua bahasa akan dipilih.',
'AclMode'						=> 'Pengaturan ACL default',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Wiki Publik (baca untuk semua orang, tulis dan komentari untuk pengguna terdaftar)',
'PrivateWiki'					=> 'Wiki Pribadi (baca, tulis, komentari hanya untuk pengguna terdaftar)',
'Admin'							=> 'Admin Name',
'AdminDesc'						=> 'Enter the admin\'s username. This should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Username must be between %1 and %2 chars long and use only alphanumeric characters. Uppercase characters are OK.',
'NameCamelCaseOnly'				=> 'Nama pengguna harus terdiri dari %1 sampai %2 karakter dan menggunakan format WikiName.',
'Password'						=> 'Admin Password',
'PasswordDesc'					=> 'Choose a password for the admin with a minimum of %1 characters.',
'PasswordConfirm'				=> 'Repeat Password:',
'Mail'							=> 'Admin Email Address',
'MailDesc'						=> 'Enter the admin\'s email address.',
'Base'							=> 'Base URL',
'BaseDesc'						=> 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash, i.e.',
'Rewrite'						=> 'Rewrite Mode',
'RewriteDesc'					=> 'Rewrite mode should be enabled if you are using WackoWiki with URL rewriting.',
'Enabled'						=> 'Diaktifkan:',
'ErrorAdminEmail'				=> 'You have entered an invalid email address!',
'ErrorAdminPasswordMismatch'	=> 'The passwords do not match!.',
'ErrorAdminPasswordShort'		=> 'The admin password is too short! The minimum length is %1 characters.',
'ModRewriteStatusUnknown'		=> 'The installer cannot verify that mod_rewrite is enabled. This, however, does not mean it is disabled.',

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
'DbNameSqliteDesc'				=> 'The data directory and file name SQLite should use for WackoWiki.',
'DbNameSqliteHelp'				=> 'SQLite menyimpan semua data dalam satu berkas.<br><br>Direktori yang Anda berikan harus dapat ditulis oleh server web selama proses instalasi.<br><br>Direktori tersebut <strong>tidak</strong> boleh dapat diakses melalui web. <br><br>Pemasang akan membuat berkas <code>.htaccess</code> bersamaan dengan itu, tetapi jika gagal, seseorang dapat mengakses basis data mentah Anda.<br>Hal ini termasuk data pengguna mentah (alamat email, kata sandi yang dienkripsi) serta halaman yang dilindungi dan data terbatas lainnya di wiki.<br><br>Pertimbangkan untuk menempatkan basis data di tempat lain sepenuhnya, misalnya di <code>/var/lib/wackowiki/yourwiki</code>.',
'DbUser'						=> 'User Name',
'DbUserDesc'					=> 'Name of the user used to connect to your database.',
'DbPassword'					=> 'Kata sandi',
'DbPasswordDesc'				=> 'Password of the user used to connect to your database.',
'Prefix'						=> 'Table Prefix',
'PrefixDesc'					=> 'Prefix of all tables used by WackoWiki. This allows you to run multiple WackoWiki installations using the same database by configuring them to use different table prefixes (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'No database driver has been detected, please enable either the mysqli or pdo_mysql extension in your php.ini file.',
'ErrorNoDbDriverSelected'		=> 'No database driver has been selected, please pick one from the list.',
'DeleteTables'					=> 'Delete Existing Tables?',
'DeleteTablesDesc'				=> 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone, and you will be required to manually restore the data from a backup.',
'ConfirmTableDeletion'			=> 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'install-database'				=> 'Database Installation',
'TestingConfiguration'			=> 'Testing Configuration',
'TestConnectionString'			=> 'Testing database connection settings',
'TestDatabaseExists'			=> 'Checking if the database you specified exists',
'TestDatabaseVersion'			=> 'Checking database minimum version requirements',
'SqliteFileExtensionError'		=> 'Silakan gunakan salah satu ekstensi file berikut: db, sdb, sqlite.',
'SqliteParentUnwritableGroup'	=> 'Tidak dapat membuat direktori data <code>%1</code>, karena direktori induk <code>%2</code> tidak bisa ditulisi oleh server web.<br><br>Penginstal telah menentukan pengguna yang menjalankan server web Anda.<br>Buat direktori <code>%3</code> menjadi dapat ditulisi olehnya.<br>Pada sistem Unix/Linux lakukan hal berikut:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> 'Tidak dapat membuat direktori data <code>%1</code>, karena direktori induk <code>%2</code> tidak bisa ditulisi oleh server web.<br><br>Penginstal tidak dapat menentukan pengguna yang menjalankan server web Anda.<br>Buat direktori <code>%3</code> menjadi dapat ditulisi oleh semua orang.<br>Pada sistem Unix/Linux lakukan hal berikut:<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> 'Kesalahan saat membuat direktori data <code>%1</code>.<br>Periksa lokasi dan coba lagi.',
'SqliteDirUnwritable'			=> 'Tidak dapat menulisi direktori <code>%1</code>.<br>Ubah hak akses direktori sehingga server web dapat menulis ke sana, dan coba lagi.',
'SqliteReadonly'				=> 'Berkas <code>%1</code> tidak dapat ditulisi.',
'SqliteCantCreateDb'			=> 'Tidak dapat membuat berkas basis data <code>%1</code>.',
'InstallTables'					=> 'Installing Tables',
'ErrorDbConnection'				=> 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDatabaseVersion'			=> 'The database version is %1 but requires at least %2.',
'To'							=> 'ke',
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
