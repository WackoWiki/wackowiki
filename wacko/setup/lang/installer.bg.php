<?php
$lang = array(

/*
   Language Settings
*/
"Charset" => "windows-1251",
"LangISO" => "bg",
"LangName" => "Bulgarian",

/*
   Generic Page Text
*/
"Title" => "���������� �� WackoWiki",
"Continue" => "�����������",
"Back" => "Back",

/*
   Language Selection Page
*/
"Lang" => "������� ���������",
"LangDesc" => "�������� ����. ��� �� �� ��������� �� ������������, � ���� � �� ����� ���� �� ������������ �� ����� WackoWiki.",

/*
   System Requirements Page
*/
"version-check" => "System Requirements",
"PHPVersion" => "PHP Version",
"PHPDetected" => "Detected PHP",
"ModRewrite" => "Apache Rewrite Extension (Optional)",
"ModRewriteInstalled" => "Rewrite Extension (mod_rewrite) Installed?",
"Database" => "Database",
"Permissions" => "Permissions",
"ReadyToInstall" => "Ready to Install?",
"Installed" => "����������� WackoWiki ������ ",
"ToUpgrade" => "���������� �� <strong>�� ���������</strong> ����� WackoWiki � ",
"PleaseBackup" => "����, ��������� �� ����� �� ������ ����� (��) ��, ���������������� ���� � �������, ��������� �� ��� ������� (��������,  ����),  ������ ��� �� � �����!",
"Fresh" => "�������� ���� �� ���� ����������, ���� ����� �� ���� WackoWiki . �� �� ��������� ��� WackoWiki ",
"Requirements" => "Your server must meet the requirements listed below.",
"OK" => "OK",
"Problem" => "Problem",
"NotePermissions" => "���������� �� ����������� �� ����� �� ������ ����������� ��� ���� <tt>wakka.config.php</tt>, ���������� � �������� ����������, ������ � WackoWiki. �� �� ����� ����, ���� ���� ������ �� � �������� �� ����� ���� ��������� ������/������! �� �� ���� ��������, ������ ���� �������� �� �� �������� ������� �� ������ �� (������� ��) ���� ����.<br /><br />��. <a href=\"http://wackowiki.org/Archiv/DocEnglish/Installation\" target=\"_blank\">WackoWiki:DocEnglish/Installation</a>.",
"ErrorPermissions" => "It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.",
"ErrorMinPHPVersion" => "The PHP Version must be greater than <strong>4.3.3</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.",
"Ready" => "Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.",

/*
   Site Config Page
*/
"site-config" => "��������� �� �����",
"Name" => "�������� ����� �� ��������",
"NameDesc" => "��� �� ����� WackoWiki. ������ �� � �� ���� ������� � �������� ���������������. <a href=\"http://wackowiki.org/Archiv/DocEnglish/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"Home" => "������ ��������",
"HomeDesc" => "Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href=\"http://wackowiki.org/Archiv/DocEnglish/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a>.",
"MultiLang" => "&laquo;�����������&raquo; �����",
"MultiLangDesc" => "&laquo;�����������&raquo; �����, ���������� ������ �� ������� �����. ��� � �������, ������������ �� ������������ �������� �� ������� �������� �����.",
"Admin" => "���",
"AdminDesc" => "�������� ���. ���� �� ��� <a href=\"http://wackowiki.org/Archiv/DocEnglish/WikiName\" title=\"View Help\" target=\"_blank\">WikiName</a> (��� ��������).",
"Password" => "��� ������",
"PasswordDesc" => "�������� ������ ( 5 � ������ ������� )",
"Password2" => "������������� �� ��������:",
"Mail" => "Admin Email Address",
"MailDesc" => "Enter the admins email address.",
"Base" => "����� URL",
"BaseDesc" => "Your WackoWiki sites base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><b><i>http://www.wackowiki.org/</i></b></li><li><b><i>http://www.wackowiki.org/wiki/</i></b></li></ul><p class=\"no_top\">If you are not going to use mod_rewrite then the URL should end with \"?page=\" i.e.<ul><li><b><i>http://www.wackowiki.org/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/wiki/index.php?page=</i></b></li><li><b><i>http://www.wackowiki.org/?page=</i></b></li><li><b><i>http://www.wackowiki.org?page=</i></b></li></ul>",
"Rewrite" => "Rewrite-�����",
"RewriteDesc" => "Rewrite-����� ������ �� � �������, ��� �������� mod_rewrite.",
"Enabled" => "�������:",
"ErrorAdminName" => "�������� ������� WackoWiki ���!",
"ErrorAdminEmail" => "�������� �������� �����!",
"ErrorAdminPasswordMismatch" => "�������� �� �������������� �� �������� ����!",
"ErrorAdminPasswordShort" => "The admin ����� � ������, the minimum length is 5 characters!",
"WarningRewriteMode" => "��������!\n��������� �������� URL � Rewrite-������ �������� �������������. ������ ��� ���������� Rewrite �� ������ ����� ? � ������� URL, �� � ��� �� ����.\n\n��� ����������� ����������� � �������� ����������� ������� ��.\n��� ����, ����� ��������� � ����� � �� ���������, ������� ������.\n\n���� �� ������ ���� ������, �������, ��� ����� ��������� ����� �������� �������� ������������������� ����� �����������.",
"ModRewriteStatusUnknown" => "The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled",

/*
   Database Config Page
*/
"database-config" => "��������� �� ��",
"DBDriverDesc" => "The database driver you want to use.  You must choose a legacy driver if you do not have PHP5.1 (or greater) and <a href=\"http://de2.php.net/pdo\" target=\"_blank\">PDO</a> installed.",
"DBDriver" => "Driver",
"DBHost" => "��� (hostname) �� ��",
"DBHostDesc" => "The host your database server is running on. Usually \"localhost\" (ie, the same machine your WackoWiki site is on).",
"DBPort" => "Port (Optional)",
"DBPortDesc" => "The port number your database server is accessable through, leave it blank to use the default port number.",
"DB" => "��",
"DBDesc" => "The database WackoWiki should use. This database needs to exist already once you continue!",
"DBUserDesc" => "Name and password of the user used to connect to your database.",
"DBUser" => "��� (username)",
"DBPasswordDesc" => "Name and password of the user used to connect to your database.",
"DBPassword" => "�����a (password)",
"PrefixDesc" => "������� �� ��������� �� Wacko. ���� ���� ���������� �� ������� WackoWiki �� ���� ��, ���� ���� �������� ��������.",
"Prefix" => "������� �� ���������",
"ErrorNoDbDriverDetected" => "No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.",
"ErrorNoDbDriverSelected" => "No database driver has been selected, please pick one from the list.",

/*
   Database Installation Page
*/
"database-install" => "Database Installation",
"TestingConfiguration" => "���� �� �����������",
"TestConnectionString" => "�������� �� �������� � ��",
"TestDatabaseExists" => "Checking if the database you specified exists",
"InstallingTables" => "Installing Tables",
"ErrorDBConnection" => "There was a problem with the database connection details you specified, please go back and check they are correct.",
"ErrorDBExists" => "�� � ������� ������ ��. ��������� ���� � ��������� �������������!",
"To" => "->",
"AlterTable" => "Altering %1 Table",
"AlterUsersTable" => "Altering Users Table",
"InstallingDefaultData" => "Adding Default Data",
"InstallingPagesBegin" => "Adding Default Pages",
"InstallingPagesEnd" => "Finished Adding Default Pages",
"InstallingAdmin" => "�������� ��������������� ����������",
"InstallingLogoImage" => "Adding Logo Image",
"ErrorInsertingPage" => "Error inserting %1 page",
"ErrorInsertingPageReadPermission" => "Error setting read permission for %1 page",
"ErrorInsertingPageWritePermission" => "Error setting write permission for %1 page",
"ErrorInsertingPageCommentPermission" => "Error setting comment permissions for %1 page",
"ErrorPageAlreadyExists" => "The %1 page already exists",
"ErrorAlteringTable" => "Error altering %1 table",
"CreatingTable" => "��������� ������� %1",
"ErrorAlreadyExists" => "The %1 already exists",
"ErrorCreatingTable" => "Error creating %1 table, does it already exist?",
"ErrorMovingRevisions" => "Error moving revision data",
"MovingRevisions" => "����������� ������� ������ � ������� revisions",
"CleanupScript" => "��������� <a href=\"http://wackowiki.org/Archiv/DocEnglish/CleanupScript\" target=\"_blank\">WackoWiki:DocEnglish/CleanupScript</a>, ���� �� ������ ������� �� ����� ����.",

/*
   Write Config Page
*/
"write-config" => "Write Config File",
"Writing" => "��������� �����������",
"Writing2" => "����� �� ���������������� ����",
"RemovingWritePrivilege" => "Removing Write Privilege",
"InstallationComplete" => "���! �������� �������. ���� ������ <a href=\"%1\">WackoWiki site</a>.",
"SecurityConsiderations" => "Security Considerations",
"SecurityRisk" => "�� ���������� ������ �� ��������� ������� ������� �� ������ �� <tt>wakka.config.php</tt> �� �������. ������ �� \"���������\"!",
"RemoveSetupDirectory" => "You should delete the \"setup\" directory now that the installation process has been completed.",
"ErrorGivePrivileges" => "���������������� ���� %1 �� ���� �� �� ������. ������ ���� �������� �� �� �������� ������� �� ������ �� (������� ��) ���� ���� ��� �� �� ������� ������ ���� <tt>wakka.config.php</tt> (<tt>touch wakka.config.php ; chmod 666 wakka.config.php</tt>; �� ���������� ������ �� ��������� ������� �������, �.e. <tt>chmod 644 wakka.config.php</tt>). ��� ���� �� �����, �� ������ �� �������� � �������� ��������� ����� � ��� ������ ���� �� ����� �������� � ����� �� �� ����������� � ��� <tt>wakka.config.php</tt> �� ������� � �������� ���������� �� Wacko. ��� ��������, ����� (����.) <a href=\"http://wackowiki.org/DocEnglish/Installation\" target=\"_blank\">WackoWiki:DocEnglish/Installation</a> ��� (�����) <a href=\"http://wackowiki.de/Archiv/DocEnglish/Installation\">WackoWiki:������������/���������</a>",
"NextStep" => "�� ���������� ������, ������������ �� ����� �� ������ ��������� ���������������� ����, <tt>wakka.config.php</tt>. ���������������� ���� <tt>wakka.config.php</tt> ��  ��������� � �������� ����������, ������ � WackoWiki. �� �� ����� ���������, ���� ���� ������ �� � �������� �� ����� ���� ��������� ������/������! �� �� ���� ��������, ������ ���� �������� �� �� �������� ������� �� ������ �� ���� ����. � �������� ������ �� ������ �� �������� ��������� �� ����. ������, ���������� �� �����������, ����� � �� ���������, �� ��� ��� <a href=\"http://wackowiki.org/Archiv/DocEnglish/Installation\" target=\"_blank\">WackoWiki:DocEnglish/Installation</a>.",
"WrittenAt" => "������� ",
"DontChange" => "�� ���������� wakka_version �����!",
"TryAgain" => "��� ����",

// O L D
/*

"pleaseConfigure" => "����, ��������� ����� WackoWiki .",
"Looking for database..." => "�������� �� ��...",
"pages alter" => "����� ������� � ����������� �� ������� pages...",
"useralter" => "����� ������� � ����������� �� �������  user...",
"Already exists?" => "���� � ���?",
"Adding some pages..." => "�������� ������������...",
"And table..." => "� ������� %1 (��������� �����!)...",
"return" => "�� �� ������� �� ����� ����",
#"mysqlHostDesc" => "��� (hostname), �� MySQL �������. ���������� \"localhost\".",
#"dbDesc" => "���� ����� �� MySQL,  �� WackoWiki. ������ �� � ��������� �������������!",
#"mysqlPasswDesc" => "��� � ������ �� �� MySQL.",
"homeDesc" => "������ �������� �� WackoWiki.  ������ �� �  � �������.",
"baseDesc" => "����� URL  �� ������ ���������� ��  WackoWiki. ������� �� ���������� �� ������������� ��� ���� � ��������� \"?page=\", ��� �� ���� �� �� ������ mod_rewrite.",
"AdminConf" => "��������� �� ����������������� ������",
"mailDesc" => "����� �� ������������ ���� (email) �� ��������������.",
"adding pages" => "�������� ���� ��������...",
"newinstall" => "������������� �������� � ��������� �����������. ���������� ��, ��� ������ ����� �������!",
"apply rights" => "������� ���������� ����� ������� �� ����� ",
"apply rights yourself" => "�� ������ �������������� ���������� ������ �� ������ �� ����� ",
*/
);
?>