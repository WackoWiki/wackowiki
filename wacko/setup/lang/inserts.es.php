<?php

$lang = 'es';

// insert these pages only for default language
if ($config['language'] == $lang)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Bienvenida a tu ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nDa click en el enlace \"Editar esta pagina\" abajo en la pagina para empezar.\n\nLa documentación se puede encontrar en WackoWiki:Doc/English.\n\nPaginas útiles: ((WackoWiki:Doc/English/Formatting Formatting)), ((Buscar)).\n\n", $lang, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lang, $config['admin_name'], true, false);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Category', '{{category}}', $lang, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lang, 'Admins', false, false);
	insert_page('Groups', 'Groups', '{{groups}}', $lang, 'Admins', false, false);
	insert_page('Users', 'Usuarios', '{{users}}', $lang, 'Admins', false, false);
}

insert_page('UltimasModificaciones', 'Ultimas Modificaciones', '{{changes}}', $lang, 'Admins', false, true, 'Modificaciones');
insert_page('UltimosCommentarios', 'Ultimos Commentarios', '{{commented}}', $lang, 'Admins', false, true, 'Commentarios');
insert_page('IndiceDePaginas', 'Indice De Paginas', '{{pageindex}}', $lang, 'Admins', false, true, 'Indice');

insert_page('Registrarse', 'Registrarse', '{{registration}}', $lang, 'Admins', false, false);

insert_page('Password', 'Password', '{{changepassword}}', $lang, 'Admins', false, false);
insert_page('Buscar', 'Buscar', '{{search}}', $lang, 'Admins', false, false);
insert_page('Conectar', 'Conectar', '{{login}}', $lang, 'Admins', false, false);
insert_page('Preferencias', 'Preferencias', '{{usersettings}}', $lang, 'Admins', false, false);

?>