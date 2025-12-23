<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'et',
'LangLocale'	=> 'et_EE',
'LangName'		=> 'Estonian',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'Kategooria',
	'groups_page'		=> 'Grupid',
	'users_page'		=> 'Kasutajad',
	'tools_page'		=> 'Tööriistad',

	'search_page'		=> 'Otsing',
	'login_page'		=> 'Sisene',
	'account_page'		=> 'Seaded',
	'registration_page'	=> 'Registreerimine',
	'password_page'		=> 'Parool',

	'whatsnew_page'		=> 'WhatsNew',
	'changes_page'		=> 'ViimasedMuudatused',
	'comments_page'		=> 'ViimatiKommenteeritud',
	'index_page'		=> 'SisuKord',

	'random_page'		=> 'JuhuslikLehekülg',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki installeerimine',
'TitleUpdate'					=> 'WackoWiki Update',
'Continue'						=> 'Jätka',
'Back'							=> 'Tagasi',
'Recommended'					=> 'soovitatav',
'InvalidAction'					=> 'Kehtetu tegevus',

/*
   Locking Check
 */
'LockAuthorization'				=> 'Authorization',
'LockAuthorizationInfo'			=> 'Palun sisestage parool, mille salvestasite faili %1.',
'LockPassword'					=> 'Parool:',
'LockLogin'						=> 'Sisene',
'LockPasswordInvalid'			=> 'Kehtetu parool.',
'LockedTryLater'				=> 'Seda veebisaiti uuendatakse praegu. Palun proovige hiljem uuesti.',
'EmptyAuthFile'					=> 'Fail %1 puudub või on tühi. Palun looge fail ja määrake sellele parool.',


/*
   Language Selection Page
*/
'lang'							=> 'Keele konfigureerimine',
'PleaseUpgradeToR6'				=> 'Tundub, et kasutate WackoWiki %1 vana versiooni. Et uuendada WackoWiki selle versiooniga, peate kõigepealt uuendama oma paigalduse versioonile %2.',
'UpgradeFromWacko'				=> 'Tere tulemast WackoWikisse! Tundub, et te uuendate WackoWiki %1-st %2-le.  Järgmised leheküljed juhatavad teid läbi uuendamise protsessi.',
'FreshInstall'					=> 'Tere tulemast WackoWiki-le, et kavatsete installida WackoWiki %1. Järgmised mõned lehed suunavad teid installiprotsessi.',
'PleaseBackup'					=> 'Enne, kui alustad versioonitäienduse sisseviimist, tee tagavarakoopia oma andmebaasist, konfiguratsioonidefailist ja kõikidest muudetud failidest. See võib sind säästa suurest peavalust!',
'LangDesc'						=> 'Vali keel, mida installeerimise ajal kasutada. Seesama keel saab olema ka vaikimisi keeleks sinu WackoWiki installatsioonil.',

/*
   System Requirements Page
*/
'version-check'					=> 'Nõuded süsteemile',
'PhpVersion'					=> 'PHP versioon',
'PhpDetected'					=> 'Detected PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'Andmebaas',
'PhpExtensions'					=> 'PHP laiendid',
'Permissions'					=> 'Õigused',
'ReadyToInstall'				=> 'Valmis installida?',
'Requirements'					=> 'Teie server peab vastama allpool loetletud nõuetele.',
'OK'							=> 'OK',
'Problem'						=> 'Probleem',
'Example'						=> 'Example',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Teie PHP installil puuduvad märgitud PHP laiendused, mida WackoWiki nõuab. ',
'PcreWithoutUtf8'				=> 'PCRE ei ole kompileeritud UTF-8 toega.',
'NotePermissions'				=> 'Üritatakse konfiguratsiooni andmeid kirjutada faili nimega %1, mis asub sinu  WackoWiki kataloogis. Et see töötaks, pead sa olema kindel, et veebi serveril on kirjutamisõigused sellesse faili! Kui kirjutamisoigust ei ole, pead sa käsitsi seda faili muutma (installeerimise käigus üteldakse kuidas see käib).<br><br>Vaata seda, et saada täpsemaid juhiseid: <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'ErrorPermissions'				=> 'Tundub, et paigaldaja ei saa automaatselt määrata vajalikke failiõigusi, et WackoWiki õigesti töötaks. Hiljem paigaldusprotsessi käigus palutakse teil käsitsi seadistada nõutavad failiõigused oma serveris.',
'ErrorMinPhpVersion'			=> 'PHP versioon peab olema suurem kui %1, teie serveril näib olevat kasutusel varasem versioon. WackoWiki korrektseks toimimiseks peate uuema PHP-versiooni peale uuendama.',
'Ready'							=> 'Palju õnne, tundub, et teie server on võimeline WackoWiki\'t käivitama. Järgmised leheküljed viivad teid läbi konfigureerimisprotsessi.',

/*
   Site Config Page
*/
'config-site'					=> 'Site konfiguratsioon',
'SiteName'						=> 'Sinu WikiNimi',
'SiteNameDesc'					=> 'Sinu WikiNimi.',
'SiteNameDefault'				=> 'MinuWiki',
'HomePage'						=> 'Koduleht',
'HomePageDesc'					=> 'Sinu WackoWiki kodulehe nimi. Peaks ka olema <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiNimi</a>.',
'HomePageDefault'				=> 'Koduleht',
'MultiLang'						=> 'Mitmekeelne režiim',
'MultiLangDesc'					=> 'Mitmekeelne režiim võimaldab ühe installatsiooni sees kasutada erinevatel lehtedele erinevaid keelte määranguid. Kui see režiim on lubatud, siis installeerimise käigus tekitatakse kõigi võimalike keelte jaoks, mis paketiga kaasas on, ühesugused menüü üksused erinevates keeltes.',
'AllowedLang'					=> 'Lubatud keeled',
'AllowedLangDesc'				=> 'Soovitatav on valida ainult need keeled, mida soovite kasutada, vastasel juhul on valitud kõik keeled.',
'AclMode'						=> 'ACL-i vaikesätted',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Avalik Wiki (lugege kõigile, kirjutage ja kommenteerige registreerunud kasutajatele)',
'PrivateWiki'					=> 'Privaatne Wiki (lugege, kirjutage, kommenteerivad ainult registreeritud kasutajad)',
'Admin'							=> 'Adminni nimi',
'AdminDesc'						=> 'Sisesta administraatori kasutajanimi. Peaks olema <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiNimi</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Kasutajanimi peab olema vahemikus %1 ja %2 sümbolit pikk. Võid kasutada vaid kirjamärke.',
'NameCamelCaseOnly'				=> 'Kasutajanimi peab olema vahemikus %1 ja %2 sümbolit pikk. and WikiName formatted.',
'Password'						=> 'Sisesta parool',
'PasswordDesc'					=> 'Vali administraatorile parool (vähemalt %1 tähemärki)',
'PasswordConfirm'				=> 'Korda parooli:',
'Mail'							=> 'Administraatori e-post',
'MailDesc'						=> 'Sisestage administraatori e-posti aadress.',
'Base'							=> 'Baas-URL',
'BaseDesc'						=> 'Teie WackoWiki saidi baas-URL.  Sellele lisatakse lehekülje nimed, nii et kui kasutate mod_rewrite\'i, peaks aadress lõppema kaldkriipsuga, st.',
'Rewrite'						=> 'Ülekirjutamise olek',
'RewriteDesc'					=> 'Ümberkirjutamise olek peab olema lubatud, kui sa kasutad WackoWiki\'t URL\'i ülekirjutamisega.',
'Enabled'						=> 'Lubama:',
'ErrorAdminEmail'				=> 'Pead sisestama korrektse adminni e-posti aadressi!',
'ErrorAdminPasswordMismatch'	=> 'Parool ei kõlba. Sisesta see uuesti!',
'ErrorAdminPasswordShort'		=> 'The admin Parool on liiga lühike, sisesta uuesti, the minimum length is %1 characters!',
'ModRewriteStatusUnknown'		=> 'Paigaldaja ei saa kontrollida, et mod_rewrite on lubatud. See ei tähenda siiski, et see on välja lülitatud.',

/*
   Database Config Page
*/
'config-database'				=> 'Andmebaasi konfigureerimine',
'DbDriver'						=> 'Driver',
'DbDriverDesc'					=> 'The database driver you want to use.',
'DbSqlMode'						=> 'SQL mode',
'DbSqlModeDesc'					=> 'The SQL mode you want use.',
'DbVendor'						=> 'Vendor',
'DbVendorDesc'					=> 'The database vendor you use.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'The database charset you want to use.',
'DbEngine'						=> 'Engine',
'DbEngineDesc'					=> 'The database engine you want to use.',
'DbHost'						=> 'Host',
'DbHostDesc'					=> 'Host, millel teie andmebaasiserver töötab, tavaliselt <code>127.0.0.1</code> või <code>localhost</code> (st sama masin, millel on teie WackoWiki sait).',
'DbPort'						=> 'Port (Optional)',
'DbPortDesc'					=> 'Pordi number, mille kaudu teie andmebaasiserver on kättesaadav. Jäta see tühjaks, et kasutada vaikimisi pordinumbrit.',
'DbName'						=> 'Andmebassi nimi',
'DbNameDesc'					=> 'Andmebaas, mida WackoWiki peaks kasutama. See andmebaas peab olema juba olemas, enne kui jätkate!',
'DbNameSqliteDesc'				=> 'Andmekataloog ja failinimi, mida SQLite peaks WackoWiki jaoks kasutama.',
'DbNameSqliteHelp'				=> 'SQLite salvestab kõik andmed ühte faili.<br><br>Teie määratud kataloog peab olema installimise ajal veebiserverile kirjutamiseks avatud.<br><br>See ei tohi olla veebi kaudu kättesaadav. <br><br>Paigaldaja kirjutab koos sellega faili <code>.htaccess</code>, kuid kui see ebaõnnestub, võib keegi saada juurdepääsu teie töötlemata andmebaasile.<br>See hõlmab nii töötlemata kasutajaandmeid (e-posti aadresse, räsitud paroole) kui ka kaitstud lehti ja muid piiratud andmeid wikis.<br><br>Kaaluge andmebaasi paigutamist hoopis mujale, näiteks kataloogi <code>/var/lib/wackowiki/yourwiki</code>.',
'DbUser'						=> 'Kasutajanimi',
'DbUserDesc'					=> 'Andmebaasiga ühendamiseks kasutatava kasutaja nimi.',
'DbPassword'					=> 'Parool',
'DbPasswordDesc'				=> 'Kasutaja parool, mida kasutatakse teie andmebaasiga ühenduse loomiseks.',
'Prefix'						=> 'Tabeli prefiks',
'PrefixDesc'					=> 'Kõikide tabelite eesliides, mida WackoWiki kasutab. See voimaldab käitada mitut WackoWikit korraga,  kasutades ära ühte ja sama  MySQL andmebaasi, konfigureerides neid kasutama erinevaid tabelite prefikseid (e.g. wacko_).',
'ErrorNoDbDriverDetected'		=> 'Andmebaasi draiverit ei ole tuvastatud, palun aktiveerige php.ini failis kas mysqli või pdo_mysql laiendus.',
'ErrorNoDbDriverSelected'		=> 'Andmebaasi draiverit ei ole valitud, palun valige üks loendist.',
'DeleteTables'					=> 'Olemasolevate tabelite kustutamine?',
'DeleteTablesDesc'				=> 'TÄHELEPANU! Kui te jätkate selle valikuga, kustutatakse kõik praegused wiki andmed teie andmebaasist. Seda ei saa tühistada, kui te ei taastata andmeid käsitsi varukoopiast.',
'ConfirmTableDeletion'			=> 'Kas olete kindel, et soovite kustutada kõik praegused wiki tabelid?',

/*
   Database Installation Page
*/
'install-database'				=> 'Andmebaasi paigaldamine',
'TestingConfiguration'			=> 'Testin konfiguratsiooni',
'TestConnectionString'			=> 'Testin database ühenduse seadistusi',
'TestDatabaseExists'			=> 'Checking if the database you specified exists',
'TestDatabaseVersion'			=> 'Checking database minimum version requirements',
'SqliteFileExtensionError'		=> 'Palun kasutage ühte järgmistest faililaienditest: db, sdb, sqlite.',
'SqliteParentUnwritableGroup'	=> 'Cannot create the data directory <code>%1</code>, because the parent directory <code>%2</code> is not writable by the webserver.<br><br>The installer has determined the user your webserver is running as.<br>Make the <code>%3</code> directory writable by it to continue.<br>On a Unix/Linux system do:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> 'Cannot create the data directory <code>%1</code>, because the parent directory <code>%2</code> is not writable by the webserver.<br><br>The installer could not determine the user your webserver is running as.<br>Make the <code>%3</code> directory globally writable by it (and others!) to continue.<br>On a Unix/Linux system do:<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> 'Andmekataloogi <code>%1</code> loomisel tekkis viga. Kontrollige asukohta ja proovige uuesti.',
'SqliteDirUnwritable'			=> 'Ei ole võimalik kirjutada kataloogi <code>%1</code>.<br>Muuda selle õigusi nii, et veebiserver saaks sinna kirjutada, ja proovi uuesti.',
'SqliteReadonly'				=> 'Faili <code>%1</code> ei saa kirjutada.',
'SqliteCantCreateDb'			=> 'Andmebaasi faili <code>%1</code> ei õnnestunud luua.',
'InstallTables'					=> 'Tabelite installimine',
'ErrorDbConnection'				=> 'Teie poolt määratud andmebaasiühenduse andmetega oli probleem, palun minge tagasi ja kontrollige, kas need on õiged.',
'ErrorDatabaseVersion'			=> 'Andmebaasi versioon on %1, kuid nõuab vähemalt %2.',
'To'							=> '->',
'AlterTable'					=> 'Altering %1 table',
'InsertRecord'					=> 'Inserting Record into %1 table',
'RenameTable'					=> 'Renaming %1 table',
'UpdateTable'					=> 'Updating %1 table',
'InstallDefaultData'			=> 'Adding Default Data',
'InstallPagesBegin'				=> 'Adding Default Pages',
'InstallPagesEnd'				=> 'Finished Adding Default Pages',
'InstallSystemAccount'			=> 'Lisan <code>System</code> kontot',
'InstallDeletedAccount'			=> 'Lisan <code>Deleted</code> kontot',
'InstallAdmin'					=> 'Lisan adminni kontot',
'InstallAdminSetting'			=> 'Lisan adminni kontot',
'InstallAdminGroup'				=> 'Adding Admins Group',
'InstallAdminGroupMember'		=> 'Adding Admins Group Member',
'InstallEverybodyGroup'			=> 'Adding Everybody Group',
'InstallModeratorGroup'			=> 'Adding Moderator Group',
'InstallReviewerGroup'			=> 'Adding Reviewer Group',
'InstallLogoImage'				=> 'Adding Logo Image',
'LogoImage'						=> 'Logo image',
'InstallConfigValues'			=> 'Adding Config Values',
'ConfigValues'					=> 'Config Values',
'ErrorInsertPage'				=> 'Error inserting %1 page',
'ErrorInsertPagePermission'		=> 'Error setting permission for %1 page',
'ErrorInsertDefaultMenuItem'	=> 'Error setting page %1 as default menu item',
'ErrorPageAlreadyExists'		=> 'The %1 page already exists',
'ErrorAlterTable'				=> 'Error altering %1 table',
'ErrorInsertRecord'				=> 'Error Inserting Record into %1 table',
'ErrorRenameTable'				=> 'Error renaming %1 table',
'ErrorUpdatingTable'			=> 'Error updating %1 table',
'CreatingTable'					=> 'Loon %1 tabelit',
'CreatingIndex'					=> 'Creating %1 index',
'CreatingTrigger'				=> 'Creating %1 trigger',
'ErrorAlreadyExists'			=> 'The %1 already exists',
'ErrorCreatingTable'			=> 'Viga tabeli %1 loomisel, kas see on juba olemas?',
'ErrorCreatingIndex'			=> 'Error creating %1 index, does it already exist?',
'ErrorCreatingTrigger'			=> 'Error creating %1 trigger, does it already exist?',
'DeletingTables'				=> 'Tabelite kustutamine',
'DeletingTablesEnd'				=> 'Finished Deleting Tables',
'ErrorDeletingTable'			=> 'Viga tabeli %1 kustutamisel. Kõige tõenäolisem põhjus on, et tabelit ei ole olemas, sellisel juhul võite seda hoiatust ignoreerida.',
'DeletingTable'					=> 'Deleting %1 table',
'NextStep'						=> 'Järgmisena üritatakse kirjutada täiendatud konfiguratsioonifaili, %1. Palun veendu, et veebi serveril oleks faili kirjutamise õigused, vastasel korral pead sa seda käsitsi tegema. Uuesti, vaata täpsema info saamiseks siia: <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Dokumentatsioon/Installeerimine</a>.',

/*
   Write Config Page
*/
'write-config'					=> 'Konfigurifaili kirjutamine',
'FinalStep'						=> 'Viimane samm',
'Writing'						=> 'Kirjutan konfiguratsioonifaili',
'RemovingWritePrivilege'		=> 'Removing Write Privilege',
'InstallationComplete'			=> 'Paigaldamine on lõppenud',
'ThatsAll'						=> 'See on kõik! Nüüd saate <a href="%1">vaadata oma WackoWiki saiti</a>.',
'SecurityConsiderations'		=> 'Turvalisuse kaalutlused',
'SecurityRisk'					=> 'Soovitan sul eemaldada kirjutamisõigus %1 failile. Kirjutamisõiguse allesjätmine on riskantne turvalisuse seisukohast!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'Nüüd, kui paigaldusprotsess on lõpetatud, peaksite kataloogi %1 kustutama.',
'ErrorGivePrivileges'			=> 'Konfiguratsiooni faili %1 ei ole võimalik kirjutada. Sa pead andma oma veebi serverile ajutiselt kirjutamisõiguse kas oma WackoWiki kataloogile, või siis tühjale failile nimega %1<br>%2<br><br> ara unusta hiljem kirjutamisõigust eemaldada, näiteks nii: <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Kuid kui sa mingil põhjusel ei saa seda teha, siis pead sa allpool oleva teksti kopeerima uude faili ja siis salvestama ning uploadima selle nimega %1 WackoWiki kataloogi. Kui sa oled selle ära teinud, siis peaks su WackoWiki leht töötama. Kui ei tööta, siis mine aadressile <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Kui sa oled selle ära teinud, siis peaks su WackoWiki leht töötama. Kui ei tööta, siis mine aadressile <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'WrittenAt'						=> 'kirjutan ',
'DontChange'					=> 'ära muuda käsitsi wacko_version versiooni!',
'ConfigDescription'				=> 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Proovi uuesti',

];
