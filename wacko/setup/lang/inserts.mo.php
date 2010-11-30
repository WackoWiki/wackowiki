<?php

$lng = "mo";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], 'Home Page', "((file:wacko4.png WackoWiki))\n**Welcome to your ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site!**\n\nClick after you have ((login logged in)) on the \"Edit this page\" link at the bottom to get started.\n\nDocumentation can be found at WackoWiki:Doc/English.\n\nUseful pages: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng, 'Admins', true, false);
	insert_page('WantedPages', 'Wanted Pages', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('OrphanedPages', 'Orphaned Pages', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('MyPages', 'My Pages', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('MyChanges', 'My Changes', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('RecentChanges', 'Recent Changes', '{{changes}}', $lng, 'Admins', false, true, 'Changes');
insert_page('RecentlyCommented', 'Recently Commented', '{{RecentlyCommented}}', $lng, 'Admins', false, true, 'Comments');
insert_page('PageIndex', 'Page Index', '{{PageIndex}}', $lng, 'Admins', false, true, 'Index');

insert_page('Users', 'Users', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('Registration', 'Registration', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('TextSearch', 'Text Search', '{{Search}}', $lng, 'Admins', false, false);
insert_page('Login', 'Login', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Settings', 'Settings', '{{UserSettings}}', $lng, 'Admins', false, false);

?>