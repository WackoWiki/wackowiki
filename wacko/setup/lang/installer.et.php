<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'windows-1257',
'LangISO' => 'et',
'LangName' => 'Estonian',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// site name
	'site_name'			=> 'MyWikiSite',

	// pages
	'category_page'		=> 'Category',
	'groups_page'		=> 'Groups',
	'users_page'		=> 'Users',

	#'help_page'			=> 'Help',
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
'Title' => 'WackoWiki installeerimine',
'Continue' => 'Jätka',
'Back' => 'Back',
'Recommended' => 'soovitatav',
'InvalidAction' => 'Invalid action',

/*
   Language Selection Page
*/
'lang' => 'Keele konfigureerimine',
'PleaseUpgradeToR5' => 'You aware to be running an old (pre 5.0.0) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to <code class="version">5.0.x</code>.',
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <code class="version">%1</code> to <code class="version">%2</code>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <code class="version">%1</code>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Enne, kui alustad versioonitäienduse sisseviimist, tee tagavarakoopia oma andmebaasist, konfiguratsioonidefailist ja kõikidest muudetud failidest. See võib sind säästa suurest peavalust!',
'LangDesc' => 'Vali keel, mida installeerimise ajal kasutada. Seesama keel saab olema ka vaikimisi keeleks sinu WackoWiki installatsioonil.',

/*
   System Requirements Page
*/
'version-check' => 'System Requirements',
'PHPVersion' => 'PHP Version',
'PHPDetected' => 'Detected PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Extension (mod_rewrite) Installed?',
'Database' => 'Database',
'PHPExtensions' => 'PHP Extensions',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Ready to Install?',
'Requirements' => 'Your server must meet the requirements listed below.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePHPExtensions' => '',
'ErrorPHPExtensions' => 'Your PHP installation appears to be missing the noted PHP extensions which are required by WackoWiki.',
'NotePermissions' => 'Üritatakse konfiguratsiooni andmeid kirjutada faili nimega %1, mis asub sinu  WackoWiki kataloogis. Et see töötaks, pead sa olema kindel, et veebi serveril on kirjutamisõigused sellesse faili! Kui kirjutamisoigust ei ole, pead sa käsitsi seda faili muutma (installeerimise käigus üteldakse kuidas see käib).<br><br>Vaata seda, et saada täpsemaid juhiseid: <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPHPVersion' => 'The PHP Version must be greater than <strong>' . PHP_MIN_VERSION . '</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'site-config' => 'Site konfiguratsioon',
'SiteName' => 'Sinu WikiNimi',
'SiteNameDesc' => 'Sinu WikiNimi.',
'HomePage' => 'KoduLeht',
'HomePageDesc' => 'Sinu WackoWiki kodulehe nimi. Peaks ka olema <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiNimi</a>.',
'HomePageDefault' => 'KoduLeht',
'MultiLang' => 'Mitmekeelne reþiim',
'MultiLangDesc' => 'Mitmekeelne reþiim võimaldab ühe installatsiooni sees kasutada erinevatel lehtedele erinevaid keelte määranguid. Kui see reþiim on lubatud, siis installeerimise käigus tekitatakse kõigi võimalike keelte jaoks, mis paketiga kaasas on, ühesugused lehed erinevates keeltes.',
'AllowedLang' => 'Allowed Languages',
'AllowedLangDesc' => 'It is recomended to select only the set of languages you want to use, other wise all languages are selected.',
'Admin' => 'Adminni nimi',
'AdminDesc' => 'Sisesta administraatori kasutajanimi. Peaks olema <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiNimi</a> (e.g. <code>WikiAdmin</code>).',
'Password' => 'Sisesta parool',
'PasswordDesc' => 'Vali administraatorile parool (vähemalt %1 tähemärki)',
'Password2' => 'Korda parooli:',
'Mail' => 'Administraatori e-post',
'MailDesc' => 'Enter the admins email address.',
'Base' => 'Baas-URL',
'BaseDesc' => 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => 'Ülekirjutamise olek',
'RewriteDesc' => 'Ümberkirjutamise olek peab olema lubatud, kui sa kasutad WackoWiki\'t URL\'i ülekirjutamisega.',
'Enabled' => 'Lubama:',
'ErrorAdminEmail' => 'Pead sisestama korrektse adminni e-posti aadressi!',
'ErrorAdminPasswordMismatch' => 'Parool ei kõlba. Sisesta see uuesti!',
'ErrorAdminPasswordShort' => 'The admin Parool on liiga lühike, sisesta uuesti, the minimum length is 9 characters!',
'WarningRewriteMode' => 'ATTENTION!\nYour base URL and rewrite-mode settings looks suspicious. Usually there is no ? mark in the base URL if rewrite-mode is set - but in your case there is one.\n\nTo continue with these settings click OK.\nTo return to the form and change your settings click CANCEL.\n\nIf you are about to proceed with these settings, please note that they COULD cause problems with your WackoWiki installation.',
'ModRewriteStatusUnknown' => 'The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled',

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
'database-config' => 'Andmebaasi konfigureerimine',
'DBDriver' => 'Driver',
'DBDriverDesc' => 'The database driver you want to use. You must choose a legacy driver if you do not have <a href="http://de2.php.net/pdo" target="_blank">PDO</a> installed.',
'DBCharset' => 'Charset',
'DBCharsetDesc' => 'The database charset you want to use.',
'DBEngine' => 'Engine',
'DBEngineDesc' => 'The database engine you want to use. You must choose MyISAM engine if you do not have at least MariaDB 10 or MySql 5.6 (or greater) and InnoDB support available.',
'DBHost' => 'Host',
'DBHostDesc' => 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DBPort' => 'Port (Optional)',
'DBPortDesc' => 'The port number your database server is accessable through, leave it blank to use the default port number.',
'DB' => 'andmebaas',
'DBDesc' => 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DBUserDesc' => 'Name of the user used to connect to your database.',
'DBUser' => 'kasutajanimi',
'DBPasswordDesc' => 'Password of the user used to connect to your database.',
'DBPassword' => 'parool',
'PrefixDesc' => 'Kõikide tabelite eesliides, mida WackoWiki kasutab. See voimaldab käitada mitut WackoWikit korraga,  kasutades ära ühte ja sama  MySQL andmebaasi, konfigureerides neid kasutama erinevaid tabelite prefikseid (e.g. wacko_).',
'Prefix' => 'Tabeli prefiks',
'ErrorNoDbDriverDetected' => 'No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.',
'ErrorNoDbDriverSelected' => 'No database driver has been selected, please pick one from the list.',
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'database-install' => 'Database Installation',
'TestingConfiguration' => 'Testin konfiguratsiooni',
'TestConnectionString' => 'Testin database ühenduse seadistusi',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'InstallingTables' => 'Installing Tables',
'ErrorDBConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDBExists' => 'Andmebaasi, mida sa konfigureerisid, ei leita. See peab olemas olema, kui sa tahad WackoWikit installeerida voi sellesse täiendusi sisse viia!',
'To' => '->',
'AlterTable' => 'Altering <code>%1</code> Table',
'RenameTable' => 'Renaming <code>%1</code> Table',
'UpdateTable' => 'Updating <code>%1</code> Table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Adding System User',
'InstallingAdmin' => 'Lisan adminni kontot',
'InstallingAdminSetting' => 'Lisan adminni kontot',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Adding Logo Image',
'InstallingConfigValues' => 'Adding Config Values',
'ErrorInsertingPage' => 'Error inserting <code>%1</code> page',
'ErrorInsertingPageReadPermission' => 'Error setting read permission for <code>%1</code> page',
'ErrorInsertingPageWritePermission' => 'Error setting write permission for <code>%1</code> page',
'ErrorInsertingPageCommentPermission' => 'Error setting comment permissions for <code>%1</code> page',
'ErrorInsertingPageCreatePermission' => 'Error setting create permissions for <code>%1</code> page',
'ErrorInsertingPageUploadPermission' => 'Error setting upload permissions for <code>%1</code> page',
'ErrorInsertingDefaultMenuItem' => 'Error setting page <code>%1</code> as default menu item',
'ErrorPageAlreadyExists' => 'The <code>%1</code> page already exists',
'ErrorAlteringTable' => 'Error altering <code>%1</code> table',
'ErrorRenamingTable' => 'Error renaming <code>%1</code> table',
'ErrorUpdatingTable' => 'Error updating <code>%1</code> table',
'CreatingTable' => 'Loon <code>%1</code> tabelit',
'ErrorAlreadyExists' => 'The <code>%1</code> already exists',
'ErrorCreatingTable' => 'Error creating <code>%1</code> table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Paigutan andmed ümber kontroll-tabelisse',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting <code>%1</code> table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting <code>%1</code> table',

/*
   Write Config Page
*/
'write-config' => 'Write Config File',
'FinalStep' => 'Final Step',
'Writing' => 'Kirjutan konfiguratsioonifaili',
'RemovingWritePrivilege' => 'Removing Write Privilege',
'InstallationComplete' => 'Installation Complete',
'ThatsAll' => 'Ja ongi kõik! Nüüd võid sa <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations' => 'Security Considerations',
'SecurityRisk' => 'Soovitan sul eemaldada kirjutamisõigus %1 failile. Kirjutamisõiguse allesjätmine on riskantne turvalisuse seisukohast!',
'RemoveSetupDirectory' => 'You should delete the <code>setup/</code> directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'Konfiguratsiooni faili %1 ei ole võimalik kirjutada. Sa pead andma oma veebi serverile ajutiselt kirjutamisõiguse kas oma WackoWiki kataloogile, või siis tühjale failile nimega %1<br>%2 ara unusta hiljem kirjutamisõigust eemaldada, näiteks nii: %3.<br>Kuid kui sa mingil põhjusel ei saa seda teha, siis pead sa allpool oleva teksti kopeerima uude faili ja siis salvestama ning uploadima selle nimega %1 WackoWiki kataloogi. Kui sa oled selle ära teinud, siis peaks su WackoWiki leht töötama. Kui ei tööta, siis mine aadressile <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'Järgmisena üritatakse kirjutada täiendatud konfiguratsioonifaili, %1. Palun veendu, et veebi serveril oleks faili kirjutamise õigused, vastasel korral pead sa seda käsitsi tegema. Uuesti, vaata täpsema info saamiseks siia: <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Dokumentatsioon/Installeerimine</a>.',
'WrittenAt' => 'kirjutan ',
'DontChange' => 'ära muuda käsitsi wacko_version versiooni!',
'ConfigDescription' => 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain' => 'Proovi uuesti',

];
?>