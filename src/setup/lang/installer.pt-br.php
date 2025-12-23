<?php
$lang = [

/*
   Language Settings
*/
'LangISO'		=> 'pt-br',
'LangLocale'	=> 'pt_BR',
'LangName'		=> 'Portuguese-Brazil',
'LangDir'		=> 'ltr',

/*
   Config Defaults

   localized page tags (no spaces)
*/
'ConfigDefaults'	=> [
	'category_page'		=> 'categoria',
	'groups_page'		=> 'grupos',
	'users_page'		=> 'Utilizadores',
	'tools_page'		=> 'Ferramentas',

	'search_page'		=> 'Pesquisa',
	'login_page'		=> 'Entrar',
	'account_page'		=> 'Confirgurações',
	'registration_page'	=> 'CriarConta',
	'password_page'		=> 'Senha',

	'whatsnew_page'		=> 'Novo',
	'changes_page'		=> 'MudançasRecentes',
	'comments_page'		=> 'RecentementeComentado',
	'index_page'		=> 'PageIndex',

	'random_page'		=> 'PáginaAleatória',
	#'help_page'			=> 'Help',
	#'terms_page'		=> 'Terms',
	#'privacy_page'		=> 'Privacy',
],

/*
   Generic Page Text
*/
'TitleInstallation'				=> 'Instalação do WackoWiki',
'TitleUpdate'					=> 'Atualização do WackoWiki',
'Continue'						=> 'Continuar',
'Back'							=> 'Anterior',
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
'lang'							=> 'Configuração de Idioma',
'PleaseUpgradeToR6'				=> 'Parece que você está executando uma versão antiga do WackoWiki %1. Para atualizar essa versão do WackoWiki, você deve primeiro atualizar sua instalação para %2.',
'UpgradeFromWacko'				=> 'Bem-vindo ao WackoWiki! Parece que você está atualizando do WackoWiki %1 para %2. As próximas páginas irão guiá-lo através do processo de atualização.',
'FreshInstall'					=> 'Bem-vindo ao WackoWiki! Você está prestes a instalar o WackoWiki %1. As próximas páginas guiarão você através do processo de instalação.',
'PleaseBackup'					=> 'Por favor, <strong>backup</strong> seu banco de dados, arquivo de configuração e todos os arquivos alterados, como aqueles que têm hacks e patches locais aplicados a eles antes de iniciar o processo de atualização. Isso pode te salvar de uma grande dor de cabeça.',
'LangDesc'						=> 'Por favor, escolha um idioma para o processo de instalação. Este idioma também será usado como o idioma padrão da instalação do seu WackoWiki.',

/*
   System Requirements Page
*/
'version-check'					=> 'Requisitos do Sistema',
'PhpVersion'					=> 'Versão do PHP',
'PhpDetected'					=> 'PHP detectado',
'ModRewrite'					=> 'Extensão de Reescrita Apache (opcional)',
'ModRewriteInstalled'			=> 'Reescrever extensão (mod_rewrite) instalada?',
'Database'						=> 'Banco',
'PhpExtensions'					=> 'Extensões PHP',
'Permissions'					=> 'Permissões',
'ReadyToInstall'				=> 'Pronto para instalar?',
'Requirements'					=> 'Seu servidor deve cumprir os requisitos listados abaixo.',
'OK'							=> 'Certo',
'Problem'						=> 'Problema',
'Example'						=> 'Exemplo',
'NotePhpExtensions'				=> '',
'ErrorPhpExtensions'			=> 'Sua instalação do PHP parece estar faltando as extensões PHP indicadas, que são necessárias para o WackoWiki.',
'PcreWithoutUtf8'				=> 'PCRE não está compilado com suporte UTF-8.',
'NotePermissions'				=> 'Este instalador tentará escrever os dados de configuração do arquivo %1, localizado no diretório WackoWiki. Para que isso funcione, você precisa ter certeza de que o servidor web tem acesso de escrita a esse arquivo. Se você não puder fazer isso, você terá que editar o arquivo manualmente (o instalador lhe dirá como).<br><br>Veja <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/English/Installation</a> para detalhes.',
'ErrorPermissions'				=> 'Parece que o instalador não pode definir automaticamente as permissões de arquivo necessárias para que o WackoWiki funcione corretamente. Será solicitado posteriormente no processo de instalação que configure manualmente as permissões de arquivo necessárias no seu servidor.',
'ErrorMinPhpVersion'			=> 'A versão do PHP deve ser maior que %1. Seu servidor parece estar executando uma versão anterior. Você precisa atualizar para uma versão mais recente do PHP para que o WackoWiki funcione corretamente.',
'Ready'							=> 'Parabéns, parece que seu servidor é capaz de executar WackoWiki. As próximas páginas irão levá-lo através do processo de configuração.',

/*
   Site Config Page
*/
'config-site'					=> 'Configuração do site',
'SiteName'						=> 'Nome do Wiki',
'SiteNameDesc'					=> 'Por favor, insira o nome do seu site Wiki.',
'SiteNameDefault'				=> 'MyWikiSite',
'HomePage'						=> 'Página Inicial',
'HomePageDesc'					=> 'Insira o nome que você gostaria que sua página inicial tivesse. Esta será a página padrão que os usuários verão quando visitarem seu site e deve ser um <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a>.',
'HomePageDefault'				=> 'Página Inicial',
'MultiLang'						=> 'Modo de Multi Idioma',
'MultiLangDesc'					=> 'O modo multilíngue permite que você tenha páginas com diferentes configurações de idioma em uma única instalação. Quando este modo está ativado, o instalador cria itens de menu iniciais para todos os idiomas disponíveis na distribuição.',
'AllowedLang'					=> 'Idiomas permitidos',
'AllowedLangDesc'				=> 'Recomenda-se selecionar apenas o conjunto de idiomas que você deseja usar, caso contrário, todos os idiomas são selecionados.',
'AclMode'						=> 'Configurações padrão de ACL',
'AclModeDesc'					=> '',
'PublicWiki'					=> 'Wiki público (leitura para todos, escrita e comentário para usuários registrados)',
'PrivateWiki'					=> 'Wiki Privado (leitura, escrita, comentário somente para usuários registrados)',
'Admin'							=> 'Nome do administrador',
'AdminDesc'						=> 'Digite o nome de usuário do administrador. Deve ser um <a href="https://wackowiki.org/doc/Doc/English/WikiName" title="View Help" target="_blank">WikiName</a> (por exemplo, <code>WikiAdmin</code>).',
'NameAlphanumOnly'				=> 'O nome de usuário deve ter entre %1 e %2 e use apenas caracteres alfanuméricos. Caracteres maiúsculos são válidos.',
'NameCamelCaseOnly'				=> 'Nome de usuário deve ter entre %1 e %2 caracteres e formatado WikiName.',
'Password'						=> 'Senha do Administrador',
'PasswordDesc'					=> 'Escolha uma senha para o administrador com um mínimo de %1 caracteres.',
'PasswordConfirm'				=> 'Repetir senha:',
'Mail'							=> 'Endereço de e-mail do administrador',
'MailDesc'						=> 'Insira o endereço de e-mail do administrador.',
'Base'							=> 'URL Base',
'BaseDesc'						=> 'Sua URL de base de site WackoWiki. Nomes de páginas são anexados a ela, então se você estiver usando mod_rewrite o endereço deve terminar com uma barra para frente, ou seja,',
'Rewrite'						=> 'Modo de reescrita',
'RewriteDesc'					=> 'O modo de reescrita deve ser ativado se você estiver usando WackoWiki com a reescrita de URL.',
'Enabled'						=> 'Habilitado:',
'ErrorAdminEmail'				=> 'Você digitou um endereço de e-mail inválido!',
'ErrorAdminPasswordMismatch'	=> 'As senhas não coincidem!.',
'ErrorAdminPasswordShort'		=> 'A senha do administrador é muito curta! O tamanho mínimo é de %1 caracteres.',
'ModRewriteStatusUnknown'		=> 'O instalador não pode verificar se o mod_rewrite está habilitado. Isto, no entanto, não significa que ele está desativado.',

/*
   Database Config Page
*/
'config-database'				=> 'Configuração de banco',
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
'DbPortDesc'					=> 'O número da porta que o seu servidor de banco de dados está acessível. Deixe em branco para usar o número de porta padrão.',
'DbName'						=> 'Nome da base',
'DbNameDesc'					=> 'O banco de dados WackoWiki deve usar. Este banco de dados precisa existir já antes de continuar!',
'DbNameSqliteDesc'				=> 'O diretório de dados e nome de arquivo SQLite devem ser usados para WackoWiki.',
'DbNameSqliteHelp'				=> 'O SQLite armazena todos os dados em um único arquivo. O diretório que você fornecer deve ser gravável pelo servidor web durante a instalação. Ele não deve ser acessível pela web. <br><br>O instalador criará um arquivo <code>.htaccess</code> junto com ele, mas se isso falhar, alguém poderá obter acesso ao seu banco de dados bruto. <br>Isso inclui dados brutos do usuário (endereços de e-mail, senhas com hash), bem como páginas protegidas e outros dados restritos na wiki. <br><br>Considere colocar o banco de dados em outro lugar, por exemplo, em <code>/var/lib/wackowiki/yourwiki</code>.',
'DbUser'						=> 'Nome de usuário',
'DbUserDesc'					=> 'Nome do usuário usado para conectar ao banco de dados.',
'DbPassword'					=> 'Palavra-passe',
'DbPasswordDesc'				=> 'Senha do usuário usada para conectar ao seu banco de dados.',
'Prefix'						=> 'Prefixo das tabelas',
'PrefixDesc'					=> 'Prefixo de todas as tabelas usadas pelo WackoWiki. Isso permite que você execute várias instalações do WackoWiki usando o mesmo banco de dados, configurando-os para usar diferentes prefixos de tabela (por exemplo, wacko_).',
'ErrorNoDbDriverDetected'		=> 'Nenhum driver de banco de dados foi detectado, por favor ative a extensão mysqli ou pdo_mysql no seu arquivo php.ini.',
'ErrorNoDbDriverSelected'		=> 'Nenhum driver de banco de dados foi selecionado, por favor escolha um da lista.',
'DeleteTables'					=> 'Excluir Tabelas Existentes?',
'DeleteTablesDesc'				=> 'ATENÇÃO! Se você prosseguir com esta opção selecionada, todos os dados atuais da wiki serão apagados do seu banco de dados. Isto não pode ser desfeito, e será necessário restaurar os dados manualmente de um backup.',
'ConfirmTableDeletion'			=> 'Você tem certeza que deseja excluir todas as tabelas wiki atuais?',

/*
   Database Installation Page
*/
'install-database'				=> 'Instalação do banco',
'TestingConfiguration'			=> 'Configuração de teste',
'TestConnectionString'			=> 'Testando configurações de conexão de banco de dados',
'TestDatabaseExists'			=> 'Verificando se o banco de dados que você especificou existe',
'TestDatabaseVersion'			=> 'Verificando requisitos mínimos da versão do banco de dados',
'SqliteFileExtensionError'		=> 'Por favor utilize uma das seguintes extensões de arquivo db, sdb, sqlite.',
'SqliteParentUnwritableGroup'	=> 'Não é possível criar o diretório de dados <code>%1</code>, porque o diretório pai <code>%2</code> não pode ser gravado pelo servidor web.<br><br>O instalador conseguiu determinar o usuário em que seu servidor web está sendo executado.<br>De permissão de gravação global ao diretório <code>%3</code> para o instalador para continuar.<br>Em um sistema Unix/Linux faça:<br><br><pre>cd %2<br>mkdir %3<br>chgrp %4 %3<br>chmod g+w %3</pre>',
'SqliteParentUnwritableNogroup'	=> 'Não foi possível criar o diretório de dados <code>%1</code>, porque o diretório pai <code>%2</code> não é gravável pelo servidor web.<br><br>O instalador não pôde determinar o usuário que seu webserver está executando como<br>Faça o <code>%3</code> diretório globalmente gravável por ele (e outros!) para continuar.<br>Em um sistema Unix/Linux :<br><br><pre>cd %2<br>mkdir %3<br>chmod a+w %3</pre>',
'SqliteMkdirError'				=> 'Erro ao criar o diretório de dados <code>%1</code>.<br>Verifique o local e tente novamente.',
'SqliteDirUnwritable'			=> 'Não é possível gravar no diretório <code>%1</code>.<br>Altere suas permissões para que o servidor web possa escrever nele e tente novamente.',
'SqliteReadonly'				=> 'O arquivo <code>%1</code> não é gravável.',
'SqliteCantCreateDb'			=> 'Não foi possível criar o arquivo de banco de dados <code>%1</code>.',
'InstallTables'					=> 'Instalando tabelas',
'ErrorDbConnection'				=> 'Houve um problema com os detalhes da conexão com a base de dados especificados, por favor volte e verifique se estão corretos.',
'ErrorDatabaseVersion'			=> 'A versão do banco de dados é %1 mas requer pelo menos %2.',
'To'							=> 'para',
'AlterTable'					=> 'Alterando tabela %1',
'InsertRecord'					=> 'Inserindo registro na tabela %1',
'RenameTable'					=> 'Renomeando tabela %1',
'UpdateTable'					=> 'Atualizando tabela %1',
'InstallDefaultData'			=> 'Adicionar dados padrão',
'InstallPagesBegin'				=> 'Adicionar páginas padrão',
'InstallPagesEnd'				=> 'Adicionando páginas padrão',
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
'ErrorInsertPagePermission'		=> 'Erro ao definir permissão para página %1',
'ErrorInsertDefaultMenuItem'	=> 'Erro ao definir a página %1 como item de menu padrão',
'ErrorPageAlreadyExists'		=> 'A página %1 já existe',
'ErrorAlterTable'				=> 'Erro ao alterar tabela %1',
'ErrorInsertRecord'				=> 'Erro ao inserir registro na tabela %1',
'ErrorRenameTable'				=> 'Erro ao renomear tabela %1',
'ErrorUpdatingTable'			=> 'Erro ao atualizar tabela %1',
'CreatingTable'					=> 'Criando tabela %1',
'CreatingIndex'					=> 'Criando índice %1',
'CreatingTrigger'				=> 'Criando gatilho %1',
'ErrorAlreadyExists'			=> 'O %1 já existe',
'ErrorCreatingTable'			=> 'Erro ao criar tabela %1 , ela já existe?',
'ErrorCreatingIndex'			=> 'Erro ao criar índice %1 , ele já existe?',
'ErrorCreatingTrigger'			=> 'Erro ao criar disparador %1 , ele já existe?',
'DeletingTables'				=> 'Excluindo tabelas',
'DeletingTablesEnd'				=> 'Excluindo tabelas concluído',
'ErrorDeletingTable'			=> 'Erro ao excluir a tabela %1 . A razão mais provável é que a tabela não existe, neste caso você pode ignorar este aviso.',
'DeletingTable'					=> 'Excluindo tabela %1',
'NextStep'						=> 'Na próxima etapa, o instalador tentará gravar o arquivo de configuração atualizado, %1. Por favor, certifique-se de que o servidor web tem acesso de gravação ao arquivo, ou você terá que editá-lo manualmente. Mais uma vez, veja  <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/Inglês/Installation</a> para detalhes.',

/*
   Write Config Page
*/
'write-config'					=> 'Escrever arquivo de configuração',
'FinalStep'						=> 'Etapa final',
'Writing'						=> 'Escrevendo arquivo de configuração',
'RemovingWritePrivilege'		=> 'Removendo Privilégio de Gravação',
'InstallationComplete'			=> 'Instalação concluída',
'ThatsAll'						=> 'Isso é tudo! Agora você pode <a href="%1">visualizar seu site WackoWiki</a>.',
'SecurityConsiderations'		=> 'Considerações de segurança',
'SecurityRisk'					=> 'Você é aconselhado a remover o acesso de gravação à %1 agora que ele foi escrito. Deixar o arquivo gravável pode ser um risco de segurança!<br>ou seja, %2',
'RemoveSetupDirectory'			=> 'Você deve excluir o diretório %1 agora que o processo de instalação foi concluído.',
'ErrorGivePrivileges'			=> 'O arquivo de configuração %1 não pôde ser gravado. Você precisará dar ao seu servidor web acesso temporário a escrita no diretório WackoWiky, ou um arquivo em branco chamado %1<br>%2.<br><br> Não se esqueça de remover o acesso de escrita de novo mais tarde, i.e., <br>%3.<br><br>',
'ErrorPrivilegesInstall'		=> 'Se, por alguma razão, você não puder fazer isso, você terá que copiar o texto abaixo em um novo arquivo e salvar/enviá-lo como %1 para o diretório WackoWiki. Depois de fazer isso, seu site WackoWiki deve funcionar. Se não, por favor, visite <a href="https://wackowiki.org/doc/Doc/English/Installation" target="_blank">WackoWiki:Doc/Inglês/Instalação</a>',
'ErrorPrivilegesUpgrade'		=> 'Depois de fazer isso, seu site WackoWiki deve funcionar. Se não, por favor, visite <a href="https://wackowiki.org/doc/Doc/English/Upgrade" target="_blank">WackoWiki:Doc/English/Upgrade</a>',
'WrittenAt'						=> 'escrito em ',
'DontChange'					=> 'não altere o wacko_version manualmente!',
'ConfigDescription'				=> 'descrição detalhada: https://wackowiki.org/doc/Doc/Inglês/Configuração',
'TryAgain'						=> 'Tente novamente',

];
