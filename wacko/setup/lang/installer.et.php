<?php
$lang = array(

/*
   Language Settings
*/
"Charset" => "windows-1257",
"LangISO" => "et",
"LangName" => "Estonian",

/*
   Generic Page Text
*/
"Title" => "WackoWiki installeerimine",
"Continue" => "J�tka",
"Back" => "Back",

/*
   Language Selection Page
*/
"Lang" => "Keele konfigureerimine",
"LangDesc" => "Vali keel, mida installeerimise ajal kasutada. Seesama keel saab olema ka vaikimisi keeleks sinu WackoWiki installatsioonil.",

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
"Installed" => "Sinu installeeritud WackoWiki nimetab ennast kui ",
"ToUpgrade" => "Sa viisid sisse WackoWikile <strong>t��tet�ienduse</strong> ",
"PleaseBackup" => "Enne, kui alustad versioonit�ienduse sisseviimist, tee tagavarakoopia oma andmebaasist, konfiguratsioonidefailist ja k�ikidest muudetud failidest. See v�ib sind s��sta suurest peavalust!",
"Fresh" => "Kuna ei leita �htegi olemasolevat WackoWiki konfiguratsiooni, siis t�en�oliselt on see uus WackoWiki installatsioon. Sa installeerid WackoWiki ",
"Requirements" => "Your server must meet the requirements listed below.",
"OK" => "OK",
"Problem" => "Problem",
"NotePermissions" => "�ritatakse konfiguratsiooni andmeid kirjutada faili nimega  <tt>wakka.config.php</tt>, mis asub sinu  WackoWiki kataloogis. Et see t��taks, pead sa olema kindel, et veebi serveril on kirjutamis�igused sellesse faili! Kui kirjutamisoigust ei ole, pead sa k�sitsi seda faili muutma (installeerimise k�igus �teldakse kuidas see k�ib).<br /><br />Vaata seda, et saada t�psemaid juhiseid: <a href=\"http://wackowiki.org/Archiv/DocEnglish/Installation\" target=\"_blank\">WackoWiki:DocEnglish/Installation</a>.",
"ErrorPermissions" => "It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.",
"ErrorMinPHPVersion" => "The PHP Version must be greater than <strong>4.3.3</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.",
"Ready" => "Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.",

/*
   Site Config Page
*/
"site-config" => "Site konfiguratsioon",
"Name" => "Sinu WikiNimi",
"NameDesc" => "Sinu WikiNimi. Tavaliselt see n�eb valja NaguMidagiSellist v�i EesnimiPerekonnanimi. <a href=\"http://wackowiki.org/Archiv/DocEnglish/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"Home" => "KoduLeht",
"HomeDesc" => "Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href=\"http://wackowiki.org/Archiv/DocEnglish/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"MultiLang" => "Mitmekeelne re�iim",
"MultiLangDesc" => "Mitmekeelne re�iim v�imaldab �he installatsiooni sees kasutada erinevatel lehtedele erinevaid keelte m��ranguid. Kui see re�iim on lubatud, siis installeerimise k�igus tekitatakse k�igi v�imalike keelte jaoks, mis paketiga kaasas on, �hesugused lehed erinevates keeltes.",
"Admin" => "Adminni nimi",
"AdminDesc" => "Sisesta administraatori kasutajanimi. Peaks olema <a href=\"http://wackowiki.org/Archiv/DocEnglish/WikiName\" title=\"View Help\" target=\"_blank\">WikiNimi</a>.",
"Password" => "Admin Password",
"PasswordDesc" => "Vali administraatorile parool (v�hemalt 5 t�hem�rki)",
"Password2" => "Korda parooli:",
"Mail" => "Admin E-post Address",
"MailDesc" => "Enter the admins email address.",
"Base" => "Baas-URL",
"BaseDesc" => "Your WackoWiki sites base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><b><i>http://www.wackowiki.org/</i></b></li><li><b><i>http://www.wackowiki.org/wiki/</i></b></li></ul><p class=\"no_top\">If you are not going to use mod_rewrite then the URL should end with \"?page=\" i.e.<ul><li><b><i>http://www.wackowiki.org/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/wiki/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/?page=</i></b></li><li><b><i>http://www.wackowiki.org?page=</i></b></li></ul>",
"Rewrite" => "�lekirjutamise olek",
"RewriteDesc" => "�mberkirjutamise olek peab olema lubatud, kui sa kasutad WackoWiki't URL'i �lekirjutamisega.",
"Enabled" => "Lubama:",
"ErrorAdminName" => "Sa peaksid valima korrektse WikiNime administraatori nimeks!",
"ErrorAdminEmail" => "Pead sisestama korrektse adminni e-posti aadressi!",
"ErrorAdminPasswordMismatch" => "Parool ei k�lba. Sisesta see uuesti!",
"ErrorAdminPasswordShort" => "The admin Parool on liiga l�hike, sisesta uuesti, the minimum length is 5 characters!",
"WarningRewriteMode" => "ATTENTION!\nYour base URL and rewrite-mode settings looks suspicious. Usually there is no ? mark in the base URL if rewrite-mode is set - but in your case there is one.\n\nTo continue with these settings click OK.\nTo return to the form and change your settings click CANCEL.\n\nIf you are about to proceed with these settings, please note that they COULD cause problems with your WackoWiki installation.",
"ModRewriteStatusUnknown" => "The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled",

/*
   Database Config Page
*/
"database-config" => "Andmebaasi konfigureerimine",
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
"PrefixDesc" => "K�ikide tabelite eesliides, mida WackoWiki kasutab. See voimaldab k�itada mitut WackoWikit korraga,  kasutades �ra �hte ja sama  MySQL andmebaasi, konfigureerides neid kasutama erinevaid tabelite prefikseid.",
"Prefix" => "Tabeli prefiks",
"ErrorNoDbDriverDetected" => "No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.",
"ErrorNoDbDriverSelected" => "No database driver has been selected, please pick one from the list.",

/*
   Database Installation Page
*/
"database-install" => "Database Installation",
"TestingConfiguration" => "Testin konfiguratsiooni",
"TestConnectionString" => "Testin database �henduse seadistusi",
"TestDatabaseExists" => "Checking if the database you specified exists",
"InstallingTables" => "Installing Tables",
"ErrorDBConnection" => "There was a problem with the database connection details you specified, please go back and check they are correct.",
"ErrorDBExists" => "Andmebaasi, mida sa konfigureerisid, ei leita. See peab olemas olema, kui sa tahad WackoWikit installeerida voi sellesse t�iendusi sisse viia!",
"To" => "->",
"AlterTable" => "Altering %1 Table",
"AlterUsersTable" => "Altering Users Table",
"InstallingDefaultData" => "Adding Default Data",
"InstallingPagesBegin" => "Adding Default Pages",
"InstallingPagesEnd" => "Finished Adding Default Pages",
"InstallingAdmin" => "Lisan adminni kontot",
"InstallingLogoImage" => "Adding Logo Image",
"ErrorInsertingPage" => "Error inserting %1 page",
"ErrorInsertingPageReadPermission" => "Error setting read permission for %1 page",
"ErrorInsertingPageWritePermission" => "Error setting write permission for %1 page",
"ErrorInsertingPageCommentPermission" => "Error setting comment permissions for %1 page",
"ErrorPageAlreadyExists" => "The %1 page already exists",
"ErrorAlteringTable" => "Error altering %1 table",
"CreatingTable" => "Loon %1 tabelit",
"ErrorAlreadyExists" => "The %1 already exists",
"ErrorCreatingTable" => "Error creating %1 table, does it already exist?",
"ErrorMovingRevisions" => "Error moving revision data",
"MovingRevisions" => "Paigutan andmed �mber kontroll-tabelisse",
"CleanupScript" => "If you'll use <a href=\"http://wackowiki.org/Archiv/DocEnglish/CleanupScript\" target=\"_blank\">WackoWiki:DocEnglish/CleanupScript</a>, you will speedup your Wacko.",

/*
   Write Config Page
*/
"write-config" => "Write Config File",
"Writing" => "Ootan konfiguratsiooni",
"Writing2" => "Kirjutan konfiguratsioonifaili",
"RemovingWritePrivilege" => "Removing Write Privilege",
"InstallationComplete" => "Ja ongi k�ik! N��d v�id sa <a href=\"%1\">view your WackoWiki site</a>.",
"SecurityConsiderations" => "Security Considerations",
"SecurityRisk" => "Soovitan sul eemaldada kirjutamis�igus  <tt>wakka.config.php</tt> failile. Kirjutamis�iguse allesj�tmine on riskantne turvalisuse seisukohast!",
"RemoveSetupDirectory" => "You should delete the \"setup\" directory now that the installation process has been completed.",
"ErrorGivePrivileges" => "Konfiguratsiooni faili %1 ei ole v�imalik kirjutada. Sa pead andma oma veebi serverile ajutiselt kirjutamis�iguse kas oma WackoWiki kataloogile, v�i siis t�hjale failile nimega  <tt>wakka.config.php</tt> (<tt>touch wakka.config.php; chmod 666 wakka.config.php;</tt> ara unusta hiljem kirjutamis�igust eemaldada, n�iteks nii: <tt>chmod 644 wakka.config.php</tt>). Kuid kui sa mingil p�hjusel ei saa seda teha, siis pead sa allpool oleva teksti kopeerima uude faili ja siis salvestama ning uploadima selle nimega <tt>wakka.config.php</tt> WackoWiki kataloogi. Kui sa oled selle �ra teinud, siis peaks su WackoWiki leht t��tama. Kui ei t��ta, siis mine aadressile <a href=\"http://wackowiki.org/Archiv/DocEnglish/Installation\">WackoWiki:DocEnglish/Installation</a>",
"NextStep" => "J�rgmisena �ritatakse kirjutada t�iendatud konfiguratsioonifaili, <tt>wakka.config.php</tt>. Palun veendu, et veebi serveril oleks faili kirjutamise �igused, vastasel korral pead sa seda k�sitsi tegema. Uuesti, vaata t�psema info saamiseks siia: <a href=\"http://wackowiki.org/Archiv/DocEnglish/Installation\" target=\"_blank\">WackoWiki:Dokumentatsioon/Installeerimine</a>.",
"WrittenAt" => "kirjutan ",
"DontChange" => "�ra muuda k�sitsi wakka_version versiooni!",
"TryAgain" => "Proovi uuesti",

// O L D
/*

"Looking for database..." => "Otsin andmebaasi...",
"pages alter" => "Ainult �ige pisut muudan lehtede tabelit...",
"useralter" => "Ainult �ige pisut muudan kasutajate tabelit...",
"Installing Stuff" => "Installeerin",
"Already exists?" => "Juba olemas?",
"Adding some pages..." => "Lisan m�ned lehed...",
"And table..." => "Ja %1 tabel (oota!)...",
"return" => "naasta oma WackoWiki lehele",
#"mysqlHostDesc" => "Masin kus sinu MySQL server asub. Enamasti \"localhost\" (ehk see sama kus asub ka sinu WackoWiki).",
#"mysqlHost" => "MySQL host",
#"dbDesc" => "MySQL andmebaas, mida WackoWiki peaks kasutama. See andmebaas peab eksisteerima, et j�tkata!",
#"db" => "MySQL andmebaas",
#"mysqlPasswDesc" => "MySQL'i kasutaja nimi ja parool, mida kasutatakse andmebaasiga kontakteerumisel.",
#"mysqlUser" => "MySQL kasutajanimi",
#"mysqlPassw" => "MySQL parool",
"homeDesc" => "Sinu WackoWiki kodulehe nimi. Peaks ka olema WikiNimi.",
"baseDesc" => "Sinu WackoWiki saidi baas-URL. Lehtede nimed liidetakse sellele, see peaks sisaldama \"?page=\" parameetrit, kui sul ei t��ta Apache serveris mod_rewrite moodulit.",
"pleaseConfigure" => "Palun konfigureeri oma WackoWiki sait, kasutades allpool olevat vormi.",
"AdminConf" => "Administraatori konto konfigureerimine",
"password" => "Sisesta parool",
"mailDesc" => "Administraatori e-post.",
"adding pages" => "Lisan m�ned lehed...",
"Doubles" => "Kui sa kasutad  <a href=\"http://wackowiki.org/DocEnglish/CleanupScript\" target=\"_blank\">WackoWiki:DocEnglish/CleanupScript</a>, siis sa kiirendad oma Wackot.",
"newinstall" => "Kuna see on v�rske installatsioon, siis �ritatakse aimata �iged vastused. Muuda neid ainult siis, kui sa oled kindel, et teed �igesti!",
*/

);?>