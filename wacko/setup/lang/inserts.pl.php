<?php

$lng = "pl";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Witaj na swojej stronie ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nKlinkij na link \"Edytuj stronê\" na dole by rozpocz±æ.\n\nDokumentacja dostêpna jest w WackoWiki:Doc/English.\n\nPrzydatne strony: ((WackoWiki:Doc/English/Formatting Formatting)), OsieroconeStrony, PotrzebneStrony, TextSearch, MojeStrony, MojeZmiany.\n\n", $lng, 'Admins', true, false);
	insert_page('PotrzebneStrony', 'Potrzebne Strony', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('OsieroconeStrony', 'Osierocone Strony', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('MojeStrony', 'Moje Strony', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('MojeZmiany', 'Moje Zmiany', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('OstatnieZmiany', 'Ostatnie Zmiany', '{{changes}}', $lng, 'Admins', false, true, 'Zmiany');
insert_page('OstatnioKomentowane', 'Ostatnio Komentowane', '{{RecentlyCommented}}', $lng, 'Admins', false, true, 'Komentowane');
insert_page('IndexStron', 'Index Stron', '{{PageIndex}}', $lng, 'Admins', false, true, 'Index');

insert_page('U¿ytkownicy', 'U¿ytkownicy', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('Rejestracja', 'Rejestracja', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('TextSearch', 'Text Search', '{{Search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Ustawienia', 'Ustawienia', '{{UserSettings}}', $lng, 'Admins', false, false);

?>