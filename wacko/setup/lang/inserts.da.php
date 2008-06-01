<?php
$lng = "da";

if ($config["language"]==$lng)
{
 InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Velkommen til din ((WackoWiki:WackoWiki WackoWiki)) installation!**\n\nKlik p� \"Rediger siden\" linket nederst for at rette denne side.\n\nDokumentation finder du p� WackoWiki:DocEnglish.\n\nS�rlige wikisider: OrphanedPages, WantedPages, ((S�gning)), MyPages, MyChanges.\n\n", $lng);
 InsertPage('WantedPages', '{{WantedPages}}', $lng);
 InsertPage('OrphanedPages', '{{OrphanedPages}}', $lng);
 InsertPage('MineSider', '{{MyPages}}', $lng);
 InsertPage('MineOpdateringer', '{{MyChanges}}', $lng);
}

InsertPage('Opdateringer', '{{RecentChanges}}', $lng);
InsertPage('Kommentarer', '{{RecentlyCommented}}', $lng);
InsertPage('Indhold', '{{PageIndex}}', $lng);
InsertPage('Brugere', '{{LastUsers}}', $lng);
InsertPage('Registration', '{{Registration}}', $lng);

InsertPage('Password', '{{ChangePassword}}', $lng);
InsertPage('S�gning', '{{Search}}', $lng);
InsertPage('Login', '{{Login}}', $lng);
InsertPage('Indstillinger', '{{UserSettings}}', $lng);

InsertPage('InterWiki', '{{InterWikiList}}', $lng);
?>