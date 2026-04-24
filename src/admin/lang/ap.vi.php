<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Chức năng cơ bản',
		'preferences'	=> 'Tùy chọn',
		'content'		=> 'Nội dung',
		'users'			=> 'Người dùng',
		'maintenance'	=> 'Bảo trì',
		'messages'		=> 'Tin nhắn',
		'extension'		=> 'Phần mở rộng',
		'database'		=> 'Cơ sở dữ liệu',
	],

	// Admin panel
	'AdminPanel'				=> 'Bảng quản trị',
	'RecoveryMode'				=> 'Chế độ khôi phục',
	'Authorization'				=> 'Xác thực',
	'AuthorizationTip'			=> 'Vui lòng nhập mật khẩu quản trị (đảm bảo trình duyệt cho phép cookie).',
	'NoRecoveryPassword'		=> 'Mật khẩu quản trị chưa được thiết lập!',
	'NoRecoveryPasswordTip'		=> 'Lưu ý: Thiếu mật khẩu quản trị là mối đe dọa về bảo mật! Nhập hàm băm mật khẩu vào tệp cấu hình và chạy lại chương trình.',

	'ErrorLoadingModule'		=> 'Lỗi tải mô-đun quản trị %1: không tồn tại.',

	'ApHomePage'				=> 'Trang chủ',
	'ApHomePageTip'				=> 'Mở trang chủ, bạn sẽ không thoát khỏi chế độ quản trị hệ thống',
	'ApLogOut'					=> 'Đăng xuất',
	'ApLogOutTip'				=> 'Thoát khỏi quản trị hệ thống',

	'TimeLeft'					=> 'Thời gian còn lại:  %1 phút',
	'ApVersion'					=> 'phiên bản',

	'SiteOpen'					=> 'Mở',
	'SiteOpened'				=> 'site đã mở',
	'SiteOpenedTip'				=> 'Trang web đang mở',
	'SiteClose'					=> 'Đóng',
	'SiteClosed'				=> 'site đã đóng',
	'SiteClosedTip'				=> 'Trang web đang đóng',

	'System'					=> 'Hệ thống',

	// Generic
	'Cancel'					=> 'Hủy',
	'Add'						=> 'Thêm',
	'Edit'						=> 'Chỉnh sửa',
	'Remove'					=> 'Xóa',
	'Enabled'					=> 'Đã bật',
	'Disabled'					=> 'Đã vô hiệu hóa',
	'Mandatory'					=> 'Bắt buộc',
	'Admin'						=> 'Quản trị',
	'Min'						=> 'Tối thiểu',
	'Max'						=> 'Tối đa',

	'MiscellaneousSection'		=> 'Khác',
	'MainSection'				=> 'Tùy chọn chung',

	'DirNotWritable'			=> 'Thư mục %1 không cho phép ghi.',
	'FileNotWritable'			=> 'Tệp %1 không cho phép ghi.',

	/**
	 * AP MENU
	 *
	 *	'module_name'		=> [
	 *		'name'		=> 'Tên mô-đun',
	 *		'title'		=> 'Tiêu đề mô-đun',
	 *	],
	 */

	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Cơ bản',
		'title'		=> 'Cài đặt cơ bản',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Giao diện',
		'title'		=> 'Cài đặt giao diện',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'Email',
		'title'		=> 'Cài đặt email',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Syndication',
		'title'		=> 'Cài đặt Syndication',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Bộ lọc',
		'title'		=> 'Cài đặt bộ lọc',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Bộ định dạng',
		'title'		=> 'Tùy chọn định dạng',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Thông báo',
		'title'		=> 'Cài đặt thông báo',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Trang',
		'title'		=> 'Trang và tham số trang web',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Quyền hạn',
		'title'		=> 'Cài đặt quyền',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Bảo mật',
		'title'		=> 'Cài đặt các hệ thống bảo mật',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Hệ thống',
		'title'		=> 'Tùy chọn hệ thống',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Tải lên',
		'title'		=> 'Cài đặt tệp đính kèm',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Đã xóa',
		'title'		=> 'Nội dung vừa bị xóa',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Thêm, sửa hoặc xóa mục menu mặc định',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Sao lưu',
		'title'		=> 'Sao lưu dữ liệu',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Sửa chữa',
		'title'		=> 'Sửa và tối ưu cơ sở dữ liệu',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Khôi phục',
		'title'		=> 'Khôi phục dữ liệu sao lưu',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Menu chính',
		'title'		=> 'Quản trị WackoWiki',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Sự không nhất quán',
		'title'		=> 'Sửa các thiếu nhất quán dữ liệu',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Đồng bộ dữ liệu',
		'title'		=> 'Đồng bộ dữ liệu',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'Gửi email hàng loạt',
		'title'		=> 'Gửi email hàng loạt',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Thông điệp hệ thống',
		'title'		=> 'Tin nhắn hệ thống',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Thông tin hệ thống',
		'title'		=> 'Thông tin hệ thống',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Nhật ký hệ thống',
		'title'		=> 'Nhật ký sự kiện hệ thống',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Thống kê',
		'title'		=> 'Hiển thị thống kê',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Bad Behaviour',
		'title'		=> 'Bad Behaviour',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Phê duyệt',
		'title'		=> 'Phê duyệt đăng ký người dùng',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Nhóm',
		'title'		=> 'Quản lý nhóm',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Người dùng',
		'title'		=> 'Quản lý người dùng',
	],

	// Main module
	'MainNote'					=> 'Lưu ý: Khuyến nghị tạm thời chặn truy cập vào trang để thực hiện bảo trì quản trị.',

	'PurgeSessions'				=> 'Làm sạch',
	'PurgeSessionsTip'			=> 'Xóa tất cả phiên làm việc',
	'PurgeSessionsConfirm'		=> 'Bạn có chắc muốn xóa tất cả phiên làm việc không? Điều này sẽ đăng xuất tất cả người dùng.',
	'PurgeSessionsExplain'		=> 'Xóa tất cả phiên. Điều này sẽ đăng xuất tất cả người dùng bằng cách rỗng bảng auth_token.',
	'PurgeSessionsDone'			=> 'Đã xóa phiên thành công.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Đã cập nhật cài đặt cơ bản',
	'LogBasicSettingsUpdated'	=> 'Đã cập nhật cài đặt cơ bản',

	'SiteName'					=> 'Tên trang:',
	'SiteNameInfo'				=> 'Tiêu đề của trang web này. Hiển thị trên tiêu đề trình duyệt, đầu chủ đề, email thông báo, v.v.',
	'SiteDesc'					=> 'Mô tả trang:',
	'SiteDescInfo'				=> 'Phần bổ sung cho tiêu đề trang, xuất hiện ở đầu trang. Giải thích ngắn gọn về nội dung trang.',
	'AdminName'					=> 'Quản trị trang:',
	'AdminNameInfo'				=> 'Tên người dùng của người chịu trách nhiệm chính về hỗ trợ trang. Tên này không dùng để xác định quyền truy cập, nhưng nên phù hợp với tên quản trị viên chính.',

	'LanguageSection'			=> 'Ngôn ngữ',
	'DefaultLanguage'			=> 'Ngôn ngữ mặc định:',
	'DefaultLanguageInfo'		=> 'Xác định ngôn ngữ hiển thị cho khách chưa đăng ký, cũng như thiết lập vùng địa phương.',
	'MultiLanguage'				=> 'Hỗ trợ đa ngôn ngữ:',
	'MultiLanguageInfo'			=> 'Cho phép chọn ngôn ngữ theo từng trang.',
	'AllowedLanguages'			=> 'Ngôn ngữ cho phép:',
	'AllowedLanguagesInfo'		=> 'Khuyến nghị chọn chỉ những ngôn ngữ bạn muốn dùng, nếu không tất cả ngôn ngữ sẽ được chọn.',

	'CommentSection'			=> 'Bình luận',
	'AllowComments'				=> 'Cho phép bình luận:',
	'AllowCommentsInfo'			=> 'Bật bình luận cho khách hoặc chỉ người dùng đã đăng ký, hoặc tắt hoàn toàn trên toàn trang.',
	'SortingComments'			=> 'Sắp xếp bình luận:',
	'SortingCommentsInfo'		=> 'Thay đổi thứ tự hiển thị bình luận trên trang, với bình luận mới nhất HOẶC cũ nhất ở trên cùng.',
	'CommentsOffset'			=> 'Trang bình luận:',
	'CommentsOffsetInfo'		=> 'Trang bình luận sẽ hiển thị theo mặc định',

	'ToolbarSection'			=> 'Thanh công cụ',
	'CommentsPanel'				=> 'Bảng bình luận:',
	'CommentsPanelInfo'			=> 'Hiển thị mặc định của phần bình luận ở cuối trang.',
	'FilePanel'					=> 'Bảng tệp:',
	'FilePanelInfo'				=> 'Hiển thị mặc định của phần tệp đính kèm ở cuối trang.',
	'TagsPanel'					=> 'Bảng thẻ:',
	'TagsPanelInfo'				=> 'Hiển thị mặc định của bảng thẻ ở cuối trang.',

	'NavigationSection'			=> 'Điều hướng',
	'ShowPermalink'				=> 'Hiển thị permalink:',
	'ShowPermalinkInfo'			=> 'Hiển thị mặc định của liên kết cố định cho phiên bản hiện tại của trang.',
	'TocPanel'					=> 'Bảng mục lục:',
	'TocPanelInfo'				=> 'Hiển thị mặc định bảng mục lục của một trang (cần hỗ trợ trong mẫu).',
	'SectionsPanel'				=> 'Bảng mục lân cận:',
	'SectionsPanelInfo'			=> 'Mặc định, hiển thị bảng các trang lân cận (cần hỗ trợ trong mẫu).',
	'DisplayingSections'		=> 'Hiển thị phần:',
	'DisplayingSectionsInfo'	=> 'Khi các tùy chọn trên được bật, hiển thị chỉ trang con (<em>lower</em>), chỉ trang cùng cấp (<em>top</em>), cả hai, hoặc dạng cây (<em>tree</em>).',
	'MenuItems'					=> 'Mục menu:',
	'MenuItemsInfo'				=> 'Số mục menu hiển thị mặc định (cần hỗ trợ trong mẫu).',

	'HandlerSection'			=> 'Bộ xử lý',
	'HideRevisions'				=> 'Ẩn bản sửa:',
	'HideRevisionsInfo'			=> 'Hiển thị mặc định các bản sửa của trang.',
	'AttachmentHandler'			=> 'Bật bộ xử lý tệp đính kèm:',
	'AttachmentHandlerInfo'		=> 'Cho phép hiển thị bộ xử lý tệp đính kèm.',
	'SourceHandler'				=> 'Bật bộ xử lý nguồn:',
	'SourceHandlerInfo'			=> 'Cho phép hiển thị bộ xử lý nguồn.',
	'ExportHandler'				=> 'Bật bộ xử lý xuất XML:',
	'ExportHandlerInfo'			=> 'Cho phép hiển thị bộ xử lý xuất XML.',

	'DiffModeSection'			=> 'Chế độ Diff',
	'DefaultDiffModeSetting'	=> 'Chế độ diff mặc định:',
	'DefaultDiffModeSettingInfo'=> 'Chế độ diff được chọn trước.',
	'AllowedDiffMode'			=> 'Các chế độ diff cho phép:',
	'AllowedDiffModeInfo'		=> 'Khuyến nghị chọn chỉ các chế độ diff bạn muốn dùng, nếu không tất cả chế độ sẽ được chọn.',
	'NotifyDiffMode'			=> 'Chế độ diff dùng trong thông báo:',
	'NotifyDiffModeInfo'		=> 'Chế độ diff dùng trong phần nội dung email thông báo.',

	'EditingSection'			=> 'Chỉnh sửa',
	'EditSummary'				=> 'Tóm tắt chỉnh sửa:',
	'EditSummaryInfo'			=> 'Hiển thị tóm tắt thay đổi trong chế độ chỉnh sửa.',
	'MinorEdit'					=> 'Chỉnh sửa nhỏ:',
	'MinorEditInfo'				=> 'Bật tùy chọn chỉnh sửa nhỏ trong chế độ chỉnh sửa.',
	'SectionEdit'				=> 'Chỉnh sửa phần:',
	'SectionEditInfo'			=> 'Cho phép chỉnh sửa chỉ một phần của trang.',
	'ReviewSettings'			=> 'Xem lại:',
	'ReviewSettingsInfo'		=> 'Bật tùy chọn xem lại trong chế độ chỉnh sửa.',
	'PublishAnonymously'		=> 'Cho phép xuất bản ẩn danh:',
	'PublishAnonymouslyInfo'	=> 'Cho phép người dùng xuất bản ẩn danh (ẩn tên).',

	'DefaultRenameRedirect'		=> 'Khi đổi tên, tạo chuyển hướng:',
	'DefaultRenameRedirectInfo'	=> 'Mặc định, đề xuất thiết lập chuyển hướng tới địa chỉ cũ của trang khi đổi tên.',
	'StoreDeletedPages'			=> 'Lưu trang đã xóa:',
	'StoreDeletedPagesInfo'		=> 'Khi xóa trang, bình luận hoặc tệp, giữ chúng trong khu vực đặc biệt, nơi có thể xem lại và khôi phục trong một khoảng thời gian (như mô tả bên dưới).',
	'KeepDeletedTime'			=> 'Thời gian lưu trang đã xóa:',
	'KeepDeletedTimeInfo'		=> 'Khoảng thời gian tính bằng ngày. Có ý nghĩa chỉ khi bật tùy chọn trước. Dùng 0 để không bao giờ xóa (trong trường hợp này quản trị viên có thể dọn thủ công).',
	'PagesPurgeTime'			=> 'Thời gian lưu các bản sửa trang:',
	'PagesPurgeTimeInfo'		=> 'Tự động xóa các phiên bản cũ hơn sau số ngày đã cho. Nhập 0 để không xóa các phiên bản cũ.',
	'EnableReferrers'			=> 'Bật referrers:',
	'EnableReferrersInfo'		=> 'Cho phép tạo và hiển thị các referrer bên ngoài.',
	'ReferrersPurgeTime'		=> 'Thời gian lưu referrers:',
	'ReferrersPurgeTimeInfo'	=> 'Giữ lịch sử các trang giới thiệu không quá số ngày cho trước. Dùng 0 để không bao giờ xóa (nhưng với trang có lưu lượng lớn, có thể làm đầy cơ sở dữ liệu).',
	'EnableCounters'			=> 'Bộ đếm truy cập:',
	'EnableCountersInfo'		=> 'Cho phép bộ đếm truy cập theo trang và hiển thị thống kê đơn giản. Lượt xem của chủ sở hữu trang không được tính.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Điều khiển cài đặt web syndication mặc định cho trang của bạn.',
	'SyndicationSettingsUpdated'	=> 'Đã cập nhật cài đặt syndication.',

	'FeedsSection'				=> 'Feeds',
	'EnableFeeds'				=> 'Bật feeds:',
	'EnableFeedsInfo'			=> 'Bật hoặc tắt RSS feeds cho toàn wiki.',
	'XmlChangeLink'				=> 'Chế độ liên kết feed thay đổi:',
	'XmlChangeLinkInfo'			=> 'Xác định nơi các mục feed Changes XML liên kết tới.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'chế độ hiển thị khác biệt',
		'2'		=> 'trang đã sửa',
		'3'		=> 'danh sách bản sửa',
		'4'		=> 'trang hiện tại',
	],

	'XmlSitemap'				=> 'Sơ đồ trang XML:',
	'XmlSitemapInfo'			=> 'Tạo tệp XML tên %1 trong thư mục xml. Bạn có thể thêm đường dẫn tới sitemap trong robots.txt ở thư mục gốc như sau:',
	'XmlSitemapGz'				=> 'Nén sitemap XML:',
	'XmlSitemapGzInfo'			=> 'Nếu muốn, bạn có thể nén tệp sitemap bằng gzip để giảm băng thông.',
	'XmlSitemapTime'			=> 'Thời gian sinh sitemap XML:',
	'XmlSitemapTimeInfo'		=> 'Sinh sitemap chỉ một lần sau số ngày cho trước. Đặt bằng 0 để sinh mỗi khi trang thay đổi.',

	'SearchSection'				=> 'Tìm kiếm',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Tạo tệp mô tả OpenSearch trong thư mục XML và bật Autodiscovery plugin tìm kiếm trong phần đầu HTML.',
	'SearchEngineVisibility'	=> 'Chặn công cụ tìm kiếm (hiển thị cho công cụ tìm kiếm):',
	'SearchEngineVisibilityInfo'=> 'Chặn công cụ tìm kiếm nhưng cho phép khách truy cập bình thường. Ghi đè cài đặt trang. <br>Yêu cầu công cụ tìm kiếm không lập chỉ mục trang này. Việc tuân thủ tùy thuộc vào từng công cụ tìm kiếm.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Điều khiển cài đặt hiển thị mặc định cho trang của bạn.',
	'AppearanceSettingsUpdated'	=> 'Đã cập nhật cài đặt giao diện.',

	'LogoOff'					=> 'Tắt',
	'LogoOnly'					=> 'chỉ logo',
	'LogoAndTitle'				=> 'logo và tiêu đề',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Logo trang:',
	'SiteLogoInfo'				=> 'Logo thường xuất hiện ở góc trên bên trái ứng dụng. Kích thước tối đa 2 MiB. Kích thước tối ưu là 255 pixel rộng × 55 pixel cao.',
	'LogoDimensions'			=> 'Kích thước logo:',
	'LogoDimensionsInfo'		=> 'Chiều rộng và chiều cao của logo hiển thị.',
	'LogoDisplayMode'			=> 'Chế độ hiển thị logo:',
	'LogoDisplayModeInfo'		=> 'Xác định cách hiển thị logo. Mặc định là tắt.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Favicon trang:',
	'SiteFaviconInfo'			=> 'Biểu tượng rút gọn của bạn (favicon) hiển thị trên thanh địa chỉ, tab và dấu trang của hầu hết trình duyệt. Điều này sẽ ghi đè favicon của giao diện.',
	'SiteFaviconTooBig'			=> 'Favicon lớn hơn 64 × 64 px.',
	'ThemeColor'				=> 'Màu chủ đề cho thanh địa chỉ:',
	'ThemeColorInfo'			=> 'Trình duyệt sẽ đặt màu thanh địa chỉ của trang theo màu CSS được cung cấp.',

	'LayoutSection'				=> 'Bố cục',
	'Theme'						=> 'Chủ đề:',
	'ThemeInfo'					=> 'Thiết kế mẫu mà trang sử dụng mặc định.',
	'ResetUserTheme'			=> 'Đặt lại chủ đề người dùng:',
	'ResetUserThemeInfo'		=> 'Đặt lại chủ đề cho tất cả người dùng. Cảnh báo: Hành động này sẽ trả tất cả chủ đề người dùng về chủ đề mặc định toàn cục.',
	'SetBackUserTheme'			=> 'Hoàn nguyên chủ đề người dùng về chủ đề %1.',
	'ThemesAllowed'				=> 'Chủ đề cho phép:',
	'ThemesAllowedInfo'			=> 'Chọn các chủ đề người dùng được phép chọn; nếu không, tất cả chủ đề khả dụng sẽ được cho phép.',
	'ThemesPerPage'				=> 'Chủ đề theo trang:',
	'ThemesPerPageInfo'			=> 'Cho phép chủ đề theo trang, chủ sở hữu trang có thể chọn qua thuộc tính trang.',

	// System settings
	'SystemSettingsInfo'		=> 'Nhóm tham số chịu trách nhiệm tinh chỉnh hệ thống. Không thay đổi trừ khi bạn hiểu rõ tác động.',
	'SystemSettingsUpdated'		=> 'Đã cập nhật cài đặt hệ thống',

	'DebugModeSection'			=> 'Chế độ gỡ lỗi',
	'DebugMode'					=> 'Chế độ gỡ lỗi:',
	'DebugModeInfo'				=> 'Trích xuất và xuất dữ liệu điều tra về thời gian thực thi ứng dụng. Chú ý: Chế độ chi tiết đầy đủ yêu cầu nhiều bộ nhớ hơn, đặc biệt với các tác vụ tốn tài nguyên như sao lưu và khôi phục cơ sở dữ liệu.',
	'DebugModes'	=> [
		'0'		=> 'tắt gỡ lỗi',
		'1'		=> 'chỉ tổng thời gian thực thi',
		'2'		=> 'toàn thời gian',
		'3'		=> 'chi tiết đầy đủ (DBMS, cache, v.v.)',
	],
	'DebugSqlThreshold'			=> 'Ngưỡng hiệu năng RDBMS:',
	'DebugSqlThresholdInfo'		=> 'Trong chế độ gỡ lỗi chi tiết, chỉ báo cáo các truy vấn mất lâu hơn số giây đã chỉ định.',
	'DebugAdminOnly'			=> 'Chỉ chẩn đoán cho admin:',
	'DebugAdminOnlyInfo'		=> 'Hiển thị dữ liệu gỡ lỗi của chương trình (và DBMS) chỉ cho quản trị viên.',

	'CachingSection'			=> 'Tùy chọn bộ nhớ đệm',
	'Cache'						=> 'Lưu trang đã kết xuất vào cache:',
	'CacheInfo'					=> 'Lưu trang đã kết xuất vào bộ nhớ đệm cục bộ để tăng tốc tải tiếp theo. Chỉ hợp lệ cho khách chưa đăng ký.',
	'CacheTtl'					=> 'Thời gian sống cho trang cached:',
	'CacheTtlInfo'				=> 'Lưu trang trong cache không quá số giây đã chỉ định.',
	'CacheSql'					=> 'Cache truy vấn DBMS:',
	'CacheSqlInfo'				=> 'Duy trì cache cục bộ cho kết quả của một số truy vấn SQL liên quan tài nguyên.',
	'CacheSqlTtl'				=> 'Thời gian sống cho truy vấn SQL cached:',
	'CacheSqlTtlInfo'			=> 'Lưu kết quả truy vấn SQL không quá số giây đã chỉ định. Giá trị lớn hơn 1200 không được khuyến nghị.',

	'LogSection'				=> 'Cài đặt nhật ký',
	'LogLevelUsage'				=> 'Sử dụng ghi nhật ký:',
	'LogLevelUsageInfo'			=> 'Mức độ ưu tiên tối thiểu của sự kiện được ghi vào nhật ký.',
	'LogThresholds'	=> [
		'0'		=> 'không lưu nhật ký',
		'1'		=> 'chỉ mức quan trọng',
		'2'		=> 'từ mức cao nhất',
		'3'		=> 'từ mức cao',
		'4'		=> 'mức trung bình',
		'5'		=> 'từ mức thấp',
		'6'		=> 'mức tối thiểu',
		'7'		=> 'ghi tất cả',
	],
	'LogDefaultShow'			=> 'Chế độ hiển thị nhật ký:',
	'LogDefaultShowInfo'		=> 'Mức ưu tiên tối thiểu của sự kiện được hiển thị trong nhật ký theo mặc định.',
	'LogModes'	=> [
		'1'		=> 'chỉ mức quan trọng',
		'2'		=> 'từ mức cao nhất',
		'3'		=> 'từ mức cao',
		'4'		=> 'mức trung bình',
		'5'		=> 'từ mức thấp',
		'6'		=> 'từ mức tối thiểu',
		'7'		=> 'hiển thị tất cả',
	],
	'LogPurgeTime'				=> 'Thời gian lưu nhật ký:',
	'LogPurgeTimeInfo'			=> 'Xóa nhật ký sự kiện sau số ngày đã chỉ định.',

	'PrivacySection'			=> 'Quyền riêng tư',
	'AnonymizeIp'				=> 'Ẩn địa chỉ IP người dùng:',
	'AnonymizeIpInfo'			=> 'Ẩn địa chỉ IP khi áp dụng (ví dụ: trang, bản sửa hoặc referrers).',

	'ReverseProxySection'		=> 'Proxy ngược',
	'ReverseProxy'				=> 'Sử dụng reverse proxy:',
	'ReverseProxyInfo'			=> 'Bật tùy chọn này để xác định đúng địa chỉ IP của client bằng cách kiểm tra thông tin trong header X-Forwarded-For. Header X-Forwarded-For là cơ chế chuẩn để nhận dạng client kết nối qua reverse proxy như Squid hoặc Pound. Reverse proxy thường dùng để tăng hiệu năng và có thể cung cấp caching, bảo mật hoặc mã hóa. Nếu WackoWiki của bạn hoạt động phía sau reverse proxy, nên bật tùy chọn để ghi nhận đúng IP trong quản lý phiên, nhật ký, thống kê và quản lý truy cập; nếu không chắc, không dùng reverse proxy, hoặc chạy trên hosting chia sẻ, hãy để tắt.',
	'ReverseProxyHeader'		=> 'Header proxy ngược:',
	'ReverseProxyHeaderInfo'	=> 'Đặt giá trị này nếu proxy của bạn gửi IP client trong header khác ngoài X-Forwarded-For. Header "X-Forwarded-For" là danh sách địa chỉ IP phân tách bằng dấu phẩy; chỉ địa chỉ cuối cùng (bên trái nhất) sẽ được dùng.',
	'ReverseProxyAddresses'		=> 'reverse_proxy chấp nhận mảng địa chỉ IP:',
	'ReverseProxyAddressesInfo'	=> 'Mỗi phần tử của mảng này là địa chỉ IP của một trong các reverse proxy của bạn. Nếu dùng mảng này, WackoWiki chỉ tin tưởng thông tin trong header X-Forwarded-For khi IP Remote là một trong các địa chỉ này; nếu không, client có thể kết nối trực tiếp tới web server và giả mạo header X-Forwarded-For.',

	'SessionSection'				=> 'Quản lý phiên',
	'SessionStorage'				=> 'Lưu trữ phiên:',
	'SessionStorageInfo'			=> 'Tùy chọn này xác định nơi lưu trữ dữ liệu phiên. Mặc định có thể là tệp hoặc lưu phiên vào cơ sở dữ liệu.',
	'SessionModes'	=> [
		'1'		=> 'Tệp',
		'2'		=> 'Cơ sở dữ liệu',
	],
	'SessionNotice'					=> 'Thông báo kết thúc phiên:',
	'SessionNoticeInfo'				=> 'Cho biết lý do kết thúc phiên.',
	'LoginNotice'					=> 'Thông báo đăng nhập:',
	'LoginNoticeInfo'				=> 'Hiển thị thông báo khi đăng nhập.',

	'RewriteMode'					=> 'Sử dụng <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Nếu web server của bạn hỗ trợ, bật để "làm đẹp" URL trang.<br>
										<span class="cite">Giá trị có thể bị lớp Settings ghi đè khi chạy, bất kể thiết lập tắt, nếu HTTP_MOD_REWRITE bật.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Các tham số chịu trách nhiệm kiểm soát truy cập và quyền hạn.',
	'PermissionsSettingsUpdated'	=> 'Đã cập nhật cài đặt quyền',

	'PermissionsSection'		=> 'Quyền và đặc quyền',
	'ReadRights'				=> 'Quyền đọc mặc định:',
	'ReadRightsInfo'			=> 'Quyền gán mặc định cho các trang gốc được tạo, cũng như các trang không thể xác định ACL cha.',
	'WriteRights'				=> 'Quyền ghi mặc định:',
	'WriteRightsInfo'			=> 'Quyền gán mặc định cho các trang gốc được tạo, cũng như các trang không thể xác định ACL cha.',
	'CommentRights'				=> 'Quyền bình luận mặc định:',
	'CommentRightsInfo'			=> 'Quyền gán mặc định cho các trang gốc được tạo, cũng như các trang không thể xác định ACL cha.',
	'CreateRights'				=> 'Quyền tạo trang con mặc định:',
	'CreateRightsInfo'			=> 'Quyền gán mặc định cho các trang con được tạo.',
	'UploadRights'				=> 'Quyền tải lên mặc định:',
	'UploadRightsInfo'			=> 'Quyền tải lên mặc định.',
	'RenameRights'				=> 'Quyền đổi tên toàn cục:',
	'RenameRightsInfo'			=> 'Danh sách quyền cho phép đổi tên (di chuyển) trang tự do.',

	'LockAcl'					=> 'Khóa tất cả ACL chỉ đọc:',
	'LockAclInfo'				=> '<span class="cite">Ghi đè cài đặt ACL của tất cả trang thành chỉ đọc.</span><br>Điều này hữu ích nếu dự án đã hoàn thành, muốn đóng chỉnh sửa tạm thời vì lý do bảo mật, hoặc phản ứng khẩn cấp trước lỗ hổng.',
	'HideLocked'				=> 'Ẩn trang không truy cập được:',
	'HideLockedInfo'			=> 'Nếu người dùng không có quyền đọc trang, ẩn nó trong các danh sách trang khác nhau (liên kết đặt trong văn bản vẫn có thể hiển thị).',
	'RemoveOnlyAdmins'			=> 'Chỉ quản trị viên được xóa trang:',
	'RemoveOnlyAdminsInfo'		=> 'Từ chối quyền xóa trang cho tất cả, trừ quản trị viên. Giới hạn đầu tiên áp dụng cho chủ sở hữu trang bình thường.',
	'OwnersRemoveComments'		=> 'Chủ sở hữu trang có thể xóa bình luận:',
	'OwnersRemoveCommentsInfo'	=> 'Cho phép chủ sở hữu trang điều tiết bình luận trên trang của họ.',
	'OwnersEditCategories'		=> 'Chủ sở hữu có thể sửa danh mục trang:',
	'OwnersEditCategoriesInfo'	=> 'Cho phép chủ sở hữu sửa danh sách danh mục gán cho trang (thêm/xóa từ).',
	'TermHumanModeration'		=> 'Thời hạn kiểm duyệt thủ công:',
	'TermHumanModerationInfo'	=> 'Người kiểm duyệt chỉ có thể chỉnh sửa bình luận nếu nó được tạo trong không quá số ngày này (giới hạn không áp dụng cho bình luận cuối cùng trong chủ đề).',

	'UserCanDeleteAccount'		=> 'Cho phép người dùng xóa tài khoản của họ',

	// Security settings
	'SecuritySettingsInfo'		=> 'Tham số chịu trách nhiệm an toàn tổng thể của nền tảng, giới hạn an ninh và các hệ thống bảo mật bổ sung.',
	'SecuritySettingsUpdated'	=> 'Đã cập nhật cài đặt bảo mật',

	'AllowRegistration'			=> 'Cho phép đăng ký trực tuyến:',
	'AllowRegistrationInfo'		=> 'Mở đăng ký người dùng. Tắt tùy chọn này sẽ ngăn đăng ký tự do, tuy nhiên quản trị viên vẫn có thể tạo tài khoản.',
	'ApproveNewUser'			=> 'Phê duyệt người dùng mới:',
	'ApproveNewUserInfo'		=> 'Cho phép quản trị viên phê duyệt người dùng sau khi đăng ký. Chỉ người dùng được phê duyệt mới được phép đăng nhập.',
	'PersistentCookies'			=> 'Cookie bền:',
	'PersistentCookiesInfo'		=> 'Cho phép cookie bền (persistent cookies).',
	'DisableWikiName'			=> 'Vô hiệu hóa WikiName:',
	'DisableWikiNameInfo'		=> 'Vô hiệu hóa yêu cầu bắt buộc sử dụng WikiName cho người dùng. Cho phép đăng ký với biệt danh truyền thống thay vì buộc định dạng CamelCase (ví dụ NameSurname).',
	'UsernameLength'			=> 'Độ dài tên người dùng:',
	'UsernameLengthInfo'		=> 'Số ký tự tối thiểu và tối đa cho tên người dùng.',

	'EmailSection'				=> 'Email',
	'AllowEmailReuse'			=> 'Cho phép tái sử dụng địa chỉ email:',
	'AllowEmailReuseInfo'		=> 'Nhiều người dùng có thể đăng ký cùng một địa chỉ email.',
	'EmailConfirmation'			=> 'Bắt buộc xác nhận email:',
	'EmailConfirmationInfo'		=> 'Yêu cầu người dùng xác minh email trước khi đăng nhập.',
	'AllowedEmailDomains'		=> 'Các miền email được phép:',
	'AllowedEmailDomainsInfo'	=> 'Danh sách miền email phân tách bằng dấu phẩy, ví dụ <code>example.com, local.lan</code>. Nếu không chỉ định, mọi miền email đều được phép.',
	'ForbiddenEmailDomains'		=> 'Các miền email bị cấm:',
	'ForbiddenEmailDomainsInfo'	=> 'Danh sách miền email bị cấm phân tách bằng dấu phẩy, ví dụ <code>example.com, local.lan</code>. Chỉ có hiệu lực nếu danh sách miền được phép trống.',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Bật captcha:',
	'EnableCaptchaInfo'			=> 'Nếu bật, captcha sẽ hiển thị trong các trường hợp sau đây hoặc khi đạt ngưỡng bảo mật.',
	'CaptchaComment'			=> 'Bình luận mới:',
	'CaptchaCommentInfo'		=> 'Để chống spam, người dùng chưa đăng ký phải hoàn thành captcha trước khi đăng bình luận.',
	'CaptchaPage'				=> 'Tạo trang mới:',
	'CaptchaPageInfo'			=> 'Để chống spam, người dùng chưa đăng ký phải hoàn thành captcha trước khi tạo trang mới.',
	'CaptchaEdit'				=> 'Chỉnh sửa trang:',
	'CaptchaEditInfo'			=> 'Để chống spam, người dùng chưa đăng ký phải hoàn thành captcha trước khi chỉnh sửa trang.',
	'CaptchaRegistration'		=> 'Đăng ký:',
	'CaptchaRegistrationInfo'	=> 'Để chống spam, người dùng chưa đăng ký phải hoàn thành captcha trước khi đăng ký.',

	'TlsSection'				=> 'Cài đặt TLS',
	'TlsConnection'				=> 'Kết nối TLS:',
	'TlsConnectionInfo'			=> 'Sử dụng kết nối được bảo mật bằng TLS. <span class="cite">Kích hoạt chứng chỉ TLS đã cài đặt trên máy chủ, nếu không bạn có thể mất quyền truy cập vào bảng quản trị!</span><br>Nó cũng xác định nếu Cookie Secure Flag được đặt: cờ <code>secure</code> chỉ gửi cookie qua kết nối an toàn.',
	'TlsImplicit'				=> 'Yêu cầu TLS:',
	'TlsImplicitInfo'			=> 'Bắt buộc chuyển hướng client từ HTTP sang HTTPS. Nếu tắt, client vẫn có thể duyệt qua kết nối HTTP không an toàn.',

	'HttpSecurityHeaders'		=> 'Header bảo mật HTTP',
	'EnableSecurityHeaders'		=> 'Bật header bảo mật:',
	'EnableSecurityHeadersinfo'	=> 'Đặt các header bảo mật (chống frame busting, clickjacking/XSS/CSRF). <br>CSP có thể gây vấn đề trong một số tình huống (ví dụ: khi phát triển), hoặc khi dùng plugin phụ thuộc tài nguyên bên ngoài như ảnh hoặc script. <br>Tắt Content Security Policy là rủi ro bảo mật!',
	'Csp'						=> 'Chính sách bảo mật nội dung (CSP):',
	'CspInfo'					=> 'Cấu hình CSP bao gồm quyết định các chính sách bạn muốn thực thi, sau đó cấu hình và dùng Content-Security-Policy để thiết lập chính sách.',
	'PolicyModes'	=> [
		'0'		=> 'đã vô hiệu hóa',
		'1'		=> 'nghiêm ngặt',
		'2'		=> 'tùy chỉnh',
	],
	'PermissionsPolicy'			=> 'Chính sách quyền:',
	'PermissionsPolicyInfo'		=> 'Header HTTP Permissions-Policy cung cấp cơ chế bật/tắt các tính năng trình duyệt mạnh mẽ một cách rõ ràng.',
	'ReferrerPolicy'			=> 'Chính sách Referrer:',
	'ReferrerPolicyInfo'		=> 'Header Referrer-Policy quản lý thông tin referrer nào (gửi trong header Referer) được bao gồm trong phản hồi.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[tắt]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> 'Bảo quản mật khẩu người dùng',
	'PwdMinChars'				=> 'Độ dài mật khẩu tối thiểu:',
	'PwdMinCharsInfo'			=> 'Mật khẩu dài hơn thường an toàn hơn (ví dụ 12–16 ký tự).<br>Khuyến khích dùng cụm mật khẩu thay vì mật khẩu ngắn.',
	'AdminPwdMinChars'			=> 'Độ dài mật khẩu quản trị tối thiểu:',
	'AdminPwdMinCharsInfo'		=> 'Mật khẩu dài hơn an toàn hơn (ví dụ 15–20 ký tự).<br>Khuyến khích dùng cụm mật khẩu.',
	'PwdCharComplexity'			=> 'Độ phức tạp mật khẩu yêu cầu:',
	'PwdCharClasses'	=> [
		'0'		=> 'không kiểm tra',
		'1'		=> 'bất kỳ chữ + số',
		'2'		=> 'chữ hoa và chữ thường + số',
		'3'		=> 'chữ hoa, chữ thường + số + ký tự đặc biệt',
	],
	'PwdUnlikeLogin'			=> 'Yêu cầu bổ sung:',
	'PwdUnlikes'	=> [
		'0'		=> 'không kiểm tra',
		'1'		=> 'mật khẩu không giống tên đăng nhập',
		'2'		=> 'mật khẩu không chứa tên người dùng',
	],

	'LoginSection'				=> 'Đăng nhập',
	'MaxLoginAttempts'			=> 'Số lần thử đăng nhập tối đa theo tên người dùng:',
	'MaxLoginAttemptsInfo'		=> 'Số lần thử cho mỗi tài khoản trước khi kích hoạt tác vụ chống spam bot. Nhập 0 để không kích hoạt cho các tài khoản khác nhau.',
	'IpLoginLimitMax'			=> 'Số lần thử đăng nhập tối đa theo địa chỉ IP:',
	'IpLoginLimitMaxInfo'		=> 'Ngưỡng số lần thử từ một địa chỉ IP trước khi kích hoạt tác vụ chống spam bot. Nhập 0 để không kích hoạt theo IP.',

	'FormsSection'				=> 'Form',
	'FormTokenTime'				=> 'Thời gian tối đa gửi form:',
	'FormTokenTimeInfo'			=> 'Thời gian người dùng có để gửi form (tính bằng giây).<br> Lưu ý form có thể trở nên không hợp lệ nếu phiên hết hạn, bất kể cài đặt này.',

	'SessionLength'				=> 'Thời hạn cookie phiên:',
	'SessionLengthInfo'			=> 'Thời lượng sống mặc định của cookie phiên người dùng (tính bằng ngày).',
	'CommentDelay'				=> 'Chống ngập cho bình luận:',
	'CommentDelayInfo'			=> 'Thời gian trễ tối thiểu giữa các bình luận mới của người dùng (tính bằng giây).',
	'IntercomDelay'				=> 'Chống ngập cho tin nhắn cá nhân:',
	'IntercomDelayInfo'			=> 'Thời gian trễ tối thiểu giữa các tin nhắn riêng tư (tính bằng giây).',
	'RegistrationDelay'			=> 'Ngưỡng thời gian đăng ký:',
	'RegistrationDelayInfo'		=> 'Thời gian tối thiểu để điền form đăng ký nhằm phân biệt bot và người thật (tính bằng giây).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Nhóm tham số chịu trách nhiệm tinh chỉnh bộ định dạng. Không thay đổi trừ khi bạn hiểu rõ tác động.',
	'FormatterSettingsUpdated'	=> 'Đã cập nhật cài đặt định dạng',

	'TextHandlerSection'		=> 'Bộ xử lý văn bản:',
	'Typografica'				=> 'Kiểm tra ngữ pháp kiểu chữ:',
	'TypograficaInfo'			=> 'Tắt tùy chọn này sẽ tăng tốc quá trình thêm bình luận và lưu trang.',
	'Paragrafica'				=> 'Đánh dấu đoạn:',
	'ParagraficaInfo'			=> 'Tương tự tùy chọn trước, nhưng có thể khiến mục lục tự động (<code>{{toc}}</code>) không hoạt động.',
	'AllowRawhtml'				=> 'Hỗ trợ HTML toàn cục:',
	'AllowRawhtmlInfo'			=> 'Tùy chọn này có thể không an toàn cho trang mở.',
	'SafeHtml'					=> 'Lọc HTML:',
	'SafeHtmlInfo'				=> 'Ngăn lưu các đối tượng HTML nguy hiểm. Vô hiệu hóa bộ lọc trên trang mở khi hỗ trợ HTML là <span class="underline">rất</span> không nên!',

	'WackoFormatterSection'		=> 'Bộ định dạng văn bản Wiki (Wacko Formatter)',
	'X11colors'					=> 'Sử dụng màu X11:',
	'X11colorsInfo'				=> 'Mở rộng các màu khả dụng cho <code>??(color) background??</code> và <code>!!(color) text!!</code>. Tắt tùy chọn này sẽ tăng tốc khi thêm bình luận và lưu trang.',
	'WikiLinks'					=> 'Vô hiệu hóa liên kết wiki:',
	'WikiLinksInfo'				=> 'Vô hiệu hóa liên kết cho <code>CamelCaseWords</code>: các từ CamelCase sẽ không tự động liên kết tới trang mới. Hữu ích khi làm việc giữa các không gian tên khác nhau. Mặc định tắt.',
	'BracketsLinks'				=> 'Vô hiệu hóa liên kết ngoặc:',
	'BracketsLinksInfo'			=> 'Vô hiệu hóa cú pháp <code>[[link]]</code> và <code>((link))</code>.',
	'Formatters'				=> 'Vô hiệu hóa bộ định dạng:',
	'FormattersInfo'			=> 'Vô hiệu hóa cú pháp <code>%%code%%</code>, dùng cho tô sáng mã.',

	'DateFormatsSection'		=> 'Định dạng ngày',
	'DateFormat'				=> 'Định dạng ngày:',
	'DateFormatInfo'			=> '(ngày, tháng, năm)',
	'TimeFormat'				=> 'Định dạng giờ:',
	'TimeFormatInfo'			=> '(giờ, phút)',
	'TimeFormatSeconds'			=> 'Định dạng thời gian chính xác:',
	'TimeFormatSecondsInfo'		=> '(giờ, phút, giây)',
	'NameDateMacro'				=> 'Định dạng macro <code>::@::</code>:',
	'NameDateMacroInfo'			=> '(tên, thời gian), ví dụ <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Múi giờ:',
	'TimezoneInfo'				=> 'Múi giờ dùng để hiển thị thời gian cho khách chưa đăng nhập. Người dùng đã đăng nhập có thể thay đổi múi giờ trong cài đặt cá nhân.',
	'AmericanDate'					=> 'Định dạng ngày kiểu Mỹ:',
	'AmericanDateInfo'				=> 'Dùng định dạng ngày kiểu Mỹ mặc định cho tiếng Anh.',

	'Canonical'					=> 'Sử dụng URL chuẩn đầy đủ:',
	'CanonicalInfo'				=> 'Tất cả liên kết được tạo dưới dạng URL tuyệt đối dạng %1. Ưu tiên URL tương đối đến gốc máy chủ dạng %2.',
	'LinkTarget'				=> 'Mở liên kết ngoài ở đâu:',
	'LinkTargetInfo'			=> 'Mở mỗi liên kết ngoài trong cửa sổ/ tab mới. Thêm <code>target="_blank"</code> vào cú pháp liên kết.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Yêu cầu trình duyệt không gửi header referer khi người dùng theo liên kết. Thêm <code>rel="noreferrer"</code> vào cú pháp liên kết.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Báo cho công cụ tìm kiếm rằng liên kết không ảnh hưởng tới thứ hạng trang mục tiêu. Thêm <code>rel="nofollow"</code> vào cú pháp liên kết.',
	'UrlsUnderscores'			=> 'Tạo địa chỉ (URL) với dấu gạch dưới:',
	'UrlsUnderscoresInfo'		=> 'Ví dụ, %1 trở thành %2 với tùy chọn này.',
	'ShowSpaces'				=> 'Hiển thị khoảng trắng trong WikiNames:',
	'ShowSpacesInfo'			=> 'Hiện khoảng trắng trong WikiNames, ví dụ <code>MyName</code> hiển thị là <code>My Name</code> với tùy chọn này.',
	'NumerateLinks'				=> 'Đánh số liên kết trong chế độ in:',
	'NumerateLinksInfo'			=> 'Đánh số và liệt kê tất cả liên kết ở cuối chế độ in khi bật tùy chọn này.',
	'YouareHereText'			=> 'Vô hiệu hóa và trực quan hóa liên kết tự tham chiếu:',
	'YouareHereTextInfo'		=> 'Trực quan hóa liên kết tới cùng trang, dùng <code>&lt;b&gt;####&lt;/b&gt;</code>. Tất cả liên kết tới chính trang mất định dạng liên kết, nhưng được hiển thị in đậm.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Tại đây bạn có thể đặt hoặc thay đổi các trang cơ bản hệ thống dùng trong Wiki. Hãy đảm bảo không quên tạo hoặc chỉnh sửa các trang tương ứng trong Wiki theo cài đặt ở đây.',
	'PagesSettingsUpdated'		=> 'Đã cập nhật cài đặt các trang cơ bản',

	'ListCount'					=> 'Số mục trên mỗi danh sách:',
	'ListCountInfo'				=> 'Số mục hiển thị trên mỗi danh sách cho khách, hoặc làm giá trị mặc định cho người dùng mới.',

	'ForumSection'				=> 'Tùy chọn Diễn đàn',
	'ForumCluster'				=> 'Cluster diễn đàn:',
	'ForumClusterInfo'			=> 'Cluster gốc cho phần diễn đàn (hành động %1).',
	'ForumTopics'				=> 'Số chủ đề trên mỗi trang:',
	'ForumTopicsInfo'			=> 'Số chủ đề hiển thị trên mỗi trang danh sách trong phần diễn đàn (hành động %1).',
	'CommentsCount'				=> 'Số bình luận trên mỗi trang:',
	'CommentsCountInfo'			=> 'Số bình luận hiển thị trên danh sách bình luận của mỗi trang. Điều này áp dụng cho tất cả bình luận trên trang, không chỉ trong diễn đàn.',

	'NewsSection'				=> 'Mục Tin tức',
	'NewsCluster'				=> 'Cluster cho tin tức:',
	'NewsClusterInfo'			=> 'Cluster gốc cho mục tin tức (hành động %1).',
	'NewsStructure'				=> 'Cấu trúc cluster tin tức:',
	'NewsStructureInfo'			=> 'Lưu trữ các bài viết tùy chọn trong các tiểu cluster theo năm/tháng hoặc tuần (ví dụ <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Giấy phép',
	'DefaultLicense'			=> 'Giấy phép mặc định:',
	'DefaultLicenseInfo'		=> 'Nội dung của bạn được phát hành theo giấy phép nào.',
	'EnableLicense'				=> 'Bật giấy phép:',
	'EnableLicenseInfo'			=> 'Bật để hiển thị thông tin giấy phép.',
	'LicensePerPage'			=> 'Giấy phép theo trang:',
	'LicensePerPageInfo'		=> 'Cho phép đặt giấy phép theo trang, chủ sở hữu trang có thể chọn trong thuộc tính trang.',

	'ServicePagesSection'		=> 'Trang Dịch vụ',
	'RootPage'					=> 'Trang chủ:',
	'RootPageInfo'				=> 'Tag của trang chính của bạn, mở tự động khi người dùng truy cập trang.',

	'PrivacyPage'				=> 'Chính sách bảo mật:',
	'PrivacyPageInfo'			=> 'Trang chứa Chính sách Bảo mật của trang.',

	'TermsPage'					=> 'Quy định và điều khoản:',
	'TermsPageInfo'				=> 'Trang chứa các quy tắc của trang.',

	'SearchPage'				=> 'Tìm kiếm:',
	'SearchPageInfo'			=> 'Trang có biểu mẫu tìm kiếm (hành động %1).',
	'RegistrationPage'			=> 'Đăng ký:',
	'RegistrationPageInfo'		=> 'Trang dành cho đăng ký người dùng mới (hành động %1).',
	'LoginPage'					=> 'Đăng nhập người dùng:',
	'LoginPageInfo'				=> 'Trang đăng nhập trên site (hành động %1).',
	'SettingsPage'				=> 'Cài đặt người dùng:',
	'SettingsPageInfo'			=> 'Trang để tùy chỉnh hồ sơ người dùng (hành động %1).',
	'PasswordPage'				=> 'Đổi mật khẩu:',
	'PasswordPageInfo'			=> 'Trang có biểu mẫu đổi / yêu cầu mật khẩu người dùng (hành động %1).',
	'UsersPage'					=> 'Danh sách người dùng:',
	'UsersPageInfo'				=> 'Trang chứa danh sách người dùng đã đăng ký (hành động %1).',
	'CategoryPage'				=> 'Danh mục:',
	'CategoryPageInfo'			=> 'Trang liệt kê các trang theo danh mục (hành động %1).',
	'GroupsPage'				=> 'Nhóm:',
	'GroupsPageInfo'			=> 'Trang liệt kê các nhóm làm việc (hành động %1).',
	'WhatsNewPage'				=> 'Có gì mới:',
	'WhatsNewPageInfo'			=> 'Trang liệt kê tất cả trang mới, bị xóa hoặc thay đổi, tệp đính kèm mới và bình luận. (hành động %1).',
	'ChangesPage'				=> 'Thay đổi gần đây:',
	'ChangesPageInfo'			=> 'Trang liệt kê các trang được chỉnh sửa gần nhất (hành động %1).',
	'CommentsPage'				=> 'Bình luận gần đây:',
	'CommentsPageInfo'			=> 'Trang liệt kê các bình luận gần đây trên trang (hành động %1).',
	'RemovalsPage'				=> 'Trang bị xóa:',
	'RemovalsPageInfo'			=> 'Trang liệt kê các trang bị xóa gần đây (hành động %1).',
	'WantedPage'				=> 'Trang được yêu cầu:',
	'WantedPageInfo'			=> 'Trang liệt kê các trang bị thiếu nhưng được tham chiếu (hành động %1).',
	'OrphanedPage'				=> 'Trang cô lập:',
	'OrphanedPageInfo'			=> 'Trang liệt kê các trang hiện có không được liên kết với bất kỳ trang nào khác (hành động %1).',
	'SandboxPage'				=> 'Sandbox:',
	'SandboxPageInfo'			=> 'Trang nơi người dùng có thể thực hành cú pháp wiki.',
	'HelpPage'					=> 'Trợ giúp:',
	'HelpPageInfo'				=> 'Phần tài liệu hướng dẫn sử dụng các công cụ quản trị trang web.',
	'IndexPage'					=> 'Mục lục:',
	'IndexPageInfo'				=> 'Trang liệt kê tất cả trang (hành động %1).',
	'RandomPage'				=> 'Ngẫu nhiên:',
	'RandomPageInfo'			=> 'Tải một trang ngẫu nhiên (hành động %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Các tham số cho thông báo của nền tảng.',
	'NotificationSettingsUpdated'	=> 'Đã cập nhật cài đặt thông báo',

	'EmailNotification'			=> 'Thông báo qua email:',
	'EmailNotificationInfo'		=> 'Cho phép thông báo qua email. Chọn Bật để kích hoạt, Tắt để vô hiệu. Lưu ý: tắt thông báo qua email không ảnh hưởng đến email sinh ra trong quá trình đăng ký người dùng.',
	'Autosubscribe'				=> 'Tự động đăng ký:',
	'AutosubscribeInfo'			=> 'Tự động thông báo cho chủ sở hữu khi có thay đổi trang.',

	'NotificationSection'		=> 'Cài đặt thông báo người dùng mặc định',
	'NotifyPageEdit'			=> 'Thông báo sửa trang:',
	'NotifyPageEditInfo'		=> 'Tạm giữ - Gửi email thông báo chỉ cho lần thay đổi đầu tiên cho đến khi người dùng truy cập lại trang.',
	'NotifyMinorEdit'			=> 'Thông báo sửa nhỏ:',
	'NotifyMinorEditInfo'		=> 'Gửi thông báo cả cho các sửa đổi nhỏ.',
	'NotifyNewComment'			=> 'Thông báo bình luận mới:',
	'NotifyNewCommentInfo'		=> 'Tạm giữ - Gửi email thông báo chỉ cho bình luận đầu tiên cho đến khi người dùng truy cập lại trang.',

	'NotifyUserAccount'			=> 'Thông báo tài khoản người dùng mới:',
	'NotifyUserAccountInfo'		=> 'Quản trị viên sẽ được thông báo khi có tài khoản mới được tạo qua biểu mẫu đăng ký.',
	'NotifyUpload'				=> 'Thông báo khi tải tệp:',
	'NotifyUploadInfo'			=> 'Các điều hành viên sẽ được thông báo khi có tệp được tải lên.',

	'PersonalMessagesSection'	=> 'Tin nhắn cá nhân',
	'AllowIntercomDefault'		=> 'Cho phép liên lạc nội bộ:',
	'AllowIntercomDefaultInfo'	=> 'Bật tùy chọn này cho phép người khác gửi tin nhắn cá nhân tới địa chỉ email của người nhận mà không lộ địa chỉ.',
	'AllowMassemailDefault'		=> 'Cho phép email hàng loạt:',
	'AllowMassemailDefaultInfo'	=> 'Chỉ gửi email tới những người đã cho phép quản trị viên gửi thông tin qua email.',

	// Resync settings
	'Synchronize'				=> 'Đồng bộ',
	'UserStatsSynched'			=> 'Thống kê người dùng đã được đồng bộ.',
	'PageStatsSynched'			=> 'Thống kê trang đã được đồng bộ.',
	'FeedsUpdated'				=> 'Các nguồn RSS đã được cập nhật.',
	'SiteMapCreated'			=> 'Phiên bản mới của sơ đồ trang đã được tạo thành công.',
	'ParseNextBatch'			=> 'Phân tích lô trang tiếp theo:',
	'WikiLinksRestored'			=> 'Liên kết Wiki đã được phục hồi.',

	'LogUserStatsSynched'		=> 'Đã đồng bộ thống kê người dùng',
	'LogPageStatsSynched'		=> 'Đã đồng bộ thống kê trang',
	'LogFeedsUpdated'			=> 'Đã đồng bộ các nguồn RSS',
	'LogPageBodySynched'		=> 'Đã phân tích lại nội dung và liên kết trang',

	'UserStats'					=> 'Thống kê người dùng',
	'UserStatsInfo'				=> 'Thống kê người dùng (số bình luận, trang sở hữu, phiên bản và tệp) có thể khác với dữ liệu thực tế trong một số tình huống. <br>Hoạt động này cho phép cập nhật thống kê để khớp với dữ liệu thực tế trong cơ sở dữ liệu.',
	'PageStats'					=> 'Thống kê trang',
	'PageStatsInfo'				=> 'Thống kê trang (số bình luận, tệp và phiên bản) có thể khác với dữ liệu thực tế trong một số tình huống. <br>Hoạt động này cho phép cập nhật thống kê để khớp với dữ liệu thực tế trong cơ sở dữ liệu.',

	'AttachmentsInfo'			=> 'Cập nhật mã băm (hash) cho tất cả tệp đính kèm trong cơ sở dữ liệu.',
	'AttachmentsSynched'		=> 'Đã băm lại tất cả tệp đính kèm',
	'LogAttachmentsSynched'		=> 'Đã băm lại tất cả tệp đính kèm',

	'Feeds'						=> 'Nguồn',
	'FeedsInfo'					=> 'Trong trường hợp chỉnh sửa trực tiếp trang trong cơ sở dữ liệu, nội dung RSS có thể không phản ánh các thay đổi. <br>Chức năng này đồng bộ kênh RSS với trạng thái hiện tại của cơ sở dữ liệu.',
	'XmlSiteMap'				=> 'Sơ đồ trang XML',
	'XmlSiteMapInfo'			=> 'Chức năng này đồng bộ Sơ đồ trang XML với trạng thái hiện tại của cơ sở dữ liệu.',
	'XmlSiteMapPeriod'			=> 'Chu kỳ %1 ngày. Ghi lần cuối %2.',
	'XmlSiteMapView'			=> 'Hiển thị Sơ đồ trang trong cửa sổ mới.',

	'ReparseBody'				=> 'Phân tích lại tất cả trang',
	'ReparseBodyInfo'			=> 'Xóa trường <code>body_r</code> trong bảng trang, để mỗi trang được kết xuất lại khi xem lần tiếp theo. Có ích khi bạn thay đổi bộ định dạng hoặc thay đổi miền wiki.',
	'PreparsedBodyPurged'		=> 'Đã xóa trường <code>body_r</code> trong bảng trang.',

	'WikiLinksResync'			=> 'Liên kết Wiki',
	'WikiLinksResyncInfo'		=> 'Thực hiện kết xuất lại cho tất cả liên kết nội bộ và phục hồi nội dung của các bảng <code>page_link</code> và <code>file_link</code> khi bị hỏng hoặc di chuyển (có thể tốn nhiều thời gian).',
	'RecompilePage'				=> 'Biên dịch lại tất cả trang (rất tốn kém)',
	'ResyncOptions'				=> 'Tùy chọn bổ sung',
	'RecompilePageLimit'		=> 'Số trang phân tích mỗi lần.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Thông tin này được sử dụng khi hệ thống gửi email đến người dùng. Vui lòng đảm bảo địa chỉ email bạn cung cấp hợp lệ, vì các email bị trả lại hoặc không thể gửi sẽ có thể đi tới địa chỉ đó. Nếu nhà cung cấp hosting không cung cấp dịch vụ email nội bộ (dựa trên PHP), bạn có thể gửi trực tiếp bằng SMTP. Điều này yêu cầu địa chỉ máy chủ phù hợp (hỏi nhà cung cấp nếu cần). Nếu máy chủ yêu cầu xác thực (chỉ khi cần), nhập tên tài khoản, mật khẩu và phương thức xác thực cần thiết.',

	'EmailSettingsUpdated'		=> 'Đã cập nhật cài đặt Email',

	'EmailFunctionName'			=> 'Tên hàm email:',
	'EmailFunctionNameInfo'		=> 'Hàm email được sử dụng để gửi thư qua PHP.',
	'UseSmtpInfo'				=> 'Chọn <code>SMTP</code> nếu bạn muốn hoặc cần gửi email qua một máy chủ thay vì hàm mail cục bộ.',

	'EnableEmail'				=> 'Bật gửi email:',
	'EnableEmailInfo'			=> 'Bật tính năng gửi email.',

	'EmailIdentitySettings'		=> 'Danh tính Email của trang web',
	'FromEmailName'				=> 'Tên người gửi:',
	'FromEmailNameInfo'			=> 'Tên người gửi dùng cho header <code>From:</code> cho tất cả email thông báo từ trang.',
	'EmailSubjectPrefix'		=> 'Tiền tố tiêu đề:',
	'EmailSubjectPrefixInfo'	=> 'Tiền tố tiêu đề email thay thế, ví dụ <code>[Prefix] Chủ đề</code>. Nếu không định nghĩa, tiền tố mặc định là Tên trang: %1.',

	'NoReplyEmail'				=> 'Địa chỉ không trả lời:',
	'NoReplyEmailInfo'			=> 'Địa chỉ này, ví dụ <code>noreply@example.com</code>, sẽ hiển thị trong trường <code>From:</code> của tất cả email thông báo từ trang.',
	'AdminEmail'				=> 'Email chủ sở hữu trang:',
	'AdminEmailInfo'			=> 'Địa chỉ này dùng cho mục đích quản trị, như thông báo người dùng mới.',
	'AbuseEmail'				=> 'Email báo lạm dụng:',
	'AbuseEmailInfo'			=> 'Địa chỉ nhận các yêu cầu khẩn cấp: đăng ký bằng email không rõ nguồn gốc, v.v. Có thể trùng với email chủ sở hữu trang.',

	'SendTestEmail'				=> 'Gửi email kiểm tra',
	'SendTestEmailInfo'			=> 'Sẽ gửi một email kiểm tra tới địa chỉ được định nghĩa trong tài khoản của bạn.',
	'TestEmailSubject'			=> 'Wiki của bạn đã được cấu hình đúng để gửi email',
	'TestEmailBody'				=> 'Nếu bạn nhận được email này, Wiki của bạn đã được cấu hình đúng để gửi email.',
	'TestEmailMessage'			=> 'Email kiểm tra đã được gửi.<br>Nếu bạn không nhận được, vui lòng kiểm tra lại cấu hình email.',

	'SmtpSettings'				=> 'Cài đặt SMTP',
	'SmtpAutoTls'				=> 'TLS thỏa hiệp:',
	'SmtpAutoTlsInfo'			=> 'Tự động bật mã hóa nếu máy chủ thông báo hỗ trợ TLS (sau khi kết nối), ngay cả khi bạn không đặt chế độ kết nối cho <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Chế độ kết nối cho SMTP:',
	'SmtpConnectionModeInfo'	=> 'Chỉ dùng nếu cần username/password. Hỏi nhà cung cấp nếu không chắc dùng phương thức nào.',
	'SmtpPassword'				=> 'Mật khẩu SMTP:',
	'SmtpPasswordInfo'			=> 'Chỉ nhập mật khẩu nếu máy chủ SMTP yêu cầu.<br><em><strong>Cảnh báo:</strong> Mật khẩu này sẽ được lưu dưới dạng văn bản thuần trong cơ sở dữ liệu, hiển thị cho bất kỳ ai truy cập được cơ sở dữ liệu hoặc xem trang cấu hình này.</em>',
	'SmtpPort'					=> 'Cổng máy chủ SMTP:',
	'SmtpPortInfo'				=> 'Chỉ thay đổi nếu bạn biết máy chủ SMTP dùng cổng khác. <br>(mặc định: <code>tls</code> cổng 587 (hoặc có thể 25) và <code>ssl</code> cổng 465).',
	'SmtpServer'				=> 'Địa chỉ máy chủ SMTP:',
	'SmtpServerInfo'			=> 'Lưu ý bạn phải cung cấp giao thức máy chủ sử dụng. Nếu dùng SSL, phải là <code>ssl://mail.example.com</code>.',
	'SmtpUsername'				=> 'Tên đăng nhập SMTP:',
	'SmtpUsernameInfo'			=> 'Chỉ nhập tên đăng nhập nếu máy chủ SMTP yêu cầu.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Tại đây bạn có thể cấu hình các cài đặt chính cho tệp đính kèm và các danh mục đặc biệt liên quan.',
	'UploadSettingsUpdated'		=> 'Đã cập nhật cài đặt tải lên',

	'FileUploadsSection'		=> 'Tải tệp',
	'RegisteredUsers'			=> 'người dùng đã đăng ký',
	'RightToUpload'				=> 'Quyền tải tệp:',
	'RightToUploadInfo'			=> '<code>admins</code> nghĩa là chỉ người dùng thuộc nhóm admins mới có thể tải tệp. <code>1</code> nghĩa là cho phép người dùng đã đăng ký. <code>0</code> nghĩa là tắt tính năng tải lên.',
	'UploadMaxFilesize'			=> 'Kích thước file tối đa:',
	'UploadMaxFilesizeInfo'		=> 'Kích thước tối đa mỗi tệp. Nếu giá trị này là 0, kích thước tối đa chỉ bị giới hạn bởi cấu hình PHP của bạn.',
	'UploadQuota'				=> 'Dung lượng đính kèm tối đa:',
	'UploadQuotaInfo'			=> 'Dung lượng ổ đĩa tối đa cho tệp đính kèm cho toàn wiki, <code>0</code> là không giới hạn. Đã dùng %1.',
	'UploadQuotaUser'			=> 'Dung lượng lưu trữ cho mỗi người dùng:',
	'UploadQuotaUserInfo'		=> 'Hạn chế dung lượng mà một người dùng có thể tải lên, <code>0</code> là không giới hạn.',

	'FileTypes'					=> 'Loại tệp',
	'UploadOnlyImages'			=> 'Chỉ cho phép tải ảnh:',
	'UploadOnlyImagesInfo'		=> 'Chỉ cho phép tải các tệp ảnh lên trang.',
	'AllowedUploadExts'			=> 'Loại tệp cho phép:',
	'AllowedUploadExtsInfo'		=> 'Các phần mở rộng được phép tải lên, phân tách bằng dấu phẩy (ví dụ <code>png, ogg, mp4</code>); nếu không, mọi phần mở rộng đều được phép.<br>Bạn nên giới hạn phần mở rộng cần thiết tối thiểu để trang hoạt động đúng.',
	'CheckMimetype'				=> 'Kiểm tra MIME type:',
	'CheckMimetypeInfo'			=> 'Một số trình duyệt có thể bị lừa để cho MIME type sai cho tệp tải lên. Tùy chọn này giúp từ chối các tệp có khả năng bị lừa.',
	'SvgSanitizer'				=> 'Bộ lọc SVG:',
	'SvgSanitizerInfo'			=> 'Bật chức năng lọc SVG để ngăn các lỗ hổng SVG/XML khi tải lên.',
	'TranslitFileName'			=> 'Chuyển tự tên tệp:',
	'TranslitFileNameInfo'		=> 'Nếu có thể và không cần ký tự Unicode, khuyến nghị chỉ chấp nhận ký tự chữ và số trong tên tệp.',
	'TranslitCaseFolding'		=> 'Chuyển tên tệp về chữ thường:',
	'TranslitCaseFoldingInfo'	=> 'Tùy chọn này chỉ có hiệu lực khi chuyển tự đang hoạt động.',

	'Thumbnails'				=> 'Ảnh thu nhỏ',
	'CreateThumbnail'			=> 'Tạo ảnh thu nhỏ:',
	'CreateThumbnailInfo'		=> 'Tạo ảnh thu nhỏ trong mọi trường hợp có thể.',
	'JpegQuality'				=> 'Chất lượng JPEG:',
	'JpegQualityInfo'			=> 'Chất lượng khi thu nhỏ ảnh JPEG. Giá trị từ 1 đến 100, 100 là chất lượng cao nhất.',
	'MaxImageArea'				=> 'Diện tích ảnh tối đa:',
	'MaxImageAreaInfo'			=> 'Số pixel tối đa mà ảnh nguồn có thể có. Giới hạn này giúp kiểm soát bộ nhớ khi giải nén ảnh để xử lý.<br><code>-1</code> nghĩa là không kiểm tra kích thước trước khi cố gắng thu nhỏ. <code>0</code> nghĩa là tự động xác định giá trị.',
	'MaxThumbWidth'				=> 'Chiều rộng tối đa của ảnh thu nhỏ (pixel):',
	'MaxThumbWidthInfo'			=> 'Ảnh thu nhỏ tạo ra sẽ không vượt quá chiều rộng này.',
	'MinThumbFilesize'			=> 'Kích thước tệp tối thiểu để tạo thu nhỏ:',
	'MinThumbFilesizeInfo'		=> 'Không tạo ảnh thu nhỏ cho ảnh nhỏ hơn giá trị này.',
	'MaxImageWidth'				=> 'Giới hạn kích thước ảnh trên trang:',
	'MaxImageWidthInfo'			=> 'Chiều rộng tối đa cho phép của ảnh trên trang, nếu vượt quá sẽ tạo ảnh thu nhỏ.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Danh sách các trang, phiên bản và tệp bị xóa.
									Xóa vĩnh viễn hoặc khôi phục trang, phiên bản hoặc tệp khỏi cơ sở dữ liệu bằng cách nhấn liên kết <em>Remove</em>
									hoặc <em>Restore</em> ở hàng tương ứng. (Cẩn thận, không có yêu cầu xác nhận xóa!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Những từ sẽ tự động bị kiểm duyệt trên Wiki của bạn.',
	'FilterSettingsUpdated'		=> 'Đã cập nhật cài đặt bộ lọc spam',

	'WordCensoringSection'		=> 'Lọc từ',
	'SPAMFilter'				=> 'Bộ lọc Spam:',
	'SPAMFilterInfo'			=> 'Bật Bộ lọc Spam',
	'WordList'					=> 'Danh sách từ:',
	'WordListInfo'				=> 'Từ hoặc cụm từ <code>mảnh</code> sẽ bị đưa vào danh sách đen (mỗi dòng một mục)',

	// Log module
	'LogFilterTip'				=> 'Lọc sự kiện theo tiêu chí:',
	'LogLevel'					=> 'Mức độ',
	'LogLevelFilters'	=> [
		'1'		=> 'không thấp hơn',
		'2'		=> 'không cao hơn',
		'3'		=> 'bằng',
	],
	'LogNoMatch'				=> 'Không có sự kiện phù hợp tiêu chí',
	'LogDate'					=> 'Ngày',
	'LogEvent'					=> 'Sự kiện',
	'LogUsername'				=> 'Tên người dùng',
	'LogLevels'	=> [
		'1'		=> 'nghiêm trọng',
		'2'		=> 'rất cao',
		'3'		=> 'cao',
		'4'		=> 'trung bình',
		'5'		=> 'thấp',
		'6'		=> 'rất thấp',
		'7'		=> 'gỡ lỗi',
	],

	// Massemail module
	'MassemailInfo'				=> 'Tại đây bạn có thể gửi email tới (1) tất cả người dùng hoặc (2) tất cả thành viên của một nhóm cụ thể đã bật nhận email hàng loạt. Một email sẽ được gửi tới địa chỉ email quản trị được cung cấp, với bản sao ẩn (BCC) gửi tới tất cả người nhận. Cấu hình mặc định bao gồm tối đa 20 người nhận trên một email. Nếu có nhiều hơn 20 người, sẽ gửi thêm email. Nếu gửi tới nhóm lớn, hãy kiên nhẫn sau khi gửi và không dừng trang giữa chừng. Việc gửi email hàng loạt có thể mất thời gian. Bạn sẽ được thông báo khi hoàn tất.',
	'LogMassemail'				=> 'Gửi email hàng loạt %1 tới nhóm / người dùng ',
	'MassemailSend'				=> 'Gửi email hàng loạt',

	'NoEmailMessage'			=> 'Bạn phải nhập nội dung tin nhắn.',
	'NoEmailSubject'			=> 'Bạn phải chỉ định tiêu đề cho tin nhắn.',
	'NoEmailRecipient'			=> 'Bạn phải chỉ định ít nhất một người dùng hoặc nhóm người dùng.',

	'MassemailSection'			=> 'Email hàng loạt',
	'MessageSubject'			=> 'Tiêu đề:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Nội dung của bạn:',
	'YourMessageInfo'			=> 'Lưu ý bạn chỉ được nhập văn bản thuần. Mọi cú pháp sẽ bị loại bỏ trước khi gửi.',

	'NoUser'					=> 'Không có người dùng',
	'NoUserGroup'				=> 'Không có nhóm người dùng',

	'SendToGroup'				=> 'Gửi tới nhóm:',
	'SendToUser'				=> 'Gửi tới người dùng:',
	'SendToUserInfo'			=> 'Chỉ những người cho phép quản trị viên gửi email cho họ mới nhận email hàng loạt. Tùy chọn này có trong cài đặt người dùng mục Thông báo.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Đã cập nhật thông báo hệ thống',

	'SysMsgSection'				=> 'Thông báo hệ thống',
	'SysMsg'					=> 'Thông báo:',
	'SysMsgInfo'				=> 'Văn bản của bạn ở đây',

	'SysMsgType'				=> 'Loại:',
	'SysMsgTypeInfo'			=> 'Loại thông báo (CSS).',
	'SysMsgAudience'			=> 'Đối tượng:',
	'SysMsgAudienceInfo'		=> 'Đối tượng sẽ thấy thông báo hệ thống.',
	'EnableSysMsg'				=> 'Bật thông báo hệ thống:',
	'EnableSysMsgInfo'			=> 'Hiển thị thông báo hệ thống.',

	// User approval module
	'ApproveNotExists'			=> 'Vui lòng chọn ít nhất một người dùng bằng nút Set.',

	'LogUserApproved'			=> 'Người dùng ##%1## đã được phê duyệt',
	'LogUserBlocked'			=> 'Người dùng ##%1## đã bị chặn',
	'LogUserDeleted'			=> 'Người dùng ##%1## đã bị xóa khỏi cơ sở dữ liệu',
	'LogUserCreated'			=> 'Đã tạo người dùng mới ##%1##',
	'LogUserUpdated'			=> 'Đã cập nhật người dùng ##%1##',
	'LogUserPasswordReset'		=> 'Mật khẩu cho người dùng ##%1## đã được đặt lại thành công',

	'UserApproveInfo'			=> 'Phê duyệt người dùng mới trước khi họ có thể đăng nhập vào trang.',
	'Approve'					=> 'Phê duyệt',
	'Deny'						=> 'Từ chối',
	'Pending'					=> 'Đang chờ',
	'Approved'					=> 'Đã phê duyệt',
	'Denied'					=> 'Đã từ chối',

	// DB Backup module
	'BackupStructure'			=> 'Cấu trúc',
	'BackupData'				=> 'Dữ liệu',
	'BackupFolder'				=> 'Thư mục',
	'BackupTable'				=> 'Bảng',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'Tệp',
	'BackupNote'				=> 'Ghi chú:',
	'BackupSettings'			=> 'Chỉ định sơ đồ sao lưu mong muốn.<br>' .
	'Cluster gốc không ảnh hưởng đến sao lưu tệp toàn cục và sao lưu tệp cache (nếu chọn, chúng luôn được lưu đầy đủ).<br>' .  '<br>' .
	'<strong>Chú ý</strong>: Để tránh mất dữ liệu khi chỉ định cluster gốc, các bảng trong bản sao lưu này sẽ không được tái cấu trúc, giống như khi sao lưu chỉ cấu trúc bảng mà không lưu dữ liệu. Để chuyển đổi hoàn toàn các bảng sang định dạng sao lưu bạn phải thực hiện <em>sao lưu toàn bộ cơ sở dữ liệu (cấu trúc và dữ liệu) mà không chỉ định cluster</em>.',
	'BackupCompleted'			=> 'Hoàn tất sao lưu và đóng gói.<br>' .
	'Tệp gói sao lưu được lưu trong thư mục con %1.<br>Để tải về hãy dùng FTP (giữ nguyên cấu trúc thư mục và tên tệp khi sao chép).<br> Để khôi phục hoặc xóa gói sao lưu, vào <a href="%2">Khôi phục cơ sở dữ liệu</a>.',
	'LogSavedBackup'			=> 'Đã lưu sao lưu cơ sở dữ liệu ##%1##',
	'Backup'					=> 'Sao lưu',
	'CantReadFile'				=> 'Không thể đọc tệp %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Bạn có thể khôi phục bất kỳ gói sao lưu nào tìm thấy, hoặc xóa chúng khỏi máy chủ.',
	'ConfirmDbRestore'			=> 'Bạn có muốn khôi phục sao lưu %1 không?',
	'ConfirmDbRestoreInfo'		=> 'Vui lòng chờ, quá trình này có thể mất thời gian.',
	'RestoreWrongVersion'		=> 'Phiên bản WackoWiki không đúng!',
	'DirectoryNotExecutable'	=> 'Thư mục %1 không thể thực thi.',
	'BackupDelete'				=> 'Bạn có chắc muốn xóa sao lưu %1 không?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Tùy chọn khôi phục bổ sung:',
	'RestoreOptionsInfo'		=> '* Trước khi khôi phục <strong>sao lưu cluster</strong>, ' .
	'bảng đích không bị xóa (để tránh mất dữ liệu từ các cluster không được sao lưu). ' .
	'Do đó, trong quá trình khôi phục sẽ xuất hiện bản ghi trùng lặp. ' .
	'Trong chế độ bình thường, chúng sẽ bị thay thế bởi bản ghi từ sao lưu (sử dụng SQL <code>REPLACE</code>), ' .
	'nếu chọn tuỳ chọn này, tất cả trùng lặp sẽ bị bỏ qua (giữ nguyên giá trị hiện tại), ' .
	'và chỉ các bản ghi có khóa mới được thêm vào bảng (SQL <code>INSERT IGNORE</code>).<br>' .
	'<strong>Lưu ý</strong>: Khi khôi phục sao lưu toàn bộ trang, tùy chọn này không có tác dụng.<br>' .
	'<br>' .
	'** Nếu sao lưu chứa tệp người dùng (toàn cục và theo trang, tệp cache, v.v.), ' .
	'trong chế độ bình thường chúng sẽ thay thế các tệp hiện có cùng tên và được đặt vào cùng thư mục khi khôi phục. ' .
	'Tùy chọn này cho phép bạn giữ bản sao hiện tại của tệp và chỉ khôi phục những tệp mới (chưa có trên máy chủ).',
	'IgnoreDuplicatedKeysNr'	=> 'Bỏ qua khóa bảng trùng lặp (không thay thế)',
	'IgnoreSameFiles'			=> 'Bỏ qua tệp giống nhau (không ghi đè)',
	'NoBackupsAvailable'		=> 'Không có bản sao lưu.',
	'BackupEntireSite'			=> 'Toàn bộ trang',
	'BackupRestored'			=> 'Bản sao lưu đã được khôi phục, báo cáo tóm tắt đính kèm dưới đây. Để xóa gói sao lưu này, nhấn',
	'BackupRemoved'				=> 'Bản sao lưu được chọn đã bị xóa thành công.',
	'LogRemovedBackup'			=> 'Đã xóa sao lưu cơ sở dữ liệu ##%1##',

	'DbEngineInvalid'			=> 'Bộ máy cơ sở dữ liệu không hợp lệ, yêu cầu %1',
	'RestoreStarted'			=> 'Bắt đầu khôi phục',
	'RestoreParameters'			=> 'Sử dụng tham số',
	'IgnoreDuplicatedKeys'		=> 'Bỏ qua khóa trùng lặp',
	'IgnoreDuplicatedFiles'		=> 'Bỏ qua tệp trùng lặp',
	'SavedCluster'				=> 'Cluster đã lưu',
	'DataProtection'			=> 'Bảo vệ dữ liệu - %1 bỏ qua',
	'AssumeDropTable'			=> 'Giả định %1',
	'RestoreSQLiteDatabase'		=> 'Khôi phục cơ sở dữ liệu SQLite',
	'SQLiteDatabaseRestored'	=> 'Đã khôi phục cơ sở dữ liệu thành công từ:',
	'RestoreTableStructure'		=> 'Khôi phục cấu trúc bảng',
	'RunSqlQueries'				=> 'Thực hiện các lệnh SQL:',
	'CompletedSqlQueries'		=> 'Hoàn thành. Lệnh đã xử lý:',
	'NoTableStructure'			=> 'Cấu trúc bảng không được lưu - bỏ qua',
	'RestoreRecords'			=> 'Khôi phục nội dung bảng',
	'ProcessTablesDump'			=> 'Tải xuống và xử lý các dump bảng',
	'Instruction'				=> 'Hướng dẫn',
	'RestoredRecords'			=> 'bản ghi:',
	'RecordsRestoreDone'		=> 'Hoàn thành. Tổng bản ghi:',
	'SkippedRecords'			=> 'Dữ liệu không được lưu - bỏ qua',
	'RestoringFiles'			=> 'Đang khôi phục tệp',
	'DecompressAndStore'		=> 'Giải nén và lưu nội dung thư mục',
	'HomonymicFiles'			=> 'tệp trùng tên',
	'RestoreSkip'				=> 'bỏ qua',
	'RestoreReplace'			=> 'thay thế',
	'RestoreFile'				=> 'Tệp:',
	'RestoredFiles'				=> 'đã khôi phục:',
	'SkippedFiles'				=> 'bị bỏ qua:',
	'FileRestoreDone'			=> 'Hoàn thành. Tổng tệp:',
	'FilesAll'					=> 'tất cả:',
	'SkipFiles'					=> 'Tệp không được lưu - bỏ qua',
	'RestoreDone'				=> 'HOÀN TẤT KHÔI PHỤC',

	'BackupCreationDate'		=> 'Ngày tạo',
	'BackupPackageContents'		=> 'Nội dung gói',
	'BackupRestore'				=> 'Khôi phục',
	'BackupRemove'				=> 'Xóa',
	'RestoreYes'				=> 'Có',
	'RestoreNo'					=> 'Không',
	'LogDbRestored'				=> 'Đã khôi phục sao lưu ##%1## của cơ sở dữ liệu.',

	'BackupArchived'			=> 'Sao lưu %1 đã được lưu trữ.',
	'BackupArchiveExists'		=> 'Kho lưu trữ sao lưu %1 đã tồn tại.',
	'LogBackupArchived'			=> 'Đã lưu trữ sao lưu ##%1##.',

	// User module
	'UsersInfo'					=> 'Tại đây bạn có thể thay đổi thông tin người dùng và một số tùy chọn cụ thể.',

	'UsersAdded'				=> 'Đã thêm người dùng',
	'UsersDeleteInfo'			=> 'Xóa người dùng:',
	'EditButton'				=> 'Chỉnh sửa',
	'UsersAddNew'				=> 'Thêm người dùng mới',
	'UsersDelete'				=> 'Bạn có chắc muốn xóa người dùng %1 không?',
	'UsersDeleted'				=> 'Người dùng %1 đã bị xóa khỏi cơ sở dữ liệu.',
	'UsersRename'				=> 'Đổi tên người dùng %1 thành',
	'UsersRenameInfo'			=> '* Lưu ý: Thay đổi sẽ ảnh hưởng tới tất cả trang được gán cho người dùng đó.',
	'UsersUpdated'				=> 'Cập nhật người dùng thành công.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Thời gian đăng ký',
	'UserActions'				=> 'Hành động',
	'NoMatchingUser'			=> 'Không có người dùng phù hợp tiêu chí',

	'UserAccountNotify'			=> 'Thông báo người dùng',
	'UserNotifySignup'			=> 'thông báo người dùng về tài khoản mới',
	'UserVerifyEmail'			=> 'đặt token xác nhận email và thêm liên kết xác minh email',
	'UserReVerifyEmail'			=> 'Gửi lại token xác nhận email',

	// Groups module
	'GroupsInfo'				=> 'Từ bảng điều khiển này bạn có thể quản lý tất cả nhóm người dùng. Bạn có thể xóa, tạo và chỉnh sửa nhóm. Thêm vào đó, bạn có thể chọn người quản lý nhóm, thay đổi trạng thái mở/ẩn/khóa và đặt tên cùng mô tả nhóm.',

	'LogMembersUpdated'			=> 'Đã cập nhật thành viên nhóm',
	'LogMemberAdded'			=> 'Đã thêm thành viên ##%1## vào nhóm ##%2##',
	'LogMemberRemoved'			=> 'Đã xóa thành viên ##%1## khỏi nhóm ##%2##',
	'LogGroupCreated'			=> 'Đã tạo nhóm mới ##%1##',
	'LogGroupRenamed'			=> 'Nhóm ##%1## đã đổi tên thành ##%2##',
	'LogGroupRemoved'			=> 'Đã xóa nhóm ##%1##',

	'GroupsMembersFor'			=> 'Thành viên của Nhóm',
	'GroupsDescription'			=> 'Mô tả',
	'GroupsModerator'			=> 'Người điều hành',
	'GroupsOpen'				=> 'Mở',
	'GroupsActive'				=> 'Hoạt động',
	'GroupsTip'					=> 'Nhấp để chỉnh sửa Nhóm',
	'GroupsUpdated'				=> 'Đã cập nhật nhóm',
	'GroupsAlreadyExists'		=> 'Nhóm này đã tồn tại.',
	'GroupsAdded'				=> 'Đã thêm nhóm thành công.',
	'GroupsRenamed'				=> 'Đã đổi tên nhóm thành công.',
	'GroupsDeleted'				=> 'Nhóm %1 và tất cả trang liên quan đã bị xóa khỏi cơ sở dữ liệu.',
	'GroupsAdd'					=> 'Thêm nhóm mới',
	'GroupsRename'				=> 'Đổi tên nhóm %1 thành',
	'GroupsRenameInfo'			=> '* Lưu ý: Thay đổi sẽ ảnh hưởng tới tất cả trang được gán cho nhóm này.',
	'GroupsDelete'				=> 'Bạn có chắc muốn xóa nhóm %1 không?',
	'GroupsDeleteInfo'			=> '* Lưu ý: Thay đổi sẽ ảnh hưởng tới tất cả thành viên thuộc nhóm này.',
	'GroupsIsSystem'			=> 'Nhóm %1 thuộc hệ thống và không thể xóa.',
	'GroupsStoreButton'			=> 'Lưu nhóm',
	'GroupsEditInfo'			=> 'Để chỉnh sửa danh sách nhóm, chọn nút radio.',

	'GroupAddMember'			=> 'Thêm thành viên',
	'GroupRemoveMember'			=> 'Xóa thành viên',
	'GroupAddNew'				=> 'Thêm nhóm',
	'GroupEdit'					=> 'Chỉnh sửa nhóm',
	'GroupDelete'				=> 'Xóa nhóm',

	'MembersAddNew'				=> 'Thêm thành viên mới',
	'MembersAdded'				=> 'Đã thêm thành viên mới vào nhóm thành công.',
	'MembersRemove'				=> 'Bạn có chắc muốn xóa thành viên %1 không?',
	'MembersRemoved'			=> 'Thành viên đã bị xóa khỏi nhóm.',

	// Statistics module
	'DbStatSection'				=> 'Thống kê cơ sở dữ liệu',
	'DbTable'					=> 'Bảng',
	'DbRecords'					=> 'Bản ghi',
	'DbSize'					=> 'Kích thước',
	'DbIndex'					=> 'Chỉ mục',
	'DbTotal'					=> 'Tổng',

	'FileStatSection'			=> 'Thống kê hệ thống tệp',
	'FileFolder'				=> 'Thư mục',
	'FileFiles'					=> 'Tệp',
	'FileSize'					=> 'Kích thước',
	'FileTotal'					=> 'Tổng',

	// Sysinfo module
	'SysInfo'					=> 'Thông tin phiên bản:',
	'SysParameter'				=> 'Tham số',
	'SysValues'					=> 'Giá trị',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Cập nhật gần nhất',
	'ServerOS'					=> 'Hệ điều hành',
	'ServerName'				=> 'Tên máy chủ',
	'WebServer'					=> 'Máy chủ Web',
	'HttpProtocol'				=> 'Giao thức HTTP',
	'DbVersion'					=> 'Cơ sở dữ liệu',
	'SqlModesGlobal'			=> 'Chế độ SQL toàn cục',
	'SqlModesSession'			=> 'Chế độ SQL phiên',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Bộ nhớ',
	'UploadFilesizeMax'			=> 'Kích thước file tải lên tối đa',
	'PostMaxSize'				=> 'Kích thước POST tối đa',
	'MaxExecutionTime'			=> 'Thời gian thực thi tối đa',
	'SessionPath'				=> 'Đường dẫn phiên',
	'PhpDefaultCharset'			=> 'Charset mặc định PHP',
	'GZipCompression'			=> 'Nén GZip',
	'PhpExtensions'				=> 'Tiện ích mở rộng PHP',
	'ApacheModules'				=> 'Modules Apache',

	// DB repair module
	'DbRepairSection'			=> 'Sửa cơ sở dữ liệu',
	'DbRepair'					=> 'Sửa cơ sở dữ liệu',
	'DbRepairInfo'				=> 'Script này có thể tìm và tự động sửa một số lỗi thường gặp của cơ sở dữ liệu. Việc sửa chữa có thể mất thời gian, vui lòng kiên nhẫn.',

	'DbOptimizeRepairSection'	=> 'Sửa và tối ưu cơ sở dữ liệu',
	'DbOptimizeRepair'			=> 'Sửa và tối ưu cơ sở dữ liệu',
	'DbOptimizeRepairInfo'		=> 'Script này cũng có thể cố gắng tối ưu hóa cơ sở dữ liệu. Điều này cải thiện hiệu năng trong một số tình huống. Việc sửa và tối ưu có thể mất nhiều thời gian và cơ sở dữ liệu sẽ bị khóa trong quá trình tối ưu.',

	'TableOk'					=> 'Bảng %1 ổn định.',
	'TableNotOk'				=> 'Bảng %1 không ổn. Báo lỗi: %2. Script này sẽ cố gắng sửa bảng&hellip;',
	'TableRepaired'				=> 'Đã sửa thành công bảng %1.',
	'TableRepairFailed'			=> 'Không sửa được bảng %1. <br>Lỗi: %2',
	'TableAlreadyOptimized'		=> 'Bảng %1 đã được tối ưu.',
	'TableOptimized'			=> 'Đã tối ưu thành công bảng %1.',
	'TableOptimizeFailed'		=> 'Không tối ưu được bảng %1. <br>Lỗi: %2',
	'TableNotRepaired'			=> 'Một số lỗi cơ sở dữ liệu không thể sửa.',
	'RepairsComplete'			=> 'Hoàn tất sửa chữa',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Hiển thị và sửa các bất nhất, xóa hoặc gán lại các bản ghi mồ côi cho người dùng/giá trị mới.',
	'Inconsistencies'			=> 'Bất nhất',
	'CheckDatabase'				=> 'Cơ sở dữ liệu',
	'CheckDatabaseInfo'			=> 'Kiểm tra các bản ghi không nhất quán trong cơ sở dữ liệu.',
	'CheckFiles'				=> 'Tệp',
	'CheckFilesInfo'			=> 'Kiểm tra các tệp bị bỏ rơi, tệp không còn tham chiếu trong bảng tệp.',
	'Records'					=> 'Bản ghi',
	'InconsistenciesNone'		=> 'Không tìm thấy bất nhất dữ liệu.',
	'InconsistenciesDone'		=> 'Đã giải quyết bất nhất dữ liệu.',
	'InconsistenciesRemoved'	=> 'Đã xóa các bất nhất',
	'Check'						=> 'Kiểm tra',
	'Solve'						=> 'Giải quyết',

	// Bad Behaviour module
	'BbInfo'					=> 'Phát hiện và chặn truy cập web không mong muốn, từ chối truy cập của spambots tự động.<br>Để biết thêm, vui lòng truy cập trang chủ %1.',
	'BbEnable'					=> 'Bật Bad Behaviour:',
	'BbEnableInfo'				=> 'Tất cả các cài đặt khác có thể thay đổi trong thư mục cấu hình %1.',
	'BbStats'					=> 'Bad Behaviour đã chặn %1 lần truy cập trong 7 ngày qua.',

	'BbSummary'					=> 'Tóm tắt',
	'BbLog'						=> 'Nhật ký',
	'BbSettings'				=> 'Cài đặt',
	'BbWhitelist'				=> 'Danh sách trắng',

	// --> Log
	'BbHits'					=> 'Lượt truy cập',
	'BbRecordsFiltered'			=> 'Hiển thị %1 trên %2 bản ghi được lọc bởi',
	'BbStatus'					=> 'Trạng thái',
	'BbBlocked'					=> 'Bị chặn',
	'BbPermitted'				=> 'Được phép',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Hiển thị tất cả %1 bản ghi',
	'BbShow'					=> 'Hiển thị',
	'BbIpDateStatus'			=> 'IP/Ngày/Trạng thái',
	'BbHeaders'					=> 'Headers',
	'BbEntity'					=> 'Thực thể',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Đã lưu tùy chọn.',
	'BbWhitelistHint'			=> 'Thêm vào danh sách trắng không phù hợp SẼ khiến bạn dễ chịu spam hoặc khiến Bad Behaviour ngừng hoạt động hoàn toàn! KHÔNG THÊM VÀO DANH SÁCH TRẮNG trừ khi bạn CHẮC CHẮN 100% nên làm vậy.',
	'BbIpAddress'				=> 'Địa chỉ IP',
	'BbIpAddressInfo'			=> 'Địa chỉ IP hoặc dải địa chỉ CIDR để thêm vào danh sách trắng (mỗi dòng một mục)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'Đoạn URL bắt đầu bằng / sau hostname của trang web (mỗi dòng một mục)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'Chuỗi user agent để thêm vào danh sách trắng (mỗi dòng một mục)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Đã cập nhật cài đặt Bad Behaviour',
	'BbLogRequest'				=> 'Ghi nhật ký yêu cầu HTTP',
	'BbLogVerbose'				=> 'Chi tiết',
	'BbLogNormal'				=> 'Bình thường (khuyến nghị)',
	'BbLogOff'					=> 'Không ghi (không khuyến nghị)',
	'BbSecurity'				=> 'Bảo mật',
	'BbStrict'					=> 'Kiểm tra nghiêm ngặt',
	'BbStrictInfo'				=> 'chặn nhiều spam hơn nhưng có thể chặn một số người thật',
	'BbOffsiteForms'			=> 'Cho phép gửi form từ các trang khác',
	'BbOffsiteFormsInfo'		=> 'cần cho OpenID; tăng lượng spam nhận được',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Để sử dụng tính năng http:BL của Bad Behaviour bạn phải có %1',
	'BbHttpblKey'				=> 'Khóa truy cập http:BL',
	'BbHttpblThreat'			=> 'Mức độ đe dọa tối thiểu (khuyến nghị 25)',
	'BbHttpblMaxage'			=> 'Độ tuổi dữ liệu tối đa (khuyến nghị 30)',
	'BbReverseProxy'			=> 'Reverse Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'Nếu bạn dùng Bad Behaviour sau reverse proxy, load balancer, HTTP accelerator, cache hay công nghệ tương tự, bật tùy chọn Reverse Proxy.<br>' .
	'Nếu có chuỗi hai hoặc nhiều reverse proxy giữa máy chủ và Internet công cộng, bạn phải liệt kê <em>tất cả</em> dải địa chỉ IP (định dạng CIDR) của các proxy, load balancer, v.v. Nếu không, Bad Behaviour có thể không xác định được IP thực của client.<br>' .
	'Ngoài ra, các proxy phải đặt địa chỉ IP của client Internet gửi yêu cầu vào một header HTTP. Nếu bạn không chỉ định header, %1 sẽ được dùng. Hầu hết proxy hỗ trợ X-Forwarded-For và bạn chỉ cần đảm bảo nó được bật trên proxy. Một số tên header khác thường dùng gồm %2 và %3.',
	'BbReverseProxyEnable'		=> 'Bật Reverse Proxy',
	'BbReverseProxyHeader'		=> 'Header chứa địa chỉ IP của client Internet',
	'BbReverseProxyAddresses'	=> 'Địa chỉ IP hoặc dải CIDR của các máy chủ proxy (mỗi dòng một mục)',

];
