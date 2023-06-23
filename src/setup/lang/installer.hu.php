<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'hu',
'LangLocale'	=> 'hu_HU',
'LangName'		=> 'Magyar',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
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
	#'privacy_page'		=> 'Adatvédelem',

	// time
	#'date_format'					=> 'dd.MM.yyyy',
	#'time_format'					=> 'HH:mm',
	#'time_format_seconds'			=> 'HH:mm:ss',
],

/*
   Generic Page Text
*/
'Title'							=> 'WackoWiki Telepítés',
'Continue'						=> 'Folytatni',
'Back'							=> 'Vissza',
'Recommended'					=> 'ajánlott',
'InvalidAction'					=> 'Invalid action',

/*
   Language Selection Page
*/
'lang'							=> 'Nyelvi Beállítások',
'PleaseUpgradeToR6'				=> 'Ön tisztában legyen fut egy régi (pre %2) felszabadulását WackoWiki (%1). A WackoWiki ezen kiadásának frissítéséhez először frissítenie kell a telepítést %2-re.',
'UpgradeFromWacko'				=> 'Üdvözöljük a WackoWiki! Úgy tűnik, hogy a (z) %1 WackoWiki verzióról %2-ra frissít. A következő néhány oldal végigvezeti Önt a frissítési folyamaton.',
'FreshInstall'					=> 'Üdvözöljük a WackoWiki oldalán, a WackoWiki %1 telepítéséhez készül. A következő néhány oldal végigvezeti Önt a frissítési folyamaton.',
'PleaseBackup'					=> 'Kérjük, a frissítési folyamat megkezdése előtt <strong>készítsen biztonsági másolatot</strong> az adatbázisról, a konfigurációs fájlról és az összes megváltozott fájlról, például azokról, amelyeken feltörések és javítások vannak. Ez megmenthet a nagy fejfájástól.',
'LangDesc'						=> 'Válasszon nyelvet a telepítési folyamathoz. Ezt a nyelvet fogja használni a WackoWiki telepítés alapértelmezett nyelveként is.',

/*
   System Requirements Page
*/
'version-check'					=> 'Rendszerkövetelmények',
'PhpVersion'					=> 'PHP verzió',
'PhpDetected'					=> 'Detektált PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'Adatbázis',
'PhpExtensions'					=> 'PHP-kiterjesztések',
'Permissions'					=> 'Jogosultságok',
'ReadyToInstall'				=> 'Készen áll a telepítésre?',
'Requirements'					=> 'Szerverének meg kell felelnie az alább felsorolt követelményeknek.',
'OK'							=> 'OK',
'Problem'						=> 'Probléma',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Úgy tűnik, hogy a PHP telepítéséből hiányoznak a WackoWiki által megkövetelt megjegyzett PHP kiterjesztések.',
'PcreWithoutUtf8'				=> 'Úgy tűnik, hogy a PHP PRCE modulja PRCE_UTF8 támogatás nélkül lett fordítva.',
'NotePermissions'				=> 'This installer will try to write the configuration data to the file %1, located in your WackoWiki directory. In order for this to work, you must make sure the web server has write access to that file.  If you can\'t do this, you will have to edit the file manually (the installer will tell you how).<br><br>See <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'ErrorPermissions'				=> 'Úgy tűnik, hogy a telepítő nem tudja automatikusan beállítani a WackoWiki megfelelő működéséhez szükséges fájlengedélyeket. A telepítés folyamán később a rendszer kéri, hogy manuálisan állítsa be a szükséges fájlengedélyeket a szerveren.',
'ErrorMinPhpVersion'			=> 'A PHP verziónak nagyobbnak kell lennie, mint a <strong>' . PHP_MIN_VERSION . '</strong>, úgy tűnik, hogy a szerverén egy korábbi verzió fut. A WackoWiki helyes működéséhez frissítenie kell egy újabb PHP verzióra.',
'Ready'							=> 'Gratulálunk, úgy tűnik, hogy a szerver képes futtatni a WackoWiki-t. A következő néhány oldalon végigvezet a konfigurációs folyamaton.',

/*
   Site Config Page
*/
'config-site'					=> 'Honlap Konfiguráció',
'SiteName'						=> 'Wiki neve',
'SiteNameDesc'					=> 'Please enter the name of your Wiki site.',
'SiteNameDefault'				=> 'SajátWiki',
'HomePage'						=> 'Címlap',
'HomePageDesc'					=> 'Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Címlap',
'MultiLang'						=> 'Többnyelvű mód',
'MultiLangDesc'					=> 'A többnyelvű mód lehetővé teszi, hogy egyetlen telepítésen belül különböző nyelvi beállításokkal rendelkező oldalak jelenjenek meg. Ha ez a mód engedélyezve van, akkor a telepítő létrehozza a kezdeti menüelemeket a disztribúcióban elérhető összes nyelvhez.',
'AllowedLang'					=> 'Engedélyezett nyelvek',
'AllowedLangDesc'				=> 'Javasoljuk, hogy csak azt a nyelvkészletet válassza, amelyet használni szeretne, egyébként minden nyelvet kiválasztva.',
'Admin'							=> 'Admin neve',
'AdminDesc'						=> 'Enter the admins username, this should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Username must be between %1 and %2 chars long and use only alphanumeric characters. Upper case characters are OK.',
'NameCamelCaseOnly'				=> 'Username must be between %1 and %2 chars long and WikiName formatted.',
'Password'						=> 'Admin jelszó',
'PasswordDesc'					=> 'Válasszon egy jelszót az adminisztrátor számára, legalább %1 karakterrel.',
'PasswordConfirm'				=> 'Jelszó újra:',
'Mail'							=> 'Admin e-mail címe',
'MailDesc'						=> 'Írja be az adminisztrátor e-mail címét.',
'Base'							=> 'Base URL',
'BaseDesc'						=> 'Your WackoWiki site base URL. Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>https://example.com/</code></strong></li><li><strong><code>https://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Rewrite Mode',
'RewriteDesc'					=> 'Rewrite mode should be enabled if you are using WackoWiki with URL rewriting.',
'Enabled'						=> 'Engedélyezett:',
'ErrorAdminEmail'				=> 'Érvénytelen e-mail címet adott meg!',
'ErrorAdminPasswordMismatch'	=> 'A jelszavak nem egyeznek!',
'ErrorAdminPasswordShort'		=> 'Az admin jelszó túl rövid, a minimális hossz %1 karakter!',
'ModRewriteStatusUnknown'		=> 'A telepítő nem tudja ellenőrizni, hogy a mod_rewrite engedélyezve van-e, de ez nem jelenti azt, hogy le van tiltva',

/*
   Database Config Page
*/
'config-database'				=> 'Adatbázis Konfiguráció',
'DbDriver'						=> 'Driver',
'DbDriverDesc'					=> 'The database driver you want to use.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'The database charset you want to use.',
'DbEngine'						=> 'Engine',
'DbEngineDesc'					=> 'The database engine you want to use.',
'DbHost'						=> 'Host',
'DbHostDesc'					=> 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort'						=> 'Port (Optional)',
'DbPortDesc'					=> 'The port number your database server is accessible through, leave it blank to use the default port number.',
'DbName'						=> 'Adatbázis név',
'DbNameDesc'					=> 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DbUser'						=> 'Felhasználónév',
'DbUserDesc'					=> 'Az adatbázisához való csatlakozáshoz használt felhasználó neve.',
'DbPassword'					=> 'Jelszó',
'DbPasswordDesc'				=> 'Az adatbázisához való csatlakozáshoz használt felhasználó jelszava.',
'Prefix'						=> 'Table Prefix',
'PrefixDesc'					=> 'Prefix of all tables used by WackoWiki. This allows you to run multiple WackoWiki installations using the same database by configuring them to use different table prefixes (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'No database driver has been detected, please enable either the mysqli or pdo_mysql extension in your php.ini file.',
'ErrorNoDbDriverSelected'		=> 'Nincs kiválasztva adatbázis-illesztőprogram, kérjük, válasszon egyet a listából.',
'DeleteTables'					=> 'Törli a meglévő táblázatokat?',
'DeleteTablesDesc'				=> 'FIGYELEM! Ha folytatja ezt a beállítást, akkor az összes aktuális wiki adat törlődik az adatbázisból. Ezt nem lehet visszavonni, ha manuálisan nem állítja vissza az adatokat egy biztonsági másolatból.',
'ConfirmTableDeletion'			=> 'Biztosan törli az összes jelenlegi wiki táblázatot?',

/*
   Database Installation Page
*/
'install-database'				=> 'Adatbázis Telepítés',
'TestingConfiguration'			=> 'Tesztelés konfiguráció',
'TestConnectionString'			=> 'Tesztelés adatbázis-kapcsolat beállításait',
'TestDatabaseExists'			=> 'Ellenőrzése, ha a megadott adatbázis létezik',
'TestDatabaseVersion'			=> 'Ellenőrzés adatbázis minimális követelmények',
'InstallTables'					=> 'Táblák telepítése',
'ErrorDbConnection'				=> 'Probléma merült fel az Ön által megadott adatbázis-kapcsolat részleteivel kapcsolatban. Kérjük, lépjen vissza és ellenőrizze, hogy helyesek-e.',
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
'DeletingTables'				=> 'Táblázatok törlése',
'DeletingTablesEnd'				=> 'Finished Deleting Tables',
'ErrorDeletingTable'			=> 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable'					=> 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config'					=> 'Write Config File',
'FinalStep'						=> 'Végső lépés',
'Writing'						=> 'Írás konfigurációs fájl',
'RemovingWritePrivilege'		=> 'Removing Write Privilege',
'InstallationComplete'			=> 'Telepítés befejezve',
'ThatsAll'						=> 'Ez minden! Most már <a href="%1">megtekintheted a WackoWiki oldaladat</a>.',
'SecurityConsiderations'		=> 'Biztonsági szempontok',
'SecurityRisk'					=> 'You are advised to remove write access to %1 again now that it\'s been written. Leaving the file writable can be a security risk!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges'			=> 'The configuration file %1 could not be written. You will need to give your web server temporary write access to either your WackoWiki directory, or a blank file called %1<br>%2<br><br>Don\'t forget to remove write access again later, i.e.<br>%3.<br><br>If, for any reason, you can\'t do this, you\'ll have to copy the text below into a new file and save/upload it as %1 into the WackoWiki directory. Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep'						=> 'In the next step, the installer will try to write the updated configuration file, %1.  Please make sure the web server has write access to the file, or you will have to edit it manually.  Once again, see  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'WrittenAt'						=> 'written at ',
'DontChange'					=> 'nem változik wacko_version kézzel!',
'ConfigDescription'				=> 'részletes leírása https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Próbáld újra',

];
