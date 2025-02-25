<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Funkcje podstawowe',
		'preferences'	=> 'Ustawienia',
		'content'		=> 'Zawartość',
		'users'			=> 'Użytkownicy',
		'maintenance'	=> 'Konserwacja',
		'messages'		=> 'Wiadomości',
		'extension'		=> 'Rozszerzenie',
		'database'		=> 'Baza danych',
	],

	// Admin panel
	'AdminPanel'				=> 'Panel administracji',
	'RecoveryMode'				=> 'Tryb odzyskiwania',
	'Authorization'				=> 'Autoryzacja',
	'AuthorizationTip'			=> 'Wprowadź hasło administracyjne (upewnij się, że pliki cookie są dozwolone w przeglądarce).',
	'NoRecoveryPassword'		=> 'Hasło administracyjne nie zostało określone!',
	'NoRecoveryPasswordTip'		=> 'Uwaga: Brak hasła administracyjnego stanowi zagrożenie dla bezpieczeństwa! Wprowadź hash hasła w pliku konfiguracyjnym i uruchom program ponownie.',

	'ErrorLoadingModule'		=> 'Błąd ładowania modułu administratora %1: nie istnieje.',

	'ApHomePage'				=> 'Strona domowa',
	'ApHomePageTip'				=> 'Zakończ administrację systemu i otwórz stronę główną',
	'ApLogOut'					=> 'Wyloguj',
	'ApLogOutTip'				=> 'Zakończ administrację systemu i wyloguj się z witryny',

	'TimeLeft'					=> 'Pozostały czas: %1 minut',
	'ApVersion'					=> 'wersja',

	'SiteOpen'					=> 'Otwórz',
	'SiteOpened'				=> 'strona otwarta',
	'SiteOpenedTip'				=> 'Strona jest otwarta',
	'SiteClose'					=> 'Zamknij',
	'SiteClosed'				=> 'strona zamknięta',
	'SiteClosedTip'				=> 'Strona jest zamknięta',

	'System'					=> 'System',

	// Generic
	'Cancel'					=> 'Anuluj',
	'Add'						=> 'Dodaj',
	'Edit'						=> 'Edytuj',
	'Remove'					=> 'Usuń',
	'Enabled'					=> 'Odblokuj',
	'Disabled'					=> 'Zablokuj',
	'Mandatory'					=> 'Obowiązkowe',
	'Admin'						=> 'Administrator',
	'Min'						=> 'Min.',
	'Max'						=> 'Maks.',

	'MiscellaneousSection'		=> 'Różne',
	'MainSection'				=> 'Opcje Ogólne',

	'DirNotWritable'			=> 'Katalog %1 nie jest zapisywalny.',
	'FileNotWritable'			=> 'Plik %1 nie jest zapisywalny.',

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
		'name'		=> 'Podstawowe',
		'title'		=> 'Podstawowe ustawienia',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Wygląd',
		'title'		=> 'Ustawienia Wygląd',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-mail',
		'title'		=> 'Ustawienia E-mail',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Syndykacja',
		'title'		=> 'Ustawienia synchronizacji',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtr',
		'title'		=> 'Ustawienia filtra',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formuła',
		'title'		=> 'Opcje formatowania',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Powiadomienia',
		'title'		=> 'Ustawienia powiadomień',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Strony',
		'title'		=> 'Strony i parametry witryny',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Uprawnienia',
		'title'		=> 'Ustawienia uprawnień',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Bezpieczeństwo',
		'title'		=> 'Ustawienia podsystemów bezpieczeństwa',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'System',
		'title'		=> 'Opcje systemowe',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Wgraj plik',
		'title'		=> 'Ustawienia załącznika',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Usunięto',
		'title'		=> 'Nowo usunięte treści',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Dodawanie, edytowanie lub usuwanie domyślnych elementów menu',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Kopia zapasowa',
		'title'		=> 'Kopia zapasowa danych',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Naprawa',
		'title'		=> 'Napraw i optymalizuj bazę danych',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Przywracanie',
		'title'		=> 'Przywracanie kopii zapasowej',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Menu główne',
		'title'		=> 'WackoWiki Administracja',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Niespójności',
		'title'		=> 'Naprawianie niespójności danych',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Synchronizacja danych',
		'title'		=> 'Synchronizacja danych',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Wiadomość masowa',
		'title'		=> 'Wiadomość masowa',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Wiadomość systemowa',
		'title'		=> 'Wiadomości systemowe',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Informacje o systemie',
		'title'		=> 'Informacje o systemie',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System log',
		'title'		=> 'Dziennik zdarzeń systemowych',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statystyki',
		'title'		=> 'Pokaż statystyki',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Złe zachowanie',
		'title'		=> 'Złe zachowanie',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Zatwierdź',
		'title'		=> 'Zatwierdzenie rejestracji użytkownika',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Grupy',
		'title'		=> 'Zarządzanie grupą',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Użytkownicy',
		'title'		=> 'Zarządzanie użytkownikami',
	],

	// Main module
	'MainNote'					=> 'Uwaga: Zaleca się, aby dostęp do witryny został tymczasowo zablokowany w celu obsługi administracyjnej.',

	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'Wyczyść wszystkie sesje',
	'PurgeSessionsConfirm'		=> 'Czy na pewno chcesz wyczyścić wszystkie sesje? To wyloguje wszystkich użytkowników.',
	'PurgeSessionsExplain'		=> 'Wyczyść wszystkie sesje. Spowoduje to wylogowanie wszystkich użytkowników przez obcięcie tabeli auth_token.',
	'PurgeSessionsDone'			=> 'Sesje pomyślnie wyczyszczone.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Zaktualizowano podstawowe ustawienia',
	'LogBasicSettingsUpdated'	=> 'Zaktualizowano podstawowe ustawienia',

	'SiteName'					=> 'Nazwa witryny:',
	'SiteNameInfo'				=> 'Tytuł tej witryny. Pojawia się na tytule przeglądarki, nagłówku motywu, powiadomieniach e-mail itp.',
	'SiteDesc'					=> 'Opis witryny:',
	'SiteDescInfo'				=> 'Uzupełnij tytuł witryny, która pojawia się w nagłówku stron. Wyjaśnij, w kilku słowach, o czym jest ta witryna.',
	'AdminName'					=> 'Administrator witryny:',
	'AdminNameInfo'				=> 'Nazwa użytkownika osoby, która jest odpowiedzialna za ogólne wsparcie witryny. Ta nazwa nie jest używana do określania praw dostępu, ale pożądane jest, aby odpowiadała nazwie głównego administratora obiektu.',

	'LanguageSection'			=> 'Język',
	'DefaultLanguage'			=> 'Domyślny język:',
	'DefaultLanguageInfo'		=> 'Określa język wiadomości wyświetlanych niezarejestrowanym gościom, jak również ustawienia językowe.',
	'MultiLanguage'				=> 'Obsługa wielu języków:',
	'MultiLanguageInfo'			=> 'Włącz możliwość wyboru języka na stronie po stronie.',
	'AllowedLanguages'			=> 'Dozwolone języki:',
	'AllowedLanguagesInfo'		=> 'Zaleca się, aby wybrać tylko zestaw języków, które chcesz używać, w przeciwnym razie wszystkie języki zostaną wybrane.',

	'CommentSection'			=> 'Komentarze',
	'AllowComments'				=> 'Zezwalaj na komentarze:',
	'AllowCommentsInfo'			=> 'Enable comments for guest or registered users only or disable them on the entire site.',
	'SortingComments'			=> 'Sortowanie komentarzy:',
	'SortingCommentsInfo'		=> 'Zmienia kolejność, w której komentarze strony są prezentowane, albo z najnowszym OR najstarszym komentarzem na górze.',

	'ToolbarSection'			=> 'Pasek narzędzi',
	'CommentsPanel'				=> 'Panel komentarzy:',
	'CommentsPanelInfo'			=> 'Domyślne wyświetlanie komentarzy na dole strony.',
	'FilePanel'					=> 'Panel plików:',
	'FilePanelInfo'				=> 'Domyślny wyświetlanie załączników na dole strony.',
	'TagsPanel'					=> 'Panel tagów:',
	'TagsPanelInfo'				=> 'Domyślny wyświetlanie panelu tagów u dołu strony.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Pokaż permalink:',
	'ShowPermalinkInfo'			=> 'Domyślny wyświetlacz permalink dla bieżącej wersji strony.',
	'TocPanel'					=> 'Spis panelu zawartości:',
	'TocPanelInfo'				=> 'Domyślny spis wyświetlany w panelu zawartości strony (może wymagać wsparcia w szablonach).',
	'SectionsPanel'				=> 'Panel sekcji:',
	'SectionsPanelInfo'			=> 'Domyślnie wyświetlaj panel sąsiadujących stron (wymaga wsparcia w szablonach).',
	'DisplayingSections'		=> 'Wyświetlanie sekcji:',
	'DisplayingSectionsInfo'	=> 'Kiedy poprzednie opcje są ustawione, czy wyświetlić tylko podstrony strony (<em>niższego</em>), tylko sąsiad (<em>top</em>), oba lub inne (<em>drzewo</em>).',
	'MenuItems'					=> 'Elementy menu:',
	'MenuItemsInfo'				=> 'Domyślna liczba wyświetlanych pozycji menu (może wymagać wsparcia w szablonach).',

	'HandlerSection'			=> 'Handler',
	'HideRevisions'				=> 'Ukryj wersje:',
	'HideRevisionsInfo'			=> 'Domyślne wyświetlanie zmian strony.',
	'AttachmentHandler'			=> 'Włącz obsługę załączników:',
	'AttachmentHandlerInfo'		=> 'Zezwala na wyświetlanie uchwytu załączników.',
	'SourceHandler'				=> 'Włącz obsługę źródła:',
	'SourceHandlerInfo'			=> 'Zezwala na wyświetlanie obsługi źródła.',
	'ExportHandler'				=> 'Włącz obsługę eksportu XML:',
	'ExportHandlerInfo'			=> 'Zezwala na wyświetlanie obsługi eksportu XML.',

	'DiffModeSection'			=> 'Tryby różnicowe',
	'DefaultDiffModeSetting'	=> 'Domyślny tryb różnicowy:',
	'DefaultDiffModeSettingInfo'=> 'Wstępnie wybrany tryb różnicowy.',
	'AllowedDiffMode'			=> 'Dozwolone tryby diff:',
	'AllowedDiffModeInfo'		=> 'Zalecane jest wybranie tylko zestawu trybów różnicowych, których chcesz użyć, w przeciwnym razie wybrane zostaną wszystkie tryby różnicowe.',
	'NotifyDiffMode'			=> 'Powiadom tryb różnicowy:',
	'NotifyDiffModeInfo'		=> 'Tryb różnicowy używany do powiadomień w treści wiadomości e-mail.',

	'EditingSection'			=> 'Edytowanie',
	'EditSummary'				=> 'Opis zmian:',
	'EditSummaryInfo'			=> 'Pokazuje podsumowanie zmian w trybie edycji.',
	'MinorEdit'					=> 'Drobna zmiana:',
	'MinorEditInfo'				=> 'Włącza opcję edycji w trybie edycji.',
	'SectionEdit'				=> 'Edycja sekcji:',
	'SectionEditInfo'			=> 'Umożliwia edycję tylko fragmentu strony.',
	'ReviewSettings'			=> 'Przegląd:',
	'ReviewSettingsInfo'		=> 'Włącza opcję przeglądu w trybie edycji.',
	'PublishAnonymously'		=> 'Zezwalaj na anonimowe publikowanie:',
	'PublishAnonymouslyInfo'	=> 'Zezwalaj użytkownikom na anonimowe publikowanie (aby ukryć nazwę).',

	'DefaultRenameRedirect'		=> 'Podczas zmiany nazwy, utwórz przekierowanie:',
	'DefaultRenameRedirectInfo'	=> 'Domyślnie oferta ustawiania przekierowania do starego adresu strony, której nazwa zostanie zmieniona.',
	'StoreDeletedPages'			=> 'Zachowaj usunięte strony:',
	'StoreDeletedPagesInfo'		=> 'Kiedy usuniesz stronę, komentarz lub plik, zachowaj go w specjalnej sekcji, gdzie będzie on dostępny do przeglądu i odzyskania przez pewien okres (jak opisano poniżej).',
	'KeepDeletedTime'			=> 'Czas przechowywania usuniętych stron:',
	'KeepDeletedTimeInfo'		=> 'Okres w dniach. Ma to sens tylko w przypadku poprzedniej opcji. Użyj zera, aby upewnić się, że jednostki nigdy nie są usuwane (w tym przypadku administrator może ręcznie wyczyścić "koszyka").',
	'PagesPurgeTime'			=> 'Czas przechowywania wersji strony:',
	'PagesPurgeTimeInfo'		=> 'Automatycznie usuwa starsze wersje w podanej liczbie dni. Jeśli wprowadzisz zero, starsze wersje nie zostaną usunięte.',
	'EnableReferrers'			=> 'Włącz polecających:',
	'EnableReferrersInfo'		=> 'Umożliwia tworzenie i wyświetlanie zewnętrznych odsyłaczy.',
	'ReferrersPurgeTime'		=> 'Czas przechowywania zleceniodawców:',
	'ReferrersPurgeTimeInfo'	=> 'Przechowuj historię odsyłania stron zewnętrznych nie dłużej niż przez określoną liczbę dni. Zero oznacza wieczne przechowywanie, ale dla aktywnie odwiedzanej strony może to prowadzić do przepełnienia bazy danych.',
	'EnableCounters'			=> 'Liczniki trafień:',
	'EnableCountersInfo'		=> 'Pozwala na liczniki uderzeń na stronę i umożliwia wyświetlanie prostych statystyk. Widoki właściciela strony nie są liczone.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Kontroluj domyślne ustawienia synchronizacji dla swojej witryny.',
	'SyndicationSettingsUpdated'	=> 'Zaktualizowano ustawienia synchronizacji.',

	'FeedsSection'				=> 'Kanały',
	'EnableFeeds'				=> 'Włącz kanały:',
	'EnableFeedsInfo'			=> 'Włącza lub wyłącza zasilanie RSS dla całej wiki.',
	'XmlChangeLink'				=> 'Zmień tryb łącza kanału:',
	'XmlChangeLinkInfo'			=> 'Określa gdzie XML zmienia odnośniki do elementów kanału XML.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'różnice',
		'2'		=> 'aktualna strona',
		'3'		=> 'lista zmian',
		'4'		=> 'zmodyfikowana strona',
	],

	'XmlSitemap'				=> 'XML Sitemap:',
	'XmlSitemapInfo'			=> 'Tworzy plik XML o nazwie %1 wewnątrz folderu xml. Możesz dodać ścieżkę do mapy strony w pliku robots.txt w katalogu głównym w następujący sposób:',
	'XmlSitemapGz'				=> 'Kompresja mapy strony XML:',
	'XmlSitemapGzInfo'			=> 'Jeśli chcesz, możesz skompresować swój plik tekstowy mapy strony za pomocą gzip, aby zmniejszyć wymaganą przepustowość.',
	'XmlSitemapTime'			=> 'Czas generowania mapy strony XML:',
	'XmlSitemapTimeInfo'		=> 'Generuje mapę Sitemap tylko raz w danej liczbie dni, zero oznacza na każdej zmianie strony.',

	'SearchSection'				=> 'Znajdź',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Tworzy plik opisu OpenSearch w katalogu XML i włącza Autodiscovery pluginu wyszukiwania w nagłówku HTML.',
	'SearchEngineVisibility'	=> 'Blokuj wyszukiwarki (widoczność wyszukiwarki):',
	'SearchEngineVisibilityInfo'=> 'Blokuj wyszukiwarki, ale zezwalaj na zwykłych odwiedzających. Nadpisuje ustawienia strony. <br>Odznacz wyszukiwarki od indeksowania tej witryny. Do wyszukiwarki należy honorowanie tego żądania.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Kontroluj domyślne ustawienia wyświetlania dla twojej witryny.',
	'AppearanceSettingsUpdated'	=> 'Zaktualizowane ustawienia wyglądu.',

	'LogoOff'					=> 'Wyłączony',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo i tytuł',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Logo strony:',
	'SiteLogoInfo'				=> 'Twoje logo pojawi się zazwyczaj w lewym górnym rogu aplikacji. Maksymalny rozmiar to 2 miB. Optymalne wymiary to 255 pikseli o szerokości 55 pikseli wysokości.',
	'LogoDimensions'			=> 'Wymiary logo:',
	'LogoDimensionsInfo'		=> 'Szerokość i wysokość wyświetlanego logo.',
	'LogoDisplayMode'			=> 'Tryb wyświetlania logo',
	'LogoDisplayModeInfo'		=> 'Określa wygląd logo. Domyślne jest wyłączone.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site Favicon:',
	'SiteFaviconInfo'			=> 'Twoja ikona skrótu lub favicon, jest wyświetlana w pasku adresu, zakładkach i zakładkach większości przeglądarek. Zastąpi to favicon Twojego motywu.',
	'SiteFaviconTooBig'			=> 'Favicon jest większy niż 64 × 64px.',
	'ThemeColor'				=> 'Kolor motywu dla paska adresu:',
	'ThemeColorInfo'			=> 'Przeglądarka ustawi kolor paska adresu każdej strony zgodnie z podanym kolorem CSS.',

	'LayoutSection'				=> 'Układ',
	'Theme'						=> 'Motyw:',
	'ThemeInfo'					=> 'Szablon domyślnie używany przez witrynę.',
	'ResetUserTheme'			=> 'Zresetuj wszystkie motywy użytkownika:',
	'ResetUserThemeInfo'		=> 'Resetuje wszystkie motywy użytkowników. Ostrzeżenie: Ta akcja przywróci wszystkie wybrane przez użytkownika motywy do globalnego domyślnego motywu.',
	'SetBackUserTheme'			=> 'Przywróć wszystkie motywy użytkownika do motywu %1.',
	'ThemesAllowed'				=> 'Dozwolone motywy:',
	'ThemesAllowedInfo'			=> 'Wybierz dozwolone motywy, które użytkownik może wybrać; w przeciwnym razie wszystkie dostępne motywy są dozwolone.',
	'ThemesPerPage'				=> 'Motywy na stronę:',
	'ThemesPerPageInfo'			=> 'Zezwalaj na szablony na stronę, którą właściciel strony może wybrać poprzez właściwości strony.',

	// System settings
	'SystemSettingsInfo'		=> 'Grupa parametrów odpowiedzialnych za dostrojenie witryny. Nie zmieniaj ich, chyba że masz pewność co do ich działań.',
	'SystemSettingsUpdated'		=> 'Zaktualizowane ustawienia systemowe',

	'DebugModeSection'			=> 'Tryb debugowania',
	'DebugMode'					=> 'Tryb debugowania:',
	'DebugModeInfo'				=> 'Wyodrębnianie i wysyłanie danych telemetrycznych o czasie wykonania aplikacji. Uwaga: Tryb pełnej szczegółowości nakłada większe wymagania na przydzieloną pamięć, zwłaszcza w przypadku operacji wymagających dużych nakładów zasobów, takich jak kopia zapasowa i przywracanie bazy danych.',
	'DebugModes'	=> [
		'0'		=> 'debugowanie jest wyłączone',
		'1'		=> 'tylko całkowity czas wykonania',
		'2'		=> 'pełny etat',
		'3'		=> 'pełne dane (DBMS, pamięć podręczna itp.)',
	],
	'DebugSqlThreshold'			=> 'Próg wydajności RDBMS:',
	'DebugSqlThresholdInfo'		=> 'W szczegółowym trybie debugowania, zgłoś tylko zapytania, które trwają dłużej niż określona liczba sekund.',
	'DebugAdminOnly'			=> 'Zamknięta diagnoza:',
	'DebugAdminOnlyInfo'		=> 'Pokaż dane debugowania programu (i DBMS) tylko dla administratora.',

	'CachingSection'			=> 'Opcje pamięci podręcznej',
	'Cache'						=> 'Pamięć podręczna renderowanych stron:',
	'CacheInfo'					=> 'Zapisz renderowane strony w lokalnej skrytce, aby przyspieszyć uruchamianie. Ważne tylko dla niezarejestrowanych odwiedzających.',
	'CacheTtl'					=> 'Term relevance cached pages:',
	'CacheTtlInfo'				=> 'Strony pamięci podręcznej nie więcej niż określoną liczbę sekund.',
	'CacheSql'					=> 'Zapytania Cache DBMS:',
	'CacheSqlInfo'				=> 'Utrzymuj lokalną pamięć podręczną wyników niektórych zapytań SQL związanych z zasobami.',
	'CacheSqlTtl'				=> 'Czas na żywo dla zapytań SQL:',
	'CacheSqlTtlInfo'			=> 'Wyniki pamięci podręcznej zapytań SQL przez nie więcej niż określoną liczbę sekund. Wartości większe niż 1200 nie są pożądane.',

	'LogSection'				=> 'Ustawienia dziennika',
	'LogLevelUsage'				=> 'Użyj rejestrowania:',
	'LogLevelUsageInfo'			=> 'Minimalny priorytet zdarzeń zarejestrowanych w logu.',
	'LogThresholds'	=> [
		'0'		=> 'nie przechowuj dziennika',
		'1'		=> 'tylko poziom krytyczny',
		'2'		=> 'z najwyższego poziomu',
		'3'		=> 'z wysoka',
		'4'		=> 'średnio',
		'5'		=> 'z niskiego',
		'6'		=> 'minimalny poziom',
		'7'		=> 'zapisz wszystko',
	],
	'LogDefaultShow'			=> 'Wyświetl tryb dziennika:',
	'LogDefaultShowInfo'		=> 'Domyślnie minimalne zdarzenia priorytetowe wyświetlane w dzienniku.',
	'LogModes'	=> [
		'1'		=> 'tylko poziom krytyczny',
		'2'		=> 'z najwyższego poziomu',
		'3'		=> 'z wysokiego poziomu',
		'4'		=> 'średnia',
		'5'		=> 'z niskiego',
		'6'		=> 'od minimalnego poziomu',
		'7'		=> 'pokaż wszystkie',
	],
	'LogPurgeTime'				=> 'Czas przechowywania dziennika:',
	'LogPurgeTimeInfo'			=> 'Usuń dziennik zdarzeń po określonej liczbie dni.',

	'PrivacySection'			=> 'Prywatność',
	'AnonymizeIp'				=> 'Anonimowe adresy IP użytkowników:',
	'AnonymizeIpInfo'			=> 'Anonimizuj adresy IP tam, gdzie ma to zastosowanie (np. strona, wersja lub odsyłacze).',

	'ReverseProxySection'		=> 'Odwrotne proxy',
	'ReverseProxy'				=> 'Użyj odwrotnego proxy:',
    'ReverseProxyInfo'			=> 
    'Włącz to ustawienie, aby określić prawidłowy adres IP zdalnego klienta, analizując informacje z
									apisane w nagłówkach X-Forwarded-For. Nagłówki X-Forwarded-For są standardowym mechanizmem
									identyfikacji systemów klienckich łączących się przez odwrotny serwer proxy, taki jak Squid lub Pound.
									Odwrócone serwery proxy są często używane w celu zwiększenia wydajności często odwiedzanych witryn,
									a także w celu zapewnienia innych korzyści związanych z buforowaniem, bezpieczeństwem lub szyfrowaniem.
									Jeśli instalacja WackoWiki działa za pośrednictwem serwera proxy, ustawienie to powinno być włączone,
									aby poprawne informacje o adresie IP były przechwytywane przez systemy zarządzania sesjami,
									logowania, statystyk i zarządzania dostępem w WackoWiki; jeśli nie masz pewności co do tego ustawienia,
									nie masz serwera proxy lub WackoWiki działa w środowisku hostingu współdzielonego,
									ustawienie to powinno pozostać wyłączone.',
	'ReverseProxyHeader'		=> 'Odwrócony nagłówek proxy:',
	'ReverseProxyHeaderInfo'	=> 'Ustaw tę wartość, jeśli Twój serwer proxy wysyła IP klienta w nagłówku innym
									niż X-Forwarded-For. Nagłówek "X-Forwarded-For" to lista adresów IP oddzielonych
									przecinkami i spacjami, z których tylko ostatni (najbardziej wysunięty w lewo) będzie używany.',
	'ReverseProxyAddresses'		=> 'reverse_proxy akceptuje tablicę adresów IP:',
	'ReverseProxyAddressesInfo'	=> 'Każdy element tej tablicy to adres IP dowolnego z twoich odwracalnych serwerów
									 proxy. Jeżeli używasz tej tablicy, WackoWiki będzie ufać informacjom przechowywanym
									 w nagłówkach X-Forwarded-For tylko wtedy, gdy zdalny adres IP jest jednym z
									 tych nagłówków, co oznacza, że żądanie dociera do serwera internetowego z jednego z twoich
									 W przeciwnym razie klient mógłby bezpośrednio połączyć się z
									 twoim serwerem internetowym poprzez nakrapianie nagłówków X-Forwarded-For.',

	'SessionSection'				=> 'Obsługa sesji',
	'SessionStorage'				=> 'Przechowywanie sesji:',
	'SessionStorageInfo'			=> 'Ta opcja definiuje gdzie przechowywane są dane sesji. Domyślnie wybrana jest sesja pliku lub bazy danych.',
	'SessionModes'	=> [
		'1'		=> 'Plik',
		'2'		=> 'Baza danych',
	],
	'SessionNotice'					=> 'Pokaż przyczynę zakończenia sesji:',
	'SessionNoticeInfo'				=> 'Wskazuje przyczynę zakończenia sesji.',
	'LoginNotice'					=> 'Powiadomienie o logowaniu:',
	'LoginNoticeInfo'				=> 'Wyświetla powiadomienie o logowaniu.',

	'RewriteMode'					=> 'Użyj <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Jeśli serwer internetowy obsługuje tę funkcję, włącz ją, aby "upiększyć" adresy URL stron.<br>
										<span class="cite">Wartość
 może zostać nadpisana przez klasę Settings w czasie wykonywania, 
niezależnie od tego, czy jest wyłączona, jeśli HTTP_MOD_REWRITE jest włączony.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parametry odpowiedzialne za kontrolę dostępu i uprawnienia.',
	'PermissionsSettingsUpdated'	=> 'Zaktualizowane ustawienia uprawnień',

	'PermissionsSection'		=> 'Prawa i przywileje',
	'ReadRights'				=> 'Domyślnie odczytywane prawa:',
	'ReadRightsInfo'			=> 'Domyślnie przypisany do utworzonych stron głównych, jak również stron, dla których nie można zdefiniować nadrzędnych ACL.',
	'WriteRights'				=> 'Domyślnie prawa do zapisu:',
	'WriteRightsInfo'			=> 'Domyślnie przypisany do utworzonych stron głównych, jak również stron, dla których nie można zdefiniować nadrzędnych ACL.',
	'CommentRights'				=> 'Domyślnie prawa komentarza:',
	'CommentRightsInfo'			=> 'Domyślnie przypisany do utworzonych stron głównych, jak również stron, dla których nie można zdefiniować nadrzędnych ACL.',
	'CreateRights'				=> 'Utwórz prawa podstrony domyślnie:',
	'CreateRightsInfo'			=> 'Domyślnie przypisane do utworzonych podstron.',
	'UploadRights'				=> 'Domyślnie praw wgrywania:',
	'UploadRightsInfo'			=> 'Domyślne prawa do przesyłania.',
	'RenameRights'				=> 'Globalna zmiana nazwy:',
	'RenameRightsInfo'			=> 'Lista uprawnień do swobodnej zmiany nazwy (move) stron.',

	'LockAcl'					=> 'Zablokuj wszystkie ACL, aby czytać tylko:',
	'LockAclInfo'				=> '<span class="cite">Nadpisuje ustawienia ACL dla wszystkich stron tylko do odczytu.</span><br>To może być przydatne po zakończeniu projektu, chcesz zamknąć edycję przez pewien okres czasu ze względów bezpieczeństwa lub jako reakcja kryzysowa w celu wykorzystania lub podatności na zagrożenia.',
	'HideLocked'				=> 'Ukryj niedostępne strony:',
	'HideLockedInfo'			=> 'Jeśli użytkownik nie ma uprawnień do odczytu strony, ukryj go w różnych listach stron (jednakże link umieszczony w tekście będzie nadal widoczny).',
	'RemoveOnlyAdmins'			=> 'Tylko administratorzy mogą usuwać strony:',
	'RemoveOnlyAdminsInfo'		=> 'Odmów wszystkim, z wyjątkiem administratorów, możliwość usuwania stron. Pierwszy limit dotyczy właścicieli zwykłych stron.',
	'OwnersRemoveComments'		=> 'Właściciele stron mogą usuwać komentarze:',
	'OwnersRemoveCommentsInfo'	=> 'Pozwól właścicielom stron na moderowanie komentarzy na ich stronach.',
	'OwnersEditCategories'		=> 'Właściciele mogą edytować kategorie stron:',
	'OwnersEditCategoriesInfo'	=> 'Pozwól właścicielom modyfikować listę kategorii stron Twojej witryny (dodaj słowa, usuń słowa), przypisuje do strony.',
	'TermHumanModeration'		=> 'Ważność moderacji człowieka:',
	'TermHumanModerationInfo'	=> 'Moderatorzy mogą edytować komentarze tylko wtedy, gdy zostały one utworzone nie więcej niż przed tą liczbą dni (to ograniczenie nie dotyczy ostatniego komentarza w temacie).',

	'UserCanDeleteAccount'		=> 'Użytkownicy mogą usuwać swoje konta',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parametry odpowiedzialne za ogólne bezpieczeństwo peronu, ograniczenia w zakresie bezpieczeństwa i dodatkowe podsystemy.',
	'SecuritySettingsUpdated'	=> 'Zaktualizowane ustawienia bezpieczeństwa',

	'AllowRegistration'			=> 'Zarejestruj się online:',
	'AllowRegistrationInfo'		=> 'Otwórz rejestrację użytkownika. Wyłączenie tej opcji uniemożliwi bezpłatną rejestrację, jednak administrator strony będzie mógł sam zarejestrować innych użytkowników.',
	'ApproveNewUser'			=> 'Zatwierdź nowych użytkowników:',
	'ApproveNewUserInfo'		=> 'Pozwala administratorom na zatwierdzanie użytkowników po rejestracji. Tylko zatwierdzeni użytkownicy będą mogli zalogować się do witryny.',
	'PersistentCookies'			=> 'Trwałe ciasteczka:',
	'PersistentCookiesInfo'		=> 'Zezwalaj na trwałe ciasteczka.',
	'DisableWikiName'			=> 'Wyłącz WikiName:',
	'DisableWikiNameInfo'		=> 'Wyłącz obowiązkowe używanie WikiName dla użytkowników. Zezwala na rejestrację użytkownika tradycyjnymi nickami zamiast wymuszonych nazw sformatowanych CamelCase (tj. NazwaNazwa).',
	'UsernameLength'			=> 'Długość nazwy użytkownika:',
	'UsernameLengthInfo'		=> 'Minimalna i maksymalna liczba znaków w nazwach użytkowników.',

	'EmailSection'				=> 'E-mail',
	'AllowEmailReuse'			=> 'Zezwalaj na ponowne użycie adresu e-mail:',
	'AllowEmailReuseInfo'		=> 'Inni użytkownicy mogą się zarejestrować za pomocą tego samego adresu e-mail.',
	'EmailConfirmation'			=> 'Wymuś potwierdzenie e-mail:',
	'EmailConfirmationInfo'		=> 'Wymaga, aby użytkownik zweryfikował swój adres e-mail, zanim będzie mógł się zalogować.',
	'AllowedEmailDomains'		=> 'Dozwolone domeny e-mail:',
	'AllowedEmailDomainsInfo'	=> 'Dozwolone domeny e-mail oddzielone przecinkami, np. <code>example.com, local.lan</code> itd., w przeciwnym razie wszystkie domeny e-mail są dozwolone.',
	'ForbiddenEmailDomains'		=> 'Zabronione domeny e-mail:',
	'ForbiddenEmailDomainsInfo'	=> 'Zakazane domeny e-mail oddzielone przecinkami, np. <code>example.com, local.lan</code> itp. (działa tylko wtedy, gdy lista dozwolonych domen e-mail jest pusta)',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Włącz Captcha:',
	'EnableCaptchaInfo'			=> 'Jeśli włączone, captcha będzie wyświetlany w następujących przypadkach lub jeśli próg bezpieczeństwa zostanie osiągnięty.',
	'CaptchaComment'			=> 'Nowy komentarz:',
	'CaptchaCommentInfo'		=> 'Jako zabezpieczenie przed spamem, niezarejestrowani użytkownicy muszą uzupełnić captcha przed dodaniem komentarza.',
	'CaptchaPage'				=> 'Nowa strona:',
	'CaptchaPageInfo'			=> 'Jako ochrona przed spamem, niezarejestrowani użytkownicy muszą ukończyć captcha przed utworzeniem nowej strony.',
	'CaptchaEdit'				=> 'Edytuj stronę:',
	'CaptchaEditInfo'			=> 'Jako ochronę przed spamem, niezarejestrowani użytkownicy muszą ukończyć captcha przed edycją stron.',
	'CaptchaRegistration'		=> 'Rejestracja:',
	'CaptchaRegistrationInfo'	=> 'Jako zabezpieczenie przed spamem, niezarejestrowani użytkownicy muszą ukończyć captcha przed rejestracją.',

	'TlsSection'				=> 'Ustawienia TLS',
	'TlsConnection'				=> 'Połączenie TLS:',
	'TlsConnectionInfo'			=> 'Użyj połączenia zabezpieczonego TLS. <span class="cite">Aktywuj wymagany preinstalowany certyfikat TLS na serwerze, w przeciwnym razie utracisz dostęp do panelu administracyjnego!</span><br>Określa również, czy ustawiona jest bezpieczna flaga Cookie Secure: Flaga <code>bezpieczna</code> określa, czy ciasteczka powinny być wysyłane tylko przez bezpieczne połączenia.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Wymuszone ponowne podłączenie klienta z HTTP do HTTPS. Z wyłączoną opcją klient może przeglądać stronę przez otwarty kanał HTTP.',

	'HttpSecurityHeaders'		=> 'Nagłówki zabezpieczeń HTTP',
	'EnableSecurityHeaders'		=> 'Enable Security Headers:',
	'EnableSecurityHeadersinfo'	=> 'Ustaw nagłówki zabezpieczeń (budzenie ramki, ochrona kliknięć/XSS/CSRF). <br>CSP może powodować problemy w niektórych sytuacjach (np. podczas rozwoju) lub w przypadku korzystania z wtyczek opartych na zasobach przechowywanych zewnętrznie, takich jak obrazy lub skrypty. <br>Wyłączenie polityki bezpieczeństwa treści jest zagrożeniem dla bezpieczeństwa!',
	'Csp'						=> 'Content-Security-Policy (CSP):',
	'CspInfo'					=> 'Konfigurowanie CSP wymaga decydowania o tym, jaką politykę chcesz wyegzekwować, a następnie konfigurowania i użycia Content-Security-Policy do ustanowienia swojej polityki.',
	'PolicyModes'	=> [
		'0'		=> 'zablokuj',
		'1'		=> 'ścisły',
		'2'		=> 'niestandardowy',
	],
	'PermissionsPolicy'			=> 'Permissions Policy:',
	'PermissionsPolicyInfo'		=> 'Nagłówek HTTP Permissions-Policy udostępnia mechanizm wyraźnego włączania lub wyłączania różnych zaawansowanych funkcji przeglądarki.',
	'ReferrerPolicy'			=> 'Referrer Policy:',
	'ReferrerPolicyInfo'		=> 'Nagłówek HTTP „Referrer-Policy HTTP” reguluje, które informacje o odsyłaniu przesyłane w nagłówku „Referer powinien być dołączony do odpowiedzi”.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'bez odsyłacza',
		'2'		=> 'brak odsyłacza - when-downgrade',
		'3'		=> 'identyczne pochodzenie',
		'4'		=> 'początek',
		'5'		=> 'pochodzenia ścisłego',
		'6'		=> 'pochodzenie-gdzie-krzyżownica',
		'7'		=> 'surowe-pochodzenie-gdzie-krzyżowe',
		'8'		=> 'niebezpieczny url'
	],

	'UserPasswordSection'		=> 'Trwałość haseł użytkownika',
	'PwdMinChars'				=> 'Minimalna długość hasła:',
	'PwdMinCharsInfo'			=> 'Dłuższe hasła są koniecznie bezpieczniejsze niż hasła krótsze (np. 12 do 16 znaków).<br>Zachęca się do używania haseł zamiast haseł.',
	'AdminPwdMinChars'			=> 'Minimalna długość hasła administratora:',
	'AdminPwdMinCharsInfo'		=> 'Dłuższe hasła są koniecznie bezpieczniejsze niż hasła krótsze (np. od 15 do 20 znaków).<br>Zachęca się do stosowania haseł zamiast haseł.',
	'PwdCharComplexity'			=> 'Wymagana złożoność hasła:',
	'PwdCharClasses'	=> [
		'0'		=> 'nie przetestowano',
		'1'		=> 'dowolne litery + cyfry',
		'2'		=> 'wielkie i małe litery + cyfry',
		'3'		=> 'wielkie i małe litery + cyfry + znaki',
	],
	'PwdUnlikeLogin'			=> 'Dodatkowe powikłania:',
	'PwdUnlikes'	=> [
		'0'		=> 'nie przetestowano',
		'1'		=> 'hasło nie jest identyczne z loginem',
		'2'		=> 'hasło nie zawiera nazwy użytkownika',
	],

	'LoginSection'				=> 'Zaloguj się',
	'MaxLoginAttempts'			=> 'Maksymalna liczba prób logowania na nazwę użytkownika:',
	'MaxLoginAttemptsInfo'		=> 'Liczba prób logowania dozwolonych na jednym koncie przed uruchomieniem zadania antyspambota. Wprowadź 0, aby zapobiec wyzwalaniu zadania antyspambota dla różnych kont użytkowników.',
	'IpLoginLimitMax'			=> 'Maksymalna liczba prób logowania na adres IP:',
	'IpLoginLimitMaxInfo'		=> 'Próg prób logowania dozwolony z pojedynczego adresu IP przed uruchomieniem zadania antyspambota. Wprowadź 0, aby zapobiec wywołaniu zadania antyspambot przez adresy IP.',

	'FormsSection'				=> 'Formularze',
	'FormTokenTime'				=> 'Maksymalny czas składania formularzy:',
	'FormTokenTimeInfo'			=> 'Czas, w którym użytkownik musi przesłać formularz (w sekundach).<br> Należy pamiętać, że formularz może stać się nieważny po zakończeniu sesji, niezależnie od tego ustawienia.',

	'SessionLength'				=> 'Ciasteczka sesji wygasa:',
	'SessionLengthInfo'			=> 'Domyślnie czas życia ciasteczka sesji użytkownika (w dniach).',
	'CommentDelay'				=> 'Przeciwdziałanie powodziom dla komentarzy:',
	'CommentDelayInfo'			=> 'Minimalne opóźnienie pomiędzy publikacją komentarzy nowych użytkowników (w sekundach).',
	'IntercomDelay'				=> 'Zapobieganie powodziom w komunikacji osobistej:',
	'IntercomDelayInfo'			=> 'Minimalne opóźnienie pomiędzy wysyłaniem prywatnych wiadomości (w sekundach).',
	'RegistrationDelay'			=> 'Próg czasowy rejestracji:',
	'RegistrationDelayInfo'		=> 'Minimalny próg czasowy między zgłoszeniami formularza rejestracyjnego aby zniechęcić boty rejestracyjne (w sekundach).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'FormatterSettingsUpdated'	=> 'Zaktualizowano ustawienia formatowania',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> 'Korektor typograficzny:',
	'TypograficaInfo'			=> 'Wyłączenie tej opcji przyspieszy proces dodawania komentarzy i zapisywania stron.',
	'Paragrafica'				=> 'Oznakowanie paragrafica:',
	'ParagraficaInfo'			=> 'Podobnie jak w przypadku poprzedniej opcji, ale doprowadzi to do odłączenia niedziałającego automatycznego spisu treści (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Globalne wsparcie HTML:',
	'AllowRawhtmlInfo'			=> 'Ta opcja może być niebezpieczna dla otwartej witryny.',
	'SafeHtml'					=> 'Filtrowanie HTML:',
	'SafeHtmlInfo'				=> 'Zapobiega zapisywaniu niebezpiecznych obiektów HTML. Wyłączenie filtru na otwartej stronie z obsługą HTML to <span class="underline">wyjątkowo</span> niepożądane!',

	'WackoFormatterSection'		=> 'Forma tekstowa Wiki (Wacko Formatter)',
	'X11colors'					=> 'Użycie kolorów X11:',
	'X11colorsInfo'				=> 'Rozszerza dostępne kolory dla <code>??(kolor) tła??</code> i <code>!!(kolor) tekst!</code>Wyłączenie tej opcji przyspiesza procesy dodawania komentarzy i zapisywania stron.',
	'WikiLinks'					=> 'Wyłącz linki wiki:',
	'WikiLinksInfo'				=> 'Wyłącza łączenie dla <code>CamelCaseWords</code>: Twoje słowa CamelCase nie będą już bezpośrednio powiązane z nową stroną. Jest to przydatne, gdy pracujesz w różnych przedziałach nazw/klastrach. Domyślnie jest wyłączone.',
	'BracketsLinks'				=> 'Wyłącz nawiasowane linki:',
	'BracketsLinksInfo'			=> 'Wyłącza składnię <code>[[link]]</code> i <code>((link))</code>',
	'Formatters'				=> 'Wyłącz formatyki:',
	'FormattersInfo'			=> 'Wyłącza składnię <code>%%code%%</code> , używaną do podświetleń.',

	'DateFormatsSection'		=> 'Formaty daty',
	'DateFormat'				=> 'Format daty:',
	'DateFormatInfo'			=> '(dzień, miesiąc, rok)',
	'TimeFormat'				=> 'Format czasu:',
	'TimeFormatInfo'			=> '(godzina, minuta)',
	'TimeFormatSeconds'			=> 'Format dokładnego czasu:',
	'TimeFormatSecondsInfo'		=> '(godziny, minuty, sekundy)',
	'NameDateMacro'				=> 'Format <code>::@::</code> makro:',
	'NameDateMacroInfo'			=> '(nazwa, czas), np. <code>Nazwa użytkownika (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Strefa czasowa:',
	'TimezoneInfo'				=> 'Strefa czasowa, która ma być używana do wyświetlania czasu niezalogowanym użytkownikom (gościom). Zalogowani użytkownicy ustawiają i mogą zmieniać swoją strefę czasową w ustawieniach użytkownika.',

	'Canonical'					=> 'Kanoniczne adresy URL:',
	'CanonicalInfo'				=> 'Wszystkie linki są tworzone jako bezwzględne adresy URL w postaci %1. Należy preferować adresy URL w stosunku do korzenia serwera w postaci %2.',
	'LinkTarget'				=> 'Gdzie otwierają się linki zewnętrzne:',
	'LinkTargetInfo'			=> 'Otwiera każde zewnętrzne łącze w nowym oknie przeglądarki. Dodaje <code>target="_blank"</code> do składni linku.',
	'Noreferrer'				=> 'nie odsyłający:',
	'NoreferrerInfo'			=> 'Wymaga, aby przeglądarka nie wysyłała nagłówka referenta HTTP, jeśli użytkownik podąża za hiperłączem. Dodaje <code>rel="noreferrer"</code> do składni linku.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Należy poinstruować niektóre wyszukiwarki, że hiperłącze nie powinno mieć wpływu na ranking linków docelowych w indeksie wyszukiwarek. Dodaje <code>rel="nofollow"</code> do składni linku.',
	'UrlsUnderscores'			=> 'Adresy formularzy (URL) z podkreśleniami:',
	'UrlsUnderscoresInfo'		=> 'Na przykład, %1 przybywa %2 z tą opcją.',
	'ShowSpaces'				=> 'Wyświetlaj NazwyWiki z odstępem:',
	'ShowSpacesInfo'			=> 'Pokaż spacje w WikiNames, np. <code>MyName</code> wyświetlany jako <code>Moja nazwa</code> z tą opcją.',
	'NumerateLinks'				=> 'Numeruj linki w widoku drukowania:',
	'NumerateLinksInfo'			=> 'Enumeruje i wyświetla wszystkie linki na dole widoku wydruku z tą opcją.',
	'YouareHereText'			=> 'Wyłącz i wizualizuj linki do samodzielnego odnoszenia:',
	'YouareHereTextInfo'		=> 'Wizualizuj linki do tej samej strony, używając <code>&lt;b&gt;####&lt;/b&gt;</code>. Wszystkie linki do formatowania własnych linków, ale są wyświetlane jako pogrubiony tekst.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Tutaj możesz ustawić lub zmienić strony bazowe systemu używane w Wiki. Upewnij się, że nie zapomniałeś utworzyć lub zmienić odpowiednich stron w Wiki zgodnie z Twoimi ustawieniami tutaj.',
	'PagesSettingsUpdated'		=> 'Zaktualizowano strony bazowe ustawień',

	'ListCount'					=> 'Liczba elementów na listę:',
	'ListCountInfo'				=> 'Liczba elementów wyświetlanych na każdej liście dla gości lub jako wartość domyślna dla nowych użytkowników.',

	'ForumSection'				=> 'Ustawienia forum',
	'ForumCluster'				=> 'Forum klaster:',
	'ForumClusterInfo'			=> 'Klaster główny dla sekcji forum (akcja %1).',
	'ForumTopics'				=> 'Liczba tematów na stronę:',
	'ForumTopicsInfo'			=> 'Liczba tematów wyświetlanych na każdej stronie listy w sekcjach forum (akcja %1).',
	'CommentsCount'				=> 'Liczba komentarzy na stronie:',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page list of comments. This applies to all the comments on the site, and not just posted in the forum.',

	'NewsSection'				=> 'Wiadomości sekcji',
	'NewsCluster'				=> 'Klaster wiadomości:',
	'NewsClusterInfo'			=> 'Klaster główny dla sekcji wiadomości (akcja %1).',
	'NewsStructure'				=> 'Struktura klastra wiadomości:',
	'NewsStructureInfo'			=> 'Przechowuje artykuły opcjonalnie w podklastrach według roku/miesiąca lub tygodnia (np. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licencja',
	'DefaultLicense'			=> 'Domyślna licencja:',
	'DefaultLicenseInfo'		=> 'Licencja, pod którą zawartość może być wydana.',
	'EnableLicense'				=> 'Włącz licencję:',
	'EnableLicenseInfo'			=> 'Włącz, aby pokazać informacje o licencji.',
	'LicensePerPage'			=> 'Licencja na stronę:',
	'LicensePerPageInfo'		=> 'Zezwalaj na licencję na stronę, którą właściciel strony może wybrać poprzez właściwości strony.',

	'ServicePagesSection'		=> 'Strony serwisu',
	'RootPage'					=> 'Strona główna:',
	'RootPageInfo'				=> 'Tag twojej głównej strony, otwiera się automatycznie, gdy użytkownik odwiedza Twoją witrynę.',

	'PrivacyPage'				=> 'Polityka ochrony prywatności:',
	'PrivacyPageInfo'			=> 'Strona z Polityką prywatności witryny.',

	'TermsPage'					=> 'Polityka i regulacje:',
	'TermsPageInfo'				=> 'Strona z regułami witryny.',

	'SearchPage'				=> 'Znajdź:',
	'SearchPageInfo'			=> 'Strona z formularzem wyszukiwania (akcja %1).',
	'RegistrationPage'			=> 'Rejestracja:',
	'RegistrationPageInfo'		=> 'Strona dla nowej rejestracji użytkownika (akcja %1).',
	'LoginPage'					=> 'Logowanie użytkownika:',
	'LoginPageInfo'				=> 'Strona logowania na stronie (akcja %1).',
	'SettingsPage'				=> 'Ustawienia użytkownika:',
	'SettingsPageInfo'			=> 'Strona do dostosowania profilu użytkownika (akcja %1).',
	'PasswordPage'				=> 'Zmień hasło:',
	'PasswordPageInfo'			=> 'Strona z formularzem do zmiany / zapytania użytkownika (akcja %1).',
	'UsersPage'					=> 'Lista użytkowników:',
	'UsersPageInfo'				=> 'Strona z listą zarejestrowanych użytkowników (akcja %1).',
	'CategoryPage'				=> 'Kategoria:',
	'CategoryPageInfo'			=> 'Strona z listą stron skategoryzowanych (akcja %1).',
	'GroupsPage'				=> 'Grupy:',
	'GroupsPageInfo'			=> 'Strona z listą grup roboczych (działanie %1).',
	'ChangesPage'				=> 'Ostatnie Zmiany:',
	'ChangesPageInfo'			=> 'Strona z listą ostatnio zmodyfikowanych stron (akcja %1).',
	'CommentsPage'				=> 'Ostatnie komentarze:',
	'CommentsPageInfo'			=> 'Page with a list of recent comment on the page (action %1).',
	'RemovalsPage'				=> 'Usunięte strony:',
	'RemovalsPageInfo'			=> 'Strona z listą ostatnio usuniętych stron (akcja %1).',
	'WantedPage'				=> 'Oczekiwane strony:',
	'WantedPageInfo'			=> 'Strona z listą brakujących stron, które są odwoływane (akcja %1).',
	'OrphanedPage'				=> 'Uosierocone strony:',
	'OrphanedPageInfo'			=> 'Strona z listą istniejących stron nie jest powiązana przez linki do żadnej innej strony (akcja %1).',
	'SandboxPage'				=> 'Sandbox:',
	'SandboxPageInfo'			=> 'Strona, na której użytkownicy mogą ćwiczyć swoje umiejętności znaczników wiki.',
	'HelpPage'					=> 'Pomoc:',
	'HelpPageInfo'				=> 'Sekcja dokumentacji dotycząca pracy z narzędziami lokalizacyjnymi.',
	'IndexPage'					=> 'Indeks:',
	'IndexPageInfo'				=> 'Strona z listą wszystkich stron (action %1).',
	'RandomPage'				=> 'Losową:',
	'RandomPageInfo'			=> 'Ładuje losowo wybraną stronę  (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parametry dla powiadomień platformy.',
	'NotificationSettingsUpdated'	=> 'Zaktualizowane ustawienia powiadomień',

	'EmailNotification'			=> 'Powiadomienie e-mail:',
	'EmailNotificationInfo'		=> 'Zezwalaj na powiadomienia e-mail. Ustaw na włączone, aby włączyć powiadomienia e-mail, wyłączone, aby je wyłączyć. Pamiętaj, że wyłączenie powiadomień e-mail nie ma wpływu na wiadomości e-mail generowane w ramach procesu rejestracji użytkownika.',
	'Autosubscribe'				=> 'Automatyczna subskrypcja:',
	'AutosubscribeInfo'			=> 'Automatycznie powiadamiaj właściciela o zmianach strony.',

	'NotificationSection'		=> 'Domyślne ustawienia powiadomień użytkownika',
	'NotifyPageEdit'			=> 'Powiadom o edycji strony:',
	'NotifyPageEditInfo'		=> 'Oczekujące - Wyślij powiadomienie e-mail tylko dla pierwszej zmiany do czasu ponownego odwiedzenia strony przez użytkownika.',
	'NotifyMinorEdit'			=> 'Powiadom o drobnej edycji:',
	'NotifyMinorEditInfo'		=> 'Wysyła powiadomienia również dla drobnych edycji.',
	'NotifyNewComment'			=> 'Powiadom o nowym komentarzu:',
	'NotifyNewCommentInfo'		=> 'Oczekujące - Wyślij powiadomienie e-mail tylko dla pierwszego komentarza do czasu ponownego odwiedzenia strony przez użytkownika.',

	'NotifyUserAccount'			=> 'Powiadom nowe konto użytkownika:',
	'NotifyUserAccountInfo'		=> 'Administrator zostanie powiadomiony o utworzeniu nowego użytkownika za pomocą formularza rejestracji.',
	'NotifyUpload'				=> 'Powiadom o przesłaniu pliku:',
	'NotifyUploadInfo'			=> 'Moderatorzy zostaną powiadomieni o przesłaniu pliku.',

	'PersonalMessagesSection'	=> 'Wiadomości osobiste',
	'AllowIntercomDefault'		=> 'Zezwalaj na intercom:',
	'AllowIntercomDefaultInfo'	=> 'Włączenie tej opcji pozwala innym użytkownikom wysyłać prywatne wiadomości na adres e-mail odbiorcy bez ujawniania adresu.',
	'AllowMassemailDefault'		=> 'Zezwalaj na masowy e-mail:',
	'AllowMassemailDefaultInfo'	=> 'Wysyłaj wiadomości tylko do tych użytkowników, którzy zezwolili administratorom na wysyłanie ich wiadomości e-mail.',

	// Resync settings
	'Synchronize'				=> 'synchronizować',
	'UserStatsSynched'			=> 'Statystyki użytkownika zsynchronizowane.',
	'PageStatsSynched'			=> 'Statystyki strony zsynchronizowane.',
	'FeedsUpdated'				=> 'Zaktualizowano kanały RSS.',
	'SiteMapCreated'			=> 'Nowa wersja mapy witryny została utworzona pomyślnie.',
	'ParseNextBatch'			=> 'Analizuj następną partię stron:',
	'WikiLinksRestored'			=> 'Przywrócono linki Wiki.',

	'LogUserStatsSynched'		=> 'Zsynchronizowane statystyki użytkownika',
	'LogPageStatsSynched'		=> 'Zsynchronizowane statystyki stron',
	'LogFeedsUpdated'			=> 'Zsynchronizowane kanały RSS',
	'LogPageBodySynched'		=> 'Zmieniona treść strony i linki',

	'UserStats'					=> 'Statystyki użytkownika',
	'UserStatsInfo'				=> 'Statystyki użytkowników (liczba komentarzy, strony własne, korekty i pliki) mogą różnić się w niektórych sytuacjach od danych rzeczywistych. <br>Ta operacja pozwala aktualizować statystyki na dopasowanie rzeczywistych danych zawartych w bazie danych.',
	'PageStats'					=> 'Statystyki strony',
	'PageStatsInfo'				=> 'Statystyki stron (liczba komentarzy, plików i zmian) mogą różnić się w niektórych sytuacjach od danych rzeczywistych. <br>Ta operacja pozwala aktualizować statystyki na dopasowanie rzeczywistych danych zawartych w bazie danych.',

	'AttachmentsInfo'			=> 'Aktualizuje hash pliku dla wszystkich załączników w bazie danych.',
	'AttachmentsSynched'		=> 'Ponownie skasowano wszystkie załączniki do pliku',
	'LogAttachmentsSynched'		=> 'Ponownie skasowano wszystkie załączniki do pliku',

	'Feeds'						=> 'Kanały',
	'FeedsInfo'					=> 'W przypadku bezpośredniej edycji stron w bazie danych zawartość kanałów RSS może nie odzwierciedlać dokonanych zmian. <br>Ta funkcja synchronizuje kanały RSS z aktualnym stanem bazy danych.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'Ta funkcja synchronizuje mapę strony XML z aktualnym stanem bazy danych.',
	'XmlSiteMapPeriod'			=> 'Okres %1 dni. Ostatnio napisane %2.',
	'XmlSiteMapView'			=> 'Pokaż mapę strony w nowym oknie.',

	'ReparseBody'				=> 'Przepakuj wszystkie strony',
	'ReparseBodyInfo'			=> 'Puste <code>body_r</code> w tabeli stron, tak aby każda strona została wyświetlona ponownie w następnym widoku strony. To może być przydatne, jeśli zmodyfikowałeś format lub zmieniłeś domenę wiki.',
	'PreparsedBodyPurged'		=> 'Puste pole <code>body_r</code> w tabeli strony.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Wykonuje ponowne renderowanie dla wszystkich linków inwazyjnych i przywraca zawartość tabel <code>page_link</code> i <code>file_link</code> w przypadku uszkodzenia lub przeniesienia (może to zająć dużo czasu).',
	'RecompilePage'				=> 'Ponowne kompilowanie wszystkich stron (bardzo drogie)',
	'ResyncOptions'				=> 'Dodatkowe opcje',
	'RecompilePageLimit'		=> 'Liczba stron do przeanalizowania jednocześnie.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Te informacje są używane przez witrynę podczas wysyłania e-maili do użytkowników. Sprawdź czy podany adres e-mail jest ważnym adresem, ponieważ wszystkie zwrócone lub niedostarczone wiadomości będą prawdopodobnie odsyłane na ten adres. Jeśli serwer nie udostępnia natywnych (opartych na PHP) usług e-mail, można wysyłać wiadomości bezpośrednio, używając protokołu SMTP. Wymaga to adresu odpowiedniego serwera. Jeśli go nie znasz, zapytaj o niego swojego usługodawcę. Jeśli serwer wymaga uwierzytelnienia (i tylko, jeśli wymaga), wprowadź nazwę użytkownika, hasło i metodę uwierzytelniania.',

	'EmailSettingsUpdated'		=> 'Zaktualizowane ustawienia e-mail',

	'EmailFunctionName'			=> 'Nazwa funkcji:',
	'EmailFunctionNameInfo'		=> 'Nazwa funkcji e-maila używana do wysyłania maili przez PHP.',
	'UseSmtpInfo'				=> 'Wybierz <code>SMTP</code> , jeśli takie jest twoje życzenie lub trzeba wysyłać wiadomości e-mail przez dany serwer zamiast przez lokalną funkcję pocztową.',

	'EnableEmail'				=> 'E-mail do wszystkich:',
	'EnableEmailInfo'			=> 'Włącz wysyłanie e-maili.',

	'EmailIdentitySettings'		=> 'Tożsamość witryny e-mail',
	'FromEmailName'				=> 'From Name:',
	'FromEmailNameInfo'			=> 'Nazwa nadawcy, która jest używana dla nagłówka <code>From:</code> dla wszystkich powiadomień e-mail wysyłanych z witryny.',
	'EmailSubjectPrefix'		=> 'Prefiks tematu:',
	'EmailSubjectPrefixInfo'	=> 'Alternatywny prefiks tematu wiadomości e-mail, np. <code>[Prefiks] Tematu</code>. Jeśli nie zostanie zdefiniowany, domyślnym prefiksem jest Site Name: %1.',

	'NoReplyEmail'				=> 'Adres bez odpowiedzi:',
	'NoReplyEmailInfo'			=> 'Ten adres, np. <code>noreply@example.com</code>, pojawi się w polu <code>From:</code> adres e-mail wszystkich powiadomień e-mail wysyłanych z witryny.',
	'AdminEmail'				=> 'Adres e-mail właściciela witryny:',
	'AdminEmailInfo'			=> 'Ten adres jest używany do celów administratora, takich jak powiadomienie o nowym użytkowniku.',
	'AbuseEmail'				=> 'Usługa nadużywania adresu e-mail:',
	'AbuseEmailInfo'			=> 'Żądania adresów w pilnych sprawach: rejestracja obcego e-maila itp. Może być taka sama jak adres e-mail właściciela witryny.',

	'SendTestEmail'				=> 'Wyślij testową wiadomość e-mail',
	'SendTestEmailInfo'			=> 'Spowoduje to wysłanie testowej wiadomości e-mail na adres zdefiniowany na Twoim koncie.',
	'TestEmailSubject'			=> 'Twoja Wiki jest poprawnie skonfigurowana do wysyłania e-maili',
	'TestEmailBody'				=> 'Jeśli otrzymałeś tę wiadomość e-mail, oznacza to, że Twój serwis Wiki jest poprawnie skonfigurowany do wysyłania wiadomości e-mail.',
	'TestEmailMessage'			=> 'Email testowy został wysłany.<br>Jeśli nie otrzymałeś go, sprawdź konfigurację swojej poczty.',

	'SmtpSettings'				=> 'Ustawienia SMTP',
	'SmtpAutoTls'				=> 'Oportunistyczne TLS:',
	'SmtpAutoTlsInfo'			=> 'Włącza szyfrowanie automatycznie, jeśli widzisz, że serwer reklamuje szyfrowanie TLS (po połączeniu z serwerem), nawet jeśli nie ustawiłeś trybu połączenia dla <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Metoda uwierzytelniania dla SMTP:',
	'SmtpConnectionModeInfo'	=> 'Uwierzytelnianie jest używane tylko wtedy, gdy jest określona nazwa użytkownika i hasło. Jeśli nie wiesz, jakiej metody użyć, zapytaj swojego dostawcę usługi.',
	'SmtpPassword'				=> 'SMTP Hasło:',
	'SmtpPasswordInfo'			=> 'Należy wprowadzić tylko, jeśli serwer SMTP tego wymaga.<br><em><strong>Ostrzeżenie:</strong> Hasło zostanie zapisane w bazie danych jako zwykły tekst i będzie widoczne dla każdego, kto ma dostęp do bazy danych lub kto może przeglądać tę stronę konfiguracji.</em>',
	'SmtpPort'					=> 'Port serwera:',
	'SmtpPortInfo'				=> 'Można zmieniać tylko wtedy, gdy wiadomo, że serwer pracuje na innym porcie. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'SMTP Adres serwera:',
	'SmtpServerInfo'			=> 'Note that you have to provide the protocol that your server uses. If you are using SSL, this has to be <code>ssl://mail.example.com</code>',
	'SmtpUsername'				=> 'SMTP Nazwa użytkownika:',
	'SmtpUsernameInfo'			=> 'Należy wprowadzić tylko, jeśli serwer SMTP tego wymaga.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Tutaj można dokonać konfiguracji głównych ustawień załączników i powiązanych z nimi kategorii specjalnych.',
	'UploadSettingsUpdated'		=> 'Zaktualizowano ustawienia przesyłania',

	'FileUploadsSection'		=> 'Przesyłanie plików',
	'RegisteredUsers'			=> 'zarejestrowani użytkownicy',
	'RightToUpload'				=> 'Uprawnienia do przesyłania plików:',
	'RightToUploadInfo'			=> '<code>administratorzy</code> oznacza, że tylko użytkownicy należący do grupy administratorów mogą przesyłać pliki. <code>1</code> oznacza, że przesyłanie jest otwarte dla zarejestrowanych użytkowników. <code>0</code> oznacza, że przesyłanie jest wyłączone.',
	'UploadMaxFilesize'			=> 'Maksymalny rozmiar pliku:',
	'UploadMaxFilesizeInfo'		=> 'Maksymalny rozmiar zamieszczanego pliku. Wartość zero (0) - rozmiar zamieszczanego pliku ograniczany jest tylko przez ustawienia PHP.',
	'UploadQuota'				=> 'Rozmiar przestrzeni dyskowej:',
	'UploadQuotaInfo'			=> 'Maksymalna przestrzeń dyskowa dostępna dla wszystkich załączników w tej instalacji Wiki. Wartość zero <code>0</code> - brak ograniczenia przestrzeni. %1 used.',
	'UploadQuotaUser'			=> 'Kontyngent pamięci na użytkownika:',
	'UploadQuotaUserInfo'		=> 'Ograniczenie limitu pamięci, który może zostać przesłany przez jednego użytkownika, przy czym <code>0</code> jest nieograniczony.',

	'FileTypes'					=> 'Formaty plików',
	'UploadOnlyImages'			=> 'Zezwalaj tylko na przesyłanie obrazów:',
	'UploadOnlyImagesInfo'		=> 'Zezwalaj tylko na przesyłanie plików obrazów na stronie.',
	'AllowedUploadExts'			=> 'Dopuszczalne formaty plików:',
	'AllowedUploadExtsInfo'		=> 'Dozwolone rozszerzenia dla przesyłanych plików, oddzielone przecinkami np. <code>png, ogg, mp4</code>, w przeciwnym razie wszystkie nie zabronione rozszerzenia plików są dozwolone.<br>Należy ograniczyć listę dozwolonych typów plików do niezbędnego minimum wymaganego przez funkcjonalność witryny.',
	'CheckMimetype'				=> 'Sprawdzaj pliki załącznika:',
	'CheckMimetypeInfo'			=> 'Niektóre przeglądarki mogą być zmuszane do przybierania nieprawidłowego typu mediów (mimetype) dla wysyłanych plików. Funkcja ta zabezpiecza takie pliki przed odrzuceniem.',
	'SvgSanitizer'				=> 'SVG Sanitizer:',
	'SvgSanitizerInfo'			=> 'Umożliwia to sanityzację wgrywanych plików SVG, aby zapobiec wgrywaniu plików SVG/XML podatnych na ataki.',
	'TranslitFileName'			=> 'Nazwy transliteracji plików:',
	'TranslitFileNameInfo'		=> 'Jeśli ma to zastosowanie i nie ma potrzeby posiadania znaków Unicode, wysoce zalecane jest akceptowanie tylko znaków alfanumerycznych.',
	'TranslitCaseFolding'		=> 'Konwertuje nazwy plików na małe litery:',
	'TranslitCaseFoldingInfo'	=> 'Ta opcja działa tylko z aktywną transliteracją.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Zawsze twórz miniaturę:',
	'CreateThumbnailInfo'		=> 'Tworzy miniaturę we wszystkich możliwych sytuacjach. Dzięki tej funkcji miniatura będzie wyświetlana bezpośrednio w poście i użytkownik może ją kliknąć, aby zobaczyć pełny obrazek.',
	'JpegQuality'				=> 'JPEG Quality:',
	'JpegQualityInfo'			=> 'Jakość podczas skalowania miniatury JPEG. Powinna zawierać się w przedziale od 1 do 100, przy czym 100 oznacza 100% jakości.',
	'MaxImageArea'				=> 'Maximum Image Area:',
	'MaxImageAreaInfo'			=> 'Maksymalna liczba pikseli, jaką może mieć obrazek źródłowy. Zapewnia to ograniczenie użycia pamięci przez stronę dekompresji skalera obrazu. <br><code>-1</code> oznacza, że nie będzie sprawdzał rozmiaru obrazu przed próbą skalowania. <code>0</code> oznacza, że wartość ta zostanie określona automatycznie.',
	'MaxThumbWidth'				=> 'Maksymalna szerokość miniatury w pikselach:',
	'MaxThumbWidthInfo'			=> 'Generowana miniatura nie będzie mogła przekroczyć określonej tutaj szerokości.',
	'MinThumbFilesize'			=> 'Minimalny rozmiar pliku miniatury:',
	'MinThumbFilesizeInfo'		=> 'Jeśli rozmiar pliku miniatury jest mniejszy niż zdefiniowana tutaj wartość, miniatura nie zostanie utworzona.',
	'MaxImageWidth'				=> 'Ograniczenie rozmiaru obrazu na stronach:',
	'MaxImageWidthInfo'			=> 'Maksymalna szerokość, jaką może mieć obraz na stronach, w przeciwnym razie generowana jest przeskalowana miniaturka.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Lista usuniętych stron, wersji i plików.
Usuń lub przywróć strony, wersje lub pliki z bazy danych, klikając na link <em>Usuń</em>
lub <em>Przywróć</em> w odpowiednim wierszu. (Uwaga, nie jest wymagane potwierdzenie usunięcia!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Słowa, które zostaną automatycznie cenzurowane na Wiki.',
	'FilterSettingsUpdated'		=> 'Zaktualizowano ustawienia filtra spamu',

	'WordCensoringSection'		=> 'Word censoring',
	'SPAMFilter'				=> 'SPAM Filter:',
	'SPAMFilterInfo'			=> 'Włączanie filtra spamu',
	'WordList'					=> 'Lista słow:',
	'WordListInfo'				=> 'Słowo lub fraza <code>fragment</code> , aby być na czarnej liście (jeden na linię)',

	// Log module
	'LogFilterTip'				=> 'Filtruj zdarzenia według kryteriów:',
	'LogLevel'					=> 'Poziom',
	'LogLevelFilters'	=> [
		'1'		=> 'nie mniej niż',
		'2'		=> 'nie wyższa niż',
		'3'		=> 'równa się',
	],
	'LogNoMatch'				=> 'Brak zdarzeń spełniających kryteria',
	'LogDate'					=> 'Data',
	'LogEvent'					=> 'Wydarzenie',
	'LogUsername'				=> 'Nazwa użytkownika',
	'LogLevels'	=> [
		'1'		=> 'krytyczne',
		'2'		=> 'najwyższy',
		'3'		=> 'wysoka',
		'4'		=> 'średnia',
		'5'		=> 'niski',
		'6'		=> 'najniższy',
		'7'		=> 'debugowanie',
	],

	// Massemail module
	'MassemailInfo'				=> 'Tutaj możesz wysłać wiadomość e-mail do wszystkich użytkowników lub do wszystkich członków konkretnej grupy, która ma włączoną <strong>funkcję odbierania masowych wiadomości e-mail</strong>. Aby to osiągnąć e-mail zostanie wysłany na adres e-maila wykonawczego z ukrytą kopią (odbiorca nie będzie widział adresów innych odbiorców) wysłaną do wszystkich odbiorców. Domyślnie ustawionych jest 50 odbiorców. Wysłanie wiadomości do dużej liczby osób może potrwać dłuższą chwilę. Zachowaj cierpliwość i nie przerywaj tej operacji. Po jej zakończeniu zostanie wyświetlone powiadomienie.',
	'LogMassemail'				=> 'Mass email send %1 to group / user ',
	'MassemailSend'				=> 'Mass email send',

	'NoEmailMessage'			=> 'Należy wprowadzić treść wiadomości.',
	'NoEmailSubject'			=> 'Należy określić temat wiadomości.',
	'NoEmailRecipient'			=> 'Musisz podać co najmniej jednego użytkownika lub grupę użytkowników.',

	'MassemailSection'			=> 'Wiadomość masowa',
	'MessageSubject'			=> 'Temat:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Treść wiadomości:',
	'YourMessageInfo'			=> 'Treść wiadomości musi być wpisana zwykłym tekstem. Przed wysłaniem wiadomości wszystkie znaczniki zostaną usunięte.',

	'NoUser'					=> 'Brak użytkownika',
	'NoUserGroup'				=> 'Brak grupy użytkowników',

	'SendToGroup'				=> 'Wyślij do grupy:',
	'SendToUser'				=> 'Wyślij do użytkowników:',
	'SendToUserInfo'			=> 'Tylko użytkownicy, którzy zezwalają administratorom na wysyłanie wiadomości e-mail otrzymają masowe wiadomości e-mail. Ta opcja jest dostępna w ustawieniach użytkownika w ramach powiadomień.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Zaktualizowano wiadomość systemową',

	'SysMsgSection'				=> 'Wiadomość systemowa',
	'SysMsg'					=> 'Wiadomość systemowa:',
	'SysMsgInfo'				=> 'Twój tekst tutaj',

	'SysMsgType'				=> 'Typ:',
	'SysMsgTypeInfo'			=> 'Typ komunikatu (CSS).',
	'SysMsgAudience'			=> 'Głość:',
	'SysMsgAudienceInfo'		=> 'Widza, do której wyświetlany jest komunikat systemowy.',
	'EnableSysMsg'				=> 'Włącz wiadomość systemową:',
	'EnableSysMsgInfo'			=> 'Pokaż komunikat systemowy.',

	// User approval module
	'ApproveNotExists'			=> 'Proszę wybrać co najmniej jednego użytkownika za pomocą przycisku Ustawienia.',

	'LogUserApproved'			=> 'Użytkownik ##%1## zatwierdzony',
	'LogUserBlocked'			=> 'Użytkownik ##%1## zablokowany',
	'LogUserDeleted'			=> 'Użytkownik ##%1## usunięty z bazy danych',
	'LogUserCreated'			=> 'Utworzono nowego użytkownika ##%1##',
	'LogUserUpdated'			=> 'Zaktualizowano użytkownika ##%1##',

	'UserApproveInfo'			=> 'Zatwierdź nowych użytkowników zanim będą mogli zalogować się na witrynę.',
	'Approve'					=> 'Zatwierdź',
	'Deny'						=> 'Odmowa',
	'Pending'					=> 'Oczekujące',
	'Approved'					=> 'Zatwierdzone',
	'Denied'					=> 'Odmowa',

	// DB Backup module
	'BackupStructure'			=> 'Struktura',
	'BackupData'				=> 'Dane',
	'BackupFolder'				=> 'Folder',
	'BackupTable'				=> 'Tabela',
	'BackupCluster'				=> 'Klaster:',
	'BackupFiles'				=> 'Pliki',
	'BackupNote'				=> 'Uwaga:',
	'BackupSettings'			=> 'Określ żądany schemat kopii zapasowej.<br>' .
    	'Klaster główny nie ma wpływu na globalną kopię zapasową plików i kopię zapasową plików pamięci podręcznej (jeśli wybrano, są one zawsze zapisywane w całości).<br>' .  '<br>' .
		'<strong>Uwaga</strong>: Aby uniknąć utraty informacji z bazy danych podczas określania głównego klastra tabele z tej kopii zapasowej nie będą restrukturyzowane, tak samo jak podczas tworzenia kopii zapasowej tylko struktury tabeli bez zapisywania danych. Aby dokonać pełnej konwersji tabel do formatu kopii zapasowej, musisz wykonać pełną kopię zapasową bazy danych <em> (strukturę i dane) bez określania klastra</em>.',
	'BackupCompleted'			=> 'Tworzenie kopii zapasowej i archiwizacja zakończone.<br>' .
    	'Pliki pakietów kopii zapasowych były przechowywane w podkatalogu %1.<br>. Aby go pobrać użyj FTP (zachowaj strukturę katalogu i nazwy plików podczas kopiowania).<br> Aby przywrócić kopię zapasową lub usunąć pakiet, przejdź do <a href="%2">Przywróć bazę danych</a>.',
	'LogSavedBackup'			=> 'Zapisano kopię zapasową bazy danych ##%1##',
	'Backup'					=> 'Kopia zapasowa',
	'CantReadFile'				=> 'Nie można odczytać pliku %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Możesz przywrócić dowolne znalezione pakiety kopii zapasowej lub usunąć je z serwera.',
	'ConfirmDbRestore'			=> 'Chcesz przywrócić kopię zapasową %1?',
	'ConfirmDbRestoreInfo'		=> 'Proszę poczekać, to może potrwać kilka minut.',
	'RestoreWrongVersion'		=> 'Nieprawidłowa wersja WackoWiki!',
	'DirectoryNotExecutable'	=> 'Katalog %1 nie jest wykonywalny.',
	'BackupDelete'				=> 'Na pewno chcesz usunąć kopię zapasową %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Dodatkowe opcje przywracania:',
	'RestoreOptionsInfo'		=> '* Przed przywróceniem kopii zapasowej klastrów <strong></strong>, ' .
									'tabele docelowe nie są usuwane (aby zapobiec utracie informacji z klastrów, które nie zostały zabezpieczone). ' .
									'Tak więc podczas procesu odzyskiwania wystąpią duplikaty rekordów. ' .
									'W trybie normalnym, wszystkie z nich zostaną zastąpione kopią zapasową formularza rekordów (używając SQL <code>REPLACE</code>), ' .
									'ale jeśli to pole wyboru jest zaznaczone, wszystkie duplikaty zostaną pominięte (bieżące wartości rekordów zostaną zachowane), ' .
									'i tylko rekordy z nowymi kluczami są dodawane do tabeli (SQL <code>INSERT IGNORE</code>).<br>' .
									'<strong>Uwaga</strong>: Podczas przywracania pełnej kopii zapasowej witryny ta opcja nie ma żadnej wartości.<br>' .
									'<br>' .
									'** Jeśli kopia zapasowa zawiera pliki użytkownika (globalne i perpity, pliki pamięci podręcznej itp.), ' .
									'w trybie normalnym zastępują istniejące pliki tymi samymi nazwami i są umieszczane w tym samym katalogu podczas przywracania. ' .
									'Ta opcja pozwala zapisać bieżące kopie plików i przywrócić z kopii zapasowej tylko nowe pliki (brakujące na serwerze).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignoruj zduplikowane klucze tabeli (nie zastępuj)',
	'IgnoreSameFiles'			=> 'Ignoruj te same pliki (nie nadpisuj)',
	'NoBackupsAvailable'		=> 'Brak dostępnych kopii zapasowych.',
	'BackupEntireSite'			=> 'Cała witryna',
	'BackupRestored'			=> 'Kopia zapasowa jest przywrócona, raport podsumowujący jest załączony poniżej. Aby usunąć tę kopię zapasową, kliknij',
	'BackupRemoved'				=> 'Wybrana kopia zapasowa została pomyślnie usunięta.',
	'LogRemovedBackup'			=> 'Usunięto kopię zapasową bazy danych ##%1##',

	'RestoreStarted'			=> 'Rozpoczęto przywracanie',
	'RestoreParameters'			=> 'Używanie parametrów',
	'IgnoreDuplicatedKeys'		=> 'Ignoruj zduplikowane klucze',
	'IgnoreDuplicatedFiles'		=> 'Ignoruj zduplikowane pliki',
	'SavedCluster'				=> 'Zapisany klaster',
	'DataProtection'			=> 'Data Protection - %1 omitted',
	'AssumeDropTable'			=> 'Przyjmij %1',
	'RestoreTableStructure'		=> 'Przywracanie struktury tabeli',
	'RunSqlQueries'				=> 'Wykonaj instrukcje SQL:',
	'CompletedSqlQueries'		=> 'Ukończone. Przetworzone instrukcje:',
	'NoTableStructure'			=> 'Struktura tabel nie została zapisana - pomiń',
	'RestoreRecords'			=> 'Przywróć zawartość tabel',
	'ProcessTablesDump'			=> 'Po prostu pobierz i przetwarzaj zrzuty tabeli',
	'Instruction'				=> 'Instrukcja',
	'RestoredRecords'			=> 'rekordy:',
	'RecordsRestoreDone'		=> 'Ukończone. Suma wpisów:',
	'SkippedRecords'			=> 'Nie zapisano danych - pomiń',
	'RestoringFiles'			=> 'Przywracanie plików',
	'DecompressAndStore'		=> 'Dekompresuj i przechowuj zawartość katalogów',
	'HomonymicFiles'			=> 'pliki homonymic',
	'RestoreSkip'				=> 'pomiń',
	'RestoreReplace'			=> 'zastąp',
	'RestoreFile'				=> 'Plik:',
	'RestoredFiles'				=> 'przywrócono:',
	'SkippedFiles'				=> 'pominięto:',
	'FileRestoreDone'			=> 'Ukończone. Całkowita ilość plików:',
	'FilesAll'					=> 'wszystko:',
	'SkipFiles'					=> 'Pliki nie są przechowywane - pomiń',
	'RestoreDone'				=> 'RESTORACJA WYPEŁNIONA',

	'BackupCreationDate'		=> 'Data utworzenia',
	'BackupPackageContents'		=> 'Zawartość opakowania',
	'BackupRestore'				=> 'Przywracanie',
	'BackupRemove'				=> 'Usuń',
	'RestoreYes'				=> 'Tak',
	'RestoreNo'					=> 'Nie',
	'LogDbRestored'				=> 'Kopia zapasowa ##%1## bazy danych przywrócona.',

	'BackupArchived'			=> 'Zarchiwizowano kopię zapasową %1.',
	'BackupArchiveExists'		=> 'Archiwum kopii zapasowej %1 już istnieje.',
	'LogBackupArchived'			=> 'Zarchiwizowano kopię zapasową ##%1##.',

	// User module
	'UsersInfo'					=> 'Tutaj możesz zmienić informacje o swoich użytkownikach i pewne konkretne opcje.',

	'UsersAdded'				=> 'Użytkownik dodany',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> 'Edytuj',
	'UsersAddNew'				=> 'Dodaj nowego użytkownika',
	'UsersDelete'				=> 'Na pewno chcesz usunąć użytkownika %1?',
	'UsersDeleted'				=> 'Użytkownik %1 został usunięty z bazy danych.',
	'UsersRename'				=> 'Zmień nazwę użytkownika %1 na',
	'UsersRenameInfo'			=> '* Uwaga: Zmiana wpłynie na wszystkie strony, które są przypisane do tego użytkownika.',
	'UsersUpdated'				=> 'Użytkownik został pomyślnie zaktualizowany.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Czas rejestracji',
	'UserActions'				=> 'Akcje',
	'NoMatchingUser'			=> 'Brak użytkowników spełniających kryteria',

	'UserAccountNotify'			=> 'Powiadomić użytkownika',
	'UserNotifySignup'			=> 'poinformować użytkownika o nowym koncie',
	'UserVerifyEmail'			=> 'ustaw email potwierdzający token i dodaj link do weryfikacji emaila.',
	'UserReVerifyEmail'			=> 'Wyślij ponownie e-mail potwierdzający token',

	// Groups module
	'GroupsInfo'				=> 'Z tego panelu możesz zarządzać wszystkimi swoimi grupami użytkowników. Możesz usunąć, utworzyć i edytować istniejące grupy. Ponadto możesz wybrać liderów grupy, włączyć status otwarcia/ukrycia/zamkniętej grupy i ustawić nazwę grupy i opis.',

	'LogMembersUpdated'			=> 'Zaktualizowano członków grupy użytkowników',
	'LogMemberAdded'			=> 'Dodano członka ##%1## do grupy ##%2##',
	'LogMemberRemoved'			=> 'Usunięto członka ##%1## z grupy ##%2##',
	'LogGroupCreated'			=> 'Utworzono nową grupę ##%1##',
	'LogGroupRenamed'			=> 'Grupa ##%1## zmiana nazwy na ##%2##',
	'LogGroupRemoved'			=> 'Usunięta grupa ##%1##',

	'GroupsMembersFor'			=> 'Członkowie grupy',
	'GroupsDescription'			=> 'Opis',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Otwórz',
	'GroupsActive'				=> 'Aktywny',
	'GroupsTip'					=> 'Kliknij, aby edytować grupę',
	'GroupsUpdated'				=> 'Zaktualizowano grupy',
	'GroupsAlreadyExists'		=> 'Ta grupa już istnieje.',
	'GroupsAdded'				=> 'Grupa została pomyślnie dodana.',
	'GroupsRenamed'				=> 'Zmieniono nazwę grupy.',
	'GroupsDeleted'				=> 'Grupa %1 i wszystkie powiązane strony zostały usunięte z bazy danych.',
	'GroupsAdd'					=> 'Dodaj nową grupę',
	'GroupsRename'				=> 'Zmień nazwę grupy %1 na',
	'GroupsRenameInfo'			=> '* Uwaga: Zmiana wpłynie na wszystkie strony, które są przypisane do tej grupy.',
	'GroupsDelete'				=> 'Na pewno chcesz usunąć grupę %1?',
	'GroupsDeleteInfo'			=> '* Uwaga: Zmiana wpłynie na wszystkich członków przypisanych do tej grupy.',
	'GroupsIsSystem'			=> 'Grupa %1 należy do systemu i nie może być usunięta.',
	'GroupsStoreButton'			=> 'Zapisz grupy',
	'GroupsEditInfo'			=> 'Aby edytować listę grup, wybierz przycisk radiowy.',

	'GroupAddMember'			=> 'Dodaj członka',
	'GroupRemoveMember'			=> 'Usuń członka',
	'GroupAddNew'				=> 'Dodaj grupę',
	'GroupEdit'					=> 'Grupa redakcyjna',
	'GroupDelete'				=> 'Usuń grupę',

	'MembersAddNew'				=> 'Dodaj nowego członka',
	'MembersAdded'				=> 'Dodano nowego członka do grupy.',
	'MembersRemove'				=> 'Czy na pewno chcesz usunąć członka %1?',
	'MembersRemoved'			=> 'Członek został usunięty z grupy.',

	// Statistics module
	'DbStatSection'				=> 'Statystyki bazy danych',
	'DbTable'					=> 'Tabela',
	'DbRecords'					=> 'Rekordy',
	'DbSize'					=> 'Rozmiar',
	'DbIndex'					=> 'Wielkość sprzedaży i udział w rynku',
	'DbOverhead'				=> 'Nieruchomości',
	'DbTotal'					=> 'Łącznie',

	'FileStatSection'			=> 'Statystyki systemu plików',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> 'Pliki',
	'FileSize'					=> 'Rozmiar',
	'FileTotal'					=> 'Łącznie',

	// Sysinfo module
	'SysInfo'					=> 'Informacje o wersji:',
	'SysParameter'				=> 'Parametr',
	'SysValues'					=> 'Wartości',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Ostatnia aktualizacja',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Nazwa serwera',
	'WebServer'					=> 'Serwer www',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'Globalne tryby SQL',
	'SqlModesSession'			=> 'Sesja trybów SQL',
	'IcuVersion'				=> 'Międzynarodowa Organizacja Normalizacyjna',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Pamięć',
	'UploadFilesizeMax'			=> 'Prześlij maksymalny rozmiar pliku',
	'PostMaxSize'				=> 'Maksymalny rozmiar wpisu',
	'MaxExecutionTime'			=> 'Maksymalny czas wykonania',
	'SessionPath'				=> 'Ścieżka sesji',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'Kompresja GZP',
	'PhpExtensions'				=> 'Rozszerzenia PHP',
	'ApacheModules'				=> 'Moduły Apache',

	// DB repair module
	'DbRepairSection'			=> 'Napraw bazę danych',
	'DbRepair'					=> 'Napraw bazę danych',
	'DbRepairInfo'				=> 'Ten skrypt może automatycznie szukać wspólnych problemów z bazą danych i je naprawić. Naprawa może chwilę potrwać, więc prosimy o cierpliwość.',

	'DbOptimizeRepairSection'	=> 'Napraw i optymalizuj bazę danych',
	'DbOptimizeRepair'			=> 'Napraw i optymalizuj bazę danych',
	'DbOptimizeRepairInfo'		=> 'Ten skrypt może również próbować zoptymalizować bazę danych. To poprawia wydajność w niektórych sytuacjach. Naprawianie i optymalizacja bazy danych może zająć dużo czasu, a baza danych zostanie zablokowana podczas optymalizacji.',

	'TableOk'					=> 'Stół %1 jest w porządku.',
	'TableNotOk'				=> 'Tabela %1 nie jest w porządku. Zgłasza następujący błąd: %2. Ten skrypt będzie próbował naprawić tę tabelę&hellip;',
	'TableRepaired'				=> 'Pomyślnie naprawiono tabelę %1.',
	'TableRepairFailed'			=> 'Nie udało się naprawić tablicy %1 . <br>Błąd: %2',
	'TableAlreadyOptimized'		=> 'Tabela %1 jest już zoptymalizowana.',
	'TableOptimized'			=> 'Pomyślnie zoptymalizowano tabelę %1.',
	'TableOptimizeFailed'		=> 'Nie udało się zoptymalizować tablicy %1 . <br>Błąd: %2',
	'TableNotRepaired'			=> 'Niektóre problemy z bazą danych nie mogły zostać naprawione.',
	'RepairsComplete'			=> 'Naprawa zakończona',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Pokaż i naprawiaj niespójności, usuń lub przypisz osierocone rekordy do nowego użytkownika / wartości.',
	'Inconsistencies'			=> 'Niespójności',
	'CheckDatabase'				=> 'Baza danych',
	'CheckDatabaseInfo'			=> 'Sprawdza niespójności rekordów w bazie danych.',
	'CheckFiles'				=> 'Pliki',
	'CheckFilesInfo'			=> 'Sprawdza czy pliki opuszczone, pliki bez odniesienia w tabeli plików.',
	'Records'					=> 'Rekordy',
	'InconsistenciesNone'		=> 'Nie znaleziono niespójności danych.',
	'InconsistenciesDone'		=> 'Niespójność danych rozwiązana.',
	'InconsistenciesRemoved'	=> 'Usunięte niespójności',
	'Check'						=> 'Sprawdzanie',
	'Solve'						=> 'Rozwiąż',

	// Bad Behaviour module
	'BbInfo'					=> 'Wykrywa i blokuje niechciany dostęp do stron internetowych, odmawia zautomatyzowanego dostępu do spambotów.<br>Aby uzyskać więcej informacji, odwiedź stronę główną %1.',
	'BbEnable'					=> 'Włącz nieprawidłowe zachowanie:',
	'BbEnableInfo'				=> 'Wszystkie inne ustawienia można zmienić w folderze konfiguracyjnym %1.',
	'BbStats'					=> 'Złe zachowanie zablokowało próby dostępu %1 w ciągu ostatnich 7 dni.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Logi',
	'BbSettings'				=> 'Ustawienia',
	'BbWhitelist'				=> 'Biała lista',

	// --> Log
	'BbHits'					=> 'Odsłony',
	'BbRecordsFiltered'			=> 'Wyświetlanie rekordów %1 z %2 przefiltrowanych przez',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Zablokowane',
	'BbPermitted'				=> 'Dozwolone',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Wyświetlanie wszystkich rekordów %1',
	'BbShow'					=> 'Pokaż',
	'BbIpDateStatus'			=> 'IP/Data/Status',
	'BbHeaders'					=> 'Nagłówki',
	'BbEntity'					=> 'Jednostka',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Opcje zapisane.',
	'BbWhitelistHint'			=> 'Nieodpowiednie białe listy WILL narażają Cię na spam lub powodują, że nieprawidłowe zachowanie przestanie działać całkowicie! NIE NALEŻY BIAŁY, chyba że pacjent jest w 100% NIEKTÓRY, że powinien go stosować.',
	'BbIpAddress'				=> 'Adres IP',
	'BbIpAddressInfo'			=> 'Adres IP lub zakresy adresów formatu CIDR do białej listy (jeden na linię)',
	'BbUrl'						=> 'Adres URL',
	'BbUrlInfo'					=> 'Fragmenty URL zaczynające się / po nazwie hosta witryny (jeden na linię)',
	'BbUserAgent'				=> 'Agent użytkownika',
	'BbUserAgentInfo'			=> 'Ciągi agentów użytkowników do dodania do białej listy (jeden na linię)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Zaktualizowano nieprawidłowe ustawienia zachowania',
	'BbLogRequest'				=> 'Logowanie żądania HTTP',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normalne (zalecane)',
	'BbLogOff'					=> 'Nie rejestrowaj (nie zalecane)',
	'BbSecurity'				=> 'Bezpieczeństwo',
	'BbStrict'					=> 'Ścisła kontrola',
	'BbStrictInfo'				=> 'blokuje więcej spamu, ale może blokować niektóre osoby',
	'BbOffsiteForms'			=> 'Zezwalaj na zamieszczanie formularzy z innych stron internetowych',
	'BbOffsiteFormsInfo'		=> 'wymagane dla OpenID; zwiększa ilość otrzymanego spamu',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Aby użyć Bad Behaviour\'s http:BL funkcje muszą mieć %1',
	'BbHttpblKey'				=> 'http:BL Klucz dostępu',
	'BbHttpblThreat'			=> 'Minimalny poziom zagrożenia (25 jest zalecany)',
	'BbHttpblMaxage'			=> 'Maksymalny wiek danych (zaleca się 30 lat)',
	'BbReverseProxy'			=> 'Równowaga Odwróconego Proxy/Load',
	'BbReverseProxyInfo'		=> 'Jeśli używasz Bad Behaviour za odwróconym proxy, załaduj balancer, akcelerator HTTP, pamięć podręczną treści lub podobną technologię, włącz opcję Reverse Proxy.<br>' .
									'Jeśli masz łańcuch dwóch lub więcej odwrotnych proxy pomiędzy Twoim serwerem a publicznym Internetem, musisz podać <em>wszystkie</em> zakresów adresów IP (w formacie CIDR) wszystkich twoich serwerów proxy, balancerów załadowań itp. W przeciwnym razie nieprawidłowe zachowanie może nie być w stanie określić prawdziwego adresu IP klienta.<br>' .
									'Ponadto serwery odwróconego serwera proxy muszą ustawić adres IP klienta internetowego, z którego otrzymali żądanie w nagłówku HTTP. Jeśli nie podasz nagłówka, zostanie użyty %1 . Większość serwerów proxy już obsługuje X-Forwarded-For i musisz tylko upewnić się, że jest ona włączona na serwerach proxy. Niektóre inne nazwy nagłówków w powszechnym użyciu zawierają %2 i %3.',
	'BbReverseProxyEnable'		=> 'Włącz Odwrotne Proxy',
	'BbReverseProxyHeader'		=> 'Nagłówek zawierający adres IP klientów internetowych',
	'BbReverseProxyAddresses'	=> 'Adres IP lub zakresy adresów w formacie CIDR dla serwerów proxy (jeden na linię)',

];
