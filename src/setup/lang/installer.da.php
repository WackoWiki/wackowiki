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

	// time
	#'date_format'					=> 'dd.MM.yyyy',
	#'time_format'					=> 'HH:mm',
	#'time_format_seconds'			=> 'HH:mm:ss',
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
'PleaseBackup'					=> 'Please, <strong>backup</strong> your database, config file and all changed files such as those which have hacks and patches applied to them before starting upgrade process. This can save you from big headache.',
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
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Din PHP-installation synes at mangle de bemærkede PHP-udvidelser, som kræves af WackoWiki. ',
'PcreWithoutUtf8'				=> 'PCRE er ikke kompileret med UTF-8-understøttelse.',
'NotePermissions'				=> 'Dette installationsprogram vil forsøge at skrive konfigurationsdata til filen %1, der er placeret i din WackoWiki-mappe. For at dette kan virke, skal du sørge for, at webserveren har skriveadgang til filen. Hvis du ikke kan gøre dette, bliver du nødt til at redigere filen manuelt (installationsprogrammet vil fortælle dig hvordan).<br><br>Se <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for detaljer.',
'ErrorPermissions'				=> 'Det ser ud til, at installationsprogrammet ikke automatisk kan indstille de nødvendige filtilladelser for at WackoWiki kan fungere korrekt. Du vil senere i installationsprocessen blive bedt om manuelt at konfigurere de nødvendige filtilladelser på din server.',
'ErrorMinPhpVersion'			=> 'PHP-versionen skal være større end <strong>' . PHP_MIN_VERSION . '</strong>, det ser ud til, at din server kører en tidligere version. Du skal opgradere til en nyere PHP-version for at WackoWiki kan fungere korrekt.',
'Ready'							=> 'Tillykke, det ser ud til, at din server kan køre WackoWiki. De næste par sider vil føre dig gennem konfigurationsprocessen.',

/*
   Site Config Page
*/
'config-site'					=> 'Websted Konfiguration',
'SiteName'						=> 'Wiki Navn',
'SiteNameDesc'					=> 'Indtast venligst navnet på dit Wiki-websted.',
'SiteNameDefault'				=> 'MinWiki',
'HomePage'						=> 'Startside',
'HomePageDesc'					=> 'Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Startside',
'MultiLang'						=> 'Multi Sprogtilstand',
'MultiLangDesc'					=> '"Flersproget" tilstand giver mulighed for at have sider med forskellige sprogindstillinger i en enkelt installation. Når denne tilstand er aktiveret, opretter installationsprogrammet indledende menupunkter for alle sprog, der er tilgængelige i distributionen.',
'AllowedLang'					=> 'Tilladte Sprog',
'AllowedLangDesc'				=> 'Det anbefales, at du kun vælger det sæt sprog, du ønsker at bruge, ellers er alle sprog valgt.',
'Admin'							=> 'Administrator Navn',
'AdminDesc'						=> 'Enter the admins username, this should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Brugernavn skal være mellem %1 og %2 tegn langt og brug kun alfanumeriske tegn.',
'NameCamelCaseOnly'				=> 'Brugernavn skal være mellem %1 og %2 tegn langt og WikiNavn formateret.',
'Password'						=> 'Admin Adgangskode',
'PasswordDesc'					=> 'Vælg en adgangskode til admin med minimum %1 tegn.',
'PasswordConfirm'				=> 'Gentag Adgangskode:',
'Mail'							=> 'Admin E-Mail Adresse',
'MailDesc'						=> 'Enter the admins email address.',
'Base'							=> 'Base URL',
'BaseDesc'						=> 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>https://example.com/</code></strong></li><li><strong><code>https://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Omskriv Tilstand',
'RewriteDesc'					=> 'Omskrivningstilstand skal være aktiveret, hvis du bruger WackoWiki med URL omskrivning.',
'Enabled'						=> 'Aktiveret:',
'ErrorAdminEmail'				=> 'Du har indtastet en ugyldig e-mailadresse!',
'ErrorAdminPasswordMismatch'	=> 'Adgangskoderne stemmer ikke over!',
'ErrorAdminPasswordShort'		=> 'Admin-adgangskoden er for kort, minimumslængden er %1 tegn!',
'ModRewriteStatusUnknown'		=> 'The installer cannot verify that mod_rewrite is enabled, however this does not mean it is disabled',

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
'DbHostDesc'					=> 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort'						=> 'Port (valgfrit)',
'DbPortDesc'					=> 'The port number your database server is accessible through, leave it blank to use the default port number.',
'DbName'						=> 'Database Navn',
'DbNameDesc'					=> 'The database WackoWiki should use. This database needs to exist already once you continue!',
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
'ErrorDeletingTable'			=> 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
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
'SecurityRisk'					=> 'You are advised to remove write access to %1 again now that it\'s been written. Leaving the file writable can be a security risk!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'Du bør slette mappen %1 nu, hvor installationsprocessen er gennemført.',
'ErrorGivePrivileges'			=> 'The configuration file %1 could not be written. You will need to give your web server temporary write access to either your WackoWiki directory, or a blank file called %1<br>%2<br><br>Don\'t forget to remove write access again later, i.e.<br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Hvis du af en eller anden grund ikke kan gøre dette, du skal kopiere teksten nedenfor til en ny fil og gemme/uploade den som %1 i WackoWiki-mappen. Når du har gjort dette, bør dit WackoWiki websted fungere. Hvis ikke, bedes du besøge <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Når du har gjort dette, bør dit WackoWiki websted fungere. Hvis ikke, bedes du besøge <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'skrevet den ',
'DontChange'					=> 'ændrer ikke wacko_version manuelt!',
'ConfigDescription'				=> 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Prøv igen',

];
