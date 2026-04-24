<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Osnovne funkcije',
		'preferences'	=> 'Postavke',
		'content'		=> 'Sadržaj',
		'users'			=> 'Korisnici',
		'maintenance'	=> 'Održavanje',
		'messages'		=> 'Poruke',
		'extension'		=> 'Proširenje',
		'database'		=> 'Baza podataka',
	],

	// Admin panel
	'AdminPanel'				=> 'Upravljačka ploča administracije',
	'RecoveryMode'				=> 'Način oporavka',
	'Authorization'				=> 'Autorizacija',
	'AuthorizationTip'			=> 'Unesite administratorsku lozinku (provjerite jesu li kolačići dopušteni u vašem pregledniku).',
	'NoRecoveryPassword'		=> 'Administratorska lozinka nije navedena!',
	'NoRecoveryPasswordTip'		=> 'Napomena: Nepostojanje administratorske lozinke predstavlja sigurnosni rizik! Unesite hash lozinke u konfiguracijsku datoteku i ponovno pokrenite program.',

	'ErrorLoadingModule'		=> 'Pogreška pri učitavanju administratorskog modula %1: ne postoji.',

	'ApHomePage'				=> 'Početna stranica',
	'ApHomePageTip'				=> 'Otvori početnu stranicu, ne izlazi iz sistemske administracije',
	'ApLogOut'					=> 'Odjava',
	'ApLogOutTip'				=> 'Izađi iz sistemske administracije',

	'TimeLeft'					=> 'Preostalo vrijeme:  %1 minuta',
	'ApVersion'					=> 'verzija',

	'SiteOpen'					=> 'Otvori',
	'SiteOpened'				=> 'stranica otvorena',
	'SiteOpenedTip'				=> 'Stranica je otvorena',
	'SiteClose'					=> 'Zatvori',
	'SiteClosed'				=> 'stranica zatvorena',
	'SiteClosedTip'				=> 'Stranica je zatvorena',

	'System'					=> 'Sustav',

	// Generic
	'Cancel'					=> 'Otkaži',
	'Add'						=> 'Dodaj',
	'Edit'						=> 'Uredi',
	'Remove'					=> 'Ukloni',
	'Enabled'					=> 'Omogućeno',
	'Disabled'					=> 'Onemogućeno',
	'Mandatory'					=> 'Obvezno',
	'Admin'						=> 'Admin',
	'Min'						=> 'Min',
	'Max'						=> 'Max',

	'MiscellaneousSection'		=> 'Razno',
	'MainSection'				=> 'Opće opcije',

	'DirNotWritable'			=> 'Direktorij %1 nije upisiv.',
	'FileNotWritable'			=> 'Datoteka %1 nije upisiva.',

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
		'name'		=> 'Osnovno',
		'title'		=> 'Osnovne postavke',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Izgled',
		'title'		=> 'Postavke izgleda',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-pošta',
		'title'		=> 'Postavke e-pošte',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Sindikacija',
		'title'		=> 'Postavke sindikacije',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtrar',
		'title'		=> 'Postavke filtra',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatiranje',
		'title'		=> 'Opcije formatiranja',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Obavijesti',
		'title'		=> 'Postavke obavijesti',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Stranice',
		'title'		=> 'Stranice i parametri web-mjesta',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Dozvole',
		'title'		=> 'Postavke dozvola',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Sigurnost',
		'title'		=> 'Postavke sigurnosnih podsustava',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Sustav',
		'title'		=> 'Opcije sustava',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Prijenos',
		'title'		=> 'Postavke privitaka',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Izbrisano',
		'title'		=> 'Nedavno izbrisani sadržaj',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Navigacija',
		'title'		=> 'Dodavanje, uređivanje ili uklanjanje stavki izbornika',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Sigurnosna kopija',
		'title'		=> 'Izrada sigurnosne kopije podataka',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Popravi',
		'title'		=> 'Popravi i optimiziraj bazu podataka',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Vrati',
		'title'		=> 'Vraćanje podataka iz sigurnosne kopije',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Glavni izbornik',
		'title'		=> 'WackoWiki administracija',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Nesukladnosti',
		'title'		=> 'Ispravljanje nesukladnosti podataka',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Sinkronizacija podataka',
		'title'		=> 'Sinkroniziranje podataka',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Masovna e-pošta',
		'title'		=> 'Masovna e-pošta',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Sistemske poruke',
		'title'		=> 'Sistemske poruke',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Informacije o sustavu',
		'title'		=> 'Informacije o sustavu',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Dnevnik sustava',
		'title'		=> 'Dnevnik događaja sustava',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistika',
		'title'		=> 'Prikaz statistike',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Loše ponašanje',
		'title'		=> 'Loše ponašanje',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Odobri',
		'title'		=> 'Odobravanje registracije korisnika',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Grupe',
		'title'		=> 'Upravljanje grupama',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Korisnici',
		'title'		=> 'Upravljanje korisnicima',
	],

	// Main module
	'MainNote'					=> 'Napomena: Preporučuje se privremeno blokiranje pristupa web-mjestu radi administrativnog održavanja.',

	'PurgeSessions'				=> 'Očisti',
	'PurgeSessionsTip'			=> 'Očisti sve sesije',
	'PurgeSessionsConfirm'		=> 'Jeste li sigurni da želite očistiti sve sesije? Ovo će odjaviti sve korisnike.',
	'PurgeSessionsExplain'		=> 'Očisti sve sesije. Ovo će odjaviti sve korisnike skraćivanjem tablice auth_token.',
	'PurgeSessionsDone'			=> 'Sesije su uspješno očišćene.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Osnovne postavke ažurirane',
	'LogBasicSettingsUpdated'	=> 'Ažurirane osnovne postavke',

	'SiteName'					=> 'Naziv stranice:',
	'SiteNameInfo'				=> 'Naslov ove stranice. Pojavljuje se u naslovu preglednika, zaglavlju teme, obavijestima e-poštom itd.',
	'SiteDesc'					=> 'Opis stranice:',
	'SiteDescInfo'				=> 'Dodatak naslovu stranice koji se pojavljuje u zaglavlju stranica. Ukratko objašnjava čemu služi stranica.',
	'AdminName'					=> 'Administrator stranice:',
	'AdminNameInfo'				=> 'Korisničko ime osobe odgovorne za opću podršku stranici. Ovo ime se ne koristi za određivanje pristupnih prava, ali je poželjno da odgovara imenu glavnog administratora stranice.',

	'LanguageSection'			=> 'Jezik',
	'DefaultLanguage'			=> 'Zadani jezik:',
	'DefaultLanguageInfo'		=> 'Određuje jezik poruka prikazanih neregistriranim posjetiteljima, kao i lokalne postavke.',
	'MultiLanguage'				=> 'Podrška za više jezika:',
	'MultiLanguageInfo'			=> 'Omogući mogućnost odabira jezika za pojedinačne stranice.',
	'AllowedLanguages'			=> 'Dopušteni jezici:',
	'AllowedLanguagesInfo'		=> 'Preporuča se odabrati samo skup jezika koje želite koristiti, inače će svi jezici biti odabrani.',

	'CommentSection'			=> 'Komentari',
	'AllowComments'				=> 'Dozvoli komentare:',
	'AllowCommentsInfo'			=> 'Omogući komentare za goste, registrirane korisnike ili ih onemogući na cijeloj stranici.',
	'SortingComments'			=> 'Sortiranje komentara:',
	'SortingCommentsInfo'		=> 'Mijenja redoslijed prikaza komentara na stranici, bilo s najnovijim ILI najstarijim komentarom na vrhu.',
	'CommentsOffset'			=> 'Stranica s komentarima:',
	'CommentsOffsetInfo'		=> 'Stranica s komentarima za prikaz po zadanom',

	'ToolbarSection'			=> 'Alatna traka',
	'CommentsPanel'				=> 'Panel komentara:',
	'CommentsPanelInfo'			=> 'Zadani prikaz komentara na dnu stranice.',
	'FilePanel'					=> 'Panel datoteka:',
	'FilePanelInfo'				=> 'Zadani prikaz privitaka na dnu stranice.',
	'TagsPanel'					=> 'Panel oznaka:',
	'TagsPanelInfo'				=> 'Zadani prikaz panela oznaka na dnu stranice.',

	'NavigationSection'			=> 'Navigacija',
	'ShowPermalink'				=> 'Prikaži permalink:',
	'ShowPermalinkInfo'			=> 'Zadani prikaz permalinka za trenutačnu verziju stranice.',
	'TocPanel'					=> 'Panel sadržaja:',
	'TocPanelInfo'				=> 'Zadani prikaz panela sadržaja stranice (možda zahtijeva podršku u predlošcima).',
	'SectionsPanel'				=> 'Panel sekcija:',
	'SectionsPanelInfo'			=> 'Po zadanim postavkama prikazuje panel susjednih stranica (zahtijeva podršku u predlošcima).',
	'DisplayingSections'		=> 'Prikaz sekcija:',
	'DisplayingSectionsInfo'	=> 'Kad su prethodne opcije uključene, hoće li se prikazati samo podstranice (<em>niže</em>), samo susjedne (<em>gornje</em>), oba ili drugo (<em>stablo</em>).',
	'MenuItems'					=> 'Stavke izbornika:',
	'MenuItemsInfo'				=> 'Zadani broj prikazanih stavki izbornika (možda zahtijeva podršku u predlošcima).',

	'HandlerSection'			=> 'Rukovatelji',
	'HideRevisions'				=> 'Sakrij revizije:',
	'HideRevisionsInfo'			=> 'Zadani prikaz revizija stranice.',
	'AttachmentHandler'			=> 'Omogući rukovatelj privicima:',
	'AttachmentHandlerInfo'		=> 'Dopušta prikaz rukovatelja privicima.',
	'SourceHandler'				=> 'Omogući rukovatelj izvornim kodom:',
	'SourceHandlerInfo'			=> 'Dopušta prikaz rukovatelja izvornim kodom.',
	'ExportHandler'				=> 'Omogući XML izvoz:',
	'ExportHandlerInfo'			=> 'Dopušta prikaz rukovatelja za XML izvoz.',

	'DiffModeSection'			=> 'Načini usporedbe',
	'DefaultDiffModeSetting'	=> 'Zadani način usporedbe:',
	'DefaultDiffModeSettingInfo'=> 'Unaprijed odabrani način usporedbe.',
	'AllowedDiffMode'			=> 'Dopušteni načini usporedbe:',
	'AllowedDiffModeInfo'		=> 'Preporuča se odabrati samo skup načina usporedbe koje želite koristiti, inače će svi biti odabrani.',
	'NotifyDiffMode'			=> 'Način usporedbe za obavijesti:',
	'NotifyDiffModeInfo'		=> 'Način usporedbe koji se koristi u obavijestima u tijelu e-pošte.',

	'EditingSection'			=> 'Uređivanje',
	'EditSummary'				=> 'Sažetak izmjena:',
	'EditSummaryInfo'			=> 'Prikazuje sažetak promjena u načinu uređivanja.',
	'MinorEdit'					=> 'Manja promjena:',
	'MinorEditInfo'				=> 'Omogućuje opciju manje promjene u načinu uređivanja.',
	'SectionEdit'				=> 'Uređivanje odjeljka:',
	'SectionEditInfo'			=> 'Omogućuje uređivanje samo dijela stranice.',
	'ReviewSettings'			=> 'Pregled:',
	'ReviewSettingsInfo'		=> 'Omogućuje opciju pregleda u načinu uređivanja.',
	'PublishAnonymously'		=> 'Dozvoli anonimno objavljivanje:',
	'PublishAnonymouslyInfo'	=> 'Dozvoli korisnicima da objavljuju anonimno (sakriju ime).',

	'DefaultRenameRedirect'		=> 'Pri preimenovanju, stvori preusmjerenje:',
	'DefaultRenameRedirectInfo'	=> 'Po zadanim postavkama, ponudi postavljanje preusmjeravanja na staru adresu preimenovane stranice.',
	'StoreDeletedPages'			=> 'Zadrži izbrisane stranice:',
	'StoreDeletedPagesInfo'		=> 'Kad izbrišete stranicu, komentar ili datoteku, zadrži ih u posebnom odjeljku gdje će biti dostupni za pregled i oporavak određeno vrijeme (kao što je opisano dolje).',
	'KeepDeletedTime'			=> 'Vrijeme čuvanja izbrisanih stranica:',
	'KeepDeletedTimeInfo'		=> 'Razdoblje u danima. Smisleno je samo uz prethodnu opciju. Upotrijebite nulu da osigurate da entiteti nikad ne budu izbrisani (u tom slučaju administrator može ručno isprazniti "koš").',
	'PagesPurgeTime'			=> 'Vrijeme čuvanja revizija stranica:',
	'PagesPurgeTimeInfo'		=> 'Automatski briše starije verzije nakon zadanog broja dana. Ako unesete nulu, starije verzije neće biti uklonjene.',
	'EnableReferrers'			=> 'Omogući referrere:',
	'EnableReferrersInfo'		=> 'Dopušta stvaranje i prikaz vanjskih referrera.',
	'ReferrersPurgeTime'		=> 'Vrijeme čuvanja referrera:',
	'ReferrersPurgeTimeInfo'	=> 'Čuvaj povijest referentnih vanjskih stranica najviše zadani broj dana. Upotrijebite nulu da referreri nikad ne budu izbrisani (ali za snažno posjećenu stranicu to može dovesti do preopterećenja baze podataka).',
	'EnableCounters'			=> 'Brojači posjeta:',
	'EnableCountersInfo'		=> 'Omogućuje brojače posjeta po stranici i prikaz jednostavne statistike. Pogledi vlasnika stranice se ne broje.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Kontrolirajte zadane postavke web sindikacije za vaše web-mjesto.',
	'SyndicationSettingsUpdated'	=> 'Postavke sindikacije ažurirane.',

	'FeedsSection'				=> 'Feedovi',
	'EnableFeeds'				=> 'Omogući feedove:',
	'EnableFeedsInfo'			=> 'Uključi ili isključi RSS feedove za cijeli wiki.',
	'XmlChangeLink'				=> 'Način poveznice u feedu promjena:',
	'XmlChangeLinkInfo'			=> 'Definira kamo stavke u XML Changes feedu vode.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'prikaz razlike',
		'2'		=> 'revidirana stranica',
		'3'		=> 'popis revizija',
		'4'		=> 'trenutna stranica',
	],

	'XmlSitemap'				=> 'XML sitemap:',
	'XmlSitemapInfo'			=> 'Stvara XML datoteku nazvanu %1 unutar xml mape. Putanju do sitemap-a možete dodati u robots.txt datoteku u korijenu ovako:',
	'XmlSitemapGz'				=> 'Komprimiranje XML sitemap-a:',
	'XmlSitemapGzInfo'			=> 'Ako želite, možete komprimirati tekstualnu datoteku sitemap-a koristeći gzip kako biste smanjili upotrebu propusnosti.',
	'XmlSitemapTime'			=> 'Vrijeme generiranja XML sitemap-a:',
	'XmlSitemapTimeInfo'		=> 'Generira sitemap samo jednom u zadanom broju dana. Postavite na nulu da generira pri svakoj promjeni stranice.',

	'SearchSection'				=> 'Pretraživanje',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Stvara OpenSearch opisnu datoteku u XML mapi i omogućuje automatsko otkrivanje tražilice u HTML zaglavlju.',
	'SearchEngineVisibility'	=> 'Blokiraj tražilice (vidljivost tražilice):',
	'SearchEngineVisibilityInfo'=> 'Blokiraj tražilice, ali dopusti normalnim posjetiteljima. Preklapa postavke stranice. <br>Odgovornost tražilica je hoće li poštovati ovaj zahtjev.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Kontrolirajte zadane postavke prikaza za vaše web-mjesto.',
	'AppearanceSettingsUpdated'	=> 'Postavke izgleda ažurirane.',

	'LogoOff'					=> 'Isključeno',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo i naslov',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Logo stranice:',
	'SiteLogoInfo'				=> 'Vaš logo obično se pojavljuje u gornjem lijevom kutu aplikacije. Maks. veličina je 2 MiB. Optimalne dimenzije su 255 px širine i 55 px visine.',
	'LogoDimensions'			=> 'Dimenzije loga:',
	'LogoDimensionsInfo'		=> 'Širina i visina prikazanog loga.',
	'LogoDisplayMode'			=> 'Način prikaza loga:',
	'LogoDisplayModeInfo'		=> 'Definira izgled loga. Zadano je isključeno.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Favicon stranice:',
	'SiteFaviconInfo'			=> 'Ikona prečaca, odnosno favicon, prikazuje se u adresnoj traci, karticama i oznakama većine preglednika. Ovo će zamijeniti favicon vaše teme.',
	'SiteFaviconTooBig'			=> 'Favicon je veći od 64 × 64 px.',
	'ThemeColor'				=> 'Boja teme za adresnu traku:',
	'ThemeColorInfo'			=> 'Preglednik će postaviti boju adresne trake svake stranice prema navedenoj CSS boji.',

	'LayoutSection'				=> 'Raspored',
	'Theme'						=> 'Tema:',
	'ThemeInfo'					=> 'Dizajn predloška koji stranicu koristi po zadanim postavkama.',
	'ResetUserTheme'			=> 'Poništi sve korisničke teme:',
	'ResetUserThemeInfo'		=> 'Poništava sve korisničke teme. Upozorenje: Ova radnja će vratiti sve korisnički odabrane teme na globalnu zadanu temu.',
	'SetBackUserTheme'			=> 'Vrati sve korisničke teme na %1 temu.',
	'ThemesAllowed'				=> 'Dopuštene teme:',
	'ThemesAllowedInfo'			=> 'Odaberite dopuštene teme koje korisnik može izabrati; inače su sve dostupne teme dopuštene.',
	'ThemesPerPage'				=> 'Tema po stranici:',
	'ThemesPerPageInfo'			=> 'Dozvoli temu po stranici, koju vlasnik stranice može odabrati preko svojstava stranice.',

	// System settings
	'SystemSettingsInfo'		=> 'Skup parametara odgovoran za fino podešavanje stranice. Ne mijenjajte ih ako niste sigurni u učinke.',
	'SystemSettingsUpdated'		=> 'Postavke sustava ažurirane',

	'DebugModeSection'			=> 'Način debugiranja',
	'DebugMode'					=> 'Način debugiranja:',
	'DebugModeInfo'				=> 'Izdvajanje i ispis telemetrijskih podataka o vremenu izvođenja aplikacije. Pažnja: Potpuni način detalja nameće veće zahtjeve za dodijeljenu memoriju, osobito za operacije zahtjevne prema resursima poput sigurnosne kopije i vraćanja baze podataka.',
	'DebugModes'	=> [
		'0'		=> 'debug isključen',
		'1'		=> 'samo ukupno vrijeme izvođenja',
		'2'		=> 'cjelovito vrijeme',
		'3'		=> 'puni detalji (DBMS, cache, itd.)',
	],
	'DebugSqlThreshold'			=> 'Prag performansi RDBMS:',
	'DebugSqlThresholdInfo'		=> 'U detaljnom načinu debugiranja prijavi samo upite koji traju dulje od navedenog broja sekundi.',
	'DebugAdminOnly'			=> 'Dijagnostika za administratore:',
	'DebugAdminOnlyInfo'		=> 'Prikaži debug podatke programa (i DBMS-a) samo administratoru.',

	'CachingSection'			=> 'Opcije predmemorije',
	'Cache'						=> 'Predmemoriraj renderirane stranice:',
	'CacheInfo'					=> 'Spremi renderirane stranice u lokalnu cache za ubrzanje budućih učitavanja. Vrijedi samo za neregistrirane posjetitelje.',
	'CacheTtl'					=> 'Vrijeme života predmemoriranih stranica:',
	'CacheTtlInfo'				=> 'Predmemoriraj stranice najviše zadani broj sekundi.',
	'CacheSql'					=> 'Predmemoriraj DBMS upite:',
	'CacheSqlInfo'				=> 'Održava lokalnu predmemoriju rezultata određenih SQL upita povezanih s resursima.',
	'CacheSqlTtl'				=> 'Vrijeme života predmemoriranih SQL upita:',
	'CacheSqlTtlInfo'			=> 'Predmemoriraj rezultate SQL upita najviše zadani broj sekundi. Vrijednosti veće od 1200 nisu poželjne.',

	'LogSection'				=> 'Postavke dnevnika',
	'LogLevelUsage'				=> 'Korištenje zapisivanja događaja:',
	'LogLevelUsageInfo'			=> 'Minimalni prioritet događaja koji se bilježe u dnevniku.',
	'LogThresholds'	=> [
		'0'		=> 'ne vodi dnevnik',
		'1'		=> 'samo kritični nivo',
		'2'		=> 'od najviše razine',
		'3'		=> 'od visoke',
		'4'		=> 'srednje',
		'5'		=> 'od niske',
		'6'		=> 'minimalna razina',
		'7'		=> 'zabilježi sve',
	],
	'LogDefaultShow'			=> 'Način prikaza dnevnika:',
	'LogDefaultShowInfo'		=> 'Minimalni prioritet događaja koji se po zadanim postavkama prikazuju u dnevniku.',
	'LogModes'	=> [
		'1'		=> 'samo kritični nivo',
		'2'		=> 'od najviše razine',
		'3'		=> 'od visoke razine',
		'4'		=> 'srednje',
		'5'		=> 'od niske',
		'6'		=> 'od minimalne razine',
		'7'		=> 'prikaži sve',
	],
	'LogPurgeTime'				=> 'Vrijeme čuvanja dnevnika:',
	'LogPurgeTimeInfo'			=> 'Ukloni dnevnik događaja nakon zadanog broja dana.',

	'PrivacySection'			=> 'Privatnost',
	'AnonymizeIp'				=> 'Anonimiziraj IP adrese korisnika:',
	'AnonymizeIpInfo'			=> 'Anonimizira IP adrese gdje je primjenjivo (npr. stranica, revizija ili referreri).',

	'ReverseProxySection'		=> 'Reverse Proxy',
	'ReverseProxy'				=> 'Koristi reverse proxy:',
	'ReverseProxyInfo'			=> 'Omogućite ovu postavku da biste ispravno odredili IP adresu udaljenog klijenta pregledom informacija pohranjenih u X-Forwarded-For zaglavljima. X-Forwarded-For zaglavlja su standardni mehanizam za identifikaciju klijenata koji se povezuju preko reverse proxy servera, poput Squid ili Pound. Reverse proxy serveri često se koriste za poboljšanje performansi jako posjećenih stranica te mogu pružiti predmemoriranje, sigurnost ili enkripciju. Ako se WackoWiki instalacija nalazi iza reverse proxyja, ovu postavku treba omogućiti kako bi se ispravno bilježile IP adrese u upravljanju sesijama, zapisivanju, statistici i pristupnim sustavima; ako niste sigurni, nemate reverse proxy ili WackoWiki radi u zajedničkom hostingu, ostavite ovu opciju onemogućenom.',
	'ReverseProxyHeader'		=> 'Zaglavlje reverse proxyja:',
	'ReverseProxyHeaderInfo'	=> 'Postavite ovu vrijednost ako vaš proxy server šalje IP klijenta u zaglavlju drugačijem od X-Forwarded-For. Zaglavlje "X-Forwarded-For" je lista IP adresa odvojena zarezima; koristiti će se samo posljednja (najlijevija).',
	'ReverseProxyAddresses'		=> 'reverse_proxy prihvaća niz IP adresa:',
	'ReverseProxyAddressesInfo'	=> 'Svaki element ovog niza je IP adresa nekog od vaših reverse proxyja. Ako koristite ovaj niz, WackoWiki će vjerovati informacijama iz X-Forwarded-For zaglavlja samo ako je udaljena IP adresa jedna od ovih, tj. zahtjev dolazi s jednog od vaših reverse proxyja. Inače, klijent bi mogao izravno pristupiti vašem web serveru lažirajući X-Forwarded-For zaglavlja.',

	'SessionSection'				=> 'Rukovanje sesijama',
	'SessionStorage'				=> 'Spremanje sesija:',
	'SessionStorageInfo'			=> 'Ova opcija definira gdje se pohranjuju podaci sesije. Po zadanim postavkama odabrano je spremanje u datoteku ili bazu podataka.',
	'SessionModes'	=> [
		'1'		=> 'Datoteka',
		'2'		=> 'Baza podataka',
	],
	'SessionNotice'					=> 'Obavijest o prekidu sesije:',
	'SessionNoticeInfo'				=> 'Naznačuje uzrok prekida sesije.',
	'LoginNotice'					=> 'Obavijest prilikom prijave:',
	'LoginNoticeInfo'				=> 'Prikazuje obavijest pri prijavi.',

	'RewriteMode'					=> 'Koristi <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Ako vaš web poslužitelj podržava ovu mogućnost, omogućite za "uljepšavanje" URL-ova stranica.<br>
										<span class="cite">Vrijednost može biti prebrisana od strane klase Settings u runtime-u, bez obzira je li isključena, ako je HTTP_MOD_REWRITE uključen.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parametri odgovorni za kontrolu pristupa i dozvole.',
	'PermissionsSettingsUpdated'	=> 'Postavke dozvola ažurirane',

	'PermissionsSection'		=> 'Prava i ovlasti',
	'ReadRights'				=> 'Prava čitanja po zadano:',
	'ReadRightsInfo'			=> 'Zadano dodijeljeno stvorenim korijenskim stranicama, kao i stranicama za koje nije moguće definirati roditeljske ACL-ove.',
	'WriteRights'				=> 'Prava pisanja po zadano:',
	'WriteRightsInfo'			=> 'Zadano dodijeljeno stvorenim korijenskim stranicama, kao i stranicama za koje nije moguće definirati roditeljske ACL-ove.',
	'CommentRights'				=> 'Prava za komentiranje po zadano:',
	'CommentRightsInfo'			=> 'Zadano dodijeljeno stvorenim korijenskim stranicama, kao i stranicama za koje nije moguće definirati roditeljske ACL-ove.',
	'CreateRights'				=> 'Prava za stvaranje podstranice po zadano:',
	'CreateRightsInfo'			=> 'Zadano dodijeljeno stvorenim podstranicama.',
	'UploadRights'				=> 'Prava prijenosa po zadano:',
	'UploadRightsInfo'			=> 'Zadana prava za prijenos.',
	'RenameRights'				=> 'Globalno pravo preimenovanja:',
	'RenameRightsInfo'			=> 'Popis dozvola za slobodno preimenovanje (premještanje) stranica.',

	'LockAcl'					=> 'Zaključaj sve ACL-ove samo za čitanje:',
	'LockAclInfo'				=> '<span class="cite">Prepisuje ACL postavke za sve stranice u samo za čitanje.</span><br>Ovo može biti korisno ako je projekt dovršen, želite privremeno zatvoriti uređivanje iz sigurnosnih razloga ili kao hitna mjera zbog exploita ili ranjivosti.',
	'HideLocked'				=> 'Sakrij nedostupne stranice:',
	'HideLockedInfo'			=> 'Ako korisnik nema pravo čitanja stranice, sakrij je iz različitih popisa stranica (međutim link u tekstu će i dalje biti vidljiv).',
	'RemoveOnlyAdmins'			=> 'Samo administratori mogu brisati stranice:',
	'RemoveOnlyAdminsInfo'		=> 'Odbij sve osim administratora mogućnost brisanja stranica. Ovo se prvo ograničenje odnosi na vlasnike običnih stranica.',
	'OwnersRemoveComments'		=> 'Vlasnici stranica mogu brisati komentare:',
	'OwnersRemoveCommentsInfo'	=> 'Dopusti vlasnicima stranica moderiranje komentara na njihovim stranicama.',
	'OwnersEditCategories'		=> 'Vlasnici mogu uređivati kategorije stranica:',
	'OwnersEditCategoriesInfo'	=> 'Dopusti vlasnicima mijenjanje liste kategorija stranice (dodavanje, brisanje riječi) koje su dodijeljene stranici.',
	'TermHumanModeration'		=> 'Rok ljudske moderacije:',
	'TermHumanModerationInfo'	=> 'Moderatori mogu uređivati komentare samo ako su stvoreni ne više od ovog broja dana (ovo ograničenje ne vrijedi za zadnji komentar u temi).',

	'UserCanDeleteAccount'		=> 'Dozvoli korisnicima brisanje vlastitog računa',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parametri odgovorni za opću sigurnost platforme, sigurnosna ograničenja i dodatne sigurnosne podsustave.',
	'SecuritySettingsUpdated'	=> 'Postavke sigurnosti ažurirane',

	'AllowRegistration'			=> 'Registracija online:',
	'AllowRegistrationInfo'		=> 'Otvorena registracija korisnika. Onemogućavanje ove opcije spriječit će slobodnu registraciju, no administrator stranice i dalje može registrirati korisnike.',
	'ApproveNewUser'			=> 'Odobri nove korisnike:',
	'ApproveNewUserInfo'		=> 'Dopušta administratorima odobravanje korisnika nakon registracije. Samo odobreni korisnici smiju se prijaviti.',
	'PersistentCookies'			=> 'Postojani kolačići:',
	'PersistentCookiesInfo'		=> 'Dozvoli postojane kolačiće.',
	'DisableWikiName'			=> 'Onemogući WikiName:',
	'DisableWikiNameInfo'		=> 'Onemogućuje obveznu upotrebu WikiName za korisnike. Dopušta registraciju sa tradicionalnim nadimcima umjesto prisilnih CamelCase imena.',
	'UsernameLength'			=> 'Duljina korisničkog imena:',
	'UsernameLengthInfo'		=> 'Minimalan i maksimalan broj znakova u korisničkim imenima.',

	'EmailSection'				=> 'E-pošta',
	'AllowEmailReuse'			=> 'Dozvoli ponovnu uporabu e-adrese:',
	'AllowEmailReuseInfo'		=> 'Različiti korisnici mogu se registrirati s istom adresom e-pošte.',
	'EmailConfirmation'			=> 'Zahtijevaj potvrdu e-pošte:',
	'EmailConfirmationInfo'		=> 'Zahtijeva da korisnik potvrdi svoju e-adresu prije nego se može prijaviti.',
	'AllowedEmailDomains'		=> 'Dopušteni domene e-pošte:',
	'AllowedEmailDomainsInfo'	=> 'Domena(e) odvojene zarezom, npr. <code>example.com, local.lan</code> itd. Ako nije navedeno, sve domene su dopuštene.',
	'ForbiddenEmailDomains'		=> 'Zabranjene domene e-pošte:',
	'ForbiddenEmailDomainsInfo'	=> 'Zabranjene domene odvojene zarezom, npr. <code>example.com, local.lan</code> itd. Djelotvorno samo ako je lista dopuštenih domena prazna.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Omogući captcha:',
	'EnableCaptchaInfo'			=> 'Ako je omogućeno, captcha će se prikazati u navedenim slučajevima ili ako je dosegnut sigurnosni prag.',
	'CaptchaComment'			=> 'Novi komentar:',
	'CaptchaCommentInfo'		=> 'Kao zaštita od spama, neregistrirani korisnici moraju riješiti captcha prije objave komentara.',
	'CaptchaPage'				=> 'Nova stranica:',
	'CaptchaPageInfo'			=> 'Kao zaštita od spama, neregistrirani korisnici moraju riješiti captcha prije kreiranja nove stranice.',
	'CaptchaEdit'				=> 'Uređivanje stranice:',
	'CaptchaEditInfo'			=> 'Kao zaštita od spama, neregistrirani korisnici moraju riješiti captcha prije uređivanja stranica.',
	'CaptchaRegistration'		=> 'Registracija:',
	'CaptchaRegistrationInfo'	=> 'Kao zaštita od spama, neregistrirani korisnici moraju riješiti captcha prije registracije.',

	'TlsSection'				=> 'TLS postavke',
	'TlsConnection'				=> 'TLS veza:',
	'TlsConnectionInfo'			=> 'Koristi TLS-om osiguranu vezu. <span class="cite">Aktivirajte odgovarajući prethodno instalirani TLS certifikat na poslužitelju, inače ćete izgubiti pristup administratorskom panelu!</span><br>Određuje i je li postavljen Cookie Secure flag: <code>secure</code> zastavica specificira trebaju li se kolačići slati samo preko sigurnih veza.',
	'TlsImplicit'				=> 'Obvezni TLS:',
	'TlsImplicitInfo'			=> 'Prisilno preusmjeri klijenta s HTTP na HTTPS. Ako je opcija onemogućena, klijent može pregledavati stranicu kroz nezaštićeni HTTP kanal.',

	'HttpSecurityHeaders'		=> 'HTTP sigurnosna zaglavlja',
	'EnableSecurityHeaders'		=> 'Omogući sigurnosna zaglavlja:',
	'EnableSecurityHeadersinfo'	=> 'Postavi sigurnosna zaglavlja (zaštita od frame bustinga, clickjackinga/XSS/CSRF). <br>CSP može uzrokovati probleme u nekim situacijama (npr. tijekom razvoja), ili pri korištenju dodataka koji ovise o vanjskim resursima poput slika ili skripti. <br>Onemogućavanje Content Security Policy predstavlja sigurnosni rizik!',
	'Csp'						=> 'Policy sadržaja (CSP):',
	'CspInfo'					=> 'Konfiguracija CSP-a uključuje odlučivanje koje politike želite provoditi, a zatim njihovu postavku pomoću Content-Security-Policy zaglavlja.',
	'PolicyModes'	=> [
		'0'		=> 'onemogućeno',
		'1'		=> 'strogo',
		'2'		=> 'prilagođeno',
	],
	'PermissionsPolicy'			=> 'Permissions policy:',
	'PermissionsPolicyInfo'		=> 'HTTP Permissions-Policy zaglavlje pruža mehanizam za eksplicitno omogućavanje ili onemogućavanje raznih moćnih značajki preglednika.',
	'ReferrerPolicy'			=> 'Politika referrera:',
	'ReferrerPolicyInfo'		=> 'Referrer-Policy HTTP zaglavlje upravlja kojim podacima o referreru, poslanima u Referer zaglavlju, treba biti uključen u odgovore.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[isključeno]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> 'Čuvanje korisničkih lozinki',
	'PwdMinChars'				=> 'Minimalna duljina lozinke:',
	'PwdMinCharsInfo'			=> 'Dulje lozinke su općenito sigurnije od kraćih (npr. 12 do 16 znakova).<br>Preporučuje se korištenje passphrase umjesto kratkih lozinki.',
	'AdminPwdMinChars'			=> 'Minimalna duljina administratorske lozinke:',
	'AdminPwdMinCharsInfo'		=> 'Dulje lozinke su općenito sigurnije (npr. 15 do 20 znakova).<br>Preporučuje se korištenje passphrase.',
	'PwdCharComplexity'			=> 'Zahtijevana složenost lozinke:',
	'PwdCharClasses'	=> [
		'0'		=> 'neprovjerava se',
		'1'		=> 'bilo koja slova + brojevi',
		'2'		=> 'velika i mala slova + brojevi',
		'3'		=> 'velika i mala slova + brojevi + znakovi',
	],
	'PwdUnlikeLogin'			=> 'Dodatna komplikacija:',
	'PwdUnlikes'	=> [
		'0'		=> 'neprovjerava se',
		'1'		=> 'lozinka nije identična korisničkom imenu',
		'2'		=> 'lozinka ne sadrži korisničko ime',
	],

	'LoginSection'				=> 'Prijava',
	'MaxLoginAttempts'			=> 'Maksimalan broj pokušaja prijave po korisničkom imenu:',
	'MaxLoginAttemptsInfo'		=> 'Broj pokušaja prijave dopuštenih za jedan račun prije aktiviranja anti-spambot mjere. Unesite 0 da se antispambot mjera ne pokreće za različite korisničke račune.',
	'IpLoginLimitMax'			=> 'Maksimalan broj pokušaja prijave po IP adresi:',
	'IpLoginLimitMaxInfo'		=> 'Prag pokušaja prijave s jedne IP adrese prije nego se aktivira antispambot mjera. Unesite 0 da se antispambot mjera ne aktivira po IP adresi.',

	'FormsSection'				=> 'Formulari',
	'FormTokenTime'				=> 'Maksimalno vrijeme za slanje obrazaca:',
	'FormTokenTimeInfo'			=> 'Vrijeme koje korisnik ima za slanje obrasca (u sekundama).<br>Napomena da obrazac može postati nevažeći ako sesija istekne, neovisno o ovoj postavci.',

	'SessionLength'				=> 'Istek kolačića sesije:',
	'SessionLengthInfo'			=> 'Trajanje kolačića korisničke sesije po zadano (u danima).',
	'CommentDelay'				=> 'Anti-flood za komentare:',
	'CommentDelayInfo'			=> 'Minimalno vrijeme između objave novih korisničkih komentara (u sekundama).',
	'IntercomDelay'				=> 'Anti-flood za privatnu komunikaciju:',
	'IntercomDelayInfo'			=> 'Minimalno vrijeme između slanja privatnih poruka (u sekundama).',
	'RegistrationDelay'			=> 'Vrijeme za registraciju:',
	'RegistrationDelayInfo'		=> 'Minimalno trajanje popunjavanja obrasca za registraciju kako bi se razlikovali botovi od ljudi (u sekundama).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Skup parametara odgovoran za fino podešavanje formata. Ne mijenjajte ih ako niste sigurni u njihove učinke.',
	'FormatterSettingsUpdated'	=> 'Postavke formatiranja ažurirane',

	'TextHandlerSection'		=> 'Rukovatelj teksta:',
	'Typografica'				=> 'Tipografski ispravljač:',
	'TypograficaInfo'			=> 'Onemogućavanje ove opcije ubrzat će proces dodavanja komentara i spremanja stranica.',
	'Paragrafica'				=> 'Paragrafičke oznake:',
	'ParagraficaInfo'			=> 'Slično prethodnoj opciji, ali može isključiti automatski sadržaj (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Globalna podrška za HTML:',
	'AllowRawhtmlInfo'			=> 'Ova opcija može biti nesigurna za otvorene stranice.',
	'SafeHtml'					=> 'Filtriranje HTML-a:',
	'SafeHtmlInfo'				=> 'Sprječava spremanje opasnih HTML elemenata. Isključivanje filtra na otvorenoj stranici s podrškom za HTML je <span class="underline">izuzetno</span> nepoželjno!',

	'WackoFormatterSection'		=> 'Wiki tekst formatiranje (Wacko Formatter)',
	'X11colors'					=> 'Korištenje X11 boja:',
	'X11colorsInfo'				=> 'Proširuje dostupne boje za <code>??(color) background??</code> i <code>!!(color) text!!</code>. Onemogućavanje ubrzava dodavanje komentara i spremanje stranica.',
	'WikiLinks'					=> 'Onemogući wiki linkove:',
	'WikiLinksInfo'				=> 'Onemogućuje automatsko povezivanje <code>CamelCaseWords</code>: vaše CamelCase riječi više neće biti linkane na novu stranicu. Korisno pri radu u različitim prostorima imena. Zadano isključeno.',
	'BracketsLinks'				=> 'Onemogući linkove u zagradama:',
	'BracketsLinksInfo'			=> 'Onemogućuje sintaksu <code>[[link]]</code> i <code>((link))</code>.',
	'Formatters'				=> 'Onemogući formatere:',
	'FormattersInfo'			=> 'Onemogućuje sintaksu <code>%%code%%</code> koja se koristi za isticanje koda.',

	'DateFormatsSection'		=> 'Format datuma',
	'DateFormat'				=> 'Format datuma:',
	'DateFormatInfo'			=> '(dan, mjesec, godina)',
	'TimeFormat'				=> 'Format vremena:',
	'TimeFormatInfo'			=> '(sat, minuta)',
	'TimeFormatSeconds'			=> 'Format točnog vremena:',
	'TimeFormatSecondsInfo'		=> '(sati, minute, sekunde)',
	'NameDateMacro'				=> 'Format makra <code>::@::</code>:',
	'NameDateMacroInfo'			=> '(ime, vrijeme), npr. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Vremenska zona:',
	'TimezoneInfo'				=> 'Vremenska zona koja se koristi za prikaz vremena korisnicima koji nisu prijavljeni (gosti). Prijavljeni korisnici mogu promijeniti svoju zonu u postavkama računa.',
	'AmericanDate'					=> 'Američki format datuma:',
	'AmericanDateInfo'				=> 'Koristi američki format datuma kao zadani za engleski jezik.',

	'Canonical'					=> 'Koristi potpuno kanonske URL-ove:',
	'CanonicalInfo'				=> 'Sve poveznice se stvaraju kao apsolutni URL-ovi u obliku %1. Relativni URL-ovi u obliku %2 trebali bi biti preferirani.',
	'LinkTarget'				=> 'Gdje se otvaraju vanjske poveznice:',
	'LinkTargetInfo'			=> 'Otvori svaku vanjsku poveznicu u novom prozoru preglednika. Dodaje <code>target="_blank"</code> sintaksi poveznice.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Zahtijeva da preglednik ne šalje Referer zaglavlje ako korisnik slijedi hiperlink. Dodaje <code>rel="noreferrer"</code> sintaksi poveznice.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Obavještava tražilice da hiperlinkovi ne bi trebali utjecati na rangiranje ciljne stranice u indeksu tražilice. Dodaje <code>rel="nofollow"</code> sintaksi poveznice.',
	'UrlsUnderscores'			=> 'Oblikuj URL-ove s podvlakama:',
	'UrlsUnderscoresInfo'		=> 'Na primjer, %1 postaje %2 s ovom opcijom.',
	'ShowSpaces'				=> 'Prikaži razmake u WikiName-ovima:',
	'ShowSpacesInfo'			=> 'Prikazuje razmake u WikiName-ovima, npr. <code>MyName</code> prikazano kao <code>My Name</code> s ovom opcijom.',
	'NumerateLinks'				=> 'Numeriraj poveznice u prikazu za ispis:',
	'NumerateLinksInfo'			=> 'Numerira i navodi sve poveznice na dnu ispisnog prikaza s ovom opcijom.',
	'YouareHereText'			=> 'Onemogući i vizualiziraj samoreferentne poveznice:',
	'YouareHereTextInfo'		=> 'Vizualizira poveznice na istu stranicu koristeći <code>&lt;b&gt;####&lt;/b&gt;</code>. Sve poveznice na sebe gube format poveznice, ali su prikazane podebljanim tekstom.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Ovdje možete postaviti ili promijeniti temeljne stranice sustava koje se koriste u wikiju. Pobrinite se da ne zaboravite stvoriti ili promijeniti odgovarajuće stranice u wikiju u skladu s ovim postavkama.',
	'PagesSettingsUpdated'		=> 'Ažurirane postavke temeljnih stranica',

	'ListCount'					=> 'Broj stavki po popisu:',
	'ListCountInfo'				=> 'Broj stavki prikazanih na svakom popisu za goste, ili kao zadana vrijednost za nove korisnike.',

	'ForumSection'				=> 'Opcije foruma',
	'ForumCluster'				=> 'Klaster foruma:',
	'ForumClusterInfo'			=> 'Korijenski klaster za forume (akcija %1).',
	'ForumTopics'				=> 'Broj tema po stranici:',
	'ForumTopicsInfo'			=> 'Broj tema prikazanih na svakoj stranici popisa u odjeljcima foruma (akcija %1).',
	'CommentsCount'				=> 'Broj komentara po stranici:',
	'CommentsCountInfo'			=> 'Broj komentara prikazanih na popisu komentara svake stranice. Ovo vrijedi za sve komentare na stranici, ne samo one u forumu.',

	'NewsSection'				=> 'Sekcija vijesti',
	'NewsCluster'				=> 'Klaster za vijesti:',
	'NewsClusterInfo'			=> 'Korijenski klaster za sekciju vijesti (akcija %1).',
	'NewsStructure'				=> 'Struktura klastera vijesti:',
	'NewsStructureInfo'			=> 'Pohranjuje članke opcionalno u podklastere po godini/mjesecu ili tjednu (npr. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licenca',
	'DefaultLicense'			=> 'Zadana licenca:',
	'DefaultLicenseInfo'		=> 'Pod kojom licencom vaš sadržaj može biti objavljen.',
	'EnableLicense'				=> 'Omogući licencu:',
	'EnableLicenseInfo'			=> 'Omogući prikaz informacija o licenci.',
	'LicensePerPage'			=> 'Licenca po stranici:',
	'LicensePerPageInfo'		=> 'Dozvoli licencu po stranici koju vlasnik stranice može odabrati preko svojstava stranice.',

	'ServicePagesSection'		=> 'Servisne stranice',
	'RootPage'					=> 'Početna stranica:',
	'RootPageInfo'				=> 'Oznaka vaše glavne stranice, otvara se automatski kad korisnik posjeti web-mjesto.',

	'PrivacyPage'				=> 'Stranica privatnosti:',
	'PrivacyPageInfo'			=> 'Stranica s politikom privatnosti web-mjesta.',

	'TermsPage'					=> 'Pravila i uvjeti:',
	'TermsPageInfo'				=> 'Stranica s pravilima web-mjesta.',

	'SearchPage'				=> 'Pretraživanje:',
	'SearchPageInfo'			=> 'Stranica s obrascem za pretraživanje (akcija %1).',
	'RegistrationPage'			=> 'Registracija:',
	'RegistrationPageInfo'		=> 'Stranica za registraciju novih korisnika (akcija %1).',
	'LoginPage'					=> 'Prijava korisnika:',
	'LoginPageInfo'				=> 'Stranica za prijavu na web-mjestu (akcija %1).',
	'SettingsPage'				=> 'Korisničke postavke:',
	'SettingsPageInfo'			=> 'Stranica za prilagodbu korisničkog profila (akcija %1).',
	'PasswordPage'				=> 'Promjena lozinke:',
	'PasswordPageInfo'			=> 'Stranica s obrascem za promjenu/upit korisničke lozinke (akcija %1).',
	'UsersPage'					=> 'Popis korisnika:',
	'UsersPageInfo'				=> 'Stranica s popisom registriranih korisnika (akcija %1).',
	'CategoryPage'				=> 'Kategorija:',
	'CategoryPageInfo'			=> 'Stranica s popisom kategoriziranih stranica (akcija %1).',
	'GroupsPage'				=> 'Grupe:',
	'GroupsPageInfo'			=> 'Stranica s popisom radnih grupa (akcija %1).',
	'WhatsNewPage'				=> 'Novosti:',
	'WhatsNewPageInfo'			=> 'Stranica s popisom svih novih, izbrisanih ili izmijenjenih stranica, novih privitaka i komentara. (akcija %1).',
	'ChangesPage'				=> 'Nedavne promjene:',
	'ChangesPageInfo'			=> 'Stranica s popisom posljednjih izmijenjenih stranica (akcija %1).',
	'CommentsPage'				=> 'Nedavni komentari:',
	'CommentsPageInfo'			=> 'Stranica s popisom nedavnih komentara na stranicama (akcija %1).',
	'RemovalsPage'				=> 'Izbrisane stranice:',
	'RemovalsPageInfo'			=> 'Stranica s popisom nedavno izbrisanih stranica (akcija %1).',
	'WantedPage'				=> 'Tražene stranice:',
	'WantedPageInfo'			=> 'Stranica s popisom nedostajućih stranica koje su referencirane (akcija %1).',
	'OrphanedPage'				=> 'Siroče stranice:',
	'OrphanedPageInfo'			=> 'Stranica s popisom postojećih stranica koje nisu povezane linkovima s bilo kojom drugom stranicom (akcija %1).',
	'SandboxPage'				=> 'Prvačić:',
	'SandboxPageInfo'			=> 'Stranica na kojoj korisnici mogu vježbati wiki markup.',
	'HelpPage'					=> 'Pomoć:',
	'HelpPageInfo'				=> 'Dokumentacijski odjeljak za rad s alatima web-mjesta.',
	'IndexPage'					=> 'Indeks:',
	'IndexPageInfo'				=> 'Stranica s popisom svih stranica (akcija %1).',
	'RandomPage'				=> 'Slučajno:',
	'RandomPageInfo'			=> 'Učitaj slučajnu stranicu (akcija %1).',


	// Postavke obavijesti
	'NotificationSettingsInfo'	=> 'Parametri za obavijesti platforme.',
	'NotificationSettingsUpdated'	=> 'Ažurirane postavke obavijesti',

	'EmailNotification'			=> 'Obavijest e-poštom:',
	'EmailNotificationInfo'		=> 'Dozvoli obavijesti putem e-pošte. Postavite na Omogućeno za uključivanje obavijesti e-poštom, Onemogućeno za njihovo isključivanje. Imajte na umu da isključivanje obavijesti e-poštom ne utječe na poruke poslane tijekom procesa registracije korisnika.',
	'Autosubscribe'				=> 'Auto-prijava:',
	'AutosubscribeInfo'			=> 'Automatski obavještava vlasnika stranice o promjenama na stranici.',

	'NotificationSection'		=> 'Zadane korisničke postavke obavijesti',
	'NotifyPageEdit'			=> 'Obavijesti o uređivanju stranice:',
	'NotifyPageEditInfo'		=> 'Na čekanju - Pošalji e-poruku samo za prvu promjenu dok korisnik ponovno ne posjeti stranicu.',
	'NotifyMinorEdit'			=> 'Obavijesti o manjim izmjenama:',
	'NotifyMinorEditInfo'		=> 'Također šalje obavijesti za manje izmjene.',
	'NotifyNewComment'			=> 'Obavijesti o novom komentaru:',
	'NotifyNewCommentInfo'		=> 'Na čekanju - Pošalji e-poruku samo za prvi komentar dok korisnik ponovno ne posjeti stranicu.',

	'NotifyUserAccount'			=> 'Obavijesti o novom korisničkom računu:',
	'NotifyUserAccountInfo'		=> 'Administrator će biti obaviješten kad je novi korisnik kreiran putem obrasca za registraciju.',
	'NotifyUpload'				=> 'Obavijesti o prijenosu datoteke:',
	'NotifyUploadInfo'			=> 'Moderator će biti obaviješten kada je datoteka prenesena.',

	'PersonalMessagesSection'	=> 'Osobne poruke',
	'AllowIntercomDefault'		=> 'Dozvoli interkom:',
	'AllowIntercomDefaultInfo'	=> 'Omogućavanje ove opcije dopušta drugim korisnicima slanje osobnih poruka na primateljevu adresu e-pošte bez otkrivanja same adrese.',
	'AllowMassemailDefault'		=> 'Dozvoli masovne e-poruke:',
	'AllowMassemailDefaultInfo'	=> 'Pošaljite poruke samo onim korisnicima koji su dopuštali administratorima da im šalju obavijesti e-poštom.',

	// Postavke resinkronizacije
	'Synchronize'				=> 'Sinkroniziraj',
	'UserStatsSynched'			=> 'Korisnička statistika sinkronizirana.',
	'PageStatsSynched'			=> 'Statistika stranica sinkronizirana.',
	'FeedsUpdated'				=> 'RSS feedovi ažurirani.',
	'SiteMapCreated'			=> 'Nova verzija karte stranica uspješno kreirana.',
	'ParseNextBatch'			=> 'Parsaj sljedeću skupinu stranica:',
	'WikiLinksRestored'			=> 'Wiki-poveznice obnovljene.',

	'LogUserStatsSynched'		=> 'Sinkronizirana korisnička statistika',
	'LogPageStatsSynched'		=> 'Sinkronizirana statistika stranica',
	'LogFeedsUpdated'			=> 'Sinkronizirani RSS feedovi',
	'LogPageBodySynched'		=> 'Ponovno parsano tijelo stranice i poveznice',

	'UserStats'					=> 'Korisnička statistika',
	'UserStatsInfo'				=> 'Korisnička statistika (broj komentara, stranica u vlasništvu, revizija i datoteka) može se u nekim situacijama razlikovati od stvarnih podataka. <br>Ova operacija omogućuje ažuriranje statistike kako bi odgovarala stvarnim podacima u bazi podataka.',
	'PageStats'					=> 'Statistika stranica',
	'PageStatsInfo'				=> 'Statistika stranica (broj komentara, datoteka i revizija) može se u nekim situacijama razlikovati od stvarnih podataka. <br>Ova operacija omogućuje ažuriranje statistike kako bi odgovarala stvarnim podacima u bazi podataka.',

	'AttachmentsInfo'			=> 'Ažuriraj hash datoteke za sve privitke u bazi podataka.',
	'AttachmentsSynched'		=> 'Ponovno izračunati hash za sve privitke',
	'LogAttachmentsSynched'		=> 'Ponovno izračunati hash za sve privitke',

	'Feeds'						=> 'Feedovi',
	'FeedsInfo'					=> 'Ako su stranice uređivane izravno u bazi podataka, sadržaj RSS feedova možda ne odražava napravljene promjene. <br>Ova funkcija sinkronizira RSS kanale s trenutnim stanjem baze podataka.',
	'XmlSiteMap'				=> 'XML karta stranica',
	'XmlSiteMapInfo'			=> 'Ova funkcija sinkronizira XML-kartu stranica s trenutnim stanjem baze podataka.',
	'XmlSiteMapPeriod'			=> 'Razdoblje %1 dana. Zadnje zapisano %2.',
	'XmlSiteMapView'			=> 'Prikaži kartu stranica u novom prozoru.',

	'ReparseBody'				=> 'Ponovno parsiraj sve stranice',
	'ReparseBodyInfo'			=> 'Isprazni polje <code>body_r</code> u tablici stranica, tako da će svaka stranica biti ponovno renderirana pri sljedećem prikazu. To može biti korisno ako ste izmijenili formatator ili promijenili domenu svog wikija.',
	'PreparsedBodyPurged'		=> 'Ispražnjeno polje <code>body_r</code> u tablici stranica.',

	'WikiLinksResync'			=> 'Wiki poveznice',
	'WikiLinksResyncInfo'		=> 'Izvodi ponovni rendering svih unutarnjih poveznica i obnavlja sadržaj tablica <code>page_link</code> i <code>file_link</code> u slučaju oštećenja ili premještanja (ovo može potrajati).',
	'RecompilePage'				=> 'Rekompilacija svih stranica (izuzetno skupo)',
	'ResyncOptions'				=> 'Dodatne opcije',
	'RecompilePageLimit'		=> 'Broj stranica za parsiranje odjednom.',

	// Postavke e-pošte
	'EmaiSettingsInfo'			=> 'Ove informacije se koriste kad engine šalje e-poštu vašim korisnicima. Provjerite da je adresa e-pošte koju navedete valjana, jer će sva odbijena ili nedostavljiva pisma vjerojatno biti vraćena na tu adresu. Ako vaš hosting ne pruža nativnu (PHP-temeljenu) email uslugu, možete slati poruke izravno putem SMTP-a. To zahtijeva adresu odgovarajućeg poslužitelja (pitajte svog hosting providera po potrebi). Ako poslužitelj zahtijeva autentikaciju (i samo ako zahtijeva), unesite korisničko ime, lozinku i metodu autentikacije.',

	'EmailSettingsUpdated'		=> 'Ažurirane postavke e-pošte',

	'EmailFunctionName'			=> 'Naziv funkcije za e-poštu:',
	'EmailFunctionNameInfo'		=> 'Funkcija za slanje e-pošte putem PHP-a.',
	'UseSmtpInfo'				=> 'Odaberite <code>SMTP</code> ako želite, ili morate, slati e-poštu preko određenog poslužitelja umjesto lokalne mail funkcije.',

	'EnableEmail'				=> 'Omogući e-poštu:',
	'EnableEmailInfo'			=> 'Omogući slanje e-pošte.',

	'EmailIdentitySettings'		=> 'Identiteti e-pošte web-stranice',
	'FromEmailName'				=> 'Ime pošiljatelja:',
	'FromEmailNameInfo'			=> 'Ime pošiljatelja koje se koristi u zaglavlju <code>From:</code> za sve obavijesti poslane sa stranice.',
	'EmailSubjectPrefix'		=> 'Prefiks predmeta:',
	'EmailSubjectPrefixInfo'	=> 'Alternativni prefiks predmeta e-pošte, npr. <code>[Prefiks] Tema</code>. Ako nije definiran, zadani prefiks je Naziv stranice: %1.',

	'NoReplyEmail'				=> 'Adresa "no-reply":',
	'NoReplyEmailInfo'			=> 'Ova adresa, npr. <code>noreply@example.com</code>, pojavljivat će se u polju <code>From:</code> kod svih obavijesti poslanih sa stranice.',
	'AdminEmail'				=> 'E-pošta vlasnika stranice:',
	'AdminEmailInfo'			=> 'Ova adresa se koristi za administrativne svrhe, poput obavijesti o novim korisnicima.',
	'AbuseEmail'				=> 'Adresa za prijave zloupotrebe:',
	'AbuseEmailInfo'			=> 'Adresa za hitne slučajeve: registracija s tuđom adresom e-pošte itd. Može biti ista kao e-pošta vlasnika stranice.',

	'SendTestEmail'				=> 'Pošalji testnu e-poštu',
	'SendTestEmailInfo'			=> 'Ovo će poslati testnu e-poštu na adresu definiranu u vašem računu.',
	'TestEmailSubject'			=> 'Vaš Wiki je ispravno konfiguriran za slanje e-pošte',
	'TestEmailBody'				=> 'Ako ste primili ovu e-poštu, vaš Wiki je ispravno konfiguriran za slanje e-pošte.',
	'TestEmailMessage'			=> 'Testna e-pošta je poslana.<br>Ako je ne primite, provjerite svoje postavke e-pošte.',

	'SmtpSettings'				=> 'SMTP postavke',
	'SmtpAutoTls'				=> 'Opportunistički TLS:',
	'SmtpAutoTlsInfo'			=> 'Automatski omogućuje enkripciju ako poslužitelj oglašava TLS enkripciju (nakon što se povežete), čak i ako niste postavili način veze za <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Način veze za SMTP:',
	'SmtpConnectionModeInfo'	=> 'Koristi se samo ako je potrebna autentikacija korisnika/lozinke. Pitajte svog providera ako niste sigurni koju metodu odabrati.',
	'SmtpPassword'				=> 'SMTP lozinka:',
	'SmtpPasswordInfo'			=> 'Unesite lozinku samo ako vaš SMTP poslužitelj to zahtijeva.<br><em><strong>Upozorenje:</strong> Ova lozinka bit će pohranjena u bazi podataka u običnom tekstu, vidljiva svima koji imaju pristup vašoj bazi ili ovoj konfiguracijskoj stranici.</em>',
	'SmtpPort'					=> 'Port SMTP poslužitelja:',
	'SmtpPortInfo'				=> 'Promijenite samo ako znate da je vaš SMTP poslužitelj na drugom portu. <br>(zadano: <code>tls</code> na portu 587 (ili moguće 25) i <code>ssl</code> na portu 465).',
	'SmtpServer'				=> 'Adresa SMTP poslužitelja:',
	'SmtpServerInfo'			=> 'Napomena: morate navesti protokol koji vaš poslužitelj koristi. Ako koristite SSL, navedite <code>ssl://mail.example.com</code>.',
	'SmtpUsername'				=> 'SMTP korisničko ime:',
	'SmtpUsernameInfo'			=> 'Unesite korisničko ime samo ako vaš SMTP poslužitelj to zahtijeva.',

	// Postavke prijenosa
	'UploadSettingsInfo'		=> 'Ovdje možete konfigurirati glavne postavke za privitke i pripadajuće posebne kategorije.',
	'UploadSettingsUpdated'		=> 'Ažurirane postavke prijenosa',

	'FileUploadsSection'		=> 'Prijenosi datoteka',
	'RegisteredUsers'			=> 'registrirani korisnici',
	'RightToUpload'				=> 'Dozvole za prijenos datoteka:',
	'RightToUploadInfo'			=> '<code>admins</code> znači da samo korisnici koji pripadaju grupi administratora mogu prenositi datoteke. <code>1</code> znači da je prijenos otvoren registriranim korisnicima. <code>0</code> znači da je prijenos onemogućen.',
	'UploadMaxFilesize'			=> 'Maksimalna veličina datoteke:',
	'UploadMaxFilesizeInfo'		=> 'Maksimalna veličina pojedine datoteke. Ako je vrijednost 0, maksimalna veličina prijenosa ograničena je samo PHP konfiguracijom.',
	'UploadQuota'				=> 'Ukupni kvota za privitke:',
	'UploadQuotaInfo'			=> 'Maksimalni prostor na disku dostupan za privitke za cijeli wiki, pri čemu <code>0</code> znači neograničeno. Iskorišteno %1.',
	'UploadQuotaUser'			=> 'Kvota po korisniku:',
	'UploadQuotaUserInfo'		=> 'Ograničenje prostora koje jedan korisnik može koristiti za prijenos, pri čemu <code>0</code> znači neograničeno.',

	'FileTypes'					=> 'Tipovi datoteka',
	'UploadOnlyImages'			=> 'Dozvoli samo prijenos slika:',
	'UploadOnlyImagesInfo'		=> 'Dozvoli samo prijenos slikovnih datoteka na stranicu.',
	'AllowedUploadExts'			=> 'Dozvoljene vrste datoteka:',
	'AllowedUploadExtsInfo'		=> 'Dozvoljene ekstenzije za prijenos datoteka, odvojene zarezom (npr. <code>png, ogg, mp4</code>); u suprotnom su dopuštene sve ekstenzije.<br>Ograničite dozvoljene ekstenzije na minimum potreban za ispravno funkcioniranje vaše stranice.',
	'CheckMimetype'				=> 'Provjeri MIME tip:',
	'CheckMimetypeInfo'			=> 'Neki preglednici se mogu prevariti i pogrešno odrediti mimetype prenesenih datoteka. Ova opcija osigurava da se takve datoteke, koje bi mogle uzrokovati probleme, vjerojatno odbijaju.',
	'SvgSanitizer'				=> 'Sanitizator SVG-a:',
	'SvgSanitizerInfo'			=> 'Omogućuje sanitizaciju SVG datoteka kako bi se spriječile ranjivosti u SVG/XML-u prilikom prijenosa.',
	'TranslitFileName'			=> 'Transliteriraj imena datoteka:',
	'TranslitFileNameInfo'		=> 'Ako je primjenjivo i nema potrebe za Unicode znakovima, preporučljivo je prihvatiti samo alfanumeričke znakove u imenima datoteka.',
	'TranslitCaseFolding'		=> 'Pretvori nazive datoteka u mala slova:',
	'TranslitCaseFoldingInfo'	=> 'Ova opcija djeluje samo uz aktivnu transliteraciju.',

	'Thumbnails'				=> 'Sličice',
	'CreateThumbnail'			=> 'Kreiraj sličicu:',
	'CreateThumbnailInfo'		=> 'Kreiraj sličicu u svim mogućim situacijama.',
	'JpegQuality'				=> 'Kvaliteta JPEG-a:',
	'JpegQualityInfo'			=> 'Kvaliteta pri skaliranju JPEG sličice. Trebala bi biti između 1 i 100, pri čemu 100 označava 100% kvalitete.',
	'MaxImageArea'				=> 'Maksimalno područje slike:',
	'MaxImageAreaInfo'			=> 'Maksimalni broj piksela koje izvorna slika može imati. Ovo ograničava memorijsku potrošnju pri dekompresiji slike za skaliranje.<br><code>-1</code> znači da se veličina slike neće provjeravati prije pokušaja skaliranja. <code>0</code> znači da će se vrijednost odrediti automatski.',
	'MaxThumbWidth'				=> 'Maksimalna širina sličice u pikselima:',
	'MaxThumbWidthInfo'			=> 'Generirana sličica neće prelaziti širinu postavljenu ovdje.',
	'MinThumbFilesize'			=> 'Minimalna veličina datoteke za sličicu:',
	'MinThumbFilesizeInfo'		=> 'Ne stvaraj sličicu za slike manje od ovoga.',
	'MaxImageWidth'				=> 'Ograničenje širine slike na stranicama:',
	'MaxImageWidthInfo'			=> 'Maksimalna širina koju slika može imati na stranicama; inače se generira umanjena sličica.',

	// Modul izbrisanih objekata
	'DeletedObjectsInfo'		=> 'Popis uklonjenih stranica, revizija i datoteka.
									Uklonite ili vratite stranice, revizije ili datoteke iz baze podataka klikom na poveznicu <em>Remove</em>
									ili <em>Restore</em> u odgovarajućem retku. (Pažljivo, neće biti traženo potvrđivanje brisanja!)',

	// Modul filtra
	'FilterSettingsInfo'		=> 'Riječi koje će biti automatski cenzurirane na vašem wikiju.',
	'FilterSettingsUpdated'		=> 'Ažurirane postavke filtera spama',

	'WordCensoringSection'		=> 'Cenzura riječi',
	'SPAMFilter'				=> 'SPAM filter:',
	'SPAMFilterInfo'			=> 'Omogućavanje spam filtra',
	'WordList'					=> 'Popis riječi:',
	'WordListInfo'				=> 'Riječ ili fraza (ili <code>fragment</code>) koja će biti na crnoj listi (jedna po retku)',

	// Modul zapisa (log)
	'LogFilterTip'				=> 'Filtriraj događaje prema kriterijima:',
	'LogLevel'					=> 'Razina',
	'LogLevelFilters'	=> [
		'1'		=> 'ne manje od',
		'2'		=> 'ne više od',
		'3'		=> 'jednako',
	],
	'LogNoMatch'				=> 'Nema događaja koji zadovoljavaju kriterije',
	'LogDate'					=> 'Datum',
	'LogEvent'					=> 'Događaj',
	'LogUsername'				=> 'Korisničko ime',
	'LogLevels'	=> [
		'1'		=> 'kritično',
		'2'		=> 'najviše',
		'3'		=> 'visoko',
		'4'		=> 'srednje',
		'5'		=> 'nisko',
		'6'		=> 'najniže',
		'7'		=> 'debug',
	],

	// Modul masovne e-pošte
	'MassemailInfo'				=> 'Ovdje možete poslati poruku ili (1) svim svojim korisnicima ili (2) svim korisnicima određene grupe koji su omogućili primanje masovnih e-poruka. E-poruka će biti poslana na administrativnu adresu e-pošte, a slijepa kopija (BCC) će biti poslana svim primateljima. Zadano je uključiti najviše 20 primatelja u jednoj poruci. Ako ih ima više, poslat će se dodatne poruke. Ako šaljete poruku velikoj grupi, budite strpljivi nakon slanja i nemojte prekidati stranicu. Normalno je da masovno slanje potraje. Bit ćete obaviješteni kada skripta završi.',
	'LogMassemail'				=> 'Masovno slanje e-pošte %1 grupi / korisniku ',
	'MassemailSend'				=> 'Slanje masovne e-pošte',

	'NoEmailMessage'			=> 'Morate unijeti poruku.',
	'NoEmailSubject'			=> 'Morate navesti naslov poruke.',
	'NoEmailRecipient'			=> 'Morate navesti barem jednog korisnika ili grupu korisnika.',

	'MassemailSection'			=> 'Masovna e-pošta',
	'MessageSubject'			=> 'Predmet:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Vaša poruka:',
	'YourMessageInfo'			=> 'Imajte na umu da možete unijeti samo običan tekst. Sav markup bit će uklonjen prije slanja.',

	'NoUser'					=> 'Nema korisnika',
	'NoUserGroup'				=> 'Nema korisničke grupe',

	'SendToGroup'				=> 'Pošalji grupi:',
	'SendToUser'				=> 'Pošalji korisniku:',
	'SendToUserInfo'			=> 'Samo korisnici koji dopuštaju administratorima da im šalju informacije e-poštom primit će masovne poruke. Ova opcija dostupna je u njihovim korisničkim postavkama pod Obavijestima.',

	// Modul sistemske poruke
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Ažurirana sistemska poruka',

	'SysMsgSection'				=> 'Sistemska poruka',
	'SysMsg'					=> 'Sistemska poruka:',
	'SysMsgInfo'				=> 'Vaš tekst ovdje',

	'SysMsgType'				=> 'Tip:',
	'SysMsgTypeInfo'			=> 'Tip poruke (CSS).',
	'SysMsgAudience'			=> 'Publika:',
	'SysMsgAudienceInfo'		=> 'Publika kojoj se prikazuje sistemska poruka.',
	'EnableSysMsg'				=> 'Omogući sistemsku poruku:',
	'EnableSysMsgInfo'			=> 'Prikaži sistemsku poruku.',

	// Modul odobravanja korisnika
	'ApproveNotExists'			=> 'Odaberite barem jednog korisnika pomoću gumba Set.',

	'LogUserApproved'			=> 'Korisnik ##%1## odobren',
	'LogUserBlocked'			=> 'Korisnik ##%1## blokiran',
	'LogUserDeleted'			=> 'Korisnik ##%1## uklonjen iz baze podataka',
	'LogUserCreated'			=> 'Kreiran novi korisnik ##%1##',
	'LogUserUpdated'			=> 'Ažuriran korisnik ##%1##',
	'LogUserPasswordReset'		=> 'Lozinka za korisnika ##%1## uspješno resetirana',

	'UserApproveInfo'			=> 'Odobri nove korisnike prije nego što mogu pristupiti stranici.',
	'Approve'					=> 'Odobri',
	'Deny'						=> 'Odbij',
	'Pending'					=> 'Na čekanju',
	'Approved'					=> 'Odobreno',
	'Denied'					=> 'Odbijeno',

	// Modul sigurnosne kopije baze podataka
	'BackupStructure'			=> 'Struktura',
	'BackupData'				=> 'Podaci',
	'BackupFolder'				=> 'Mapa',
	'BackupTable'				=> 'Tablica',
	'BackupCluster'				=> 'Klaster:',
	'BackupFiles'				=> 'Datoteke',
	'BackupNote'				=> 'Napomena:',
	'BackupSettings'			=> 'Odredite željeni način izrade sigurnosne kopije.<br>' .
	'Root klaster ne utječe na globalnu sigurnosnu kopiju datoteka i cache datoteka (ako su odabrani, oni se uvijek spremaju u potpunosti).<br>' .  '<br>' .
	'<strong>Pažnja</strong>: Kako biste izbjegli gubitak podataka u bazi pri određivanju root klastera, tablice iz ove kopije neće biti restrukturirane, isto kao kada radite samo strukturu tablice bez spremanja podataka. Za potpunu konverziju tablica u format sigurnosne kopije morate napraviti <em>potpunu sigurnosnu kopiju baze podataka (struktura i podaci) bez označavanja klastera</em>.',
	'BackupCompleted'			=> 'Izrada sigurnosne kopije i arhiviranje završeni.<br>' .
	'Datoteke paketa sigurnosne kopije pohranjene su u podmapu %1.<br>Za preuzimanje koristite FTP (zadržite strukturu mapa i nazive datoteka prilikom kopiranja).<br>Za vraćanje sigurnosne kopije ili uklanjanje paketa, idite na <a href="%2">Obnovi bazu podataka</a>.',
	'LogSavedBackup'			=> 'Spremljena sigurnosna kopija baze podataka ##%1##',
	'Backup'					=> 'Sigurnosna kopija',
	'CantReadFile'				=> 'Ne mogu pročitati datoteku %1.',

	// Modul obnove baze podataka
	'RestoreInfo'				=> 'Možete vratiti bilo koji od pronađenih paketa sigurnosnih kopija ili ih ukloniti sa servera.',
	'ConfirmDbRestore'			=> 'Želite li vratiti sigurnosnu kopiju %1?',
	'ConfirmDbRestoreInfo'		=> 'Molimo pričekajte, ovo može potrajati.',
	'RestoreWrongVersion'		=> 'Pogrešna verzija WackoWiki!',
	'DirectoryNotExecutable'	=> 'Mapa %1 nije izvršna.',
	'BackupDelete'				=> 'Jeste li sigurni da želite ukloniti sigurnosnu kopiju %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Dodatne opcije obnove:',
	'RestoreOptionsInfo'		=> '* Prije obnavljanja <strong>klasterske sigurnosne kopije</strong>, ciljne tablice se ne brišu (kako bi se spriječio gubitak podataka iz klastera koji nisu bili uključeni u kopiju). ' .
	'Stoga će tijekom procesa vraćanja nastati duplicirani zapisi. ' .
	'U normalnom načinu svi će biti zamijenjeni zapisima iz kopije (korištenjem SQL <code>REPLACE</code>), ' .
	'ali ako je ova opcija označena, svi duplikati se preskaču (trenutne vrijednosti zapisa ostaju), ' .
	'i samo se zapisi s novim ključevima dodaju u tablicu (SQL <code>INSERT IGNORE</code>).<br>' .
	'<strong>Napomena</strong>: Kada se vraća potpuna sigurnosna kopija stranice, ova opcija nema smisla.<br>' .
	'<br>' .
	'** Ako sigurnosna kopija sadrži korisničke datoteke (globalne i po stranici, cache datoteke itd.), ' .
	'u normalnom načinu one zamjenjuju postojeće datoteke s istim imenima i vraćaju se u iste direktorije. ' .
	'Ova opcija omogućuje sačuvati trenutne kopije datoteka i vratiti iz kopije samo nove datoteke (koje nedostaju na serveru).',
	'IgnoreDuplicatedKeysNr'	=> 'Preskoči duplicirane ključeve tablice (ne zamjenjuj)',
	'IgnoreSameFiles'			=> 'Preskoči iste datoteke (ne prepiši)',
	'NoBackupsAvailable'		=> 'Nema dostupnih sigurnosnih kopija.',
	'BackupEntireSite'			=> 'Cijela stranica',
	'BackupRestored'			=> 'Sigurnosna kopija je vraćena, sažetak je naveden dolje. Za brisanje ovog paketa kliknite',
	'BackupRemoved'				=> 'Odabrana sigurnosna kopija je uspješno uklonjena.',
	'LogRemovedBackup'			=> 'Uklonjena sigurnosna kopija baze podataka ##%1##',

	'DbEngineInvalid'			=> 'Nevažeći DB engine, očekivano %1',
	'RestoreStarted'			=> 'Pokrenuto vraćanje',
	'RestoreParameters'			=> 'Koriste se parametri',
	'IgnoreDuplicatedKeys'		=> 'Preskoči duplicirane ključeve',
	'IgnoreDuplicatedFiles'		=> 'Preskoči duplicirane datoteke',
	'SavedCluster'				=> 'Spremjeni klaster',
	'DataProtection'			=> 'Zaštita podataka - izostavljeno %1',
	'AssumeDropTable'			=> 'Pretpostavi %1',
	'RestoreSQLiteDatabase'		=> 'Vraćanje SQLite baze podataka',
	'SQLiteDatabaseRestored'	=> 'Baza podataka uspješno vraćena iz:',
	'RestoreTableStructure'		=> 'Vraćanje strukture tablice',
	'RunSqlQueries'				=> 'Izvrši SQL naredbe:',
	'CompletedSqlQueries'		=> 'Dovršeno. Obradene naredbe:',
	'NoTableStructure'			=> 'Struktura tablica nije spremljena - preskočeno',
	'RestoreRecords'			=> 'Vraćanje sadržaja tablica',
	'ProcessTablesDump'			=> 'Samo preuzmi i obradi dumpove tablica',
	'Instruction'				=> 'Uputa',
	'RestoredRecords'			=> 'zapisa:',
	'RecordsRestoreDone'		=> 'Dovršeno. Ukupno zapisa:',
	'SkippedRecords'			=> 'Podaci nisu spremljeni - preskočeno',
	'RestoringFiles'			=> 'Vraćanje datoteka',
	'DecompressAndStore'		=> 'Dekomprimiraj i spremi sadržaj direktorija',
	'HomonymicFiles'			=> 'datoteke s istim imenom',
	'RestoreSkip'				=> 'preskoči',
	'RestoreReplace'			=> 'zamijeni',
	'RestoreFile'				=> 'Datoteka:',
	'RestoredFiles'				=> 'vraćeno:',
	'SkippedFiles'				=> 'preskočeno:',
	'FileRestoreDone'			=> 'Dovršeno. Ukupno datoteka:',
	'FilesAll'					=> 'sve:',
	'SkipFiles'					=> 'Datoteke se ne pohranjuju - preskoči',
	'RestoreDone'				=> 'VRAĆANJE ZAVRŠENO',

	'BackupCreationDate'		=> 'Datum izrade',
	'BackupPackageContents'		=> 'Sadržaj paketa',
	'BackupRestore'				=> 'Vrati',
	'BackupRemove'				=> 'Ukloni',
	'RestoreYes'				=> 'Da',
	'RestoreNo'					=> 'Ne',
	'LogDbRestored'				=> 'Sigurnosna kopija ##%1## baze podataka vraćena.',

	'BackupArchived'			=> 'Sigurnosna kopija %1 arhivirana.',
	'BackupArchiveExists'		=> 'Arhiva sigurnosne kopije %1 već postoji.',
	'LogBackupArchived'			=> 'Arhivirana sigurnosna kopija ##%1##.',

	// Modul korisnika
	'UsersInfo'					=> 'Ovdje možete mijenjati informacije o korisnicima i neke posebne opcije.',

	'UsersAdded'				=> 'Korisnik dodan',
	'UsersDeleteInfo'			=> 'Izbriši korisnika:',
	'EditButton'				=> 'Uredi',
	'UsersAddNew'				=> 'Dodaj novog korisnika',
	'UsersDelete'				=> 'Jeste li sigurni da želite ukloniti korisnika %1?',
	'UsersDeleted'				=> 'Korisnik %1 je uklonjen iz baze podataka.',
	'UsersRename'				=> 'Preimenuj korisnika %1 u',
	'UsersRenameInfo'			=> '* Napomena: Promjena će utjecati na sve stranice dodijeljene tom korisniku.',
	'UsersUpdated'				=> 'Korisnik je uspješno ažuriran.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Vrijeme registracije',
	'UserActions'				=> 'Radnje',
	'NoMatchingUser'			=> 'Nema korisnika koji zadovoljavaju kriterije',

	'UserAccountNotify'			=> 'Obavijesti korisnika',
	'UserNotifySignup'			=> 'obavijesti korisnika o novom računu',
	'UserVerifyEmail'			=> 'postavi token za potvrdu e-pošte i dodaj poveznicu za potvrdu',
	'UserReVerifyEmail'			=> 'Ponovno pošalji token za potvrdu e-pošte',

	// Modul grupa
	'GroupsInfo'				=> 'Iz ovog panela možete upravljati svim korisničkim grupama. Možete brisati, stvarati i uređivati grupe. Također možete odabrati vođe grupa, mijenjati status grupe (otvorena/skrivena/zatvorena) te postaviti naziv i opis grupe.',

	'LogMembersUpdated'			=> 'Ažurirani članovi grupe',
	'LogMemberAdded'			=> 'Dodano član ##%1## u grupu ##%2##',
	'LogMemberRemoved'			=> 'Uklonjen član ##%1## iz grupe ##%2##',
	'LogGroupCreated'			=> 'Kreirana nova grupa ##%1##',
	'LogGroupRenamed'			=> 'Grupa ##%1## preimenovana u ##%2##',
	'LogGroupRemoved'			=> 'Uklonjena grupa ##%1##',

	'GroupsMembersFor'			=> 'Članovi grupe',
	'GroupsDescription'			=> 'Opis',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Otvorena',
	'GroupsActive'				=> 'Aktivna',
	'GroupsTip'					=> 'Kliknite za uređivanje grupe',
	'GroupsUpdated'				=> 'Grupe ažurirane',
	'GroupsAlreadyExists'		=> 'Ta grupa već postoji.',
	'GroupsAdded'				=> 'Grupa je uspješno dodana.',
	'GroupsRenamed'				=> 'Grupa je uspješno preimenovana.',
	'GroupsDeleted'				=> 'Grupa %1 i sve pridružene stranice su uklonjene iz baze podataka.',
	'GroupsAdd'					=> 'Dodaj novu grupu',
	'GroupsRename'				=> 'Preimenuj grupu %1 u',
	'GroupsRenameInfo'			=> '* Napomena: Promjena će utjecati na sve stranice dodijeljene toj grupi.',
	'GroupsDelete'				=> 'Jeste li sigurni da želite ukloniti grupu %1?',
	'GroupsDeleteInfo'			=> '* Napomena: Promjena će utjecati na sve članove dodijeljene toj grupi.',
	'GroupsIsSystem'			=> 'Grupa %1 pripada sustavu i ne može se ukloniti.',
	'GroupsStoreButton'			=> 'Spremi grupe',
	'GroupsEditInfo'			=> 'Za uređivanje popisa grupa odaberite odgovarajući radio gumb.',

	'GroupAddMember'			=> 'Dodaj člana',
	'GroupRemoveMember'			=> 'Ukloni člana',
	'GroupAddNew'				=> 'Dodaj grupu',
	'GroupEdit'					=> 'Uredi grupu',
	'GroupDelete'				=> 'Ukloni grupu',

	'MembersAddNew'				=> 'Dodaj novog člana',
	'MembersAdded'				=> 'Novi član uspješno dodan u grupu.',
	'MembersRemove'				=> 'Jeste li sigurni da želite ukloniti člana %1?',
	'MembersRemoved'			=> 'Član je uklonjen iz grupe.',

	// Modul statistike
	'DbStatSection'				=> 'Statistika baze podataka',
	'DbTable'					=> 'Tablica',
	'DbRecords'					=> 'Zapisi',
	'DbSize'					=> 'Veličina',
	'DbIndex'					=> 'Indeks',
	'DbTotal'					=> 'Ukupno',

	'FileStatSection'			=> 'Statistika datotečnog sustava',
	'FileFolder'				=> 'Mapa',
	'FileFiles'					=> 'Datoteke',
	'FileSize'					=> 'Veličina',
	'FileTotal'					=> 'Ukupno',

	// Modul sistemskih informacija
	'SysInfo'					=> 'Informacije o verziji:',
	'SysParameter'				=> 'Parametar',
	'SysValues'					=> 'Vrijednosti',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Zadnje ažuriranje',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Naziv poslužitelja',
	'WebServer'					=> 'Web server',
	'HttpProtocol'				=> 'HTTP protokol',
	'DbVersion'					=> 'Baza podataka',
	'SqlModesGlobal'			=> 'SQL modovi globalno',
	'SqlModesSession'			=> 'SQL modovi sesija',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memorija',
	'UploadFilesizeMax'			=> 'Maksimalna veličina upload-a',
	'PostMaxSize'				=> 'Maksimalna veličina POST zahtjeva',
	'MaxExecutionTime'			=> 'Maks. vrijeme izvršavanja',
	'SessionPath'				=> 'Putanja sesije',
	'PhpDefaultCharset'			=> 'Zadani PHP charset',
	'GZipCompression'			=> 'GZip kompresija',
	'PhpExtensions'				=> 'PHP ekstenzije',
	'ApacheModules'				=> 'Apache moduli',

	// Modul popravka baze podataka
	'DbRepairSection'			=> 'Popravi bazu podataka',
	'DbRepair'					=> 'Popravi bazu podataka',
	'DbRepairInfo'				=> 'Ovaj skript može automatski potražiti uobičajene probleme s bazom podataka i pokušati ih popraviti. Popravak može potrajati, stoga budite strpljivi.',

	'DbOptimizeRepairSection'	=> 'Popravi i optimiziraj bazu podataka',
	'DbOptimizeRepair'			=> 'Popravi i optimiziraj bazu podataka',
	'DbOptimizeRepairInfo'		=> 'Ovaj skript također može pokušati optimizirati bazu podataka. To poboljšava performanse u nekim situacijama. Popravak i optimizacija mogu potrajati, a baza će biti zaključana tijekom optimizacije.',

	'TableOk'					=> 'Tablica %1 je u redu.',
	'TableNotOk'				=> 'Tablica %1 nije u redu. Prijavljuje sljedeću pogrešku: %2. Skripta će pokušati popraviti ovu tablicu…',
	'TableRepaired'				=> 'Uspješno popravljena tablica %1.',
	'TableRepairFailed'			=> 'Neuspjelo popravljanje tablice %1. <br>Pogreška: %2',
	'TableAlreadyOptimized'		=> 'Tablica %1 je već optimizirana.',
	'TableOptimized'			=> 'Uspješno optimizirana tablica %1.',
	'TableOptimizeFailed'		=> 'Neuspjelo optimiziranje tablice %1. <br>Pogreška: %2',
	'TableNotRepaired'			=> 'Neki problemi s bazom podataka nisu mogli biti popravljeni.',
	'RepairsComplete'			=> 'Popravci dovršeni',

	// Modul nekonzistentnosti
	'InconsistenciesInfo'		=> 'Prikaži i ispravi nekonzistentnosti, izbriši ili dodijeli siročad zapise novom korisniku / vrijednosti.',
	'Inconsistencies'			=> 'Nekonzistentnosti',
	'CheckDatabase'				=> 'Baza podataka',
	'CheckDatabaseInfo'			=> 'Provjerava nekonzistentnosti zapisa u bazi podataka.',
	'CheckFiles'				=> 'Datoteke',
	'CheckFilesInfo'			=> 'Provjerava napuštene datoteke, datoteke za koje više nema referenci u tablici datoteka.',
	'Records'					=> 'Zapisi',
	'InconsistenciesNone'		=> 'Nisu pronađene nekonzistentnosti podataka.',
	'InconsistenciesDone'		=> 'Nekonzistentnosti podataka riješene.',
	'InconsistenciesRemoved'	=> 'Uklonjene nekonzistentnosti',
	'Check'						=> 'Provjeri',
	'Solve'						=> 'Riješi',

	// Modul Bad Behaviour
	'BbInfo'					=> 'Otkriva i blokira neželjene web pristupe, sprječava automatizirane spambots pristupe.<br>Za više informacija posjetite %1 početnu stranicu.',
	'BbEnable'					=> 'Omogući Bad Behaviour:',
	'BbEnableInfo'				=> 'Sve ostale postavke možete mijenjati u konfiguracijskoj mapi %1.',
	'BbStats'					=> 'Bad Behaviour je blokirao %1 pokušaja pristupa u posljednjih 7 dana.',

	'BbSummary'					=> 'Sažetak',
	'BbLog'						=> 'Zapis',
	'BbSettings'				=> 'Postavke',
	'BbWhitelist'				=> 'Bijela lista',

	// --> Log
	'BbHits'					=> 'Pogoci',
	'BbRecordsFiltered'			=> 'Prikazuje se %1 od %2 zapisa filtriranih prema',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Blokirano',
	'BbPermitted'				=> 'Dozvoljeno',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Prikaz svih %1 zapisa',
	'BbShow'					=> 'Prikaži',
	'BbIpDateStatus'			=> 'IP/Datum/Status',
	'BbHeaders'					=> 'Zaglavlja',
	'BbEntity'					=> 'Entitet',

	// --> Bijela lista
	'BbOptionsSaved'			=> 'Opcije spremljene.',
	'BbWhitelistHint'			=> 'Neprimjereno dodavanje u bijelu listu IZLAŽE vas spamu ili može potpuno zaustaviti rad Bad Behaviour! NE STAVLJAJTE NA BIJELU LISTU osim ako niste 100% sigurni da to treba.',
	'BbIpAddress'				=> 'IP adresa',
	'BbIpAddressInfo'			=> 'IP adrese ili rasponi u CIDR formatu koji će biti na bijeloj listi (jedna po retku)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'Fragmenti URL-a počevši s / nakon naziva vaše domene (jedan po retku)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'Stringovi user agenta koji će biti na bijeloj listi (jedan po retku)',

	// --> Postavke
	'BbSettingsUpdated'			=> 'Ažurirane Bad Behaviour postavke',
	'BbLogRequest'				=> 'Logiranje HTTP zahtjeva',
	'BbLogVerbose'				=> 'Detaljno',
	'BbLogNormal'				=> 'Normalno (preporučeno)',
	'BbLogOff'					=> 'Ne logiraj (ne preporučuje se)',
	'BbSecurity'				=> 'Sigurnost',
	'BbStrict'					=> 'Stroga provjera',
	'BbStrictInfo'				=> 'blokira više spama, ali može blokirati i neke korisnike',
	'BbOffsiteForms'			=> 'Dozvoli slanje obrazaca s drugih web-stranica',
	'BbOffsiteFormsInfo'		=> 'potrebno za OpenID; povećava primljeni spam',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Za korištenje http:BL funkcionalnosti Bad Behaviour morate imati %1',
	'BbHttpblKey'				=> 'http:BL pristupni ključ',
	'BbHttpblThreat'			=> 'Minimalna razina prijetnje (preporučeno 25)',
	'BbHttpblMaxage'			=> 'Maksimalna starost podataka (preporučeno 30)',
	'BbReverseProxy'			=> 'Reverse proxy / balansiranje opterećenja',
	'BbReverseProxyInfo'		=> 'Ako koristite Bad Behaviour iza reverznog proxyja, load balancera, HTTP akceleratora, cache sustava ili slične tehnologije, omogućite opciju Reverse Proxy.<br>' .
	'Ako imate lanac od dva ili više reverznih proxy servera između vašeg poslužitelja i javnog Interneta, morate navesti <em>sve</em> IP rasponе (u CIDR formatu) svih vaših proxy poslužitelja, load balancera itd. Inače Bad Behaviour možda neće moći determinirati stvarnu IP adresu klijenta.<br>' .
	'Osim toga, vaši reverzni proxy poslužitelji moraju u HTTP zaglavlju postaviti IP adresu Internet klijenta od kojeg su primili zahtjev. Ako ne navedete zaglavlje, koristit će se %1. Većina proxy poslužitelja podržava X-Forwarded-For i tada je potrebno samo da to bude omogućeno na vašim proxy poslužiteljima. Neki drugi često korišteni nazivi zaglavlja su %2 i %3.',
	'BbReverseProxyEnable'		=> 'Omogući Reverse Proxy',
	'BbReverseProxyHeader'		=> 'Zaglavlje koje sadrži IP adresu Internet klijenta',
	'BbReverseProxyAddresses'	=> 'IP adresa ili rasponi u CIDR formatu za vaše proxy poslužitelje (jedan po retku)',

];
