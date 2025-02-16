<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'no',
'LangLocale'	=> 'no_NO',
'LangName'		=> 'Norwegian',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Kategori',
	'groups_page'		=> 'Grupper',
	'users_page'		=> 'Brukere',

	'search_page'		=> 'Søk',
	'login_page'		=> 'Innlogging',
	'account_page'		=> 'Innstillinger',
	'registration_page'	=> 'Registrering',
	'password_page'		=> 'Passord',

	'changes_page'		=> 'Nylige endringer',
	'comments_page'		=> 'Nylig kommentert',
	'index_page'		=> 'PageIndex',

	'random_page'		=> 'Tilfeldig',
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
'TitleInstallation'				=> 'WackoWiki installasjon',
'TitleUpdate'					=> 'WackoWiki oppdatering',
'Continue'						=> 'Fortsett',
'Back'							=> 'Tilbake',
'Recommended'					=> 'anbefalt',
'InvalidAction'					=> 'Ugyldig handling',

/*
   Language Selection Page
*/
'lang'							=> 'Språkkonfigurasjon (Automatic Translation)',
'PleaseUpgradeToR6'				=> 'Det ser ut til at du kjører en gammel (pre %2) utgivelse av WackoWiki (%1). For å oppdatere i denne utgaven av WackoWiki, må du først oppdatere installasjonen til %2.',
'UpgradeFromWacko'				=> 'Velkommen til WackoWiki! Det ser ut til at du oppgraderer fra WackoWiki %1 til %2. De neste sidene vil lede deg gjennom oppgraderingsprosessen.',
'FreshInstall'					=> 'Velkommen til WackoWiki! Du er i ferd med å installere WackoWiki %1. De neste sidene vil veilede deg gjennom installasjonsprosessen.',
'PleaseBackup'					=> 'Please, <strong>backup</strong> your database, config file and all changed files such as those which have local hacks and patches applied to them before starting upgrade process. This can save you from a big headache.',
'LangDesc'						=> 'Velg et språk for installasjonsprosessen. Dette språket vil også bli brukt som standardspråket for WackoWiki-installasjonen din.',

/*
   System Requirements Page
*/
'version-check'					=> 'Krav i systemet',
'PhpVersion'					=> 'PHP versjon',
'PhpDetected'					=> 'Oppdaget PHP',
'ModRewrite'					=> 'Apache Omskriving utvidelse (valgfritt)',
'ModRewriteInstalled'			=> 'Skrive om utvidelse (mod_rewrite) Installert?',
'Database'						=> 'Databasen',
'PhpExtensions'					=> 'PHP utvidelser',
'Permissions'					=> 'Tillatelser',
'ReadyToInstall'				=> 'Klar til å installere?',
'Requirements'					=> 'Serveren må oppfylle kravene i listen nedenfor.',
'OK'							=> 'Ok',
'Problem'						=> 'Problem',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'PHP-installasjonen din mangler trolig de angitte PHP-utvidelsene, som er påkrevd av WackoWiki.',
'PcreWithoutUtf8'				=> 'PCRE er ikke utarbeidet med UTF-8-støtte.',
'NotePermissions'				=> 'Denne installasjonsprogrammet vil forsøke å skrive konfigurasjonsdataene til filen %1, basert i din WackoWiki-mappe. For at dette skal fungere, må du sørge for at webserveren har skrivetilgang til den filen. Hvis du ikke kan gjøre dette, må du redigere filen manuelt (installatøren vil fortelle deg hvordan).<br><br>Se <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for detaljer.',
'ErrorPermissions'				=> 'Det vil vises at installasjonsprogrammet ikke kan sette de nødvendige filtillatelsene for WackoWiki automatisk for å fungere riktig. Du vil bli spurt senere i installasjonsprosessen for å manuelt konfigurere de nødvendige filtillatelsene på serveren din.',
'ErrorMinPhpVersion'			=> 'PHP-versjonen må være større enn <strong>' . PHP_MIN_VERSION . '</strong>. Serveren din ser ut til å kjøre en tidligere versjon. Du må oppgradere til en nyere PHP-versjon for at WackoWiki skal fungere riktig.',
'Ready'							=> 'Gratulerer, det ser ut til at serveren din er i stand til å kjøre WackoWiki. De neste sidene vil ta deg gjennom konfigurasjonsprosessen.',

/*
   Site Config Page
*/
'config-site'					=> 'Konfigurasjon av nettstedet',
'SiteName'						=> 'Wiki navn',
'SiteNameDesc'					=> 'Skriv inn navnet på Wiki-nettstedet.',
'SiteNameDefault'				=> 'MyWikiSite',
'HomePage'						=> 'Hjemme Side',
'HomePageDesc'					=> 'Skriv inn navnet du ønsker at hjemmesiden din skal ha. Dette vil være standardbrukere for side vil se når de besøker nettstedet ditt og bør være en <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Hjemmeside',
'MultiLang'						=> 'Flervalg for språk',
'MultiLangDesc'					=> 'Flerspråklig modus lar deg ha sider med forskjellige språkinnstillinger i én enkelt installasjon. Når denne modusen er aktivert, oppretter installatøren startmenyelementer for alle språkene som er tilgjengelig i distribusjonen.',
'AllowedLang'					=> 'Tillatte språk',
'AllowedLangDesc'				=> 'Det anbefales å bare velge hvilke språk du vil bruke, ellers velges alle språk.',
'Admin'							=> 'Admin navn',
'AdminDesc'						=> 'Skriv inn adminens brukernavn. Dette bør være et <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (f.eks. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Brukernavnet må være mellom %1 og %2 tegn lang og bare bruke alfanumeriske tegn. De store bokstavene er OK.',
'NameCamelCaseOnly'				=> 'Brukernavnet må være mellom %1 og %2 tegn langt og WikiName formatert.',
'Password'						=> 'Admin passord',
'PasswordDesc'					=> 'Velg et passord for administrator med minimum %1 tegn.',
'PasswordConfirm'				=> 'Gjenta passord:',
'Mail'							=> 'Admin e-postadresse',
'MailDesc'						=> 'Skriv inn brukerens e-postadresse.',
'Base'							=> 'Standard URL',
'BaseDesc'						=> 'WackoWiki sidens grunnURL. Sidenavn blir lagt til her, så hvis du bruker mod_rewrite adressen bør slutte med en skråstrek, i. .</p><ul><li><strong><code>https://example. om/</code></strong></li><li><strong><code>https://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Omskrive modus',
'RewriteDesc'					=> 'Omskrivingsmodus bør aktiveres hvis du bruker WackoWiki med URL omskrivning.',
'Enabled'						=> 'Aktivert:',
'ErrorAdminEmail'				=> 'Du har angitt en ugyldig epostadresse!',
'ErrorAdminPasswordMismatch'	=> 'Passordene samsvarer ikke!',
'ErrorAdminPasswordShort'		=> 'Administratorpassordet er for kort! Minimumslengden er på %1 tegn.',
'ModRewriteStatusUnknown'		=> 'Installasjonen kan ikke verifisere at mod_rewrite er aktivert. Dette betyr imidlertid ikke at den er deaktivert.',

/*
   Database Config Page
*/
'config-database'				=> 'Database Konfigurasjon',
'DbDriver'						=> 'Sjåfør',
'DbDriverDesc'					=> 'Databasen driveren du vil bruke.',
'DbSqlMode'						=> 'SQL modus',
'DbSqlModeDesc'					=> 'SQL-modus du vil bruke.',
'DbVendor'						=> 'Leverandør',
'DbVendorDesc'					=> 'Databaseleverandør du bruker.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'Databasekorset du vil bruke.',
'DbEngine'						=> 'Motor',
'DbEngineDesc'					=> 'Databasemotor du vil bruke.',
'DbHost'						=> 'Vert',
'DbHostDesc'					=> 'Verten din databaseserver kjører på, vanligvis <code>127.0.0.1</code> eller <code>localhost</code> (dvs. samme maskin WackoWiki nettstedet ditt).',
'DbPort'						=> 'Port (Valgfritt)',
'DbPortDesc'					=> 'Portnummer databasen serveren er tilgjengelig for. La den være tom for å bruke standard portnummer.',
'DbName'						=> 'Database navn',
'DbNameDesc'					=> 'Databasen WackoWiki skal bruke. Denne databasen må allerede eksistere før du fortsetter!',
'DbUser'						=> 'Bruker navn',
'DbUserDesc'					=> 'Navn på bruker som brukes til å koble til databasen.',
'DbPassword'					=> 'Passord',
'DbPasswordDesc'				=> 'Passord for brukeren som brukes til å koble til databasen.',
'Prefix'						=> 'Tabellprefiks',
'PrefixDesc'					=> 'Prefiks for alle tabeller som brukes av WackoWiki. Dette lar deg kjøre flere WackoWiki installasjoner ved å bruke samme database ved å sette dem opp til forskjellige tabellprefikser (f.eks. wacko_).',
'ErrorNoDbDriverDetected'		=> 'Ingen databasedriver ble funnet, vennligst aktiver filtypen mysqli eller pdo_mysql i din php.ini-fil.',
'ErrorNoDbDriverSelected'		=> 'Ingen databasedriver er valgt, velg en fra listen.',
'DeleteTables'					=> 'Slette eksisterende tabeller?',
'DeleteTablesDesc'				=> 'ATTENTION! Hvis du fortsetter med dette alternativet, slettes alle gjeldende wiki-data fra databasen. Dette kan ikke angres, og du vil måtte manuelt gjenopprette data fra en sikkerhetskopi.',
'ConfirmTableDeletion'			=> 'Er du sikker på at du vil slette alle gjeldende wiki-tabeller?',

/*
   Database Installation Page
*/
'install-database'				=> 'Installasjon av database',
'TestingConfiguration'			=> 'Test konfigurasjon',
'TestConnectionString'			=> 'Tester databasetilkoblingsinnstillinger',
'TestDatabaseExists'			=> 'Sjekker om databasen du angav finnes',
'TestDatabaseVersion'			=> 'Sjekker minstekravene til versjon av databasen',
'InstallTables'					=> 'Installerer tabeller',
'ErrorDbConnection'				=> 'Det oppstod et problem med tilkoblingsdetaljene til databasen du angitt, gå tilbake og sjekk at de er riktige.',
'ErrorDatabaseVersion'			=> 'Databaseversjonen er %1 , men krever minst %2.',
'To'							=> 'til',
'AlterTable'					=> 'Legger til %1 tabell',
'InsertRecord'					=> 'Setter inn opptak til %1 -tabellen',
'RenameTable'					=> 'Endrer %1 -tabell',
'UpdateTable'					=> 'Oppdaterer %1 tabell',
'InstallDefaultData'			=> 'Legger til standard data',
'InstallPagesBegin'				=> 'Legge til standardsider',
'InstallPagesEnd'				=> 'Ferdig med å legge til standardsider',
'InstallSystemAccount'			=> 'Legger til bruker <code>System</code>',
'InstallDeletedAccount'			=> 'Adding <code>Deleted</code> User',
'InstallAdmin'					=> 'Legge til Admin bruker',
'InstallAdminSetting'			=> 'Legge til Admin brukerinnstillinger',
'InstallAdminGroup'				=> 'Legger til administratorgruppe',
'InstallAdminGroupMember'		=> 'Legger til administratorgruppemedlem',
'InstallEverybodyGroup'			=> 'Legger til alle grupper',
'InstallModeratorGroup'			=> 'Legger til moderatorgruppe',
'InstallReviewerGroup'			=> 'Legger til kontrollørgruppe',
'InstallLogoImage'				=> 'Legger til Logo-bilde',
'LogoImage'						=> 'Logobilde',
'InstallConfigValues'			=> 'Legge til konfigurasjonsverdier',
'ConfigValues'					=> 'Konfigurasjonsverdier (Automatic Translation)',
'ErrorInsertPage'				=> 'Error inserting %1 page',
'ErrorInsertPagePermission'		=> 'Feil ved innstilling av tillatelse for %1 side',
'ErrorInsertDefaultMenuItem'	=> 'Feil ved innstilling av side %1 som standard menyelement',
'ErrorPageAlreadyExists'		=> '%1 siden finnes allerede',
'ErrorAlterTable'				=> 'Error altering %1 table',
'ErrorInsertRecord'				=> 'Feil ved innsetting av opptak til %1 -tabellen',
'ErrorRenameTable'				=> 'Feil ved endring av %1 -tabellen',
'ErrorUpdatingTable'			=> 'Feil ved oppdatering av %1 -tabellen',
'CreatingTable'					=> 'Oppretter %1 -tabellen',
'ErrorAlreadyExists'			=> '%1 finnes allerede',
'ErrorCreatingTable'			=> 'Feil ved oppretting av %1 -tabellen, eksisterer allerede?',
'DeletingTables'				=> 'Sletter tabeller',
'DeletingTablesEnd'				=> 'Ferdig med å slette tabeller',
'ErrorDeletingTable'			=> 'Feil ved sletting av %1 -tabellen. Den mest sannsynlige årsaken er at tabellen ikke eksisterer, i så fall kan du ignorere denne advarselen.',
'DeletingTable'					=> 'Sletter %1 -tabellen',
'NextStep'						=> 'I det neste trinnet vil installatøren forsøke å skrive den oppdaterte konfigurasjonsfilen, %1. Kontroller at webserveren har skrivetilgang til filen, eller at du må redigere den manuelt. Når igjen, se  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for detaljer.',

/*
   Write Config Page
*/
'write-config'					=> 'Skriv konfigurasjonsfil',
'FinalStep'						=> 'Siste trinn',
'Writing'						=> 'Skriver konfigurasjonsfil',
'RemovingWritePrivilege'		=> 'Fjerner skrive privilegium',
'InstallationComplete'			=> 'Installasjon fullført',
'ThatsAll'						=> 'That\'s all! You can now <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations'		=> 'Sikkerhet Hensyn',
'SecurityRisk'					=> 'Du anbefales å fjerne skrivetilgang til %1 nå som det er skrevet. Forlater du filen skrivbar kan være en sikkerhetsrisiko!<br>dvs. %2',
'RemoveSetupDirectory'			=> 'Du bør slette mappen %1 nå som installeringsprosessen er fullført.',
'ErrorGivePrivileges'			=> 'Konfigurasjonsfilen %1 kunne ikke skrives inn. Du må gi webserveren din midlertidige skrivetilgang til mappen WackoWiki, eller en tom fil kalt %1<br>%2.<br><br> Ikke glem å fjerne skrivetilgang igjen senere, dvs. <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Hvis du av en eller annen grunn ikke kan gjøre dette, Du må kopiere teksten nedenfor til en ny fil og laste den opp som %1 i WackoWiki-mappen. Når du har gjort dette, burde din WackoWiki fungere. Hvis ikke, besøk <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Når du har gjort dette, burde ditt WackoWiki fungere. Hvis ikke, besøk <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'skrevet på ',
'DontChange'					=> 'ikke endre wacko_version manuelt!',
'ConfigDescription'				=> 'detaljert beskrivelse: https://wackowiki.org/doc/English/Configuration',
'TryAgain'						=> 'Prøv igjen',

];
