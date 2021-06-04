<?php
$lang = [

/*
   Language Settings
*/
'Charset'	=> 'utf-8',
'LangISO'	=> 'it',
'LangName'	=> 'Italian',

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
'Title'							=> 'Installazione di WackoWiki',
'Continue'						=> 'Continua',
'Back'							=> 'Back',
'Recommended'					=> 'raccomandato',
'InvalidAction'					=> 'Invalid action',

/*
   Language Selection Page
*/
'lang'							=> 'Configurazione della lingua',
'PleaseUpgradeToR6'				=> 'Siete a conoscenza di una vecchia (pre %1) versione di WackoWiki. Per aggiornare a questa release di WackoWiki, devi prima aggiornare la tua installazione a %2.',
'UpgradeFromWacko'				=> 'Benvenuti a WackoWiki, sembra che stiate aggiornando da WackoWiki %1 a %2. Le prossime pagine vi guideranno attraverso il processo di aggiornamento.',
'FreshInstall'					=> 'Benvenuti su WackoWiki, state per installare WackoWiki %1. Le prossime pagine vi guideranno attraverso il processo di installazione.',
'PleaseBackup'					=> 'Per favore, <strong>backup</strong> del vostro database, file di configurazione e tutti i file modificati come quelli che hanno hack e patch applicati ad essi prima di iniziare il processo di aggiornamento. Questo può salvarvi da un grande mal di testa.',
'LangDesc'						=> 'Scegli una lingua per il processo d\'installazione: la stessa sarà installata come lingua di default nel tuo WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Requisiti di sistema',
'PhpVersion'					=> 'PHP Version',
'PhpDetected'					=> 'Detected PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'Database',
'PhpExtensions'					=> 'PHP Extensions',
'Permissions'					=> 'Permissions',
'ReadyToInstall'				=> 'Ready to Install?',
'Requirements'					=> 'Il vostro server deve soddisfare i requisiti elencati di seguito.',
'OK'							=> 'OK',
'Problem'						=> 'Problema',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'La vostra installazione PHP sembra mancare le note estensioni PHP richieste da WackoWiki.',
'PcreWithoutUtf8'				=> 'Il modulo PCRE di PHP sembra essere stato compilato senza il supporto PCRE_UTF8',
'NotePermissions'				=> 'Questo installatore  tenterà di scrivere i dati di configurazione nel file %1, presente nella tua directory WackoWiki. Per gestire al meglio questa operazione, devi assicurarti che il server del tuo sito sia accessibile alla scrittura per questo file! Se non puoi farlo, dovrai editare il file manualmente (l\'installatore ti dirà come farlo).<br><br>Vedi <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> per i dettagli.',
'ErrorPermissions'				=> 'Sembrerebbe che il programma di installazione non possa impostare automaticamente i permessi necessari per il corretto funzionamento di WackoWiki.  Più avanti nel processo di installazione vi verrà richiesto di configurare manualmente i permessi richiesti per i file sul vostro server.',
'ErrorMinPhpVersion'			=> 'La versione di PHP deve essere maggiore di <strong>' . PHP_MIN_VERSION . '</strong>, il vostro server sembra eseguire una versione precedente. Per far funzionare correttamente WackoWiki, è necessario eseguire l\'aggiornamento a una versione più recente di PHP.',
'Ready'							=> 'Congratulazioni, sembra che il vostro server sia in grado di eseguire WackoWiki. Le prossime pagine vi guideranno attraverso il processo di configurazione.',

/*
   Site Config Page
*/
'config-site'					=> 'Configurazione di sito',
'SiteName'						=> 'Tuo nome Wiki',
'SiteNameDesc'					=> 'Il nome del tuo sito Wiki.',
'SiteNameDefault'				=> 'MyWikiSite',
'HomePage'						=> 'Home Page',
'HomePageDesc'					=> 'La tua homepage WackoWiki. Deve essere un <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">NomeWiki</a>.',
'HomePageDefault'				=> 'HomePage',
'MultiLang'						=> 'Multi Language Mode',
'MultiLangDesc'					=> 'La modalità multilingua permette di avere pagine con impostazioni linguistiche diverse all\'interno di una singola installazione. Se questa modalità è abilitata, l\'installatore creerà le voci di menu iniziali per tutte le lingue disponibili nella distribuzione.',
'AllowedLang'					=> 'Allowed Languages',
'AllowedLangDesc'				=> 'Si consiglia di selezionare solo l\'insieme delle lingue che si desidera utilizzare, altre saggiamente tutte le lingue sono selezionate.',
'Admin'							=> 'Nome dell\'amministratore',
'AdminDesc'						=> 'Immetti username dell\'amministratore (dovrà essere un <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>) (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Il nome utente deve avere minimo %1 e massimo %2 caratteri, deve contenere solo caratteri alfanumerici.',
'NameCamelCaseOnly'				=> 'Il nome utente deve avere minimo %1 e massimo %2 caratteri and WikiName formatted.',
'Password'						=> 'Admin Password',
'PasswordDesc'					=> 'Scegli una password per amministratore (almeno %1 caratteri)',
'Password2'						=> 'Ripeti password:',
'Mail'							=> 'Email dell\'amministratore.',
'MailDesc'						=> 'Inserisci l\'indirizzo e-mail degli amministratori.',
'Base'							=> 'URL di base',
'BaseDesc'						=> 'La tua URL di base per il sito WackoWiki. I nomi di pagina sono stati aggiunti, ora sarà incluso l\'oggetto-parametro "?page=" se la modalità di riscrittura di URL non funziona sul tuo server. <ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Modalità Rewrite',
'RewriteDesc'					=> 'La modalità Rewrite sarà attivata se si sta usando WackoWiki per la riscrittura d\'URL.',
'Enabled'						=> 'Attivato:',
'ErrorAdminEmail'				=> 'Devi immettere un indirizzo email valido!',
'ErrorAdminPasswordMismatch'	=> 'Le password non coincidono, reimmetti password!',
'ErrorAdminPasswordShort'		=> 'The admin Password troppo corta, reimmetti un\'altra, the minimum length is %1 characters!',
'ModRewriteStatusUnknown'		=> 'Il programma di installazione non può verificare che mod_rewrite sia abilitato, ma ciò non significa che sia disabilitato.',

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
'config-database'				=> 'Configurazione del database',
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
'Db'							=> 'Database Name',
'DbDesc'						=> 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DbUserDesc'					=> 'Name of the user used to connect to your database.',
'DbUser'						=> 'Nome utente',
'DbPasswordDesc'				=> 'Password of the user used to connect to your database.',
'DbPassword'					=> 'Immetti password',
'PrefixDesc'					=> 'Prefisso di tutte le tabelle usate da WackoWiki. Questo ti permette di disporre di più installazioni WackoWiki che utilizzano lo stesso database configurandolo all\'impiego dei diversi prefissi di tabella (e.g. wacko_).',
'Prefix'						=> 'Prefisso di tabella',
'ErrorNoDbDriverDetected'		=> 'No database driver has been detected, please enable either the mysqli or pdo_mysql extension in your php.ini file.',
'ErrorNoDbDriverSelected'		=> 'No database driver has been selected, please pick one from the list.',
'DeleteTables'					=> 'Cancellare tabelle esistenti?',
'DeleteTablesDesc'				=> 'ATTENZIONE! Se si procede con questa opzione selezionata tutti i dati del wiki corrente saranno cancellati dal database.  Questo non può essere annullato a meno che non si ripristini manualmente i dati da un backup.',
'ConfirmTableDeletion'			=> 'Sei sicuro di voler cancellare tutte le tabelle wiki attuali?',

/*
   Database Installation Page
*/
'install-database'				=> 'Installazione database',
'TestingConfiguration'			=> 'Test della configurazione',
'TestConnectionString'			=> 'Prova i parametri di connessione database',
'TestDatabaseExists'			=> 'Verifica dell\'esistenza del database specificato',
'TestDatabaseVersion'			=> 'Controllo dei requisiti minimi di versione della banca dati',
'InstallTables'					=> 'Installing Tables',
'ErrorDbConnection'				=> 'C\'è stato un problema con i dettagli di connessione al database che hai specificato, per favore torna indietro e controlla che siano corretti.',
'ErrorDbExists'					=> 'Il database da te configurato non è stato trovato. Ricorda che deve esistere prima di installare o aggiornare WackoWiki!',
'ErrorDatabaseVersion'			=> 'La versione del database è %1 ma richiede almeno %2.',
'To'							=> 'a',
'AlterTable'					=> 'Altering %1 table',
'InsertRecord'					=> 'Inserting Record into %1 table',
'RenameTable'					=> 'Renaming %1 table',
'UpdateTable'					=> 'Updating %1 table',
'InstallDefaultData'			=> 'Adding Default Data',
'InstallPagesBegin'				=> 'Adding Default Pages',
'InstallPagesEnd'				=> 'Finished Adding Default Pages',
'InstallSystemAccount'			=> 'Aggiunge utente <code>System</code>',
'InstallDeletedAccount'			=> 'Aggiunge utente <code>Deleted</code>',
'InstallAdmin'					=> 'Aggiunge utente-amministratore',
'InstallAdminSetting'			=> 'Aggiunge utente-amministratore',
'InstallAdminGroup'				=> 'Adding Admins Group',
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
'CreatingTable'					=> 'Creazione di %1 tabella/e',
'ErrorAlreadyExists'			=> 'The %1 already exists',
'ErrorCreatingTable'			=> 'Error creating %1 table, does it already exist?',
'DeletingTables'				=> 'Deleting Tables',
'DeletingTablesEnd'				=> 'Finished Deleting Tables',
'ErrorDeletingTable'			=> 'Errore di cancellazione della tabella %1, la ragione più probabile è che la tabella non esiste, nel qual caso si può ignorare questo avviso.',
'DeletingTable'					=> 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config'					=> 'Write Config File',
'FinalStep'						=> 'Final Step',
'Writing'						=> 'Scrittura del file di configurazione',
'RemovingWritePrivilege'		=> 'Removing Write Privilege',
'InstallationComplete'			=> 'Installazione completata',
'ThatsAll'						=> 'È tutto! Adesso puoi <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations'		=> 'Security Considerations',
'SecurityRisk'					=> 'Infine, ti consigliamo di escludere l\'opzione di scrittura su %1 ora che è stata scritta. Lasciare il file aperto alla scrittura è un rischio per la tua sicurezza!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'Dovreste cancellare la directory %1 ora che il processo di installazione è stato completato.',
'ErrorGivePrivileges'			=> 'Il file di configurazione %1 non si è potuto scrivere. Si dovrà rendere temporaneamente accessibile alla scrittura il tuo server e la tua directory WackoWiki, o un file vuoto col nome di %1<br>%2<br>; don\'t forget to remove write access again later, i.e. %3.<br>Se, per qualche motivo, non puoi farlo, dovrai copiare il testo in basso in un nuovo file e salvarlo/immetterlo come %1 nella directory WackoWiki. Ciò fatto, il tuo sito WackoWiki è pronto per funzionare. Altrimenti, visita <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep'						=> 'Nel passo successivo, l\'installatore tenterà di scrivere il nuovo file di configurazione, %1. Verifica che il server del web abbia accesso alla scrittura sul file, o che tu possa editarlo manualmente.  Ancora una volta, consulta  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> per i dettagli.',
'WrittenAt'						=> 'scritto a ',
'DontChange'					=> 'non modificare manualmente la wacko_version!',
'ConfigDescription'				=> 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Riprova',

];
