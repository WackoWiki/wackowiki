<?php

$page_lang = 'fr';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Bienvenue sur votre wiki motorisé par ((WackoWiki:Doc/Français WackoWiki))!**' . "\n\n" .
			'Connectez-vous, puis cliquez sur le lien "Editer cette page" en bas à gauche pour commencer.' . "\n\n" .
			'Une documentation sommaire peut être trouvée ici : WackoWiki:Doc/Français.' . "\n" .
			'Pages utiles: ((WackoWiki:Doc/Français/MiseEnForme MiseEnForme)), ((/Recherche Recherche)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Page d\'accueil',		$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Catégories',				'{{category}}',		false, false],
		$config['groups_page']			=> ['Groupes',					'{{groups}}',		false, false],
		$config['users_page']			=> ['Utilisateurs',				'{{users}}',		false, false],

		# $config['help_page']			=> ['Aide',						'',					false, false],
		# $config['terms_page']			=> ['Conditions d\'utilisation',		'',			false, false],
		# $config['privacy_page']		=> ['Politique de confidentialité',		'',			false, false],

		$config['registration_page']	=> ['Enregistrement',		'{{registration}}',		false, false],
		$config['password_page']		=> ['Mot De Passe',			'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Recherche',			'{{search}}',			false, false],
		$config['login_page']			=> ['Connexion',			'{{login}}',			false, false],
		$config['account_page']			=> ['Préférences',			'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Modifications',		'{{changes}}',			false, SET_MENU, 'Modifications'],
		$config['comments_page']		=> ['Commentaires',			'{{commented}}',		false, SET_MENU, 'Commentaires'],
		$config['index_page']			=> ['Index',				'{{pageindex}}',		false, SET_MENU, 'Index'],
		$config['random_page']			=> ['Page au hasard',		'{{randompage}}',		false, SET_MENU, 'Au hasard'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Modifications'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Commentaires'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Index'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Au hasard'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);