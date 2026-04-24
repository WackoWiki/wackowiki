<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'th',
'LangLocale'	=> 'th_TH',
'LangName'		=> 'Thai',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
	'ConfigDefaults'	=> [
		'category_page'		=> 'Category',
		'groups_page'		=> 'Groups',
		'users_page'		=> 'Users',
		'tools_page'		=> 'เครื่องมือ',

		'search_page'		=> 'Search',
		'login_page'		=> 'Login',
		'account_page'		=> 'Settings',
		'registration_page'	=> 'Registration',
		'password_page'		=> 'Password',

		'whatsnew_page'		=> 'WhatsNew',
		'changes_page'		=> 'RecentChanges',
		'comments_page'		=> 'RecentlyCommented',
		'index_page'		=> 'PageIndex',

		'random_page'		=> 'RandomPage',
		#'help_page'			=> 'Help',
		#'terms_page'		=> 'Terms',
		#'privacy_page'		=> 'Privacy',
	],

	/*
	 Generic Page Text
	 */
	'TitleInstallation'				=> 'การติดตั้ง WackoWiki',
	'TitleUpdate'					=> 'อัปเดต WackoWiki',
	'Continue'						=> 'ดำเนินการต่อ',
	'Back'							=> 'ย้อนกลับ',
	'Recommended'					=> 'แนะนำ',
	'InvalidAction'					=> 'การดำเนินการไม่ถูกต้อง',

	/*
	 Locking Check
	 */
	'LockAuthorization'				=> 'การอนุญาต',
	'LockAuthorizationInfo'			=> 'โปรดใส่รหัสผ่านที่คุณบันทึกไว้ในไฟล์ %1',
	'LockPassword'					=> 'รหัสผ่าน:',
	'LockLogin'						=> 'เข้าสู่ระบบ',
	'LockPasswordInvalid'			=> 'รหัสผ่านไม่ถูกต้อง',
	'LockedTryLater'				=> 'เว็บไซต์นี้กำลังอยู่ระหว่างการอัปเกรด กรุณาลองใหม่อีกครั้งในภายหลัง',
	'EmptyAuthFile'					=> 'ไฟล์ %1 หายไปหรือว่างเปล่า กรุณาสร้างไฟล์และใส่รหัสผ่านลงในไฟล์นั้น',

	/*
	 Language Selection Page
	 */
	'lang'							=> 'การตั้งค่าภาษา',
	'PleaseUpgradeToR6'				=> 'ดูเหมือนว่าคุณกำลังใช้งาน WackoWiki รุ่นเก่า %1 เพื่ออัปเดตเป็นรุ่นนี้ของ WackoWiki คุณต้องอัปเดตการติดตั้งของคุณเป็น %2 ก่อน',
	'UpgradeFromWacko'				=> 'ยินดีต้อนรับสู่ WackoWiki! ดูเหมือนว่าคุณกำลังอัปเกรดจาก WackoWiki %1 ไปยัง %2 หน้าต่อไปจะนำทางคุณผ่านขั้นตอนการอัปเกรด',
	'FreshInstall'					=> 'ยินดีต้อนรับสู่ WackoWiki! คุณกำลังจะติดตั้ง WackoWiki %1 หน้าต่อไปจะนำทางคุณผ่านขั้นตอนการติดตั้ง',
	'PleaseBackup'					=> 'โปรดสำรองข้อมูล (backup) ฐานข้อมูล ไฟล์ config และไฟล์ที่มีการแก้ไขใดๆ เช่นไฟล์ที่มีการปรับแต่งท้องถิ่นก่อนเริ่มกระบวนการอัปเกรด สิ่งนี้จะช่วยป้องกันปัญหาใหญ่ได้',
	'LangDesc'						=> 'โปรดเลือกภาษาสำหรับกระบวนการติดตั้ง ภาษานี้จะถูกใช้เป็นภาษาตั้งต้นสำหรับการติดตั้ง WackoWiki ของคุณ',

	/*
	 System Requirements Page
	 */
	'version-check'					=> 'ข้อกำหนดของระบบ',
	'PhpVersion'					=> 'รุ่น PHP',
	'PhpDetected'					=> 'ตรวจพบ PHP',
	'ModRewrite'					=> 'ส่วนขยาย Apache Rewrite (ไม่จำเป็น)',
	'ModRewriteInstalled'			=> 'ติดตั้ง Rewrite Extension (mod_rewrite) แล้วหรือไม่?',
	'Database'						=> 'ฐานข้อมูล',
	'PhpExtensions'					=> 'ส่วนขยายของ PHP',
	'Permissions'					=> 'สิทธิ์การเข้าถึง',
	'ReadyToInstall'				=> 'พร้อมติดตั้งหรือไม่?',
	'Requirements'					=> 'เซิร์ฟเวอร์ของคุณต้องตรงตามข้อกำหนดด้านล่าง',
	'OK'							=> 'เรียบร้อย',
	'Problem'						=> 'ปัญหา',
	'Example'						=> 'ตัวอย่าง',
	'NotePhpExtensions'				=> '',
	'ErrorPhpExtensions'			=> 'การติดตั้ง PHP ของคุณดูเหมือนจะขาดส่วนขยายที่ระบุ ซึ่ง WackoWiki จำเป็นต้องใช้',
	'PcreWithoutUtf8'				=> 'PCRE ถูกคอมไพล์โดยไม่รองรับ UTF-8',
	'NotePermissions'				=> 'ตัวติดตั้งจะพยายามเขียนข้อมูลการตั้งค่าไปยังไฟล์ %1 ซึ่งอยู่ในไดเรกทอรี WackoWiki ของคุณ เพื่อให้สิ่งนี้ทำงานได้ คุณต้องแน่ใจว่าเว็บเซิร์ฟเวอร์มีสิทธิ์เขียนไฟล์นั้น หากคุณไม่สามารถทำได้ คุณจะต้องแก้ไขไฟล์ด้วยตนเอง (ตัวติดตั้งจะแจ้งวิธีการให้)<br><br>ดู <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> สำหรับรายละเอียด',
	'ErrorPermissions'				=> 'ดูเหมือนว่าตัวติดตั้งจะไม่สามารถตั้งค่าสิทธิ์ไฟล์ที่จำเป็นให้กับ WackoWiki โดยอัตโนมัติได้ คุณจะถูกขอให้ตั้งค่าสิทธิ์ไฟล์ด้วยตนเองในภายหลังระหว่างขั้นตอนการติดตั้ง',
	'ErrorMinPhpVersion'			=> 'รุ่น PHP ต้องมากกว่า %1 เซิร์ฟเวอร์ของคุณดูเหมือนจะรันรุ่นที่เก่ากว่า คุณต้องอัปเกรดเป็น PHP รุ่นใหม่กว่าเพื่อให้ WackoWiki ทำงานได้อย่างถูกต้อง',
	'Ready'							=> 'ยินดีด้วย ดูเหมือนว่าเซิร์ฟเวอร์ของคุณสามารถรัน WackoWiki ได้ หน้าต่อไปจะนำคุณผ่านกระบวนการตั้งค่า',

	/*
	 Site Config Page
	 */
	'config-site'					=> 'การตั้งค่าไซต์',
	'SiteName'						=> 'ชื่อวิกิ',
	'SiteNameDesc'					=> 'โปรดใส่ชื่อไซต์วิกิของคุณ',
	'SiteNameDefault'				=> 'MyWikiSite',
	'HomePage'						=> 'หน้าแรก',
	'HomePageDesc'					=> 'ใส่ชื่อที่คุณต้องการให้หน้าแรกมี ชื่อนี้จะเป็นหน้าที่ผู้ใช้เห็นเมื่อเข้าชมไซต์ของคุณ โดยควรเป็น <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>',
	'HomePageDefault'				=> 'HomePage',
	'MultiLang'						=> 'โหมดหลายภาษา',
	'MultiLangDesc'					=> 'โหมดหลายภาษาช่วยให้คุณมีหน้าที่มีการตั้งค่าภาษาต่างกันภายในการติดตั้งเดียว เมื่อเปิดใช้งาน ตัวติดตั้งจะสร้างเมนูเริ่มต้นสำหรับทุกภาษาที่มีในดิสทริบิวชัน',
	'AllowedLang'					=> 'ภาษาที่อนุญาต',
	'AllowedLangDesc'				=> 'แนะนำให้เลือกเฉพาะชุดภาษาที่คุณต้องการใช้ มิฉะนั้นจะเลือกทุกภาษาโดยอัตโนมัติ',
	'AclMode'						=> 'การตั้งค่า ACL เริ่มต้น',
	'AclModeDesc'					=> '',
	'PublicWiki'					=> 'วิกิสาธารณะ (อ่านได้ทุกคน เขียนและคอมเมนต์ได้เฉพาะผู้ใช้ที่ลงทะเบียน)',
	'PrivateWiki'					=> 'วิกิส่วนตัว (อ่าน เขียน คอมเมนต์ได้เฉพาะผู้ใช้ที่ลงทะเบียนเท่านั้น)',
	'Admin'							=> 'ชื่อผู้ดูแลระบบ',
	'AdminDesc'						=> 'ใส่ชื่อผู้ใช้ผู้ดูแล ระบบควรเป็น <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (เช่น <code>WikiAdmin</code>)',
	'NameAlphanumOnly'				=> 'ชื่อผู้ใช้ต้องมีความยาวระหว่าง %1 ถึง %2 ตัวอักษรและใช้เฉพาะตัวอักษรและตัวเลขเท่านั้น ตัวอักษรพิมพ์ใหญ่ใช้ได้',
	'NameCamelCaseOnly'				=> 'ชื่อผู้ใช้ต้องมีความยาวระหว่าง %1 ถึง %2 ตัวอักษรและอยู่ในรูปแบบ WikiName',
	'Password'						=> 'รหัสผ่านผู้ดูแล',
	'PasswordDesc'					=> 'เลือกรหัสผ่านสำหรับผู้ดูแลที่มีความยาวอย่างน้อย %1 ตัวอักษร',
	'PasswordConfirm'				=> 'ยืนยันรหัสผ่าน:',
	'Mail'							=> 'อีเมลของผู้ดูแล',
	'MailDesc'						=> 'ใส่ที่อยู่อีเมลของผู้ดูแล',
	'Base'							=> 'URL พื้นฐาน',
	'BaseDesc'						=> 'URL พื้นฐานของไซต์ WackoWiki ของคุณ ชื่อหน้าจะถูกต่อท้ายลงไป ดังนั้นถ้าคุณใช้ mod_rewrite ที่อยู่ควรลงท้ายด้วยเครื่องหมายทับ (/)',
	'Rewrite'						=> 'โหมดเขียนทับ (Rewrite)',
	'RewriteDesc'					=> 'ควรเปิดใช้งานโหมด Rewrite หากคุณใช้ WackoWiki กับการเขียน URL ใหม่',
	'Enabled'						=> 'เปิดใช้งาน:',
	'ErrorAdminEmail'				=> 'คุณใส่อีเมลไม่ถูกต้อง!',
	'ErrorAdminPasswordMismatch'	=> 'รหัสผ่านไม่ตรงกัน!',
	'ErrorAdminPasswordShort'		=> 'รหัสผ่านของผู้ดูแลสั้นเกินไป! ความยาวขั้นต่ำคือ %1 ตัวอักษร',
	'ModRewriteStatusUnknown'		=> 'ตัวติดตั้งไม่สามารถตรวจสอบได้ว่า mod_rewrite ถูกเปิดใช้งานหรือไม่ แต่หมายความว่าอาจจะยังใช้งานได้',

	/*
	 Database Config Page
	 */
	'config-database'				=> 'การตั้งค่าฐานข้อมูล',
	'DbDriver'						=> 'ไดรเวอร์',
	'DbDriverDesc'					=> 'ไดรเวอร์ฐานข้อมูลที่คุณต้องการใช้',
	'DbSqlMode'						=> 'โหมด SQL',
	'DbSqlModeDesc'					=> 'โหมด SQL ที่คุณต้องการใช้',
	'DbVendor'						=> 'ผู้จำหน่าย',
	'DbVendorDesc'					=> 'ผู้ให้บริการฐานข้อมูลที่คุณใช้',
	'DbCharset'						=> 'ชุดอักขระ',
	'DbCharsetDesc'					=> 'ชุดอักขระของฐานข้อมูลที่คุณต้องการใช้',
	'DbEngine'						=> 'เอนจิน',
	'DbEngineDesc'					=> 'เอนจินฐานข้อมูลที่คุณต้องการใช้',
	'DbHost'						=> 'โฮสต์',
	'DbHostDesc'					=> 'โฮสต์ที่เซิร์ฟเวอร์ฐานข้อมูลของคุณรันอยู่ โดยปกติเป็น <code>127.0.0.1</code> หรือ <code>localhost</code> (เช่นเดียวกับเครื่องที่ไซต์ WackoWiki ของคุณอยู่)',
	'DbPort'						=> 'พอร์ต (ไม่บังคับ)',
	'DbPortDesc'					=> 'หมายเลขพอร์ตที่เซิร์ฟเวอร์ฐานข้อมูลเข้าถึงได้ ปล่อยว่างเพื่อใช้พอร์ตเริ่มต้น',
	'DbName'						=> 'ชื่อฐานข้อมูล',
	'DbNameDesc'					=> 'ฐานข้อมูลที่ WackoWiki จะใช้งาน ฐานข้อมูลนี้ต้องมีอยู่แล้วก่อนจะดำเนินการต่อ',
	'DbNameSqliteDesc'				=> 'ไดเรกทอรีข้อมูลและชื่อไฟล์ที่ SQLite จะใช้สำหรับ WackoWiki',
	'DbNameSqliteHelp'				=> 'SQLite เก็บข้อมูลทั้งหมดไว้ในไฟล์เดียว<br><br>ไดเรกทอรีที่คุณระบุต้องสามารถเขียนได้โดยเว็บเซิร์ฟเวอร์ในระหว่างการติดตั้ง<br><br>ไม่ควรให้สามารถเข้าถึงผ่านเว็บได้<br><br>ตัวติดตั้งจะเขียนไฟล์ <code>.htaccess</code ควบคู่ไปด้วย แต่หากล้มเหลว อาจมีคนเข้าถึงฐานข้อมูลดิบของคุณได้<br>ซึ่งรวมถึงข้อมูลผู้ใช้ดิบ (อีเมล รหัสผ่านที่แฮชแล้ว) รวมทั้งหน้าที่ถูกป้องกันและข้อมูลจำกัดอื่นๆ บนวิกิ<br><br>พิจารณาเก็บฐานข้อมูลไว้ที่อื่น เช่น <code>/var/lib/wackowiki/yourwiki</code>',
	'DbUser'						=> 'ชื่อผู้ใช้',
	'DbUserDesc'					=> 'ชื่อผู้ใช้ที่ใช้เชื่อมต่อกับฐานข้อมูลของคุณ',
	'DbPassword'					=> 'รหัสผ่าน',
	'DbPasswordDesc'				=> 'รหัสผ่านของผู้ใช้ที่ใช้เชื่อมต่อกับฐานข้อมูลของคุณ',
	'Prefix'						=> 'คำนำหน้าตาราง',
	'PrefixDesc'					=> 'คำนำหน้าของตารางทั้งหมดที่ใช้โดย WackoWiki วิธีนี้ช่วยให้คุณรันการติดตั้ง WackoWiki หลายชุดในฐานข้อมูลเดียวกันโดยตั้งค่านำหน้าตารางแตกต่างกัน (เช่น wacko_)',
	'ErrorNoDbDriverDetected'		=> 'ไม่พบไดรเวอร์ฐานข้อมูล กรุณาเปิดใช้งานส่วนขยาย mysqli หรือ pdo_mysql ในไฟล์ php.ini ของคุณ',
	'ErrorNoDbDriverSelected'		=> 'ยังไม่ได้เลือกไดรเวอร์ฐานข้อมูล กรุณาเลือกจากรายการ',
	'DeleteTables'					=> 'ลบตารางที่มีอยู่แล้ว?',
	'DeleteTablesDesc'				=> 'คำเตือน! หากคุณดำเนินการต่อพร้อมเลือกตัวเลือกนี้ ข้อมูลวิกิปัจจุบันทั้งหมดจะถูกลบจากฐานข้อมูลของคุณ การกระทำนี้ไม่สามารถย้อนกลับได้ และคุณจะต้องกู้คืนข้อมูลด้วยตนเองจากการสำรองข้อมูล',
	'ConfirmTableDeletion'			=> 'คุณแน่ใจหรือไม่ว่าต้องการลบตารางวิกิทั้งหมดในปัจจุบัน?',

	/*
	 Database Installation Page
	 */
	'install-database'				=> 'การติดตั้งฐานข้อมูล',
	'TestingConfiguration'			=> 'กำลังทดสอบการตั้งค่า',
	'TestConnectionString'			=> 'กำลังทดสอบการตั้งค่าการเชื่อมต่อฐานข้อมูล',
	'TestDatabaseExists'			=> 'กำลังตรวจสอบว่าฐานข้อมูลที่คุณระบุมีอยู่หรือไม่',
	'TestDatabaseVersion'			=> 'กำลังตรวจสอบความต้องการรุ่นขั้นต่ำของฐานข้อมูล',
	'SqliteFileExtensionError'		=> 'โปรดใช้หนึ่งในนามสกุลไฟล์ต่อไปนี้ db, sdb, sqlite',
	'SqliteParentUnwritableGroup'	=> 'ไม่สามารถสร้างไดเรกทอรีข้อมูล <code>%1</code> ได้ เนื่องจากไดเรกทอรีแม่ <code>%2</code> ไม่สามารถเขียนได้โดยเว็บเซิร์ฟเวอร์<br><br>ตัวติดตั้งได้ตรวจสอบผู้ใช้ที่เว็บเซิร์ฟเวอร์รันอยู่แล้ว<br>ทำให้ไดเรกทอรี <code>%3</code> สามารถเขียนได้โดยกลุ่มนั้นเพื่อต่อไป<br>บนระบบ Unix/Linux ให้ทำ:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
	'SqliteParentUnwritableNogroup'	=> 'ไม่สามารถสร้างไดเรกทอรีข้อมูล <code>%1</code> ได้ เนื่องจากไดเรกทอรีแม่ <code>%2</code> ไม่สามารถเขียนได้โดยเว็บเซิร์ฟเวอร์<br><br>ตัวติดตั้งไม่สามารถระบุกลุ่มผู้ใช้ที่เว็บเซิร์ฟเวอร์รันอยู่ได้<br>ทำให้ไดเรกทอรี <code>%3</code> เป็นไดเรกทอรีที่ทุกคนเขียนได้เพื่อต่อไป<br>บนระบบ Unix/Linux ให้ทำ:<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
	'SqliteMkdirError'				=> 'เกิดข้อผิดพลาดในการสร้างไดเรกทอรีข้อมูล <code>%1</code> ตรวจสอบตำแหน่งและลองอีกครั้ง',
	'SqliteDirUnwritable'			=> 'ไม่สามารถเขียนไปยังไดเรกทอรี <code>%1</code> ได้ เปลี่ยนสิทธิ์ของมันให้เว็บเซิร์ฟเวอร์สามารถเขียนและลองอีกครั้ง',
	'SqliteReadonly'				=> 'ไฟล์ <code>%1</code> ไม่สามารถเขียนได้',
	'SqliteCantCreateDb'			=> 'ไม่สามารถสร้างไฟล์ฐานข้อมูล <code>%1</code> ได้',
	'InstallTables'					=> 'กำลังติดตั้งตาราง',
	'ErrorDbConnection'				=> 'มีปัญหากับรายละเอียดการเชื่อมต่อฐานข้อมูลที่คุณระบุ กรุณากลับไปและตรวจสอบให้ถูกต้อง',
	'ErrorDatabaseVersion'			=> 'รุ่นฐานข้อมูลคือ %1 แต่ต้องการอย่างน้อย %2',
	'To'							=> 'เป็น',
	'AlterTable'					=> 'กำลังแก้ไขตาราง %1',
	'InsertRecord'					=> 'กำลังแทรกระเบียนลงในตาราง %1',
	'RenameTable'					=> 'กำลังเปลี่ยนชื่อโต๊ะ %1',
	'UpdateTable'					=> 'กำลังอัปเดตตาราง %1',
	'InstallDefaultData'			=> 'กำลังเพิ่มข้อมูลเริ่มต้น',
	'InstallPagesBegin'				=> 'กำลังเพิ่มหน้ามาตรฐาน',
	'InstallPagesEnd'				=> 'เสร็จสิ้นการเพิ่มหน้ามาตรฐาน',
	'InstallSystemAccount'			=> 'กำลังเพิ่มผู้ใช้ <code>System</code>',
	'InstallDeletedAccount'			=> 'กำลังเพิ่มผู้ใช้ <code>Deleted</code>',
	'InstallAdmin'					=> 'กำลังเพิ่มผู้ดูแลระบบ',
	'InstallAdminSetting'			=> 'กำลังเพิ่มการตั้งค่าของผู้ดูแล',
	'InstallAdminGroup'				=> 'กำลังเพิ่มกลุ่มผู้ดูแล',
	'InstallAdminGroupMember'		=> 'กำลังเพิ่มสมาชิกกลุ่มผู้ดูแล',
	'InstallEverybodyGroup'			=> 'กำลังเพิ่มกลุ่ม Everybody',
	'InstallModeratorGroup'			=> 'กำลังเพิ่มกลุ่มผู้ควบคุม',
	'InstallReviewerGroup'			=> 'กำลังเพิ่มกลุ่มผู้ตรวจสอบ',
	'InstallLogoImage'				=> 'กำลังเพิ่มรูปโลโก้',
	'LogoImage'						=> 'รูปโลโก้',
	'InstallConfigValues'			=> 'กำลังเพิ่มค่าการตั้งค่า',
	'ConfigValues'					=> 'ค่าการตั้งค่า',
	'ErrorInsertPage'				=> 'เกิดข้อผิดพลาดในการแทรกหน้ %1',
	'ErrorInsertPagePermission'		=> 'เกิดข้อผิดพลาดในการตั้งค่าสิทธิ์สำหรับหน้ %1',
	'ErrorInsertDefaultMenuItem'	=> 'เกิดข้อผิดพลาดในการตั้งค่าหน้า %1 เป็นรายการเมนูเริ่มต้น',
	'ErrorPageAlreadyExists'		=> 'หน้ %1 มีอยู่แล้ว',
	'ErrorAlterTable'				=> 'เกิดข้อผิดพลาดในการแก้ไขตาราง %1',
	'ErrorInsertRecord'				=> 'เกิดข้อผิดพลาดในการแทรกระเบียนลงในตาราง %1',
	'ErrorRenameTable'				=> 'เกิดข้อผิดพลาดในการเปลี่ยนชื่อตาราง %1',
	'ErrorUpdatingTable'			=> 'เกิดข้อผิดพลาดในการอัปเดตตาราง %1',
	'CreatingTable'					=> 'กำลังสร้างตาราง %1',
	'CreatingIndex'					=> 'กำลังสร้างดัชนี %1',
	'CreatingTrigger'				=> 'กำลังสร้างทริกเกอร์ %1',
	'ErrorAlreadyExists'			=> '%1 มีอยู่แล้ว',
	'ErrorCreatingTable'			=> 'เกิดข้อผิดพลาดในการสร้างตาราง %1 อาจมีอยู่แล้ว?',
	'ErrorCreatingIndex'			=> 'เกิดข้อผิดพลาดในการสร้างดัชนี %1 อาจมีอยู่แล้ว?',
	'ErrorCreatingTrigger'			=> 'เกิดข้อผิดพลาดในการสร้างทริกเกอร์ %1 อาจมีอยู่แล้ว?',
	'DeletingTables'				=> 'กำลังลบตาราง',
	'DeletingTablesEnd'				=> 'เสร็จสิ้นการลบตาราง',
	'ErrorDeletingTable'			=> 'เกิดข้อผิดพลาดในการลบตาราง %1 สาเหตุที่เป็นไปได้ที่สุดคือ ตารางนั้นไม่มีอยู่ ซึ่งคุณสามารถละเว้นคำเตือนนี้ได้',
	'DeletingTable'					=> 'กำลังลบตาราง %1',
	'NextStep'						=> 'ในขั้นตอนต่อไป ตัวติดตั้งจะพยายามเขียนไฟล์การตั้งค่า %1 โปรดแน่ใจว่าเว็บเซิร์ฟเวอร์มีสิทธิ์เขียนไฟล์ มิฉะนั้นคุณจะต้องแก้ไขด้วยตนเอง อีกครั้งดู <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> สำหรับรายละเอียด',

	/*
	 Write Config Page
	 */
	'write-config'					=> 'เขียนไฟล์การตั้งค่า',
	'FinalStep'						=> 'ขั้นตอนสุดท้าย',
	'Writing'						=> 'กำลังเขียนไฟล์การตั้งค่า',
	'RemovingWritePrivilege'		=> 'กำลังเอาสิทธิ์การเขียนออก',
	'InstallationComplete'			=> 'การติดตั้งเสร็จสมบูรณ์',
	'ThatsAll'						=> 'เสร็จเรียบร้อย! คุณสามารถ <a href="%1">ดูไซต์ WackoWiki ของคุณ</a> ได้แล้ว',
	'SecurityConsiderations'		=> 'ข้อควรพิจารณาด้านความปลอดภัย',
	'SecurityRisk'					=> 'แนะนำให้คุณเอาสิทธิ์การเขียนออกจาก %1 ตอนนี้หลังจากที่เขียนแล้ว การปล่อยให้ไฟล์เขียนได้อาจเป็นความเสี่ยงด้านความปลอดภัย!<br>เช่น %2',
	'RemoveSetupDirectory'			=> 'คุณควรลบไดเรกทอรี %1 ตอนนี้หลังจากกระบวนการติดตั้งเสร็จสิ้น',
	'ErrorGivePrivileges'			=> 'ไม่สามารถเขียนไฟล์การตั้งค่า %1 ได้ คุณจะต้องให้เว็บเซิร์ฟเวอร์มีสิทธิ์เขียนชั่วคราวกับไดเรกทอรี WackoWiki หรือตั้งไฟล์ว่างชื่อ %1<br>%2.<br><br>อย่าลืมเอาสิทธิ์การเขียนออกอีกครั้งภายหลัง เช่น<br>%3.<br><br>',
	'ErrorPrivilegesInstall'		=> 'หากด้วยเหตุผลใดไม่สามารถทำเช่นนั้นได้ คุณจะต้องคัดลอกข้อความด้านล่างไปยังไฟล์ใหม่แล้วบันทึก/อัปโหลดเป็น %1 ลงในไดเรกทอรี WackoWiki เมื่อทำแล้ว ไซต์ WackoWiki ของคุณควรทำงาน หากไม่ กรุณาเยี่ยมชม <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
	'ErrorPrivilegesUpgrade'		=> 'เมื่อคุณทำเช่นนั้นแล้ว ไซต์ WackoWiki ของคุณควรทำงาน หากไม่ กรุณาเยี่ยมชม <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
	'WrittenAt'						=> 'เขียนที่ ',
	'DontChange'					=> 'อย่าเปลี่ยน wacko_version ด้วยตนเอง!',
	'ConfigDescription'				=> 'คำอธิบายโดยละเอียด: https://wackowiki.org/doc/Doc/English/Configuration',
	'TryAgain'						=> 'ลองอีกครั้ง',

];
