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
"Back" => "Zur�ck",

/*
   Language Selection Page
*/
"UpgradeFromWacko" => "Wilkommen bei WackoWiki, es scheint das du von WackoWiki <tt>%1</tt> auf <tt>%2</tt> aktualisierst.  Die n�chsten Seiten werden dich durch den Installationsvorgang f�hren.",
"UpgradeFromWakka" => "Wilkommen bei WackoWiki, es scheint das du von WakkaWiki <tt>%1</tt> auf <tt>%2</tt> aktualisierst.  Die n�chsten Seiten werden dich durch den Installationsvorgang f�hren.",
"FreshInstall" => "Wilkommen bei WackoWiki, du installierst gerade WackoWiki <tt>%1</tt>.  Die n�chsten Seiten werden dich durch den Installationsvorgang f�hren.",
"PleaseBackup" => "Bitte, erstelle eine Sicherungskopie von deiner Datenbank, der Konfigurationsdatei config.inc.php und aller ge�nderter Dateien (ggf. auch Layouts) bevor du den Aktualisierungs-Vorgang beginnst. Das kann dir im Problemfall viel �rger ersparen.",
"Lang" => "Spracheinstellungen",
"LangDesc" => "W�hle eine Sprache f�r die Installation aus. Das wird die Standardsprache f�r deine WackoWiki Installation.",

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
"Requirements" => "Dein Server muss den folgenden Anforderungen entsprechen.",
"OK" => "OK",
"Problem" => "Problem",
"NotePermissions" => "ACHTUNG: Der Installer wird versuchen, die Einstellungen in die Datei <tt>config.inc.php</tt> zu schreiben, diese Datei befindet sich im WackoWiki Verzeichnis. Damit das funktioniert, musst du sicherstellen, dass der Webserver Schreibrechte auf diese Datei hat! Falls du das nicht kannst, musst du die Datei sp�ter von Hand �ndern (das Installationsskript sagt dir dann, was zu tun ist).<br/><br/>Lies <a href=\"http://wackowiki.org/Doc/Deutsch/Installation\" target=\"_blank\">WackoWiki:Doc/Deutsch/Installation</a> f�r weitere Einzelheiten.",
"ErrorPermissions" => "Es scheint das der Installer nicht automatisch die erforderlichen Zugriffsrechte f�r die Dateien setzen kann um work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.",
"ErrorMinPHPVersion" => "Die PHP Version muss gr��er als <strong>4.3.3</strong> sein, dein Server scheint mit einer f�heren Version zu laufen.  Du must auf eine aktuellere PHP Version upgraden damit WackoWiki korrekt funktioniert.",
"Ready" => "Gl�ckw�nsch, dein Server scheint f�hig WackoWiki ausf�hren zu k�nnen.  Die folgenden Seiten werden dich durch den Konfigurationsprozess f�hren.",

/*
   Site Config Page
*/
"site-config" => "Site Konfiguration",
"Name" => "WackoWiki Name",
"NameDesc" => "Der Name deines WackoWikis. Normalerweise ist das ein <a href=\"http://wackowiki.org/Doc/Deutsch/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a> und sieht EtwaSoAus (z.B. MeinWackoWiki).",
"Home" => "Startseite",
"HomeDesc" => "Der Name der Startseite deines WackoWikis. Sollte ein WikiName sein (z.B. StartSeite)., dies wird die Startseite sein deines Wikis und sollte ein <a href=\"http://wackowiki.org/Doc/Deutsch/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a> sein.",
"MultiLang" => "Mehrsprachen-Modus",
"MultiLangDesc" => "Der Mehrsprachen-Modus erm�glicht Seiten mit unterschiedlichen Spracheinstellungen innerhalb einer Installation. Wenn dieser Modus aktiviert ist, wird die Installations-Routine die Grundseiten f�r allen Sprachen erstellen, die in dieser Version verf�gbar sind.",
"Admin" => "Verwalter Name",
"AdminDesc" => "Gib den Benutzernamen des Verwalters an. Sollte ein <a href=\"http://wackowiki.org/Doc/Deutsch/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a> sein (z.B. WikiAdmin).",
"Password" => "Verwalter Passwort",
"PasswordDesc" => "W�hle ein Passwort f�r den Verwalter mit mindestens 5 Zeichen.",
"Password2" => "Wiederhole Passwort:",
"Mail" => "E-Mail Adresse des Verwalters",
"MailDesc" => "Gib die E-Mail Adresse des Verwalters ein.",
"Base" => "Basis-URL",
"BaseDesc" => "Die Basis-URL deines WackoWikis. Die Seitennamen werden an diese angeh�ngt., so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><b><i>http://www.wackowiki.org/</i></b></li><li><b><i>http://www.wackowiki.org/wiki/</i></b></li></ul><p class=\"no_top\">Sollte URL-Umschreiben auf deinem Server nicht funktionieren, musst du \"?page=\" i.e.<ul><li><b><i>http://www.wackowiki.org/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/wiki/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/?page=</i></b></li></ul>",
"Rewrite" => "Umschreiben",
"RewriteDesc" => "<a href=\"http://wackowiki.org/Doc/Deutsch/RewriteModus\" target=\"_blank\">Umschreiben</a> sollte aktiviert sein, falls du WackoWiki mit URL-Umschreiben verwenden willst.",
"Enabled" => "Aktiviert:",
"ErrorAdminName" => "Der Verwalter Name muss ein WikiName sein!",
"ErrorAdminEmail" => "Du hast eine ung�ltige E-Mailadresse angegeben!",
"ErrorAdminPasswordMismatch" => "Die Passw�rter stimmen nicht �berein!",
"ErrorAdminPasswordShort" => "Das Verwalter Passwort ist zu kurz, die Mindestl�nge ist 5 Zeichen!",
"WarningRewriteMode" => "ACHTUNG!\nDeine Basis-URL & die Umschreib-Rechte (rewrite-mode settings) schauen ungew�hnlich aus. Normalerweise ist da kein ? in der URL wenn Umschreibe-Rechte aktiviert sind - in deinem Fall ist da aber ein Fragezeichen.\n\nUm dennoch mit diesen Einstellungen fortzufahren dr�cke OK.\nZur�ck zu den Einstellungen (form & change settings) dr�cke ABBRECHEN.\n\nFalls du mit den Einstellungen fortf�hrst, kann diese Software-Installation zu unerwarteten Fehlern f�hren.",
"ModRewriteStatusUnknown" => "Der Installer kann nicht ermitteln ob mod_rewrite aktiviert ist, dies bedeutet jedoch nicht das es deaktiviert ist.",

/*
   Database Config Page
*/
"database-config" => "Datenbank Konfiguration",
"DBDriverDesc" => "Der Datenbanktreiber der verwendet werden soll. Du musst einen Altsystem (legacy) Treiber w�hlen falls PHP5.1 (oder gr��er) und <a href=\"http://de2.php.net/pdo\" target=\"_blank\">PDO</a> nicht zur Verf�gung stehen.",
"DBDriver" => "Treiber",
"DBHost" => "Host",
"DBHostDesc" => "Der Server, auf dem deine Datenbank l�uft. Normalerweise \"localhost\" (wenn dein WackoWiki auf dem gleichen Server ist) oder der Host deines Providers.",
"DBPort" => "Port (Optional)",
"DBPortDesc" => "Die Port-Nummer �ber die dein Datenbankservers erreichbar ist, bei Verwendung der default Port Nummer leer lassen.",
"DB" => "Datenbank Name",
"DBDesc" => "Die Datenbank f�r unser WackoWiki. Diese Datenbank muss bereits existieren!",
"DBUserDesc" => "Name des Benutzers welcher f�r die Datenbankverbindung verwendet wird.",
"DBUser" => "Benutzername",
"DBPasswordDesc" => "Passwort des Benutzers welcher f�r die Datenbankverbindung verwendet wird.",
"DBPassword" => "Passwort",
"PrefixDesc" => "Pr�fix f�r alle Tabellen, die von WackoWiki benutzt werden. Man kann eine MySQL-Datenbank f�r mehrere WackoWikis verwenden in dem man unterschiedliche Tabellenpr�fixe verwendet.",
"Prefix" => "Tabellenpr�fix",
"ErrorNoDbDriverDetected" => "Es wurde kein Datenbanktreiber erkannt, bitte aktiviere entweder die mysql, mysqli oder pdo Erweiterung in deiner php.ini Datei.",
"ErrorNoDbDriverSelected" => "Es wurde kein Datenbanktreiber ausgew�hlt, bitte suche den passenden Treiber aus der Liste aus.",
"DeleteTables" => "L�sche bestehende Tabellen?",
"DeleteTablesDesc" => "ACHTUNG! Wenn du mit dieser Option fortf�hrst werden alle aktuellen Wiki-Daten aus deiner Datenbank gel�scht. Dies kann nicht r�ckg�ngig gemacht werden, es sei denn, du stellt die die Daten von Hand aus einem gesichert Backup wieder her.",
"ConfirmTableDeletion" => "Bist du sicher das du alle bestehenden Wiki-Tabellen l�schen willst?",

/*
   Database Installation Page
*/
"database-install" => "Datenbank Installation",
"TestingConfiguration" => "Teste Konfiguration",
"TestConnectionString" => "Teste Datenbank Verbindung",
"TestDatabaseExists" => "Pr�fe ob die ausgew�hlte Datenbank vorhanden ist",
"InstallingTables" => "Installiere Tabellen",
"ErrorDBConnection" => "Es gab ein Problem mit den von dir gemachten Datenbank Verbindungsdaten, bitte gehe zur�ck und pr�fe ob diese korrekt sind.",
"ErrorDBExists" => "Die angegebene Datenbank wurde nicht gefunden. Beachte, diese muss bereits bestehen bevor du WackoWiki installierst/upgradest!",
"To" => "zu",
"AlterTable" => "�ndere <tt>%1</tt> Tabelle",
"AlterUsersTable" => "�ndere Users Tabelle",
"InstallingDefaultData" => "F�ge Default Daten hinzu",
"InstallingPagesBegin" => "F�ge Basis-Seiten hinzu",
"InstallingPagesEnd" => "Die Basis-Seiten wurden hinzugef�gt",
"InstallingAdmin" => "F�ge Benutzerkonto f�r Verwalter hinzu",
"InstallingLogoImage" => "F�ge WackoWiki Logo hinzu",
"ErrorInsertingPage" => "Fehler beim Einf�gen der <tt>%1</tt> Seite",
"ErrorInsertingPageReadPermission" => "Fehler beim Setzen der Lese-Rechte f�r <tt>%1</tt> Seite",
"ErrorInsertingPageWritePermission" => "Fehler beim Setzen der Schreib-Rechte f�r <tt>%1</tt> Seite",
"ErrorInsertingPageCommentPermission" => "Fehler beim Setzen der Kommentar-Rechte f�r <tt>%1</tt> Seite",
"ErrorPageAlreadyExists" => "Diese <tt>%1</tt> Seite besteht bereits",
"ErrorAlteringTable" => "Fehler beim �ndern der <tt>%1</tt> Tabelle",
"CreatingTable" => "Erstelle <tt>%1</tt> Tabelle",
"ErrorAlreadyExists" => "Der <tt>%1</tt> existiert bereits",
"ErrorCreatingTable" => "Fehler beim Erstellen von <tt>%1</tt> Tabelle, besteht diese bereits?",
"ErrorMovingRevisions" => "Fehler beim Verschieben der Revisionen",
"MovingRevisions" => "Verschiebe Daten in Tabelle revisions",
"CleanupScript" => "Um Wacko zu beschleunigen, benutze <a href=\"http://wackowiki.org/Doc/English/CleanupScript\" target=\"_blank\">WackoWiki:Doc/English/CleanupScript</a>.",
"DeletingTables" => "L�sche Tabellen",
"DeletingTablesEnd" => "Tabellen wurden gel�scht",
"ErrorDeletingTable" => "Fehler beim L�schen der <tt>%1</tt> Tabelle, der wahrscheinlichste Grund daf�r ist, dass die Tabelle nicht existiert, in diesem Fall kannst du die Warnung ignorieren.",
"DeletingTable" => "L�sche <tt>%1</tt> Tabelle",

/*
   Write Config Page
*/
"write-config" => "Schreibe Konfig-Datei",
"FinalStep" => "Letzter Schritt",
"FinalSteps" => "Letzte Schritte",
"Writing" => "Schreibe Konfigurationsdatei",
"RemovingWritePrivilege" => "Entferne Schreibrechte",
"InstallationComplete" => "Installation abgeschlossen",
"ThatsAll" => "Das wars! Du kannst nun <a href=\"%1\"> zu deinem WackoWiki zur�ckkehren</a>.",
"SecurityConsiderations" => "Sicherheitserw�gungen",
"SecurityRisk" => "Es wird dringend empfohlen, die Schreibrechte auf die Datei <tt>config.inc.php</tt> nach dem Schreiben der Konfiguration wieder mit <tt>chmod 644</tt> zu entfernen. Eine �berschreibbare Konfigurationsdatei ist ein Sicherheitsrisiko!",
"RemoveSetupDirectory" => "Du solltest den Ordner <tt>\"setup\"</tt> l�schen nachdem die Installation beendet wurde.",
"ErrorGivePrivileges" => "Die Konfigurationsdatei <tt>%1</tt> konnte nicht geschrieben werden. Du musst dem Webserver vor�bergehend Schreibrechte auf das WackoWiki Verzeichnis oder auf eine leere Datei <tt>config.inc.php</tt> (<tt>touch config.inc.php ; chmod 666 config.inc.php</tt> geben; vergiss nicht, das Schreibrecht sp�ter wieder zu entziehen, z.B. mit <tt>chmod 644 config.inc.php</tt>). Falls das aus irgendwelchen Gr�nden nicht m�glich ist, kopiere den folgenden Text in eine neue Datei und speichere diese unter <tt>config.inc.php</tt> in dem WackoWiki Verzeichnis ab. Danach sollte dein WackoWiki funktionieren. Falls nicht, gehe zu <a href=\"http://wackowiki.org/Doc/Deutsch/Installation\" target=\"_blank\">WackoWiki:Doc/Deutsch/Installation</a>",
"NextStep" => "Im n�chsten Schritt wird das Installationsprogramm versuchen, die aktualisierte Konfigurationsdatei, <tt>config.inc.php</tt>, zu schreiben. Bitte stelle sicher, dass der Webserver Schreibrechte auf die Datei besitzt oder du musst die Datei von Hand �ndern.  F�r die Einzelheiten besuche bitte <a href=\"http://wackowiki.org/Doc/Deutsch/Installation\" target=\"_blank\">WackoWiki:Doc/Deutsch/Installation</a>.",
"WrittenAt" => "eingetragen in ",
"DontChange" => "�ndere wakka_version nicht von Hand!",
"ConfigDescription" => "http://wackowiki.org/Doc/Deutsch/Konfiguration",
"TryAgain" => "Versuche es erneut",
"RemoveWakkaConfigFile" => "WackoWiki verwendet eine neuere Konfigurationsdatei als deine fr�here WakkaWiki Installation.  Die alte Datei konnte nicht automatisch durch das System gel�scht werden und so ist es ratsam die Datei <tt>wakka.config.php</tt> manuell zu l�schen.",
"DeletingWakkaConfigFile" => "L�sche hinf�llige Wakka Konfigurationsdatei",

);
?>