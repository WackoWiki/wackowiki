<?php
$lng = "es";

if ($config["language"]==$lng)
{
 InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Bienvenida a tu ((WackoWiki:WackoWiki WackoWiki))!**\n\nDa click en el enlace \"Editar esta pagina\" abajo en la pagina para empezar.\n\nLa documentación se puede encontrar en WackoWiki:DocEnglish.\n\nPaginas útiles: PaginasOrfelinas, PaginasBuscadas, ((Buscar)), MisPaginas, MisCambios.\n\n", $lng);
 InsertPage('PaginasBuscadas', '{{WantedPages}}', $lng);
 InsertPage('PaginasOrfelinas', '{{OrphanedPages}}', $lng);
 InsertPage('MisPaginas', '{{MyPages}}', $lng);
 InsertPage('MisCambios', '{{MyChanges}}', $lng);
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