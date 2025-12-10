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

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'Categoria',
	'groups_page'		=> 'Grupos',
	'users_page'		=> 'Usuários',

	'search_page'		=> 'Buscar',
	'login_page'		=> 'Entrar',
	'account_page'		=> 'Configurações',
	'registration_page'	=> 'CriarConta',
	'password_page'		=> 'Senha',

	'whatsnew_page'		=> 'Novo',
	'changes_page'		=> 'AlteraçõesRecentes',
	'comments_page'		=> 'RecentementeComentadas',
	'index_page'		=> 'ÍndicedePáginas',

	'random_page'		=> 'PáginaAleatória',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'WackoWiki Instalação',
'TitleUpdate'					=> 'Atualização do WackoWiki',
'Continue'						=> 'Continuar',
'Back'							=> 'Voltar',
'Recommended'					=> 'recomendado',
'InvalidAction'					=> 'Ação inválida',

/*
   Locking Check
 */
'LockAuthorization'				=> 'Autorização',
'LockAuthorizationInfo'			=> 'Por favor, digite a senha que você salvou no arquivo %1.',
'LockPassword'					=> 'Senha:',
'LockLogin'						=> 'Conectar-se',
'LockPasswordInvalid'			=> 'Senha inválida',
'LockedTryLater'				=> 'Este site está sendo atualizado no momento. Por favor, tente novamente mais tarde.',
'EmptyAuthFile'					=> 'Arquivo %1 em falta ou vazio. Por favor, crie o arquivo e defina uma senha para ele.',


/*
   Language Selection Page
*/
'lang'							=> 'Configuração de idioma',
'PleaseUpgradeToR6'				=> 'Está a correr uma versão antiga do WackoWiki %1. Para actualizar para esta nova versão do WackoWiki, deve primeiro actualizar a sua instalação para %2.',
'UpgradeFromWacko'				=> 'Bem-vindo a WackoWiki, parece que está a passar de WackoWiki %1 para %2.  As próximas páginas irão guiá-lo através do processo de actualização.',
'FreshInstall'					=> 'Bem-vindo ao WackoWiki, está prestes a instalar o WackoWiki %1.  As próximas páginas irão guiá-lo através do processo de instalação.',
'PleaseBackup'					=> 'Por favor, <strong>backup</strong> a sua base de dados, ficheiro de configuração e todos os ficheiros alterados, tais como os que têm hacks e patches aplicados a eles antes de iniciar o processo de actualização. Isto pode salvá-lo de uma grande dor de cabeça.',
'LangDesc'						=> 'Escolha um idioma para o processo de instalação. Este idioma também será usado como o idioma padrão da sua instalação do WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Requisitos de sistema',
'PhpVersion'					=> 'Versão PHP',
'PhpDetected'					=> 'PHP detectado',
'ModRewrite'					=> 'Extensão de Reescrita Apache (opcional)',
'ModRewriteInstalled'			=> 'Reescrever extensão (mod_rewrite) instalada?',
'Database'						=> 'Base de dados',
'PhpExtensions'					=> 'Extensões PHP',
'Permissions'					=> 'Permissões',
'ReadyToInstall'				=> 'Pronto para instalar?',
'Requirements'					=> 'Seu servidor deve atender aos requisitos listados abaixo.',
'OK'							=> 'OK',
'Problem'						=> 'Problema',
'Example'						=> 'Exemplo',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'A sua instalação PHP parece estar a faltar as extensões de PHP assinaladas que são requeridas por WackoWiki.',
'PcreWithoutUtf8'				=> 'O módulo PCRE do PHP parece ter sido compilado sem suporte PCRE_UTF8.',
'NotePermissions'				=> 'Este instalador tentará escrever os dados de configuração no ficheiro %1, localizado no seu diretório WackoWiki. Para que isto funcione, tem de se certificar que o servidor web tem acesso de escrita a esse ficheiro. Se não o conseguir fazer, terá de editar o ficheiro manualmente (o instalador dir-lhe-á como).<br><br>Veja <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> para detalhes.',
'ErrorPermissions'				=> 'Parece que o instalador não pode definir automaticamente as permissões de arquivo necessárias para que o WackoWiki funcione correctamente. Ser-lhe-á pedido mais tarde no processo de instalação para configurar manualmente as permissões de ficheiro necessárias no seu servidor.',
'ErrorMinPhpVersion'			=> 'The PHP version must be greater than %1. Your server appears to be running an earlier version.  You must upgrade to a more recent PHP version for WackoWiki to work correctly.',
'Ready'							=> 'Parabéns, parece que o seu servidor é capaz de executar o WackoWiki. As próximas páginas irão levá-lo através do processo de configuração.',

/*
   Site Config Page
*/
'config-site'					=> 'Configuração do Site',
'SiteName'						=> 'Nome da wiki',
'SiteNameDesc'					=> 'Por favor, introduza o nome do seu sítio Wiki.',
'SiteNameDefault'				=> 'AMinhaWiki',
'HomePage'						=> 'Página inicial',
'HomePageDesc'					=> 'Introduza o nome que gostaria que a sua página inicial tivesse, esta será a página padrão que os utilizadores verão quando visitarem o seu site.',
'HomePageDefault'				=> 'Página Inicial',
'MultiLang'						=> 'Modo de Multi Idioma',
'MultiLangDesc'					=> 'O modo multilíngüe permite ter páginas com configurações de idioma diferentes em uma única instalação. Se este modo estiver ativado, o instalador criará itens de menu iniciais para todos os idiomas disponíveis na distribuição.',
'AllowedLang'					=> 'Idiomas permitidos',
'AllowedLangDesc'				=> 'Recomenda-se que seleccione apenas o conjunto de idiomas que pretende utilizar, caso contrário todos os idiomas são seleccionados.',
'AclMode'						=> 'Configurações padrão de ACL',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Wiki público (leitura para todos, escrita e comentário para usuários registrados)',
'PrivateWiki'					=> 'Wiki Privado (leitura, escrita, comentário somente para usuários registrados)',
'Admin'							=> 'Nome do Administrador',
'AdminDesc'						=> 'Digite o nome de usuário do administrador. Deve ser um <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (por exemplo, <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'O Nome de Utilizador deve ser constituído por %1 a %2 caracteres e usar somente caracteres alfanuméricos.',
'NameCamelCaseOnly'				=> 'O Nome de Utilizador deve ser constituído por %1 a %2 caracteres e WikiName formatted.',
'Password'						=> 'Senha de Administrador',
'PasswordDesc'					=> 'Escolha uma senha para o administrador com um mínimo de %1 caracteres.',
'PasswordConfirm'				=> 'Repetir Senha:',
'Mail'							=> 'Endereço de e-mail do administrador',
'MailDesc'						=> 'Digite o endereço de e-mail dos administradores.',
'Base'							=> 'URL Base',
'BaseDesc'						=> 'Sua URL de base de site WackoWiki. Nomes de páginas são anexados a ela, então se você estiver usando mod_rewrite o endereço deve terminar com uma barra para frente, ou seja,',
'Rewrite'						=> 'Modo de reescrita',
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
'DbDriver'						=> 'Motorista',
'DbDriverDesc'					=> 'O driver de banco de dados que você quer usar.',
'DbSqlMode'						=> 'Modo SQL',
'DbSqlModeDesc'					=> 'O modo SQL que você deseja usar.',
'DbVendor'						=> 'Fornecedor',
'DbVendorDesc'					=> 'Fornecedor de banco de dados que você usa.',
'DbCharset'						=> 'Charset',
'DbCharsetDesc'					=> 'O conjunto de gráficos do banco de dados que você deseja usar.',
'DbEngine'						=> 'Mecanismo',
'DbEngineDesc'					=> 'O motor de banco de dados que você quer usar.',
'DbHost'						=> 'Servidor',
'DbHostDesc'					=> 'O servidor de banco de dados está sendo executado, geralmente <code>127.0.0.1</code> ou <code>localhost</code> (ou seja, a mesma máquina na qual o site WackoWiki está ligado).',
'DbPort'						=> 'Porta (opcional)',
'DbPortDesc'					=> 'O número da porta pela qual o seu servidor de base de dados está acessível, deixe-o em branco para usar o número da porta padrão.',
'DbName'						=> 'Nome da base',
'DbNameDesc'					=> 'A base de dados WackoWiki deve ser utilizada. Esta base de dados precisa de existir já depois de continuar!',
'DbNameSqliteDesc'				=> 'O diretório de dados e nome de arquivo SQLite devem ser usados para WackoWiki.',
'DbNameSqliteHelp'				=> 'O SQLite armazena todos os dados num único ficheiro.<br><br>O diretório que fornecer deve ser gravável pelo servidor web durante a instalação.<br><br>Não deve ser acessível através da web. <br><br>O instalador irá gravar um ficheiro <code>.htaccess</code> junto com ele, mas se isso falhar, alguém poderá obter acesso ao seu banco de dados bruto.<br>Isso inclui dados brutos do utilizador (endereços de e-mail, senhas com hash), bem como páginas protegidas e outros dados restritos na wiki.<br><br>Considere colocar o banco de dados em outro lugar, por exemplo, em <code>/var/lib/wackowiki/yourwiki</code>.',
'DbUser'						=> 'Nome de utilizador',
'DbUserDesc'					=> 'Nome do utilizador utilizado para se ligar à sua base de dados.',
'DbPassword'					=> 'Palavra-chave',
'DbPasswordDesc'				=> 'Senha do utilizador utilizada para se ligar à sua base de dados.',
'Prefix'						=> 'Prefixo das tabelas',
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
'SqliteFileExtensionError'		=> 'Por favor utilize uma das seguintes extensões de arquivo db, sdb, sqlite.',
'SqliteParentUnwritableGroup'	=> 'Não é possível criar o diretório de dados <code>%1</code>, porque o servidor de internet não tem permissão de escrita no diretório que o contém <code>%2</code>.<br><br>O instalador determinou em que nome de utilizador o seu servidor de internet está a correr.<br>Para continuar, configure o diretório <code>%3</code> para poder ser escrito por este utilizador.<br>Para fazê-lo em sistemas Unix ou Linux, use:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> 'Não foi possível criar o diretório de dados <code>%1</code>, porque o diretório pai <code>%2</code> não é gravável pelo servidor web.<br><br>O instalador não pôde determinar o usuário que seu webserver está executando como<br>Faça o <code>%3</code> diretório globalmente gravável por ele (e outros!) para continuar.<br>Em um sistema Unix/Linux :<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> 'Erro ao criar o diretório de dados <code>%1</code>.<br>Verifique o local e tente novamente.',
'SqliteDirUnwritable'			=> 'Não é possível gravar no diretório <code>%1</code>.<br>Altere suas permissões para que o servidor web possa escrever nele e tente novamente.',
'SqliteReadonly'				=> 'O arquivo <code>%1</code> não é gravável.',
'SqliteCantCreateDb'			=> 'Não foi possível criar o arquivo de banco de dados <code>%1</code>.',
'InstallTables'					=> 'Instalando Tabelas',
'ErrorDbConnection'				=> 'Houve um problema com os detalhes de ligação à base de dados que especificou, por favor volte atrás e verifique se estão correctos.',
'ErrorDatabaseVersion'			=> 'A versão da base de dados é %1 mas requer pelo menos %2.',
'To'							=> 'para',
'AlterTable'					=> 'Alterando %1 tabela',
'InsertRecord'					=> 'Inserção do registro na tabela %1',
'RenameTable'					=> 'Renomear tabela %1',
'UpdateTable'					=> 'Atualização da tabela %1',
'InstallDefaultData'			=> 'Adicionar dados padrão',
'InstallPagesBegin'				=> 'Adicionar páginas padrão',
'InstallPagesEnd'				=> 'Terminou a adição de páginas predefinidas',
'InstallSystemAccount'			=> 'Adicionando usuário <code>Sistema</code>',
'InstallDeletedAccount'			=> 'Adicionando <code>Deleted</code> Usuário',
'InstallAdmin'					=> 'Adicionando usuário Admin',
'InstallAdminSetting'			=> 'Adicionando preferências de usuário Admin',
'InstallAdminGroup'				=> 'Adicionando Grupo de Administradores',
'InstallAdminGroupMember'		=> 'Adicionando membro do grupo administradores',
'InstallEverybodyGroup'			=> 'Adicionando Grupo Todos',
'InstallModeratorGroup'			=> 'Adicionando grupo de moderadores',
'InstallReviewerGroup'			=> 'Adicionando grupo de revisores',
'InstallLogoImage'				=> 'Adicionando imagem do logotipo',
'LogoImage'						=> 'Imagem do logotipo',
'InstallConfigValues'			=> 'Adicionando valores de configuração',
'ConfigValues'					=> 'Valores de configuração',
'ErrorInsertPage'				=> 'Erro ao inserir página %1',
'ErrorInsertPagePermission'		=> 'Erro ao definir permissão para a página %1',
'ErrorInsertDefaultMenuItem'	=> 'Erro ao definir a página %1 como item de menu predefinido',
'ErrorPageAlreadyExists'		=> 'A página %1 já existe',
'ErrorAlterTable'				=> 'Erro na alteração da tabela %1',
'ErrorInsertRecord'				=> 'Erro ao inserir registo na tabela %1',
'ErrorRenameTable'				=> 'Erro ao renomear tabela %1',
'ErrorUpdatingTable'			=> 'Erro ao atualizar a tabela %1',
'CreatingTable'					=> 'Criar tabela %1',
'CreatingIndex'					=> 'Criando índice %1',
'CreatingTrigger'				=> 'Criando gatilho %1',
'ErrorAlreadyExists'			=> 'O %1 já existe',
'ErrorCreatingTable'			=> 'Erro ao criar a tabela %1, ela já existe?',
'ErrorCreatingIndex'			=> 'Erro ao criar índice %1 , ele já existe?',
'ErrorCreatingTrigger'			=> 'Erro ao criar disparador %1 , ele já existe?',
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
'WrittenAt'						=> 'escrito em ',
'DontChange'					=> 'não altere a wacko_version manualmente!',
'ConfigDescription'				=> 'descrição detalhada https://wackowiki.org/doc/Doc/English/Configuration',
'TryAgain'						=> 'Tente novamente',

];
