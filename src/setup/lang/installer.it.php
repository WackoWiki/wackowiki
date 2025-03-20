<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'it',
'LangLocale'	=> 'it_IT',
'LangName'		=> 'Italian',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Categoria',
	'groups_page'		=> 'Gruppi',
	'users_page'		=> 'Utenti',

	'search_page'		=> 'Ricerca',
	'login_page'		=> 'Connessione',
	'account_page'		=> 'Preferenze',
	'registration_page'	=> 'Registrazione',
	'password_page'		=> 'Password',

	'changes_page'		=> 'UltimeModifiche',
	'comments_page'		=> 'UltimiCommenti',
	'index_page'		=> 'IndicePagine',

	'random_page'		=> 'PaginaCasuale',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'Installazione di WackoWiki',
'TitleUpdate'					=> 'Aggiornamento WackoWiki',
'Continue'						=> 'Continua',
'Back'							=> 'Indietro',
'Recommended'					=> 'raccomandato',
'InvalidAction'					=> 'Azione non valida',

/*
   Language Selection Page
*/
'lang'							=> 'Configurazione della lingua',
'PleaseUpgradeToR6'				=> 'Siete a conoscenza di una vecchia (pre %2) versione di WackoWiki (%1). Per aggiornare a questa release di WackoWiki, devi prima aggiornare la tua installazione a %2.',
'UpgradeFromWacko'				=> 'Benvenuti a WackoWiki, sembra che stiate aggiornando da WackoWiki %1 a %2. Le prossime pagine vi guideranno attraverso il processo di aggiornamento.',
'FreshInstall'					=> 'Benvenuti su WackoWiki, state per installare WackoWiki %1. Le prossime pagine vi guideranno attraverso il processo di installazione.',
'PleaseBackup'					=> 'Per favore, <strong>backup</strong> del vostro database, file di configurazione e tutti i file modificati come quelli che hanno hack e patch applicati ad essi prima di iniziare il processo di aggiornamento. Questo può salvarvi da un grande mal di testa.',
'LangDesc'						=> 'Scegli una lingua per il processo d\'installazione: la stessa sarà installata come lingua di default nel tuo WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Requisiti di sistema',
'PhpVersion'					=> 'Versione PHP',
'PhpDetected'					=> 'Rilevato PHP',
'ModRewrite'					=> 'Estensione Apache Rewrite (opzionale)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installato?',
'Database'						=> 'Database',
'PhpExtensions'					=> 'Estensioni PHP',
'Permissions'					=> 'Permessi',
'ReadyToInstall'				=> 'Pronto per l\'installazione?',
'Requirements'					=> 'Il vostro server deve soddisfare i requisiti elencati di seguito.',
'OK'							=> 'OK',
'Problem'						=> 'Problema',
'Example'						=> 'Esempio',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'La vostra installazione PHP sembra mancare le note estensioni PHP richieste da WackoWiki.',
'PcreWithoutUtf8'				=> 'Il modulo PCRE di PHP sembra essere stato compilato senza il supporto PCRE_UTF8',
'NotePermissions'				=> 'Questo installatore  tenterà di scrivere i dati di configurazione nel file %1, presente nella tua directory WackoWiki. Per gestire al meglio questa operazione, devi assicurarti che il server del tuo sito sia accessibile alla scrittura per questo file! Se non puoi farlo, dovrai editare il file manualmente (l\'installatore ti dirà come farlo).<br><br>Vedi <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> per i dettagli.',
'ErrorPermissions'				=> 'Sembrerebbe che il programma di installazione non possa impostare automaticamente i permessi necessari per il corretto funzionamento di WackoWiki.  Più avanti nel processo di installazione vi verrà richiesto di configurare manualmente i permessi richiesti per i file sul vostro server.',
'ErrorMinPhpVersion'			=> 'La versione PHP deve essere maggiore di %1. Il server sembra aver eseguito una versione precedente. È necessario aggiornare a una versione PHP più recente per WackoWiki per funzionare correttamente.',
'Ready'							=> 'Congratulazioni, sembra che il vostro server sia in grado di eseguire WackoWiki. Le prossime pagine vi guideranno attraverso il processo di configurazione.',

/*
   Site Config Page
*/
'config-site'					=> 'Configurazione di sito',
'SiteName'						=> 'Tuo nome Wiki',
'SiteNameDesc'					=> 'Il nome del tuo sito Wiki.',
'SiteNameDefault'				=> 'MyWiki',
'HomePage'						=> 'Pagina Iniziale',
'HomePageDesc'					=> 'La tua homepage WackoWiki. Deve essere un <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">NomeWiki</a>.',
'HomePageDefault'				=> 'HomePage',
'MultiLang'						=> 'Modalità Multi-Lingua',
'MultiLangDesc'					=> 'La modalità multilingua permette di avere pagine con impostazioni linguistiche diverse all\'interno di una singola installazione. Se questa modalità è abilitata, l\'installatore creerà le voci di menu iniziali per tutte le lingue disponibili nella distribuzione.',
'AllowedLang'					=> 'Lingue Permesse',
'AllowedLangDesc'				=> 'Si consiglia di selezionare solo l\'insieme delle lingue che si desidera utilizzare, altre saggiamente tutte le lingue sono selezionate.',
'AclMode'							=> 'Impostazioni ACL predefinite',
'AclModeDesc'							=> '',
'PublicWiki'							=> 'Public Wiki (leggi per tutti, scrivi e commenta per gli utenti registrati)',
'PrivateWiki'							=> 'Private Wiki (lettura, scrittura, commento solo per utenti registrati)',
'Admin'							=> 'Nome dell\'amministratore',
'AdminDesc'						=> 'Immetti username dell\'amministratore (dovrà essere un <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>) (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Il nome utente deve avere minimo %1 e massimo %2 caratteri, deve contenere solo caratteri alfanumerici.',
'NameCamelCaseOnly'				=> 'Il nome utente deve avere minimo %1 e massimo %2 caratteri and WikiName formatted.',
'Password'						=> 'Password Amministratore',
'PasswordDesc'					=> 'Scegli una password per amministratore (almeno %1 caratteri)',
'PasswordConfirm'				=> 'Ripeti password:',
'Mail'							=> 'Email dell\'amministratore.',
'MailDesc'						=> 'Inserisci l\'indirizzo e-mail degli amministratori.',
'Base'							=> 'URL di base',
'BaseDesc'						=> 'Il tuo URL base del sito WackoWiki. I nomi delle pagine vengono aggiunti ad esso, quindi se si utilizza mod_rewrite l\'indirizzo dovrebbe terminare con uno slash in avanti, ad es.',
'Rewrite'						=> 'Modalità Rewrite',
'RewriteDesc'					=> 'La modalità Rewrite sarà attivata se si sta usando WackoWiki per la riscrittura d\'URL.',
'Enabled'						=> 'Attivato:',
'ErrorAdminEmail'				=> 'Devi immettere un indirizzo email valido!',
'ErrorAdminPasswordMismatch'	=> 'Le password non coincidono, reimmetti password!',
'ErrorAdminPasswordShort'		=> 'La password dell\'amministratore è troppo corta, la lunghezza minima è %1 caratteri!',
'ModRewriteStatusUnknown'		=> 'Il programma di installazione non può verificare che mod_rewrite sia abilitato, ma ciò non significa che sia disabilitato.',

/*
   Database Config Page
*/
'config-database'				=> 'Configurazione del database',
'DbDriver'						=> 'Driver',
'DbDriverDesc'					=> 'Il driver del database che vuoi usare.',
'DbSqlMode'						=> 'Modalità SQL',
'DbSqlModeDesc'					=> 'La modalità SQL che si desidera utilizzare.',
'DbVendor'						=> 'Fornitore',
'DbVendorDesc'					=> 'Il fornitore di database che utilizzi.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'Il set di caratteri del database che vuoi usare.',
'DbEngine'						=> 'Motore',
'DbEngineDesc'					=> 'Il motore di database che vuoi usare.',
'DbHost'						=> 'Host',
'DbHostDesc'					=> 'L\'host del server del database è in esecuzione. Di solito <code>127.0.0.1</code> o <code>localhost</code> (cioè, la stessa macchina su cui è attivo il sito WackoWiki).',
'DbPort'						=> 'Porta (facoltativo)',
'DbPortDesc'					=> 'Il numero di porta del server del database è accessibile, lascialo vuoto per usare il numero di porta predefinito.',
'DbName'						=> 'Nome Database',
'DbNameDesc'					=> 'Il database WackoWiki dovrebbe usare. Questo database deve esistere già una volta che continui!',
'DbUser'						=> 'Nome utente',
'DbUserDesc'					=> 'Nome dell\'utente usato per connettersi al database.',
'DbPassword'					=> 'Immetti password',
'DbPasswordDesc'				=> 'Password dell\'utente usata per connettersi al database.',
'Prefix'						=> 'Prefisso di tabella',
'PrefixDesc'					=> 'Prefisso di tutte le tabelle usate da WackoWiki. Questo ti permette di disporre di più installazioni WackoWiki che utilizzano lo stesso database configurandolo all\'impiego dei diversi prefissi di tabella (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'Non è stato rilevato alcun driver di database, si prega di abilitare l\'estensione mysqli o pdo_mysql nel file php.ini.',
'ErrorNoDbDriverSelected'		=> 'Non è stato selezionato alcun driver di database, sceglierne uno dall\'elenco.',
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
'InstallTables'					=> 'Installazione Tabelle',
'ErrorDbConnection'				=> 'C\'è stato un problema con i dettagli di connessione al database che hai specificato, per favore torna indietro e controlla che siano corretti.',
'ErrorDatabaseVersion'			=> 'La versione del database è %1 ma richiede almeno %2.',
'To'							=> 'a',
'AlterTable'					=> 'Modifica tabella %1',
'InsertRecord'					=> 'Inserimento record nella tabella %1',
'RenameTable'					=> 'Rinomina tabella %1',
'UpdateTable'					=> 'Aggiornamento tabella %1',
'InstallDefaultData'			=> 'Aggiungere Dati Predefiniti',
'InstallPagesBegin'				=> 'Aggiungere Pagine Predefinite',
'InstallPagesEnd'				=> 'Aggiunta Pagine Predefinite Finita',
'InstallSystemAccount'			=> 'Aggiunge utente <code>System</code>',
'InstallDeletedAccount'			=> 'Aggiunge utente <code>Deleted</code>',
'InstallAdmin'					=> 'Aggiunge utente-amministratore',
'InstallAdminSetting'			=> 'Aggiunge utente-amministratore',
'InstallAdminGroup'				=> 'Aggiunta Gruppo Amministratori',
'InstallAdminGroupMember'		=> 'Aggiunta Membro Del Gruppo Amministratori',
'InstallEverybodyGroup'			=> 'Aggiungere Gruppo Tutti',
'InstallModeratorGroup'			=> 'Aggiungere Gruppo Moderatore',
'InstallReviewerGroup'			=> 'Aggiungere Gruppo Revisore',
'InstallLogoImage'				=> 'Aggiungere Immagine Logo',
'LogoImage'						=> 'Immagine logo',
'InstallConfigValues'			=> 'Aggiungere Valori Di Configurazione',
'ConfigValues'					=> 'Valori Di Configurazione',
'ErrorInsertPage'				=> 'Errore nell\'inserire la pagina %1',
'ErrorInsertPagePermission'		=> 'Errore nell\'impostare i permessi per la pagina %1',
'ErrorInsertDefaultMenuItem'	=> 'Errore nell\'impostare la pagina %1 come elemento di menu predefinito',
'ErrorPageAlreadyExists'		=> 'La pagina %1 esiste già',
'ErrorAlterTable'				=> 'Errore nel modificare la tabella %1',
'ErrorInsertRecord'				=> 'Errore nel inserire il record nella tabella %1',
'ErrorRenameTable'				=> 'Errore nel rinominare tabella %1',
'ErrorUpdatingTable'			=> 'Errore nell\'aggiornare la tabella %1',
'CreatingTable'					=> 'Creazione di %1 tabella/e',
'ErrorAlreadyExists'			=> '%1 esiste già',
'ErrorCreatingTable'			=> 'Errore nella creazione della tabella %1, esiste gia?',
'DeletingTables'				=> 'Eliminazione Tabelle',
'DeletingTablesEnd'				=> 'Finito Eliminazione Tabelle',
'ErrorDeletingTable'			=> 'Errore di cancellazione della tabella %1, la ragione più probabile è che la tabella non esiste, nel qual caso si può ignorare questo avviso.',
'DeletingTable'					=> 'Eliminazione tabella %1',
'NextStep'						=> 'Nel passo successivo, l\'installatore tenterà di scrivere il nuovo file di configurazione, %1. Verifica che il server del web abbia accesso alla scrittura sul file, o che tu possa editarlo manualmente.  Ancora una volta, consulta  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> per i dettagli.',

/*
   Write Config Page
*/
'write-config'					=> 'Scrivi file di configurazione',
'FinalStep'						=> 'Ultimo passo',
'Writing'						=> 'Scrittura del file di configurazione',
'RemovingWritePrivilege'		=> 'Rimozione Privilegio Scrivere',
'InstallationComplete'			=> 'Installazione completata',
'ThatsAll'						=> 'È tutto! Adesso puoi <a href="%1">visualizzare il tuo sito WackoWiki</a>.',
'SecurityConsiderations'		=> 'Considerazioni di sicurezza',
'SecurityRisk'					=> 'Infine, ti consigliamo di escludere l\'opzione di scrittura su %1 ora che è stata scritta. Lasciare il file aperto alla scrittura è un rischio per la tua sicurezza!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'Dovreste cancellare la directory %1 ora che il processo di installazione è stato completato.',
'ErrorGivePrivileges'			=> 'Il file di configurazione %1 non si è potuto scrivere. Si dovrà rendere temporaneamente accessibile alla scrittura il tuo server e la tua directory WackoWiki, o un file vuoto col nome di %1<br>%2<br><br>Don\'t forget to remove write access again later, i.e.<br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Se, per qualche motivo, non puoi farlo, dovrai copiare il testo in basso in un nuovo file e salvarlo/immetterlo come %1 nella directory WackoWiki. Ciò fatto, il tuo sito WackoWiki è pronto per funzionare. Altrimenti, visita <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Ciò fatto, il tuo sito WackoWiki è pronto per funzionare. Altrimenti, visita <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'scritto a ',
'DontChange'					=> 'non modificare manualmente la wacko_version!',
'ConfigDescription'				=> 'descrizione dettagliata https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Riprova',

];
