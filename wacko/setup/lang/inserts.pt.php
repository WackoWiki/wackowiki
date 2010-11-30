<?php

$lng = "pt";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], 'Home Page', "((file:wacko4.png WackoWiki))\n**Welcome to your ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nClick after you have ((login logged in)) on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng, 'Admins', true, false);
	insert_page('WantedPages', 'Wanted Pages', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('OrphanedPages', 'Orphaned Pages', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('MyPages', 'My Pages', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('MyChanges', 'My Changes', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('AlteraçõesRecentes', 'Alterações Recentes', '{{changes}}', $lng, 'Admins', false, true, 'Alterações');
insert_page('RecentementeComentadas', 'Recentemente Comentadas', '{{RecentlyCommented}}', $lng, 'Admins', false, true, 'Comentadas');
insert_page('ÍndicedePáginas', 'Índicede Páginas', '{{PageIndex}}', $lng, 'Admins', false, true, 'Índicede');

insert_page('Users', 'Users', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('Registration', 'Registration', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('TextSearch', 'Text Search', '{{Search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{UserSettings}}', $lng, 'Admins', false, false);

?>