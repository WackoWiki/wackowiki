<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Základní funkce',
		'preferences'	=> 'Předvolby',
		'content'		=> 'Obsah',
		'users'			=> 'Uživatelé',
		'maintenance'	=> 'Údržba',
		'messages'		=> 'Zprávy',
		'extension'		=> 'Rozšíření',
		'database'		=> 'Databáze',
	],

	// Admin panel
	'AdminPanel'				=> 'Ovládací panel administrace',
	'RecoveryMode'				=> 'Režim Recovery',
	'Authorization'				=> 'Autorizace',
	'AuthorizationTip'			=> 'Zadejte prosím administrativní heslo (ujistěte se, že ve vašem prohlížeči jsou povoleny cookies).',
	'NoRecoveryPassword'		=> 'Administrativní heslo není zadáno!',
	'NoRecoveryPasswordTip'		=> 'Poznámka: Absence administrativního hesla ohrožuje bezpečnost! Zadejte hash hesla do konfiguračního souboru a spusťte program znovu.',

	'ErrorLoadingModule'		=> 'Chyba při načítání modulu %1: neexistuje.',

	'ApHomePage'				=> 'Domovská stránka',
	'ApHomePageTip'				=> 'Ukončit správu systému a otevřít domovskou stránku',
	'ApLogOut'					=> 'Odhlásit se',
	'ApLogOutTip'				=> 'Ukončit správu systému a odhlásit se z webu',

	'TimeLeft'					=> 'Zbývající čas:  %1 minut',
	'ApVersion'					=> 'verze',

	'SiteOpen'					=> 'Otevřít',
	'SiteOpened'				=> 'stránka otevřena',
	'SiteOpenedTip'				=> 'Web je otevřený',
	'SiteClose'					=> 'Zavřít',
	'SiteClosed'				=> 'web uzavřen',
	'SiteClosedTip'				=> 'Stránka je uzavřena',

	'System'					=> 'Systém',

	// Generic
	'Cancel'					=> 'Zrušit',
	'Add'						=> 'Přidat',
	'Edit'						=> 'Upravit',
	'Remove'					=> 'Odebrat',
	'Enabled'					=> 'Povoleno',
	'Disabled'					=> 'Zakázáno',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'Admin',
	'Min'						=> 'Min.',
	'Max'						=> 'Max.',

	'MiscellaneousSection'		=> 'Ostatní',
	'MainSection'				=> 'Obecné možnosti',

	'DirNotWritable'			=> 'Adresář %1 není zapisovatelný.',
	'FileNotWritable'			=> 'Soubor %1 není zapisovatelný.',

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
		'name'		=> 'Základní',
		'title'		=> 'Základní nastavení',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Vzhled',
		'title'		=> 'Nastavení vzhledu',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-mailová adresa',
		'title'		=> 'Nastavení e-mailu',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Synchronizace',
		'title'		=> 'Nastavení synchronizace',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtr',
		'title'		=> 'Nastavení filtru',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Předchozí',
		'title'		=> 'Možnosti formátování',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Oznámení',
		'title'		=> 'Nastavení oznámení',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Stránky',
		'title'		=> 'Stránky a parametry lokality',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Práva',
		'title'		=> 'Nastavení oprávnění',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Zabezpečení',
		'title'		=> 'Nastavení bezpečnostních subsystémů',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Systém',
		'title'		=> 'Možnosti systému',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Nahrát',
		'title'		=> 'Nastavení příloh',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Odstraněno',
		'title'		=> 'Nově odstraněný obsah',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Přidat, upravit nebo odebrat výchozí položky nabídky',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Záloha',
		'title'		=> 'Zálohování dat',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Opravit',
		'title'		=> 'Opravit a optimalizovat databázi',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Obnovit',
		'title'		=> 'Obnovení zálohovaných dat',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Hlavní menu',
		'title'		=> 'Správa WackoWiki',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Nesrovnalosti',
		'title'		=> 'Oprava nesrovnalostí v údajích',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Synchronizace dat',
		'title'		=> 'Synchronizuji data',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Hromadný e-mail',
		'title'		=> 'Hromadný e-mail',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Systémová zpráva',
		'title'		=> 'Systémové zprávy',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Systémové informace',
		'title'		=> 'Systémové informace',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Systémový protokol',
		'title'		=> 'Protokol systémových událostí',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistiky',
		'title'		=> 'Zobrazit statistiky',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Špatné chování',
		'title'		=> 'Špatné chování',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Schválit',
		'title'		=> 'Schválení registrace uživatele',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Skupiny',
		'title'		=> 'Správa skupin',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Uživatelé',
		'title'		=> 'Správa uživatelů',
	],

	// Main module
	'MainNote'					=> 'Poznámka: Doporučuje se, aby byl pro administrativní údržbu dočasně zablokován přístup na dané místo.',

	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'Vymazat všechny relace',
	'PurgeSessionsConfirm'		=> 'Jste si jisti, že chcete odstranit všechny relace? Tímto se odhlásí všichni uživatelé.',
	'PurgeSessionsExplain'		=> 'Vymazat všechny relace. Odhlásí se všechny uživatele zkrácením tabulky autora tokenu.',
	'PurgeSessionsDone'			=> 'Relace byly úspěšně odstraněny.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Aktualizováno základní nastavení',
	'LogBasicSettingsUpdated'	=> 'Aktualizováno základní nastavení',

	'SiteName'					=> 'Název stránky:',
	'SiteNameInfo'				=> 'Název tohoto webu. Zobrazí se v názvu prohlížeče, záhlaví motivu, e-mailové upozornění, atd.',
	'SiteDesc'					=> 'Popis stránky:',
	'SiteDescInfo'				=> 'Doplněk k názvu stránky, který se objeví v záhlaví stránek. Vysvětlete, pár slov, o čem tato stránka je.',
	'AdminName'					=> 'Admin stránky:',
	'AdminNameInfo'				=> 'Uživatelské jméno jednotlivce, který je odpovědný za celkovou podporu webu. Toto jméno se nepoužívá k určení přístupových práv, ale je žádoucí, aby odpovídal názvu hlavního správce lokality.',

	'LanguageSection'			=> 'Jazyk',
	'DefaultLanguage'			=> 'Výchozí jazyk:',
	'DefaultLanguageInfo'		=> 'Určuje jazyk zpráv zobrazených neregistrovaným hostům, stejně jako lokální nastavení.',
	'MultiLanguage'				=> 'Podpora pro více jazyků:',
	'MultiLanguageInfo'			=> 'Povolte možnost vybrat jazyk na základě jednotlivých stránek.',
	'AllowedLanguages'			=> 'Povolené jazyky:',
	'AllowedLanguagesInfo'		=> 'Doporučuje se vybrat pouze sadu jazyků, které chcete použít, jinak budou vybrány všechny jazyky.',

	'CommentSection'			=> 'Komentáře',
	'AllowComments'				=> 'Povolit komentář:',
	'AllowCommentsInfo'			=> 'Povolit komentáře pouze pro hosty nebo registrované uživatele nebo je zakázat na celém webu.',
	'SortingComments'			=> 'Řazení komentářů:',
	'SortingCommentsInfo'		=> 'Změní pořadí komentářů stránky, buď s nejnovějšími NEBO nejstaršími komentáři nahoře.',

	'ToolbarSection'			=> 'Panel nástrojů',
	'CommentsPanel'				=> 'Panel pro poznámky:',
	'CommentsPanelInfo'			=> 'Výchozí zobrazení komentářů v dolní části stránky.',
	'FilePanel'					=> 'Panel souborů:',
	'FilePanelInfo'				=> 'Výchozí zobrazení příloh v dolní části stránky.',
	'TagsPanel'					=> 'Panel štítků:',
	'TagsPanelInfo'				=> 'Výchozí zobrazení panelu štítků v dolní části stránky.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Zobrazit trvalý odkaz:',
	'ShowPermalinkInfo'			=> 'Výchozí zobrazení trvalého odkazu pro aktuální verzi stránky.',
	'TocPanel'					=> 'Obsah panelu:',
	'TocPanelInfo'				=> 'Výchozí zobrazovací tabulka obsahu panelu stránky (může potřebovat podporu v šablonách).',
	'SectionsPanel'				=> 'Panel oddílů:',
	'SectionsPanelInfo'			=> 'Ve výchozím nastavení zobrazit panel sousedních stránek (vyžaduje podporu v šabloně).',
	'DisplayingSections'		=> 'Zobrazení sekcí:',
	'DisplayingSectionsInfo'	=> 'Když jsou nastaveny předchozí možnosti, zda se zobrazí pouze podstránky stránky (<em>lower</em>), pouze soused (<em>top</em>), obojí nebo jiný (<em>strom</em>).',
	'MenuItems'					=> 'Položky nabídky:',
	'MenuItemsInfo'				=> 'Výchozí počet zobrazených položek nabídky (může potřebovat podporu v šablonách).',

	'HandlerSection'			=> 'Handlers',
	'HideRevisions'				=> 'Skrýt revize:',
	'HideRevisionsInfo'			=> 'Výchozí zobrazení revizí stránky.',
	'AttachmentHandler'			=> 'Povolit zpracování příloh:',
	'AttachmentHandlerInfo'		=> 'Umožňuje zobrazení obsluhy příloh.',
	'SourceHandler'				=> 'Povolit obsluhu zdrojového zařízení:',
	'SourceHandlerInfo'			=> 'Umožňuje zobrazení obsluhy zdroje.',
	'ExportHandler'				=> 'Povolit XML export handler:',
	'ExportHandlerInfo'			=> 'Umožňuje zobrazení správce exportu XML.',

	'DiffModeSection'			=> 'Rozdílové režimy',
	'DefaultDiffModeSetting'	=> 'Výchozí režim rozdílů:',
	'DefaultDiffModeSettingInfo'=> 'Předvolený režim rozdílů.',
	'AllowedDiffMode'			=> 'Povolené režimy rozdílů:',
	'AllowedDiffModeInfo'		=> 'Doporučuje se vybrat pouze sadu různých režimů, které chcete použít, jinak jsou vybrány všechny režimy rozdílů.',
	'NotifyDiffMode'			=> 'Oznámit rozdílový režim:',
	'NotifyDiffModeInfo'		=> 'Rozdílný režim používaný pro oznámení v těle e-mailu.',

	'EditingSection'			=> 'Úprava',
	'EditSummary'				=> 'Upravit shrnutí:',
	'EditSummaryInfo'			=> 'Zobrazí shrnutí změn v režimu úprav.',
	'MinorEdit'					=> 'Malá úprava:',
	'MinorEditInfo'				=> 'Povolí možnost menších úprav v režimu úprav.',
	'SectionEdit'				=> 'Editace sekcí:',
	'SectionEditInfo'			=> 'Umožňuje úpravy pouze sekce stránky.',
	'ReviewSettings'			=> 'Recenze:',
	'ReviewSettingsInfo'		=> 'Umožňuje možnost recenze v režimu úprav.',
	'PublishAnonymously'		=> 'Povolit anonymní publikování:',
	'PublishAnonymouslyInfo'	=> 'Povolit uživatelům publikovat anonymně (skrýt jméno).',

	'DefaultRenameRedirect'		=> 'Při přejmenování vytvořte přesměrování:',
	'DefaultRenameRedirectInfo'	=> 'Ve výchozím nastavení nabídněte nastavení přesměrování na starou adresu přejmenované stránky.',
	'StoreDeletedPages'			=> 'Ponechat smazané stránky:',
	'StoreDeletedPagesInfo'		=> 'Když odstraníte stránku, komentář nebo soubor, ponechte ji ve zvláštní sekci, kde bude po určitou dobu k dispozici k přezkoumání a zpětnému získání (jak je popsáno níže).',
	'KeepDeletedTime'			=> 'Čas uložení odstraněných stránek:',
	'KeepDeletedTimeInfo'		=> 'Doba ve dnech. Má smysl pouze s předchozí možností. Použijte nulu, abyste zajistili, že entity nebudou nikdy odstraněny (v tomto případě může správce ručně vymazat "košík").',
	'PagesPurgeTime'			=> 'Doba ukládání revizí stránky:',
	'PagesPurgeTimeInfo'		=> 'Automaticky odstraní starší verze během daného počtu dní. Pokud zadáte nulu, starší verze nebudou odstraněny.',
	'EnableReferrers'			=> 'Povolit referery:',
	'EnableReferrersInfo'		=> 'Umožňuje tvorbu a zobrazení externích refererů.',
	'ReferrersPurgeTime'		=> 'Doba uložení refererů:',
	'ReferrersPurgeTimeInfo'	=> 'Ponechat historii odkazů na externí stránky ne déle než daný počet dní. Použijte nulu k zajištění toho, aby odkazující nebyli nikdy smazáni (ale pro aktivně navštívené stránky to může vést k přetečení databáze).',
	'EnableCounters'			=> 'Počet zásahů:',
	'EnableCountersInfo'		=> 'Umožňuje na stránce čítače stisknutí a umožňuje zobrazení jednoduchých statistik. Zobrazení vlastníka stránky se nepočítá.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Nastavte výchozí nastavení synchronizace webu pro vaše stránky.',
	'SyndicationSettingsUpdated'	=> 'Aktualizováno nastavení synchronizace.',

	'FeedsSection'				=> 'Zdroje',
	'EnableFeeds'				=> 'Povolit kanály:',
	'EnableFeedsInfo'			=> 'Zapne nebo vypne RSS kanály pro celou wiki.',
	'XmlChangeLink'				=> 'Změní režim odkazu kanálu:',
	'XmlChangeLinkInfo'			=> 'Určuje, kam XML mění položky kanálu.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'pohled na rozdíl',
		'2'		=> 'revidovaná stránka',
		'3'		=> 'seznam revizí',
		'4'		=> 'aktuální stránka',
	],

	'XmlSitemap'				=> 'XML sitemap:',
	'XmlSitemapInfo'			=> 'Vytvoří XML soubor nazvaný %1 uvnitř složky xml. Cestu k mapě stránek v souboru robots.txt můžete přidat do kořenového adresáře takto:',
	'XmlSitemapGz'				=> 'Komprese XML sitemap',
	'XmlSitemapGzInfo'			=> 'Pokud chcete, můžete zkompilovat textový soubor mapy stránek pomocí gzipu pro snížení požadavků na šířku pásma.',
	'XmlSitemapTime'			=> 'Čas vytvoření mapy XML sitemap:',
	'XmlSitemapTimeInfo'		=> 'Vygeneruje mapu stránek pouze jednou za daný počet dní. Nastavte na nulu pro generování každé změny stránky.',

	'SearchSection'				=> 'Hledat',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Vytvoří soubor s popisem OpenSearch ve složce XML a v hlavičce HTML umožní automatické zobrazení vyhledávacího pluginu.',
	'SearchEngineVisibility'	=> 'Blokovat vyhledávače (viditelnost vyhledávače):',
	'SearchEngineVisibilityInfo'=> 'Blokujte vyhledávače, ale povolte běžné návštěvníky. Přepíše nastavení stránky. <br>Odradit vyhledávače od indexování tohoto webu. Je na vyhledávačích, aby tento požadavek splnili.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Ovládání výchozích nastavení zobrazení vašeho webu.',
	'AppearanceSettingsUpdated'	=> 'Aktualizováno nastavení vzhledu.',

	'LogoOff'					=> 'Vypnuto',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo a název',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Logo stránky:',
	'SiteLogoInfo'				=> 'Vaše logo se obvykle zobrazí v levém horním rohu aplikace. Maximální velikost je 2 MiB. Optimální rozměry jsou 255 pixelů široké, 55 pixelů.',
	'LogoDimensions'			=> 'Rozměry loga:',
	'LogoDimensionsInfo'		=> 'Šířka a výška zobrazeného loga.',
	'LogoDisplayMode'			=> 'Režim zobrazení loga:',
	'LogoDisplayModeInfo'		=> 'Určuje vzhled loga. Výchozí nastavení je vypnuto.',

	'FaviconSection'			=> 'Oblíbená ikona',
	'SiteFavicon'				=> 'Oblíbené stránky:',
	'SiteFaviconInfo'			=> 'Ikona zkratky nebo oblíbená je zobrazena v adresním řádku, záložkách a záložkách většiny prohlížečů. To přepíše oblíbenost šablony.',
	'SiteFaviconTooBig'			=> 'Favicon je větší než 64 x 64 px.',
	'ThemeColor'				=> 'Barva motivu pro adresní řádku:',
	'ThemeColorInfo'			=> 'Prohlížeč nastaví barvu adresního řádku každé stránky podle uvedené barvy CSS.',

	'LayoutSection'				=> 'Rozložení',
	'Theme'						=> 'Motiv:',
	'ThemeInfo'					=> 'Šablona designu, kterou web používá ve výchozím nastavení.',
	'ResetUserTheme'			=> 'Resetovat všechny uživatelské motivy:',
	'ResetUserThemeInfo'		=> 'Resetuje všechny uživatelské motivy. Varování: Tato akce vrátí všechny uživatelsky vybrané motivy do globálního výchozího motivu.',
	'SetBackUserTheme'			=> 'Vrátit všechny uživatelské motivy do šablony %1.',
	'ThemesAllowed'				=> 'Povolená témata:',
	'ThemesAllowedInfo'			=> 'Vyberte povolené motivy, které si uživatel může vybrat. V opačném případě jsou povoleny všechny dostupné motivy.',
	'ThemesPerPage'				=> 'Motivy na stránku:',
	'ThemesPerPageInfo'			=> 'Povolit motivy na stránku, které si vlastník stránky může vybrat prostřednictvím vlastností stránky.',

	// System settings
	'SystemSettingsInfo'		=> 'Skupina parametrů odpovědných za jemné ladění webu. Neměňte je, pokud si nejste jisti jejich akcemi.',
	'SystemSettingsUpdated'		=> 'Aktualizováno systémové nastavení',

	'DebugModeSection'			=> 'Režim ladění',
	'DebugMode'					=> 'Režim ladění:',
	'DebugModeInfo'				=> 'Extrahování a vkládání telemetrických dat o spouštěcí době aplikace. Upozornění: Režim plné podrobnosti ukládá vyšší požadavky na přidělenou paměť, zejména pro operace náročné na zdroje, jako je zálohování a obnova databáze.',
	'DebugModes'	=> [
		'0'		=> 'ladění je vypnuté',
		'1'		=> 'pouze celková doba provádění',
		'2'		=> 'plný pracovní úvazek',
		'3'		=> 'úplné podrobnosti (DBMS, keš atd.)',
	],
	'DebugSqlThreshold'			=> 'Prahová hodnota RDBMS:',
	'DebugSqlThresholdInfo'		=> 'V podrobném režimu ladění nahlaste pouze dotazy, které trvají déle, než je zadaný počet sekund.',
	'DebugAdminOnly'			=> 'Uzavřená diagnostika:',
	'DebugAdminOnlyInfo'		=> 'Zobrazit ladící data programu (a DBMS) pouze pro správce.',

	'CachingSection'			=> 'Možnosti ukládání do cache',
	'Cache'						=> 'Vykreslené stránky mezipaměti:',
	'CacheInfo'					=> 'Uložte vykreslené stránky do místní mezipaměti pro urychlení následného spuštění. Platné pouze pro neregistrované návštěvníky.',
	'CacheTtl'					=> 'Čas do času pro uložené stránky:',
	'CacheTtlInfo'				=> 'Mezipaměť stránek ne více než zadaný počet sekund.',
	'CacheSql'					=> 'Dotazy DBMS do mezipaměti:',
	'CacheSqlInfo'				=> 'Udržujte místní mezipaměť výsledků některých dotazů souvisejících s SQL zdroji.',
	'CacheSqlTtl'				=> 'Čas do času pro dotazy SQL v mezipaměti:',
	'CacheSqlTtlInfo'			=> 'Výsledek SQL dotazů maximálně po zadaný počet sekund. Hodnoty větší než 1200 nejsou žádoucí.',

	'LogSection'				=> 'Nastavení protokolu',
	'LogLevelUsage'				=> 'Použít protokolování:',
	'LogLevelUsageInfo'			=> 'Minimální priorita událostí zaznamenaných v záznamu.',
	'LogThresholds'	=> [
		'0'		=> 'neuchovávat deník',
		'1'		=> 'pouze kritická úroveň',
		'2'		=> 'od nejvyšší úrovně',
		'3'		=> 'od vysoké',
		'4'		=> 'v průměru',
		'5'		=> 'z nízkých',
		'6'		=> 'minimální úroveň',
		'7'		=> 'zaznamenat vše',
	],
	'LogDefaultShow'			=> 'Režim zobrazení:',
	'LogDefaultShowInfo'		=> 'Minimální prioritní události zobrazené ve výchozím nastavení v logu.',
	'LogModes'	=> [
		'1'		=> 'pouze kritická úroveň',
		'2'		=> 'od nejvyšší úrovně',
		'3'		=> 'z vysoké úrovně',
		'4'		=> 'průměr',
		'5'		=> 'z nízkého',
		'6'		=> 'z minimální úrovně',
		'7'		=> 'zobrazit vše',
	],
	'LogPurgeTime'				=> 'Doba uložení logu:',
	'LogPurgeTimeInfo'			=> 'Odstranit záznam událostí po zadaném počtu dní.',

	'PrivacySection'			=> 'Soukromí',
	'AnonymizeIp'				=> 'Anonymizujte IP adresy uživatelů:',
	'AnonymizeIpInfo'			=> 'Případně anonymizovat IP adresy (tj. stránky, revize nebo odkazující adresy).',

	'ReverseProxySection'		=> 'Reverzní proxy',
	'ReverseProxy'				=> 'Použít reverzní proxy:',
    'ReverseProxyInfo'			=> 
    'Povolte toto nastavení pro určení správné IP adresy vzdáleného klienta na základě zkoumání informací uložených v hlavičkách X-Forwarded-For headers. Hlavičky X-Forwarded-For jsou standardním mechanismem pro identifikaci klientských systémů spojujících přes reverzní proxy server, jako je Squid nebo Pound. Reverzní proxy servery jsou často využívány ke zlepšení výkonu silně navštívených stránek a mohou také poskytovat další výhody v mezipaměti stránek, zabezpečení nebo šifrování. Pokud tato instalace WackoWiki funguje za reverzním proxy, toto nastavení by mělo být povoleno tak, aby byly do systému řízení relací WackoWiki zachyceny správné informace IP adresy, logování, statistiky a správy přístupu; pokud si nejste jisti tímto nastavením, nemáte reverzní proxy nebo WackoWiki funguje ve sdíleném hostitelském prostředí, toto nastavení by mělo zůstat vypnuto.',
	'ReverseProxyHeader'		=> 'Reverzní proxy header:',
	'ReverseProxyHeaderInfo'	=> 'Nastavte tuto hodnotu, pokud proxy server odešle klientovi IP adresu v záhlaví
									 jiné než X-Forwarded-For. Hlavička "X-Forwarded-For" je čárkou oddělený seznam IP
									 adres; bude použita pouze poslední (vlevo).',
	'ReverseProxyAddresses'		=> 'reverse_proxy přijímá pole IP adres:',
	'ReverseProxyAddressesInfo'	=> 'Each element of this array is the IP address of any of your reverse
									 proxies. If using this array, WackoWiki will trust the information stored
									 in the X-Forwarded-For headers only if the Remote IP address is one of
									 these, that is, the request reaches the web server from one of your
									 reverse proxies. Otherwise, the client could directly connect to
									 your web server by spoofing the X-Forwarded-For headers.',

	'SessionSection'				=> 'Manipulace s relací',
	'SessionStorage'				=> 'Úložiště relace:',
	'SessionStorageInfo'			=> 'Tato volba definuje, kde jsou data relace uložena. Ve výchozím nastavení je vybrána buď soubor nebo databázová relace.',
	'SessionModes'	=> [
		'1'		=> 'Soubor',
		'2'		=> 'Databáze',
	],
	'SessionNotice'					=> 'Oznámení o ukončení relace:',
	'SessionNoticeInfo'				=> 'Označuje příčinu ukončení relace.',
	'LoginNotice'					=> 'Oznámení o přihlášení:',
	'LoginNoticeInfo'				=> 'Zobrazí přihlašovací oznámení.',

	'RewriteMode'					=> 'Použijte <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Pokud váš webový server tuto funkci podporuje, povolte "krásné" URL stránky.<br>
										<span class="cite">Hodnota může být přepsána třídou nastavení při běhu, bez ohledu na to, zda je vypnuto, pokud je zapnuto HTTP_MOD_REWRITE.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parametry odpovědné za kontrolu přístupu a oprávnění.',
	'PermissionsSettingsUpdated'	=> 'Aktualizováno nastavení oprávnění',

	'PermissionsSection'		=> 'Práva a práva',
	'ReadRights'				=> 'Ve výchozím nastavení číst práva:',
	'ReadRightsInfo'			=> 'Výchozí nastavení přiřazeno k kořenovým stránkám, stejně jako stránkám, pro které nelze definovat nadřazené ACL.',
	'WriteRights'				=> 'Napsat práva ve výchozím nastavení:',
	'WriteRightsInfo'			=> 'Výchozí nastavení přiřazeno k kořenovým stránkám, stejně jako stránkám, pro které nelze definovat nadřazené ACL.',
	'CommentRights'				=> 'Práva komentářů ve výchozím nastavení:',
	'CommentRightsInfo'			=> 'Výchozí nastavení přiřazeno k kořenovým stránkám, stejně jako stránkám, pro které nelze definovat nadřazené ACL.',
	'CreateRights'				=> 'Ve výchozím nastavení vytvořit práva na podstránku:',
	'CreateRightsInfo'			=> 'Výchozí přiřazeno k vytvořeným podstránkám.',
	'UploadRights'				=> 'Nahrát práva ve výchozím nastavení:',
	'UploadRightsInfo'			=> 'Výchozí práva pro nahrávání.',
	'RenameRights'				=> 'Globální přejmenování vpravo:',
	'RenameRightsInfo'			=> 'Seznam oprávnění volně přejmenovat (přesunout) stránky.',

	'LockAcl'					=> 'Zamknout všechny přístupy pouze pro čtení:',
	'LockAclInfo'				=> '<span class="cite">Přepíše nastavení ACL pro všechny stránky pouze pro čtení.</span><br>To může být užitečné, pokud je projekt dokončen, chcete ukončit úpravy na určitou dobu z bezpečnostních důvodů nebo jako reakci na mimořádné události na vykořisťování nebo zranitelnost.',
	'HideLocked'				=> 'Skrýt nepřístupné stránky:',
	'HideLockedInfo'			=> 'Pokud uživatel nemá oprávnění ke čtení stránky, skrýt ji v různých seznamech stránek (ale odkaz umístěný v textu bude stále viditelný).',
	'RemoveOnlyAdmins'			=> 'Pouze administrátoři mohou smazat stránky:',
	'RemoveOnlyAdminsInfo'		=> 'Zakázat všechny, kromě správců, možnost odstranit stránky. První limit se vztahuje na majitele běžných stránek.',
	'OwnersRemoveComments'		=> 'Vlastníci stránek mohou odstranit komentáře:',
	'OwnersRemoveCommentsInfo'	=> 'Povolit vlastníkům stránek umírnit komentáře na jejich stránkách.',
	'OwnersEditCategories'		=> 'Vlastníci mohou upravovat kategorie stránek:',
	'OwnersEditCategoriesInfo'	=> 'Umožňuje vlastníkům upravovat seznam kategorií stránek vašeho webu (přidejte slova, odstraňte slova), přiřadí se na stránku.',
	'TermHumanModeration'		=> 'Ukončení platnosti lidstva:',
	'TermHumanModerationInfo'	=> 'Moderátoři mohou upravovat komentáře pouze v případě, že byly vytvořeny ne více než před tímto počtem dní (toto omezení se nevztahuje na poslední komentář v tématu).',

	'UserCanDeleteAccount'		=> 'Povolit uživatelům odstranit jejich účty',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parametry odpovědné za celkovou bezpečnost platformy, bezpečnostní omezení a další subsystémy zabezpečení.',
	'SecuritySettingsUpdated'	=> 'Aktualizováno nastavení zabezpečení',

	'AllowRegistration'			=> 'Registrovat online:',
	'AllowRegistrationInfo'		=> 'Otevřená registrace uživatele. Zakázáním této volby zabráníte bezplatné registraci, správce webu však bude moci uživatele registrovat.',
	'ApproveNewUser'			=> 'Schválit nové uživatele:',
	'ApproveNewUserInfo'		=> 'Umožňuje administrátorům schvalovat uživatele, jakmile se zaregistrují. Na webu se budou moci přihlásit pouze schválení uživatelé.',
	'PersistentCookies'			=> 'Trvalé cookes:',
	'PersistentCookiesInfo'		=> 'Povolit trvalé soubory cookie.',
	'DisableWikiName'			=> 'Zakázat WikiJméno:',
	'DisableWikiNameInfo'		=> 'Zakažte povinné používání WikiName pro uživatele. Povolí registraci uživatelů s tradičními přezdívkami namísto vynuceného CamelCase-formátovaného jména (tj. NameSurname).',
	'UsernameLength'			=> 'Délka uživatelského jména:',
	'UsernameLengthInfo'		=> 'Minimální a maximální počet znaků v uživatelských jménech.',

	'EmailSection'				=> 'E-mailová adresa',
	'AllowEmailReuse'			=> 'Povolit opětovné použití e-mailové adresy:',
	'AllowEmailReuseInfo'		=> 'Se stejnou e-mailovou adresou se mohou zaregistrovat různí uživatelé.',
	'EmailConfirmation'			=> 'Vynutit potvrzení e-mailu:',
	'EmailConfirmationInfo'		=> 'Vyžaduje aby uživatel ověřil svou e-mailovou adresu, než se bude moci přihlásit.',
	'AllowedEmailDomains'		=> 'Povolené e-mailové domény:',
	'AllowedEmailDomainsInfo'	=> 'E-mailové domény oddělené čárkami, např. <code>example.com, local.lan</code> atd. Pokud není zadáno, všechny e-mailové domény jsou povoleny.',
	'ForbiddenEmailDomains'		=> 'Zakázané e-mailové domény:',
	'ForbiddenEmailDomainsInfo'	=> 'Čárkou oddělené zakázané e-mailové domény, např. <code>example.com, local.lan</code> atd. Efektivní pouze pokud je seznam povolených e-mailových domén prázdný.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Povolit captcha:',
	'EnableCaptchaInfo'			=> 'Je-li povoleno, captcha se zobrazí v následujících případech nebo v případě, že je dosaženo bezpečnostního limitu.',
	'CaptchaComment'			=> 'Nový komentář:',
	'CaptchaCommentInfo'		=> 'Jako ochrana proti spamu, neregistrovaní uživatelé musí vyplnit captcha před odesláním komentáře.',
	'CaptchaPage'				=> 'Nová stránka:',
	'CaptchaPageInfo'			=> 'Jako ochrana před spamem, neregistrovaní uživatelé musí vyplnit captcha před vytvořením nové stránky.',
	'CaptchaEdit'				=> 'Upravit stránku:',
	'CaptchaEditInfo'			=> 'Jako ochrana proti spamu, neregistrovaní uživatelé musí vyplnit captcha před editací stránek.',
	'CaptchaRegistration'		=> 'Registrace:',
	'CaptchaRegistrationInfo'	=> 'Jako ochrana před spamem musí neregistrovaní uživatelé před registrací vyplnit captchu.',

	'TlsSection'				=> 'Nastavení TLS',
	'TlsConnection'				=> 'Připojení TLS:',
	'TlsConnectionInfo'			=> 'Použít připojení zabezpečené TLS. <span class="cite">Aktivujte požadovaný TLS certifikát na serveru, jinak ztratíte přístup do admin panelu!</span><br>Také určuje, zda je nastavena vlajka zabezpečení cookie: <code>bezpečná</code> specifikuje, zda by cookies měly být posílány pouze prostřednictvím zabezpečených spojení.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Vynuceně znovu připojit klienta z HTTP k HTTPS. S vypnutou možností může klient prohlížet stránky přes otevřený kanál HTTP.',

	'HttpSecurityHeaders'		=> 'HTTP hlavičky zabezpečení',
	'EnableSecurityHeaders'		=> 'Povolit záhlaví:',
	'EnableSecurityHeadersinfo'	=> 'Nastavte záhlaví zabezpečení (spalování snímků, kliknutí/XSS/CSRF ochrana). <br>CSP může způsobit problémy v určitých situacích (např. během vývoje) nebo při používání pluginů spoléhajících se na externě hostované zdroje, jako jsou obrázky nebo skripty. <br>Zakázání bezpečnostní politiky obsahu je bezpečnostní riziko!',
	'Csp'						=> 'Politika bezpečnosti obsahu (CSP):',
	'CspInfo'					=> 'Konfigurace CSP zahrnuje rozhodování o tom, jaké zásady chcete vynutit, a pak je konfigurovat a používat Content-Security-Policy k vytvoření vašich politik.',
	'PolicyModes'	=> [
		'0'		=> 'vypnuto',
		'1'		=> 'striktní',
		'2'		=> 'vlastní',
	],
	'PermissionsPolicy'			=> 'Zásady oprávnění:',
	'PermissionsPolicyInfo'		=> 'HTTP Permissions-Policy hlavička poskytuje mechanismus pro explicitní povolení nebo zakázání různých výkonných funkcí prohlížeče.',
	'ReferrerPolicy'			=> 'Odkazující politika:',
	'ReferrerPolicyInfo'		=> 'Do odpovědí by měl být zahrnut hlavička HTTP referenční politiky (referrer-Policy HTTP), která odkazující informace zaslané v záhlaví referenta.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'neodkazující',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'stejného původu',
		'4'		=> 'původ',
		'5'		=> 'striktní původ',
		'6'		=> 'Křížový původ',
		'7'		=> 'přísný původ – křížový původ',
		'8'		=> 'nebezpečné url'
	],

	'UserPasswordSection'		=> 'Zachování uživatelských hesel',
	'PwdMinChars'				=> 'Minimální délka hesla:',
	'PwdMinCharsInfo'			=> 'Delší hesla jsou nutně bezpečnější než kratší hesla (např. 12 až 16 znaků).<br>Je podporováno používání přístupových frází.',
	'AdminPwdMinChars'			=> 'Minimální délka hesla správce:',
	'AdminPwdMinCharsInfo'		=> 'Delší hesla jsou nutně bezpečnější než kratší hesla (např. 15 až 20 znaků).<br>Je podporováno používání přístupových frází.',
	'PwdCharComplexity'			=> 'Požadovaná složitost hesla:',
	'PwdCharClasses'	=> [
		'0'		=> 'není testováno',
		'1'		=> 'jakákoli písmena + čísla',
		'2'		=> 'velká a malá písmena + čísla',
		'3'		=> 'velká a malá písmena + čísla + znaky',
	],
	'PwdUnlikeLogin'			=> 'Další komplikace:',
	'PwdUnlikes'	=> [
		'0'		=> 'není testováno',
		'1'		=> 'heslo není totožné s přihlašovacím jménem',
		'2'		=> 'heslo neobsahuje uživatelské jméno',
	],

	'LoginSection'				=> 'Přihlásit se',
	'MaxLoginAttempts'			=> 'Maximální počet pokusů o přihlášení na uživatelské jméno:',
	'MaxLoginAttemptsInfo'		=> 'Počet pokusů o přihlášení povolených pro jeden účet před spuštěním úlohy proti spambot. Zadejte 0, abyste zabránili spuštění úlohy proti spambot pro různé uživatelské účty.',
	'IpLoginLimitMax'			=> 'Maximální počet pokusů o přihlášení na IP adresu:',
	'IpLoginLimitMaxInfo'		=> 'Práh pokusů o přihlášení povolený z jediné IP adresy před spuštěním úlohy proti spambot. Zadejte 0, abyste zabránili spuštění úlohy proti spambot pomocí IP adres.',

	'FormsSection'				=> 'Tiskopisy',
	'FormTokenTime'				=> 'Maximální doba pro odeslání formulářů:',
	'FormTokenTimeInfo'			=> 'Čas, po který musí uživatel odeslat formulář (v sekundách).<br> Všimněte si, že formulář může být neplatný, pokud relace vyprší, bez ohledu na toto nastavení.',

	'SessionLength'				=> 'Platnost cookie relace:',
	'SessionLengthInfo'			=> 'Výchozí životnost cookie uživatelských relací (ve dnech).',
	'CommentDelay'				=> 'Protipovodně pro připomínky:',
	'CommentDelayInfo'			=> 'Minimální zpoždění mezi zveřejněním komentářů nového uživatele (v sekundách).',
	'IntercomDelay'				=> 'Protipovodně pro osobní komunikaci:',
	'IntercomDelayInfo'			=> 'Minimální zpoždění mezi odesláním soukromých zpráv (v sekundách).',
	'RegistrationDelay'			=> 'Časový limit pro registraci:',
	'RegistrationDelayInfo'		=> 'Minimální časový limit mezi předložením registračního formuláře s cílem zabránit registračním robotům (v sekundách).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Skupina parametrů odpovědných za jemné ladění webu. Neměňte je, pokud si nejste jisti jejich akcemi.',
	'FormatterSettingsUpdated'	=> 'Aktualizováno nastavení formátování',

	'TextHandlerSection'		=> 'Zpracovatel textu:',
	'Typografica'				=> 'Typografický korektor:',
	'TypograficaInfo'			=> 'Zakázáním této volby se urychlí proces přidávání komentářů a ukládání stránek.',
	'Paragrafica'				=> 'Označení Paragrafica:',
	'ParagraficaInfo'			=> 'Podobně jako předchozí možnost, ale povede k odpojení neovladatelného automatického obsahu (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Globální HTML podpora:',
	'AllowRawhtmlInfo'			=> 'Tato možnost je potenciálně nebezpečná pro otevřený web.',
	'SafeHtml'					=> 'Filtrování HTML:',
	'SafeHtmlInfo'				=> 'Zabraňuje ukládání nebezpečných HTML objektů. Vypnutí filtru na otevřeném webu s HTML podporou je <span class="underline">extrémně</span> nežádoucí!',

	'WackoFormatterSection'		=> 'Wiki textová fóra (Wacko Formatter)',
	'X11colors'					=> 'Použití barev X11:',
	'X11colorsInfo'				=> 'Rozšiřuje dostupné barvy pro <code>???(barva) pozadí??</code> a <code>!! Barva) text!!</code>Zakázání této možnosti urychluje procesy přidávání komentářů a ukládání stránek.',
	'WikiLinks'					=> 'Zakázat Wiki odkazy:',
	'WikiLinksInfo'				=> 'Zakáže propojení pro <code>CamelCaseWords</code>: Vaše CamelCase slova již nebudou přímo propojena s novou stránkou. To je užitečné, pokud pracujete na různých jmenných místech/clusterech. Ve výchozím nastavení je vypnuto.',
	'BracketsLinks'				=> 'Zakázat závorkové odkazy:',
	'BracketsLinksInfo'			=> 'Zakáže <code>[[link]]</code> a <code>(link))</code> syntax.',
	'Formatters'				=> 'Zakázat formátování:',
	'FormattersInfo'			=> 'Zakáže syntaxi <code>%%code%%</code> , která se používá pro zvýrazňovače.',

	'DateFormatsSection'		=> 'Formáty data',
	'DateFormat'				=> 'Formát data:',
	'DateFormatInfo'			=> '(den, měsíc, rok)',
	'TimeFormat'				=> 'Formát času:',
	'TimeFormatInfo'			=> '(hodina, minuta)',
	'TimeFormatSeconds'			=> 'Formát přesného času:',
	'TimeFormatSecondsInfo'		=> '(hodiny, minuty, vteřiny)',
	'NameDateMacro'				=> 'Formát <code>::@::</code> makro:',
	'NameDateMacroInfo'			=> '(jméno, čas), např. <code>Uživatelské jméno (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Timezone:',
	'TimezoneInfo'				=> 'Časové pásmo pro zobrazení časů uživatelům, kteří nejsou přihlášeni (hosté). Přihlášení uživatelé mohou změnit své časové pásmo v nastavení uživatele.',

	'Canonical'					=> 'Použít plně kanonické URL:',
	'CanonicalInfo'				=> 'Všechny odkazy jsou vytvořeny jako absolutní URL ve tvaru %1. URL vzhledem k kořenovému adresáři serveru ve tvaru %2 by měla být upřednostněna.',
	'LinkTarget'				=> 'Pokud jsou otevřeny externí odkazy:',
	'LinkTargetInfo'			=> 'Otevře každý externí odkaz v novém okně prohlížeče. Přidá <code>target="_blank"</code> do syntaxe odkazu.',
	'Noreferrer'				=> 'noreferr:',
	'NoreferrerInfo'			=> 'Vyžaduje, aby prohlížeč neposlal HTTP referer hlavičku, pokud uživatel dodržuje hypertextový odkaz. Přidá <code>rel="noreferrer"</code> k syntaxi odkazu.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Řekne vyhledávačům, že hypertextové odkazy by neměly ovlivnit pořadí stránek cílové stránky v indexu vyhledávače. Přidá <code>rel="nofollow"</code> do syntaxe odkazu.',
	'UrlsUnderscores'			=> 'Adresa formuláře (URL) s podtržítkem:',
	'UrlsUnderscoresInfo'		=> 'Například, %1 se stane %2 s touto možností.',
	'ShowSpaces'				=> 'Zobrazit mezery na WikiName:',
	'ShowSpacesInfo'			=> 'Zobrazit mezery ve WikiNames, např. <code>MyName</code> se zobrazuje jako <code>Mé jméno</code> s touto možností.',
	'NumerateLinks'				=> 'Číst odkazy v zobrazení tisku:',
	'NumerateLinksInfo'			=> 'Zobrazí a vypíše všechny odkazy v dolní části zobrazení tisku s touto možností.',
	'YouareHereText'			=> 'Zakázat a vizualizovat samoodkazovací odkazy:',
	'YouareHereTextInfo'		=> 'Vizualizace odkazů na stejnou stránku pomocí <code>&lt;b&gt;####&lt;/b&gt;</code>. Všechny odkazy na vlastní formátování odkazů ztrácejí, ale jsou zobrazeny jako tučný text.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Zde můžete nastavit nebo změnit systémové základní stránky používané ve Wiki. Ujistěte se, že podle nastavení nezapomeňte vytvořit nebo měnit odpovídající stránky ve Wiki.',
	'PagesSettingsUpdated'		=> 'Aktualizované základní stránky nastavení',

	'ListCount'					=> 'Počet položek na seznam:',
	'ListCountInfo'				=> 'Počet položek zobrazených v každém seznamu pro hosty, nebo jako výchozí hodnota pro nové uživatele.',

	'ForumSection'				=> 'Fórum možností',
	'ForumCluster'				=> 'Kazetové fórum:',
	'ForumClusterInfo'			=> 'Root cluster pro sekci fóra (akce %1).',
	'ForumTopics'				=> 'Počet témat na stránku:',
	'ForumTopicsInfo'			=> 'Počet témat zobrazených na každé stránce seznamu v sekcích fóra (akce %1).',
	'CommentsCount'				=> 'Počet komentářů na stránku:',
	'CommentsCountInfo'			=> 'Počet komentářů zobrazených na seznamu komentářů každé stránky. To platí pro všechny komentáře na stránce, nejen ty, které byly zveřejněny ve fóru.',

	'NewsSection'				=> 'Sekce novinky',
	'NewsCluster'				=> 'Seskupení novinek:',
	'NewsClusterInfo'			=> 'Root cluster pro novinky (akce %1).',
	'NewsStructure'				=> 'Struktura clusteru zpráv:',
	'NewsStructureInfo'			=> 'Nepovinně ukládá články v dílčích seskupeních podle roku/měsíce nebo týdne (např. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licence',
	'DefaultLicense'			=> 'Výchozí licence:',
	'DefaultLicenseInfo'		=> 'Podle které licence může být váš obsah uvolněn.',
	'EnableLicense'				=> 'Povolit licenci:',
	'EnableLicenseInfo'			=> 'Povolit zobrazení informací o licenci.',
	'LicensePerPage'			=> 'Licence na stránku:',
	'LicensePerPageInfo'		=> 'Povolit licenci na stránku, kterou si vlastník stránky může vybrat prostřednictvím vlastností stránky.',

	'ServicePagesSection'		=> 'Servisní stránky',
	'RootPage'					=> 'Domácí stránka:',
	'RootPageInfo'				=> 'Označení vaší hlavní stránky, se automaticky otevře při návštěvě vašeho webu.',

	'PrivacyPage'				=> 'Zásady ochrany osobních údajů:',
	'PrivacyPageInfo'			=> 'Stránka se zásadami ochrany osobních údajů na webu.',

	'TermsPage'					=> 'Politiky a nařízení:',
	'TermsPageInfo'				=> 'Stránka s pravidly webu.',

	'SearchPage'				=> 'Hledat:',
	'SearchPageInfo'			=> 'Stránka s vyhledávacím formulářem (akce %1).',
	'RegistrationPage'			=> 'Registrace:',
	'RegistrationPageInfo'		=> 'Stránka pro novou registraci uživatele (akce %1).',
	'LoginPage'					=> 'Přihlášení uživatele:',
	'LoginPageInfo'				=> 'Přihlašovací stránka na webu (akce %1).',
	'SettingsPage'				=> 'Nastavení uživatele:',
	'SettingsPageInfo'			=> 'Stránka pro přizpůsobení profilu uživatele (akce %1).',
	'PasswordPage'				=> 'Změnit heslo:',
	'PasswordPageInfo'			=> 'Stránka s formulářem pro změnu / dotaz uživatelského hesla (akce %1).',
	'UsersPage'					=> 'Seznam uživatelů:',
	'UsersPageInfo'				=> 'Stránka se seznamem registrovaných uživatelů (akce %1).',
	'CategoryPage'				=> 'Kategorie:',
	'CategoryPageInfo'			=> 'Stránka se seznamem kategorizovaných stránek (akce %1).',
	'GroupsPage'				=> 'Skupiny:',
	'GroupsPageInfo'			=> 'Stránka se seznamem pracovních skupin (akce %1).',
	'ChangesPage'				=> 'Poslední změny:',
	'ChangesPageInfo'			=> 'Stránka se seznamem posledních upravených stránek (akce %1).',
	'CommentsPage'				=> 'Poslední komentář:',
	'CommentsPageInfo'			=> 'Stránka se seznamem nedávných komentářů na stránce (akce %1).',
	'RemovalsPage'				=> 'Smazané stránky:',
	'RemovalsPageInfo'			=> 'Stránka se seznamem nedávno odstraněných stránek (akce %1).',
	'WantedPage'				=> 'Požadované stránky:',
	'WantedPageInfo'			=> 'Stránka se seznamem chybějících stránek, na které je odkazováno (akce %1).',
	'OrphanedPage'				=> 'Osiřelé stránky:',
	'OrphanedPageInfo'			=> 'Stránka se seznamem existujících stránek není propojena prostřednictvím odkazů na žádnou jinou stránku (akce %1).',
	'SandboxPage'				=> 'Sandbox:',
	'SandboxPageInfo'			=> 'Stránka, kde mohou uživatelé procvičovat své znalosti wiki značky.',
	'HelpPage'					=> 'Nápověda:',
	'HelpPageInfo'				=> 'Část dokumentace pro práci s nástroji webu.',
	'IndexPage'					=> 'Index:',
	'IndexPageInfo'				=> 'Stránka se seznamem všech stránek (akce %1).',
	'RandomPage'				=> 'Náhodné:',
	'RandomPageInfo'			=> 'Načte náhodnou stránku (akce %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parametry pro oznámení platformy.',
	'NotificationSettingsUpdated'	=> 'Aktualizováno nastavení oznámení',

	'EmailNotification'			=> 'E-mailové oznámení:',
	'EmailNotificationInfo'		=> 'Povolit e-mailové upozornění. Nastavením povolíte povolení e-mailových upozornění. Zakázáno pro jejich vypnutí. Upozorňujeme, že vypnutí e-mailových upozornění nemá vliv na e-maily generované jako součást procesu registrace uživatele.',
	'Autosubscribe'				=> 'Automatické předplatné:',
	'AutosubscribeInfo'			=> 'Automaticky informovat vlastníka změn stránky.',

	'NotificationSection'		=> 'Výchozí nastavení oznámení uživatele',
	'NotifyPageEdit'			=> 'Upozornění na editaci stránky:',
	'NotifyPageEditInfo'		=> 'Čeká na odeslání e-mailového oznámení pouze pro první změnu, dokud uživatel nenavštíví stránku znovu.',
	'NotifyMinorEdit'			=> 'Oznámit drobné úpravy:',
	'NotifyMinorEditInfo'		=> 'Odešle oznámení také pro drobné úpravy.',
	'NotifyNewComment'			=> 'Upozornit na nový komentář:',
	'NotifyNewCommentInfo'		=> 'Čeká na zaslání e-mailového upozornění pouze pro první komentář, dokud uživatel nenavštíví stránku znovu.',

	'NotifyUserAccount'			=> 'Upozornit na nový uživatelský účet:',
	'NotifyUserAccountInfo'		=> 'Admin bude upozorněn, když bude nový uživatel vytvořen pomocí registračního formuláře.',
	'NotifyUpload'				=> 'Upozornit na nahrání souboru:',
	'NotifyUploadInfo'			=> 'Moderátoři budou upozorněni na nahrání souboru.',

	'PersonalMessagesSection'	=> 'Osobní zprávy',
	'AllowIntercomDefault'		=> 'Povolit intercom:',
	'AllowIntercomDefaultInfo'	=> 'Povolení této možnosti umožňuje ostatním uživatelům odesílat osobní zprávy na e-mailovou adresu příjemce bez zveřejnění adresy.',
	'AllowMassemailDefault'		=> 'Povolit hromadný e-mail:',
	'AllowMassemailDefaultInfo'	=> 'Posílejte zprávy pouze těm uživatelům, kteří povolili správcům zasílat jim informace e-mailem.',

	// Resync settings
	'Synchronize'				=> 'Synchronize',
	'UserStatsSynched'			=> 'Statistiky uživatelů synchronizovány.',
	'PageStatsSynched'			=> 'Statistiky stránky synchronizovány.',
	'FeedsUpdated'				=> 'RSS zdroje aktualizovány.',
	'SiteMapCreated'			=> 'Nová verze mapy stránek byla úspěšně vytvořena.',
	'ParseNextBatch'			=> 'Analýza další dávky stránek:',
	'WikiLinksRestored'			=> 'Wiki odkazy obnoveny.',

	'LogUserStatsSynched'		=> 'Synchronizované statistiky uživatelů',
	'LogPageStatsSynched'		=> 'Synchronizované statistiky stránek',
	'LogFeedsUpdated'			=> 'Synchronizované RSS kanály',
	'LogPageBodySynched'		=> 'Nahrazené tělo stránky a odkazy',

	'UserStats'					=> 'Statistiky uživatelů',
	'UserStatsInfo'				=> 'Statistiky uživatelů (počet komentářů, vlastněné stránky, revize a soubory) se mohou od skutečných údajů v některých situacích lišit. <br>Tato operace umožňuje aktualizovat statistiky tak, aby odpovídaly skutečným údajům obsaženým v databázi.',
	'PageStats'					=> 'Statistiky stránky',
	'PageStatsInfo'				=> 'Statistiky stránek (počet komentářů, souborů a revizí) se mohou od skutečných údajů v některých situacích lišit. <br>Tato operace umožňuje aktualizovat statistiky tak, aby odpovídaly skutečným údajům obsaženým v databázi.',

	'AttachmentsInfo'			=> 'Aktualizovat hash souboru pro všechny přílohy v databázi.',
	'AttachmentsSynched'		=> 'Znovu hashovat všechny přílohy souborů',
	'LogAttachmentsSynched'		=> 'Znovu hashovat všechny přílohy souborů',

	'Feeds'						=> 'Zdroje',
	'FeedsInfo'					=> 'V případě přímé úpravy stránek v databázi nemusí obsah RSS zdrojů odrážet provedené změny. <br>Tato funkce synchronizuje RSS kanály s aktuálním stavem databáze.',
	'XmlSiteMap'				=> 'XML Sitemap',
	'XmlSiteMapInfo'			=> 'Tato funkce synchronizuje XML-Sitemap s aktuálním stavem databáze.',
	'XmlSiteMapPeriod'			=> 'Období %1 dní. Poslední napsal %2.',
	'XmlSiteMapView'			=> 'Zobrazit mapu stránek v novém okně.',

	'ReparseBody'				=> 'Znovu rozdělit všechny stránky',
	'ReparseBodyInfo'			=> 'Vyprázdní <code>body_r</code> v tabulce stránek, aby se každá stránka znovu vykreslila v následujícím zobrazení. To může být užitečné, pokud jste změnili formát nebo změnili doménu vaší wiki.',
	'PreparsedBodyPurged'		=> 'V tabulce stránek bylo vyplněno <code>body_r</code>.',

	'WikiLinksResync'			=> 'Wiki odkazy',
	'WikiLinksResyncInfo'		=> 'Provede opětovné vykreslování všech intrazitních odkazů a obnoví obsah tabulek <code>page_link</code> a <code>file_link</code> v případě poškození nebo přemístění (to může trvat značně dlouho).',
	'RecompilePage'				=> 'Znovu kompilovat všechny stránky (extrémně nákladné)',
	'ResyncOptions'				=> 'Další možnosti',
	'RecompilePageLimit'		=> 'Počet stránek, které se mají zpracovat najednou.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Tato informace se používá, když engine odesílá e-maily vašim uživatelům. Ujistěte se, že e-mailová adresa, kterou zadáte, je platná, protože na tuto adresu budou pravděpodobně odeslány všechny odepsané nebo neodstranitelné zprávy. Pokud váš poskytovatel hostingu neposkytuje nativní poštovní službu (založené na PHP-), můžete místo toho posílat zprávy přímo pomocí SMTP. To vyžaduje adresu vhodného serveru (zeptejte se svého poskytovatele hostingu v případě potřeby). Pokud server vyžaduje autentizaci (a pouze pokud tak činí), zadejte potřebné uživatelské jméno, heslo a metodu ověřování.',

	'EmailSettingsUpdated'		=> 'Aktualizované nastavení e-mailu',

	'EmailFunctionName'			=> 'Název funkce e-mailu:',
	'EmailFunctionNameInfo'		=> 'Funkce e-mailu používaná k odesílání e-mailů přes PHP.',
	'UseSmtpInfo'				=> 'Vyberte <code>SMTP</code> , pokud chcete nebo musíte, poslat e-mail přes pojmenovaný server místo prostřednictvím lokální funkce pošty.',

	'EnableEmail'				=> 'Povolit e-maily:',
	'EnableEmailInfo'			=> 'Povolit odesílání e-mailů.',

	'EmailIdentitySettings'		=> 'Identity e-mailu webu',
	'FromEmailName'				=> 'Od jména:',
	'FromEmailNameInfo'			=> 'Jméno odesílatele, které se používá v hlavičce <code>Od:</code> pro všechna e-mailová oznámení odeslaná z webu.',
	'EmailSubjectPrefix'		=> 'Prefix předmětu:',
	'EmailSubjectPrefixInfo'	=> 'Alternativní prefix předmětu e-mailu, např. <code>[Prefix] Téma</code>. Pokud není definováno, výchozí prefix je název stránky: %1.',

	'NoReplyEmail'				=> 'Adresa ne-odpovědi:',
	'NoReplyEmailInfo'			=> 'Tato adresa, např. <code>noreply@example.com</code>se zobrazí v poli <code>od:</code> e-mailová adresa všech e-mailových oznámení odeslaných z webu.',
	'AdminEmail'				=> 'E-mail vlastníka lokality:',
	'AdminEmailInfo'			=> 'Tato adresa se používá pro administrátorské účely, jako je oznámení nového uživatele.',
	'AbuseEmail'				=> 'Služba zneužívání e-mailu:',
	'AbuseEmailInfo'			=> 'Žádosti o naléhavou záležitost: registrace na zahraniční e-mail atd. Může být stejný jako e-mail vlastníka webu.',

	'SendTestEmail'				=> 'Odeslat testovací e-mail',
	'SendTestEmailInfo'			=> 'Toto pošle testovací e-mail na adresu definovanou ve vašem účtu.',
	'TestEmailSubject'			=> 'Vaše Wiki je správně nakonfigurována pro odesílání e-mailů',
	'TestEmailBody'				=> 'Pokud jste obdrželi tento e-mail, vaše Wiki je správně nakonfigurována pro odesílání e-mailů.',
	'TestEmailMessage'			=> 'Testovací e-mail byl odeslán.<br>Pokud jej neobdržíte, zkontrolujte prosím nastavení e-mailu.',

	'SmtpSettings'				=> 'Nastavení SMTP',
	'SmtpAutoTls'				=> 'Příležitostné TLS:',
	'SmtpAutoTlsInfo'			=> 'Umožňuje šifrování automaticky, pokud je na serveru reklamní TLS šifrování (po připojení k serveru), i když jste nenastavili režim připojení pro <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Režim připojení pro SMTP:',
	'SmtpConnectionModeInfo'	=> 'Používá se pouze v případě, že je vyžadováno uživatelské jméno/heslo. Zeptejte se svého poskytovatele, pokud si nejste jisti, jakou metodu chcete použít.',
	'SmtpPassword'				=> 'SMTP heslo:',
	'SmtpPasswordInfo'			=> 'Heslo zadejte pouze v případě, že to vyžaduje váš SMTP server.<br><em><strong>Varování:</strong> Toto heslo bude uloženo jako prostý text v databázi, viditelné pro každého, kdo má přístup k databázi nebo kdo může zobrazit tuto konfigurační stránku.</em>',
	'SmtpPort'					=> 'Port SMTP serveru:',
	'SmtpPortInfo'				=> 'Změňte to pouze pokud víte, že váš SMTP server je na jiném portu. <br>(výchozí: <code>tls</code> na portu 587 (nebo možná 25) a <code>ssl</code> na portu 465).',
	'SmtpServer'				=> 'Adresa SMTP serveru:',
	'SmtpServerInfo'			=> 'Všimněte si, že musíte zadat protokol, který používá váš server. Pokud používáte SSL, musí to být <code>ssl://mail.example.com</code>.',
	'SmtpUsername'				=> 'SMTP uživatelské jméno:',
	'SmtpUsernameInfo'			=> 'Zadejte uživatelské jméno pouze v případě, že to vyžaduje váš SMTP server.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Zde můžete nakonfigurovat hlavní nastavení pro přílohy a související speciální kategorie.',
	'UploadSettingsUpdated'		=> 'Aktualizováno nastavení nahrávání',

	'FileUploadsSection'		=> 'Nahrávání souborů',
	'RegisteredUsers'			=> 'registrovaní uživatelé',
	'RightToUpload'				=> 'Oprávnění k nahrávání souborů:',
	'RightToUploadInfo'			=> '<code>adminů</code> znamená, že pouze uživatelé patřící do skupiny správců mohou nahrávat soubory. <code>1</code> znamená, že nahrávání je otevřeno registrovaným uživatelům. <code>0</code> znamená, že nahrávání je zakázáno.',
	'UploadMaxFilesize'			=> 'Maximální velikost souboru:',
	'UploadMaxFilesizeInfo'		=> 'Maximální velikost každého souboru. Je-li tato hodnota 0, maximální velikost nahrávaného souboru je omezena pouze vaší konfigurací PHP.',
	'UploadQuota'				=> 'Celková kvóta přílohy:',
	'UploadQuotaInfo'			=> 'Maximální dostupný prostor na disk pro přílohy pro celou wiki a <code>0</code> je neomezený. %1 použito.',
	'UploadQuotaUser'			=> 'Kvóta úložiště na uživatele:',
	'UploadQuotaUserInfo'		=> 'Omezení kvóty úložiště, které může nahrát jeden uživatel, přičemž <code>0</code> je neomezené.',

	'FileTypes'					=> 'Typy souborů',
	'UploadOnlyImages'			=> 'Povolit pouze nahrávání obrázků:',
	'UploadOnlyImagesInfo'		=> 'Povolit pouze nahrávání obrázků na stránce.',
	'AllowedUploadExts'			=> 'Povolené typy souborů:',
	'AllowedUploadExtsInfo'		=> 'Povolené přípony pro nahrávání souborů, oddělené čárkami (tj. <code>png, ogg, mp4</code>); jinak jsou povoleny všechny přípony souborů.<br>Povolené přípony souborů byste měli omezit na minimum požadované pro správnou funkčnost vašich stránek.',
	'CheckMimetype'				=> 'Zkontrolovat MIME typ:',
	'CheckMimetypeInfo'			=> 'Některé prohlížeče mohou být oříznuty tak, aby předpokládaly nesprávný mimetype pro nahrané soubory. Tato možnost zajišťuje, že takové soubory, které by to mohly způsobit, budou zamítnuty.',
	'SvgSanitizer'				=> 'SVG sanitizátor:',
	'SvgSanitizerInfo'			=> 'To umožňuje zmapovat SVG soubory, aby se zabránilo nahrávání slabých míst SVG/XML.',
	'TranslitFileName'			=> 'Přeložit názvy souborů:',
	'TranslitFileNameInfo'		=> 'Pokud se použije a není třeba mít znaky Unicode, doporučuje se přijímat pouze alfanumerické znaky v názvu souboru.',
	'TranslitCaseFolding'		=> 'Převést názvy souborů na malá písmena:',
	'TranslitCaseFoldingInfo'	=> 'Tato možnost je účinná pouze s aktivním překladem.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Create thumbnail:',
	'CreateThumbnailInfo'		=> 'Vytvořte náhled ve všech možných situacích.',
	'JpegQuality'				=> 'Kvalita JPEG:',
	'JpegQualityInfo'			=> 'Kvalita při škálování miniatury JPEG. Měla by být v rozmezí 1 až 100, což ukazuje 100 % kvality.',
	'MaxImageArea'				=> 'Maximální plocha obrázku:',
	'MaxImageAreaInfo'			=> 'Maximální počet pixelů, které může mít zdrojový obrázek. To poskytuje limit využití paměti pro dekompresní stranu snímku.<br><code>-1</code> znamená, že nebude zkontrolovat velikost obrázku, než se ho pokusí zvětšit. <code>0</code> znamená, že bude automaticky určovat hodnotu.',
	'MaxThumbWidth'				=> 'Maximální šířka náhledu v pixelech:',
	'MaxThumbWidthInfo'			=> 'Vygenerovaný náhled nepřekročí tuto šířku.',
	'MinThumbFilesize'			=> 'Minimální velikost náhledu souboru:',
	'MinThumbFilesizeInfo'		=> 'Nevytvářet náhledy pro obrázky menší.',
	'MaxImageWidth'				=> 'Limit velikosti obrázku na stránkách:',
	'MaxImageWidthInfo'			=> 'Maximální šířka, kterou může mít obrázek na stránkách, v opačném případě je generován zmenšený náhled.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Seznam odstraněných stránek, revizí a souborů.
									odebrat nebo obnovit stránky, revize nebo soubory z databáze kliknutím na odkaz <em>Odstranit</em>
									nebo <em>Obnovit</em> v odpovídajícím řádku. (Pozorně, není požadováno potvrzení smazání!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Slova, která budou automaticky cenzurována na Wiki.',
	'FilterSettingsUpdated'		=> 'Aktualizováno nastavení spam filtru',

	'WordCensoringSection'		=> 'Snímače slov',
	'SPAMFilter'				=> 'Filtr nevyžádané pošty:',
	'SPAMFilterInfo'			=> 'Povoluji filtr nevyžádané pošty',
	'WordList'					=> 'Seznam slov:',
	'WordListInfo'				=> 'Slovo nebo fráze <code>fragmentu</code> bude na černé listině (jeden na řádek)',

	// Log module
	'LogFilterTip'				=> 'Filtrovat události podle kritérií:',
	'LogLevel'					=> 'Úrovně',
	'LogLevelFilters'	=> [
		'1'		=> 'ne méně než',
		'2'		=> 'není vyšší než',
		'3'		=> 'rovno',
	],
	'LogNoMatch'				=> 'Žádné události, které splňují kritéria',
	'LogDate'					=> 'Datum:',
	'LogEvent'					=> 'Událost',
	'LogUsername'				=> 'Uživatelské jméno',
	'LogLevels'	=> [
		'1'		=> 'kritický',
		'2'		=> 'nejvyšší',
		'3'		=> 'Vysoká',
		'4'		=> 'střední',
		'5'		=> 'nízká',
		'6'		=> 'nejnižší',
		'7'		=> 'ladění',
	],

	// Massemail module
	'MassemailInfo'				=> 'Zde můžete poslat zprávu buď 1) všem vašim uživatelům nebo 2) všem uživatelům konkrétní skupiny, kteří povolili příjem hromadných e-mailů. Na zadanou administrativní e-mailovou adresu bude zaslán e-mail s nevidomou kopie (BCC) zaslanou všem příjemcům. Výchozí nastavení obsahuje maximálně 20 příjemců tohoto e-mailu. Pokud je více než 20 příjemců, budou odeslány další e-maily. Pokud odesíláte e-mailem velké skupině lidí, buďte prosím trpěliví po odeslání a nezastavujte stránku v půli cesty. Je normální, aby hromadné odesílání e-mailů trvalo dlouho. Po dokončení skriptu budete upozorněni.',
	'LogMassemail'				=> 'Hromadný email odešle %1 do skupiny / uživateli ',
	'MassemailSend'				=> 'Hromadný e-mail',

	'NoEmailMessage'			=> 'Musíte zadat zprávu.',
	'NoEmailSubject'			=> 'Musíte zadat předmět vaší zprávy.',
	'NoEmailRecipient'			=> 'Musíte zadat alespoň jednoho uživatele nebo skupinu uživatelů.',

	'MassemailSection'			=> 'Hromadný e-mail',
	'MessageSubject'			=> 'Předmět:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Vaše zpráva:',
	'YourMessageInfo'			=> 'Vezměte prosím na vědomí, že můžete zadat pouze prostý text. Všechny značky budou odstraněny před odesláním.',

	'NoUser'					=> 'Žádný uživatel',
	'NoUserGroup'				=> 'Žádná uživatelská skupina',

	'SendToGroup'				=> 'Odeslat do skupiny:',
	'SendToUser'				=> 'Poslat uživateli:',
	'SendToUserInfo'			=> 'Pouze uživatelé, kteří umožňují správcům zasílat jim informace e-maily, budou dostávat hromadné e-maily. Tato možnost je k dispozici v jejich uživatelském nastavení pod oznámením.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Aktualizovaná systémová zpráva',

	'SysMsgSection'				=> 'Systémová zpráva',
	'SysMsg'					=> 'Systémová zpráva:',
	'SysMsgInfo'				=> 'Váš text zde',

	'SysMsgType'				=> 'Typ:',
	'SysMsgTypeInfo'			=> 'Typ zprávy (CSS).',
	'SysMsgAudience'			=> 'Audio:',
	'SysMsgAudienceInfo'		=> 'Audience systémová zpráva je zobrazena.',
	'EnableSysMsg'				=> 'Povolit systémovou zprávu:',
	'EnableSysMsgInfo'			=> 'Zobrazit systémovou zprávu.',

	// User approval module
	'ApproveNotExists'			=> 'Vyberte alespoň jednoho uživatele pomocí tlačítka Nastavení.',

	'LogUserApproved'			=> 'Uživatel ##%1## schválen',
	'LogUserBlocked'			=> 'Uživatel ##%1## zablokován',
	'LogUserDeleted'			=> 'Uživatel ##%1## odstraněn z databáze',
	'LogUserCreated'			=> 'Vytvořil nového uživatele ##%1##',
	'LogUserUpdated'			=> 'Aktualizován uživatel ##%1##',

	'UserApproveInfo'			=> 'Schválit nové uživatele před tím, než se budou moci přihlásit na web.',
	'Approve'					=> 'Schválit',
	'Deny'						=> 'Zamítnout',
	'Pending'					=> 'Nevyřízeno',
	'Approved'					=> 'Schváleno',
	'Denied'					=> 'Zamítnuto',

	// DB Backup module
	'BackupStructure'			=> 'Struktura',
	'BackupData'				=> 'Údaje',
	'BackupFolder'				=> 'Složka',
	'BackupTable'				=> 'Stupeň úvěrové kvality 1',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'Soubory',
	'BackupNote'				=> 'Pozn.:',
	'BackupSettings'			=> 'Zadejte požadované schéma zálohy.<br>' .
    	'Kořenový cluster nemá vliv na globální zálohování souborů a zálohování souborů v mezipaměti (pokud je vybráno, jsou vždy uloženy plnění).<br>' .  '<br>' .
		'<strong>Pozornost</strong>: Aby se zabránilo ztrátě informací z databáze při specifikování kořenového clusteru, tabulky z této zálohy nebudou restrukturalizovány, stejné jako při zálohování pouze tabulky bez uložení dat. Chcete-li provést úplnou konverzi tabulek na formát zálohy, musíte <em> vytvořit úplnou zálohu databáze (strukturu a data) bez zadání clusteru</em>.',
	'BackupCompleted'			=> 'Zálohování a archivace dokončena.<br>' .
    	'Soubory záložních balíčků byly uloženy v podadresáři %1.<br>. Pro stažení použijte FTP (udržovat strukturu adresáře a názvy souborů při kopírování).<br> Chcete-li obnovit zálohu nebo odstranit balíček, přejděte do <a href="%2">Obnovit databázi</a>.',
	'LogSavedBackup'			=> 'Uložená záložní databáze ##%1##',
	'Backup'					=> 'Záloha',
	'CantReadFile'				=> 'Nelze číst soubor %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Můžete obnovit všechny nalezené záložní balíčky nebo je odstranit ze serveru.',
	'ConfirmDbRestore'			=> 'Chcete obnovit zálohu %1?',
	'ConfirmDbRestoreInfo'		=> 'Počkejte prosím, může to chvíli trvat.',
	'RestoreWrongVersion'		=> 'Chybná verze WackoWik!',
	'DirectoryNotExecutable'	=> 'Adresář %1 není spustitelný.',
	'BackupDelete'				=> 'Jste si jisti, že chcete odstranit zálohu %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Další možnosti obnovy:',
	'RestoreOptionsInfo'		=> '* Před obnovením <strong>cluster zálohy</strong>, ' .
									'cílové tabulky nejsou odstraněny (aby se zabránilo ztrátě informací z seskupení, která nebyla zálohována). ' .
									'V průběhu procesu obnovy dojde k duplicitním záznamům. ' .
									'V normálním režimu budou všechny nahrazeny zálohou formuláře záznamů (pomocí SQL <code>REPLACE</code>), ' .
									'ale pokud je zaškrtnuto toto políčko, všechny duplikáty jsou přeskočeny (aktuální hodnoty záznamů budou uloženy), ' .
									'a do tabulky jsou přidány pouze záznamy s novými klíči (SQL <code>VLOŽIT IGNORE</code>).<br>' .
									'<strong>Poznámka</strong>: Při obnovení kompletní zálohy webu nemá tato volba žádnou hodnotu.<br>' .
									'<br>' .
									'** Pokud záloha obsahuje uživatelské soubory (globální a perstránky, soubory mezipaměti atd.), ' .
									'v normálním režimu nahrazují existující soubory stejnými názvy a jsou při obnově umístěny ve stejném adresáři. ' .
									'Tato možnost umožňuje uložit aktuální kopie souborů a obnovit ze zálohy pouze nové soubory (chybí na serveru).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignorovat duplicitní klíče tabulky (nenahrazeny)',
	'IgnoreSameFiles'			=> 'Ignorovat stejné soubory (nepřepsat)',
	'NoBackupsAvailable'		=> 'Žádné zálohy nejsou k dispozici.',
	'BackupEntireSite'			=> 'Celá stránka',
	'BackupRestored'			=> 'Záloha je obnovena, níže je přiložena souhrnná zpráva. Chcete-li odstranit tento záložní balíček, klikněte',
	'BackupRemoved'				=> 'Vybraná záloha byla úspěšně odstraněna.',
	'LogRemovedBackup'			=> 'Záloha databáze ##%1 ## byla odstraněna',

	'RestoreStarted'			=> 'Zahájené obnovení',
	'RestoreParameters'			=> 'Použití parametrů',
	'IgnoreDuplicatedKeys'		=> 'Ignorovat duplicitní klíče',
	'IgnoreDuplicatedFiles'		=> 'Ignorovat duplikované soubory',
	'SavedCluster'				=> 'Uložený cluster',
	'DataProtection'			=> 'Ochrana dat - %1 vynechán',
	'AssumeDropTable'			=> 'Předpokládat %1',
	'RestoreTableStructure'		=> 'Obnovení struktury tabulky',
	'RunSqlQueries'				=> 'Provést SQL instrukce:',
	'CompletedSqlQueries'		=> 'Dokončeno. Zpracované instrukce:',
	'NoTableStructure'			=> 'Struktura tabulek nebyla uložena - přeskočit',
	'RestoreRecords'			=> 'Obnovit obsah tabulek',
	'ProcessTablesDump'			=> 'Stačí stáhnout a zpracovat výpisy tabulek',
	'Instruction'				=> 'Instrukce',
	'RestoredRecords'			=> 'záznamy:',
	'RecordsRestoreDone'		=> 'Dokončeno. Celkem položek:',
	'SkippedRecords'			=> 'Data nebyla uložena - přeskočit',
	'RestoringFiles'			=> 'Obnovení souborů',
	'DecompressAndStore'		=> 'Rozbalit a uložit obsah adresářů',
	'HomonymicFiles'			=> 'homonymní soubory',
	'RestoreSkip'				=> 'přeskočit',
	'RestoreReplace'			=> 'nahradit',
	'RestoreFile'				=> 'Soubor:',
	'RestoredFiles'				=> 'Obnoveno:',
	'SkippedFiles'				=> 'přeskočeno:',
	'FileRestoreDone'			=> 'Dokončeno. Soubory:',
	'FilesAll'					=> 'vše:',
	'SkipFiles'					=> 'Soubory nejsou uloženy - přeskočit',
	'RestoreDone'				=> 'RESTORACE DOKONČENA',

	'BackupCreationDate'		=> 'Datum vytvoření',
	'BackupPackageContents'		=> 'Obsah balení',
	'BackupRestore'				=> 'Obnovit',
	'BackupRemove'				=> 'Odebrat',
	'RestoreYes'				=> 'Ano',
	'RestoreNo'					=> 'Ne',
	'LogDbRestored'				=> 'Záloha ##%1## databáze obnovena.',

	'BackupArchived'			=> 'Záloha %1 byla archivována.',
	'BackupArchiveExists'		=> 'Záložní archiv %1 již existuje.',
	'LogBackupArchived'			=> 'Záloha ##%1## byla archivována.',

	// User module
	'UsersInfo'					=> 'Zde můžete změnit informace o vašich uživatelích a určité konkrétní možnosti.',

	'UsersAdded'				=> 'Uživatel přidán',
	'UsersDeleteInfo'			=> 'Odstranit uživatele:',
	'EditButton'				=> 'Upravit',
	'UsersAddNew'				=> 'Přidat nového uživatele',
	'UsersDelete'				=> 'Jste si jisti, že chcete odstranit uživatele %1?',
	'UsersDeleted'				=> 'Uživatel %1 byl odstraněn z databáze.',
	'UsersRename'				=> 'Rename the user %1 to',
	'UsersRenameInfo'			=> '* Poznámka: Změna ovlivní všechny stránky, které jsou přiřazeny tomuto uživateli.',
	'UsersUpdated'				=> 'Uživatel byl úspěšně aktualizován.',

	'UserIP'					=> 'IP adresa',
	'UserSignuptime'			=> 'Čas registrace',
	'UserActions'				=> 'Akce',
	'NoMatchingUser'			=> 'Žádní uživatelé, kteří splňují kritéria',

	'UserAccountNotify'			=> 'Upozornit uživatele',
	'UserNotifySignup'			=> 'informovat uživatele o novém účtu',
	'UserVerifyEmail'			=> 'nastavit e-mail potvrdit token a přidat odkaz pro ověření e-mailu',
	'UserReVerifyEmail'			=> 'Znovu odeslat potvrzovací token e-mailu',

	// Groups module
	'GroupsInfo'				=> 'Z tohoto panelu můžete spravovat všechny vaše uživatelské skupiny. Můžete odstranit, vytvořit a upravit existující skupiny. Kromě toho si můžete vybrat vedoucí skupiny, přepnout otevřený/skrytý/uzavřený stav skupiny a nastavit název a popis skupiny.',

	'LogMembersUpdated'			=> 'Aktualizovaní členové uživatelské skupiny',
	'LogMemberAdded'			=> 'Přidán člen ##%1## do skupiny ##%2##',
	'LogMemberRemoved'			=> 'Byl odebrán člen ##%1## ze skupiny ##%2##',
	'LogGroupCreated'			=> 'Vytvořena nová skupina ##%1##',
	'LogGroupRenamed'			=> 'Skupina ##%1## přejmenována na ##%2##',
	'LogGroupRemoved'			=> 'Skupina ## odebrána%1##',

	'GroupsMembersFor'			=> 'Členové za skupinu',
	'GroupsDescription'			=> 'L 343, 22.12.2009, s. 1).',
	'GroupsModerator'			=> 'Moderátor',
	'GroupsOpen'				=> 'Otevřít',
	'GroupsActive'				=> 'Aktivní',
	'GroupsTip'					=> 'Kliknutím upravíte skupinu',
	'GroupsUpdated'				=> 'Skupiny aktualizovány',
	'GroupsAlreadyExists'		=> 'Tato skupina již existuje.',
	'GroupsAdded'				=> 'Skupina byla úspěšně přidána.',
	'GroupsRenamed'				=> 'Skupina úspěšně přejmenována.',
	'GroupsDeleted'				=> 'Skupina %1 a všechny přidružené stránky byly odstraněny z databáze.',
	'GroupsAdd'					=> 'Přidat novou skupinu',
	'GroupsRename'				=> 'Přejmenovat skupinu %1 na',
	'GroupsRenameInfo'			=> '* Poznámka: Změna ovlivní všechny stránky, které jsou přiřazeny k této skupině.',
	'GroupsDelete'				=> 'Jste si jisti, že chcete odstranit skupinu %1?',
	'GroupsDeleteInfo'			=> '* Poznámka: Změna ovlivní všechny členy, kteří jsou přiřazeni k této skupině.',
	'GroupsIsSystem'			=> 'Skupina %1 patří do systému a nelze ji odstranit.',
	'GroupsStoreButton'			=> 'Uložit skupiny',
	'GroupsEditInfo'			=> 'Chcete-li upravit seznam skupin, vyberte tlačítko rádio.',

	'GroupAddMember'			=> 'Přidat člena',
	'GroupRemoveMember'			=> 'Odebrat člena',
	'GroupAddNew'				=> 'Přidat skupinu',
	'GroupEdit'					=> 'Upravit skupinu',
	'GroupDelete'				=> 'Odstranit skupinu',

	'MembersAddNew'				=> 'Přidat nového člena',
	'MembersAdded'				=> 'Nový člen do skupiny byl úspěšně přidán.',
	'MembersRemove'				=> 'Jste si jisti, že chcete odstranit člena %1?',
	'MembersRemoved'			=> 'Člen byl odstraněn ze skupiny.',

	// Statistics module
	'DbStatSection'				=> 'Statistiky databáze',
	'DbTable'					=> 'Stupeň úvěrové kvality 1',
	'DbRecords'					=> 'Záznamy',
	'DbSize'					=> 'Velikost',
	'DbIndex'					=> 'Objem dovozu (v tunách)',
	'DbOverhead'				=> 'Režijní',
	'DbTotal'					=> 'Celkem',

	'FileStatSection'			=> 'Statistiky souborového systému',
	'FileFolder'				=> 'Složka',
	'FileFiles'					=> 'Soubory',
	'FileSize'					=> 'Velikost',
	'FileTotal'					=> 'Celkem',

	// Sysinfo module
	'SysInfo'					=> 'Informace o verzi:',
	'SysParameter'				=> 'Parametr',
	'SysValues'					=> 'Hodnoty',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Poslední aktualizace',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Název serveru',
	'WebServer'					=> 'Webový server',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'Globální SQL módy',
	'SqlModesSession'			=> 'Relace SQL režimů',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Paměť',
	'UploadFilesizeMax'			=> 'Nahrát maximální velikost souboru',
	'PostMaxSize'				=> 'Maximální velikost příspěvku',
	'MaxExecutionTime'			=> 'Maximální doba provádění',
	'SessionPath'				=> 'Cesta k relaci',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'Komprese GZip',
	'PhpExtensions'				=> 'PHP rozšíření',
	'ApacheModules'				=> 'Moduly Apache',

	// DB repair module
	'DbRepairSection'			=> 'Opravit databázi',
	'DbRepair'					=> 'Opravit databázi',
	'DbRepairInfo'				=> 'Tento skript může automaticky vyhledat některé běžné problémy s databází a opravit je. Opravování může chvíli trvat, takže prosím buďte trpěliví.',

	'DbOptimizeRepairSection'	=> 'Opravit a optimalizovat databázi',
	'DbOptimizeRepair'			=> 'Opravit a optimalizovat databázi',
	'DbOptimizeRepairInfo'		=> 'Tento skript se také může pokusit optimalizovat databázi. To zlepšuje výkon v některých situacích. Oprava a optimalizace databáze může trvat dlouho a databáze bude uzamčena při optimalizaci.',

	'TableOk'					=> 'Tabulka %1 je v pořádku.',
	'TableNotOk'				=> 'Tabulka %1 není v pořádku. Hlásí následující chybu: %2. Tento skript se pokusí opravit tuto tabulku&hellip;',
	'TableRepaired'				=> 'Úspěšně opravena tabulka %1.',
	'TableRepairFailed'			=> 'Nepodařilo se opravit tabulku %1 . <br>Chyba: %2',
	'TableAlreadyOptimized'		=> 'Tabulka %1 je již optimalizována.',
	'TableOptimized'			=> 'Úspěšně optimalizována tabulka %1.',
	'TableOptimizeFailed'		=> 'Nepodařilo se optimalizovat tabulku %1 . <br>Chyba: %2',
	'TableNotRepaired'			=> 'Některé problémy s databází nelze opravit.',
	'RepairsComplete'			=> 'Opravy dokončeny',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Zobrazit a opravit nesrovnalosti, smazat nebo přiřadit osiřelé záznamy k novému uživateli / hodnotě.',
	'Inconsistencies'			=> 'Nesrovnalosti',
	'CheckDatabase'				=> 'Databáze',
	'CheckDatabaseInfo'			=> 'Kontroly nesrovnalostí záznamů v databázi.',
	'CheckFiles'				=> 'Soubory',
	'CheckFilesInfo'			=> 'Kontroluje opuštěné soubory, soubory bez odkazů v tabulce souborů.',
	'Records'					=> 'Záznamy',
	'InconsistenciesNone'		=> 'Nebyly nalezeny žádné nesrovnalosti v datech.',
	'InconsistenciesDone'		=> 'Nekonzistentnost údajů vyřešena.',
	'InconsistenciesRemoved'	=> 'Odstraněné nesrovnalosti',
	'Check'						=> 'Zkontrolovat',
	'Solve'						=> 'Vyřešit',

	// Bad Behaviour module
	'BbInfo'					=> 'Detekuje a blokuje nežádoucí přístup na web, znemožňuje přístup automatickým spambotům.<br>Pro více informací navštivte domovskou stránku %1.',
	'BbEnable'					=> 'Povolit špatné chování:',
	'BbEnableInfo'				=> 'Všechna ostatní nastavení lze změnit ve složce nastavení %1.',
	'BbStats'					=> 'Špatné chování zablokovalo pokusy o přístup %1 za posledních 7 dní.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Záznamy',
	'BbSettings'				=> 'Nastavení',
	'BbWhitelist'				=> 'Seznam povolených',

	// --> Log
	'BbHits'					=> 'Zobrazení',
	'BbRecordsFiltered'			=> 'Zobrazení %1 z %2 záznamů filtrováno',
	'BbStatus'					=> 'Stav',
	'BbBlocked'					=> 'Blokované',
	'BbPermitted'				=> 'Povoleno',
	'BbIp'						=> 'IP adresa',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Zobrazení všech %1 záznamů',
	'BbShow'					=> 'Zobrazit',
	'BbIpDateStatus'			=> 'IP/Datum/Stav',
	'BbHeaders'					=> 'Záhlaví',
	'BbEntity'					=> 'Subjekt',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Možnosti uloženy.',
	'BbWhitelistHint'			=> 'Nevhodný bílou listinu WILL vás vystaví spamu, nebo způsobí, že Bad Behaviour přestane fungovat úplně! NEPOVÍCE, pokud nejste 100% CERTAIN, který byste měli.',
	'BbIpAddress'				=> 'IP adresa',
	'BbIpAddressInfo'			=> 'IP adresa nebo rozsahy adresy ve formátu CIDR, které mají být povoleny (jeden na řádek)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'fragmenty URL začínající / po názvu vašeho webu (jeden na řádek)',
	'BbUserAgent'				=> 'Uživatelský agent',
	'BbUserAgentInfo'			=> 'Řetězce uživatelského agenta, které mají být na seznamu povolených (jeden na řádek)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Aktualizováno nastavení špatného chování',
	'BbLogRequest'				=> 'Logování HTTP požadavku',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normální (doporučeno)',
	'BbLogOff'					=> 'Nelogovat (není doporučeno)',
	'BbSecurity'				=> 'Zabezpečení',
	'BbStrict'					=> 'Přísná kontrola',
	'BbStrictInfo'				=> 'blokuje více nevyžádané pošty, ale může zablokovat některé lidi',
	'BbOffsiteForms'			=> 'Povolit vkládání formulářů z jiných webových stránek',
	'BbOffsiteFormsInfo'		=> 'vyžadováno pro OpenID; zvyšuje přijaté spam',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Chcete-li použít funkce http:BL Bad Behaviour, musíte mít %1',
	'BbHttpblKey'				=> 'http:BL přístupový klíč',
	'BbHttpblThreat'			=> 'Minimální úroveň ohrožení (25 se doporučuje)',
	'BbHttpblMaxage'			=> 'Maximální věk dat (doporučuje se 30)',
	'BbReverseProxy'			=> 'Zůstatek proxy/Načíst',
	'BbReverseProxyInfo'		=> 'Pokud používáte špatné chování za reverzním proxy, načtěte balancer, akcelerátor HTTP, mezipaměť obsahu nebo podobnou technologii, povolte možnost Reverse Proxy.<br>' .
									'Pokud máte řetězec dvou nebo více reverzních proxy serverů mezi vaším serverem a veřejným internetem, musíte zadat <em>všechny</em> rozsahů IP adres (ve formátu CIDR) všech proxy serverů, načíst balancery atd. V opačném případě Bad Behaviour možná nebude schopen určit skutečnou IP adresu klienta.<br>' .
									'Kromě toho musí vaše reverzní proxy servery nastavit IP adresu internetového klienta, ze kterého obdržely požadavek v hlavičce HTTP. Pokud nespecifikujete hlavičku, bude použit %1 . Většina proxy serverů již podporuje X-Forwarded-For a pak byste se měli ujistit, že je na proxy serverech povolena. Některé další běžně používané názvy záhlaví zahrnují %2 a %3.',
	'BbReverseProxyEnable'		=> 'Povolit reverzní proxy',
	'BbReverseProxyHeader'		=> 'Záhlaví obsahující IP adresu internetových klientů',
	'BbReverseProxyAddresses'	=> 'IP adresa nebo rozsahy adres ve formátu CIDR pro proxy servery (jeden na řádek)',

];
