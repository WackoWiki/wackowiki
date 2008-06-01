<?php
$lng = "fr";

if ($config["language"]==$lng)
{
 InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Bienvenue sur votre site ((WackoWiki:WackoWiki WackoWiki))!**\n\nCliquez sur le lien \"Editer cette page\" en bas de la page pour commencer.\n\nUne documentation sommaire peut �tre trouv�e ici : WackoWiki:DocFrancophone.\n\nPages utiles: PagesOrphelines, PagesDemand�es, ((Recherche)), MesPages, MesModifications.\n\n", $lng);
 InsertPage('PagesDemand�es', '{{WantedPages}}', $lng);
 InsertPage('PagesOrphelines', '{{OrphanedPages}}', $lng);
 InsertPage('MesPages', '{{MyPages}}', $lng);
 InsertPage('MesModifications', '{{MyChanges}}', $lng);
}

InsertPage('Derni�resModifications', '{{RecentChanges}}', $lng);
InsertPage('DerniersCommentaires', '{{RecentlyCommented}}', $lng);
InsertPage('Index', '{{PageIndex}}', $lng);
InsertPage('Utilisateurs', '{{LastUsers}}', $lng);
InsertPage('Enregistrement', '{{Registration}}', $lng);

InsertPage('MotDePasse', '{{ChangePassword}}', $lng);
InsertPage('Recherche', '{{Search}}', $lng);
InsertPage('Connexion', '{{Login}}', $lng);
InsertPage('Pr�f�rences', '{{UserSettings}}', $lng);

InsertPage('InterWiki', '{{InterWikiList}}', $lng);

?>
