<?php

$lng = "de";

if ($config['language'] == $lng)
{
	insert_page($config['root_page'], '', "((file:wacko4.png WackoWiki))\n**Willkommen zu Deiner ((WackoWiki:Doc/Deutsch/WackoWiki WackoWiki)) Installation!**\n\nKlicke nach der ((Anmeldung)) unten auf den Punkt \"Editieren\" um zu beginnen.\n\nDie Dokumentation ist unter WackoWiki:Doc/Deutsch zu finden.\n\nNützliche Seiten: ((WackoWiki:Doc/Deutsch/Formatierung Formatierung)), VerwaisteSeiten, OffeneSeiten, TextSuche, MeineSeiten, MeineAenderungen.\n\n", $lng, "Admins", true);
	insert_page('OffeneSeiten', 'Offene Seiten', '{{WantedPages}}', $lng, "Admins", true);
	insert_page('VerwaisteSeiten', 'Verwaiste Seiten', '{{OrphanedPages}}', $lng, "Admins", true);
	insert_page('MeineSeiten', 'Meine Seiten', '{{MyPages}}', $lng, "Admins", true);
	insert_page('MeineAenderungen', 'Meine Änderungen', '{{MyChanges}}', $lng, "Admins", true);
}

insert_page('LetzteAenderungen', 'Letzte Änderungen', '{{RecentChanges}}', $lng);
insert_page('LetzteKommentare', 'Letzte Kommentare', '{{RecentlyCommented}}', $lng);
insert_page('SeitenIndex', 'Seiten Index', '{{PageIndex}}', $lng);
insert_page('Benutzer', 'Benutzer', '{{LastUsers}}', $lng);
insert_page('Registrierung', 'Registrierung', '{{Registration}}', $lng);

insert_page('Passwort', 'Passwort', '{{ChangePassword}}', $lng);
insert_page('TextSuche', 'TextSuche', '{{Search}}\n\n\n  * ++4 Buchstaben Minimum für die Suche im Text der Seiten. Das ist eine ~MySQL Beschränkung.++\n  * ++3 Buchstaben Minimum für die Suche in Seitennamen.++\n  * ++Bei der Suche im Text verwenden wir die Volltextsuche Funktion von ~MySQL. Es wird  nur nach ganzen Worten gesucht.++\n\n', $lng);
insert_page('Anmeldung', 'Anmeldung', '{{Login}}', $lng);
insert_page('Einstellungen', 'Einstellungen', '{{UserSettings}}', $lng);

?>