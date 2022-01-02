<?php
$lang = [

/*
   Language Settings
*/
'Charset'	=> 'utf-8',
'LangISO'	=> 'nl',
'LangName'	=> 'Dutch',
'LangDir'	=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Categorie',
	'groups_page'		=> 'Groepen',
	'users_page'		=> 'Gebruikers',

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
'Title'							=> 'WackoWiki Installatie',
'Continue'						=> 'Verder gaan',
'Back'							=> 'Terug',
'Recommended'					=> 'aanbevolen',
'InvalidAction'					=> 'Ongeldige actie',

/*
   Language Selection Page
*/
'lang'							=> 'Taal Configuratie',
'PleaseUpgradeToR6'				=> 'Je weet dat je een oude (pre %1) release van WackoWiki uitvoert. Om deze versie van WackoWiki te updaten, moet je eerst je installatie updaten naar %2.',
'UpgradeFromWacko'				=> 'Welkom bij WackoWiki, het lijkt erop dat je aan het upgraden bent van WackoWiki %1 naar %2. De volgende pagina\'s leiden u door het upgradeproces.',
'FreshInstall'					=> 'Welkom bij WackoWiki, je staat op het punt om WackoWiki %1 te installeren. De volgende pagina\'s leiden u door het installatieproces.',
'PleaseBackup'					=> 'Maak een kopie van de database, het configuratiebestand en alle gewijzigde bestanden (zoals thema\'s) voor u de upgrade start om gegevensverlies te voorkomen.',
'LangDesc'						=> 'Kies de taal voor het installatieproces. Dezelfde taal zal de standaard taal van uw WackoWiki installatie zijn.',

/*
   System Requirements Page
*/
'version-check'					=> 'Systeem Vereisten',
'PhpVersion'					=> 'PHP Versie',
'PhpDetected'					=> 'Gedetecteerd PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'Database',
'PhpExtensions'					=> 'PHP Extensies',
'Permissions'					=> 'Permissions',
'ReadyToInstall'				=> 'Klaar om te installeren?',
'Requirements'					=> 'Uw server moet voldoen aan de onderstaande eisen.',
'OK'							=> 'OK',
'Problem'						=> 'Probleem',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Uw PHP-installatie lijkt de genoteerde PHP-extensies te missen die door WackoWiki zijn vereist.',
'PcreWithoutUtf8'				=> 'PCRE is niet gecompileerd met UTF-8 ondersteuning.',
'NotePermissions'				=> 'Deze installer, probeert het configuratie instellingen naar het bestand %1, in uw WackoWiki directory. Om dit te doen dient u zeker te weten dat uw webserver schrijfrechten heeft op dat bestand! Als dat niet mogelijk is moet u het bestand handmatig wijzigen (het installatieprogramma zal u vertellen hoe).<br><br>See <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'ErrorPermissions'				=> 'Het lijkt erop dat het installatieprogramma niet automatisch de vereiste bestandsrechten kan instellen om WackoWiki correct te laten werken. Later in het installatieproces wordt u gevraagd om de vereiste bestandsrechten op uw server handmatig te configureren.',
'ErrorMinPhpVersion'			=> 'De PHP-versie moet groter zijn dan <strong>' . PHP_MIN_VERSION . '</strong>, uw server lijkt een eerdere versie te draaien. U moet upgraden naar een recentere PHP-versie om WackoWiki correct te laten werken.',
'Ready'							=> 'Gefeliciteerd, het blijkt dat uw server in staat is om WackoWiki te draaien. De volgende pagina\'s nemen u mee door het configuratieproces.',

/*
   Site Config Page
*/
'config-site'					=> 'Site Configuratie',
'SiteName'						=> 'Uw Wiki\'s naam',
'SiteNameDesc'					=> 'De naam van uw Wiki site.',
'SiteNameDefault'				=> 'MijnWiki',
'HomePage'						=> 'Home pagina',
'HomePageDesc'					=> 'Voer de naam in die u wilt dat uw homepage heeft, dit zal de standaard pagina zijn die gebruikers zien wanneer ze uw site bezoeken en zou een <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="Bekijk Help" target="_blank">WikiName</a> moeten zijn.',
'HomePageDefault'				=> 'Startpagina',
'MultiLang'						=> 'Multi Language Mode',
'MultiLangDesc'					=> 'De meertalige modus maakt het mogelijk om paginas met verschillende taalinstellingen binnen één installatie te hebben. Als deze modus is ingeschakeld, zal het installatieprogramma de eerste menu-items voor alle talen die beschikbaar zijn in de distributie maken.',
'AllowedLang'					=> 'Allowed Languages',
'AllowedLangDesc'				=> 'Het wordt aanbevolen om alleen de set van talen te selecteren die u wilt gebruiken, anders worden alle talen geselecteerd.',
'Admin'							=> 'Beheerders naam',
'AdminDesc'						=> 'Geef de gebruikersnaam van de beheerder. Moet een <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> zijn (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Gebruikersnaam moet tussen %1 en %2 tekens lang zijn. Gebruik hierbij alleen letters en cijfers.',
'NameCamelCaseOnly'				=> 'Gebruikersnaam moet tussen %1 en %2 tekens lang zijn en een WikiNaam zijn.',
'Password'						=> 'Geef wachtwoord voor de beheerder',
'PasswordDesc'					=> 'Kies een wachtwoord voor de beheerder (%1 + tekens).',
'Password2'						=> 'Herhaal wachtwoord:',
'Mail'							=> 'Beheerders mailadres.',
'MailDesc'						=> 'Enter the beheerders mailadres.',
'Base'							=> 'Basis URL',
'BaseDesc'						=> 'Your WackoWiki site base URL. Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>https://example.com/</code></strong></li><li><strong><code>https://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Herschrijf modus',
'RewriteDesc'					=> 'Herschrijven modus moet aan staan als u een WackoWiki met URL rewriting gebruikt.',
'Enabled'						=> 'Aan:',
'ErrorAdminEmail'				=> 'U moet een juist beheerders emailadres invullen!',
'ErrorAdminPasswordMismatch'	=> 'Wachtwoorden komen niet overeen, vul het wachtwoord opnieuw in!',
'ErrorAdminPasswordShort'		=> 'The admin Wachtwoord is te kort, vul het wachtwoord opnieuw in, the minimum length is %1 characters!',
'ModRewriteStatusUnknown'		=> 'Het installatieprogramma kan niet controleren of mod_rewrite is ingeschakeld, maar dit betekent niet dat het is uitgeschakeld.',

/*
   Database Config Page
*/
'config-database'				=> 'Database Configuratie',
'DbDriver'						=> 'Driver',
'DbDriverDesc'					=> 'The database driver you want to use.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'De database karakterset die u wilt gebruiken.',
'DbEngine'						=> 'Engine',
'DbEngineDesc'					=> 'The database engine you want to use.',
'DbHost'						=> 'Host',
'DbHostDesc'					=> 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort'						=> 'Port (Optional)',
'DbPortDesc'					=> 'The port number your database server is accessible through, leave it blank to use the default port number.',
'DbName'						=> 'Database Name',
'DbNameDesc'					=> 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DbUser'						=> 'Gebruikersnaam',
'DbUserDesc'					=> 'Name of the user used to connect to your database.',
'DbPassword'					=> 'Wachtwoord',
'DbPasswordDesc'				=> 'Password of the user used to connect to your database.',
'Prefix'						=> 'Tabel prefix',
'PrefixDesc'					=> 'Prefix voor alle tabellen gebruikt door WackoWiki. Dit geeft u de mogelijkheid meerdere WackoWiki installaties met dezelfde database te gebruiken (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'No database driver has been detected, please enable either the mysqli or pdo_mysql extension in your php.ini file.',
'ErrorNoDbDriverSelected'		=> 'No database driver has been selected, please pick one from the list.',
'DeleteTables'					=> 'Bestaande tabellen verwijderen?',
'DeleteTablesDesc'				=> 'LET OP! Als u doorgaat met deze optie, worden alle huidige wikigegevens uit uw database gewist. Dit kan niet ongedaan worden gemaakt, tenzij u de gegevens handmatig uit een back-up herstelt.',
'ConfirmTableDeletion'			=> 'Weet u zeker dat u alle huidige wiki tabellen wilt verwijderen?',

/*
   Database Installation Page
*/
'install-database'				=> 'Database Installation',
'TestingConfiguration'			=> 'Testen Configuratie',
'TestConnectionString'			=> 'Testen database connectie instellingen',
'TestDatabaseExists'			=> 'Controleren of de door u opgegeven database bestaat',
'TestDatabaseVersion'			=> 'Controle van de minimale versie-eisen van de database',
'InstallTables'					=> 'Installing Tables',
'ErrorDbConnection'				=> 'Er was een probleem met de gegevens van de databaseverbinding die u hebt opgegeven, ga terug en controleer of ze correct zijn.',
'ErrorDbExists'					=> 'De gekozen database is niet gevonden. De database moet al bestaan voordat u WackoWiki kunt installeren of upgraden!',
'ErrorDatabaseVersion'			=> 'De databaseversie is %1 maar vereist minstens %2.',
'To'							=> 'aan',
'AlterTable'					=> 'Altering %1 table',
'InsertRecord'					=> 'Inserting Record into %1 table',
'RenameTable'					=> 'Renaming %1 table',
'UpdateTable'					=> 'Updating %1 table',
'InstallDefaultData'			=> 'Adding Default Data',
'InstallPagesBegin'				=> 'Adding Default Pages',
'InstallPagesEnd'				=> 'Finished Adding Default Pages',
'InstallSystemAccount'			=> 'Toevoegen van de gebruiker <code>System</code>',
'InstallDeletedAccount'			=> 'Toevoegen van de gebruiker <code>Deleted</code>',
'InstallAdmin'					=> 'Toevoegen van de gebruiker beheerder',
'InstallAdminSetting'			=> 'Toevoegen van de gebruiker beheerder',
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
'CreatingTable'					=> 'Maak %1 tabel aan',
'ErrorAlreadyExists'			=> 'The %1 already exists',
'ErrorCreatingTable'			=> 'Error creating %1 table, does it already exist?',
'DeletingTables'				=> 'Deleting Tables',
'DeletingTablesEnd'				=> 'Finished Deleting Tables',
'ErrorDeletingTable'			=> 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable'					=> 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config'					=> 'Write Config File',
'FinalStep'						=> 'Final Step',
'Writing'						=> 'Wegschrijven configuratie bestand',
'RemovingWritePrivilege'		=> 'Removing Write Privilege',
'InstallationComplete'			=> 'Installatie is voltooid',
'ThatsAll'						=> 'Dat is alles! U kunt nu <a href="%1">bekijk uw WackoWiki-site</a>.',
'SecurityConsiderations'		=> 'Beveiligingsoverwegingen',
'SecurityRisk'					=> 'Echter, u wordt geadviseerd om schrijfrechten op %1 te verwijderen nu het is weggeschreven. Door de schrijfrechten te handhaven creert u een veiligheidsrisico!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'U moet de %1 -directory verwijderen nu het installatieproces is voltooid.',
'ErrorGivePrivileges'			=> 'Het configuratie bestand %1 Geen schrijf rechten. U dient uw webserver tijdelijk schrijfrechten te geven op uw WackoWiki directory, of een lege bestand met de naam %1<br>%2<br>; vergeet niet om de schrijfrechten later te verwijderen, i.e. %3.<br>Als, voor welke reden dan ook,for any reason, you can\'t do this, you\'ll have to copy the text below into a new file and save/upload it as %1 into the WackoWiki directory. Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep'						=> 'In de volgende stap probeert het installatieprogramma het actuele configuratie bestand weg te schrijven, %1. Controleer of de web server schrijfrechten heeft op het bestand, anders moet u het handmatig aanpassen. Wederom, zie <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'WrittenAt'						=> 'geschreven op ',
'DontChange'					=> 'Wijzig de wacko_version niet handmatig!',
'ConfigDescription'				=> 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Weer proberen',

];
