<?php
$lang = array(

/*
   Language Settings
*/
'Charset' => 'windows-1257',
'LangISO' => 'et',
'LangName' => 'Estonian',

/*
   Generic Page Text
*/
'Title' => 'WackoWiki installeerimine',
'Continue' => 'Jätka',
'Back' => 'Back',

/*
   Language Selection Page
*/
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <tt>%1</tt> to <tt>%2</tt>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <tt>%1</tt>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Enne, kui alustad versioonitäienduse sisseviimist, tee tagavarakoopia oma andmebaasist, konfiguratsioonidefailist ja kõikidest muudetud failidest. See võib sind säästa suurest peavalust!',
'Lang' => 'Keele konfigureerimine',
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
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Ready to Install?',
'Requirements' => 'Your server must meet the requirements listed below.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePermissions' => 'Üritatakse konfiguratsiooni andmeid kirjutada faili nimega  <tt>config.php</tt>, mis asub sinu  WackoWiki kataloogis. Et see töötaks, pead sa olema kindel, et veebi serveril on kirjutamisõigused sellesse faili! Kui kirjutamisoigust ei ole, pead sa käsitsi seda faili muutma (installeerimise käigus üteldakse kuidas see käib).<br /><br />Vaata seda, et saada täpsemaid juhiseid: <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPHPVersion' => 'The PHP Version must be greater than <strong>5.2.0</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'site-config' => 'Site konfiguratsioon',
'Name' => 'Sinu WikiNimi',
'NameDesc' => 'Sinu WikiNimi. Tavaliselt see näeb valja NaguMidagiSellist või EesnimiPerekonnanimi. <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'Home' => 'KoduLeht',
'HomeDesc' => 'Sinu WackoWiki kodulehe nimi. Peaks ka olema <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiNimi</a>.',
'HomeDefault' => 'KoduLeht',
'MultiLang' => 'Mitmekeelne reþiim',
'MultiLangDesc' => 'Mitmekeelne reþiim võimaldab ühe installatsiooni sees kasutada erinevatel lehtedele erinevaid keelte määranguid. Kui see reþiim on lubatud, siis installeerimise käigus tekitatakse kõigi võimalike keelte jaoks, mis paketiga kaasas on, ühesugused lehed erinevates keeltes.',
'Admin' => 'Adminni nimi',
'AdminDesc' => 'Sisesta administraatori kasutajanimi. Peaks olema <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiNimi</a> (e.g. WikiAdmin).',
'Password' => 'Sisesta parool',
'PasswordDesc' => 'Vali administraatorile parool (vähemalt 8 tähemärki)',
'Password2' => 'Korda parooli:',
'Mail' => 'Administraatori e-post',
'MailDesc' => 'Enter the admins email address.',
'Base' => 'Baas-URL',
'BaseDesc' => 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><b><i>http://wackowiki.org/</i></b></li><li><b><i>http://wackowiki.org/wiki/</i></b></li></ul>',
'Rewrite' => 'Ülekirjutamise olek',
'RewriteDesc' => 'Ümberkirjutamise olek peab olema lubatud, kui sa kasutad WackoWiki\'t URL\'i ülekirjutamisega.',
'Enabled' => 'Lubama:',
'ErrorAdminName' => 'Sa peaksid valima korrektse WikiNime administraatori nimeks!',
'ErrorAdminEmail' => 'Pead sisestama korrektse adminni e-posti aadressi!',
'ErrorAdminPasswordMismatch' => 'Parool ei kõlba. Sisesta see uuesti!',
'ErrorAdminPasswordShort' => 'The admin Parool on liiga lühike, sisesta uuesti, the minimum length is 8 characters!',
'WarningRewriteMode' => 'ATTENTION!\nYour base URL and rewrite-mode settings looks suspicious. Usually there is no ? mark in the base URL if rewrite-mode is set - but in your case there is one.\n\nTo continue with these settings click OK.\nTo return to the form and change your settings click CANCEL.\n\nIf you are about to proceed with these settings, please note that they COULD cause problems with your WackoWiki installation.',
'ModRewriteStatusUnknown' => 'The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled',

/*
   Database Config Page
*/
'database-config' => 'Andmebaasi konfigureerimine',
'DBDriverDesc' => 'The database driver you want to use.  You must choose a legacy driver if you do not have PHP5.1 (or greater) and <a href="http://de2.php.net/pdo" target="_blank">PDO</a> installed.',
'DBDriver' => 'Driver',
'DBHost' => 'Host',
'DBHostDesc' => 'The host your database server is running on. Usually "localhost" (ie, the same machine your WackoWiki site is on).',
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
'AlterTable' => 'Altering <tt>%1</tt> Table',
'RenameTable' => 'Renaming <tt>%1</tt> Table',
'UpdateTable' => 'Updating <tt>%1</tt> Table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Adding System User',
'InstallingAdmin' => 'Lisan adminni kontot',
'InstallingAdminSetting' => 'Lisan adminni kontot',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingRegisteredGroup' => 'Adding Registered Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Adding Logo Image',
'InstallingConfigValues' => 'Adding Config Values',
'ErrorInsertingPage' => 'Error inserting <tt>%1</tt> page',
'ErrorInsertingPageReadPermission' => 'Error setting read permission for <tt>%1</tt> page',
'ErrorInsertingPageWritePermission' => 'Error setting write permission for <tt>%1</tt> page',
'ErrorInsertingPageCommentPermission' => 'Error setting comment permissions for <tt>%1</tt> page',
'ErrorInsertingPageCreatePermission' => 'Error setting create permissions for <tt>%1</tt> page',
'ErrorInsertingPageUploadPermission' => 'Error setting upload permissions for <tt>%1</tt> page',
'ErrorInsertingPageCreatePermission' => 'Error setting create permissions for <tt>%1</tt> page',
'ErrorInsertingPageUploadPermission' => 'Error setting upload permissions for <tt>%1</tt> page',
'ErrorInsertingDefaultBookmark' => 'Error setting page <tt>%1</tt> as default bookmark',
'ErrorPageAlreadyExists' => 'The <tt>%1</tt> page already exists',
'ErrorAlteringTable' => 'Error altering <tt>%1</tt> table',
'ErrorRenamingTable' => 'Error renaming <tt>%1</tt> table',
'ErrorUpdatingTable' => 'Error updating <tt>%1</tt> table',
'CreatingTable' => 'Loon <tt>%1</tt> tabelit',
'ErrorAlreadyExists' => 'The <tt>%1</tt> already exists',
'ErrorCreatingTable' => 'Error creating <tt>%1</tt> table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Paigutan andmed ümber kontroll-tabelisse',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting <tt>%1</tt> table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting <tt>%1</tt> table',

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
'SecurityRisk' => 'Soovitan sul eemaldada kirjutamisõigus  <tt>config.php</tt> failile. Kirjutamisõiguse allesjätmine on riskantne turvalisuse seisukohast!',
'RemoveSetupDirectory' => 'You should delete the "setup" directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'Konfiguratsiooni faili <tt>%1</tt> ei ole võimalik kirjutada. Sa pead andma oma veebi serverile ajutiselt kirjutamisõiguse kas oma WackoWiki kataloogile, või siis tühjale failile nimega  <tt>config.php</tt> (<tt>touch config.php; chmod 666 config.php;</tt> ara unusta hiljem kirjutamisõigust eemaldada, näiteks nii: <tt>chmod 644 config.php</tt>). Kuid kui sa mingil põhjusel ei saa seda teha, siis pead sa allpool oleva teksti kopeerima uude faili ja siis salvestama ning uploadima selle nimega <tt>config.php</tt> WackoWiki kataloogi. Kui sa oled selle ära teinud, siis peaks su WackoWiki leht töötama. Kui ei tööta, siis mine aadressile <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'Järgmisena üritatakse kirjutada täiendatud konfiguratsioonifaili, <tt>config.php</tt>. Palun veendu, et veebi serveril oleks faili kirjutamise õigused, vastasel korral pead sa seda käsitsi tegema. Uuesti, vaata täpsema info saamiseks siia: <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Dokumentatsioon/Installeerimine</a>.',
'WrittenAt' => 'kirjutan ',
'DontChange' => 'ära muuda käsitsi wacko_version versiooni!',
'ConfigDescription' => 'detailed description http://wackowiki.org/Doc/English/Configuration',
'TryAgain' => 'Proovi uuesti',
'RemoveWakkaConfigFile' => 'WackoWiki uses a newer config file than your previous WakkaWiki installation.  The old file could not be automatically removed by the system and so it is recommended that you manually delete the file <tt>wakka.config.php</tt>.',
'DeletingWakkaConfigFile' => 'Deleting Obsolete Wakka Configuration File',

);?>