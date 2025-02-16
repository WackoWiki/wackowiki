<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'الوظائف الأساسية',
		'preferences'	=> 'التفضيلات',
		'content'		=> 'محتوى',
		'users'			=> 'المستخدمون',
		'maintenance'	=> 'صيانة',
		'messages'		=> 'الرسائل',
		'extension'		=> 'ملحق',
		'database'		=> 'قاعدة البيانات',
	],

	// Admin panel
	'AdminPanel'				=> 'لوحة تحكم الإدارة',
	'RecoveryMode'				=> 'وضع الاسترداد',
	'Authorization'				=> 'التصريح',
	'AuthorizationTip'			=> 'الرجاء إدخال كلمة المرور الإدارية (تأكد من أن ملفات تعريف الارتباط مسموح بها في المتصفح الخاص بك).',
	'NoRecoveryPassword'		=> 'لم يتم تحديد كلمة المرور الإدارية!',
	'NoRecoveryPasswordTip'		=> 'ملاحظة: عدم وجود كلمة مرور إدارية هو تهديد للأمن! أدخل تجزئة كلمة المرور الخاصة بك في ملف التكوين وتشغيل البرنامج مرة أخرى.',

	'ErrorLoadingModule'		=> 'خطأ في تحميل وحدة المشرف %1: غير موجود.',

	'ApHomePage'				=> 'الصفحة الرئيسية',
	'ApHomePageTip'				=> 'إنهاء إدارة النظام وفتح الصفحة الرئيسية',
	'ApLogOut'					=> 'خروج',
	'ApLogOutTip'				=> 'إنهاء إدارة النظام وتسجيل الخروج من الموقع',

	'TimeLeft'					=> 'الوقت المتبقي:  %1 دقيقة',
	'ApVersion'					=> 'الإصدار',

	'SiteOpen'					=> 'فتح',
	'SiteOpened'				=> 'تم فتح الموقع',
	'SiteOpenedTip'				=> 'الموقع مفتوح',
	'SiteClose'					=> 'أغلق',
	'SiteClosed'				=> 'الموقع مغلق',
	'SiteClosedTip'				=> 'الموقع مغلق',

	'System'					=> 'النظام',

	// Generic
	'Cancel'					=> 'ألغ',
	'Add'						=> 'إضافة',
	'Edit'						=> 'تحرير',
	'Remove'					=> 'إزالة',
	'Enabled'					=> 'مفعل',
	'Disabled'					=> 'معطل',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'المشرف',
	'Min'						=> 'الحد الأدنى',
	'Max'						=> 'الحد الأقصى',

	'MiscellaneousSection'		=> 'متنوعات',
	'MainSection'				=> 'خيارات عامة',

	'DirNotWritable'			=> 'دليل %1 غير قابل للكتابة.',
	'FileNotWritable'			=> 'ملف %1 غير قابل للكتابة.',

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
		'name'		=> 'اساسي',
		'title'		=> 'الإعدادات الأساسية',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'المظهر',
		'title'		=> 'إعدادات المظهر',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'البريد الإلكتروني',
		'title'		=> 'إعدادات البريد الإلكتروني',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'نقابة',
		'title'		=> 'إعدادات النقابة',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'تصفية',
		'title'		=> 'إعدادات الفلتر',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'فورت',
		'title'		=> 'خيارات التنسيق',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'الإشعارات',
		'title'		=> 'إعدادات الإشعارات',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'صفحات',
		'title'		=> 'الصفحات ومعالم الموقع',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'الأذونات',
		'title'		=> 'إعدادات الأذونات',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'أمان',
		'title'		=> 'إعدادات أنظمة الحماية الفرعية',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'النظام',
		'title'		=> 'خيارات النظام',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'تحميل',
		'title'		=> 'إعدادات المرفقات',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'محذوف',
		'title'		=> 'المحتوى المحذوف حديثاً',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'القائمة',
		'title'		=> 'إضافة عناصر القائمة الافتراضية أو تعديلها أو إزالتها',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'نسخة احتياطية',
		'title'		=> 'النسخ الاحتياطي للبيانات',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'إصلاح',
		'title'		=> 'إصلاح وتحسين قاعدة البيانات',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'إستعادة',
		'title'		=> 'استعادة بيانات النسخ الاحتياطي',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'القائمة الرئيسية',
		'title'		=> 'إدارة WackoWiki',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'التناقضات',
		'title'		=> 'تثبيت عدم اتساق البيانات',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'مزامنة البيانات',
		'title'		=> 'مزامنة البيانات',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'البريد الإلكتروني الشامل',
		'title'		=> 'البريد الإلكتروني الشامل',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'رسالة النظام',
		'title'		=> 'رسائل النظام',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'معلومات النظام',
		'title'		=> 'معلومات النظام',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'سجل النظام',
		'title'		=> 'سجل أحداث النظام',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'الإحصائيات',
		'title'		=> 'إظهار الإحصائيات',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'سلوك سيء',
		'title'		=> 'سلوك سيء',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'الموافقة',
		'title'		=> 'موافقة تسجيل المستخدم',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'المجموعات',
		'title'		=> 'إدارة المجموعة',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'المستخدمون',
		'title'		=> 'إدارة المستخدم',
	],

	// Main module
	'MainNote'					=> 'ملاحظة: يوصى بحظر الدخول إلى الموقع مؤقتا لأغراض الصيانة الإدارية.',

	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'إزالة جميع الجلسات',
	'PurgeSessionsConfirm'		=> 'هل أنت متأكد من رغبتك في إزالة جميع الجلسات؟ سيؤدي هذا إلى تسجيل الخروج من جميع المستخدمين.',
	'PurgeSessionsExplain'		=> 'تطهير جميع الجلسات. سيؤدي هذا إلى تسجيل خروج جميع المستخدمين عن طريق اقتطاع جدول Tok_token',
	'PurgeSessionsDone'			=> 'تم إزالة الجلسات بنجاح.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'تحديث الإعدادات الأساسية',
	'LogBasicSettingsUpdated'	=> 'تحديث الإعدادات الأساسية',

	'SiteName'					=> 'اسم الموقع:',
	'SiteNameInfo'				=> 'عنوان هذا الموقع. يظهر على عنوان المتصفح، وعنوان الموضوع، وإشعار البريد الإلكتروني، إلخ.',
	'SiteDesc'					=> 'وصف الموقع:',
	'SiteDescInfo'				=> 'ملحق لعنوان الموقع الذي يظهر في عنوان الصفحات. يشرح، ببضع كلمات، ما هو هذا الموقع.',
	'AdminName'					=> 'مشرف الموقع:',
	'AdminNameInfo'				=> 'اسم المستخدم للفرد المسؤول عن الدعم العام للموقع. هذا الاسم غير مستخدم لتحديد حقوق الوصول، ولكن من المستصوب أن يكون ذلك متوافقا مع اسم كبير مديري الموقع.',

	'LanguageSection'			=> 'اللغة',
	'DefaultLanguage'			=> 'اللغة الافتراضية:',
	'DefaultLanguageInfo'		=> 'يحدد لغة الرسائل المعروضة على الضيوف غير المسجلين، وكذلك إعدادات المحليات.',
	'MultiLanguage'				=> 'دعم تعدد اللغات:',
	'MultiLanguageInfo'			=> 'تمكين القدرة على اختيار لغة على أساس كل صفحة على حدة.',
	'AllowedLanguages'			=> 'اللغات المسموح بها:',
	'AllowedLanguagesInfo'		=> 'من المستحسن فقط تحديد مجموعة اللغات التي تريد استخدامها، وإلا تم تحديد جميع اللغات.',

	'CommentSection'			=> 'تعليقات',
	'AllowComments'				=> 'السماح بالتعليقات:',
	'AllowCommentsInfo'			=> 'تمكين التعليقات للضيوف أو المستخدمين المسجلين فقط، أو تعطيلها على الموقع بأكمله.',
	'SortingComments'			=> 'فرز التعليقات:',
	'SortingCommentsInfo'		=> 'يقوم بتغيير الترتيب الذي يتم تقديم تعليقات الصفحة فيه، إما مع أحدث تعليق أو أقدم تعليق في الأعلى.',

	'ToolbarSection'			=> 'شريط الأدوات',
	'CommentsPanel'				=> 'فريق التعليقات:',
	'CommentsPanelInfo'			=> 'العرض الافتراضي للتعليقات في الجزء السفلي من الصفحة.',
	'FilePanel'					=> 'لوحة الملف:',
	'FilePanelInfo'				=> 'العرض الافتراضي للمرفقات في الجزء السفلي من الصفحة.',
	'TagsPanel'					=> 'لوحة العلامات:',
	'TagsPanelInfo'				=> 'العرض الافتراضي للوحة العلامات في الجزء السفلي من الصفحة.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'إظهار الرابط الدائم:',
	'ShowPermalinkInfo'			=> 'العرض الافتراضي للرابط الثابت للإصدار الحالي من الصفحة.',
	'TocPanel'					=> 'لوحة محتويات الجدول:',
	'TocPanelInfo'				=> 'جدول العرض الافتراضي للوحة المحتويات في صفحة ما (قد تحتاج إلى دعم في القوالب).',
	'SectionsPanel'				=> 'فريق الأقسام:',
	'SectionsPanelInfo'			=> 'بشكل افتراضي، عرض لوحة الصفحات المتاخمة (يتطلب الدعم في القوالب).',
	'DisplayingSections'		=> 'عرض الأقسام:',
	'DisplayingSectionsInfo'	=> 'عندما يتم تعيين الخيارات السابقة، ما إذا كان سيتم عرض الصفحات الفرعية للصفحة فقط (<em>أسفل</em>)، الجار فقط (<em>أعلى</em>) ، أو كليهما ، أو أي نوع آخر (<em>شجرة</em>).',
	'MenuItems'					=> 'عناصر القائمة:',
	'MenuItemsInfo'				=> 'العدد الافتراضي لعناصر القائمة المعروضة (قد تحتاج إلى دعم في القوالب).',

	'HandlerSection'			=> 'Handlers',
	'HideRevisions'				=> 'إخفاء المراجعات:',
	'HideRevisionsInfo'			=> 'العرض الافتراضي للمراجعات للصفحة.',
	'AttachmentHandler'			=> 'تمكين معالج المرفقات:',
	'AttachmentHandlerInfo'		=> 'تصاريح عرض معالج المرفقات.',
	'SourceHandler'				=> 'تمكين معالج المصدر:',
	'SourceHandlerInfo'			=> 'يسمح بعرض معالج المصدر.',
	'ExportHandler'				=> 'تمكين متعامل تصدير XML:',
	'ExportHandlerInfo'			=> 'يسمح بعرض مناول التصدير XML.',

	'DiffModeSection'			=> 'أوضاع الاختلاف',
	'DefaultDiffModeSetting'	=> 'وضع الفاصل الافتراضي:',
	'DefaultDiffModeSettingInfo'=> 'وضع الخلاف المختار مسبقاً.',
	'AllowedDiffMode'			=> 'مسموح بموضوعات التقسيم:',
	'AllowedDiffModeInfo'		=> 'من المستحسن تحديد فقط مجموعة من الأوضاع التي تريد استخدامها، وإلا تم تحديد جميع أوضاع التقسيم.',
	'NotifyDiffMode'			=> 'وضع التنبيه:',
	'NotifyDiffModeInfo'		=> 'وضع الاختلاف المستخدم للإشعارات في نص البريد الإلكتروني.',

	'EditingSection'			=> 'تحرير',
	'EditSummary'				=> 'تحرير الموجز:',
	'EditSummaryInfo'			=> 'إظهار تغيير الملخص في وضع التحرير.',
	'MinorEdit'					=> 'تحرير طفيف:',
	'MinorEditInfo'				=> 'تمكين خيار تحرير طفيف في وضع التحرير.',
	'SectionEdit'				=> 'تحرير القسم',
	'SectionEditInfo'			=> 'تمكين تحرير قسم فقط من الصفحة.',
	'ReviewSettings'			=> 'مراجعة:',
	'ReviewSettingsInfo'		=> 'تمكين خيار المراجعة في وضع التحرير.',
	'PublishAnonymously'		=> 'السماح بالنشر المجهول:',
	'PublishAnonymouslyInfo'	=> 'السماح للمستخدمين بنشر مجهول (إخفاء الاسم).',

	'DefaultRenameRedirect'		=> 'عند إعادة التسمية، أنشئ إعادة التوجيه:',
	'DefaultRenameRedirectInfo'	=> 'بشكل افتراضي، عرض إعادة توجيه إلى العنوان القديم للصفحة التي يتم إعادة تسميتها.',
	'StoreDeletedPages'			=> 'إبقاء الصفحات المحذوفة:',
	'StoreDeletedPagesInfo'		=> 'عند حذف صفحة، تعليق أو ملف، الاحتفاظ به في قسم خاص، حيث ستكون متاحة للاستعراض والاسترداد لفترة ما من الزمن (على النحو المبين أدناه).',
	'KeepDeletedTime'			=> 'وقت التخزين للصفحات المحذوفة:',
	'KeepDeletedTimeInfo'		=> 'الفترة في أيام. لا معنى لها إلا فيما يتعلق بالخيار السابق. استخدم صفر لضمان عدم حذف الكيانات أبداً (في هذه الحالة يمكن للمدير مسح "سلة التسوق" يدوياً).',
	'PagesPurgeTime'			=> 'وقت التخزين لمراجعات الصفحات:',
	'PagesPurgeTimeInfo'		=> 'حذف الإصدارات القديمة تلقائياً ضمن عدد معين من الأيام. إذا قمت بإدخال صفر، فلن تتم إزالة الإصدارات القديمة.',
	'EnableReferrers'			=> 'تمكين الإحالة:',
	'EnableReferrersInfo'		=> 'تصاريح إنشاء وعرض الإحالات الخارجية.',
	'ReferrersPurgeTime'		=> 'وقت التخزين من الإحالة:',
	'ReferrersPurgeTimeInfo'	=> 'الحفاظ على تاريخ إحالة الصفحات الخارجية كحد أقصى من عدد معين من الأيام. استخدم صفر لضمان عدم حذف الإحالات أبداً (ولكن بالنسبة للموقع الذي تمت زيارته بنشاط، يمكن أن يؤدي هذا إلى تدفق قاعدة البيانات).',
	'EnableCounters'			=> 'مضادات الضغط:',
	'EnableCountersInfo'		=> 'يسمح بعدادات الضغط على كل صفحة ويمكّن عرض الإحصاءات البسيطة. لا يتم حساب آراء مالك الصفحة.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'التحكم في إعدادات مجموعة الويب الافتراضية لموقعك.',
	'SyndicationSettingsUpdated'	=> 'تم تحديث إعدادات المؤسسة.',

	'FeedsSection'				=> 'التحديثات',
	'EnableFeeds'				=> 'تمكين الخلاصات:',
	'EnableFeedsInfo'			=> 'تشغيل تغذية RSS أو إيقاف تشغيلها لكامل الويكي.',
	'XmlChangeLink'				=> 'تغيير وضع رابط التحديث:',
	'XmlChangeLinkInfo'			=> 'يحدد المكان الذي يتم فيه تغيير روابط عناصر تغذية XML.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'عرض الفرق',
		'2'		=> 'الصفحة المنقحة',
		'3'		=> 'قائمة التنقيحات',
		'4'		=> 'الصفحة الحالية',
	],

	'XmlSitemap'				=> 'XML sitemap:',
	'XmlSitemapInfo'			=> 'ينشئ ملف XML يسمى %1 داخل مجلد xml. يمكنك إضافة المسار إلى خريطة الموقع في ملف robots.txt في الدليل الجذر الخاص بك على النحو التالي:',
	'XmlSitemapGz'				=> 'ضغط خريطة موقع XML:',
	'XmlSitemapGzInfo'			=> 'إذا كنت ترغب في ذلك، قد تضغط على ملف sitemap النص باستخدام gzip لتقليل متطلبات عرض النطاق الترددي الخاص بك.',
	'XmlSitemapTime'			=> 'وقت إنشاء خريطة موقع XML:',
	'XmlSitemapTimeInfo'		=> 'ينشئ خريطة الموقع مرة واحدة فقط في عدد الأيام المحددة. تعيين إلى صفر لتوليد كل تغيير في الصفحة.',

	'SearchSection'				=> 'ابحث',
	'OpenSearch'				=> 'فتح البحث:',
	'OpenSearchInfo'			=> 'ينشئ ملف وصف OpenSearch في مجلد XML ويمكّن الاكتشاف التلقائي لملحق البحث في رأس HTML.',
	'SearchEngineVisibility'	=> 'حظر محركات البحث (رؤية محرك البحث):',
	'SearchEngineVisibilityInfo'=> 'Block search engines, but allow normal visitors. Overrides page settings. <br>Discourage search engines from indexing this site. It is up to search engines to honor this request.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'التحكم في إعدادات العرض الافتراضية لموقعك.',
	'AppearanceSettingsUpdated'	=> 'إعدادات المظهر المحدثة.',

	'LogoOff'					=> 'متوقف',
	'LogoOnly'					=> 'الشعار',
	'LogoAndTitle'				=> 'الشعار والعنوان',

	'LogoSection'				=> 'الشعار',
	'SiteLogo'					=> 'شعار الموقع:',
	'SiteLogoInfo'				=> 'الشعار الخاص بك سيظهر عادة في الزاوية العلوية اليسرى من التطبيق. الحد الأقصى للحجم هو 2 ميجابايت. الأبعاد المثلى هي 255 بكسل بعرض 55 بكسل.',
	'LogoDimensions'			=> 'أبعاد الشعار:',
	'LogoDimensionsInfo'		=> 'عرض وارتفاع الشعار المعروض.',
	'LogoDisplayMode'			=> 'وضع عرض الشعار:',
	'LogoDisplayModeInfo'		=> 'يحدد مظهر الشعار. الافتراضي غير مفعل.',

	'FaviconSection'			=> 'فافيتشون',
	'SiteFavicon'				=> 'الموقع الافتراضي:',
	'SiteFaviconInfo'			=> 'يتم عرض أيقونة الاختصار، أو favicon، في شريط العنوان، علامات التبويب والعلامات المرجعية لمعظم المتصفحات. هذا سيتجاوز المظهر الخاص بك.',
	'SiteFaviconTooBig'			=> 'فافيكون أكبر من 64 × 64 بكسل.',
	'ThemeColor'				=> 'لون السمة لشريط العنوان:',
	'ThemeColorInfo'			=> 'سيقوم المتصفح بتعيين لون شريط العناوين لكل صفحة وفقا للون CSS المتوفرة.',

	'LayoutSection'				=> 'تخطيط',
	'Theme'						=> 'السمة:',
	'ThemeInfo'					=> 'تصميم القالب يستخدم الموقع بشكل افتراضي.',
	'ResetUserTheme'			=> 'إعادة تعيين جميع سمات المستخدم:',
	'ResetUserThemeInfo'		=> 'إعادة تعيين جميع سمات المستخدم. تحذير: هذا الإجراء سوف يعيد جميع السمات المحددة للمستخدم إلى السمة الافتراضية العالمية.',
	'SetBackUserTheme'			=> 'إرجاع جميع سمات المستخدم إلى سمة %1.',
	'ThemesAllowed'				=> 'السمات المسموح بها:',
	'ThemesAllowedInfo'			=> 'حدد السمات المسموح بها، والتي يمكن للمستخدم أن يختارها؛ وإلا فإن جميع السمات المتاحة مسموح بها.',
	'ThemesPerPage'				=> 'السمات لكل صفحة:',
	'ThemesPerPageInfo'			=> 'السماح بالسمات لكل صفحة، والتي يمكن لمالك الصفحة أن يختارها عبر خصائص الصفحة.',

	// System settings
	'SystemSettingsInfo'		=> 'مجموعة من المعلمات المسؤولة عن ضبط الموقع. لا تقم بتغييرها إلا إذا كنت واثقا من أعمالها.',
	'SystemSettingsUpdated'		=> 'تحديث إعدادات النظام',

	'DebugModeSection'			=> 'وضع التصحيح',
	'DebugMode'					=> 'وضع التصحيح:',
	'DebugModeInfo'				=> 'استخراج واستخراج بيانات القياس عن بعد حول وقت تنفيذ التطبيق. انتباه: يفرض وضع التفاصيل الكاملة متطلبات أعلى على الذاكرة المخصصة، ولا سيما بالنسبة للعمليات الكثيفة الاستخدام للموارد، مثل النسخ الاحتياطي لقاعدة البيانات واستعادتها.',
	'DebugModes'	=> [
		'0'		=> 'تصحيح الأخطاء متوقف',
		'1'		=> 'فقط مجموع وقت التنفيذ',
		'2'		=> 'متفرغ',
		'3'		=> 'التفاصيل الكاملة (DBMS، المخبئ، إلخ.)',
	],
	'DebugSqlThreshold'			=> 'أداء عتبة RDBMS:',
	'DebugSqlThresholdInfo'		=> 'في وضع التصحيح المفصل، أبلغ فقط عن الاستفسارات التي تستغرق وقتا أطول من عدد الثواني المحددة.',
	'DebugAdminOnly'			=> 'التشخيص المغلق:',
	'DebugAdminOnlyInfo'		=> 'إظهار بيانات تصحيح أخطاء البرنامج (و DBMS) فقط للمدير.',

	'CachingSection'			=> 'خيارات التخزين المؤقت',
	'Cache'						=> 'ذاكرة التخزين المؤقت للصفحات:',
	'CacheInfo'					=> 'حفظ الصفحات التي تم توفيرها في ذاكرة التخزين المؤقت المحلية لتسريع التشغيل اللاحق. صالح فقط للزوار غير المسجلين.',
	'CacheTtl'					=> 'وقت الحياة للصفحات المخزنة مؤقتاً:',
	'CacheTtlInfo'				=> 'صفحات ذاكرة التخزين المؤقت لا أكثر من عدد محدد من الثواني.',
	'CacheSql'					=> 'استفسارات DBMS المخبئة:',
	'CacheSqlInfo'				=> 'الحفاظ على مخبأ محلي لنتائج بعض استفسارات SQL ذات الصلة بالموارد.',
	'CacheSqlTtl'				=> 'وقت الحياة لاستفسارات SQL المخزنة مؤقتاً:',
	'CacheSqlTtlInfo'			=> 'نتائج التخزين المؤقت لاستفسارات SQL لمدة لا تزيد عن عدد الثواني المحدد. القيم التي تزيد عن 1200 غير مرغوب فيها.',

	'LogSection'				=> 'إعدادات السجل',
	'LogLevelUsage'				=> 'استخدام التسجيل:',
	'LogLevelUsageInfo'			=> 'الأولوية الدنيا للأحداث المسجلة في السجل.',
	'LogThresholds'	=> [
		'0'		=> 'لا تحتفظ بمجلة',
		'1'		=> 'المستوى الحرج فقط',
		'2'		=> 'من أعلى مستوى',
		'3'		=> 'من عالي',
		'4'		=> 'في المتوسط',
		'5'		=> 'من منخفض',
		'6'		=> 'الحد الأدنى للمستوى',
		'7'		=> 'تسجيل الكل',
	],
	'LogDefaultShow'			=> 'وضع سجل العرض:',
	'LogDefaultShowInfo'		=> 'الحد الأدنى من الأحداث ذات الأولوية المعروضة في السجل بشكل افتراضي.',
	'LogModes'	=> [
		'1'		=> 'المستوى الحرج فقط',
		'2'		=> 'من أعلى مستوى',
		'3'		=> 'من المستوى الرفيع',
		'4'		=> 'متوسط',
		'5'		=> 'من منخفض',
		'6'		=> 'من الحد الأدنى للمستوى',
		'7'		=> 'إظهار الكل',
	],
	'LogPurgeTime'				=> 'وقت التخزين للسجل:',
	'LogPurgeTimeInfo'			=> 'إزالة سجل الأحداث بعد عدد الأيام المحدد.',

	'PrivacySection'			=> 'الخصوصية',
	'AnonymizeIp'				=> 'إخفاء هوية عناوين IP للمستخدمين:',
	'AnonymizeIpInfo'			=> 'إخفاء هوية عناوين IP عند الاقتضاء (أي الصفحة أو التنقيح أو الإحالة).',

	'ReverseProxySection'		=> 'عكس الوكيل',
	'ReverseProxy'				=> 'استخدام الوكيل العكسي:',
    'ReverseProxyInfo'			=> 
    'تمكين هذا الإعداد لتحديد عنوان IP الصحيح للعميل البعيد عن طريق فحص المعلومات المخزنة في رأس X-Forwarded-for heads. وتعتبر الرؤوس من طراز X-Forwarded-for آلية قياسية لتحديد نظم الزبائن الموصولة من خلال خادم وكيل عكسي، مثل Squid أو Pound. وكثيرا ما تستخدم خوادم الوكيل المعاكسة لتعزيز أداء المواقع التي تمت زيارتها بكثافة وقد توفر أيضا مزايا أخرى للتخزين الاحتياطي أو الأمن أو التشفير. إذا كان هذا التثبيت WackoWiki يعمل خلف وكيل عكسي، وينبغي تمكين هذا الإعداد بحيث يتم التقاط المعلومات الصحيحة عن عنوان IP في نظم إدارة دورات واكوويكي، وقطع الأخشاب والإحصاءات وإدارة الوصول؛ إذا كنت غير متأكد من هذا الإعداد، ليس لديك وكيل عكسي، أو يعمل WackoWiki في بيئة استضافة مشتركة، يجب أن يظل هذا الإعداد معطلًا.',
	'ReverseProxyHeader'		=> 'عكس اتجاه البروكسي:',
	'ReverseProxyHeaderInfo'	=> 'عيّن هذه القيمة إذا كان الخادم الوكيل الخاص بك يرسل IP العميل في رأس
									 <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> بخلاف X-Forwarded-For. عنوان "X-Forwarded-For" هو قائمة محددة بفواصل من عناوين IP
									 <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> ؛ ولن يستخدم سوى العنوان الأخير (الأيسر منها).',
	'ReverseProxyAddresses'		=> 'verse_proxy يقبل مجموعة من عناوين IP:',
	'ReverseProxyAddressesInfo'	=> 'كل عنصر من هذه الصفيفة هو عنوان IP لأي من عناوينك العكسية
									 <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> proxes. إذا استخدمت هذه المصفوفة، WackoWiki سيثق في المعلومات المخزنة
									 <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> في X-Forwarded-for heads، فقط إذا كان عنوان IP البعيد هو واحد من
									 <unk> <unk> <unk> <unk> <unk> <unk> هذه، هذا يعني أن الطلب يصل إلى خادم الويب من أحد الوكلاء
									 <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> العكس. وبخلاف ذلك، يمكن للعميل الاتصال مباشرة بـ
									 <unk> <unk> <unk> <unk> <unk> <unk> <unk> خادم الويب الخاص بك عن طريق تفريغ رؤوس X-Forwarded-.',

	'SessionSection'				=> 'معالجة الجلسة',
	'SessionStorage'				=> 'تخزين الجلسة:',
	'SessionStorageInfo'			=> 'يحدد هذا الخيار المكان الذي يتم فيه تخزين بيانات الجلسة. بشكل افتراضي، يتم تحديد إما تخزين الملف أو قاعدة البيانات.',
	'SessionModes'	=> [
		'1'		=> 'ملف',
		'2'		=> 'قاعدة البيانات',
	],
	'SessionNotice'					=> 'إشعار إنهاء الدورة:',
	'SessionNoticeInfo'				=> 'يشير إلى سبب انتهاء الدورة.',
	'LoginNotice'					=> 'إشعار تسجيل الدخول:',
	'LoginNoticeInfo'				=> 'يعرض إشعار تسجيل الدخول.',

	'RewriteMode'					=> 'استخدم <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'إذا كان خادم الويب الخاص بك يدعم هذه الميزة، قم بتفعيل عناوين URL للصفحة.<br>
										<unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk>										<span class="cite">قد يتم الكتابة فوق القيمة بواسطة فئة الإعدادات في وقت التشغيل، بغض النظر عما إذا كان قد تم إيقاف تشغيله، إذا كان HTTP_MOD_REWRITE قيد التشغيل.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'المعلمات المسؤولة عن التحكم في الوصول والأذونات.',
	'PermissionsSettingsUpdated'	=> 'إعدادات الأذونات المحدثة',

	'PermissionsSection'		=> 'الحقوق والامتيازات',
	'ReadRights'				=> 'حقوق القراءة بشكل افتراضي:',
	'ReadRightsInfo'			=> 'تم التعيين الافتراضي لصفحات الجذور التي تم إنشاؤها، فضلا عن الصفحات التي لا يمكن تعريف ACLs الأصل لها.',
	'WriteRights'				=> 'كتابة الحقوق بشكل افتراضي:',
	'WriteRightsInfo'			=> 'تم التعيين الافتراضي لصفحات الجذور التي تم إنشاؤها، فضلا عن الصفحات التي لا يمكن تعريف ACLs الأصل لها.',
	'CommentRights'				=> 'حقوق التعليق بشكل افتراضي:',
	'CommentRightsInfo'			=> 'تم التعيين الافتراضي لصفحات الجذور التي تم إنشاؤها، فضلا عن الصفحات التي لا يمكن تعريف ACLs الأصل لها.',
	'CreateRights'				=> 'إنشاء حقوق لصفحة فرعية بشكل افتراضي:',
	'CreateRightsInfo'			=> 'تم التعيين الافتراضي للصفحات الفرعية التي تم إنشاؤها.',
	'UploadRights'				=> 'تحميل الحقوق بشكل افتراضي:',
	'UploadRightsInfo'			=> 'حقوق الرفع الافتراضية.',
	'RenameRights'				=> 'إعادة التسمية العامة:',
	'RenameRightsInfo'			=> 'قائمة الأذونات لإعادة تسمية الصفحات (نقلها) بحرية.',

	'LockAcl'					=> 'قفل جميع ACLs للقراءة فقط:',
	'LockAclInfo'				=> '<span class="cite">Overwrites the ACL settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period of time for security reasons, or as a emergency response to an exploit or vulnerability.',
	'HideLocked'				=> 'إخفاء الصفحات التي يتعذر الوصول إليها:',
	'HideLockedInfo'			=> 'إذا لم يكن لدى المستخدم الصلاحية لقراءة الصفحة، إخفاء ذلك في قوائم صفحات مختلفة (ولكن الرابط الموجود في النص سيظل مرئيًا).',
	'RemoveOnlyAdmins'			=> 'يمكن للمسؤولين فقط حذف الصفحات:',
	'RemoveOnlyAdminsInfo'		=> 'رفض الجميع، باستثناء المسؤولين، القدرة على حذف الصفحات. الحد الأول ينطبق على أصحاب الصفحات العادية.',
	'OwnersRemoveComments'		=> 'يمكن لأصحاب الصفحات حذف التعليقات:',
	'OwnersRemoveCommentsInfo'	=> 'السماح لمالكي الصفحات بضبط التعليقات على صفحاتهم.',
	'OwnersEditCategories'		=> 'يمكن للمالكين تعديل فئات الصفحات:',
	'OwnersEditCategoriesInfo'	=> 'السماح للمالكين بتعديل قائمة فئات الصفحات في موقعك (إضافة كلمات، حذف الكلمات)، يتم تعيينه إلى صفحة.',
	'TermHumanModeration'		=> 'انتهاء صلاحية الاعتدال البشري:',
	'TermHumanModerationInfo'	=> 'لا يمكن للمشرفين تعديل التعليقات إلا إذا تم إنشاؤها أكثر من هذا العدد من الأيام (هذا الحد لا ينطبق على التعليق الأخير في الموضوع).',

	'UserCanDeleteAccount'		=> 'السماح للمستخدمين بحذف حساباتهم',

	// Security settings
	'SecuritySettingsInfo'		=> '3 - البارامترات المسؤولة عن سلامة المنصة عموما، والقيود المفروضة على السلامة، والنظم الفرعية الأمنية الإضافية.',
	'SecuritySettingsUpdated'	=> 'تحديث إعدادات الأمان',

	'AllowRegistration'			=> 'التسجيل على الإنترنت:',
	'AllowRegistrationInfo'		=> 'فتح تسجيل المستخدم. تعطيل هذا الخيار سيمنع التسجيل المجاني، ولكن مدير الموقع سيظل قادرا على تسجيل المستخدمين.',
	'ApproveNewUser'			=> 'الموافقة على المستخدمين الجدد:',
	'ApproveNewUserInfo'		=> 'يسمح للمسؤولين بالموافقة على المستخدمين بمجرد تسجيلهم. سيتم السماح للمستخدمين المعتمدين فقط بتسجيل الدخول إلى الموقع.',
	'PersistentCookies'			=> 'ملفات تعريف الارتباط الثابتة:',
	'PersistentCookiesInfo'		=> 'السماح بالكعكات المستمرة.',
	'DisableWikiName'			=> 'تعطيل الويكيما:',
	'DisableWikiNameInfo'		=> 'تعطيل الاستخدام الإلزامي للويكياسم للمستخدمين. التصاريح لتسجيل المستخدم مع الأسماء المستعارة التقليدية بدلا من الأسماء المجبرة تنسيق CamelCase-(أي اسم الأسرة).',
	'UsernameLength'			=> 'طول اسم المستخدم:',
	'UsernameLengthInfo'		=> 'الحد الأدنى والحد الأقصى لعدد الأحرف في أسماء المستخدم.',

	'EmailSection'				=> 'البريد الإلكتروني',
	'AllowEmailReuse'			=> 'السماح بإعادة استخدام عنوان البريد الإلكتروني:',
	'AllowEmailReuseInfo'		=> 'يمكن للمستخدمين المختلفين التسجيل بنفس عنوان البريد الإلكتروني.',
	'EmailConfirmation'			=> 'تفعيل تأكيد البريد الإلكتروني:',
	'EmailConfirmationInfo'		=> 'يتطلب المستخدم التحقق من عنوان البريد الإلكتروني الخاص به قبل أن يتمكن من تسجيل الدخول.',
	'AllowedEmailDomains'		=> 'نطاقات البريد الإلكتروني المسموح بها:',
	'AllowedEmailDomainsInfo'	=> 'نطاقات البريد الإلكتروني مفصولة بفاصلة، مثل <code>example.com, local.lan</code> إلخ. إذا لم يتم تحديدها، فإن جميع نطاقات البريد الإلكتروني مسموح بها.',
	'ForbiddenEmailDomains'		=> 'نطاق البريد الإلكتروني المحظور:',
	'ForbiddenEmailDomainsInfo'	=> 'نطاقات البريد الإلكتروني المحظورة مفصولة بفاصلة، مثل <code>example.com, local.lan</code> إلخ. فقط تكون فعالة إذا كانت قائمة نطاقات البريد الإلكتروني المسموح بها فارغة.',

	'CaptchaSection'			=> 'الكابتشا',
	'EnableCaptcha'				=> 'تمكين كلمة التحقق:',
	'EnableCaptchaInfo'			=> 'إذا تم تفعيله، سيتم عرض كلمة التحقق في الحالات التالية، أو إذا تم الوصول إلى عتبة الأمان.',
	'CaptchaComment'			=> 'تعليق جديد:',
	'CaptchaCommentInfo'		=> 'كحماية من الرسائل غير المرغوب فيها، يجب على المستخدمين غير المسجلين إكمال كلمة التحقق قبل نشر التعليق.',
	'CaptchaPage'				=> 'صفحة جديدة:',
	'CaptchaPageInfo'			=> 'كحماية من الرسائل غير المرغوب فيها، يجب على المستخدمين غير المسجلين إكمال كلمة التحقق قبل إنشاء صفحة جديدة.',
	'CaptchaEdit'				=> 'تحرير الصفحة:',
	'CaptchaEditInfo'			=> 'كحماية من الرسائل غير المرغوب فيها، يجب على المستخدمين غير المسجلين إكمال كلمة التحقق قبل تحرير الصفحات.',
	'CaptchaRegistration'		=> 'التسجيل:',
	'CaptchaRegistrationInfo'	=> 'كحماية من الرسائل غير المرغوب فيها، يجب على المستخدمين غير المسجلين إكمال كلمة التحقق قبل التسجيل.',

	'TlsSection'				=> 'إعدادات TLS',
	'TlsConnection'				=> 'اتصال TLS:',
	'TlsConnectionInfo'			=> 'استخدام اتصال TLS-آمن. <span class="cite">قم بتفعيل شهادة TLS المثبتة مسبقاً على الخادم، وإلا ستفقد الوصول إلى لوحة المدير!</span><br>يحدد أيضا ما إذا كان قد تم تعيين العلم الآمن لكوكوي: العلم <code>الآمن</code> يحدد ما إذا كان يجب إرسال ملفات تعريف الارتباط فقط عبر اتصالات آمنة.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'إعادة توصيل العميل عنوة من HTTP إلى HTTPS. مع تعطيل الخيار، يمكن للعميل تصفح الموقع من خلال قناة HTTP مفتوحة.',

	'HttpSecurityHeaders'		=> 'ترويسات أمان HTTP',
	'EnableSecurityHeaders'		=> 'تمكين رؤوس الأمن:',
	'EnableSecurityHeadersinfo'	=> 'تعيين رؤوس الأمان (تثبيت الإطار، النقر على القرصنة/XSS/CSRF). يمكن أن يسبب <br>CSP مشاكل في بعض الحالات (على سبيل المثال. أثناء التطوير)، أو عند استخدام الإضافات المعتمدة على موارد مستضافة خارجيا مثل الصور أو البرامج النصية. <br>تعطيل سياسة أمن المحتوى هو خطر أمني!',
	'Csp'						=> 'سياسة أمن المحتوى:',
	'CspInfo'					=> 'تكوين CSP يتضمن تحديد السياسات التي تريد إنفاذها، ثم تكوينها واستخدام سياسة المحتوى - الأمن لإنشاء سياستك.',
	'PolicyModes'	=> [
		'0'		=> 'معطل',
		'1'		=> 'صارم',
		'2'		=> 'مخصص',
	],
	'PermissionsPolicy'			=> 'سياسة الأذونات:',
	'PermissionsPolicyInfo'		=> 'يوفر رأس سياسة أذونات HTTP آلية لتمكين أو تعطيل مختلف ميزات المتصفح القوية.',
	'ReferrerPolicy'			=> 'سياسة الإحالة:',
	'ReferrerPolicyInfo'		=> 'وينظم رأس الإحالة - السياسة HTTP الذي يحيل المعلومات المرسلة في عنوان الحكم، وينبغي أن يدرج في الردود.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'عدم الإحالة',
		'2'		=> 'عدم الإحالة متى',
		'3'		=> 'نفس الأصل',
		'4'		=> 'الأصل',
		'5'		=> 'الأصل الدقيق',
		'6'		=> 'الأصل - متى',
		'7'		=> 'الأصل المطلق متي الأصل',
		'8'		=> 'رابط غير آمن'
	],

	'UserPasswordSection'		=> 'استمرار كلمات مرور المستخدم',
	'PwdMinChars'				=> 'الحد الأدنى لطول كلمة المرور:',
	'PwdMinCharsInfo'			=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 12 to 16 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'AdminPwdMinChars'			=> 'الحد الأدنى لطول كلمة مرور المشرف:',
	'AdminPwdMinCharsInfo'		=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 15 to 20 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'PwdCharComplexity'			=> 'تعقيدات كلمة المرور المطلوبة:',
	'PwdCharClasses'	=> [
		'0'		=> 'لم يتم اختباره',
		'1'		=> 'أي أحرف + أرقام',
		'2'		=> 'أحرف كبيرة و أحرف صغيرة + أرقام',
		'3'		=> 'الحروف الكبيرة والحروف الصغيرة + الأرقام + الأحرف',
	],
	'PwdUnlikeLogin'			=> 'تعقيدات إضافية:',
	'PwdUnlikes'	=> [
		'0'		=> 'لم يتم اختباره',
		'1'		=> 'كلمة المرور غير متطابقة مع تسجيل الدخول',
		'2'		=> 'كلمة المرور لا تحتوي على اسم المستخدم',
	],

	'LoginSection'				=> 'ولوج',
	'MaxLoginAttempts'			=> 'الحد الأقصى لعدد محاولات تسجيل الدخول لكل اسم مستخدم:',
	'MaxLoginAttemptsInfo'		=> 'عدد محاولات تسجيل الدخول المسموح بها لحساب واحد قبل تشغيل مهمة مكافحة البريد المزعج. أدخل 0 لمنع تشغيل مهمة مكافحة الرسائل غير المرغوب فيها لحسابات المستخدم المميزة.',
	'IpLoginLimitMax'			=> 'الحد الأقصى لعدد محاولات تسجيل الدخول لكل عنوان IP:',
	'IpLoginLimitMaxInfo'		=> 'عتبة محاولات تسجيل الدخول المسموح بها من عنوان IP واحد قبل تشغيل مهمة مكافحة الرسائل غير المرغوب فيها. أدخل 0 لمنع تشغيل مهمة مكافحة سبامبوت بواسطة عناوين IP',

	'FormsSection'				=> 'استمارات',
	'FormTokenTime'				=> 'أقصى وقت لتقديم الاستمارات:',
	'FormTokenTimeInfo'			=> 'الوقت الذي يتوجب فيه على المستخدم تقديم استمارة (بالثواني).<br> لاحظ أن النموذج قد يصبح غير صالح إذا انتهت صلاحية الجلسة، بغض النظر عن هذا الإعداد.',

	'SessionLength'				=> 'انتهاء صلاحية ملف تعريف الارتباط:',
	'SessionLengthInfo'			=> 'عمر ملف تعريف الارتباط الخاص بجلسة المستخدم بشكل افتراضي (بالأيام).',
	'CommentDelay'				=> 'مكافحة الفيضانات للتعليق عليها:',
	'CommentDelayInfo'			=> 'الحد الأدنى من التأخير بين نشر التعليقات الجديدة للمستعمل (بالثواني).',
	'IntercomDelay'				=> 'مكافحة الفيضان لأغراض الاتصالات الشخصية:',
	'IntercomDelayInfo'			=> 'الحد الأدنى للتأخير بين إرسال الرسائل الخاصة (بالثواني).',
	'RegistrationDelay'			=> 'الحد الزمني للتسجيل:',
	'RegistrationDelayInfo'		=> 'الحد الأدنى للوقت الفاصل بين تقديم استمارة التسجيل لثني بوتات التسجيل (بالثواني).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'مجموعة من المعلمات المسؤولة عن ضبط الموقع. لا تقم بتغييرها إلا إذا كنت واثقا من أعمالها.',
	'FormatterSettingsUpdated'	=> 'تحديث إعدادات التنسيق',

	'TextHandlerSection'		=> 'معالج النص:',
	'Typografica'				=> 'مصحح طباعي مطبع:',
	'TypograficaInfo'			=> 'سيؤدي تعطيل هذا الخيار إلى تسريع عمليات إضافة التعليقات وحفظ الصفحات.',
	'Paragrafica'				=> 'علامات المظلة:',
	'ParagraficaInfo'			=> 'شبيهة بالخيار السابق، ولكن سيؤدي إلى قطع توصيل جدول المحتويات التلقائي غير القابل للتشغيل (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'دعم HTML العالمي:',
	'AllowRawhtmlInfo'			=> 'وقد يكون هذا الخيار غير آمن بالنسبة لموقع مفتوح.',
	'SafeHtml'					=> 'تصفية HTML:',
	'SafeHtmlInfo'				=> 'Prevents saving of dangerous HTML objects. Turning off the filter on an open site with HTML support is <span class="underline">extremely</span> undesirable!',

	'WackoFormatterSection'		=> 'صيغة نص ويكي (منتدى واكو)',
	'X11colors'					=> 'استخدام الألوان X11:',
	'X11colorsInfo'				=> 'يوسع الألوان المتاحة ل <code>??(اللون) الخلفية؟?</code> و <code>!! نص اللون!!</code>تعطيل هذا الخيار يؤدي إلى تسريع عمليات إضافة التعليقات وحفظ الصفحات.',
	'WikiLinks'					=> 'تعطيل روابط ويكي:',
	'WikiLinksInfo'				=> 'تعطيل الربط ل <code>CamelCaseWords</code>: كلمات CamelCase الخاصة بك لن يتم ربطها مباشرة بصفحة جديدة. هذا مفيد عندما تعمل عبر الفضاءات الاسم/التكتلات المختلفة. بشكل افتراضي هو غير مفعل.',
	'BracketsLinks'				=> 'تعطيل الروابط بين قوسين:',
	'BracketsLinksInfo'			=> 'يعطل بناء الجملة <code>[[link]و</code> و <code>(الرابط)</code>',
	'Formatters'				=> 'تعطيل التنسيقات:',
	'FormattersInfo'			=> 'تعطيل بناء الجملة <code>%%code%%</code> المستخدمة للمبرزين.',

	'DateFormatsSection'		=> 'تنسيقات التاريخ',
	'DateFormat'				=> '3 - شكل التاريخ:',
	'DateFormatInfo'			=> '(اليوم، الشهر، السنة)',
	'TimeFormat'				=> 'ألف - شكل الوقت:',
	'TimeFormatInfo'			=> '(ساعة، دقيقة)',
	'TimeFormatSeconds'			=> '3 - شكل الوقت بالضبط:',
	'TimeFormatSecondsInfo'		=> '(ساعات، دقائق، ثواني)',
	'NameDateMacro'				=> 'تنسيق <code>:@::</code> مايكل:',
	'NameDateMacroInfo'			=> '(الاسم، الوقت)، مثل <code>اسم المستخدم (17.11.2016 16:48)</code>',
	'Timezone'					=> 'المنطقة الزمنية:',
	'TimezoneInfo'				=> 'المنطقة الزمنية للاستخدام لعرض الأوقات للمستخدمين الذين لم يتم تسجيل الدخول (الضيف). يمكن للمستخدمين تسجيل الدخول تغيير المنطقة الزمنية الخاصة بهم في إعدادات المستخدم الخاصة بهم.',

	'Canonical'					=> 'استخدام عناوين URL الكاملة:',
	'CanonicalInfo'				=> 'يتم إنشاء جميع الروابط كعناوين URL مطلقة في النموذج %1. يجب تفضيل عناوين URL المتعلقة بجذر الخادم في النموذج %2.',
	'LinkTarget'				=> 'حيثما تفتح الروابط الخارجية:',
	'LinkTargetInfo'			=> 'يفتح كل رابط خارجي في نافذة متصفح جديدة. يضيف <code>target="_blank"</code> إلى بناء الربط.',
	'Noreferrer'				=> 'المحال:',
	'NoreferrerInfo'			=> 'يتطلب أن لا يرسل المتصفح ترويسة حكما HTTP إذا كان المستخدم يتبع الرابط التشعبي. يضيف <code>rel="norerer"</code> إلى بناء الرابط.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'يخبر محركات البحث أن الروابط التشعبية لا ينبغي أن تؤثر على ترتيب صفحات الصفحة المستهدفة في فهرس محرك البحث. يضيف <code>rel="nofollow"</code> إلى بناء الرابط.',
	'UrlsUnderscores'			=> 'عناوين النموذج (URLs) مع الشرط:',
	'UrlsUnderscoresInfo'		=> 'على سبيل المثال، %1 أصبح %2 مع هذا الخيار.',
	'ShowSpaces'				=> 'إظهار المسافات في الويكيمات:',
	'ShowSpacesInfo'			=> 'إظهار المسافات في ويكيماس، على سبيل المثال <code>MyName</code> التي يتم عرضها ك <code>اسمي</code> مع هذا الخيار.',
	'NumerateLinks'				=> 'عدد الروابط في عرض الطباعة:',
	'NumerateLinksInfo'			=> 'تعداد وتسرد جميع الروابط في أسفل طريقة عرض الطباعة مع هذا الخيار.',
	'YouareHereText'			=> 'تعطيل وتصوير روابط المراجع الذاتية:',
	'YouareHereTextInfo'		=> 'تصور الروابط إلى نفس الصفحة، باستخدام <code>&lt;b&gt;####&lt;/b&gt;</code>. جميع الروابط إلى الذات تفقد تنسيق الرابط، ولكن يتم عرضها كنص جريء.',

	// Pages settings
	'PagesSettingsInfo'			=> 'هنا يمكنك تعيين أو تغيير صفحات النظام الأساسية المستخدمة داخل ويكي. الرجاء التأكد من أنك لا تنسى إنشاء أو تغيير الصفحات المقابلة في ويكي وفقا للإعدادات الخاصة بك هنا.',
	'PagesSettingsUpdated'		=> 'تحديث الإعدادات الصفحات الأساسية',

	'ListCount'					=> 'عدد العناصر لكل قائمة:',
	'ListCountInfo'				=> 'عدد العناصر المعروضة على كل قائمة للزوار أو كقيمة افتراضية للمستخدمين الجدد.',

	'ForumSection'				=> 'منتدى الخيارات',
	'ForumCluster'				=> 'منتدى المجموعات:',
	'ForumClusterInfo'			=> 'مجموعة جذر لقسم المنتدى (الإجراء %1).',
	'ForumTopics'				=> 'عدد المواضيع في الصفحة:',
	'ForumTopicsInfo'			=> 'عدد المواضيع المعروضة في كل صفحة من القائمة في أقسام المنتدى (الإجراء %1).',
	'CommentsCount'				=> 'عدد التعليقات لكل صفحة:',
	'CommentsCountInfo'			=> 'عدد التعليقات المعروضة على قائمة التعليقات في كل صفحة. وينطبق هذا على جميع التعليقات على الموقع، وليس فقط تلك التي تنشر في المنتدى.',

	'NewsSection'				=> 'أخبار القسم',
	'NewsCluster'				=> 'مجموعة الأخبار:',
	'NewsClusterInfo'			=> 'مجموعة جذر لقسم الأخبار (الإجراء %1).',
	'NewsStructure'				=> 'هيكل مجموعات الأخبار:',
	'NewsStructureInfo'			=> 'يخزن المقالات اختيارياً في المجموعات الفرعية بالسنة/الشهر أو الأسبوع (على سبيل المثال <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'الترخيص',
	'DefaultLicense'			=> 'الترخيص الافتراضي:',
	'DefaultLicenseInfo'		=> 'يمكن تحرير المحتوى الخاص بك بموجب الترخيص.',
	'EnableLicense'				=> 'تمكين الرخصة:',
	'EnableLicenseInfo'			=> 'تمكين إظهار معلومات الترخيص.',
	'LicensePerPage'			=> 'الترخيص لكل صفحة:',
	'LicensePerPageInfo'		=> 'السماح بالترخيص لكل صفحة، التي يمكن لمالك الصفحة أن يختارها عبر خصائص الصفحة.',

	'ServicePagesSection'		=> 'صفحات الخدمة',
	'RootPage'					=> 'الصفحة الرئيسية:',
	'RootPageInfo'				=> 'علامة الصفحة الرئيسية الخاصة بك، تفتح تلقائياً عندما يزور المستخدم موقعك.',

	'PrivacyPage'				=> 'سياسة الخصوصية:',
	'PrivacyPageInfo'			=> 'الصفحة مع سياسة الخصوصية للموقع.',

	'TermsPage'					=> 'السياسات واللوائح:',
	'TermsPageInfo'				=> '2 - الصفحة التي تتضمن قواعد الموقع.',

	'SearchPage'				=> 'البحث:',
	'SearchPageInfo'			=> 'صفحة مع نموذج البحث (الإجراء %1).',
	'RegistrationPage'			=> 'التسجيل:',
	'RegistrationPageInfo'		=> 'صفحة تسجيل المستخدم الجديد (الإجراء %1).',
	'LoginPage'					=> 'تسجيل دخول المستخدم:',
	'LoginPageInfo'				=> 'صفحة تسجيل الدخول على الموقع (الإجراء %1).',
	'SettingsPage'				=> 'إعدادات المستخدم:',
	'SettingsPageInfo'			=> 'صفحة لتخصيص الملف الشخصي للمستخدم (الإجراء %1).',
	'PasswordPage'				=> 'تغيير كلمة المرور:',
	'PasswordPageInfo'			=> 'صفحة مع نموذج لتغيير / استعلام كلمة مرور المستخدم (الإجراء %1).',
	'UsersPage'					=> 'قائمة المستخدمين:',
	'UsersPageInfo'				=> 'صفحة مع قائمة المستخدمين المسجلين (الإجراء %1).',
	'CategoryPage'				=> 'الفئة:',
	'CategoryPageInfo'			=> 'صفحة تحتوي على قائمة الصفحات المصنفة (الإجراء %1).',
	'GroupsPage'				=> 'المجموعات:',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action %1).',
	'ChangesPage'				=> 'أحدث التغييرات:',
	'ChangesPageInfo'			=> 'صفحة تحتوي على قائمة بآخر صفحات معدلة (الإجراء %1).',
	'CommentsPage'				=> 'التعليقات الأخيرة:',
	'CommentsPageInfo'			=> 'صفحة تحتوي على قائمة بالتعليقات الأخيرة على الصفحة (الإجراء %1).',
	'RemovalsPage'				=> 'الصفحات المحذوفة:',
	'RemovalsPageInfo'			=> 'صفحة تحتوي على قائمة من الصفحات المحذوفة مؤخرا (الإجراء %1).',
	'WantedPage'				=> 'الصفحات المطلوبة:',
	'WantedPageInfo'			=> 'صفحة مع قائمة الصفحات المفقودة التي تم الرجوع إليها (الإجراء %1).',
	'OrphanedPage'				=> 'الصفحات اليتيمة:',
	'OrphanedPageInfo'			=> 'الصفحة التي تحتوي على قائمة الصفحات الموجودة ليست مرتبطة عبر روابط لأي صفحة أخرى (الإجراء %1).',
	'SandboxPage'				=> 'صندوق الرمل:',
	'SandboxPageInfo'			=> 'صفحة حيث يمكن للمستخدمين ممارسة مهاراتهم في ترقية الويكي.',
	'HelpPage'					=> 'مساعدة:',
	'HelpPageInfo'				=> 'قسم الوثائق للعمل مع أدوات الموقع.',
	'IndexPage'					=> 'الفهرس:',
	'IndexPageInfo'				=> 'صفحة تحتوي على قائمة بجميع الصفحات (الإجراء %1).',
	'RandomPage'				=> 'عشوائية:',
	'RandomPageInfo'			=> 'تحميل صفحة عشوائية (الإجراء %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'معلمات لإشعارات المنصة.',
	'NotificationSettingsUpdated'	=> 'تحديث إعدادات الإشعارات',

	'EmailNotification'			=> 'إشعار البريد الإلكتروني:',
	'EmailNotificationInfo'		=> 'السماح بإشعار البريد الإلكتروني. تعيين لتمكين إشعارات البريد الإلكتروني، معطل لتعطيلها. لاحظ أن تعطيل إشعارات البريد الإلكتروني ليس له تأثير على رسائل البريد الإلكتروني التي تم إنشاؤها كجزء من عملية تسجيل المستخدم.',
	'Autosubscribe'				=> 'الاشتراك التلقائي:',
	'AutosubscribeInfo'			=> 'إشعار المالك تلقائياً بتغيير الصفحة.',

	'NotificationSection'		=> 'إعدادات إشعارات المستخدم الافتراضية',
	'NotifyPageEdit'			=> 'إشعار تحرير الصفحة:',
	'NotifyPageEditInfo'		=> 'في انتظار - إرسال إشعار بريد إلكتروني فقط للتغيير الأول حتى يزور المستخدم الصفحة مرة أخرى.',
	'NotifyMinorEdit'			=> 'إشعار تحرير بسيط:',
	'NotifyMinorEditInfo'		=> 'إرسال إشعارات أيضا لتعديلات طفيفة.',
	'NotifyNewComment'			=> 'إشعار تعليق جديد:',
	'NotifyNewCommentInfo'		=> 'في انتظار - إرسال إشعار بريد إلكتروني فقط للتعليق الأول حتى يزور المستخدم الصفحة مرة أخرى.',

	'NotifyUserAccount'			=> 'إشعار حساب المستخدم الجديد:',
	'NotifyUserAccountInfo'		=> 'سيتم إعلام المشرف عند إنشاء مستخدم جديد باستخدام نموذج التسجيل.',
	'NotifyUpload'				=> 'اشعار برفع الملف:',
	'NotifyUploadInfo'			=> 'سيتم إعلام المشرفين عندما يتم تحميل ملف.',

	'PersonalMessagesSection'	=> 'الرسائل الشخصية',
	'AllowIntercomDefault'		=> 'السماح بالترابط:',
	'AllowIntercomDefaultInfo'	=> 'تمكين هذا الخيار يسمح للمستخدمين الآخرين بإرسال رسائل شخصية إلى عنوان البريد الإلكتروني للمستلم دون الكشف عن العنوان.',
	'AllowMassemailDefault'		=> 'السماح بالبريد الإلكتروني الكلي:',
	'AllowMassemailDefaultInfo'	=> 'إرسال رسائل فقط إلى المستخدمين الذين سمحوا للمشرفين بإرسال معلومات إليهم.',

	// Resync settings
	'Synchronize'				=> 'Synchronize',
	'UserStatsSynched'			=> 'تم مزامنة إحصائيات المستخدم.',
	'PageStatsSynched'			=> 'تم مزامنة إحصائيات الصفحة.',
	'FeedsUpdated'				=> 'تم تحديث التغذية RSS.',
	'SiteMapCreated'			=> 'تم إنشاء النسخة الجديدة من خريطة الموقع بنجاح.',
	'ParseNextBatch'			=> 'تحليل المجموعة التالية من الصفحات:',
	'WikiLinksRestored'			=> 'استعادة روابط الويكي.',

	'LogUserStatsSynched'		=> 'مزامنة إحصائيات المستخدم',
	'LogPageStatsSynched'		=> 'إحصائيات الصفحات المتزامنة',
	'LogFeedsUpdated'			=> 'تغذية RSS المتزامنة',
	'LogPageBodySynched'		=> 'نص الصفحة ووصلات التعويض',

	'UserStats'					=> 'إحصائيات المستخدم',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to match actual data contained in the database.',
	'PageStats'					=> 'إحصائيات الصفحة',
	'PageStatsInfo'				=> 'وقد تختلف إحصاءات الصفحات (عدد التعليقات والملفات والتنقيحات) في بعض الحالات عن البيانات الفعلية. <br>هذه العملية تسمح بتحديث الإحصاءات لتطابق البيانات الفعلية الموجودة في قاعدة البيانات.',

	'AttachmentsInfo'			=> 'قم بتحديث تجزئة الملف لجميع المرفقات في قاعدة البيانات.',
	'AttachmentsSynched'		=> 'إعادة تجزئة جميع مرفقات الملفات',
	'LogAttachmentsSynched'		=> 'إعادة تجزئة جميع مرفقات الملفات',

	'Feeds'						=> 'التحديثات',
	'FeedsInfo'					=> 'وفي حالة التحرير المباشر للصفحات في قاعدة البيانات، قد لا يعكس محتوى التغذية الخاصة بقاعدة البيانات هذه التغييرات التي تم إجراؤها. <br>هذه الوظيفة تزامن قنوات RSS مع الحالة الراهنة لقاعدة البيانات.',
	'XmlSiteMap'				=> 'XML Sitemap',
	'XmlSiteMapInfo'			=> 'هذه الوظيفة تتزامن مع خريطة موقع XML-Sitemap مع الحالة الحالية لقاعدة البيانات.',
	'XmlSiteMapPeriod'			=> 'الفترة %1 أيام. آخر كتبت %2.',
	'XmlSiteMapView'			=> 'إظهار خريطة الموقع في نافذة جديدة.',

	'ReparseBody'				=> 'تعويض كل الصفحات',
	'ReparseBodyInfo'			=> 'إفراغ <code>body_r</code> في جدول الصفحات، بحيث يتم تقديم كل صفحة مرة أخرى في عرض الصفحة التالية. قد يكون هذا مفيداً إذا قمت بتعديل تنسيق أو تغيير نطاق ويكي الخاص بك.',
	'PreparsedBodyPurged'		=> 'حقل إفراغي <code>body_r</code> في جدول الصفحات.',

	'WikiLinksResync'			=> 'روابط ويكي',
	'WikiLinksResyncInfo'		=> 'إجراء إعادة تقديم لجميع الروابط داخل الفضاء واستعادة محتويات الجداول <code>page_link</code> و <code>file_link</code> في حالة التلف أو النقل (وهذا قد يستغرق وقتاً طويلاً).',
	'RecompilePage'				=> 'إعادة تجميع جميع الصفحات (باهظ التكلفة)',
	'ResyncOptions'				=> 'خيارات إضافية',
	'RecompilePageLimit'		=> 'عدد الصفحات المراد تحليلها في وقت واحد.',

	// Email settings
	'EmaiSettingsInfo'			=> 'يتم استخدام هذه المعلومات عندما يرسل المحرك رسائل البريد الإلكتروني إلى المستخدمين الخاصين. الرجاء التأكد من أن عنوان البريد الإلكتروني الذي تحدده صحيح، حيث أنه من المرجح أن يتم إرسال أي رسائل مرتدة أو غير قابلة للتسليم إلى ذلك العنوان. إذا كان مزود خدمة الاستضافة الخاص بك لا يوفر خدمة بريد إلكتروني أصلية (PHP)، يمكنك بدلاً من ذلك إرسال الرسائل مباشرة باستخدام SMTP. هذا يتطلب عنوان خادم مناسب (اسأل مقدم خدمة الاستضافة إذا لزم الأمر). إذا كان الخادم يحتاج إلى المصادقة (وفقط إذا كان يفعل)، أدخل اسم المستخدم وكلمة المرور وطريقة المصادقة اللازمة.',

	'EmailSettingsUpdated'		=> 'تحديث إعدادات البريد الإلكتروني',

	'EmailFunctionName'			=> 'اسم وظيفة البريد الإلكتروني:',
	'EmailFunctionNameInfo'		=> 'وظيفة البريد الإلكتروني المستخدمة لإرسال رسائل عبر PHP.',
	'UseSmtpInfo'				=> 'حدد <code>SMTP</code> إذا كنت ترغب في إرسال بريد إلكتروني عبر خادم مسمى بدلاً من وظيفة البريد المحلي.',

	'EnableEmail'				=> 'تمكين رسائل البريد الإلكتروني:',
	'EnableEmailInfo'			=> 'تمكين إرسال رسائل البريد الإلكتروني.',

	'EmailIdentitySettings'		=> 'هويات البريد الإلكتروني للموقع',
	'FromEmailName'				=> 'من الاسم:',
	'FromEmailNameInfo'			=> 'اسم المرسل الذي يستخدم ل <code>من:</code> رأس لجميع إشعارات البريد الإلكتروني المرسلة من الموقع.',
	'EmailSubjectPrefix'		=> 'بادئة الموضوع:',
	'EmailSubjectPrefixInfo'	=> 'بادئة موضوع بريد إلكتروني بديل، مثل <code>[Prefix] A الموضوع</code>. إذا لم يتم تعريفه، البادئة الافتراضية هي اسم الموقع: %1.',

	'NoReplyEmail'				=> 'عنوان رقم الرد:',
	'NoReplyEmailInfo'			=> 'هذا العنوان، مثل <code>noreply@example.com</code>، سيظهر في <code>From:</code> حقل عنوان البريد الإلكتروني لجميع إشعارات البريد الإلكتروني المرسلة من الموقع.',
	'AdminEmail'				=> 'البريد الإلكتروني لمالك الموقع:',
	'AdminEmailInfo'			=> 'يتم استخدام هذا العنوان لأغراض المشرف ، مثل إشعار المستخدم الجديد.',
	'AbuseEmail'				=> 'خدمة إساءة استعمال البريد الإلكتروني:',
	'AbuseEmailInfo'			=> 'معالجة طلبات المسائل المستعجلة: تسجيل البريد الإلكتروني الأجنبي، إلخ. قد يكون نفس البريد الإلكتروني لمالك الموقع.',

	'SendTestEmail'				=> 'إرسال بريد إلكتروني تجريبي',
	'SendTestEmailInfo'			=> 'سيؤدي هذا إلى إرسال بريد إلكتروني تجريبي إلى العنوان المحدد في حسابك.',
	'TestEmailSubject'			=> 'تم تكوين ويكي بشكل صحيح لإرسال رسائل البريد الإلكتروني',
	'TestEmailBody'				=> 'إذا تلقيت هذا البريد الإلكتروني، يتم تكوين ويكي بشكل صحيح لإرسال رسائل البريد الإلكتروني.',
	'TestEmailMessage'			=> 'The test email has been sent.<br>If you don\'t receive it, please check your email configuration settings.',

	'SmtpSettings'				=> 'إعدادات SMTP',
	'SmtpAutoTls'				=> 'TLS الانتهازية:',
	'SmtpAutoTlsInfo'			=> 'تمكين التشفير تلقائياً، إذا رأى أن الخادم هو الإعلان عن تشفير TLS (بعد أن تكون قد اتصلت بالخادم)، حتى إذا لم تقم بتعيين وضع الاتصال ل <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'وضع الاتصال لـ SMTP:',
	'SmtpConnectionModeInfo'	=> 'يستخدم فقط إذا كان اسم المستخدم/كلمة المرور مطلوبًا. اسأل المزود الخاص بك إذا كنت غير متأكد من أي طريقة لاستخدامها',
	'SmtpPassword'				=> 'كلمة مرور SMTP:',
	'SmtpPasswordInfo'			=> 'Only enter a password if your SMTP server requires it.<br><em><strong>Warning:</strong> This password will be stored as plaintext in the database, visible to everybody who can access your database or who can view this configuration page.</em>',
	'SmtpPort'					=> 'منفذ خادم SMTP:',
	'SmtpPortInfo'				=> 'قم بتغيير هذا فقط إذا كنت تعرف أن خادم SMTP الخاص بك على منفذ مختلف. <br>(الافتراضي: <code>tls</code> على المنفذ 587 (أو ربما 25) و <code>ssl</code> على المنفذ 465).',
	'SmtpServer'				=> 'عنوان خادم SMTP:',
	'SmtpServerInfo'			=> 'لاحظ أنه يجب عليك توفير البروتوكول الذي يستخدمه الخادم الخاص بك. إذا كنت تستخدم SSL، فيجب أن يكون هذا <code>ssl://mail.example.com</code>.',
	'SmtpUsername'				=> 'اسم المستخدم SMTP:',
	'SmtpUsernameInfo'			=> 'أدخل اسم المستخدم فقط إذا كان خادم SMTP يتطلب ذلك.',

	// Upload settings
	'UploadSettingsInfo'		=> 'هنا يمكنك تكوين الإعدادات الرئيسية للمرفقات والفئات الخاصة المرتبطة بها.',
	'UploadSettingsUpdated'		=> 'تحديث إعدادات الرفع',

	'FileUploadsSection'		=> 'تحميل الملف',
	'RegisteredUsers'			=> 'المستخدمون المسجلون',
	'RightToUpload'				=> 'أذونات تحميل الملفات:',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belonging to the admins group can upload  files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadMaxFilesize'			=> 'الحد الأقصى لحجم الملف:',
	'UploadMaxFilesizeInfo'		=> 'الحد الأقصى لحجم كل ملف. إذا كانت هذه القيمة 0، الحد الأقصى لحجم الملف القابل للتحميل محدود فقط من خلال تكوين PHP.',
	'UploadQuota'				=> 'إجمالي حصة المرفقات:',
	'UploadQuotaInfo'			=> 'الحد الأقصى لمساحة محرك الأقراص المتاحة للمرفقات لكامل الويكي، مع <code>0</code> غير محدودة. %1 مستخدم.',
	'UploadQuotaUser'			=> 'حصة التخزين لكل مستخدم:',
	'UploadQuotaUserInfo'		=> 'تقييد حصة التخزين التي يمكن أن يرفعها مستخدم واحد، مع <code>0</code> غير محدود.',

	'FileTypes'					=> 'أنواع الملفات',
	'UploadOnlyImages'			=> 'السماح فقط بتحميل الصور:',
	'UploadOnlyImagesInfo'		=> 'السماح فقط برفع ملفات الصور على الصفحة.',
	'AllowedUploadExts'			=> 'أنواع الملفات المسموح بها:',
	'AllowedUploadExtsInfo'		=> 'الملحقات المسموح بها لتحميل الملفات، مفصولة بفواصل (أي <code>png، ogg، mp4</code>)؛ وإلا فإن جميع ملحقات الملفات مسموح بها.<br>يجب أن تقصر ملحقات الملفات المسموح بها على الحد الأدنى المطلوب لوظائف موقعك الصحيحة.',
	'CheckMimetype'				=> 'تحقق من نوع MIME :',
	'CheckMimetypeInfo'			=> 'يمكن خداع بعض المتصفحات لفرض نوع غير صحيح للملفات التي تم تحميلها. هذا الخيار يضمن أن مثل هذه الملفات التي من المرجح أن تسبب هذا الرفض.',
	'SvgSanitizer'				=> 'مصحات SVG:',
	'SvgSanitizerInfo'			=> 'هذا يمكّن من تحسين ملفات SVG لمنع تحميل نقاط الضعف SVG/XML.',
	'TranslitFileName'			=> 'نقل أسماء الملف:',
	'TranslitFileNameInfo'		=> 'إذا كان قابلا للتطبيق ولا حاجة إلى وجود أحرف Unicode ، فإنه من المستحسن بشدة قبول الأحرف الأبجدية الرقمية فقط في أسماء الملفات.',
	'TranslitCaseFolding'		=> 'تحويل أسماء الملفات إلى حروف منخفضة:',
	'TranslitCaseFoldingInfo'	=> 'هذا الخيار فعال فقط مع كتابة الترجمة النشطة.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Create thumbnail:',
	'CreateThumbnailInfo'		=> 'إنشاء صورة مصغرة في جميع الحالات الممكنة.',
	'JpegQuality'				=> 'جودة JPEG:',
	'JpegQualityInfo'			=> 'الجودة عند قياس الصورة المصغرة لـ JPEG. يجب أن تكون بين 1 و 100، مع 100 تشير إلى جودة 100٪.',
	'MaxImageArea'				=> 'أقصى مساحة للصورة:',
	'MaxImageAreaInfo'			=> 'الحد الأقصى لعدد البكسلات التي يمكن أن تكون بها صورة مصدر. وهذا يوفر حداً لاستخدام الذاكرة لجانب فك الضغط في مقياس الصورة.<br><code>-1</code> يعني أنه لن يتحقق من حجم الصورة قبل محاولة تحديدها. <code>0</code> يعني أنه سيحدد القيمة تلقائياً.',
	'MaxThumbWidth'				=> 'أقصى عرض مصغر بالبكسل:',
	'MaxThumbWidthInfo'			=> 'الصورة المصغرة التي تم إنشاؤها لن تتجاوز عرض المجموعة هنا.',
	'MinThumbFilesize'			=> 'الحد الأدنى لحجم الملف المصغر:',
	'MinThumbFilesizeInfo'		=> 'لا تنشئ صورة مصغرة للصور الأصغر من هذا.',
	'MaxImageWidth'				=> 'حد حجم الصورة على الصفحات:',
	'MaxImageWidthInfo'			=> 'أقصى عرض للصورة يمكن أن يكون في الصفحات، وإلا يتم إنشاء صورة مصغرة لأسفل.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'قائمة الصفحات والمراجعات والملفات المحذوفة.
									<unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> ازالة أو استعادة الصفحات، التنقيحات أو الملفات من قاعدة البيانات بالنقر على الرابط <em>إزالة</em>
									<unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> <unk> أو <em>الاستعادة</em> في الصف المقابل. (حذر، لا يطلب تأكيد الحذف!)',

	// Filter module
	'FilterSettingsInfo'		=> 'الكلمات التي سيتم رقابتها تلقائيا على الويكي الخاص بك.',
	'FilterSettingsUpdated'		=> 'تحديث إعدادات فلتر البريد المزعج',

	'WordCensoringSection'		=> 'الرقابة على الكلمات',
	'SPAMFilter'				=> 'فلتر البريد المزعج:',
	'SPAMFilterInfo'			=> 'تمكين فلتر البريد المزعج',
	'WordList'					=> 'قائمة الكلمات:',
	'WordListInfo'				=> 'كلمة أو عبارة <code>fragment</code> لتكون مدرجة سوداء (واحد لكل سطر)',

	// Log module
	'LogFilterTip'				=> 'تصفية الأحداث حسب المعايير:',
	'LogLevel'					=> 'المستوى',
	'LogLevelFilters'	=> [
		'1'		=> 'لا يقل عن',
		'2'		=> 'ليس أعلى من',
		'3'		=> 'يساوي',
	],
	'LogNoMatch'				=> 'لا توجد أحداث تستوفي المعايير',
	'LogDate'					=> 'التاريخ',
	'LogEvent'					=> 'الحدث',
	'LogUsername'				=> 'اسم المستخدم',
	'LogLevels'	=> [
		'1'		=> 'حرج',
		'2'		=> 'الأعلى',
		'3'		=> 'عالي',
		'4'		=> 'متوسطه',
		'5'		=> 'منخفض',
		'6'		=> 'أدنى',
		'7'		=> 'تصحيح الأخطاء',
	],

	// Massemail module
	'MassemailInfo'				=> 'هنا يمكنك إرسال رسالة إلى إما (1) جميع المستخدمين أو (2) جميع مستخدمي مجموعة معينة الذين قاموا بتمكين تلقي رسائل البريد الإلكتروني الجماعية. وسترسل رسالة بريد إلكتروني إلى عنوان البريد الإلكتروني الإداري المزود بها، مع إرسال نسخة كربونية أعمى إلى جميع المتلقين. الإعداد الافتراضي هو تضمين 20 مستلم كحد أقصى في مثل هذا البريد الإلكتروني. إذا كان هناك أكثر من 20 مستلم، سيتم إرسال رسائل بريد إلكتروني إضافية. إذا كنت ترسل بالبريد الإلكتروني مجموعة كبيرة من الناس، فيرجى التحلي بالصبر بعد التقديم ولا توقف الصفحة في منتصف الطريق. من الطبيعي أن يستغرق البريد الإلكتروني الجماعي وقتاً طويلاً. سيتم إعلامك عند اكتمال البرنامج النصي.',
	'LogMassemail'				=> 'إرسال بريد إلكتروني شامل %1 إلى مجموعة / مستخدم ',
	'MassemailSend'				=> 'إرسال البريد الإلكتروني الشامل',

	'NoEmailMessage'			=> 'يجب عليك إدخال رسالة.',
	'NoEmailSubject'			=> 'يجب عليك تحديد موضوع لرسالتك.',
	'NoEmailRecipient'			=> 'يجب عليك تحديد مستخدم واحد على الأقل أو مجموعة مستخدم.',

	'MassemailSection'			=> 'البريد الإلكتروني الشامل',
	'MessageSubject'			=> 'الموضوع:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'رسالتك:',
	'YourMessageInfo'			=> 'يرجى ملاحظة أنك قد تدخل فقط plaintext. سيتم إزالة جميع العلامات قبل الإرسال.',

	'NoUser'					=> 'لا يوجد مستخدم',
	'NoUserGroup'				=> 'لا توجد مجموعة مستخدم',

	'SendToGroup'				=> 'إرسال إلى المجموعة:',
	'SendToUser'				=> 'إرسال إلى المستخدم:',
	'SendToUserInfo'			=> 'فقط المستخدمين الذين يسمحون للمسؤولين بإرسال المعلومات إليهم سوف يتلقون رسائل البريد الإلكتروني الجماعي. هذا الخيار متاح في إعدادات المستخدم الخاصة بهم تحت الإخطارات.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'تحديث رسالة النظام',

	'SysMsgSection'				=> 'رسالة النظام',
	'SysMsg'					=> 'رسالة النظام:',
	'SysMsgInfo'				=> 'النص الخاص بك هنا',

	'SysMsgType'				=> 'النوع:',
	'SysMsgTypeInfo'			=> 'نوع الرسالة (CSS).',
	'SysMsgAudience'			=> 'الجمهور:',
	'SysMsgAudienceInfo'		=> 'الجمهور الذي تظهر له رسالة النظام.',
	'EnableSysMsg'				=> 'تمكين رسالة النظام:',
	'EnableSysMsgInfo'			=> 'إظهار رسالة النظام.',

	// User approval module
	'ApproveNotExists'			=> 'الرجاء تحديد مستخدم واحد على الأقل عن طريق زر الضبط.',

	'LogUserApproved'			=> 'تمت الموافقة على المستخدم ##%1##',
	'LogUserBlocked'			=> 'تم حظر المستخدم ##%1##',
	'LogUserDeleted'			=> 'تمت إزالة المستخدم ##%1## من قاعدة البيانات',
	'LogUserCreated'			=> 'تم إنشاء مستخدم جديد ##%1##',
	'LogUserUpdated'			=> 'تم تحديث المستخدم ##%1##',

	'UserApproveInfo'			=> 'الموافقة على المستخدمين الجدد قبل أن يتمكنوا من تسجيل الدخول إلى الموقع.',
	'Approve'					=> 'الموافقة',
	'Deny'						=> 'رفض',
	'Pending'					=> 'معلق',
	'Approved'					=> 'معتمد',
	'Denied'					=> 'مرفوض',

	// DB Backup module
	'BackupStructure'			=> 'الهيكل',
	'BackupData'				=> 'البيانات',
	'BackupFolder'				=> 'مجلد',
	'BackupTable'				=> 'الجدول',
	'BackupCluster'				=> 'المجموعة:',
	'BackupFiles'				=> 'الملفات',
	'BackupNote'				=> 'ملاحظة:',
	'BackupSettings'			=> 'حدد مخطط النسخ الاحتياطي المطلوب.<br>' .
    	'مجموعة الجذر لا تؤثر على النسخ الاحتياطي للملفات العالمية و النسخ الاحتياطي لملفات ذاكرة التخزين المؤقت (إذا تم اختيارها، يتم حفظها دائما كاملة).<br>' .  '<br>' .
		'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster, the tables from this backup will not be restructured, same as when backing up only table structure without saving the data. To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'تم النسخ الاحتياطي والأرشفة.<br>' .
    	'تم تخزين ملفات حزمة النسخ الاحتياطي في الدليل الفرعي %1.<br>. للتنزيل يستخدم FTP (الحفاظ على هيكل الدليل وأسماء الملفات عند النسخ).<br> لاستعادة نسخة احتياطية أو إزالة حزمة، انتقل إلى <a href="%2">استعادة قاعدة البيانات</a>.',
	'LogSavedBackup'			=> 'حفظ قاعدة بيانات النسخ الاحتياطي ##%1##',
	'Backup'					=> 'نسخة احتياطية',
	'CantReadFile'				=> 'لا يمكن قراءة الملف %1.',

	// DB Restore module
	'RestoreInfo'				=> 'يمكنك استعادة أي من حزم النسخ الاحتياطي التي تم العثور عليها، أو إزالتها من الخادم.',
	'ConfirmDbRestore'			=> 'هل تريد استعادة النسخ الاحتياطي %1؟',
	'ConfirmDbRestoreInfo'		=> 'الرجاء الانتظار، قد يستغرق هذا بعض الوقت.',
	'RestoreWrongVersion'		=> 'إصدار WackoWiki غير صحيح!',
	'DirectoryNotExecutable'	=> 'دليل %1 غير قابل للتنفيذ.',
	'BackupDelete'				=> 'هل أنت متأكد من أنك تريد إزالة النسخ الاحتياطي %1؟',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'خيارات استعادة إضافية:',
	'RestoreOptionsInfo'		=> '* قبل استعادة النسخة الاحتياطية للمجموعة <strong></strong>، ' .
									'لا تحذف الجداول المستهدفة (لمنع فقدان المعلومات من المجموعات التي لم يتم النسخ الاحتياطي لها). ' .
									'ومن ثم فإن السجلات المزدوجة ستحدث خلال عملية الاسترداد. ' .
									'في الوضع العادي، سيتم استبدالها جميعا بالنسخ الاحتياطي لنموذج السجلات (باستخدام SQL <code>REPLACE</code>)، ' .
									'ولكن إذا تم تحديد خانة الاختيار هذه، يتم تخطي جميع التكرار (سيتم حفظ القيم الحالية للسجلات)، ' .
									'and only the records with new keys are added to the table (SQL <code>INSERT IGNORE</code>).<br>' .
									'<strong>الإشعار</strong>: عند استعادة النسخ الاحتياطي الكامل للموقع، هذا الخيار ليس له قيمة.<br>' .
									'<br>' .
									'** إذا كانت النسخة الاحتياطية تحتوي على ملفات المستخدم (العام والصفحة، ملفات ذاكرة التخزين المؤقت، إلخ.)، ' .
									'في الوضع العادي تستبدل الملفات الموجودة بنفس الأسماء وتوضع في نفس الدليل عند استعادتها. ' .
									'هذا الخيار يسمح لك بحفظ النسخ الحالية من الملفات والاستعادة من النسخ الاحتياطية فقط الملفات الجديدة (مفقودة على الخادم).',
	'IgnoreDuplicatedKeysNr'	=> 'تجاهل مفاتيح الجدول المكررة (غير بديل)',
	'IgnoreSameFiles'			=> 'تجاهل نفس الملفات (ليس الكتابة فوق)',
	'NoBackupsAvailable'		=> 'لا توجد نسخ احتياطية متاحة.',
	'BackupEntireSite'			=> 'الموقع بأكمله',
	'BackupRestored'			=> 'يتم استعادة النسخ الاحتياطي، يرفق تقرير موجز أدناه. لحذف هذه الحزمة الاحتياطية، انقر فوق',
	'BackupRemoved'				=> 'تم إزالة النسخة الاحتياطية المحددة بنجاح.',
	'LogRemovedBackup'			=> 'تمت إزالة النسخ الاحتياطي لقاعدة البيانات ##%1##',

	'RestoreStarted'			=> 'بدء الاستعادة',
	'RestoreParameters'			=> 'استخدام المعلمات',
	'IgnoreDuplicatedKeys'		=> 'تجاهل المفاتيح المكررة',
	'IgnoreDuplicatedFiles'		=> 'تجاهل الملفات المكررة',
	'SavedCluster'				=> 'مجموعة محفوظة',
	'DataProtection'			=> 'حماية البيانات - %1 محذوف',
	'AssumeDropTable'			=> 'افترض %1',
	'RestoreTableStructure'		=> 'باء - استعادة هيكل الجدول',
	'RunSqlQueries'				=> 'تنفيذ تعليمات SQL:',
	'CompletedSqlQueries'		=> 'اكتمل. التعليمات المعالجة:',
	'NoTableStructure'			=> 'لم يتم حفظ هيكل الجداول - تخطي',
	'RestoreRecords'			=> 'استعادة محتويات الجداول',
	'ProcessTablesDump'			=> 'فقط تنزيل و معالجة مقالب الجداول',
	'Instruction'				=> 'تعليمات',
	'RestoredRecords'			=> 'السجلات:',
	'RecordsRestoreDone'		=> 'اكتمل. اجمالي الإدخالات:',
	'SkippedRecords'			=> 'لم يتم حفظ البيانات - تخطي',
	'RestoringFiles'			=> 'استعادة الملفات',
	'DecompressAndStore'		=> 'فك ضغط محتويات الأدلة وتخزينها',
	'HomonymicFiles'			=> 'ملفات الأسماء الشخصية',
	'RestoreSkip'				=> 'تخطي',
	'RestoreReplace'			=> 'استبدل',
	'RestoreFile'				=> 'الملف:',
	'RestoredFiles'				=> 'الاستعادة:',
	'SkippedFiles'				=> 'تخطى:',
	'FileRestoreDone'			=> 'اكتمل. اجمالي الملفات:',
	'FilesAll'					=> 'الكل:',
	'SkipFiles'					=> 'لم يتم تخزين الملفات - تخطي',
	'RestoreDone'				=> 'تكملة الإصلاح',

	'BackupCreationDate'		=> 'تاريخ الإنشاء',
	'BackupPackageContents'		=> 'محتويات الحزمة',
	'BackupRestore'				=> 'إستعادة',
	'BackupRemove'				=> 'إزالة',
	'RestoreYes'				=> 'نعم',
	'RestoreNo'					=> 'لا',
	'LogDbRestored'				=> 'تم استعادة النسخ الاحتياطي ##%1## من قاعدة البيانات.',

	'BackupArchived'			=> 'النسخ الاحتياطي %1 المؤرشف.',
	'BackupArchiveExists'		=> 'النسخ الاحتياطي أرشيف %1 موجود بالفعل.',
	'LogBackupArchived'			=> 'تم أرشفة النسخ الاحتياطي ##%1.',

	// User module
	'UsersInfo'					=> 'هنا يمكنك تغيير معلومات المستخدمين وخيارات محددة معينة.',

	'UsersAdded'				=> 'تم إضافة المستخدم',
	'UsersDeleteInfo'			=> 'حذف المستخدم:',
	'EditButton'				=> 'تحرير',
	'UsersAddNew'				=> 'إضافة مستخدم جديد',
	'UsersDelete'				=> 'هل أنت متأكد من أنك تريد إزالة المستخدم %1؟',
	'UsersDeleted'				=> 'تم حذف المستخدم %1 من قاعدة البيانات.',
	'UsersRename'				=> 'إعادة تسمية المستخدم %1 إلى',
	'UsersRenameInfo'			=> '* ملاحظة: سيؤثر التغيير على جميع الصفحات التي تم تعيينها لذلك المستخدم.',
	'UsersUpdated'				=> 'تم تحديث المستخدم بنجاح.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'وقت التسجيل',
	'UserActions'				=> 'الإجراءات',
	'NoMatchingUser'			=> 'لا يوجد مستخدمين يستوفون المعايير',

	'UserAccountNotify'			=> 'إشعار المستخدم',
	'UserNotifySignup'			=> 'إبلاغ المستخدم عن الحساب الجديد',
	'UserVerifyEmail'			=> 'تعيين تأكيد الرمز المميز للبريد الإلكتروني وإضافة رابط للتحقق من البريد الإلكتروني',
	'UserReVerifyEmail'			=> 'إعادة إرسال تأكيد البريد الإلكتروني',

	// Groups module
	'GroupsInfo'				=> 'من هذا اللوحة، يمكنك إدارة جميع مجموعات المستخدمين الخاصة بك. يمكنك حذف وإنشاء وتعديل المجموعات الموجودة. علاوة على ذلك، يمكنك اختيار قادة المجموعة، وتغيير حالة المجموعات المفتوحة/المخفية/المغلقة وتعيين اسم المجموعة ووصفها.',

	'LogMembersUpdated'			=> 'تحديث أعضاء مجموعة المستخدمين',
	'LogMemberAdded'			=> 'تم إضافة عضو ##%1## للمجموعة ##%2 ## #',
	'LogMemberRemoved'			=> 'تمت إزالة العضو ##%1## من المجموعة ##%2 ## #',
	'LogGroupCreated'			=> 'تم إنشاء مجموعة جديدة ##%1##',
	'LogGroupRenamed'			=> 'تم تغيير اسم المجموعة ##%1## إلى ##%2##',
	'LogGroupRemoved'			=> 'تمت إزالة المجموعة ##%1##',

	'GroupsMembersFor'			=> 'أعضاء المجموعة',
	'GroupsDescription'			=> 'الوصف',
	'GroupsModerator'			=> 'المشرف',
	'GroupsOpen'				=> 'فتح',
	'GroupsActive'				=> 'نشط',
	'GroupsTip'					=> 'انقر لتعديل المجموعة',
	'GroupsUpdated'				=> 'تم تحديث المجموعات',
	'GroupsAlreadyExists'		=> 'هذه المجموعة موجودة مسبقاً.',
	'GroupsAdded'				=> 'تمت إضافة المجموعة بنجاح.',
	'GroupsRenamed'				=> 'تمت إعادة تسمية المجموعة بنجاح.',
	'GroupsDeleted'				=> 'تم حذف المجموعة %1 وجميع الصفحات المرتبطة بها من قاعدة البيانات.',
	'GroupsAdd'					=> 'إضافة مجموعة جديدة',
	'GroupsRename'				=> 'إعادة تسمية المجموعة %1 إلى',
	'GroupsRenameInfo'			=> '* ملاحظة: سيؤثر التغيير على جميع الصفحات التي تم تعيينها لتلك المجموعة.',
	'GroupsDelete'				=> 'هل أنت متأكد من أنك تريد إزالة المجموعة %1؟',
	'GroupsDeleteInfo'			=> '* ملاحظة: سيؤثر التغيير على جميع الأعضاء المعينين لتلك المجموعة.',
	'GroupsIsSystem'			=> 'المجموعة %1 تنتمي إلى النظام ولا يمكن إزالتها.',
	'GroupsStoreButton'			=> 'حفظ المجموعات',
	'GroupsEditInfo'			=> 'لتحرير قائمة المجموعات حدد زر الراديو.',

	'GroupAddMember'			=> 'إضافة عضو',
	'GroupRemoveMember'			=> 'إزالة عضو',
	'GroupAddNew'				=> 'إضافة مجموعة',
	'GroupEdit'					=> 'تحرير المجموعة',
	'GroupDelete'				=> 'إزالة المجموعة',

	'MembersAddNew'				=> 'إضافة عضو جديد',
	'MembersAdded'				=> 'تمت إضافة عضو جديد إلى المجموعة بنجاح.',
	'MembersRemove'				=> 'هل أنت متأكد من أنك تريد إزالة العضو %1؟',
	'MembersRemoved'			=> 'وقد عُزل العضو من المجموعة.',

	// Statistics module
	'DbStatSection'				=> 'إحصائيات قاعدة البيانات',
	'DbTable'					=> 'الجدول',
	'DbRecords'					=> 'السجلات',
	'DbSize'					=> 'الحجم',
	'DbIndex'					=> 'الفهرس',
	'DbOverhead'				=> 'رأس',
	'DbTotal'					=> 'المجموع',

	'FileStatSection'			=> 'إحصائيات نظام الملفات',
	'FileFolder'				=> 'مجلد',
	'FileFiles'					=> 'الملفات',
	'FileSize'					=> 'الحجم',
	'FileTotal'					=> 'المجموع',

	// Sysinfo module
	'SysInfo'					=> 'معلومات الإصدار:',
	'SysParameter'				=> 'المعلمة',
	'SysValues'					=> 'القيم',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'آخر تحديث',
	'ServerOS'					=> 'نظام التشغيل',
	'ServerName'				=> 'اسم الخادم',
	'WebServer'					=> 'خادم الويب',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'أنماط SQL العالمية',
	'SqlModesSession'			=> 'جلسة وضع SQL',
	'IcuVersion'				=> 'إيكو',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'الذاكرة',
	'UploadFilesizeMax'			=> 'رفع الحد الأقصى لحجم الملف',
	'PostMaxSize'				=> 'حجم النشر الأقصى',
	'MaxExecutionTime'			=> 'الحد الأقصى لوقت التنفيذ',
	'SessionPath'				=> 'مسار الجلسة',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'ضغط GZip',
	'PhpExtensions'				=> 'ملحقات PHP',
	'ApacheModules'				=> 'وحدات أباتشي',

	// DB repair module
	'DbRepairSection'			=> 'إصلاح قاعدة البيانات',
	'DbRepair'					=> 'إصلاح قاعدة البيانات',
	'DbRepairInfo'				=> 'يمكن لهذا البرنامج النصي البحث تلقائياً عن بعض مشاكل قاعدة البيانات المشتركة وإصلاحها. يمكن أن يستغرق الإصلاح بعض الوقت، لذا يرجى التحلي بالصبر.',

	'DbOptimizeRepairSection'	=> 'إصلاح وتحسين قاعدة البيانات',
	'DbOptimizeRepair'			=> 'إصلاح وتحسين قاعدة البيانات',
	'DbOptimizeRepairInfo'		=> 'يمكن أن يحاول هذا النص أيضا تحسين قاعدة البيانات. هذا يحسن الأداء في بعض الحالات. قد يستغرق إصلاح قاعدة البيانات وتحسينها وقتاً طويلاً وسيتم تأمين قاعدة البيانات أثناء تحسينها.',

	'TableOk'					=> 'الجدول %1 على ما يرام.',
	'TableNotOk'				=> 'جدول %1 ليس على ما يرام. إنه يبلّغ عن الخطأ التالي: %2. سيحاول هذا البرنامج النصي إصلاح هذا الجدول&hellip;',
	'TableRepaired'				=> 'تم إصلاح جدول %1 بنجاح.',
	'TableRepairFailed'			=> 'فشل إصلاح جدول %1 . <br>خطأ: %2',
	'TableAlreadyOptimized'		=> 'الجدول %1 تم تحسينه بالفعل.',
	'TableOptimized'			=> 'تم تحسين جدول %1 بنجاح.',
	'TableOptimizeFailed'		=> 'فشل تحسين جدول %1 . <br>خطأ: %2',
	'TableNotRepaired'			=> 'ولم يتسن إصلاح بعض مشاكل قواعد البيانات.',
	'RepairsComplete'			=> 'اكتملت الإصلاحات',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'إظهار وإصلاح أوجه التضارب، حذف أو تعيين السجلات اليتيمة لمستخدم جديد / قيمة.',
	'Inconsistencies'			=> 'التناقضات',
	'CheckDatabase'				=> 'قاعدة البيانات',
	'CheckDatabaseInfo'			=> 'التحقق من وجود تناقضات في السجلات في قاعدة البيانات.',
	'CheckFiles'				=> 'الملفات',
	'CheckFilesInfo'			=> 'التحقق من الملفات المتروكة، الملفات التي لا توجد أي إشارة متبقية في جدول الملفات.',
	'Records'					=> 'السجلات',
	'InconsistenciesNone'		=> 'لم يتم العثور على تناقضات البيانات.',
	'InconsistenciesDone'		=> 'تم حل تناقضات البيانات.',
	'InconsistenciesRemoved'	=> 'إزالة التناقضات',
	'Check'						=> 'تحقق',
	'Solve'						=> 'حل',

	// Bad Behaviour module
	'BbInfo'					=> 'Detects and blocks unwanted web accesses, deny automated spambots access.<br>For more information, please visit the %1 homepage.',
	'BbEnable'					=> 'تمكين السلوك السيئ:',
	'BbEnableInfo'				=> 'يمكن تغيير جميع الإعدادات الأخرى في مجلد التكوين %1.',
	'BbStats'					=> 'السلوك السيئ قام بحظر محاولات الوصول ل %1 خلال الأيام السبعة الأخيرة.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'سجل',
	'BbSettings'				=> 'إعدادات',
	'BbWhitelist'				=> 'القائمة البيضاء',

	// --> Log
	'BbHits'					=> 'الارتطام',
	'BbRecordsFiltered'			=> 'عرض %1 من %2 سجلات تم تصفيتها بواسطة',
	'BbStatus'					=> 'الحالة',
	'BbBlocked'					=> 'محظور',
	'BbPermitted'				=> 'مسموح',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'عرض جميع سجلات %1',
	'BbShow'					=> 'إظهار',
	'BbIpDateStatus'			=> 'IP/التاريخ/الحالة',
	'BbHeaders'					=> 'الترويسات',
	'BbEntity'					=> 'الكيان',

	// --> Whitelist
	'BbOptionsSaved'			=> 'الخيارات المحفوظة.',
	'BbWhitelistHint'			=> 'القائمة البيضاء غير المناسبة تعرضك للبريد المزعج، أو تسبب في توقف السلوك السيئ عن العمل تمامًا! لا تتحدث إلا إذا كنت 100٪ من القروض.',
	'BbIpAddress'				=> 'عنوان IP',
	'BbIpAddressInfo'			=> 'عنوان IP أو تنسيق عنوان CIDR نطاقات العناوين لتكون مدرجة في القائمة البيضاء (واحد لكل سطر)',
	'BbUrl'						=> 'الرابط',
	'BbUrlInfo'					=> 'أجزاء URL تبدأ ب/ بعد اسم مضيف موقع الويب الخاص بك (واحد لكل سطر)',
	'BbUserAgent'				=> 'وكيل المستخدم',
	'BbUserAgentInfo'			=> 'سلاسل وكيل المستخدم لتكون مدرجة في القائمة البيضاء (واحد لكل سطر)',

	// --> Settings
	'BbSettingsUpdated'			=> 'تحديث إعدادات السلوك السيئ',
	'BbLogRequest'				=> 'تسجيل طلب HTTP',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (مستحسن)',
	'BbLogOff'					=> 'لا تقم بتسجيل الدخول (غير مستحسن)',
	'BbSecurity'				=> 'أمان',
	'BbStrict'					=> 'التحقق الدقيق',
	'BbStrictInfo'				=> 'حظر المزيد من الرسائل غير المرغوب فيها ولكن قد تمنع بعض الأشخاص',
	'BbOffsiteForms'			=> 'السماح بنشر النموذج من مواقع الويب الأخرى',
	'BbOffsiteFormsInfo'		=> 'مطلوب لمعرف OpenID؛ زيادة البريد المزعج المستلم',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'لاستخدام سلوكيات سيئة http:BL يجب أن يكون لديك %1',
	'BbHttpblKey'				=> 'http:BL مفتاح الوصول',
	'BbHttpblThreat'			=> 'الحد الأدنى لمستوى التهديد (25 موصى به)',
	'BbHttpblMaxage'			=> 'الحد الأقصى لسن البيانات (30 موصى به)',
	'BbReverseProxy'			=> 'عكس Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'If you are using Bad Behaviour behind a reverse proxy, load balancer, HTTP accelerator, content cache or similar technology, enable the Reverse Proxy option.<br>' .
									'إذا كان لديك سلسلة من اثنين أو أكثر من وكلاء عكسيين بين الخادم الخاص بك والإنترنت العام، يجب عليك تحديد <em>جميع</em> من نطاقات عناوين IP (بتنسيق CIDR) لجميع خوادم البروكسي الخاصة بك، وتحميل البانرز، إلخ. خلاف ذلك، قد يكون السلوك السيئ غير قادر على تحديد عنوان IP الحقيقي للعميل.<br>' .
									'بالإضافة إلى ذلك، يجب على خوادم البروكسي العكسية الخاصة بك تعيين عنوان IP لعميل الإنترنت الذي تلقوا منه الطلب في عنوان HTTP. إذا لم تقم بتحديد رأس ، سيتم استخدام %1 . معظم خوادم البروكسي تدعم بالفعل X-Forwarded-for وسوف تحتاج فقط إلى التأكد من أنه مفعل على خوادم البروكسي الخاصة بك. وتشمل بعض أسماء الرؤوس الأخرى التي يشيع استخدامها %2 و %3.',
	'BbReverseProxyEnable'		=> 'تمكين الوكيل العكسي',
	'BbReverseProxyHeader'		=> 'العنوان الذي يحتوي على عنوان IP لعملاء الإنترنت',
	'BbReverseProxyAddresses'	=> 'نطاق عنوان IP أو تنسيق عنوان CIDR لخوادم البروكسي الخاص بك (واحد لكل سطر)',

];
