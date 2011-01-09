<?php
$lang = array(

/*
   Language Settings
*/
'Charset' => 'iso-8859-1',
'LangISO' => 'fr',
'LangName' => 'French',

/*
   Generic Page Text
*/
'Title' => 'Installation de WackoWiki',
'Continue' => 'Continuer',
'Back' => 'Revenir en arrière',

/*
   Language Selection Page
*/
'UpgradeFromWacko' => 'Bienvenue à bord de WackoWiki, vous semblez passer de WackoWiki <tt>%1</tt> à <tt>%2</tt>.  Les quelques pages qui suivent vous guideront dans le processus de mise à niveau.',
'FreshInstall' => 'Bienvenue à bord de WackoWiki, vous vous apprêtez à installer WackoWiki <tt>%1</tt>.  Les quelques pages qui suivent vous guideront dans le processus d\'installation.',
'PleaseBackup' => 'Merci de sauvegarder votre base de données, le fichier de configuration et tous les fichiers modifiés, tels que ceux qui auxquels des rustines auraient été appliquées, avant de commencer le processus de mise à niveau. Cela peut vous éviter une bonne migraine.',
'Lang' => 'Configuration de la langue',
'LangDesc' => 'Merci de choisir une langue pour le processus d\'installation. Ce sera aussi la langue par défaut de votre installation WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'Exigences système',
'PHPVersion' => 'Version PHP',
'PHPDetected' => 'PHP détecté',
'ModRewrite' => 'Extension "mod_rewrite" du serveur Apache (Optionnelle)',
'ModRewriteInstalled' => 'L\'extension "mod_rewrite" du serveur Apache est-elle installée&nbsp;?',
'Database' => 'Base de données',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Prêt à installer&nbsp;?',
'Requirements' => 'Votre serveur doit satisfaire les exigences listées ci-dessous.',
'OK' => 'OK',
'Problem' => 'Problème',
'NotePermissions' => 'Cet installeur va tenter d\'écrire les données de configuration dans le fichier <tt>config.php</tt>, dans votre répertoire WackoWiki. Pour celà assurer-vous que le serveur http ait le droit d\'écrire dans ce répertoire.  Sinon, vous devrez éditer ce fichier manuellement&nbsp;; l\'installeur vous indiquera comment faire.<br /><br />Voir <a href="http://wackowiki.org/Doc/Francophone/InstallationEtMiseAJour" target="_blank">WackoWiki:Doc/Francophone/InstallationEtMiseAJour</a> pour les détails.',
'ErrorPermissions' => 'L\'installeur ne semble pas autorisé à attribuer des droits suffisants sur les fichiers pour que WackoWiki fonctionne correctement.  On vous demandera ultérieurement de le faire vous-même.',
'ErrorMinPHPVersion' => 'La version de PHP doit être supérieure à <strong>5.2.0</strong> et votre serveur semble fonctionner avec une version antérieure.  Vous devez mettre à niveau PHP pour que WackoWiki fonctionne correctement.',
'Ready' => 'Félicitations, votre serveur semble capable de faire fonctionner WackoWiki.  Les quelques pages qui suivent vous guideront dans le processus de configuration.',

/*
   Site Config Page
*/
'site-config' => 'Configuration du site',
'Name' => 'Nom WackoWiki',
'NameDesc' => 'Choisissez le nom de votre site WackoWiki, ce doit être un <a href="http://wackowiki.org/Doc/Francophone/NomWiki" title="Voir l\'aide" target="_blank">Nom Wiki</a>.',
'Home' => 'Page d\'accueil',
'HomeDesc' => 'Choissez le nom de votre page d\'accueil. Ce doit être un <a href="http://wackowiki.org/Doc/Francophone/NomWiki" title="Voir l\'aide" target="_blank">NomWiki</a>.',
'HomeDefault' => 'HomePage',
'MultiLang' => 'Mode multilingue',
'MultiLangDesc' => 'Le mode multilingue permet d\'avoir des pages avec plusieurs réglages de langue sur le même site. Si ce mode est choisi, l\'installeur crée un jeu de pages de base dans chacune des langues incluses dans la distribution.',
'Admin' => 'Nom de l\'administrateur',
'AdminDesc' => 'Indiquez le nom de l\'administrateur, ce doit être un <a href="http://wackowiki.org/Doc/Francophone/NomWiki" title="Voir l\'aide" target="_blank">Nom Wiki</a> (e.g. WikiAdmin).',
'Password' => 'Mot de passe de l\'administrateur',
'PasswordDesc' => 'Choisissez un mot de passe d\'au moins 8 caractères pour l\'administrateur.',
'Password2' => 'Répétez le mot de passe&nbsp;:',
'Mail' => 'Adresse de messagerie de l\'administrateur',
'MailDesc' => 'Indiquez l\'adresse de messagerie de l\'administrateur.',
'Base' => 'URL de base',
'BaseDesc' => 'URL de base de votre site WackoWiki. Les noms de page lui sont accolés, aussi doit-il se terminer par une barre oblique si vous utilisez l\'extension "mod_rewrite", exemples&nbsp;:<br/><tt>http://wackowiki.org/<br/>http://wackowiki.org/wiki/</tt><br/>',
'Rewrite' => 'Mode "rewrite"',
'RewriteDesc' => 'L\'extension "mod_rewrite" doit être activée pour utiliser WackoWiki avec la réécriture d\'URL.',
'Enabled' => 'Activé&nbsp;',
'ErrorAdminName' => 'Le nom d\'administrateur doit être un NomWiki&nbsp;!',
'ErrorAdminEmail' => 'Vous avez indiqué une adresse de messagerie non conforme&nbsp;!',
'ErrorAdminPasswordMismatch' => 'Les mots de passe ne coïncident pas&nbsp;!',
'ErrorAdminPasswordShort' => 'Le mot de passe de l\'administrateur est trop court, il doit avoir au moins 8 caractères&nbsp;!',
'WarningRewriteMode' => 'ATTENTION!\nVotre URL de base comporte un point d\'interrogation alors que l\'extension "mod_rewrite") est activée, ceci nous semble incohérent.\n\nPour confirmer néanmoins ce réglage cliquez sur OK.\nPour revenir au formulaire et changer vos réglages cliquez sur CANCEL.\n\nSi vous vous apprêtez à confirmer ces réglages, veuillez noter que cela pourrait rendre problématique votre installation de WackoWiki.',
'ModRewriteStatusUnknown' => 'L\'installeur ne peut pas confirmer que "mod_rewrite" soit activé, il est cependant possible qu\'il le soit.',

/*
   Database Config Page
*/
'database-config' => 'Configuration de la base de données',
'DBDriverDesc' => 'Choisissez le pilote de base de données que vous souhaitez utiliser. Pour utiliser un pilote PDO vous devez avoir PHP version 5.1 (ou supérieure) et <a href="http://fr.php.net/pdo" target="_blank">PDO</a> installés.',
'DBDriver' => 'Pilote',
'DBHost' => 'Hôte',
'DBHostDesc' => 'Indiquez le nom de domaine de l\'hôte sur lequel votre serveur de base de données fonctionne. Le cas échéant, votre hébergeur peut vous l\'indiquer.',
'DBPort' => 'Numéro de port (Optionnel)',
'DBPortDesc' => 'Le numéro de port à utiliser pour communiquer avec votre serveur de base de données. Laissez-le vide pour utiliser le numéro de port pas défaut.',
'DB' => 'Nom de base de données',
'DBDesc' => 'Indiquez le nom de la base de données à utiliser par WackoWiki. Elle doit exister avant de continuer&nbsp;!',
'DBUserDesc' => 'Indiquez le nom de l\'utilisateur sous l\'identité duquel se connecter à votre base de données.',
'DBUser' => 'Nom d\'utilisateur',
'DBPasswordDesc' => 'Indiquez le mot de passe de l\'utilisateur sous l\'identité duquel se connecter à votre base de données.',
'DBPassword' => 'Mot de passe',
'PrefixDesc' => 'Chosissez le préfixe de toutes les tables utilisées par WackoWiki. Ceci vous permet de faire fonctionner plusieurs installations de WackoWiki utilisant la même base de données, en les configurant avec des préfixes distincts (par exemple wacko_).',
'Prefix' => 'Préfixe des tables',
'ErrorNoDbDriverDetected' => 'Aucun pilote de base de données n\'a été détecté, activez une des extensions mysql, mysqli ou pdo dans votre fichier "php.ini".',
'ErrorNoDbDriverSelected' => 'Aucun pilote de base de données n\'a été sélectionné, choisissez-en un dans la liste.',
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! Si vous poursuivez avec cette option, tout le contenu actuel du wiki sera effacé de la base de données. Il vous sera impossible de revenir en arrière, à moins que vous ne restauriez manuellement les données à partir d\'une sauvegarde.',
'ConfirmTableDeletion' => 'Êtes-vous sûr de vouloir effacer toutes les données présentes dans les tables du Wiki ?',

/*
   Database Installation Page
*/
'database-install' => 'Installation de la base de données',
'TestingConfiguration' => 'Test de la configuration',
'TestConnectionString' => 'Test des paramètres de connexion à la base de données',
'TestDatabaseExists' => 'Vérification de l\'existence de la base de donnée indiquée',
'InstallingTables' => 'Installation des tables',
'ErrorDBConnection' => 'Les paramètres de connexion à la base de données que vous avez indiqués posent un problème, merci de revenir en arrière et de les vérifier.',
'ErrorDBExists' => 'La base de donnée indiquée n\'a pas été trouvée. Souvenez-vous qu\'elle doit exister avant d\'installer ou de mettre à niveau WackoWiki&nbsp!',
'To' => 'Vers',
'AlterTable' => 'Modification de la table <tt>%1</tt>',
'RenameTable' => 'Renaming <tt>%1</tt> Table',
'UpdateTable' => 'Updating <tt>%1</tt> Table',
'InstallingDefaultData' => 'Ajout des données par défaut',
'InstallingPagesBegin' => 'Ajout des pages par défaut',
'InstallingPagesEnd' => 'Ajout des pages par défaut',
'InstallingSystemAccount' => 'Adding System User',
'InstallingAdmin' => 'Ajout de l\'utilisateur administrateur',
'InstallingAdminSetting' => 'Ajout de l\'utilisateur administrateur',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingRegisteredGroup' => 'Adding Registered Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Ajout du logo',
'InstallingConfigValues' => 'Ajout des paramètres de configuration',
'ErrorInsertingPage' => 'Erreur dans l\'insertion de la page <tt>%1</tt>',
'ErrorInsertingPageReadPermission' => 'Erreur lors de l\'attribution du droit de lire la page <tt>%1</tt>',
'ErrorInsertingPageWritePermission' => 'Erreur lors de l\'attribution du droit d\'écrire la page <tt>%1</tt>',
'ErrorInsertingPageCommentPermission' => 'Erreur lors de l\'attribution du droit de commenter la page <tt>%1</tt>',
'ErrorInsertingDefaultBookmark' => 'Error setting page <tt>%1</tt> as default bookmark',
'ErrorPageAlreadyExists' => 'La page <tt>%1</tt> existe déjà',
'ErrorAlteringTable' => 'Erreur lors de la modification de la table <tt>%1</tt>',
'ErrorRenamingTable' => 'Error renaming <tt>%1</tt> table',
'ErrorUpdatingTable' => 'Erreur lors de la mise à jour de la table <tt>%1</tt> table',
'CreatingTable' => 'Création de la table <tt>%1</tt>',
'ErrorAlreadyExists' => ' Erreur, <tt>%1</tt> existe déjà',
'ErrorCreatingTable' => 'Erreur lors de la création de la table <tt>%1</tt>, existe-telle déjà&nbsp;?',
'ErrorMovingRevisions' => 'Erreur lors du déplacement des données concernant les révisions',
'MovingRevisions' => 'Déplacement des données concernées vers la table des révisions',
'DeletingTables' => 'Effacement des tables',
'DeletingTablesEnd' => 'Effacement des tables terminé',
'ErrorDeletingTable' => 'Erreur lors de l\'effacement de la table <tt>%1</tt>, probablement parce que cette table n\'existe pas, auquel cas vous pouvez ignorer cette alerte.',
'DeletingTable' => 'Effacement de la table <tt>%1</tt>',

/*
   Write Config Page
*/
'write-config' => 'Écriture du fichier de configuration',
'FinalStep' => 'Dernière étape',
'Writing' => 'Écriture du fichier de configuration',
'RemovingWritePrivilege' => 'Suppression du droit d\'écrire',
'InstallationComplete' => 'Installation terminée',
'ThatsAll' => 'C\'est tout&nbsp;! Vous pouvez maintenant <a href="%1">accéder à votre site WackoWiki</a>.',
'SecurityConsiderations' => 'Considérations sur la sécurité',
'SecurityRisk' => 'Par sécurité, limitez maintenant le droit d\'écrire le fichier <tt>config.php</tt> maintenant, par exemple <tt>chmod 644 config.php</tt>.',
'RemoveSetupDirectory' => 'Par sécurité, supprimez maintenant le répertoire "setup", devenu inutile.',
'ErrorGivePrivileges' => 'Le fichier de configuration <tt>%1</tt> n\'a pas pu être écrit par le serveur http dans votre répertoire WackoWiki.<br/>Si possible, créez un fichier vide appelé  <tt>config.php</tt>, sur lequel vous attribuerez à provisoirement à tous le droit d\'écrire&nbsp;:<br/><tt>touch config.php</tt><br/><tt>chmod 666 config.php</tt>.<br/>Nota&nbsp;: après enregistrement vous supprimerez ce droit, i.e. <tt>chmod 644 config.php</tt>).<br/> Sinon, vous devrez copier le texte ci-dessous dans un fichier et le sauvegarder comme <tt>config.php</tt> dans le répertoire WackoWiki.<br/>Ceci fait, votre site WackoWiki devrait fonctionner. Sinon, voyez  <a href="http://wackowiki.org/Doc/Francophone/InstallationEtMiseAJour">WackoWiki:Doc/Francophone/InstallationEtMiseAJour</a>',
'NextStep' => 'Au cours de la prochaine étape, l\'installeur va tenter d\'écrire le fichier de configuration mis à jour, <tt>config.php</tt>.  Assurez-vous que le serveur a le droit d\'écrire ce fichier, sinon vous devrez l\'éditer manuellement. Encore une fois, voyez <a href="http://wackowiki.org/Doc/Francophone/InstallationEtMiseAJour" target="_blank">WackoWiki:Doc/Francophone/InstallationEtMiseAJour</a> pour les détails.',
'WrittenAt' => 'écrit à ',
'DontChange' => 'ne modifiez pas wacko_version !',
'ConfigDescription' => 'pour une description détaillée de la configuration voir http://wackowiki.org/Doc/Francophone/Configuration',
'TryAgain' => 'Essayez encore',
'RemoveWakkaConfigFile' => 'WackoWiki utilise un fichier de configuration plus récent que celui de votre installation précédente de  WakkaWiki  L\'ancien fichier n\'a pu être automatiquement supprimé par le système, aussi vous êtes il recommandé d\'effacer vous-même le fichier <tt>wakka.config.php</tt>.',
'DeletingWakkaConfigFile' => 'Effacement du fichier de configuration Wakka obsomète',

);
?>
