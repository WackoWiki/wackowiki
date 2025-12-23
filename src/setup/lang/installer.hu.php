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

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'Kategória',
	'groups_page'		=> 'Csoportok',
	'users_page'		=> 'Felhasználók',
	'tools_page'		=> 'Eszközök',

	'search_page'		=> 'Keresés',
	'login_page'		=> 'Bejelentkezés',
	'account_page'		=> 'Beállítások',
	'registration_page'	=> 'Regisztráció',
	'password_page'		=> 'Jelszó',

	'whatsnew_page'		=> 'WhatsNew',
	'changes_page'		=> 'FrissVáltoztatások',
	'comments_page'		=> 'UtolsóMegjegyzések',
	'index_page'		=> 'OldalIndex',

	'random_page'		=> 'LapTalálomra',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki Telepítés',
'TitleUpdate'					=> 'WackoWiki Update',
'Continue'						=> 'Folytatni',
'Back'							=> 'Vissza',
'Recommended'					=> 'ajánlott',
'InvalidAction'					=> 'Invalid action',

/*
   Locking Check
 */
'LockAuthorization'				=> 'Authorization',
'LockAuthorizationInfo'			=> 'Kérjük, írja be a %1 fájlban elmentett jelszót.',
'LockPassword'					=> 'Jelszó:',
'LockLogin'						=> 'Bejelentkezés',
'LockPasswordInvalid'			=> 'Invalid password.',
'LockedTryLater'				=> 'Ez az oldal jelenleg frissítés alatt áll. Kérjük, próbálkozzon újra később.',
'EmptyAuthFile'					=> 'Hiányzik vagy üres a %1 fájl. Kérjük, hozza létre a fájlt, és állítson be jelszót abban a fájlban.',


/*
   Language Selection Page
*/
'lang'							=> 'Nyelvi Beállítások',
'PleaseUpgradeToR6'				=> 'Ön tisztában legyen fut egy régi felszabadulását WackoWiki %1. A WackoWiki ezen kiadásának frissítéséhez először frissítenie kell a telepítést %2-re.',
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
'Example'						=> 'Example',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Úgy tűnik, hogy a PHP telepítéséből hiányoznak a WackoWiki által megkövetelt megjegyzett PHP kiterjesztések.',
'PcreWithoutUtf8'				=> 'Úgy tűnik, hogy a PHP PRCE modulja PRCE_UTF8 támogatás nélkül lett fordítva.',
'NotePermissions'				=> 'This installer will try to write the configuration data to the file %1, located in your WackoWiki directory. In order for this to work, you must make sure the web server has write access to that file.  If you can\'t do this, you will have to edit the file manually (the installer will tell you how).<br><br>See <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'ErrorPermissions'				=> 'Úgy tűnik, hogy a telepítő nem tudja automatikusan beállítani a WackoWiki megfelelő működéséhez szükséges fájlengedélyeket. A telepítés folyamán később a rendszer kéri, hogy manuálisan állítsa be a szükséges fájlengedélyeket a szerveren.',
'ErrorMinPhpVersion'			=> 'A PHP verziónak nagyobbnak kell lennie, mint a %1, úgy tűnik, hogy a szerverén egy korábbi verzió fut. A WackoWiki helyes működéséhez frissítenie kell egy újabb PHP verzióra.',
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
'AclMode'						=> 'Alapértelmezett ACL-beállítások',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Nyilvános Wiki (mindenki olvassa el, regisztrált felhasználók írhatnak és kommentálhatnak)',
'PrivateWiki'					=> 'Privát Wiki (olvasni, írni, kommentelni csak regisztrált felhasználók számára)',
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
'BaseDesc'						=> 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash, i.e.',
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
'DbSqlMode'						=> 'SQL mode',
'DbSqlModeDesc'					=> 'The SQL mode you want use.',
'DbVendor'						=> 'Vendor',
'DbVendorDesc'					=> 'The database vendor you use.',
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
'DbNameSqliteDesc'				=> 'The data directory and file name SQLite should use for WackoWiki.',
'DbNameSqliteHelp'				=> 'Az SQLite az összes adatot egyetlen fájlban tárolja.<br><br>A megadott könyvtárnak a telepítés során írható állapotúnak kell lennie a webszerver számára.<br><br>A könyvtár <strong>nem</strong> lehet elérhető a weben keresztül. <br><br>A telepítő egy <code>.htaccess</code> fájlt is létrehoz, de ha ez nem sikerül, akkor valaki hozzáférhet a nyers adatbázisához.<br>Ez magában foglalja a nyers felhasználói adatokat (e-mail címek, hash-elt jelszavak), valamint a védett oldalakat és a wiki egyéb korlátozott adatait.<br><br>Fontolja meg, hogy az adatbázist egy teljesen más helyre helyezi, például a <code>/var/lib/wackowiki/yourwiki</code> mappába.',
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
'SqliteFileExtensionError'		=> 'Kérjük, használja az alábbi fájlkiterjesztések egyikét: db, sdb, sqlite.',
'SqliteParentUnwritableGroup'	=> 'Nem hozható létre a(z) <code>%1</code> adatkönyvtár, mert a szülőkönyvtárba <code>%2</code> nem írhat a webszerver.<br><br>A telepítő megállapította, hogy mely felhasználó futtatja a webszervert.<br>A folytatáshoz tedd írhatóvá a(z) <code>%3</code> könyvtárat.<br>Unix/Linux rendszeren tedd a következőt:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> 'Nem lehet létrehozni az adatok tárolásához szükséges <code>%1</code> könyvtárat, mert a webszerver nem írhat a szülőkönyvtárba <code>%2</code>.<br><br>A telepítő nem tudta megállapítani, hogy melyik felhasználói fiókon fut a webszerver.<br>A folytatáshoz tedd írhatóvá ezen fiók (és más fiókok!) számára a következő könyvtárat: <code>%3</code>.<br>Unix/Linux rendszereken tedd a következőt:<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> 'Nem sikerült létrehozni a következő adatkönyvtárat: <code>%1</code>.<br>Ellenőrizd a helyet, majd próbáld újra.',
'SqliteDirUnwritable'			=> 'Nem sikerült írni a következő könyvtárba: <code>%1</code>.<br>Módosítsd a jogosultságokat úgy, hogy a webszerver tudjon oda írni, majd próbáld újra.',
'SqliteReadonly'				=> 'A következő fájl nem írható: <code>%1</code>.',
'SqliteCantCreateDb'			=> 'Nem sikerült létrehozni a következő adatbázisfájlt: <code>%1</code>.',
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
'CreatingIndex'					=> 'Creating %1 index',
'CreatingTrigger'				=> 'Creating %1 trigger',
'ErrorAlreadyExists'			=> 'The %1 already exists',
'ErrorCreatingTable'			=> 'Error creating %1 table, does it already exist?',
'ErrorCreatingIndex'			=> 'Error creating %1 index, does it already exist?',
'ErrorCreatingTrigger'			=> 'Error creating %1 trigger, does it already exist?',
'DeletingTables'				=> 'Táblázatok törlése',
'DeletingTablesEnd'				=> 'Finished Deleting Tables',
'ErrorDeletingTable'			=> 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable'					=> 'Deleting %1 table',
'NextStep'						=> 'In the next step, the installer will try to write the updated configuration file, %1.  Please make sure the web server has write access to the file, or you will have to edit it manually.  Once again, see  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',

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
'ErrorGivePrivileges'			=> 'The configuration file %1 could not be written. You will need to give your web server temporary write access to either your WackoWiki directory, or a blank file called %1<br>%2<br><br>Don\'t forget to remove write access again later, i.e.<br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'If, for any reason, you can\'t do this, you\'ll have to copy the text below into a new file and save/upload it as %1 into the WackoWiki directory. Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'written at ',
'DontChange'					=> 'nem változik wacko_version kézzel!',
'ConfigDescription'				=> 'részletes leírása https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Próbáld újra',

];
