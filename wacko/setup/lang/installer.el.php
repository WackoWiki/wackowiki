<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'iso-8859-7',
'LangISO' => 'el',
'LangName' => 'Greek',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// site name
	'site_name'			=> 'MyWikiSite',

	// pages
	'category_page'		=> 'Category',
	'groups_page'		=> 'Groups',
	'users_page'		=> 'Users',

	#'help_page'			=> '�������',
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
'Title' => '����������� WackoWiki',
'Continue' => '��������',
'Back' => '���������',
'Recommended' => '����������',
'InvalidAction' => 'Invalid action',

/*
   Language Selection Page
*/
'lang' => '��������� �������',
'PleaseUpgradeToR5' => 'You aware to be running an old (pre 5.0.0) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to <code class="version">5.0.x</code>.',
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <code class="version">%1</code> to <code class="version">%2</code>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <code class="version">%1</code>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => '��������, ����� ��������� ��� �����, ��� ������� ��������� ��� ��� �� ������������� ������ ���� ���� ��� ����� ������� �� ������ ��� ��������� ����������� ���� ��� �������� ��� ����������� �����������. ���� �� ��� ��������� ��� ���� ������ ����������.',
'LangDesc' => '�������� �������� ��� ������ ��� ��� ���������� ������������. � ������ ���� �� �������������� ������ ��� �� �������������� ������ ��� ��� ����������� ��� WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => '���������� ����������',
'PHPVersion' => '������ PHP',
'PHPDetected' => '����������� PHP',
'ModRewrite' => 'Apache Rewrite Extension (�����������)',
'ModRewriteInstalled' => '������������� Rewrite Extension (mod_rewrite];',
'Database' => '���� ���������',
'PHPExtensions' => 'PHP Extensions',
'Permissions' => '����������',
'ReadyToInstall' => '������� ��� �����������;',
'Requirements' => '� ����������� ������ �� ���� ��� �������� �� ����� ����������.',
'OK' => 'OK',
'Problem' => '��������',
'NotePHPExtensions' => '',
'ErrorPHPExtensions' => 'Your PHP installation appears to be missing the noted PHP extensions which are required by WackoWiki.',
'PCREwithoutUTF8' => 'PCRE is not compiled with UTF-8 support.',
'NotePermissions' => '�� ��������� ������������ �� ������������ �� ������ �������� ��������� ��� ������ %1, �� ����� �������� ���� �������� ��� WackoWiki. ��� �� �������� ����, ������ �� ����������� ��� � web server ��� ������ �� ������ �� ���� �� ������. ��� ��� ������ �� �� ����� ����, �� ������ �� �� �������������� �� �� ���� (�� ��������� ������������ �� ��� ��� ���).<br><br>����� <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> ��� ������������.',
'ErrorPermissions' => '���� �������� �� ��������� ������������ ��� ������ �������� �� ����� ��� ���������� ��� ���������� ������� ��� �� WackoWiki �� �������� �����. �� ���������� �������� ���� ��� ���������� ������������ �� ������������� �� �� ���� ��� ���������� ��� ���������� ��� ������� ���� ���������� ���.',
'ErrorMinPHPVersion' => '� ������ ��� PHP ������ �� ����� ���������� ��� <strong>' . PHP_MIN_VERSION . '</strong>, � ����������� ��� �������� �� ������ �� ����������� ������. ������ �� ������������ �� ��� ��� �������� PHP ������ ��� �������� ����� �� WackoWiki.',
'Ready' => '������������, ������������� ��� � ����������� ��� ������ �� ������ �� WackoWiki.
�� �������� ������� �� ��� ����������� ���� ���������� ����������������.',

/*
   Site Config Page
*/
'site-config' => '��������������� Site',
'SiteName' => '����� ��� Wiki',
'SiteNameDesc' => '�������� ��������� ��� ����� ��� �� Wiki site ���, ���� ������ �� �����
��� ������ <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePage' => '������ ������',
'HomePageDesc' => '�������������� �� ����� ��� ������ �� ���� � ������ ������ ���, ���� �� ����� � �������������� ������ ��� �� ������� �� ������� ���� ������������� �� site ��� ��� �� ������ �� ����� ��� <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault' => 'HomePage',
'MultiLang' => '������������ ����������',
'MultiLangDesc' => '� ������������ ���������� ��� ��������� �� ����� ������� �� ������������ ��������� ��������� ���� �� ��� ���� �����������. ��� ���� � ������� ����� ��������������, ���� �� ��������� ������������ �� ������������ ������� ������� ��� ���� ��� ���������� ������� ���� �������.',
'AllowedLang' => 'Allowed Languages',
'AllowedLangDesc' => 'It is recomended to select only the set of languages you want to use, other wise all languages are selected.',
'Admin' => '����� �����������',
'AdminDesc' => '��������� �� ����� ��� �����������, ���� ������ �� ����� ��� <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'Password' => '����������� �����������',
'PasswordDesc' => '������� ��� ����������� ��� ��� ����������� �� ����������� %1 ����������.',
'Password2' => '��������� �� �����������:',
'Mail' => '����������� ��������� �����������',
'MailDesc' => '�������� ��� ����������� ��������� ��� �����������.',
'Base' => '������ URL',
'BaseDesc' => '�� ������ URL ��� WackoWiki sites ���. �� ������� ��� ������� �� ���������� ��� ����, ���� ���� �� �������������� �� mod_rewrite � ��������� �� ��������� �� ��� ������ �.�.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => '��������� ������������',
'RewriteDesc' => '� ��������� ������������ �� ������������� ��� ��������������� �� WackoWiki �� ��� ����������� URL.',
'Enabled' => '������������:',
'ErrorAdminEmail' => '��� ����� ������� ��� ������ ����������� ���������!',
'ErrorAdminPasswordMismatch' => '�� ����������� ��� ����������!.',
'ErrorAdminPasswordShort' => '�� ����������� ��� ����������� ����� ���� �����, �� �������� ����� ����� %1 ����������!',
'WarningRewriteMode' => '�������!\n�� ������ ��� URL ��� � ������� ��� ���������� ������������ ��������� ������. ������� ��� ������� ������ ? ��� ������ URL ���� � ��������� ������������ ���� ����� - ���� ���� ��������� ��� �������.\n\n��� �� ���������� �� ����� ��� ��������� ������� �� OK.\n��� �� ����������� ���� ����� ��� �� �������� ��� ��������� ��� ������� �� CANCEL(�������).\n\n�� ����� ������� �� ����������� �� ����� ��� ���������, �������� �� ��������� ��� ������ �� ������������� ���������� �� ��� ����������� ��� WackoWiki.',
'ModRewriteStatusUnknown' => '�� ��������� ������������ ��� ������ �� ������������ ��� �� mod_rewrite ����� ��������������, ������ ���� ���� ��� �������� ��� ����� ����������������',

'LanguageArray'	=> [
	'bg' => 'bulgarian',
	'da' => 'danish',
	'nl' => 'dutch',
	'el' => 'greek',
	'en' => 'english',
	'et' => 'estonian',
	'fr' => 'french',
	'de' => 'german',
	'hu' => 'hungarian',
	'it' => 'italian',
	'pl' => 'polish',
	'pt' => 'portuguese',
	'ru' => 'russian',
	'es' => 'spanish',
],

/*
   Database Config Page
*/
'database-config' => '��������� �����',
'DBDriver' => '������',
'DBDriverDesc' => '� ������ ��� ����� ��� ������ �� ���������������. �� ������ �� ����� ���� ������������ ������ ��� ��� ����� ������������� <a href="http://gr.php.net/pdo" target="_blank">PDO</a>.',
'DBCharset' => 'Charset',
'DBCharsetDesc' => 'The database charset you want to use.',
'DBEngine' => 'Engine',
'DBEngineDesc' => 'The database engine you want to use. You must choose MyISAM engine if you do not have at least MariaDB 10 or MySql 5.6 (or greater) and InnoDB support available.',
'DBHost' => '�����������',
'DBHostDesc' => '�� ����� ��� ���������� ������ ��������� ��� ������ �� ����. ������� ����� <code>127.0.0.1</code> � <code>localhost</code> (�.�., �� ���� ����� ��� ����� �� WackoWiki site ���).',
'DBPort' => '����� (�����������)',
'DBPortDesc' => '� ������� ��� ������ ��� ���������� ������ ��������� ��� �� ����� ����������� �� ����, ������ �� ���� ��� ��������������
��� �������������� ������ ������.',
'DB' => '�� ����� ��� �����',
'DBDesc' => '� ���� ��������� ��� �� �������������� �� WackoWiki. ���� � ���� ������ �� ������� ��� ��� �� ������������!',
'DBUserDesc' => '�� ����� ��� �� ����������� ��� ������ ��� ��������������� ��� �� ��������� ���� ���� ���.',
'DBUser' => '����� ������',
'DBPasswordDesc' => '�� ����� ��� �� ����������� ��� ������ ��� ��������������� ��� �� ��������� ���� ���� ���.',
'DBPassword' => '�����������',
'PrefixDesc' => '������� ���� ��� ������� ��� ���������������� ��� �� WackoWiki. ���� ��� ��������� �� ������� ��������� ������������� ��� WackoWiki ��������������� ��� ���� ���� ��������� ����������� ����������� ��������� ����� ������� (e.g. wacko_).',
'Prefix' => '������� ������',
'ErrorNoDbDriverDetected' => '��� ����������� ������ ������ ���������, �������� ���� ������������� ��� �� ��� ���������� mysql, mysqli � pdo ��� php.ini ������ ���.',
'ErrorNoDbDriverSelected' => '��� ����������� ������ ������ ���������, �������� �������� ���� ��� ��� �����.',
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'database-install' => '����������� �����',
'TestingConfiguration' => '������� ���������',
'TestConnectionString' => '������� ��������� �������� �� ��� ���� ���������',
'TestDatabaseExists' => '������ ��� � ���� ��������� ��� �������� �������',
'InstallingTables' => '����������� �������',
'ErrorDBConnection' => '������ ��� �������� �� ��� ������������ ��� ������ ��� ��� ������� �� ��� ���� ���������, �������� ���������� ��� �������� ��� ����� �����.',
'ErrorDBExists' => '� ���� ��������� ��� ����� �������� ��� �������. ���������, ���������� �� ������� ���� ��� ��� �����������/���������� ��� WackoWiki!',
'To' => '���',
'AlterTable' => '������ ��� %1 ������',
'InsertRecord' => 'Inserting Record into %1 table',
'RenameTable' => 'Renaming %1 table',
'UpdateTable' => 'Updating %1 table',
'InstallingDefaultData' => '�������� ��������������� ���������',
'InstallingPagesBegin' => '�������� ��������������� �������',
'InstallingPagesEnd' => '���������� ��������� ��������������� �������',
'InstallingSystemAccount' => '�������� ������ <code>System</code>',
'InstallingDeletedAccount' => '�������� ������ <code>Deleted</code>',
'InstallingAdmin' => '�������� ����� �����������',
'InstallingAdminSetting' => '�������� ����� �����������',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => '�������� ������� ��������',
'LogoImage' => 'Logo image',
'InstallingConfigValues' => 'Adding Config Values',
'ConfigValues' => 'Config Values',
'ErrorInsertingPage' => '������ ���� ��� �������� ��� %1 �������',
'ErrorInsertingPageReadPermission' => '������ �������� ����������� ��������� ��� ��� %1 ������',
'ErrorInsertingPageWritePermission' => '������ �������� ����������� �������� ��� ��� %1 ������',
'ErrorInsertingPageCommentPermission' => '������ �������� ����������� ������� ��� ��� %1 ������',
'ErrorInsertingPageCreatePermission' => 'Error setting create permissions for %1 page',
'ErrorInsertingPageUploadPermission' => 'Error setting upload permissions for %1 page',
'ErrorInsertingDefaultMenuItem' => 'Error setting page %1 as default menu item',
'ErrorPageAlreadyExists' => '� %1 ������ ��� �������',
'ErrorAlteringTable' => '������ ������� %1 ������',
'ErrorInsertingRecord' => 'Error Inserting Record into %1 table',
'ErrorRenamingTable' => 'Error renaming %1 table',
'ErrorUpdatingTable' => 'Error updating %1 table',
'CreatingTable' => '���������� ������: %1',
'ErrorAlreadyExists' => '� %1 ������� ���',
'ErrorCreatingTable' => '������ ���� ��� ���������� ��� ������: %1, ��� ������� ���;',
'ErrorMovingRevisions' => '������ ����������� ��������� �������',
'MovingRevisions' => '���������� ��������� �� ������ �������',
'DeletingTables' => '�������� �������',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config' => '������� ������� ���������',
'FinalStep' => 'Final Step',
'Writing' => '������� ������� ���������',
'RemovingWritePrivilege' => '�������� ����������� ��������',
'InstallationComplete' => 'Installation Complete',
'ThatsAll' => '���� ���� ���! �������� ���� <a href="%1"> �� ����� �� WackoWiki site ���</a>.',
'SecurityConsiderations' => '��������� ���������',
'SecurityRisk' => '��� ����������� �� ���������� �� �������� �������� ��� %1 ���� ��� ���� �������. ��������� �� ������ ��������� ������ �� �������� ����� ���������!',
'RemoveSetupDirectory' => '�� ������ �� ���������� ��� �������� %1 ���� ��� � ���������� ������������ ���� �����������.',
'ErrorGivePrivileges' => '�� ������ ��������� %1 ��� ������ �� ����� ���������. �� ��������� �� ������ ���� web server ��� ��������� �������� ���� �� ������ ���� ���� �������� ��� WackoWiki, � ��� ���� ������ �� ����� %1<br>%2<br>; ��� �������� �� ���������� �� �������� �������� ��������, �.�. %3.<br>��, ��� ������ ����, ��� �������� �� �� ������, �� ������ �� ����������� �� �������� ������� �� ��� ��� ������ ��� �� �� ������������/��������� �� %1 ���� ���� �������� ��� WackoWiki. ���� �� ������ ����� �� WackoWiki site ��� �� ��������. ��� ���, �������� ������������� �� <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => '��� ������� ����, �� ��������� ������������ �� ����������� �� ������ �� ���������� ������ ���������, %1.
�������� �������������� ��� � web server ��� ���� �������� ��������� �������� ��� ������, ������ �� ��������� �� �� ��������������� �� �� ����.
����� ��� ����, ����� ��� ������������ ���: <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'WrittenAt' => '��������� ���� ',
'DontChange' => '��� �������� ��� ������ ��� wacko_version �� �� ����!',
'ConfigDescription' => 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain' => '��������� ����',

];
?>