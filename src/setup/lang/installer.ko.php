<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'ko',
'LangLocale'	=> 'ko_KR',
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

	'whatsnew_page'		=> '새로운 소식',
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
'TitleUpdate'					=> 'WackoWiki 업데이트',
'Continue'						=> '계속',
'Back'							=> '뒤로',
'Recommended'					=> '권장',
'InvalidAction'					=> 'Invalid action',

/*
   Locking Check
 */
'LockAuthorization'				=> '권한 부여',
'LockAuthorizationInfo'			=> '파일 %1에 저장한 비밀번호를 입력하세요.',
'LockPassword'					=> '비밀번호:',
'LockLogin'						=> '로그인',
'LockPasswordInvalid'			=> '잘못된 비밀번호입니다.',
'LockedTryLater'				=> '현재 사이트가 업그레이드 중입니다. 잠시 후 다시 시도해 주세요.',
'EmptyAuthFile'					=> '%1 파일이 없거나 비어 있습니다. 파일을 생성하고 해당 파일에 암호를 설정하십시오.',


/*
   Language Selection Page
*/
'lang'							=> '언어 설정',
'PleaseUpgradeToR6'				=> '현재 구버전 WackoWiki %1을 실행 중인 것으로 보입니다. 이 버전의 WackoWiki로 업데이트하려면 먼저 설치 환경을 %2로 업데이트해야 합니다.',
'UpgradeFromWacko'				=> 'WackoWiki에 오신 것을 환영합니다! 현재 WackoWiki %1에서 %2로 업그레이드 중인 것으로 보입니다. 다음 몇 페이지에서 업그레이드 과정을 안내해 드리겠습니다.',
'FreshInstall'					=> 'WackoWiki에 오신 것을 환영합니다! WackoWiki %1을 설치하려고 합니다. 다음 몇 페이지에서 설치 과정을 안내해 드리겠습니다.',
'PleaseBackup'					=> '업그레이드 프로세스를 시작하기 전에 데이터베이스, 구성 파일 및 로컬 해킹이나 패치가 적용된 파일 등 변경된 모든 파일을 <strong>백업</strong>하십시오. 이는 큰 골칫거리를 피하는 데 도움이 될 수 있습니다.',
'LangDesc'						=> '설치 과정에서 사용할 언어를 선택하세요. 이 언어는 또한 귀하의 WackoWiki 설치의 기본 언어로 사용될 것입니다.',

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
'ReadyToInstall'				=> '설치 준비되셨나요?',
'Requirements'					=> '서버는 아래에 나열된 요구 사항을 충족해야 합니다.',
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
'HomePageDesc'					=> 'Enter the name you would like your home page to have. This will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> '홈페이지',
'MultiLang'						=> '다국어 모드',
'MultiLangDesc'					=> '다국어 모드를 사용하면 단일 설치 환경 내에서 서로 다른 언어 설정을 가진 페이지를 가질 수 있습니다. 이 모드가 활성화되면 설치 프로그램은 배포판에서 사용 가능한 모든 언어에 대한 초기 메뉴 항목을 생성합니다.',
'AllowedLang'					=> '허용되는 언어',
'AllowedLangDesc'				=> '사용하려는 언어만 선택하는 것이 좋습니다. 그렇지 않으면 모든 언어가 선택됩니다.',
'AclMode'						=> '기본 ACL 설정',
'AclModeDesc'					=> '',
'PublicWiki'					=> '공개 위키(모두 읽기, 등록 사용자에 대한 쓰기 및 댓글)',
'PrivateWiki'					=> '비공개 위키(등록 사용자에 대한 읽기, 쓰기, 댓글)',
'Admin'							=> '관리자 이름',
'AdminDesc'						=> 'Enter the admin\'s username. This should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> '사용자 이름은 %1과 %2 사이의 길이로, 영숫자만 사용해야 합니다. 대문자도 사용 가능합니다.',
'NameCamelCaseOnly'				=> '사용자 이름은 %1과 %2 사이의 길이로 위키 이름 형식이어야 합니다.',
'Password'						=> '관리자 비밀번호',
'PasswordDesc'					=> '관리자용 비밀번호를 최소 %1자 이상으로 설정하십시오.',
'PasswordConfirm'				=> '비밀번호 확인:',
'Mail'							=> '관리자 이메일 주소',
'MailDesc'						=> '관리자의 이메일 주소를 입력하세요.',
'Base'							=> '기본 URL',
'BaseDesc'						=> '귀하의 WackoWiki 사이트 기본 URL입니다. 페이지 이름이 여기에 추가되므로, mod_rewrite를 사용 중이라면 주소는 슬래시(/)로 끝나야 합니다. 예를 들어:',
'Rewrite'						=> 'Rewrite Mode',
'RewriteDesc'					=> 'URL 재작성 기능을 사용하는 경우 WackoWiki에서 재작성 모드를 활성화해야 합니다.',
'Enabled'						=> '사용:',
'ErrorAdminEmail'				=> '잘못된 이메일 주소를 입력하셨습니다!',
'ErrorAdminPasswordMismatch'	=> '입력한 비밀번호 두 개가 일치하지 않습니다!.',
'ErrorAdminPasswordShort'		=> '관리자 비밀번호가 너무 짧습니다! 최소 길이는 %1자입니다.',
'ModRewriteStatusUnknown'		=> '설치 프로그램은 mod_rewrite가 활성화되었는지 확인할 수 없습니다. 그러나 이는 비활성화되었음을 의미하지는 않습니다.',

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
'DbCharsetDesc'					=> '사용할 데이터베이스 문자 집합을 선택하세요.',
'DbEngine'						=> '저장소 엔진',
'DbEngineDesc'					=> 'The database engine you want to use.',
'DbHost'						=> '데이터베이스 호스트',
'DbHostDesc'					=> '데이터베이스 서버가 실행되는 호스트입니다. 일반적으로 <code>127.0.0.1</code> 또는 <code>localhost</code>입니다(즉, WackoWiki 사이트가 있는 동일한 컴퓨터입니다).',
'DbPort'						=> '포트 (선택 과목)',
'DbPortDesc'					=> '데이터베이스 서버에 접속하는 데 사용하는 포트 번호입니다. 기본 포트 번호를 사용하려면 비워 두십시오.',
'DbName'						=> '데이터베이스 이름',
'DbNameDesc'					=> 'WackoWiki에서 사용할 데이터베이스입니다. 계속 진행하기 전에 이 데이터베이스가 이미 존재해야 합니다!',
'DbNameSqliteDesc'				=> 'WackoWiki에 사용할 SQLite의 데이터 디렉터리 및 파일 이름입니다.',
'DbNameSqliteHelp'				=> 'SQLite는 모든 데이터를 단일 파일에 저장합니다.<br><br>설치 중에 웹 서버에서 해당 디렉터리에 쓰기 권한이 있어야 합니다.<br><br>웹을 통해 접근할 수 없어야 합니다.<br><br>설치 프로그램은 <code>.htaccess</code> 파일을 함께 생성하지만, 이 과정이 실패할 경우 누군가가 원시 데이터베이스에 접근할 수 있습니다.<br>여기에는 원시 사용자 데이터(이메일 주소, 해시된 비밀번호)뿐만 아니라 보호된 페이지 및 위키의 기타 제한된 데이터가 포함됩니다.<br><br>데이터베이스를 다른 위치, 예를 들어 <code>/var/lib/wackowiki/yourwiki</code>에 저장하는 것을 고려해 보세요.',
'DbUser'						=> '사용자 이름',
'DbUserDesc'					=> '데이터베이스에 연결하는 데 사용된 사용자 이름입니다.',
'DbPassword'					=> '암호',
'DbPasswordDesc'				=> '데이터베이스에 접속하는 데 사용된 사용자의 비밀번호입니다.',
'Prefix'						=> '테이블 접두어',
'PrefixDesc'					=> 'WackoWiki에서 사용하는 모든 테이블의 접두사입니다. 이를 통해 서로 다른 테이블 접두사(예: wacko_)를 사용하도록 구성함으로써 동일한 데이터베이스를 사용하는 여러 WackoWiki 설치를 실행할 수 있습니다.',
'ErrorNoDbDriverDetected'		=> '데이터베이스 드라이버가 감지되지 않았습니다. php.ini 파일에서 mysqli 또는 pdo_mysql 확장 기능을 활성화하십시오.',
'ErrorNoDbDriverSelected'		=> '데이터베이스 드라이버가 선택되지 않았습니다. 목록에서 선택하세요.',
'DeleteTables'					=> 'Delete Existing Tables?',
'DeleteTablesDesc'				=> '주의! 이 옵션을 선택하여 진행하시면 현재 위키 데이터가 데이터베이스에서 모두 삭제됩니다. 이 작업은 되돌릴 수 없으며, 백업에서 데이터를 수동으로 복원해야 합니다.',
'ConfirmTableDeletion'			=> 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'install-database'				=> '데이터베이스 설치',
'TestingConfiguration'			=> '테스트 구성',
'TestConnectionString'			=> '데이터베이스 연결 설정 테스트',
'TestDatabaseExists'			=> '지정한 데이터베이스가 존재하는지 확인합니다',
'TestDatabaseVersion'			=> '데이터베이스 최소 버전 요구 사항 확인 중',
'SqliteFileExtensionError'		=> '다음 파일 확장자 중 하나를 사용하십시오: db, sdb, sqlite.',
'SqliteParentUnwritableGroup'	=> '<code>%1</code> 데이터 디렉토리를 만들 수 없으며, 이는 웹 서버는 상위 디렉토리인 <code>%2</code>에 쓸 수 없기 때문입니다.<br><br>설치 관리자는 웹 서버로 실행 중인 사용자를 지정할 수 없습니다.<br>계속하려면 웹 서버가 쓸 수 있는 <code>%3</code> 디렉토리를 만드세요.<br>유닉스/리눅스 시스템에서의 수행:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> '<code>%1</code> 데이터 디렉토리를 만들 수 없으며, 이는 웹 서버가 상위 디렉토리인 <code>%2</code>에 쓸 수 없기 때문입니다.<br><br>설치 관리자는 웹 서버로 실행 중인 사용자를 지정할 수 없습니다.<br>계속하려면 웹 서버(와 그 외 서버!)가 전역으로 쓸 수 있는 <code>%3</code> 디렉토리를 만드세요.<br>유닉스/리눅스 시스템에서의 수행:<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> '<code>%1</code> 데이터 디렉터리를 만드는 도중 오류가 발생했습니다.<br>경로를 확인하고 다시 시도하세요.',
'SqliteDirUnwritable'			=> '<code>%1</code> 디렉토리에 쓸 수 없습니다.\n웹 서버를 쓸 수 있도록 권한을 바꾸고 다시 시도하세요.',
'SqliteReadonly'				=> '<code>%1</code> 파일은 쓸 수 없습니다.',
'SqliteCantCreateDb'			=> '<code>%1</code> 데이터베이스 파일을 만들 수 없습니다.',
'InstallTables'					=> 'Installing Tables',
'ErrorDbConnection'				=> '지정하신 데이터베이스 연결 정보에 문제가 있습니다. 다시 확인하시어 정확한지 확인해 주십시오.',
'ErrorDatabaseVersion'			=> '데이터베이스 버전은 %1이지만 최소 %2가 필요합니다.',
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
'ErrorDeletingTable'			=> 'Error deleting %1 table. The most likely reason is that the table does not exist, in which case you can ignore this warning.',
'DeletingTable'					=> 'Deleting %1 table',
'NextStep'						=> '다음 단계에서 설치 프로그램은 업데이트된 구성 파일인 %1을 작성하려고 시도합니다. 웹 서버가 해당 파일에 대한 쓰기 권한을 가지고 있는지 확인하십시오. 그렇지 않으면 수동으로 파일을 편집해야 합니다. 자세한 내용은 <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>을 참조하십시오.',

/*
   Write Config Page
*/
'write-config'					=> '구성 파일 작성',
'FinalStep'						=> '마지막 단계',
'Writing'						=> '구성 파일 작성',
'RemovingWritePrivilege'		=> 'Removing Write Privilege',
'InstallationComplete'			=> '설치 완료',
'ThatsAll'						=> '그게 다예요! 이제 <a href="%1">WackoWiki 사이트를 볼 수 있습니다</a>.',
'SecurityConsiderations'		=> '보안 고려 사항',
'SecurityRisk'					=> '%1 파일에 쓰기 권한이 부여된 상태이므로 즉시 해당 권한을 제거하시기 바랍니다. 파일을 쓰기 가능 상태로 방치하면 보안 위험이 발생할 수 있습니다!<br>예: %2',
'RemoveSetupDirectory'			=> '설치 과정이 완료되었으므로 %1 디렉토리를 삭제해야 합니다.',
'ErrorGivePrivileges'			=> '구성 파일 %1을 작성할 수 없습니다. 웹 서버에 WackoWiki 디렉터리 또는 %1<br>%2라는 빈 파일에 대한 임시 쓰기 권한을 부여해야 합니다.<br><br>나중에 다시 쓰기 권한을 제거하는 것을 잊지 마십시오. 즉, <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> '어떤 이유로든 이 작업을 수행할 수 없다면, 아래 텍스트를 새 파일에 복사하여 WackoWiki 디렉터리에 %1로 저장/업로드해야 합니다. 이 작업을 완료하면 WackoWiki 사이트가 정상 작동할 것입니다. 그렇지 않다면, <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>을 방문해 주세요',
'ErrorPrivilegesUpgrade'		=> '이 작업을 완료하면 WackoWiki 사이트가 정상 작동할 것입니다. 그렇지 않은 경우 <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/Upgrade</a>를 방문해 주세요',
'WrittenAt'						=> '작성됨 ',
'DontChange'					=> 'wacko_version을 수동으로 변경하지 마세요!',
'ConfigDescription'				=> '상세 설명: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> '다시 시도하십시오',

];
