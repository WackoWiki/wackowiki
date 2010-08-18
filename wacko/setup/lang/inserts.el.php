<?php

$lng = "el";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Καλώς ήλθατε στο ((WackoWiki:Doc/English/WackoWiki WackoWiki)) site σας!**\n\nΠατήστε στον σύνδεμο \"Επεξεργασία Σελίδας\" στο κάτω μέρος της σελίδας για να ξεκινήσετε.\n\nΗ τεκμηρίωση μπορεί να βρεθεί στο WackoWiki:Doc/English.\n\nΧρήσιμες Σελίδες: ((WackoWiki:Doc/English/Formatting Formatting)), OrphanedPages, WantedPages, TextSearch, MyPages, MyChanges.\n\n", $lng, "Admins", true);
	insert_page('WantedPages', 'Wanted Pages', '{{WantedPages}}', $lng, "Admins", true);
	insert_page('OrphanedPages', 'Orphaned Pages', '{{OrphanedPages}}', $lng, "Admins", true);
	insert_page('MyPages', 'My Pages', '{{MyPages}}', $lng, "Admins", true);
	insert_page('MyChanges', 'My Changes', '{{MyChanges}}', $lng, "Admins", true);
}

insert_page('RecentChanges', 'Recent Changes', '{{RecentChanges}}', $lng);
insert_page('RecentlyCommented', 'Recently Commented', '{{RecentlyCommented}}', $lng);
insert_page('PageIndex', 'Page Index', '{{PageIndex}}', $lng);
insert_page('Users', 'Users', '{{LastUsers}}', $lng);
insert_page('Registration', 'Registration', '{{Registration}}', $lng);

insert_page('Password', 'Password', '{{ChangePassword}}', $lng);
insert_page('TextSearch', 'Text Search', '{{Search}}', $lng);
insert_page('Login', 'Login', '{{Login}}', $lng);
insert_page('Settings', 'Settings', '{{UserSettings}}', $lng);

?>