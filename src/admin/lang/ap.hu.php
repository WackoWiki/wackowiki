<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Alapfunkciók',
		'preferences'	=> 'Preferenciák',
		'content'		=> 'Tartalom',
		'users'			=> 'Felhasználók',
		'maintenance'	=> 'Karbantartás',
		'messages'		=> 'Üzenetek',
		'extension'		=> 'Bővítmények',
		'database'		=> 'Adatbázis',
	],

	// Admin panel
	'AdminPanel'				=> 'Adminisztrátori vezérlőpult',
	'RecoveryMode'				=> 'Visszaállítási mód',
	'Authorization'				=> 'Hitelesítés',
	'AuthorizationTip'			=> 'Kérjük, adja meg az adminisztrátori jelszót (győződjön meg arról is, hogy a böngészőben engedélyezve van a sütik használata).',
	'NoRecoveryPassword'		=> 'Az adminisztrátori jelszó nincs megadva!',
	'NoRecoveryPasswordTip'		=> 'Figyelem: Az adminisztrátori jelszó hiánya biztonsági kockázatot jelent! Adja meg a jelszavát a konfigurációs fájlban, majd indítsa újra a programot.',

	'ApDevNologinBlocked'		=> 'Access blocked: AP_DEV_NOLOGIN is enabled in admin.php but the request did not originate from localhost (127.0.0.1, ::1, or localhost). This is a development-only flag and must be disabled on production. Set <code>AP_DEV_NOLOGIN = 0</code> in admin.php to restore access.',
	'ApDevNologinBlockedLog'	=> '!!! SECURITY: %1 is enabled but admin.php was accessed from a non-localhost address (%2). Admin panel access has been blocked.',

	'ErrorLoadingModule'		=> 'Hiba történt a(z) %1 admin modul betöltésekor: nem létezik.',

	'ApHomePage'				=> 'Főoldal',
	'ApHomePageTip'				=> 'a főoldal megnyitása anélkül, hogy kilépne az adminisztrációból',
	'ApLogOut'					=> 'Kilépés',
	'ApLogOutTip'				=> 'kilépés a rendszer adminisztrációjából',

	'TimeLeft'					=> 'Hátralévő idő: %1 perc',
	'TimeLeftInfinity'			=> 'Time left:  %1 (developer mode)',
	'ApVersion'					=> 'verzió',

	'SiteOpen'					=> 'Megnyitás',
	'SiteOpened'				=> 'a weboldal nyitva van',
	'SiteOpenedTip'				=> 'A weboldal nyitva áll',
	'SiteClose'					=> 'Lezárás',
	'SiteClosed'				=> 'a weboldal lezárva',
	'SiteClosedTip'				=> 'A weboldal lezárva',

	'System'					=> 'Rendszer',

	// Generic
	'Cancel'					=> 'Mégse',
	'Add'						=> 'Hozzáadás',
	'Edit'						=> 'Szerkesztés',
	'Remove'					=> 'Eltávolítás',
	'Enabled'					=> 'Engedélyezve',
	'Disabled'					=> 'Letiltva',
	'Mandatory'					=> 'Kötelező',
	'Admin'						=> 'Adminisztrátor',
	'Min'						=> 'Min',
	'Max'						=> 'Max',

	'MiscellaneousSection'		=> 'Egyéb',
	'MainSection'				=> 'Alapvető paraméterek',

	'DirNotWritable'			=> 'A(z) %1 könyvtár nem írható.',
	'FileNotWritable'			=> 'A(z) %1 fájl nem írható.',

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
		'name'		=> 'Alapvető',
		'title'		=> 'Alapvető beállítások',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Megjelenés',
		'title'		=> 'Megjelenés beállításai',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-mail',
		'title'		=> 'E-mail beállítások',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Hírfolyam',
		'title'		=> 'Hírfolyam beállításai',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Szűrők',
		'title'		=> 'Szűrő beállítások',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formázás',
		'title'		=> 'Formázási beállítások',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Értesítések',
		'title'		=> 'Értesítési beállítások',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Oldalak',
		'title'		=> 'Oldalak és webhely beállításai',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Jogosultságok',
		'title'		=> 'Jogosultsági beállítások',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Biztonság',
		'title'		=> 'Biztonsági alrendszerek beállításai',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Rendszer',
		'title'		=> 'Rendszerbeállítások',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Feltöltés',
		'title'		=> 'Melléklet beállításai',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Törölt',
		'title'		=> 'Újonnan törölt tartalmak',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menü',
		'title'		=> 'Alapértelmezett menüelemek hozzáadása, szerkesztése vagy eltávolítása',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Biztonsági mentés',
		'title'		=> 'Adatok biztonsági mentése',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Javítás',
		'title'		=> 'Adatbázis javítása és optimalizálása',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Visszaállítás',
		'title'		=> 'Biztonsági mentés visszaállítása',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Főmenü',
		'title'		=> 'WackoWiki adminisztráció',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Ellentmondások',
		'title'		=> 'Adat-ellentmondások javítása',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Szinkronizálás',
		'title'		=> 'Adatok szinkronizálása',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Kollektív e-mail',
		'title'		=> 'Kollektív e-mail küldése',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Rendszerüzenet',
		'title'		=> 'Rendszerüzenetek',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Rendszerinformáció',
		'title'		=> 'Rendszerinformációk',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Rendszernapló',
		'title'		=> 'Rendszeresemények naplója',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statisztika',
		'title'		=> 'Statisztikák megjelenítése',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Rossz viselkedés',
		'title'		=> 'Rossz viselkedés elleni védelem',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Jóváhagyás',
		'title'		=> 'Felhasználói regisztráció jóváhagyása',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Csoportok',
		'title'		=> 'Csoportok kezelése',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Felhasználók',
		'title'		=> 'Felhasználók kezelése',
	],

	// Main module
	'MainNote'					=> 'Figyelem: Műszaki adminisztrációs tevékenységek végzése előtt erősen ajánlott a weboldalhoz való hozzáférés blokkolása!',

	'PurgeSessions'				=> 'Munkamenetek törlése',
	'PurgeSessionsTip'			=> 'Az összes munkamenet törlése',
	'PurgeSessionsConfirm'		=> 'Biztosan törölni szeretné az összes munkamenetet? Ez minden felhasználót kijelentkeztet.',
	'PurgeSessionsExplain'		=> 'Az összes munkamenet törlése. Ez minden felhasználót kijelentkeztet az auth_token tábla ürítésével.',
	'PurgeSessionsDone'			=> 'A munkamenetek sikeresen törölve.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Alapbeállítások frissítve',
	'LogBasicSettingsUpdated'	=> 'Alapbeállítások frissítve',

	'SiteName'					=> 'Weboldal neve:',
	'SiteNameInfo'				=> 'A weboldal címe, amely megjelenik a böngésző címsorában, a téma fejlécében, e-mail értesítésekben stb.',
	'SiteDesc'					=> 'Weboldal leírása:',
	'SiteDescInfo'				=> 'Kiegészítés a weboldal címéhez, amely a lapok fejlécében jelenik meg, hogy néhány szóban elmagyarázza, miről szól ez a weboldal.',
	'AdminName'					=> 'Weboldal adminisztrátora:',
	'AdminNameInfo'				=> 'Felhasználónév, amely felelős a weboldal általános támogatásáért. Ez a név nem használatos hozzáférési jogok meghatározására, de kívánatos, hogy megfeleljen a weboldal főadminisztrátorának nevének.',

	'LanguageSection'			=> 'Nyelv',
	'DefaultLanguage'			=> 'Alapértelmezett nyelv:',
	'DefaultLanguageInfo'		=> 'Meghatározza a nem regisztrált vendégeknek megjelenített üzenetek nyelvét, valamint a locale beállításokat.',
	'MultiLanguage'				=> 'Többnyelvű támogatás:',
	'MultiLanguageInfo'			=> 'Engedélyezi a nyelv oldalankénti kiválasztásának lehetőségét.',
	'AllowedLanguages'			=> 'Engedélyezett nyelvek:',
	'AllowedLanguagesInfo'		=> 'Javasoljuk, hogy csak azokat a nyelveket válassza ki, amelyeket használni szeretne, egyébként minden nyelv engedélyezve lesz.',

	'CommentSection'			=> 'Hozzászólások',
	'AllowComments'				=> 'Hozzászólások engedélyezése:',
	'AllowCommentsInfo'			=> 'Engedélyezi a hozzászólásokat csak vendégeknek vagy regisztrált felhasználóknak, vagy letiltja azokat az egész weboldalon.',
	'SortingComments'			=> 'Hozzászólások rendezése:',
	'SortingCommentsInfo'		=> 'Megváltoztatja a hozzászólások megjelenítésének sorrendjét, vagy a legfrissebb, vagy a legrégebbi hozzászólást helyezve legfelülre.',
	'CommentsOffset'			=> 'Hozzászólások oldala:',
	'CommentsOffsetInfo'		=> 'Alapértelmezés szerint megjelenítendő hozzászólások oldal',

	'ToolbarSection'			=> 'Eszköztár',
	'CommentsPanel'				=> 'Hozzászólások panel:',
	'CommentsPanelInfo'			=> 'Alapértelmezett megjelenítés a lap alján lévő hozzászólások paneljén.',
	'FilePanel'					=> 'Fájlok panel:',
	'FilePanelInfo'				=> 'Alapértelmezett megjelenítés a lap alján lévő mellékletek paneljén.',
	'TagsPanel'					=> 'Címkék panel:',
	'TagsPanelInfo'				=> 'Alapértelmezett megjelenítés a lap alján lévő címkék paneljén.',

	'NavigationSection'			=> 'Navigáció',
	'ShowPermalink'				=> 'Permalink megjelenítése:',
	'ShowPermalinkInfo'			=> 'Alapértelmezett megjelenítés a lap aktuális verziójának permalinkjén.',
	'TocPanel'					=> 'Tartalomjegyzék panel:',
	'TocPanelInfo'				=> 'Alapértelmezett megjelenítés a lap tartalomjegyzék paneljén (a sablonok támogatását igényelheti).',
	'SectionsPanel'				=> 'Szekciók panel:',
	'SectionsPanelInfo'			=> 'Alapértelmezett megjelenítés a szomszédos lapok paneljén (a sablonok támogatását igényelheti).',
	'DisplayingSections'		=> 'Szekciók megjelenítése:',
	'DisplayingSectionsInfo'	=> 'Az előző opciókkal kapcsolatban, hogy csak az oldal aloldalait (lower), csak a szomszédos oldalakat (top), vagy mindkettőt, illetve egyébeket (tree) jelenítse meg.',
	'MenuItems'					=> 'Menüelemek:',
	'MenuItemsInfo'				=> 'Alapértelmezett számú megjelenített menüelem (a sablonok támogatását igényelheti).',

	'HandlerSection'			=> 'Kezelő',
	'HideRevisions'				=> 'Reviziók elrejtése:',
	'HideRevisionsInfo'			=> 'Alapértelmezett megjelenítés a lap revízióiról.',
	'AttachmentHandler'			=> 'Mellékletek kezelő engedélyezése:',
	'AttachmentHandlerInfo'		=> 'Engedélyezi a mellékletek kezelőjének megjelenítését.',
	'SourceHandler'				=> 'Forráskezelő engedélyezése:',
	'SourceHandlerInfo'			=> 'Engedélyezi a forráskezelő megjelenítését.',
	'ExportHandler'				=> 'XML export kezelő engedélyezése:',
	'ExportHandlerInfo'			=> 'Engedélyezi az XML export kezelő megjelenítését.',

	'DiffModeSection'			=> 'Diff módok',
	'DefaultDiffModeSetting'	=> 'Alapértelmezett diff mód:',
	'DefaultDiffModeSettingInfo'=> 'Előre kiválasztott diff mód.',
	'AllowedDiffMode'			=> 'Engedélyezett Diff módok:',
	'AllowedDiffModeInfo'		=> 'Javasolt csak azokat a diff módokat kiválasztani, amelyeket használni szeretne, egyébként minden diff mód engedélyezve lesz.',
	'NotifyDiffMode'			=> 'Értesítési diff mód:',
	'NotifyDiffModeInfo'		=> 'Diff mód, amelyet az e-mailben lévő értesítésekhez használnak.',

	'EditingSection'			=> 'Szerkesztés',
	'EditSummary'				=> 'Szerkesztési összefoglaló:',
	'EditSummaryInfo'			=> 'Megjeleníti a változtatások összefoglalóját szerkesztési módban.',
	'MinorEdit'					=> 'Apróbb szerkesztések:',
	'MinorEditInfo'				=> 'Engedélyezi az apróbb szerkesztések opcióját szerkesztési módban.',
	'SectionEdit'				=> 'Szekció szerkesztés:',
	'SectionEditInfo'			=> 'Csak az oldal egy szakaszának szerkesztését teszi lehetővé.',
	'ReviewSettings'			=> 'Felülvizsgálat:',
	'ReviewSettingsInfo'		=> 'Engedélyezi a felülvizsgálati opciót szerkesztési módban.',
	'PublishAnonymously'		=> 'Névtelen közzététel engedélyezése:',
	'PublishAnonymouslyInfo'	=> 'Engedélyezi a felhasználóknak, hogy inkább névtelenül tegyék közzé (hogy elrejtsék a nevüket).',

	'DefaultRenameRedirect'		=> 'Átnevezéskor átirányítás létrehozása:',
	'DefaultRenameRedirectInfo'	=> 'Alapértelmezés szerint felajánlja egy átirányítás létrehozását az átnevezett lap régi címére.',
	'StoreDeletedPages'			=> 'Törölt lapok tárolása:',
	'StoreDeletedPagesInfo'		=> 'Amikor töröl egy lapot, hozzászólást vagy fájlt, azokat egy különleges szekcióban tárolja, ahol bizonyos ideig még elérhetőek lesznek felülvizsgálatra és visszaállításra (ahogy alább le van írva).',
	'KeepDeletedTime'			=> 'Törölt lapok tárolási ideje:',
	'KeepDeletedTimeInfo'		=> 'A napok száma. Csak az előző opcióval van értelme. A nulla örökös tárolást jelent (ebben az esetben az adminisztrátor manuálisan törölheti a "kosarat").',
	'PagesPurgeTime'			=> 'Lapverziók tárolási ideje:',
	'PagesPurgeTimeInfo'		=> 'Automatikusan törli a régebbi verziókat a megadott napok számán belül. Ha nullát ad meg, a régebbi verziók nem lesznek törölve.',
	'EnableReferrers'			=> 'Hivatkozások engedélyezése:',
	'EnableReferrersInfo'		=> 'Engedélyezi külső hivatkozások tárolását és megjelenítését.',
	'ReferrersPurgeTime'		=> 'Hivatkozások tárolási ideje:',
	'ReferrersPurgeTimeInfo'	=> 'Tartsa meg a külső hivatkozások történetét nem több, mint a megadott napok számáig. A nulla örökös tárolást jelent, de egy forgalmas weboldalnál ez adatbázis túlterheléshez vezethet.',
	'EnableCounters'			=> 'Látogatásszámlálók:',
	'EnableCountersInfo'		=> 'Engedélyezi a lapankénti látogatásszámlálókat és egyszerű statisztikák megjelenítését. A lap tulajdonosának látogatásai nem számítanak.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'A webhely alapértelmezett webes szindikációs beállításainak szabályozása.',
	'SyndicationSettingsUpdated'	=> 'Frissített szindikációs beállítások.',

	'FeedsSection'				=> 'Hírcsatornák',
	'EnableFeeds'				=> 'Hírcsatornák engedélyezése:',
	'EnableFeedsInfo'			=> 'Az RSS-hírcsatornák be- és kikapcsolása a teljes wiki számára.',
	'XmlChangeLink'				=> 'Változások hírcsatorna link módja:',
	'XmlChangeLinkInfo'			=> 'Meghatározza, hogy a XML Changes hírcsatorna elemei hová mutassanak.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'a változás nézetre',
		'2'		=> 'a jelenlegi oldalra',
		'3'		=> 'a változatok listájára',
		'4'		=> 'az átdolgozott oldalra',
	],

	'XmlSitemap'				=> 'XML webhelytérkép:',
	'XmlSitemapInfo'			=> 'Létrehoz egy %1 nevű XML fájlt az xml mappában. A webhelytérkép elérési útját a gyökérkönyvtárban lévő robots.txt fájlhoz a következőképpen adhatja hozzá:',
	'XmlSitemapGz'				=> 'XML webhelytérkép tömörítése:',
	'XmlSitemapGzInfo'			=> 'Ha szeretné, tömörítheti a webhelytérkép szövegfájlját gzip használatával, hogy csökkentse a sávszélesség-igényét.',
	'XmlSitemapTime'			=> 'XML webhelytérkép generálási ideje:',
	'XmlSitemapTimeInfo'		=> 'A webhelytérképet csak egyszer generálja az adott napok számában, nulla azt jelenti, hogy minden oldalváltozáskor.',

	'SearchSection'				=> 'Keresés',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Létrehozza az OpenSearch leíró fájlt az XML mappában, és engedélyezi a keresési bővítmény automatikus felfedezését a HTML fejlécben.',
	'SearchEngineVisibility'	=> 'Tiltás keresőmotorok számára (Keresőmotor láthatóság):',
	'SearchEngineVisibilityInfo'=> 'Letiltja a keresőmotorokat, de engedélyezi a normál látogatókat. Felülírja az oldalak beállításait.
Megakadályozza a keresőmotorokat ennek a webhelynek az indexelését, a keresőmotorok döntik el, hogy betartják-e ezt a kérést.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Állítsa be a webhely alapértelmezett megjelenési beállításait.',
	'AppearanceSettingsUpdated'	=> 'Frissített megjelenési beállítások.',

	'LogoOff'					=> 'ki',
	'LogoOnly'					=> 'csak logó',
	'LogoAndTitle'				=> 'logó és cím',

	'LogoSection'				=> 'Logó',
	'SiteLogo'					=> 'Webhely logója:',
	'SiteLogoInfo'				=> 'A logó általában a webalkalmazás bal felső sarkában jelenik meg. Maximális méret: 2 MiB. Optimális méretek: 255 pixel széles, 55 pixel magas.',
	'LogoDimensions'			=> 'Logó méretei:',
	'LogoDimensionsInfo'		=> 'A megjelenített logó szélessége és magassága.',
	'LogoDisplayMode'			=> 'Logó megjelenítési módja:',
	'LogoDisplayModeInfo'		=> 'Meghatározza a logó megjelenését. Alapértelmezés szerint ki van kapcsolva.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Webhely faviconja:',
	'SiteFaviconInfo'			=> 'A webhely parancsikonja (favicon) megjelenik a böngésző címsorában, lapfüleiben és könyvjelzőiben. Ez felülírja a téma faviconját.',
	'SiteFaviconTooBig'			=> 'A Favicon nagyobb, mint 64 × 64 képpont.',
	'ThemeColor'				=> 'Téma színe a címsorhoz:',
	'ThemeColorInfo'			=> 'A böngésző beállítja a címsor színét minden oldalon a megadott CSS szín alapján.',

	'LayoutSection'				=> 'Elrendezés',
	'Theme'						=> 'Téma:',
	'ThemeInfo'					=> 'A webhely alapértelmezés szerint használt sablonterve.',
	'ResetUserTheme'			=> 'Összes felhasználói téma visszaállítása:',
	'ResetUserThemeInfo'		=> 'Visszaállítja az összes felhasználói témát. Figyelem: Ez a művelet minden felhasználó által választott témát visszaállítja a globális alapértelmezett témára.',
	'SetBackUserTheme'			=> 'Minden felhasználói téma visszaállítása a(z) %1 témára.',
	'ThemesAllowed'				=> 'Engedélyezett témák:',
	'ThemesAllowedInfo'			=> 'Válassza ki azokat a témákat, amelyeket a felhasználók választhatnak, egyébként minden elérhető téma engedélyezett lesz.',
	'ThemesPerPage'				=> 'Témák oldalanként:',
	'ThemesPerPageInfo'			=> 'Engedélyezze a témákat oldalanként, amelyeket az oldal tulajdonosa az oldal tulajdonságain keresztül választhat.',

	// System settings
	'SystemSettingsInfo'		=> 'A platform finomhangolásáért felelős paramétercsoport. Ne változtasson rajtuk, hacsak nem biztos a hatásukban.',
	'SystemSettingsUpdated'		=> 'A rendszerbeállítások frissítve',

	'DebugModeSection'			=> 'Hibakeresési mód',
	'DebugMode'					=> 'Hibakeresési mód:',
	'DebugModeInfo'				=> 'A program futási idejének rögzítése és telemetriai adatok megjelenítése. Megjegyzés: a részletes üzemmód magas memóriaigényt támaszt, különösen igényes műveleteknél, mint például az adatbázis mentése és visszaállítása.',
	'DebugModes'	=> [
		'0'		=> 'hibakeresés kikapcsolva',
		'1'		=> 'csak a teljes futási idő',
		'2'		=> 'teljes idő',
		'3'		=> 'teljes részletesség (DBMS, gyorsítótár stb.)',
	],
	'DebugSqlThreshold'			=> 'RDBMS teljesítményküszöb:',
	'DebugSqlThresholdInfo'		=> 'Részletes hibakeresési módban csak azokat a lekérdezéseket rögzíti, amelyek meghaladják a megadott másodpercek számát.',
	'DebugAdminOnly'			=> 'Zárt diagnosztika:',
	'DebugAdminOnlyInfo'		=> 'A program (és DBMS) hibakeresési adatait csak az adminisztrátor számára jeleníti meg.',

	'CachingSection'			=> 'Gyorsítótárazási beállítások',
	'Cache'						=> 'Renderelt oldalak gyorsítótárazása:',
	'CacheInfo'					=> 'A renderelt oldalakat helyi gyorsítótárban tárolja a későbbi betöltés gyorsítása érdekében. Csak nem regisztrált látogatókra érvényes.',
	'CacheTtl'					=> 'Gyorsítótárazott oldalak érvényességi ideje:',
	'CacheTtlInfo'				=> 'Az oldalakat nem tárolja gyorsítótárban hosszabb ideig, mint a megadott másodpercek száma.',
	'CacheSql'					=> 'DBMS lekérdezések gyorsítótárazása:',
	'CacheSqlInfo'				=> 'Bizonyos erőforrás-igényes SQL-lekérdezések eredményeit helyi gyorsítótárban tárolja.',
	'CacheSqlTtl'				=> 'Adatbázis gyorsítótár érvényességi ideje:',
	'CacheSqlTtlInfo'			=> 'Az SQL-lekérdezések eredményeit nem tárolja gyorsítótárban hosszabb ideig, mint a megadott másodpercek száma. 1200-nál nagyobb értékek használata nem ajánlott.',

	'LogSection'				=> 'Naplóbeállítások',
	'LogLevelUsage'				=> 'Naplózás használata:',
	'LogLevelUsageInfo'			=> 'A naplóban rögzített események minimális prioritása.',
	'LogThresholds'	=> [
		'0'		=> 'naplózás kikapcsolva',
		'1'		=> 'csak kritikus szint',
		'2'		=> 'a legmagasabb szinttől',
		'3'		=> 'magas szinttől',
		'4'		=> 'közepes szint',
		'5'		=> 'alacsony szinttől',
		'6'		=> 'a legalacsonyabb szinttől',
		'7'		=> 'minden rögzítése',
	],
	'LogDefaultShow'			=> 'Napló megjelenítési mód:',
	'LogDefaultShowInfo'		=> 'Alapértelmezés szerint a naplóban megjelenített események minimális prioritása.',
	'LogModes'	=> [
		'1'		=> 'csak kritikus szint',
		'2'		=> 'a legmagasabb szinttől',
		'3'		=> 'magas szinttől',
		'4'		=> 'közepes szint',
		'5'		=> 'alacsony szinttől',
		'6'		=> 'a legalacsonyabb szinttől',
		'7'		=> 'mindent megjelenít',
	],
	'LogPurgeTime'				=> 'Napló tárolási ideje:',
	'LogPurgeTimeInfo'			=> 'Az eseménynaplót a megadott napok számán túl törli.',

	'PrivacySection'			=> 'Adatvédelem',
	'AnonymizeIp'				=> 'Felhasználói IP-címek anonímizálása:',
	'AnonymizeIpInfo'			=> 'IP-címek anonímizálása, ahol alkalmazható (pl. oldalak, revíziók vagy hivatkozások esetén).',

	'ReverseProxySection'		=> 'Fordított proxy',
	'ReverseProxy'				=> 'Fordított proxy használata:',
	'ReverseProxyInfo'			=> 'Engedélyezze ezt a beállítást a távoli kliens helyes IP-címének meghatározásához az X-Forwarded-For fejlécekben tárolt információk vizsgálatával. Az X-Forwarded-For fejlécek szabványos mechanizmusok a fordított proxy szerveren (pl. Squid vagy Pound) keresztül csatlakozó kliensrendszerek azonosítására. A fordított proxy szerverek gyakran használatosak forgalmas webhelyek teljesítményének növelésére, valamint egyéb előnyöket nyújthatnak, mint például gyorsítótárazás, biztonság vagy titkosítás. Ha ez a WackoWiki telepítés fordított proxy mögött működik, engedélyezze ezt a beállítást, hogy a helyes IP-cím információt rögzítse a WackoWiki munkamenet-kezelésében, naplózásában, statisztikáiban és hozzáférés-kezelő rendszereiben. Ha bizonytalan ebben a beállításban, nincs fordított proxyja, vagy a WackoWiki közös tárhelyen működik, hagyja ezt a beállítást kikapcsolva.',
	'ReverseProxyHeader'		=> 'Fordított proxy fejléc:',
	'ReverseProxyHeaderInfo'	=> 'Állítsa be ezt az értéket, ha a proxy szerver az ügyfél IP-címét az X-Forwarded-For-től eltérő fejlécben küldi. Az "X-Forwarded-For" fejléc vesszővel és szóközzel elválasztott IP-címek listája, csak a legutolsó (bal szélső) kerül felhasználásra.',
	'ReverseProxyAddresses'		=> 'A reverse_proxy IP-címek tömbjét fogadja el:',
	'ReverseProxyAddressesInfo'	=> 'Ennek a tömbnek minden eleme bármelyik fordított proxy IP-címe lehet. Ezt a tömböt kitöltve a WackoWiki csak akkor bízik meg az X-Forwarded-For fejlécekben tárolt információban, ha a távoli IP-cím ezek közül az egyik, azaz a kérés a webkiszolgálóhoz a fordított proxyk egyikéről érkezik. Ellenkező esetben a kliens közvetlenül csatlakozhat a webkiszolgálóhoz, meghamisítva az X-Forwarded-For fejléceket.',

	'SessionSection'				=> 'Munkamenet-kezelés',
	'SessionStorage'				=> 'Munkamenet-tárolás:',
	'SessionStorageInfo'			=> 'Ez a beállítás meghatározza, hol tárolódnak a munkamenet adatai. Alapértelmezés szerint fájl vagy adatbázis alapú munkamenet-tárolás van kiválasztva.',
	'SessionModes'	=> [
		'1'		=> 'Fájl',
		'2'		=> 'Adatbázis',
	],
	'SessionNotice'					=> 'A munkamenet befejezésének okának megjelenítése:',
	'SessionNoticeInfo'				=> 'A munkamenet befejezésének okát jeleníti meg.',
	'LoginNotice'					=> 'Bejelentkezési értesítés:',
	'LoginNoticeInfo'				=> 'Megjeleníti a bejelentkezési értesítést.',

	'RewriteMode'					=> 'Használja a
mod_rewrite
-t:',
	'RewriteModeInfo'				=> 'Ha a webkiszolgáló támogatja ezt a funkciót, kapcsolja be, hogy "szép" címeket kapjon az oldalakhoz.
 Az érték felülírható a Settings osztály által futásidőben, függetlenül attól, hogy ki van-e kapcsolva, ha a HTTP_MOD_REWRITE be van kapcsolva.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Hozzáférés-vezérlésért és jogosultságokért felelős paraméterek.',
	'PermissionsSettingsUpdated'	=> 'Jogosultsági beállítások frissítve',

	'PermissionsSection'		=> 'Jogok és privilégiumok',
	'ReadRights'				=> 'Olvasási jogok alapértelmezés szerint:',
	'ReadRightsInfo'			=> 'Ezek a létrehozott gyökéroldalakhoz, valamint azokhoz az oldalakhoz vannak hozzárendelve, amelyeknél a szülő jogok nem határozhatók meg.',
	'WriteRights'				=> 'Írási jogok alapértelmezés szerint:',
	'WriteRightsInfo'			=> 'Ezek a létrehozott gyökéroldalakhoz, valamint azokhoz az oldalakhoz vannak hozzárendelve, amelyeknél a szülő jogok nem határozhatók meg.',
	'CommentRights'				=> 'Hozzászólási jogok alapértelmezés szerint:',
	'CommentRightsInfo'			=> 'Ezek a létrehozott gyökéroldalakhoz, valamint azokhoz az oldalakhoz vannak hozzárendelve, amelyeknél a szülő jogok nem határozhatók meg.',
	'CreateRights'				=> 'Aloldal létrehozási jogai alapértelmezés szerint:',
	'CreateRightsInfo'			=> 'Meghatározza a gyökéroldalak létrehozásának jogát, és hozzárendeli azokat az oldalakhoz, amelyeknél a szülő jogok nem határozhatók meg.',
	'UploadRights'				=> 'Feltöltési jogok alapértelmezés szerint:',
	'UploadRightsInfo'			=> 'Ezek a létrehozott gyökéroldalakhoz, valamint azokhoz az oldalakhoz vannak hozzárendelve, amelyeknél a szülő jogok nem határozhatók meg.',
	'RenameRights'				=> 'Globális átnevezési jog:',
	'RenameRightsInfo'			=> 'Az oldalak szabadon történő átnevezésének (áthelyezésének) jogosultsági listája.',

	'LockAcl'					=> 'Minden ACL csak olvashatóra zárása:',
	'LockAclInfo'				=> 'Felülírja az összes oldal ACL-beállítását csak olvashatóra.
Hasznos lehet, ha egy projekt befejeződött, bizonyos ideig biztonsági okokból le akarja zárni a szerkesztést, vagy vészhelyzet esetén.',
	'HideLocked'				=> 'Elérhetetlen oldalak elrejtése:',
	'HideLockedInfo'			=> 'Ha a felhasználónak nincs joga olvasni az oldalt, elrejti azt különböző oldallistákban (a szövegben elhelyezett link azonban továbbra is látható marad).',
	'RemoveOnlyAdmins'			=> 'Csak adminisztrátorok törölhetnek oldalakat:',
	'RemoveOnlyAdminsInfo'		=> 'Mindenki másnak megtagadja az oldalak törlésének jogát. Elsősorban a normál oldalak tulajdonosaira vonatkozik.',
	'OwnersRemoveComments'		=> 'Az oldaltulajdonosok törölhetik a hozzászólásokat:',
	'OwnersRemoveCommentsInfo'	=> 'Engedélyezi az oldaltulajdonosoknak, hogy moderálják a hozzászólásokat az oldalaikon.',
	'OwnersEditCategories'		=> 'Az oldaltulajdonosok szerkeszthetik az oldalak kategóriáit:',
	'OwnersEditCategoriesInfo'	=> 'Engedélyezi a tulajdonosoknak, hogy módosítsák a webhely kategórialistáját (szavak hozzáadása, szavak törlése), amely az oldalhoz van rendelve.',
	'TermHumanModeration'		=> 'Emberi moderáció időtartama:',
	'TermHumanModerationInfo'	=> 'A moderátorok csak akkor szerkeszthetik a hozzászólásokat, ha azokat ennyi nappal ezelőtt hozták létre (ez a korlátozás nem vonatkozik a téma utolsó hozzászólására).',

	'UserCanDeleteAccount'		=> 'A felhasználók törölhetik a saját fiókjukat',

	// Security settings
	'SecuritySettingsInfo'		=> 'A platform általános biztonságáért, biztonsági korlátozásokért és kiegészítő biztonsági alrendszerekért felelős paraméterek.',
	'SecuritySettingsUpdated'	=> 'A biztonsági beállítások frissítve',

	'AllowRegistration'			=> 'Online regisztráció:',
	'AllowRegistrationInfo'		=> 'Engedélyezi a felhasználók online regisztrációját. Ennek a lehetőségnek a letiltása megakadályozza a szabad regisztrációt, azonban a webhely adminisztrátora továbbra is regisztrálhat más felhasználókat.',
	'ApproveNewUser'			=> 'Új felhasználók jóváhagyása:',
	'ApproveNewUserInfo'		=> 'Engedélyezi az adminisztrátoroknak, hogy jóváhagyják a regisztrált felhasználókat. Csak a jóváhagyott felhasználók léphetnek be a webhelyre.',
	'PersistentCookies'			=> 'Állandó sütik:',
	'PersistentCookiesInfo'		=> 'Engedélyezi az állandó sütik használatát.',
	'DisableWikiName'			=> 'WikiNév tiltása:',
	'DisableWikiNameInfo'		=> 'Tiltja a WikiNév kötelező használatát. Lehetővé teszi a felhasználók hagyományos becenevekkel való regisztrációját, nem kötelezően NévCsaládnév formátumban.',
	'UsernameLength'			=> 'Felhasználónév hossza:',
	'UsernameLengthInfo'		=> 'A felhasználónevek minimális és maximális karakterhossza.',

	'EmailSection'				=> 'E-mail',
	'AllowEmailReuse'			=> 'E-mail cím újbóli használatának engedélyezése:',
	'AllowEmailReuseInfo'		=> 'Különböző felhasználók regisztrálhatnak ugyanazzal az e-mail címmel.',
	'EmailConfirmation'			=> 'E-mail megerősítés kikényszerítése:',
	'EmailConfirmationInfo'		=> 'A felhasználónak meg kell erősítenie az e-mail címét, mielőtt bejelentkezhetne.',
	'AllowedEmailDomains'		=> 'Engedélyezett e-mail tartományok:',
	'AllowedEmailDomainsInfo'	=> 'Engedélyezett e-mail tartományok vesszővel elválasztva, pl.
pelda.hu, local.lan
 stb., egyébként minden e-mail tartomány engedélyezett.',
	'ForbiddenEmailDomains'		=> 'Tiltott e-mail tartományok:',
	'ForbiddenEmailDomainsInfo'	=> 'Tiltott e-mail tartományok vesszővel elválasztva, pl.
pelda.hu, local.lan
 stb. (csak akkor hatékony, ha az engedélyezett e-mail tartományok listája üres)',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'CAPTCHA engedélyezése:',
	'EnableCaptchaInfo'			=> 'Ha engedélyezve van, a CAPTCHA megjelenik az alábbi esetekben vagy ha elér egy bizonyos biztonsági küszöböt.',
	'CaptchaComment'			=> 'Új hozzászólás:',
	'CaptchaCommentInfo'		=> 'A spam publikációk elleni védekezésként a nem regisztrált felhasználóknak egyszer meg kell oldaniuk a tesztet, mielőtt hozzászólást küldhetnének.',
	'CaptchaPage'				=> 'Új oldal:',
	'CaptchaPageInfo'			=> 'A spam publikációk elleni védekezésként a nem regisztrált felhasználóknak egyszer meg kell oldaniuk a tesztet, mielőtt új oldalt hozhatnának létre.',
	'CaptchaEdit'				=> 'Oldal szerkesztése:',
	'CaptchaEditInfo'			=> 'A spam publikációk elleni védekezésként a nem regisztrált felhasználóknak egyszer meg kell oldaniuk a tesztet, mielőtt szerkeszthetnék az oldalakat.',
	'CaptchaRegistration'		=> 'Regisztráció:',
	'CaptchaRegistrationInfo'	=> 'A spam publikációk elleni védekezésként a nem regisztrált felhasználóknak egyszer meg kell oldaniuk a tesztet, mielőtt regisztrálhatnának.',

	'TlsSection'				=> 'TLS beállítások',
	'TlsConnection'				=> 'TLS-kapcsolat:',
	'TlsConnectionInfo'			=> 'Használjon TLS-védett kapcsolatot. Aktiválja a szükséges előre telepített TLS-tanúsítványt a szerveren, különben elveszíti az admin felülethez való hozzáférést!
Ezzel meghatározza, hogy be legyen-e állítva a Cookie Secure Flag, a
secure
 flag meghatározza, hogy a sütiket csak biztonságos kapcsolatokon keresztül küldjék-e.',
	'TlsImplicit'				=> 'Kötelező TLS:',
	'TlsImplicitInfo'			=> 'Kényszerítse a klienst HTTP-ről HTTPS-re való átirányításra. Ha ez a lehetőség ki van kapcsolva, a kliens nyílt HTTP-csatornán keresztül böngészheti a webhelyet.',

	'HttpSecurityHeaders'		=> 'HTTP Biztonsági Fejlécek',
	'EnableSecurityHeaders'		=> 'Biztonsági fejlécek engedélyezése:',
	'EnableSecurityHeadersinfo'	=> 'Állítsa be a biztonsági fejléceket (keretfeltörés, clickjacking/XSS/CSRF védelem).
A CSP bizonyos helyzetekben problémákat okozhat (pl. fejlesztés során), vagy külső erőforrásokra támaszkodó bővítmények használatakor, mint például képek vagy szkriptek.
A Content Security Policy kikapcsolása biztonsági kockázatot jelent!',
	'Csp'						=> 'Content-Security-Policy (CSP):',
	'CspInfo'					=> 'A Content Security Policy konfigurálása magában foglalja annak eldöntését, hogy milyen irányelveket kíván érvényesíteni, majd ezek konfigurálását és a Content-Security-Policy használatát az irányelv létrehozásához.',
	'PolicyModes'	=> [
		'0'		=> 'kikapcsolva',
		'1'		=> 'szigorú',
		'2'		=> 'egyéni',
	],
	'PermissionsPolicy'			=> 'Permissions Policy:',
	'PermissionsPolicyInfo'		=> 'Az HTTP Permissions-Policy fejléc mechanizmust biztosít különböző erős böngészőfunkciók explicit engedélyezésére vagy tiltására.',
	'ReferrerPolicy'			=> 'Referrer Policy:',
	'ReferrerPolicyInfo'		=> 'A Referrer-Policy HTTP fejléc szabályozza, hogy a Referer fejlécben küldött hivatkozási információkat milyen kérésekkel együtt kell elküldeni.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[kikapcsolva]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> 'Felhasználói jelszavak kezelése',
	'PwdMinChars'				=> 'Minimum jelszóhossz:',
	'PwdMinCharsInfo'			=> 'A hosszabb jelszavak szükségszerűen biztonságosabbak, mint a rövidek (pl. 12-16 karakter).
A jelszó helyett javasolt a jelszómondatok használata.',
	'AdminPwdMinChars'			=> 'Adminisztrátori jelszó minimális hossza:',
	'AdminPwdMinCharsInfo'		=> 'A hosszabb jelszavak szükségszerűen biztonságosabbak, mint a rövidek (pl. 15-20 karakter).
A jelszó helyett javasolt a jelszómondatok használata.',
	'PwdCharComplexity'			=> 'Szükséges jelszóbonyolultság:',
	'PwdCharClasses'	=> [
		'0'		=> 'nem tesztelt',
		'1'		=> 'bármilyen betű + számok',
		'2'		=> 'kis- és nagybetűk + számok',
		'3'		=> 'kis- és nagybetűk + számok + speciális karakterek',
	],
	'PwdUnlikeLogin'			=> 'További bonyolítás:',
	'PwdUnlikes'	=> [
		'0'		=> 'nem tesztelt',
		'1'		=> 'a jelszó nem azonos a bejelentkezési névvel',
		'2'		=> 'a jelszó nem tartalmazza a felhasználónevet',
	],

	'LoginSection'				=> 'Bejelentkezés',
	'MaxLoginAttempts'			=> 'Bejelentkezési kísérletek maximális száma felhasználónként:',
	'MaxLoginAttemptsInfo'		=> 'Egyetlen fiókra engedélyezett bejelentkezési kísérletek száma, mielőtt az anti-spam bot feladat aktiválódik. Írjon be 0-t, hogy megakadályozza az anti-spam bot feladat aktiválódását különböző felhasználói fiókokra.',
	'IpLoginLimitMax'			=> 'Bejelentkezési kísérletek maximális száma IP-címenként:',
	'IpLoginLimitMaxInfo'		=> 'Egyetlen IP-címről engedélyezett bejelentkezési kísérletek küszöbszáma, mielőtt az anti-spam bot feladat aktiválódik. Írjon be 0-t, hogy megakadályozza az anti-spam bot feladat aktiválódását IP-címekről.',

	'FormsSection'				=> 'Űrlapok',
	'FormTokenTime'				=> 'Űrlap elküldésének maximális ideje:',
	'FormTokenTimeInfo'			=> 'Az az idő, ameddig a felhasználónak el kell küldenie az űrlapot (másodpercben).
Figyelem: az űrlap érvénytelenné válhat, ha a munkamenet lejár, függetlenül ettől a beállítástól.',

	'SessionLength'				=> 'Bejelentkezési süti élettartama:',
	'SessionLengthInfo'			=> 'A felhasználói bejelentkezési süti alapértelmezett élettartama (napokban).',
	'CommentDelay'				=> 'Anti-flood a hozzászólásoknál:',
	'CommentDelayInfo'			=> 'A felhasználók új hozzászólásai között minimális késleltetés (másodpercben).',
	'IntercomDelay'				=> 'Anti-flood személyes üzeneteknél:',
	'IntercomDelayInfo'			=> 'A felhasználók privát üzenetei között minimális késleltetés (másodpercben).',
	'RegistrationDelay'			=> 'Regisztrációs időküszöb:',
	'RegistrationDelayInfo'		=> 'A regisztrációs űrlap kitöltésének minimális időküszöbe, hogy megkülönböztessék a botokat az emberektől (másodpercben).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'A platform finomhangolásáért felelős paramétercsoport. Ne változtasson rajtuk, hacsak nem biztos a hatásukban.',
	'FormatterSettingsUpdated'	=> 'A formázási beállítások frissítve',

	'TextHandlerSection'		=> 'Szövegfeldolgozó',
	'Typografica'				=> 'Tipográfiai korrektor:',
	'TypograficaInfo'			=> 'Kikapcsolása némileg felgyorsítja a hozzászólások hozzáadásának és az oldal mentésének folyamatát.',
	'Paragrafica'				=> 'Bekezdésjelölések:',
	'ParagraficaInfo'			=> 'Hasonló az előző opcióhoz, de a nem működő automatikus tartalomjegyzék lekapcsolásához vezet:
{{toc}}
.',
	'AllowRawhtml'				=> 'Globális HTML támogatás:',
	'AllowRawhtmlInfo'			=> 'Ez az opció potenciálisan biztonsági kockázatot jelent egy nyílt weboldalon.',
	'SafeHtml'					=> 'HTML szűrés:',
	'SafeHtmlInfo'				=> 'Megakadályozza veszélyes HTML-objektumok mentését. A szűrő kikapcsolása HTML-támogatással rendelkező nyílt weboldalon rendkívül nem kívánatos!',

	'WackoFormatterSection'		=> 'Wiki szövegformázó (Wacko Formatter)',
	'X11colors'					=> 'X11 színek használata:',
	'X11colorsInfo'				=> 'Bővíti a rendelkezésre álló színeket a
??(szín) háttér??
 és
!!(szín) szöveg!!
 formátumokhoz. Kikapcsolása némileg felgyorsítja a hozzászólások hozzáadásának és az oldalak mentésének folyamatát.',
	'WikiLinks'					=> 'Wikilink-ek tiltása:',
	'WikiLinksInfo'				=> 'Letiltja a
CamelCaseSzavak
 linkelését, így a CamelCase szavak többé nem lesznek közvetlenül új oldalhoz linkelve. Ez hasznos, amikor különböző névtérben vagy klaszterben dolgozik. Alapértelmezés szerint ki van kapcsolva.',
	'BracketsLinks'				=> 'Zárójeles linkek tiltása:',
	'BracketsLinksInfo'			=> 'Letiltja a
[[link]]
 és
((link))
 szintaxist.',
	'Formatters'				=> 'Formázók tiltása:',
	'FormattersInfo'			=> 'Letiltja a
%%kód%%
 szintaxist, amelyet kiemelőkhöz használnak.',

	'DateFormatsSection'		=> 'Dátumformátumok',
	'DateFormat'				=> 'A dátum formátuma:',
	'DateFormatInfo'			=> '(nap, hónap, év)',
	'TimeFormat'				=> 'Az idő formátuma:',
	'TimeFormatInfo'			=> '(óra, perc)',
	'TimeFormatSeconds'			=> 'A pontos idő formátuma:',
	'TimeFormatSecondsInfo'		=> '(óra, perc, másodperc)',
	'NameDateMacro'				=> 'A
::@::
 makró formátuma:',
	'NameDateMacroInfo'			=> '(név, idő), például
Felhasználónév (2016.11.17. 16:48)
',
	'Timezone'					=> 'Időzóna:',
	'TimezoneInfo'				=> 'Az időzóna, amelyet a be nem jelentkezett felhasználók (vendégek) számára megjelenítendő időpontokhoz használnak. A bejelentkezett felhasználók beállíthatják és megváltoztathatják az időzónájukat a felhasználói beállításaikban.',
	'AmericanDate'					=> 'Amerikai dátum:',
	'AmericanDateInfo'				=> 'Az amerikai dátumformátumot használja alapértelmezettként az angol nyelvhez.',

	'Canonical'					=> 'Teljes kanonikus URL-ek használata:',
	'CanonicalInfo'				=> 'Minden link abszolút URL-ként jön létre %1 formátumban. A szerver gyökeréhez kapcsolódó URL-ek használata %2 formátumban ajánlott.',
	'LinkTarget'				=> 'Külső linkek megnyitásának helye:',
	'LinkTargetInfo'			=> 'Minden külső link új böngészőablakban nyílik meg. Hozzáadja a
target="_blank"
 attribútumot a link szintaxisához.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Követeli, hogy a böngésző ne küldjön HTTP referer fejlécet, ha a felhasználó követi a hiperlinket. Hozzáadja a
rel="noreferrer"
 attribútumot a link szintaxisához.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Utasítja a keresőmotorokat, hogy a hiperlink ne befolyásolja a link célpontjának rangsorolását a keresőmotor indexében. Hozzáadja a
rel="nofollow"
 attribútumot a link szintaxisához.',
	'UrlsUnderscores'			=> 'URL-címek aláhúzásjelekkel:',
	'UrlsUnderscoresInfo'		=> 'Például a %1 %2 lesz ezzel az opcióval.',
	'ShowSpaces'				=> 'Szóközök megjelenítése WikiNevekben:',
	'ShowSpacesInfo'			=> 'Megjeleníti a szóközöket a WikiNevekben, például a
AzÉnNevem

Az Én Nevem
 formában jelenik meg ezzel az opcióval.',
	'NumerateLinks'				=> 'Linkek számozása nyomtatási nézetben:',
	'NumerateLinksInfo'			=> 'Számozza és listázza az összes linket a nyomtatási nézet alján ezzel az opcióval.',
	'YouareHereText'			=> 'Önhivatkozó linkek tiltása és megjelenítése:',
	'YouareHereTextInfo'		=> 'Megjeleníti az ugyanarra az oldalra mutató linkeket, próbálja ki a
<b>####</b>
 formátumot, az önhivatkozó linkek nem lesznek linkek, hanem félkövér szöveg.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Itt állíthatja be vagy módosíthatja a wiki rendszerének alapoldalait. Kérjük, hozza létre vagy módosítsa a wiki megfelelő oldalait az itt megadott beállításoknak megfelelően.',
	'PagesSettingsUpdated'		=> 'Alapoldalak beállításai frissítve',

	'ListCount'					=> 'Listánkénti elemek száma:',
	'ListCountInfo'				=> 'A vendégeknek vagy új felhasználók alapértelmezett értékének megjelenített elemek száma minden listán.',

	'ForumSection'				=> 'Fórum beállításai',
	'ForumCluster'				=> 'Fórum cluster:',
	'ForumClusterInfo'			=> 'A fórum szakasz gyökér clustere (action %1).',
	'ForumTopics'				=> 'Témák száma oldalanként:',
	'ForumTopicsInfo'			=> 'Megjelenített témák száma minden oldalon a fórum szakaszokban (action %1).',
	'CommentsCount'				=> 'Hozzászólások száma oldalanként:',
	'CommentsCountInfo'			=> 'Megjelenített hozzászólások száma minden oldalon a hozzászólások listáján. Ez vonatkozik az összes webhelyen lévő hozzászólásra, nem csak a fórumban közzétettre.',

	'NewsSection'				=> 'Hírek szakasz',
	'NewsCluster'				=> 'Hírek clustere:',
	'NewsClusterInfo'			=> 'A hírek szakaszának gyökér clustere (action %1).',
	'NewsStructure'				=> 'Hírek cluster szerkezete:',
	'NewsStructureInfo'			=> 'A cikkek opcionálisan év/hónap vagy hét szerinti alcclusterekben tárolhatók (pl.
[cluster]/[év]/[hónap]
).',

	'LicenseSection'			=> 'Licenc',
	'DefaultLicense'			=> 'Alapértelmezett licenc:',
	'DefaultLicenseInfo'		=> 'Milyen licenc alatt kerüljön közzétételre a tartalma.',
	'EnableLicense'				=> 'Licenc engedélyezése:',
	'EnableLicenseInfo'			=> 'Engedélyezi a licenc információk megjelenítését.',
	'LicensePerPage'			=> 'Licenc oldalanként:',
	'LicensePerPageInfo'		=> 'Engedélyezi az oldalankénti licencet, amelyet az oldal tulajdonosa az oldal tulajdonságain keresztül választhat.',

	'ServicePagesSection'		=> 'Szolgáltató oldalak',
	'RootPage'					=> 'Főoldal:',
	'RootPageInfo'				=> 'A főoldal azonosítója, amely automatikusan megnyílik, amikor a felhasználó meglátogatja a weboldalt.',

	'PrivacyPage'				=> 'Adatvédelmi irányelvek:',
	'PrivacyPageInfo'			=> 'Az oldal az adatvédelmi irányelvekkel.',

	'TermsPage'					=> 'Szabályzatok és rendelkezések:',
	'TermsPageInfo'				=> 'Az oldal a webhely szabályaival.',

	'SearchPage'				=> 'Keresés:',
	'SearchPageInfo'			=> 'Oldal a kereső űrlappal (action %1).',
	'RegistrationPage'			=> 'Regisztráció:',
	'RegistrationPageInfo'		=> 'Új felhasználó regisztrációs oldal (action %1).',
	'LoginPage'					=> 'Felhasználói bejelentkezés:',
	'LoginPageInfo'				=> 'Bejelentkezési oldal a webhelyen (action %1).',
	'SettingsPage'				=> 'Felhasználói beállítások:',
	'SettingsPageInfo'			=> 'Oldal a felhasználói profil testreszabásához (action %1).',
	'PasswordPage'				=> 'Jelszó megváltoztatása:',
	'PasswordPageInfo'			=> 'Oldal az űrlappal a felhasználói jelszó megváltoztatásához/visszaállításához (action %1).',
	'UsersPage'					=> 'Felhasználók listája:',
	'UsersPageInfo'				=> 'Oldal a regisztrált felhasználók listájával (action %1).',
	'CategoryPage'				=> 'Kategória:',
	'CategoryPageInfo'			=> 'Oldal a kategorizált oldalak listájával (action %1).',
	'GroupsPage'				=> 'Csoportok:',
	'GroupsPageInfo'			=> 'Oldal a munkacsoportok listájával (action %1).',
	'WhatsNewPage'				=> 'Újdonságok:',
	'WhatsNewPageInfo'			=> 'Oldal az összes új, törölt vagy módosított oldallal, új mellékletekkel és hozzászólásokkal. (action %1).',
	'ChangesPage'				=> 'Legutóbbi változások:',
	'ChangesPageInfo'			=> 'Oldal a legutóbb módosított oldalak listájával (action %1).',
	'CommentsPage'				=> 'Legutóbbi hozzászólások:',
	'CommentsPageInfo'			=> 'Oldal a legutóbbi hozzászólások listájával (action %1).',
	'RemovalsPage'				=> 'Törölt oldalak:',
	'RemovalsPageInfo'			=> 'Oldal a legutóbb törölt oldalak listájával (action %1).',
	'WantedPage'				=> 'Hiányzó oldalak:',
	'WantedPageInfo'			=> 'Oldal a hiányzó, de hivatkozott oldalak listájával (action %1).',
	'OrphanedPage'				=> 'Árva oldalak:',
	'OrphanedPageInfo'			=> 'Oldal a létező, de a többi oldallal nem kapcsolódó oldalak listájával (action %1).',
	'SandboxPage'				=> 'Homokozó:',
	'SandboxPageInfo'			=> 'Oldal, ahol a felhasználók gyakorolhatják a wiki jelölőnyelv használatát.',
	'HelpPage'					=> 'Súgó:',
	'HelpPageInfo'				=> 'Dokumentáció a webhelyeszközök használatáról.',
	'IndexPage'					=> 'Index:',
	'IndexPageInfo'				=> 'Oldal az összes oldal listájával (action %1).',
	'RandomPage'				=> 'Véletlenszerű oldal:',
	'RandomPageInfo'			=> 'Véletlenszerű oldalt tölt be (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'A platform értesítési paraméterei.',
	'NotificationSettingsUpdated'	=> 'Az értesítési beállítások frissítve',

	'EmailNotification'			=> 'E-mail értesítés:',
	'EmailNotificationInfo'		=> 'Engedélyezi az e-mail értesítéseket. Állítsa BE-re az e-mail értesítések engedélyezéséhez, KI-re a letiltásukhoz. Megjegyzés: az e-mail értesítések letiltása nem befolyásolja a felhasználói regisztrációs folyamat során generált e-maileket.',
	'Autosubscribe'				=> 'Automatikus feliratkozás:',
	'AutosubscribeInfo'			=> 'Automatikusan feliratkoztatja az új oldal tulajdonosát az oldal változásaira.',

	'NotificationSection'		=> 'Alapértelmezett felhasználói értesítési beállítások',
	'NotifyPageEdit'			=> 'Oldal szerkesztésének értesítése:',
	'NotifyPageEditInfo'		=> 'Függőben - E-mail értesítést csak az első változásról küldi el, amíg a felhasználó újra meg nem látogatja az oldalt.',
	'NotifyMinorEdit'			=> 'Kisebb szerkesztések értesítése:',
	'NotifyMinorEditInfo'		=> 'Értesítést küld a kisebb szerkesztésekről is.',
	'NotifyNewComment'			=> 'Új hozzászólás értesítése:',
	'NotifyNewCommentInfo'		=> 'Függőben - E-mail értesítést csak az első hozzászólásról küldi el, amíg a felhasználó újra meg nem látogatja az oldalt.',

	'NotifyUserAccount'			=> 'Új felhasználói fiók értesítése:',
	'NotifyUserAccountInfo'		=> 'Az adminisztrátort értesíti, amikor új felhasználó regisztrált a regisztrációs űrlapon keresztül.',
	'NotifyUpload'				=> 'Fájlfeltöltés értesítése:',
	'NotifyUploadInfo'			=> 'A moderátorokat értesíti, amikor fájlt töltöttek fel.',

	'PersonalMessagesSection'	=> 'Személyes üzenetek',
	'AllowIntercomDefault'		=> 'Intercom engedélyezése:',
	'AllowIntercomDefaultInfo'	=> 'Ezzel az opcióval más felhasználók személyes üzeneteket küldhetnek a címzett e-mail címére anélkül, hogy felfednék a címet.',
	'AllowMassemailDefault'		=> 'Kollektív e-mail engedélyezése:',
	'AllowMassemailDefaultInfo'	=> 'Csak azoknak a felhasználóknak küldi el az üzeneteket, akik engedélyezték az adminisztrátoroknak, hogy információkat küldjenek nekik e-mailben.',

	// Resync settings
	'Synchronize'				=> 'Szinkronizálás',
	'UserStatsSynched'			=> 'Felhasználói statisztikák szinkronizálva.',
	'PageStatsSynched'			=> 'Oldalstatisztikák szinkronizálva.',
	'FeedsUpdated'				=> 'RSS-hírcsatornák frissítve.',
	'SiteMapCreated'			=> 'Az új verziójú webhelytérkép sikeresen létrehozva.',
	'ParseNextBatch'			=> 'Következő oldalcsoport feldolgozása:',
	'WikiLinksRestored'			=> 'Wiki-hivatkozások visszaállítva.',

	'LogUserStatsSynched'		=> 'Felhasználói statisztikák szinkronizálva',
	'LogPageStatsSynched'		=> 'Oldalstatisztikák szinkronizálva',
	'LogFeedsUpdated'			=> 'RSS-hírcsatornák szinkronizálva',
	'LogPageBodySynched'		=> 'Oldaltörzs és hivatkozások újra feldolgozva',

	'UserStats'					=> 'Felhasználói statisztikák',
	'UserStatsInfo'				=> 'A felhasználói statisztikák (hozzászólások, tulajdonolt oldalak, revíziók és fájlok száma) bizonyos helyzetekben eltérhetnek a tényleges adatoktól.
Ez a művelet lehetővé teszi a statisztikák frissítését az adatbázis aktuális tényleges adataihoz.',
	'PageStats'					=> 'Oldalstatisztikák',
	'PageStatsInfo'				=> 'Az oldalstatisztikák (hozzászólások, fájlok és revíziók száma) bizonyos helyzetekben eltérhetnek a tényleges adatoktól.
Ez a művelet lehetővé teszi a statisztikák frissítését az adatbázis aktuális tényleges adataihoz.',

	'AttachmentsInfo'			=> 'Frissíti az adatbázisban lévő összes melléklet fájl hash-ét.',
	'AttachmentsSynched'		=> 'Az összes fájlmelléklet szinkronizálva',
	'LogAttachmentsSynched'		=> 'Az összes fájlmelléklet szinkronizálva',

	'Feeds'						=> 'Hírcsatornák',
	'FeedsInfo'					=> 'Az adatbázisban közvetlenül szerkesztett oldalak esetén az RSS-hírcsatornák tartalma nem tükrözheti a végrehajtott változtatásokat.
Ez a funkció szinkronizálja az RSS-csatornákat az adatbázis aktuális állapotával.',
	'XmlSiteMap'				=> 'XML-webhelytérkép',
	'XmlSiteMapInfo'			=> 'Ez a funkció szinkronizálja az XML-webhelytérképet az adatbázis aktuális állapotával.',
	'XmlSiteMapPeriod'			=> 'Időszak %1 nap. Utoljára írva: %2.',
	'XmlSiteMapView'			=> 'Webhelytérkép megjelenítése új ablakban.',

	'ReparseBody'				=> 'Minden oldal újra feldolgozása',
	'ReparseBodyInfo'			=> 'Kiüríti a
body_r
 mezőt az oldal táblában, így minden oldal újra lesz renderelve a következő oldalmegtekintéskor. Ez hasznos lehet, ha módosította a formázót vagy megváltoztatta a wiki domainjét.',
	'PreparsedBodyPurged'		=> 'A
body_r
 mező kiürítve az oldal táblában.',

	'WikiLinksResync'			=> 'Wiki-hivatkozások',
	'WikiLinksResyncInfo'		=> 'Végrehajtja az összes belső hivatkozás újra renderelését és visszaállítja a
page_link
 és
file_link
 táblák tartalmát sérülés vagy áthelyezés esetén (ez jelentős időt vehet igénybe).',
	'RecompilePage'				=> 'Minden oldal újra összeállítása (rendkívül költséges)',
	'ResyncOptions'				=> 'További beállítások',
	'RecompilePageLimit'		=> 'Egyszerre feldolgozandó oldalak száma.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Az alábbi információkat használja a wiki e-mailek küldésekor. Győződjön meg róla, hogy az megadott e-mail cím helyes, mivel minden nem kézbesíthető levél erre a címre fog érkezni. Ha a tárhelyszolgáltatója nem biztosít natív (PHP alapú) e-mail küldést, használhat helyette SMTP-t. Ehhez szükség van egy megfelelő szerver címére (ha szükséges, kérdezze meg szolgáltatóját). Ha (és csak ha) a szerver azonosítást igényel, adja meg a szükséges felhasználónevet, jelszót és azonosítási módot.',

	'EmailSettingsUpdated'		=> 'E-mail beállítások frissítve',

	'EmailFunctionName'			=> 'E-mail függvény neve:',
	'EmailFunctionNameInfo'		=> 'A PHP-n keresztüli e-mail küldéshez használt függvény neve.',
	'UseSmtpInfo'				=> '
SMTP
 Állítsa BE-re, ha a helyi mail függvény helyett egy meghatározott szerveren keresztül szeretné az e-maileket kiküldeni.',

	'EnableEmail'				=> 'E-mailek engedélyezése:',
	'EnableEmailInfo'			=> 'E-mailek engedélyezése',

	'EmailIdentitySettings'		=> 'Weboldal e-mailek azonosítása',
	'FromEmailName'				=> 'Küldő neve:',
	'FromEmailNameInfo'			=> 'A küldő neve, amely a weboldalról küldött összes e-mail értesítés
From:
 fejlécében szerepel.',
	'EmailSubjectPrefix'		=> 'Tárgy előtag:',
	'EmailSubjectPrefixInfo'	=> 'Alternatív e-mail tárgy előtag, pl.
[Előtag] Téma
. Ha nincs megadva, az alapértelmezett előtag a webhely neve: %1.',

	'NoReplyEmail'				=> 'Nem válaszolható cím:',
	'NoReplyEmailInfo'			=> 'Ez a cím, pl.
noreply@example.com
, megjelenik a weboldalról küldött összes e-mail értesítés
From:
 e-mail cím mezőjében.',
	'AdminEmail'				=> 'A webhely tulajdonosának e-mail címe:',
	'AdminEmailInfo'			=> 'Ez a cím adminisztrációs célokra használatos, például új felhasználó értesítésekor.',
	'AbuseEmail'				=> 'Visszaélési szolgáltatás e-mail címe:',
	'AbuseEmailInfo'			=> 'Sürgős ügyekben (külföldi e-mail címről történő regisztráció stb.) használt cím. Megegyezhet az előzővel.',

	'SendTestEmail'				=> 'Teszt e-mail küldése',
	'SendTestEmailInfo'			=> 'Ezzel a funkcióval teszt e-mailt küldhet a fiókjában megadott címre.',
	'TestEmailSubject'			=> 'A Wiki helyesen van konfigurálva e-mailek küldéséhez',
	'TestEmailBody'				=> 'Ha megkapta ezt az e-mailt, a Wiki helyesen van konfigurálva e-mailek küldéséhez.',
	'TestEmailMessage'			=> 'A teszt e-mail elküldve.
Ha nem kapta meg, kérjük, ellenőrizze az e-mail beállításait.',

	'SmtpSettings'				=> 'SMTP beállítások',
	'SmtpAutoTls'				=> 'Opportunistic TLS:',
	'SmtpAutoTlsInfo'			=> 'Automatikusan engedélyezi a titkosítást, ha a szerver TLS titkosítást támogat (miután csatlakozott a szerverhez), még akkor is, ha nem állította be a kapcsolati módot a
SMTPSecure
 beállításnál.',
	'SmtpConnectionMode'		=> 'SMTP azonosítási mód:',
	'SmtpConnectionModeInfo'	=> 'Csak akkor használatos, ha felhasználónév/jelszó páros meg van adva. Ha nem biztos benne, melyik módot használja, kérdezze meg szolgáltatóját.',
	'SmtpPassword'				=> 'SMTP jelszó:',
	'SmtpPasswordInfo'			=> 'Csak akkor adjon meg jelszót, ha a használt SMTP szerver megköveteli.
Figyelem: Ez a jelszó sima szövegként kerül tárolásra az adatbázisban, így bárki által elérhető, aki hozzáfér az adatbázishoz vagy látja ezt a beállítási oldalt.',
	'SmtpPort'					=> 'SMTP szerver portja:',
	'SmtpPortInfo'				=> 'Csak akkor változtassa meg, ha tudja, hogy az SMTP szerver más porton van.
(alapértelmezett:
tls
 port 587-en (vagy esetleg 25-ön) és
ssl
 port 465-ön)',
	'SmtpServer'				=> 'SMTP szerver címe:',
	'SmtpServerInfo'			=> 'Meg kell adnia a szerver által használt protokollt. Ha SSL-t használ, akkor a címnek
ssl://mail.example.com
 formátumúnak kell lennie.',
	'SmtpUsername'				=> 'SMTP felhasználónév:',
	'SmtpUsernameInfo'			=> 'Csak akkor adjon meg felhasználónevet, ha a használt SMTP szerver megköveteli.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Itt adhatja meg a mellékletek főbb beállításait, valamint módosíthatja a speciális kategóriák egyedi opcióit.',
	'UploadSettingsUpdated'		=> 'Feltöltési beállítások frissítve',

	'FileUploadsSection'		=> 'Fájlfeltöltés',
	'RegisteredUsers'			=> 'regisztrált felhasználók',
	'RightToUpload'				=> 'Fájlok feltöltésének joga:',
	'RightToUploadInfo'			=> '
admins
 csak az admin csoportba tartozó felhasználók tölthetnek fel fájlokat.
1
 a regisztrált felhasználók számára engedélyezi a feltöltést.
0
 letiltja a feltöltést.',
	'UploadMaxFilesize'			=> 'Maximális fájlméret:',
	'UploadMaxFilesizeInfo'		=> 'A feltölthető fájlok maximális mérete. A 0 érték letiltja a korlátozást.',
	'UploadQuota'				=> 'Mellékletek tárhelye:',
	'UploadQuotaInfo'			=> 'Az összes melléklet maximális helyfoglalása az egész wikin. A
0
 érték letiltja a korlátozást. %1 felhasználva.',
	'UploadQuotaUser'			=> 'Tárolási kvóta felhasználónként:',
	'UploadQuotaUserInfo'		=> 'Egy felhasználó által feltölthető adatok maximális mennyisége, a
0
 korlátlan.',

	'FileTypes'					=> 'Fájltípusok',
	'UploadOnlyImages'			=> 'Csak képek feltöltésének engedélyezése:',
	'UploadOnlyImagesInfo'		=> 'Csak képfájlok feltöltését engedélyezi a weboldalon.',
	'AllowedUploadExts'			=> 'Engedélyezett fájlkiterjesztések:',
	'AllowedUploadExtsInfo'		=> 'A feltölthető fájlok engedélyezett kiterjesztései, vesszővel elválasztva, pl.
png, ogg, mp4
, egyébként minden nem tiltott kiterjesztés engedélyezett.
A feltöltött fájltípusokat a webhely funkcionális szükségleteinek megfelelően a minimálisra kell korlátozni.',
	'CheckMimetype'				=> 'Mellékelt fájlok ellenőrzése:',
	'CheckMimetypeInfo'			=> 'Néhány böngésző hamis MIME típust állapíthat meg a feltöltött fájlokról. Ez a beállítás visszautasítja az ilyen fájlokat.',
	'SvgSanitizer'				=> 'SVG szanálás:',
	'SvgSanitizerInfo'			=> 'Engedélyezi a feltöltött SVG fájlok tisztítását, hogy megakadályozza sérülékeny SVG/XML fájlok feltöltését.',
	'TranslitFileName'			=> 'Fájlnevek átírása:',
	'TranslitFileNameInfo'		=> 'Ha lehetséges és nincs szükség Unicode karakterekre, erősen ajánlott csak alfanumerikus karaktereket elfogadni.',
	'TranslitCaseFolding'		=> 'Fájlnevek kisbetűssé alakítása:',
	'TranslitCaseFoldingInfo'	=> 'Ez a beállítás csak aktív átírás esetén érvényes.',

	'Thumbnails'				=> 'Bélyegképek',
	'CreateThumbnail'			=> 'Bélyegkép készítése:',
	'CreateThumbnailInfo'		=> 'Minden lehetséges esetben készítsen bélyegképet.',
	'ImageQuality'				=> 'Image Quality Preset:',
	'ImageQualityInfo'			=> 'Quality when scaling a thumbnail. Presets that pick per-codec values which produce a comparable perceptual result.',
	'MaxImageArea'				=> 'Maximális képterület:',
	'MaxImageAreaInfo'			=> 'A forráskép maximális pixeleinek száma. Ez korlátozza a kép méretezési dekompressziós oldalának memóriafelhasználását. A
-1
 azt jelenti, hogy nem ellenőrzi a kép méretét a méretezés előtt. A
0
 azt jelenti, hogy az érték automatikusan van meghatározva.',
	'MaxThumbWidth'				=> 'Maximális bélyegkép szélesség képpontban:',
	'MaxThumbWidthInfo'			=> 'A generált bélyegkép nem lesz szélesebb, mint itt meg van adva.',
	'MinThumbFilesize'			=> 'Minimális bélyegkép fájlméret:',
	'MinThumbFilesizeInfo'		=> 'Ennél kisebb képeknél nem készül bélyegkép.',
	'MaxImageWidth'				=> 'Képméret-korlátozás az oldalakon:',
	'MaxImageWidthInfo'			=> 'A kép maximális szélessége az oldalakon, ellenkező esetben a rendszer egy kicsinyített bélyegképet generál.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Törölt oldalak, revíziók és fájlok listája. Véglegesen törölheti vagy visszaállíthatja az adatbázisból az oldalakat, revíziókat vagy fájlokat az adott sorban lévő Törlés vagy Visszaállítás linkre kattintva. (Figyelem, nincs törlés megerősítés!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Az automatikusan cenzúrázandó szavak listája a wikin.',
	'FilterSettingsUpdated'		=> 'A spam szűrő beállításai frissítve',

	'WordCensoringSection'		=> 'Szavak cenzúrázása',
	'SPAMFilter'				=> 'SPAM szűrő:',
	'SPAMFilterInfo'			=> 'SPAM szűrő engedélyezése',
	'WordList'					=> 'Szavak listája:',
	'WordListInfo'				=> 'Feketelistára tett szó vagy kifejezés
töredék
 (soronként egy)',

	// Log module
	'LogFilterTip'				=> 'Események szűrése kritériumok szerint:',
	'LogLevel'					=> 'Szint',
	'LogLevelFilters'	=> [
		'1'		=> 'nem kisebb mint',
		'2'		=> 'nem magasabb mint',
		'3'		=> 'egyenlő',
	],
	'LogDate'					=> 'Dátum',
	'LogEvent'					=> 'Esemény',
	'LogUsername'				=> 'Felhasználónév',
	'LogLevels'	=> [
		'1'		=> 'kritikus',
		'2'		=> 'legmagasabb',
		'3'		=> 'magas',
		'4'		=> 'közepes',
		'5'		=> 'alacsony',
		'6'		=> 'legalacsonyabb',
		'7'		=> 'hibakeresés',
	],

	'LogCollapse'        => 'collapse',
	'LogExpand'          => 'expand',
	'LogType'              => 'Type',
	'LogSearch'            => 'Search',
	'LogSearchPlaceholder' => 'search messages...',
	'LogUserId'            => 'User ID',
	'LogExactMatch'        => 'exact match',
	'LogFrom'              => 'From',
	'LogTo'                => 'To',
	'LogSupportKey'        => 'Support key',
	'LogContext'           => 'Context',
	'LogTarget'            => 'Target',
	'LogUserAgent'         => 'User agent',
	'LogReferer'           => 'Referer',
	'LogTotal'             => 'Total',
	'LogFilteredBy'        => 'Filtered by',
	'LogClearFilter'       => 'Clear filter',
	'LogActions'           => 'Actions',
	'LogDelete'            => 'Delete',
	'LogDeleteConfirm'     => 'Delete this log entry?',
	'LogDeleteSelected'    => 'Delete selected',
	'LogBulkAction'        => '— bulk action —',
	'LogApply'             => 'Apply',
	'LogExportCSV'         => 'Export CSV',
	'LogExportJSON'        => 'Export JSON',
	'LogPurged'            => 'Log table truncated.',
	'LogPurgedFiltered'     => '%1 log entries deleted by filter.',
	'LogDeleted'           => 'Log entry deleted.',
	'LogDeletedBulk'        => '%1 log entries deleted.',
	'LogPurgeSection'      => 'Destructive operations',
	'LogPurgeWarning'      => 'There are %1 entries matching the current view. Use with care.',
	'LogPurgeConfirm'      => 'I understand this will permanently delete log entries',
	'LogPurgeFiltered'     => 'Purge matching filter',
	'LogPurgeFilteredConfirm' => 'Delete all entries matching the current filter? This cannot be undone.',
	'LogPurgeAll'          => 'Purge ENTIRE log',
	'LogPurgeAllConfirm'   => 'Delete EVERY log entry in the database? This cannot be undone.',
	'LogFindRelated'       => 'Find related entries',
	'LogNoMatch'           => 'No log entries match the current filter.',

	'LogMarkAll'                => 'Mark all rows on this page',
	'LogMarkNone'               => 'Unmark all rows',
	'LogSelectRow'              => 'Select row',

	// Massemail module
	'MassemailInfo'				=> 'Itt küldhetsz e-mailt az összes olyan felhasználónak vagy egy meghatározott csoport tagjainak, akik engedélyezték a csoportos e-mailek fogadását. Ez a következőképpen történik: a megadott adminisztrátori e-mail címre egy e-mail kerül kiküldésre, és a címzettek titkos másolatot kapnak ebből a levélből. Alapértelmezés szerint egy levélben maximum 50 címzett szerepelhet, ennél több címzett esetén több levél kerül kiküldésre. Ha sok embernek küldesz e-mailt, kérjük, légy türelmes az űrlap elküldése után, és ne szakítsd meg az oldal betöltését félúton. Teljesen normális, hogy a csoportos e-mail küldése időigényes; amint a szkript befejezte a futását, értesítést kapsz.',
	'LogMassemail'				=> 'Csoportos e-mail küldve %1 csoportnak/felhasználónak',
	'MassemailSend'				=> 'Csoportos e-mail küldése',

	'NoEmailMessage'			=> 'Az üzenetet meg kell adnod.',
	'NoEmailSubject'			=> 'Az üzenet témáját meg kell adnod.',
	'NoEmailRecipient'			=> 'Legalább egy felhasználót vagy felhasználói csoportot meg kell adnod.',

	'MassemailSection'			=> 'Csoportos e-mail',
	'MessageSubject'			=> 'Téma:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Az Ön üzenete:',
	'YourMessageInfo'			=> 'Kérjük, vegye figyelembe, hogy csak sima szöveget adhatsz meg. Az elküldés előtt minden kód eltávolításra kerül.',

	'NoUser'					=> 'Nincs felhasználó',
	'NoUserGroup'				=> 'Nincs felhasználói csoport',

	'SendToGroup'				=> 'Címzett csoport:',
	'SendToUser'				=> 'Címzett felhasználók:',
	'SendToUserInfo'			=> 'Csak azoknak a felhasználóknak küldi el az üzenetet, akik engedélyezték az adminisztrátoroknak, hogy információkat küldjenek nekik e-mailben. Ez a beállítás elérhető a felhasználói beállításaiknál az Értesítések alatt.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Rendszerüzenet frissítve',

	'SysMsgSection'				=> 'Rendszerüzenet',
	'SysMsg'					=> 'Rendszerüzenet:',
	'SysMsgInfo'				=> 'Ide írhatja a szövegét',

	'SysMsgType'				=> 'Típus:',
	'SysMsgTypeInfo'			=> 'Üzenet típusa (CSS).',
	'SysMsgAudience'			=> 'Célközönség:',
	'SysMsgAudienceInfo'		=> 'Kik láthatják a rendszerüzenetet.',
	'EnableSysMsg'				=> 'Rendszerüzenet engedélyezése:',
	'EnableSysMsgInfo'			=> 'Rendszerüzenet megjelenítése.',

	// User approval module
	'ApproveNotExists'			=> 'Kérjük, válasszon ki legalább egy felhasználót a Beállítás gombbal.',

	'LogUserApproved'			=> 'Felhasználó ##%1## jóváhagyva',
	'LogUserBlocked'			=> 'Felhasználó ##%1## blokkolva',
	'LogUserDeleted'			=> 'Felhasználó ##%1## törölve az adatbázisból',
	'LogUserCreated'			=> 'Új felhasználó ##%1## létrehozva',
	'LogUserUpdated'			=> 'Felhasználó ##%1## frissítve',
	'LogUserPasswordReset'		=> 'Felhasználó ##%1## jelszava sikeresen visszaállítva',

	'UserApproveInfo'			=> 'Jóváhagyja az új felhasználókat, mielőtt be tudnának jelentkezni a weboldalra.',
	'Approve'					=> 'Jóváhagyás',
	'Deny'						=> 'Elutasítás',
	'Pending'					=> 'Függőben',
	'Approved'					=> 'Jóváhagyva',
	'Denied'					=> 'Elutasítva',

	// DB Backup module
	'BackupStructure'			=> 'Szerkezet',
	'BackupData'				=> 'Adatok',
	'BackupFolder'				=> 'Mappa',
	'BackupTable'				=> 'Tábla',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'Fájlok',
	'BackupNote'				=> 'Megjegyzés:',
	'BackupSettings'			=> 'Adja meg a kívánt mentési sémát.
' .
    	'A gyökér cluster nem befolyásolja a globális fájlok és gyorsítótárfájlok mentését (ha kiválasztja őket, mindig teljes mértékben mentésre kerülnek).
' .  '<br>' .
		'Figyelem: A gyökér cluster megadása esetén az adatbázis információvesztésének elkerülése érdekében a mentésből ezek a táblák nem lesznek újrastrukturálva.',
	'BackupCompleted'			=> 'A mentés és archiválás befejeződött.
' .
    	'A mentési csomagfájlok a %1 alkönyvtárban kerültek tárolásra.
',
	'LogSavedBackup'			=> 'Adatbázis mentés ##%1## mentve',
	'Backup'					=> 'Mentés',
	'CantReadFile'				=> 'Nem lehet olvasni a %1 fájlt.',

	// DB Restore module
	'RestoreInfo'				=> 'Visszaállíthat bármelyik megtalált mentési csomagot vagy eltávolíthatja azt a szerverről.',
	'ConfirmDbRestore'			=> 'Biztosan vissza akarja állítani a %1 mentést?',
	'ConfirmDbRestoreInfo'		=> 'Kérjük, várjon, ez néhány percet igénybe vehet.',
	'RestoreWrongVersion'		=> 'Hibás WackoWiki verzió!',
	'DirectoryNotExecutable'	=> 'A %1 könyvtár nem futtatható.',
	'BackupDelete'				=> 'Biztosan el akarja távolítani a %1 mentést?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'További visszaállítási opciók:',
	'RestoreOptionsInfo'		=> '* Cluster mentés visszaállítása előtt ' .
									'a cél táblák nem törlődnek (hogy elkerüljék az információvesztést a nem mentett clusterekből). ' .
									'Így a visszaállítási folyamat során duplikált rekordok keletkezhetnek. ' .
									'Normál módban ezek mindegyike a mentés rekordjaival lesz helyettesítve (az SQL
REPLACE
 utasításával), ' .
									'de ha ezt a jelölőnégyzetet bejelöli, a duplikált rekordok kihagyásra kerülnek (a rekordok aktuális értékei megmaradnak), ' .
									'és csak az új kulcsú rekordok kerülnek hozzáadásra a táblához (SQL
INSERT IGNORE
 utasítás).
' .
									'Megjegyzés: Teljes weboldal mentés visszaállítása esetén ez az opció értéktelen.
' .
									'<br>' .
									'** Ha a mentés felhasználói fájlokat tartalmaz (globális és oldalonkénti, gyorsítótárfájlok stb.), ' .
									'normál módban ezek felülírják a meglévő azonos nevű fájlokat és ugyanabba a könyvtárba kerülnek visszaállításkor. ' .
									'Ez az opció lehetővé teszi, hogy megőrizze a fájlok aktuális másolatait és a mentésből csak az új fájlokat állítsa vissza (amelyek hiányoznak a szerverről).',
	'IgnoreDuplicatedKeysNr'	=> 'Duplikált táblakulcsok kihagyása (nem cseréljük le)',
	'IgnoreSameFiles'			=> 'Azonos fájlok kihagyása (nem írjuk felül)',
	'NoBackupsAvailable'		=> 'Nincs elérhető mentés.',
	'BackupEntireSite'			=> 'Teljes weboldal',
	'BackupRestored'			=> 'A mentés visszaállítva, alább a összefoglaló jelentés található. A mentési csomag törléséhez kattintson',
	'BackupRemoved'				=> 'A kiválasztott mentés sikeresen eltávolítva.',
	'LogRemovedBackup'			=> 'Adatbázis mentés ##%1## eltávolítva',

	'DbEngineInvalid'			=> 'Érvénytelen adatbázis motor, %1 várható',
	'RestoreStarted'			=> 'Visszaállítás elindítva',
	'RestoreParameters'			=> 'Használt paraméterek',
	'IgnoreDuplicatedKeys'		=> 'Duplikált kulcsok kihagyása',
	'IgnoreDuplicatedFiles'		=> 'Duplikált fájlok kihagyása',
	'SavedCluster'				=> 'Mentett cluster',
	'DataProtection'			=> 'Adatvédelem - %1 kihagyva',
	'AssumeDropTable'			=> '%1 feltételezése',
	'RestoreSQLiteDatabase'		=> 'SQLite adatbázis visszaállítása',
	'SQLiteDatabaseRestored'	=> 'Az adatbázis sikeresen visszaállítva:',
	'RestoreTableStructure'		=> 'Tábla szerkezetének visszaállítása',
	'RunSqlQueries'				=> 'SQL utasítások végrehajtása:',
	'CompletedSqlQueries'		=> 'Befejezve. Feldolgozott utasítások:',
	'NoTableStructure'			=> 'A táblák szerkezete nem került mentésre - kihagyás',
	'RestoreRecords'			=> 'Táblák tartalmának visszaállítása',
	'ProcessTablesDump'			=> 'Csak a táblák dumpjának letöltése és feldolgozása',
	'Instruction'				=> 'Utasítás',
	'RestoredRecords'			=> 'rekordok:',
	'RecordsRestoreDone'		=> 'Befejezve. Összes bejegyzés:',
	'SkippedRecords'			=> 'Adatok nem lettek mentve - kihagyás',
	'RestoringFiles'			=> 'Fájlok visszaállítása',
	'DecompressAndStore'		=> 'Könyvtárak tartalmának kibontása és tárolása',
	'HomonymicFiles'			=> 'azonos nevű fájlok',
	'RestoreSkip'				=> 'kihagyás',
	'RestoreReplace'			=> 'csere',
	'RestoreFile'				=> 'Fájl:',
	'RestoredFiles'				=> 'visszaállítva:',
	'SkippedFiles'				=> 'kihagyva:',
	'FileRestoreDone'			=> 'Befejezve. Összes fájl:',
	'FilesAll'					=> 'összes:',
	'SkipFiles'					=> 'Fájlok nem lettek tárolva - kihagyás',
	'RestoreDone'				=> 'VISSZAÁLLÍTÁS BEFEJEZVE',

	'BackupCreationDate'		=> 'Létrehozás dátuma',
	'BackupPackageContents'		=> 'A csomag tartalma',
	'BackupRestore'				=> 'Visszaállítás',
	'BackupRemove'				=> 'Eltávolítás',
	'RestoreYes'				=> 'Igen',
	'RestoreNo'					=> 'Nem',
	'LogDbRestored'				=> 'Adatbázis mentés ##%1## visszaállítva.',

	'BackupArchived'			=> '%1 mentés archiválva.',
	'BackupArchiveExists'		=> 'A %1 mentés archívuma már létezik.',
	'LogBackupArchived'			=> 'Mentés ##%1## archiválva.',

	// User module
	'UsersInfo'					=> 'Itt módosíthatja a felhasználók adatait és bizonyos speciális beállításokat.',

	'UsersAdded'				=> 'Felhasználó hozzáadva',
	'UsersDeleteInfo'			=> '[Felhasználó törléséről szóló információ...]',
	'EditButton'				=> 'Szerkesztés',
	'UsersAddNew'				=> 'Új felhasználó hozzáadása',
	'UsersDelete'				=> 'Biztosan el akarja távolítani a %1 felhasználót?',
	'UsersDeleted'				=> 'A %1 felhasználó törlésre került az adatbázisból.',
	'UsersRename'				=> 'A %1 felhasználó átnevezése erre:',
	'UsersRenameInfo'			=> '* Megjegyzés: A változtatás az összes ehhez a felhasználóhoz rendelt oldalt érinti.',
	'UsersUpdated'				=> 'Felhasználó sikeresen frissítve.',

	'UserIP'					=> 'IP-cím',
	'UserSignuptime'			=> 'Regisztráció időpontja',
	'UserActions'				=> 'Műveletek',
	'NoMatchingUser'			=> 'Nincsenek megfelelő kritériumoknak megfelelő felhasználók',

	'UserAccountNotify'			=> 'Értesítse a felhasználót',
	'UserNotifySignup'			=> 'tájékoztassa a felhasználót az új fiókról',
	'UserVerifyEmail'			=> 'állítsa be az e-mail megerősítő tokent és adjon hozzá linket az e-mail ellenőrzéséhez',
	'UserReVerifyEmail'			=> 'E-mail megerősítő token újraküldése',

	// Groups module
	'GroupsInfo'				=> 'Ebből a felületről kezelheti az összes felhasználói csoportját. Törölhet, létrehozhat és szerkeszthet meglévő csoportokat. Emellett kijelölhet csoportvezetőket, beállíthatja a csoport nyitott/rejtett/zárt státuszát, valamint módosíthatja a csoport nevét és leírását.',

	'LogMembersUpdated'			=> 'Felhasználói csoport tagjai frissítve',
	'LogMemberAdded'			=> 'Tag ##%1## hozzáadva a ##%2## csoporthoz',
	'LogMemberRemoved'			=> 'Tag ##%1## eltávolítva a ##%2## csoportból',
	'LogGroupCreated'			=> 'Új ##%1## csoport létrehozva',
	'LogGroupRenamed'			=> '##%1## csoport átnevezve ##%2##-ra',
	'LogGroupRemoved'			=> '##%1## csoport törölve',

	'GroupsMembersFor'			=> 'Csoport tagjai',
	'GroupsDescription'			=> 'Leírás',
	'GroupsModerator'			=> 'Moderátor',
	'GroupsOpen'				=> 'Nyitott',
	'GroupsActive'				=> 'Aktív',
	'GroupsTip'					=> 'Kattintson a csoport szerkesztéséhez',
	'GroupsUpdated'				=> 'Csoportok frissítve',
	'GroupsAlreadyExists'		=> 'Ez a csoport már létezik.',
	'GroupsAdded'				=> 'Csoport sikeresen hozzáadva.',
	'GroupsRenamed'				=> 'Csoport sikeresen átnevezve.',
	'GroupsDeleted'				=> 'A %1 csoport törlésre került az adatbázisból és az összes oldalról.',
	'GroupsAdd'					=> 'Új csoport hozzáadása',
	'GroupsRename'				=> 'A %1 csoport átnevezése erre:',
	'GroupsRenameInfo'			=> '* Megjegyzés: A változtatás az összes ehhez a csoporthoz rendelt oldalt érinti.',
	'GroupsDelete'				=> 'Biztosan el akarja távolítani a %1 csoportot?',
	'GroupsDeleteInfo'			=> '* Megjegyzés: A változtatás az összes ehhez a csoporthoz tartozó tagot érinti.',
	'GroupsIsSystem'			=> 'A %1 csoport rendszerhez tartozik, ezért nem törölhető.',
	'GroupsStoreButton'			=> 'Csoportok mentése',
	'GroupsEditInfo'			=> 'A csoportok listájának szerkesztéséhez válassza ki a rádiógombot.',

	'GroupAddMember'			=> 'Tag hozzáadása',
	'GroupRemoveMember'			=> 'Tag eltávolítása',
	'GroupAddNew'				=> 'Csoport hozzáadása',
	'GroupEdit'					=> 'Csoport szerkesztése',
	'GroupDelete'				=> 'Csoport törlése',

	'MembersAddNew'				=> 'Új tag hozzáadása',
	'MembersAdded'				=> 'Új tag sikeresen hozzáadva a csoporthoz.',
	'MembersRemove'				=> 'Biztosan el akarja távolítani a %1 tagot?',
	'MembersRemoved'			=> 'A tag törlésre került a csoportból.',

	// Statistics module
	'DbStatSection'				=> 'Adatbázis-statisztikák',
	'DbTable'					=> 'Tábla',
	'DbRecords'					=> 'Bejegyzések',
	'DbSize'					=> 'Μέγεθος',
	'DbIndex'					=> 'Index',
	'DbTotal'					=> 'Összesen',

	'FileStatSection'			=> 'Fájlrendszer-statisztikák',
	'FileFolder'				=> 'Mappa',
	'FileFiles'					=> 'Fájlok',
	'FileSize'					=> 'Méret',
	'FileTotal'					=> 'Összesen',

	// Sysinfo module
	'SysInfo'					=> 'Verzióinformációk:',
	'SysParameter'				=> 'Paraméter',
	'SysValues'					=> 'Értékek',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Utolsó frissítés',
	'ServerOS'					=> 'Operációs rendszer',
	'ServerName'				=> 'Szerver neve',
	'WebServer'					=> 'Webszerver',
	'HttpProtocol'				=> 'HTTP-protokoll',
	'DbVersion'					=> 'Adatbázis',
	'SqlModesGlobal'			=> 'SQL-módok (globális)',
	'SqlModesSession'			=> 'SQL-módok (munkamenet)',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memória',
	'UploadFilesizeMax'			=> 'Maximális feltölthető fájlméret',
	'PostMaxSize'				=> 'Maximális POST méret',
	'MaxExecutionTime'			=> 'Maximális végrehajtási idő',
	'SessionPath'				=> 'Munkamenet elérési útja',
	'PhpDefaultCharset'			=> 'PHP alapértelmezett karakterkódolás',
	'GZipCompression'			=> 'GZip tömörítés',
	'PhpExtensions'				=> 'PHP-kiterjesztések',
	'ApacheModules'				=> 'Apache-modulok',

	// DB repair module
	'DbRepairSection'			=> 'Adatbázis-javítás',
	'DbRepair'					=> 'Adatbázis javítása',
	'DbRepairInfo'				=> 'Ez a szkript automatikusan kereshet és javíthat bizonyos gyakori adatbázis-problémákat. A javítás időigényes lehet, kérjük, legyen türelmes.',

	'DbOptimizeRepairSection'	=> 'Adatbázis javítása és optimalizálása',
	'DbOptimizeRepair'			=> 'Adatbázis javítása és optimalizálása',
	'DbOptimizeRepairInfo'		=> 'Ez a szkript optimalizálni is képes az adatbázist. Ez bizonyos esetekben javíthatja a teljesítményt. Az adatbázis javítása és optimalizálása időigényes lehet, és az adatbázis在此期间 zárolva lesz.',

	'TableOk'					=> 'A(z) %1 tábla rendben van.',
	'TableNotOk'				=> 'A(z) %1 tábla nem rendben van. A következő hibát jelzi: %2. A szkript megkísérli javítani ezt a táblát…',
	'TableRepaired'				=> 'A(z) %1 tábla sikeresen javítva.',
	'TableRepairFailed'			=> 'Nem sikerült javítani a(z) %1 táblát.
Hiba: %2',
	'TableAlreadyOptimized'		=> 'A(z) %1 tábla már optimalizálva van.',
	'TableOptimized'			=> 'A(z) %1 tábla sikeresen optimalizálva.',
	'TableOptimizeFailed'		=> 'Nem sikerült optimalizálni a(z) %1 táblát.
Hiba: %2',
	'TableNotRepaired'			=> 'Néhány adatbázis-probléma nem javítható.',
	'RepairsComplete'			=> 'A javítás befejeződött',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Következetlenségek megjelenítése és javítása, árva rekordok törlése vagy hozzárendelése egy új felhasználóhoz/értékhez.',
	'Inconsistencies'			=> 'Következetlenségek',
	'CheckDatabase'				=> 'Adatbázis',
	'CheckDatabaseInfo'			=> 'Ellenőrzi az adatbázisban a rekordok következetlenségeit.',
	'CheckFiles'				=> 'Fájlok',
	'CheckFilesInfo'			=> 'Ellenőrzi az elhagyott fájlokat, amelyekre már nincs hivatkozás a fájltáblában.',
	'Records'					=> 'Rekordok',
	'InconsistenciesNone'		=> 'Nem találtak adatkövetkezetlenségeket.',
	'InconsistenciesDone'		=> 'Az adatkövetkezetlenségek megoldva.',
	'InconsistenciesRemoved'	=> 'Következetlenségek eltávolítva',
	'Check'						=> 'Ellenőrzés',
	'Solve'						=> 'Megoldás',

	// Bad Behaviour module
	'BbInfo'					=> 'Észleli és blokkolja a nemkívánatos webes hozzáféréseket, megtagadja az automatizált spamrobotok hozzáférését
További információkért látogasson el a %1 weboldalára.',
	'BbEnable'					=> 'Bad Behaviour engedélyezése:',
	'BbEnableInfo'				=> 'Az összes többi beállítás módosítható a %1 konfigurációs mappában.',
	'BbStats'					=> 'A Bad Behaviour az elmúlt 7 napban %1 hozzáférési kísérletet blokkolt.',

	'BbSummary'					=> 'Összefoglaló',
	'BbLog'						=> 'Napló',
	'BbSettings'				=> 'Beállítások',
	'BbWhitelist'				=> 'Engedélyezési lista',

	// --> Log
	'BbHits'					=> 'Találatok',
	'BbRecordsFiltered'			=> '%1 megjelenítése %2 rekordból, szűrve',
	'BbStatus'					=> 'Állapot',
	'BbBlocked'					=> 'Blokkolva',
	'BbPermitted'				=> 'Engedélyezve',
	'BbIp'						=> 'IP-cím',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Összes %1 rekord megjelenítése',
	'BbShow'					=> 'Megjelenítés',
	'BbIpDateStatus'			=> 'IP-cím/Dátum/Állapot',
	'BbHeaders'					=> 'Fejlécek',
	'BbEntity'					=> 'Entitás',

	'BbSearchPlaceholder'        => 'Search UA, URI, IP, host, support_key, status…',
	'BbFilterAnyCategory'        => 'Any category',
	'BbFilterAnyMethod'          => 'Any method',
	'BbFilterAnyStatus'          => 'Any status',
	'BbFilterBlockedOnly'        => 'Blocked only',
	'BbFilterPermittedOnly'      => 'Permitted only',
	'BbFilterApply'              => 'Apply',
	'BbFilterClear'              => 'Clear filters',
	'BbChipSearch'               => 'Search',
	'BbChipCategory'             => 'Category',
	'BbChipMethod'               => 'Method',
	'BbChipStatus'               => 'Status',
	'BbChipRemove'               => 'Remove this filter',
	'BbFilterByCategory'         => 'Filter by this category',
	'BbSearchBySupportKey'       => 'Search for this support key',

	// === Check flag (operator-marked records, exempt from autodelete) ===
	'BbFilterAnyCheck'         => 'Any check status',
	'BbFilterCheckedOnly'      => 'Checked only',
	'BbFilterUncheckedOnly'    => 'Unchecked only',
	'BbChipCheck'              => 'Check status',
	'BbChecked'                => 'checked',
	'BbUnchecked'              => 'unchecked',
	'BbActionCheck'            => 'check',
	'BbActionUncheck'          => 'uncheck',
	'BbRowChecked'             => 'Log entry marked as checked',
	'BbRowUnchecked'           => 'Log entry unchecked',
	'BbRowCheckedHint'         => 'This record is checked — exempt from automatic cleanup',
	'BbRowUncheckedHint'       => 'Mark this record to keep it across automatic cleanup',
	'BbBulkCheckSelected'      => 'Mark checked',
	'BbBulkUncheckSelected'    => 'Unmark checked',
	'BbBulkChecked'            => 'Marked %1 entries as checked',
	'BbBulkUnchecked'          => 'Unmarked %1 entries',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Beállítások mentve.',
	'BbWhitelistHint'			=> 'A nem megfelelő engedélyezési lista SPAM-hez vezethet, vagy a Bad Behaviour teljes mértékben leállhat! NE ENGEDÉLYEZZEN, hacsak nem 100%-osan biztos abban, hogy ezt kell tennie.',
	'BbIpAddress'				=> 'IP-cím',
	'BbIpAddressInfo'			=> 'IP-cím vagy CIDR formátumú címtartományok engedélyezésre (soronként egy)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL-töredékek engedélyezésre a weboldal hosztneve utáni / karaktertől kezdődően (soronként egy)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'User Agent karakterláncok engedélyezésre (soronként egy)',

	// --> Settings
	'BbSettingsUpdated'			=> 'A Bad Behaviour beállításai frissítve',
	'BbLogRequest'				=> 'HTTP-kérés naplózása',
	'BbLogVerbose'				=> 'Részletes',
	'BbLogNormal'				=> 'Normál (ajánlott)',
	'BbLogOff'					=> 'Ne naplózzon (nem ajánlott)',
	'BbSecurity'				=> 'Biztonság',
	'BbStrict'					=> 'Szigorú ellenőrzés',
	'BbStrictInfo'				=> 'több spamet blokkol, de bizonyos felhasználókat is blokkolhat',
	'BbOffsiteForms'			=> 'Más weboldalakról érkező űrlapküldések engedélyezése',
	'BbOffsiteFormsInfo'		=> 'szükséges az OpenID-hez; növeli a kapott spam mennyiségét',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'A Bad Behaviour http:BL funkcióinak használatához szüksége van egy %1 kulcsra',
	'BbHttpblKey'				=> 'http:BL hozzáférési kulcs',
	'BbHttpblThreat'			=> 'Minimális fenyegetettségi szint (25 ajánlott)',
	'BbHttpblMaxage'			=> 'Adatok maximális életkora (30 ajánlott)',
	'BbReverseProxy'			=> 'Fordított proxy/terheléselosztó',
	'BbReverseProxyInfo'		=> 'Ha a Bad Behaviour-t fordított proxy, terheléselosztó, HTTP gyorsító, tartalomgyorsító vagy hasonló technológia mögött használja, engedélyezze a Fordított Proxy opciót.
' .
									'Ha két vagy több fordított proxy van a szerver és a nyilvános internet között, akkor adja meg az összes proxy szerver IP-címtartományát (CIDR formátumban). Ellenkező esetben a Bad Behaviour nem tudja meghatározni az ügyfél valódi IP-címét.
' .
									'Ezenkívül a fordított proxy szervereknek be kell állítaniuk az internetes ügyfél IP-címét, amelytől a kérést kapták, egy HTTP-fejlécben. Ha nem ad meg fejlécet, akkor %1 lesz használva. A legtöbb proxy szerver már támogatja az X-Forwarded-For-t, és csak biztosítania kell, hogy engedélyezve legyen a proxy szervereken. Más gyakran használt fejlécek közé tartozik a %2 és %3.',
	'BbReverseProxyEnable'		=> 'Fordított proxy engedélyezése',
	'BbReverseProxyHeader'		=> 'Fejléc, amely tartalmazza az internetes ügyfelek IP-címét',
	'BbReverseProxyAddresses'	=> 'Proxy szerverek IP-címe vagy CIDR formátumú címtartományai (soronként egy)',

	'BbBehavioral'           => 'Behavioral Analysis',
	'BbEnableBehavioral'     => 'Enable behavioral analysis (rate anomalies, rotating UA/IP)',
	'BbEnableBehavioralInfo' => 'Tracks request patterns per session. Safe to keep enabled.',
	'BbEnableFingerprinting' => 'Enable TLS/HTTP/2 fingerprinting (JA3, H2, header order)',
	'BbEnableFingerprintingInfo' => 'Blocks known bad fingerprints only. Requires enable_fingerprinting=true. May cause false positives on old browsers/proxies.',
	'BbInspectJson'          => 'Inspect JSON request bodies for attacks',
	'BbInspectJsonInfo'      => 'WARNING: Breaks AJAX/JSON APIs (wiki markup, code snippets trigger false positives). Keep OFF.',
	'BbInspectMultipart'     => 'Inspect multipart/form-data bodies for attacks',
	'BbInspectMultipartInfo' => 'WARNING: Breaks file uploads. Keep OFF.',

	'BbEnableClientHints'      => 'Enable Client Hints Validation',
	'BbEnableClientHintsInfo'  => 'Validate Sec-CH-UA headers against User-Agent to detect spoofed browsers (Chrome 89+).',
	'BbEnableAgentic'          => 'Enable Agentic Behavior Detection',
	'BbEnableAgenticInfo'      => 'Detect AI agent patterns: think-then-fetch, non-linear navigation, precision targeting.',
	'BbStrictSearchEngines'    => 'Strict search engines',
	'BbStrictSearchEnginesInfo' => 'Apply stricter checks to unverified search engine bots (Googlebot, Bingbot, …) before allowing them through.',
	'BbEnableDynamicIp'        => 'Enable Dynamic IP Range Fetching',
	'BbEnableDynamicIpInfo'    => 'Fetch official IP ranges from Google, Bing, OpenAI, Anthropic, Apple, etc. (cached 24h, stale fallback 7 days).',

	'BbAiCrawlers'           => 'AI Crawler Control',
	'BbBlockUnverifiedAi'    => 'Block unverified AI crawlers',
	'BbBlockUnverifiedAiInfo' => 'Blocks AI crawlers that fail DNS/IP verification (spoofed bots).',
	'BbStrictAi'             => 'Strict AI mode (block even verified unallowed AI)',
	'BbStrictAiInfo'         => 'Blocks ALL AI crawlers not in allowed list, even if verified.',
	'BbAllowedAiCrawlers'    => 'Allowed AI crawler tokens (one per line)',
	'BbAllowedAiCrawlersInfo' => 'Tokens: GPTBot, ClaudeBot, Google-Extended, PerplexityBot, Meta-ExternalAgent, Applebot-Extended, CCBot, ia_archiver',

	'BbDnsbl'                => 'DNSBL / http:BL',
	'BbDnsblEnabled'         => 'Enable DNSBL checks',
	'BbDnsblLists'           => 'DNSBL lists (one per line)',
	'BbDnsblListsInfo'       => 'Default: zen.spamhaus.org, bl.spamcop.net',

	'BbRateLimits'           => 'Rate Limiting',
	'BbRateLimitEnabled'     => 'Enable rate limiting',
	'BbRateGlobalRequests'   => 'Global requests per window',
	'BbRateGlobalWindow'     => 'Global window (seconds)',
	'BbRatePerMinuteRequests'=> 'Per-minute requests',
	'BbRatePerMinuteWindow'  => 'Per-minute window (seconds)',
	'BbRatePostRequests'     => 'POST requests per window',
	'BbRatePostWindow'       => 'POST window (seconds)',
	'BbRateLoginRequests'    => 'Login requests per window',
	'BbRateLoginWindow'      => 'Login window (seconds)',

	'BbChallenge'            => 'Challenge System',
	'BbChallengeEnabled'     => 'Enable challenges',
	'BbChallengeProvider'    => 'Challenge provider',
	'BbChallengeSiteKey'     => 'Site key',
	'BbChallengeSecretKey'   => 'Secret key',
	'BbRecaptchaMinScore'    => 'reCAPTCHA v3 min score',

	'BbPerformance'          => 'Performance',
	'BbSkipExtensions'       => 'Skip extensions (one per line)',
	'BbSkipPaths'            => 'Skip path prefixes (one per line)',

	'BbGeoip'                => 'GeoIP / ASN Blocking',
	'BbGeoipEnabled'         => 'Enable GeoIP lookups',
	'BbGeoipDbPath'          => 'MaxMind DB path',
	'BbBlockedCountries'     => 'Blocked countries (ISO codes, one per line)',
	'BbBlockedAsns'          => 'Blocked ASNs (one per line)',

	'BbBlockPage'                  => 'Block Page',
	'BbShowDetailedBlockPage'      => 'Show detailed block page',
	'BbShowDetailedBlockPageInfo'  => 'Show reason, request URI, and technical support key on the block page. Recommended for production.',
	'BbShowContactInfo'            => 'Show contact info on block page',
	'BbShowContactInfoInfo'        => 'Show admin email on the block page (only takes effect when detailed block page is enabled).',
	'BbSettingsSaveFailed'         => 'Failed to save Bad Behaviour settings',

	// === Basic section ===
	'BbBasicSection'      => 'Basic settings',
	'BbAdvancedSection'   => 'Advanced settings',
	'BbAdvancedHint'      => 'Most operators should not need to change these.',

	// === Basic knobs ===
	'BbPreset'            => 'Bot preset',
	'BbPresetInfo'        => 'Which bots to recognize. "minimal" (default) is fastest; "full" is most thorough.',
	'BbStrictness'        => 'Blocking posture',
	'BbStrictnessInfo'    => 'monitor-only logs but blocks nothing; normal blocks verified attackers; strict blocks aggressively.',
	'BbLoggingMode'       => 'Logging',
	'BbLoggingModeInfo'   => 'Normal (recommended), Verbose (logs every request), Off',
	'BbLogModeNormal'     => 'Normal',
	'BbLogModeVerbose'    => 'Verbose',
	'BbLogModeOff'        => 'Off',
	'BbBehindProxy'       => 'Site is behind a reverse proxy or CDN',
	'BbBehindProxyInfo'   => 'Enable if behind Cloudflare, AWS, GCP, Fastly, etc. You must add proxy IP ranges in Advanced — without them, real client IPs cannot be determined.',

	// === Advanced section headers ===
	'BbAdvCore'           => 'Core',
	'BbAdvReverseProxy'   => 'Reverse Proxy',
	'BbAdvAiCrawlers'     => 'AI Crawlers',
	'BbAdvBotCategories'  => 'Bot Categories',
	'BbAdvDnsVerification'=> 'DNS Verification',
	'BbAdvRateLimits'     => 'Rate Limiting',
	'BbAdvHeadDetection'  => 'Head Request Detection',
	'BbAdvAssetScraping'  => 'Asset Scraping Detection',
	'BbAdvDynamicIp'      => 'Dynamic IP Ranges',
	'BbAdvOnDemandRefresh'=> 'On-Demand IP Refresh',
	'BbAdvHttpbl'         => 'Project Honeypot http:BL',
	'BbAdvDnsbl'          => 'DNSBL',
	'BbAdvChallenge'      => 'Challenge / CAPTCHA',
	'BbAdvPerformance'    => 'Performance',
	'BbAdvGeoip'          => 'GeoIP / ASN Blocking',
	'BbAdvFingerprints'   => 'TLS / HTTP/2 Fingerprints',
	'BbAdvCustomRules'    => 'Custom Rules',
	'BbAdvBlockPage'      => 'Block Page',

	// === bot category labels (multi-checkbox) ===
	'BbCatSearchEngine'   => 'Search Engine',
	'BbCatAiCrawler'      => 'AI Crawler',
	'BbCatSocialCrawler'  => 'Social Crawler',
	'BbCatSeoCrawler'     => 'SEO Crawler',
	'BbCatArchiveCrawler' => 'Archive Crawler',
	'BbCatMonitoring'     => 'Monitoring',
	'BbCatFeedReader'     => 'Feed Reader',
	'BbCatShoppingCrawler'=> 'Shopping Crawler',
	'BbCatCloudInfra'     => 'Cloud Infrastructure',
	'BbCatSecurityScanner'=> 'Security Scanner',
	'BbCatResidentialProxy'=> 'Residential Proxy',
	'BbCatMalicious'      => 'Malicious',
	'BbCatUnknown'        => 'Unknown',

	// === on_demand_ip_refresh cloud providers ===
	'BbCloudProviderAws'        => 'AWS',
	'BbCloudProviderCloudflare' => 'Cloudflare',
	'BbCloudProviderFastly'     => 'Fastly',
	'BbCloudProviderGcp'        => 'Google Cloud',
	'BbCloudProvidersInfo'      => 'Limit on-demand refresh to specific providers. Empty = all four.',

	// === Log retention ===
	'BbAdvLogRetention'              => 'Log Retention',
	'BbLogRetentionEnabled'          => 'Enable automatic log cleanup',
	'BbLogRetentionEnabledInfo'      => 'Periodically delete log rows older than the retention window. Recommended for sites without cron access.',
	'BbLogRetentionMaxAgeDays'       => 'Retention window (days)',
	'BbLogRetentionMaxAgeDaysInfo'   => 'Rows older than this are deleted. Default: 7. Common values: 7, 14, 30, 90.',
	'BbLogRetentionMaxRows'          => 'Maximum row count (0 = no cap)',
	'BbLogRetentionMaxRowsInfo'      => 'If set, oldest rows are deleted whenever the table exceeds this size, regardless of age. Useful for high-traffic sites.',
	'BbLogRetentionProbability'       => 'Probability denominator (1 in N)',
	'BbLogRetentionProbabilityInfo'   => '1 in N requests checks the staleness gate. Higher = less DB load. Default: 1000.',
	'BbLogRetentionMinInterval'      => 'Minimum interval between cleanups (seconds)',
	'BbLogRetentionMinIntervalInfo'  => 'Hard floor on cleanup frequency. Default: 21600 (6h).',
	'BbLogRetentionLockTtl'          => 'Cleanup lock TTL (seconds)',
	'BbLogRetentionLockTtlInfo'      => 'How long the cleanup mutex is held. Default: 600 (10 min).',

	// === misc new fields ===
	'BbDnsVerificationEnabled'  => 'Enable DNS verification',
	'BbDnsVerificationInfo'     => 'Verify bot claims (e.g. Googlebot) by reverse-DNS lookup. Catches spoofed bots.',
	'BbDnsTimeoutMs'            => 'DNS lookup timeout (ms)',
	'BbDnsPositiveTtl'          => 'Positive cache TTL (seconds)',
	'BbDnsNegativeTtl'          => 'Negative cache TTL (seconds)',
	'BbDnsRequireForward'       => 'Require forward-confirm (PTR + A record match)',
	'BbDnsRequireForwardInfo'   => 'Catches PTR spoofing but adds latency and IPv6 FP risk.',

	'BbHeadRefererExemptPaths'  => 'HEAD exempt paths (one per line)',
	'BbHeadRefererExemptInfo'   => 'Paths where HEAD without Referer is legitimate (e.g. /api/, /wp-json/).',

	'BbAssetExtensionsLabel'    => 'Asset extensions to protect (one per line)',
	'BbAssetExtensionsInfo'     => 'File types watched for direct scraping without page loads.',

	'BbOnDemandBotIds'          => 'Bot IDs to refresh (empty = all)',
	'BbOnDemandBotIdsInfo'      => 'Restrict refresh to specific bots. Leave empty to refresh all registered bots.',
	'BbOnDemandProbability'     => 'Probability denominator (1 in N)',
	'BbOnDemandMinAge'          => 'Min cache age (seconds)',
	'BbOnDemandLockTtl'         => 'Lock TTL (seconds)',
	'BbOnDemandCacheTtl'        => 'Cache TTL (seconds)',
	'BbOnDemandFeedTimeout'     => 'Feed fetch timeout (seconds)',

	'BbDynamicIpTtl'            => 'Cache TTL (seconds)',
	'BbDynamicIpFeeds'          => 'Feeds to refresh (one per line)',

	// === Time-window selector / dashboards ===
	'BbLastSeen'             => 'Last seen',
	'BbSeverity'             => 'Severity',
	'BbStatusBreakdown'      => 'Status breakdown',
	'BbBotBreakdown'         => 'Bot breakdown',
	'BbTopBlocked'           => 'Top denied IPs',
	'BbGeoSummary'           => 'Geographic summary',
	'BbCountry'              => 'Country',
	'BbAsn'                  => 'ASN',
	'BbVerifiedPct'          => 'Verified %',
	'BbNoData'               => 'No data for the selected window',
	'BbCategory'             => 'Category',
	'BbResponseTime'         => 'Response time',
	'BbDateCol'              => 'Time / IP / Status',
	'BbSelectRow'            => 'Select row',

	// === Active-filter chips ===
	'BbChipSlow'             => 'Slow only',
	'BbChipDate'             => 'Date range',
	'BbChipResolved'         => 'Resolved',
	'BbChipStatusCode' => 'Status code',
	'BbChipIp'         => 'IP',
	'BbChipUa'         => 'UA',
	'BbChipUri'        => 'URI',
	'BbChipJa3'        => 'JA3',
	'BbChipAsn'        => 'ASN',
	'BbChipCountry'    => 'Country',

	// === Manage view additions ===
	'BbViewHeaders'          => 'View headers',
	'BbViewBody'             => 'View body',
	'BbViewContentLabel'     => 'Content',
	'BbViewModeFull'         => 'Full (always shown)',
	'BbViewModeTeaser'       => 'Teaser (click to expand)',
	'BbViewModeHidden'       => 'Hidden (show on demand)',
	'BbHide'                 => 'hide',
	'BbChars'                => 'chars',

	// === Custom rules ===
	'BbCustomRules'                => 'Custom Rules',
	'BbCustomRulesLabel'           => 'Custom rules (one JSON object per line)',
	'BbCustomRulesInfo'            => 'Each line is a JSON object with keys: type (ip|ua_regex|ua_contains|asn|country|header), value, action (allow|block|challenge|log), and id. Example: {"type":"ua_regex","value":"/Googlebot/i","action":"log","id":"audit_googlebot"}',

	// === Body scan ===
	'BbBodyScanSkipFields'         => 'Body scan skip fields',
	'BbBodyScanSkipFieldsInfo'     => 'One field name per line. Fields listed are skipped during SQL/XSS body inspection.',

	// === Advanced filters ===
	'BbAdvancedFilters'     => 'Advanced filters',
	'BbDateFrom'            => 'From',
	'BbDateTo'              => 'To',
	'BbJa3'                 => 'JA3 hash',
	'BbSlowOnly'            => 'Slow requests only (>1s)',

	// === Resolved workflow ===
	'BbResolvedActive'      => 'Active only',
	'BbResolvedOnly'        => 'Resolved only',
	'BbResolvedAll'         => 'Active + resolved',
	'BbResolved'            => 'resolved',
	'BbActionResolve'       => 'resolve',
	'BbActionUnresolve'     => 'unresolve',
	'BbRowResolved'         => 'Log entry marked resolved',
	'BbRowUnresolved'       => 'Log entry marked unresolved',

	// === Bulk actions ===
	'BbBulkDeleteSelected'      => 'Delete selected',
	'BbBulkWhitelistSelected'   => 'Whitelist IPs',
	'BbBulkResolveSelected'     => 'Mark resolved',
	'BbBulkUnresolveSelected'   => 'Mark unresolved',
	'BbBulkHint'                => 'Tick rows first, then click an action.',
	'BbNoItemsSelected'         => 'No items selected',
	'BbBulkDeleted'             => 'Deleted %1 log entries',
	'BbBulkWhitelisted'         => 'Added %1 IPs to whitelist',
	'BbBulkResolved'            => 'Marked %1 entries as resolved',
	'BbBulkUnresolved'          => 'Marked %1 entries as unresolved',
	'BbMarkAll'                 => 'Mark all rows on this page',
	'BbMarkNone'                => 'Unmark all rows',

	'BbBulkFailed'              => 'Could not update the selected rows. Check the database or try again.',
	'BbBulkWhitelistedNone'     => 'No new IPs were added — all selected IPs were already on the whitelist.',

	// === Verified badge ===
	'BbVerified'             => 'verified',
	'BbUnverified'           => 'unverified',

	// === ResultCode enum mapping (BbStatus_<code>) ===
	'BbStatus_allowed'                    => 'Request allowed',
	'BbStatus_blocked.bot'                => 'Known bot blocked',
	'BbStatus_blocked.ai_crawler'         => 'AI crawler blocked',
	'BbStatus_blocked.seo_crawler'        => 'SEO crawler blocked',
	'BbStatus_blocked.malicious_ua'       => 'Malicious User-Agent',
	'BbStatus_blocked.attack_pattern'     => 'Attack payload detected',
	'BbStatus_blocked.dnsbl'              => 'DNSBL match',
	'BbStatus_blocked.httpbl'             => 'http:BL match',
	'BbStatus_blocked.behavioral'         => 'Behavioral anomaly',
	'BbStatus_blocked.fingerprint'        => 'Bad fingerprint',
	'BbStatus_blocked.rate_limit'         => 'Rate limit exceeded',
	'BbStatus_blocked.custom_rule'        => 'Custom rule match',
	'BbStatus_blocked.geoip'              => 'GeoIP block',
	'BbStatus_blocked.residential_proxy'  => 'Residential proxy blocked',
	'BbStatus_challenge.required'         => 'Challenge required',
	'BbStatus_challenge.failed'           => 'Challenge failed',
	'BbStatus_error.internal'             => 'Internal error',
	'BbStatus_error.configuration'        => 'Configuration error',

	// === Time-window tabs ===
	'BbWindow24h' => 'Last 24 hours',
	'BbWindow7d'  => 'Last 7 days',
	'BbWindow30d' => 'Last 30 days',
	'BbWindowAll' => 'All time',

	// === Preset dropdown ===
	'BbPresetMinimal'        => 'Minimal (default)',
	'BbPresetFull'           => 'Full',
	'BbPresetVerifiedOnly'   => 'Verified-only',
	'BbPresetNoAi'           => 'No-AI',
	'BbPresetNoSeo'          => 'No-SEO',
	'BbPresetEuOnly'         => 'EU-only',
	'BbPresetHumanOnly'      => 'Human-only',
	'BbPresetCustom'         => 'Custom',

	// === Strictness dropdown ===
	'BbStrictnessMonitorOnly' => 'Monitor-only',
	'BbStrictnessNormal'      => 'Normal',
	'BbStrictnessStrict'      => 'Strict',

	// === Challenge provider dropdown ===
	'BbChallengeProviderBuiltin'   => 'Builtin (PoW)',
	'BbChallengeProviderHcaptcha'  => 'hCaptcha',
	'BbChallengeProviderRecaptcha' => 'reCAPTCHA v3',
	'BbChallengeProviderTurnstile' => 'Cloudflare Turnstile',

	// === Head Request Detection (newly translated form labels) ===
	'BbEnableHeadRequest'        => 'Enable head request detection',
	'BbHeadRequireReferer'       => 'Require Referer on HEAD',
	'BbHeadFloodThreshold'       => 'Flood threshold (per session)',
	'BbHeadProbeThreshold'       => 'Probe threshold (per IP / 5min)',

	// === Asset Scraping (newly translated form labels) ===
	'BbEnableAssetScraping'        => 'Enable asset scraping detection',
	'BbAssetNoRefererThreshold'    => 'No-referer threshold (per IP / hour)',
	'BbAssetOnlySessionThreshold'  => 'Asset-only session threshold',
	'BbAssetPatternThreshold'      => 'Sequential pattern threshold (per IP / 5min)',

	// === Dynamic IP Ranges ===
	'BbEnableDynamicIpRanges' => 'Enable dynamic IP ranges',

	// === On-demand IP Refresh ===
	'BbEnableOnDemandRefresh'    => 'Enable on-demand refresh',
	'BbOnDemandRefreshInfo'      => 'Refresh IP range cache during requests. Use when you have no cron access.',
	'BbOnDemandBotIdsPlaceholder' => 'googlebot, gptbot, claude…',

	// === Fingerprint field labels ===
	'BbFpBadJa3'          => 'Bad JA3',
	'BbFpBadH2'           => 'Bad H2',
	'BbFpBotHeaderOrders' => 'Bot Header Orders',
	'BbFpExpectedJa3'     => 'Expected JA3',

	// === Bot category list titles + hint ===
	'BbListBlocked'   => 'Blocked',
	'BbListChallenge' => 'Challenge (CAPTCHA)',
	'BbListLogOnly'   => 'Log only (no enforcement)',
	'BbListAllowed'   => 'Explicitly allowed',
	'BbListHint'      => 'Categories in this list get the action regardless of category default.',

	// === Bot category dropdown labels (manage filter) ===
	'BbCatSearchEngine'    => 'Search Engine',
	'BbCatAiCrawler'       => 'AI Crawler',
	'BbCatSocialCrawler'   => 'Social Crawler',
	'BbCatSeoCrawler'      => 'SEO Crawler',
	'BbCatArchiveCrawler'  => 'Archive Crawler',
	'BbCatMonitoring'      => 'Monitoring',
	'BbCatFeedReader'      => 'Feed Reader',
	'BbCatShoppingCrawler' => 'Shopping Crawler',
	'BbCatCloudInfra'      => 'Cloud Infrastructure',
	'BbCatSecurityScanner' => 'Security Scanner',
	'BbCatResidentialProxy'=> 'Residential Proxy',
	'BbCatMalicious'       => 'Malicious',
	'BbCatUnknown'         => 'Unknown',

	// === Placeholders ===
	'BbJa3Placeholder' => '32-char hash',

	// === Summary severity group labels ===
	'BbSevAttackPatterns' => 'Attack patterns',
	'BbSevChallenges'     => 'Challenges issued',
	'BbSevPermitted'      => 'Permitted',
	'BbSevErrors'         => 'Errors',

	// === Summary table column (was used but missing from set) ===
	'BbCategories' => 'Categories',

	'BbResultBreakdown'    => 'Result breakdown',
	'BbBreakdownBlocked'   => 'Blocked',
	'BbBreakdownMonitored' => 'Monitored',
	'BbBreakdownAllowed'   => 'Allowed',
	'BbViewAllInLog'       => 'View all in log',
	'BbAllowedHintVerbose' => 'Allowed traffic is only logged when verbose logging is enabled. Toggle logging_mode=verbose in Settings to see what passes through.',

];
