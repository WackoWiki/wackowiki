<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'utf-8',
'LangISO' => 'fr',
'LangName' => 'French',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// site name
	'site_name'			=> 'MonSiteWiki',

	// pages
	'category_page'		=> 'Catégories',
	'groups_page'		=> 'Groupes',
	'users_page'		=> 'Utilisateurs',

	'search_page'		=> 'Recherche',
	'login_page'		=> 'Connexion',
	'account_page'		=> 'Préférences',
	'registration_page'	=> 'Enregistrement',
	'password_page'		=> 'MotDePasse',

	'changes_page'		=> 'Modifications',
	'comments_page'		=> 'Commentaires',
	'index_page'		=> 'Index',

	'random_page'		=> 'PageAuHasard',
	#'help_page'			=> 'Aide',
	#'terms_page'		=> 'Termes',
	#'privacy_page'		=> 'Confidentialité',

	// time
	#'date_format'					=> 'd.m.Y',
	#'time_format'					=> 'H:i',
	#'time_format_seconds'			=> 'H:i:s',
],

/*
   Generic Page Text
*/
'Title' => 'Installation de WackoWiki',
'Continue' => 'Continuer',
'Back' => 'Revenir en arrière',
'Recommended' => 'recommandée',
'InvalidAction' => 'Action non valide',

/*
   Language Selection Page
*/
'lang' => 'Configuration de la langue',
'PleaseUpgradeToR5' => 'Vous faites fonctionner une vieille version de WackoWiki, antérieure à la 5.0.0. Pour la mettre à jour à la version actuelle, vous devez d&rsquo;abord effectuer une mise à jour à la version <code class="version">5.0.x</code>.',
'UpgradeFromWacko' => 'Bienvenue à bord de WackoWiki, vous semblez passer de WackoWiki <code class="version">%1</code> à <code class="version">%2</code>.  Les quelques pages qui suivent vous guideront dans le processus de mise à niveau.',
'FreshInstall' => 'Bienvenue à bord de WackoWiki, vous vous apprêtez à installer WackoWiki <code class="version">%1</code>.  Les quelques pages qui suivent vous guideront dans le processus d&rsquo;installation.',
'PleaseBackup' => 'Merci de sauvegarder votre base de données, le fichier de configuration et tous les fichiers modifiés, tels que ceux qui auxquels des rustines auraient été appliquées, avant de commencer le processus de mise à niveau. Cela peut vous éviter une bonne migraine.',
'LangDesc' => 'Merci de choisir une langue pour le processus d&rsquo;installation. Ce sera aussi la langue par défaut de votre installation WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'Exigences système',
'PHPVersion' => 'Version PHP',
'PHPDetected' => 'PHP détecté',
'ModRewrite' => 'Extension "mod_rewrite" du serveur Apache (Optionnelle)',
'ModRewriteInstalled' => 'L&rsquo;extension "mod_rewrite" du serveur Apache est-elle installée ?',
'Database' => 'Base de données',
'PHPExtensions' => 'PHP Extensions',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Prêt à installer ?',
'Requirements' => 'Votre serveur doit satisfaire les exigences listées ci-dessous.',
'OK' => 'OK',
'Problem' => 'Problème',
'NotePHPExtensions' => '',
'ErrorPHPExtensions' => 'Il semble manquer à votre installation de PHP installation les extensions indiqués requises par WackoWiki.',
'PCREwithoutUTF8' => 'PCRE n&rsquo;est pas compilé avec le support UTF8',
'NotePermissions' => 'Cet installeur va tenter d&rsquo;écrire les données de configuration dans le fichier %1, dans votre répertoire WackoWiki. Pour cela assurez-vous que le serveur http ait le droit d&rsquo;écrire dans ce répertoire.  Sinon, vous devrez éditer ce fichier manuellement ; l&rsquo;installeur vous indiquera comment faire.<br><br>Voir <a href="https://wackowiki.org/doc/Doc/Francophone/InstallationEtMiseAJour" target="_blank">WackoWiki:Doc/Francophone/InstallationEtMiseAJour</a> pour les détails.',
'ErrorPermissions' => 'L&rsquo;installeur ne semble pas autorisé à attribuer des droits suffisants sur les fichiers pour que WackoWiki fonctionne correctement.  On vous demandera ultérieurement de le faire vous-même.',
'ErrorMinPHPVersion' => 'La version de PHP doit être supérieure à <strong>' . PHP_MIN_VERSION . '</strong> et votre serveur semble fonctionner avec une version antérieure.  Vous devez mettre à niveau PHP pour que WackoWiki fonctionne correctement.',
'Ready' => 'Félicitations, votre serveur semble capable de faire fonctionner WackoWiki.  Les quelques pages qui suivent vous guideront dans le processus de configuration.',

/*
   Site Config Page
*/
'site-config' => 'Configuration du site',
'SiteName' => 'Nom Wiki',
'SiteNameDesc' => 'Choisissez le nom de votre site Wiki.',
'HomePage' => 'Page d&rsquo;accueil',
'HomePageDesc' => 'Choissez le nom de votre page d&rsquo;accueil. Ce doit être un <a href="https://wackowiki.org/doc/Doc/Francophone/NomWiki" title="Voir l&rsquo;aide" target="_blank">NomWiki</a>.',
'HomePageDefault' => 'PagePrincipale',
'MultiLang' => 'Mode multilingue',
'MultiLangDesc' => 'Le mode multilingue permet d&rsquo;avoir des pages avec plusieurs réglages de langue sur le même site. Si ce mode est choisi, l&rsquo;installeur crée un jeu de pages de base dans chacune des langues incluses dans la distribution.',
'AllowedLang' => 'Langues autorisées',
'AllowedLangDesc' => 'Il est recommandé de sélectionner seulement le jeu de langues souhaité, sinon toutes les langues seront sélectionnées.',
'Admin' => 'Nom de l&rsquo;administrateur',
'AdminDesc' => 'Indiquez le nom de l&rsquo;administrateur, ce doit être un <a href="https://wackowiki.org/doc/Doc/Francophone/NomWiki" title="Voir l&rsquo;aide" target="_blank">Nom Wiki</a> (e.g. <code>WikiAdmin</code>).',
'Password' => 'Mot de passe de l&rsquo;administrateur',
'PasswordDesc' => 'Choisissez un mot de passe d&rsquo;au moins %1 caractères pour l&rsquo;administrateur.',
'Password2' => 'Répétez le mot de passe :',
'Mail' => 'Adresse de messagerie de l&rsquo;administrateur',
'MailDesc' => 'Indiquez l&rsquo;adresse de messagerie de l&rsquo;administrateur.',
'Base' => 'URL de base',
'BaseDesc' => 'URL de base de votre site WackoWiki. Les noms de page lui sont accolés, aussi doit-il se terminer par une barre oblique si vous utilisez l&rsquo;extension "mod_rewrite", exemples :<br><code>http://example.com/<br>http://example.com/wiki/</code><br>',
'Rewrite' => 'Mode "rewrite"',
'RewriteDesc' => 'L&rsquo;extension "mod_rewrite" doit être activée pour utiliser WackoWiki avec la réécriture d&rsquo;URL.',
'Enabled' => 'Activé ',
'ErrorAdminEmail' => 'Vous avez indiqué une adresse de messagerie non conforme !',
'ErrorAdminPasswordMismatch' => 'Les mots de passe ne coïncident pas !',
'ErrorAdminPasswordShort' => 'Le mot de passe de l&rsquo;administrateur est trop court, il doit avoir au moins %1 caractères !',
'WarningRewriteMode' => 'ATTENTION!\nVotre URL de base comporte un point d&rsquo;interrogation alors que l&rsquo;extension "mod_rewrite") est activée, ceci nous semble incohérent.\n\nPour confirmer néanmoins ce réglage cliquez sur OK.\nPour revenir au formulaire et changer vos réglages cliquez sur CANCEL.\n\nSi vous vous apprêtez à confirmer ces réglages, veuillez noter que cela pourrait rendre problématique votre installation de WackoWiki.',
'ModRewriteStatusUnknown' => 'L&rsquo;installeur ne peut pas confirmer que "mod_rewrite" soit activé, il est cependant possible qu&rsquo;il le soit.',

'LanguageArray'	=> [
	'bg' => 'Bulgare',
	'da' => 'Danois',
	'nl' => 'Néerlandais',
	'el' => 'Grec',
	'en' => 'Anglais',
	'et' => 'Estonien',
	'fr' => 'Français',
	'de' => 'Allemand',
	'hu' => 'Hongroise',
	'it' => 'Italien',
	'pl' => 'Polonais',
	'pt' => 'Portugais',
	'ru' => 'Russe',
	'es' => 'Espagnol',
],

/*
   Database Config Page
*/
'database-config' => 'Configuration de la base de données',
'DBDriver' => 'Pilote',
'DBDriverDesc' => 'Choisissez le pilote de base de données que vous souhaitez utiliser. Pour utiliser un pilote PDO vous devez avoir <a href="http://fr.php.net/pdo" target="_blank">PDO</a> installés.',
'DBCharset' => 'Jeu de caractères',
'DBCharsetDesc' => 'Le jeu de caractères que vous voulez utiliser pour la base de données.',
'DBEngine' => 'Moteur',
'DBEngineDesc' => 'Le moteur de base de données que vous voulez utiliser.',
'DBHost' => 'Hôte',
'DBHostDesc' => 'Indiquez le nom de domaine de l&rsquo;hôte sur lequel votre serveur de base de données fonctionne. Le cas échéant, votre hébergeur peut vous l&rsquo;indiquer.',
'DBPort' => 'Numéro de port (optionnel)',
'DBPortDesc' => 'Le numéro de port à utiliser pour communiquer avec votre serveur de base de données. Laissez-le vide pour utiliser le numéro de port pas défaut.',
'DB' => 'Nom de base de données',
'DBDesc' => 'Indiquez le nom de la base de données à utiliser par WackoWiki. Elle doit exister avant de continuer !',
'DBUserDesc' => 'Indiquez le nom de l&rsquo;utilisateur sous l&rsquo;identité duquel se connecter à votre base de données.',
'DBUser' => 'Nom d&rsquo;utilisateur',
'DBPasswordDesc' => 'Indiquez le mot de passe de l&rsquo;utilisateur sous l&rsquo;identité duquel se connecter à votre base de données.',
'DBPassword' => 'Mot de passe',
'PrefixDesc' => 'Choisissez le préfixe de toutes les tables utilisées par WackoWiki. Ceci vous permet de faire fonctionner plusieurs installations de WackoWiki utilisant la même base de données, en les configurant avec des préfixes distincts (par exemple wacko_).',
'Prefix' => 'Préfixe des tables',
'ErrorNoDbDriverDetected' => 'Aucun pilote de base de données n&rsquo;a été détecté, activez une des extensions mysql, mysqli ou pdo dans votre fichier "php.ini".',
'ErrorNoDbDriverSelected' => 'Aucun pilote de base de données n&rsquo;a été sélectionné, choisissez-en un dans la liste.',
'DeleteTables' => 'Effacer les tables existantes ?',
'DeleteTablesDesc' => 'ATTENTION! Si vous poursuivez avec cette option, tout le contenu actuel du wiki sera effacé de la base de données. Il vous sera impossible de revenir en arrière, à moins que vous ne restauriez manuellement les données à partir d&rsquo;une sauvegarde.',
'ConfirmTableDeletion' => 'Êtes-vous sûr de vouloir effacer toutes les données présentes dans les tables du Wiki ?',

/*
   Database Installation Page
*/
'database-install' => 'Installation de la base de données',
'TestingConfiguration' => 'Test de la configuration',
'TestConnectionString' => 'Test des paramètres de connexion à la base de données',
'TestDatabaseExists' => 'Vérification de l&rsquo;existence de la base de donnée indiquée',
'InstallingTables' => 'Installation des tables',
'ErrorDBConnection' => 'Les paramètres de connexion à la base de données que vous avez indiqués posent un problème, merci de revenir en arrière et de les vérifier.',
'ErrorDBExists' => 'La base de donnée indiquée n&rsquo;a pas été trouvée. Souvenez-vous qu&rsquo;elle doit exister avant d&rsquo;installer ou de mettre à niveau WackoWiki !',
'To' => 'Vers',
'AlterTable' => 'Modification de la table %1',
'InsertRecord' => 'Inserting Record into %1 table',
'RenameTable' => 'Renommage de la table %1',
'UpdateTable' => 'Mise à jour de la table %1',
'InstallingDefaultData' => 'Ajout des données par défaut',
'InstallingPagesBegin' => 'Ajout des pages par défaut',
'InstallingPagesEnd' => 'Ajout des pages par défaut',
'InstallingSystemAccount' => 'Ajout de l&rsquo;utilisateur <code>système</code>',
'InstallingDeletedAccount' => 'Ajout de l&rsquo;utilisateur <code>Deleted</code>',
'InstallingAdmin' => 'Ajout de l&rsquo;utilisateur administrateur',
'InstallingAdminSetting' => 'Réglages pour l&rsquo;utilisateur administrateur',
'InstallingAdminGroup' => 'Ajout du groupe « administrateurs »',
'InstallingAdminGroupMember' => 'Ajout d&rsquo;un membre du groupe « administrateurs »',
'InstallingEverybodyGroup' => 'Ajout du groupe « tous »',
'InstallingModeratorGroup' => 'Ajout du groupe « modérateurs »',
'InstallingReviewerGroup' => 'Ajout du groupe « réviseurs »',
'InstallingLogoImage' => 'Ajout du logo',
'LogoImage' => 'Logo image',
'InstallingConfigValues' => 'Ajout des paramètres de configuration',
'ConfigValues' => 'Config Values',
'ErrorInsertingPage' => 'Erreur dans l&rsquo;insertion de la page %1',
'ErrorInsertingPageReadPermission' => 'Erreur lors de l&rsquo;attribution du droit de lire la page %1',
'ErrorInsertingPageWritePermission' => 'Erreur lors de l&rsquo;attribution du droit d&rsquo;écrire la page %1',
'ErrorInsertingPageCommentPermission' => 'Erreur lors de l&rsquo;attribution du droit de commenter la page %1',
'ErrorInsertingPageCreatePermission' => 'Erreur lors du réglage des permissions de créer %1 page',
'ErrorInsertingPageUploadPermission' => 'Erreur lors du réglage des permissions de télé-déposer %1 page',
'ErrorInsertingDefaultMenuItem' => 'Erreur de paramétrage de la page %1 come élément de menu par défaut',
'ErrorPageAlreadyExists' => 'La page %1 existe déjà',
'ErrorAlteringTable' => 'Erreur lors de la modification de la table %1',
'ErrorInsertingRecord' => 'Error Inserting Record into %1 table',
'ErrorRenamingTable' => 'Erreur de renommage de la table %1 ',
'ErrorUpdatingTable' => 'Erreur lors de la mise à jour de la table %1',
'CreatingTable' => 'Création de la table %1',
'ErrorAlreadyExists' => ' Erreur, %1 existe déjà',
'ErrorCreatingTable' => 'Erreur lors de la création de la table %1, existe-telle déjà ?',
'ErrorMovingRevisions' => 'Erreur lors du déplacement des données concernant les révisions',
'MovingRevisions' => 'Déplacement des données concernées vers la table des révisions',
'DeletingTables' => 'Effacement des tables',
'DeletingTablesEnd' => 'Effacement des tables terminé',
'ErrorDeletingTable' => 'Erreur lors de l&rsquo;effacement de la table %1, probablement parce que cette table n&rsquo;existe pas, auquel cas vous pouvez ignorer cette alerte.',
'DeletingTable' => 'Effacement de la table %1',

/*
   Write Config Page
*/
'write-config' => 'Écriture du fichier de configuration',
'FinalStep' => 'Dernière étape',
'Writing' => 'Écriture du fichier de configuration',
'RemovingWritePrivilege' => 'Suppression du droit d&rsquo;écrire',
'InstallationComplete' => 'Installation terminée',
'ThatsAll' => 'C&rsquo;est tout ! Vous pouvez maintenant <a href="%1">accéder à votre site WackoWiki</a>.',
'SecurityConsiderations' => 'Considérations sur la sécurité',
'SecurityRisk' => 'Par sécurité, limitez maintenant le droit d&rsquo;écrire le fichier %1 maintenant, par exemple %2.',
'RemoveSetupDirectory' => 'Par sécurité, supprimez maintenant le répertoire %1, devenu inutile.',
'ErrorGivePrivileges' => 'Le fichier de configuration %1 n&rsquo;a pas pu être écrit par le serveur http dans votre répertoire WackoWiki.<br>Si possible, créez un fichier vide appelé  %1, sur lequel vous attribuerez à provisoirement à tous le droit d&rsquo;écrire :<br>%2<br>Nota : après enregistrement vous supprimerez ce droit, i.e. %3.<br> Sinon, vous devrez copier le texte ci-dessous dans un fichier et le sauvegarder comme %1 dans le répertoire WackoWiki.<br>Ceci fait, votre site WackoWiki devrait fonctionner. Sinon, voyez  <a href="https://wackowiki.org/doc/Doc/Francophone/InstallationEtMiseAJour" target="_blank">WackoWiki:Doc/Francophone/InstallationEtMiseAJour</a>',
'NextStep' => 'Au cours de la prochaine étape, l&rsquo;installeur va tenter d&rsquo;écrire le fichier de configuration mis à jour, %1.  Assurez-vous que le serveur ait le droit d&rsquo;écrire ce fichier, sinon vous devrez l&rsquo;éditer manuellement. Encore une fois, voyez <a href="https://wackowiki.org/doc/Doc/Francophone/InstallationEtMiseAJour" target="_blank">WackoWiki:Doc/Francophone/InstallationEtMiseAJour</a> pour les détails.',
'WrittenAt' => 'écrit à ',
'DontChange' => 'ne modifiez pas le paramètre « wacko_version » !',
'ConfigDescription' => 'pour une description détaillée de la configuration voir https://wackowiki.org/doc/Doc/Francophone/Configuration',
'TryAgain' => 'Essayez encore',

];
?>
