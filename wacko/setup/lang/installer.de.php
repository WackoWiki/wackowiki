<?php
$lang = array(

/*
   Language Settings
*/
'Charset' => 'iso-8859-1',
'LangISO' => 'de',
'LangName' => 'Deutsch',

/*
   Generic Page Text
*/
'Title' => 'WackoWiki Installation',
'Continue' => 'Weiter',
'Back' => 'Zurück',

/*
   Language Selection Page
*/
'UpgradeFromWacko' => 'Wilkommen bei WackoWiki, es scheint das du von WackoWiki <tt>%1</tt> auf <tt>%2</tt> aktualisierst.  Die nächsten Seiten werden dich durch den Installationsvorgang führen.',
'FreshInstall' => 'Wilkommen bei WackoWiki, du installierst gerade WackoWiki <tt>%1</tt>.  Die nächsten Seiten werden dich durch den Installationsvorgang führen.',
'PleaseBackup' => 'Bitte, erstelle eine Sicherungskopie von deiner Datenbank, der Konfigurationsdatei config.php und aller geänderter Dateien (ggf. auch Layouts) bevor du den Aktualisierungs-Vorgang beginnst. Das kann dir im Problemfall viel Ärger ersparen.',
'Lang' => 'Spracheinstellungen',
'LangDesc' => 'Wähle eine Sprache für die Installation aus. Das wird die Standardsprache für deine WackoWiki Installation.',

/*
   System Requirements Page
*/
'version-check' => 'System Anforderungen',
'PHPVersion' => 'PHP Version',
'PHPDetected' => 'Erkannt PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Extension (mod_rewrite) Installiert?',
'Database' => 'Datenbank',
'Permissions' => 'Berechtigungen',
'ReadyToInstall' => 'Bereit zur Installation?',
'Requirements' => 'Dein Server muss den folgenden Anforderungen entsprechen.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePermissions' => 'ACHTUNG: Der Installer wird versuchen, die Einstellungen in die Datei <tt>config.php</tt> zu schreiben, diese Datei befindet sich im WackoWiki Verzeichnis. Damit das funktioniert, musst du sicherstellen, dass der Webserver Schreibrechte auf diese Datei hat! Falls du das nicht kannst, musst du die Datei später von Hand ändern (das Installationsskript sagt dir dann, was zu tun ist).<br/><br/>Lies <a href="http://wackowiki.org/Doc/Deutsch/Installation" target="_blank">WackoWiki:Doc/Deutsch/Installation</a> für weitere Einzelheiten.',
'ErrorPermissions' => 'Es scheint das der Installer nicht automatisch die erforderlichen Zugriffsrechte für die Dateien setzen kann um work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPHPVersion' => 'Die PHP Version muss größer als <strong>5.2.0</strong> sein, dein Server scheint mit einer füheren Version zu laufen.  Du must auf eine aktuellere PHP Version upgraden damit WackoWiki korrekt funktioniert.',
'Ready' => 'Glückwünsch, dein Server scheint fähig WackoWiki ausführen zu können.  Die folgenden Seiten werden dich durch den Konfigurationsprozess führen.',

/*
   Site Config Page
*/
'site-config' => 'Site Konfiguration',
'Name' => 'WackoWiki Name',
'NameDesc' => 'Der Name deines WackoWikis. Normalerweise ist das ein <a href="http://wackowiki.org/Doc/Deutsch/WikiName" title="View Help" target="_blank">WikiName</a> und sieht EtwaSoAus (z.B. MeinWackoWiki).',
'Home' => 'Startseite',
'HomeDesc' => 'Der Name der Startseite deines WackoWikis. Sollte ein WikiName sein (z.B. StartSeite)., dies wird die Startseite sein deines Wikis und sollte ein <a href="http://wackowiki.org/Doc/Deutsch/WikiName" title="View Help" target="_blank">WikiName</a> sein.',
'HomeDefault' => 'StartSeite',
'MultiLang' => 'Mehrsprachen-Modus',
'MultiLangDesc' => 'Der Mehrsprachen-Modus ermöglicht Seiten mit unterschiedlichen Spracheinstellungen innerhalb einer Installation. Wenn dieser Modus aktiviert ist, wird die Installations-Routine die Grundseiten für allen Sprachen erstellen, die in dieser Version verfügbar sind.',
'Admin' => 'Verwalter Name',
'AdminDesc' => 'Gib den Benutzernamen des Verwalters an. Sollte ein <a href="http://wackowiki.org/Doc/Deutsch/WikiName" title="View Help" target="_blank">WikiName</a> sein (z.B. WikiAdmin).',
'Password' => 'Verwalter Passwort',
'PasswordDesc' => 'Wähle ein Passwort für den Verwalter mit mindestens 8 Zeichen.',
'Password2' => 'Wiederhole Passwort:',
'Mail' => 'E-Mail Adresse des Verwalters',
'MailDesc' => 'Gib die E-Mail Adresse des Verwalters ein.',
'Base' => 'Basis-URL',
'BaseDesc' => 'Die Basis-URL deines WackoWikis. Die Seitennamen werden an diese angehängt., so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><b><i>http://wackowiki.org/</i></b></li><li><b><i>http://wackowiki.org/wiki/</i></b></li></ul>',
'Rewrite' => 'Umschreiben',
'RewriteDesc' => '<a href="http://wackowiki.org/Doc/Deutsch/RewriteModus" target="_blank">Umschreiben</a> sollte aktiviert sein, falls du WackoWiki mit URL-Umschreiben verwenden willst.',
'Enabled' => 'Aktiviert:',
'ErrorAdminName' => 'Der Verwalter Name muss ein WikiName sein!',
'ErrorAdminEmail' => 'Du hast eine ungültige E-Mailadresse angegeben!',
'ErrorAdminPasswordMismatch' => 'Die Passwörter stimmen nicht überein!',
'ErrorAdminPasswordShort' => 'Das Verwalter Passwort ist zu kurz, die Mindestlänge ist 8 Zeichen!',
'WarningRewriteMode' => 'ACHTUNG!\nDeine Basis-URL & die Umschreib-Rechte (rewrite-mode settings) schauen ungewöhnlich aus. Normalerweise ist da kein ? in der URL wenn Umschreibe-Rechte aktiviert sind - in deinem Fall ist da aber ein Fragezeichen.\n\nUm dennoch mit diesen Einstellungen fortzufahren drücke OK.\nZurück zu den Einstellungen (form & change settings) drücke ABBRECHEN.\n\nFalls du mit den Einstellungen fortfährst, kann diese Software-Installation zu unerwarteten Fehlern führen.',
'ModRewriteStatusUnknown' => 'Der Installer kann nicht ermitteln ob mod_rewrite aktiviert ist, dies bedeutet jedoch nicht das es deaktiviert ist.',

/*
   Database Config Page
*/
'database-config' => 'Datenbank Konfiguration',
'DBDriverDesc' => 'Der Datenbanktreiber der verwendet werden soll. Du musst einen Altsystem (legacy) Treiber wählen falls PHP5.1 (oder größer) und <a href="http://de2.php.net/pdo" target="_blank">PDO</a> nicht zur Verfügung stehen.',
'DBDriver' => 'Treiber',
'DBHost' => 'Host',
'DBHostDesc' => 'Der Server, auf dem deine Datenbank läuft. Normalerweise "localhost" (wenn dein WackoWiki auf dem gleichen Server ist) oder der Host deines Providers.',
'DBPort' => 'Port (Optional)',
'DBPortDesc' => 'Die Port-Nummer über die dein Datenbankservers erreichbar ist, bei Verwendung der default Port Nummer leer lassen.',
'DB' => 'Datenbank Name',
'DBDesc' => 'Die Datenbank für unser WackoWiki. Diese Datenbank muss bereits existieren!',
'DBUserDesc' => 'Name des Benutzers welcher für die Datenbankverbindung verwendet wird.',
'DBUser' => 'Benutzername',
'DBPasswordDesc' => 'Passwort des Benutzers welcher für die Datenbankverbindung verwendet wird.',
'DBPassword' => 'Passwort',
'PrefixDesc' => 'Präfix für alle Tabellen, die von WackoWiki benutzt werden. Man kann eine MySQL-Datenbank für mehrere WackoWikis verwenden in dem man unterschiedliche Tabellenpräfixe verwendet (z.B. wacko_).',
'Prefix' => 'Tabellenpräfix',
'ErrorNoDbDriverDetected' => 'Es wurde kein Datenbanktreiber erkannt, bitte aktiviere entweder die mysql, mysqli oder pdo Erweiterung in deiner php.ini Datei.',
'ErrorNoDbDriverSelected' => 'Es wurde kein Datenbanktreiber ausgewählt, bitte suche den passenden Treiber aus der Liste aus.',
'DeleteTables' => 'Lösche bestehende Tabellen?',
'DeleteTablesDesc' => 'ACHTUNG! Wenn du mit dieser Option fortfährst werden alle aktuellen Wiki-Daten aus deiner Datenbank gelöscht. Dies kann nicht rückgängig gemacht werden, es sei denn, du stellt die die Daten von Hand aus einem gesichert Backup wieder her.',
'ConfirmTableDeletion' => 'Bist du sicher das du alle bestehenden Wiki-Tabellen löschen willst?',

/*
   Database Installation Page
*/
'database-install' => 'Datenbank Installation',
'TestingConfiguration' => 'Teste Konfiguration',
'TestConnectionString' => 'Teste Datenbank Verbindung',
'TestDatabaseExists' => 'Prüfe ob die ausgewählte Datenbank vorhanden ist',
'InstallingTables' => 'Installiere Tabellen',
'ErrorDBConnection' => 'Es gab ein Problem mit den von dir gemachten Datenbank Verbindungsdaten, bitte gehe zurück und prüfe ob diese korrekt sind.',
'ErrorDBExists' => 'Die angegebene Datenbank wurde nicht gefunden. Beachte, diese muss bereits bestehen bevor du WackoWiki installierst/upgradest!',
'To' => 'zu',
'AlterTable' => 'Ändere <tt>%1</tt> Tabelle',
'RenameTable' => 'Benenne <tt>%1</tt> Tabelle um',
'UpdateTable' => 'Aktualisiere <tt>%1</tt> Tabelle',
'InstallingDefaultData' => 'Füge Default Daten hinzu',
'InstallingPagesBegin' => 'Füge Basis-Seiten hinzu',
'InstallingPagesEnd' => 'Die Basis-Seiten wurden hinzugefügt',
'InstallingSystemAccount' => 'Füge Benutzerkonto für System hinzu',
'InstallingAdmin' => 'Füge Benutzerkonto für Verwalter hinzu',
'InstallingAdminSetting' => 'Füge Einstellungen für Verwalter hinzu',
'InstallingAdminGroup' => 'Gruppe Admins hinzugefügt',
'InstallingAdminGroupMember' => 'Gruppe Admins Mitglied hinzugefügt',
'InstallingEverybodyGroup' => 'Gruppe Everybody hinzugefügt',
'InstallingRegisteredGroup' => 'Gruppe Registered hinzugefügt',
'InstallingModeratorGroup' => 'Gruppe Moderator hinzugefügt',
'InstallingReviewerGroup' => 'Gruppe Reviewer hinzugefügt',
'InstallingLogoImage' => 'Füge WackoWiki Logo hinzu',
'InstallingConfigValues' => 'Adding Config Values',
'ErrorInsertingPage' => 'Fehler beim Einfügen der <tt>%1</tt> Seite',
'ErrorInsertingPageReadPermission' => 'Fehler beim Setzen der Lese-Rechte für <tt>%1</tt> Seite',
'ErrorInsertingPageWritePermission' => 'Fehler beim Setzen der Schreib-Rechte für <tt>%1</tt> Seite',
'ErrorInsertingPageCommentPermission' => 'Fehler beim Setzen der Kommentar-Rechte für <tt>%1</tt> Seite',
'ErrorInsertingPageCreatePermission' => 'Error setting create permissions for <tt>%1</tt> page',
'ErrorInsertingPageUploadPermission' => 'Error setting upload permissions for <tt>%1</tt> page',
'ErrorInsertingDefaultBookmark' => 'Fehler beim Setzen der Seite <tt>%1</tt> als Default-Lesezeichen',
'ErrorPageAlreadyExists' => 'Diese <tt>%1</tt> Seite besteht bereits',
'ErrorAlteringTable' => 'Fehler beim Ändern der <tt>%1</tt> Tabelle',
'ErrorRenamingTable' => 'Fehler beim Umbenennen der <tt>%1</tt> Tabelle',
'ErrorUpdatingTable' => 'Fehler beim Aktualisieren der <tt>%1</tt> table',
'CreatingTable' => 'Erstelle <tt>%1</tt> Tabelle',
'ErrorAlreadyExists' => 'Der <tt>%1</tt> existiert bereits',
'ErrorCreatingTable' => 'Fehler beim Erstellen von <tt>%1</tt> Tabelle, besteht diese bereits?',
'ErrorMovingRevisions' => 'Fehler beim Verschieben der Revisionen',
'MovingRevisions' => 'Verschiebe Daten in Tabelle revisions',
'DeletingTables' => 'Lösche Tabellen',
'DeletingTablesEnd' => 'Tabellen wurden gelöscht',
'ErrorDeletingTable' => 'Fehler beim Löschen der <tt>%1</tt> Tabelle, der wahrscheinlichste Grund dafür ist, dass die Tabelle nicht existiert, in diesem Fall kannst du die Warnung ignorieren.',
'DeletingTable' => 'Lösche <tt>%1</tt> Tabelle',

/*
   Write Config Page
*/
'write-config' => 'Schreibe Konfig-Datei',
'FinalStep' => 'Letzter Schritt',
'Writing' => 'Schreibe Konfigurationsdatei',
'RemovingWritePrivilege' => 'Entferne Schreibrechte',
'InstallationComplete' => 'Installation abgeschlossen',
'ThatsAll' => 'Das wars! Du kannst nun <a href="%1"> zu deinem WackoWiki zurückkehren</a>.',
'SecurityConsiderations' => 'Sicherheitserwägungen',
'SecurityRisk' => 'Es wird dringend empfohlen, die Schreibrechte auf die Datei <tt>config.php</tt> nach dem Schreiben der Konfiguration wieder mit <tt>chmod 644</tt> zu entfernen. Eine überschreibbare Konfigurationsdatei ist ein Sicherheitsrisiko!',
'RemoveSetupDirectory' => 'Du solltest den Ordner <tt>"setup"</tt> löschen nachdem die Installation beendet wurde.',
'ErrorGivePrivileges' => 'Die Konfigurationsdatei <tt>%1</tt> konnte nicht geschrieben werden. Du musst dem Webserver vorübergehend Schreibrechte auf das WackoWiki Verzeichnis oder auf eine leere Datei <tt>config.php</tt> (<tt>touch config.php ; chmod 666 config.php</tt> geben; vergiss nicht, das Schreibrecht später wieder zu entziehen, z.B. mit <tt>chmod 644 config.php</tt>). Falls das aus irgendwelchen Gründen nicht möglich ist, kopiere den folgenden Text in eine neue Datei und speichere diese unter <tt>config.php</tt> in dem WackoWiki Verzeichnis ab. Danach sollte dein WackoWiki funktionieren. Falls nicht, gehe zu <a href="http://wackowiki.org/Doc/Deutsch/Installation" target="_blank">WackoWiki:Doc/Deutsch/Installation</a>',
'NextStep' => 'Im nächsten Schritt wird das Installationsprogramm versuchen, die aktualisierte Konfigurationsdatei, <tt>config.php</tt>, zu schreiben. Bitte stelle sicher, dass der Webserver Schreibrechte auf die Datei besitzt oder du musst die Datei von Hand ändern.  Für die Einzelheiten besuche bitte <a href="http://wackowiki.org/Doc/Deutsch/Installation" target="_blank">WackoWiki:Doc/Deutsch/Installation</a>.',
'WrittenAt' => 'eingetragen in ',
'DontChange' => 'Ändere wacko_version nicht von Hand!',
'ConfigDescription' => 'http://wackowiki.org/Doc/Deutsch/Konfiguration',
'TryAgain' => 'Versuche es erneut',
'RemoveWakkaConfigFile' => 'WackoWiki verwendet eine neuere Konfigurationsdatei als deine frühere WakkaWiki Installation.  Die alte Datei konnte nicht automatisch durch das System gelöscht werden und so ist es ratsam die Datei <tt>wakka.config.php</tt> manuell zu löschen.',
'DeletingWakkaConfigFile' => 'Lösche hinfällige Wakka Konfigurationsdatei',

);
?>