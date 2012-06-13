<?php

$lng = 'fr';

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Bienvenue sur votre wiki motoris� par ((WackoWiki:HomePage WackoWiki))!**\n\nConnectez-vous, puis cliquez sur le lien \"Editer cette page\" en bas � gauche pour commencer.\n\nUne documentation sommaire peut �tre trouv�e ici : WackoWiki:Doc/Francophone.\n\nPages utiles: ((WackoWiki:Doc/Francophone/MiseEnForme MiseEnForme)), ((Recherche)).\n\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lng, $config['admin_name'], true, false);
	}
	else
	{
		// ...
	}

	#insert_page('PagesDemand�es', 'Pages Demand�es', '{{wanted}}', $lng, 'Admins', true, false);
	#insert_page('PagesOrphelines', 'Pages Orphelines', '{{orphaned}}', $lng, 'Admins', true, false);
	#insert_page('MesPages', 'Mes Pages', '{{mypages}}', $lng, 'Admins', true, false);
	#insert_page('MesModifications', 'Mes Modifications', '{{mychanges}}', $lng, 'Admins', true, false);

	insert_page('Cat�gories', 'C	at�gories', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permaliens', 'Liens permanents', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lng, 'Admins', false, false);
	insert_page('Utilisateurs', 'Utilisateurs', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('Modifications', 'Modifications', '{{changes}}', $lng, 'Admins', false, true, 'Modifications');
insert_page('Commentaires', 'Commentaires', '{{commented}}', $lng, 'Admins', false, true, 'Commentaires');
insert_page('Index', 'Index', '{{pageindex}}', $lng, 'Admins', false, true, 'Index');

insert_page('Enregistrement', 'Enregistrement', '{{registration}}', $lng, 'Admins', false, false);

insert_page('MotDePasse', 'Mot De Passe', '{{changepassword}}', $lng, 'Admins', false, false);
insert_page('Recherche', 'Recherche', '{{search}}', $lng, 'Admins', false, false);
insert_page('Connexion', 'Connexion', '{{login}}', $lng, 'Admins', false, false);
insert_page('Pr�f�rences', 'Pr�f�rences', '{{usersettings}}', $lng, 'Admins', false, false);

?>
