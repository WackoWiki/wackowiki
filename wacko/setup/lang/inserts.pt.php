<?php

$page_lang = 'pt';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if (!$config['is_update'])
	{
		$home_page_body		=
			'file:/wacko_logo.png?right' . "\n" .
			'**Bem-vindo ao seu site ((WackoWiki:Doc/English WackoWiki))!**' . "\n\n" .
			'Clique depois de ter ((Entrar entrado)) no link "Editar esta página" na parte inferior para começar.' . "\n\n" .
			'A documentação pode ser encontrada em WackoWiki:Doc/English.' . "\n" .
			'Páginas úteis: ((WackoWiki:Doc/English/Formatting Formatting)), ((Buscar)).' . "\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))', date($config['date_format'] . ' ' . $config['time_format']));

		insert_page($config['root_page'], 'Página inicial', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'] . '/' . $config['admin_name'], $config['admin_name'], $admin_page_body . "\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}

	insert_page($config['category_page'],		'Categoria',				'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page($config['groups_page'],			'Grupos',					'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page($config['users_page'],			'Usuários',					'{{users}}',			$page_lang, 'Admins', false, false);

	insert_page($config['help_page'],			'Ajuda',					'',						$page_lang, 'Admins', false, false);
	insert_page($config['terms_page'],			'Condições de utilização',	'',						$page_lang, 'Admins', false, false);
	insert_page($config['privacy_page'],		'Política de privacidade',	'',						$page_lang, 'Admins', false, false);

	insert_page($config['registration_page'],	'Criar conta',				'{{registration}}',		$page_lang, 'Admins', false, false);
	insert_page($config['password_page'],		'Password',					'{{changepassword}}',	$page_lang, 'Admins', false, false);
	insert_page($config['search_page'],			'Buscar',					'{{search}}',			$page_lang, 'Admins', false, false);
	insert_page($config['login_page'],			'Entrar',					'{{login}}',			$page_lang, 'Admins', false, false);
	insert_page($config['account_page'],		'Configurações',			'{{usersettings}}',		$page_lang, 'Admins', false, false);

	insert_page($config['changes_page'],		'Alterações Recentes',		'{{changes}}',			$page_lang, 'Admins', false, SET_MENU, 'Alterações');
	insert_page($config['comments_page'],		'Recentemente Comentadas',	'{{commented}}',		$page_lang, 'Admins', false, SET_MENU, 'Comentadas');
	insert_page($config['index_page'],			'Índicede Páginas',			'{{pageindex}}',		$page_lang, 'Admins', false, SET_MENU, 'Índicede');
	insert_page($config['random_page'],			'Página aleatória',			'{{randompage}}',		$page_lang, 'Admins', false, SET_MENU, 'Aleatória');
}
else
{
	// set only bookmarks
	insert_page($config['changes_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Alterações');
	insert_page($config['comments_page'],		'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Comentadas');
	insert_page($config['index_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Índicede');
	insert_page($config['random_page'],			'',		'',		$page_lang, '', false, SET_MENU_ONLY, 'Aleatória');
}