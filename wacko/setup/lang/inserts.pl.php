<?php
$lng = "pl";

if ($config["language"]==$lng)
{
 InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Witaj na swojej stronie ((WackoWiki:WackoWiki WackoWiki))!**\n\nKlinkij na link \"Edytuj stronê\" na dole by rozpocz±æ.\n\nDokumentacja dostêpna jest w WackoWiki:DocEnglish.\n\nPrzydatne strony: OsieroconeStrony, PotrzebneStrony, TextSearch, MojeStrony, MojeZmiany.\n\n", $lng);
 InsertPage('PotrzebneStrony', '{{WantedPages}}', $lng);
 InsertPage('OsieroconeStrony', '{{OrphanedPages}}', $lng);
 InsertPage('MojeStrony', '{{MyPages}}', $lng);
 InsertPage('MojeZmiany', '{{MyChanges}}', $lng);
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