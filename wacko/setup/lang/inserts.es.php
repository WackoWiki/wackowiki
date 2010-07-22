<?php

$lng = "es";

if ($config["language"] == $lng)
{
	InsertPage($config["root_page"], '', "((file:wacko4.png WackoWiki))\n**Bienvenida a tu ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nDa click en el enlace \"Editar esta pagina\" abajo en la pagina para empezar.\n\nLa documentación se puede encontrar en WackoWiki:Doc/English.\n\nPaginas útiles: ((WackoWiki:Doc/English/Formatting Formatting)), PaginasOrfelinas, PaginasBuscadas, ((Buscar)), MisPaginas, MisCambios.\n\n", $lng, "Admins", true);
	InsertPage('PaginasBuscadas', 'Paginas Buscadas', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('PaginasOrfelinas', 'Paginas Orfelinas', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MisPaginas', 'Mis Paginas', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MisCambios', 'Mis Cambios', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('UltimasModificaciones', 'Ultimas Modificaciones', '{{RecentChanges}}', $lng);
InsertPage('UltimosCommentarios', 'Ultimos Commentarios', '{{RecentlyCommented}}', $lng);
InsertPage('IndiceDePaginas', 'Indice De Paginas', '{{PageIndex}}', $lng);
InsertPage('Usuarios', 'Usuarios', '{{LastUsers}}', $lng);
InsertPage('Registrarse', 'Registrarse', '{{Registration}}', $lng);

InsertPage('Password', 'Password', '{{ChangePassword}}', $lng);
InsertPage('Buscar', 'Buscar', '{{Search}}', $lng);
InsertPage('Conectar', 'Conectar', '{{Login}}', $lng);
InsertPage('Preferencias', 'Preferencias', '{{UserSettings}}', $lng);

?>