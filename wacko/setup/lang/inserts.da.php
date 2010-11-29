<?php

$lng = "da";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Velkommen til din ((WackoWiki:Doc/English/WackoWiki WackoWiki)) installation!**\n\nKlik på \"Rediger siden\" linket nederst for at rette denne side.\n\nDokumentation finder du på WackoWiki:Doc/English.\n\nSærlige wikisider: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, ((Søgning)), MyPages, MyChanges.\n\n", $lng, 'Admins', true, false);
	insert_page('WantedPages', 'Wanted Pages', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('OrphanedPages', 'Orphaned Pages', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('MineSider', 'Mine Sider', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('MineOpdateringer', 'Mine Opdateringer', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('Opdateringer', 'Opdateringer', '{{changes}}', $lng, 'Admins', false, true, 'Opdateringer');
insert_page('Kommentarer', 'Kommentarer', '{{RecentlyCommented}}', $lng, 'Admins', false, true, 'Kommentarer');
insert_page('Indhold', 'Indhold', '{{PageIndex}}', $lng, 'Admins', false, true, 'Indhold');

insert_page('Brugere', 'Brugere', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('Registrering', 'Registrering', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('Søgning', 'Søgning', '{{Search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Indstillinger', 'Indstillinger', '{{UserSettings}}', $lng, 'Admins', false, false);

?>