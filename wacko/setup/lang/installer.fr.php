<?php
$lang = array(

/*
   Generic Page Text
*/
"Title" => "Installation de WackoWiki",
"Continue" => "Continuer",
"Back" => "Revenir en arri�re",

/*
   Language Selection Page
*/
"Lang" => "Configuration de la langue",
"LangDesc" => "Merci de choisir une langue pour le processus d'installation. Ce sera aussi la langue par d�faut de votre installation WackoWiki.",

/*
   System Requirements Page
*/
"version-check" => "Exigences syst�me",
"PHPVersion" => "Version PHP",
"PHPDetected" => "PHP d�tect�",
"ModRewrite" => "Extension \"mod_rewrite\" du serveur Apache (Optionnelle)",
"ModRewriteInstalled" => "L'extension \"mod_rewrite\" du serveur Apache est-elle install�e&nbsp;?",
"Database" => "Base de donn�es",
"Permissions" => "Permissions",
"ReadyToInstall" => "Pr�t � installer&nbsp;?",
"Installed" => "Votre WackoWiki d�j� install� se d�clare comme ",
"ToUpgrade" => "Vous vous appr�tez � <strong>mettre � niveau</strong> WackoWiki ",
"PleaseBackup" => "Merci de sauvegarder votre base de donn�es, le fichier de configuration et tous les fichiers modifi�s, tels que ceux qui auxquels des rustines auraient �t� appliqu�es, avant de commencer le processus de mise � jour. Cela peut vous �viter de forts maux de t�te.",
"Fresh" => "Comme aucun fichier de configuration de WackoWiki n'a �t� trouv�, il s'agit probablement d'une nouvelle installation. Vous vous appr�tez � installer WackoWiki ",
"Requirements" => "Votre serveur doit satisfaire les exigences list�es ci-dessous.",
"OK" => "OK",
"Problem" => "Probl�me",
"NotePermissions" => "Cet installeur va tenter d'�crire les donn�es de configuration dans le fichier <tt>wakka.config.php</tt>, dans votre r�pertoire WackoWiki. Pour cel� assurer-vous que le serveur http ait le droit d'�crire dans ce r�pertoire.  Sinon, vous devrez �diter ce fichier manuellement&nbsp;; l'installeur vous indiquera comment faire.<br /><br />Voir <a href=\"http://wackowiki.de/Archiv/DocFrancophone/InstallationEtMiseAJour\" target=\"_blank\">WackoWiki:DocFrancophone/InstallationEtMiseAJour</a> pour les d�tails.",
"ErrorPermissions" => "L'installeur ne semble pas autoris� � attribuer les droits sur les fichiers de mani�re � ce que  WackoWiki fonctionne correctement.  On vous demandera ult�rieurement d'effectuer vous-m�me de le faire vous-m�me.",
"ErrorMinPHPVersion" => "La version de PHP doit �tre sup�rieure � <strong>4.3.3</strong> et votre serveur semble fonctionner avec une version ant�rieure.  Vous devez mettre � niveau PHP pour que WackoWiki fonctionne correctement.",
"Ready" => "F�licitations, votre serveur semble capable de faire fonctionner WackoWiki.  Les quelques pages qui suivent vous guideront dans le processus de configuration.",

/*
   Site Config Page
*/
"site-config" => "Configuration du site",
"Name" => "Nom WackoWiki",
"NameDesc" => "Merci de taper le nom de vore site WackoWiki, ce doit �tre un <a href=\"http://wackowiki.de/Archiv/DocFrancophone/NomWiki\" title=\"Voir l'aide\" target=\"_blank\">Nom Wiki</a>.",
"Home" => "Page d'accueil",
"HomeDesc" => "Tapez le nom que vous souhaitez pour votre page d'accueil. Ce doit �tre un <a href=\"http://wackowiki.de/Archiv/DocFrancophone/NomWiki\" title=\"Voir l'aide\" target=\"_blank\">NomWiki</a>.",
"MultiLang" => "Mode multilingue",
"MultiLangDesc" => "Le mode multilingue permet d'avoir des pages avec plusieurs r�glages de langue sur le m�me site. Si ce mode est choisi, l'installeur cr�ee un jeu de pages de base dans chacune des langues incluses dans la distribution.",
"Admin" => "Nom de l'administrateur",
"AdminDesc" => "Tapez le nom de l'administrateur, ce doit �tre un <a href=\"http://wackowiki.de/Archiv/DocFrancophone/NomWiki\" title=\"Voir l'aide\" target=\"_blank\">Nom Wiki</a>.",
"Password" => "Mot de passe de l'administrateur",
"PasswordDesc" => "Choisissez un mot de passe d'au moins 5 caract�res pour l'administrateur.",
"Password2" => "R�p�tez le mot de passe&nbsp;:",
"Mail" => "Adresse de messagerie de l'administrateur",
"MailDesc" => "Tapez l'adresse de messagerie de l'administrateur.",
"Base" => "URL de base",
"BaseDesc" => "URL de base de votre site WackoWiki. Les noms de page lui sont accol�s, aussi doit-il se terminer par une barre oblique si vous utilisez l'extension \"mod_rewrite\", exemples&nbsp;:<br/><tt>http://www.wackowiki.de/<br/>http://www.wackowiki.de/wiki/</tt><br/><p class=\"no_top\">En revanche si vous n'utilisez pas  \"mod_rewrite\" l'URL doit se terminer par \"?page=\", exemples&nbsp;:<br/><tt>http://www.wackowiki.de/index.php?page=<br/>http://www.wackowiki.de/wiki/index.php?page=<br/>http://www.wackowiki.de/?page=<br/>http://www.wackowiki.de?page=</tt><br/>",
"Rewrite" => "Mode \"rewrite\"",
"RewriteDesc" => "L'extension \"mod_rewrite\" doit �tre activ�e pour utiliser WackoWiki avec la r��criture d'URL.",
"Enabled" => "Activ�&nbsp;",
"ErrorAdminName" => "Le nom d'administrateur doit �te un NomWiki&nbsp;!",
"ErrorAdminEmail" => "Vous avez indiqu� une adresse de messagerie non valide&nbsp;!",
"ErrorAdminPasswordMismatch" => "Les mots de passe ne co�ncident pas&nbsp;!",
"ErrorAdminPasswordShort" => "Le mot de passe de l'administrateur est trop court, il doit avoir au moins 5 caract�res&nbsp;!",
"WarningRewriteMode" => "ATTENTION!\nVotre URL de base comporte un point d'interrogation alors que l'extension \"mod_rewrite\") est activ�e, ceci nous semble incoh�rent.\n\nPour confirmer n�anmoins ce r�glage cliquez sur OK.\nPour revenir au formualire et changer vos r�glages cliquez sur CANCEL.\n\nSi vous vous appr�tez � confirmer ces r�glages, veuillez noter que cela pourrait causer des probl�mes avec votre installation de WackoWiki.",
"ModRewriteStatusUnknown" => "L'installeur ne peut pas confirmer que \"mod_rewrite\" est activ�, il est cependant possible qu'il le soit.",

/*
   Database Config Page
*/
"database-config" => "Configuration de la base de donn�es",
"DBDriverDesc" => "Le pilote de base de donn�es que vous souhaitez utiliser. Pour utiliser un pilote PDO vous devez avoir PHP version 5.1 (ou sup�rieure) et <a href=\"http://fr.php.net/pdo\" target=\"_blank\">PDO</a> install�s.",
"DBDriver" => "Pilote",
"DBHost" => "H�te",
"DBHostDesc" => "l'h�te sur lequel votre serveur de base de donn�es fonctionne, habituellement\"localhost\" (ie, la m�me machine que celle sur laquelle est install� votre site WackoWiki).",
"DBPort" => "Num�ro de port (Optionnel)",
"DBPortDesc" => "Le num�ro de port � utiliser pour communiquer avec votre serveur de base de donn�es. Laissez-le vide pour utiliser le num�ro de port pas d�faut.",
"DB" => "Nom de base de donn�es",
"DBDesc" => "La base de donn�es � utiliser par WackoWiki. Elle doit exister avant de continuer&nbsp;!",
"DBUserDesc" => "Nom et mot de passe de l'utilisateur sous l'identit� duquel se connecter � votre base de donn�es.",
"DBUser" => "Nom d'utilisateur",
"DBPasswordDesc" => "Nom et mot de passe de l'utilisateur sous l'identit� duquel se connecter � votre base de donn�es.",
"DBPassword" => "Mot de passe",
"PrefixDesc" => "Prefixe de toutes les tables utilis�es par WackoWiki. Son utilisation vous permet de faire fonctionner plusieurs installations de WackoWiki utilisant la m�me base de donn�es, en les configurant avec des pr�fixes distincts.",
"Prefix" => "Pr�fixe des tables",
"ErrorNoDbDriverDetected" => "Aucun pilote de base de donn�es n'a �t� d�tect�, activez s'il vous plait une des extensions mysql, mysqli ou pdo dans votre fichier \"php.ini\".",
"ErrorNoDbDriverSelected" => "Aucun pilote de base de donn�es n'a �t� s�lectionn�, merci d'en choisir un dans la liste.",

/*
   Database Installation Page
*/
"database-install" => "Installation de la base de donn�es",
"TestingConfiguration" => "Test de la configuration",
"TestConnectionString" => "Test des param�tres de connexion � la base de donn�es",
"TestDatabaseExists" => "V�rification de l'existence de la base de donn�e indiqu�e",
"InstallingTables" => "Installation des tables",
"ErrorDBConnection" => "Les param�tres de connexion � la base de donn�es que vous avez indiqu�s posent un probl�me, merci de revenir en arr�re et de les v�rifier.",
"ErrorDBExists" => "La base de donn�e indiqu�e n'a pas �t� trouv�e. Souvenez-vous qu'elle doit exister avant d'installer ou de mettre � niveau WackoWiki&nbsp!",
"To" => "Vers",
"AlterTable" => "Modification de la table %1",
"AlterUsersTable" => "Modification de la table des utilisateurs",
"InstallingDefaultData" => "Ajout des donn�es par d�faut",
"InstallingPagesBegin" => "Ajout des pages par d�faut",
"InstallingPagesEnd" => "Ajout des pages par d�faut",
"InstallingAdmin" => "Ajout de l'utilisateur administrateur",
"InstallingLogoImage" => "Ajout du logo",
"ErrorInsertingPage" => "Erreur dans l'insertion de la page %1",
"ErrorInsertingPageReadPermission" => "Erreur lors de l'attribution du droit de lire la page %1",
"ErrorInsertingPageWritePermission" => "Erreur lors de l'attribution du droit d'�crire la page %1",
"ErrorInsertingPageCommentPermission" => "Erreur lors de l'attribution du droit de commenter la page %1",
"ErrorPageAlreadyExists" => "La page %1 existe d�j�",
"ErrorAlteringTable" => "Erreur lors de la modification de la page %1",
"CreatingTable" => "Cr�ation de la page %1",
"ErrorAlreadyExists" => " Erreur, %1 existe d�j�",
"ErrorCreatingTable" => "Erreur lors de la cr�ation de la table %1, existe-telle d�j�&nbsp;?",
"ErrorMovingRevisions" => "Erreur lors du d�placement des donn�es concernant les r�visions",
"MovingRevisions" => "D�placement des donn�es concern�es vers la table des r�visions",
"CleanupScript" => "Si vous utilisez <a href=\"http://wackowiki.de/Archiv/DocEnglish/CleanupScript\" target=\"_blank\">WackoWiki:DocEnglish/CleanupScript</a>, vous acc�l�rerez votre WackoWiki.",

/*
   Write Config Page
*/
"write-config" => "Ecriture du fichier de configuration",
"Writing" => "Ecriture de la configuration",
"Writing2" => "Ecriture du fichier de configuration",
"RemovingWritePrivilege" => "Suppression du droits d'�crire",
"InstallationComplete" => "C'est tout&nbsp;! Vous pouvez maintenenant <a href=\"%1\">acc�der � votre site WackoWiki</a>.",
"SecurityConsiderations" => "Considerations sur la s�curit�",
"SecurityRisk" => "Par s�curit�, limitez maintenant le droit d'�crire le fichier <tt>wakka.config.php</tt> maintenant, par exemple <tt>chmod 644 wakka.config.php</tt>.",
"RemoveSetupDirectory" => "Par s�curit�, supprimez maintenant le r�pertoire \"setup\", devenu inutile.",
"ErrorGivePrivileges" => "Le fichier de configuration %1 n'a pas pu �tre �crit par le serveur http dans votre r�pertoire WackoWiki.<br/>Si possible, cr�ez un fichier vide appel�  <tt>wakka.config.php</tt>, sur lequel vous attribuerez � provisoirement � tous le droit d'�criture&nbsp;:<br/><tt>touch wakka.config.php</tt><br/><tt>chmod 666 wakka.config.php</tt>.<br/>Nota&nbsp;: apr�s enregistrement vous supprimerez ce droit, i.e. <tt>chmod 644 wakka.config.php</tt>).<br/> Sinon, vous devrez copier le texte ci-dessous dans un fichier et le sauvegarder comme <tt>wakka.config.php</tt> dans le r�pertoire WackoWiki.<br/>Ceci fait, votre site WackoWiki devrait fontionner. Sinon, voyez  <a href=\"http://wackowiki.de/Archiv/DocFrancophone/InstallationEtMiseAJour\">WackoWiki:DocFrancophone/InstallationEtMiseAJour</a>",
"NextStep" => "Dans la prochaine �tape, l'installeur va tenter d'�crire le fichier de configuration mis � jour, <tt>wakka.config.php</tt>.  Merci de vous assurer que le serveur a le droit d'�crire ce fichier, sinon vous devrez l'�diter manuellement. Encore une fois, voyez <a href=\"http://wackowiki.de/Archiv/DocFrancophone/InstallationEtMiseAJour\" target=\"_blank\">WackoWiki:DocFrench/InstallationEtMiseAJour</a> pour les d�tails.",
"WrittenAt" => "�crit � ",
"DontChange" => "ne modifiez pas wakka_version !",
"TryAgain" => "Essayez encore",
);
?>