<?php
$lng = "fr";

if ($config["language"]==$lng)
{
	InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Bienvenue sur votre site ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nCliquez sur le lien \"Editer cette page\" en bas de la page pour commencer.\n\nUne documentation sommaire peut être trouvée ici : WackoWiki:Doc/Francophone.\n\nPages utiles: ((WackoWiki:Doc/Francophone/MiseEnForme MiseEnForme)), PagesOrphelines, PagesDemandées, ((Recherche)), MesPages, MesModifications.\n\n", $lng, "Admins", true);
	InsertPage('PagesDemandées', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('PagesOrphelines', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MesPages', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MesModifications', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('DernièresModifications', '{{RecentChanges}}', $lng);
InsertPage('DerniersCommentaires', '{{RecentlyCommented}}', $lng);
InsertPage('Index', '{{PageIndex}}', $lng);
InsertPage('Utilisateurs', '{{LastUsers}}', $lng);
InsertPage('Enregistrement', '{{Registration}}', $lng);

InsertPage('MotDePasse', '{{ChangePassword}}', $lng);
InsertPage('Recherche', '{{Search}}', $lng);
InsertPage('Connexion', '{{Login}}', $lng);
InsertPage('Préférences', '{{UserSettings}}', $lng);

InsertPage('InterWiki', '{{InterWikiList}}', $lng);

?>
