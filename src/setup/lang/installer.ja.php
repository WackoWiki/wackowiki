<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'ja',
'LangLocale'	=> 'ja_JP',
'LangName'		=> '日本語 ',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'カテゴリー',
	'groups_page'		=> 'グループ',
	'users_page'		=> 'ユーザー',

	'search_page'		=> '検索',
	'login_page'		=> 'ログイン',
	'account_page'		=> '設定',
	'registration_page'	=> 'アカウント作成',
	'password_page'		=> 'パスワード',

	'changes_page'		=> '最近の変化',
	'comments_page'		=> '最近コメント',
	'index_page'		=> 'ページインデックス',

	'random_page'		=> 'ランダムページ',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki のインストール',
'TitleUpdate'					=> 'WackoWikiの更新',
'Continue'						=> '続行',
'Back'							=> '戻る',
'Recommended'					=> '推奨',
'InvalidAction'					=> '無効なアクション',

/*
   Language Selection Page
*/
'lang'							=> '言語設定',
'PleaseUpgradeToR6'				=> 'You appear to be running an old (pre %2) release of WackoWiki (%1). To update to this release of WackoWiki, you must first update your installation to %2.',
'UpgradeFromWacko'				=> 'WackoWiki へようこそ! WackoWiki %1 から %2にアップグレードしているようです。 次の数ページでは、アップグレードプロセスをご案内します。',
'FreshInstall'					=> 'WackoWiki へようこそ! WackoWiki %1をインストールしようとしています。次の数ページはインストールプロセスをご案内します。',
'PleaseBackup'					=> 'アップグレード プロセスを開始する前に、データベース、構成ファイル、ローカル ハックやパッチが適用されたファイルなど、変更されたすべてのファイルを <strong>バックアップ</strong> してください。これにより、大きな問題から解放されます。',
'LangDesc'						=> 'インストールプロセスの言語を選択してください。この言語はWackoWikiのデフォルト言語としても使用されます。',

/*
   System Requirements Page
*/
'version-check'					=> 'システム要件',
'PhpVersion'					=> 'PHPのバージョン',
'PhpDetected'					=> '検出されたPHP',
'ModRewrite'					=> 'Apache Rewrite Extension (省略可能)',
'ModRewriteInstalled'			=> 'リライトエクステンション (mod_rewrite) をインストールしますか?',
'Database'						=> 'データベース',
'PhpExtensions'					=> 'PHP エクステンション',
'Permissions'					=> '権限',
'ReadyToInstall'				=> 'インストールの準備はできましたか？',
'Requirements'					=> 'サーバーは以下の要件を満たしている必要があります。',
'OK'							=> 'OK',
'Problem'						=> '問題',
'Example'						=> '例',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'あなたのPHPのインストールは、WackoWikiによって必要とされるPHP拡張機能を欠いているように見えます。',
'PcreWithoutUtf8'				=> 'PHP の PCRE が PCRE_UTF8 対応なしでコンパイルされているようです。',
'NotePermissions'				=> 'このインストーラはWackoWikiディレクトリにある %1ファイルに設定データを書き込もうとします。 これを機能させるには、ウェブサーバーがそのファイルへの書き込みアクセス権を持っていることを確認する必要があります。 これを行うことができない場合は、手動でファイルを編集する必要があります(インストーラが方法を教えてくれます)。 Aformat@@0<br><br>詳細は <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> をご覧ください。',
'ErrorPermissions'				=> 'WackoWikiが正しく動作するために必要なファイル権限をインストーラが自動的に設定できないようです。 手動でサーバーに必要なファイル権限を設定するには、インストールプロセスの後半にプロンプトが表示されます。',
'ErrorMinPhpVersion'			=> 'PHPのバージョンは %1より大きくなければなりません。サーバーが以前のバージョンを実行しているようです。 WackoWikiが正しく動作するには、最新のPHPバージョンにアップグレードする必要があります。',
'Ready'							=> 'おめでとうございます。あなたのサーバーは WackoWiki を実行できるようになっています。次のいくつかのページで構成プロセスを説明します。',

/*
   Site Config Page
*/
'config-site'					=> 'サイト設定',
'SiteName'						=> 'ウィキ名',
'SiteNameDesc'					=> 'Wikiサイトの名前を入力してください。',
'SiteNameDefault'				=> 'マイウィキ',
'HomePage'						=> 'ホームページ',
'HomePageDesc'					=> 'ホームページに表示する名前を入力します。 これは、ユーザーがあなたのサイトにアクセスしたときに表示されるデフォルトのページになり、 <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> になるはずです。',
'HomePageDefault'				=> 'ホームページ',
'MultiLang'						=> 'マルチ言語モード',
'MultiLangDesc'					=> '多言語モードでは、単一のインストール内で異なる言語設定のページを持つことができます。 このモードが有効な場合、インストーラは配布物で利用可能なすべての言語の初期メニュー項目を作成します。',
'AllowedLang'					=> '許可された言語',
'AllowedLangDesc'				=> '使用する言語のセットのみを選択することをお勧めします。そうでなければ、すべての言語が選択されます。',
'AclMode'						=> 'デフォルトの ACL 設定',
'AclModeDesc'					=> '',
'PublicWiki'					=> '公開 Wiki (すべてのユーザーのために読んで、登録ユーザーのために書いてコメントしてください)',
'PrivateWiki'					=> 'プライベート Wiki (作成されたユーザーのみ読み取り、書き込み、コメント可能)',
'Admin'							=> '管理者名',
'AdminDesc'						=> '管理者のユーザ名を入力します。これは、 <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (例: <code>WikiAdmin</code> )にする必要があります。',
'NameAlphanumOnly'				=> 'ユーザー名は %1 文字から %2 文字の間で、英数字のみを使用する必要があります。大文字はOKです。',
'NameCamelCaseOnly'				=> 'ユーザー名は %1 と %2 文字の間でなければならず、WikiName フォーマットされています。',
'Password'						=> '管理者パスワード',
'PasswordDesc'					=> '最低 %1 文字の管理者用パスワードを選択してください。',
'PasswordConfirm'				=> 'パスワードの再入力:',
'Mail'							=> '管理者メールアドレス',
'MailDesc'						=> '管理者のメールアドレスを入力します。',
'Base'							=> 'ベースURL',
'BaseDesc'						=> 'あなたの WackoWiki サイトのベース URL です。 ページ名が付加されるので、mod_rewrite を使用している場合は、 アドレスはスラッシュ、すなわち で終わるべきです。',
'Rewrite'						=> '書き換えモード',
'RewriteDesc'					=> 'URL書き換えでWackoWikiを使用している場合は、書き換えモードを有効にする必要があります。',
'Enabled'						=> '有効にする:',
'ErrorAdminEmail'				=> '無効なメールアドレスを入力しました！',
'ErrorAdminPasswordMismatch'	=> '入力された2つのパスワードが一致しません。',
'ErrorAdminPasswordShort'		=> '管理者パスワードが短すぎます！最小文字数は %1 文字です。',
'ModRewriteStatusUnknown'		=> 'インストーラは、mod_rewrite が有効であることを確認できません。ただし、それが無効であることを意味するものではありません。',

/*
   Database Config Page
*/
'config-database'				=> 'データベース設定',
'DbDriver'						=> 'ドライバ',
'DbDriverDesc'					=> '使用するデータベースドライバ。',
'DbSqlMode'						=> 'SQL モード',
'DbSqlModeDesc'					=> '使用する SQL モード。',
'DbVendor'						=> '仕入先',
'DbVendorDesc'					=> '使用しているデータベースベンダー。',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> '使用するデータベースの文字セット。',
'DbEngine'						=> 'ストレージ エンジン',
'DbEngineDesc'					=> '使用するデータベースエンジン。',
'DbHost'						=> 'データベースのホスト',
'DbHostDesc'					=> 'データベースサーバーが動作しているホスト、通常は <code>127.0.0.1</code> または <code>localhost</code> (つまり、WackoWiki サイトが動作しているマシン) です。',
'DbPort'						=> 'データベースのポート (Optional)',
'DbPortDesc'					=> 'データベースサーバーからアクセス可能なポート番号です。デフォルトのポート番号を使用するには空白のままにしてください。',
'DbName'						=> 'データベース名',
'DbNameDesc'					=> 'データベースの WackoWiki が使用する必要があります。このデータベースは続行する前に既に存在する必要があります！',
'DbUser'						=> 'データベースのユーザー名',
'DbUserDesc'					=> 'データベースへの接続に使用するユーザー名です。',
'DbPassword'					=> 'データベースのパスワード',
'DbPasswordDesc'				=> 'データベースへの接続に使用するユーザーのパスワード。',
'Prefix'						=> 'データベース テーブルの接頭辞',
'PrefixDesc'					=> 'WackoWikiで使用されるすべてのテーブルのプレフィックス。 これにより、異なるテーブルプレフィックス(wacko_など)を使用するように設定することで、同じデータベースを使用して複数の WackoWiki インストールを実行することができます。',
'ErrorNoDbDriverDetected'		=> 'データベースドライバが検出されていません。php.iniファイルでmysqliまたはpdo_mysql拡張子を有効にしてください。',
'ErrorNoDbDriverSelected'		=> 'データベースドライバが選択されていません。一覧から選択してください。',
'DeleteTables'					=> '既存のテーブルを削除しますか？',
'DeleteTablesDesc'				=> '注意! このオプションを選択すると、現在のすべてのwikiデータがデータベースから消去されます。 これは元に戻すことはできません。バックアップからデータを手動で復元する必要があります。',
'ConfirmTableDeletion'			=> '現在のWiki表をすべて削除してもよろしいですか？',

/*
   Database Installation Page
*/
'install-database'				=> 'データベースのインストール',
'TestingConfiguration'			=> 'テストの構成',
'TestConnectionString'			=> 'データベース接続設定のテスト',
'TestDatabaseExists'			=> '指定したデータベースが存在するか確認しています',
'TestDatabaseVersion'			=> 'データベースの最小バージョン要件を確認しています',
'InstallTables'					=> 'テーブルのインストール',
'ErrorDbConnection'				=> '指定したデータベース接続の詳細に問題がありました。戻って正しいことを確認してください。',
'ErrorDatabaseVersion'			=> 'データベースのバージョンは %1 ですが、少なくとも %2が必要です。',
'To'							=> '宛先',
'AlterTable'					=> 'Altering %1 table',
'InsertRecord'					=> '%1 テーブルにレコードを挿入する',
'RenameTable'					=> '%1 テーブルの名前を変更中',
'UpdateTable'					=> '%1 テーブルを更新中',
'InstallDefaultData'			=> '既定のデータの追加',
'InstallPagesBegin'				=> 'デフォルトページを追加する',
'InstallPagesEnd'				=> 'デフォルトページの追加が完了しました',
'InstallSystemAccount'			=> '<code>システム</code> の追加',
'InstallDeletedAccount'			=> 'Adding <code>Deleted</code> User',
'InstallAdmin'					=> '管理者ユーザーを追加中',
'InstallAdminSetting'			=> '管理者ユーザー設定の追加',
'InstallAdminGroup'				=> '管理者グループを追加中',
'InstallAdminGroupMember'		=> '管理者グループメンバーの追加',
'InstallEverybodyGroup'			=> '全員のグループを追加',
'InstallModeratorGroup'			=> 'モデレーターグループの追加',
'InstallReviewerGroup'			=> '査読者グループを追加中',
'InstallLogoImage'				=> 'ロゴ画像の追加',
'LogoImage'						=> 'ロゴ画像',
'InstallConfigValues'			=> '設定値の追加',
'ConfigValues'					=> '設定値',
'ErrorInsertPage'				=> '%1 ページの挿入エラー',
'ErrorInsertPagePermission'		=> '%1 ページの権限設定エラー',
'ErrorInsertDefaultMenuItem'	=> 'ページ %1 をデフォルトのメニューアイテムとして設定中にエラーが発生しました',
'ErrorPageAlreadyExists'		=> '%1 ページは既に存在します',
'ErrorAlterTable'				=> '%1 テーブルの変更エラー',
'ErrorInsertRecord'				=> '%1 テーブルにレコードを挿入中にエラー',
'ErrorRenameTable'				=> '%1 テーブルの名前を変更できませんでした',
'ErrorUpdatingTable'			=> '%1 テーブルの更新中にエラーが発生しました',
'CreatingTable'					=> '%1 テーブルの作成',
'ErrorAlreadyExists'			=> '%1 は既に存在します',
'ErrorCreatingTable'			=> '%1 テーブルの作成でエラーが発生しました。既に存在しますか？',
'DeletingTables'				=> 'テーブルの削除',
'DeletingTablesEnd'				=> 'テーブルの削除が完了しました',
'ErrorDeletingTable'			=> '%1 テーブルの削除エラー。テーブルが存在しない可能性が最も高い理由は、この警告を無視することができます。',
'DeletingTable'					=> '%1 テーブルの削除',
'NextStep'						=> '次のステップでは、インストーラーは更新された構成ファイル %1 を書き込もうとします。Web サーバーにファイルへの書き込み権限があることを確認してください。権限がない場合は、手動で編集する必要があります。詳細については、<a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> を参照してください。',

/*
   Write Config Page
*/
'write-config'					=> '設定ファイルの書き込み',
'FinalStep'						=> '最終ステップ',
'Writing'						=> '設定ファイルの書き込み',
'RemovingWritePrivilege'		=> '書き込み権限を削除する',
'InstallationComplete'			=> 'インストール完了',
'ThatsAll'						=> 'That\'s all! You can now <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations'		=> 'セキュリティについての考慮事項',
'SecurityRisk'					=> '%1 への書き込みアクセスを今すぐ削除することをお勧めします。 書き込み可能なファイルを残すと、セキュリティ上のリスクになります！format@@0<br>つまり、 %2',
'RemoveSetupDirectory'			=> 'インストール処理が完了したら、 %1 ディレクトリを削除してください。',
'ErrorGivePrivileges'			=> 'The configuration file %1 could not be written. You will need to give your web server temporary write access to either your WackoWiki directory, or a blank file called %1<br>%2.<br><br> Don\'t forget to remove write access again later, i.e., <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'If, for any reason, you can\'t do this, you\'ll have to copy the text below into a new file and save/upload it as %1 into the WackoWiki directory. Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'これを行ったら、あなたのWackoWikiサイトは動作するはずです。そうでない場合は、 <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a> にアクセスしてください。',
'WrittenAt'						=> 'に書き込まれた ',
'DontChange'					=> 'wacko_version を手動で変更しないでください!',
'ConfigDescription'				=> '詳細な説明: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'もう一度試す',

];
