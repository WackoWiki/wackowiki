<?php

$lng = "de";

// insert these pages only for default language
if ($config['language'] == $lng)
{
	if ($config['is_update'] == false)
	{
		insert_page($config['root_page'], '', "((file:wacko_logo.png WackoWiki))\n**Willkommen zu Deiner ((WackoWiki:Doc/Deutsch/WackoWiki WackoWiki)) Installation!**\n\nKlicke nach der ((Anmeldung)) unten auf den Punkt \"Editieren\" um zu beginnen.\n\nDie Dokumentation ist unter WackoWiki:Doc/Deutsch zu finden.\n\nNützliche Seiten: ((WackoWiki:Doc/Deutsch/Formatierung Formatierung)), TextSuche.\n\n", $lng, 'Admins', true, false);
		insert_page($config['users_page'].'/'.$config['admin_name'], $config['admin_name'], "::+::\n\n", $lng, $config['admin_name'], true, false);
	}
	else
	{
		insert_page($config['users_page'].'/'.$config['admin_name'].'/MigrateDataToR50', 'Migrate Data to R5.0', "{{adminupdate}}\n\n", $lng, $config['admin_name'], true, false);
	}

	#insert_page('OffeneSeiten', 'Offene Seiten', '{{wanted}}', $lng, 'Admins', true, false);
	#insert_page('VerwaisteSeiten', 'Verwaiste Seiten', '{{orphaned}}', $lng, 'Admins', true, false);
	#insert_page('MeineSeiten', 'Meine Seiten', '{{mypages}}', $lng, 'Admins', true, false);
	#insert_page('MeineAenderungen', 'Meine Änderungen', '{{mychanges}}', $lng, 'Admins', true, false);

	insert_page('Category', 'Kategorie', '{{category}}', $lng, 'Admins', false, false);
	insert_page('Permalink', 'Permalink', '{{permalinkproxy}}', $lng, 'Admins', false, false);
	insert_page('Groups', 'Gruppen', '{{usergroups}}', $lng, 'Admins', false, false);
	insert_page('Users', 'Benutzer', '{{users}}', $lng, 'Admins', false, false);
}

insert_page('LetzteAenderungen', 'Letzte Änderungen', '{{changes}}', $lng, 'Admins', false, true, 'Änderungen');
insert_page('LetzteKommentare', 'Letzte Kommentare', '{{commented}}', $lng, 'Admins', false, true, 'Kommentare');
insert_page('SeitenIndex', 'Seiten Index', '{{pageindex}}', $lng, 'Admins', false, true, 'Index');

insert_page('Registrierung', 'Registrierung', '{{registration}}', $lng, 'Admins', false, false);

insert_page('Passwort', 'Passwort', '{{changepassword}}', $lng, 'Admins', false, false);
insert_page('TextSuche', 'TextSuche', '{{search}}\n\n\n  * ++4 Buchstaben Minimum für die Suche im Text der Seiten. Das ist eine ~MySQL Beschränkung.++\n  * ++3 Buchstaben Minimum für die Suche in Seitennamen.++\n  * ++Bei der Suche im Text verwenden wir die Volltextsuche Funktion von ~MySQL. Es wird  nur nach ganzen Worten gesucht.++\n\n', $lng, 'Admins', false, false);
insert_page('Anmeldung', 'Anmeldung', '{{login}}', $lng, 'Admins', false, false);
insert_page('Einstellungen', 'Einstellungen', '{{usersettings}}', $lng, 'Admins', false, false);

?>