<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'utf-8',
'LangISO' => 'pl',
'LangName' => 'Polski',

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
'Title' => 'Instalacja WackoWiki',
'Continue' => 'Kontynuuj',
'Back' => 'Plecy',
'Recommended' => 'zalecane',
'InvalidAction' => 'Nieprawidłowe działanie',

/*
   Language Selection Page
*/
'lang' => 'Konfiguracja J&#281;zyka',
'PleaseUpgradeToR5' => 'You aware to be running an old (pre 5.0.0) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to <code class="version">5.0.x</code>.',
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <code class="version">%1</code> to <code class="version">%2</code>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <code class="version">%1</code>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Please, <strong>backup</strong> your database, config file and all changed files such as those which have hacks and patches applied to them before starting upgrade process. This can save you from big headache.',
'LangDesc' => 'Wybierz j&#281;zyk do procesu instalacji. Ten sam j&#281;zyk b&#281;dzie domy&#347;lnym j&#281;zykiem dla Twojej instalacji WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'Wymagania systemowe',
'PHPVersion' => 'PHP Version',
'PHPDetected' => 'Detected PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Extension (mod_rewrite) Installed?',
'Database' => 'Baza danych',
'PHPExtensions' => 'PHP Extensions',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Gotowy do instalacji?',
'Requirements' => 'Your server must meet the requirements listed below.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePHPExtensions' => '',
'ErrorPHPExtensions' => 'Your PHP installation appears to be missing the noted PHP extensions which are required by WackoWiki.',
'PCREwithoutUTF8' => 'PCRE is not compiled with UTF-8 support.',
'NotePermissions' => 'Instalator spr&#243;buje zapisa&#263; dane z konfiguracji do pliku %1, umieszczonego w katalogu WackoWiki. Aby to si&#281; uda&#322;o, musisz mie&#263; pewno&#347;&#263;, &#380;e serwer posiada prawo zapisu do tego pliku! Je&#380;eli nie mo&#380;esz tego zrobi&#263;, b&#281;dziesz musia&#322; edytowa&#263; plik r&#281;cznie (instalator powie Ci jak).<br><br>Zagl&#261;dnij na <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> po wi&#281;cej informacji.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPHPVersion' => 'The PHP Version must be greater than <strong>' . PHP_MIN_VERSION . '</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'site-config' => 'Konfiguracja Strony',
'SiteName' => 'Twoja nazwa Wiki',
'SiteNameDesc' => 'Nazwa Twojej strony Wiki.',
'HomePage' => 'Strona g&#322;&#243;wna',
'HomePageDesc' => 'Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault' => 'HomePage',
'MultiLang' => 'Tryb Wieloj&#281;zyczny',
'MultiLangDesc' => 'Tryb Wieloj&#281;zyczny pozwala posiada&#263; strony z r&#243;&#380;nymi ustawieniami j&#281;zykowymi za pomoc&#261; jednej instalacji. Je&#380;eli ten tryb jest w&#322;&#261;czony, instalator stworzy strony pocz&#261;tkowe dla wszystkich j&#281;zyk&#243;w dost&#281;pnych w dystrybucji.',
'AllowedLang' => 'Allowed Languages',
'AllowedLangDesc' => 'It is recomended to select only the set of languages you want to use, other wise all languages are selected.',
'Admin' => 'Nazwa admina',
'AdminDesc' => 'Wpisz nazw&#281; administratora. Powinna by&#263; <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">Naz&#261;Wiki</a> (e.g. <code>WikiAdmin</code>).',
'Password' => 'Admina wpisz has&#322;o',
'PasswordDesc' => 'Wpisz has&#322;o dla administratora (min. %1 znak&#243;w).',
'Password2' => 'Powt&#243;rz has&#322;o:',
'Mail' => 'Adres e-mail administratora',
'MailDesc' => 'Wpisz adres e-mail administratora.',
'Base' => 'Podstawowy URL',
'BaseDesc' => 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => 'Tryb Rewrite',
'RewriteDesc' => 'Tryb Rewrite powinien by&#263; w&#322;&#261;czony je&#380;eli u&#380;ywasz WackoWiki z nadpisywaniem URLi.',
'Enabled' => 'W&#322;&#261;czony:',
'ErrorAdminEmail' => 'Adres e-mail administratora musi byc poprawny!',
'ErrorAdminPasswordMismatch' => 'Hasla sie nie zgadzaja, prosze wprowadz je ponownie!',
'ErrorAdminPasswordShort' => 'The admin Haslo za krotkie, prosze wprowadz je ponownie, the minimum length is %1 characters!',
'WarningRewriteMode' => 'ATTENTION!\nYour base URL and rewrite-mode settings looks suspicious. Usually there is no ? mark in the base URL if rewrite-mode is set - but in your case there is one.\n\nTo continue with these settings click OK.\nTo return to the form and change your settings click CANCEL.\n\nIf you are about to proceed with these settings, please note that they COULD cause problems with your WackoWiki installation.',
'ModRewriteStatusUnknown' => 'The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled',

'LanguageArray'	=> [
	'bg' => 'bulgarian',
	'da' => 'danish',
	'nl' => 'dutch',
	'el' => 'greek',
	'en' => 'english',
	'et' => 'estonian',
	'fr' => 'french',
	'de' => 'german',
	'hu' => 'hungarian',
	'it' => 'italian',
	'pl' => 'polish',
	'pt' => 'portuguese',
	'ru' => 'russian',
	'es' => 'spanish',
],

/*
   Database Config Page
*/
'database-config' => 'Konfiguracja Bazy Danych',
'DBDriver' => 'Driver',
'DBDriverDesc' => 'The database driver you want to use. You must choose a legacy driver if you do not have <a href="https://secure.php.net/pdo" target="_blank">PDO</a> installed.',
'DBCharset' => 'Charset',
'DBCharsetDesc' => 'The database charset you want to use.',
'DBEngine' => 'Engine',
'DBEngineDesc' => 'The database engine you want to use.',
'DBHost' => 'Host',
'DBHostDesc' => 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DBPort' => 'Port (Optional)',
'DBPortDesc' => 'The port number your database server is accessable through, leave it blank to use the default port number.',
'DB' => 'Baza danych',
'DBDesc' => 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DBUserDesc' => 'Name of the user used to connect to your database.',
'DBUser' => 'Nazwa u&#380;ytkownika',
'DBPasswordDesc' => 'Password of the user used to connect to your database.',
'DBPassword' => 'Has&#322;o u&#380;ytkownika',
'PrefixDesc' => 'Przedrostek wszystkich tabeli u&#380;ytych przez WackoWiki. Pozwala to uruchamia&#263; r&#243;&#380;ne instalacje WackoWiki u&#380;ywaj&#261;c tej samej bazy danych poprzez konfiguracj&#281; ich, by u&#380;ywa&#322;y r&#243;&#380;nych przedrostk&#243;w tabeli (e.g. wacko_).',
'Prefix' => 'Przedrostek tabeli',
'ErrorNoDbDriverDetected' => 'No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.',
'ErrorNoDbDriverSelected' => 'No database driver has been selected, please pick one from the list.',
'DeleteTables' => 'Usuwanie istniejących tabel?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'database-install' => 'Instalacja bazy danych',
'TestingConfiguration' => 'Testuj&#281; Konfiguracj&#281;',
'TestConnectionString' => 'Testuj&#281; ustawienia po&#322;&#261;cze&#324; z database',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'InstallingTables' => 'Installing Tables',
'ErrorDBConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDBExists' => 'Baza danych, kt&#243;r&#261; wybra&#322;e&#347;, nie zosta&#322;a znaleziona. Pami&#281;taj, &#380;e musi ona istnie&#263; zanim zaczniesz instalowa&#263;/aktualizowa&#263; WackoWiki!',
'To' => 'na',
'AlterTable' => 'Altering %1 table',
'InsertRecord' => 'Inserting Record into %1 table',
'RenameTable' => 'Renaming %1 table',
'UpdateTable' => 'Updating %1 table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Dodaj&#281; konto  <code>System</code>',
'InstallingDeletedAccount' => 'Dodaj&#281; konto <code>Deleted</code>',
'InstallingAdmin' => 'Dodaj&#281; konto administratora',
'InstallingAdminSetting' => 'Dodaj&#281; konto administratora',
'InstallingAdminGroup' => 'Dodanie grupy Administratorzy',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Adding Logo Image',
'LogoImage' => 'Logo image',
'InstallingConfigValues' => 'Adding Config Values',
'ConfigValues' => 'Config Values',
'ErrorInsertingPage' => 'Error inserting %1 page',
'ErrorInsertingPagePermission' => 'Error setting permission for %1 page',
'ErrorInsertingDefaultMenuItem' => 'Error setting page %1 as default menu item',
'ErrorPageAlreadyExists' => 'The %1 page already exists',
'ErrorAlteringTable' => 'Error altering %1 table',
'ErrorInsertingRecord' => 'Error Inserting Record into %1 table',
'ErrorRenamingTable' => 'Error renaming %1 table',
'ErrorUpdatingTable' => 'Error updating %1 table',
'CreatingTable' => 'Tworz&#281; tabel&#281; %1',
'ErrorAlreadyExists' => 'The %1 already exists',
'ErrorCreatingTable' => 'Error creating %1 table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Przenosz&#281; dane to tabeli revisions',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config' => 'Napisz plik konfiguracyjny',
'FinalStep' => 'Ostatnim krokiem',
'Writing' => 'Zapisywanie pliku konfiguracyjnego',
'RemovingWritePrivilege' => 'Removing Write Privilege',
'InstallationComplete' => 'Instalacja zakończona',
'ThatsAll' => 'To wszystko! Mo&#380;esz teraz <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations' => 'Security Considerations',
'SecurityRisk' => 'Jednak, doradzamy usuni&#281;cie praw zapisu do pliku %1 po tym jak zosta&#322; on zapisany. Zagro&#380;eniem dla bezpiecze&#324;stwa jest pozostawienie pliku z prawem do zapisu!',
'RemoveSetupDirectory' => 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'Plik konfiguracyjny %1 nie mo&#380;e zosta&#263; zapisany. Musisz nada&#263; swojemu serwerowi tymczasowe prawo do zapisu do katalogu WackoWiki, lub tak&#380;e dla pustego pliku %1<br>%2<br>; nie zapomnij usun&#261;&#263; prawa do zapisu p&#243;&#378;niej, czyli %3.<br>Je&#380;eli, z jakiego&#347; powodu nie mo&#380;esz tego zrobi&#263;, b&#281;dziesz musia&#322; skopiowa&#263; poni&#380;szy tekst do nowego pliku i zapisa&#263;/wgra&#263; go na server jako %1 do katalogu WackoWiki. Gdy ju&#380; to zrobisz, Twoja strona WackoWiki powinna ju&#380; dzia&#322;a&#263;. Je&#380;eli nie, odwied&#378; prosz&#281; <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'W nast&#281;pnym kroku, instalator b&#281;dzie pr&#243;bowa&#322; zapisa&#263; zaktualizowany plik konfiguracyjny, %1.  Postaraj si&#281;, &#380;e serwer posiada prawo zapisu do pliku, w przeciwnym wypadku b&#281;dziesz musia&#322; edytowa&#263; go r&#281;cznie. Raz jeszcze, zagl&#261;dnij na  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> po wi&#281;cej informacji.',
'WrittenAt' => 'zapisano jako ',
'DontChange' => 'nie zmieniaj wacko_version r&#281;cznie!',
'ConfigDescription' => 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain' => 'Spr&#243;buj ponownie',

];
