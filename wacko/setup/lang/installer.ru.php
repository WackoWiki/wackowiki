<?php
$lang = array(

/*
   Language Settings
*/
"Charset" => "windows-1251",
"LangISO" => "ru",
"LangName" => "�������",

/*
   Generic Page Text
*/
"Title" => "��������� WackoWiki",
"Continue" => "����������",
"Back" => "�����",

/*
   Language Selection Page
*/
"UpgradeFromWacko" => "Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <tt>%1</tt> to <tt>%2</tt>.  The next few pages will guide you through the upgrade process.",
"FreshInstall" => "Welcome to WackoWiki, you are about to install WackoWiki <tt>%1</tt>.  The next few pages will guide you through the installation process.",
"PleaseBackup" => "C������� ��������� ����� ���� ������, ����������������� ����� � ������ ��������� ���� ������ (��������, ������ ����) �� ������ �������� ���������. ��� ����� ������ ��� �� ����� ���������� ��������.",
"Lang" => "��������� �����",
"LangDesc" => "����������, �������� ����. �� ����� �������������� � �������� ���������, � ����� ������ ������ �� ��������� ������������� WackoWiki.",

/*
   System Requirements Page
*/
"version-check" => "��������� ����������",
"PHPVersion" => "������ PHP",
"PHPDetected" => "��������� PHP",
"ModRewrite" => "���������� Apache Rewrite (�������������)",
"ModRewriteInstalled" => "������ ���������� (mod_rewrite) ����������?",
"Database" => "���� ������",
"Permissions" => "����� �������",
"ReadyToInstall" => "������ � ���������?",
"Requirements" => "��� ������ ������ �������������� �����������, ������������� ����.",
"OK" => "OK",
"Problem" => "��������",
"NotePermissions" => "��������� ��������� ���������� �������� ��������� � ���� <tt>config.inc.php</tt>, ������������ � �������� WackoWiki. ����� �� ������ �������, ���������, ��� ���-������ ����� ����� �� ������ � ������ ����. ���� ��� ����������, ��� ������� �������� ���� ������� (��������� ��������� ��������, ���).<br /><br />��. <a href=\"http://wackowiki.org/Doc/English/Installation\" target=\"_blank\">WackoWiki:DocEnglish/Installation</a>.",
"ErrorPermissions" => "��� ����� ����������, ����� ��������� ��������� �� ����� ������������� ������ �����, ��������� ��� ���������� ������ WackoWiki. ����� �� ����� ��������� ��� ����� ���������� ��������� ������� ��������� ����� ������� � ������ �� �������.",
"ErrorMinPHPVersion" => "������ PHP ������ ���� ������ <strong>5.1.0</strong>, � ������ ���������� ���� �� ���������� ������.  ��� ���������� ������ WackoWiki ����� �������� PHP �� ���� �� ��������� ������.",
"Ready" => "�����������, ��� ������ ����� ��� ������� WackoWiki. ������� � ��������� ����� ��������� ��������� �������.",

/*
   Site Config Page
*/
"site-config" => "��������� �����",
"Name" => "�������� WackoWiki",
"NameDesc" => "����������, ������� ��� ������ ����� WackoWiki, ��� ������ ���� <a href=\"http://wackowiki.org/Doc/English/WikiName\" title=\"View Help\" target=\"_blank\">����������</a>.",
"Home" => "������� ��������",
"HomeDesc" => "������� ��� �������� ��������;&nbsp;&mdash;&nbsp;��� ����� �������� �� ���������, � ������������ ������ ������ ��� ��������� �����; ��� ������ <a href=\"http://wackowiki.org/Doc/English/WikiName\" title=\"View Help\" target=\"_blank\">����������</a>.",
"HomeDefault" => "HomePage",
"MultiLang" => "����� ��������������",
"MultiLangDesc" => "����� ��������������, ����������� �������� �� ���������� �� ������ ������. ���� ����� �������, �� ��������� ��������� ������� ��������� ����� ������� ��� ���� ��������� �� ������.",
"Admin" => "Admin Name",
"AdminDesc" => "�������� ��� ��������������. ������ ������������ ����� ������� (��� ������� ����) <a href=\"http://wackowiki.org/Doc/English/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a> (e.g. WikiAdmin).",
"Password" => "������ ��������������",
"PasswordDesc" => "�������� ������ (�� ����� ���� ��������).",
"Password2" => "������������� ������:",
"Mail" => "����� ����������� ����� ��������������",
"MailDesc" => "������� ����� ����������� ����� ��������������.",
"Base" => "������� URL",
"BaseDesc" => "������� URL ����� WackoWiki. � ���� ����� ����������� ����� �������; ���� ������������ mod_rewrite, ����� ������ ������������ ������ ����� ������, �. �.</p><ul><li><b><i>http://www.wackowiki.org/</i></b></li><li><b><i>http://www.wackowiki.org/wiki/</i></b></li></ul><p class=\"no_top\">���� ������������� mod_rewrite �� �����������, URL ������ ������������ \"?page=\" �. �.<ul><li><b><i>http://www.wackowiki.org/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/wiki/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/?page=</i></b></li></ul>",
"Rewrite" => "Rewrite-�����",
"RewriteDesc" => "Rewrite-����� ������ ���� �������, ���� �� ����������� mod_rewrite.",
"Enabled" => "�������:",
"ErrorAdminName" => "����� ������ ���������� ������� � �������� ����� ��������������!",
"ErrorAdminEmail" => "������� ������ ����� ����������� �����!",
"ErrorAdminPasswordMismatch" => "������ �� ���������. ����������, ��������� ���� ������ ��������������",
"ErrorAdminPasswordShort" => "������ �������������� ������� ��������, ����������� �����&nbsp;&mdash;&nbsp;5 ��������!",
"WarningRewriteMode" => "��������!\n��������� �������� URL � Rewrite-������ �������� �������������. ������ ��� ���������� Rewrite �� ������ ����� ? � ������� URL, �� � ��� �� ����.\n\n��� ����������� ����������� � �������� ����������� ������� ��.\n��� ����, ����� ��������� � ����� � �� ���������, ������� ������.\n\n���� �� ������ ���� ������, �������, ��� ����� ��������� ����� �������� �������� ������������������� ����� �����������.",
"ModRewriteStatusUnknown" => "��������� ��������� �� ����� ���������, ������� �� mod_rewrite, �� ��� �� ��������, ��� �� ��������",

/*
   Database Config Page
*/
"database-config" => "��������� ��",
"DBDriverDesc" => "������� ���� ������, ������� �� ������ ������������. ����� ������� legacy-�������, ���� �� ������������ PHP 5.1 (��� ������) � ������������� <a href=\"http://de2.php.net/pdo\" target=\"_blank\">PDO</a>.",
"DBDriver" => "�������",
"DBHost" => "��� �������",
"DBHostDesc" => "��� �������, �� ������� �������� ��. ������ \"localhost\" (�. �. �� ������, �� ������� ��������������� WackoWiki).",
"DBPort" => "���� (�������������)",
"DBPortDesc" => "����� �����, �� �������� �������� ������ ��, ��� ������������� ����� �� ��������� �������� ������.",
"DB" => "��� ���� ������",
"DBDesc" => "���� ������, ������� ����� ������������ WackoWiki. ��� ������ ������������, ����� ��������� ������������!",
"DBUserDesc" => "��� ������������ ��� ����������� � ���� ������.",
"DBUser" => "��� ������������",
"DBPasswordDesc" => "������ ������������ ��� ����������� � ���� ������.",
"DBPassword" => "������",
"PrefixDesc" => "������� ���� ������, ������������ WackoWiki. ��� �������� ��������� ��������� WackoWiki, ��������� ���� ��&nbsp;&mdash;&nbsp;���������� ������� ��� ��� ������ �������� ������ (e.g. wacko_).",
"Prefix" => "������� ������",
"ErrorNoDbDriverDetected" => "�������� ��� ������ �� ����������. ����������, �������� ������������� ���������� mysql, mysqli ��� pdo � ����� php.ini.",
"ErrorNoDbDriverSelected" => "�� ������ ������� ���� ������, �������� ���� �� ������.",
"DeleteTables" => "Delete Existing Tables?",
"DeleteTablesDesc" => "ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.",
"ConfirmTableDeletion" => "Are you sure you want to delete all current wiki tables?",

/*
   Database Installation Page
*/
"database-install" => "��������� ���� ������",
"TestingConfiguration" => "������������ ��������",
"TestConnectionString" => "�������� ���������� ���������� � ��",
"TestDatabaseExists" => "�������� ������������� ��������� ��",
"InstallingTables" => "��������� ������",
"ErrorDBConnection" => "��������� ������ ��� ����������� � �� � ���������� �����������. ����������, ��������� � ��������� �� ������������.",
"ErrorDBExists" => "��������� �� �� ����������. ����������, ��������������, ��� ����� �� ����������!",
"To" => "->",
"AlterTable" => "��������� ��������� ������� <tt>%1</tt>",
"UpdateTable" => "Updating <tt>%1</tt> Table",
"InstallingDefaultData" => "���������� ������ �� ���������",
"InstallingPagesBegin" => "���������� ������� �� ���������",
"InstallingPagesEnd" => "���������� ������� �� ��������� ���������",
"InstallingAdmin" => "���������� ������������-��������������",
"InstallingLogoImage" => "���������� �������� ��������",
"InstallingConfigValues" => "Adding Config Values",
"ErrorInsertingPage" => "������ ������� �������� <tt>%1</tt>",
"ErrorInsertingPageReadPermission" => "������ ��������� ���� �� ������ �������� <tt>%1</tt>",
"ErrorInsertingPageWritePermission" => "������ ��������� ���� �� ������ �������� <tt>%1</tt>",
"ErrorInsertingPageCommentPermission" => "������ ��������� ���� �� ��������������� �������� <tt>%1</tt>",
"ErrorPageAlreadyExists" => "�������� <tt>%1</tt> ��� ����������",
"ErrorAlteringTable" => "������ ��������� ��������� ������� <tt>%1</tt>",
"ErrorUpdatingTable" => "Error updating <tt>%1</tt> table",
"CreatingTable" => "�������� ������� <tt>%1</tt>",
"ErrorAlreadyExists" => "<tt>%1</tt> ��� ����������",
"ErrorCreatingTable" => "������ �������� ������� <tt>%1</tt>, ��� ��� ����������?",
"ErrorMovingRevisions" => "������ ����������� ������ ������",
"MovingRevisions" => "����������� ��� ������ ������ � ������� revisions",
"DeletingTables" => "Deleting Tables",
"DeletingTablesEnd" => "Finished Deleting Tables",
"ErrorDeletingTable" => "Error deleting <tt>%1</tt> table, the most likely reason is that the table does not exist in which case you can ignore this warning.",
"DeletingTable" => "Deleting <tt>%1</tt> table",

/*
   Write Config Page
*/
"write-config" => "���������� ����������������� �����",
"FinalStep" => "Final Step",
"Writing" => "���������� ����������������� �����",
"RemovingWritePrivilege" => "�������� ���������� �� ������",
"InstallationComplete" => "Installation Complete",
"ThatsAll" => "���! �� ������ �������. ������ �� ������ <a href=\"%1\">���������� ���� ���� WackoWiki</a>.",
"SecurityConsiderations" => "����������� ������������",
"SecurityRisk" => "�� �������� ������ ����� �� ��������� ����� <tt>config.inc.php</tt> ���-��������. ���� ����� �� �������, ��� ������ ��������!",
"RemoveSetupDirectory" => "������ �� ������ ������� ������� \"setup\";&nbsp;&mdash;&nbsp;������� ��������� ��������.",
"ErrorGivePrivileges" => "���������������� ���� <tt>%1</tt> �� ����� ���� �������. ����� �������� ���� ���-������� ����� �� ������ ���� �� ������� WackoWiki, ���� �� ������ ���� <tt>config.inc.php</tt> (<tt>touch config.inc.php ; chmod 666 config.inc.php</tt>; �� �������� ������ ��� ����� ����� ���������, �. e. <tt>chmod 644 config.inc.php</tt>). ����, ������-���� �� �� ������ ��������� ����� �����, ������� ����������� �����, ������������� ���� � ����� ���� � ��������� ��� �� ������ ��� ������ <tt>config.inc.php</tt> � ������� WackoWiki. ����� ����� ��� ���� ������ ����������. ���� ���, �������� <a href=\"http://wackowiki.org/Doc/English/Installation\">WackoWiki:DocEnglish/Installation</a>",
"NextStep" => "�� ��������� ���� ��������� ��������� ��������� ��������� ���������� ���������������� ����, <tt>config.inc.php</tt>. ����������, ���������, ��� ���-������ ����� ���������� ���� ��� ��������� �����; � ��������� ������ ��� ������� ��������� ��������� �������. �� �������� �����������, ��. <a href=\"http://wackowiki.org/Doc/English/Installation\" target=\"_blank\">WackoWiki:DocEnglish/Installation</a>.",
"WrittenAt" => "������� ",
"DontChange" => "�� ������� wacko_version �������!",
"ConfigDescription" => "detailed description http://wackowiki.org/Doc/Russian/FajjlKonfiguracii",
"TryAgain" => "���������� �����",
"RemoveWakkaConfigFile" => "WackoWiki uses a newer config file than your previous WakkaWiki installation.  The old file could not be automatically removed by the system and so it is recommended that you manually delete the file <tt>wakka.config.php</tt>.",
"DeletingWakkaConfigFile" => "Deleting Obsolete Wakka Configuration File",

);
?>