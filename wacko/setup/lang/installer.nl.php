<?php
$lang = array(

/*
   Language Settings
*/
'Charset' => 'iso-8859-1',
'LangISO' => 'nl',
'LangName' => 'Dutch',

/*
   Generic Page Text
*/
'Title' => 'WackoWiki Installatie',
'Continue' => 'Verder gaan',
'Back' => 'Back',

/*
   Language Selection Page
*/
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <tt>%1</tt> to <tt>%2</tt>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <tt>%1</tt>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Maak een kopie van de database, het configuratiebestand en alle gewijzigde bestanden (zoals thema\'s) voor u de upgrade start om gegevensverlies te voorkomen.',
'Lang' => 'Taal Configuratie',
'LangDesc' => 'Kies de taal voor het installatieproces. Dezelfde taal zal de standaard taal van uw WackoWiki installatie zijn.',

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
'NotePermissions' => 'Deze installer, probeert het configuratie instellingen naar het bestand <tt>config.php</tt>, in uw WackoWiki directory. Om dit te doen dient u zeker te weten dat uw webserver schrijfrechten heeft op dat bestand! Als dat niet mogelijk is moet u het bestand handmatig wijzigen (het installatieprogramma zal u vertellen hoe).<br /><br />See <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPHPVersion' => 'The PHP Version must be greater than <strong>5.2.0</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'site-config' => 'Site Configuratie',
'Name' => 'Uw WackoWiki\'s naam',
'NameDesc' => 'De naam van uw WackoWiki site. Dit is meestal een WikiName met de volgende syntax -> SomethingLikeThis. <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'Home' => 'Home pagina',
'HomeDesc' => 'Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomeDefault' => 'HomePage',
'MultiLang' => 'Multi Language Mode',
'MultiLangDesc' => 'Multilanguage mode allows to have pages with different language settings within single installation. If this mode is enabled, installer will create initial pages for all languages available in distribution.',
'Admin' => 'Beheerders naam',
'AdminDesc' => 'Geef de gebruikersnaam van de beheerder. Moet een <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> zijn (e.g. WikiAdmin).',
'Password' => 'Geef wachtwoord voor de beheerder',
'PasswordDesc' => 'Kies een wachtwoord voor de beheerder (8+ tekens).',
'Password2' => 'Herhaal wachtwoord:',
'Mail' => 'Beheerders mailadres.',
'MailDesc' => 'Enter the beheerders mailadres.',
'Base' => 'Basis URL',
'BaseDesc' => 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><b><i>http://wackowiki.org/</i></b></li><li><b><i>http://wackowiki.org/wiki/</i></b></li></ul>',
'Rewrite' => 'Herschrijf modus',
'RewriteDesc' => 'Herschrijven modus moet aan staan als u een WackoWiki met URL rewriting gebruikt.',
'Enabled' => 'Aan:',
'ErrorAdminName' => 'U moet een juiste WikiName invullen als gebruikersnaam voor de beheerder!',
'ErrorAdminEmail' => 'U moet een juist beheerders emailadres invullen!',
'ErrorAdminPasswordMismatch' => 'Wachtwoorden komen niet overeen, vul het wachtwoord opnieuw in!',
'ErrorAdminPasswordShort' => 'The admin Wachtwoord is te kort, vul het wachtwoord opnieuw in, the minimum length is 8 characters!',
'WarningRewriteMode' => 'LET OP!\nMogelijk zit er een fout in uw basis-URL en instellingen van de rewrite-modus. In een basis-URL hoort geen vraagteken te staan als de rewrite-modus is ingeschakeld. In uw instellingen is dat wel het geval.\n\nKlik OK om met deze instellingen door te gaan.\nKlik Annuleren om terug te gaan en de instellingen te veranderen.\n\nU kunt doorgaan met deze instellingen, maar het is mogelijk dat er dan problemen ontstaan.',
'ModRewriteStatusUnknown' => 'The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled',

/*
   Database Config Page
*/
'database-config' => 'Database Configuratie',
'DBDriverDesc' => 'The database driver you want to use.  You must choose a legacy driver if you do not have PHP5.1 (or greater) and <a href="http://de2.php.net/pdo" target="_blank">PDO</a> installed.',
'DBDriver' => 'Driver',
'DBHost' => 'Host',
'DBHostDesc' => 'The host your database server is running on. Usually "localhost" (ie, the same machine your WackoWiki site is on).',
'DBPort' => 'Port (Optional)',
'DBPortDesc' => 'The port number your database server is accessable through, leave it blank to use the default port number.',
'DB' => 'Database Name',
'DBDesc' => 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DBUserDesc' => 'Name of the user used to connect to your database.',
'DBUser' => 'gebruikersnaam',
'DBPasswordDesc' => 'Password of the user used to connect to your database.',
'DBPassword' => 'wachtwoord',
'PrefixDesc' => 'Prefix voor alle tabellen gebruikt door WackoWiki. Dit geeft u de mogelijkheid meerdere WackoWiki installaties met dezelfde database te gebruiken (e.g. wacko_).',
'Prefix' => 'Tabel prefix',
'ErrorNoDbDriverDetected' => 'No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.',
'ErrorNoDbDriverSelected' => 'No database driver has been selected, please pick one from the list.',
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'database-install' => 'Database Installation',
'TestingConfiguration' => 'Testen Configuratie',
'TestConnectionString' => 'Testen database connectie instellingen',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'InstallingTables' => 'Installing Tables',
'ErrorDBConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDBExists' => 'De gekozen database is niet gevonden. De database moet al bestaan voordat u WackoWiki kunt installeren of upgraden!',
'To' => 'aan',
'AlterTable' => 'Altering <tt>%1</tt> Table',
'RenameTable' => 'Renaming <tt>%1</tt> Table',
'UpdateTable' => 'Updating <tt>%1</tt> Table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Adding System User',
'InstallingAdmin' => 'Toevoegen van de gebruiker beheerder',
'InstallingAdminSetting' => 'Toevoegen van de gebruiker beheerder',
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
'ErrorInsertingDefaultBookmark' => 'Error setting page <tt>%1</tt> as default bookmark',
'ErrorPageAlreadyExists' => 'The <tt>%1</tt> page already exists',
'ErrorAlteringTable' => 'Error altering <tt>%1</tt> table',
'ErrorRenamingTable' => 'Error renaming <tt>%1</tt> table',
'ErrorUpdatingTable' => 'Error updating <tt>%1</tt> table',
'CreatingTable' => 'Maak <tt>%1</tt> tabel aan',
'ErrorAlreadyExists' => 'The <tt>%1</tt> already exists',
'ErrorCreatingTable' => 'Error creating <tt>%1</tt> table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Verplaats de gegevens naar de revisie tabellen',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting <tt>%1</tt> table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting <tt>%1</tt> table',

/*
   Write Config Page
*/
'write-config' => 'Write Config File',
'FinalStep' => 'Final Step',
'Writing' => 'Wegschrijven configuratie bestand',
'RemovingWritePrivilege' => 'Removing Write Privilege',
'InstallationComplete' => 'Installatie is voltooid',
'ThatsAll' => 'Dat is alles! U kunt nu <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations' => 'Security Considerations',
'SecurityRisk' => 'Echter, u wordt geadviseerd om schrijfrechten op <tt>config.php</tt> te verwijderen nu het is weggeschreven. Door de schrijfrechten te handhaven creert u een veiligheidsrisico!',
'RemoveSetupDirectory' => 'You should delete the "setup" directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'Het configuratie bestand <tt>%1</tt> Geen schrijf rechten. U dient uw webserver tijdelijk schrijfrechten te geven op uw WackoWiki directory, of een lege bestand met de naam <tt>config.php</tt> (<tt>touch config.php ; chmod 666 config.php</tt>; vergeet niet om de schrijfrechten later te verwijderen, ie <tt>chmod 644 config.php</tt>). Als, voor welke reden dan ook,for any reason, you can\'t do this, you\'ll have to copy the text below into a new file and save/upload it as <tt>config.php</tt> into the WackoWiki directory. Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'In de volgende stap probeert het installatieprogramma het actuele configuratie bestand weg te schrijven, <tt>config.php</tt>. Controleer of de web server schrijfrechten heeft op het bestand, anders moet u het handmatig aanpassen. Wederom, zie <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'WrittenAt' => 'geschreven op ',
'DontChange' => 'Wijzig de wacko_version niet handmatig!',
'ConfigDescription' => 'detailed description http://wackowiki.org/Doc/English/Configuration',
'TryAgain' => 'Weer proberen',
'RemoveWakkaConfigFile' => 'WackoWiki uses a newer config file than your previous WakkaWiki installation.  The old file could not be automatically removed by the system and so it is recommended that you manually delete the file <tt>wakka.config.php</tt>.',
'DeletingWakkaConfigFile' => 'Deleting Obsolete Wakka Configuration File',

);
?>