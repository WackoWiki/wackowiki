<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'da',
'LangLocale'	=> 'da_DK',
'LangName'		=> 'Dansk',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Kategori',
	'groups_page'		=> 'Grupper',
	'users_page'		=> 'Brugere',

	'search_page'		=> 'Søgning',
	'login_page'		=> 'Log ind',
	'account_page'		=> 'Indstillinger',
	'registration_page'	=> 'Registrering',
	'password_page'		=> 'Din adgangskode',

	'changes_page'		=> 'Opdateringer',
	'comments_page'		=> 'Kommentarer',
	'index_page'		=> 'Indhold',

	'random_page'		=> 'TilfældigSide',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki Installation',
'TitleUpdate'					=> 'WackoWiki Opdatering',
'Continue'						=> 'Fortsæt',
'Back'							=> 'Tilbage',
'Recommended'					=> 'anbefales',
'InvalidAction'					=> 'Ugyldig handling',

/*
   Language Selection Page
*/
'lang'							=> 'Sprogkonfiguration',
'PleaseUpgradeToR6'				=> 'Du kører en gammel (før %2) version af WackoWiki (%1). For at opdatere til denne nye version af WackoWiki, skal du først opdatere din installation til %2.',
'UpgradeFromWacko'				=> 'Velkommen til WackoWiki, det ser ud til, at du opgraderer fra WackoWiki %1 til %2.  De næste par sider vil guide dig gennem opgraderingsprocessen.',
'FreshInstall'					=> 'Velkommen til WackoWiki, du er ved at installere WackoWiki %1.  De næste par sider vil guide dig gennem installationsprocessen.',
'PleaseBackup'					=> 'Venligst, <strong>backup</strong> din database, config fil og alle ændrede filer som dem, der har lokale hacks og patches anvendes til dem, før du starter opgraderingsprocessen. Dette kan redde dig fra en stor hovedpine.',
'LangDesc'						=> 'Vælg venligst et sprog til installationsprocessen. Dette sprog vil også blive brugt som standardsprog i din WackoWiki-installation.',

/*
   System Requirements Page
*/
'version-check'					=> 'Systemkrav',
'PhpVersion'					=> 'PHP Version',
'PhpDetected'					=> 'Registreret PHP',
'ModRewrite'					=> 'Apache Omskriv Udvidelse (Valgfri)',
'ModRewriteInstalled'			=> 'Omskriv Udvidelse (mod_rewrite) Installeret?',
'Database'						=> 'Database',
'PhpExtensions'					=> 'Php Udvidelser',
'Permissions'					=> 'Rediger tilladelser',
'ReadyToInstall'				=> 'Klar til installation?',
'Requirements'					=> 'Din server skal opfylde nedenstående krav.',
'OK'							=> 'Ok',
'Problem'						=> 'Problem',
'Example'						=> 'Eksempel',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Din PHP-installation synes at mangle de bemærkede PHP-udvidelser, som kræves af WackoWiki. ',
'PcreWithoutUtf8'				=> 'PCRE er ikke kompileret med UTF-8-understøttelse.',
'NotePermissions'				=> 'Dette installationsprogram vil forsøge at skrive konfigurationsdata til filen %1, der er placeret i din WackoWiki-mappe. For at dette kan virke, skal du sørge for, at webserveren har skriveadgang til filen. Hvis du ikke kan gøre dette, bliver du nødt til at redigere filen manuelt (installationsprogrammet vil fortælle dig hvordan).<br><br>Se <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for detaljer.',
'ErrorPermissions'				=> 'Det ser ud til, at installationsprogrammet ikke automatisk kan indstille de nødvendige filtilladelser for at WackoWiki kan fungere korrekt. Du vil senere i installationsprocessen blive bedt om manuelt at konfigurere de nødvendige filtilladelser på din server.',
'ErrorMinPhpVersion'			=> 'PHP versionen skal være større end %1. Din server synes at køre en tidligere version. Du skal opgradere til en nyere PHP-version for at WackoWiki kan fungere korrekt.',
'Ready'							=> 'Tillykke, det ser ud til, at din server kan køre WackoWiki. De næste par sider vil føre dig gennem konfigurationsprocessen.',

/*
   Site Config Page
*/
'config-site'					=> 'Websted Konfiguration',
'SiteName'						=> 'Wiki Navn',
'SiteNameDesc'					=> 'Indtast venligst navnet på dit Wiki-websted.',
'SiteNameDefault'				=> 'MinWiki',
'HomePage'						=> 'Startside',
'HomePageDesc'					=> 'Indtast det navn, du ønsker din startside skal have. Dette vil være standardsiden brugere vil se, når de besøger dit websted og bør være et <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Startside',
'MultiLang'						=> 'Multi Sprogtilstand',
'MultiLangDesc'					=> '"Flersproget" tilstand giver mulighed for at have sider med forskellige sprogindstillinger i en enkelt installation. Når denne tilstand er aktiveret, opretter installationsprogrammet indledende menupunkter for alle sprog, der er tilgængelige i distributionen.',
'AllowedLang'					=> 'Tilladte Sprog',
'AllowedLangDesc'				=> 'Det anbefales, at du kun vælger det sæt sprog, du ønsker at bruge, ellers er alle sprog valgt.',
'AclMode'						=> 'Standard ACL indstillinger',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Offentlig Wiki (læs for alle, skriv og kommentar til registrerede brugere)',
'PrivateWiki'					=> 'Privat Wiki (læs, skriv, kommentar kun for registrerede brugere)',
'Admin'							=> 'Administrator Navn',
'AdminDesc'						=> 'Indtast administratorens brugernavn. Dette skal være et <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (f.eks. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Brugernavn skal være mellem %1 og %2 tegn langt og brug kun alfanumeriske tegn.',
'NameCamelCaseOnly'				=> 'Brugernavn skal være mellem %1 og %2 tegn langt og WikiNavn formateret.',
'Password'						=> 'Admin Adgangskode',
'PasswordDesc'					=> 'Vælg en adgangskode til admin med minimum %1 tegn.',
'PasswordConfirm'				=> 'Gentag Adgangskode:',
'Mail'							=> 'Admin E-Mail Adresse',
'MailDesc'						=> 'Indtast administratorens e-mailadresse.',
'Base'							=> 'Base URL',
'BaseDesc'						=> 'Din WackoWiki site base URL. Page names get added to it, so if you are using mod_rewrite the address should end with a forward slash, i.e.',
'Rewrite'						=> 'Omskriv Tilstand',
'RewriteDesc'					=> 'Omskrivningstilstand skal være aktiveret, hvis du bruger WackoWiki med URL omskrivning.',
'Enabled'						=> 'Aktiveret:',
'ErrorAdminEmail'				=> 'Du har indtastet en ugyldig e-mailadresse!',
'ErrorAdminPasswordMismatch'	=> 'Adgangskoderne stemmer ikke over!',
'ErrorAdminPasswordShort'		=> 'Admin-adgangskoden er for kort, minimumslængden er %1 tegn!',
'ModRewriteStatusUnknown'		=> 'Installationsprogrammet kan ikke verificere at mod_rewrite er aktiveret. Dette betyder dog ikke, at det er deaktiveret.',

/*
   Database Config Page
*/
'config-database'				=> 'Database Konfiguration',
'DbDriver'						=> 'Chauffør',
'DbDriverDesc'					=> 'Databasedriveren du vil bruge.',
'DbSqlMode'						=> 'SQL tilstand',
'DbSqlModeDesc'					=> 'SQL- tilstand du vil bruge.',
'DbVendor'						=> 'Forhandler',
'DbVendorDesc'					=> 'Databaseleverandøren, du bruger.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'Databasens tegnsæt, du vil bruge.',
'DbEngine'						=> 'Motor',
'DbEngineDesc'					=> 'Databasemotoren du vil bruge.',
'DbHost'						=> 'Vært',
'DbHostDesc'					=> 'Værten din database server kører på, normalt <code>127.0.0.1</code> eller <code>localhost</code> (dvs. den samme maskine som din WackoWiki hjemmeside er på).',
'DbPort'						=> 'Port (valgfrit)',
'DbPortDesc'					=> 'Portenummeret som din databaseserver er tilgængeligt igennem. Lad det stå tomt for at bruge standard portnummeret.',
'DbName'						=> 'Database Navn',
'DbNameDesc'					=> 'Databasen WackoWiki skal bruge. Denne database skal allerede eksistere før du fortsætter!',
'DbUser'						=> 'Bruger Navn',
'DbUserDesc'					=> 'Navn på den bruger, der bruges til at oprette forbindelse til din database.',
'DbPassword'					=> 'Din adgangskode',
'DbPasswordDesc'				=> 'Adgangskode for brugeren, der bruges til at oprette forbindelse til din database.',
'Prefix'						=> 'Tabel Præfiks',
'PrefixDesc'					=> 'Præfiks for alle tabeller brugt af WackoWiki. Dette giver dig mulighed for at køre flere WackoWiki installationer ved hjælp af den samme database ved at konfigurere dem til at bruge forskellige tabel præfikser (fx wacko_).',
'ErrorNoDbDriverDetected'		=> 'Ingen database driver er blevet fundet. Aktiver venligst enten mysqli eller pdo_mysql udvidelsen i din php.ini fil.',
'ErrorNoDbDriverSelected'		=> 'Ingen database driver er valgt, vælg venligst en fra listen.',
'DeleteTables'					=> 'Slet eksisterende tabeller?',
'DeleteTablesDesc'				=> 'OPMÆRKSOMHED! Hvis du fortsætter med denne indstilling valgt, vil alle nuværende wiki-data blive slettet fra din database. Dette kan ikke fortrydes, medmindre du manuelt gendanner dataene fra en sikkerhedskopi.',
'ConfirmTableDeletion'			=> 'Er du sikker på, at du vil slette alle nuværende wiki-tabeller?',

/*
   Database Installation Page
*/
'install-database'				=> 'Database Installation',
'TestingConfiguration'			=> 'Test Konfiguration',
'TestConnectionString'			=> 'Test databaseforbindelsesindstillinger',
'TestDatabaseExists'			=> 'Kontrollerer om den angivne database findes',
'TestDatabaseVersion'			=> 'Kontrollerer minimumskrav til databaseversion',
'InstallTables'					=> 'Installerer Tabeller',
'ErrorDbConnection'				=> 'Der opstod et problem med de databaseforbindelsesdetaljer, du har angivet, gå venligst tilbage og tjek at de er korrekte.',
'ErrorDatabaseVersion'			=> 'Databaseversionen er %1 , men kræver mindst %2.',
'To'							=> 'til',
'AlterTable'					=> 'Ændre %1 tabel',
'InsertRecord'					=> 'Indsætter post i %1 tabel',
'RenameTable'					=> 'Omdøber %1 tabel',
'UpdateTable'					=> 'Opdaterer %1 tabel',
'InstallDefaultData'			=> 'Tilføjer Standarddata',
'InstallPagesBegin'				=> 'Tilføjer Standardsider',
'InstallPagesEnd'				=> 'Tilføjelse Af Standardsider Afsluttet',
'InstallSystemAccount'			=> 'Tilføje <code>System</code> Bruger',
'InstallDeletedAccount'			=> 'Tilføje <code>Slettet</code> Bruger',
'InstallAdmin'					=> 'Tilføjer Administratorbruger',
'InstallAdminSetting'			=> 'Tilføjer Administrerende Brugerindstillinger',
'InstallAdminGroup'				=> 'Tilføjer Admins Gruppe',
'InstallAdminGroupMember'		=> 'Tilføjelse Af Admins Gruppemedlem',
'InstallEverybodyGroup'			=> 'Tilføje Alle Gruppe',
'InstallModeratorGroup'			=> 'Tilføjer Moderatorgruppe',
'InstallReviewerGroup'			=> 'Tilføjer Anmeldergruppe',
'InstallLogoImage'				=> 'Tilføjer Logo Billede',
'LogoImage'						=> 'Logo billede',
'InstallConfigValues'			=> 'Tilføjer Konfigurationsværdier',
'ConfigValues'					=> 'Konfigurations Værdier',
'ErrorInsertPage'				=> 'Fejl ved indsættelse af %1 side',
'ErrorInsertPagePermission'		=> 'Fejl ved indstilling af tilladelse til %1 side',
'ErrorInsertDefaultMenuItem'	=> 'Fejl ved indstilling af side %1 som standard menupunkt',
'ErrorPageAlreadyExists'		=> 'Siden %1 findes allerede',
'ErrorAlterTable'				=> 'Fejl under ændring af %1 tabel',
'ErrorInsertRecord'				=> 'Fejl under indtastning af post i tabellen %1',
'ErrorRenameTable'				=> 'Fejl under omdøbning af %1 tabel',
'ErrorUpdatingTable'			=> 'Fejl under opdatering af %1 tabel',
'CreatingTable'					=> 'Opretter %1 tabel',
'ErrorAlreadyExists'			=> '%1 findes allerede',
'ErrorCreatingTable'			=> 'Fejl ved oprettelse af %1 -tabellen, eksisterer den allerede?',
'DeletingTables'				=> 'Sletter Tabeller',
'DeletingTablesEnd'				=> 'Afsluttede Sletningstabeller',
'ErrorDeletingTable'			=> 'Fejl ved sletning af %1 tabel. Den mest sandsynlige årsag er, at tabellen ikke findes, i hvilket tilfælde du kan ignorere denne advarsel.',
'DeletingTable'					=> 'Sletter %1 tabel',
'NextStep'						=> 'I det næste trin vil installationsprogrammet forsøge at skrive den opdaterede konfigurationsfil, %1. Kontroller, at webserveren har skriveadgang til filen, eller at du bliver nødt til at redigere den manuelt. Igen, se  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for detaljer.',

/*
   Write Config Page
*/
'write-config'					=> 'Skriv Config File',
'FinalStep'						=> 'Afsluttende Trin',
'Writing'						=> 'Brænder Konfigurationsfil',
'RemovingWritePrivilege'		=> 'Fjerner Skriv Privilege',
'InstallationComplete'			=> 'Installation færdig',
'ThatsAll'						=> 'Det er det hele! Du kan nu <a href="%1">se dit WackoWiki-websted</a>.',
'SecurityConsiderations'		=> 'Overvejelser Om Sikkerhed',
'SecurityRisk'					=> 'Du rådes til at fjerne skriveadgang til %1 nu, hvor den er skrevet. Forlader filen skrivbar kan være en sikkerhedsrisiko!<br>dvs.. %2',
'RemoveSetupDirectory'			=> 'Du bør slette mappen %1 nu, hvor installationsprocessen er gennemført.',
'ErrorGivePrivileges'			=> 'Konfigurationsfilen %1 kunne ikke skrives. Du skal give din webserver midlertidig skriveadgang til enten din WackoWiki-mappe, eller en tom fil kaldet %1<br>%2.<br><br> Glem ikke at fjerne skriveadgang igen senere, dvs. <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Hvis du af en eller anden grund ikke kan gøre dette, du skal kopiere teksten nedenfor til en ny fil og gemme/uploade den som %1 i WackoWiki-mappen. Når du har gjort dette, bør dit WackoWiki websted fungere. Hvis ikke, bedes du besøge <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Når du har gjort dette, bør dit WackoWiki websted fungere. Hvis ikke, bedes du besøge <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'skrevet den ',
'DontChange'					=> 'ændrer ikke wacko_version manuelt!',
'ConfigDescription'				=> 'detaljeret beskrivelse: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Prøv igen',

];
