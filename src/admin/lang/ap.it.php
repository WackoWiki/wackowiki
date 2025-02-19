<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Funzioni base',
		'preferences'	=> 'Preferenze',
		'content'		=> 'Contenuto',
		'users'			=> 'Utenti',
		'maintenance'	=> 'Manutenzione',
		'messages'		=> 'Messaggi',
		'extension'		=> 'Estensione',
		'database'		=> 'Database',
	],

	// Admin panel
	'AdminPanel'				=> 'Pannello di Controllo Amministrazione',
	'RecoveryMode'				=> 'Modalità di recupero',
	'Authorization'				=> 'Autorizzazione',
	'AuthorizationTip'			=> 'Inserisci la password amministrativa (assicurati anche che i cookie siano ammessi nel tuo browser).',
	'NoRecoveryPassword'		=> 'La password amministrativa non è specificata!',
	'NoRecoveryPasswordTip'		=> 'Nota: l’assenza di una password amministrativa è una minaccia alla sicurezza! Inserisci la tua password nel file di configurazione ed esegui nuovamente il programma.',

	'ErrorLoadingModule'		=> 'Errore nel caricare il modulo di amministrazione %1: non esiste.',

	'ApHomePage'				=> 'Pagina Iniziale',
	'ApHomePageTip'				=> 'Esci dall\'amministrazione del sistema e apri la pagina iniziale',
	'ApLogOut'					=> 'Esci',
	'ApLogOutTip'				=> 'Uscire dalla somministrazione del sistema e uscire dal sito',

	'TimeLeft'					=> 'Tempo rimasto: %1 minuti',
	'ApVersion'					=> 'versione',

	'SiteOpen'					=> 'Apri',
	'SiteOpened'				=> 'sito aperto',
	'SiteOpenedTip'				=> 'Il sito è aperto',
	'SiteClose'					=> 'Chiudi',
	'SiteClosed'				=> 'sito chiuso',
	'SiteClosedTip'				=> 'Il sito è chiuso',

	'System'					=> 'Sistema',

	// Generic
	'Cancel'					=> 'Annulla',
	'Add'						=> 'Aggiungi',
	'Edit'						=> 'Modifica',
	'Remove'					=> 'Rimuovere',
	'Enabled'					=> 'Abilitata',
	'Disabled'					=> 'Disabilitata',
	'Mandatory'					=> 'Obbligatorio',
	'Admin'						=> 'Amministratore',
	'Min'						=> 'Min',
	'Max'						=> 'Max',

	'MiscellaneousSection'		=> 'Varie',
	'MainSection'				=> 'Opzioni Generali',

	'DirNotWritable'			=> 'La directory %1 non è scrivibile',
	'FileNotWritable'			=> 'Il file %1 non è scrivibile.',

	/**
	 * AP MENU
	 *
	 *	'module_name'		=> [
	 *		'name'		=> 'Module name',
	 *		'title'		=> 'Module title',
	 *	],
	 */

	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Base',
		'title'		=> 'Parametri base',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Aspetto',
		'title'		=> 'Impostazioni aspetto',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-mail',
		'title'		=> 'Impostazioni e-mail',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Sindacato',
		'title'		=> 'Impostazioni di syndication',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtro',
		'title'		=> 'Impostazioni filtro',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formattazione',
		'title'		=> 'Opzioni di formattazione',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Notifiche',
		'title'		=> 'Impostazioni notifiche',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Pagine',
		'title'		=> 'Pagine e parametri del sito',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permessi',
		'title'		=> 'Impostazioni permessi',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Sicurezza',
		'title'		=> 'Impostazioni sottosistemi di sicurezza',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Sistema',
		'title'		=> 'Opzioni di sistema',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Carica',
		'title'		=> 'Impostazioni allegato',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Eliminato',
		'title'		=> 'Contenuto recentemente eliminato',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Aggiungi, modifica o rimuovi voci di menu predefinite',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Backup',
		'title'		=> 'Backup dei dati',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Riparazione',
		'title'		=> 'Ripara e Ottimizza Database',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Ripristina',
		'title'		=> 'Ripristino dei dati di backup',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Menu Principale',
		'title'		=> 'Amministrazione WackoWiki',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Incongruenze',
		'title'		=> 'Correggere Incongruenze Dei Dati',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Sincronizzazione Dati',
		'title'		=> 'Sincronizzazione dati',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'E-mail di massa',
		'title'		=> 'E-mail di massa',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Messaggio di sistema',
		'title'		=> 'Messaggi di sistema',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Informazioni Di Sistema',
		'title'		=> 'Informazioni Di Sistema',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System log',
		'title'		=> 'Registro degli eventi di sistema',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistiche',
		'title'		=> 'Mostra statistiche',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Comportamento Cattivo',
		'title'		=> 'Comportamento Cattivo',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Approva',
		'title'		=> 'Approvazione registrazione utente',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Gruppi',
		'title'		=> 'Gestione del gruppo',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Utenti',
		'title'		=> 'Gestione utenti',
	],

	// Main module
	'MainNote'					=> 'Note: Before the administration of technical activities strongly are encouraged to block access to the site!',

	'PurgeSessions'				=> 'Purga',
	'PurgeSessionsTip'			=> 'Elimina tutte le sessioni',
	'PurgeSessionsConfirm'		=> 'Sei sicuro di voler eliminare tutte le sessioni? Questo disconnetterà tutti gli utenti.',
	'PurgeSessionsExplain'		=> 'Elimina tutte le sessioni. Questo eliminerà tutti gli utenti troncando la tabella auth_token.',
	'PurgeSessionsDone'			=> 'Sessioni eliminate con successo.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Impostazioni base aggiornate',
	'LogBasicSettingsUpdated'	=> 'Impostazioni base aggiornate',

	'SiteName'					=> 'Nome sito:',
	'SiteNameInfo'				=> 'Il titolo di questo sito. Appare sul titolo del browser, sull\'intestazione del tema, sulla notifica via email, ecc.',
	'SiteDesc'					=> 'Descrizione del sito:',
	'SiteDescInfo'				=> 'Supplemento al titolo del sito che appare nell\'intestazione delle pagine. Spiega, in poche parole, di cosa si tratta questo sito.',
	'AdminName'					=> 'Admin del sito:',
	'AdminNameInfo'				=> 'Nome utente della persona responsabile del supporto generale del sito. Questo nome non è usato per determinare i diritti di accesso, ma è desiderabile che sia conforme al nome del amministratore capo del sito.',

	'LanguageSection'			=> 'Lingua',
	'DefaultLanguage'			=> 'Lingua predefinita:',
	'DefaultLanguageInfo'		=> 'Specifica la lingua dei messaggi visualizzati agli ospiti non registrati, nonché le impostazioni locali.',
	'MultiLanguage'				=> 'Supporto multilingue:',
	'MultiLanguageInfo'			=> 'Abilita la possibilità di selezionare una lingua su una pagina per pagina.',
	'AllowedLanguages'			=> 'Lingue ammesse:',
	'AllowedLanguagesInfo'		=> 'Si consiglia di selezionare solo l’insieme delle lingue che si desidera utilizzare, altre saggiamente tutte le lingue sono selezionate.',

	'CommentSection'			=> 'Commenti',
	'AllowComments'				=> 'Consenti commenti:',
	'AllowCommentsInfo'			=> 'Abilita i commenti solo per gli ospiti o gli utenti registrati, o disabilitarli su tutto il sito.',
	'SortingComments'			=> 'Ordinamento commenti:',
	'SortingCommentsInfo'		=> 'Modifica l\'ordine che i commenti della pagina sono presentati, sia con il più recente OR il più vecchio commento in alto.',

	'ToolbarSection'			=> 'Barra Strumenti',
	'CommentsPanel'				=> 'Pannello commenti:',
	'CommentsPanelInfo'			=> 'La visualizzazione predefinita dei commenti in fondo alla pagina.',
	'FilePanel'					=> 'Pannello file:',
	'FilePanelInfo'				=> 'La visualizzazione predefinita degli allegati in fondo alla pagina.',
	'TagsPanel'					=> 'Pannello tag:',
	'TagsPanelInfo'				=> 'La visualizzazione predefinita del pannello dei tag in fondo alla pagina.',

	'NavigationSection'			=> 'Navigazione',
	'ShowPermalink'				=> 'Mostra permalink:',
	'ShowPermalinkInfo'			=> 'La visualizzazione predefinita del permalink per la versione corrente della pagina.',
	'TocPanel'					=> 'Tabella del pannello di contenuto:',
	'TocPanelInfo'				=> 'La tabella di visualizzazione predefinita del pannello dei contenuti di una pagina (potrebbe aver bisogno di supporto nei modelli).',
	'SectionsPanel'				=> 'Pannello sezioni:',
	'SectionsPanelInfo'			=> 'Per impostazione predefinita, visualizza il pannello delle pagine adiacenti (richiede supporto nei modelli).',
	'DisplayingSections'		=> 'Visualizzazione sezioni:',
	'DisplayingSectionsInfo'	=> 'Quando le opzioni precedenti sono impostate, se visualizzare solo le sotto-pagine della pagina (<em>inferiore</em>), solo vicino (<em>top</em>), entrambi, o altro (<em>albero</em>).',
	'MenuItems'					=> 'Voci di menu:',
	'MenuItemsInfo'				=> 'Numero predefinito di voci di menu mostrate (potrebbe essere necessario supporto nei modelli).',

	'HandlerSection'			=> 'Handler',
	'HideRevisions'				=> 'Nascondi revisioni:',
	'HideRevisionsInfo'			=> 'La visualizzazione predefinita delle revisioni della pagina.',
	'AttachmentHandler'			=> 'Abilita gestore allegati:',
	'AttachmentHandlerInfo'		=> 'Permette di visualizzare il gestore degli allegati.',
	'SourceHandler'				=> 'Abilita gestore sorgente:',
	'SourceHandlerInfo'			=> 'Permette la visualizzazione del gestore sorgente.',
	'ExportHandler'				=> 'Abilita gestore esportazione XML:',
	'ExportHandlerInfo'			=> 'Permette la visualizzazione del gestore di esportazione XML.',

	'DiffModeSection'			=> 'Modalità Di Differenza',
	'DefaultDiffModeSetting'	=> 'Modalità diff predefinita:',
	'DefaultDiffModeSettingInfo'=> 'Modalità diff preselezionata.',
	'AllowedDiffMode'			=> 'Modalità diff consentite:',
	'AllowedDiffModeInfo'		=> 'Si consiglia di selezionare solo l\'insieme di modalità di diff che si desidera utilizzare, altrimenti tutte le modalità di diff sono selezionate.',
	'NotifyDiffMode'			=> 'Notifica modalità diff',
	'NotifyDiffModeInfo'		=> 'Modalità di confronto utilizzata per le notifiche nel corpo dell\'email.',

	'EditingSection'			=> 'Modifica',
	'EditSummary'				=> 'Modifica riepilogo:',
	'EditSummaryInfo'			=> 'Mostra il riepilogo di modifica in modalità modifica.',
	'MinorEdit'					=> 'Modifica minore:',
	'MinorEditInfo'				=> 'Abilita l\'opzione di modifica minore nella modalità di modifica.',
	'SectionEdit'				=> 'Modifica sezione:',
	'SectionEditInfo'			=> 'Consente di modificare solo una sezione di una pagina.',
	'ReviewSettings'			=> 'Revisione:',
	'ReviewSettingsInfo'		=> 'Abilita l\'opzione di revisione in modalità modifica.',
	'PublishAnonymously'		=> 'Consenti la pubblicazione anonima:',
	'PublishAnonymouslyInfo'	=> 'Consenti agli utenti di pubblicare in modo anonimo (per nascondere il nome).',

	'DefaultRenameRedirect'		=> 'Quando si rinomina, creare reindirizzamento:',
	'DefaultRenameRedirectInfo'	=> 'Per impostazione predefinita, offrire di impostare un reindirizzamento al vecchio indirizzo della pagina che viene rinominato.',
	'StoreDeletedPages'			=> 'Mantieni le pagine eliminate:',
	'StoreDeletedPagesInfo'		=> 'Quando si elimina una pagina, un commento o un file, conservarlo in una sezione speciale, dove sarà disponibile per il riesame e il recupero per un certo periodo di tempo (come descritto di seguito).',
	'KeepDeletedTime'			=> 'Tempo di archiviazione delle pagine cancellate:',
	'KeepDeletedTimeInfo'		=> 'Il periodo in giorni. Ha senso solo con l\'opzione precedente. Usa zero per garantire che le entità non vengano mai eliminate (in questo caso l\'amministratore può cancellare manualmente il "carrello").',
	'PagesPurgeTime'			=> 'Tempo di memorizzazione delle revisioni della pagina:',
	'PagesPurgeTimeInfo'		=> 'Elimina automaticamente le versioni più vecchie entro il numero di giorni specificato. Se inserisci zero, le versioni più vecchie non verranno rimosse.',
	'EnableReferrers'			=> 'Abilita referrers:',
	'EnableReferrersInfo'		=> 'Permette la creazione e la visualizzazione di referenti esterni.',
	'ReferrersPurgeTime'		=> 'Tempo di conservazione dei referenti:',
	'ReferrersPurgeTimeInfo'	=> 'Conservare la cronologia delle pagine esterne di riferimento non più di un determinato numero di giorni. Zero significa conservazione eterna, ma per un sito visitato attivamente questo può portare ad un overflow del database.',
	'EnableCounters'			=> 'Contatori Colpiti:',
	'EnableCountersInfo'		=> 'Permette il conteggio delle visite per pagina e la visualizzazione di semplici statistiche. Le chiamate del proprietario della pagina non vengono contate.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Controlla le impostazioni di syndication web predefinite per il vostro sito.',
	'SyndicationSettingsUpdated'	=> 'Impostazioni di syndication aggiornate.',

	'FeedsSection'				=> 'Feed',
	'EnableFeeds'				=> 'Abilita i feed:',
	'EnableFeedsInfo'			=> 'Attiva o disattiva i feed RSS per l’intero wiki.',
	'XmlChangeLink'				=> 'Cambia la modalità di collegamento del feed:',
	'XmlChangeLinkInfo'			=> 'Definisce dove il file XML cambia gli elementi del feed si collega.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'vista differenze',
		'2'		=> 'pagina attuale',
		'3'		=> 'elenco revisioni',
		'4'		=> 'pagina revisionata',
	],

	'XmlSitemap'				=> 'XML Sitemap:',
	'XmlSitemapInfo'			=> 'Crea un file XML chiamato %1 all\'interno della cartella xml. È possibile aggiungere il percorso alla mappa del sito nel file robots.txt nella directory principale come segue:',
	'XmlSitemapGz'				=> 'XML Sitemap compression:',
	'XmlSitemapGzInfo'			=> 'Se vuoi, puoi comprimere il file di testo della mappa del sito usando gzip per ridurre il tuo requisito di larghezza di banda.',
	'XmlSitemapTime'			=> 'Tempo di generazione della mappa del sito XML:',
	'XmlSitemapTimeInfo'		=> 'Genera la Sitemap una sola volta nel numero di giorni indicato, zero significa ad ogni cambio di pagina.',

	'SearchSection'				=> 'Ricerca',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Crea il file di descrizione di OpenSearch nella cartella XML e abilita l’Autodiscovery del plugin di ricerca nell’intestazione HTML.',
	'SearchEngineVisibility'	=> 'Block search engines (Search Engine Visibility):',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site, it is up to search engines to honor this request.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Controlla le impostazioni di visualizzazione predefinite per il tuo sito.',
	'AppearanceSettingsUpdated'	=> 'Impostazioni di aspetto aggiornate.',

	'LogoOff'					=> 'Spento',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo e titolo',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Site Logo:',
	'SiteLogoInfo'				=> 'In genere il tuo logo apparirà nell\'angolo in alto a sinistra dell\'applicazione. La dimensione massima è di 2 MiB. Le dimensioni ottimali sono di 255 pixel di larghezza per 55 pixel di altezza.',
	'LogoDimensions'			=> 'Dimensioni del logo:',
	'LogoDimensionsInfo'		=> 'Larghezza e altezza del logo visualizzato.',
	'LogoDisplayMode'			=> 'Modalità di visualizzazione logo:',
	'LogoDisplayModeInfo'		=> 'Definisce l\' aspetto del logo. Il valore predefinito è disattivato.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site Favicon:',
	'SiteFaviconInfo'			=> 'La tua icona di scorciatoia, o favicon, viene visualizzata nella barra degli indirizzi, nelle schede e nei segnalibri della maggior parte dei browser. Questo sovrascriverà la favicon del tuo tema.',
	'SiteFaviconTooBig'			=> 'Favicon è più grande di 64 × 64px.',
	'ThemeColor'				=> 'Colore del tema per la barra degli indirizzi:',
	'ThemeColorInfo'			=> 'Il browser imposterà il colore della barra degli indirizzi di ogni pagina secondo il colore CSS fornito.',

	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Tema:',
	'ThemeInfo'					=> 'Progettazione del modello che il sito utilizza per impostazione predefinita.',
	'ResetUserTheme'			=> 'Reimposta tutti i temi utente:',
	'ResetUserThemeInfo'		=> 'Ripristina tutti i temi utente. Attenzione: Questa azione ripristinerà tutti i temi selezionati dall\'utente al tema globale predefinito.',
	'SetBackUserTheme'			=> 'Ripristina tutti i temi utente al tema %1.',
	'ThemesAllowed'				=> 'Temi Consentiti:',
	'ThemesAllowedInfo'			=> 'Selezionare i temi consentiti, che l\'utente può scegliere, altrimenti, tutti i temi disponibili sono consentiti.',
	'ThemesPerPage'				=> 'Temi per pagina:',
	'ThemesPerPageInfo'			=> 'Consenti temi per pagina, che il proprietario della pagina può scegliere tramite le proprietà della pagina.',

	// System settings
	'SystemSettingsInfo'		=> 'Gruppo di parametri responsabili per la messa a punto del sito. Non cambiarli a meno che non si è sicuri delle loro azioni.',
	'SystemSettingsUpdated'		=> 'Impostazioni di sistema aggiornate',

	'DebugModeSection'			=> 'Modalità Debug',
	'DebugMode'					=> 'Modalità debug:',
	'DebugModeInfo'				=> 'Estrazione e visualizzazione di dati telematici sul tempo di esecuzione dell\'applicazione. Attenzione: la modalità dettaglio completa impone requisiti più elevati alla memoria assegnata, soprattutto per operazioni ad alta intensità di risorse, come il backup e il ripristino del database.',
	'DebugModes'	=> [
		'0'		=> 'il debug è disattivato',
		'1'		=> 'solo il tempo totale di esecuzione',
		'2'		=> 'a tempo pieno',
		'3'		=> 'dettaglio completo (DBMS, cache, ecc.)',
	],
	'DebugSqlThreshold'			=> 'Prestazioni soglia RDBMS:',
	'DebugSqlThresholdInfo'		=> 'In modalità debug dettagliata, segnalare solo le query che richiedono più tempo del numero di secondi specificato.',
	'DebugAdminOnly'			=> 'Diagnosi chiusa:',
	'DebugAdminOnlyInfo'		=> 'Mostra i dati di debug del programma (e DBMS) solo per l\'amministratore.',

	'CachingSection'			=> 'Opzioni Di Caching',
	'Cache'						=> 'Pagine renderizzate nella cache:',
	'CacheInfo'					=> 'Salva le pagine renderizzate nella cache locale per velocizzare il successivo avvio. Valido solo per i visitatori non registrati.',
	'CacheTtl'					=> 'Time-to-live per le pagine nella cache:',
	'CacheTtlInfo'				=> 'Pagine cache non più di un numero specificato di secondi.',
	'CacheSql'					=> 'Domande di Cache DBMS:',
	'CacheSqlInfo'				=> 'Mantenere una cache locale dei risultati di alcune query SQL relative alle risorse.',
	'CacheSqlTtl'				=> 'Term relevance Cache Database:',
	'CacheSqlTtlInfo'			=> 'Risultati della cache di query SQL per non più del numero specificato di secondi. Valori superiori a 1200 non sono auspicabili.',

	'LogSection'				=> 'Impostazioni Log',
	'LogLevelUsage'				=> 'Usa la registrazione:',
	'LogLevelUsageInfo'			=> 'La priorità minima degli eventi registrati nel registro.',
	'LogThresholds'	=> [
		'0'		=> 'do not keep a journal',
		'1'		=> 'solo il livello critico',
		'2'		=> 'dal livello più alto',
		'3'		=> 'da alto',
		'4'		=> 'in media',
		'5'		=> 'da basso',
		'6'		=> 'il livello minimo',
		'7'		=> 'registra tutti',
	],
	'LogDefaultShow'			=> 'Display Log Mode:',
	'LogDefaultShowInfo'		=> 'Gli eventi di priorità minima visualizzati nel registro per impostazione predefinita.',
	'LogModes'	=> [
		'1'		=> 'solo il livello critico',
		'2'		=> 'dal livello più alto',
		'3'		=> 'da alto livello',
		'4'		=> 'la media',
		'5'		=> 'da un basso',
		'6'		=> 'dal livello minimo',
		'7'		=> 'mostra tutto',
	],
	'LogPurgeTime'				=> 'Tempo di conservazione del registro:',
	'LogPurgeTimeInfo'			=> 'Rimuovere il registro eventi dopo il numero specificato di giorni.',

	'PrivacySection'			=> 'Privacy',
	'AnonymizeIp'				=> 'Anonimizza gli indirizzi IP degli utenti:',
	'AnonymizeIpInfo'			=> 'Anonimizza gli indirizzi IP se pertinente (cioè, pagina, revisione o riferimenti).',

	'ReverseProxySection'		=> 'Proxy Inverso',
	'ReverseProxy'				=> 'Usa proxy inverso:',
    'ReverseProxyInfo'			=> 
    'Attivare questa impostazione per determinare l’indirizzo IP corretto del client remoto esaminando
									le informazioni memorizzate nelle intestazioni X-Forwarded-For. Le intestazioni X-Forwarded-For
									sono un meccanismo standard per identificare i sistemi client che si connettono attraverso un
									server proxy inverso, come Squid o Pound. I server proxy inversi sono spesso utilizzati per migliorare
									le prestazioni di siti molto visitati e possono anche fornire altri vantaggi in termini di caching,
									sicurezza o crittografia. Se questa installazione di WackoWiki opera dietro un reverse proxy,
									questa impostazione dovrebbe essere abilitata in modo che le informazioni corrette sull’indirizzo
									IP siano catturate nei sistemi di gestione delle sessioni, dei log, delle statistiche e degli
									accessi di WackoWiki; se non si è sicuri di questa impostazione, se non si dispone di un reverse proxy
									o se WackoWiki opera in un ambiente di hosting condiviso, questa impostazione dovrebbe rimanere disabilitata.',
	'ReverseProxyHeader'		=> 'Inversione intestazione del proxy:',
	'ReverseProxyHeaderInfo'	=> 'Impostare questo valore se il server proxy invia l’IP del client in un’intestazione diversa
									da X-Forwarded-For. L’intestazione "X-Forwarded-For" è un elenco di indirizzi IP separati da
									virgole e spazi, di cui verrà utilizzato solo l’ultimo (quello più a sinistra).',
	'ReverseProxyAddresses'		=> 'reverse_proxy accetta un array di indirizzi IP:',
	'ReverseProxyAddressesInfo'	=> 'Each element of this array is the IP address of any of your reverse
									 proxies. Filling this array WackoWiki will trust the information stored
									 in the X-Forwarded-For headers only if Remote IP address is one of
									 these, that is the request reaches the web server from one of your
									 reverse proxies. Otherwise, the client could directly connect to
									 your web server spoofing the X-Forwarded-For headers.',

	'SessionSection'				=> 'Session handling',
	'SessionStorage'				=> 'Memoria sessione:',
	'SessionStorageInfo'			=> 'Questa opzione definisce dove vengono memorizzati i dati della sessione. Per impostazione predefinita, è selezionata la memoria di sessione del file o del database.',
	'SessionModes'	=> [
		'1'		=> 'File',
		'2'		=> 'Database',
	],
	'SessionNotice'					=> 'Mostra la causa di terminazione della sessione:',
	'SessionNoticeInfo'				=> 'Indica la causa dell’interruzione della sessione.',
	'LoginNotice'					=> 'Avviso di accesso:',
	'LoginNoticeInfo'				=> 'Visualizza un avviso di accesso.',

	'RewriteMode'					=> 'Usa <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'If your web server supports this feature, turn to get "beautiful" the addresses of pages.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parametri responsabili del controllo dell\'accesso e delle autorizzazioni.',
	'PermissionsSettingsUpdated'	=> 'Impostazioni autorizzazioni aggiornate',

	'PermissionsSection'		=> 'Rights and privileges',
	'ReadRights'				=> 'Diritti di lettura per impostazione predefinita:',
	'ReadRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'WriteRights'				=> 'Diritti di scrittura per impostazione predefinita:',
	'WriteRightsInfo'			=> 'Predefinito assegnato alle pagine radice create, così come le pagine per le quali le ACL genitore non possono essere definite.',
	'CommentRights'				=> 'Diritti di commento per impostazione predefinita:',
	'CommentRightsInfo'			=> 'Predefinito assegnato alle pagine radice create, così come le pagine per le quali le ACL genitore non possono essere definite.',
	'CreateRights'				=> 'Crea i diritti di una sotto-pagina per impostazione predefinita:',
	'CreateRightsInfo'			=> 'Predefinito assegnato alle sotto-pagine create.',
	'UploadRights'				=> 'Carica diritti per impostazione predefinita:',
	'UploadRightsInfo'			=> 'Diritti di caricamento predefiniti.',
	'RenameRights'				=> 'Rinominare a destra globale:',
	'RenameRightsInfo'			=> 'L\'elenco dei permessi per rinominare liberamente (spostare).',

	'LockAcl'					=> 'Blocca tutte le ACL per leggere soltanto:',
	'LockAclInfo'				=> '<span class="cite">Sovrascrive le impostazioni ACL per tutte le pagine in sola lettura.</span><br>Potrebbe essere utile se un progetto è finito, si desidera una modifica immediata per un periodo di tempo per motivi di sicurezza, o come risposta di emergenza a un exploit o vulnerabilità.',
	'HideLocked'				=> 'Nascondi pagine inaccessibili:',
	'HideLockedInfo'			=> 'Se l\'utente non ha il permesso di leggere la pagina, nasconderlo in diverse liste di pagine (tuttavia il link inserito nel testo sarà ancora visibile).',
	'RemoveOnlyAdmins'			=> 'Solo gli amministratori possono eliminare le pagine:',
	'RemoveOnlyAdminsInfo'		=> 'Nega tutto, tranne gli amministratori, la possibilità di eliminare pagine. Il primo limite si applica ai proprietari di pagine normali.',
	'OwnersRemoveComments'		=> 'I proprietari delle pagine possono eliminare i commenti:',
	'OwnersRemoveCommentsInfo'	=> 'Consenti ai proprietari di moderare i commenti sulle loro pagine.',
	'OwnersEditCategories'		=> 'I proprietari possono modificare le categorie della pagina:',
	'OwnersEditCategoriesInfo'	=> 'Consenti ai proprietari di modificare l\'elenco delle categorie di pagine del tuo sito (aggiungere parole, eliminare parole), assegna a una pagina.',
	'TermHumanModeration'		=> 'Term human moderation:',
	'TermHumanModerationInfo'	=> 'I moderatori possono modificare i commenti solo se sono stati creati non più di questo numero di giorni fa (questa limitazione non si applica all’ultimo commento nell’argomento).',

	'UserCanDeleteAccount'		=> 'Gli utenti possono eliminare il proprio account',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parametri responsabili della sicurezza generale della piattaforma, delle restrizioni di sicurezza e dei sottosistemi di sicurezza aggiuntivi.',
	'SecuritySettingsUpdated'	=> 'Impostazioni di sicurezza aggiornate',

	'AllowRegistration'			=> 'Registrati online:',
	'AllowRegistrationInfo'		=> 'Aprire la registrazione dell’utente. Disabilitando questa opzione si impedisce la registrazione gratuita, tuttavia, l’amministratore del sito potrà registrare personalmente gli altri utenti.',
	'ApproveNewUser'			=> 'Approva nuovi utenti:',
	'ApproveNewUserInfo'		=> 'Consente agli amministratori di approvare gli utenti una volta registrati. Solo gli utenti approvati potranno accedere al sito.',
	'PersistentCookies'			=> 'Cookie persistenti:',
	'PersistentCookiesInfo'		=> 'Consenti cookie persistenti.',
	'DisableWikiName'			=> 'Disabilita WikiName:',
	'DisableWikiNameInfo'		=> 'Disabilita l\'uso obbligatorio di un WikiName per gli utenti. Permette la registrazione dell\'utente con soprannomi tradizionali invece di nomi forzati CamelCase-formattati (cioè, NameCognome).',
	'UsernameLength'			=> 'Lunghezza nome utente:',
	'UsernameLengthInfo'		=> 'Numero minimo e massimo di caratteri nei nomi utente.',

	'EmailSection'				=> 'E-mail',
	'AllowEmailReuse'			=> 'Consenti il riutilizzo dell\'indirizzo email:',
	'AllowEmailReuseInfo'		=> 'Diversi utenti possono registrarsi con lo stesso indirizzo email.',
	'EmailConfirmation'			=> 'Imporre la conferma via e-mail:',
	'EmailConfirmationInfo'		=> 'Richiede all’utente di verificare il suo indirizzo e-mail prima di poter accedere.',
	'AllowedEmailDomains'		=> 'Domini e-mail consentiti:',
	'AllowedEmailDomainsInfo'	=> 'Domini e-mail consentiti separati da virgole, ad esempio <code>example.com, local.lan</code> ecc, other wise all email domains are allowed.',
	'ForbiddenEmailDomains'		=> 'Domini e-mail proibiti:',
	'ForbiddenEmailDomainsInfo'	=> 'Domini e-mail vietati separati da una virgola, ad esempio <code>example.com, local.lan</code> ecc (efficace solo se l’elenco dei domini e-mail consentiti è vuoto)',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Abilita captcha:',
	'EnableCaptchaInfo'			=> 'Se abilitata, il captcha verrà mostrato nei seguenti casi, o se viene raggiunta una soglia di sicurezza.',
	'CaptchaComment'			=> 'Nuovo commento:',
	'CaptchaCommentInfo'		=> 'Come protezione contro lo spam, gli utenti non registrati devono completare captcha prima di commentare verrà pubblicato.',
	'CaptchaPage'				=> 'Nuova pagina:',
	'CaptchaPageInfo'			=> 'Come protezione contro lo spam, gli utenti non registrati devono completare il captcha prima di creare una nuova pagina.',
	'CaptchaEdit'				=> 'Modifica pagina:',
	'CaptchaEditInfo'			=> 'Come protezione contro lo spam, gli utenti non registrati devono completare captcha prima di modificare le pagine.',
	'CaptchaRegistration'		=> 'Registrazione:',
	'CaptchaRegistrationInfo'	=> 'Come protezione contro lo spam, gli utenti non registrati devono completare il captcha prima di registrarsi.',

	'TlsSection'				=> 'Impostazioni TLS',
	'TlsConnection'				=> 'TLS-Connection:',
	'TlsConnectionInfo'			=> 'Usa la connessione TLS. <span class="cite">Attiva il certificato TLS preinstallato richiesto sul server, altrimenti perderai l\'accesso al pannello amministratore!</span><br>Determina anche se è impostato il Contrassegno Cookie Sicuro: il flag <code>secure</code> specifica se i cookie devono essere inviati solo tramite connessioni protette.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Con la forza ricollegare il client da HTTP a HTTPS. Con l\'opzione disabilitata, il client può navigare il sito attraverso un canale HTTP aperto.',

	'HttpSecurityHeaders'		=> 'Intestazioni Di Sicurezza Http',
	'EnableSecurityHeaders'		=> 'Enable Security Headers:',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk !',
	'Csp'						=> 'Content-Security-Policy (CSP):',
	'CspInfo'					=> 'Configuring Content Security Policy involves deciding what policies you want to enforce, and then configuring them and using Content-Security-Policy to establish your policy.',
	'PolicyModes'	=> [
		'0'		=> 'disabilitata',
		'1'		=> 'rigoroso',
		'2'		=> 'personalizzato',
	],
	'PermissionsPolicy'			=> 'Permissions Policy:',
	'PermissionsPolicyInfo'		=> 'L’intestazione HTTP Permissions-Policy fornisce un meccanismo per abilitare o disabilitare esplicitamente varie potenti caratteristiche del browser.',
	'ReferrerPolicy'			=> 'Referrer Policy:',
	'ReferrerPolicyInfo'		=> 'The Referrer-Policy HTTP header governs which referrer information, sent in the Referer header, should be included with requests made.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'nessun referente',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'omonima origine',
		'4'		=> 'origine',
		'5'		=> 'strict-origin',
		'6'		=> 'origine-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> 'Persistence of user passwords',
	'PwdMinChars'				=> 'Lunghezza minima della password:',
	'PwdMinCharsInfo'			=> 'Le password più lunghe sono necessariamente più sicure delle password più corte (ad esempio da 12 a 16 caratteri).<br>L\'uso delle parole d\'ordine invece delle password è incoraggiato.',
	'AdminPwdMinChars'			=> 'Minimum Admin password length:',
	'AdminPwdMinCharsInfo'		=> 'Le password più lunghe sono necessariamente più sicure rispetto alle password più corte (ad esempio da 15 a 20 caratteri).<br>L\'uso delle parole d\'ordine invece delle password è incoraggiato.',
	'PwdCharComplexity'			=> 'La complessità della password richiesta:',
	'PwdCharClasses'	=> [
		'0'		=> 'non testato',
		'1'		=> 'eventuali lettere + numeri',
		'2'		=> 'maiuscole e minuscole + numeri',
		'3'		=> 'maiuscole e minuscole + numeri + caratteri',
	],
	'PwdUnlikeLogin'			=> 'Complicazione aggiuntiva:',
	'PwdUnlikes'	=> [
		'0'		=> 'non testato',
		'1'		=> 'la password non è identica al login',
		'2'		=> 'la password non contiene nome utente',
	],

	'LoginSection'				=> 'Entra',
	'MaxLoginAttempts'			=> 'Numero massimo di tentativi di login per nome utente:',
	'MaxLoginAttemptsInfo'		=> 'Il numero di tentativi di accesso consentiti per un singolo account prima dell\'attivazione del task anti-spambot. Inserisci 0 per evitare che l\'attività anti-spambot venga attivata per account utente distinti.',
	'IpLoginLimitMax'			=> 'Numero massimo di tentativi di accesso per indirizzo IP:',
	'IpLoginLimitMaxInfo'		=> 'La soglia dei tentativi di accesso consentiti da un singolo indirizzo IP prima che un task anti-spambot venga attivato. Inserisci 0 per evitare che l\'attività anti-spambot venga attivata dagli indirizzi IP.',

	'FormsSection'				=> 'Moduli',
	'FormTokenTime'				=> 'Tempo massimo per inviare i moduli:',
	'FormTokenTimeInfo'			=> 'Il tempo che un utente deve inviare un modulo (in secondi).<br> Si noti che un modulo potrebbe diventare non valido se la sessione scade, indipendentemente da questa impostazione.',

	'SessionLength'				=> 'Term login cookie:',
	'SessionLengthInfo'			=> 'La durata del cookie di sessione utente per impostazione predefinita (in giorni).',
	'CommentDelay'				=> 'Anti-alluvione per commenti:',
	'CommentDelayInfo'			=> 'Il ritardo minimo tra la pubblicazione dei commenti dei nuovi utenti (in secondi).',
	'IntercomDelay'				=> 'Anti-alluvione per comunicazioni personali:',
	'IntercomDelayInfo'			=> 'Il ritardo minimo tra l\'invio di messaggi privati (in secondi).',
	'RegistrationDelay'			=> 'Soglia di tempo per la registrazione:',
	'RegistrationDelayInfo'		=> 'La soglia minima di tempo tra le presentazioni del modulo di registrazione per scoraggiare i bot di registrazione (in secondi).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Group of parameters responsible for the fine tuning platform. Do not change them unless you are confident in their actions.',
	'FormatterSettingsUpdated'	=> 'Impostazioni di formattazione aggiornate',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> 'Typographical Proofreader:',
	'TypograficaInfo'			=> 'Unsetting slightly speed up the process of adding comments and save the page.',
	'Paragrafica'				=> 'Marcature Paragrafica:',
	'ParagraficaInfo'			=> 'Similar to the previous option, but will lead to disconnection of inoperable automatic table of contents: <code>{{toc}}</code>.',
	'AllowRawhtml'				=> 'Global HTML Support:',
	'AllowRawhtmlInfo'			=> 'Questa opzione è potenzialmente pericolosa per un sito aperto.',
	'SafeHtml'					=> 'Filtraggio HTML:',
	'SafeHtmlInfo'				=> 'Prevents saving of dangerous HTML-objects. Turning off the filter on an open site with HTML support is <span class="underline">extremely</span> undesirable!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formatter)',
	'X11colors'					=> 'X11 Colors Usage:',
	'X11colorsInfo'				=> 'Extents the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code>Unsetting slightly speeds up the process of adding comments and saving of pages.',
	'WikiLinks'					=> 'Disable Wikilinks:',
	'WikiLinksInfo'				=> 'Disables linking for <code>CamelCaseWords</code>, your CamelCase Words will no longer be linked directly to a new page. This is useful when you work across different namespaces aks clusters. By default it is off.',
	'BracketsLinks'				=> 'Disable bracketslinks:',
	'BracketsLinksInfo'			=> 'Disabilita la sintassi <code>[[link]]</code> e <code>((link))</code>.',
	'Formatters'				=> 'Disable Formatters:',
	'FormattersInfo'			=> 'Disabilita la sintassi <code>%%code%%</code> , usata per gli evidenziatori.',

	'DateFormatsSection'		=> 'Formati Data',
	'DateFormat'				=> 'Il formato della data:',
	'DateFormatInfo'			=> '(giorno, mese, anno)',
	'TimeFormat'				=> 'Il formato del tempo:',
	'TimeFormatInfo'			=> '(ora, minuto)',
	'TimeFormatSeconds'			=> 'Il formato del tempo esatto:',
	'TimeFormatSecondsInfo'		=> '(ore, minuti, secondi)',
	'NameDateMacro'				=> 'Il formato del macro <code>::@::</code>:',
	'NameDateMacroInfo'			=> '(nome, ora), ad esempio <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Fuso orario:',
	'TimezoneInfo'				=> 'Fuso orario da utilizzare per la visualizzazione degli orari agli utenti che non sono collegati (ospiti). Gli utenti registrati impostano e possono cambiare il loro fuso orario nelle loro impostazioni utente.',

	'Canonical'					=> 'Usa URL canoniche:',
	'CanonicalInfo'				=> 'Tutti i link vengono creati come URL assoluti nella forma %1. Sono da preferire gli URL relativi alla radice del server nella forma %2.',
	'LinkTarget'				=> 'Dove si aprono collegamenti esterni:',
	'LinkTargetInfo'			=> 'Apre ogni link esterno in una nuova finestra del browser. Aggiunge <code>target="_blank"</code> alla sintassi del link.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Richiede che il browser non invii un header di riferimento HTTP se l’utente segue il collegamento ipertestuale. Aggiunge <code>rel="noreferrer"</code> alla sintassi del link.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Istruire alcuni motori di ricerca che il link ipertestuale non deve influenzare il posizionamento dei link target nell’indice dei motori di ricerca. Aggiunge <code>rel="nofollow"</code> alla sintassi del link.',
	'UrlsUnderscores'			=> 'Indirizzi di modulo (URL) con sottolineatura:',
	'UrlsUnderscoresInfo'		=> 'For example %1 becames %2 with this option.',
	'ShowSpaces'				=> 'Mostra gli spazi nei NomiWiki:',
	'ShowSpacesInfo'			=> 'Mostra gli spazi in WikiNames, ad esempio <code>MyName</code> che vengono visualizzati come <code>Il mio nome</code> con questa opzione.',
	'NumerateLinks'				=> 'Numerate links in print view:',
	'NumerateLinksInfo'			=> 'Numerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disabilita e visualizza i link di auto-referenziazione:',
	'YouareHereTextInfo'		=> 'Visualizing links to the same page, try to <code>&lt;b&gt;####&lt;/b&gt;</code>, all links-to-self became not links, but bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Qui è possibile impostare o modificare le pagine base del sistema utilizzate all’interno del Wiki. Non dimenticate di creare o modificare le pagine corrispondenti nel Wiki in base alle vostre impostazioni.',
	'PagesSettingsUpdated'		=> 'Pagine di base delle impostazioni aggiornate',

	'ListCount'					=> 'Numero di articoli per lista:',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> 'Forum Opzioni',
	'ForumCluster'				=> 'Cluster Forum:',
	'ForumClusterInfo'			=> 'Root cluster per sezione forum (azione %1).',
	'ForumTopics'				=> 'Numero di argomenti per pagina:',
	'ForumTopicsInfo'			=> 'Numero di argomenti visualizzati in ogni pagina della lista nelle sezioni del forum (azione %1).',
	'CommentsCount'				=> 'Numero di commenti per pagina:',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page list of comments. This applies to all the comments on the site, and not just posted in the forum.',

	'NewsSection'				=> 'Sezione Notizie',
	'NewsCluster'				=> 'Cluster for the News:',
	'NewsClusterInfo'			=> 'Root cluster per la sezione notizie (azione %1).',
	'NewsStructure'				=> 'Struttura del cluster di news:',
	'NewsStructureInfo'			=> 'Memorizza gli articoli facoltativamente nei sub-cluster per anno/mese o settimana (ad esempio <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licenza',
	'DefaultLicense'			=> 'Licenza predefinita:',
	'DefaultLicenseInfo'		=> 'Under which license should your content be released.',
	'EnableLicense'				=> 'Enable License:',
	'EnableLicenseInfo'			=> 'Abilita per mostrare le informazioni sulla licenza.',
	'LicensePerPage'			=> 'Licenza per pagina:',
	'LicensePerPageInfo'		=> 'Consenti licenza per pagina, che il proprietario della pagina può scegliere tramite le proprietà della pagina.',

	'ServicePagesSection'		=> 'Service pages',
	'RootPage'					=> 'Pagina iniziale:',
	'RootPageInfo'				=> 'Tag della tua pagina principale, si apre automaticamente quando un utente visita il tuo sito.',

	'PrivacyPage'				=> 'Informativa sulla privacy:',
	'PrivacyPageInfo'			=> 'La pagina con la Privacy Policy del sito.',

	'TermsPage'					=> 'Policies and Regulations:',
	'TermsPageInfo'				=> 'La pagina con le regole del sito.',

	'SearchPage'				=> 'Ricerca:',
	'SearchPageInfo'			=> 'Pagina con il modulo di ricerca (azione %1).',
	'RegistrationPage'			=> 'Registrazione:',
	'RegistrationPageInfo'		=> 'Page new user registration (action %1).',
	'LoginPage'					=> 'Accesso utente:',
	'LoginPageInfo'				=> 'Pagina di accesso sul sito (azione %1).',
	'SettingsPage'				=> 'Impostazioni Utente:',
	'SettingsPageInfo'			=> 'Page customize the user profile (action %1).',
	'PasswordPage'				=> 'Cambia Password:',
	'PasswordPageInfo'			=> 'Pagina con un modulo per cambiare / interrogare la password utente (azione %1).',
	'UsersPage'					=> 'Elenco utenti:',
	'UsersPageInfo'				=> 'Pagina con un elenco di utenti registrati (azione %1).',
	'CategoryPage'				=> 'Categoria:',
	'CategoryPageInfo'			=> 'Pagina con un elenco di pagine categorizzate (azione %1).',
	'GroupsPage'				=> 'Gruppi:',
	'GroupsPageInfo'			=> 'Pagina con un elenco di gruppi di lavoro (azione %1).',
	'ChangesPage'				=> 'Ultimi modifiche:',
	'ChangesPageInfo'			=> 'Pagina con un elenco delle ultime pagine modificate (azione %1).',
	'CommentsPage'				=> 'Commenti recenti:',
	'CommentsPageInfo'			=> 'Page with a list of recent comment on the page (action %1).',
	'RemovalsPage'				=> 'Pagine eliminate:',
	'RemovalsPageInfo'			=> 'Pagina con un elenco di pagine cancellate di recente (azione %1).',
	'WantedPage'				=> 'Pagine desiderate:',
	'WantedPageInfo'			=> 'Pagina con un elenco di pagine mancanti che sono referenziate (azione %1).',
	'OrphanedPage'				=> 'Pagine orfane:',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related links with the rest (action %1).',
	'SandboxPage'				=> 'Sandbox:',
	'SandboxPageInfo'			=> 'Page where users can be trained in the use of wiki-markup.',
	'HelpPage'					=> 'Aiuto:',
	'HelpPageInfo'				=> 'La sezione documentazione per lavorare con gli strumenti del sito.',
	'IndexPage'					=> 'Indice:',
	'IndexPageInfo'				=> 'Pagina con l’elenco di tutte le pagine (action %1).',
	'RandomPage'				=> 'Casuale:',
	'RandomPageInfo'			=> 'Carica una pagina casuale  (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parametri per le notifiche della piattaforma.',
	'NotificationSettingsUpdated'	=> 'Impostazioni di notifica aggiornate',

	'EmailNotification'			=> 'Email Notification:',
	'EmailNotificationInfo'		=> 'Allow email notification. Set to ON to enable email notifications, OFF to disable them. Note that disabling email notifications has no effect on emails generated as part of the user signup process.',
	'Autosubscribe'				=> 'Autosubscribe:',
	'AutosubscribeInfo'			=> 'Automatically sign a new page in the owner’s notice of its changes.',

	'NotificationSection'		=> 'Default user notification settings',
	'NotifyPageEdit'			=> 'Notifica modifica pagina:',
	'NotifyPageEditInfo'		=> 'Pending - Sending a email notification only for the first change until the user visits the page again.',
	'NotifyMinorEdit'			=> 'Notifica modifica minore:',
	'NotifyMinorEditInfo'		=> 'Invia notifiche anche per modifiche minori.',
	'NotifyNewComment'			=> 'Notificare il nuovo commento:',
	'NotifyNewCommentInfo'		=> 'Pending - Sending a email notification only for the first comment until the user visits the page again.',

	'NotifyUserAccount'			=> 'Notificare il nuovo account utente:',
	'NotifyUserAccountInfo'		=> 'L\'amministratore verrà avvisato quando un nuovo utente sarà stato creato utilizzando il modulo di registrazione.',
	'NotifyUpload'				=> 'Notifica caricamento file:',
	'NotifyUploadInfo'			=> 'I Moderatori saranno avvisati quando un file sarà stato caricato.',

	'PersonalMessagesSection'	=> 'Messaggi personali',
	'AllowIntercomDefault'		=> 'Allow Intercom:',
	'AllowIntercomDefaultInfo'	=> 'Enable this option allows other users sending personal messages to the recipient email-address without disclosing the address.',
	'AllowMassemailDefault'		=> 'Allow Massemail:',
	'AllowMassemailDefaultInfo'	=> 'It send only messages to those user who allowed Administrators to email them information.',

	// Resync settings
	'Synchronize'				=> 'Sincronizzare',
	'UserStatsSynched'			=> 'Statistiche utente sincronizzate.',
	'PageStatsSynched'			=> 'Statistiche pagina sincronizzate.',
	'FeedsUpdated'				=> 'RSS-feed aggiornati.',
	'SiteMapCreated'			=> 'La nuova versione della mappa del sito creata con successo.',
	'ParseNextBatch'			=> 'Analizza il prossimo lotto di pagine:',
	'WikiLinksRestored'			=> 'Wiki-links ripristinati.',

	'LogUserStatsSynched'		=> 'Statistiche utente sincronizzate',
	'LogPageStatsSynched'		=> 'Statistiche pagina sincronizzate',
	'LogFeedsUpdated'			=> 'Feed RSS sincronizzati',
	'LogPageBodySynched'		=> 'Corpo e link della pagina riesaminati',

	'UserStats'					=> 'User Statistics',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'PageStats'					=> 'Statistiche di pagina',
	'PageStatsInfo'				=> 'Page statistics (number of comments, files and revisions) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',

	'AttachmentsInfo'			=> 'Aggiorna l’hash del file per tutti gli allegati nel database.',
	'AttachmentsSynched'		=> 'Revisione dell’hash di tutti i file allegati',
	'LogAttachmentsSynched'		=> 'Revisione dell’hash di tutti i file allegati',

	'Feeds'						=> 'Feed',
	'FeedsInfo'					=> 'In caso di modifica diretta delle pagine nel database, il contenuto dei feed RSS-feed potrebbe non riflettere le modifiche apportate. <br>Questa funzione sincronizza i canali RSS-channels con lo stato corrente del database.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'Questa funzione sincronizza la XML-Sitemap con lo stato attuale del database.',
	'XmlSiteMapPeriod'			=> 'Periodo %1 giorni. Ultima scrittura %2.',
	'XmlSiteMapView'			=> 'Mostra Sitemap in una nuova finestra.',

	'ReparseBody'				=> 'Riesamina tutte le pagine',
	'ReparseBodyInfo'			=> 'Svuota <code>body_r</code> nella tabella delle pagine, in modo che ogni pagina venga nuovamente renderizzata nella vista delle pagine successive. Questo può essere utile se hai modificato il formattatore o cambiato il dominio della tua wiki.',
	'PreparsedBodyPurged'		=> 'Campo <code>body_r</code> vuoto nella tabella delle pagine.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Performs a re-rendering for all intrasite links and restores the contents of the table <code>page_link</code> and <code>file_link</code> in the event of damage or relocation (this can take considerable time).',
	'RecompilePage'				=> 'Ricompilazione di tutte le pagine (estremamente costose)',
	'ResyncOptions'				=> 'Opzioni aggiuntive',
	'RecompilePageLimit'		=> 'Numero di pagine da analizzare contemporaneamente.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Questo modulo viene usato quando si inviano email ai propri utenti dalla Board. Assicurati che l’indirizzo email specificato sia valido; ogni messaggio respinto o non consegnato, verrà inviato a questo indirizzo. Se il tuo server non fornisce un servizio email (basato su PHP) puoi in alternativa inviare messaggi direttamente via SMTP. Questo richiede l’indirizzo di un server appropriato (chiedi al tuo provider, se necessario). Non specificare nomi vecchi qui. Se il server richiede autenticazione (e solo se lo fa) inserisci nome utente e password.',

	'EmailSettingsUpdated'		=> 'Impostazioni email aggiornate',

	'EmailFunctionName'			=> 'Nome funzione email:',
	'EmailFunctionNameInfo'		=> 'Funzione email usata per spedire mail attraverso PHP.',
	'UseSmtpInfo'				=> 'Scegli <code>SMTP</code> se vuoi o devi inviare email attraverso un server specifico invece di usare la funzione mail locale.',

	'EnableEmail'				=> 'Abilita email:',
	'EnableEmailInfo'			=> 'Enabling emails',

	'EmailIdentitySettings'		=> 'Sito web Email Identità',
	'FromEmailName'				=> 'From Name:',
	'FromEmailNameInfo'			=> 'The sender name, part of <code>From:</code> header in emails for all the email-notification sent from the site.',
	'EmailSubjectPrefix'		=> 'Prefisso dell’oggetto:',
	'EmailSubjectPrefixInfo'	=> 'Prefisso alternativo dell’oggetto dell’e-mail, ad esempio <code>[Prefisso] Argomento</code>. Se non è definito, il prefisso predefinito è Nome del sito: %1.',

	'NoReplyEmail'				=> 'Indirizzo senza risposta:',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all your email-notifications sent from the site.',
	'AdminEmail'				=> 'Email del proprietario del sito:',
	'AdminEmailInfo'			=> 'Questo indirizzo è utilizzato per scopi amministrativi, come la notifica del nuovo utente.',
	'AbuseEmail'				=> 'Servizio di abuso e-mail:',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may coincide with the previous.',

	'SendTestEmail'				=> 'Invia email di prova',
	'SendTestEmailInfo'			=> 'Questo invierà un’email di prova all’indirizzo specificato sul tuo account.',
	'TestEmailSubject'			=> 'Il tuo Wiki è configurato correttamente per inviare email',
	'TestEmailBody'				=> 'Se hai ricevuto questa email, il tuo Wiki è configurato correttamente per inviare e-mail.',
	'TestEmailMessage'			=> 'The test email has been sent.<br>If you don’t receive it, please check your emails configuration.',

	'SmtpSettings'				=> 'Impostazioni SMTP',
	'SmtpAutoTls'				=> 'TLS Opportunistici:',
	'SmtpAutoTlsInfo'			=> 'Abilita la crittografia automaticamente, se vede che il server è una crittografia TLS pubblicitaria (dopo aver connesso al server), anche se non hai impostato la modalità di connessione per <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Metodo autenticazione per SMTP:',
	'SmtpConnectionModeInfo'	=> 'Si usa solo se un nome utente o una password sono impostati. Chiedi al tuo provider se non sei sicuro del metodo da usare.',
	'SmtpPassword'				=> 'Password SMTP:',
	'SmtpPasswordInfo'			=> 'Inserisci una password solo se il tuo server SMTP la richiede. <br><em><strong>Attenzione:</strong> questa password è conservata come testo in chiaro nel database.</em>',
	'SmtpPort'					=> 'Porta del server SMTP:',
	'SmtpPortInfo'				=> 'Modifica questo parametro solo se sai che il tuo server SMTP si trova su una porta diversa. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Indirizzo server SMTP:',
	'SmtpServerInfo'			=> 'Tieni presente che è necessario fornire il protocollo che il server utilizza. Se si utilizza il protocollo SSL, questo deve essere <code>ssl://mail.example.com</code>',
	'SmtpUsername'				=> 'Nome utente SMTP:',
	'SmtpUsernameInfo'			=> 'Inserisci un nome utente solo se il tuo server SMTP lo richiede.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Da qui puoi configurare le caratteristiche principali degli allegati e delle categorie speciali collegate.',
	'UploadSettingsUpdated'		=> 'Impostazioni di caricamento aggiornate',

	'FileUploadsSection'		=> 'File uploads',
	'RegisteredUsers'			=> 'utenti registrati',
	'RightToUpload'				=> 'Right to the upload files:',
	'RightToUploadInfo'			=> '<code>amministratori</code> significa che solo gli utenti appartenenti al gruppo amministratori possono caricare file. <code>1</code> significa che il caricamento è aperto agli utenti registrati. <code>0</code> significa che il caricamento è disabilitato.',
	'UploadMaxFilesize'			=> 'Dimensione massima:',
	'UploadMaxFilesizeInfo'		=> 'Dimensione massima di ogni file. Se questo valore è uguale a 0, la dimensione del file inviabile sarà limitata solo dalla configurazione PHP.',
	'UploadQuota'				=> 'Quota massima allegati:',
	'UploadQuotaInfo'			=> 'Dimensione massima riservata su disco per tutti gli allegati; <code>0</code> = illimitata. %1 used.',
	'UploadQuotaUser'			=> 'Quota di stoccaggio per utente:',
	'UploadQuotaUserInfo'		=> 'Limitazione della quota di archiviazione che può essere caricata da un utente, con <code>0</code> illimitata.',

	'FileTypes'					=> 'Tipi di file',
	'UploadOnlyImages'			=> 'Consenti solo il caricamento delle immagini:',
	'UploadOnlyImagesInfo'		=> 'Consenti solo il caricamento di file di immagini sulla pagina.',
	'AllowedUploadExts'			=> 'Tipi di file consentiti:',
	'AllowedUploadExtsInfo'		=> 'Estensioni consentite per il caricamento dei file, separate da una virgola, ad esempio <code>png, ogg, mp4</code>, altrimenti sono consentite tutte le estensioni di file non vietate.<br>Si consiglia di limitare l’elenco dei tipi di file caricati consentiti al minimo necessario per la funzionalità dei contenuti del sito.',
	'CheckMimetype'				=> 'Controlla allegati:',
	'CheckMimetypeInfo'			=> 'Alcuni browser possono essere ingannati nell’accettare un mimetype incorretto per i file da caricare. Questa opzione garantisce che i file che possono causare questo problema vengano respinti.',
	'SvgSanitizer'				=> 'SVG Sanitizer:',
	'SvgSanitizerInfo'			=> 'Questo permette di sanificare i file SVG caricati per evitare che vengano caricati file SVG/XML vulnerabili.',
	'TranslitFileName'			=> 'Traslitterare i nomi dei file:',
	'TranslitFileNameInfo'		=> 'Se è applicabile e non è necessario avere caratteri Unicode, si raccomanda vivamente di accettare solo caratteri alfanumerici.',
	'TranslitCaseFolding'		=> 'Converte i nomi dei file in minuscolo:',
	'TranslitCaseFoldingInfo'	=> 'Questa opzione è efficace solo con la traslitterazione attiva.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Crea miniatura:',
	'CreateThumbnailInfo'		=> 'Crea miniatura in tutte le situazioni possibili.',
	'JpegQuality'				=> 'Qualità JPEG:',
	'JpegQualityInfo'			=> 'Qualità quando si scala una miniatura JPEG. Dovrebbe essere compreso tra 1 e 100, con 100 che indica una qualità del 100%.',
	'MaxImageArea'				=> 'Maximum Image Area:',
	'MaxImageAreaInfo'			=> 'Il numero massimo di pixel che un’immagine sorgente può avere. Questo fornisce un limite all’uso della memoria per il lato di decompressione dello scalatore di immagini. <br><code>-1</code> significa che non controllerà la dimensione dell’immagine prima di tentare di scalarla. <code>0</code> significa che determinerà il valore automaticamente.',
	'MaxThumbWidth'				=> 'Larghezza massima miniatura in pixel:',
	'MaxThumbWidthInfo'			=> 'La miniatura generata non avrà una larghezza superiore a quella impostata qui.',
	'MinThumbFilesize'			=> 'Dimensioni minime per miniatura:',
	'MinThumbFilesizeInfo'		=> 'Non crea miniature per immagini con dimensioni inferiori a queste.',
	'MaxImageWidth'				=> 'Limite di dimensione dell’immagine nelle pagine:',
	'MaxImageWidthInfo'			=> 'La larghezza massima che un’immagine può avere nelle pagine, altrimenti viene generata una miniatura ridimensionata.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'List of removed pages, revisions and files.
									Finally remove or restore the pages, revisions or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Parole che verranno censurate automaticamente sul tuo Wiki.',
	'FilterSettingsUpdated'		=> 'Impostazioni del filtro spam aggiornate',

	'WordCensoringSection'		=> 'Word censoring',
	'SPAMFilter'				=> 'SPAM Filter:',
	'SPAMFilterInfo'			=> 'Enabling SPAM Filter',
	'WordList'					=> 'Elenco parole:',
	'WordListInfo'				=> 'Frammento <code>di parola o frase</code> da annerire (uno per riga)',

	// Log module
	'LogFilterTip'				=> 'Filtra gli eventi per criteri:',
	'LogLevel'					=> 'Livello',
	'LogLevelFilters'	=> [
		'1'		=> 'non meno di',
		'2'		=> 'non superiore a',
		'3'		=> 'uguale',
	],
	'LogNoMatch'				=> 'Nessun evento che soddisfi i criteri',
	'LogDate'					=> 'Data',
	'LogEvent'					=> 'Evento',
	'LogUsername'				=> 'Nome utente',
	'LogLevels'	=> [
		'1'		=> 'critico',
		'2'		=> 'più alto',
		'3'		=> 'alto',
		'4'		=> 'medio',
		'5'		=> 'basso',
		'6'		=> 'più basso',
		'7'		=> 'debug',
	],

	// Massemail module
	'MassemailInfo'				=> 'Da qui puoi inviare messaggi email a tutti gli utenti o a quelli di un gruppo specifico, <strong>purché abbiano l’opzione di ricevere email di massa dall’amministratore abilitata</strong>. L’email verrà inviata all’indirizzo amministrativo del Forum, e i destinatari la riceveranno come copia di conoscenza nascosta (CCN). Le impostazioni predefinite prevedono un massimo di 20 destinatari per ciascuna email, quindi se il numero è maggiore, verranno spedite diverse email; pertanto abbi pazienza dopo l’invio e non bloccare il procedimento in corso, in quanto potrebbe durare anche diversi minuti se il numero di destinatari è molto elevato. Al termine dell’operazione verrai informato dell’avvenuto invio.',
	'LogMassemail'				=> 'Messemail send %1 to group / user ',
	'MassemailSend'				=> 'Massemail send',

	'NoEmailMessage'			=> 'Devi scrivere il messaggio.',
	'NoEmailSubject'			=> 'Devi specificare un titolo per il tuo messaggio.',
	'NoEmailRecipient'			=> 'Devi specificare almeno un utente o un gruppo di utenti.',

	'MassemailSection'			=> 'E-mail di massa',
	'MessageSubject'			=> 'Soggetto:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Il tuo messaggio:',
	'YourMessageInfo'			=> 'Puoi scrivere soltanto testo normale. Tutto il resto sarà rimosso prima della trasmissione.',

	'NoUser'					=> 'Nessun utente',
	'NoUserGroup'				=> 'Nessun gruppo di utenti',

	'SendToGroup'				=> 'Invia a gruppo:',
	'SendToUser'				=> 'Invia a utenti:',
	'SendToUserInfo'			=> 'It send only messages to those user who allowed Administrators to email them information. This option is available in their user settings under Notifications.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Messaggio di sistema aggiornato',

	'SysMsgSection'				=> 'System message',
	'SysMsg'					=> 'Messaggio di sistema:',
	'SysMsgInfo'				=> 'Il tuo testo qui',

	'SysMsgType'				=> 'Tipo:',
	'SysMsgTypeInfo'			=> 'Tipo di messaggio (CSS).',
	'SysMsgAudience'			=> 'Pubblico:',
	'SysMsgAudienceInfo'		=> 'Pubblico a cui viene mostrato il messaggio di sistema.',
	'EnableSysMsg'				=> 'Abilita messaggio di sistema:',
	'EnableSysMsgInfo'			=> 'Mostra messaggio di sistema.',

	// User approval module
	'ApproveNotExists'			=> 'Si prega di selezionare almeno un utente tramite il pulsante Imposta.',

	'LogUserApproved'			=> 'Utente ##%1## approvato',
	'LogUserBlocked'			=> 'Utente ##%1## bloccato',
	'LogUserDeleted'			=> 'Utente ##%1## rimosso dal database',
	'LogUserCreated'			=> 'Creato un nuovo utente ##%1##',
	'LogUserUpdated'			=> 'Utente Aggiornato ##%1##',

	'UserApproveInfo'			=> 'Approva nuovi utenti prima che siano in grado di accedere al sito.',
	'Approve'					=> 'Approva',
	'Deny'						=> 'Nega',
	'Pending'					=> 'In Attesa',
	'Approved'					=> 'Approvato',
	'Denied'					=> 'Negato',

	// DB Backup module
	'BackupStructure'			=> 'Struttura',
	'BackupData'				=> 'Dati',
	'BackupFolder'				=> 'Cartella',
	'BackupTable'				=> 'Tabella',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'File',
	'BackupNote'				=> 'Nota:',
	'BackupSettings'			=> 'Specify the desired scheme of Backup.<br>' .
    	'The root cluster does not affect the global files backup and cache files backup (being chosen they are always saved in full).<br>' .  '<br>' .
		'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster the tables from this backup will not be restructured, ',
	'BackupCompleted'			=> 'Backup e archiviazione completati.<br>' .
    	'I file dei pacchetti di backup sono stati memorizzati nella sottodirectory %1.<br>. Per scaricarlo usa FTP (mantieni la struttura delle directory e i nomi dei file durante la copia).<br> Per ripristinare una copia di backup o rimuovere un pacchetto, vai su <a href="%2">Ripristina database</a>.',
	'LogSavedBackup'			=> 'Backup salvato del database ##%1##',
	'Backup'					=> 'Backup',
	'CantReadFile'				=> 'Can’t read file %1.',

	// DB Restore module
	'RestoreInfo'				=> 'You can restore any of the backup packages found or remove it from the server.',
	'ConfirmDbRestore'			=> 'Si desidera ripristinare il backup %1?',
	'ConfirmDbRestoreInfo'		=> 'Per favore, aspetta che ci vorrà qualche minuto.',
	'RestoreWrongVersion'		=> 'Versione WackoWiki errata!',
	'DirectoryNotExecutable'	=> 'La directory %1 non è eseguibile.',
	'BackupDelete'				=> 'Sei sicuro di voler rimuovere il backup %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Opzioni di ripristino aggiuntive:',
	'RestoreOptionsInfo'		=> '* Prima di ripristinare il backup del cluster <strong></strong>, ' .
									'le tabelle di destinazione non vengono eliminate (per evitare la perdita di informazioni dai cluster che non sono stati sottoposti a backup). ' .
									'Così, durante il processo di recupero duplicato record si verificheranno. ' .
									'In normal mode, all of them will be replaced by the records form backup (using SQL-instruction <code>REPLACE</code>), ' .
									'ma se questa casella è selezionata, tutti i duplicati sono saltati (i valori attuali dei record saranno mantenuti), ' .
									'and only the records with new keys are added to the table (SQL-instruction <code>INSERT IGNORE</code>).<br>' .
									'<strong>Avviso</strong>: Quando si ripristina il backup completo del sito, questa opzione non ha valore.<br>' .
									'<br>' .
									'** Se il backup contiene i file utente (globale e perpagina, file cache, ecc.), ' .
									'in modalità normale sostituiscono i file esistenti con gli stessi nomi e vengono posizionati nella stessa directory quando vengono ripristinati. ' .
									'Questa opzione consente di salvare le copie correnti dei file e ripristinare da un backup solo nuovi file (mancanti sul server).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignora i tasti della tabella duplicati (non sostituire)',
	'IgnoreSameFiles'			=> 'Ignora gli stessi file (non sovrascrivere)',
	'NoBackupsAvailable'		=> 'Nessun backup disponibile.',
	'BackupEntireSite'			=> 'Intero sito',
	'BackupRestored'			=> 'Il backup è ripristinato, un report di riepilogo è allegato sotto. Per eliminare questo pacchetto di backup, fare clic su',
	'BackupRemoved'				=> 'Il backup selezionato è stato rimosso con successo.',
	'LogRemovedBackup'			=> 'Backup del database rimosso ##%1##',

	'RestoreStarted'			=> 'Ripristino Iniziato',
	'RestoreParameters'			=> 'Uso dei parametri',
	'IgnoreDuplicatedKeys'		=> 'Ignora i tasti duplicati',
	'IgnoreDuplicatedFiles'		=> 'Ignora i file duplicati',
	'SavedCluster'				=> 'cluster salvato',
	'DataProtection'			=> 'Protezione dei dati - %1 omesso',
	'AssumeDropTable'			=> 'Assumere %1',
	'RestoreTableStructure'		=> 'Ripristino della struttura del tavolo',
	'RunSqlQueries'				=> 'Perform SQL-instructions:',
	'CompletedSqlQueries'		=> 'Completato. Istruzioni elaborate:',
	'NoTableStructure'			=> 'La struttura delle tabelle non è stata salvata - salta',
	'RestoreRecords'			=> 'Ripristina il contenuto delle tabelle',
	'ProcessTablesDump'			=> 'Just download and process tables dump',
	'Instruction'				=> 'Istruzioni',
	'RestoredRecords'			=> 'record:',
	'RecordsRestoreDone'		=> 'Completato. Voci totali:',
	'SkippedRecords'			=> 'Dati non salvati - salta',
	'RestoringFiles'			=> 'Ripristino dei file',
	'DecompressAndStore'		=> 'Decomprimi e memorizza i contenuti delle directory',
	'HomonymicFiles'			=> 'file omonimici',
	'RestoreSkip'				=> 'salta',
	'RestoreReplace'			=> 'sostituisci',
	'RestoreFile'				=> 'File:',
	'RestoredFiles'				=> 'ripristinato:',
	'SkippedFiles'				=> 'saltato:',
	'FileRestoreDone'			=> 'Completato. File totali:',
	'FilesAll'					=> 'tutti:',
	'SkipFiles'					=> 'I file non sono memorizzati - salta',
	'RestoreDone'				=> 'RESTORAZIONE COMPLETATA',

	'BackupCreationDate'		=> 'Data Di Creazione',
	'BackupPackageContents'		=> 'Il contenuto del pacchetto',
	'BackupRestore'				=> 'Ripristina',
	'BackupRemove'				=> 'Rimuovere',
	'RestoreYes'				=> 'Sì',
	'RestoreNo'					=> 'No',
	'LogDbRestored'				=> 'Backup ##%1## del database ripristinato.',

	'BackupArchived'			=> 'Backup %1 archiviato.',
	'BackupArchiveExists'		=> 'L’archivio di backup %1 esiste già.',
	'LogBackupArchived'			=> 'Backup ##%1## archiviato.',

	// User module
	'UsersInfo'					=> 'Here you can change your users information and certain specific options.',

	'UsersAdded'				=> 'Utente aggiunto',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> 'Modificare',
	'UsersAddNew'				=> 'Aggiungi nuovo utente',
	'UsersDelete'				=> 'Sei sicuro di voler rimuovere l’utente %1?',
	'UsersDeleted'				=> 'L\'utente %1 è stato eliminato dal database.',
	'UsersRename'				=> 'Rinomina l\'utente %1 in',
	'UsersRenameInfo'			=> '* Nota: il cambiamento influenzerà tutte le pagine assegnate a quell\'utente.',
	'UsersUpdated'				=> 'Utente aggiornato correttamente.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Tempo Di Registrazione',
	'UserActions'				=> 'Azioni',
	'NoMatchingUser'			=> 'Nessun utente che soddisfi i criteri',

	'UserAccountNotify'			=> 'Notifica utente',
	'UserNotifySignup'			=> 'informare l’utente del nuovo account',
	'UserVerifyEmail'			=> 'imposta il token di conferma e-mail e aggiungi link per la verifica e-mail',
	'UserReVerifyEmail'			=> 'Invia di nuovo il token di conferma dell’e-mail',

	// Groups module
	'GroupsInfo'				=> 'Da questo pannello puoi amministrare tutti i tuoi gruppi utente. Puoi eliminare, creare e modificare gruppi esistenti. Inoltre, è possibile scegliere i capi di gruppo, attivare/nascondere/chiudere lo stato del gruppo e impostare il nome del gruppo e la descrizione.',

	'LogMembersUpdated'			=> 'Membri del gruppo utente aggiornati',
	'LogMemberAdded'			=> 'Aggiunto membro ##%1## al gruppo ##%2##',
	'LogMemberRemoved'			=> 'Membro rimosso ##%1## dal gruppo ##%2##',
	'LogGroupCreated'			=> 'Creato un nuovo gruppo ##%1##',
	'LogGroupRenamed'			=> 'Gruppo ##%1## rinominato in ##%2##',
	'LogGroupRemoved'			=> 'Rimosso il gruppo ##%1##',

	'GroupsMembersFor'			=> 'Membri del gruppo',
	'GroupsDescription'			=> 'Descrizione',
	'GroupsModerator'			=> 'Moderatore',
	'GroupsOpen'				=> 'Apri',
	'GroupsActive'				=> 'Attivo',
	'GroupsTip'					=> 'Clicca per modificare il Gruppo',
	'GroupsUpdated'				=> 'Gruppi aggiornati',
	'GroupsAlreadyExists'		=> 'Questo gruppo esiste già.',
	'GroupsAdded'				=> 'Gruppo aggiunto con successo.',
	'GroupsRenamed'				=> 'Gruppo rinominato con successo.',
	'GroupsDeleted'				=> 'The group %1 was deleted from the database and all pages.',
	'GroupsAdd'					=> 'Aggiungere un nuovo gruppo',
	'GroupsRename'				=> 'Rinomina il gruppo %1 in',
	'GroupsRenameInfo'			=> '* Nota: il cambiamento influenzerà tutte le pagine assegnate a quel gruppo.',
	'GroupsDelete'				=> 'Sei sicuro di voler rimuovere il gruppo %1?',
	'GroupsDeleteInfo'			=> '* Nota: Le modifiche riguardano tutti i membri assegnati a quel gruppo.',
	'GroupsIsSystem'			=> 'Il gruppo %1 appartiene al sistema e non può essere rimosso.',
	'GroupsStoreButton'			=> 'Salva Gruppi',
	'GroupsEditInfo'			=> 'Per modificare l\'elenco dei gruppi selezionare il pulsante di selezione.',

	'GroupAddMember'			=> 'Aggiungi membro',
	'GroupRemoveMember'			=> 'Rimuovi Membro',
	'GroupAddNew'				=> 'Aggiungi gruppo',
	'GroupEdit'					=> 'Modifica gruppo',
	'GroupDelete'				=> 'Rimuovi gruppo',

	'MembersAddNew'				=> 'Aggiungere un nuovo membro',
	'MembersAdded'				=> 'Aggiunto con successo un nuovo membro del gruppo.',
	'MembersRemove'				=> 'Sei sicuro di voler rimuovere un membro %1?',
	'MembersRemoved'			=> 'Il membro è stato allontanato dal gruppo.',

	// Statistics module
	'DbStatSection'				=> 'Statistiche Database',
	'DbTable'					=> 'Tabella',
	'DbRecords'					=> 'Record',
	'DbSize'					=> 'Dimensione del file',
	'DbIndex'					=> 'Indice',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'Totale',

	'FileStatSection'			=> 'Statistiche Del File System',
	'FileFolder'				=> 'Cartella',
	'FileFiles'					=> 'File',
	'FileSize'					=> 'Dimensione del file',
	'FileTotal'					=> 'Totale',

	// Sysinfo module
	'SysInfo'					=> 'Version informations:',
	'SysParameter'				=> 'Parametro',
	'SysValues'					=> 'Valori',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Ultimo aggiornamento',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Nome del server',
	'WebServer'					=> 'Server web',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'Modalità SQL Globale',
	'SqlModesSession'			=> 'Sessione Modalità SQL',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memoria',
	'UploadFilesizeMax'			=> 'Carica dimensione massima file',
	'PostMaxSize'				=> 'Dimensione massima post',
	'MaxExecutionTime'			=> 'Tempo massimo di esecuzione',
	'SessionPath'				=> 'Percorso sessione',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'Compressione GZip',
	'PhpExtensions'				=> 'Estensioni PHP',
	'ApacheModules'				=> 'Moduli Apache',

	// DB repair module
	'DbRepairSection'			=> 'Ripara Database',
	'DbRepair'					=> 'Ripara Database',
	'DbRepairInfo'				=> 'Questo script può automaticamente cercare alcuni problemi di database comuni e ripararli. Riparazione può richiedere un po\' di tempo, quindi sii paziente.',

	'DbOptimizeRepairSection'	=> 'Ripara e Ottimizza Database',
	'DbOptimizeRepair'			=> 'Ripara e Ottimizza Database',
	'DbOptimizeRepairInfo'		=> 'Questo script può anche tentare di ottimizzare il database. Questo migliora le prestazioni in alcune situazioni. La riparazione e l\'ottimizzazione del database possono richiedere molto tempo e il database sarà bloccato durante l\'ottimizzazione.',

	'TableOk'					=> 'La tabella %1 va bene.',
	'TableNotOk'				=> 'La tabella %1 non va bene. Sta segnalando il seguente errore: %2. Questo script tenterà di riparare questa tabella&hellip;',
	'TableRepaired'				=> 'Riparato con successo la tabella %1.',
	'TableRepairFailed'			=> 'Riparazione della tabella %1 non riuscita. <br>Errore: %2',
	'TableAlreadyOptimized'		=> 'La tabella %1 è già ottimizzata.',
	'TableOptimized'			=> 'Ottimizzato con successo la tabella %1.',
	'TableOptimizeFailed'		=> 'Impossibile ottimizzare la tabella %1 . <br>Errore: %2',
	'TableNotRepaired'			=> 'Alcuni problemi di database non possono essere riparati.',
	'RepairsComplete'			=> 'Riparazioni completate',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Mostra e correggi incongruenze, elimina o assegna i record orfani a un nuovo utente/valore.',
	'Inconsistencies'			=> 'Incongruenze',
	'CheckDatabase'				=> 'Database',
	'CheckDatabaseInfo'			=> 'Controlla le incongruenze di record nel database.',
	'CheckFiles'				=> 'File',
	'CheckFilesInfo'			=> 'Controlla i file abbandonati, i file senza riferimento rimasti nella tabella dei file.',
	'Records'					=> 'Record',
	'InconsistenciesNone'		=> 'Nessuna incongruenza di dati trovata.',
	'InconsistenciesDone'		=> 'Incongruenze di dati risolte.',
	'InconsistenciesRemoved'	=> 'Incoerenze rimosse',
	'Check'						=> 'Controlla',
	'Solve'						=> 'Risolvi',

	// Bad Behaviour module
	'BbInfo'					=> 'Detects and blocks unwanted Web accesses, deny automated spambots access<br>For more information please visit the %1 homepage.',
	'BbEnable'					=> 'Abilita Comportamento Cattivo:',
	'BbEnableInfo'				=> 'Tutte le altre impostazioni possono essere modificate nella cartella di configurazione %1.',
	'BbStats'					=> 'Comportamento errato ha bloccato i tentativi di accesso %1 negli ultimi 7 giorni.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Registro',
	'BbSettings'				=> 'Preferenze',
	'BbWhitelist'				=> 'Whitelist',

	// --> Log
	'BbHits'					=> 'Colpi',
	'BbRecordsFiltered'			=> 'Visualizzazione di %1 di %2 record filtrati da',
	'BbStatus'					=> 'Stato',
	'BbBlocked'					=> 'Bloccato',
	'BbPermitted'				=> 'Consentito',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Visualizzazione di tutti i record %1',
	'BbShow'					=> 'Mostra',
	'BbIpDateStatus'			=> 'IP/Data/Stato',
	'BbHeaders'					=> 'Intestazioni',
	'BbEntity'					=> 'Entità',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Opzioni salvate.',
	'BbWhitelistHint'			=> 'WILL whitelisting inappropriato ti espone allo spam, o causa il comportamento cattivo per interrompere completamente il funzionamento! NON WHITELIST a meno che non siate 100% DETERMINATI che dovreste fare.',
	'BbIpAddress'				=> 'Indirizzo IP',
	'BbIpAddressInfo'			=> 'Intervalli di indirizzi IP o formato CIDR da inserire nella whitelist (uno per riga)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'Frammenti di URL che iniziano con / dopo il tuo hostname del sito web (uno per riga)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'Stringhe dell\'agente utente da inserire nella whitelist (una per riga)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Impostazioni di comportamento errate aggiornate',
	'BbLogRequest'				=> 'Richiesta di registrazione HTTP',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normale (raccomandato)',
	'BbLogOff'					=> 'Non registrare (non consigliato)',
	'BbSecurity'				=> 'Sicurezza',
	'BbStrict'					=> 'Controllo rigoroso',
	'BbStrictInfo'				=> 'blocca più spam ma può bloccare alcune persone',
	'BbOffsiteForms'			=> 'Consenti post di moduli da altri siti web',
	'BbOffsiteFormsInfo'		=> 'richiesto per OpenID; aumenta lo spam ricevuto',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'To use Bad Behaviour’s http:BL features you must have an %1',
	'BbHttpblKey'				=> 'http:BL Access Key',
	'BbHttpblThreat'			=> 'Livello minimo di minaccia (25 è raccomandato)',
	'BbHttpblMaxage'			=> 'Età massima dei dati (30 è raccomandata)',
	'BbReverseProxy'			=> 'Bilanciatore Del Proxy/Carico Inverso',
	'BbReverseProxyInfo'		=> 'Se si utilizza un cattivo comportamento dietro un proxy inverso, bilanciere il carico, acceleratore HTTP, cache dei contenuti o tecnologia simile, abilitare l\'opzione Proxy inverso.<br>' .
									'If you have a chain of two or more reverse proxies between your server and the public Internet, you must specify <em>all</em> of the IP address ranges (in CIDR format) of all of your proxy servers, load balancers, etc. Otherwise, Bad Behaviour may be unable to determine the client’s true IP address.<br>' .
									'In addition, your reverse proxy servers must set the IP address of the Internet client from which they received the request in an HTTP header. If you don’t specify a header, %1 will be used. Most proxy servers already support X-Forwarded-For and you would then only need to ensure that it is enabled on your proxy servers. Some other header names in common use include %2 and %3.',
	'BbReverseProxyEnable'		=> 'Abilita Proxy Inverso',
	'BbReverseProxyHeader'		=> 'Intestazione contenente l\'indirizzo IP dei client Internet',
	'BbReverseProxyAddresses'	=> 'Intervalli di indirizzi IP o formato CIDR per i server proxy (uno per riga)',

];
