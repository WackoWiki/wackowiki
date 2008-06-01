<?php
$lng = "de";

if ($config["language"]==$lng)
{
 InsertPage($config["root_page"], "((file:wacko4.gif WackoWiki))\n**Willkommen zu Deiner ((WackoWiki:DocDeutsch/WackoWiki WackoWiki)) Installation!**\n\nKlicke unten auf den Punkt \"Editieren\" um zu beginnen.\n\nDokumentation ist unter WackoWiki:DocDeutsch zu finden.\n\nNützliche Seiten: ((WackoWiki:DocDeutsch/Formatierung Formatierung)), VerwaisteSeiten, OffeneSeiten, TextSuche, MeineSeiten, MeineAenderungen.\n\n", $lng);
 InsertPage('OffeneSeiten', '{{WantedPages}}', $lng);
 InsertPage('VerwaisteSeiten', '{{OrphanedPages}}', $lng);
 InsertPage('MeineSeiten', '{{MyPages}}', $lng);
 InsertPage('MeineAenderungen', '{{MyChanges}}', $lng);
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