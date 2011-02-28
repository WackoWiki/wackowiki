<?php

$lng = "fr";

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] = false)
	{
		insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Bienvenue sur votre wiki motorisé par ((WackoWiki:HomePage WackoWiki))!**\n\nConnectez-vous, puis cliquez sur le lien \"Editer cette page\" en bas à gauche pour commencer.\n\nUne documentation sommaire peut être trouvée ici : WackoWiki:Doc/Francophone.\n\nPages utiles: ((WackoWiki:Doc/Francophone/MiseEnForme MiseEnForme)), ((Recherche)).\n\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "{{adminupdate}}\n\n", $lng, $config['admin_name'], true, false);
	}

	#insert_page('PagesDemandées', 'Pages Demandées', '{{wanted}}', $lng, 'Admins', true, false);
	#insert_page('PagesOrphelines', 'Pages Orphelines', '{{orphaned}}', $lng, 'Admins', true, false);
	#insert_page('MesPages', 'Mes Pages', '{{MyPages}}', $lng, 'Admins', true, false);
	#insert_page('MesModifications', 'Mes Modifications', '{{MyChanges}}', $lng, 'Admins', true, false);

	insert_page('Category', 'Category', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{usergroups}}', $lng, 'Admins', false, false);
	insert_page('Users', 'Utilisateurs', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('Modifications', 'Modifications', '{{changes}}', $lng, 'Admins', false, true, 'Modifications');
insert_page('Commentaires', 'Commentaires', '{{commented}}', $lng, 'Admins', false, true, 'Commentaires');
insert_page('Index', 'Index', '{{PageIndex}}', $lng, 'Admins', false, true, 'Index');

insert_page('Enregistrement', 'Enregistrement', '{{registration}}', $lng, 'Admins', false, false);

insert_page('MotDePasse', 'Mot De Passe', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('Recherche', 'Recherche', '{{search}}', $lng, 'Admins', false, false);
insert_page('Connexion', 'Connexion', '{{login}}', $lng, 'Admins', false, false);
insert_page('Préférences', 'Préférences', '{{UserSettings}}', $lng, 'Admins', false, false);

?>