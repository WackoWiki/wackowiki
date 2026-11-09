<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Basis functies',
		'preferences'	=> 'Voorkeuren',
		'content'		=> 'Inhoud',
		'users'			=> 'Gebruikers',
		'maintenance'	=> 'Onderhoud',
		'messages'		=> 'Berichten',
		'extension'		=> 'Extensies',
		'database'		=> 'Database',
	],

	// Admin panel
	'AdminPanel'				=> 'Beheerderspaneel',
	'RecoveryMode'				=> 'Herstelmodus',
	'Authorization'				=> 'Autorisatie',
	'AuthorizationTip'			=> 'Voer het administratieve wachtwoord in (zorg ervoor dat cookies toegestaan zijn in uw browser).',
	'NoRecoveryPassword'		=> 'Het beheerderswachtwoord is niet opgegeven!',
	'NoRecoveryPasswordTip'		=> 'Opmerking: Het ontbreken van een administratief wachtwoord is een bedreiging voor de veiligheid! Voer je wachtwoord hash in in het configuratiebestand en voer het programma opnieuw uit.',

	'ApDevNologinBlocked'		=> 'Toegang geblokkeerd: AP_DEV_NOLOGIN is ingeschakeld in admin.php maar het verzoek kwam niet voort uit localhost (127.0.0.1, ::1, of localhost). Dit is een enige ontwikkelingsvlag en moet uitgeschakeld worden op productie. Stel <code>AP_DEV_NOLOGIN = 0</code> in admin.php om de toegang te herstellen.',
	'ApDevNologinBlockedLog'	=> '!!! SECURITY: %1 is ingeschakeld maar admin.php was toegankelijk vanaf een niet-localhost adres (%2). Het Admin paneel toegang is geblokkeerd.',

	'ErrorLoadingModule'		=> 'Fout bij het laden van beheermodule %1: bestaat niet.',

	'ApHomePage'				=> 'Home pagina',
	'ApHomePageTip'				=> 'Systeembeheer afsluiten en de startpagina openen',
	'ApLogOut'					=> 'Log uit',
	'ApLogOutTip'				=> 'Systeembeheer afsluiten en uitloggen',

	'TimeLeft'					=> 'Resterende tijd:  %1 minuten',
	'TimeLeftInfinity'			=> 'Resterende tijd:  %1 (ontwikkelaarmodus)',
	'ApVersion'					=> 'versie',

	'SiteOpen'					=> 'Open',
	'SiteOpened'				=> 'site geopend',
	'SiteOpenedTip'				=> 'De site is geopend',
	'SiteClose'					=> 'Afsluiten',
	'SiteClosed'				=> 'site gesloten',
	'SiteClosedTip'				=> 'De site is gesloten',

	'System'					=> 'Systeem',

	// Generic
	'Cancel'					=> 'Annuleren',
	'Add'						=> 'Toevoegen',
	'Edit'						=> 'Bewerk',
	'Remove'					=> 'Verwijderen',
	'Enabled'					=> 'Inschakelen',
	'Disabled'					=> 'Uitschakelen',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'Beheerder',
	'Min'						=> 'Min.',
	'Max'						=> 'Max.',

	'MiscellaneousSection'		=> 'Overige',
	'MainSection'				=> 'Algemene Opties',

	'DirNotWritable'			=> 'De %1 map is niet schrijfbaar.',
	'FileNotWritable'			=> 'Het %1 bestand is niet schrijfbaar.',

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
		'name'		=> 'Eenvoudig',
		'title'		=> 'Basic parameters',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Uiterlijk',
		'title'		=> 'Weergave instellingen',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-mailadres',
		'title'		=> 'Email instellingen',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Syndicatie',
		'title'		=> 'Syndication-instellingen',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filteren',
		'title'		=> 'Filter instellingen',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formaat',
		'title'		=> 'Opmaak opties',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Meldingen',
		'title'		=> 'Notificatie instellingen',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Pagina\'s',
		'title'		=> 'Pagina\'s en site-parameters',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permissies',
		'title'		=> 'Instellingen van machtigingen',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Beveiliging',
		'title'		=> 'Instellingen beveiligingssubsystemen',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Systeem',
		'title'		=> 'Systeem opties',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Doorgaan',
		'title'		=> 'Instellingen voor bijlagen',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Verwijderd',
		'title'		=> 'Nieuw verwijderde inhoud',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Toevoegen, bewerken of verwijderen van standaard menu-items',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Back-up',
		'title'		=> 'Gegevens back-uppen',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Herstellen',
		'title'		=> 'Repareer en Optimaliseer Database',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Herstellen',
		'title'		=> 'Back-up gegevens herstellen',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Hoofd Menu',
		'title'		=> 'WackoWiki Beheer',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inconsistenties',
		'title'		=> 'Correctie van gegevensinconsistenties',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Gegevens synchroniseren',
		'title'		=> 'Gegevens synchroniseren',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Groepsgewijs e-mail',
		'title'		=> 'Groepsgewijs e-mail',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Systeem bericht',
		'title'		=> 'Systeem berichten',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Systeem Info',
		'title'		=> 'Systeeminformatie',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Systeem log',
		'title'		=> 'Log van systeem gebeurtenissen',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistieken',
		'title'		=> 'Statistieken tonen',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Slecht gedrag',
		'title'		=> 'Slecht gedrag',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Goedkeuren',
		'title'		=> 'Gebruiker registratie goedkeuring',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Groepen',
		'title'		=> 'Groep beheer',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Gebruikers',
		'title'		=> 'Gebruikers beheren',
	],

	// Main module
	'MainNote'					=> 'Opmerking: Het is aan te raden om de toegang tot de site tijdelijk te blokkeren bij administratief onderhoud.',

	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'Alle sessies verwijderen',
	'PurgeSessionsConfirm'		=> 'Weet je zeker dat je alle sessies wilt verwijderen? Dit zal alle gebruikers uitloggen.',
	'PurgeSessionsExplain'		=> 'Alle sessies wissen. Hiermee worden alle gebruikers uitgelogd door de auth_token tabel af te breken.',
	'PurgeSessionsDone'			=> 'Sessies succesvol gewist.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Bijgewerkte basisinstellingen',
	'LogBasicSettingsUpdated'	=> 'Bijgewerkte basisinstellingen',

	'SiteName'					=> 'Website naam:',
	'SiteNameInfo'				=> 'De titel van deze site. Verschijnt op de browsertitel, thema header, e-mailnotificatie, etc.',
	'SiteDesc'					=> 'Site beschrijving:',
	'SiteDescInfo'				=> 'Aanvullend op de titel van de site die in de koptekst van de pagina\'s verschijnt, wordt in een paar woorden uitgelegd waar deze site over gaat.',
	'AdminName'					=> 'Admin van de site:',
	'AdminNameInfo'				=> 'Gebruikersnaam van de persoon die verantwoordelijk is voor de algemene ondersteuning van de site. Deze naam wordt niet gebruikt om toegangsrechten te bepalen. maar het is wenselijk dat het voldoet aan de naam van de hoofdadministrateur van de site.',

	'LanguageSection'			=> 'Taal',
	'DefaultLanguage'			=> 'Standaard taal:',
	'DefaultLanguageInfo'		=> 'Specificeert de taal van de berichten die worden weergegeven aan niet-geregistreerde gasten, evenals de lokale instellingen.',
	'MultiLanguage'				=> 'Meertalige ondersteuning:',
	'MultiLanguageInfo'			=> 'Schakel de mogelijkheid in om een taal te selecteren per pagina.',
	'AllowedLanguages'			=> 'Toegestane talen:',
	'AllowedLanguagesInfo'		=> 'Het wordt aanbevolen om alleen de set van talen te selecteren die u wilt gebruiken, anders worden alle talen geselecteerd.',

	'CommentSection'			=> 'Reacties',
	'AllowComments'				=> 'Reacties toestaan:',
	'AllowCommentsInfo'			=> 'Activeer reacties voor gasten of geregistreerde gebruikers alleen, of schakel deze uit op de hele site.',
	'SortingComments'			=> 'Reacties sorteren:',
	'SortingCommentsInfo'		=> 'Wijzigt de volgorde waarin de paginacommentaren worden gepresenteerd, ofwel met de meest recente of de oudste reactie aan de bovenkant.',
	'CommentsOffset'			=> 'Reacties pagina:',
	'CommentsOffsetInfo'		=> 'Reacties pagina om standaard te tonen',

	'ToolbarSection'			=> 'Werkbalk',
	'CommentsPanel'				=> 'Paneel opmerkingen:',
	'CommentsPanelInfo'			=> 'De standaard weergave van reacties onderaan de pagina.',
	'FilePanel'					=> 'Bestand paneel:',
	'FilePanelInfo'				=> 'De standaard weergave van bijlagen onderaan de pagina.',
	'TagsPanel'					=> 'Labels paneel:',
	'TagsPanelInfo'				=> 'De standaard weergave van het tags paneel onderaan de pagina.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Toon permalink:',
	'ShowPermalinkInfo'			=> 'De standaard weergave van de permalink voor de huidige versie van de pagina.',
	'TocPanel'					=> 'Lijst met inhoudsopgave:',
	'TocPanelInfo'				=> 'De standaard weergavetabel van het inhoudspaneel van een pagina (kan ondersteuning nodig hebben in de templates).',
	'SectionsPanel'				=> 'Secties paneel:',
	'SectionsPanelInfo'			=> 'Toon standaard het paneel van de aangrenzende pagina\'s (vereist ondersteuning in de templates).',
	'DisplayingSections'		=> 'Secties tonen:',
	'DisplayingSectionsInfo'	=> 'Als de vorige opties zijn ingesteld, alleen subpagina\'s van pagina weergeven (<em>lagere</em>), alleen buurman (<em>top</em>), allebei (<em>tree</em>).',
	'MenuItems'					=> 'Menu items:',
	'MenuItemsInfo'				=> 'Standaard aantal getoonde menu-items (kan ondersteuning nodig hebben in de templates).',

	'HandlerSection'			=> 'Handler',
	'HideRevisions'				=> 'Verbergen revisies:',
	'HideRevisionsInfo'			=> 'De standaard weergave van herzieningen van de pagina.',
	'AttachmentHandler'			=> 'Bijlagen afhandelaar inschakelen:',
	'AttachmentHandlerInfo'		=> 'Geeft een weergave van de bijlagen-afhandelaar.',
	'SourceHandler'				=> 'Inschakelen van bron handler:',
	'SourceHandlerInfo'			=> 'Geeft de weergave van de bron-handler.',
	'ExportHandler'				=> 'XML export afhandelaar inschakelen:',
	'ExportHandlerInfo'			=> 'Geeft de weergave van de XML-uitvoer-handler.',

	'DiffModeSection'			=> 'Verschil modi',
	'DefaultDiffModeSetting'	=> 'Standaard diff modus:',
	'DefaultDiffModeSettingInfo'=> 'Preselecteer diff modus.',
	'AllowedDiffMode'			=> 'Toegestane diff modi:',
	'AllowedDiffModeInfo'		=> 'Het is aanbevolen om alleen de set van de diff modi te selecteren die u wilt gebruiken, anders worden alle diff modi geselecteerd.',
	'NotifyDiffMode'			=> 'Diff-modus waarschuwen:',
	'NotifyDiffModeInfo'		=> 'Diff modus gebruikt voor meldingen in de inhoud van de e-mail.',

	'EditingSection'			=> 'Bewerken',
	'EditSummary'				=> 'Samenvatting bewerken:',
	'EditSummaryInfo'			=> 'Toont de wijziging samenvatting in de bewerkingsmodus.',
	'MinorEdit'					=> 'Kleine bewerking:',
	'MinorEditInfo'				=> 'Maakt kleine bewerkingsoptie mogelijk in de bewerkingsmodus.',
	'SectionEdit'				=> 'Sectie bewerken:',
	'SectionEditInfo'			=> 'Maakt het mogelijk alleen een sectie van een pagina te bewerken.',
	'ReviewSettings'			=> 'Beoordeling:',
	'ReviewSettingsInfo'		=> 'Toont de beoordelingsoptie in de bewerkingsmodus.',
	'PublishAnonymously'		=> 'Anonieme publicatie toestaan:',
	'PublishAnonymouslyInfo'	=> 'Sta gebruikers toe anoniem te publiceren (om de naam te verbergen).',

	'DefaultRenameRedirect'		=> 'Bij het hernoemen maak omleiding:',
	'DefaultRenameRedirectInfo'	=> 'Standaard biedt de aanbieding aan om een doorverwijzing in te stellen naar het oude adres van de pagina die wordt hernoemd.',
	'StoreDeletedPages'			=> 'Verwijderde pagina\'s behouden:',
	'StoreDeletedPagesInfo'		=> 'Wanneer u een pagina, een opmerking of een bestand verwijdert, houd het in een speciale sectie waar het beschikbaar is voor review en herstel gedurende enige tijd (zoals hieronder beschreven).',
	'KeepDeletedTime'			=> 'Opslagtijd van verwijderde pagina\'s:',
	'KeepDeletedTimeInfo'		=> 'De periode in dagen. Dat is alleen zinvol bij de vorige optie. Gebruik nul om ervoor te zorgen dat entiteiten nooit verwijderd worden (in dit geval kan de beheerder de "auto" handmatig wissen).',
	'PagesPurgeTime'			=> 'Opslag tijd van pagina herzieningen:',
	'PagesPurgeTimeInfo'		=> 'Verwijderd automatisch oudere versies binnen het opgegeven aantal dagen. Als je nul invoert, worden de oudere versies niet verwijderd.',
	'EnableReferrers'			=> 'Verwijzingen inschakelen:',
	'EnableReferrersInfo'		=> 'Verleent het aanmaken en weergeven van externe verwijzers.',
	'ReferrersPurgeTime'		=> 'Opslagtijd van verwijzingen:',
	'ReferrersPurgeTimeInfo'	=> 'Bewaar de geschiedenis van het doorverwijzen van externe pagina\'s niet langer dan een bepaald aantal dagen. Nul betekent eeuwige opslag, maar voor een actief bezochte site kan dit leiden tot een databaseoverloop.',
	'EnableCounters'			=> 'Raak Counters:',
	'EnableCountersInfo'		=> 'Maakt het tellen van hits per pagina mogelijk en maakt de weergave van eenvoudige statistieken mogelijk. Oproepen van de eigenaar van de pagina worden niet meegeteld.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Beheer de standaardinstellingen voor websyndicatie voor je site.',
	'SyndicationSettingsUpdated'	=> 'Bijgewerkte syndicatie-instellingen.',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Inschakelen feeds:',
	'EnableFeedsInfo'			=> 'Schakelt RSS-feeds in of uit voor de hele wiki.',
	'XmlChangeLink'				=> 'Wijzigingen feed link modus:',
	'XmlChangeLinkInfo'			=> 'Definieert waar de XML wijzigingen item naar linken.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'verschillen',
		'2'		=> 'de huidige pagina',
		'3'		=> 'lijst van revisies',
		'4'		=> 'de gewijzigde pagina',
	],

	'XmlSitemap'				=> 'XML Sitemap:',
	'XmlSitemapInfo'			=> 'Maakt een XML-bestand met de naam %1 in de XML-map. U kunt het pad toevoegen aan de sitemap in het robots.txt bestand in uw hoofdmap als volgt:',
	'XmlSitemapGz'				=> 'XML sitemap compressie:',
	'XmlSitemapGzInfo'			=> 'Als u wilt, kunt u de tekst van de sitemap comprimeren met behulp van gzip om uw bandbreedte te verminderen.',
	'XmlSitemapTime'			=> 'XML sitemap generatie tijd:',
	'XmlSitemapTimeInfo'		=> 'Genereert de Sitemap slechts één keer in het opgegeven aantal dagen, nul betekent op elke paginawissel.',

	'SearchSection'				=> 'Zoeken',
	'OpenSearch'				=> 'Opensearch:',
	'OpenSearchInfo'			=> 'Maakt het OpenSearch-beschrijvingsbestand aan in de XML-map en activeert Autodiscovery van de zoekplugin in de HTML-header.',
	'SearchEngineVisibility'	=> 'Blokkeer zoekmachines (zoekmachine zichtbaarheid):',
	'SearchEngineVisibilityInfo'=> 'Zoekmachines blokkeren, maar normale bezoekers toestaan. Overschrijft pagina-instellingen. <br>Ontmoedig zoekmachines bij het indexeren van deze site. Het is aan zoekmachines om dit verzoek te honoreren.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Beheer standaard weergave-instellingen voor uw site.',
	'AppearanceSettingsUpdated'	=> 'Weergave instellingen bijgewerkt.',

	'LogoOff'					=> 'Uit',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo en titel',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Site Logo:',
	'SiteLogoInfo'				=> 'Jouw logo verschijnt meestal in de linker bovenhoek van de applicatie. Maximale grootte is 2 MiB. Optimale afmetingen zijn 255 pixels breed met 55 pixels hoog.',
	'LogoDimensions'			=> 'Logo dimensies:',
	'LogoDimensionsInfo'		=> 'Breedte en hoogte van het weergegeven logo.',
	'LogoDisplayMode'			=> 'Logo weergavemodus:',
	'LogoDisplayModeInfo'		=> 'Definieert het uiterlijk van het logo. Standaard is uitgeschakeld.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site Favicon:',
	'SiteFaviconInfo'			=> 'Uw snelkoppelingspictogram of favicon, wordt weergegeven in de adresbalk, tabbladen en bladwijzers van de meeste browsers. Dit overschrijft de favicon van uw thema.',
	'SiteFaviconTooBig'			=> 'Favicon is groter dan 64 × 64px.',
	'ThemeColor'				=> 'Thema kleur voor adresbalk:',
	'ThemeColorInfo'			=> 'De browser zal de kleur van de adresbalk van elke pagina instellen volgens de opgegeven CSS kleur.',

	'LayoutSection'				=> 'Indeling',
	'Theme'						=> 'Thema:',
	'ThemeInfo'					=> 'Sjabloonontwerp dat de website standaard gebruikt',
	'ResetUserTheme'			=> 'Reset alle gebruikersthema\'s:',
	'ResetUserThemeInfo'		=> 'Reset alle gebruikersthema\'s. Waarschuwing: Deze actie zal alle door de gebruiker geselecteerde thema\'s terugzetten naar het globale standaardthema.',
	'SetBackUserTheme'			=> 'Draai alle gebruikersthema\'s terug naar %1 thema.',
	'ThemesAllowed'				=> 'Toegestane thema\'s:',
	'ThemesAllowedInfo'			=> 'Selecteer de toegestane thema\'s, die de gebruiker kan kiezen; anders zijn alle beschikbare thema\'s toegestaan.',
	'ThemesPerPage'				=> 'Thema\'s per pagina:',
	'ThemesPerPageInfo'			=> 'Sta thema\'s per pagina toe, welke de pagina-eigenaar kan kiezen via pagina-eigenschappen.',

	// System settings
	'SystemSettingsInfo'		=> 'Groep parameters die verantwoordelijk zijn voor het afstemmen van de site. Wijzig deze alleen als u vertrouwen heeft in hun acties.',
	'SystemSettingsUpdated'		=> 'Bijgewerkte systeeminstellingen',

	'DebugModeSection'			=> 'Debug Modus',
	'DebugMode'					=> 'Foutopsporing modus:',
	'DebugModeInfo'				=> 'Uitpakken en uitvoeren van telemetrie data over de uitvoeringstijd van de applicatie. Opgelet: Volledige detailmodus stelt hogere eisen aan het toegewezen geheugen, vooral voor hulpbron-intensieve operaties, zoals database-back-up en herstel.',
	'DebugModes'	=> [
		'0'		=> 'debugging is uitgeschakeld',
		'1'		=> 'alleen de totale uitvoeringstijd',
		'2'		=> 'Voltijds',
		'3'		=> 'volledige details (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Drempel prestatie RDBMS:',
	'DebugSqlThresholdInfo'		=> 'Rapporteer in gedetailleerde debug modus alleen de query\'s die langer duren dan het aantal gespecificeerde seconden.',
	'DebugAdminOnly'			=> 'Gesloten diagnose:',
	'DebugAdminOnlyInfo'		=> 'Toon debug data van het programma (en DBMS) alleen voor de beheerder.',

	'CachingSection'			=> 'Caching opties',
	'Cache'						=> 'Cache weergegeven pagina\'s:',
	'CacheInfo'					=> 'Opgeslagen pagina\'s in de lokale cache om de volgende opstart te versnellen. Alleen geldig voor ongeregistreerde bezoekers.',
	'CacheTtl'					=> 'Time-to-live voor gecachte pagina\'s:',
	'CacheTtlInfo'				=> 'Cache pagina\'s niet meer dan een aantal seconden.',
	'CacheSql'					=> 'Cache DBMS query\'s:',
	'CacheSqlInfo'				=> 'Behoud een lokale cache van de resultaten van bepaalde resource-gerelateerde SQL queries.',
	'CacheSqlTtl'				=> 'Time-to-live voor gecachte SQL-query\'s:',
	'CacheSqlTtlInfo'			=> 'Cache resultaten van SQL zoekopdrachten voor niet meer dan het opgegeven aantal seconden. Waarden groter dan 1200 zijn niet gewenst.',

	'LogSection'				=> 'Log Instellingen',
	'LogLevelUsage'				=> 'Loggen gebruiken:',
	'LogLevelUsageInfo'			=> 'De minimale prioriteit van de in de log opgenomen gebeurtenissen.',
	'LogThresholds'	=> [
		'0'		=> 'houd geen dagboek bij',
		'1'		=> 'alleen het kritieke niveau',
		'2'		=> 'van het hoogste level',
		'3'		=> 'van hoog',
		'4'		=> 'gemiddeld',
		'5'		=> 'van laag',
		'6'		=> 'het minimum niveau',
		'7'		=> 'alles opnemen',
	],
	'LogDefaultShow'			=> 'Toon logboekmodus:',
	'LogDefaultShowInfo'		=> 'De minimum prioriteit gebeurtenissen die standaard worden weergegeven in het logboek.',
	'LogModes'	=> [
		'1'		=> 'alleen het kritieke niveau',
		'2'		=> 'van het hoogste level',
		'3'		=> 'van hoog',
		'4'		=> 'het gemiddelde',
		'5'		=> 'van een laag',
		'6'		=> 'van het minimumniveau',
		'7'		=> 'alles weergeven',
	],
	'LogPurgeTime'				=> 'Opslag tijd van de log:',
	'LogPurgeTimeInfo'			=> 'Remove event log over a given number of days.',

	'PrivacySection'			=> 'Privacy',
	'AnonymizeIp'				=> 'Anonimiseer IP adressen van gebruikers:',
	'AnonymizeIpInfo'			=> 'IP-adressen waar van toepassing zijn anonimiseren (d.w.z. pagina, revisie of verwijzers).',

	'ReverseProxySection'		=> 'Omgekeerde Proxy',
	'ReverseProxy'				=> 'Omgekeerde proxy gebruiken:',
	'ReverseProxyInfo'			=> 'Schakel deze instelling in om het juiste IP adres van de remote client te bepalen door
									de informatie opgeslagen in de X-Forwarded-For headers te onderzoeken. X-Forwarded-For headers
									zijn een standaardmechanisme om cliëntsystemen te identificeren die verbinding maken via een
									reverse proxyserver, zoals Squid of Pound. Reverse proxy servers worden vaak gebruikt om de prestatie
									van druk bezochte sites te verbeteren en kunnen ook andere site caching, beveiliging of encryptie
									voordelen bieden. Als deze WackoWiki installatie achter een reverse proxy opereert, zou deze instelling
									aangezet moeten worden zodat correcte IP adres informatie wordt vastgelegd in WackoWiki\'s
									sessie management, logging, statistieken en toegangsmanagement systemen; als u niet zeker bent
									over deze instelling, geen reverse proxy heeft, of WackoWiki opereert in een gedeelde hosting omgeving,
									zou deze instelling uitgeschakeld moeten blijven.',
	'ReverseProxyHeader'		=> 'Reverse proxy header:',
	'ReverseProxyHeaderInfo'	=> 'Stel deze waarde in als je proxyserver het IP van de client in een andere
									header dan X-Forwarded-For stuurt. De "X-Forwarded-For" header is een komma+spatie
									gescheiden lijst van IP adressen, alleen het laatste (het meest linkse) zal worden gebruikt.',
	'ReverseProxyAddresses'		=> 'reverse_proxy accepteert een reeks IP-adressen:',
	'ReverseProxyAddressesInfo'	=> 'Elk element van deze array is het IP-adres van een van je reverse
									 proxies. Als je deze array gebruikt, zal WackoWiki de informatie die is opgeslagen
									 in de X-Forwarded-For headers alleen als het Remote IP adres een van deze is.
									 is, dat wil zeggen dat het verzoek de webserver bereikt vanaf een van uw
									 reverse proxies. Anders kan de client direct verbinding maken met
									 uw webserver door de X-Forwarded-For headers te spoofen.',

	'SessionSection'				=> 'Sessie Handling',
	'SessionStorage'				=> 'Sessie opslag:',
	'SessionStorageInfo'			=> 'Deze optie definieert waar de sessie data is opgeslagen. Standaard is er een bestand of database sessie opslag geselecteerd.',
	'SessionModes'	=> [
		'1'		=> 'Bestand',
		'2'		=> 'Database',
	],
	'SessionNotice'					=> 'Toon sessie beëindiging oorzaak:',
	'SessionNoticeInfo'				=> 'Geeft de oorzaak van de sessiebeëindiging aan.',
	'LoginNotice'					=> 'Aanmeldingsbericht:',
	'LoginNoticeInfo'				=> 'Geeft een aanmeldingsbericht weer.',

	'RewriteMode'					=> 'Gebruik <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Als uw webserver deze functie ondersteunt, schakel deze dan in om de pagina-URL\'s te "verfraaien".<br>
										<span class="cite">De waarde kan worden overschreven door de Instellingen klasse tijdens runtime, ongeacht of deze is uitgeschakeld, als HTTP_MOD_REWRITE is ingeschakeld.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parameters die verantwoordelijk zijn voor toegangsbeheer en rechten.',
	'PermissionsSettingsUpdated'	=> 'Permissie-instellingen bijgewerkt',

	'PermissionsSection'		=> 'Rechten en Privileges',
	'ReadRights'				=> 'Lezen van rechten standaard:',
	'ReadRightsInfo'			=> 'Standaard toegewezen aan de gemaakte root pagina\'s, evenals pagina\'s waarvoor bovenliggende ACLs niet kunnen worden gedefinieerd.',
	'WriteRights'				=> 'Schrijf standaard rechten:',
	'WriteRightsInfo'			=> 'Standaard toegewezen aan de gemaakte root pagina\'s, evenals pagina\'s waarvoor bovenliggende ACLs niet kunnen worden gedefinieerd.',
	'CommentRights'				=> 'Reactie standaard rechten:',
	'CommentRightsInfo'			=> 'Standaard toegewezen aan de gemaakte root pagina\'s, evenals pagina\'s waarvoor bovenliggende ACLs niet kunnen worden gedefinieerd.',
	'CreateRights'				=> 'Maak standaard de rechten van een subpagina aan:',
	'CreateRightsInfo'			=> 'Standaard toegewezen aan de gemaakte subpagina\'s.',
	'UploadRights'				=> 'Standaard uploadrechten:',
	'UploadRightsInfo'			=> 'Standaard uploadrechten.',
	'RenameRights'				=> 'Wereldwijde hernoem rechts',
	'RenameRightsInfo'			=> 'De lijst met rechten om gratis (beweeg) pagina\'s te hernoemen.',

	'LockAcl'					=> 'Vergrendel alle ACL\'s om alleen te lezen:',
	'LockAclInfo'				=> '<span class="cite">Overschrijft de ACL instellingen zodat alle pagina\'s alleen kunnen lezen.</span><br>Dit kan handig zijn als een project is voltooid, u wilt dicht bewerken voor een periode om veiligheidsredenen, of als een noodreactie op een exploitatie of kwetsbaarheid.',
	'HideLocked'				=> 'Verberg ontoegankelijke pagina\'s:',
	'HideLockedInfo'			=> 'Als de gebruiker geen toestemming heeft om de pagina te lezen. verberg het in verschillende paginalijsten (maar de link in de tekst zal nog steeds zichtbaar zijn).',
	'RemoveOnlyAdmins'			=> 'Alleen beheerders kunnen pagina\'s verwijderen:',
	'RemoveOnlyAdminsInfo'		=> 'Wijs alles, behalve beheerders, de mogelijkheid om pagina\'s te verwijderen. Het eerste limiet geldt voor eigenaren van normale pagina\'s.',
	'OwnersRemoveComments'		=> 'Eigenaren van pagina\'s kunnen reacties verwijderen:',
	'OwnersRemoveCommentsInfo'	=> 'Pagina-eigenaars toestaan om commentaren op hun pagina\'s te modereren.',
	'OwnersEditCategories'		=> 'Eigenaren kunnen pagina categorieën bewerken:',
	'OwnersEditCategoriesInfo'	=> 'Eigenaren kunnen de paginalijst van uw website wijzigen (woorden toevoegen, woorden verwijderen), toewijzen aan een pagina.',
	'TermHumanModeration'		=> 'Menselijke moderatie vervaldatum:',
	'TermHumanModerationInfo'	=> 'Moderators kunnen alleen commentaar bewerken als het niet meer dan dit aantal dagen geleden is aangemaakt (deze beperking is niet van toepassing op het laatste commentaar in het onderwerp).',

	'UserCanDeleteAccount'		=> 'Gebruikers kunnen hun accounts verwijderen',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parameters die verantwoordelijk zijn voor de algemene veiligheid van het platform, veiligheidsbeperkingen en extra veiligheidssubsystemen.',
	'SecuritySettingsUpdated'	=> 'Bijgewerkte beveiligingsinstellingen',

	'AllowRegistration'			=> 'Online registreren:',
	'AllowRegistrationInfo'		=> 'Open gebruikersregistratie. Het uitschakelen van deze optie voorkomt gratis registratie, maar de beheerder van de site kan wel zelf andere gebruikers registreren.',
	'ApproveNewUser'			=> 'Goedkeuren van nieuwe gebruikers:',
	'ApproveNewUserInfo'		=> 'Laat beheerders toe om gebruikers goed te keuren zodra ze registreren. Alleen goedgekeurde gebruikers kunnen inloggen op de site.',
	'PersistentCookies'			=> 'Persisterende cookies:',
	'PersistentCookiesInfo'		=> 'Sta aanhoudende koekjes toe.',
	'DisableWikiName'			=> 'WikiName uitschakelen:',
	'DisableWikiNameInfo'		=> 'Schakel het verplichte gebruik van een WikiName voor gebruikers uit. Geeft gebruikersregistratie met traditionele nicknames in plaats van geforceerde CamelCase-geformatteerde namen (bijv. Naamfamilienaam).',
	'UsernameLength'			=> 'Gebruikersnaam lengte:',
	'UsernameLengthInfo'		=> 'Minimum en maximaal aantal tekens in gebruikersnamen.',

	'EmailSection'				=> 'E-mailadres',
	'AllowEmailReuse'			=> 'Hergebruik van e-mailadres toestaan:',
	'AllowEmailReuseInfo'		=> 'Verschillende gebruikers kunnen zich registreren met hetzelfde e-mailadres.',
	'EmailConfirmation'			=> 'Bevestiging per e-mail afdwingen:',
	'EmailConfirmationInfo'		=> 'Vereist dat de gebruiker zijn e-mailadres verifieert voordat hij kan inloggen.',
	'AllowedEmailDomains'		=> 'Toegestane e-maildomeinen:',
	'AllowedEmailDomainsInfo'	=> 'Toegestane e-maildomeinen, gescheiden door komma\'s, bijv. <code>example.com, local.lan</code> etc., anders zijn alle e-maildomeinen toegestaan.',
	'ForbiddenEmailDomains'		=> 'Verboden e-maildomeinen:',
	'ForbiddenEmailDomainsInfo'	=> 'Verboden e-maildomeinen, gescheiden door komma\'s, bijv. <code>example.com, local.lan</code> enz. (alleen effectief als lijst met toegestane e-maildomeinen leeg is)',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Activeer captcha:',
	'EnableCaptchaInfo'			=> 'Indien ingeschakeld, zal captcha worden getoond in de volgende gevallen of als een beveiligingsdrempel is bereikt.',
	'CaptchaComment'			=> 'Nieuwe reactie:',
	'CaptchaCommentInfo'		=> 'Als bescherming tegen spam moeten niet-geregistreerde gebruikers de captcha voltooien voordat er een reactie wordt geplaatst.',
	'CaptchaPage'				=> 'Nieuwe pagina',
	'CaptchaPageInfo'			=> 'Als bescherming tegen spam moeten niet-geregistreerde gebruikers captcha voltooien voordat ze een nieuwe pagina maken.',
	'CaptchaEdit'				=> 'Pagina bewerken:',
	'CaptchaEditInfo'			=> 'Als bescherming tegen spam moeten niet-geregistreerde gebruikers captcha voltooien voordat ze pagina\'s bewerken.',
	'CaptchaRegistration'		=> 'Registratie:',
	'CaptchaRegistrationInfo'	=> 'Als bescherming tegen spam moeten niet-geregistreerde gebruikers captcha voltooien voordat ze registreren.',

	'TlsSection'				=> 'TLS instellingen',
	'TlsConnection'				=> 'TLS-verbinding:',
	'TlsConnectionInfo'			=> 'Gebruik TLS-beveiligde verbinding. <span class="cite">Activeer het vooraf geïnstalleerde TLS-certificaat op de server, anders verliest u toegang tot het beheerpaneel!</span><br>Het bepaalt ook of de Cookie Secure Vlag is ingesteld: de <code>veilige</code> vlag geeft aan of cookies alleen via beveiligde verbindingen verzonden moeten worden.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Verbind de client gedwongen opnieuw van HTTP naar HTTPS. Met de optie uitgeschakeld, kan de client de site bladeren via een open HTTP-kanaal.',

	'HttpSecurityHeaders'		=> 'HTTP Beveiligingsheaders',
	'EnableSecurityHeaders'		=> 'Enable security headers:',
	'EnableSecurityHeadersinfo'	=> 'Beveiligingsheaders instellen (frame busting, klikjacking/XSS/CSRF bescherming). <br>CSP kan in bepaalde situaties problemen veroorzaken (bijv. tijdens ontwikkeling), of wanneer je plugins gebruikt die vertrouwen op externe gehoste bronnen zoals afbeeldingen of scripts. <br>Het uitschakelen van het inhoudsveiligheidsbeleid is een veiligheidsrisico!',
	'Csp'						=> 'Content-Security-Policy (CSP):',
	'CspInfo'					=> 'Het configureren van CSP houdt in dat je beslist welk beleid je wilt afdwingen, en deze vervolgens configureert en gebruik maakt van Content-Security-Policy om je beleid vast te stellen.',
	'PolicyModes'	=> [
		'0'		=> 'uitgeschakeld',
		'1'		=> 'strikt',
		'2'		=> 'Aangepast',
	],
	'PermissionsPolicy'			=> 'Permissions Policy:',
	'PermissionsPolicyInfo'		=> 'De HTTP Permissions-Policy header biedt een mechanisme om verschillende krachtige browserfuncties expliciet in of uit te schakelen.',
	'ReferrerPolicy'			=> 'Referrer Policy:',
	'ReferrerPolicyInfo'		=> 'De HTTP-header Referrer-Policy header regelt welke verwijst naar informatie, verzonden in de Referer-header, moet worden opgenomen in reacties.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-oorsprong',
		'4'		=> 'herkomst',
		'5'		=> 'strikte oorsprong',
		'6'		=> 'origineel-when-cross-origin',
		'7'		=> 'strikt-origineel-when-cross-origin',
		'8'		=> 'onveilige URL'
	],

	'UserPasswordSection'		=> 'Persistentie van gebruikerswachtwoorden',
	'PwdMinChars'				=> 'Minimale lengte wachtwoord:',
	'PwdMinCharsInfo'			=> 'Langere wachtwoorden zijn noodzakelijkerwijs veiliger dan kortere wachtwoorden (bijvoorbeeld 12 tot 16 tekens).<br>Het gebruik van wachtwoorden in plaats van wachtwoorden wordt aangemoedigd.',
	'AdminPwdMinChars'			=> 'Minimale lengte wachtwoord admin:',
	'AdminPwdMinCharsInfo'		=> 'Langere wachtwoorden zijn noodzakelijkerwijs veiliger dan kortere wachtwoorden (bijvoorbeeld 15 tot 20 tekens).<br>Het gebruik van wachtwoorden in plaats van wachtwoorden wordt aangemoedigd.',
	'PwdCharComplexity'			=> 'Het vereiste wachtwoord complexiteit:',
	'PwdCharClasses'	=> [
		'0'		=> 'niet getest',
		'1'		=> 'alle letters + cijfers',
		'2'		=> 'hoofdletters en kleine letters + nummers',
		'3'		=> 'hoofdletters en kleine letters + cijfers + tekens',
	],
	'PwdUnlikeLogin'			=> 'Aanvullende complicatie:',
	'PwdUnlikes'	=> [
		'0'		=> 'niet getest',
		'1'		=> 'wachtwoord is niet identiek aan de login',
		'2'		=> 'wachtwoord bevat geen gebruikersnaam',
	],

	'LoginSection'				=> 'Inloggen',
	'MaxLoginAttempts'			=> 'Maximum aantal inlogpogingen per gebruikersnaam:',
	'MaxLoginAttemptsInfo'		=> 'Het aantal inlogpogingen toegestaan voor een enkel account voordat de anti-spambot taak wordt geactiveerd. Vul 0 in om te voorkomen dat de anti-spambot taak wordt geactiveerd voor verschillende gebruikersaccounts.',
	'IpLoginLimitMax'			=> 'Maximum aantal inlogpogingen per IP-adres:',
	'IpLoginLimitMaxInfo'		=> 'De drempel van inlogpogingen toegestaan van een enkel IP-adres voordat een anti-spambot taak wordt geactiveerd. Vul 0 in om te voorkomen dat de anti-spambot taak wordt geactiveerd door IP-adressen.',

	'FormsSection'				=> 'Formulieren',
	'FormTokenTime'				=> 'Maximale tijd om formulieren in te dienen:',
	'FormTokenTimeInfo'			=> 'De tijd die een gebruiker heeft om een formulier in te dienen (in seconden).<br> Merk op dat een formulier ongeldig kan worden als de sessie afloopt, ongeacht deze instelling.',

	'SessionLength'				=> 'Term login cookie:',
	'SessionLengthInfo'			=> 'De levensduur van de gebruikerssessie cookie standaard (in dagen).',
	'CommentDelay'				=> 'Anti-overstroming voor opmerkingen:',
	'CommentDelayInfo'			=> 'De minimale vertraging tussen de publicatie van opmerkingen van nieuwe gebruikers (in seconden).',
	'IntercomDelay'				=> 'Anti-overstroming voor persoonlijke communicatie:',
	'IntercomDelayInfo'			=> 'De minimale vertraging tussen het verzenden van privéberichten (in seconden).',
	'RegistrationDelay'			=> 'Tijddrempel voor registratie:',
	'RegistrationDelayInfo'		=> 'De minimale tijdgrens tussen inzendingen registratieformulier om registratiebots te ontmoedigen (in seconden).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Groep parameters die verantwoordelijk zijn voor het afstemmen van de site. Wijzig deze alleen als u vertrouwen heeft in hun acties.',
	'FormatterSettingsUpdated'	=> 'Bijgewerkte opmaak instellingen',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> 'Typografische proeflezer:',
	'TypograficaInfo'			=> 'Het uitschakelen van deze optie zal het proces van het toevoegen van reacties en het opslaan van pagina\'s versnellen.',
	'Paragrafica'				=> 'Paragrafica markeringen:',
	'ParagraficaInfo'			=> 'Vergelijkbaar met de vorige optie, maar zal leiden tot het verbreken van de onwerkbare automatische inhoudsopgave (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Globale HTML ondersteuning:',
	'AllowRawhtmlInfo'			=> 'Deze optie is mogelijk onveilig voor een open site.',
	'SafeHtml'					=> 'HTML filteren:',
	'SafeHtmlInfo'				=> 'Voorkomt het opslaan van gevaarlijke HTML-objecten. Het uitschakelen van het filter op een open site met HTML-ondersteuning is <span class="underline">extreem</span> onwenselijk!',

	'WackoFormatterSection'		=> 'Wiki tekstvormgeving (Wacko Formatter)',
	'X11colors'					=> 'X11 kleuren gebruik:',
	'X11colorsInfo'				=> 'Breidt de beschikbare kleuren voor <code>??(color) achtergrond uit??</code> en <code>!! (color) tekst!!</code>Uitschakelen van deze optie versnelt het proces van het toevoegen van reacties en het opslaan van pagina\'s.',
	'WikiLinks'					=> 'Wiki links uitschakelen:',
	'WikiLinksInfo'				=> 'Schakelt het linken van <code>CamelCaseWords</code>uit: Uw CamelCase woorden worden niet langer rechtstreeks aan een nieuwe pagina gekoppeld. Dit is handig wanneer je werkt met verschillende namespaces/clusters. Standaard is het uit.',
	'BracketsLinks'				=> 'Bracketed links uitschakelen:',
	'BracketsLinksInfo'			=> 'Schakelt <code>[[link]]</code> en <code>((link)) syntax.</code>.',
	'Formatters'				=> 'Formatters uitschakelen:',
	'FormattersInfo'			=> 'Schakelt <code>%%code%%</code> syntax uit, gebruikt voor highlighters.',

	'DateFormatsSection'		=> 'Datum Formaten',
	'DateFormat'				=> 'Het formaat van de datum:',
	'DateFormatInfo'			=> '(dag, maand, jaar)',
	'TimeFormat'				=> 'De indeling van de tijd:',
	'TimeFormatInfo'			=> '(uur, minuut)',
	'TimeFormatSeconds'			=> 'De indeling van de exacte tijd:',
	'TimeFormatSecondsInfo'		=> '(uren, minuten, seconden)',
	'NameDateMacro'				=> 'Het formaat van de <code>::@::</code> macro:',
	'NameDateMacroInfo'			=> '(naam, tijd), bijv. <code>Gebruikersnaam (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Tijdszone:',
	'TimezoneInfo'				=> 'Tijdzone te gebruiken voor het tonen van tijden aan gebruikers die niet zijn ingelogd (gasten). Aangemelde gebruikers kunnen hun tijdzone instellen en wijzigen in hun gebruikersinstellingen.',
	'AmericanDate'					=> 'Amerikaanse datum:',
	'AmericanDateInfo'				=> 'Gebruikt americaanse datumnotatie als standaard voor Engels.',

	'Canonical'					=> 'Herleid URL\'s tot hun basisvorm:',
	'CanonicalInfo'				=> 'Alle links worden als absolute URL\'s aangemaakt in de vorm %1. URL\'s ten opzichte van de server root in de vorm %2 verdienen de voorkeur.',
	'LinkTarget'				=> 'Waar externe links openen:',
	'LinkTargetInfo'			=> 'Opent elke externe link in een nieuw browservenster. Voegt <code>target="_blank"</code> toe aan de syntaxis van de link.',
	'Noreferrer'				=> 'noter:',
	'NoreferrerInfo'			=> 'Vereist dat de browser geen HTTP-referentiekop stuurt als de gebruiker de hyperlink volgt. Voegt <code>rel="noreferrer"</code> toe aan de syntaxis van de link.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Instrueer sommige zoekmachines dat de hyperlink geen invloed mag hebben op de ranking van het doel van de link in de index van de zoekmachines. Voegt <code>rel="nofollow"</code> toe aan de syntaxis van de link.',
	'UrlsUnderscores'			=> 'Formulieradressen (URL\'s) met onderstrepingstekens:',
	'UrlsUnderscoresInfo'		=> 'Bijvoorbeeld, %1 becames %2 met deze optie.',
	'ShowSpaces'				=> 'Toon spaties in WikiNames:',
	'ShowSpacesInfo'			=> 'Toon spaties in WikiNamen, bijv. <code>MyName</code> die worden weergegeven als <code>Mijn Naam</code> met deze optie.',
	'NumerateLinks'				=> 'Links opsommen in afdrukweergave:',
	'NumerateLinksInfo'			=> 'Geeft een opsomming van alle links aan de onderkant van de printweergave met deze optie.',
	'YouareHereText'			=> 'Schakel zelfverwijzingen uit en visualiseer links:',
	'YouareHereTextInfo'		=> 'Visualiseer links naar dezelfde pagina, door <code>&lt;b&gt;####&lt;/b&gt;</code>te gebruiken. Alle links naar zelf-link-opmaak verliezen, maar worden weergegeven als vetgedrukte tekst.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Hier kunt u de systeembasispagina\'s die binnen de Wiki worden gebruikt, instellen of wijzigen. Vergeet niet om de overeenkomstige pagina\'s in de Wiki aan te maken of te wijzigen volgens uw instellingen hier.',
	'PagesSettingsUpdated'		=> 'Bijgewerkte basispagina\'s',

	'ListCount'					=> 'Aantal items per lijst:',
	'ListCountInfo'				=> 'Aantal items dat wordt weergegeven op elke lijst voor gast of als standaardwaarde voor nieuwe gebruikers.',

	'ForumSection'				=> 'Opties Forum',
	'ForumCluster'				=> 'Cluster Forum:',
	'ForumClusterInfo'			=> 'Root cluster voor de forum sectie (actie %1).',
	'ForumTopics'				=> 'Aantal topics per pagina:',
	'ForumTopicsInfo'			=> 'Aantal onderwerpen dat wordt weergegeven op elke pagina van de lijst in de forum secties (actie %1).',
	'CommentsCount'				=> 'Aantal reacties per pagina:',
	'CommentsCountInfo'			=> 'Aantal weergegeven reacties op elke paginalijst met commentaren. Dit geldt voor alle reacties op de site, niet alleen de reacties die op het forum geplaatst zijn.',

	'NewsSection'				=> 'Sectie nieuws',
	'NewsCluster'				=> 'Cluster voor het nieuws:',
	'NewsClusterInfo'			=> 'Root cluster voor nieuws sectie (actie %1).',
	'NewsStructure'				=> 'Nieuwscluster structuur:',
	'NewsStructureInfo'			=> 'Bewaart de artikelen optioneel in sub-clusters per jaar/maand of week (bijv. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licentie',
	'DefaultLicense'			=> 'Standaard licentie:',
	'DefaultLicenseInfo'		=> 'Onder welke welke licentie de inhoud kan worden vrijgegeven.',
	'EnableLicense'				=> 'Activeer licentie:',
	'EnableLicenseInfo'			=> 'Inschakelen om licentie-informatie te tonen.',
	'LicensePerPage'			=> 'Licentie per pagina:',
	'LicensePerPageInfo'		=> 'Sta licentie per pagina toe, welke de pagina-eigenaar kan kiezen via pagina-eigenschappen.',

	'ServicePagesSection'		=> 'Service pagina\'s',
	'RootPage'					=> 'Thuis pagina:',
	'RootPageInfo'				=> 'Tag van uw hoofdpagina wordt automatisch geopend wanneer een gebruiker uw site bezoekt.',

	'PrivacyPage'				=> 'Privacybeleid:',
	'PrivacyPageInfo'			=> 'De pagina met het Privacybeleid van de site.',

	'TermsPage'					=> 'Beleid en reguleringen:',
	'TermsPageInfo'				=> 'De pagina met de regels van de site.',

	'SearchPage'				=> 'Zoeken:',
	'SearchPageInfo'			=> 'Pagina met het zoekformulier (actie %1).',
	'RegistrationPage'			=> 'Registratie:',
	'RegistrationPageInfo'		=> 'Pagina voor nieuwe gebruikersregistratie (actie %1).',
	'LoginPage'					=> 'Gebruiker inlog:',
	'LoginPageInfo'				=> 'Inlogpagina op de website (actie %1).',
	'SettingsPage'				=> 'Gebruikersinstellingen:',
	'SettingsPageInfo'			=> 'Pagina om het gebruikersprofiel aan te passen (actie %1).',
	'PasswordPage'				=> 'Wachtwoord wijzigen:',
	'PasswordPageInfo'			=> 'Pagina met een formulier om het wachtwoord van de gebruiker te wijzigen / query (actie %1).',
	'UsersPage'					=> 'Gebruikers lijst:',
	'UsersPageInfo'				=> 'Pagina met een lijst van geregistreerde gebruikers (actie %1).',
	'CategoryPage'				=> 'Categorie:',
	'CategoryPageInfo'			=> 'Pagina met een lijst van gecategoriseerde pagina\'s (actie %1).',
	'GroupsPage'				=> 'Groepen:',
	'GroupsPageInfo'			=> 'Pagina met een lijst van werkgroepen (actie %1).',
	'WhatsNewPage'				=> 'Wat is nieuw:',
	'WhatsNewPageInfo'			=> 'Pagina met een lijst met alle nieuwe, verwijderde of gewijzigde pagina\'s, nieuwe bijlagen en reacties. (actie %1).',
	'ChangesPage'				=> 'Recente wijzigingen:',
	'ChangesPageInfo'			=> 'Pagina met een lijst van de laatst gewijzigde pagina\'s (actie %1).',
	'CommentsPage'				=> 'Recente reacties:',
	'CommentsPageInfo'			=> 'Pagina met een lijst van recente reacties op de pagina (actie %1).',
	'RemovalsPage'				=> 'Pagina verwijderd:',
	'RemovalsPageInfo'			=> 'Pagina met een lijst van onlangs verwijderde pagina\'s (actie %1).',
	'WantedPage'				=> 'Gezochte pagina\'s:',
	'WantedPageInfo'			=> 'Pagina met een lijst van ontbrekende pagina\'s waarnaar verwezen wordt (actie %1).',
	'OrphanedPage'				=> 'Versierde pagina\'s:',
	'OrphanedPageInfo'			=> 'Pagina met een lijst van bestaande pagina\'s zijn niet gerelateerd via links naar een andere pagina (actie %1).',
	'SandboxPage'				=> 'Sandbox:',
	'SandboxPageInfo'			=> 'Pagina waar gebruikers hun wiki-opmaak vaardigheden kunnen oefenen.',
	'HelpPage'					=> 'Hulp:',
	'HelpPageInfo'				=> 'De sectie documentatie voor het werken met site tools.',
	'IndexPage'					=> 'Index:',
	'IndexPageInfo'				=> 'Pagina met een lijst van alle pagina\'s (action %1).',
	'RandomPage'				=> 'Willekeurig:',
	'RandomPageInfo'			=> 'Laadt een willekeurige pagina  (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameters voor meldingen van het platform.',
	'NotificationSettingsUpdated'	=> 'Bijgewerkte meldingsinstellingen',

	'EmailNotification'			=> 'E-mail notificatie:',
	'EmailNotificationInfo'		=> 'Sta e-mailmeldingen toe. Stel in om e-mailmeldingen in te schakelen, uitgeschakeld om deze te deactiveren. Merk op dat het uitschakelen van e-mailnotificaties geen effect heeft op e-mails gegenereerd als onderdeel van het aanmeldingsproces van de gebruiker.',
	'Autosubscribe'				=> 'Autosubscribe:',
	'AutosubscribeInfo'			=> 'Automatisch de eigenaar op de hoogte brengen van wijzigingen van de pagina.',

	'NotificationSection'		=> 'Standaard gebruikersmeldingen instellingen',
	'NotifyPageEdit'			=> 'Bewerk pagina notificatie:',
	'NotifyPageEditInfo'		=> 'In afwachting - Stuur alleen een e-mailmelding voor de eerste wijziging totdat de gebruiker de pagina opnieuw bezoekt.',
	'NotifyMinorEdit'			=> 'Melding bij kleine bewerking:',
	'NotifyMinorEditInfo'		=> 'Verstuurt meldingen ook voor kleine bewerkingen.',
	'NotifyNewComment'			=> 'Notificeer nieuwe reactie:',
	'NotifyNewCommentInfo'		=> 'In afwachting - Stuur alleen een e-mailmelding voor de eerste reactie, totdat de gebruiker de pagina opnieuw bezoekt.',

	'NotifyUserAccount'			=> 'Waarschuw nieuwe gebruikersaccount:',
	'NotifyUserAccountInfo'		=> 'De Admin zal een melding krijgen wanneer een nieuwe gebruiker is aangemaakt met behulp van het aanmeldformulier.',
	'NotifyUpload'				=> 'Melden bestand upload:',
	'NotifyUploadInfo'			=> 'De Moderators zullen een melding krijgen wanneer een bestand is geüpload.',

	'PersonalMessagesSection'	=> 'Persoonlijke berichten',
	'AllowIntercomDefault'		=> 'Intercom toestaan:',
	'AllowIntercomDefaultInfo'	=> 'Door deze optie in te schakelen, kunnen andere gebruikers persoonlijke berichten verzenden naar het e-mailadres van de ontvanger zonder het adres te onthullen.',
	'AllowMassemailDefault'		=> 'Massa-e-mail toestaan:',
	'AllowMassemailDefaultInfo'	=> 'Stuur alleen berichten naar gebruikers die beheerders toestemming hebben gegeven om informatie te e-mailen.',

	// Resync settings
	'Synchronize'				=> 'synchroniseren',
	'UserStatsSynched'			=> 'Gebruikersstatistieken gesynchroniseerd.',
	'PageStatsSynched'			=> 'Pagina statistieken gesynchroniseerd.',
	'FeedsUpdated'				=> 'RSS-feeds bijgewerkt.',
	'SiteMapCreated'			=> 'De nieuwe versie van de sitemap is succesvol gemaakt.',
	'ParseNextBatch'			=> 'Volgende batch van pagina\'s parsen:',
	'WikiLinksRestored'			=> 'Wiki-links hersteld.',

	'LogUserStatsSynched'		=> 'Gesynchroniseerde gebruikersstatistieken',
	'LogPageStatsSynched'		=> 'Gesynchroniseerde pagina statistieken',
	'LogFeedsUpdated'			=> 'Gesynchroniseerde RSS feeds',
	'LogPageBodySynched'		=> 'Reparsed page body and links',

	'UserStats'					=> 'Gebruikers statistieken',
	'UserStatsInfo'				=> 'Gebruikersstatistieken (aantal opmerkingen, eigen pagina\'s, herzieningen en bestanden) kunnen in sommige situaties afwijken van de werkelijke gegevens. <br>Deze bewerking staat het bijwerken van statistieken toe die overeenkomen met de werkelijke gegevens uit de database.',
	'PageStats'					=> 'Pagina statistieken',
	'PageStatsInfo'				=> 'Pagina statistieken (aantal opmerkingen, bestanden en herzieningen) kunnen in sommige situaties afwijken van de werkelijke gegevens. <br>Deze bewerking staat het bijwerken van statistieken toe die overeenkomen met de werkelijke gegevens uit de database.',

	'AttachmentsInfo'			=> 'Werkt de hash van alle bijlagen in de database bij.',
	'AttachmentsSynched'		=> 'Alle bestandsbijlagen opnieuw gehasht',
	'LogAttachmentsSynched'		=> 'Alle bestandsbijlagen opnieuw gehasht',

	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'In het geval van direct bewerken van pagina\'s in de database is het mogelijk dat de inhoud van RSS-feeds de gemaakte wijzigingen niet weerspiegelt. <br>Deze functie synchroniseert de RSS-zenders met de huidige status van de database.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'Deze functie synchroniseert de XML-Sitemap met de huidige status van de database.',
	'XmlSiteMapPeriod'			=> 'Periode %1 dagen. Laatst geschreven %2.',
	'XmlSiteMapView'			=> 'Sitemap in nieuw venster weergeven.',

	'ReparseBody'				=> 'Alle pagina\'s opnieuw verwerken',
	'ReparseBodyInfo'			=> 'Leegt <code>body_r</code> in pagina tabel, zodat elke pagina opnieuw wordt weergegeven op de volgende pagina weergave. Dit kan handig zijn als u de opmaakcode wijzigt of het domein van uw wiki wijzigt.',
	'PreparsedBodyPurged'		=> 'Leegte <code>body_r</code> veld in pagina tabel.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Voert een re-rendering uit voor alle intrasite links en herstelt de inhoud van de <code>page_link</code> en <code>file_link</code> tabellen in geval van schade of verplaatsing (dit kan aanzienlijke tijd duren).',
	'RecompilePage'				=> 'Alle pagina\'s opnieuw compileren (extreem duur)',
	'ResyncOptions'				=> 'Toegevoegde opties',
	'RecompilePageLimit'		=> 'Aantal pagina\'s om tegelijk te parsen.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Deze informatie wordt gebruikt wanneer het site e-mails verstuurt naar je gebruikers. Zorg er voor dat het e-mailadres dat je specificeert geldig is, elk bericht dat niet verstuurd kan worden zal waarschijnlijk hier naar toe verstuurd worden. Als je host geen (PHP gebaseerde) e-mailservice aanbied, dan kan je berichten versturen door gebruik te maken van SMTP. Dit vereist het adres van een server (vraag je provider indien nodig). Als de server authenticatie vereist is (en alleen als het vereist wordt), voer dan de benodigde gebruikersnaam, wachtwoord en authenticatiemethode in.',

	'EmailSettingsUpdated'		=> 'Bijgewerkte e-mailinstellingen',

	'EmailFunctionName'			=> 'E-mailfunctie-naam:',
	'EmailFunctionNameInfo'		=> 'De e-mailfunctie gebruikt om e-mails te versturen via PHP.',
	'UseSmtpInfo'				=> 'Selecteer <code>SMTP</code> als je e-mail wilt versturen via een genoemde server in plaats van de lokale e-mailfunctie.',

	'EnableEmail'				=> 'E-mails inschakelen:',
	'EnableEmailInfo'			=> 'E-mails inschakelen',

	'EmailIdentitySettings'		=> 'Website E-mails Identiteit',
	'FromEmailName'				=> 'From Name:',
	'FromEmailNameInfo'			=> 'De afzendernaam die wordt gebruikt voor de <code>From:</code> header voor alle e-mailnotificaties die van de site worden verzonden.',
	'EmailSubjectPrefix'		=> 'Onderwerp Voorvoegsel:',
	'EmailSubjectPrefixInfo'	=> 'Alternatief e-mailonderwerpvoorvoegsel, bijv. <code>[Voorvoegsel] Onderwerp</code>. Als dit niet is gedefinieerd, is het standaardvoorvoegsel sitenaam: %1.',

	'NoReplyEmail'				=> 'Geen antwoord adres:',
	'NoReplyEmailInfo'			=> 'Dit adres, bijvoorbeeld <code>noreply@example.com</code>, zal verschijnen in de <code>From:</code> email adres veld van alle e-mail notificaties verzonden van de site.',
	'AdminEmail'				=> 'E-mail van de eigenaar van de website:',
	'AdminEmailInfo'			=> 'Dit adres wordt gebruikt voor admin doeleinden, zoals nieuwe gebruikersmelding.',
	'AbuseEmail'				=> 'Service voor e-mailmisbruik:',
	'AbuseEmailInfo'			=> 'Adresverzoeken voor urgente kwesties: registratie voor een buitenlandse e-mail, etc. Het kan hetzelfde zijn als de website eigenaar e-mail.',

	'SendTestEmail'				=> 'Test e-mail versturen',
	'SendTestEmailInfo'			=> 'Deze optie verstuurt een test-e-mail naar het e-mailadres dat is opgegeven bij je accountinstellingen.',
	'TestEmailSubject'			=> 'Wiki is correct geconfigureerd om e-mails te versturen',
	'TestEmailBody'				=> 'Als je deze e-mail hebt ontvangen, is je wiki correct geconfigureerd om e-mails te versturen.',
	'TestEmailMessage'			=> 'De test-e-mail is verzonden.<br>Controleer je e-mailconfiguratie als je de test e-mail niet hebt ontvangen.',

	'SmtpSettings'				=> 'SMTP-instellingen',
	'SmtpAutoTls'				=> 'Opportunistische TLS:',
	'SmtpAutoTlsInfo'			=> 'Schakelt codering automatisch in als de server ziet dat de server TLS-encryptie adverteert (nadat u met de server hebt verbonden), zelfs als u de verbindingsmodus niet hebt ingesteld voor <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Authenticatiemethode voor SMTP:',
	'SmtpConnectionModeInfo'	=> 'Alleen gebruiken als een gebruikersnaam/wachtwoord ingesteld is, vraag je provider als je niet zeker bent welke methode je moet gebruiken.',
	'SmtpPassword'				=> 'SMTP-wachtwoord:',
	'SmtpPasswordInfo'			=> 'Alleen een wachtwoord invoeren als je SMTP-server dit vereist.<br><em><strong>Waarschuwing:</strong> Dit wachtwoord zal opgeslagen worden als platte tekst in de database, zichtbaar voor iedereen die toegang heeft tot je database of die dit configuratiepagina kan bekijken.</em>',
	'SmtpPort'					=> 'SMTP-serverpoort:',
	'SmtpPortInfo'				=> 'Verander dit alleen als je weet dat je SMTP-server op een andere poort draait. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'SMTP-serveradres:',
	'SmtpServerInfo'			=> 'Let op dat je het gebruikte protocol ook opgeeft. Indien je SSL gebruikt, dan is dit <code>ssl://mail.example.com</code>',
	'SmtpUsername'				=> 'SMTP-gebruikersnaam:',
	'SmtpUsernameInfo'			=> 'Voer alleen een gebruikersnaam in als je SMTP-server dit vereist.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Hier kan je de hoofdinstellingen voor bijlagen en bijbehorende speciale categorieën instellen.',
	'UploadSettingsUpdated'		=> 'Uploadinstellingen bijgewerkt',

	'FileUploadsSection'		=> 'Bestand Uploads',
	'RegisteredUsers'			=> 'geregistreerde gebruikers',
	'RightToUpload'				=> 'Machtigingen om bestanden te uploaden:',
	'RightToUploadInfo'			=> '<code>admins</code> betekent dat alleen gebruikers die tot de admins groep behoren bestanden kunnen uploaden. <code>1</code> betekent dat uploaden wordt geopend voor geregistreerde gebruikers. <code>0</code> betekent dat uploaden uitgeschakeld is.',
	'UploadMaxFilesize'			=> 'Maximum bestandsgrootte:',
	'UploadMaxFilesizeInfo'		=> 'Maximum grootte van elk bestand, met 0 als ongelimiteerd, bijgevoegd aan een privébericht.',
	'UploadQuota'				=> 'Totaal bijlage quota:',
	'UploadQuotaInfo'			=> 'Maximum schijfruimte beschikbaar voor bijlagen van het hele wiki, met <code>0</code> als ongelimiteerd. %1 used.',
	'UploadQuotaUser'			=> 'Opslagquota per gebruiker:',
	'UploadQuotaUserInfo'		=> 'Beperking van het opslagquotum dat kan worden geüpload door één gebruiker, waarbij <code>0</code> onbeperkt is.',

	'FileTypes'					=> 'Bestandstypes',
	'UploadOnlyImages'			=> 'Alleen uploaden van afbeeldingen toestaan:',
	'UploadOnlyImagesInfo'		=> 'Alleen uploaden van afbeeldingsbestanden op de pagina toestaan.',
	'AllowedUploadExts'			=> 'Toegelaten bestandstypes:',
	'AllowedUploadExtsInfo'		=> 'Toegestane extensies voor het uploaden van bestanden, door komma\'s gescheiden bv. <code>png, ogg, mp4</code>, anders zijn alle niet verboden bestandsextensies toegestaan.<br>U moet de lijst met toegestane bestandstypen beperken tot het minimum dat nodig is voor de inhoud van uw site.',
	'CheckMimetype'				=> 'Controleer bijlage bestanden:',
	'CheckMimetypeInfo'			=> 'Sommige browsers kunnen een incorrecte mimetype voor geüploade bestanden aannemen. Deze optie verzekerd je er van dat zulke bestanden die dit veroorzaken worden afgewezen.',
	'SvgSanitizer'				=> 'SVG Sanitizer:',
	'SvgSanitizerInfo'			=> 'Hiermee kunnen geüploade SVG-bestanden worden gezuiverd om te voorkomen dat SVG/XML kwetsbare bestanden worden geüpload.',
	'TranslitFileName'			=> 'Namen van vertalingen:',
	'TranslitFileNameInfo'		=> 'Als het van toepassing is en er is geen noodzaak om Unicode-tekens te gebruiken, is het sterk aanbevolen om alleen alfanumerieke tekens te accepteren.',
	'TranslitCaseFolding'		=> 'Converteer bestandsnamen naar kleine letters:',
	'TranslitCaseFoldingInfo'	=> 'Deze optie werkt alleen bij actieve transliteratie.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Miniatuur aanmaken:',
	'CreateThumbnailInfo'		=> 'Maakt een miniatuur aan in alle mogelijke situaties.',
	'ImageQuality'				=> 'Afbeelding kwaliteitsinstelling:',
	'ImageQualityInfo'			=> 'Kwaliteit bij het schalen van een miniatuur. Druk op om per codec waarden te kiezen die een vergelijkbaar perceptief resultaat opleveren.',
	'MaxImageArea'				=> 'Maximum Image Area:',
	'MaxImageAreaInfo'			=> 'Het maximum aantal pixels dat een bronafbeelding kan hebben. Dit geeft een limiet aan het geheugengebruik voor de decompressiekant van de beeldschaler. <br><code>-1</code> betekent dat de grootte van de afbeelding niet wordt gecontroleerd voordat wordt geprobeerd deze te schalen. <code>0</code> betekent dat de waarde automatisch wordt bepaald.',
	'MaxThumbWidth'				=> 'Maximum miniatuur breedte in pixel:',
	'MaxThumbWidthInfo'			=> 'Een aangemaakte miniatuur zal de hier ingestelde breedte niet overschrijden.',
	'MinThumbFilesize'			=> 'Minimum miniatuur bestandsgrootte:',
	'MinThumbFilesizeInfo'		=> 'Maakt geen miniatuur aan voor afbeeldingen kleiner dan dit.',
	'MaxImageWidth'				=> 'Afbeeldingsgroottelimiet op pagina\'s:',
	'MaxImageWidthInfo'			=> 'De maximale breedte die een afbeelding mag hebben op pagina\'s, anders wordt een verkleinde thumbnail gegenereerd.
',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Lijst met verwijderde pagina\'s, revisies en bestanden.
Verwijder of herstel de pagina\'s, revisies of bestanden uit de database door te klikken op de link <em>Remove</em>
of <em>Restore</em> in de overeenkomstige rij. (Let op, er wordt geen verwijderingsbevestiging gevraagd!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Woorden die automatisch op uw Wiki worden gecensureerd.',
	'FilterSettingsUpdated'		=> 'Bijgewerkte spamfilter instellingen',

	'WordCensoringSection'		=> 'Woord Censuur',
	'SPAMFilter'				=> 'SPAM Filter:',
	'SPAMFilterInfo'			=> 'Spam filter inschakelen',
	'WordList'					=> 'Woordenlijst:',
	'WordListInfo'				=> 'Woord of zin <code>fragment</code> om op de zwarte lijst te staan (één per regel)',

	// Log module
	'LogFilterTip'				=> 'Gebeurtenissen filteren op criteria:',
	'LogLevel'					=> 'Niveau',
	'LogLevelFilters'	=> [
		'1'		=> 'niet minder dan',
		'2'		=> 'niet hoger dan',
		'3'		=> 'gelijk',
	],
	'LogDate'					=> 'Datum',
	'LogEvent'					=> 'Gebeurtenis',
	'LogUsername'				=> 'Gebruikersnaam',
	'LogLevels'	=> [
		'1'		=> 'kritiek',
		'2'		=> 'hoogste',
		'3'		=> 'hoog',
		'4'		=> 'gemiddeld',
		'5'		=> 'laag',
		'6'		=> 'laagste',
		'7'		=> 'debuggen',
	],

	'LogCollapse'        => 'samenvouwen',
	'LogExpand'          => 'uitbreiden',
	'LogType'              => 'Type',
	'LogSearch'            => 'Zoeken',
	'LogSearchPlaceholder' => 'berichten zoeken...',
	'LogUserId'            => 'Gebruiker ID',
	'LogExactMatch'        => 'exacte overeenkomst',
	'LogFrom'              => 'van',
	'LogTo'                => 'tot',
	'LogSupportKey'        => 'Support key',
	'LogContext'           => 'Context',
	'LogTarget'            => 'Target',
	'LogUserAgent'         => 'User Agent',
	'LogReferer'           => 'Verwijzer',
	'LogTotal'             => 'Totaal',
	'LogFilteredBy'        => 'Gefilterd door',
	'LogClearFilter'       => 'Filter wissen',
	'LogActions'           => 'acties',
	'LogDelete'            => 'Verwijderen',
	'LogDeleteConfirm'     => 'Deze log wissen?',
	'LogDeleteSelected'    => 'Verwijder geselecteerde items',
	'LogBulkAction'        => '— bulk actie —',
	'LogApply'             => 'Toepassen',
	'LogExportCSV'         => 'Exporteren als CSV',
	'LogExportJSON'        => 'JSON exporteren',
	'LogPurged'            => 'Log tabel afgekapt.',
	'LogPurgedFiltered'     => '%1 logboekvermeldingen verwijderd door het filter.',
	'LogDeleted'           => 'Logboek is verwijderd.',
	'LogDeletedBulk'        => '%1 log items verwijderd.',
	'LogPurgeSection'      => 'Vernietigende bewerkingen',
	'LogPurgeWarning'      => 'Er zijn %1 vermeldingen die overeenkomen met de huidige weergave. Gebruik zorgvuldig.',
	'LogPurgeConfirm'      => 'Ik begrijp dat dit de logboekvermeldingen permanent verwijdert',
	'LogPurgeFiltered'     => 'Opschonen overeenkomende filter',
	'LogPurgeFilteredConfirm' => 'Alle items verwijderen die overeenkomen met het huidige filter? Dit kan niet ongedaan worden gemaakt.',
	'LogPurgeAll'          => 'Verwijder ENTIRE log',
	'LogPurgeAllConfirm'   => 'Verwijder ALLE logboekvermelding in de database? Dit kan niet ongedaan worden gemaakt.',
	'LogFindRelated'       => 'Vind gerelateerde items',
	'LogNoMatch'           => 'Geen logboekvermelding komt overeen met het huidige filter.',

	'LogMarkAll'                => 'Markeer alle rijen op deze pagina',
	'LogMarkNone'               => 'Deselecteer alle rijen',
	'LogSelectRow'              => 'Rij selecteren',

	// Massemail module
	'MassemailInfo'				=> 'Hier kan je een e-mail naar alle gebruikers of de leden van een specifieke groep sturen, <strong>die de ontvangst van massa e-mails toelaten</strong>. Hiervoor wordt een e-mail met alle ontvangers als onzichtbaar (bcc) ingesteld, naar het beheerders-e-mailadres gestuurd. Bij de standaard instellingen wordt de e-mail naar 20 mensen per pakket gestuurd. Indien er meer dan 50 ontvangers zijn, wordt de e-mail via meerdere pakketten verzonden. Indien je een e-mail naar een grote groep stuurt, wees dan geduldig en stop de pagina niet halverwege. Het is normaal dat het versturen van massa e-mails enige tijd in beslag neemt. Je wordt ervan op de hoogte gebracht zodra het script klaar is.',
	'LogMassemail'				=> 'Messemail send %1 to group / user ',
	'MassemailSend'				=> 'Massemail send',

	'NoEmailMessage'			=> 'Het berichtveld is nog leeg.',
	'NoEmailSubject'			=> 'Je hebt geen onderwerp opgegeven.',
	'NoEmailRecipient'			=> 'U moet ten minste één gebruiker of gebruikersgroep opgeven.',

	'MassemailSection'			=> 'Groepsgewijs e-mail',
	'MessageSubject'			=> 'Onderwerp:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Je bericht:',
	'YourMessageInfo'			=> 'Het bericht wordt verzonden zonder tekst-opmaak. Alle opmaak wordt voor het verzenden verwijderd.',

	'NoUser'					=> 'Geen gebruiker',
	'NoUserGroup'				=> 'Geen gebruikersgroep',

	'SendToGroup'				=> 'Verstuur naar groep:',
	'SendToUser'				=> 'Verstuur naar gebruikers:',
	'SendToUserInfo'			=> 'It send only messages to those user who allowed Administrators to email them information. This option is available in their user settings under Notifications.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Systeembericht bijgewerkt',

	'SysMsgSection'				=> 'Systeemmelding',
	'SysMsg'					=> 'Systeemmelding:',
	'SysMsgInfo'				=> 'Je tekst hier',

	'SysMsgType'				=> 'Type',
	'SysMsgTypeInfo'			=> 'Berichttype (CSS).',
	'SysMsgAudience'			=> 'Publiek:',
	'SysMsgAudienceInfo'		=> 'Het publiek aan wie het systeembericht wordt getoond.',
	'EnableSysMsg'				=> 'Systeembericht inschakelen:',
	'EnableSysMsgInfo'			=> 'Toon systeembericht.',

	// User approval module
	'ApproveNotExists'			=> 'Selecteer ten minste één gebruiker via de knop instellen.',

	'LogUserApproved'			=> 'Gebruiker ##%1## goedgekeurd',
	'LogUserBlocked'			=> 'Gebruiker ##%1## geblokkeerd',
	'LogUserDeleted'			=> 'Gebruiker ##%1verwijderd uit de database',
	'LogUserCreated'			=> 'Maak een nieuwe gebruiker ##%1##',
	'LogUserUpdated'			=> 'Bijgewerkt gebruiker ##%1##',
	'LogUserPasswordReset'		=> 'Wachtwoord voor gebruiker ##%1## succesvol gereset',

	'UserApproveInfo'			=> 'Goedkeuren nieuwe gebruikers voordat ze kunnen inloggen op de site.',
	'Approve'					=> 'Goedkeuren',
	'Deny'						=> 'Weigeren',
	'Pending'					=> 'Hangende',
	'Approved'					=> 'Goedgekeurd',
	'Denied'					=> 'Geweigerd',

	// DB Backup module
	'BackupStructure'			=> 'Structuur',
	'BackupData'				=> 'Gegevens',
	'BackupFolder'				=> 'Map',
	'BackupTable'				=> 'Tabel',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'Bestanden',
	'BackupNote'				=> 'Opmerking:',
	'BackupSettings'			=> 'Specificeer het gewenste systeem van backup.<br>' .
    	'De root cluster heeft geen invloed op de globale bestanden back-up en cache bestanden back-up (indien gekozen, worden ze altijd volledig bewaard).<br>' .  '<br>' .
		'<strong>Aandacht</strong>: Om verlies van informatie uit de database te voorkomen bij het specificeren van de hoofdcluster, de tabellen van deze back-up zullen niet worden geherstructureerd, hetzelfde als wanneer alleen tabelstructuur wordt geback-upt zonder de gegevens op te slaan. Om een volledige conversie van de tabellen naar het back-upformaat te maken, moet je de <em> volledige database backup (structuur en gegevens) maken zonder de cluster</em> te specificeren.',
	'BackupCompleted'			=> 'Back-up en archivering voltooid.<br>' .
    	'De Back-up pakketbestanden zijn opgeslagen in de submap %1.<br>Om het te downloaden gebruikt u FTP (behoud de mapstructuur en bestandsnamen tijdens het kopiëren).<br> Om een back-up te herstellen of te verwijderen, ga naar <a href="%2">Database</a>.',
	'LogSavedBackup'			=> 'Back-up database opgeslagen ##%1##',
	'Backup'					=> 'Back-up',
	'CantReadFile'				=> 'Kan bestand %1 niet lezen.',

	// DB Restore module
	'RestoreInfo'				=> 'Je kunt een van de gevonden backup-pakketten herstellen of ze van de server verwijderen.',
	'ConfirmDbRestore'			=> 'Wilt u back-up %1 herstellen?',
	'ConfirmDbRestoreInfo'		=> 'Wacht alstublieft even, dit kan enkele minuten duren.',
	'RestoreWrongVersion'		=> 'Verkeerde versie van WackoWiki!',
	'DirectoryNotExecutable'	=> 'De map %1 is niet uitvoerbaar.',
	'BackupDelete'				=> 'Weet u zeker dat u back-up %1 wilt verwijderen?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Extra herstel opties:',
	'RestoreOptionsInfo'		=> '* Voor het herstellen van de <strong>cluster back-up</strong>, ' .
									'de doeltabellen worden niet verwijderd (om te voorkomen dat informatie van de clusters die niet zijn gerepareerd.) ' .
									'Tijdens het herstelproces zullen er dus dubbele records plaatsvinden. ' .
									'In normale modus worden ze allemaal vervangen door de records vorm back-up (met SQL <code>REPLACE</code>), ' .
									'maar als dit selectievakje is aangevinkt, worden alle duplicaten overgeslagen (de huidige waarden van de records worden bewaard), ' .
									'en alleen de records met nieuwe sleutels worden toegevoegd aan de tabel (SQL <code>INSERT IGNORE</code>).<br>' .
									'<strong>Notificatie</strong>: Bij het herstellen van de volledige back-up van de site heeft deze optie geen waarde.<br>' .
									'<br>' .
									'** Als de back-up de gebruikersbestanden bevat (globale en perpagina, cache bestanden, enz.), ' .
									'in normale modus vervangen ze de bestaande bestanden met dezelfde namen en worden geplaatst in dezelfde map wanneer ze worden hersteld. ' .
									'Met deze optie kunt u de huidige kopieën van de bestanden opslaan en herstellen van alleen een nieuwe back-up (ontbrekende op de server).',
	'IgnoreDuplicatedKeysNr'	=> 'Dubbele tafeltoetsen negeren (niet vervangen)',
	'IgnoreSameFiles'			=> 'Negeer dezelfde bestanden (niet overschrijven)',
	'NoBackupsAvailable'		=> 'Geen back-ups beschikbaar.',
	'BackupEntireSite'			=> 'Gehele site',
	'BackupRestored'			=> 'De back-up is hersteld. Hieronder is een samenvattend rapport bijgevoegd. Klik om dit backup pakket te verwijderen op',
	'BackupRemoved'				=> 'De geselecteerde back-up is met succes verwijderd.',
	'LogRemovedBackup'			=> 'Database backup ##%1 ## verwijderd',

	'DbEngineInvalid'			=> 'Ongeldige database engine, verwacht %1',
	'RestoreStarted'			=> 'Herstel geïnitieerd',
	'RestoreParameters'			=> 'Gebruik parameters',
	'IgnoreDuplicatedKeys'		=> 'Dubbele toetsen negeren',
	'IgnoreDuplicatedFiles'		=> 'Dubbele bestanden negeren',
	'SavedCluster'				=> 'Opgeslagen cluster',
	'DataProtection'			=> 'Gegevensbescherming - %1 weggelaten',
	'AssumeDropTable'			=> 'Neem %1 aan',
	'RestoreSQLiteDatabase'		=> 'De SQLite database herstellen',
	'SQLiteDatabaseRestored'	=> 'Database succesvol hersteld van:',
	'RestoreTableStructure'		=> 'Herstellen van de structuur van de tabel',
	'RunSqlQueries'				=> 'Perform SQL-instructions:',
	'CompletedSqlQueries'		=> 'Voltooid. Verwerkte instructies:',
	'NoTableStructure'			=> 'De structuur van de tabellen is niet opgeslagen - Overslaan',
	'RestoreRecords'			=> 'De inhoud van tabellen herstellen',
	'ProcessTablesDump'			=> 'Gewoon downloaden en verwerken van tabeldumps',
	'Instruction'				=> 'Instructie',
	'RestoredRecords'			=> 'records:',
	'RecordsRestoreDone'		=> 'Totaal voltooid. Totaal aantal invoeren:',
	'SkippedRecords'			=> 'Gegevens niet opgeslagen - overslaan',
	'RestoringFiles'			=> 'Bestanden herstellen',
	'DecompressAndStore'		=> 'Vergroot en sla de inhoud van mappen op',
	'HomonymicFiles'			=> 'homonische bestanden',
	'RestoreSkip'				=> 'overslaan',
	'RestoreReplace'			=> 'vervang',
	'RestoreFile'				=> 'Bestand:',
	'RestoredFiles'				=> 'hersteld:',
	'SkippedFiles'				=> 'overgeslagen:',
	'FileRestoreDone'			=> 'Totaal aantal bestanden:',
	'FilesAll'					=> 'alle:',
	'SkipFiles'					=> 'Bestanden worden niet opgeslagen - overslaan',
	'RestoreDone'				=> 'HERSTORATIE VOLTOOID',

	'BackupCreationDate'		=> 'Aanmaak datum',
	'BackupPackageContents'		=> 'De inhoud van het pakket',
	'BackupRestore'				=> 'Herstellen',
	'BackupRemove'				=> 'Verwijderen',
	'RestoreYes'				=> 'Ja',
	'RestoreNo'					=> 'Nee',
	'LogDbRestored'				=> 'Back-up ##%1## van de database hersteld.',

	'BackupArchived'			=> 'Back-up %1 gearchiveerd.',
	'BackupArchiveExists'		=> 'Back-uparchief %1 bestaat al.',
	'LogBackupArchived'			=> 'Back-up ##%1## gearchiveerd.',

	// User module
	'UsersInfo'					=> 'Hier kunt u de gebruikersinformatie en bepaalde specifieke opties wijzigen.',

	'UsersAdded'				=> 'Gebruiker toegevoegd',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> 'Bewerk',
	'UsersAddNew'				=> 'Nieuwe gebruiker toevoegen',
	'UsersDelete'				=> 'Weet u zeker dat u gebruiker %1 wilt verwijderen?',
	'UsersDeleted'				=> 'De gebruiker %1 werd uit de database verwijderd.',
	'UsersRename'				=> 'Wijzig de naam van gebruiker %1 naar',
	'UsersRenameInfo'			=> '* NB: Verandering heeft gevolgen voor alle pagina\'s die aan die gebruiker zijn toegewezen.',
	'UsersUpdated'				=> 'Gebruiker succesvol bijgewerkt.',

	'UserIP'					=> 'IP-adres',
	'UserSignuptime'			=> 'Aanmeldtijd',
	'UserActions'				=> 'acties',
	'NoMatchingUser'			=> 'Geen gebruikers die voldoen aan de criteria',

	'UserAccountNotify'			=> 'Gebruiker informeren',
	'UserNotifySignup'			=> 'de gebruiker informeren over het nieuwe account',
	'UserVerifyEmail'			=> 'e-mailbevestig token instellen en een link toevoegen voor e-mailverificatie',
	'UserReVerifyEmail'			=> 'Verzend het e-mailbevestigingstoken opnieuw',

	// Groups module
	'GroupsInfo'				=> 'Vanuit dit paneel kun je al je gebruikersgroepen beheren. Je kunt bestaande groepen verwijderen, aanmaken en bewerken. Bovendien kunt u groepsleiders kiezen, schakel de status van open/verborgen/gesloten groepen in en stel de groepsnaam en -beschrijving in.',

	'LogMembersUpdated'			=> 'Geüpdatet gebruikersgroep leden',
	'LogMemberAdded'			=> 'Lid ##%1## toegevoegd aan groep ##%2##',
	'LogMemberRemoved'			=> 'Lid ##%1## verwijderd uit groep ##%2##',
	'LogGroupCreated'			=> 'Een nieuwe groep gemaakt ##%1##',
	'LogGroupRenamed'			=> '## Groep ##%1## hernoemd tot ##%2##',
	'LogGroupRemoved'			=> 'Groep verwijderd ##%1##',

	'GroupsMembersFor'			=> 'Leden voor de groep',
	'GroupsDescription'			=> 'Beschrijving',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Open',
	'GroupsActive'				=> 'Actief',
	'GroupsTip'					=> 'Klik om groep te bewerken',
	'GroupsUpdated'				=> 'Groepen bijgewerkt',
	'GroupsAlreadyExists'		=> 'Deze groep bestaat al.',
	'GroupsAdded'				=> 'Groep succesvol toegevoegd.',
	'GroupsRenamed'				=> 'Hernoemen groep geslaagd.',
	'GroupsDeleted'				=> 'De groep %1 en alle bijbehorende pagina\'s zijn verwijderd uit de database.',
	'GroupsAdd'					=> 'Nieuwe groep toevoegen',
	'GroupsRename'				=> 'Hernoem de groep %1 naar',
	'GroupsRenameInfo'			=> '* NB: Verandering heeft invloed op alle pagina\'s die aan die groep zijn toegewezen.',
	'GroupsDelete'				=> 'Weet u zeker dat u groep %1 wilt verwijderen?',
	'GroupsDeleteInfo'			=> '* Opmerking: Verandering zal van invloed zijn op alle leden die aan die groep zijn toegewezen.',
	'GroupsIsSystem'			=> 'De groep %1 behoort tot het systeem en kan niet worden verwijderd.',
	'GroupsStoreButton'			=> 'Groepen opslaan',
	'GroupsEditInfo'			=> 'Selecteer de radio knop om de lijst met groepen te bewerken.',

	'GroupAddMember'			=> 'Lid toevoegen',
	'GroupRemoveMember'			=> 'Lid verwijderen',
	'GroupAddNew'				=> 'Groep toevoegen',
	'GroupEdit'					=> 'Groep bewerken',
	'GroupDelete'				=> 'Groep verwijderen',

	'MembersAddNew'				=> 'Voeg nieuw lid toe',
	'MembersAdded'				=> 'Nieuw lid met succes aan de groep toegevoegd.',
	'MembersRemove'				=> 'Weet u zeker dat u deelnemer %1 wilt verwijderen?',
	'MembersRemoved'			=> 'Het lid is verwijderd uit de groep.',

	// Statistics module
	'DbStatSection'				=> 'Database statistieken',
	'DbTable'					=> 'Tabel',
	'DbRecords'					=> 'Records',
	'DbSize'					=> 'Grootte',
	'DbIndex'					=> 'Indexeren',
	'DbTotal'					=> 'Totaal',

	'FileStatSection'			=> 'Bestandssysteem statistieken',
	'FileFolder'				=> 'Map',
	'FileFiles'					=> 'Bestanden',
	'FileSize'					=> 'Grootte',
	'FileTotal'					=> 'Totaal',

	// Sysinfo module
	'SysInfo'					=> 'Versie informatie:',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Waarden',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Laatste update',
	'ServerOS'					=> 'Besturingssysteem',
	'ServerName'				=> 'Server naam',
	'WebServer'					=> 'Web server',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'Database',
	'SqlModesGlobal'			=> 'SQL Modi Globaal',
	'SqlModesSession'			=> 'SQL modi sessie',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Geheugen',
	'UploadFilesizeMax'			=> 'Upload max bestandsgrootte',
	'PostMaxSize'				=> 'Post maximale grootte',
	'MaxExecutionTime'			=> 'Maximale uitvoeringstijd',
	'SessionPath'				=> 'Sessie pad',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip compressie',
	'PhpExtensions'				=> 'PHP extensies',
	'ApacheModules'				=> 'Apache modules',

	// DB repair module
	'DbRepairSection'			=> 'Repareer Database',
	'DbRepair'					=> 'Repareer Database',
	'DbRepairInfo'				=> 'Dit script kan automatisch naar gemeenschappelijke databaseproblemen zoeken en repareren. Repareren kan een tijdje duren, dus wees geduldig.',

	'DbOptimizeRepairSection'	=> 'Repareer en Optimaliseer Database',
	'DbOptimizeRepair'			=> 'Repareer en Optimaliseer Database',
	'DbOptimizeRepairInfo'		=> 'Dit script kan ook proberen de database te optimaliseren. Dit verbetert de prestaties in sommige situaties. Het herstellen en optimaliseren van de database kan veel tijd in beslag nemen en de database zal worden vergrendeld tijdens het optimaliseren.',

	'TableOk'					=> 'De %1 tabel is oké.',
	'TableNotOk'				=> 'De %1 tabel is niet in orde. Het rapporteert de volgende fout: %2. Dit script zal proberen deze tabel te repareren&hellip;',
	'TableRepaired'				=> 'Succesvol de %1 tabel gerepareerd.',
	'TableRepairFailed'			=> 'Herstellen van de %1 tabel mislukt. <br>Error: %2',
	'TableAlreadyOptimized'		=> 'De tabel %1 is al geoptimaliseerd.',
	'TableOptimized'			=> 'De tabel %1 is succesvol geoptimaliseerd.',
	'TableOptimizeFailed'		=> 'Het optimaliseren van de %1 tabel is mislukt. <br>Error: %2',
	'TableNotRepaired'			=> 'Sommige databaseproblemen konden niet worden hersteld.',
	'RepairsComplete'			=> 'Reparaties voltooid',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Toon en corrigeer inconsistenties, verwijder of wijs verweesde records toe aan een nieuwe gebruiker / waarde.',
	'Inconsistencies'			=> 'Inconsistenties',
	'CheckDatabase'				=> 'Database',
	'CheckDatabaseInfo'			=> 'Controleert voor record inconsistenties in de database.',
	'CheckFiles'				=> 'Bestanden',
	'CheckFilesInfo'			=> 'Controleert op verlaten bestanden, bestanden zonder referentie links in de tabel van het bestand.',
	'Records'					=> 'Records',
	'InconsistenciesNone'		=> 'Geen data inconsistenties gevonden.',
	'InconsistenciesDone'		=> 'Datalinconsistenties opgelost.',
	'InconsistenciesRemoved'	=> 'Verwijderde inconsistenties',
	'Check'						=> 'Controleer',
	'Solve'						=> 'Oplossen',

	// Bad Behaviour module
	'BbInfo'					=> 'Detects and blocks unwanted Web accesses, deny automated spambots access<br>For more information please visit the %1 homepage.',
	'BbEnable'					=> 'Slecht gedrag inschakelen:',
	'BbEnableInfo'				=> 'Alle andere instellingen kunnen worden gewijzigd in de configuratiemap %1.',
	'BbStats'					=> 'Bad Behaviour heeft toegang tot %1 de afgelopen 7 dagen geblokkeerd.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Logboek',
	'BbSettings'				=> 'Instellingen',
	'BbWhitelist'				=> 'Witte',

	// --> Log
	'BbHits'					=> 'Treffers',
	'BbRecordsFiltered'			=> 'Weergeven %1 van %2 records gefilterd door',
	'BbStatus'					=> 'status',
	'BbBlocked'					=> 'Geblokkeerd',
	'BbPermitted'				=> 'Toegestand',
	'BbIp'						=> 'IP-adres',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Alle %1 records worden weergegeven',
	'BbShow'					=> 'Weergeven',
	'BbIpDateStatus'			=> 'IP/Datum/Status',
	'BbHeaders'					=> 'Kopteksten',
	'BbEntity'					=> 'Entiteit',

	'BbSearchPlaceholder'        => 'Zoek UA, URI, IP, host, support_key, status…',
	'BbFilterAnyCategory'        => 'Elke categorie',
	'BbFilterAnyMethod'          => 'Elke methode',
	'BbFilterAnyStatus'          => 'Elke status',
	'BbFilterBlockedOnly'        => 'Alleen geblokkeerd',
	'BbFilterPermittedOnly'      => 'Alleen toegestaan',
	'BbFilterApply'              => 'Toepassen',
	'BbFilterClear'              => 'Filters wissen',
	'BbChipSearch'               => 'Zoeken',
	'BbChipCategory'             => 'categorie',
	'BbChipMethod'               => 'Methode',
	'BbChipStatus'               => 'status',
	'BbChipRemove'               => 'Deze filter verwijderen',
	'BbFilterByCategory'         => 'Filteren op deze categorie',
	'BbSearchBySupportKey'       => 'Zoeken naar deze support sleutel',

	// === Check flag (operator-marked records, exempt from autodelete) ===
	'BbFilterAnyCheck'         => 'Elke controlestatus',
	'BbFilterCheckedOnly'      => 'Alleen aangevinkt',
	'BbFilterUncheckedOnly'    => 'Alleen niet-aangevinkt',
	'BbChipCheck'              => 'Status controleren',
	'BbChecked'                => 'gecontroleerd',
	'BbUnchecked'              => 'uitgevinkt',
	'BbActionCheck'            => 'controleren',
	'BbActionUncheck'          => 'uitvinken',
	'BbRowChecked'             => 'Log gemarkeerd als aangevinkt',
	'BbRowUnchecked'           => 'Log niet aangevinkt',
	'BbRowCheckedHint'         => 'Dit record is gecontroleerd - vrijgesteld van automatische schoonmaak',
	'BbRowUncheckedHint'       => 'Markeer dit record om het over automatische opschonen te houden',
	'BbBulkCheckSelected'      => 'Markeer als aangevinkt',
	'BbBulkUncheckSelected'    => 'Niet markeren aangevinkt',
	'BbBulkChecked'            => 'Gemarkeerd als %1 invoergegevens als gecontroleerd',
	'BbBulkUnchecked'          => 'Niet-gemarkeerde %1 invoergegevens',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Instellingen opgeslagen.',
	'BbWhitelistHint'			=> 'Ongepast whitelisting laat je bloot staan aan spam of veroorzaakt slecht gedrag om volledig te werken! NIET WHITELIST tenzij je 100% CERTAIN bent dat je zou moeten doen.',
	'BbIpAddress'				=> 'IP adres',
	'BbIpAddressInfo'			=> 'IP-adres of CIDR formaat adresbereiken die op de witte lijst staan (één per regel)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL-fragmenten beginnend met de / na de hostnaam van uw website (een per regel)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'Tekenreeksen voor gebruikersagenten die op de witte lijst staan (één per regel)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Instellingen voor Bad Behaviour bijgewerkt',
	'BbLogRequest'				=> 'HTTP-verzoek wordt vastgelegd',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normaal (aanbevolen)',
	'BbLogOff'					=> 'Niet loggen (niet aanbevolen)',
	'BbSecurity'				=> 'Beveiliging',
	'BbStrict'					=> 'Strikte controle',
	'BbStrictInfo'				=> 'blokkeert meer spam maar blokkeert sommige mensen',
	'BbOffsiteForms'			=> 'Formulierberichten van andere websites toestaan',
	'BbOffsiteFormsInfo'		=> 'vereist voor OpenID; verhoog spam ontvangen',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Om Bad Behaviour http:BL functies te kunnen gebruiken moet je een %1 hebben',
	'BbHttpblKey'				=> 'http:BL toegangssleutel',
	'BbHttpblThreat'			=> 'Minimaal Bedreigingsniveau (25 wordt aanbevolen)',
	'BbHttpblMaxage'			=> 'Maximale leeftijd van gegevens (30 wordt aanbevolen)',
	'BbReverseProxy'			=> 'Omgekeerde Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'Als je Bad Gedrag gebruikt achter een reverse proxy, load balancer, HTTP-accelerator, content-cache of soortgelijke technologie, schakel dan de Reverse Proxy optie in.<br>' .
									'Als u een keten van twee of meer reverse proxy\'s hebt tussen uw server en het openbare internet, u moet <em>alle</em> van het IP-adresbereik (in CIDR formaat) van al uw proxyservers, laadbalansen, etc. specificeren. Anders is Bad Behaviour mogelijk niet in staat om het echte IP adres van de klant te bepalen.<br>' .
									'Daarnaast moeten uw reverse-proxy-servers het IP-adres van de internetclient instellen waaruit zij het verzoek in een HTTP-header hebben ontvangen. Als u geen header opgeeft, zal %1 worden gebruikt. De meeste proxyservers ondersteunen al X-Forwarded-For en je hoeft er vervolgens alleen voor te zorgen dat het is ingeschakeld op je proxyservers. Enkele andere headernamen in gemeenschappelijk gebruik zijn %2 en %3.',
	'BbReverseProxyEnable'		=> 'Omgekeerde Proxy Inschakelen',
	'BbReverseProxyHeader'		=> 'Koptekst met IP adres van Internet-clients',
	'BbReverseProxyAddresses'	=> 'IP-adres of CIDR formaat adresbereiken voor uw proxyservers (één per regel)',

	'BbBehavioral'           => 'Gedragkundige analyse',
	'BbEnableBehavioral'     => 'Inschakelen van gedragsanalyse (afwijkingen van het tarief, draai UA/IP)',
	'BbEnableBehavioralInfo' => 'Trackt aanvraagpatronen per sessie. Veilig om ingeschakeld te blijven.',
	'BbEnableFingerprinting' => 'TLS/HTTP/2 vingerafdrukken inschakelen (JA3, H2, header order)',
	'BbEnableFingerprintingInfo' => 'Blokkeert alleen bekende slechte vingerafdrukken. Vereist enable_fingerprinting=true. kan valse positieve effecten veroorzaken in oude browsers/proxies.',
	'BbInspectJson'          => 'Controleer JSON aanvraaglichamen voor aanvallen',
	'BbInspectJsonInfo'      => 'WAARSCHUWING: Breaks AX/JSON API\'s (wiki opmaak, code snippets zorgen voor valse posities). Houd UIT.',
	'BbInspectMultipart'     => 'Controleer multipart/form-data lichamen voor aanvallen',
	'BbInspectMultipartInfo' => 'WAARSCHUWING: Breekt bestandsuploads. OFF.',

	'BbEnableClientHints'      => 'Client Hints validatie inschakelen',
	'BbEnableClientHintsInfo'  => 'Valideren sec-CH-UA headers tegen User-Agent om spoofed browsers te detecteren (Chrome 89+).',
	'BbEnableAgentic'          => 'Schakel Agentische Gedragsdetectie in',
	'BbEnableAgenticInfo'      => 'Detecteer AI agent patronen: denkk-then-fetch, niet-lineaire navigatie, precisie doelwit.',
	'BbStrictSearchEngines'    => 'Strikte zoekmachines',
	'BbStrictSearchEnginesInfo' => 'Pas strengere controles toe aan niet-geverifieerde zoekmachine bots (Googlebot, Bingbot, …) voordat ze worden uitgevoerd.',
	'BbEnableDynamicIp'        => 'Dynamisch IP Bereik Ophalen inschakelen',
	'BbEnableDynamicIpInfo'    => 'Het ophalen van officiële IP-bereiken via Google, Bing, OpenAI, Anthropic, Apple, etc. (gecached 24h, versteende terugval 7 dagen).',

	'BbAiCrawlers'           => 'AI Crawler Besturing',
	'BbBlockUnverifiedAi'    => 'Blok niet-geverifieerde AI crawlers',
	'BbBlockUnverifiedAiInfo' => 'Blokkeert AI crawlers die DNS/IP verificatie mislukt (spoofed bots).',
	'BbStrictAi'             => 'Strikte AI-modus (blok zelfs geverifieerde ongeoorloofde AI)',
	'BbStrictAiInfo'         => 'Blokkeert ALLE AI crawlers die niet in de toegestane lijst staan, zelfs als geverifieerd.',
	'BbAllowedAiCrawlers'    => 'Toegestane AI crawler tokens (één per regel)',
	'BbAllowedAiCrawlersInfo' => 'Tokens: GPTBot, ClaudeBot, Google-Extened, PerplexityBot, Meta-ExternalAgent, Applebot-Extened, CCBot, ia_archiver',

	'BbDnsbl'                => 'DNSBL / http:BL',
	'BbDnsblEnabled'         => 'DNSBL-controles inschakelen',
	'BbDnsblLists'           => 'DNSBL lijsten (een per regel)',
	'BbDnsblListsInfo'       => 'Default: zen.spamhaus.org, bl.spamcop.net',

	'BbRateLimits'           => 'Tarief Limiet',
	'BbRateLimitEnabled'     => 'Tarief limitatie inschakelen',
	'BbRateGlobalRequests'   => 'Globale verzoeken per venster',
	'BbRateGlobalWindow'     => 'Globaal venster (seconden)',
	'BbRatePerMinuteRequests'=> 'Aanvragen per minuut',
	'BbRatePerMinuteWindow'  => 'Per-minuten venster (seconden)',
	'BbRatePostRequests'     => 'POST-aanvragen per venster',
	'BbRatePostWindow'       => 'POST venster (seconden)',
	'BbRateLoginRequests'    => 'Inlogverzoeken per venster',
	'BbRateLoginWindow'      => 'Login venster (seconden)',

	'BbChallenge'            => 'Uitdaging Systeem',
	'BbChallengeEnabled'     => 'Uitdagingen inschakelen',
	'BbChallengeProvider'    => 'Uitdaging aanbieder',
	'BbChallengeSiteKey'     => 'Site sleutel',
	'BbChallengeSecretKey'   => 'Geheime sleutel',
	'BbRecaptchaMinScore'    => 'reCAPTCHA v3 min score',

	'BbPerformance'          => 'Prestaties',
	'BbSkipExtensions'       => 'Extensies overslaan (één per regel)',
	'BbSkipPaths'            => 'Skip pad voorvoegsels (één per regel)',

	'BbGeoip'                => 'GeoIP / ASN Blokkeren',
	'BbGeoipEnabled'         => 'GeoIP-zoekopdrachten inschakelen',
	'BbGeoipDbPath'          => 'MaxMind DB pad',
	'BbBlockedCountries'     => 'Geblokkeerde landen (ISO-codes, één per regel)',
	'BbBlockedAsns'          => 'Geblokkeerde ASN\'s (één per regel)',

	'BbBlockPage'                  => 'Pagina blokkeren',
	'BbShowDetailedBlockPage'      => 'Toon gedetailleerde blok pagina',
	'BbShowDetailedBlockPageInfo'  => 'Toon reden, verzoek URI en technische ondersteuningssleutel op de blokpagina. Aanbevolen voor productie.',
	'BbShowContactInfo'            => 'Contactinformatie weergeven op blokpagina',
	'BbShowContactInfoInfo'        => 'Toon admin e-mail op de blok pagina (wordt alleen van kracht wanneer gedetailleerde blok pagina is ingeschakeld).',
	'BbSettingsSaveFailed'         => 'Fout bij het opslaan van Bad Behaviour instellingen',

	// === Basic section ===
	'BbBasicSection'      => 'Basis instellingen',
	'BbAdvancedSection'   => 'Geavanceerde instellingen',
	'BbAdvancedHint'      => 'De meeste exploitanten zouden die niet hoeven te veranderen.',

	// === Basic knobs ===
	'BbPreset'            => 'Bot preset',
	'BbPresetInfo'        => 'Welke bots te herkennen. "minimaal" (standaard) is snelste; "vol" is het meest grondig.',
	'BbStrictness'        => 'Posters blokkeren',
	'BbStrictnessInfo'    => 'alleen logs monitoren maar niets blokkeren; normale blokken geverifieerde aanvallers; strikte blokkeert agressief.',
	'BbLoggingMode'       => 'Logboekregistratie',
	'BbLoggingModeInfo'   => 'Normaal (aanbevolen), Verbose (logt elke aanvraag), Uit',
	'BbLogModeNormal'     => 'normaal',
	'BbLogModeVerbose'    => 'Verbose',
	'BbLogModeOff'        => 'UIT',
	'BbBehindProxy'       => 'Site bevindt zich achter een reverse proxy of CDN',
	'BbBehindProxyInfo'   => 'Inschakelen achter Cloudflare, AWS, GCP, snel, etc. U moet proxyIP-bereiken toevoegen in geavanceerd - zonder hen, kunnen echte client IP\'s niet worden bepaald.',

	// === Advanced section headers ===
	'BbAdvCore'           => 'Kern',
	'BbAdvReverseProxy'   => 'Omgekeerde Proxy',
	'BbAdvAiCrawlers'     => 'AI Crawlers',
	'BbAdvBotCategories'  => 'Bot Categorieën',
	'BbAdvDnsVerification'=> 'DNS-verificatie',
	'BbAdvRateLimits'     => 'Tarief Limiet',
	'BbAdvHeadDetection'  => 'Hoofdverzoek detectie',
	'BbAdvAssetScraping'  => 'Asset Scraping Detectie',
	'BbAdvDynamicIp'      => 'Dynamische IP-bereiken',
	'BbAdvOnDemandRefresh'=> 'On-Demand IP vernieuwen',
	'BbAdvHttpbl'         => 'Project Honeypot http:BL',
	'BbAdvDnsbl'          => 'DNSBL',
	'BbAdvChallenge'      => 'Uitdaging / CAPTCHA',
	'BbAdvPerformance'    => 'Prestaties',
	'BbAdvGeoip'          => 'GeoIP / ASN Blokkeren',
	'BbAdvFingerprints'   => 'TLS / HTTP/2 vingerafdrukken',
	'BbAdvCustomRules'    => 'Aangepaste regels',
	'BbAdvBlockPage'      => 'Pagina blokkeren',

	// === bot category labels (multi-checkbox) ===
	'BbCatSearchEngine'   => 'Motor zoeken',
	'BbCatAiCrawler'      => 'AI Crawler',
	'BbCatSocialCrawler'  => 'Sociale Crawler',
	'BbCatSeoCrawler'     => 'SEO Crawler',
	'BbCatArchiveCrawler' => 'Archiveer Crawler',
	'BbCatMonitoring'     => 'Controle',
	'BbCatFeedReader'     => 'RSS lezer (Beta)',
	'BbCatShoppingCrawler'=> 'Shopping Crawler',
	'BbCatCloudInfra'     => 'Cloud Infrastructuur',
	'BbCatSecurityScanner'=> 'Beveiligings Scanner',
	'BbCatResidentialProxy'=> 'Residential Proxy',
	'BbCatMalicious'      => 'Kwaadaardig',
	'BbCatUnknown'        => 'onbekend',

	// === on_demand_ip_refresh cloud providers ===
	'BbCloudProviderAws'        => 'AWS',
	'BbCloudProviderCloudflare' => 'Cloudflare',
	'BbCloudProviderFastly'     => 'Snel',
	'BbCloudProviderGcp'        => 'Google Cloud',
	'BbCloudProvidersInfo'      => 'Limiteer op-demand verversen naar specifieke aanbieders. Leeg = alle vier.',

	// === Log retention ===
	'BbAdvLogRetention'              => 'Log bewaring',
	'BbLogRetentionEnabled'          => 'Schakel automatische log opschonen in',
	'BbLogRetentionEnabledInfo'      => 'Periodiek logboekrijen ouder dan het bewaarvenster verwijderen. Aanbevolen voor sites zonder cron toegang.',
	'BbLogRetentionMaxAgeDays'       => 'Retentie venster (dagen)',
	'BbLogRetentionMaxAgeDaysInfo'   => 'Rijen ouder dan dit worden verwijderd. Standaard: 7. Gebruikelijke waarden: 7, 14, 30, 90.',
	'BbLogRetentionMaxRows'          => 'Maximum aantal rijen (0 = geen cap)',
	'BbLogRetentionMaxRowsInfo'      => 'Indien gezet, oudste rijen worden verwijderd wanneer de tabel deze grootte overschrijdt, ongeacht leeftijd. Handig voor high-traffic sites.',
	'BbLogRetentionProbability'       => 'Waarschijnlijkheid noemer (1 in N)',
	'BbLogRetentionProbabilityInfo'   => '1 in N verzoek controleert de staleness poort. Hoger = minder DB belasting. Standaard: 1000.',
	'BbLogRetentionMinInterval'      => 'Minimale interval tussen schoonmaak (seconden)',
	'BbLogRetentionMinIntervalInfo'  => 'Hard vloer op schoonmaakfrequentie. Standaard: 21600 (6h).',
	'BbLogRetentionLockTtl'          => 'Opschonen lock TTL (seconden)',
	'BbLogRetentionLockTtlInfo'      => 'Hoe lang de schoonmaakmutex wordt gehouden. Standaard: 600 (10 min).',

	// === misc new fields ===
	'BbDnsVerificationEnabled'  => 'DNS-verificatie inschakelen',
	'BbDnsVerificationInfo'     => 'Controleer boteclaims (bijv. Googlebot) door reverse-DNS-zoekopdracht te doen. Catches spoofed bots.',
	'BbDnsTimeoutMs'            => 'Time-out DNS-zoekopdracht (ms)',
	'BbDnsPositiveTtl'          => 'Positieve cache TTL (seconden)',
	'BbDnsNegativeTtl'          => 'Negatieve cache TTL (seconden)',
	'BbDnsRequireForward'       => 'Vereis forward-confirmatie (PTR + A record match)',
	'BbDnsRequireForwardInfo'   => 'Vangt PTR vervalsing, maar voegt latentie en IPv6 FP risico toe.',

	'BbHeadRefererExemptPaths'  => 'HEAD vrijgestelde paden (één per lijn)',
	'BbHeadRefererExemptInfo'   => 'Paden waar HEAD zonder Referer legaal is (bv. /api/, /wp-json/).',

	'BbAssetExtensionsLabel'    => 'Te beschermen assetextensies (één per regel)',
	'BbAssetExtensionsInfo'     => 'Bestandstypen bekeken voor direct scrapen zonder pagina-lading.',

	'BbOnDemandBotIds'          => 'Bot IDs om te vernieuwen (leeg = alles)',
	'BbOnDemandBotIdsInfo'      => 'Verversen beperken tot specifieke bots. Laat leeg om alle geregistreerde bots te vernieuwen.',
	'BbOnDemandProbability'     => 'Waarschijnlijkheid noemer (1 in N)',
	'BbOnDemandMinAge'          => 'Min. cache leeftijd (seconden)',
	'BbOnDemandLockTtl'         => 'TTL (seconden) vergrendelen',
	'BbOnDemandCacheTtl'        => 'Cache TTL (seconden)',
	'BbOnDemandFeedTimeout'     => 'Feed Haal time-out op (seconden)',

	'BbDynamicIpTtl'            => 'Cache TTL (seconden)',
	'BbDynamicIpFeeds'          => 'Feeds om te vernieuwen (een per regel)',

	// === Time-window selector / dashboards ===
	'BbLastSeen'             => 'Laatst gezien',
	'BbSeverity'             => 'Ernstigheid',
	'BbStatusBreakdown'      => 'Status verdeling',
	'BbBotBreakdown'         => 'Bot uitsplitsing',
	'BbTopBlocked'           => 'Top geweigerde IPs',
	'BbGeoSummary'           => 'Geografische samenvatting',
	'BbCountry'              => 'Land:',
	'BbAsn'                  => 'ASN',
	'BbVerifiedPct'          => 'Geverifieerd %',
	'BbNoData'               => 'Geen gegevens voor het geselecteerde venster',
	'BbCategory'             => 'categorie',
	'BbResponseTime'         => 'Antwoord tijd',
	'BbDateCol'              => 'Tijd / IP / Status',
	'BbSelectRow'            => 'Rij selecteren',

	// === Active-filter chips ===
	'BbChipSlow'             => 'Alleen langzaam',
	'BbChipDate'             => 'Date range',
	'BbChipResolved'         => 'Opgelost',
	'BbChipStatusCode' => 'Status code',
	'BbChipIp'         => 'IP-adres',
	'BbChipUa'         => 'UA',
	'BbChipUri'        => 'URI',
	'BbChipJa3'        => 'JA3',
	'BbChipAsn'        => 'ASN',
	'BbChipCountry'    => 'Land:',

	// === Manage view additions ===
	'BbViewHeaders'          => 'Koppen bekijken',
	'BbViewBody'             => 'Bekijk het lichaam',
	'BbViewContentLabel'     => 'Inhoud',
	'BbViewModeFull'         => 'Volledig (altijd getoond)',
	'BbViewModeTeaser'       => 'Teaser (klik om uit te breiden)',
	'BbViewModeHidden'       => 'Verborgen (show op vraag)',
	'BbHide'                 => 'verberg',
	'BbChars'                => 'tekens',

	// === Custom rules ===
	'BbCustomRules'                => 'Aangepaste regels',
	'BbCustomRulesLabel'           => 'Aangepaste regels (een JSON-object per regel)',
	'BbCustomRulesInfo'            => 'Elke regel is een JSON-object met sleutels: type (ipexceeds ua_regexA3ua_contains_containsude landheader), waarde, actie (sta goed), waarde, actie (toelatend block² challenge log), en id. Bijvoorbeeld: {"type":"ua_regex","value":"/Googlebot/i","action":"log","id":"id":"audit_googlebot"}',

	// === Body scan ===
	'BbBodyScanSkipFields'         => 'Body scan overgeslagen velden',
	'BbBodyScanSkipFieldsInfo'     => 'Eén veldnaam per regel. De vermelde velden worden overgeslagen tijdens SQL/XSS body inspectie.',

	// === Advanced filters ===
	'BbAdvancedFilters'     => 'Geavanceerde filters',
	'BbDateFrom'            => 'van',
	'BbDateTo'              => 'tot',
	'BbJa3'                 => 'JA3 hash',
	'BbSlowOnly'            => 'Alleen trage verzoeken (>1s)',

	// === Resolved workflow ===
	'BbResolvedActive'      => 'Alleen actief',
	'BbResolvedOnly'        => 'Alleen opgelost',
	'BbResolvedAll'         => 'Actief + opgelost',
	'BbResolved'            => 'opgelost',
	'BbActionResolve'       => 'oplossen',
	'BbActionUnresolve'     => 'onopgelost',
	'BbRowResolved'         => 'Log invoer gemarkeerd als opgelost',
	'BbRowUnresolved'       => 'Log invoer gemarkeerd als onopgelost',

	// === Bulk actions ===
	'BbBulkDeleteSelected'      => 'Verwijder geselecteerde items',
	'BbBulkWhitelistSelected'   => 'Whitelist IPs',
	'BbBulkResolveSelected'     => 'Markeer afgehandeld',
	'BbBulkUnresolveSelected'   => 'Markeren als onopgelost',
	'BbBulkHint'                => 'Tik rijen eerst, klik dan op een actie.',
	'BbNoItemsSelected'         => 'Geen items geselecteerd',
	'BbBulkDeleted'             => '%1 log items verwijderd',
	'BbBulkWhitelisted'         => '%1 IPs toegevoegd aan de whitelist',
	'BbBulkResolved'            => '%1 items gemarkeerd als opgelost',
	'BbBulkUnresolved'          => '%1 items gemarkeerd als onopgelost',
	'BbMarkAll'                 => 'Markeer alle rijen op deze pagina',
	'BbMarkNone'                => 'Deselecteer alle rijen',

	'BbBulkFailed'              => 'Kon de geselecteerde rijen niet bijwerken. Controleer de database of probeer het opnieuw.',
	'BbBulkWhitelistedNone'     => 'Geen nieuwe IP-adressen toegevoegd - alle geselecteerde IP-adressen stonden al op de whitelist.',

	// === Verified badge ===
	'BbVerified'             => 'geverifieerd',
	'BbUnverified'           => 'niet-geverifieerd',

	// === ResultCode enum mapping (BbStatus_<code>) ===
	'BbStatus_allowed'                    => 'Verzoek toegestaan',
	'BbStatus_blocked.bot'                => 'Bekende bot geblokkeerd',
	'BbStatus_blocked.ai_crawler'         => 'AI crawler geblokkeerd',
	'BbStatus_blocked.seo_crawler'        => 'SEO crawler geblokkeerd',
	'BbStatus_blocked.malicious_ua'       => 'Kwaadaardige User-Agent',
	'BbStatus_blocked.attack_pattern'     => 'Aanval payload gedetecteerd',
	'BbStatus_blocked.dnsbl'              => 'DNSBL wedstrijd',
	'BbStatus_blocked.httpbl'             => 'http:BL overeenkomst',
	'BbStatus_blocked.behavioral'         => 'Gedrag anomalie',
	'BbStatus_blocked.fingerprint'        => 'Slechte vingerafdruk',
	'BbStatus_blocked.rate_limit'         => 'Tarief limiet overschreden',
	'BbStatus_blocked.custom_rule'        => 'Aangepaste regel overeenkomst',
	'BbStatus_blocked.geoip'              => 'GeoIP blok',
	'BbStatus_blocked.residential_proxy'  => 'Residentiële proxy geblokkeerd',
	'BbStatus_challenge.required'         => 'Uitdaging vereist',
	'BbStatus_challenge.failed'           => 'Uitdaging mislukt',
	'BbStatus_error.internal'             => 'Interne fout',
	'BbStatus_error.configuration'        => 'Configuratie fout',

	// === Time-window tabs ===
	'BbWindow24h' => 'Afgelopen 24 uur',
	'BbWindow7d'  => 'Afgelopen 7 dagen',
	'BbWindow30d' => 'Laatste 30 dagen',
	'BbWindowAll' => 'Gehele tijd',

	// === Preset dropdown ===
	'BbPresetMinimal'        => 'Minimaal (standaard)',
	'BbPresetFull'           => 'Volledig',
	'BbPresetVerifiedOnly'   => 'Alleen geverifieerd',
	'BbPresetNoAi'           => 'No-AI',
	'BbPresetNoSeo'          => 'No-SEO',
	'BbPresetEuOnly'         => 'alleen EU-',
	'BbPresetHumanOnly'      => 'Alleen-mens',
	'BbPresetCustom'         => 'Aangepaste',

	// === Strictness dropdown ===
	'BbStrictnessMonitorOnly' => 'Alleen monitoren',
	'BbStrictnessNormal'      => 'normaal',
	'BbStrictnessStrict'      => 'Strikt',

	// === Challenge provider dropdown ===
	'BbChallengeProviderBuiltin'   => 'Builtin (PoW)',
	'BbChallengeProviderHcaptcha'  => 'hCaptcha',
	'BbChallengeProviderRecaptcha' => 'reCAPTCHA v3',
	'BbChallengeProviderTurnstile' => 'Cloudflare Draai',

	// === Head Request Detection (newly translated form labels) ===
	'BbEnableHeadRequest'        => 'Schakel detectie hoofdverzoek in',
	'BbHeadRequireReferer'       => 'Vereis Referentie op HEAD',
	'BbHeadFloodThreshold'       => 'Overgangsdrempelwaarde (per sessie)',
	'BbHeadProbeThreshold'       => 'Probe drempelwaarde (per IP / 5min)',

	// === Asset Scraping (newly translated form labels) ===
	'BbEnableAssetScraping'        => 'Schakel asset scraping detectie in',
	'BbAssetNoRefererThreshold'    => 'Drempelwaarde zonder referer (per IP / uur)',
	'BbAssetOnlySessionThreshold'  => 'Drempelwaarde \'Alleen Asset-\' sessie',
	'BbAssetPatternThreshold'      => 'Sequentiële patroonwaarde (per IP / 5min)',

	// === Dynamic IP Ranges ===
	'BbEnableDynamicIpRanges' => 'Inschakelen van dynamisch IP-bereik',

	// === On-demand IP Refresh ===
	'BbEnableOnDemandRefresh'    => 'On-demand vernieuwen inschakelen',
	'BbOnDemandRefreshInfo'      => 'Vernieuw het IP-bereik cache tijdens verzoeken. Gebruik dit wanneer u geen cron toegang heeft.',
	'BbOnDemandBotIdsPlaceholder' => 'googlebot, gptbot, claude…',

	// === Fingerprint field labels ===
	'BbFpBadJa3'          => 'Slechte JA3',
	'BbFpBadH2'           => 'Slechte H2',
	'BbFpBotHeaderOrders' => 'Bot Header Orders',
	'BbFpExpectedJa3'     => 'Verwachte JA3',

	// === Bot category list titles + hint ===
	'BbListBlocked'   => 'Geblokkeerd',
	'BbListChallenge' => 'Uitdaging (CAPTCHA)',
	'BbListLogOnly'   => 'Alleen loggen (geen handhaving)',
	'BbListAllowed'   => 'Expliciet toegestaan',
	'BbListHint'      => 'Categorieën in deze lijst krijgen de actie ongeacht de standaard categorie.',

	// === Bot category dropdown labels (manage filter) ===
	'BbCatSearchEngine'    => 'Motor zoeken',
	'BbCatAiCrawler'       => 'AI Crawler',
	'BbCatSocialCrawler'   => 'Sociale Crawler',
	'BbCatSeoCrawler'      => 'SEO Crawler',
	'BbCatArchiveCrawler'  => 'Archiveer Crawler',
	'BbCatMonitoring'      => 'Controle',
	'BbCatFeedReader'      => 'RSS lezer (Beta)',
	'BbCatShoppingCrawler' => 'Shopping Crawler',
	'BbCatCloudInfra'      => 'Cloud Infrastructuur',
	'BbCatSecurityScanner' => 'Beveiligings Scanner',
	'BbCatResidentialProxy'=> 'Residential Proxy',
	'BbCatMalicious'       => 'Kwaadaardig',
	'BbCatUnknown'         => 'onbekend',

	// === Placeholders ===
	'BbJa3Placeholder' => '32-char hash',

	// === Summary severity group labels ===
	'BbSevAttackPatterns' => 'Patronen aanvallen',
	'BbSevChallenges'     => 'Uitdagingen uitgegeven',
	'BbSevPermitted'      => 'Toegestand',
	'BbSevErrors'         => 'Foutmeldingen',

	// === Summary table column (was used but missing from set) ===
	'BbCategories' => 'Categoriechar@@0n',

	'BbResultBreakdown'    => 'Uitsplitsing resultaat',
	'BbBreakdownBlocked'   => 'Geblokkeerd',
	'BbBreakdownMonitored' => 'Gecontroleerd',
	'BbBreakdownAllowed'   => 'Toegestaan',
	'BbViewAllInLog'       => 'Bekijk alles in het logboek',
	'BbAllowedHintVerbose' => 'Toegestane verkeer is alleen aangemeld als uitgebreide logboekregistratie is ingeschakeld. Schakel logging_mode=verbose in Instellingen om te zien welke passes doorlopen.',

];
