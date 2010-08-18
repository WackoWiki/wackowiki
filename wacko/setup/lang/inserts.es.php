<?php

$lng = "es";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Bienvenida a tu ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nDa click en el enlace \"Editar esta pagina\" abajo en la pagina para empezar.\n\nLa documentación se puede encontrar en WackoWiki:Doc/English.\n\nPaginas útiles: ((WackoWiki:Doc/English/Formatting Formatting)), PaginasOrfelinas, PaginasBuscadas, ((Buscar)), MisPaginas, MisCambios.\n\n", $lng, "Admins", true);
	insert_page('PaginasBuscadas', 'Paginas Buscadas', '{{WantedPages}}', $lng, "Admins", true);
	insert_page('PaginasOrfelinas', 'Paginas Orfelinas', '{{OrphanedPages}}', $lng, "Admins", true);
	insert_page('MisPaginas', 'Mis Paginas', '{{MyPages}}', $lng, "Admins", true);
	insert_page('MisCambios', 'Mis Cambios', '{{MyChanges}}', $lng, "Admins", true);
}

insert_page('UltimasModificaciones', 'Ultimas Modificaciones', '{{RecentChanges}}', $lng);
insert_page('UltimosCommentarios', 'Ultimos Commentarios', '{{RecentlyCommented}}', $lng);
insert_page('IndiceDePaginas', 'Indice De Paginas', '{{PageIndex}}', $lng);
insert_page('Usuarios', 'Usuarios', '{{LastUsers}}', $lng);
insert_page('Registrarse', 'Registrarse', '{{Registration}}', $lng);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng);
insert_page('Buscar', 'Buscar', '{{Search}}', $lng);
insert_page('Conectar', 'Conectar', '{{Login}}', $lng);
insert_page('Preferencias', 'Preferencias', '{{UserSettings}}', $lng);

?>