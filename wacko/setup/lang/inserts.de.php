<?php

$lng = "de";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Willkommen zu Deiner ((WackoWiki:Doc/Deutsch/WackoWiki WackoWiki)) Installation!**\n\nKlicke nach der ((Anmeldung)) unten auf den Punkt \"Editieren\" um zu beginnen.\n\nDie Dokumentation ist unter WackoWiki:Doc/Deutsch zu finden.\n\nNützliche Seiten: ((WackoWiki:Doc/Deutsch/Formatierung Formatierung)), VerwaisteSeiten, OffeneSeiten, TextSuche, MeineSeiten, MeineAenderungen.\n\n", $lng, 'Admins', true, false);
	insert_page('OffeneSeiten', 'Offene Seiten', '{{wanted}}', $lng, 'Admins', true, false);
	insert_page('VerwaisteSeiten', 'Verwaiste Seiten', '{{orphaned}}', $lng, 'Admins', true, false);
	insert_page('MeineSeiten', 'Meine Seiten', '{{MyPages}}', $lng, 'Admins', true, false);
	insert_page('MeineAenderungen', 'Meine Änderungen', '{{MyChanges}}', $lng, 'Admins', true, false);
}

insert_page('LetzteAenderungen', 'Letzte Änderungen', '{{changes}}', $lng, 'Admins', false, true, 'Änderungen');
insert_page('LetzteKommentare', 'Letzte Kommentare', '{{RecentlyCommented}}', $lng, 'Admins', false, true, 'Kommentare');
insert_page('SeitenIndex', 'Seiten Index', '{{PageIndex}}', $lng, 'Admins', false, true, 'Index');

insert_page('Benutzer', 'Benutzer', '{{LastUsers}}', $lng, 'Admins', false, false);
insert_page('Registrierung', 'Registrierung', '{{Registration}}', $lng, 'Admins', false, false);

insert_page('Passwort', 'Passwort', '{{ChangePassword}}', $lng, 'Admins', false, false);
insert_page('TextSuche', 'TextSuche', '{{Search}}\n\n\n  * ++4 Buchstaben Minimum für die Suche im Text der Seiten. Das ist eine ~MySQL Beschränkung.++\n  * ++3 Buchstaben Minimum für die Suche in Seitennamen.++\n  * ++Bei der Suche im Text verwenden wir die Volltextsuche Funktion von ~MySQL. Es wird  nur nach ganzen Worten gesucht.++\n\n', $lng, 'Admins', false, false);
insert_page('Anmeldung', 'Anmeldung', '{{Login}}', $lng, 'Admins', false, false);
insert_page('Einstellungen', 'Einstellungen', '{{UserSettings}}', $lng, 'Admins', false, false);

?>