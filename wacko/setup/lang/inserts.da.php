<?php

$lng = "da";

if ($config["language"] == $lng)
{
	InsertPage($config["root_page"], '', "((file:wacko4.png WackoWiki))\n**Velkommen til din ((WackoWiki:Doc/English/WackoWiki WackoWiki)) installation!**\n\nKlik p� \"Rediger siden\" linket nederst for at rette denne side.\n\nDokumentation finder du p� WackoWiki:Doc/English.\n\nS�rlige wikisider: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, ((S�gning)), MyPages, MyChanges.\n\n", $lng, "Admins", true);
	InsertPage('WantedPages', 'Wanted Pages', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('OrphanedPages', 'Orphaned Pages', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MineSider', 'Mine Sider', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MineOpdateringer', 'Mine Opdateringer', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('Opdateringer', 'Opdateringer', '{{RecentChanges}}', $lng);
InsertPage('Kommentarer', 'Kommentarer', '{{RecentlyCommented}}', $lng);
InsertPage('Indhold', 'Indhold', '{{PageIndex}}', $lng);
InsertPage('Brugere', 'Brugere', '{{LastUsers}}', $lng);
InsertPage('Registrering', 'Registrering', '{{Registration}}', $lng);

InsertPage('Password', 'Password', '{{ChangePassword}}', $lng);
InsertPage('S�gning', 'S�gning', '{{Search}}', $lng);
InsertPage('Login', 'Login', '{{Login}}', $lng);
InsertPage('Indstillinger', 'Indstillinger', '{{UserSettings}}', $lng);

?>