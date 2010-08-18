<?php

$lng = "fr";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Bienvenue sur votre wiki motorisé par ((WackoWiki:HomePage WackoWiki))!**\n\nConnectez-vous, puis cliquez sur le lien \"Editer cette page\" en bas à gauche pour commencer.\n\nUne documentation sommaire peut être trouvée ici : WackoWiki:Doc/Francophone.\n\nPages utiles: ((WackoWiki:Doc/Francophone/MiseEnForme MiseEnForme)), PagesOrphelines, PagesDemandées, ((Recherche)), MesPages, MesModifications.\n\n", $lng, "Admins", true);
	insert_page('PagesDemandées', 'Pages Demandées', '{{WantedPages}}', $lng, "Admins", true);
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
insert_page('Préférences', 'Préférences', '{{UserSettings}}', $lng);

?>