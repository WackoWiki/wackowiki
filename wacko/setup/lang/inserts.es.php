<?php
$lng = "es";

if ($config["language"] == $lng)
{
	InsertPage($config["root_page"], "((file:wacko4.png WackoWiki))\n**Bienvenida a tu ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nDa click en el enlace \"Editar esta pagina\" abajo en la pagina para empezar.\n\nLa documentación se puede encontrar en WackoWiki:Doc/English.\n\nPaginas útiles: ((WackoWiki:Doc/English/Formatting Formatting)), PaginasOrfelinas, PaginasBuscadas, ((Buscar)), MisPaginas, MisCambios.\n\n", $lng, "Admins", true);
	InsertPage('PaginasBuscadas', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('PaginasOrfelinas', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MisPaginas', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MisCambios', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('UltimasModificaciones', '{{RecentChanges}}', $lng);
InsertPage('UltimosCommentarios', '{{RecentlyCommented}}', $lng);
InsertPage('IndiceDePaginas', '{{PageIndex}}', $lng);
InsertPage('Usuarios', '{{LastUsers}}', $lng);
InsertPage('Registrarse', '{{Registration}}', $lng);

InsertPage('Password', '{{ChangePassword}}', $lng);
InsertPage('Buscar', '{{Search}}', $lng);
InsertPage('Conectar', '{{Login}}', $lng);
InsertPage('Preferencias', '{{UserSettings}}', $lng);

InsertPage('InterWiki', '{{InterWikiList}}', $lng);
?>