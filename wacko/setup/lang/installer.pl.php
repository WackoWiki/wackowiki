<?php
$lang = [

/*
   Language Settings
*/
'Charset'	=> 'utf-8',
'LangISO'	=> 'pl',
'LangName'	=> 'Polski',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages
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
'Back'							=> 'Plecy',
'Recommended'					=> 'zalecane',
'InvalidAction'					=> 'Nieprawidłowe działanie',

/*
   Language Selection Page
*/
'lang'							=> 'Konfiguracja Języka',
'PleaseUpgradeToR6'				=> 'You aware to be running an old (pre %1) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to %2.',
'UpgradeFromWacko'				=> 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki %1 to %2.  The next few pages will guide you through the upgrade process.',
'FreshInstall'					=> 'Welcome to WackoWiki, you are about to install WackoWiki %1.  The next few pages will guide you through the installation process.',
'PleaseBackup'					=> 'Please, <strong>backup</strong> your database, config file and all changed files such as those which have hacks and patches applied to them before starting upgrade process. This can save you from big headache.',
'LangDesc'						=> 'Wybierz język do procesu instalacji. Ten sam język będzie domyślnym językiem dla Twojej instalacji WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Wymagania systemowe',
'PhpVersion'					=> 'PHP Version',
'PhpDetected'					=> 'Detected PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'Baza danych',
'PhpExtensions'					=> 'PHP Extensions',
'Permissions'					=> 'Permissions',
'ReadyToInstall'				=> 'Gotowy do instalacji?',
'Requirements'					=> 'Your server must meet the requirements listed below.',
'OK'							=> 'OK',
'Problem'						=> 'Problem',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Wygląda na to, że w Twojej instalacji PHP brakuje wymienionych rozszerzeń PHP, które są wymagane przez WackoWiki.',
'PcreWithoutUtf8'				=> 'Wydaje się, że moduł PCRE w PHP został skompilowany bez wsparcia dla UTF‐8.',
'NotePermissions'				=> 'Instalator spróbuje zapisać dane z konfiguracji do pliku %1, umieszczonego w katalogu WackoWiki. Aby to się udało, musisz mieć pewność, że serwer posiada prawo zapisu do tego pliku! Jeżeli nie możesz tego zrobić, będziesz musiał edytować plik ręcznie (instalator powie Ci jak).<br><br>Zaglądnij na <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> po więcej informacji.',
'ErrorPermissions'				=> 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPhpVersion'			=> 'The PHP Version must be greater than <strong>' . PHP_MIN_VERSION . '</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready'							=> 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'config-site'					=> 'Konfiguracja Strony',
'SiteName'						=> 'Twoja nazwa Wiki',
'SiteNameDesc'					=> 'Nazwa Twojej strony Wiki.',
'SiteNameDefault'				=> 'MojaWiki',
'HomePage'						=> 'Strona główna',
'HomePageDesc'					=> 'Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'HomePage',
'MultiLang'						=> 'Tryb Wielojęzyczny',
'MultiLangDesc'					=> 'Tryb Wielojęzyczny pozwala posiadać strony z różnymi ustawieniami językowymi za pomocą jednej instalacji. Jeżeli ten tryb jest włączony, instalator stworzy pozycje menu początkowe dla wszystkich języków dostępnych w dystrybucji.',
'AllowedLang'					=> 'Allowed Languages',
'AllowedLangDesc'				=> 'It is recommended to select only the set of languages you want to use, other wise all languages are selected.',
'Admin'							=> 'Nazwa admina',
'AdminDesc'						=> 'Wpisz nazwę administratora. Powinna być <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">NaząWiki</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Login musi mieć min. %1, a maks. %2 znaków i składać się tylko z liter alfabetu łacińskiego oraz cyfr.',
'NameCamelCaseOnly'				=> 'Login musi mieć min. %1, a maks. %2 znaków i WikiName formatted.',
'Password'						=> 'Admina wpisz hasło',
'PasswordDesc'					=> 'Wpisz hasło dla administratora (min. %1 znaków).',
'Password2'						=> 'Powtórz hasło:',
'Mail'							=> 'Adres e-mail administratora',
'MailDesc'						=> 'Wpisz adres e-mail administratora.',
'Base'							=> 'Podstawowy URL',
'BaseDesc'						=> 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Tryb Rewrite',
'RewriteDesc'					=> 'Tryb Rewrite powinien być włączony jeżeli używasz WackoWiki z nadpisywaniem URLi.',
'Enabled'						=> 'Włączony:',
'ErrorAdminEmail'				=> 'Adres e-mail administratora musi byc poprawny!',
'ErrorAdminPasswordMismatch'	=> 'Hasla sie nie zgadzaja, prosze wprowadz je ponownie!',
'ErrorAdminPasswordShort'		=> 'The admin Haslo za krotkie, prosze wprowadz je ponownie, the minimum length is %1 characters!',
'ModRewriteStatusUnknown'		=> 'The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled',

'LanguageArray'	=> [
	'bg' => 'Български',
	'da' => 'Dansk',
	'de' => 'Deutsch',
	'el' => 'Ελληνικά',
	'en' => 'English',
	'es' => 'Español',
	'et' => 'Eesti',
	'fr' => 'Français',
	'hu' => 'Magyar',
	'it' => 'Italiano',
	'ja' => '日本語',
	'ko' => '한국어',
	'nl' => 'Nederlands',
	'pl' => 'Polski',
	'pt' => 'Português',
	'ru' => 'Русский',
	'zh' => '简体中文',
	'zh-tw' => '正體中文',
],

/*
   Database Config Page
*/
'config-database'				=> 'Konfiguracja Bazy Danych',
'DbDriver'						=> 'Driver',
'DbDriverDesc'					=> 'The database driver you want to use. You must choose a legacy driver if you do not have <a href="https://secure.php.net/pdo" target="_blank">PDO</a> installed.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'The database charset you want to use.',
'DbEngine'						=> 'Engine',
'DbEngineDesc'					=> 'The database engine you want to use.',
'DbHost'						=> 'Host',
'DbHostDesc'					=> 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort'						=> 'Port (Optional)',
'DbPortDesc'					=> 'The port number your database server is accessible through, leave it blank to use the default port number.',
'Db'							=> 'Baza danych',
'DbDesc'						=> 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DbUserDesc'					=> 'Name of the user used to connect to your database.',
'DbUser'						=> 'Nazwa użytkownika',
'DbPasswordDesc'				=> 'Password of the user used to connect to your database.',
'DbPassword'					=> 'Hasło użytkownika',
'PrefixDesc'					=> 'Przedrostek wszystkich tabeli użytych przez WackoWiki. Pozwala to uruchamiać różne instalacje WackoWiki używając tej samej bazy danych poprzez konfigurację ich, by używały różnych przedrostków tabeli (e.g. wacko_).',
'Prefix'						=> 'Przedrostek tabeli',
'ErrorNoDbDriverDetected'		=> 'No database driver has been detected, please enable either the mysqli or pdo_mysql extension in your php.ini file.',
'ErrorNoDbDriverSelected'		=> 'No database driver has been selected, please pick one from the list.',
'DeleteTables'					=> 'Usuwanie istniejących tabel?',
'DeleteTablesDesc'				=> 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion'			=> 'Czy na pewno chcesz usunąć wszystkie obecne tabele wiki?',

/*
   Database Installation Page
*/
'install-database'				=> 'Instalacja bazy danych',
'TestingConfiguration'			=> 'Testuję Konfigurację',
'TestConnectionString'			=> 'Testuję ustawienia połączeń z database',
'TestDatabaseExists'			=> 'Checking if the database you specified exists',
'TestDatabaseVersion'			=> 'Checking database minimum version requirements',
'InstallTables'					=> 'Installing Tables',
'ErrorDbConnection'				=> 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDbExists'					=> 'Baza danych, którą wybrałeś, nie została znaleziona. Pamiętaj, że musi ona istnieć zanim zaczniesz instalować/aktualizować WackoWiki!',
'ErrorDatabaseVersion'			=> 'The database version is %1 but requires at least %2.',
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
'ThatsAll'						=> 'To wszystko! Możesz teraz <a href="%1">view your WackoWiki site</a>.',
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
