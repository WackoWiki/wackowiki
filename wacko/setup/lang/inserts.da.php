<?php

$lng = "da";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Velkommen til din ((WackoWiki:Doc/English/WackoWiki WackoWiki)) installation!**\n\nKlik på \"Rediger siden\" linket nederst for at rette denne side.\n\nDokumentation finder du på WackoWiki:Doc/English.\n\nSærlige wikisider: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, ((Søgning)), MyPages, MyChanges.\n\n", $lng, "Admins", true);
	insert_page('WantedPages', 'Wanted Pages', '{{WantedPages}}', $lng, "Admins", true);
	insert_page('OrphanedPages', 'Orphaned Pages', '{{OrphanedPages}}', $lng, "Admins", true);
	insert_page('MineSider', 'Mine Sider', '{{MyPages}}', $lng, "Admins", true);
	insert_page('MineOpdateringer', 'Mine Opdateringer', '{{MyChanges}}', $lng, "Admins", true);
}

insert_page('Opdateringer', 'Opdateringer', '{{RecentChanges}}', $lng);
insert_page('Kommentarer', 'Kommentarer', '{{RecentlyCommented}}', $lng);
insert_page('Indhold', 'Indhold', '{{PageIndex}}', $lng);
insert_page('Brugere', 'Brugere', '{{LastUsers}}', $lng);
insert_page('Registrering', 'Registrering', '{{Registration}}', $lng);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng);
insert_page('Søgning', 'Søgning', '{{Search}}', $lng);
insert_page('Login', 'Login', '{{Login}}', $lng);
insert_page('Indstillinger', 'Indstillinger', '{{UserSettings}}', $lng);

?>