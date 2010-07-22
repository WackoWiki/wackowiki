<?php

$lng = "fr";

if ($config["language"] == $lng)
{
	InsertPage($config["root_page"], '', "((file:wacko4.png WackoWiki))\n**Bienvenue sur votre wiki motoris� par ((WackoWiki:HomePage WackoWiki))!**\n\nConnectez-vous, puis cliquez sur le lien \"Editer cette page\" en bas � gauche pour commencer.\n\nUne documentation sommaire peut �tre trouv�e ici : WackoWiki:Doc/Francophone.\n\nPages utiles: ((WackoWiki:Doc/Francophone/MiseEnForme MiseEnForme)), PagesOrphelines, PagesDemand�es, ((Recherche)), MesPages, MesModifications.\n\n", $lng, "Admins", true);
	InsertPage('PagesDemand�es', 'Pages Demand�es', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('PagesOrphelines', 'Pages Orphelines', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MesPages', 'Mes Pages', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MesModifications', 'Mes Modifications', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('Modifications', 'Modifications', '{{RecentChanges}}', $lng);
InsertPage('Commentaires', 'Commentaires', '{{RecentlyCommented}}', $lng);
InsertPage('Index', 'Index', '{{PageIndex}}', $lng);
InsertPage('Utilisateurs', 'Utilisateurs', '{{LastUsers}}', $lng);
InsertPage('Enregistrement', 'Enregistrement', '{{Registration}}', $lng);

InsertPage('MotDePasse', 'Mot De Passe', '{{ChangePassword}}', $lng);
InsertPage('Recherche', 'Recherche', '{{Search}}', $lng);
InsertPage('Connexion', 'Connexion', '{{Login}}', $lng);
InsertPage('Pr�f�rences', 'Pr�f�rences', '{{UserSettings}}', $lng);

?>