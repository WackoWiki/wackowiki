<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'utf-8',
'LangISO' => 'de',
'LangName' => 'Deutsch',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages
	'category_page'		=> 'Kategorie',
	'groups_page'		=> 'Gruppen',
	'users_page'		=> 'Benutzer',

	'search_page'		=> 'Suche',
	'login_page'		=> 'Anmeldung',
	'account_page'		=> 'Konto',
	'registration_page'	=> 'Registrierung',
	'password_page'		=> 'Passwort',

	'changes_page'		=> 'LetzteAenderungen',
	'comments_page'		=> 'LetzteKommentare',
	'index_page'		=> 'SeitenIndex',

	'random_page'		=> 'RandomPage',

	#'help_page'			=> 'Hilfe',
	#'terms_page'		=> 'Nutzungsbedingungen',
	#'privacy_page'		=> 'Datenschutz',

	// time
	#'date_format'					=> 'd.m.Y',
	#'time_format'					=> 'H:i',
	#'time_format_seconds'			=> 'H:i:s',
],

/*
   Generic Page Text
*/
'Title' => 'WackoWiki Installation',
'Continue' => 'Weiter',
'Back' => 'Zurück',
'Recommended' => 'empfohlen',
'InvalidAction' => 'Ungültige Aktion',

/*
   Language Selection Page
*/
'lang' => 'Spracheinstellungen',
'PleaseUpgradeToR5' => 'Bei dir läuft eine alte (pre %1) Version von WackoWiki (<code class="version">%1</code>). Um auf diese neue Version von WackoWiki zu aktualisieren, musst du zuerst deine Installation auf <code class="version">%2</code> updaten.',
'UpgradeFromWacko' => 'Wilkommen bei WackoWiki, es scheint das du von WackoWiki <strong><code class="version">%1</code></strong> auf <strong><code class="version">%2</code></strong> aktualisierst.  Die nächsten Seiten werden dich durch den Installationsvorgang führen.',
'FreshInstall' => 'Wilkommen bei WackoWiki, du installierst gerade WackoWiki <code class="version">%1</code>. Die nächsten Seiten werden dich durch den Installationsvorgang führen.',
'PleaseBackup' => 'Bitte erstelle eine <strong>Sicherungskopie</strong> von deiner Datenbank und der Konfigurationsdatei config.php und aller geänderter Dateien bevor du den Aktualisierungsvorgang beginnst. Das kann dir im Problemfall viel Ärger ersparen.',
'LangDesc' => 'Wähle eine Sprache für die Installation aus. Das wird die Standardsprache für deine WackoWiki Installation.',

/*
   System Requirements Page
*/
'version-check' => 'System Anforderungen',
'PHPVersion' => 'PHP Version',
'PHPDetected' => 'Erkannt PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Erweiterung (mod_rewrite) Installiert?',
'Database' => 'Datenbank',
'PHPExtensions' => 'PHP Erweiterungen',
'Permissions' => 'Berechtigungen',
'ReadyToInstall' => 'Bereit zur Installation?',
'Requirements' => 'Dein Server muss den folgenden Anforderungen entsprechen.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePHPExtensions' => '',
'ErrorPHPExtensions' => 'In deiner PHP Installation scheinen folgende von WackoWiki benötigte PHP-Erweiterungen nicht verfügbar zu sein.',
'PCREwithoutUTF8' => 'PCRE ist nicht mit UTF-8-Unterstützung kompiliert.',
'NotePermissions' => 'ACHTUNG: Der Installer wird versuchen, die Einstellungen in die Datei %1 zu schreiben, diese Datei befindet sich im WackoWiki Verzeichnis. Damit das funktioniert, muss sichergestellt sein, dass der Webserver Schreibrechte auf diese Datei hat! Falls das nicht möglich ist, musst du die Datei später von Hand geändert werden (das Installationsskript sagt dann, was zu tun ist).<br><br>Lies <a href="https://wackowiki.org/doc/Doc/Deutsch/Installation" target="_blank">WackoWiki:Doc/Deutsch/Installation</a> für weitere Einzelheiten.',
'ErrorPermissions' => 'Es scheint das der Installer nicht die erforderlichen Zugriffsrechte für die Dateien automatisch setzen kann um korrekt zu funktionieren. Du wirst später im Installationsprozess aufgefordert, die erforderlichen Zugriffsrechte händisch auf dem Server zu setzen.',
'ErrorMinPHPVersion' => 'Die PHP Version muss größer als <strong>' . PHP_MIN_VERSION . '</strong> sein, dein Server scheint mit einer füheren Version zu laufen.  Du must auf eine aktuellere PHP Version upgraden damit WackoWiki korrekt funktioniert.',
'Ready' => 'Glückwünsch, dein Server scheint fähig WackoWiki ausführen zu können. Die folgenden Seiten werden dich durch den Konfigurationsprozess führen.',

/*
   Site Config Page
*/
'site-config' => 'Site Konfiguration',
'SiteName' => 'Wiki Name',
'SiteNameDesc' => 'Der Name deines Wikis.',
'HomePage' => 'Startseite',
'HomePageDesc' => 'Der Name der Startseite deines WackoWikis. Sollte ein WikiName sein (z.B. <code>StartSeite</code>), dies wird die Startseite sein deines Wikis und sollte ein <a href="https://wackowiki.org/doc/Doc/Deutsch/WikiName" title="Hilfe lesen" target="_blank">WikiName</a> sein.',
'HomePageDefault' => 'Startseite',
'MultiLang' => 'Mehrsprachen-Modus',
'MultiLangDesc' => 'Der Mehrsprachen-Modus ermöglicht Seiten mit unterschiedlichen Spracheinstellungen innerhalb einer Installation. Wenn dieser Modus aktiviert ist, wird die Installations-Routine die Menüeinträge für allen Sprachen erstellen, die in dieser Version verfügbar sind.',
'AllowedLang' => 'Erlaubte Sprachen',
'AllowedLangDesc' => 'Es wird empfohlen, nur die Sprachen auszuwählen, die verwendet werden sollen, anderenfalls werden alle Sprachen ausgewählt.',
'Admin' => 'Verwalter Name',
'AdminDesc' => 'Gib den Benutzernamen des Verwalters an. Sollte ein <a href="https://wackowiki.org/doc/Doc/Deutsch/WikiName" title="Hilfe lesen" target="_blank">WikiName</a> sein (z.B. <code>WikiAdmin</code>).',
'Password' => 'Verwalter Passwort',
'PasswordDesc' => 'Wähle ein Passwort für den Verwalter mit mindestens %1 Zeichen.',
'Password2' => 'Wiederhole Passwort:',
'Mail' => 'E-Mail Adresse des Verwalters',
'MailDesc' => 'Gib die E-Mail Adresse des Verwalters ein.',
'Base' => 'Basis-URL',
'BaseDesc' => 'Die Basis-URL deines WackoWikis. Die Seitennamen werden an diese angehängt. Falls mod_rewrite verfügbar ist, muß die URL mit einen Schrägstrich abschließen:</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => 'Umschreiben',
'RewriteDesc' => '<a href="https://wackowiki.org/doc/Doc/Deutsch/RewriteModus" target="_blank">Umschreiben</a> sollte aktiviert sein, falls du WackoWiki mit URL-Umschreiben verwenden willst.',
'Enabled' => 'Aktiviert:',
'ErrorAdminEmail' => 'Du hast eine ungültige E-Mailadresse angegeben!',
'ErrorAdminPasswordMismatch' => 'Die Passwörter stimmen nicht überein!',
'ErrorAdminPasswordShort' => 'Das Verwalter Passwort ist zu kurz, die Mindestlänge ist %1 Zeichen!',
'WarningRewriteMode' => 'ACHTUNG!\nDeine Basis-URL & die Umschreib-Rechte (rewrite-mode settings) schauen ungewöhnlich aus. Normalerweise ist da kein ? in der URL wenn Umschreibe-Rechte aktiviert sind - in deinem Fall ist da aber ein Fragezeichen.\n\nUm dennoch mit diesen Einstellungen fortzufahren drücke OK.\nZurück zu den Einstellungen (form & change settings) drücke ABBRECHEN.\n\nFalls du mit den Einstellungen fortfährst, kann diese Software-Installation zu unerwarteten Fehlern führen.',
'ModRewriteStatusUnknown' => 'Der Installer kann nicht ermitteln ob mod_rewrite aktiviert ist, dies bedeutet jedoch nicht das es deaktiviert ist.',

'LanguageArray'	=> [
	'bg' => 'Bulgarisch',
	'da' => 'Dänisch',
	'nl' => 'Niederländisch',
	'el' => 'Griechisch',
	'en' => 'Englisch',
	'et' => 'Estnisch',
	'fr' => 'Französisch',
	'de' => 'Deutsch',
	'hu' => 'Ungarisch',
	'it' => 'Italienisch',
	'pl' => 'Polnisch',
	'pt' => 'Portugiesisch',
	'ru' => 'Russisch',
	'es' => 'Spanisch',
],

/*
   Database Config Page
*/
'database-config' => 'Datenbank Konfiguration',
'DBDriver' => 'Treiber',
'DBDriverDesc' => 'Der Datenbanktreiber der verwendet werden soll. Du musst einen Altsystem (legacy) Treiber wählen falls <a href="https://secure.php.net/pdo" target="_blank">PDO</a> nicht zur Verfügung steht.',
'DBCharset' => 'Zeichensatz',
'DBCharsetDesc' => 'Der Datenbankzeichensatz, den du verwenden möchtest.',
'DBEngine' => 'Engine',
'DBEngineDesc' => 'Die Datenbank-Engine, die du verwenden möchtest.',
'DBHost' => 'Host',
'DBHostDesc' => 'Der Server, auf dem deine Datenbank läuft. Normalerweise <code>127.0.0.1</code> oder <code>localhost</code> (wenn dein WackoWiki auf dem gleichen Server ist) oder der Host deines Providers.',
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
'DeleteTablesDesc' => 'ACHTUNG! Wenn du mit dieser Option fortfährst, werden alle aktuellen Wiki-Daten aus deiner Datenbank gelöscht. Dies kann nicht rückgängig gemacht werden, es sei denn, du stellt die die Daten von Hand aus einem gesichert Backup wieder her.',
'ConfirmTableDeletion' => 'Bist du sicher das du alle bestehenden Wiki-Tabellen löschen willst?',

/*
   Database Installation Page
*/
'database-install' => 'Datenbank Installation',
'TestingConfiguration' => 'Teste Konfiguration',
'TestConnectionString' => 'Teste Datenbank Verbindung',
'TestDatabaseExists' => 'Prüfe ob die ausgewählte Datenbank vorhanden ist',
'TestDatabaseVersion' => 'Checking database minimum version requirements',
'InstallingTables' => 'Installiere Tabellen',
'ErrorDBConnection' => 'Es gab ein Problem mit den von dir gemachten Datenbank Verbindungsdaten, bitte gehe zurück und prüfe ob diese korrekt sind.',
'ErrorDBExists' => 'Die angegebene Datenbank wurde nicht gefunden. Beachte, diese muss bereits bestehen bevor du WackoWiki installierst/upgradest!',
'ErrorDatabaseVersion' => 'The database version is %1 but requirers at least %2.',
'To' => 'zu',
'AlterTable' => 'Ändere %1 Tabelle',
'InsertRecord' => 'Füge Datensatz in %1 Tabelle ein',
'RenameTable' => 'Benenne %1 Tabelle um',
'UpdateTable' => 'Aktualisiere %1 Tabelle',
'InstallingDefaultData' => 'Füge Default Daten hinzu',
'InstallingPagesBegin' => 'Füge Basis-Seiten hinzu',
'InstallingPagesEnd' => 'Die Basis-Seiten wurden hinzugefügt',
'InstallingSystemAccount' => 'Füge Benutzerkonto <code>System</code> hinzu',
'InstallingDeletedAccount' => 'Füge Benutzerkonto <code>Deleted</code> hinzu',
'InstallingAdmin' => 'Füge Benutzerkonto für Verwalter hinzu',
'InstallingAdminSetting' => 'Füge Einstellungen für Verwalter hinzu',
'InstallingAdminGroup' => 'Gruppe Admins hinzugefügt',
'InstallingAdminGroupMember' => 'Gruppe Admins Mitglied hinzugefügt',
'InstallingEverybodyGroup' => 'Gruppe Everybody hinzugefügt',
'InstallingModeratorGroup' => 'Gruppe Moderator hinzugefügt',
'InstallingReviewerGroup' => 'Gruppe Reviewer hinzugefügt',
'InstallingLogoImage' => 'Füge Logo hinzu',
'LogoImage' => 'Logo image',
'InstallingConfigValues' => 'Füge Config-Werte hinzu',
'ConfigValues' => 'Config-Werte',
'ErrorInsertingPage' => 'Fehler beim Einfügen der %1 Seite',
'ErrorInsertingPagePermission' => 'Fehler beim Setzen der Rechte für %1 Seite',
'ErrorInsertingDefaultMenuItem' => 'Fehler beim Setzen der Seite %1 als Default-Menüeintrag',
'ErrorPageAlreadyExists' => 'Diese %1 Seite besteht bereits',
'ErrorAlteringTable' => 'Fehler beim Ändern der %1 Tabelle',
'ErrorInsertingRecord' => 'Error Inserting Record into %1 table',
'ErrorRenamingTable' => 'Fehler beim Umbenennen der %1 Tabelle',
'ErrorUpdatingTable' => 'Fehler beim Aktualisieren der %1 table',
'CreatingTable' => 'Erstelle %1 Tabelle',
'ErrorAlreadyExists' => 'Der %1 existiert bereits',
'ErrorCreatingTable' => 'Fehler beim Erstellen von %1 Tabelle, besteht diese bereits?',
'ErrorMovingRevisions' => 'Fehler beim Verschieben der Revisionen',
'MovingRevisions' => 'Verschiebe Daten in Tabelle revisions',
'DeletingTables' => 'Lösche Tabellen',
'DeletingTablesEnd' => 'Tabellen wurden gelöscht',
'ErrorDeletingTable' => 'Fehler beim Löschen der %1 Tabelle, der wahrscheinlichste Grund dafür ist, dass die Tabelle nicht existiert, in diesem Fall kannst du die Warnung ignorieren.',
'DeletingTable' => 'Lösche %1 Tabelle',

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
'SecurityRisk' => 'Es wird dringend empfohlen, die Schreibrechte auf die Datei %1 nach dem Schreiben der Konfiguration wieder mit %2 zu entfernen. Eine überschreibbare Konfigurationsdatei ist ein Sicherheitsrisiko!<br>i.e. %2',
'RemoveSetupDirectory' => 'Du solltest den Ordner <code>%1</code> löschen nachdem die Installation beendet wurde.',
'ErrorGivePrivileges' => 'Die Konfigurationsdatei %1 konnte nicht geschrieben werden. Du musst dem Webserver vorübergehend Schreibrechte auf das WackoWiki Verzeichnis oder auf eine leere Datei %1<br>%2<br> geben; vergiss nicht, das Schreibrecht später wieder zu entziehen, z.B. mit %2.<br>Falls das aus irgendwelchen Gründen nicht möglich ist, kopiere den folgenden Text in eine neue Datei und speichere diese unter %1 in dem WackoWiki Verzeichnis ab. Danach sollte dein WackoWiki funktionieren. Falls nicht, gehe zu <a href="https://wackowiki.org/doc/Doc/Deutsch/Installation" target="_blank">WackoWiki:Doc/Deutsch/Installation</a>',
'NextStep' => 'Im nächsten Schritt wird das Installationsprogramm versuchen, die aktualisierte Konfigurationsdatei, %1, zu schreiben. Bitte stelle sicher, dass der Webserver Schreibrechte auf die Datei besitzt oder du musst die Datei von Hand ändern.  Für die Einzelheiten besuche bitte <a href="https://wackowiki.org/doc/Doc/Deutsch/Installation" target="_blank">WackoWiki:Doc/Deutsch/Installation</a>.',
'WrittenAt' => 'geschrieben am ',
'DontChange' => 'Ändere wacko_version nicht von Hand!',
'ConfigDescription' => 'https://wackowiki.org/doc/Doc/Deutsch/Konfiguration',
'TryAgain' => 'Versuche es erneut',

];
