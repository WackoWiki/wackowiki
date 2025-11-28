<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Funcții de bază',
		'preferences'	=> 'Preferințe',
		'content'		=> 'Conținut',
		'users'			=> 'Utilizatori',
		'maintenance'	=> 'Mentenanţă',
		'messages'		=> 'Mesaje',
		'extension'		=> 'Extensie',
		'database'		=> 'Baza de date',
	],

	// Admin panel
	'AdminPanel'				=> 'Panoul de Control Administrare',
	'RecoveryMode'				=> 'Mod de recuperare',
	'Authorization'				=> 'Autorizare',
	'AuthorizationTip'			=> 'Introduceți parola administrativă (asigurați-vă că în browser-ul dvs. sunt permise cookie-uri).',
	'NoRecoveryPassword'		=> 'Parola administrativă nu este specificată!',
	'NoRecoveryPasswordTip'		=> 'Notă: Absența unei parole administrative este o amenințare la adresa securității! Introduceți parola hash în fișierul de configurare și rulați din nou programul.',

	'ErrorLoadingModule'		=> 'Eroare la încărcarea modulului de administrare %1: nu există.',

	'ApHomePage'				=> 'Pagina de start',
	'ApHomePageTip'				=> 'Închideți administrarea sistemului și deschideți pagina principală',
	'ApLogOut'					=> 'Deconectare',
	'ApLogOutTip'				=> 'Părăsiți administrarea sistemului și deconectați-vă de pe site',

	'TimeLeft'					=> 'Timp rămas:  %1 minute',
	'ApVersion'					=> 'versiune',

	'SiteOpen'					=> 'Deschideți',
	'SiteOpened'				=> 'site deschis',
	'SiteOpenedTip'				=> 'Site-ul este deschis',
	'SiteClose'					=> 'Inchide',
	'SiteClosed'				=> 'site închis',
	'SiteClosedTip'				=> 'Site-ul este închis',

	'System'					=> 'Sistem',

	// Generic
	'Cancel'					=> 'Anulează',
	'Add'						=> 'Adăugare',
	'Edit'						=> 'Editare',
	'Remove'					=> 'Elimină',
	'Enabled'					=> 'Activat',
	'Disabled'					=> 'Dezactivat',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'Admin',
	'Min'						=> 'Minim',
	'Max'						=> 'Maxim',

	'MiscellaneousSection'		=> 'Diverse',
	'MainSection'				=> 'Opţiuni generale',

	'DirNotWritable'			=> 'Directorul %1 nu permite scrierea.',
	'FileNotWritable'			=> 'Fișierul %1 nu poate fi scris.',

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
		'name'		=> 'Baza',
		'title'		=> 'Setări de bază',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Aspectul',
		'title'		=> 'Setări aspect',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-mail',
		'title'		=> 'Setări e-mail',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Sindrom',
		'title'		=> 'Setări pentru sindicate',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtrare',
		'title'		=> 'Setări filtru',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Fortăreață',
		'title'		=> 'Opțiuni de formatare',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Notificări',
		'title'		=> 'Setări notificări',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Pagini',
		'title'		=> 'Pagini și parametri site',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permisiuni',
		'title'		=> 'Setări permisiuni',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Securitate',
		'title'		=> 'Setări subsisteme de securitate',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Sistem',
		'title'		=> 'Opțiuni de sistem',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Incarca',
		'title'		=> 'Setări atașamente',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Șters',
		'title'		=> 'Conținut nou șters',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Meniu',
		'title'		=> 'Adaugă, modifică sau elimină elementele de meniu implicite',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Backup',
		'title'		=> 'Salvare date',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Repară',
		'title'		=> 'Repară și optimizează baza de date',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Restaurează',
		'title'		=> 'Restabilirea datelor de rezervă',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Meniul principal',
		'title'		=> 'Administrare WackoWiki',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Incoerențe',
		'title'		=> 'Rezolvarea inconsecvențelor datelor',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Sincronizarea datelor',
		'title'		=> 'Sincronizarea datelor',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'E-mail în masă',
		'title'		=> 'E-mail în masă',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Mesaj de sistem',
		'title'		=> 'Mesaje de sistem',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Informații despre sistem',
		'title'		=> 'Informatii Sistem',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Jurnal de sistem',
		'title'		=> 'Jurnal de evenimente de sistem',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistici',
		'title'		=> 'Arată statistici',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Comportament greșit',
		'title'		=> 'Comportament greșit',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Aprobați',
		'title'		=> 'Aprobarea înregistrării utilizatorului',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Grupuri',
		'title'		=> 'Administrare grup',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Utilizatori',
		'title'		=> 'Gestionare utilizator',
	],

	// Main module
	'MainNote'					=> 'Notă: Se recomandă blocarea temporară a accesului la site pentru întreținere administrativă.',

	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'Şterge toate sesiunile',
	'PurgeSessionsConfirm'		=> 'Sunteţi sigur că doriţi să ştergeţi toate sesiunile? Acest lucru va deconecta toţi utilizatorii.',
	'PurgeSessionsExplain'		=> 'Şterge toate sesiunile. Acest lucru va deconecta toţi utilizatorii prin trunchierea tabelului auth_token.',
	'PurgeSessionsDone'			=> 'Sesiunile au fost șterse.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Setări de bază actualizate',
	'LogBasicSettingsUpdated'	=> 'Setări de bază actualizate',

	'SiteName'					=> 'Numele site-ului:',
	'SiteNameInfo'				=> 'Titlul acestui site. Apare pe titlul browserului, antetul temei, e-mail-notificare, etc.',
	'SiteDesc'					=> 'Descriere site:',
	'SiteDescInfo'				=> 'Supliment la titlul site-ului care apare în antetul paginilor. Explicaţi, în câteva cuvinte, despre ce este vorba despre acest site.',
	'AdminName'					=> 'Admin site:',
	'AdminNameInfo'				=> 'Numele de utilizator al persoanei fizice care răspunde de sprijinul general al site-ului. Acest nume nu este folosit pentru a stabili drepturile de acces, dar este de dorit să fie în conformitate cu numele administratorului principal al sitului.',

	'LanguageSection'			=> 'Limba',
	'DefaultLanguage'			=> 'Limba implicită:',
	'DefaultLanguageInfo'		=> 'Specifică limba mesajelor afișate oaspeților neînregistrați, precum și setările locale.',
	'MultiLanguage'				=> 'Suport multilingvism:',
	'MultiLanguageInfo'			=> 'Activați capacitatea de a selecta o limbă pe fiecare pagină în parte.',
	'AllowedLanguages'			=> 'Limbi permise:',
	'AllowedLanguagesInfo'		=> 'Este recomandat să selectați doar setul de limbi pe care doriți să le utilizați, altfel toate limbile sunt selectate.',

	'CommentSection'			=> 'Comentarii',
	'AllowComments'				=> 'Permite comentarii:',
	'AllowCommentsInfo'			=> 'Activează comentariile doar pentru vizitatori sau utilizatori înregistrați, sau dezactivează-le pe întregul site.',
	'SortingComments'			=> 'Sortare comentarii:',
	'SortingCommentsInfo'		=> 'Modifică ordinea comentariilor paginii sunt prezentate, fie cu cel mai recent SAU cel mai vechi comentariu din partea de sus.',
	'CommentsOffset'			=> 'Pagina de comentarii:',
	'CommentsOffsetInfo'		=> 'Pagină Comentarii de afișat în mod implicit',

	'ToolbarSection'			=> 'Bară de instrumente',
	'CommentsPanel'				=> 'Panou comentarii:',
	'CommentsPanelInfo'			=> 'Afișarea implicită a comentariilor în partea de jos a paginii.',
	'FilePanel'					=> 'Panou de fişiere:',
	'FilePanelInfo'				=> 'Afișarea implicită a atașamentelor în partea de jos a paginii.',
	'TagsPanel'					=> 'Panou etichete:',
	'TagsPanelInfo'				=> 'Afișarea implicită a panoului de etichete în partea de jos a paginii.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Arată permalink:',
	'ShowPermalinkInfo'			=> 'Afișarea implicită a permalink pentru versiunea curentă a paginii.',
	'TocPanel'					=> 'Tabelul panoului de conținut:',
	'TocPanelInfo'				=> 'Tabel implicit de afişare a conţinutului de panou al unei pagini (poate necesita suport în şabloane).',
	'SectionsPanel'				=> 'Secţiuni panou:',
	'SectionsPanelInfo'			=> 'În mod implicit, afișează panoul paginilor adiacente (necesită suport în șabloane).',
	'DisplayingSections'		=> 'Afișare secțiuni:',
	'DisplayingSectionsInfo'	=> 'Când opțiunile anterioare sunt setate, dacă se afișează doar subpaginile paginii (<em>mai mic</em>), numai vecin (<em>top</em>), ambele sau alte (<em>arbore</em>).',
	'MenuItems'					=> 'Elemente de meniu:',
	'MenuItemsInfo'				=> 'Numărul implicit de elemente de meniu afișate (poate avea nevoie de suport în șabloane).',

	'HandlerSection'			=> 'Handlers',
	'HideRevisions'				=> 'Ascunde revizuiri:',
	'HideRevisionsInfo'			=> 'Afișarea implicită a revizuirilor paginii.',
	'AttachmentHandler'			=> 'Activați gestionarul de atașamente:',
	'AttachmentHandlerInfo'		=> 'Afișarea autorizațiilor pentru manipulatorul de atașamente.',
	'SourceHandler'				=> 'Activați gestionarul sursă:',
	'SourceHandlerInfo'			=> 'Permite afișarea handler-ului sursă.',
	'ExportHandler'				=> 'Activează handler de export XML:',
	'ExportHandlerInfo'			=> 'Permite afișarea manipulatorului de export XML.',

	'DiffModeSection'			=> 'Dif moduri',
	'DefaultDiffModeSetting'	=> 'Mod diff implicit:',
	'DefaultDiffModeSettingInfo'=> 'Dif preselectat.',
	'AllowedDiffMode'			=> 'Moduri diff permise:',
	'AllowedDiffModeInfo'		=> 'Este recomandat să selectaţi doar setul de moduri diff pe care doriţi să le utilizaţi, în caz contrar sunt selectate toate modurile diferite.',
	'NotifyDiffMode'			=> 'Notifică modul diff:',
	'NotifyDiffModeInfo'		=> 'Modul Diff utilizat pentru notificările din corpul de e-mail.',

	'EditingSection'			=> 'Editare',
	'EditSummary'				=> 'Editare rezumat:',
	'EditSummaryInfo'			=> 'Afișează sumarul modificărilor în modul de editare.',
	'MinorEdit'					=> 'Editare minoră:',
	'MinorEditInfo'				=> 'Activează opțiunea de editare minoră în modul de editare.',
	'SectionEdit'				=> 'Modificare secţiune:',
	'SectionEditInfo'			=> 'Activează editarea doar a unei secțiuni a unei pagini.',
	'ReviewSettings'			=> 'Recenzie:',
	'ReviewSettingsInfo'		=> 'Activează opţiunea de recenzie în modul de editare.',
	'PublishAnonymously'		=> 'Permite publicarea anonimă:',
	'PublishAnonymouslyInfo'	=> 'Permite utilizatorilor să publice anonim (pentru a ascunde numele).',

	'DefaultRenameRedirect'		=> 'La redenumire, creează redirecționare:',
	'DefaultRenameRedirectInfo'	=> 'În mod implicit, oferta de a seta o redirecționare la vechea adresă a paginii care este redenumită.',
	'StoreDeletedPages'			=> 'Păstrează paginile șterse:',
	'StoreDeletedPagesInfo'		=> 'Când ştergeţi o pagină, un comentariu sau un fişier, păstraţi-o într-o secţiune specială, unde vor fi disponibile pentru revizuire și recuperare pentru o anumită perioadă de timp (după cum se descrie mai jos).',
	'KeepDeletedTime'			=> 'Timpul de stocare al paginilor șterse:',
	'KeepDeletedTimeInfo'		=> 'Perioada din zile. Are sens doar cu opţiunea anterioară. Folosește zero pentru a se asigura că entitățile nu sunt șterse niciodată (în acest caz administratorul poate șterge „coșul” manual).',
	'PagesPurgeTime'			=> 'Timpul de stocare al revizuirilor paginii:',
	'PagesPurgeTimeInfo'		=> 'Şterge automat versiunile mai vechi într-un număr dat de zile. Dacă introduci zero, versiunile mai vechi nu vor fi şterse.',
	'EnableReferrers'			=> 'Activare referințe:',
	'EnableReferrersInfo'		=> 'Crearea de permise și afișarea de referințe externe.',
	'ReferrersPurgeTime'		=> 'Timpul de stocare al recomandărilor:',
	'ReferrersPurgeTimeInfo'	=> 'Păstraţi istoricul paginilor externe de referinţă nu mai mult de un număr dat de zile. Folosește zero pentru a te asigura că niciodată referenții nu sunt șterși (dar pentru un site vizitat, acest lucru poate duce la un flux de baze de date).',
	'EnableCounters'			=> 'Contoare de lovituri:',
	'EnableCountersInfo'		=> 'Permite pentru fiecare pagină atingerea contoarelor şi permite afişarea de statistici simple. Vizualizările proprietarului paginii nu sunt numărate.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Controlați setările implicite de sindicat web pentru site-ul dvs.',
	'SyndicationSettingsUpdated'	=> 'Setări de sindicalizare actualizate.',

	'FeedsSection'				=> 'Fluxuri',
	'EnableFeeds'				=> 'Activează fluxurile:',
	'EnableFeedsInfo'			=> 'Porneşte sau dezactivează feed-urile RSS pentru întregul wiki.',
	'XmlChangeLink'				=> 'Schimbă modul flux:',
	'XmlChangeLinkInfo'			=> 'Definește unde se leagă obiectele de modificare XML.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'vedere diferită',
		'2'		=> 'pagina revizuită',
		'3'		=> 'lista revizuirilor',
		'4'		=> 'pagina curentă',
	],

	'XmlSitemap'				=> 'XML sitemap:',
	'XmlSitemapInfo'			=> 'Creează un fișier XML numit %1 în interiorul dosarului xml. Poti adauga calea la sitemap in fisierul robots.txt in directorul radacina dupa cum urmează:',
	'XmlSitemapGz'				=> 'Compresie sitemap XML:',
	'XmlSitemapGzInfo'			=> 'Daca doriti, puteti comprima fisierul text sitemap folosind gzip pentru a reduce cerintele de latime de banda.',
	'XmlSitemapTime'			=> 'Timp de generare sitemap XML:',
	'XmlSitemapTimeInfo'		=> 'Generează sitemap doar o singură dată în numărul dat de zile. Setat la zero pentru a genera la fiecare modificare a paginii.',

	'SearchSection'				=> 'Caută',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Creează fișierul de descriere OpenSearch în folderul XML și activează autodescoperirea plugin-ului de căutare în antetul HTML.',
	'SearchEngineVisibility'	=> 'Motoarele de căutare blocate (vizibilitate a motorului de căutare):',
	'SearchEngineVisibilityInfo'=> 'Blochează motoarele de căutare, dar permite vizitatorii obişnuiţi. Suprascrie setările paginii. <br>Dezactivează motoarele de căutare de la indexarea acestui site. Depinde de motoarele de căutare pentru a onora această cerere.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Controlați setările implicite de afișare pentru site-ul dvs.',
	'AppearanceSettingsUpdated'	=> 'Setări de aspect actualizate.',

	'LogoOff'					=> 'Dezactivat',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo și titlu',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Logo-ul site-ului:',
	'SiteLogoInfo'				=> 'Logo-ul dvs. va apărea de obicei în colțul din stânga sus al aplicației. Dimensiunea maximă este de 2 MiB. Dimensiunile optime au o lăţime de 255 pixeli cu 55 de pixeli înălţime.',
	'LogoDimensions'			=> 'Dimensiuni siglă:',
	'LogoDimensionsInfo'		=> 'Lățimea și înălțimea logo-ului afișat.',
	'LogoDisplayMode'			=> 'Mod afișare siglă:',
	'LogoDisplayModeInfo'		=> 'Definește aspectul logo-ului. Implicit este oprit.',

	'FaviconSection'			=> 'Pictogramă',
	'SiteFavicon'				=> 'Magazin favicon:',
	'SiteFaviconInfo'			=> 'Pictograma scurtăturii sau faviconul dvs. este afișat în bara de adrese, tab-uri și marcaje ale majorității browserelor. Acest lucru va suprascrie pictograma favorită a temei dvs.',
	'SiteFaviconTooBig'			=> 'Favicon este mai mare de 64 x 64 px.',
	'ThemeColor'				=> 'Culoarea temei pentru bara de adrese:',
	'ThemeColorInfo'			=> 'Browser-ul va seta culoarea barei de adrese a fiecărei pagini în funcție de culoarea CSS furnizată.',

	'LayoutSection'				=> 'Aspect',
	'Theme'						=> 'Temă:',
	'ThemeInfo'					=> 'Design-ul de șabloane utilizează site-ul în mod implicit.',
	'ResetUserTheme'			=> 'Resetează toate temele utilizatorului:',
	'ResetUserThemeInfo'		=> 'Resetează toate temele utilizatorului. Avertisment: Această acţiune va returna toate temele selectate de utilizator la tema globală implicită.',
	'SetBackUserTheme'			=> 'Reveniți toate temele utilizatorului la tema %1.',
	'ThemesAllowed'				=> 'Teme permise:',
	'ThemesAllowedInfo'			=> 'Selectați temele permise, pe care utilizatorul le poate alege; altfel, toate temele disponibile sunt permise.',
	'ThemesPerPage'				=> 'Teme per pagină:',
	'ThemesPerPageInfo'			=> 'Permite teme pe pagină, pe care proprietarul paginii le poate alege prin proprietăți ale paginii.',

	// System settings
	'SystemSettingsInfo'		=> 'Grup de parametri responsabili pentru reglarea site-ului. Nu îi schimbați decât dacă sunteți încrezător în acțiunile lor.',
	'SystemSettingsUpdated'		=> 'Setări de sistem actualizate',

	'DebugModeSection'			=> 'Mod depanare',
	'DebugMode'					=> 'Mod depanare:',
	'DebugModeInfo'				=> 'Extragerea și afișarea datelor telemetrice despre timpul de execuție al aplicației. Atenție: Modul de detaliu impune cerințe mai stricte memoriei alocate, în special pentru operațiunile cu utilizare intensivă a resurselor, cum ar fi copia de rezervă și restaurarea bazei de date.',
	'DebugModes'	=> [
		'0'		=> 'depanarea este dezactivată',
		'1'		=> 'doar timpul total de execuție',
		'2'		=> 'normă întreagă',
		'3'		=> 'detalii complete (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Pragul de performanță RDBMS:',
	'DebugSqlThresholdInfo'		=> 'În modul de depanare detaliat, raportează doar interogările care durează mai mult decât numărul de secunde specificat.',
	'DebugAdminOnly'			=> 'Diagnosticul închis:',
	'DebugAdminOnlyInfo'		=> 'Arată datele de depanare ale programului (și DBMS) doar pentru administrator.',

	'CachingSection'			=> 'Opțiuni cache',
	'Cache'						=> 'Cache randat pagini:',
	'CacheInfo'					=> 'Salvează paginile redate în cache-ul local pentru a accelera pornirea ulterioară. Valid doar pentru vizitatorii neînregistraţi.',
	'CacheTtl'					=> 'Timp de viata pentru paginile din cache :',
	'CacheTtlInfo'				=> 'Cache paginile nu mai mult de un număr specificat de secunde.',
	'CacheSql'					=> 'Cache interogări DBMS:',
	'CacheSqlInfo'				=> 'Mențineți o geocutie locală a rezultatelor anumitor interogări SQL legate de resurse.',
	'CacheSqlTtl'				=> 'Timp de viata pentru interogari SQL geocutii:',
	'CacheSqlTtlInfo'			=> 'Rezultatele Cache ale interogărilor SQL pentru cel mult numărul specificat de secunde. Valorile mai mari de 1200 nu sunt de dorit.',

	'LogSection'				=> 'Setări Jurnal',
	'LogLevelUsage'				=> 'Utilizare jurnal:',
	'LogLevelUsageInfo'			=> 'Prioritatea minimă a evenimentelor înregistrate în jurnal.',
	'LogThresholds'	=> [
		'0'		=> 'nu păstra un jurnal',
		'1'		=> 'numai nivelul critic',
		'2'		=> 'de la cel mai înalt nivel',
		'3'		=> 'de la mare',
		'4'		=> 'în medie',
		'5'		=> 'de jos',
		'6'		=> 'nivelul minim',
		'7'		=> 'înregistrează toate',
	],
	'LogDefaultShow'			=> 'Modul de afișare a jurnalului:',
	'LogDefaultShowInfo'		=> 'Numărul minim de evenimente prioritare afișate implicit în jurnal.',
	'LogModes'	=> [
		'1'		=> 'numai nivelul critic',
		'2'		=> 'de la cel mai înalt nivel',
		'3'		=> 'de la nivel înalt',
		'4'		=> 'media',
		'5'		=> 'de la un nivel scăzut',
		'6'		=> 'de la nivelul minim',
		'7'		=> 'arată tot',
	],
	'LogPurgeTime'				=> 'Timpul de stocare al jurnalului:',
	'LogPurgeTimeInfo'			=> 'Elimină jurnalul evenimentelor după numărul de zile specificat.',

	'PrivacySection'			=> 'Confidențialitate',
	'AnonymizeIp'				=> 'Anonimizează adresele IP ale utilizatorilor:',
	'AnonymizeIpInfo'			=> 'Anonimizați adresele IP unde este cazul (adică, pagină, revizuire sau referințe).',

	'ReverseProxySection'		=> 'Inversează Proxy',
	'ReverseProxy'				=> 'Folosește proxy invers:',
	'ReverseProxyInfo'			=> 'Activează această setare pentru a determina adresa IP corectă a clientului de la distanţă prin examinarea informaţiilor stocate în antetul X-Forwarded-For X-Forwarded-For headers sunt un mecanism standard pentru identificarea sistemelor client care se conectează printr-un server proxy invers, cum ar fi Squid sau Pound. Serverele proxy inverse sunt adesea utilizate pentru a îmbunătăți performanța site-urilor vizitate intens și pot oferi, de asemenea, beneficii pentru caching, securitate sau criptare pe alte site-uri. Dacă această instalație WackoWiki funcționează în spatele unui proxy invers această setare ar trebui activată astfel încât informațiile corecte despre adresa IP să fie captate în sistemele de gestionare, logare a sesiunilor, statistici și gestionare a accesului ale WackoWiki; dacă nu sunteți sigur de această setare, nu aveți un proxy invers, sau WackoWiki operează într-un mediu de găzduire comun, această setare ar trebui să rămână dezactivată.',
	'ReverseProxyHeader'		=> 'Inversează antetul proxy:',
	'ReverseProxyHeaderInfo'	=> 'Setează această valoare în cazul în care serverul tău proxy trimite IP-ul clientului într-un antet de tip
									 avut toate efectele, altele decât X-Forwarded-For. Antet "X-Forwarded-For" este o listă delimitată prin virgulă a IP-
									 , teoretic , doar ultima (cea mai din stânga) va fi folosită.',
	'ReverseProxyAddresses'		=> 'reverse_proxy acceptă o serie de adrese IP:',
	'ReverseProxyAddressesInfo'	=> 'Fiecare element din acest array este adresa IP a oricăruia dintre versiunile invers
									 - format@@0 - toate permisiunile necesare. Dacă utilizaţi acest array, WackoWiki va avea încredere în informaţia stocată
									 care nu are decât în antetele X-Forwarded-For dacă adresa IP de la distanţă este una din
									 Asteapta toate astea, adică, cererea ajunge la serverul web de la unul dintre dispozitivele voastre de la
									 Astept. În caz contrar, clientul s-ar putea conecta direct la
									 Nord decât la serverul dvs. web prin spargerea header-de--pentru-racord.',

	'SessionSection'				=> 'Gestionare sesiune',
	'SessionStorage'				=> 'Stocare sesiune:',
	'SessionStorageInfo'			=> 'Această opțiune definește unde sunt stocate datele sesiunii. În mod implicit, fie spațiul de stocare al sesiunii de date este selectat.',
	'SessionModes'	=> [
		'1'		=> 'Fişier',
		'2'		=> 'Baza de date',
	],
	'SessionNotice'					=> 'Notificare de încheiere a sesiunii:',
	'SessionNoticeInfo'				=> 'Indică cauza închiderii sesiunii.',
	'LoginNotice'					=> 'Notificare autentificare:',
	'LoginNoticeInfo'				=> 'Afişează anunţul de autentificare.',

	'RewriteMode'					=> 'Folosește <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Dacă serverul dvs. web acceptă această caracteristică, activați "frumos" adresele URL ale paginii.<br>
										Asteptari <unk> <unk>										<span class="cite">Valoarea poate fi suprascrisa de clasa Setari la rulare, indiferent dacă este oprit, dacă HTTP_MOD_REWRITE este pornit.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parametrii responsabili pentru controlul accesului şi permisiuni.',
	'PermissionsSettingsUpdated'	=> 'Setări permisiuni actualizate',

	'PermissionsSection'		=> 'Drepturi și privilegii',
	'ReadRights'				=> 'Citire implicită a drepturilor:',
	'ReadRightsInfo'			=> 'Implicit atribuit paginilor rădăcină create, precum și paginilor pentru care nu pot fi definite ACL-uri părinte.',
	'WriteRights'				=> 'Drepturi de scriere implicit:',
	'WriteRightsInfo'			=> 'Implicit atribuit paginilor rădăcină create, precum și paginilor pentru care nu pot fi definite ACL-uri părinte.',
	'CommentRights'				=> 'Drepturi de comentariu implicit:',
	'CommentRightsInfo'			=> 'Implicit atribuit paginilor rădăcină create, precum și paginilor pentru care nu pot fi definite ACL-uri părinte.',
	'CreateRights'				=> 'Crează drepturile unei subpagini în mod implicit:',
	'CreateRightsInfo'			=> 'Implicit atribuit subpaginilor create.',
	'UploadRights'				=> 'Drepturi de încărcare implicit:',
	'UploadRightsInfo'			=> 'Drepturile de încărcare implicite.',
	'RenameRights'				=> 'Redenumire globală dreapta:',
	'RenameRightsInfo'			=> 'Lista de permisiuni pentru a redenumi paginile în mod liber.',

	'LockAcl'					=> 'Blochează toate ACL-urile doar pentru a citi:',
	'LockAclInfo'				=> '<span class="cite">Suprascrie setările ACL doar pentru toate paginile de citit.</span><br>Acest lucru ar putea fi util dacă un proiect este finalizat, doriți editarea apropiată pentru o perioadă de timp din motive de securitate sau ca răspuns de urgență la un exploit sau vulnerabilitate.',
	'HideLocked'				=> 'Ascunde paginile inaccesibile:',
	'HideLockedInfo'			=> 'Dacă utilizatorul nu are permisiunea de a citi pagina, ascunde-l în diferite liste de pagini (totuși, link-ul plasat în text va fi încă vizibil).',
	'RemoveOnlyAdmins'			=> 'Doar administratorii pot șterge pagini:',
	'RemoveOnlyAdminsInfo'		=> 'Refuzați toți, cu excepția administratorilor, abilitatea de a șterge pagini. Prima limită se aplică proprietarilor de pagini normale.',
	'OwnersRemoveComments'		=> 'Proprietarii de pagini pot șterge comentariile:',
	'OwnersRemoveCommentsInfo'	=> 'Permite proprietarilor de pagini să modereze comentariile pe paginile lor.',
	'OwnersEditCategories'		=> 'Proprietarii pot edita categoriile de pagină:',
	'OwnersEditCategoriesInfo'	=> 'Permite proprietarilor să modifice lista categoriilor paginilor site-ului dvs (adaugă cuvinte, șterge cuvinte), atribuie la o pagină.',
	'TermHumanModeration'		=> 'Expirarea moderării umane:',
	'TermHumanModerationInfo'	=> 'Moderatorii pot edita comentariile doar dacă acestea au fost create nu mai mult de acest număr de zile în urmă (această limitare nu se aplică ultimului comentariu din subiect).',

	'UserCanDeleteAccount'		=> 'Permite utilizatorilor să-şi şteargă conturile',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parametrii responsabili pentru siguranța generală a platformei, pentru restricțiile de siguranță și pentru subsistemele suplimentare de securitate.',
	'SecuritySettingsUpdated'	=> 'Setări de securitate actualizate',

	'AllowRegistration'			=> 'Înregistrare online:',
	'AllowRegistrationInfo'		=> 'Deschideți înregistrarea utilizatorului. Dezactivarea acestei opțiuni va împiedica înregistrarea gratuită, cu toate acestea, administratorul site-ului va putea totuși să înregistreze utilizatori.',
	'ApproveNewUser'			=> 'Aprobați utilizatorii noi:',
	'ApproveNewUserInfo'		=> 'Permite administratorilor să aprobe utilizatorii după ce se înregistrează. Numai utilizatorilor aprobați le va fi permis să se autentifice în site.',
	'PersistentCookies'			=> 'Cookie-uri persistente:',
	'PersistentCookiesInfo'		=> 'Permite cookie-uri persistente.',
	'DisableWikiName'			=> 'Dezactivează WikiNume:',
	'DisableWikiNameInfo'		=> 'Dezactivează utilizarea obligatorie a unui WikiName pentru utilizatori. Permit înregistrarea utilizatorului cu porecle tradiționale în loc de numele formatate de CamelCase-(ex., numele de nume).',
	'UsernameLength'			=> 'Lungime nume utilizator:',
	'UsernameLengthInfo'		=> 'Numărul minim şi maxim de caractere în numele de utilizator.',

	'EmailSection'				=> 'E-mail',
	'AllowEmailReuse'			=> 'Permiteți reutilizarea adreselor de e-mail:',
	'AllowEmailReuseInfo'		=> 'Diferiți utilizatori se pot înregistra cu aceeași adresă de e-mail.',
	'EmailConfirmation'			=> 'Impune confirmarea e-mailului:',
	'EmailConfirmationInfo'		=> 'Necesită ca utilizatorul să îşi verifice adresa de e-mail înainte de a se putea autentifica.',
	'AllowedEmailDomains'		=> 'Domenii de e-mail permise:',
	'AllowedEmailDomainsInfo'	=> 'Domenii de e-mail separate prin virgulă, de ex. <code>exemplu.com, local.lan</code> etc. Dacă nu este specificat, toate domeniile de e-mail sunt permise.',
	'ForbiddenEmailDomains'		=> 'Domenii de e-mail interzise:',
	'ForbiddenEmailDomainsInfo'	=> 'Domenii de e-mail interzise separate prin virgulă, de ex. <code>exemplu.lan</code> etc. Numai dacă lista de domenii permise este goală.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Activează captcha:',
	'EnableCaptchaInfo'			=> 'Dacă este activat, captcha va fi afișat în următoarele cazuri, sau dacă este atins un prag de securitate.',
	'CaptchaComment'			=> 'Comentariu nou:',
	'CaptchaCommentInfo'		=> 'Ca protecție împotriva spam-ului, utilizatorii neînregistrați trebuie să captcha completă, înainte de a posta comentariu.',
	'CaptchaPage'				=> 'Pagină nouă:',
	'CaptchaPageInfo'			=> 'Ca protecție împotriva spamului, utilizatorii neînregistrați trebuie să completeze captcha înainte de a crea o pagină nouă.',
	'CaptchaEdit'				=> 'Editare pagină:',
	'CaptchaEditInfo'			=> 'Ca protecție împotriva spamului, utilizatorii neînregistrați trebuie să completeze captcha înainte de a edita pagini.',
	'CaptchaRegistration'		=> 'Înregistrare:',
	'CaptchaRegistrationInfo'	=> 'Ca protecție împotriva spamului, utilizatorii neînregistrați trebuie să completeze captcha înainte de a se înregistra.',

	'TlsSection'				=> 'Setări TLS',
	'TlsConnection'				=> 'Conexiune TLS:',
	'TlsConnectionInfo'			=> 'Folosește conexiune securizată TLS. <span class="cite">Activați certificatul TLS preinstalat necesar pe server, altfel veți pierde accesul la panoul de administrator!</span><br>De asemenea, determină dacă steagul Cookie Secure este setat: steagul <code>securizat</code> specifică dacă cookie-urile trebuie trimise doar prin conexiuni securizate.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Reconectați forțat clientul de la HTTP la HTTPS. Cu această opțiune dezactivată, clientul poate răsfoi site-ul printr-un canal deschis HTTP.',

	'HttpSecurityHeaders'		=> 'Antete de securitate HTTP',
	'EnableSecurityHeaders'		=> 'Activează antetul de securitate:',
	'EnableSecurityHeadersinfo'	=> 'Setează antete de securitate (cadru busting, clickjacking/XSS/CSRF). <br>CSP poate cauza probleme în anumite situații (de ex. în timpul dezvoltării) sau atunci când se utilizează plugin-uri găzduite extern, cum ar fi imagini sau scripturi. <br>Dezactivarea politicii de securitate a conținutului este un risc de securitate!',
	'Csp'						=> 'Politica de securitate a conținutului (CSP):',
	'CspInfo'					=> 'Configurarea CSP implică să decideți ce politici doriți să aplicați, și apoi să le configurați și să folosiți Politică de Content-Securitate pentru a vă stabili politica.',
	'PolicyModes'	=> [
		'0'		=> 'dezactivat',
		'1'		=> 'strict',
		'2'		=> 'personalizat',
	],
	'PermissionsPolicy'			=> 'Politica permisiunilor:',
	'PermissionsPolicyInfo'		=> 'Antet HTTP Permisiuni-Politică oferă un mecanism pentru a activa sau dezactiva în mod explicit diverse funcții puternice ale browser-ului.',
	'ReferrerPolicy'			=> 'Politica de referință:',
	'ReferrerPolicyInfo'		=> 'Directorul HTTP de referinţă reglementează informaţiile trimise în header-ul Referer-Policy care ar trebui incluse în răspunsuri.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'fără referințe',
		'2'		=> 'no-referrer-cui downgrade',
		'3'		=> 'aceeași origine',
		'4'		=> 'origine',
		'5'		=> 'origini strict-origini',
		'6'		=> 'Originea și originea',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'nesigur-url'
	],

	'UserPasswordSection'		=> 'Persistenţa parolelor utilizatorului',
	'PwdMinChars'				=> 'Lungimea minimă a parolei:',
	'PwdMinCharsInfo'			=> 'Parolele mai lungi sunt neapărat mai sigure decât parolele mai scurte (de ex. 12 până la 16 caractere).<br>Folosirea expresiilor de acces în loc de parole este încurajată.',
	'AdminPwdMinChars'			=> 'Lungimea minimă a parolei administratorului:',
	'AdminPwdMinCharsInfo'		=> 'Parolele mai lungi sunt neapărat mai sigure decât parolele mai scurte (de ex. 15 până la 20 de caractere).<br>Folosirea expresiilor de acces în loc de parole este încurajată.',
	'PwdCharComplexity'			=> 'Complexitatea necesară a parolei:',
	'PwdCharClasses'	=> [
		'0'		=> 'nu a fost testat',
		'1'		=> 'orice litere + numere',
		'2'		=> 'majuscule și numere minuscule + minuscule',
		'3'		=> 'majusculă și minusculă + numere + caractere',
	],
	'PwdUnlikeLogin'			=> 'Complicații suplimentare:',
	'PwdUnlikes'	=> [
		'0'		=> 'nu a fost testat',
		'1'		=> 'parola nu este identică cu cea de conectare',
		'2'		=> 'parola nu conține numele de utilizator',
	],

	'LoginSection'				=> 'Autentificare',
	'MaxLoginAttempts'			=> 'Numărul maxim de încercări de conectare pe nume de utilizator:',
	'MaxLoginAttemptsInfo'		=> 'Numărul de încercări de conectare permise pentru un singur cont înainte de declanșarea sarcinii anti-spambot. Introduceți 0 pentru a preveni declanșarea sarcinii anti-spambot pentru conturi de utilizator distincte.',
	'IpLoginLimitMax'			=> 'Numărul maxim de încercări de conectare pe adresă IP:',
	'IpLoginLimitMaxInfo'		=> 'Pragul de încercări de conectare permis de la o singură adresă IP înainte de declanșarea unei sarcini anti-spambot. Introduceți 0 pentru a preveni declanșarea sarcinii anti-spambot de către adresele IP.',

	'FormsSection'				=> 'Formulare',
	'FormTokenTime'				=> 'Timpul maxim pentru trimiterea formularelor:',
	'FormTokenTimeInfo'			=> 'Timpul în care un utilizator trebuie să trimită un formular (în secunde).<br> Rețineți că un formular ar putea deveni invalid dacă sesiunea expiră, indiferent de această setare.',

	'SessionLength'				=> 'Expirarea cookie-urilor sesiunii:',
	'SessionLengthInfo'			=> 'Durata implicită a cookie-ului sesiunii utilizatorului (în zile).',
	'CommentDelay'				=> 'Anti-inundație pentru comentarii:',
	'CommentDelayInfo'			=> 'Întârzierea minimă între publicarea noilor comentarii ale utilizatorului (în secunde).',
	'IntercomDelay'				=> 'Anti-inundații pentru comunicarea personală:',
	'IntercomDelayInfo'			=> 'Întârzierea minimă între trimiterea mesajelor private (în secunde).',
	'RegistrationDelay'			=> 'Pragul de timp pentru înregistrare:',
	'RegistrationDelayInfo'		=> 'Pragul minim de timp între depunerea formularelor de înregistrare pentru a descuraja roboții de înregistrare (în secunde).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Grup de parametri responsabili pentru reglarea site-ului. Nu îi schimbați decât dacă sunteți încrezător în acțiunile lor.',
	'FormatterSettingsUpdated'	=> 'Setări de formatare actualizate',

	'TextHandlerSection'		=> 'Gestionar de text:',
	'Typografica'				=> 'Proofreader tipografic:',
	'TypograficaInfo'			=> 'Dezactivarea acestei opțiuni va accelera procesul de adăugare a comentariilor și de salvare a paginilor.',
	'Paragrafica'				=> 'Marcajele Paragrafica:',
	'ParagraficaInfo'			=> 'Similar cu opțiunea anterioară, dar va duce la deconectarea tabelului automat de conținut inoperabil (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Suport HTML global:',
	'AllowRawhtmlInfo'			=> 'Această opțiune poate fi nesigură pentru un site deschis.',
	'SafeHtml'					=> 'Filtrare HTML:',
	'SafeHtmlInfo'				=> 'Prevenirea salvării obiectelor HTML periculoase. Dezactivarea filtrului pe un site cu suport HTML este <span class="underline">extrem de</span> nedorit!',

	'WackoFormatterSection'		=> 'Formatter text Wiki (Wacko Formatter)',
	'X11colors'					=> 'X11 culori utilizate:',
	'X11colorsInfo'				=> 'Extinde culorile disponibile pentru <code>??(color) fundal??</code> și <code>!!(color) text!!</code>Dezactivarea acestei opțiuni accelerează procesele de adăugare a comentariilor și de salvare a paginilor.',
	'WikiLinks'					=> 'Dezactivare link-uri wiki:',
	'WikiLinksInfo'				=> 'Dezactiveaza legatura pentru <code>CamelCaseWords</code>: Cuvintele CamelCase nu vor mai fi legate direct la o pagina noua. Acest lucru este util atunci când lucrați pe diferite spații de nume/clustere. Implicit este oprit.',
	'BracketsLinks'				=> 'Dezactivează link-urile cu paranteză:',
	'BracketsLinksInfo'			=> 'Dezactivează sintaxa <code>[[link]]</code> și <code>(link))</code>.',
	'Formatters'				=> 'Dezactivare formatare:',
	'FormattersInfo'			=> 'Dezactivează sintaxa <code>%%code%%</code>, utilizată pentru evidențiere.',

	'DateFormatsSection'		=> 'Formate de dată',
	'DateFormat'				=> 'Formatul datei:',
	'DateFormatInfo'			=> '(zi, lună, an)',
	'TimeFormat'				=> 'Formatul orei:',
	'TimeFormatInfo'			=> '(oră, minut)',
	'TimeFormatSeconds'			=> 'Formatul orei exacte:',
	'TimeFormatSecondsInfo'		=> '(ore, minute, secunde)',
	'NameDateMacro'				=> 'Formatul <code>::@::</code> macro:',
	'NameDateMacroInfo'			=> '(nume, oră), ex. <code>Utilizator (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Timezone:',
	'TimezoneInfo'				=> 'Fus orar utilizat pentru afișarea timpilor pentru utilizatorii care nu sunt autentificați (vizitatori). Utilizatorii autentificați își pot schimba fusul orar în setările lor de utilizator.',
	'AmericanDate'					=> 'Data Statelor Unite:',
	'AmericanDateInfo'				=> 'Folosește formatul de dată american ca implicit pentru engleză.',

	'Canonical'					=> 'Utilizaţi URL-uri complet canonice:',
	'CanonicalInfo'				=> 'Toate link-urile sunt create ca URL-uri absolute în forma %1. URL-uri relative la rădăcina serverului în forma %2 ar trebui să fie preferate.',
	'LinkTarget'				=> 'Acolo unde se deschid link-uri externe:',
	'LinkTargetInfo'			=> 'Deschide fiecare link extern într-o nouă fereastră de browser. Adaugă <code>target="_blank"</code> la sintaxa link-ului.',
	'Noreferrer'				=> 'noreferinte:',
	'NoreferrerInfo'			=> 'Necesită ca browserul să nu trimită un antet de referer HTTP dacă utilizatorul urmează hyperlink-ul. Adaugă <code>rel="noreferrer"</code> la sintaxa link-ului.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Apreciază motoarelor de căutare că hiperlinkurile nu ar trebui să afecteze clasamentul paginii țintă din indexul motorului de căutare. Adaugă <code>rel="nofollow"</code> la sintaxa link-ului.',
	'UrlsUnderscores'			=> 'Adrese de formular (URL-uri) cu sublinieri:',
	'UrlsUnderscoresInfo'		=> 'De exemplu, %1 becames %2 cu această opţiune.',
	'ShowSpaces'				=> 'Arată spaţiile în WikiNume:',
	'ShowSpacesInfo'			=> 'Arată spațiile în WikiNames, de ex. <code>MyName</code> fiind afișat ca <code>Numele meu</code> cu această opțiune.',
	'NumerateLinks'				=> 'Enumerați link-uri în vizualizarea tipăririi:',
	'NumerateLinksInfo'			=> 'Enumerează și enumeră toate link-urile din partea de jos a vizualizării printului cu această opțiune.',
	'YouareHereText'			=> 'Dezactivați și vizualizați link-urile de auto-referință:',
	'YouareHereTextInfo'		=> 'Vizualizează link-uri către aceeași pagină, folosind <code>&lt;b&gt;####&lt;/b&gt;</code>. Toate link-urile către auto-pierd formatarea link-ului, dar sunt afișate ca text îngroșat.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Aici puteţi seta sau modifica paginile de bază ale sistemului folosite în Wiki. Vă rugăm să vă asigurați că nu uitați să creați sau să schimbați paginile corespunzătoare din Wiki aici.',
	'PagesSettingsUpdated'		=> 'Actualizați paginile de bază ale setărilor',

	'ListCount'					=> 'Numărul de articole pe listă:',
	'ListCountInfo'				=> 'Numărul de elemente afișate în fiecare listă pentru vizitatori, sau ca valoare implicită pentru utilizatorii noi.',

	'ForumSection'				=> 'Forumul Opţiunilor',
	'ForumCluster'				=> 'Forum cluster:',
	'ForumClusterInfo'			=> 'Cluster rădăcină pentru secţiunea forum (acţiunea %1).',
	'ForumTopics'				=> 'Număr de subiecte pe pagină:',
	'ForumTopicsInfo'			=> 'Numărul de subiecte de discuţie afişate pe fiecare pagină a listei în secţiunile forumului (acţiunea %1).',
	'CommentsCount'				=> 'Numărul de comentarii pe pagină:',
	'CommentsCountInfo'			=> 'Numărul de comentarii afişate pe lista de comentarii a fiecărei pagini. Acest lucru se aplică tuturor comentariilor de pe site, nu doar celor postate în forum.',

	'NewsSection'				=> 'Ştiri din secţiune',
	'NewsCluster'				=> 'Grup pentru știri:',
	'NewsClusterInfo'			=> 'Cluster rădăcină pentru secțiunea știri (acțiunea %1).',
	'NewsStructure'				=> 'Structura clusterelor de știri:',
	'NewsStructureInfo'			=> 'Stochează articolele opțional în subclustere pe an/lună sau săptămână (de ex. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licenta',
	'DefaultLicense'			=> 'Licență implicită:',
	'DefaultLicenseInfo'		=> 'sub ce licență poate fi partajat conținutul dvs.',
	'EnableLicense'				=> 'Permite licența:',
	'EnableLicenseInfo'			=> 'Activează afișarea informațiilor de licență.',
	'LicensePerPage'			=> 'Licență pe pagină:',
	'LicensePerPageInfo'		=> 'Permite licența pe pagină, pe care proprietarul paginii o poate alege prin proprietățile paginii.',

	'ServicePagesSection'		=> 'Pagini de servicii',
	'RootPage'					=> 'Prima pagină:',
	'RootPageInfo'				=> 'Eticheta paginii principale, se deschide automat atunci când un utilizator vizitează site-ul tău.',

	'PrivacyPage'				=> 'Politica de confidențialitate:',
	'PrivacyPageInfo'			=> 'Pagina cu Politica de Confidențialitate a site-ului.',

	'TermsPage'					=> 'Politici și regulamente:',
	'TermsPageInfo'				=> 'Pagina cu regulile site-ului.',

	'SearchPage'				=> 'Căutare:',
	'SearchPageInfo'			=> 'Pagina cu formularul de căutare (acţiunea %1).',
	'RegistrationPage'			=> 'Înregistrare:',
	'RegistrationPageInfo'		=> 'Pagina pentru înregistrarea unui utilizator nou (acţiunea %1).',
	'LoginPage'					=> 'Autentificare utilizator:',
	'LoginPageInfo'				=> 'Pagina de conectare pe site (acțiunea %1).',
	'SettingsPage'				=> 'Setări utilizator:',
	'SettingsPageInfo'			=> 'Pagina pentru a personaliza profilul utilizatorului (acţiunea %1).',
	'PasswordPage'				=> 'Schimbă parola:',
	'PasswordPageInfo'			=> 'Pagina cu un formular pentru a schimba / interoga parola utilizatorului (actiunea %1).',
	'UsersPage'					=> 'Listă de utilizatori:',
	'UsersPageInfo'				=> 'Pagina cu o listă de utilizatori înregistrați (acțiunea %1).',
	'CategoryPage'				=> 'Categorie:',
	'CategoryPageInfo'			=> 'Pagina cu o listă de pagini clasificate (acţiunea %1).',
	'GroupsPage'				=> 'Grupuri:',
	'GroupsPageInfo'			=> 'Pagina cu o listă de grupuri de lucru (acţiunea %1).',
	'WhatsNewPage'				=> 'Ce este nou:',
	'WhatsNewPageInfo'			=> 'Pagina cu o listă cu toate paginile noi, șterse, sau modificate, atașamente noi și comentarii. (acțiunea %1).',
	'ChangesPage'				=> 'Modificări recente:',
	'ChangesPageInfo'			=> 'Pagina cu o listă a ultimelor pagini modificate (acţiunea %1).',
	'CommentsPage'				=> 'Comentarii recente:',
	'CommentsPageInfo'			=> 'Pagina cu o listă de comentarii recente pe pagină (acţiunea %1).',
	'RemovalsPage'				=> 'Pagini șterse:',
	'RemovalsPageInfo'			=> 'Pagina cu o listă de pagini recent șterse (acțiunea %1).',
	'WantedPage'				=> 'Pagini dorite:',
	'WantedPageInfo'			=> 'Pagina cu o listă de pagini lipsă care sunt referențiate (acțiunea %1).',
	'OrphanedPage'				=> 'Pagini orfane:',
	'OrphanedPageInfo'			=> 'Pagina cu o listă a paginilor existente nu sunt legate prin link-uri către orice altă pagină (acţiunea %1).',
	'SandboxPage'				=> 'Cutie de nisip.',
	'SandboxPageInfo'			=> 'Pagina în care utilizatorii își pot exersa abilitățile de marcare wiki.',
	'HelpPage'					=> 'Ajutor:',
	'HelpPageInfo'				=> 'Secțiunea de documentație pentru lucrul cu uneltele site-ului.',
	'IndexPage'					=> 'Indice:',
	'IndexPageInfo'				=> 'Pagina cu o listă a tuturor paginilor (acţiunea %1).',
	'RandomPage'				=> 'Aleator:',
	'RandomPageInfo'			=> 'Încarcă o pagină aleatorie (acțiunea %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parametrii pentru notificările platformei.',
	'NotificationSettingsUpdated'	=> 'Setări de notificare actualizate',

	'EmailNotification'			=> 'Notificare e-mail:',
	'EmailNotificationInfo'		=> 'Permiteți notificarea prin e-mail. Setați la activare pentru a activa notificările prin e-mail, dezactivat pentru a le dezactiva. Reţineţi că dezactivarea notificărilor prin e-mail nu are niciun efect asupra e-mailurilor generate ca parte a procesului de înscriere a utilizatorului.',
	'Autosubscribe'				=> 'Auto-abonare:',
	'AutosubscribeInfo'			=> 'Notifică automat proprietarul modificărilor de pagină.',

	'NotificationSection'		=> 'Setări implicite de notificare utilizator',
	'NotifyPageEdit'			=> 'Notifică editarea paginii:',
	'NotifyPageEditInfo'		=> 'În aşteptare - Trimite o notificare prin e-mail doar pentru prima modificare până când utilizatorul vizitează din nou pagina.',
	'NotifyMinorEdit'			=> 'Notifică editarea minoră:',
	'NotifyMinorEditInfo'		=> 'Trimite notificări și pentru editări minore.',
	'NotifyNewComment'			=> 'Notifică un nou comentariu:',
	'NotifyNewCommentInfo'		=> 'În aşteptare - Trimite o notificare prin e-mail doar pentru primul comentariu până când utilizatorul vizitează din nou pagina.',

	'NotifyUserAccount'			=> 'Notifică noul cont de utilizator:',
	'NotifyUserAccountInfo'		=> 'Administratorul va fi notificat atunci când un utilizator nou a fost creat folosind formularul de înscriere.',
	'NotifyUpload'				=> 'Notifică încărcarea fișierului:',
	'NotifyUploadInfo'			=> 'Moderatorii vor fi notificați când a fost încărcat un fișier.',

	'PersonalMessagesSection'	=> 'Mesaje personale',
	'AllowIntercomDefault'		=> 'Permite intercom:',
	'AllowIntercomDefaultInfo'	=> 'Activarea acestei opțiuni permite altor utilizatori să trimită mesaje personale la adresa de e-mail a destinatarului fără a dezvălui adresa.',
	'AllowMassemailDefault'		=> 'Permite e-mail de masă:',
	'AllowMassemailDefaultInfo'	=> 'Trimite mesaje doar acelor utilizatori care au permis administratorilor să îi trimită prin e-mail.',

	// Resync settings
	'Synchronize'				=> 'Synchronize',
	'UserStatsSynched'			=> 'Statistici utilizator sincronizate.',
	'PageStatsSynched'			=> 'Statistici pagină sincronizate.',
	'FeedsUpdated'				=> 'RSS-feed-uri actualizate.',
	'SiteMapCreated'			=> 'Noua versiune a hărții site-ului a fost creată cu succes.',
	'ParseNextBatch'			=> 'Analiza următorului lot de pagini:',
	'WikiLinksRestored'			=> 'Link-uri Wiki restaurate.',

	'LogUserStatsSynched'		=> 'Statistici sincronizate pentru utilizatori',
	'LogPageStatsSynched'		=> 'Statistici pagină sincronizate',
	'LogFeedsUpdated'			=> 'Fluxuri RSS sincronizate',
	'LogPageBodySynched'		=> 'Corpul paginii și link-urile reanalizate',

	'UserStats'					=> 'Statistici utilizatori',
	'UserStatsInfo'				=> 'Statisticile utilizatorilor (numărul de comentarii, pagini deținute, revizuiri și fișiere) pot diferi în unele situații de datele reale. <br>Această operațiune permite actualizarea statisticilor pentru a se potrivi cu datele actuale conținute în baza de date.',
	'PageStats'					=> 'Statistici pagină',
	'PageStatsInfo'				=> 'Statisticile paginilor (numărul de comentarii, fișiere și revizuiri) pot diferi în unele situații de datele reale. <br>Această operațiune permite actualizarea statisticilor pentru a se potrivi datelor actuale conținute în baza de date.',

	'AttachmentsInfo'			=> 'Actualizeaza fisierul hash pentru toate atasamentele din baza de date.',
	'AttachmentsSynched'		=> 'Re-hashed toate atașamentele fișierului',
	'LogAttachmentsSynched'		=> 'Re-hashed toate atașamentele fișierului',

	'Feeds'						=> 'Fluxuri',
	'FeedsInfo'					=> 'În cazul editării directe a paginilor în baza de date, conținutul fluxurilor RSS poate să nu reflecte modificările efectuate. <br>Această funcţie sincronizează canalele RSS cu starea curentă a bazei de date.',
	'XmlSiteMap'				=> 'XML Sitemap',
	'XmlSiteMapInfo'			=> 'Această funcţie sincronizează XML-Sitemap cu starea curentă a bazei de date.',
	'XmlSiteMapPeriod'			=> 'Perioada %1 zile. Ultima dată scris %2.',
	'XmlSiteMapView'			=> 'Arată sitemap într-o fereastră nouă.',

	'ReparseBody'				=> 'Repară toate paginile',
	'ReparseBodyInfo'			=> 'Empties <code>body_r</code> în tabelul de pagini, astfel încât fiecare pagină să fie redată la vizualizarea paginii următoare. Acest lucru poate fi util dacă ați modificat formatorul sau ați schimbat domeniul wiki-ului.',
	'PreparsedBodyPurged'		=> 'Câmpul Emptied <code>body_r</code> din tabelul paginii.',

	'WikiLinksResync'			=> 'Link-uri Wiki',
	'WikiLinksResyncInfo'		=> 'Efectuează o re-redare pentru toate link-urile intrazite și restaurează conținutul tabelelor <code>page_link</code> și <code>file_link</code> în caz de daune sau delocalizare (acest lucru poate dura considerabil de timp).',
	'RecompilePage'				=> 'Recompilarea tuturor paginilor (extrem de costisitoare)',
	'ResyncOptions'				=> 'Opțiuni suplimentare',
	'RecompilePageLimit'		=> 'Numărul de pagini de analizat imediat.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Aceste informații sunt utilizate atunci când motorul trimite e-mailuri utilizatorilor dvs. Asigurați-vă că adresa de e-mail pe care o specificați este validă, deoarece orice mesaje returnate sau infiabile vor fi probabil trimise la acea adresă. În cazul în care furnizorul dvs. de găzduire nu furnizează un serviciu de e-mail nativ (bazat pe PSP), puteți trimite mesaje direct folosind SMTP. Acest lucru necesită adresa unui server potrivit (întreabă furnizorul tău de găzduire dacă este necesar). În cazul în care serverul necesită autentificare (și numai în cazul în care o face), introduceți numele de utilizator, parola și metoda de autentificare necesare.',

	'EmailSettingsUpdated'		=> 'Setări e-mail actualizate',

	'EmailFunctionName'			=> 'Nume funcţie e-mail',
	'EmailFunctionNameInfo'		=> 'Funcția de e-mail folosită pentru a trimite e-mailuri prin PHP.',
	'UseSmtpInfo'				=> 'Selectați <code>SMTP</code> dacă doriți sau trebuie să trimiteți e-mail prin intermediul unui server numit în loc de prin intermediul funcției locale de e-mail.',

	'EnableEmail'				=> 'Activează e-mailurile:',
	'EnableEmailInfo'			=> 'Activează trimiterea de e-mailuri.',

	'EmailIdentitySettings'		=> 'Identitati e-mail site',
	'FromEmailName'				=> 'De la nume:',
	'FromEmailNameInfo'			=> 'Numele expeditorului care este folosit pentru <code>din:</code> antet pentru toate notificările prin e-mail trimise de pe site.',
	'EmailSubjectPrefix'		=> 'Prefix subiect:',
	'EmailSubjectPrefixInfo'	=> 'Prefix de e-mail alternativ, ex. <code>[Prefix] Topic</code>. Dacă nu este definit, prefixul implicit este numele site-ului: %1.',

	'NoReplyEmail'				=> 'Adresă fără răspuns:',
	'NoReplyEmailInfo'			=> 'Această adresă, de ex. <code>noreply@example.com</code>, va apărea în câmpul <code>din:</code> adresa de e-mail pentru toate notificările trimise de pe site.',
	'AdminEmail'				=> 'E-mailul proprietarului site-ului:',
	'AdminEmailInfo'			=> 'Această adresă este folosită în scopuri de administrator, cum ar fi notificarea unui nou utilizator.',
	'AbuseEmail'				=> 'Serviciu de abuz de e-mail:',
	'AbuseEmailInfo'			=> 'Adresa solicită chestiuni urgente: înregistrarea pentru un e-mail străin, etc. Poate fi identică cu adresa de e-mail a proprietarului site-ului.',

	'SendTestEmail'				=> 'Trimite un e-mail de test',
	'SendTestEmailInfo'			=> 'Acest lucru va trimite un e-mail de testare la adresa definită în contul dvs.',
	'TestEmailSubject'			=> 'Wiki este configurat corect pentru a trimite e-mailuri',
	'TestEmailBody'				=> 'Dacă ați primit acest e-mail, Wiki este configurat corect pentru a trimite e-mailuri.',
	'TestEmailMessage'			=> 'A fost trimis e-mailul de test.<br>Dacă nu îl primiţi, vă rugăm să verificaţi setările de configurare pentru e-mail.',

	'SmtpSettings'				=> 'Setări SMTP',
	'SmtpAutoTls'				=> 'TLS oportunist:',
	'SmtpAutoTlsInfo'			=> 'Activează criptarea automată, dacă vede că serverul face publicitate pentru criptarea TLS (după ce te-ai conectat la server), chiar dacă nu aţi setat modul de conexiune pentru <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Mod conexiune pentru SMTP:',
	'SmtpConnectionModeInfo'	=> 'Folosit numai dacă este necesar un nume/o parolă. Întreabă furnizorul dacă nu ești sigur ce metodă să folosești',
	'SmtpPassword'				=> 'Parola SMTP:',
	'SmtpPasswordInfo'			=> 'Introduceți o parolă doar dacă serverul dvs. SMTP are nevoie.<br><em><strong>Avertisment:</strong> Această parolă va fi stocată ca plaintext în baza de date, vizibil tuturor celor care pot accesa baza de date sau care pot vizualiza această pagină de configurare.</em>',
	'SmtpPort'					=> 'Portul serverului SMTP:',
	'SmtpPortInfo'				=> 'Schimbă asta doar dacă ştii că serverul tău SMTP este într-un alt port. <br>(implicit: <code>tls</code> on port 587 (sau posibil 25) and <code>ssl</code> on port 465).',
	'SmtpServer'				=> 'Adresa serverului SMTP:',
	'SmtpServerInfo'			=> 'Țineți cont că trebuie să furnizați protocolul pe care îl folosește server-ul dvs. Dacă utilizați SSL, acesta trebuie să fie <code>ssl://mail.example.com</code>.',
	'SmtpUsername'				=> 'Nume utilizator SMTP:',
	'SmtpUsernameInfo'			=> 'Introduceți un nume de utilizator doar dacă serverul dvs. SMTP are nevoie.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Aici puteţi configura setările principale pentru ataşamente şi categoriile speciale asociate.',
	'UploadSettingsUpdated'		=> 'Setări de încărcare actualizate',

	'FileUploadsSection'		=> 'Încărcări fișiere',
	'RegisteredUsers'			=> 'utilizatori înregistrați',
	'RightToUpload'				=> 'Permisiuni de incarcare fisiere:',
	'RightToUploadInfo'			=> '<code>admins</code> înseamnă că numai utilizatorii care aparțin grupului de administratori pot încărca fișiere. <code>1</code> înseamnă că încărcarea este deschisă utilizatorilor înregistraţi. <code>0</code> înseamnă că încărcarea este dezactivată.',
	'UploadMaxFilesize'			=> 'Dimensiunea maximă a fișierului:',
	'UploadMaxFilesizeInfo'		=> 'Dimensiunea maxima a fiecarui fisier. Daca aceasta valoare este 0, dimensiunea maxima a fisierului uploadable este limitata doar de configuratia PHP.',
	'UploadQuota'				=> 'Cota totală atașament:',
	'UploadQuotaInfo'			=> 'Spațiu maxim disponibil pentru atașamente pentru întregul wiki, cu <code>0</code> nelimitat. %1 utilizat.',
	'UploadQuotaUser'			=> 'Cota de stocare per utilizator:',
	'UploadQuotaUserInfo'		=> 'Restricționare a contingentului de stocare care poate fi încărcat de un utilizator, cu <code>0</code> nelimitat.',

	'FileTypes'					=> 'Tipuri de fișiere',
	'UploadOnlyImages'			=> 'Permite doar încărcarea de imagini:',
	'UploadOnlyImagesInfo'		=> 'Permite doar încărcarea fişierelor imagine de pe pagină.',
	'AllowedUploadExts'			=> 'Tipuri de fișiere permise:',
	'AllowedUploadExtsInfo'		=> 'Extensii permise pentru încărcarea fişierelor, separate prin virgulă (adică, <code>png, ogg, mp4</code>); în caz contrar, toate extensiile de fişiere sunt permise.<br>Ar trebui să limitați extensiile de fișiere permise la minimul necesar pentru funcționalitatea corectă a site-ului dvs.',
	'CheckMimetype'				=> 'Verifică tipul MIME:',
	'CheckMimetypeInfo'			=> 'Unele browsere pot fi păcăliți să presupună un tip de mimetru incorect pentru fișierele încărcate. Această opțiune asigură că astfel de fișiere care ar putea cauza acest lucru sunt respinse.',
	'SvgSanitizer'				=> 'Scanitizator SVG:',
	'SvgSanitizerInfo'			=> 'Aceasta permite sanitizarea fișierelor SVG pentru a preveni ca vulnerabilitățile SVG/XML să fie încărcate.',
	'TranslitFileName'			=> 'Numele fişierelor de transliterat:',
	'TranslitFileNameInfo'		=> 'Dacă este aplicabil și nu este nevoie să ai caractere Unicode, este foarte recomandat să accepți doar caractere alfanumerice în numele fișierelor.',
	'TranslitCaseFolding'		=> 'Convertește numele fișierelor în litere mici:',
	'TranslitCaseFoldingInfo'	=> 'Această opțiune este eficientă doar în cazul transliterării active.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Create thumbnail:',
	'CreateThumbnailInfo'		=> 'Creați o miniatură în toate situațiile posibile.',
	'JpegQuality'				=> 'Calitatea JPEG:',
	'JpegQualityInfo'			=> 'Calitate la scalarea unei miniaturi JPEG. Ar trebui să fie între 1 și 100, 100 indicând o calitate 100%.',
	'MaxImageArea'				=> 'Suprafață maximă imagine:',
	'MaxImageAreaInfo'			=> 'Numărul maxim de pixeli pe care o poate avea o imagine sursă. Aceasta oferă o limită de utilizare a memoriei pentru partea de decompresie a scalatorului de imagini.<br><code></code> înseamnă că nu va verifica dimensiunea imaginii înainte de a încerca să o scară. <code></code> înseamnă că va determina valoarea în mod automat.',
	'MaxThumbWidth'				=> 'Lățimea maximă a miniaturii în pixeli:',
	'MaxThumbWidthInfo'			=> 'O miniatură generata nu va depasi latimea setata aici.',
	'MinThumbFilesize'			=> 'Dimensiune minimă a fişierului miniatură:',
	'MinThumbFilesizeInfo'		=> 'Nu crea o miniatură pentru imagini mai mici de atât.',
	'MaxImageWidth'				=> 'Limita dimensiunii imaginii pe pagini:',
	'MaxImageWidthInfo'			=> 'Lățimea maximă pe care o imagine poate avea pe pagini, altfel o miniatură scalată în jos este generată.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Lista paginilor, revizuirilor și fișierelor eliminate.
 Eliminați sau restaurați paginile, revizuirile sau fișierele din baza de date făcând clic pe linkul <em>Eliminați</em>
 sau <em>Restaurați</em> în rândul corespunzător. (Aveți grijă, nu se solicită nicio confirmare de ștergere!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Cuvinte care vor fi cenzurate automat pe Wiki.',
	'FilterSettingsUpdated'		=> 'Setări filtru spam actualizate',

	'WordCensoringSection'		=> 'Cenzurare cuvânt',
	'SPAMFilter'				=> 'Filtru de spam:',
	'SPAMFilterInfo'			=> 'Activarea filtrului de spam',
	'WordList'					=> 'Listă cuvinte:',
	'WordListInfo'				=> 'Cuvinte sau fraza <code>fragment</code> pentru a fi pe lista neagră (unul pe linie)',

	// Log module
	'LogFilterTip'				=> 'Filtrează evenimentele după criterii:',
	'LogLevel'					=> 'Nivel',
	'LogLevelFilters'	=> [
		'1'		=> 'minim de',
		'2'		=> 'nu mai mare de',
		'3'		=> 'egal',
	],
	'LogNoMatch'				=> 'Niciun eveniment care îndeplinește criteriile',
	'LogDate'					=> 'Data',
	'LogEvent'					=> 'Eveniment',
	'LogUsername'				=> 'Nume',
	'LogLevels'	=> [
		'1'		=> 'critică',
		'2'		=> 'cele mai',
		'3'		=> 'înalt',
		'4'		=> 'medie',
		'5'		=> 'scăzută',
		'6'		=> 'cel mai mic',
		'7'		=> 'depanare',
	],

	// Massemail module
	'MassemailInfo'				=> 'Aici puteți trimite un mesaj către (1) toți utilizatorii dvs. sau (2) toți utilizatorii unui anumit grup care au activat primirea de e-mailuri în masă. Un e-mail va fi trimis la adresa de e-mail administrativă furnizată, cu o copie oarbă de carbon (BCC) trimisă tuturor destinatarilor. Setarea implicită este de a include un maxim de 20 de destinatari într-un astfel de e-mail. Dacă sunt mai mult de 20 de destinatari, e-mailurile suplimentare vor fi trimise. Dacă trimiteți un e-mail unui grup mare de persoane, aveți răbdare după ce vă trimiteți și nu opriți pagina la jumătatea drumului. Este normal ca un e-mail în masă să dureze mult timp. Vei fi notificat când script-ul s-a terminat.',
	'LogMassemail'				=> 'E-mail în masă trimite %1 la grup / utilizator ',
	'MassemailSend'				=> 'Trimitere e-mail în masă',

	'NoEmailMessage'			=> 'Trebuie să introduceți un mesaj.',
	'NoEmailSubject'			=> 'Trebuie să specificați un subiect pentru mesajul dvs.',
	'NoEmailRecipient'			=> 'Trebuie să specificaţi cel puţin un utilizator sau un grup de utilizatori.',

	'MassemailSection'			=> 'E-mail în masă',
	'MessageSubject'			=> 'Subiect:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Mesajul tău:',
	'YourMessageInfo'			=> 'Vă rugăm să reţineţi că puteţi introduce doar plaintext. Toate marcajele vor fi eliminate înainte de a fi trimise.',

	'NoUser'					=> 'Niciun utilizator',
	'NoUserGroup'				=> 'Niciun grup de utilizatori',

	'SendToGroup'				=> 'Trimite la grup:',
	'SendToUser'				=> 'Trimite utilizatorului:',
	'SendToUserInfo'			=> 'Doar utilizatorii care permit administratorilor să îi trimită prin e-mail informații vor primi e-mailuri în masă. Această opțiune este disponibilă în setările lor de utilizator sub notificări.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Mesajul de sistem actualizat',

	'SysMsgSection'				=> 'Mesaj de sistem',
	'SysMsg'					=> 'Mesaj de sistem:',
	'SysMsgInfo'				=> 'Textul tău aici',

	'SysMsgType'				=> 'Tip:',
	'SysMsgTypeInfo'			=> 'Tipul mesajului (CSS).',
	'SysMsgAudience'			=> 'Audienta:',
	'SysMsgAudienceInfo'		=> 'Publicul a arătat mesajul sistemului.',
	'EnableSysMsg'				=> 'Activează mesajul de sistem:',
	'EnableSysMsgInfo'			=> 'Arată mesajul de sistem.',

	// User approval module
	'ApproveNotExists'			=> 'Vă rugăm să selectaţi cel puţin un utilizator prin butonul Setare.',

	'LogUserApproved'			=> 'Utilizator ##%1## aprobat',
	'LogUserBlocked'			=> 'Utilizator ##%1## blocat',
	'LogUserDeleted'			=> 'Utilizator ##%1## eliminat din baza de date',
	'LogUserCreated'			=> 'Creat un utilizator nou ##%1##',
	'LogUserUpdated'			=> 'Utilizator actualizat ##%1##',
	'LogUserPasswordReset'		=> 'Parola pentru utilizator ##%1## resetare cu succes',

	'UserApproveInfo'			=> 'Aproba utilizatori noi înainte de a se putea conecta la site. (Automatic Translation)',
	'Approve'					=> 'Aprobați',
	'Deny'						=> 'Refuză',
	'Pending'					=> 'In asteptare',
	'Approved'					=> 'Aprobat',
	'Denied'					=> 'Refuzat',

	// DB Backup module
	'BackupStructure'			=> 'Structura',
	'BackupData'				=> 'Date',
	'BackupFolder'				=> 'Dosar',
	'BackupTable'				=> 'Tabel',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'Fișiere',
	'BackupNote'				=> 'Notă:',
	'BackupSettings'			=> 'Specificați schema dorită de rezervă.<br>' .
    	'Clusterul rădăcină nu afectează copia de rezervă a fişierelor globale şi a fişierelor de cache (dacă este ales, acestea sunt întotdeauna salvate în întregime).<br>' .  '<br>' .
		'<strong>Atenția</strong>: Pentru a evita pierderea de informații din baza de date atunci când specificați grupul rădăcină, tabelele din această copie de rezervă nu vor fi restructurate, la fel ca atunci când copia de rezervă numai structura tabelelor fără a salva datele. Pentru a face o conversie completă a tabelelor în formatul de rezervă trebuie să faceți o copie de rezervă completă <em> bazei de date (structură și date) fără a specifica clusterul</em>.',
	'BackupCompleted'			=> 'Arhivare și arhivare finalizată.<br>' .
    	'Fișierele pachetului de backup au fost stocate în sub-directorul %1.<br>Pentru a o descărca folosește FTP (întreține structura directorului și numele fișierelor la copiere).<br> Pentru a restaura o copie de rezervă sau a elimina un pachet, accesați <a href="%2">Restaurați baza de date</a>.',
	'LogSavedBackup'			=> 'Baza de date de rezervă salvată ##%1##',
	'Backup'					=> 'Backup',
	'CantReadFile'				=> 'Nu se poate citi fișierul %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Poți restaura oricare din copiile de siguranță găsite sau să le ștergi de pe server.',
	'ConfirmDbRestore'			=> 'Vrei să restaurezi copia de rezervă %1?',
	'ConfirmDbRestoreInfo'		=> 'Te rog așteaptă, acest lucru poate dura ceva timp.',
	'RestoreWrongVersion'		=> 'Versiune WackoWiki greșită!',
	'DirectoryNotExecutable'	=> 'Directorul %1 nu este executabil.',
	'BackupDelete'				=> 'Sunteţi sigur că doriţi să eliminaţi copia de rezervă %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Opțiuni de restaurare suplimentare:',
	'RestoreOptionsInfo'		=> '* Înainte de restaurarea copiei de rezervă <strong>cluster</strong>, ' .
									'tabelele ţintă nu sunt şterse (pentru a preveni pierderea informaţiilor din clusterele care nu au fost salvate). ' .
									'Astfel, în timpul procesului de recuperare vor apărea înregistrări duble. ' .
									'În modul normal, toate vor fi înlocuite cu copia de rezervă a formularului de înregistrare (folosind SQL <code>REPLACE</code>), ' .
									'dar dacă această casetă de selectare este bifată, toate duplicatele sunt omise (valorile curente ale înregistrărilor vor fi păstrate), ' .
									'şi doar înregistrările cu chei noi sunt adăugate în tabel (SQL <code>INSERT IGNORE</code>).<br>' .
									'<strong>Nota</strong>: La restaurarea completă a site-ului, această opțiune nu are nicio valoare.<br>' .
									'<br>' .
									'** Dacă copia de rezervă conține fișiere utilizator (global și perpage, fișiere cache etc.), ' .
									'în mod normal ele înlocuiesc fișierele existente cu aceleași nume și sunt plasate în același director atunci când sunt restaurate. ' .
									'Aceasta optiune iti permite sa salvezi copiile curente ale fisierelor si sa restaurezi dintr-o copie de siguranta doar din fisierele noi (lipsesc pe server).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignoră tastele de tabel duplicate (nu înlocuiți)',
	'IgnoreSameFiles'			=> 'Ignoră aceleași fișiere (fără suprascriere)',
	'NoBackupsAvailable'		=> 'Nu există copii de rezervă disponibile.',
	'BackupEntireSite'			=> 'Întreg site-ul',
	'BackupRestored'			=> 'Copia de rezervă este restaurată, un raport sumar este atașat mai jos. Pentru a șterge acest pachet de rezervă, faceți clic',
	'BackupRemoved'				=> 'Copia de rezervă selectată a fost eliminată cu succes.',
	'LogRemovedBackup'			=> 'Backup pentru baze de date șterse ##%1##',

	'RestoreStarted'			=> 'Restaurare inițiată',
	'RestoreParameters'			=> 'Utilizarea parametrilor',
	'IgnoreDuplicatedKeys'		=> 'Ignoră tastele duplicate',
	'IgnoreDuplicatedFiles'		=> 'Ignoră fișierele duplicate',
	'SavedCluster'				=> 'Grup salvat',
	'DataProtection'			=> 'Protecția datelor - %1 a fost omisă',
	'AssumeDropTable'			=> 'Asumează %1',
	'RestoreSQLiteDatabase'		=> 'Restabilirea bazei de date SQLite',
	'RestoreTableStructure'		=> 'Restabilirea structurii tabelului',
	'RunSqlQueries'				=> 'Efectuați instrucțiuni SQL:',
	'CompletedSqlQueries'		=> 'Instrucţiuni finalizate:',
	'NoTableStructure'			=> 'Structura tabelelor nu a fost salvată - săriți peste',
	'RestoreRecords'			=> 'Restabiliți conținutul tabelelor',
	'ProcessTablesDump'			=> 'Doar descarcă și procesează tabelele de dumping',
	'Instruction'				=> 'Instrucțiuni',
	'RestoredRecords'			=> 'înregistrări:',
	'RecordsRestoreDone'		=> 'Finalizat. Total intrări:',
	'SkippedRecords'			=> 'Datele nu sunt salvate - săriți peste',
	'RestoringFiles'			=> 'Restaurare fișiere',
	'DecompressAndStore'		=> 'Dezarhivaţi şi păstraţi conţinutul directoarelor',
	'HomonymicFiles'			=> 'fişiere omonice',
	'RestoreSkip'				=> 'omite',
	'RestoreReplace'			=> 'inlocuire',
	'RestoreFile'				=> 'Fișier:',
	'RestoredFiles'				=> 'restaurat:',
	'SkippedFiles'				=> 'sărit:',
	'FileRestoreDone'			=> 'Finalizat. Total fişiere:',
	'FilesAll'					=> 'toate:',
	'SkipFiles'					=> 'Fișierele nu sunt stocate - săriți peste',
	'RestoreDone'				=> 'RESTORARE FINALIZATĂ',

	'BackupCreationDate'		=> 'Data creării',
	'BackupPackageContents'		=> 'Conţinutul ambalajului',
	'BackupRestore'				=> 'Restaurează',
	'BackupRemove'				=> 'Elimină',
	'RestoreYes'				=> 'Da',
	'RestoreNo'					=> 'Nr',
	'LogDbRestored'				=> 'Backup ##%1## din baza de date restaurată.',

	'BackupArchived'			=> 'Backup %1 arhivat.',
	'BackupArchiveExists'		=> 'Arhiva de rezervă %1 există deja.',
	'LogBackupArchived'			=> 'Backup ##%1## arhivat.',

	// User module
	'UsersInfo'					=> 'Aici puteţi schimba informaţiile utilizatorilor şi anumite opţiuni specifice.',

	'UsersAdded'				=> 'Utilizator adăugat',
	'UsersDeleteInfo'			=> 'Ștergere utilizator:',
	'EditButton'				=> 'Editare',
	'UsersAddNew'				=> 'Adaugă utilizator nou',
	'UsersDelete'				=> 'Sunteţi sigur că doriţi să ştergeţi utilizatorul %1?',
	'UsersDeleted'				=> 'Utilizatorul %1 a fost șters din baza de date.',
	'UsersRename'				=> 'Redenumește utilizatorul %1 la',
	'UsersRenameInfo'			=> '* Notă: Schimbarea va afecta toate paginile care sunt atribuite acelui utilizator.',
	'UsersUpdated'				=> 'Utilizator actualizat cu succes.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Înscriere',
	'UserActions'				=> 'Acțiuni',
	'NoMatchingUser'			=> 'Niciun utilizator care îndeplinește criteriile',

	'UserAccountNotify'			=> 'Notifică utilizatorul',
	'UserNotifySignup'			=> 'informează utilizatorul despre noul cont',
	'UserVerifyEmail'			=> 'setează simbolul de confirmare a e-mailului și adaugă link-ul pentru verificarea prin e-mail',
	'UserReVerifyEmail'			=> 'Re-trimite e-mail confirmare simbol',

	// Groups module
	'GroupsInfo'				=> 'Din acest panou puteţi administra toate grupurile de utilizatori. Puteţi şterge, crea şi edita grupurile existente. În plus, puteți alege lideri de grup, comutați statutul de grup deschis/ascuns/închis și setați numele grupului și descrierea.',

	'LogMembersUpdated'			=> 'Membrii grupului de utilizatori actualizați',
	'LogMemberAdded'			=> 'Membru adăugat ##%1## la grupul ##%2##',
	'LogMemberRemoved'			=> 'Membru eliminat ##%1## din grupul ##%2##',
	'LogGroupCreated'			=> 'Creat un grup nou ##%1##',
	'LogGroupRenamed'			=> 'Grupul ##%1## redenumit ##%2##',
	'LogGroupRemoved'			=> 'Grup eliminat ##%1##',

	'GroupsMembersFor'			=> 'Membri ai Grupului',
	'GroupsDescription'			=> 'Descriere',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Deschideți',
	'GroupsActive'				=> 'Activ',
	'GroupsTip'					=> 'Click pentru a edita grupul',
	'GroupsUpdated'				=> 'Grupuri actualizate',
	'GroupsAlreadyExists'		=> 'Acest grup există deja.',
	'GroupsAdded'				=> 'Grup adăugat cu succes.',
	'GroupsRenamed'				=> 'Grupul a fost redenumit.',
	'GroupsDeleted'				=> 'Grupul %1 şi toate paginile asociate au fost şterse din baza de date.',
	'GroupsAdd'					=> 'Adaugă un grup nou',
	'GroupsRename'				=> 'Redenumește grupul %1 la',
	'GroupsRenameInfo'			=> '* Notă: Modificarea va afecta toate paginile care sunt atribuite acelui grup.',
	'GroupsDelete'				=> 'Sunteţi sigur că doriţi să ştergeţi grupul %1?',
	'GroupsDeleteInfo'			=> '* Notă: Modificarea va afecta toți membrii care sunt asociați acelui grup.',
	'GroupsIsSystem'			=> 'Grupul %1 aparține sistemului și nu poate fi eliminat.',
	'GroupsStoreButton'			=> 'Salvare grupuri',
	'GroupsEditInfo'			=> 'Pentru a edita lista de grupuri selectaţi butonul radio.',

	'GroupAddMember'			=> 'Adaugă membru',
	'GroupRemoveMember'			=> 'Elimină membru',
	'GroupAddNew'				=> 'Adaugă grup',
	'GroupEdit'					=> 'Editează grup',
	'GroupDelete'				=> 'Elimină grup',

	'MembersAddNew'				=> 'Adaugă un nou membru',
	'MembersAdded'				=> 'Membru nou adăugat cu succes la grup.',
	'MembersRemove'				=> 'Sunteţi sigur că doriţi să ştergeţi membrul %1?',
	'MembersRemoved'			=> 'Membrul a fost înlăturat din grup.',

	// Statistics module
	'DbStatSection'				=> 'Statistici bază de date',
	'DbTable'					=> 'Tabel',
	'DbRecords'					=> 'Înregistrări',
	'DbSize'					=> 'Dimensiune',
	'DbIndex'					=> 'Indice',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'Statistici sistem de fișiere',
	'FileFolder'				=> 'Dosar',
	'FileFiles'					=> 'Fișiere',
	'FileSize'					=> 'Dimensiune',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Informații versiune:',
	'SysParameter'				=> 'Parametru',
	'SysValues'					=> 'Valori',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Ultima actualizare',
	'ServerOS'					=> 'SG',
	'ServerName'				=> 'Nume server',
	'WebServer'					=> 'Server web',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'Baza de date',
	'SqlModesGlobal'			=> 'Moduri SQL globale',
	'SqlModesSession'			=> 'Sesiune Moduri SQL',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memorie',
	'UploadFilesizeMax'			=> 'Mărimea maximă a fișierului',
	'PostMaxSize'				=> 'Dimensiune maximă postare',
	'MaxExecutionTime'			=> 'Timpul maxim de execuție',
	'SessionPath'				=> 'Cale sesiune',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'Compresie GZip',
	'PhpExtensions'				=> 'Extensii PHP',
	'ApacheModules'				=> 'Module Apache',

	// DB repair module
	'DbRepairSection'			=> 'Repară baza de date',
	'DbRepair'					=> 'Repară baza de date',
	'DbRepairInfo'				=> 'Acest script poate căuta automat probleme comune cu baza de date și le poate repara. Repararea poate dura un timp, așa că vă rog să aveți răbdare.',

	'DbOptimizeRepairSection'	=> 'Repară și optimizează baza de date',
	'DbOptimizeRepair'			=> 'Repară și optimizează baza de date',
	'DbOptimizeRepairInfo'		=> 'Acest script poate încerca, de asemenea, să optimizeze baza de date. Acest lucru îmbunătăţeşte performanţa în unele situaţii. Repararea şi optimizarea bazei de date poate dura mult timp, iar baza de date va fi blocată în timpul optimizării.',

	'TableOk'					=> 'Tabelul %1 este în regulă.',
	'TableNotOk'				=> 'Tabelul %1 nu este în regulă. Raportează următoarea eroare: %2. Acest script va încerca să repare acest tabel&hellip;',
	'TableRepaired'				=> 'S-a reparat cu succes tabelul %1.',
	'TableRepairFailed'			=> 'Eșec la repararea tabelului %1 . <br>Eroare: %2',
	'TableAlreadyOptimized'		=> 'Tabelul %1 este deja optimizat.',
	'TableOptimized'			=> 'Tabelul %1 a fost optimizat cu succes.',
	'TableOptimizeFailed'		=> 'Eșuare optimizare tabel %1 . <br>Eroare: %2',
	'TableNotRepaired'			=> 'Unele probleme cu baza de date nu au putut fi reparate.',
	'RepairsComplete'			=> 'Reparații complete',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Arată și repară neconcordanțe, șterge sau atribuie înregistrări orfane unui utilizator / unei valori noi.',
	'Inconsistencies'			=> 'Incoerențe',
	'CheckDatabase'				=> 'Baza de date',
	'CheckDatabaseInfo'			=> 'Verificări pentru incoerențe ale înregistrărilor în baza de date.',
	'CheckFiles'				=> 'Fișiere',
	'CheckFilesInfo'			=> 'Verifică pentru fişierele abandonate, fişierele fără referinţe rămase în tabelul de fişiere.',
	'Records'					=> 'Înregistrări',
	'InconsistenciesNone'		=> 'Nu s-au găsit neconcordanțe de date.',
	'InconsistenciesDone'		=> 'Inconsistențe de date rezolvate.',
	'InconsistenciesRemoved'	=> 'Incoerențe eliminate',
	'Check'						=> 'Verifică',
	'Solve'						=> 'Rezolvă',

	// Bad Behaviour module
	'BbInfo'					=> 'Detectează și blochează accesul nedorit la web, refuză accesul automat al roboților.<br>Pentru mai multe informații, vă rugăm să vizitați pagina de pornire %1.',
	'BbEnable'					=> 'Activează comportamentul necorespunzător:',
	'BbEnableInfo'				=> 'Toate celelalte setări pot fi modificate în folderul de configurare %1.',
	'BbStats'					=> 'Comportamentul necorespunzător a blocat tentativele de acces %1 în ultimele 7 zile.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Jurnal',
	'BbSettings'				=> 'Setări',
	'BbWhitelist'				=> 'Lista albă',

	// --> Log
	'BbHits'					=> 'Accesări',
	'BbRecordsFiltered'			=> 'Se afişează %1 din înregistrările %2 filtrate de',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Blocat',
	'BbPermitted'				=> 'Permis',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Se afişează toate înregistrările %1',
	'BbShow'					=> 'Afișare',
	'BbIpDateStatus'			=> 'IP/Data/statutul',
	'BbHeaders'					=> 'Antete',
	'BbEntity'					=> 'Entitate',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Opțiuni salvate.',
	'BbWhitelistHint'			=> 'Lista inadecvată de whitelisting WILL vă expune la spam, sau vă provoacă un comportament greșit pentru a opri funcționarea în întregime! NU CONTRIBUŢI LISTA ALTĂ decât dacă sunteţi 100% ANUMITOR PE care ar trebui.',
	'BbIpAddress'				=> 'Adresă IP',
	'BbIpAddressInfo'			=> 'Adresa IP sau clasele de adrese în format CIDR care vor fi permise (unul pe linie)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'Fragmente URL care încep cu / după numele de gazdă al site-ului web (unul pe linie)',
	'BbUserAgent'				=> 'Agent utilizator',
	'BbUserAgentInfo'			=> 'Șirurile agentului utilizatorului vor fi permise (câte unul pe rând)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Setări de comportament necorespunzător actualizate',
	'BbLogRequest'				=> 'Cerere HTTP de logare',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (recomandat)',
	'BbLogOff'					=> 'Nu vă logați (nu este recomandat)',
	'BbSecurity'				=> 'Securitate',
	'BbStrict'					=> 'Verificare strictă',
	'BbStrictInfo'				=> 'blochează mai mult spam dar poate bloca unele persoane',
	'BbOffsiteForms'			=> 'Permite postări de formulare de pe alte site-uri web',
	'BbOffsiteFormsInfo'		=> 'necesare pentru OpenID; crește numărul de spam primit',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Pentru a utiliza comportamentul necorespunzător http:BL trebuie să aveţi un %1',
	'BbHttpblKey'				=> 'http:BL Cheie Acces',
	'BbHttpblThreat'			=> 'Nivelul minim de amenințare (25 este recomandat)',
	'BbHttpblMaxage'			=> 'Vârsta maximă a datelor (30 este recomandat)',
	'BbReverseProxy'			=> 'Echilibru Proxy/Load Inversat',
	'BbReverseProxyInfo'		=> 'Dacă folosiți comportament greșit în spatele unui proxy inversat, încărcați balancerul, accelerator HTTP, cache de conținut sau tehnologie similară, activați opțiunea Proxy invers.<br>' .
									'Dacă ai un lanț de două sau mai multe proxy-uri inverse între serverul tău și internetul public, trebuie să specificați <em>toate</em> din intervalele de adrese IP (în format CIDR) ale tuturor serverelor proxy, încărcați balanceri, etc. În caz contrar, este posibil ca comportamentul necorespunzător să nu poată determina adevărata adresă IP a clientului.<br>' .
									'În plus, serverele tale proxy inversate trebuie să seteze adresa IP a clientului de Internet de la care au primit solicitarea într-un header HTTP. Daca nu specificati un antet, va fi folosit %1 . Majoritatea serverelor proxy suportă deja X-Forwarded-Pentru și atunci va trebui doar să vă asigurați că este activat pe serverele proxy. Alte nume de antet în uz comun includ %2 și %3.',
	'BbReverseProxyEnable'		=> 'Activează Proxy Inversare',
	'BbReverseProxyHeader'		=> 'Antet care conține adresa IP a clienților de internet',
	'BbReverseProxyAddresses'	=> 'Adresă IP sau format CIDR pentru serverele proxy (câte unul pe linie)',

];
