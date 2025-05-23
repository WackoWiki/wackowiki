<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'pl',
'LangLocale'	=> 'pl_PL',
'LangName'		=> 'Polski',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Kategoria',
	'groups_page'		=> 'Grupy',
	'users_page'		=> 'Użytkownicy',

	'search_page'		=> 'Szukaj',
	'login_page'		=> 'Zaloguj się',
	'account_page'		=> 'Ustawienia',
	'registration_page'	=> 'Rejestracja',
	'password_page'		=> 'Hasło',

	'changes_page'		=> 'OstatnieZmiany',
	'comments_page'		=> 'OstatnioKomentowane',
	'index_page'		=> 'IndexStron',

	'random_page'		=> 'LosowąStrona',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'Instalacja WackoWiki',
'TitleUpdate'					=> 'Aktualizacja WackoWiki',
'Continue'						=> 'Kontynuuj',
'Back'							=> 'Wstecz',
'Recommended'					=> 'zalecane',
'InvalidAction'					=> 'Nieprawidłowe działanie',

/*
   Language Selection Page
*/
'lang'							=> 'Konfiguracja Języka',
'PleaseUpgradeToR6'				=> 'Używana jest stara (sprzed %2) wersja WackoWiki (%1). Aby zaktualizować WackoWiki do nowej wersji, należy najpierw zaktualizować instalację do wersji %2.',
'UpgradeFromWacko'				=> 'Witamy w WackoWiki. Wygląda na to, że dokonujesz aktualizacji z wersji %1 WackoWiki do wersji %2.  Następne kilka stron poprowadzi Cię przez proces aktualizacji.',
'FreshInstall'					=> 'Witamy w WackoWiki. Za chwilę nastąpi instalacja %1 WackoWiki.  Następne kilka stron poprowadzi Cię przez proces instalacji.',
'PleaseBackup'					=> 'Proszę, <strong>zrób kopię zapasową</strong> swojej bazy danych, pliku konfiguracyjnego i wszystkich zmienionych plików, takich jak te, które mają hacki i poprawki zastosowane do nich przed rozpoczęciem procesu aktualizacji. To może zaoszczędzić Ci dużego bólu głowy.',
'LangDesc'						=> 'Wybierz język do procesu instalacji. Ten sam język będzie domyślnym językiem dla Twojej instalacji WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Wymagania systemowe',
'PhpVersion'					=> 'Wersja PHP',
'PhpDetected'					=> 'Wykryto PHP',
'ModRewrite'					=> 'Rozszerzenie Apache Przepisywanie (Opcjonalne)',
'ModRewriteInstalled'			=> 'Zainstalować rozszerzenie (mod_rewrite)?',
'Database'						=> 'Baza danych',
'PhpExtensions'					=> 'Rozszerzenia PHP',
'Permissions'					=> 'Uprawnienia',
'ReadyToInstall'				=> 'Gotowy do instalacji?',
'Requirements'					=> 'Twój serwer musi spełniać wymagania wymienione poniżej.',
'OK'							=> 'OK',
'Problem'						=> 'Problem',
'Example'						=> 'Przykład',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Wygląda na to, że w Twojej instalacji PHP brakuje wymienionych rozszerzeń PHP, które są wymagane przez WackoWiki.',
'PcreWithoutUtf8'				=> 'Wydaje się, że moduł PCRE w PHP został skompilowany bez wsparcia dla UTF‐8.',
'NotePermissions'				=> 'Instalator spróbuje zapisać dane z konfiguracji do pliku %1, umieszczonego w katalogu WackoWiki. Aby to się udało, musisz mieć pewność, że serwer posiada prawo zapisu do tego pliku! Jeżeli nie możesz tego zrobić, będziesz musiał edytować plik ręcznie (instalator powie Ci jak).<br><br>Zaglądnij na <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> po więcej informacji.',
'ErrorPermissions'				=> 'Wygląda na to, że instalator nie może automatycznie ustawić uprawnień do plików wymaganych do poprawnego działania WackoWiki.  W dalszej części procesu instalacji zostanie wyświetlony monit o ręczne skonfigurowanie wymaganych uprawnień do plików na serwerze.',
'ErrorMinPhpVersion'			=> 'Wersja PHP musi być większa niż %1. Wygląda na to, że Twój serwer ma wcześniejszą wersję. Musisz uaktualnić do najnowszej wersji PHP dla WackoWiki, aby działać poprawnie.',
'Ready'							=> 'Gratulacje, wygląda na to, że na twoim serwerze można uruchomić WackoWiki.  Na następnych stronach zostanie przeprowadzony proces konfiguracji.',

/*
   Site Config Page
*/
'config-site'					=> 'Konfiguracja Strony',
'SiteName'						=> 'Twoja nazwa Wiki',
'SiteNameDesc'					=> 'Nazwa Twojej strony Wiki.',
'SiteNameDefault'				=> 'MojaWiki',
'HomePage'						=> 'Strona główna',
'HomePageDesc'					=> 'Wpisz nazwę, którą chciałbyś, aby Twoja strona główna miała, będzie to domyślna strona, którą użytkownicy zobaczą, gdy odwiedzą Twoją witrynę i powinna to być <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="Wyświetl pomoc" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Strona główna',
'MultiLang'						=> 'Tryb Wielojęzyczny',
'MultiLangDesc'					=> 'Tryb Wielojęzyczny pozwala posiadać strony z różnymi ustawieniami językowymi za pomocą jednej instalacji. Jeżeli ten tryb jest włączony, instalator stworzy pozycje menu początkowe dla wszystkich języków dostępnych w dystrybucji.',
'AllowedLang'					=> 'Dozwolony język',
'AllowedLangDesc'				=> 'Zaleca się, aby wybrać tylko zestaw języków, które chcesz używać, w przeciwnym razie wszystkie języki zostaną wybrane.',
'AclMode'						=> 'Domyślne ustawienia ACL',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Publiczne wiki (czytaj dla każdego, napisz i komentarz dla zarejestrowanych użytkowników)',
'PrivateWiki'					=> 'Prywatne Wiki (odczyt, zapis, komentarz tylko dla zarejestrowanych użytkowników)',
'Admin'							=> 'Nazwa admina',
'AdminDesc'						=> 'Wpisz nazwę administratora. Powinna być <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">NaząWiki</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Login musi mieć min. %1, a maks. %2 znaków i składać się tylko z liter alfabetu łacińskiego oraz cyfr.',
'NameCamelCaseOnly'				=> 'Login musi mieć min. %1, a maks. %2 znaków i WikiName formatted.',
'Password'						=> 'Admina wpisz hasło',
'PasswordDesc'					=> 'Wpisz hasło dla administratora (min. %1 znaków).',
'PasswordConfirm'				=> 'Powtórz hasło:',
'Mail'							=> 'Adres e-mail administratora',
'MailDesc'						=> 'Wpisz adres e-mail administratora.',
'Base'							=> 'Podstawowy URL',
'BaseDesc'						=> 'Twój adres URL bazy WackoWiki. Nazwy stron zostaną do nich dołączone, więc jeśli używasz mod_rewrite adres powinien kończyć się przednim ukośnikiem, tj.',
'Rewrite'						=> 'Tryb Rewrite',
'RewriteDesc'					=> 'Tryb Rewrite powinien być włączony jeżeli używasz WackoWiki z nadpisywaniem URLi.',
'Enabled'						=> 'Włączony:',
'ErrorAdminEmail'				=> 'Adres e-mail administratora musi byc poprawny!',
'ErrorAdminPasswordMismatch'	=> 'Hasla sie nie zgadzaja, prosze wprowadz je ponownie!',
'ErrorAdminPasswordShort'		=> 'The admin Haslo za krotkie, prosze wprowadz je ponownie, the minimum length is %1 characters!',
'ModRewriteStatusUnknown'		=> 'Instalator nie może zweryfikować, czy mod_rewrite jest włączony, jednak nie oznacza to, że jest wyłączony.',

/*
   Database Config Page
*/
'config-database'				=> 'Konfiguracja Bazy Danych',
'DbDriver'						=> 'Kierowca',
'DbDriverDesc'					=> 'Sterownik bazy danych, którego chcesz użyć.',
'DbSqlMode'						=> 'Tryb SQL',
'DbSqlModeDesc'					=> 'Tryb SQL, którego chcesz użyć.',
'DbVendor'						=> 'Sprzedawca',
'DbVendorDesc'					=> 'Dostawca bazy danych, którego używasz.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'Zestaw znaków bazy danych, którego chcesz użyć.',
'DbEngine'						=> 'Silnik',
'DbEngineDesc'					=> 'Silnik bazy danych, którego chcesz użyć.',
'DbHost'						=> 'Host',
'DbHostDesc'					=> 'Serwer bazy danych jest uruchomiony, zazwyczaj <code>127.0.0.0.1</code> lub <code>localhost</code> (tj. ta sama maszyna, w której znajduje się WackoWiki).',
'DbPort'						=> 'Port (opcjonalnie)',
'DbPortDesc'					=> 'Numer portu, przez który Twój serwer bazy danych jest dostępny, pozostaw puste, aby użyć domyślnego numeru portu.',
'DbName'						=> 'Baza danych',
'DbNameDesc'					=> 'Baza danych, której WackoWiki powinno używać. Ta baza danych musi już istnieć, gdy będziesz kontynuować!',
'DbUser'						=> 'Nazwa użytkownika',
'DbUserDesc'					=> 'Nazwa użytkownika używanego do łączenia się z bazą danych.',
'DbPassword'					=> 'Hasło użytkownika',
'DbPasswordDesc'				=> 'Hasło użytkownika używane do łączenia się z bazą danych.',
'Prefix'						=> 'Przedrostek tabeli',
'PrefixDesc'					=> 'Przedrostek wszystkich tabeli użytych przez WackoWiki. Pozwala to uruchamiać różne instalacje WackoWiki używając tej samej bazy danych poprzez konfigurację ich, by używały różnych przedrostków tabeli (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'Nie wykryto sterownika bazy danych, proszę włączyć rozszerzenie mysqli lub pdo_mysql w pliku php.ini.',
'ErrorNoDbDriverSelected'		=> 'Nie wybrano sterownika bazy danych, proszę wybrać jeden z listy.',
'DeleteTables'					=> 'Usuwanie istniejących tabel?',
'DeleteTablesDesc'				=> 'UWAGA! Jeśli wybierzesz tę opcję, wszystkie aktualne dane wiki zostaną usunięte z bazy danych. To nie może być cofnięte, chyba że ręcznie przywrócisz dane z kopii zapasowej.',
'ConfirmTableDeletion'			=> 'Czy na pewno chcesz usunąć wszystkie obecne tabele wiki?',

/*
   Database Installation Page
*/
'install-database'				=> 'Instalacja bazy danych',
'TestingConfiguration'			=> 'Testuję Konfigurację',
'TestConnectionString'			=> 'Testuję ustawienia połączeń z database',
'TestDatabaseExists'			=> 'Sprawdzenie, czy podana baza danych istnieje',
'TestDatabaseVersion'			=> 'Sprawdzanie minimalnych wymagań wersji bazy danych',
'InstallTables'					=> 'Instalacja tabel',
'ErrorDbConnection'				=> 'Wystąpił problem z podanymi przez Ciebie danymi połączenia z bazą danych, proszę wrócić i sprawdzić, czy są one poprawne.',
'ErrorDatabaseVersion'			=> 'Wersja bazy danych to %1, ale wymaga co najmniej %2.',
'To'							=> 'na',
'AlterTable'					=> 'Zmiana tabeli %1',
'InsertRecord'					=> 'Wstawianie rekordu do tabeli %1',
'RenameTable'					=> 'Zmiana nazwy tablicy %1',
'UpdateTable'					=> 'Aktualizowanie tabeli %1',
'InstallDefaultData'			=> 'Dodawanie danych domyślnych',
'InstallPagesBegin'				=> 'Dodawanie stron domyślnych',
'InstallPagesEnd'				=> 'Zakończono dodawanie domyślnych stron',
'InstallSystemAccount'			=> 'Dodaję konto  <code>System</code>',
'InstallDeletedAccount'			=> 'Dodaję konto <code>Deleted</code>',
'InstallAdmin'					=> 'Dodaję konto administratora',
'InstallAdminSetting'			=> 'Dodaję konto administratora',
'InstallAdminGroup'				=> 'Dodanie grupy Administratorzy',
'InstallAdminGroupMember'		=> 'Dodawanie członków grupy administratorów',
'InstallEverybodyGroup'			=> 'Dodawanie Grupy Wszystkich',
'InstallModeratorGroup'			=> 'Dodawanie grupy moderatorów',
'InstallReviewerGroup'			=> 'Dodawanie grupy recenzenta',
'InstallLogoImage'				=> 'Dodawanie obrazu logo',
'LogoImage'						=> 'Obraz logo',
'InstallConfigValues'			=> 'Dodawanie wartości konfiguracji',
'ConfigValues'					=> 'Wartości konfiguracji',
'ErrorInsertPage'				=> 'Błąd podczas wstawiania strony %1',
'ErrorInsertPagePermission'		=> 'Błąd ustawiania uprawnień dla strony %1',
'ErrorInsertDefaultMenuItem'	=> 'Błąd ustawiania strony %1 jako domyślnej pozycji menu',
'ErrorPageAlreadyExists'		=> 'Strona %1 już istnieje',
'ErrorAlterTable'				=> 'Błąd zmiany tabeli %1',
'ErrorInsertRecord'				=> 'Błąd wstawiania rekordu do tabeli %1',
'ErrorRenameTable'				=> 'Błąd zmiany nazwy tablicy %1',
'ErrorUpdatingTable'			=> 'Błąd aktualizacji tabeli %1',
'CreatingTable'					=> 'Tworzę tabelę %1',
'ErrorAlreadyExists'			=> '%1 już istnieje',
'ErrorCreatingTable'			=> 'Błąd podczas tworzenia tabeli %1 , czy już istnieje?',
'DeletingTables'				=> 'Usuwanie tabel',
'DeletingTablesEnd'				=> 'Zakończono usuwanie tabel',
'ErrorDeletingTable'			=> 'Błąd podczas usuwania tabeli %1. Najbardziej prawdopodobnym powodem jest to, że tabela nie istnieje, w którym to przypadku możesz zignorować to ostrzeżenie.',
'DeletingTable'					=> 'Usuwanie tablicy %1',
'NextStep'						=> 'W następnym kroku, instalator będzie próbował zapisać zaktualizowany plik konfiguracyjny, %1.  Postaraj się, że serwer posiada prawo zapisu do pliku, w przeciwnym wypadku będziesz musiał edytować go ręcznie. Raz jeszcze, zaglądnij na  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> po więcej informacji.',

/*
   Write Config Page
*/
'write-config'					=> 'Napisz plik konfiguracyjny',
'FinalStep'						=> 'Ostatnim krokiem',
'Writing'						=> 'Zapisywanie pliku konfiguracyjnego',
'RemovingWritePrivilege'		=> 'Usuwanie przywilejów zapisu',
'InstallationComplete'			=> 'Instalacja zakończona',
'ThatsAll'						=> 'To wszystko! Możesz teraz <a href="%1">przeglądać witrynę WackoWiki</a>.',
'SecurityConsiderations'		=> 'Kwestie bezpieczeństwa',
'SecurityRisk'					=> 'Jednak, doradzamy usunięcie praw zapisu do pliku %1 po tym jak został on zapisany. Zagrożeniem dla bezpieczeństwa jest pozostawienie pliku z prawem do zapisu!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'Powinieneś usunąć katalog %1 teraz, gdy proces instalacji został zakończony.',
'ErrorGivePrivileges'			=> 'Plik konfiguracyjny %1 nie może zostać zapisany. Musisz nadać swojemu serwerowi tymczasowe prawo do zapisu do katalogu WackoWiki, lub także dla pustego pliku %1<br>%2<br><br>; nie zapomnij usunąć prawa do zapisu później, czyli <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Jeżeli, z jakiegoś powodu nie możesz tego zrobić, będziesz musiał skopiować poniższy tekst do nowego pliku i zapisać/wgrać go na server jako %1 do katalogu WackoWiki. Gdy już to zrobisz, Twoja strona WackoWiki powinna już działać. Jeżeli nie, odwiedź proszę <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Gdy już to zrobisz, Twoja strona WackoWiki powinna już działać. Jeżeli nie, odwiedź proszę <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'zapisano jako ',
'DontChange'					=> 'nie zmieniaj wacko_version ręcznie!',
'ConfigDescription'				=> 'szczegółowy opis: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Spróbuj ponownie',

];
