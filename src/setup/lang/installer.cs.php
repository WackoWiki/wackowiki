<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'cs',
'LangLocale'	=> 'cs_CZ',
'LangName'		=> 'Czech',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'Kategorie',
	'groups_page'		=> 'Skupiny',
	'users_page'		=> 'Uživatelé',

	'search_page'		=> 'Hledat',
	'login_page'		=> 'Přihlásit',
	'account_page'		=> 'Nastavení',
	'registration_page'	=> 'Registrace',
	'password_page'		=> 'Heslo',

	'whatsnew_page'		=> 'WhatsNew',
	'changes_page'		=> 'PosledníZměny',
	'comments_page'		=> 'NedávnoKomentováno',
	'index_page'		=> 'PageIndex',

	'random_page'		=> 'NáhodnáStránka',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'Instalace WackoWiki',
'TitleUpdate'					=> 'WackoWiki aktualizace',
'Continue'						=> 'Pokračovat',
'Back'							=> 'Zpět',
'Recommended'					=> 'doporučeno',
'InvalidAction'					=> 'Neplatná akce',

/*
   Locking Check
 */
'LockAuthorization'				=> 'Autorizace',
'LockAuthorizationInfo'			=> 'Zadejte prosím heslo, které jste uložili do souboru %1.',
'LockPassword'					=> 'Heslo:',
'LockLogin'						=> 'Přihlásit se',
'LockPasswordInvalid'			=> 'Neplatné heslo.',
'LockedTryLater'				=> 'Tato stránka je aktuálně aktualizována. Opakujte akci později.',
'EmptyAuthFile'					=> 'Chybějící nebo prázdný soubor %1 . Vytvořte soubor a nastavte heslo do tohoto souboru.',


/*
   Language Selection Page
*/
'lang'							=> 'Nastavení jazyka',
'PleaseUpgradeToR6'				=> 'Zdá se, že používáte starou verzi WackoWiki %1. Chcete-li aktualizovat na tuto verzi WackoWiki, musíte nejprve aktualizovat instalaci na %2.',
'UpgradeFromWacko'				=> 'Vítejte na WackoWiki! Zdá se, že jste upgrade z WackoWiki %1 na %2. Několik dalších stránek vás provede aktualizací.',
'FreshInstall'					=> 'Vítejte ve WackoWiki! Chystáte se nainstalovat WackoWiki %1. Několik dalších stránek vás provede instalačním procesem.',
'PleaseBackup'					=> 'Prosím, <strong>zálohujte</strong> svou databázi, konfigurační soubor a všechny změněné soubory, jako jsou ty, které mají místní hacky a záplaty před spuštěním procesu aktualizace. Toto tě může ušetřit z velké bolesti hlavy.',
'LangDesc'						=> 'Vyberte prosím jazyk pro instalační proces. Tento jazyk bude také použit jako výchozí jazyk instalace WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Systémové požadavky',
'PhpVersion'					=> 'Verze PHP',
'PhpDetected'					=> 'Detekováno PHP',
'ModRewrite'					=> 'Rozšíření Apache přepisu (volitelné)',
'ModRewriteInstalled'			=> 'Přepsat rozšíření (mod_rewrite) nainstalované?',
'Database'						=> 'Databáze',
'PhpExtensions'					=> 'PHP rozšíření',
'Permissions'					=> 'Práva',
'ReadyToInstall'				=> 'Připraveno k instalaci?',
'Requirements'					=> 'Váš server musí splňovat níže uvedené požadavky.',
'OK'							=> 'OK',
'Problem'						=> 'Problém',
'Example'						=> 'Příklad',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Zdá se, že vaše instalace PHP chybí uvedená rozšíření PHP, která WackoWiki vyžaduje.',
'PcreWithoutUtf8'				=> 'PCRE není kompilován s podporou UTF-8.',
'NotePermissions'				=> 'Tento instalátor se pokusí zapsat konfigurační data do souboru %1ve vašem adresáři WackoWiki. Aby to fungovalo, musíte se ujistit, že webový server má přístup k tomuto souboru. Pokud to neuděláte, budete muset soubor upravovat ručně (instalátor vám řekne jak).<br><br>Viz <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> pro podrobnosti.',
'ErrorPermissions'				=> 'Zdá se, že instalační program nemůže automaticky nastavit požadovaná oprávnění pro správné fungování WackoWiki. V instalačním procesu budete vyzváni k manuálnímu nastavení požadovaných oprávnění k souboru na vašem serveru.',
'ErrorMinPhpVersion'			=> 'Verze PHP musí být větší než %1. Zdá se, že váš server používá starší verzi. Musíte aktualizovat na novější verzi PHP, aby WackoWiki fungovala správně.',
'Ready'							=> 'Gratulujeme, zdá se, že váš server je schopen spustit WackoWiki. Následující několik stránek vás provede v procesu nastavení.',

/*
   Site Config Page
*/
'config-site'					=> 'Konfigurace webu',
'SiteName'						=> 'Název Wiki',
'SiteNameDesc'					=> 'Zadejte název vašeho Wiki stránky.',
'SiteNameDefault'				=> 'MyWikiSite',
'HomePage'						=> 'Domovská stránka',
'HomePageDesc'					=> 'Zadejte jméno, které chcete mít na domovské stránce. Toto bude výchozí stránka uživatelů uvidí, kdy navštíví vaše stránky a mělo by být <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Domovská stránka',
'MultiLang'						=> 'Vícejazyčný režim',
'MultiLangDesc'					=> 'Vícejazyčný režim umožňuje mít v rámci jedné instalace stránky s jiným nastavením jazyka. Pokud je tento režim povolen, instalátor vytvoří výchozí položky nabídky pro všechny jazyky dostupné v distribuci.',
'AllowedLang'					=> 'Povolené jazyky',
'AllowedLangDesc'				=> 'Doporučuje se vybrat pouze sadu jazyků, které chcete použít, jinak budou vybrány všechny jazyky.',
'AclMode'						=> 'Výchozí nastavení ACL',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Veřejná Wiki (čtěte pro každého, napište a komentujte pro registrované uživatele)',
'PrivateWiki'					=> 'Soukromá Wiki (čtení, zápis, komentář pouze pro registrované uživatele)',
'Admin'							=> 'Název správce',
'AdminDesc'						=> 'Zadejte uživatelské jméno administrátora. Toto by mělo být <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (např. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Uživatelské jméno musí být v rozmezí %1 až %2 znaků dlouhé a používat pouze alfanumerické znaky. Velká písmena jsou OK.',
'NameCamelCaseOnly'				=> 'Uživatelské jméno musí být mezi %1 a %2 znaky dlouhé a WikiName formátované.',
'Password'						=> 'Heslo administrátora',
'PasswordDesc'					=> 'Zvolte heslo pro administrátora s minimem %1 znaků.',
'PasswordConfirm'				=> 'Opakovat heslo:',
'Mail'							=> 'E-mailová adresa správce',
'MailDesc'						=> 'Zadejte e-mailovou adresu administrátora.',
'Base'							=> 'Základní URL',
'BaseDesc'						=> 'Vaše URL adresa webu WackoWiki Názvy stránek jsou připojeny, takže pokud používáte mod_rewrite měla by adresa končit lomítkem vpřed, tj.',
'Rewrite'						=> 'Režim přepisu',
'RewriteDesc'					=> 'Přepis by měl být povolen, pokud používáte WackoWiki s přepisem URL.',
'Enabled'						=> 'Povoleno:',
'ErrorAdminEmail'				=> 'Zadali jste neplatnou e-mailovou adresu!',
'ErrorAdminPasswordMismatch'	=> 'Hesla nesouhlasí!.',
'ErrorAdminPasswordShort'		=> 'Heslo administrátora je příliš krátké! Minimální délka je %1 znaků.',
'ModRewriteStatusUnknown'		=> 'Instalační program nemůže ověřit, zda je aktivní mod_rewriting. To však neznamená, že je zakázán.',

/*
   Database Config Page
*/
'config-database'				=> 'Nastavení databáze',
'DbDriver'						=> 'Řidič',
'DbDriverDesc'					=> 'Ovladač databáze, kterou chcete použít.',
'DbSqlMode'						=> 'Režim SQL',
'DbSqlModeDesc'					=> 'Režim SQL, který chcete použít.',
'DbVendor'						=> 'Dodavatel',
'DbVendorDesc'					=> 'Dodavatel databáze, který používáte.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'Znaková sada databáze, kterou chcete použít.',
'DbEngine'						=> 'Motor',
'DbEngineDesc'					=> 'Databázový modul, který chcete použít.',
'DbHost'						=> 'Hostitel',
'DbHostDesc'					=> 'Hostitel vašeho databázového serveru běží, obvykle <code>127.0.0.0.1</code> nebo <code>localhost</code> (tj. stejný stroj je vaše WackoWiki stránka).',
'DbPort'						=> 'Port (nepovinné)',
'DbPortDesc'					=> 'Port číslo vašeho databázového serveru je přístupné. Nechte prázdné pro použití výchozího čísla portu.',
'DbName'						=> 'Název databáze',
'DbNameDesc'					=> 'Databáze WackoWiki by měla být používána. Tato databáze musí existovat, než budete pokračovat!',
'DbNameSqliteDesc'				=> 'Datový adresář a název souboru SQLite by měl být použit pro WackoWiki.',
'DbNameSqliteHelp'				=> 'SQLite ukládá všechna data do jediného souboru.<br><br>Adresář, který zadáte, musí být během instalace přístupný pro zápis webovým serverem.<br><br>Neměl by být přístupný přes web. <br><br>Instalační program spolu s ním zapíše soubor <code>.htaccess</code>, ale pokud se to nepodaří, někdo může získat přístup k vaší surové databázi.<br>To zahrnuje surová uživatelská data (e-mailové adresy, hashovaná hesla) i chráněné stránky a další omezená data na wiki.<br><br>Zvažte umístění databáze úplně jinam, například do <code>/var/lib/wackowiki/yourwiki</code>.',
'DbUser'						=> 'Uživatelské jméno',
'DbUserDesc'					=> 'Jméno uživatele použité k připojení k databázi.',
'DbPassword'					=> 'Heslo',
'DbPasswordDesc'				=> 'Heslo uživatele použité k připojení k databázi.',
'Prefix'						=> 'Předpona tabulek',
'PrefixDesc'					=> 'Předpona všech tabulek používaných WackoWiki. To vám umožní spustit více instalací WackoWiki pomocí stejné databáze tím, že je nastavíte tak, že použijete různé prefixy tabulek (např. wacko_).',
'ErrorNoDbDriverDetected'		=> 'Nebyl nalezen žádný ovladač databáze, povolte prosím rozšíření mysqli nebo pdo_mysql v souboru php.ini.',
'ErrorNoDbDriverSelected'		=> 'Nebyl vybrán žádný ovladač databáze, vyberte prosím ze seznamu.',
'DeleteTables'					=> 'Smazat existující tabulky?',
'DeleteTablesDesc'				=> 'POZOR! Pokud budete pokračovat v této volbě, všechna současná wiki data budou vymazána z vaší databáze. Toto nelze vrátit zpět a budete muset ručně obnovit data ze zálohy.',
'ConfirmTableDeletion'			=> 'Jste si jisti, že chcete odstranit všechny aktuální tabulky wiki?',

/*
   Database Installation Page
*/
'install-database'				=> 'Instalace databáze',
'TestingConfiguration'			=> 'Testovací konfigurace',
'TestConnectionString'			=> 'Testování nastavení připojení k databázi',
'TestDatabaseExists'			=> 'Kontroluji zda databáze, kterou jste zadali existuje',
'TestDatabaseVersion'			=> 'Kontrola minimálních požadavků na verzi databáze',
'SqliteFileExtensionError'		=> 'Použijte prosím jednu z následujících přípon souborů db, sdb, sqlite.',
'SqliteParentUnwritableGroup'	=> 'Nelze vytvořit datový adresář <code>%1</code>, protože do nadřazeného adresáře <code>%2</code> nelze webový server zapisovat.<br><br>Instalátor určil uživatele, který webserver běží jako.<br>Udělejte, aby adresář <code>%3</code> mohl zapisovat a pokračovat.<br>Na Unix/Linuxu do:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> 'Nelze vytvořit datový adresář <code>%1</code>, protože do nadřazeného adresáře <code>%2</code> nelze webový server zapisovat.<br><br>Instalátor nemohl určit uživatele, který webserver běží jako.<br>Udělej adresář <code>%3</code> pro globální zápis a další!) pro pokračování.<br>Na Unix/Linuxu do:<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> 'Chyba při vytváření datového adresáře <code>%1</code>.<br>Zkontrolujte polohu a zkuste to znovu.',
'SqliteDirUnwritable'			=> 'Nelze zapisovat do adresáře <code>%1</code>.<br>Změňte jeho oprávnění tak, aby na něj mohl webový server zapisovat a opakujte akci.',
'SqliteReadonly'				=> 'Soubor <code>%1</code> není zapisovatelný.',
'SqliteCantCreateDb'			=> 'Nelze vytvořit databázový soubor <code>%1</code>.',
'InstallTables'					=> 'Instalace tabulek',
'ErrorDbConnection'				=> 'Vyskytl se problém s údaji o připojení k databázi, které jste zadali, vraťte se prosím zpět a zkontrolujte, zda jsou správné.',
'ErrorDatabaseVersion'			=> 'Verze databáze je %1 , ale vyžaduje alespoň %2.',
'To'							=> 'do',
'AlterTable'					=> 'Upozorňuje se na tabulku %1',
'InsertRecord'					=> 'Vkládání záznamu do tabulky %1',
'RenameTable'					=> 'Přejmenování tabulky %1',
'UpdateTable'					=> 'Aktualizuji tabulku %1',
'InstallDefaultData'			=> 'Přidávání výchozích dat',
'InstallPagesBegin'				=> 'Přidávání výchozích stránek',
'InstallPagesEnd'				=> 'Dokončeno přidávání výchozích stránek',
'InstallSystemAccount'			=> 'Přidávání <code>System</code> uživatele',
'InstallDeletedAccount'			=> 'Přidání <code>smazáno</code> uživatel',
'InstallAdmin'					=> 'Přidávání uživatele administrátora',
'InstallAdminSetting'			=> 'Přidávání uživatelských předvoleb administrátora',
'InstallAdminGroup'				=> 'Přidávání skupiny administrátorů',
'InstallAdminGroupMember'		=> 'Přidávám člena skupiny Admins',
'InstallEverybodyGroup'			=> 'Přidávám skupinu všech',
'InstallModeratorGroup'			=> 'Přidávání Moderátorové skupiny',
'InstallReviewerGroup'			=> 'Přidávání skupiny recenzentů',
'InstallLogoImage'				=> 'Přidávání obrázku loga',
'LogoImage'						=> 'Obrázek loga',
'InstallConfigValues'			=> 'Přidávání konfiguračních hodnot',
'ConfigValues'					=> 'Konfigurační hodnoty',
'ErrorInsertPage'				=> 'Chyba při vkládání stránky %1',
'ErrorInsertPagePermission'		=> 'Chyba při nastavení oprávnění pro stránku %1',
'ErrorInsertDefaultMenuItem'	=> 'Chyba nastavení stránky %1 jako výchozí položka nabídky',
'ErrorPageAlreadyExists'		=> 'Stránka %1 již existuje',
'ErrorAlterTable'				=> 'Chyba při změně tabulky %1',
'ErrorInsertRecord'				=> 'Chyba při vkládání záznamu do tabulky %1',
'ErrorRenameTable'				=> 'Chyba při přejmenování tabulky %1',
'ErrorUpdatingTable'			=> 'Chyba při aktualizaci tabulky %1',
'CreatingTable'					=> 'Vytváření tabulky %1',
'CreatingIndex'					=> 'Vytváření %1 indexu',
'CreatingTrigger'				=> 'Vytváření spouštěče %1',
'ErrorAlreadyExists'			=> '%1 již existuje',
'ErrorCreatingTable'			=> 'Chyba při vytváření tabulky %1 , již existuje?',
'ErrorCreatingIndex'			=> 'Chyba při vytváření indexu %1 , již existuje?',
'ErrorCreatingTrigger'			=> 'Chyba při vytváření %1 spouštěče, již existuje?',
'DeletingTables'				=> 'Mazání tabulek',
'DeletingTablesEnd'				=> 'Mazání tabulek dokončeno',
'ErrorDeletingTable'			=> 'Chyba při odstraňování tabulky %1 . Nejpravděpodobnějším důvodem je, že tabulka neexistuje, v tom případě můžete toto varování ignorovat.',
'DeletingTable'					=> 'Mazání tabulky %1',
'NextStep'						=> 'V dalším kroku se instalátor pokusí zapsat aktualizovaný konfigurační soubor %1. Ujistěte se, že webový server má přístup k souboru, nebo jej budete muset upravit ručně. Ještě jednou, podívejte se na  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',

/*
   Write Config Page
*/
'write-config'					=> 'Zapsat konfigurační soubor',
'FinalStep'						=> 'Konečný krok',
'Writing'						=> 'Zápis konfiguračního souboru',
'RemovingWritePrivilege'		=> 'Odstraňování práv zápisu',
'InstallationComplete'			=> 'Instalace dokončena',
'ThatsAll'						=> 'To je vše! Nyní můžete <a href="%1">zobrazit své WackoWiki stránky</a>.',
'SecurityConsiderations'		=> 'Bezpečnostní úvahy',
'SecurityRisk'					=> 'Doporučujeme odebrat přístup k zápisu do %1 nyní, když je zapsán. Opustit zapisovatelný soubor může představovat bezpečnostní riziko!<br>např. %2',
'RemoveSetupDirectory'			=> 'Nyní byste měli odstranit složku %1 po dokončení instalace.',
'ErrorGivePrivileges'			=> 'Konfigurační soubor %1 nelze zapsat. Musíte dát svému webovému serveru dočasný přístup k zápisu do adresáře WackoWiki, nebo prázdný soubor nazvaný %1<br>%2.<br><br> Nezapomeňte znovu odstranit přístup k zápisu později, tj. <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Pokud z nějakého důvodu to neuděláte, budete muset zkopírovat text níže do nového souboru a uložit / nahrát jej jako %1 do adresáře WackoWiki. Jakmile tak učiníte, vaše WackoWiki by měla fungovat. Pokud ne, navštivte prosím <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Jakmile tak učiníte, vaše WackoWiki by měla fungovat. Pokud ne, navštivte prosím <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'napsáno v ',
'DontChange'					=> 'ručně neměnit wacko_verzi!',
'ConfigDescription'				=> 'podrobný popis: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Zkuste to znovu',

];
