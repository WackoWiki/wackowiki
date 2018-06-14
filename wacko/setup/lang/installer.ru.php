<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'windows-1251',
'LangISO' => 'ru',
'LangName' => '�������',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// site name
	'site_name'			=> 'MyWikiSite',

	// pages
	'category_page'		=> '���������',
	'groups_page'		=> '������',
	'users_page'		=> '������������',

	'help_page'			=> '������',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',

	// time
	#'date_format'					=> 'd.m.Y',
	#'time_format'					=> 'H:i',
	#'time_format_seconds'			=> 'H:i:s',
],

/*
   Generic Page Text
*/
'Title' => '��������� WackoWiki',
'Continue' => '����������',
'Back' => '�����',
'Recommended' => '�������������',
'InvalidAction' => '������������ ��������',

/*
   Language Selection Page
*/
'lang' => '����� �����',
'PleaseUpgradeToR5' => '�� ����������� �������������� (�� 5.0.0) ������ WackoWiki. ��� ���������� �� ������� ������ ������ ��������� ��������� ������� �� <code class="version">5.0.x</code>.',
'UpgradeFromWacko' => '����� ���������� � WackoWiki! ������ ������� ���������� WackoWiki � <code class="version">%1</code> �� <code class="version">%2</code>.  ������� ���������� ����� ��������� ��������� �������.',
'FreshInstall' => '����� ���������� � WackoWiki! �� ������ ��� ��������� WackoWiki <code class="version">%1</code>.  ������� ��������� ����� ��������� ��������� �������.',
'PleaseBackup' => '�������� ��������� ����� ���� ������, ����������������� ����� � ������ ��������� ���� ������ (��������, ������ ����) �� ������ �������� ���������. ��� ����� ������ ��� �� ����� ���������� ��������.',
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
'PHPExtensions' => 'PHP ����������',
'Permissions' => '����� �������',
'ReadyToInstall' => '������ � ���������?',
'Requirements' => '��� ������ ������ ��������������� �����������, ������������� ����.',
'OK' => 'OK',
'Problem' => '��������',
'NotePHPExtensions' => '',
'ErrorPHPExtensions' => '���� ����������� PHP �� ������������ PHP ���������� ����������� ��� ������ WackoWiki.',
'NotePermissions' => '��������� ��������� ���������� �������� ��������� � ���� %1, ������������� � �������� WackoWiki. ����� �� ������ �������, ���������, ��� ���-������ ����� ����� �� ������ � ������ ����. ���� ��� ����������, ��� ������� �������� ���� ������� (��������� ��������� ��������, ���).<br><br>��. <a href="https://wackowiki.org/doc/Doc/Russian/Installjacija" target="_blank">WackoWiki:Doc/Russian/�����������</a>.',
'ErrorPermissions' => '��� ����� ����������, ����� ��������� ��������� �� ����� ������������� ������ �����, ��������� ��� ���������� ������ WackoWiki. ����� �� ����� ��������� ��� ����� ���������� ��������� ������� ��������� ����� ������� � ������ �� �������.',
'ErrorMinPHPVersion' => '������ PHP ������ ���� ������ <strong>' . PHP_MIN_VERSION . '</strong>, � ������ ���������� ���� �� ���������� ������.  ��� ���������� ������ WackoWiki ����� �������� PHP �� ���� �� ��������� ������.',
'Ready' => '�����������, ��� ������ ����� ��� ������� WackoWiki. ������� � ��������� ����� ��������� ��������� �������.',

/*
   Site Config Page
*/
'site-config' => '��������� �����',
'SiteName' => '�������� WackoWiki',
'SiteNameDesc' => '����������, ������� ��� ������ ����� Wiki.',
'HomePage' => '������� ��������',
'HomePageDesc' => '������� ��� �������� ��������&nbsp;&mdash; ��� ����� �������� �� ���������, ������������ ������ � ������ ��� ��������� �����; ��� ������ <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">����������</a>.',
'HomePageDefault' => '�������',
'MultiLang' => '����� ��������������',
'MultiLangDesc' => '����� �������������� ��������� ������� �������� �� ������ ������ � ����� ����. ���� ����� �������, ��������� ��������� ������� ��������� �������� ��� ���� ������, ���������� � �����������.',
'AllowedLang' => '����������� �����',
'AllowedLangDesc' => '������������� ������� ����� ������, ������� �� �������� ������������, ����� ����� ������� ���.',
'Admin' => '��� ��������������',
'AdminDesc' => '������� ��� ��������������, ��� ������ ���� <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">����������</a> (��� ������� ����) (��������, WikiAdmin).',
'Password' => '������ ��������������',
'PasswordDesc' => '������� ������ (�� ����� %1 ��������).',
'Password2' => '������������� ������:',
'Mail' => '����� ����������� ����� ��������������',
'MailDesc' => '������� ����� ����������� ����� ��������������.',
'Base' => '������� URL',
'BaseDesc' => '������� URL ����� WackoWiki. � ���� ����� ����������� ����� �������; ���� ������������ mod_rewrite, ����� ������ ������������ ������ ����� ������, �.&nbsp;�.</p><ul><li><strong><em>http://example.com/</em></strong></li><li><strong><em>http://example.com/wiki/</em></strong></li></ul>',
'Rewrite' => 'Rewrite-�����',
'RewriteDesc' => 'Rewrite-����� ������ ���� �������, ���� �� ����������� mod_rewrite.',
'Enabled' => '�������:',
'ErrorAdminEmail' => '������� ���������� ����� ����������� �����!',
'ErrorAdminPasswordMismatch' => '������ �� ���������. ����������, ��������� ���� ������ ��������������',
'ErrorAdminPasswordShort' => '������ �������������� ������� ��������, ����������� ����� - 9 ��������!',
'WarningRewriteMode' => '��������!\n��������� �������� URL � Rewrite-������ �������� �������������. ������ ��� ���������� Rewrite �� ������ ����� ? � ������� URL, �� � ��� �� ����.\n\n��� ����������� ��������� � �������� ����������� ������� ��.\n��� ����, ����� ��������� � ����� � �� ���������, ������� ������.\n\n���� �� ������ ���� ������, �������, ��� ����� ��������� ����� �������� �������� ������������������� ����� ���������.',
'ModRewriteStatusUnknown' => '��������� ��������� �� ����� ���������, ������� �� mod_rewrite, �� ��� �� ��������, ��� �� ��������',

'LanguageArray'	=> [
	'bg' => '����������',
	'da' => '�������',
	'nl' => '�������������',
	'el' => '���������',
	'en' => '����������',
	'et' => '���������',
	'fr' => '�����������',
	'de' => '��������',
	'hu' => '����������',
	'it' => '�����������',
	'pl' => '��������',
	'pt' => '�������������',
	'ru' => '�������',
	'es' => '���������',
],

/*
   Database Config Page
*/
'database-config' => '��������� ���� ������',
'DBDriver' => '�������',
'DBDriverDesc' => '������� ���� ������, ������� �� ������ ������������. ����� ������� legacy-�������, ���� �� ������������ ������������� <a href="http://de2.php.net/pdo" target="_blank">PDO</a>.',
'DBCharset' => '���������',
'DBCharsetDesc' => '��������� ������� ���� ������.',
'DBEngine' => '������ ���� ������',
'DBEngineDesc' => '������ ���� ������ ������� ����� �����������. �� ������ ������� ������ MyISAM ���� �� ������� ������� MariaDB 10 ��� MySql 5.6 (��� ����) � ���������� InnoDB.',
'DBHost' => '��� �������',
'DBHostDesc' => '��� �������, �� ������� �������� ��. ������ "127.0.0.1" ��� "localhost" (�. �. �� ������, �� ������� ��������������� WackoWiki).',
'DBPort' => '���� (�������������)',
'DBPortDesc' => '����� �����, �� �������� �������� ������ ��, ��� ������������� ����� �� ��������� �������� ������.',
'DB' => '��� ���� ������',
'DBDesc' => '���� ������, ������� ����� ������������ WackoWiki. ��� ������ ������������, ����� ��������� ������������!',
'DBUserDesc' => '��� ������������ ��� ����������� � ���� ������.',
'DBUser' => '��� ������������ ���� ������',
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
'AlterTable' => '��������� ��������� ������� <code>%1</code>',
'RenameTable' => '�������������� ������� <code>%1</code>',
'UpdateTable' => '���������� ������� <code>%1</code>',
'InstallingDefaultData' => '���������� ������ �� ���������',
'InstallingPagesBegin' => '���������� ������� �� ���������',
'InstallingPagesEnd' => '���������� ������� �� ��������� ���������',
'InstallingSystemAccount' => '���������� �����-������������ System',
'InstallingAdmin' => '���������� ������������-��������������',
'InstallingAdminSetting' => '���������� ������������-��������������',
'InstallingAdminGroup' => '���������� ������ Admins',
'InstallingAdminGroupMember' => '���������� ���������� � ������ Admins',
'InstallingEverybodyGroup' => '���������� ������ Everybody',
'InstallingModeratorGroup' => '���������� ������ Moderator',
'InstallingReviewerGroup' => '���������� ������ Reviewer',
'InstallingLogoImage' => '���������� �������� ��������',
'InstallingConfigValues' => '���������� ���������� ������������',
'ErrorInsertingPage' => '������ ������� �������� <code>%1</code>',
'ErrorInsertingPageReadPermission' => '������ ��������� ���� �� ������ �������� <code>%1</code>',
'ErrorInsertingPageWritePermission' => '������ ��������� ���� �� ������ �������� <code>%1</code>',
'ErrorInsertingPageCommentPermission' => '������ ��������� ���� �� ��������������� �������� <code>%1</code>',
'ErrorInsertingPageCreatePermission' => '������ ��������� ���� �� �������� ��������<code>%1</code>',
'ErrorInsertingPageUploadPermission' => '������ ��������� ���� �� �������� ������ �� �������� <code>%1</code>',
'ErrorInsertingDefaultMenuItem' => '������ ��������� �������� <code>%1</code>��� ������ ���� �� ���������',
'ErrorPageAlreadyExists' => '�������� <code>%1</code> ��� ����������',
'ErrorAlteringTable' => '������ ��������� ��������� ������� <code>%1</code>',
'ErrorRenamingTable' => '������ �������������� ������� <code>%1</code>',
'ErrorUpdatingTable' => '������ ���������� ������� <code>%1</code>',
'CreatingTable' => '�������� ������� <code>%1</code>',
'ErrorAlreadyExists' => '<code>%1</code> ��� ����������',
'ErrorCreatingTable' => '������ �������� ������� <code>%1</code>, ��� ��� ����������?',
'ErrorMovingRevisions' => '������ ����������� ������ ������',
'MovingRevisions' => '����������� ��� ������ ������ � ������� revisions',
'DeletingTables' => '�������� ������',
'DeletingTablesEnd' => '�������� ������ ���������',
'ErrorDeletingTable' => '������ �������� ������� <code>%1</code>, ��������� �������&nbsp;&mdash; ���������� ������� � ����, � ���� ������ �������������� ����� ���������������.',
'DeletingTable' => '�������� ������� <code>%1</code>',

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
'SecurityRisk' => '�� �������� ������ ����� �� ��������� ����� %1 ���-��������. ���� ����� �� �������, ��� ������ ��������!',
'RemoveSetupDirectory' => '������ �� ������ ������� ������� <code>setup/</code>&nbsp;&mdash; ������� ��������� ��������.',
'ErrorGivePrivileges' => '���������������� ���� %1 �� ����� ���� �������. ����� �������� ���� ���-������� ����� �� ������ ���� �� ������� WackoWiki, ���� �� ������ ���� %1<br>%2<br>; �� �������� ������ ��� ����� ����� ���������, �.&nbsp;e. %3.<br>����, ������-���� �� �� ������ ��������� ����� �����, ������� ����������� �����, ������������� ���� � ����� ���� � ��������� ��� �� ������ ��� ������ %1 � ������� WackoWiki. ����� ����� ��� ���� ������ ����������. ���� ���, �������� <a href="https://wackowiki.org/doc/Doc/Russian/Installjacija">WackoWiki:Doc/Russian/�����������</a>',
'NextStep' => '�� ��������� ���� ��������� ��������� ��������� ��������� ���������� ���������������� ����, %1. ����������, ���������, ��� ���-������ ����� ���������� ���� ��� ��������� �����; � ��������� ������ ��� ������� ��������� ��������� �������. �� �������� �����������, ��. <a href="https://wackowiki.org/doc/Doc/Russian/Installjacija" target="_blank">WackoWiki:Doc/Russian/�����������</a>.',
'WrittenAt' => '������� ',
'DontChange' => '�� ������� wacko_version �������!',
'ConfigDescription' => '��������� �������� https://wackowiki.org/doc/Doc/Russian/FajjlKonfiguracii',
'TryAgain' => '���������� �����',

];
?>
