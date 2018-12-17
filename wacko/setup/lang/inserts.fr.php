<?php

$page_lang = 'fr';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:/wacko_logo.png\n**Bienvenue sur votre wiki motoris� par ((WackoWiki:Doc/Francophone WackoWiki))!**\n\nConnectez-vous, puis cliquez sur le lien \"Editer cette page\" en bas � gauche pour commencer.\n\nUne documentation sommaire peut �tre trouv�e ici : WackoWiki:Doc/Francophone.\n\nPages utiles: ((WackoWiki:Doc/Francophone/MiseEnForme MiseEnForme)), ((Recherche)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Page d\'accueil', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body."\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page($config['category_page'],	'Cat�gories',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],		'Groupes',			'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],		'Utilisateurs',		'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],		'Aide',				'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],		'Conditions d\'utilisation',		'',		$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],	'Politique de confidentialit�',		'',		$page_lang, 'Admins', false, false);

	#insert_page('PageAuHasard',			'Page au hasard',	'{{randompage}}',		$page_lang, 'Admins', false, true, 'Au hasard');
}

insert_page('Modifications',	'Modifications',	'{{changes}}',			$page_lang, 'Admins', false, true, 'Modifications');
insert_page('Commentaires',		'Commentaires',		'{{commented}}',		$page_lang, 'Admins', false, true, 'Commentaires');
insert_page('Index',			'Index',			'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Index');

insert_page('Enregistrement',	'Enregistrement',	'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('MotDePasse',		'Mot De Passe',		'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('Recherche',		'Recherche',		'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('Connexion',		'Connexion',		'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Pr�f�rences',		'Pr�f�rences',		'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>
