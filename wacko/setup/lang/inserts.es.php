<?php

$page_lang = 'es';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Bienvenida a tu ((WackoWiki:Doc/English WackoWiki))!**' . "\n\n" .
			'Da click en el enlace "Editar esta pagina" abajo en la pagina para empezar.' . "\n\n" .
			'La documentación se puede encontrar en WackoWiki:Doc/English.' . "\n" .
			'Paginas útiles: ((WackoWiki:Doc/English/Formatting Formatting)), ((Buscar)).' . "\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Página de inicio', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}

	insert_page($config['category_page'],		'Categoría',				'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'Grupos',					'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'Usuarios',					'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'Ayuda',					'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'Terms',					'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'Normativa de privacidad',	'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'Registrarse',				'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Password',					'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Buscar',					'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Conectar',					'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Preferencias',				'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Ultimas Modificaciones',	'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'Modificaciones');
	insert_page($config['comments_page'],		'Ultimos Comentarios',		'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'Comentarios');
	insert_page($config['index_page'],			'Indice De Paginas',		'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'Indice');
	insert_page($config['random_page'],			'Página aleatoria',			'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'Aleatoria');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Modificaciones');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Comentarios');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Indice');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Aleatoria');

}