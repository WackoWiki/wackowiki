<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'iso-8859-1',
'LangISO' => 'de',
'LangName' => 'Deutsch',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// site name
	'site_name'			=> 'MyWikiSite',

	// pages
	'category_page'		=> 'Kategorie',
	'groups_page'		=> 'Gruppen',
	'users_page'		=> 'Benutzer',

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
'Back' => 'Zur�ck',
'Recommended' => 'empfohlen',
'InvalidAction' => 'Ung�ltige Aktion',

/*
   Language Selection Page
*/
'lang' => 'Spracheinstellungen',
'PleaseUpgradeToR5' => 'Bei dir l�uft eine alte (pre 5.0.0) Version von WackoWiki (<code class="version">%1</code>). Um auf diese neue Version von WackoWiki zu aktualisieren, musst du zuerst deine Installation auf <code class="version">5.0.x</code> updaten.',
'UpgradeFromWacko' => 'Wilkommen bei WackoWiki, es scheint das du von WackoWiki <strong><code class="version">%1</code></strong> auf <strong><code class="version">%2</code></strong> aktualisierst.  Die n�chsten Seiten werden dich durch den Installationsvorgang f�hren.',
'FreshInstall' => 'Wilkommen bei WackoWiki, du installierst gerade WackoWiki <code class="version">%1</code>. Die n�chsten Seiten werden dich durch den Installationsvorgang f�hren.',
'PleaseBackup' => 'Bitte erstelle eine <strong>Sicherungskopie</strong> von deiner Datenbank und der Konfigurationsdatei config.php und aller ge�nderter Dateien bevor du den Aktualisierungsvorgang beginnst. Das kann dir im Problemfall viel �rger ersparen.',
'LangDesc' => 'W�hle eine Sprache f�r die Installation aus. Das wird die Standardsprache f�r deine WackoWiki Installation.',

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
'ErrorPHPExtensions' => 'In deiner PHP Installation scheinen folgende von WackoWiki ben�tigte PHP-Erweiterungen nicht verf�gbar zu sein.',
'PCREwithoutUTF8' => 'PCRE ist nicht mit UTF-8-Unterst�tzung kompiliert.',
'NotePermissions' => 'ACHTUNG: Der Installer wird versuchen, die Einstellungen in die Datei %1 zu schreiben, diese Datei befindet sich im WackoWiki Verzeichnis. Damit das funktioniert, muss sichergestellt sein, dass der Webserver Schreibrechte auf diese Datei hat! Falls das nicht m�glich ist, musst du die Datei sp�ter von Hand ge�ndert werden (das Installationsskript sagt dann, was zu tun ist).<br><br>Lies <a href="https://wackowiki.org/doc/Doc/Deutsch/Installation" target="_blank">WackoWiki:Doc/Deutsch/Installation</a> f�r weitere Einzelheiten.',
'ErrorPermissions' => 'Es scheint das der Installer nicht die erforderlichen Zugriffsrechte f�r die Dateien automatisch setzen kann um korrekt zu funktionieren. Du wirst sp�ter im Installationsprozess aufgefordert, die erforderlichen Zugriffsrechte h�ndisch auf dem Server zu setzen.',
'ErrorMinPHPVersion' => 'Die PHP Version muss gr��er als <strong>' . PHP_MIN_VERSION . '</strong> sein, dein Server scheint mit einer f�heren Version zu laufen.  Du must auf eine aktuellere PHP Version upgraden damit WackoWiki korrekt funktioniert.',
'Ready' => 'Gl�ckw�nsch, dein Server scheint f�hig WackoWiki ausf�hren zu k�nnen. Die folgenden Seiten werden dich durch den Konfigurationsprozess f�hren.',

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
'MultiLangDesc' => 'Der Mehrsprachen-Modus erm�glicht Seiten mit unterschiedlichen Spracheinstellungen innerhalb einer Installation. Wenn dieser Modus aktiviert ist, wird die Installations-Routine die Grundseiten f�r allen Sprachen erstellen, die in dieser Version verf�gbar sind.',
'AllowedLang' => 'Erlaubte Sprachen',
'AllowedLangDesc' => 'Es wird empfohlen, nur die Sprachen auszuw�hlen, die verwendet werden sollen, anderenfalls werden alle Sprachen ausgew�hlt.',
'Admin' => 'Verwalter Name',
'AdminDesc' => 'Gib den Benutzernamen des Verwalters an. Sollte ein <a href="https://wackowiki.org/doc/Doc/Deutsch/WikiName" title="Hilfe lesen" target="_blank">WikiName</a> sein (z.B. <code>WikiAdmin</code>).',
'Password' => 'Verwalter Passwort',
'PasswordDesc' => 'W�hle ein Passwort f�r den Verwalter mit mindestens %1 Zeichen.',
'Password2' => 'Wiederhole Passwort:',
'Mail' => 'E-Mail Adresse des Verwalters',
'MailDesc' => 'Gib die E-Mail Adresse des Verwalters ein.',
'Base' => 'Basis-URL',
'BaseDesc' => 'Die Basis-URL deines WackoWikis. Die Seitennamen werden an diese angeh�ngt. Falls mod_rewrite verf�gbar ist, mu� die URL mit einen Schr�gstrich abschlie�en:</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => 'Umschreiben',
'RewriteDesc' => '<a href="https://wackowiki.org/doc/Doc/Deutsch/RewriteModus" target="_blank">Umschreiben</a> sollte aktiviert sein, falls du WackoWiki mit URL-Umschreiben verwenden willst.',
'Enabled' => 'Aktiviert:',
'ErrorAdminEmail' => 'Du hast eine ung�ltige E-Mailadresse angegeben!',
'ErrorAdminPasswordMismatch' => 'Die Passw�rter stimmen nicht �berein!',
'ErrorAdminPasswordShort' => 'Das Verwalter Passwort ist zu kurz, die Mindestl�nge ist %1 Zeichen!',
'WarningRewriteMode' => 'ACHTUNG!\nDeine Basis-URL & die Umschreib-Rechte (rewrite-mode settings) schauen ungew�hnlich aus. Normalerweise ist da kein ? in der URL wenn Umschreibe-Rechte aktiviert sind - in deinem Fall ist da aber ein Fragezeichen.\n\nUm dennoch mit diesen Einstellungen fortzufahren dr�cke OK.\nZur�ck zu den Einstellungen (form & change settings) dr�cke ABBRECHEN.\n\nFalls du mit den Einstellungen fortf�hrst, kann diese Software-Installation zu unerwarteten Fehlern f�hren.',
'ModRewriteStatusUnknown' => 'Der Installer kann nicht ermitteln ob mod_rewrite aktiviert ist, dies bedeutet jedoch nicht das es deaktiviert ist.',

'LanguageArray'	=> [
	'bg' => 'Bulgarisch',
	'da' => 'D�nisch',
	'nl' => 'Niederl�ndisch',
	'el' => 'Griechisch',
	'en' => 'Englisch',
	'et' => 'Estnisch',
	'fr' => 'Franz�sisch',
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
'DBDriverDesc' => 'Der Datenbanktreiber der verwendet werden soll. Du musst einen Altsystem (legacy) Treiber w�hlen falls <a href="http://de2.php.net/pdo" target="_blank">PDO</a> nicht zur Verf�gung steht.',
'DBCharset' => 'Zeichensatz',
'DBCharsetDesc' => 'Der Datenbankzeichensatz, den du verwenden m�chtest.',
'DBEngine' => 'Engine',
'DBEngineDesc' => 'Die Datenbank-Engine, die du verwenden m�chtest. Es muss die MyISAM-Engine verwendet werden, wenn MariaDB 10 oder MySql 5.6 (oder gr��er) und InnoDB Unterst�tzung nicht verf�gbar ist.',
'DBHost' => 'Host',
'DBHostDesc' => 'Der Server, auf dem deine Datenbank l�uft. Normalerweise <code>127.0.0.1</code> oder <code>localhost</code> (wenn dein WackoWiki auf dem gleichen Server ist) oder der Host deines Providers.',
'DBPort' => 'Port (Optional)',
'DBPortDesc' => 'Die Port-Nummer �ber die dein Datenbankservers erreichbar ist, bei Verwendung der default Port Nummer leer lassen.',
'DB' => 'Datenbank Name',
'DBDesc' => 'Die Datenbank f�r unser WackoWiki. Diese Datenbank muss bereits existieren!',
'DBUserDesc' => 'Name des Benutzers welcher f�r die Datenbankverbindung verwendet wird.',
'DBUser' => 'Benutzername',
'DBPasswordDesc' => 'Passwort des Benutzers welcher f�r die Datenbankverbindung verwendet wird.',
'DBPassword' => 'Passwort',
'PrefixDesc' => 'Pr�fix f�r alle Tabellen, die von WackoWiki benutzt werden. Man kann eine MySQL-Datenbank f�r mehrere WackoWikis verwenden in dem man unterschiedliche Tabellenpr�fixe verwendet (z.B. wacko_).',
'Prefix' => 'Tabellenpr�fix',
'ErrorNoDbDriverDetected' => 'Es wurde kein Datenbanktreiber erkannt, bitte aktiviere entweder die mysql, mysqli oder pdo Erweiterung in deiner php.ini Datei.',
'ErrorNoDbDriverSelected' => 'Es wurde kein Datenbanktreiber ausgew�hlt, bitte suche den passenden Treiber aus der Liste aus.',
'DeleteTables' => 'L�sche bestehende Tabellen?',
'DeleteTablesDesc' => 'ACHTUNG! Wenn du mit dieser Option fortf�hrst, werden alle aktuellen Wiki-Daten aus deiner Datenbank gel�scht. Dies kann nicht r�ckg�ngig gemacht werden, es sei denn, du stellt die die Daten von Hand aus einem gesichert Backup wieder her.',
'ConfirmTableDeletion' => 'Bist du sicher das du alle bestehenden Wiki-Tabellen l�schen willst?',

/*
   Database Installation Page
*/
'database-install' => 'Datenbank Installation',
'TestingConfiguration' => 'Teste Konfiguration',
'TestConnectionString' => 'Teste Datenbank Verbindung',
'TestDatabaseExists' => 'Pr�fe ob die ausgew�hlte Datenbank vorhanden ist',
'InstallingTables' => 'Installiere Tabellen',
'ErrorDBConnection' => 'Es gab ein Problem mit den von dir gemachten Datenbank Verbindungsdaten, bitte gehe zur�ck und pr�fe ob diese korrekt sind.',
'ErrorDBExists' => 'Die angegebene Datenbank wurde nicht gefunden. Beachte, diese muss bereits bestehen bevor du WackoWiki installierst/upgradest!',
'To' => 'zu',
'AlterTable' => '�ndere <code>%1</code> Tabelle',
'RenameTable' => 'Benenne <code>%1</code> Tabelle um',
'UpdateTable' => 'Aktualisiere <code>%1</code> Tabelle',
'InstallingDefaultData' => 'F�ge Default Daten hinzu',
'InstallingPagesBegin' => 'F�ge Basis-Seiten hinzu',
'InstallingPagesEnd' => 'Die Basis-Seiten wurden hinzugef�gt',
'InstallingSystemAccount' => 'F�ge Benutzerkonto f�r System hinzu',
'InstallingAdmin' => 'F�ge Benutzerkonto f�r Verwalter hinzu',
'InstallingAdminSetting' => 'F�ge Einstellungen f�r Verwalter hinzu',
'InstallingAdminGroup' => 'Gruppe Admins hinzugef�gt',
'InstallingAdminGroupMember' => 'Gruppe Admins Mitglied hinzugef�gt',
'InstallingEverybodyGroup' => 'Gruppe Everybody hinzugef�gt',
'InstallingModeratorGroup' => 'Gruppe Moderator hinzugef�gt',
'InstallingReviewerGroup' => 'Gruppe Reviewer hinzugef�gt',
'InstallingLogoImage' => 'F�ge WackoWiki Logo hinzu',
'InstallingConfigValues' => 'F�ge Config Werte hinzu',
'ErrorInsertingPage' => 'Fehler beim Einf�gen der <code>%1</code> Seite',
'ErrorInsertingPageReadPermission' => 'Fehler beim Setzen der Lese-Rechte f�r <code>%1</code> Seite',
'ErrorInsertingPageWritePermission' => 'Fehler beim Setzen der Schreib-Rechte f�r <code>%1</code> Seite',
'ErrorInsertingPageCommentPermission' => 'Fehler beim Setzen der Kommentar-Rechte f�r <code>%1</code> Seite',
'ErrorInsertingPageCreatePermission' => 'Fehler beim Setzen der Erstell-Rechte f�r <code>%1</code> Seite',
'ErrorInsertingPageUploadPermission' => 'Fehler beim Setzen der Hochlad-Rechte f�r <code>%1</code> Seite',
'ErrorInsertingDefaultMenuItem' => 'Fehler beim Setzen der Seite <code>%1</code> als Default-Men�eintrag',
'ErrorPageAlreadyExists' => 'Diese <code>%1</code> Seite besteht bereits',
'ErrorAlteringTable' => 'Fehler beim �ndern der <code>%1</code> Tabelle',
'ErrorRenamingTable' => 'Fehler beim Umbenennen der <code>%1</code> Tabelle',
'ErrorUpdatingTable' => 'Fehler beim Aktualisieren der <code>%1</code> table',
'CreatingTable' => 'Erstelle <code>%1</code> Tabelle',
'ErrorAlreadyExists' => 'Der <code>%1</code> existiert bereits',
'ErrorCreatingTable' => 'Fehler beim Erstellen von <code>%1</code> Tabelle, besteht diese bereits?',
'ErrorMovingRevisions' => 'Fehler beim Verschieben der Revisionen',
'MovingRevisions' => 'Verschiebe Daten in Tabelle revisions',
'DeletingTables' => 'L�sche Tabellen',
'DeletingTablesEnd' => 'Tabellen wurden gel�scht',
'ErrorDeletingTable' => 'Fehler beim L�schen der <code>%1</code> Tabelle, der wahrscheinlichste Grund daf�r ist, dass die Tabelle nicht existiert, in diesem Fall kannst du die Warnung ignorieren.',
'DeletingTable' => 'L�sche <code>%1</code> Tabelle',

/*
   Write Config Page
*/
'write-config' => 'Schreibe Konfig-Datei',
'FinalStep' => 'Letzter Schritt',
'Writing' => 'Schreibe Konfigurationsdatei',
'RemovingWritePrivilege' => 'Entferne Schreibrechte',
'InstallationComplete' => 'Installation abgeschlossen',
'ThatsAll' => 'Das wars! Du kannst nun <a href="%1"> zu deinem WackoWiki zur�ckkehren</a>.',
'SecurityConsiderations' => 'Sicherheitserw�gungen',
'SecurityRisk' => 'Es wird dringend empfohlen, die Schreibrechte auf die Datei %1 nach dem Schreiben der Konfiguration wieder mit %2 zu entfernen. Eine �berschreibbare Konfigurationsdatei ist ein Sicherheitsrisiko!',
'RemoveSetupDirectory' => 'Du solltest den Ordner <code><code>setup/</code></code> l�schen nachdem die Installation beendet wurde.',
'ErrorGivePrivileges' => 'Die Konfigurationsdatei %1 konnte nicht geschrieben werden. Du musst dem Webserver vor�bergehend Schreibrechte auf das WackoWiki Verzeichnis oder auf eine leere Datei %1<br>%2<br> geben; vergiss nicht, das Schreibrecht sp�ter wieder zu entziehen, z.B. mit %2.<br>Falls das aus irgendwelchen Gr�nden nicht m�glich ist, kopiere den folgenden Text in eine neue Datei und speichere diese unter %1 in dem WackoWiki Verzeichnis ab. Danach sollte dein WackoWiki funktionieren. Falls nicht, gehe zu <a href="https://wackowiki.org/doc/Doc/Deutsch/Installation" target="_blank">WackoWiki:Doc/Deutsch/Installation</a>',
'NextStep' => 'Im n�chsten Schritt wird das Installationsprogramm versuchen, die aktualisierte Konfigurationsdatei, %1, zu schreiben. Bitte stelle sicher, dass der Webserver Schreibrechte auf die Datei besitzt oder du musst die Datei von Hand �ndern.  F�r die Einzelheiten besuche bitte <a href="https://wackowiki.org/doc/Doc/Deutsch/Installation" target="_blank">WackoWiki:Doc/Deutsch/Installation</a>.',
'WrittenAt' => 'geschrieben am ',
'DontChange' => '�ndere wacko_version nicht von Hand!',
'ConfigDescription' => 'https://wackowiki.org/doc/Doc/Deutsch/Konfiguration',
'TryAgain' => 'Versuche es erneut',

];
?>