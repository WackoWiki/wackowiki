<?php
$lang = array(

/*
   Language Settings
*/
'Charset' => 'iso-8859-2',
'LangISO' => 'pl',
'LangName' => 'Polski',

/*
   Generic Page Text
*/
'Title' => 'Instalacja WackoWiki',
'Continue' => 'Kontynuuj',
'Back' => 'Back',

/*
   Language Selection Page
*/
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <tt>%1</tt> to <tt>%2</tt>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <tt>%1</tt>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Please, backup your database, config file and all changed files such as those which have hacks and patches applied to them before starting upgrade process. This can save you from big headache.',
'Lang' => 'Konfiguracja J&#281;zyka',
'LangDesc' => 'Wybierz j&#281;zyk do procesu instalacji. Ten sam j&#281;zyk b&#281;dzie domy&#347;lnym j&#281;zykiem dla Twojej instalacji WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'System Requirements',
'PHPVersion' => 'PHP Version',
'PHPDetected' => 'Detected PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Extension (mod_rewrite) Installed?',
'Database' => 'Database',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Ready to Install?',
'Requirements' => 'Your server must meet the requirements listed below.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePermissions' => 'Instalator spr&#243;buje zapisa&#263; dane z konfiguracji do pliku <tt>config.php</tt>, umieszczonego w katalogu WackoWiki. Aby to si&#281; uda&#322;o, musisz mie&#263; pewno&#347;&#263;, &#380;e serwer posiada prawo zapisu do tego pliku! Je&#380;eli nie mo&#380;esz tego zrobi&#263;, b&#281;dziesz musia&#322; edytowa&#263; plik r&#281;cznie (instalator powie Ci jak).<br /><br />Zagl&#261;dnij na <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> po wi&#281;cej informacji.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPHPVersion' => 'The PHP Version must be greater than <strong>5.2.0</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'site-config' => 'Konfiguracja Strony',
'Name' => 'Twoja nazwa WackoWiki',
'NameDesc' => 'Nazwa Twojej strony WackoWiki. Przewa&#380;nie jest to NazwaWiki i wygl&#261;da JakCosTakiego. <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'Home' => 'Strona g&#322;&#243;wna',
'HomeDesc' => 'Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomeDefault' => 'HomePage',
'MultiLang' => 'Tryb Wieloj&#281;zyczny',
'MultiLangDesc' => 'Tryb Wieloj&#281;zyczny pozwala posiada&#263; strony z r&#243;&#380;nymi ustawieniami j&#281;zykowymi za pomoc&#261; jednej instalacji. Je&#380;eli ten tryb jest w&#322;&#261;czony, instalator stworzy strony pocz&#261;tkowe dla wszystkich j&#281;zyk&#243;w dost&#281;pnych w dystrybucji.',
'Admin' => 'Nazwa admina',
'AdminDesc' => 'Wpisz nazw&#281; administratora. Powinna by&#263; <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">Naz&#261;Wiki</a> (e.g. WikiAdmin).',
'Password' => 'Admina wpisz has&#322;o',
'PasswordDesc' => 'Wpisz has&#322;o dla administratora (min. 8 znak&#243;w).',
'Password2' => 'Powt&#243;rz has&#322;o:',
'Mail' => 'Adres e-mail administratora',
'MailDesc' => 'Enter the admins email address.',
'Base' => 'Podstawowy URL',
'BaseDesc' => 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><b><i>http://wackowiki.org/</i></b></li><li><b><i>http://wackowiki.org/wiki/</i></b></li></ul>',
'Rewrite' => 'Tryb Rewrite',
'RewriteDesc' => 'Tryb Rewrite powinien by&#263; w&#322;&#261;czony je&#380;eli u&#380;ywasz WackoWiki z nadpisywaniem URLi.',
'Enabled' => 'W&#322;&#261;czony:',
'ErrorAdminName' => 'NazwaWiki dla administratora musi byc poprawna!',
'ErrorAdminEmail' => 'Adres e-mail administratora musi byc poprawny!',
'ErrorAdminPasswordMismatch' => 'Hasla sie nie zgadzaja, prosze wprowadz je ponownie!',
'ErrorAdminPasswordShort' => 'The admin Haslo za krotkie, prosze wprowadz je ponownie, the minimum length is 8 characters!',
'WarningRewriteMode' => 'ATTENTION!\nYour base URL and rewrite-mode settings looks suspicious. Usually there is no ? mark in the base URL if rewrite-mode is set - but in your case there is one.\n\nTo continue with these settings click OK.\nTo return to the form and change your settings click CANCEL.\n\nIf you are about to proceed with these settings, please note that they COULD cause problems with your WackoWiki installation.',
'ModRewriteStatusUnknown' => 'The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled',

/*
   Database Config Page
*/
'database-config' => 'Konfiguracja Bazy Danych',
'DBDriverDesc' => 'The database driver you want to use.  You must choose a legacy driver if you do not have PHP5.1 (or greater) and <a href="http://de2.php.net/pdo" target="_blank">PDO</a> installed.',
'DBDriver' => 'Driver',
'DBHost' => 'Host',
'DBHostDesc' => 'The host your database server is running on. Usually "localhost" (ie, the same machine your WackoWiki site is on).',
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
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'database-install' => 'Database Installation',
'TestingConfiguration' => 'Testuj&#281; Konfiguracj&#281;',
'TestConnectionString' => 'Testuj&#281; ustawienia po&#322;&#261;cze&#324; z database',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'InstallingTables' => 'Installing Tables',
'ErrorDBConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDBExists' => 'Baza danych, kt&#243;r&#261; wybra&#322;e&#347;, nie zosta&#322;a znaleziona. Pami&#281;taj, &#380;e musi ona istnie&#263; zanim zaczniesz instalowa&#263;/aktualizowa&#263; WackoWiki!',
'To' => 'na',
'AlterTable' => 'Altering <tt>%1</tt> Table',
'RenameTable' => 'Renaming <tt>%1</tt> Table',
'UpdateTable' => 'Updating <tt>%1</tt> Table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Adding System User',
'InstallingAdmin' => 'Dodaj&#281; konto administratora',
'InstallingAdminSetting' => 'Dodaj&#281; konto administratora',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingRegisteredGroup' => 'Adding Registered Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Adding Logo Image',
'InstallingConfigValues' => 'Adding Config Values',
'ErrorInsertingPage' => 'Error inserting <tt>%1</tt> page',
'ErrorInsertingPageReadPermission' => 'Error setting read permission for <tt>%1</tt> page',
'ErrorInsertingPageWritePermission' => 'Error setting write permission for <tt>%1</tt> page',
'ErrorInsertingPageCommentPermission' => 'Error setting comment permissions for <tt>%1</tt> page',
'ErrorInsertingPageCreatePermission' => 'Error setting create permissions for <tt>%1</tt> page',
'ErrorInsertingPageUploadPermission' => 'Error setting upload permissions for <tt>%1</tt> page',
'ErrorInsertingDefaultBookmark' => 'Error setting page <tt>%1</tt> as default bookmark',
'ErrorPageAlreadyExists' => 'The <tt>%1</tt> page already exists',
'ErrorAlteringTable' => 'Error altering <tt>%1</tt> table',
'ErrorRenamingTable' => 'Error renaming <tt>%1</tt> table',
'ErrorUpdatingTable' => 'Error updating <tt>%1</tt> table',
'CreatingTable' => 'Tworz&#281; tabel&#281; <tt>%1</tt>',
'ErrorAlreadyExists' => 'The <tt>%1</tt> already exists',
'ErrorCreatingTable' => 'Error creating <tt>%1</tt> table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Przenosz&#281; dane to tabeli revisions',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting <tt>%1</tt> table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting <tt>%1</tt> table',

/*
   Write Config Page
*/
'write-config' => 'Write Config File',
'FinalStep' => 'Final Step',
'Writing' => 'Zapisywanie pliku konfiguracyjnego',
'RemovingWritePrivilege' => 'Removing Write Privilege',
'InstallationComplete' => 'Installation Complete',
'ThatsAll' => 'To wszystko! Mo&#380;esz teraz <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations' => 'Security Considerations',
'SecurityRisk' => 'Jednak, doradzamy usuni&#281;cie praw zapisu do pliku <tt>config.php</tt> po tym jak zosta&#322; on zapisany. Zagro&#380;eniem dla bezpiecze&#324;stwa jest pozostawienie pliku z prawem do zapisu!',
'RemoveSetupDirectory' => 'You should delete the "setup" directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'Plik konfiguracyjny <tt>%1</tt> nie mo&#380;e zosta&#263; zapisany. Musisz nada&#263; swojemu serwerowi tymczasowe prawo do zapisu do katalogu WackoWiki, lub tak&#380;e dla pustego pliku <tt>config.php</tt> (<tt>touch config.php ; chmod 666 config.php</tt>; nie zapomnij usun&#261;&#263; prawa do zapisu p&#243;&#378;niej, czyli <tt>chmod 644 config.php</tt>). Je&#380;eli, z jakiego&#347; powodu nie mo&#380;esz tego zrobi&#263;, b&#281;dziesz musia&#322; skopiowa&#263; poni&#380;szy tekst do nowego pliku i zapisa&#263;/wgra&#263; go na server jako <tt>config.php</tt> do katalogu WackoWiki. Gdy ju&#380; to zrobisz, Twoja strona WackoWiki powinna ju&#380; dzia&#322;a&#263;. Je&#380;eli nie, odwied&#378; prosz&#281; <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'W nast&#281;pnym kroku, instalator b&#281;dzie pr&#243;bowa&#322; zapisa&#263; zaktualizowany plik konfiguracyjny, <tt>config.php</tt>.  Postaraj si&#281;, &#380;e serwer posiada prawo zapisu do pliku, w przeciwnym wypadku b&#281;dziesz musia&#322; edytowa&#263; go r&#281;cznie. Raz jeszcze, zagl&#261;dnij na  <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> po wi&#281;cej informacji.',
'WrittenAt' => 'zapisano jako ',
'DontChange' => 'nie zmieniaj wacko_version r&#281;cznie!',
'ConfigDescription' => 'detailed description http://wackowiki.org/Doc/English/Configuration',
'TryAgain' => 'Spr&#243;buj ponownie',
'RemoveWakkaConfigFile' => 'WackoWiki uses a newer config file than your previous WakkaWiki installation.  The old file could not be automatically removed by the system and so it is recommended that you manually delete the file <tt>wakka.config.php</tt>.',
'DeletingWakkaConfigFile' => 'Deleting Obsolete Wakka Configuration File',

);
?>