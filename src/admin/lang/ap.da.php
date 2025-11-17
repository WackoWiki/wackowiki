<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Grundlæggende funktioner',
		'preferences'	=> 'Præferencer',
		'content'		=> 'Indhold',
		'users'			=> 'Brugere',
		'maintenance'	=> 'Vedligeholdelse',
		'messages'		=> 'Beskeder',
		'extension'		=> 'Udvidelse',
		'database'		=> 'Database',
	],

	// Admin panel
	'AdminPanel'				=> 'Administratorkontrolpanel',
	'RecoveryMode'				=> 'Gendannelsestilstand',
	'Authorization'				=> 'Tilladelse',
	'AuthorizationTip'			=> 'Indtast venligst den administrative adgangskode (sørg for, at cookies er tilladt i din browser).',
	'NoRecoveryPassword'		=> 'Den administrative adgangskode er ikke angivet!',
	'NoRecoveryPasswordTip'		=> 'Bemærk: Fraværet af en administrativ adgangskode er en trussel mod sikkerheden! Indtast dit password-hash i konfigurationsfilen, og kør programmet igen.',

	'ErrorLoadingModule'		=> 'Fejl ved indlæsning af admin modul %1: eksisterer ikke.',

	'ApHomePage'				=> 'Startside',
	'ApHomePageTip'				=> 'open the home page, you do not quit administration',
	'ApLogOut'					=> 'Log af',
	'ApLogOutTip'				=> 'Afslut systemadministration og log ud af webstedet',

	'TimeLeft'					=> 'Tid tilbage:  %1 minut(ter)',
	'ApVersion'					=> 'version',

	'SiteOpen'					=> 'Åbn',
	'SiteOpened'				=> 'site åbnet',
	'SiteOpenedTip'				=> 'Webstedet er åbent',
	'SiteClose'					=> 'Luk',
	'SiteClosed'				=> 'site lukket',
	'SiteClosedTip'				=> 'Webstedet er lukket',

	'System'					=> 'System',

	// Generic
	'Cancel'					=> 'Fortryd',
	'Add'						=> 'Tilføj',
	'Edit'						=> 'Rediger',
	'Remove'					=> 'Fjern',
	'Enabled'					=> 'Aktiveret',
	'Disabled'					=> 'Deaktiveret',
	'Mandatory'					=> 'Obligatorisk',
	'Admin'						=> 'Administrator',
	'Min'						=> 'Min.',
	'Max'						=> 'Maks.',

	'MiscellaneousSection'		=> 'Diverse',
	'MainSection'				=> 'Generelle Indstillinger',

	'DirNotWritable'			=> 'Mappen %1 er ikke skrivbar.',
	'FileNotWritable'			=> 'Filen %1 er ikke skrivbar.',

	/**
	 * AP MENU
	 *
	 *	'module_name'		=> [
	 *		'name'		=> 'Module name',
	 *		'title'		=> 'Module title',
	 *	],
	 */

	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Grundlæggende',
		'title'		=> 'Grundlæggende indstillinger',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Udseende',
		'title'		=> 'Indstillinger for udseende',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-mail',
		'title'		=> 'Email indstillinger',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Syndikering',
		'title'		=> 'Syndikering indstillinger',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtrer',
		'title'		=> 'Filtrer indstillinger',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'Formatering indstillinger',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Underretninger',
		'title'		=> 'Indstillinger for notifikationer',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Sider',
		'title'		=> 'Sider og site parametre',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Rediger tilladelser',
		'title'		=> 'Indstillinger for tilladelser',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Sikkerhed',
		'title'		=> 'Indstillinger for sikkerhedsdelsystemer',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'System',
		'title'		=> 'System indstillinger',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Fortsæt',
		'title'		=> 'Indstillinger for vedhæftning',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Slettet',
		'title'		=> 'Nyligt slettet indhold',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Tilføj, rediger eller fjern standard menupunkter',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Sikkerhedskopi',
		'title'		=> 'Sikkerhedskopierer data',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Reparer',
		'title'		=> 'Reparér og optimer database',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Gendan',
		'title'		=> 'Gendanner sikkerhedskopieringsdata',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Hovedmenu',
		'title'		=> 'WackoWiki Administration',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Uoverensstemmelser',
		'title'		=> 'Fastsættelse Af Data Uoverensstemmelser',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Data Synkronisering',
		'title'		=> 'Synkroniserer data',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Masse e-mail',
		'title'		=> 'Masse e-mail',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'System besked',
		'title'		=> 'System beskeder',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'System Info',
		'title'		=> 'System Information',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System log',
		'title'		=> 'Logning af systemhændelser',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistik',
		'title'		=> 'Vis statistik',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Dårlig Opførsel',
		'title'		=> 'Dårlig Opførsel',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Godkend',
		'title'		=> 'Bruger registrering godkendelse',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Grupper',
		'title'		=> 'Håndtering af grupper',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Brugere',
		'title'		=> 'Bruger håndtering',
	],

	// Main module
	'MainNote'					=> 'Bemærk: Det anbefales, at adgangen til webstedet midlertidigt blokeres for administrativ vedligeholdelse.',

	'PurgeSessions'				=> 'Rense',
	'PurgeSessionsTip'			=> 'Ryd alle sessioner',
	'PurgeSessionsConfirm'		=> 'Er du sikker på, at du vil rense alle sessioner? Dette vil logge alle brugere ud.',
	'PurgeSessionsExplain'		=> 'Ryd alle sessioner. Dette vil logge ud af alle brugere ved at trunkere auth_token tabellen.',
	'PurgeSessionsDone'			=> 'Sessioner ryddet op.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Opdaterede grundlæggende indstillinger',
	'LogBasicSettingsUpdated'	=> 'Opdaterede grundlæggende indstillinger',

	'SiteName'					=> 'Site navn:',
	'SiteNameInfo'				=> 'Titlen på dette site. Vises på browsertitel, tema header, e-mail notifikation, etc.',
	'SiteDesc'					=> 'Site Description:',
	'SiteDescInfo'				=> 'Supplement til titlen på det websted, der vises i siderne header. Forklarer, med et par ord, hvad dette websted handler om.',
	'AdminName'					=> 'Admin of Site:',
	'AdminNameInfo'				=> 'Brugernavnet på den person, der er ansvarlig for den samlede støtte på webstedet. Dette navn bruges ikke til at afgøre adgangsrettigheder men det er ønskeligt, at det er i overensstemmelse med navnet på den ledende administrator af webstedet.',

	'LanguageSection'			=> 'Sprog',
	'DefaultLanguage'			=> 'Standard sprog:',
	'DefaultLanguageInfo'		=> 'Angiver sproget for beskeder, der vises til uregistrerede gæster, samt lokalindstillingerne.',
	'MultiLanguage'				=> 'Multilanguage støtte:',
	'MultiLanguageInfo'			=> 'Aktiver muligheden for at vælge et sprog på en side-for-side.',
	'AllowedLanguages'			=> 'Tilladte sprog:',
	'AllowedLanguagesInfo'		=> 'Det anbefales, at du kun vælger det sæt sprog, du ønsker at bruge, ellers er alle sprog valgt.',

	'CommentSection'			=> 'Kommentarer',
	'AllowComments'				=> 'Tillad kommentarer:',
	'AllowCommentsInfo'			=> 'Aktiver kun kommentarer for gæster eller registrerede brugere, eller deaktiver dem på hele webstedet.',
	'SortingComments'			=> 'Sortering af kommentarer:',
	'SortingCommentsInfo'		=> 'Ændrer rækkefølgen på siden kommentarerne er præsenteret, enten med den seneste ELLER den ældste kommentar øverst.',
	'CommentsOffset'			=> 'Kommentarer side:',
	'CommentsOffsetInfo'		=> 'Kommentarside skal vises som standard',

	'ToolbarSection'			=> 'Værktøjslinje',
	'CommentsPanel'				=> 'Kommentarer panel:',
	'CommentsPanelInfo'			=> 'Standard visningen af kommentarer nederst på siden.',
	'FilePanel'					=> 'Fil panel:',
	'FilePanelInfo'				=> 'Standard visningen af vedhæftede filer nederst på siden.',
	'TagsPanel'					=> 'Tags panel:',
	'TagsPanelInfo'				=> 'Standard visningen af tag-panelet nederst på siden.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Vis permalink:',
	'ShowPermalinkInfo'			=> 'Standardvisningen af permalink for den aktuelle version af siden.',
	'TocPanel'					=> 'Tabel med indholdspanel:',
	'TocPanelInfo'				=> 'Standard visningstabel for indholdspanel på en side (kan kræve understøttelse i skabelonerne).',
	'SectionsPanel'				=> 'Sektioner panel:',
	'SectionsPanelInfo'			=> 'Vis som standard panelet af tilstødende sider (kræver understøttelse i skabelonerne).',
	'DisplayingSections'		=> 'Viser sektioner:',
	'DisplayingSectionsInfo'	=> 'Når de tidligere indstillinger er indstillet, om kun at vise undersider af side (<em>lavere</em>), kun nabo (<em>top</em>), begge eller andre (<em>træ</em>).',
	'MenuItems'					=> 'Menupunkter:',
	'MenuItemsInfo'				=> 'Standard antal viste menupunkter (kan kræve understøttelse i skabelonerne).',

	'HandlerSection'			=> 'Handler',
	'HideRevisions'				=> 'Skjul revisioner:',
	'HideRevisionsInfo'			=> 'Standard visningen af revisioner af siden.',
	'AttachmentHandler'			=> 'Aktiver håndtering af vedhæftede filer:',
	'AttachmentHandlerInfo'		=> 'Tillader visning af vedhæftede filer handler.',
	'SourceHandler'				=> 'Aktivér kildehåndtering:',
	'SourceHandlerInfo'			=> 'Tillader visning af kilden behandler.',
	'ExportHandler'				=> 'Aktiver XML- eksporthåndtering:',
	'ExportHandlerInfo'			=> 'Tillader visning af XML- eksportbehandleren.',

	'DiffModeSection'			=> 'Forskellige Tilstande',
	'DefaultDiffModeSetting'	=> 'Standard diff-tilstand:',
	'DefaultDiffModeSettingInfo'=> 'Forvalgt diff- tilstand.',
	'AllowedDiffMode'			=> 'Tilladte diff-tilstande:',
	'AllowedDiffModeInfo'		=> 'Det anbefales kun at vælge det sæt af diff-tilstande du vil bruge, ellers er alle diff-tilstande valgt.',
	'NotifyDiffMode'			=> 'Underret diff- tilstand:',
	'NotifyDiffModeInfo'		=> 'Diff mode bruges til meddelelser i e-mail-krop.',

	'EditingSection'			=> 'Redigering',
	'EditSummary'				=> 'Opsummér redigering:',
	'EditSummaryInfo'			=> 'Viser ændringsoversigt i redigeringstilstand.',
	'MinorEdit'					=> 'Mindre redigere:',
	'MinorEditInfo'				=> 'Aktiverer mindre redigeringsindstilling i redigeringstilstand.',
	'SectionEdit'				=> 'Afsnit redigere:',
	'SectionEditInfo'			=> 'Gør det muligt kun at redigere et afsnit af en side.',
	'ReviewSettings'			=> 'Gennemgå:',
	'ReviewSettingsInfo'		=> 'Aktiverer mulighed for gennemgang i redigeringstilstand.',
	'PublishAnonymously'		=> 'Tillad anonym publicering:',
	'PublishAnonymouslyInfo'	=> 'Tillad brugere at publicere anonymt (for at skjule navnet).',

	'DefaultRenameRedirect'		=> 'Opret omdirigering ved omdøbning:',
	'DefaultRenameRedirectInfo'	=> 'Tilbyd som standard at indstille en omdirigering til den gamle adresse på den side, der omdøbes.',
	'StoreDeletedPages'			=> 'Behold slettede sider:',
	'StoreDeletedPagesInfo'		=> 'Når du sletter en side, en kommentar eller en fil, opbevar den i en særlig sektion, hvor den vil være til rådighed for fornyet undersøgelse og nyttiggørelse i en vis periode (som beskrevet nedenfor).',
	'KeepDeletedTime'			=> 'Opbevaringstid på slettede sider:',
	'KeepDeletedTimeInfo'		=> 'Perioden i dage. Det giver mening kun med den tidligere mulighed. Brug nul for at sikre, at enheder aldrig slettes (i dette tilfælde kan administratoren rydde "kurven" manuelt).',
	'PagesPurgeTime'			=> 'Opbevaringstid for siderevisioner:',
	'PagesPurgeTimeInfo'		=> 'Slet automatisk de ældre versioner inden for det givne antal dage. Hvis du indtaster nul, fjernes de ældre versioner.',
	'EnableReferrers'			=> 'Aktiver henvisninger:',
	'EnableReferrersInfo'		=> 'Tillader oprettelse og visning af eksterne henvisninger.',
	'ReferrersPurgeTime'		=> 'Opbevaringstid for henviserede:',
	'ReferrersPurgeTimeInfo'	=> 'Opbevar historien om henvisning til eksterne sider ikke længere end et givet antal dage. Nul betyder evig lagring, men for et aktivt besøgt websted kan dette føre til databaseoverløb.',
	'EnableCounters'			=> 'Hit Counters:',
	'EnableCountersInfo'		=> 'Tillader per side hit tællere og muliggør visning af simpel statistik. Visninger af sideejeren er ikke medregnet.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Kontroller standard web syndikering indstillinger for dit websted.',
	'SyndicationSettingsUpdated'	=> 'Opdaterede syndikeringsindstillinger.',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Aktiver feeds:',
	'EnableFeedsInfo'			=> 'Slår RSS-feeds til eller fra for hele wikien.',
	'XmlChangeLink'				=> 'Ændrer feed link tilstand:',
	'XmlChangeLinkInfo'			=> 'Definerer hvor XML-ændringer feed elementer linkes til.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'liste over forskelle',
		'2'		=> 'den nuværende side',
		'3'		=> 'liste over revideringer',
		'4'		=> 'den reviderede side',
	],

	'XmlSitemap'				=> 'XML Sitemap:',
	'XmlSitemapInfo'			=> 'Opretter en XML-fil kaldet %1 inde i XML-mappen. Du kan tilføje stien til sitemap i robots.txt filen i din rodmappe som følger:',
	'XmlSitemapGz'				=> 'XML- sitemap komprimering:',
	'XmlSitemapGzInfo'			=> 'Hvis du ønsker det, kan du komprimere din sitemap tekstfil ved hjælp af gzip til at reducere din båndbredde krav.',
	'XmlSitemapTime'			=> 'XML- sitemap genereringstid:',
	'XmlSitemapTimeInfo'		=> 'Genererer sitemap kun én gang i det givne antal dage, nul betyder ved hver sideændring.',

	'SearchSection'				=> 'Søg',
	'OpenSearch'				=> 'Åbensøg:',
	'OpenSearchInfo'			=> 'Opretter OpenSearch-beskrivelsesfilen i XML-mappen og aktiverer Autodiscovery of search plugin i HTML-headeren.',
	'SearchEngineVisibility'	=> 'Bloker søgemaskiner (søgemaskine synlighed):',
	'SearchEngineVisibilityInfo'=> 'Blokér søgemaskiner, men tillad normale besøgende. Tilsidesætter sideindstillinger. <br>Afvis søgemaskiner fra at indeksere dette websted. Det er op til søgemaskiner at honorere denne anmodning.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Kontroller standard display indstillinger for dit websted.',
	'AppearanceSettingsUpdated'	=> 'Opdaterede indstillinger for udseende.',

	'LogoOff'					=> 'Af',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo og titel',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Site Logo:',
	'SiteLogoInfo'				=> 'Dit logo vises typisk øverst til venstre i applikationen. Max størrelse er 2 MiB. Optimale dimensioner er 255 pixels bred med 55 pixels høj.',
	'LogoDimensions'			=> 'Logo dimensioner:',
	'LogoDimensionsInfo'		=> 'Bredde og højde af det viste logo.',
	'LogoDisplayMode'			=> 'Logo visningstilstand:',
	'LogoDisplayModeInfo'		=> 'Definerer udseendet af logoet. Standard er deaktiveret.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site Favicon:',
	'SiteFaviconInfo'			=> 'Din genvejsikon, eller favicon, vises i adresselinjen, faneblade og bogmærker for de fleste browsere. Dette vil tilsidesætte favicon for dit tema.',
	'SiteFaviconTooBig'			=> 'Favicon er større end 64 × 64px.',
	'ThemeColor'				=> 'Temafarve for adresselinjen:',
	'ThemeColorInfo'			=> 'Browseren indstiller farven på adresselinjen på hver side i overensstemmelse med den angivne CSS-farve.',

	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Tema:',
	'ThemeInfo'					=> 'Skabelon design webstedet bruger som standard.',
	'ResetUserTheme'			=> 'Nulstil alle brugertemaer:',
	'ResetUserThemeInfo'		=> 'Nulstiller alle brugertemaer. Advarsel: Denne handling vil returnere alle brugervalgte temaer til det globale standardtema.',
	'SetBackUserTheme'			=> 'Gendan alle brugertemaer til %1 -tema.',
	'ThemesAllowed'				=> 'Tilladte Temaer:',
	'ThemesAllowedInfo'			=> 'Vælg de tilladte temaer, som brugeren kan vælge; ellers er alle tilgængelige temaer tilladt.',
	'ThemesPerPage'				=> 'Temaer pr. side:',
	'ThemesPerPageInfo'			=> 'Tillad temaer pr. side, som sideejeren kan vælge via sideegenskaber.',

	// System settings
	'SystemSettingsInfo'		=> 'Gruppe af parametre, der er ansvarlige for finjustering af webstedet. Ændr dem ikke, medmindre du er sikker på deres handlinger.',
	'SystemSettingsUpdated'		=> 'Opdaterede systemindstillinger',

	'DebugModeSection'			=> 'Debug mode',
	'DebugMode'					=> 'Fejlfindingstilstand:',
	'DebugModeInfo'				=> 'Udpakker og udsender telemetri data om programmets udførelsestid. Opmærksomhed: Fuldstændig detaljetilstand stiller højere krav til den tildelte hukommelse, især til ressourceintensive operationer, såsom database backup og gendannelse.',
	'DebugModes'	=> [
		'0'		=> 'fejlfinding er slået fra',
		'1'		=> 'kun den samlede udførelsestid',
		'2'		=> 'fuldtid',
		'3'		=> 'fuld detalje (DBMS, cache, osv.)',
	],
	'DebugSqlThreshold'			=> 'Grænseværdi ydeevne RDBMS:',
	'DebugSqlThresholdInfo'		=> 'I detaljeret fejlfindingstilstand, rapporteres kun de forespørgsler, der tager længere end antallet af sekunder angivet.',
	'DebugAdminOnly'			=> 'Lukket diagnose:',
	'DebugAdminOnlyInfo'		=> 'Vis kun fejlretningsdata for programmet (og DBMS) for administratoren.',

	'CachingSection'			=> 'Cachelagring Indstillinger',
	'Cache'						=> 'Cache gengivne sider:',
	'CacheInfo'					=> 'Gem renderede sider i den lokale cache for at fremskynde den efterfølgende opstart. Gyldig kun for uregistrerede besøgende.',
	'CacheTtl'					=> 'Term relevance cached pages:',
	'CacheTtlInfo'				=> 'Cache sider ikke mere end et bestemt antal sekunder.',
	'CacheSql'					=> 'Cache DBMS forespørgsler:',
	'CacheSqlInfo'				=> 'Opretholde en lokal cache af resultaterne af visse ressource-relaterede SQL-forespørgsler.',
	'CacheSqlTtl'				=> 'Time-to-live for cachelagrede SQL-forespørgsler:',
	'CacheSqlTtlInfo'			=> 'Cache resultater af SQL forespørgsler i ikke mere end det angivne antal sekunder. Værdier større end 1200 er ikke ønskeligt.',

	'LogSection'				=> 'Logindstillinger',
	'LogLevelUsage'				=> 'Brug logning:',
	'LogLevelUsageInfo'			=> 'Minimumsprioriteten for de begivenheder, der er registreret i loggen.',
	'LogThresholds'	=> [
		'0'		=> 'opbevar ikke en journal',
		'1'		=> 'kun det kritiske niveau',
		'2'		=> 'fra højeste niveau',
		'3'		=> 'fra høj',
		'4'		=> 'i gennemsnit',
		'5'		=> 'fra lav',
		'6'		=> 'minimumsniveauet',
		'7'		=> 'optag alle',
	],
	'LogDefaultShow'			=> 'Vis log tilstand:',
	'LogDefaultShowInfo'		=> 'Den mindste prioritet begivenheder vises i loggen som standard.',
	'LogModes'	=> [
		'1'		=> 'kun det kritiske niveau',
		'2'		=> 'fra højeste niveau',
		'3'		=> 'fra højt niveau',
		'4'		=> 'gennemsnittet',
		'5'		=> 'fra en lav',
		'6'		=> 'fra minimumsniveauet',
		'7'		=> 'vis alle',
	],
	'LogPurgeTime'				=> 'Opbevaringstid for log:',
	'LogPurgeTimeInfo'			=> 'Fjern begivenhedslog efter det angivne antal dage.',

	'PrivacySection'			=> 'Privatliv',
	'AnonymizeIp'				=> 'Anonymisér brugernes IP-adresser:',
	'AnonymizeIpInfo'			=> 'Anonymiser IP-adresser, hvor det er relevant (dvs. side, revision eller henvisninger).',

	'ReverseProxySection'		=> 'Omvendt Proxy',
	'ReverseProxy'				=> 'Brug omvendt proxy:',
	'ReverseProxyInfo'			=> 'Aktiver denne indstilling for at bestemme den korrekte IP-adresse for fjernklienten
									ved at undersøge oplysninger, der er gemt i X-Forwarded-For-headerne. X-Forwarded-For-headere
									er en standardmekanisme til identifikation af klientsystemer, der opretter forbindelse via en
									reverse proxyserver, f.eks. Squid eller Pound. Reverse proxyservere bruges ofte til at forbedre
									ydeevnen på meget besøgte websteder og kan også give andre fordele i forbindelse med caching,
									sikkerhed eller kryptering af websteder. Hvis denne WackoWiki-installation opererer bag en
									reverse proxy, bør denne indstilling aktiveres, så korrekte IP-adresseoplysninger opfanges
									i WackoWikis systemer til sessionshåndtering, logning, statistik og adgangsstyring;
									hvis du er usikker på denne indstilling, ikke har en reverse proxy, eller WackoWiki opererer
									i et delt hostingmiljø, bør denne indstilling forblive deaktiveret.',
	'ReverseProxyHeader'		=> 'Omvendt proxy header:',
	'ReverseProxyHeaderInfo'	=> 'Indstil denne værdi, hvis din proxyserver sender klient-IP i en anden header
									end X-Forwarded-For. "X-Forwarded-For"-headeren er en liste af IP-adresser adskilt af
									kommaer og mellemrum, og kun den sidste (den længst til venstre) vil blive brugt.',
	'ReverseProxyAddresses'		=> 'reverse_proxy accepterer en række IP-adresser:',
	'ReverseProxyAddressesInfo'	=> 'Hvert element i dette array er IP-adressen på en hvilken som helst af jeres omvendte
									 ØGELØBEDØBEDØRTE proxies. Hvis du bruger dette array, WackoWiki vil stole på de oplysninger, der er lagret
									 Øjeblikkelig - autentisk - i de X-Forwarded-For overskrifter kun hvis Remote IP-adressen er en af
									 Øjeblikkelig, Det vil sige, at anmodningen når webserveren fra en af dine
									 Øjeblikkelige proxies. Ellers, klienten kunne direkte oprette forbindelse til
									 ØJEDES Øjeblikkelige din webserver ved at spoofing X-Forwarded-For overskrifter.',

	'SessionSection'				=> 'Session Håndtering',
	'SessionStorage'				=> 'Session lagring:',
	'SessionStorageInfo'			=> 'Dette tilvalg definerer hvor sessionsdata gemmes. Som standard vælges enten fil- eller databasesessionslagring.',
	'SessionModes'	=> [
		'1'		=> 'Fil',
		'2'		=> 'Database',
	],
	'SessionNotice'					=> 'Vis årsagen til afslutning af sessionen:',
	'SessionNoticeInfo'				=> 'Angiver årsagen til, at sessionen er blevet afbrudt.',
	'LoginNotice'					=> 'Login-meddelelse:',
	'LoginNoticeInfo'				=> 'Viser en login-meddelelse.',

	'RewriteMode'					=> 'Brug <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Hvis din webserver understøtter denne funktion, skal du aktivere for at "forskønne" sidens URL\'er.<br>
  <span class="cite">Værdien kan blive overskrevet af klassen Indstillinger under kørsel, uanset om den er slået fra, hvis HTTP_MOD_REWRITE er slået til.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parametre, der er ansvarlige for adgangskontrol og tilladelser.',
	'PermissionsSettingsUpdated'	=> 'Opdaterede tilladelsesindstillinger',

	'PermissionsSection'		=> 'Rights and privileges',
	'ReadRights'				=> 'Læs rettigheder som standard:',
	'ReadRightsInfo'			=> 'Standard tildelt til de oprettede rodsider, samt sider, for hvilke overordnede ACL\'er ikke kan defineres.',
	'WriteRights'				=> 'Skriv rettigheder som standard:',
	'WriteRightsInfo'			=> 'Standard tildelt til de oprettede rodsider, samt sider, for hvilke overordnede ACL\'er ikke kan defineres.',
	'CommentRights'				=> 'Kommentar rettigheder som standard:',
	'CommentRightsInfo'			=> 'Standard tildelt til de oprettede rodsider, samt sider, for hvilke overordnede ACL\'er ikke kan defineres.',
	'CreateRights'				=> 'Opret rettigheder for en underside som standard:',
	'CreateRightsInfo'			=> 'Standard tildelt til de oprettede undersider.',
	'UploadRights'				=> 'Upload rettigheder som standard:',
	'UploadRightsInfo'			=> 'Standard upload rettigheder.',
	'RenameRights'				=> 'Globalt omdøb højre:',
	'RenameRightsInfo'			=> 'Listen over tilladelser til frit at omdøbe (flytte) sider.',

	'LockAcl'					=> 'Lås alle ACL\'er for kun at læse:',
	'LockAclInfo'				=> '<span class="cite">Overskriver ACL indstillingerne for alle sider til kun at læse.</span><br>Dette kan være nyttigt, hvis et projekt er færdigt, du ønsker tæt redigering for en periode af sikkerhedsmæssige årsager eller som en nødreaktion på en udnyttelse eller sårbarhed.',
	'HideLocked'				=> 'Skjul utilgængelige sider:',
	'HideLockedInfo'			=> 'Hvis brugeren ikke har tilladelse til at læse siden, skjule det i forskellige sidelister (linket placeret i tekst vil dog stadig være synligt).',
	'RemoveOnlyAdmins'			=> 'Kun administratorer kan slette sider:',
	'RemoveOnlyAdminsInfo'		=> 'Afvis alle, undtagen administratorer, muligheden for at slette sider. Den første grænse gælder for ejere af normale sider.',
	'OwnersRemoveComments'		=> 'Ejere af sider kan slette kommentarer:',
	'OwnersRemoveCommentsInfo'	=> 'Tillad sideejere at moderere kommentarer på deres sider.',
	'OwnersEditCategories'		=> 'Ejere kan redigere sidekategorier:',
	'OwnersEditCategoriesInfo'	=> 'Tillad ejere at ændre siders kategori liste over dit websted (tilføj ord, slet ord), tildeler en side.',
	'TermHumanModeration'		=> 'Udløb af moderation hos mennesker:',
	'TermHumanModerationInfo'	=> 'Moderatorer kan kun redigere kommentarer, hvis de ikke blev oprettet mere end dette antal dage siden (denne begrænsning gælder ikke for den sidste kommentar i emnet).',

	'UserCanDeleteAccount'		=> 'Brugererne kan selv slette deres konti',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parametre, der er ansvarlige for platformens overordnede sikkerhed, sikkerhedsbegrænsninger og yderligere sikkerhedsdelsystemer.',
	'SecuritySettingsUpdated'	=> 'Opdaterede sikkerhedsindstillinger',

	'AllowRegistration'			=> 'Registrer online:',
	'AllowRegistrationInfo'		=> 'Åben brugerregistrering. Deaktivering af denne mulighed forhindrer gratis registrering, men webstedsadministratoren kan selv registrere andre brugere.',
	'ApproveNewUser'			=> 'Godkend nye brugere:',
	'ApproveNewUserInfo'		=> 'Tillader administratorer at godkende brugere når de er registreret. Kun godkendte brugere vil få lov til at logge ind på webstedet.',
	'PersistentCookies'			=> 'Vedvarende cookies:',
	'PersistentCookiesInfo'		=> 'Tillad vedvarende cookies.',
	'DisableWikiName'			=> 'Deaktivér WikiName:',
	'DisableWikiNameInfo'		=> 'Deaktiver den obligatoriske brug af en WikiName for brugere. Tillader brugerregistrering med traditionelle kaldenavne i stedet for tvungen CamelCase-formateret navne (dvs. NavnEfternavn).',
	'UsernameLength'			=> 'Brugernavn længde:',
	'UsernameLengthInfo'		=> 'Minimum og maksimum antal tegn i brugernavne.',

	'EmailSection'				=> 'E-mail',
	'AllowEmailReuse'			=> 'Tillad genbrug af e-mailadresse:',
	'AllowEmailReuseInfo'		=> 'Forskellige brugere kan registrere sig med den samme e-mail-adresse.',
	'EmailConfirmation'			=> 'Gennemtving e-mail-bekræftelse:',
	'EmailConfirmationInfo'		=> 'Kræver, at brugeren verificerer sin e-mailadresse, før han kan logge ind.',
	'AllowedEmailDomains'		=> 'Tilladte e-mail-domæner:',
	'AllowedEmailDomainsInfo'	=> 'Tilladte e-mail-domæner kommasepareret, f.eks. <code>example.com, local.lan</code> etc., ellers er alle e-mail-domæner tilladt.',
	'ForbiddenEmailDomains'		=> 'Forbudte e-mail-domæner:',
	'ForbiddenEmailDomainsInfo'	=> 'Forbudte e-mail-domæner kommasepareret, f.eks. <code>example.com, local.lan</code> osv. (kun effektiv, hvis listen over tilladte e-mail-domæner er tom)',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Aktiver captcha:',
	'EnableCaptchaInfo'			=> 'Hvis aktiveret, vil captcha blive vist i følgende tilfælde, eller hvis en sikkerhedstærskel er nået.',
	'CaptchaComment'			=> 'Ny kommentar:',
	'CaptchaCommentInfo'		=> 'Da beskyttelse mod spam skal uregistrerede brugere udfylde captcha før kommentarer vil blive sendt.',
	'CaptchaPage'				=> 'Ny side:',
	'CaptchaPageInfo'			=> 'Som beskyttelse mod spam skal uregistrerede brugere udfylde captcha før du opretter en ny side.',
	'CaptchaEdit'				=> 'Rediger side:',
	'CaptchaEditInfo'			=> 'Som beskyttelse mod spam skal uregistrerede brugere udfylde captcha før redigering sider.',
	'CaptchaRegistration'		=> 'Registrering:',
	'CaptchaRegistrationInfo'	=> 'Som beskyttelse mod spam skal uregistrerede brugere udfylde captcha før registrering.',

	'TlsSection'				=> 'TLS Indstillinger',
	'TlsConnection'				=> 'TLS- forbindelse:',
	'TlsConnectionInfo'			=> 'Brug TLS-sikret forbindelse. <span class="cite">Aktiver det forudinstallerede TLS-certifikat på serveren, ellers mister du adgang til admin-panelet!</span><br>Det afgør også, om Cookie Secure Flag er indstillet: <code>sikker</code> markering angiver, om cookies kun skal sendes over sikre forbindelser.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Forstærket genforbinde klienten fra HTTP til HTTPS. Med indstillingen deaktiveret, kan klienten gennemse webstedet gennem en åben HTTP-kanal.',

	'HttpSecurityHeaders'		=> 'Http Sikkerheds Headers',
	'EnableSecurityHeaders'		=> 'Aktiver sikkerheds headers:',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP kan forårsage problemer i visse situationer (f.eks. under udvikling), eller når du bruger plugins, der er afhængige af eksternt hostede ressourcer såsom billeder eller scripts. <br>Deaktivering af indholdssikkerhedspolitik er en sikkerhedsrisiko!',
	'Csp'						=> 'Content-Security-Policy (CSP):',
	'CspInfo'					=> 'Konfigurering af CSP indebærer at beslutte, hvilke politikker du ønsker at håndhæve, og derefter konfigurere dem og bruge Content-Security-Policy til at etablere din politik.',
	'PolicyModes'	=> [
		'0'		=> 'deaktiveret',
		'1'		=> 'streng',
		'2'		=> 'brugerdefineret',
	],
	'PermissionsPolicy'			=> 'Permissions Policy:',
	'PermissionsPolicyInfo'		=> 'HTTP Permissions-Policy-headeren giver en mekanisme til eksplicit at aktivere eller deaktivere forskellige effektive browserfunktioner.',
	'ReferrerPolicy'			=> 'Referrer Policy:',
	'ReferrerPolicyInfo'		=> 'Referrer-Policy HTTP header regulerer, hvilke referrer oplysninger, der sendes i Referer header, bør indgå i svar.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-nedgradering',
		'3'		=> 'samme oprindelse',
		'4'		=> 'oprindelse',
		'5'		=> 'strikt-oprindelse',
		'6'		=> 'oprindelse-when-cross-origin',
		'7'		=> 'strikt-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> 'Persistens af brugeradgangskoder',
	'PwdMinChars'				=> 'Mindste adgangskodelængde:',
	'PwdMinCharsInfo'			=> 'Længere adgangskoder er nødvendigvis mere sikre end kortere adgangskoder (f.eks. 12 til 16 tegn).<br>Brug af adgangskoder i stedet for adgangskoder opmuntres.',
	'AdminPwdMinChars'			=> 'Minimum admin adgangskode længde:',
	'AdminPwdMinCharsInfo'		=> 'Længere adgangskoder er nødvendigvis mere sikre end kortere adgangskoder (f.eks. 15 til 20 tegn).<br>Brug af adgangskoder i stedet for adgangskoder opmuntres.',
	'PwdCharComplexity'			=> 'Den påkrævede adgangskode kompleksitet:',
	'PwdCharClasses'	=> [
		'0'		=> 'ikke testet',
		'1'		=> 'alle bogstaver + tal',
		'2'		=> 'store og små bogstaver + tal',
		'3'		=> 'store og små bogstaver + tal + tegn',
	],
	'PwdUnlikeLogin'			=> 'Yderligere komplikation:',
	'PwdUnlikes'	=> [
		'0'		=> 'ikke testet',
		'1'		=> 'adgangskode er ikke identisk med login',
		'2'		=> 'adgangskode indeholder ikke brugernavn',
	],

	'LoginSection'				=> 'Log ind',
	'MaxLoginAttempts'			=> 'Maksimalt antal login-forsøg pr. brugernavn:',
	'MaxLoginAttemptsInfo'		=> 'Antallet af login forsøg tilladt for en enkelt konto, før anti-spambot opgaven udløses. Indtast 0 for at forhindre anti-spambot-opgaven i at blive udløst for særskilte brugerkonti.',
	'IpLoginLimitMax'			=> 'Maksimalt antal login-forsøg pr. IP-adresse:',
	'IpLoginLimitMaxInfo'		=> 'Tærsklen for loginforsøg tilladt fra en enkelt IP-adresse før en anti-spambot opgave udløses. Indtast 0 for at forhindre anti-spambot-opgaven i at blive udløst af IP-adresser.',

	'FormsSection'				=> 'Formularer',
	'FormTokenTime'				=> 'Maksimal tid til at indsende formularer:',
	'FormTokenTimeInfo'			=> 'Den tid, en bruger skal indsende en formular (i sekunder). <br> Bemærk, at en formular kan blive ugyldig, hvis sessionen udløber, uanset denne indstilling.',

	'SessionLength'				=> 'Session cookie udløb:',
	'SessionLengthInfo'			=> 'Levetiden for brugersessions cookie som standard (i dage).',
	'CommentDelay'				=> 'Anti-oversvømmelse for kommentarer:',
	'CommentDelayInfo'			=> 'Den mindste forsinkelse mellem offentliggørelsen af nye brugerkommentarer (i sekunder).',
	'IntercomDelay'				=> 'Anti-oversvømmelse til personlig kommunikation:',
	'IntercomDelayInfo'			=> 'Den mindste forsinkelse mellem afsendelse af private beskeder (i sekunder).',
	'RegistrationDelay'			=> 'Tidsfrist for registrering:',
	'RegistrationDelayInfo'		=> 'Minimumstærsklen mellem tilmeldingsblanketten for at modvirke tilmeldings-robotter (i sekunder).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Gruppe af parametre, der er ansvarlige for finjustering af webstedet. Ændr dem ikke, medmindre du er sikker på deres handlinger.',
	'FormatterSettingsUpdated'	=> 'Opdaterede formateringsindstillinger',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> 'Typografisk korrekturlæser:',
	'TypograficaInfo'			=> 'Deaktivering af denne indstilling vil fremskynde processen med at tilføje kommentarer og gemme sider.',
	'Paragrafica'				=> 'Paragrafica markeringer:',
	'ParagraficaInfo'			=> 'Svarende til den tidligere mulighed, men vil føre til afbrydelse af inoperable automatisk indholdsfortegnelse (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Global HTML Support:',
	'AllowRawhtmlInfo'			=> 'Denne indstilling er potentielt usikker for et åbent websted.',
	'SafeHtml'					=> 'Filtrering HTML:',
	'SafeHtmlInfo'				=> 'Forhindrer lagring af farlige HTML-objekter. At slukke for filteret på et åbent websted med HTML-understøttelse er <span class="underline">ekstremt</span> uønskeligt!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formater)',
	'X11colors'					=> 'X11 farveforbrug:',
	'X11colorsInfo'				=> 'Udvider de tilgængelige farver til <code>??(farve) baggrund??</code> og <code>!!(farve) tekst!!</code>Deaktivering af denne indstilling fremskynder processen med at tilføje kommentarer og gemme sider.',
	'WikiLinks'					=> 'Deaktiver wiki-links:',
	'WikiLinksInfo'				=> 'Deaktiverer linking for <code>CamelCaseWords</code>, dine CamelCase Words vil ikke længere blive linket direkte til en ny side. Dette er nyttigt, når du arbejder på tværs af forskellige namespaces aks klynger. Som standard er den slået fra.',
	'BracketsLinks'				=> 'Deaktiver bracketed links:',
	'BracketsLinksInfo'			=> 'Deaktiverer <code>[[link]]</code> og <code>((link))</code> syntaks.',
	'Formatters'				=> 'Deaktiver formattere:',
	'FormattersInfo'			=> 'Deaktiverer syntaks <code>%%code%%</code> , der bruges til fremhævninger.',

	'DateFormatsSection'		=> 'Dato Formater',
	'DateFormat'				=> 'Datoens format:',
	'DateFormatInfo'			=> '(dag, måned, år)',
	'TimeFormat'				=> 'Formatet af tid:',
	'TimeFormatInfo'			=> '(time, minut)',
	'TimeFormatSeconds'			=> 'Formatet af den nøjagtige tid:',
	'TimeFormatSecondsInfo'		=> '(timer, minutter, sekunder)',
	'NameDateMacro'				=> 'Formatet af <code>: @::</code> makro:',
	'NameDateMacroInfo'			=> '(navn, tid), f.eks. <code>Brugernavn (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Tidszone:',
	'TimezoneInfo'				=> 'Tidszone, der skal bruges til at vise tidspunkter til brugere, der ikke er logget ind (gæster). Indloggede brugere indstiller og kan ændre deres tidszone i deres brugerindstillinger.',
	'AmericanDate'					=> 'Amerikansk dato:',
	'AmericanDateInfo'				=> 'Bruger amerikansk datoformat som standard for engelsk.',

	'Canonical'					=> 'Benyt fuldt kanoniske netadresser:',
	'CanonicalInfo'				=> 'Alle links oprettes som absolutte URL\'er i formularen %1. URL\'er i forhold til serverroden i formularen %2 bør foretrækkes.',
	'LinkTarget'				=> 'Hvis eksterne links åbner:',
	'LinkTargetInfo'			=> 'Åbner hvert eksterne link i et nyt browservindue. Tilføjer <code>target="_blank"</code> til linksyntaxen.',
	'Noreferrer'				=> 'noreferer:',
	'NoreferrerInfo'			=> 'Kræver at browseren ikke skal sende en HTTP referer header hvis brugeren følger hyperlinket. Tilføjer <code>rel="noreferrer"</code> til linksyntaksen.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Instruer nogle søgemaskiner, at hyperlinket ikke skal have indflydelse på rangeringen af linksmålet i søgemaskinens indeks. Tilføjer <code>rel="nofollow"</code> til linksyntaxen.',
	'UrlsUnderscores'			=> 'Form adresser (URL\'er) med understregninger:',
	'UrlsUnderscoresInfo'		=> 'For eksempel, %1 bliver %2 med denne mulighed.',
	'ShowSpaces'				=> 'Vis mellemrum i WikiNavne:',
	'ShowSpacesInfo'			=> 'Vis mellemrum i WikiNames, f.eks. <code>MyName</code> vises som <code>Mit navn</code> med denne indstilling.',
	'NumerateLinks'				=> 'Tæl links i udskriftsvisning:',
	'NumerateLinksInfo'			=> 'Tæller og lister alle links nederst i udskriftsvisningen med denne indstilling.',
	'YouareHereText'			=> 'Deaktiver og visualisere selvrefererende links:',
	'YouareHereTextInfo'		=> 'Visualisér links til samme side, ved brug af <code>&lt;b&gt;####&lt;/b&gt;</code>. Alle links til self mister link formatering, men vises som fed tekst.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Her kan du indstille eller ændre de systembasissider, der bruges i Wiki. Sørg for, at du ikke glemmer at oprette eller ændre de tilsvarende sider i Wiki i henhold til dine indstillinger her.',
	'PagesSettingsUpdated'		=> 'Opdaterede indstillinger grundsider',

	'ListCount'					=> 'Antal varer pr. liste:',
	'ListCountInfo'				=> 'Antal elementer der vises på hver liste for gæst, eller som standardværdi for nye brugere.',

	'ForumSection'				=> 'Valgmuligheder Forum',
	'ForumCluster'				=> 'Cluster Forum:',
	'ForumClusterInfo'			=> 'Root cluster til forum sektion (handling %1).',
	'ForumTopics'				=> 'Antal emner pr. side:',
	'ForumTopicsInfo'			=> 'Antal emner der vises på hver side af listen i forumsektionerne (handling %1).',
	'CommentsCount'				=> 'Antal kommentarer pr. side:',
	'CommentsCountInfo'			=> 'Antal kommentarer der vises på hver sides liste over kommentarer. Dette gælder for alle kommentarer på hjemmesiden, ikke kun dem, der er sendt i forummet.',

	'NewsSection'				=> 'Afsnit Nyheder',
	'NewsCluster'				=> 'Cluster for the News:',
	'NewsClusterInfo'			=> 'Root cluster for nyhedssektion (handling %1).',
	'NewsStructure'				=> 'Nyheder klynge struktur:',
	'NewsStructureInfo'			=> 'Gemmer artiklerne eventuelt i underklynger efter år/måned eller uge (f.eks. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licens',
	'DefaultLicense'			=> 'Standard licens:',
	'DefaultLicenseInfo'		=> 'Under hvilken licens dit indhold kan frigives.',
	'EnableLicense'				=> 'Aktiver licens:',
	'EnableLicenseInfo'			=> 'Aktiver for at vise licensinformation.',
	'LicensePerPage'			=> 'Licens pr. side:',
	'LicensePerPageInfo'		=> 'Tillad licens pr. side, som sideejeren kan vælge via sideegenskaber.',

	'ServicePagesSection'		=> 'Service pages',
	'RootPage'					=> 'Hjemmeside:',
	'RootPageInfo'				=> 'Tag af din hovedside, åbner automatisk, når en bruger besøger dit websted.',

	'PrivacyPage'				=> 'Privacy Policy:',
	'PrivacyPageInfo'			=> 'Siden med Privacy Policy af webstedet.',

	'TermsPage'					=> 'Politikker og forordninger:',
	'TermsPageInfo'				=> 'Siden med reglerne for webstedet.',

	'SearchPage'				=> 'Søg:',
	'SearchPageInfo'			=> 'Side med søgeformularen (handling %1).',
	'RegistrationPage'			=> 'Registrering:',
	'RegistrationPageInfo'		=> 'Side til ny brugerregistrering (handling %1).',
	'LoginPage'					=> 'Bruger login:',
	'LoginPageInfo'				=> 'Login side på webstedet (handling %1).',
	'SettingsPage'				=> 'Brugerindstillinger:',
	'SettingsPageInfo'			=> 'Side der skal tilpasses brugerprofilen (handling %1).',
	'PasswordPage'				=> 'Skift Adgangskode:',
	'PasswordPageInfo'			=> 'Side med en formular til at ændre / forespørge bruger adgangskode (handling %1).',
	'UsersPage'					=> 'Brugerliste:',
	'UsersPageInfo'				=> 'Side med en liste over registrerede brugere (handling %1).',
	'CategoryPage'				=> 'Kategori:',
	'CategoryPageInfo'			=> 'Side med en liste over kategoriserede sider (handling %1).',
	'GroupsPage'				=> 'Grupper:',
	'GroupsPageInfo'			=> 'Side med en liste over arbejdsgrupper (handling %1).',
	'WhatsNewPage'				=> 'Hvad er nyt:',
	'WhatsNewPageInfo'			=> 'Side med en liste over alle nye, slettede eller ændrede sider, nye vedhæftede filer og kommentarer. (handling %1).',
	'ChangesPage'				=> 'Seneste ændringer:',
	'ChangesPageInfo'			=> 'Side med en liste over de senest ændrede sider (handling %1).',
	'CommentsPage'				=> 'Seneste kommentarer:',
	'CommentsPageInfo'			=> 'Side med en liste over seneste kommentarer på siden (handling %1).',
	'RemovalsPage'				=> 'Slettede sider:',
	'RemovalsPageInfo'			=> 'Side med en liste over nyligt slettede sider (handling %1).',
	'WantedPage'				=> 'Ønskede sider:',
	'WantedPageInfo'			=> 'Side med en liste over manglende sider, der refereres til (handling %1).',
	'OrphanedPage'				=> 'Forældreløse sider:',
	'OrphanedPageInfo'			=> 'Side med en liste over eksisterende sider er ikke relateret via links til andre sider (handling %1).',
	'SandboxPage'				=> 'Sandkasse:',
	'SandboxPageInfo'			=> 'Siden, hvor brugerne kan øve deres wiki markup færdigheder.',
	'HelpPage'					=> 'Hjælp:',
	'HelpPageInfo'				=> 'Dokumentationsafsnittet til at arbejde med webstedsværktøjer.',
	'IndexPage'					=> 'Indeks:',
	'IndexPageInfo'				=> 'Side med en liste over alle sider (action %1).',
	'RandomPage'				=> 'Tilfældig:',
	'RandomPageInfo'			=> 'Indlæser en tilfældig side (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parametre for meddelelser om platformen.',
	'NotificationSettingsUpdated'	=> 'Opdaterede notifikationsindstillinger',

	'EmailNotification'			=> 'Email Notification:',
	'EmailNotificationInfo'		=> 'Tillad e-mail-notifikation. Sæt til aktiveret for at aktivere e-mail-notifikationer, deaktiveret for at deaktivere dem. Bemærk, at deaktivering af e-mail-meddelelser ikke har nogen effekt på e-mails, der genereres som en del af bruger-tilmeldingsprocessen.',
	'Autosubscribe'				=> 'Autoabonnering:',
	'AutosubscribeInfo'			=> 'Underret automatisk ejeren af sideændringer.',

	'NotificationSection'		=> 'Standard Indstillinger For Brugernotifikationer',
	'NotifyPageEdit'			=> 'Underret sideredigering:',
	'NotifyPageEditInfo'		=> 'Afventer - Send kun en e-mail notifikation for den første ændring, indtil brugeren besøger siden igen.',
	'NotifyMinorEdit'			=> 'Underret mindre redigering:',
	'NotifyMinorEditInfo'		=> 'Sender meddelelser også for mindre redigeringer.',
	'NotifyNewComment'			=> 'Notificér ny kommentar:',
	'NotifyNewCommentInfo'		=> 'Afventer - Send kun en e-mail notifikation for den første kommentar, indtil brugeren besøger siden igen.',

	'NotifyUserAccount'			=> 'Underret ny brugerkonto:',
	'NotifyUserAccountInfo'		=> 'Admin vil blive underrettet, når en ny bruger er blevet oprettet ved hjælp af tilmeldingsformularen.',
	'NotifyUpload'				=> 'Advisér fil upload:',
	'NotifyUploadInfo'			=> 'Moderatorerne får besked, når en fil er blevet uploadet.',

	'PersonalMessagesSection'	=> 'Personlige beskeder',
	'AllowIntercomDefault'		=> 'Tillad intercom:',
	'AllowIntercomDefaultInfo'	=> 'Aktivering af denne indstilling giver andre brugere mulighed for at sende personlige beskeder til modtagerens e-mailadresse uden at afsløre adressen.',
	'AllowMassemailDefault'		=> 'Tillad masse e-mail:',
	'AllowMassemailDefaultInfo'	=> 'Send kun beskeder til de brugere, der har tilladt administratorer at e-maile dem oplysninger.',

	// Resync settings
	'Synchronize'				=> 'synkronisere',
	'UserStatsSynched'			=> 'Brugerstatistik synkroniseret.',
	'PageStatsSynched'			=> 'Sidestatistik synkroniseret.',
	'FeedsUpdated'				=> 'RSS-feeds opdateret.',
	'SiteMapCreated'			=> 'Den nye version af webstedskortet blev oprettet.',
	'ParseNextBatch'			=> 'Fortolk næste parti af sider:',
	'WikiLinksRestored'			=> 'Wiki-links genoprettet.',

	'LogUserStatsSynched'		=> 'Synkroniseret brugerstatistik',
	'LogPageStatsSynched'		=> 'Synkroniseret sidestatistik',
	'LogFeedsUpdated'			=> 'Synkroniserede RSS-feeds',
	'LogPageBodySynched'		=> 'Repareret side krop og links',

	'UserStats'					=> 'Brugerstatistik',
	'UserStatsInfo'				=> 'Brugerstatistik (antal kommentarer, ejede sider, revisioner og filer) kan i nogle situationer afvige fra faktiske data. <br>Denne handling gør det muligt for opdateringsstatistikker at matche faktiske data i databasen.',
	'PageStats'					=> 'Side statistik',
	'PageStatsInfo'				=> 'Sidestatistik (antal kommentarer, filer og revisioner) kan i visse situationer afvige fra faktiske data. <br>Denne handling gør det muligt for opdateringsstatistikker at matche faktiske data indeholdt i databasen.',

	'AttachmentsInfo'			=> 'Opdaterer filhashen for alle vedhæftede filer i databasen.',
	'AttachmentsSynched'		=> 'Genhastede alle filvedhæftninger',
	'LogAttachmentsSynched'		=> 'Genhastede alle filvedhæftninger',

	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'I tilfælde af direkte redigering af sider i databasen kan indholdet af RSS-feeds ikke afspejle de foretagne ændringer. <br>Denne funktion synkroniserer RSS-kanalerne med den aktuelle tilstand af databasen.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'Denne funktion synkroniserer XML-Sitemap med den aktuelle tilstand af databasen.',
	'XmlSiteMapPeriod'			=> 'Periode %1 dage. Sidst skrevet %2.',
	'XmlSiteMapView'			=> 'Vis Sitemap i et nyt vindue.',

	'ReparseBody'				=> 'Reparér alle sider',
	'ReparseBodyInfo'			=> 'Tømmer <code>body_r</code> i sidetabellen, så hver side bliver gengivet igen i næste sidevisning. Dette kan være nyttigt, hvis du har ændret formatteren eller ændret domænet på din wiki.',
	'PreparsedBodyPurged'		=> 'Tømt <code>body_r</code> felt i sidetabellen.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Udfører en gengivelse for alle intrasite links og gendanner indholdet af <code>page_link</code> og <code>file_link</code> tabeller i tilfælde af skade eller omplacering (dette kan tage lang tid).',
	'RecompilePage'				=> 'Genopbygning af alle sider (ekstremt dyre)',
	'ResyncOptions'				=> 'Yderligere muligheder',
	'RecompilePageLimit'		=> 'Antal sider der skal tolkes på én gang.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Disse indstillinger anvendes af webstedet ved forsendelse af emails til tilmeldte brugere. Bemærk venligst at denne emailadresse skal være gyldig, da enhver tilbagesendt eller vildfaren email sandsynligvis vil blive returneret til denne emailaddresse. Hvis din vært ikke lader dig bruge den indbyggede (PHP-baserede) emailservice, kan du i stedet sende emails direkte igennem SMTP. Dette kræver adressen på en passende server (spørg om nødvendigt din vært). Hvis serveren kræver autentifikation (og kun hvis den gør) angives det nødvendige brugernavn, kodeord og autentifikationsmetoden.',

	'EmailSettingsUpdated'		=> 'Opdaterede e-mail-indstillinger',

	'EmailFunctionName'			=> 'Navn på emailfunktion:',
	'EmailFunctionNameInfo'		=> 'Navnet på den anvendte emailfunktion ved forsendelse af emails gennem PHP.',
	'UseSmtpInfo'				=> 'Vælg <code>SMTP</code>, hvis du vil eller skal bruge en navngiven server til at sende email i stedet for boardets indbyggede emailfunktion.',

	'EnableEmail'				=> 'Boardets emailsystem er:',
	'EnableEmailInfo'			=> 'Enabling emails',

	'EmailIdentitySettings'		=> 'Hjemmeside E-mails Identitet',
	'FromEmailName'				=> 'From Name:',
	'FromEmailNameInfo'			=> 'Afsendernavnet der bruges til <code>From:</code> header for alle e-mail notifikationer sendt fra webstedet.',
	'EmailSubjectPrefix'		=> 'Emne-præfiks:',
	'EmailSubjectPrefixInfo'	=> 'Alternativt e-mail-emnepræfiks, f.eks. <code>[Præfiks] Emne</code>. Hvis det ikke er defineret, er standardpræfikset Site Name: %1.',

	'NoReplyEmail'				=> 'No-svar adresse:',
	'NoReplyEmailInfo'			=> 'Denne adresse, f.eks. <code>noreply@example.com</code>, vises i <code>From:</code> e-mail-adresse felt af alle e-mail-meddelelser sendt fra webstedet.',
	'AdminEmail'				=> 'Email for ejeren af webstedet:',
	'AdminEmailInfo'			=> 'Denne adresse bruges til administrationsformål, som f.eks. notifikation af nye brugere.',
	'AbuseEmail'				=> 'Email misbrugstjeneste:',
	'AbuseEmailInfo'			=> 'Adresseanmodninger for hastende sager: registrering af en udenlandsk e-mail mv. Det kan være den samme som ejeren af webstedet e-mail.',

	'SendTestEmail'				=> 'Send en test e-mail',
	'SendTestEmailInfo'			=> 'Der afsendes en test-email til den mailadresse der er angivet for din konto.',
	'TestEmailSubject'			=> 'Din Wiki er opsat korrekt til at sende emails',
	'TestEmailBody'				=> 'Tillykke, da du har modtaget denne email er din Wiki korrekt konfigureret og kan sende emails.',
	'TestEmailMessage'			=> 'Der er netop afsendt en test-email.<br>Modtager du den ikke, bedes du kontrollere dine emailkonfigurationer.',

	'SmtpSettings'				=> 'SMTP-indstillinger',
	'SmtpAutoTls'				=> 'Opportunistiske TLS:',
	'SmtpAutoTlsInfo'			=> 'Aktiverer automatisk kryptering, hvis den ser, at serveren annoncerer TLS-kryptering (efter at du har tilsluttet serveren), selvom du ikke har indstillet forbindelsestilstanden for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Godkendelsesmetode for SMTP:',
	'SmtpConnectionModeInfo'	=> 'Bruges kun, hvis et brugernavn og kodeord er angivet, spørg din vært, hvis du er usikker på hvilken metode, der skal bruges.',
	'SmtpPassword'				=> 'SMTP-kodeord:',
	'SmtpPasswordInfo'			=> 'Indtast kun et kodeord, hvis din SMTP-server kræver det.<br><em><strong>Advarsel:</strong> Kodeordet bliver lagret i databasen i klar og ukrypteret tekst, og vil være synligt for alle med adgang til databasen eller til denne konfigurationsside.</em>',
	'SmtpPort'					=> 'SMTP-serverport:',
	'SmtpPortInfo'				=> 'Skift kun denne, hvis du ved, at din SMTP-server benytter en anden port. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Adresse på SMTP-server:',
	'SmtpServerInfo'			=> 'Bemærk at du skal anføre den protokol din server anvender. Hvis der anvendes SSL, anføres <code>ssl://mail.example.com</code>',
	'SmtpUsername'				=> 'SMTP-brugernavn:',
	'SmtpUsernameInfo'			=> 'Indtast kun et brugernavn, hvis din SMTP-server kræver det.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Her kan du ændre og vedligeholde indstillingerne for vedhæftede filer og tilknyttede specialkategorier.',
	'UploadSettingsUpdated'		=> 'Opdaterede upload indstillinger',

	'FileUploadsSection'		=> 'Fil Uploads',
	'RegisteredUsers'			=> 'registrerede brugere',
	'RightToUpload'				=> 'Tilladelser til at uploade filer:',
	'RightToUploadInfo'			=> '<code>admins</code> betyder, at kun brugere, der tilhører admins gruppen, kan uploade filer. <code>1</code> betyder, at upload er åbnet for registrerede brugere. <code>0</code> betyder, at upload er deaktiveret.',
	'UploadMaxFilesize'			=> 'Maksimal filstørrelse:',
	'UploadMaxFilesizeInfo'		=> 'Er størrelsen sat til 0, er det alene din interne PHP-konfiguration, der begrænser filstørrelsen.',
	'UploadQuota'				=> 'Den totale kvote for vedhæftede filer:',
	'UploadQuotaInfo'			=> 'Maksimum drevplads tilgængelig for vedhæftede filer på hele wiki, <code>0</code> betyder ubegrænset. %1 used.',
	'UploadQuotaUser'			=> 'Lagringskvote pr. bruger:',
	'UploadQuotaUserInfo'		=> 'Begrænsning af den lagerkvote, der kan uploades af en bruger, hvor <code>0</code> er ubegrænset.',

	'FileTypes'					=> 'Filtyper',
	'UploadOnlyImages'			=> 'Tillad kun upload af billeder:',
	'UploadOnlyImagesInfo'		=> 'Tillad kun upload af billedfiler på siden.',
	'AllowedUploadExts'			=> 'Tilladte filtyper:',
	'AllowedUploadExtsInfo'		=> 'Tilladte filtypenavne til upload af filer, kommasepareret, f.eks. <code>png, ogg, mp4</code>, ellers er alle ikke forbudte filtypenavne tilladt.<br>Du bør begrænse listen over tilladte uploadede filtyper til det nødvendige minimum, der kræves for funktionaliteten af dit websted.',
	'CheckMimetype'				=> 'Kontrol af vedhæftede filer:',
	'CheckMimetypeInfo'			=> 'Nogle browsere kan snydes og medfører fejlfortolkning af uploadede filers mimetype. Denne kontrol sikrer afvisning af filer der er årsag hertil.',
	'SvgSanitizer'				=> 'SVG Sanitizer:',
	'SvgSanitizerInfo'			=> 'Dette gør det muligt at rense uploadede SVG-filer for at forhindre, at SVG/XML sårbare filer bliver uploadet.',
	'TranslitFileName'			=> 'Translitterere filnavne:',
	'TranslitFileNameInfo'		=> 'Hvis det er relevant, og der ikke er behov for Unicode-tegn, anbefales det stærkt kun at acceptere alfanumeriske tegn.',
	'TranslitCaseFolding'		=> 'Konverter filnavne til små bogstaver:',
	'TranslitCaseFoldingInfo'	=> 'Denne indstilling er kun effektiv med aktiv translitteration.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Opret miniature:',
	'CreateThumbnailInfo'		=> 'Der oprettes altid en miniature.',
	'JpegQuality'				=> 'JPEG-kvalitet:',
	'JpegQualityInfo'			=> 'Kvalitet: Kvalitet ved skalering af et JPEG-miniaturebillede. Den skal være mellem 1 og 100, hvor 100 angiver 100 % kvalitet.',
	'MaxImageArea'				=> 'Maximum Image Area:',
	'MaxImageAreaInfo'			=> 'Det maksimale antal pixels, som et kildebillede kan have. Dette giver en grænse for hukommelsesforbruget for billedskaleringens dekomprimeringsside. <br><code>-1</code> betyder, at den ikke kontrollerer billedets størrelse, før den forsøger at skalere det. <code>0</code> betyder, at den vil bestemme værdien automatisk.',
	'MaxThumbWidth'				=> 'Maksimal bredde på miniature i pixels:',
	'MaxThumbWidthInfo'			=> 'Miniaturer vil ikke blive oprettet bredere end værdien defineret her.',
	'MinThumbFilesize'			=> 'Grænse for oprettelse af miniature:',
	'MinThumbFilesizeInfo'		=> 'Opret ikke miniature for billeder der er mindre end.',
	'MaxImageWidth'				=> 'Begrænsning af billedstørrelse på sider:',
	'MaxImageWidthInfo'			=> 'Den maksimale bredde, som et billede kan have på siderne, ellers genereres et nedskaleret miniaturebillede.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'List of removed pages, revisions and files.
									Finally remove or restore the pages, revisions or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Ord, der automatisk vil blive censureret på din Wiki.',
	'FilterSettingsUpdated'		=> 'Opdaterede spamfilter indstillinger',

	'WordCensoringSection'		=> 'Ord Censurering',
	'SPAMFilter'				=> 'SPAM Filter:',
	'SPAMFilterInfo'			=> 'Aktiverer Spam Filter',
	'WordList'					=> 'Ordliste:',
	'WordListInfo'				=> 'Ord eller sætning <code>fragment</code> der skal sortlistes (en pr. linje)',

	// Log module
	'LogFilterTip'				=> 'Filtrer begivenheder efter kriterier:',
	'LogLevel'					=> 'Niveau',
	'LogLevelFilters'	=> [
		'1'		=> 'mindst',
		'2'		=> 'ikke højere end',
		'3'		=> 'lig med',
	],
	'LogNoMatch'				=> 'Ingen hændelser, der opfylder kriterierne',
	'LogDate'					=> 'Dato',
	'LogEvent'					=> 'Begivenhed',
	'LogUsername'				=> 'Dit brugernavn',
	'LogLevels'	=> [
		'1'		=> 'kritisk',
		'2'		=> 'højeste',
		'3'		=> 'høj',
		'4'		=> 'medium',
		'5'		=> 'lav',
		'6'		=> 'laveste',
		'7'		=> 'fejlfinding',
	],

	// Massemail module
	'MassemailInfo'				=> 'Her kan du sende en email til enten alle dine brugere, eller til de brugere i en specifik gruppe som <strong>har muligheden for at modtage masse-emails aktiveret</strong>. Når en masse-email afsendes bliver administrator sat som afsender, og afsendes med modtagere som blind kopi, som derfor ikke kan se øvrige modtagere. Som standard afsendes emailen til 20 brugere ad gangen. Vær tålmodig, når du sender email til en stor gruppe af personer og stop ikke siden halvvejs. Afsendelsen af en masse-email kan tage lang tid, men du bliver informeret når scriptet er fuldført.',
	'LogMassemail'				=> 'Masse e-mail sende %1 til gruppe / bruger ',
	'MassemailSend'				=> 'Masse e-mail send',

	'NoEmailMessage'			=> 'Du skal skrive en besked.',
	'NoEmailSubject'			=> 'Du skal angive en overskrift i din email.',
	'NoEmailRecipient'			=> 'Du skal angive mindst én bruger eller brugergruppe.',

	'MassemailSection'			=> 'Masse e-mail',
	'MessageSubject'			=> 'Emne:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Emailens tekst:',
	'YourMessageInfo'			=> 'Bemærk venligst at du kun bør skrive ren tekst. Al opmærkning vil blive fjernet inden afsendelse.',

	'NoUser'					=> 'Ingen bruger',
	'NoUserGroup'				=> 'Ingen brugergruppe',

	'SendToGroup'				=> 'Send til gruppe:',
	'SendToUser'				=> 'Send til brugere:',
	'SendToUserInfo'			=> 'Kun brugere som tillader Administratorer at sende en e-mail til dem, vil modtage masse- e- mail. Denne indstilling er tilgængelig i deres bruger- indstillinger under Notifikationer.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Opdaterede systembesked',

	'SysMsgSection'				=> 'System message',
	'SysMsg'					=> 'System besked:',
	'SysMsgInfo'				=> 'Din tekst her',

	'SysMsgType'				=> 'Type:',
	'SysMsgTypeInfo'			=> 'Meddelelsestype (CSS).',
	'SysMsgAudience'			=> 'Publikum:',
	'SysMsgAudienceInfo'		=> 'Publikum systembeskeden vises til.',
	'EnableSysMsg'				=> 'Aktiver systembesked:',
	'EnableSysMsgInfo'			=> 'Vis systembesked.',

	// User approval module
	'ApproveNotExists'			=> 'Vælg venligst mindst én bruger via knappen Set.',

	'LogUserApproved'			=> 'Bruger ##%1## godkendt',
	'LogUserBlocked'			=> 'Bruger ##%1## blokeret',
	'LogUserDeleted'			=> 'Bruger ##%1## fjernet fra databasen',
	'LogUserCreated'			=> 'Oprettede en ny bruger ##%1##',
	'LogUserUpdated'			=> 'Opdateret Bruger ##%1##',
	'LogUserPasswordReset'		=> 'Adgangskode for bruger ##%1## succesfuldt nulstillet',

	'UserApproveInfo'			=> 'Godkend nye brugere, før de kan logge ind på webstedet.',
	'Approve'					=> 'Godkend',
	'Deny'						=> 'Afvis',
	'Pending'					=> 'Verserende',
	'Approved'					=> 'Godkendt',
	'Denied'					=> 'Afvist',

	// DB Backup module
	'BackupStructure'			=> 'Struktur',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Mappe',
	'BackupTable'				=> 'Tabel',
	'BackupCluster'				=> 'Klynge:',
	'BackupFiles'				=> 'Filer',
	'BackupNote'				=> 'Bemærk:',
	'BackupSettings'			=> 'Angiv den ønskede backup-ordning.<br>' .
    	'Root-klyngen påvirker ikke sikkerhedskopieringen af globale filer og cache-filer (hvis valgt, gemmes de altid fuldt ud).<br>' .  '<br>' .
		'<strong>Attention</strong>: For at undgå tab af oplysninger fra databasen, når du angiver rodklyngen, tabellerne fra denne backup vil ikke blive omstruktureret, det samme som når der kun sikkerhedskopieres tabelstruktur uden at gemme dataene. For at foretage en fuldstændig konvertering af tabellerne til backup-formatet skal du lave <em> fuld backup af databasen (struktur og data) uden at angive klyngen</em>.',
	'BackupCompleted'			=> 'Sikkerhedskopiering og arkivering fuldført.<br>' .
    	'Backup-pakkefilerne blev gemt i undermappen %1.<br>. For at downloade det bruge FTP (vedligeholde mappestruktur og filnavne, når du kopierer).<br> For at gendanne en sikkerhedskopi eller fjerne en pakke, gå til <a href="%2">Gendan database</a>.',
	'LogSavedBackup'			=> 'Gemt backup database ##%1##',
	'Backup'					=> 'Sikkerhedskopi',
	'CantReadFile'				=> 'Kan ikke læse filen %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Du kan gendanne nogen af de sikkerhedskopi pakker fundet, eller fjerne dem fra serveren.',
	'ConfirmDbRestore'			=> 'Vil du gendanne sikkerhedskopi %1?',
	'ConfirmDbRestoreInfo'		=> 'Vent venligst, dette kan tage nogle minutter.',
	'RestoreWrongVersion'		=> 'Forkert WackoWiki version!',
	'DirectoryNotExecutable'	=> 'Mappen %1 er ikke eksekverbar.',
	'BackupDelete'				=> 'Er du sikker på, at du vil fjerne backup %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Yderligere gendannelsesmuligheder:',
	'RestoreOptionsInfo'		=> '* Før gendannelse af <strong>cluster backup</strong>, ' .
									'måltabellerne slettes ikke (for at forhindre tab af information fra de klynger, der ikke er bakket op). ' .
									'Således, under inddrivelse proces duplikere poster vil forekomme. ' .
									'I normal tilstand vil alle af dem blive erstattet af posteringerne form backup (ved hjælp af SQL <code>REPLACE</code>), ' .
									'men hvis dette afkrydsningsfelt er markeret, bliver alle dubletter sprunget over (de aktuelle værdier for elementer vil blive gemt), ' .
									'og kun poster med nye nøgler føjes til tabellen (SQL <code>INSERT IGNORE</code>).<br>' .
									'<strong>Bemærk</strong>: Når du gendanner fuldstændig backup af webstedet, har denne indstilling ingen værdi.<br>' .
									'<br>' .
									'** Hvis sikkerhedskopien indeholder brugerfiler (global og perpage, cache filer, osv.), ' .
									'i normal tilstand erstatter de eksisterende filer med de samme navne og placeres i samme mappe, når de gendannes. ' .
									'Denne indstilling giver dig mulighed for at gemme de aktuelle kopier af filerne og gendanne fra en backup kun nye filer (mangler på serveren).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignorér duplikerede tabelnøgler (ikke erstat)',
	'IgnoreSameFiles'			=> 'Ignorér samme filer (ikke overskriv)',
	'NoBackupsAvailable'		=> 'Ingen sikkerhedskopier tilgængelige.',
	'BackupEntireSite'			=> 'Hele lokaliteten',
	'BackupRestored'			=> 'Sikkerhedskopien er genoprettet, en sammenfattende rapport er vedhæftet nedenfor. For at slette denne backup pakke, skal du klikke',
	'BackupRemoved'				=> 'Den valgte backup er blevet fjernet.',
	'LogRemovedBackup'			=> 'Fjernet database backup ##%1##',

	'RestoreStarted'			=> 'Istandsat Gendannelse',
	'RestoreParameters'			=> 'Bruger parametre',
	'IgnoreDuplicatedKeys'		=> 'Ignorér duplikerede nøgler',
	'IgnoreDuplicatedFiles'		=> 'Ignorer duplikerede filer',
	'SavedCluster'				=> 'Gemt klynge',
	'DataProtection'			=> 'Databeskyttelse - %1 udeladt',
	'AssumeDropTable'			=> 'Antag %1',
	'RestoreTableStructure'		=> 'Gendannelse af strukturen i tabellen',
	'RunSqlQueries'				=> 'Udfør SQL instruktioner:',
	'CompletedSqlQueries'		=> 'Fuldført. Behandlede instruktioner:',
	'NoTableStructure'			=> 'Strukturen af tabellerne blev ikke gemt - spring over',
	'RestoreRecords'			=> 'Gendan indholdet af tabeller',
	'ProcessTablesDump'			=> 'Bare downloade og behandle tabel lossepladser',
	'Instruction'				=> 'Instruktion',
	'RestoredRecords'			=> 'optegnelser:',
	'RecordsRestoreDone'		=> 'Fuldført. Indgange i alt:',
	'SkippedRecords'			=> 'Data ikke gemt - spring over',
	'RestoringFiles'			=> 'Gendanner filer',
	'DecompressAndStore'		=> 'Nedbryd og opbevar indholdet af mapper',
	'HomonymicFiles'			=> 'homonymiske filer',
	'RestoreSkip'				=> 'spring over',
	'RestoreReplace'			=> 'erstat',
	'RestoreFile'				=> 'Fil:',
	'RestoredFiles'				=> 'genoprettet:',
	'SkippedFiles'				=> 'springer over:',
	'FileRestoreDone'			=> 'Afsluttet. Total filer:',
	'FilesAll'					=> 'alle:',
	'SkipFiles'					=> 'Filerne gemmes ikke - spring over',
	'RestoreDone'				=> 'GENOPBEVARING FULDT',

	'BackupCreationDate'		=> 'Oprettelsesdato',
	'BackupPackageContents'		=> 'Indholdet af pakningen',
	'BackupRestore'				=> 'Gendan',
	'BackupRemove'				=> 'Slet',
	'RestoreYes'				=> 'Ja',
	'RestoreNo'					=> 'Nej',
	'LogDbRestored'				=> 'Backup ##%1## af databasen gendannet.',

	'BackupArchived'			=> 'Backup %1 arkiveret.',
	'BackupArchiveExists'		=> 'Backup-arkivet %1 findes allerede.',
	'LogBackupArchived'			=> 'Backup ##%1## arkiveret.',

	// User module
	'UsersInfo'					=> 'Her kan du ændre dine brugeres information og visse specifikke indstillinger.',

	'UsersAdded'				=> 'Bruger tilføjet',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> 'Redigere',
	'UsersAddNew'				=> 'Tilføj ny bruger',
	'UsersDelete'				=> 'Er du sikker på, at du vil fjerne bruger %1?',
	'UsersDeleted'				=> 'Brugeren %1 blev slettet fra databasen.',
	'UsersRename'				=> 'Omdøb brugeren %1 til',
	'UsersRenameInfo'			=> '* Bemærk: Ændringen vil påvirke alle sider, der er tildelt den pågældende bruger.',
	'UsersUpdated'				=> 'Bruger opdateret.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Tilmeldingstid',
	'UserActions'				=> 'Handlinger',
	'NoMatchingUser'			=> 'Ingen brugere, der opfylder kriterierne',

	'UserAccountNotify'			=> 'Underret bruger',
	'UserNotifySignup'			=> 'informere brugeren om den nye konto',
	'UserVerifyEmail'			=> 'angiv e-mail-bekræftelses-token og tilføj link til e-mail-verifikation',
	'UserReVerifyEmail'			=> 'Send e-mail-bekræftelsestoken igen',

	// Groups module
	'GroupsInfo'				=> 'Fra dette panel kan du administrere alle dine brugergrupper. Du kan slette, oprette og redigere eksisterende grupper. Derudover kan du vælge gruppeledere, skifte åbne/skjulte/lukket gruppe-status og angive gruppenavn og -beskrivelse.',

	'LogMembersUpdated'			=> 'Opdaterede brugergruppemedlemmer',
	'LogMemberAdded'			=> 'Tilføjet medlem ##%1## til gruppe ##%2##',
	'LogMemberRemoved'			=> 'Fjernede medlem ##%1## fra gruppe ##%2##',
	'LogGroupCreated'			=> 'Oprettede en ny gruppe ##%1##',
	'LogGroupRenamed'			=> 'Gruppe ##%1## omdøbt til ##%2##',
	'LogGroupRemoved'			=> 'Fjernede gruppe ##%1##',

	'GroupsMembersFor'			=> 'Medlemmer for gruppe',
	'GroupsDescription'			=> 'Beskrivelse',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Åbn',
	'GroupsActive'				=> 'Aktiv',
	'GroupsTip'					=> 'Klik for at redigere gruppe',
	'GroupsUpdated'				=> 'Grupper opdateret',
	'GroupsAlreadyExists'		=> 'Denne gruppe eksisterer allerede.',
	'GroupsAdded'				=> 'Gruppen blev tilføjet.',
	'GroupsRenamed'				=> 'Gruppe omdøbt.',
	'GroupsDeleted'				=> 'Gruppen %1 og alle tilknyttede sider blev slettet fra databasen.',
	'GroupsAdd'					=> 'Tilføj en ny gruppe',
	'GroupsRename'				=> 'Omdøb gruppen %1 til',
	'GroupsRenameInfo'			=> '* Bemærk: Ændringen vil påvirke alle sider, der er tilknyttet denne gruppe.',
	'GroupsDelete'				=> 'Er du sikker på, at du vil fjerne gruppe %1?',
	'GroupsDeleteInfo'			=> '* Bemærk: Ændring vil påvirke alle medlemmer, der er tilknyttet denne gruppe.',
	'GroupsIsSystem'			=> 'Gruppen %1 tilhører systemet og kan ikke fjernes.',
	'GroupsStoreButton'			=> 'Gem Grupper',
	'GroupsEditInfo'			=> 'For at redigere listen over grupper, vælg radioknappen.',

	'GroupAddMember'			=> 'Tilføj medlem',
	'GroupRemoveMember'			=> 'Fjern Medlem',
	'GroupAddNew'				=> 'Tilføj gruppe',
	'GroupEdit'					=> 'Rediger Gruppe',
	'GroupDelete'				=> 'Fjern Gruppe',

	'MembersAddNew'				=> 'Tilføj nyt medlem',
	'MembersAdded'				=> 'Tilføjet nyt medlem til gruppen med succes.',
	'MembersRemove'				=> 'Er du sikker på, at du vil fjerne medlem %1?',
	'MembersRemoved'			=> 'Medlemmet blev fjernet fra gruppen.',

	// Statistics module
	'DbStatSection'				=> 'Database Statistik',
	'DbTable'					=> 'Tabel',
	'DbRecords'					=> 'Poster',
	'DbSize'					=> 'Størrelse',
	'DbIndex'					=> 'Indeks',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'I Alt',

	'FileStatSection'			=> 'Statistik over filsystemet',
	'FileFolder'				=> 'Mappe',
	'FileFiles'					=> 'Filer',
	'FileSize'					=> 'Størrelse',
	'FileTotal'					=> 'I Alt',

	// Sysinfo module
	'SysInfo'					=> 'Version informations:',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Værdier',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Sidst opdateret',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Server navn',
	'WebServer'					=> 'Webserver',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'Database',
	'SqlModesGlobal'			=> 'Sql Tilstande Globalt',
	'SqlModesSession'			=> 'Session Af Sql- Tilstande',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Hukommelse',
	'UploadFilesizeMax'			=> 'Upload maks. filstørrelse',
	'PostMaxSize'				=> 'Maks. størrelse på indlæg',
	'MaxExecutionTime'			=> 'Maks. udførelsestid',
	'SessionPath'				=> 'Session sti',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip komprimering',
	'PhpExtensions'				=> 'PHP udvidelser',
	'ApacheModules'				=> 'Apache moduler',

	// DB repair module
	'DbRepairSection'			=> 'Reparer Database',
	'DbRepair'					=> 'Reparer Database',
	'DbRepairInfo'				=> 'Dette script kan automatisk søge efter nogle almindelige database problemer og reparere dem. Reparation kan tage et stykke tid, så vær tålmodig.',

	'DbOptimizeRepairSection'	=> 'Reparér og optimer database',
	'DbOptimizeRepair'			=> 'Reparér og optimer database',
	'DbOptimizeRepairInfo'		=> 'Dette script kan også forsøge at optimere databasen. Dette forbedrer ydeevnen i nogle situationer. Reparation og optimering af databasen kan tage lang tid, og databasen vil blive låst under optimering.',

	'TableOk'					=> 'Tabellen %1 er okay.',
	'TableNotOk'				=> 'Tabellen %1 er ikke okay. Den rapporterer følgende fejl: %2. Dette script vil forsøge at reparere denne tabel&hellip;',
	'TableRepaired'				=> 'Tabellen %1 blev repareret.',
	'TableRepairFailed'			=> 'Kunne ikke reparere %1 -tabellen. <br>Fejl: %2',
	'TableAlreadyOptimized'		=> 'Tabellen %1 er allerede optimeret.',
	'TableOptimized'			=> 'Optimeret %1 tabellen.',
	'TableOptimizeFailed'		=> 'Mislykkedes at optimere %1 -tabellen. <br>Fejl: %2',
	'TableNotRepaired'			=> 'Nogle databaseproblemer kunne ikke repareres.',
	'RepairsComplete'			=> 'Reparationer fuldført',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Vis og løs uoverensstemmelser, slet eller tildel forældreløse elementer til en ny bruger / værdi.',
	'Inconsistencies'			=> 'Uoverensstemmelser',
	'CheckDatabase'				=> 'Database',
	'CheckDatabaseInfo'			=> 'Kontrol for registrering af uoverensstemmelser i databasen.',
	'CheckFiles'				=> 'Filer',
	'CheckFilesInfo'			=> 'Kontrollerer for forladte filer, filer uden reference tilbage i filtabellen.',
	'Records'					=> 'Poster',
	'InconsistenciesNone'		=> 'Ingen data uoverensstemmelser fundet.',
	'InconsistenciesDone'		=> 'Data Uoverensstemmelser løst.',
	'InconsistenciesRemoved'	=> 'Fjernede uoverensstemmelser',
	'Check'						=> 'Tjek',
	'Solve'						=> 'Løs',

	// Bad Behaviour module
	'BbInfo'					=> 'Registrerer og blokerer uønsket webadgang, nægter automatisk adgang til spambots.<br>For mere information, besøg venligst %1 hjemmeside.',
	'BbEnable'					=> 'Aktivér Dårlig Opførsel:',
	'BbEnableInfo'				=> 'Alle andre indstillinger kan ændres i konfigurationsmappen %1.',
	'BbStats'					=> 'Bad Adfærd har blokeret %1 adgang forsøg i de sidste 7 dage.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Log',
	'BbSettings'				=> 'Indstillinger',
	'BbWhitelist'				=> 'Hvidliste',

	// --> Log
	'BbHits'					=> 'Visninger',
	'BbRecordsFiltered'			=> 'Viser %1 af %2 elementer filtreret af',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Blokeret',
	'BbPermitted'				=> 'Tilladt',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Viser alle %1 posteringer',
	'BbShow'					=> 'Vis',
	'BbIpDateStatus'			=> 'Ip/Dato/Status',
	'BbHeaders'					=> 'Overskrifter',
	'BbEntity'					=> 'Enhed',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Indstillinger gemt.',
	'BbWhitelistHint'			=> 'Upassende hvidlistning WILL udsætte dig for spam, eller forårsage dårlig adfærd til at stoppe med at fungere helt! MÅ IKKE HVIDELIST, medmindre du er 100% VISSE som du burde.',
	'BbIpAddress'				=> 'Ip Adresse',
	'BbIpAddressInfo'			=> 'IP-adresse eller CIDR-format adresseområder der skal hvidlistes (én pr. linje)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL fragmenter, der begynder med / efter din hjemmeside værtsnavn (en pr. linje)',
	'BbUserAgent'				=> 'Bruger Agent',
	'BbUserAgentInfo'			=> 'Brugeragent strenge der skal hvidlistes (en pr. linje)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Opdaterede indstillinger for dårlig adfærd',
	'BbLogRequest'				=> 'Logning af HTTP anmodning',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (anbefalet)',
	'BbLogOff'					=> 'Log ikke (ikke anbefalet)',
	'BbSecurity'				=> 'Sikkerhed',
	'BbStrict'					=> 'Streng kontrol',
	'BbStrictInfo'				=> 'blokerer mere spam, men kan blokere nogle mennesker',
	'BbOffsiteForms'			=> 'Tillad formularopslag fra andre websteder',
	'BbOffsiteFormsInfo'		=> 'påkrævet for OpenID; øger modtagne spam',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'For at bruge Bad Adfærds http:BL funktioner skal du have en %1',
	'BbHttpblKey'				=> 'http:BL Adgangsnøgle',
	'BbHttpblThreat'			=> 'Mindste trusselsniveau (25 anbefales)',
	'BbHttpblMaxage'			=> 'Maksimal alder for data (30 anbefales)',
	'BbReverseProxy'			=> 'Omvendt Proxy/Belastning Balancer',
	'BbReverseProxyInfo'		=> 'Hvis du bruger Bad Behaviour bag en omvendt proxy, load balancer, HTTP accelerator, indhold cache eller lignende teknologi, aktivere Reverse Proxy mulighed.<br>' .
									'Hvis du har en kæde af to eller flere omvendte fuldmagter mellem din server og det offentlige internet, du skal angive <em>alle</em> af IP-adresseintervallerne (i CIDR-format) for alle dine proxy-servere, load balancers, osv. Ellers, Bad Opførsel kan være ude af stand til at bestemme kundens sande IP-adresse.<br>' .
									'Derudover skal dine reverse proxy-servere indstille IP-adressen på internetklienten hvorfra de modtog anmodningen i en HTTP-header. Hvis du ikke angiver en header, vil %1 blive brugt. De fleste proxy-servere understøtter allerede X-Forwarded-For og du skal så kun sikre, at det er aktiveret på dine proxy-servere. Nogle andre header navne i almindelig brug omfatter %2 og %3.',
	'BbReverseProxyEnable'		=> 'Aktiver Omvendt Proxy',
	'BbReverseProxyHeader'		=> 'Header indeholder internetklienter IP-adresse',
	'BbReverseProxyAddresses'	=> 'IP-adresse eller CIDR-format adresseintervaller for dine proxyservere (en pr. linje)',

];
