<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'fi',
'LangLocale'	=> 'fi_FI',
'LangName'		=> 'Finnish',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Kategoria',
	'groups_page'		=> 'Ryhmät',
	'users_page'		=> 'Käyttäjät',

	'search_page'		=> 'Etsi',
	'login_page'		=> 'Kirjaudu',
	'account_page'		=> 'Asetukset',
	'registration_page'	=> 'Rekisteröinti',
	'password_page'		=> 'Salasana',

	'changes_page'		=> 'Viimeisimmät Muutokset',
	'comments_page'		=> 'Äskettäin Kommentoitu',
	'index_page'		=> 'PageIndex',

	'random_page'		=> 'Satunnaissivu',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',

	// time
	#'date_format'					=> 'dd.MM.yyyy',
	#'time_format'					=> 'HH:mm',
	#'time_format_seconds'			=> 'HH:mm:ss',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki Asennus',
'TitleUpdate'					=> 'WackoWiki Päivitys',
'Continue'						=> 'Jatka',
'Back'							=> 'Takaisin',
'Recommended'					=> 'suositellaan',
'InvalidAction'					=> 'Virheellinen toiminto',

/*
   Language Selection Page
*/
'lang'							=> 'Kielen Asetukset',
'PleaseUpgradeToR6'				=> 'Näytät olevan käynnissä vanha (pre %2) julkaisu WackoWiki (%1). Päivittääksesi tähän WackoWikin versioon, sinun on ensin päivitettävä asennus %2 versioon.',
'UpgradeFromWacko'				=> 'Tervetuloa WackoWikiin! Näyttää siltä, että olet päivittämässä WackoWiki %1 %2. Seuraavat muutamat sivut opastavat sinua läpi päivitysprosessin.',
'FreshInstall'					=> 'Tervetuloa WackoWikiin! Olet asentamassa WackoWiki %1. Seuraavat sivut opastavat sinut asennusprosessin läpi.',
'PleaseBackup'					=> 'Ole hyvä ja <strong>varmuuskopioi</strong> tietokantasi, config tiedosto ja kaikki muutetut tiedostot, kuten ne, joilla on paikallisia hakata ja korjauksia sovelletaan niihin ennen päivitysprosessin aloittamista. Tämä voi pelastaa sinut iso päänsärky.',
'LangDesc'						=> 'Ole hyvä ja valitse asennusprosessin kieli. Tätä kieltä käytetään myös WackoWiki asennuksen oletuskielenä.',

/*
   System Requirements Page
*/
'version-check'					=> 'Järjestelmävaatimukset',
'PhpVersion'					=> 'Php Versio',
'PhpDetected'					=> 'Havaittu PHP',
'ModRewrite'					=> 'Apache Rewrite Lisäosa (Valinnainen)',
'ModRewriteInstalled'			=> 'Uudelleenkirjoitetaanko Lisäosa (mod_rewrite) asennettu?',
'Database'						=> 'Tietokanta',
'PhpExtensions'					=> 'Php Laajennukset',
'Permissions'					=> 'Käyttöoikeudet',
'ReadyToInstall'				=> 'Valmis asentamaan?',
'Requirements'					=> 'Palvelimesi on täytettävä alla luetellut vaatimukset.',
'OK'							=> 'Ok',
'Problem'						=> 'Ongelma',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'PHP asennus näyttää puuttuvan merkityt PHP laajennukset, jotka vaaditaan WackoWiki.',
'PcreWithoutUtf8'				=> 'PCRE ei ole käännetty UTF-8 tuella.',
'NotePermissions'				=> 'Tämä asentaja yrittää kirjoittaa asetustiedot tiedostoon %1, joka sijaitsee WackoWiki hakemistossa. Jotta tämä toimisi, sinun on varmistettava, että web-palvelimella on kirjoitusoikeudet kyseiseen tiedostoon. Jos et voi tehdä tätä, sinun täytyy muokata tiedostoa manuaalisesti (asennusohjelma kertoo sinulle).<br><br>Katso lisätietoja <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'ErrorPermissions'				=> 'Näyttää siltä, että asentaja ei voi automaattisesti asettaa vaadittuja tiedostoja WackoWiki toimimaan oikein. Sinulle kysytään myöhemmin asennusprosessissa, jotta voit määrittää manuaalisesti vaaditut tiedostooikeudet palvelimellasi.',
'ErrorMinPhpVersion'			=> 'PHP-version on oltava suurempi kuin <strong>' . PHP_MIN_VERSION . '</strong>. Palvelimesi näyttää olevan käynnissä aikaisemmassa versiossa. Sinun täytyy päivittää uusimpaan PHP-versioon, jotta WackoWiki toimisi oikein.',
'Ready'							=> 'Onnittelut, näyttää siltä, että palvelimesi pystyy suorittamaan WackoWikin. Seuraavat sivut vievät sinut konfiguraation läpi.',

/*
   Site Config Page
*/
'config-site'					=> 'Sivuston Asetukset',
'SiteName'						=> 'Wiki Nimi',
'SiteNameDesc'					=> 'Ole hyvä ja kirjoita Wiki-sivustosi nimi.',
'SiteNameDefault'				=> 'MyWikiSite',
'HomePage'						=> 'Kotisivu',
'HomePageDesc'					=> 'Anna nimi, jonka haluat olevan kotisivussasi. Tämä on oletussivun käyttäjät näkevät, kun he vierailevat sivustolla ja pitäisi olla <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Kotisivu',
'MultiLang'						=> 'Monen Kielen Tila',
'MultiLangDesc'					=> 'Monikielinen tila mahdollistaa että sinulla on sivuja, joissa on eri kieliasetukset yhdessä asennuksessa. Kun tämä tila on käytössä, asentaja luo ensimmäisiä valikon nimikkeitä kaikille kielille, jotka ovat saatavilla jakelussa.',
'AllowedLang'					=> 'Sallitut Kielet',
'AllowedLangDesc'				=> 'On suositeltavaa valita vain joukko kieliä, joita haluat käyttää, muuten kaikki kielet on valittu.',
'Admin'							=> 'Ylläpitäjän Nimi',
'AdminDesc'						=> 'Anna ylläpitäjän käyttäjänimi. Tämän pitäisi olla <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (esim. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Käyttäjänimen tulee olla %1 - %2 merkkiä pitkä ja käyttää vain alfanumeerisia merkkejä. Suurimmat kirjaimet ovat OK.',
'NameCamelCaseOnly'				=> 'Käyttäjätunnuksen on oltava välillä %1 ja %2 merkkiä pitkä ja WikiName muotoiltu.',
'Password'						=> 'Ylläpitäjän Salasana',
'PasswordDesc'					=> 'Choose a password for the admin with a minimum of %1 characters.',
'PasswordConfirm'				=> 'Salasana:',
'Mail'							=> 'Ylläpitäjän Sähköpostiosoite',
'MailDesc'						=> 'Syötä ylläpitäjän sähköpostiosoite.',
'Base'							=> 'Base URL',
'BaseDesc'						=> 'WackoWiki sivuston perusosoite. Sivun nimet liitetään siihen, joten jos käytät mod_rewrite osoitetta loppuu eteenpäin slash, i. .</p><ul><li><strong><code>https://example. om/</code></strong></li><li><strong><code>https://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Uudelleenkirjoitustila',
'RewriteDesc'					=> 'Uudelleenkirjoitustila tulisi ottaa käyttöön, jos käytät WackoWikiä URL-osoitteen uudelleenkirjoittamiseen.',
'Enabled'						=> 'Käytössä:',
'ErrorAdminEmail'				=> 'Olet syöttänyt virheellisen sähköpostiosoitteen!',
'ErrorAdminPasswordMismatch'	=> 'Salasanat eivät täsmää!.',
'ErrorAdminPasswordShort'		=> 'Pääkäyttäjän salasana on liian lyhyt! Vähimmäispituus on %1 merkkiä.',
'ModRewriteStatusUnknown'		=> 'Asennus ei voi varmistaa, että mod_rewrite on käytössä. Tämä ei kuitenkaan tarkoita, että se olisi pois päältä.',

/*
   Database Config Page
*/
'config-database'				=> 'Tietokannan Asetukset',
'DbDriver'						=> 'Kuljettaja',
'DbDriverDesc'					=> 'Tietokannan ajuri, jota haluat käyttää.',
'DbSqlMode'						=> 'SQL-tila',
'DbSqlModeDesc'					=> 'SQL-tila jota haluat käyttää.',
'DbVendor'						=> 'Valmistaja',
'DbVendorDesc'					=> 'Tietokannan myyjä käytät.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'Tietokannan merkistö, jota haluat käyttää.',
'DbEngine'						=> 'Moottori',
'DbEngineDesc'					=> 'Tietokannan moottori, jota haluat käyttää.',
'DbHost'						=> 'Isäntä',
'DbHostDesc'					=> 'Tietokantapalvelin on käynnissä, yleensä <code>127.0.0.1</code> tai <code>localhost</code> (toisin sanoen, sama kone WackoWiki sivusto on päällä).',
'DbPort'						=> 'Portti (valinnainen)',
'DbPortDesc'					=> 'Portti numero tietokantapalvelin on käytettävissä läpi. Jätä tyhjäksi käyttääksesi oletusportin numero.',
'DbName'						=> 'Tietokannan Nimi',
'DbNameDesc'					=> 'Tietokannan WackoWiki pitäisi käyttää. Tämä tietokanta on oltava olemassa jo ennen kuin jatkat sitä!',
'DbUser'						=> 'Käyttäjän Nimi',
'DbUserDesc'					=> 'Tietokantaan yhdistettävän käyttäjän nimi. @ info: whatsthis',
'DbPassword'					=> 'Salasana',
'DbPasswordDesc'				=> 'Käyttäjän salasana, jota käytetään yhdistämään tietokantaan.',
'Prefix'						=> 'Taulun Etuliite',
'PrefixDesc'					=> 'Etuliite kaikista WackoWikin käyttämistä taulukoista. Tämän avulla voit ajaa useita WackoWiki asennuksia käyttäen samaa tietokantaa määrittämällä ne käyttämään erilaisia taulukon etuliitteitä (esim. wacko_).',
'ErrorNoDbDriverDetected'		=> 'Tietokannan ajuria ei ole havaittu, ota käyttöön joko mysqli tai pdo_mysql laajennus php.ini tiedostossa.',
'ErrorNoDbDriverSelected'		=> 'Tietokantaohjainta ei ole valittu, ole hyvä ja valitse yksi listalta.',
'DeleteTables'					=> 'Poista Olemassa Olevat Taulukot?',
'DeleteTablesDesc'				=> 'HUOMIO! Jos jatkat tätä vaihtoehtoa, kaikki nykyiset wikitiedot poistetaan tietokannastasi. Tätä ei voi peruuttaa, ja sinun on palautettava tiedot manuaalisesti varmuuskopiosta.',
'ConfirmTableDeletion'			=> 'Oletko varma, että haluat poistaa kaikki nykyiset wiki-taulukot?',

/*
   Database Installation Page
*/
'install-database'				=> 'Tietokannan Asennus',
'TestingConfiguration'			=> 'Testataan Asetuksia',
'TestConnectionString'			=> 'Testataan tietokantayhteyden asetuksia',
'TestDatabaseExists'			=> 'Tarkistetaan, onko määrittämäsi tietokanta olemassa',
'TestDatabaseVersion'			=> 'Tarkistetaan tietokannan vähimmäisversiovaatimukset',
'InstallTables'					=> 'Asennetaan Tauluja',
'ErrorDbConnection'				=> 'Määrittämäsi tietokantayhteyden tiedot olivat ongelma, ole hyvä ja tarkista, että ne ovat oikeita.',
'ErrorDatabaseVersion'			=> 'Tietokannan versio on %1 mutta vaatii vähintään %2.',
'To'							=> 'päättyen',
'AlterTable'					=> 'Muutetaan %1 -taulua',
'InsertRecord'					=> 'Tietueen lisääminen %1 tauluun',
'RenameTable'					=> 'Uudelleennimetään %1 -taulu',
'UpdateTable'					=> 'Päivitetään %1 taulua',
'InstallDefaultData'			=> 'Lisätään Oletustietoja',
'InstallPagesBegin'				=> 'Lisätään Oletussivuja',
'InstallPagesEnd'				=> 'Oletussivujen Lisääminen Valmis',
'InstallSystemAccount'			=> 'Lisätään <code>Järjestelmä</code> Käyttäjä',
'InstallDeletedAccount'			=> 'Lisätään <code>Poistettu</code> Käyttäjä',
'InstallAdmin'					=> 'Lisätään Ylläpitäjän Käyttäjää',
'InstallAdminSetting'			=> 'Lisätään Ylläpitäjän Asetukset',
'InstallAdminGroup'				=> 'Lisätään Ylläpitäjäryhmä',
'InstallAdminGroupMember'		=> 'Admins Groupin Jäsen',
'InstallEverybodyGroup'			=> 'Lisätään Kaikki Ryhmät',
'InstallModeratorGroup'			=> 'Lisätään Moderaattoriryhmä',
'InstallReviewerGroup'			=> 'Lisätään Tarkastelijaryhmä',
'InstallLogoImage'				=> 'Lisätään Logo-kuva',
'LogoImage'						=> 'Logon kuva',
'InstallConfigValues'			=> 'Lisätään Asetusten Arvoja',
'ConfigValues'					=> 'Config Arvot',
'ErrorInsertPage'				=> 'Virhe lisättäessä %1 -sivua',
'ErrorInsertPagePermission'		=> 'Virhe asetettaessa lupaa %1 sivulle',
'ErrorInsertDefaultMenuItem'	=> 'Virhe asettaessa sivun %1 oletusvalikkonimikkeeksi',
'ErrorPageAlreadyExists'		=> '%1 sivu on jo olemassa',
'ErrorAlterTable'				=> 'Virhe muokattaessa %1 -taulua',
'ErrorInsertRecord'				=> 'Virhe tietueen lisäämisessä %1 tauluun',
'ErrorRenameTable'				=> 'Virhe uudelleennimeäessä %1 taulua',
'ErrorUpdatingTable'			=> 'Virhe päivitettäessä %1 taulua',
'CreatingTable'					=> 'Luodaan %1 -taulua',
'ErrorAlreadyExists'			=> '%1 on jo olemassa',
'ErrorCreatingTable'			=> 'Virhe luotaessa %1 -taulukkoa, onko se jo olemassa?',
'DeletingTables'				=> 'Poistetaan Tauluja',
'DeletingTablesEnd'				=> 'Poistaminen Valmis',
'ErrorDeletingTable'			=> 'Virhe poistettaessa %1 -taulukkoa. Todennäköisin syy on, että taulukkoa ei ole olemassa, jolloin voit ohittaa tämän varoituksen.',
'DeletingTable'					=> 'Poistetaan %1 -taulua',
'NextStep'						=> 'In the next step, the installer will try to write the updated configuration file, %1.  Please make sure the web server has write access to the file, or you will have to edit it manually.  Once again, see  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',

/*
   Write Config Page
*/
'write-config'					=> 'Kirjoita Konfiguraatiotiedosto',
'FinalStep'						=> 'Viimeinen Vaihe',
'Writing'						=> 'Kirjoitetaan Asetustiedostoa',
'RemovingWritePrivilege'		=> 'Poistetaan Kirjoitusoikeuksia',
'InstallationComplete'			=> 'Asennus Valmis',
'ThatsAll'						=> 'That\'s all! You can now <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations'		=> 'Turvallisuutta Koskevat Huomiot',
'SecurityRisk'					=> 'Sinua kehotetaan poistamaan kirjoitusoikeudet %1 nyt kun se on kirjoitettu. Tiedoston jättäminen kirjoitettavaksi voi olla turvallisuusriski!<br>eli %2',
'RemoveSetupDirectory'			=> 'Sinun pitäisi poistaa %1 -hakemisto nyt, kun asennusprosessi on valmis.',
'ErrorGivePrivileges'			=> 'Konfiguraatiotiedostoa %1 ei voitu kirjoittaa. Sinun tulee antaa web-palvelimelle väliaikainen kirjoitusoikeus joko WackoWiki hakemistoon, tai tyhjä tiedosto nimeltä %1<br>%2.<br><br> Älä unohda poistaa kirjoitusoikeuksia uudelleen myöhemmin, ts. <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Jos jostain syystä et voi tehdä tätä, Sinun täytyy kopioida alla oleva teksti uuteen tiedostoon ja tallentaa tai ladata se nimellä %1 WackoWiki hakemistoon. Kun olet tehnyt tämän, WackoWiki sivuston pitäisi toimia. Jos ei, käy <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Kun olet tehnyt tämän, WackoWiki sivuston pitäisi toimia. Jos ei, käy <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'kirjoitettu klo ',
'DontChange'					=> 'älä muuta wacko_versiota manuaalisesti!',
'ConfigDescription'				=> 'yksityiskohtainen kuvaus: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Yritä Uudelleen',

];
