<?php

$lng = "fr";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Bienvenue sur votre wiki motoris� par ((WackoWiki:HomePage WackoWiki))!**\n\nConnectez-vous, puis cliquez sur le lien \"Editer cette page\" en bas � gauche pour commencer.\n\nUne documentation sommaire peut �tre trouv�e ici : WackoWiki:Doc/Francophone.\n\nPages utiles: ((WackoWiki:Doc/Francophone/MiseEnForme MiseEnForme)), PagesOrphelines, PagesDemand�es, ((Recherche)), MesPages, MesModifications.\n\n", $lng, "Admins", true);
	insert_page('PagesDemand�es', 'Pages Demand�es', '{{WantedPages}}', $lng, "Admins", true);
	insert_page('PagesOrphelines', 'Pages Orphelines', '{{OrphanedPages}}', $lng, "Admins", true);
	insert_page('MesPages', 'Mes Pages', '{{MyPages}}', $lng, "Admins", true);
	insert_page('MesModifications', 'Mes Modifications', '{{MyChanges}}', $lng, "Admins", true);
}

insert_page('Modifications', 'Modifications', '{{RecentChanges}}', $lng);
insert_page('Commentaires', 'Commentaires', '{{RecentlyCommented}}', $lng);
insert_page('Index', 'Index', '{{PageIndex}}', $lng);
insert_page('Utilisateurs', 'Utilisateurs', '{{LastUsers}}', $lng);
insert_page('Enregistrement', 'Enregistrement', '{{Registration}}', $lng);

insert_page('MotDePasse', 'Mot De Passe', '{{ChangePassword}}', $lng);
insert_page('Recherche', 'Recherche', '{{Search}}', $lng);
insert_page('Connexion', 'Connexion', '{{Login}}', $lng);
insert_page('Pr�f�rences', 'Pr�f�rences', '{{UserSettings}}', $lng);

?>