<?php

$lng = "pl";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Witaj na swojej stronie ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nKlinkij na link \"Edytuj stronê\" na dole by rozpocz±æ.\n\nDokumentacja dostêpna jest w WackoWiki:Doc/English.\n\nPrzydatne strony: ((WackoWiki:Doc/English/Formatting Formatting)), OsieroconeStrony, PotrzebneStrony, TextSearch, MojeStrony, MojeZmiany.\n\n", $lng, "Admins", true);
	insert_page('PotrzebneStrony', 'Potrzebne Strony', '{{WantedPages}}', $lng, "Admins", true);
	insert_page('OsieroconeStrony', 'Osierocone Strony', '{{OrphanedPages}}', $lng, "Admins", true);
	insert_page('MojeStrony', 'Moje Strony', '{{MyPages}}', $lng, "Admins", true);
	insert_page('MojeZmiany', 'Moje Zmiany', '{{MyChanges}}', $lng, "Admins", true);
}

insert_page('OstatnieZmiany', 'Ostatnie Zmiany', '{{RecentChanges}}', $lng);
insert_page('OstatnioKomentowane', 'Ostatnio Komentowane', '{{RecentlyCommented}}', $lng);
insert_page('IndexStron', 'Index Stron', '{{PageIndex}}', $lng);
insert_page('U¿ytkownicy', 'U¿ytkownicy', '{{LastUsers}}', $lng);
insert_page('Rejestracja', 'Rejestracja', '{{Registration}}', $lng);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng);
insert_page('TextSearch', 'Text Search', '{{Search}}', $lng);
insert_page('Login', 'Login', '{{Login}}', $lng);
insert_page('Ustawienia', 'Ustawienia', '{{UserSettings}}', $lng);

?>