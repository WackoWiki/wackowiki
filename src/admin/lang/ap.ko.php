<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> '기본 기능',
		'preferences'	=> '환경설정',
		'content'		=> '콘텐츠',
		'users'			=> '사용자',
		'maintenance'	=> '유지',
		'messages'		=> '메시지',
		'extension'		=> '확장 기능',
		'database'		=> '데이터베이스',
	],

	// Admin panel
	'AdminPanel'				=> '관리자 제어판',
	'RecoveryMode'				=> '복구 모드',
	'Authorization'				=> '권한 부여',
	'AuthorizationTip'			=> '관리자 비밀번호를 입력해 주세요 (브라우저에서 쿠키가 허용되어 있는지 확인해 주세요).',
	'NoRecoveryPassword'		=> '관리자 비밀번호가 지정되지 않았습니다!',
	'NoRecoveryPasswordTip'		=> '참고: 관리 비밀번호가 없으면 보안에 위협이 됩니다! 구성 파일에 비밀번호 해시를 입력하고 프로그램을 다시 실행하세요.',

	'ErrorLoadingModule'		=> '관리자 모듈 %1을 로드하는 중 오류 발생: 해당 모듈이 존재하지 않습니다.',

	'ApHomePage'				=> '홈페이지',
	'ApHomePageTip'				=> '홈페이지를 열어 관리 화면에서 벗어나지 않습니다',
	'ApLogOut'					=> '로그아웃',
	'ApLogOutTip'				=> '시스템 관리 종료',

	'TimeLeft'					=> '남은 시간:  %1분',
	'ApVersion'					=> '버전',

	'SiteOpen'					=> 'Open',
	'SiteOpened'				=> 'site opened',
	'SiteOpenedTip'				=> 'The site is open',
	'SiteClose'					=> 'Close',
	'SiteClosed'				=> 'site closed',
	'SiteClosedTip'				=> 'The site is closed',

	'System'					=> '시스템',

	// Generic
	'Cancel'					=> '취소',
	'Add'						=> '추가',
	'Edit'						=> '편집',
	'Remove'					=> '제거',
	'Enabled'					=> '사용',
	'Disabled'					=> '비활성화됨',
	'Mandatory'					=> '필수적인',
	'Admin'						=> '관리',
	'Min'						=> 'Min',
	'Max'						=> 'Max',

	'MiscellaneousSection'		=> 'Miscellaneous',
	'MainSection'				=> '일반 옵션',

	'DirNotWritable'			=> '%1 디렉터리에 쓰기 권한이 없습니다.',
	'FileNotWritable'			=> '%1 파일에 쓰기 권한이 없습니다.',

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
		'name'		=> '기본',
		'title'		=> '기본 설정',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> '보이기',
		'title'		=> '외관 설정',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> '이메일 주소',
		'title'		=> '이메일 설정',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> '신디케이트 조직',
		'title'		=> '신디케이션',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> '필터',
		'title'		=> '필터 설정',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> '포맷터',
		'title'		=> '서식 옵션',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> '알림',
		'title'		=> '알림 설정',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> '페이지',
		'title'		=> '페이지 및 사이트 매개변수',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> '사용자 권한',
		'title'		=> '권한 설정',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> '보안',
		'title'		=> '보안 하위 시스템 설정',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> '시스템',
		'title'		=> '시스템 옵션',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> '올리기',
		'title'		=> '첨부 파일 설정',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> '삭제됨',
		'title'		=> '새로 삭제된 콘텐츠',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> '메뉴',
		'title'		=> '기본 메뉴 항목을 추가, 편집 또는 삭제합니다',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> '지원',
		'title'		=> '데이터 백업',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> '수리하다',
		'title'		=> '데이터베이스 복구 및 최적화',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> '복구',
		'title'		=> '백업 데이터 복원 중',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> '재생 메뉴',
		'title'		=> 'WackoWiki 관리자',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> '불일치',
		'title'		=> '데이터 불일치 수정',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> '데이터 동기화',
		'title'		=> '데이터 동기화',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> '회람',
		'title'		=> '대량 이메일',
	],

	// System message module
	'messages'		=> [
		'name'		=> '시스템 메시지',
		'title'		=> '시스템 메시지',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> '시스템 정보',
		'title'		=> '시스템 정보',
	],

	// System log module
	'system_log'		=> [
		'name'		=> '시스템 로그',
		'title'		=> '시스템 이벤트 로그',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> '통계',
		'title'		=> '통계 보기',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Bad Behaviour',
		'title'		=> 'Bad Behaviour',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> '승인',
		'title'		=> '사용자 등록 승인',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> '그룹',
		'title'		=> '그룹 관리',
	],

	// User module
	'user_users'		=> [
		'name'		=> '사용자',
		'title'		=> '사용자 관리',
	],

	// Main module
	'MainNote'					=> '참고: 관리 작업을 위해 사이트 접근을 일시적으로 차단하는 것을 권장합니다.',

	'PurgeSessions'				=> '세션 정리',
	'PurgeSessionsTip'			=> '모든 세션 정리',
	'PurgeSessionsConfirm'		=> '정말로 모든 세션을 정리하시겠습니까? 이 작업을 하면 모든 사용자가 로그아웃됩니다.',
	'PurgeSessionsExplain'		=> 'auth_token 테이블을 비워 모든 세션을 정리합니다. 이로 인해 모든 사용자가 로그아웃됩니다.',
	'PurgeSessionsDone'			=> '세션이 성공적으로 정리되었습니다.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> '기본 설정이 업데이트되었습니다',
	'LogBasicSettingsUpdated'	=> '기본 설정이 업데이트되었습니다',

	'SiteName'					=> '사이트 이름:',
	'SiteNameInfo'				=> '이 사이트의 제목입니다. 브라우저 탭 제목, 테마 헤더, 이메일 알림 등에 표시됩니다.',
	'SiteDesc'					=> '사이트 설명:',
	'SiteDescInfo'				=> '페이지 헤더에 표시되는 사이트 제목의 보충 설명입니다. 몇 마디로 이 사이트가 무엇인지 설명합니다.',
	'AdminName'					=> '사이트 관리자:',
	'AdminNameInfo'				=> '사이트 전반에 대한 책임을 지는 사용자의 사용자 이름입니다. 이 이름으로 접근 권한을 결정하진 않지만, 최고 관리자 명칭과 일치하는 것이 바람직합니다.',

	'LanguageSection'			=> '언어',
	'DefaultLanguage'			=> '기본 언어:',
	'DefaultLanguageInfo'		=> '등록하지 않은 방문자에게 표시되는 메시지의 언어와 로케일 설정을 지정합니다.',
	'MultiLanguage'				=> '다국어 지원:',
	'MultiLanguageInfo'			=> '페이지별로 언어를 선택할 수 있도록 기능을 활성화합니다.',
	'AllowedLanguages'			=> '허용 언어:',
	'AllowedLanguagesInfo'		=> '사용하려는 언어만 선택하는 것이 좋습니다. 그렇지 않으면 모든 언어가 선택됩니다.',

	'CommentSection'			=> '댓글',
	'AllowComments'				=> '댓글 허용:',
	'AllowCommentsInfo'			=> '비회원 및 등록 사용자 모두에게 댓글 허용, 등록 사용자만 허용 또는 사이트 전체에서 댓글 비활성화 중에서 선택합니다.',
	'SortingComments'			=> '댓글 정렬:',
	'SortingCommentsInfo'		=> '페이지 댓글이 표시되는 순서를 변경합니다. 최신 댓글 또는 가장 오래된 댓글을 상단에 표시할 수 있습니다.',
	'CommentsOffset'			=> '댓글 페이지:',
	'CommentsOffsetInfo'		=> '기본적으로 표시되는 댓글 페이지',

	'ToolbarSection'			=> '도구 모음',
	'CommentsPanel'				=> '댓글 판넬:',
	'CommentsPanelInfo'			=> '페이지 하단에 댓글을 기본으로 표시합니다.',
	'FilePanel'					=> '파일 판넬:',
	'FilePanelInfo'				=> '페이지 하단에 첨부파일을 기본으로 표시합니다.',
	'TagsPanel'					=> '태그 판넬:',
	'TagsPanelInfo'				=> '페이지 하단에 태그 판넬을 기본으로 표시합니다.',

	'NavigationSection'			=> '네비게이션',
	'ShowPermalink'				=> '고유 링크 표시:',
	'ShowPermalinkInfo'			=> '현재 버전의 페이지에 대한 고유 링크를 기본으로 표시합니다.',
	'TocPanel'					=> '목차 판넬:',
	'TocPanelInfo'				=> '페이지의 목차 판넬을 기본으로 표시합니다(템플릿 지원 필요할 수 있음).',
	'SectionsPanel'				=> '섹션 판넬:',
	'SectionsPanelInfo'			=> '기본적으로 인접한 페이지의 판넬을 표시합니다(템플릿의 지원 필요).',
	'DisplayingSections'		=> '섹션 표시 방식:',
	'DisplayingSectionsInfo'	=> '이전 옵션이 설정되었을 때 하위 페이지만(<em>lower</em>), 인접 페이지만(<em>top</em>), 둘 다 또는 트리 구조로(<em>tree</em>) 표시할지 여부를 정합니다.',
	'MenuItems'					=> '메뉴 항목:',
	'MenuItemsInfo'				=> '표시할 기본 메뉴 항목 수(템플릿 지원이 필요할 수 있음).',

	'HandlerSection'			=> '핸들러',
	'HideRevisions'				=> '개정판 숨기기:',
	'HideRevisionsInfo'			=> '페이지의 개정판(수정 이력)을 기본으로 숨깁니다.',
	'AttachmentHandler'			=> '첨부파일 핸들러 활성화:',
	'AttachmentHandlerInfo'		=> '첨부파일 핸들러의 표시를 허용합니다.',
	'SourceHandler'				=> '소스 핸들러 활성화:',
	'SourceHandlerInfo'			=> '소스 핸들러의 표시를 허용합니다.',
	'ExportHandler'				=> 'XML 내보내기 핸들러 활성화:',
	'ExportHandlerInfo'			=> 'XML 내보내기 핸들러의 표시를 허용합니다.',

	'DiffModeSection'			=> '차이 비교 모드',
	'DefaultDiffModeSetting'	=> '기본 비교 모드:',
	'DefaultDiffModeSettingInfo'=> '사전 선택된 비교 모드입니다.',
	'AllowedDiffMode'			=> '허용된 비교 모드:',
	'AllowedDiffModeInfo'		=> '사용하려는 비교 모드만 선택하는 것이 권장됩니다. 그렇지 않으면 모든 모드가 선택됩니다.',
	'NotifyDiffMode'			=> '알림 비교 모드:',
	'NotifyDiffModeInfo'		=> '이메일 본문에 사용되는 비교 모드입니다.',

	'EditingSection'			=> '편집',
	'EditSummary'				=> '편집 요약:',
	'EditSummaryInfo'			=> '편집 모드에서 변경 요약을 표시합니다.',
	'MinorEdit'					=> '사소한 변경:',
	'MinorEditInfo'				=> '편집 모드에서 사소한 변경 옵션을 활성화합니다.',
	'SectionEdit'				=> '섹션 편집:',
	'SectionEditInfo'			=> '페이지의 특정 섹션만 편집할 수 있도록 합니다.',
	'ReviewSettings'			=> '검토:',
	'ReviewSettingsInfo'		=> '편집 모드에서 검토 옵션을 활성화합니다.',
	'PublishAnonymously'		=> '익명 게시 허용:',
	'PublishAnonymouslyInfo'	=> '사용자가 이름을 숨기고 익명으로 게시할 수 있게 허용합니다.',

	'DefaultRenameRedirect'		=> '이름 변경 시 리다이렉트 생성:',
	'DefaultRenameRedirectInfo'	=> '기본적으로 페이지 이름을 변경할 때 이전 주소로의 리다이렉트를 설정하도록 제안합니다.',
	'StoreDeletedPages'			=> '삭제된 페이지 보관:',
	'StoreDeletedPagesInfo'		=> '페이지, 댓글 또는 파일을 삭제하면 일정 기간 검토 및 복구할 수 있도록 별도 섹션에 보관합니다(아래에 설명된 대로).',
	'KeepDeletedTime'			=> '삭제된 항목 보관 기간:',
	'KeepDeletedTimeInfo'		=> '일 단위 기간입니다. 이전 옵션과 함께만 의미가 있습니다. 영구 보관하려면 0을 사용하세요(이 경우 관리자가 수동으로 "휴지통"을 비울 수 있습니다).',
	'PagesPurgeTime'			=> '페이지 개정판 보관 기간:',
	'PagesPurgeTimeInfo'		=> '지정한 일수보다 오래된 버전을 자동으로 삭제합니다. 0을 입력하면 오래된 버전이 제거되지 않습니다.',
	'EnableReferrers'			=> '리퍼러 활성화:',
	'EnableReferrersInfo'		=> '외부 리퍼러의 생성 및 표시를 허용합니다.',
	'ReferrersPurgeTime'		=> '리퍼러 보관 기간:',
	'ReferrersPurgeTimeInfo'	=> '외부 참조 페이지의 기록을 지정한 일수보다 오래 보관하지 않습니다. 리퍼러를 절대 삭제하지 않으려면 0을 사용하세요(단, 방문이 많은 사이트에서는 데이터베이스가 과부하될 수 있습니다).',
	'EnableCounters'			=> '조회수 카운터:',
	'EnableCountersInfo'		=> '페이지별 조회수 카운터를 허용하고 간단한 통계 표시를 활성화합니다. 페이지 소유자의 조회는 카운트되지 않습니다.',

	// 배포 설정
	'SyndicationSettingsInfo'		=> '사이트의 기본 웹 배포(syndication) 설정을 제어합니다.',
	'SyndicationSettingsUpdated'	=> '배포 설정이 업데이트되었습니다.',
	'FeedsSection'				=> '피드',
	'EnableFeeds'				=> '피드 사용:',
	'EnableFeedsInfo'			=> '위키 전체에 대해 RSS 피드를 켜거나 끕니다.',
	'XmlChangeLink'				=> '변경 피드 링크 모드:',
	'XmlChangeLinkInfo'			=> 'XML 변경(Changes) 피드 항목이 어디로 연결되는지 정의합니다.',
	'XmlChangeLinkMode'			=> [
		'1'		=> '차이 보기',
		'2'		=> '현재 문서',
		'3'		=> '판의 목록',
		'4'		=> '개정된 문서',
	],

	'XmlSitemap'				=> 'XML 사이트맵:',
	'XmlSitemapInfo'			=> 'xml 폴더 안에 %1이라는 XML 파일을 생성합니다. 루트 디렉터리의 robots.txt 파일에 사이트맵 경로를 다음과 같이 추가할 수 있습니다:',
	'XmlSitemapGz'				=> 'XML 사이트맵 압축:',
	'XmlSitemapGzInfo'			=> '원하면 gzip을 사용해 사이트맵 텍스트 파일을 압축하여 대역폭을 줄일 수 있습니다.',
	'XmlSitemapTime'			=> 'XML 사이트맵 생성 주기(일):',
	'XmlSitemapTimeInfo'		=> '지정한 일 수 동안에만 사이트맵을 한 번 생성합니다. 0으로 설정하면 페이지가 변경될 때마다 생성합니다.',

	'SearchSection'				=> '검색',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'XML 폴더에 OpenSearch 설명 파일을 생성하고 HTML 헤더에서 검색 플러그인의 자동 검색(Autodiscovery)을 활성화합니다.',
	'SearchEngineVisibility'	=> '검색 엔진 차단(검색 엔진 가시성):',
	'SearchEngineVisibilityInfo'=> '일반 방문자는 허용하되 검색 엔진을 차단합니다. 페이지 설정을 무시합니다. <br>검색 엔진이 이 사이트를 색인하지 않도록 권장합니다. 이 요청을 검색 엔진이 수락할지는 검색 엔진에 달려 있습니다.',



	// 외형 설정
	'AppearanceSettingsInfo'	=> '사이트의 기본 표시 설정을 제어합니다.',
	'AppearanceSettingsUpdated'	=> '외형 설정이 업데이트되었습니다.',

	'LogoOff'					=> '끄기',
	'LogoOnly'					=> '로고만',
	'LogoAndTitle'				=> '로고와 제목',

	'LogoSection'				=> '로고',
	'SiteLogo'					=> '사이트 로고:',
	'SiteLogoInfo'				=> '로고는 일반적으로 애플리케이션의 왼쪽 상단에 표시됩니다. 최대 크기는 2MiB입니다. 권장 크기는 가로 255픽셀, 세로 55픽셀입니다.',
	'LogoDimensions'			=> '로고 크기:',
	'LogoDimensionsInfo'		=> '표시되는 로고의 너비와 높이입니다.',
	'LogoDisplayMode'			=> '로고 표시 모드:',
	'LogoDisplayModeInfo'		=> '로고의 표시 방식을 정의합니다. 기본값은 끔입니다.',

	'FaviconSection'			=> '파비콘',
	'SiteFavicon'				=> '사이트 파비콘:',
	'SiteFaviconInfo'			=> '바로가기 아이콘(파비콘)은 대부분의 브라우저 주소 표시줄, 탭 및 북마크에 표시됩니다. 이 설정은 테마의 파비콘을 덮어씁니다.',
	'SiteFaviconTooBig'			=> '파비콘이 64 × 64 px보다 큽니다.',
	'ThemeColor'				=> '주소 표시줄 테마 색상:',
	'ThemeColorInfo'			=> '브라우저는 제공된 CSS 색상에 따라 모든 페이지의 주소 표시줄 색상을 설정합니다.',

	'LayoutSection'				=> '레이아웃',
	'Theme'						=> '테마:',
	'ThemeInfo'					=> '사이트가 기본으로 사용하는 템플릿 디자인입니다.',
	'ResetUserTheme'			=> '모든 사용자 테마 재설정:',
	'ResetUserThemeInfo'		=> '모든 사용자 테마를 재설정합니다. 경고: 이 작업을 실행하면 사용자가 선택한 모든 테마가 전역 기본 테마로 되돌아갑니다.',
	'SetBackUserTheme'			=> '모든 사용자 테마를 %1 테마로 되돌립니다.',
	'ThemesAllowed'				=> '허용되는 테마:',
	'ThemesAllowedInfo'			=> '사용자가 선택할 수 있는 허용 테마를 선택합니다. 선택하지 않으면 사용 가능한 모든 테마가 허용됩니다.',
	'ThemesPerPage'				=> '페이지별 테마 허용:',
	'ThemesPerPageInfo'			=> '페이지 소유자가 페이지 속성을 통해 선택할 수 있는 페이지별 테마를 허용합니다.',

	// 시스템 설정
	'SystemSettingsInfo'		=> '사이트를 세부 조정하는 매개변수 그룹입니다. 내용에 확신이 없다면 변경하지 마십시오.',
	'SystemSettingsUpdated'		=> '시스템 설정이 업데이트되었습니다.',

	'DebugModeSection'			=> '디버그 모드',
	'DebugMode'					=> '디버그 모드:',
	'DebugModeInfo'				=> '애플리케이션 실행 시간에 대한 텔레메트리 데이터를 추출하고 출력합니다. 주의: 전체 상세 모드는 특히 데이터베이스 백업 및 복원과 같은 리소스 집약적 작업에서 더 많은 메모리를 요구합니다.',
	'DebugModes'	=> [
		'0'		=> '디버그 꺼짐',
		'1'		=> '전체 실행 시간만',
		'2'		=> '전체 시간',
		'3'		=> '상세 전체(DBMS, 캐시 등)',
	],
	'DebugSqlThreshold'			=> 'RDBMS 성능 임계값(초):',
	'DebugSqlThresholdInfo'		=> '상세 디버그 모드에서 지정한 초보다 오래 걸리는 쿼리만 보고합니다.',
	'DebugAdminOnly'			=> '관리자 전용 디버깅:',
	'DebugAdminOnlyInfo'		=> '프로그램(및 DBMS)의 디버그 데이터를 관리자에게만 표시합니다.',

	'CachingSection'			=> '캐싱 옵션',
	'Cache'						=> '렌더된 페이지 캐시:',
	'CacheInfo'					=> '렌더된 페이지를 로컬 캐시에 저장하여 이후 로드 속도를 높입니다. 등록되지 않은 방문자에게만 적용됩니다.',
	'CacheTtl'					=> '캐시된 페이지의 유지 시간(초):',
	'CacheTtlInfo'				=> '페이지를 지정한 초 수보다 오래 캐시하지 않습니다.',
	'CacheSql'					=> 'DBMS 쿼리 캐시:',
	'CacheSqlInfo'				=> '특정 리소스 관련 SQL 쿼리 결과의 로컬 캐시를 유지합니다.',
	'CacheSqlTtl'				=> '캐시된 SQL 쿼리의 유지 시간(초):',
	'CacheSqlTtlInfo'			=> 'SQL 쿼리 결과를 지정한 초 수보다 오래 캐시하지 않습니다. 1200을 초과하는 값은 권장되지 않습니다.',

	'LogSection'				=> '로그 설정',
	'LogLevelUsage'				=> '로깅 사용:',
	'LogLevelUsageInfo'			=> '로그에 기록할 이벤트의 최소 우선순위입니다.',
	'LogThresholds'	=> [
		'0'		=> '로그 기록 안 함',
		'1'		=> '치명적 수준만',
		'2'		=> '높은 수준부터',
		'3'		=> '상위 수준부터',
		'4'		=> '보통',
		'5'		=> '낮은 수준부터',
		'6'		=> '최소 수준',
		'7'		=> '모두 기록',
	],
	'LogDefaultShow'			=> '로그 표시 모드:',
	'LogDefaultShowInfo'		=> '기본적으로 로그에 표시할 최소 우선순위 이벤트입니다.',
	'LogModes'	=> [
		'1'		=> '치명적 수준만',
		'2'		=> '높은 수준부터',
		'3'		=> '상위 수준부터',
		'4'		=> '보통',
		'5'		=> '낮은 수준부터',
		'6'		=> '최소 수준부터',
		'7'		=> '모두 표시',
	],
	'LogPurgeTime'				=> '로그 보관 기간(일):',
	'LogPurgeTimeInfo'			=> '지정한 일 수가 지난 이벤트 로그를 제거합니다.',

	'PrivacySection'			=> '개인정보처리방침',
	'AnonymizeIp'				=> '사용자 IP 주소 익명화:',
	'AnonymizeIpInfo'			=> '해당되는 경우(IP가 저장되는 페이지, 판, 유입 경로 등) IP 주소를 익명화합니다.',

	'ReverseProxySection'		=> '리버스 프록시',
	'ReverseProxy'				=> '리버스 프록시 사용:',
	'ReverseProxyInfo'			=> '이 설정을 활성화하면 X-Forwarded-For 헤더에 저장된 정보를 검사하여 원격 클라이언트의 올바른 IP 주소를 결정합니다. X-Forwarded-For 헤더는 Squid나 Pound 같은 리버스 프록시 서버를 통해 연결되는 클라이언트를 식별하는 표준 메커니즘입니다. 리버스 프록시는 트래픽이 많은 사이트의 성능을 향상시키고 캐싱, 보안 또는 암호화 등의 이점을 제공할 수 있습니다. 이 WackoWiki 설치가 리버스 프록시 뒤에서 운영되는 경우 세션 관리, 로깅, 통계 및 접근 관리 시스템에 올바른 IP 주소 정보가 수집되도록 이 설정을 활성화해야 합니다. 설정이 확실하지 않거나 리버스 프록시를 사용하지 않거나 WackoWiki가 공유 호스팅 환경에서 작동하는 경우 이 설정은 비활성으로 두어야 합니다.',
	'ReverseProxyHeader'		=> '리버스 프록시 헤더:',
	'ReverseProxyHeaderInfo'	=> '프록시 서버가 클라이언트 IP를 X-Forwarded-For 이외의 헤더에 보낼 경우 이 값을 설정하십시오. "X-Forwarded-For" 헤더는 쉼표로 구분된 IP 주소 목록입니다; 가장 오른쪽(가장 왼쪽?)이 아닌, 마지막이 아닌 첫 번째(왼쪽에서 가장 첫번째)만 사용됩니다.',
	'ReverseProxyAddresses'		=> 'reverse_proxy가 허용하는 IP 주소 배열:',
	'ReverseProxyAddressesInfo'	=> '이 배열의 각 요소는 리버스 프록시 서버의 IP 주소입니다. 이 배열을 사용하는 경우 요청이 웹 서버에 도달한 원격 IP 주소가 이들 중 하나일 때만 X-Forwarded-For 헤더에 저장된 정보를 신뢰합니다. 그렇지 않으면 클라이언트가 X-Forwarded-For 헤더를 위조하여 웹 서버에 직접 접속할 수 있습니다.',

	'SessionSection'				=> '세션 처리',
	'SessionStorage'				=> '세션 저장소:',
	'SessionStorageInfo'			=> '이 옵션은 세션 데이터를 어디에 저장할지 정의합니다. 기본적으로 파일 또는 데이터베이스 세션 저장소 중 하나가 선택됩니다.',
	'SessionModes'	=> [
		'1'		=> '파일',
		'2'		=> '데이터베이스',
	],

	'SessionNotice'					=> '세션 종료 원인 표시:',
	'SessionNoticeInfo'				=> '세션 종료의 원인을 나타냅니다.',
	'LoginNotice'					=> '로그인 알림:',
	'LoginNoticeInfo'				=> '로그인 알림: 로그인 알림을 표시합니다.',

	'RewriteMode'					=> '<code>mod_rewrite</code> 사용:',
	'RewriteModeInfo'				=> '웹 서버가 이 기능을 지원하면 페이지 URL을 "보기 좋게" 만들기 위해 활성화하세요.<br>
										<span class="cite">HTTP_MOD_REWRITE가 켜져 있으면, 이 값은 런타임에 Settings 클래스에 의해 꺼져 있더라도 덮어써질 수 있습니다.</span>',

	// 권한 설정
	'PermissionsSettingsInfo'		=> '접근 제어 및 권한에 대한 설정입니다.',
	'PermissionsSettingsUpdated'	=> '권한 설정이 업데이트되었습니다',

	'PermissionsSection'		=> '권한 및 권한 부여',
	'ReadRights'				=> '기본 읽기 권한:',
	'ReadRightsInfo'			=> '생성된 루트 페이지 및 부모 ACL을 정의할 수 없는 페이지에 기본으로 할당되는 권한입니다.',
	'WriteRights'				=> '기본 쓰기 권한:',
	'WriteRightsInfo'			=> '생성된 루트 페이지 및 부모 ACL을 정의할 수 없는 페이지에 기본으로 할당되는 권한입니다.',
	'CommentRights'				=> '기본 댓글 권한:',
	'CommentRightsInfo'			=> '생성된 루트 페이지 및 부모 ACL을 정의할 수 없는 페이지에 기본으로 할당되는 권한입니다.',
	'CreateRights'				=> '하위 페이지 생성 기본 권한:',
	'CreateRightsInfo'			=> '생성된 하위 페이지에 기본으로 할당되는 권한입니다.',
	'UploadRights'				=> '기본 업로드 권한:',
	'UploadRightsInfo'			=> '기본 업로드 권한입니다.',
	'RenameRights'				=> '전역 이름 변경 권한:',
	'RenameRightsInfo'			=> '페이지를 자유롭게 이름 변경(또는 이동)할 수 있는 권한 목록입니다.',

	'LockAcl'					=> '모든 ACL을 읽기 전용으로 잠그기:',
	'LockAclInfo'				=> '<span class="cite">모든 페이지의 ACL 설정을 읽기 전용으로 덮어씁니다.</span><br>프로젝트가 완료되었거나 일정 기간 편집을 제한해 보안상 닫아야 할 때, 또는 취약점 대응 등의 비상 상황에서 유용합니다.',
	'HideLocked'				=> '접근 불가능한 페이지 숨기기:',
	'HideLockedInfo'			=> '사용자가 페이지를 읽을 권한이 없으면 다양한 페이지 목록에서 해당 페이지를 숨깁니다(단, 본문에 삽입된 링크는 여전히 표시될 수 있습니다).',
	'RemoveOnlyAdmins'			=> '페이지를 삭제할 수 있는 권한을 관리자만 허용:',
	'RemoveOnlyAdminsInfo'		=> '관리자 이외의 모든 사용자에게 페이지 삭제를 금지합니다. 이 제한은 일반 페이지 소유자에게도 적용됩니다.',
	'OwnersRemoveComments'		=> '페이지 소유자가 댓글을 삭제할 수 있음:',
	'OwnersRemoveCommentsInfo'	=> '페이지 소유자가 자신의 페이지에 대한 댓글을 관리(삭제)할 수 있도록 허용합니다.',
	'OwnersEditCategories'		=> '소유자가 페이지 카테고리를 편집할 수 있음:',
	'OwnersEditCategoriesInfo'	=> '소유자가 해당 페이지에 할당된 카테고리 목록을 수정(단어 추가, 삭제)할 수 있도록 허용합니다.',
	'TermHumanModeration'		=> '인간 검토 만료 기간:',
	'TermHumanModerationInfo'	=> '중재자는 작성된 지 이 일수 이내인 댓글만 편집할 수 있습니다(이 제한은 해당 주제의 마지막 댓글에는 적용되지 않습니다).',

	'UserCanDeleteAccount'		=> '사용자가 자신의 계정을 삭제할 수 있도록 허용',

	// 보안 설정
	'SecuritySettingsInfo'		=> '플랫폼 전반의 안전성, 보안 제한 및 추가 보안 서브시스템에 관한 설정입니다.',
	'SecuritySettingsUpdated'	=> '보안 설정이 업데이트되었습니다',

	'AllowRegistration'			=> '온라인 가입 허용:',
	'AllowRegistrationInfo'		=> '사용자 등록을 열지 여부입니다. 이 옵션을 비활성화하면 일반 사용자의 자유로운 가입이 차단되지만, 사이트 관리자는 여전히 사용자를 등록할 수 있습니다.',
	'ApproveNewUser'			=> '신규 사용자 승인:',
	'ApproveNewUserInfo'		=> '사용자가 등록하면 관리자가 승인해야 로그인할 수 있도록 합니다. 승인된 사용자만 사이트에 로그인할 수 있습니다.',
	'PersistentCookies'			=> '영구 쿠키:',
	'PersistentCookiesInfo'		=> '영구 쿠키를 허용합니다.',
	'DisableWikiName'			=> 'WikiName 비활성화:',
	'DisableWikiNameInfo'		=> '사용자에 대해 WikiName 사용을 강제하지 않습니다. 강제된 CamelCase 형식(예: NameSurname) 대신 일반 닉네임으로 사용자 등록을 허용합니다.',
	'UsernameLength'			=> '사용자 이름 길이:',
	'UsernameLengthInfo'		=> '사용자 이름의 최소 및 최대 문자 수입니다.',

	'EmailSection'				=> '이메일 주소',
	'AllowEmailReuse'			=> '이메일 주소 재사용 허용:',
	'AllowEmailReuseInfo'		=> '서로 다른 사용자가 동일한 이메일 주소로 가입할 수 있습니다.',
	'EmailConfirmation'			=> '이메일 확인 적용:',
	'EmailConfirmationInfo'		=> '사용자가 로그인하기 전에 이메일 주소를 확인하도록 요구합니다.',
	'AllowedEmailDomains'		=> '허용된 이메일 도메인:',
	'AllowedEmailDomainsInfo'	=> '쉼표로 구분된 허용 이메일 도메인(예: <code>example.com, local.lan</code>)을 지정합니다. 비워두면 모든 이메일 도메인이 허용됩니다.',
	'ForbiddenEmailDomains'		=> '금지된 이메일 도메인:',
	'ForbiddenEmailDomainsInfo'	=> '쉼표로 구분된 금지 이메일 도메인(예: <code>example.com, local.lan</code>)을 지정합니다. 허용된 이메일 도메인 목록이 비어 있을 때만 적용됩니다.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> '캡차 활성화:',
	'EnableCaptchaInfo'			=> '활성화하면 보안 임계값에 도달했거나 다음의 경우에 캡차가 표시됩니다.',
	'CaptchaComment'			=> '새 댓글:',
	'CaptchaCommentInfo'		=> '스팸 방지를 위해 비회원은 댓글을 게시하기 전에 캡차를 완료해야 합니다.',
	'CaptchaPage'				=> '새 페이지:',
	'CaptchaPageInfo'			=> '스팸 방지를 위해 비회원은 새 페이지를 생성하기 전에 캡차를 완료해야 합니다.',
	'CaptchaEdit'				=> '페이지 편집:',
	'CaptchaEditInfo'			=> '스팸 방지를 위해 비회원은 페이지를 편집하기 전에 캡차를 완료해야 합니다.',
	'CaptchaRegistration'		=> '계정 생성',
	'CaptchaRegistrationInfo'	=> '스팸 방지를 위해 비회원은 등록하기 전에 캡차를 완료해야 합니다.',

	'TlsSection'				=> 'TLS 설정',
	'TlsConnection'				=> 'TLS 연결:',
	'TlsConnectionInfo'			=> 'TLS로 보호된 연결을 사용합니다. <span class="cite">서버에 미리 설치된 TLS 인증서를 활성화하지 않으면 관리자 패널에 대한 접근을 잃게 됩니다!</span><br>또한 쿠키의 Secure 플래그 설정 여부를 결정합니다: <code>secure</code> 플래그는 쿠키가 안전한 연결에서만 전송되어야 하는지를 지정합니다.',
	'TlsImplicit'				=> '강제 TLS:',
	'TlsImplicitInfo'			=> '클라이언트를 HTTP에서 HTTPS로 강제로 재연결합니다. 이 옵션이 비활성화되면 클라이언트는 열린 HTTP 채널을 통해 사이트를 조회할 수 있습니다.',

	'HttpSecurityHeaders'		=> 'HTTP 보안 헤더',
	'EnableSecurityHeaders'		=> '보안 헤더 활성화:',
	'EnableSecurityHeadersinfo'	=> '보안 헤더(프레임 차단, 클릭재킹/XSS/CSRF 방지)를 설정합니다. <br>CSP는 특정 상황(예: 개발 중)이거나 외부에 호스팅된 이미지나 스크립트 등에 의존하는 플러그인을 사용할 때 문제가 될 수 있습니다. <br>콘텐츠 보안 정책을 비활성화하는 것은 보안상 위험합니다!',
	'Csp'						=> '콘텐츠 보안 정책(CSP):',
	'CspInfo'					=> 'CSP를 구성하려면 적용하려는 정책을 결정한 뒤 해당 정책을 설정하고 Content-Security-Policy 헤더를 사용해 정책을 적용해야 합니다.',
	'PolicyModes'	=> [
		'0'		=> '비활성화됨',
		'1'		=> '엄격',
		'2'		=> '사용자 정의',
	],
	'PermissionsPolicy'			=> '권한 정책:',
	'PermissionsPolicyInfo'		=> 'HTTP Permissions-Policy 헤더는 다양한 강력한 브라우저 기능을 명시적으로 활성화하거나 비활성화하는 메커니즘을 제공합니다.',
	'ReferrerPolicy'			=> '리퍼러 정책:',
	'ReferrerPolicyInfo'		=> 'Referrer-Policy HTTP 헤더는 응답에 포함될 Referer 헤더의 리퍼러 정보를 제어합니다.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[비활성]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> '사용자 비밀번호 보존',
	'PwdMinChars'				=> '최소 비밀번호 길이:',
	'PwdMinCharsInfo'			=> '길이가 긴 비밀번호가 짧은 비밀번호보다 더 안전합니다(예: 12~16자).<br>비밀번호 대신 문구(passphrase)를 사용하는 것을 권장합니다.',
	'AdminPwdMinChars'			=> '관리자 최소 비밀번호 길이:',
	'AdminPwdMinCharsInfo'		=> '길이가 긴 비밀번호가 짧은 비밀번호보다 더 안전합니다(예: 15~20자).<br>비밀번호 대신 문구(passphrase)를 사용하는 것을 권장합니다.',
	'PwdCharComplexity'			=> '요구되는 비밀번호 복잡성:',
	'PwdCharClasses'	=> [
		'0'		=> '검사 안 함',
		'1'		=> '문자 + 숫자 허용',
		'2'		=> '대소문자 + 숫자',
		'3'		=> '대소문자 + 숫자 + 특수문자',
	],
	'PwdUnlikeLogin'			=> '추가 제한:',
	'PwdUnlikes'	=> [
		'0'		=> '검사 안 함',
		'1'		=> '비밀번호가 로그인명과 동일하지 않음',
		'2'		=> '비밀번호에 사용자명이 포함되지 않음',
	],

	'LoginSection'				=> '로그인',
	'MaxLoginAttempts'			=> '사용자명당 최대 로그인 시도 횟수:',
	'MaxLoginAttemptsInfo'		=> '스팸봇 방지 작업이 작동되기 전, 단일 계정에 허용되는 로그인 시도 횟수입니다. 서로 다른 사용자 계정에 대해 스팸봇 방지 작업이 작동하지 않게 하려면 0을 입력하세요.',
	'IpLoginLimitMax'			=> 'IP 주소당 최대 로그인 시도 횟수:',
	'IpLoginLimitMaxInfo'		=> '단일 IP 주소에서 허용되는 로그인 시도 횟수 임계값입니다. 이 횟수를 넘기면 스팸봇 방지 작업이 실행됩니다. IP 주소로 인해 스팸봇 방지 작업이 작동하지 않게 하려면 0을 입력하세요.',

	'FormsSection'				=> '폼',
	'FormTokenTime'				=> '폼 제출 최대 시간:',
	'FormTokenTimeInfo'			=> '사용자가 폼을 제출할 수 있는 시간(초)입니다. 세션이 만료되면 이 설정과 관계없이 폼이 무효화될 수 있다는 점을 유의하세요.',

	'SessionLength'				=> '세션 쿠키 만료 기간:',
	'SessionLengthInfo'			=> '사용자 세션 쿠키의 기본 수명(일 단위)입니다.',
	'CommentDelay'				=> '댓글 방지(플러딩) 지연:',
	'CommentDelayInfo'			=> '새 사용자 댓글 게시 사이의 최소 지연 시간(초)입니다.',
	'IntercomDelay'				=> '쪽지 방지(플러딩) 지연:',
	'IntercomDelayInfo'			=> '개인 메시지 전송 사이의 최소 지연 시간(초)입니다.',
	'RegistrationDelay'			=> '회원가입 시간 임계값:',
	'RegistrationDelayInfo'		=> '봇과 사람을 구분하기 위해 회원가입 양식을 작성하는 데 필요한 최소 시간(초)입니다.',

	// Formatter settings
	'FormatterSettingsInfo'		=> '사이트 세부 동작을 조정하는 파라미터 모음입니다. 동작을 확실히 이해하지 못한다면 변경하지 마세요.',
	'FormatterSettingsUpdated'	=> '서식 설정이 업데이트되었습니다',

	'TextHandlerSection'		=> '텍스트 처리기:',
	'Typografica'				=> '타이포그래피 교정:',
	'TypograficaInfo'			=> '이 옵션을 비활성화하면 댓글 추가 및 페이지 저장 속도가 빨라집니다.',
	'Paragrafica'				=> '단락 표시(Paragrafica):',
	'ParagraficaInfo'			=> '앞의 옵션과 유사하지만 작동하지 않는 자동 목차(<code>{{toc}}</code>)가 해제됩니다.',
	'AllowRawhtml'				=> '전체 HTML 사용 허용:',
	'AllowRawhtmlInfo'			=> '이 옵션은 공개 사이트에서는 잠재적으로 안전하지 않을 수 있습니다.',
	'SafeHtml'					=> 'HTML 필터링:',
	'SafeHtmlInfo'				=> '위험한 HTML 요소의 저장을 방지합니다. 공개 사이트에서 HTML 지원을 켠 상태로 필터를 끄는 것은 <span class="underline">매우</span> 바람직하지 않습니다!',

	'WackoFormatterSection'		=> '위키 텍스트 포매터 (Wacko Formatter)',
	'X11colors'					=> 'X11 색상 사용:',
	'X11colorsInfo'				=> '<code>??(color) background??</code> 및 <code>!!(color) text!!</code>에 사용할 수 있는 색상을 확장합니다. 이 옵션을 비활성화하면 댓글 추가 및 페이지 저장 속도가 빨라집니다.',
	'WikiLinks'					=> '위키 링크 비활성화:',
	'WikiLinksInfo'				=> '<code>CamelCaseWords</code>에 대한 자동 연결을 비활성화합니다: CamelCase 단어가 더 이상 새 페이지로 자동 연결되지 않습니다. 서로 다른 네임스페이스/클러스터에서 작업할 때 유용합니다. 기본값은 비활성화입니다.',
	'BracketsLinks'				=> '대괄호 링크 비활성화:',
	'BracketsLinksInfo'			=> '<code>[[link]]</code> 및 <code>((link))</code> 구문을 비활성화합니다.',
	'Formatters'				=> '포매터 비활성화:',
	'FormattersInfo'			=> '하이라이터에 사용되는 <code>%%code%%</code> 구문을 비활성화합니다.',

	'DateFormatsSection'		=> '날짜 형식',
	'DateFormat'				=> '날짜 형식:',
	'DateFormatInfo'			=> '(일, 월, 연)',
	'TimeFormat'				=> '시간 형식:',
	'TimeFormatInfo'			=> '(시, 분)',
	'TimeFormatSeconds'			=> '정확한 시간 형식:',
	'TimeFormatSecondsInfo'		=> '(시, 분, 초)',
	'NameDateMacro'				=> '<code>::@::</code> 매크로 형식:',
	'NameDateMacroInfo'			=> '(이름, 시간), 예: <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> '시간대:',
	'TimezoneInfo'				=> '로그인하지 않은 사용자(게스트)에게 표시할 때 사용할 시간대입니다. 로그인한 사용자는 자신의 사용자 설정에서 시간대를 변경할 수 있습니다.',
	'AmericanDate'					=> '미국식 날짜:',
	'AmericanDateInfo'				=> '영어의 기본으로 미국식 날짜 형식을 사용합니다.',

	'Canonical'					=> '완전 표준(정규) URL 사용:',
	'CanonicalInfo'				=> '모든 링크를 %1 형식의 절대 URL로 생성합니다. 서버 루트에 상대적인 %2 형식의 URL 사용이 권장됩니다.',
	'LinkTarget'				=> '외부 링크를 여는 방식:',
	'LinkTargetInfo'			=> '각 외부 링크를 새 브라우저 창에서 엽니다. 링크 구문에 <code>target="_blank"</code>를 추가합니다.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> '사용자가 하이퍼링크를 따라갈 때 브라우저가 HTTP Referer 헤더를 전송하지 않도록 요구합니다. 링크 구문에 <code>rel="noreferrer"</code>를 추가합니다.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> '검색 엔진에 이 하이퍼링크가 대상 페이지의 검색 엔진 색인 내 페이지 순위에 영향을 주지 않음을 알립니다. 링크 구문에 <code>rel="nofollow"</code>를 추가합니다.',
	'UrlsUnderscores'			=> '언더스코어로 주소(URL) 생성:',
	'UrlsUnderscoresInfo'		=> '예를 들어, 이 옵션을 사용하면 %1이 %2로 바뀝니다.',
	'ShowSpaces'				=> '위키 이름에 공백 표시:',
	'ShowSpacesInfo'			=> '위키 이름에서 공백을 표시합니다. 예: <code>MyName</code>이 이 옵션을 켜면 <code>My Name</code>으로 표시됩니다.',
	'NumerateLinks'				=> '인쇄 보기에서 링크 번호 매기기:',
	'NumerateLinksInfo'			=> '이 옵션을 사용하면 인쇄 보기 하단에 모든 링크를 번호 매겨 나열합니다.',
	'YouareHereText'			=> '자기 참조 링크 비활성화 및 시각화:',
	'YouareHereTextInfo'		=> '같은 페이지로의 링크를 <code>&lt;b&gt;####&lt;/b&gt;</code>처럼 시각화합니다. 자기 참조 링크는 링크 형식을 잃고 굵은 텍스트로 표시됩니다.',

	// Pages settings
	'PagesSettingsInfo'			=> '여기에서 Wiki 내에서 사용되는 시스템 기본 페이지를 설정하거나 변경할 수 있습니다. 여기 설정에 따라 Wiki에서 해당 페이지를 생성하거나 변경하는 것을 잊지 마십시오.',
	'PagesSettingsUpdated'		=> '기본 페이지 설정이 업데이트되었습니다',

	'ListCount'					=> '목록당 항목 수:',
	'ListCountInfo'				=> '손님에게 표시되거나 새 사용자의 기본값으로 사용되는 각 목록에 표시할 항목 수입니다.',

	'ForumSection'				=> '포럼 설정',
	'ForumCluster'				=> '포럼 클러스터:',
	'ForumClusterInfo'			=> '포럼 섹션의 루트 클러스터(동작 %1).',
	'ForumTopics'				=> '페이지당 주제 수:',
	'ForumTopicsInfo'			=> '포럼 섹션 목록의 각 페이지에 표시할 주제 수(동작 %1).',
	'CommentsCount'				=> '페이지당 댓글 수:',
	'CommentsCountInfo'			=> '댓글 목록의 각 페이지에 표시할 댓글 수입니다. 이는 포럼에 게시된 댓글뿐만 아니라 사이트의 모든 댓글에 적용됩니다.',

	'NewsSection'				=> '뉴스 섹션',
	'NewsCluster'				=> '뉴스 클러스터:',
	'NewsClusterInfo'			=> '뉴스 섹션의 루트 클러스터(동작 %1).',
	'NewsStructure'				=> '뉴스 클러스터 구조:',
	'NewsStructureInfo'			=> '연/월 또는 주별 하위 클러스터에 기사를 선택적으로 저장합니다(예: [cluster]/[year]/[month]).',

	'LicenseSection'			=> '라이선스',
	'DefaultLicense'			=> '기본 라이선스:',
	'DefaultLicenseInfo'		=> '콘텐츠를 어떤 라이선스 아래에 배포할 것인지 설정합니다.',
	'EnableLicense'				=> '라이선스 사용:',
	'EnableLicenseInfo'			=> '라이선스 정보를 표시하려면 활성화하세요.',
	'LicensePerPage'			=> '페이지별 라이선스:',
	'LicensePerPageInfo'		=> '페이지 소유자가 페이지 속성에서 선택할 수 있도록 페이지별 라이선스 허용.',

	'ServicePagesSection'		=> '서비스 페이지',
	'RootPage'					=> '홈페이지:',
	'RootPageInfo'				=> '사용자가 사이트를 방문했을 때 자동으로 열리는 메인 페이지의 태그입니다.',

	'PrivacyPage'				=> '개인정보처리방침:',
	'PrivacyPageInfo'			=> '사이트의 개인정보처리방침이 담긴 페이지입니다.',

	'TermsPage'					=> '정책 및 규정:',
	'TermsPageInfo'				=> '사이트 규칙이 담긴 페이지입니다.',

	'SearchPage'				=> '검색:',
	'SearchPageInfo'			=> '검색 양식이 있는 페이지(동작 %1).',
	'RegistrationPage'			=> '계정 만들기:',
	'RegistrationPageInfo'		=> '새 사용자 등록을 위한 페이지(동작 %1).',
	'LoginPage'					=> '사용자 로그인:',
	'LoginPageInfo'				=> '사이트의 로그인 페이지(동작 %1).',
	'SettingsPage'				=> '사용자 설정:',
	'SettingsPageInfo'			=> '사용자 프로필을 맞춤 설정하는 페이지(동작 %1).',
	'PasswordPage'				=> '비밀번호 변경:',
	'PasswordPageInfo'			=> '사용자 비밀번호 변경/조회 양식이 있는 페이지(동작 %1).',
	'UsersPage'					=> '사용자 목록:',
	'UsersPageInfo'				=> '등록된 사용자 목록이 있는 페이지(동작 %1).',
	'CategoryPage'				=> '카테고리:',
	'CategoryPageInfo'			=> '카테고리별로 정리된 페이지 목록이 있는 페이지(동작 %1).',
	'GroupsPage'				=> '그룹:',
	'GroupsPageInfo'			=> '작업 그룹 목록이 있는 페이지(동작 %1).',
	'WhatsNewPage'				=> '새로운 소식:',
	'WhatsNewPageInfo'			=> '새로 추가되거나 삭제되거나 변경된 페이지, 새 첨부 파일 및 댓글 목록이 있는 페이지입니다(동작 %1).',
	'ChangesPage'				=> '최근 변경:',
	'ChangesPageInfo'			=> '최근 수정된 페이지 목록이 있는 페이지(동작 %1).',
	'CommentsPage'				=> '최근 댓글 목록:',
	'CommentsPageInfo'			=> '페이지에 달린 최근 댓글 목록이 있는 페이지(동작 %1).',
	'RemovalsPage'				=> '삭제된 페이지:',
	'RemovalsPageInfo'			=> '최근 삭제된 페이지 목록이 있는 페이지(동작 %1).',
	'WantedPage'				=> '요청된 페이지:',
	'WantedPageInfo'			=> '참조는 되어 있으나 존재하지 않는(비어 있는) 페이지 목록이 있는 페이지(동작 %1).',
	'OrphanedPage'				=> '고아 페이지:',
	'OrphanedPageInfo'			=> '다른 어떤 페이지와도 링크로 연결되어 있지 않은 기존 페이지 목록이 있는 페이지(동작 %1).',
	'SandboxPage'				=> '샌드박스:',
	'SandboxPageInfo'			=> '사용자가 위키 문법을 연습할 수 있는 페이지입니다.',
	'HelpPage'					=> '도움말:',
	'HelpPageInfo'				=> '사이트 도구와 관련된 문서 섹션입니다.',
	'IndexPage'					=> '색인:',
	'IndexPageInfo'				=> '모든 페이지의 목록이 있는 페이지(동작 %1).',
	'RandomPage'				=> '무작위:',
	'RandomPageInfo'			=> '무작위 페이지를 불러옵니다(동작 %1).',

	// 알림 설정
	'NotificationSettingsInfo'	=> '플랫폼 알림 관련 매개변수입니다.',
	'NotificationSettingsUpdated'	=> '알림 설정이 업데이트되었습니다',

	'EmailNotification'			=> '이메일 알림:',
	'EmailNotificationInfo'		=> '이메일 알림을 허용합니다. 활성화하면 이메일 알림이 켜지고, 비활성화하면 꺼집니다. 단, 이메일 알림을 비활성화해도 회원 가입 과정에서 발송되는 이메일에는 영향이 없습니다.',
	'Autosubscribe'				=> '자동 구독:',
	'AutosubscribeInfo'			=> '페이지 변경 사항에 대해 페이지 소유자에게 자동으로 알림을 보냅니다.',

	'NotificationSection'		=> '사용자 기본 알림 설정',
	'NotifyPageEdit'			=> '페이지 편집 알림:',
	'NotifyPageEditInfo'		=> '보류 - 사용자가 페이지를 다시 방문할 때까지 첫 번째 변경에 대해서만 이메일 알림을 보냅니다.',
	'NotifyMinorEdit'			=> '사소한 편집 알림:',
	'NotifyMinorEditInfo'		=> '사소한 편집에 대해서도 알림을 전송합니다.',
	'NotifyNewComment'			=> '새 댓글 알림:',
	'NotifyNewCommentInfo'		=> '보류 - 사용자가 페이지를 다시 방문할 때까지 첫 번째 댓글에 대해서만 이메일 알림을 보냅니다.',

	'NotifyUserAccount'			=> '새 사용자 계정 알림:',
	'NotifyUserAccountInfo'		=> '가입 양식을 통해 새 사용자가 생성되면 관리자에게 알림이 전송됩니다.',
	'NotifyUpload'				=> '파일 업로드 알림:',
	'NotifyUploadInfo'			=> '파일이 업로드되면 운영자에게 알림이 전송됩니다.',

	'PersonalMessagesSection'	=> '개인 메시지',
	'AllowIntercomDefault'		=> '인터컴 허용:',
	'AllowIntercomDefaultInfo'	=> '이 옵션을 활성화하면 다른 사용자가 수신자의 이메일 주소를 공개하지 않고도 개인 메시지를 보낼 수 있습니다.',
	'AllowMassemailDefault'		=> '대량 이메일 허용:',
	'AllowMassemailDefaultInfo'	=> '관리자가 이메일을 보낼 수 있도록 허용한 사용자에게만 메시지를 보냅니다.',

	// 재동기화 설정
	'Synchronize'				=> '동기화',
	'UserStatsSynched'			=> '사용자 통계가 동기화되었습니다.',
	'PageStatsSynched'			=> '페이지 통계가 동기화되었습니다.',
	'FeedsUpdated'				=> 'RSS 피드가 업데이트되었습니다.',
	'SiteMapCreated'			=> '사이트맵의 새 버전이 성공적으로 생성되었습니다.',
	'ParseNextBatch'			=> '다음 페이지 묶음 파싱:',
	'WikiLinksRestored'			=> '위키 링크가 복원되었습니다.',

	'LogUserStatsSynched'		=> '사용자 통계 동기화',
	'LogPageStatsSynched'		=> '페이지 통계 동기화',
	'LogFeedsUpdated'			=> 'RSS 피드 동기화',
	'LogPageBodySynched'		=> '페이지 본문 및 링크 재파싱',

	'UserStats'					=> '사용자 통계',
	'UserStatsInfo'				=> '사용자 통계(댓글 수, 소유한 페이지, 수정본 및 파일 수)는 일부 상황에서 실제 데이터와 다를 수 있습니다. 이 작업은 데이터베이스에 저장된 실제 데이터와 일치하도록 통계를 업데이트합니다.',
	'PageStats'					=> '페이지 통계',
	'PageStatsInfo'				=> '페이지 통계(댓글 수, 파일 및 수정본 수)는 일부 상황에서 실제 데이터와 다를 수 있습니다. 이 작업은 데이터베이스에 저장된 실제 데이터와 일치하도록 통계를 업데이트합니다.',

	'AttachmentsInfo'			=> '데이터베이스의 모든 첨부 파일에 대한 파일 해시를 업데이트합니다.',
	'AttachmentsSynched'		=> '모든 첨부 파일 해시 재해시',
	'LogAttachmentsSynched'		=> '모든 첨부 파일 해시 재해시',

	'Feeds'						=> '피드',
	'FeedsInfo'					=> '데이터베이스에서 페이지를 직접 편집한 경우 RSS 피드의 내용이 변경 사항을 반영하지 않을 수 있습니다. <br>이 기능은 RSS 채널을 데이터베이스의 현재 상태와 동기화합니다.',
	'XmlSiteMap'				=> 'XML 사이트맵',
	'XmlSiteMapInfo'			=> '이 기능은 XML 사이트맵을 데이터베이스의 현재 상태와 동기화합니다.',
	'XmlSiteMapPeriod'			=> '주기 %1일. 마지막 작성 %2.',
	'XmlSiteMapView'			=> '새 창에서 사이트맵 보기.',

	'ReparseBody'				=> '모든 페이지 다시 파싱',
	'ReparseBodyInfo'			=> '페이지 테이블의 <code>body_r</code> 필드를 비워 다음 페이지 조회 시 각 페이지가 다시 렌더링되도록 합니다. 포맷터를 수정했거나 위키의 도메인을 변경한 경우 유용할 수 있습니다.',
	'PreparsedBodyPurged'		=> '페이지 테이블의 <code>body_r</code> 필드를 비웠습니다.',

	'WikiLinksResync'			=> '위키 링크',
	'WikiLinksResyncInfo'		=> '사이트 내부 링크를 모두 재렌더링하고 손상되었거나 위치가 변경된 경우 <code>page_link</code> 및 <code>file_link</code> 테이블의 내용을 복원합니다(상당한 시간이 걸릴 수 있음).',
	'RecompilePage'				=> '모든 페이지 재컴파일(매우 많은 자원 소모)',
	'ResyncOptions'				=> '추가 옵션',
	'RecompilePageLimit'		=> '한 번에 파싱할 페이지 수.',

	// Email settings
	'EmaiSettingsInfo'			=> '이 정보는 엔진이 사용자에게 이메일을 보낼 때 사용됩니다. 지정한 이메일 주소가 유효한지 확인하십시오. 반송되거나 배달되지 않은 메시지는 해당 주소로 돌아갈 가능성이 높습니다. 호스트가 네이티브(PHP 기반) 이메일 서비스를 제공하지 않는 경우 SMTP를 통해 직접 메시지를 보낼 수 있습니다. 이 경우 적절한 서버의 주소가 필요합니다(필요하면 호스팅 제공자에게 문의하십시오). 서버가 인증을 요구하는 경우(그리고 실제로 요구할 때만) 필요한 사용자 이름, 비밀번호 및 인증 방식을 입력하십시오.',

	'EmailSettingsUpdated'		=> '이메일 설정이 업데이트되었습니다',

	'EmailFunctionName'			=> '이메일 함수 이름:',
	'EmailFunctionNameInfo'		=> 'PHP를 통해 메일을 보낼 때 사용되는 이메일 함수입니다.',
	'UseSmtpInfo'				=> '지역 메일 함수 대신 명시된 서버를 통해 이메일을 보내야 하거나 보내고 싶다면 <code>SMTP</code>를 선택하십시오.',

	'EnableEmail'				=> '이메일 사용:',
	'EnableEmailInfo'			=> '이메일 전송을 활성화합니다.',

	'EmailIdentitySettings'		=> '웹사이트 이메일 신원',
	'FromEmailName'				=> '발신자 이름:',
	'FromEmailNameInfo'			=> '사이트에서 발송되는 모든 이메일 알림의 <code>From:</code> 헤더에 사용될 발신자 이름입니다.',
	'EmailSubjectPrefix'		=> '제목 접두사:',
	'EmailSubjectPrefixInfo'	=> '대체 이메일 제목 접두사(예: <code>[접두사] 제목</code>). 정의하지 않으면 기본 접두사는 사이트 이름입니다: %1.',

	'NoReplyEmail'				=> '회신 금지 주소:',
	'NoReplyEmailInfo'			=> '예: <code>noreply@example.com</code>와 같이 사이트에서 발송되는 모든 이메일 알림의 <code>From:</code> 주소로 표시될 주소입니다.',
	'AdminEmail'				=> '사이트 소유자 이메일:',
	'AdminEmailInfo'			=> '새 사용자 알림 등 관리자 용도로 사용되는 주소입니다.',
	'AbuseEmail'				=> '악용 신고 이메일:',
	'AbuseEmailInfo'			=> '외부 이메일 등록 등 긴급한 문제에 대한 문의를 받을 주소입니다. 사이트 소유자 이메일과 동일할 수 있습니다.',

	'SendTestEmail'				=> '테스트 메일 보내기',
	'SendTestEmailInfo'			=> '계정에 정의된 주소로 테스트 이메일을 보냅니다.',
	'TestEmailSubject'			=> '위키가 이메일 전송을 올바르게 구성했습니다',
	'TestEmailBody'				=> '이 이메일을 받았다면, 귀하의 위키는 이메일 전송이 올바르게 설정된 상태입니다.',
	'TestEmailMessage'			=> '테스트 이메일이 발송되었습니다.<br>메일을 받지 못했다면 이메일 설정을 확인해 주십시오.',

	'SmtpSettings'				=> 'SMTP 설정',
	'SmtpAutoTls'				=> '기회적 TLS 사용:',
	'SmtpAutoTlsInfo'			=> '서버가 TLS 암호화를 광고하면(서버에 연결한 후) 자동으로 암호화를 활성화합니다. <code>SMTPSecure</code> 연결 모드를 설정하지 않았더라도 동작할 수 있습니다.',
	'SmtpConnectionMode'		=> 'SMTP 연결 모드:',
	'SmtpConnectionModeInfo'	=> '사용자 이름/비밀번호가 필요한 경우에만 사용됩니다. 어떤 방식을 써야 할지 확실하지 않으면 제공자에게 문의하십시오.',
	'SmtpPassword'				=> 'SMTP 비밀번호:',
	'SmtpPasswordInfo'			=> 'SMTP 서버가 비밀번호를 요구하는 경우에만 입력하십시오.<br><em><strong>경고:</strong> 이 비밀번호는 데이터베이스에 평문으로 저장되며 데이터베이스에 접근할 수 있거나 이 구성 페이지를 볼 수 있는 모든 사용자에게 노출됩니다.</em>',
	'SmtpPort'					=> 'SMTP 서버 포트:',
	'SmtpPortInfo'				=> 'SMTP 서버가 다른 포트를 사용하는 경우에만 변경하십시오. <br>(기본값: <code>tls</code>는 포트 587(또는 경우에 따라 25), <code>ssl</code>는 포트 465).',
	'SmtpServer'				=> 'SMTP 서버 주소:',
	'SmtpServerInfo'			=> '서버가 사용하는 프로토콜을 함께 제공해야 합니다. SSL을 사용하는 경우 <code>ssl://mail.example.com</code>처럼 입력해야 합니다.',
	'SmtpUsername'				=> 'SMTP 사용자 이름:',
	'SmtpUsernameInfo'			=> 'SMTP 서버가 요구하는 경우에만 사용자 이름을 입력하십시오.',

	// Upload settings
	'UploadSettingsInfo'		=> '여기에서 첨부 파일과 관련 특수 카테고리에 대한 주요 설정을 구성할 수 있습니다.',
	'UploadSettingsUpdated'		=> '업로드 설정이 업데이트되었습니다',

	'FileUploadsSection'		=> '파일 업로드',
	'RegisteredUsers'			=> '등록된 사용자',
	'RightToUpload'				=> '파일 업로드 권한:',
	'RightToUploadInfo'			=> '<code>admins</code>는 관리자 그룹에 속한 사용자만 파일을 업로드할 수 있음을 의미합니다. <code>1</code>은 등록된 사용자가 업로드할 수 있음을 의미합니다. <code>0</code>은 업로드가 비활성화된 상태입니다.',
	'UploadMaxFilesize'			=> '최대 파일 크기:',
	'UploadMaxFilesizeInfo'		=> '각 파일의 최대 크기입니다. 값이 0이면 업로드 가능한 최대 파일 크기는 PHP 설정에 의해 제한됩니다.',
	'UploadQuota'				=> '전체 첨부 파일 할당량:',
	'UploadQuotaInfo'			=> '위키 전체에 대해 첨부 파일에 사용할 수 있는 총 디스크 공간이며 <code>0</code>은 무제한입니다. 현재 %1 사용 중입니다.',
	'UploadQuotaUser'			=> '사용자별 저장 용량 할당량:',
	'UploadQuotaUserInfo'		=> '한 사용자가 업로드할 수 있는 저장 용량 제한이며 <code>0</code>은 무제한입니다.',

	'FileTypes'					=> '파일 형식',
	'UploadOnlyImages'			=> '이미지 파일만 업로드 허용:',
	'UploadOnlyImagesInfo'		=> '페이지에 이미지 파일만 업로드하도록 허용합니다.',
	'AllowedUploadExts'			=> '허용된 파일 형식:',
	'AllowedUploadExtsInfo'		=> '업로드를 허용할 파일 확장자를 쉼표로 구분해 적습니다(예: <code>png, ogg, mp4</code>). 이 목록에 없는 확장자는 금지됩니다.<br>사이트의 콘텐츠 기능에 필요한 최소한의 파일 형식만 허용 목록에 포함시키는 것이 좋습니다.',
	'CheckMimetype'				=> 'MIME 타입 검사:',
	'CheckMimetypeInfo'			=> '일부 브라우저는 업로드된 파일의 MIME 타입을 잘못 추정할 수 있습니다. 이 옵션은 그러한 파일들을 거부하여 문제를 예방합니다.',
	'SvgSanitizer'				=> 'SVG 정화기:',
	'SvgSanitizerInfo'			=> '업로드된 SVG 파일을 정화하여 SVG/XML 취약점을 이용한 파일이 업로드되는 것을 방지합니다.',
	'TranslitFileName'			=> '파일 이름을 음역:',
	'TranslitFileNameInfo'		=> '가능한 경우 유니코드 문자를 사용하지 않고 영숫자 문자만 허용하려면 음역을 권장합니다.',
	'TranslitCaseFolding'		=> '파일 이름을 소문자로 변환:',
	'TranslitCaseFoldingInfo'	=> '이 옵션은 음역이 활성화된 경우에만 적용됩니다.',

	'Thumbnails'				=> '썸네일',
	'CreateThumbnail'			=> '썸네일 생성:',
	'CreateThumbnailInfo'		=> '가능한 모든 상황에서 썸네일을 생성합니다.',
	'JpegQuality'				=> 'JPEG 품질:',
	'JpegQualityInfo'			=> 'JPEG 썸네일을 리사이즈할 때의 품질입니다. 값은 1에서 100 사이여야 하며 100은 100% 품질을 의미합니다.',
	'MaxImageArea'				=> '최대 이미지 영역:',
	'MaxImageAreaInfo'			=> '원본 이미지가 가질 수 있는 최대 픽셀 수입니다. 이는 이미지 스케일러가 내부적으로 사용하는 메모리 사용량을 제한합니다. <br><code>-1</code>은 이미지 크기를 확인하기 전에 스케일링을 시도하지 않음을 의미하고, <code>0</code>은 값을 자동으로 결정함을 의미합니다.',
	'MaxThumbWidth'				=> '썸네일의 최대 너비(픽셀):',
	'MaxThumbWidthInfo'			=> '생성된 썸네일은 여기서 설정한 너비를 초과하지 않습니다.',
	'MinThumbFilesize'			=> '썸네일 최소 파일 크기:',
	'MinThumbFilesizeInfo'		=> '이 값보다 작은 이미지는 썸네일을 생성하지 않습니다.',
	'MaxImageWidth'				=> '페이지에서 허용되는 최대 이미지 너비:',
	'MaxImageWidthInfo'			=> '페이지에서 이미지가 가질 수 있는 최대 너비입니다. 이를 초과하면 축소된 썸네일이 생성됩니다.',

	// Deleted module
	'DeletedObjectsInfo'		=> '삭제된 페이지, 리비전 및 파일 목록입니다.
									해당 행의 <em>Remove</em> 또는 <em>Restore</em> 링크를 클릭하여 데이터베이스에서 페이지, 리비전 또는 파일을 삭제하거나 복원할 수 있습니다. (주의: 삭제 확인이 표시되지 않습니다!)',

	// Filter module
	'FilterSettingsInfo'		=> '위키에서 자동으로 검열될 단어들입니다.',
	'FilterSettingsUpdated'		=> '스팸 필터 설정이 업데이트되었습니다',

	'WordCensoringSection'		=> '단어 검열',
	'SPAMFilter'				=> '스팸 필터:',
	'SPAMFilterInfo'			=> '스팸 필터 활성화',
	'WordList'					=> '단어 목록:',
	'WordListInfo'				=> '블랙리스트에 추가할 단어 또는 구문의 일부 <code>조각</code>을 한 줄에 하나씩 적습니다.',

	// Log module
	'LogFilterTip'				=> '다음 기준으로 이벤트 필터링:',
	'LogLevel'					=> '레벨',
	'LogLevelFilters'	=> [
		'1'		=> '이상',
		'2'		=> '이하',
		'3'		=> '같음',
	],
	'LogNoMatch'				=> '조건에 맞는 이벤트가 없습니다',
	'LogDate'					=> '날짜',
	'LogEvent'					=> '이벤트',
	'LogUsername'				=> '사용자 이름',
	'LogLevels'	=> [
		'1'		=> '치명적',
		'2'		=> '최상',
		'3'		=> '높음',
		'4'		=> '중간',
		'5'		=> '낮음',
		'6'		=> '최하',
		'7'		=> '디버깅',
	],

	// Massemail module
	'MassemailInfo'				=> '여기에서 (1) 전체 사용자에게 또는 (2) 대량 이메일 수신을 허용한 특정 그룹의 모든 사용자에게 메시지를 보낼 수 있습니다. 관리용 이메일 주소로 메시지가 발송되며, 모든 수신자에게는 숨은 참조(BCC)로 동일한 메일이 전송됩니다. 기본 설정은 한 이메일에 최대 20명의 수신자를 포함하는 것입니다. 수신자가 20명을 초과하면 추가 이메일이 발송됩니다. 많은 수신자에게 이메일을 보내는 경우 전송이 완료될 때까지 기다려 주시고 페이지를 중간에 중단하지 마십시오. 대량 메일 발송은 시간이 오래 걸리는 것이 정상이며, 스크립트가 완료되면 알림을 받게 됩니다.',
	'LogMassemail'				=> '대량 이메일 발송 %1 그룹/사용자 ',
	'MassemailSend'				=> '대량 이메일 발송',

	'NoEmailMessage'			=> '메시지를 입력해야 합니다.',
	'NoEmailSubject'			=> '메시지의 제목을 지정해야 합니다.',
	'NoEmailRecipient'			=> '최소한 하나의 사용자 또는 사용자 그룹을 지정해야 합니다.',

	'MassemailSection'			=> '대량 이메일',
	'MessageSubject'			=> '제목:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> '메시지 내용:',
	'YourMessageInfo'			=> '텍스트만 입력할 수 있습니다. 전송 전에 모든 마크업이 제거됩니다.',

	'NoUser'					=> '사용자 없음',
	'NoUserGroup'				=> '사용자 그룹 없음',

	'SendToGroup'				=> '그룹에 보내기:',
	'SendToUser'				=> '사용자에게 보내기:',
	'SendToUserInfo'			=> '관리자가 이메일을 통해 정보를 보낼 수 있도록 허용한 사용자만 대량 이메일을 받습니다. 이 옵션은 사용자 설정의 알림 항목에서 사용할 수 있습니다.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> '시스템 메시지 업데이트됨',

	'SysMsgSection'				=> '시스템 메시지',
	'SysMsg'					=> '시스템 메시지:',
	'SysMsgInfo'				=> '여기에 텍스트를 입력하세요',

	'SysMsgType'				=> '형식:',
	'SysMsgTypeInfo'			=> '메시지 타입 (CSS).',
	'SysMsgAudience'			=> '대상:',
	'SysMsgAudienceInfo'		=> '시스템 메시지가 표시될 대상입니다.',
	'EnableSysMsg'				=> '시스템 메시지 활성화:',
	'EnableSysMsgInfo'			=> '시스템 메시지를 표시합니다.',

	// User approval module
	'ApproveNotExists'			=> '설정 버튼을 통해 최소 한 명의 사용자를 선택하세요.',

	'LogUserApproved'			=> '사용자 ##%1## 승인됨',
	'LogUserBlocked'			=> '사용자 ##%1## 차단됨',
	'LogUserDeleted'			=> '데이터베이스에서 사용자 ##%1## 제거됨',
	'LogUserCreated'			=> '새 사용자 ##%1## 생성됨',
	'LogUserUpdated'			=> '사용자 ##%1## 업데이트됨',
	'LogUserPasswordReset'		=> '사용자 ##%1##의 비밀번호가 성공적으로 재설정되었습니다.',

	'UserApproveInfo'			=> '사용자가 사이트에 로그인할 수 있기 전에 새 사용자를 승인하세요.',
	'Approve'					=> '승인',
	'Deny'						=> '거절',
	'Pending'					=> '대기 중',
	'Approved'					=> '승인됨',
	'Denied'					=> '거부됨',

	// DB Backup module
	'BackupStructure'			=> '구조',
	'BackupData'				=> '데이터',
	'BackupFolder'				=> '폴더',
	'BackupTable'				=> '테이블',
	'BackupCluster'				=> '클러스터:',
	'BackupFiles'				=> '파일',
	'BackupNote'				=> '참고:',
	'BackupSettings'			=> '원하는 백업 방식을 지정하세요.<br>' .
	'루트 클러스터는 전체 파일 백업 및 캐시 파일 백업(선택한 경우)에 영향을 주지 않습니다(선택 시 항상 전체 저장됨).<br>' .  '<br>' .
	'<strong>주의</strong>: 루트 클러스터를 지정하면 데이터 손실을 방지하기 위해 해당 클러스터의 테이블은 재구성되지 않습니다. 이는 데이터 없이 테이블 구조만 백업하는 경우와 동일합니다. 테이블을 백업 형식으로 완전히 변환하려면 <em>클러스터를 지정하지 않고 전체 데이터베이스 백업(구조 및 데이터)</em>을 수행해야 합니다.',
	'BackupCompleted'			=> '백업 및 아카이빙 완료.<br>' .
	'백업 패키지 파일은 %1 하위 디렉터리에 저장되었습니다.<br>FTP로 다운로드하세요(복사 시 디렉터리 구조와 파일 이름을 유지하세요).<br>백업 복사본을 복원하거나 패키지를 제거하려면 <a href="%2">데이터베이스 복원</a>으로 이동하세요.',
	'LogSavedBackup'			=> '백업 데이터베이스 ##%1## 저장됨',
	'Backup'					=> '백업',
	'CantReadFile'				=> '파일 %1을(를) 읽을 수 없습니다.',

	// DB Restore module
	'RestoreInfo'				=> '찾은 백업 패키지 중에서 원하는 것을 복원하거나 서버에서 제거할 수 있습니다.',
	'ConfirmDbRestore'			=> '백업 %1 을(를) 복원하시겠습니까?',
	'ConfirmDbRestoreInfo'		=> '잠시 기다려 주세요. 시간이 걸릴 수 있습니다.',
	'RestoreWrongVersion'		=> '잘못된 WackoWiki 버전입니다!',
	'DirectoryNotExecutable'	=> '%1 디렉터리를 실행할 수 없습니다.',
	'BackupDelete'				=> '백업 %1 을(를) 삭제하시겠습니까?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> '추가 복원 옵션:',
	'RestoreOptionsInfo'		=> '* <strong>클러스터 백업</strong>을 복원하기 전에 대상 테이블은 삭제되지 않습니다(백업되지 않은 클러스터의 정보 손실 방지). ' .
	'따라서 복원 과정에서 중복 레코드가 발생할 수 있습니다. ' .
	'일반 모드에서는 백업의 레코드로 모두 교체됩니다(SQL <code>REPLACE</code> 사용), ' .
	'그러나 이 옵션을 체크하면 모든 중복은 건너뛰고(현재 레코드 값 유지), ' .
	'새 키를 가진 레코드만 테이블에 추가됩니다(SQL <code>INSERT IGNORE</code>).<br>' .
	'<strong>참고</strong>: 사이트 전체 백업을 복원할 때는 이 옵션이 의미가 없습니다.<br>' .
	'<br>' .
	'** 백업에 사용자 파일(전역 및 페이지별, 캐시 파일 등)이 포함된 경우, 일반 모드에서는 동일한 이름의 기존 파일을 교체하여 같은 디렉터리에 복원합니다. ' .
	'이 옵션을 사용하면 현재 파일의 복사본을 유지하고 서버에 없는 새 파일만 백업에서 복원할 수 있습니다.',
	'IgnoreDuplicatedKeysNr'	=> '중복된 테이블 키 무시 (교체하지 않음)',
	'IgnoreSameFiles'			=> '동일한 파일 무시 (덮어쓰지 않음)',
	'NoBackupsAvailable'		=> '사용 가능한 백업이 없습니다.',
	'BackupEntireSite'			=> '사이트 전체',
	'BackupRestored'			=> '백업이 복원되었으며, 아래에 요약 보고서가 첨부되어 있습니다. 이 백업 패키지를 삭제하려면 클릭하세요',
	'BackupRemoved'				=> '선택한 백업이 성공적으로 제거되었습니다.',
	'LogRemovedBackup'			=> '데이터베이스 백업 ##%1## 제거됨',

	'DbEngineInvalid'			=> '유효하지 않은 데이터베이스 엔진, %1 필요',
	'RestoreStarted'			=> '복원 시작됨',
	'RestoreParameters'			=> '사용된 매개변수',
	'IgnoreDuplicatedKeys'		=> '중복 키 무시',
	'IgnoreDuplicatedFiles'		=> '중복 파일 무시',
	'SavedCluster'				=> '저장된 클러스터',
	'DataProtection'			=> '데이터 보호 - %1 제외됨',
	'AssumeDropTable'			=> '%1 가정',
	'RestoreSQLiteDatabase'		=> 'SQLite 데이터베이스 복원',
	'SQLiteDatabaseRestored'	=> '데이터베이스가 다음 위치에 성공적으로 복원되었습니다:',
	'RestoreTableStructure'		=> '테이블 구조 복원 중',
	'RunSqlQueries'				=> 'SQL 명령 실행:',
	'CompletedSqlQueries'		=> '완료됨. 처리된 명령:',
	'NoTableStructure'			=> '테이블 구조가 저장되지 않음 - 건너뜀',
	'RestoreRecords'			=> '테이블 내용 복원',
	'ProcessTablesDump'			=> '테이블 덤프만 다운로드하여 처리함',
	'Instruction'				=> '명령',
	'RestoredRecords'			=> '레코드:',
	'RecordsRestoreDone'		=> '완료. 총 항목 수:',
	'SkippedRecords'			=> '저장되지 않은 데이터 - 건너뜀',
	'RestoringFiles'			=> '파일 복원 중',
	'DecompressAndStore'		=> '디렉터리 내용 압축 해제 및 저장',
	'HomonymicFiles'			=> '동명 파일',
	'RestoreSkip'				=> '건너뜀',
	'RestoreReplace'			=> '교체',
	'RestoreFile'				=> '파일:',
	'RestoredFiles'				=> '복원됨:',
	'SkippedFiles'				=> '건너뜀:',
	'FileRestoreDone'			=> '완료. 총 파일 수:',
	'FilesAll'					=> '전체:',
	'SkipFiles'					=> '파일이 저장되지 않음 - 건너뜀',
	'RestoreDone'				=> '복원 완료',

	'BackupCreationDate'		=> '생성일',
	'BackupPackageContents'		=> '패키지 내용',
	'BackupRestore'				=> '복원',
	'BackupRemove'				=> '제거',
	'RestoreYes'				=> '예',
	'RestoreNo'					=> '아니요',
	'LogDbRestored'				=> '데이터베이스 백업 ##%1## 복원됨.',

	'BackupArchived'			=> '백업 %1 이(가) 보관되었습니다.',
	'BackupArchiveExists'		=> '백업 아카이브 %1 이(가) 이미 존재합니다.',
	'LogBackupArchived'			=> '백업 ##%1## 보관됨.',

	// User module
	'UsersInfo'					=> '여기서 사용자 정보와 특정 옵션을 변경할 수 있습니다.',

	'UsersAdded'				=> '사용자 추가됨',
	'UsersDeleteInfo'			=> '사용자 삭제:',
	'EditButton'				=> '편집',
	'UsersAddNew'				=> '새 사용자 추가',
	'UsersDelete'				=> '사용자 %1 을(를) 정말로 삭제하시겠습니까?',
	'UsersDeleted'				=> '사용자 %1 이(가) 데이터베이스에서 삭제되었습니다.',
	'UsersRename'				=> '사용자 %1 의 이름을 다음으로 변경',
	'UsersRenameInfo'			=> '* 참고: 이 변경은 해당 사용자에게 할당된 모든 페이지에 영향을 미칩니다.',
	'UsersUpdated'				=> '사용자가 성공적으로 업데이트되었습니다.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> '가입 시간',
	'UserActions'				=> '동작',
	'NoMatchingUser'			=> '조건에 맞는 사용자가 없습니다',

	'UserAccountNotify'			=> '사용자에게 알림',
	'UserNotifySignup'			=> '새 계정에 대해 사용자에게 알림',
	'UserVerifyEmail'			=> '이메일 확인 토큰 설정 및 이메일 확인 링크 추가',
	'UserReVerifyEmail'			=> '이메일 확인 토큰 재전송',

	// Groups module
	'GroupsInfo'				=> '이 패널에서 모든 사용자 그룹을 관리할 수 있습니다. 그룹을 삭제, 생성 및 편집할 수 있으며 그룹 리더를 지정하고 공개/숨김/비공개 상태를 전환하고 그룹 이름과 설명을 설정할 수 있습니다.',

	'LogMembersUpdated'			=> '사용자 그룹 구성원 업데이트됨',
	'LogMemberAdded'			=> '구성원 ##%1##이(가) 그룹 ##%2##에 추가됨',
	'LogMemberRemoved'			=> '구성원 ##%1##이(가) 그룹 ##%2##에서 제거됨',
	'LogGroupCreated'			=> '새 그룹 ##%1## 생성됨',
	'LogGroupRenamed'			=> '그룹 ##%1##이(가) ##%2##으로(로) 이름 변경됨',
	'LogGroupRemoved'			=> '그룹 ##%1## 제거됨',

	'GroupsMembersFor'			=> '그룹의 구성원',
	'GroupsDescription'			=> '설명',
	'GroupsModerator'			=> '관리자',
	'GroupsOpen'				=> '열림',
	'GroupsActive'				=> '활성',
	'GroupsTip'					=> '클릭하여 그룹 편집',
	'GroupsUpdated'				=> '그룹이 업데이트되었습니다',
	'GroupsAlreadyExists'		=> '이 그룹은 이미 존재합니다.',
	'GroupsAdded'				=> '그룹이 성공적으로 추가되었습니다.',
	'GroupsRenamed'				=> '그룹 이름이 성공적으로 변경되었습니다.',
	'GroupsDeleted'				=> '그룹 %1 및 관련된 모든 페이지가 데이터베이스에서 삭제되었습니다.',
	'GroupsAdd'					=> '새 그룹 추가',
	'GroupsRename'				=> '그룹 %1 의 이름을 다음으로 변경',
	'GroupsRenameInfo'			=> '* 참고: 이 변경은 해당 그룹에 할당된 모든 페이지에 영향을 미칩니다.',
	'GroupsDelete'				=> '그룹 %1 을(를) 정말로 삭제하시겠습니까?',
	'GroupsDeleteInfo'			=> '* 참고: 이 변경은 해당 그룹에 할당된 모든 구성원에게 영향을 미칩니다.',
	'GroupsIsSystem'			=> '그룹 %1 은(는) 시스템에 속하므로 제거할 수 없습니다.',
	'GroupsStoreButton'			=> '그룹 저장',
	'GroupsEditInfo'			=> '그룹 목록을 편집하려면 라디오 버튼을 선택하세요.',

	'GroupAddMember'			=> '구성원 추가',
	'GroupRemoveMember'			=> '구성원 제거',
	'GroupAddNew'				=> '그룹 추가',
	'GroupEdit'					=> '그룹 편집',
	'GroupDelete'				=> '그룹 제거',

	'MembersAddNew'				=> '새 구성원 추가',
	'MembersAdded'				=> '그룹에 새 구성원이 성공적으로 추가되었습니다.',
	'MembersRemove'				=> '구성원 %1 을(를) 정말로 제거하시겠습니까?',
	'MembersRemoved'			=> '구성원이 그룹에서 제거되었습니다.',

	// Statistics module
	'DbStatSection'				=> '데이터베이스 통계',
	'DbTable'					=> '테이블',
	'DbRecords'					=> '레코드',
	'DbSize'					=> '크기',
	'DbIndex'					=> '인덱스',
	'DbTotal'					=> '총합',

	'FileStatSection'			=> '파일 시스템 통계',
	'FileFolder'				=> '폴더',
	'FileFiles'					=> '파일',
	'FileSize'					=> '크기',
	'FileTotal'					=> '총합',

	// Sysinfo module
	'SysInfo'					=> '버전 정보:',
	'SysParameter'				=> '항목',
	'SysValues'					=> '값',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> '마지막 업데이트',
	'ServerOS'					=> '운영체제',
	'ServerName'				=> '서버 이름',
	'WebServer'					=> '웹 서버',
	'HttpProtocol'				=> 'HTTP 프로토콜',
	'DbVersion'					=> '데이터베이스',
	'SqlModesGlobal'			=> '글로벌 SQL 모드',
	'SqlModesSession'			=> '세션 SQL 모드',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> '메모리 제한',
	'UploadFilesizeMax'			=> '업로드 최대 파일 크기',
	'PostMaxSize'				=> 'POST 최대 크기',
	'MaxExecutionTime'			=> '최대 실행 시간',
	'SessionPath'				=> '세션 경로',
	'PhpDefaultCharset'			=> 'PHP 기본 문자셋',
	'GZipCompression'			=> 'GZip 압축',
	'PhpExtensions'				=> 'PHP 확장',
	'ApacheModules'				=> 'Apache 모듈',

	// DB repair module
	'DbRepairSection'			=> '데이터베이스 복구',
	'DbRepair'					=> '데이터베이스 복구',
	'DbRepairInfo'				=> '이 스크립트는 일반적인 데이터베이스 문제를 자동으로 검사하고 복구할 수 있습니다. 복구 작업은 시간이 걸릴 수 있으니 잠시만 기다려 주십시오.',

	'DbOptimizeRepairSection'	=> '데이터베이스 복구 및 최적화',
	'DbOptimizeRepair'			=> '데이터베이스 복구 및 최적화',
	'DbOptimizeRepairInfo'		=> '이 스크립트는 데이터베이스 최적화를 시도할 수도 있습니다. 이는 특정 상황에서 성능을 향상시킵니다. 데이터베이스 복구 및 최적화에는 시간이 오래 걸릴 수 있으며, 최적화 중에는 데이터베이스가 잠길 수 있습니다.',

	'TableOk'					=> '%1 테이블은 정상입니다.',
	'TableNotOk'				=> '%1 테이블에 문제가 있습니다. 다음 오류가 보고되었습니다: %2. 이 스크립트가 이 테이블을 복구하려고 시도합니다…',
	'TableRepaired'				=> '%1 테이블을 성공적으로 복구했습니다.',
	'TableRepairFailed'			=> '%1 테이블 복구에 실패했습니다. <br>오류: %2',
	'TableAlreadyOptimized'		=> '%1 테이블은 이미 최적화되어 있습니다.',
	'TableOptimized'			=> '%1 테이블을 성공적으로 최적화했습니다.',
	'TableOptimizeFailed'		=> '%1 테이블 최적화에 실패했습니다. <br>오류: %2',
	'TableNotRepaired'			=> '일부 데이터베이스 문제는 복구할 수 없습니다.',
	'RepairsComplete'			=> '복구 완료',

	// Inconsistencies module
	'InconsistenciesInfo'		=> '불일치를 표시하고 수정하며, 고아 레코드를 삭제하거나 새 사용자/값에 할당합니다.',
	'Inconsistencies'			=> '불일치',
	'CheckDatabase'				=> '데이터베이스',
	'CheckDatabaseInfo'			=> '데이터베이스 내 레코드 불일치를 검사합니다.',
	'CheckFiles'				=> '파일',
	'CheckFilesInfo'			=> '파일 테이블에 참조가 남아 있지 않은 고아 파일을 검사합니다.',
	'Records'					=> '레코드',
	'InconsistenciesNone'		=> '데이터 불일치가 발견되지 않았습니다.',
	'InconsistenciesDone'		=> '데이터 불일치가 해결되었습니다.',
	'InconsistenciesRemoved'	=> '제거된 불일치',
	'Check'						=> '검사',
	'Solve'						=> '해결',

	// Bad Behaviour module
	'BbInfo'					=> '원치 않는 웹 접근을 감지하고 차단하여 자동 스팸봇의 접근을 막습니다.<br>자세한 내용은 %1 홈페이지를 방문하십시오.',
	'BbEnable'					=> 'Bad Behaviour 활성화:',
	'BbEnableInfo'				=> '다른 모든 설정은 config 폴더 %1에서 변경할 수 있습니다.',
	'BbStats'					=> 'Bad Behaviour는 지난 7일 동안 %1건의 접근 시도를 차단했습니다.',

	'BbSummary'					=> '요약',
	'BbLog'						=> '로그',
	'BbSettings'				=> '설정',
	'BbWhitelist'				=> '화이트리스트',

	// --> Log
	'BbHits'					=> '조회수',
	'BbRecordsFiltered'			=> '필터된 %2개 중 %1개 레코드 표시',
	'BbStatus'					=> '상태',
	'BbBlocked'					=> '차단됨',
	'BbPermitted'				=> '허용됨',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> '전체 %1개 레코드 표시',
	'BbShow'					=> '표시하기',
	'BbIpDateStatus'			=> 'IP/날짜/상태',
	'BbHeaders'					=> '헤더',
	'BbEntity'					=> '엔티티',

	// --> Whitelist
	'BbOptionsSaved'			=> '옵션이 저장되었습니다.',
	'BbWhitelistHint'			=> '부적절한 화이트리스트 처리는 스팸에 노출되거나 Bad Behaviour가 완전히 작동을 멈추게 할 수 있습니다! 화이트리스트는 반드시 허용해야 한다고 100% 확신할 때만 사용하세요.',
	'BbIpAddress'				=> 'IP 주소',
	'BbIpAddressInfo'			=> '화이트리스트에 추가할 IP 주소 또는 CIDR 형식의 주소 범위(한 줄에 하나씩)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> '웹사이트 호스트명 뒤의 /로 시작하는 URL 조각(한 줄에 하나씩)',
	'BbUserAgent'				=> '사용자 에이전트',
	'BbUserAgentInfo'			=> '화이트리스트에 추가할 사용자 에이전트 문자열(한 줄에 하나씩)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Bad Behaviour 설정이 업데이트되었습니다',
	'BbLogRequest'				=> 'HTTP 요청 기록',
	'BbLogVerbose'				=> '상세',
	'BbLogNormal'				=> '일반 (권장)',
	'BbLogOff'					=> '기록하지 않음 (권장되지 않음)',
	'BbSecurity'				=> '보안',
	'BbStrict'					=> '엄격 검사',
	'BbStrictInfo'				=> '스팸을 더 많이 차단하지만 일부 사용자를 차단할 수 있습니다',
	'BbOffsiteForms'			=> '다른 웹사이트에서의 폼 제출 허용',
	'BbOffsiteFormsInfo'		=> 'OpenID에 필요; 수신 스팸이 증가합니다',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Bad Behaviour의 http:BL 기능을 사용하려면 %1이(가) 필요합니다',
	'BbHttpblKey'				=> 'http:BL 접근 키',
	'BbHttpblThreat'			=> '최소 위협 수준 (25 권장)',
	'BbHttpblMaxage'			=> '데이터 최대 연령 (30 권장)',
	'BbReverseProxy'			=> '리버스 프록시/로드 밸런서',
	'BbReverseProxyInfo'		=> '리버스 프록시, 로드 밸런서, HTTP 가속기, 콘텐츠 캐시 등 뒤에서 Bad Behaviour를 사용하는 경우 리버스 프록시 옵션을 활성화하세요.<br>' .
	'서버와 퍼블릭 인터넷 사이에 두 개 이상의 리버스 프록시 체인이 있는 경우, 모든 프록시 서버와 로드 밸런서 등의 IP 주소 범위(CIDR 형식)를 <em>모두</em> 지정해야 합니다. 그렇지 않으면 Bad Behaviour가 클라이언트의 실제 IP 주소를 판단하지 못할 수 있습니다.<br>' .
	'또한, 리버스 프록시 서버는 요청을 받은 인터넷 클라이언트의 IP 주소를 HTTP 헤더에 설정해야 합니다. 헤더를 지정하지 않으면 %1이(가) 사용됩니다. 대부분의 프록시 서버는 이미 X-Forwarded-For를 지원하며, 프록시 서버에서 이를 활성화하면 됩니다. 일반적으로 사용되는 다른 헤더 이름으로는 %2와 %3가 있습니다.',
	'BbReverseProxyEnable'		=> '리버스 프록시 활성화',
	'BbReverseProxyHeader'		=> '인터넷 클라이언트 IP를 포함한 헤더',
	'BbReverseProxyAddresses'	=> '프록시 서버의 IP 주소 또는 CIDR 형식 주소 범위(한 줄에 하나씩)',

];
