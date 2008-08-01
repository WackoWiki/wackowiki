<?php
$lang = array(

/*
   Language Settings
*/
"Charset" => "iso-8859-1",
"LangISO" => "de",
"LangName" => "Deutsch",

/*
   Generic Page Text
*/
"Title" => "WackoWiki Installation",
"Continue" => "Weiter",
"Back" => "Zurück",

/*
   Language Selection Page
*/
"Lang" => "Spracheinstellungen",
"LangDesc" => "Wähle eine Sprache für die Installation aus. Das wird die Standardsprache für deine WackoWiki Installation.",

/*
   System Requirements Page
*/
"version-check" => "System Anforderungen",
"PHPVersion" => "PHP Version",
"PHPDetected" => "Erkannt PHP",
"ModRewrite" => "Apache Rewrite Extension (Optional)",
"ModRewriteInstalled" => "Rewrite Extension (mod_rewrite) Installiert?",
"Database" => "Datenbank",
"Permissions" => "Berechtigungen",
"ReadyToInstall" => "Bereit zur Installation?",
"Installed" => "Dein installiertes WackoWiki meldet sich selbst als  ",
"ToUpgrade" => "Du <strong>aktualisierst</strong> gerade zu WackoWiki ",
"PleaseBackup" => "Bitte, mache eine Sicherungskopie von deiner Datenbank, der wakka.config.php-Datei und aller geänderter Dateien (ggf. auch Layouts) bevor du den Aktualisierungs-Vorgang startest. Das kann dir im Problemfall viel Ärger ersparen.",
"Fresh" => "Weil keine WackoWiki-Konfigurationsdatei existiert, ist das möglicherweise eine Neuinstallation. Du installierst gerade WackoWiki ",
"Requirements" => "Dein Server muss den folgenden Anforderungen entsprechen.",
"OK" => "OK",
"Problem" => "Problem",
"NotePermissions" => "ACHTUNG: Der Installer wird versuchen, die Einstellungen in die Datei <tt>wakka.config.php</tt> zu schreiben, diese Datei befindet sich im WackoWiki Verzeichnis. Damit das funktioniert, musst du sicherstellen, dass der Webserver Schreibrechte auf diese Datei hat! Falls du das nicht kannst, musst du die Datei später von Hand ändern (das Installationsskript sagt dir dann, was zu tun ist).<br/><br/>Lies <a href=\"http://wackowiki.de/Archiv/DocDeutsch/Installation\" target=\"_blank\">WackoWiki:DocDeutsch/Installation</a> für weitere Einzelheiten.",
"ErrorPermissions" => "Es scheint das der Installer nicht automatisch die erforderlichen Zugriffsrechte für die Dateien setzen kann um work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.",
"ErrorMinPHPVersion" => "Die PHP Version muss größer als <strong>4.3.3</strong> sein, dein Server scheint mit einer füheren Version zu laufen.  Du must auf eine aktuellere PHP Version upgraden damit WackoWiki korrekt funktioniert.",
"Ready" => "Glückwünsch, dein Server scheint fähig WackoWiki ausführen zu können.  Die folgenden Seiten werden dich durch den Konfigurationsprozess führen.",

/*
   Site Config Page
*/
"site-config" => "Site Konfiguration",
"Name" => "WackoWiki Name",
"NameDesc" => "Der Name deines WackoWikis. Normalerweise ist das ein <a href=\"http://wackowiki.de/Archiv/DocDeutsch/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a> und sieht EtwaSoAus (z.B. MeinWackoWiki).",
"Home" => "Startseite",
"HomeDesc" => "Der Name der Startseite deines WackoWikis. Sollte ein WikiName sein (z.B. StartSeite)., dies wird die Startseite sein deines Wikis und sollte ein <a href=\"http://wackowiki.de/Archiv/DocDeutsch/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a> sein.",
"MultiLang" => "Mehrsprachen-Modus",
"MultiLangDesc" => "Der Mehrsprachen-Modus ermöglicht Seiten mit unterschiedlichen Spracheinstellungen innerhalb einer Installation. Wenn dieser Modus aktiviert ist, wird die Installations-Routine die Grundseiten in allen Sprachen erstellen, die in dieser Version verfügbar sind.",
"Admin" => "Verwalter Name",
"AdminDesc" => "Gib den Benutzernamen des Verwalters an. Sollte ein <a href=\"http://wackowiki.de/Archiv/DocDeutsch/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a> sein (z.B. WikiAdmin).",
"Password" => "Verwalter Passwort",
"PasswordDesc" => "Wähle ein Passwort für den Verwalter mit mindestens 5 Zeichen.",
"Password2" => "Wiederhole Passwort:",
"Mail" => "E-Mail Adresse des Verwalters",
"MailDesc" => "Gib die E-Mail Adresse des Verwalters ein.",
"Base" => "Basis-URL",
"BaseDesc" => "Die Basis-URL deines WackoWikis. Die Seitennamen werden an diese angehängt., so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><b><i>http://www.wackowiki.de/</i></b></li><li><b><i>http://www.wackowiki.de/wiki/</i></b></li></ul><p class=\"no_top\">Sollte URL-Umschreiben auf deinem Server nicht funktionieren, musst du \"?page=\" i.e.<ul><li><b><i>http://www.wackowiki.de/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.de/wiki/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.de/?page=</i></b></li><li><b><i>http://www.wackowiki.de?page=</i></b></li></ul>",
"Rewrite" => "Umschreiben",
"RewriteDesc" => "<a href=\"http://wackowiki.de/Archiv/DocDeutsch/RewriteModus\" target=\"_blank\">Umschreiben</a> sollte aktiviert sein, falls du WackoWiki mit URL-Umschreiben verwenden willst.",
"Enabled" => "Aktiviert:",
"ErrorAdminName" => "Der Verwalter Name muss ein WikiName sein!",
"ErrorAdminEmail" => "Du hast eine ungültige E-Mailadresse angegeben!",
"ErrorAdminPasswordMismatch" => "Die Passwörter stimmen nicht überein!",
"ErrorAdminPasswordShort" => "Das Verwalter Passwort ist zu kurz, die Mindestlänge ist 5 Zeichen!",
"WarningRewriteMode" => "ACHTUNG!\nDeine Basis-URL & die Umschreib-Rechte (rewrite-mode settings) schauen ungewöhnlich aus. Normalerweise ist da kein ? in der URL wenn Umschreibe-Rechte aktiviert sind - in deinem Fall ist da aber ein Fragezeichen.\n\nUm dennoch mit diesen Einstellungen fortzufahren drücke OK.\nZurück zu den Einstellungen (form & change settings) drücke ABBRECHEN.\n\nFalls du mit den Einstellungen fortfährst, kann diese Software-Installation zu unerwarteten Fehlern führen.",
"ModRewriteStatusUnknown" => "Der Installer kann nicht ermitteln ob mod_rewrite aktiviert ist, dies bedeutet jedoch nicht das es deaktiviert ist.",

/*
   Database Config Page
*/
"database-config" => "Datenbank Konfiguration",
"DBDriverDesc" => "Der Datenbanktreiber der verwendet werden soll. Du musst einen Altsystem (legacy) Treiber wählen falls PHP5.1 (oder größer) und <a href=\"http://de2.php.net/pdo\" target=\"_blank\">PDO</a> nicht zur Verfügung stehen.",
"DBDriver" => "Treiber",
"DBHost" => "Host",
"DBHostDesc" => "Der Server, auf dem deine Datenbank läuft. Normalerweise \"localhost\" (wenn dein WackoWiki auf dem gleichen Server ist) oder der Host deines Providers.",
"DBPort" => "Port (Optional)",
"DBPortDesc" => "Die Port-Nummer über die dein Datenbankservers erreichbar ist, bei Verwendung der default Port Nummer leer lassen.",
"DB" => "Datenbank Name",
"DBDesc" => "Die Datenbank für unser WackoWiki. Diese Datenbank muss bereits existieren!",
"DBUserDesc" => "Name des Benutzer welcher für die Datenbankverbindung verwendet wird.",
"DBUser" => "Benutzername",
"DBPasswordDesc" => "Passwort des Benutzer welcher für die Datenbankverbindung verwendet wird.",
"DBPassword" => "Passwort",
"PrefixDesc" => "Präfix für alle Tabellen, die von WackoWiki benutzt werden. Man kann eine MySQL-Datenbank für mehrere WackoWikis verwenden in dem man unterschiedliche Tabellenpräfixe verwendet.",
"Prefix" => "Tabellenpräfix",
"ErrorNoDbDriverDetected" => "Es wurde kein Datenbanktreiber erkannt, bitte aktiviere entweder die mysql, mysqli oder pdo Erweiterung in deiner php.ini Datei.",
"ErrorNoDbDriverSelected" => "Es wurde kein Datenbanktreiber ausgewählt, bitte suche den passenden Treiber aus der Liste aus.",

/*
   Database Installation Page
*/
"database-install" => "Datenbank Installation",
"TestingConfiguration" => "Teste Konfiguration",
"TestConnectionString" => "Teste Datenbank Verbindung",
"TestDatabaseExists" => "Prüfe ob die ausgewählte Datenbank vorhanden ist",
"InstallingTables" => "Installiere Tabellen",
"ErrorDBConnection" => "Es gab ein Problem mit den von dir gemachten Datenbank Verbindungsdaten, bitte gehe zurück und prüfe ob diese korrekt sind.",
"ErrorDBExists" => "Die angegebene Datenbank wurde nicht gefunden. Beachte, diese muss bereits bestehen bevor du WackoWiki installierst/upgradest!",
"To" => "zu",
"AlterTable" => "Ändere %1 Tabelle",
"AlterUsersTable" => "Ändere Users Tabelle",
"InstallingDefaultData" => "Füge Default Daten hinzu",
"InstallingPagesBegin" => "Füge Default Seiten hinzu",
"InstallingPagesEnd" => "Die Basis-Seiten würden hinzugefügt",
"InstallingAdmin" => "Füge Benutzerkonto für Verwalter hinzu",
"InstallingLogoImage" => "Füge WackoWiki Logo hinzu",
"ErrorInsertingPage" => "Fehler beim Einfügen der %1 Seite",
"ErrorInsertingPageReadPermission" => "Fehler beim Setzen der Lese-Rechte für %1 Seite",
"ErrorInsertingPageWritePermission" => "Fehler beim Setzen der Schreib-Rechte für %1 Seite",
"ErrorInsertingPageCommentPermission" => "Fehler beim Setzen der Kommentar-Rechte für %1 Seite",
"ErrorPageAlreadyExists" => "Diese %1 Seite besteht bereits",
"ErrorAlteringTable" => "Fehler beim Ändern der %1 Tabelle",
"CreatingTable" => "Erstelle %1 Tabelle",
"ErrorAlreadyExists" => "Der %1 existiert bereits",
"ErrorCreatingTable" => "Fehler beim Erstellen von %1 Tabelle, besteht diese bereits?",
"ErrorMovingRevisions" => "Fehler moving revision data",
"MovingRevisions" => "Verschiebe Daten in Tabelle revisions",
"CleanupScript" => "Um Wacko zu beschleunigen, benutze <a href=\"http://wackowiki.de/Archiv/DocEnglish/CleanupScript\" target=\"_blank\">WackoWiki:DocEnglish/CleanupScript</a>.",

/*
   Write Config Page
*/
"write-config" => "Schreibe Konfig-Datei",
"Writing" => "Schreibe Konfiguration",
"Writing2" => "Schreibe Konfigurationsdatei",
"RemovingWritePrivilege" => "Entferne Schreibrechte",
"InstallationComplete" => "Das wars! Du kannst nun <a href=\"%1\"> zu deinem WackoWiki zurückkehren</a>.",
"SecurityConsiderations" => "Sicherheitserwägungen",
"SecurityRisk" => "Es wird dringend empfohlen, das Schreibrecht auf die Datei <tt>wakka.config.php</tt> nach dem Schreiben der Konfiguration wieder mit <tt>chmod 644</tt> zu entfernen. Eine überschreibbare Konfigurationsdatei ist ein Sicherheitsrisiko!",
"RemoveSetupDirectory" => "Du solltest den Ordner \"setup\" löschen nachdem die Installation beendet wurde.",
"ErrorGivePrivileges" => "Die Konfigurationsdatei %1 konnte nicht geschrieben werden. Du musst dem Webserver vorübergehend Schreibrechte auf das WackoWiki Verzeichnis oder auf eine leere Datei <tt>wakka.config.php</tt> (<tt>touch wakka.config.php ; chmod 666 wakka.config.php</tt> geben; vergiss nicht, das Schreibrecht später wieder zu entziehen, z.B. mit <tt>chmod 644 wakka.config.php</tt>). Falls das aus irgendwelchen Gründen nicht möglich ist, kopiere den folgenden Text in eine neue Datei und speichere diese unter <tt>wakka.config.php</tt> in dem WackoWiki Verzeichnis ab. Danach sollte dein WackoWiki funktionieren. Falls nicht, gehe zu <a href=\"http://wackowiki.de/Archiv/DocDeutsch/Installation\" target=\"_blank\">WackoWiki:DocDeutsch/Installation</a>",
"NextStep" => "Im nächsten Schritt wird das Installationsprogramm versuchen, die aktualisierte Konfigurationsdatei zu schreiben, <tt>wakka.config.php</tt>. Bitte stelle sicher, dass der Webserver Schreibrechte auf die Datei besitzt oder du musst die Datei von Hand ändern.  Für die Einzelheiten besuche bitte <a href=\"http://wackowiki.de/Archiv/DocDeutsch/Installation\" target=\"_blank\">WackoWiki:DocDeutsch/Installation</a>.",
"WrittenAt" => "eingetragen in ",
"DontChange" => "Ändere wakka_version nicht von Hand!",
"TryAgain" => "Versuche es erneut",

);
?>