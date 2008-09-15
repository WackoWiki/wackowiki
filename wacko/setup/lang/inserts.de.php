<?php
$lng = "de";

if ($config["language"]==$lng)
{
	InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Willkommen zu Deiner ((WackoWiki:Doc/Deutsch/WackoWiki WackoWiki)) Installation!**\n\nKlicke nach der ((Anmeldung)) unten auf den Punkt \"Editieren\" um zu beginnen.\n\nDokumentation ist unter WackoWiki:Doc/Deutsch zu finden.\n\nNützliche Seiten: ((WackoWiki:Doc/Deutsch/Formatierung Formatierung)), VerwaisteSeiten, OffeneSeiten, TextSuche, MeineSeiten, MeineAenderungen.\n\n", $lng, "Admins", true);
	InsertPage('OffeneSeiten', '{{WantedPages}}', $lng, "Admins", true);
	InsertPage('VerwaisteSeiten', '{{OrphanedPages}}', $lng, "Admins", true);
	InsertPage('MeineSeiten', '{{MyPages}}', $lng, "Admins", true);
	InsertPage('MeineAenderungen', '{{MyChanges}}', $lng, "Admins", true);
}

InsertPage('LetzteAenderungen', '{{RecentChanges}}', $lng);
InsertPage('LetzteKommentare', '{{RecentlyCommented}}', $lng);
InsertPage('SeitenIndex', '{{PageIndex}}', $lng);
InsertPage('Benutzer', '{{LastUsers}}', $lng);
InsertPage('Registrierung', '{{Registration}}', $lng);

InsertPage('Passwort', '{{ChangePassword}}', $lng);
InsertPage('TextSuche', '{{Search}}\n\n\n  * ++4 Buchstaben Minimum für die Suche im Text der Seiten. Das ist eine ~MySQL Beschränkung.++\n  * ++3 Buchstaben Minimum für die Suche in Seitennamen.++\n  * ++Bei der Suche im Text verwenden wir die Volltextsuche Funktion von ~MySQL. Es wird  nur nach ganzen Worten gesucht.++\n\n', $lng);
InsertPage('Anmeldung', '{{Login}}', $lng);
InsertPage('Einstellungen', '{{UserSettings}}', $lng);

InsertPage('InterWiki', '{{InterWikiList}}', $lng);

?>