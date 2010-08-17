<?php

$lng = "pl";

if ($config['language'] == $lng)
{
	InsertPage($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Witaj na swojej stronie ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nKlinkij na link \"Edytuj stronê\" na dole by rozpocz±æ.\n\nDokumentacja dostêpna jest w WackoWiki:Doc/English.\n\nPrzydatne strony: ((WackoWiki:Doc/English/Formatting Formatting)), OsieroconeStrony, PotrzebneStrony, TextSearch, MojeStrony, MojeZmiany.\n\n", $lng, "Admins", true);
	InsertPage('PotrzebneStrony', 'Potrzebne Strony', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('OsieroconeStrony', 'Osierocone Strony', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MojeStrony', 'Moje Strony', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MojeZmiany', 'Moje Zmiany', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('OstatnieZmiany', 'Ostatnie Zmiany', '{{RecentChanges}}', $lng);
InsertPage('OstatnioKomentowane', 'Ostatnio Komentowane', '{{RecentlyCommented}}', $lng);
InsertPage('IndexStron', 'Index Stron', '{{PageIndex}}', $lng);
InsertPage('U¿ytkownicy', 'U¿ytkownicy', '{{LastUsers}}', $lng);
InsertPage('Rejestracja', 'Rejestracja', '{{Registration}}', $lng);

InsertPage('Password', 'Password', '{{ChangePassword}}', $lng);
InsertPage('TextSearch', 'Text Search', '{{Search}}', $lng);
InsertPage('Login', 'Login', '{{Login}}', $lng);
InsertPage('Ustawienia', 'Ustawienia', '{{UserSettings}}', $lng);

?>