<?php
$lang = array(

/*
   Generic Page Text
*/
"Title" => "WackoWiki Installation",
"Continue" => "Weiter",
"Back" => "Zur�ck",

/*
   Language Selection Page
*/
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
"Installed" => "Dein installiertes WackoWiki meldet sich selbst als  ",
"ToUpgrade" => "Du <strong>aktualisierst</strong> gerade zu WackoWiki ",
"PleaseBackup" => "Bitte, mache eine Sicherungskopie von deiner Datenbank, der wakka.config.php-Datei und aller ge�nderter Dateien (ggf. auch Layouts) bevor du den Aktualisierungs-Vorgang startest. Das kann dir im Problemfall viel �rger ersparen.",
"Fresh" => "Weil keine WackoWiki-Konfigurationsdatei existiert, ist das m�glicherweise eine Neuinstallation. Du installierst gerade WackoWiki ",
"Requirements" => "Dein Server muss den folgenden Anforderungen entsprechen.",
"OK" => "OK",
"Problem" => "Problem",
"NotePermissions" => "ACHTUNG: Der Installer wird versuchen, die Einstellungen in die Datei <tt>wakka.config.php</tt> zu schreiben, diese Datei befindet sich im WackoWiki Verzeichnis. Damit das funktioniert, musst du sicherstellen, dass der Webserver Schreibrechte auf diese Datei hat! Falls du das nicht kannst, musst du die Datei sp�ter von Hand �ndern (das Installationsskript sagt dir dann, was zu tun ist).<br/><br/>Lies <a href=\"http://wackowiki.de/Archiv/DocDeutsch/Installation\" target=\"_blank\">WackoWiki:DocDeutsch/Installation</a> f�r weitere Einzelheiten.",
"ErrorPermissions" => "Es scheint das der Installer nicht automatisch die erforderlichen Zugriffsrechte f�r die Dateien setzen kann um work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.",
"ErrorMinPHPVersion" => "Die PHP Version muss gr��er als <strong>4.3.3</strong> sein, dein Server scheint mit einer f�heren Version zu laufen.  Du must auf eine aktuellere PHP Version upgraden damit WackoWiki korrekt funktioniert.",
"Ready" => "Gl�ckw�nsch, dein Server scheint f�hig WackoWiki ausf�hren zu k�nnen.  Die folgenden Seiten werden dich durch den Konfigurationsprozess f�hren.",

/*
   Site Config Page
*/
"site-config" => "Site Konfiguration",
"Name" => "WackoWiki Name",
"NameDesc" => "Der Name deines WackoWikis. Normalerweise ist das ein <a href=\"http://wackowiki.de/Archiv/DocDeutsch/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a> und sieht EtwaSoAus (z.B. MeinWackoWiki).",
"Home" => "Startseite",
"HomeDesc" => "Der Name der Startseite deines WackoWikis. Sollte ein WikiName sein (z.B. StartSeite)., dies wird die Startseite sein deines Wikis und sollte ein <a href=\"http://wackowiki.de/Archiv/DocDeutsch/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a> sein.",
"MultiLang" => "Mehrsprachen-Modus",
"MultiLangDesc" => "Der Mehrsprachen-Modus erm�glicht Seiten mit unterschiedlichen Spracheinstellungen innerhalb einer Installation. Wenn dieser Modus aktiviert ist, wird die Installations-Routine die Grundseiten in allen Sprachen erstellen, die in dieser Version verf�gbar sind.",
"Admin" => "Verwalter Name",
"AdminDesc" => "Gib den Benutzernamen des Verwalters an. Sollte ein <a href=\"http://wackowiki.de/Archiv/DocDeutsch/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a> sein (z.B. WikiAdmin).",
"Password" => "Verwalter Passwort",
"PasswordDesc" => "W�hle ein Passwort f�r den Verwalter mit mindestens 5 Zeichen.",
"Password2" => "Wiederhole Passwort:",
"Mail" => "E-Mail Adresse des Verwalters",
"MailDesc" => "Gib die E-Mail Adresse des Verwalters ein.",
"Base" => "Basis-URL",
"BaseDesc" => "Die Basis-URL deines WackoWikis. Die Seitennamen werden an diese angeh�ngt., so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><b><i>http://www.wackowiki.de/</i></b></li><li><b><i>http://www.wackowiki.de/wiki/</i></b></li></ul><p class=\"no_top\">Sollte URL-Umschreiben auf deinem Server nicht funktionieren, musst du \"?page=\" i.e.<ul><li><b><i>http://www.wackowiki.de/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.de/wiki/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.de/?page=</i></b></li><li><b><i>http://www.wackowiki.de?page=</i></b></li></ul>",
"Rewrite" => "Umschreiben",
"RewriteDesc" => "<a href=\"http://wackowiki.de/Archiv/DocDeutsch/RewriteModus\" target=\"_blank\">Umschreiben</a> sollte aktiviert sein, falls du WackoWiki mit URL-Umschreiben verwenden willst.",
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
"DBUserDesc" => "Name des Benutzer welcher f�r die Datenbankverbindung verwendet wird.",
"DBUser" => "Benutzername",
"DBPasswordDesc" => "Passwort des Benutzer welcher f�r die Datenbankverbindung verwendet wird.",
"DBPassword" => "Passwort",
"PrefixDesc" => "Pr�fix f�r alle Tabellen, die von WackoWiki benutzt werden. Man kann eine MySQL-Datenbank f�r mehrere WackoWikis verwenden in dem man unterschiedliche Tabellenpr�fixe verwendet.",
"Prefix" => "Tabellenpr�fix",
"ErrorNoDbDriverDetected" => "Es wurde kein Datenbanktreiber erkannt, bitte aktiviere entweder die mysql, mysqli oder pdo Erweiterung in deiner php.ini Datei.",
"ErrorNoDbDriverSelected" => "Es wurde kein Datenbanktreiber ausgew�hlt, bitte suche den passenden Treiber aus der Liste aus.",

/*
   Database Installation Page
*/
"database-install" => "Datenbank Installation",
"TestingConfiguration" => "Teste Konfiguration",
"TestConnectionString" => "Teste Datenbank Verbindung",
"TestDatabaseExists" => "Pr�fe ob die ausgew�hlte Datenbank vorhanden ist",
"InstallingTables" => "Installiere Tabellen",
"ErrorDBConnection" => "Es gab ein Problem mit den von dir gemachten Datenbank Verbindungsdaten, bitte gehe zur�ck und pr�fe ob diese korrekt sind.",
"ErrorDBExists" => "Die angegebene Datenbank wurde nicht gefunden. Remember, it needs to exist before you can install/upgrade WackoWiki!",
"To" => "zu",
"AlterTable" => "�ndere %1 Tabelle",
"AlterUsersTable" => "�ndere Users Tabelle",
"InstallingDefaultData" => "F�ge Default Daten hinzu",
"InstallingPagesBegin" => "F�ge Default Seiten hinzu",
"InstallingPagesEnd" => "Die Basis-Seiten w�rden hinzugef�gt",
"InstallingAdmin" => "F�ge Benutzerkonto f�r Verwalter hinzu",
"InstallingLogoImage" => "F�ge WackoWiki Logo hinzu",
"ErrorInsertingPage" => "Fehler beim Einf�gen der %1 Seite",
"ErrorInsertingPageReadPermission" => "Fehler setting read permission for %1 Seite",
"ErrorInsertingPageWritePermission" => "Fehler setting write permission for %1 Seite",
"ErrorInsertingPageCommentPermission" => "Fehler setting comment permissions for %1 Seite",
"ErrorPageAlreadyExists" => "Diese %1 Seite besteht bereits",
"ErrorAlteringTable" => "Fehler beim �ndern der %1 Tabelle",
"CreatingTable" => "Erstelle %1 Tabelle",
"ErrorAlreadyExists" => "Die %1 existiert bereits",
"ErrorCreatingTable" => "Fehler creating %1 table, does it already exist?",
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
"InstallationComplete" => "Das wars! Du kannst nun <a href=\"%1\"> zu deinem WackoWiki zur�ckkehren</a>.",
"SecurityConsiderations" => "Sicherheitserw�gungen",
"SecurityRisk" => "Es wird dringend empfohlen, das Schreibrecht auf die Datei <tt>wakka.config.php</tt> nach dem Schreiben der Konfiguration wieder mit <tt>chmod 644</tt> zu entfernen. Eine �berschreibbare Konfigurationsdatei ist ein Sicherheitsrisiko!",
"RemoveSetupDirectory" => "You should delete the \"setup\" directory now that the installation process has been completed.",
"ErrorGivePrivileges" => "Die Konfigurationsdatei %1 konnte nicht geschrieben werden. Du musst dem Webserver vor�bergehend Schreibrechte auf das WackoWiki Verzeichnis oder auf eine leere Datei <tt>wakka.config.php</tt> (<tt>touch wakka.config.php ; chmod 666 wakka.config.php</tt> geben; vergiss nicht, das Schreibrecht sp�ter wieder zu entziehen, z.B. mit <tt>chmod 644 wakka.config.php</tt>). Falls das aus irgendwelchen Gr�nden nicht m�glich ist, kopiere den folgenden Text in eine neue Datei und speichere diese unter <tt>wakka.config.php</tt> in dem WackoWiki Verzeichnis ab. Danach sollte dein WackoWiki funktionieren. Falls nicht, gehe zu <a href=\"http://wackowiki.de/Archiv/DocDeutsch/Installation\" target=\"_blank\">WackoWiki:DocDeutsch/Installation</a>",
"NextStep" => "Im n�chsten Schritt wird das Installationsprogramm versuchen, die aktualisierte Konfigurationsdatei zu schreiben, <tt>wakka.config.php</tt>.  Bitte stelle sicher, dass der Webserver Schreibrechte auf die Datei besitzt oder du musst die Datei von Hand �ndern.  F�r die Einzelheiten besuche bitte <a href=\"http://wackowiki.de/Archiv/DocDeutsch/Installation\" target=\"_blank\">WackoWiki:DocDeutsch/Installation</a>.",
"WrittenAt" => "eingetragen in ",
"DontChange" => "�ndere wakka_version nicht von Hand!",
"TryAgain" => "Versuche es erneut",

// O L D
/*
"DBError" => "Die von dir angegebene Datenbank wurde nicht gefunden. Bitte beachte, dass diese bereits vor der Installation/Aktualisierung von WackoWiki existieren muss!",
"TestSql" => "�berpr�fe Einstellungen zur Datenbank Verbindung...",
"Testing Configuration" => "�berpr�fe Konfiguration",
"Looking for database..." => "Suche nach Datenbank...",
"pages alter" => "�ndere geringf�gig die Tabelle 'pages'...",
"0.1.1" => "Sende Hassmail an die WackoWiki Entwickler...",
"useralter" => "�ndere geringf�gig die Tabelle 'user'...",
"NextStep" => "Im n�chsten Schritt wird das Installationsprogramm versuchen, die aktualisierte Konfigurationsdatei zu schreiben,",
"MakeWrite" => "Bitte stelle sicher, dass der Webserver Schreibrechte auf die Datei besitzt oder du musst die Datei von Hand �ndern",
"ForDetailsSee" => "F�r die Einzelheiten besuche bitte <a href=\"http://wackowiki.de/DocDeutsch/Installation\" target=\"_blank\">WackoWiki:DocDeutsch/Installation</a>",
"Continue" => "Weiter",
"Installing Stuff" => "Installiere Tabellen",
"Creating table..." => "Erstelle Tabelle '%1'...",
"Already exists?" => "Bereits vorhanden?",
"to" => "zu",
"Adding some pages..." => "F�ge einige Seiten hinzu...",
"Hmm!" => "Hmm!",
"Claiming all your base..." => "Claiming all your base...",
"And table..." => "und Tabelle '%1' (Warte!)...",
"writtenAt" => "eingetragen in ",
"dontchange" => "�ndere wakka_version nicht von Hand!",
"writing" => "<strong>Schreibe Konfiguration</strong><br/>\n",
"writing2" => "Schreibe Konfigurationsdatei",
"ready" => "<p>Das wars! Du kannst nun",
"return" => "zu deinem WackoWiki zur�ckkehren",
"SecurityRisk" => "Es wird dringend empfohlen, das Schreibrecht auf die Datei <tt>wakka.config.php</tt> nach dem Schreiben der Konfiguration wieder mit <tt>chmod 644</tt> zu entfernen. Eine �berschreibbare Konfigurationsdatei ist ein Sicherheitsrisiko!",
"warning" => "<span class=\"failed\">WARNUNG:</span> Die Konfigurationsdatei",
"GivePrivileges" => "konnte nicht geschrieben werden. Du musst dem Webserver vor�bergehend Schreibrechte auf das WackoWiki Verzeichnis oder auf eine leere Datei <tt>wakka.config.php</tt> (<tt>touch wakka.config.php ; chmod 666 wakka.config.php</tt> geben; vergiss nicht, das Schreibrecht sp�ter wieder zu entziehen, z.B. mit <tt>chmod 644 wakka.config.php</tt>). Falls das aus irgendwelchen Gr�nden nicht m�glich ist, kopiere den folgenden Text in eine neue Datei und speichere diese unter <tt>wakka.config.php</tt> in dem WackoWiki Verzeichnis ab. Danach sollte dein WackoWiki funktionieren. Falls nicht, gehe zu <a href=\"http://wackowiki.de/DocDeutsch/Installation\" target=\"_blank\">WackoWiki:DocDeutsch/Installation</a>",
"try again" => "Nochmal versuchen",
"title" => "WackoWiki Installation",
"failed" => "FEHLGESCHLAGEN",
"note" => "ACHTUNG: Dieses Skript wird versuchen, die Einstellungen in die Datei <tt>wakka.config.php</tt> zu schreiben, diese Datei befindet sich im WackoWiki Verzeichnis. Damit das funktioniert, musst du sicherstellen, dass der Webserver Schreibrechte auf diese Datei hat! Falls du das nicht kannst, musst du die Datei sp�ter von Hand �ndern (das Installationsskript sagt dir dann, was zu tun ist).<br/><br/>Lies <a href=\"http://wackowiki.de/DocDeutsch/Installation\" target=\"_blank\">WackoWiki:DocDeutsch/Installation</a> f�r weitere Einzelheiten.",
"dbConf" => "Datenbankkonfiguration",
"dbDriverDesc" => "Der Datenbanktreiber der verwendet werden soll. Du musst einen Altsystem (legacy) Treiber w�hlen falls PHP5.1 (oder gr��er) und <a href=\"http://de2.php.net/pdo\" target=\"_blank\">PDO</a> nicht zur Verf�gung stehen.",
"dbDriver" => "Datenbank Treiber",
"dbPortDesc" => "Die Port-Nummer �ber die dein Datenbankservers erreichbar ist, bei Verwendung der default Port Nummer leer lassen.",
"dbPort" => "Datenbank Port",
"dbHostDesc" => "Der Server, auf dem deine Datenbank l�uft. Normalerweise \"localhost\" (wenn dein WackoWiki auf dem gleichen Server ist) oder der Host deines Providers.",
"dbHost" => "Datenbank Host",
"dbDesc" => "Die Datenbank f�r unser WackoWiki. Diese Datenbank muss bereits existieren!",
"db" => "Name der Datenbank",
"dbPasswDesc" => "Name und Passwort des Benutzers f�r die Datenbankverbindung",
"dbUser" => "Benutzername",
"dbPassw" => "Passwort",
"noDbDriverSelected" => "Es wurde kein Datenbanktreiber ausgew�hlt, bitte suche den passenden Treiber aus der Liste aus.",
"noDbDriverDetected" => "Es wurde kein Datenbanktreiber erkannt, bitte aktiviere entweder die mysql, mysqli oder pdo Erweiterung in deiner php.ini Datei.",
"prefixDesc" => "Pr�fix f�r alle Tabellen, die von WackoWiki benutzt werden. Man kann eine MySQL-Datenbank f�r mehrere WackoWikis verwenden in dem man unterschiedliche Tabellenpr�fixe verwendet.",
"prefix" => "Tabellenpr�fix",
"SiteConf" => "WackoWiki Konfiguration",
"nameDesc" => "Der Name deines WackoWikis. Normalerweise ist das ein WikiName und sieht EtwaSoAus (z.B. MeinWackoWiki).",
"name" => "WackoWiki-Name",
"homeDesc" => "Der Name der Startseite deines WackoWikis. Sollte ein WikiName sein (z.B. StartSeite).",
"home" => "Startseite",
"metaDesc" => "META Schl�sselworte/Beschreibung die in den HTML-Header eingef�gt werden sollen.",
"meta1" => "Meta Schl�sselworte",
"meta2" => "Meta Beschreibung",
"UrlConf" => "WackoWiki URL Konfiguration",
"baseDesc" => "Die Basis-URL deines WackoWikis (Standardeinstellung ist richtig, ggf. https://... verwenden).  Die Seitennamen werden an diese angeh�ngt. Sollte URL-Umschreiben auf deinem Server nicht funktionieren, musst du  <tt>\"index.php?page=\"</tt> mit einf�gen.",
"base" => "Basis-URL",
"rewriteDesc" => "<a href=\"http://wackowiki.de/DocDeutsch/RewriteModus\" target=\"_blank\">Umschreiben</a> muss aktiviert werden, falls du das WackoWiki mit URL-Umschreiben verwenden willst.",
"rewrite" => "Umschreiben",
"enabled" => "aktiviert",
"installed" => "Dein installiertes WackoWiki meldet sich selbst als ",
"toUpgrade" => "Du <strong>aktualisierst</strong> gerade zu WackoWiki ",
"review" => "Bitte �berpr�fe deine nachfolgenden Einstellungen.",
"fresh" => "Weil keine WackoWiki-Konfigurationsdatei existiert, ist das m�glicherweise eine Neuinstallation. Du installierst gerade WackoWiki ",
"pleaseConfigure" => "Bitte konfiguriere dein WackoWiki mittels dieses Formulars.",
"langConf" => "Spracheinstellungen",
"langDesc" => "W�hle eine Sprache f�r die Installation aus. Das wird die Standardsprache f�r dein WackoWiki.",
"lang" => "W�hle eine Sprache",
"VeryBad" => "Sehr schlecht. Rufe sofort die Entwickler! M�glicher Datenverlust.",
"Moving data to revisions table..." => "Verschiebe Daten in Tabelle 'revision'...",
"AdminConf" => "Konfiguration des Verwaltungskontos",
"adminDesc" => "Gib den Benutzernamen des Verwalters an. Sollte ein WikiName sein (z.B. WikiAdmin).",
"admin" => "Verwalter",
"passwDesc" => "W�hle ein Passwort f�r den Verwalter (5+ Zeichen)",
"password" => "Passwort",
"password2" => "Wiederhole Passwort",
"mailDesc" => "E-Mailadresse des Verwalters.",
"mail" => "E-Mail",
"adding pages" => "F�ge einige Seiten hinzu...",
"incorrect wikiname" => "Du musst einen korrekten WikiNamen als Benutzernamen f�r den Verwalter angeben!",
"incorrect email" => "Du musst eine korrekte E-Mailadresse f�r den Verwalter angeben!",
"passwords don't match" => "Passw�rter stimmen nicht �berein, bitte neu eingeben.",
"password too short" => "Passwort zu kurz, bitte neu eingeben.",
"adding admin" => "F�ge Benutzerkonto f�r Verwalter hinzu...",
"Doubles" => "Um Wacko zu beschleunigen, benutze <a href=\"http://wackowiki.de/DocEnglish/CleanupScript\" target=\"_blank\">WackoWiki:DocEnglish/CleanupScript</a>.",
"newinstall" => "Weil dies eine Neuinstallation ist, versucht das Installationsskript die richtige Parameter zu ermitteln. �ndere diese Werte nur, wenn du weisst, was du tust!",
"multilangDesc" => "Der Mehrsprachen-Modus erm�glicht Seiten mit unterschiedlichen Spracheinstellungen innerhalb einer Installation. Wenn dieser Modus aktiviert ist, wird die Installations-Routine die Grundseiten in allen Sprachen erstellen, die in dieser Version verf�gbar sind.",
"multilang" => "mehrsprachiger Modus",
"PleaseBackup" => "Bitte, mache eine Sicherungskopie von deiner Datenbank, der wakka.config.php-Datei und aller ge�nderter Dateien (ggf. auch Layouts) bevor du den Aktualisierungs-Vorgang startest. Das kann dir im Problemfall viel �rger ersparen.",
"apply rights" => "Versuche Schreibrechte zu setzen f�r das Verzeichnis",
"apply rights yourself" => "Bitte setze die Zugriffsrechte auf 777 f�r das Verzeichnis",
"RewriteModeAlert" => "ACHTUNG!\nDeine Basis-URL & die Umschreib-Rechte (rewrite-mode settings) schauen ungew�hnlich aus. Normalerweise ist da kein ? in der URL wenn Umschreibe-Rechte aktiviert sind - in deinem Fall ist da aber ein Fragezeichen.\n\nUm dennoch mit diesen Einstellungen fortzufahren dr�cke OK.\nZur�ck zu den Einstellungen (form & change settings) dr�cke ABBRECHEN.\n\nFalls du mit den Einstellungen fortf�hrst, kann diese Software-Installation zu unerwarteten Fehlern f�hren.",
"adding logo image..." => "F�ge WackoWiki Logo hinzu...",
*/

);
?>