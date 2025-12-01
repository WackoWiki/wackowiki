<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Grunnleggende funksjoner',
		'preferences'	=> 'Innstillinger',
		'content'		=> 'Innhold',
		'users'			=> 'Brukere',
		'maintenance'	=> 'Vedlikehold',
		'messages'		=> 'Meldinger',
		'extension'		=> 'Utvidelse',
		'database'		=> 'Databasen',
	],

	// Admin panel
	'AdminPanel'				=> 'Administrasjons kontrollpanel',
	'RecoveryMode'				=> 'Gjenopprettings modus',
	'Authorization'				=> 'Autorisasjon',
	'AuthorizationTip'			=> 'Vennligst skriv inn det administrative passordet (sørg for at informasjonskapsler er tillatt i nettleseren din).',
	'NoRecoveryPassword'		=> 'Det administrative passordet er ikke spesifisert!',
	'NoRecoveryPasswordTip'		=> 'Merk: Fraværet av et administrativt passord er en trussel mot sikkerhet! Angi ditt passord hash i konfigurasjonsfilen og kjør programmet på nytt.',

	'ErrorLoadingModule'		=> 'Feil under lasting av admin-modul %1: finnes ikke.',

	'ApHomePage'				=> 'Hjemme Side',
	'ApHomePageTip'				=> 'Avslutt systemadministrasjon og åpne hjemmesiden',
	'ApLogOut'					=> 'Logg ut',
	'ApLogOutTip'				=> 'Avslutt systemadministrasjon og logg ut av nettstedet',

	'TimeLeft'					=> 'Gjenstående tid:  %1 minutt(er)',
	'ApVersion'					=> 'versjon',

	'SiteOpen'					=> 'Åpne',
	'SiteOpened'				=> 'område åpnet',
	'SiteOpenedTip'				=> 'Nettstedet er åpent',
	'SiteClose'					=> 'Lukk',
	'SiteClosed'				=> 'nettstedet lukket',
	'SiteClosedTip'				=> 'Nettstedet er stengt',

	'System'					=> 'System',

	// Generic
	'Cancel'					=> 'Avbryt',
	'Add'						=> 'Legg til',
	'Edit'						=> 'Rediger',
	'Remove'					=> 'Fjern',
	'Enabled'					=> 'Aktivert',
	'Disabled'					=> 'Deaktivert',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'Administrator',
	'Min'						=> 'Minimum',
	'Max'						=> 'Maks',

	'MiscellaneousSection'		=> 'Diverse',
	'MainSection'				=> 'Generelle alternativer',

	'DirNotWritable'			=> 'Mappen %1 er ikke skrivbar.',
	'FileNotWritable'			=> '%1 filen er ikke skrivbar.',

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
		'name'		=> 'Grunnleggende',
		'title'		=> 'Grunnleggende innstillinger',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Utseende',
		'title'		=> 'Innstillinger for utseende',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-post',
		'title'		=> 'E-post innstillinger',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Syndikering',
		'title'		=> 'Innstillinger for syndikering',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtrer',
		'title'		=> 'Innstillinger for filter',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'Formatering alternativer',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Varsler',
		'title'		=> 'Innstillinger for varslinger',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Sider',
		'title'		=> 'Sider og nettstedsparametere',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Tillatelser',
		'title'		=> 'Innstillinger for tillatelser',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Sikkerhet',
		'title'		=> 'Innstillinger for sikkerhetsdelsystemer',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Systemadministrasjon',
		'title'		=> 'System alternativer',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Last opp',
		'title'		=> 'Innstillinger for vedlegg',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Slettet',
		'title'		=> 'Nylig slettet innhold',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Meny',
		'title'		=> 'Legg til, rediger eller fjern standard menypunkt',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Sikkerhetskopi',
		'title'		=> 'Sikkerhetskopierer data',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Reparer',
		'title'		=> 'Reparer og Optimaliser databasen',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Gjenopprett',
		'title'		=> 'Gjenoppretter backup data',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Hoved Meny',
		'title'		=> 'WackoWiki administrasjon',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inkonsistens',
		'title'		=> 'Fikser Data Inkonsistens',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Synkronisering av data',
		'title'		=> 'Synkroniserer data',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Masse e-post',
		'title'		=> 'Masse e-post',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'System melding',
		'title'		=> 'System meldinger',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'System informasjon',
		'title'		=> 'System Informasjon',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System logg',
		'title'		=> 'Logg på systemhendelser',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistikk',
		'title'		=> 'Vis statistikk',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Dårlig oppførsel',
		'title'		=> 'Dårlig oppførsel',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Godkjenn',
		'title'		=> 'Godkjenning av brukerregistrering',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Grupper',
		'title'		=> 'Administrasjon av konsernet',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Brukere',
		'title'		=> 'Brukeradministrasjon administrasjon',
	],

	// Main module
	'MainNote'					=> 'Merk: Det anbefales at tilgang til nettstedet midlertidig blokkeres for administrativt vedlikehold.',

	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'Tøm alle økter',
	'PurgeSessionsConfirm'		=> 'Er du sikker på at du vil rense alle øktene? Dette vil logge ut alle brukere.',
	'PurgeSessionsExplain'		=> 'Tøm alle økter. Dette vil logge ut alle brukere ved å avkorte auth_token tabellen.',
	'PurgeSessionsDone'			=> 'Økter renset.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Oppdaterte grunnleggende innstillinger',
	'LogBasicSettingsUpdated'	=> 'Oppdaterte grunnleggende innstillinger',

	'SiteName'					=> 'Sidens navn:',
	'SiteNameInfo'				=> 'Tittelen på dette nettstedet. Vises på webleserens tittel, temadhoder, e-postvarsling, etc.',
	'SiteDesc'					=> 'Sidens beskrivelse:',
	'SiteDescInfo'				=> 'Tillegg til tittelen på nettstedet som vises i sideoverskriften. Utforsk med noen få ord, hva dette nettstedet handler om.',
	'AdminName'					=> 'Admin av nettstedet:',
	'AdminNameInfo'				=> 'Brukernavnet til personen som er ansvarlig for generell støtte til nettstedet. Dette navnet brukes ikke for å bestemme tilgangsrettigheter, men det er ønskelig at den er i samsvar med navnet på den øverste administratoren for nettstedet.',

	'LanguageSection'			=> 'Språk',
	'DefaultLanguage'			=> 'Standard språk:',
	'DefaultLanguageInfo'		=> 'Spesifiserer språket til meldinger som vises til uregistrerte gjester, samt innstillingene for lokale innstillinger.',
	'MultiLanguage'				=> 'Flerspråklig støtte:',
	'MultiLanguageInfo'			=> 'Aktiver muligheten til å velge et språk for side basert på siden.',
	'AllowedLanguages'			=> 'Tillatte språk:',
	'AllowedLanguagesInfo'		=> 'Det anbefales å bare velge hvilke språk du vil bruke, ellers velges alle språk.',

	'CommentSection'			=> 'Kommentarer',
	'AllowComments'				=> 'Tillat kommentarer:',
	'AllowCommentsInfo'			=> 'Aktiver kommentarer for gjester eller registrerte brukere eller deaktiver dem på hele nettstedet.',
	'SortingComments'			=> 'Sortering av kommentarer:',
	'SortingCommentsInfo'		=> 'Endrer rekkefølgen på kommentarer til siden blir presentert, enten med den nyeste ELLER den eldste kommentaren øverst.',
	'CommentsOffset'			=> 'Kommentarer side:',
	'CommentsOffsetInfo'		=> 'Kommentarer siden som skal vises som standard',

	'ToolbarSection'			=> 'Verktøylinje',
	'CommentsPanel'				=> 'Panelet for kommentarer:',
	'CommentsPanelInfo'			=> 'Standardvisningen av kommentarer nederst på siden.',
	'FilePanel'					=> 'Fil panel:',
	'FilePanelInfo'				=> 'Standard visning av vedlegg nederst på siden.',
	'TagsPanel'					=> 'Etiketter panel:',
	'TagsPanelInfo'				=> 'Standard visning av knagg-panelet nederst på siden.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Vis permalink:',
	'ShowPermalinkInfo'			=> 'Standard visning av permalenke for den gjeldende versjonen av siden.',
	'TocPanel'					=> 'Tabell over innholdspanel:',
	'TocPanelInfo'				=> 'Den standard visningstabellen på innholdspanelet på en side (kan trenge støtte i malene).',
	'SectionsPanel'				=> 'Deler panel:',
	'SectionsPanelInfo'			=> 'Som standard må du vise panelet på tilstøtende sider (krever støtte i malene).',
	'DisplayingSections'		=> 'Viser seksjoner:',
	'DisplayingSectionsInfo'	=> 'Når de forrige alternativene er angitt, om du vil vise bare undersider til siden (<em>nedre</em>), bare nabo (<em>øverst</em>), begge eller andre (<em>tre</em>).',
	'MenuItems'					=> 'Menyelementer:',
	'MenuItemsInfo'				=> 'Standard antall viste menyelementer (kan trenge støtte i malene).',

	'HandlerSection'			=> 'Handlers',
	'HideRevisions'				=> 'Skjul versjoner:',
	'HideRevisionsInfo'			=> 'Standardvisningen av revisjoner av siden.',
	'AttachmentHandler'			=> 'Aktiver vedlegg behandler:',
	'AttachmentHandlerInfo'		=> 'Tillater visning av vedlegg behandler.',
	'SourceHandler'				=> 'Aktiver kildebehandler:',
	'SourceHandlerInfo'			=> 'Permits the display of the source manager. (Automatic Copy)',
	'ExportHandler'				=> 'Aktiver XML-eksportbehandler:',
	'ExportHandlerInfo'			=> 'Tillat visning av XML-eksportbehandleren.',

	'DiffModeSection'			=> 'Forskjell moduser',
	'DefaultDiffModeSetting'	=> 'Standard diff modus:',
	'DefaultDiffModeSettingInfo'=> 'Preselected diff mode.',
	'AllowedDiffMode'			=> 'Tillatte diff moduser:',
	'AllowedDiffModeInfo'		=> 'Det anbefales å bare velge de forskjellige modusene du ønsker å bruke, hvis ikke alle disff moduser er valgt.',
	'NotifyDiffMode'			=> 'Varsle diff modus:',
	'NotifyDiffModeInfo'		=> 'Diff-modus brukes for varsler i e-postmeldingen.',

	'EditingSection'			=> 'Redigering',
	'EditSummary'				=> 'Rediger sammendrag:',
	'EditSummaryInfo'			=> 'Viser sammendrag av serier i redigeringsmodus.',
	'MinorEdit'					=> 'Minor redigering:',
	'MinorEditInfo'				=> 'Aktiverer mindre redigeringsalternativ i redigeringsmodus.',
	'SectionEdit'				=> 'Avsnitt redigering:',
	'SectionEditInfo'			=> 'Aktiverer bare redigering av en seksjon av en side.',
	'ReviewSettings'			=> 'Gjennomgang:',
	'ReviewSettingsInfo'		=> 'Aktiverer for anmeldelse i redigeringsmodus.',
	'PublishAnonymously'		=> 'Tillat anonym publisering:',
	'PublishAnonymouslyInfo'	=> 'Tillat brukere å publisere anonymt (for å skjule navnet).',

	'DefaultRenameRedirect'		=> 'Når du navngir det, opprett omadressering:',
	'DefaultRenameRedirectInfo'	=> 'Som standard er det tilbudt å angi en omdirigering til den gamle adressen til siden som får nytt navn.',
	'StoreDeletedPages'			=> 'Behold slettede sider:',
	'StoreDeletedPagesInfo'		=> 'Når du sletter en side, en kommentar eller en fil, behold den i en spesiell del, der den vil være tilgjengelig for gjennomgang og gjenvinning i en periode (som beskrevet nedenfor).',
	'KeepDeletedTime'			=> 'Lagringstid på slettede sider:',
	'KeepDeletedTimeInfo'		=> 'Perioden i dager. Det er fornuftig bare med det forrige alternativet. Bruk 0 for å sikre at enheter aldri slettes (i denne saken kan administratoren fjerne "handlekurv" manuelt).',
	'PagesPurgeTime'			=> 'Oppbevaringstid på siden revisjoner:',
	'PagesPurgeTimeInfo'		=> 'Slett de eldre versjonene automatisk innen de angitte antall dager. Hvis du angir null, vil de eldre versjonene ikke fjernes.',
	'EnableReferrers'			=> 'Aktiver referanser:',
	'EnableReferrersInfo'		=> 'Tillatelser til å opprette og vise eksterne referanser',
	'ReferrersPurgeTime'		=> 'Oppbevaringstid for henvisere:',
	'ReferrersPurgeTimeInfo'	=> 'Hold historien om henvisning til eksterne sider ikke lenger enn et gitt antall dager. Bruk null for å sikre at henvisninger aldri slettes (men for et aktivt besøkt nettsted kan dette føre til databaseoverflyt).',
	'EnableCounters'			=> 'Antall treff:',
	'EnableCountersInfo'		=> 'Tillater per treff-side-tellere og aktiverer visning av enkel statistikk. Visninger av sideeier er ikke teller.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Kontroller standardinnstillingene for syndikering av nettet for ditt nettsted.',
	'SyndicationSettingsUpdated'	=> 'Oppdaterte syndikeringsinnstillinger.',

	'FeedsSection'				=> 'Strøm',
	'EnableFeeds'				=> 'Aktiver feeds:',
	'EnableFeedsInfo'			=> 'Skrur RSS-feeder av eller på for hele wikien.',
	'XmlChangeLink'				=> 'Modus for endringer av feedlink:',
	'XmlChangeLinkInfo'			=> 'Angir hvor XML Endrer kanalene lenker til.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'differanse visning',
		'2'		=> 'den reviderte siden',
		'3'		=> 'liste over revisjoner',
		'4'		=> 'den gjeldende siden',
	],

	'XmlSitemap'				=> 'XML sitemap:',
	'XmlSitemapInfo'			=> 'Oppretter en XML-fil som heter %1 i xml-mappen. Du kan legge til stien i sidekartet i robots.txt-filen i din rotmappe som følger:',
	'XmlSitemapGz'				=> 'XML sidekart kompresjon:',
	'XmlSitemapGzInfo'			=> 'Hvis du ønsker det, kan du komprimere tekstfilen for nettstedskart med gzip for å redusere kravet til båndbredde.',
	'XmlSitemapTime'			=> 'XML nettsidekart genereringstid:',
	'XmlSitemapTimeInfo'		=> 'Genererer kun sidekartet en gang i det angitte antall dager. Sett til null for å generere på hver side endring.',

	'SearchSection'				=> 'Søk',
	'OpenSearch'				=> 'OpenSøk:',
	'OpenSearchInfo'			=> 'Oppretter OpenSearch beskrivelsesfilen i XML-mappen og gjør det mulig å oppdage søkeplugin automatisk i HTML-overskriften.',
	'SearchEngineVisibility'	=> 'Blokker søkemotorer (søkemotorens synlighet):',
	'SearchEngineVisibilityInfo'=> 'Blokker søkemotor, men tillatt normale besøkende. Overstyrer sideinnstillinger. <br>Oppmuntre søkemotorer fra å indekserer dette nettstedet. Det er opp til søkemotorer å hedre denne forespørselen.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Kontroller standardinnstillingene for skjermen for nettsiden.',
	'AppearanceSettingsUpdated'	=> 'Oppdatert utseendemenyen.',

	'LogoOff'					=> 'Av',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo og tittel',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Nettsteds logo:',
	'SiteLogoInfo'				=> 'Din logo vil vanligvis dukke opp øverst til venstre i programmet. Maksimumsstørrelsen er 2 MiB. Optimale dimensjoner er 255 piksler store med 55 piksler høye.',
	'LogoDimensions'			=> 'Logo-dimensjoner:',
	'LogoDimensionsInfo'		=> 'Bredde og høyden på den viste logoen.',
	'LogoDisplayMode'			=> 'Logo skjermmodus:',
	'LogoDisplayModeInfo'		=> 'Definerer utseendet på logoen. Standard er av.',

	'FaviconSection'			=> 'Favikon',
	'SiteFavicon'				=> 'Sidens favicon:',
	'SiteFaviconInfo'			=> 'Snarveiikonet, eller favicon, vises i adresselinjen, faner og bokmerker for de fleste nettlesere. Dette vil overstyre favicon til tema.',
	'SiteFaviconTooBig'			=> 'Favicon er større enn 64 x 64 px.',
	'ThemeColor'				=> 'Tema farge for adresselinjen:',
	'ThemeColorInfo'			=> 'Nettleseren vil angi adressefargen på hver side i henhold til angitt CSS-farge.',

	'LayoutSection'				=> 'Oppsett',
	'Theme'						=> 'Tema:',
	'ThemeInfo'					=> 'Designmal siden bruker som standard.',
	'ResetUserTheme'			=> 'Tilbakestill alle brukertemaer:',
	'ResetUserThemeInfo'		=> 'Nullstiller alle brukertemaene. Advarsel: Denne handlingen vil tilbakestille alle brukervalgte temaer til det globale standardtemaet.',
	'SetBackUserTheme'			=> 'Tilbakestill alle brukertemaer til %1 temaet.',
	'ThemesAllowed'				=> 'Tillatte temaer:',
	'ThemesAllowedInfo'			=> 'Velg de tillatte temaene som brukeren kan velge. Ellers er alle tilgjengelige temaer tillatt.',
	'ThemesPerPage'				=> 'Temaer per side:',
	'ThemesPerPageInfo'			=> 'Tillat temaer per side, som sideeieren kan velge via side-egenskaper.',

	// System settings
	'SystemSettingsInfo'		=> 'Gruppe med parametere som er ansvarlige for å finjustere nettstedet. Ikke endre siden med mindre du er sikker på handlingene deres.',
	'SystemSettingsUpdated'		=> 'Oppdaterte systeminnstillinger',

	'DebugModeSection'			=> 'Feilsøk modus',
	'DebugMode'					=> 'Debug modus:',
	'DebugModeInfo'				=> 'Utpakking og telemetridata om søknadens gjennomføringstid. NB: Full detaljmodus stiller høyere krav til allokert hukommelse, spesielt ressurskrevende operasjoner som sikkerhetskopiering og gjenoppretting av databaser.',
	'DebugModes'	=> [
		'0'		=> 'feilsøking er av',
		'1'		=> 'bare den totale gjennomføringstiden',
		'2'		=> 'fulltid',
		'3'		=> 'fullstendig detalj (DBMS, cache, osv.)',
	],
	'DebugSqlThreshold'			=> 'Terskelens ytelse RDBMS:',
	'DebugSqlThresholdInfo'		=> 'I detaljert feilsøkingsmodus er det kun spørringer som tar lengre tid enn det antall sekunder som er angitt.',
	'DebugAdminOnly'			=> 'Lukket diagnose:',
	'DebugAdminOnlyInfo'		=> 'Vis bare feilsøkingsinformasjon av programmet (og DBMS) for administrator.',

	'CachingSection'			=> 'Alternativer for hurtiglagring',
	'Cache'						=> 'Cache gjengitte sider:',
	'CacheInfo'					=> 'Lagre gjengitte sider i den lokale mellomlageret for å øke hastigheten på neste oppstart. Gyldig bare for uregistrerte besøkende.',
	'CacheTtl'					=> 'Tid-til-live for bufrede sider',
	'CacheTtlInfo'				=> 'Cachesider ikke mer enn et angitt antall sekunder.',
	'CacheSql'					=> 'Cache DBMS spørringer:',
	'CacheSqlInfo'				=> 'Oppretthold en lokal cache av resultatene av visse ressursrelaterte SQL-spørringer.',
	'CacheSqlTtl'				=> 'Tid-til-live for cachede SQL spørringer:',
	'CacheSqlTtlInfo'			=> 'Cacheresultater for SQL-spørringer i høyere enn det angitte antall sekunder. Verdier høyere enn 1200 er ikke ønskelig.',

	'LogSection'				=> 'Logg innstillinger',
	'LogLevelUsage'				=> 'Bruk logging:',
	'LogLevelUsageInfo'			=> 'Minste prioritet for hendelsene oppført i loggen.',
	'LogThresholds'	=> [
		'0'		=> 'ikke beholder journalen',
		'1'		=> 'bare det kritiske nivået',
		'2'		=> 'fra det høyeste nivået',
		'3'		=> 'fra høy',
		'4'		=> 'i gjennomsnitt',
		'5'		=> 'fra lav',
		'6'		=> 'minste nivå',
		'7'		=> 'hent alle',
	],
	'LogDefaultShow'			=> 'Vis loggmodus:',
	'LogDefaultShowInfo'		=> 'Minimumsprioritetshendelser vises i loggen som standard.',
	'LogModes'	=> [
		'1'		=> 'bare det kritiske nivået',
		'2'		=> 'fra det høyeste nivået',
		'3'		=> 'fra høyt nivå',
		'4'		=> 'gjennomsnittet',
		'5'		=> 'fra en lav',
		'6'		=> 'fra minste nivå',
		'7'		=> 'vis alle',
	],
	'LogPurgeTime'				=> 'Lagringstid for loggen:',
	'LogPurgeTimeInfo'			=> 'Fjern hendelsesloggen etter angitt antall dager.',

	'PrivacySection'			=> 'Personvern',
	'AnonymizeIp'				=> 'Anonymiser brukernes IP-adresser:',
	'AnonymizeIpInfo'			=> 'Anonymiser IP-adresser der det er aktuelt (f.eks. side, revisjon eller referanser).',

	'ReverseProxySection'		=> 'Revers proxy',
	'ReverseProxy'				=> 'Bruk omvendt proxy:',
	'ReverseProxyInfo'			=> 'Aktiver denne innstillingen for å fastsette korrekt IP-adresse til fjernklienten ved å undersøke informasjon lagret i X-Forwarded-For overskrifter. X-Forwarded-For headere er en standardmekanisme for å identifisere klientsystemer som kobles til via en revers proxy-server, som firkant eller Pound. Reverser proxyservere blir ofte brukt til å forbedre ytelsen til tungt besøkte nettsteder og kan også gi andre tjenester som fungerer på nettstedet, sikkerhet eller kryptering. Hvis denne WackoWiki-installasjonen opererer bak en omvendt proxy, denne innstillingen bør aktiveres slik at korrekt IP-adresseinformasjon fanges opp i WackoWikis øktbehandling, logging, statistikk og tilgang til styringssystemer; hvis du er usikker på denne innstillingen, ikke har omvendt proxy, eller WackoWiki opererer i et felles hostingsmiljø, denne innstillingen bør forbli deaktivert.',
	'ReverseProxyHeader'		=> 'Revers proxy header:',
	'ReverseProxyHeaderInfo'	=> 'Angi denne verdien hvis proxytjenen din sender klientens IP i en overskrift
									 ⋅εεεεεεεεεε^ other than X-Forwarded-For. (Automatic Translation) Overskriften "X-Forwarded-For" er en kommaseparert liste over IP
									 εephalephalephalephalephalε″addresses; bare den siste (den venstremest) vil bli brukt.',
	'ReverseProxyAddresses'		=> 'reverse_proxy godtar en liste med IP-adresser:',
	'ReverseProxyAddressesInfo'	=> 'Hvert element i denne matrisen er IP-adressen til en av dine omvendte
									 proxyer. Hvis du bruker denne matrisen, vil WackoWiki stole på informasjonen som er lagret
									 i X-Forwarded-For-overskriftene bare hvis den eksterne IP-adressen er en av
									 disse, det vil si at forespørselen når webserveren fra en av dine
									 omvendte proxyer. Ellers kan klienten koble seg direkte til
									 webserveren din ved å forfalske X-Forwarded-For-overskriftene.',

	'SessionSection'				=> 'Økt håndtering',
	'SessionStorage'				=> 'Økt-lager:',
	'SessionStorageInfo'			=> 'Dette alternativet definerer hvor øktdataene er lagret. Som standard blir enten fil eller databaseøktlagring valgt.',
	'SessionModes'	=> [
		'1'		=> 'Fil',
		'2'		=> 'Databasen',
	],
	'SessionNotice'					=> 'Sesjonens avslutningsmelding:',
	'SessionNoticeInfo'				=> 'Indikerer årsaken til oppsigelsen av økten.',
	'LoginNotice'					=> 'Innlogging varsel:',
	'LoginNoticeInfo'				=> 'Viser informasjon om innlogging.',

	'RewriteMode'					=> 'Bruk <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Hvis din web-server støtter denne funksjonen, aktiver "vakker" sidens URL-er.<br>
										εεεεεεεεεε″										<span class="cite">Verdien kan overskrives av innstillingsklassen på kjøretidspunktet. uavhengig om den er slått av, hvis HTTP_MOD_REWRITE er på.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parametere ansvarlig for tilgangskontroll og -tillatelser.',
	'PermissionsSettingsUpdated'	=> 'Oppdaterte tillatelsesinnstillinger',

	'PermissionsSection'		=> 'Rettigheter og rettigheter',
	'ReadRights'				=> 'Lesetilgang som standard:',
	'ReadRightsInfo'			=> 'Standard tilordnet de opprettede rotsidene, samt sider som foreldre ACL ikke kan defineres til.',
	'WriteRights'				=> 'Skrive rettigheter som standard:',
	'WriteRightsInfo'			=> 'Standard tilordnet de opprettede rotsidene, samt sider som foreldre ACL ikke kan defineres til.',
	'CommentRights'				=> 'Kommentar rettigheter som standard:',
	'CommentRightsInfo'			=> 'Standard tilordnet de opprettede rotsidene, samt sider som foreldre ACL ikke kan defineres til.',
	'CreateRights'				=> 'Lag underside rettigheter som standard:',
	'CreateRightsInfo'			=> 'Standard tilordnet de opprettede undersidene.',
	'UploadRights'				=> 'Opplastingsrettigheter som standard:',
	'UploadRightsInfo'			=> 'Standard opplasting-rettigheter.',
	'RenameRights'				=> 'Global endre navn på høyre:',
	'RenameRightsInfo'			=> 'Listen over tillatelser for fritt å gi nytt navn (flyttende) sider.',

	'LockAcl'					=> 'Lås alle ACLs til å lese:',
	'LockAclInfo'				=> '<span class="cite">Overskriver ACL-innstillingene for alle sider for kun å lese.</span><br>Dette kan være nyttig hvis et prosjekt er fullført, du vil ha tett redigering i en periode av sikkerhetsgrunner, eller som en nødreaksjon på en utnyttelse eller sårbarhet.',
	'HideLocked'				=> 'Skjul utilgjengelige sider:',
	'HideLockedInfo'			=> 'Hvis brukeren ikke har tillatelse til å lese siden, skjule det i en annen sideliste (men lenken i teksten vil fortsatt være synlig).',
	'RemoveOnlyAdmins'			=> 'Kun administratorer kan slette sider:',
	'RemoveOnlyAdminsInfo'		=> 'Nekt alt, unntatt administratorer, evne til å slette sider. Den første grensen gjelder eiere på vanlige sider.',
	'OwnersRemoveComments'		=> 'Eiere av sider kan slette kommentarer:',
	'OwnersRemoveCommentsInfo'	=> 'Tillat sideeiere å moderere kommentarer på sine sider.',
	'OwnersEditCategories'		=> 'Eiere kan endre sidekategorier:',
	'OwnersEditCategoriesInfo'	=> 'Tillat eiere å endre kategorilisten over sider til nettstedet ditt (legge til ord, slett ord), tilordne en side.',
	'TermHumanModeration'		=> 'Utløpsdato for moderasjon hos mennesket:',
	'TermHumanModerationInfo'	=> 'Moderatorer kan bare redigere kommentarer hvis de ble opprettet innen dette antall dager siden (denne begrensningen gjelder ikke for den siste kommentaren i emnet).',

	'UserCanDeleteAccount'		=> 'Tillate brukere å slette sine kontoer',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parametere som er ansvarlige for den generelle sikkerheten til plattform, sikkerhetsbegrensninger og ytterligere sikkerhetsundersystemer.',
	'SecuritySettingsUpdated'	=> 'Oppdaterte sikkerhetsinnstillinger',

	'AllowRegistration'			=> 'Registrer deg på nettet:',
	'AllowRegistrationInfo'		=> 'Åpne brukerregistrering. Deaktivering av dette valget vil hindre gratis registrering, men sideadministratoren vil fortsatt kunne registrere brukere',
	'ApproveNewUser'			=> 'Godkjenn nye brukere:',
	'ApproveNewUserInfo'		=> 'Lar administratorer godkjenne brukere når de registrerer seg. Bare godkjente brukere kan logge inn på nettstedet.',
	'PersistentCookies'			=> 'Vedvarende cookies:',
	'PersistentCookiesInfo'		=> 'Tillat vedvarende informasjonskapsler.',
	'DisableWikiName'			=> 'Deaktiver WikiName:',
	'DisableWikiNameInfo'		=> 'Deaktiver den obligatoriske bruken av et WikiName for brukere. Tillat brukerregistrering med tradisjonelle kallenavn i stedet for tvunget CamelCase-formaterte navn (dvs. navn på navn).',
	'UsernameLength'			=> 'Brukernavn lengde:',
	'UsernameLengthInfo'		=> 'Minimum og maksimum antall tegn i brukernavn.',

	'EmailSection'				=> 'E-post',
	'AllowEmailReuse'			=> 'Tillat gjenbruk av e-postadresse',
	'AllowEmailReuseInfo'		=> 'Forskjellige brukere kan registrere seg med samme e-postadresse.',
	'EmailConfirmation'			=> 'Bekreft fremheving av e-post:',
	'EmailConfirmationInfo'		=> 'Krever at brukeren bekrefter sin e-postadresse før de kan logge på.',
	'AllowedEmailDomains'		=> 'Tillatte e-postdomener:',
	'AllowedEmailDomainsInfo'	=> 'Komma-separerte e-postdomener, for eksempel <code>eksempel.com, local.lan</code> osv. Hvis ikke angitt, er alle e-postdomener tillatt.',
	'ForbiddenEmailDomains'		=> 'Forbudte e-post-domener:',
	'ForbiddenEmailDomainsInfo'	=> 'Komma-separert forbudt e-postdomener, for eksempel <code>eksempel.com, local.lan</code> osv. Bare effektiv hvis tillatt e-postdomener er tom.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Aktiver captcha:',
	'EnableCaptchaInfo'			=> 'Hvis aktivert, vil captcha bli vist i følgende tilfeller, eller hvis en sikkerhetsterskel er nådd.',
	'CaptchaComment'			=> 'Ny kommentar:',
	'CaptchaCommentInfo'		=> 'Fordi beskyttelse mot spam, må uregistrerte brukere fullføre captcha før du kan kommentere.',
	'CaptchaPage'				=> 'Ny side:',
	'CaptchaPageInfo'			=> 'Som beskyttelse mot søppelpost må uregistrerte brukere fullføre captcha før du oppretter en ny side.',
	'CaptchaEdit'				=> 'Rediger side:',
	'CaptchaEditInfo'			=> 'Som beskyttelse mot søppelpost må uregistrerte brukere fullføre captcha før de redigerer sider.',
	'CaptchaRegistration'		=> 'Registrering:',
	'CaptchaRegistrationInfo'	=> 'Som beskyttelse mot spam må uregistrerte brukere fullføre captcha før registrering.',

	'TlsSection'				=> 'TLS innstillinger',
	'TlsConnection'				=> 'TLS-tilkobling:',
	'TlsConnectionInfo'			=> 'Bruk TLS-sikret tilkobling. <span class="cite">aktivere påkrevd forhåndsinstallert TLS-sertifikat på serveren, ellers vil du miste tilgang til adminpanelet!</span><br>Det avgjør også om Cookie Secure flagget er satt: <code>sikre</code> flagg angir om informasjonskapsler kun skal sendes over sikre tilkoblinger.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Forcibly koble klienten fra HTTP til HTTPS. Med valget er deaktivert, kan klienten bla gjennom nettstedet gjennom en åpen HTTP kanal.',

	'HttpSecurityHeaders'		=> 'HTTP Security Hoder',
	'EnableSecurityHeaders'		=> 'Aktiver sikkerhetsoverskrifter:',
	'EnableSecurityHeadersinfo'	=> 'Angi sikkerhetshoder (rammefeil, klikk/XSS/CSRF-beskyttelse). <br>CSP kan forårsake problemer i enkelte situasjoner (f.eks. under utviklingen eller når du bruker plugins som baserer seg på eksternt betjente ressurser som bilder eller skript. <br>deaktivering av retningslinjer for informasjonssikkerhet er en sikkerhetsrisiko!',
	'Csp'						=> 'Sikkerhetspolitikk for innhold (CSP):',
	'CspInfo'					=> 'Konfigurering av CSP innebærer å bestemme hvilke retningslinjer du vil håndheve, og deretter konfigurere dem og bruke Content-Security-policy for å etablere dine retningslinjer.',
	'PolicyModes'	=> [
		'0'		=> 'deaktivert',
		'1'		=> 'strikt',
		'2'		=> 'tilpasset',
	],
	'PermissionsPolicy'			=> 'Rettighets polis:',
	'PermissionsPolicyInfo'		=> 'HTTP-tillatelsespolicy-topptekst gir en mekanisme for eksplisitt å aktivere eller deaktivere forskjellige kraftige nettleserfunksjoner.',
	'ReferrerPolicy'			=> 'Referent policy:',
	'ReferrerPolicyInfo'		=> 'Referanseverdiene for HTTP header regulerer hvilke henvisningsinformasjon, som sendes i henvisningsoverskriften, som skal inkluderes i svar.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'ingen henviser',
		'2'		=> 'ingen henvisert-hven-nedgradering',
		'3'		=> 'samme-utgangspunkt',
		'4'		=> 'opprinnelse',
		'5'		=> 'strikt-opprinnelse',
		'6'		=> 'opprinnelse-kryss-opprinnelse',
		'7'		=> 'strikt-opprinnelse, født',
		'8'		=> 'usikker URL'
	],

	'UserPasswordSection'		=> 'Varighet av brukerpassord',
	'PwdMinChars'				=> 'Minimal passordlengde:',
	'PwdMinCharsInfo'			=> 'Lengre passord er nødvendigvis mer sikre enn kortere passord (f.eks. 12 til 16 tegn).<br>Bruk av passord i stedet for passord er oppmuntrt.',
	'AdminPwdMinChars'			=> 'Minimal lengde på admin passord:',
	'AdminPwdMinCharsInfo'		=> 'Lengre passord er nødvendigvis mer sikre enn kortere passord (f.eks. 15 til 20 tegn).<br>Bruk av passord i stedet for passord er oppmuntrt.',
	'PwdCharComplexity'			=> 'Nødvendig passord kompleksitet:',
	'PwdCharClasses'	=> [
		'0'		=> 'ikke testet',
		'1'		=> 'enhver bokstav + tall',
		'2'		=> 'store bokstaver og små tall +',
		'3'		=> 'store og små bokstaver + tall + tegn',
	],
	'PwdUnlikeLogin'			=> 'Ytterligere komplikasjon:',
	'PwdUnlikes'	=> [
		'0'		=> 'ikke testet',
		'1'		=> 'Passordet er ikke identisk med innloggingen',
		'2'		=> 'Passordet inneholder ikke brukernavn',
	],

	'LoginSection'				=> 'Innlogging',
	'MaxLoginAttempts'			=> 'Maksimalt antall påloggingsforsøk per brukernavn:',
	'MaxLoginAttemptsInfo'		=> 'Antall påloggingsforsøk som er tillatt for én konto før oppgaven med anti-spambot utløses. Angi 0 for å forhindre at anti-spambot oppgaven utløses for forskjellige brukerkontoer.',
	'IpLoginLimitMax'			=> 'Maksimalt antall påloggingsforsøk per IP-adresse:',
	'IpLoginLimitMaxInfo'		=> 'Terskelen for påloggingsforsøk tillatt fra én IP-adresse før en anti-spambot oppgave aktiveres. Angi 0 for å forhindre anti-spambot oppgaven fra å bli utløst av IP-adresser.',

	'FormsSection'				=> 'Skjemaer',
	'FormTokenTime'				=> 'Maksimal tid til å sende skjemaer:',
	'FormTokenTimeInfo'			=> 'Tiden en brukeren må sende inn et skjema (i sekunder).<br> Vær oppmerksom på at et skjema kan bli ugyldig hvis økten utløper, uavhengig av denne innstillingen.',

	'SessionLength'				=> 'Øktinformasjonskapsel utløp:',
	'SessionLengthInfo'			=> 'Levetiden til informasjonskapslene for brukerøkten som standard (i dager).',
	'CommentDelay'				=> 'Fareflom til kommentarer:',
	'CommentDelayInfo'			=> 'Minste forsinkelse mellom publisering av nye brukere (i sekunder).',
	'IntercomDelay'				=> 'Fareflommen for personlig kommunikasjon:',
	'IntercomDelayInfo'			=> 'Minste forsinkelse mellom sending av private meldinger (i sekunder).',
	'RegistrationDelay'			=> 'Terskel for tidsregistrering:',
	'RegistrationDelayInfo'		=> 'Minste tidsgrense mellom registreringsskjema for å forhindre registreringsbotter (i sekunder).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Gruppe med parametere som er ansvarlige for å finjustere nettstedet. Ikke endre siden med mindre du er sikker på handlingene deres.',
	'FormatterSettingsUpdated'	=> 'Oppdatert formateringsinnstillinger',

	'TextHandlerSection'		=> 'Tekstbehandler:',
	'Typografica'				=> 'Typisk korrektur:',
	'TypograficaInfo'			=> 'Deaktivering av dette alternativet vil fremskynde prosessene for å legge til kommentarer og lagre sider.',
	'Paragrafica'				=> 'Paragrafica markering:',
	'ParagraficaInfo'			=> 'På samme måte som det forrige alternativet, men vil føre til frakobling av ulagert automatisk innholdsfortegnelse (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Global HTML støtte:',
	'AllowRawhtmlInfo'			=> 'Dette alternativet er potensielt usikkert for et åpent nettsted.',
	'SafeHtml'					=> 'Filtrerer HTML:',
	'SafeHtmlInfo'				=> 'Forhindrer lagring av farlige HTML-objekter. Slår av filteret på en åpen nettside med HTML-støtte er <span class="underline">ekstremt</span> uønskelig!',

	'WackoFormatterSection'		=> 'Wiki tekst formatering',
	'X11colors'					=> 'X11 bruk av farger:',
	'X11colorsInfo'				=> 'Forlenger tilgjengelige farger for <code>??(farge) bakgrunn??</code> og <code>!!(farge) tekst!!</code>Deaktivering av denne alternativet, øker prosessene for å legge til kommentarer og lagre sider.',
	'WikiLinks'					=> 'Deaktivere wiki-lenker:',
	'WikiLinksInfo'				=> 'Deaktiverer kobling for <code>CamelCaseWords</code>: CamelCase ordene dine vil ikke lenger bli knyttet til en ny side. Dette er nyttig når du arbeider på tvers av navneområder/clustere. Som standard er den av.',
	'BracketsLinks'				=> 'Deaktiver parenteserte lenker:',
	'BracketsLinksInfo'			=> 'Deaktiverer <code>[[link]]</code> og <code>(link))</code> syntaks.',
	'Formatters'				=> 'Deaktiver formatterer:',
	'FormattersInfo'			=> 'Deaktiverer <code>%%code%%</code> syntaks, brukes for uthevet.',

	'DateFormatsSection'		=> 'Dato formater',
	'DateFormat'				=> 'Formatet på dato:',
	'DateFormatInfo'			=> '(dag, måned, år)',
	'TimeFormat'				=> 'Formatet på tid:',
	'TimeFormatInfo'			=> '(time, minutt)',
	'TimeFormatSeconds'			=> 'Formatet på nøyaktig tid:',
	'TimeFormatSecondsInfo'		=> '(timer, minutter, sekunder)',
	'NameDateMacro'				=> 'Formatet til <code>:@::</code> makro:',
	'NameDateMacroInfo'			=> '(navn, time), f.eks <code>BrukerNavn (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Timezone:',
	'TimezoneInfo'				=> 'Tidssone som skal brukes til å vise brukere som ikke er logget inn (gjester). Innloggede brukere kan endre tidssonen i brukerinnstillingene sine.',
	'AmericanDate'					=> 'Amerikansk dato:',
	'AmericanDateInfo'				=> 'Bruker amerikansk datoformat som standard for engelsk.',

	'Canonical'					=> 'Bruk fullt kanoniske URLer:',
	'CanonicalInfo'				=> 'Alle linker blir opprettet som absolutte URLer i skjema %1. Adresser relativt til serverroten i form %2 bør foretrekkes.',
	'LinkTarget'				=> 'Når eksterne lenker åpnes:',
	'LinkTargetInfo'			=> 'Åpner hver ekstern lenke i et nytt nettleservindu. Legger til <code>target="_blank"</code> til linken.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Krever at nettleseren ikke skal sende en HTTP-referanseoverskrift hvis brukeren følger hyperkoblingen. Legger til <code>rel="noreferrer"</code> til koblingssyntaksen.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Forteller søkemotorer som snarveiene ikke skal påvirke målsiden i søkemotorens indeks. Legger til <code>rel="nofollow"</code> til koblingens syntaks.',
	'UrlsUnderscores'			=> 'Skjemaadresser (URLer) med understrekning:',
	'UrlsUnderscoresInfo'		=> 'For eksempel beviker %1 %2 med dette valget.',
	'ShowSpaces'				=> 'Vis fellesskap i WikiName:',
	'ShowSpacesInfo'			=> 'Vis mellomrom i WikiNames, f.eks. <code>Mitt navn</code> vises som <code>Mitt navn</code> med dette alternativet.',
	'NumerateLinks'				=> 'Liste opp lenker i utskriftsvesen:',
	'NumerateLinksInfo'			=> 'Liste opp og viser alle koblingene nederst i utskriftsvinduet med dette alternativet.',
	'YouareHereText'			=> 'Deaktiver og visualiser selvrefererende lenker:',
	'YouareHereTextInfo'		=> 'Visualiser linker til samme side, ved å bruke <code>&lt;b&gt;####&lt;/b&gt;</code>. Alle linker til seg selv mister formatering, men vises som ufet tekst.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Her kan du angi eller endre systembasesider som er brukt på Wikien. Vennligst sørg for at du ikke glemmer å opprette eller endre de tilsvarende sidene i henhold til dine innstillinger her.',
	'PagesSettingsUpdated'		=> 'Oppdaterte standardsider',

	'ListCount'					=> 'Antall elementer per liste:',
	'ListCountInfo'				=> 'Antall elementer som vises på hver liste for gjest, eller som standard verdi for nye brukere.',

	'ForumSection'				=> 'Alternativer Forum',
	'ForumCluster'				=> 'Klynge forum:',
	'ForumClusterInfo'			=> 'Rootklyngen for forumseksjonen (action %1).',
	'ForumTopics'				=> 'Antall emner per side:',
	'ForumTopicsInfo'			=> 'Antall emner som vises på hver side i listen i forumseksjonene (handling %1).',
	'CommentsCount'				=> 'Antall kommentarer per side:',
	'CommentsCountInfo'			=> 'Antall kommentarer som vises på hver side sin liste over kommentarer. Dette gjelder alle kommentarene på virksomhetsstedet, ikke bare de som er lagt inn i forum.',

	'NewsSection'				=> 'Seksjon for nyheter',
	'NewsCluster'				=> 'Klynge for nyhetene:',
	'NewsClusterInfo'			=> 'Rootklyngen for nyhetsseksjonen (action %1).',
	'NewsStructure'				=> 'Nedbør i nyhetsstruktur:',
	'NewsStructureInfo'			=> 'Lagrer artiklene i underklynger ved år/måned eller uke (f.eks <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Lisens',
	'DefaultLicense'			=> 'Standard lisens:',
	'DefaultLicenseInfo'		=> 'Under hvilken lisens kan innholdet ditt bli frigitt.',
	'EnableLicense'				=> 'Aktiver lisens:',
	'EnableLicenseInfo'			=> 'Aktiver for å vise lisensinformasjon.',
	'LicensePerPage'			=> 'Lisens per side:',
	'LicensePerPageInfo'		=> 'Tillat lisens per side, som sideeieren kan velge via side-egenskaper.',

	'ServicePagesSection'		=> 'Tjeneste sider',
	'RootPage'					=> 'Hjem-side:',
	'RootPageInfo'				=> 'Tag på hovedsiden din åpnes automatisk når en bruker besøker nettstedet ditt.',

	'PrivacyPage'				=> 'Retningslinjer for personvern:',
	'PrivacyPageInfo'			=> 'Siden med nettstedets personvernerklæring.',

	'TermsPage'					=> 'Policyer og forskrifter:',
	'TermsPageInfo'				=> 'Siden med reglene for nettstedet.',

	'SearchPage'				=> 'Søk:',
	'SearchPageInfo'			=> 'Side med søkeskjema (handling %1).',
	'RegistrationPage'			=> 'Registrering:',
	'RegistrationPageInfo'		=> 'Side for ny brukerregistrering (handling %1).',
	'LoginPage'					=> 'Bruker innlogging:',
	'LoginPageInfo'				=> 'Påloggingsside på siden (handling %1).',
	'SettingsPage'				=> 'Bruker innstillinger:',
	'SettingsPageInfo'			=> 'Side for å tilpasse brukerprofilen (handling %1).',
	'PasswordPage'				=> 'Bytt Passord:',
	'PasswordPageInfo'			=> 'Side med et skjema for å endre / søke brukerpassord (handling %1).',
	'UsersPage'					=> 'Brukerliste:',
	'UsersPageInfo'				=> 'Side med en liste over registrerte brukere (handling %1).',
	'CategoryPage'				=> 'Kategori:',
	'CategoryPageInfo'			=> 'Side med en liste over kategoriserte sider (handling %1).',
	'GroupsPage'				=> 'Grupper:',
	'GroupsPageInfo'			=> 'Side med en liste over arbeidsgrupper (action %1).',
	'WhatsNewPage'				=> 'Hva er nytt:',
	'WhatsNewPageInfo'			=> 'Side med en liste over alle nye, slettede eller endrede sider, nye vedlegg og kommentarer. (action %1).',
	'ChangesPage'				=> 'Nylige endringer:',
	'ChangesPageInfo'			=> 'Side med en liste over de siste endrede sidene (action %1).',
	'CommentsPage'				=> 'Siste kommentarer:',
	'CommentsPageInfo'			=> 'Side med en liste over siste kommentarer på siden (handling %1).',
	'RemovalsPage'				=> 'Slettet sider:',
	'RemovalsPageInfo'			=> 'Side med en liste over nylig slettede sider (handling %1).',
	'WantedPage'				=> 'Ønsket sider:',
	'WantedPageInfo'			=> 'Side med en liste over manglende sider som er referert (action %1).',
	'OrphanedPage'				=> 'Foreldreløse sider',
	'OrphanedPageInfo'			=> 'Side med en liste over eksisterende sider er ikke relatert via lenker til en annen side (handling %1).',
	'SandboxPage'				=> 'Sandboks:',
	'SandboxPageInfo'			=> 'Side der brukere kan øve på wiki-markeringsferdigheter.',
	'HelpPage'					=> 'Hjelp:',
	'HelpPageInfo'				=> 'Dokumentasjonsseksjonen for arbeid med stedlig verktøy.',
	'IndexPage'					=> 'Indeks:',
	'IndexPageInfo'				=> 'Side med en liste over alle sider (action %1).',
	'RandomPage'				=> 'Tilfeldig:',
	'RandomPageInfo'			=> 'Laster inn en tilfeldig side (handling %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parametere for varsler om plattformen.',
	'NotificationSettingsUpdated'	=> 'Oppdaterte varslingsinnstillinger',

	'EmailNotification'			=> 'E-post melding:',
	'EmailNotificationInfo'		=> 'Tillat e-postvarsling. Sett til Aktiver for å aktivere e-postvarslinger, deaktivert for å deaktivere dem. Merk at det ikke har noen effekt på e-post generert som en del av brukerregistreringsprosessen.',
	'Autosubscribe'				=> 'Autosubscribe:',
	'AutosubscribeInfo'			=> 'varsle eieren om sideendringer automatisk',

	'NotificationSection'		=> 'Standard innstillinger for brukervarsel',
	'NotifyPageEdit'			=> 'Varsle sideredigering:',
	'NotifyPageEditInfo'		=> 'Venter - Send kun e-post varsel for første endring til brukeren besøker siden igjen.',
	'NotifyMinorEdit'			=> 'Varsle underordnet redigering:',
	'NotifyMinorEditInfo'		=> 'Sender varsler for mindre redigeringer.',
	'NotifyNewComment'			=> 'Varsle ny kommentar:',
	'NotifyNewCommentInfo'		=> 'Venter - Send kun e-postvarsel for den første kommentaren til brukeren besøker siden igjen.',

	'NotifyUserAccount'			=> 'Varsle ny brukerkonto:',
	'NotifyUserAccountInfo'		=> 'Admin vil bli varslet når en ny bruker har blitt opprettet ved hjelp av registreringsskjemaet.',
	'NotifyUpload'				=> 'Varsle fil opplasting:',
	'NotifyUploadInfo'			=> 'Moderatorene vil bli varslet når en fil er blitt lastet opp.',

	'PersonalMessagesSection'	=> 'Personlige meldinger',
	'AllowIntercomDefault'		=> 'Tillat samspill:',
	'AllowIntercomDefaultInfo'	=> 'Aktivering av dette alternativet tillater andre brukere å sende personlige meldinger til mottakerens e-postadresse uten å sende denne adressen.',
	'AllowMassemailDefault'		=> 'Tillat masse epost:',
	'AllowMassemailDefaultInfo'	=> 'Send bare meldinger til de brukere som har tillatt administratorer for å sende dem informasjon.',

	// Resync settings
	'Synchronize'				=> 'Synchronize',
	'UserStatsSynched'			=> 'Brukerstatistikk er synkronisert.',
	'PageStatsSynched'			=> 'Sidestatistikk er synkronisert.',
	'FeedsUpdated'				=> 'RSS-strømmer oppdatert.',
	'SiteMapCreated'			=> 'Den nye versjonen av nettstedskartet ble opprettet.',
	'ParseNextBatch'			=> 'Analyser neste bunt av sider:',
	'WikiLinksRestored'			=> 'Wiki-lenker gjenopprettet.',

	'LogUserStatsSynched'		=> 'Synkroniserte brukerstatistikker',
	'LogPageStatsSynched'		=> 'Synkronisert sidestatistikk',
	'LogFeedsUpdated'			=> 'Synkroniserte RSS-strømmer',
	'LogPageBodySynched'		=> 'Reparert side body og linker',

	'UserStats'					=> 'Brukerstatistikk',
	'UserStatsInfo'				=> 'Brukerstatistikk (antall kommentarer, eide sider, revisjoner og filer) kan variere i enkelte situasjoner fra faktiske data. <br>Denne operasjonen tillater oppdatering av statistikk for å samsvare med faktiske data i databasen.',
	'PageStats'					=> 'Sidens statistikk',
	'PageStatsInfo'				=> 'Sidestatistikk (antall kommentarer, filer og versjoner) kan variere i noen situasjoner fra faktiske data. <br>Denne operasjonen tillater oppdatering av statistikk for å samsvare med faktiske data i databasen.',

	'AttachmentsInfo'			=> 'Oppdater filhash for alle vedlegg i databasen.',
	'AttachmentsSynched'		=> 'Re-hashed alle filvedlegg',
	'LogAttachmentsSynched'		=> 'Re-hashed alle filvedlegg',

	'Feeds'						=> 'Strøm',
	'FeedsInfo'					=> 'Ved direkte redigering av sider i databasen kan ikke innholdet i RSS-strømmer gjenspeile endringene som er gjort. <br>Denne funksjonen synkroniserer RSS-kanalene med gjeldende tilstand i databasen.',
	'XmlSiteMap'				=> 'XML Sitemap',
	'XmlSiteMapInfo'			=> 'Denne funksjonen synkroniserer XML-Sidekartet med nåværende tilstand i databasen.',
	'XmlSiteMapPeriod'			=> 'Periode %1 dager. Sist skrevet %2.',
	'XmlSiteMapView'			=> 'Vis sidekart i et nytt vindu.',

	'ReparseBody'				=> 'Overfør alle sider',
	'ReparseBodyInfo'			=> 'Keiser <code>body_r</code> i side-tabellen, slik at hver side blir gjengitt igjen på neste sidevisning. Dette kan være nyttig hvis du har endret formatteret eller endret domenet til wikien din.',
	'PreparsedBodyPurged'		=> 'Tømt <code>body_r</code> feltet i sidetabellen.',

	'WikiLinksResync'			=> 'Wiki lenker',
	'WikiLinksResyncInfo'		=> 'Utfører en re-gjengivelse for alle intrasittlinker og gjenoppretter innholdet i <code>page_link</code> og <code>file_link</code> tabellene i tilfelle skade eller omplassering (dette kan ta lang tid).',
	'RecompilePage'				=> 'Re-kompilerer alle sider (svært kostbare)',
	'ResyncOptions'				=> 'Flere alternativer',
	'RecompilePageLimit'		=> 'Antall sider å analysere på en gang.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Denne informasjonen brukes når motoren sender e-post til dine brukere. Kontroller at e-postadressen som du angav er gyldig, da eventuelle returprodukter eller uleverbare meldinger sannsynligvis vil bli sendt til den adressen. Hvis din vertsleverandør ikke gir en opprinnelig (PHP-basert) e-posttjeneste, kan du i stedet sende meldinger direkte ved hjelp av SMTP. Dette krever adressen til en passende server (spør din leverandør av webhotell om nødvendig). Dersom serveren krever godkjenning (og bare hvis den gjør), skriv inn nødvendig brukernavn, passord og autentiseringsmetode.',

	'EmailSettingsUpdated'		=> 'Oppdaterte e-postinnstillinger',

	'EmailFunctionName'			=> 'E-post funksjonsnavn:',
	'EmailFunctionNameInfo'		=> 'E-postfunksjonen brukes til å sende e-postmeldinger gjennom PHP.',
	'UseSmtpInfo'				=> 'Velg <code>SMTP</code> hvis du vil, eller måtte sende e-post via en navngitt tjener i stedet for via den lokale e-postfunksjonen.',

	'EnableEmail'				=> 'Aktiver e-post:',
	'EnableEmailInfo'			=> 'Aktiver sending av e-post.',

	'EmailIdentitySettings'		=> 'Nettsted e-postidentiteter',
	'FromEmailName'				=> 'Fra navn:',
	'FromEmailNameInfo'			=> 'Avsendernavnet som er brukt for <code>Fra:</code> header for alle e-postvarsler sendt fra nettstedet.',
	'EmailSubjectPrefix'		=> 'Prefiks for emne:',
	'EmailSubjectPrefixInfo'	=> 'Alternativ emnets prefiks, f.eks <code>[Prefix] Emne</code>. Hvis ikke definert, er standard prefiks sidenavn: %1.',

	'NoReplyEmail'				=> 'Ikke noe svaradresse:',
	'NoReplyEmailInfo'			=> 'Denne adressen, f.eks. <code>noreply@example.com</code>, vil vises i <code>Fra:</code> e-postfelt for alle e-postvarsler sendt fra nettstedet.',
	'AdminEmail'				=> 'E-postadressen til nettstedets eier:',
	'AdminEmailInfo'			=> 'Denne adressen brukes til admin formål, som for eksempel ny brukervarsel.',
	'AbuseEmail'				=> 'E-post misbrukstjeneste',
	'AbuseEmailInfo'			=> 'Reklameønske for hastesaker: registrering på utlendingspost osv. Det kan være det samme som nettsidens eier.',

	'SendTestEmail'				=> 'Send en test-epost',
	'SendTestEmailInfo'			=> 'Dette sender en test-e-post til adressen som er angitt på kontoen din.',
	'TestEmailSubject'			=> 'Din Wiki er riktig konfigurert til å sende e-post',
	'TestEmailBody'				=> 'Hvis du har mottatt denne e-posten, er din Wiki riktig konfigurert til å sende e-post.',
	'TestEmailMessage'			=> 'Test-e-posten har blitt sendt.<br>Hvis du ikke mottar den, vennligst sjekk innstillingene for e-postkonfigurasjon.',

	'SmtpSettings'				=> 'SMTP Innstillinger',
	'SmtpAutoTls'				=> 'Opportunistisk TLS:',
	'SmtpAutoTlsInfo'			=> 'Aktiverer kryptering automatisk, hvis den ser at tjeneren annonserer TLS-kryptering (etter at du har koblet til serveren), selv om du ikke har satt tilkoblingsmodus for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Tilkoblingsmodus for SMTP:',
	'SmtpConnectionModeInfo'	=> 'Brukes bare hvis det kreves et brukernavn/passord. Spør leverandøren hvis du er usikker på hvilken metode du skal bruke',
	'SmtpPassword'				=> 'SMTP passord:',
	'SmtpPasswordInfo'			=> 'Du må kun skrive inn et passord hvis SMTP-serveren din trenger det.<br><em><strong>Advarsel:</strong> Dette passordet vil bli lagret som klartekst i databasen, synlig for alle som kan få tilgang til databasen din eller som kan se denne konfigurasjonssiden.</em>',
	'SmtpPort'					=> 'SMTP server port:',
	'SmtpPortInfo'				=> 'Endre dette bare dersom du vet at SMTP-serveren din er på en annen port. <br>(standard: <code>tls</code> på port 587 (eller muligens 25) og <code>sl</code> på port 465).',
	'SmtpServer'				=> 'SMTP serveradresse:',
	'SmtpServerInfo'			=> 'Merk at du må oppgi protokollen som deres server bruker. Hvis du bruker SSL, må dette være <code>ssl://mail.example.com</code>.',
	'SmtpUsername'				=> 'SMTP brukernavn:',
	'SmtpUsernameInfo'			=> 'Du må kun skrive inn et brukernavn dersom SMTP-serveren din trenger det.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Her kan du konfigurere hovedinnstillingene for vedlegg og de tilknyttede spesialkategorier.',
	'UploadSettingsUpdated'		=> 'Oppdaterte opplastingsinnstillinger',

	'FileUploadsSection'		=> 'Fil opplastinger',
	'RegisteredUsers'			=> 'registrerte brukere',
	'RightToUpload'				=> 'Tillatelse til å laste opp filer:',
	'RightToUploadInfo'			=> '<code>admins</code> betyr at bare brukere som tilhører administratorgruppen kan laste opp filer. <code>1</code> betyr at opplasting er åpnet for registrerte brukere. <code>0</code> betyr at opplasting er deaktivert.',
	'UploadMaxFilesize'			=> 'Maksimal filstørrelse:',
	'UploadMaxFilesizeInfo'		=> 'Maksimal størrelse for hver fil. Hvis denne verdien er 0, blir maksimal opplastbar filstørrelse bare begrenset av PHP-konfigurasjonen.',
	'UploadQuota'				=> 'Totalt vedlegg kvote:',
	'UploadQuotaInfo'			=> 'Den maksimale stasjonsområdet er tilgjengelig for vedlegg til hele wikien, med <code>0</code> er ubegrenset. %1 brukt.',
	'UploadQuotaUser'			=> 'Lagringskvote per bruker:',
	'UploadQuotaUserInfo'		=> 'Begrensning på kvote for lagring som kan lastes opp av en bruker, mens <code>0</code> er ubegrenset.',

	'FileTypes'					=> 'Fil typer',
	'UploadOnlyImages'			=> 'Tillat kun opplasting av bilder:',
	'UploadOnlyImagesInfo'		=> 'Tillat kun opplasting av bildefiler på siden.',
	'AllowedUploadExts'			=> 'Tillatte filtyper:',
	'AllowedUploadExtsInfo'		=> 'Tillatte utvidelser for opplasting av filer, kommaseparert (dvs. <code>png, ogg, mp4</code>); alle filtyper er tillatt.<br>Du bør begrense de tillatte filendelsene til det minimum som kreves for funksjonaliteten til nettstedet.',
	'CheckMimetype'				=> 'Sjekk på MIME-type:',
	'CheckMimetypeInfo'			=> 'Noen nettlesere kan bli lurt å anta en feilaktig mimetype for opplastede filer. Dette alternativet sikrer at slike filer sannsynligvis forårsaker dette blir avvist.',
	'SvgSanitizer'				=> 'SVG sanitizer:',
	'SvgSanitizerInfo'			=> 'Dette gjør det mulig for saniterende SVG-filer å hindre SVG/XML-sårbarheter å bli lastet opp.',
	'TranslitFileName'			=> 'Oversett filnavn:',
	'TranslitFileNameInfo'		=> 'Hvis det er aktuelt og det ikke er nødvendig å ha Unicode tegn, anbefales det å bare godta alfanumeriske tegn i filnavn.',
	'TranslitCaseFolding'		=> 'Konverter filnavn til liten kasse:',
	'TranslitCaseFoldingInfo'	=> 'Dette alternativet er bare effektivt med aktiv oversettelse.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Create thumbnail:',
	'CreateThumbnailInfo'		=> 'Lag et miniatyrbilde i alle mulige situasjoner.',
	'JpegQuality'				=> 'JPEG kvalitet:',
	'JpegQualityInfo'			=> 'Kvalitet når JPEG skaleres. Det bør være mellom 1 og 100, med 100 indikerer 100% kvalitet.',
	'MaxImageArea'				=> 'Maksimalt bildeområde:',
	'MaxImageAreaInfo'			=> 'Maksimalt antall piksler et kildebilde kan ha. Dette gir en grense for minnebruk for dekomprimeringssiden av bildeskalaen.<br><code>-1</code> betyr at bildet ikke vil sjekke før du prøver å skalere det. <code>0</code> betyr at verdien vil bli automatisk fastsatt.',
	'MaxThumbWidth'				=> 'Maks miniatyrbilde bredde i piksler:',
	'MaxThumbWidthInfo'			=> 'Et generert miniatyrbilde vil ikke overstige bredden angitt her.',
	'MinThumbFilesize'			=> 'Minimum miniatyrbilde filstørrelse:',
	'MinThumbFilesizeInfo'		=> 'Ikke lag et miniatyrbilde for mindre bilder enn dette.',
	'MaxImageWidth'				=> 'Bildestørrelse på sider',
	'MaxImageWidthInfo'			=> 'Maksimal bredde på et bilde kan ha på sider, ellers genereres et skalert miniatyrbilde.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Liste over slettede sider, revisjoner og filer.
									KABKABGlenεεεεεεε″Fjern eller gjenopprett sidene, Revisjoner eller filer fra databasen ved å klikke på koblingen <em>Fjern</em>
									Connuflue εεεεεεephalephalephaló eller <em>Gjenoppretter</em> i tilsvarende rad. (Be forsiktig, ingen slette-bekreftelse er forespurt!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Ord som vil bli sensurert automatisk på din Wiki.',
	'FilterSettingsUpdated'		=> 'Oppdaterte spam filterinnstillinger',

	'WordCensoringSection'		=> 'Word Censoring',
	'SPAMFilter'				=> 'Spam filter:',
	'SPAMFilterInfo'			=> 'Aktiverer søppelpostfilter',
	'WordList'					=> 'Ordliste :',
	'WordListInfo'				=> 'Ord eller uttrykk <code>fragment</code> som skal være svartelistet (en per linje)',

	// Log module
	'LogFilterTip'				=> 'Filtrer hendelser etter kriterier:',
	'LogLevel'					=> 'Nivå',
	'LogLevelFilters'	=> [
		'1'		=> 'ikke mindre enn',
		'2'		=> 'ikke høyere enn',
		'3'		=> 'lik',
	],
	'LogNoMatch'				=> 'Ingen hendelser som oppfyller kriteriene',
	'LogDate'					=> 'Dato',
	'LogEvent'					=> 'Hendelse',
	'LogUsername'				=> 'Brukernavn',
	'LogLevels'	=> [
		'1'		=> 'kritisk',
		'2'		=> 'høyeste',
		'3'		=> 'høy',
		'4'		=> 'middels',
		'5'		=> 'lav',
		'6'		=> 'lavest',
		'7'		=> 'feilsøking',
	],

	// Massemail module
	'MassemailInfo'				=> 'Her kan du sende en melding til om (1) alle brukerne eller (2) til alle brukere av en bestemt gruppe som har aktivert å motta massee-post. En e-post vil bli sendt ut til den leverte administratoradressen, med en blind karbonkopi (BCC) som sendes til alle mottakere. Standardinnstillingen er å inkludere maksimalt 20 mottakere i en slik e-post. Er det mer enn 20 mottakere, sendes ytterligere e-postmeldinger. Hvis du sender fra en stor gruppe mennesker, vennligst vær tålmodig etter at du har sendt inn siden halvveis gjennom. Det er normalt for en massee-postmelding å ta lang tid. Du vil bli varslet når skriptet er fullført.',
	'LogMassemail'				=> 'Masseutsending av e-post %1 til gruppen / brukeren ',
	'MassemailSend'				=> 'Masseutsending av e-post',

	'NoEmailMessage'			=> 'Du må skrive inn en melding.',
	'NoEmailSubject'			=> 'Du må angi et emne for meldingen.',
	'NoEmailRecipient'			=> 'Du må angi minst én bruker eller gruppe.',

	'MassemailSection'			=> 'Masse e-post',
	'MessageSubject'			=> 'Emne:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Din melding:',
	'YourMessageInfo'			=> 'Vær oppmerksom på at du kun kan legge inn fletting. All opptegnelse vil bli fjernet før sending.',

	'NoUser'					=> 'Ingen bruker',
	'NoUserGroup'				=> 'Ingen brukergruppe',

	'SendToGroup'				=> 'Send til gruppe:',
	'SendToUser'				=> 'Send til bruker:',
	'SendToUserInfo'			=> 'Kun brukere som tillater at administratorer sender dem informasjon vil motta massee-post. Dette alternativet er tilgjengelig i sine brukerinnstillinger under varslinger.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Oppdatert systemmelding',

	'SysMsgSection'				=> 'System Melding',
	'SysMsg'					=> 'System melding:',
	'SysMsgInfo'				=> 'Din tekst her',

	'SysMsgType'				=> 'Type:',
	'SysMsgTypeInfo'			=> 'Meldingstype (CSS).',
	'SysMsgAudience'			=> 'Audiens:',
	'SysMsgAudienceInfo'		=> 'Audiens systemmeldingen vises til.',
	'EnableSysMsg'				=> 'Aktiver systemmelding:',
	'EnableSysMsgInfo'			=> 'Vis systemmelding.',

	// User approval module
	'ApproveNotExists'			=> 'Velg minst én bruker via Sett-knappen.',

	'LogUserApproved'			=> 'Bruker ##%1## godkjent',
	'LogUserBlocked'			=> 'Bruker ##%1## blokkert',
	'LogUserDeleted'			=> 'Bruker ##%1## fjernet fra databasen',
	'LogUserCreated'			=> 'Opprettet en ny bruker ##%1##',
	'LogUserUpdated'			=> 'Oppdatert bruker ##%1##',
	'LogUserPasswordReset'		=> 'Passordet for brukeren ##%1## ble tilbakestilt',

	'UserApproveInfo'			=> 'Godkjenn nye brukere før de kan logge inn på nettstedet.',
	'Approve'					=> 'Godkjenn',
	'Deny'						=> 'Avslå',
	'Pending'					=> 'Ventende',
	'Approved'					=> 'Godkjent',
	'Denied'					=> 'Avvist',

	// DB Backup module
	'BackupStructure'			=> 'Struktur',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Mappe',
	'BackupTable'				=> 'Tabell',
	'BackupCluster'				=> 'Gruppering:',
	'BackupFiles'				=> 'Filer',
	'BackupNote'				=> 'Merk:',
	'BackupSettings'			=> 'Angi den ønskede sikkerhetskopieringen.<br>' .
    	'Klysten for rot påvirker ikke den globale sikkerhetskopien og mellomlagret filer (hvis valgt, de er alltid lagret i full).<br>' .  '<br>' .
		'<strong>Legg merke til</strong>: For å unngå tap av informasjon fra databasen når du angir rotklyngen, tabellene fra denne sikkerhetskopien vil ikke bli omstrukturert, samme som ved bare sikkerhetskopiering av tabellstruktur uten å lagre dataene. For å fullføre konverteringen av tabellene til sikkerhetskopiformatet må du lage <em> fullstendig sikkerhetskopi (struktur og data) uten å angi klyngen</em>.',
	'BackupCompleted'			=> 'Sikkerhetskopiering og arkivering fullført.<br>' .
    	'Sikkerhetskopieringspakkefilene ble lagret i underkatalogen %1.<br>For å laste ned FTP (vedlikehold av mappestruktur og filnavn når de kopierer).<br> for å gjenopprette en sikkerhetskopiering eller fjerne en pakke, gå til <a href="%2">Gjenopprette database</a>.',
	'LogSavedBackup'			=> 'Lagret sikkerhetskopieringsdatabase ##%1##',
	'Backup'					=> 'Sikkerhetskopi',
	'CantReadFile'				=> 'Kan ikke lese filen %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Du kan gjenopprette alle reservepakkene funnet, eller fjerne dem fra serveren.',
	'ConfirmDbRestore'			=> 'Vil du gjenopprette sikkerhetskopien %1?',
	'ConfirmDbRestoreInfo'		=> 'Vennligst vent, dette kan ta litt tid.',
	'RestoreWrongVersion'		=> 'Feil WackoWiki versjon!',
	'DirectoryNotExecutable'	=> 'Mappen %1 er ikke kjørbar.',
	'BackupDelete'				=> 'Er du sikker på at du vil fjerne sikkerhetskopiering %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Flere gjenopprettingsalternativer',
	'RestoreOptionsInfo'		=> '* Før du gjenoppretter <strong>klynge sikkerhetskopien</strong>, ' .
									'måltabellene slettes ikke (for å hindre tap av informasjon fra sektorene som ikke er sikkerhetskopiert). ' .
									'Det vil derfor bli duplisert journal i løpet av utvinningsprosessen. ' .
									'I vanlig modus blir alle vil bli erstattet av sikkerhetskopiering av postens skjema (ved å bruke SQL <code>REPLACE</code>), ' .
									'men hvis denne avmerkingsboksen er merket, blir alle duplikater hoppet over (de gjeldende verdiene til poster vil bli holdt), ' .
									'og bare elementene med nye nøkler er lagt til i tabellen (SQL <code>INSERT IGNORE</code>).<br>' .
									'<strong>Merk</strong>: Når du gjenoppretter fullstendig sikkerhetskopi av nettstedet, har dette alternativet ingen verdi.<br>' .
									'<br>' .
									'** Hvis sikkerhetskopien inneholder brukerfilene (global og perside, mellomlagerfiler osv.), ' .
									'i normal modus erstatter de eksisterende filene med samme navn og plasseres i samme mappe når de blir gjenopprettet. ' .
									'Dette alternativet lar deg lagre gjeldende kopier av filene og gjenopprette fra en sikkerhetskopi, bare nye filer (mangler på serveren).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignorer dupliserte tabellnøkler (ikke erstattet)',
	'IgnoreSameFiles'			=> 'Ignorer samme filer (ikke overskrive)',
	'NoBackupsAvailable'		=> 'Ingen sikkerhetskopier tilgjengelig.',
	'BackupEntireSite'			=> 'Hele siden',
	'BackupRestored'			=> 'Sikkerhetskopien er gjenopprettet. En oppsummeringsrapport er vedlagt nedenfor. For å slette denne backup-pakken, klikk',
	'BackupRemoved'				=> 'Den valgte sikkerhetskopien har blitt fjernet.',
	'LogRemovedBackup'			=> 'Fjernet sikkerhetskopi av databasen ##%1##',

	'DbEngineInvalid'			=> 'Ugyldig databasemotor, forventer %1',
	'RestoreStarted'			=> 'Initiert restasjon',
	'RestoreParameters'			=> 'Bruke parametere',
	'IgnoreDuplicatedKeys'		=> 'Ignorer dupliserte nøkler',
	'IgnoreDuplicatedFiles'		=> 'Ignorer dupliserte filer',
	'SavedCluster'				=> 'Lagret klynge',
	'DataProtection'			=> 'Datatiltak - %1 utelatt',
	'AssumeDropTable'			=> 'Forutsett %1',
	'RestoreSQLiteDatabase'		=> 'Gjenoppretter SQLite databasen',
	'SQLiteDatabaseRestored'	=> 'Database gjenopprettet fra:',
	'RestoreTableStructure'		=> 'Gjenoppretter konstruksjonen til tabellen',
	'RunSqlQueries'				=> 'Utfør SQL-instruksjoner:',
	'CompletedSqlQueries'		=> 'Fullført. Behandlede instruksjoner:',
	'NoTableStructure'			=> 'Strukturen til tabellene ble ikke lagret - hopp over',
	'RestoreRecords'			=> 'Gjenopprett innholdet i tabellene',
	'ProcessTablesDump'			=> 'Bare last ned og behandle tabelldumper',
	'Instruction'				=> 'Instruksjon',
	'RestoredRecords'			=> 'poster:',
	'RecordsRestoreDone'		=> 'Fullført. Antall oppføringer:',
	'SkippedRecords'			=> 'Data ikke lagret - hopp over',
	'RestoringFiles'			=> 'Gjenoppretter filer',
	'DecompressAndStore'		=> 'Dekomprimere og lagre mappenes innhold',
	'HomonymicFiles'			=> 'homonyiske filer',
	'RestoreSkip'				=> 'hopp over',
	'RestoreReplace'			=> 'erstatt',
	'RestoreFile'				=> 'Fil:',
	'RestoredFiles'				=> 'gjenopprettet:',
	'SkippedFiles'				=> 'hoppet over:',
	'FileRestoreDone'			=> 'Fullført. Antall filer:',
	'FilesAll'					=> 'alle:',
	'SkipFiles'					=> 'Filer er ikke lagret - hopp over',
	'RestoreDone'				=> 'GODKJENNELSE FULLFØRT',

	'BackupCreationDate'		=> 'Opprettet dato',
	'BackupPackageContents'		=> 'Innholdet i pakningen',
	'BackupRestore'				=> 'Gjenopprett',
	'BackupRemove'				=> 'Fjern',
	'RestoreYes'				=> 'Ja',
	'RestoreNo'					=> 'Nei',
	'LogDbRestored'				=> 'Backup ##%1## av databasen gjenopprettet.',

	'BackupArchived'			=> 'Sikkerhetskopiering %1 ble arkivert.',
	'BackupArchiveExists'		=> 'Sikkerhetskopiarkiv %1 finnes allerede.',
	'LogBackupArchived'			=> 'Backup ##%1## arkivert.',

	// User module
	'UsersInfo'					=> 'Her kan du endre informasjon om brukerne dine og bestemte alternativer.',

	'UsersAdded'				=> 'Bruker lagt til',
	'UsersDeleteInfo'			=> 'Slette bruker:',
	'EditButton'				=> 'Rediger',
	'UsersAddNew'				=> 'Legg til ny bruker',
	'UsersDelete'				=> 'Er du sikker på at du vil fjerne bruker %1?',
	'UsersDeleted'				=> 'Brukeren %1 ble slettet fra databasen.',
	'UsersRename'				=> 'Endre navn på brukeren %1 til',
	'UsersRenameInfo'			=> '* Merk: Endring vil påvirke alle sider som er tilordnet den brukeren.',
	'UsersUpdated'				=> 'Oppdatering av bruker vellykket.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Registrering',
	'UserActions'				=> 'Handlinger',
	'NoMatchingUser'			=> 'Ingen brukere som oppfyller kriteriene',

	'UserAccountNotify'			=> 'Varsle brukeren',
	'UserNotifySignup'			=> 'informere brukeren om den nye kontoen',
	'UserVerifyEmail'			=> 'angi e-postbekreftelsekode token og legg til lenke for e-postbekreftelse',
	'UserReVerifyEmail'			=> 'Re-send e-postbekreftelsen token',

	// Groups module
	'GroupsInfo'				=> 'Fra dette panelet kan du administrere alle brukergruppene dine. Du kan slette, opprette og redigere eksisterende grupper. Videre kan du velge gruppeledere, vis åpen/skjulte/lukkede gruppe-status og angi gruppenavn og beskrivelse.',

	'LogMembersUpdated'			=> 'Oppdaterte medlemmer fra brukergruppen',
	'LogMemberAdded'			=> 'La til medlem ##%1## i gruppen ##%2##',
	'LogMemberRemoved'			=> 'Fjernet medlem ##%1## fra gruppen ##%2##',
	'LogGroupCreated'			=> 'Opprettet en ny gruppe ##%1##',
	'LogGroupRenamed'			=> 'Gruppe ##%1## endret navn til ##%2##',
	'LogGroupRemoved'			=> 'Fjernet gruppen ##%1##',

	'GroupsMembersFor'			=> 'Medlemmer for gruppe',
	'GroupsDescription'			=> 'Beskrivelse',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Åpne',
	'GroupsActive'				=> 'Aktiv',
	'GroupsTip'					=> 'Klikk for å redigere gruppe',
	'GroupsUpdated'				=> 'Grupper oppdatert',
	'GroupsAlreadyExists'		=> 'Denne gruppen finnes allerede.',
	'GroupsAdded'				=> 'Gruppe er lagt til.',
	'GroupsRenamed'				=> 'Omdøp gruppen',
	'GroupsDeleted'				=> 'Gruppen %1 og alle assosierte sider ble slettet fra databasen.',
	'GroupsAdd'					=> 'Legg til ny gruppe',
	'GroupsRename'				=> 'Endre navn på gruppen %1 til',
	'GroupsRenameInfo'			=> '* Merk: Endring vil påvirke alle sider som er tilordnet den gruppen.',
	'GroupsDelete'				=> 'Er du sikker på at du vil fjerne gruppe %1?',
	'GroupsDeleteInfo'			=> '* Merk: Endring vil påvirke alle medlemmer som er tilordnet til den gruppen.',
	'GroupsIsSystem'			=> 'Gruppen %1 tilhører systemet og kan ikke fjernes.',
	'GroupsStoreButton'			=> 'Lagre grupper',
	'GroupsEditInfo'			=> 'Hvis du vil redigere gruppelisten, velger du valgknappen.',

	'GroupAddMember'			=> 'Legg til medlem',
	'GroupRemoveMember'			=> 'Fjern medlem',
	'GroupAddNew'				=> 'Legg til gruppe',
	'GroupEdit'					=> 'Rediger gruppe',
	'GroupDelete'				=> 'Fjern gruppe',

	'MembersAddNew'				=> 'Legg til nytt medlem',
	'MembersAdded'				=> 'Det ble lagt til nytt medlem i gruppen.',
	'MembersRemove'				=> 'Er du sikker på at du vil fjerne medlem %1?',
	'MembersRemoved'			=> 'Medlemmet ble fjernet fra gruppen.',

	// Statistics module
	'DbStatSection'				=> 'Database Statistikk',
	'DbTable'					=> 'Tabell',
	'DbRecords'					=> 'Poster',
	'DbSize'					=> 'Størrelse',
	'DbIndex'					=> 'Indeks',
	'DbTotal'					=> 'Totalt',

	'FileStatSection'			=> 'Statistikk for filsystem',
	'FileFolder'				=> 'Mappe',
	'FileFiles'					=> 'Filer',
	'FileSize'					=> 'Størrelse',
	'FileTotal'					=> 'Totalt',

	// Sysinfo module
	'SysInfo'					=> 'Versjons informasjon:',
	'SysParameter'				=> 'Parametre',
	'SysValues'					=> 'Verdier',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Siste oppdatering',
	'ServerOS'					=> 'operativsystem',
	'ServerName'				=> 'Server navn',
	'WebServer'					=> 'Webserver',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'Databasen',
	'SqlModesGlobal'			=> 'SQL Moder Global',
	'SqlModesSession'			=> 'SQL Modes økt',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Minne',
	'UploadFilesizeMax'			=> 'Laste opp maks filstørrelse',
	'PostMaxSize'				=> 'Post maks størrelse',
	'MaxExecutionTime'			=> 'Max gjennomføringstid',
	'SessionPath'				=> 'Sesjon sti',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'Komprimering av gZip',
	'PhpExtensions'				=> 'PHP utvidelser',
	'ApacheModules'				=> 'Apache moduler',

	// DB repair module
	'DbRepairSection'			=> 'Reparer databasen',
	'DbRepair'					=> 'Reparer databasen',
	'DbRepairInfo'				=> 'Dette skriptet kan automatisk se etter noen vanlige databaseproblemer og reparere dem. Reparasjon kan ta en stund, så vennligst vær tålmodig.',

	'DbOptimizeRepairSection'	=> 'Reparer og Optimaliser databasen',
	'DbOptimizeRepair'			=> 'Reparer og Optimaliser databasen',
	'DbOptimizeRepairInfo'		=> 'Dette skriptet kan også forsøke å optimalisere databasen. Dette forbedrer ytelsen i noen situasjoner. Reparasjon og optimalisering av databasen kan ta lang tid, og databasen vil bli låst mens den optimaliseres.',

	'TableOk'					=> '%1 bordet er greit.',
	'TableNotOk'				=> '%1-tabellen er ikke i orden. Den rapporterer følgende feil: %2. Dette skriptet vil forsøke å reparere denne tabellen&hellip;',
	'TableRepaired'				=> '%1 ble reparert tabellen.',
	'TableRepairFailed'			=> 'Kunne ikke reparere %1-tabellen. <br>Feil: %2',
	'TableAlreadyOptimized'		=> 'Tabellen %1 er allerede optimalisert.',
	'TableOptimized'			=> 'Tabellen %1 ble optimalisert.',
	'TableOptimizeFailed'		=> 'Kunne ikke optimalisere %1-tabellen. <br>Feil: %2',
	'TableNotRepaired'			=> 'Enkelte databaseproblemer kunne ikke repareres.',
	'RepairsComplete'			=> 'Reparasjoner fullført',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Vis og fiks inkonsistens, slett eller tilordne foreldede oppføringer til en ny bruker / verdi.',
	'Inconsistencies'			=> 'Inkonsistens',
	'CheckDatabase'				=> 'Databasen',
	'CheckDatabaseInfo'			=> 'Kontrollene for registrering av avvik i databasen.',
	'CheckFiles'				=> 'Filer',
	'CheckFilesInfo'			=> 'Sjekker for forlatte filer, filer uten referanse igjen i filtabellen.',
	'Records'					=> 'Poster',
	'InconsistenciesNone'		=> 'Ingen data inkonsistens funnet.',
	'InconsistenciesDone'		=> 'Inkonsistens overfor data løst',
	'InconsistenciesRemoved'	=> 'Fjernet inkonsistens',
	'Check'						=> 'Sjekk',
	'Solve'						=> 'Løs',

	// Bad Behaviour module
	'BbInfo'					=> 'Oppdager og blokker uønskede web-tilgang, nekte automatiserte spambots tilgang.<br>For mer informasjon, vennligst gå til hjemmesiden %1.',
	'BbEnable'					=> 'Aktivere Dårlig oppførsel:',
	'BbEnableInfo'				=> 'Alle andre innstillinger kan endres i konfigurasjonsmappen %1.',
	'BbStats'					=> 'Dårlig oppførsel har blokkert %1 tilgangsforsøk de siste 7 dagene.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Logg',
	'BbSettings'				=> 'Innstillinger',
	'BbWhitelist'				=> 'Hviteliste',

	// --> Log
	'BbHits'					=> 'Treff',
	'BbRecordsFiltered'			=> 'Viser %1 av %2 poster filtrert av',
	'BbStatus'					=> 'Status:',
	'BbBlocked'					=> 'Blokkert',
	'BbPermitted'				=> 'Tillatt',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'BETAK/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Viser alle %1 poster',
	'BbShow'					=> 'Vis',
	'BbIpDateStatus'			=> 'IP/Dato/Status',
	'BbHeaders'					=> 'Overskrifter',
	'BbEntity'					=> 'Enhet',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Alternativer lagret.',
	'BbWhitelistHint'			=> 'Upassende hvitelisting WILL vil at du spam, eller forårsake Dårlig oppførsel for å slutte å fungere, helt! IKKE HVITELISTEN hvis du ikke er 100 % CERTAIN den du skal.',
	'BbIpAddress'				=> 'IP Adresse',
	'BbIpAddressInfo'			=> 'IP adresse eller CIDR format adresseområder for å være hvitelistet (en per linje)',
	'BbUrl'						=> 'Nettadresse',
	'BbUrlInfo'					=> 'URL fragmenter som begynner med / etter ditt webområde vertsnavn (én per linje)',
	'BbUserAgent'				=> 'Bruker Agent',
	'BbUserAgentInfo'			=> 'Brukeragentstrengene som skal være hvitelistet (en per linje)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Oppdaterte feilaktige atferdsinnstillinger',
	'BbLogRequest'				=> 'Logger HTTP forespørsel',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (anbefalt)',
	'BbLogOff'					=> 'Ikke logg inn (ikke anbefalt)',
	'BbSecurity'				=> 'Sikkerhet',
	'BbStrict'					=> 'Streng kontroll',
	'BbStrictInfo'				=> 'blokkerer mer spam, men kan blokkere noen personer',
	'BbOffsiteForms'			=> 'Tillat form innlegg fra andre nettsteder',
	'BbOffsiteFormsInfo'		=> 'kreves for OpenID; øk spam mottatt',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'For å bruke Bad Behaviour\'s http:BL funksjoner må du ha en %1',
	'BbHttpblKey'				=> 'http:BL tilgangsnøkkel',
	'BbHttpblThreat'			=> 'Minste trusselnivå (25 er anbefalt)',
	'BbHttpblMaxage'			=> 'Maksimal alder for data (30 anbefales)',
	'BbReverseProxy'			=> 'Revers Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'Hvis du bruker Dårlig oppførsel bak en revers proxy, lastbalansere, HTTP-akselerator, innholdscache eller lignende teknologi, aktiverer du Reverse Proxy-alternativet.<br>' .
									'Hvis du har en kjede av to eller flere revers-proxyer mellom serveren din og det offentlige Internett, du må spesifisere <em>alle</em> av IP-adresseområder (i CIDR format) for alle dine proxy-servere, laste saldoer osv. Ellers, dårlig oppførsel kan ikke være i stand til å bestemme klientens reelle IP-adresse.<br>' .
									'I tillegg må dine revers-proxy servere angi IP-adressen til Internett-klienten som de mottok forespørselen i en HTTP-header fra. Hvis du ikke angir et hode, vil %1 bli brukt. De fleste proxyservere støtter allerede X-Forwarded-For og du vil da bare behøve å forsikre deg om at det er aktivert på proxyserverne dine. Noen andre topplinjenavn i vanlig bruk inkluderer %2 og %3.',
	'BbReverseProxyEnable'		=> 'Aktiver revers proxy',
	'BbReverseProxyHeader'		=> 'Overskrift som inneholder IP-adressen til Internett-klienter',
	'BbReverseProxyAddresses'	=> 'IP adresse eller CIDR format adresseområder for dine proxy servere (en per linje)',

];
