<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> '基本功能',
		'preferences'	=> '偏好設定',
		'content'		=> '內容',
		'users'			=> '使用者',
		'maintenance'	=> '維護',
		'messages'		=> '訊息',
		'extension'		=> '擴充',
		'database'		=> '資料庫',
	],

	// Admin panel
	'AdminPanel'				=> '系統管理控制面板',
	'RecoveryMode'				=> '復原模式',
	'Authorization'				=> '授權',
	'AuthorizationTip'			=> '請輸入管理員密碼（也請確認瀏覽器允許使用 Cookie）。',
	'NoRecoveryPassword'		=> '未設定管理員密碼！',
	'NoRecoveryPasswordTip'		=> '注意：未設定管理員密碼會造成安全風險！請在設定檔中輸入您的密碼雜湊後重新執行程式。',

	'ErrorLoadingModule'		=> '載入管理模組 %1 時發生錯誤：不存在。',

	'ApHomePage'				=> '首頁',
	'ApHomePageTip'				=> '開啟首頁，但不離開管理介面',
	'ApLogOut'					=> '登出',
	'ApLogOutTip'				=> '離開系統管理',

	'TimeLeft'					=> '剩餘時間： %1 分鐘',
	'ApVersion'					=> '版本',

	'SiteOpen'					=> '開啟',
	'SiteOpened'				=> '網站已開啟',
	'SiteOpenedTip'				=> '網站目前為開放狀態',
	'SiteClose'					=> '關閉',
	'SiteClosed'				=> '網站已關閉',
	'SiteClosedTip'				=> '網站目前已關閉',

	'System'					=> '系統管理',

	// Generic
	'Cancel'					=> '取消',
	'Add'						=> '新增',
	'Edit'						=> '編輯',
	'Remove'					=> '移除',
	'Enabled'					=> '已啟用',
	'Disabled'					=> '已停用',
	'Mandatory'					=> '必填',
	'Admin'						=> '管理',
	'Min'						=> '最小',
	'Max'						=> '最大',

	'MiscellaneousSection'		=> '其他項目',
	'MainSection'				=> '一般選項',

	'DirNotWritable'			=> '%1 目錄不可寫入。',
	'FileNotWritable'			=> '%1 檔案不可寫入。',

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
		'name'		=> '基本',
		'title'		=> '基本設定',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> '外觀',
		'title'		=> '外觀設定',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> '電郵',
		'title'		=> '電郵設定',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> '聚合',
		'title'		=> '聚合設定',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> '篩選器',
		'title'		=> '篩選器設定',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> '格式化',
		'title'		=> '格式化選項',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> '通知',
		'title'		=> '通知設定',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> '頁面',
		'title'		=> '頁面與站點參數',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> '權限',
		'title'		=> '權限設定',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> '安全性',
		'title'		=> '安全子系統設定',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> '系統管理',
		'title'		=> '系統選項',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> '上傳',
		'title'		=> '附件設定',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> '已刪除',
		'title'		=> '最近刪除的內容',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> '選單',
		'title'		=> '新增、編輯或移除預設選單項目',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> '備份',
		'title'		=> '資料備份',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> '修復',
		'title'		=> '修復與優化資料庫',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> '復原',
		'title'		=> '還原備份資料',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> '主選單',
		'title'		=> 'WackoWiki 管理',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> '資料不一致',
		'title'		=> '修正資料不一致性',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> '資料同步',
		'title'		=> '同步資料',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> '大量郵件',
		'title'		=> '大量郵件',
	],

	// System message module
	'messages'		=> [
		'name'		=> '系統訊息',
		'title'		=> '系統訊息',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> '系統資訊',
		'title'		=> '系統資訊',
	],

	// System log module
	'system_log'		=> [
		'name'		=> '系統日誌',
		'title'		=> '系統事件日誌',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> '統計',
		'title'		=> '顯示統計資料',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> '不當行為防護',
		'title'		=> '不當行為防護',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> '審核',
		'title'		=> '使用者註冊審核',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> '群組',
		'title'		=> '群組管理',
	],

	// User module
	'user_users'		=> [
		'name'		=> '使用者',
		'title'		=> '使用者管理',
	],

	// 主模組
	'MainNote'					=> '注意：建議在進行管理維護時暫時封鎖對網站的存取。',

	'PurgeSessions'				=> '清除',
	'PurgeSessionsTip'			=> '清除所有會話',
	'PurgeSessionsConfirm'		=> '您確定要清除所有會話嗎？這將會登出所有使用者。',
	'PurgeSessionsExplain'		=> '清除所有會話。這將透過截斷 auth_token 資料表來登出所有使用者。',
	'PurgeSessionsDone'			=> '會話已成功清除。',

	// 基本設定
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> '已更新基本設定',
	'LogBasicSettingsUpdated'	=> '已更新基本設定',

	'SiteName'					=> '網站名稱：',
	'SiteNameInfo'				=> '此網站的標題，會顯示於瀏覽器標題、佈景表頭、電子郵件通知等處。',
	'SiteDesc'					=> '網站描述：',
	'SiteDescInfo'				=> '作為網站標題的補充，顯示於頁面標頭內，用幾個字說明此網站的內容。',
	'AdminName'					=> '網站管理者：',
	'AdminNameInfo'				=> '負責整體支援網站的使用者名稱。此名稱不會用於決定存取權限，但建議與網站首席管理者的名稱一致。',

	'LanguageSection'			=> '語言',
	'DefaultLanguage'			=> '預設語言：',
	'DefaultLanguageInfo'		=> '指定未註冊訪客所看到的訊息語言，以及區域設定。',
	'MultiLanguage'				=> '多語支援：',
	'MultiLanguageInfo'			=> '啟用在各頁面選擇語言的功能。',
	'AllowedLanguages'			=> '允許的語言：',
	'AllowedLanguagesInfo'		=> '建議只選擇您要使用的語言集合，否則會選取所有語言。',

	'CommentSection'			=> '回應',
	'AllowComments'				=> '允許回應：',
	'AllowCommentsInfo'			=> '為訪客或僅註冊使用者啟用回應，或在整個網站停用回應。',
	'SortingComments'			=> '回應排序：',
	'SortingCommentsInfo'		=> '變更頁面回應的顯示順序，最近或最舊的回應顯示在最上方。',
	'CommentsOffset'			=> '回應頁面：',
	'CommentsOffsetInfo'		=> '預設顯示的留言頁面',

	'ToolbarSection'			=> '工具列',
	'CommentsPanel'				=> '回應面板：',
	'CommentsPanelInfo'			=> '預設在頁面底部顯示的回應面板。',
	'FilePanel'					=> '檔案面板：',
	'FilePanelInfo'				=> '預設在頁面底部顯示的附件面板。',
	'TagsPanel'					=> '標籤面板：',
	'TagsPanelInfo'				=> '預設在頁面底部顯示的標籤面板。',

	'NavigationSection'			=> '導覽',
	'ShowPermalink'				=> '顯示永久連結：',
	'ShowPermalinkInfo'			=> '預設顯示目前版本頁面的永久連結。',
	'TocPanel'					=> '目錄面板：',
	'TocPanelInfo'				=> '預設顯示頁面的目錄面板（可能需要佈景範本支援）。',
	'SectionsPanel'				=> '章節面板：',
	'SectionsPanelInfo'			=> '預設顯示相鄰頁面的面板（需要範本支援）。',
	'DisplayingSections'		=> '章節顯示：',
	'DisplayingSectionsInfo'	=> '針對先前選項，決定僅顯示頁面的子頁（<em>lower</em>）、僅顯示同級頁（<em>top</em>）或兩者，或以樹狀（<em>tree</em>）方式顯示。',
	'MenuItems'					=> '選單項目：',
	'MenuItemsInfo'				=> '預設顯示的選單項目數（可能需要範本支援）。',

	'HandlerSection'			=> '處理器',
	'HideRevisions'				=> '隱藏修訂：',
	'HideRevisionsInfo'			=> '預設是否顯示頁面的修訂紀錄。',
	'AttachmentHandler'			=> '啟用附件處理器：',
	'AttachmentHandlerInfo'		=> '允許顯示附件處理器。',
	'SourceHandler'				=> '啟用原始碼處理器：',
	'SourceHandlerInfo'			=> '允許顯示原始碼處理器。',
	'ExportHandler'				=> '啟用 XML 匯出處理器：',
	'ExportHandlerInfo'			=> '允許顯示 XML 匯出處理器。',

	'DiffModeSection'			=> '差異模式',
	'DefaultDiffModeSetting'	=> '預設差異模式：',
	'DefaultDiffModeSettingInfo'=> '預選的差異比較模式。',
	'AllowedDiffMode'			=> '允許的差異模式：',
	'AllowedDiffModeInfo'		=> '建議只選擇您要使用的差異模式集合，否則會選取所有差異模式。',
	'NotifyDiffMode'			=> '通知差異模式：',
	'NotifyDiffModeInfo'		=> '用於電子郵件內文通知的差異顯示模式。',

	'EditingSection'			=> '編輯',
	'EditSummary'				=> '編輯摘要：',
	'EditSummaryInfo'			=> '在編輯模式顯示變更摘要。',
	'MinorEdit'					=> '小幅修改：',
	'MinorEditInfo'				=> '在編輯模式啟用小幅修改選項。',
	'SectionEdit'				=> '部分編輯：',
	'SectionEditInfo'			=> '僅允許編輯頁面的一部分。',
	'ReviewSettings'			=> '審核：',
	'ReviewSettingsInfo'		=> '在編輯模式啟用審核選項。',
	'PublishAnonymously'		=> '允許匿名發布：',
	'PublishAnonymouslyInfo'	=> '允許使用者以匿名方式發布（隱藏姓名）。',

	'DefaultRenameRedirect'		=> '重新命名時建立重定向：',
	'DefaultRenameRedirectInfo'	=> '預設在重新命名頁面時，提供將舊網址設為重定向的選項。',
	'StoreDeletedPages'			=> '保留已刪除的頁面：',
	'StoreDeletedPagesInfo'		=> '當您刪除頁面、評論或檔案時，將其保留在特殊區段，讓它在一段時間內可以被檢視和復原（如下所述）。',
	'KeepDeletedTime'			=> '已刪除頁面的保存期限：',
	'KeepDeletedTimeInfo'		=> '以天為單位的期間。此設定僅在前一選項啟用時有意義。輸入零表示永久保留（此時管理員可手動清除「回收站」）。',
	'PagesPurgeTime'			=> '頁面修訂保存時間：',
	'PagesPurgeTimeInfo'		=> '自動刪除在指定天數之前的舊版本。若輸入零，舊版本將不會被移除。',
	'EnableReferrers'			=> '啟用引用來源：',
	'EnableReferrersInfo'		=> '允許儲存並顯示外部引用來源（referrers）。',
	'ReferrersPurgeTime'		=> '引用來源保存時間：',
	'ReferrersPurgeTimeInfo'	=> '保留外部引用頁面的歷史不超過指定天數。輸入零表示永久保存，但對於高流量網站可能導致資料庫膨脹。',
	'EnableCounters'			=> '點閱計數器：',
	'EnableCountersInfo'		=> '允許每頁點閱計數並啟用簡易統計顯示。頁面擁有者的瀏覽不會被計入。',

	// 聚合（Syndication）設定
	'SyndicationSettingsInfo'		=> '控制網站的預設網路聚合（Syndication）設定。',
	'SyndicationSettingsUpdated'	=> '已更新聚合設定。',

	'FeedsSection'				=> '摘要（Feeds）',
	'EnableFeeds'				=> '啟用摘要：',
	'EnableFeedsInfo'			=> '為整個 wiki 開啟或關閉 RSS 摘要。',
	'XmlChangeLink'				=> '變更摘要連結模式：',
	'XmlChangeLinkInfo'			=> '定義 XML 變更摘要中的項目連結到哪裡。',
	'XmlChangeLinkMode'			=> [
		'1'		=> '差異檢視',
		'2'		=> '目前頁面',
		'3'		=> '版本清單',
		'4'		=> '已修訂的頁面',
	],

	'XmlSitemap'				=> 'XML Sitemap：',
	'XmlSitemapInfo'			=> '在 xml 資料夾中建立一個名為 %1 的 XML 檔案。您可以在網站根目錄的 robots.txt 中加入 sitemap 路徑，如下所示：',
	'XmlSitemapGz'				=> 'XML Sitemap 壓縮：',
	'XmlSitemapGzInfo'			=> '如需節省頻寬，可將 Sitemap 文字檔以 gzip 壓縮。',
	'XmlSitemapTime'			=> 'XML Sitemap 產生時間：',
	'XmlSitemapTimeInfo'		=> '在指定天數內只產生一次 Sitemap，輸入零表示每次頁面變更都重新產生。',

	'SearchSection'				=> '搜尋',
	'OpenSearch'				=> 'OpenSearch：',
	'OpenSearchInfo'			=> '在 XML 資料夾中建立 OpenSearch 描述檔，並在 HTML 標頭中啟用搜尋外掛的自動偵測。',
	'SearchEngineVisibility'	=> '阻擋搜尋引擎（Search Engine Visibility）：',
	'SearchEngineVisibilityInfo'=> '阻擋搜尋引擎，但允許一般訪客。會覆蓋頁面設定。<br>阻止搜尋引擎索引此網站，是否遵守取決於搜尋引擎本身。',



	// 外觀設定
	'AppearanceSettingsInfo'	=> '控制網站的預設顯示設定。',
	'AppearanceSettingsUpdated'	=> '已更新外觀設定。',

	'LogoOff'					=> '關閉',
	'LogoOnly'					=> '僅 logo',
	'LogoAndTitle'				=> 'logo 與標題',

	'LogoSection'				=> '標誌',
	'SiteLogo'					=> '網站標誌：',
	'SiteLogoInfo'				=> '您的標誌通常會顯示在應用程式的左上角。最大檔案為 2 MiB。建議尺寸為寬 255 像素，高 55 像素。',
	'LogoDimensions'			=> '標誌尺寸：',
	'LogoDimensionsInfo'		=> '顯示標誌的寬度與高度。',
	'LogoDisplayMode'			=> '標誌顯示模式：',
	'LogoDisplayModeInfo'		=> '定義標誌的顯示方式。預設為關閉。',

	'FaviconSection'			=> '網站圖示（Favicon）',
	'SiteFavicon'				=> '網站 Favicon：',
	'SiteFaviconInfo'			=> '您的捷徑圖示或 favicon 會顯示在大多數瀏覽器的網址列、分頁與書籤中。此設定會覆蓋佈景主題的 favicon。',
	'SiteFaviconTooBig'			=> 'Favicon 大小超過 64 × 64px。',
	'ThemeColor'				=> '網址列主題顏色：',
	'ThemeColorInfo'			=> '瀏覽器將根據所提供的 CSS 顏色設定每個頁面的網址列顏色。',

	'LayoutSection'				=> '版面配置',
	'Theme'						=> '主題：',
	'ThemeInfo'					=> '網站預設使用的範本設計。',
	'ResetUserTheme'			=> '重設所有使用者主題：',
	'ResetUserThemeInfo'		=> '重設所有使用者所選的主題。警告：此動作會將所有使用者選定的主題回復為全域預設主題。',
	'SetBackUserTheme'			=> '將所有使用者主題回復為 %1 主題。',
	'ThemesAllowed'				=> '允許的主題：',
	'ThemesAllowedInfo'			=> '選擇使用者可選擇的主題，否則會允許所有可用主題。',
	'ThemesPerPage'				=> '每頁主題數：',
	'ThemesPerPageInfo'			=> '允許每頁指定的主題，由頁面擁有者可透過頁面屬性選擇。',

	// 系統設定
	'SystemSettingsInfo'		=> '一組用於微調平台的參數。若不確定其作用，請勿更改。',
	'SystemSettingsUpdated'		=> '已更新系統設定',

	'DebugModeSection'			=> '除錯模式',
	'DebugMode'					=> '除錯模式：',
	'DebugModeInfo'				=> '在程式執行時記錄與輸出遙測資料。注意：詳細的除錯模式對記憶體需求較高，特別是在備份與還原資料庫等資源密集的操作。',
	'DebugModes'	=> [
		'0'		=> '關閉除錯',
		'1'		=> '僅記錄總執行時間',
		'2'		=> '記錄完整時間',
		'3'		=> '完整詳細（DBMS、快取等）',
	],
	'DebugSqlThreshold'			=> '資料庫查詢性能門檻：',
	'DebugSqlThresholdInfo'		=> '在詳細除錯模式下，僅記錄執行超過指定秒數的查詢。',
	'DebugAdminOnly'			=> '僅限管理員的除錯資訊：',
	'DebugAdminOnlyInfo'		=> '僅向管理員顯示程式（及 DBMS）的除錯資料。',

	'CachingSection'			=> '快取選項',
	'Cache'						=> '快取已渲染頁面：',
	'CacheInfo'					=> '將已渲染的頁面儲存在本機快取以加速後續載入。僅對未註冊訪客生效。',
	'CacheTtl'					=> '已快取頁面的有效期限：',
	'CacheTtlInfo'				=> '快取頁面不超過指定的秒數。',
	'CacheSql'					=> '快取資料庫查詢：',
	'CacheSqlInfo'				=> '維護某些資源 SQL 查詢結果的本機快取。',
	'CacheSqlTtl'				=> '資料庫快取有效期限：',
	'CacheSqlTtlInfo'			=> '將 SQL 查詢結果的快取保留不超過指定秒數。不建議使用超過 1200 的值。',

	'LogSection'				=> '日誌設定',
	'LogLevelUsage'				=> '使用日誌記錄：',
	'LogLevelUsageInfo'			=> '記錄到日誌中的事件最低優先級。',
	'LogThresholds'	=> [
		'0'		=> '不保留日誌',
		'1'		=> '僅重大級別',
		'2'		=> '從較高級別起',
		'3'		=> '從高級別起',
		'4'		=> '中等級',
		'5'		=> '從低級別起',
		'6'		=> '最低級別',
		'7'		=> '記錄全部',
	],
	'LogDefaultShow'			=> '日誌顯示模式：',
	'LogDefaultShowInfo'		=> '預設在日誌中顯示的最低事件優先級。',
	'LogModes'	=> [
		'1'		=> '僅重大級別',
		'2'		=> '從較高級別起',
		'3'		=> '從高級別起',
		'4'		=> '中等級',
		'5'		=> '從低級別起',
		'6'		=> '從最低級別起',
		'7'		=> '顯示全部',
	],
	'LogPurgeTime'				=> '日誌保存時間：',
	'LogPurgeTimeInfo'			=> '移除指定天數之前的事件日誌。',

	'PrivacySection'			=> '隱私政策',
	'AnonymizeIp'				=> '匿名化使用者 IP 位址：',
	'AnonymizeIpInfo'			=> '在適用時匿名化頁面、修訂或引用來源中的 IP 位址。',

	'ReverseProxySection'		=> '反向代理',
	'ReverseProxy'				=> '使用反向代理：',
	'ReverseProxyInfo'			=> '啟用此設定以透過檢查 X-Forwarded-For 標頭中的資訊來判斷遠端用戶端的正確 IP 位址。' .
	'X-Forwarded-For 標頭是識別透過反向代理伺服器（如 Squid 或 Pound）連線的用戶端系統的標準機制。' .
	'反向代理伺服器常用於提升高流量網站的效能，並可能提供快取、安全或加密等其他好處。' .
	'若此 WackoWiki 安裝位於反向代理後方，應啟用此設定以便在 WackoWiki 的會話管理、日誌、統計與存取管理系統中擷取正確的 IP 位址資訊；' .
	'若不確定此設定、未使用反向代理，或 WackoWiki 在共用主機環境下運作，則應保持此設定為停用。',
	'ReverseProxyHeader'		=> '反向代理標頭：',
	'ReverseProxyHeaderInfo'	=> '若您的代理伺服器以非 X-Forwarded-For 的標頭傳送用戶端 IP，請設定此值。' .
	'「X-Forwarded-For」標頭為以逗號加空格分隔的 IP 位址清單，僅會使用最後一個（最左側）。',
	'ReverseProxyAddresses'		=> 'reverse_proxy 接受一個 IP 位址陣列：',
	'ReverseProxyAddressesInfo'	=> '此陣列的每個元素為您任一反向代理的 IP 位址。當填入此陣列後，WackoWiki 僅在遠端 IP 位址為這些位址之一時才信任 X-Forwarded-For 標頭中的資訊，亦即請求是從您某一反向代理到達 Web 伺服器。否則，客戶端可能會直接連接至您的 Web 伺服器並偽造 X-Forwarded-For 標頭。',

	'SessionSection'				=> '會話處理',
	'SessionStorage'				=> '會話儲存：',
	'SessionStorageInfo'			=> '此選項定義會話資料的儲存位置。預設可選擇檔案或資料庫會話儲存。',
	'SessionModes'	=> [
		'1'		=> '檔案',
		'2'		=> '資料庫',
	],
	'SessionNotice'					=> '顯示會話終止原因：',
	'SessionNoticeInfo'				=> '指示會話終止的原因。',
	'LoginNotice'					=> '登入通知：',
	'LoginNoticeInfo'				=> '顯示登入通知。',

	'RewriteMode'					=> '使用 <code>mod_rewrite</code>：',
	'RewriteModeInfo'				=> '若您的網頁伺服器支援此功能，啟用以取得較美觀的頁面網址。<br>' .
	'<span class="cite">此值可能會在執行期間被 Settings 類別覆寫，不論此處是否關閉，只要 HTTP_MOD_REWRITE 為開啟。</span>',

	// 權限設定
	'PermissionsSettingsInfo'		=> '負責存取控制與權限的參數。',
	'PermissionsSettingsUpdated'	=> '已更新權限設定',

	'PermissionsSection'		=> '權限與特權',
	'ReadRights'				=> '預設閱讀權限：',
	'ReadRightsInfo'			=> '這些權限會被指派給新建立的根頁面，以及那些無法定義父頁面權限的頁面。',
	'WriteRights'				=> '預設寫入權限：',
	'WriteRightsInfo'			=> '這些權限會被指派給新建立的根頁面，以及那些無法定義父頁面權限的頁面。',
	'CommentRights'				=> '預設留言權限：',
	'CommentRightsInfo'			=> '這些權限會被指派給新建立的根頁面，以及那些無法定義父頁面權限的頁面。',
	'CreateRights'				=> '預設子頁建立權限：',
	'CreateRightsInfo'			=> '定義建立根頁面的權限，並指派給那些無法定義父頁面權限的頁面。',
	'UploadRights'				=> '預設上傳權限：',
	'UploadRightsInfo'			=> '這些權限會被指派給新建立的根頁面，以及那些無法定義父頁面權限的頁面。',
	'RenameRights'				=> '全域重新命名權限：',
	'RenameRightsInfo'			=> '允許自由重新命名（移動）頁面的權限清單。',

	'LockAcl'					=> '將所有 ACL 鎖定為唯讀：',
	'LockAclInfo'				=> '<span class="cite">覆寫所有頁面的 ACL 設定為唯讀。</span><br>當專案已完成、想在一段期間內關閉編輯以提高安全性，或作為緊急應變時，這個選項可能很有用。',
	'HideLocked'				=> '隱藏不可存取的頁面：',
	'HideLockedInfo'			=> '如果使用者沒有權限閱讀某頁，在各種頁面清單中隱藏該頁（但在文字中放置的連結仍然會顯示）。',
	'RemoveOnlyAdmins'			=> '只有管理員可以刪除頁面：',
	'RemoveOnlyAdminsInfo'		=> '禁止所有人（管理員除外）刪除頁面。此限制首先套用於一般頁面的擁有者。',
	'OwnersRemoveComments'		=> '頁面擁有者可刪除留言：',
	'OwnersRemoveCommentsInfo'	=> '允許頁面擁有者管理其頁面的留言。',
	'OwnersEditCategories'		=> '頁面擁有者可編輯分類：',
	'OwnersEditCategoriesInfo'	=> '允許擁有者修改指派給頁面的分類清單（新增或刪除關鍵字）。',
	'TermHumanModeration'		=> '人工審核期限：',
	'TermHumanModerationInfo'	=> '管理員僅能編輯在此天數內建立的留言（此限制不適用於主題中的最後一則留言）。',

	'UserCanDeleteAccount'		=> '允許使用者刪除自己的帳號',

	// Security settings
	'SecuritySettingsInfo'		=> '由此設定平台整體安全性、限制與額外的安全子系統參數。',
	'SecuritySettingsUpdated'	=> '已更新安全性設定',

	'AllowRegistration'			=> '允許線上註冊：',
	'AllowRegistrationInfo'		=> '開放使用者註冊。停用此選項將阻止自由註冊，但網站管理員仍可代為建立使用者帳號。',
	'ApproveNewUser'			=> '新使用者需審核：',
	'ApproveNewUserInfo'		=> '允許管理員在使用者註冊後進行核准。只有經核准的使用者才能登入網站。',
	'PersistentCookies'			=> '持久性 Cookie：',
	'PersistentCookiesInfo'		=> '允許使用持久性 cookie。',
	'DisableWikiName'			=> '停用 WikiName：',
	'DisableWikiNameInfo'		=> '停用強制使用 WikiName，允許以一般暱稱註冊使用者，而非強制使用姓名格式。',
	'UsernameLength'			=> '使用者名稱長度：',
	'UsernameLengthInfo'		=> '使用者名稱的最小與最大字元數。',

	'EmailSection'				=> '電子郵件',
	'AllowEmailReuse'			=> '允許重複使用電子郵件地址：',
	'AllowEmailReuseInfo'		=> '不同使用者可以使用相同的電子郵件地址註冊。',
	'EmailConfirmation'			=> '強制電子郵件確認：',
	'EmailConfirmationInfo'		=> '要求使用者在登入前驗證其電子郵件地址。',
	'AllowedEmailDomains'		=> '允許的電子郵件域：',
	'AllowedEmailDomainsInfo'	=> '允許的電子郵件域以逗號分隔，例如 <code>example.com, local.lan</code>，若未設定則接受所有電子郵件域。',
	'ForbiddenEmailDomains'		=> '禁止的電子郵件域：',
	'ForbiddenEmailDomainsInfo'	=> '禁止的電子郵件域以逗號分隔，例如 <code>example.com, local.lan</code>。 (僅在允許電子郵件域清單為空時生效)',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> '啟用驗證碼：',
	'EnableCaptchaInfo'			=> '啟用後，當達到安全門檻或符合下列情況時將顯示驗證碼。',
	'CaptchaComment'			=> '新增留言：',
	'CaptchaCommentInfo'		=> '為防止垃圾訊息，要求未註冊使用者在發表留言前完成一次驗證測試。',
	'CaptchaPage'				=> '新增頁面：',
	'CaptchaPageInfo'			=> '為防止垃圾訊息，要求未註冊使用者在建立新頁面前完成一次驗證測試。',
	'CaptchaEdit'				=> '編輯頁面：',
	'CaptchaEditInfo'			=> '為防止垃圾訊息，要求未註冊使用者在編輯頁面前完成一次驗證測試。',
	'CaptchaRegistration'		=> '建立帳號：',
	'CaptchaRegistrationInfo'	=> '為防止垃圾訊息，要求未註冊使用者在註冊前完成一次驗證測試。',

	'TlsSection'				=> 'TLS 設定',
	'TlsConnection'				=> 'TLS 連線：',
	'TlsConnectionInfo'			=> '使用 TLS 安全連線。<span class="cite">請在伺服器上啟用已安裝的 TLS 憑證，否則您將無法存取管理面板！</span><br>此設定也會決定是否設定 Cookie 的 secure 標記，<code>secure</code> 標記指定 Cookie 僅能透過安全連線傳送。',
	'TlsImplicit'				=> '強制 TLS：',
	'TlsImplicitInfo'			=> '強制將用戶端從 HTTP 重新導向到 HTTPS。若停用此選項，用戶端仍可透過未加密的 HTTP 通道瀏覽網站。',

	'HttpSecurityHeaders'		=> 'HTTP 安全標頭',
	'EnableSecurityHeaders'		=> '啟用安全標頭：',
	'EnableSecurityHeadersinfo'	=> '設定安全標頭（如框架防護、點擊劫持/XSS/CSRF 防護）。<br>CSP 在某些情況下可能造成問題（例如開發時），或當使用仰賴外部資源（如圖片或腳本）的外掛時。<br>停用內容安全策略（CSP）將增加安全風險！',
	'Csp'						=> 'Content-Security-Policy (CSP)：',
	'CspInfo'					=> '配置內容安全策略時，需要決定要強制執行哪些政策，然後設定並透過 Content-Security-Policy 來建立您的策略。',
	'PolicyModes'	=> [
		'0'		=> '已停用',
		'1'		=> '嚴格',
		'2'		=> '自訂',
	],
	'PermissionsPolicy'			=> 'Permissions Policy：',
	'PermissionsPolicyInfo'		=> 'HTTP Permissions-Policy 標頭提供一種機制，可明確啟用或停用多項強大的瀏覽器功能。',
	'ReferrerPolicy'			=> 'Referrer Policy：',
	'ReferrerPolicyInfo'		=> 'Referrer-Policy HTTP 標頭決定在發出請求時，應隨附多少 referer 資訊（於 Referer 標頭中傳送）。',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[關閉]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> '使用者密碼相關',
	'PwdMinChars'				=> '密碼最小長度：',
	'PwdMinCharsInfo'			=> '一般來說，較長的密碼比短密碼更安全（例如 12 至 16 個字元）。<br>建議使用短語（passphrases）代替一般密碼。',
	'AdminPwdMinChars'			=> '管理員密碼最小長度：',
	'AdminPwdMinCharsInfo'		=> '較長的密碼通常比短的更安全（例如 15 至 20 個字元）。<br>建議使用短語（passphrases）代替一般密碼。',
	'PwdCharComplexity'			=> '密碼所需複雜度：',
	'PwdCharClasses'	=> [
		'0'		=> '不檢查',
		'1'		=> '任意大小寫字母 + 數字',
		'2'		=> '大小寫字母 + 數字',
		'3'		=> '大小寫字母 + 數字 + 符號',
	],
	'PwdUnlikeLogin'			=> '額外限制：',
	'PwdUnlikes'	=> [
		'0'		=> '不檢查',
		'1'		=> '密碼不得與帳號相同',
		'2'		=> '密碼不得包含使用者名稱',
	],

	'LoginSection'				=> '登入',
	'MaxLoginAttempts'			=> '每個帳號允許的最大登入嘗試次數：',
	'MaxLoginAttemptsInfo'		=> '在觸發防垃圾機制前，單一帳號可嘗試登入的次數。輸入 0 可讓不同帳號不會觸發此反垃圾機制。',
	'IpLoginLimitMax'			=> '每個 IP 允許的最大登入嘗試次數：',
	'IpLoginLimitMaxInfo'		=> '在觸發反垃圾機制前，來自單一 IP 的登入嘗試門檻。輸入 0 可讓 IP 不會觸發此反垃圾機制。',

	'FormsSection'				=> '表單',
	'FormTokenTime'				=> '提交表單的最長時間：',
	'FormTokenTimeInfo'			=> '使用者提交表單的時限（以秒為單位）。<br>請注意，如果會話過期，表單可能會失效，與此設定無關。',

	'SessionLength'				=> '登入 Cookie 有效期：',
	'SessionLengthInfo'			=> '使用者登入 Cookie 的預設有效天數（以天為單位）。',
	'CommentDelay'				=> '留言防灌水間隔：',
	'CommentDelayInfo'			=> '使用者發佈新留言之間的最短間隔（以秒為單位）。',
	'IntercomDelay'				=> '私人訊息防灌水間隔：',
	'IntercomDelayInfo'			=> '發送私人訊息之間的最短間隔（以秒為單位）。',
	'RegistrationDelay'			=> '註冊填表的時間門檻：',
	'RegistrationDelayInfo'		=> '填寫註冊表單的最短時間，用以區分機器人與真人（以秒為單位）。',

	// Formatter settings
	'FormatterSettingsInfo'		=> '一組用於微調平台的參數。除非您確定需求，否則請勿變更。',
	'FormatterSettingsUpdated'	=> '已更新格式化設定',

	'TextHandlerSection'		=> '文字處理器',
	'Typografica'				=> '排版校正：',
	'TypograficaInfo'			=> '停用此項可略微加快新增留言與儲存頁面的處理速度。',
	'Paragrafica'				=> '段落標記：',
	'ParagraficaInfo'			=> '與前一選項類似，但會導致自動目錄（<code>{{toc}}</code>）失效。',
	'AllowRawhtml'				=> '全域 HTML 支援：',
	'AllowRawhtmlInfo'			=> '此選項在開放站台上可能不安全。',
	'SafeHtml'					=> 'HTML 過濾：',
	'SafeHtmlInfo'				=> '防止儲存危險的 HTML 元素。在開放站台上同時允許 HTML 支援卻停用過濾是<span class="underline">極度</span>不建議的！',

	'WackoFormatterSection'		=> 'Wiki 文本格式化器（Wacko Formatter）',
	'X11colors'					=> '允許使用 X11 色彩：',
	'X11colorsInfo'				=> '擴充 <code>??(color) background??</code> 和 <code>!!(color) text!!</code> 可用的顏色列表。停用此項可略微加快新增留言與儲存頁面的速度。',
	'WikiLinks'					=> '停用 Wiki 連結：',
	'WikiLinksInfo'				=> '停用對 <code>CamelCaseWords</code> 的連結，您的 CamelCase 單字將不會自動連到新頁面。當跨不同命名空間或叢集工作時，此選項很有用。預設為關閉（啟用連結）。',
	'BracketsLinks'				=> '停用方括號連結：',
	'BracketsLinksInfo'			=> '停用 <code>[[link]]</code> 與 <code>((link))</code> 語法。',
	'Formatters'				=> '停用格式器：',
	'FormattersInfo'			=> '停用用於語法標示的 <code>%%code%%</code> 語法。',

	'DateFormatsSection'		=> '日期格式',
	'DateFormat'				=> '日期格式：',
	'DateFormatInfo'			=> '（日、月、年）',
	'TimeFormat'				=> '時間格式：',
	'TimeFormatInfo'			=> '（時、分）',
	'TimeFormatSeconds'			=> '具秒數的時間格式：',
	'TimeFormatSecondsInfo'		=> '（時、分、秒）',
	'NameDateMacro'				=> '<code>::@::</code> 宏的格式：',
	'NameDateMacroInfo'			=> '（名稱、時間），例如 <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> '時區：',
	'TimezoneInfo'				=> '用於顯示給未登入使用者（訪客）的時間的時區。已登入使用者可在個人設定中設定並變更自己的時區。',
	'AmericanDate'					=> '美式日期：',
	'AmericanDateInfo'				=> '將美國日期格式設為英文的預設格式。',

	'Canonical'					=> '使用完整標準化 URL：',
	'CanonicalInfo'				=> '所有連結會以絕對 URL 形式建立，格式為 %1。相對於伺服器根目錄的 URL（格式為 %2）通常較為建議。',
	'LinkTarget'				=> '外部連結開啟位置：',
	'LinkTargetInfo'			=> '在新視窗開啟每個外部連結。於連結語法中加入 <code>target="_blank"</code>。',
	'Noreferrer'				=> 'noreferrer：',
	'NoreferrerInfo'			=> '要求瀏覽器在使用者點擊連結時不發送 HTTP referer 標頭。於連結語法中加入 <code>rel="noreferrer"</code>。',
	'Nofollow'					=> 'nofollow：',
	'NofollowInfo'				=> '告知搜尋引擎該超連結不應影響目標頁面的搜尋排名。於連結語法中加入 <code>rel="nofollow"</code>。',
	'UrlsUnderscores'			=> '網址使用底線：',
	'UrlsUnderscoresInfo'		=> '例如啟用此選項後，%1 會變成 %2。',
	'ShowSpaces'				=> '在 WikiName 顯示空格：',
	'ShowSpacesInfo'			=> '啟用此選項可在 WikiName 中顯示空格，例如將 <code>MyName</code> 顯示為 <code>My Name</code>。',
	'NumerateLinks'				=> '列印視圖中編號連結：',
	'NumerateLinksInfo'			=> '啟用後會在列印視圖底部將所有連結編號並列出。',
	'YouareHereText'			=> '停用並視覺化自我參照連結：',
	'YouareHereTextInfo'		=> '將連到同一頁面的連結視覺化，例如使用 <code>&lt;b&gt;####&lt;/b&gt;</code>，所有自指連結將不再是連結，而是粗體文字。',

	// Pages settings
	'PagesSettingsInfo'			=> '在此可設定或變更 Wiki 內使用的系統基礎頁面。請務必依照這裡的設定建立或更新對應的 Wiki 頁面。',
	'PagesSettingsUpdated'		=> '已更新基礎頁面設定',

	'ListCount'					=> '每頁清單項目數：',
	'ListCountInfo'				=> '顯示於各清單頁面的項目數，針對訪客或作為新使用者的預設值。',

	'ForumSection'				=> '討論區選項',
	'ForumCluster'				=> '討論區群集：',
	'ForumClusterInfo'			=> '討論區區段的根群集（操作 %1）。',
	'ForumTopics'				=> '每頁主題數：',
	'ForumTopicsInfo'			=> '討論區列表中，每頁顯示的主題數（操作 %1）。',
	'CommentsCount'				=> '每頁留言數：',
	'CommentsCountInfo'			=> '每個留言清單頁面顯示的留言數。此設定適用於站內所有留言，而不僅限於討論區。',

	'NewsSection'				=> '新聞區段',
	'NewsCluster'				=> '新聞群集：',
	'NewsClusterInfo'			=> '新聞區段的根群集（操作 %1）。',
	'NewsStructure'				=> '新聞群集結構：',
	'NewsStructureInfo'			=> '可選擇以年/月或週的子群集來儲存文章（例如 <code>[cluster]/[year]/[month]</code>）。',

	'LicenseSection'			=> '許可證',
	'DefaultLicense'			=> '預設許可證：',
	'DefaultLicenseInfo'		=> '您的內容應以何種許可證發布。',
	'EnableLicense'				=> '啟用許可資訊：',
	'EnableLicenseInfo'			=> '啟用以顯示許可證資訊。',
	'LicensePerPage'			=> '每頁許可權：',
	'LicensePerPageInfo'		=> '允許每頁設定不同的許可證，頁面擁有者可透過頁面屬性選擇。',

	'ServicePagesSection'		=> '服務頁面',
	'RootPage'					=> '首頁：',
	'RootPageInfo'				=> '主要頁面的標籤，使用者訪問網站時會自動打開。',

	'PrivacyPage'				=> '隱私政策：',
	'PrivacyPageInfo'			=> '網站隱私政策所在的頁面。',

	'TermsPage'					=> '政策與規範：',
	'TermsPageInfo'				=> '網站規則與條款所在的頁面。',

	'SearchPage'				=> '搜尋：',
	'SearchPageInfo'			=> '帶有搜尋表單的頁面（操作 %1）。',
	'RegistrationPage'			=> '建立帳號：',
	'RegistrationPageInfo'		=> '新使用者註冊頁面（操作 %1）。',
	'LoginPage'					=> '使用者登入：',
	'LoginPageInfo'				=> '網站的登入頁面（操作 %1）。',
	'SettingsPage'				=> '使用者設定：',
	'SettingsPageInfo'			=> '用於自訂使用者個人資料的頁面（操作 %1）。',
	'PasswordPage'				=> '更改密碼：',
	'PasswordPageInfo'			=> '包含變更或重設使用者密碼表單的頁面（操作 %1）。',
	'UsersPage'					=> '使用者清單：',
	'UsersPageInfo'				=> '包含已註冊使用者清單的頁面（操作 %1）。',
	'CategoryPage'				=> '分類：',
	'CategoryPageInfo'			=> '包含分類頁面清單的頁面（操作 %1）。',
	'GroupsPage'				=> '群組：',
	'GroupsPageInfo'			=> '包含工作群組清單的頁面（操作 %1）。',
	'WhatsNewPage'				=> '最新動態：',
	'WhatsNewPageInfo'			=> '包含所有新增、刪除或變更的頁面，以及新增附件與留言的清單頁面。（操作 %1）',
	'ChangesPage'				=> '近期變動：',
	'ChangesPageInfo'			=> '包含最近被修改頁面的清單頁面（操作 %1）。',
	'CommentsPage'				=> '最近的留言：',
	'CommentsPageInfo'			=> '包含近期留言清單的頁面（操作 %1）。',
	'RemovalsPage'				=> '已刪除的頁面：',
	'RemovalsPageInfo'			=> '包含最近被刪除頁面的清單頁面（操作 %1）。',
	'WantedPage'				=> '缺頁清單：',
	'WantedPageInfo'			=> '包含被引用但不存在的缺頁清單（操作 %1）。',
	'OrphanedPage'				=> '孤立頁面：',
	'OrphanedPageInfo'			=> '包含與其他頁面無相互連結的既有頁面清單（操作 %1）。',
	'SandboxPage'				=> '沙盒：',
	'SandboxPageInfo'			=> '供使用者練習 wiki 標記語法的頁面。',
	'HelpPage'					=> '說明：',
	'HelpPageInfo'				=> '網站工具與操作說明文件的頁面。',
	'IndexPage'					=> '索引：',
	'IndexPageInfo'				=> '包含所有頁面清單的頁面（操作 %1）。',
	'RandomPage'				=> '隨機頁面：',
	'RandomPageInfo'			=> '載入一個隨機頁面（操作 %1）。',

	// 通知設定
	'NotificationSettingsInfo' => '平台通知的參數。',
	'NotificationSettingsUpdated' => '已更新通知設定',

	'EmailNotification' => '電子郵件通知：',
	'EmailNotificationInfo' => '允許電子郵件通知。設為 ON 啟用電子郵件通知，設為 OFF 則停用。請注意，停用電子郵件通知不會影響在使用者註冊流程中所產生的郵件。',
	'Autosubscribe' => '自動訂閱：',
	'AutosubscribeInfo' => '當頁面建立時，自動在擁有者的變更通知中訂閱該頁面。',

	'NotificationSection' => '使用者預設通知設定',
	'NotifyPageEdit' => '通知頁面編輯：',
	'NotifyPageEditInfo' => '待定 — 只會在首次變更時發送電子郵件通知，直到使用者再次訪問該頁面。',
	'NotifyMinorEdit' => '通知次要編輯：',
	'NotifyMinorEditInfo' => '也會針對次要編輯發送通知。',
	'NotifyNewComment' => '通知新留言：',
	'NotifyNewCommentInfo' => '待定 — 只會在首次留言時發送電子郵件通知，直到使用者再次訪問該頁面。',

	'NotifyUserAccount' => '通知新使用者帳號：',
	'NotifyUserAccountInfo' => '當有人使用註冊表單建立新使用者時，管理員會收到通知。',
	'NotifyUpload' => '通知檔案上傳：',
	'NotifyUploadInfo' => '當有人上傳檔案時，版主會收到通知。',

	'PersonalMessagesSection' => '個人訊息',
	'AllowIntercomDefault' => '允許內部訊息：',
	'AllowIntercomDefaultInfo' => '啟用此選項允許其他使用者向收件人電子郵件地址傳送個人訊息，而不會揭露該地址。',
	'AllowMassemailDefault' => '允許群發郵件：',
	'AllowMassemailDefaultInfo' => '僅向那些允許管理員發送電子郵件給他們的使用者發送訊息。',

	// 重新同步設定
	'Synchronize' => '同步',
	'UserStatsSynched' => '使用者統計已同步。',
	'PageStatsSynched' => '頁面統計已同步。',
	'FeedsUpdated' => 'RSS 訂閱已更新。',
	'SiteMapCreated' => '網站地圖已建立新版本。',
	'ParseNextBatch' => '解析下一批頁面：',
	'WikiLinksRestored' => 'Wiki 鏈接已還原。',

	'LogUserStatsSynched' => '已同步使用者統計',
	'LogPageStatsSynched' => '已同步頁面統計',
	'LogFeedsUpdated' => '已同步 RSS 訂閱',
	'LogPageBodySynched' => '已重新解析頁面內容與鏈接',

	'UserStats' => '使用者統計',
	'UserStatsInfo' => '使用者統計（留言數、擁有的頁面、修訂次數與檔案數）在某些情況下可能與實際資料不同。<br>此操作可將統計更新為資料庫的當前實際資料。',
	'PageStats' => '頁面統計',
	'PageStatsInfo' => '頁面統計（留言數、檔案與修訂次數）在某些情況下可能與實際資料不同。<br>此操作可將統計更新為資料庫的當前實際資料。',

	'AttachmentsInfo' => '更新資料庫中所有附件的檔案雜湊值（hash）。',
	'AttachmentsSynched' => '已對所有檔案附件重新計算雜湊值',
	'LogAttachmentsSynched' => '已對所有檔案附件重新計算雜湊值',

	'Feeds' => '訂閱',
	'FeedsInfo' => '如果直接在資料庫中編輯頁面，RSS 訂閱的內容可能不會反映這些變更。<br>此功能可將 RSS 頻道與資料庫的當前狀態同步。',
	'XmlSiteMap' => 'XML 網站地圖',
	'XmlSiteMapInfo' => '此功能可將 XML 網站地圖與資料庫的當前狀態同步。',
	'XmlSiteMapPeriod' => '週期 %1 天。最後生成於 %2。',
	'XmlSiteMapView' => '在新視窗中顯示網站地圖。',

	'ReparseBody' => '重新解析所有頁面',
	'ReparseBodyInfo' => '清空頁面表中 <code>body_r</code> 欄位，以便每個頁面在下一次檢視時重新渲染。如果您修改了格式化器或變更了 Wiki 的網域，這可能會很有用。',
	'PreparsedBodyPurged' => '已清空頁面表中 <code>body_r</code> 欄位。',

	'WikiLinksResync' => 'Wiki 鏈接',
	'WikiLinksResyncInfo' => '對所有站內鏈接執行重新渲染，並在發生損壞或移動時恢復 <code>page_link</code> 與 <code>file_link</code> 表的內容（此操作可能需要相當長的時間）。',
	'RecompilePage' => '重新編譯所有頁面（耗費極大資源）',
	'ResyncOptions' => '附加選項',
	'RecompilePageLimit' => '一次解析的頁面數量限制。',

	// 電子郵件設定
	'EmaiSettingsInfo' => '當引擎向您的使用者發送電子郵件時會使用這些資訊。請確保您指定的電子郵件地址有效，退信或無法送達的郵件通常會寄回該地址。如果您的主機未提供原生（基於 PHP）的郵件服務，您可以改為使用 SMTP 直接發送郵件。這需要提供適當伺服器的位址（如有需要請向您的提供者詢問）。若伺服器需要驗證（僅在需要時），請輸入必要的使用者名稱、密碼與驗證方法。',

	'EmailSettingsUpdated' => '已更新電子郵件設定',

	'EmailFunctionName' => '郵件函式名稱：',
	'EmailFunctionNameInfo' => '用於透過 PHP 發送郵件的電子郵件函式。',
	'UseSmtpInfo' => '如果您想或必須透過指定的伺服器（而非本機 mail 函式）發送電子郵件，請選擇 <code>SMTP</code>。',

	'EnableEmail' => '啟用電子郵件：',
	'EnableEmailInfo' => '啟用電子郵件功能',

	'EmailIdentitySettings' => '網站電子郵件身分',
	'FromEmailName' => '寄件者名稱：',
	'FromEmailNameInfo' => '寄件者名稱，會出現在從本站發出的所有郵件通知的 <code>From:</code> 標頭中。',
	'EmailSubjectPrefix' => '主題前綴：',
	'EmailSubjectPrefixInfo' => '備用的電子郵件主題前綴，例如 <code>[前綴] 主題</code>。若未定義，預設前綴為網站名稱：%1。',

	'NoReplyEmail' => '免回覆地址：',
	'NoReplyEmailInfo' => '此地址（例如 <code>noreply@example.com</code>）會出現在所有從網站發出的郵件通知的 <code>From:</code> 欄位中。',
	'AdminEmail' => '站長電子郵件：',
	'AdminEmailInfo' => '此地址用於管理用途，例如新使用者通知。',
	'AbuseEmail' => '濫用通報郵件：',
	'AbuseEmailInfo' => '處理緊急事項（如註冊使用外來電子郵件等）的申請地址。可與前者相同。',

	'SendTestEmail' => '傳送測試電子郵件',
	'SendTestEmailInfo' => '這會向您帳戶中定義的地址發送一封測試郵件。',
	'TestEmailSubject' => '您的 Wiki 已正確設定為發送電子郵件',
	'TestEmailBody' => '如果您收到這封郵件，表示您的 Wiki 已正確設定為發送電子郵件。',
	'TestEmailMessage' => '測試郵件已發送。<br>如果您未收到，請檢查您的電子郵件設定。',

	'SmtpSettings' => 'SMTP 設定',
	'SmtpAutoTls' => '機會式 TLS：',
	'SmtpAutoTlsInfo' => '若伺服器在連線後宣告支援 TLS 加密，則會自動啟用加密（即使您未為 <code>SMTPSecure</code> 設定連線模式）。',
	'SmtpConnectionMode' => 'SMTP 連線模式：',
	'SmtpConnectionModeInfo' => '僅在設定了使用者名稱/密碼時使用；若不確定要使用何種方法，請向您的提供者詢問。',
	'SmtpPassword' => 'SMTP 密碼：',
	'SmtpPasswordInfo' => '只有在 SMTP 伺服器需要時才輸入密碼。<br><em><strong>警告：</strong>此密碼會以純文字形式儲存在資料庫中，對所有能存取資料庫或查看此設定頁面的人可見。</em>',
	'SmtpPort' => 'SMTP 伺服器埠號：',
	'SmtpPortInfo' => '僅在您確定 SMTP 伺服器使用不同埠時才更改此值。<br>（預設：<code>tls</code> 使用埠 587（或可能為 25），<code>ssl</code> 使用埠 465）',
	'SmtpServer' => 'SMTP 伺服器位址：',
	'SmtpServerInfo' => '請注意，您必須提供伺服器使用的協定。若使用 SSL，應為 <code>ssl://mail.example.com</code> 之類的格式。',
	'SmtpUsername' => 'SMTP 使用者名稱：',
	'SmtpUsernameInfo' => '只有在 SMTP 伺服器需要時才輸入使用者名稱。',

	// 上傳設定
	'UploadSettingsInfo' => '在此您可設定附件與相關特殊分類的主要設定。',
	'UploadSettingsUpdated' => '已更新上傳設定',

	'FileUploadsSection' => '檔案上傳',
	'RegisteredUsers' => '註冊用戶',
	'RightToUpload' => '上傳檔案權限：',
	'RightToUploadInfo' => '<code>admins</code> 表示只有屬於 admins 群組的使用者可以上傳檔案。<code>1</code> 表示已開放給註冊使用者上傳。<code>0</code> 表示停用上傳功能。',
	'UploadMaxFilesize' => '單一檔案最大限制：',
	'UploadMaxFilesizeInfo' => '單一檔案的最大大小。如果此值為 0，則可上傳的檔案大小僅受您的 PHP 配置限制。',
	'UploadQuota' => '附件總額度：',
	'UploadQuotaInfo' => '整個 Wiki 可用於附件的最大磁碟空間，<code>0</code> 表示不限制。已使用 %1。',
	'UploadQuotaUser' => '每位使用者的儲存額度：',
	'UploadQuotaUserInfo' => '限制單一使用者可上傳佔用的儲存空間，<code>0</code> 表示不限制。',

	'FileTypes' => '檔案類型',
	'UploadOnlyImages' => '僅允許上傳圖片：',
	'UploadOnlyImagesInfo' => '僅允許在頁面上上傳圖像檔案。',
	'AllowedUploadExts' => '允許的檔案類型：',
	'AllowedUploadExtsInfo' => '允許上傳的檔案副檔名，逗號分隔，例如 <code>png, ogg, mp4</code>。除此之外，所有未被禁止的副檔名皆允許。<br>您應將允許的上傳檔案類型限制為網站功能所需的最低範圍。',
	'CheckMimetype' => '檢查 MIME 類型：',
	'CheckMimetypeInfo' => '某些瀏覽器可能會被騙而判定錯誤的 MIME 類型。此選項可確保可能導致問題的檔案被拒絕。',
	'SvgSanitizer' => 'SVG 清理器：',
	'SvgSanitizerInfo' => '對上傳的 SVG 檔案進行清理，以防止上傳易受攻擊的 SVG/XML 檔案。',
	'TranslitFileName' => '音譯檔名：',
	'TranslitFileNameInfo' => '若適用且不需要 Unicode 字元，強烈建議只接受英數字元。',
	'TranslitCaseFolding' => '將檔名轉為小寫：',
	'TranslitCaseFoldingInfo' => '此選項僅對啟用音譯時有效。',

	'Thumbnails' => '縮圖',
	'CreateThumbnail' => '建立縮圖：',
	'CreateThumbnailInfo' => '在所有可能情況下建立縮圖。',
	'JpegQuality' => 'JPEG 品質：',
	'JpegQualityInfo' => '縮放 JPEG 縮圖時的品質，應介於 1 到 100 之間，100 表示 100% 品質。',
	'MaxImageArea' => '最大影像像素面積：',
	'MaxImageAreaInfo' => '原始影像可擁有的最大像素數。這為影像縮放器在解壓縮端提供記憶體使用限制。<br><code>-1</code> 表示在嘗試縮放之前不檢查影像大小。<code>0</code> 表示將自動決定該值。',
	'MaxThumbWidth' => '縮圖最大寬度（像素）：',
	'MaxThumbWidthInfo' => '產生的縮圖寬度不會超過此處設定的值。',
	'MinThumbFilesize' => '生成縮圖的最小檔案大小：',
	'MinThumbFilesizeInfo' => '不要為小於此值的影像建立縮圖。',
	'MaxImageWidth' => '頁面上影像寬度限制：',
	'MaxImageWidthInfo' => '影像在頁面上可具有的最大寬度，超過則生成等比例縮小的縮圖。',

	// 已刪除模組
	'DeletedObjectsInfo' => '列出已移除的頁面、修訂與檔案。最後可在對應列點選 <em>Remove</em> 或 <em>Restore</em> 從資料庫中永久移除或還原頁面、修訂或檔案。（注意：不會要求刪除確認！）',

	// 過濾模組
	'FilterSettingsInfo' => '會在您的 Wiki 上自動過濾的辭彙。',
	'FilterSettingsUpdated' => '已更新垃圾訊息過濾設定',

	'WordCensoringSection' => '詞語過濾',
	'SPAMFilter' => '垃圾郵件過濾：',
	'SPAMFilterInfo' => '啟用垃圾郵件過濾',
	'WordList' => '詞語清單：',
	'WordListInfo' => '要列入黑名單的詞語或片語片段（每行一條），使用 <code>fragment</code> 表示片段。',

	// 日誌模組
	'LogFilterTip' => '依條件篩選事件：',
	'LogLevel' => '等級',
	'LogLevelFilters' => [
		'1' => '不低於',
		'2' => '不高於',
		'3' => '等於',
	],
	'LogNoMatch' => '沒有符合條件的事件',
	'LogDate' => '日期',
	'LogEvent' => '事件',
	'LogUsername' => '使用者名稱',
	'LogLevels' => [
		'1' => '嚴重',
		'2' => '最高',
		'3' => '高',
		'4' => '中等',
		'5' => '低',
		'6' => '最低',
		'7' => '偵錯',
	],

	// 群發郵件模組
	'MassemailInfo' => '在此您可以向所有使用者或某特定群組中允許接收群發郵件的使用者發送電子郵件。系統會向管理用電子郵件地址發送一封郵件，並以密件副本（BCC）抄送給所有收件者。預設設定為每封郵件只包含 20 位收件者；若收件者更多會分多封郵件發送。若您要發送大量郵件，提交後請耐心等候，並勿中途停止頁面處理。群發郵件通常會花較長時間，腳本完成後會通知您。',
	'LogMassemail' => '群發郵件已發送 %1 給 群組 / 使用者 ',
	'MassemailSend' => '發送群發郵件',

	'NoEmailMessage' => '您必須輸入訊息內容。',
	'NoEmailSubject' => '您必須為訊息指定主旨。',
	'NoEmailRecipient' => '您必須指定至少一位使用者或使用者群組。',

	'MassemailSection' => '群發郵件',
	'MessageSubject' => '標題：',
	'MessageSubjectInfo' => '',
	'YourMessage' => '您的訊息：',
	'YourMessageInfo' => '請注意僅能輸入純文字。所有標記在發送前都會被移除。',

	'NoUser' => '無此使用者',
	'NoUserGroup' => '無此使用者群組',

	'SendToGroup' => '寄送至群組：',
	'SendToUser' => '寄送至使用者：',
	'SendToUserInfo' => '僅向那些允許管理員發送資訊郵件的使用者發送訊息。此選項可在其使用者設定的通知項目中找到。',

	// 系統訊息模組
	'SystemMessageInfo' => '',
	'SysMsgUpdated' => '已更新系統訊息',

	'SysMsgSection' => '系統訊息',
	'SysMsg' => '系統訊息：',
	'SysMsgInfo' => '在此輸入您的文字',

	'SysMsgType' => '類型：',
	'SysMsgTypeInfo' => '訊息類型（CSS）。',
	'SysMsgAudience' => '受眾：',
	'SysMsgAudienceInfo' => '系統訊息顯示的目標受眾。',
	'EnableSysMsg' => '啟用系統訊息：',
	'EnableSysMsgInfo' => '顯示系統訊息。',

	// 使用者審核模組
	'ApproveNotExists' => '請透過「設定」按鈕至少選擇一位使用者。',

	'LogUserApproved' => '使用者 ##%1## 已核准',
	'LogUserBlocked' => '使用者 ##%1## 已封鎖',
	'LogUserDeleted' => '使用者 ##%1## 已從資料庫移除',
	'LogUserCreated' => '已建立新使用者 ##%1##',
	'LogUserUpdated' => '已更新使用者 ##%1##',
	'LogUserPasswordReset' => '已成功重設使用者 ##%1## 的密碼',

	'UserApproveInfo' => '在新使用者能登入網站之前請先核准他們。',
	'Approve' => '核准',
	'Deny' => '拒絕',
	'Pending' => '待定',
	'Approved' => '已核准',
	'Denied' => '已拒絕',

	// DB 備份模組
	'BackupStructure'			=> '結構',
	'BackupData'				=> '資料',
	'BackupFolder'				=> '資料夾',
	'BackupTable'				=> '資料表',
	'BackupCluster'				=> '叢集：',
	'BackupFiles'				=> '檔案',
	'BackupNote'				=> '注意：',
	'BackupSettings'			=> '指定所需的備份方案。<br>' .
	'根叢集不會影響全域檔案備份和快取檔案備份（若被選中，這些檔案將始終完整保存）。<br>' .  '<br>' .
	'<strong>注意</strong>：為避免在指定根叢集時造成資料庫資訊遺失，本次備份中的這些資料表將不會被重建， ',
	'BackupCompleted'			=> '備份與壓縮完成。<br>' .
	'備份包檔案儲存在子目錄 %1 中。 <br>要下載它，請使用 FTP（複製時請保持目錄結構和檔案名稱不變）。 <br>要還原備份或刪除軟體包，請前往<a href="%2">還原資料庫</a>。',
	'LogSavedBackup'			=> '已儲存資料庫備份 ##%1##',
	'Backup'					=> '備份',
	'CantReadFile'				=> '無法讀取檔案 %1。',

	// DB 還原模組
	'RestoreInfo'				=> '您可以還原找到的任何備份包，或從伺服器中將其刪除。',
	'ConfirmDbRestore'			=> '您確定要還原備份 %1 嗎？',
	'ConfirmDbRestoreInfo'		=> '請稍候，這可能需要數分鐘。',
	'RestoreWrongVersion'		=> 'WackoWiki 版本不正確！',
	'DirectoryNotExecutable'	=> '目錄 %1 無法執行。',
	'BackupDelete'				=> '您確定要移除備份 %1 嗎？',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> '其他還原選項：',
	'RestoreOptionsInfo'		=> '* 在還原<strong>叢集備份</strong>之前，目標資料表不會被刪除（以避免未被備份之叢集造成的資料遺失）。' .
	'因此，還原過程中可能會出現重複記錄。' .
	'在一般模式下，所有重複項將被備份中的記錄取代（使用 SQL 指令 <code>REPLACE</code>），' .
	'但若勾選此選項，所有重複項將被跳過（保留當前記錄值），' .
	'只有新的鍵值記錄會被新增到資料表（SQL 指令 <code>INSERT IGNORE</code>）。<br>' .
	'<strong>注意</strong>：當還原整站的完整備份時，此選項無效。<br>' .
	'<br>' .
	'** 如果備份包含使用者檔案（全域與頁面專屬、快取檔案等），' .
	'在一般模式下還原時會取代現有相同名稱的檔案並放回相同目錄。' .
	'此選項允許您保留當前的檔案副本，僅從備份還原伺服器上不存在的新檔案。',
	'IgnoreDuplicatedKeysNr'	=> '忽略重複的資料表鍵（不取代）',
	'IgnoreSameFiles'			=> '忽略相同檔案（不覆蓋）',
	'NoBackupsAvailable'		=> '沒有可用的備份。',
	'BackupEntireSite'			=> '整個網站',
	'BackupRestored'			=> '備份已還原，以下附上摘要報告。要刪除此備份包，請點選',
	'BackupRemoved'				=> '選定的備份已成功移除。',
	'LogRemovedBackup'			=> '已移除資料庫備份 ##%1##',

	'DbEngineInvalid'			=> '資料庫引擎無效，應為 %1',
	'RestoreStarted'			=> '開始還原',
	'RestoreParameters'			=> '使用參數',
	'IgnoreDuplicatedKeys'		=> '忽略重複鍵',
	'IgnoreDuplicatedFiles'		=> '忽略重複檔案',
	'SavedCluster'				=> '已儲存叢集',
	'DataProtection'			=> '資料保護 - 已省略 %1',
	'AssumeDropTable'			=> '假設 %1',
	'RestoreSQLiteDatabase'		=> '還原 SQLite 資料庫',
	'SQLiteDatabaseRestored'	=> '資料庫已成功從以下位置還原：',
	'RestoreTableStructure'		=> '還原資料表結構',
	'RunSqlQueries'				=> '執行 SQL 指令：',
	'CompletedSqlQueries'		=> '完成。處理指令：',
	'NoTableStructure'			=> '未保存資料表結構 - 跳過',
	'RestoreRecords'			=> '還原資料表內容',
	'ProcessTablesDump'			=> '僅下載並處理資料表轉儲',
	'Instruction'				=> '指令',
	'RestoredRecords'			=> '記錄：',
	'RecordsRestoreDone'		=> '完成。總條目數：',
	'SkippedRecords'			=> '資料未保存 - 跳過',
	'RestoringFiles'			=> '還原檔案中',
	'DecompressAndStore'		=> '解壓並儲存目錄內容',
	'HomonymicFiles'			=> '同名檔案',
	'RestoreSkip'				=> '跳過',
	'RestoreReplace'			=> '取代',
	'RestoreFile'				=> '檔案：',
	'RestoredFiles'				=> '已還原：',
	'SkippedFiles'				=> '已跳過：',
	'FileRestoreDone'			=> '完成。總檔案數：',
	'FilesAll'					=> '全部：',
	'SkipFiles'					=> '檔案未儲存 - 跳過',
	'RestoreDone'				=> '還原完成',

	'BackupCreationDate'		=> '建立日期',
	'BackupPackageContents'		=> '備份包內容',
	'BackupRestore'				=> '還原',
	'BackupRemove'				=> '移除',
	'RestoreYes'				=> '是',
	'RestoreNo'					=> '否',
	'LogDbRestored'				=> '已還原資料庫備份 ##%1##。',

	'BackupArchived'			=> '備份 %1 已存檔。',
	'BackupArchiveExists'		=> '備份存檔 %1 已存在。',
	'LogBackupArchived'			=> '備份 ##%1## 已存檔。',

	// 使用者模組
	'UsersInfo'					=> '在此您可以變更使用者資訊及某些特定選項。',

	'UsersAdded'				=> '已新增使用者',
	'UsersDeleteInfo'			=> '[在此顯示使用者刪除資訊..]',
	'EditButton'				=> '編輯',
	'UsersAddNew'				=> '新增使用者',
	'UsersDelete'				=> '您確定要移除使用者 %1 嗎？',
	'UsersDeleted'				=> '使用者 %1 已從資料庫中刪除。',
	'UsersRename'				=> '將使用者 %1 重新命名為',
	'UsersRenameInfo'			=> '* 注意：變更將影響指派給該使用者的所有頁面。',
	'UsersUpdated'				=> '使用者更新成功。',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> '註冊時間',
	'UserActions'				=> '操作',
	'NoMatchingUser'			=> '沒有符合條件的使用者',

	'UserAccountNotify'			=> '通知使用者',
	'UserNotifySignup'			=> '通知使用者新帳號已建立',
	'UserVerifyEmail'			=> '設定電子郵件確認憑證並加入電子郵件驗證連結',
	'UserReVerifyEmail'			=> '重新發送電子郵件確認憑證',

	// 群組模組
	'GroupsInfo'				=> '在此面板您可以管理所有使用者群組。您可以刪除、建立與編輯現有群組。此外，您可以選擇群組管理員、切換開放/隱藏/關閉群組狀態，並設定群組名稱與說明。',

	'LogMembersUpdated'			=> '已更新使用者群組成員',
	'LogMemberAdded'			=> '已新增成員 ##%1## 至群組 ##%2##',
	'LogMemberRemoved'			=> '已從群組 ##%2## 移除成員 ##%1##',
	'LogGroupCreated'			=> '已建立新群組 ##%1##',
	'LogGroupRenamed'			=> '群組 ##%1## 已重新命名為 ##%2##',
	'LogGroupRemoved'			=> '已移除群組 ##%1##',

	'GroupsMembersFor'			=> '群組成員：',
	'GroupsDescription'			=> '說明',
	'GroupsModerator'			=> '版主',
	'GroupsOpen'				=> '開啟',
	'GroupsActive'				=> '已啟用',
	'GroupsTip'					=> '點擊以編輯群組',
	'GroupsUpdated'				=> '群組已更新',
	'GroupsAlreadyExists'		=> '此群組已存在。',
	'GroupsAdded'				=> '已成功新增群組。',
	'GroupsRenamed'				=> '群組已成功重新命名。',
	'GroupsDeleted'				=> '群組 %1 已從資料庫與所有頁面中刪除。',
	'GroupsAdd'					=> '新增群組',
	'GroupsRename'				=> '將群組 %1 重新命名為',
	'GroupsRenameInfo'			=> '* 注意：變更將影響指派給該群組的所有頁面。',
	'GroupsDelete'				=> '您確定要移除群組 %1 嗎？',
	'GroupsDeleteInfo'			=> '* 注意：變更將影響指派給該群組的所有成員。',
	'GroupsIsSystem'			=> '群組 %1 屬於系統保留，無法移除。',
	'GroupsStoreButton'			=> '儲存群組',
	'GroupsEditInfo'			=> '要編輯群組清單，請選取單選按鈕。',

	'GroupAddMember'			=> '新增成員',
	'GroupRemoveMember'			=> '移除成員',
	'GroupAddNew'				=> '新增群組',
	'GroupEdit'					=> '編輯群組',
	'GroupDelete'				=> '移除群組',

	'MembersAddNew'				=> '新增成員',
	'MembersAdded'				=> '已成功新增新成員至群組。',
	'MembersRemove'				=> '您確定要移除成員 %1 嗎？',
	'MembersRemoved'			=> '該成員已從群組中移除。',

	// Statistics module
	'DbStatSection'				=> '資料庫統計',
	'DbTable'					=> '資料表',
	'DbRecords'					=> '記錄數',
	'DbSize'					=> '大小',
	'DbIndex'					=> '索引',
	'DbTotal'					=> '總計',

	'FileStatSection'			=> '檔案系統統計',
	'FileFolder'				=> '資料夾',
	'FileFiles'					=> '檔案',
	'FileSize'					=> '大小',
	'FileTotal'					=> '總計',

	// Sysinfo module
	'SysInfo'					=> '版本資訊：',
	'SysParameter'				=> '參數',
	'SysValues'					=> '數值',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> '最後更新',
	'ServerOS'					=> '作業系統',
	'ServerName'				=> '伺服器名稱',
	'WebServer'					=> '網頁伺服器',
	'HttpProtocol'				=> 'HTTP 協定',
	'DbVersion'					=> '資料庫',
	'SqlModesGlobal'			=> 'SQL 全域模式',
	'SqlModesSession'			=> 'SQL 會話模式',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> '記憶體限制',
	'UploadFilesizeMax'			=> '上傳檔案最大值',
	'PostMaxSize'				=> 'POST 最大值',
	'MaxExecutionTime'			=> '最大執行時間',
	'SessionPath'				=> 'Session 路徑',
	'PhpDefaultCharset'			=> 'PHP 預設字元集',
	'GZipCompression'			=> 'GZip 壓縮',
	'PhpExtensions'				=> 'PHP 擴充模組',
	'ApacheModules'				=> 'Apache 模組',

	// DB repair module
	'DbRepairSection'			=> '修復資料庫',
	'DbRepair'					=> '修復資料庫',
	'DbRepairInfo'				=> '此腳本可自動檢查並修復一些常見的資料庫問題。修復可能需要一段時間，請耐心等候。',

	'DbOptimizeRepairSection'	=> '修復並優化資料庫',
	'DbOptimizeRepair'			=> '修復並優化資料庫',
	'DbOptimizeRepairInfo'		=> '此腳本也可嘗試優化資料庫。在某些情況下可改善效能。修復與優化資料庫可能需要很長時間，且在優化期間資料庫會被鎖住。',

	'TableOk'					=> '資料表 %1 正常。',
	'TableNotOk'				=> '資料表 %1 不正常。回報了以下錯誤：%2。此腳本將嘗試修復該資料表…',
	'TableRepaired'				=> '成功修復資料表 %1。',
	'TableRepairFailed'			=> '無法修復資料表 %1。<br>錯誤：%2',
	'TableAlreadyOptimized'		=> '資料表 %1 已經是最佳化狀態。',
	'TableOptimized'			=> '成功最佳化資料表 %1。',
	'TableOptimizeFailed'		=> '無法最佳化資料表 %1。<br>錯誤：%2',
	'TableNotRepaired'			=> '有些資料庫問題無法被修復。',
	'RepairsComplete'			=> '修復完成',

	// Inconsistencies module
	'InconsistenciesInfo'		=> '顯示並修正不一致性，刪除或將孤立記錄指派給新使用者或新值。',
	'Inconsistencies'			=> '不一致項目',
	'CheckDatabase'				=> '資料庫',
	'CheckDatabaseInfo'			=> '檢查資料庫中的記錄不一致情況。',
	'CheckFiles'				=> '檔案',
	'CheckFilesInfo'			=> '檢查遺留檔案，即在檔案表中已無任何參考的檔案。',
	'Records'					=> '記錄',
	'InconsistenciesNone'		=> '未發現資料不一致。',
	'InconsistenciesDone'		=> '資料不一致已解決。',
	'InconsistenciesRemoved'	=> '已移除的不一致項目',
	'Check'						=> '檢查',
	'Solve'						=> '解決',

	// Bad Behaviour module
	'BbInfo'					=> '偵測並阻擋不良的網站存取，拒絕自動化垃圾郵件機器人存取。<br>欲知更多資訊請造訪 %1 首頁。',
	'BbEnable'					=> '啟用 Bad Behaviour：',
	'BbEnableInfo'				=> '其他設定可在設定資料夾 %1 中變更。',
	'BbStats'					=> 'Bad Behaviour 在過去 7 天內已阻擋 %1 次存取嘗試。',

	'BbSummary'					=> '摘要',
	'BbLog'						=> '日誌',
	'BbSettings'				=> '設定',
	'BbWhitelist'				=> '白名單',

	// --> Log
	'BbHits'					=> '次數',
	'BbRecordsFiltered'			=> '顯示 %1（共 %2 筆）經過篩選的記錄，篩選條件：',
	'BbStatus'					=> '狀態',
	'BbBlocked'					=> '已阻擋',
	'BbPermitted'				=> '允許',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> '顯示所有 %1 筆記錄',
	'BbShow'					=> '顯示',
	'BbIpDateStatus'			=> 'IP/日期/狀態',
	'BbHeaders'					=> '標頭',
	'BbEntity'					=> '實體',

	// --> Whitelist
	'BbOptionsSaved'			=> '選項已儲存。',
	'BbWhitelistHint'			=> '不當的白名單設定會讓您暴露在垃圾郵件風險中，或導致 Bad Behaviour 完全失效！除非您 100% 確定，否則請勿加入白名單。',
	'BbIpAddress'				=> 'IP 地址',
	'BbIpAddressInfo'			=> '要加入白名單的 IP 位址或 CIDR 格式的地址範圍（每行一筆）',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> '以網站主機名稱後的 / 開頭的 URL 片段（每行一筆）',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> '要加入白名單的使用者代理字串（每行一筆）',

	// --> Settings
	'BbSettingsUpdated'			=> 'Bad Behaviour 設定已更新',
	'BbLogRequest'				=> '記錄 HTTP 請求',
	'BbLogVerbose'				=> '詳細記錄',
	'BbLogNormal'				=> '一般（建議）',
	'BbLogOff'					=> '不記錄（不建議）',
	'BbSecurity'				=> '安全性',
	'BbStrict'					=> '嚴格檢查',
	'BbStrictInfo'				=> '可阻擋更多垃圾郵件，但可能誤阻部分使用者',
	'BbOffsiteForms'			=> '允許其他網站提交表單',
	'BbOffsiteFormsInfo'		=> 'OpenID 所需；會增加接收的垃圾郵件數量',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> '要使用 Bad Behaviour 的 http:BL 功能，您必須擁有一個 %1',
	'BbHttpblKey'				=> 'http:BL 存取金鑰',
	'BbHttpblThreat'			=> '最低威脅等級（建議為 25）',
	'BbHttpblMaxage'			=> '資料最大年齡（建議為 30）',
	'BbReverseProxy'			=> '反向代理/負載平衡器',
	'BbReverseProxyInfo'		=> '如果您在反向代理、負載平衡器、HTTP 加速器、內容快取或類似技術後方使用 Bad Behaviour，請啟用反向代理選項。<br>' .
	'如果伺服器與公開網際網路之間有兩層或更多的反向代理，您必須以 CIDR 格式指定所有代理伺服器、負載平衡器等的 IP 位址範圍。否則 Bad Behaviour 可能無法判斷客戶端的真實 IP 位址。<br>' .
	'此外，您的反向代理伺服器必須將他們從中接收請求的網際網路用戶端 IP 位址放入 HTTP 標頭。如果您未指定標頭，將使用 %1。大多數代理伺服器已支援 X-Forwarded-For，只要在代理上啟用即可。其他常見的標頭名稱還包含 %2 與 %3。',
	'BbReverseProxyEnable'		=> '啟用反向代理',
	'BbReverseProxyHeader'		=> '包含網際網路用戶端 IP 的標頭',
	'BbReverseProxyAddresses'	=> '您代理伺服器的 IP 位址或 CIDR 格式的地址範圍（每行一筆）',

];
