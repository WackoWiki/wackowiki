<?php

$lang = 'fr';

// insert these pages only for default language
if ($config['language'] == $lang)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Bienvenue sur votre wiki motorisé par ((WackoWiki:HomePage WackoWiki))!**\n\nConnectez-vous, puis cliquez sur le lien \"Editer cette page\" en bas à gauche pour commencer.\n\nUne documentation sommaire peut être trouvée ici : WackoWiki:Doc/Francophone.\n\nPages utiles: ((WackoWiki:Doc/Francophone/MiseEnForme MiseEnForme)), ((Recherche)).\n\n", $lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Catégories', 'Catégories', '{{category}}', $lang, 'Admins', false, false);
	insert_page('Permaliens', 'Liens permanents', '{{permalinkproxy}}', $lang, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lang, 'Admins', false, false);
	insert_page('Utilisateurs', 'Utilisateurs', '{{users}}', $lang, 'Admins', false, false);
}

insert_page('Modifications', 'Modifications', '{{changes}}', $lang, 'Admins', false, true, 'Modifications');
insert_page('Commentaires', 'Commentaires', '{{commented}}', $lang, 'Admins', false, true, 'Commentaires');
insert_page('Index', 'Index', '{{pageindex}}', $lang, 'Admins', false, true, 'Index');

insert_page('Enregistrement', 'Enregistrement', '{{registration}}', $lang, 'Admins', false, false);

insert_page('MotDePasse', 'Mot De Passe', '{{changepassword}}', $lang, 'Admins', false, false);
insert_page('Recherche', 'Recherche', '{{search}}', $lang, 'Admins', false, false);
insert_page('Connexion', 'Connexion', '{{login}}', $lang, 'Admins', false, false);
insert_page('Préférences', 'Préférences', '{{usersettings}}', $lang, 'Admins', false, false);

?>
