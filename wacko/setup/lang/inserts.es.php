<?php

$lng = "es";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Bienvenida a tu ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nDa click en el enlace \"Editar esta pagina\" abajo en la pagina para empezar.\n\nLa documentación se puede encontrar en WackoWiki:Doc/English.\n\nPaginas útiles: ((WackoWiki:Doc/English/Formatting Formatting)), PaginasOrfelinas, PaginasBuscadas, ((Buscar)), MisPaginas, MisCambios.\n\n", $lng, 'Admins', true, false);
	insert_page('PaginasBuscadas', 'Paginas Buscadas', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('PaginasOrfelinas', 'Paginas Orfelinas', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('MisPaginas', 'Mis Paginas', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('MisCambios', 'Mis Cambios', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('UltimasModificaciones', 'Ultimas Modificaciones', '{{changes}}', $lng, 'Admins', false, true, 'Modificaciones');
insert_page('UltimosCommentarios', 'Ultimos Commentarios', '{{RecentlyCommented}}', $lng, 'Admins', false, true, 'Commentarios');
insert_page('IndiceDePaginas', 'Indice De Paginas', '{{PageIndex}}', $lng, 'Admins', false, true, 'Indice');

insert_page('Usuarios', 'Usuarios', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('Registrarse', 'Registrarse', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('Buscar', 'Buscar', '{{Search}}', $lng, 'Admins', false, false);
insert_page('Conectar', 'Conectar', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Preferencias', 'Preferencias', '{{UserSettings}}', $lng, 'Admins', false, false);

?>