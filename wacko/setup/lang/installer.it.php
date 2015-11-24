<?php
$lang = array(

/*
   Language Settings
*/
'Charset' => 'iso-8859-1',
'LangISO' => 'it',
'LangName' => 'Italian',

/*
   Generic Page Text
*/
'Title' => 'Installazione di WackoWiki',
'Continue' => 'Continua',
'Back' => 'Back',
'Recommended' => 'raccomandato',

/*
   Language Selection Page
*/
'lang' => 'Configurazione della lingua',
'PleaseUpgradeToR5' => 'You aware to be running an old (pre 5.0.0) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to <code class="version">5.0.x</code>.',
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <code class="version">%1</code> to <code class="version">%2</code>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <code class="version">%1</code>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Please, backup your database, config file and all changed files such as those which have hacks and patches applied to them before starting upgrade process. This can save you from big headache.',
'LangDesc' => 'Scegli una lingua per il processo d\'installazione: la stessa sar� installata come lingua di default nel tuo WackoWiki.',

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
'NotePermissions' => 'Questo installatore  tenter� di scrivere i dati di configurazione nel file <code>config.php</code>, presente nella tua directory WackoWiki. Per gestire al meglio questa operazione, devi assicurarti che il server del tuo sito sia accessibile alla scrittura per questo file! Se non puoi farlo, dovrai editare il file manualmente (l\'installatore ti dir� come farlo).<br /><br />Vedi <a href="http://wackowiki.sourceforge.net/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> per i dettagli.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPHPVersion' => 'The PHP Version must be greater than <strong>'.PHP_MIN_VERSION.'</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'site-config' => 'Configurazione di sito',
'Name' => 'Tuo nome WackoWiki',
'NameDesc' => 'Il nome del tuo sito WackoWiki. � di norma un NomeWiki e somiglia a QualcosaComeQuesto. <a href="http://wackowiki.sourceforge.net/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'Home' => 'Home Page',
'HomeDesc' => 'La tua homepage WackoWiki. Deve essere un <a href="http://wackowiki.sourceforge.net/doc/Doc/English/WikiName" title="View Help" target="_blank">NomeWiki</a>.',
'HomeDefault' => 'HomePage',
'MultiLang' => 'Multi Language Mode',
'MultiLangDesc' => 'Multilanguage mode allows to have pages with different language settings within single installation. If this mode is enabled, installer will create initial pages for all languages available in distribution.',
'AllowedLang' => 'Allowed Languages',
'AllowedLangDesc' => 'It is recomended to select only the set of languages you want to use, other wise all languages are selected.',
'Admin' => 'Nome dell\'amministratore',
'AdminDesc' => 'Immetti username dell\'amministratore (dovr� essere un <a href="http://wackowiki.sourceforge.net/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>) (e.g. WikiAdmin).',
'Password' => 'Admin Password',
'PasswordDesc' => 'Scegli una password per amministratore (almeno 9 caratteri)',
'Password2' => 'Ripeti password:',
'Mail' => 'Email dell\'amministratore.',
'MailDesc' => 'Enter the admins email address.',
'Base' => 'URL di base',
'BaseDesc' => 'La tua URL di base per il sito WackoWiki. I nomi di pagina sono stati aggiunti, ora sar� incluso l\'oggetto-parametro "?page=" se la modalit� di riscrittura di URL non funziona sul tuo server. <ul><li><b><em>http://example.com/</em></b></li><li><b><em>http://example.com/wiki/</em></b></li></ul>',
'Rewrite' => 'Modalit� Rewrite',
'RewriteDesc' => 'La modalit� Rewrite sar� attivata se si sta usando WackoWiki per la riscrittura d\'URL.',
'Enabled' => 'Attivato:',
'ErrorAdminName' => 'Devi immettere un WikiName valido per il nome dell\'amministratore!',
'ErrorAdminEmail' => 'Devi immettere un indirizzo email valido!',
'ErrorAdminPasswordMismatch' => 'Le password non coincidono, reimmetti password!',
'ErrorAdminPasswordShort' => 'The admin Password troppo corta, reimmetti un\'altra, the minimum length is 9 characters!',
'WarningRewriteMode' => 'ATTENTION!\nYour base URL and rewrite-mode settings looks suspicious. Usually there is no ? mark in the base URL if rewrite-mode is set - but in your case there is one.\n\nTo continue with these settings click OK.\nTo return to the form and change your settings click CANCEL.\n\nIf you are about to proceed with these settings, please note that they COULD cause problems with your WackoWiki installation.',
'ModRewriteStatusUnknown' => 'The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled',

'Languages'	=>  array(
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
),

/*
   Database Config Page
*/
'database-config' => 'Configurazione del database',
'DBDriver' => 'Driver',
'DBDriverDesc' => 'The database driver you want to use.  You must choose a legacy driver if you do not have PHP5.1 (or greater) and <a href="http://de2.php.net/pdo" target="_blank">PDO</a> installed.',
'DBCharset' => 'Charset',
'DBCharsetDesc' => 'The database charset you want to use.',
'DBEngine' => 'Engine',
'DBEngineDesc' => 'The database engine you want to use.  You must choose MyISAM engine if you do not have MariaDB 10 or MySql 5.6 (or greater) and InnoDB support available.',
'DBHost' => 'Host',
'DBHostDesc' => 'The host your database server is running on. Usually "localhost" (ie, the same machine your WackoWiki site is on).',
'DBPort' => 'Port (Optional)',
'DBPortDesc' => 'The port number your database server is accessable through, leave it blank to use the default port number.',
'DB' => 'Database Name',
'DBDesc' => 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DBUserDesc' => 'Name of the user used to connect to your database.',
'DBUser' => 'Nome utente',
'DBPasswordDesc' => 'Password of the user used to connect to your database.',
'DBPassword' => 'Immetti password',
'PrefixDesc' => 'Prefisso di tutte le tabelle usate da WackoWiki. Questo ti permette di disporre di pi� installazioni WackoWiki che utilizzano lo stesso database configurandolo all\'impiego dei diversi prefissi di tabella (e.g. wacko_).',
'Prefix' => 'Prefisso di tabella',
'ErrorNoDbDriverDetected' => 'No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.',
'ErrorNoDbDriverSelected' => 'No database driver has been selected, please pick one from the list.',
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'database-install' => 'Database Installation',
'TestingConfiguration' => 'Test della configurazione',
'TestConnectionString' => 'Prova i parametri di connessione database',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'InstallingTables' => 'Installing Tables',
'ErrorDBConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDBExists' => 'Il database da te configurato non � stato trovato. Ricorda che deve esistere prima di installare o aggiornare WackoWiki!',
'To' => 'a',
'AlterTable' => 'Altering <code>%1</code> Table',
'RenameTable' => 'Renaming <code>%1</code> Table',
'UpdateTable' => 'Updating <code>%1</code> Table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Adding System User',
'InstallingAdmin' => 'Aggiunge utente-amministratore',
'InstallingAdminSetting' => 'Aggiunge utente-amministratore',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingRegisteredGroup' => 'Adding Registered Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Adding Logo Image',
'InstallingConfigValues' => 'Adding Config Values',
'ErrorInsertingPage' => 'Error inserting <code>%1</code> page',
'ErrorInsertingPageReadPermission' => 'Error setting read permission for <code>%1</code> page',
'ErrorInsertingPageWritePermission' => 'Error setting write permission for <code>%1</code> page',
'ErrorInsertingPageCommentPermission' => 'Error setting comment permissions for <code>%1</code> page',
'ErrorInsertingPageCreatePermission' => 'Error setting create permissions for <code>%1</code> page',
'ErrorInsertingPageUploadPermission' => 'Error setting upload permissions for <code>%1</code> page',
'ErrorInsertingDefaultMenuItem' => 'Error setting page <code>%1</code> as default menu item',
'ErrorPageAlreadyExists' => 'The <code>%1</code> page already exists',
'ErrorAlteringTable' => 'Error altering <code>%1</code> table',
'ErrorRenamingTable' => 'Error renaming <code>%1</code> table',
'ErrorUpdatingTable' => 'Error updating <code>%1</code> table',
'CreatingTable' => 'Creazione di <code>%1</code> tabella/e',
'ErrorAlreadyExists' => 'The <code>%1</code> already exists',
'ErrorCreatingTable' => 'Error creating <code>%1</code> table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Trasferimento di dati alla tabella di revisione',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting <code>%1</code> table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting <code>%1</code> table',

/*
   Write Config Page
*/
'write-config' => 'Write Config File',
'FinalStep' => 'Final Step',
'Writing' => 'Scrittura del file di configurazione',
'RemovingWritePrivilege' => 'Removing Write Privilege',
'InstallationComplete' => 'Installazione completata',
'ThatsAll' => '� tutto! Adesso puoi <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations' => 'Security Considerations',
'SecurityRisk' => 'Infine, ti consigliamo di escludere l\'opzione di scrittura su <code>config.php</code>ora che � stata scritta. Lasciare il file aperto alla scrittura � un rischio per la tua sicurezza!',
'RemoveSetupDirectory' => 'You should delete the "setup" directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'Il file di configurazione <code>%1</code> non si � potuto scrivere. Si dovr� rendere temporaneamente accessibile alla scrittura il tuo server e la tua directory WackoWiki, o un file vuoto col nome di <code>config.php</code> (<code>touch config.php ; chmod 666 config.php</code>; don\'t forget to remove write access again later, ie <code>chmod 644 config.php</code>). Se, per qualche motivo, non puoi farlo, dovrai copiare il testo in basso in un nuovo file e salvarlo/immetterlo come <code>config.php</code> nella directory WackoWiki. Ci� fatto, il tuo sito WackoWiki � pronto per funzionare. Altrimenti, visita <a href="http://wackowiki.sourceforge.net/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'Nel passo successivo, l\'installatore tenter� di scrivere il nuovo file di configurazione, <code>config.php</code>. Verifica che il server del web abbia accesso alla scrittura sul file, o che tu possa editarlo manualmente.  Ancora una volta, consulta  <a href="http://wackowiki.sourceforge.net/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> per i dettagli.',
'WrittenAt' => 'scritto a ',
'DontChange' => 'non modificare manualmente la wacko_version!',
'ConfigDescription' => 'detailed description http://wackowiki.sourceforge.net/doc/Doc/English/Configuration',
'TryAgain' => 'Riprova',

);
?>