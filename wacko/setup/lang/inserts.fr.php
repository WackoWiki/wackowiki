<?php

$lng = "fr";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Bienvenue sur votre wiki motorisé par ((WackoWiki:HomePage WackoWiki))!**\n\nConnectez-vous, puis cliquez sur le lien \"Editer cette page\" en bas à gauche pour commencer.\n\nUne documentation sommaire peut être trouvée ici : WackoWiki:Doc/Francophone.\n\nPages utiles: ((WackoWiki:Doc/Francophone/MiseEnForme MiseEnForme)), PagesOrphelines, PagesDemandées, ((Recherche)), MesPages, MesModifications.\n\n", $lng, 'Admins', true, false);
	insert_page('PagesDemandées', 'Pages Demandées', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('PagesOrphelines', 'Pages Orphelines', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('MesPages', 'Mes Pages', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('MesModifications', 'Mes Modifications', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('Modifications', 'Modifications', '{{changes}}', $lng, 'Admins', false, true, 'Modifications');
insert_page('Commentaires', 'Commentaires', '{{RecentlyCommented}}', $lng, 'Admins', false, true, 'Commentaires');
insert_page('Index', 'Index', '{{PageIndex}}', $lng, 'Admins', false, true, 'Index');

insert_page('Utilisateurs', 'Utilisateurs', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('Enregistrement', 'Enregistrement', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('MotDePasse', 'Mot De Passe', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('Recherche', 'Recherche', '{{Search}}', $lng, 'Admins', false, false);
insert_page('Connexion', 'Connexion', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Préférences', 'Préférences', '{{UserSettings}}', $lng, 'Admins', false, false);

?>