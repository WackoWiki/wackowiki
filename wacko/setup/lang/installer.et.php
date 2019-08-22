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
	// pages
	'category_page'		=> 'Kategooria',
	'groups_page'		=> 'Grupid',
	'users_page'		=> 'Kasutajad',

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
'Continue' => 'J�tka',
'Back' => 'Tagasi',
'Recommended' => 'soovitatav',
'InvalidAction' => 'Invalid action',

/*
   Language Selection Page
*/
'lang' => 'Keele konfigureerimine',
'PleaseUpgradeToR5' => 'You aware to be running an old (pre 5.0.0) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to <code class="version">5.0.x</code>.',
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <code class="version">%1</code> to <code class="version">%2</code>. J�rgmised m�ned lehed viivad teid uuendusprotsessi l�bi.',
'FreshInstall' => 'Tere tulemast WackoWiki-le, et kavatsete installida WackoWiki <code class="version">%1</code>. J�rgmised m�ned lehed suunavad teid installiprotsessi.',
'PleaseBackup' => 'Enne, kui alustad versioonit�ienduse sisseviimist, tee tagavarakoopia oma andmebaasist, konfiguratsioonidefailist ja k�ikidest muudetud failidest. See v�ib sind s��sta suurest peavalust!',
'LangDesc' => 'Vali keel, mida installeerimise ajal kasutada. Seesama keel saab olema ka vaikimisi keeleks sinu WackoWiki installatsioonil.',

/*
   System Requirements Page
*/
'version-check' => 'N�uded s�steemile',
'PHPVersion' => 'PHP Version',
'PHPDetected' => 'Detected PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Extension (mod_rewrite) Installed?',
'Database' => 'Database',
'PHPExtensions' => 'PHP Extensions',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Valmis installida?',
'Requirements' => 'Your server must meet the requirements listed below.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePHPExtensions' => '',
'ErrorPHPExtensions' => 'Your PHP installation appears to be missing the noted PHP extensions which are required by WackoWiki.',
'PCREwithoutUTF8' => 'PCRE is not compiled with UTF-8 support.',
'NotePermissions' => '�ritatakse konfiguratsiooni andmeid kirjutada faili nimega %1, mis asub sinu  WackoWiki kataloogis. Et see t��taks, pead sa olema kindel, et veebi serveril on kirjutamis�igused sellesse faili! Kui kirjutamisoigust ei ole, pead sa k�sitsi seda faili muutma (installeerimise k�igus �teldakse kuidas see k�ib).<br><br>Vaata seda, et saada t�psemaid juhiseid: <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly. You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPHPVersion' => 'The PHP Version must be greater than <strong>' . PHP_MIN_VERSION . '</strong>, your server appears to be running an earlier version. You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
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
'MultiLang' => 'Mitmekeelne re�iim',
'MultiLangDesc' => 'Mitmekeelne re�iim v�imaldab �he installatsiooni sees kasutada erinevatel lehtedele erinevaid keelte m��ranguid. Kui see re�iim on lubatud, siis installeerimise k�igus tekitatakse k�igi v�imalike keelte jaoks, mis paketiga kaasas on, �hesugused lehed erinevates keeltes.',
'AllowedLang' => 'Allowed Languages',
'AllowedLangDesc' => 'It is recomended to select only the set of languages you want to use, other wise all languages are selected.',
'Admin' => 'Adminni nimi',
'AdminDesc' => 'Sisesta administraatori kasutajanimi. Peaks olema <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiNimi</a> (e.g. <code>WikiAdmin</code>).',
'Password' => 'Sisesta parool',
'PasswordDesc' => 'Vali administraatorile parool (v�hemalt %1 t�hem�rki)',
'Password2' => 'Korda parooli:',
'Mail' => 'Administraatori e-post',
'MailDesc' => 'Sisestage administraatori e-posti aadress.',
'Base' => 'Baas-URL',
'BaseDesc' => 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => '�lekirjutamise olek',
'RewriteDesc' => '�mberkirjutamise olek peab olema lubatud, kui sa kasutad WackoWiki\'t URL\'i �lekirjutamisega.',
'Enabled' => 'Lubama:',
'ErrorAdminEmail' => 'Pead sisestama korrektse adminni e-posti aadressi!',
'ErrorAdminPasswordMismatch' => 'Parool ei k�lba. Sisesta see uuesti!',
'ErrorAdminPasswordShort' => 'The admin Parool on liiga l�hike, sisesta uuesti, the minimum length is %1 characters!',
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
'DBDriverDesc' => 'The database driver you want to use. You must choose a legacy driver if you do not have <a href="https://secure.php.net/pdo" target="_blank">PDO</a> installed.',
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
'PrefixDesc' => 'K�ikide tabelite eesliides, mida WackoWiki kasutab. See voimaldab k�itada mitut WackoWikit korraga,  kasutades �ra �hte ja sama  MySQL andmebaasi, konfigureerides neid kasutama erinevaid tabelite prefikseid (e.g. wacko_).',
'Prefix' => 'Tabeli prefiks',
'ErrorNoDbDriverDetected' => 'No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.',
'ErrorNoDbDriverSelected' => 'No database driver has been selected, please pick one from the list.',
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'database-install' => 'Andmebaasi paigaldamine',
'TestingConfiguration' => 'Testin konfiguratsiooni',
'TestConnectionString' => 'Testin database �henduse seadistusi',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'InstallingTables' => 'Tabelite installimine',
'ErrorDBConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDBExists' => 'Andmebaasi, mida sa konfigureerisid, ei leita. See peab olemas olema, kui sa tahad WackoWikit installeerida voi sellesse t�iendusi sisse viia!',
'To' => '->',
'AlterTable' => 'Altering %1 table',
'InsertRecord' => 'Inserting Record into %1 table',
'RenameTable' => 'Renaming %1 table',
'UpdateTable' => 'Updating %1 table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Lisan <code>System</code> kontot',
'InstallingDeletedAccount' => 'Lisan <code>Deleted</code> kontot',
'InstallingAdmin' => 'Lisan adminni kontot',
'InstallingAdminSetting' => 'Lisan adminni kontot',
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
'CreatingTable' => 'Loon %1 tabelit',
'ErrorAlreadyExists' => 'The %1 already exists',
'ErrorCreatingTable' => 'Error creating %1 table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Paigutan andmed �mber kontroll-tabelisse',
'DeletingTables' => 'Tabelite kustutamine',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config' => 'Konfigurifaili kirjutamine',
'FinalStep' => 'Viimane samm',
'Writing' => 'Kirjutan konfiguratsioonifaili',
'RemovingWritePrivilege' => 'Removing Write Privilege',
'InstallationComplete' => 'Paigaldamine on l�ppenud',
'ThatsAll' => 'Ja ongi k�ik! N��d v�id sa <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations' => 'Security Considerations',
'SecurityRisk' => 'Soovitan sul eemaldada kirjutamis�igus %1 failile. Kirjutamis�iguse allesj�tmine on riskantne turvalisuse seisukohast!',
'RemoveSetupDirectory' => 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'Konfiguratsiooni faili %1 ei ole v�imalik kirjutada. Sa pead andma oma veebi serverile ajutiselt kirjutamis�iguse kas oma WackoWiki kataloogile, v�i siis t�hjale failile nimega %1<br>%2 ara unusta hiljem kirjutamis�igust eemaldada, n�iteks nii: %3.<br>Kuid kui sa mingil p�hjusel ei saa seda teha, siis pead sa allpool oleva teksti kopeerima uude faili ja siis salvestama ning uploadima selle nimega %1 WackoWiki kataloogi. Kui sa oled selle �ra teinud, siis peaks su WackoWiki leht t��tama. Kui ei t��ta, siis mine aadressile <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'J�rgmisena �ritatakse kirjutada t�iendatud konfiguratsioonifaili, %1. Palun veendu, et veebi serveril oleks faili kirjutamise �igused, vastasel korral pead sa seda k�sitsi tegema. Uuesti, vaata t�psema info saamiseks siia: <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Dokumentatsioon/Installeerimine</a>.',
'WrittenAt' => 'kirjutan ',
'DontChange' => '�ra muuda k�sitsi wacko_version versiooni!',
'ConfigDescription' => 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain' => 'Proovi uuesti',

];
?>