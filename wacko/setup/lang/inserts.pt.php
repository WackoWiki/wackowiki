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
			'Clique depois de ter ((/Entrar entrado)) no link "Editar esta página" na parte inferior para começar.' . "\n\n" .
			'A documentação pode ser encontrada em WackoWiki:Doc/English.' . "\n" .
			'Páginas úteis: ((WackoWiki:Doc/English/Formatting Formatting)), ((/Buscar Buscar)).' . "\n\n";
		$admin_page_body	= '((user:' . $config['admin_name'] . ' ' . $config['admin_name'] . '))' . "\n\n";
		$admin_page			= $config['users_page'] . '/' . $config['admin_name'];

		$critical_pages = [
			$config['root_page']		=> ['Página inicial',		$home_page_body,		true, false, null, 0],
			$admin_page					=> [$config['admin_name'],	$admin_page_body,		true, false, null, 0],
		];
	}

	$pages = [
		$config['category_page']		=> ['Categoria',				'{{category}}',			false, false],
		$config['groups_page']			=> ['Grupos',					'{{groups}}',			false, false],
		$config['users_page']			=> ['Usuários',					'{{users}}',			false, false],

		# $config['help_page']			=> ['Ajuda',					'',						false, false],
		# $config['terms_page']			=> ['Condições de utilização',	'',						false, false],
		# $config['privacy_page']		=> ['Política de privacidade',	'',						false, false],

		$config['registration_page']	=> ['Criar conta',				'{{registration}}',		false, false],
		$config['password_page']		=> ['Password',					'{{changepassword}}',	false, false],
		$config['search_page']			=> ['Buscar',					'{{search}}',			false, false],
		$config['login_page']			=> ['Entrar',					'{{login}}',			false, false],
		$config['account_page']			=> ['Configurações',			'{{usersettings}}',		false, false],

		$config['changes_page']			=> ['Alterações Recentes',		'{{changes}}',			false, SET_MENU, 'Alterações'],
		$config['comments_page']		=> ['Recentemente Comentadas',	'{{commented}}',		false, SET_MENU, 'Comentadas'],
		$config['index_page']			=> ['Índicede Páginas',			'{{pageindex}}',		false, SET_MENU, 'Índicede'],
		$config['random_page']			=> ['Página aleatória',			'{{randompage}}',		false, SET_MENU, 'Aleatória'],
	];
}
else
{
	// set only bookmarks
	$pages = [
		$config['changes_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Alterações'],
		$config['comments_page']		=> ['',		'',		'', false, SET_MENU_ONLY, 'Comentadas'],
		$config['index_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Índicede'],
		$config['random_page']			=> ['',		'',		'', false, SET_MENU_ONLY, 'Aleatória'],
	];
}

if (!empty($critical_pages))
{
	$pages = array_merge($critical_pages, $pages);
}

insert_pages($pages, $page_lang);