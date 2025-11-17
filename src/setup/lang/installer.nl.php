<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'nl',
'LangLocale'	=> 'nl_NL',
'LangName'		=> 'Dutch',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'Categorie',
	'groups_page'		=> 'Groepen',
	'users_page'		=> 'Gebruikers',

	'search_page'		=> 'Zoeken',
	'login_page'		=> 'Inloggen',
	'account_page'		=> 'Instellingen',
	'registration_page'	=> 'Registratie',
	'password_page'		=> 'Paswoord',

	'whatsnew_page'		=> 'WhatsNieuw',
	'changes_page'		=> 'LaatsteWijzigingen',
	'comments_page'		=> 'LaatsteOpmerkingen',
	'index_page'		=> 'PaginaIndex',

	'random_page'		=> 'WillekeurigePagina',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki Installatie',
'TitleUpdate'					=> 'WackoWiki Update',
'Continue'						=> 'Verder gaan',
'Back'							=> 'Terug',
'Recommended'					=> 'aanbevolen',
'InvalidAction'					=> 'Ongeldige actie',

/*
   Locking Check
 */
'LockAuthorization'				=> 'Autorisatie',
'LockAuthorizationInfo'			=> 'Voer het wachtwoord in dat u hebt opgeslagen in het bestand %1, dat u tijdelijk in de map Wacko hebt geplaatst.',
'LockPassword'					=> 'Wachtwoord:',
'LockLogin'						=> 'Aanmelden',
'LockPasswordInvalid'			=> 'Ongeldig wachtwoord.',
'LockedTryLater'				=> 'Deze site wordt momenteel bijgewerkt. Probeer het later opnieuw.',


/*
   Language Selection Page
*/
'lang'							=> 'Taal Configuratie',
'PleaseUpgradeToR6'				=> 'Je weet dat je een oude release van WackoWiki %1 uitvoert. Om deze versie van WackoWiki te updaten, moet je eerst je installatie updaten naar %2.',
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
'ModRewrite'					=> 'Apache Herschrijf Extensie (optioneel)',
'ModRewriteInstalled'			=> 'Herschrijf Extensie (mod_rewrite) geïnstalleerd?',
'Database'						=> 'Database',
'PhpExtensions'					=> 'PHP Extensies',
'Permissions'					=> 'Bewerk ACL\'s (rechten)',
'ReadyToInstall'				=> 'Klaar om te installeren?',
'Requirements'					=> 'Uw server moet voldoen aan de onderstaande eisen.',
'OK'							=> 'Ok',
'Problem'						=> 'Probleem',
'Example'						=> 'Voorbeeld',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Uw PHP-installatie lijkt de genoteerde PHP-extensies te missen die door WackoWiki zijn vereist.',
'PcreWithoutUtf8'				=> 'PCRE is niet gecompileerd met UTF-8 ondersteuning.',
'NotePermissions'				=> 'Deze installer, probeert het configuratie instellingen naar het bestand %1, in uw WackoWiki directory. Om dit te doen dient u zeker te weten dat uw webserver schrijfrechten heeft op dat bestand! Als dat niet mogelijk is moet u het bestand handmatig wijzigen (het installatieprogramma zal u vertellen hoe).<br><br>See <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'ErrorPermissions'				=> 'Het lijkt erop dat het installatieprogramma niet automatisch de vereiste bestandsrechten kan instellen om WackoWiki correct te laten werken. Later in het installatieproces wordt u gevraagd om de vereiste bestandsrechten op uw server handmatig te configureren.',
'ErrorMinPhpVersion'			=> 'De PHP-versie moet groter zijn dan %1. Uw server gebruikt een eerdere versie. U moet upgraden naar een recentere PHP-versie om WackoWiki correct te laten werken.',
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
'MultiLang'						=> 'Meertalige taalmodus',
'MultiLangDesc'					=> 'De meertalige modus maakt het mogelijk om paginas met verschillende taalinstellingen binnen één installatie te hebben. Als deze modus is ingeschakeld, zal het installatieprogramma de eerste menu-items voor alle talen die beschikbaar zijn in de distributie maken.',
'AllowedLang'					=> 'Toegestane talen',
'AllowedLangDesc'				=> 'Het wordt aanbevolen om alleen de set van talen te selecteren die u wilt gebruiken, anders worden alle talen geselecteerd.',
'AclMode'						=> 'Standaard ACL instellingen',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Publieke Wiki (gelezen voor iedereen, schrijven en commentaar voor geregistreerde gebruikers)',
'PrivateWiki'					=> 'Privé Wiki (lezen, schrijven, commentaar alleen voor geregistreerde gebruikers)',
'Admin'							=> 'Beheerders naam',
'AdminDesc'						=> 'Geef de gebruikersnaam van de beheerder. Moet een <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> zijn (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Gebruikersnaam moet tussen %1 en %2 tekens lang zijn. Gebruik hierbij alleen letters en cijfers.',
'NameCamelCaseOnly'				=> 'Gebruikersnaam moet tussen %1 en %2 tekens lang zijn en een WikiNaam zijn.',
'Password'						=> 'Geef wachtwoord voor de beheerder',
'PasswordDesc'					=> 'Kies een wachtwoord voor de beheerder (%1 + tekens).',
'PasswordConfirm'				=> 'Herhaal wachtwoord:',
'Mail'							=> 'Beheerders mailadres.',
'MailDesc'						=> 'Enter the beheerders mailadres.',
'Base'							=> 'Basis URL',
'BaseDesc'						=> 'Uw basis-URL van uw WackoWiki Paginanamen worden er aan toegevoegd, dus als u gebruik maakt van mod_rewrite moet het adres eindigen met een slash, dat wil zeggen',
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
'DbDriver'						=> 'Chauffeur',
'DbDriverDesc'					=> 'De database driver die u wilt gebruiken.',
'DbSqlMode'						=> 'SQL modus',
'DbSqlModeDesc'					=> 'De SQL modus die u wilt gebruiken.',
'DbVendor'						=> 'Leverancier',
'DbVendorDesc'					=> 'De database-leverancier die u gebruikt.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'De database karakterset die u wilt gebruiken.',
'DbEngine'						=> 'Motor',
'DbEngineDesc'					=> 'De database-engine die u wilt gebruiken.',
'DbHost'						=> 'Hostnaam',
'DbHostDesc'					=> 'De host waar uw database server op draait, meestal <code>127.0.0.1</code> of <code>localhost</code> (d.w.z. dezelfde machine waar je WackoWiki site aan is).',
'DbPort'						=> 'Poort (optioneel)',
'DbPortDesc'					=> 'Het poortnummer waar uw databaseserver bereikbaar is. Laat leeg om het standaard poortnummer te gebruiken.',
'DbName'						=> 'Database Naam',
'DbNameDesc'					=> 'De database WackoWiki moet gebruiken. Deze database moet al bestaan voordat je doorgaat!',
'DbNameSqliteDesc'				=> 'De gegevensmap en bestandsnaam SQLite zou moeten gebruiken voor WackoWiki.',
'DbNameSqliteHelp'				=> 'SQLite slaat alle gegevens in één enkel bestand op.<br><br>De map die u opgeeft moet beschrijfbaar zijn door de webserver tijdens de installatie. <br><br>Het moet <strong>niet</strong> toegankelijk zijn via het web.<br><br>Het installatieprogramma maakt een extra <code>. toegang tot</code> bestand samen met het bestand, maar als dit niet lukt, kan iemand toegang krijgen tot uw database. <br>Dit omvat gebruikersgegevens (e-mailadressen, hash-wachtwoorden) en beschermde pagina\'s en andere vertrouwelijke gegevens opgeslagen in de wiki. <br><br>Het is daarom raadzaam om het gegevensbestand op een volledig andere locatie op te slaan, bijvoorbeeld in de map <code>/var/lib/wackowiki/yourwiki</code>.',
'DbUser'						=> 'Gebruikersnaam',
'DbUserDesc'					=> 'Naam van de gebruiker die gebruikt wordt om verbinding te maken met uw database.',
'DbPassword'					=> 'Wachtwoord',
'DbPasswordDesc'				=> 'Wachtwoord van de gebruiker die gebruikt wordt om verbinding te maken met uw database.',
'Prefix'						=> 'Tabel prefix',
'PrefixDesc'					=> 'Prefix voor alle tabellen gebruikt door WackoWiki. Dit geeft u de mogelijkheid meerdere WackoWiki installaties met dezelfde database te gebruiken (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'Er is geen database driver gedetecteerd, schakel mysqli of pdo_mysql extensie in in uw php.ini bestand in.',
'ErrorNoDbDriverSelected'		=> 'Er is geen database driver geselecteerd, kies er een uit de lijst.',
'DeleteTables'					=> 'Bestaande tabellen verwijderen?',
'DeleteTablesDesc'				=> 'LET OP! Als u doorgaat met deze optie, worden alle huidige wikigegevens uit uw database gewist. Dit kan niet ongedaan worden gemaakt, tenzij u de gegevens handmatig uit een back-up herstelt.',
'ConfirmTableDeletion'			=> 'Weet u zeker dat u alle huidige wiki tabellen wilt verwijderen?',

/*
   Database Installation Page
*/
'install-database'				=> 'Database Installatie',
'TestingConfiguration'			=> 'Testen Configuratie',
'TestConnectionString'			=> 'Testen database connectie instellingen',
'TestDatabaseExists'			=> 'Controleren of de door u opgegeven database bestaat',
'TestDatabaseVersion'			=> 'Controle van de minimale versie-eisen van de database',
'SqliteFileExtensionError'		=> 'Gebruik een van de volgende bestandsextensies db, sdb, sqlite.',
'SqliteParentUnwritableGroup'	=> 'Kan de gegevensmap niet aanmaken <code>%1</code>, omdat de bovenliggende map <code>%2</code> niet beschrijfbaar is door de webserver.<br><br>De installatie heeft bepaald als welke gebruiker je webserver draait.<br>Maak de <code>%3</code> map beschrijfbaar om verder te gaan.<br>op een Unix/Linux systeem doen:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> 'Kan de gegevensmap niet aanmaken <code>%1</code>, omdat de bovenliggende map <code>%2</code> niet beschrijfbaar is door de webserver.<br><br>Het installatieprogramma kon de gebruiker die uw webserver draait niet bepalen.<br>Maak de <code>%3</code> map wereldwijd beschrijfbaar (en anderen!) om door te gaan.<br>op een Unix/Linux systeem doen:<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> 'Fout bij het maken van de gegevensmap <code>%1</code>.<br>Controleer de locatie en probeer het opnieuw.',
'SqliteDirUnwritable'			=> 'Het is niet mogelijk om te schrijven naar de map <code>%1</code>.<br>Wijzig de rechten zodat de webserver ernaar kan schrijven en het opnieuw kan proberen.',
'SqliteReadonly'				=> 'Het bestand <code>%1</code> is niet schrijfbaar.',
'SqliteCantCreateDb'			=> 'Kan het databasebestand niet aanmaken <code>%1</code>.',
'InstallTables'					=> 'Tabellen installeren',
'ErrorDbConnection'				=> 'Er was een probleem met de gegevens van de databaseverbinding die u hebt opgegeven, ga terug en controleer of ze correct zijn.',
'ErrorDatabaseVersion'			=> 'De databaseversie is %1 maar vereist minstens %2.',
'To'							=> 'aan',
'AlterTable'					=> 'Wijzig %1 tabel',
'InsertRecord'					=> 'Record in %1 tabel invoegen',
'RenameTable'					=> 'Hernoem %1 tabel',
'UpdateTable'					=> 'Bijwerken %1 tabel',
'InstallDefaultData'			=> 'Standaardgegevens toevoegen',
'InstallPagesBegin'				=> 'Standaardpagina\'s toevoegen',
'InstallPagesEnd'				=> 'Klaar met toevoegen van standaard pagina\'s',
'InstallSystemAccount'			=> 'Toevoegen van de gebruiker <code>System</code>',
'InstallDeletedAccount'			=> 'Toevoegen van de gebruiker <code>Deleted</code>',
'InstallAdmin'					=> 'Toevoegen van de gebruiker beheerder',
'InstallAdminSetting'			=> 'Toevoegen van de gebruiker beheerder',
'InstallAdminGroup'				=> 'Admins groep toevoegen',
'InstallAdminGroupMember'		=> 'Beheerders groepsleden toevoegen',
'InstallEverybodyGroup'			=> 'Iedereen toevoegen groep',
'InstallModeratorGroup'			=> 'Moderator groep toevoegen',
'InstallReviewerGroup'			=> 'Reviewer groep toevoegen',
'InstallLogoImage'				=> 'Logo afbeelding toevoegen',
'LogoImage'						=> 'Logo afbeelding',
'InstallConfigValues'			=> 'Configuratie waarden toevoegen',
'ConfigValues'					=> 'Configuratie waarden',
'ErrorInsertPage'				=> 'Fout bij invoegen %1 pagina',
'ErrorInsertPagePermission'		=> 'Fout bij instellen toestemming voor %1 pagina',
'ErrorInsertDefaultMenuItem'	=> 'Fout bij instellen van pagina %1 als standaard menu-item',
'ErrorPageAlreadyExists'		=> 'De %1 pagina bestaat al',
'ErrorAlterTable'				=> 'Fout bij wijzigen %1 tabel',
'ErrorInsertRecord'				=> 'Fout bij toevoegen record in %1 tabel',
'ErrorRenameTable'				=> 'Fout bij hernoemen %1 tabel',
'ErrorUpdatingTable'			=> 'Fout bijwerken %1 tabel',
'CreatingTable'					=> 'Maak %1 tabel aan',
'CreatingIndex'					=> '%1 index aanmaken',
'CreatingTrigger'				=> 'Maken van %1 trigger',
'ErrorAlreadyExists'			=> 'De %1 bestaat al',
'ErrorCreatingTable'			=> 'Fout bij aanmaken %1 tabel, bestaat deze al?',
'ErrorCreatingIndex'			=> 'Fout bij aanmaken %1 index, bestaat deze al?',
'ErrorCreatingTrigger'			=> 'Fout bij het maken van %1 trigger, bestaat deze al?',
'DeletingTables'				=> 'Tabellen verwijderen',
'DeletingTablesEnd'				=> 'Afgeronde verwijdertabellen',
'ErrorDeletingTable'			=> 'Fout bij verwijderen %1 tabel. De meest waarschijnlijke reden is dat de tabel niet bestaat, in welk geval u deze waarschuwing kunt negeren.',
'DeletingTable'					=> '%1 tabel verwijderen',
'NextStep'						=> 'In de volgende stap probeert het installatieprogramma het actuele configuratie bestand weg te schrijven, %1. Controleer of de web server schrijfrechten heeft op het bestand, anders moet u het handmatig aanpassen. Wederom, zie <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',

/*
   Write Config Page
*/
'write-config'					=> 'Configuratiebestand schrijven',
'FinalStep'						=> 'Laatste stap',
'Writing'						=> 'Wegschrijven configuratie bestand',
'RemovingWritePrivilege'		=> 'Schrijfrecht verwijderen',
'InstallationComplete'			=> 'Installatie is voltooid',
'ThatsAll'						=> 'Dat is alles! U kunt nu <a href="%1">bekijk uw WackoWiki-site</a>.',
'SecurityConsiderations'		=> 'Beveiligingsoverwegingen',
'SecurityRisk'					=> 'Echter, u wordt geadviseerd om schrijfrechten op %1 te verwijderen nu het is weggeschreven. Door de schrijfrechten te handhaven creert u een veiligheidsrisico!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'U moet de %1 -directory verwijderen nu het installatieproces is voltooid.',
'ErrorGivePrivileges'			=> 'Het configuratie bestand %1 Geen schrijf rechten. U dient uw webserver tijdelijk schrijfrechten te geven op uw WackoWiki directory, of een lege bestand met de naam %1<br>%2<br><br>; vergeet niet om de schrijfrechten later te verwijderen, i.e. <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Als, voor welke reden dan ook,for any reason, you can\'t do this, you\'ll have to copy the text below into a new file and save/upload it as %1 into the WackoWiki directory. Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Zodra je dit hebt gedaan, moet je WackoWiki-site werken. Zo niet, ga dan naar <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'geschreven op ',
'DontChange'					=> 'Wijzig de wacko_version niet handmatig!',
'ConfigDescription'				=> 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Weer proberen',

];
