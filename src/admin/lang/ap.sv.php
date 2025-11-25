<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Grundläggande funktioner',
		'preferences'	=> 'Inställningar',
		'content'		=> 'Innehåll',
		'users'			=> 'Användare',
		'maintenance'	=> 'Underhåll',
		'messages'		=> 'Meddelanden',
		'extension'		=> 'Tillägg',
		'database'		=> 'Databas',
	],

	// Admin panel
	'AdminPanel'				=> 'Kontrollpanel för administration',
	'RecoveryMode'				=> 'Återställningsläge',
	'Authorization'				=> 'Tillstånd',
	'AuthorizationTip'			=> 'Ange det administrativa lösenordet (se till att cookies är tillåtna i din webbläsare).',
	'NoRecoveryPassword'		=> 'Det administrativa lösenordet har inte angetts!',
	'NoRecoveryPasswordTip'		=> 'Obs: Avsaknaden av ett administrativt lösenord är ett hot mot säkerheten! Ange ditt lösenord hash i konfigurationsfilen och kör programmet igen.',

	'ErrorLoadingModule'		=> 'Fel vid laddning av adminmodul %1: finns inte.',

	'ApHomePage'				=> 'Startsida',
	'ApHomePageTip'				=> 'Avsluta systemadministration och öppna startsidan',
	'ApLogOut'					=> 'Logga ut',
	'ApLogOutTip'				=> 'Avsluta systemadministration och logga ut från webbplatsen',

	'TimeLeft'					=> 'Tid kvar:  %1 minut(er)',
	'ApVersion'					=> 'version',

	'SiteOpen'					=> 'Öppna',
	'SiteOpened'				=> 'webbplats öppnad',
	'SiteOpenedTip'				=> 'Webbplatsen är öppen',
	'SiteClose'					=> 'Stäng',
	'SiteClosed'				=> 'webbplats stängd',
	'SiteClosedTip'				=> 'Webbplatsen är stängd',

	'System'					=> 'System',

	// Generic
	'Cancel'					=> 'Avbryt',
	'Add'						=> 'Lägg till',
	'Edit'						=> 'Redigera',
	'Remove'					=> 'Radera',
	'Enabled'					=> 'Aktiverad',
	'Disabled'					=> 'Inaktiverad',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'Administratör',
	'Min'						=> 'Minsta',
	'Max'						=> 'Max',

	'MiscellaneousSection'		=> 'Diverse',
	'MainSection'				=> 'Allmänna inställningar',

	'DirNotWritable'			=> '%1 -katalogen är inte skrivbar.',
	'FileNotWritable'			=> 'Filen %1 är inte skrivbar.',

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
		'name'		=> 'Grundläggande',
		'title'		=> 'Grundläggande inställningar',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Utseende',
		'title'		=> 'Inställningar för utseende',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-post',
		'title'		=> 'E-post inställningar',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Syndikation',
		'title'		=> 'Syndikeringsinställningar',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtrera',
		'title'		=> 'Filtrera inställningar',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formateria',
		'title'		=> 'Formatera alternativ',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Aviseringar',
		'title'		=> 'Inställningar för aviseringar',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Sidor',
		'title'		=> 'Sidor och webbplatsparametrar',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Behörigheter',
		'title'		=> 'Inställningar för behörigheter',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Säkerhet',
		'title'		=> 'Inställningar för säkerhetsdelsystem',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'System',
		'title'		=> 'Systeminställningar',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Ladda upp',
		'title'		=> 'Bilagans inställningar',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Borttagen',
		'title'		=> 'Nyligen raderat innehåll',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Meny',
		'title'		=> 'Lägg till, redigera eller ta bort standardmenyobjekt',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Säkerhetskopiera',
		'title'		=> 'Säkerhetskopierar data',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Reparera',
		'title'		=> 'Reparera och optimera databas',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Återställ',
		'title'		=> 'Återställer säkerhetskopieringsdata',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Huvudmeny',
		'title'		=> 'WackoWiki Administration',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inkonsekvenser',
		'title'		=> 'Fastställande av datainkonsekvenser',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Synkronisering av data',
		'title'		=> 'Synkroniserar data',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Massa e-post',
		'title'		=> 'Massa e-post',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'System meddelande',
		'title'		=> 'System meddelanden',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Systeminformation',
		'title'		=> 'Systeminformation',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Systemets logg',
		'title'		=> 'Logg över systemhändelser',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistik',
		'title'		=> 'Visa statistik',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Dåligt beteende',
		'title'		=> 'Dåligt beteende',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Godkänn',
		'title'		=> 'Godkännande av användarregistrering',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Grupper',
		'title'		=> 'Koncernledning',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Användare',
		'title'		=> 'Hantering av användare',
	],

	// Main module
	'MainNote'					=> 'Obs: Det rekommenderas att åtkomst till webbplatsen tillfälligt blockeras för administrativt underhåll.',

	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'Rensa alla sessioner',
	'PurgeSessionsConfirm'		=> 'Är du säker på att du vill rensa alla sessioner? Detta kommer att logga ut alla användare.',
	'PurgeSessionsExplain'		=> 'Rensa alla sessioner. Detta kommer att logga ut alla användare genom att trunkera auth_token tabellen.',
	'PurgeSessionsDone'			=> 'Sessioner rensades framgångsrikt.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Uppdaterade grundläggande inställningar',
	'LogBasicSettingsUpdated'	=> 'Uppdaterade grundläggande inställningar',

	'SiteName'					=> 'Webbplatsens namn:',
	'SiteNameInfo'				=> 'Titeln på denna webbplats. Visas på webbläsarens titel, tema rubrik, e-postmeddelande, etc.',
	'SiteDesc'					=> 'Webbplatsens beskrivning:',
	'SiteDescInfo'				=> 'Tillägg till titeln på den webbplats som visas i sidhuvudet. Förklara med några ord, vad denna webbplats handlar om.',
	'AdminName'					=> 'Admin av sajt:',
	'AdminNameInfo'				=> 'Användarnamnet på den enskilde som är ansvarig för övergripande stöd på webbplatsen. Detta namn används inte för att bestämma åtkomsträttigheter, men det är önskvärt att det överensstämmer med namnet på huvudadministratören på webbplatsen.',

	'LanguageSection'			=> 'Språk',
	'DefaultLanguage'			=> 'Standardspråk:',
	'DefaultLanguageInfo'		=> 'Anger språket för meddelanden som visas för oregistrerade gäster, samt lokalinställningar.',
	'MultiLanguage'				=> 'Stöd för flerspråkighet:',
	'MultiLanguageInfo'			=> 'Aktivera möjligheten att välja ett språk från sida till sida.',
	'AllowedLanguages'			=> 'Tillåtna språk:',
	'AllowedLanguagesInfo'		=> 'Det rekommenderas att endast välja den uppsättning språk du vill använda, annars är alla språk valda.',

	'CommentSection'			=> 'Kommentarer',
	'AllowComments'				=> 'Tillåt kommentarer:',
	'AllowCommentsInfo'			=> 'Aktivera kommentarer enbart för gäster eller registrerade användare, eller inaktivera dem på hela webbplatsen.',
	'SortingComments'			=> 'Sortering av kommentarer:',
	'SortingCommentsInfo'		=> 'Ändrar ordningen sidan kommentarer presenteras, antingen med den senaste ELLER den äldsta kommentaren i toppen.',
	'CommentsOffset'			=> 'Kommentarer:',
	'CommentsOffsetInfo'		=> 'Kommentarssida att visa som standard',

	'ToolbarSection'			=> 'Verktygsfält',
	'CommentsPanel'				=> 'Kommentarspanelen:',
	'CommentsPanelInfo'			=> 'Standardvisning av kommentarer längst ner på sidan.',
	'FilePanel'					=> 'Fil panel:',
	'FilePanelInfo'				=> 'Standardvisning av bilagor längst ner på sidan.',
	'TagsPanel'					=> 'Taggpanel:',
	'TagsPanelInfo'				=> 'Standardvisning av taggar längst ner på sidan.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Visa permalänk:',
	'ShowPermalinkInfo'			=> 'Standardvisning av permalänk för den aktuella versionen av sidan.',
	'TocPanel'					=> 'Innehållsförteckning:',
	'TocPanelInfo'				=> 'Standardvisningstabellen för innehållspanelen på en sida (kan behöva stöd i mallarna).',
	'SectionsPanel'				=> 'Sektioner panel:',
	'SectionsPanelInfo'			=> 'Som standard visas panelen på intilliggande sidor (kräver stöd i mallarna).',
	'DisplayingSections'		=> 'Visar sektioner:',
	'DisplayingSectionsInfo'	=> 'När de tidigare alternativen är inställda, om du bara ska visa undersidor på sidan (<em>lägre</em>), bara granne (<em>topp</em>), både eller andra (<em>träd</em>).',
	'MenuItems'					=> 'Menyobjekt:',
	'MenuItemsInfo'				=> 'Standard antal visade menyobjekt (kan behöva stöd i mallarna).',

	'HandlerSection'			=> 'Handlers',
	'HideRevisions'				=> 'Dölj revisioner:',
	'HideRevisionsInfo'			=> 'Standardvisning av revisioner av sidan.',
	'AttachmentHandler'			=> 'Aktivera bilaga-hanterare:',
	'AttachmentHandlerInfo'		=> 'Tillåter visning av bilagans hanterare.',
	'SourceHandler'				=> 'Aktivera källhanterare:',
	'SourceHandlerInfo'			=> 'Tillåter visning av källhanteraren.',
	'ExportHandler'				=> 'Aktivera XML-exporthanterare:',
	'ExportHandlerInfo'			=> 'Tillåter visning av XML-exporthanteraren.',

	'DiffModeSection'			=> 'Diff lägen',
	'DefaultDiffModeSetting'	=> 'Standard diff-läge:',
	'DefaultDiffModeSettingInfo'=> 'Förvalt diff-läge.',
	'AllowedDiffMode'			=> 'Tillåtna diff-lägen:',
	'AllowedDiffModeInfo'		=> 'Det rekommenderas att endast välja den uppsättning diff lägen du vill använda, annars är alla diff lägen valda.',
	'NotifyDiffMode'			=> 'Meddela diff läge:',
	'NotifyDiffModeInfo'		=> 'Diff-läge som används för aviseringar i e-postkroppen.',

	'EditingSection'			=> 'Redigerar',
	'EditSummary'				=> 'Redigera sammanfattning:',
	'EditSummaryInfo'			=> 'Visar sammanfattning av ändringar i redigeringsläget.',
	'MinorEdit'					=> 'Mindre redigering:',
	'MinorEditInfo'				=> 'Aktiverar mindre redigeringsalternativ i redigeringsläget.',
	'SectionEdit'				=> 'Sektion redigera:',
	'SectionEditInfo'			=> 'Aktiverar endast redigering av en sektion på en sida.',
	'ReviewSettings'			=> 'Recension:',
	'ReviewSettingsInfo'		=> 'Aktiverar granskningsalternativ i redigeringsläget.',
	'PublishAnonymously'		=> 'Tillåt anonym publicering:',
	'PublishAnonymouslyInfo'	=> 'Tillåt användare att publicera anonymt (för att dölja namnet).',

	'DefaultRenameRedirect'		=> 'När du byter namn, skapa omdirigering:',
	'DefaultRenameRedirectInfo'	=> 'Som standard, erbjudande att ställa in en omdirigering till den gamla adressen för sidan som byts namn.',
	'StoreDeletedPages'			=> 'Behåll raderade sidor:',
	'StoreDeletedPagesInfo'		=> 'När du tar bort en sida, en kommentar eller en fil, behåll den i ett speciellt avsnitt, där den kommer att finnas tillgänglig för granskning och återhämtning under en viss tidsperiod (enligt beskrivningen nedan).',
	'KeepDeletedTime'			=> 'Lagringstid för borttagna sidor:',
	'KeepDeletedTimeInfo'		=> 'Perioden i dagar. Det är vettigt endast med det föregående alternativet. Använd noll för att säkerställa att enheter aldrig tas bort (i detta fall kan administratören rensa "vagnen" manuellt).',
	'PagesPurgeTime'			=> 'Lagringstid för sidrevisioner:',
	'PagesPurgeTimeInfo'		=> 'Ta automatiskt bort de äldre versionerna inom det angivna antalet dagar. Om du anger noll, kommer de äldre versionerna inte att tas bort.',
	'EnableReferrers'			=> 'Aktivera hänvisningar:',
	'EnableReferrersInfo'		=> 'Tillåter skapande och visning av externa hänvisningar.',
	'ReferrersPurgeTime'		=> 'Lagringstid för remisser:',
	'ReferrersPurgeTimeInfo'	=> 'Håll historien om hänvisande externa sidor inte längre än ett givet antal dagar. Använd noll för att se till att hänvisningar aldrig tas bort (men för en aktivt besökt webbplats, detta kan leda till databas överflöd).',
	'EnableCounters'			=> 'Träffa räknare:',
	'EnableCountersInfo'		=> 'Tillåter per sidträffräknare och möjliggör visning av enkel statistik. Visningar av sidägaren räknas inte.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Kontroll standard webb syndikering inställningar för din webbplats.',
	'SyndicationSettingsUpdated'	=> 'Uppdaterade syndikeringsinställningar.',

	'FeedsSection'				=> 'Flöden',
	'EnableFeeds'				=> 'Aktivera flöden:',
	'EnableFeedsInfo'			=> 'Sätter på eller stänger av RSS-flöden för hela wikin.',
	'XmlChangeLink'				=> 'Ändrar länkläge:',
	'XmlChangeLinkInfo'			=> 'Definierar var XML ändrar foder objekt länkar till.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'skillnad vy',
		'2'		=> 'den reviderade sidan',
		'3'		=> 'lista över revideringar',
		'4'		=> 'den aktuella sidan',
	],

	'XmlSitemap'				=> 'XML sitemap:',
	'XmlSitemapInfo'			=> 'Skapar en XML-fil som heter %1 i XML-mappen. Du kan lägga till sökvägen till webbplatskartan i robots.txt-filen i din rotkatalog enligt följande:',
	'XmlSitemapGz'				=> 'Komprimering av XML-webbplatskarta:',
	'XmlSitemapGzInfo'			=> 'Om du vill, kan du komprimera din webbplatskarta textfil med gzip för att minska ditt bandbreddskrav.',
	'XmlSitemapTime'			=> 'XML webbplatskartsgenereringstid:',
	'XmlSitemapTimeInfo'		=> 'Genererar webbplatskartan endast en gång i det angivna antalet dagar. Sätt till noll för att generera på varje sidbyte.',

	'SearchSection'				=> 'Sök',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Skapar beskrivningsfilen för OpenSearch i XML-mappen och aktiverar Autodiscovery av sökplugin i HTML-huvudet.',
	'SearchEngineVisibility'	=> 'Blockera sökmotorer (sökmotorns synlighet):',
	'SearchEngineVisibilityInfo'=> 'Blockera sökmotorer, men tillåt vanliga besökare. Åsidosätter sidinställningar. <br>Uppmuntra sökmotorer från att indexera denna webbplats. Det är upp till sökmotorer att hedra denna begäran.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Kontrollera standardinställningarna för din webbplats.',
	'AppearanceSettingsUpdated'	=> 'Uppdaterade inställningar för utseende.',

	'LogoOff'					=> 'Av',
	'LogoOnly'					=> 'logotyp',
	'LogoAndTitle'				=> 'logotyp och titel',

	'LogoSection'				=> 'Logotyp',
	'SiteLogo'					=> 'Webbplatsens logotyp:',
	'SiteLogoInfo'				=> 'Din logotyp kommer vanligtvis att visas i det övre vänstra hörnet av programmet. Max storlek är 2 MiB. Optimala mått är 255 pixlar breda och 55 pixlar höga.',
	'LogoDimensions'			=> 'Logotyp dimensioner:',
	'LogoDimensionsInfo'		=> 'Bredd och höjd på den visade logotypen.',
	'LogoDisplayMode'			=> 'Visningsläge för logotyp:',
	'LogoDisplayModeInfo'		=> 'Definierar utseendet på logotypen. Standard är avstängd.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Webbplatsens favicon:',
	'SiteFaviconInfo'			=> 'Din genvägsikon, eller favicon, visas i adressfältet, flikar och bokmärken i de flesta webbläsare. Detta kommer att åsidosätta ikonen för ditt tema.',
	'SiteFaviconTooBig'			=> 'Favicon är större än 64 x 64 px.',
	'ThemeColor'				=> 'Temafärg för adressfältet:',
	'ThemeColorInfo'			=> 'Webbläsaren kommer att ställa in adressfältets färg på varje sida enligt den angivna CSS-färgen.',

	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Tema:',
	'ThemeInfo'					=> 'Mall design webbplatsen använder som standard.',
	'ResetUserTheme'			=> 'Återställ alla användarteman:',
	'ResetUserThemeInfo'		=> 'Återställer alla användarteman. Varning: Den här åtgärden återställer alla användarvalda teman till det globala standardtemat.',
	'SetBackUserTheme'			=> 'Återställ alla användarteman till %1 tema.',
	'ThemesAllowed'				=> 'Tillåtna teman:',
	'ThemesAllowedInfo'			=> 'Välj tillåtna teman, som användaren kan välja; annars är alla tillgängliga teman tillåtna.',
	'ThemesPerPage'				=> 'Teman per sida:',
	'ThemesPerPageInfo'			=> 'Tillåt teman per sida, som sidägaren kan välja via sidegenskaper.',

	// System settings
	'SystemSettingsInfo'		=> 'Grupp av parametrar som ansvarar för finjustering av webbplatsen. Ändra inte dem om du inte är säker på deras handlingar.',
	'SystemSettingsUpdated'		=> 'Uppdaterade systeminställningar',

	'DebugModeSection'			=> 'Felsökningsläge',
	'DebugMode'					=> 'Debug-läge:',
	'DebugModeInfo'				=> 'Extrahera och mata ut telemetriska data om programmets genomförandetid. Observera: Fullt detaljläge ställer högre krav på det tilldelade minnet, särskilt för resursintensiva operationer, såsom säkerhetskopiering av databasen och återställning.',
	'DebugModes'	=> [
		'0'		=> 'felsökning är avstängd',
		'1'		=> 'endast den totala körningstiden',
		'2'		=> 'heltid',
		'3'		=> 'fullständig detalj (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Tröskelprestanda RDBMS:',
	'DebugSqlThresholdInfo'		=> 'I detaljerat felsökningsläge, rapportera endast de frågor som tar längre tid än antalet angivna sekunder.',
	'DebugAdminOnly'			=> 'Stängd diagnos:',
	'DebugAdminOnlyInfo'		=> 'Visa felsökningsdata för programmet (och DBMS) endast för administratören.',

	'CachingSection'			=> 'Cachning alternativ',
	'Cache'						=> 'Cache renderade sidor:',
	'CacheInfo'					=> 'Spara renderade sidor i den lokala cachen för att snabba upp den efterföljande uppstarten. Gäller endast för oregistrerade besökare.',
	'CacheTtl'					=> 'Time-to-live för cachade sidor:',
	'CacheTtlInfo'				=> 'Cache-sidor inte mer än ett angivet antal sekunder.',
	'CacheSql'					=> 'Cache DBMS frågor:',
	'CacheSqlInfo'				=> 'Behåll en lokal cache av resultaten från vissa resursrelaterade SQL-frågor.',
	'CacheSqlTtl'				=> 'Time-to-live för cachelagrade SQL-frågor:',
	'CacheSqlTtlInfo'			=> 'Cache resultat av SQL-frågor i högst det angivna antalet sekunder. Värden större än 1200 är inte önskvärda.',

	'LogSection'				=> 'Logga inställningar',
	'LogLevelUsage'				=> 'Använd loggning:',
	'LogLevelUsageInfo'			=> 'Minimiprioritet för de händelser som registreras i loggen.',
	'LogThresholds'	=> [
		'0'		=> 'förvara inte en tidskrift',
		'1'		=> 'bara den kritiska nivån',
		'2'		=> 'från den högsta nivån',
		'3'		=> 'från hög',
		'4'		=> 'i genomsnitt',
		'5'		=> 'från låg',
		'6'		=> 'den lägsta nivån',
		'7'		=> 'spela in alla',
	],
	'LogDefaultShow'			=> 'Visa loggläge:',
	'LogDefaultShowInfo'		=> 'De minsta prioritetshändelserna som visas i loggen som standard.',
	'LogModes'	=> [
		'1'		=> 'bara den kritiska nivån',
		'2'		=> 'från den högsta nivån',
		'3'		=> 'från hög nivå',
		'4'		=> 'den genomsnittliga',
		'5'		=> 'från en låg',
		'6'		=> 'från miniminivå',
		'7'		=> 'visa alla',
	],
	'LogPurgeTime'				=> 'Lagringstid för loggen:',
	'LogPurgeTimeInfo'			=> 'Ta bort händelseloggen efter det angivna antalet dagar.',

	'PrivacySection'			=> 'Sekretess',
	'AnonymizeIp'				=> 'Anonymisera användarnas IP-adresser:',
	'AnonymizeIpInfo'			=> 'Anonymisera IP-adresser där det är tillämpligt (dvs sida, revision eller referenter).',

	'ReverseProxySection'		=> 'Omvänd proxy',
	'ReverseProxy'				=> 'Använd omvänd proxy:',
	'ReverseProxyInfo'			=> 'Aktivera denna inställning för att bestämma rätt IP-adress för fjärrklienten genom att undersöka information som lagras i X-Forwarded-For headers. X-Forwarded-For headers är en standardmekanism för att identifiera klientsystem som ansluter via en omvänd proxyserver, såsom Squid eller Pound. Omvänd proxyservrar används ofta för att förbättra prestandan för starkt besökta webbplatser och kan också ge andra webbplatscaching, säkerhet eller krypteringsfördelar. Om denna WackoWiki installation fungerar bakom en omvänd proxy, denna inställning bör aktiveras så att korrekt IP-adressinformation samlas in i WackoWiki:s sessionshantering, loggning, statistik och system för åtkomsthantering; om du är osäker på denna inställning, inte har en omvänd proxy, eller WackoWiki fungerar i en delad webbhotellsmiljö bör denna inställning förbli inaktiverad.',
	'ReverseProxyHeader'		=> 'Omvänd proxy header:',
	'ReverseProxyHeaderInfo'	=> 'Ange detta värde om din proxyserver skickar klientens IP i ett header
									 <unk> <unk> <unk> <unk> <unk> <unk> <unk> andra än X-Forwarded-For. Headern "X-Forwarded-For" är en komma-avgränsad lista över IP
									 <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> ; endast den sista (den vänster-mest) kommer att användas.',
	'ReverseProxyAddresses'		=> 'reverse_proxy accepterar en rad IP-adresser:',
	'ReverseProxyAddressesInfo'	=> 'Varje element i denna array är IP-adressen för någon av dina omvända
									 <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> proxies. Om du använder denna matris, WackoWiki litar på den information som lagras
									 <unk> <unk> <unk> <unk> <unk> <unk> i X-Forwarded-For headers endast om fjärr-IP-adressen är en av
									 <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> dessa det vill säga att begäran når webbservern från en av dina
									 <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> omvända proxyer. Annars kan klienten ansluta direkt till
									 <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> din webbserver genom att spoofing X-Forwarded-For headers.',

	'SessionSection'				=> 'Sessionshantering',
	'SessionStorage'				=> 'Sessionslagring:',
	'SessionStorageInfo'			=> 'Det här alternativet definierar var sessionsdata lagras. Som standard väljs antingen fil- eller databassessionslagring.',
	'SessionModes'	=> [
		'1'		=> 'Fil',
		'2'		=> 'Databas',
	],
	'SessionNotice'					=> 'Meddelande om uppsägning av sessionen:',
	'SessionNoticeInfo'				=> 'Anger orsaken till sessionens avslutande.',
	'LoginNotice'					=> 'Meddelande om inloggning:',
	'LoginNoticeInfo'				=> 'Visar inloggningsmeddelande.',

	'RewriteMode'					=> 'Använd <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Om din webbserver stöder denna funktion, aktivera för att "försköna" sidan webbadresser.<br>
										<unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk>										<span class="cite">Värdet kan skrivas över av klassen Inställningar vid körning, oavsett om den är avstängd, om HTTP_MOD_REWRITE är på.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parametrar som ansvarar för åtkomstkontroll och behörigheter.',
	'PermissionsSettingsUpdated'	=> 'Uppdaterade behörighetsinställningar',

	'PermissionsSection'		=> 'Rättigheter och privilegier',
	'ReadRights'				=> 'Läs rättigheter som standard:',
	'ReadRightsInfo'			=> 'Standard tilldelad till de skapade rotsidorna, samt sidor för vilka överordnade ACL:er inte kan definieras.',
	'WriteRights'				=> 'Skriv rättigheter som standard:',
	'WriteRightsInfo'			=> 'Standard tilldelad till de skapade rotsidorna, samt sidor för vilka överordnade ACL:er inte kan definieras.',
	'CommentRights'				=> 'Kommentar rättigheter som standard:',
	'CommentRightsInfo'			=> 'Standard tilldelad till de skapade rotsidorna, samt sidor för vilka överordnade ACL:er inte kan definieras.',
	'CreateRights'				=> 'Skapa rättigheter för en undersida som standard:',
	'CreateRightsInfo'			=> 'Standard tilldelad till de skapade undersidorna.',
	'UploadRights'				=> 'Ladda upp rättigheter som standard:',
	'UploadRightsInfo'			=> 'Standardrättigheter för uppladdning.',
	'RenameRights'				=> 'Global byta namn på rätt:',
	'RenameRightsInfo'			=> 'Listan över behörigheter att fritt döpa om (flytta) sidor.',

	'LockAcl'					=> 'Lås alla ACL:er endast för läsning:',
	'LockAclInfo'				=> '<span class="cite">Skriver över ACL-inställningarna för alla sidor att läsa.</span><br>Detta kan vara användbart om ett projekt är klart, du vill ha en nära redigering under en tidsperiod av säkerhetsskäl, eller som ett nödsvar på en exploatering eller sårbarhet.',
	'HideLocked'				=> 'Dölj otillgängliga sidor:',
	'HideLockedInfo'			=> 'Om användaren inte har behörighet att läsa sidan, göm den i olika sidlistor (länken som placeras i texten kommer dock fortfarande att vara synlig).',
	'RemoveOnlyAdmins'			=> 'Endast administratörer kan ta bort sidor:',
	'RemoveOnlyAdminsInfo'		=> 'Neka alla, förutom administratörer, möjligheten att ta bort sidor. Den första gränsen gäller ägare av normala sidor.',
	'OwnersRemoveComments'		=> 'Ägare av sidor kan ta bort kommentarer:',
	'OwnersRemoveCommentsInfo'	=> 'Tillåt sidägare att moderera kommentarer på sina sidor.',
	'OwnersEditCategories'		=> 'Ägare kan redigera sidkategorier:',
	'OwnersEditCategoriesInfo'	=> 'Tillåt ägare att ändra sidornas kategorilista på din webbplats (lägg till ord, ta bort ord), tilldelar en sida.',
	'TermHumanModeration'		=> 'Mänsklig moderering löper ut:',
	'TermHumanModerationInfo'	=> 'Moderatorer kan bara redigera kommentarer om de inte skapades mer än detta antal dagar sedan (denna begränsning gäller inte för den sista kommentaren i ämnet).',

	'UserCanDeleteAccount'		=> 'Tillåt användare att ta bort sina konton',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parametrar som ansvarar för plattformens övergripande säkerhet, säkerhetsbegränsningar och ytterligare delsystem för säkerhet.',
	'SecuritySettingsUpdated'	=> 'Uppdaterade säkerhetsinställningar',

	'AllowRegistration'			=> 'Registrera dig online:',
	'AllowRegistrationInfo'		=> 'Öppen användarregistrering. Inaktivera detta alternativ kommer att förhindra gratis registrering, men webbplatsadministratören kommer fortfarande att kunna registrera användare.',
	'ApproveNewUser'			=> 'Godkänn nya användare:',
	'ApproveNewUserInfo'		=> 'Tillåter administratörer att godkänna användare när de registrerar sig. Endast godkända användare kommer att tillåtas logga in på webbplatsen.',
	'PersistentCookies'			=> 'Beständiga cookies:',
	'PersistentCookiesInfo'		=> 'Tillåt beständiga cookies.',
	'DisableWikiName'			=> 'Inaktivera WikiName:',
	'DisableWikiNameInfo'		=> 'Inaktivera obligatorisk användning av ett WikiName för användare. Tillåter användarregistrering med traditionella smeknamn istället för tvingade CamelCase-formaterade namn (dvs. NameSurname).',
	'UsernameLength'			=> 'Användarnamn längd:',
	'UsernameLengthInfo'		=> 'Minsta och högsta antal tecken i användarnamn.',

	'EmailSection'				=> 'E-post',
	'AllowEmailReuse'			=> 'Tillåt återanvändning av e-postadress:',
	'AllowEmailReuseInfo'		=> 'Olika användare kan registrera sig med samma e-postadress.',
	'EmailConfirmation'			=> 'Tvinga e-postbekräftelse:',
	'EmailConfirmationInfo'		=> 'Kräver att användaren verifierar sin e-postadress innan de kan logga in.',
	'AllowedEmailDomains'		=> 'Tillåtna e-postdomäner:',
	'AllowedEmailDomainsInfo'	=> 'Kommaseparerade e-postdomäner, t.ex. <code>example.com, local.lan</code> etc. Om det inte anges är alla e-postdomäner tillåtna.',
	'ForbiddenEmailDomains'		=> 'Förbjudna e-postdomäner:',
	'ForbiddenEmailDomainsInfo'	=> 'Kommaseparerade förbjudna e-postdomäner, t.ex. <code>example.com, local.lan</code> etc. Endast effektivt om tillåtna e-postdomäner listan är tom.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Aktivera captcha:',
	'EnableCaptchaInfo'			=> 'Om aktiverad, kommer captcha att visas i följande fall, eller om en säkerhetströskel uppnås.',
	'CaptchaComment'			=> 'Ny kommentar:',
	'CaptchaCommentInfo'		=> 'Som skydd mot skräppost, måste oregistrerade användare slutföra captcha innan kommentar kommer att publiceras.',
	'CaptchaPage'				=> 'Ny sida:',
	'CaptchaPageInfo'			=> 'Som skydd mot spam, måste oregistrerade användare slutföra captcha innan du skapar en ny sida.',
	'CaptchaEdit'				=> 'Redigera sida:',
	'CaptchaEditInfo'			=> 'Som skydd mot skräppost måste oregistrerade användare fylla i captcha innan de redigerar sidor.',
	'CaptchaRegistration'		=> 'Registrering:',
	'CaptchaRegistrationInfo'	=> 'Som skydd mot skräppost måste oregistrerade användare slutföra captcha innan de registrerar sig.',

	'TlsSection'				=> 'TLS inställningar',
	'TlsConnection'				=> 'TLS anslutning:',
	'TlsConnectionInfo'			=> 'Använd TLS-säkrad anslutning. <span class="cite">Aktivera det förinstallerade TLS-certifikatet på servern, annars förlorar du åtkomst till adminpanelen!</span><br>Det avgör också om flaggan för Cookie Secure Flag är satt: <code>Secure</code> -flaggan anger om cookies endast ska skickas över säkra anslutningar.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Återanslut klienten från HTTP till HTTPS. Med alternativet inaktiverat kan klienten bläddra genom en öppen HTTP-kanal.',

	'HttpSecurityHeaders'		=> 'HTTP Security Headers',
	'EnableSecurityHeaders'		=> 'Aktivera säkerhetsrubriker:',
	'EnableSecurityHeadersinfo'	=> 'Ställ in säkerhetshuvuden (frame busting, clickjacking/XSS/CSRF-skydd). <br>CSP kan orsaka problem i vissa situationer (t.ex. under utveckling), eller när du använder plugins som förlitar sig på externa resurser som bilder eller skript. <br>Inaktivera innehållets säkerhetspolicy är en säkerhetsrisk!',
	'Csp'						=> 'Säkerhetspolicy för innehåll (CSP):',
	'CspInfo'					=> 'Konfigurera CSP innebär att besluta vilka policyer du vill genomdriva, och sedan konfigurera dem och använda Content-Security-Policy för att fastställa din policy.',
	'PolicyModes'	=> [
		'0'		=> 'inaktiverad',
		'1'		=> 'strikt',
		'2'		=> 'anpassad',
	],
	'PermissionsPolicy'			=> 'Behörighetspolicy:',
	'PermissionsPolicyInfo'		=> 'HTTP-behörigheter-Policy header ger en mekanism för att uttryckligen aktivera eller inaktivera olika kraftfulla webbläsarfunktioner.',
	'ReferrerPolicy'			=> 'Hänvisarens policy:',
	'ReferrerPolicyInfo'		=> 'HTTP-headern för hänvisningspolicyn styr vilka uppgifter om hänvisning, som skickas i rubrik för hänvisning, bör inkluderas i svaren.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'utan referens',
		'2'		=> 'utan referrer-när-nedgradera',
		'3'		=> 'samma ursprung',
		'4'		=> 'ursprung',
		'5'		=> 'strikt-ursprung',
		'6'		=> 'ursprung-när-kors-ursprung',
		'7'		=> 'strikt-ursprung-när-kors-ursprung',
		'8'		=> 'osäker url'
	],

	'UserPasswordSection'		=> 'Beständighet av användarens lösenord',
	'PwdMinChars'				=> 'Minsta längd på lösenordet:',
	'PwdMinCharsInfo'			=> 'Längre lösenord är nödvändigtvis säkrare än kortare lösenord (t.ex. 12 till 16 tecken).<br>Användningen av lösenord istället för lösenord uppmuntras.',
	'AdminPwdMinChars'			=> 'Minsta längd på administratörslösenord:',
	'AdminPwdMinCharsInfo'		=> 'Längre lösenord är nödvändigtvis säkrare än kortare lösenord (t.ex. 15 till 20 tecken).<br>Användningen av lösenord istället för lösenord uppmuntras.',
	'PwdCharComplexity'			=> 'Obligatorisk lösenordskomplexitet:',
	'PwdCharClasses'	=> [
		'0'		=> 'ej testad',
		'1'		=> 'alla bokstäver + siffror',
		'2'		=> 'versaler och gemener + siffror',
		'3'		=> 'stora och små bokstäver + siffror + tecken',
	],
	'PwdUnlikeLogin'			=> 'Ytterligare komplikation:',
	'PwdUnlikes'	=> [
		'0'		=> 'ej testad',
		'1'		=> 'lösenordet är inte identiskt med inloggningen',
		'2'		=> 'lösenordet innehåller inte användarnamn',
	],

	'LoginSection'				=> 'Inloggning',
	'MaxLoginAttempts'			=> 'Maximalt antal inloggningsförsök per användarnamn:',
	'MaxLoginAttemptsInfo'		=> 'Antalet inloggningsförsök som tillåts för ett enda konto innan anti-spambot uppgiften utlöses. Ange 0 för att förhindra att anti-spambot uppgiften utlöses för distinkta användarkonton.',
	'IpLoginLimitMax'			=> 'Maximalt antal inloggningsförsök per IP-adress:',
	'IpLoginLimitMaxInfo'		=> 'Tröskeln för inloggningsförsök som tillåts från en enda IP-adress innan en anti-spambot uppgift utlöses. Ange 0 för att förhindra att anti-spambot-uppgiften utlöses av IP-adresser.',

	'FormsSection'				=> 'Formulär',
	'FormTokenTime'				=> 'Maximal tid att skicka in formulär:',
	'FormTokenTimeInfo'			=> 'Den tid som en användare måste skicka in ett formulär (i sekunder).<br> Observera att ett formulär kan bli ogiltigt om sessionen upphör, oavsett denna inställning.',

	'SessionLength'				=> 'Sessionscookies utgång:',
	'SessionLengthInfo'			=> 'Livslängden för användarens sessionscookie som standard (i dagar).',
	'CommentDelay'				=> 'Anti-flod för kommentarer:',
	'CommentDelayInfo'			=> 'Minsta fördröjning mellan publicering av nya kommentarer (i sekunder).',
	'IntercomDelay'				=> 'Anti-flod för personlig kommunikation:',
	'IntercomDelayInfo'			=> 'Minsta fördröjning mellan att skicka privata meddelanden (i sekunder).',
	'RegistrationDelay'			=> 'Tidströskel för registrering:',
	'RegistrationDelayInfo'		=> 'Den minsta tidsgränsen mellan registreringsformulär inlämningar för att avskräcka registreringsrobotar (i sekunder).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Grupp av parametrar som ansvarar för finjustering av webbplatsen. Ändra inte dem om du inte är säker på deras handlingar.',
	'FormatterSettingsUpdated'	=> 'Uppdaterade formateringsinställningar',

	'TextHandlerSection'		=> 'Texthanterare:',
	'Typografica'				=> 'Typografisk korrekturläsare:',
	'TypograficaInfo'			=> 'Inaktivera detta alternativ kommer att påskynda processerna för att lägga till kommentarer och spara sidor.',
	'Paragrafica'				=> 'Paragrafica märkningar:',
	'ParagraficaInfo'			=> 'I likhet med det tidigare alternativet, men kommer att leda till frånkoppling av obrukbar automatisk innehållsförteckning (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Globalt HTML-stöd:',
	'AllowRawhtmlInfo'			=> 'Det här alternativet är potentiellt osäkert för en öppen webbplats.',
	'SafeHtml'					=> 'Filtrerar HTML:',
	'SafeHtmlInfo'				=> 'Förhindrar att farliga HTML-objekt sparas. Att stänga av filtret på en öppen webbplats med HTML-stöd är <span class="underline">extremt</span> oönskat!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formatter)',
	'X11colors'					=> 'X11 färger användning:',
	'X11colorsInfo'				=> 'Utökar de tillgängliga färgerna för <code>??(färg) bakgrund??</code> och <code>!!(färg) text!!</code>Inaktivera detta alternativ snabbar upp processerna för att lägga till kommentarer och spara sidor.',
	'WikiLinks'					=> 'Inaktivera wikisänkar:',
	'WikiLinksInfo'				=> 'Inaktiverar länkning för <code>CamelCaseOrd</code>: Dina CamelCase-ord kommer inte längre att länkas direkt till en ny sida. Detta är användbart när du arbetar i olika namnrymder/kluster. Som standard är den avstängd.',
	'BracketsLinks'				=> 'Inaktivera bracketed länkar:',
	'BracketsLinksInfo'			=> 'Inaktiverar <code>[[link]]</code> och <code>((link))</code> syntax.',
	'Formatters'				=> 'Inaktivera format:',
	'FormattersInfo'			=> 'Inaktiverar <code>%%code%%</code> syntax, används för highlighters.',

	'DateFormatsSection'		=> 'Datumformat',
	'DateFormat'				=> 'Formatet på datumet:',
	'DateFormatInfo'			=> '(dag, månad, år)',
	'TimeFormat'				=> 'Formatet av tid:',
	'TimeFormatInfo'			=> '(timme, minut)',
	'TimeFormatSeconds'			=> 'Formatet på den exakta tiden:',
	'TimeFormatSecondsInfo'		=> '(timmar, minuter, sekunder)',
	'NameDateMacro'				=> 'Formatet på <code>::@::</code> makron:',
	'NameDateMacroInfo'			=> '(namn, tid), t.ex. <code>Användarnamn (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Timezone:',
	'TimezoneInfo'				=> 'Tidszon att använda för att visa tider för användare som inte är inloggade (gäster). Inloggade användare kan ändra sin tidszon i sina användarinställningar.',
	'AmericanDate'					=> 'Amerikansk datum:',
	'AmericanDateInfo'				=> 'Använder amerikanskt datumformat som standard för engelska.',

	'Canonical'					=> 'Använd fullt kanoniska URL:er:',
	'CanonicalInfo'				=> 'Alla länkar skapas som absoluta URL:er i formuläret %1. URL:er i förhållande till serverroten i formuläret %2 bör vara att föredra.',
	'LinkTarget'				=> 'Där externa länkar öppnas:',
	'LinkTargetInfo'			=> 'Öppnar varje extern länk i ett nytt webbläsarfönster. Lägger till <code>target="_blank"</code> i länksyntaxen.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Kräver att webbläsaren inte ska skicka en HTTP-referens header om användaren följer hyperlänken. Lägger till <code>rel="noreferrer"</code> till länksyntax.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Berättar sökmotorer att hyperlänkarna inte bör påverka sidrankningen av målsidan i sökmotorns index. Lägger till <code>rel="nofollow"</code> till länksyntax.',
	'UrlsUnderscores'			=> 'Formuläradresser (URL:er) med understreck:',
	'UrlsUnderscoresInfo'		=> 'Till exempel blev %1 %2 med det här alternativet.',
	'ShowSpaces'				=> 'Visa mellanslag i WikiNames:',
	'ShowSpacesInfo'			=> 'Visa mellanslag i WikiNames, t.ex. <code>MyName</code> som visas som <code>Mitt namn</code> med det här alternativet.',
	'NumerateLinks'				=> 'Uppge länkar i utskriftsvy:',
	'NumerateLinksInfo'			=> 'Exumererar och listar alla länkar längst ner i utskriftsvyn med detta alternativ.',
	'YouareHereText'			=> 'Inaktivera och visualisera självrefererande länkar:',
	'YouareHereTextInfo'		=> 'Visualisera länkar till samma sida, med hjälp av <code>&lt;b&gt;####&lt;/b&gt;</code>. Alla länkar till själv-förlora länkformatering, men visas som fet text.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Här kan du ställa in eller ändra systemets bassidor som används i Wiki. Se till att du inte glömmer att skapa eller ändra motsvarande sidor i Wiki enligt dina inställningar här.',
	'PagesSettingsUpdated'		=> 'Uppdaterade bassidor för inställningar',

	'ListCount'					=> 'Antal objekt per lista:',
	'ListCountInfo'				=> 'Antal objekt som visas på varje lista för gäster, eller som standardvärde för nya användare.',

	'ForumSection'				=> 'Alternativ Forum',
	'ForumCluster'				=> 'Klusterforum:',
	'ForumClusterInfo'			=> 'Root-kluster för forumavsnitt (åtgärd %1).',
	'ForumTopics'				=> 'Antal ämnen per sida:',
	'ForumTopicsInfo'			=> 'Antal ämnen som visas på varje sida i listan i forumsektionerna (åtgärd %1).',
	'CommentsCount'				=> 'Antal kommentarer per sida:',
	'CommentsCountInfo'			=> 'Antal kommentarer som visas på varje sidas lista över kommentarer. Detta gäller alla kommentarer på webbplatsen, inte bara de som postas i forumet.',

	'NewsSection'				=> 'Nyheter i sektionen',
	'NewsCluster'				=> 'Kluster för nyheterna:',
	'NewsClusterInfo'			=> 'Rotkluster för nyhetssektion (åtgärd %1).',
	'NewsStructure'				=> 'Nyhetsklusterstruktur:',
	'NewsStructureInfo'			=> 'Lagrar artiklar som tillval i undergrupper per år/månad eller vecka (t.ex. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licens',
	'DefaultLicense'			=> 'Standard licens:',
	'DefaultLicenseInfo'		=> 'Under vilken licens ditt innehåll kan släppas.',
	'EnableLicense'				=> 'Aktivera licens:',
	'EnableLicenseInfo'			=> 'Aktivera för att visa licensinformation.',
	'LicensePerPage'			=> 'Licens per sida:',
	'LicensePerPageInfo'		=> 'Tillåt licens per sida, som sidägaren kan välja via sidegenskaper.',

	'ServicePagesSection'		=> 'Tjänstens sidor',
	'RootPage'					=> 'Hemsida:',
	'RootPageInfo'				=> 'Tagg av din huvudsida, öppnas automatiskt när en användare besöker din webbplats.',

	'PrivacyPage'				=> 'Integritetspolicy:',
	'PrivacyPageInfo'			=> 'Sidan med sekretesspolicyn för webbplatsen.',

	'TermsPage'					=> 'Policyer och förordningar:',
	'TermsPageInfo'				=> 'Sidan med reglerna för webbplatsen.',

	'SearchPage'				=> 'Sök:',
	'SearchPageInfo'			=> 'Sida med sökformuläret (åtgärd %1).',
	'RegistrationPage'			=> 'Registrering:',
	'RegistrationPageInfo'		=> 'Sida för ny användarregistrering (åtgärd %1).',
	'LoginPage'					=> 'Användarens inloggning:',
	'LoginPageInfo'				=> 'Inloggningssidan på webbplatsen (åtgärd %1).',
	'SettingsPage'				=> 'Användarinställningar:',
	'SettingsPageInfo'			=> 'Sida för att anpassa användarprofilen (åtgärd %1).',
	'PasswordPage'				=> 'Ändra lösenord:',
	'PasswordPageInfo'			=> 'Sida med ett formulär för att ändra / fråga användarlösenord (åtgärd %1).',
	'UsersPage'					=> 'Användarlista:',
	'UsersPageInfo'				=> 'Sida med en lista över registrerade användare (åtgärd %1).',
	'CategoryPage'				=> 'Kategori:',
	'CategoryPageInfo'			=> 'Sida med en lista över kategoriserade sidor (åtgärd %1).',
	'GroupsPage'				=> 'Grupper:',
	'GroupsPageInfo'			=> 'Sida med en lista över arbetsgrupper (åtgärd %1).',
	'WhatsNewPage'				=> 'Vad är nytt:',
	'WhatsNewPageInfo'			=> 'Sida med en lista över alla nya, raderade eller ändrade sidor, nya bilagor och kommentarer. (åtgärd %1).',
	'ChangesPage'				=> 'Senaste ändringarna:',
	'ChangesPageInfo'			=> 'Sida med en lista över de senast ändrade sidorna (åtgärd %1).',
	'CommentsPage'				=> 'Senaste kommentarer:',
	'CommentsPageInfo'			=> 'Sida med en lista över de senaste kommentarerna på sidan (åtgärd %1).',
	'RemovalsPage'				=> 'Borttagna sidor:',
	'RemovalsPageInfo'			=> 'Sida med en lista över nyligen borttagna sidor (åtgärd %1).',
	'WantedPage'				=> 'Önskade sidor:',
	'WantedPageInfo'			=> 'Sida med en lista över saknade sidor som refereras (åtgärd %1).',
	'OrphanedPage'				=> 'Övergivna sidor:',
	'OrphanedPageInfo'			=> 'Sida med en lista över befintliga sidor är inte relaterade via länkar till någon annan sida (åtgärd %1).',
	'SandboxPage'				=> 'Sandlåda:',
	'SandboxPageInfo'			=> 'Sida där användare kan öva sina wiki-markeringsfärdigheter.',
	'HelpPage'					=> 'Hjälp:',
	'HelpPageInfo'				=> 'Sektionen för dokumentation för att arbeta med webbplatsverktyg.',
	'IndexPage'					=> 'Index:',
	'IndexPageInfo'				=> 'Sida med en lista över alla sidor (åtgärd %1).',
	'RandomPage'				=> 'Slumpmässig:',
	'RandomPageInfo'			=> 'Laddar en slumpmässig sida (åtgärd %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parametrar för aviseringar av plattformen.',
	'NotificationSettingsUpdated'	=> 'Uppdaterade aviseringsinställningar',

	'EmailNotification'			=> 'E-postmeddelande:',
	'EmailNotificationInfo'		=> 'Tillåt e-postavisering. Sätt till Aktiverad för att aktivera e-postaviseringar, inaktiverad för att inaktivera dem. Observera att inaktivering av e-postmeddelanden inte har någon effekt på e-post som genereras som en del av användarens registreringsprocess.',
	'Autosubscribe'				=> 'Autosubscribe:',
	'AutosubscribeInfo'			=> 'Meddela automatiskt ägaren av sidändringar.',

	'NotificationSection'		=> 'Standardinställningar för användaraviseringar',
	'NotifyPageEdit'			=> 'Notifiera sidredigering:',
	'NotifyPageEditInfo'		=> 'Väntande - Skicka ett e-postmeddelande endast för den första ändringen tills användaren besöker sidan igen.',
	'NotifyMinorEdit'			=> 'Meddela mindre redigering:',
	'NotifyMinorEditInfo'		=> 'Skickar notifieringar även för mindre redigeringar.',
	'NotifyNewComment'			=> 'Notifiera ny kommentar:',
	'NotifyNewCommentInfo'		=> 'Väntande - Skicka ett e-postmeddelande endast för den första kommentaren tills användaren besöker sidan igen.',

	'NotifyUserAccount'			=> 'Meddela nytt användarkonto:',
	'NotifyUserAccountInfo'		=> 'Administratören kommer att meddelas när en ny användare har skapats med hjälp av registreringsformuläret.',
	'NotifyUpload'				=> 'Meddela filuppladdning:',
	'NotifyUploadInfo'			=> 'Moderatorerna kommer att meddelas när en fil har laddats upp.',

	'PersonalMessagesSection'	=> 'Personliga meddelanden',
	'AllowIntercomDefault'		=> 'Tillåt intercom:',
	'AllowIntercomDefaultInfo'	=> 'Aktivera detta alternativ tillåter andra användare att skicka personliga meddelanden till mottagarens e-postadress utan att avslöja adressen.',
	'AllowMassemailDefault'		=> 'Tillåt mass-e-post:',
	'AllowMassemailDefaultInfo'	=> 'Skicka endast meddelanden till de användare som har tillåtit administratörer att skicka information till dem.',

	// Resync settings
	'Synchronize'				=> 'Synchronize',
	'UserStatsSynched'			=> 'Användarstatistik synkroniserad.',
	'PageStatsSynched'			=> 'Sidstatistik synkroniserad.',
	'FeedsUpdated'				=> 'RSS-flöden uppdaterade.',
	'SiteMapCreated'			=> 'Den nya versionen av sajtkartan har skapats.',
	'ParseNextBatch'			=> 'Tolka nästa omgång sidor:',
	'WikiLinksRestored'			=> 'Wiki-länkar återställda.',

	'LogUserStatsSynched'		=> 'Synkroniserad användarstatistik',
	'LogPageStatsSynched'		=> 'Synkroniserad sidstatistik',
	'LogFeedsUpdated'			=> 'Synkroniserade RSS-flöden',
	'LogPageBodySynched'		=> 'Omvänd sida kropp och länkar',

	'UserStats'					=> 'Användarstatistik',
	'UserStatsInfo'				=> 'Användarstatistik (antal kommentarer, egna sidor, revisioner och filer) kan i vissa situationer skilja sig från faktiska uppgifter. <br>Denna åtgärd gör det möjligt att uppdatera statistik för att matcha faktiska data som finns i databasen.',
	'PageStats'					=> 'Sidstatistik',
	'PageStatsInfo'				=> 'Sidstatistik (antal kommentarer, filer och revisioner) kan i vissa situationer skilja sig från faktiska uppgifter. <br>Den här åtgärden gör det möjligt att uppdatera statistik för att matcha faktiska data som finns i databasen.',

	'AttachmentsInfo'			=> 'Uppdatera filen hash för alla bilagor i databasen.',
	'AttachmentsSynched'		=> 'Åter hashade alla bilagor',
	'LogAttachmentsSynched'		=> 'Åter hashade alla bilagor',

	'Feeds'						=> 'Flöden',
	'FeedsInfo'					=> 'När det gäller direkt redigering av sidor i databasen kan innehållet i RSS-flöden inte återspegla de ändringar som gjorts. <br>Denna funktion synkroniserar RSS-kanalerna med databasens aktuella tillstånd.',
	'XmlSiteMap'				=> 'XML Sitemap',
	'XmlSiteMapInfo'			=> 'Denna funktion synkroniserar XML-Sitemap med det aktuella tillståndet i databasen.',
	'XmlSiteMapPeriod'			=> 'Period %1 dagar. Senast skriven %2.',
	'XmlSiteMapView'			=> 'Visa sajtkarta i ett nytt fönster.',

	'ReparseBody'				=> 'Tolka alla sidor',
	'ReparseBodyInfo'			=> 'Empties <code>body_r</code> i sidtabellen, så att varje sida blir renderas igen på nästa sidvy. Detta kan vara användbart om du ändrat formatet eller ändrat domänen för din wiki.',
	'PreparsedBodyPurged'		=> 'Tömd <code>body_r</code> fält i sidtabellen.',

	'WikiLinksResync'			=> 'Wiki länkar',
	'WikiLinksResyncInfo'		=> 'Utför en re-rendering för alla intrasite-länkar och återställer innehållet i tabellerna <code>page_link</code> och <code>file_link</code> i händelse av skada eller flytt (detta kan ta lång tid).',
	'RecompilePage'				=> 'Återsammanställa alla sidor (extremt dyra)',
	'ResyncOptions'				=> 'Ytterligare alternativ',
	'RecompilePageLimit'		=> 'Antal sidor att tolka på en gång.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Denna information används när motorn skickar e-post till dina användare. Se till att e-postadressen du anger är giltig, eftersom alla studsade eller icke levererbara meddelanden sannolikt kommer att skickas till den adressen. Om ditt webbhotell inte tillhandahåller någon e-posttjänst (PHP-baserad) kan du istället skicka meddelanden direkt via SMTP. Detta kräver adressen till en lämplig server (fråga din webbhotellsleverantör om det behövs). Om servern kräver autentisering (och endast om den gör), ange nödvändigt användarnamn, lösenord och autentiseringsmetod.',

	'EmailSettingsUpdated'		=> 'Uppdaterade e-postinställningar',

	'EmailFunctionName'			=> 'Namn på e-postfunktionen:',
	'EmailFunctionNameInfo'		=> 'E-postfunktionen som används för att skicka e-post via PHP.',
	'UseSmtpInfo'				=> 'Välj <code>SMTP</code> om du vill, eller måste, skicka e-post via en namngiven server istället för via den lokala e-postfunktionen.',

	'EnableEmail'				=> 'Aktivera e-postmeddelanden:',
	'EnableEmailInfo'			=> 'Aktivera sändning av e-post.',

	'EmailIdentitySettings'		=> 'Webbplatsens e-postadresser',
	'FromEmailName'				=> 'Från namn:',
	'FromEmailNameInfo'			=> 'Avsändarens namn som används för <code>Från:</code> header för alla e-postmeddelanden som skickas från webbplatsen.',
	'EmailSubjectPrefix'		=> 'Prefix:',
	'EmailSubjectPrefixInfo'	=> 'Alternativt ämne prefix, t.ex. <code>[Prefix] Ämne</code>. Om inte definierat, är standardprefixet webbplatsens namn: %1.',

	'NoReplyEmail'				=> 'Ingen svarsadress:',
	'NoReplyEmailInfo'			=> 'Denna adress, t.ex. <code>noreply@example.com</code>, kommer att visas i <code>Från:</code> e-postadressfältet för alla e-postmeddelanden som skickas från webbplatsen.',
	'AdminEmail'				=> 'E-post av webbplatsens ägare:',
	'AdminEmailInfo'			=> 'Den här adressen används i administratörssyfte, som ett meddelande om nya användare.',
	'AbuseEmail'				=> 'Tjänsten för missbruk av e-post:',
	'AbuseEmailInfo'			=> 'Adressförfrågningar för brådskande ärenden: registrering för en utländsk e-post, etc. Det kan vara samma som sajtens ägare e-post.',

	'SendTestEmail'				=> 'Skicka ett testmeddelande',
	'SendTestEmailInfo'			=> 'Detta kommer att skicka ett testmeddelande till den adress som anges i ditt konto.',
	'TestEmailSubject'			=> 'Din wiki är korrekt konfigurerad för att skicka e-post',
	'TestEmailBody'				=> 'Om du fick detta e-postmeddelande är din Wiki korrekt konfigurerad att skicka e-post.',
	'TestEmailMessage'			=> 'Testmeddelandet har skickats.<br>Om du inte får det, kontrollera inställningarna för din e-postkonfiguration.',

	'SmtpSettings'				=> 'SMTP inställningar',
	'SmtpAutoTls'				=> 'Opportunistisk TLS:',
	'SmtpAutoTlsInfo'			=> 'Aktiverar kryptering automatiskt, om den ser att servern annonserar TLS-kryptering (efter att du har anslutit till servern), även om du inte har ställt in anslutningsläget för <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Anslutningsläge för SMTP:',
	'SmtpConnectionModeInfo'	=> 'Används endast om ett användarnamn/lösenord krävs. Fråga din leverantör om du är osäker på vilken metod du ska använda',
	'SmtpPassword'				=> 'SMTP lösenord:',
	'SmtpPasswordInfo'			=> 'Ange bara ett lösenord om din SMTP-server kräver det.<br><em><strong>Varning:</strong> Detta lösenord kommer att lagras som klartext i databasen, synlig för alla som kan komma åt din databas eller som kan se denna konfigurationssida.</em>',
	'SmtpPort'					=> 'SMTP-serverport:',
	'SmtpPortInfo'				=> 'Ändra bara detta om du vet att din SMTP-server är på en annan port. <br>(standard: <code>tls</code> på port 587 (eller möjligen 25) och <code>ssl</code> på port 465).',
	'SmtpServer'				=> 'SMTP-serveradress:',
	'SmtpServerInfo'			=> 'Observera att du måste ange det protokoll som din server använder. Om du använder SSL, måste detta vara <code>ssl://mail.example.com</code>.',
	'SmtpUsername'				=> 'SMTP användarnamn:',
	'SmtpUsernameInfo'			=> 'Ange bara ett användarnamn om din SMTP-server kräver det.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Här kan du konfigurera huvudinställningarna för bilagor och tillhörande specialkategorier.',
	'UploadSettingsUpdated'		=> 'Uppdaterade uppladdningsinställningar',

	'FileUploadsSection'		=> 'Ladda upp filer',
	'RegisteredUsers'			=> 'registrerade användare',
	'RightToUpload'				=> 'Behörighet att ladda upp filer:',
	'RightToUploadInfo'			=> '<code>administratörer</code> innebär att endast användare som tillhör administratörsgruppen kan ladda upp filer. <code>1</code> innebär att uppladdning öppnas för registrerade användare. <code>0</code> betyder att uppladdning är inaktiverad.',
	'UploadMaxFilesize'			=> 'Maximal filstorlek:',
	'UploadMaxFilesizeInfo'		=> 'Maximal storlek för varje fil. Om detta värde är 0, begränsas den maximala uppladdningsbara filstorleken endast av din PHP-konfiguration.',
	'UploadQuota'				=> 'Total bilagakvot:',
	'UploadQuotaInfo'			=> 'Maximalt lagringsutrymme för bilagor för hela wiki, med obegränsad <code>0</code> . %1 används.',
	'UploadQuotaUser'			=> 'Lagringskvot per användare:',
	'UploadQuotaUserInfo'		=> 'Begränsning av kvoten för lagring som kan laddas upp av en användare, med <code>0</code> obegränsad.',

	'FileTypes'					=> 'Typer av fil',
	'UploadOnlyImages'			=> 'Tillåt endast uppladdning av bilder:',
	'UploadOnlyImagesInfo'		=> 'Tillåt endast uppladdning av bildfiler på sidan.',
	'AllowedUploadExts'			=> 'Tillåtna filtyper',
	'AllowedUploadExtsInfo'		=> 'Tillåtna tillägg för att ladda upp filer, kommaseparerade (dvs. <code>png, ogg, mp4</code>); annars är alla filtillägg tillåtna.<br>Du bör begränsa de tillåtna filtilläggen till det minimum som krävs för att din webbplats ska fungera korrekt.',
	'CheckMimetype'				=> 'Kontrollera MIME-typ:',
	'CheckMimetypeInfo'			=> 'Vissa webbläsare kan luras att anta en felaktig mimetyp för uppladdade filer. Detta alternativ säkerställer att sådana filer som kan orsaka detta avvisas.',
	'SvgSanitizer'				=> 'SVG sanitizer:',
	'SvgSanitizerInfo'			=> 'Detta gör det möjligt att sanera SVG-filer för att förhindra att SVG/XML-sårbarheter laddas upp.',
	'TranslitFileName'			=> 'Translitterera filnamn:',
	'TranslitFileNameInfo'		=> 'Om det är tillämpligt och det inte finns något behov av att ha Unicode-tecken, rekommenderas det starkt att endast acceptera alfanumeriska tecken i filnamn.',
	'TranslitCaseFolding'		=> 'Konvertera filnamn till gemensamt:',
	'TranslitCaseFoldingInfo'	=> 'Detta alternativ är endast effektivt med aktiv translitteration.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Create thumbnail:',
	'CreateThumbnailInfo'		=> 'Skapa en miniatyrbild i alla tänkbara situationer.',
	'JpegQuality'				=> 'JPEG kvalitet:',
	'JpegQualityInfo'			=> 'Kvalitet vid skalning av en JPEG-miniatyrbild. Den ska vara mellan 1 och 100, med 100 tecken på 100 % kvalitet.',
	'MaxImageArea'				=> 'Maximalt bildområde:',
	'MaxImageAreaInfo'			=> 'Det maximala antalet pixlar en källbild kan ha. Detta ger en gräns för minnesanvändning för dekompressionssidan av bildskalan.<br><code>-1</code> betyder att det inte kommer att kontrollera storleken på bilden innan du försöker skala den. <code>0</code> betyder att det kommer att bestämma värdet automatiskt.',
	'MaxThumbWidth'				=> 'Maximal miniatyrbredd i pixlar:',
	'MaxThumbWidthInfo'			=> 'En genererad miniatyrbild kommer inte att överskrida bredden här.',
	'MinThumbFilesize'			=> 'Minsta storlek på miniatyrbilden:',
	'MinThumbFilesizeInfo'		=> 'Skapa inte en miniatyrbild för bilder mindre än så här.',
	'MaxImageWidth'				=> 'Gräns för bildstorlek på sidor:',
	'MaxImageWidthInfo'			=> 'Maximal bredd en bild kan ha på sidor, annars genereras en skalad miniatyrbild.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Lista över borttagna sidor, revisioner och filer.
									<unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> Ta bort eller återställ sidorna, revideringar eller filer från databasen genom att klicka på länken <em>Ta bort</em>
									<unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> eller <em>Återställ</em> i motsvarande rad. (Var försiktig, ingen bekräftelse för att ta bort efterfrågas!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Ord som automatiskt censureras på din Wiki.',
	'FilterSettingsUpdated'		=> 'Uppdaterade inställningar för skräppostfilter',

	'WordCensoringSection'		=> 'Ord Censoring',
	'SPAMFilter'				=> 'Skräppostfilter:',
	'SPAMFilterInfo'			=> 'Aktiverar skräppostfilter',
	'WordList'					=> 'Ordlista:',
	'WordListInfo'				=> 'Ord eller fras <code>fragment</code> som ska svartlistas (en per rad)',

	// Log module
	'LogFilterTip'				=> 'Filtrera händelser efter kriterier:',
	'LogLevel'					=> 'Nivå',
	'LogLevelFilters'	=> [
		'1'		=> 'inte mindre än',
		'2'		=> 'inte högre än',
		'3'		=> 'lika',
	],
	'LogNoMatch'				=> 'Inga händelser som uppfyller kriterierna',
	'LogDate'					=> 'Datum',
	'LogEvent'					=> 'Händelse',
	'LogUsername'				=> 'Användarnamn',
	'LogLevels'	=> [
		'1'		=> 'kritisk',
		'2'		=> 'högsta',
		'3'		=> 'hög',
		'4'		=> 'medium',
		'5'		=> 'låg',
		'6'		=> 'lägsta',
		'7'		=> 'felsökning',
	],

	// Massemail module
	'MassemailInfo'				=> 'Här kan du mejla ett meddelande till antingen (1) alla dina användare eller (2) alla användare i en specifik grupp som har aktiverat mottagande av massutskick. Ett e-postmeddelande kommer att skickas ut till den administrativa e-postadressen som levereras, med en blind kopia (BCC) skickas till alla mottagare. Standardinställningen är att inkludera högst 20 mottagare i ett sådant e-postmeddelande. Om det finns fler än 20 mottagare kommer ytterligare e-post att skickas. Om du skickar e-post till en stor grupp människor, vänligen ha tålamod efter att ha skickat in och inte stoppa sidan halvvägs. Det är normalt att en massa e-post tar lång tid. Du kommer att meddelas när skriptet har slutförts.',
	'LogMassemail'				=> 'Massmail skicka %1 till grupp / användare ',
	'MassemailSend'				=> 'Massa e-post skicka',

	'NoEmailMessage'			=> 'Du måste ange ett meddelande.',
	'NoEmailSubject'			=> 'Du måste ange ett ämne för ditt meddelande.',
	'NoEmailRecipient'			=> 'Du måste ange minst en användare eller användargrupp.',

	'MassemailSection'			=> 'Massa e-post',
	'MessageSubject'			=> 'Ämne:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Ditt meddelande:',
	'YourMessageInfo'			=> 'Observera att du endast kan skriva in klartext. Alla markeringar kommer att tas bort innan du skickar.',

	'NoUser'					=> 'Ingen användare',
	'NoUserGroup'				=> 'Ingen användargrupp',

	'SendToGroup'				=> 'Skicka till grupp:',
	'SendToUser'				=> 'Skicka till användare:',
	'SendToUserInfo'			=> 'Endast användare som tillåter administratörer att skicka information till dem kommer att få massutskick. Det här alternativet är tillgängligt i deras användarinställningar under Meddelanden.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Uppdaterat systemmeddelande',

	'SysMsgSection'				=> 'System meddelande',
	'SysMsg'					=> 'Systemmeddelande:',
	'SysMsgInfo'				=> 'Din text här',

	'SysMsgType'				=> 'Typ:',
	'SysMsgTypeInfo'			=> 'Meddelandetyp (CSS).',
	'SysMsgAudience'			=> 'Målgrupp:',
	'SysMsgAudienceInfo'		=> 'Publiken systemet meddelande visas.',
	'EnableSysMsg'				=> 'Aktivera systemmeddelande:',
	'EnableSysMsgInfo'			=> 'Visa systemmeddelande.',

	// User approval module
	'ApproveNotExists'			=> 'Välj minst en användare via inställningsknappen.',

	'LogUserApproved'			=> 'Användare ##%1## godkänd',
	'LogUserBlocked'			=> 'Användare ##%1## blockerad',
	'LogUserDeleted'			=> 'Användare ##%1## togs bort från databasen',
	'LogUserCreated'			=> 'Skapade en ny användare ##%1##',
	'LogUserUpdated'			=> 'Uppdaterad användare ##%1##',
	'LogUserPasswordReset'		=> 'Lösenord för användare ##%1## har återställts',

	'UserApproveInfo'			=> 'Godkänn nya användare innan de kan logga in på webbplatsen.',
	'Approve'					=> 'Godkänn',
	'Deny'						=> 'Neka',
	'Pending'					=> 'Väntande',
	'Approved'					=> 'Godkänd',
	'Denied'					=> 'Nekad',

	// DB Backup module
	'BackupStructure'			=> 'Struktur',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Mapp',
	'BackupTable'				=> 'Tabell',
	'BackupCluster'				=> 'Kluster:',
	'BackupFiles'				=> 'Filer',
	'BackupNote'				=> 'Notera:',
	'BackupSettings'			=> 'Ange önskat system för säkerhetskopiering.<br>' .
    	'Rotklustret påverkar inte säkerhetskopiering av globala filer och säkerhetskopiering av cachefiler (om valt, de sparas alltid i sin helhet).<br>' .  '<br>' .
		'<strong>Obs</strong>: För att undvika förlust av information från databasen när du anger rotklustret, tabellerna från denna backup kommer inte att omstruktureras, samma som vid säkerhetskopiering endast tabellstruktur utan att spara data. För att göra en fullständig konvertering av tabellerna till säkerhetskopieringsformat måste du göra <em> full databas backup (struktur och data) utan att ange klustret</em>.',
	'BackupCompleted'			=> 'Säkerhetskopiering och arkivering slutförd.<br>' .
    	'Filerna för säkerhetskopior lagrades i underkatalogen %1.<br>. För att ladda ner den använder FTP (underhålla katalogstrukturen och filnamnen vid kopiering).<br> För att återställa en säkerhetskopia eller ta bort ett paket, gå till <a href="%2">Återställ databas</a>.',
	'LogSavedBackup'			=> 'Sparad säkerhetskopieringsdatabas ##%1##',
	'Backup'					=> 'Säkerhetskopiera',
	'CantReadFile'				=> 'Kan inte läsa filen %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Du kan återställa något av de säkerhetskopieringspaket som hittats, eller ta bort dem från servern.',
	'ConfirmDbRestore'			=> 'Vill du återställa säkerhetskopia %1?',
	'ConfirmDbRestoreInfo'		=> 'Var snäll och vänta, detta kan ta lite tid.',
	'RestoreWrongVersion'		=> 'Fel WackoWiki version!',
	'DirectoryNotExecutable'	=> '%1 -katalogen är inte körbar.',
	'BackupDelete'				=> 'Är du säker på att du vill ta bort säkerhetskopia %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Ytterligare återställningsalternativ:',
	'RestoreOptionsInfo'		=> '* Innan du återställer <strong>klusterbackup</strong>, ' .
									'måltabellerna tas inte bort (för att förhindra förlust av information från kluster som inte har säkerhetskopierats). ' .
									'Således, under återhämtningsprocessen dubbla poster kommer att inträffa. ' .
									'I normalt läge kommer alla av dem att ersättas av registreringsformulär säkerhetskopiering (med SQL <code>REPLACE</code>), ' .
									'men om denna kryssruta är markerad, alla dubbletter hoppas över (aktuella värden för poster kommer att behållas), ' .
									'och endast poster med nya nycklar läggs till i tabellen (SQL <code>INSERT IGNORE</code>).<br>' .
									'<strong>Notis</strong>: När du återställer fullständig säkerhetskopia av webbplatsen, har detta alternativ inget värde.<br>' .
									'<br>' .
									'** Om säkerhetskopian innehåller användarfilerna (global och persida, cachefiler, etc.), ' .
									'i normalt läge ersätter de befintliga filerna med samma namn och placeras i samma katalog när de återställs. ' .
									'Det här alternativet låter dig spara de aktuella kopiorna av filerna och återställa från en säkerhetskopia endast nya filer (saknas på servern).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignorera duplicerade bordsnycklar (ersätter inte)',
	'IgnoreSameFiles'			=> 'Ignorera samma filer (skriv inte över)',
	'NoBackupsAvailable'		=> 'Inga säkerhetskopior tillgängliga.',
	'BackupEntireSite'			=> 'Hela sajten',
	'BackupRestored'			=> 'Säkerhetskopieringen återställs, en sammanfattande rapport bifogas nedan. För att ta bort detta säkerhetskopieringspaket, klicka',
	'BackupRemoved'				=> 'Den valda säkerhetskopian har tagits bort.',
	'LogRemovedBackup'			=> 'Borttagen säkerhetskopia av databasen ##%1##',

	'RestoreStarted'			=> 'Initierad återställning',
	'RestoreParameters'			=> 'Använda parametrar',
	'IgnoreDuplicatedKeys'		=> 'Ignorera duplicerade nycklar',
	'IgnoreDuplicatedFiles'		=> 'Ignorera duplicerade filer',
	'SavedCluster'				=> 'Sparat kluster',
	'DataProtection'			=> 'Dataskydd - %1 utelämnad',
	'AssumeDropTable'			=> 'Anta %1',
	'RestoreTableStructure'		=> 'Återställa strukturen på tabellen',
	'RunSqlQueries'				=> 'Utför SQL-instruktioner:',
	'CompletedSqlQueries'		=> 'Färdigställd. Bearbetade instruktioner:',
	'NoTableStructure'			=> 'Strukturen på tabellerna sparades inte - hoppa över',
	'RestoreRecords'			=> 'Återställ innehållet i tabeller',
	'ProcessTablesDump'			=> 'Bara ladda ner och bearbeta tabelldumpar',
	'Instruction'				=> 'Instruktion',
	'RestoredRecords'			=> 'poster:',
	'RecordsRestoreDone'		=> 'Slutförd. Totalt antal poster:',
	'SkippedRecords'			=> 'Data sparades inte - hoppa över',
	'RestoringFiles'			=> 'Återställer filer',
	'DecompressAndStore'		=> 'Dekompressa och lagra innehållet i kataloger',
	'HomonymicFiles'			=> 'homonymiska filer',
	'RestoreSkip'				=> 'hoppa över',
	'RestoreReplace'			=> 'ersätt',
	'RestoreFile'				=> 'Fil:',
	'RestoredFiles'				=> 'återställd:',
	'SkippedFiles'				=> 'hoppad:',
	'FileRestoreDone'			=> 'Slutförd. Totalt antal filer:',
	'FilesAll'					=> 'alla:',
	'SkipFiles'					=> 'Filer är inte lagrade - hoppa över',
	'RestoreDone'				=> 'ÅTERSTÄLLNING KOMPLETAT',

	'BackupCreationDate'		=> 'Skapad datum',
	'BackupPackageContents'		=> 'Innehållet i paketet',
	'BackupRestore'				=> 'Återställ',
	'BackupRemove'				=> 'Radera',
	'RestoreYes'				=> 'Ja',
	'RestoreNo'					=> 'Nej',
	'LogDbRestored'				=> 'Backup ##%1## av databasen återställd.',

	'BackupArchived'			=> 'Säkerhetskopia %1 arkiverad.',
	'BackupArchiveExists'		=> 'Backuparkivet %1 finns redan.',
	'LogBackupArchived'			=> 'Backup ##%1## arkiverad.',

	// User module
	'UsersInfo'					=> 'Här kan du ändra dina användares information och vissa specifika alternativ.',

	'UsersAdded'				=> 'Användare tillagd',
	'UsersDeleteInfo'			=> 'Ta bort användare:',
	'EditButton'				=> 'Redigera',
	'UsersAddNew'				=> 'Lägg till ny användare',
	'UsersDelete'				=> 'Är du säker på att du vill ta bort användare %1?',
	'UsersDeleted'				=> 'Användaren %1 har tagits bort från databasen.',
	'UsersRename'				=> 'Byt namn på användaren %1 till',
	'UsersRenameInfo'			=> '* Obs: Ändring kommer att påverka alla sidor som tilldelas den användaren.',
	'UsersUpdated'				=> 'Användaren har uppdaterats.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Anmälningstid',
	'UserActions'				=> 'Åtgärder',
	'NoMatchingUser'			=> 'Inga användare som uppfyller kriterierna',

	'UserAccountNotify'			=> 'Meddela användaren',
	'UserNotifySignup'			=> 'informera användaren om det nya kontot',
	'UserVerifyEmail'			=> 'ange e-postbekräftelseroken och lägg till länk för e-postverifiering',
	'UserReVerifyEmail'			=> 'Skicka e-postbekräftelsemoken igen',

	// Groups module
	'GroupsInfo'				=> 'Från denna panel kan du administrera alla dina användargrupper. Du kan ta bort, skapa och redigera befintliga grupper. Dessutom kan du välja gruppledare, växla öppen/gömd/stängd gruppstatus och ange gruppnamn och beskrivning.',

	'LogMembersUpdated'			=> 'Uppdaterade medlemmar i användargruppen',
	'LogMemberAdded'			=> 'Lade till medlem ##%1## till grupp ##%2##',
	'LogMemberRemoved'			=> 'Tog bort medlem ##%1## från grupp ##%2##',
	'LogGroupCreated'			=> 'Skapade en ny grupp ##%1##',
	'LogGroupRenamed'			=> 'Grupp ##%1## bytt namn till ##%2##',
	'LogGroupRemoved'			=> 'Tog bort grupp ##%1##',

	'GroupsMembersFor'			=> 'Medlemmar för grupp',
	'GroupsDescription'			=> 'Beskrivning',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Öppna',
	'GroupsActive'				=> 'Aktiv',
	'GroupsTip'					=> 'Klicka för att redigera grupp',
	'GroupsUpdated'				=> 'Grupper uppdaterade',
	'GroupsAlreadyExists'		=> 'Denna grupp finns redan.',
	'GroupsAdded'				=> 'Gruppen har lagts till.',
	'GroupsRenamed'				=> 'Gruppen har döpts om.',
	'GroupsDeleted'				=> 'Gruppen %1 och alla tillhörande sidor har tagits bort från databasen.',
	'GroupsAdd'					=> 'Lägg till en ny grupp',
	'GroupsRename'				=> 'Döp om gruppen %1 till',
	'GroupsRenameInfo'			=> '* Obs: Ändring kommer att påverka alla sidor som tilldelas den gruppen.',
	'GroupsDelete'				=> 'Är du säker på att du vill ta bort gruppen %1?',
	'GroupsDeleteInfo'			=> '* Obs: Ändring kommer att påverka alla medlemmar som tilldelas den gruppen.',
	'GroupsIsSystem'			=> 'Gruppen %1 tillhör systemet och kan inte tas bort.',
	'GroupsStoreButton'			=> 'Spara grupper',
	'GroupsEditInfo'			=> 'För att redigera grupplistan väljer du radioknappen.',

	'GroupAddMember'			=> 'Lägg till medlem',
	'GroupRemoveMember'			=> 'Ta bort medlem',
	'GroupAddNew'				=> 'Lägg till grupp',
	'GroupEdit'					=> 'Redigera grupp',
	'GroupDelete'				=> 'Ta bort grupp',

	'MembersAddNew'				=> 'Lägg till ny medlem',
	'MembersAdded'				=> 'Lade till ny medlem till gruppen framgångsrikt.',
	'MembersRemove'				=> 'Är du säker på att du vill ta bort medlem %1?',
	'MembersRemoved'			=> 'Medlemmen togs bort från gruppen.',

	// Statistics module
	'DbStatSection'				=> 'Databasens statistik',
	'DbTable'					=> 'Tabell',
	'DbRecords'					=> 'Poster',
	'DbSize'					=> 'Storlek',
	'DbIndex'					=> 'Index',
	'DbTotal'					=> 'Totalt',

	'FileStatSection'			=> 'Statistik för filsystem',
	'FileFolder'				=> 'Mapp',
	'FileFiles'					=> 'Filer',
	'FileSize'					=> 'Storlek',
	'FileTotal'					=> 'Totalt',

	// Sysinfo module
	'SysInfo'					=> 'Versionsinformation:',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Värden',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Senast uppdaterad',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Serverns namn',
	'WebServer'					=> 'Webbserver',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'Databas',
	'SqlModesGlobal'			=> 'Globala SQL-lägen',
	'SqlModesSession'			=> 'Session för SQL-lägen',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Minne',
	'UploadFilesizeMax'			=> 'Ladda upp max filstorlek',
	'PostMaxSize'				=> 'Posta max storlek',
	'MaxExecutionTime'			=> 'Max körningstid',
	'SessionPath'				=> 'Sessionens sökväg',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip-komprimering',
	'PhpExtensions'				=> 'PHP-tillägg',
	'ApacheModules'				=> 'Apache-moduler',

	// DB repair module
	'DbRepairSection'			=> 'Reparera databas',
	'DbRepair'					=> 'Reparera databas',
	'DbRepairInfo'				=> 'Detta skript kan automatiskt leta efter några vanliga databasproblem och reparera dem. Reparation kan ta ett tag, så var tålmodig.',

	'DbOptimizeRepairSection'	=> 'Reparera och optimera databas',
	'DbOptimizeRepair'			=> 'Reparera och optimera databas',
	'DbOptimizeRepairInfo'		=> 'Detta skript kan också försöka optimera databasen. Detta förbättrar prestanda i vissa situationer. Reparation och optimering av databasen kan ta lång tid och databasen låses vid optimering.',

	'TableOk'					=> 'Tabellen %1 är okej.',
	'TableNotOk'				=> 'Tabellen %1 är inte okej. Den rapporterar följande fel: %2. Detta skript kommer att försöka reparera denna tabell&hellip;',
	'TableRepaired'				=> 'Reparerade framgångsrikt %1 tabellen.',
	'TableRepairFailed'			=> 'Det gick inte att reparera %1 tabellen. <br>fel: %2',
	'TableAlreadyOptimized'		=> 'Tabellen %1 är redan optimerad.',
	'TableOptimized'			=> 'Framgångsrikt optimerade %1 tabellen.',
	'TableOptimizeFailed'		=> 'Misslyckades att optimera %1 tabellen. <br>fel: %2',
	'TableNotRepaired'			=> 'Vissa databasproblem kunde inte repareras.',
	'RepairsComplete'			=> 'Reparationer slutförda',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Visa och fixa inkonsekvenser, ta bort eller tilldela övergivna poster till en ny användare / värde.',
	'Inconsistencies'			=> 'Inkonsekvenser',
	'CheckDatabase'				=> 'Databas',
	'CheckDatabaseInfo'			=> 'Kontrollerar om postinkonsekvenser i databasen.',
	'CheckFiles'				=> 'Filer',
	'CheckFilesInfo'			=> 'Kontrollerar efter övergivna filer, filer utan referens kvar i filtabellen.',
	'Records'					=> 'Poster',
	'InconsistenciesNone'		=> 'Inga datainkonsekvenser hittades.',
	'InconsistenciesDone'		=> 'Inkonsekvenser av data löst.',
	'InconsistenciesRemoved'	=> 'Borttagna inkonsekvenser',
	'Check'						=> 'Kontrollera',
	'Solve'						=> 'Lös',

	// Bad Behaviour module
	'BbInfo'					=> 'Upptäcker och blockerar oönskade webbåtkomster, neka automatiserade spamrobotar åtkomst.<br>För mer information, besök %1 hemsida.',
	'BbEnable'					=> 'Aktivera dåligt beteende:',
	'BbEnableInfo'				=> 'Alla andra inställningar kan ändras i konfigurationsmappen %1.',
	'BbStats'					=> 'Bad Behaviour har stoppat %1 tillgång försök under de senaste 7 dagarna.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Logg',
	'BbSettings'				=> 'Inställningar',
	'BbWhitelist'				=> 'Vitlista',

	// --> Log
	'BbHits'					=> 'Hits',
	'BbRecordsFiltered'			=> 'Visar %1 av %2 poster filtrerade av',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Blockerad',
	'BbPermitted'				=> 'Tillåten',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Visar alla %1 poster',
	'BbShow'					=> 'Visa',
	'BbIpDateStatus'			=> 'IP/Datum/Status',
	'BbHeaders'					=> 'Sidhuvuden',
	'BbEntity'					=> 'Enhet',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Alternativ sparade.',
	'BbWhitelistHint'			=> 'Olämplig vitlistning kommer att utsätta dig för skräppost, eller orsaka Bad Behaviour att sluta fungera helt! INTE VITELIST såvida du inte är 100% CERTAIN som du borde.',
	'BbIpAddress'				=> 'IP-adress',
	'BbIpAddressInfo'			=> 'IP-adress eller CIDR-format adressintervall som ska vitlistas (en per rad)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL-fragment som börjar med / efter din webbplats värdnamn (en per rad)',
	'BbUserAgent'				=> 'Användarens agent',
	'BbUserAgentInfo'			=> 'Användaragentsträngar som ska vitlistas (en per rad)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Uppdaterade Bad Behaviour inställningar',
	'BbLogRequest'				=> 'HTTP-begäran för loggning',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (rekommenderas)',
	'BbLogOff'					=> 'Logg ej (rekommenderas inte)',
	'BbSecurity'				=> 'Säkerhet',
	'BbStrict'					=> 'Strikt kontroll',
	'BbStrictInfo'				=> 'blockerar mer skräppost men kan blockera vissa personer',
	'BbOffsiteForms'			=> 'Tillåt formulärinlägg från andra webbplatser',
	'BbOffsiteFormsInfo'		=> 'krävs för OpenID; ökar mottagen skräppost',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'För att använda Bad Behaviours http:BL funktioner måste du ha en %1',
	'BbHttpblKey'				=> 'http:BL åtkomstnyckel',
	'BbHttpblThreat'			=> 'Minsta hotnivå (25 rekommenderas)',
	'BbHttpblMaxage'			=> 'Maximal ålder på data (30 rekommenderas)',
	'BbReverseProxy'			=> 'Omvänd Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'Om du använder Bad Behaviour bakom en omvänd proxy, lastbalanserare, HTTP-accelerator, innehållscache eller liknande teknik, aktivera alternativet Reverse Proxy<br>' .
									'Om du har en kedja av två eller flera omvända proxies mellan din server och det offentliga Internet, du måste ange <em>alla</em> av IP-adressintervall (i CIDR-format) för alla dina proxyservrar, lastbalanserare etc. Annars kan Bad Behaviour inte avgöra kundens sanna IP-adress.<br>' .
									'Dessutom måste dina omvända proxyservrar ange IP-adressen till Internetklienten från vilken de fick begäran i ett HTTP-header. Om du inte anger ett huvud kommer %1 att användas. De flesta proxyservrar har redan stöd för X-Forwarded-For och du behöver då bara se till att den är aktiverad på dina proxyservrar. Några andra namn på sidhuvuden i vanligt bruk inkluderar %2 och %3.',
	'BbReverseProxyEnable'		=> 'Aktivera omvänd proxy',
	'BbReverseProxyHeader'		=> 'Header som innehåller Internetklienter IP-adress',
	'BbReverseProxyAddresses'	=> 'IP-adress eller CIDR-format adressintervall för dina proxyservrar (en per rad)',

];
