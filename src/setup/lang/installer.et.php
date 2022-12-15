<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'et',
'LangLocale'	=> 'et_EE',
'LangName'		=> 'Estonian',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Kategooria',
	'groups_page'		=> 'Grupid',
	'users_page'		=> 'Kasutajad',

	'search_page'		=> 'Otsing',
	'login_page'		=> 'Login',
	'account_page'		=> 'Settings',
	'registration_page'	=> 'Registreerimine',
	'password_page'		=> 'Parool',

	'changes_page'		=> 'ViimasedMuudatused',
	'comments_page'		=> 'ViimatiKommenteeritud',
	'index_page'		=> 'SisuKord',

	'random_page'		=> 'JuhuslikLehekülg',
	#'help_page'			=> 'Help',
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
'Title'							=> 'WackoWiki installeerimine',
'Continue'						=> 'Jätka',
'Back'							=> 'Tagasi',
'Recommended'					=> 'soovitatav',
'InvalidAction'					=> 'Kehtetu tegevus',

/*
   Language Selection Page
*/
'lang'							=> 'Keele konfigureerimine',
'PleaseUpgradeToR6'				=> 'You aware to be running an old (pre %1) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to %2.',
'UpgradeFromWacko'				=> 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki %1 to %2. Järgmised mõned lehed viivad teid uuendusprotsessi läbi.',
'FreshInstall'					=> 'Tere tulemast WackoWiki-le, et kavatsete installida WackoWiki %1. Järgmised mõned lehed suunavad teid installiprotsessi.',
'PleaseBackup'					=> 'Enne, kui alustad versioonitäienduse sisseviimist, tee tagavarakoopia oma andmebaasist, konfiguratsioonidefailist ja kõikidest muudetud failidest. See võib sind säästa suurest peavalust!',
'LangDesc'						=> 'Vali keel, mida installeerimise ajal kasutada. Seesama keel saab olema ka vaikimisi keeleks sinu WackoWiki installatsioonil.',

/*
   System Requirements Page
*/
'version-check'					=> 'Nõuded süsteemile',
'PhpVersion'					=> 'PHP versioon',
'PhpDetected'					=> 'Detected PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'Andmebaas',
'PhpExtensions'					=> 'PHP laiendid',
'Permissions'					=> 'Õigused',
'ReadyToInstall'				=> 'Valmis installida?',
'Requirements'					=> 'Teie server peab vastama allpool loetletud nõuetele.',
'OK'							=> 'OK',
'Problem'						=> 'Probleem',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Teie PHP installil puuduvad märgitud PHP laiendused, mida WackoWiki nõuab. ',
'PcreWithoutUtf8'				=> 'PCRE ei ole kompileeritud UTF-8 toega.',
'NotePermissions'				=> 'Üritatakse konfiguratsiooni andmeid kirjutada faili nimega %1, mis asub sinu  WackoWiki kataloogis. Et see töötaks, pead sa olema kindel, et veebi serveril on kirjutamisõigused sellesse faili! Kui kirjutamisoigust ei ole, pead sa käsitsi seda faili muutma (installeerimise käigus üteldakse kuidas see käib).<br><br>Vaata seda, et saada täpsemaid juhiseid: <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'ErrorPermissions'				=> 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly. You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPhpVersion'			=> 'PHP versioon peab olema suurem kui <strong>' . PHP_MIN_VERSION . '</strong>, teie serveril näib olevat kasutusel varasem versioon. WackoWiki korrektseks toimimiseks peate uuema PHP-versiooni peale uuendama.',
'Ready'							=> 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'config-site'					=> 'Site konfiguratsioon',
'SiteName'						=> 'Sinu WikiNimi',
'SiteNameDesc'					=> 'Sinu WikiNimi.',
'SiteNameDefault'				=> 'MinuWiki',
'HomePage'						=> 'Koduleht',
'HomePageDesc'					=> 'Sinu WackoWiki kodulehe nimi. Peaks ka olema <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiNimi</a>.',
'HomePageDefault'				=> 'Koduleht',
'MultiLang'						=> 'Mitmekeelne režiim',
'MultiLangDesc'					=> 'Mitmekeelne režiim võimaldab ühe installatsiooni sees kasutada erinevatel lehtedele erinevaid keelte määranguid. Kui see režiim on lubatud, siis installeerimise käigus tekitatakse kõigi võimalike keelte jaoks, mis paketiga kaasas on, ühesugused menüü üksused erinevates keeltes.',
'AllowedLang'					=> 'Allowed Languages',
'AllowedLangDesc'				=> 'Soovitatav on valida ainult need keeled, mida soovite kasutada, vastasel juhul on valitud kõik keeled.',
'Admin'							=> 'Adminni nimi',
'AdminDesc'						=> 'Sisesta administraatori kasutajanimi. Peaks olema <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiNimi</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Kasutajanimi peab olema vahemikus %1 ja %2 sümbolit pikk. Võid kasutada vaid kirjamärke.',
'NameCamelCaseOnly'				=> 'Kasutajanimi peab olema vahemikus %1 ja %2 sümbolit pikk. and WikiName formatted.',
'Password'						=> 'Sisesta parool',
'PasswordDesc'					=> 'Vali administraatorile parool (vähemalt %1 tähemärki)',
'PasswordConfirm'				=> 'Korda parooli:',
'Mail'							=> 'Administraatori e-post',
'MailDesc'						=> 'Sisestage administraatori e-posti aadress.',
'Base'							=> 'Baas-URL',
'BaseDesc'						=> 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>https://example.com/</code></strong></li><li><strong><code>https://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Ülekirjutamise olek',
'RewriteDesc'					=> 'Ümberkirjutamise olek peab olema lubatud, kui sa kasutad WackoWiki\'t URL\'i ülekirjutamisega.',
'Enabled'						=> 'Lubama:',
'ErrorAdminEmail'				=> 'Pead sisestama korrektse adminni e-posti aadressi!',
'ErrorAdminPasswordMismatch'	=> 'Parool ei kõlba. Sisesta see uuesti!',
'ErrorAdminPasswordShort'		=> 'The admin Parool on liiga lühike, sisesta uuesti, the minimum length is %1 characters!',
'ModRewriteStatusUnknown'		=> 'The installer cannot verify that mod_rewrite is enabled, however this does not mean it is disabled',

/*
   Database Config Page
*/
'config-database'				=> 'Andmebaasi konfigureerimine',
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
'DbName'						=> 'andmebaas',
'DbNameDesc'					=> 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DbUser'						=> 'Kasutajanimi',
'DbUserDesc'					=> 'Name of the user used to connect to your database.',
'DbPassword'					=> 'Parool',
'DbPasswordDesc'				=> 'Password of the user used to connect to your database.',
'Prefix'						=> 'Tabeli prefiks',
'PrefixDesc'					=> 'Kõikide tabelite eesliides, mida WackoWiki kasutab. See voimaldab käitada mitut WackoWikit korraga,  kasutades ära ühte ja sama  MySQL andmebaasi, konfigureerides neid kasutama erinevaid tabelite prefikseid (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'No database driver has been detected, please enable either the mysqli or pdo_mysql extension in your php.ini file.',
'ErrorNoDbDriverSelected'		=> 'No database driver has been selected, please pick one from the list.',
'DeleteTables'					=> 'Olemasolevate tabelite kustutamine?',
'DeleteTablesDesc'				=> 'TÄHELEPANU! Kui te jätkate selle valikuga, kustutatakse kõik praegused wiki andmed teie andmebaasist. Seda ei saa tühistada, kui te ei taastata andmeid käsitsi varukoopiast.',
'ConfirmTableDeletion'			=> 'Kas olete kindel, et soovite kustutada kõik praegused wiki tabelid?',

/*
   Database Installation Page
*/
'install-database'				=> 'Andmebaasi paigaldamine',
'TestingConfiguration'			=> 'Testin konfiguratsiooni',
'TestConnectionString'			=> 'Testin database ühenduse seadistusi',
'TestDatabaseExists'			=> 'Checking if the database you specified exists',
'TestDatabaseVersion'			=> 'Checking database minimum version requirements',
'InstallTables'					=> 'Tabelite installimine',
'ErrorDbConnection'				=> 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDatabaseVersion'			=> 'The database version is %1 but requires at least %2.',
'To'							=> '->',
'AlterTable'					=> 'Altering %1 table',
'InsertRecord'					=> 'Inserting Record into %1 table',
'RenameTable'					=> 'Renaming %1 table',
'UpdateTable'					=> 'Updating %1 table',
'InstallDefaultData'			=> 'Adding Default Data',
'InstallPagesBegin'				=> 'Adding Default Pages',
'InstallPagesEnd'				=> 'Finished Adding Default Pages',
'InstallSystemAccount'			=> 'Lisan <code>System</code> kontot',
'InstallDeletedAccount'			=> 'Lisan <code>Deleted</code> kontot',
'InstallAdmin'					=> 'Lisan adminni kontot',
'InstallAdminSetting'			=> 'Lisan adminni kontot',
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
'CreatingTable'					=> 'Loon %1 tabelit',
'ErrorAlreadyExists'			=> 'The %1 already exists',
'ErrorCreatingTable'			=> 'Error creating %1 table, does it already exist?',
'DeletingTables'				=> 'Tabelite kustutamine',
'DeletingTablesEnd'				=> 'Finished Deleting Tables',
'ErrorDeletingTable'			=> 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable'					=> 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config'					=> 'Konfigurifaili kirjutamine',
'FinalStep'						=> 'Viimane samm',
'Writing'						=> 'Kirjutan konfiguratsioonifaili',
'RemovingWritePrivilege'		=> 'Removing Write Privilege',
'InstallationComplete'			=> 'Paigaldamine on lõppenud',
'ThatsAll'						=> 'See on kõik! Nüüd saate <a href="%1">vaadata oma WackoWiki saiti</a>.',
'SecurityConsiderations'		=> 'Security Considerations',
'SecurityRisk'					=> 'Soovitan sul eemaldada kirjutamisõigus %1 failile. Kirjutamisõiguse allesjätmine on riskantne turvalisuse seisukohast!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges'			=> 'Konfiguratsiooni faili %1 ei ole võimalik kirjutada. Sa pead andma oma veebi serverile ajutiselt kirjutamisõiguse kas oma WackoWiki kataloogile, või siis tühjale failile nimega %1<br>%2 ara unusta hiljem kirjutamisõigust eemaldada, näiteks nii: %3.<br>Kuid kui sa mingil põhjusel ei saa seda teha, siis pead sa allpool oleva teksti kopeerima uude faili ja siis salvestama ning uploadima selle nimega %1 WackoWiki kataloogi. Kui sa oled selle ära teinud, siis peaks su WackoWiki leht töötama. Kui ei tööta, siis mine aadressile <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep'						=> 'Järgmisena üritatakse kirjutada täiendatud konfiguratsioonifaili, %1. Palun veendu, et veebi serveril oleks faili kirjutamise õigused, vastasel korral pead sa seda käsitsi tegema. Uuesti, vaata täpsema info saamiseks siia: <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Dokumentatsioon/Installeerimine</a>.',
'WrittenAt'						=> 'kirjutan ',
'DontChange'					=> 'ära muuda käsitsi wacko_version versiooni!',
'ConfigDescription'				=> 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Proovi uuesti',

];
