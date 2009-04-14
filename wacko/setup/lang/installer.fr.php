<?php
$lang = array(

/*
   Language Settings
*/
"Charset" => "iso-8859-1",
"LangISO" => "fr",
"LangName" => "French",

/*
   Generic Page Text
*/
"Title" => "Installation de WackoWiki",
"Continue" => "Continuer",
"Back" => "Revenir en arrière",

/*
   Language Selection Page
*/
"UpgradeFromWacko" => "Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <tt>%1</tt> to <tt>%2</tt>.  The next few pages will guide you through the upgrade process.",
"UpgradeFromWakka" => "Welcome to WackoWiki, it appears that you are upgrading from WakkaWiki <tt>%1</tt> to <tt>%2</tt>.  The next few pages will guide you through the upgrade process.",
"FreshInstall" => "Welcome to WackoWiki, you are about to install WackoWiki <tt>%1</tt>.  The next few pages will guide you through the installation process.",
"PleaseBackup" => "Merci de sauvegarder votre base de données, le fichier de configuration et tous les fichiers modifiés, tels que ceux qui auxquels des rustines auraient été appliquées, avant de commencer le processus de mise à jour. Cela peut vous éviter de forts maux de tête.",
"Lang" => "Configuration de la langue",
"LangDesc" => "Merci de choisir une langue pour le processus d'installation. Ce sera aussi la langue par défaut de votre installation WackoWiki.",

/*
   System Requirements Page
*/
"version-check" => "Exigences système",
"PHPVersion" => "Version PHP",
"PHPDetected" => "PHP détecté",
"ModRewrite" => "Extension \"mod_rewrite\" du serveur Apache (Optionnelle)",
"ModRewriteInstalled" => "L'extension \"mod_rewrite\" du serveur Apache est-elle installée&nbsp;?",
"Database" => "Base de données",
"Permissions" => "Permissions",
"ReadyToInstall" => "Prêt à installer&nbsp;?",
"Requirements" => "Votre serveur doit satisfaire les exigences listées ci-dessous.",
"OK" => "OK",
"Problem" => "Problème",
"NotePermissions" => "Cet installeur va tenter d'écrire les données de configuration dans le fichier <tt>config.inc.php</tt>, dans votre répertoire WackoWiki. Pour celà assurer-vous que le serveur http ait le droit d'écrire dans ce répertoire.  Sinon, vous devrez éditer ce fichier manuellement&nbsp;; l'installeur vous indiquera comment faire.<br /><br />Voir <a href=\"http://wackowiki.org/Doc/Francophone/InstallationEtMiseAJour\" target=\"_blank\">WackoWiki:Doc/Francophone/InstallationEtMiseAJour</a> pour les détails.",
"ErrorPermissions" => "L'installeur ne semble pas autorisé à attribuer les droits sur les fichiers de manière à ce que  WackoWiki fonctionne correctement.  On vous demandera ultérieurement d'effectuer vous-même de le faire vous-même.",
"ErrorMinPHPVersion" => "La version de PHP doit être supérieure à <strong>4.3.3</strong> et votre serveur semble fonctionner avec une version antérieure.  Vous devez mettre à niveau PHP pour que WackoWiki fonctionne correctement.",
"Ready" => "Félicitations, votre serveur semble capable de faire fonctionner WackoWiki.  Les quelques pages qui suivent vous guideront dans le processus de configuration.",

/*
   Site Config Page
*/
"site-config" => "Configuration du site",
"Name" => "Nom WackoWiki",
"NameDesc" => "Choisissez le nom de votre site WackoWiki, ce doit être un <a href=\"http://wackowiki.org/Doc/Francophone/NomWiki\" title=\"Voir l'aide\" target=\"_blank\">Nom Wiki</a>.",
"Home" => "Page d'accueil",
"HomeDesc" => "Choissez le nom de votre page d'accueil. Ce doit être un <a href=\"http://wackowiki.org/Doc/Francophone/NomWiki\" title=\"Voir l'aide\" target=\"_blank\">NomWiki</a>.",
"MultiLang" => "Mode multilingue",
"MultiLangDesc" => "Le mode multilingue permet d'avoir des pages avec plusieurs réglages de langue sur le même site. Si ce mode est choisi, l'installeur créee un jeu de pages de base dans chacune des langues incluses dans la distribution.",
"Admin" => "Nom de l'administrateur",
"AdminDesc" => "Indiquez le nom de l'administrateur, ce doit être un <a href=\"http://wackowiki.org/Doc/Francophone/NomWiki\" title=\"Voir l'aide\" target=\"_blank\">Nom Wiki</a>.",
"Password" => "Mot de passe de l'administrateur",
"PasswordDesc" => "Choisissez un mot de passe d'au moins 5 caractères pour l'administrateur.",
"Password2" => "Répétez le mot de passe&nbsp;:",
"Mail" => "Adresse de messagerie de l'administrateur",
"MailDesc" => "Indiquez l'adresse de messagerie de l'administrateur.",
"Base" => "URL de base",
"BaseDesc" => "URL de base de votre site WackoWiki. Les noms de page lui sont accolés, aussi doit-il se terminer par une barre oblique si vous utilisez l'extension \"mod_rewrite\", exemples&nbsp;:<br/><tt>http://www.wackowiki.org/<br/>http://www.wackowiki.org/wiki/</tt><br/><p class=\"no_top\">En revanche si vous n'utilisez pas  \"mod_rewrite\" l'URL doit se terminer par \"?page=\", exemples&nbsp;:<br/><tt>http://www.wackowiki.org/index.php?page=<br/>http://www.wackowiki.org/wiki/index.php?page=<br/>http://www.wackowiki.org/?page=<br/>http://www.wackowiki.org?page=</tt><br/>",
"Rewrite" => "Mode \"rewrite\"",
"RewriteDesc" => "L'extension \"mod_rewrite\" doit être activée pour utiliser WackoWiki avec la réécriture d'URL.",
"Enabled" => "Activé&nbsp;",
"ErrorAdminName" => "Le nom d'administrateur doit ête un NomWiki&nbsp;!",
"ErrorAdminEmail" => "Vous avez indiqué une adresse de messagerie non valide&nbsp;!",
"ErrorAdminPasswordMismatch" => "Les mots de passe ne coîncident pas&nbsp;!",
"ErrorAdminPasswordShort" => "Le mot de passe de l'administrateur est trop court, il doit avoir au moins 5 caractères&nbsp;!",
"WarningRewriteMode" => "ATTENTION!\nVotre URL de base comporte un point d'interrogation alors que l'extension \"mod_rewrite\") est activée, ceci nous semble incohérent.\n\nPour confirmer néanmoins ce réglage cliquez sur OK.\nPour revenir au formualire et changer vos réglages cliquez sur CANCEL.\n\nSi vous vous apprêtez à confirmer ces réglages, veuillez noter que cela pourrait causer des problèmes avec votre installation de WackoWiki.",
"ModRewriteStatusUnknown" => "L'installeur ne peut pas confirmer que \"mod_rewrite\" est activé, il est cependant possible qu'il le soit.",

/*
   Database Config Page
*/
"database-config" => "Configuration de la base de données",
"DBDriverDesc" => "Choisissez le pilote de base de données que vous souhaitez utiliser. Pour utiliser un pilote PDO vous devez avoir PHP version 5.1 (ou supérieure) et <a href=\"http://fr.php.net/pdo\" target=\"_blank\">PDO</a> installés.",
"DBDriver" => "Pilote",
"DBHost" => "Hôte",
"DBHostDesc" => "Indiquez le nom de domaine de l'hôte sur lequel votre serveur de base de données fonctionne. Le cas échéant, votre hébergeur peut vous l'indiquer.",
"DBPort" => "Numéro de port (Optionnel)",
"DBPortDesc" => "Le numéro de port à utiliser pour communiquer avec votre serveur de base de données. Laissez-le vide pour utiliser le numéro de port pas défaut.",
"DB" => "Nom de base de données",
"DBDesc" => "Indiquez le nom de la base de données à utiliser par WackoWiki. Elle doit exister avant de continuer&nbsp;!",
"DBUserDesc" => "Indiquez le nom de l'utilisateur sous l'identité duquel se connecter à votre base de données.",
"DBUser" => "Nom d'utilisateur",
"DBPasswordDesc" => "Indiquez le mot de passe de l'utilisateur sous l'identité duquel se connecter à votre base de données.",
"DBPassword" => "Mot de passe",
"PrefixDesc" => "Chosissez le préfixe de toutes les tables utilisées par WackoWiki. Ceci vous permet de faire fonctionner plusieurs installations de WackoWiki utilisant la même base de données, en les configurant avec des préfixes distincts.",
"Prefix" => "Préfixe des tables",
"ErrorNoDbDriverDetected" => "Aucun pilote de base de données n'a été détecté, activez une des extensions mysql, mysqli ou pdo dans votre fichier \"php.ini\".",
"ErrorNoDbDriverSelected" => "Aucun pilote de base de données n'a été sélectionné, choisissez-en un dans la liste.",
"DeleteTables" => "Delete Existing Tables?",
"DeleteTablesDesc" => "ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.",
"ConfirmTableDeletion" => "Are you sure you want to delete all current wiki tables?",

/*
   Database Installation Page
*/
"database-install" => "Installation de la base de données",
"TestingConfiguration" => "Test de la configuration",
"TestConnectionString" => "Test des paramètres de connexion à la base de données",
"TestDatabaseExists" => "Vérification de l'existence de la base de donnée indiquée",
"InstallingTables" => "Installation des tables",
"ErrorDBConnection" => "Les paramètres de connexion à la base de données que vous avez indiqués posent un problème, merci de revenir en arrère et de les vérifier.",
"ErrorDBExists" => "La base de donnée indiquée n'a pas été trouvée. Souvenez-vous qu'elle doit exister avant d'installer ou de mettre à niveau WackoWiki&nbsp!",
"To" => "Vers",
"AlterTable" => "Modification de la table <tt>%1</tt>",
"AlterUsersTable" => "Modification de la table des utilisateurs",
"InstallingDefaultData" => "Ajout des données par défaut",
"InstallingPagesBegin" => "Ajout des pages par défaut",
"InstallingPagesEnd" => "Ajout des pages par défaut",
"InstallingAdmin" => "Ajout de l'utilisateur administrateur",
"InstallingLogoImage" => "Ajout du logo",
"ErrorInsertingPage" => "Erreur dans l'insertion de la page <tt>%1</tt>",
"ErrorInsertingPageReadPermission" => "Erreur lors de l'attribution du droit de lire la page <tt>%1</tt>",
"ErrorInsertingPageWritePermission" => "Erreur lors de l'attribution du droit d'écrire la page <tt>%1</tt>",
"ErrorInsertingPageCommentPermission" => "Erreur lors de l'attribution du droit de commenter la page <tt>%1</tt>",
"ErrorPageAlreadyExists" => "La page <tt>%1</tt> existe déjà",
"ErrorAlteringTable" => "Erreur lors de la modification de la page <tt>%1</tt>",
"CreatingTable" => "Création de la page <tt>%1</tt>",
"ErrorAlreadyExists" => " Erreur, <tt>%1</tt> existe déjà",
"ErrorCreatingTable" => "Erreur lors de la création de la table <tt>%1</tt>, existe-telle déjà&nbsp;?",
"ErrorMovingRevisions" => "Erreur lors du déplacement des données concernant les révisions",
"MovingRevisions" => "Déplacement des données concernées vers la table des révisions",
"CleanupScript" => "Si vous utilisez <a href=\"http://wackowiki.org/Doc/English/CleanupScript\" target=\"_blank\">WackoWiki:Doc/English/CleanupScript</a>, vous accélérerez votre WackoWiki.",
"DeletingTables" => "Deleting Tables",
"DeletingTablesEnd" => "Finished Deleting Tables",
"ErrorDeletingTable" => "Error deleting <tt>%1</tt> table, the most likely reason is that the table does not exist in which case you can ignore this warning.",
"DeletingTable" => "Deleting <tt>%1</tt> table",

/*
   Write Config Page
*/
"write-config" => "Ecriture du fichier de configuration",
"FinalStep" => "Final Step",
"FinalSteps" => "Final Steps",
"Writing" => "Ecriture du fichier de configuration",
"RemovingWritePrivilege" => "Suppression du droits d'écrire",
"InstallationComplete" => "Installation terminée",
"ThatsAll" => "C'est tout&nbsp;! Vous pouvez maintenenant <a href=\"%1\">accéder à votre site WackoWiki</a>.",
"SecurityConsiderations" => "Considérations sur la sécurité",
"SecurityRisk" => "Par sécurité, limitez maintenant le droit d'écrire le fichier <tt>config.inc.php</tt> maintenant, par exemple <tt>chmod 644 config.inc.php</tt>.",
"RemoveSetupDirectory" => "Par sécurité, supprimez maintenant le répertoire \"setup\", devenu inutile.",
"ErrorGivePrivileges" => "Le fichier de configuration <tt>%1</tt> n'a pas pu être écrit par le serveur http dans votre répertoire WackoWiki.<br/>Si possible, créez un fichier vide appelé  <tt>config.inc.php</tt>, sur lequel vous attribuerez à provisoirement à tous le droit d'écrire&nbsp;:<br/><tt>touch config.inc.php</tt><br/><tt>chmod 666 config.inc.php</tt>.<br/>Nota&nbsp;: après enregistrement vous supprimerez ce droit, i.e. <tt>chmod 644 config.inc.php</tt>).<br/> Sinon, vous devrez copier le texte ci-dessous dans un fichier et le sauvegarder comme <tt>config.inc.php</tt> dans le répertoire WackoWiki.<br/>Ceci fait, votre site WackoWiki devrait fontionner. Sinon, voyez  <a href=\"http://wackowiki.org/Doc/Francophone/InstallationEtMiseAJour\">WackoWiki:Doc/Francophone/InstallationEtMiseAJour</a>",
"NextStep" => "Dans la prochaine étape, l'installeur va tenter d'écrire le fichier de configuration mis à jour, <tt>config.inc.php</tt>.  Assurez-vous que le serveur a le droit d'écrire ce fichier, sinon vous devrez l'éditer manuellement. Encore une fois, voyez <a href=\"http://wackowiki.org/Doc/Francophone/InstallationEtMiseAJour\" target=\"_blank\">WackoWiki:Doc/Francophone/InstallationEtMiseAJour</a> pour les détails.",
"WrittenAt" => "écrit à ",
"DontChange" => "ne modifiez pas wakka_version !",
"ConfigDescription" => "detailed description http://wackowiki.org/Doc/Francophone/Configuration",
"TryAgain" => "Essayez encore",
"RemoveWakkaConfigFile" => "WackoWiki uses a newer config file than your previous WakkaWiki installation.  The old file could not be automatically removed by the system and so it is recommended that you manually delete the file <tt>wakka.config.php</tt>.",
"DeletingWakkaConfigFile" => "Deleting Obsolete Wakka Configuration File",

);
?>