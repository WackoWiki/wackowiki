<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'utf-8',
'LangISO' => 'nl',
'LangName' => 'Dutch',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages
	'category_page'		=> 'Category',
	'groups_page'		=> 'Groups',
	'users_page'		=> 'Users',

	'search_page'		=> 'Zoeken',
	'login_page'		=> 'Inloggen',
	'account_page'		=> 'Instellingen',
	'registration_page'	=> 'Registratie',
	'password_page'		=> 'Paswoord',

	'changes_page'		=> 'LaatsteWijzigingen',
	'comments_page'		=> 'LaatsteOpmerkingen',
	'index_page'		=> 'PaginaIndex',

	'random_page'		=> 'WillekeurigePagina',
	#'help_page'			=> 'Hulp',
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
'Title' => 'WackoWiki Installatie',
'Continue' => 'Verder gaan',
'Back' => 'Terug',
'Recommended' => 'aanbevolen',
'InvalidAction' => 'Ongeldige actie',

/*
   Language Selection Page
*/
'lang' => 'Taal Configuratie',
'PleaseUpgradeToR5' => 'You aware to be running an old (pre %1) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to <code class="version">%2</code>.',
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <code class="version">%1</code> to <code class="version">%2</code>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <code class="version">%1</code>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Maak een kopie van de database, het configuratiebestand en alle gewijzigde bestanden (zoals thema\'s) voor u de upgrade start om gegevensverlies te voorkomen.',
'LangDesc' => 'Kies de taal voor het installatieproces. Dezelfde taal zal de standaard taal van uw WackoWiki installatie zijn.',

/*
   System Requirements Page
*/
'version-check' => 'Systeem Vereisten',
'PhpVersion' => 'PHP Version',
'PhpDetected' => 'Gedetecteerd PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Extension (mod_rewrite) Installed?',
'Database' => 'Database',
'PhpExtensions' => 'PHP Extensions',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Klaar om te installeren?',
'Requirements' => 'Your server must meet the requirements listed below.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePhpExtensions' => '',
'ErrorPhpExtensions' => 'Uw PHP-installatie lijkt de genoteerde PHP-extensies te missen die door WackoWiki zijn vereist.',
'PcreWithoutUtf8' => 'PCRE is not compiled with UTF-8 support.',
'NotePermissions' => 'Deze installer, probeert het configuratie instellingen naar het bestand %1, in uw WackoWiki directory. Om dit te doen dient u zeker te weten dat uw webserver schrijfrechten heeft op dat bestand! Als dat niet mogelijk is moet u het bestand handmatig wijzigen (het installatieprogramma zal u vertellen hoe).<br><br>See <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPhpVersion' => 'The PHP Version must be greater than <strong>' . PHP_MIN_VERSION . '</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'config-site' => 'Site Configuratie',
'SiteName' => 'Uw Wiki\'s naam',
'SiteNameDesc' => 'De naam van uw Wiki site.',
'HomePage' => 'Home pagina',
'HomePageDesc' => 'Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault' => 'HomePage',
'MultiLang' => 'Multi Language Mode',
'MultiLangDesc' => 'De meertalige modus maakt het mogelijk om paginas met verschillende taalinstellingen binnen één installatie te hebben. Als deze modus is ingeschakeld, zal het installatieprogramma de eerste menu-items voor alle talen die beschikbaar zijn in de distributie maken.',
'AllowedLang' => 'Allowed Languages',
'AllowedLangDesc' => 'Het wordt aanbevolen om alleen de set van talen te selecteren die u wilt gebruiken, anders worden alle talen geselecteerd.',
'Admin' => 'Beheerders naam',
'AdminDesc' => 'Geef de gebruikersnaam van de beheerder. Moet een <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> zijn (e.g. <code>WikiAdmin</code>).',
'Password' => 'Geef wachtwoord voor de beheerder',
'PasswordDesc' => 'Kies een wachtwoord voor de beheerder (%1 + tekens).',
'Password2' => 'Herhaal wachtwoord:',
'Mail' => 'Beheerders mailadres.',
'MailDesc' => 'Enter the beheerders mailadres.',
'Base' => 'Basis URL',
'BaseDesc' => 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => 'Herschrijf modus',
'RewriteDesc' => 'Herschrijven modus moet aan staan als u een WackoWiki met URL rewriting gebruikt.',
'Enabled' => 'Aan:',
'ErrorAdminEmail' => 'U moet een juist beheerders emailadres invullen!',
'ErrorAdminPasswordMismatch' => 'Wachtwoorden komen niet overeen, vul het wachtwoord opnieuw in!',
'ErrorAdminPasswordShort' => 'The admin Wachtwoord is te kort, vul het wachtwoord opnieuw in, the minimum length is %1 characters!',
'WarningRewriteMode' => 'LET OP!\nMogelijk zit er een fout in uw basis-URL en instellingen van de rewrite-modus. In een basis-URL hoort geen vraagteken te staan als de rewrite-modus is ingeschakeld. In uw instellingen is dat wel het geval.\n\nKlik OK om met deze instellingen door te gaan.\nKlik Annuleren om terug te gaan en de instellingen te veranderen.\n\nU kunt doorgaan met deze instellingen, maar het is mogelijk dat er dan problemen ontstaan.',
'ModRewriteStatusUnknown' => 'The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled',

'LanguageArray'	=> [
	'bg' => 'Bulgaars',
	'da' => 'Deens',
	'nl' => 'Nederlands',
	'el' => 'Grieks',
	'en' => 'Engels',
	'et' => 'Estlands',
	'fr' => 'Frans',
	'de' => 'Duits',
	'hu' => 'Hongaars',
	'it' => 'Italiaans',
	'pl' => 'Pools',
	'pt' => 'Portugees',
	'ru' => 'Russisch',
	'es' => 'Spaans',
],

/*
   Database Config Page
*/
'config-database' => 'Database Configuratie',
'DbDriver' => 'Driver',
'DbDriverDesc' => 'The database driver you want to use. You must choose a legacy driver if you do not have <a href="https://secure.php.net/pdo" target="_blank">PDO</a> installed.',
'DbCharset' => 'Charset',
'DbCharsetDesc' => 'De database karakterset die u wilt gebruiken.',
'DbEngine' => 'Engine',
'DbEngineDesc' => 'The database engine you want to use.',
'DbHost' => 'Host',
'DbHostDesc' => 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort' => 'Port (Optional)',
'DbPortDesc' => 'The port number your database server is accessible through, leave it blank to use the default port number.',
'Db' => 'Database Name',
'DbDesc' => 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DbUserDesc' => 'Name of the user used to connect to your database.',
'DbUser' => 'Gebruikersnaam',
'DbPasswordDesc' => 'Password of the user used to connect to your database.',
'DbPassword' => 'Wachtwoord',
'PrefixDesc' => 'Prefix voor alle tabellen gebruikt door WackoWiki. Dit geeft u de mogelijkheid meerdere WackoWiki installaties met dezelfde database te gebruiken (e.g. wacko_).',
'Prefix' => 'Tabel prefix',
'ErrorNoDbDriverDetected' => 'No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.',
'ErrorNoDbDriverSelected' => 'No database driver has been selected, please pick one from the list.',
'DeleteTables' => 'Bestaande tabellen verwijderen?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'install-database' => 'Database Installation',
'TestingConfiguration' => 'Testen Configuratie',
'TestConnectionString' => 'Testen database connectie instellingen',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'TestDatabaseVersion' => 'Checking database minimum version requirements',
'InstallingTables' => 'Installing Tables',
'ErrorDbConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDbExists' => 'De gekozen database is niet gevonden. De database moet al bestaan voordat u WackoWiki kunt installeren of upgraden!',
'ErrorDatabaseVersion' => 'The database version is %1 but requires at least %2.',
'To' => 'aan',
'AlterTable' => 'Altering %1 table',
'InsertRecord' => 'Inserting Record into %1 table',
'RenameTable' => 'Renaming %1 table',
'UpdateTable' => 'Updating %1 table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Toevoegen van de gebruiker <code>System</code>',
'InstallingDeletedAccount' => 'Toevoegen van de gebruiker <code>Deleted</code>',
'InstallingAdmin' => 'Toevoegen van de gebruiker beheerder',
'InstallingAdminSetting' => 'Toevoegen van de gebruiker beheerder',
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
'CreatingTable' => 'Maak %1 tabel aan',
'ErrorAlreadyExists' => 'The %1 already exists',
'ErrorCreatingTable' => 'Error creating %1 table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Verplaats de gegevens naar de revisie tabellen',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config' => 'Write Config File',
'FinalStep' => 'Final Step',
'Writing' => 'Wegschrijven configuratie bestand',
'RemovingWritePrivilege' => 'Removing Write Privilege',
'InstallationComplete' => 'Installatie is voltooid',
'ThatsAll' => 'Dat is alles! U kunt nu <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations' => 'Beveiligingsoverwegingen',
'SecurityRisk' => 'Echter, u wordt geadviseerd om schrijfrechten op %1 te verwijderen nu het is weggeschreven. Door de schrijfrechten te handhaven creert u een veiligheidsrisico!<br>i.e. %2',
'RemoveSetupDirectory' => 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'Het configuratie bestand %1 Geen schrijf rechten. U dient uw webserver tijdelijk schrijfrechten te geven op uw WackoWiki directory, of een lege bestand met de naam %1<br>%2<br>; vergeet niet om de schrijfrechten later te verwijderen, i.e. %3.<br>Als, voor welke reden dan ook,for any reason, you can\'t do this, you\'ll have to copy the text below into a new file and save/upload it as %1 into the WackoWiki directory. Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'In de volgende stap probeert het installatieprogramma het actuele configuratie bestand weg te schrijven, %1. Controleer of de web server schrijfrechten heeft op het bestand, anders moet u het handmatig aanpassen. Wederom, zie <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'WrittenAt' => 'geschreven op ',
'DontChange' => 'Wijzig de wacko_version niet handmatig!',
'ConfigDescription' => 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain' => 'Weer proberen',

];
