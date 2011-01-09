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
'Back' => 'Revenir en arri�re',

/*
   Language Selection Page
*/
'UpgradeFromWacko' => 'Bienvenue � bord de WackoWiki, vous semblez passer de WackoWiki <tt>%1</tt> � <tt>%2</tt>.  Les quelques pages qui suivent vous guideront dans le processus de mise � niveau.',
'FreshInstall' => 'Bienvenue � bord de WackoWiki, vous vous appr�tez � installer WackoWiki <tt>%1</tt>.  Les quelques pages qui suivent vous guideront dans le processus d\'installation.',
'PleaseBackup' => 'Merci de sauvegarder votre base de donn�es, le fichier de configuration et tous les fichiers modifi�s, tels que ceux qui auxquels des rustines auraient �t� appliqu�es, avant de commencer le processus de mise � niveau. Cela peut vous �viter une bonne migraine.',
'Lang' => 'Configuration de la langue',
'LangDesc' => 'Merci de choisir une langue pour le processus d\'installation. Ce sera aussi la langue par d�faut de votre installation WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'Exigences syst�me',
'PHPVersion' => 'Version PHP',
'PHPDetected' => 'PHP d�tect�',
'ModRewrite' => 'Extension "mod_rewrite" du serveur Apache (Optionnelle)',
'ModRewriteInstalled' => 'L\'extension "mod_rewrite" du serveur Apache est-elle install�e&nbsp;?',
'Database' => 'Base de donn�es',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Pr�t � installer&nbsp;?',
'Requirements' => 'Votre serveur doit satisfaire les exigences list�es ci-dessous.',
'OK' => 'OK',
'Problem' => 'Probl�me',
'NotePermissions' => 'Cet installeur va tenter d\'�crire les donn�es de configuration dans le fichier <tt>config.php</tt>, dans votre r�pertoire WackoWiki. Pour cel� assurer-vous que le serveur http ait le droit d\'�crire dans ce r�pertoire.  Sinon, vous devrez �diter ce fichier manuellement&nbsp;; l\'installeur vous indiquera comment faire.<br /><br />Voir <a href="http://wackowiki.org/Doc/Francophone/InstallationEtMiseAJour" target="_blank">WackoWiki:Doc/Francophone/InstallationEtMiseAJour</a> pour les d�tails.',
'ErrorPermissions' => 'L\'installeur ne semble pas autoris� � attribuer des droits suffisants sur les fichiers pour que WackoWiki fonctionne correctement.  On vous demandera ult�rieurement de le faire vous-m�me.',
'ErrorMinPHPVersion' => 'La version de PHP doit �tre sup�rieure � <strong>5.2.0</strong> et votre serveur semble fonctionner avec une version ant�rieure.  Vous devez mettre � niveau PHP pour que WackoWiki fonctionne correctement.',
'Ready' => 'F�licitations, votre serveur semble capable de faire fonctionner WackoWiki.  Les quelques pages qui suivent vous guideront dans le processus de configuration.',

/*
   Site Config Page
*/
'site-config' => 'Configuration du site',
'Name' => 'Nom WackoWiki',
'NameDesc' => 'Choisissez le nom de votre site WackoWiki, ce doit �tre un <a href="http://wackowiki.org/Doc/Francophone/NomWiki" title="Voir l\'aide" target="_blank">Nom Wiki</a>.',
'Home' => 'Page d\'accueil',
'HomeDesc' => 'Choissez le nom de votre page d\'accueil. Ce doit �tre un <a href="http://wackowiki.org/Doc/Francophone/NomWiki" title="Voir l\'aide" target="_blank">NomWiki</a>.',
'HomeDefault' => 'HomePage',
'MultiLang' => 'Mode multilingue',
'MultiLangDesc' => 'Le mode multilingue permet d\'avoir des pages avec plusieurs r�glages de langue sur le m�me site. Si ce mode est choisi, l\'installeur cr�e un jeu de pages de base dans chacune des langues incluses dans la distribution.',
'Admin' => 'Nom de l\'administrateur',
'AdminDesc' => 'Indiquez le nom de l\'administrateur, ce doit �tre un <a href="http://wackowiki.org/Doc/Francophone/NomWiki" title="Voir l\'aide" target="_blank">Nom Wiki</a> (e.g. WikiAdmin).',
'Password' => 'Mot de passe de l\'administrateur',
'PasswordDesc' => 'Choisissez un mot de passe d\'au moins 8 caract�res pour l\'administrateur.',
'Password2' => 'R�p�tez le mot de passe&nbsp;:',
'Mail' => 'Adresse de messagerie de l\'administrateur',
'MailDesc' => 'Indiquez l\'adresse de messagerie de l\'administrateur.',
'Base' => 'URL de base',
'BaseDesc' => 'URL de base de votre site WackoWiki. Les noms de page lui sont accol�s, aussi doit-il se terminer par une barre oblique si vous utilisez l\'extension "mod_rewrite", exemples&nbsp;:<br/><tt>http://wackowiki.org/<br/>http://wackowiki.org/wiki/</tt><br/>',
'Rewrite' => 'Mode "rewrite"',
'RewriteDesc' => 'L\'extension "mod_rewrite" doit �tre activ�e pour utiliser WackoWiki avec la r��criture d\'URL.',
'Enabled' => 'Activ�&nbsp;',
'ErrorAdminName' => 'Le nom d\'administrateur doit �tre un NomWiki&nbsp;!',
'ErrorAdminEmail' => 'Vous avez indiqu� une adresse de messagerie non conforme&nbsp;!',
'ErrorAdminPasswordMismatch' => 'Les mots de passe ne co�ncident pas&nbsp;!',
'ErrorAdminPasswordShort' => 'Le mot de passe de l\'administrateur est trop court, il doit avoir au moins 8 caract�res&nbsp;!',
'WarningRewriteMode' => 'ATTENTION!\nVotre URL de base comporte un point d\'interrogation alors que l\'extension "mod_rewrite") est activ�e, ceci nous semble incoh�rent.\n\nPour confirmer n�anmoins ce r�glage cliquez sur OK.\nPour revenir au formulaire et changer vos r�glages cliquez sur CANCEL.\n\nSi vous vous appr�tez � confirmer ces r�glages, veuillez noter que cela pourrait rendre probl�matique votre installation de WackoWiki.',
'ModRewriteStatusUnknown' => 'L\'installeur ne peut pas confirmer que "mod_rewrite" soit activ�, il est cependant possible qu\'il le soit.',

/*
   Database Config Page
*/
'database-config' => 'Configuration de la base de donn�es',
'DBDriverDesc' => 'Choisissez le pilote de base de donn�es que vous souhaitez utiliser. Pour utiliser un pilote PDO vous devez avoir PHP version 5.1 (ou sup�rieure) et <a href="http://fr.php.net/pdo" target="_blank">PDO</a> install�s.',
'DBDriver' => 'Pilote',
'DBHost' => 'H�te',
'DBHostDesc' => 'Indiquez le nom de domaine de l\'h�te sur lequel votre serveur de base de donn�es fonctionne. Le cas �ch�ant, votre h�bergeur peut vous l\'indiquer.',
'DBPort' => 'Num�ro de port (Optionnel)',
'DBPortDesc' => 'Le num�ro de port � utiliser pour communiquer avec votre serveur de base de donn�es. Laissez-le vide pour utiliser le num�ro de port pas d�faut.',
'DB' => 'Nom de base de donn�es',
'DBDesc' => 'Indiquez le nom de la base de donn�es � utiliser par WackoWiki. Elle doit exister avant de continuer&nbsp;!',
'DBUserDesc' => 'Indiquez le nom de l\'utilisateur sous l\'identit� duquel se connecter � votre base de donn�es.',
'DBUser' => 'Nom d\'utilisateur',
'DBPasswordDesc' => 'Indiquez le mot de passe de l\'utilisateur sous l\'identit� duquel se connecter � votre base de donn�es.',
'DBPassword' => 'Mot de passe',
'PrefixDesc' => 'Chosissez le pr�fixe de toutes les tables utilis�es par WackoWiki. Ceci vous permet de faire fonctionner plusieurs installations de WackoWiki utilisant la m�me base de donn�es, en les configurant avec des pr�fixes distincts (par exemple wacko_).',
'Prefix' => 'Pr�fixe des tables',
'ErrorNoDbDriverDetected' => 'Aucun pilote de base de donn�es n\'a �t� d�tect�, activez une des extensions mysql, mysqli ou pdo dans votre fichier "php.ini".',
'ErrorNoDbDriverSelected' => 'Aucun pilote de base de donn�es n\'a �t� s�lectionn�, choisissez-en un dans la liste.',
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! Si vous poursuivez avec cette option, tout le contenu actuel du wiki sera effac� de la base de donn�es. Il vous sera impossible de revenir en arri�re, � moins que vous ne restauriez manuellement les donn�es � partir d\'une sauvegarde.',
'ConfirmTableDeletion' => '�tes-vous s�r de vouloir effacer toutes les donn�es pr�sentes dans les tables du Wiki ?',

/*
   Database Installation Page
*/
'database-install' => 'Installation de la base de donn�es',
'TestingConfiguration' => 'Test de la configuration',
'TestConnectionString' => 'Test des param�tres de connexion � la base de donn�es',
'TestDatabaseExists' => 'V�rification de l\'existence de la base de donn�e indiqu�e',
'InstallingTables' => 'Installation des tables',
'ErrorDBConnection' => 'Les param�tres de connexion � la base de donn�es que vous avez indiqu�s posent un probl�me, merci de revenir en arri�re et de les v�rifier.',
'ErrorDBExists' => 'La base de donn�e indiqu�e n\'a pas �t� trouv�e. Souvenez-vous qu\'elle doit exister avant d\'installer ou de mettre � niveau WackoWiki&nbsp!',
'To' => 'Vers',
'AlterTable' => 'Modification de la table <tt>%1</tt>',
'RenameTable' => 'Renaming <tt>%1</tt> Table',
'UpdateTable' => 'Updating <tt>%1</tt> Table',
'InstallingDefaultData' => 'Ajout des donn�es par d�faut',
'InstallingPagesBegin' => 'Ajout des pages par d�faut',
'InstallingPagesEnd' => 'Ajout des pages par d�faut',
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
'InstallingConfigValues' => 'Ajout des param�tres de configuration',
'ErrorInsertingPage' => 'Erreur dans l\'insertion de la page <tt>%1</tt>',
'ErrorInsertingPageReadPermission' => 'Erreur lors de l\'attribution du droit de lire la page <tt>%1</tt>',
'ErrorInsertingPageWritePermission' => 'Erreur lors de l\'attribution du droit d\'�crire la page <tt>%1</tt>',
'ErrorInsertingPageCommentPermission' => 'Erreur lors de l\'attribution du droit de commenter la page <tt>%1</tt>',
'ErrorInsertingDefaultBookmark' => 'Error setting page <tt>%1</tt> as default bookmark',
'ErrorPageAlreadyExists' => 'La page <tt>%1</tt> existe d�j�',
'ErrorAlteringTable' => 'Erreur lors de la modification de la table <tt>%1</tt>',
'ErrorRenamingTable' => 'Error renaming <tt>%1</tt> table',
'ErrorUpdatingTable' => 'Erreur lors de la mise � jour de la table <tt>%1</tt> table',
'CreatingTable' => 'Cr�ation de la table <tt>%1</tt>',
'ErrorAlreadyExists' => ' Erreur, <tt>%1</tt> existe d�j�',
'ErrorCreatingTable' => 'Erreur lors de la cr�ation de la table <tt>%1</tt>, existe-telle d�j�&nbsp;?',
'ErrorMovingRevisions' => 'Erreur lors du d�placement des donn�es concernant les r�visions',
'MovingRevisions' => 'D�placement des donn�es concern�es vers la table des r�visions',
'DeletingTables' => 'Effacement des tables',
'DeletingTablesEnd' => 'Effacement des tables termin�',
'ErrorDeletingTable' => 'Erreur lors de l\'effacement de la table <tt>%1</tt>, probablement parce que cette table n\'existe pas, auquel cas vous pouvez ignorer cette alerte.',
'DeletingTable' => 'Effacement de la table <tt>%1</tt>',

/*
   Write Config Page
*/
'write-config' => '�criture du fichier de configuration',
'FinalStep' => 'Derni�re �tape',
'Writing' => '�criture du fichier de configuration',
'RemovingWritePrivilege' => 'Suppression du droit d\'�crire',
'InstallationComplete' => 'Installation termin�e',
'ThatsAll' => 'C\'est tout&nbsp;! Vous pouvez maintenant <a href="%1">acc�der � votre site WackoWiki</a>.',
'SecurityConsiderations' => 'Consid�rations sur la s�curit�',
'SecurityRisk' => 'Par s�curit�, limitez maintenant le droit d\'�crire le fichier <tt>config.php</tt> maintenant, par exemple <tt>chmod 644 config.php</tt>.',
'RemoveSetupDirectory' => 'Par s�curit�, supprimez maintenant le r�pertoire "setup", devenu inutile.',
'ErrorGivePrivileges' => 'Le fichier de configuration <tt>%1</tt> n\'a pas pu �tre �crit par le serveur http dans votre r�pertoire WackoWiki.<br/>Si possible, cr�ez un fichier vide appel�  <tt>config.php</tt>, sur lequel vous attribuerez � provisoirement � tous le droit d\'�crire&nbsp;:<br/><tt>touch config.php</tt><br/><tt>chmod 666 config.php</tt>.<br/>Nota&nbsp;: apr�s enregistrement vous supprimerez ce droit, i.e. <tt>chmod 644 config.php</tt>).<br/> Sinon, vous devrez copier le texte ci-dessous dans un fichier et le sauvegarder comme <tt>config.php</tt> dans le r�pertoire WackoWiki.<br/>Ceci fait, votre site WackoWiki devrait fonctionner. Sinon, voyez  <a href="http://wackowiki.org/Doc/Francophone/InstallationEtMiseAJour">WackoWiki:Doc/Francophone/InstallationEtMiseAJour</a>',
'NextStep' => 'Au cours de la prochaine �tape, l\'installeur va tenter d\'�crire le fichier de configuration mis � jour, <tt>config.php</tt>.  Assurez-vous que le serveur a le droit d\'�crire ce fichier, sinon vous devrez l\'�diter manuellement. Encore une fois, voyez <a href="http://wackowiki.org/Doc/Francophone/InstallationEtMiseAJour" target="_blank">WackoWiki:Doc/Francophone/InstallationEtMiseAJour</a> pour les d�tails.',
'WrittenAt' => '�crit � ',
'DontChange' => 'ne modifiez pas wacko_version !',
'ConfigDescription' => 'pour une description d�taill�e de la configuration voir http://wackowiki.org/Doc/Francophone/Configuration',
'TryAgain' => 'Essayez encore',
'RemoveWakkaConfigFile' => 'WackoWiki utilise un fichier de configuration plus r�cent que celui de votre installation pr�c�dente de  WakkaWiki  L\'ancien fichier n\'a pu �tre automatiquement supprim� par le syst�me, aussi vous �tes il recommand� d\'effacer vous-m�me le fichier <tt>wakka.config.php</tt>.',
'DeletingWakkaConfigFile' => 'Effacement du fichier de configuration Wakka obsom�te',

);
?>
