<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Fonctions de base',
		'preferences'	=> 'Préférences',
		'content'		=> 'Contenu',
		'users'			=> 'Utilisateurs',
		'maintenance'	=> 'Maintenance',
		'messages'		=> 'Messages',
		'extension'		=> 'Extension',
		'database'		=> 'Base de données',
	],

	// Admin panel
	'AdminPanel'				=> 'Panneau de contrôle d’administration',
	'RecoveryMode'				=> 'Mode de récupération',
	'Authorization'				=> 'Autorisation',
	'AuthorizationTip'			=> 'Merci d’indiquer le mot de passe d’administration (assurez-vous également que les cookies soient autorisés par votre navigateur).',
	'NoRecoveryPassword'		=> 'Le mot de passe d’administration n’est pas spécifié !',
	'NoRecoveryPasswordTip'		=> 'Note : L’ absence de mot de passe d’administration constitue une menace pour la sécurité ! Saisissez votre mot de passe dans le fichier de configuration et exécutez le programme de nouveau.',

	'ErrorLoadingModule'		=> 'Erreur de chargement du module admin %1 : n’existe pas.',

	'ApHomePage'				=> 'Page d’accueil',
	'ApHomePageTip'				=> 'ouvrir la page d’accueil, vous ne quittez pas l’administration',
	'ApLogOut'					=> 'Déconnexion',
	'ApLogOutTip'				=> 'quitter l’administration du système',

	'TimeLeft'					=> 'Temps restant : %1 minutes',
	'ApVersion'					=> 'version',

	'SiteOpen'					=> 'Ouvrir',
	'SiteOpened'				=> 'site ouvert',
	'SiteOpenedTip'				=> 'Le site est ouvert',
	'SiteClose'					=> 'Fermer',
	'SiteClosed'				=> 'site fermé',
	'SiteClosedTip'				=> 'Le site est fermé',

	'System'					=> 'System',

	// Generic
	'Cancel'					=> 'Annuler',
	'Add'						=> 'Ajouter',
	'Edit'						=> 'Modifier',
	'Remove'					=> 'Enlever',
	'Enabled'					=> 'Activé',
	'Disabled'					=> 'Désactivé',
	'Mandatory'					=> 'Obligatoire',
	'Admin'						=> 'Admin',
	'Min'						=> 'Min',
	'Max'						=> 'Max',

	'MiscellaneousSection'		=> 'Divers',
	'MainSection'				=> 'Paramètres de base',

	'DirNotWritable'			=> 'Le répertoire %1 n’est pas accessible en écriture.',
	'FileNotWritable'			=> 'The %1 file is not writable.',

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
		'name'		=> 'Basic',
		'title'		=> 'Paramètres de base',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Apparence',
		'title'		=> 'Paramètres d’apparence',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Email',
		'title'		=> 'Paramètres d’e-mail',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Syndication',
		'title'		=> 'Paramètres de syndication',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtre',
		'title'		=> 'Paramètres du filtre',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'Options de formatage',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Notifications',
		'title'		=> 'Paramètres des notifications',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Pages',
		'title'		=> 'Pages et paramètres du site',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Droits',
		'title'		=> 'Paramètres des permissions',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Sécurité',
		'title'		=> 'Paramètres des sous-systèmes de sécurité',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Système',
		'title'		=> 'Options du système',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Télécharger',
		'title'		=> 'Paramètres des pièces jointes',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Supprimé',
		'title'		=> 'Contenu récemment supprimé',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Ajouter, modifier ou supprimer des éléments de menu par défaut',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Sauvegarde',
		'title'		=> 'Sauvegarde des données',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Réparation',
		'title'		=> 'Réparer et optimiser la base de données',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Restaurer',
		'title'		=> 'Restauration des données de sauvegarde',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Menu principal',
		'title'		=> 'WackoWiki Administration',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Incohérences',
		'title'		=> 'Correction des incohérences dans les données',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Synchronisation des données',
		'title'		=> 'Synchronisation des données',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Courriel de masse',
		'title'		=> 'Courriel de masse',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Message système',
		'title'		=> 'Message du système',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Info système',
		'title'		=> 'Informations sur le système',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Journal système',
		'title'		=> 'Journal des événements du système',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistiques',
		'title'		=> 'Afficher les statistiques',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Bad Behaviour',
		'title'		=> 'Bad Behaviour',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Approuver',
		'title'		=> 'Approbation de l’enregistrement de l’utilisateur',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Groupes',
		'title'		=> 'Gestion du groupe',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Utilisateurs',
		'title'		=> 'Gestion des utilisateurs',
	],

	// Main module
	'MainNote'					=> 'Attention : Il est fortement recommandé de ne pas accéder au site avant d’organiser des événements techniques et/ou administratifs !',

	'PurgeSessions'				=> 'Purger',
	'PurgeSessionsTip'			=> 'Purger toutes les sessions',
	'PurgeSessionsConfirm'		=> 'Êtes-vous sûr de vouloir purger toutes les sessions ? Tous les utilisateurs seront déconnectés.',
	'PurgeSessionsExplain'		=> 'Purgez toutes les sessions. Tous les utilisateurs seront déconnectés en tronquant la table auth_token.',
	'PurgeSessionsDone'			=> 'Sessions purgées avec succès.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Mise à jour des réglages de base',
	'LogBasicSettingsUpdated'	=> 'Mise à jour des réglages de base',

	'SiteName'					=> 'Nom du site :',
	'SiteNameInfo'				=> 'Le titre de ce site, apparaît sur le titre du navigateur, l’en-tête du thème, l’avis par courriel, etc.',
	'SiteDesc'					=> 'Description du site :',
	'SiteDescInfo'				=> 'Complément au titre du site qui apparaît dans l’en-tête des pages pour expliquer en quelques mots, en quoi consiste ce site.',
	'AdminName'					=> 'Admin du site :',
	'AdminNameInfo'				=> 'Nom d’utilisateur, qui est responsable du support global du site. Ce nom n’est pas utilisé pour déterminer les droits d’accès, mais il est souhaitable de se conformer au nom de l’administrateur en chef du site.',

	'LanguageSection'			=> 'Langue',
	'DefaultLanguage'			=> 'Langue par défaut :',
	'DefaultLanguageInfo'		=> 'Spécifie la langue des messages affichés aux invités non enregistrés, ainsi que les paramètres locaux.',
	'MultiLanguage'				=> 'Soutien multilangues :',
	'MultiLanguageInfo'			=> 'Permet de sélectionner une langue page par page.',
	'AllowedLanguages'			=> 'Langues autorisées :',
	'AllowedLanguagesInfo'		=> 'Il est recommandé de ne sélectionner que l’ensemble des langues que vous souhaitez utiliser, sinon toutes les langues sont sélectionnées.',

	'CommentSection'			=> 'Commentaires',
	'AllowComments'				=> 'Permettre les commentaires :',
	'AllowCommentsInfo'			=> 'Activer les commentaires pour les utilisateurs invités ou enregistrés uniquement ou les désactiver sur l’ensemble du site.',
	'SortingComments'			=> 'Tri des commentaires :',
	'SortingCommentsInfo'		=> 'Modifie l’ordre dans lequel les commentaires de la page sont présentés, soit avec le commentaire le plus récent OU le plus ancien en haut.',

	'ToolbarSection'			=> 'Barre d’outils',
	'CommentsPanel'				=> 'Panneau des commentaires :',
	'CommentsPanelInfo'			=> 'L’affichage par défaut des commentaires en bas de la page.',
	'FilePanel'					=> 'Panneau de fichiers :',
	'FilePanelInfo'				=> 'L’affichage par défaut des fichiers joints en bas de la page.',
	'TagsPanel'					=> 'Panneau de balises :',
	'TagsPanelInfo'				=> 'L’affichage par défaut du panneau de balises en bas de la page.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Afficher le lien permanent :',
	'ShowPermalinkInfo'			=> 'L’affichage par défaut du permalien pour la version actuelle de la page.',
	'TocPanel'					=> 'Table des matières panneau :',
	'TocPanelInfo'				=> 'La table des matières par défaut d’une page (peut nécessiter un support dans les modèles).',
	'SectionsPanel'				=> 'Panneau des sections :',
	'SectionsPanelInfo'			=> 'Par défaut, affiche le panneau des pages adjacentes (nécessite une prise en charge dans les modèles).',
	'DisplayingSections'		=> 'Affichage des sections :',
	'DisplayingSectionsInfo'	=> 'When the previous options, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>) or both, and other (<em>tree</em>).',
	'MenuItems'					=> 'Éléments du menu :',
	'MenuItemsInfo'				=> 'Nombre par défaut d’éléments de menu affichés (peut avoir besoin d’aide dans les modèles).',

	'HandlerSection'			=> 'Handler',
	'HideRevisions'				=> 'Masquer révisions :',
	'HideRevisionsInfo'			=> 'L’affichage par défaut des révisions de la page.',
	'AttachmentHandler'			=> 'Activer le gestionnaire de pièces jointes :',
	'AttachmentHandlerInfo'		=> 'Permet d’afficher le gestionnaire de pièces jointes.',
	'SourceHandler'				=> 'Enable source handler :',
	'SourceHandlerInfo'			=> 'Allows to show the source handler.',
	'ExportHandler'				=> 'Enable XML export handler :',
	'ExportHandlerInfo'			=> 'Allows to show the XML export handler.',

	'DiffModeSection'			=> 'Diff Modes',
	'DefaultDiffModeSetting'	=> 'Mode diff par défaut :',
	'DefaultDiffModeSettingInfo'=> 'Mode diff présélectionné.',
	'AllowedDiffMode'			=> 'Modes Diff autorisés :',
	'AllowedDiffModeInfo'		=> 'Il est recommandé de ne sélectionner que l’ensemble des modes de diff que vous souhaitez utiliser, sinon tous les modes de diff sont sélectionnés.',
	'NotifyDiffMode'			=> 'Notify diff mode :',
	'NotifyDiffModeInfo'		=> 'Mode Diff utilisé pour les notifications dans le corps de l’email.',

	'EditingSection'			=> 'Rédaction',
	'EditSummary'				=> 'Éditer le sommaire :',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Édition mineure :',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'SectionEdit'				=> 'Edition de section :',
	'SectionEditInfo'			=> 'Permet de modifier uniquement une section d’une page.',
	'ReviewSettings'			=> 'Review :',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',
	'PublishAnonymously'		=> 'Autoriser la publication anonyme :',
	'PublishAnonymouslyInfo'	=> 'Autoriser les utilisateurs à publier de préférence de manière anonyme (pour cacher le nom).',

	'DefaultRenameRedirect'		=> 'Lors du renommage, mettre la redirection :',
	'DefaultRenameRedirectInfo'	=> 'Par défaut, offrez de définir une redirection vers l’ancienne adresse de la page à renommer.',
	'StoreDeletedPages'			=> 'Conserver les pages supprimées :',
	'StoreDeletedPagesInfo'		=> 'Lorsque vous supprimez une page, un commentaire ou un fichier, conservez-le dans une section spéciale, où il sera disponible pour examen et récupération pendant un certain temps encore (comme décrit ci-dessous).',
	'KeepDeletedTime'			=> 'Temps de stockage des pages supprimées :',
	'KeepDeletedTimeInfo'		=> 'La période en jours. Cela n’a de sens qu’avec l’option précédente. Le zéro indique la possession éternelle (dans ce cas, l’administrateur peut vider le "panier" manuellement).',
	'PagesPurgeTime'			=> 'Temps de stockage des révisions de page :',
	'PagesPurgeTimeInfo'		=> 'Supprime automatiquement les anciennes versions dans le nombre de jours donné. Si vous entrez zéro, les anciennes versions ne seront pas supprimées.',
	'EnableReferrers'			=> 'Activer les référents :',
	'EnableReferrersInfo'		=> 'Permet de stocker et d’afficher les références externes.',
	'ReferrersPurgeTime'		=> 'Temps de stockage des référents :',
	'ReferrersPurgeTimeInfo'	=> 'L’historique des renvois de pages externes ne doit pas dépasser un nombre de jours donné. Zéro signifie stockage éternel, mais pour un site activement visité, cela peut entraîner un débordement de la base de données.',
	'EnableCounters'			=> 'Hit Counters :',
	'EnableCountersInfo'		=> 'Permet de compter les hits par page et d’afficher des statistiques simples. Les appels du propriétaire de la page ne sont pas comptabilisés.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Contrôle les paramètres de syndication web par défaut pour votre site.',
	'SyndicationSettingsUpdated'	=> 'Paramètres de syndication mis à jour.',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Activer les flux :',
	'EnableFeedsInfo'			=> 'Active ou désactive les flux RSS pour l’ensemble du wiki.',
	'XmlChangeLink'				=> 'Changes feed link mode:',
	'XmlChangeLinkInfo'			=> 'Defines where the XML Changes feed items links to.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'liste des différences',
		'2'		=> 'page actuelle',
		'3'		=> 'liste des révisions',
		'4'		=> 'page révisée',
	],

	'XmlSitemap'				=> 'XML Sitemap :',
	'XmlSitemapInfo'			=> 'Créez un fichier XML appelé %1 dans le dossier xml. Générer un fichier XML compatible avec le format Sitemaps XML. Vous pouvez modifier le chemin d’accès pour le placer dans votre dossier racine, car c’est l’une des conditions requises, à savoir que le fichier XML se trouve dans le dossier racine. D’autre part, vous pouvez également ajouter le chemin d’accès au plan du site dans le fichier robots.txt de votre répertoire racine comme suit :',
	'XmlSitemapGz'				=> 'XML Sitemap compression :',
	'XmlSitemapGzInfo'			=> 'Si vous le souhaitez, vous pouvez compresser votre fichier texte Sitemap à l’aide de gzip afin de réduire votre besoin en bande passante.',
	'XmlSitemapTime'			=> 'XML Sitemap generation time :',
	'XmlSitemapTimeInfo'		=> 'Génère le Sitemap une seule fois dans le nombre de jours donné, zéro signifie à chaque changement de page.',

	'SearchSection'				=> 'Recherche',
	'OpenSearch'				=> 'OpenSearch :',
	'OpenSearchInfo'			=> 'Crée le fichier de description OpenSearch dans le dossier XML et active la découverte automatique du plugin de recherche dans l’en-tête HTML.',
	'SearchEngineVisibility'	=> 'Bloquer les moteurs de recherche (Visibilité sur les moteurs de recherche) :',
	'SearchEngineVisibilityInfo'=> 'Bloquer les moteurs de recherche, mais permettre aux visiteurs normaux. Remplace les paramètres de page. <br>Décourager les moteurs de recherche d’indexer ce site, c’est aux moteurs de recherche d’honorer cette demande.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Contrôlez les paramètres d’affichage par défaut de votre site.',
	'AppearanceSettingsUpdated'	=> 'Mise à jour des paramètres d’apparence.',

	'LogoOff'					=> 'Désactivé',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo et titre',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Logo du site :',
	'SiteLogoInfo'				=> 'Votre logo apparaîtra typiquement dans le coin supérieur gauche de l’application. La taille maximale est de 2 MiB. Les dimensions optimales sont de 255 pixels de large sur 55 pixels de haut.',
	'LogoDimensions'			=> 'Dimensions du logo :',
	'LogoDimensionsInfo'		=> 'Largeur et hauteur du logo affiché.',
	'LogoDisplayMode'			=> 'Mode d’affichage du logo :',
	'LogoDisplayModeInfo'		=> 'Définit l’appearance du logo. La valeur par défaut est désactivée.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Favicon du site :',
	'SiteFaviconInfo'			=> 'Votre icône de raccourci, ou favicon, est affichée dans la barre d’adresse, les onglets et les signets de la plupart des navigateurs. Ceci remplacera le favicon de votre thème.',
	'SiteFaviconTooBig'			=> 'Favicon est plus grand que 64 × 64px.',
	'ThemeColor'				=> 'Couleur du thème pour la barre d’adresse :',
	'ThemeColorInfo'			=> 'Le navigateur définira la couleur de la barre d’adresse de chaque page en fonction de la couleur CSS fournie.',

	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Thème :',
	'ThemeInfo'					=> 'La conception des modèles que le site utilise par défaut.',
	'ThemesAllowed'				=> 'Thèmes autorisés :',
	'ThemesAllowedInfo'			=> 'Sélectionnez les thèmes autorisés, que l’utilisateur peut choisir, sinon tous les thèmes disponibles sont autorisés.',
	'ThemesPerPage'				=> 'Thèmes par page :',
	'ThemesPerPageInfo'			=> 'Autoriser les thèmes par page, que le propriétaire de la page peut choisir via les propriétés de la page.',

	// System settings
	'SystemSettingsInfo'		=> 'Groupe de paramètres responsable de la plate-forme de réglage fin. Ne les changez pas à moins d’avoir confiance en leurs actions.',
	'SystemSettingsUpdated'		=> 'Mise à jour des paramètres du système',

	'DebugModeSection'			=> 'Mode débogage',
	'DebugMode'					=> 'Mode débogage :',
	'DebugModeInfo'				=> 'Fixation and the withdrawal of telemetry data on the time of the program. Note: the full detail of the regime imposes high demands on available memory, especially in demanding operations such as backup and restore the database.',
	'DebugModes'	=> [
		'0'		=> 'le débogage est désactivé',
		'1'		=> 'uniquement le temps d’exécution total',
		'2'		=> 'à plein temps',
		'3'		=> 'tous les détails (SGBD, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Performance seuil SGBDR :',
	'DebugSqlThresholdInfo'		=> 'Dans le mode de débogage détaillé, l’enregistrement des requêtes prend plus de temps que le nombre de secondes.',
	'DebugAdminOnly'			=> 'Diagnostic fermé :',
	'DebugAdminOnlyInfo'		=> 'Afficher les données de débogage du programme (et du SGBD) uniquement pour l’administrateur.',

	'CachingSection'			=> 'Options de mise en cache',
	'Cache'						=> 'Mise en cache des pages rendues :',
	'CacheInfo'					=> 'Enregistrez les pages rendues dans le cache local pour accélérer le démarrage suivant. Valable uniquement pour les visiteurs non enregistrés.',
	'CacheTtl'					=> 'Terme pertinence pages mises en cache :',
	'CacheTtlInfo'				=> 'La mise en cache des pages ne dépasse pas un nombre de secondes spécifié.',
	'CacheSql'					=> 'Requêtes du SGBD cache :',
	'CacheSqlInfo'				=> 'Maintenir un cache local les résultats de certaines requêtes SQL de ressources.',
	'CacheSqlTtl'				=> 'Pertinence du terme Cache Base de données :',
	'CacheSqlTtlInfo'			=> 'Cache les résultats des requêtes SQL pendant un nombre de secondes maximum spécifié. L’utilisation de valeurs supérieures à 1200 n’est pas souhaitable.',

	'LogSection'				=> 'Log settings',
	'LogLevelUsage'				=> 'Using logging :',
	'LogLevelUsageInfo'			=> 'The minimum priority of the events recorded in the log.',
	'LogThresholds'	=> [
		'0'		=> 'not keep a journal',
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high',
		'4'		=> 'on average',
		'5'		=> 'from low',
		'6'		=> 'the minimum level',
		'7'		=> 'record all',
	],
	'LogDefaultShow'			=> 'Display Log Mode :',
	'LogDefaultShowInfo'		=> 'The minimum priority events displayed in the log by default.',
	'LogModes'	=> [
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high-level',
		'4'		=> 'the average',
		'5'		=> 'from a low',
		'6'		=> 'from the minimum level',
		'7'		=> 'show all',
	],
	'LogPurgeTime'				=> 'Storage time of Log :',
	'LogPurgeTimeInfo'			=> 'Remove event log over a given number of days.',

	'PrivacySection'			=> 'Vie privée',
	'AnonymizeIp'				=> 'Anonymiser les adresses IP des utilisateurs :',
	'AnonymizeIpInfo'			=> 'Anonymiser les adresses IP, le cas échéant, comme les pages, les révisions ou les références.',

	'ReverseProxySection'		=> 'Reverse Proxy',
	'ReverseProxy'				=> 'Use Reverse proxy :',
	'ReverseProxyInfo'			=> 'Activez ce paramètre pour déterminer l’adresse IP correcte du client distant en examinant
									les informations stockées dans les en-têtes X-Forwarded-For. Les en-têtes X-Forwarded-For sont
									un mécanisme standard d’identification des systèmes clients se connectant via un serveur proxy inverse,
									tel que Squid ou Pound. Les serveurs proxy inversés sont souvent utilisés pour améliorer
									les performances des sites très visités et peuvent également fournir d’autres avantages en matière
									de mise en cache, de sécurité ou de cryptage. Si cette installation de WackoWiki fonctionne derrière
									un proxy inverse, ce paramètre doit être activé afin que les informations correctes sur l’adresse IP
									soient capturées dans les systèmes de gestion de session, de journalisation, de statistiques et
									de gestion des accès de WackoWiki ; si vous n’êtes pas sûr de ce paramètre, si vous n’avez pas
									de proxy inverse ou si WackoWiki fonctionne dans un environnement d’hébergement partagé,
									ce paramètre doit rester désactivé.',
	'ReverseProxyHeader'		=> 'Reverse proxy header :',
	'ReverseProxyHeaderInfo'	=> 'Définissez cette valeur si votre serveur proxy envoie l’IP du client dans
									un en-tête autre que X-Forwarded-For. L’en-tête "X-Forwarded-For" est une
									liste d’adresses IP séparées par des virgules et des espaces, seule la dernière (la plus à gauche) sera utilisée.',
	'ReverseProxyAddresses'		=> 'reverse_proxy accepts an array of IP addresses :',
	'ReverseProxyAddressesInfo'	=> 'Each element of this array is the IP address of any of your reverse
									 proxies. Filling this array WackoWiki will trust the information stored
									 in the X-Forwarded-For headers only if Remote IP address is one of
									 these, that is the request reaches the web server from one of your
									 reverse proxies. Otherwise, the client could directly connect to
									 your web server spoofing the X-Forwarded-For headers.',

	'SessionSection'				=> 'Traitement des sessions',
	'SessionStorage'				=> 'Stockage des sessions :',
	'SessionStorageInfo'			=> 'Cette option définit l’endroit où les données de session sont stockées. Par défaut, le stockage de session de fichier ou de base de données est sélectionné.',
	'SessionModes'	=> [
		'1'		=> 'Fichier',
		'2'		=> 'Base de données',
	],
	'SessionNotice'					=> 'Montrer la cause de la fin de la session :',
	'SessionNoticeInfo'				=> 'Indique la cause de la fin de la session.',
	'LoginNotice'					=> 'Avis de connexion :',
	'LoginNoticeInfo'				=> 'Affiche une indication de connexion.',

	'RewriteMode'					=> 'Utiliser <code>mod_rewrite</code> :',
	'RewriteModeInfo'				=> 'If your web server supports this feature, turn to get "beautiful" the addresses of pages.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Paramètres responsables du contrôle d’accès et des permissions.',
	'PermissionsSettingsUpdated'	=> 'Mise à jour des paramètres de permissions',

	'PermissionsSection'		=> 'Droits et privilèges',
	'ReadRights'				=> 'Droits de lecture par défaut :',
	'ReadRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'WriteRights'				=> 'Droits d’écriture par défaut :',
	'WriteRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'CommentRights'				=> 'Droits de commentaire par défaut :',
	'CommentRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'CreateRights'				=> 'Create rights of a sub page by default :',
	'CreateRightsInfo'			=> 'Define the right for creating root pages and assign them to pages for which parental rights cannot be defined.',
	'UploadRights'				=> 'Droits de téléchargement par défaut :',
	'UploadRightsInfo'			=> 'They are assigned to the created root pages, as well as pages for which parental rights cannot be defined.',
	'RenameRights'				=> 'Droit global de renommer :',
	'RenameRightsInfo'			=> 'The list of permissions to freely rename (move) pages.',

	'LockAcl'					=> 'Lock all ACL to read only :',
	'LockAclInfo'				=> '<span class="cite">Overwrites the acl settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period for security reasons or as a emergency response.',
	'HideLocked'				=> 'Masquer les pages inaccessibles :',
	'HideLockedInfo'			=> 'Si l’utilisateur n’a pas l’autorisation de lire la page, cachez-la dans des listes de pages différentes (cependant le lien placé dans le texte, sera toujours visible).',
	'RemoveOnlyAdmins'			=> 'Seuls les administrateurs peuvent supprimer des pages :',
	'RemoveOnlyAdminsInfo'		=> 'Deny all, except administrators, to delete pages. In the first limit applies to owners of normal pages.',
	'OwnersRemoveComments'		=> 'Les propriétaires de pages peuvent supprimer les commentaires :',
	'OwnersRemoveCommentsInfo'	=> 'Permettre aux propriétaires de pages de modérer les commentaires sur leurs pages.',
	'OwnersEditCategories'		=> 'Les propriétaires peuvent modifier les catégories de pages :',
	'OwnersEditCategoriesInfo'	=> 'Permet aux propriétaires de modifier la liste des catégories de pages de votre site (ajouter des mots, supprimer des mots), assigne à une page.',
	'TermHumanModeration'		=> 'Term human moderation :',
	'TermHumanModerationInfo'	=> 'Les modérateurs ne peuvent modifier les commentaires que s’ils ont été créés il y a un nombre de jours maximum (cette limitation ne s’applique pas au dernier commentaire du sujet).',

	'UserCanDeleteAccount'		=> 'Utilisateurs autorisés à supprimer leur compte',

	// Security settings
	'SecuritySettingsInfo'		=> 'Paramètres responsables de la sécurité globale de la plate-forme, des restrictions de sécurité et des sous-systèmes de sécurité supplémentaires.',
	'SecuritySettingsUpdated'	=> 'Mise à jour des paramètres de sécurité',

	'AllowRegistration'			=> 'Inscription en ligne :',
	'AllowRegistrationInfo'		=> 'Enregistrement ouvert des utilisateurs. La désactivation de cette option empêchera l’enregistrement gratuit, mais l’administrateur du site pourra enregistrer lui-même d’autres utilisateurs.',
	'ApproveNewUser'			=> 'Approuver de nouveaux utilisateurs :',
	'ApproveNewUserInfo'		=> 'Permet aux administrateurs d’approuver les utilisateurs une fois qu’ils se sont enregistrés. Seuls les utilisateurs approuvés seront autorisés à se connecter sur le site.',
	'PersistentCookies'			=> 'Cookies persistants :',
	'PersistentCookiesInfo'		=> 'Autoriser les cookies persistants.',
	'DisableWikiName'			=> 'Désactiver le NomWiki :',
	'DisableWikiNameInfo'		=> 'Désactivez l’utilisation obligatoire du NomWiki. Permet d’enregistrer les utilisateurs avec des surnoms traditionnels, et non forcés NameSurname.',
	'UsernameLength'			=> 'Longueur du nom d’utilisateur :',
	'UsernameLengthInfo'		=> 'Nombre minimum et maximum de caractères dans les noms d’utilisateur.',

	'EmailSection'				=> 'Email',
	'AllowEmailReuse'			=> 'Autoriser la réutilisation de l’adresse e-mail :',
	'AllowEmailReuseInfo'		=> 'Différents utilisateurs peuvent s’inscrire avec la même adresse e-mail.',
	'EmailConfirmation'			=> 'Confirmation de l’adresse électronique :',
	'EmailConfirmationInfo'		=> 'Exige que l’utilisateur vérifie son adresse électronique avant de pouvoir se connecter.',
	'AllowedEmailDomains'		=> 'Domaines de messagerie autorisés :',
	'AllowedEmailDomainsInfo'	=> 'Domaines de messagerie autorisés séparés par des virgules, par exemple <code>example.com, local.lan</code> etc., other wise all email domains are allowed.',
	'ForbiddenEmailDomains'		=> 'Domaines de messagerie interdits :',
	'ForbiddenEmailDomainsInfo'	=> 'Domaines de courrier électronique interdits, séparés par des virgules, par exemple <code>example.com, local.lan</code> etc. (n’est efficace que si la liste des domaines de courrier électronique autorisés est vide)',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Activer Captcha :',
	'EnableCaptchaInfo'			=> 'Si cette option est activée, Captcha sera affiché dans les cas suivants ou si un seuil de sécurité est atteint.',
	'CaptchaComment'			=> 'Nouveau commentaire :',
	'CaptchaCommentInfo'		=> 'Comme mesure de protection contre le spam, les publications exigent des utilisateurs non enregistrés une solution unique du test avant de poster le commentaire.',
	'CaptchaPage'				=> 'Nouvelle page :',
	'CaptchaPageInfo'			=> 'Comme mesure de protection contre le spam, les publications exigent des utilisateurs non enregistrés une solution unique du test avant de créer de nouvelles pages.',
	'CaptchaEdit'				=> 'Éditer la page :',
	'CaptchaEditInfo'			=> 'Comme mesure de protection contre le spam, les publications exigent des utilisateurs non enregistrés une solution unique du test avant d’éditer les pages.',
	'CaptchaRegistration'		=> 'Enregistrement :',
	'CaptchaRegistrationInfo'	=> 'Comme mesure de protection contre le spam, les publications exigent des utilisateurs non enregistrés une solution unique du test avant l’enregistrement.',

	'TlsSection'				=> 'TLS Réglages',
	'TlsConnection'				=> 'Raccordement TLS :',
	'TlsConnectionInfo'			=> 'Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS-certificate on the server, otherwise you will lose access to the admin panel!</span><br>It also determines if the the Cookie Secure Flag is set, the <code>secure</code> flag specifies whether cookies should only be sent over secure connections.',
	'TlsImplicit'				=> 'TLS obligatoire :',
	'TlsImplicitInfo'			=> 'Reconnecter de force le client de HTTP à HTTPS. L’option étant désactivée, le client peut naviguer sur le site via un canal HTTP ouvert.',

	'HttpSecurityHeaders'		=> 'HTTP Security Headers',
	'EnableSecurityHeaders'		=> 'Activer Security Headers :',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk !',
	'Csp'						=> 'Content-Security-Policy (CSP) :',
	'CspInfo'					=> 'Configuring Content Security Policy involves deciding what policies you want to enforce, and then configuring them and using Content-Security-Policy to establish your policy.',
	'PolicyModes'	=> [
		'0'		=> 'désactivé',
		'1'		=> 'rigoureux',
		'2'		=> 'personnalisée',
	],
	'PermissionsPolicy'			=> 'Permissions Policy :',
	'PermissionsPolicyInfo'		=> 'L’en-tête HTTP Permissions-Policy fournit un mécanisme permettant d’activer ou de désactiver explicitement diverses fonctionnalités puissantes du navigateur.',
	'ReferrerPolicy'			=> 'Referrer Policy :',
	'ReferrerPolicyInfo'		=> 'The Referrer-Policy HTTP header governs which referrer information, sent in the Referer header, should be included with requests made.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> 'Persistence of user passwords',
	'PwdMinChars'				=> 'Minimum password length :',
	'PwdMinCharsInfo'			=> 'Les mots de passe longs sont nécessairement plus sûrs que les mots de passe courts (par exemple 12 à 16 caractères).<br>L’utilisation de phrases de passe au lieu de mots de passe est encouragée.',
	'AdminPwdMinChars'			=> 'Minimum Admin password length :',
	'AdminPwdMinCharsInfo'		=> 'Les mots de passe longs sont nécessairement plus sûrs que les mots de passe courts (par exemple 12 à 16 caractères).<br>L’utilisation de phrases de passe au lieu de mots de passe est encouragée.',
	'PwdCharComplexity'			=> 'The required password complexity :',
	'PwdCharClasses'	=> [
		'0'		=> 'not tested',
		'1'		=> 'any letters + numbers',
		'2'		=> 'uppercase and lowercase + numbers',
		'3'		=> 'uppercase and lowercase + numbers + characters',
	],
	'PwdUnlikeLogin'			=> 'Additional complication :',
	'PwdUnlikes'	=> [
		'0'		=> 'not tested',
		'1'		=> 'password is not identical to the login',
		'2'		=> 'password does not contain username',
	],

	'LoginSection'				=> 'Connexion',
	'MaxLoginAttempts'			=> 'Maximum number of login attempts per username :',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximum number of login attempts per IP address :',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'FormsSection'				=> 'Forms',
	'FormTokenTime'				=> 'Maximum time to submit forms :',
	'FormTokenTimeInfo'			=> 'Le temps dont dispose un utilisateur pour soumettre un formulaire (en secondes).<br> Notez qu’un formulaire peut devenir invalide si la session expire, quel que soit ce paramètre.',

	'SessionLength'				=> 'Term login cookie :',
	'SessionLengthInfo'			=> 'The lifetime of the user cookie login by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments :',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of the new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications :',
	'IntercomDelayInfo'			=> 'The minimum delay between sending a private message user connection (in seconds).',
	'RegistrationDelay'			=> 'Time threshold for registering :',
	'RegistrationDelayInfo'		=> 'The minimum time threshold for filling out the registration form to tell away bots from humans (in seconds).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Groupe de paramètres responsable de la plate-forme de réglage fin. Ne les changez pas à moins d’avoir confiance en leurs actions.',
	'FormatterSettingsUpdated'	=> 'Mise à jour des paramètres de formatage',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> 'Typographical Proofreader :',
	'TypograficaInfo'			=> 'Unsetting slightly speed up the process of adding comments and save the page.',
	'Paragrafica'				=> 'Paragrafica markings :',
	'ParagraficaInfo'			=> 'Similar to the previous option, but will lead to disconnection of inoperable automatic table of contents: <code>{{toc}}</code>.',
	'AllowRawhtml'				=> 'Global HTML Support :',
	'AllowRawhtmlInfo'			=> 'Cette option est potentiellement dangereuse pour un site ouvert.',
	'SafeHtml'					=> 'Filtering HTML :',
	'SafeHtmlInfo'				=> 'Empêche l’enregistrement d’objets HTML dangereux. Désactiver le filtre sur un site ouvert avec support HTML est <span class="underline">extrêmement</span> indésirable !',

	'WackoFormatterSection'		=> 'Mise en forme de texte Wiki (Wacko Formatter)',
	'X11colors'					=> 'X11 Colors Usage :',
	'X11colorsInfo'				=> 'Extents the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code>Unsetting slightly speeds up the process of adding comments and saving of pages.',
	'WikiLinks'					=> 'Désactiver les Wikilinks :',
	'WikiLinksInfo'				=> 'Désactive les liens pour <code>CamelCaseWords</code>, vos CamelCase Words ne seront plus liés directement à une nouvelle page. Ceci est utile lorsque vous travaillez sur différents espaces de noms et clusters. Par défaut, il est désactivé.',
	'BracketsLinks'				=> 'Désactiver les liens entre parenthèses :',
	'BracketsLinksInfo'			=> 'Désactive <code>[[lien]]</code> et <code>((lien))</code> syntaxe.',
	'Formatters'				=> 'Désactiver les Formateurs :',
	'FormattersInfo'			=> 'Disables <code>%%code%%</code> syntax, used for highlighters.',

	'DateFormatsSection'		=> 'Date Formats',
	'DateFormat'				=> 'The format of the date :',
	'DateFormatInfo'			=> '(day, month, year)',
	'TimeFormat'				=> 'The format of time :',
	'TimeFormatInfo'			=> '(hour, minute)',
	'TimeFormatSeconds'			=> 'The format of the exact time :',
	'TimeFormatSecondsInfo'		=> '(hours, minutes, seconds)',
	'NameDateMacro'				=> 'The format of the <code>::@::</code> macro :',
	'NameDateMacroInfo'			=> '(name, time), e.g. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Fuseau horaire :',
	'TimezoneInfo'				=> 'Fuseau horaire à utiliser pour afficher les heures aux utilisateurs qui ne sont pas connectés (invités). Les utilisateurs connectés définissent et peuvent modifier leur fuseau horaire dans leurs paramètres d’utilisateur.',

	'Canonical'					=> 'Utiliser des URL canoniques :',
	'CanonicalInfo'				=> 'Tous les liens sont créés sous forme d’URL absolues sous la forme %1. Les URL relatives à la racine du serveur sous la forme %2 doivent être préférées.',
	'LinkTarget'				=> 'Where external links open :',
	'LinkTargetInfo'			=> 'Ouvre chaque lien externe dans une nouvelle fenêtre de navigateur. Ajoute <code>target="_blank"</code> à la syntaxe du lien.',
	'Noreferrer'				=> 'noreferrer :',
	'NoreferrerInfo'			=> 'Exige que le navigateur n’envoie pas d’en-tête de référence HTTP si l’utilisateur suit l’hyperlien. Ajoute <code>rel="noreferrer"</code> à la syntaxe du lien.',
	'Nofollow'					=> 'nofollow :',
	'NofollowInfo'				=> 'Indiquez à certains moteurs de recherche que l’hyperlien ne doit pas influencer le classement des liens ciblés dans l’index des moteurs de recherche. Ajoute <code>rel="nofollow"</code> à la syntaxe du lien.',
	'UrlsUnderscores'			=> 'Form addresses (URLs) with underscores :',
	'UrlsUnderscoresInfo'		=> 'For example %1 becames %2 with this option.',
	'ShowSpaces'				=> 'Insérer des espaces dans les NomWiki :',
	'ShowSpacesInfo'			=> 'Show spaces in WikiNames, e.g. <code>MyName</code> being displayed as <code>My Name</code> with this option.',
	'NumerateLinks'				=> 'Numérotation des liens en vue d’impression :',
	'NumerateLinksInfo'			=> 'Numerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disable and visualize self-referencing links :',
	'YouareHereTextInfo'		=> 'Visualizing links to the same page, try to <code>&lt;b&gt;####&lt;/b&gt;</code>, all links-to-self became not links, but bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Ici, vous pouvez définir ou modifier les pages de base du système utilisées dans le Wiki. N’oubliez pas de créer ou de modifier les pages correspondantes dans le Wiki en fonction des paramètres que vous avez définis ici.',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Number of items per list :',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster Forum :',
	'ForumClusterInfo'			=> 'Root cluster for forum section (action %1).',
	'ForumTopics'				=> 'Number of topics per page :',
	'ForumTopicsInfo'			=> 'Number of topics displayed on each page of the list in the forum sections (action %1).',
	'CommentsCount'				=> 'Number of comments per page :',
	'CommentsCountInfo'			=> 'Nombre de commentaires affichés sur chaque page de la liste des commentaires. Ceci s’applique à tous les commentaires du site, et pas seulement à ceux postés dans le forum.',

	'NewsSection'				=> 'Section News',
	'NewsCluster'				=> 'Cluster for the News :',
	'NewsClusterInfo'			=> 'Root cluster for news section (action %1).',
	'NewsStructure'				=> 'News cluster structure :',
	'NewsStructureInfo'			=> 'Stores the articles optionally in sub-clusters by year/month or week (e.g. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licence',
	'DefaultLicense'			=> 'Default license :',
	'DefaultLicenseInfo'		=> 'Under which license should your content be released.',
	'EnableLicense'				=> 'Enable License :',
	'EnableLicenseInfo'			=> 'Enable to show license information.',
	'LicensePerPage'			=> 'License per page :',
	'LicensePerPageInfo'		=> 'Allow license per page, which the page owner can choose via page properties.',

	'ServicePagesSection'		=> 'Service pages',
	'RootPage'					=> 'Page d’accueil :',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',

	'PrivacyPage'				=> 'Politique de confidentialité :',
	'PrivacyPageInfo'			=> 'The page with the Privacy Policy of the site.',

	'TermsPage'					=> 'Policies and Regulations :',
	'TermsPageInfo'				=> 'The page with the rules of the site.',

	'SearchPage'				=> 'Recherche :',
	'SearchPageInfo'			=> 'Page with the search form (action %1).',
	'RegistrationPage'			=> 'Enregistrer sur notre site :',
	'RegistrationPageInfo'		=> 'Page new user registration (action %1).',
	'LoginPage'					=> 'Connexion de l’utilisateur :',
	'LoginPageInfo'				=> 'Login page on the site (action %1).',
	'SettingsPage'				=> 'Réglages utilisateur :',
	'SettingsPageInfo'			=> 'Page customize the user profile (action %1).',
	'PasswordPage'				=> 'Change Password :',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action %1).',
	'UsersPage'					=> 'Liste des utilisateurs :',
	'UsersPageInfo'				=> 'Page with a list of registered users (action %1).',
	'CategoryPage'				=> 'Catégorie :',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action %1).',
	'GroupsPage'				=> 'Groupes :',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action %1).',
	'ChangesPage'				=> 'Recent changes :',
	'ChangesPageInfo'			=> 'Page with a list of the last modified pages (action %1).',
	'CommentsPage'				=> 'Recent comments :',
	'CommentsPageInfo'			=> 'Page with a list of recent comment on the page (action %1).',
	'RemovalsPage'				=> 'Pages supprimées :',
	'RemovalsPageInfo'			=> 'Page with a list of recently deleted pages (action %1).',
	'WantedPage'				=> 'Wanted pages :',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action %1).',
	'OrphanedPage'				=> 'Orphaned pages :',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related links with the rest (action %1).',
	'SandboxPage'				=> 'Sandbox :',
	'SandboxPageInfo'			=> 'Page where users can be trained in the use of wiki-markup.',
	'HelpPage'					=> 'Aide :',
	'HelpPageInfo'				=> 'The documentation section for working with site tools.',
	'IndexPage'					=> 'Index :',
	'IndexPageInfo'				=> 'Page avec une liste de toutes les pages (action %1).',
	'RandomPage'				=> 'Au hasard :',
	'RandomPageInfo'			=> 'Charge une page aléatoire  (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Paramètres pour les notifications de la plate-forme.',
	'NotificationSettingsUpdated'	=> 'Paramètres de notification mis à jour',

	'EmailNotification'			=> 'Notification par courriel :',
	'EmailNotificationInfo'		=> 'Autoriser la notification par e-mail. Réglé sur ON pour activer les notifications par e-mail, OFF pour les désactiver. Notez que la désactivation des notifications par e-mail n’a aucun effet sur les e-mails générés dans le cadre du processus d’inscription de l’utilisateur.',
	'Autosubscribe'				=> 'Autosubscribe :',
	'AutosubscribeInfo'			=> 'Automatically sign a new page in the owner’s notice of its changes.',

	'NotificationSection'		=> 'Paramètres de notification par défaut de l’utilisateur',
	'NotifyPageEdit'			=> 'Notifier l’édition de la page :',
	'NotifyPageEditInfo'		=> 'En attente - Envoi d’une notification par e-mail uniquement pour le premier changement jusqu’à ce que l’utilisateur visite à nouveau la page.',
	'NotifyMinorEdit'			=> 'Notifier les modifications mineures :',
	'NotifyMinorEditInfo'		=> 'Envoie également des notifications pour des modifications mineures.',
	'NotifyNewComment'			=> 'Notifier un nouveau commentaire :',
	'NotifyNewCommentInfo'		=> 'En attente - Envoi d’une notification par e-mail uniquement pour le premier commentaire jusqu’à ce que l’utilisateur visite à nouveau la page.',

	'NotifyUserAccount'			=> 'Notifier un nouveau compte d’utilisateur :',
	'NotifyUserAccountInfo'		=> 'L’administrateur sera averti lorsqu’un nouvel utilisateur a été créé à l’aide du formulaire d’inscription.',
	'NotifyUpload'				=> 'Notifier le téléchargement de fichiers :',
	'NotifyUploadInfo'			=> 'TLes modérateurs seront avertis lorsqu’un fichier a été téléchargé.',

	'PersonalMessagesSection'	=> 'Messages personnels',
	'AllowIntercomDefault'		=> 'Autoriser l’intercom :',
	'AllowIntercomDefaultInfo'	=> 'Activer cette option permet aux autres utilisateurs d’envoyer des messages personnels à l’adresse e-mail du destinataire sans divulguer l’adresse.',
	'AllowMassemailDefault'		=> 'Autoriser le courrier de masse :',
	'AllowMassemailDefaultInfo'	=> 'Il n’envoie que des messages aux utilisateurs qui ont autorisé les administrateurs à leur envoyer des informations par e-mail.',

	// Resync settings
	'Synchronize'				=> 'synchroniser',
	'UserStatsSynched'			=> 'Statistiques utilisateur synchronisées.',
	'PageStatsSynched'			=> 'Page Statistics synchronized.',
	'FeedsUpdated'				=> 'RSS-feeds updated.',
	'SiteMapCreated'			=> 'The new version of the site map created successfully.',
	'ParseNextBatch'			=> 'Parse next batch of pages:',
	'WikiLinksRestored'			=> 'Wiki-links restored.',

	'LogUserStatsSynched'		=> 'Statistiques utilisateur synchronisées',
	'LogPageStatsSynched'		=> 'Statistiques de page synchronisées',
	'LogFeedsUpdated'			=> 'Flux RSS synchronisés',
	'LogPageBodySynched'		=> 'Reparsed page body and links',

	'UserStats'					=> 'Statistiques utilisateur',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',
	'PageStats'					=> 'Statistiques des pages',
	'PageStatsInfo'				=> 'Page statistics (number of comments, files and revisions) may differ in some situations from actual data. <br>This operation allows updating statistics to current actual data of the database.',

	'AttachmentsInfo'			=> 'Met à jour le hachage du fichier pour toutes les pièces jointes de la base de données.',
	'AttachmentsSynched'		=> 'Remise à jour de toutes les pièces jointes',
	'LogAttachmentsSynched'		=> 'Remise à jour de toutes les pièces jointes',

	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'In the case of direct editing of pages in the database, the content of RSS-feeds may not reflect the changes made. <br>This function synchronizes the RSS-channels with the current state of the database.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'Cette fonction synchronise le plan du site XML avec l’état actuel de la base de données.',
	'XmlSiteMapPeriod'			=> 'Period %1 days. Last written %2.',
	'XmlSiteMapView'			=> 'Show Sitemap in a new window.',

	'ReparseBody'				=> 'Reparse all pages',
	'ReparseBodyInfo'			=> 'Empties <code>body_r</code> in page table, so that each page gets rendered again on the next page view. This may be useful if you modified the formatter or changed the domain of your wiki.',
	'PreparsedBodyPurged'		=> 'Emptied <code>body_r</code> field in page table.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Performs a re-rendering for all intrasite links and restores the contents of the table <code>page_link</code> and <code>file_link</code> in the event of damage or relocation (this can take considerable time).',
	'RecompilePage'				=> 'Recompiler toutes les pages (extrêmement cher)',
	'ResyncOptions'				=> 'Options additionelles',
	'RecompilePageLimit'		=> 'Number of pages to parse at once.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Ces informations sont utilisées lors de l’envoi de courriers électroniques à vos utilisateurs. Veuillez vous assurer que l’adresse de courrier électronique spécifiée est correcte car les messages refusés ou échoués seront probablement retournés à cette adresse. Si votre hébergeur ne fournit aucun service d’envoi de courriers électroniques en PHP par défaut, vous pouvez envoyer directement des messages en utilisant le protocole SMTP. Cela demande l’adresse d’un serveur approprié (si besoin, demandez cette information à votre hébergeur internet). Si le serveur exige une authentification (et seulement dans ce cas), saisissez le nom d’utilisateur, le mot de passe et la méthode d’authentification nécessaire.',

	'EmailSettingsUpdated'		=> 'Mise à jour des paramètres de courriel',

	'EmailFunctionName'			=> 'Nom de la fonction de la messagerie électronique :',
	'EmailFunctionNameInfo'		=> 'Le nom de la fonction PHP utilisée par la messagerie électronique afin d’envoyer des courriels.',
	'UseSmtpInfo'				=> 'Activez cette option si vous souhaitez envoyer les courriels par un serveur SMTP au lieu d’utiliser la fonction locale de la messagerie électronique.',

	'EnableEmail'				=> 'Activer les emails :',
	'EnableEmailInfo'			=> 'Activation des emails',

	'EmailIdentitySettings'		=> 'Site Internet Emails Identité',
	'FromEmailName'				=> 'From nom :',
	'FromEmailNameInfo'			=> 'Le nom de l’expéditeur, partie de <code>From:</code>en-tête dans les courriels pour toutes les notifications par courriel envoyées à partir du site.',
	'EmailSubjectPrefix'		=> 'Préfixe du sujet :',
	'EmailSubjectPrefixInfo'	=> 'Autre préfixe de l’objet du courrier électronique, par exemple <code>[Préfixe] Sujet</code>. S’il n’est pas défini, le préfixe par défaut est Nom du site : %1.',

	'NoReplyEmail'				=> 'No-reply adress :',
	'NoReplyEmailInfo'			=> 'Cette adresse, par exemple <code>noreply@example.com</code>, apparaîtra dans le champ <code>From:</code> email address de toutes vos notifications par e-mail envoyées depuis le site.',
	'AdminEmail'				=> 'Email du propriétaire du site :',
	'AdminEmailInfo'			=> 'Cette adresse est utilisée à des fins d’administration, comme la notification d’un nouvel utilisateur.',
	'AbuseEmail'				=> 'Email abuse service :',
	'AbuseEmailInfo'			=> 'Répondre aux demandes urgentes : inscription à un courrier électronique étranger, etc. Elle peut coïncider avec la précédente.',

	'SendTestEmail'				=> 'Envoyer un courriel de test',
	'SendTestEmailInfo'			=> 'Cela enverra un courriel de test à l’adresse de courriel spécifiée dans votre compte.',
	'TestEmailSubject'			=> 'Votre Wiki est correctement configuré pour envoyer des courriels',
	'TestEmailBody'				=> 'La réception de ce courriel signifie que la messagerie électronique de Wiki est correctement configurée.',
	'TestEmailMessage'			=> 'Le courriel de test a été envoyé.<br>Si vous ne le recevez pas, veuillez vérifier votre configuration des courriels.',

	'SmtpSettings'				=> 'Réglages du protocole SMTP',
	'SmtpAutoTls'				=> 'Opportunistic TLS :',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Méthode d’authentification du protocole SMTP :',
	'SmtpConnectionModeInfo'	=> 'N’est utilisée que si un nom d’utilisateur et un mot de passe ont été renseignés. Veuillez demander cette information à votre hébergeur internet si vous n’êtes pas certain de la méthode à utiliser.',
	'SmtpPassword'				=> 'Mot de passe SMTP :',
	'SmtpPasswordInfo'			=> 'Ne saisissez un mot de passe que si votre serveur SMTP le demande.<br><em><strong>Attention :</strong> ce mot de passe sera stocké en texte brut dans la base de données et sera visible à tous ceux qui ont accès à votre base de données et à cette page de configuration.</em>',
	'SmtpPort'					=> 'Port du serveur SMTP :',
	'SmtpPortInfo'				=> 'Ne modifiez ce dernier que si votre serveur SMTP utilise un port différent dont vous avez connaissance. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Adresse du serveur SMTP :',
	'SmtpServerInfo'			=> 'Veuillez noter que vous devez renseigner le protocole utilisé par le serveur. Si vous utilisez SSL, cela ressemblera à <code>ssl://mail.example.com</code>',
	'SmtpUsername'				=> 'Nom d’utilisateur SMTP :',
	'SmtpUsernameInfo'			=> 'Ne saisissez un nom d’utilisateur que si votre serveur SMTP le demande.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Vous pouvez configurer sur cette page les réglages relatifs aux pièces jointes et à leurs catégories spéciales.',
	'UploadSettingsUpdated'		=> 'Mise à jour des paramètres de téléchargement',

	'FileUploadsSection'		=> 'Téléchargements de fichiers',
	'RegisteredUsers'			=> 'utilisateurs enregistrés',
	'RightToUpload'				=> 'Droit aux fichiers téléchargés :',
	'RightToUploadInfo'			=> '<code>admins</code> signifie que seuls les utilisateurs appartenant au groupe admins peuvent télécharger les fichiers. <code>1</code> signifie que le téléchargement est ouvert aux utilisateurs enregistrés. <code>0</code> signifie que le téléchargement est désactivé.',
	'UploadMaxFilesize'			=> 'Taille maximale des pièces jointes :',
	'UploadMaxFilesizeInfo'		=> 'La taille maximale des pièces jointes. Si cette valeur est réglée sur 0, la taille ne sera limitée que par votre configuration de PHP.',
	'UploadQuota'				=> 'Quota maximal des pièces jointes :',
	'UploadQuotaInfo'			=> 'L’espace de stockage maximal alloué à la totalité des pièces jointes transférées sur le forum. Réglez cette valeur sur <code>0</code> si vous ne souhaitez pas limiter cet espace. %1 used.',
	'UploadQuotaUser'			=> 'Quota de stockage par utilisateur :',
	'UploadQuotaUserInfo'		=> 'Restriction sur le quota de stockage qui peut être téléchargé par un utilisateur, <code>0</code> étant illimité.',

	'FileTypes'					=> 'Formats de fichiers',
	'UploadOnlyImages'			=> 'Autoriser uniquement le téléchargement d’images :',
	'UploadOnlyImagesInfo'		=> 'Autoriser uniquement le téléchargement de fichiers image sur la page.',
	'AllowedUploadExts'			=> 'Formats de fichiers autorisés :',
	'AllowedUploadExtsInfo'		=> 'Extensions autorisées pour le téléchargement de fichiers, séparées par des virgules, par exemple <code>png, ogg, mp4</code>, sinon toutes les extensions de fichiers non interdites sont autorisées.<br>Vous devez limiter la liste des types de fichiers téléchargés autorisés au minimum nécessaire à la fonctionnalité du contenu de votre site.',
	'CheckMimetype'				=> 'Vérifier les pièces jointes :',
	'CheckMimetypeInfo'			=> 'Certains navigateurs internet peuvent faire erreur en attribuant un type MIME incorrect aux fichiers transférés. Cette option permet de rejeter les fichiers qui présentent un risque de provoquer cette erreur.',
	'SvgSanitizer'				=> 'SVG Sanitizer:',
	'SvgSanitizerInfo'			=> 'Cela permet d’assainir les fichiers SVG téléchargés afin d’éviter que des fichiers SVG/XML vulnérables ne soient téléchargés.',
	'TranslitFileName'			=> 'Transliterate file names :',
	'TranslitFileNameInfo'		=> 'Si elle est applicable et qu’il n’est pas nécessaire d’avoir des caractères Unicode, il est fortement recommandé de n’accepter que des caractères alphanumériques.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Générer des miniatures :',
	'CreateThumbnailInfo'		=> 'Génère des miniatures dans toutes les situations possibles.',
	'JpegQuality'				=> 'Qualité JPEG :',
	'JpegQualityInfo'			=> 'Qualité lors de la mise à l’échelle d’une vignette JPEG. Elle doit être comprise entre 1 et 100, 100 indiquant une qualité de 100 %.',
	'MaxImageArea'				=> 'Maximum Image Area:',
	'MaxImageAreaInfo'			=> 'Le nombre maximum de pixels que peut avoir une image source. Cela permet de limiter l’utilisation de la mémoire pour la partie décompression de l’outil de mise à l’échelle de l’image. <br><code>-1</code> signifie qu’il ne vérifiera pas la taille de l’image avant de tenter de la mettre à l’échelle. <code>0</code> signifie qu’il déterminera la valeur automatiquement.',
	'MaxThumbWidth'				=> 'Largeur maximale des miniatures :',
	'MaxThumbWidthInfo'			=> 'Les miniatures générées ne dépasseront pas la largeur de cette valeur.',
	'MinThumbFilesize'			=> 'Taille minimale des miniatures :',
	'MinThumbFilesizeInfo'		=> 'Si la taille des images est inférieure à cette valeur, ces dernières ne seront pas miniaturisées.',
	'MaxImageWidth'				=> 'Limite de taille de l’image sur les pages :',
	'MaxImageWidthInfo'			=> 'Largeur maximale d’une image sur les pages, sinon une vignette réduite est générée.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Liste des pages, révisions et fichiers supprimés.
									Finally remove or restore the pages, revisions or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Mots qui seront automatiquement censurés sur votre Wiki.',
	'FilterSettingsUpdated'		=> 'Mise à jour des paramètres du filtre anti-spam',

	'WordCensoringSection'		=> 'Censure des mots',
	'SPAMFilter'				=> 'Filtre anti-spam :',
	'SPAMFilterInfo'			=> 'Activation du filtre anti-spam',
	'WordList'					=> 'Liste de mots :',
	'WordListInfo'				=> 'Mot ou phrase <code>fragment</code> à mettre sur liste noire (un par ligne)',

	// Log module
	'LogFilterTip'				=> 'Filtrer les événements par critère :',
	'LogLevel'					=> 'Niveau',
	'LogLevelFilters'	=> [
		'1'		=> 'pas moins de',
		'2'		=> 'pas plus de',
		'3'		=> 'égal',
	],
	'LogNoMatch'				=> 'Aucun événement ne répond aux critères',
	'LogDate'					=> 'Date',
	'LogEvent'					=> 'Événement',
	'LogUsername'				=> 'Nom d’utilisateur',
	'LogLevels'	=> [
		'1'		=> 'critique',
		'2'		=> 'le plus élevé',
		'3'		=> 'élevé',
		'4'		=> 'moyen',
		'5'		=> 'bas',
		'6'		=> 'le plus bas',
		'7'		=> 'débogage',
	],

	// Massemail module
	'MassemailInfo'				=> 'Vous pouvez envoyer sur cette page un courriel à la totalité des utilisateurs ou aux utilisateurs d’un groupe d’utilisateurs spécifique <strong>qui acceptent la réception de courriels de masse</strong>. Pour ce faire, un courriel sera envoyé à l’adresse de courriel renseignée par les administrateurs et une copie sera adressée à tous les destinataires. Le réglage par défaut est limité à 20 destinataires par courriel, mais si ce nombre est dépassé, des courriels supplémentaires seront envoyés. Sachez également que plus les destinataires sont nombreux, plus le temps d’exécution est important. Il est normal que l’envoi d’un courriel de masse prenne un certain temps, veillez à ne pas vous déplacer sur une autre page tant que l’opération n’est pas totalement terminée.',
	'LogMassemail'				=> 'Messemail send %1 to group / user ',
	'MassemailSend'				=> 'Massemail send',

	'NoEmailMessage'			=> 'Vous devez saisir un message.',
	'NoEmailSubject'			=> 'Vous devez saisir le sujet de votre message.',
	'NoEmailRecipient'			=> 'Vous devez spécifier au moins un utilisateur ou un groupe d’utilisateurs.',

	'MassemailSection'			=> 'Courriel de masse',
	'MessageSubject'			=> 'Sujet :',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Votre message :',
	'YourMessageInfo'			=> 'Le message ne doit contenir que du texte brut. Toutes les balises seront automatiquement supprimées.',

	'NoUser'					=> 'Aucun utilisateur',
	'NoUserGroup'				=> 'Aucun groupe d’utilisateurs',

	'SendToGroup'				=> 'Envoyer à un groupe d’utilisateurs :',
	'SendToUser'				=> 'Envoyer à des utilisateurs :',
	'SendToUserInfo'			=> 'Il n’envoie que des messages aux utilisateurs qui ont autorisé les administrateurs à leur envoyer des informations par e-mail. Cette option est disponible dans leurs paramètres utilisateur sous notifications.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Message système mis à jour',

	'SysMsgSection'				=> 'Message du système',
	'SysMsg'					=> 'Message du système :',
	'SysMsgInfo'				=> 'Votre texte ici',

	'SysMsgType'				=> 'Type :',
	'SysMsgTypeInfo'			=> 'Type de message (CSS).',
	'SysMsgAudience'			=> 'Audience:',
	'SysMsgAudienceInfo'		=> 'Audience à laquelle le message du système est présenté.',
	'EnableSysMsg'				=> 'Activer le message du système :',
	'EnableSysMsgInfo'			=> 'Afficher le message système.',

	// User approval module
	'ApproveNotExists'			=> 'Veuillez sélectionner au moins un utilisateur à l’aide du bouton Définir.',

	'LogUserApproved'			=> 'Utilisateur ##%1## approuvé',
	'LogUserBlocked'			=> 'Utilisateur ##%1## bloqué',
	'LogUserDeleted'			=> 'Utilisateur ##%1## supprimé de la base de données',
	'LogUserCreated'			=> 'Création d’un nouvel utilisateur ##%1##',
	'LogUserUpdated'			=> 'Utilisateur mis à jour ##%1##',

	'UserApproveInfo'			=> 'Approuver les nouveaux utilisateurs avant qu’ils ne puissent se connecter au site.',
	'Approve'					=> 'Approuver',
	'Deny'						=> 'Refuser',
	'Pending'					=> 'En attente',
	'Approved'					=> 'Approuvé',
	'Denied'					=> 'Refusé',

	// DB Backup module
	'BackupStructure'			=> 'Structure',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Folder',
	'BackupTable'				=> 'Table',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'Fichiers',
	'BackupNote'				=> 'Note :',
	'BackupSettings'			=> 'Spécifiez le schéma de sauvegarde souhaité.<br>' .
									'The root cluster does not affect the global files backup and cache files backup (being chosen they are always saved in full).<br>' .
									'<br>' .
									'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster the tables from this backup will not be restructured, ' .
									'same when backing up only table structure without saving the data. ' .
									'To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Sauvegarde et archivage terminés.<br>' .
									'Les fichiers du package de sauvegarde ont été stockés dans le sous-répertoire %1 suivant.<br>' .
									'Pour le télécharger, utilisez FTP (gérez la structure des répertoires et les noms de fichiers lors de la copie).<br>' .
									'Pour restaurer une copie de sauvegarde ou supprimer un paquet, allez à <a href="%2">Restaurer la base de données</a>.',
	'LogSavedBackup'			=> 'Saved backup database ##%1##',
	'Backup'					=> 'Sauvegarde',
	'CantReadFile'				=> 'Can’t read file %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Vous pouvez restaurer n’importe lequel des paquets de sauvegarde trouvés ou le supprimer du serveur.',
	'ConfirmDbRestore'			=> 'Voulez-vous restaurer la sauvegarde %1 ?',
	'ConfirmDbRestoreInfo'		=> 'Veuillez patienter quelques minutes.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'DirectoryNotExecutable'	=> 'Le répertoire %1 n’est pas exécutable.',
	'BackupDelete'				=> 'Êtes-vous sûr de vouloir supprimer %1 de sauvegarde ?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Autres options de restauration :',
	'RestoreOptionsInfo'		=> '* Before restoring the <strong>cluster backup</strong>, ' .
									'the target tables are not deleted (to prevent loss of information from the clusters that have not been backed up). ' .
									'Thus, during the recovery process duplicate records will occur. ' .
									'In normal mode, all of them will be replaced by the records form backup (using SQL-instruction <code>REPLACE</code>), ' .
									'but if this checkbox is checked, all duplicates are skipped (the current values of records will be kept), ' .
									'and only the records with new keys are added to the table (SQL-instruction <code>INSERT IGNORE</code>).<br>' .
									'<strong>Notice</strong>: When restore complete backup of the site, this option has no value.<br>' .
									'<br>' .
									'** If the backup contains the user files (global and perpage, cache files, etc.), ' .
									'in normal mode they replace the existing files with the same names and are placed in the same directory when being restored. ' .
									'This option allows you to save the current copies of the files and restore from a backup only new files (missing on the server).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignore duplicated table keys (not replace)',
	'IgnoreSameFiles'			=> 'Ignore same files (not overwrite)',
	'NoBackupsAvailable'		=> 'Aucune sauvegarde n’est disponible.',
	'BackupEntireSite'			=> 'Entire site',
	'BackupRestored'			=> 'The backup is restored, a summary report is attached below. To delete this backup package, click',
	'BackupRemoved'				=> 'The selected backup has been successfully removed.',
	'LogRemovedBackup'			=> 'Removed database backup ##%1##',

	'RestoreStarted'			=> 'Initiated Restoration',
	'RestoreParameters'			=> 'Using parameters',
	'IgnoreDuplicatedKeys'		=> 'Ignorer les clés dupliquées',
	'IgnoreDuplicatedFiles'		=> 'Ignore duplicated files',
	'SavedCluster'				=> 'Saved cluster',
	'DataProtection'			=> 'Data Protection - %1 omitted',
	'AssumeDropTable'			=> 'Assume %1',
	'RestoreTableStructure'		=> 'Restoring the structure of the table',
	'RunSqlQueries'				=> 'Perform SQL-instructions :',
	'CompletedSqlQueries'		=> 'Completed. Processed instructions :',
	'NoTableStructure'			=> 'The structure of the tables was not saved - skip',
	'RestoreRecords'			=> 'Restore the contents of tables',
	'ProcessTablesDump'			=> 'Just download and process tables dump',
	'Instruction'				=> 'Instruction',
	'RestoredRecords'			=> 'records :',
	'RecordsRestoreDone'		=> 'Completed. Total entries :',
	'SkippedRecords'			=> 'Data not saved - skip',
	'RestoringFiles'			=> 'Restoring files',
	'DecompressAndStore'		=> 'Decompress and store the contents of directories',
	'HomonymicFiles'			=> 'homonymic files',
	'RestoreSkip'				=> 'skip',
	'RestoreReplace'			=> 'replace',
	'RestoreFile'				=> 'Fichier :',
	'RestoredFiles'				=> 'restored :',
	'SkippedFiles'				=> 'skipped :',
	'FileRestoreDone'			=> 'Completed. Total files :',
	'FilesAll'					=> 'tous :',
	'SkipFiles'					=> 'Files are not stored - skip',
	'RestoreDone'				=> 'RESTORATION COMPLETED',

	'BackupCreationDate'		=> 'Date de création',
	'BackupPackageContents'		=> 'Le contenu du paquet',
	'BackupRestore'				=> 'Restaurer',
	'BackupRemove'				=> 'Enlever',
	'RestoreYes'				=> 'si',
	'RestoreNo'					=> 'non',
	'LogDbRestored'				=> 'Sauvegarde ##%1## de la base de données restaurée.',

	'BackupArchived'			=> 'Sauvegarde %1 archivée.',
	'BackupArchiveExists'		=> 'L’archive de sauvegarde %1 existe déjà.',
	'LogBackupArchived'			=> 'Sauvegarde ##%1## archivée.',

	// User module
	'UsersInfo'					=> 'Here you can change your users information and certain specific options.',

	'UsersAdded'				=> 'Utilisateur ajouté',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> 'Éditer',
	'UsersAddNew'				=> 'Ajouter un utilisateur',
	'UsersDelete'				=> 'Êtes-vous sûr de vouloir supprimer l’utilisateur %1 ?',
	'UsersDeleted'				=> 'L’utilisateur %1 a été supprimé de la base de données.',
	'UsersRename'				=> 'Renommer l’utilisateur %1 en',
	'UsersRenameInfo'			=> '* Note : les modifications affecteront toutes les pages affectées à cet utilisateur.',
	'UsersUpdated'				=> 'Utilisateur effectivement actualisé.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Temps d’inscription',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'Aucun utilisateur ne répond aux critères',

	'UserAccountNotify'			=> 'Notifier l’utilisateur',
	'UserNotifySignup'			=> 'informer l’utilisateur du nouveau compte',
	'UserVerifyEmail'			=> 'configurer le jeton de confirmation de l’email et ajouter un lien pour la vérification de l’email',
	'UserReVerifyEmail'			=> 'Renvoyer l’e-mail de confirmation du jeton',

	// Groups module
	'GroupsInfo'				=> 'A partir de ce panneau, vous pouvez administrer tous vos groupes d’utilisateurs. Vous pouvez supprimer, créer et modifier des groupes existants. En outre, vous pouvez choisir les chefs de groupe, basculer entre les statuts Ouvert/Masqué/Fermé et définir le nom et la description du groupe.',

	'LogMembersUpdated'			=> 'Mise à jour des membres du groupe d’utilisateurs',
	'LogMemberAdded'			=> 'Added member ##%1## to group ##%2##',
	'LogMemberRemoved'			=> 'Removed member ##%1## from group ##%2##',
	'LogGroupCreated'			=> 'Création d’un nouveau groupe ##%1##',
	'LogGroupRenamed'			=> 'Group ##%1## renamed to ##%2##',
	'LogGroupRemoved'			=> 'Groupe supprimé ##%1##',

	'GroupsMembersFor'			=> 'Membres du groupe',
	'GroupsDescription'			=> 'Description',
	'GroupsModerator'			=> 'Modérateur',
	'GroupsOpen'				=> 'Ouvert',
	'GroupsActive'				=> 'Actif',
	'GroupsTip'					=> 'Cliquer pour modifier le groupe',
	'GroupsUpdated'				=> 'Groupes modifiés',
	'GroupsAlreadyExists'		=> 'Ce groupe existe déjà.',
	'GroupsAdded'				=> 'Groupe effectivement ajouté.',
	'GroupsRenamed'				=> 'Groupe effectivement renommé.',
	'GroupsDeleted'				=> 'Le groupe %1 a été supprimé de la base de données et de toutes les pages.',
	'GroupsAdd'					=> 'Ajouter un groupe',
	'GroupsRename'				=> 'Renommer le groupe %1',
	'GroupsRenameInfo'			=> '* Note : la modification affectera toutes les pages affectées au groupe.',
	'GroupsDelete'				=> 'Êtes-vous sûr(e) de vouloir supprimer le groupe %1?',
	'GroupsDeleteInfo'			=> '* Note : la modification affectera tous les membres du groupe.',
	'GroupsIsSystem'			=> 'Le groupe %1 appartient au système et ne peut pas être supprimé.',
	'GroupsStoreButton'			=> 'Sauvegarder les  groupes',
	'GroupsEditInfo'			=> 'Pour modifier la liste des groupes utilisez le bouton radio.',

	'GroupAddMember'			=> 'Ajouter un membre',
	'GroupRemoveMember'			=> 'Supprimer un membre',
	'GroupAddNew'				=> 'Ajouter un groupe',
	'GroupEdit'					=> 'Modifier le groupe',
	'GroupDelete'				=> 'Supprimer un groupe',

	'MembersAddNew'				=> 'Ajouter un membre',
	'MembersAdded'				=> 'Added new member to the group successfully.',
	'MembersRemove'				=> 'Êtes-vous sûr de vouloir ôter le membre %1 ?',
	'MembersRemoved'			=> 'Le membre a été ôté du groupe.',

	// Statistics module
	'DbStatSection'				=> 'Statistiques de la base de données',
	'DbTable'					=> 'Table',
	'DbRecords'					=> 'Records',
	'DbSize'					=> 'Taille',
	'DbIndex'					=> 'Index',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'File system Statistics',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> 'Fichiers',
	'FileSize'					=> 'Taille',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Version informations :',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Values',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Dernière mise à jour',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Server name',
	'WebServer'					=> 'Web server',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'SQL Modes Global',
	'SqlModesSession'			=> 'SQL Modes Session',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memory',
	'UploadFilesizeMax'			=> 'Upload max filesize',
	'PostMaxSize'				=> 'Post max size',
	'MaxExecutionTime'			=> 'Max execution time',
	'SessionPath'				=> 'Session path',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip compression',
	'PhpExtensions'				=> 'PHP extensions',
	'ApacheModules'				=> 'Apache modules',

	// DB repair module
	'DbRepairSection'			=> 'Repair Database',
	'DbRepair'					=> 'Repair Database',
	'DbRepairInfo'				=> 'Ce script peut rechercher automatiquement certains problèmes courants des bases de données et les réparer. La réparation peut prendre un certain temps, alors soyez patient.',

	'DbOptimizeRepairSection'	=> 'Réparer et optimiser la base de données',
	'DbOptimizeRepair'			=> 'Réparer et optimiser la base de données',
	'DbOptimizeRepairInfo'		=> 'Ce script peut également tenter d’optimiser la base de données. Cela améliore les performances dans certaines situations. La réparation et l’optimisation de la base de données peuvent prendre beaucoup de temps et la base de données sera verrouillée tout en l’optimisant.',

	'TableOk'					=> 'Le tableau %1 est correct.',
	'TableNotOk'				=> 'Le tableau %1 n’est pas correct. Il signale l’erreur suivante : %2. Ce script va tenter de réparer cette table…',
	'TableRepaired'				=> 'Successfully repaired the %1 table.',
	'TableRepairFailed'			=> 'N’a pas réussi à réparer la table %1. <br>Erreur : %2',
	'TableAlreadyOptimized'		=> 'Le tableau %1 est déjà optimisé.',
	'TableOptimized'			=> 'Optimisation réussie du tableau %1.',
	'TableOptimizeFailed'		=> 'N’a pas réussi à optimiser le tableau %1. <br>Erreur : %2',
	'TableNotRepaired'			=> 'Certains problèmes de base de données n’ont pas pu être réparés.',
	'RepairsComplete'			=> 'Réparations terminées',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Show and fix inconsistencies, delete or assign orphaned records to a new user / value.',
	'Inconsistencies'			=> 'Incohérences',
	'CheckDatabase'				=> 'Base de données',
	'CheckDatabaseInfo'			=> 'Vérifie les incohérences d’enregistrement dans la base de données.',
	'CheckFiles'				=> 'Fichiers',
	'CheckFilesInfo'			=> 'Vérifie les fichiers abandonnés, les fichiers qui n’ont plus de référence dans la table des fichiers.',
	'Records'					=> 'Records',
	'InconsistenciesNone'		=> 'Aucune incohérence dans les données trouvée.',
	'InconsistenciesDone'		=> 'Les incohérences dans les données ont été résolues.',
	'InconsistenciesRemoved'	=> 'Correction des incohérences',
	'Check'						=> 'Vérifier',
	'Solve'						=> 'Solve',

	// Bad Behaviour module
	'BbInfo'					=> 'Détecte et bloque les accès Web indésirables, refuse l’accès aux robots spammeurs automatisés <br>Pour plus d’informations, veuillez consulter la page d’accueil %1.',
	'BbEnable'					=> 'Activer Bad Behaviour :',
	'BbEnableInfo'				=> 'All other settings can be changed in the config folder %1.',
	'BbStats'					=> 'Bad Behaviour a bloqué %1 tentatives d’accès au cours des 7 derniers jours.',

	'BbSummary'					=> 'Résumé',
	'BbLog'						=> 'Journal',
	'BbSettings'				=> 'Réglages',
	'BbWhitelist'				=> 'Liste blanche',

	// --> Log
	'BbHits'					=> 'Hits',
	'BbRecordsFiltered'			=> 'Displaying %1 of %2 records filtered by',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Bloqué',
	'BbPermitted'				=> 'Autorisé',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Displaying all %1 records',
	'BbShow'					=> 'Afficher',
	'BbIpDateStatus'			=> 'IP/Date/Status',
	'BbHeaders'					=> 'Headers',
	'BbEntity'					=> 'Entity',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Options saved.',
	'BbWhitelistHint'			=> 'Inappropriate whitelisting WILL expose you to spam, or cause Bad Behaviour to stop functioning entirely! DO NOT WHITELIST unless you are 100% CERTAIN that you should.',
	'BbIpAddress'				=> 'IP Address',
	'BbIpAddressInfo'			=> 'IP address or CIDR format address ranges to be whitelisted (one per line)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL fragments beginning with the / after your web site hostname (one per line)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'User agent strings to be whitelisted (one per line)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Updated Bad Behaviour settings',
	'BbLogRequest'				=> 'Logging HTTP request',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (recommended)',
	'BbLogOff'					=> 'Do not log (not recommended)',
	'BbSecurity'				=> 'Sécurité',
	'BbStrict'					=> 'Strict checking',
	'BbStrictInfo'				=> 'blocks more spam but may block some people',
	'BbOffsiteForms'			=> 'Allow form postings from other web sites',
	'BbOffsiteFormsInfo'		=> 'required for OpenID; increases spam received',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'To use Bad Behaviour’s http:BL features you must have an %1',
	'BbHttpblKey'				=> 'http:BL Access Key',
	'BbHttpblThreat'			=> 'Minimum Threat Level (25 is recommended)',
	'BbHttpblMaxage'			=> 'Maximum Age of Data (30 is recommended)',
	'BbReverseProxy'			=> 'Reverse Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'If you are using Bad Behaviour behind a reverse proxy, load balancer, HTTP accelerator, content cache or similar technology, enable the Reverse Proxy option.<br>' .
									'If you have a chain of two or more reverse proxies between your server and the public Internet, you must specify <em>all</em> of the IP address ranges (in CIDR format) of all of your proxy servers, load balancers, etc. Otherwise, Bad Behaviour may be unable to determine the client’s true IP address.<br>' .
									'In addition, your reverse proxy servers must set the IP address of the Internet client from which they received the request in an HTTP header. If you don’t specify a header, %1 will be used. Most proxy servers already support X-Forwarded-For and you would then only need to ensure that it is enabled on your proxy servers. Some other header names in common use include %2 and %3.',
	'BbReverseProxyEnable'		=> 'Enable Reverse Proxy',
	'BbReverseProxyHeader'		=> 'Header containing Internet clients IP address',
	'BbReverseProxyAddresses'	=> 'IP address or CIDR format address ranges for your proxy servers (one per line)',

];
