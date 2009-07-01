<?php
$lng = "pl";

if ($config["language"] == $lng)
{
	InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Witaj na swojej stronie ((WackoWiki:Doc/English/WackoWiki WackoWiki))!**\n\nKlinkij na link \"Edytuj stronê\" na dole by rozpocz±æ.\n\nDokumentacja dostêpna jest w WackoWiki:Doc/English.\n\nPrzydatne strony: ((WackoWiki:Doc/English/Formatting Formatting)), OsieroconeStrony, PotrzebneStrony, TextSearch, MojeStrony, MojeZmiany.\n\n", $lng, "Admins", true);
	InsertPage('PotrzebneStrony', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('OsieroconeStrony', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MojeStrony', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MojeZmiany', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('OstatnieZmiany', '{{RecentChanges}}', $lng);
InsertPage('OstatnioKomentowane', '{{RecentlyCommented}}', $lng);
InsertPage('IndexStron', '{{PageIndex}}', $lng);
InsertPage('U¿ytkownicy', '{{LastUsers}}', $lng);
InsertPage('Rejestracja', '{{Registration}}', $lng);

InsertPage('Password', '{{ChangePassword}}', $lng);
InsertPage('TextSearch', '{{Search}}', $lng);
InsertPage('Login', '{{Login}}', $lng);
InsertPage('Settings', '{{UserSettings}}', $lng);

InsertPage('InterWiki', '{{InterWikiList}}', $lng);
?>