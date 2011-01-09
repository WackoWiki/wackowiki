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

/*
   Language Selection Page
*/
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <tt>%1</tt> to <tt>%2</tt>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <tt>%1</tt>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Please, backup your database, config file and all changed files such as those which have hacks and patches applied to them before starting upgrade process. This can save you from big headache.',
'Lang' => 'Configurazione della lingua',
'LangDesc' => 'Scegli una lingua per il processo d\'installazione: la stessa sarà installata come lingua di default nel tuo WackoWiki.',

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
'NotePermissions' => 'Questo installatore  tenterà di scrivere i dati di configurazione nel file <tt>config.php</tt>, presente nella tua directory WackoWiki. Per gestire al meglio questa operazione, devi assicurarti che il server del tuo sito sia accessibile alla scrittura per questo file! Se non puoi farlo, dovrai editare il file manualmente (l\'installatore ti dirà come farlo).<br /><br />Vedi <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> per i dettagli.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPHPVersion' => 'The PHP Version must be greater than <strong>5.2.0</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'site-config' => 'Configurazione di sito',
'Name' => 'Tuo nome WackoWiki',
'NameDesc' => 'Il nome del tuo sito WackoWiki. È di norma un NomeWiki e somiglia a QualcosaComeQuesto. <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'Home' => 'Home Page',
'HomeDesc' => 'La tua homepage WackoWiki. Deve essere un <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">NomeWiki</a>.',
'HomeDefault' => 'HomePage',
'MultiLang' => 'Multi Language Mode',
'MultiLangDesc' => 'Multilanguage mode allows to have pages with different language settings within single installation. If this mode is enabled, installer will create initial pages for all languages available in distribution.',
'Admin' => 'Nome dell\'amministratore',
'AdminDesc' => 'Immetti username dell\'amministratore (dovrà essere un <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>) (e.g. WikiAdmin).',
'Password' => 'Admin Password',
'PasswordDesc' => 'Scegli una password per amministratore (almeno 8 caratteri)',
'Password2' => 'Ripeti password:',
'Mail' => 'Email dell\'amministratore.',
'MailDesc' => 'Enter the admins email address.',
'Base' => 'URL di base',
'BaseDesc' => 'La tua URL di base per il sito WackoWiki. I nomi di pagina sono stati aggiunti, ora sarà incluso l\'oggetto-parametro "?page=" se la modalità di riscrittura di URL non funziona sul tuo server. <ul><li><b><i>http://wackowiki.org/</i></b></li><li><b><i>http://wackowiki.org/wiki/</i></b></li></ul>',
'Rewrite' => 'Modalità Rewrite',
'RewriteDesc' => 'La modalità Rewrite sarà attivata se si sta usando WackoWiki per la riscrittura d\'URL.',
'Enabled' => 'Attivato:',
'ErrorAdminName' => 'Devi immettere un WikiName valido per il nome dell\'amministratore!',
'ErrorAdminEmail' => 'Devi immettere un indirizzo email valido!',
'ErrorAdminPasswordMismatch' => 'Le password non coincidono, reimmetti password!',
'ErrorAdminPasswordShort' => 'The admin Password troppo corta, reimmetti un\'altra, the minimum length is 8 characters!',
'WarningRewriteMode' => 'ATTENTION!\nYour base URL and rewrite-mode settings looks suspicious. Usually there is no ? mark in the base URL if rewrite-mode is set - but in your case there is one.\n\nTo continue with these settings click OK.\nTo return to the form and change your settings click CANCEL.\n\nIf you are about to proceed with these settings, please note that they COULD cause problems with your WackoWiki installation.',
'ModRewriteStatusUnknown' => 'The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled',

/*
   Database Config Page
*/
'database-config' => 'Configurazione del database',
'DBDriverDesc' => 'The database driver you want to use.  You must choose a legacy driver if you do not have PHP5.1 (or greater) and <a href="http://de2.php.net/pdo" target="_blank">PDO</a> installed.',
'DBDriver' => 'Driver',
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
'database-install' => 'Database Installation',
'TestingConfiguration' => 'Test della configurazione',
'TestConnectionString' => 'Prova i parametri di connessione database',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'InstallingTables' => 'Installing Tables',
'ErrorDBConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDBExists' => 'Il database da te configurato non è stato trovato. Ricorda che deve esistere prima di installare o aggiornare WackoWiki!',
'To' => 'a',
'AlterTable' => 'Altering <tt>%1</tt> Table',
'RenameTable' => 'Renaming <tt>%1</tt> Table',
'UpdateTable' => 'Updating <tt>%1</tt> Table',
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
'CreatingTable' => 'Creazione di <tt>%1</tt> tabella/e',
'ErrorAlreadyExists' => 'The <tt>%1</tt> already exists',
'ErrorCreatingTable' => 'Error creating <tt>%1</tt> table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Trasferimento di dati alla tabella di revisione',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting <tt>%1</tt> table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting <tt>%1</tt> table',

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
'SecurityRisk' => 'Infine, ti consigliamo di escludere l\'opzione di scrittura su <tt>config.php</tt>ora che è stata scritta. Lasciare il file aperto alla scrittura è un rischio per la tua sicurezza!',
'RemoveSetupDirectory' => 'You should delete the "setup" directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'Il file di configurazione <tt>%1</tt> non si è potuto scrivere. Si dovrà rendere temporaneamente accessibile alla scrittura il tuo server e la tua directory WackoWiki, o un file vuoto col nome di <tt>config.php</tt> (<tt>touch config.php ; chmod 666 config.php</tt>; don\'t forget to remove write access again later, ie <tt>chmod 644 config.php</tt>). Se, per qualche motivo, non puoi farlo, dovrai copiare il testo in basso in un nuovo file e salvarlo/immetterlo come <tt>config.php</tt> nella directory WackoWiki. Ciò fatto, il tuo sito WackoWiki è pronto per funzionare. Altrimenti, visita <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'Nel passo successivo, l\'installatore tenterà di scrivere il nuovo file di configurazione, <tt>config.php</tt>. Verifica che il server del web abbia accesso alla scrittura sul file, o che tu possa editarlo manualmente.  Ancora una volta, consulta  <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> per i dettagli.',
'WrittenAt' => 'scritto a ',
'DontChange' => 'non modificare manualmente la wacko_version!',
'ConfigDescription' => 'detailed description http://wackowiki.org/Doc/English/Configuration',
'TryAgain' => 'Riprova',
'RemoveWakkaConfigFile' => 'WackoWiki uses a newer config file than your previous WakkaWiki installation.  The old file could not be automatically removed by the system and so it is recommended that you manually delete the file <tt>wakka.config.php</tt>.',
'DeletingWakkaConfigFile' => 'Deleting Obsolete Wakka Configuration File',

);
?>