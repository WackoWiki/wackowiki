<?php
$lang = [

/*
   Language Settings
*/
'Charset' => 'utf-8',
'LangISO' => 'pt',
'LangName' => 'Portugues',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages
	'category_page'		=> 'Categoria',
	'groups_page'		=> 'Grupos',
	'users_page'		=> 'Usuários',

	'search_page'		=> 'Buscar',
	'login_page'		=> 'Entrar',
	'account_page'		=> 'Settings',
	'registration_page'	=> 'Registration',
	'password_page'		=> 'Senha',

	'changes_page'		=> 'AlteraçõesRecentes',
	'comments_page'		=> 'RecentementeComentadas',
	'index_page'		=> 'ÍndicedePáginas',

	'random_page'		=> 'PáginaAleatória',
	#'help_page'		=> 'Help',
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
'Title' => 'WackoWiki Instalação',
'Continue' => 'Continuar',
'Back' => 'Voltar',
'Recommended' => 'recomendado',
'InvalidAction' => 'Invalid action',

/*
   Language Selection Page
*/
'lang' => 'Configuração de idioma',
'PleaseUpgradeToR5' => 'You aware to be running an old (pre %1) release of WackoWiki. To update to this release of WackoWiki, you must first update your installation to <code class="version">%2</code>.',
'UpgradeFromWacko' => 'Welcome to WackoWiki, it appears that you are upgrading from WackoWiki <code class="version">%1</code> to <code class="version">%2</code>.  The next few pages will guide you through the upgrade process.',
'FreshInstall' => 'Welcome to WackoWiki, you are about to install WackoWiki <code class="version">%1</code>.  The next few pages will guide you through the installation process.',
'PleaseBackup' => 'Please, <strong>backup</strong> your database, config file and all changed files such as those which have hacks and patches applied to them before starting upgrade process. This can save you from big headache.',
'LangDesc' => 'Escolha um idioma para o processo de instalação. Este idioma também será usado como o idioma padrão da sua instalação do WackoWiki.',

/*
   System Requirements Page
*/
'version-check' => 'Requisitos de sistema',
'PhpVersion' => 'PHP Version',
'PhpDetected' => 'Detected PHP',
'ModRewrite' => 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled' => 'Rewrite Extension (mod_rewrite) Installed?',
'Database' => 'Base de dados',
'PhpExtensions' => 'PHP Extensions',
'Permissions' => 'Permissões',
'ReadyToInstall' => 'Pronto para instalar?',
'Requirements' => 'Seu servidor deve atender aos requisitos listados abaixo.',
'OK' => 'OK',
'Problem' => 'Problema',
'NotePhpExtensions' => '',
'ErrorPhpExtensions' => 'Your PHP installation appears to be missing the noted PHP extensions which are required by WackoWiki.',
'PcreWithoutUtf8' => 'PCRE is not compiled with UTF-8 support.',
'NotePermissions' => 'This installer will try to write the configuration data to the file %1, located in your WackoWiki directory. In order for this to work, you must make sure the web server has write access to that file.  If you can\'t do this, you will have to edit the file manually (the installer will tell you how).<br><br>See <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'ErrorPermissions' => 'It would appear that the installer cannot automatically set the required file permissions for WackoWiki to work correctly. You will be prompted later in the installation process to manually configure the required file permissions on your server.',
'ErrorMinPhpVersion' => 'The PHP Version must be greater than <strong>' . PHP_MIN_VERSION . '</strong>, your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready' => 'Parabéns, parece que o seu servidor é capaz de executar o WackoWiki. As próximas páginas irão levá-lo através do processo de configuração.',

/*
   Site Config Page
*/
'config-site' => 'Configuração do Site',
'SiteName' => 'Nome da wiki',
'SiteNameDesc' => 'Please enter the name of your Wiki site.',
'HomePage' => 'Home Page',
'HomePageDesc' => 'Enter the name you would like your home page to have, this will be the default page users will see when they visit your site and should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault' => 'HomePage',
'MultiLang' => 'Multi Language Mode',
'MultiLangDesc' => 'O modo multilíngüe permite ter páginas com configurações de idioma diferentes em uma única instalação. Se este modo estiver ativado, o instalador criará itens de menu iniciais para todos os idiomas disponíveis na distribuição.',
'AllowedLang' => 'Allowed Languages',
'AllowedLangDesc' => 'Recomenda-se que seleccione apenas o conjunto de idiomas que pretende utilizar, caso contrário todos os idiomas são seleccionados.',
'Admin' => 'Nome do Administrador',
'AdminDesc' => 'Enter the admins username, this should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'Password' => 'Senha de Administrador',
'PasswordDesc' => 'Escolha uma senha para o administrador com um mínimo de %1 caracteres.',
'Password2' => 'Repetir Senha:',
'Mail' => 'Admin Email Address',
'MailDesc' => 'Digite o endereço de e-mail dos administradores.',
'Base' => 'Base URL',
'BaseDesc' => 'Your WackoWiki site base URL.  Page names get appended to it, so if you are using mod_rewrite the address should end with a forward slash i.e.</p><ul><li><strong><code>http://example.com/</code></strong></li><li><strong><code>http://example.com/wiki/</code></strong></li></ul>',
'Rewrite' => 'Rewrite Mode',
'RewriteDesc' => 'Rewrite mode should be enabled if you are using WackoWiki with URL rewriting.',
'Enabled' => 'Enabled:',
'ErrorAdminEmail' => 'Você digitou um endereço de e-mail inválido!',
'ErrorAdminPasswordMismatch' => 'As senhas não coincidem!',
'ErrorAdminPasswordShort' => 'A senha do administrador é muito curta, o comprimento mínimo é de %1 caracteres!',
'WarningRewriteMode' => 'ATTENTION!\nYour base URL and rewrite-mode settings looks suspicious. Usually there is no ? mark in the base URL if rewrite-mode is set - but in your case there is one.\n\nTo continue with these settings click OK.\nTo return to the form and change your settings click CANCEL.\n\nIf you are about to proceed with these settings, please note that they COULD cause problems with your WackoWiki installation.',
'ModRewriteStatusUnknown' => 'The installer cannot verify that mod_rewrite is enabled, however this does not mean it is disabled',

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
'config-database' => 'Configuração do banco de dados',
'DbDriver' => 'Driver',
'DbDriverDesc' => 'The database driver you want to use. You must choose a legacy driver if you do not have <a href="https://secure.php.net/pdo" target="_blank">PDO</a> installed.',
'DbCharset' => 'Charset',
'DbCharsetDesc' => 'The database charset you want to use.',
'DbEngine' => 'Engine',
'DbEngineDesc' => 'The database engine you want to use.',
'DbHost' => 'Host',
'DbHostDesc' => 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort' => 'Port (Optional)',
'DbPortDesc' => 'The port number your database server is accessible through, leave it blank to use the default port number.',
'Db' => 'Database Name',
'DbDesc' => 'The database WackoWiki should use. This database needs to exist already once you continue!',
'DbUserDesc' => 'Name of the user used to connect to your database.',
'DbUser' => 'User Name',
'DbPasswordDesc' => 'Password of the user used to connect to your database.',
'DbPassword' => 'Password',
'PrefixDesc' => 'Prefix of all tables used by WackoWiki. This allows you to run multiple WackoWiki installations using the same database by configuring them to use different table prefixes (e.g. wacko_).',
'Prefix' => 'Table Prefix',
'ErrorNoDbDriverDetected' => 'No database driver has been detected, please enable either the mysql, mysqli or pdo extension in your php.ini file.',
'ErrorNoDbDriverSelected' => 'No database driver has been selected, please pick one from the list.',
'DeleteTables' => 'Eliminar tabelas existentes?',
'DeleteTablesDesc' => 'ATTENTION! If you proceed with this option selected all current wiki data will be erased from your database.  This cannot be undone unless you manually restore the data from a backup.',
'ConfirmTableDeletion' => 'Are you sure you want to delete all current wiki tables?',

/*
   Database Installation Page
*/
'install-database' => 'Instalação do banco de dados',
'TestingConfiguration' => 'Teste de Configuração',
'TestConnectionString' => 'Testar as configurações de conexão do banco de dados',
'TestDatabaseExists' => 'Verificar se o banco de dados especificado existe',
'TestDatabaseVersion' => 'Verificação dos requisitos mínimos da versão da base de dados',
'InstallingTables' => 'Instalando Tabelas',
'ErrorDbConnection' => 'Houve um problema com os detalhes de ligação à base de dados que especificou, por favor volte atrás e verifique se estão correctos.',
'ErrorDbExists' => 'A base de dados que configurou não foi encontrada. Lembre-se, ela precisa existir antes que você possa instalar/atualizar o WackoWiki!',
'ErrorDatabaseVersion' => 'A versão da base de dados é %1 mas requer pelo menos %2.',
'To' => 'to',
'AlterTable' => 'Alterando %1 tabela',
'InsertRecord' => 'Inserção do registro na tabela %1',
'RenameTable' => 'Renomear tabela %1',
'UpdateTable' => 'Atualização da tabela %1',
'InstallingDefaultData' => 'Adding Default Data',
'InstallingPagesBegin' => 'Adding Default Pages',
'InstallingPagesEnd' => 'Finished Adding Default Pages',
'InstallingSystemAccount' => 'Adding <code>System</code> User',
'InstallingDeletedAccount' => 'Adding <code>Deleted</code> User',
'InstallingAdmin' => 'Adding Admin User',
'InstallingAdminSetting' => 'Adding Admin User Preferences',
'InstallingAdminGroup' => 'Adding Admins Group',
'InstallingAdminGroupMember' => 'Adding Admins Group Member',
'InstallingEverybodyGroup' => 'Adding Everybody Group',
'InstallingModeratorGroup' => 'Adding Moderator Group',
'InstallingReviewerGroup' => 'Adding Reviewer Group',
'InstallingLogoImage' => 'Adding Logo Image',
'LogoImage' => 'Logo image',
'InstallingConfigValues' => 'Adding Config Values',
'ConfigValues' => 'Config Values',
'ErrorInsertingPage' => 'Error inserting %1 page',
'ErrorInsertingPagePermission' => 'Error setting permission for %1 page',
'ErrorInsertingDefaultMenuItem' => 'Error setting page %1 as default menu item',
'ErrorPageAlreadyExists' => 'The %1 page already exists',
'ErrorAlteringTable' => 'Error altering %1 table',
'ErrorInsertingRecord' => 'Error Inserting Record into %1 table',
'ErrorRenamingTable' => 'Error renaming %1 table',
'ErrorUpdatingTable' => 'Error updating %1 table',
'CreatingTable' => 'Creating %1 table',
'ErrorAlreadyExists' => 'The %1 already exists',
'ErrorCreatingTable' => 'Error creating %1 table, does it already exist?',
'ErrorMovingRevisions' => 'Error moving revision data',
'MovingRevisions' => 'Moving data to revisions table',
'DeletingTables' => 'Excluindo Tabelas',
'DeletingTablesEnd' => 'Finished Deleting Tables',
'ErrorDeletingTable' => 'Error deleting %1 table, the most likely reason is that the table does not exist in which case you can ignore this warning.',
'DeletingTable' => 'Deleting %1 table',

/*
   Write Config Page
*/
'write-config' => 'Escrever ficheiro de configuração',
'FinalStep' => 'Passo final',
'Writing' => 'Writing Configuration File',
'RemovingWritePrivilege' => 'Removing Write Privilege',
'InstallationComplete' => 'Instalação completa',
'ThatsAll' => 'That\'s all! You can now <a href="%1">view your WackoWiki site</a>.',
'SecurityConsiderations' => 'Considerações de segurança',
'SecurityRisk' => 'You are advised to remove write access to %1 again now that it\'s been written. Leaving the file writable can be a security risk!<br>i.e. %2',
'RemoveSetupDirectory' => 'You should delete the %1 directory now that the installation process has been completed.',
'ErrorGivePrivileges' => 'The configuration file %1 could not be written. You will need to give your web server temporary write access to either your WackoWiki directory, or a blank file called %1<br>%2<br>; don\'t forget to remove write access again later, i.e. %3.<br>If, for any reason, you can\'t do this, you\'ll have to copy the text below into a new file and save/upload it as %1 into the WackoWiki directory. Once you\'ve done this, your WackoWiki site should work. If not, please visit <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'NextStep' => 'In the next step, the installer will try to write the updated configuration file, %1.  Please make sure the web server has write access to the file, or you will have to edit it manually.  Once again, see  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> for details.',
'WrittenAt' => 'written at ',
'DontChange' => 'do not change wacko_version manually!',
'ConfigDescription' => 'detailed description https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain' => 'Tente novamente',

];
