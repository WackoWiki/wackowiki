<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'tr',
'LangLocale'	=> 'tr_TR',
'LangName'		=> 'Turkish',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'Category',
	'groups_page'		=> 'Groups',
	'users_page'		=> 'Users',
	'tools_page'		=> 'Araçlar',

	'search_page'		=> 'Ara',
	'login_page'		=> 'Login',
	'account_page'		=> 'Ayarlar',
	'registration_page'	=> 'Registration',
	'password_page'		=> 'Şifre',

	'whatsnew_page'		=> 'WhatsNew',
	'changes_page'		=> 'RecentChanges',
	'comments_page'		=> 'RecentlyCommented',
	'index_page'		=> 'PageIndex',

	'random_page'		=> 'RandomPage',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki Kurulumu',
'TitleUpdate'					=> 'WackoWiki Güncellemesi',
'Continue'						=> 'Devam',
'Back'							=> 'Geri',
'Recommended'					=> 'önerilen',
'InvalidAction'					=> 'Geçersiz işlem',

/*
   Locking Check
 */
'LockAuthorization'				=> 'Yetkilendirme',
'LockAuthorizationInfo'			=> 'Lütfen %1 dosyasına kaydettiğiniz parolayı girin.',
'LockPassword'					=> 'Şifre:',
'LockLogin'						=> 'Giriş',
'LockPasswordInvalid'			=> 'Geçersiz şifre.',
'LockedTryLater'				=> 'Bu site şu anda yükseltme işlemi altında. Lütfen daha sonra tekrar deneyin.',
'EmptyAuthFile'					=> 'Eksik veya boş %1 dosyası. Lütfen dosyayı oluşturun ve içine bir parola yazın.',


/*
   Language Selection Page
*/
'lang'							=> 'Dil Yapılandırması',
'PleaseUpgradeToR6'				=> 'Görünüşe göre eski bir WackoWiki sürümü (%1) kullanıyorsunuz. Bu sürüme yükseltme yapmak için önce kurulumunuzu %2 sürümüne güncellemeniz gerekir.',
'UpgradeFromWacko'				=> 'WackoWiki\'ye hoş geldiniz! Görünüşe göre WackoWiki %1 sürümünden %2 sürümüne yükseltiyorsunuz. Aşağıdaki sayfalar sizi yükseltme sürecinde yönlendirecek.',
'FreshInstall'					=> 'WackoWiki\'ye hoş geldiniz! WackoWiki %1 sürümünü kurmak üzeresiniz. Aşağıdaki sayfalar kurulum sürecinde size rehberlik edecek.',
'PleaseBackup'					=> 'Lütfen güncelleme işlemine başlamadan önce veritabanınızı, yapılandırma dosyanızı ve yerel düzeltmeler veya yamalar uygulanmış tüm değiştirilmiş dosyaları <strong>yedekleyin</strong>. Bu size büyük bir baş ağrısından kurtarabilir.',
'LangDesc'						=> 'Kurulum işlemi için bir dil seçin. Bu dil, WackoWiki kurulumunuzun varsayılan dili olarak kullanılacaktır.',

/*
   System Requirements Page
*/
'version-check'					=> 'Sistem Gereksinimleri',
'PhpVersion'					=> 'PHP Sürümü',
'PhpDetected'					=> 'Algılanan PHP',
'ModRewrite'					=> 'Apache Rewrite Uzantısı (İsteğe bağlı)',
'ModRewriteInstalled'			=> 'Rewrite Uzantısı (mod_rewrite) Yüklü mü?',
'Database'						=> 'Veritabanı',
'PhpExtensions'					=> 'PHP Eklentileri',
'Permissions'					=> 'İzinler',
'ReadyToInstall'				=> 'Kuruluma Hazır mısınız?',
'Requirements'					=> 'Sunucunuzun aşağıda listelenen gereksinimleri karşılaması gerekir.',
'OK'							=> 'Tamam',
'Problem'						=> 'Sorun',
'Example'						=> 'Örnek',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'PHP kurulumunuz, WackoWiki tarafından gereken belirtilen PHP eklentilerinden yoksun görünüyor.',
'PcreWithoutUtf8'				=> 'PCRE, UTF-8 desteği ile derlenmemiş.',
'NotePermissions'				=> 'Bu yükleyici yapılandırma verilerini WackoWiki dizininizde bulunan %1 dosyasına yazmaya çalışacaktır. Bunun çalışması için web sunucusunun bu dosyaya yazma iznine sahip olduğundan emin olmalısınız. Bunu yapamazsanız dosyayı elle düzenlemeniz gerekecektir (yükleyici nasıl yapacağınızı söyleyecektir).<br><br>Detaylar için bkz. <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'ErrorPermissions'				=> 'Görünüşe göre yükleyici WackoWiki\'nin doğru çalışması için gereken dosya izinlerini otomatik olarak ayarlayamıyor. Kurulum sürecinin ilerleyen adımlarında sizden sunucunuzda gerekli dosya izinlerini elle yapılandırmanız istenecek.',
'ErrorMinPhpVersion'			=> 'PHP sürümü %1 veya daha yeni olmalıdır. Sunucunuz daha eski bir sürüm çalıştırıyor gibi görünüyor. WackoWiki\'nin düzgün çalışması için PHP\'yi daha yeni bir sürüme yükseltmelisiniz.',
'Ready'							=> 'Tebrikler, sunucunuzun WackoWiki çalıştırmaya uygun olduğu görülüyor. Bir sonraki sayfalar sizi yapılandırma sürecinde yönlendirecek.',

/*
   Site Config Page
*/
'config-site'					=> 'Site Yapılandırması',
'SiteName'						=> 'Wiki Adı',
'SiteNameDesc'					=> 'Lütfen Wiki sitenizin adını girin.',
'SiteNameDefault'				=> 'BenimWikiSitem',
'HomePage'						=> 'Ana Sayfa',
'HomePageDesc'					=> 'Ana sayfanızın almasını istediğiniz ismi girin. Bu, ziyaretçilerinizin siteye girdiklerinde göreceği varsayılan sayfa olacak ve bir <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="Yardımı Gör" target="_blank">WikiName</a> olmalıdır.',
'HomePageDefault'				=> 'AnaSayfa',
'MultiLang'						=> 'Çok Dilli Mod',
'MultiLangDesc'					=> 'Çok dilli mod, tek bir kurulum içinde farklı dil ayarlarına sahip sayfalara izin verir. Bu mod etkinleştirilirse, yükleyici dağıtımdaki tüm diller için başlangıç menü öğeleri oluşturur.',
'AllowedLang'					=> 'İzin Verilen Diller',
'AllowedLangDesc'				=> 'Kullanmak istediğiniz dil setini seçmeniz önerilir; aksi halde tüm diller seçili olacaktır.',
'AclMode'						=> 'Varsayılan ACL ayarları',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Genel Wiki (okuma herkes için, yazma ve yorum yapma kayıtlı kullanıcılar için)',
'PrivateWiki'					=> 'Özel Wiki (okuma, yazma, yorum yalnızca kayıtlı kullanıcılar için)',
'Admin'							=> 'Yönetici Adı',
'AdminDesc'						=> 'Yönetici kullanıcı adını girin. Bu bir <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="Yardımı Gör" target="_blank">WikiName</a> olmalıdır (örn. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Kullanıcı adı %1 ile %2 karakter arasında olmalı ve yalnızca alfanümerik karakterler içermelidir. Büyük harf kullanılabilir.',
'NameCamelCaseOnly'				=> 'Kullanıcı adı %1 ile %2 karakter arasında olmalı ve WikiName formatında olmalıdır.',
'Password'						=> 'Yönetici Parolası',
'PasswordDesc'					=> 'Yönetici için en az %1 karakter uzunluğunda bir parola seçin.',
'PasswordConfirm'				=> 'Parolayı Tekrar Girin:',
'Mail'							=> 'Yönetici E-posta Adresi',
'MailDesc'						=> 'Yöneticinin e-posta adresini girin.',
'Base'							=> 'Temel URL',
'BaseDesc'						=> 'WackoWiki sitenizin temel URL\'si. Sayfa isimleri buna eklenecek, bu yüzden mod_rewrite kullanıyorsanız adresin sonunda eğik çizgi (/) olmalıdır, örneğin',
'Rewrite'						=> 'Yeniden Yazma Modu',
'RewriteDesc'					=> 'WackoWiki\'yi URL yeniden yazma ile kullanıyorsanız yeniden yazma modu etkin olmalıdır.',
'Enabled'						=> 'Etkin:',
'ErrorAdminEmail'				=> 'Geçersiz bir e-posta adresi girdiniz!',
'ErrorAdminPasswordMismatch'	=> 'Parolalar eşleşmiyor!',
'ErrorAdminPasswordShort'		=> 'Yönetici parolası çok kısa! Minimum uzunluk %1 karakterdir.',
'ModRewriteStatusUnknown'		=> 'Yükleyici mod_rewrite\'ın etkin olup olmadığını doğrulayamadı. Ancak bu, mod_rewrite\'ın devre dışı olduğu anlamına gelmez.',

/*
   Database Config Page
*/
'config-database'				=> 'Veritabanı Yapılandırması',
'DbDriver'						=> 'Sürücü',
'DbDriverDesc'					=> 'Kullanmak istediğiniz veritabanı sürücüsü.',
'DbSqlMode'						=> 'SQL modu',
'DbSqlModeDesc'					=> 'Kullanmak istediğiniz SQL modu.',
'DbVendor'						=> 'Sağlayıcı',
'DbVendorDesc'					=> 'Kullandığınız veritabanı sağlayıcısı.',
'DbCharset'						=> 'Karakter Seti',
'DbCharsetDesc'					=> 'Kullanmak istediğiniz veritabanı karakter seti.',
'DbEngine'						=> 'Motor',
'DbEngineDesc'					=> 'Kullanmak istediğiniz veritabanı motoru.',
'DbHost'						=> 'Sunucu',
'DbHostDesc'					=> 'Veritabanı sunucunuzun çalıştığı host, genellikle <code>127.0.0.1</code> veya <code>localhost</code> (yani WackoWiki sitenizin bulunduğu makine).',
'DbPort'						=> 'Port (İsteğe bağlı)',
'DbPortDesc'					=> 'Veritabanı sunucunuza erişilen port numarası. Varsayılan portu kullanmak için boş bırakın.',
'DbName'						=> 'Veritabanı Adı',
'DbNameDesc'					=> 'WackoWiki\'nin kullanacağı veritabanı. Devam etmeden önce bu veritabanının zaten var olması gerekir!',
'DbNameSqliteDesc'				=> 'WackoWiki için SQLite\'ın kullanacağı veri dizini ve dosya adı.',
'DbNameSqliteHelp'				=> 'SQLite tüm verileri tek bir dosyada depolar.<br><br>Sağladığınız dizin, kurulum sırasında web sunucusu tarafından yazılabilir olmalıdır.<br><br>Bu dizin <strong>web üzerinden erişilebilir</strong> olmamalıdır.<br><br>Yükleyici bununla birlikte bir <code>.htaccess</code> dosyası yazacaktır; fakat bu başarısız olursa biri ham veritabanınıza erişebilir.<br>Bu, ham kullanıcı verilerini (e-posta adresleri, hashlenmiş parolalar) ve korunmuş sayfalar ile diğer kısıtlı wiki verilerini içerir.<br><br>Veritabanını tamamen başka bir yere koymayı düşünün, örn. <code>/var/lib/wackowiki/yourwiki</code>.',
'DbUser'						=> 'Kullanıcı Adı',
'DbUserDesc'					=> 'Veritabanına bağlanmak için kullanılacak kullanıcı adı.',
'DbPassword'					=> 'Şifre',
'DbPasswordDesc'				=> 'Veritabanına bağlanmak için kullanılacak kullanıcının şifresi.',
'Prefix'						=> 'Tablo Öneki',
'PrefixDesc'					=> 'WackoWiki tarafından kullanılacak tüm tabloların öneki. Bu, aynı veritabanında farklı tablo önekleri kullanarak birden fazla WackoWiki kurulumu çalıştırmanızı sağlar (örn. wacko_).',
'ErrorNoDbDriverDetected'		=> 'Hiçbir veritabanı sürücüsü algılanmadı, lütfen php.ini dosyanızda mysqli veya pdo_mysql uzantısını etkinleştirin.',
'ErrorNoDbDriverSelected'		=> 'Hiçbir veritabanı sürücüsü seçilmedi, lütfen listeden birini seçin.',
'DeleteTables'					=> 'Mevcut Tablolar Silinsin mi?',
'DeleteTablesDesc'				=> 'DİKKAT! Bu seçeneği işaretleyip devam ederseniz, veritabanınızdaki mevcut wiki verilerinin tamamı silinecektir. Bu geri alınamaz ve verileri bir yedekten elle geri yüklemeniz gerekecektir.',
'ConfirmTableDeletion'			=> 'Mevcut tüm wiki tablolarını silmek istediğinizden emin misiniz?',

/*
   Database Installation Page
*/
'install-database'				=> 'Veritabanı Kurulumu',
'TestingConfiguration'			=> 'Yapılandırma Test Ediliyor',
'TestConnectionString'			=> 'Veritabanı bağlantı ayarları test ediliyor',
'TestDatabaseExists'			=> 'Belirttiğiniz veritabanının varlığı kontrol ediliyor',
'TestDatabaseVersion'			=> 'Veritabanı için minimum sürüm gereksinimleri kontrol ediliyor',
'SqliteFileExtensionError'		=> 'Lütfen db, sdb veya sqlite dosya uzantılarından birini kullanın.',
'SqliteParentUnwritableGroup'	=> 'Veri dizini <code>%1</code> oluşturulamıyor, çünkü üst dizin <code>%2</code> web sunucusu tarafından yazılabilir değil.<br><br>Yükleyici web sunucunuzun hangi kullanıcı olarak çalıştığını belirledi.<br>Devam etmek için <code>%3</code> dizinini bu kullanıcıya yazılabilir kılın.<br>Unix/Linux sistemlerde şunu yapın:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> 'Veri dizini <code>%1</code> oluşturulamıyor, çünkü üst dizin <code>%2</code> web sunucusu tarafından yazılabilir değil.<br><br>Yükleyici web sunucunuzun hangi kullanıcı olarak çalıştığını belirleyemedi.<br>Devam etmek için <code>%3</code> dizinini herkes için yazılabilir yapın.<br>Unix/Linux sistemlerde şunu yapın:<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> 'Veri dizini <code>%1</code> oluşturulurken hata oluştu.<br>Konumu kontrol edin ve tekrar deneyin.',
'SqliteDirUnwritable'			=> '<code>%1</code> dizinine yazılamıyor.<br>Web sunucusunun yazabilmesi için izinlerini değiştirin ve tekrar deneyin.',
'SqliteReadonly'				=> '<code>%1</code> dosyası yazılabilir değil.',
'SqliteCantCreateDb'			=> '<code>%1</code> veritabanı dosyası oluşturulamadı.',
'InstallTables'					=> 'Tablolar Yükleniyor',
'ErrorDbConnection'				=> 'Belirttiğiniz veritabanı bağlantı bilgileriyle ilgili bir sorun var, lütfen geri gidip doğruluğunu kontrol edin.',
'ErrorDatabaseVersion'			=> 'Veritabanı sürümü %1, ancak en az %2 gerekmektedir.',
'To'							=> 'ile',
'AlterTable'					=> '%1 tablosu değiştiriliyor',
'InsertRecord'					=> '%1 tablosuna kayıt ekleniyor',
'RenameTable'					=> '%1 tablosu yeniden adlandırılıyor',
'UpdateTable'					=> '%1 tablosu güncelleniyor',
'InstallDefaultData'			=> 'Varsayılan Veriler Ekleniyor',
'InstallPagesBegin'				=> 'Varsayılan Sayfalar Ekleniyor',
'InstallPagesEnd'				=> 'Varsayılan Sayfaların Eklenmesi Tamamlandı',
'InstallSystemAccount'			=> '<code>System</code> Kullanıcısı ekleniyor',
'InstallDeletedAccount'			=> '<code>Deleted</code> Kullanıcısı ekleniyor',
'InstallAdmin'					=> 'Yönetici Kullanıcısı ekleniyor',
'InstallAdminSetting'			=> 'Yönetici Kullanıcı Tercihleri ekleniyor',
'InstallAdminGroup'				=> 'Yöneticiler Grubu ekleniyor',
'InstallAdminGroupMember'		=> 'Yöneticiler Grubuna Üye ekleniyor',
'InstallEverybodyGroup'			=> 'Herkes Grubu ekleniyor',
'InstallModeratorGroup'			=> 'Moderatör Grubu ekleniyor',
'InstallReviewerGroup'			=> 'İnceleyici Grubu ekleniyor',
'InstallLogoImage'				=> 'Logo Görseli ekleniyor',
'LogoImage'						=> 'Logo görseli',
'InstallConfigValues'			=> 'Yapılandırma Değerleri ekleniyor',
'ConfigValues'					=> 'Yapılandırma Değerleri',
'ErrorInsertPage'				=> '%1 sayfası eklenirken hata oluştu',
'ErrorInsertPagePermission'		=> '%1 sayfası için izin ayarlanırken hata oluştu',
'ErrorInsertDefaultMenuItem'	=> '%1 sayfası varsayılan menü öğesi olarak ayarlanırken hata oluştu',
'ErrorPageAlreadyExists'		=> '%1 sayfası zaten var',
'ErrorAlterTable'				=> '%1 tablosu değiştirilirken hata oluştu',
'ErrorInsertRecord'				=> '%1 tablosuna kayıt eklenirken hata oluştu',
'ErrorRenameTable'				=> '%1 tablosu yeniden adlandırılırken hata oluştu',
'ErrorUpdatingTable'			=> '%1 tablosu güncellenirken hata oluştu',
'CreatingTable'					=> '%1 tablosu oluşturuluyor',
'CreatingIndex'					=> '%1 indeksi oluşturuluyor',
'CreatingTrigger'				=> '%1 tetikleyicisi oluşturuluyor',
'ErrorAlreadyExists'			=> '%1 zaten mevcut',
'ErrorCreatingTable'			=> '%1 tablosu oluşturulurken hata oluştu, zaten mevcut mu diye kontrol edin?',
'ErrorCreatingIndex'			=> '%1 indeksi oluşturulurken hata oluştu, zaten mevcut mu diye kontrol edin?',
'ErrorCreatingTrigger'			=> '%1 tetikleyicisi oluşturulurken hata oluştu, zaten mevcut mu diye kontrol edin?',
'DeletingTables'				=> 'Tablolar Siliniyor',
'DeletingTablesEnd'				=> 'Tabloların Silinmesi Tamamlandı',
'ErrorDeletingTable'			=> '%1 tablosu silinirken hata oluştu. Muhtemel neden tabloyun mevcut olmamasıdır; bu durumda bu uyarıyı göz ardı edebilirsiniz.',
'DeletingTable'					=> '%1 tablosu siliniyor',
'NextStep'						=> 'Bir sonraki adımda yükleyici güncellenmiş yapılandırma dosyası %1 dosyasını yazmaya çalışacaktır. Lütfen web sunucusunun bu dosyaya yazma izni olduğundan emin olun; aksi halde dosyayı elle düzenlemeniz gerekecektir. Detaylar için tekrar bkz. <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',

/*
   Write Config Page
*/
'write-config'					=> 'Yapılandırma Dosyasını Yaz',
'FinalStep'						=> 'Son Adım',
'Writing'						=> 'Yapılandırma Dosyası Yazılıyor',
'RemovingWritePrivilege'		=> 'Yazma İzninin Kaldırılması',
'InstallationComplete'			=> 'Kurulum Tamamlandı',
'ThatsAll'						=> 'Hepsi bu kadar! Artık <a href="%1">WackoWiki sitenizi görüntüleyebilirsiniz</a>.',
'SecurityConsiderations'		=> 'Güvenlik Dikkatleri',
'SecurityRisk'					=> '%1 dosyası yazıldıktan sonra ona yazma erişimini kaldırmanız önerilir. Dosyayı yazılabilir bırakmak güvenlik riski oluşturabilir!<br>Örnek: %2',
'RemoveSetupDirectory'			=> 'Kurulum işlemi tamamlandıktan sonra %1 dizinini silmelisiniz.',
'ErrorGivePrivileges'			=> 'Yapılandırma dosyası %1 yazılamadı. Web sunucunuza geçici olarak WackoWiki dizinine veya %1 adında boş bir dosyaya yazma izni vermeniz gerekecek<br>%2.<br><br>Sonrasında yazma iznini tekrar kaldırmayı unutmayın, örn. <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Herhangi bir nedenle bunu yapamıyorsanız, aşağıdaki metni yeni bir dosyaya kopyalayıp WackoWiki dizinine %1 adıyla kaydetmeniz/yüklemeniz gerekecektir. Bunu yaptıktan sonra WackoWiki siteniz çalışmalıdır. Eğer çalışmazsa, lütfen <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> sayfasını ziyaret edin.',
'ErrorPrivilegesUpgrade'		=> 'Bunu yaptıktan sonra WackoWiki siteniz çalışmalıdır. Eğer çalışmazsa, lütfen <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a> sayfasını ziyaret edin.',
'WrittenAt'						=> 'yazıldı:',
'DontChange'					=> 'wacko_version bilgisini elle değiştirmeyin!',
'ConfigDescription'				=> 'ayrıntılı açıklama: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Tekrar Deneyin',

];
