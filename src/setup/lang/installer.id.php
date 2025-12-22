<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'id',
'LangLocale'	=> 'id_ID',
'LangName'		=> 'Indonesian',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'Kategori',
	'groups_page'		=> 'Kelompok',
	'users_page'		=> 'Pengguna',

	'search_page'		=> 'Cari',
	'login_page'		=> 'Log masuk',
	'account_page'		=> 'Pengaturan',
	'registration_page'	=> 'Registrasi',
	'password_page'		=> 'Kata sandi',

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
'TitleInstallation'				=> 'Pemasangan WackoWiki',
'TitleUpdate'					=> 'Pembaruan WackoWiki',
'Continue'						=> 'Lanjutkan',
'Back'							=> 'Kembali',
'Recommended'					=> 'direkomendasikan',
'InvalidAction'					=> 'Invalid action',

/*
   Locking Check
 */
'LockAuthorization'				=> 'Otorisasi',
'LockAuthorizationInfo'			=> 'Silakan masukkan kata sandi yang Anda simpan dalam berkas %1.',
'LockPassword'					=> 'Kata sandi:',
'LockLogin'						=> 'Log masuk',
'LockPasswordInvalid'			=> 'Kata sandi tidak valid.',
'LockedTryLater'				=> 'Situs ini sedang dalam proses pembaruan. Silakan coba lagi nanti.',
'EmptyAuthFile'					=> 'Berkas %1 hilang atau kosong. Silakan buat berkas tersebut dan atur kata sandi di dalamnya.',


/*
   Language Selection Page
*/
'lang'							=> 'Konfigurasi Bahasa',
'PleaseUpgradeToR6'				=> 'Anda tampaknya menggunakan versi lama WackoWiki %1. Untuk memperbarui ke versi ini dari WackoWiki, Anda harus terlebih dahulu memperbarui instalasi Anda ke %2.',
'UpgradeFromWacko'				=> 'Selamat datang di WackoWiki! Sepertinya Anda sedang melakukan pembaruan dari WackoWiki %1 ke %2.  Halaman-halaman berikutnya akan memandu Anda melalui proses pembaruan.',
'FreshInstall'					=> 'Selamat datang di WackoWiki! Anda akan segera menginstal WackoWiki %1.  Halaman-halaman berikutnya akan memandu Anda melalui proses instalasi.',
'PleaseBackup'					=> 'Silakan, <strong>cadangkan</strong> basis data, berkas konfigurasi, dan semua berkas yang telah diubah, seperti berkas yang telah diterapkan modifikasi lokal atau tambalan, sebelum memulai proses pembaruan. Hal ini dapat menghindarkan Anda dari masalah besar.',
'LangDesc'						=> 'Silakan pilih bahasa untuk proses instalasi. Bahasa ini juga akan digunakan sebagai bahasa default untuk instalasi WackoWiki Anda.',

/*
   System Requirements Page
*/
'version-check'					=> 'Persyaratan Sistem',
'PhpVersion'					=> 'Versi PHP',
'PhpDetected'					=> 'Detected PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'Basis data',
'PhpExtensions'					=> 'Ekstensi PHP',
'Permissions'					=> 'Hak akses',
'ReadyToInstall'				=> 'Siap untuk dipasang?',
'Requirements'					=> 'Server Anda harus memenuhi persyaratan yang tercantum di bawah ini.',
'OK'							=> 'OK',
'Problem'						=> 'Masalah',
'Example'						=> 'Contoh',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Instalasi PHP Anda tampaknya tidak memiliki ekstensi PHP yang diperlukan oleh WackoWiki.',
'PcreWithoutUtf8'				=> 'PCRE tidak dikompilasi dengan dukungan UTF-8.',
'NotePermissions'				=> 'Pemasang ini akan mencoba menulis data konfigurasi ke berkas %1, yang terletak di direktori WackoWiki Anda. Agar ini berfungsi, pastikan server web memiliki akses tulis ke berkas tersebut.  Jika Anda tidak dapat melakukannya, Anda harus mengedit berkas tersebut secara manual (pemasang akan memberi tahu Anda caranya).<br><br>Lihat <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> untuk detailnya.',
'ErrorPermissions'				=> 'Sepertinya installer tidak dapat secara otomatis mengatur izin file yang diperlukan agar WackoWiki dapat berfungsi dengan benar. Anda akan diminta untuk secara manual mengatur izin file yang diperlukan pada server Anda pada tahap selanjutnya dalam proses instalasi.',
'ErrorMinPhpVersion'			=> 'Versi PHP harus lebih tinggi dari %1. Server Anda tampaknya menggunakan versi PHP yang lebih lama.  Anda harus memperbarui ke versi PHP yang lebih baru agar WackoWiki dapat berfungsi dengan benar.',
'Ready'							=> 'Selamat, sepertinya server Anda mampu menjalankan WackoWiki. Halaman-halaman berikutnya akan memandu Anda melalui proses konfigurasi.',

/*
   Site Config Page
*/
'config-site'					=> 'Konfigurasi Situs',
'SiteName'						=> 'Wiki Name',
'SiteNameDesc'					=> 'Silakan masukkan nama situs Wiki Anda.',
'SiteNameDefault'				=> 'MyWikiSite',
'HomePage'						=> 'Halaman Beranda',
'HomePageDesc'					=> 'Enter the name you would like your home page to have. This will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'HomePage',
'MultiLang'						=> 'Mode Multi Bahasa',
'MultiLangDesc'					=> 'Mode multibahasa memungkinkan Anda memiliki halaman dengan pengaturan bahasa yang berbeda dalam satu instalasi. Saat mode ini diaktifkan, penginstal akan membuat item menu awal untuk semua bahasa yang tersedia dalam distribusi.',
'AllowedLang'					=> 'Bahasa yang Diizinkan',
'AllowedLangDesc'				=> 'Disarankan untuk memilih hanya serangkaian bahasa yang ingin Anda gunakan, jika tidak, semua bahasa akan dipilih.',
'AclMode'						=> 'Pengaturan ACL default',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Wiki Publik (baca untuk semua orang, tulis dan komentari untuk pengguna terdaftar)',
'PrivateWiki'					=> 'Wiki Pribadi (baca, tulis, komentari hanya untuk pengguna terdaftar)',
'Admin'							=> 'Admin Name',
'AdminDesc'						=> 'Enter the admin\'s username. This should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Nama pengguna harus terdiri dari %1 hingga %2 karakter dan hanya menggunakan karakter alfanumerik. Huruf besar diperbolehkan.',
'NameCamelCaseOnly'				=> 'Nama pengguna harus terdiri dari %1 sampai %2 karakter dan menggunakan format WikiName.',
'Password'						=> 'Kata Sandi Admin',
'PasswordDesc'					=> 'Pilih kata sandi untuk admin dengan minimal %1 karakter.',
'PasswordConfirm'				=> 'Ulangi Kata Sandi:',
'Mail'							=> 'Alamat Email Admin',
'MailDesc'						=> 'Masukkan alamat email admin.',
'Base'							=> 'Base URL',
'BaseDesc'						=> 'URL dasar situs WackoWiki Anda.  Nama halaman ditambahkan ke URL tersebut, jadi jika Anda menggunakan mod_rewrite, alamat harus diakhiri dengan tanda slash (/), misalnya.',
'Rewrite'						=> 'Rewrite Mode',
'RewriteDesc'					=> 'Mode penulisan ulang harus diaktifkan jika Anda menggunakan WackoWiki dengan penulisan ulang URL.',
'Enabled'						=> 'Diaktifkan:',
'ErrorAdminEmail'				=> 'Anda telah memasukkan alamat email yang tidak valid!',
'ErrorAdminPasswordMismatch'	=> 'Kata sandi tidak cocok!.',
'ErrorAdminPasswordShort'		=> 'Kata sandi admin terlalu pendek! Panjang minimum adalah %1 karakter.',
'ModRewriteStatusUnknown'		=> 'Pemasang tidak dapat memverifikasi bahwa mod_rewrite diaktifkan. Namun, hal ini tidak berarti mod_rewrite dinonaktifkan.',

/*
   Database Config Page
*/
'config-database'				=> 'Konfigurasi Database',
'DbDriver'						=> 'Driver',
'DbDriverDesc'					=> 'Pengemudi basis data yang ingin Anda gunakan.',
'DbSqlMode'						=> 'SQL mode',
'DbSqlModeDesc'					=> 'Mode SQL yang ingin Anda gunakan.',
'DbVendor'						=> 'Vendor',
'DbVendorDesc'					=> 'Penyedia basis data yang Anda gunakan.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'Karakter set basis data yang ingin Anda gunakan.',
'DbEngine'						=> 'Engine',
'DbEngineDesc'					=> 'Mesin basis data yang ingin Anda gunakan.',
'DbHost'						=> 'Host',
'DbHostDesc'					=> 'Host di mana server basis data Anda berjalan, biasanya <code>127.0.0.1</code> atau <code>localhost</code> (yaitu, mesin yang sama di mana situs WackoWiki Anda berada).',
'DbPort'						=> 'Port (Optional)',
'DbPortDesc'					=> 'Nomor port yang digunakan untuk mengakses server basis data Anda. Biarkan kosong untuk menggunakan nomor port default.',
'DbName'						=> 'Database Name',
'DbNameDesc'					=> 'Database yang harus digunakan oleh WackoWiki. Database ini harus sudah ada sebelum Anda melanjutkan!',
'DbNameSqliteDesc'				=> 'Direktori data dan nama file yang harus digunakan SQLite untuk WackoWiki.',
'DbNameSqliteHelp'				=> 'SQLite menyimpan semua data dalam satu berkas.<br><br>Direktori yang Anda berikan harus dapat ditulis oleh server web selama proses instalasi.<br><br>Direktori tersebut <strong>tidak</strong> boleh dapat diakses melalui web. <br><br>Pemasang akan membuat berkas <code>.htaccess</code> bersamaan dengan itu, tetapi jika gagal, seseorang dapat mengakses basis data mentah Anda.<br>Hal ini termasuk data pengguna mentah (alamat email, kata sandi yang dienkripsi) serta halaman yang dilindungi dan data terbatas lainnya di wiki.<br><br>Pertimbangkan untuk menempatkan basis data di tempat lain sepenuhnya, misalnya di <code>/var/lib/wackowiki/yourwiki</code>.',
'DbUser'						=> 'User Name',
'DbUserDesc'					=> 'Nama pengguna yang digunakan untuk terhubung ke basis data Anda.',
'DbPassword'					=> 'Kata sandi',
'DbPasswordDesc'				=> 'Kata sandi pengguna yang digunakan untuk terhubung ke basis data Anda.',
'Prefix'						=> 'Table Prefix',
'PrefixDesc'					=> 'Prefiks untuk semua tabel yang digunakan oleh WackoWiki. Hal ini memungkinkan Anda untuk menjalankan beberapa instalasi WackoWiki menggunakan database yang sama dengan mengonfigurasi mereka untuk menggunakan prefiks tabel yang berbeda (misalnya wacko_).',
'ErrorNoDbDriverDetected'		=> 'Tidak ditemukan driver database, silakan aktifkan ekstensi mysqli atau pdo_mysql di berkas php.ini Anda.',
'ErrorNoDbDriverSelected'		=> 'Tidak ada driver database yang dipilih, silakan pilih salah satu dari daftar.',
'DeleteTables'					=> 'Delete Existing Tables?',
'DeleteTablesDesc'				=> 'PERHATIAN! Jika Anda melanjutkan dengan opsi ini dipilih, semua data wiki saat ini akan dihapus dari basis data Anda.  Hal ini tidak dapat dibatalkan, dan Anda diharuskan untuk memulihkan data secara manual dari cadangan.',
'ConfirmTableDeletion'			=> 'Apakah Anda yakin ingin menghapus semua tabel wiki yang ada saat ini?',

/*
   Database Installation Page
*/
'install-database'				=> 'Pemasangan Database',
'TestingConfiguration'			=> 'Konfigurasi Pengujian',
'TestConnectionString'			=> 'Pengujian pengaturan koneksi database',
'TestDatabaseExists'			=> 'Memeriksa apakah database yang Anda tentukan ada',
'TestDatabaseVersion'			=> 'Memverifikasi persyaratan versi minimum database',
'SqliteFileExtensionError'		=> 'Silakan gunakan salah satu ekstensi file berikut: db, sdb, sqlite.',
'SqliteParentUnwritableGroup'	=> 'Tidak dapat membuat direktori data <code>%1</code>, karena direktori induk <code>%2</code> tidak bisa ditulisi oleh server web.<br><br>Penginstal telah menentukan pengguna yang menjalankan server web Anda.<br>Buat direktori <code>%3</code> menjadi dapat ditulisi olehnya.<br>Pada sistem Unix/Linux lakukan hal berikut:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> 'Tidak dapat membuat direktori data <code>%1</code>, karena direktori induk <code>%2</code> tidak bisa ditulisi oleh server web.<br><br>Penginstal tidak dapat menentukan pengguna yang menjalankan server web Anda.<br>Buat direktori <code>%3</code> menjadi dapat ditulisi oleh semua orang.<br>Pada sistem Unix/Linux lakukan hal berikut:<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> 'Kesalahan saat membuat direktori data <code>%1</code>.<br>Periksa lokasi dan coba lagi.',
'SqliteDirUnwritable'			=> 'Tidak dapat menulisi direktori <code>%1</code>.<br>Ubah hak akses direktori sehingga server web dapat menulis ke sana, dan coba lagi.',
'SqliteReadonly'				=> 'Berkas <code>%1</code> tidak dapat ditulisi.',
'SqliteCantCreateDb'			=> 'Tidak dapat membuat berkas basis data <code>%1</code>.',
'InstallTables'					=> 'Installing Tables',
'ErrorDbConnection'				=> 'Ada masalah dengan detail koneksi database yang Anda tentukan, silakan periksa kembali apakah detail tersebut benar.',
'ErrorDatabaseVersion'			=> 'Versi database adalah %1 tetapi memerlukan setidaknya %2.',
'To'							=> 'ke',
'AlterTable'					=> 'Altering %1 table',
'InsertRecord'					=> 'Inserting Record into %1 table',
'RenameTable'					=> 'Renaming %1 table',
'UpdateTable'					=> 'Updating %1 table',
'InstallDefaultData'			=> 'Adding Default Data',
'InstallPagesBegin'				=> 'Adding Default Pages',
'InstallPagesEnd'				=> 'Finished Adding Default Pages',
'InstallSystemAccount'			=> 'Adding <code>System</code> User',
'InstallDeletedAccount'			=> 'Adding <code>Deleted</code> User',
'InstallAdmin'					=> 'Adding Admin User',
'InstallAdminSetting'			=> 'Adding Admin User Preferences',
'InstallAdminGroup'				=> 'Adding Admins Group',
'InstallAdminGroupMember'		=> 'Adding Admins Group Member',
'InstallEverybodyGroup'			=> 'Adding Everybody Group',
'InstallModeratorGroup'			=> 'Adding Moderator Group',
'InstallReviewerGroup'			=> 'Adding Reviewer Group',
'InstallLogoImage'				=> 'Adding Logo Image',
'LogoImage'						=> 'Logo image',
'InstallConfigValues'			=> 'Adding Config Values',
'ConfigValues'					=> 'Nilai Konfigurasi',
'ErrorInsertPage'				=> 'Error inserting %1 page',
'ErrorInsertPagePermission'		=> 'Error setting permission for %1 page',
'ErrorInsertDefaultMenuItem'	=> 'Error setting page %1 as default menu item',
'ErrorPageAlreadyExists'		=> 'The %1 page already exists',
'ErrorAlterTable'				=> 'Error altering %1 table',
'ErrorInsertRecord'				=> 'Error Inserting Record into %1 table',
'ErrorRenameTable'				=> 'Error renaming %1 table',
'ErrorUpdatingTable'			=> 'Error updating %1 table',
'CreatingTable'					=> 'Creating %1 table',
'CreatingIndex'					=> 'Creating %1 index',
'CreatingTrigger'				=> 'Creating %1 trigger',
'ErrorAlreadyExists'			=> 'The %1 already exists',
'ErrorCreatingTable'			=> 'Error creating %1 table, does it already exist?',
'ErrorCreatingIndex'			=> 'Error creating %1 index, does it already exist?',
'ErrorCreatingTrigger'			=> 'Error creating %1 trigger, does it already exist?',
'DeletingTables'				=> 'Deleting Tables',
'DeletingTablesEnd'				=> 'Finished Deleting Tables',
'ErrorDeletingTable'			=> 'Error deleting %1 table. The most likely reason is that the table does not exist, in which case you can ignore this warning.',
'DeletingTable'					=> 'Deleting %1 table',
'NextStep'						=> 'Pada langkah berikutnya, installer akan mencoba menulis file konfigurasi yang diperbarui, %1.  Pastikan server web memiliki akses tulis ke file tersebut, atau Anda harus mengeditnya secara manual.  Sekali lagi, lihat  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> untuk detailnya.',

/*
   Write Config Page
*/
'write-config'					=> 'Tulis Berkas Konfigurasi',
'FinalStep'						=> 'Langkah Terakhir',
'Writing'						=> 'Menulis Berkas Konfigurasi',
'RemovingWritePrivilege'		=> 'Menghapus Hak Tulis',
'InstallationComplete'			=> 'Pemasangan Selesai',
'ThatsAll'						=> 'Itu saja! Anda sekarang dapat <a href="%1">melihat situs WackoWiki Anda</a>.',
'SecurityConsiderations'		=> 'Pertimbangan Keamanan',
'SecurityRisk'					=> 'Anda disarankan untuk menghapus akses tulis ke %1 sekarang setelah file tersebut telah ditulis. Membiarkan file tetap dapat ditulis dapat menjadi risiko keamanan!<br>misalnya: %2',
'RemoveSetupDirectory'			=> 'Anda harus menghapus direktori %1 sekarang setelah proses instalasi selesai.',
'ErrorGivePrivileges'			=> 'Berkas konfigurasi %1 tidak dapat ditulis. Anda perlu memberikan akses tulis sementara kepada server web Anda ke direktori WackoWiki, atau berkas kosong bernama %1<br>%2.<br><br> Jangan lupa untuk menghapus akses tulis kembali nanti, yaitu <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Jika, karena alasan apa pun, Anda tidak dapat melakukan ini, Anda harus menyalin teks di bawah ini ke file baru dan menyimpannya/mengunggahnya sebagai %1 ke direktori WackoWiki. Setelah Anda melakukannya, situs WackoWiki Anda seharusnya berfungsi. Jika tidak, silakan kunjungi <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Setelah Anda melakukan ini, situs WackoWiki Anda seharusnya berfungsi. Jika tidak, silakan kunjungi <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'written at ',
'DontChange'					=> 'do not change wacko_version manually!',
'ConfigDescription'				=> 'detailed description: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Coba Lagi',

];
