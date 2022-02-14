<?php

$page_lang = 'es';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Bienvenida a tu ((WackoWiki:Doc/English WackoWiki))!**' . "\n\n" .
			'Da click en el enlace "Editar esta pagina" abajo en la pagina para empezar.' . "\n\n" .
			'La documentación se puede encontrar en WackoWiki:Doc/English.' . "\n" .
			'Paginas útiles: ((WackoWiki:Doc/Español/ReglasFormato Formatting)), ((/Buscar Buscar)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Página de inicio',		$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Categoría',				'{{category}}',			false, false],
		$config['groups_page']			=> ['Grupos',					'{{groups}}',			false, false],
		$config['users_page']			=> ['Usuarios',					'{{users}}',			false, false],

		# $config['help_page']			=> ['Ayuda',					'',						false, false],
		# $config['terms_page']			=> ['Terms',					'',						false, false],
		# $config['privacy_page']		=> ['Normativa de privacidad',	'',						false, false],

		$config['registration_page']	=> ['Registrarse',				'{{registration}}',		false, false],
		$config['password_page']		=> ['Password',					'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Buscar',					'{{search}}',			false, false],
		$config['login_page']			=> ['Conectar',					'{{login}}',			false, false],
		$config['account_page']			=> ['Preferencias',				'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Ultimas Modificaciones',	'{{changes}}',			false, SET_MENU, 'Modificaciones'],
		$config['comments_page']		=> ['Ultimos Comentarios',		'{{commented}}',		false, SET_MENU, 'Comentarios'],
		$config['index_page']			=> ['Indice De Paginas',		'{{pageindex}}',		false, SET_MENU, 'Indice'],
		$config['random_page']			=> ['Página aleatoria',			'{{randompage}}',		false, SET_MENU, 'Aleatoria'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Modificaciones'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Comentarios'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Indice'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Aleatoria'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);