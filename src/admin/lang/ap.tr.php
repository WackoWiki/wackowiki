<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Temel işlevler',
		'preferences'	=> 'Tercihler',
		'content'		=> 'İçerik',
		'users'			=> 'Kullanıcılar',
		'maintenance'	=> 'Bakım',
		'messages'		=> 'Mesajlar',
		'extension'		=> 'Eklenti',
		'database'		=> 'Veritabanı',
	],

	// Admin panel
	'AdminPanel'				=> 'Yönetim Kontrol Paneli',
	'RecoveryMode'				=> 'Kurtarma Modu',
	'Authorization'				=> 'Yetkilendirme',
	'AuthorizationTip'			=> 'Lütfen yönetici şifresini girin (tarayıcınızda çerezlerin etkin olduğundan emin olun).',
	'NoRecoveryPassword'		=> 'Yönetici şifresi belirtilmemiş!',
	'NoRecoveryPasswordTip'		=> 'Not: Yönetici şifresinin olmaması güvenlik tehdididir! Şifre karmasını yapılandırma dosyasına girin ve programı tekrar çalıştırın.',

	'ErrorLoadingModule'		=> 'Yönetici modülü %1 yüklenirken hata: mevcut değil.',

	'ApHomePage'				=> 'Ana Sayfa',
	'ApHomePageTip'				=> 'Ana sayfayı açar, sistem yönetimini sonlandırmaz',
	'ApLogOut'					=> 'Oturumu kapat',
	'ApLogOutTip'				=> 'Sistem yönetiminden çık',

	'TimeLeft'					=> 'Kalan süre:  %1 dakika',
	'ApVersion'					=> 'sürüm',

	'SiteOpen'					=> 'Aç',
	'SiteOpened'				=> 'site açık',
	'SiteOpenedTip'				=> 'Site açıktır',
	'SiteClose'					=> 'Kapat',
	'SiteClosed'				=> 'site kapalı',
	'SiteClosedTip'				=> 'Site kapalıdır',

	'System'					=> 'Sistem',

	// Generic
	'Cancel'					=> 'İptal',
	'Add'						=> 'Ekle',
	'Edit'						=> 'Düzenle',
	'Remove'					=> 'Kaldır',
	'Enabled'					=> 'Etkin',
	'Disabled'					=> 'Devre dışı',
	'Mandatory'					=> 'Zorunlu',
	'Admin'						=> 'Yönetici',
	'Min'						=> 'Min',
	'Max'						=> 'Maks',

	'MiscellaneousSection'		=> 'Çeşitli',
	'MainSection'				=> 'Genel Seçenekler',

	'DirNotWritable'			=> '%1 dizinine yazılamıyor.',
	'FileNotWritable'			=> '%1 dosyasına yazılamıyor.',

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
		'name'		=> 'Temel',
		'title'		=> 'Temel ayarlar',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Görünüm',
		'title'		=> 'Görünüm ayarları',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-posta',
		'title'		=> 'E-posta ayarları',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Senkronizasyon',
		'title'		=> 'Senkronizasyon ayarları',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtre',
		'title'		=> 'Filtre ayarları',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Biçimlendirici',
		'title'		=> 'Biçimlendirme seçenekleri',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Bildirimler',
		'title'		=> 'Bildirim ayarları',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Sayfalar',
		'title'		=> 'Sayfalar ve site parametreleri',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'İzinler',
		'title'		=> 'İzin ayarları',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Güvenlik',
		'title'		=> 'Güvenlik alt sistemleri ayarları',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Sistem',
		'title'		=> 'Sistem seçenekleri',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Yükleme',
		'title'		=> 'Ek dosya ayarları',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Silinenler',
		'title'		=> 'Yeni silinmiş içerik',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menü',
		'title'		=> 'Varsayılan menü öğelerini ekle, düzenle veya kaldır',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Yedek',
		'title'		=> 'Veri yedekleme',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Onar',
		'title'		=> 'Veritabanını Onar ve Optimize Et',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Geri Yükle',
		'title'		=> 'Yedek verileri geri yükle',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Ana Menü',
		'title'		=> 'WackoWiki Yönetimi',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Tutarsızlıklar',
		'title'		=> 'Veri Tutarsızlıklarını Düzeltme',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Veri Senkronizasyonu',
		'title'		=> 'Verileri senkronize etme',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Toplu e-posta',
		'title'		=> 'Toplu e-posta',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Sistem mesajı',
		'title'		=> 'Sistem mesajları',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Sistem Bilgisi',
		'title'		=> 'Sistem Bilgileri',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Sistem Günlüğü',
		'title'		=> 'Sistem olaylarının günlüğü',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'İstatistikler',
		'title'		=> 'İstatistikleri göster',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Bad Behaviour',
		'title'		=> 'Bad Behaviour',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Onayla',
		'title'		=> 'Kullanıcı kayıt onayı',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Gruplar',
		'title'		=> 'Grup yönetimi',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Kullanıcılar',
		'title'		=> 'Kullanıcı yönetimi',
	],

	// Main module
	'MainNote'					=> 'Not: Yönetim bakımı sırasında siteye erişimi geçici olarak kapatmanız önerilir.',

	'PurgeSessions'				=> 'Temizle',
	'PurgeSessionsTip'			=> 'Tüm oturumları temizle',
	'PurgeSessionsConfirm'		=> 'Tüm oturumları temizlemek istediğinizden emin misiniz? Bu işlem tüm kullanıcıların oturumunu kapatır.',
	'PurgeSessionsExplain'		=> 'Tüm oturumları temizler. Bu, auth_token tablosunu boşaltarak tüm kullanıcıların oturumunu kapatır.',
	'PurgeSessionsDone'			=> 'Oturumlar başarıyla temizlendi.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Temel ayarlar güncellendi',
	'LogBasicSettingsUpdated'	=> 'Temel ayarlar güncellendi',

	'SiteName'					=> 'Site adı:',
	'SiteNameInfo'				=> 'Bu sitenin başlığı. Tarayıcı başlığında, tema üstbilgisinde, e-posta bildirimlerinde vb. görünür.',
	'SiteDesc'					=> 'Site açıklaması:',
	'SiteDescInfo'				=> 'Sayfa başlığında görünen site başlığına ek açıklama. Kısa bir şekilde sitenin amacı anlatılır.',
	'AdminName'					=> 'Sitenin yöneticisi:',
	'AdminNameInfo'				=> 'Sitenin genel desteğinden sorumlu kişinin kullanıcı adı. Bu ad erişim haklarını belirlemek için kullanılmaz, ancak sitenin baş yöneticisinin adıyla uyumlu olması tercih edilir.',

	'LanguageSection'			=> 'Dil',
	'DefaultLanguage'			=> 'Varsayılan dil:',
	'DefaultLanguageInfo'		=> 'Kayıtlı olmayan ziyaretçilere gösterilen mesajların dilini ve yerel ayarları belirler.',
	'MultiLanguage'				=> 'Çokdilli destek:',
	'MultiLanguageInfo'			=> 'Sayfa bazında dil seçme olanağını etkinleştir.',
	'AllowedLanguages'			=> 'İzin verilen diller:',
	'AllowedLanguagesInfo'		=> 'Kullanmak istediğiniz dillerden sadece bir küme seçmeniz önerilir, aksi takdirde tüm diller seçilmiş olur.',

	'CommentSection'			=> 'Yorumlar',
	'AllowComments'				=> 'Yorumlara izin ver:',
	'AllowCommentsInfo'			=> 'Yorumları misafirlere, yalnızca kayıtlı kullanıcılara izin verin veya tüm sitede devre dışı bırakın.',
	'SortingComments'			=> 'Yorum sıralama:',
	'SortingCommentsInfo'		=> 'Sayfa yorumlarının en yeni veya en eski yorumun en üstte olacağı şekilde sıralanmasının varsayılan halini değiştirir.',
	'CommentsOffset'			=> 'Yorum sayfası:',
	'CommentsOffsetInfo'		=> 'Varsayılan olarak gösterilecek yorum sayfa numarası',

	'ToolbarSection'			=> 'Araç Çubuğu',
	'CommentsPanel'				=> 'Yorum paneli:',
	'CommentsPanelInfo'			=> 'Sayfanın altındaki yorumların varsayılan gösterimi.',
	'FilePanel'					=> 'Dosya paneli:',
	'FilePanelInfo'				=> 'Sayfanın altındaki ek dosyaların varsayılan gösterimi.',
	'TagsPanel'					=> 'Etiketler paneli:',
	'TagsPanelInfo'				=> 'Sayfanın altındaki etiketler panelinin varsayılan gösterimi.',

	'NavigationSection'			=> 'Gezinme',
	'ShowPermalink'				=> 'Kalıcı bağlantıyı göster:',
	'ShowPermalinkInfo'			=> 'Mevcut sayfanın sürümü için kalıcı bağlantının varsayılan gösterimi.',
	'TocPanel'					=> 'İçindekiler paneli:',
	'TocPanelInfo'				=> 'Bir sayfanın içindekiler panelinin varsayılan gösterimi (şablonlarda destek gerekebilir).',
	'SectionsPanel'				=> 'Bölümler paneli:',
	'SectionsPanelInfo'			=> 'Varsayılan olarak bitişik sayfalar panelini gösterir (şablonlarda destek gerektirir).',
	'DisplayingSections'		=> 'Bölümlerin gösterimi:',
	'DisplayingSectionsInfo'	=> 'Önceki seçenekler ayarlandığında, yalnızca alt sayfaları (<em>alt</em>), yalnızca komşuları (<em>üst</em>), ikisini birden veya diğerini (<em>ağaç</em>) göstermeyi seçin.',
	'MenuItems'					=> 'Menü öğeleri:',
	'MenuItemsInfo'				=> 'Gösterilen varsayılan menü öğeleri sayısı (şablonlarda destek gerekebilir).',

	'HandlerSection'			=> ' İşleyiciler',
	'HideRevisions'				=> 'Revizyonları gizle:',
	'HideRevisionsInfo'			=> 'Sayfanın revizyonlarının varsayılan gösterimi.',
	'AttachmentHandler'			=> 'Eklenti işleyicisini etkinleştir:',
	'AttachmentHandlerInfo'		=> 'Eklenti işleyicisinin gösterilmesine izin verir.',
	'SourceHandler'				=> 'Kaynak işleyicisini etkinleştir:',
	'SourceHandlerInfo'			=> 'Kaynak işleyicisinin gösterilmesine izin verir.',
	'ExportHandler'				=> 'XML dışa aktarma işleyicisini etkinleştir:',
	'ExportHandlerInfo'			=> 'XML dışa aktarma işleyicisinin gösterilmesine izin verir.',

	'DiffModeSection'			=> 'Fark Modları',
	'DefaultDiffModeSetting'	=> 'Varsayılan fark modu:',
	'DefaultDiffModeSettingInfo'=> 'Önceden seçilmiş fark modu.',
	'AllowedDiffMode'			=> 'İzin verilen fark modları:',
	'AllowedDiffModeInfo'		=> 'Kullanmak istediğiniz fark modlarının yalnızca bir kümesini seçmeniz önerilir, aksi takdirde tüm fark modları seçilmiş olur.',
	'NotifyDiffMode'			=> 'Bildirim fark modu:',
	'NotifyDiffModeInfo'		=> 'E-posta gövdesinde bildirimler için kullanılan fark modu.',

	'EditingSection'			=> 'Düzenleme',
	'EditSummary'				=> 'Düzenleme özeti:',
	'EditSummaryInfo'			=> 'Düzenleme modunda değişiklik özetini gösterir.',
	'MinorEdit'					=> 'Küçük düzenleme:',
	'MinorEditInfo'				=> 'Düzenleme modunda küçük düzenleme seçeneğini etkinleştirir.',
	'SectionEdit'				=> 'Bölüm düzenleme:',
	'SectionEditInfo'			=> 'Sadece bir sayfa bölümünün düzenlenmesine izin verir.',
	'ReviewSettings'			=> 'İnceleme:',
	'ReviewSettingsInfo'		=> 'Düzenleme modunda inceleme seçeneğini etkinleştirir.',
	'PublishAnonymously'		=> 'Anonim yayımlamaya izin ver:',
	'PublishAnonymouslyInfo'	=> 'Kullanıcıların isimlerini gizleyerek anonim yayımlama yapmasına izin ver.',

	'DefaultRenameRedirect'		=> 'Yeniden adlandırırken yönlendirme oluştur:',
	'DefaultRenameRedirectInfo'	=> 'Varsayılan olarak, yeniden adlandırılan sayfanın eski adresine yönlendirme ayarlamayı teklif eder.',
	'StoreDeletedPages'			=> 'Silinen sayfaları sakla:',
	'StoreDeletedPagesInfo'		=> 'Bir sayfayı, yorumu veya dosyayı sildiğinizde, bunları belirli bir süre gözden geçirme ve kurtarma için özel bir bölümde tutar.',
	'KeepDeletedTime'			=> 'Silinen sayfaların saklanma süresi:',
	'KeepDeletedTimeInfo'		=> 'Gün cinsinden süre. Yalnızca önceki seçenek etkinse anlamlıdır. Varlıkların asla silinmemesini istiyorsanız sıfır kullanın (bu durumda yönetici "sepeti" manuel olarak temizleyebilir).',
	'PagesPurgeTime'			=> 'Sayfa revizyonlarının saklanma süresi:',
	'PagesPurgeTimeInfo'		=> 'Belirtilen gün sayısı içinde daha eski sürümleri otomatik olarak siler. Sıfır girerseniz daha eski sürümler kaldırılmaz.',
	'EnableReferrers'			=> 'Yönlendirenleri etkinleştir:',
	'EnableReferrersInfo'		=> 'Dış yönlendirenlerin oluşturulmasına ve gösterilmesine izin verir.',
	'ReferrersPurgeTime'		=> 'Yönlendirenlerin saklanma süresi:',
	'ReferrersPurgeTimeInfo'	=> 'Dış sayfalardan gelen yönlendirme geçmişini belirtilen günden daha uzun süre saklamayın. Yönlendirenlerin asla silinmemesini istiyorsanız sıfır kullanın (ancak yoğun ziyaret edilen bir site için bu veritabanı taşmasına neden olabilir).',
	'EnableCounters'			=> 'Ziyaret Sayacı:',
	'EnableCountersInfo'		=> 'Sayfa başına ziyaret sayaçlarına izin verir ve basit istatistiklerin gösterilmesini etkinleştirir. Sayfa sahibinin görüntülemeleri sayılmaz.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Siteniz için varsayılan web senkronizasyon ayarlarını yönetin.',
	'SyndicationSettingsUpdated'	=> 'Senkronizasyon ayarları güncellendi.',

	'FeedsSection'				=> 'Beslemeler',
	'EnableFeeds'				=> 'Beslemeleri etkinleştir:',
	'EnableFeedsInfo'			=> 'Tüm wiki için RSS beslemelerini açıp kapatır.',
	'XmlChangeLink'				=> 'Değişiklikler besleme bağlantı modu:',
	'XmlChangeLinkInfo'			=> 'XML Değişiklikler beslemesindeki öğelerin nereye bağlantı vereceğini belirler.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'fark görünümü',
		'2'		=> 'düzenlenen sayfa',
		'3'		=> 'revizyon listesi',
		'4'		=> 'mevcut sayfa',
	],

	'XmlSitemap'				=> 'XML site haritası:',
	'XmlSitemapInfo'			=> 'xml klasörünün içinde %1 adlı bir XML dosyası oluşturur. Site haritasının yolunu kök dizininizdeki robots.txt dosyasına şu şekilde ekleyebilirsiniz:',
	'XmlSitemapGz'				=> 'XML site haritası sıkıştırması:',
	'XmlSitemapGzInfo'			=> 'İsterseniz site haritası metin dosyanızı bant genişliği gereksinimini azaltmak için gzip ile sıkıştırabilirsiniz.',
	'XmlSitemapTime'			=> 'XML site haritası oluşturma sıklığı:',
	'XmlSitemapTimeInfo'		=> 'Site haritasını yalnızca verilen gün sayısınca bir kez oluşturur. Her sayfa değişiminde oluşturmak için sıfır olarak ayarlayın.',

	'SearchSection'				=> 'Ara',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'XML klasöründe OpenSearch açıklama dosyası oluşturur ve HTML başlığında arama eklentisinin otomatik keşfini etkinleştirir.',
	'SearchEngineVisibility'	=> 'Arama motorlarını engelle (görünürlük):',
	'SearchEngineVisibilityInfo'=> 'Arama motorlarını engelle, normal ziyaretçilere izin ver. Sayfa ayarlarının üzerine yazar. <br>Arama motorlarını bu siteyi indekslememeye teşvik eder. Bu isteği arama motorlarının uygulayıp uygulamamaları onların takdirindedir.',

	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Siteniz için varsayılan görüntüleme ayarlarını yönetin.',
	'AppearanceSettingsUpdated'	=> 'Görünüm ayarları güncellendi.',

	'LogoOff'					=> 'Kapalı',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo ve başlık',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Site logosu:',
	'SiteLogoInfo'				=> 'Logonuz tipik olarak uygulamanın sol üst köşesinde görünür. Maksimum boyut 2 MiB\'dir. Optimal boyutlar 255 piksel genişlik ve 55 piksel yüksekliktir.',
	'LogoDimensions'			=> 'Logo boyutları:',
	'LogoDimensionsInfo'		=> 'Gösterilen logonun genişlik ve yüksekliği.',
	'LogoDisplayMode'			=> 'Logo gösterim modu:',
	'LogoDisplayModeInfo'		=> 'Logonun görünümünü tanımlar. Varsayılan kapalıdır.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site favicon\'u:',
	'SiteFaviconInfo'			=> 'Kısayol simgeniz veya favicon, çoğu tarayıcının adres çubuğunda, sekmelerde ve yer imlerinde görüntülenir. Bu, temanızın favicon\'unu geçersiz kılacaktır.',
	'SiteFaviconTooBig'			=> 'Favicon 64 × 64 px\'den büyük.',
	'ThemeColor'				=> 'Adres çubuğu için tema rengi:',
	'ThemeColorInfo'			=> 'Tarayıcı, sağlanan CSS rengine göre her sayfanın adres çubuğu rengini ayarlar.',

	'LayoutSection'				=> 'Yerleşim',
	'Theme'						=> 'Tema:',
	'ThemeInfo'					=> 'Sitenin varsayılan olarak kullandığı şablon tasarımı.',
	'ResetUserTheme'			=> 'Tüm kullanıcı temalarını sıfırla:',
	'ResetUserThemeInfo'		=> 'Tüm kullanıcı temalarını sıfırlar. Uyarı: Bu işlem tüm kullanıcıların seçtiği temaları genel varsayılan temaya döndürecektir.',
	'SetBackUserTheme'			=> 'Tüm kullanıcı temalarını %1 temasına geri döndür.',
	'ThemesAllowed'				=> 'İzin verilen Temalar:',
	'ThemesAllowedInfo'			=> 'Kullanıcının seçebileceği izin verilen temaları seçin; aksi takdirde tüm mevcut temalara izin verilir.',
	'ThemesPerPage'				=> 'Sayfa başına tema:',
	'ThemesPerPageInfo'			=> 'Sayfa sahibi tarafından sayfa özellikleri yoluyla seçilebilen tema sayısını izin ver.',

	// System settings
	'SystemSettingsInfo'		=> 'Sitenin ince ayarından sorumlu parametreler grubudur. Ne yaptıklarından emin değilseniz değiştirmeyin.',
	'SystemSettingsUpdated'		=> 'Sistem ayarları güncellendi',

	'DebugModeSection'			=> 'Hata Ayıklama Modu',
	'DebugMode'					=> 'Hata ayıklama modu:',
	'DebugModeInfo'				=> 'Uygulamanın yürütme zamanına ilişkin telemetri verilerinin çıkarılması ve çıktılanması. Dikkat: Tam ayrıntı modu, özellikle veritabanı yedekleme ve geri yükleme gibi kaynak yoğun işlemler için ayrılan belleğe daha yüksek gereksinimler getirir.',
	'DebugModes'	=> [
		'0'		=> 'hata ayıklama kapalı',
		'1'		=> 'sadece toplam yürütme süresi',
		'2'		=> 'tam zaman',
		'3'		=> 'tam ayrıntı (DBMS, önbellek, vb.)',
	],
	'DebugSqlThreshold'			=> 'RDBMS eşik süresi:',
	'DebugSqlThresholdInfo'		=> 'Ayrıntılı hata ayıklama modunda, belirtilen saniyeden daha uzun süren sorguları rapor edin.',
	'DebugAdminOnly'			=> 'Teşhis sadece yöneticiye:',
	'DebugAdminOnlyInfo'		=> 'Programın (ve DBMS) hata ayıklama verilerini yalnızca yöneticiye göster.',

	'CachingSection'			=> 'Önbellekleme Seçenekleri',
	'Cache'						=> 'Render edilmiş sayfaları önbelleğe al:',
	'CacheInfo'					=> 'Render edilmiş sayfaları yerel önbelleğe kaydederek sonraki istekleri hızlandırır. Sadece kaydedilmemiş ziyaretçiler için geçerlidir.',
	'CacheTtl'					=> 'Önbellekteki sayfaların yaşama süresi:',
	'CacheTtlInfo'				=> 'Sayfaları belirtilen saniye sayısından daha uzun süre önbellekte tutmayın.',
	'CacheSql'					=> 'DBMS sorgularını önbelleğe al:',
	'CacheSqlInfo'				=> 'Belirli kaynakla ilgili SQL sorgularının sonuçlarını yerel önbellekte tutun.',
	'CacheSqlTtl'				=> 'Önbelleğe alınan SQL sorgularının yaşama süresi:',
	'CacheSqlTtlInfo'			=> 'SQL sorgularının sonuçlarını belirtilen saniyeden daha uzun önbelleğe almayın. 1200\'den büyük değerler önerilmez.',

	'LogSection'				=> 'Günlük Ayarları',
	'LogLevelUsage'				=> 'Günlüğü kullan:',
	'LogLevelUsageInfo'			=> 'Günlükte kaydedilecek olayların minimum önceliği.',
	'LogThresholds'	=> [
		'0'		=> 'günlük tutulmasın',
		'1'		=> 'sadece kritik seviye',
		'2'		=> 'en yüksek seviyeden itibaren',
		'3'		=> 'yüksekten itibaren',
		'4'		=> 'orta seviye',
		'5'		=> 'düşükten itibaren',
		'6'		=> 'minimum seviye',
		'7'		=> 'tümünü kaydet',
	],
	'LogDefaultShow'			=> 'Günlük görüntüleme modu:',
	'LogDefaultShowInfo'		=> 'Varsayılan olarak günlükte gösterilen minimum öncelikli olaylar.',
	'LogModes'	=> [
		'1'		=> 'sadece kritik seviye',
		'2'		=> 'en yüksek seviyeden itibaren',
		'3'		=> 'yüksek seviyeden itibaren',
		'4'		=> 'orta seviye',
		'5'		=> 'düşükten itibaren',
		'6'		=> 'minimum seviyeden itibaren',
		'7'		=> 'tümünü göster',
	],
	'LogPurgeTime'				=> 'Günlük saklama süresi:',
	'LogPurgeTimeInfo'			=> 'Olay günlüğünü belirtilen gün sayısından sonra kaldır.',

	'PrivacySection'			=> 'Gizlilik',
	'AnonymizeIp'				=> 'Kullanıcıların IP adreslerini anonimleştir:',
	'AnonymizeIpInfo'			=> 'Uygulanabildiği yerlerde IP adreslerini anonimleştir (ör. sayfa, revizyon veya yönlendirenlerde).',

	'ReverseProxySection'		=> 'Ters Proxy',
	'ReverseProxy'				=> 'Ters proxy kullan:',
	'ReverseProxyInfo'			=> 'Uzak istemcinin doğru IP adresini belirlemek için X-Forwarded-For başlıklarında saklanan bilgileri incelemek üzere bu ayarı etkinleştirin. X-Forwarded-For başlıkları, Squid veya Pound gibi ters proxy sunucusu üzerinden bağlanan istemci sistemlerini tanımlamak için standart bir mekanizmadır. Ters proxy sunucuları yoğun trafikli sitelerde performansı artırmak, önbellekleme, güvenlik veya şifreleme avantajları sağlamak için kullanılabilir. Bu WackoWiki kurulumunun bir ters proxy arkasında çalışması durumunda, oturum yönetimi, günlükleme, istatistik ve erişim yönetimi sistemlerinde doğru IP bilgisi yakalanması için bu ayar etkinleştirilmelidir; bu ayarda emin değilseniz, ters proxy kullanmıyorsanız veya WackoWiki paylaşımlı bir barındırma ortamında çalışıyorsa, bu ayar devre dışı bırakılmalıdır.',
	'ReverseProxyHeader'		=> 'Ters proxy başlığı:',
	'ReverseProxyHeaderInfo'	=> 'Proxy sunucunuz istemci IP\'sini X-Forwarded-For dışındaki bir başlıkta gönderiyorsa bu değeri ayarlayın. "X-Forwarded-For" başlığı virgülle ayrılmış bir IP adresleri listesi içerir; yalnızca sonuncusu (soldaki) kullanılacaktır.',
	'ReverseProxyAddresses'		=> 'reverse_proxy bir IP adresleri dizisini kabul eder:',
	'ReverseProxyAddressesInfo'	=> 'Bu dizinin her bir öğesi ters proxy\'lerinizden herhangi birinin IP adresidir. Bu dizi kullanıldığında, Remote IP adresi bu adreslerden biri ise WackoWiki sadece X-Forwarded-For başlıklarında saklanan bilgiyi güvenilir kabul eder; aksi takdirde istemci, X-Forwarded-For başlıklarını sahteleyerek doğrudan web sunucunuza bağlanabilir.',

	'SessionSection'				=> 'Oturum Yönetimi',
	'SessionStorage'				=> 'Oturum depolama:',
	'SessionStorageInfo'			=> 'Bu seçenek oturum verilerinin nerede saklandığını tanımlar. Varsayılan olarak dosya veya veritabanı oturum depolaması seçilidir.',
	'SessionModes'	=> [
		'1'		=> 'Dosya',
		'2'		=> 'Veritabanı',
	],
	'SessionNotice'					=> 'Oturum sonlandırma bildirimi:',
	'SessionNoticeInfo'				=> 'Oturum sonlandırmanın nedenini belirtir.',
	'LoginNotice'					=> 'Giriş bildirimi:',
	'LoginNoticeInfo'				=> 'Giriş bildirimini gösterir.',

	'RewriteMode'					=> '<code>mod_rewrite</code> kullan:',
	'RewriteModeInfo'				=> 'Web sunucunuz bu özelliği destekliyorsa, sayfa URL\'lerini "güzel" hale getirmek için etkinleştirin.<br>
										<span class="cite">Bu değer, HTTP_MOD_REWRITE açıksa çalışma zamanında Settings sınıfı tarafından kapalı olsa bile üzerine yazılabilir.</span>',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Erişim kontrolü ve izinlerden sorumlu parametreler.',
	'PermissionsSettingsUpdated'	=> 'İzin ayarları güncellendi',

	'PermissionsSection'		=> 'Haklar ve Yetkiler',
	'ReadRights'				=> 'Okuma hakları varsayılan:',
	'ReadRightsInfo'			=> 'Oluşturulan kök sayfalara ve üst ACL\'leri tanımlanamayan sayfalara varsayılan olarak atanır.',
	'WriteRights'				=> 'Yazma hakları varsayılan:',
	'WriteRightsInfo'			=> 'Oluşturulan kök sayfalara ve üst ACL\'leri tanımlanamayan sayfalara varsayılan olarak atanır.',
	'CommentRights'				=> 'Yorum hakları varsayılan:',
	'CommentRightsInfo'			=> 'Oluşturulan kök sayfalara ve üst ACL\'leri tanımlanamayan sayfalara varsayılan olarak atanır.',
	'CreateRights'				=> 'Alt sayfa oluşturma hakları varsayılan:',
	'CreateRightsInfo'			=> 'Oluşturulan alt sayfalara varsayılan olarak atanır.',
	'UploadRights'				=> 'Yükleme hakları varsayılan:',
	'UploadRightsInfo'			=> 'Varsayılan yükleme hakları.',
	'RenameRights'				=> 'Genel yeniden adlandırma hakkı:',
	'RenameRightsInfo'			=> 'Sayfaları serbestçe yeniden adlandırma (taşıma) izni listesi.',

	'LockAcl'					=> 'Tüm ACL\'leri yalnızca okunur kilitle:',
	'LockAclInfo'				=> '<span class="cite">Tüm sayfaların ACL ayarlarını yalnızca okunur olarak üzerine yazar.</span><br>Bu, bir proje bittiyse, güvenlik nedenleriyle düzenlemeyi geçici olarak kapatmak istediğinizde veya bir açık/istismara acil yanıt olarak yararlı olabilir.',
	'HideLocked'				=> 'Erişilemeyen sayfaları gizle:',
	'HideLockedInfo'			=> 'Kullanıcının sayfayı okuma izni yoksa, farklı sayfa listelerinde gizle (metne yerleştirilen bağlantı yine de görünür olacaktır).',
	'RemoveOnlyAdmins'			=> 'Sadece yöneticiler sayfaları silebilir:',
	'RemoveOnlyAdminsInfo'		=> 'Yöneticiler dışında herkesten sayfa silme yetkisini engelle. İlk sınırlama normal sayfa sahiplerine uygulanır.',
	'OwnersRemoveComments'		=> 'Sayfa sahipleri yorumları silebilir:',
	'OwnersRemoveCommentsInfo'	=> 'Sayfa sahiplerinin kendi sayfalarındaki yorumları yönetmesine izin ver.',
	'OwnersEditCategories'		=> 'Sahipler sayfa kategorilerini düzenleyebilir:',
	'OwnersEditCategoriesInfo'	=> 'Sahiplerin bir sayfaya atanan kategori listesini (kelime ekleme, silme) değiştirmesine izin ver.',
	'TermHumanModeration'		=> 'İnsan moderasyon süresi:',
	'TermHumanModerationInfo'	=> 'Moderatörler yalnızca belirtilen gün sayısından daha eski olmayan yorumları düzenleyebilir (bu sınırlama konu içindeki son yoruma uygulanmaz).',

	'UserCanDeleteAccount'		=> 'Kullanıcıların hesaplarını silmesine izin ver',

	// Security settings
	'SecuritySettingsInfo'		=> 'Platformun genel güvenliğinden, güvenlik sınırlamalarından ve ek güvenlik alt sistemlerinden sorumlu parametreler.',
	'SecuritySettingsUpdated'	=> 'Güvenlik ayarları güncellendi',

	'AllowRegistration'			=> 'Çevrimiçi kayıt izni:',
	'AllowRegistrationInfo'		=> 'Açık kullanıcı kaydını etkinleştir. Bu seçeneği devre dışı bırakmak ücretsiz kaydı engeller, ancak site yöneticisi yine de kullanıcı kaydedebilir.',
	'ApproveNewUser'			=> 'Yeni kullanıcıları onayla:',
	'ApproveNewUserInfo'		=> 'Yönetici kayıt olduktan sonra kullanıcıları onaylayabilir. Yalnızca onaylanan kullanıcılar siteye giriş yapabilir.',
	'PersistentCookies'			=> 'Kalıcı çerezler:',
	'PersistentCookiesInfo'		=> 'Kalıcı çerezlere izin ver.',
	'DisableWikiName'			=> 'WikiName zorunluluğunu devre dışı bırak:',
	'DisableWikiNameInfo'		=> 'Kullanıcılar için WikiName zorunluluğunu devre dışı bırakır. Zorunlu CamelCase biçimli adlar yerine geleneksel takma adlarla kayıt yapılmasına izin verir.',
	'UsernameLength'			=> 'Kullanıcı adı uzunluğu:',
	'UsernameLengthInfo'		=> 'Kullanıcı adlarındaki minimum ve maksimum karakter sayısı.',

	'EmailSection'				=> 'E-posta',
	'AllowEmailReuse'			=> 'E-posta adresinin yeniden kullanımına izin ver:',
	'AllowEmailReuseInfo'		=> 'Farklı kullanıcıların aynı e-posta adresiyle kayıt olmasına izin ver.',
	'EmailConfirmation'			=> 'E-posta onayı zorunlu kıl:',
	'EmailConfirmationInfo'		=> 'Kullanıcının giriş yapabilmesi için e-posta adresini doğrulamasını gerektirir.',
	'AllowedEmailDomains'		=> 'İzin verilen e-posta alanları:',
	'AllowedEmailDomainsInfo'	=> 'Virgülle ayrılmış e-posta alanları, örn. <code>example.com, local.lan</code> vb. Belirtilmezse tüm e-posta alanlarına izin verilir.',
	'ForbiddenEmailDomains'		=> 'Yasaklanmış e-posta alanları:',
	'ForbiddenEmailDomainsInfo'	=> 'Virgülle ayrılmış yasaklı e-posta alanları, örn. <code>example.com, local.lan</code> vb. Yalnızca izin verilen e-posta alanları listesi boşsa etkilidir.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Captcha\'yı etkinleştir:',
	'EnableCaptchaInfo'			=> 'Etkinleştirilirse, captcha aşağıdaki durumlarda veya bir güvenlik eşiğine ulaşıldığında gösterilir.',
	'CaptchaComment'			=> 'Yeni yorum:',
	'CaptchaCommentInfo'		=> 'Spam koruması için, kayıtlı olmayan kullanıcıların yorum göndermeden önce captcha\'yı tamamlaması gerekir.',
	'CaptchaPage'				=> 'Yeni sayfa:',
	'CaptchaPageInfo'			=> 'Spam koruması için, kayıtlı olmayan kullanıcıların yeni sayfa oluşturmadan önce captcha\'yı tamamlaması gerekir.',
	'CaptchaEdit'				=> 'Sayfa düzenleme:',
	'CaptchaEditInfo'			=> 'Spam koruması için, kayıtlı olmayan kullanıcıların sayfa düzenlemeden önce captcha\'yı tamamlaması gerekir.',
	'CaptchaRegistration'		=> 'Kayıt:',
	'CaptchaRegistrationInfo'	=> 'Spam koruması için, kayıtlı olmayan kullanıcıların kayıt olmadan önce captcha\'yı tamamlaması gerekir.',

	'TlsSection'				=> 'TLS Ayarları',
	'TlsConnection'				=> 'TLS bağlantısı:',
	'TlsConnectionInfo'			=> 'TLS güvenli bağlantısı kullanın. <span class="cite">Sunucuda gerekli önceden yüklenmiş TLS sertifikasını etkinleştirin, aksi takdirde yönetici paneline erişimi kaybedersiniz!</span><br>Bu ayrıca Cookie Secure Bayrağını belirleyip belirlemeyeceğini etkiler: <code>secure</code> bayrağı çerezlerin yalnızca güvenli bağlantılar üzerinden gönderilip gönderilmeyeceğini belirtir.',
	'TlsImplicit'				=> 'Zorunlu TLS:',
	'TlsImplicitInfo'			=> 'İstemciyi HTTP\'den HTTPS\'e zorunlu olarak yeniden yönlendirir. Seçenek devre dışıysa istemci açık HTTP kanalı üzerinden siteyi gezebilir.',

	'HttpSecurityHeaders'		=> 'HTTP Güvenlik Başlıkları',
	'EnableSecurityHeaders'		=> 'Güvenlik başlıklarını etkinleştir:',
	'EnableSecurityHeadersinfo'	=> 'Güvenlik başlıklarını ayarla (frame kırma, clickjacking/XSS/CSRF koruması). <br>CSP bazı durumlarda (örn. geliştirme sırasında) veya dış kaynaklı resim veya betik gibi kaynaklara dayanan eklentiler kullanıldığında sorunlara neden olabilir. <br>İçerik Güvenliği Politikasını devre dışı bırakmak güvenlik riski oluşturur!',
	'Csp'						=> 'İçerik güvenlik politikası (CSP):',
	'CspInfo'					=> 'CSP yapılandırması hangi politikaları uygulamak istediğinize karar vermeyi ve ardından bunları yapılandırmayı içerir; Content-Security-Policy başlığını kullanarak politikanızı belirleyin.',
	'PolicyModes'	=> [
		'0'		=> 'devre dışı',
		'1'		=> 'katı',
		'2'		=> 'özel',
	],
	'PermissionsPolicy'			=> 'İzin politikası:',
	'PermissionsPolicyInfo'		=> 'HTTP Permissions-Policy başlığı çeşitli güçlü tarayıcı özelliklerini açıkça etkinleştirme veya devre dışı bırakma mekanizması sağlar.',
	'ReferrerPolicy'			=> 'Yönlendiren politikası:',
	'ReferrerPolicyInfo'		=> 'Referrer-Policy HTTP başlığı, Referer başlığında gönderilen hangi yönlendirici bilgisinin yanıtlarla birlikte dahil edileceğini belirler.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[kapalı]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> 'Kullanıcı Parolalarının Sürekliliği',
	'PwdMinChars'				=> 'Minimum parola uzunluğu:',
	'PwdMinCharsInfo'			=> 'Daha uzun parolalar genellikle daha güvenlidir (örn. 12 ila 16 karakter).<br>Parola yerine parola cümleleri (passphrase) kullanılması teşvik edilir.',
	'AdminPwdMinChars'			=> 'Minimum yönetici parola uzunluğu:',
	'AdminPwdMinCharsInfo'		=> 'Daha uzun parolalar genellikle daha güvenlidir (örn. 15 ila 20 karakter).<br>Parola yerine parola cümleleri (passphrase) kullanılması teşvik edilir.',
	'PwdCharComplexity'			=> 'Gerekli parola karmaşıklığı:',
	'PwdCharClasses'	=> [
		'0'		=> 'test edilmedi',
		'1'		=> 'herhangi harf + rakam',
		'2'		=> 'büyük ve küçük harf + rakam',
		'3'		=> 'büyük ve küçük harf + rakam + özel karakterler',
	],
	'PwdUnlikeLogin'			=> 'Ek karmaşıklık:',
	'PwdUnlikes'	=> [
		'0'		=> 'test edilmedi',
		'1'		=> 'parola girişle aynı değil',
		'2'		=> 'parola kullanıcı adını içermiyor',
	],

	'LoginSection'				=> 'Giriş',
	'MaxLoginAttempts'			=> 'Kullanıcı adı başına maksimum giriş denemesi sayısı:',
	'MaxLoginAttemptsInfo'		=> 'Bir hesap için anti-spambot görevi tetiklenmeden önce izin verilen giriş denemesi sayısı. Farklı kullanıcı hesapları için anti-spambot görevini engellemek için 0 girin.',
	'IpLoginLimitMax'			=> 'IP adresi başına maksimum giriş denemesi sayısı:',
	'IpLoginLimitMaxInfo'		=> 'Bir IP adresinden izin verilen giriş denemeleri eşiği. Anti-spambot görevinin IP adresleri tarafından tetiklenmesini engellemek için 0 girin.',

	'FormsSection'				=> 'Formlar',
	'FormTokenTime'				=> 'Formları göndermek için maks. süre:',
	'FormTokenTimeInfo'			=> 'Bir kullanıcının bir formu göndermek için sahip olduğu süre (saniye cinsinden).<br>Oturum süresi dolarsa form bu ayardan bağımsız olarak geçersiz hale gelebilir.',

	'SessionLength'				=> 'Oturum çerezi süresi:',
	'SessionLengthInfo'			=> 'Kullanıcı oturum çerezinin varsayılan ömrü (gün cinsinden).',
	'CommentDelay'				=> 'Yorumlar için anti-flood:',
	'CommentDelayInfo'			=> 'Yeni kullanıcı yorumları yayınlama arasındaki minimum gecikme (saniye cinsinden).',
	'IntercomDelay'				=> 'Özel iletişimler için anti-flood:',
	'IntercomDelayInfo'			=> 'Özel mesaj gönderimleri arasındaki minimum gecikme (saniye cinsinden).',
	'RegistrationDelay'			=> 'Kayıt için zaman eşiği:',
	'RegistrationDelayInfo'		=> 'Kayıt formunun doldurulması için botları insanlardan ayırt etmek amacıyla minimum zaman eşiği (saniye cinsinden).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Sitenin ince ayarından sorumlu parametreler grubudur. Ne yaptıklarından emin değilseniz değiştirmeyin.',
	'FormatterSettingsUpdated'	=> 'Biçimlendirme ayarları güncellendi',

	'TextHandlerSection'		=> 'Metin İşleyicisi:',
	'Typografica'				=> 'Yazım düzeltici:',
	'TypograficaInfo'			=> 'Bu seçenek devre dışı bırakılırsa, yorum ekleme ve sayfa kaydetme işlemleri hızlanır.',
	'Paragrafica'				=> 'Paragraf işaretlemeleri:',
	'ParagraficaInfo'			=> 'Önceki seçeneğe benzer; ancak otomatik içindekiler tablosunun (<code>{{toc}}</code>) çalışmasını etkileyebilir.',
	'AllowRawhtml'				=> 'Genel HTML desteği:',
	'AllowRawhtmlInfo'			=> 'Bu seçenek açık bir site için potansiyel olarak güvensizdir.',
	'SafeHtml'					=> 'HTML filtreleme:',
	'SafeHtmlInfo'				=> 'Tehlikeli HTML öğelerinin kaydedilmesini engeller. HTML desteği olan açık bir sitede filtreyi kapatmak <span class="underline">aşırı derecede</span> istenmeyendir!',

	'WackoFormatterSection'		=> 'Wiki Metin Biçimlendirici (Wacko Formatter)',
	'X11colors'					=> 'X11 renkleri kullanımı:',
	'X11colorsInfo'				=> '<code>??(color) background??</code> ve <code>!!(color) text!!</code> için kullanılabilecek renkleri genişletir. Bu seçeneği devre dışı bırakmak yorum ekleme ve sayfa kaydetme işlemlerini hızlandırır.',
	'WikiLinks'					=> 'Wiki bağlantılarını devre dışı bırak:',
	'WikiLinksInfo'				=> '<code>CamelCaseWords</code> için bağlantı oluşturulmasını devre dışı bırakır: CamelCase sözcükleriniz doğrudan yeni bir sayfaya bağlanmaz. Farklı ad alanları/kümelerle çalışırken faydalıdır. Varsayılan olarak kapalıdır.',
	'BracketsLinks'				=> 'Köşeli parantezli bağlantıları devre dışı bırak:',
	'BracketsLinksInfo'			=> '<code>[[link]]</code> ve <code>((link))</code> söz dizimini devre dışı bırakır.',
	'Formatters'				=> 'Biçimlendiricileri devre dışı bırak:',
	'FormattersInfo'			=> '<code>%%code%%</code> söz dizimi ile kullanılan vurgulayıcıları devre dışı bırakır.',

	'DateFormatsSection'		=> 'Tarih Formatları',
	'DateFormat'				=> 'Tarih biçimi:',
	'DateFormatInfo'			=> '(gün, ay, yıl)',
	'TimeFormat'				=> 'Saat biçimi:',
	'TimeFormatInfo'			=> '(saat, dakika)',
	'TimeFormatSeconds'			=> 'Kesin zaman biçimi:',
	'TimeFormatSecondsInfo'		=> '(saat, dakika, saniye)',
	'NameDateMacro'				=> '<code>::@::</code> makrosunun biçimi:',
	'NameDateMacroInfo'			=> '(isim, zaman), örn. <code>KullaniciAdi (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Zaman dilimi:',
	'TimezoneInfo'				=> 'Giriş yapmamış kullanıcılara (misafirler) zamanları görüntülemek için kullanılacak zaman dilimi. Giriş yapmış kullanıcılar kullanıcı ayarlarında zaman dilimini değiştirebilir.',
	'AmericanDate'					=> 'Amerikan tarihi:',
	'AmericanDateInfo'				=> 'İngilizce için varsayılan olarak Amerikan tarih formatını kullanır.',

	'Canonical'					=> 'Tam kanonik URL\'leri kullan:',
	'CanonicalInfo'				=> 'Tüm bağlantılar %1 biçiminde mutlak URL olarak oluşturulur. Sunucu köküne göreli URL\'ler %2 biçiminde tercih edilmelidir.',
	'LinkTarget'				=> 'Dış bağlantıların açılacağı yer:',
	'LinkTargetInfo'			=> 'Her dış bağlantıyı yeni bir tarayıcı penceresinde açar. Bağlantı sözdizimine <code>target="_blank"</code> ekler.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Kullanıcı hiperbağlantıyı takip ederse tarayıcının HTTP referer başlığı göndermemesi gerektiğini zorunlu kılar. Bağlantı sözdizimine <code>rel="noreferrer"</code> ekler.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Arama motorlarına, hiperlinklerin hedef sayfanın arama motoru dizinindeki sayfa sıralamasını etkilememesi gerektiğini bildirir. Bağlantı sözdizimine <code>rel="nofollow"</code> ekler.',
	'UrlsUnderscores'			=> 'Adresleri (URL) alt çizgiyle oluştur:',
	'UrlsUnderscoresInfo'		=> 'Örneğin, bu seçenekle %1, %2 haline gelir.',
	'ShowSpaces'				=> 'WikiAdlarındaki boşlukları göster:',
	'ShowSpacesInfo'			=> 'WikiAdlarındaki boşlukları gösterir; örn. <code>MyName</code> bu seçenekle <code>My Name</code> şeklinde görüntülenir.',
	'NumerateLinks'				=> 'Yazdırma görünümünde bağlantıları numaralandır:',
	'NumerateLinksInfo'			=> 'Bu seçenek ile yazdırma görünümünde tüm bağlantıları altta numaralandırır ve listeler.',
	'YouareHereText'			=> 'Kendine referans veren bağlantıları devre dışı bırak ve görselleştir:',
	'YouareHereTextInfo'		=> 'Aynı sayfaya olan bağlantıları <code>&lt;b&gt;####&lt;/b&gt;</code> ile görselleştirir. Kendine olan tüm bağlantılar bağlantı biçimlendirmesini kaybeder, ancak kalın metin olarak gösterilir.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Buradan Wiki içinde kullanılan sistem temel sayfalarını ayarlayabilir veya değiştirebilirsiniz. Lütfen burada yaptığınız ayarlara uygun olarak ilgili sayfaları Wikide oluşturmayı veya değiştirmeyi unutmayın.',
	'PagesSettingsUpdated'		=> 'Temel sayfa ayarları güncellendi',

	'ListCount'					=> 'Liste başına öğe sayısı:',
	'ListCountInfo'				=> 'Her liste sayfasında ziyaretçi için gösterilecek öğe sayısı veya yeni kullanıcılar için varsayılan değer.',

	'ForumSection'				=> 'Forum Seçenekleri',
	'ForumCluster'				=> 'Forum kümesi:',
	'ForumClusterInfo'			=> 'Forum bölümü için kök küme (action %1).',
	'ForumTopics'				=> 'Sayfa başına konu sayısı:',
	'ForumTopicsInfo'			=> 'Forum bölümlerinin liste sayfasında (action %1) her sayfada gösterilecek konu sayısı.',
	'CommentsCount'				=> 'Sayfa başına yorum sayısı:',
	'CommentsCountInfo'			=> 'Her sayfanın yorum listesinde gösterilecek yorum sayısı. Bu tüm sitedeki yorumlar için geçerlidir, sadece forumda yapılanlarla sınırlı değildir.',

	'NewsSection'				=> 'Haber Bölümü',
	'NewsCluster'				=> 'Haberler için küme:',
	'NewsClusterInfo'			=> 'Haber bölümü için kök küme (action %1).',
	'NewsStructure'				=> 'Haber kümesi yapısı:',
	'NewsStructureInfo'			=> 'Makaleleri isteğe bağlı olarak yıl/ay veya hafta alt-kümelerinde saklar (örn. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Lisans',
	'DefaultLicense'			=> 'Varsayılan lisans:',
	'DefaultLicenseInfo'		=> 'İçeriğinizin hangi lisans altında yayınlanabileceği.',
	'EnableLicense'				=> 'Lisansı etkinleştir:',
	'EnableLicenseInfo'			=> 'Lisans bilgilerini göstermek için etkinleştirin.',
	'LicensePerPage'			=> 'Sayfa başına lisans:',
	'LicensePerPageInfo'		=> 'Sayfa sahibi tarafından sayfa özellikleri aracılığıyla seçilebilecek sayfa başına lisansa izin ver.',

	'ServicePagesSection'		=> 'Servis Sayfaları',
	'RootPage'					=> 'Ana sayfa:',
	'RootPageInfo'				=> 'Ana sayfanızın etiketi; bir kullanıcı sitenizi ziyaret ettiğinde otomatik olarak açılır.',

	'PrivacyPage'				=> 'Gizlilik politikası:',
	'PrivacyPageInfo'			=> 'Sitenin Gizlilik Politikası sayfası.',

	'TermsPage'					=> 'Politikalar ve düzenlemeler:',
	'TermsPageInfo'				=> 'Sitenin kurallarını içeren sayfa.',

	'SearchPage'				=> 'Arama:',
	'SearchPageInfo'			=> 'Arama formunun bulunduğu sayfa (action %1).',
	'RegistrationPage'			=> 'Kayıt:',
	'RegistrationPageInfo'		=> 'Yeni kullanıcı kayıt sayfası (action %1).',
	'LoginPage'					=> 'Kullanıcı girişi:',
	'LoginPageInfo'				=> 'Sitedeki giriş sayfası (action %1).',
	'SettingsPage'				=> 'Kullanıcı Ayarları:',
	'SettingsPageInfo'			=> 'Kullanıcı profilini özelleştirmek için sayfa (action %1).',
	'PasswordPage'				=> 'Parolayı Değiştir:',
	'PasswordPageInfo'			=> 'Kullanıcı parolasını değiştirmek/sorgulamak için form içeren sayfa (action %1).',
	'UsersPage'					=> 'Kullanıcı listesi:',
	'UsersPageInfo'				=> 'Kayıtlı kullanıcıların listesinin bulunduğu sayfa (action %1).',
	'CategoryPage'				=> 'Kategori:',
	'CategoryPageInfo'			=> 'Kategorize edilmiş sayfaların listesinin bulunduğu sayfa (action %1).',
	'GroupsPage'				=> 'Gruplar:',
	'GroupsPageInfo'			=> 'Çalışma gruplarının listesinin bulunduğu sayfa (action %1).',
	'WhatsNewPage'				=> 'Yeni neler:',
	'WhatsNewPageInfo'			=> 'Tüm yeni, silinmiş veya değiştirilmiş sayfaların, yeni eklerin ve yorumların listesini içeren sayfa. (action %1).',
	'ChangesPage'				=> 'Son değişiklikler:',
	'ChangesPageInfo'			=> 'Son değiştirilen sayfaların listesinin bulunduğu sayfa (action %1).',
	'CommentsPage'				=> 'Son yorumlar:',
	'CommentsPageInfo'			=> 'Sayfadaki son yorumların listesinin bulunduğu sayfa (action %1).',
	'RemovalsPage'				=> 'Silinmiş sayfalar:',
	'RemovalsPageInfo'			=> 'Yakın zamanda silinmiş sayfaların listesinin bulunduğu sayfa (action %1).',
	'WantedPage'				=> 'İstenen sayfalar:',
	'WantedPageInfo'			=> 'Referans verilmiş fakat eksik olan sayfaların listesinin bulunduğu sayfa (action %1).',
	'OrphanedPage'				=> 'Yetim sayfalar:',
	'OrphanedPageInfo'			=> 'Mevcut fakat başka hiçbir sayfa ile bağlantılı olmayan sayfaların listesinin bulunduğu sayfa (action %1).',
	'SandboxPage'				=> 'Deneme alanı:',
	'SandboxPageInfo'			=> 'Kullanıcıların wiki biçimlendirme becerilerini denemesi için sayfa.',
	'HelpPage'					=> 'Yardım:',
	'HelpPageInfo'				=> 'Site araçlarıyla çalışmak için belgeler bölümü.',
	'IndexPage'					=> 'İndeks:',
	'IndexPageInfo'				=> 'Tüm sayfaların listesinin bulunduğu sayfa (action %1).',
	'RandomPage'				=> 'Rastgele:',
	'RandomPageInfo'			=> 'Rastgele bir sayfa yükler (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Platform bildirimleri için parametreler.',
	'NotificationSettingsUpdated'	=> 'Bildirim ayarları güncellendi',

	'EmailNotification'			=> 'E-posta bildirimi:',
	'EmailNotificationInfo'		=> 'E-posta bildirimine izin ver. Etkinleştirildiğinde e-posta bildirimleri açılır, Devre Dışı yapıldığında kapatılır. Not: e-posta bildirimlerini devre dışı bırakmak, kullanıcı kaydı sürecinin bir parçası olarak oluşturulan e-postaları etkilemez.',
	'Autosubscribe'				=> 'Otomatik abone olma:',
	'AutosubscribeInfo'			=> 'Sayfa değişikliklerinde otomatik olarak sayfa sahibini bilgilendir.',

	'NotificationSection'		=> 'Varsayılan Kullanıcı Bildirim Ayarları',
	'NotifyPageEdit'			=> 'Sayfa düzenleme bildirimleri:',
	'NotifyPageEditInfo'		=> 'Beklemede - Kullanıcı sayfayı tekrar ziyaret edene kadar yalnızca ilk değişiklik için e-posta bildirimi gönder.',
	'NotifyMinorEdit'			=> 'Küçük düzenlemeyi bildir:',
	'NotifyMinorEditInfo'		=> 'Küçük düzenlemeler için de bildirim gönderir.',
	'NotifyNewComment'			=> 'Yeni yorumu bildir:',
	'NotifyNewCommentInfo'		=> 'Beklemede - Kullanıcı sayfayı tekrar ziyaret edene kadar yalnızca ilk yorum için e-posta bildirimi gönder.',

	'NotifyUserAccount'			=> 'Yeni kullanıcı hesabını bildir:',
	'NotifyUserAccountInfo'		=> 'Yönetici, kayıt formu kullanılarak yeni bir kullanıcı oluşturulduğunda bilgilendirilecek.',
	'NotifyUpload'				=> 'Dosya yüklemeyi bildir:',
	'NotifyUploadInfo'			=> 'Bir dosya yüklendiğinde Moderatörler bilgilendirilecek.',

	'PersonalMessagesSection'	=> 'Kişisel Mesajlar',
	'AllowIntercomDefault'		=> 'İnterkoma izin ver:',
	'AllowIntercomDefaultInfo'	=> 'Bu seçeneği etkinleştirmek, diğer kullanıcıların alıcının e-posta adresini açıklamadan alıcının e-posta adresine kişisel mesaj göndermesine izin verir.',
	'AllowMassemailDefault'		=> 'Toplu e-postaya izin ver:',
	'AllowMassemailDefaultInfo'	=> 'Yalnızca yöneticilerin kendilerine e-posta göndermesine izin veren kullanıcılar toplu e-postalar alır.',

	// Resync settings
	'Synchronize'				=> 'Eşitle',
	'UserStatsSynched'			=> 'Kullanıcı istatistikleri eşitlendi.',
	'PageStatsSynched'			=> 'Sayfa istatistikleri eşitlendi.',
	'FeedsUpdated'				=> 'RSS beslemeleri güncellendi.',
	'SiteMapCreated'			=> 'Site haritasının yeni sürümü başarıyla oluşturuldu.',
	'ParseNextBatch'			=> 'Bir sonraki sayfa kümesini ayrıştır:',
	'WikiLinksRestored'			=> 'Wiki bağlantıları geri yüklendi.',

	'LogUserStatsSynched'		=> 'Kullanıcı istatistikleri senkronize edildi',
	'LogPageStatsSynched'		=> 'Sayfa istatistikleri senkronize edildi',
	'LogFeedsUpdated'			=> 'RSS beslemeleri senkronize edildi',
	'LogPageBodySynched'		=> 'Sayfa gövdesi ve bağlantıları tekrar ayrıştırıldı',

	'UserStats'					=> 'Kullanıcı istatistikleri',
	'UserStatsInfo'				=> 'Kullanıcı istatistikleri (yorum sayısı, sahip olunan sayfalar, revizyonlar ve dosyalar) bazı durumlarda gerçek verilerden farklı olabilir. <br>Bu işlem, veritabanında bulunan gerçek verilerle istatistikleri güncellemenizi sağlar.',
	'PageStats'					=> 'Sayfa istatistikleri',
	'PageStatsInfo'				=> 'Sayfa istatistikleri (yorum, dosya ve revizyon sayısı) bazı durumlarda gerçek verilerden farklı olabilir. <br>Bu işlem, veritabanındaki gerçek durumla istatistikleri eşleştirmenizi sağlar.',

	'AttachmentsInfo'			=> 'Veritabanındaki tüm eklerin dosya karmasını güncelle.',
	'AttachmentsSynched'		=> 'Tüm dosya eklerinin karması yeniden oluşturuldu',
	'LogAttachmentsSynched'		=> 'Tüm dosya eklerinin karması yeniden oluşturuldu',

	'Feeds'						=> 'Beslemeler',
	'FeedsInfo'					=> 'Sayfaların veritabanında doğrudan düzenlenmesi durumunda, RSS beslemelerinin içeriği yapılan değişiklikleri yansıtmayabilir. <br>Bu işlev RSS kanallarını veritabanının mevcut durumu ile senkronize eder.',
	'XmlSiteMap'				=> 'XML Site Haritası',
	'XmlSiteMapInfo'			=> 'Bu işlev XML Site Haritasını veritabanının mevcut durumu ile senkronize eder.',
	'XmlSiteMapPeriod'			=> 'Süre %1 gün. Son yazılma %2.',
	'XmlSiteMapView'			=> 'Site Haritasını yeni pencerede göster.',

	'ReparseBody'				=> 'Tüm sayfaları yeniden ayrıştır',
	'ReparseBodyInfo'			=> 'Sayfa tablosundaki <code>body_r</code> alanını boşaltır, böylece her sayfa bir sonraki görüntülemede yeniden oluşturulur. Bu, biçimlendiriciyi değiştirdiğinizde veya wiki alan adını değiştirdiğinizde faydalı olabilir.',
	'PreparsedBodyPurged'		=> 'Sayfa tablosundaki <code>body_r</code> alanı boşaltıldı.',

	'WikiLinksResync'			=> 'Wiki bağlantıları',
	'WikiLinksResyncInfo'		=> 'Tüm dahili site bağlantıları için yeniden render yapar ve zarar veya taşınma durumunda <code>page_link</code> ve <code>file_link</code> tablolarının içeriğini geri yükler (bu önemli zaman alabilir).',
	'RecompilePage'				=> 'Tüm sayfaları yeniden derleme (çok maliyetli)',
	'ResyncOptions'				=> 'Ek seçenekler',
	'RecompilePageLimit'		=> 'Aynı anda ayrıştırılacak sayfa sayısı.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Bu bilgiler, motor kullanıcılarınıza e-posta gönderdiğinde kullanılır. Lütfen belirttiğiniz e-posta adresinin geçerli olduğundan emin olun; aksi takdirde geri dönen veya teslim edilemeyen mesajlar muhtemelen o adrese gönderilecektir. Hosting sağlayıcınız yerel (PHP tabanlı) bir e-posta hizmeti sağlamıyorsa, mesajları doğrudan SMTP kullanarak gönderebilirsiniz. Bu, uygun bir sunucunun adresini gerektirir (gerekirse hosting sağlayıcınıza sorun). Sunucu kimlik doğrulama gerektiriyorsa (yalnızca öyleyse), gerekli kullanıcı adı, parola ve kimlik doğrulama yöntemini girin.',

	'EmailSettingsUpdated'		=> 'E-posta ayarları güncellendi',

	'EmailFunctionName'			=> 'E-posta fonksiyon adı:',
	'EmailFunctionNameInfo'		=> 'PHP aracılığıyla posta göndermek için kullanılan e-posta fonksiyonu.',
	'UseSmtpInfo'				=> '<code>SMTP</code>yi, e-postaları yerel mail fonksiyonu yerine adlandırılmış bir sunucu üzerinden göndermek istiyorsanız veya göndermek zorundaysanız seçin.',

	'EnableEmail'				=> 'E-postaları etkinleştir:',
	'EnableEmailInfo'			=> 'E-postaların gönderilmesini etkinleştir.',

	'EmailIdentitySettings'		=> 'Web Sitesi E-posta Kimlikleri',
	'FromEmailName'				=> 'Gönderen adı:',
	'FromEmailNameInfo'			=> 'Siteden gönderilen tüm e-posta bildirimleri için <code>From:</code> başlığında kullanılacak gönderen adı.',
	'EmailSubjectPrefix'		=> 'Konu ön eki:',
	'EmailSubjectPrefixInfo'	=> 'Alternatif e-posta konu ön eki, örn. <code>[Prefix] Başlık</code>. Tanımlanmadıysa varsayılan önek Site Adı: %1 olur.',

	'NoReplyEmail'				=> 'Yanıtlama yok adresi:',
	'NoReplyEmailInfo'			=> 'Örneğin <code>noreply@example.com</code> gibi bu adres, siteden gönderilen tüm e-posta bildirimlerinin <code>From:</code> alanında görünecektir.',
	'AdminEmail'				=> 'Site sahibinin e-postası:',
	'AdminEmailInfo'			=> 'Yeni kullanıcı bildirimi gibi yönetim amaçlı için kullanılacak adres.',
	'AbuseEmail'				=> 'Kötüye kullanım bildirimi e-postası:',
	'AbuseEmailInfo'			=> 'Yabancı e-posta kaydı gibi acil konular için başvuruların gideceği adres. Site sahibinin e-postasıyla aynı olabilir.',

	'SendTestEmail'				=> 'Test e-postası gönder',
	'SendTestEmailInfo'			=> 'Bu, hesabınızda tanımlı adrese bir test e-postası gönderecektir.',
	'TestEmailSubject'			=> 'Wikiniz e-posta gönderecek şekilde doğru yapılandırıldı',
	'TestEmailBody'				=> 'Bu e-postayı aldıysanız, Wikiniz e-posta göndermeye uygun şekilde yapılandırılmıştır.',
	'TestEmailMessage'			=> 'Test e-postası gönderildi.<br>E-postayı almazsanız, lütfen e-posta yapılandırma ayarlarınızı kontrol edin.',

	'SmtpSettings'				=> 'SMTP Ayarları',
	'SmtpAutoTls'				=> 'Fırsatçı TLS:',
	'SmtpAutoTlsInfo'			=> 'Sunucunun TLS şifrelemesini reklam ettiğini görürse, bağlantı modunu <code>SMTPSecure</code> için ayarlamamış olsanız bile şifrelemeyi otomatik olarak etkinleştirir (sunucuya bağlandıktan sonra).',
	'SmtpConnectionMode'		=> 'SMTP için bağlantı modu:',
	'SmtpConnectionModeInfo'	=> 'Sadece kullanıcı adı/parola gerekiyorsa kullanılır. Hangi yöntemin kullanılacağını bilmiyorsanız sağlayıcınıza sorun.',
	'SmtpPassword'				=> 'SMTP parolası:',
	'SmtpPasswordInfo'			=> 'SMTP sunucunuz gerektiriyorsa yalnızca bir parola girin.<br><em><strong>Uyarı:</strong> Bu parola veritabanında düz metin olarak saklanacak ve veritabanınıza erişebilen veya bu yapılandırma sayfasını görüntüleyebilen herkes tarafından görülebilecektir.</em>',
	'SmtpPort'					=> 'SMTP sunucu portu:',
	'SmtpPortInfo'				=> 'SMTP sunucunuzun farklı bir portta olduğunu biliyorsanız bunu değiştirin. <br>(varsayılan: <code>tls</code> için genellikle 587 (veya bazen 25), <code>ssl</code> için 465).',
	'SmtpServer'				=> 'SMTP sunucu adresi:',
	'SmtpServerInfo'			=> 'Sunucunuzun kullandığı protokolü belirtmeniz gerektiğini unutmayın. SSL kullanıyorsanız bu <code>ssl://mail.example.com</code> gibi olmalıdır.',
	'SmtpUsername'				=> 'SMTP kullanıcı adı:',
	'SmtpUsernameInfo'			=> 'SMTP sunucunuz gerektiriyorsa yalnızca bir kullanıcı adı girin.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Buradan ekler ve ilgili özel kategoriler için temel ayarları yapılandırabilirsiniz.',
	'UploadSettingsUpdated'		=> 'Yükleme ayarları güncellendi',

	'FileUploadsSection'		=> 'Dosya Yüklemeleri',
	'RegisteredUsers'			=> 'kayıtlı kullanıcılar',
	'RightToUpload'				=> 'Dosya yükleme izinleri:',
	'RightToUploadInfo'			=> '<code>admins</code>, sadece admins grubuna ait kullanıcıların dosya yükleyebileceği anlamına gelir. <code>1</code>, yüklemenin kayıtlı kullanıcılara açık olduğunu belirtir. <code>0</code>, yüklemenin devre dışı olduğunu belirtir.',
	'UploadMaxFilesize'			=> 'Maksimum dosya boyutu:',
	'UploadMaxFilesizeInfo'		=> 'Her dosyanın maksimum boyutu. Bu değer 0 ise, yüklenebilecek maksimum dosya boyutu yalnızca PHP yapılandırmanız tarafından sınırlanır.',
	'UploadQuota'				=> 'Toplam ek kotası:',
	'UploadQuotaInfo'			=> 'Tüm wikinin ekler için kullanılabilir maksimum disk alanı; <code>0</code> sınırsızdır. %1 kullanıldı.',
	'UploadQuotaUser'			=> 'Kullanıcı başına depolama kotası:',
	'UploadQuotaUserInfo'		=> 'Tek bir kullanıcının yükleyebileceği depolama kotası sınırı; <code>0</code> sınırsızdır.',

	'FileTypes'					=> 'Dosya Türleri',
	'UploadOnlyImages'			=> 'Yalnızca resim yüklemeye izin ver:',
	'UploadOnlyImagesInfo'		=> 'Sayfaya yalnızca resim dosyalarının yüklenmesine izin ver.',
	'AllowedUploadExts'			=> 'İzin verilen dosya türleri:',
	'AllowedUploadExtsInfo'		=> 'Dosya yüklemek için izin verilen uzantılar, virgülle ayrılmış (örn. <code>png, ogg, mp4</code>); aksi halde tüm dosya uzantılarına izin verilir.<br>Site işlevselliğiniz için gereken asgari uzantılarla sınırlamanız önerilir.',
	'CheckMimetype'				=> 'MIME türünü denetle:',
	'CheckMimetypeInfo'			=> 'Bazı tarayıcılar yüklenen dosyalar için yanlış bir mimetype varsayacak şekilde kandırılabilir. Bu seçenek bu tür dosyaların reddedilmesini sağlamaya yardımcı olur.',
	'SvgSanitizer'				=> 'SVG temizleyici:',
	'SvgSanitizerInfo'			=> 'SVG/XML zafiyetlerinin yüklenmesini önlemek için SVG dosyalarını temizlemeyi etkinleştirir.',
	'TranslitFileName'			=> 'Dosya adlarını translitere et:',
	'TranslitFileNameInfo'		=> 'Uygulanabilir ve Unicode karakterlerine gerek yoksa, dosya adlarında yalnızca alfanümerik karakterleri kabul etmek şiddetle tavsiye edilir.',
	'TranslitCaseFolding'		=> 'Dosya adlarını küçük harfe dönüştür:',
	'TranslitCaseFoldingInfo'	=> 'Bu seçenek yalnızca transliterasyon etkin ise etkilidir.',

	'Thumbnails'				=> 'Küçük Resimler',
	'CreateThumbnail'			=> 'Küçük resim oluştur:',
	'CreateThumbnailInfo'		=> 'Tüm mümkün durumlarda küçük resim oluştur.',
	'JpegQuality'				=> 'JPEG kalite:',
	'JpegQualityInfo'			=> 'JPEG küçük resmi ölçeklendirilirken kalite değeri. 1 ile 100 arasında olmalı, 100 en yüksek kaliteyi gösterir.',
	'MaxImageArea'				=> 'Maksimum görüntü alanı:',
	'MaxImageAreaInfo'			=> 'Kaynak görüntünün sahip olabileceği maksimum piksel sayısı. Bu, görüntü ölçeklendiricinin açılmasında hafıza kullanımını sınırlar.<br><code>-1</code> görüntüyü ölçeklendirmeye çalışmadan önce boyutu kontrol etmeyeceği anlamına gelir. <code>0</code> değeri otomatik olarak belirlenecektir.',
	'MaxThumbWidth'				=> 'Küçük resim için maksimum genişlik (piksel):',
	'MaxThumbWidthInfo'			=> 'Oluşturulan küçük resim burada belirtilen genişliği aşmayacaktır.',
	'MinThumbFilesize'			=> 'Minimum küçük resim dosya boyutu:',
	'MinThumbFilesizeInfo'		=> 'Bu değerden daha küçük resimler için küçük resim oluşturma.',
	'MaxImageWidth'				=> 'Sayfalardaki görüntü genişliği sınırı:',
	'MaxImageWidthInfo'			=> 'Sayfalarda bir resmin sahip olabileceği maksimum genişlik; aksi halde ölçeklenmiş küçük resim oluşturulur.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Silinmiş sayfalar, revizyonlar ve dosyaların listesi.
									İlgili satırdaki <em>Remove</em> veya <em>Restore</em> bağlantısına tıklayarak veritabanından sayfaları, revizyonları veya dosyaları kaldırın ya da geri yükleyin. (Dikkat: silme işlemi için onay istenmez!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Wikinizde otomatik olarak sansürlenecek kelimeler.',
	'FilterSettingsUpdated'		=> 'Spam filtre ayarları güncellendi',

	'WordCensoringSection'		=> 'Kelime Sansürleme',
	'SPAMFilter'				=> 'Spam filtresi:',
	'SPAMFilterInfo'			=> 'Spam filtresini etkinleştir',
	'WordList'					=> 'Kelime listesi:',
	'WordListInfo'				=> 'Kara listeye alınacak kelime veya ifade <code>parçaları</code> (her satıra bir tane)',

	// Log module
	'LogFilterTip'				=> 'Olayları kriterlere göre filtrele:',
	'LogLevel'					=> 'Seviye',
	'LogLevelFilters'	=> [
		'1'		=> 'en az',
		'2'		=> 'en fazla',
		'3'		=> 'eşit',
	],
	'LogNoMatch'				=> 'Kriterleri karşılayan olay yok',
	'LogDate'					=> 'Tarih',
	'LogEvent'					=> 'Olay',
	'LogUsername'				=> 'Kullanıcı Adı',
	'LogLevels'	=> [
		'1'		=> 'kritik',
		'2'		=> 'en yüksek',
		'3'		=> 'yüksek',
		'4'		=> 'orta',
		'5'		=> 'düşük',
		'6'		=> 'en düşük',
		'7'		=> 'hata ayıklama',
	],

	// Massemail module
	'MassemailInfo'				=> 'Buradan (1) tüm kullanıcılarınıza veya (2) toplu e-posta almayı etkinleştirmiş belirli bir grubun tüm üyelerine bir mesaj e-posta ile gönderebilirsiniz. Yönetici e-postası adresine bir e-posta gönderilecek ve tüm alıcılara gizli kopya (BCC) gönderilecektir. Varsayılan ayar böyle bir e-postada en fazla 20 alıcıyı içerir. 20\'den fazla alıcı varsa ek e-postalar gönderilir. Büyük bir gruba e-posta gönderiyorsanız, gönderimi tamamlandıktan sonra sabırlı olun ve sayfayı yarıda durdurmayın. Toplu e-posta gönderimi uzun sürebilir ve işlem tamamlandığında bilgilendirileceksiniz.',
	'LogMassemail'				=> 'Toplu e-posta gönderildi %1 grup / kullanıcı için ',
	'MassemailSend'				=> 'Toplu e-posta gönder',

	'NoEmailMessage'			=> 'Bir mesaj girmeniz gerekiyor.',
	'NoEmailSubject'			=> 'Mesajınız için bir konu belirtmelisiniz.',
	'NoEmailRecipient'			=> 'En az bir kullanıcı veya kullanıcı grubu belirtmelisiniz.',

	'MassemailSection'			=> 'Toplu e-posta',
	'MessageSubject'			=> 'Konu:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Mesajınız:',
	'YourMessageInfo'			=> 'Lütfen yalnızca düz metin girebileceğinizi unutmayın. Tüm biçimlendirme gönderilmeden önce kaldırılacaktır.',

	'NoUser'					=> 'Kullanıcı yok',
	'NoUserGroup'				=> 'Kullanıcı grubu yok',

	'SendToGroup'				=> 'Gruba gönder:',
	'SendToUser'				=> 'Kullanıcıya gönder:',
	'SendToUserInfo'			=> 'Yalnızca yöneticilerin kendilerine e-posta göndermesine izin veren kullanıcılar toplu e-postalar alır. Bu seçenek onların Bildirimler bölümünde kullanıcı ayarlarında mevcuttur.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Sistem mesajı güncellendi',

	'SysMsgSection'				=> 'Sistem Mesajı',
	'SysMsg'					=> 'Sistem mesajı:',
	'SysMsgInfo'				=> 'Mesajınızı buraya yazın',

	'SysMsgType'				=> 'Tür:',
	'SysMsgTypeInfo'			=> 'Mesaj türü (CSS).',
	'SysMsgAudience'			=> 'Hedef kitle:',
	'SysMsgAudienceInfo'		=> 'Sistem mesajının gösterileceği kitle.',
	'EnableSysMsg'				=> 'Sistem mesajını etkinleştir:',
	'EnableSysMsgInfo'			=> 'Sistem mesajını göster.',

	// User approval module
	'ApproveNotExists'			=> 'Lütfen Set düğmesi ile en az bir kullanıcı seçin.',

	'LogUserApproved'			=> 'Kullanıcı ##%1## onaylandı',
	'LogUserBlocked'			=> 'Kullanıcı ##%1## engellendi',
	'LogUserDeleted'			=> 'Kullanıcı ##%1## veritabanından kaldırıldı',
	'LogUserCreated'			=> 'Yeni kullanıcı oluşturuldu ##%1##',
	'LogUserUpdated'			=> 'Kullanıcı güncellendi ##%1##',
	'LogUserPasswordReset'		=> '##%1## kullanıcısının parolası başarıyla sıfırlandı',

	'UserApproveInfo'			=> 'Yeni kullanıcıların siteye giriş yapabilmeden önce onaylanmasını sağlayın.',
	'Approve'					=> 'Onayla',
	'Deny'						=> 'Reddet',
	'Pending'					=> 'Beklemede',
	'Approved'					=> 'Onaylandı',
	'Denied'					=> 'Reddedildi',

	// DB Backup module
	'BackupStructure'			=> 'Yapı',
	'BackupData'				=> 'Veri',
	'BackupFolder'				=> 'Klasör',
	'BackupTable'				=> 'Tablo',
	'BackupCluster'				=> 'Küme:',
	'BackupFiles'				=> 'Dosyalar',
	'BackupNote'				=> 'Not:',
	'BackupSettings'			=> 'Yedekleme için istenen şemayı belirtin.<br>' .
	'Kök küme, küresel dosya yedeklemesini ve önbellek dosyası yedeklemesini etkilemez (seçilse bile bunlar her zaman tamamen kaydedilir).<br>' .  '<br>' .
	'<strong>Dikkat</strong>: Kök küme belirtilirken veritabanından bilgi kaybını önlemek için, bu yedeklemeden alınan tablolar yeniden yapılandırılmayacaktır; aynı şekilde yalnızca tablo yapısını yedekleyip verileri kaydetmezseniz de. Tabloların yedek formatına tam dönüştürülmesi için <em>küme belirtmeden tam veritabanı yedeği (yapı ve veri)</em> alınmalıdır.',
	'BackupCompleted'			=> 'Yedekleme ve arşivleme tamamlandı.<br>' .
	'Yedek paket dosyaları %1 alt dizinine kaydedildi.<br>İndirmek için FTP kullanın (kopyalama sırasında dizin yapısını ve dosya adlarını koruyun).<br>Bir yedekten geri yüklemek veya paketi silmek için <a href="%2">Veritabanını geri yükle</a> sayfasına gidin.',
	'LogSavedBackup'			=> 'Kaydedilen yedek veritabanı ##%1##',
	'Backup'					=> 'Yedekle',
	'CantReadFile'				=> '%1 dosyası okunamıyor.',

	// DB Restore module
	'RestoreInfo'				=> 'Bulunan yedek paketlerinden herhangi birini geri yükleyebilir veya sunucudan kaldırabilirsiniz.',
	'ConfirmDbRestore'			=> '%1 yedeğini geri yüklemek istiyor musunuz?',
	'ConfirmDbRestoreInfo'		=> 'Lütfen bekleyin, bu biraz zaman alabilir.',
	'RestoreWrongVersion'		=> 'Yanlış WackoWiki sürümü!',
	'DirectoryNotExecutable'	=> '%1 dizini çalıştırılabilir değil.',
	'BackupDelete'				=> '%1 yedeğini kaldırmak istediğinizden emin misiniz?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Ek geri yükleme seçenekleri:',
	'RestoreOptionsInfo'		=> '* <strong>Küme yedeğini</strong> geri yüklemeden önce hedef tablolar silinmez (yedeklenmemiş kümelerdeki bilgiler kaybolmasın diye). ' .
	'Böylece geri yükleme sürecinde çift kayıtlar oluşacaktır. ' .
	'Normal modda, bunların tümü yedek kayıtlarıyla değiştirilecektir (SQL <code>REPLACE</code> kullanılarak), ' .
	'ancak bu onay kutusu işaretlenirse, tüm çiftler atlanır (mevcut kayıt değerleri korunur), ' .
	've yalnızca yeni anahtarlara sahip kayıtlar tabloya eklenir (SQL <code>INSERT IGNORE</code>).<br>' .
	'<strong>Not</strong>: Siteye ait tam yedek geri yüklendiğinde bu seçeneğin anlamı yoktur.<br>' .
	'<br>' .
	'** Yedek kullanıcı dosyalarını (küresel ve sayfa başına, önbellek dosyaları vb.) içeriyorsa, normal modda aynı adlara sahip mevcut dosyaların yerini alır ve geri yüklenirken aynı dizine yerleştirilir. ' .
	'Bu seçenek, mevcut dosyaların kopyalarını korumanıza ve bir yedekten yalnızca sunucuda eksik olan yeni dosyaları geri yüklemenize olanak tanır.',
	'IgnoreDuplicatedKeysNr'	=> 'Çoğaltılmış tablo anahtarlarını yoksay (değiştirme)',
	'IgnoreSameFiles'			=> 'Aynı dosyaları yoksay (üzerine yazma)',
	'NoBackupsAvailable'		=> 'Kullanılabilir yedek yok.',
	'BackupEntireSite'			=> 'Tüm site',
	'BackupRestored'			=> 'Yedek geri yüklendi, özet rapor aşağıda eklenmiştir. Bu yedek paketini silmek için tıklayın',
	'BackupRemoved'				=> 'Seçilen yedek başarıyla kaldırıldı.',
	'LogRemovedBackup'			=> 'Kaldırılan veritabanı yedeği ##%1##',

	'DbEngineInvalid'			=> 'Geçersiz veritabanı motoru, %1 bekleniyor',
	'RestoreStarted'			=> 'Geri Yükleme Başlatıldı',
	'RestoreParameters'			=> 'Kullanılan parametreler',
	'IgnoreDuplicatedKeys'		=> 'Çoğaltılmış anahtarları yoksay',
	'IgnoreDuplicatedFiles'		=> 'Çoğaltılmış dosyaları yoksay',
	'SavedCluster'				=> 'Kaydedilmiş küme',
	'DataProtection'			=> 'Veri Koruma - %1 atlandı',
	'AssumeDropTable'			=> '%1 varsay',
	'RestoreSQLiteDatabase'		=> 'SQLite veritabanını geri yüklüyor',
	'SQLiteDatabaseRestored'	=> 'Veritabanı başarıyla geri yüklendi:',
	'RestoreTableStructure'		=> 'Tablo yapısını geri yüklüyor',
	'RunSqlQueries'				=> 'SQL talimatlarını çalıştır:',
	'CompletedSqlQueries'		=> 'Tamamlandı. İşlenen talimatlar:',
	'NoTableStructure'			=> 'Tablo yapısı kaydedilmedi - atlanıyor',
	'RestoreRecords'			=> 'Tabloların içeriğini geri yükle',
	'ProcessTablesDump'			=> 'Sadece tablo dökümlerini indir ve işle',
	'Instruction'				=> 'Talimat',
	'RestoredRecords'			=> 'kayıtlar:',
	'RecordsRestoreDone'		=> 'Tamamlandı. Toplam kayıtlar:',
	'SkippedRecords'			=> 'Veri kaydedilmedi - atlandı',
	'RestoringFiles'			=> 'Dosyalar geri yükleniyor',
	'DecompressAndStore'		=> 'Dizilerin içeriğini aç ve depola',
	'HomonymicFiles'			=> 'aynı ada sahip dosyalar',
	'RestoreSkip'				=> 'atla',
	'RestoreReplace'			=> 'değiştir',
	'RestoreFile'				=> 'Dosya:',
	'RestoredFiles'				=> 'geri yüklendi:',
	'SkippedFiles'				=> 'atlandı:',
	'FileRestoreDone'			=> 'Tamamlandı. Toplam dosyalar:',
	'FilesAll'					=> 'tümü:',
	'SkipFiles'					=> 'Dosyalar depolanmadı - atlandı',
	'RestoreDone'				=> 'GERİ YÜKLEME TAMAMLANDI',

	'BackupCreationDate'		=> 'Oluşturulma Tarihi',
	'BackupPackageContents'		=> 'Paketin içeriği',
	'BackupRestore'				=> 'Geri Yükle',
	'BackupRemove'				=> 'Kaldır',
	'RestoreYes'				=> 'Evet',
	'RestoreNo'					=> 'Hayır',
	'LogDbRestored'				=> 'Veritabanı yedeği ##%1## geri yüklendi.',

	'BackupArchived'			=> '%1 yedeği arşivlendi.',
	'BackupArchiveExists'		=> '%1 yedek arşivi zaten mevcut.',
	'LogBackupArchived'			=> 'Yedek ##%1## arşivlendi.',

	// User module
	'UsersInfo'					=> 'Buradan kullanıcı bilgilerinizde ve belirli özel seçeneklerde değişiklik yapabilirsiniz.',

	'UsersAdded'				=> 'Kullanıcı eklendi',
	'UsersDeleteInfo'			=> 'Kullanıcıyı sil:',
	'EditButton'				=> 'Düzenle',
	'UsersAddNew'				=> 'Yeni kullanıcı ekle',
	'UsersDelete'				=> '%1 kullanıcısını kaldırmak istediğinizden emin misiniz?',
	'UsersDeleted'				=> '%1 kullanıcısı veritabanından silindi.',
	'UsersRename'				=> '%1 kullanıcısının adını değiştir',
	'UsersRenameInfo'			=> '* Not: Değişiklik, o kullanıcıya atanmış tüm sayfaları etkileyecektir.',
	'UsersUpdated'				=> 'Kullanıcı başarıyla güncellendi.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Kayıt zamanı',
	'UserActions'				=> 'İşlemler',
	'NoMatchingUser'			=> 'Kriterlere uyan kullanıcı yok',

	'UserAccountNotify'			=> 'Kullanıcıyı bildir',
	'UserNotifySignup'			=> 'kullanıcıyı yeni hesap hakkında bilgilendir',
	'UserVerifyEmail'			=> 'e-posta onay jetonu ayarla ve e-posta doğrulama bağlantısı ekle',
	'UserReVerifyEmail'			=> 'E-posta onay jetonunu yeniden gönder',

	// Groups module
	'GroupsInfo'				=> 'Bu panelden tüm kullanıcı gruplarınızı yönetebilirsiniz. Mevcut grupları silebilir, oluşturabilir ve düzenleyebilirsiniz. Ayrıca grup liderleri seçebilir, açık/gizli/kapalı grup durumlarını değiştirebilir ve grup adı ile açıklamasını ayarlayabilirsiniz.',

	'LogMembersUpdated'			=> 'Kullanıcı grubu üyeleri güncellendi',
	'LogMemberAdded'			=> '##%1## üyesi ##%2## grubuna eklendi',
	'LogMemberRemoved'			=> '##%1## üyesi ##%2## grubundan kaldırıldı',
	'LogGroupCreated'			=> 'Yeni grup oluşturuldu ##%1##',
	'LogGroupRenamed'			=> '##%1## grubu ##%2## olarak yeniden adlandırıldı',
	'LogGroupRemoved'			=> '##%1## grubu kaldırıldı',

	'GroupsMembersFor'			=> 'Grup üyeleri için',
	'GroupsDescription'			=> 'Açıklama',
	'GroupsModerator'			=> 'Moderatör',
	'GroupsOpen'				=> 'Aç',
	'GroupsActive'				=> 'Etkin',
	'GroupsTip'					=> 'Grubu düzenlemek için tıklayın',
	'GroupsUpdated'				=> 'Gruplar güncellendi',
	'GroupsAlreadyExists'		=> 'Bu grup zaten mevcut.',
	'GroupsAdded'				=> 'Grup başarıyla eklendi.',
	'GroupsRenamed'				=> 'Grup başarıyla yeniden adlandırıldı.',
	'GroupsDeleted'				=> '%1 grubu ve ilgili tüm sayfalar veritabanından silindi.',
	'GroupsAdd'					=> 'Yeni grup ekle',
	'GroupsRename'				=> '%1 grubunun adını değiştir',
	'GroupsRenameInfo'			=> '* Not: Değişiklik, o gruba atanmış tüm sayfaları etkileyecektir.',
	'GroupsDelete'				=> '%1 grubunu kaldırmak istediğinizden emin misiniz?',
	'GroupsDeleteInfo'			=> '* Not: Değişiklik, o gruba atanmış tüm üyeleri etkileyecektir.',
	'GroupsIsSystem'			=> '%1 grubu sistem grubudur ve kaldırılamaz.',
	'GroupsStoreButton'			=> 'Grupları Kaydet',
	'GroupsEditInfo'			=> 'Gruplar listesini düzenlemek için radyo düğmesini seçin.',

	'GroupAddMember'			=> 'Üye ekle',
	'GroupRemoveMember'			=> 'Üyeyi kaldır',
	'GroupAddNew'				=> 'Grup ekle',
	'GroupEdit'					=> 'Grubu düzenle',
	'GroupDelete'				=> 'Grubu kaldır',

	'MembersAddNew'				=> 'Yeni üye ekle',
	'MembersAdded'				=> 'Gruba yeni üye başarıyla eklendi.',
	'MembersRemove'				=> '%1 üyesini kaldırmak istediğinizden emin misiniz?',
	'MembersRemoved'			=> 'Üye gruptan kaldırıldı.',

	// Statistics module
	'DbStatSection'				=> 'Veritabanı İstatistikleri',
	'DbTable'					=> 'Tablo',
	'DbRecords'					=> 'Kayıtlar',
	'DbSize'					=> 'Boyut',
	'DbIndex'					=> 'İndeks',
	'DbTotal'					=> 'Toplam',

	'FileStatSection'			=> 'Dosya Sistemi İstatistikleri',
	'FileFolder'				=> 'Klasör',
	'FileFiles'					=> 'Dosyalar',
	'FileSize'					=> 'Boyut',
	'FileTotal'					=> 'Toplam',

	// Sysinfo module
	'SysInfo'					=> 'Sürüm bilgisi:',
	'SysParameter'				=> 'Parametre',
	'SysValues'					=> 'Değerler',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Son güncelleme',
	'ServerOS'					=> 'İşletim Sistemi',
	'ServerName'				=> 'Sunucu adı',
	'WebServer'					=> 'Web sunucusu',
	'HttpProtocol'				=> 'HTTP Protokolü',
	'DbVersion'					=> 'Veritabanı',
	'SqlModesGlobal'			=> 'SQL Modları (Genel)',
	'SqlModesSession'			=> 'SQL Modları (Oturum)',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Bellek',
	'UploadFilesizeMax'			=> 'Maks. yükleme dosya boyutu',
	'PostMaxSize'				=> 'Maks. POST boyutu',
	'MaxExecutionTime'			=> 'Maks. yürütme süresi',
	'SessionPath'				=> 'Oturum yolu',
	'PhpDefaultCharset'			=> 'PHP varsayılan karakter seti',
	'GZipCompression'			=> 'GZip sıkıştırma',
	'PhpExtensions'				=> 'PHP eklentileri',
	'ApacheModules'				=> 'Apache modülleri',

	// DB repair module
	'DbRepairSection'			=> 'Veritabanını Onar',
	'DbRepair'					=> 'Veritabanını Onar',
	'DbRepairInfo'				=> 'Bu betik bazı yaygın veritabanı sorunlarını otomatik olarak arayıp onarabilir. Onarma biraz zaman alabilir, lütfen sabırlı olun.',

	'DbOptimizeRepairSection'	=> 'Veritabanını Onar ve Optimize Et',
	'DbOptimizeRepair'			=> 'Veritabanını Onar ve Optimize Et',
	'DbOptimizeRepairInfo'		=> 'Bu betik ayrıca veritabanını optimize etmeye çalışabilir. Bu bazı durumlarda performansı artırır. Veritabanını onarmak ve optimize etmek uzun sürebilir ve optimize sırasında veritabanı kilitlenecektir.',

	'TableOk'					=> '%1 tablosu iyi durumda.',
	'TableNotOk'				=> '%1 tablosu iyi değil. Aşağıdaki hatayı bildiriyor: %2. Bu betik bu tabloyu onarmaya çalışacaktır…',
	'TableRepaired'				=> '%1 tablosu başarıyla onarıldı.',
	'TableRepairFailed'			=> '%1 tablosunu onarmada başarısız oldu. <br>Hata: %2',
	'TableAlreadyOptimized'		=> '%1 tablosu zaten optimize edilmiş.',
	'TableOptimized'			=> '%1 tablosu başarıyla optimize edildi.',
	'TableOptimizeFailed'		=> '%1 tablosunu optimize ederken başarısız oldu. <br>Hata: %2',
	'TableNotRepaired'			=> 'Bazı veritabanı sorunları onarılamadı.',
	'RepairsComplete'			=> 'Onarımlar tamamlandı',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Tutarsızlıkları gösterin ve düzeltin; yetim kayıtları silin veya yeni bir kullanıcı/değer atayın.',
	'Inconsistencies'			=> 'Tutarsızlıklar',
	'CheckDatabase'				=> 'Veritabanı',
	'CheckDatabaseInfo'			=> 'Veritabanındaki kayıt tutarsızlıklarını kontrol eder.',
	'CheckFiles'				=> 'Dosyalar',
	'CheckFilesInfo'			=> 'Atıl durumdaki dosyaları, dosya tablosunda artık referansı olmayan dosyaları kontrol eder.',
	'Records'					=> 'Kayıtlar',
	'InconsistenciesNone'		=> 'Herhangi bir veri tutarsızlığı bulunamadı.',
	'InconsistenciesDone'		=> 'Veri tutarsızlıkları çözüldü.',
	'InconsistenciesRemoved'	=> 'Tutarsızlıklar kaldırıldı',
	'Check'						=> 'Kontrol et',
	'Solve'						=> 'Çöz',

	// Bad Behaviour module
	'BbInfo'					=> 'İstenmeyen web erişimlerini algılar ve engeller, otomatik spam botlarının erişimini reddeder.<br>Daha fazla bilgi için lütfen %1 ana sayfasını ziyaret edin.',
	'BbEnable'					=> 'Bad Behaviour\'ı etkinleştir:',
	'BbEnableInfo'				=> 'Diğer tüm ayarlar %1 yapılandırma klasöründe değiştirilebilir.',
	'BbStats'					=> 'Bad Behaviour son 7 günde %1 erişim girişimini engelledi.',

	'BbSummary'					=> 'Özet',
	'BbLog'						=> 'Günlük',
	'BbSettings'				=> 'Ayarlar',
	'BbWhitelist'				=> 'Beyaz liste',

	// --> Log
	'BbHits'					=> 'Erişimler',
	'BbRecordsFiltered'			=> '%2 kayıttan %1 tanesi filtrelenerek gösteriliyor',
	'BbStatus'					=> 'Durum',
	'BbBlocked'					=> 'Engellendi',
	'BbPermitted'				=> 'İzin verildi',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Tüm %1 kayıt gösteriliyor',
	'BbShow'					=> 'Göster',
	'BbIpDateStatus'			=> 'IP/Tarih/Durum',
	'BbHeaders'					=> 'Başlıklar',
	'BbEntity'					=> 'Varlık',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Seçenekler kaydedildi.',
	'BbWhitelistHint'			=> 'Uygunsuz beyaz listeleme SPAM ile karşılaşmanıza veya Bad Behaviour\'ın tamamen çalışmayı durdurmasına yol açabilir! Beyaz listeye eklemeyin, %100 EMİN değilseniz.',
	'BbIpAddress'				=> 'IP Adresi',
	'BbIpAddressInfo'			=> 'Beyaz listeye alınacak IP adresi veya CIDR formatındaki adres aralıkları (her satıra bir tane)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'Web sitesi ana bilgisayar adınızı takip eden / ile başlayan URL parçaları (her satıra bir tane)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'Beyaz listeye alınacak user agent dizeleri (her satıra bir tane)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Bad Behaviour ayarları güncellendi',
	'BbLogRequest'				=> 'HTTP isteğini kaydet',
	'BbLogVerbose'				=> 'Ayrıntılı',
	'BbLogNormal'				=> 'Normal (önerilen)',
	'BbLogOff'					=> 'Kaydetme (önerilmez)',
	'BbSecurity'				=> 'Güvenlik',
	'BbStrict'					=> 'Sıkı denetim',
	'BbStrictInfo'				=> 'daha fazla spam engeller ancak bazı kişileri de engelleyebilir',
	'BbOffsiteForms'			=> 'Diğer web sitelerinden form gönderimine izin ver',
	'BbOffsiteFormsInfo'		=> 'OpenID için gerekli; alınan spam miktarını artırır',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Bad Behaviour\'ın http:BL özelliklerini kullanmak için bir %1 sahibi olmalısınız',
	'BbHttpblKey'				=> 'http:BL Erişim Anahtarı',
	'BbHttpblThreat'			=> 'Minimum Tehdit Seviyesi (25 önerilir)',
	'BbHttpblMaxage'			=> 'Veri Maksimum Yaşı (30 önerilir)',
	'BbReverseProxy'			=> 'Ters Proxy/Yük Dengeleyici',
	'BbReverseProxyInfo'		=> 'Bad Behaviour\'ı ters proxy, yük dengeleyici, HTTP hızlandırıcı, içerik önbelleği veya benzeri bir teknoloji arkasında kullanıyorsanız, Ters Proxy seçeneğini etkinleştirin.<br>' .
	'Eğer sunucunuz ile genel İnternet arasında iki veya daha fazla ters proxy zinciri varsa, tüm proxy sunucularınızın, yük dengeleyicilerinizin vb. IP adres aralıklarını (CIDR formatında) <em>tümü</em> olarak belirtmelisiniz. Aksi takdirde Bad Behaviour istemcinin gerçek IP adresini belirleyemeyebilir.<br>' .
	'Ayrıca ters proxy sunucularınız, isteği aldıkları İnternet istemcisinin IP adresini bir HTTP başlığında ayarlamalıdır. Bir başlık belirtmezseniz %1 kullanılacaktır. Çoğu proxy sunucusu zaten X-Forwarded-For destekler ve yalnızca proxy sunucularınızda bunun etkin olduğundan emin olmanız gerekir. Yaygın kullanılan diğer başlık adları %2 ve %3 olabilir.',
	'BbReverseProxyEnable'		=> 'Ters Proxy\'yi Etkinleştir',
	'BbReverseProxyHeader'		=> 'İnternet istemcisinin IP adresini içeren başlık',
	'BbReverseProxyAddresses'	=> 'Proxy sunucularınız için IP adresi veya CIDR formatında adres aralıkları (her satıra bir tane)',

];
