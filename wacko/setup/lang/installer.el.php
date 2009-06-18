<?php
$lang = array(

/*
   Language Settings
*/
"Charset" => "iso-8859-7",
"LangISO" => "el",
"LangName" => "Greek",

/*
   Generic Page Text
*/
"Title" => "����������� WackoWiki",
"Continue" => "��������",
"Back" => "���������",

/*
   Language Selection Page
*/
"UpgradeFromWacko" => "Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <tt>%1</tt> to <tt>%2</tt>.  The next few pages will guide you through the upgrade process.",
"UpgradeFromWakka" => "Welcome to WackoWiki, it appears that you are upgrading from WakkaWiki <tt>%1</tt> to <tt>%2</tt>.  The next few pages will guide you through the upgrade process.",
"FreshInstall" => "Welcome to WackoWiki, you are about to install WackoWiki <tt>%1</tt>.  The next few pages will guide you through the installation process.",
"PleaseBackup" => "��������, ����� ��������� ��� �����, ��� ������� ��������� ��� ��� �� ������������� ������ ���� ���� ��� ����� ������� �� ������ ��� ��������� ����������� ���� ��� �������� ��� ����������� �����������. ���� �� ��� ��������� ��� ���� ������ ����������.",
"Lang" => "��������� �������",
"LangDesc" => "�������� �������� ��� ������ ��� ��� ���������� ������������. � ������ ���� �� �������������� ������ ��� �� �������������� ������ ��� ��� ����������� ��� WackoWiki.",

/*
   System Requirements Page
*/
"version-check" => "���������� ����������",
"PHPVersion" => "������ PHP",
"PHPDetected" => "����������� PHP",
"ModRewrite" => "Apache Rewrite Extension (�����������)",
"ModRewriteInstalled" => "������������� Rewrite Extension (mod_rewrite);",
"Database" => "���� ���������",
"Permissions" => "����������",
"ReadyToInstall" => "������� ��� �����������;",
"Requirements" => "� ����������� ������ �� ���� ��� �������� �� ����� ����������.",
"OK" => "OK",
"Problem" => "��������",
"NotePermissions" => "�� ��������� ������������ �� ������������ �� ������ �������� ��������� ��� ������ <tt>config.inc.php</tt>, �� ����� �������� ���� �������� ��� WackoWiki. ��� �� �������� ����, ������ �� ����������� ��� � web server ��� ������ �� ������ �� ���� �� ������. ��� ��� ������ �� �� ����� ����, �� ������ �� �� �������������� �� �� ���� (�� ��������� ������������ �� ��� ��� ���).<br /><br />����� <a href=\"http://wackowiki.org/Doc/English/Installation\" target=\"_blank\">WackoWiki:Doc/English/Installation</a> ��� ������������.",
"ErrorPermissions" => "���� �������� �� ��������� ������������ ��� ������ �������� �� ����� ��� ���������� ��� ���������� ������� ��� �� WackoWiki �� �������� �����. �� ���������� �������� ���� ��� ���������� ������������ �� ������������� �� �� ���� ��� ���������� ��� ���������� ��� ������� ���� ���������� ���.",
"ErrorMinPHPVersion" => "� ������ ��� PHP ������ �� ����� ���������� ��� <strong>4.3.3</strong>, � ����������� ��� �������� �� ������ �� ����������� ������. ������ �� ������������ �� ��� ��� �������� PHP ������ ��� �������� ����� �� WackoWiki.",
"Ready" => "������������, ������������� ��� � ����������� ��� ������ �� ������ �� WackoWiki.
�� �������� ������� �� ��� ����������� ���� ���������� ����������������.",

/*
   Site Config Page
*/
"site-config" => "��������������� Site",
"Name" => "����� ��� WackoWiki",
"NameDesc" => "�������� ��������� ��� ����� ��� �� WackoWiki site ���, ���� ������ �� ����� 
��� ������ <a href=\"http://wackowiki.org/Doc/English/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"Home" => "������ ������",
"HomeDesc" => "�������������� �� ����� ��� ������ �� ���� � ������ ������ ���, ���� �� ����� � �������������� ������ ��� �� ������� �� ������� ���� ������������� �� site ��� ��� �� ������ �� ����� ��� <a href=\"http://wackowiki.org/Doc/English/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"HomeDefault" => "HomePage",
"MultiLang" => "������������ ����������",
"MultiLangDesc" => "� ������������ ���������� ��� ��������� �� ����� ������� �� ������������ ��������� ��������� ���� �� ��� ���� �����������. ��� ���� � ������� ����� ��������������, ���� �� ��������� ������������ �� ������������ ������� ������� ��� ���� ��� ���������� ������� ���� �������.",
"Admin" => "����� �����������",
"AdminDesc" => "��������� �� ����� ��� �����������, ���� ������ �� ����� ��� <a href=\"http://wackowiki.org/Doc/English/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"Password" => "����������� �����������",
"PasswordDesc" => "������� ��� ����������� ��� ��� ����������� �� ����������� 5 ����������.",
"Password2" => "��������� �� �����������:",
"Mail" => "����������� ��������� �����������",
"MailDesc" => "�������� ��� ����������� ��������� ��� �����������.",
"Base" => "������ URL",
"BaseDesc" => "�� ������ URL ��� WackoWiki sites ���. �� ������� ��� ������� �� ���������� ��� ����, ���� ���� �� �������������� �� mod_rewrite � ��������� �� ��������� �� ��� ������ �.�.</p><ul><li><b><i>http://www.wackowiki.org/</i></b></li><li><b><i>http://www.wackowiki.org/wiki/</i></b></li></ul><p class=\"no_top\"> ��� ��� �� ��������������� �� mod_rewrite ���� �� URL �� ���������� �� �� \"?page=\" �.�.<ul><li><b><i>http://www.wackowiki.org/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/wiki/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/?page=</i></b></li></ul>",
"Rewrite" => "��������� ������������",
"RewriteDesc" => "� ��������� ������������ �� ������������� ��� ��������������� �� WackoWiki �� ��� ����������� URL.",
"Enabled" => "������������:",
"ErrorAdminName" => "�� ����� ��� ����������� ������ �� ����� ��� WikiName!",
"ErrorAdminEmail" => "��� ����� ������� ��� ������ ����������� ���������!",
"ErrorAdminPasswordMismatch" => "�� ����������� ��� ����������!.",
"ErrorAdminPasswordShort" => "�� ����������� ��� ����������� ����� ���� �����, �� �������� ����� ����� 5 ����������!",
"WarningRewriteMode" => "�������!\n�� ������ ��� URL ��� � ������� ��� ���������� ������������ ��������� ������. ������� ��� ������� ������ ? ��� ������ URL ���� � ��������� ������������ ���� ����� - ���� ���� ��������� ��� �������.\n\n��� �� ���������� �� ����� ��� ��������� ������� �� OK.\n��� �� ����������� ���� ����� ��� �� �������� ��� ��������� ��� ������� �� CANCEL(�������).\n\n�� ����� ������� �� ����������� �� ����� ��� ���������, �������� �� ��������� ��� ������ �� ������������� ���������� �� ��� ����������� ��� WackoWiki.",
"ModRewriteStatusUnknown" => "�� ��������� ������������ ��� ������ �� ������������ ��� �� mod_rewrite ����� ��������������, ������ ���� ���� ��� �������� ��� ����� ����������������",

/*
   Database Config Page
*/
"database-config" => "��������� �����",
"DBDriverDesc" => "
� ������ ��� ����� ��� ������ �� ���������������. �� ������ �� ����� ���� ������������ ������ ��� ��� ����� PHP5.1 (� ����������) ��� ������������� <a href=\"http://gr.php.net/pdo\" target=\"_blank\">PDO</a>.",
"DBDriver" => "������",
"DBHost" => "�����������",
"DBHostDesc" => "�� ����� ��� ���������� ������ ��������� ��� ������ �� ����. ������� ����� \"localhost\" (�.�., �� ���� ����� ��� ����� �� WackoWiki site ���).",
"DBPort" => "����� (�����������)",
"DBPortDesc" => "� ������� ��� ������ ��� ���������� ������ ��������� ��� �� ����� ����������� �� ����, ������ �� ���� ��� ��������������
��� �������������� ������ ������.",
"DB" => "�� ����� ��� �����",
"DBDesc" => "� ���� ��������� ��� �� �������������� �� WackoWiki. ���� � ���� ������ �� ������� ��� ��� �� ������������!",
"DBUserDesc" => "�� ����� ��� �� ����������� ��� ������ ��� ��������������� ��� �� ��������� ���� ���� ���.",
"DBUser" => "����� ������",
"DBPasswordDesc" => "�� ����� ��� �� ����������� ��� ������ ��� ��������������� ��� �� ��������� ���� ���� ���.",
"DBPassword" => "�����������",
"PrefixDesc" => "������� ���� ��� ������� ��� ���������������� ��� �� WackoWiki. ���� ��� ��������� �� ������� ��������� ������������� ��� WackoWiki ��������������� ��� ���� ���� ��������� ����������� ����������� ��������� ����� �������.",
"Prefix" => "������� ������",
"ErrorNoDbDriverDetected" => "��� ����������� ������ ������ ���������, �������� ���� ������������� ��� �� ��� ���������� mysql, mysqli � pdo ��� php.ini ������ ���.",
"ErrorNoDbDriverSelected" => "��� ����������� ������ ������ ���������, �������� �������� ���� ��� ��� �����.",
"DeleteTables" => "Delete Existing Tables?",
"DeleteTablesDesc" => "ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.",
"ConfirmTableDeletion" => "Are you sure you want to delete all current wiki tables?",

/*
   Database Installation Page
*/
"database-install" => "����������� �����",
"TestingConfiguration" => "������� ���������",
"TestConnectionString" => "������� ��������� �������� �� ��� ���� ���������",
"TestDatabaseExists" => "������ ��� � ���� ��������� ��� �������� �������",
"InstallingTables" => "����������� �������",
"ErrorDBConnection" => "������ ��� �������� �� ��� ������������ ��� ������ ��� ��� ������� �� ��� ���� ���������, �������� ���������� ��� �������� ��� ����� �����.",
"ErrorDBExists" => "� ���� ��������� ��� ����� �������� ��� �������. ���������, ���������� �� ������� ���� ��� ��� �����������/���������� ��� WackoWiki!",
"To" => "���",
"AlterTable" => "������ ��� <tt>%1</tt> ������",
"UpdateTable" => "Updating <tt>%1</tt> Table",
"AlterUsersTable" => "������ ������ �������",
"InstallingDefaultData" => "�������� ��������������� ���������",
"InstallingPagesBegin" => "�������� ��������������� �������",
"InstallingPagesEnd" => "���������� ��������� ��������������� �������",
"InstallingAdmin" => "�������� ����� �����������",
"InstallingLogoImage" => "�������� ������� ��������",
"ErrorInsertingPage" => "������ ���� ��� �������� ��� <tt>%1</tt> �������",
"ErrorInsertingPageReadPermission" => "������ �������� ����������� ��������� ��� ��� <tt>%1</tt> ������",
"ErrorInsertingPageWritePermission" => "������ �������� ����������� �������� ��� ��� <tt>%1</tt> ������",
"ErrorInsertingPageCommentPermission" => "������ �������� ����������� ������� ��� ��� <tt>%1</tt> ������",
"ErrorPageAlreadyExists" => "� <tt>%1</tt> ������ ��� �������",
"ErrorAlteringTable" => "������ ������� <tt>%1</tt> ������",
"ErrorUpdatingTable" => "Error updating <tt>%1</tt> table",
"CreatingTable" => "���������� ������: <tt>%1</tt>",
"ErrorAlreadyExists" => "� <tt>%1</tt> ������� ���",
"ErrorCreatingTable" => "������ ���� ��� ���������� ��� ������: <tt>%1</tt>, ��� ������� ���;",
"ErrorMovingRevisions" => "������ ����������� ��������� �������",
"MovingRevisions" => "���������� ��������� �� ������ �������",
"CleanupScript" => "�� �� ��������������� �� <a href=\"http://wackowiki.org/Doc/English/CleanupScript\" target=\"_blank\">WackoWiki:Doc/English/CleanupScript</a>, �� ����������� �� Wacko.",
"DeletingTables" => "Deleting Tables",
"DeletingTablesEnd" => "Finished Deleting Tables",
"ErrorDeletingTable" => "Error deleting <tt>%1</tt> table, the most likely reason is that the table does not exist in which case you can ignore this warning.",
"DeletingTable" => "Deleting <tt>%1</tt> table",

/*
   Write Config Page�
*/
"write-config" => "������� ������� ���������",
"FinalStep" => "Final Step",
"FinalSteps" => "Final Steps",
"Writing" => "������� ������� ���������",
"RemovingWritePrivilege" => "�������� ����������� ��������",
"InstallationComplete" => "Installation Complete",
"ThatsAll" => "���� ���� ���! �������� ���� <a href=\"%1\"> �� ����� �� WackoWiki site ���</a>.",
"SecurityConsiderations" => "��������� ���������",
"SecurityRisk" => "��� ����������� �� ���������� �� �������� �������� ��� <tt>config.inc.php</tt> ���� ��� ���� �������. ��������� �� ������ ��������� ������ �� �������� ����� ���������!",
"RemoveSetupDirectory" => "�� ������ �� ���������� ��� �������� \"setup\" ���� ��� � ���������� ������������ ���� �����������.",
"ErrorGivePrivileges" => "�� ������ ��������� <tt>%1</tt> ��� ������ �� ����� ���������. �� ��������� �� ������ ���� web server ��� ��������� �������� ���� �� ������ ���� ���� �������� ��� WackoWiki, � ��� ���� ������ �� ����� <tt>config.inc.php</tt> (<tt>touch config.inc.php ; chmod 666 config.inc.php</tt>; ��� �������� �� ���������� �� �������� �������� ��������, �.�. <tt>chmod 644 config.inc.php</tt>). ��, ��� ������ ����, ��� �������� �� �� ������, �� ������ �� ����������� �� �������� ������� �� ��� ��� ������ ��� �� �� ������������/��������� �� <tt>config.inc.php</tt> ���� ���� �������� ��� WackoWiki. ���� �� ������ ����� �� WackoWiki site ��� �� ��������. ��� ���, �������� ������������� �� <a href=\"http://wackowiki.org/Doc/English/Installation\" target=\"_blank\">WackoWiki:Doc/English/Installation</a>",
"NextStep" => "��� ������� ����, �� ��������� ������������ �� ����������� �� ������ �� ���������� ������ ���������, <tt>config.inc.php</tt>. 
�������� �������������� ��� � web server ��� ���� �������� ��������� �������� ��� ������, ������ �� ��������� �� �� ��������������� �� �� ����.
����� ��� ����, ����� ��� ������������ ���: <a href=\"http://wackowiki.org/Doc/English/Installation\" target=\"_blank\">WackoWiki:Doc/English/Installation</a>.",
"WrittenAt" => "��������� ���� ",
"DontChange" => "��� �������� ��� ������ ��� wakka_version �� �� ����!",
"ConfigDescription" => "detailed description http://wackowiki.org/Doc/English/Configuration",
"TryAgain" => "��������� ����",
"RemoveWakkaConfigFile" => "WackoWiki uses a newer config file than your previous WakkaWiki installation.  The old file could not be automatically removed by the system and so it is recommended that you manually delete the file <tt>wakka.config.php</tt>.",
"DeletingWakkaConfigFile" => "Deleting Obsolete Wakka Configuration File",

);
?>