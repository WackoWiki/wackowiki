<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'utf-8',
'LangISO' => 'it',
'LangName' => 'Italian',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages
	'category_page'		=> 'Category',
	'groups_page'		=> 'Groups',
	'users_page'		=> 'Utenti',

	'search_page'		=> 'Ricerca',
	'login_page'		=> 'Connessione',
	'account_page'		=> 'Preferenze',
	'registration_page'	=> 'Registrazione',
	'password_page'		=> 'Password',

	'changes_page'		=> 'UltimeModifiche',
	'comments_page'		=> 'UltimiCommenti',
	'index_page'		=> 'IndicePagine',

	'random_page'		=> 'RandomPage',
	#'help_page'			=> 'Help',
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
'Title' => 'Installazione di WackoWiki',
'Continue' => 'Continua',
'Back' => 'Back',
'Recommended' => 'raccomandato',
'InvalidAction' => 'Invalid action',

/*
   Language Selection Page
*/
'lang' => 'Configurazione della lingua',
'PleaseUpgradeToR5' => 'You aware to be running an old (pre %1) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to <code class="version">%2</code>.',
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <code class="version">%1</code> to <code class="version">%2</code>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <code class="version">%1</code>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Please, <strong>backup</strong> your database, config file and all changed files such as those which have hacks and patches applied to them before starting upgrade process. This can save you from big headache.',
'LangDesc' => 'Scegli una lingua per il processo d\'installazione: la stessa sarà installata come lingua di default nel tuo WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'System Requirements',
'PhpVersion' => 'PHP Version',
'PhpDetected' => 'Detected PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Extension (mod_rewrite) Installed?',
'Database' => 'Database',
'PhpExtensions' => 'PHP Extensions',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Ready to Install?',
'Requirements' => 'Your server must meet the requirements listed below.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePhpExtensions' => '',
'ErrorPhpExtensions' => 'Your PHP installation appears to be missing the noted PHP extensions which are required by WackoWiki.',
'PcreWithoutUtf8' => 'PCRE is not compiled with UTF-8 support.',
'NotePermissions' => 'Questo installatore  tenterà di scrivere i dati di configurazione nel file %1, presente nella tua directory WackoWiki. Per gestire al meglio questa operazione, devi assicurarti che il server del tuo sito sia accessibile alla scrittura per questo file! Se non puoi farlo, dovrai editare il file manualmente (l\'installatore ti dirà come farlo).<br><br>Vedi <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> per i dettagli.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPhpVersion' => 'The PHP Version must be greater than <strong>' . PHP_MIN_VERSION . '</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'config-site' => 'Configurazione di sito',
'SiteName' => 'Tuo nome Wiki',
'SiteNameDesc' => 'Il nome del tuo sito Wiki.',
'HomePage' => 'Home Page',
'HomePageDesc' => 'La tua homepage WackoWiki. Deve essere un <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">NomeWiki</a>.',
'HomePageDefault' => 'HomePage',
'MultiLang' => 'Multi Language Mode',
'MultiLangDesc' => 'La modalità multilingua permette di avere pagine con impostazioni linguistiche diverse all\'interno di una singola installazione. Se questa modalità è abilitata, l\'installatore creerà le voci di menu iniziali per tutte le lingue disponibili nella distribuzione.',
'AllowedLang' => 'Allowed Languages',
'AllowedLangDesc' => 'It is recommended to select only the set of languages you want to use, other wise all languages are selected.',
'Admin' => 'Nome dell\'amministratore',
'AdminDesc' => 'Immetti username dell\'amministratore (dovrà essere un <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>) (e.g. <code>WikiAdmin</code>).',
'Password' => 'Admin Password',
'PasswordDesc' => 'Scegli una password per amministratore (almeno %1 caratteri)',
'Password2' => 'Ripeti password:',
'Mail' => 'Email dell\'amministratore.',
'MailDesc' => 'Enter the admins email address.',
'Base' => 'URL di base',
'BaseDesc' => 'La tua URL di base per il sito WackoWiki. I nomi di pagina sono stati aggiunti, ora sarà incluso l\'oggetto-parametro "?page=" se la modalità di riscrittura di URL non funziona sul tuo server. <ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => 'Modalità Rewrite',
'RewriteDesc' => 'La modalità Rewrite sarà attivata se si sta usando WackoWiki per la riscrittura d\'URL.',
'Enabled' => 'Attivato:',
'ErrorAdminEmail' => 'Devi immettere un indirizzo email valido!',
'ErrorAdminPasswordMismatch' => 'Le password non coincidono, reimmetti password!',
'ErrorAdminPasswordShort' => 'The admin Password troppo corta, reimmetti un\'altra, the minimum length is %1 characters!',
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
'config-database' => 'Configurazione del database',
'DbDriver' => 'Driver',
'DbDriverDesc' => 'The database driver you want to use. You must choose a legacy driver if you do not have <a href="https://secure.php.net/pdo" target="_blank">PDO</a> installed.',
'DbCharset' => 'Charset',
'DbCharsetDesc' => 'The database charset you want to use.',
'DbEngine' => 'Engine',
'DbEngineDesc' => 'The database engine you want to use.',
'DbHost' => 'Host',
'DbHostDesc' => 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort' => 'Port (Optional)',
'DbPortDesc' => 'The port number your database server is accessible through, leave it blank to use the default port number.',
'Db' => 'Database Name',
'DbDesc' => 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DbUserDesc' => 'Name of the user used to connect to your database.',
'DbUser' => 'Nome utente',
'DbPasswordDesc' => 'Password of the user used to connect to your database.',
'DbPassword' => 'Immetti password',
'PrefixDesc' => 'Prefisso di tutte le tabelle usate da WackoWiki. Questo ti permette di disporre di più installazioni WackoWiki che utilizzano lo stesso database configurandolo all\'impiego dei diversi prefissi di tabella (e.g. wacko_).',
'Prefix' => 'Prefisso di tabella',
'ErrorNoDbDriverDetected' => 'No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.',
'ErrorNoDbDriverSelected' => 'No database driver has been selected, please pick one from the list.',
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'install-database' => 'Database Installation',
'TestingConfiguration' => 'Test della configurazione',
'TestConnectionString' => 'Prova i parametri di connessione database',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'TestDatabaseVersion' => 'Checking database minimum version requirements',
'InstallingTables' => 'Installing Tables',
'ErrorDbConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDbExists' => 'Il database da te configurato non è stato trovato. Ricorda che deve esistere prima di installare o aggiornare WackoWiki!',
'ErrorDatabaseVersion' => 'The database version is %1 but requires at least %2.',
'To' => 'a',
'AlterTable' => 'Altering %1 table',
'InsertRecord' => 'Inserting Record into %1 table',
'RenameTable' => 'Renaming %1 table',
'UpdateTable' => 'Updating %1 table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Aggiunge utente <code>System</code>',
'InstallingDeletedAccount' => 'Aggiunge utente <code>Deleted</code>',
'InstallingAdmin' => 'Aggiunge utente-amministratore',
'InstallingAdminSetting' => 'Aggiunge utente-amministratore',
'InstallingAdminGroup' => 'Adding Admins Group',
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
'CreatingTable' => 'Creazione di %1 tabella/e',
'ErrorAlreadyExists' => 'The %1 already exists',
'ErrorCreatingTable' => 'Error creating %1 table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Trasferimento di dati alla tabella di revisione',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config' => 'Write Config File',
'FinalStep' => 'Final Step',
'Writing' => 'Scrittura del file di configurazione',
'RemovingWritePrivilege' => 'Removing Write Privilege',
'InstallationComplete' => 'Installazione completata',
'ThatsAll' => 'È tutto! Adesso puoi <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations' => 'Security Considerations',
'SecurityRisk' => 'Infine, ti consigliamo di escludere l\'opzione di scrittura su %1 ora che è stata scritta. Lasciare il file aperto alla scrittura è un rischio per la tua sicurezza!<br>i.e. %2',
'RemoveSetupDirectory' => 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'Il file di configurazione %1 non si è potuto scrivere. Si dovrà rendere temporaneamente accessibile alla scrittura il tuo server e la tua directory WackoWiki, o un file vuoto col nome di %1<br>%2<br>; don\'t forget to remove write access again later, i.e. %3.<br>Se, per qualche motivo, non puoi farlo, dovrai copiare il testo in basso in un nuovo file e salvarlo/immetterlo come %1 nella directory WackoWiki. Ciò fatto, il tuo sito WackoWiki è pronto per funzionare. Altrimenti, visita <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'Nel passo successivo, l\'installatore tenterà di scrivere il nuovo file di configurazione, %1. Verifica che il server del web abbia accesso alla scrittura sul file, o che tu possa editarlo manualmente.  Ancora una volta, consulta  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> per i dettagli.',
'WrittenAt' => 'scritto a ',
'DontChange' => 'non modificare manualmente la wacko_version!',
'ConfigDescription' => 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain' => 'Riprova',

];
