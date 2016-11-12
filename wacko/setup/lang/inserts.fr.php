<?php

$page_lang = 'fr';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png\n**Bienvenue sur votre wiki motorisé par ((WackoWiki:HomePage WackoWiki))!**\n\nConnectez-vous, puis cliquez sur le lien \"Editer cette page\" en bas à gauche pour commencer.\n\nUne documentation sommaire peut être trouvée ici : WackoWiki:Doc/Francophone.\n\nPages utiles: ((WackoWiki:Doc/Francophone/MiseEnForme MiseEnForme)), ((Recherche)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_macro_format']));

		insert_page($config['root_page'], 'Page d\'accueil', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body."\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Catégories',	'Catégories',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page('Groups',		'Groups',			'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page('Utilisateurs',	'Utilisateurs',		'{{users}}',			$page_lang, 'Admins', false, false);
}

insert_page('Modifications',	'Modifications',	'{{changes}}',			$page_lang, 'Admins', false, true, 'Modifications');
insert_page('Commentaires',		'Commentaires',		'{{commented}}',		$page_lang, 'Admins', false, true, 'Commentaires');
insert_page('Index',			'Index',			'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Index');

insert_page('Enregistrement',	'Enregistrement',	'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('MotDePasse',		'Mot De Passe',		'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('Recherche',		'Recherche',		'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('Connexion',		'Connexion',		'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Préférences',		'Préférences',		'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>
