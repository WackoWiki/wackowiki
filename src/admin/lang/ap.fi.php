<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Perustoiminnot',
		'preferences'	=> 'Asetukset',
		'content'		=> 'Sisältö',
		'users'			=> 'Käyttäjät',
		'maintenance'	=> 'Huolto',
		'messages'		=> 'Viestit',
		'extension'		=> 'Laajennus',
		'database'		=> 'Tietokanta',
	],

	// Admin panel
	'AdminPanel'				=> 'Hallinnon Ohjauspaneeli',
	'RecoveryMode'				=> 'Palautustila',
	'Authorization'				=> 'Valtuutus',
	'AuthorizationTip'			=> 'Anna hallinnollinen salasana (varmista, että evästeet ovat sallittuja selaimessasi).',
	'NoRecoveryPassword'		=> 'Hallinnollista salasanaa ei ole määritelty!',
	'NoRecoveryPasswordTip'		=> 'Huomautus: Hallinnollisen salasanan puuttuminen on uhka turvallisuudelle! Syötä salasanasi hash asetustiedostoon ja suorita ohjelma uudelleen.',

	'ErrorLoadingModule'		=> 'Virhe ladattaessa hallintamoduulia %1: ei ole olemassa.',

	'ApHomePage'				=> 'Kotisivu',
	'ApHomePageTip'				=> 'Lopeta järjestelmän hallinto ja avaa kotisivu',
	'ApLogOut'					=> 'Kirjaudu ulos',
	'ApLogOutTip'				=> 'Lopeta järjestelmän käyttö ja kirjaudu ulos sivustosta',

	'TimeLeft'					=> 'Aikaa jäljellä:  %1 minuutti(a)',
	'ApVersion'					=> 'versio',

	'SiteOpen'					=> 'Avaa',
	'SiteOpened'				=> 'sivusto avattu',
	'SiteOpenedTip'				=> 'Sivusto on auki',
	'SiteClose'					=> 'Sulje',
	'SiteClosed'				=> 'sivusto suljettu',
	'SiteClosedTip'				=> 'Sivusto on suljettu',

	'System'					=> 'Järjestelmä',

	// Generic
	'Cancel'					=> 'Peruuta',
	'Add'						=> 'Lisää',
	'Edit'						=> 'Muokkaa',
	'Remove'					=> 'Poista',
	'Enabled'					=> 'Käytössä',
	'Disabled'					=> 'Pois Käytöstä',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'Ylläpitäjä',
	'Min'						=> 'Minimi',
	'Max'						=> 'Maksimi',

	'MiscellaneousSection'		=> 'Sekalaiset',
	'MainSection'				=> 'Yleiset Asetukset',

	'DirNotWritable'			=> '%1 -hakemisto ei ole kirjoitettavissa.',
	'FileNotWritable'			=> '%1 -tiedosto ei ole kirjoitettavissa.',

	/**
	 * AP MENU
	 *
	 *	'module_name'		=> [
	 *		'name'		=> 'Module name',
	 *		'title'		=> 'Module title',
	 *	],
	 */

	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Perus',
		'title'		=> 'Perusasetukset',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Ulkoasu',
		'title'		=> 'Ulkoasun asetukset',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Sähköposti',
		'title'		=> 'Sähköpostin asetukset',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Syndikointi',
		'title'		=> 'Syndikoinnin asetukset',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Suodatin',
		'title'		=> 'Suodattimen asetukset',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> 'Alustuksen asetukset',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Ilmoitukset',
		'title'		=> 'Ilmoitusten asetukset',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Sivut',
		'title'		=> 'Sivut ja sivuston parametrit',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Käyttöoikeudet',
		'title'		=> 'Käyttöoikeuksien asetukset',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Turvallisuus',
		'title'		=> 'Turvallisuusosajärjestelmien asetukset',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Järjestelmä',
		'title'		=> 'Järjestelmän asetukset',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Lähetä',
		'title'		=> 'Liitteen asetukset',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Poistettu',
		'title'		=> 'Äskettäin poistettu sisältö',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Valikko',
		'title'		=> 'Lisää, muokkaa tai poista oletusvalikon nimikkeitä',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Varmuuskopio',
		'title'		=> 'Tietojen varmuuskopiointi',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Korjaa',
		'title'		=> 'Korjaa ja optimoi tietokanta',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Palauta',
		'title'		=> 'Palautetaan varmuuskopion tiedot',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Päävalikko',
		'title'		=> 'WackoWiki Ylläpito',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Epäjohdonmukaisuudet',
		'title'		=> 'Tietojen Korjaaminen Epäjohdonmukaisuudet',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Tietojen Synkronointi',
		'title'		=> 'Synkronoidaan tietoja',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Massasähköposti',
		'title'		=> 'Massasähköposti',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Järjestelmän viesti',
		'title'		=> 'Järjestelmän viestit',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Järjestelmän Tiedot',
		'title'		=> 'Järjestelmän Tiedot',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Järjestelmän Loki',
		'title'		=> 'Järjestelmän tapahtumien loki',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Tilastot',
		'title'		=> 'Näytä tilastot',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Huono Käyttäytyminen',
		'title'		=> 'Huono Käyttäytyminen',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Hyväksy',
		'title'		=> 'Käyttäjän rekisteröinnin hyväksyminen',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Ryhmät',
		'title'		=> 'Ryhmien johto',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Käyttäjät',
		'title'		=> 'Käyttäjien hallinta',
	],

	// Main module
	'MainNote'					=> 'Huomautus: On suositeltavaa, että pääsy sivustolle estetään väliaikaisesti hallinnollista ylläpitoa varten.',

	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'Tyhjennä kaikki istunnot',
	'PurgeSessionsConfirm'		=> 'Oletko varma, että haluat puhdistaa kaikki istunnot? Tämä kirjautuu ulos kaikilta käyttäjiltä.',
	'PurgeSessionsExplain'		=> 'Tyhjennä kaikki istunnot. Tämä kirjautuu ulos kaikista käyttäjistä katkaisemalla auth_token taulukko.',
	'PurgeSessionsDone'			=> 'Istunnot tyhjennettiin onnistuneesti.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Perusasetukset päivitetty',
	'LogBasicSettingsUpdated'	=> 'Perusasetukset päivitetty',

	'SiteName'					=> 'Sivuston nimi:',
	'SiteNameInfo'				=> 'Sivuston otsikko näkyy selaimen otsikossa, teeman otsikossa, sähköposti-ilmoituksessa jne.',
	'SiteDesc'					=> 'Sivuston kuvaus:',
	'SiteDescInfo'				=> 'Täydennys otsikko sivuston, joka näkyy sivuilla otsikko. Selittää, muutamalla sanalla, mitä tämä sivusto on noin.',
	'AdminName'					=> 'Sivuston ylläpitäjä:',
	'AdminNameInfo'				=> 'Käyttäjän nimi, joka on vastuussa sivuston yleisestä tuesta. Tätä nimeä ei käytetä käyttöoikeuksien määrittämiseen, mutta on toivottavaa, että se on sivuston päävalvojan nimen mukainen.',

	'LanguageSection'			=> 'Kieli',
	'DefaultLanguage'			=> 'Oletus kieli:',
	'DefaultLanguageInfo'		=> 'Määrittää rekisteröitymättömille vieraille näytettävien viestien kielen, samoin kuin lokaalien asetukset.',
	'MultiLanguage'				=> 'Monikielinen tuki:',
	'MultiLanguageInfo'			=> 'Ota käyttöön mahdollisuus valita kieli sivun mukaan.',
	'AllowedLanguages'			=> 'Sallitut kielet:',
	'AllowedLanguagesInfo'		=> 'On suositeltavaa valita vain joukko kieliä, joita haluat käyttää, muuten kaikki kielet on valittu.',

	'CommentSection'			=> 'Kommentit',
	'AllowComments'				=> 'Salli kommentit:',
	'AllowCommentsInfo'			=> 'Ota kommentit käyttöön vain vieraille tai rekisteröityneille käyttäjille tai poista ne käytöstä koko sivustolla.',
	'SortingComments'			=> 'Lajittelu kommentit:',
	'SortingCommentsInfo'		=> 'Muutokset tilauksen sivun kommentit on esitelty, joko uusimman TAI vanhin kommentti yläreunassa.',
	'CommentsOffset'			=> 'Kommenttien sivu:',
	'CommentsOffsetInfo'		=> 'Oletusarvoisesti näytettävä kommenttisivu',

	'ToolbarSection'			=> 'Työkalupalkki',
	'CommentsPanel'				=> 'Kommenttipaneeli:',
	'CommentsPanelInfo'			=> 'Tämän sivun alareunassa olevien kommenttien oletuksena näkyvä näyttö.',
	'FilePanel'					=> 'Tiedostopaneeli:',
	'FilePanelInfo'				=> 'Tämän sivun alareunassa olevien liitetiedostojen oletusnäyttö',
	'TagsPanel'					=> 'Tunnisteet paneeli:',
	'TagsPanelInfo'				=> 'Tämän sivun alareunassa oleva tagipaneelin oletuksena oleva näyttö. @ action: button',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Näytä permalink:',
	'ShowPermalinkInfo'			=> 'The default display of the permalink for the current version of the page. (Automatic Copy)',
	'TocPanel'					=> 'Paneelin sisältötaulukko:',
	'TocPanelInfo'				=> 'Sivuston sisältöpaneelin oletusnäyttötaulukko (saattaa olla tarpeen tukea sivupohjat).',
	'SectionsPanel'				=> 'Osioiden paneeli:',
	'SectionsPanelInfo'			=> 'Näytä oletusarvoisesti vierekkäisten sivujen paneeli (vaatii tuen malleissa).',
	'DisplayingSections'		=> 'Näytetään osiot:',
	'DisplayingSectionsInfo'	=> 'Kun aiemmat asetukset on asetettu, näyttääkö vain sivun alasivut (<em>alempi</em>), vain naapuri (<em>top</em>), molemmat tai muut (<em>puu</em>).',
	'MenuItems'					=> 'Valikon nimikkeet:',
	'MenuItemsInfo'				=> 'Oletusmäärä näytettyjä valikkonimikkeitä (saattaa tarvita tukea malleissa).',

	'HandlerSection'			=> 'Handlers',
	'HideRevisions'				=> 'Piilota versiot:',
	'HideRevisionsInfo'			=> 'Oletus näyttö versioiden sivu. @ info: whatsthis',
	'AttachmentHandler'			=> 'Ota liitteiden käsittelijä käyttöön:',
	'AttachmentHandlerInfo'		=> 'Sallii liitetiedostojen käsittelijän näyttämisen.',
	'SourceHandler'				=> 'Salli lähdekoodin käsittely:',
	'SourceHandlerInfo'			=> 'Mahdollistaa lähteen käsittelijän näyttämisen.',
	'ExportHandler'				=> 'Ota XML-viennin käsittelijä käyttöön:',
	'ExportHandlerInfo'			=> 'Sallii XML-viennin käsittelijän näytön.',

	'DiffModeSection'			=> 'Diff- Tilat',
	'DefaultDiffModeSetting'	=> 'Oletus diff tila:',
	'DefaultDiffModeSettingInfo'=> 'Esivalittu diff- tila.',
	'AllowedDiffMode'			=> 'Sallitut diff-tilat:',
	'AllowedDiffModeInfo'		=> 'On suositeltavaa valita vain joukko diff- tilat, joita haluat käyttää, muuten kaikki diff- tilat on valittu.',
	'NotifyDiffMode'			=> 'Ilmoita diff-tila:',
	'NotifyDiffModeInfo'		=> 'Diff -tila, jota käytetään sähköpostin ruudussa oleviin ilmoituksiin.',

	'EditingSection'			=> 'Muokataan',
	'EditSummary'				=> 'Muokkaa yhteenvetoa:',
	'EditSummaryInfo'			=> 'Näyttää muutoksen yhteenvedon muokkaustilassa.',
	'MinorEdit'					=> 'Vähäinen muokkaus:',
	'MinorEditInfo'				=> 'Ottaa käyttöön pienen muokkausvaihtoehdon muokkaustilassa.',
	'SectionEdit'				=> 'Osion muokkaus:',
	'SectionEditInfo'			=> 'Ottaa käyttöön vain sivun osan muokkaamisen.',
	'ReviewSettings'			=> 'Arvostelu:',
	'ReviewSettingsInfo'		=> 'Ottaa käyttöön arvosteluvaihtoehdon muokkaustilassa.',
	'PublishAnonymously'		=> 'Salli anonyymi julkaisu:',
	'PublishAnonymouslyInfo'	=> 'Salli käyttäjien julkaista anonyymisti (piilottaa nimi).',

	'DefaultRenameRedirect'		=> 'Kun nimetään uudelleen, luo uudelleenohjaus:',
	'DefaultRenameRedirectInfo'	=> 'Oletuksena tarjous asettaa uudelleenohjaus vanhaan osoitteeseen, jonka sivu on uudelleennimetty.',
	'StoreDeletedPages'			=> 'Pidä poistetut sivut:',
	'StoreDeletedPagesInfo'		=> 'Kun poistat sivun, kommentin tai tiedoston, säilytä se erityisessä osiossa, jos se on käytettävissä tarkastelua ja takaisinperintään jonkin aikaa (jäljempänä kuvatulla tavalla).',
	'KeepDeletedTime'			=> 'Poistettujen sivujen tallennusaika:',
	'KeepDeletedTimeInfo'		=> 'Aika päivinä. On järkevää vain edellisen vaihtoehdon. Käytä nollaa varmistaaksesi, että kohteita ei koskaan poisteta (tässä tapauksessa ylläpitäjä voi tyhjentää "ostoskorin" manuaalisesti).',
	'PagesPurgeTime'			=> 'Sivujen muutosten säilytysaika:',
	'PagesPurgeTimeInfo'		=> 'Poistaa vanhemmat versiot automaattisesti annettujen päivien sisällä. Jos syötät nollaan, vanhempia versioita ei poisteta.',
	'EnableReferrers'			=> 'Ota suosittelijat käyttöön:',
	'EnableReferrersInfo'		=> 'Sallii ulkoisten viittaajien luomisen ja näyttämisen.',
	'ReferrersPurgeTime'		=> 'Suosittelijoiden varastointiaika:',
	'ReferrersPurgeTimeInfo'	=> 'Pidä ulkoisten sivujen historia enintään tietyn määrän päiviä. Käytä nollaa varmistaaksesi, että viittauksia ei koskaan poisteta (mutta aktiivisesti vieraillulle sivustolle, tämä voi johtaa tietokannan ylivuotoon).',
	'EnableCounters'			=> 'Osuma Counters:',
	'EnableCountersInfo'		=> 'Sallii per sivu osuma laskurit ja mahdollistaa näytön yksinkertaisia tilastoja. Näkymiä sivun omistaja ei lasketa.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Hallitse web-syndikaation oletusasetuksia sivustollesi.',
	'SyndicationSettingsUpdated'	=> 'Syndikoinnin asetukset päivitetty.',

	'FeedsSection'				=> 'Syötteet',
	'EnableFeeds'				=> 'Ota syötteet käyttöön:',
	'EnableFeedsInfo'			=> 'Kytkee RSS-syötteet päälle tai pois käytöstä koko wikin.',
	'XmlChangeLink'				=> 'Muuttaa syötteen linkkitilaa:',
	'XmlChangeLinkInfo'			=> 'Määrittää, mihin XML-muutokset syötetään kohteita linkitettiin.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'ero näkymä',
		'2'		=> 'tarkistettu sivu',
		'3'		=> 'luettelo tarkistuksista',
		'4'		=> 'nykyinen sivu',
	],

	'XmlSitemap'				=> 'XML sitemap:',
	'XmlSitemapInfo'			=> 'Luo XML-tiedoston nimeltä %1 sisällä xml kansioon. Voit lisätä polun sivustokartta vuonna robots.txt tiedosto oman root hakemistoon seuraavasti:',
	'XmlSitemapGz'				=> 'XML-sivukartan pakkaus:',
	'XmlSitemapGzInfo'			=> 'Jos haluat, voit pakata sitemap text file using gzip to reduce your kaistanleveys vaatimus.',
	'XmlSitemapTime'			=> 'XML-sivukartan luontiaika:',
	'XmlSitemapTimeInfo'		=> 'Luo sivukartta vain kerran tietyssä määrä päiviä. Aseta nolla luoda jokaisen sivun muutos.',

	'SearchSection'				=> 'Etsi',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Luo OpenSearch kuvaustiedoston XML- kansioon ja sallii haun autodiscovery of search plugin HTML otsikkoon.',
	'SearchEngineVisibility'	=> 'Estä hakukoneet (hakukoneen näkyvyys):',
	'SearchEngineVisibilityInfo'=> 'Estä hakukoneet, mutta salli tavalliset kävijät. Ohita sivuasetukset. <br>Poista hakukoneet indeksoimalla tätä sivustoa. On jopa hakukoneet kunnioittamaan tätä pyyntöä.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Hallitse oletusnäytön asetuksia sivustollesi.',
	'AppearanceSettingsUpdated'	=> 'Ulkoasun asetukset päivitetty.',

	'LogoOff'					=> 'Pois',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo ja otsikko',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Sivuston logo:',
	'SiteLogoInfo'				=> 'Logosi näkyy tyypillisesti sovelluksen vasemmassa yläkulmassa (top left corner). Max koko on 2 MiB. Optimaaliset mitat ovat 255 pikseliä leveä 55 pikseliä korkea.',
	'LogoDimensions'			=> 'Logon mitat:',
	'LogoDimensionsInfo'		=> 'Näytettävän logon leveys ja korkeus.',
	'LogoDisplayMode'			=> 'Logon näyttötila:',
	'LogoDisplayModeInfo'		=> 'Määrittää logon ulkonäön. Oletus on pois päältä.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Sivuston favikoni:',
	'SiteFaviconInfo'			=> 'Pikakuvake tai favicon, näytetään useimpien selainten osoitepalkissa, välilehdissä ja kirjanmerkeissä. Tämä ohittaa teeman faviconin.',
	'SiteFaviconTooBig'			=> 'Favicon on suurempi kuin 64 x 64 px.',
	'ThemeColor'				=> 'Teeman väri osoitepalkkille:',
	'ThemeColorInfo'			=> 'Selain asettaa osoitepalkin värin jokaiselle sivulle edellyttäen, että se on CSS väri.',

	'LayoutSection'				=> 'Asettelu',
	'Theme'						=> 'Teema:',
	'ThemeInfo'					=> 'Malli suunnitella sivuston oletusarvoisesti.',
	'ResetUserTheme'			=> 'Nollaa kaikki käyttäjäteemat:',
	'ResetUserThemeInfo'		=> 'Nollaa kaikki käyttäjien teemat. Varoitus: Tämä toiminto palauttaa kaikki käyttäjän valitsemat teemat globaaliin oletusteemaan.',
	'SetBackUserTheme'			=> 'Palauta kaikki käyttäjäteemat %1 teemaan.',
	'ThemesAllowed'				=> 'Sallitut Teemat:',
	'ThemesAllowedInfo'			=> 'Valitse sallitut teemat, jotka käyttäjä voi valita, muuten kaikki käytettävissä olevat teemat ovat sallittuja.',
	'ThemesPerPage'				=> 'Teemat sivulla:',
	'ThemesPerPageInfo'			=> 'Salli teemoja per sivu, jonka sivun omistaja voi valita kautta sivun ominaisuuksia.',

	// System settings
	'SystemSettingsInfo'		=> 'Ryhmä parametrejä vastuussa hienosäätö sivusto. Älä muuta niitä ellet ole varma niiden toimia.',
	'SystemSettingsUpdated'		=> 'Järjestelmän asetukset päivitetty',

	'DebugModeSection'			=> 'Vianetsintä Tila',
	'DebugMode'					=> 'Vianetsinnän tila:',
	'DebugModeInfo'				=> 'Sovelluksen suoritusaikaa koskevien telemetriatiedojen talteenotto ja poisto. Huomio: Täysi yksityiskohta tilassa asettaa korkeammat vaatimukset varatulle muistille, erityisesti resurssiintensiivisille toiminnoille, kuten tietokannan varmuuskopiointi ja palauttaminen.',
	'DebugModes'	=> [
		'0'		=> 'vianetsintä on pois päältä',
		'1'		=> 'vain suorituksen kokonaisaika',
		'2'		=> 'kokopäiväinen',
		'3'		=> 'täysi yksityiskohta (DBMS, välimuisti jne.)',
	],
	'DebugSqlThreshold'			=> 'Kynnysarvot RDBMS:',
	'DebugSqlThresholdInfo'		=> 'Yksityiskohtaisessa virheenjäljitystilassa, ilmoita vain kyselyt, jotka kestävät pidempään kuin ilmoitetut sekunnit.',
	'DebugAdminOnly'			=> 'Suljettu diagnoosi:',
	'DebugAdminOnlyInfo'		=> 'Näytä debug tiedot ohjelma (ja DBMS) vain järjestelmänvalvoja.',

	'CachingSection'			=> 'Välimuistin Asetukset',
	'Cache'						=> 'Välimuistin tehtävät sivut:',
	'CacheInfo'					=> 'Tallenna renderöidyt sivut paikalliseen kätköön nopeuttaaksesi myöhempää käynnistystä. Voimassa vain rekisteröimättömille kävijöille.',
	'CacheTtl'					=> 'Aikaa eläville välimuistissa oleville sivuille:',
	'CacheTtlInfo'				=> 'Välimuistin sivut enintään määritelty määrä sekuntia.',
	'CacheSql'					=> 'Välimuistin DBMS kyselyt:',
	'CacheSqlInfo'				=> 'Säilytä paikallinen välimuisti tiettyjen resursseihin liittyvien SQL-kyselyiden tuloksista.',
	'CacheSqlTtl'				=> 'Aikaa suorille välimuistissa oleville SQL-kyselyille:',
	'CacheSqlTtlInfo'			=> 'Välimuistin tulokset SQL kyselyt enintään määritetty sekuntia. Arvot suurempi kuin 1200 eivät ole toivottavia.',

	'LogSection'				=> 'Lokin Asetukset',
	'LogLevelUsage'				=> 'Käytä lokia:',
	'LogLevelUsageInfo'			=> 'Jos lokiin tallennetut tapahtumat ovat vähintään etusijalla.',
	'LogThresholds'	=> [
		'0'		=> 'älä säilytä päiväkirjaa',
		'1'		=> 'vain kriittinen taso',
		'2'		=> 'korkeimmalta tasolta',
		'3'		=> 'korkealta',
		'4'		=> 'keskimäärin',
		'5'		=> 'pienestä alkaen',
		'6'		=> 'vähimmäismäärä',
		'7'		=> 'tallenna kaikki',
	],
	'LogDefaultShow'			=> 'Näytä lokitila:',
	'LogDefaultShowInfo'		=> 'Vähimmäisprioriteettitapahtumat jotka näkyvät lokissa oletuksena',
	'LogModes'	=> [
		'1'		=> 'vain kriittinen taso',
		'2'		=> 'korkeimmalta tasolta',
		'3'		=> 'korkean tason',
		'4'		=> 'keskiarvo',
		'5'		=> 'pienestä alkaen',
		'6'		=> 'pienimmästä tasosta alkaen',
		'7'		=> 'näytä kaikki',
	],
	'LogPurgeTime'				=> 'Lokin varastointiaika:',
	'LogPurgeTimeInfo'			=> 'Poista tapahtumaloki määritetyn päivien lukumäärän jälkeen.',

	'PrivacySection'			=> 'Yksityisyys',
	'AnonymizeIp'				=> 'Anonymisoi käyttäjien IP-osoitteet:',
	'AnonymizeIpInfo'			=> 'Anonymisoi IP-osoitteet soveltuvin osin (toisin sanoen, sivu, versio tai viittaajat).',

	'ReverseProxySection'		=> 'Käänteinen Välityspalvelin',
	'ReverseProxy'				=> 'Käytä käänteisvälitystä:',
	'ReverseProxyInfo'			=> 'Ota tämä asetus käyttöön määrittääksesi etäasiakkaan oikean IP-osoitteen tutkimalla X-Forwarded-For -otsikoihin tallennettuja tietoja. X-Forwarded-For headers on standardi mekanismi tunnistaa asiakasjärjestelmät yhdistämällä käänteinen välityspalvelin, kuten Squid tai Pound. Käänteisiä välityspalvelimet käytetään usein parantamaan suorituskykyä voimakkaasti vierailevien sivustojen ja voi myös tarjota muita sivuston välimuisti-, tietoturva- tai salausetuja. Jos tämä WackoWiki asennus toimii takana käänteinen välityspalvelin, tämän asetuksen tulisi olla käytössä niin, että oikeat IP-osoitteen tiedot tallennetaan WackoWikin istunnonhallintaan, lokiin, tilastoihin ja käyttöoikeuksien hallintajärjestelmiin; jos olet epävarma tästä asetuksesta, sinulla ei ole käänteistä välitystä, tai WackoWiki toimii jaetussa hosting-ympäristössä, tämä asetus olisi pidettävä poissa käytöstä.',
	'ReverseProxyHeader'		=> 'Käänteinen välityspalvelimen otsake:',
	'ReverseProxyHeaderInfo'	=> 'Set this value if your proxy server send the client IP in a header
									 ¶ \ \ \ \ \ \ other than X-Forwarded-For. The "X-Forwarded-For" header is a comma-delimited list of IP
									 ¶ •••addresses; only the last one (left-most) will be used.',
	'ReverseProxyAddresses'		=> 'reverse_proxy hyväksyy joukon IP-osoitteita:',
	'ReverseProxyAddressesInfo'	=> 'Jokainen osa tämän taulukon on IP-osoite minkä tahansa käänteisen
									 ¼ ¼ ¼ ¼ - proxies. Jos käytät tätä taulukkoa, WackoWiki luottaa tallennetut tiedot
									 ¶ • • in X-Forwarded-For headers vain, jos etä-IP-osoite on yksi
									 − • • nämä, eli pyyntö saavuttaa Web-palvelimen yksi
									 - Vakituisesti • Vakituinen käänteinen proxies. Muussa tapauksessa asiakas voisi olla suoraan yhteydessä
									 ¶ • web-palvelimen spoofing X-Forwarded-For headers.',

	'SessionSection'				=> 'Istunnon Käsittely',
	'SessionStorage'				=> 'Istunnon tallennus:',
	'SessionStorageInfo'			=> 'Tämä valinta määrittelee missä istunnon tiedot tallennetaan. Oletuksena joko tiedosto tai tietokannan istunnon tallennustila on valittuna.',
	'SessionModes'	=> [
		'1'		=> 'Tiedosto',
		'2'		=> 'Tietokanta',
	],
	'SessionNotice'					=> 'Istunnon päättymistä koskeva ilmoitus:',
	'SessionNoticeInfo'				=> 'Ilmoittaa istunnon päättämisen syyn.',
	'LoginNotice'					=> 'Sisäänkirjautumista koskeva ilmoitus:',
	'LoginNoticeInfo'				=> 'Näyttää kirjautumisilmoituksen.',

	'RewriteMode'					=> 'Käytä <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Jos verkkopalvelimesi tukee tätä ominaisuutta, ota se käyttöön ”kaunistaaksesi” sivun URL-osoitteita.<br>
										<span class=”cite”>Asetukset-luokka saattaa korvata arvon ajonaikana riippumatta siitä, onko se kytketty pois päältä, jos HTTP_MOD_REWRITE on käytössä.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parametrit, jotka vastaavat kulunvalvonnasta ja käyttöoikeuksista.',
	'PermissionsSettingsUpdated'	=> 'Käyttöoikeusasetukset päivitetty',

	'PermissionsSection'		=> 'Oikeudet ja erioikeudet',
	'ReadRights'				=> 'Lue oikeudet oletusarvolla:',
	'ReadRightsInfo'			=> 'Oletus määritetty luoduille juurisivuille sekä sivuille, joille vanhemman ACL:ia ei voi määritellä.',
	'WriteRights'				=> 'Kirjoita oikeudet oletusarvolla:',
	'WriteRightsInfo'			=> 'Oletus määritetty luoduille juurisivuille sekä sivuille, joille vanhemman ACL:ia ei voi määritellä.',
	'CommentRights'				=> 'Kommentoi oikeudet oletusarvolla:',
	'CommentRightsInfo'			=> 'Oletus määritetty luoduille juurisivuille sekä sivuille, joille vanhemman ACL:ia ei voi määritellä.',
	'CreateRights'				=> 'Luo alisivun oikeudet oletuksella:',
	'CreateRightsInfo'			=> 'Oletus määritetty luoduille alisivuille.',
	'UploadRights'				=> 'Lataa oikeudet oletuksesta:',
	'UploadRightsInfo'			=> 'Oletusarvoiset latausoikeudet.',
	'RenameRights'				=> 'Uudelleennimeä tiedosto oikealla:',
	'RenameRightsInfo'			=> 'Luettelo käyttöoikeuksista nimetä vapaasti uudelleen (siirrä) sivut.',

	'LockAcl'					=> 'Lukitse kaikki luettavat ACL:t:',
	'LockAclInfo'				=> '<span class="cite">Ohittaa ACL- asetukset vain luettaville sivuille.</span><br>Tästä voi olla hyötyä, jos projekti on valmis, haluat, että tietoja muokataan ajan mittaan turvallisuussyistä tai että se on hätävastaus hyödyntämiseen tai haavoittuvuuteen.',
	'HideLocked'				=> 'Piilota saavuttamattomat sivut:',
	'HideLockedInfo'			=> 'Jos käyttäjällä ei ole oikeuksia lukea sivua, piilota se eri sivujen listoilla (kuitenkin tekstiin sijoitettu linkki on edelleen näkyvissä).',
	'RemoveOnlyAdmins'			=> 'Vain ylläpitäjät voivat poistaa sivuja:',
	'RemoveOnlyAdminsInfo'		=> 'Kiellä kaikki, paitsi ylläpitäjät, kyky poistaa sivuja. Ensimmäinen raja koskee omistajia tavalliset sivut.',
	'OwnersRemoveComments'		=> 'Sivujen omistajat voivat poistaa kommentteja:',
	'OwnersRemoveCommentsInfo'	=> 'Salli sivun omistajien hillitä kommentteja sivuillaan.',
	'OwnersEditCategories'		=> 'Omistajat voivat muokata sivukategorioita',
	'OwnersEditCategoriesInfo'	=> 'Salli omistajien muokata sivujen kategoria luettelo sivustosi (lisää sanoja, poista sanat), määrittää sivulle.',
	'TermHumanModeration'		=> 'Ihmisen maltillinen poistuminen:',
	'TermHumanModerationInfo'	=> 'Moderaattorit voivat muokata kommentteja vain, jos ne on luotu enintään tämän monta päivää sitten (tämä rajoitus ei koske viimeistä kommenttia aiheesta).',

	'UserCanDeleteAccount'		=> 'Salli käyttäjien poistaa tilinsä',

	// Security settings
	'SecuritySettingsInfo'		=> 'Muuttujat, jotka ovat vastuussa laiturin yleisestä turvallisuudesta, turvallisuusrajoituksista ja lisäturvaosajärjestelmistä.',
	'SecuritySettingsUpdated'	=> 'Turvallisuusasetukset päivitetty',

	'AllowRegistration'			=> 'Rekisteröidy verkossa:',
	'AllowRegistrationInfo'		=> 'Open user registration. Tämän vaihtoehdon ottaminen pois käytöstä estää ilmaisen rekisteröinnin, mutta sivuston ylläpitäjä voi silti rekisteröidä käyttäjiä.',
	'ApproveNewUser'			=> 'Hyväksy uudet käyttäjät:',
	'ApproveNewUserInfo'		=> 'Sallii järjestelmänvalvojien hyväksyä käyttäjät rekisteröitymisen jälkeen. Vain hyväksytyt käyttäjät voivat kirjautua sivustolle.',
	'PersistentCookies'			=> 'Pysyvät evästeet:',
	'PersistentCookiesInfo'		=> 'Salli pysyvät evästeet.',
	'DisableWikiName'			=> 'Poista WikiNimi:',
	'DisableWikiNameInfo'		=> 'Poista WikiName pakollinen käyttö käyttäjille. Sallii käyttäjän rekisteröinnin perinteisillä lempinimillä pakko-CamelCase-muotoisten nimien (toisin sanoen NameSurname) sijaan.',
	'UsernameLength'			=> 'Käyttäjänimen pituus:',
	'UsernameLengthInfo'		=> 'Merkkien vähimmäis- ja enimmäismäärä käyttäjätunnuksissa.',

	'EmailSection'				=> 'Sähköposti',
	'AllowEmailReuse'			=> 'Salli sähköpostiosoitteen uudelleenkäyttö:',
	'AllowEmailReuseInfo'		=> 'Eri käyttäjät voivat rekisteröityä samalla sähköpostiosoitteella.',
	'EmailConfirmation'			=> 'Pakota sähköpostin vahvistus:',
	'EmailConfirmationInfo'		=> 'Vaatii, että käyttäjä vahvistaa sähköpostiosoitteensa ennen kuin hän voi kirjautua sisään.',
	'AllowedEmailDomains'		=> 'Sallitut sähköpostiosoitteet:',
	'AllowedEmailDomainsInfo'	=> 'Pilkuilla eroteltuja sähköpostiosoitteita, esim. <code>example.com, local.lan</code> jne. Jos ei ole määritelty, kaikki sähköpostiosoitteet ovat sallittuja.',
	'ForbiddenEmailDomains'		=> 'Kielletyt sähköpostiosoitteet:',
	'ForbiddenEmailDomainsInfo'	=> 'Pilkuilla erotettu kielletty sähköpostiverkkotunnukset, esim. <code>example.com, local.lan</code> jne. Käytössä vain, jos sallitut sähköpostiosoitteet ovat tyhjä.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Ota käyttöön captcha:',
	'EnableCaptchaInfo'			=> 'Jos käytössä, captcha näytetään seuraavissa tapauksissa tai jos turvakynnys on saavutettu.',
	'CaptchaComment'			=> 'Uusi kommentti:',
	'CaptchaCommentInfo'		=> 'Suojauksena roskapostia vastaan rekisteröimättömien käyttäjien on täytettävä captcha, ennen kuin kommenttia lähetetään.',
	'CaptchaPage'				=> 'Uusi sivu:',
	'CaptchaPageInfo'			=> 'Suojauksena roskapostia vastaan rekisteröimättömien käyttäjien on täytettävä captcha-toiminto ennen uuden sivun luomista.',
	'CaptchaEdit'				=> 'Muokkaa sivua:',
	'CaptchaEditInfo'			=> 'Suojauksena roskapostia vastaan rekisteröimättömien käyttäjien on täytettävä captcha ennen sivujen muokkaamista.',
	'CaptchaRegistration'		=> 'Rekisteröinti:',
	'CaptchaRegistrationInfo'	=> 'Suojauksena roskapostia vastaan rekisteröimättömien käyttäjien on täytettävä captcha ennen rekisteröitymistä.',

	'TlsSection'				=> 'Tls- Asetukset',
	'TlsConnection'				=> 'TLS-yhteys:',
	'TlsConnectionInfo'			=> 'Käytä TLS-suojattua yhteyttä. <span class="cite">Aktivoi tarvittava esiasennettu TLS sertifikaatti palvelimelle, muuten menetät pääsyn hallintapaneeliin!</span><br>Se määrittää myös, onko Cookie Secure Flag asetettu: <code>turvallinen</code> lippu määrittää, pitäisikö evästeet lähettää vain suojatuissa yhteyksissä.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Kytke asiakas nopeasti uudelleen HTTP:stä HTTPS:ään. Kun optio ei ole käytössä, asiakas voi selata sivustoa avoimen HTTP-kanavan kautta.',

	'HttpSecurityHeaders'		=> 'Http Suojausotsakkeet',
	'EnableSecurityHeaders'		=> 'Ota suojausotsakkeet käyttöön:',
	'EnableSecurityHeadersinfo'	=> 'Aseta suojausotsikot (rungon selaus, klikkaus/XSS/CSRF-suojaus). <br>CSP voi aiheuttaa ongelmia tietyissä tilanteissa (esim. kehittämisen aikana), tai kun käytetään liitännäisiä, jotka perustuvat ulkoisesti isännöityihin resursseihin, kuten kuviin tai skripteihin. <br>Sisällön suojauskäytännön poistaminen käytöstä on turvallisuusriski!',
	'Csp'						=> 'Sisällön turvallisuuspolitiikka (CSP):',
	'CspInfo'					=> 'CSP-järjestelmän määrittäminen edellyttää sitä, että päätät, mitä politiikkoja haluat panna täytäntöön, ja määrität ne ja sisällönsuojauspolitiikan avulla luodaksesi politiikan.',
	'PolicyModes'	=> [
		'0'		=> 'poistettu käytöstä',
		'1'		=> 'tiukka',
		'2'		=> 'mukautettu',
	],
	'PermissionsPolicy'			=> 'Käyttöoikeuskäytäntö:',
	'PermissionsPolicyInfo'		=> 'HTTP Permissions-Policy -otsikko tarjoaa mekanismin, jolla voit ottaa käyttöön tai poistaa käytöstä selainominaisuuksia.',
	'ReferrerPolicy'			=> 'Viittaava politiikka:',
	'ReferrerPolicyInfo'		=> 'Referrer-Policy HTTP -otsikko säätelee, mitä referoijan otsikossa lähetettyjä tietoja tulisi sisällyttää vastauksiin.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'ei-referoija',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'samaisesta alkuperästä',
		'4'		=> 'alkuperä',
		'5'		=> 'tiukka alkuperä',
		'6'		=> 'origin-when-ristikkäinen alkuperä',
		'7'		=> 'tiukka alkuperä/when-risti-alkuperä',
		'8'		=> 'epäturva-url'
	],

	'UserPasswordSection'		=> 'Käyttäjän salasanan pysyvyys',
	'PwdMinChars'				=> 'Salasanan vähimmäispituus:',
	'PwdMinCharsInfo'			=> 'Pidemmät salasanat ovat välttämättä turvallisempia kuin lyhyemmät salasanat (esim. 12-16 merkkiä).<br>Salasanojen käyttöä ei suositeta.',
	'AdminPwdMinChars'			=> 'Pääkäyttäjän salasanan vähimmäispituus:',
	'AdminPwdMinCharsInfo'		=> 'Pidemmät salasanat ovat välttämättä turvallisempia kuin lyhyemmät salasanat (esim. 15-20 merkkiä).<br>Salasanojen käyttöä ei suositeta.',
	'PwdCharComplexity'			=> 'Vaadittu salasanan monimutkaisuus:',
	'PwdCharClasses'	=> [
		'0'		=> 'ei testattu',
		'1'		=> 'kaikki kirjaimet + numerot',
		'2'		=> 'isot kirjaimet ja pienet kirjaimet + numerot',
		'3'		=> 'isot kirjaimet ja pienet kirjaimet + numerot + merkit',
	],
	'PwdUnlikeLogin'			=> 'Muu komplikaatio:',
	'PwdUnlikes'	=> [
		'0'		=> 'ei testattu',
		'1'		=> 'salasana ei ole sama kuin kirjautuminen',
		'2'		=> 'salasana ei sisällä käyttäjänimeä',
	],

	'LoginSection'				=> 'Kirjaudu',
	'MaxLoginAttempts'			=> 'Suurin määrä kirjautumisyrityksiä per käyttäjänimi:',
	'MaxLoginAttemptsInfo'		=> 'Kirjautumisyritysten määrä sallittu yhdelle tilille ennen kuin spambot-toiminto käynnistetään. Syötä 0 estääksesi spambot-tehtävän käynnistymisen erillisille käyttäjätileille. @ info',
	'IpLoginLimitMax'			=> 'Suurin määrä kirjautumisyrityksiä per IP-osoite:',
	'IpLoginLimitMaxInfo'		=> 'Kynnys kirjautumisyritysten sallittu yhdestä IP-osoitteesta ennen kuin anti-spambot tehtävä käynnistetään. Syötä 0 estääksesi anti-spambot tehtävän käynnistymisen IP-osoitteissa.',

	'FormsSection'				=> 'Lomakkeet',
	'FormTokenTime'				=> 'Enimmäisaika lomakkeiden lähettämisessä:',
	'FormTokenTimeInfo'			=> 'Ajankohta, jolloin käyttäjän on lähetettävä lomake (sekunneissa).<br> Huomaa, että lomake saattaa olla virheellinen istunnon päättyessä tästä asetuksesta riippumatta.',

	'SessionLength'				=> 'Istunnon eväste:',
	'SessionLengthInfo'			=> 'Oletuksena käyttöikä käyttäjän istunnon eväste (päivissä).',
	'CommentDelay'				=> 'Tulvantorjunta huomautusten perusteella:',
	'CommentDelayInfo'			=> 'Vähimmäisviive uusien käyttäjien kommenttien julkaisemisen välillä (sekunneissa).',
	'IntercomDelay'				=> 'Tulvantorjunta henkilökohtaiseen viestintään:',
	'IntercomDelayInfo'			=> 'Vähimmäisviive yksityisten viestien lähettämisen välillä (sekunneissa).',
	'RegistrationDelay'			=> 'Rekisteröitymisen aikaraja',
	'RegistrationDelayInfo'		=> 'Vähimmäisaika rekisteröintilomakkeen toimittamisen välillä, jotta rekisteröintibotteja ei kannusteta (sekunneissa).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Ryhmä parametrejä vastuussa hienosäätö sivusto. Älä muuta niitä ellet ole varma niiden toimia.',
	'FormatterSettingsUpdated'	=> 'Muotoilun asetukset päivitetty',

	'TextHandlerSection'		=> 'Tekstin Käsittelijä:',
	'Typografica'				=> 'Typografinen oikolukija:',
	'TypograficaInfo'			=> 'Tämän asetuksen poistaminen käytöstä nopeuttaa kommentteja lisääviä prosesseja ja sivujen tallentamista.',
	'Paragrafica'				=> 'Kappaleiden merkinnät:',
	'ParagraficaInfo'			=> 'Kuten edellinen vaihtoehto, mutta johtaa kytkeytymättömän automaattisen sisällön taulukon (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Yleinen HTML-tuki:',
	'AllowRawhtmlInfo'			=> 'Tämä vaihtoehto on mahdollisesti vaarallinen avoin sivusto.',
	'SafeHtml'					=> 'Suodatetaan HTML:',
	'SafeHtmlInfo'				=> 'Estää vaarallisten HTML-objektien tallentamisen. Suodattimen sammuttaminen avoimella sivustolla HTML-tuella on <span class="underline">erittäin</span> ei toivottavaa!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formatter)',
	'X11colors'					=> 'X11 värien käyttö:',
	'X11colorsInfo'				=> 'Laajentaa saatavilla olevat värit <code>??(väri) taustalle??</code> ja <code>!!(väri) teksti!!</code>Tämän asetuksen poistaminen käytöstä nopeuttaa kommentteja lisäämisen ja sivujen tallentamisen prosesseja.',
	'WikiLinks'					=> 'Poista wiki-linkit käytöstä:',
	'WikiLinksInfo'				=> 'Poistaa yhteyden <code>CamelCaseWords</code>: CamelCase sanoja ei enää linkitetä suoraan uuteen sivuun. Tämä on hyödyllistä, kun työskentelet eri nimia/ryhmiä. Oletuksena se on pois päältä.',
	'BracketsLinks'				=> 'Poista ristikkäiset linkit:',
	'BracketsLinksInfo'			=> 'Poistaa <code>[[link]]</code> ja <code>((link))</code> syntaksin.',
	'Formatters'				=> 'Poista formaatit käytöstä:',
	'FormattersInfo'			=> 'Poistaa käytöstä <code>%%code%%%</code>-syntaksin, jota käytetään korostimissa.',

	'DateFormatsSection'		=> 'Päivämäärän Muodot',
	'DateFormat'				=> 'Päivämäärän muoto:',
	'DateFormatInfo'			=> '(päivä, kuukausi, vuosi)',
	'TimeFormat'				=> 'Ajankohdan muoto:',
	'TimeFormatInfo'			=> '(tunti, minuutti)',
	'TimeFormatSeconds'			=> 'Tarkan ajan muoto:',
	'TimeFormatSecondsInfo'		=> '(tuntia, minuuttia, sekuntia)',
	'NameDateMacro'				=> '<code>: :@::</code> makro:',
	'NameDateMacroInfo'			=> '(nimi, aika), esim. <code>Käyttäjätunnus (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Timezone:',
	'TimezoneInfo'				=> 'Aikavyöhyke, jota käytetään aikojen näyttämiseen käyttäjille, jotka eivät ole kirjautuneet sisään (vieraille). Kirjautuneet käyttäjät voivat muuttaa aikavyöhykettään käyttäjän asetuksissa.',
	'AmericanDate'					=> 'Amerikan pvm:',
	'AmericanDateInfo'				=> 'Käyttää amerikkalaista päivämäärän muotoa oletuksena englanniksi.',

	'Canonical'					=> 'Käytä täysin kanonisia URL-osoitteita:',
	'CanonicalInfo'				=> 'Kaikki linkit on luotu absoluuttisina URL-osoitteina muodossa %1. URL-osoitteet suhteessa palvelimen juuriin muodossa %2 tulisi asettaa etusijalle.',
	'LinkTarget'				=> 'Jos ulkoiset linkit avataan:',
	'LinkTargetInfo'			=> 'Avaa jokaisen ulkoisen linkin selaimen uudessa ikkunassa. Lisää <code>target="_blank"</code> linkin syntaksiin.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Vaatii, että selain ei lähetä HTTP refererin otsikkoa, jos käyttäjä seuraa hyperlinkkiä. Lisää <code>rel="noreferrer"</code> linkin syntaksiin.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Kerää hakukoneita, joiden hyperlinkit eivät saa vaikuttaa hakukoneen indeksin kohdesivun sijoitteluun. Lisää linkin syntaksiin <code>rel="nofollow"</code>.',
	'UrlsUnderscores'			=> 'Lomakkeen osoitteet (URLs) alaviivoilla:',
	'UrlsUnderscoresInfo'		=> 'Esimerkiksi, %1 becames %2 tällä valinnalla.',
	'ShowSpaces'				=> 'Näytä välilyönnit WikiNimissä:',
	'ShowSpacesInfo'			=> 'Näytä välilyönnit WikiNamesissa, esim. <code>MyName</code> näytetään <code>My Name</code> tällä valinnalla.',
	'NumerateLinks'				=> 'Kuvaa linkit tulostusnäkymään:',
	'NumerateLinksInfo'			=> 'Lukee ja listaa kaikki linkit tulostusnäkymän alareunassa tämän vaihtoehdon avulla.',
	'YouareHereText'			=> 'Poista itseviittaavat linkit käytöstä ja visualisoi niitä:',
	'YouareHereTextInfo'		=> 'Visualisoi linkit samaan sivuun, käyttäen <code>&lt;b&gt;####&lt;/b&gt;</code>. Kaikki linkit itse menettää linkin muotoilu, mutta näytetään lihavoitu teksti.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Täällä voit asettaa tai muuttaa Wikissä käytettyjä järjestelmän perussivuja. Varmista, että et unohda luoda tai muuttaa vastaavia sivuja Wiki mukaan asetukset täällä.',
	'PagesSettingsUpdated'		=> 'Päivitetyt asetusten perussivut',

	'ListCount'					=> 'Tuotteiden määrä luetteloa kohti:',
	'ListCountInfo'				=> 'Jokaisessa luettelossa näytettävien kohteiden määrä tai oletusarvo uusille käyttäjille.',

	'ForumSection'				=> 'Valinnat Foorumi',
	'ForumCluster'				=> 'Klusterifoorumi:',
	'ForumClusterInfo'			=> 'Root cluster for forum section (toiminta %1).',
	'ForumTopics'				=> 'Aiheiden määrä sivulla:',
	'ForumTopicsInfo'			=> 'Foorumiosioissa näytettävien aiheiden lukumäärä listan jokaisella sivulla (toiminto %1).',
	'CommentsCount'				=> 'Kommentteja per sivu:',
	'CommentsCountInfo'			=> 'Montako kommenttia näytetään kunkin sivun lista kommenteista. Tämä koskee kaikkia kommentteja sivustolla, ei vain niitä lähetetty foorumilla.',

	'NewsSection'				=> 'Osion Uutiset',
	'NewsCluster'				=> 'Kluster for the news:',
	'NewsClusterInfo'			=> 'Juuriryhmä uutisosiota varten (toimi %1).',
	'NewsStructure'				=> 'Uutisklusterin rakenne:',
	'NewsStructureInfo'			=> 'Säilytä artikkelit valinnaisesti alaryppäissä vuosi/kuukausi tai viikko (esim. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Lisenssi',
	'DefaultLicense'			=> 'Oletus lisenssi:',
	'DefaultLicenseInfo'		=> 'Millä lisenssillä sisältösi voidaan vapauttaa.',
	'EnableLicense'				=> 'Salli lisenssi:',
	'EnableLicenseInfo'			=> 'Ota käyttöön nähdäksesi lisenssitiedot.',
	'LicensePerPage'			=> 'Lisenssi sivua kohti:',
	'LicensePerPageInfo'		=> 'Salli lisenssi per sivu, jonka sivun omistaja voi valita kautta sivun ominaisuuksia.',

	'ServicePagesSection'		=> 'Palvelun Sivut',
	'RootPage'					=> 'Kotisivu :',
	'RootPageInfo'				=> 'Tunniste pääsivustasi, avautuu automaattisesti, kun käyttäjä vierailee sivustollasi.',

	'PrivacyPage'				=> 'Yksityisyyden suoja:',
	'PrivacyPageInfo'			=> 'The page with the Privacy Policy of the site.',

	'TermsPage'					=> 'Politiikat ja määräykset:',
	'TermsPageInfo'				=> 'Sivu, jossa on sivuston säännöt.',

	'SearchPage'				=> 'Etsi:',
	'SearchPageInfo'			=> 'Sivu hakulomakkeella (toiminto %1).',
	'RegistrationPage'			=> 'Rekisteröinti:',
	'RegistrationPageInfo'		=> 'Sivu uudelle käyttäjälle rekisteröinnille (toimi %1).',
	'LoginPage'					=> 'Käyttäjän kirjautuminen:',
	'LoginPageInfo'				=> 'Kirjautumissivu sivustolla (toiminto %1).',
	'SettingsPage'				=> 'Käyttäjän Asetukset:',
	'SettingsPageInfo'			=> 'Sivu muokataksesi käyttäjäprofiilia (toiminto %1).',
	'PasswordPage'				=> 'Vaihda Salasana:',
	'PasswordPageInfo'			=> 'Sivu lomakkeella, jolla muutetaan / kysy käyttäjän salasana (toiminto %1).',
	'UsersPage'					=> 'Käyttäjän lista:',
	'UsersPageInfo'				=> 'Sivu, jossa on luettelo rekisteröityneistä käyttäjistä (toiminto %1).',
	'CategoryPage'				=> 'Luokka:',
	'CategoryPageInfo'			=> 'Sivu, jossa on luettelo luokitelluista sivuista (toimi %1).',
	'GroupsPage'				=> 'Ryhmät:',
	'GroupsPageInfo'			=> 'Sivu, jolla on luettelo työryhmistä (toiminto %1).',
	'ChangesPage'				=> 'Viimeaikaiset muutokset:',
	'ChangesPageInfo'			=> 'Sivu viimeksi muokatuilla sivuilla (toimi %1).',
	'CommentsPage'				=> 'Viimeaikaiset kommentit:',
	'CommentsPageInfo'			=> 'Sivu jossa on luettelo viimeaikaisista kommenteista sivulla (toiminto %1).',
	'RemovalsPage'				=> 'Poistetut sivut:',
	'RemovalsPageInfo'			=> 'Sivu äskettäin poistetuilla sivuilla (toiminto %1).',
	'WantedPage'				=> 'Halutut sivut:',
	'WantedPageInfo'			=> 'Sivu, jossa on luettelo puuttuvista sivuista, joihin viitataan (toiminto %1).',
	'OrphanedPage'				=> 'Orvot sivut:',
	'OrphanedPageInfo'			=> 'Sivu, jolla on luettelo olemassa olevista sivuista, ei liity linkkien kautta muille sivuille (toiminto %1).',
	'SandboxPage'				=> 'Hiekkalaatikko:',
	'SandboxPageInfo'			=> 'Sivu, jossa käyttäjät voivat harjoitella wiki markup taitoja.',
	'HelpPage'					=> 'Apu:',
	'HelpPageInfo'				=> 'Dokumentaatiojakso, joka koskee työskentelyä sivuston työkalujen kanssa.',
	'IndexPage'					=> 'Indeksi:',
	'IndexPageInfo'				=> 'Sivu, jossa on luettelo kaikista sivuista (toiminto %1).',
	'RandomPage'				=> 'Satunnainen:',
	'RandomPageInfo'			=> 'Lataa satunnainen sivu (toiminto %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Alustan ilmoituksia koskevat parametrit.',
	'NotificationSettingsUpdated'	=> 'Ilmoitusasetukset päivitetty',

	'EmailNotification'			=> 'Sähköposti-ilmoitus:',
	'EmailNotificationInfo'		=> 'Salli sähköposti-ilmoitus. Aseta käyttöön ottaaksesi sähköposti-ilmoitukset, pois käytöstä poistaaksesi ne käytöstä. Huomaa, että sähköpostiilmoitusten poistaminen käytöstä ei vaikuta sähköposteihin, jotka on luotu osana käyttäjän kirjautumisprosessia.',
	'Autosubscribe'				=> 'Automaattitilaus:',
	'AutosubscribeInfo'			=> 'Ilmoita automaattisesti sivun muutoksista omistajalle.',

	'NotificationSection'		=> 'Käyttäjäilmoitusten Oletusasetukset',
	'NotifyPageEdit'			=> 'Ilmoita sivun muokkaus:',
	'NotifyPageEditInfo'		=> 'Odottaa - Lähetä sähköposti-ilmoitus vain ensimmäiseen muutokseen, kunnes käyttäjä vierailee sivulla uudelleen.',
	'NotifyMinorEdit'			=> 'Ilmoita vähäisestä muokkauksesta:',
	'NotifyMinorEditInfo'		=> 'Lähettää ilmoituksia myös pienistä muokkauksista.',
	'NotifyNewComment'			=> 'Huomauta uutta kommenttia:',
	'NotifyNewCommentInfo'		=> 'Odottaa - Lähetä sähköposti-ilmoitus vain ensimmäinen kommentti kunnes käyttäjä vierailee sivulla uudelleen.',

	'NotifyUserAccount'			=> 'Ilmoita uudelle käyttäjätilille:',
	'NotifyUserAccountInfo'		=> 'Ylläpitäjä tulee ilmoittamaan, kun uusi käyttäjä on luotu käyttäen ilmoittautumislomaketta.',
	'NotifyUpload'				=> 'Ilmoita tiedostojen lataus:',
	'NotifyUploadInfo'			=> 'Valvoja tullaan ilmoittamaan, kun tiedosto on ladattu.',

	'PersonalMessagesSection'	=> 'Henkilökohtaiset Viestit',
	'AllowIntercomDefault'		=> 'Salli intercom:',
	'AllowIntercomDefaultInfo'	=> 'Tämän asetuksen käyttöönotto sallii muiden käyttäjien lähettää henkilökohtaisia viestejä vastaanottajan sähköpostiosoitteeseen paljastamatta osoitetta.',
	'AllowMassemailDefault'		=> 'Salli massasähköposti:',
	'AllowMassemailDefaultInfo'	=> 'Lähetä viestejä vain niille käyttäjille, jotka ovat sallineet järjestelmänvalvojien lähettää heille tietoja.',

	// Resync settings
	'Synchronize'				=> 'Synchronize',
	'UserStatsSynched'			=> 'Käyttäjän tilastot synkronoitu.',
	'PageStatsSynched'			=> 'Sivutilastot synkronoitu.',
	'FeedsUpdated'				=> 'RSS-syötteet päivitetty.',
	'SiteMapCreated'			=> 'Sivuston kartan uusi versio luotu onnistuneesti.',
	'ParseNextBatch'			=> 'Jäsentää seuraavat sivut:',
	'WikiLinksRestored'			=> 'Wiki-linkit palautettu.',

	'LogUserStatsSynched'		=> 'Synkronoidut käyttäjätilastot',
	'LogPageStatsSynched'		=> 'Synkronoidut sivutilastot',
	'LogFeedsUpdated'			=> 'Synkronoidut RSS-syötteet',
	'LogPageBodySynched'		=> 'Palautettu sivun runko ja linkit',

	'UserStats'					=> 'Käyttäjän tilastot',
	'UserStatsInfo'				=> 'Käyttäjätilastot (kommenttien lukumäärä, omistamat sivut, versiot ja tiedostot) saattavat joissakin tilanteissa poiketa todellisista tiedoista. <br>Tämä toiminto sallii tietojen päivityksen vastaamaan tietokannan todellisia tietoja.',
	'PageStats'					=> 'Sivun tilastot',
	'PageStatsInfo'				=> 'Sivutilastot (kommenttien lukumäärä, tiedostot ja korjaukset) saattavat joissakin tilanteissa poiketa todellisista tiedoista. <br>Tämä toiminto mahdollistaa tilastojen päivittämisen tietokannan sisältämien todellisten tietojen mukaan.',

	'AttachmentsInfo'			=> 'Päivitä tiedostojen tiivistelmä kaikille tietokannan liitteille.',
	'AttachmentsSynched'		=> 'Uudelleen hajautettu kaikki liitetiedostot',
	'LogAttachmentsSynched'		=> 'Uudelleen hajautettu kaikki liitetiedostot',

	'Feeds'						=> 'Syötteet',
	'FeedsInfo'					=> 'Kun kyseessä on tietokannan sivujen suora muokkaus, RSS-syötteiden sisältö ei välttämättä vastaa tehtyjä muutoksia. <br>Tämä toiminto synkronoi RSS-kanavat tietokannan nykyisen tilan kanssa.',
	'XmlSiteMap'				=> 'XML Sitemap',
	'XmlSiteMapInfo'			=> 'Tämä toiminto synkronoi XML-sivukartan tietokannan nykyisen tilan kanssa.',
	'XmlSiteMapPeriod'			=> 'Jakso %1 päivää. Viimeksi kirjoitettu %2.',
	'XmlSiteMapView'			=> 'Näytä sivukartta uudessa ikkunassa.',

	'ReparseBody'				=> 'Korjaa kaikki sivut',
	'ReparseBodyInfo'			=> 'Tyhjät <code>body_r</code> sivutaulukossa, niin että jokainen sivu saa renderöidyn seuraavan sivun näkymässä. Tämä voi olla hyödyllistä, jos muokkasit formaattia tai muutit wikisi verkkotunnusta.',
	'PreparsedBodyPurged'		=> 'Tyhjennetty <code>body_r</code> -kenttä sivutaulukossa.',

	'WikiLinksResync'			=> 'Wiki linkit',
	'WikiLinksResyncInfo'		=> 'Suorittaa uudelleenrenderöinnin kaikille intrasite-linkeille ja palauttaa <code>page_link</code> ja <code>file_link</code> -taulukoiden sisällön, jos vahingot tai uudelleensijoitukset tapahtuvat (tämä voi kestää kauan).',
	'RecompilePage'				=> 'Kokoa uudelleen kaikki sivut (erittäin kalliisti)',
	'ResyncOptions'				=> 'Muut asetukset',
	'RecompilePageLimit'		=> 'Niiden sivujen määrä, jotka jäsennetään kerralla.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Näitä tietoja käytetään, kun moottori lähettää sähköposteja käyttäjille. Varmista, että määrittämäsi sähköpostiosoite on voimassa, sillä kaikki lähetetyt tai toimittamattomat viestit lähetetään todennäköisesti kyseiseen osoitteeseen. Jos hosting-palveluntarjoaja ei tarjoa natiivi (PHP-pohjaista) sähköpostipalvelua, voit sen sijaan lähettää viestejä suoraan SMTP:llä. Tämä edellyttää sopivan palvelimen osoitetta (kysy tarvittaessa palveluntarjoajalta). Jos palvelin vaatii todennuksen (ja vain jos se tekee), kirjoita tarvittava käyttäjänimi, salasana ja todentamismenetelmä.',

	'EmailSettingsUpdated'		=> 'Sähköpostin asetukset päivitetty',

	'EmailFunctionName'			=> 'Sähköpostifunktion nimi:',
	'EmailFunctionNameInfo'		=> 'Sähköpostifunktio, jota käytetään sähköpostien lähettämiseen PHP:n kautta.',
	'UseSmtpInfo'				=> 'Valitse <code>SMTP</code> jos haluat lähettää tai joudut lähettämään sähköpostia nimetyn palvelimen kautta paikallisen sähköpostifunktion kautta.',

	'EnableEmail'				=> 'Ota sähköpostit käyttöön:',
	'EnableEmailInfo'			=> 'Ota sähköpostien lähettäminen käyttöön.',

	'EmailIdentitySettings'		=> 'Sivuston Sähköposti Identiteetit',
	'FromEmailName'				=> 'Lähettäjän nimi:',
	'FromEmailNameInfo'			=> 'Lähettäjän nimi, jota käytetään <code>Alkaen:</code> otsikko kaikille sivustolta lähetetyille sähköposti-ilmoituksille.',
	'EmailSubjectPrefix'		=> 'Kohteen etuliite:',
	'EmailSubjectPrefixInfo'	=> 'Vaihtoehtoinen sähköpostin aiheen etuliite, esim. <code>[Prefix] Aihe</code>. Jos ei ole määritelty, oletusetuliite on Sivuston nimi: %1.',

	'NoReplyEmail'				=> 'Ei vastausta osoite:',
	'NoReplyEmailInfo'			=> 'Tämä osoite, esim. <code>noreply@example.com</code>, ilmestyy <code>Alkaen:</code> kaikkien sivustolta lähetettyjen sähköpostiilmoitusten sähköpostiosoitteeseen.',
	'AdminEmail'				=> 'Sivuston omistajan sähköposti:',
	'AdminEmailInfo'			=> 'Tätä osoitetta käytetään hallintatarkoituksiin, kuten uuden käyttäjän ilmoitukseen.',
	'AbuseEmail'				=> 'Sähköpostin väärinkäyttöpalvelu:',
	'AbuseEmailInfo'			=> 'Osoitepyynnöt kiireellisistä asioista: ulkomaisen sähköpostin rekisteröinti jne. Se voi olla sama kuin sivuston omistajan sähköposti.',

	'SendTestEmail'				=> 'Lähetä testisähköposti',
	'SendTestEmailInfo'			=> 'Tämä lähettää testisähköpostin osoitteeseen, joka on määritetty tililläsi.',
	'TestEmailSubject'			=> 'Wiki on määritetty oikein lähettää sähköposteja',
	'TestEmailBody'				=> 'Jos olet saanut tämän sähköpostiviestin, Wiki on oikein konfiguroitu lähettämään sähköposteja.',
	'TestEmailMessage'			=> 'Testisähköposti on lähetetty.<br>Jos et saa sitä, tarkista sähköpostisi asetukset.',

	'SmtpSettings'				=> 'Smtp Asetukset',
	'SmtpAutoTls'				=> 'Opportunistinen TLS:',
	'SmtpAutoTlsInfo'			=> 'Mahdollistaa salauksen automaattisesti, jos se näkee, että palvelin mainostaa TLS-salausta (kun olet yhdistänyt palvelimeen), vaikka et ole asettanut yhteyttä tilaa <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Yhteyden tila SMTP: lle:',
	'SmtpConnectionModeInfo'	=> 'Käytetään vain, jos käyttäjätunnus/salasana on pakollinen. Kysy palveluntarjoajaltasi, jos olet epävarma mitä menetelmää käytetään.',
	'SmtpPassword'				=> 'SMTP salasana:',
	'SmtpPasswordInfo'			=> 'Syötä salasana vain, jos SMTP-palvelin vaatii sen.<br><em><strong>Varoitus:</strong> Tämä salasana tallennetaan plaintext tietokantaan, näkyvät kaikille, jotka voivat käyttää tietokantaasi tai jotka voivat tarkastella tätä asetussivua.</em>',
	'SmtpPort'					=> 'SMTP palvelimen portti:',
	'SmtpPortInfo'				=> 'Muuta tätä vain, jos tiedät, että SMTP-palvelimesi on eri portissa. <br>(oletus: <code>tls</code> portissa 587 (tai mahdollisesti 25) ja <code>ssl</code> portissa 465).',
	'SmtpServer'				=> 'SMTP palvelimen osoite:',
	'SmtpServerInfo'			=> 'Huomaa, että sinun täytyy antaa protokolla, jota palvelin käyttää. Jos käytät SSL, tämän täytyy olla <code>ssl://mail.example.com</code>.',
	'SmtpUsername'				=> 'SMTP käyttäjätunnus:',
	'SmtpUsernameInfo'			=> 'Syötä käyttäjänimi vain, jos SMTP-palvelin vaatii sen.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Täällä voit määrittää tärkeimmät asetukset liitteitä ja niihin liittyviä erityisiä luokkia.',
	'UploadSettingsUpdated'		=> 'Päivitetty latausasetukset',

	'FileUploadsSection'		=> 'Tiedostojen Lataukset',
	'RegisteredUsers'			=> 'rekisteröidyt käyttäjät',
	'RightToUpload'				=> 'Oikeudet ladata tiedostoja:',
	'RightToUploadInfo'			=> '<code>admins</code> tarkoittaa, että vain ylläpitäjien ryhmään kuuluvat käyttäjät voivat ladata tiedostoja. <code>1</code> tarkoittaa, että lataus avataan rekisteröidyille käyttäjille. <code>0</code> tarkoittaa, että lataus ei ole käytössä.',
	'UploadMaxFilesize'			=> 'Tiedoston enimmäiskoko:',
	'UploadMaxFilesizeInfo'		=> 'Kunkin tiedoston enimmäiskoko. Jos tämä arvo on 0, suurin ladattava tiedostokoko rajoittuu vain PHP-asetuksiin.',
	'UploadQuota'				=> 'Liitekiintiö yhteensä:',
	'UploadQuotaInfo'			=> 'Koko wikin lisäosien maksimimäärä käytettävissä ja <code>0</code> on rajoittamaton. %1 käytetty.',
	'UploadQuotaUser'			=> 'Varastointikiintiö käyttäjää kohden:',
	'UploadQuotaUserInfo'		=> 'Varastointikiintiön rajoittaminen, jonka yksi käyttäjä voi ladata ja jonka <code>0</code> on rajoittamaton.',

	'FileTypes'					=> 'Tiedostotyypit',
	'UploadOnlyImages'			=> 'Salli vain kuvien lähettäminen:',
	'UploadOnlyImagesInfo'		=> 'Salli vain kuvatiedostojen lataaminen sivulla.',
	'AllowedUploadExts'			=> 'Sallitut tiedostotyypit:',
	'AllowedUploadExtsInfo'		=> 'Sallitut lisäosat tiedostojen lataamiseen, pilkuilla eroteltuja (esim. <code>png, ogg, mp4</code>); muussa tapauksessa kaikki tiedostopäätteet ovat sallittuja.<br>Sinun pitäisi rajoittaa sallitut tiedostopäätteet niin pieneen kuin sivustosi oikean toiminnon edellyttää.',
	'CheckMimetype'				=> 'Tarkista MIME-tyyppi:',
	'CheckMimetypeInfo'			=> 'Joitakin selaimia voidaan huijata, jotta voidaan olettaa, että ladattaville tiedostoille on väärä mimetyppi. Tämä valinta varmistaa, että tällaiset tiedostot, jotka todennäköisesti aiheuttavat tämän, hylätään.',
	'SvgSanitizer'				=> 'SVG sanitiaattori:',
	'SvgSanitizerInfo'			=> 'Tämä mahdollistaa SvG- tiedostojen sanitiivistyksen, joka estää SVG/XML-haavoittuvuuksien lähettämisen.',
	'TranslitFileName'			=> 'Transliterate tiedostojen nimet:',
	'TranslitFileNameInfo'		=> 'Jos se on sovellettavissa ja Unicode-merkkejä ei tarvita, on erittäin suositeltavaa hyväksyä vain alfanumeeriset merkit tiedostonimissä.',
	'TranslitCaseFolding'		=> 'Muunna tiedostonimet pieniksi kirjaimiksi:',
	'TranslitCaseFoldingInfo'	=> 'Tämä vaihtoehto on tehokas vain aktiivisen translitteroinnin avulla.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Create thumbnail:',
	'CreateThumbnailInfo'		=> 'Luo pikkukuva kaikissa mahdollisissa tilanteissa.',
	'JpegQuality'				=> 'JPEG-laatu:',
	'JpegQualityInfo'			=> 'Laatu skaalatessa JPEG-pikkukuvaa. Sen pitäisi olla välillä 1 ja 100, 100 osoittaa 100% laatua.',
	'MaxImageArea'				=> 'Kuvan enimmäisalue:',
	'MaxImageAreaInfo'			=> 'Suurin sallittu määrä pikseleitä, joita lähdekuvassa voi olla. Tämä tarjoaa rajan muistin käytölle kuvan skaalauksen purkupuolella.<br><code>-1</code> tarkoittaa, että se ei tarkista kuvan kokoa ennen kuin yritetään skaalata. <code>0</code> tarkoittaa, että se määrittää arvon automaattisesti.',
	'MaxThumbWidth'				=> 'Pienoiskuvan suurin leveys pikseleinä:',
	'MaxThumbWidthInfo'			=> 'Luotu pikkukuva ei ylitä tässä asetettua leveyttä.',
	'MinThumbFilesize'			=> 'Pienimmän pikkukuvan koko:',
	'MinThumbFilesizeInfo'		=> 'Älä luo pikkukuvaa pienemmille kuville.',
	'MaxImageWidth'				=> 'Kuvan kokoraja sivuilla:',
	'MaxImageWidthInfo'			=> 'Kuvan suurin leveys voi olla sivuilla, muuten luodaan pienennetty pienoiskuva alaspäin.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Luettelo poistetuista sivuista, versioista ja tiedostoista.
 Poista tai palauta sivut, versiot tai tiedostot tietokannasta napsauttamalla <em>Poista</em>-linkkiä.
 tai <em>Palauta</em> vastaavalla rivillä. (Ole varovainen, poistovahvistusta ei pyydetä!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Sanat, jotka automaattisesti sensuroidaan Wikillesi.',
	'FilterSettingsUpdated'		=> 'Roskapostisuodattimen asetukset päivitetty',

	'WordCensoringSection'		=> 'Sana Sensorointi',
	'SPAMFilter'				=> 'Roskapostin suodatin:',
	'SPAMFilterInfo'			=> 'Ota Roskapostisuodatin Käyttöön',
	'WordList'					=> 'Sanaluettelo:',
	'WordListInfo'				=> 'Sana tai lause <code>fragmentti</code> olla mustalla listalla (yksi per rivi)',

	// Log module
	'LogFilterTip'				=> 'Suodata tapahtumia kriteerien mukaan:',
	'LogLevel'					=> 'Taso',
	'LogLevelFilters'	=> [
		'1'		=> 'vähintään yksi kuin',
		'2'		=> 'ei suurempi kuin',
		'3'		=> 'tasa-arvoinen',
	],
	'LogNoMatch'				=> 'Ei mitään kriteerejä täyttäviä tapahtumia',
	'LogDate'					=> 'Päivämäärä',
	'LogEvent'					=> 'Tapahtuma',
	'LogUsername'				=> 'Käyttäjätunnus',
	'LogLevels'	=> [
		'1'		=> 'kriittinen',
		'2'		=> 'korkein',
		'3'		=> 'korkea',
		'4'		=> 'keskikokoinen',
		'5'		=> 'matala',
		'6'		=> 'alin',
		'7'		=> 'vianetsintä',
	],

	// Massemail module
	'MassemailInfo'				=> 'Täällä voit lähettää viestin joko (1) kaikille käyttäjille tai (2) kaikille tietyn ryhmän käyttäjille, jotka ovat ottaneet käyttöön joukkoviestien vastaanottamisen. Sähköpostiosoite lähetetään hallinnolliseen sähköpostiosoitteeseen, johon on lähetetty sokean hiilen kopio (BCC) kaikille vastaanottajille. Oletusasetus on sisällyttää enintään 20 vastaanottajaa tällaiseen sähköpostiin. Jos vastaanottajia on enemmän kuin 20, lähetetään lisää sähköposteja. Jos olet lähettämässä sähköpostia suurelle joukolle, ole hyvä ja kärsivällinen lähettämisen jälkeen ja älä lopeta sivun puolivälissä. On normaalia, että massasähköposti kestää kauan. Sinulle ilmoitetaan, kun skripti on valmis.',
	'LogMassemail'				=> 'Massasähköposti lähetä %1 ryhmälle / käyttäjälle ',
	'MassemailSend'				=> 'Massasähköpostin lähetys',

	'NoEmailMessage'			=> 'Sinun täytyy syöttää viesti.',
	'NoEmailSubject'			=> 'Sinun on määritettävä viestin aihe.',
	'NoEmailRecipient'			=> 'Sinun on määritettävä vähintään yksi käyttäjä tai käyttäjäryhmä.',

	'MassemailSection'			=> 'Massasähköposti',
	'MessageSubject'			=> 'Aihe:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Viestisi:',
	'YourMessageInfo'			=> 'Huomaa, että voit syöttää vain plaintext. Kaikki merkintä poistetaan ennen lähettämistä.',

	'NoUser'					=> 'Ei käyttäjää',
	'NoUserGroup'				=> 'Ei käyttäjäryhmää',

	'SendToGroup'				=> 'Lähetä ryhmään:',
	'SendToUser'				=> 'Lähetä käyttäjälle:',
	'SendToUserInfo'			=> 'Vain käyttäjät, jotka sallivat järjestelmänvalvojien sähköpostin lähettämisen, saavat massasähköposteja. Tämä valinta on käytettävissä käyttäjän asetuksissa ilmoituksien alla.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Järjestelmän viesti päivitetty',

	'SysMsgSection'				=> 'Järjestelmän Viesti',
	'SysMsg'					=> 'Järjestelmän viesti:',
	'SysMsgInfo'				=> 'Tekstisi tässä',

	'SysMsgType'				=> 'Tyyppi:',
	'SysMsgTypeInfo'			=> 'Viestin tyyppi (CSS).',
	'SysMsgAudience'			=> 'Yleisö:',
	'SysMsgAudienceInfo'		=> 'Yleisö on näytetty järjestelmän viestille.',
	'EnableSysMsg'				=> 'Ota järjestelmäviesti käyttöön:',
	'EnableSysMsgInfo'			=> 'Näytä järjestelmän viesti.',

	// User approval module
	'ApproveNotExists'			=> 'Valitse vähintään yksi käyttäjä Set-painikkeen kautta.',

	'LogUserApproved'			=> 'Käyttäjä ##%1## hyväksytty',
	'LogUserBlocked'			=> 'Käyttäjä ##%1## estetty',
	'LogUserDeleted'			=> 'Käyttäjä ##%1## poistettu tietokannasta',
	'LogUserCreated'			=> 'Luotu uuden käyttäjän ##%1##',
	'LogUserUpdated'			=> 'Päivitetty Käyttäjä ##%1##',
	'LogUserPasswordReset'		=> 'Käyttäjän salasana ##%1## nollaus onnistui',

	'UserApproveInfo'			=> 'Hyväksy uudet käyttäjät ennen kuin he voivat kirjautua sivustolle.',
	'Approve'					=> 'Hyväksy',
	'Deny'						=> 'Estä',
	'Pending'					=> 'Odottaa',
	'Approved'					=> 'Hyväksytty',
	'Denied'					=> 'Estetty',

	// DB Backup module
	'BackupStructure'			=> 'Rakenne',
	'BackupData'				=> 'Tiedot',
	'BackupFolder'				=> 'Kansio',
	'BackupTable'				=> 'Taulukko',
	'BackupCluster'				=> 'Klusteri:',
	'BackupFiles'				=> 'Tiedostot',
	'BackupNote'				=> 'Huomautus:',
	'BackupSettings'			=> 'Määritä haluttu varmuuskopiointiohjelma.<br>' .
    	'Juuriryhmä ei vaikuta varmuuskopioihin ja välimuistitiedostoihin (jos valittu, ne tallennetaan aina kokonaan).<br>' .  '<br>' .
		'<strong>Huomio</strong>: Välttää tietojen menetys tietokannasta määriteltäessä juuriklusteria, tästä varmuuskopiosta peräisin olevia taulukoita ei järjestetä uudelleen, sama kuin kun varmuuskopioidaan vain taulukkorakennetta tallentamatta tietoja. Jotta taulukoiden täydellinen muuntaminen varmuuskopion muotoon, sinun on tehtävä <em> koko tietokannan varmuuskopio (rakenne ja tiedot) määrittelemättä klusteria</em>.',
	'BackupCompleted'			=> 'Varmuuskopiointi ja arkistointi valmistui.<br>' .
    	'Varmuuskopioidut pakettitiedostot on tallennettu alikansioon %1.<br>. Lataa se käyttää FTP (ylläpitää hakemistorakenne ja tiedostonimet kun kopioidaan).<br> Palautaksesi varmuuskopion tai poistaaksesi paketin, mene <a href="%2">Palauta tietokanta</a>.',
	'LogSavedBackup'			=> 'Tallennettu varmuuskopiotietokanta ##%1##',
	'Backup'					=> 'Varmuuskopio',
	'CantReadFile'				=> 'Tiedostoa %1 ei voi lukea.',

	// DB Restore module
	'RestoreInfo'				=> 'Voit palauttaa minkä tahansa löydetyn varmuuskopion paketin tai poistaa sen palvelimelta.',
	'ConfirmDbRestore'			=> 'Haluatko palauttaa varmuuskopion %1?',
	'ConfirmDbRestoreInfo'		=> 'Odota, tämä voi kestää jonkin aikaa.',
	'RestoreWrongVersion'		=> 'Väärä WackoWiki versio!',
	'DirectoryNotExecutable'	=> '%1 -kansio ei ole suoritettavissa.',
	'BackupDelete'				=> 'Oletko varma, että haluat poistaa varmuuskopion %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Muut palautuksen valinnat:',
	'RestoreOptionsInfo'		=> '* Ennen <strong>klusterin varmuuskopion palauttamista</strong>, ' .
									'kohdetaulukoita ei poisteta (jotta estetään tietojen häviäminen klustereista, joita ei ole varmuuskopioitu). ' .
									'Näin ollen palautusprosessin aikana tehdään päällekkäisiä tietueita. ' .
									'Normaalitilassa, ne kaikki korvataan tietueet lomakkeella varmuuskopio (SQL <code>REPLACE</code>), ' .
									'mutta jos tämä valinta on valittuna, kaikki kaksoiskappaleet ohitetaan (nykyiset tietueiden arvot säilytetään), ' .
									'ja vain tietueet uusilla näppäimillä lisätään tauluun (SQL <code>INSERT IGNORE</code>).<br>' .
									'<strong>Huomautus</strong>: Kun palautat sivuston täydellisen varmuuskopion, tällä valinnalla ei ole arvoa.<br>' .
									'<br>' .
									'** Jos varmuuskopio sisältää käyttäjän tiedostot (yleinen ja etusivu, välimuistitiedostot jne.), ' .
									'normaalitilassa ne korvaavat olemassa olevat tiedostot samoilla nimillä ja laitetaan samaan hakemistoon kun ne palautetaan. ' .
									'Tämän vaihtoehdon avulla voit tallentaa nykyiset kopiot tiedostoista ja palauttaa varmuuskopiosta vain uudet tiedostot (puuttuu palvelimelta).',
	'IgnoreDuplicatedKeysNr'	=> 'Ohita päällekkäiset pöytäavaimet (ei korvaa)',
	'IgnoreSameFiles'			=> 'Ohita samat tiedostot (ei ylikirjoiteta)',
	'NoBackupsAvailable'		=> 'Ei varmuuskopioita saatavilla.',
	'BackupEntireSite'			=> 'Koko sivusto',
	'BackupRestored'			=> 'Varmuuskopio on palautettu, yhteenveto raportti on liitetty alla. Voit poistaa tämän varmuuskopion paketin, klikkaa',
	'BackupRemoved'				=> 'Valittu varmuuskopio on onnistuneesti poistettu.',
	'LogRemovedBackup'			=> 'Tietokannan varmuuskopiointi ##%1##',

	'RestoreStarted'			=> 'Alustettu Palautus',
	'RestoreParameters'			=> 'Parametrien käyttö',
	'IgnoreDuplicatedKeys'		=> 'Ohita monistetut avaimet',
	'IgnoreDuplicatedFiles'		=> 'Ohita kopioidut tiedostot',
	'SavedCluster'				=> 'Tallennettu klusteri',
	'DataProtection'			=> 'Tietosuoja - %1 jätetty pois',
	'AssumeDropTable'			=> 'Oletetaan %1',
	'RestoreTableStructure'		=> 'Taulukon rakenteen palauttaminen',
	'RunSqlQueries'				=> 'Suorita SQL-ohjeet:',
	'CompletedSqlQueries'		=> 'Valmis. Käsitellyt ohjeet:',
	'NoTableStructure'			=> 'Taulukoiden rakennetta ei ole tallennettu - ohita',
	'RestoreRecords'			=> 'Palauta taulujen sisältö',
	'ProcessTablesDump'			=> 'Vain ladata ja käsitellä taulun kaatopaikat',
	'Instruction'				=> 'Ohjeet',
	'RestoredRecords'			=> 'tietueita:',
	'RecordsRestoreDone'		=> 'Valmiit. Tietueet yhteensä:',
	'SkippedRecords'			=> 'Tietoja ei tallennettu - ohita',
	'RestoringFiles'			=> 'Palautetaan tiedostoja',
	'DecompressAndStore'		=> 'Hajota ja tallenna hakemistojen sisältö',
	'HomonymicFiles'			=> 'homonyymiset tiedostot',
	'RestoreSkip'				=> 'ohita',
	'RestoreReplace'			=> 'korvaa',
	'RestoreFile'				=> 'Tiedosto:',
	'RestoredFiles'				=> 'palautettu:',
	'SkippedFiles'				=> 'ohitettu:',
	'FileRestoreDone'			=> 'Valmis. Tiedostoja yhteensä:',
	'FilesAll'					=> 'kaikki:',
	'SkipFiles'					=> 'Tiedostoja ei ole tallennettu - ohita',
	'RestoreDone'				=> 'VARASTOINTI TÄYTETTY',

	'BackupCreationDate'		=> 'Luonti Päivämäärä',
	'BackupPackageContents'		=> 'Pakkauksen sisältö on seuraava:',
	'BackupRestore'				=> 'Palauta',
	'BackupRemove'				=> 'Poista',
	'RestoreYes'				=> 'Kyllä',
	'RestoreNo'					=> 'Ei',
	'LogDbRestored'				=> 'Varmuuskopiointi ##%1## tietokannasta palautettu.',

	'BackupArchived'			=> 'Varmuuskopioi %1 arkistoitu.',
	'BackupArchiveExists'		=> 'Varmuuskopioi arkisto %1 on jo olemassa.',
	'LogBackupArchived'			=> 'Varmuuskopiointi ##%1## arkistoitu.',

	// User module
	'UsersInfo'					=> 'Täällä voit muuttaa käyttäjien tietoja ja tiettyjä vaihtoehtoja.',

	'UsersAdded'				=> 'Käyttäjä lisätty',
	'UsersDeleteInfo'			=> 'Poista käyttäjä:',
	'EditButton'				=> 'Muokkaa',
	'UsersAddNew'				=> 'Lisää uusi käyttäjä',
	'UsersDelete'				=> 'Oletko varma, että haluat poistaa käyttäjän %1?',
	'UsersDeleted'				=> 'Käyttäjä %1 poistettiin tietokannasta.',
	'UsersRename'				=> 'Nimeä käyttäjä %1 muotoon',
	'UsersRenameInfo'			=> '* Huomautus: Muutos vaikuttaa kaikkiin sivuihin, jotka on määritetty käyttäjälle.',
	'UsersUpdated'				=> 'Käyttäjä päivitetty onnistuneesti.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Allekirjoitusaika',
	'UserActions'				=> 'Toiminnot',
	'NoMatchingUser'			=> 'Ei käyttäjiä, jotka täyttävät kriteerit',

	'UserAccountNotify'			=> 'Ilmoita käyttäjälle',
	'UserNotifySignup'			=> 'ilmoittaa käyttäjälle uudesta tilistä',
	'UserVerifyEmail'			=> 'aseta sähköpostin vahvistustunnus ja lisää linkki sähköpostin vahvistusta varten',
	'UserReVerifyEmail'			=> 'Lähetä sähköpostin vahvistustunnus uudelleen',

	// Groups module
	'GroupsInfo'				=> 'Tästä paneelista voit hallita kaikkia käyttäjäryhmiäsi. Voit poistaa, luoda ja muokata olemassa olevia ryhmiä. Voit myös valita ryhmän johtajia, vaihtaa avaa/piilotettu/suljettu ryhmän tilaa ja asettaa ryhmän nimen ja kuvauksen.',

	'LogMembersUpdated'			=> 'Käyttäjäryhmän jäsenet päivitetty',
	'LogMemberAdded'			=> 'Lisätty jäsen ##%1## ryhmään ##%2##',
	'LogMemberRemoved'			=> 'Poistettu jäsen ##%1## ryhmästä ##%2##',
	'LogGroupCreated'			=> 'Luotu uusi ryhmä ##%1##',
	'LogGroupRenamed'			=> 'Ryhmä ##%1## nimettiin uudelleen ##%2##',
	'LogGroupRemoved'			=> 'Poistettu ryhmä ##%1##',

	'GroupsMembersFor'			=> 'Ryhmän jäsenet',
	'GroupsDescription'			=> 'Kuvaus',
	'GroupsModerator'			=> 'Moderaattori',
	'GroupsOpen'				=> 'Avaa',
	'GroupsActive'				=> 'Aktiivinen',
	'GroupsTip'					=> 'Klikkaa muokataksesi ryhmää',
	'GroupsUpdated'				=> 'Ryhmät päivitetty',
	'GroupsAlreadyExists'		=> 'Tämä ryhmä on jo olemassa.',
	'GroupsAdded'				=> 'Ryhmä lisätty onnistuneesti.',
	'GroupsRenamed'				=> 'Ryhmä nimettiin uudelleen onnistuneesti.',
	'GroupsDeleted'				=> 'Ryhmä %1 ja kaikki siihen liittyvät sivut poistettiin tietokannasta.',
	'GroupsAdd'					=> 'Lisää uusi ryhmä',
	'GroupsRename'				=> 'Nimeä ryhmä %1 muotoon',
	'GroupsRenameInfo'			=> '* Huomautus: Muutos vaikuttaa kaikkiin sivuihin, jotka on määritetty kyseiseen ryhmään.',
	'GroupsDelete'				=> 'Oletko varma, että haluat poistaa ryhmän %1?',
	'GroupsDeleteInfo'			=> '* Huomautus: Muutos vaikuttaa kaikkiin jäseniin, jotka on määritetty kyseiseen ryhmään.',
	'GroupsIsSystem'			=> 'Ryhmä %1 kuuluu järjestelmään, eikä sitä voi poistaa.',
	'GroupsStoreButton'			=> 'Tallenna Ryhmät',
	'GroupsEditInfo'			=> 'Muokataksesi ryhmien luetteloa valitse radio-painike.',

	'GroupAddMember'			=> 'Lisää jäsen',
	'GroupRemoveMember'			=> 'Poista Jäsen',
	'GroupAddNew'				=> 'Lisää ryhmä',
	'GroupEdit'					=> 'Muokkaa Ryhmää',
	'GroupDelete'				=> 'Poista Ryhmä',

	'MembersAddNew'				=> 'Lisää uusi jäsen',
	'MembersAdded'				=> 'Uusi jäsen lisätty ryhmään onnistuneesti.',
	'MembersRemove'				=> 'Oletko varma, että haluat poistaa jäsenen %1?',
	'MembersRemoved'			=> 'Jäsentä on poistettu ryhmästä.',

	// Statistics module
	'DbStatSection'				=> 'Tietokannan Tilastot',
	'DbTable'					=> 'Taulukko',
	'DbRecords'					=> 'Tietueet',
	'DbSize'					=> 'Koko',
	'DbIndex'					=> 'Indeksi',
	'DbOverhead'				=> 'Ilmapiiri',
	'DbTotal'					=> 'Yhteensä',

	'FileStatSection'			=> 'Tiedostojärjestelmän tilastot',
	'FileFolder'				=> 'Kansio',
	'FileFiles'					=> 'Tiedostot',
	'FileSize'					=> 'Koko',
	'FileTotal'					=> 'Yhteensä',

	// Sysinfo module
	'SysInfo'					=> 'Version tiedot:',
	'SysParameter'				=> 'Parametri',
	'SysValues'					=> 'Arvot',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Viimeisin päivitys',
	'ServerOS'					=> 'Käyttöjärjestelmä',
	'ServerName'				=> 'Palvelimen nimi',
	'WebServer'					=> 'Web-palvelin',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'Sql-Tilat Globaalit',
	'SqlModesSession'			=> 'Sql-Tilan Istunto',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Muisti',
	'UploadFilesizeMax'			=> 'Lataa max tiedostokoko',
	'PostMaxSize'				=> 'Viestin enimmäiskoko',
	'MaxExecutionTime'			=> 'Maksimi suoritusaika',
	'SessionPath'				=> 'Istunnon polku',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip pakkaus',
	'PhpExtensions'				=> 'PHP laajennukset',
	'ApacheModules'				=> 'Apachen moduulit',

	// DB repair module
	'DbRepairSection'			=> 'Korjaa Tietokanta',
	'DbRepair'					=> 'Korjaa Tietokanta',
	'DbRepairInfo'				=> 'Tämä skripti voi automaattisesti etsiä joitakin yhteisiä tietokantaongelmia ja korjata ne. Korjaaminen voi kestää jonkin aikaa, joten ole kärsivällinen.',

	'DbOptimizeRepairSection'	=> 'Korjaa ja optimoi tietokanta',
	'DbOptimizeRepair'			=> 'Korjaa ja optimoi tietokanta',
	'DbOptimizeRepairInfo'		=> 'Tämä skripti voi myös yrittää optimoida tietokantaa. Tämä parantaa suorituskykyä joissakin tilanteissa. Tietokannan korjaus ja optimointi voi kestää kauan, ja tietokanta lukitaan ja optimoidaan.',

	'TableOk'					=> '%1 taulukko on okei.',
	'TableNotOk'				=> '%1 taulukko ei ole kunnossa. Se raportoi seuraavan virheen: %2. Tämä komentosarja yrittää korjata tämän taulukon&hellip;',
	'TableRepaired'				=> '%1 taulukon korjaus onnistui.',
	'TableRepairFailed'			=> '%1 pöydän korjaus epäonnistui. <br>Virhe: %2',
	'TableAlreadyOptimized'		=> '%1 taulukko on jo optimoitu.',
	'TableOptimized'			=> '%1 taulukon optimointi onnistui.',
	'TableOptimizeFailed'		=> '%1 taulukon optimointi epäonnistui. <br>Virhe: %2',
	'TableNotRepaired'			=> 'Joitakin tietokannan ongelmia ei voitu korjata.',
	'RepairsComplete'			=> 'Korjaukset valmis',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Näytä ja korjaa epäjohdonmukaisuuksia, poista tai määritä orvot tietueet uudelle käyttäjälle / arvolle.',
	'Inconsistencies'			=> 'Epäjohdonmukaisuudet',
	'CheckDatabase'				=> 'Tietokanta',
	'CheckDatabaseInfo'			=> 'Tietokannan epäjohdonmukaisuuksien kirjaamista koskevat tarkastukset.',
	'CheckFiles'				=> 'Tiedostot',
	'CheckFilesInfo'			=> 'Valitsee hylätyt tiedostot, tiedostot, joissa ei ole viittausta jäljellä tiedostotaulukossa.',
	'Records'					=> 'Tietueet',
	'InconsistenciesNone'		=> 'Tietojen epäjohdonmukaisuuksia ei löytynyt.',
	'InconsistenciesDone'		=> 'Tietojen epäjohdonmukaisuudet ratkaistu.',
	'InconsistenciesRemoved'	=> 'Poistetut epäjohdonmukaisuudet',
	'Check'						=> 'Tarkista',
	'Solve'						=> 'Ratkaise',

	// Bad Behaviour module
	'BbInfo'					=> 'Havaitsee ja estää ei-toivotut verkkoyhteydet, kieltävät automaattisen spamboottien käytön.<br>Lisätietoja saat %1 kotisivulta.',
	'BbEnable'					=> 'Käytä Huonoa Käyttäytymistä:',
	'BbEnableInfo'				=> 'Kaikki muut asetukset voidaan muuttaa asetuskansiossa %1.',
	'BbStats'					=> 'Bad Behaviour on estänyt %1 pääsyn viimeisen 7 päivän kuluessa.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Loki',
	'BbSettings'				=> 'Asetukset',
	'BbWhitelist'				=> 'Sallitut',

	// --> Log
	'BbHits'					=> 'Osumat',
	'BbRecordsFiltered'			=> 'Näytetään %1 %2 -tietueista suodatettuna',
	'BbStatus'					=> 'Tila',
	'BbBlocked'					=> 'Estetty',
	'BbPermitted'				=> 'Sallittu',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Näyttää kaikki %1 tietueet',
	'BbShow'					=> 'Näytä',
	'BbIpDateStatus'			=> 'Ip/Päiväys/Tila',
	'BbHeaders'					=> 'Otsikot',
	'BbEntity'					=> 'Entiteetti',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Asetukset tallennettu.',
	'BbWhitelistHint'			=> 'Epätarkoituksenmukainen valkoistalisti WILL altistaa sinut roskapostille, tai aiheuttaa Bad Behaviour -toimintoa kokonaan toiminnan lopettamiseksi! ÄLÄ VALKOISTA ellet ole 100% TIETOA että sinun pitäisi.',
	'BbIpAddress'				=> 'Ip Osoite',
	'BbIpAddressInfo'			=> 'IP-osoitteen tai CIDR-formaatin osoitealueet, jotka ovat sallittuja (yksi per rivi)',
	'BbUrl'						=> 'URL-osoite',
	'BbUrlInfo'					=> 'URL fragmentit, jotka alkavat / jälkeen web-sivuston isäntänimi (yksi per rivi)',
	'BbUserAgent'				=> 'Käyttäjän Agentti',
	'BbUserAgentInfo'			=> 'Käyttäjäagenttien merkkijonot, jotka ovat sallittuja (yksi per rivi)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Bad Behaviour -asetukset päivitetty',
	'BbLogRequest'				=> 'Ladataan HTTP-pyyntöä',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normaali (suositeltava)',
	'BbLogOff'					=> 'Älä loki (ei suositeltu)',
	'BbSecurity'				=> 'Turvallisuus',
	'BbStrict'					=> 'Tiukka tarkastus',
	'BbStrictInfo'				=> 'estää enemmän roskapostia, mutta saattaa estää joitakin ihmisiä',
	'BbOffsiteForms'			=> 'Salli lomakkeen lähetykset muilta sivustoilta',
	'BbOffsiteFormsInfo'		=> 'vaaditaan OpenID:lle; lisää vastaanotettua roskapostia',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Käyttääksesi Bad Behaviourin http:BL-ominaisuuksia, sinulla on oltava %1',
	'BbHttpblKey'				=> 'http:Bl- Käyttöavain',
	'BbHttpblThreat'			=> 'Minimi uhka taso (25 suositellaan)',
	'BbHttpblMaxage'			=> 'Tietojen maksimiikä (suositellaan 30 vuotta)',
	'BbReverseProxy'			=> 'Käänteinen Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'Jos käytät Bad Behaviour takana käänteinen välityspalvelin, lataa tasapainotin, HTTP kiihdytin, sisällön välimuisti tai vastaava tekniikka, ota Reverse Proxy vaihtoehto.<br>' .
									'Jos sinulla on ketju, jossa on kaksi tai useampia käänteisiä lähetyksiä välillä palvelimen ja julkisen internetin, sinun on määritettävä <em>kaikki</em> IP-osoitteen alueet (CIDR muodossa) kaikkien välityspalvelinten, kuormituksen tasapainottimet jne. Muussa tapauksessa Bad Behaviour ei ehkä pysty määrittämään asiakkaan todellista IP-osoitetta.<br>' .
									'Lisäksi sinun käänteinen välityspalvelimet on asetettava IP-osoite Internet asiakas, josta he saivat pyynnön HTTP otsikko. Jos et määritä otsikkoa, %1 käytetään. Useimmat välityspalvelimet tukevat jo X-Forwarded-For ja sitten sinun tarvitsee vain varmistaa, että se on käytössä välityspalvelimien. Joitakin muita otsikkonimiä yleisessä käytössä ovat %2 ja %3.',
	'BbReverseProxyEnable'		=> 'Ota Käänteinen Välityspalvelin Käyttöön',
	'BbReverseProxyHeader'		=> 'Otsikko, joka sisältää Internet-asiakkaiden IP-osoitteen',
	'BbReverseProxyAddresses'	=> 'IP-osoite tai CIDR muoto osoitealueet välityspalvelimet (yksi per rivi)',

];
