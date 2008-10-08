<?php
$lng = "fr";

if ($config["language"]==$lng)
{
	InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Bienvenue sur votre wiki motorisé par ((WackoWiki:HomePage WackoWiki))!**\n\nConnectez-vous, puis cliquez sur le lien \"Editer cette page\" en bas à gauche pour commencer.\n\nUne documentation sommaire peut être trouvée ici : WackoWiki:Doc/Francophone.\n\nPages utiles: ((WackoWiki:Doc/Francophone/MiseEnForme MiseEnForme)), PagesOrphelines, PagesDemandées, ((Recherche)), MesPages, MesModifications.\n\n", $lng, "Admins", true);
	InsertPage('PagesDemandées', '{{WantedPages}}', $lng, "Admins", true);
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
InsertPage('Préférences', '{{UserSettings}}', $lng);

InsertPage('InterWiki', '{{InterWikiList}}', $lng);
?>