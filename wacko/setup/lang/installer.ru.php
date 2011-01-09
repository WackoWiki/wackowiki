<?php
$lang = array(

/*
   Language Settings
*/
'Charset' => 'windows-1251',
'LangISO' => 'ru',
'LangName' => '�������',

/*
   Generic Page Text
*/
'Title' => '��������� WackoWiki',
'Continue' => '����������',
'Back' => '�����',

/*
   Language Selection Page
*/
'UpgradeFromWacko' => '����� ���������� � WackoWiki! ������ ������� ���������� WackoWiki � <tt>%1</tt> �� <tt>%2</tt>.  ������� � ���������� ����� ��������� ��������� �������.',
'FreshInstall' => '����� ���������� � WackoWiki! �� ������ ��� ��������� WackoWiki <tt>%1</tt>.  ������� � ��������� ����� ��������� ��������� �������.',
'PleaseBackup' => 'C������� ��������� ����� ���� ������, ����������������� ����� � ������ ��������� ���� ������ (��������, ������ ����) �� ������ �������� ���������. ��� ����� ������ ��� �� ����� ���������� ��������.',
'Lang' => '����� �����',
'LangDesc' => '����������, �������� ����. �� ����� �������������� � �������� ���������, � ����� ������ ������ �� ��������� ������������� WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => '��������� ����������',
'PHPVersion' => '������ PHP',
'PHPDetected' => '��������� PHP',
'ModRewrite' => '���������� Apache Rewrite (�������������)',
'ModRewriteInstalled' => '������ ���������� (mod_rewrite) ����������?',
'Database' => '���� ������',
'Permissions' => '����� �������',
'ReadyToInstall' => '������ � ���������?',
'Requirements' => '��� ������ ������ �������������� �����������, ������������� ����.',
'OK' => 'OK',
'Problem' => '��������',
'NotePermissions' => '��������� ��������� ���������� �������� ��������� � ���� <tt>config.php</tt>, ������������ � �������� WackoWiki. ����� �� ������ �������, ���������, ��� ���-������ ����� ����� �� ������ � ������ ����. ���� ��� ����������, ��� ������� �������� ���� ������� (��������� ��������� ��������, ���).<br /><br />��. <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:DocEnglish/Installation</a>.',
'ErrorPermissions' => '��� ����� ����������, ����� ��������� ��������� �� ����� ������������� ������ �����, ��������� ��� ���������� ������ WackoWiki. ����� �� ����� ��������� ��� ����� ���������� ��������� ������� ��������� ����� ������� � ������ �� �������.',
'ErrorMinPHPVersion' => '������ PHP ������ ���� ������ <strong>5.2.0</strong>, � ������ ���������� ���� �� ���������� ������.  ��� ���������� ������ WackoWiki ����� �������� PHP �� ���� �� ��������� ������.',
'Ready' => '�����������, ��� ������ ����� ��� ������� WackoWiki. ������� � ��������� ����� ��������� ��������� �������.',

/*
   Site Config Page
*/
'site-config' => '��������� �����',
'Name' => '�������� WackoWiki',
'NameDesc' => '����������, ������� ��� ������ ����� WackoWiki, ��� ������ ���� <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">����������</a>.',
'Home' => '������� ��������',
'HomeDesc' => '������� ��� �������� ��������&nbsp;&mdash; ��� ����� �������� �� ���������, ������������ ������ � ������ ��� ��������� �����; ��� ������ <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">����������</a>.',
'HomeDefault' => 'HomePage',
'MultiLang' => '����� ��������������',
'MultiLangDesc' => '����� �������������� ��������� ������� �������� �� ������ ������ � ����� ����. ���� ����� �������, ��������� ��������� ������� ��������� �������� ��� ���� ������, ���������� � �����������.',
'Admin' => '��� ��������������',
'AdminDesc' => '������� ��� ��������������, ��� ������ ���� <a href="http://wackowiki.org/Doc/English/WikiName" title="View Help" target="_blank">����������</a> (��� ������� ����) (��������, WikiAdmin).',
'Password' => '������ ��������������',
'PasswordDesc' => '������� ������ (�� ����� ���� ��������).',
'Password2' => '������������� ������:',
'Mail' => '����� ����������� ����� ��������������',
'MailDesc' => '������� ����� ����������� ����� ��������������.',
'Base' => '������� URL',
'BaseDesc' => '������� URL ����� WackoWiki. � ���� ����� ����������� ����� �������; ���� ������������ mod_rewrite, ����� ������ ������������ ������ ����� ������, �.&nbsp;�.</p><ul><li><b><i>http://wackowiki.org/</i></b></li><li><b><i>http://wackowiki.org/wiki/</i></b></li></ul>',
'Rewrite' => 'Rewrite-�����',
'RewriteDesc' => 'Rewrite-����� ������ ���� �������, ���� �� ����������� mod_rewrite.',
'Enabled' => '�������:',
'ErrorAdminName' => '����� ������ ���������� ������� � �������� ����� ��������������!',
'ErrorAdminEmail' => '������� ���������� ����� ����������� �����!',
'ErrorAdminPasswordMismatch' => '������ �� ���������. ����������, ��������� ���� ������ ��������������',
'ErrorAdminPasswordShort' => '������ �������������� ������� ��������, ����������� ����� � 8 ��������!',
'WarningRewriteMode' => '��������!\n��������� �������� URL � Rewrite-������ �������� �������������. ������ ��� ���������� Rewrite �� ������ ����� ? � ������� URL, �� � ��� �� ����.\n\n��� ����������� ��������� � �������� ����������� ������� ��.\n��� ����, ����� ��������� � ����� � �� ���������, ������� ������.\n\n���� �� ������ ���� ������, �������, ��� ����� ��������� ����� �������� �������� ������������������� ����� ���������.',
'ModRewriteStatusUnknown' => '��������� ��������� �� ����� ���������, ������� �� mod_rewrite, �� ��� �� ��������, ��� �� ��������',

/*
   Database Config Page
*/
'database-config' => '��������� ��',
'DBDriverDesc' => '������� ���� ������, ������� �� ������ ������������. ����� ������� legacy-�������, ���� �� ������������ PHP 5.1 (��� ������) � ������������� <a href="http://de2.php.net/pdo" target="_blank">PDO</a>.',
'DBDriver' => '�������',
'DBHost' => '��� �������',
'DBHostDesc' => '��� �������, �� ������� �������� ��. ������ "localhost" (�. �. �� ������, �� ������� ��������������� WackoWiki).',
'DBPort' => '���� (�������������)',
'DBPortDesc' => '����� �����, �� �������� �������� ������ ��, ��� ������������� ����� �� ��������� �������� ������.',
'DB' => '��� ���� ������',
'DBDesc' => '���� ������, ������� ����� ������������ WackoWiki. ��� ������ ������������, ����� ��������� ������������!',
'DBUserDesc' => '��� ������������ ��� ����������� � ���� ������.',
'DBUser' => '��� ������������',
'DBPasswordDesc' => '������ ������������ ��� ����������� � ���� ������.',
'DBPassword' => '������',
'PrefixDesc' => '������� ���� ������, ������������ WackoWiki. ��� �������� ��������� ��������� WackoWiki, ��������� ���� ��&nbsp;&mdash; ���������� ������� ��� ��� ������ �������� ������ (��������, wacko_).',
'Prefix' => '������� ������',
'ErrorNoDbDriverDetected' => '�������� ��� ������ �� ����������. ����������, �������� ������������� ���������� mysql, mysqli ��� pdo � ����� php.ini.',
'ErrorNoDbDriverSelected' => '�� ������ ������� ���� ������, �������� ���� �� ������.',
'DeleteTables' => '������� ������������ �������?',
'DeleteTablesDesc' => '��������! ��������� ����� ������ ������� � �������� ���� ������������ ������ �� ���� ����. �������� ��� �������� �� �������, ������ ����� ���� ������������� ������ ������� �� ��������� �����.',
'ConfirmTableDeletion' => '�� �������, ��� ������ ������� ��� ������������ ������� ����?',

/*
   Database Installation Page
*/
'database-install' => '��������� ���� ������',
'TestingConfiguration' => '������������ ��������',
'TestConnectionString' => '�������� ���������� ���������� � ��',
'TestDatabaseExists' => '�������� ������������� ��������� ��',
'InstallingTables' => '��������� ������',
'ErrorDBConnection' => '��������� ������ ��� ����������� � �� � ���������� �����������. ����������, ��������� � ��������� �� ������������.',
'ErrorDBExists' => '��������� �� �� ����������. ����������, ��������������, ��� ����� �� ����������!',
'To' => '->',
'AlterTable' => '��������� ��������� ������� <tt>%1</tt>',
'RenameTable' => 'Renaming <tt>%1</tt> Table',
'UpdateTable' => '���������� ������� <tt>%1</tt>',
'InstallingDefaultData' => '���������� ������ �� ���������',
'InstallingPagesBegin' => '���������� ������� �� ���������',
'InstallingPagesEnd' => '���������� ������� �� ��������� ���������',
'InstallingSystemAccount' => 'Adding System User',
'InstallingAdmin' => '���������� ������������-��������������',
'InstallingAdminSetting' => '���������� ������������-��������������',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingRegisteredGroup' => 'Adding Registered Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => '���������� �������� ��������',
'InstallingConfigValues' => '���������� ���������� ������������',
'ErrorInsertingPage' => '������ ������� �������� <tt>%1</tt>',
'ErrorInsertingPageReadPermission' => '������ ��������� ���� �� ������ �������� <tt>%1</tt>',
'ErrorInsertingPageWritePermission' => '������ ��������� ���� �� ������ �������� <tt>%1</tt>',
'ErrorInsertingPageCommentPermission' => '������ ��������� ���� �� ��������������� �������� <tt>%1</tt>',
'ErrorInsertingPageCreatePermission' => 'Error setting create permissions for <tt>%1</tt> page',
'ErrorInsertingPageUploadPermission' => 'Error setting upload permissions for <tt>%1</tt> page',
'ErrorInsertingDefaultBookmark' => 'Error setting page <tt>%1</tt> as default bookmark',
'ErrorPageAlreadyExists' => '�������� <tt>%1</tt> ��� ����������',
'ErrorAlteringTable' => '������ ��������� ��������� ������� <tt>%1</tt>',
'ErrorRenamingTable' => 'Error renaming <tt>%1</tt> table',
'ErrorUpdatingTable' => '������ ���������� ������� <tt>%1</tt>',
'CreatingTable' => '�������� ������� <tt>%1</tt>',
'ErrorAlreadyExists' => '<tt>%1</tt> ��� ����������',
'ErrorCreatingTable' => '������ �������� ������� <tt>%1</tt>, ��� ��� ����������?',
'ErrorMovingRevisions' => '������ ����������� ������ ������',
'MovingRevisions' => '����������� ��� ������ ������ � ������� revisions',
'DeletingTables' => '�������� ������',
'DeletingTablesEnd' => '�������� ������ ���������',
'ErrorDeletingTable' => '������ �������� ������� <tt>%1</tt>, ��������� �������&nbsp;&mdash; ���������� ������� � ����, � ���� ������ �������������� ����� ���������������.',
'DeletingTable' => '�������� ������� <tt>%1</tt>',

/*
   Write Config Page
*/
'write-config' => '���������� ����������������� �����',
'FinalStep' => '��������� ���',
'Writing' => '���������� ����������������� �����',
'RemovingWritePrivilege' => '�������� ���������� �� ������',
'InstallationComplete' => '��������� ���������',
'ThatsAll' => '���! �� ������ �������. ������ �� ������ <a href="%1">���������� ���� ���� WackoWiki</a>.',
'SecurityConsiderations' => '����������� ������������',
'SecurityRisk' => '�� �������� ������ ����� �� ��������� ����� <tt>config.php</tt> ���-��������. ���� ����� �� �������, ��� ������ ��������!',
'RemoveSetupDirectory' => '������ �� ������ ������� ������� "setup"&nbsp;&mdash; ������� ��������� ��������.',
'ErrorGivePrivileges' => '���������������� ���� <tt>%1</tt> �� ����� ���� �������. ����� �������� ���� ���-������� ����� �� ������ ���� �� ������� WackoWiki, ���� �� ������ ���� <tt>config.php</tt> (<tt>touch config.php ; chmod 666 config.php</tt>; �� �������� ������ ��� ����� ����� ���������, �.&nbsp;e. <tt>chmod 644 config.php</tt>). ����, ������-���� �� �� ������ ��������� ����� �����, ������� ����������� �����, ������������� ���� � ����� ���� � ��������� ��� �� ������ ��� ������ <tt>config.php</tt> � ������� WackoWiki. ����� ����� ��� ���� ������ ����������. ���� ���, �������� <a href="http://wackowiki.org/Doc/English/Installation">WackoWiki:DocEnglish/Installation</a>',
'NextStep' => '�� ��������� ���� ��������� ��������� ��������� ��������� ���������� ���������������� ����, <tt>config.php</tt>. ����������, ���������, ��� ���-������ ����� ���������� ���� ��� ��������� �����; � ��������� ������ ��� ������� ��������� ��������� �������. �� �������� �����������, ��. <a href="http://wackowiki.org/Doc/English/Installation" target="_blank">WackoWiki:DocEnglish/Installation</a>.',
'WrittenAt' => '������� ',
'DontChange' => '�� ������� wacko_version �������!',
'ConfigDescription' => '��������� �������� http://wackowiki.org/Doc/Russian/FajjlKonfiguracii',
'TryAgain' => '���������� �����',
'RemoveWakkaConfigFile' => 'WackoWiki ���������� ���� ������������ ����� ����� ������, ��� ���������� ���������.  ������ ���� �� ����� ������������� ����� �� �������, ������������� ������� <tt>wakka.config.php</tt> �������.',
'DeletingWakkaConfigFile' => '�������� ����������� ����� �������� Wakka',

);
?>