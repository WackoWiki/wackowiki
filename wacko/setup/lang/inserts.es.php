<?php

$page_lang = 'es';

// insert these pages only for default language
if ($config['language'] == $page_lang)
{
	if ($config['is_update'] == false)
	{
		$home_page_body		= "file:wacko_logo.png\n**Bienvenida a tu ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nDa click en el enlace \"Editar esta pagina\" abajo en la pagina para empezar.\n\nLa documentación se puede encontrar en WackoWiki:Doc/English.\n\nPaginas útiles: ((WackoWiki:Doc/English/Formatting Formatting)), ((Buscar)).\n\n";
		$admin_page_body	= sprintf($config['name_date_macro'], '((user:'.$config['admin_name'].' '.$config['admin_name'].'))', date($config['date_macro_format']));

		insert_page($config['root_page'], '', $home_page_body, $page_lang, 'Admins', true, false, null, 0);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], $admin_page_body."\n\n", $page_lang, $config['admin_name'], true, false, null, 0);
	}
	else
	{
		// ...
	}

	insert_page('Category',		'Category',		'{{category}}',			$page_lang, 'Admins', false, false);
	insert_page('Permalink',	'Permalink',	'{{permalinkproxy}}',	$page_lang, 'Admins', false, false);
	insert_page('Groups',		'Groups',		'{{groups}}',			$page_lang, 'Admins', false, false);
	insert_page('Users',		'Usuarios',		'{{users}}',			$page_lang, 'Admins', false, false);
}

insert_page('UltimasModificaciones',	'Ultimas Modificaciones',	'{{changes}}',			$page_lang, 'Admins', false, true, 'Modificaciones');
insert_page('UltimosCommentarios',		'Ultimos Commentarios',		'{{commented}}',		$page_lang, 'Admins', false, true, 'Commentarios');
insert_page('IndiceDePaginas',			'Indice De Paginas',		'{{pageindex}}',		$page_lang, 'Admins', false, true, 'Indice');

insert_page('Registrarse',				'Registrarse',				'{{registration}}',		$page_lang, 'Admins', false, false);
insert_page('Password',					'Password',					'{{changepassword}}',	$page_lang, 'Admins', false, false);
insert_page('Buscar',					'Buscar',					'{{search}}',			$page_lang, 'Admins', false, false);
insert_page('Conectar',					'Conectar',					'{{login}}',			$page_lang, 'Admins', false, false);
insert_page('Preferencias',				'Preferencias',				'{{usersettings}}',		$page_lang, 'Admins', false, false);

?>