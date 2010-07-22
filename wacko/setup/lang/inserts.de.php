<?php

$lng = "de";

if ($config["language"] == $lng)
{
	InsertPage($config["root_page"], '', "((file:wacko4.png WackoWiki))\n**Willkommen zu Deiner ((WackoWiki:Doc/Deutsch/WackoWiki WackoWiki)) Installation!**\n\nKlicke nach der ((Anmeldung)) unten auf den Punkt \"Editieren\" um zu beginnen.\n\nDie Dokumentation ist unter WackoWiki:Doc/Deutsch zu finden.\n\nNützliche Seiten: ((WackoWiki:Doc/Deutsch/Formatierung Formatierung)), VerwaisteSeiten, OffeneSeiten, TextSuche, MeineSeiten, MeineAenderungen.\n\n", $lng, "Admins", true);
	InsertPage('OffeneSeiten', 'Offene Seiten', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('VerwaisteSeiten', 'Verwaiste Seiten', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MeineSeiten', 'Meine Seiten', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MeineAenderungen', 'Meine Änderungen', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('LetzteAenderungen', 'Letzte Änderungen', '{{RecentChanges}}', $lng);
InsertPage('LetzteKommentare', 'Letzte Kommentare', '{{RecentlyCommented}}', $lng);
InsertPage('SeitenIndex', 'Seiten Index', '{{PageIndex}}', $lng);
InsertPage('Benutzer', 'Benutzer', '{{LastUsers}}', $lng);
InsertPage('Registrierung', 'Registrierung', '{{Registration}}', $lng);

InsertPage('Passwort', 'Passwort', '{{ChangePassword}}', $lng);
InsertPage('TextSuche', 'TextSuche', '{{Search}}\n\n\n  * ++4 Buchstaben Minimum für die Suche im Text der Seiten. Das ist eine ~MySQL Beschränkung.++\n  * ++3 Buchstaben Minimum für die Suche in Seitennamen.++\n  * ++Bei der Suche im Text verwenden wir die Volltextsuche Funktion von ~MySQL. Es wird  nur nach ganzen Worten gesucht.++\n\n', $lng);
InsertPage('Anmeldung', 'Anmeldung', '{{Login}}', $lng);
InsertPage('Einstellungen', 'Einstellungen', '{{UserSettings}}', $lng);

?>