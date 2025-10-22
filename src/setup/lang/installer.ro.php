<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'ro',
'LangLocale'	=> 'ro_RO',
'LangName'		=> 'Romanian',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'Categorie',
	'groups_page'		=> 'Grupuri',
	'users_page'		=> 'Utilizatori',

	'search_page'		=> 'Caută',
	'login_page'		=> 'Autentificare',
	'account_page'		=> 'Setări',
	'registration_page'	=> 'Înregistrare',
	'password_page'		=> 'Parolă',

	'whatsnew_page'		=> 'WhatsNew',
	'changes_page'		=> 'Modificări',
	'comments_page'		=> 'Comentat',
	'index_page'		=> 'PageIndex',

	'random_page'		=> 'Aleator',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'Instalare WackoWiki',
'TitleUpdate'					=> 'Actualizare WackoWiki',
'Continue'						=> 'Continuă',
'Back'							=> 'Înapoi',
'Recommended'					=> 'recomandat',
'InvalidAction'					=> 'Acțiune nevalidă',

/*
   Language Selection Page
*/
'lang'							=> 'Configurare limbă',
'PleaseUpgradeToR6'				=> 'Se pare că rulezi o versiune veche de WackoWiki %1. Pentru a actualiza la această versiune de WackoWiki, trebuie mai întâi să actualizați instalarea la %2.',
'UpgradeFromWacko'				=> 'Bine ați venit la WackoWiki! Se pare că faceți upgrade de la WackoWiki %1 la %2. Următoarele câteva pagini vă vor ghida prin procesul de actualizare.',
'FreshInstall'					=> 'Bine ați venit la WackoWiki! Urmează să instalați WackoWiki %1. Următoarele câteva pagini vă vor ghida prin procesul de instalare.',
'PleaseBackup'					=> 'Vă rugăm, <strong>copiați copia de rezervă</strong> bazei de date fișierul de configurare și toate fișierele modificate, cum ar fi cele care au hack-uri locale și patch-uri aplicate acestora înainte de a începe procesul de actualizare. Acest lucru vă poate salva de o durere de cap mare.',
'LangDesc'						=> 'Vă rugăm să alegeți o limbă pentru procesul de instalare. Această limbă va fi folosită și ca limbă implicită pentru instalarea WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Cerințele de sistem',
'PhpVersion'					=> 'Versiune PHP',
'PhpDetected'					=> 'PHP detectat',
'ModRewrite'					=> 'Rescriere extensie Apache (opțional)',
'ModRewriteInstalled'			=> 'Rescrieți extensia (mod_rewrite)?',
'Database'						=> 'Baza de date',
'PhpExtensions'					=> 'Extensii PHP',
'Permissions'					=> 'Permisiuni',
'ReadyToInstall'				=> 'Ești gata să instalezi?',
'Requirements'					=> 'Serverul tău trebuie să îndeplinească cerințele enumerate mai jos.',
'OK'							=> 'Ok',
'Problem'						=> 'Problemă',
'Example'						=> 'Exemplu',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Instalarea dvs PHP pare să nu conțină extensiile PHP indicate, necesare pentru WackoWiki.',
'PcreWithoutUtf8'				=> 'PCRE nu este compilat cu sprijinul UTF-8.',
'NotePermissions'				=> 'Acest instalator va încerca să scrie datele de configurare în fișierul %1, localizat în directorul WackoWiki. Pentru ca acest lucru să funcționeze, trebuie să vă asigurați că serverul web are acces la scriere la acest fișier. Dacă nu puteți face acest lucru, va trebui să editați fișierul manual (instalatorul vă va spune cum).<br><br>Vezi <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> pentru detalii.',
'ErrorPermissions'				=> 'Se pare că instalarea nu poate seta automat permisiunile de fișier necesare pentru ca WackoWiki să funcționeze corect. Vi se va solicita mai târziu în procesul de instalare să configurezi manual permisiunile de fișier necesare pe serverul tău.',
'ErrorMinPhpVersion'			=> 'Versiunea PHP trebuie să fie mai mare decât %1. Serverul tău pare să ruleze o versiune mai veche. Trebuie să faceți upgrade la o versiune mai recentă de PHP pentru ca WackoWiki să funcționeze corect.',
'Ready'							=> 'Felicitări, se pare că serverul tău este capabil să ruleze WackoWiki. Următoarele câteva pagini te vor duce prin procesul de configurare.',

/*
   Site Config Page
*/
'config-site'					=> 'Configurare site',
'SiteName'						=> 'Nume Wiki',
'SiteNameDesc'					=> 'Te rugăm să introduci numele site-ului tău Wiki.',
'SiteNameDefault'				=> 'MyWikiSite',
'HomePage'						=> 'Pagina de start',
'HomePageDesc'					=> 'Introduceți numele pe care doriți să îl aveți pe pagina de pornire. Acesta va fi pagina implicită pe care utilizatorii o vor vedea când vor vizita site-ul și ar trebui să fie un <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Pagina principală',
'MultiLang'						=> 'Mod multilingv',
'MultiLangDesc'					=> 'Modul multilingv vă permite să aveți pagini cu setări diferite de limbă într-o singură instalare. Când acest mod este activat, instalatorul creează elemente de meniu inițiale pentru toate limbile disponibile în distribuție.',
'AllowedLang'					=> 'Limbi permise',
'AllowedLangDesc'				=> 'Este recomandat să selectați doar setul de limbi pe care doriți să le utilizați, altfel toate limbile sunt selectate.',
'AclMode'						=> 'Setări ACL implicite',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Wiki public (citit pentru toată lumea, scrie și comentează pentru utilizatorii înregistrați)',
'PrivateWiki'					=> 'Wiki privat (citire, scriere, comentariu doar pentru utilizatorii înregistrați)',
'Admin'							=> 'Nume Administrator',
'AdminDesc'						=> 'Introduceți numele de utilizator al administratorului. Acesta ar trebui să fie un <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (de ex. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Numele de utilizator trebuie să fie între %1 și %2 lung și să folosească doar caractere alfanumerice. Caracterele mari sunt OK.',
'NameCamelCaseOnly'				=> 'Numele de utilizator trebuie să fie între %1 și %2 caractere lungi și WikiName formatat.',
'Password'						=> 'Parolă Admin',
'PasswordDesc'					=> 'Alegeți o parolă pentru administratorul cu minim %1 caractere.',
'PasswordConfirm'				=> 'Repetă parola:',
'Mail'							=> 'Adresă e-mail administrator',
'MailDesc'						=> 'Introduceți adresa de e-mail a administratorului.',
'Base'							=> 'URL de bază',
'BaseDesc'						=> 'URL-ul de bază al site-ului WackoWiki. Numele paginii sunt anexate lui, deci dacă utilizați mod_rewrite adresa ar trebui să se termine cu un slash, adică',
'Rewrite'						=> 'Mod Rescriere',
'RewriteDesc'					=> 'Modul de Rescriere ar trebui să fie activat dacă utilizați WackoWiki cu rescrierea de URL-uri.',
'Enabled'						=> 'Activat:',
'ErrorAdminEmail'				=> 'Ați introdus o adresă de e-mail invalidă!',
'ErrorAdminPasswordMismatch'	=> 'Parolele nu se potrivesc!.',
'ErrorAdminPasswordShort'		=> 'Parola de administrare este prea scurtă! Lungimea minimă este de %1 caractere.',
'ModRewriteStatusUnknown'		=> 'Instalatorul nu poate verifica dacă mod_rewrite este activat. Cu toate acestea, nu înseamnă că este dezactivat.',

/*
   Database Config Page
*/
'config-database'				=> 'Configurare bază de date',
'DbDriver'						=> 'Șofer',
'DbDriverDesc'					=> 'Șoferul bazei de date pe care doriți să îl folosiți.',
'DbSqlMode'						=> 'Mod SQL',
'DbSqlModeDesc'					=> 'Modul SQL pe care doriţi să-l utilizaţi.',
'DbVendor'						=> 'Furnizor',
'DbVendorDesc'					=> 'Furnizorul bazei de date pe care il folositi.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'Baza de date pe care doriţi să o folosiţi.',
'DbEngine'						=> 'Motor',
'DbEngineDesc'					=> 'Motorul bazei de date pe care doriți să îl folosiți.',
'DbHost'						=> 'Gazdă',
'DbHostDesc'					=> 'Găzduiește serverul bazei tale de date, de obicei <code>127.0.0.1</code> sau <code>localhost</code> (adică, aceeași mașinărie pe care se află site-ul tău WackoWiki).',
'DbPort'						=> 'Port (opţional)',
'DbPortDesc'					=> 'Numărul portului prin care serverul bazei de date este accesibil. Lăsați necompletat pentru a utiliza numărul implicit de port.',
'DbName'						=> 'Numele bazei de date',
'DbNameDesc'					=> 'Baza de date WackoWiki ar trebui să folosească. Această bază de date trebuie să existe deja înainte de a continua!',
'DbUser'						=> 'Nume Utilizator',
'DbUserDesc'					=> 'Numele utilizatorului folosit pentru conectarea la baza ta de date.',
'DbPassword'					=> 'Parolă',
'DbPasswordDesc'				=> 'Parola utilizatorului folosită pentru conectarea la baza de date.',
'Prefix'						=> 'Prefix tabel',
'PrefixDesc'					=> 'Prefixul tuturor tabelelor folosite de WackoWiki. Acest lucru vă permite să rulați mai multe instalații WackoWiki folosind aceeași bază de date prin configurarea lor pentru a utiliza prefixele de tabel diferite (de ex. wacko_).',
'ErrorNoDbDriverDetected'		=> 'Nu a fost detectat niciun driver pentru baza de date, vă rugăm să activați extensia mysqli sau pdo_mysql din fișierul dvs. php.ini.',
'ErrorNoDbDriverSelected'		=> 'Nu a fost selectat niciun șofer de baze de date, vă rugăm să alegeți unul din listă.',
'DeleteTables'					=> 'Ștergeți tabelele existente?',
'DeleteTablesDesc'				=> 'ATENŢIE! Dacă continuaţi cu această opţiune, toate datele wiki curente vor fi şterse din baza de date. Această acțiune nu poate fi anulată și va fi necesar să restabiliți manual datele dintr-o copie de rezervă.',
'ConfirmTableDeletion'			=> 'Sunteţi sigur că doriţi să ştergeţi toate tabelele wiki curente?',

/*
   Database Installation Page
*/
'install-database'				=> 'Instalarea bazei de date',
'TestingConfiguration'			=> 'Testare configurație',
'TestConnectionString'			=> 'Testarea setărilor de conectare a bazei de date',
'TestDatabaseExists'			=> 'Verificarea dacă baza de date specificată există',
'TestDatabaseVersion'			=> 'Verificarea cerințelor minime ale versiunii în baza de date',
'InstallTables'					=> 'Instalare tabele',
'ErrorDbConnection'				=> 'A apărut o problemă cu detaliile conexiunii bazei de date specificate, te rugăm să mergi înapoi și să verifici dacă sunt corecte.',
'ErrorDatabaseVersion'			=> 'Versiunea bazei de date este %1 dar necesită cel puţin %2.',
'To'							=> 'către',
'AlterTable'					=> 'Modificarea tabelului %1',
'InsertRecord'					=> 'Inserare înregistrare în tabelul %1',
'RenameTable'					=> 'Redenumire tabel %1',
'UpdateTable'					=> 'Actualizarea tabelului %1',
'InstallDefaultData'			=> 'Adăugarea datelor implicite',
'InstallPagesBegin'				=> 'Adăugarea paginilor implicite',
'InstallPagesEnd'				=> 'S-a terminat adăugarea paginilor implicite',
'InstallSystemAccount'			=> 'Adăugare <code>Sistem</code> Utilizator',
'InstallDeletedAccount'			=> 'Adăugare <code>şters</code> utilizator',
'InstallAdmin'					=> 'Adăugare utilizator Admin',
'InstallAdminSetting'			=> 'Adăugare Preferinţe Utilizator Admin',
'InstallAdminGroup'				=> 'Adăugare Grup Administratori',
'InstallAdminGroupMember'		=> 'Adăugare membru al grupului de administratori',
'InstallEverybodyGroup'			=> 'Adăugarea grupului tuturor',
'InstallModeratorGroup'			=> 'Adăugarea grupului de moderatori',
'InstallReviewerGroup'			=> 'Adăugare Grup Revizuitor',
'InstallLogoImage'				=> 'Adăugare imagine logo',
'LogoImage'						=> 'Imagine logo',
'InstallConfigValues'			=> 'Adăugarea valorilor de configurare',
'ConfigValues'					=> 'Valori de configurare',
'ErrorInsertPage'				=> 'Eroare la inserarea %1 pagină',
'ErrorInsertPagePermission'		=> 'Eroare la setarea permisiunii pentru pagina %1',
'ErrorInsertDefaultMenuItem'	=> 'Eroare la setarea paginii %1 ca element de meniu implicit',
'ErrorPageAlreadyExists'		=> 'Pagina %1 există deja',
'ErrorAlterTable'				=> 'Eroare la modificarea tabelului %1',
'ErrorInsertRecord'				=> 'Eroare la inserarea înregistrării în tabelul %1',
'ErrorRenameTable'				=> 'Eroare la redenumirea tabelului %1',
'ErrorUpdatingTable'			=> 'Eroare la actualizarea tabelului %1',
'CreatingTable'					=> 'Se creează tabelul %1',
'ErrorAlreadyExists'			=> 'The %1 already exists (Automatic Copy)',
'ErrorCreatingTable'			=> 'Eroare la crearea tabelului %1 , există deja?',
'DeletingTables'				=> 'Ştergere tabele',
'DeletingTablesEnd'				=> 'Stergere tabele terminate',
'ErrorDeletingTable'			=> 'Eroare la ștergerea tabelului %1 . Cel mai probabil motiv este că tabelul nu există, caz în care puteți ignora acest avertisment.',
'DeletingTable'					=> 'Ștergere tabel %1',
'NextStep'						=> 'În pasul următor, instalatorul va încerca să scrie fișierul de configurare actualizat, %1. Asigurați-vă că serverul web are acces la scriere în fișier, sau va trebui să îl editați manual. Încă o dată, vezi  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> pentru detalii.',

/*
   Write Config Page
*/
'write-config'					=> 'Scrie fișier de configurare',
'FinalStep'						=> 'Ultimul pas',
'Writing'						=> 'Scrie fișierul de configurare',
'RemovingWritePrivilege'		=> 'Eliminare privilegiu scriere',
'InstallationComplete'			=> 'Instalare completă',
'ThatsAll'						=> 'Asta e tot! Acum puteți să <a href="%1">vedeți site-ul dvs. WackoWiki</a>.',
'SecurityConsiderations'		=> 'Considerații de securitate',
'SecurityRisk'					=> 'Acum ești sfătuit să elimini accesul la scriere la %1 pentru că a fost scris. Lăsarea fişierului care poate fi scris poate fi un risc de securitate!<br> %2',
'RemoveSetupDirectory'			=> 'Ar trebui să ştergeţi directorul %1 acum că procesul de instalare a fost finalizat.',
'ErrorGivePrivileges'			=> 'Fișierul de configurare %1 nu a putut fi scris. Va trebui să dai serverului tău de web acces temporar la scriere fie în directorul WackoWiki, sau un fișier gol numit %1<br>%2<br><br> Nu uita să elimini accesul de scriere din nou mai târziu, adică <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Dacă, din orice motiv, nu puteți face asta, Va trebui să copiați textul de mai jos într-un fișier nou și să îl salvați/încărcați ca %1 în directorul WackoWiki. Odată ce ai făcut acest lucru, site-ul tău WackoWiki ar trebui să funcționeze. Dacă nu, te rugăm să vizitezi <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Odată ce ai făcut acest lucru, site-ul tău WackoWiki ar trebui să funcționeze. Dacă nu, te rugăm să vizitezi <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'scris la ',
'DontChange'					=> 'nu schimba versiunea wacko_manual!',
'ConfigDescription'				=> 'Descriere detaliată: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Încearcă din nou',

];
