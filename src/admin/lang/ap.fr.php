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
		'maintenance'	=> 'Entretien',
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

	'System'					=> 'Système',

	// Generic
	'Cancel'					=> 'Annuler',
	'Add'						=> 'Ajouter',
	'Edit'						=> 'Modifier',
	'Remove'					=> 'Enlever',
	'Enabled'					=> 'Activé',
	'Disabled'					=> 'Désactivé',
	'Mandatory'					=> 'Obligatoire',
	'Admin'						=> 'Administrateur',
	'Min'						=> 'Min',
	'Max'						=> 'Max.',

	'MiscellaneousSection'		=> 'Divers',
	'MainSection'				=> 'Paramètres de base',

	'DirNotWritable'			=> 'Le répertoire %1 n’est pas accessible en écriture.',
	'FileNotWritable'			=> 'Le fichier %1 n\'est pas accessible en écriture.',

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
		'name'		=> 'Basique',
		'title'		=> 'Paramètres de base',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Apparence',
		'title'		=> 'Paramètres d’apparence',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Courriel',
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
		'name'		=> 'Formats',
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
		'title'		=> 'Administration de WackoWiki',
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
		'name'		=> 'Comportement incorrect',
		'title'		=> 'Comportement incorrect',
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
	'CommentsOffset'			=> 'Page de commentaires:',
	'CommentsOffsetInfo'		=> 'Page de commentaires à afficher par défaut',

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
	'DisplayingSectionsInfo'	=> 'Lorsque les options précédentes sont définies, il est possible d\'afficher uniquement les sous-pages de la page (<em>inférieure</em>), uniquement les pages voisines (<em>supérieures</em>), les deux ou les autres (<em>arborescence</em>).',
	'MenuItems'					=> 'Éléments du menu :',
	'MenuItemsInfo'				=> 'Nombre par défaut d’éléments de menu affichés (peut avoir besoin d’aide dans les modèles).',

	'HandlerSection'			=> 'Handler',
	'HideRevisions'				=> 'Masquer révisions :',
	'HideRevisionsInfo'			=> 'L’affichage par défaut des révisions de la page.',
	'AttachmentHandler'			=> 'Activer le gestionnaire de pièces jointes :',
	'AttachmentHandlerInfo'		=> 'Permet d’afficher le gestionnaire de pièces jointes.',
	'SourceHandler'				=> 'Activer le gestionnaire de source:',
	'SourceHandlerInfo'			=> 'Permet l\'affichage du gestionnaire de source.',
	'ExportHandler'				=> 'Activer le gestionnaire d\'exportation XML:',
	'ExportHandlerInfo'			=> 'Permet l\'affichage du gestionnaire d\'exportation XML.',

	'DiffModeSection'			=> 'Modes Diff',
	'DefaultDiffModeSetting'	=> 'Mode diff par défaut :',
	'DefaultDiffModeSettingInfo'=> 'Mode diff présélectionné.',
	'AllowedDiffMode'			=> 'Modes Diff autorisés :',
	'AllowedDiffModeInfo'		=> 'Il est recommandé de ne sélectionner que l’ensemble des modes de diff que vous souhaitez utiliser, sinon tous les modes de diff sont sélectionnés.',
	'NotifyDiffMode'			=> 'Notify diff mode :',
	'NotifyDiffModeInfo'		=> 'Mode Diff utilisé pour les notifications dans le corps de l’email.',

	'EditingSection'			=> 'Rédaction',
	'EditSummary'				=> 'Éditer le sommaire :',
	'EditSummaryInfo'			=> 'Montre le résumé des changements en mode édition.',
	'MinorEdit'					=> 'Édition mineure :',
	'MinorEditInfo'				=> 'Active l\'option d\'édition mineure en mode édition.',
	'SectionEdit'				=> 'Edition de section :',
	'SectionEditInfo'			=> 'Permet de modifier uniquement une section d’une page.',
	'ReviewSettings'			=> 'Review :',
	'ReviewSettingsInfo'		=> 'Active l\'option de révision en mode édition.',
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
	'EnableCounters'			=> 'Compteurs de clics :',
	'EnableCountersInfo'		=> 'Permet de compter les hits par page et d’afficher des statistiques simples. Les appels du propriétaire de la page ne sont pas comptabilisés.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Contrôle les paramètres de syndication web par défaut pour votre site.',
	'SyndicationSettingsUpdated'	=> 'Paramètres de syndication mis à jour.',

	'FeedsSection'				=> 'Flux',
	'EnableFeeds'				=> 'Activer les flux :',
	'EnableFeedsInfo'			=> 'Active ou désactive les flux RSS pour l’ensemble du wiki.',
	'XmlChangeLink'				=> 'Changer le mode de lien de flux :',
	'XmlChangeLinkInfo'			=> 'Définit à quel point les éléments du flux XML Changements sont liés.',
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
	'XmlSitemapTime'			=> 'Temps de génération du sitemap XML :',
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
	'LogoOnly'					=> 'Logo',
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

	'LayoutSection'				=> 'Mise en page',
	'Theme'						=> 'Thème :',
	'ThemeInfo'					=> 'La conception des modèles que le site utilise par défaut.',
	'ResetUserTheme'			=> 'Réinitialiser tous les thèmes de l\'utilisateur :',
	'ResetUserThemeInfo'		=> 'Réinitialise tous les thèmes de l\'utilisateur. Attention : Cette action annulera tous les thèmes sélectionnés par l\'utilisateur vers le thème global par défaut.',
	'SetBackUserTheme'			=> 'Rétablir tous les thèmes utilisateur au thème %1.',
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

	'LogSection'				=> 'Paramètres du journal',
	'LogLevelUsage'				=> 'Utiliser la journalisation :',
	'LogLevelUsageInfo'			=> 'La priorité minimale des événements enregistrés dans le journal.',
	'LogThresholds'	=> [
		'0'		=> 'ne pas tenir de journal',
		'1'		=> 'seulement le niveau critique',
		'2'		=> 'du plus haut niveau',
		'3'		=> 'à partir de haut',
		'4'		=> 'en moyenne',
		'5'		=> 'à partir de bas',
		'6'		=> 'le niveau minimum',
		'7'		=> 'enregistrer tout',
	],
	'LogDefaultShow'			=> 'Display Log Mode :',
	'LogDefaultShowInfo'		=> 'Les événements de priorité minimale affichés dans le journal par défaut.',
	'LogModes'	=> [
		'1'		=> 'seulement le niveau critique',
		'2'		=> 'du plus haut niveau',
		'3'		=> 'de haut niveau',
		'4'		=> 'la moyenne',
		'5'		=> 'à partir d\'un bas',
		'6'		=> 'du niveau minimum',
		'7'		=> 'tout afficher',
	],
	'LogPurgeTime'				=> 'Temps de stockage du journal :',
	'LogPurgeTimeInfo'			=> 'Supprimer le journal des événements après le nombre de jours spécifié.',

	'PrivacySection'			=> 'Vie privée',
	'AnonymizeIp'				=> 'Anonymiser les adresses IP des utilisateurs :',
	'AnonymizeIpInfo'			=> 'Anonymiser les adresses IP, le cas échéant, comme les pages, les révisions ou les références.',

	'ReverseProxySection'		=> 'Proxy inverse',
	'ReverseProxy'				=> 'Utiliser un proxy inverse :',
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
	'RewriteModeInfo'				=> 'Si votre serveur web prend en charge cette fonctionnalité, activez pour "embellir" les URL de la page.<br>
										<span class="cite">La valeur peut être remplacée par la classe Paramètres à l\'exécution, que ce soit désactivé, si HTTP_MOD_REWRITE est activé.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Paramètres responsables du contrôle d’accès et des permissions.',
	'PermissionsSettingsUpdated'	=> 'Mise à jour des paramètres de permissions',

	'PermissionsSection'		=> 'Droits et privilèges',
	'ReadRights'				=> 'Droits de lecture par défaut :',
	'ReadRightsInfo'			=> 'Assigné par défaut aux pages racine créées, ainsi qu\'aux pages pour lesquelles les ACLs parents ne peuvent pas être définies.',
	'WriteRights'				=> 'Droits d’écriture par défaut :',
	'WriteRightsInfo'			=> 'Assigné par défaut aux pages racine créées, ainsi qu\'aux pages pour lesquelles les ACLs parents ne peuvent pas être définies.',
	'CommentRights'				=> 'Droits de commentaire par défaut :',
	'CommentRightsInfo'			=> 'Assigné par défaut aux pages racine créées, ainsi qu\'aux pages pour lesquelles les ACLs parents ne peuvent pas être définies.',
	'CreateRights'				=> 'Créer les droits d\'une sous-page par défaut :',
	'CreateRightsInfo'			=> 'Assigné par défaut aux sous-pages créées.',
	'UploadRights'				=> 'Droits de téléchargement par défaut :',
	'UploadRightsInfo'			=> 'Droits de téléchargement par défaut.',
	'RenameRights'				=> 'Droit global de renommer :',
	'RenameRightsInfo'			=> 'La liste des permissions pour renommer (déplacer) librement les pages.',

	'LockAcl'					=> 'Verrouiller toutes les ACL en lecture seule :',
	'LockAclInfo'				=> '<span class="cite">Remplace les paramètres ACL de toutes les pages en lecture seule.</span><br>Cela peut être utile si un projet est terminé, si vous souhaitez fermer l\'édition pendant une période de temps pour des raisons de sécurité ou comme réponse d\'urgence à un exploit ou à une vulnérabilité.',
	'HideLocked'				=> 'Masquer les pages inaccessibles :',
	'HideLockedInfo'			=> 'Si l’utilisateur n’a pas l’autorisation de lire la page, cachez-la dans des listes de pages différentes (cependant le lien placé dans le texte, sera toujours visible).',
	'RemoveOnlyAdmins'			=> 'Seuls les administrateurs peuvent supprimer des pages :',
	'RemoveOnlyAdminsInfo'		=> 'Refuser tout, à l\'exception des administrateurs, la possibilité de supprimer des pages. La première limite s\'applique aux propriétaires de pages normales.',
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

	'EmailSection'				=> 'Courriel',
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
	'TlsConnectionInfo'			=> 'Utiliser la connexion sécurisée TLS. <span class="cite">Activez le certificat TLS pré-installé sur le serveur, sinon vous perdrez l\'accès au panneau d\'administration !</span><br>Il détermine également si le drapeau Cookie Secure est défini : Le drapeau <code>sécurisé</code> spécifie si les cookies ne doivent être envoyés que sur des connexions sécurisées.',
	'TlsImplicit'				=> 'TLS obligatoire :',
	'TlsImplicitInfo'			=> 'Reconnecter de force le client de HTTP à HTTPS. L’option étant désactivée, le client peut naviguer sur le site via un canal HTTP ouvert.',

	'HttpSecurityHeaders'		=> 'En-têtes de sécurité HTTP',
	'EnableSecurityHeaders'		=> 'Activer Security Headers :',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk !',
	'Csp'						=> 'Content-Security-Policy (CSP) :',
	'CspInfo'					=> 'La configuration de CSP implique de décider quelles politiques vous voulez appliquer, puis de les configurer et d\'utiliser la politique Content-Security-Policy pour établir votre politique.',
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
		'0'		=> '[désactivé]',
		'1'		=> 'sans référent',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'même origine',
		'4'		=> 'Origine',
		'5'		=> 'origine stricte',
		'6'		=> 'origine-quand-origine',
		'7'		=> 'origine-quand-origine',
		'8'		=> 'url non sécurisée'
	],

	'UserPasswordSection'		=> 'Persistance des mots de passe utilisateur',
	'PwdMinChars'				=> 'Longueur minimale du mot de passe :',
	'PwdMinCharsInfo'			=> 'Les mots de passe longs sont nécessairement plus sûrs que les mots de passe courts (par exemple 12 à 16 caractères).<br>L’utilisation de phrases de passe au lieu de mots de passe est encouragée.',
	'AdminPwdMinChars'			=> 'Longueur minimale du mot de passe admin :',
	'AdminPwdMinCharsInfo'		=> 'Les mots de passe longs sont nécessairement plus sûrs que les mots de passe courts (par exemple 12 à 16 caractères).<br>L’utilisation de phrases de passe au lieu de mots de passe est encouragée.',
	'PwdCharComplexity'			=> 'La complexité requise du mot de passe :',
	'PwdCharClasses'	=> [
		'0'		=> 'non testé',
		'1'		=> 'toutes les lettres + chiffres',
		'2'		=> 'majuscules et minuscules + chiffres',
		'3'		=> 'majuscules et minuscules + chiffres + caractères',
	],
	'PwdUnlikeLogin'			=> 'Complication supplémentaire :',
	'PwdUnlikes'	=> [
		'0'		=> 'non testé',
		'1'		=> 'le mot de passe n\'est pas identique à la connexion',
		'2'		=> 'le mot de passe ne contient pas de nom d\'utilisateur',
	],

	'LoginSection'				=> 'Connexion',
	'MaxLoginAttempts'			=> 'Nombre maximum de tentatives de connexion par nom d\'utilisateur :',
	'MaxLoginAttemptsInfo'		=> 'Le nombre de tentatives de connexion autorisées pour un seul compte avant le déclenchement de la tâche anti-spambot. Entrez 0 pour éviter que la tâche anti-spambot ne soit déclenchée pour des comptes utilisateurs distincts.',
	'IpLoginLimitMax'			=> 'Nombre maximum de tentatives de connexion par adresse IP :',
	'IpLoginLimitMaxInfo'		=> 'Le seuil de tentatives de connexion autorisé à partir d\'une seule adresse IP avant le déclenchement d\'une tâche anti-spambot. Entrez 0 pour éviter que la tâche anti-spambot ne soit déclenchée par des adresses IP.',

	'FormsSection'				=> 'Formulaires',
	'FormTokenTime'				=> 'Temps maximum pour soumettre les formulaires :',
	'FormTokenTimeInfo'			=> 'Le temps dont dispose un utilisateur pour soumettre un formulaire (en secondes).<br> Notez qu’un formulaire peut devenir invalide si la session expire, quel que soit ce paramètre.',

	'SessionLength'				=> 'Expiration du cookie de session :',
	'SessionLengthInfo'			=> 'La durée de vie du cookie de session utilisateur par défaut (en jours).',
	'CommentDelay'				=> 'Anti-inondation pour commentaires :',
	'CommentDelayInfo'			=> 'Le délai minimum entre la publication des nouveaux commentaires de l\'utilisateur (en secondes).',
	'IntercomDelay'				=> 'Anti-inondations pour les communications personnelles :',
	'IntercomDelayInfo'			=> 'Délai minimum entre l\'envoi de messages privés (en secondes).',
	'RegistrationDelay'			=> 'Seuil de temps pour l\'inscription :',
	'RegistrationDelayInfo'		=> 'Le délai minimum entre les soumissions de formulaires d\'inscription pour décourager les bots d\'inscription (en secondes).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Groupe de paramètres responsable de la plate-forme de réglage fin. Ne les changez pas à moins d’avoir confiance en leurs actions.',
	'FormatterSettingsUpdated'	=> 'Mise à jour des paramètres de formatage',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> 'Relecteur typographique :',
	'TypograficaInfo'			=> 'Désactiver cette option accélérera les processus d’ajout de commentaires et d’enregistrement des pages.',
	'Paragrafica'				=> 'Marquages de paragrafica :',
	'ParagraficaInfo'			=> 'Similaire à l\'option précédente, mais conduira à la déconnexion de la table de matières automatique inopérante (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Prise en charge globale du HTML :',
	'AllowRawhtmlInfo'			=> 'Cette option est potentiellement dangereuse pour un site ouvert.',
	'SafeHtml'					=> 'Filtrage HTML :',
	'SafeHtmlInfo'				=> 'Empêche l’enregistrement d’objets HTML dangereux. Désactiver le filtre sur un site ouvert avec support HTML est <span class="underline">extrêmement</span> indésirable !',

	'WackoFormatterSection'		=> 'Mise en forme de texte Wiki (Wacko Formatter)',
	'X11colors'					=> 'Utilisation des couleurs X11 :',
	'X11colorsInfo'				=> 'Étend les couleurs disponibles pour l\'arrière-plan <code>??(couleur) ??</code> et <code>!!(color) text!!</code>La désactivation de cette option accélère les processus d’ajout de commentaires et d’enregistrement des pages.',
	'WikiLinks'					=> 'Désactiver les Wikilinks :',
	'WikiLinksInfo'				=> 'Désactive les liens pour <code>CamelCaseWords</code>, vos CamelCase Words ne seront plus liés directement à une nouvelle page. Ceci est utile lorsque vous travaillez sur différents espaces de noms et clusters. Par défaut, il est désactivé.',
	'BracketsLinks'				=> 'Désactiver les liens entre parenthèses :',
	'BracketsLinksInfo'			=> 'Désactive <code>[[lien]]</code> et <code>((lien))</code> syntaxe.',
	'Formatters'				=> 'Désactiver les Formateurs :',
	'FormattersInfo'			=> 'Désactive la syntaxe <code>%%code%%</code> utilisée pour les surligneurs.',

	'DateFormatsSection'		=> 'Formats de date',
	'DateFormat'				=> 'Le format de la date :',
	'DateFormatInfo'			=> '(jour, mois, année)',
	'TimeFormat'				=> 'Le format de l\'heure :',
	'TimeFormatInfo'			=> '(heure, minute)',
	'TimeFormatSeconds'			=> 'Le format de l\'heure exacte :',
	'TimeFormatSecondsInfo'		=> '(heures, minutes, secondes)',
	'NameDateMacro'				=> 'Le format de la macro <code>::@::</code>:',
	'NameDateMacroInfo'			=> '(nom, heure), par exemple <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Fuseau horaire :',
	'TimezoneInfo'				=> 'Fuseau horaire à utiliser pour afficher les heures aux utilisateurs qui ne sont pas connectés (invités). Les utilisateurs connectés définissent et peuvent modifier leur fuseau horaire dans leurs paramètres d’utilisateur.',
	'AmericanDate'					=> 'Date américaine :',
	'AmericanDateInfo'				=> 'Utilise le format de date américain par défaut pour l\'anglais.',

	'Canonical'					=> 'Utiliser des URL canoniques :',
	'CanonicalInfo'				=> 'Tous les liens sont créés sous forme d’URL absolues sous la forme %1. Les URL relatives à la racine du serveur sous la forme %2 doivent être préférées.',
	'LinkTarget'				=> 'Où des liens externes s\'ouvrent :',
	'LinkTargetInfo'			=> 'Ouvre chaque lien externe dans une nouvelle fenêtre de navigateur. Ajoute <code>target="_blank"</code> à la syntaxe du lien.',
	'Noreferrer'				=> 'noreferrer :',
	'NoreferrerInfo'			=> 'Exige que le navigateur n’envoie pas d’en-tête de référence HTTP si l’utilisateur suit l’hyperlien. Ajoute <code>rel="noreferrer"</code> à la syntaxe du lien.',
	'Nofollow'					=> 'nofollow :',
	'NofollowInfo'				=> 'Indiquez à certains moteurs de recherche que l’hyperlien ne doit pas influencer le classement des liens ciblés dans l’index des moteurs de recherche. Ajoute <code>rel="nofollow"</code> à la syntaxe du lien.',
	'UrlsUnderscores'			=> 'Adresses du formulaire (URLs) avec des underscores :',
	'UrlsUnderscoresInfo'		=> 'Par exemple, %1 devient %2 avec cette option.',
	'ShowSpaces'				=> 'Insérer des espaces dans les NomWiki :',
	'ShowSpacesInfo'			=> 'Afficher les espaces dans WikiNames, par exemple <code>MyName</code> étant affiché comme <code>Mon nom</code> avec cette option.',
	'NumerateLinks'				=> 'Numérotation des liens en vue d’impression :',
	'NumerateLinksInfo'			=> 'Énumère et liste tous les liens en bas de la vue d\'impression avec cette option.',
	'YouareHereText'			=> 'Désactiver et visualiser les liens d\'auto-référencement :',
	'YouareHereTextInfo'		=> 'Visualisez les liens vers la même page, en utilisant <code>&lt;b&gt;####&lt;/b&gt;</code>. Tous les liens vers la mise en forme de lien se perdent eux-mêmes, mais sont affichés en texte gras.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Ici, vous pouvez définir ou modifier les pages de base du système utilisées dans le Wiki. N’oubliez pas de créer ou de modifier les pages correspondantes dans le Wiki en fonction des paramètres que vous avez définis ici.',
	'PagesSettingsUpdated'		=> 'Pages de base des paramètres mis à jour',

	'ListCount'					=> 'Nombre d\'éléments par liste :',
	'ListCountInfo'				=> 'Nombre d\'éléments affichés sur chaque liste pour les invités, ou comme valeur par défaut pour les nouveaux utilisateurs.',

	'ForumSection'				=> 'Options du forum',
	'ForumCluster'				=> 'Cluster Forum :',
	'ForumClusterInfo'			=> 'Instance racine pour la section du forum (action %1).',
	'ForumTopics'				=> 'Nombre de sujets par page :',
	'ForumTopicsInfo'			=> 'Nombre de sujets affichés sur chaque page de la liste dans les sections du forum (action %1).',
	'CommentsCount'				=> 'Nombre de commentaires par page :',
	'CommentsCountInfo'			=> 'Nombre de commentaires affichés sur chaque page de la liste des commentaires. Ceci s’applique à tous les commentaires du site, et pas seulement à ceux postés dans le forum.',

	'NewsSection'				=> 'Actualités de la section',
	'NewsCluster'				=> 'Cluster pour les actualités :',
	'NewsClusterInfo'			=> 'Grappe racine pour la section news (action %1).',
	'NewsStructure'				=> 'Structure de cluster d\'actualités :',
	'NewsStructureInfo'			=> 'Stocke les articles optionnellement dans les sous-groupes par année/mois ou par semaine (par exemple <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licence',
	'DefaultLicense'			=> 'Licence par défaut :',
	'DefaultLicenseInfo'		=> 'Sous quelle licence votre contenu peut être publié.',
	'EnableLicense'				=> 'Activer la licence :',
	'EnableLicenseInfo'			=> 'Activer pour afficher les informations de licence.',
	'LicensePerPage'			=> 'Licence par page :',
	'LicensePerPageInfo'		=> 'Autoriser la licence par page, que le propriétaire de la page peut choisir via les propriétés de la page.',

	'ServicePagesSection'		=> 'Pages de services',
	'RootPage'					=> 'Page d’accueil :',
	'RootPageInfo'				=> 'Tag de votre page principale, s\'ouvre automatiquement lorsqu\'un utilisateur visite votre site.',

	'PrivacyPage'				=> 'Politique de confidentialité :',
	'PrivacyPageInfo'			=> 'La page avec la Politique de confidentialité du site.',

	'TermsPage'					=> 'Politiques et réglementations :',
	'TermsPageInfo'				=> 'La page avec les règles du site.',

	'SearchPage'				=> 'Recherche :',
	'SearchPageInfo'			=> 'Page avec le formulaire de recherche (action %1).',
	'RegistrationPage'			=> 'Enregistrer sur notre site :',
	'RegistrationPageInfo'		=> 'Page pour l\'enregistrement d\'un nouvel utilisateur (action %1).',
	'LoginPage'					=> 'Connexion de l’utilisateur :',
	'LoginPageInfo'				=> 'Page de connexion sur le site (action %1).',
	'SettingsPage'				=> 'Réglages utilisateur :',
	'SettingsPageInfo'			=> 'Page pour personnaliser le profil utilisateur (action %1).',
	'PasswordPage'				=> 'Modifier le mot de passe :',
	'PasswordPageInfo'			=> 'Page avec un formulaire pour changer / interroger le mot de passe de l\'utilisateur (action %1).',
	'UsersPage'					=> 'Liste des utilisateurs :',
	'UsersPageInfo'				=> 'Page avec une liste des utilisateurs enregistrés (action %1).',
	'CategoryPage'				=> 'Catégorie :',
	'CategoryPageInfo'			=> 'Page avec une liste de pages catégorisées (action %1).',
	'GroupsPage'				=> 'Groupes :',
	'GroupsPageInfo'			=> 'Page avec une liste de groupes de travail (action %1).',
	'WhatsNewPage'				=> 'Quoi de neuf :',
	'WhatsNewPageInfo'			=> 'Page avec une liste de toutes les pages nouvelles, supprimées ou modifiées, les nouvelles pièces jointes et les commentaires. (action %1).',
	'ChangesPage'				=> 'Modifications récentes :',
	'ChangesPageInfo'			=> 'Page avec une liste des dernières pages modifiées (action %1).',
	'CommentsPage'				=> 'Commentaires récents :',
	'CommentsPageInfo'			=> 'Page avec une liste des commentaires récents sur la page (action %1).',
	'RemovalsPage'				=> 'Pages supprimées :',
	'RemovalsPageInfo'			=> 'Page avec une liste de pages récemment supprimées (action %1).',
	'WantedPage'				=> 'Pages désirées :',
	'WantedPageInfo'			=> 'Page avec une liste de pages manquantes qui sont référencées (action %1).',
	'OrphanedPage'				=> 'Pages orphelines :',
	'OrphanedPageInfo'			=> 'La page avec une liste de pages existantes n\'est liée à aucune autre page (action %1).',
	'SandboxPage'				=> 'Bac à sable :',
	'SandboxPageInfo'			=> 'Page où les utilisateurs peuvent pratiquer leurs compétences de marquage wiki.',
	'HelpPage'					=> 'Aide :',
	'HelpPageInfo'				=> 'La section de documentation pour travailler avec les outils du site.',
	'IndexPage'					=> 'Index :',
	'IndexPageInfo'				=> 'Page avec une liste de toutes les pages (action %1).',
	'RandomPage'				=> 'Au hasard :',
	'RandomPageInfo'			=> 'Charge une page aléatoire  (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Paramètres pour les notifications de la plate-forme.',
	'NotificationSettingsUpdated'	=> 'Paramètres de notification mis à jour',

	'EmailNotification'			=> 'Notification par courriel :',
	'EmailNotificationInfo'		=> 'Autoriser la notification par e-mail. Réglé sur ON pour activer les notifications par e-mail, OFF pour les désactiver. Notez que la désactivation des notifications par e-mail n’a aucun effet sur les e-mails générés dans le cadre du processus d’inscription de l’utilisateur.',
	'Autosubscribe'				=> 'Auto-abonnement :',
	'AutosubscribeInfo'			=> 'Informer automatiquement le propriétaire des modifications apportées à la page.',

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
	'PageStatsSynched'			=> 'Statistiques de page synchronisées.',
	'FeedsUpdated'				=> 'Flux RSS mis à jour.',
	'SiteMapCreated'			=> 'La nouvelle version du plan du site a été créée avec succès.',
	'ParseNextBatch'			=> 'Analyser le prochain lot de pages :',
	'WikiLinksRestored'			=> 'Liens Wiki restaurés.',

	'LogUserStatsSynched'		=> 'Statistiques utilisateur synchronisées',
	'LogPageStatsSynched'		=> 'Statistiques de page synchronisées',
	'LogFeedsUpdated'			=> 'Flux RSS synchronisés',
	'LogPageBodySynched'		=> 'Corps et liens de la page récupérés',

	'UserStats'					=> 'Statistiques utilisateur',
	'UserStatsInfo'				=> 'Les statistiques des utilisateurs (nombre de commentaires, pages possédées, révisions et fichiers) peuvent différer dans certaines situations de données réelles. <br>Cette opération permet de mettre à jour les statistiques pour correspondre aux données réelles contenues dans la base de données.',
	'PageStats'					=> 'Statistiques des pages',
	'PageStatsInfo'				=> 'Les statistiques des pages (nombre de commentaires, fichiers et révisions) peuvent différer dans certaines situations de données réelles. <br>Cette opération permet de mettre à jour les statistiques pour correspondre aux données réelles contenues dans la base de données.',

	'AttachmentsInfo'			=> 'Met à jour le hachage du fichier pour toutes les pièces jointes de la base de données.',
	'AttachmentsSynched'		=> 'Remise à jour de toutes les pièces jointes',
	'LogAttachmentsSynched'		=> 'Remise à jour de toutes les pièces jointes',

	'Feeds'						=> 'Flux',
	'FeedsInfo'					=> 'Dans le cas de l\'édition directe des pages dans la base de données, le contenu des flux RSS peut ne pas refléter les modifications apportées. <br>Cette fonction synchronise les RSS-channels avec l\'état actuel de la base de données.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'Cette fonction synchronise le plan du site XML avec l’état actuel de la base de données.',
	'XmlSiteMapPeriod'			=> 'Période %1 jours. Dernière écriture %2.',
	'XmlSiteMapView'			=> 'Afficher le plan du site dans une nouvelle fenêtre.',

	'ReparseBody'				=> 'Analyser toutes les pages',
	'ReparseBodyInfo'			=> 'Vide <code>body_r</code> dans la table de pages, afin que chaque page soit à nouveau affichée dans la vue de la page suivante. Cela peut être utile si vous avez modifié le formateur ou modifié le domaine de votre wiki.',
	'PreparsedBodyPurged'		=> 'Champ <code>body_r</code> vidé dans la table de page.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Effectue un re-rendu pour tous les liens intrasites et restaure le contenu des tables <code>page_link</code> et <code>file_link</code> en cas d\'endommagement ou de déplacement (cela peut prendre un temps considérable).',
	'RecompilePage'				=> 'Recompiler toutes les pages (extrêmement cher)',
	'ResyncOptions'				=> 'Options additionelles',
	'RecompilePageLimit'		=> 'Nombre de pages à analyser en même temps.',

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
	'SmtpAutoTls'				=> 'TLS opportuniste :',
	'SmtpAutoTlsInfo'			=> 'Active le chiffrement automatiquement, s\'il voit que le serveur fait de la publicité pour le cryptage TLS (après vous être connecté au serveur), même si vous n\'avez pas défini le mode de connexion pour <code>SMTPSecure</code>.',
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
	'TranslitFileName'			=> 'Translittérer les noms de fichiers :',
	'TranslitFileNameInfo'		=> 'Si elle est applicable et qu’il n’est pas nécessaire d’avoir des caractères Unicode, il est fortement recommandé de n’accepter que des caractères alphanumériques.',
	'TranslitCaseFolding'		=> 'Convertir les noms de fichiers en minuscules :',
	'TranslitCaseFoldingInfo'	=> 'Cette option n’est efficace qu’en cas de translittération active.',

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
	'LogMassemail'				=> 'Envoyer un email de masse %1 au groupe / utilisateur ',
	'MassemailSend'				=> 'Envoi de courriel en masse',

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
	'SysMsgAudience'			=> 'Audience :',
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
	'LogUserPasswordReset'		=> 'Mot de passe pour l\'utilisateur ##%1## réinitialisé avec succès',

	'UserApproveInfo'			=> 'Approuver les nouveaux utilisateurs avant qu’ils ne puissent se connecter au site.',
	'Approve'					=> 'Approuver',
	'Deny'						=> 'Refuser',
	'Pending'					=> 'En attente',
	'Approved'					=> 'Approuvé',
	'Denied'					=> 'Refusé',

	// DB Backup module
	'BackupStructure'			=> 'Structure',
	'BackupData'				=> 'Donnée',
	'BackupFolder'				=> 'Répertoire',
	'BackupTable'				=> 'Tableau',
	'BackupCluster'				=> 'Grappe :',
	'BackupFiles'				=> 'Fichiers',
	'BackupNote'				=> 'Note :',
	'BackupSettings'			=> 'Spécifiez le schéma de sauvegarde souhaité.<br>' .
    	'La instance racine n\'affecte pas la sauvegarde des fichiers globaux et la sauvegarde des fichiers de cache (si choisi, ils sont toujours sauvegardés en intégralité).<br>' .  '<br>' .
		'<strong>Attention</strong>: Pour éviter la perte d\'informations de la base de données lors de la spécification de la grappe racine, les tables de cette sauvegarde ne seront pas restructurées, comme lors de la sauvegarde de la structure de la table sans enregistrer les données. Pour effectuer une conversion complète des tables au format de sauvegarde, vous devez faire la sauvegarde complète de la base de données <em> (structure et données) sans spécifier la grappe</em>.',
	'BackupCompleted'			=> 'Sauvegarde et archivage terminés.<br>' .
    	'Les fichiers du package de sauvegarde ont été stockés dans le sous-répertoire %1.<br>Pour le télécharger, utilisez FTP (maintenez la structure du répertoire et les noms de fichiers lors de la copie).<br> Pour restaurer une copie de sauvegarde ou supprimer un paquet, allez dans <a href="%2">Restaurer la base de données</a>.',
	'LogSavedBackup'			=> 'Base de données de sauvegarde enregistrée ##%1##',
	'Backup'					=> 'Sauvegarde',
	'CantReadFile'				=> 'Impossible de lire le fichier %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Vous pouvez restaurer n’importe lequel des paquets de sauvegarde trouvés ou le supprimer du serveur.',
	'ConfirmDbRestore'			=> 'Voulez-vous restaurer la sauvegarde %1 ?',
	'ConfirmDbRestoreInfo'		=> 'Veuillez patienter quelques minutes.',
	'RestoreWrongVersion'		=> 'Mauvaise version WackoWiki !',
	'DirectoryNotExecutable'	=> 'Le répertoire %1 n’est pas exécutable.',
	'BackupDelete'				=> 'Êtes-vous sûr de vouloir supprimer %1 de sauvegarde ?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Autres options de restauration :',
	'RestoreOptionsInfo'		=> '* Avant de restaurer la sauvegarde <strong>cluster</strong>, ' .
									'les tables cibles ne sont pas supprimées (pour éviter la perte d\'informations des grappes qui n\'ont pas été sauvegardées). ' .
									'Ainsi, pendant le processus de récupération, des doublons d\'enregistrements se produiront. ' .
									'En mode normal, tous seront remplacés par les enregistrements de sauvegarde (en utilisant SQL <code>REPLACE</code>), ' .
									'mais si cette case à cocher est cochée, tous les doublons sont ignorés (les valeurs actuelles des enregistrements seront conservées), ' .
									'et seuls les enregistrements avec de nouvelles clés sont ajoutés à la table (SQL <code>INSERT IGNORE</code>).<br>' .
									'<strong>Avis</strong>: Lors de la restauration d\'une sauvegarde complète du site, cette option n\'a aucune valeur.<br>' .
									'<br>' .
									'** Si la sauvegarde contient les fichiers de l\'utilisateur (global et perpage, fichiers de cache, etc.), ' .
									'en mode normal, ils remplacent les fichiers existants par les mêmes noms et sont placés dans le même répertoire lors de la restauration. ' .
									'Cette option vous permet de sauvegarder les copies actuelles des fichiers et de les restaurer uniquement à partir d\'une sauvegarde (manquant sur le serveur).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignorer les clés de table dupliquées (pas de remplacement)',
	'IgnoreSameFiles'			=> 'Ignorer les mêmes fichiers (pas écraser)',
	'NoBackupsAvailable'		=> 'Aucune sauvegarde n’est disponible.',
	'BackupEntireSite'			=> 'Tout le site',
	'BackupRestored'			=> 'La sauvegarde est restaurée, un rapport sommaire est joint ci-dessous. Pour supprimer ce package de sauvegarde, cliquez sur',
	'BackupRemoved'				=> 'La sauvegarde sélectionnée a été supprimée avec succès.',
	'LogRemovedBackup'			=> 'Sauvegarde de la base de données supprimée ##%1##',

	'DbEngineInvalid'			=> 'Moteur de base de données non valide, attend %1',
	'RestoreStarted'			=> 'Restauration lancée',
	'RestoreParameters'			=> 'Utiliser les paramètres',
	'IgnoreDuplicatedKeys'		=> 'Ignorer les clés dupliquées',
	'IgnoreDuplicatedFiles'		=> 'Ignorer les fichiers en double',
	'SavedCluster'				=> 'Grappe enregistrée',
	'DataProtection'			=> 'Protection des données - %1 omis',
	'AssumeDropTable'			=> 'Supposer %1',
	'RestoreSQLiteDatabase'		=> 'Restauration de la base de données SQLite',
	'SQLiteDatabaseRestored'	=> 'La base de données a été restaurée avec succès:',
	'RestoreTableStructure'		=> 'Restauration de la structure de la table',
	'RunSqlQueries'				=> 'Exécuter les instructions SQL :',
	'CompletedSqlQueries'		=> 'Terminé. Instructions traitées :',
	'NoTableStructure'			=> 'La structure des tables n\'a pas été sauvegardée - sauter',
	'RestoreRecords'			=> 'Restaurer le contenu des tables',
	'ProcessTablesDump'			=> 'Il suffit de télécharger et de traiter les dumps de table',
	'Instruction'				=> 'Instructions',
	'RestoredRecords'			=> 'records :',
	'RecordsRestoreDone'		=> 'Completed. Total entries :',
	'SkippedRecords'			=> 'Données non enregistrées - ignorer',
	'RestoringFiles'			=> 'Restauration des fichiers',
	'DecompressAndStore'		=> 'Décompresser et stocker le contenu des répertoires',
	'HomonymicFiles'			=> 'fichiers homonymiques',
	'RestoreSkip'				=> 'sauter',
	'RestoreReplace'			=> 'remplacer',
	'RestoreFile'				=> 'Fichier :',
	'RestoredFiles'				=> 'restauré :',
	'SkippedFiles'				=> 'ignoré :',
	'FileRestoreDone'			=> 'Terminé. Nombre total de fichiers :',
	'FilesAll'					=> 'tous :',
	'SkipFiles'					=> 'Les fichiers ne sont pas stockés - sauter',
	'RestoreDone'				=> 'RESTORATION TERMINÉE',

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
	'UsersInfo'					=> 'Ici, vous pouvez modifier les informations de vos utilisateurs et certaines options spécifiques.',

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
	'LogMemberAdded'			=> 'Ajout d\'un membre ##%1## au groupe ##%2##',
	'LogMemberRemoved'			=> 'Membre supprimé ##%1## du groupe ##%2##',
	'LogGroupCreated'			=> 'Création d’un nouveau groupe ##%1##',
	'LogGroupRenamed'			=> 'Groupe ##%1## renommé en ##%2##',
	'LogGroupRemoved'			=> 'Groupe supprimé ##%1##',

	'GroupsMembersFor'			=> 'Membres du groupe',
	'GroupsDescription'			=> 'Libellé',
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
	'MembersAdded'				=> 'Nouveau membre ajouté au groupe avec succès.',
	'MembersRemove'				=> 'Êtes-vous sûr de vouloir ôter le membre %1 ?',
	'MembersRemoved'			=> 'Le membre a été ôté du groupe.',

	// Statistics module
	'DbStatSection'				=> 'Statistiques de la base de données',
	'DbTable'					=> 'Tableau',
	'DbRecords'					=> 'Enregistrements',
	'DbSize'					=> 'Taille',
	'DbIndex'					=> 'Index',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'Statistiques du système de fichiers',
	'FileFolder'				=> 'Répertoire',
	'FileFiles'					=> 'Fichiers',
	'FileSize'					=> 'Taille',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Version informations :',
	'SysParameter'				=> 'Paramètre',
	'SysValues'					=> 'Valeurs',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Dernière mise à jour',
	'ServerOS'					=> 'Système d\'exploitation',
	'ServerName'				=> 'Nom du serveur',
	'WebServer'					=> 'Serveur Web',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'Base de données',
	'SqlModesGlobal'			=> 'Modes SQL globaux',
	'SqlModesSession'			=> 'Session en mode SQL',
	'IcuVersion'				=> 'Unité de soins intensifs',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Mémoire',
	'UploadFilesizeMax'			=> 'Charger la taille maximale du fichier',
	'PostMaxSize'				=> 'Taille maximale de la publication',
	'MaxExecutionTime'			=> 'Temps maximum d\'exécution',
	'SessionPath'				=> 'Chemin de session',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'Compression GZip',
	'PhpExtensions'				=> 'Extensions PHP',
	'ApacheModules'				=> 'Modules Apache',

	// DB repair module
	'DbRepairSection'			=> 'Réparer la base de données',
	'DbRepair'					=> 'Réparer la base de données',
	'DbRepairInfo'				=> 'Ce script peut rechercher automatiquement certains problèmes courants des bases de données et les réparer. La réparation peut prendre un certain temps, alors soyez patient.',

	'DbOptimizeRepairSection'	=> 'Réparer et optimiser la base de données',
	'DbOptimizeRepair'			=> 'Réparer et optimiser la base de données',
	'DbOptimizeRepairInfo'		=> 'Ce script peut également tenter d’optimiser la base de données. Cela améliore les performances dans certaines situations. La réparation et l’optimisation de la base de données peuvent prendre beaucoup de temps et la base de données sera verrouillée tout en l’optimisant.',

	'TableOk'					=> 'Le tableau %1 est correct.',
	'TableNotOk'				=> 'Le tableau %1 n’est pas correct. Il signale l’erreur suivante : %2. Ce script va tenter de réparer cette table…',
	'TableRepaired'				=> 'La table %1 a été réparée avec succès.',
	'TableRepairFailed'			=> 'N’a pas réussi à réparer la table %1. <br>Erreur : %2',
	'TableAlreadyOptimized'		=> 'Le tableau %1 est déjà optimisé.',
	'TableOptimized'			=> 'Optimisation réussie du tableau %1.',
	'TableOptimizeFailed'		=> 'N’a pas réussi à optimiser le tableau %1. <br>Erreur : %2',
	'TableNotRepaired'			=> 'Certains problèmes de base de données n’ont pas pu être réparés.',
	'RepairsComplete'			=> 'Réparations terminées',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Afficher et corriger les incohérences, supprimer ou assigner des enregistrements orphelins à un nouvel utilisateur/valeur.',
	'Inconsistencies'			=> 'Incohérences',
	'CheckDatabase'				=> 'Base de données',
	'CheckDatabaseInfo'			=> 'Vérifie les incohérences d’enregistrement dans la base de données.',
	'CheckFiles'				=> 'Fichiers',
	'CheckFilesInfo'			=> 'Vérifie les fichiers abandonnés, les fichiers qui n’ont plus de référence dans la table des fichiers.',
	'Records'					=> 'Enregistrements',
	'InconsistenciesNone'		=> 'Aucune incohérence dans les données trouvée.',
	'InconsistenciesDone'		=> 'Les incohérences dans les données ont été résolues.',
	'InconsistenciesRemoved'	=> 'Correction des incohérences',
	'Check'						=> 'Vérifier',
	'Solve'						=> 'Résoudre',

	// Bad Behaviour module
	'BbInfo'					=> 'Détecte et bloque les accès Web indésirables, refuse l’accès aux robots spammeurs automatisés <br>Pour plus d’informations, veuillez consulter la page d’accueil %1.',
	'BbEnable'					=> 'Activer Bad Behaviour :',
	'BbEnableInfo'				=> 'Tous les autres paramètres peuvent être modifiés dans le dossier de configuration %1.',
	'BbStats'					=> 'Bad Behaviour a bloqué %1 tentatives d’accès au cours des 7 derniers jours.',

	'BbSummary'					=> 'Résumé',
	'BbLog'						=> 'Journal',
	'BbSettings'				=> 'Réglages',
	'BbWhitelist'				=> 'Liste blanche',

	// --> Log
	'BbHits'					=> 'Coups',
	'BbRecordsFiltered'			=> 'Affichage des enregistrements %1 de %2 filtrés par',
	'BbStatus'					=> 'Statut',
	'BbBlocked'					=> 'Bloqué',
	'BbPermitted'				=> 'Autorisé',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Affichage de tous les enregistrements %1',
	'BbShow'					=> 'Afficher',
	'BbIpDateStatus'			=> 'IP/Date/Statut',
	'BbHeaders'					=> 'En-têtes',
	'BbEntity'					=> 'Entité',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Options enregistrées.',
	'BbWhitelistHint'			=> 'Une liste blanche inappropriée WILL vous expose à des pourriels, ou fait cesser tout fonctionnement de mauvais comportement! NE PAS WHITELISTER à moins que vous ne soyez 100 % CERTAINS que vous devriez.',
	'BbIpAddress'				=> 'Adresse IP',
	'BbIpAddressInfo'			=> 'Intervalle d\'adresses IP ou format CIDR à mettre en liste blanche (une par ligne)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'Fragments d\'URL commençant par le / après le nom d\'hôte de votre site web (un par ligne)',
	'BbUserAgent'				=> 'Agent Utilisateur',
	'BbUserAgentInfo'			=> 'Chaînes de caractères de l\'agent utilisateur à mettre en liste blanche (une par ligne)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Mauvais comportement mis à jour',
	'BbLogRequest'				=> 'Requête HTTP de journalisation',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (recommandé)',
	'BbLogOff'					=> 'Ne pas enregistrer (pas recommandé)',
	'BbSecurity'				=> 'Sécurité',
	'BbStrict'					=> 'Vérification stricte',
	'BbStrictInfo'				=> 'bloque plus de spam mais peut bloquer certaines personnes',
	'BbOffsiteForms'			=> 'Autoriser la publication de formulaires à partir d\'autres sites web',
	'BbOffsiteFormsInfo'		=> 'requis pour OpenID; augmente le spam reçu',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Pour utiliser les fonctionnalités du mauvais comportement http:BL vous devez avoir un %1',
	'BbHttpblKey'				=> 'http:BL clé d\'accès',
	'BbHttpblThreat'			=> 'Niveau de menace minimum (25 est recommandé)',
	'BbHttpblMaxage'			=> 'Âge maximum de données (30 est recommandé)',
	'BbReverseProxy'			=> 'Inverser le Proxy/Équilibreur de Charge',
	'BbReverseProxyInfo'		=> 'Si vous utilisez un mauvais comportement derrière un proxy inverse, l\'équilibreur de charge, l\'accélérateur HTTP, le cache de contenu ou une technologie similaire, activez l\'option Reverse Proxy.<br>' .
									'Si vous avez une chaîne de deux ou plusieurs mandataires inversés entre votre serveur et l\'Internet public, vous devez spécifier <em>tous les</em> des plages d\'adresses IP (au format CIDR) de tous vos serveurs proxy, répartiteurs de charge, etc. Sinon, le mauvais comportement peut être incapable de déterminer l\'adresse IP réelle du client.<br>' .
									'De plus, vos serveurs mandataires inversés doivent définir l\'adresse IP du client Internet d\'où ils ont reçu la requête dans un en-tête HTTP. Si vous ne spécifiez pas d\'en-tête, %1 sera utilisé. La plupart des serveurs proxy prennent déjà en charge X-Forwarded-For et vous aurez alors seulement besoin de vous assurer qu\'il est activé sur vos serveurs proxy. D\'autres noms d\'en-têtes sont %2 et %3.',
	'BbReverseProxyEnable'		=> 'Activer le proxy inversé',
	'BbReverseProxyHeader'		=> 'En-tête contenant l\'adresse IP des clients Internet',
	'BbReverseProxyAddresses'	=> 'Adresses IP ou format CIDR pour vos serveurs proxy (une par ligne)',

];
