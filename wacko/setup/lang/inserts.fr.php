<?php

$page_lang = 'fr';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Bienvenue sur votre wiki motorisé par ((WackoWiki:Doc/Français WackoWiki))!**' . "\n\n" .
			'Connectez-vous, puis cliquez sur le lien "Editer cette page" en bas à gauche pour commencer.' . "\n\n" .
			'Une documentation sommaire peut être trouvée ici : WackoWiki:Doc/Français.' . "\n" .
			'Pages utiles: ((WackoWiki:Doc/Français/MiseEnForme MiseEnForme)), ((Recherche)).' . "\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Page d\'accueil', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}

	insert_page($config['category_page'],		'Catégories',				'{{category}}',		$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'Groupes',					'{{groups}}',		$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'Utilisateurs',				'{{users}}',		$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'Aide',						'',					$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'Conditions d\'utilisation',		'',			$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'Politique de confidentialité',		'',			$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'Enregistrement',		'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Mot De Passe',			'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Recherche',			'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Connexion',			'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Préférences',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Modifications',		'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'Modifications');
	insert_page($config['comments_page'],		'Commentaires',			'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'Commentaires');
	insert_page($config['index_page'],			'Index',				'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'Index');
	insert_page($config['random_page'],			'Page au hasard',		'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'Au hasard');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Modifications');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Commentaires');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Index');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Au hasard');
}