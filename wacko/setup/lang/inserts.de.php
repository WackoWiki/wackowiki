<?php

$lng = 'de';

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Willkommen zu Deiner ((WackoWiki:Doc/Deutsch/WackoWiki WackoWiki)) Installation!**\n\nKlicke nach der ((Anmeldung)) unten auf den Punkt \"Editieren\" um zu beginnen.\n\nDie Dokumentation ist unter WackoWiki:Doc/Deutsch zu finden.\n\nNützliche Seiten: ((WackoWiki:Doc/Deutsch/Formatierung Formatierung)), ((Suche)).\n\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::@::\n\n", $lng, $config['admin_name'], true, false);
	}
	else
	{
		// ...
	}

	insert_page('Category', 'Kategorie', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Gruppen', '{{groups}}', $lng, 'Admins', false, false);
	insert_page('Users', 'Benutzer', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('LetzteAenderungen', 'Letzte Änderungen', '{{changes}}', $lng, 'Admins', false, true, 'Änderungen');
insert_page('LetzteKommentare', 'Letzte Kommentare', '{{commented}}', $lng, 'Admins', false, true, 'Kommentare');
insert_page('SeitenIndex', 'Seiten Index', '{{pageindex}}', $lng, 'Admins', false, true, 'Index');

insert_page('Registrierung', 'Registrierung', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Passwort', 'Passwort', '{{changepassword}}', $lng, 'Admins', false, false);
insert_page('Suche', 'Suche', '{{search}}\n\n\n  * ++4 Buchstaben Minimum für die Suche im Text der Seiten. Das ist eine ~MySQL Beschränkung.++\n  * ++3 Buchstaben Minimum für die Suche in Seitennamen.++\n  * ++Bei der Suche im Text wird die Volltextsuche Funktion von ~MySQL verwendet. Es wird nur nach ganzen Worten gesucht.++\n\n', $lng, 'Admins', false, false);
insert_page('Anmeldung', 'Anmeldung', '{{login}}', $lng, 'Admins', false, false);
insert_page('Einstellungen', 'Einstellungen', '{{usersettings}}', $lng, 'Admins', false, false);

?>