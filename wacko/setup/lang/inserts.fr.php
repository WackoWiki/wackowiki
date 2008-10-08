<?php
$lng = "fr";

if ($config["language"]==$lng)
{
	InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Bienvenue sur votre wiki motoris� par ((WackoWiki:HomePage WackoWiki))!**\n\nConnectez-vous, puis cliquez sur le lien \"Editer cette page\" en bas � gauche pour commencer.\n\nUne documentation sommaire peut �tre trouv�e ici : WackoWiki:Doc/Francophone.\n\nPages utiles: ((WackoWiki:Doc/Francophone/MiseEnForme MiseEnForme)), PagesOrphelines, PagesDemand�es, ((Recherche)), MesPages, MesModifications.\n\n", $lng, "Admins", true);
	InsertPage('PagesDemand�es', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('PagesOrphelines', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MesPages', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MesModifications', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('Modifications', '{{RecentChanges}}', $lng);
InsertPage('Commentaires', '{{RecentlyCommented}}', $lng);
InsertPage('Index', '{{PageIndex}}', $lng);
InsertPage('Utilisateurs', '{{LastUsers}}', $lng);
InsertPage('Enregistrement', '{{Registration}}', $lng);

InsertPage('MotDePasse', '{{ChangePassword}}', $lng);
InsertPage('Recherche', '{{Search}}', $lng);
InsertPage('Connexion', '{{Login}}', $lng);
InsertPage('Pr�f�rences', '{{UserSettings}}', $lng);

InsertPage('InterWiki', '{{InterWikiList}}', $lng);
?>