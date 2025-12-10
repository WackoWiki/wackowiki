<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'ko',
'LangLocale'	=> 'en_US',
'LangName'		=> '한국어',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> '카테고리',
	'groups_page'		=> '그룹',
	'users_page'		=> '사용자',

	'search_page'		=> '검색',
	'login_page'		=> '로그인',
	'account_page'		=> '설정',
	'registration_page'	=> '계정만들기',
	'password_page'		=> '비밀번호',

	'whatsnew_page'		=> 'WhatsNew',
	'changes_page'		=> '최근바뀜',
	'comments_page'		=> '최근댓글',
	'index_page'		=> '페이지색인',

	'random_page'		=> '임의의문서로',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki 설치',
'TitleUpdate'					=> 'WackoWiki Update',
'Continue'						=> '계속',
'Back'							=> '뒤로',
'Recommended'					=> '권장',
'InvalidAction'					=> 'Invalid action',

/*
   Locking Check
 */
'LockAuthorization'				=> '권한 부여',
'LockAuthorizationInfo'			=> 'Please enter the password you saved in the file %1.',
'LockPassword'					=> '비밀번호:',
'LockLogin'						=> '로그인',
'LockPasswordInvalid'			=> 'Invalid password.',
'LockedTryLater'				=> 'This site is currently being upgraded. Please try again later.',
'EmptyAuthFile'					=> 'Missing or empty %1 file. Please create the file and set a password into that file.',


/*
   Language Selection Page
*/
'lang'							=> '언어 설정',
'PleaseUpgradeToR6'				=> '현재 구버전 WackoWiki %1을 실행 중인 것으로 보입니다. 이 버전의 WackoWiki로 업데이트하려면 먼저 설치 환경을 %2로 업데이트해야 합니다.',
'UpgradeFromWacko'				=> 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki %1 to %2.  The next few pages will guide you through the upgrade process.',
'FreshInstall'					=> 'Welcome to WackoWiki, you are about to install WackoWiki %1.  The next few pages will guide you through the installation process.',
'PleaseBackup'					=> 'Please, <strong>backup</strong> your database, config file and all changed files such as those which have hacks and patches applied to them before starting upgrade process. This can save you from big headache.',
'LangDesc'						=> '설치 과정에서 사용할 언어를 선택하세요. This language will also be used as the default language of your WackoWiki installation.',

/*
   System Requirements Page
*/
'version-check'					=> '시스템 요구사항',
'PhpVersion'					=> 'PHP 버전',
'PhpDetected'					=> 'Detected PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> '데이터베이스',
'PhpExtensions'					=> 'PHP 확장',
'Permissions'					=> '사용자 권한',
'ReadyToInstall'				=> 'Ready to Install?',
'Requirements'					=> 'Your server must meet the requirements listed below.',
'OK'							=> 'OK',
'Problem'						=> '문제',
'Example'						=> 'Example',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'PHP 설치에 WackoWiki에서 요구하는 PHP 확장이 누락 된 것 같습니다. ',
'PcreWithoutUtf8'				=> 'PHP의 PCRE 모듈은 RCRE_UTF8 지원 없이 컴파일된 것 같습니다.',
'NotePermissions'				=> '이 설치 프로그램은 WackoWiki 디렉토리에 위치한 %1 파일에 구성 데이터를 기록하려고 시도합니다. 이 작업이 정상적으로 수행되려면 웹 서버가 해당 파일에 대한 쓰기 권한을 반드시 가져야 합니다.  이 작업을 수행할 수 없는 경우 파일을 수동으로 편집해야 합니다(설치 프로그램에서 방법을 안내해 줍니다).<br><br>자세한 내용은 <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>을 참조하십시오.',
'ErrorPermissions'				=> '설치 프로그램이 WackoWiki가 정상적으로 작동하도록 필요한 파일 권한을 자동으로 설정할 수 없는 것으로 보입니다. 설치 과정 후반부에 서버에서 필요한 파일 권한을 수동으로 구성하라는 안내가 표시될 것입니다.',
'ErrorMinPhpVersion'			=> 'PHP 버전은 %1보다 높아야 합니다. 서버가 이전 버전을 실행 중인 것으로 보입니다. WackoWiki가 정상적으로 작동하려면 최신 PHP 버전으로 업그레이드해야 합니다.',
'Ready'							=> '축하합니다. 귀하의 서버가 WackoWiki를 실행할 수 있는 것으로 보입니다. 다음 몇 페이지에서 설정 과정을 안내해 드리겠습니다.',

/*
   Site Config Page
*/
'config-site'					=> '사이트 구성',
'SiteName'						=> '위키 이름',
'SiteNameDesc'					=> '사이트 이름을 입력하세요.',
'SiteNameDefault'				=> '내위키',
'HomePage'						=> '홈페이지',
'HomePageDesc'					=> 'Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> '홈페이지',
'MultiLang'						=> '다국어 모드',
'MultiLangDesc'					=> '다국어 모드를 사용하면 단일 설치 환경 내에서 서로 다른 언어 설정을 가진 페이지를 가질 수 있습니다. 이 모드가 활성화되면 설치 프로그램은 배포판에서 사용 가능한 모든 언어에 대한 초기 메뉴 항목을 생성합니다.',
'AllowedLang'					=> '허용되는 언어',
'AllowedLangDesc'				=> 'It is recommended to select only the set of languages you want to use, other wise all languages are selected.',
'AclMode'						=> '기본 ACL 설정',
'AclModeDesc'					=> '',
'PublicWiki'					=> '공개 위키(모두 읽기, 등록 사용자에 대한 쓰기 및 댓글)',
'PrivateWiki'					=> '비공개 위키(등록 사용자에 대한 읽기, 쓰기, 댓글)',
'Admin'							=> '관리자 이름',
'AdminDesc'						=> 'Enter the admins username, this should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'Username must be between %1 and %2 chars long and use only alphanumeric characters. Upper case characters are OK.',
'NameCamelCaseOnly'				=> 'Username must be between %1 and %2 chars long and WikiName formatted.',
'Password'						=> '관리자 비밀번호',
'PasswordDesc'					=> 'Choose a password for the admin with a minimum of %1 characters.',
'PasswordConfirm'				=> '비밀번호 확인:',
'Mail'							=> '관리자 이메일 주소',
'MailDesc'						=> 'Enter the admins email address.',
'Base'							=> 'Base URL',
'BaseDesc'						=> 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash, i.e.',
'Rewrite'						=> 'Rewrite Mode',
'RewriteDesc'					=> 'Rewrite mode should be enabled if you are using WackoWiki with URL rewriting.',
'Enabled'						=> '사용:',
'ErrorAdminEmail'				=> 'You have entered an invalid email address!',
'ErrorAdminPasswordMismatch'	=> '입력한 비밀번호 두 개가 일치하지 않습니다!.',
'ErrorAdminPasswordShort'		=> 'The admin password is too short, the minimum length is %1 characters!',
'ModRewriteStatusUnknown'		=> 'The installer cannot verify that mod_rewrite is enabled, however this does not mean it is disabled',

/*
   Database Config Page
*/
'config-database'				=> '데이터베이스 구성',
'DbDriver'						=> 'Driver',
'DbDriverDesc'					=> 'The database driver you want to use.',
'DbSqlMode'						=> 'SQL mode',
'DbSqlModeDesc'					=> 'The SQL mode you want use.',
'DbVendor'						=> 'Vendor',
'DbVendorDesc'					=> 'The database vendor you use.',
'DbCharset'						=> '문자셋',
'DbCharsetDesc'					=> 'The database charset you want to use.',
'DbEngine'						=> '저장소 엔진',
'DbEngineDesc'					=> 'The database engine you want to use.',
'DbHost'						=> '데이터베이스 호스트',
'DbHostDesc'					=> 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort'						=> '포트 (선택 과목)',
'DbPortDesc'					=> 'The port number your database server is accessible through, leave it blank to use the default port number.',
'DbName'						=> '데이터베이스 이름',
'DbNameDesc'					=> 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DbNameSqliteDesc'				=> 'The data directory and file name SQLite should use for WackoWiki.',
'DbNameSqliteHelp'				=> 'SQLite stores all data in a single file.<br><br>The directory you provide must be writable by the webserver during installation.<br><br>It should <strong>not</strong> be accessible via the web.<br><br>The installer will write a <code>.htaccess</code> file along with it, but if that fails someone can gain access to your raw database.<br>That includes raw user data (email addresses, hashed passwords) as well as protected pages and other restricted data on the wiki.<br><br>Consider putting the database somewhere else altogether, for example in <code>/var/lib/wackowiki/yourwiki</code>.',
'DbUser'						=> '사용자 이름',
'DbUserDesc'					=> 'Name of the user used to connect to your database.',
'DbPassword'					=> '암호',
'DbPasswordDesc'				=> 'Password of the user used to connect to your database.',
'Prefix'						=> '테이블 접두어',
'PrefixDesc'					=> 'WackoWiki에서 사용하는 모든 테이블의 접두사입니다. 이를 통해 서로 다른 테이블 접두사(예: wacko_)를 사용하도록 구성함으로써 동일한 데이터베이스를 사용하는 여러 WackoWiki 설치를 실행할 수 있습니다.',
'ErrorNoDbDriverDetected'		=> 'No database driver has been detected, please enable either the mysqli or pdo_mysql extension in your php.ini file.',
'ErrorNoDbDriverSelected'		=> 'No database driver has been selected, please pick one from the list.',
'DeleteTables'					=> 'Delete Existing Tables?',
'DeleteTablesDesc'				=> 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion'			=> 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'install-database'				=> '데이터베이스 설치',
'TestingConfiguration'			=> 'Testing Configuration',
'TestConnectionString'			=> 'Testing database connection settings',
'TestDatabaseExists'			=> 'Checking if the database you specified exists',
'TestDatabaseVersion'			=> 'Checking database minimum version requirements',
'SqliteFileExtensionError'		=> '다음 파일 확장자 중 하나를 사용하십시오: db, sdb, sqlite.',
'SqliteParentUnwritableGroup'	=> '<code>%1</code> 데이터 디렉토리를 만들 수 없으며, 이는 웹 서버는 상위 디렉토리인 <code>%2</code>에 쓸 수 없기 때문입니다.<br><br>설치 관리자는 웹 서버로 실행 중인 사용자를 지정할 수 없습니다.<br>계속하려면 웹 서버가 쓸 수 있는 <code>%3</code> 디렉토리를 만드세요.<br>유닉스/리눅스 시스템에서의 수행:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> '<code>%1</code> 데이터 디렉토리를 만들 수 없으며, 이는 웹 서버가 상위 디렉토리인 <code>%2</code>에 쓸 수 없기 때문입니다.<br><br>설치 관리자는 웹 서버로 실행 중인 사용자를 지정할 수 없습니다.<br>계속하려면 웹 서버(와 그 외 서버!)가 전역으로 쓸 수 있는 <code>%3</code> 디렉토리를 만드세요.<br>유닉스/리눅스 시스템에서의 수행:<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> '<code>%1</code> 데이터 디렉터리를 만드는 도중 오류가 발생했습니다.<br>경로를 확인하고 다시 시도하세요.',
'SqliteDirUnwritable'			=> '<code>%1</code> 디렉토리에 쓸 수 없습니다.\n웹 서버를 쓸 수 있도록 권한을 바꾸고 다시 시도하세요.',
'SqliteReadonly'				=> '<code>%1</code> 파일은 쓸 수 없습니다.',
'SqliteCantCreateDb'			=> '<code>%1</code> 데이터베이스 파일을 만들 수 없습니다.',
'InstallTables'					=> 'Installing Tables',
'ErrorDbConnection'				=> '지정하신 데이터베이스 연결 정보에 문제가 있습니다. 다시 확인하시어 정확한지 확인해 주십시오.',
'ErrorDatabaseVersion'			=> 'The database version is %1 but requires at least %2.',
'To'							=> 'to',
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
'ConfigValues'					=> 'Config Values',
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
'ErrorDeletingTable'			=> 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable'					=> 'Deleting %1 table',
'NextStep'						=> '다음 단계에서 설치 프로그램은 업데이트된 구성 파일인 %1을 작성하려고 시도합니다. 웹 서버가 해당 파일에 대한 쓰기 권한을 가지고 있는지 확인하십시오. 그렇지 않으면 수동으로 파일을 편집해야 합니다. 자세한 내용은 <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>을 참조하십시오.',

/*
   Write Config Page
*/
'write-config'					=> 'Write Config File',
'FinalStep'						=> '마지막 단계',
'Writing'						=> 'Writing Configuration File',
'RemovingWritePrivilege'		=> 'Removing Write Privilege',
'InstallationComplete'			=> '설치 완료',
'ThatsAll'						=> 'That\'s all! You can now <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations'		=> '보안 고려 사항',
'SecurityRisk'					=> 'You are advised to remove write access to %1 again now that it\'s been written. Leaving the file writable can be a security risk!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges'			=> 'The configuration file %1 could not be written. You will need to give your web server temporary write access to either your WackoWiki directory, or a blank file called %1<br>%2<br><br>Don\'t forget to remove write access again later, i.e.<br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> '어떤 이유로든 이 작업을 수행할 수 없다면, 아래 텍스트를 새 파일에 복사하여 WackoWiki 디렉터리에 %1로 저장/업로드해야 합니다. 이 작업을 완료하면 WackoWiki 사이트가 정상 작동할 것입니다. 그렇지 않다면, <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>을 방문해 주세요',
'ErrorPrivilegesUpgrade'		=> '이 작업을 완료하면 WackoWiki 사이트가 정상 작동할 것입니다. 그렇지 않은 경우 <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/Upgrade</a>를 방문해 주세요',
'WrittenAt'						=> 'written at ',
'DontChange'					=> 'do not change wacko_version manually!',
'ConfigDescription'				=> 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> '다시 시도하십시오',

];
