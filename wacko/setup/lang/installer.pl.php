<?php
$lang = [

/*
   Language Settings
*/
'Charset'		=> 'utf-8',
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
	'login_page'		=> 'Login',
	'account_page'		=> 'Ustawienia',
	'registration_page'	=> 'Rejestracja',
	'password_page'		=> 'Hasło',

	'changes_page'		=> 'OstatnieZmiany',
	'comments_page'		=> 'OstatnioKomentowane',
	'index_page'		=> 'IndexStron',

	'random_page'		=> 'LosowąStrona',
	#'help_page'			=> 'Pomoc',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',

	// time
	#'date_format'					=> 'd.m.Y',
	#'time_format'					=> 'H:i',
	#'time_format_seconds'			=> 'H:i:s',
],

/*
   Generic Page Text
*/
'Title'							=> 'Instalacja WackoWiki',
'Continue'						=> 'Kontynuuj',
'Back'							=> 'Wstecz',
'Recommended'					=> 'zalecane',
'InvalidAction'					=> 'Nieprawidłowe działanie',

/*
   Language Selection Page
*/
'lang'							=> 'Konfiguracja Języka',
'PleaseUpgradeToR6'				=> 'Używana jest stara (sprzed %1) wersja WackoWiki (%1). Aby zaktualizować WackoWiki do nowej wersji, należy najpierw zaktualizować instalację do wersji %2.',
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
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'Baza danych',
'PhpExtensions'					=> 'PHP Extensions',
'Permissions'					=> 'Uprawnienia',
'ReadyToInstall'				=> 'Gotowy do instalacji?',
'Requirements'					=> 'Twój serwer musi spełniać wymagania wymienione poniżej.',
'OK'							=> 'OK',
'Problem'						=> 'Problem',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Wygląda na to, że w Twojej instalacji PHP brakuje wymienionych rozszerzeń PHP, które są wymagane przez WackoWiki.',
'PcreWithoutUtf8'				=> 'Wydaje się, że moduł PCRE w PHP został skompilowany bez wsparcia dla UTF‐8.',
'NotePermissions'				=> 'Instalator spróbuje zapisać dane z konfiguracji do pliku %1, umieszczonego w katalogu WackoWiki. Aby to się udało, musisz mieć pewność, że serwer posiada prawo zapisu do tego pliku! Jeżeli nie możesz tego zrobić, będziesz musiał edytować plik ręcznie (instalator powie Ci jak).<br><br>Zaglądnij na <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> po więcej informacji.',
'ErrorPermissions'				=> 'Wygląda na to, że instalator nie może automatycznie ustawić uprawnień do plików wymaganych do poprawnego działania WackoWiki.  W dalszej części procesu instalacji zostanie wyświetlony monit o ręczne skonfigurowanie wymaganych uprawnień do plików na serwerze.',
'ErrorMinPhpVersion'			=> 'Wersja PHP musi być większa niż <strong>' . PHP_MIN_VERSION . '</strong>, wygląda na to, że Twój serwer działa na wcześniejszej wersji.  Aby WackoWiki działało poprawnie, należy zaktualizować go do nowszej wersji PHP.',
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
'HomePageDefault'				=> 'HomePage',
'MultiLang'						=> 'Tryb Wielojęzyczny',
'MultiLangDesc'					=> 'Tryb Wielojęzyczny pozwala posiadać strony z różnymi ustawieniami językowymi za pomocą jednej instalacji. Jeżeli ten tryb jest włączony, instalator stworzy pozycje menu początkowe dla wszystkich języków dostępnych w dystrybucji.',
'AllowedLang'					=> 'Allowed Languages',
'AllowedLangDesc'				=> 'Zaleca się, aby wybrać tylko zestaw języków, które chcesz używać, w przeciwnym razie wszystkie języki zostaną wybrane.',
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
'BaseDesc'						=> 'Your WackoWiki site base URL. Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>https://example.com/</code></strong></li><li><strong><code>https://example.com/wiki/</code></strong></li></ul>',
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
'DbDriver'						=> 'Driver',
'DbDriverDesc'					=> 'The database driver you want to use.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'The database charset you want to use.',
'DbEngine'						=> 'Engine',
'DbEngineDesc'					=> 'The database engine you want to use.',
'DbHost'						=> 'Host',
'DbHostDesc'					=> 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort'						=> 'Port (Optional)',
'DbPortDesc'					=> 'Numer portu, przez który Twój serwer bazy danych jest dostępny, pozostaw puste, aby użyć domyślnego numeru portu.',
'DbName'						=> 'Baza danych',
'DbNameDesc'					=> 'Baza danych, której WackoWiki powinno używać. Ta baza danych musi już istnieć, gdy będziesz kontynuować!',
'DbUser'						=> 'Nazwa użytkownika',
'DbUserDesc'					=> 'Name of the user used to connect to your database.',
'DbPassword'					=> 'Hasło użytkownika',
'DbPasswordDesc'				=> 'Password of the user used to connect to your database.',
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
'InstallTables'					=> 'Installing Tables',
'ErrorDbConnection'				=> 'Wystąpił problem z podanymi przez Ciebie danymi połączenia z bazą danych, proszę wrócić i sprawdzić, czy są one poprawne.',
'ErrorDbExists'					=> 'Baza danych, którą wybrałeś, nie została znaleziona. Pamiętaj, że musi ona istnieć zanim zaczniesz instalować/aktualizować WackoWiki!',
'ErrorDatabaseVersion'			=> 'Wersja bazy danych to %1, ale wymaga co najmniej %2.',
'To'							=> 'na',
'AlterTable'					=> 'Altering %1 table',
'InsertRecord'					=> 'Inserting Record into %1 table',
'RenameTable'					=> 'Renaming %1 table',
'UpdateTable'					=> 'Updating %1 table',
'InstallDefaultData'			=> 'Adding Default Data',
'InstallPagesBegin'				=> 'Adding Default Pages',
'InstallPagesEnd'				=> 'Finished Adding Default Pages',
'InstallSystemAccount'			=> 'Dodaję konto  <code>System</code>',
'InstallDeletedAccount'			=> 'Dodaję konto <code>Deleted</code>',
'InstallAdmin'					=> 'Dodaję konto administratora',
'InstallAdminSetting'			=> 'Dodaję konto administratora',
'InstallAdminGroup'				=> 'Dodanie grupy Administratorzy',
'InstallAdminGroupMember'		=> 'Adding Admins Group Member',
'InstallEverybodyGroup'			=> 'Adding Everybody Group',
'InstallModeratorGroup'			=> 'Adding Moderator Group',
'InstallReviewerGroup'			=> 'Adding Reviewer Group',
'InstallLogoImage'				=> 'Adding Logo Image',
'LogoImage'						=> 'Logo image',
'InstallConfigValues'			=> 'Adding Config Values',
'ConfigValues'					=> 'Config Values',
'ErrorInsertPage'				=> 'Error inserting %1 page',
'ErrorInsertPagePermission'		=> 'Error setting permission for %1 page',
'ErrorInsertDefaultMenuItem'	=> 'Error setting page %1 as default menu item',
'ErrorPageAlreadyExists'		=> 'The %1 page already exists',
'ErrorAlterTable'				=> 'Error altering %1 table',
'ErrorInsertRecord'				=> 'Error Inserting Record into %1 table',
'ErrorRenameTable'				=> 'Error renaming %1 table',
'ErrorUpdatingTable'			=> 'Error updating %1 table',
'CreatingTable'					=> 'Tworzę tabelę %1',
'ErrorAlreadyExists'			=> 'The %1 already exists',
'ErrorCreatingTable'			=> 'Error creating %1 table, does it already exist?',
'DeletingTables'				=> 'Deleting Tables',
'DeletingTablesEnd'				=> 'Finished Deleting Tables',
'ErrorDeletingTable'			=> 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable'					=> 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config'					=> 'Napisz plik konfiguracyjny',
'FinalStep'						=> 'Ostatnim krokiem',
'Writing'						=> 'Zapisywanie pliku konfiguracyjnego',
'RemovingWritePrivilege'		=> 'Removing Write Privilege',
'InstallationComplete'			=> 'Instalacja zakończona',
'ThatsAll'						=> 'To wszystko! Możesz teraz <a href="%1">przeglądać witrynę WackoWiki</a>.',
'SecurityConsiderations'		=> 'Security Considerations',
'SecurityRisk'					=> 'Jednak, doradzamy usunięcie praw zapisu do pliku %1 po tym jak został on zapisany. Zagrożeniem dla bezpieczeństwa jest pozostawienie pliku z prawem do zapisu!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges'			=> 'Plik konfiguracyjny %1 nie może zostać zapisany. Musisz nadać swojemu serwerowi tymczasowe prawo do zapisu do katalogu WackoWiki, lub także dla pustego pliku %1<br>%2<br>; nie zapomnij usunąć prawa do zapisu później, czyli %3.<br>Jeżeli, z jakiegoś powodu nie możesz tego zrobić, będziesz musiał skopiować poniższy tekst do nowego pliku i zapisać/wgrać go na server jako %1 do katalogu WackoWiki. Gdy już to zrobisz, Twoja strona WackoWiki powinna już działać. Jeżeli nie, odwiedź proszę <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep'						=> 'W następnym kroku, instalator będzie próbował zapisać zaktualizowany plik konfiguracyjny, %1.  Postaraj się, że serwer posiada prawo zapisu do pliku, w przeciwnym wypadku będziesz musiał edytować go ręcznie. Raz jeszcze, zaglądnij na  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> po więcej informacji.',
'WrittenAt'						=> 'zapisano jako ',
'DontChange'					=> 'nie zmieniaj wacko_version ręcznie!',
'ConfigDescription'				=> 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Spróbuj ponownie',

];
