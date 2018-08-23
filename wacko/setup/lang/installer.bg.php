<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'windows-1251',
'LangISO' => 'bg',
'LangName' => 'Bulgarian',

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

	#'help_page'			=> '�����',
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
'Title' => '���������� �� WackoWiki',
'Continue' => '�����������',
'Back' => 'Back',
'Recommended' => '����������',
'InvalidAction' => 'Invalid action',

/*
   Language Selection Page
*/
'lang' => '������� ���������',
'PleaseUpgradeToR5' => 'You aware to be running an old (pre 5.0.0) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to <code class="version">5.0.x</code>.',
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <code class="version">%1</code> to <code class="version">%2</code>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <code class="version">%1</code>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => '����, ��������� �� ����� �� ������ ����� (��) ��, ���������������� ���� � �������, ��������� �� ��� ������� (��������,  ����),  ������ ��� �� � �����!',
'LangDesc' => '�������� ����. ��� �� �� ��������� �� ������������, � ���� � �� ����� ���� �� ������������ �� ����� WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'System Requirements',
'PHPVersion' => 'PHP Version',
'PHPDetected' => 'Detected PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Extension (mod_rewrite) Installed?',
'Database' => 'Database',
'PHPExtensions' => 'PHP Extensions',
'Permissions' => 'Permissions',
'ReadyToInstall' => 'Ready to Install?',
'Requirements' => 'Your server must meet the requirements listed below.',
'OK' => 'OK',
'Problem' => 'Problem',
'NotePHPExtensions' => '',
'ErrorPHPExtensions' => 'Your PHP installation appears to be missing the noted PHP extensions which are required by WackoWiki.',
'PCREwithoutUTF8' => 'PCRE is not compiled with UTF-8 support.',
'NotePermissions' => '���������� �� ����������� �� ����� �� ������ ����������� ��� ���� %1, ���������� � �������� ����������, ������ � WackoWiki. �� �� ����� ����, ���� ���� ������ �� � �������� �� ����� ���� ��������� ������/������! �� �� ���� ��������, ������ ���� �������� �� �� �������� ������� �� ������ �� (������� ��) ���� ����.<br><br>��. <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly.  You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPHPVersion' => 'The PHP Version must be greater than <strong>' . PHP_MIN_VERSION . '</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Congratulations, it appears that your server is capable of running WackoWiki.  The next few pages will take you through the configuration process.',

/*
   Site Config Page
*/
'site-config' => '��������� �� �����',
'SiteName' => '�������� ����� �� ��������',
'SiteNameDesc' => '��� �� ����� Wiki.',
'HomePage' => '������ ��������',
'HomePageDesc' => '������ �������� �� WackoWiki.  ������ �� �  � <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">�������</a>.',
'HomePageDefault' => 'HomePage',
'MultiLang' => '&laquo;�����������&raquo; �����',
'MultiLangDesc' => '&laquo;�����������&raquo; �����, ���������� ������ �� ������� �����. ��� � �������, ������������ �� ������������ �������� �� ������� �������� �����.',
'AllowedLang' => 'Allowed Languages',
'AllowedLangDesc' => 'It is recomended to select only the set of languages you want to use, other wise all languages are selected.',
'Admin' => '���',
'AdminDesc' => '�������� ���. ���� �� ��� <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (��� ��������).',
'Password' => '��� ������',
'PasswordDesc' => '�������� ������ ( 9 � ������ ������� )',
'Password2' => '������������� �� ��������:',
'Mail' => 'Admin Email Address',
'MailDesc' => '����� �� ������������ ���� (email) �� ��������������.',
'Base' => '����� URL',
'BaseDesc' => '����� URL  �� ������ ���������� ��  WackoWiki. ������� �� ���������� �� ������������� ��� ���� � forward slash, ��� �� ���� �� �� ������ mod_rewrite i.e.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => 'Rewrite-�����',
'RewriteDesc' => 'Rewrite-����� ������ �� � �������, ��� �������� mod_rewrite.',
'Enabled' => '�������:',
'ErrorAdminEmail' => '�������� �������� �����!',
'ErrorAdminPasswordMismatch' => '�������� �� �������������� �� �������� ����!',
'ErrorAdminPasswordShort' => 'The admin ����� � ������, the minimum length is %1 characters!',
'WarningRewriteMode' => '��������!\n��������� �������� URL � Rewrite-������ �������� �������������. ������ ��� ���������� Rewrite �� ������ ����� ? � ������� URL, �� � ��� �� ����.\n\n��� ����������� ����������� � �������� ����������� ������� ��.\n��� ����, ����� ��������� � ����� � �� ���������, ������� ������.\n\n���� �� ������ ���� ������, �������, ��� ����� ��������� ����� �������� �������� ������������������� ����� �����������.',
'ModRewriteStatusUnknown' => 'The installer cannot veriry that mod_rewrite is enabled, however this does not mean it is disabled',

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
'database-config' => '��������� �� ��',
'DBDriver' => 'Driver',
'DBDriverDesc' => 'The database driver you want to use. You must choose a legacy driver if you do not have <a href="http://de2.php.net/pdo" target="_blank">PDO</a> installed.',
'DBCharset' => 'Charset',
'DBCharsetDesc' => 'The database charset you want to use.',
'DBEngine' => 'Engine',
'DBEngineDesc' => 'The database engine you want to use. You must choose MyISAM engine if you do not have at least MariaDB 10 or MySql 5.6 (or greater) and InnoDB support available.',
'DBHost' => '��� (hostname) �� ��',
'DBHostDesc' => 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DBPort' => 'Port (Optional)',
'DBPortDesc' => 'The port number your database server is accessable through, leave it blank to use the default port number.',
'DB' => '��',
'DBDesc' => 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DBUserDesc' => 'Name of the user used to connect to your database.',
'DBUser' => '��� (username)',
'DBPasswordDesc' => 'Password of the user used to connect to your database.',
'DBPassword' => '�����a (password)',
'PrefixDesc' => '������� �� ��������� �� Wacko. ���� ���� ���������� �� ������� WackoWiki �� ���� ��, ���� ���� �������� �������� (e.g. wacko_).',
'Prefix' => '������� �� ���������',
'ErrorNoDbDriverDetected' => 'No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.',
'ErrorNoDbDriverSelected' => 'No database driver has been selected, please pick one from the list.',
'DeleteTables' => 'Delete Existing Tables?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'database-install' => 'Database Installation',
'TestingConfiguration' => '���� �� �����������',
'TestConnectionString' => '�������� �� �������� � ��',
'TestDatabaseExists' => 'Checking if the database you specified exists',
'InstallingTables' => 'Installing Tables',
'ErrorDBConnection' => 'There was a problem with the database connection details you specified, please go back and check they are correct.',
'ErrorDBExists' => '�� � ������� ������ ��. ��������� ���� � ��������� �������������!',
'To' => '->',
'AlterTable' => 'Altering <code>%1</code> Table',
'RenameTable' => 'Renaming <code>%1</code> Table',
'UpdateTable' => 'Updating <code>%1</code> Table',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Adding System User',
'InstallingAdmin' => '�������� ��������������� ����������',
'InstallingAdminSetting' => '�������� ��������������� ����������',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Adding Logo Image',
'InstallingConfigValues' => 'Adding Config Values',
'ErrorInsertingPage' => 'Error inserting <code>%1</code> page',
'ErrorInsertingPageReadPermission' => 'Error setting read permission for <code>%1</code> page',
'ErrorInsertingPageWritePermission' => 'Error setting write permission for <code>%1</code> page',
'ErrorInsertingPageCommentPermission' => 'Error setting comment permissions for <code>%1</code> page',
'ErrorInsertingPageCreatePermission' => 'Error setting create permissions for <code>%1</code> page',
'ErrorInsertingPageUploadPermission' => 'Error setting upload permissions for <code>%1</code> page',
'ErrorInsertingDefaultMenuItem' => 'Error setting page <code>%1</code> as default menu item',
'ErrorPageAlreadyExists' => 'The <code>%1</code> page already exists',
'ErrorAlteringTable' => 'Error altering <code>%1</code> table',
'ErrorRenamingTable' => 'Error renaming <code>%1</code> table',
'ErrorUpdatingTable' => 'Error updating <code>%1</code> table',
'CreatingTable' => '��������� ������� <code>%1</code>',
'ErrorAlreadyExists' => 'The <code>%1</code> already exists',
'ErrorCreatingTable' => 'Error creating <code>%1</code> table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => '����������� ������� ������ � ������� revisions',
'DeletingTables' => 'Deleting Tables',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting <code>%1</code> table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting <code>%1</code> table',

/*
   Write Config Page
*/
'write-config' => 'Write Config File',
'FinalStep' => 'Final Step',
'Writing' => '����� �� ���������������� ����',
'RemovingWritePrivilege' => 'Removing Write Privilege',
'InstallationComplete' => 'Installation Complete',
'ThatsAll' => '���! �������� �������. ���� ������ <a href="%1">WackoWiki site</a>.',
'SecurityConsiderations' => 'Security Considerations',
'SecurityRisk' => '�� ���������� ������ �� ��������� ������� ������� �� ������ �� %1 �� �������. ������ �� "���������"!',
'RemoveSetupDirectory' => 'You should delete the <code>setup/</code> directory now that the installation process has been completed.',
'ErrorGivePrivileges' => '���������������� ���� %1 �� ���� �� �� ������. ������ ���� �������� �� �� �������� ������� �� ������ �� (������� ��) ���� ���� ��� �� �� ������� ������ ���� %1<br>%2<br>; �� ���������� ������ �� ��������� ������� �������, �.e. %3.<br>��� ���� �� �����, �� ������ �� �������� � �������� ��������� ����� � ��� ������ ���� �� ����� �������� � ����� �� �� ����������� � ��� %1 �� ������� � �������� ���������� �� Wacko. ��� ��������, ����� (����.) <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> ��� (�����) <a href="https://wackowiki.org/doc/Doc/English/Installation">WackoWiki:������������/���������</a>',
'NextStep' => '�� ���������� ������, ������������ �� ����� �� ������ ��������� ���������������� ����, %1. ���������������� ���� %1 ��  ��������� � �������� ����������, ������ � WackoWiki. �� �� ����� ���������, ���� ���� ������ �� � �������� �� ����� ���� ��������� ������/������! �� �� ���� ��������, ������ ���� �������� �� �� �������� ������� �� ������ �� ���� ����. � �������� ������ �� ������ �� �������� ��������� �� ����. ������, ���������� �� �����������, ����� � �� ���������, �� ��� ��� <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>.',
'WrittenAt' => '������� ',
'DontChange' => '�� ���������� wacko_version �����!',
'ConfigDescription' => 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain' => '��� ����',

];
?>