<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'fr',
'LangLocale'	=> 'fr_FR',
'LangName'		=> 'French',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
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
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',

	// time
	#'date_format'					=> 'dd.MM.yyyy',
	#'time_format'					=> 'HH:mm',
	#'time_format_seconds'			=> 'HH:mm:ss',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'Installation de WackoWiki',
'TitleUpdate'					=> 'Mise à jour de WackoWiki',
'Continue'						=> 'Continuer',
'Back'							=> 'Revenir en arrière',
'Recommended'					=> 'recommandée',
'InvalidAction'					=> 'Action non valide',

/*
   Language Selection Page
*/
'lang'							=> 'Configuration de la langue',
'PleaseUpgradeToR6'				=> 'Vous faites fonctionner une vieille version de WackoWiki (%1), antérieure à la %2. Pour la mettre à jour à la version actuelle, vous devez d’abord effectuer une mise à jour à la version %2.',
'UpgradeFromWacko'				=> 'Bienvenue à bord de WackoWiki, vous semblez passer de WackoWiki %1 à %2.  Les quelques pages qui suivent vous guideront dans le processus de mise à niveau.',
'FreshInstall'					=> 'Bienvenue à bord de WackoWiki, vous vous apprêtez à installer WackoWiki %1.  Les quelques pages qui suivent vous guideront dans le processus d’installation.',
'PleaseBackup'					=> 'Merci de sauvegarder votre base de données, le fichier de configuration et tous les fichiers modifiés, tels que ceux qui auxquels des rustines auraient été appliquées, avant de commencer le processus de mise à niveau. Cela peut vous éviter une bonne migraine.',
'LangDesc'						=> 'Merci de choisir une langue pour le processus d’installation. Ce sera aussi la langue par défaut de votre installation WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Exigences système',
'PhpVersion'					=> 'Version PHP',
'PhpDetected'					=> 'PHP détecté',
'ModRewrite'					=> 'Extension "mod_rewrite" du serveur Apache (Optionnelle)',
'ModRewriteInstalled'			=> 'L’extension "mod_rewrite" du serveur Apache est-elle installée ?',
'Database'						=> 'Base de données',
'PhpExtensions'					=> 'Extensions PHP',
'Permissions'					=> 'Changer les droits',
'ReadyToInstall'				=> 'Prêt à installer ?',
'Requirements'					=> 'Votre serveur doit satisfaire les exigences listées ci-dessous.',
'OK'							=> 'Ok',
'Problem'						=> 'Problème',
'Example'						=> 'Exemple',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Il semble manquer à votre installation de PHP installation les extensions indiqués requises par WackoWiki.',
'PcreWithoutUtf8'				=> 'PCRE n’est pas compilé avec le support UTF8',
'NotePermissions'				=> 'Cet installeur va tenter d’écrire les données de configuration dans le fichier %1, dans votre répertoire WackoWiki. Pour cela assurez-vous que le serveur http ait le droit d’écrire dans ce répertoire.  Sinon, vous devrez éditer ce fichier manuellement ; l’installeur vous indiquera comment faire.<br><br>Voir <a href="https://wackowiki.org/doc/Doc/Français/Installation" target="_blank">WackoWiki:Doc/Français/Installation</a> pour les détails.',
'ErrorPermissions'				=> 'L’installeur ne semble pas autorisé à attribuer des droits suffisants sur les fichiers pour que WackoWiki fonctionne correctement.  On vous demandera ultérieurement de le faire vous-même.',
'ErrorMinPhpVersion'			=> 'La version de PHP doit être supérieure à <strong>' . PHP_MIN_VERSION . '</strong> et votre serveur semble fonctionner avec une version antérieure.  Vous devez mettre à niveau PHP pour que WackoWiki fonctionne correctement.',
'Ready'							=> 'Félicitations, votre serveur semble capable de faire fonctionner WackoWiki.  Les quelques pages qui suivent vous guideront dans le processus de configuration.',

/*
   Site Config Page
*/
'config-site'					=> 'Configuration du site',
'SiteName'						=> 'Nom Wiki',
'SiteNameDesc'					=> 'Choisissez le nom de votre site Wiki.',
'SiteNameDefault'				=> 'MonWiki',
'HomePage'						=> 'Page d’accueil',
'HomePageDesc'					=> 'Choissez le nom de votre page d’accueil. Ce doit être un <a href="https://wackowiki.org/doc/Doc/Français/NomWiki" title="Voir l’aide" target="_blank">NomWiki</a>.',
'HomePageDefault'				=> 'Accueil',
'MultiLang'						=> 'Mode multilingue',
'MultiLangDesc'					=> 'Le mode multilingue permet d’avoir des pages avec plusieurs réglages de langue sur le même site. Si ce mode est choisi, l’installeur crée un jeu de éléments de menu de base dans chacune des langues incluses dans la distribution.',
'AllowedLang'					=> 'Langues autorisées',
'AllowedLangDesc'				=> 'Il est recommandé de sélectionner seulement le jeu de langues souhaité, sinon toutes les langues seront sélectionnées.',
'Admin'							=> 'Nom de l’administrateur',
'AdminDesc'						=> 'Indiquez le nom de l’administrateur, ce doit être un <a href="https://wackowiki.org/doc/Doc/Français/NomWiki" title="Voir l’aide" target="_blank">Nom Wiki</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Le nom d’utilisateur doit être compris entre %1 et %2 caractères de long et ne doit contenir que des caractères alphanumériques.',
'NameCamelCaseOnly'				=> 'Le nom d’utilisateur doit être compris entre %1 et %2 caractères de long et WikiName formatted.',
'Password'						=> 'Mot de passe de l’administrateur',
'PasswordDesc'					=> 'Choisissez un mot de passe d’au moins %1 caractères pour l’administrateur.',
'PasswordConfirm'				=> 'Répétez le mot de passe :',
'Mail'							=> 'Adresse de messagerie de l’administrateur',
'MailDesc'						=> 'Indiquez l’adresse de messagerie de l’administrateur.',
'Base'							=> 'URL de base',
'BaseDesc'						=> 'URL de base de votre site WackoWiki. Les noms de page lui sont accolés, aussi doit-il se terminer par une barre oblique si vous utilisez l’extension "mod_rewrite", exemples :<br><code>https://example.com/<br>https://example.com/wiki/</code><br>',
'Rewrite'						=> 'Mode "rewrite"',
'RewriteDesc'					=> 'L’extension "mod_rewrite" doit être activée pour utiliser WackoWiki avec la réécriture d’URL.',
'Enabled'						=> 'Activé ',
'ErrorAdminEmail'				=> 'Vous avez indiqué une adresse de messagerie non conforme !',
'ErrorAdminPasswordMismatch'	=> 'Les mots de passe ne coïncident pas !',
'ErrorAdminPasswordShort'		=> 'Le mot de passe de l’administrateur est trop court, il doit avoir au moins %1 caractères !',
'ModRewriteStatusUnknown'		=> 'L’installeur ne peut pas confirmer que "mod_rewrite" soit activé, il est cependant possible qu’il le soit.',

/*
   Database Config Page
*/
'config-database'				=> 'Configuration de la base de données',
'DbDriver'						=> 'Pilote',
'DbDriverDesc'					=> 'Choisissez le pilote de base de données que vous souhaitez utiliser.',
'DbSqlMode'						=> 'Mode SQL',
'DbSqlModeDesc'					=> 'Le mode SQL que vous voulez utiliser.',
'DbVendor'						=> 'Fournisseur',
'DbVendorDesc'					=> 'Le fournisseur de base de données que vous utilisez.',
'DbCharset'						=> 'Jeu de caractères',
'DbCharsetDesc'					=> 'Le jeu de caractères que vous voulez utiliser pour la base de données.',
'DbEngine'						=> 'Moteur',
'DbEngineDesc'					=> 'Le moteur de base de données que vous voulez utiliser.',
'DbHost'						=> 'Hôte',
'DbHostDesc'					=> 'Indiquez le nom de domaine de l’hôte sur lequel votre serveur de base de données fonctionne. Le cas échéant, votre hébergeur peut vous l’indiquer.',
'DbPort'						=> 'Numéro de port (optionnel)',
'DbPortDesc'					=> 'Le numéro de port à utiliser pour communiquer avec votre serveur de base de données. Laissez-le vide pour utiliser le numéro de port pas défaut.',
'DbName'						=> 'Nom de base de données',
'DbNameDesc'					=> 'Indiquez le nom de la base de données à utiliser par WackoWiki. Elle doit exister avant de continuer !',
'DbUser'						=> 'Nom d’utilisateur',
'DbUserDesc'					=> 'Indiquez le nom de l’utilisateur sous l’identité duquel se connecter à votre base de données.',
'DbPassword'					=> 'Mot de passe',
'DbPasswordDesc'				=> 'Indiquez le mot de passe de l’utilisateur sous l’identité duquel se connecter à votre base de données.',
'Prefix'						=> 'Préfixe des tables',
'PrefixDesc'					=> 'Choisissez le préfixe de toutes les tables utilisées par WackoWiki. Ceci vous permet de faire fonctionner plusieurs installations de WackoWiki utilisant la même base de données, en les configurant avec des préfixes distincts (par exemple wacko_).',
'ErrorNoDbDriverDetected'		=> 'Aucun pilote de base de données n’a été détecté, activez une des extensions mysqli ou pdo_mysql dans votre fichier "php.ini".',
'ErrorNoDbDriverSelected'		=> 'Aucun pilote de base de données n’a été sélectionné, choisissez-en un dans la liste.',
'DeleteTables'					=> 'Effacer les tables existantes ?',
'DeleteTablesDesc'				=> 'ATTENTION! Si vous poursuivez avec cette option, tout le contenu actuel du wiki sera effacé de la base de données. Il vous sera impossible de revenir en arrière, à moins que vous ne restauriez manuellement les données à partir d’une sauvegarde.',
'ConfirmTableDeletion'			=> 'Êtes-vous sûr de vouloir effacer toutes les données présentes dans les tables du Wiki ?',

/*
   Database Installation Page
*/
'install-database'				=> 'Installation de la base de données',
'TestingConfiguration'			=> 'Test de la configuration',
'TestConnectionString'			=> 'Test des paramètres de connexion à la base de données',
'TestDatabaseExists'			=> 'Vérification de l’existence de la base de donnée indiquée',
'TestDatabaseVersion'			=> 'Vérification de la version minimale requise de la base de données',
'InstallTables'					=> 'Installation des tables',
'ErrorDbConnection'				=> 'Les paramètres de connexion à la base de données que vous avez indiqués posent un problème, merci de revenir en arrière et de les vérifier.',
'ErrorDatabaseVersion'			=> 'La version de la base de données est %1 mais nécessite au moins %2.',
'To'							=> 'vers',
'AlterTable'					=> 'Modification de la table %1',
'InsertRecord'					=> 'Insertion de l\'enregistrement dans la table %1',
'RenameTable'					=> 'Renommage de la table %1',
'UpdateTable'					=> 'Mise à jour de la table %1',
'InstallDefaultData'			=> 'Ajout des données par défaut',
'InstallPagesBegin'				=> 'Ajout des pages par défaut',
'InstallPagesEnd'				=> 'Ajout des pages par défaut',
'InstallSystemAccount'			=> 'Ajout de l’utilisateur <code>System</code>',
'InstallDeletedAccount'			=> 'Ajout de l’utilisateur <code>Deleted</code>',
'InstallAdmin'					=> 'Ajout de l’utilisateur administrateur',
'InstallAdminSetting'			=> 'Réglages pour l’utilisateur administrateur',
'InstallAdminGroup'				=> 'Ajout du groupe « administrateurs »',
'InstallAdminGroupMember'		=> 'Ajout d’un membre du groupe « administrateurs »',
'InstallEverybodyGroup'			=> 'Ajout du groupe « tous »',
'InstallModeratorGroup'			=> 'Ajout du groupe « modérateurs »',
'InstallReviewerGroup'			=> 'Ajout du groupe « réviseurs »',
'InstallLogoImage'				=> 'Ajout du logo',
'LogoImage'						=> 'Image du logo',
'InstallConfigValues'			=> 'Ajout des paramètres de configuration',
'ConfigValues'					=> 'Valeurs de configuration',
'ErrorInsertPage'				=> 'Erreur dans l’insertion de la page %1',
'ErrorInsertPagePermission'		=> 'Erreur lors de l’attribution du droit la page %1',
'ErrorInsertDefaultMenuItem'	=> 'Erreur de paramétrage de la page %1 come élément de menu par défaut',
'ErrorPageAlreadyExists'		=> 'La page %1 existe déjà',
'ErrorAlterTable'				=> 'Erreur lors de la modification de la table %1',
'ErrorInsertRecord'				=> 'Erreur lors de l\'insertion de l\'enregistrement dans la table %1',
'ErrorRenameTable'				=> 'Erreur de renommage de la table %1 ',
'ErrorUpdatingTable'			=> 'Erreur lors de la mise à jour de la table %1',
'CreatingTable'					=> 'Création de la table %1',
'ErrorAlreadyExists'			=> ' Erreur, %1 existe déjà',
'ErrorCreatingTable'			=> 'Erreur lors de la création de la table %1, existe-telle déjà ?',
'DeletingTables'				=> 'Effacement des tables',
'DeletingTablesEnd'				=> 'Effacement des tables terminé',
'ErrorDeletingTable'			=> 'Erreur lors de l’effacement de la table %1, probablement parce que cette table n’existe pas, auquel cas vous pouvez ignorer cette alerte.',
'DeletingTable'					=> 'Effacement de la table %1',
'NextStep'						=> 'Au cours de la prochaine étape, l’installeur va tenter d’écrire le fichier de configuration mis à jour, %1.  Assurez-vous que le serveur ait le droit d’écrire ce fichier, sinon vous devrez l’éditer manuellement. Encore une fois, voyez <a href="https://wackowiki.org/doc/Doc/Français/Installation" target="_blank">WackoWiki:Doc/Français/Installation</a> pour les détails.',

/*
   Write Config Page
*/
'write-config'					=> 'Écriture du fichier de configuration',
'FinalStep'						=> 'Dernière étape',
'Writing'						=> 'Écriture du fichier de configuration',
'RemovingWritePrivilege'		=> 'Suppression du droit d’écrire',
'InstallationComplete'			=> 'Installation terminée',
'ThatsAll'						=> 'C’est tout ! Vous pouvez maintenant <a href="%1">accéder à votre site WackoWiki</a>.',
'SecurityConsiderations'		=> 'Considérations sur la sécurité',
'SecurityRisk'					=> 'Par sécurité, limitez maintenant le droit d’écrire le fichier %1 maintenant, par exemple %2.',
'RemoveSetupDirectory'			=> 'Par sécurité, supprimez maintenant le répertoire %1, devenu inutile.',
'ErrorGivePrivileges'			=> 'Le fichier de configuration %1 n’a pas pu être écrit par le serveur http dans votre répertoire WackoWiki.<br>Si possible, créez un fichier vide appelé  %1, sur lequel vous attribuerez à provisoirement à tous le droit d’écrire :<br>%2<br><br>Nota : après enregistrement vous supprimerez ce droit, i.e. <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Sinon, vous devrez copier le texte ci-dessous dans un fichier et le sauvegarder comme %1 dans le répertoire WackoWiki.<br>Ceci fait, votre site WackoWiki devrait fonctionner. Sinon, voyez  <a href="https://wackowiki.org/doc/Doc/Français/Installation" target="_blank">WackoWiki:Doc/Français/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Ceci fait, votre site WackoWiki devrait fonctionner. Sinon, voyez  <a href="https://wackowiki.org/doc/Doc/Français/MiseAJour" target="_blank">WackoWiki:Doc/Français/MiseAJour</a>',
'WrittenAt'						=> 'écrit à ',
'DontChange'					=> 'ne modifiez pas le paramètre « wacko_version » !',
'ConfigDescription'				=> 'pour une description détaillée de la configuration voir https://wackowiki.org/doc/Doc/Français/Configuration',
'TryAgain'						=> 'Essayez encore',

];
