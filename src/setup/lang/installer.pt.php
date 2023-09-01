<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'pt',
'LangLocale'	=> 'pt_PT',
'LangName'		=> 'Portugues',
'LangDir'		=> 'ltr',

/*
   Config Defaults
*/
'ConfigDefaults'	=> [
	// pages (tag)
	'category_page'		=> 'Categoria',
	'groups_page'		=> 'Grupos',
	'users_page'		=> 'Usuários',

	'search_page'		=> 'Buscar',
	'login_page'		=> 'Entrar',
	'account_page'		=> 'Configurações',
	'registration_page'	=> 'CriarConta',
	'password_page'		=> 'Senha',

	'changes_page'		=> 'AlteraçõesRecentes',
	'comments_page'		=> 'RecentementeComentadas',
	'index_page'		=> 'ÍndicedePáginas',

	'random_page'		=> 'PáginaAleatória',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',

	// time
	#'date_format'					=> 'dd.MM.yyyy',
	#'time_format'					=> 'HH:mm',
	#'time_format_seconds'			=> 'HH:mm:ss',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki Instalação',
'TitleUpdate'					=> 'WackoWiki Update',
'Continue'						=> 'Continuar',
'Back'							=> 'Voltar',
'Recommended'					=> 'recomendado',
'InvalidAction'					=> 'Invalid action',

/*
   Language Selection Page
*/
'lang'							=> 'Configuração de idioma',
'PleaseUpgradeToR6'				=> 'Está a correr uma versão antiga (pré %2) do WackoWiki (%1). Para actualizar para esta nova versão do WackoWiki, deve primeiro actualizar a sua instalação para %2.',
'UpgradeFromWacko'				=> 'Bem-vindo a WackoWiki, parece que está a passar de WackoWiki %1 para %2.  As próximas páginas irão guiá-lo através do processo de actualização.',
'FreshInstall'					=> 'Bem-vindo ao WackoWiki, está prestes a instalar o WackoWiki %1.  As próximas páginas irão guiá-lo através do processo de instalação.',
'PleaseBackup'					=> 'Por favor, <strong>backup</strong> a sua base de dados, ficheiro de configuração e todos os ficheiros alterados, tais como os que têm hacks e patches aplicados a eles antes de iniciar o processo de actualização. Isto pode salvá-lo de uma grande dor de cabeça.',
'LangDesc'						=> 'Escolha um idioma para o processo de instalação. Este idioma também será usado como o idioma padrão da sua instalação do WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Requisitos de sistema',
'PhpVersion'					=> 'PHP Version',
'PhpDetected'					=> 'Detected PHP',
'ModRewrite'					=> 'Apache Rewrite Extension (Optional)',
'ModRewriteInstalled'			=> 'Rewrite Extension (mod_rewrite) Installed?',
'Database'						=> 'Base de dados',
'PhpExtensions'					=> 'PHP Extensions',
'Permissions'					=> 'Permissões',
'ReadyToInstall'				=> 'Pronto para instalar?',
'Requirements'					=> 'Seu servidor deve atender aos requisitos listados abaixo.',
'OK'							=> 'OK',
'Problem'						=> 'Problema',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'A sua instalação PHP parece estar a faltar as extensões de PHP assinaladas que são requeridas por WackoWiki.',
'PcreWithoutUtf8'				=> 'O módulo PCRE do PHP parece ter sido compilado sem suporte PCRE_UTF8.',
'NotePermissions'				=> 'Este instalador tentará escrever os dados de configuração no ficheiro %1, localizado no seu diretório WackoWiki. Para que isto funcione, tem de se certificar que o servidor web tem acesso de escrita a esse ficheiro. Se não o conseguir fazer, terá de editar o ficheiro manualmente (o instalador dir-lhe-á como).<br><br>Veja <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> para detalhes.',
'ErrorPermissions'				=> 'Parece que o instalador não pode definir automaticamente as permissões de arquivo necessárias para que o WackoWiki funcione correctamente. Ser-lhe-á pedido mais tarde no processo de instalação para configurar manualmente as permissões de ficheiro necessárias no seu servidor.',
'ErrorMinPhpVersion'			=> 'A Versão PHP deve ser maior que <strong>' . PHP_MIN_VERSION . '</strong>, o seu servidor parece estar a correr uma versão anterior. Tem de actualizar para uma versão mais recente do PHP para que o WackoWiki funcione correctamente.',
'Ready'							=> 'Parabéns, parece que o seu servidor é capaz de executar o WackoWiki. As próximas páginas irão levá-lo através do processo de configuração.',

/*
   Site Config Page
*/
'config-site'					=> 'Configuração do Site',
'SiteName'						=> 'Nome da wiki',
'SiteNameDesc'					=> 'Por favor, introduza o nome do seu sítio Wiki.',
'SiteNameDefault'				=> 'AMinhaWiki',
'HomePage'						=> 'Home Page',
'HomePageDesc'					=> 'Introduza o nome que gostaria que a sua página inicial tivesse, esta será a página padrão que os utilizadores verão quando visitarem o seu site.',
'HomePageDefault'				=> 'HomePage',
'MultiLang'						=> 'Multi Language Mode',
'MultiLangDesc'					=> 'O modo multilíngüe permite ter páginas com configurações de idioma diferentes em uma única instalação. Se este modo estiver ativado, o instalador criará itens de menu iniciais para todos os idiomas disponíveis na distribuição.',
'AllowedLang'					=> 'Allowed Languages',
'AllowedLangDesc'				=> 'Recomenda-se que seleccione apenas o conjunto de idiomas que pretende utilizar, caso contrário todos os idiomas são seleccionados.',
'Admin'							=> 'Nome do Administrador',
'AdminDesc'						=> 'Enter the admins username, this should be a <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (e.g. <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'O Nome de Utilizador deve ser constituído por %1 a %2 caracteres e usar somente caracteres alfanuméricos.',
'NameCamelCaseOnly'				=> 'O Nome de Utilizador deve ser constituído por %1 a %2 caracteres e WikiName formatted.',
'Password'						=> 'Senha de Administrador',
'PasswordDesc'					=> 'Escolha uma senha para o administrador com um mínimo de %1 caracteres.',
'PasswordConfirm'				=> 'Repetir Senha:',
'Mail'							=> 'Admin Email Address',
'MailDesc'						=> 'Digite o endereço de e-mail dos administradores.',
'Base'							=> 'Base URL',
'BaseDesc'						=> 'O URL base do teu site WackoWiki.  Os nomes das páginas são anexados a ele, por isso, se estiver a usar mod_rewrite, o endereço deve terminar com uma barra, ou seja</p><ul><li><strong><code>https://example.com/</code></strong></li><li><strong><code>https://example.com/wiki/</code></strong></li></ul>',
'Rewrite'						=> 'Rewrite Mode',
'RewriteDesc'					=> 'O modo de reescrita deve ser ativado se estiver a utilizar o WackoWiki com reescrita de URL.',
'Enabled'						=> 'Ativado:',
'ErrorAdminEmail'				=> 'Você digitou um endereço de e-mail inválido!',
'ErrorAdminPasswordMismatch'	=> 'As senhas não coincidem!',
'ErrorAdminPasswordShort'		=> 'A senha do administrador é muito curta, o comprimento mínimo é de %1 caracteres!',
'ModRewriteStatusUnknown'		=> 'O instalador não pode verificar se o mod_rewrite está activado, mas isso não significa que esteja desactivado',

/*
   Database Config Page
*/
'config-database'				=> 'Configuração do banco de dados',
'DbDriver'						=> 'Driver',
'DbDriverDesc'					=> 'The database driver you want to use.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'The database charset you want to use.',
'DbEngine'						=> 'Engine',
'DbEngineDesc'					=> 'The database engine you want to use.',
'DbHost'						=> 'Servidor',
'DbHostDesc'					=> 'The host your database server is running on. Usually <code>127.0.0.1</code> or <code>localhost</code> (ie, the same machine your WackoWiki site is on).',
'DbPort'						=> 'Port (Optional)',
'DbPortDesc'					=> 'O número da porta pela qual o seu servidor de base de dados está acessível, deixe-o em branco para usar o número da porta padrão.',
'DbName'						=> 'Database Name',
'DbNameDesc'					=> 'A base de dados WackoWiki deve ser utilizada. Esta base de dados precisa de existir já depois de continuar!',
'DbUser'						=> 'Nome de utilizador',
'DbUserDesc'					=> 'Nome do utilizador utilizado para se ligar à sua base de dados.',
'DbPassword'					=> 'Palavra-chave',
'DbPasswordDesc'				=> 'Senha do utilizador utilizada para se ligar à sua base de dados.',
'Prefix'						=> 'Table Prefix',
'PrefixDesc'					=> 'Prefixo de todas as tabelas utilizadas pelo WackoWiki. Isto permite-lhe executar várias instalações do WackoWiki utilizando a mesma base de dados, configurando-as para utilizarem diferentes prefixos de tabelas (por exemplo, wacko_).',
'ErrorNoDbDriverDetected'		=> 'Nenhum driver de base de dados foi detectado, por favor active ou a extensão mysqli ou pdo_mysql no seu ficheiro php.ini.',
'ErrorNoDbDriverSelected'		=> 'Não foi seleccionado nenhum condutor de base de dados, por favor escolha um da lista.',
'DeleteTables'					=> 'Eliminar tabelas existentes?',
'DeleteTablesDesc'				=> 'ATENÇÃO! Se proceder com esta opção seleccionada, todos os dados wiki actuais serão apagados da sua base de dados.  Isto não pode ser desfeito a menos que restaure manualmente os dados a partir de uma cópia de segurança.',
'ConfirmTableDeletion'			=> 'Tem a certeza de que quer apagar todas as tabelas wiki actuais?',

/*
   Database Installation Page
*/
'install-database'				=> 'Instalação do banco de dados',
'TestingConfiguration'			=> 'Teste de Configuração',
'TestConnectionString'			=> 'Testar as configurações de conexão do banco de dados',
'TestDatabaseExists'			=> 'Verificar se o banco de dados especificado existe',
'TestDatabaseVersion'			=> 'Verificação dos requisitos mínimos da versão da base de dados',
'InstallTables'					=> 'Instalando Tabelas',
'ErrorDbConnection'				=> 'Houve um problema com os detalhes de ligação à base de dados que especificou, por favor volte atrás e verifique se estão correctos.',
'ErrorDatabaseVersion'			=> 'A versão da base de dados é %1 mas requer pelo menos %2.',
'To'							=> 'para',
'AlterTable'					=> 'Alterando %1 tabela',
'InsertRecord'					=> 'Inserção do registro na tabela %1',
'RenameTable'					=> 'Renomear tabela %1',
'UpdateTable'					=> 'Atualização da tabela %1',
'InstallDefaultData'			=> 'Adding Default Data',
'InstallPagesBegin'				=> 'Adding Default Pages',
'InstallPagesEnd'				=> 'Terminou a adição de páginas predefinidas',
'InstallSystemAccount'			=> 'Adding <code>System</code> User',
'InstallDeletedAccount'			=> 'Adding <code>Deleted</code> User',
'InstallAdmin'					=> 'Adding Admin User',
'InstallAdminSetting'			=> 'Adding Admin User Preferences',
'InstallAdminGroup'				=> 'Adding Admins Group',
'InstallAdminGroupMember'		=> 'Adding Admins Group Member',
'InstallEverybodyGroup'			=> 'Adding Everybody Group',
'InstallModeratorGroup'			=> 'Adding Moderator Group',
'InstallReviewerGroup'			=> 'Adding Reviewer Group',
'InstallLogoImage'				=> 'Adding Logo Image',
'LogoImage'						=> 'Logo image',
'InstallConfigValues'			=> 'Adding Config Values',
'ConfigValues'					=> 'Config Values',
'ErrorInsertPage'				=> 'Erro ao inserir página %1',
'ErrorInsertPagePermission'		=> 'Erro ao definir permissão para a página %1',
'ErrorInsertDefaultMenuItem'	=> 'Erro ao definir a página %1 como item de menu predefinido',
'ErrorPageAlreadyExists'		=> 'A página %1 já existe',
'ErrorAlterTable'				=> 'Erro na alteração da tabela %1',
'ErrorInsertRecord'				=> 'Erro ao inserir registo na tabela %1',
'ErrorRenameTable'				=> 'Erro ao renomear tabela %1',
'ErrorUpdatingTable'			=> 'Erro ao atualizar a tabela %1',
'CreatingTable'					=> 'Criar tabela %1',
'ErrorAlreadyExists'			=> 'The %1 already exists',
'ErrorCreatingTable'			=> 'Erro ao criar a tabela %1, ela já existe?',
'DeletingTables'				=> 'Excluindo Tabelas',
'DeletingTablesEnd'				=> 'Terminou a eliminação de tabelas',
'ErrorDeletingTable'			=> 'Erro ao eliminar a tabela %1, a razão mais provável é que a tabela não existe, caso em que se pode ignorar este aviso.',
'DeletingTable'					=> 'Eliminar tabela %1',
'NextStep'						=> 'No passo seguinte, o instalador irá tentar escrever o ficheiro de configuração atualizado, %1. Certifique-se de que o servidor Web tem acesso de escrita ao ficheiro, ou terá de o editar manualmente. Mais uma vez, ver <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> para pormenores.',

/*
   Write Config Page
*/
'write-config'					=> 'Escrever ficheiro de configuração',
'FinalStep'						=> 'Passo final',
'Writing'						=> 'Escrever ficheiro de configuração',
'RemovingWritePrivilege'		=> 'Remover o privilégio de escrita',
'InstallationComplete'			=> 'Instalação completa',
'ThatsAll'						=> 'E é tudo! Pode agora <a href="%1">ver o seu site WackoWiki</a>.',
'SecurityConsiderations'		=> 'Considerações de segurança',
'SecurityRisk'					=> 'Aconselha-se a remover novamente o acesso de escrita a %1 agora que foi escrito. Deixar o ficheiro gravável pode ser um risco de segurança!<br>i.e. %2',
'RemoveSetupDirectory'			=> 'Deve eliminar o directório %1 agora que o processo de instalação foi concluído.',
'ErrorGivePrivileges'			=> 'O ficheiro de configuração %1 não pôde ser escrito. Terá de dar ao seu servidor web acesso temporário de escrita ao seu diretório WackoWiki, ou a um ficheiro em branco chamado %1<br>%2<br><br>Não se esqueça de voltar a remover o acesso de escrita mais tarde, i.e.<br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Se, por qualquer razão, não o conseguires fazer, terás de copiar o texto abaixo para um novo ficheiro e guardá-lo/carregá-lo como %1 no diretório do WackoWiki. Assim que tiveres feito isto, o teu site WackoWiki deverá funcionar. Caso contrário, visite <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a>',
'ErrorPrivilegesUpgrade'		=> 'Depois de ter feito isto, o seu site WackoWiki deve funcionar. Caso contrário, visite <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'written at ',
'DontChange'					=> 'não altere a wacko_version manualmente!',
'ConfigDescription'				=> 'descrição detalhada https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Tente novamente',

];
