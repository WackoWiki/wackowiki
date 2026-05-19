<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Fungsi dasar',
		'preferences'	=> 'Preferensi',
		'content'		=> 'Konten',
		'users'			=> 'Pengguna',
		'maintenance'	=> 'Pemeliharaan',
		'messages'		=> 'Pesan',
		'extension'		=> 'Ekstensi',
		'database'		=> 'Basis data',
	],

	// Admin panel
	'AdminPanel'				=> 'Panel Administrator',
	'RecoveryMode'				=> 'Mode Pemulihan',
	'Authorization'				=> 'Otorisasi',
	'AuthorizationTip'			=> 'Silakan masukkan kata sandi administratif (pastikan bahwa kuki diizinkan di peramban).',
	'NoRecoveryPassword'		=> 'Kata sandi administratif tidak ada!',
	'NoRecoveryPasswordTip'		=> 'Catatan: Absennya kata sandi administratif merupakan ancaman keamanan! Silakan masukkan hash kata sandi di berkas konfigurasi dan jalankan progam kembali.',

	'ErrorLoadingModule'		=> 'Tidak dapat memuat modul admin %1: tidak ada.',

	'ApHomePage'				=> 'Halaman Beranda',
	'ApHomePageTip'				=> 'Keluar dari panel administrator dan buka halaman beranda',
	'ApLogOut'					=> 'Log keluar',
	'ApLogOutTip'				=> 'Keluar dari administrator sistem dan log keluar dari situs',

	'TimeLeft'					=> 'Waktu tersisa: %1 menit',
	'ApVersion'					=> 'versi',

	'SiteOpen'					=> 'Buka',
	'SiteOpened'				=> 'situs terbuka',
	'SiteOpenedTip'				=> 'Situs ini terbuka',
	'SiteClose'					=> 'Tutup',
	'SiteClosed'				=> 'situs ditutup',
	'SiteClosedTip'				=> 'Situs ini ditutup',

	'System'					=> 'Sistem',

	// Generic
	'Cancel'					=> 'Batal',
	'Add'						=> 'Tambah',
	'Edit'						=> 'Sunting',
	'Remove'					=> 'Hapus',
	'Enabled'					=> 'Diaktifkan',
	'Disabled'					=> 'Dinonaktifkan',
	'Mandatory'					=> 'Wajib',
	'Admin'						=> 'Pengurus',
	'Min'						=> 'Minimal',
	'Max'						=> 'Maksimal',

	'MiscellaneousSection'		=> 'Lain-lain',
	'MainSection'				=> 'Opsi Umum',

	'DirNotWritable'			=> 'Direktori %1 tidak dapat ditulis.',
	'FileNotWritable'			=> 'Berkas %1 tidak dapat ditulis.',

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
		'name'		=> 'Dasar',
		'title'		=> 'Pengaturan dasar',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Tampilan',
		'title'		=> 'Pengaturan tampilan',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Surel',
		'title'		=> 'Pengaturan surel',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Sindikasi',
		'title'		=> 'Pengaturan sindikasi',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Sortir',
		'title'		=> 'Pengaturan sortir',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Pemformatan',
		'title'		=> 'Opsi pemformatan',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Pemberitahuan',
		'title'		=> 'Setelan pemberitahuan',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Halaman',
		'title'		=> 'Parameter situs dan halaman',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Hak akses',
		'title'		=> 'Pengaturan hak akses',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Keamanan',
		'title'		=> 'Pengaturan keamanan subsistem',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Sistem',
		'title'		=> 'Opsi sistem',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Unggah',
		'title'		=> 'Pengaturan lampiran',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Dihapus',
		'title'		=> 'Konten dihapus baru-baru ini',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Tambah, sunting, atau hapus item bawaan menu',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Cadangan',
		'title'		=> 'Mencadangkan data',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Perbaikan',
		'title'		=> 'Perbaikan dan Optimisasi Basis data',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Kembalikan',
		'title'		=> 'Pulihkan cadangan data',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Menu Utama',
		'title'		=> 'Administrasi WackoWiki',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inkonsistensi',
		'title'		=> 'Perbaiki Inkonsistensi Data',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Sinkronisasi Data',
		'title'		=> 'Menyinkronisasikan data',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Surel massal',
		'title'		=> 'Surel massal',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Pesan sistem',
		'title'		=> 'Pesan sistem',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Info Sistem',
		'title'		=> 'Informasi Sistem',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Log Sistem',
		'title'		=> 'Log peristiwa sistem',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Statistik',
		'title'		=> 'Tampilkan statistik',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Perilaku Buruk',
		'title'		=> 'Perilaku Buruk',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Setujui',
		'title'		=> 'Persetujuan registrasi pengguna',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Kelompok',
		'title'		=> 'Manajemen kelompok',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Pengguna',
		'title'		=> 'Manajemen pengguna',
	],

	// Main module
	'MainNote'					=> 'Catatan: Sangat disarankan untuk memblokir sementara akses ke situs untuk pemeliharaan.',

	'PurgeSessions'				=> 'Bersihkan',
	'PurgeSessionsTip'			=> 'Bersihkan semua sesi',
	'PurgeSessionsConfirm'		=> 'Apakah Anda yakin untuk membersihkan semua sesi? Ini akan mengeluarkan semua pengguna.',
	'PurgeSessionsExplain'		=> 'Bersihkan semua sesi. Tindakan ini akan mengeluarkan semua pengguna dengan menghapus tabel auth_token.',
	'PurgeSessionsDone'			=> 'Sesi berhasil dibersihkan.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Pengaturan dasar yang diperbaharui',
	'LogBasicSettingsUpdated'	=> 'Pengaturan dasar yang diperbaharui',

	'SiteName'					=> 'Nama situs:',
	'SiteNameInfo'				=> 'Judul situs. Ini akan tampil pada judul peramban, kepala tema, surel notifikasi, dan lainnya.',
	'SiteDesc'					=> 'Deskripsi situs:',
	'SiteDescInfo'				=> 'Tambahan untuk judul situs yang muncul di header halaman. Menjelaskan, dalam beberapa kata, tentang apa situs ini.',
	'AdminName'					=> 'Pengurus situs:',
	'AdminNameInfo'				=> 'Nama pengguna individu yang bertanggung jawab atas dukungan keseluruhan situs. Nama ini tidak digunakan untuk menentukan hak akses, tetapi sebaiknya sesuai dengan nama administrator utama situs.',

	'LanguageSection'			=> 'Bahasa',
	'DefaultLanguage'			=> 'Bahasa bawaan:',
	'DefaultLanguageInfo'		=> 'Menentukan bahasa pesan yang ditampilkan kepada pengguna anonim, serta pengaturan lokal.',
	'MultiLanguage'				=> 'Dukungan multibahasa:',
	'MultiLanguageInfo'			=> 'Aktifkan kemampuan untuk memilih bahasa berdasarkan halaman per halaman.',
	'AllowedLanguages'			=> 'Bahasa yang diizinkan:',
	'AllowedLanguagesInfo'		=> 'Disarankan untuk memilih hanya serangkaian bahasa yang ingin Anda gunakan, jika tidak, semua bahasa akan dipilih.',

	'CommentSection'			=> 'Bagian Komentar',
	'AllowComments'				=> 'Izinkan komentar:',
	'AllowCommentsInfo'			=> 'Aktifkan komentar hanya untuk pengguna anonim atau pengguna terdaftar, atau nonaktifkan komentar di seluruh situs.',
	'SortingComments'			=> 'Pengurutan komentar:',
	'SortingCommentsInfo'		=> 'Mengubah urutan komentar halaman yang ditampilkan, baik dengan komentar terbaru atau komentar terlama di bagian atas.',
	'CommentsOffset'			=> 'Halaman komentar:',
	'CommentsOffsetInfo'		=> 'Halaman komentar yang akan ditampilkan secara otomatis',

	'ToolbarSection'			=> 'Bilah Alat',
	'CommentsPanel'				=> 'Panel komentar:',
	'CommentsPanelInfo'			=> 'Tampilan default komentar di bagian bawah halaman.',
	'FilePanel'					=> 'Panel berkas:',
	'FilePanelInfo'				=> 'Tampilan default lampiran di bagian bawah halaman.',
	'TagsPanel'					=> 'Panel tag:',
	'TagsPanelInfo'				=> 'Tampilan default panel tag di bagian bawah halaman.',

	'NavigationSection'			=> 'Navigasi',
	'ShowPermalink'				=> 'Tampilkan tautan permanen:',
	'ShowPermalinkInfo'			=> 'Tampilan default tautan permanen untuk versi halaman saat ini.',
	'TocPanel'					=> 'Panel daftar isi:',
	'TocPanelInfo'				=> 'Tampilan default panel daftar isi halaman (mungkin memerlukan dukungan pada templat).',
	'SectionsPanel'				=> 'Panel bagian:',
	'SectionsPanelInfo'			=> 'Secara default, tampilkan panel halaman-halaman yang berdekatan (memerlukan dukungan pada templat).',
	'DisplayingSections'		=> 'Menampilkan bagian:',
	'DisplayingSectionsInfo'	=> 'Ketika opsi sebelumnya diatur, apakah hanya menampilkan subhalaman (bawah), hanya tetangga (atas), keduanya, atau lainnya (pohon).',
	'MenuItems'					=> 'Item menu:',
	'MenuItemsInfo'				=> 'Jumlah default item menu yang ditampilkan (mungkin memerlukan dukungan pada templat).',

	'HandlerSection'			=> 'Penangan',
	'HideRevisions'				=> 'Sembunyikan revisi:',
	'HideRevisionsInfo'			=> 'Tampilan default revisi halaman.',
	'AttachmentHandler'			=> 'Aktifkan penangan lampiran:',
	'AttachmentHandlerInfo'		=> 'Izinkan tampilan penangan lampiran.',
	'SourceHandler'				=> 'Aktifkan penangan sumber:',
	'SourceHandlerInfo'			=> 'Izinkan tampilan penangan sumber.',
	'ExportHandler'				=> 'Aktifkan penangan ekspor XML:',
	'ExportHandlerInfo'			=> 'Izinkan tampilan penangan ekspor XML.',

	'DiffModeSection'			=> 'Mode Pembandingan',
	'DefaultDiffModeSetting'	=> 'Mode pembandingan bawaan:',
	'DefaultDiffModeSettingInfo'=> 'Mode pembandingan yang dipilih sebelumnya.',
	'AllowedDiffMode'			=> 'Mode pembandingan yang diizinkan:',
	'AllowedDiffModeInfo'		=> 'Disarankan untuk hanya memilih set mode pembandingan yang ingin digunakan, jika tidak semua mode pembandingan akan dipilih.',
	'NotifyDiffMode'			=> 'Mode pembandingan notifikasi:',
	'NotifyDiffModeInfo'		=> 'Mode pembandingan yang digunakan untuk notifikasi dalam isi email.',

	'EditingSection'			=> 'Pengeditan',
	'EditSummary'				=> 'Ringkasan pengeditan:',
	'EditSummaryInfo'			=> 'Tampilkan ringkasan perubahan dalam mode pengeditan.',
	'MinorEdit'					=> 'Pengeditan kecil:',
	'MinorEditInfo'				=> 'Aktifkan opsi pengeditan kecil dalam mode pengeditan.',
	'SectionEdit'				=> 'Pengeditan bagian:',
	'SectionEditInfo'			=> 'Aktifkan pengeditan hanya bagian tertentu dari halaman.',
	'ReviewSettings'			=> 'Pengaturan tinjauan:',
	'ReviewSettingsInfo'		=> 'Aktifkan opsi tinjauan dalam mode pengeditan.',
	'PublishAnonymously'		=> 'Izinkan penerbitan anonim:',
	'PublishAnonymouslyInfo'	=> 'Izinkan pengguna untuk menerbitkan secara anonim (untuk menyembunyikan nama).',

	'DefaultRenameRedirect'		=> 'Saat mengganti nama, buat pengalihan:',
	'DefaultRenameRedirectInfo'	=> 'Secara default, tawarkan untuk membuat pengalihan ke alamat lama halaman yang diganti nama.',
	'StoreDeletedPages'			=> 'Simpan halaman yang dihapus:',
	'StoreDeletedPagesInfo'		=> 'Ketika Anda menghapus halaman, komentar, atau berkas, simpan dalam bagian khusus di mana akan tersedia untuk ditinjau dan dipulihkan untuk beberapa waktu (seperti dijelaskan di bawah).',
	'KeepDeletedTime'			=> 'Waktu penyimpanan halaman yang dihapus:',
	'KeepDeletedTimeInfo'		=> 'Periode dalam hari. Hanya berlaku dengan opsi sebelumnya. Gunakan nol untuk memastikan entitas tidak pernah dihapus (dalam hal ini administrator dapat membersihkan "keranjang" secara manual).',
	'PagesPurgeTime'			=> 'Waktu penyimpanan revisi halaman:',
	'PagesPurgeTimeInfo'		=> 'Secara otomatis menghapus versi lama dalam jumlah hari yang ditentukan. Jika Anda memasukkan nol, versi lama tidak akan dihapus.',
	'EnableReferrers'			=> 'Aktifkan referrer:',
	'EnableReferrersInfo'		=> 'Izinkan pembuatan dan tampilan referrer eksternal.',
	'ReferrersPurgeTime'		=> 'Waktu penyimpanan referrer:',
	'ReferrersPurgeTimeInfo'	=> 'Simpan riwayat halaman eksternal yang merujuk tidak lebih dari jumlah hari yang ditentukan. Gunakan nol untuk memastikan referrer tidak pernah dihapus (tetapi untuk situs yang sering dikunjungi, ini dapat menyebabkan kelebihan database).',
	'EnableCounters'			=> 'Penghitung kunjungan:',
	'EnableCountersInfo'		=> 'Izinkan penghitung kunjungan per halaman dan aktifkan tampilan statistik sederhana. Kunjungan oleh pemilik halaman tidak dihitung.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Kontrol pengaturan sindikasi web bawaan untuk situs Anda.',
	'SyndicationSettingsUpdated'	=> 'Pengaturan sindikasi diperbarui.',

	'FeedsSection'				=> 'Umpan',
	'EnableFeeds'				=> 'Aktifkan umpan:',
	'EnableFeedsInfo'			=> 'Mengaktifkan atau menonaktifkan umpan RSS untuk seluruh wiki.',
	'XmlChangeLink'				=> 'Mode tautan umpan perubahan:',
	'XmlChangeLinkInfo'			=> 'Menentukan ke mana tautan item umpan Perubahan XML mengarah.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'tampilan perbedaan',
		'2'		=> 'halaman yang direvisi',
		'3'		=> 'daftar revisi',
		'4'		=> 'halaman saat ini',
	],

	'XmlSitemap'				=> 'Peta situs XML:',
	'XmlSitemapInfo'			=> 'Membuat file XML bernama %1 di dalam folder xml. Anda dapat menambahkan jalur ke peta situs dalam file robots.txt di direktori root Anda sebagai berikut:',
	'XmlSitemapGz'				=> 'Kompresi peta situs XML:',
	'XmlSitemapGzInfo'			=> 'Jika Anda mau, Anda dapat mengompres file teks peta situs Anda menggunakan gzip untuk mengurangi kebutuhan bandwidth.',
	'XmlSitemapTime'			=> 'Waktu pembuatan peta situs XML:',
	'XmlSitemapTimeInfo'		=> 'Membuat peta situs hanya sekali dalam jumlah hari yang ditentukan. Setel ke nol untuk membuat setiap kali halaman berubah.',

	'SearchSection'				=> 'Pencarian',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Membuat file deskripsi OpenSearch di folder XML dan mengaktifkan Autodiscovery plugin pencarian di header HTML.',
	'SearchEngineVisibility'	=> 'Blokir mesin pencari (visibilitas mesin pencari):',
	'SearchEngineVisibilityInfo'=> 'Blokir mesin pencari, tetapi izinkan pengunjung normal. Mengabaikan pengaturan halaman.
Mencegah mesin pencari untuk mengindeks situs ini. Terserah mesin pencari untuk menghormati permintaan ini.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Kontrol pengaturan tampilan bawaan untuk situs Anda.',
	'AppearanceSettingsUpdated'	=> 'Pengaturan tampilan diperbarui.',

	'LogoOff'					=> 'Nonaktif',
	'LogoOnly'					=> 'hanya logo',
	'LogoAndTitle'				=> 'logo dan judul',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Logo situs:',
	'SiteLogoInfo'				=> 'Logo Anda biasanya akan muncul di sudut kiri atas aplikasi. Ukuran maksimal adalah 2 MiB. Dimensi optimal adalah lebar 255 piksel dan tinggi 55 piksel.',
	'LogoDimensions'			=> 'Dimensi logo:',
	'LogoDimensionsInfo'		=> 'Lebar dan tinggi logo yang ditampilkan.',
	'LogoDisplayMode'			=> 'Mode tampilan logo:',
	'LogoDisplayModeInfo'		=> 'Menentukan penampilan logo. Default adalah nonaktif.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Favicon situs:',
	'SiteFaviconInfo'			=> 'Ikon pintasan Anda, atau favicon, ditampilkan di bilah alamat, tab, dan bookmark sebagian besar browser. Ini akan menggantikan favicon tema Anda.',
	'SiteFaviconTooBig'			=> 'Favicon lebih besar dari 64 × 64 px.',
	'ThemeColor'				=> 'Warna tema untuk bilah alamat:',
	'ThemeColorInfo'			=> 'Browser akan mengatur warna bilah alamat setiap halaman sesuai dengan warna CSS yang diberikan.',

	'LayoutSection'				=> 'Tata letak',
	'Theme'						=> 'Tema:',
	'ThemeInfo'					=> 'Desain templat yang digunakan situs secara default.',
	'ResetUserTheme'			=> 'Reset semua tema pengguna:',
	'ResetUserThemeInfo'		=> 'Mengatur ulang semua tema pengguna. Peringatan: Tindakan ini akan mengembalikan semua tema yang dipilih pengguna ke tema default global.',
	'SetBackUserTheme'			=> 'Kembalikan semua tema pengguna ke tema %1.',
	'ThemesAllowed'				=> 'Tema yang diizinkan:',
	'ThemesAllowedInfo'			=> 'Pilih tema yang diizinkan yang dapat dipilih pengguna; jika tidak, semua tema yang tersedia diizinkan.',
	'ThemesPerPage'				=> 'Tema per halaman:',
	'ThemesPerPageInfo'			=> 'Izinkan tema per halaman, yang dapat dipilih pemilik halaman melalui properti halaman.',

	// System settings
	'SystemSettingsInfo'		=> 'Kelompok parameter yang bertanggung jawab untuk penyetelan halus situs. Jangan mengubahnya kecuali Anda yakin dengan tindakannya.',
	'SystemSettingsUpdated'		=> 'Pengaturan sistem diperbarui.',

	'DebugModeSection'			=> 'Mode Debug',
	'DebugMode'					=> 'Mode debug:',
	'DebugModeInfo'				=> 'Mengekstrak dan menampilkan data telemetri tentang waktu eksekusi aplikasi. Perhatian: Mode detail penuh membutuhkan memori yang lebih besar, terutama untuk operasi yang intensif sumber daya, seperti backup dan restore database.',
	'DebugModes'	=> [
		'0'		=> 'debugging nonaktif',
		'1'		=> 'hanya total waktu eksekusi',
		'2'		=> 'waktu penuh',
		'3'		=> 'detail penuh (DBMS, cache, dll.)',
	],
	'DebugSqlThreshold'			=> 'Ambang kinerja RDBMS:',
	'DebugSqlThresholdInfo'		=> 'Dalam mode debug detail, laporkan hanya query yang memakan waktu lebih lama dari jumlah detik yang ditentukan.',
	'DebugAdminOnly'			=> 'Diagnosis tertutup:',
	'DebugAdminOnlyInfo'		=> 'Tampilkan data debug program (dan DBMS) hanya untuk administrator.',

	'CachingSection'			=> 'Opsi Cache',
	'Cache'						=> 'Cache halaman yang dirender:',
	'CacheInfo'					=> 'Simpan halaman yang telah dirender dalam cache lokal untuk mempercepat pemuatan berikutnya. Hanya berlaku untuk pengunjung yang belum terdaftar.',
	'CacheTtl'					=> 'Waktu hidup untuk halaman cache:',
	'CacheTtlInfo'				=> 'Cache halaman tidak lebih dari jumlah detik yang ditentukan.',
	'CacheSql'					=> 'Cache query DBMS:',
	'CacheSqlInfo'				=> 'Pertahankan cache lokal dari hasil query SQL tertentu yang terkait dengan sumber daya.',
	'CacheSqlTtl'				=> 'Waktu hidup untuk cache query SQL:',
	'CacheSqlTtlInfo'			=> 'Cache hasil query SQL tidak lebih dari jumlah detik yang ditentukan. Nilai lebih dari 1200 tidak diinginkan.',

	'LogSection'				=> 'Pengaturan Log',
	'LogLevelUsage'				=> 'Gunakan pencatatan:',
	'LogLevelUsageInfo'			=> 'Tingkat prioritas minimum dari peristiwa yang dicatat dalam log.',
	'LogThresholds'	=> [
		'0'		=> 'jangan menyimpan jurnal',
		'1'		=> 'hanya tingkat kritis',
		'2'		=> 'dari tingkat tertinggi',
		'3'		=> 'dari tingkat tinggi',
		'4'		=> 'tingkat sedang',
		'5'		=> 'dari tingkat rendah',
		'6'		=> 'dari tingkat minimum',
		'7'		=> 'catat semua',
	],
	'LogDefaultShow'			=> 'Mode tampilan log bawaan:',
	'LogDefaultShowInfo'		=> 'Tingkat prioritas minimum peristiwa yang ditampilkan dalam log secara default.',
	'LogModes'	=> [
		'1'		=> 'hanya tingkat kritis',
		'2'		=> 'dari tingkat tertinggi',
		'3'		=> 'dari tingkat tinggi',
		'4'		=> 'tingkat sedang',
		'5'		=> 'dari tingkat rendah',
		'6'		=> 'dari tingkat minimum',
		'7'		=> 'tampilkan semua',
	],
	'LogPurgeTime'				=> 'Waktu penyimpanan log:',
	'LogPurgeTimeInfo'			=> 'Hapus log peristiwa setelah jumlah hari yang ditentukan.',

	'PrivacySection'			=> 'Privasi',
	'AnonymizeIp'				=> 'Anonimkan alamat IP pengguna:',
	'AnonymizeIpInfo'			=> 'Anonimkan alamat IP jika berlaku (misalnya pada halaman, revisi atau referrer).',

	'ReverseProxySection'		=> 'Reverse Proxy',
	'ReverseProxy'				=> 'Gunakan reverse proxy:',
	'ReverseProxyInfo'			=> 'Aktifkan pengaturan ini untuk menentukan alamat IP yang benar dari klien jarak jauh dengan memeriksa informasi yang disimpan dalam header X-Forwarded-For. Header X-Forwarded-For adalah mekanisme standar untuk mengidentifikasi sistem klien yang terhubung melalui server reverse proxy, seperti Squid atau Pound. Server reverse proxy sering digunakan untuk meningkatkan kinerja situs yang banyak dikunjungi dan juga dapat memberikan manfaat caching, keamanan atau enkripsi lainnya. Jika instalasi WackoWiki ini beroperasi di belakang reverse proxy, pengaturan ini harus diaktifkan agar informasi alamat IP yang benar ditangkap dalam sistem manajemen sesi, pencatatan, statistik dan kontrol akses WackoWiki; jika Anda tidak yakin tentang pengaturan ini, tidak memiliki reverse proxy, atau WackoWiki beroperasi dalam lingkungan shared hosting, pengaturan ini harus tetap dinonaktifkan.',
	'ReverseProxyHeader'		=> 'Header reverse proxy:',
	'ReverseProxyHeaderInfo'	=> 'Atur nilai ini jika server proxy Anda mengirim IP klien dalam header selain X-Forwarded-For. Header "X-Forwarded-For" adalah daftar alamat IP yang dipisahkan koma; hanya yang terakhir (paling kiri) yang akan digunakan.',
	'ReverseProxyAddresses'		=> 'reverse_proxy menerima array alamat IP:',
	'ReverseProxyAddressesInfo'	=> 'Setiap elemen array ini adalah alamat IP dari reverse proxy Anda. Jika menggunakan array ini, WackoWiki akan mempercayai informasi yang disimpan dalam header X-Forwarded-For hanya jika alamat IP Remote adalah salah satunya, yaitu permintaan mencapai server web dari salah satu reverse proxy Anda. Jika tidak, klien dapat langsung terhubung ke server web Anda dengan memalsukan header X-Forwarded-For.',

	'SessionSection'				=> 'Penanganan Sesi',
	'SessionStorage'				=> 'Penyimpanan sesi:',
	'SessionStorageInfo'			=> 'Opsi ini menentukan di mana data sesi disimpan. Secara default, penyimpanan sesi file atau database dipilih.',
	'SessionModes'	=> [
		'1'		=> 'File',
		'2'		=> 'Basis data',
	],
	'SessionNotice'					=> 'Pemberitahuan penghentian sesi:',
	'SessionNoticeInfo'				=> 'Menunjukkan penyebab penghentian sesi.',
	'LoginNotice'					=> 'Pemberitahuan login:',
	'LoginNoticeInfo'				=> 'Menampilkan pemberitahuan login.',

	'RewriteMode'					=> 'Gunakan
mod_rewrite
:',
	'RewriteModeInfo'				=> 'Jika server web Anda mendukung fitur ini, aktifkan untuk "mempercantik" URL halaman.

Nilai mungkin akan ditimpa oleh kelas Settings saat runtime, terlepas dari apakah dinonaktifkan, jika HTTP_MOD_REWRITE aktif.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parameter yang bertanggung jawab untuk kontrol akses dan izin.',
	'PermissionsSettingsUpdated'	=> 'Pengaturan izin diperbarui.',

	'PermissionsSection'		=> 'Hak dan Privilege',
	'ReadRights'				=> 'Hak baca secara default:',
	'ReadRightsInfo'			=> 'Ditugaskan secara default ke halaman root yang dibuat, serta halaman yang ACL induknya tidak dapat ditentukan.',
	'WriteRights'				=> 'Hak tulis secara default:',
	'WriteRightsInfo'			=> 'Ditugaskan secara default ke halaman root yang dibuat, serta halaman yang ACL induknya tidak dapat ditentukan.',
	'CommentRights'				=> 'Hak komentar secara default:',
	'CommentRightsInfo'			=> 'Ditugaskan secara default ke halaman root yang dibuat, serta halaman yang ACL induknya tidak dapat ditentukan.',
	'CreateRights'				=> 'Hak membuat subhalaman secara default:',
	'CreateRightsInfo'			=> 'Ditugaskan secara default ke subhalaman yang dibuat.',
	'UploadRights'				=> 'Hak unggah secara default:',
	'UploadRightsInfo'			=> 'Hak unggah default.',
	'RenameRights'				=> 'Hak ganti nama global:',
	'RenameRightsInfo'			=> 'Daftar izin untuk mengganti nama (memindahkan) halaman secara bebas.',

	'LockAcl'					=> 'Kunci semua ACL menjadi hanya-baca:',
	'LockAclInfo'				=> 'Menimpa pengaturan ACL untuk semua halaman menjadi hanya-baca.
Ini mungkin berguna jika proyek telah selesai, Anda ingin menutup pengeditan untuk sementara waktu karena alasan keamanan, atau sebagai respons darurat terhadap eksploitasi atau kerentanan.',
	'HideLocked'				=> 'Sembunyikan halaman yang tidak dapat diakses:',
	'HideLockedInfo'			=> 'Jika pengguna tidak memiliki izin untuk membaca halaman, sembunyikan dalam berbagai daftar halaman (namun tautan yang ditempatkan dalam teks masih akan terlihat).',
	'RemoveOnlyAdmins'			=> 'Hanya administrator yang dapat menghapus halaman:',
	'RemoveOnlyAdminsInfo'		=> 'Larang semua, kecuali administrator, kemampuan untuk menghapus halaman. Batasan pertama berlaku untuk pemilik halaman biasa.',
	'OwnersRemoveComments'		=> 'Pemilik halaman dapat menghapus komentar:',
	'OwnersRemoveCommentsInfo'	=> 'Izinkan pemilik halaman untuk memoderasi komentar di halaman mereka.',
	'OwnersEditCategories'		=> 'Pemilik dapat mengedit kategori halaman:',
	'OwnersEditCategoriesInfo'	=> 'Izinkan pemilik untuk memodifikasi daftar kategori halaman situs Anda (menambah kata, menghapus kata), yang ditugaskan ke halaman.',
	'TermHumanModeration'		=> 'Batas waktu moderasi manusia:',
	'TermHumanModerationInfo'	=> 'Moderator hanya dapat mengedit komentar jika dibuat tidak lebih dari jumlah hari ini (batasan ini tidak berlaku untuk komentar terakhir dalam topik).',

	'UserCanDeleteAccount'		=> 'Izinkan pengguna menghapus akun mereka',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parameter yang bertanggung jawab untuk keamanan keseluruhan platform, pembatasan keamanan, dan subsistem keamanan tambahan.',
	'SecuritySettingsUpdated'	=> 'Pengaturan keamanan diperbarui.',

	'AllowRegistration'			=> 'Registrasi daring:',
	'AllowRegistrationInfo'		=> 'Buka pendaftaran pengguna. Menonaktifkan opsi ini akan mencegah pendaftaran bebas, namun administrator situs masih dapat mendaftarkan pengguna.',
	'ApproveNewUser'			=> 'Setujui pengguna baru:',
	'ApproveNewUserInfo'		=> 'Memungkinkan administrator untuk menyetujui pengguna setelah mereka mendaftar. Hanya pengguna yang disetujui yang diizinkan masuk ke situs.',
	'PersistentCookies'			=> 'Cookie persisten:',
	'PersistentCookiesInfo'		=> 'Izinkan cookie persisten.',
	'DisableWikiName'			=> 'Nonaktifkan WikiName:',
	'DisableWikiNameInfo'		=> 'Nonaktifkan penggunaan wajib WikiName untuk pengguna. Memungkinkan pendaftaran pengguna dengan nama panggilan tradisional alih-alih nama format CamelCase yang dipaksakan (misalnya, NamaSurname).',
	'UsernameLength'			=> 'Panjang nama pengguna:',
	'UsernameLengthInfo'		=> 'Jumlah minimum dan maksimum karakter dalam nama pengguna.',

	'EmailSection'				=> 'Surel',
	'AllowEmailReuse'			=> 'Izinkan penggunaan ulang alamat surel:',
	'AllowEmailReuseInfo'		=> 'Pengguna berbeda dapat mendaftar dengan alamat surel yang sama.',
	'EmailConfirmation'			=> 'Wajibkan konfirmasi surel:',
	'EmailConfirmationInfo'		=> 'Mengharuskan pengguna untuk memverifikasi alamat surel mereka sebelum dapat masuk.',
	'AllowedEmailDomains'		=> 'Domain surel yang diizinkan:',
	'AllowedEmailDomainsInfo'	=> 'Domain surel yang dipisahkan koma, misalnya
example.com, local.lan
 dll. Jika tidak ditentukan, semua domain surel diizinkan.',
	'ForbiddenEmailDomains'		=> 'Domain surel yang dilarang:',
	'ForbiddenEmailDomainsInfo'	=> 'Domain surel terlarang yang dipisahkan koma, misalnya
example.com, local.lan
 dll. Hanya berlaku jika daftar domain surel yang diizinkan kosong.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Aktifkan captcha:',
	'EnableCaptchaInfo'			=> 'Jika diaktifkan, captcha akan ditampilkan dalam kasus berikut, atau jika ambang batas keamanan tercapai.',
	'CaptchaComment'			=> 'Komentar baru:',
	'CaptchaCommentInfo'		=> 'Sebagai perlindungan terhadap spam, pengguna yang belum terdaftar harus menyelesaikan captcha sebelum mengirim komentar.',
	'CaptchaPage'				=> 'Halaman baru:',
	'CaptchaPageInfo'			=> 'Sebagai perlindungan terhadap spam, pengguna yang belum terdaftar harus menyelesaikan captcha sebelum membuat halaman baru.',
	'CaptchaEdit'				=> 'Edit halaman:',
	'CaptchaEditInfo'			=> 'Sebagai perlindungan terhadap spam, pengguna yang belum terdaftar harus menyelesaikan captcha sebelum mengedit halaman.',
	'CaptchaRegistration'		=> 'Registrasi:',
	'CaptchaRegistrationInfo'	=> 'Sebagai perlindungan terhadap spam, pengguna yang belum terdaftar harus menyelesaikan captcha sebelum mendaftar.',

	'TlsSection'				=> 'Pengaturan TLS',
	'TlsConnection'				=> 'Koneksi TLS:',
	'TlsConnectionInfo'			=> 'Gunakan koneksi yang diamankan TLS. Aktifkan sertifikat TLS yang diperlukan yang telah diinstal sebelumnya di server, jika tidak Anda akan kehilangan akses ke panel admin!
Ini juga menentukan apakah Flag Secure Cookie diatur: Flag
secure
 menentukan apakah cookie hanya boleh dikirim melalui koneksi aman.',
	'TlsImplicit'				=> 'TLS wajib:',
	'TlsImplicitInfo'			=> 'Paksa klien untuk terhubung ulang dari HTTP ke HTTPS. Dengan opsi dinonaktifkan, klien dapat menjelajahi situs melalui saluran HTTP terbuka.',

	'HttpSecurityHeaders'		=> 'Header Keamanan HTTP',
	'EnableSecurityHeaders'		=> 'Aktifkan header keamanan:',
	'EnableSecurityHeadersinfo'	=> 'Atur header keamanan (pencegahan frame, perlindungan clickjacking/XSS/CSRF).
CSP dapat menyebabkan masalah dalam situasi tertentu (misalnya selama pengembangan), atau saat menggunakan plugin yang bergantung pada sumber daya yang dihosting secara eksternal seperti gambar atau skrip.
Menonaktifkan Content Security Policy adalah risiko keamanan!',
	'Csp'						=> 'Kebijakan Keamanan Konten (CSP):',
	'CspInfo'					=> 'Mengonfigurasi CSP melibatkan keputusan kebijakan apa yang ingin Anda terapkan, kemudian mengonfigurasinya dan menggunakan Content-Security-Policy untuk menetapkan kebijakan Anda.',
	'PolicyModes'	=> [
		'0'		=> 'dinonaktifkan',
		'1'		=> 'ketat',
		'2'		=> 'kustom',
	],
	'PermissionsPolicy'			=> 'Kebijakan Izin:',
	'PermissionsPolicyInfo'		=> 'Header HTTP Permissions-Policy menyediakan mekanisme untuk secara eksplisit mengaktifkan atau menonaktifkan berbagai fitur browser yang kuat.',
	'ReferrerPolicy'			=> 'Kebijakan Referrer:',
	'ReferrerPolicyInfo'		=> 'Header HTTP Referrer-Policy mengatur informasi referrer apa, yang dikirim dalam header Referer, yang harus disertakan dalam respons.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[nonaktif]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> 'Ketahanan Kata Sandi Pengguna',
	'PwdMinChars'				=> 'Panjang minimum kata sandi:',
	'PwdMinCharsInfo'			=> 'Kata sandi yang lebih panjang tentu lebih aman daripada yang pendek (misal 12 hingga 16 karakter).
Penggunaan passphrase alih-alih kata sandi sangat dianjurkan.',
	'AdminPwdMinChars'			=> 'Panjang minimum kata sandi admin:',
	'AdminPwdMinCharsInfo'		=> 'Kata sandi yang lebih panjang tentu lebih aman daripada yang pendek (misal 15 hingga 20 karakter).
Penggunaan passphrase alih-alih kata sandi sangat dianjurkan.',
	'PwdCharComplexity'			=> 'Kompleksitas kata sandi yang diperlukan:',
	'PwdCharClasses'	=> [
		'0'		=> 'tidak diuji',
		'1'		=> 'huruf dan angka apa saja',
		'2'		=> 'huruf besar dan kecil + angka',
		'3'		=> 'huruf besar dan kecil + angka + karakter',
	],
	'PwdUnlikeLogin'			=> 'Komplikasi tambahan:',
	'PwdUnlikes'	=> [
		'0'		=> 'tidak diuji',
		'1'		=> 'kata sandi tidak identik dengan login',
		'2'		=> 'kata sandi tidak mengandung nama pengguna',
	],

	'LoginSection'				=> 'Masuk',
	'MaxLoginAttempts'			=> 'Jumlah maksimum percobaan login per nama pengguna:',
	'MaxLoginAttemptsInfo'		=> 'Jumlah percobaan login yang diizinkan untuk satu akun sebelum tugas anti-spambot dipicu. Masukkan 0 untuk mencegah tugas anti-spambot dipicu untuk akun pengguna yang berbeda.',
	'IpLoginLimitMax'			=> 'Jumlah maksimum percobaan login per alamat IP:',
	'IpLoginLimitMaxInfo'		=> 'Ambang batas percobaan login yang diizinkan dari satu alamat IP sebelum tugas anti-spambot dipicu. Masukkan 0 untuk mencegah tugas anti-spambot dipicu oleh alamat IP.',

	'FormsSection'				=> 'Formulir',
	'FormTokenTime'				=> 'Waktu maksimum untuk mengirim formulir:',
	'FormTokenTimeInfo'			=> 'Waktu yang dimiliki pengguna untuk mengirim formulir (dalam detik).
Catatan: formulir mungkin menjadi tidak valid jika sesi berakhir, terlepas dari pengaturan ini.',

	'SessionLength'				=> 'Kadaluarsa cookie sesi:',
	'SessionLengthInfo'			=> 'Masa hidup cookie sesi pengguna secara default (dalam hari).',
	'CommentDelay'				=> 'Anti-flood untuk komentar:',
	'CommentDelayInfo'			=> 'Jeda minimum antara publikasi komentar pengguna baru (dalam detik).',
	'IntercomDelay'				=> 'Anti-flood untuk komunikasi pribadi:',
	'IntercomDelayInfo'			=> 'Jeda minimum antara pengiriman pesan pribadi (dalam detik).',
	'RegistrationDelay'			=> 'Ambang waktu untuk pendaftaran:',
	'RegistrationDelayInfo'		=> 'Ambang waktu minimum untuk mengisi formulir pendaftaran untuk membedakan bot dari manusia (dalam detik).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Kelompok parameter yang bertanggung jawab untuk penyetelan halus situs. Jangan mengubahnya kecuali Anda yakin dengan tindakannya.',
	'FormatterSettingsUpdated'	=> 'Pengaturan pemformatan diperbarui.',

	'TextHandlerSection'		=> 'Penangan Teks:',
	'Typografica'				=> 'Pemeriksa tata tulis:',
	'TypograficaInfo'			=> 'Menonaktifkan opsi ini akan mempercepat proses penambahan komentar dan penyimpanan halaman.',
	'Paragrafica'				=> 'Penanda paragraf:',
	'ParagraficaInfo'			=> 'Mirip dengan opsi sebelumnya, tetapi akan menyebabkan pemutusan daftar isi otomatis yang tidak berfungsi (
{{toc}}
).',
	'AllowRawhtml'				=> 'Dukungan HTML global:',
	'AllowRawhtmlInfo'			=> 'Opsi ini berpotensi tidak aman untuk situs terbuka.',
	'SafeHtml'					=> 'Penyaringan HTML:',
	'SafeHtmlInfo'				=> 'Mencegah penyimpanan objek HTML yang berbahaya. Mematikan filter pada situs terbuka dengan dukungan HTML sangat tidak diinginkan!',

	'WackoFormatterSection'		=> 'Pemformat Teks Wiki (Wacko Formatter)',
	'X11colors'					=> 'Penggunaan warna X11:',
	'X11colorsInfo'				=> 'Memperluas warna yang tersedia untuk
??(warna) latar belakang??
 dan
!!(warna) teks!!
. Menonaktifkan opsi ini mempercepat proses penambahan komentar dan penyimpanan halaman.',
	'WikiLinks'					=> 'Nonaktifkan tautan wiki:',
	'WikiLinksInfo'				=> 'Menonaktifkan penautan untuk
KataBentukUnta
: Kata bentuk unta Anda tidak lagi ditautkan langsung ke halaman baru. Ini berguna saat Anda bekerja di berbagai namespace/kluster. Secara default dinonaktifkan.',
	'BracketsLinks'				=> 'Nonaktifkan tautan dalam kurung:',
	'BracketsLinksInfo'			=> 'Menonaktifkan sintaks
[[tautan]]
 dan
((tautan))
.',
	'Formatters'				=> 'Nonaktifkan pemformat:',
	'FormattersInfo'			=> 'Menonaktifkan sintaks
%%kode%%
, digunakan untuk penyorot sintaks.',

	'DateFormatsSection'		=> 'Format Tanggal',
	'DateFormat'				=> 'Format tanggal:',
	'DateFormatInfo'			=> '(hari, bulan, tahun)',
	'TimeFormat'				=> 'Format waktu:',
	'TimeFormatInfo'			=> '(jam, menit)',
	'TimeFormatSeconds'			=> 'Format waktu tepat:',
	'TimeFormatSecondsInfo'		=> '(jam, menit, detik)',
	'NameDateMacro'				=> 'Format makro
::@::
:',
	'NameDateMacroInfo'			=> '(nama, waktu), misal
NamaPengguna (17.11.2016 16:48)
',
	'Timezone'					=> 'Zona waktu:',
	'TimezoneInfo'				=> 'Zona waktu yang digunakan untuk menampilkan waktu kepada pengguna yang tidak masuk (tamu). Pengguna yang masuk dapat mengubah zona waktu mereka di pengaturan pengguna.',
	'AmericanDate'					=> 'Tanggal Amerika:',
	'AmericanDateInfo'				=> 'Menggunakan format tanggal Amerika sebagai standar untuk bahasa Inggris.',

	'Canonical'					=> 'Gunakan URL kanonikal penuh:',
	'CanonicalInfo'				=> 'Semua tautan dibuat sebagai URL absolut dalam bentuk %1. URL relatif terhadap root server dalam bentuk %2 harus lebih diutamakan.',
	'LinkTarget'				=> 'Tempat tautan eksternal terbuka:',
	'LinkTargetInfo'			=> 'Membuka setiap tautan eksternal di jendela browser baru. Menambahkan
target="_blank"
 ke sintaks tautan.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Meminta agar browser tidak mengirim header HTTP referer jika pengguna mengikuti hyperlink. Menambahkan
rel="noreferrer"
 ke sintaks tautan.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Memberi tahu mesin pencari bahwa hyperlink tidak boleh mempengaruhi peringkat halaman tujuan dalam indeks mesin pencari. Menambahkan
rel="nofollow"
 ke sintaks tautan.',
	'UrlsUnderscores'			=> 'Alamat (URL) dengan garis bawah:',
	'UrlsUnderscoresInfo'		=> 'Misalnya, %1 menjadi %2 dengan opsi ini.',
	'ShowSpaces'				=> 'Tampilkan spasi dalam WikiNames:',
	'ShowSpacesInfo'			=> 'Menampilkan spasi dalam WikiNames, misal
NamaSaya
 ditampilkan sebagai
Nama Saya
 dengan opsi ini.',
	'NumerateLinks'				=> 'Nomori tautan dalam tampilan cetak:',
	'NumerateLinksInfo'			=> 'Menomori dan mencantumkan semua tautan di bagian bawah tampilan cetak dengan opsi ini.',
	'YouareHereText'			=> 'Nonaktifkan dan visualisasikan tautan yang merujuk ke diri sendiri:',
	'YouareHereTextInfo'		=> 'Visualisasikan tautan ke halaman yang sama, menggunakan
<b>####</b>
. Semua tautan ke diri sendiri kehilangan format tautan, tetapi ditampilkan sebagai teks tebal.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Di sini Anda dapat mengatur atau mengubah halaman dasar sistem yang digunakan dalam Wiki. Pastikan Anda tidak lupa membuat atau mengubah halaman yang sesuai dalam Wiki sesuai dengan pengaturan di sini.',
	'PagesSettingsUpdated'		=> 'Pengaturan halaman dasar diperbarui',

	'ListCount'					=> 'Jumlah item per daftar:',
	'ListCountInfo'				=> 'Jumlah item yang ditampilkan pada setiap daftar untuk tamu, atau sebagai nilai default untuk pengguna baru.',

	'ForumSection'				=> 'Opsi Forum',
	'ForumCluster'				=> 'Kluster forum:',
	'ForumClusterInfo'			=> 'Kluster root untuk bagian forum (aksi %1).',
	'ForumTopics'				=> 'Jumlah topik per halaman:',
	'ForumTopicsInfo'			=> 'Jumlah topik yang ditampilkan pada setiap halaman daftar di bagian forum (aksi %1).',
	'CommentsCount'				=> 'Jumlah komentar per halaman:',
	'CommentsCountInfo'			=> 'Jumlah komentar yang ditampilkan pada daftar komentar setiap halaman. Ini berlaku untuk semua komentar di situs, tidak hanya yang diposting di forum.',

	'NewsSection'				=> 'Bagian Berita',
	'NewsCluster'				=> 'Kluster untuk berita:',
	'NewsClusterInfo'			=> 'Kluster root untuk bagian berita (aksi %1).',
	'NewsStructure'				=> 'Struktur kluster berita:',
	'NewsStructureInfo'			=> 'Menyimpan artikel secara opsional dalam sub-kluster berdasarkan tahun/bulan atau minggu (misal
[kluster]/[tahun]/[bulan]
).',

	'LicenseSection'			=> 'Lisensi',
	'DefaultLicense'			=> 'Lisensi default:',
	'DefaultLicenseInfo'		=> 'Di bawah lisensi apa konten Anda dapat dirilis.',
	'EnableLicense'				=> 'Aktifkan lisensi:',
	'EnableLicenseInfo'			=> 'Aktifkan untuk menampilkan informasi lisensi.',
	'LicensePerPage'			=> 'Lisensi per halaman:',
	'LicensePerPageInfo'		=> 'Izinkan lisensi per halaman, yang dapat dipilih pemilik halaman melalui properti halaman.',

	'ServicePagesSection'		=> 'Halaman Layanan',
	'RootPage'					=> 'Halaman utama:',
	'RootPageInfo'				=> 'Tag halaman utama Anda, terbuka secara otomatis ketika pengguna mengunjungi situs Anda.',

	'PrivacyPage'				=> 'Kebijakan privasi:',
	'PrivacyPageInfo'			=> 'Halaman dengan Kebijakan Privasi situs.',

	'TermsPage'					=> 'Kebijakan dan peraturan:',
	'TermsPageInfo'				=> 'Halaman dengan peraturan situs.',

	'SearchPage'				=> 'Cari:',
	'SearchPageInfo'			=> 'Halaman dengan formulir pencarian (aksi %1).',
	'RegistrationPage'			=> 'Registrasi:',
	'RegistrationPageInfo'		=> 'Halaman untuk pendaftaran pengguna baru (aksi %1).',
	'LoginPage'					=> 'Masuk pengguna:',
	'LoginPageInfo'				=> 'Halaman masuk ke situs (aksi %1).',
	'SettingsPage'				=> 'Pengaturan pengguna:',
	'SettingsPageInfo'			=> 'Halaman untuk menyesuaikan profil pengguna (aksi %1).',
	'PasswordPage'				=> 'Ubah Kata Sandi:',
	'PasswordPageInfo'			=> 'Halaman dengan formulir untuk mengubah/meminta kata sandi pengguna (aksi %1).',
	'UsersPage'					=> 'Daftar pengguna:',
	'UsersPageInfo'				=> 'Halaman dengan daftar pengguna terdaftar (aksi %1).',
	'CategoryPage'				=> 'Kategori:',
	'CategoryPageInfo'			=> 'Halaman dengan daftar halaman yang dikategorikan (aksi %1).',
	'GroupsPage'				=> 'Kelompok:',
	'GroupsPageInfo'			=> 'Halaman dengan daftar kelompok kerja (aksi %1).',
	'WhatsNewPage'				=> 'Apa yang baru:',
	'WhatsNewPageInfo'			=> 'Halaman yang menampilkan daftar semua halaman baru, dihapus, atau diubah, lampiran baru, dan komentar. (aksi %1).',
	'ChangesPage'				=> 'Perubahan terbaru:',
	'ChangesPageInfo'			=> 'Halaman dengan daftar halaman yang terakhir dimodifikasi (aksi %1).',
	'CommentsPage'				=> 'Komentar terbaru:',
	'CommentsPageInfo'			=> 'Halaman dengan daftar komentar terbaru pada halaman (aksi %1).',
	'RemovalsPage'				=> 'Halaman yang dihapus:',
	'RemovalsPageInfo'			=> 'Halaman dengan daftar halaman yang baru saja dihapus (aksi %1).',
	'WantedPage'				=> 'Halaman yang diinginkan:',
	'WantedPageInfo'			=> 'Halaman dengan daftar halaman yang hilang namun dirujuk (aksi %1).',
	'OrphanedPage'				=> 'Halaman yatim:',
	'OrphanedPageInfo'			=> 'Halaman dengan daftar halaman yang ada namun tidak terkait melalui tautan dengan halaman lain (aksi %1).',
	'SandboxPage'				=> 'Sandbox:',
	'SandboxPageInfo'			=> 'Halaman tempat pengguna dapat berlatih keterampilan markup wiki mereka.',
	'HelpPage'					=> 'Bantuan:',
	'HelpPageInfo'				=> 'Bagian dokumentasi untuk bekerja dengan alat situs.',
	'IndexPage'					=> 'Indeks:',
	'IndexPageInfo'				=> 'Halaman dengan daftar semua halaman (aksi %1).',
	'RandomPage'				=> 'Acak:',
	'RandomPageInfo'			=> 'Memuat halaman acak (aksi %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameter untuk notifikasi platform.',
	'NotificationSettingsUpdated'	=> 'Pengaturan notifikasi diperbarui',

	'EmailNotification'			=> 'Notifikasi email:',
	'EmailNotificationInfo'		=> 'Izinkan notifikasi email. Atur ke Aktif untuk mengaktifkan notifikasi email, Nonaktif untuk menonaktifkannya. Perhatikan bahwa menonaktifkan notifikasi email tidak berpengaruh pada email yang dihasilkan sebagai bagian dari proses pendaftaran pengguna.',
	'Autosubscribe'				=> 'Autosubscribe:',
	'AutosubscribeInfo'			=> 'Secara otomatis beri tahu pemilik tentang perubahan halaman.',

	'NotificationSection'		=> 'Pengaturan Notifikasi Pengguna Default',
	'NotifyPageEdit'			=> 'Beri tahu pengeditan halaman:',
	'NotifyPageEditInfo'		=> 'Tertunda - Kirim notifikasi email hanya untuk perubahan pertama sampai pengguna mengunjungi halaman lagi.',
	'NotifyMinorEdit'			=> 'Beri tahu pengeditan kecil:',
	'NotifyMinorEditInfo'		=> 'Kirim notifikasi juga untuk pengeditan kecil.',
	'NotifyNewComment'			=> 'Beri tahu komentar baru:',
	'NotifyNewCommentInfo'		=> 'Tertunda - Kirim notifikasi email hanya untuk komentar pertama sampai pengguna mengunjungi halaman lagi.',

	'NotifyUserAccount'			=> 'Beri tahu akun pengguna baru:',
	'NotifyUserAccountInfo'		=> 'Admin akan diberi tahu ketika pengguna baru dibuat menggunakan formulir pendaftaran.',
	'NotifyUpload'				=> 'Beri tahu unggahan berkas:',
	'NotifyUploadInfo'			=> 'Moderator akan diberi tahu ketika berkas diunggah.',

	'PersonalMessagesSection'	=> 'Pesan Pribadi',
	'AllowIntercomDefault'		=> 'Izinkan interkom:',
	'AllowIntercomDefaultInfo'	=> 'Mengaktifkan opsi ini memungkinkan pengguna lain mengirim pesan pribadi ke alamat email penerima tanpa mengungkapkan alamat tersebut.',
	'AllowMassemailDefault'		=> 'Izinkan email massal:',
	'AllowMassemailDefaultInfo'	=> 'Hanya kirim pesan kepada pengguna yang telah mengizinkan administrator untuk mengirimkan informasi melalui email kepada mereka.',

	// Resync settings
	'Synchronize'				=> 'Sinkronisasi',
	'UserStatsSynched'			=> 'Statistik pengguna disinkronisasi.',
	'PageStatsSynched'			=> 'Statistik halaman disinkronisasi.',
	'FeedsUpdated'				=> 'Umpan RSS diperbarui.',
	'SiteMapCreated'			=> 'Versi baru peta situs berhasil dibuat.',
	'ParseNextBatch'			=> 'Proses batch halaman berikutnya:',
	'WikiLinksRestored'			=> 'Tautan wiki dipulihkan.',

	'LogUserStatsSynched'		=> 'Statistik pengguna disinkronisasi',
	'LogPageStatsSynched'		=> 'Statistik halaman disinkronisasi',
	'LogFeedsUpdated'			=> 'Umpan RSS disinkronisasi',
	'LogPageBodySynched'		=> 'Isi halaman dan tautan diurai ulang',

	'UserStats'					=> 'Statistik pengguna',
	'UserStatsInfo'				=> 'Statistik pengguna (jumlah komentar, halaman yang dimiliki, revisi dan berkas) mungkin berbeda dalam beberapa situasi dari data aktual.
Operasi ini memungkinkan pembaruan statistik agar sesuai dengan data aktual yang terdapat dalam database.',
	'PageStats'					=> 'Statistik halaman',
	'PageStatsInfo'				=> 'Statistik halaman (jumlah komentar, berkas dan revisi) mungkin berbeda dalam beberapa situasi dari data aktual.
Operasi ini memungkinkan pembaruan statistik agar sesuai dengan data aktual yang terdapat dalam database.',

	'AttachmentsInfo'			=> 'Perbarui hash berkas untuk semua lampiran dalam database.',
	'AttachmentsSynched'		=> 'Semua lampiran berkas di-hash ulang',
	'LogAttachmentsSynched'		=> 'Semua lampiran berkas di-hash ulang',

	'Feeds'						=> 'Umpan',
	'FeedsInfo'					=> 'Dalam kasus pengeditan langsung halaman dalam database, konten umpan RSS mungkin tidak mencerminkan perubahan yang dibuat.
Fungsi ini menyinkronkan saluran RSS dengan keadaan terkini database.',
	'XmlSiteMap'				=> 'Peta Situs XML',
	'XmlSiteMapInfo'			=> 'Fungsi ini menyinkronkan Peta Situs XML dengan keadaan terkini database.',
	'XmlSiteMapPeriod'			=> 'Periode %1 hari. Terakhir ditulis %2.',
	'XmlSiteMapView'			=> 'Tampilkan Peta Situs dalam jendela baru.',

	'ReparseBody'				=> 'Proses ulang semua halaman',
	'ReparseBodyInfo'			=> 'Mengosongkan kolom
body_r
 dalam tabel halaman, sehingga setiap halaman akan dirender kembali pada tampilan halaman berikutnya. Ini mungkin berguna jika Anda memodifikasi pemformat atau mengubah domain wiki Anda.',
	'PreparsedBodyPurged'		=> 'Kolom
body_r
 dalam tabel halaman dikosongkan.',

	'WikiLinksResync'			=> 'Tautan wiki',
	'WikiLinksResyncInfo'		=> 'Melakukan proses ulang render untuk semua tautan internal dan memulihkan konten tabel
page_link
 dan
file_link
 jika terjadi kerusakan atau relokasi (ini bisa memakan waktu yang cukup lama).',
	'RecompilePage'				=> 'Mengompilasi ulang semua halaman (sangat mahal)',
	'ResyncOptions'				=> 'Opsi tambahan',
	'RecompilePageLimit'		=> 'Jumlah halaman yang akan diproses sekaligus.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Informasi ini digunakan ketika sistem mengirim email kepada pengguna Anda. Pastikan alamat email yang Anda tentukan valid, karena pesan yang terpental atau tidak terkirim kemungkinan akan dikirim ke alamat tersebut. Jika penyedia hosting Anda tidak menyediakan layanan email native (berbasis PHP), Anda dapat mengirim pesan langsung menggunakan SMTP. Ini memerlukan alamat server yang sesuai (tanyakan kepada penyedia hosting jika perlu). Jika server memerlukan autentikasi (dan hanya jika diperlukan), masukkan nama pengguna, kata sandi, dan metode autentikasi yang diperlukan.',

	'EmailSettingsUpdated'		=> 'Pengaturan Email diperbarui',

	'EmailFunctionName'			=> 'Nama fungsi email:',
	'EmailFunctionNameInfo'		=> 'Fungsi email yang digunakan untuk mengirim email melalui PHP.',
	'UseSmtpInfo'				=> 'Pilih
SMTP
 jika Anda ingin atau harus mengirim email melalui server bernama alih-alih melalui fungsi mail lokal.',

	'EnableEmail'				=> 'Aktifkan email:',
	'EnableEmailInfo'			=> 'Aktifkan pengiriman email.',

	'EmailIdentitySettings'		=> 'Identitas Email Situs',
	'FromEmailName'				=> 'Nama pengirim:',
	'FromEmailNameInfo'			=> 'Nama pengirim yang digunakan untuk header
From:
 untuk semua notifikasi email yang dikirim dari situs.',
	'EmailSubjectPrefix'		=> 'Prefiks subjek:',
	'EmailSubjectPrefixInfo'	=> 'Prefiks subjek email alternatif, misal
[Prefiks] Topik
. Jika tidak ditentukan, prefiks default adalah Nama Situs: %1.',

	'NoReplyEmail'				=> 'Alamat no-reply:',
	'NoReplyEmailInfo'			=> 'Alamat ini, misal
noreply@example.com
, akan muncul di bidang alamat email
From:
 untuk semua notifikasi email yang dikirim dari situs.',
	'AdminEmail'				=> 'Email pemilik situs:',
	'AdminEmailInfo'			=> 'Alamat ini digunakan untuk keperluan admin, seperti notifikasi pengguna baru.',
	'AbuseEmail'				=> 'Email layanan pelaporan:',
	'AbuseEmailInfo'			=> 'Alamat untuk permintaan hal-hal mendesak: pendaftaran untuk email asing, dll. Bisa sama dengan email pemilik situs.',

	'SendTestEmail'				=> 'Kirim email uji',
	'SendTestEmailInfo'			=> 'Ini akan mengirim email uji ke alamat yang ditentukan dalam akun Anda.',
	'TestEmailSubject'			=> 'Wiki Anda telah dikonfigurasi dengan benar untuk mengirim email',
	'TestEmailBody'				=> 'Jika Anda menerima email ini, Wiki Anda telah dikonfigurasi dengan benar untuk mengirim email.',
	'TestEmailMessage'			=> 'Email uji telah dikirim.
Jika Anda tidak menerimanya, silakan periksa pengaturan konfigurasi email Anda.',

	'SmtpSettings'				=> 'Pengaturan SMTP',
	'SmtpAutoTls'				=> 'TLS oportunistik:',
	'SmtpAutoTlsInfo'			=> 'Mengaktifkan enkripsi secara otomatis, jika server mengumumkan dukungan TLS (setelah Anda terhubung ke server), meskipun Anda belum mengatur mode koneksi untuk
SMTPSecure
.',
	'SmtpConnectionMode'		=> 'Mode koneksi untuk SMTP:',
	'SmtpConnectionModeInfo'	=> 'Hanya digunakan jika nama pengguna/kata sandi diperlukan. Tanyakan kepada penyedia Anda jika Anda tidak yakin metode mana yang harus digunakan.',
	'SmtpPassword'				=> 'Kata sandi SMTP:',
	'SmtpPasswordInfo'			=> 'Hanya masukkan kata sandi jika server SMTP Anda memerlukannya.
Peringatan: Kata sandi ini akan disimpan sebagai teks biasa dalam database, terlihat oleh siapa saja yang dapat mengakses database Anda atau yang dapat melihat halaman konfigurasi ini.',
	'SmtpPort'					=> 'Port server SMTP:',
	'SmtpPortInfo'				=> 'Hanya ubah ini jika Anda tahu server SMTP Anda menggunakan port yang berbeda.
(default:
tls
 pada port 587 (atau mungkin 25) dan
ssl
 pada port 465).',
	'SmtpServer'				=> 'Alamat server SMTP:',
	'SmtpServerInfo'			=> 'Perhatikan bahwa Anda harus menyediakan protokol yang digunakan server Anda. Jika menggunakan SSL, harus berupa
ssl://mail.example.com
.',
	'SmtpUsername'				=> 'Nama pengguna SMTP:',
	'SmtpUsernameInfo'			=> 'Hanya masukkan nama pengguna jika server SMTP Anda memerlukannya.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Di sini Anda dapat mengonfigurasi pengaturan utama untuk lampiran dan kategori khusus yang terkait.',
	'UploadSettingsUpdated'		=> 'Pengaturan unggahan diperbarui',

	'FileUploadsSection'		=> 'Unggahan Berkas',
	'RegisteredUsers'			=> 'pengguna terdaftar',
	'RightToUpload'				=> 'Izin untuk mengunggah berkas:',
	'RightToUploadInfo'			=> '
admins
 berarti hanya pengguna yang termasuk dalam grup admin yang dapat mengunggah berkas.
1
 berarti unggahan terbuka untuk pengguna terdaftar.
0
 berarti unggahan dinonaktifkan.',
	'UploadMaxFilesize'			=> 'Ukuran berkas maksimum:',
	'UploadMaxFilesizeInfo'		=> 'Ukuran maksimum setiap berkas. Jika nilai ini 0, ukuran berkas maksimum yang dapat diunggah hanya dibatasi oleh konfigurasi PHP Anda.',
	'UploadQuota'				=> 'Kuota lampiran total:',
	'UploadQuotaInfo'			=> 'Ruang penyimpanan maksimum yang tersedia untuk lampiran untuk seluruh wiki, dengan
0
 berarti tidak terbatas. %1 telah digunakan.',
	'UploadQuotaUser'			=> 'Kuota penyimpanan per pengguna:',
	'UploadQuotaUserInfo'		=> 'Pembatasan pada kuota penyimpanan yang dapat diunggah oleh satu pengguna, dengan
0
 berarti tidak terbatas.',

	'FileTypes'					=> 'Jenis Berkas',
	'UploadOnlyImages'			=> 'Hanya izinkan unggahan gambar:',
	'UploadOnlyImagesInfo'		=> 'Hanya izinkan pengunggahan berkas gambar pada halaman.',
	'AllowedUploadExts'			=> 'Jenis berkas yang diizinkan:',
	'AllowedUploadExtsInfo'		=> 'Ekstensi yang diizinkan untuk mengunggah berkas, dipisahkan koma (misal,
png, ogg, mp4
); jika tidak, semua ekstensi berkas diizinkan.
Anda harus membatasi ekstensi berkas yang diizinkan seminimal mungkin yang diperlukan untuk fungsionalitas situs Anda.',
	'CheckMimetype'				=> 'Periksa tipe MIME:',
	'CheckMimetypeInfo'			=> 'Beberapa browser dapat ditipu untuk menganggap tipe MIME yang salah untuk berkas yang diunggah. Opsi ini memastikan bahwa berkas yang mungkin menyebabkan hal ini ditolak.',
	'SvgSanitizer'				=> 'Sanitasi SVG:',
	'SvgSanitizerInfo'			=> 'Ini mengaktifkan sanitasi berkas SVG untuk mencegah kerentanan SVG/XML yang diunggah.',
	'TranslitFileName'			=> 'Transliterasi nama berkas:',
	'TranslitFileNameInfo'		=> 'Jika berlaku dan tidak perlu menggunakan karakter Unicode, sangat disarankan untuk hanya menerima karakter alfanumerik dalam nama berkas.',
	'TranslitCaseFolding'		=> 'Konversi nama berkas ke huruf kecil:',
	'TranslitCaseFoldingInfo'	=> 'Opsi ini hanya berlaku dengan transliterasi aktif.',

	'Thumbnails'				=> 'Thumbnail',
	'CreateThumbnail'			=> 'Buat thumbnail:',
	'CreateThumbnailInfo'		=> 'Buat thumbnail dalam semua situasi yang memungkinkan.',
	'JpegQuality'				=> 'Kualitas JPEG:',
	'JpegQualityInfo'			=> 'Kualitas saat menskalakan thumbnail JPEG. Harus antara 1 dan 100, dengan 100 menunjukkan kualitas 100%.',
	'MaxImageArea'				=> 'Area gambar maksimum:',
	'MaxImageAreaInfo'			=> 'Jumlah piksel maksimum yang dapat dimiliki gambar sumber. Ini memberikan batasan penggunaan memori untuk sisi dekompresi penskala gambar.
-1
 berarti tidak akan memeriksa ukuran gambar sebelum mencoba menskalanya.
0
 berarti akan menentukan nilai secara otomatis.',
	'MaxThumbWidth'				=> 'Lebar thumbnail maksimum dalam piksel:',
	'MaxThumbWidthInfo'			=> 'Thumbnail yang dihasilkan tidak akan melebihi lebar yang ditetapkan di sini.',
	'MinThumbFilesize'			=> 'Ukuran berkas thumbnail minimum:',
	'MinThumbFilesizeInfo'		=> 'Jangan buat thumbnail untuk gambar yang lebih kecil dari ini.',
	'MaxImageWidth'				=> 'Batas ukuran gambar pada halaman:',
	'MaxImageWidthInfo'			=> 'Lebar maksimum yang dapat dimiliki gambar pada halaman, jika tidak, thumbnail yang diperkecil akan dibuat.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Daftar halaman, revisi, dan berkas yang telah dihapus. Hapus atau pulihkan halaman, revisi, atau berkas dari database dengan mengklik tautan Hapus atau Pulihkan pada baris yang sesuai. (Hati-hati, tidak ada konfirmasi penghapusan yang diminta!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Kata-kata yang akan disensor secara otomatis di Wiki Anda.',
	'FilterSettingsUpdated'		=> 'Pengaturan filter spam diperbarui',

	'WordCensoringSection'		=> 'Sensor Kata',
	'SPAMFilter'				=> 'Filter spam:',
	'SPAMFilterInfo'			=> 'Mengaktifkan Filter Spam',
	'WordList'					=> 'Daftar kata:',
	'WordListInfo'				=> 'Kata atau frasa
fragment
 yang akan dimasukkan daftar hitam (satu per baris)',

	// Log module
	'LogFilterTip'				=> 'Filter peristiwa berdasarkan kriteria:',
	'LogLevel'					=> 'Tingkat',
	'LogLevelFilters'	=> [
		'1'		=> 'tidak kurang dari',
		'2'		=> 'tidak lebih tinggi dari',
		'3'		=> 'sama dengan',
	],
	'LogNoMatch'				=> 'Tidak ada peristiwa yang memenuhi kriteria',
	'LogDate'					=> 'Tanggal',
	'LogEvent'					=> 'Peristiwa',
	'LogUsername'				=> 'Nama pengguna',
	'LogLevels'	=> [
		'1'		=> 'kritis',
		'2'		=> 'tertinggi',
		'3'		=> 'tinggi',
		'4'		=> 'sedang',
		'5'		=> 'rendah',
		'6'		=> 'terendah',
		'7'		=> 'debugging',
	],

	// Massemail module
	'MassemailInfo'				=> 'Di sini Anda dapat mengirim pesan email ke (1) semua pengguna Anda atau (2) semua pengguna dari grup tertentu yang telah mengaktifkan penerimaan email massal. Email akan dikirim ke alamat email administratif yang disediakan, dengan salinan karbon buta (BCC) dikirim ke semua penerima. Pengaturan default adalah menyertakan maksimal 20 penerima dalam satu email. Jika ada lebih dari 20 penerima, email tambahan akan dikirim. Jika Anda mengirim email ke grup besar, harap bersabar setelah mengirim dan jangan menghentikan halaman di tengah proses. Wajar jika pengiriman email massal memakan waktu lama. Anda akan diberitahu ketika skrip telah selesai.',
	'LogMassemail'				=> 'Pengiriman email massal %1 ke grup/pengguna ',
	'MassemailSend'				=> 'Kirim email massal',

	'NoEmailMessage'			=> 'Anda harus memasukkan pesan.',
	'NoEmailSubject'			=> 'Anda harus menentukan subjek untuk pesan Anda.',
	'NoEmailRecipient'			=> 'Anda harus menentukan setidaknya satu pengguna atau grup pengguna.',

	'MassemailSection'			=> 'Email Massal',
	'MessageSubject'			=> 'Subjek:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Pesan Anda:',
	'YourMessageInfo'			=> 'Harap diperhatikan bahwa Anda hanya dapat memasukkan teks biasa. Semua markup akan dihapus sebelum pengiriman.',

	'NoUser'					=> 'Tidak ada pengguna',
	'NoUserGroup'				=> 'Tidak ada grup pengguna',

	'SendToGroup'				=> 'Kirim ke grup:',
	'SendToUser'				=> 'Kirim ke pengguna:',
	'SendToUserInfo'			=> 'Hanya pengguna yang mengizinkan administrator untuk mengirim email kepada mereka yang akan menerima email massal. Opsi ini tersedia dalam pengaturan pengguna mereka di bawah Notifikasi.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Pesan sistem diperbarui',

	'SysMsgSection'				=> 'Pesan Sistem',
	'SysMsg'					=> 'Pesan sistem:',
	'SysMsgInfo'				=> 'Teks Anda di sini',

	'SysMsgType'				=> 'Tipe:',
	'SysMsgTypeInfo'			=> 'Tipe pesan (CSS).',
	'SysMsgAudience'			=> 'Penerima:',
	'SysMsgAudienceInfo'		=> 'Penerima yang akan melihat pesan sistem.',
	'EnableSysMsg'				=> 'Aktifkan pesan sistem:',
	'EnableSysMsgInfo'			=> 'Tampilkan pesan sistem.',

	// User approval module
	'ApproveNotExists'			=> 'Silakan pilih setidaknya satu pengguna melalui tombol Set.',

	'LogUserApproved'			=> 'Pengguna ##%1## disetujui',
	'LogUserBlocked'			=> 'Pengguna ##%1## diblokir',
	'LogUserDeleted'			=> 'Pengguna ##%1## dihapus dari database',
	'LogUserCreated'			=> 'Membuat pengguna baru ##%1##',
	'LogUserUpdated'			=> 'Memperbarui Pengguna ##%1##',
	'LogUserPasswordReset'		=> 'Kata sandi untuk pengguna ##%1## berhasil disetel ulang',

	'UserApproveInfo'			=> 'Setujui pengguna baru sebelum mereka dapat masuk ke situs.',
	'Approve'					=> 'Setujui',
	'Deny'						=> 'Tolak',
	'Pending'					=> 'Menunggu',
	'Approved'					=> 'Disetujui',
	'Denied'					=> 'Ditolak',

	// DB Backup module
	'BackupStructure'			=> 'Struktur',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Folder',
	'BackupTable'				=> 'Tabel',
	'BackupCluster'				=> 'Kluster:',
	'BackupFiles'				=> 'Berkas',
	'BackupNote'				=> 'Catatan:',
	'BackupSettings'			=> 'Tentukan skema cadangan yang diinginkan.
' .
    	'Kluster root tidak mempengaruhi cadangan berkas global dan cadangan berkas cache (jika dipilih, mereka selalu disimpan secara penuh).
' .  '<br>' .
		'Perhatian: Untuk menghindari kehilangan informasi dari basis data saat menentukan kluster root, tabel dari cadangan ini tidak akan direstrukturisasi, sama seperti saat mencadangkan hanya struktur tabel tanpa menyimpan data. Untuk melakukan konversi lengkap tabel ke format cadangan, Anda harus membuat cadangan basis data penuh (struktur dan data) tanpa menentukan kluster.',
	'BackupCompleted'			=> 'Pencadangan dan pengarsipan selesai.
' .
    	'Berkas-berkas paket cadangan disimpan di subdirektori %1.
',
	'LogSavedBackup'			=> 'Menyimpan cadangan basis data ##%1##',
	'Backup'					=> 'Cadangan',
	'CantReadFile'				=> 'Tidak dapat membaca berkas %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Anda dapat memulihkan salah satu paket cadangan yang ditemukan, atau menghapusnya dari server.',
	'ConfirmDbRestore'			=> 'Apakah Anda ingin memulihkan cadangan %1?',
	'ConfirmDbRestoreInfo'		=> 'Harap tunggu, proses ini mungkin memakan waktu.',
	'RestoreWrongVersion'		=> 'Versi WackoWiki salah!',
	'DirectoryNotExecutable'	=> 'Direktori %1 tidak dapat dieksekusi.',
	'BackupDelete'				=> 'Apakah Anda yakin ingin menghapus cadangan %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Opsi pemulihan tambahan:',
	'RestoreOptionsInfo'		=> '* Sebelum memulihkan cadangan kluster, ' .
									'tabel tujuan tidak dihapus (untuk mencegah kehilangan informasi dari kluster yang belum dicadangkan). ' .
									'Dengan demikian, selama proses pemulihan akan terjadi duplikasi catatan. ' .
									'Dalam mode normal, semua duplikasi akan digantikan oleh catatan dari cadangan (menggunakan SQL
REPLACE
), ' .
									'tetapi jika kotak centang ini dicentang, semua duplikasi akan dilewati (nilai catatan saat ini akan dipertahankan), ' .
									'dan hanya catatan dengan kunci baru yang akan ditambahkan ke tabel (SQL
INSERT IGNORE
).
' .
									'Perhatian: Saat memulihkan cadangan lengkap situs, opsi ini tidak berlaku.
' .
									'<br>' .
									'** Jika cadangan berisi berkas pengguna (global dan per halaman, berkas cache, dll.), ' .
									'dalam mode normal mereka akan menggantikan berkas yang ada dengan nama yang sama dan ditempatkan di direktori yang sama saat dipulihkan. ' .
									'Opsi ini memungkinkan Anda untuk menyimpan salinan berkas saat ini dan memulihkan dari cadangan hanya berkas baru (yang tidak ada di server).',
	'IgnoreDuplicatedKeysNr'	=> 'Abaikan kunci tabel duplikat (jangan ganti)',
	'IgnoreSameFiles'			=> 'Abaikan berkas yang sama (jangan timpa)',
	'NoBackupsAvailable'		=> 'Tidak ada cadangan yang tersedia.',
	'BackupEntireSite'			=> 'Seluruh situs',
	'BackupRestored'			=> 'Cadangan telah dipulihkan, laporan ringkasan terlampir di bawah. Untuk menghapus paket cadangan ini, klik',
	'BackupRemoved'				=> 'Cadangan yang dipilih telah berhasil dihapus.',
	'LogRemovedBackup'			=> 'Menghapus cadangan basis data ##%1##',

	'DbEngineInvalid'			=> 'Mesin basis data tidak valid, diharapkan %1',
	'RestoreStarted'			=> 'Pemulihan dimulai',
	'RestoreParameters'			=> 'Menggunakan parameter',
	'IgnoreDuplicatedKeys'		=> 'Abaikan kunci duplikat',
	'IgnoreDuplicatedFiles'		=> 'Abaikan berkas duplikat',
	'SavedCluster'				=> 'Kluster tersimpan',
	'DataProtection'			=> 'Perlindungan Data - %1 dilewati',
	'AssumeDropTable'			=> 'Asumsikan %1',
	'RestoreSQLiteDatabase'		=> 'Memulihkan basis data SQLite',
	'SQLiteDatabaseRestored'	=> 'Basis data telah berhasil dipulihkan dari:',
	'RestoreTableStructure'		=> 'Memulihkan struktur tabel',
	'RunSqlQueries'				=> 'Menjalankan instruksi SQL:',
	'CompletedSqlQueries'		=> 'Selesai. Instruksi yang diproses:',
	'NoTableStructure'			=> 'Struktur tabel tidak disimpan - dilewati',
	'RestoreRecords'			=> 'Memulihkan isi tabel',
	'ProcessTablesDump'			=> 'Hanya unduh dan proses dump tabel',
	'Instruction'				=> 'Instruksi',
	'RestoredRecords'			=> 'catatan:',
	'RecordsRestoreDone'		=> 'Selesai. Total entri:',
	'SkippedRecords'			=> 'Data tidak disimpan - dilewati',
	'RestoringFiles'			=> 'Memulihkan berkas',
	'DecompressAndStore'		=> 'Dekompresi dan simpan isi direktori',
	'HomonymicFiles'			=> 'berkas homonim',
	'RestoreSkip'				=> 'lewati',
	'RestoreReplace'			=> 'gantikan',
	'RestoreFile'				=> 'Berkas:',
	'RestoredFiles'				=> 'dipulihkan:',
	'SkippedFiles'				=> 'dilewati:',
	'FileRestoreDone'			=> 'Selesai. Total berkas:',
	'FilesAll'					=> 'semua:',
	'SkipFiles'					=> 'Berkas tidak disimpan - dilewati',
	'RestoreDone'				=> 'PEMULIHAN SELESAI',

	'BackupCreationDate'		=> 'Tanggal Pembuatan',
	'BackupPackageContents'		=> 'Isi paket',
	'BackupRestore'				=> 'Pulihkan',
	'BackupRemove'				=> 'Hapus',
	'RestoreYes'				=> 'Ya',
	'RestoreNo'					=> 'Tidak',
	'LogDbRestored'				=> 'Cadangan ##%1## basis data dipulihkan.',

	'BackupArchived'			=> 'Cadangan %1 diarsipkan.',
	'BackupArchiveExists'		=> 'Arsip cadangan %1 sudah ada.',
	'LogBackupArchived'			=> 'Cadangan ##%1## diarsipkan.',

	// User module
	'UsersInfo'					=> 'Di sini Anda dapat mengubah informasi pengguna dan opsi tertentu yang spesifik.',

	'UsersAdded'				=> 'Pengguna ditambahkan',
	'UsersDeleteInfo'			=> 'Hapus pengguna:',
	'EditButton'				=> 'Sunting',
	'UsersAddNew'				=> 'Tambah pengguna baru',
	'UsersDelete'				=> 'Apakah Anda yakin ingin menghapus pengguna %1?',
	'UsersDeleted'				=> 'Pengguna %1 telah dihapus dari database.',
	'UsersRename'				=> 'Ubah nama pengguna %1 menjadi',
	'UsersRenameInfo'			=> '* Catatan: Perubahan akan mempengaruhi semua halaman yang ditugaskan ke pengguna tersebut.',
	'UsersUpdated'				=> 'Pengguna berhasil diperbarui.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Waktu pendaftaran',
	'UserActions'				=> 'Aksi',
	'NoMatchingUser'			=> 'Tidak ada pengguna yang memenuhi kriteria',

	'UserAccountNotify'			=> 'Beritahu pengguna',
	'UserNotifySignup'			=> 'beritahu pengguna tentang akun baru',
	'UserVerifyEmail'			=> 'atur token konfirmasi email dan tambahkan tautan untuk verifikasi email',
	'UserReVerifyEmail'			=> 'Kirim ulang token konfirmasi email',

	// Groups module
	'GroupsInfo'				=> 'Dari panel ini Anda dapat mengelola semua grup pengguna Anda. Anda dapat menghapus, membuat, dan mengedit grup yang ada. Selain itu, Anda dapat memilih pemimpin grup, mengubah status grup terbuka/tersembunyi/tertutup, serta mengatur nama dan deskripsi grup.',

	'LogMembersUpdated'			=> 'Anggota grup pengguna diperbarui',
	'LogMemberAdded'			=> 'Menambahkan anggota ##%1## ke grup ##%2##',
	'LogMemberRemoved'			=> 'Menghapus anggota ##%1## dari grup ##%2##',
	'LogGroupCreated'			=> 'Membuat grup baru ##%1##',
	'LogGroupRenamed'			=> 'Grup ##%1## diubah nama menjadi ##%2##',
	'LogGroupRemoved'			=> 'Menghapus grup ##%1##',

	'GroupsMembersFor'			=> 'Anggota untuk Grup',
	'GroupsDescription'			=> 'Deskripsi',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Terbuka',
	'GroupsActive'				=> 'Aktif',
	'GroupsTip'					=> 'Klik untuk mengedit Grup',
	'GroupsUpdated'				=> 'Grup diperbarui',
	'GroupsAlreadyExists'		=> 'Grup ini sudah ada.',
	'GroupsAdded'				=> 'Grup berhasil ditambahkan.',
	'GroupsRenamed'				=> 'Grup berhasil diubah nama.',
	'GroupsDeleted'				=> 'Grup %1 dan semua halaman terkait telah dihapus dari database.',
	'GroupsAdd'					=> 'Tambah grup baru',
	'GroupsRename'				=> 'Ubah nama grup %1 menjadi',
	'GroupsRenameInfo'			=> '* Catatan: Perubahan akan mempengaruhi semua halaman yang ditugaskan ke grup tersebut.',
	'GroupsDelete'				=> 'Apakah Anda yakin ingin menghapus grup %1?',
	'GroupsDeleteInfo'			=> '* Catatan: Perubahan akan mempengaruhi semua anggota yang ditugaskan ke grup tersebut.',
	'GroupsIsSystem'			=> 'Grup %1 termasuk dalam sistem dan tidak dapat dihapus.',
	'GroupsStoreButton'			=> 'Simpan Grup',
	'GroupsEditInfo'			=> 'Untuk mengedit daftar grup pilih tombol radio.',

	'GroupAddMember'			=> 'Tambah anggota',
	'GroupRemoveMember'			=> 'Hapus Anggota',
	'GroupAddNew'				=> 'Tambah grup',
	'GroupEdit'					=> 'Edit Grup',
	'GroupDelete'				=> 'Hapus Grup',

	'MembersAddNew'				=> 'Tambah anggota baru',
	'MembersAdded'				=> 'Anggota baru berhasil ditambahkan ke grup.',
	'MembersRemove'				=> 'Apakah Anda yakin ingin menghapus anggota %1?',
	'MembersRemoved'			=> 'Anggota telah dihapus dari grup.',

	// Statistics module
	'DbStatSection'				=> 'Statistik Basis Data',
	'DbTable'					=> 'Tabel',
	'DbRecords'					=> 'Catatan',
	'DbSize'					=> 'Ukuran',
	'DbIndex'					=> 'Indeks',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'Statistik Sistem Berkas',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> 'Berkas',
	'FileSize'					=> 'Ukuran',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Informasi Versi:',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Nilai',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Pembaruan terakhir',
	'ServerOS'					=> 'Sistem Operasi',
	'ServerName'				=> 'Nama Server',
	'WebServer'					=> 'Server Web',
	'HttpProtocol'				=> 'Protokol HTTP',
	'DbVersion'					=> 'Basis Data',
	'SqlModesGlobal'			=> 'Mode SQL Global',
	'SqlModesSession'			=> 'Mode SQL Sesi',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Batas Memori',
	'UploadFilesizeMax'			=> 'Ukuran Berkas Unggah Maksimum',
	'PostMaxSize'				=> 'Ukuran Post Maksimum',
	'MaxExecutionTime'			=> 'Waktu Eksekusi Maksimum',
	'SessionPath'				=> 'Path Sesi',
	'PhpDefaultCharset'			=> 'Set Karakter Default PHP',
	'GZipCompression'			=> 'Kompresi GZip',
	'PhpExtensions'				=> 'Ekstensi PHP',
	'ApacheModules'				=> 'Modul Apache',

	// DB repair module
	'DbRepairSection'			=> 'Perbaikan Basis Data',
	'DbRepair'					=> 'Perbaiki Basis Data',
	'DbRepairInfo'				=> 'Skrip ini dapat secara otomatis mencari beberapa masalah umum basis data dan memperbaikinya. Perbaikan dapat memakan waktu lama, jadi harap bersabar.',

	'DbOptimizeRepairSection'	=> 'Perbaikan dan Optimisasi Basis Data',
	'DbOptimizeRepair'			=> 'Perbaiki dan Optimalkan Basis Data',
	'DbOptimizeRepairInfo'		=> 'Skrip ini juga dapat mencoba mengoptimalkan basis data. Ini meningkatkan kinerja dalam beberapa situasi. Perbaikan dan optimisasi basis data dapat memakan waktu lama dan basis data akan terkunci selama proses optimisasi.',

	'TableOk'					=> 'Tabel %1 dalam keadaan baik.',
	'TableNotOk'				=> 'Tabel %1 tidak dalam keadaan baik. Menampilkan kesalahan berikut: %2. Skrip ini akan mencoba memperbaiki tabel ini…',
	'TableRepaired'				=> 'Berhasil memperbaiki tabel %1.',
	'TableRepairFailed'			=> 'Gagal memperbaiki tabel %1.
Kesalahan: %2',
	'TableAlreadyOptimized'		=> 'Tabel %1 sudah dioptimalkan.',
	'TableOptimized'			=> 'Berhasil mengoptimalkan tabel %1.',
	'TableOptimizeFailed'		=> 'Gagal mengoptimalkan tabel %1.
Kesalahan: %2',
	'TableNotRepaired'			=> 'Beberapa masalah basis data tidak dapat diperbaiki.',
	'RepairsComplete'			=> 'Perbaikan selesai',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Tampilkan dan perbaiki inkonsistensi, hapus atau tetapkan catatan yatim ke pengguna/nilai baru.',
	'Inconsistencies'			=> 'Inkonsistensi',
	'CheckDatabase'				=> 'Basis Data',
	'CheckDatabaseInfo'			=> 'Memeriksa inkonsistensi catatan dalam basis data.',
	'CheckFiles'				=> 'Berkas',
	'CheckFilesInfo'			=> 'Memeriksa berkas yang terabaikan, berkas yang tidak memiliki referensi dalam tabel berkas.',
	'Records'					=> 'Catatan',
	'InconsistenciesNone'		=> 'Tidak ditemukan Inkonsistensi Data.',
	'InconsistenciesDone'		=> 'Inkonsistensi Data telah diselesaikan.',
	'InconsistenciesRemoved'	=> 'Inkonsistensi yang dihapus',
	'Check'						=> 'Periksa',
	'Solve'						=> 'Selesaikan',

	// Bad Behaviour module
	'BbInfo'					=> 'Mendeteksi dan memblokir akses web yang tidak diinginkan, mencegah akses bot spam otomatis.
Untuk informasi lebih lanjut, kunjungi halaman utama %1.',
	'BbEnable'					=> 'Aktifkan Bad Behaviour:',
	'BbEnableInfo'				=> 'Semua pengaturan lain dapat diubah di folder konfigurasi %1.',
	'BbStats'					=> 'Bad Behaviour telah memblokir %1 upaya akses dalam 7 hari terakhir.',

	'BbSummary'					=> 'Ringkasan',
	'BbLog'						=> 'Log',
	'BbSettings'				=> 'Pengaturan',
	'BbWhitelist'				=> 'Daftar Putih',

	// --> Log
	'BbHits'					=> 'Hits',
	'BbRecordsFiltered'			=> 'Menampilkan %1 dari %2 catatan yang difilter berdasarkan',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Diblokir',
	'BbPermitted'				=> 'Diizinkan',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Menampilkan semua %1 catatan',
	'BbShow'					=> 'Tampilkan',
	'BbIpDateStatus'			=> 'IP/Tanggal/Status',
	'BbHeaders'					=> 'Header',
	'BbEntity'					=> 'Entitas',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Pengaturan disimpan.',
	'BbWhitelistHint'			=> 'Daftar putih yang tidak tepat AKAN membuat Anda terpapar spam, atau menyebabkan Bad Behaviour berhenti berfungsi sama sekali! JANGAN MELAKUKAN DAFTAR PUTIH kecuali Anda 100% YAKIN bahwa Anda harus melakukannya.',
	'BbIpAddress'				=> 'Alamat IP',
	'BbIpAddressInfo'			=> 'Alamat IP atau rentang alamat dalam format CIDR yang akan dimasukkan dalam daftar putih (satu per baris)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'Fragmen URL yang dimulai dengan / setelah nama host situs web Anda (satu per baris)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'String user agent yang akan dimasukkan dalam daftar putih (satu per baris)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Pengaturan Bad Behaviour diperbarui',
	'BbLogRequest'				=> 'Mencatat permintaan HTTP',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (direkomendasikan)',
	'BbLogOff'					=> 'Jangan mencatat (tidak direkomendasikan)',
	'BbSecurity'				=> 'Keamanan',
	'BbStrict'					=> 'Pemeriksaan ketat',
	'BbStrictInfo'				=> 'memblokir lebih banyak spam tetapi mungkin memblokir beberapa pengguna',
	'BbOffsiteForms'			=> 'Izinkan pengiriman formulir dari situs web lain',
	'BbOffsiteFormsInfo'		=> 'diperlukan untuk OpenID; meningkatkan spam yang diterima',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Untuk menggunakan fitur http:BL Bad Behaviour, Anda harus memiliki %1',
	'BbHttpblKey'				=> 'Kunci Akses http:BL',
	'BbHttpblThreat'			=> 'Tingkat Ancaman Minimum (25 direkomendasikan)',
	'BbHttpblMaxage'			=> 'Usia Maksimum Data (30 direkomendasikan)',
	'BbReverseProxy'			=> 'Reverse Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'Jika Anda menggunakan Bad Behaviour di belakang reverse proxy, load balancer, HTTP accelerator, content cache atau teknologi serupa, aktifkan opsi Reverse Proxy.
' .
									'Jika Anda memiliki rantai dua atau lebih reverse proxy antara server Anda dan Internet publik, Anda harus menentukan semua rentang alamat IP (dalam format CIDR) dari semua server proxy, load balancer, dll. Anda. Jika tidak, Bad Behaviour mungkin tidak dapat menentukan alamat IP sebenarnya dari klien.
' .
									'Selain itu, server reverse proxy Anda harus menetapkan alamat IP klien Internet dari mana mereka menerima permintaan dalam header HTTP. Jika Anda tidak menentukan header, %1 akan digunakan. Kebanyakan server proxy sudah mendukung X-Forwarded-For dan Anda hanya perlu memastikan bahwa itu diaktifkan pada server proxy Anda. Beberapa nama header lain yang umum digunakan termasuk %2 dan %3.',
	'BbReverseProxyEnable'		=> 'Aktifkan Reverse Proxy',
	'BbReverseProxyHeader'		=> 'Header yang berisi alamat IP klien Internet',
	'BbReverseProxyAddresses'	=> 'Alamat IP atau rentang alamat dalam format CIDR untuk server proxy Anda (satu per baris)',

];
