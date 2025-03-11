<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'ar',
'LangLocale'	=> 'ar_EG',
'LangName'		=> 'Arabic',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'الفئة',
	'groups_page'		=> 'المجموعات',
	'users_page'		=> 'المستخدمون',

	'search_page'		=> 'ابحث',
	'login_page'		=> 'دخول',
	'account_page'		=> 'إعدادات',
	'registration_page'	=> 'التسجيل',
	'password_page'		=> 'كلمة السر',

	'changes_page'		=> 'التغييرات الأخيرة',
	'comments_page'		=> 'تم التعليق مؤخرا',
	'index_page'		=> 'PageIndex',

	'random_page'		=> 'عشوائي',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'تثبيت WackoWiki',
'TitleUpdate'					=> 'تحديث WackoWiki',
'Continue'						=> 'متابعة',
'Back'							=> 'الرجوع',
'Recommended'					=> 'مستحسن',
'InvalidAction'					=> 'إجراء غير صالح',

/*
   Language Selection Page
*/
'lang'							=> 'تكوين اللغة',
'PleaseUpgradeToR6'				=> 'يبدو أنك تقوم بتشغيل إصدار قديم (قبل %2) من WackoWiki (%1). للتحديث إلى هذا الإصدار من WackoWiki ، يجب أولاً تحديث التثبيت الخاص بك إلى %2.',
'UpgradeFromWacko'				=> 'مرحبا بكم في WackoWiki! يبدو أنك تقوم بالترقية من WackoWiki %1 إلى %2. الصفحات القليلة القادمة سوف توجهك من خلال عملية الترقية.',
'FreshInstall'					=> 'مرحبا بك في WackoWiki! أنت على وشك تثبيت WackoWiki %1. ستوجهك الصفحات القليلة القادمة خلال عملية التثبيت.',
'PleaseBackup'					=> 'Please, <strong>backup</strong> your database, config file and all changed files such as those which have local hacks and patches applied to them before starting upgrade process. This can save you from a big headache.',
'LangDesc'						=> 'الرجاء اختيار لغة لعملية التثبيت. سوف تستخدم هذه اللغة أيضا كلغة افتراضية لتثبيت WackoWiki الخاص بك.',

/*
   System Requirements Page
*/
'version-check'					=> 'متطلبات النظام',
'PhpVersion'					=> 'إصدار PHP',
'PhpDetected'					=> 'تم اكتشاف PHP',
'ModRewrite'					=> 'ملحق إعادة كتابة أباتشي (اختياري)',
'ModRewriteInstalled'			=> 'إعادة كتابة ملحق (mod_rewrite) مثبت؟',
'Database'						=> 'قاعدة البيانات',
'PhpExtensions'					=> 'ملحقات PHP',
'Permissions'					=> 'الأذونات',
'ReadyToInstall'				=> 'جاهز للتثبيت؟',
'Requirements'					=> 'يجب أن يفي الخادم الخاص بك بالمتطلبات المدرجة أدناه.',
'OK'							=> 'حسناً',
'Problem'						=> 'مشكلة',
'Example'						=> 'مثال',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'يبدو أن تثبيت PHP الخاص بك مفقود ملحقات PHP المشار إليها، والتي مطلوبة من قبل واكوويكي.',
'PcreWithoutUtf8'				=> 'لم يتم تجميع PCRE بدعم من UTF-8.',
'NotePermissions'				=> 'سيحاول هذا المثبت كتابة بيانات التكوين إلى الملف %1الموجود في دليل WackoWiki الخاص بك. لكي يعمل هذا، يجب أن تتأكد من أن خادم الويب لديه صلاحية الكتابة إلى ذلك الملف. إذا لم تستطع فعل ذلك، فسيتعين عليك تعديل الملف يدوياً (سوف يخبرك المثبت كيف).<br><br>انظر <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> للحصول على التفاصيل.',
'ErrorPermissions'				=> 'يبدو أن المثبت لا يمكنه تعيين أذونات الملف المطلوبة تلقائيًا لتشغيل WackoWiki بشكل صحيح. سيتم مطالبتك لاحقاً في عملية التثبيت لتهيئة أذونات الملف المطلوبة يدوياً على الخادم الخاص بك.',
'ErrorMinPhpVersion'			=> 'يجب أن يكون إصدار PHP أكبر من %1. يبدو أن الخادم الخاص بك يقوم بتشغيل إصدار سابق. يجب عليك الترقية إلى إصدار PHP أحدث لWackoWiki للعمل بشكل صحيح.',
'Ready'							=> 'تهانينا، يبدو أن الخادم الخاص بك قادر على تشغيل WackoWiki. الصفحات القليلة القادمة سوف تأخذك من خلال عملية الإعداد.',

/*
   Site Config Page
*/
'config-site'					=> 'تكوين الموقع',
'SiteName'						=> 'اسم ويكي',
'SiteNameDesc'					=> 'الرجاء إدخال اسم موقع ويكي الخاص بك.',
'SiteNameDefault'				=> 'ماي ويكي',
'HomePage'						=> 'الصفحة الرئيسية',
'HomePageDesc'					=> 'Enter the name you would like your home page to have. This will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'الصفحة الرئيسية',
'MultiLang'						=> 'وضع تعدد اللغات',
'MultiLangDesc'					=> 'وضع تعدد اللغات يسمح لك بأن يكون لديك صفحات ذات إعدادات لغة مختلفة ضمن تثبيت واحد. عند تمكين هذا الوضع، يقوم المثبت بإنشاء عناصر قائمة أولية لجميع اللغات المتاحة في التوزيع.',
'AllowedLang'					=> 'اللغات المسموح بها',
'AllowedLangDesc'				=> 'من المستحسن فقط تحديد مجموعة اللغات التي تريد استخدامها، وإلا تم تحديد جميع اللغات.',
'Admin'							=> 'اسم المشرف',
'AdminDesc'						=> 'Enter the admin\'s username. This should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'اسم المستخدم يجب أن يكون بين أحرف %1 و %2 طويلة و يستخدم أحرف أبجدية رقمية فقط. الأحرف العلوية على ما يرام.',
'NameCamelCaseOnly'				=> 'اسم المستخدم يجب أن يكون بين أحرف %1 و %2 طويلة و ويكيم.',
'Password'						=> 'كلمة مرور المدير',
'PasswordDesc'					=> 'اختر كلمة مرور للمشرف مع حد أدنى من أحرف %1.',
'PasswordConfirm'				=> 'كرر كلمة المرور:',
'Mail'							=> 'عنوان البريد الإلكتروني للمدير',
'MailDesc'						=> 'أدخل عنوان البريد الإلكتروني للمشرف.',
'Base'							=> 'الرابط الأساسي',
'BaseDesc'						=> 'رابط قاعدة موقع WackoWiki الخاص بك. يتم إرفاق أسماء الصفحات بها، لذلك إذا كنت تستخدم mod_rewrite ، يجب أن ينتهي العنوان ببطء إلى الأمام، أي',
'Rewrite'						=> 'إعادة كتابة الوضع',
'RewriteDesc'					=> 'يجب تمكين وضع إعادة الكتابة إذا كنت تستخدم WackoWiki مع إعادة كتابة عنوان URL.',
'Enabled'						=> 'مفعل:',
'ErrorAdminEmail'				=> 'لقد قمت بإدخال عنوان بريد إلكتروني غير صالح!',
'ErrorAdminPasswordMismatch'	=> 'كلمات المرور غير متطابقة!.',
'ErrorAdminPasswordShort'		=> 'كلمة مرور المشرف قصيرة جداً! الحد الأدنى لطول الأحرف %1.',
'ModRewriteStatusUnknown'		=> 'لا يمكن للمثبت التحقق من أن mod_rewrite مفعل. ولكن هذا لا يعني أنه معطل.',

/*
   Database Config Page
*/
'config-database'				=> 'تكوين قاعدة البيانات',
'DbDriver'						=> 'سائق',
'DbDriverDesc'					=> 'مشغل قاعدة البيانات الذي تريد استخدامه.',
'DbSqlMode'						=> 'وضع SQL',
'DbSqlModeDesc'					=> 'وضع SQL الذي تريد استخدامه.',
'DbVendor'						=> 'البائع',
'DbVendorDesc'					=> 'بائع قاعدة البيانات الذي تستخدمه.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'محارف قاعدة البيانات التي تريد استخدامها.',
'DbEngine'						=> 'محرك',
'DbEngineDesc'					=> 'محرك قاعدة البيانات الذي تريد استخدامه.',
'DbHost'						=> 'المضيف',
'DbHostDesc'					=> 'المضيف الذي يعمل به خادم قاعدة البيانات الخاص بك، عادة <code>127.0.0.1</code> أو <code>localhost</code> (أي نفس الآلة التي يعمل بها موقع WackoWiki).',
'DbPort'						=> 'المنفذ (اختياري)',
'DbPortDesc'					=> 'رقم المنفذ الخاص بك خادم قاعدة البيانات يمكن الوصول إليه من خلال. اتركه فارغاً لاستخدام رقم المنفذ الافتراضي.',
'DbName'						=> 'اسم قاعدة البيانات',
'DbNameDesc'					=> 'قاعدة البيانات WackoWiki يجب أن تستخدم. قاعدة البيانات هذه يجب أن تكون موجودة بالفعل قبل المتابعة!',
'DbUser'						=> 'اسم المستخدم',
'DbUserDesc'					=> 'اسم المستخدم المستخدم للاتصال بقاعدة البيانات الخاصة بك.',
'DbPassword'					=> 'كلمة السر',
'DbPasswordDesc'				=> 'كلمة المرور للمستخدم المستخدمة للاتصال بقاعدة البيانات الخاصة بك.',
'Prefix'						=> 'بادئة الجدول',
'PrefixDesc'					=> 'بادئة جميع الجداول المستخدمة من قبل واكوويكي. هذا يسمح لك بتشغيل العديد من تثبيت WackoWiki باستخدام نفس قاعدة البيانات عن طريق تكوينها لاستخدام بادئات جداول مختلفة (مثل wacko_).',
'ErrorNoDbDriverDetected'		=> 'لم يتم اكتشاف أي مشغل قاعدة بيانات، يرجى تمكين ملحق mysqli أو pdo_mysql في ملف php.ini.',
'ErrorNoDbDriverSelected'		=> 'لم يتم تحديد أي مشغل قاعدة بيانات، يرجى اختيار واحد من القائمة.',
'DeleteTables'					=> 'حذف الجداول الموجودة؟',
'DeleteTablesDesc'				=> 'تحذير! إذا قمت بالمضي قدما في هذا الخيار، سيتم مسح جميع بيانات ويكي الحالية من قاعدة البيانات الخاصة بك. لا يمكن التراجع عن هذا، وسوف تكون مطلوبا لاستعادة البيانات يدوياً من نسخة احتياطية.',
'ConfirmTableDeletion'			=> 'هل أنت متأكد من أنك تريد حذف جميع جداول ويكي الحالية؟',

/*
   Database Installation Page
*/
'install-database'				=> 'تثبيت قاعدة البيانات',
'TestingConfiguration'			=> 'اختبار التكوين',
'TestConnectionString'			=> 'اختبار إعدادات اتصال قاعدة البيانات',
'TestDatabaseExists'			=> 'التحقق مما إذا كانت قاعدة البيانات التي حددتها موجودة',
'TestDatabaseVersion'			=> 'التحقق من الحد الأدنى لاشتراطات إصدار قاعدة البيانات',
'InstallTables'					=> 'تثبيت الجداول',
'ErrorDbConnection'				=> 'حدثت مشكلة مع تفاصيل اتصال قاعدة البيانات التي حددتها، يرجى العودة والتحقق من صحتها.',
'ErrorDatabaseVersion'			=> 'إصدار قاعدة البيانات هو %1 ولكن يتطلب على الأقل %2.',
'To'							=> 'إلى',
'AlterTable'					=> 'تغيير جدول %1',
'InsertRecord'					=> 'إدراج السجل في جدول %1',
'RenameTable'					=> 'إعادة تسمية جدول %1',
'UpdateTable'					=> 'تحديث جدول %1',
'InstallDefaultData'			=> 'إضافة البيانات الافتراضية',
'InstallPagesBegin'				=> 'إضافة الصفحات الافتراضية',
'InstallPagesEnd'				=> 'تم الانتهاء من إضافة الصفحات الافتراضية',
'InstallSystemAccount'			=> 'Adding <code>System</code> User',
'InstallDeletedAccount'			=> 'Adding <code>Deleted</code> User',
'InstallAdmin'					=> 'إضافة مستخدم مسؤول',
'InstallAdminSetting'			=> 'إضافة تفضيلات مستخدم المدير',
'InstallAdminGroup'				=> 'إضافة مجموعة المشرفين',
'InstallAdminGroupMember'		=> 'إضافة عضو مجموعة المشرفين',
'InstallEverybodyGroup'			=> 'إضافة مجموعة الجميع',
'InstallModeratorGroup'			=> 'إضافة مجموعة المشرفين',
'InstallReviewerGroup'			=> 'إضافة مجموعة المستعرض',
'InstallLogoImage'				=> 'إضافة صورة الشعار',
'LogoImage'						=> 'صورة الشعار',
'InstallConfigValues'			=> 'إضافة قيم التكوين',
'ConfigValues'					=> 'قيم التكوين',
'ErrorInsertPage'				=> 'خطأ في إدراج صفحة %1',
'ErrorInsertPagePermission'		=> 'خطأ في تعيين إذن لصفحة %1',
'ErrorInsertDefaultMenuItem'	=> 'خطأ في إعداد الصفحة %1 كعنصر قائمة افتراضي',
'ErrorPageAlreadyExists'		=> 'صفحة %1 موجودة بالفعل',
'ErrorAlterTable'				=> 'خطأ في تغيير جدول %1',
'ErrorInsertRecord'				=> 'خطأ في إدراج السجل في جدول %1',
'ErrorRenameTable'				=> 'خطأ في إعادة تسمية جدول %1',
'ErrorUpdatingTable'			=> 'خطأ في تحديث جدول %1',
'CreatingTable'					=> 'إنشاء جدول %1',
'ErrorAlreadyExists'			=> '%1 موجود بالفعل',
'ErrorCreatingTable'			=> 'خطأ في إنشاء جدول %1 ، هل هو موجود بالفعل؟',
'DeletingTables'				=> 'حذف الجداول',
'DeletingTablesEnd'				=> 'انتهى حذف الجداول',
'ErrorDeletingTable'			=> 'خطأ في حذف جدول %1 . السبب الأرجح هو أن الجدول غير موجود، وفي هذه الحالة يمكنك تجاهل هذا التحذير.',
'DeletingTable'					=> 'حذف جدول %1',
'NextStep'						=> 'في الخطوة التالية، سيحاول المثبت كتابة ملف التكوين المحدث، %1. الرجاء التأكد من أن خادم الويب لديه صلاحية الكتابة إلى الملف، أو يجب عليك تعديله يدوياً. مرة أخرى، انظر  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> للحصول على التفاصيل.',

/*
   Write Config Page
*/
'write-config'					=> 'كتابة ملف التكوين',
'FinalStep'						=> 'الخطوة النهائية',
'Writing'						=> 'كتابة ملف التكوين',
'RemovingWritePrivilege'		=> 'إزالة امتياز الكتابة',
'InstallationComplete'			=> 'اكتمل التثبيت',
'ThatsAll'						=> 'هذا كل شيء! يمكنك الآن <a href="%1">عرض موقع WackoWiki الخاص بك</a>.',
'SecurityConsiderations'		=> 'الاعتبارات الأمنية',
'SecurityRisk'					=> 'ينصح لك بإزالة الوصول إلى الكتابة إلى %1 الآن بعد أن تم كتابته. ترك الملف قابل للكتابة يمكن أن يكون خطراً أمنياً!<br>أي %2',
'RemoveSetupDirectory'			=> 'يجب عليك حذف دليل %1 الآن بعد اكتمال عملية التثبيت.',
'ErrorGivePrivileges'			=> 'تعذر كتابة ملف التكوين %1 . سوف تحتاج إلى إعطاء خادم الويب الخاص بك حق الوصول إلى الكتابة المؤقتة إما إلى دليل WackoWiki الخاص بك، أو ملف فارغ يسمى %1<br>%2.<br><br> لا تنسى إزالة الوصول إلى الكتابة مرة أخرى لاحقا، أي <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'إذا ، لأي سبب ، لا يمكنك فعل ذلك ، يجب عليك نسخ النص أدناه في ملف جديد وحفظ/رفع كـ %1 في دليل واكوويكي. بمجرد أن تفعل ذلك، يجب أن يعمل موقع WackoWiki الخاص بك. إذا لم يكن الأمر كذلك، يرجى زيارة <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Ininstallation</a>',
'ErrorPrivilegesUpgrade'		=> 'بمجرد أن تفعل ذلك، يجب أن يعمل موقع WackoWiki الخاص بك. إذا لم يكن الأمر كذلك، يرجى زيارة <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'مكتوب في ',
'DontChange'					=> 'لا تغير wacko_version يدويًا!',
'ConfigDescription'				=> 'وصف تفصيلي: https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'حاول مرة أخرى',

];
