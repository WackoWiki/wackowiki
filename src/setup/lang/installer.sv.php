<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'sv',
'LangLocale'	=> 'sv_SE',
'LangName'		=> 'Swedish',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Kategori',
	'groups_page'		=> 'Grupper',
	'users_page'		=> 'Användare',

	'search_page'		=> 'Sök',
	'login_page'		=> 'Inloggning',
	'account_page'		=> 'Inställningar',
	'registration_page'	=> 'Registrering',
	'password_page'		=> 'Lösenord',

	'changes_page'		=> 'Nyligen ändrade',
	'comments_page'		=> 'Nyligen kommenterade',
	'index_page'		=> 'PageIndex',

	'random_page'		=> 'Slumpmässig',
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
'TitleInstallation'				=> 'WackoWiki Installation',
'TitleUpdate'					=> 'Uppdatering av WackoWiki',
'Continue'						=> 'Fortsätt',
'Back'							=> 'Tillbaka',
'Recommended'					=> 'rekommenderad',
'InvalidAction'					=> 'Ogiltig åtgärd',

/*
   Language Selection Page
*/
'lang'							=> 'Språk konfiguration',
'PleaseUpgradeToR6'				=> 'Du verkar köra en gammal (före %2) release av WackoWiki (%1). För att uppdatera till denna utgåva av WackoWiki, måste du först uppdatera din installation till %2.',
'UpgradeFromWacko'				=> 'Välkommen till WackoWiki! Det verkar som om du uppgraderar från WackoWiki %1 till %2. De närmaste sidorna kommer att guida dig genom uppgraderingsprocessen.',
'FreshInstall'					=> 'Välkommen till WackoWiki! Du är på väg att installera WackoWiki %1. De närmaste sidorna kommer att vägleda dig genom installationsprocessen.',
'PleaseBackup'					=> 'Snälla, <strong>säkerhetskopiera</strong> din databas, config fil och alla ändrade filer som de som har lokala hacks och patchar tillämpas på dem innan uppgraderingsprocessen. Detta kan rädda dig från en stor huvudvärk.',
'LangDesc'						=> 'Välj ett språk för installationsprocessen. Detta språk kommer också att användas som standardspråk för din WackoWiki installation.',

/*
   System Requirements Page
*/
'version-check'					=> 'Systemkrav',
'PhpVersion'					=> 'PHP-version',
'PhpDetected'					=> 'Upptäckt PHP',
'ModRewrite'					=> 'Apache omskrivningstillägg (valfritt)',
'ModRewriteInstalled'			=> 'Skriva om tillägg (mod_rewrite) Installerad?',
'Database'						=> 'Databas',
'PhpExtensions'					=> 'PHP-tillägg',
'Permissions'					=> 'Behörigheter',
'ReadyToInstall'				=> 'Redo att installera?',
'Requirements'					=> 'Din server måste uppfylla de krav som anges nedan.',
'OK'							=> 'Ok',
'Problem'						=> 'Problem',
'Example'						=> 'Exempel',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Din PHP-installation verkar sakna de angivna PHP-tilläggen, som krävs av WackoWiki.',
'PcreWithoutUtf8'				=> 'PCRE kompileras inte med UTF-8-stöd.',
'NotePermissions'				=> 'Detta installationsprogram kommer att försöka skriva konfigurationsdata till filen %1, som finns i din WackoWiki-katalog. För att detta ska fungera måste du se till att webbservern har skrivrättigheter till den filen. Om du inte kan göra detta måste du redigera filen manuellt (installationsprogrammet kommer att berätta hur).<br><br>Se <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> för detaljer.',
'ErrorPermissions'				=> 'Det verkar som att installationsprogrammet inte automatiskt kan ställa in de nödvändiga filbehörigheterna för WackoWiki att fungera korrekt. Du kommer att bli tillfrågad senare i installationsprocessen för att manuellt konfigurera de nödvändiga filbehörigheterna på din server.',
'ErrorMinPhpVersion'			=> 'PHP-versionen måste vara större än <strong>' . PHP_MIN_VERSION . '</strong>. Din server verkar köra en tidigare version. Du måste uppgradera till en nyare PHP-version för att WackoWiki ska fungera korrekt.',
'Ready'							=> 'Grattis, det verkar som om din server kan köra WackoWiki. De närmaste sidorna tar dig genom konfigurationsprocessen.',

/*
   Site Config Page
*/
'config-site'					=> 'Webbplatsens konfiguration',
'SiteName'						=> 'Wiki-namn',
'SiteNameDesc'					=> 'Ange namnet på din wikisajt.',
'SiteNameDefault'				=> 'MyWikiSite',
'HomePage'						=> 'Startsida',
'HomePageDesc'					=> 'Ange det namn du vill att din hemsida ska ha. Detta kommer att vara standard sidanvändare kommer att se när de besöker din webbplats och bör vara ett <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Hemsida',
'MultiLang'						=> 'Flerspråkigt läge',
'MultiLangDesc'					=> 'Flerspråkig läge kan du ha sidor med olika språkinställningar inom en enda installation. När det här läget är aktiverat skapar installationsprogrammet initiala menyalternativ för alla språk som finns i distributionen.',
'AllowedLang'					=> 'Tillåtna språk',
'AllowedLangDesc'				=> 'Det rekommenderas att endast välja den uppsättning språk du vill använda, annars är alla språk valda.',
'Admin'							=> 'Administratörens namn',
'AdminDesc'						=> 'Ange administratörens användarnamn. Detta bör vara ett <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (t.ex. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Användarnamnet måste vara mellan %1 och %2 tecken långt och endast använda alfanumeriska tecken. Versaler tecken är OK.',
'NameCamelCaseOnly'				=> 'Användarnamnet måste vara mellan %1 och %2 tecken långt och WikiName formaterat.',
'Password'						=> 'Admin Lösenord',
'PasswordDesc'					=> 'Välj ett lösenord för administratören med minst %1 tecken.',
'PasswordConfirm'				=> 'Upprepa lösenord:',
'Mail'							=> 'Admins e-postadress',
'MailDesc'						=> 'Ange administratörens e-postadress.',
'Base'							=> 'Bas URL',
'BaseDesc'						=> 'Din WackoWiki webbplats URL Sidnamn läggs till i det, så om du använder mod_rewrite bör adressen sluta med ett framåtriktat snedstreck i. .</p><ul><li><strong><code>https://exempel. om/</code></strong></li><li><strong><code>https://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Skriv om läge',
'RewriteDesc'					=> 'Omskrivningsläge bör aktiveras om du använder WackoWiki med URL-omskrivning.',
'Enabled'						=> 'Aktiverad:',
'ErrorAdminEmail'				=> 'Du har angett en ogiltig e-postadress!',
'ErrorAdminPasswordMismatch'	=> 'Lösenorden matchar inte!.',
'ErrorAdminPasswordShort'		=> 'Administratörslösenordet är för kort! Minsta längd är %1 tecken.',
'ModRewriteStatusUnknown'		=> 'Installationsprogrammet kan inte verifiera att mod_rewrite är aktiverat. Detta betyder dock inte att det är inaktiverat.',

/*
   Database Config Page
*/
'config-database'				=> 'Databas konfiguration',
'DbDriver'						=> 'Förare',
'DbDriverDesc'					=> 'Databasdrivrutinen du vill använda.',
'DbSqlMode'						=> 'SQL-läge',
'DbSqlModeDesc'					=> 'SQL-läget du vill använda.',
'DbVendor'						=> 'Leverantör',
'DbVendorDesc'					=> 'Databasleverantören du använder.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'Databasen charset som du vill använda.',
'DbEngine'						=> 'Motor',
'DbEngineDesc'					=> 'Databasen som du vill använda.',
'DbHost'						=> 'Värd',
'DbHostDesc'					=> 'Värden din databasserver körs på, vanligtvis <code>127.0.0.1</code> eller <code>localhost</code> (dvs samma maskin din WackoWiki webbplats är på).',
'DbPort'						=> 'Port (valfritt)',
'DbPortDesc'					=> 'Portnumret som din databasserver är tillgänglig genom. Lämna det tomt för att använda standardportnumret.',
'DbName'						=> 'Databasens namn',
'DbNameDesc'					=> 'Databasen WackoWiki bör använda. Denna databas måste finnas redan innan du fortsätter!',
'DbUser'						=> 'Användarnamn',
'DbUserDesc'					=> 'Namnet på användaren som används för att ansluta till din databas.',
'DbPassword'					=> 'Lösenord',
'DbPasswordDesc'				=> 'Lösenord för användaren som används för att ansluta till din databas.',
'Prefix'						=> 'Tabell Prefix',
'PrefixDesc'					=> 'Prefix för alla tabeller som används av WackoWiki. Detta gör att du kan köra flera WackoWiki installationer med samma databas genom att konfigurera dem för att använda olika tabellprefix (t.ex. wacko_).',
'ErrorNoDbDriverDetected'		=> 'Ingen databasdrivrutin har upptäckts, vänligen aktivera antingen mysqli eller pdo_mysql i din php.ini-fil.',
'ErrorNoDbDriverSelected'		=> 'Ingen databasdrivrutin har valts, välj en från listan.',
'DeleteTables'					=> 'Ta bort befintliga tabeller?',
'DeleteTablesDesc'				=> 'OBSERVERA! Om du fortsätter med det här alternativet kommer alla aktuella wiki-data att raderas från din databas. Detta kan inte ångras, och du kommer att behöva manuellt återställa data från en säkerhetskopia.',
'ConfirmTableDeletion'			=> 'Är du säker på att du vill ta bort alla nuvarande wiki-tabeller?',

/*
   Database Installation Page
*/
'install-database'				=> 'Installation av databas',
'TestingConfiguration'			=> 'Testar konfiguration',
'TestConnectionString'			=> 'Testar anslutningsinställningar för databas',
'TestDatabaseExists'			=> 'Kontrollerar om databasen du angav finns',
'TestDatabaseVersion'			=> 'Kontrollerar databasens minimikrav',
'InstallTables'					=> 'Installerar tabeller',
'ErrorDbConnection'				=> 'Det uppstod ett problem med databasens anslutningsdetaljer som du angav, gå tillbaka och kontrollera att de är korrekta.',
'ErrorDatabaseVersion'			=> 'Databasversionen är %1 men kräver minst %2.',
'To'							=> 'till',
'AlterTable'					=> 'Ändra %1 tabell',
'InsertRecord'					=> 'Infogar post i tabellen %1',
'RenameTable'					=> 'Byter namn på %1 tabell',
'UpdateTable'					=> 'Uppdaterar %1 tabell',
'InstallDefaultData'			=> 'Lägger till standarddata',
'InstallPagesBegin'				=> 'Lägger till standardsidor',
'InstallPagesEnd'				=> 'Slutförd att lägga till standardsidor',
'InstallSystemAccount'			=> 'Lägger till <code>System</code> användare',
'InstallDeletedAccount'			=> 'Lägger till <code>borttagen</code> användare',
'InstallAdmin'					=> 'Lägger till admin-användare',
'InstallAdminSetting'			=> 'Lägger till admin-användarinställningar',
'InstallAdminGroup'				=> 'Lägga till admins grupp',
'InstallAdminGroupMember'		=> 'Lägga till Admins Gruppmedlem',
'InstallEverybodyGroup'			=> 'Lägger till alla grupper',
'InstallModeratorGroup'			=> 'Lägga till moderatorgrupp',
'InstallReviewerGroup'			=> 'Lägger till granskargrupp',
'InstallLogoImage'				=> 'Lägger till Logotypbild',
'LogoImage'						=> 'Logotyp bild',
'InstallConfigValues'			=> 'Lägger till konfigurationsvärden',
'ConfigValues'					=> 'Konfigurationsvärden',
'ErrorInsertPage'				=> 'Fel vid infogning av %1 sida',
'ErrorInsertPagePermission'		=> 'Fel vid inställning av behörighet för %1 sida',
'ErrorInsertDefaultMenuItem'	=> 'Fel vid inställning av sida %1 som standardmenyobjekt',
'ErrorPageAlreadyExists'		=> 'Sidan %1 finns redan',
'ErrorAlterTable'				=> 'Fel vid ändring av %1 tabell',
'ErrorInsertRecord'				=> 'Fel vid infogning av post i tabellen %1',
'ErrorRenameTable'				=> 'Fel vid namnbyte av %1 tabell',
'ErrorUpdatingTable'			=> 'Fel vid uppdatering av %1 tabell',
'CreatingTable'					=> 'Skapar %1 tabell',
'ErrorAlreadyExists'			=> '%1 finns redan',
'ErrorCreatingTable'			=> 'Fel vid skapande av %1 tabell, finns det?',
'DeletingTables'				=> 'Tar bort tabeller',
'DeletingTablesEnd'				=> 'Avslutade Borttagning av tabeller',
'ErrorDeletingTable'			=> 'Fel vid radering av %1 tabell. Den troligaste anledningen är att tabellen inte existerar, i vilket fall du kan ignorera denna varning.',
'DeletingTable'					=> 'Tar bort %1 tabell',
'NextStep'						=> 'I nästa steg kommer installationsprogrammet att försöka skriva den uppdaterade konfigurationsfilen, %1. Kontrollera att webbservern har skrivrättigheter till filen, annars måste du redigera det manuellt. Återigen, se  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> för detaljer.',

/*
   Write Config Page
*/
'write-config'					=> 'Skriv konfigurationsfil',
'FinalStep'						=> 'Slutligt steg',
'Writing'						=> 'Skriva konfigurationsfil',
'RemovingWritePrivilege'		=> 'Ta bort skrivprivilegium',
'InstallationComplete'			=> 'Installationen slutförd',
'ThatsAll'						=> 'Det är allt! Du kan nu <a href="%1">visa din WackoWiki webbplats</a>.',
'SecurityConsiderations'		=> 'Säkerhetsöverväganden',
'SecurityRisk'					=> 'Du uppmanas att ta bort skrivrättigheter till %1 nu när det är skrivet. Att lämna filen skrivbar kan vara en säkerhetsrisk!<br>dvs. %2',
'RemoveSetupDirectory'			=> 'Du bör ta bort %1 -katalogen nu när installationsprocessen har slutförts.',
'ErrorGivePrivileges'			=> 'Konfigurationsfilen %1 kunde inte skrivas. Du kommer att behöva ge din webbserver tillfällig skrivtillgång till antingen din WackoWiki katalog, eller en tom fil som heter %1<br>%2.<br><br> Glöm inte att ta bort skrivåtkomst igen senare, dvs <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Om, av någon anledning, du inte kan göra detta, du måste kopiera texten nedan till en ny fil och spara/ladda upp den som %1 till WackoWiki katalogen. När du har gjort detta, bör din WackoWiki webbplats fungera. Om inte, besök <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'När du har gjort detta, bör din WackoWiki webbplats fungera. Om inte, besök <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'skriven vid ',
'DontChange'					=> 'ändra inte wacko_version manuellt!',
'ConfigDescription'				=> 'detaljerad beskrivning: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Försök igen',

];
