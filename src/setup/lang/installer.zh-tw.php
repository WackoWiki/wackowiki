<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'zh-tw',
'LangLocale'	=> 'zh_TW',
'LangName'		=> '正體中文',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> '分類',
	'groups_page'		=> '群組',
	'users_page'		=> '使用者',
	'tools_page'		=> '工具',

	'search_page'		=> '搜尋',
	'login_page'		=> '登入',
	'account_page'		=> '設定',
	'registration_page'	=> '建立帳號',
	'password_page'		=> '密碼',

	'whatsnew_page'		=> 'WhatsNew',
	'changes_page'		=> '近期變動',
	'comments_page'		=> '最近評論',
	'index_page'		=> '頁面索引',

	'random_page'		=> '隨機頁面',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki 安裝',
'TitleUpdate'					=> 'WackoWiki Update',
'Continue'						=> '繼續',
'Back'							=> '返回',
'Recommended'					=> '建議',
'InvalidAction'					=> '動作無效',

/*
   Locking Check
 */
'LockAuthorization'				=> '授權',
'LockAuthorizationInfo'			=> '請輸入您儲存在檔案 %1 中的密碼。',
'LockPassword'					=> '密碼:',
'LockLogin'						=> '登入',
'LockPasswordInvalid'			=> '密碼無效。',
'LockedTryLater'				=> '本網站正在升級中，請稍後再試。',
'EmptyAuthFile'					=> '缺少或空的 %1 檔案。請建立該檔案並在其中設定密碼。',


/*
   Language Selection Page
*/
'lang'							=> '語言設定',
'PleaseUpgradeToR6'				=> '您似乎正在使用舊版本的 WackoWiki %1。若要更新至此版本的 WackoWiki，您必須先將安裝更新至 %2。',
'UpgradeFromWacko'				=> '歡迎來到 WackoWiki！您似乎正在從 WackoWiki %1 升級至 %2。接下來的幾頁將引導您完成升級流程。',
'FreshInstall'					=> '歡迎來到 WackoWiki！您即將安裝 WackoWiki %1。接下來的頁面將引導您完成安裝流程。',
'PleaseBackup'					=> '請務必在啟動升級程序前，<strong>備份</strong>您的資料庫、設定檔以及所有已修改的檔案（例如已套用本地化修改或修補程式之檔案）。此舉可避免您日後陷入棘手的困境。',
'LangDesc'						=> '請選擇安裝程序的語言。此語言亦將作為您的 WackoWiki 安裝預設語言。',

/*
   System Requirements Page
*/
'version-check'					=> '系統需求',
'PhpVersion'					=> 'PHP 版本',
'PhpDetected'					=> '偵測到的 PHP',
'ModRewrite'					=> 'Apache Rewrite 擴充（選用）',
'ModRewriteInstalled'			=> '是否已安裝 Rewrite 擴充（mod_rewrite）？',
'Database'						=> '資料庫',
'PhpExtensions'					=> 'PHP 擴充模組',
'Permissions'					=> '權限',
'ReadyToInstall'				=> '準備好安裝了嗎？',
'Requirements'					=> '您的伺服器必須符合下列需求。',
'OK'							=> '確定',
'Problem'						=> '問題',
'Example'						=> '範例',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> '您的 PHP 安裝似乎缺少 WackoWiki 所需的 PHP 擴充模組。',
'PcreWithoutUtf8'				=> 'PHP 的 PCRE 模組在編譯時未包含 PCRE_UTF8 支援。',
'NotePermissions'				=> '本安裝程式會嘗試將設定資料寫入位於 WackoWiki 目錄內的檔案 %1。為使此動作成功，請確定網頁伺服器對該檔案具有寫入權限。如果無法設定，您將必須手動編輯該檔案（安裝程式會告訴您如何操作）。<br><br>詳細資訊請參閱 <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>。',
'ErrorPermissions'				=> '看起來安裝程式無法自動設定 WackoWiki 正常運作所需的檔案權限。安裝過程中稍後會提示您在伺服器上手動設定這些權限。',
'ErrorMinPhpVersion'			=> 'PHP 版本必須高於 %1。您的伺服器似乎執行的是較舊的版本。您必須升級 PHP 才能讓 WackoWiki 正常運作。',
'Ready'							=> '恭喜，您的伺服器看起來可以執行 WackoWiki。接下來的幾個頁面將引導您完成設定程序。',

/*
   Site Config Page
*/
'config-site'					=> '網站設定',
'SiteName'						=> 'Wiki 名稱',
'SiteNameDesc'					=> '請輸入您的 Wiki 站點名稱。',
'SiteNameDefault'				=> '我的 wiki',
'HomePage'						=> '首頁',
'HomePageDesc'					=> '輸入您希望首頁使用的名稱。這將是使用者造訪站點時預設看到的頁面，應該為一個 <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>。',
'HomePageDefault'				=> '首頁',
'MultiLang'						=> '多語系模式',
'MultiLangDesc'					=> '多語系模式允許在單一安裝中為不同頁面設定不同語言。啟用此模式後，安裝程式會為發行版中提供的所有語言建立初始選單項目。',
'AllowedLang'					=> '允許的語言',
'AllowedLangDesc'				=> '建議只選取您打算使用的語言集合，否則會選取所有語言。',
'AclMode'						=> '預設 ACL 設定',
'AclModeDesc'					=> '',
'PublicWiki'					=> '公開 Wiki（所有人可閱讀，註冊使用者可撰寫與評論）',
'PrivateWiki'					=> '私人 Wiki（僅限註冊使用者閱讀、撰寫、評論）',
'Admin'							=> '管理員帳號',
'AdminDesc'						=> '輸入管理員的使用者名稱。此名稱應為 <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>（例如 <code>WikiAdmin</code>）。',
'NameAlphanumOnly'				=> '使用者名稱必須介於 %1 到 %2 個字元，且僅能使用英數字元。大寫字母亦可。',
'NameCamelCaseOnly'				=> '使用者名稱長度必須在 %1 - %2 字元間，並且符合 WikiName 格式。',
'Password'						=> '管理員密碼',
'PasswordDesc'					=> '為管理員選擇一組至少 %1 字元的密碼。',
'PasswordConfirm'				=> '重複密碼：',
'Mail'							=> '管理員電子郵件地址',
'MailDesc'						=> '輸入管理員的電子郵件地址。',
'Base'							=> '基礎 URL',
'BaseDesc'						=> '您的 WackoWiki 站點基礎 URL。頁面名稱會附加在其後；若使用 mod_rewrite，地址應以斜線結尾，例如。',
'Rewrite'						=> '重寫模式',
'RewriteDesc'					=> '若您在使用 URL 重寫功能，應啟用重寫模式（Rewrite mode）。',
'Enabled'						=> '啟用：',
'ErrorAdminEmail'				=> '您輸入的電子郵件地址無效！',
'ErrorAdminPasswordMismatch'	=> '兩次輸入的密碼不相符！',
'ErrorAdminPasswordShort'		=> '管理員密碼太短！最低長度為 %1 個字元。',
'ModRewriteStatusUnknown'		=> '安裝程式無法確認 mod_rewrite 是否已啟用。但這並不表示它已停用。',

/*
   Database Config Page
*/
'config-database'				=> '資料庫設定',
'DbDriver'						=> '驅動程式',
'DbDriverDesc'					=> '您要使用的資料庫驅動程式。',
'DbSqlMode'						=> 'SQL 模式',
'DbSqlModeDesc'					=> '您要使用的 SQL 模式。',
'DbVendor'						=> '供應商',
'DbVendorDesc'					=> '您使用的資料庫供應商。',
'DbCharset'						=> '字元集',
'DbCharsetDesc'					=> '您要使用的資料庫字元集。',
'DbEngine'						=> '儲存引擎',
'DbEngineDesc'					=> '您要使用的資料庫儲存引擎。',
'DbHost'						=> '資料庫主機',
'DbHostDesc'					=> '您的資料庫伺服器所在主機，通常為 <code>127.0.0.1</code> 或 <code>localhost</code>（即與 WackoWiki 相同的機器）。',
'DbPort'						=> '資料庫連接埠（選填）',
'DbPortDesc'					=> '您的資料庫伺服器可透過的連接埠號。留白以使用預設連接埠。',
'DbName'						=> '資料庫名稱',
'DbNameDesc'					=> 'WackoWiki 應使用的資料庫。此資料庫在繼續前必須已存在！',
'DbNameSqliteDesc'				=> 'SQLite 應使用的資料目錄與檔案名稱。',
'DbNameSqliteHelp'				=> 'SQLite 將所有資料儲存在單一檔案中。<br><br>安裝時，您所提供的目錄必須可由網頁伺服器寫入。<br><br>該目錄應該<strong>不可</strong>被網頁直接存取。<br><br>安裝程式會嘗試同步建立 <code>.htaccess</code> 檔案；若此機制失效，其他人可能會直接存取原始資料庫。<br>這將包含原始的使用者資料（電子郵件地址、雜湊後的密碼）、站內受保護頁面及其他限制性資料。<br><br>建議將資料庫儲存在其他位置，例如 <code>/var/lib/wackowiki/yourwiki</code>。',
'DbUser'						=> '資料庫使用者名稱',
'DbUserDesc'					=> '用於連接資料庫的使用者名稱。',
'DbPassword'					=> '資料庫密碼',
'DbPasswordDesc'				=> '用於連接資料庫的使用者密碼。',
'Prefix'						=> '資料表名稱字首',
'PrefixDesc'					=> 'WackoWiki 使用的所有資料表前綴。這讓您可以在同一資料庫中以不同前綴執行多個 WackoWiki 安裝（例如 wacko_）。',
'ErrorNoDbDriverDetected'		=> '未偵測到任何資料庫驅動程式，請在您的 php.ini 中啟用 mysqli 或 pdo_mysql 擴充。',
'ErrorNoDbDriverSelected'		=> '尚未選取資料庫驅動程式，請從列表中選擇一項。',
'DeleteTables'					=> '刪除現有資料表？',
'DeleteTablesDesc'				=> '注意！若繼續並勾選此選項，資料庫中所有現有的 wiki 資料將被清除。此操作無法還原，您需自行從備份手動還原資料。',
'ConfirmTableDeletion'			=> '您確定要刪除所有現有的 wiki 資料表嗎？',

/*
   Database Installation Page
*/
'install-database'				=> '資料庫安裝',
'TestingConfiguration'			=> '測試設定',
'TestConnectionString'			=> '測試資料庫連線設定',
'TestDatabaseExists'			=> '檢查您指定的資料庫是否存在',
'TestDatabaseVersion'			=> '檢查資料庫是否符合最低版本需求',
'SqliteFileExtensionError'		=> '請使用下列其中一種檔案副檔名：db、sdb、sqlite。',
'SqliteParentUnwritableGroup'	=> '無法建立資料目錄 <code>%1</code>，因網頁伺服器對上層目錄 <code>%2</code> 沒有寫入權限。<br><br>安裝程序使用的執行身份取決於您所使用的網頁伺服器設定；<br>請授予網頁伺服器對 <code>%3</code> 的寫入權限以繼續安裝。<br>在 Unix/Linux 系統上可以執行下列指令：<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> '無法建立資料目錄 <code>%1</code>，因網頁伺服器對上層目錄 <code>%2</code> 沒有寫入權限。<br><br>安裝程序使用的執行身份取決於您所使用的網頁伺服器設定；<br>請開放所有人對 <code>%3</code> 的寫入權限以繼續安裝。<br>在 Unix/Linux 系統上可以執行下列指令：<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> '建立資料目錄 <code>%1</code> 時發生錯誤。\n請檢查路徑後再試一次。',
'SqliteDirUnwritable'			=> '無法寫入目錄 <code>%1</code>。<br>請修改該目錄權限，開放網頁伺服器的寫入權限後再試一次。',
'SqliteReadonly'				=> '檔案 <code>%1</code> 無寫入權限。',
'SqliteCantCreateDb'			=> '無法建立資料庫檔案 <code>%1</code>。',
'InstallTables'					=> '建立資料表中',
'ErrorDbConnection'				=> '您所提供的資料庫連線資訊發生問題，請返回檢查是否正確。',
'ErrorDatabaseVersion'			=> '資料庫版本為 %1，但至少需要 %2。',
'To'							=> '到',
'AlterTable'					=> '變更 %1 資料表',
'InsertRecord'					=> '插入紀錄到 %1 資料表',
'RenameTable'					=> '重新命名 %1 資料表',
'UpdateTable'					=> '更新 %1 資料表',
'InstallDefaultData'			=> '加入預設資料',
'InstallPagesBegin'				=> '開始新增預設頁面',
'InstallPagesEnd'				=> '新增預設頁面完成',
'InstallSystemAccount'			=> '加入 <code>System</code> 帳號',
'InstallDeletedAccount'			=> '加入 <code>Deleted</code> 帳號',
'InstallAdmin'					=> '新增管理員',
'InstallAdminSetting'			=> '加入管理員使用者偏好設定',
'InstallAdminGroup'				=> '加入管理員群組',
'InstallAdminGroupMember'		=> '加入管理員群組成員',
'InstallEverybodyGroup'			=> '加入 Everybody 群組',
'InstallModeratorGroup'			=> '加入 Moderator 群組',
'InstallReviewerGroup'			=> '加入 Reviewer 群組',
'InstallLogoImage'				=> '加入標誌圖片',
'LogoImage'						=> '標誌圖片',
'InstallConfigValues'			=> '加入設定值',
'ConfigValues'					=> '設定值',
'ErrorInsertPage'				=> '插入 %1 頁面時發生錯誤',
'ErrorInsertPagePermission'		=> '設定 %1 頁面權限時發生錯誤',
'ErrorInsertDefaultMenuItem'	=> '設定頁面 %1 為預設選單項目時發生錯誤',
'ErrorPageAlreadyExists'		=> '%1 頁面已存在',
'ErrorAlterTable'				=> '變更 %1 資料表時發生錯誤',
'ErrorInsertRecord'				=> '插入紀錄到 %1 資料表時發生錯誤',
'ErrorRenameTable'				=> '重新命名 %1 資料表時發生錯誤',
'ErrorUpdatingTable'			=> '更新 %1 資料表時發生錯誤',
'CreatingTable'					=> '建立 %1 資料表',
'CreatingIndex'					=> '建立 %1 索引',
'CreatingTrigger'				=> '建立 %1 觸發器',
'ErrorAlreadyExists'			=> '%1 已存在',
'ErrorCreatingTable'			=> '建立 %1 資料表時發生錯誤，可能已經存在？',
'ErrorCreatingIndex'			=> '建立 %1 索引時發生錯誤，可能已經存在？',
'ErrorCreatingTrigger'			=> '建立 %1 觸發器時發生錯誤，可能已經存在？',
'DeletingTables'				=> '刪除資料表中',
'DeletingTablesEnd'				=> '刪除資料表完成',
'ErrorDeletingTable'			=> '刪除 %1 資料表時發生錯誤。最可能的原因是該資料表不存在，在此情況下您可以忽略此警告。',
'DeletingTable'					=> '刪除 %1 資料表',
'NextStep'						=> '在下一步中，安裝程式會嘗試寫入更新後的設定檔 %1。請確認網頁伺服器對該檔案具有寫入權限，否則您將必須手動編輯它。再次提醒，詳情請參閱 <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>。',

/*
   Write Config Page
*/
'write-config'					=> '寫入設定檔',
'FinalStep'						=> '最後一步',
'Writing'						=> '寫入設定中',
'RemovingWritePrivilege'		=> '移除寫入權限中',
'InstallationComplete'			=> '安裝完成',
'ThatsAll'						=> '完成！您現在可以 <a href="%1">檢視您的 WackoWiki 站點</a>。',
'SecurityConsiderations'		=> '安全性注意事項',
'SecurityRisk'					=> '建議在設定檔 %1 已寫入後移除其寫入權限。檔案保持可寫入可能造成安全風險！<br>例如 %2',
'RemoveSetupDirectory'			=> '安裝程序完成後，建議刪除目錄 %1。',
'ErrorGivePrivileges'			=> '無法寫入設定檔 %1。您需要臨時開放網頁伺服器對 WackoWiki 目錄或一個名為 %1 的空白檔案的寫入權限<br>%2。<br><br>別忘了稍後再次移除寫入權限，例如：<br>%3。<br><br>',
'ErrorPrivilegesInstall'		=> '若因任何原因無法如此操作，請將下方的文字複製到一個新檔案，並儲存/上傳為 %1 至 WackoWiki 目錄。完成後，您的 WackoWiki 站點應可正常運作。若仍有問題，請造訪 <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> '完成後，您的 WackoWiki 站點應可正常運作。若仍有問題，請造訪 <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> '寫於 ',
'DontChange'					=> '請勿手動修改 wacko_version！',
'ConfigDescription'				=> '詳細說明： https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> '再試一次',

];
