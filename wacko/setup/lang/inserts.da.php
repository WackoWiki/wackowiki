<?php
$lng = "da";

if ($config["language"]==$lng)
{
	InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Velkommen til din ((WackoWiki:Doc/English/WackoWiki WackoWiki)) installation!**\n\nKlik på \"Rediger siden\" linket nederst for at rette denne side.\n\nDokumentation finder du på WackoWiki:Doc/English.\n\nSærlige wikisider: OrphanedPages, WantedPages, ((Søgning)), MyPages, MyChanges.\n\n", $lng, "Admins", true);
	InsertPage('WantedPages', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('OrphanedPages', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MineSider', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MineOpdateringer', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('Opdateringer', '{{RecentChanges}}', $lng);
InsertPage('Kommentarer', '{{RecentlyCommented}}', $lng);
InsertPage('Indhold', '{{PageIndex}}', $lng);
InsertPage('Brugere', '{{LastUsers}}', $lng);
InsertPage('Registration', '{{Registration}}', $lng);

InsertPage('Password', '{{ChangePassword}}', $lng);
InsertPage('Søgning', '{{Search}}', $lng);
InsertPage('Login', '{{Login}}', $lng);
InsertPage('Indstillinger', '{{UserSettings}}', $lng);

InsertPage('InterWiki', '{{InterWikiList}}', $lng);
?>