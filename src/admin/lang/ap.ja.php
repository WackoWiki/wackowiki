<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> '基本機能',
		'preferences'	=> 'ユーザー設定',
		'content'		=> 'コンテンツ',
		'users'			=> 'ユーザー',
		'maintenance'	=> 'メンテナンス',
		'messages'		=> 'メッセージ',
		'extension'		=> '拡張',
		'database'		=> 'データベース',
	],

	// Admin panel
	'AdminPanel'				=> '管理コントロール パネル',
	'RecoveryMode'				=> 'リカバリーモード',
	'Authorization'				=> '認可',
	'AuthorizationTip'			=> '管理者パスワードを入力してください(ブラウザでクッキーが許可されていることを確認してください)。',
	'NoRecoveryPassword'		=> '管理パスワードが指定されていない！',
	'NoRecoveryPasswordTip'		=> '注：管理パスワードがないことは、セキュリティ上の脅威となる！設定ファイルにパスワードハッシュを入力し、再度プログラムを実行してください。',

	'ApDevNologinBlocked'		=> 'アクセスがブロックされました: admin.phpでAP_DEV_NOLOGINが有効になっていますが、リクエストはlocalhost(127.0.0.1、::1、localhost)からのものではありません。 これは開発専用フラグであり、本番環境では無効にする必要があります。アクセスを復元するには、admin.php で <code>AP_DEV_NOLOGIN = 0</code> を設定してください。',
	'ApDevNologinBlockedLog'	=> '!!! SECURITY: %1 is enabled but admin.php was accessed from a non-localhost address (%2). Admin panel access has been blocked.',

	'ErrorLoadingModule'		=> '管理モジュール %1の読み込み中にエラーが発生しました: 存在しません。',

	'ApHomePage'				=> 'ホームページ',
	'ApHomePageTip'				=> 'システムの管理を終了し、ホームページを開く',
	'ApLogOut'					=> 'ログアウト',
	'ApLogOutTip'				=> 'quit system administration',

	'TimeLeft'					=> 'Time left:  %1 minutes',
	'TimeLeftInfinity'			=> '残り時間:  %1 (開発者モード)',
	'ApVersion'					=> 'バージョン',

	'SiteOpen'					=> '開く',
	'SiteOpened'				=> 'サイトが開かれました',
	'SiteOpenedTip'				=> 'サイトは開いています',
	'SiteClose'					=> '閉じる',
	'SiteClosed'				=> 'サイトが閉じられました',
	'SiteClosedTip'				=> 'サイトは閉じられています',

	'System'					=> 'システム',

	// Generic
	'Cancel'					=> 'キャンセル',
	'Add'						=> '追加',
	'Edit'						=> '編集',
	'Remove'					=> '削除',
	'Enabled'					=> '有効にする',
	'Disabled'					=> '無効',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> '管理',
	'Min'						=> '最小',
	'Max'						=> '最大値',

	'MiscellaneousSection'		=> 'その他',
	'MainSection'				=> '全般オプション',

	'DirNotWritable'			=> '%1 ディレクトリは書き込み可能ではありません。',
	'FileNotWritable'			=> '%1 ファイルは書き込み可能ではありません。',

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
		'name'		=> '外観',
		'title'		=> '外観の設定',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'メール',
		'title'		=> 'メール設定',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Syndication',
		'title'		=> '配信設定',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'フィルター',
		'title'		=> 'フィルタの設定',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatter',
		'title'		=> '書式設定',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> '通知',
		'title'		=> '通知設定',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'ページ',
		'title'		=> 'ページとサイトパラメータ',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'パーミッション',
		'title'		=> '権限の設定',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'セキュリティ',
		'title'		=> 'セキュリティサブシステムの設定',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'システム',
		'title'		=> 'システムオプション',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'アップロード',
		'title'		=> '添付ファイルの設定',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> '削除しました',
		'title'		=> '新しく削除されたコンテンツ',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'メニュー',
		'title'		=> 'デフォルトのメニュー項目を追加、編集、または削除します',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'バックアップ',
		'title'		=> 'データのバックアップ',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> '修復',
		'title'		=> 'データベースの修復と最適化',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> '復元',
		'title'		=> 'バックアップデータを復元中',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'メインメニュー',
		'title'		=> 'WackoWiki管理',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> '不整合性',
		'title'		=> 'データの不整合の修正',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'データ同期',
		'title'		=> 'データの同期',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> '一括メール',
		'title'		=> '一括メール',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'システム メッセージ',
		'title'		=> 'システムメッセージ',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'システム情報',
		'title'		=> 'システム情報',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System log',
		'title'		=> 'システムイベントのログ',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> '統計情報',
		'title'		=> '統計情報を表示',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> '不正な動作',
		'title'		=> '不正な動作',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> '承認',
		'title'		=> 'ユーザー登録の承認',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'グループ',
		'title'		=> 'グループ管理',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'ユーザー',
		'title'		=> 'ユーザー管理',
	],

	// Main module
	'MainNote'					=> '注意: 管理メンテナンスのため、サイトへのアクセスを一時的にブロックすることをお勧めします。',

	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'すべてのセッションを消去',
	'PurgeSessionsConfirm'		=> 'すべてのセッションを削除してもよろしいですか？すべてのユーザーがログアウトします。',
	'PurgeSessionsExplain'		=> 'すべてのセッションを削除します。auth_token テーブルを切り捨てることで、すべてのユーザーがログアウトします。',
	'PurgeSessionsDone'			=> 'セッションの削除に成功しました。',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> '基本設定を更新しました',
	'LogBasicSettingsUpdated'	=> '基本設定を更新しました',

	'SiteName'					=> 'サイト名：',
	'SiteNameInfo'				=> 'このサイトのタイトル。ブラウザのタイトル、テーマヘッダー、メール通知などに表示されます。',
	'SiteDesc'					=> 'サイト説明：',
	'SiteDescInfo'				=> 'ページヘッダーに表示されるサイトのタイトルを補足します．このサイトが何であるかをいくつかの言葉で説明します．',
	'AdminName'					=> 'サイト管理者：',
	'AdminNameInfo'				=> 'サイト全体のサポートを担当する個人のユーザー名。 この名前はアクセス権を決定するために使用されません でもサイトの管理責任者の名前に合致することが望ましいです',

	'LanguageSection'			=> '言語',
	'DefaultLanguage'			=> 'デフォルト言語:',
	'DefaultLanguageInfo'		=> '未登録のゲストに表示されるメッセージの言語と、ロケール設定を指定します。',
	'MultiLanguage'				=> '多言語サポート:',
	'MultiLanguageInfo'			=> 'ページ単位で言語を選択する機能を有効にします。',
	'AllowedLanguages'			=> '使用可能な言語:',
	'AllowedLanguagesInfo'		=> '使用する言語のセットのみを選択することをお勧めします。そうでなければ、すべての言語が選択されます。',

	'CommentSection'			=> 'コメント',
	'AllowComments'				=> 'コメントを許可:',
	'AllowCommentsInfo'			=> 'ゲストまたは登録ユーザーのみのコメントを有効にするか、サイト全体でコメントを無効にします。',
	'SortingComments'			=> 'ソートコメント:',
	'SortingCommentsInfo'		=> 'ページのコメントが表示される順序を変更します。上部にある最新のコメントまたは最も古いコメントが表示されます。',
	'CommentsOffset'			=> 'コメントページ:',
	'CommentsOffsetInfo'		=> 'デフォルトで表示されるコメントページ',

	'ToolbarSection'			=> 'ツールバー',
	'CommentsPanel'				=> 'コメント パネル:',
	'CommentsPanelInfo'			=> 'ページの下部にコメントがデフォルトで表示されます。',
	'FilePanel'					=> 'ファイルパネル:',
	'FilePanelInfo'				=> 'ページの下部に添付ファイルが既定で表示されます。',
	'TagsPanel'					=> 'タグパネル:',
	'TagsPanelInfo'				=> 'ページの下部にあるタグパネルのデフォルト表示。',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'パーマリンクを表示:',
	'ShowPermalinkInfo'			=> 'ページの現在のバージョンのパーマリンクのデフォルト表示。',
	'TocPanel'					=> '目次パネル:',
	'TocPanelInfo'				=> 'ページのコンテンツパネルのデフォルトの表示テーブル (テンプレートでサポートが必要な場合があります)。',
	'SectionsPanel'				=> 'セクションパネル:',
	'SectionsPanelInfo'			=> 'デフォルトでは、隣接するページのパネルを表示します(テンプレートでサポートが必要です)。',
	'DisplayingSections'		=> 'セクションを表示:',
	'DisplayingSectionsInfo'	=> 'When the previous options are set, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>), both, or other (<em>tree</em>).',
	'MenuItems'					=> 'メニューアイテム:',
	'MenuItemsInfo'				=> 'デフォルトのメニューアイテム数（テンプレートでサポートが必要な場合があります）。',

	'HandlerSection'			=> 'Handler',
	'HideRevisions'				=> 'リビジョンを非表示:',
	'HideRevisionsInfo'			=> 'ページのリビジョンのデフォルト表示。',
	'AttachmentHandler'			=> '添付ファイルハンドラを有効化:',
	'AttachmentHandlerInfo'		=> '添付ファイルハンドラの表示を許可します。',
	'SourceHandler'				=> 'ソースハンドラを有効にします:',
	'SourceHandlerInfo'			=> 'ソースハンドラの表示を許可します。',
	'ExportHandler'				=> 'XML エクスポートハンドラーを有効にします:',
	'ExportHandlerInfo'			=> 'XML エクスポートハンドラーの表示を許可します。',

	'DiffModeSection'			=> '差分モード',
	'DefaultDiffModeSetting'	=> 'デフォルトの差分モード:',
	'DefaultDiffModeSettingInfo'=> '差分モードが事前に選択されています。',
	'AllowedDiffMode'			=> '許可されている差分モード:',
	'AllowedDiffModeInfo'		=> '使用する差分モードのセットのみを選択することをお勧めします。そうでない場合はすべての差分モードが選択されます。',
	'NotifyDiffMode'			=> '差分モードを通知:',
	'NotifyDiffModeInfo'		=> 'メール本文の通知に使用される差分モードです。',

	'EditingSection'			=> '編集',
	'EditSummary'				=> '概要を編集:',
	'EditSummaryInfo'			=> '編集モードで変更の概要を表示します。',
	'MinorEdit'					=> '小変更:',
	'MinorEditInfo'				=> '編集モードでマイナー編集オプションを有効にします。',
	'SectionEdit'				=> 'セクション編集:',
	'SectionEditInfo'			=> 'ページの一部分のみを編集することができます．',
	'ReviewSettings'			=> 'レビュー:',
	'ReviewSettingsInfo'		=> '編集モードでレビューオプションを有効にします。',
	'PublishAnonymously'		=> '匿名公開を許可:',
	'PublishAnonymouslyInfo'	=> 'ユーザーが匿名で公開することを許可します(名前を非表示にする)。',

	'DefaultRenameRedirect'		=> '名前を変更する場合、リダイレクトを作成します。',
	'DefaultRenameRedirectInfo'	=> 'デフォルトでは、リネームされているページの古いアドレスにリダイレクトを設定します。',
	'StoreDeletedPages'			=> '削除されたページを保持:',
	'StoreDeletedPagesInfo'		=> 'ページ、コメント、ファイルを削除した場合は、特別なセクションに保存します。 以下で説明するように、しばらくの間、レビューとリカバリを行うことができます。',
	'KeepDeletedTime'			=> '削除されたページの保存時間:',
	'KeepDeletedTimeInfo'		=> '日付の期間. これは、前のオプションでのみ意味を成します. エンティティが削除されないようにするには、ゼロを使用してください(この場合、管理者は「カート」を手動で削除できます)。',
	'PagesPurgeTime'			=> 'ページ改訂の保存時間:',
	'PagesPurgeTimeInfo'		=> '指定された日数以内に自動的に古いバージョンを削除します。0 を入力すると、古いバージョンは削除されません。',
	'EnableReferrers'			=> '紹介を有効にする:',
	'EnableReferrersInfo'		=> '外部紹介者の作成と表示を許可します。',
	'ReferrersPurgeTime'		=> '紹介者のストレージ時間:',
	'ReferrersPurgeTimeInfo'	=> '参照元の外部ページの履歴は指定された日数以内に保持されます。 紹介者が削除されないようにするには、ゼロを使用してください(ただし、アクティブに訪問されたサイトでは、データベースのオーバーフローにつながる可能性があります)。',
	'EnableCounters'			=> 'ヒット数：',
	'EnableCountersInfo'		=> 'ページヒットカウンターごとに許可し、簡単な統計情報を表示します。ページオーナーのビューはカウントされません。',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'サイトのデフォルトのウェブシンジケーション設定を制御します。',
	'SyndicationSettingsUpdated'	=> '同期設定を更新しました。',

	'FeedsSection'				=> 'フィード',
	'EnableFeeds'				=> 'フィードを有効にする:',
	'EnableFeedsInfo'			=> 'RSSフィードをWiki全体のオンまたはオフにします。',
	'XmlChangeLink'				=> 'フィードリンクモードを変更:',
	'XmlChangeLinkInfo'			=> 'XML 変更がリンクされる場所を定義します。',
	'XmlChangeLinkMode'			=> [
		'1'		=> '変更点のリスト',
		'2'		=> '現在のページ',
		'3'		=> 'リビジョンのリスト',
		'4'		=> '変更されたページ',
	],

	'XmlSitemap'				=> 'XML Sitemap:',
	'XmlSitemapInfo'			=> 'xmlフォルダ内に %1 という名前のXMLファイルを作成します。 ルートディレクトリのrobots.txtファイルのサイトマップに以下のようにパスを追加できます:',
	'XmlSitemapGz'				=> 'XML Sitemap compression:',
	'XmlSitemapGzInfo'			=> '必要に応じて、gzip を使用してサイトマップテキストファイルを圧縮して帯域幅の要件を減らすことができます。',
	'XmlSitemapTime'			=> 'XMLサイトマップ生成時間:',
	'XmlSitemapTimeInfo'		=> 'サイトマップを生成するのは、指定された日数に一度だけです。すべてのページ変更で生成するには、ゼロに設定してください。',

	'SearchSection'				=> '検索',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'XMLフォルダにOpenSearch記述ファイルを作成し、HTMLヘッダで検索プラグインの自動検出を有効にします。',
	'SearchEngineVisibility'	=> '検索エンジンをブロック (検索エンジンの可視性):',
	'SearchEngineVisibilityInfo'=> '検索エンジンをブロックしますが、通常の訪問者を許可します。ページ設定を上書きします。 <br>このサイトのインデックスから検索エンジンを阻止します。このリクエストを尊重するためには、検索エンジンが必要です。',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'サイトのデフォルト表示設定を制御します。',
	'AppearanceSettingsUpdated'	=> '外観の設定を更新しました。',

	'LogoOff'					=> 'オフ',
	'LogoOnly'					=> 'ロゴ',
	'LogoAndTitle'				=> 'ロゴとタイトル',

	'LogoSection'				=> 'ロゴ',
	'SiteLogo'					=> 'サイトのロゴ:',
	'SiteLogoInfo'				=> '通常、ロゴはアプリケーションの左上隅に表示されます。 最大サイズは2 MiBです。最適な寸法は、幅255ピクセル、高さ55ピクセルです。',
	'LogoDimensions'			=> 'ロゴ寸法:',
	'LogoDimensionsInfo'		=> '表示されるロゴの幅と高さ。',
	'LogoDisplayMode'			=> 'ロゴ表示モード:',
	'LogoDisplayModeInfo'		=> 'ロゴの外観を指定します。デフォルトは OFF です。',

	'FaviconSection'			=> 'ファビコン',
	'SiteFavicon'				=> 'Site Favicon:',
	'SiteFaviconInfo'			=> 'ショートカットアイコン、またはfaviconがほとんどのブラウザのアドレスバー、タブ、ブックマークに表示されます。これはテーマのfaviconを上書きします。',
	'SiteFaviconTooBig'			=> 'ファビコンは64×64ピクセルより大きい。',
	'ThemeColor'				=> 'アドレスバーのテーマカラー:',
	'ThemeColorInfo'			=> 'ブラウザは、指定されたCSSカラーに従って、すべてのページのアドレスバーの色を設定します。',

	'LayoutSection'				=> 'レイアウト',
	'Theme'						=> 'テーマ:',
	'ThemeInfo'					=> 'サイトがデフォルトで使用するテンプレートのデザイン。',
	'ResetUserTheme'			=> 'すべてのユーザーテーマをリセット:',
	'ResetUserThemeInfo'		=> 'すべてのユーザーテーマをリセットします。警告: この操作は、ユーザーが選択したすべてのテーマをグローバルデフォルトテーマに戻します。',
	'SetBackUserTheme'			=> 'すべてのユーザーテーマを %1 テーマに戻す',
	'ThemesAllowed'				=> '許可されたテーマ:',
	'ThemesAllowedInfo'			=> 'ユーザーが選択できる許可されたテーマを選択します。そうでなければ、すべての利用可能なテーマが許可されます。',
	'ThemesPerPage'				=> 'ページごとのテーマ:',
	'ThemesPerPageInfo'			=> 'ページごとのテーマを許可します。ページの所有者は、ページ プロパティで選択できます。',

	// System settings
	'SystemSettingsInfo'		=> 'サイトの微調整を担当するパラメータのグループです。自分の行動に自信がない限り変更しないでください。',
	'SystemSettingsUpdated'		=> 'システム設定を更新しました',

	'DebugModeSection'			=> 'Debug mode',
	'DebugMode'					=> 'デバッグモード:',
	'DebugModeInfo'				=> 'アプリケーションの実行時間に関するテレメトリーデータの抽出と出力。 注意:フルディテールモードでは、割り当てられたメモリに、特にデータベースのバックアップや復元などのリソースを必要とする操作には、より高い要件が課されます。',
	'DebugModes'	=> [
		'0'		=> 'デバッグはオフです',
		'1'		=> '合計実行時間だけだ',
		'2'		=> 'フルタイムの',
		'3'		=> '詳細（DBMS、キャッシュなど）',
	],
	'DebugSqlThreshold'			=> '閾値パフォーマンス RDBMS:',
	'DebugSqlThresholdInfo'		=> '詳細なデバッグモードでは、指定した秒数よりも長いクエリのみを報告します。',
	'DebugAdminOnly'			=> '閉じた診断:',
	'DebugAdminOnlyInfo'		=> '管理者のみ、プログラム (および DBMS) のデバッグ データを表示します。',

	'CachingSection'			=> 'キャッシュオプション',
	'Cache'						=> 'レンダリングされたページのキャッシュ:',
	'CacheInfo'					=> '後続の起動をスピードアップするために、レンダリングされたページをローカルキャッシュに保存します。未登録の訪問者のみ有効です。',
	'CacheTtl'					=> 'キャッシュされたページのライブまでの時間:',
	'CacheTtlInfo'				=> '指定された秒数以下のページをキャッシュします。',
	'CacheSql'					=> 'DBMSクエリをキャッシュ:',
	'CacheSqlInfo'				=> '特定のリソース関連SQLクエリの結果のローカルキャッシュを維持します。',
	'CacheSqlTtl'				=> 'キャッシュされた SQL クエリのライブまでの時間:',
	'CacheSqlTtlInfo'			=> 'SQLクエリのキャッシュ結果は指定された秒数以下です。1200より大きい値は望ましくありません。',

	'LogSection'				=> 'Log settings',
	'LogLevelUsage'				=> 'Using logging:',
	'LogLevelUsageInfo'			=> 'ログに記録されたイベントの優先度の最小値。',
	'LogThresholds'	=> [
		'0'		=> '日記を持たないでください',
		'1'		=> '重要なレベルだけが',
		'2'		=> '最高レベルから',
		'3'		=> '高さから',
		'4'		=> '平均して',
		'5'		=> '低いからです',
		'6'		=> '最小レベル',
		'7'		=> 'すべてを記録',
	],
	'LogDefaultShow'			=> 'Display Log Mode:',
	'LogDefaultShowInfo'		=> 'デフォルトでログに表示される最小優先度イベント。',
	'LogModes'	=> [
		'1'		=> '重要なレベルだけが',
		'2'		=> '最高レベルから',
		'3'		=> '高レベルから',
		'4'		=> '平均値は',
		'5'		=> '低いからね',
		'6'		=> '最低レベルから',
		'7'		=> 'すべて表示',
	],
	'LogPurgeTime'				=> 'ログの保存時間:',
	'LogPurgeTimeInfo'			=> '指定した日数の後にイベントログを削除します。',

	'PrivacySection'			=> 'プライバシー',
	'AnonymizeIp'				=> 'ユーザーの IP アドレスを匿名化:',
	'AnonymizeIpInfo'			=> '該当する (すなわち、ページ、リビジョンまたはリファラー) IP アドレスを匿名化します。',

	'ReverseProxySection'		=> 'リバースプロキシ',
	'ReverseProxy'				=> 'リバースプロキシを使用:',
	'ReverseProxyInfo'			=> 'この設定を有効にすると、X-Forward-For ヘッダーに保存されている情報を調べることで、リモートクライアントの正しいIPアドレスを特定できます。 X-Forwarded-For ヘッダは、イカやポンドなど、リバースプロキシサーバーを介して接続しているクライアントシステムを識別するための標準的なメカニズムです。 リバース・プロキシ・サーバーは、多くの場合、訪問されたサイトのパフォーマンスを向上させるために使用され、他のサイトのキャッシュ、セキュリティ、または暗号化の利点を提供する可能性があります。 この WackoWiki インストールがリバースプロキシの背後で動作する場合。 この設定は、WackoWikiのセッション管理、ログ、統計、アクセス管理システムで正しいIPアドレス情報をキャプチャするように有効にする必要があります。 この設定が不明な場合はリバースプロキシを使用しないでください または、WackoWikiは共有ホスティング環境で動作します。この設定は無効のままにしておく必要があります。',
	'ReverseProxyHeader'		=> 'リバースプロキシヘッダー:',
	'ReverseProxyHeaderInfo'	=> 'Set this value if your proxy server sends the client IP in a header
									 other than X-Forwarded-For. The "X-Forwarded-For" header is a comma-delimited list of IP
									 addresses; only the last one (the left-most) will be used.',
	'ReverseProxyAddresses'		=> 'reverse_proxy は IP アドレスの配列を受け付けます:',
	'ReverseProxyAddressesInfo'	=> 'Each element of this array is the IP address of any of your reverse
									 proxies. If using this array, WackoWiki will trust the information stored
									 in the X-Forwarded-For headers only if the Remote IP address is one of
									 these, that is, the request reaches the web server from one of your
									 reverse proxies. Otherwise, the client could directly connect to
									 your web server by spoofing the X-Forwarded-For headers.',

	'SessionSection'				=> 'Session handling',
	'SessionStorage'				=> 'セッションストレージ:',
	'SessionStorageInfo'			=> 'このオプションは、セッションデータがどこに保存されるかを定義します。デフォルトでは、ファイルまたはデータベースセッションストレージが選択されています。',
	'SessionModes'	=> [
		'1'		=> 'ファイル',
		'2'		=> 'データベース',
	],
	'SessionNotice'					=> 'セッションの終了原因を表示:',
	'SessionNoticeInfo'				=> 'セッション終了の原因を示す。',
	'LoginNotice'					=> 'ログイン通知：',
	'LoginNoticeInfo'				=> 'ログイン通知を表示します。',

	'RewriteMode'					=> '<code>mod_rewrite</code> を使用する :',
	'RewriteModeInfo'				=> 'Webサーバーがこの機能をサポートしている場合は、ページURLを「美しく」することを有効にします。<br>
										<span class="cite">実行時に設定クラスによって値が上書きされる可能性があります HTTP_MOD_REWRITE がオンになっているかどうかにかかわらず。',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'アクセス制御および権限の責任を負うパラメータ',
	'PermissionsSettingsUpdated'	=> '権限設定を更新しました',

	'PermissionsSection'		=> '権利と特権',
	'ReadRights'				=> '既定で読み込み権限：',
	'ReadRightsInfo'			=> '作成されたルートページに割り当てられた既定値と、親ACLを定義できないページ。',
	'WriteRights'				=> 'デフォルトでの書き込み権限:',
	'WriteRightsInfo'			=> '作成されたルートページに割り当てられた既定値と、親ACLを定義できないページ。',
	'CommentRights'				=> 'デフォルトでのコメント権限:',
	'CommentRightsInfo'			=> '作成されたルートページに割り当てられた既定値と、親ACLを定義できないページ。',
	'CreateRights'				=> 'サブページのアクセス権をデフォルトで作成:',
	'CreateRightsInfo'			=> '作成されたサブページに割り当てられたデフォルト。',
	'UploadRights'				=> 'デフォルトでのアップロード権限:',
	'UploadRightsInfo'			=> 'デフォルトのアップロード権限。',
	'RenameRights'				=> 'グローバル名称権限:',
	'RenameRightsInfo'			=> '自由にページ名を変更する権限の一覧です。',

	'LockAcl'					=> 'すべての ACL を読み取り専用にロック:',
	'LockAclInfo'				=> '<span class="cite">読み取り専用のすべてのページの ACL 設定を上書きします。 <span class="cite"></span><br>プロジェクトが終了した場合に便利かもしれません セキュリティ上の理由から一定期間閉じて編集するか 攻撃や脆弱性への緊急対応か',
	'HideLocked'				=> 'アクセスできないページを非表示:',
	'HideLockedInfo'			=> 'ユーザーがページを読む権限を持っていない場合 別のページ リストでそれを非表示にします(ただし、テキストに配置されたリンクはまだ表示されます)。',
	'RemoveOnlyAdmins'			=> '管理者のみページを削除できます：',
	'RemoveOnlyAdminsInfo'		=> '管理者以外のすべてを拒否します。最初の制限は通常のページの所有者に適用されます。',
	'OwnersRemoveComments'		=> 'ページの所有者はコメントを削除できます:',
	'OwnersRemoveCommentsInfo'	=> 'ページ所有者が自分のページのコメントを管理できるようにします。',
	'OwnersEditCategories'		=> 'オーナーはページカテゴリを編集できます:',
	'OwnersEditCategoriesInfo'	=> '所有者がサイトのページカテゴリリストを変更することを許可します (単語の追加、単語の削除)、ページに割り当てます。',
	'TermHumanModeration'		=> 'ヒューマンモデレーションの有効期限:',
	'TermHumanModerationInfo'	=> 'モデレータは、この日数以上前に作成されたコメントのみ編集できます (この制限はトピックの最後のコメントには適用されません)。',

	'UserCanDeleteAccount'		=> 'ユーザーによるアカウントの削除を許可する',

	// Security settings
	'SecuritySettingsInfo'		=> 'プラットフォームの全体的な安全性、安全制限、追加のセキュリティサブシステムを担当するパラメータ。',
	'SecuritySettingsUpdated'	=> 'セキュリティ設定を更新しました',

	'AllowRegistration'			=> 'オンライン登録:',
	'AllowRegistrationInfo'		=> 'ユーザー登録を開きます。このオプションを無効にすると無料登録ができなくなりますが、サイト管理者はユーザーを登録することができます。',
	'ApproveNewUser'			=> '新しいユーザーを承認:',
	'ApproveNewUserInfo'		=> '管理者は登録するとユーザーを承認することができます。承認されたユーザーのみがサイトにログインできます。',
	'PersistentCookies'			=> '永続的なクッキー:',
	'PersistentCookiesInfo'		=> '永続的なクッキーを許可する',
	'DisableWikiName'			=> 'WikiNameを無効にする:',
	'DisableWikiNameInfo'		=> '強制的なCamelCase形式の名前 (NameSurname) ではなく、従来のニックネームでのユーザー登録を許可します。',
	'UsernameLength'			=> 'ユーザー名の長さ:',
	'UsernameLengthInfo'		=> 'ユーザ名の最小文字と最大文字数。',

	'EmailSection'				=> 'Eメールアドレス',
	'AllowEmailReuse'			=> 'メールアドレスの再利用を許可:',
	'AllowEmailReuseInfo'		=> '異なるユーザーは、同じメールアドレスで登録できます。',
	'EmailConfirmation'			=> '電子メール確認を強制します：',
	'EmailConfirmationInfo'		=> 'ユーザがログインする前に電子メール・アドレスを確認することを要求します。',
	'AllowedEmailDomains'		=> '許可された電子メール・ドメイン：',
	'AllowedEmailDomainsInfo'	=> '許可された電子メールドメインはカンマで区切られています。例えば、<code>example.com, local.lan</code>などです。, other wise all email domains are allowed.',
	'ForbiddenEmailDomains'		=> '禁止された電子メールドメイン：',
	'ForbiddenEmailDomainsInfo'	=> 'カンマ区切りの禁止されたメールドメイン、例えば、 <code>example.com、local.lan</code> など。許可されたメールドメインリストが空の場合にのみ有効です。',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Captcha を有効にする',
	'EnableCaptchaInfo'			=> '有効にすると、次の場合、またはセキュリティ閾値に達した場合にCaptchaが表示されます。',
	'CaptchaComment'			=> '新規コメント:',
	'CaptchaCommentInfo'		=> 'スパムに対する保護として、未登録のユーザーはコメントが投稿される前にCAPTCHAを完了する必要があります。',
	'CaptchaPage'				=> '新しいページ:',
	'CaptchaPageInfo'			=> 'スパムに対する保護として、未登録のユーザーは新しいページを作成する前にCAPTCHAを完了する必要があります。',
	'CaptchaEdit'				=> 'ページの編集:',
	'CaptchaEditInfo'			=> 'スパムに対する保護として、未登録のユーザーはページを編集する前にCAPTCHAを完了する必要があります。',
	'CaptchaRegistration'		=> 'アカウント作成',
	'CaptchaRegistrationInfo'	=> 'スパムに対する保護として、未登録のユーザーは登録する前にCAPTCHAを完了する必要があります。',

	'TlsSection'				=> 'TLS 設定',
	'TlsConnection'				=> 'TLS 接続:',
	'TlsConnectionInfo'			=> 'TLSセキュア接続を使用します。 <span class="cite">サーバー上で必要なプリインストールされた TLS 証明書を有効にすると、管理者パネルへのアクセスが失われます。 <span class="cite"></span><br>また、Cookie Secure Flagが設定されているかどうかも決定します。 <code>セキュア</code> フラグは、Cookie をセキュアな接続上でのみ送信するかどうかを指定します。',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'クライアントを HTTP から HTTPS へ強制的に再接続します。このオプションを無効にすると、クライアントは開いている HTTP チャンネルを介してサイトを参照できます。',

	'HttpSecurityHeaders'		=> 'HTTP セキュリティヘッダー',
	'EnableSecurityHeaders'		=> 'セキュリティヘッダーを有効にする:',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk!',
	'Csp'						=> 'コンテンツ セキュリティ ポリシー (CSP):',
	'CspInfo'					=> 'CSP の設定では、どのポリシーを適用するかを決定し、そのポリシーを設定し、Content-Security-Policy を使用してポリシーを設定します。',
	'PolicyModes'	=> [
		'0'		=> '無効',
		'1'		=> '厳格な',
		'2'		=> 'カスタム',
	],
	'PermissionsPolicy'			=> 'Permissions Policy:',
	'PermissionsPolicyInfo'		=> 'HTTP Permissions-Policy ヘッダーは、さまざまな強力なブラウザ機能を明示的に有効または無効にするメカニズムを提供します。',
	'ReferrerPolicy'			=> 'Referrer Policy:',
	'ReferrerPolicyInfo'		=> 'Referrer-Policy HTTP ヘッダは、Referer ヘッダに送られるリファラー情報をレスポンスに含めるべきです。',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> '安全でない URL'
	],

	'UserPasswordSection'		=> 'ユーザパスワードの永続性',
	'PwdMinChars'				=> 'パスワードの最小文字数:',
	'PwdMinCharsInfo'			=> 'より長いパスワードは、必ずしも短いパスワード(例えば、12文字から16文字まで)よりも安全です。<br>パスワードの代わりにパスフレーズを使用することを推奨します。',
	'AdminPwdMinChars'			=> '最小管理者パスワードの長さ:',
	'AdminPwdMinCharsInfo'		=> 'より長いパスワードは、必ずしも短いパスワード(例えば、15文字から20文字まで)よりも安全です。<br>パスワードの代わりにパスフレーズを使用することを推奨します。',
	'PwdCharComplexity'			=> '必要なパスワードの複雑さ:',
	'PwdCharClasses'	=> [
		'0'		=> 'テストされていない',
		'1'		=> '任意の文字 + 数字',
		'2'		=> '大文字と小文字+数字',
		'3'		=> '大文字と小文字+数字 + 文字',
	],
	'PwdUnlikeLogin'			=> 'その他の合併症:',
	'PwdUnlikes'	=> [
		'0'		=> 'テストされていない',
		'1'		=> 'パスワードがログインと同じではありません',
		'2'		=> 'パスワードにユーザー名が含まれていません',
	],

	'LoginSection'				=> 'ログイン',
	'MaxLoginAttempts'			=> '最大ログイン試行回数/ユーザー名:',
	'MaxLoginAttemptsInfo'		=> 'アンチスパムボットタスクがトリガーされる前に、1つのアカウントで許可されるログイン試行回数。 0を入力すると、スパムボット対策タスクが別のユーザーアカウントでトリガーされるのを防ぎます。',
	'IpLoginLimitMax'			=> 'IPアドレスあたりの最大ログイン回数:',
	'IpLoginLimitMaxInfo'		=> 'アンチスパムボットタスクがトリガーされる前に、単一のIPアドレスから許可されたログイン試行のしきい値。 スパムボット対策タスクがIPアドレスでトリガーされないようにするには、0を入力します。',

	'FormsSection'				=> 'フォーム',
	'FormTokenTime'				=> 'フォームを送信する最大時間:',
	'FormTokenTimeInfo'			=> 'ユーザーがフォームを送信しなければならない時間 (秒単位)。<br> この設定に関係なく、セッションの有効期限が切れるとフォームが無効になることがあります。',

	'SessionLength'				=> 'セッションクッキーの有効期限:',
	'SessionLengthInfo'			=> 'デフォルトでユーザーセッションクッキーの有効期間 (日数)',
	'CommentDelay'				=> 'コメントに対する洪水対策：',
	'CommentDelayInfo'			=> '新規ユーザーコメントの公開までの最小遅延（秒単位）。',
	'IntercomDelay'				=> '個人的なコミュニケーションの防水:',
	'IntercomDelayInfo'			=> 'プライベートメッセージの送信間の最小遅延（秒単位）',
	'RegistrationDelay'			=> '登録時間のしきい値:',
	'RegistrationDelayInfo'		=> '登録ボットを阻止するための登録フォーム送信間の最小時間閾値(秒単位)。',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'サイトの微調整を担当するパラメータのグループです。自分の行動に自信がない限り変更しないでください。',
	'FormatterSettingsUpdated'	=> '書式設定を更新しました',

	'TextHandlerSection'		=> 'Text Handler ',
	'Typografica'				=> '組版校正者:',
	'TypograficaInfo'			=> 'このオプションを無効にすると、コメントの追加とページの保存のプロセスが速くなります。',
	'Paragrafica'				=> 'パラグラフのマーキング:',
	'ParagraficaInfo'			=> '前のオプションと同様ですが、操作不能なコンテンツテーブル(<code>{{toc}}</code>)の切断につながります。',
	'AllowRawhtml'				=> 'グローバル HTML サポート:',
	'AllowRawhtmlInfo'			=> 'このオプションは、オープンサイトでは安全ではない可能性があります。',
	'SafeHtml'					=> 'HTMLのフィルタリング:',
	'SafeHtmlInfo'				=> '危険な HTML オブジェクトの保存を防止します。HTML をサポートするオープン サイトでフィルターをオフにすることは、<span class="underline">絶対に</span> 避けてください！',

	'WackoFormatterSection'		=> 'Wiki テキストフォーマット(Wacko Formatter)',
	'X11colors'					=> 'X11 カラー使用量:',
	'X11colorsInfo'				=> 'Extends the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code>Disabling this option speeds up the processes of adding comments and saving pages.',
	'WikiLinks'					=> 'Wiki リンクを無効にする:',
	'WikiLinksInfo'				=> '<code>CamelCaseWords</code>: CamelCase の単語が新しいページに直接リンクされなくなります。 これは、さまざまな名前空間/クラスターで作業する場合に便利です。デフォルトではオフになっています。',
	'BracketsLinks'				=> '括弧付きリンクを無効化:',
	'BracketsLinksInfo'			=> '<code>[[link]]</code> と <code>((リンク))</code> 構文を無効にします。',
	'Formatters'				=> '書式を無効にする:',
	'FormattersInfo'			=> '強調表示に使用される <code>%%code%%</code> 構文を無効にします。',

	'DateFormatsSection'		=> '日付の形式',
	'DateFormat'				=> '日付の書式：',
	'DateFormatInfo'			=> '(日、月、年)',
	'TimeFormat'				=> '時刻の形式:',
	'TimeFormatInfo'			=> '(時間、分)',
	'TimeFormatSeconds'			=> '正確な時刻の書式:',
	'TimeFormatSecondsInfo'		=> '(時間、分、秒)',
	'NameDateMacro'				=> '<code>::@::</code> マクロの書式:',
	'NameDateMacroInfo'			=> '(name, time), e.g. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'タイムゾーン:',
	'TimezoneInfo'				=> 'ログインしていないユーザーにタイムゾーンを表示するために使用するタイムゾーン(ゲスト) ログインしているユーザーは、ユーザー設定でタイムゾーンを変更できます。',
	'AmericanDate'					=> 'アメリカの日付:',
	'AmericanDateInfo'				=> 'アメリカの日付フォーマットを英語のデフォルトとして使用します。',

	'Canonical'					=> '完全正規の URL を使用:',
	'CanonicalInfo'				=> 'すべてのリンクは、 %1形式の絶対URLとして作成されます。 %2 形式のサーバールートからのURLが優先されます。',
	'LinkTarget'				=> '外部リンクが開いた場所:',
	'LinkTargetInfo'			=> '新しいブラウザウィンドウでそれぞれの外部リンクを開きます。リンク構文に <code>target="_blank"</code> を追加します。',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'ユーザーがハイパーリンクをたどった場合、ブラウザがHTTPリファラヘッダーを送信しないようにする必要があります。リンク構文に <code>rel="noreferrerer</code> を追加します。',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'ハイパーリンクは、検索エンジンインデックスのターゲットページのページランキングに影響を与えないように検索エンジンに指示します。 リンク構文に <code>rel="nofollow"</code> を追加します。',
	'UrlsUnderscores'			=> 'アンダースコア付きのアドレス（URL）をフォーム：',
	'UrlsUnderscoresInfo'		=> '例えば、 %1 はこのオプションで %2 になります。',
	'ShowSpaces'				=> 'WikiNamesにスペースを表示:',
	'ShowSpacesInfo'			=> 'WikiNames にスペースを表示します。例えば、 <code>MyName</code> が <code>My Name</code> としてこのオプションで表示されます。',
	'NumerateLinks'				=> '印刷ビュー内のリンクの列挙:',
	'NumerateLinksInfo'			=> 'このオプションを使用して、印刷ビューの下部にあるすべてのリンクを列挙して一覧表示します。',
	'YouareHereText'			=> '自己参照リンクを無効にして表示:',
	'YouareHereTextInfo'		=> '<code>&lt;b&gt;####&lt;/b&gt;</code>を使用して、同じページへのリンクを視覚化します。 自己へのすべてのリンクはリンク書式を失うが、太字のテキストとして表示されます。',

	// Pages settings
	'PagesSettingsInfo'			=> 'ここでは、Wiki内で使用されるシステムベースのページを設定・変更することができます。ここで設定した内容に応じて、Wiki内の対応するページを作成したり、変更したりすることを忘れないようにしてください。',
	'PagesSettingsUpdated'		=> '基本ページを更新しました',

	'ListCount'					=> 'リストあたりのアイテム数:',
	'ListCountInfo'				=> 'ゲストの各リストに表示されるアイテム数、新規ユーザーのデフォルト値として表示されるアイテム数。',

	'ForumSection'				=> 'オプションフォーラム',
	'ForumCluster'				=> 'Cluster forum:',
	'ForumClusterInfo'			=> 'フォーラムセクションのルートクラスター（アクション %1）。',
	'ForumTopics'				=> 'ページあたりのトピック数:',
	'ForumTopicsInfo'			=> 'フォーラムセクションの各ページに表示されるトピック数（アクション %1）です。',
	'CommentsCount'				=> 'ページあたりのコメント数:',
	'CommentsCountInfo'			=> '各ページのコメント一覧に表示されるコメント数です。 これは、フォーラムに投稿されたコメントだけでなく、サイト上のすべてのコメントに適用されます。',

	'NewsSection'				=> 'セクションニュース',
	'NewsCluster'				=> 'ニュースのクラスター:',
	'NewsClusterInfo'			=> 'ニュースセクションのルートクラスター（アクション %1）。',
	'NewsStructure'				=> 'ニュースクラスターの構造:',
	'NewsStructureInfo'			=> '任意で記事を年/月または週ごとにサブクラスターに保存します（例： <code>[cluster]/[year]/[month]</code>）。',

	'LicenseSection'			=> 'ライセンス',
	'DefaultLicense'			=> 'デフォルトのライセンス:',
	'DefaultLicenseInfo'		=> 'ライセンスの下で、コンテンツをリリースできます。',
	'EnableLicense'				=> 'ライセンスを有効にする:',
	'EnableLicenseInfo'			=> 'ライセンス情報を表示するために有効にします。',
	'LicensePerPage'			=> 'ページごとのライセンス:',
	'LicensePerPageInfo'		=> 'ページごとのライセンスを許可します。このライセンスは、ページの所有者がページ プロパティで選択できます。',

	'ServicePagesSection'		=> 'サービスページ',
	'RootPage'					=> 'ホームページ:',
	'RootPageInfo'				=> 'メインページのタグは、ユーザがサイトにアクセスしたときに自動的に開きます。',

	'PrivacyPage'				=> 'プライバシーポリシー:',
	'PrivacyPageInfo'			=> 'サイトのプライバシーポリシーのページ。',

	'TermsPage'					=> 'ポリシーと規制:',
	'TermsPageInfo'				=> 'サイトのルールのあるページ',

	'SearchPage'				=> '検索:',
	'SearchPageInfo'			=> 'ページの検索フォーム (アクション %1 ) です。',
	'RegistrationPage'			=> 'アカウント作成:',
	'RegistrationPageInfo'		=> '新規ユーザー登録ページ（アクション %1）',
	'LoginPage'					=> 'ユーザーログイン:',
	'LoginPageInfo'				=> 'サイトのログインページ (アクション %1)。',
	'SettingsPage'				=> 'ユーザー設定:',
	'SettingsPageInfo'			=> 'ユーザープロファイルをカスタマイズするためのページ (アクション %1)。',
	'PasswordPage'				=> 'パスワードの変更:',
	'PasswordPageInfo'			=> 'ユーザーパスワードを変更/クエリするためのフォーム付きのページ (アクション %1)。',
	'UsersPage'					=> 'ユーザーリスト:',
	'UsersPageInfo'				=> 'Page with a list of users (action %1).',
	'CategoryPage'				=> 'カテゴリー:',
	'CategoryPageInfo'			=> '分類されたページの一覧を持つページ (アクション %1)',
	'GroupsPage'				=> 'グループ:',
	'GroupsPageInfo'			=> '作業グループの一覧を持つページ (アクション %1)',
	'WhatsNewPage'				=> '新着情報:',
	'WhatsNewPageInfo'			=> '新規ページ、削除または変更されたページ、新しい添付ファイル、コメントの一覧が表示されます。 (アクション %1)。',
	'ChangesPage'				=> '最近の変更:',
	'ChangesPageInfo'			=> '最後に変更されたページの一覧を持つページ (アクション %1)。',
	'CommentsPage'				=> '最近のコメント:',
	'CommentsPageInfo'			=> 'Page with a list of recent comments on the page (action %1).',
	'RemovalsPage'				=> '削除されたページ：',
	'RemovalsPageInfo'			=> '最近削除されたページの一覧を持つページ (アクション %1)。',
	'WantedPage'				=> '募集ページ:',
	'WantedPageInfo'			=> '参照されている不足しているページの一覧を持つページ (アクション %1)。',
	'OrphanedPage'				=> '孤立したページ:',
	'OrphanedPageInfo'			=> '既存のページの一覧があるページは他のページへのリンクを介して関連付けられていません (アクション %1)。',
	'SandboxPage'				=> 'サンドボックス:',
	'SandboxPageInfo'			=> 'ページでは、ユーザは wiki マークアップのスキルを練習できます。',
	'HelpPage'					=> 'ヘルプ:',
	'HelpPageInfo'				=> 'サイトツールを使用するためのドキュメントセクション。',
	'IndexPage'					=> 'インデックス:',
	'IndexPageInfo'				=> 'すべてのページの一覧を持つページ (アクション %1)',
	'RandomPage'				=> 'ランダム:',
	'RandomPageInfo'			=> 'ランダムなページ (アクション %1 ) を読み込みます。',


	// Notification settings
	'NotificationSettingsInfo'	=> 'プラットフォームの通知のパラメータ',
	'NotificationSettingsUpdated'	=> '更新された通知設定',

	'EmailNotification'			=> 'メール通知：',
	'EmailNotificationInfo'		=> 'メール通知を許可します。メール通知を有効にするには有効にします。無効にするには無効にします。 メール通知を無効にすることは、ユーザー登録プロセスの一部として生成されたメールには影響しませんのでご注意ください。',
	'Autosubscribe'				=> '自動購読:',
	'AutosubscribeInfo'			=> 'ページ変更の所有者に自動的に通知します。',

	'NotificationSection'		=> 'デフォルトのユーザー通知設定',
	'NotifyPageEdit'			=> 'Notify page edit:',
	'NotifyPageEditInfo'		=> '保留中 - ユーザーが再度ページにアクセスするまで、最初の変更のみメール通知を送信します。',
	'NotifyMinorEdit'			=> 'マイナー編集通知:',
	'NotifyMinorEditInfo'		=> 'マイナーな編集のためにも通知を送信します。',
	'NotifyNewComment'			=> 'Notify new comment:',
	'NotifyNewCommentInfo'		=> '保留中 - ユーザーが再度ページにアクセスするまで、最初のコメントに対してのみ電子メール通知を送信します。',

	'NotifyUserAccount'			=> 'Notify new user account:',
	'NotifyUserAccountInfo'		=> '新しいユーザーが登録フォームを使用して作成されたときに管理者に通知されます。',
	'NotifyUpload'				=> 'Notify file upload:',
	'NotifyUploadInfo'			=> 'モデレータは、ファイルがアップロードされたときに通知されます。',

	'PersonalMessagesSection'	=> '個人メッセージ',
	'AllowIntercomDefault'		=> 'インターホンを許可:',
	'AllowIntercomDefaultInfo'	=> 'このオプションを有効にすると、他のユーザーは、アドレスを開示せずに受信者のメールアドレスに個人的なメッセージを送信できます。',
	'AllowMassemailDefault'		=> '大量のメールを許可:',
	'AllowMassemailDefaultInfo'	=> '管理者がそれらの情報を電子メールで送信できるようにしたユーザーにのみメッセージを送信します。',

	// Resync settings
	'Synchronize'				=> 'Synchronize',
	'UserStatsSynched'			=> 'ユーザー統計が同期されました。',
	'PageStatsSynched'			=> 'ページ統計を同期しました。',
	'FeedsUpdated'				=> 'RSSフィードを更新しました。',
	'SiteMapCreated'			=> 'サイトマップの新しいバージョンが正常に作成されました。',
	'ParseNextBatch'			=> '次のページを解析:',
	'WikiLinksRestored'			=> 'Wikiリンクを復元しました。',

	'LogUserStatsSynched'		=> '同期したユーザーの統計',
	'LogPageStatsSynched'		=> '同期されたページ統計',
	'LogFeedsUpdated'			=> '同期された RSS フィード',
	'LogPageBodySynched'		=> 'リパースされたページの本文とリンク',

	'UserStats'					=> 'ユーザーの統計',
	'UserStatsInfo'				=> 'ユーザー統計(コメント、所有ページ、リビジョン、ファイルの数)は、実際のデータと異なる場合があります。 <br>データベースに含まれる実際のデータに合わせて統計情報を更新することができます。',
	'PageStats'					=> 'ページの統計',
	'PageStatsInfo'				=> 'ページ統計(コメント、ファイル、リビジョンの数)が実際のデータと異なる場合があります。 <br>データベースに含まれる実際のデータに合わせて統計情報を更新することができます。',

	'AttachmentsInfo'			=> 'データベース内のすべての添付ファイルのファイルハッシュを更新します。',
	'AttachmentsSynched'		=> '添付ファイルをすべて再ハッシュ化',
	'LogAttachmentsSynched'		=> '添付ファイルをすべて再ハッシュ化',

	'Feeds'						=> 'フィード',
	'FeedsInfo'					=> 'データベース内のページを直接編集する場合、RSSフィードの内容は変更内容を反映していない可能性があります。 <br>この機能は、RSSチャンネルと現在のデータベースの状態を同期させます。',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'この関数は XML-Sitemap をデータベースの現在の状態と同期させます。',
	'XmlSiteMapPeriod'			=> '月経 %1 日、最終書き込み %2。',
	'XmlSiteMapView'			=> '新しいウィンドウにサイトマップを表示',

	'ReparseBody'				=> 'すべてのページを再解析します。',
	'ReparseBodyInfo'			=> 'ページテーブルに <code>body_r</code> を空にすると、各ページが次のページビューで再びレンダリングされます。 wikiのフォーマッタを変更したり、ドメインを変更したりした場合に便利です。',
	'PreparsedBodyPurged'		=> 'ページ テーブルの <code>body_r</code> フィールドを空にしました。',

	'WikiLinksResync'			=> 'Wikiリンク',
	'WikiLinksResyncInfo'		=> 'すべてのイントラサイトリンクに対して再レンダリングを実行し、損傷や再配置が発生した場合に、 <code>page_link</code> と <code>file_link</code> テーブルの内容を復元します(これはかなりの時間がかかる場合があります)。',
	'RecompilePage'				=> 'すべてのページを再コンパイルします (非常に費用がかかります)',
	'ResyncOptions'				=> '追加オプション',
	'RecompilePageLimit'		=> '一度に解析するページ数です。',

	// Email settings
	'EmaiSettingsInfo'			=> 'この情報は、エンジンがユーザーに電子メールを送信するときに使用されます。 指定したメールアドレスが有効であることを確認してください。バウンスまたは配信不能なメッセージがそのアドレスに送信される可能性があります。 ホスティングプロバイダがネイティブ(PHPベース)の電子メールサービスを提供していない場合は、代わりにSMTPを使用して直接メッセージを送信することができます。 これは、適切なサーバーのアドレスが必要です(必要に応じてホスティングプロバイダに問い合わせてください)。 サーバーが認証を必要とする場合(そして認証が必要な場合のみ)、必要なユーザー名、パスワード、および認証方法を入力します。',

	'EmailSettingsUpdated'		=> 'メール設定を更新しました',

	'EmailFunctionName'			=> 'メール機能名:',
	'EmailFunctionNameInfo'		=> 'PHP経由でメールを送信するために使用されるメール機能。',
	'UseSmtpInfo'				=> 'ローカル メール機能ではなく、名前付きサーバー経由で電子メールを送信する場合、または送信する必要がある場合は、<code>SMTP</code> を選択します。',

	'EnableEmail'				=> 'メールアドレスを有効にする:',
	'EnableEmailInfo'			=> 'メールの送信を有効にします。',

	'EmailIdentitySettings'		=> 'アイデンティティ',
	'FromEmailName'				=> '差出人名:',
	'FromEmailNameInfo'			=> 'サイトから送信されるすべての電子メール通知に対して、 <code>From:</code> ヘッダーに使用される送信者名。',
	'EmailSubjectPrefix'		=> '件名のプレフィックス：',
	'EmailSubjectPrefixInfo'	=> '例: <code>[Prefix] Topic</code>。定義されていない場合、接頭辞として長いサイト名 %1 が使用されます。',

	'NoReplyEmail'				=> '返信しないアドレス:',
	'NoReplyEmailInfo'			=> 'このアドレス、例えば、 <code>noreply@example.com</code>、サイトから送信されたすべての電子メール通知の <code>From:</code> 電子メールアドレスフィールドに表示されます。',
	'AdminEmail'				=> 'サイト所有者の電子メール:',
	'AdminEmailInfo'			=> 'このアドレスは、新しいユーザー通知などの管理目的で使用されます。',
	'AbuseEmail'				=> 'メールの不正使用サービス:',
	'AbuseEmailInfo'			=> '緊急の事態に対する住所請求:外国メールの登録などサイト所有者のメールアドレスと同じ場合があります。',

	'SendTestEmail'				=> 'テストメールを送信',
	'SendTestEmailInfo'			=> 'これにより、あなたのアカウントで定義されたアドレスにテストメールが送信されます。',
	'TestEmailSubject'			=> 'あなたのWikiはメールを送信するように正しく設定されています',
	'TestEmailBody'				=> 'このメールを受信した場合、Wiki はメールを送信するように正しく設定されています。',
	'TestEmailMessage'			=> 'テストメールが送信されました。<br>受信できない場合は、メールの設定を確認してください。',

	'SmtpSettings'				=> 'SMTP設定',
	'SmtpAutoTls'				=> '機会性のTLS:',
	'SmtpAutoTlsInfo'			=> 'サーバーが(サーバーに接続した後)TLS暗号化を宣伝していることがわかった場合、自動的に暗号化を有効にします。 接続モードを <code>SMTPSecure</code> に設定していない場合でも。',
	'SmtpConnectionMode'		=> 'SMTPの接続モード:',
	'SmtpConnectionModeInfo'	=> 'ユーザー名/パスワードが必要な場合にのみ使用されます。どの方法を使用するか不明な場合はプロバイダに確認してください。',
	'SmtpPassword'				=> 'SMTPパスワード:',
	'SmtpPasswordInfo'			=> 'SMTP サーバーで必要な場合のみ、パスワードを入力してください。<br><em><strong>警告:</strong> このパスワードはデータベースにプレーンテキストとして保存され、データベースにアクセスできるユーザーやこの構成ページを表示できるユーザー全員が閲覧できます。</em>',
	'SmtpPort'					=> 'SMTP サーバー ポート:',
	'SmtpPortInfo'				=> 'SMTP サーバーが別のポートにあることがわかっている場合にのみ、これを変更してください。 <br>(デフォルト: <code>tls</code> on port 587 (or may 25) and <code>ssl</code> on port 465).',
	'SmtpServer'				=> 'SMTPサーバーアドレス:',
	'SmtpServerInfo'			=> 'サーバーが使用するプロトコルを指定する必要があることに注意してください。SSL を使用している場合は、<code>ssl://mail.example.com</code> にする必要があります。',
	'SmtpUsername'				=> 'SMTPユーザー名:',
	'SmtpUsernameInfo'			=> 'SMTPサーバーが必要な場合にのみユーザー名を入力してください。',

	// Upload settings
	'UploadSettingsInfo'		=> 'ここでは、添付ファイルと関連する特殊カテゴリのメイン設定を構成できます。',
	'UploadSettingsUpdated'		=> 'アップロード設定を更新しました',

	'FileUploadsSection'		=> 'ファイルアップロード',
	'RegisteredUsers'			=> '登録ユーザ',
	'RightToUpload'				=> 'ファイルをアップロードする権限:',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belonging to the admins group can upload  files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadMaxFilesize'			=> '最大ファイルサイズ:',
	'UploadMaxFilesizeInfo'		=> '各ファイルの最大サイズ。この値が 0 の場合、アップロード可能な最大ファイルサイズは、PHP の設定によってのみ制限されます。',
	'UploadQuota'				=> '添付ファイルの容量の合計:',
	'UploadQuotaInfo'			=> 'Wiki全体の添付ファイルに利用可能な最大ドライブ領域。 <code>0 0</code> は無制限です。 %1 が使用されています。',
	'UploadQuotaUser'			=> 'ユーザーごとのストレージ容量:',
	'UploadQuotaUserInfo'		=> '<code>0</code> は無制限で、あるユーザーがアップロードできるストレージのクォータを制限します。',

	'FileTypes'					=> 'File types',
	'UploadOnlyImages'			=> '画像のアップロードのみを許可:',
	'UploadOnlyImagesInfo'		=> 'ページ上の画像ファイルのアップロードのみ許可します。',
	'AllowedUploadExts'			=> '許可されているファイル形式:',
	'AllowedUploadExtsInfo'		=> 'アップロードできるファイルの拡張子は、カンマ区切りで指定します（例：<code>png, ogg, mp4</code>, その他、禁止されていないファイル拡張子はすべて許可されます）。<br>アップロード可能なファイルの種類は、サイトのコンテンツ機能に必要な最小限のものに限定する必要があります。',
	'CheckMimetype'				=> 'チェックMIMEタイプ:',
	'CheckMimetypeInfo'			=> '一部のブラウザーは、アップロードされたファイルに対して不正な mimetype を想定するように騙されることがあります。このオプションは、これを引き起こす可能性の高いファイルが拒否されることを保証します。',
	'SvgSanitizer'				=> 'SVG Sanitizer:',
	'SvgSanitizerInfo'			=> 'アップロードされたSVGファイルをサニタイズし、SVG/XMLの脆弱なファイルがアップロードされないようにします。',
	'TranslitFileName'			=> 'ファイル名を音訳する：',
	'TranslitFileNameInfo'		=> 'Unicode文字を使用する必要がない場合は、英数字のみを使用することを強くお勧めします。',
	'TranslitCaseFolding'		=> 'ファイル名を小文字に変換します：',
	'TranslitCaseFoldingInfo'	=> 'このオプションはアクティブな音訳でのみ有効です。',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Create thumbnail:',
	'CreateThumbnailInfo'		=> 'あらゆる状況でサムネイルを作成します。',
	'ImageQuality'				=> '画像品質プリセット:',
	'ImageQualityInfo'			=> 'サムネイルの拡大時の画質。コーデックごとの値を選択し、同様の知覚結果を生成します。',
	'MaxImageArea'				=> 'Maximum Image Area:',
	'MaxImageAreaInfo'			=> '元画像の最大画素数。これは、画像スケーラの解凍側のメモリ使用量を制限するものです。<br><code>-1</code> は、スケーリングする前に画像の大きさを確認しないことを意味します。<code>0</code>は、自動的に値を決定することを意味します。',
	'MaxThumbWidth'				=> 'サムネイルの最大幅（ピクセル単位）',
	'MaxThumbWidthInfo'			=> '生成されたサムネイルはここで設定された幅を超えません。',
	'MinThumbFilesize'			=> 'サムネイルの最小サイズ:',
	'MinThumbFilesizeInfo'		=> 'これより小さい画像のサムネイルは作成しないでください。',
	'MaxImageWidth'				=> 'ページ上の画像サイズ制限：',
	'MaxImageWidthInfo'			=> 'ページ内で使用できる画像の最大幅を指定し、それ以外は縮小されたサムネイルが生成されます。',

	// Deleted module
	'DeletedObjectsInfo'		=> 'List of removed pages, revisions and files.
									Remove or restore the pages, revisions or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'あなたのWikiで自動的に検閲される単語。',
	'FilterSettingsUpdated'		=> 'スパムフィルターの設定を更新しました',

	'WordCensoringSection'		=> '単語センサリング',
	'SPAMFilter'				=> 'スパムフィルタ:',
	'SPAMFilterInfo'			=> 'スパムフィルタを有効にしています',
	'WordList'					=> '単語リスト:',
	'WordListInfo'				=> '単語またはフレーズ <code>フラグメント</code> がブラックリストに登録されます(1行に1つ)',

	// Log module
	'LogFilterTip'				=> '条件でイベントを絞り込みます:',
	'LogLevel'					=> 'レベル',
	'LogLevelFilters'	=> [
		'1'		=> '以下より小さく',
		'2'		=> '以下より大きい',
		'3'		=> '等しい',
	],
	'LogDate'					=> '日付',
	'LogEvent'					=> 'イベント',
	'LogUsername'				=> 'ユーザー名',
	'LogLevels'	=> [
		'1'		=> '決定的な',
		'2'		=> '最も高い',
		'3'		=> '高い',
		'4'		=> 'medium',
		'5'		=> '低い',
		'6'		=> '最も低い',
		'7'		=> 'デバッグ',
	],

	'LogCollapse'        => '折りたたみます',
	'LogExpand'          => '展開',
	'LogType'              => 'タイプ',
	'LogSearch'            => '検索',
	'LogSearchPlaceholder' => 'メッセージを検索...',
	'LogUserId'            => 'ユーザー ID',
	'LogExactMatch'        => '完全一致',
	'LogFrom'              => '差出人:',
	'LogTo'                => '終了日',
	'LogSupportKey'        => 'サポートキー',
	'LogContext'           => 'コンテキスト',
	'LogTarget'            => 'Target',
	'LogUserAgent'         => 'ユーザーエージェント',
	'LogReferer'           => 'リファラ',
	'LogTotal'             => '合計',
	'LogFilteredBy'        => 'によってフィルターされた',
	'LogClearFilter'       => 'フィルターをクリア',
	'LogActions'           => 'アクション',
	'LogDelete'            => '削除',
	'LogDeleteConfirm'     => 'このログエントリを削除しますか？',
	'LogDeleteSelected'    => '選択したものを削除',
	'LogBulkAction'        => '— 一括操作 —',
	'LogApply'             => '適用',
	'LogExportCSV'         => 'CSVエクスポート',
	'LogExportJSON'        => 'JSONをエクスポート',
	'LogPurged'            => 'ログテーブルを切り捨てました。',
	'LogPurgedFiltered'     => '%1 ログエントリがフィルターで削除されました。',
	'LogDeleted'           => 'ログエントリが削除されました。',
	'LogDeletedBulk'        => '%1 ログエントリを削除しました。',
	'LogPurgeSection'      => '破壊的な操作',
	'LogPurgeWarning'      => '現在のビューに一致する %1 エントリがあります。注意して使用してください。',
	'LogPurgeConfirm'      => 'ログエントリが完全に削除されることを理解しています',
	'LogPurgeFiltered'     => '一致するフィルターを削除',
	'LogPurgeFilteredConfirm' => '現在のフィルタに一致するすべてのエントリを削除しますか? これは元に戻すことはできません。',
	'LogPurgeAll'          => 'ログ全体を削除',
	'LogPurgeAllConfirm'   => 'データベース内のすべてのログエントリを削除しますか？元に戻すことはできません。',
	'LogFindRelated'       => '関連項目を検索',
	'LogNoMatch'           => '現在のフィルタに一致するログエントリはありません。',

	'LogMarkAll'                => 'このページのすべての行にマーク',
	'LogMarkNone'               => 'すべての行の標識を解除',
	'LogSelectRow'              => '行を選択',

	// Massemail module
	'MassemailInfo'				=> 'ここでは、(1)すべてのユーザーまたは(2)特定のグループのすべてのユーザーにメッセージを電子メールで送信することができます。 すべての受信者にBCC(盲検炭素コピー)を送信し、送信された管理者のメールアドレスにメールが送信されます。 デフォルトの設定では、このような電子メールには最大20人の受信者を含めることになります。 受信者が20人を超える場合は、追加のメールが送信されます。 大勢の人々にメールを送っている場合は、送信後に我慢してください。途中でページを止めないでください。 大量メールを送信するには時間がかかるのが普通です。スクリプトが完了すると通知されます。',
	'LogMassemail'				=> 'グループ/ユーザーに一括メール送信 %1 ',
	'MassemailSend'				=> '一括メール送信',

	'NoEmailMessage'			=> 'メッセージを入力する必要があります。',
	'NoEmailSubject'			=> 'メッセージの件名を指定する必要があります。',
	'NoEmailRecipient'			=> '少なくとも1つのユーザーまたはユーザーグループを指定する必要があります。',

	'MassemailSection'			=> '一括メール',
	'MessageSubject'			=> '件名:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'あなたのメッセージ:',
	'YourMessageInfo'			=> '平文のみを入力できることに注意してください。送信する前にすべてのマークアップが削除されます。',

	'NoUser'					=> 'ユーザーがいません',
	'NoUserGroup'				=> 'ユーザーグループがありません',

	'SendToGroup'				=> 'グループに送信:',
	'SendToUser'				=> 'ユーザーに送信:',
	'SendToUserInfo'			=> '管理者がそれらの情報を電子メールで送信できるユーザーのみが大量のメールを受信します。このオプションは、通知の下のユーザー設定で利用できます。',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> '更新されたシステムメッセージ',

	'SysMsgSection'				=> 'システムメッセージ',
	'SysMsg'					=> 'システムメッセージ:',
	'SysMsgInfo'				=> 'ここにあなたのテキスト',

	'SysMsgType'				=> 'タイプ:',
	'SysMsgTypeInfo'			=> 'メッセージタイプ(CSS)。',
	'SysMsgAudience'			=> '観客：',
	'SysMsgAudienceInfo'		=> 'システムメッセージの観客が表示されます。',
	'EnableSysMsg'				=> 'システムメッセージを有効にする:',
	'EnableSysMsgInfo'			=> 'システムメッセージを表示',

	// User approval module
	'ApproveNotExists'			=> 'セットボタンから少なくとも1人のユーザーを選択してください。',

	'LogUserApproved'			=> 'ユーザー ##%1## が承認されました',
	'LogUserBlocked'			=> 'ユーザー ##%1## がブロックされました',
	'LogUserDeleted'			=> 'ユーザー ##%1## がデータベースから削除されました',
	'LogUserCreated'			=> '新しいユーザー ##%1 ## を作成',
	'LogUserUpdated'			=> '更新されたユーザー ##%1##',
	'LogUserPasswordReset'		=> 'ユーザー ##%1## のパスワードが正常にリセットされました',

	'UserApproveInfo'			=> 'サイトにログインする前に新規ユーザーを承認します。',
	'Approve'					=> '承認',
	'Deny'						=> '拒否',
	'Pending'					=> '保留中',
	'Approved'					=> '承認済み',
	'Denied'					=> '拒否しました',

	// DB Backup module
	'BackupStructure'			=> '構成',
	'BackupData'				=> 'データ',
	'BackupFolder'				=> 'フォルダ',
	'BackupTable'				=> '表',
	'BackupCluster'				=> 'クラスター:',
	'BackupFiles'				=> 'ファイル',
	'BackupNote'				=> 'お知らせ:',
	'BackupSettings'			=> 'バックアップの必要なスキームを指定します。<br>' .
    	'ルートクラスターはグローバルファイルのバックアップとキャッシュファイルのバックアップには影響しません（選択した場合は常に完全に保存されます）。<br>' .  '<br>' .
		'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster, the tables from this backup will not be restructured, same as when backing up only table structure without saving the data. To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'バックアップとアーカイブが完了しました。<br>' .
    	'The Backup package files were stored in the sub-directory %1.<br>To download it use FTP (maintain the directory structure and file names when copying).<br> To restore a backup copy or remove a package, go to <a href="%2">Restore database</a>.',
	'LogSavedBackup'			=> '保存されたバックアップ データベース ##%1##',
	'Backup'					=> 'バックアップ',
	'CantReadFile'				=> 'ファイル %1を読み取ることができません。',

	// DB Restore module
	'RestoreInfo'				=> '見つかったバックアップパッケージを復元するか、サーバーから削除することができます。',
	'ConfirmDbRestore'			=> 'バックアップ %1を復元しますか？',
	'ConfirmDbRestoreInfo'		=> 'しばらくお待ちください。時間がかかることがあります。',
	'RestoreWrongVersion'		=> 'WackoWikiのバージョンが間違っています！',
	'DirectoryNotExecutable'	=> '%1 ディレクトリは実行できません。',
	'BackupDelete'				=> 'バックアップ %1を削除してもよろしいですか？',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> '追加の復元オプション:',
	'RestoreOptionsInfo'		=> '* <strong>クラスタバックアップ</strong>を復元する前に ' .
									'ターゲットテーブルは削除されません(バックアップされていないクラスタからの情報の損失を防ぐため)。 ' .
									'したがって、回復プロセス中に重複レコードが発生します。 ' .
									'通常モードでは、すべてのレコードフォームのバックアップ (SQL <code>REPLACE</code>を使用) に置き換えられます。 ' .
									'しかし、このチェックボックスにチェックが入っている場合、すべての重複はスキップされます(現在のレコードの値は保持されます)。 ' .
									'新しいキーを持つレコードのみがテーブルに追加されます(SQL <code>INSERT IGNORE</code>)。<br>' .
									'<strong>注意事項</strong>: サイトの完全なバックアップを復元すると、このオプションに値がありません。<br>' .
									'<br>' .
									'** バックアップにユーザーファイルが含まれている場合 (グローバルおよびperpage、キャッシュファイルなど) ' .
									'通常モードでは、既存のファイルを同じ名前で置き換え、復元時に同じディレクトリに配置されます。 ' .
									'このオプションを使用すると、現在のファイルのコピーを保存し、バックアップからのみ新しいファイルのみを復元することができます(サーバー上に欠落)。',
	'IgnoreDuplicatedKeysNr'	=> '重複したテーブルキーを無視（置換ではありません）',
	'IgnoreSameFiles'			=> '同じファイルを無視（上書き不可）',
	'NoBackupsAvailable'		=> '利用可能なバックアップはありません。',
	'BackupEntireSite'			=> 'サイト全体',
	'BackupRestored'			=> 'バックアップが復元され、サマリーレポートが以下に添付されています。このバックアップパッケージを削除するには、',
	'BackupRemoved'				=> '選択したバックアップが正常に削除されました。',
	'LogRemovedBackup'			=> 'データベースのバックアップ ##%1 ## を削除しました',

	'DbEngineInvalid'			=> '無効なデータベースエンジンです。 %1 を期待しています',
	'RestoreStarted'			=> '復元を開始',
	'RestoreParameters'			=> 'パラメータの使用',
	'IgnoreDuplicatedKeys'		=> '重複キーを無視',
	'IgnoreDuplicatedFiles'		=> '重複したファイルを無視',
	'SavedCluster'				=> '保存されたクラスター',
	'DataProtection'			=> 'データ保護 - %1 は省略されました',
	'AssumeDropTable'			=> '%1 と仮定する',
	'RestoreSQLiteDatabase'		=> 'SQLiteデータベースの復元',
	'SQLiteDatabaseRestored'	=> 'データベースが正常に復元されました:',
	'RestoreTableStructure'		=> 'テーブルの構造を復元する',
	'RunSqlQueries'				=> 'SQL命令を実行:',
	'CompletedSqlQueries'		=> '完了しました。処理済みの手順:',
	'NoTableStructure'			=> 'テーブルの構造は保存されませんでした - スキップ',
	'RestoreRecords'			=> 'テーブルの内容を復元します',
	'ProcessTablesDump'			=> 'テーブルダンプをダウンロードして処理する',
	'Instruction'				=> '説明',
	'RestoredRecords'			=> 'レコード:',
	'RecordsRestoreDone'		=> '完了しました。合計エントリ数:',
	'SkippedRecords'			=> 'データは保存されていません - スキップ',
	'RestoringFiles'			=> 'ファイルの復元中',
	'DecompressAndStore'		=> 'ディレクトリの内容を解凍して保存します',
	'HomonymicFiles'			=> '同義語ファイル',
	'RestoreSkip'				=> 'スキップ',
	'RestoreReplace'			=> '置換',
	'RestoreFile'				=> 'ファイル:',
	'RestoredFiles'				=> 'リストア:',
	'SkippedFiles'				=> 'スキップ:',
	'FileRestoreDone'			=> '完了しました。ファイルの合計:',
	'FilesAll'					=> 'すべて:',
	'SkipFiles'					=> 'ファイルは保存されません - スキップ',
	'RestoreDone'				=> '復元完了',

	'BackupCreationDate'		=> '作成日',
	'BackupPackageContents'		=> 'パッケージの内容',
	'BackupRestore'				=> '復元',
	'BackupRemove'				=> '削除',
	'RestoreYes'				=> 'はい',
	'RestoreNo'					=> 'いいえ',
	'LogDbRestored'				=> 'データベースのバックアップ ##%1## が復元されました。',

	'BackupArchived'			=> 'バックアップ %1 がアーカイブされました。',
	'BackupArchiveExists'		=> 'バックアップ・アーカイブ %1 は既に存在します。',
	'LogBackupArchived'			=> 'バックアップ ##%1## がアーカイブされました。',

	// User module
	'UsersInfo'					=> 'ここでは、ユーザー情報と特定のオプションを変更できます。',

	'UsersAdded'				=> 'ユーザーを追加しました',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> '編集',
	'UsersAddNew'				=> '新しいユーザーを追加',
	'UsersDelete'				=> 'ユーザー %1 を削除してもよろしいですか？',
	'UsersDeleted'				=> 'ユーザー %1 がデータベースから削除されました。',
	'UsersRename'				=> 'ユーザー %1 の名前を変更',
	'UsersRenameInfo'			=> '* 注意: 変更は、そのユーザーに割り当てられているすべてのページに影響します。',
	'UsersUpdated'				=> 'ユーザーが正常に更新されました。',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'サインアップ時間',
	'UserActions'				=> 'アクション',
	'NoMatchingUser'			=> '条件を満たすユーザーはいません。',

	'UserAccountNotify'			=> 'ユーザーに通知',
	'UserNotifySignup'			=> '新しいアカウントについてユーザーに知らせてください',
	'UserVerifyEmail'			=> 'メール確認トークンを設定し、メール確認用のリンクを追加する',
	'UserReVerifyEmail'			=> 'トークンの確認メールを再送信する',

	// Groups module
	'GroupsInfo'				=> 'このパネルから、すべてのユーザグループを管理できます。既存のグループを削除、作成、編集できます。 さらに、グループリーダーを選択し、open/hidden/closed/closedグループステータスを切り替え、グループ名と説明を設定できます。',

	'LogMembersUpdated'			=> 'ユーザーグループのメンバーを更新しました',
	'LogMemberAdded'			=> 'グループ ##%1#にメンバー ##%2 ## を追加しました ##',
	'LogMemberRemoved'			=> 'グループ ##%1## からメンバー ##%2 ## を削除しました ##',
	'LogGroupCreated'			=> '新しいグループ ##%1 ## を作成しました',
	'LogGroupRenamed'			=> 'グループ ##%1## の名前を ##%2 ## に変更しました ##',
	'LogGroupRemoved'			=> 'グループ ##%1 ## を削除しました',

	'GroupsMembersFor'			=> 'Members for Group',
	'GroupsDescription'			=> '説明',
	'GroupsModerator'			=> 'モデレータ',
	'GroupsOpen'				=> '開く',
	'GroupsActive'				=> 'アクティブ',
	'GroupsTip'					=> 'クリックしてグループを編集',
	'GroupsUpdated'				=> 'グループが更新されました',
	'GroupsAlreadyExists'		=> 'このグループは既に存在します。',
	'GroupsAdded'				=> 'グループが追加されました。',
	'GroupsRenamed'				=> 'グループの名前を変更しました。',
	'GroupsDeleted'				=> 'グループ %1 と関連するすべてのページがデータベースから削除されました。',
	'GroupsAdd'					=> '新しいグループを追加',
	'GroupsRename'				=> 'グループ %1 の名前を変更',
	'GroupsRenameInfo'			=> '* 注意: 変更は、そのグループに割り当てられているすべてのページに影響します。',
	'GroupsDelete'				=> 'グループ %1を削除してもよろしいですか？',
	'GroupsDeleteInfo'			=> '* 注意: 変更は、そのグループに割り当てられているすべてのメンバーに影響します。',
	'GroupsIsSystem'			=> 'グループ %1 はシステムに属しているため、削除できません。',
	'GroupsStoreButton'			=> 'グループを保存',
	'GroupsEditInfo'			=> 'グループリストを編集するには、ラジオボタンを選択します。',

	'GroupAddMember'			=> 'メンバーを追加',
	'GroupRemoveMember'			=> 'メンバーを削除',
	'GroupAddNew'				=> 'グループを追加',
	'GroupEdit'					=> 'グループを編集',
	'GroupDelete'				=> 'グループを削除',

	'MembersAddNew'				=> '新しいメンバーを追加',
	'MembersAdded'				=> 'グループに新しいメンバーを追加しました。',
	'MembersRemove'				=> 'メンバー %1を削除してもよろしいですか？',
	'MembersRemoved'			=> 'メンバーがグループから削除されました。',

	// Statistics module
	'DbStatSection'				=> 'データベースの統計',
	'DbTable'					=> '表',
	'DbRecords'					=> 'レコード',
	'DbSize'					=> 'サイズ',
	'DbIndex'					=> '目次と索引',
	'DbTotal'					=> '合計',

	'FileStatSection'			=> 'ファイルシステムの統計情報',
	'FileFolder'				=> 'フォルダ',
	'FileFiles'					=> 'ファイル',
	'FileSize'					=> 'サイズ',
	'FileTotal'					=> '合計',

	// Sysinfo module
	'SysInfo'					=> 'バージョン情報:',
	'SysParameter'				=> 'パラメータ',
	'SysValues'					=> '値',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> '最終更新',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'サーバー名',
	'WebServer'					=> 'Webサーバー',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'データベース',
	'SqlModesGlobal'			=> 'SQL モード グローバル',
	'SqlModesSession'			=> 'SQL モードセッション',
	'IcuVersion'				=> '国際基督教大学(ICU)',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'メモリ',
	'UploadFilesizeMax'			=> '最大ファイルサイズをアップロード',
	'PostMaxSize'				=> '投稿の最大サイズ',
	'MaxExecutionTime'			=> '最大実行時間',
	'SessionPath'				=> 'セッションパス',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip 圧縮',
	'PhpExtensions'				=> 'PHP extensions',
	'ApacheModules'				=> 'Apache モジュール',

	// DB repair module
	'DbRepairSection'			=> 'データベースの修復',
	'DbRepair'					=> 'データベースの修復',
	'DbRepairInfo'				=> 'このスクリプトは一般的なデータベースの問題を自動的に探して修復します。修復には時間がかかる場合がありますので、しばらくお待ちください。',

	'DbOptimizeRepairSection'	=> 'データベースの修復と最適化',
	'DbOptimizeRepair'			=> 'データベースの修復と最適化',
	'DbOptimizeRepairInfo'		=> 'このスクリプトは、データベースの最適化を試みることもできます。これにより、場合によってはパフォーマンスが向上します。 データベースの修復と最適化には時間がかかり、最適化中にデータベースがロックされます。',

	'TableOk'					=> '%1 テーブルは問題ありません。',
	'TableNotOk'				=> '%1 テーブルが正常ではありません。次のエラーを報告しています: %2. このスクリプトは、このテーブル&hellip; を修復しようとします。',
	'TableRepaired'				=> '%1 テーブルの修理に成功しました。',
	'TableRepairFailed'			=> 'Failed to repair the %1 table. <br>Error: %2',
	'TableAlreadyOptimized'		=> '%1 テーブルはすでに最適化されています。',
	'TableOptimized'			=> '%1 テーブルの最適化に成功しました。',
	'TableOptimizeFailed'		=> '%1 テーブルの最適化に失敗しました。 <br>エラー: %2',
	'TableNotRepaired'			=> '一部のデータベースの問題を修復できませんでした。',
	'RepairsComplete'			=> '修理完了',

	// Inconsistencies module
	'InconsistenciesInfo'		=> '新しいユーザー / 値に、孤立したレコードを表示、削除、または割り当てる不整合を修正します。',
	'Inconsistencies'			=> '不整合性',
	'CheckDatabase'				=> 'データベース',
	'CheckDatabaseInfo'			=> 'データベース内のレコードの矛盾をチェックします。',
	'CheckFiles'				=> 'ファイル',
	'CheckFilesInfo'			=> 'ファイルテーブルに参照が残っていない、放棄されたファイルをチェックします。',
	'Records'					=> 'レコード',
	'InconsistenciesNone'		=> 'データの矛盾が見つかりませんでした。',
	'InconsistenciesDone'		=> 'データの不整合を解決しました。',
	'InconsistenciesRemoved'	=> '矛盾を削除しました',
	'Check'						=> 'チェック',
	'Solve'						=> '解決',

	// Bad Behaviour module
	'BbInfo'					=> '不要なウェブアクセスを検出してブロックしたり、スパムボットの自動アクセスを拒否したりします。<br>詳細については、 %1 ホームページをご覧ください。',
	'BbEnable'					=> '不正な動作を有効にする:',
	'BbEnableInfo'				=> '設定フォルダ %1でその他の設定を変更することができます。',
	'BbStats'					=> '不正な動作により、過去7日間に %1 のアクセス試行がブロックされました。',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'ログ',
	'BbSettings'				=> '設定',
	'BbWhitelist'				=> 'ホワイトリスト',

	// --> Log
	'BbHits'					=> '閲覧数',
	'BbRecordsFiltered'			=> 'フィルタリングされた %1 レコードの %2 を表示',
	'BbStatus'					=> 'ステータス',
	'BbBlocked'					=> 'ブロック',
	'BbPermitted'				=> '許可',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'すべての %1 レコードを表示',
	'BbShow'					=> '表示',
	'BbIpDateStatus'			=> 'IP/Date/Status',
	'BbHeaders'					=> 'ヘッダー',
	'BbEntity'					=> 'エンティティ',

	'BbSearchPlaceholder'        => 'UA、URI、IP、ホスト、support_key、ステータス…',
	'BbFilterAnyCategory'        => 'すべてのカテゴリ',
	'BbFilterAnyMethod'          => '任意のメソッド',
	'BbFilterAnyStatus'          => '任意のステータス',
	'BbFilterBlockedOnly'        => 'ブロックされている',
	'BbFilterPermittedOnly'      => '許可のみ',
	'BbFilterApply'              => '適用',
	'BbFilterClear'              => 'フィルターをクリア',
	'BbChipSearch'               => '検索',
	'BbChipCategory'             => 'カテゴリ',
	'BbChipMethod'               => '方法',
	'BbChipStatus'               => 'ステータス',
	'BbChipRemove'               => 'このフィルターを削除',
	'BbFilterByCategory'         => 'このカテゴリでフィルター',
	'BbSearchBySupportKey'       => 'このサポートキーを検索',

	// === Check flag (operator-marked records, exempt from autodelete) ===
	'BbFilterAnyCheck'         => 'すべてのチェックステータス',
	'BbFilterCheckedOnly'      => 'チェック済みのみ',
	'BbFilterUncheckedOnly'    => '未チェックのみ',
	'BbChipCheck'              => 'ステータスの確認',
	'BbChecked'                => 'checked',
	'BbUnchecked'              => '未チェック',
	'BbActionCheck'            => 'チェック',
	'BbActionUncheck'          => 'チェックを外す',
	'BbRowChecked'             => 'ログエントリをチェック済みにする',
	'BbRowUnchecked'           => 'ログエントリがチェックされていません',
	'BbRowCheckedHint'         => 'このレコードはチェックされています — 自動クリーンアップは免除されます',
	'BbRowUncheckedHint'       => 'このレコードを自動クリーンアップで保持するには、このレコードをマークします',
	'BbBulkCheckSelected'      => 'チェック済みにする',
	'BbBulkUncheckSelected'    => 'チェックを解除',
	'BbBulkChecked'            => '%1 項目をチェック済みにする',
	'BbBulkUnchecked'          => '%1 エントリのマークを外しました',

	// --> Whitelist
	'BbOptionsSaved'			=> 'オプションを保存しました。',
	'BbWhitelistHint'			=> '不適切なホワイトリスト作成はあなたをスパムにさらしたり、悪い行動が完全に機能しなくなったりします！ あなたがするべきである100%CERTAINでない限り、しないでください。',
	'BbIpAddress'				=> 'IP アドレス',
	'BbIpAddressInfo'			=> 'IPアドレスまたはCIDR形式のアドレス範囲をホワイトリストに登録する(1行に1つ)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URLフラグメントは、ウェブサイトのホスト名の後に / で始まります(1行に1つ)',
	'BbUserAgent'				=> 'ユーザーエージェント',
	'BbUserAgentInfo'			=> 'ホワイトリストに登録するユーザーエージェントの文字列 (1行に1つ)',

	// --> Settings
	'BbSettingsUpdated'			=> '更新された不正な動作設定',
	'BbLogRequest'				=> 'HTTPリクエストのログ',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> '通常（推奨）',
	'BbLogOff'					=> 'ログを記録しない (非推奨)',
	'BbSecurity'				=> 'セキュリティ',
	'BbStrict'					=> '厳密なチェック',
	'BbStrictInfo'				=> '他のスパムをブロックしますが、ブロックする人もいるかもしれません。',
	'BbOffsiteForms'			=> '他のウェブサイトからのフォーム投稿を許可する',
	'BbOffsiteFormsInfo'		=> 'OpenIDに必須; スパム受信を増加させる',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> '不正な動作 http:BL 機能を使用するには、 %1 が必要です',
	'BbHttpblKey'				=> 'http:BL アクセスキー',
	'BbHttpblThreat'			=> '最小脅威レベル（25を推奨）',
	'BbHttpblMaxage'			=> 'データの最大年齢 (30 を推奨)',
	'BbReverseProxy'			=> 'プロキシ/ロードバランサー',
	'BbReverseProxyInfo'		=> 'リバースプロキシ、ロードバランサ、HTTPアクセラレータ、コンテンツキャッシュなどのテクノロジーの背後でBad Behaviourを使用している場合は、Reverse Proxy オプションを有効にしてください。<br>' .
									'If you have a chain of two or more reverse proxies between your server and the public Internet, you must specify <em>all</em> of the IP address ranges (in CIDR format) of all of your proxy servers, load balancers, etc. Otherwise, Bad Behaviour may be unable to determine the client\'s true IP address.<br>' .
									'In addition, your reverse proxy servers must set the IP address of the Internet client from which they received the request in an HTTP header. If you don\'t specify a header, %1 will be used. Most proxy servers already support X-Forwarded-For and you would then only need to ensure that it is enabled on your proxy servers. Some other header names in common use include %2 and %3.',
	'BbReverseProxyEnable'		=> 'リバースプロキシを有効にする',
	'BbReverseProxyHeader'		=> 'インターネットクライアントのIPアドレスを含むヘッダー',
	'BbReverseProxyAddresses'	=> 'あなたのプロキシサーバーのIPアドレスまたはCIDRフォーマットアドレスの範囲（1行に1つ）',

	'BbBehavioral'           => '行動分析',
	'BbEnableBehavioral'     => '行動分析を有効にします（速度異常、UA/IP回転）',
	'BbEnableBehavioralInfo' => 'セッションごとのリクエストパターンを追跡します。有効にしても安全です。',
	'BbEnableFingerprinting' => 'TLS/HTTP/2 フィンガープリンティングを有効にする (JA3, H2, ヘッダ順)',
	'BbEnableFingerprintingInfo' => '不正なフィンガープリントのみをブロックします。enable_fingering=trueが必要です。古いブラウザ/プロキシで誤検出を引き起こす可能性があります。',
	'BbInspectJson'          => 'JSONリクエストボディの攻撃を調査する',
	'BbInspectJsonInfo'      => '警告：AJAX/JSONのAPI（wikiマークアップ、コードスニペットは誤陽性を引き起こします）を中断します。オフにしてください。',
	'BbInspectMultipart'     => '攻撃のマルチパート/フォームデータボディを調査',
	'BbInspectMultipartInfo' => '警告: ファイルのアップロードを中断します。オフにしてください。',

	'BbEnableClientHints'      => 'クライアントヒントの検証を有効にする',
	'BbEnableClientHintsInfo'  => 'なりすましブラウザ(Chrome 89以上)を検出するために、User-Agent に対してSec-CH-UAヘッダーを検証します。',
	'BbEnableAgentic'          => 'Agentically Behavior Detection を有効にする',
	'BbEnableAgenticInfo'      => 'AIエージェントパターンの検出:think-cell、ノンリニアナビゲーション、精密ターゲティング。',
	'BbStrictSearchEngines'    => '厳密な検索',
	'BbStrictSearchEnginesInfo' => '検証されていない検索エンジンのボット(Googlebot、Bingbot、 …)に厳格なチェックを適用します。',
	'BbEnableDynamicIp'        => '動的IP範囲取得を有効にする',
	'BbEnableDynamicIpInfo'    => 'Google、Bing、OpenAI、Anthropic、Appleなどの公式IP範囲を取得してください(24時間、古いフォールバック7日間)。',

	'BbAiCrawlers'           => 'AIクローラーコントロール',
	'BbBlockUnverifiedAi'    => '未検証AIクローラーをブロック',
	'BbBlockUnverifiedAiInfo' => 'DNS/IP検証に失敗したAIクローラーをブロック (なりすましボット)。',
	'BbStrictAi'             => '厳格なAIモード（許可されていないAIもブロック）',
	'BbStrictAiInfo'         => '許可されたリストにないすべてのAIクローラーをブロックします。',
	'BbAllowedAiCrawlers'    => '許可されたAIクローラトークン（1行に1つ）',
	'BbAllowedAiCrawlersInfo' => 'トークン: GPTBot, ClaudeBot, Google拡張, PerplexityBot, Meta-ExternalAgent, Applebot-Extended, CCBot, ia_archver',

	'BbDnsbl'                => 'DNSBL / http:BL',
	'BbDnsblEnabled'         => 'DNSBLチェックを有効にする',
	'BbDnsblLists'           => 'DNSBLリスト (1行に1つ)',
	'BbDnsblListsInfo'       => 'Default: zen.spamhaus.org, bl.spamcop.net',

	'BbRateLimits'           => 'レート制限',
	'BbRateLimitEnabled'     => 'レート制限を有効にする',
	'BbRateGlobalRequests'   => 'ウィンドウごとのグローバルリクエスト',
	'BbRateGlobalWindow'     => 'グローバルウィンドウ (秒)',
	'BbRatePerMinuteRequests'=> '毎分ごとのリクエスト',
	'BbRatePerMinuteWindow'  => '分単位ウィンドウ (秒)',
	'BbRatePostRequests'     => 'ウィンドウごとのPOSTリクエスト',
	'BbRatePostWindow'       => 'POST ウィンドウ (秒)',
	'BbRateLoginRequests'    => 'ウィンドウごとのログインリクエスト',
	'BbRateLoginWindow'      => 'ログインウィンドウ (秒)',

	'BbChallenge'            => 'チャレンジシステム',
	'BbChallengeEnabled'     => 'チャレンジを有効にする',
	'BbChallengeProvider'    => 'チャレンジプロバイダー',
	'BbChallengeSiteKey'     => 'サイトキー',
	'BbChallengeSecretKey'   => 'シークレットキー',
	'BbRecaptchaMinScore'    => 'reCAPTCHA v3 分スコア',

	'BbPerformance'          => 'パフォーマンス',
	'BbSkipExtensions'       => '拡張子をスキップ(1行に1つ)',
	'BbSkipPaths'            => 'パスプレフィックスをスキップ (1行に1つ)',

	'BbGeoip'                => 'GeoIP / ASNブロック',
	'BbGeoipEnabled'         => 'GeoIP検索を有効にする',
	'BbGeoipDbPath'          => 'MaxMind DB path',
	'BbBlockedCountries'     => 'ブロックされた国 (ISOコード、1行に1つ)',
	'BbBlockedAsns'          => 'ブロックされたASN (1行に1つ)',

	'BbBlockPage'                  => 'ブロックページ',
	'BbShowDetailedBlockPage'      => '詳細なブロックページを表示',
	'BbShowDetailedBlockPageInfo'  => 'ブロックページに理由、リクエスト URI 、テクニカルサポートキーを表示します。本番環境におすすめです。',
	'BbShowContactInfo'            => 'ブロックページに連絡先情報を表示',
	'BbShowContactInfoInfo'        => 'ブロックページに管理者のメールを表示します（詳細ブロックページが有効な場合のみ有効）。',
	'BbSettingsSaveFailed'         => '不正なビヘイビア設定の保存に失敗しました',

	// === Basic section ===
	'BbBasicSection'      => '基本設定',
	'BbAdvancedSection'   => '詳細設定',
	'BbAdvancedHint'      => 'ほとんどの演算子はこれらを変更する必要はありません。',

	// === Basic knobs ===
	'BbPreset'            => 'Bot preset',
	'BbPresetInfo'        => 'どのボットを認識するか。「最小」(デフォルト)が最も速く、「いっぱい」が最も徹底しています。',
	'BbStrictness'        => 'ブロックの状況',
	'BbStrictnessInfo'    => 'モニターのみのログですが、何もブロックしません。通常のブロックは攻撃者を検証しました。厳格なブロックは攻撃的です。',
	'BbLoggingMode'       => 'ログ',
	'BbLoggingModeInfo'   => '通常（推奨）、冗長（リクエストごとにログ）、オフ',
	'BbLogModeNormal'     => '標準',
	'BbLogModeVerbose'    => 'Verbose',
	'BbLogModeOff'        => 'オフ',
	'BbBehindProxy'       => 'サイトはリバースプロキシまたは CDN の背後にあります。',
	'BbBehindProxyInfo'   => 'Cloudflare、AWS、GCP、Fastlyなどの背後にある場合に有効にします。プロキシIP範囲を高度に追加する必要があります。',

	// === Advanced section headers ===
	'BbAdvCore'           => 'コア',
	'BbAdvReverseProxy'   => 'リバースプロキシ',
	'BbAdvAiCrawlers'     => 'AIクローラー',
	'BbAdvBotCategories'  => 'ボットカテゴリ',
	'BbAdvDnsVerification'=> 'DNS 認証',
	'BbAdvRateLimits'     => 'レート制限',
	'BbAdvHeadDetection'  => 'ヘッドリクエストの検出',
	'BbAdvAssetScraping'  => 'アセットスクラップ検出',
	'BbAdvDynamicIp'      => '動的IP範囲',
	'BbAdvOnDemandRefresh'=> 'オンデマンド IP 更新',
	'BbAdvHttpbl'         => 'プロジェクト Honeypot http:BL',
	'BbAdvDnsbl'          => 'DNSBL',
	'BbAdvChallenge'      => 'チャレンジ/CAPTCHA',
	'BbAdvPerformance'    => 'パフォーマンス',
	'BbAdvGeoip'          => 'GeoIP / ASNブロック',
	'BbAdvFingerprints'   => 'TLS / HTTP/2 フィンガープリント',
	'BbAdvCustomRules'    => 'カスタムルール',
	'BbAdvBlockPage'      => 'ブロックページ',

	// === bot category labels (multi-checkbox) ===
	'BbCatSearchEngine'   => 'Search Engine',
	'BbCatAiCrawler'      => 'AI Crawler',
	'BbCatSocialCrawler'  => 'ソーシャルクローラー',
	'BbCatSeoCrawler'     => 'SEOクローラー',
	'BbCatArchiveCrawler' => 'クローラーをアーカイブ',
	'BbCatMonitoring'     => 'モニタリング',
	'BbCatFeedReader'     => 'フィードリーダー',
	'BbCatShoppingCrawler'=> '買い物用クローラー',
	'BbCatCloudInfra'     => 'クラウドインフラストラクチャ',
	'BbCatSecurityScanner'=> 'セキュリティスキャナ',
	'BbCatResidentialProxy'=> 'レジデンシャルプロキシ',
	'BbCatMalicious'      => '悪意のある',
	'BbCatUnknown'        => '不明',

	// === on_demand_ip_refresh cloud providers ===
	'BbCloudProviderAws'        => 'AWS',
	'BbCloudProviderCloudflare' => 'Cloudflare',
	'BbCloudProviderFastly'     => 'Fastly',
	'BbCloudProviderGcp'        => 'Google Cloud',
	'BbCloudProvidersInfo'      => 'オンデマンドの更新を特定のプロバイダに制限します。空の場合はすべて4つです。',

	// === Log retention ===
	'BbAdvLogRetention'              => 'ログの保持',
	'BbLogRetentionEnabled'          => '自動ログのクリーンアップを有効にする',
	'BbLogRetentionEnabledInfo'      => '保存ウィンドウよりも古いログ行を定期的に削除します。cronアクセスのないサイトに推奨します。',
	'BbLogRetentionMaxAgeDays'       => '保持ウィンドウ（日）',
	'BbLogRetentionMaxAgeDaysInfo'   => 'デフォルト: 7. 一般的な値: 7, 14, 30, 90.',
	'BbLogRetentionMaxRows'          => '最大行数 (0 = 上限なし)',
	'BbLogRetentionMaxRowsInfo'      => '設定されている場合、年齢に関係なく、テーブルがこのサイズを超えるたびに最も古い行が削除されます。高トラフィックサイトに便利です。',
	'BbLogRetentionProbability'       => '確率分母（1 in N）',
	'BbLogRetentionProbabilityInfo'   => '1 in N requests checkes the staleness gate. Higher = less DB load. Default: 1000',
	'BbLogRetentionMinInterval'      => 'クリーンアップ間隔の最小値 (秒)',
	'BbLogRetentionMinIntervalInfo'  => 'クリーンアップ周波数のハードフロア. デフォルト: 21600 (6h).',
	'BbLogRetentionLockTtl'          => 'ロック TTL をクリーンアップ(秒)',
	'BbLogRetentionLockTtlInfo'      => 'クリーンアップの mutex が保持されている期間。デフォルト: 600 (10 min)',

	// === misc new fields ===
	'BbDnsVerificationEnabled'  => 'DNS認証を有効にする',
	'BbDnsVerificationInfo'     => '逆DNSルックアップによりボットの要求（Googlebotなど）を確認します。詐欺ボットをキャッチします。',
	'BbDnsTimeoutMs'            => 'DNS ルックアップタイムアウト (ミリ秒)',
	'BbDnsPositiveTtl'          => '正のキャッシュ TTL (秒)',
	'BbDnsNegativeTtl'          => '負のキャッシュ TTL (秒)',
	'BbDnsRequireForward'       => '転送確認が必要 (PTR + レコード一致)',
	'BbDnsRequireForwardInfo'   => 'PTRスプーフィングをキャッチしますが、レイテンシとIPv6 FPリスクが追加されます。',

	'BbHeadRefererExemptPaths'  => '免除されたパス (1行に1つ)',
	'BbHeadRefererExemptInfo'   => 'Referer なしの HEAD が正当なパス（例: /api/, /wp-json/）。',

	'BbAssetExtensionsLabel'    => '保護するアセットエクステンション（1行に1つ）',
	'BbAssetExtensionsInfo'     => 'ページ読み込みなしで直接スクレイピングするために見られるファイルタイプ。',

	'BbOnDemandBotIds'          => 'リフレッシュするボットID (空 = すべて)',
	'BbOnDemandBotIdsInfo'      => '特定のボットに更新を制限します。空白のままにすると、登録されているすべてのボットを更新します。',
	'BbOnDemandProbability'     => '確率分母（1 in N）',
	'BbOnDemandMinAge'          => '最小キャッシュ年齢 (秒)',
	'BbOnDemandLockTtl'         => 'TTLをロック(秒)',
	'BbOnDemandCacheTtl'        => 'キャッシュ TTL (秒)',
	'BbOnDemandFeedTimeout'     => 'フィードフェッチのタイムアウト（秒）',

	'BbDynamicIpTtl'            => 'キャッシュ TTL (秒)',
	'BbDynamicIpFeeds'          => 'リフレッシュするフィード（1行に1つ）',

	// === Time-window selector / dashboards ===
	'BbLastSeen'             => '最終閲覧',
	'BbSeverity'             => '重大度',
	'BbStatusBreakdown'      => 'ステータスの内訳：',
	'BbBotBreakdown'         => 'Botの内訳：',
	'BbTopBlocked'           => 'トップ拒否されたIP',
	'BbGeoSummary'           => '地理的な概要',
	'BbCountry'              => '国',
	'BbAsn'                  => 'ASN',
	'BbVerifiedPct'          => '確認済み%',
	'BbNoData'               => '選択したウィンドウにデータがありません',
	'BbCategory'             => 'カテゴリ',
	'BbResponseTime'         => '応答時間',
	'BbDateCol'              => '時間 / IP / ステータス',
	'BbSelectRow'            => '行を選択',

	// === Active-filter chips ===
	'BbChipSlow'             => 'スローのみ',
	'BbChipDate'             => 'Date range',
	'BbChipResolved'         => '解決済み',
	'BbChipStatusCode' => 'ステータスコード：',
	'BbChipIp'         => 'IP',
	'BbChipUa'         => 'UA',
	'BbChipUri'        => 'URI',
	'BbChipJa3'        => 'JA3',
	'BbChipAsn'        => 'ASN',
	'BbChipCountry'    => '国',

	// === Manage view additions ===
	'BbViewHeaders'          => 'ヘッダーを表示',
	'BbViewBody'             => '本文を表示',
	'BbViewContentLabel'     => 'コンテンツ',
	'BbViewModeFull'         => 'フル (常に表示)',
	'BbViewModeTeaser'       => 'チューザー (クリックで展開)',
	'BbViewModeHidden'       => '非表示 (オンデマンドで表示)',
	'BbHide'                 => 'ヒデ',
	'BbChars'                => '文字',

	// === Custom rules ===
	'BbCustomRules'                => 'カスタムルール',
	'BbCustomRulesLabel'           => 'カスタムルール (1 行に 1 つの JSON オブジェクト)',
	'BbCustomRulesInfo'            => '各行はキーを持つJSONオブジェクトです: type (ip|ua_regex|ua_contains|asn|country|header), value, action (allow|block|challenge|log), id. Example: {"type":"ua_regex","value":"/Googlebot/i","action":"log","id":"audit_googlebot"}',

	// === Body scan ===
	'BbBodyScanSkipFields'         => '本文スキャンのスキップフィールド',
	'BbBodyScanSkipFieldsInfo'     => '1行に1つのフィールド名があります。リストされたフィールドはSQL/XSSボディ検査中にスキップされます。',

	// === Advanced filters ===
	'BbAdvancedFilters'     => '高度なフィルタ',
	'BbDateFrom'            => '差出人:',
	'BbDateTo'              => '終了日',
	'BbJa3'                 => 'JA3 hash',
	'BbSlowOnly'            => 'スローリクエストのみ (>1s)',

	// === Resolved workflow ===
	'BbResolvedActive'      => 'アクティブのみ',
	'BbResolvedOnly'        => '解決済みのみ',
	'BbResolvedAll'         => 'アクティブ + 解決済み',
	'BbResolved'            => '解決済み',
	'BbActionResolve'       => '解決',
	'BbActionUnresolve'     => '未解決',
	'BbRowResolved'         => 'ログエントリが解決済みになっています',
	'BbRowUnresolved'       => 'ログエントリが未解決になっています',

	// === Bulk actions ===
	'BbBulkDeleteSelected'      => '選択したものを削除',
	'BbBulkWhitelistSelected'   => 'ホワイトリストIP',
	'BbBulkResolveSelected'     => '解決済みのマーク',
	'BbBulkUnresolveSelected'   => '未解決にする',
	'BbBulkHint'                => '最初に行をチェックし、アクションをクリックします。',
	'BbNoItemsSelected'         => 'アイテムが選択されていません',
	'BbBulkDeleted'             => '%1 ログエントリを削除しました',
	'BbBulkWhitelisted'         => '%1 IPをホワイトリストに追加しました',
	'BbBulkResolved'            => '%1 項目を解決済みにする',
	'BbBulkUnresolved'          => '%1 項目を未解決としてマークしました',
	'BbMarkAll'                 => 'このページのすべての行にマーク',
	'BbMarkNone'                => 'すべての行の標識を解除',

	'BbBulkFailed'              => '選択した行を更新できませんでした。データベースを確認するか、もう一度お試しください。',
	'BbBulkWhitelistedNone'     => '新しいIPが追加されませんでした。選択したIPはすべてホワイトリストに登録されていました。',

	// === Verified badge ===
	'BbVerified'             => '確認済み',
	'BbUnverified'           => '未確認',

	// === ResultCode enum mapping (BbStatus_<code>) ===
	'BbStatus_allowed'                    => '許可されたリクエスト',
	'BbStatus_blocked.bot'                => '既知のボットがブロックされています',
	'BbStatus_blocked.ai_crawler'         => 'AIクローラーがブロック',
	'BbStatus_blocked.seo_crawler'        => 'SEOクローラーがブロックされました',
	'BbStatus_blocked.malicious_ua'       => '悪意のあるユーザーエージェント',
	'BbStatus_blocked.attack_pattern'     => '攻撃ペイロードを検出しました',
	'BbStatus_blocked.dnsbl'              => 'DNSBL一致',
	'BbStatus_blocked.httpbl'             => 'http:BL一致',
	'BbStatus_blocked.behavioral'         => '行動異常',
	'BbStatus_blocked.fingerprint'        => '不正なフィンガープリントです',
	'BbStatus_blocked.rate_limit'         => 'レート制限を超えました',
	'BbStatus_blocked.custom_rule'        => 'カスタムルールの一致',
	'BbStatus_blocked.geoip'              => 'GeoIPブロック',
	'BbStatus_blocked.residential_proxy'  => '住宅用プロキシがブロックされました',
	'BbStatus_challenge.required'         => 'チャレンジが必要です',
	'BbStatus_challenge.failed'           => 'チャレンジに失敗しました',
	'BbStatus_error.internal'             => '内部エラー',
	'BbStatus_error.configuration'        => '設定エラー',

	// === Time-window tabs ===
	'BbWindow24h' => '過去24時間',
	'BbWindow7d'  => '過去 7 日間',
	'BbWindow30d' => '過去 30 日間',
	'BbWindowAll' => 'すべて',

	// === Preset dropdown ===
	'BbPresetMinimal'        => '最小 (デフォルト)',
	'BbPresetFull'           => 'フル',
	'BbPresetVerifiedOnly'   => '確認済みのみ',
	'BbPresetNoAi'           => 'No-AI',
	'BbPresetNoSeo'          => 'No-SEO',
	'BbPresetEuOnly'         => 'EUのみ',
	'BbPresetHumanOnly'      => '人間のみ',
	'BbPresetCustom'         => 'カスタム',

	// === Strictness dropdown ===
	'BbStrictnessMonitorOnly' => 'モニターのみ',
	'BbStrictnessNormal'      => '標準',
	'BbStrictnessStrict'      => 'Strict',

	// === Challenge provider dropdown ===
	'BbChallengeProviderBuiltin'   => 'Builtin (PoW)',
	'BbChallengeProviderHcaptcha'  => 'hCaptcha',
	'BbChallengeProviderRecaptcha' => 'reCAPTCHA v3',
	'BbChallengeProviderTurnstile' => 'Cloudflare Turnstile',

	// === Head Request Detection (newly translated form labels) ===
	'BbEnableHeadRequest'        => 'ヘッド要求の検出を有効にする',
	'BbHeadRequireReferer'       => '参照者を要求する',
	'BbHeadFloodThreshold'       => '洪水のしきい値（セッション毎）',
	'BbHeadProbeThreshold'       => 'プローブ閾値（IP / 5分あたり）',

	// === Asset Scraping (newly translated form labels) ===
	'BbEnableAssetScraping'        => 'アセットスクレイピング検出を有効にする',
	'BbAssetNoRefererThreshold'    => '非リファラー閾値（IP / 時間あたり）',
	'BbAssetOnlySessionThreshold'  => 'アセットのみのセッションしきい値',
	'BbAssetPatternThreshold'      => 'シーケンシャルパターンしきい値 (IP / 5minあたり)',

	// === Dynamic IP Ranges ===
	'BbEnableDynamicIpRanges' => '動的IP範囲を有効にする',

	// === On-demand IP Refresh ===
	'BbEnableOnDemandRefresh'    => 'オンデマンドの更新を有効にする',
	'BbOnDemandRefreshInfo'      => 'リクエスト中にIP範囲キャッシュを更新します。cronアクセスがない場合に使用します。',
	'BbOnDemandBotIdsPlaceholder' => 'googlebot, gptbot, claude…',

	// === Fingerprint field labels ===
	'BbFpBadJa3'          => '不正なJA3',
	'BbFpBadH2'           => 'H2が不正です',
	'BbFpBotHeaderOrders' => 'Botヘッダ注文',
	'BbFpExpectedJa3'     => '期待されているJA3',

	// === Bot category list titles + hint ===
	'BbListBlocked'   => 'ブロック',
	'BbListChallenge' => 'チャレンジ (CAPTCHA)',
	'BbListLogOnly'   => 'ログのみ (強制なし)',
	'BbListAllowed'   => '明示的に許可',
	'BbListHint'      => 'このリストのカテゴリは、カテゴリのデフォルトに関係なくアクションを取得します。',

	// === Bot category dropdown labels (manage filter) ===
	'BbCatSearchEngine'    => 'Search Engine',
	'BbCatAiCrawler'       => 'AI Crawler',
	'BbCatSocialCrawler'   => 'ソーシャルクローラー',
	'BbCatSeoCrawler'      => 'SEOクローラー',
	'BbCatArchiveCrawler'  => 'クローラーをアーカイブ',
	'BbCatMonitoring'      => 'モニタリング',
	'BbCatFeedReader'      => 'フィードリーダー',
	'BbCatShoppingCrawler' => '買い物用クローラー',
	'BbCatCloudInfra'      => 'クラウドインフラストラクチャ',
	'BbCatSecurityScanner' => 'セキュリティスキャナ',
	'BbCatResidentialProxy'=> 'レジデンシャルプロキシ',
	'BbCatMalicious'       => '悪意のある',
	'BbCatUnknown'         => '不明',

	// === Placeholders ===
	'BbJa3Placeholder' => '32文字ハッシュ',

	// === Summary severity group labels ===
	'BbSevAttackPatterns' => '攻撃パターン',
	'BbSevChallenges'     => '発行された課題',
	'BbSevPermitted'      => '許可',
	'BbSevErrors'         => 'エラー',

	// === Summary table column (was used but missing from set) ===
	'BbCategories' => 'カテゴリ',

	'BbResultBreakdown'    => '結果の内訳：',
	'BbBreakdownBlocked'   => 'ブロック',
	'BbBreakdownMonitored' => '監視中',
	'BbBreakdownAllowed'   => '許可',
	'BbViewAllInLog'       => 'すべてのログを表示',
	'BbAllowedHintVerbose' => '冗長ロギングが有効な場合にのみ許可されるトラフィックが記録されます。設定で logging_mode=verbose を切り替えて、何が通過するかを確認します。',

];
