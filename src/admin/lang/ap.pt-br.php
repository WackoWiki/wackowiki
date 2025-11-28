<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Funções básicas',
		'preferences'	=> 'Preferências:',
		'content'		=> 'Conteúdo',
		'users'			=> 'Utilizadores',
		'maintenance'	=> 'Manutenção',
		'messages'		=> 'mensagens',
		'extension'		=> 'Extensão',
		'database'		=> 'Banco',
	],

	// Admin panel
	'AdminPanel'				=> 'Painel de Controle Administrativo',
	'RecoveryMode'				=> 'Modo de recuperação',
	'Authorization'				=> 'Autorização',
	'AuthorizationTip'			=> 'Por favor digite a senha administrativa (certifique-se de que os cookies são permitidos no seu navegador).',
	'NoRecoveryPassword'		=> 'A senha administrativa não foi especificada!',
	'NoRecoveryPasswordTip'		=> 'Nota: A ausência de uma senha administrativa é uma ameaça à segurança! Insira o hash da sua senha no arquivo de configuração e execute o programa novamente.',

	'ErrorLoadingModule'		=> 'Erro ao carregar módulo de administração %1: não existe.',

	'ApHomePage'				=> 'Página Inicial',
	'ApHomePageTip'				=> 'Sair da administração do sistema e abrir a página inicial',
	'ApLogOut'					=> 'Efetuar logout',
	'ApLogOutTip'				=> 'Sair da administração do sistema e sair do site',

	'TimeLeft'					=> 'Tempo restante:  %1 minuto(s)',
	'ApVersion'					=> 'Versão',

	'SiteOpen'					=> 'Abertas',
	'SiteOpened'				=> 'site aberto',
	'SiteOpenedTip'				=> 'O site está aberto',
	'SiteClose'					=> 'FECHAR',
	'SiteClosed'				=> 'site fechado',
	'SiteClosedTip'				=> 'O site está fechado',

	'System'					=> 'SISTEMA',

	// Generic
	'Cancel'					=> 'cancelar',
	'Add'						=> 'Adicionar',
	'Edit'						=> 'Alterar',
	'Remove'					=> 'Excluir',
	'Enabled'					=> 'Ativado',
	'Disabled'					=> 'Desabilitado',
	'Mandatory'					=> 'Mandatory',
	'Admin'						=> 'Administrador',
	'Min'						=> 'Mínimo',
	'Max'						=> 'Máximo',

	'MiscellaneousSection'		=> 'Diversos',
	'MainSection'				=> 'Opções Gerais',

	'DirNotWritable'			=> 'O diretório %1 não tem permissões de escrita.',
	'FileNotWritable'			=> 'O arquivo %1 não é gravável.',

	/**
	 * AP MENU
	 *
	 *	'module_name'		=> [
	 *		'name'		=> 'Module name',
	 *		'title'		=> 'Module title',
	 *	],
	 */

	// Config Basic module
	'config_basic'		=> [
		'name'		=> 'Básico',
		'title'		=> 'Configurações básicas',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Aparência',
		'title'		=> 'Configurações de aparência',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'e-mail',
		'title'		=> 'Configurações de email',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Distribuição',
		'title'		=> 'Configurações de síntese',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'filtro',
		'title'		=> 'Configurações de filtro',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Quarta',
		'title'		=> 'Opções de formatação',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'notificações',
		'title'		=> 'Configurações de notificações',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'páginas',
		'title'		=> 'Parâmetros do site e páginas',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permissões',
		'title'		=> 'Configurações de permissões',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Segurança',
		'title'		=> 'Configurações de subsistemas de segurança',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'SISTEMA',
		'title'		=> 'Opções de sistema',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Transferir',
		'title'		=> 'Configurações de anexos',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Excluído',
		'title'		=> 'Conteúdo deletado recentemente',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Adicionar, editar ou remover itens de menu padrão',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Backup',
		'title'		=> 'Fazendo backup dos dados',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Reparação',
		'title'		=> 'Reparar e Otimizar Banco de Dados',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'RESTAURAR',
		'title'		=> 'Restaurando dados do backup',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Menu Principal',
		'title'		=> 'Administração de WackoWiki',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inconsistências',
		'title'		=> 'Corrigindo inconsistências de Dados',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Sincronização de dados',
		'title'		=> 'Sincronizando dados',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'E-mail em massa',
		'title'		=> 'E-mail em massa',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Sistema de mensagem',
		'title'		=> 'Mensagens do sistema',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Informações do Sistema',
		'title'		=> 'Informação do Sistema',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'Registro do sistema',
		'title'		=> 'Log de eventos do sistema',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'estatísticas',
		'title'		=> 'Mostrar estatísticas',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Comportamento ruim',
		'title'		=> 'Comportamento ruim',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Aprovar',
		'title'		=> 'Aprovação de cadastro de usuário',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'grupos',
		'title'		=> 'Gerenciamento de grupos',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Utilizadores',
		'title'		=> 'Gerenciamento de usuários',
	],

	// Main module
	'MainNote'					=> 'Nota: É recomendável que o acesso ao site seja temporariamente bloqueado para manutenção administrativa.',

	'PurgeSessions'				=> 'Purge',
	'PurgeSessionsTip'			=> 'Limpar todas as sessões',
	'PurgeSessionsConfirm'		=> 'Tem certeza que deseja limpar todas as sessões? Isto irá encerrar todos os usuários.',
	'PurgeSessionsExplain'		=> 'Limpar todas as sessões. Isto desconectará todos os usuários deixando a tabela auth_token.',
	'PurgeSessionsDone'			=> 'Sessões purgadas com sucesso.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Configurações básicas atualizadas',
	'LogBasicSettingsUpdated'	=> 'Configurações básicas atualizadas',

	'SiteName'					=> 'Nome do Site:',
	'SiteNameInfo'				=> 'O título deste site. Aparece no título do navegador, cabeçalho do tema, notificação por e-mail, etc.',
	'SiteDesc'					=> 'Descrição do Site:',
	'SiteDescInfo'				=> 'Complemento ao título do site que aparece no cabeçalho das páginas. Explica, em poucas palavras, sobre o que é este site.',
	'AdminName'					=> 'Administrador do site:',
	'AdminNameInfo'				=> 'Nome de usuário do indivíduo responsável pelo apoio global do site. Este nome não é usado para determinar permissões de acesso, mas é desejável que esteja de acordo com o nome do administrador-chefe do site.',

	'LanguageSection'			=> 'IDIOMA',
	'DefaultLanguage'			=> 'Idioma padrão:',
	'DefaultLanguageInfo'		=> 'Especifica o idioma das mensagens exibidas para visitantes não registrados, bem como as configurações de localidade.',
	'MultiLanguage'				=> 'Suporte a Multilinguagem:',
	'MultiLanguageInfo'			=> 'Habilita a capacidade de selecionar um idioma em uma base de página por página.',
	'AllowedLanguages'			=> 'Idiomas permitidos:',
	'AllowedLanguagesInfo'		=> 'Recomenda-se selecionar apenas o conjunto de idiomas que você deseja usar, caso contrário, todos os idiomas são selecionados.',

	'CommentSection'			=> 'comentários',
	'AllowComments'				=> 'Permitir comentários:',
	'AllowCommentsInfo'			=> 'Habilitar comentários para convidados ou usuários registrados apenas, ou desativá-los em todo o site.',
	'SortingComments'			=> 'Classificando comentários:',
	'SortingCommentsInfo'		=> 'Altera a ordem em que os comentários da página são apresentados, seja com o comentário mais recente OU o mais antigo no topo.',
	'CommentsOffset'			=> 'Página de comentários:',
	'CommentsOffsetInfo'		=> 'Página de comentários a exibir por padrão',

	'ToolbarSection'			=> 'Barra',
	'CommentsPanel'				=> 'Painel de comentários.',
	'CommentsPanelInfo'			=> 'A exibição padrão de comentários no final da página.',
	'FilePanel'					=> 'Painel de arquivo:',
	'FilePanelInfo'				=> 'A exibição padrão de anexos na parte inferior da página.',
	'TagsPanel'					=> 'Painel de tags:',
	'TagsPanelInfo'				=> 'A exibição padrão do painel de tags na parte inferior da página.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Mostrar permalink:',
	'ShowPermalinkInfo'			=> 'A exibição padrão do permalink para a versão atual da página.',
	'TocPanel'					=> 'Tabela de painel de conteúdo:',
	'TocPanelInfo'				=> 'A tabela de exibição padrão do painel de conteúdos de uma página (pode precisar de suporte nos templates).',
	'SectionsPanel'				=> 'Painel de seções:',
	'SectionsPanelInfo'			=> 'Por padrão, exibir o painel de páginas adjacentes (requer suporte nos templates).',
	'DisplayingSections'		=> 'Exibindo seções:',
	'DisplayingSectionsInfo'	=> 'Quando as opções anteriores estiverem definidas, exibir apenas subpáginas da página (<em>inferior</em>) apenas vizinho (<em>top</em>), ambos, ou outra (<em>árvore</em>).',
	'MenuItems'					=> 'Itens de menu:',
	'MenuItemsInfo'				=> 'Número padrão de itens de menu mostrados (pode precisar de suporte nos templates).',

	'HandlerSection'			=> 'Handlers',
	'HideRevisions'				=> 'Ocultar revisões:',
	'HideRevisionsInfo'			=> 'A exibição padrão de revisões da página.',
	'AttachmentHandler'			=> 'Habilitar manipulador de anexos:',
	'AttachmentHandlerInfo'		=> 'Permite exibir o manipulador de anexos.',
	'SourceHandler'				=> 'Habilitar manipulador de origem:',
	'SourceHandlerInfo'			=> 'Permite a exibição do manipulador de origem.',
	'ExportHandler'				=> 'Habilitar manipulador de exportação XML:',
	'ExportHandlerInfo'			=> 'Permite a exibição do manipulador de exportação XML.',

	'DiffModeSection'			=> 'Modos de Diff',
	'DefaultDiffModeSetting'	=> 'Modo padrão de diff:',
	'DefaultDiffModeSettingInfo'=> 'Modo de diff pré-selecionado.',
	'AllowedDiffMode'			=> 'Modos de diff permitidos:',
	'AllowedDiffModeInfo'		=> 'Recomenda-se selecionar apenas o conjunto de modos de diff que deseja usar, caso contrário, todos os modos de diff são selecionados.',
	'NotifyDiffMode'			=> 'Modo diff:',
	'NotifyDiffModeInfo'		=> 'Modo diff usado para as notificações no corpo do e-mail.',

	'EditingSection'			=> 'Editando',
	'EditSummary'				=> 'Editar resumo:',
	'EditSummaryInfo'			=> 'Mostra o resumo das alterações no modo de edição.',
	'MinorEdit'					=> 'Edição menor:',
	'MinorEditInfo'				=> 'Habilita a opção de edição menor no modo de edição.',
	'SectionEdit'				=> 'Editar a turma:',
	'SectionEditInfo'			=> 'Permite a edição de apenas uma seção de uma página.',
	'ReviewSettings'			=> 'Avaliação:',
	'ReviewSettingsInfo'		=> 'Ativar opção de revisão no modo de edição.',
	'PublishAnonymously'		=> 'Permitir publicação anônima:',
	'PublishAnonymouslyInfo'	=> 'Permitir que os usuários publiquem anonimamente (para ocultar o nome).',

	'DefaultRenameRedirect'		=> 'Ao renomear, crie o redirecionamento:',
	'DefaultRenameRedirectInfo'	=> 'Por padrão, oferecer para definir um redirecionamento para o endereço antigo da página a ser renomeada.',
	'StoreDeletedPages'			=> 'Manter páginas excluídas:',
	'StoreDeletedPagesInfo'		=> 'Quando você excluir uma página, um comentário ou arquivo, mantenha-o em uma seção especial, onde ele estará disponível para revisão e recuperação por algum período de tempo (como descrito abaixo).',
	'KeepDeletedTime'			=> 'Tempo de armazenamento das páginas excluídas:',
	'KeepDeletedTimeInfo'		=> 'O período em dias: faz sentido apenas com a opção anterior. Use zero para garantir que as entidades nunca sejam excluídas (neste caso, o administrador pode limpar o "carrinho" manualmente).',
	'PagesPurgeTime'			=> 'Tempo de armazenamento das revisões da página:',
	'PagesPurgeTimeInfo'		=> 'Exclui automaticamente as versões mais antigas dentro do número de dias determinado. Se você digitar zero, as versões mais antigas não serão removidas.',
	'EnableReferrers'			=> 'Habilitar referências:',
	'EnableReferrersInfo'		=> 'Permite criação e exibição de referenciadores externos.',
	'ReferrersPurgeTime'		=> 'Tempo de armazenamento dos indicadores:',
	'ReferrersPurgeTimeInfo'	=> 'Manter o histórico de referência de páginas externas não mais do que um determinado número de dias. Use zero para garantir que referenciadores nunca sejam excluídos (mas para um site ativamente visitado, isso pode levar ao overflow).',
	'EnableCounters'			=> 'Contadores de Vistos:',
	'EnableCountersInfo'		=> 'Permite contadores de acertos por página e ativa a exibição de estatísticas simples. Visualizações do proprietário da página não são contadas.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Controle as configurações padrão de sincronização web para seu site.',
	'SyndicationSettingsUpdated'	=> 'Atualizadas configurações de sincronização.',

	'FeedsSection'				=> 'Conteúdos',
	'EnableFeeds'				=> 'Ativar feeds:',
	'EnableFeedsInfo'			=> 'Turna ou desliga alimentações RSS para a wiki inteira.',
	'XmlChangeLink'				=> 'Altera o modo de link do feed:',
	'XmlChangeLinkInfo'			=> 'Define para onde o XML muda os links do feed.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'visualização da diferença',
		'2'		=> 'página revisada',
		'3'		=> 'lista de revisões',
		'4'		=> 'a página atual',
	],

	'XmlSitemap'				=> 'XML sitemap:',
	'XmlSitemapInfo'			=> 'Cria um arquivo XML chamado %1 dentro da pasta xml. Você pode adicionar o caminho para o mapa do site no arquivo robots.txt em seu diretório raiz da seguinte forma:',
	'XmlSitemapGz'				=> 'Compressão de sitemap XML:',
	'XmlSitemapGzInfo'			=> 'Se você quiser, pode compactar o arquivo de texto do sitemap usando o gzip para reduzir o requisito de largura de banda.',
	'XmlSitemapTime'			=> 'Tempo de geração do sitemap XML:',
	'XmlSitemapTimeInfo'		=> 'Gera o mapa do site apenas uma vez no número dado de dias. Defina como zero para gerar em cada mudança de página.',

	'SearchSection'				=> 'Pesquisa',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Cria o arquivo de descrição OpenSearch na pasta XML e permite a descoberta automática do plugin de pesquisa no cabeçalho HTML.',
	'SearchEngineVisibility'	=> 'Bloquear motores de busca (visibilidade de mecanismos de busca):',
	'SearchEngineVisibilityInfo'=> 'Bloquear motores de busca, mas permitir visitantes normais. Substitui configurações de página. U <br>Desencorajar os motores de busca de indexação deste site. Cabe aos motores de busca honrar esta solicitação.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Controle as configurações de exibição padrão do seu site.',
	'AppearanceSettingsUpdated'	=> 'Configurações de aparência atualizadas.',

	'LogoOff'					=> 'Desligado',
	'LogoOnly'					=> 'Logotipo',
	'LogoAndTitle'				=> 'logotipo e título',

	'LogoSection'				=> 'Logotipo',
	'SiteLogo'					=> 'Logo do site:',
	'SiteLogoInfo'				=> 'Seu logotipo normalmente aparecerá no canto superior esquerdo da aplicação. O tamanho máximo é de 2 Mi. Dimensões ótimas têm 255 pixels de largura por 55 pixels de altura.',
	'LogoDimensions'			=> 'Dimensões do logo:',
	'LogoDimensionsInfo'		=> 'Largura e altura do logotipo exibido.',
	'LogoDisplayMode'			=> 'Modo exibição do logotipo:',
	'LogoDisplayModeInfo'		=> 'Define a aparência do logotipo. O padrão está desativado.',

	'FaviconSection'			=> 'Favicon:',
	'SiteFavicon'				=> 'Favicon:',
	'SiteFaviconInfo'			=> 'Seu ícone de atalho, ou favicon, é exibido na barra de endereços, abas e favoritos da maioria dos navegadores. Isto irá substituir o favicon do seu tema.',
	'SiteFaviconTooBig'			=> 'O Favicon é maior do que 64 x 64 px.',
	'ThemeColor'				=> 'Cor do tema para a barra de endereços:',
	'ThemeColorInfo'			=> 'O navegador definirá a cor da barra de endereço de cada página de acordo com a cor CSS fornecida.',

	'LayoutSection'				=> 'Disposição',
	'Theme'						=> 'Tema:',
	'ThemeInfo'					=> 'Modelo de design que o site usa por padrão.',
	'ResetUserTheme'			=> 'Redefinir todos os temas do usuário:',
	'ResetUserThemeInfo'		=> 'Redefinir todos os temas do usuário. Aviso: Esta ação irá reverter todos os temas selecionados do usuário para o tema padrão global.',
	'SetBackUserTheme'			=> 'Reverter todos os temas do usuário para o tema %1.',
	'ThemesAllowed'				=> 'Temas permitidos:',
	'ThemesAllowedInfo'			=> 'Selecione os temas permitidos que o usuário pode escolher. Caso contrário, todos os temas disponíveis são permitidos.',
	'ThemesPerPage'				=> 'Temas por página:',
	'ThemesPerPageInfo'			=> 'Permitir temas por página, que o proprietário da página pode escolher através das propriedades da página.',

	// System settings
	'SystemSettingsInfo'		=> 'Grupo de parâmetros responsáveis por afinar o site. Não altere, a menos que você confie em suas ações.',
	'SystemSettingsUpdated'		=> 'Configurações do sistema atualizadas',

	'DebugModeSection'			=> 'Modo de depuração',
	'DebugMode'					=> 'Modo de depuração:',
	'DebugModeInfo'				=> 'Extraindo e saindo dados de telemetria sobre o tempo de execução da aplicação. Atenção: O modo de detalhe completo impõe requisitos mais elevados à memória alocada, especialmente para operações intensivas em recursos, como backup de banco de dados e restauração.',
	'DebugModes'	=> [
		'0'		=> 'A depuração está desativada',
		'1'		=> 'apenas o tempo total de execução',
		'2'		=> 'tempo integral',
		'3'		=> 'detalhe completo (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Limite de desempenho RDBMS:',
	'DebugSqlThresholdInfo'		=> 'No modo de depuração detalhado, reporte apenas as consultas que levam mais tempo do que o número de segundos especificado.',
	'DebugAdminOnly'			=> 'Diagnóstico fechado:',
	'DebugAdminOnlyInfo'		=> 'Mostrar dados de depuração do programa (e DBMS) apenas para o administrador.',

	'CachingSection'			=> 'Opções de Cache',
	'Cache'						=> 'Páginas processadas no cache:',
	'CacheInfo'					=> 'Salve as páginas renderizadas no cache local para acelerar a inicialização subsequente. Válido apenas para visitantes não registrados.',
	'CacheTtl'					=> 'Tempo de vida para páginas em cache:',
	'CacheTtlInfo'				=> 'Páginas de cache não mais do que um número específico de segundos.',
	'CacheSql'					=> 'Cache consultas DBMS:',
	'CacheSqlInfo'				=> 'Manter uma cache local dos resultados de certas consultas SQL relacionadas aos recursos.',
	'CacheSqlTtl'				=> 'Tempo-a-vivo para consultas SQL em cache:',
	'CacheSqlTtlInfo'			=> 'Resultado do cache de consultas SQL por não mais do que o número especificado de segundos. Valores maiores do que 1200 não são desejáveis.',

	'LogSection'				=> 'Configurações de Log',
	'LogLevelUsage'				=> 'Use registro:',
	'LogLevelUsageInfo'			=> 'A prioridade mínima dos eventos registrados no log.',
	'LogThresholds'	=> [
		'0'		=> 'não manter um diário',
		'1'		=> 'apenas o nível crítico',
		'2'		=> 'do nível mais alto',
		'3'		=> 'do alto',
		'4'		=> 'em média',
		'5'		=> 'de baixo',
		'6'		=> 'o nível mínimo',
		'7'		=> 'gravar tudo',
	],
	'LogDefaultShow'			=> 'Exibir modo log:',
	'LogDefaultShowInfo'		=> 'Os eventos de prioridade mínima exibidos no log por padrão.',
	'LogModes'	=> [
		'1'		=> 'apenas o nível crítico',
		'2'		=> 'do nível mais alto',
		'3'		=> 'de alto nível',
		'4'		=> 'a média',
		'5'		=> 'de um baixo',
		'6'		=> 'do nível mínimo',
		'7'		=> 'mostrar todos',
	],
	'LogPurgeTime'				=> 'Tempo de armazenamento do log:',
	'LogPurgeTimeInfo'			=> 'Remover o registro de eventos após o número especificado de dias.',

	'PrivacySection'			=> 'Privacidade',
	'AnonymizeIp'				=> 'Anonimizar endereços IP dos usuários:',
	'AnonymizeIpInfo'			=> 'Anonimizar endereços IP onde aplicável (por exemplo, página, revisão ou referências).',

	'ReverseProxySection'		=> 'Proxy reverso',
	'ReverseProxy'				=> 'Usar proxy reverso:',
	'ReverseProxyInfo'			=> 'Ativar esta configuração para determinar o endereço IP correto do cliente remoto examinando informações armazenadas nos cabeçalhos X-Forwarded-para. Os cabeçalhos X-Forwarded-For são um mecanismo padrão para identificar sistemas de clientes se conectando através de um servidor proxy reverso, como Lula ou Pound. Servidores de proxy reversos são frequentemente usados para melhorar o desempenho de sites visitados fortemente e também podem fornecer outros benefícios de cache, segurança ou encriptação do site. Se esta instalação do WackoWiki opera atrás de um proxy reverso, essa configuração deve ser habilitada para que informações corretas de endereço IP sejam capturadas nos sistemas de gerenciamento de sessão do WackoWiki; se você não tiver certeza sobre essa configuração, não tenha um proxy reverso, ou WackoWiki opera em um ambiente de hospedagem compartilhada, esta configuração deve permanecer desativada.',
	'ReverseProxyHeader'		=> 'Cabeçalho do proxy revertido:',
	'ReverseProxyHeaderInfo'	=> 'Defina este valor se o seu servidor proxy enviar o IP do cliente em um cabeçalho
									 ├├├├├├other than X-Forwarded-For. O cabeçalho "X-Forwarded-for" é uma lista de IPA delimitada por vírgulas
									 econtramenginédita. Somente o último (o mais à esquerda) será utilizado.',
	'ReverseProxyAddresses'		=> 'reverse_proxy aceita um array de endereços IP:',
	'ReverseProxyAddressesInfo'	=> 'Cada elemento desta matriz é o endereço IP de qualquer um dos seus aparelhos
									 reverso A,format@@0 ├├├├├™️. Se estiver usando este array, O WackoWiki confiará na informação armazenada
									 ├├├├├in the X-Forwarded-For somente se o endereço IP remoto é um de
									 ├├├├├├these, ou seja, a solicitação chega ao servidor da web a partir de um dos seus procuradores
									 de A-format@@3 「├├├├reverse proxies. Caso contrário, o cliente pode se conectar diretamente à
									 anormalheia de seu servidor web falsificando cabeçalhos de Encaminhamento X-Forwarded-para.',

	'SessionSection'				=> 'Manipulação da Sessão',
	'SessionStorage'				=> 'Armazenamento de sessão:',
	'SessionStorageInfo'			=> 'Esta opção define onde os dados da sessão são armazenados. Por padrão, o armazenamento de arquivos ou da sessão do banco de dados está selecionado.',
	'SessionModes'	=> [
		'1'		=> 'Arquivo',
		'2'		=> 'Banco',
	],
	'SessionNotice'					=> 'Aviso de término de sessão:',
	'SessionNoticeInfo'				=> 'Indica a causa do término da sessão.',
	'LoginNotice'					=> 'Aviso de login:',
	'LoginNoticeInfo'				=> 'Mostra aviso de acesso',

	'RewriteMode'					=> 'Usar mod_rewrite <code></code>:',
	'RewriteModeInfo'				=> 'Se o seu servidor web suportar este recurso, habilite para "linfy" as URLs da página. U<br>
										e&mostrmostrmostrmostramos "A" in runtime "										<span class="cite">O valor pode ser substituído pela classe "Configurações" em tempo de execução. independente de se está desligado, se HTTP_MOD_REWRITE estiver ligado.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parâmetros responsáveis pelo controle de acesso e permissões.',
	'PermissionsSettingsUpdated'	=> 'Configurações de permissões atualizadas',

	'PermissionsSection'		=> 'Direitos e Privilégios',
	'ReadRights'				=> 'Permissões de leitura por padrão:',
	'ReadRightsInfo'			=> 'Padrão atribuído às páginas raiz criadas, bem como páginas para as quais os ACLs pai não podem ser definidos.',
	'WriteRights'				=> 'Permissões de escrita por padrão:',
	'WriteRightsInfo'			=> 'Padrão atribuído às páginas raiz criadas, bem como páginas para as quais os ACLs pai não podem ser definidos.',
	'CommentRights'				=> 'Comentar direitos por padrão:',
	'CommentRightsInfo'			=> 'Padrão atribuído às páginas raiz criadas, bem como páginas para as quais os ACLs pai não podem ser definidos.',
	'CreateRights'				=> 'Criar direitos de sub página por padrão:',
	'CreateRightsInfo'			=> 'Padrão atribuído às sub páginas criadas.',
	'UploadRights'				=> 'Permissões de upload por padrão:',
	'UploadRightsInfo'			=> 'Direitos padrão de upload.',
	'RenameRights'				=> 'Renomear global da direita:',
	'RenameRightsInfo'			=> 'A lista de permissões para renomear livremente (mover) páginas.',

	'LockAcl'					=> 'Bloquear todos os ACLs para somente leitura:',
	'LockAclInfo'				=> '<span class="cite">Sobrescreve as configurações de ACL para todas as páginas somente leitura.</span><br>Isso pode ser útil se um projeto estiver concluído, você quer fechar a edição por um período de tempo por razões de segurança, ou como resposta de emergência a um exploit ou vulnerabilidade.',
	'HideLocked'				=> 'Ocultar páginas inacessídas:',
	'HideLockedInfo'			=> 'Se o usuário não tem permissão para ler a página, ocultá-lo em listas de páginas diferentes (entretanto, o link colocado no texto ainda estará visível).',
	'RemoveOnlyAdmins'			=> 'Somente os administradores podem excluir páginas:',
	'RemoveOnlyAdminsInfo'		=> 'Negar todos, exceto administradores, a capacidade de excluir páginas. O primeiro limite aplica-se a proprietários de páginas normais.',
	'OwnersRemoveComments'		=> 'Proprietários das páginas podem excluir comentários:',
	'OwnersRemoveCommentsInfo'	=> 'Permitir que proprietários de páginas moderem comentários em suas páginas.',
	'OwnersEditCategories'		=> 'Proprietários podem editar categorias da página:',
	'OwnersEditCategoriesInfo'	=> 'Permitir aos proprietários modificar a lista de categorias de páginas do seu site (adicionar palavras, excluir palavras), atribuir a uma página.',
	'TermHumanModeration'		=> 'Expiração da moderação humana:',
	'TermHumanModerationInfo'	=> 'Moderadores só podem editar comentários se eles foram criados não mais do que este número de dias atrás (esta limitação não se aplica ao último comentário no tópico).',

	'UserCanDeleteAccount'		=> 'Permitir que os usuários excluam suas contas',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parâmetros responsáveis pela segurança geral da plataforma, restrições de segurança e subsistemas de segurança adicionais.',
	'SecuritySettingsUpdated'	=> 'Configurações de segurança atualizadas',

	'AllowRegistration'			=> 'Registrar online:',
	'AllowRegistrationInfo'		=> 'Abrir registro de usuário. Desabilitar essa opção impedirá o registro gratuito, no entanto, o administrador do site ainda será capaz de registrar usuários.',
	'ApproveNewUser'			=> 'Aprovar novos usuários:',
	'ApproveNewUserInfo'		=> 'Permite que os administradores aprovem usuários após o seu cadastro. Somente usuários aprovados terão permissão para acessar o site.',
	'PersistentCookies'			=> 'Cookies persistentes:',
	'PersistentCookiesInfo'		=> 'Permitir cookies persistentes.',
	'DisableWikiName'			=> 'Desativar WikiName:',
	'DisableWikiNameInfo'		=> 'Desative o uso obrigatório de um WikiName para usuários. Permite o registro de usuários com apelidos tradicionais ao invés de nomes com formatação do CamelCase-formatados (ou seja, NameSurname).',
	'UsernameLength'			=> 'Tamanho do usuário:',
	'UsernameLengthInfo'		=> 'Número mínimo e máximo de caracteres em nomes de usuário.',

	'EmailSection'				=> 'e-mail',
	'AllowEmailReuse'			=> 'Permitir endereço de e-mail reutilização:',
	'AllowEmailReuseInfo'		=> 'Usuários diferentes podem se registrar com o mesmo endereço de e-mail.',
	'EmailConfirmation'			=> 'Forçar confirmação do e-mail:',
	'EmailConfirmationInfo'		=> 'Requer que o usuário verifique o seu endereço de email antes de poder acessar.',
	'AllowedEmailDomains'		=> 'Domínios de e-mail permitidos:',
	'AllowedEmailDomainsInfo'	=> 'Domínios de e-mail separados por vírgula, por exemplo, <code>example.com, local.lan</code> etc. Se não for especificado, todos os domínios de e-mail são permitidos.',
	'ForbiddenEmailDomains'		=> 'Domínios de e-mail proibidos:',
	'ForbiddenEmailDomainsInfo'	=> 'Domínios de e-mail proibidos separados por vírgula, por exemplo, <code>example.com, local.lan</code> etc. Somente eficaz se a lista de domínios de e-mail permitidos estiver vazia.',

	'CaptchaSection'			=> 'Carro',
	'EnableCaptcha'				=> 'Ativar captcha:',
	'EnableCaptchaInfo'			=> 'Se ativado, o captcha será exibido nos seguintes casos ou se um limite de segurança for atingido.',
	'CaptchaComment'			=> 'Novo comentário:',
	'CaptchaCommentInfo'		=> 'Como proteção contra spam, usuários não registrados devem completar o captcha antes que o comentário seja publicado.',
	'CaptchaPage'				=> 'Nova página:',
	'CaptchaPageInfo'			=> 'Como proteção contra spam, usuários não registrados devem completar o captcha antes de criar uma nova página.',
	'CaptchaEdit'				=> 'Editar página:',
	'CaptchaEditInfo'			=> 'Como proteção contra spam, usuários não registrados devem completar o captcha antes de editar páginas.',
	'CaptchaRegistration'		=> 'Registro:',
	'CaptchaRegistrationInfo'	=> 'Como proteção contra spam, usuários não registrados devem completar o captcha antes de se registrar.',

	'TlsSection'				=> 'Configurações TLS',
	'TlsConnection'				=> 'Conexão TLS:',
	'TlsConnectionInfo'			=> 'Usar conexão segura TLS. <span class="cite">Ativar o certificado TLS pré-instalado no servidor, caso contrário, você perderá o acesso ao painel de administração!</span><br>Também determina se a bandeira segura do Cookie está definida: O sinalizador <code>seguro</code> especifica se os cookies só devem ser enviados através de conexões seguras.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Reconecte forçadamente o cliente de HTTP a HTTPS. Com a opção desativada, o cliente pode navegar no site através de um canal HTTP aberto.',

	'HttpSecurityHeaders'		=> 'Cabeçalhos de Segurança HTTP',
	'EnableSecurityHeaders'		=> 'Habilitar cabeçalhos de segurança:',
	'EnableSecurityHeadersinfo'	=> 'Definir cabeçalhos de segurança (buscando quadros, clickjacking/XSS/CSRF proteção). <br>CSP pode causar problemas em certas situações (por exemplo durante o desenvolvimento), ou ao usar plugins que dependem de recursos hospedados externos, como imagens ou scripts. <br>Desabilitar a Política de Segurança de Conteúdo é um risco de segurança!',
	'Csp'						=> 'Política de segurança de conteúdo (CSP):',
	'CspInfo'					=> 'Configurar o CSP envolve decidir quais políticas você deseja aplicar e, em seguida, configurá-los e usar a Content-Security-Policy para estabelecer a sua política.',
	'PolicyModes'	=> [
		'0'		=> 'desabilitado',
		'1'		=> 'estrito',
		'2'		=> 'personalizado',
	],
	'PermissionsPolicy'			=> 'Política de permissões:',
	'PermissionsPolicyInfo'		=> 'O cabeçalho Permissões-Política HTTP fornece um mecanismo para ativar ou desativar explicitamente vários recursos poderosos do navegador.',
	'ReferrerPolicy'			=> 'Política de referência:',
	'ReferrerPolicyInfo'		=> 'O cabeçalho HTTP Política de Referencia governa quais informações referenciadoras, enviadas no cabeçalho Referer, devem ser incluídas nas respostas.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'sem referência',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'mesma-origem',
		'4'		=> 'origem',
		'5'		=> 'estrita-origem',
		'6'		=> 'origem-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'URL-insegura'
	],

	'UserPasswordSection'		=> 'Persistência de Senhas de Usuário',
	'PwdMinChars'				=> 'Tamanho mínimo da senha:',
	'PwdMinCharsInfo'			=> 'Senhas mais longas são necessariamente mais seguras do que senhas mais curtas (por exemplo, 12 a 16 caracteres).<br>O uso de frases-senha em vez de senhas é incentivado.',
	'AdminPwdMinChars'			=> 'Tamanho mínimo da senha de administrador:',
	'AdminPwdMinCharsInfo'		=> 'Senhas mais longas são necessariamente mais seguras do que senhas mais curtas (por exemplo, 15 a 20 caracteres).<br>O uso de frases-senha em vez de senhas é incentivado.',
	'PwdCharComplexity'			=> 'A complexidade de senha necessária:',
	'PwdCharClasses'	=> [
		'0'		=> 'não testado',
		'1'		=> 'quaisquer letras + números',
		'2'		=> 'maiúsculas e minúsculas + números',
		'3'		=> 'maiúsculas e minúsculas + números + caracteres',
	],
	'PwdUnlikeLogin'			=> 'complicação adicional:',
	'PwdUnlikes'	=> [
		'0'		=> 'não testado',
		'1'		=> 'a senha não é idêntica ao login',
		'2'		=> 'a senha não contém o nome de usuário',
	],

	'LoginSection'				=> 'Conectar-se',
	'MaxLoginAttempts'			=> 'Número máximo de tentativas de login por nome de usuário:',
	'MaxLoginAttemptsInfo'		=> 'O número de tentativas de login permitidas para uma única conta antes que a tarefa anti-spambot seja acionada. Digite 0 para impedir que a tarefa anti-spambot seja acionada para contas de usuários distintas.',
	'IpLoginLimitMax'			=> 'Número máximo de tentativas de login por endereço IP:',
	'IpLoginLimitMaxInfo'		=> 'O limite de tentativas de login permitidas a partir de um único endereço IP antes que uma tarefa anti-spambot seja acionada. Digite 0 para evitar que a tarefa anti-spambot seja acionada por endereços IP.',

	'FormsSection'				=> 'Formulários',
	'FormTokenTime'				=> 'Tempo máximo para enviar formulários:',
	'FormTokenTimeInfo'			=> 'O tempo que um usuário deve enviar um formulário (em segundos).<br> Note que um formulário pode se tornar inválido se a sessão expirar, independentemente dessa configuração.',

	'SessionLength'				=> 'Expiração do cookie da sessão:',
	'SessionLengthInfo'			=> 'O tempo de vida do cookie de sessão do usuário por padrão (em dias).',
	'CommentDelay'				=> 'Anti-flood para comentários:',
	'CommentDelayInfo'			=> 'O atraso mínimo entre a publicação de novos comentários de usuários (em segundos).',
	'IntercomDelay'				=> 'Anti-flood para comunicações pessoais:',
	'IntercomDelayInfo'			=> 'O mínimo de atraso entre o envio de mensagens privadas (em segundos).',
	'RegistrationDelay'			=> 'Tempo limite para se registrar:',
	'RegistrationDelayInfo'		=> 'O tempo mínimo entre as submissões de formulários de registro para desencorajar os bots de registro (em segundos).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Grupo de parâmetros responsáveis por afinar o site. Não altere, a menos que você confie em suas ações.',
	'FormatterSettingsUpdated'	=> 'Configurações de formatação atualizadas',

	'TextHandlerSection'		=> 'Manipulador de Textos:',
	'Typografica'				=> 'Revisão tipográfica:',
	'TypograficaInfo'			=> 'Desabilitar esta opção irá acelerar os processos de adicionar comentários e salvar páginas.',
	'Paragrafica'				=> 'Marcações paragrafica',
	'ParagraficaInfo'			=> 'Semelhante à opção anterior, mas levará à desconexão de tabela de conteúdo automática inoperável (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Suporte HTML global:',
	'AllowRawhtmlInfo'			=> 'Esta opção potencialmente não é segura para um site aberto.',
	'SafeHtml'					=> 'Filtrando HTML:',
	'SafeHtmlInfo'				=> 'Impede salvar objetos HTML perigosos. Desligar o filtro em um site aberto com suporte a HTML é <span class="underline">extremamente</span> indesejável!',

	'WackoFormatterSection'		=> 'Formatador de Texto Wiki (Formato Wacko)',
	'X11colors'					=> 'Uso de cores X11:',
	'X11colorsInfo'				=> 'Estende as cores disponíveis para <code>??(cor) de fundo??</code> e <code>!!(color) texto!!</code>Desativar esta opção acelera os processos de adicionar comentários e salvar páginas.',
	'WikiLinks'					=> 'Desabilitar links wiki:',
	'WikiLinksInfo'				=> 'Desativa a vinculação para <code>CamelCaseWords</code>: Suas palavras CamelCase já não serão vinculadas diretamente a uma nova página. Isso é útil quando você trabalha em diferentes namespaces/clusters. Por padrão, ele está desativado.',
	'BracketsLinks'				=> 'Desativar links para-braços:',
	'BracketsLinksInfo'			=> 'Desativa a sintaxe <code>[[link]]</code> e <code>((link))</code>.',
	'Formatters'				=> 'Desativar formatos:',
	'FormattersInfo'			=> 'Desativa a sintaxe <code>%%code%%</code> , usada para destaques.',

	'DateFormatsSection'		=> 'Formatos de data',
	'DateFormat'				=> 'O formato da data:',
	'DateFormatInfo'			=> '(dia, mês, ano)',
	'TimeFormat'				=> 'O formato da hora:',
	'TimeFormatInfo'			=> '(hora, minuto)',
	'TimeFormatSeconds'			=> 'O formato do horário exato:',
	'TimeFormatSecondsInfo'		=> '(horas, minutos, segundos)',
	'NameDateMacro'				=> 'O formato do <code>::@::</code> macro:',
	'NameDateMacroInfo'			=> '(name, time), ex.: <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Timezone:',
	'TimezoneInfo'				=> 'Fuso horário para exibir horários para usuários que não estão conectados (convidados). Os usuários conectados podem alterar seu fuso horário em suas configurações de usuário.',
	'AmericanDate'					=> 'Data americana:',
	'AmericanDateInfo'				=> 'Usa o formato de data Americano como padrão para Inglês.',

	'Canonical'					=> 'Usar URLs totalmente canônicos:',
	'CanonicalInfo'				=> 'Todos os links são criados como URLs absolutas no formulário %1. URLs relativas à raiz do servidor no formulário %2 devem ser preferidas.',
	'LinkTarget'				=> 'Onde links externos abrem:',
	'LinkTargetInfo'			=> 'Abre cada link externo em uma nova janela do navegador. Adiciona <code>target="_blank"</code> à sintaxe de link.',
	'Noreferrer'				=> 'noreferer:',
	'NoreferrerInfo'			=> 'Requer que o navegador não envie um cabeçalho HTTP referer se o usuário seguir o hiperlink. Adiciona <code>rel="noreferrer"</code> à sintaxe de link.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Dizem aos motores de busca que os hiperlinks não devem afetar a classificação da página de destino no índice do motor de busca. Adiciona <code>rel="nofollow"</code> na sintaxe do link.',
	'UrlsUnderscores'			=> 'Endereços de formulário (URLs) com sublinhados:',
	'UrlsUnderscoresInfo'		=> 'Por exemplo, %1 acena %2 com esta opção.',
	'ShowSpaces'				=> 'Mostrar espaços em WikiNames:',
	'ShowSpacesInfo'			=> 'Mostrar espaços em WikiNames, por exemplo, <code>MeuNome</code> sendo exibido como <code>Meu Nome</code> com esta opção.',
	'NumerateLinks'				=> 'Enumerar links na visualização da impressão:',
	'NumerateLinksInfo'			=> 'Enumera e lista todos os links na parte inferior da visualização impressa com esta opção.',
	'YouareHereText'			=> 'Desativar e visualizar links de auto-referenciamento:',
	'YouareHereTextInfo'		=> 'Visualize links para a mesma página, usando <code>&lt;b&gt;####&lt;/b&gt;</code>. Todos os links para a formatação de link auto-perdido, mas são exibidos como texto em negrito.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Aqui você pode definir ou alterar as páginas de base do sistema utilizadas na Wiki. Por favor, certifique-se de que você não se esqueça de criar ou alterar as páginas correspondentes no Wiki de acordo com suas configurações aqui.',
	'PagesSettingsUpdated'		=> 'Páginas de base de configurações atualizadas',

	'ListCount'					=> 'Número de itens por lista:',
	'ListCountInfo'				=> 'Número de itens exibidos em cada lista para visitantes, ou como valor padrão para novos usuários.',

	'ForumSection'				=> 'Opções de Fórum',
	'ForumCluster'				=> 'Fórum do cluster:',
	'ForumClusterInfo'			=> 'Root cluster da seção do fórum (ação %1).',
	'ForumTopics'				=> 'Número de tópicos por página:',
	'ForumTopicsInfo'			=> 'Número de tópicos exibidos em cada página da lista nas seções do fórum (ação %1).',
	'CommentsCount'				=> 'Número de comentários por página:',
	'CommentsCountInfo'			=> 'Número de comentários exibidos na lista de comentários de cada página. Isso aplica-se a todos os comentários do site, não apenas aos que postaram no fórum.',

	'NewsSection'				=> 'Notícias da seção',
	'NewsCluster'				=> 'Aglomerado para as notícias:',
	'NewsClusterInfo'			=> 'Grupo de raiz para a seção de notícias (ação %1).',
	'NewsStructure'				=> 'Estrutura do cluster de notícias:',
	'NewsStructureInfo'			=> 'Armazena os artigos opcionalmente em subclusters por ano/mês ou semana (por exemplo, <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Tipo:',
	'DefaultLicense'			=> 'Licença padrão:',
	'DefaultLicenseInfo'		=> 'Sob o qual a licença seu conteúdo pode ser publicado.',
	'EnableLicense'				=> 'Habilitar licença:',
	'EnableLicenseInfo'			=> 'Habilite para mostrar informações de licença.',
	'LicensePerPage'			=> 'Licença por página:',
	'LicensePerPageInfo'		=> 'Permitir licença por página, que o proprietário da página pode escolher via propriedades da página.',

	'ServicePagesSection'		=> 'Páginas de Serviço',
	'RootPage'					=> 'Página inicial:',
	'RootPageInfo'				=> 'Etiqueta da sua página principal, abre automaticamente quando um usuário visita o seu site.',

	'PrivacyPage'				=> 'Política de privacidade:',
	'PrivacyPageInfo'			=> 'A página com a Política de Privacidade do site.',

	'TermsPage'					=> 'Políticas e regulamentos:',
	'TermsPageInfo'				=> 'A página com as regras do site.',

	'SearchPage'				=> 'Buscar:',
	'SearchPageInfo'			=> 'Página com o formulário de pesquisa (ação %1).',
	'RegistrationPage'			=> 'Registro:',
	'RegistrationPageInfo'		=> 'Página para o novo registro de usuário (ação %1).',
	'LoginPage'					=> 'Login do usuário:',
	'LoginPageInfo'				=> 'Página de login no site (ação %1).',
	'SettingsPage'				=> 'Configurações do Usuário:',
	'SettingsPageInfo'			=> 'Página para personalizar o perfil do usuário (ação %1).',
	'PasswordPage'				=> 'Alterar senha:',
	'PasswordPageInfo'			=> 'Página com um formulário para alterar / consultar senha do usuário (ação %1).',
	'UsersPage'					=> 'Lista de usuários:',
	'UsersPageInfo'				=> 'Página com uma lista de usuários registrados (ação %1).',
	'CategoryPage'				=> 'Categoria:',
	'CategoryPageInfo'			=> 'Página com uma lista de páginas categorizadas (ação %1).',
	'GroupsPage'				=> 'Grupos:',
	'GroupsPageInfo'			=> 'Página com uma lista de grupos de trabalho (ação %1).',
	'WhatsNewPage'				=> 'Quais as novidades:',
	'WhatsNewPageInfo'			=> 'Página com uma lista de todas as páginas novas, excluídas ou alteradas, novos anexos e comentários. (ação %1).',
	'ChangesPage'				=> 'Mudanças recentes:',
	'ChangesPageInfo'			=> 'Página com uma lista das últimas páginas modificadas (ação %1).',
	'CommentsPage'				=> 'Comentários recentes:',
	'CommentsPageInfo'			=> 'Página com uma lista de comentários recentes na página (ação %1).',
	'RemovalsPage'				=> 'Páginas excluídas:',
	'RemovalsPageInfo'			=> 'Página com uma lista de páginas excluídas recentemente (ação %1).',
	'WantedPage'				=> 'Páginas desejadas:',
	'WantedPageInfo'			=> 'Página com uma lista de páginas ausentes que são referenciadas (ação %1).',
	'OrphanedPage'				=> 'Páginas órfãs:',
	'OrphanedPageInfo'			=> 'Página com uma lista de páginas existentes não são relacionadas através de links para qualquer outra página (ação %1).',
	'SandboxPage'				=> 'Sandbox:',
	'SandboxPageInfo'			=> 'Página onde os usuários podem praticar suas habilidades de marcação na wiki.',
	'HelpPage'					=> 'Ajuda:',
	'HelpPageInfo'				=> 'A seção de documentação para trabalhar com ferramentas de site.',
	'IndexPage'					=> 'Índice',
	'IndexPageInfo'				=> 'Página com uma lista de todas as páginas (ação %1).',
	'RandomPage'				=> 'Aleatório:',
	'RandomPageInfo'			=> 'Carrega uma página aleatória (ação %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parâmetros para notificações da plataforma.',
	'NotificationSettingsUpdated'	=> 'Configurações de notificação atualizadas',

	'EmailNotification'			=> 'Notificação por e-mail:',
	'EmailNotificationInfo'		=> 'Permitir notificação por e-mail. Defina como habilitado para habilitar notificações por email, desativado para desativar. Note que desativar as notificações por email não tem efeito nos e-mails gerados como parte do processo de inscrição do usuário.',
	'Autosubscribe'				=> 'Inscrição automática:',
	'AutosubscribeInfo'			=> 'Notificar automaticamente o proprietário da alteração da página.',

	'NotificationSection'		=> 'Configurações padrão de notificação de usuário',
	'NotifyPageEdit'			=> 'Notificar edição de página:',
	'NotifyPageEditInfo'		=> 'Pendente - Enviar uma notificação de e-mail somente para a primeira alteração até o usuário visitar a página novamente.',
	'NotifyMinorEdit'			=> 'Notifique uma pequena edição:',
	'NotifyMinorEditInfo'		=> 'Envia notificações também para edições menores.',
	'NotifyNewComment'			=> 'Notificar novo comentário:',
	'NotifyNewCommentInfo'		=> 'Pendente - Enviar uma notificação por e-mail apenas para o primeiro comentário até o usuário visitar a página novamente.',

	'NotifyUserAccount'			=> 'Notificar nova conta de usuário:',
	'NotifyUserAccountInfo'		=> 'O Admin será notificado quando um novo usuário tiver sido criado utilizando o formulário de inscrição.',
	'NotifyUpload'				=> 'Notificar carregamento de arquivo:',
	'NotifyUploadInfo'			=> 'Os Moderadores serão notificados quando um arquivo for carregado.',

	'PersonalMessagesSection'	=> 'Mensagens Pessoais',
	'AllowIntercomDefault'		=> 'Permitir intercom:',
	'AllowIntercomDefaultInfo'	=> 'Ativar esta opção permite que outros usuários enviem mensagens pessoais para o endereço de e-mail do destinatário sem divulgar o endereço.',
	'AllowMassemailDefault'		=> 'Permitir e-mail em massa:',
	'AllowMassemailDefaultInfo'	=> 'Enviar mensagens apenas para aqueles usuários que permitiram os administradores enviarem e-mail para as informações.',

	// Resync settings
	'Synchronize'				=> 'Synchronize',
	'UserStatsSynched'			=> 'Estatísticas do usuário sincronizadas.',
	'PageStatsSynched'			=> 'Estatísticas de Página sincronizadas.',
	'FeedsUpdated'				=> 'Feeds RSS atualizados.',
	'SiteMapCreated'			=> 'A nova versão do mapa do site criada com sucesso.',
	'ParseNextBatch'			=> 'Analisar próximo lote de páginas:',
	'WikiLinksRestored'			=> 'Wiki-links restaurados.',

	'LogUserStatsSynched'		=> 'Estatísticas sincronizadas do usuário',
	'LogPageStatsSynched'		=> 'Estatísticas de páginas sincronizadas',
	'LogFeedsUpdated'			=> 'RSS feeds sincronizados',
	'LogPageBodySynched'		=> 'Corpo e links de página reanalisados',

	'UserStats'					=> 'Estatísticas do usuário',
	'UserStatsInfo'				=> 'Estatísticas do usuário (número de comentários, páginas de propriedade, revisões e arquivos) podem ser diferentes em algumas situações de dados reais. U <br>Esta operação permite a atualização de estatísticas para corresponder aos dados reais contidos no banco de dados.',
	'PageStats'					=> 'Estatísticas de página',
	'PageStatsInfo'				=> 'Estatísticas de página (número de comentários, arquivos e revisões) podem diferir em algumas situações dos dados reais. U <br>Esta operação permite a atualização de estatísticas para corresponder aos dados reais da base de dados.',

	'AttachmentsInfo'			=> 'Atualizar o hash do arquivo para todos os anexos no banco de dados.',
	'AttachmentsSynched'		=> 'Re-hashed todos os anexos de arquivos',
	'LogAttachmentsSynched'		=> 'Re-hashed todos os anexos de arquivos',

	'Feeds'						=> 'Conteúdos',
	'FeedsInfo'					=> 'No caso da edição direta de páginas na base de dados, o conteúdo dos feeds RSS pode não reflectir as alterações feitas. <br>Esta função sincroniza os canais RSS-com o estado atual do banco de dados.',
	'XmlSiteMap'				=> 'XML Sitemap',
	'XmlSiteMapInfo'			=> 'Esta função sincroniza o XML-Sitemap com o estado atual do banco de dados.',
	'XmlSiteMapPeriod'			=> 'Período %1 dias. Último escrito %2.',
	'XmlSiteMapView'			=> 'Exibir o mapa do site em uma nova janela.',

	'ReparseBody'				=> 'Reanalisar todas as páginas',
	'ReparseBodyInfo'			=> 'Vazio <code>body_r</code> na tabela de páginas, para que cada página seja renderizada novamente na próxima exibição de página. Isto pode ser útil se você modificou o formatador ou mudou o domínio da sua wiki.',
	'PreparsedBodyPurged'		=> 'Esvaziado campo <code>body_r</code> na tabela de página.',

	'WikiLinksResync'			=> 'Links da wiki',
	'WikiLinksResyncInfo'		=> 'Executa uma re-renderização para todos os links intrasite e restaura o conteúdo das tabelas <code>page_link</code> e <code>file_link</code> em caso de dano ou deslocalização (isso pode levar um tempo considerável).',
	'RecompilePage'				=> 'Recompilando todas as páginas (extremamente caro)',
	'ResyncOptions'				=> 'Opções adicionais',
	'RecompilePageLimit'		=> 'Número de páginas para analisar de uma vez.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Esta informação é utilizada quando o mecanismo envia e-mails para os seus usuários. Por favor, certifique-se de que o endereço de e-mail especificado é válido, pois qualquer mensagem devolvida ou não entregue provavelmente será enviada para esse endereço. Se o seu provedor de hospedagem não fornece um serviço de e-mail nativo (PHP-base), você pode, em vez disso, enviar mensagens diretamente usando SMTP. Isto requer o endereço de um servidor apropriado (pergunte ao seu provedor de hospedagem, se necessário). Se o servidor requer autenticação (e apenas se necessária), digite o nome de usuário, senha e método de autenticação.',

	'EmailSettingsUpdated'		=> 'Configurações de e-mail atualizadas',

	'EmailFunctionName'			=> 'Nome da função Email:',
	'EmailFunctionNameInfo'		=> 'A função de e-mail usada para enviar e-mails através de PHP.',
	'UseSmtpInfo'				=> 'Selecione <code>SMTP</code> se você quiser ou tiver que enviar e-mail através de um servidor nomeado em vez de através da função mail local.',

	'EnableEmail'				=> 'Habilitar e-mails:',
	'EnableEmailInfo'			=> 'Habilitar o envio de e-mails.',

	'EmailIdentitySettings'		=> 'Identidades de e-mail do site',
	'FromEmailName'				=> 'Nome De:',
	'FromEmailNameInfo'			=> 'O nome do remetente que é usado para o cabeçalho <code>De:</code> para todas as notificações por e-mail enviadas a partir do site.',
	'EmailSubjectPrefix'		=> 'Prefixo do assunto:',
	'EmailSubjectPrefixInfo'	=> 'Prefixo para assunto do email alternativo, por exemplo, <code>[Prefix] Tópico</code>. Se não for definido, o prefixo padrão é o Nome do Site: %1.',

	'NoReplyEmail'				=> 'Endereço para No-resposta:',
	'NoReplyEmailInfo'			=> 'Este endereço, por exemplo, <code>noreply@example.com</code>, aparecerá no campo de endereço de email <code>de:</code> de todas as notificações de email enviadas a partir do site.',
	'AdminEmail'				=> 'E-mail do proprietário do site:',
	'AdminEmailInfo'			=> 'Esse endereço é usado para fins administrativos, como uma nova notificação de usuário.',
	'AbuseEmail'				=> 'Serviço de abuso de e-mail:',
	'AbuseEmailInfo'			=> 'Solicitações de endereço para assuntos urgentes: registro de um e-mail estrangeiro, etc. Pode ser o mesmo que o e-mail do proprietário do site.',

	'SendTestEmail'				=> 'Enviar um e-mail de teste',
	'SendTestEmailInfo'			=> 'Enviaremos um e-mail de teste para o endereço definido na sua conta.',
	'TestEmailSubject'			=> 'O seu Wiki está configurado corretamente para enviar e-mails',
	'TestEmailBody'				=> 'Se você recebeu este e-mail, o Wiki está configurado corretamente para enviar e-mails.',
	'TestEmailMessage'			=> 'O e-mail de teste foi enviado.<br>Se você não o receber, por favor, verifique as suas configurações de e-mail.',

	'SmtpSettings'				=> 'Configurações de SMTP',
	'SmtpAutoTls'				=> 'TLS Oportunista:',
	'SmtpAutoTlsInfo'			=> 'Habilita a criptografia automaticamente, se ele vir que o servidor está publicitando TLS (depois de ter conectado ao servidor), mesmo se você não configurou o modo de conexão <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Modo de conexão SMTP:',
	'SmtpConnectionModeInfo'	=> 'Usado somente se um nome de usuário/senha for necessário. Pergunte ao seu provedor se você não tem certeza qual método usar',
	'SmtpPassword'				=> 'Senha do SMTP:',
	'SmtpPasswordInfo'			=> 'Insira uma senha somente se o seu servidor SMTP exigir.<br><em><strong>Aviso:</strong> Esta senha será armazenada como texto simples no banco de dados, visível para todos que podem acessar seu banco de dados ou que podem visualizar esta página de configuração.</em>',
	'SmtpPort'					=> 'Porta do servidor SMTP:',
	'SmtpPortInfo'				=> 'Só altere isso se você sabe que seu servidor SMTP está em uma porta diferente. <br>(padrão: <code>tls</code> na porta 587 (ou possivelmente 25) e <code>ssl</code> na porta 465).',
	'SmtpServer'				=> 'Endereço do servidor SMTP:',
	'SmtpServerInfo'			=> 'Note que você precisa fornecer o protocolo que seu servidor usa. Se você está usando SSL, este deve ser o protocolo <code>ssl://mail.example.com</code>.',
	'SmtpUsername'				=> 'Usuário SMTP:',
	'SmtpUsernameInfo'			=> 'Insira um nome de usuário somente se o servidor SMTP o exigir.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Aqui você pode configurar as configurações principais para anexos e categorias especiais associadas.',
	'UploadSettingsUpdated'		=> 'Configurações de envio atualizadas',

	'FileUploadsSection'		=> 'Carregamentos de Arquivos',
	'RegisteredUsers'			=> 'usuários registrados',
	'RightToUpload'				=> 'Permissões para enviar arquivos:',
	'RightToUploadInfo'			=> '<code>admins</code> significa que apenas usuários do grupo de administradores podem fazer upload de arquivos. <code>1</code> significa que o envio é aberto para usuários registrados. <code>0</code> significa que o envio está desativado.',
	'UploadMaxFilesize'			=> 'Tamanho máximo do arquivo:',
	'UploadMaxFilesizeInfo'		=> 'Tamanho máximo para cada arquivo. Se este valor é 0, o tamanho máximo de arquivos para upload é limitado apenas pela sua configuração do PHP.',
	'UploadQuota'				=> 'Cota total de anexos:',
	'UploadQuotaInfo'			=> 'Espaço máximo disponível para anexos para toda a wiki, com <code>0</code> sendo ilimitado. %1 usado.',
	'UploadQuotaUser'			=> 'Cota de armazenamento por usuário:',
	'UploadQuotaUserInfo'		=> 'Restrição sobre a cota de armazenamento que pode ser carregada por um usuário, sendo ilimitada <code>0</code>.',

	'FileTypes'					=> 'Tipos de arquivo',
	'UploadOnlyImages'			=> 'Permitir apenas o envio de imagens:',
	'UploadOnlyImagesInfo'		=> 'Permitir apenas o envio de arquivos de imagem na página.',
	'AllowedUploadExts'			=> 'Tipos de arquivo permitidos:',
	'AllowedUploadExtsInfo'		=> 'Extensões permitidas para o envio de arquivos, separados por vírgula (ou seja, <code>png, ogg, mp4</code>); caso contrário, todas as extensões de arquivos são permitidas.<br>Você deve limitar as extensões de arquivos permitidas ao mínimo necessário para as funcionalidades adequadas do seu site.',
	'CheckMimetype'				=> 'Verificar tipo MIME:',
	'CheckMimetypeInfo'			=> 'Alguns navegadores podem ser enganados para assumir um mimetype incorreto para arquivos carregados. Esta opção garante que esses arquivos provavelmente causam isso sejam rejeitados.',
	'SvgSanitizer'				=> 'SVG sanitizador:',
	'SvgSanitizerInfo'			=> 'Isto permite sanitizar arquivos SVG para impedir que vulnerabilidades SVG/XML sejam carregadas.',
	'TranslitFileName'			=> 'Transliterar nomes de arquivos:',
	'TranslitFileNameInfo'		=> 'Se for aplicável e não houver necessidade de ter caracteres Unicode, é altamente recomendável aceitar apenas caracteres alfanuméricos em nomes de arquivos.',
	'TranslitCaseFolding'		=> 'Converter nomes de arquivos para minúsculas:',
	'TranslitCaseFoldingInfo'	=> 'Esta opção só é eficaz com transliteração ativa.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Create thumbnail:',
	'CreateThumbnailInfo'		=> 'Crie uma miniatura em todas as situações possíveis.',
	'JpegQuality'				=> 'Qualidade do JPEG:',
	'JpegQualityInfo'			=> 'Qualidade ao dimensionar uma miniatura JPEG. Ela deve estar entre 1 e 100, indicando 100% de qualidade.',
	'MaxImageArea'				=> 'Área de imagem máxima:',
	'MaxImageAreaInfo'			=> 'O número máximo de pixels que uma imagem de origem pode ter. Isso fornece um limite no uso de memória para o lado de descompactação da escala da imagem.<br><code>-1</code> significa que ele não irá verificar o tamanho da imagem antes de tentar escaloná-la. <code>0</code> significa que ele determinará o valor automaticamente.',
	'MaxThumbWidth'				=> 'Largura máxima da miniatura em pixels:',
	'MaxThumbWidthInfo'			=> 'A miniatura gerada não irá exceder a largura definida aqui.',
	'MinThumbFilesize'			=> 'Tamanho mínimo de arquivo em miniatura:',
	'MinThumbFilesizeInfo'		=> 'Não crie uma miniatura para imagens menores que esta.',
	'MaxImageWidth'				=> 'Limite de tamanho de imagem em páginas:',
	'MaxImageWidthInfo'			=> 'A largura máxima que uma imagem pode ter nas páginas, caso contrário, uma miniatura redimensionada será gerada.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Lista de páginas removidas, revisões e arquivos. U
									eé-vésprima&rbbamprrrb+rrbwrrrb+rba&rbr e restaurar as páginas, revisões ou arquivos do banco de dados clicando sobre o link <em>Remover</em>
									├├├├├├├├and <em>Restaurar</em> na linha correspondente. (Cuidado, nenhuma confirmação de exclusão foi solicitada!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Palavras que serão automaticamente censuradas no seu Wiki.',
	'FilterSettingsUpdated'		=> 'Configurações de filtro de spam atualizadas',

	'WordCensoringSection'		=> 'Censura de Palavras',
	'SPAMFilter'				=> 'Filtro de spam:',
	'SPAMFilterInfo'			=> 'Ativando Filtro de Spam',
	'WordList'					=> 'Lista de palavras:',
	'WordListInfo'				=> 'Palavra ou frase <code>fragmento</code> a ser colocado na lista negra (uma por linha)',

	// Log module
	'LogFilterTip'				=> 'Filtrar eventos por critério:',
	'LogLevel'					=> 'Nível',
	'LogLevelFilters'	=> [
		'1'		=> 'não menos do que',
		'2'		=> 'não superior a',
		'3'		=> 'Igual',
	],
	'LogNoMatch'				=> 'Nenhum evento que atenda ao critério',
	'LogDate'					=> 'Encontro',
	'LogEvent'					=> 'Evento',
	'LogUsername'				=> 'Usuário:',
	'LogLevels'	=> [
		'1'		=> 'crítico',
		'2'		=> 'maior',
		'3'		=> 'Alto',
		'4'		=> 'Médio',
		'5'		=> 'Baixa',
		'6'		=> 'abaixar',
		'7'		=> 'Depuração',
	],

	// Massemail module
	'MassemailInfo'				=> 'Aqui você pode enviar uma mensagem para (1) todos os seus usuários ou (2) todos os usuários de um grupo específico que permitiram a recepção de e-mails em massa. Um e-mail será enviado para o endereço de e-mail administrativo fornecido, com uma cópia oculta (BCC) enviada a todos os destinatários. A configuração padrão é incluir um máximo de 20 destinatários em tal email. Se houver mais de 20 destinatários, e-mails adicionais serão enviados. Se enviar um e-mail para um grande grupo de pessoas, seja paciente depois de submeter e não pare a página a meio do caminho. É normal que um e-mail em massa leve um longo tempo. Você será notificado quando o script tiver terminado.',
	'LogMassemail'				=> 'Enviar e-mail em massa %1 para o grupo / usuário ',
	'MassemailSend'				=> 'E-mail em massa enviar',

	'NoEmailMessage'			=> 'Você deve digitar uma mensagem.',
	'NoEmailSubject'			=> 'É necessário especificar um assunto para sua mensagem.',
	'NoEmailRecipient'			=> 'Você deve especificar pelo menos um grupo de usuário ou usuário.',

	'MassemailSection'			=> 'E-mail em massa',
	'MessageSubject'			=> 'Assunto:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'Sua mensagem:',
	'YourMessageInfo'			=> 'Por favor, note que você só pode inserir texto em linguagem simples. Todas as marcações serão removidas antes do envio.',

	'NoUser'					=> 'Nenhum usuário',
	'NoUserGroup'				=> 'Nenhum grupo de usuário',

	'SendToGroup'				=> 'Enviar para grupo:',
	'SendToUser'				=> 'Enviar para o usuário:',
	'SendToUserInfo'			=> 'Apenas usuários que permitirem que os Administradores enviem um e-mail com informações receberão e-mails em massa. Esta opção está disponível nas configurações do usuário em Notificações.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Mensagem do sistema atualizada',

	'SysMsgSection'				=> 'Sistema de mensagem',
	'SysMsg'					=> 'Mensagem do sistema:',
	'SysMsgInfo'				=> 'Seu texto aqui',

	'SysMsgType'				=> 'Tipo:',
	'SysMsgTypeInfo'			=> 'Tipo de mensagem (CSS).',
	'SysMsgAudience'			=> 'Audiência:',
	'SysMsgAudienceInfo'		=> 'Audiência a mensagem do sistema mostrada.',
	'EnableSysMsg'				=> 'Ativar mensagem do sistema:',
	'EnableSysMsgInfo'			=> 'Mostrar mensagem do sistema.',

	// User approval module
	'ApproveNotExists'			=> 'Por favor, selecione pelo menos um usuário através do botão Configurar.',

	'LogUserApproved'			=> 'Usuário ##%1## aprovado',
	'LogUserBlocked'			=> 'Usuário ##%1## bloqueado',
	'LogUserDeleted'			=> 'Usuário ##%1## removido do banco de dados',
	'LogUserCreated'			=> 'Criou um novo usuário ##%1##',
	'LogUserUpdated'			=> 'Usuário atualizado ##%1##',
	'LogUserPasswordReset'		=> 'Senha para usuário ##%1## redefinida com sucesso',

	'UserApproveInfo'			=> 'Aprovar novos usuários antes que eles possam acessar o site.',
	'Approve'					=> 'Aprovar',
	'Deny'						=> 'Recusar',
	'Pending'					=> 'PENDENTE',
	'Approved'					=> 'Aceito',
	'Denied'					=> 'Negado',

	// DB Backup module
	'BackupStructure'			=> 'Estrutura',
	'BackupData'				=> 'Dado',
	'BackupFolder'				=> 'pasta',
	'BackupTable'				=> 'Classificações',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'arquivos',
	'BackupNote'				=> 'Nota:',
	'BackupSettings'			=> 'Especifique o esquema de backup desejado.<br>' .
    	'O cluster raiz não afeta o backup dos arquivos globais e o backup dos arquivos de cache (se escolhido, eles são sempre salvos na íntegra).<br>' .  '<br>' .
		'<strong>Atenção</strong>: Para evitar a perda de informações do banco de dados ao especificar o cluster de raiz, as tabelas deste backup não serão reestruturadas, o mesmo que durante o backup somente da estrutura de tabelas sem salvar os dados. Para fazer uma conversão completa das tabelas para o formato de backup, é necessário fazer o <em> backup completo da base de dados (estrutura e dados) sem especificar o cluster</em>.',
	'BackupCompleted'			=> 'Backup e arquivamento concluído.<br>' .
    	'Os arquivos do pacote de Backup foram armazenados no sub-diretório %1.<br>Para baixar, use FTP (mantenha a estrutura do diretório e os nomes de arquivos durante a cópia).<br> Para restaurar uma cópia de segurança ou remover um pacote, vá para <a href="%2">Restaurar banco de dados</a>.',
	'LogSavedBackup'			=> 'Banco de dados de backup salvo ##%1##',
	'Backup'					=> 'Backup',
	'CantReadFile'				=> 'Não é possível ler o arquivo %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Você pode restaurar qualquer um dos pacotes de backup encontrados ou removê-los do servidor.',
	'ConfirmDbRestore'			=> 'Deseja restaurar o backup %1?',
	'ConfirmDbRestoreInfo'		=> 'Por favor, aguarde, isso pode levar algum tempo.',
	'RestoreWrongVersion'		=> 'Versão errada do WackoWiki!',
	'DirectoryNotExecutable'	=> 'O diretório %1 não é executável.',
	'BackupDelete'				=> 'Tem certeza que deseja remover a cópia de segurança %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Opções de restauração adicionais:',
	'RestoreOptionsInfo'		=> '* Antes de restaurar o backup do cluster <strong></strong>, ' .
									'as tabelas alvo não são excluídas (para evitar perda de informações dos agrupamentos que não foram salvas). ' .
									'Assim, durante o processo de recuperação de registros duplicados ocorrerão. ' .
									'No modo normal, todas elas serão substituídas pelo backup do formulário de registros (usando SQL <code>REPLACE</code>), ' .
									'mas se esta opção estiver marcada, todas as duplicatas são ignoradas (os valores atuais dos registros serão mantidos), ' .
									'e apenas os registros com novas chaves são adicionados à tabela (SQL <code>INSERIR IGNORE</code>).<br>' .
									'<strong>Aviso</strong>: Quando restaurar o backup completo do site, esta opção não tem valor.<br>' .
									'<br>' .
									'** Se o backup contiver os arquivos de usuário (global e por página, arquivos de cache, etc.), ' .
									'no modo normal eles substituem os arquivos existentes pelos mesmos nomes e são colocados no mesmo diretório quando restaurados. ' .
									'Esta opção permite que você salve as cópias atuais dos arquivos e restaure de um backup apenas de novos arquivos (em falta no servidor).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignorar chaves de tabela duplicadas (não substituir)',
	'IgnoreSameFiles'			=> 'Ignorar os mesmos arquivos (não sobrescrever)',
	'NoBackupsAvailable'		=> 'Backups não disponíveis.',
	'BackupEntireSite'			=> 'Todo o site',
	'BackupRestored'			=> 'O backup foi restaurado, um relatório de resumo está anexado abaixo. Para excluir este pacote de backup, clique',
	'BackupRemoved'				=> 'O backup selecionado foi removido com sucesso.',
	'LogRemovedBackup'			=> 'Backup do banco de dados removido ##%1##',

	'RestoreStarted'			=> 'Restauração iniciada',
	'RestoreParameters'			=> 'Usando parâmetros',
	'IgnoreDuplicatedKeys'		=> 'Ignorar chaves duplicadas',
	'IgnoreDuplicatedFiles'		=> 'Ignorar arquivos duplicados',
	'SavedCluster'				=> 'Classe salva',
	'DataProtection'			=> 'Proteção de dados - %1 omitido',
	'AssumeDropTable'			=> 'Assume %1',
	'RestoreTableStructure'		=> 'Restaurando a estrutura da tabela',
	'RunSqlQueries'				=> 'Executar instruções SQL:',
	'CompletedSqlQueries'		=> 'Concluído. Instruções processadas:',
	'NoTableStructure'			=> 'A estrutura das tabelas não foi salva - pule',
	'RestoreRecords'			=> 'Restaurar o conteúdo das tabelas',
	'ProcessTablesDump'			=> 'Basta baixar e processar dumps de tabela',
	'Instruction'				=> 'Instrução',
	'RestoredRecords'			=> 'registros:',
	'RecordsRestoreDone'		=> 'Total de entradas concluídas:',
	'SkippedRecords'			=> 'Dados não salvos - pular',
	'RestoringFiles'			=> 'Restaurando arquivos',
	'DecompressAndStore'		=> 'Descompactar e armazenar o conteúdo de diretórios',
	'HomonymicFiles'			=> 'arquivos homônimos',
	'RestoreSkip'				=> 'Pular',
	'RestoreReplace'			=> 'substituir',
	'RestoreFile'				=> 'Arquivo:',
	'RestoredFiles'				=> 'restaurado:',
	'SkippedFiles'				=> 'ignorado:',
	'FileRestoreDone'			=> 'Total de arquivos concluídos:',
	'FilesAll'					=> 'todos:',
	'SkipFiles'					=> 'Os arquivos não são armazenados - pular',
	'RestoreDone'				=> 'RESTAURAÇÃO CONCLUÍDA',

	'BackupCreationDate'		=> 'Data de Criação',
	'BackupPackageContents'		=> 'O conteúdo do pacote',
	'BackupRestore'				=> 'RESTAURAR',
	'BackupRemove'				=> 'Excluir',
	'RestoreYes'				=> 'sim',
	'RestoreNo'					=> 'Não',
	'LogDbRestored'				=> 'Backup ##%1## do banco de dados restaurado.',

	'BackupArchived'			=> 'Backup %1 arquivado.',
	'BackupArchiveExists'		=> 'Backup do arquivo %1 já existe.',
	'LogBackupArchived'			=> 'Backup ##%1## arquivado.',

	// User module
	'UsersInfo'					=> 'Aqui você pode alterar as informações dos usuários e algumas opções específicas.',

	'UsersAdded'				=> 'Usuário adicionado',
	'UsersDeleteInfo'			=> 'Excluir usuário:',
	'EditButton'				=> 'Alterar',
	'UsersAddNew'				=> 'Adicionar novo usuário',
	'UsersDelete'				=> 'Tem certeza que deseja remover o usuário %1?',
	'UsersDeleted'				=> 'O usuário %1 foi excluído do banco de dados.',
	'UsersRename'				=> 'Renomear o usuário %1 para',
	'UsersRenameInfo'			=> '* Nota: A alteração afetará todas as páginas que são atribuídas a este usuário.',
	'UsersUpdated'				=> 'Usuário atualizado com sucesso.',

	'UserIP'					=> 'PI',
	'UserSignuptime'			=> 'Cadastro',
	'UserActions'				=> 'Ações.',
	'NoMatchingUser'			=> 'Nenhum usuário que atenda ao critério',

	'UserAccountNotify'			=> 'Notificar usuário',
	'UserNotifySignup'			=> 'informar o usuário sobre a nova conta',
	'UserVerifyEmail'			=> 'definir token de confirmação de e-mail e adicionar link para verificação de e-mail',
	'UserReVerifyEmail'			=> 'Reenviar token de confirmação de e-mail',

	// Groups module
	'GroupsInfo'				=> 'A partir deste painel você pode administrar todos os seus grupos de usuários. Você pode excluir, criar e editar grupos existentes. Além disso, você pode escolher os líderes do grupo, alternar entre status de grupo aberto/oculto/fechado e definir o nome e a descrição do grupo.',

	'LogMembersUpdated'			=> 'Membros do grupo usuário atualizados',
	'LogMemberAdded'			=> 'Adicionado membro ##%1## ao grupo ## ##%2##',
	'LogMemberRemoved'			=> 'Membro removido ##%1## do grupo ## ##%2##',
	'LogGroupCreated'			=> 'Criou um novo grupo ##%1##',
	'LogGroupRenamed'			=> 'Grupo ##%1## renomeado para ##%2##',
	'LogGroupRemoved'			=> 'Grupo removido ##%1##',

	'GroupsMembersFor'			=> 'Membros do Grupo',
	'GroupsDescription'			=> 'Descrição:',
	'GroupsModerator'			=> 'Moderador(a)',
	'GroupsOpen'				=> 'Abertas',
	'GroupsActive'				=> 'ativo',
	'GroupsTip'					=> 'Clique para editar o grupo',
	'GroupsUpdated'				=> 'Grupos atualizados',
	'GroupsAlreadyExists'		=> 'Este grupo já existe.',
	'GroupsAdded'				=> 'Grupo adicionado com sucesso.',
	'GroupsRenamed'				=> 'Grupo renomeado com sucesso.',
	'GroupsDeleted'				=> 'O grupo %1 e todas as páginas associadas foram excluídas do banco de dados.',
	'GroupsAdd'					=> 'Adicionar um novo grupo',
	'GroupsRename'				=> 'Renomear o grupo %1 para',
	'GroupsRenameInfo'			=> '* Nota: A mudança afetará todas as páginas que são atribuídas a esse grupo.',
	'GroupsDelete'				=> 'Tem certeza que deseja remover o grupo %1?',
	'GroupsDeleteInfo'			=> '* Nota: A mudança afetará todos os membros que são atribuídos a esse grupo.',
	'GroupsIsSystem'			=> 'O grupo %1 pertence ao sistema e não pode ser removido.',
	'GroupsStoreButton'			=> 'Salvar Grupos',
	'GroupsEditInfo'			=> 'Para editar a lista de grupos, selecione o botão de rádio.',

	'GroupAddMember'			=> 'Adicionar membro',
	'GroupRemoveMember'			=> 'Remover Membro',
	'GroupAddNew'				=> 'Adicionar grupo',
	'GroupEdit'					=> 'Editar Grupo',
	'GroupDelete'				=> 'Remover Grupo',

	'MembersAddNew'				=> 'Adicionar novo membro',
	'MembersAdded'				=> 'Novo membro adicionado ao grupo com sucesso.',
	'MembersRemove'				=> 'Tem certeza que deseja remover o membro %1?',
	'MembersRemoved'			=> 'O membro foi removido do grupo.',

	// Statistics module
	'DbStatSection'				=> 'Estatísticas do banco',
	'DbTable'					=> 'Classificações',
	'DbRecords'					=> 'registros',
	'DbSize'					=> 'Tamanho',
	'DbIndex'					=> 'Indexação',
	'DbTotal'					=> 'Total:',

	'FileStatSection'			=> 'Estatísticas do Sistema de Arquivos',
	'FileFolder'				=> 'pasta',
	'FileFiles'					=> 'arquivos',
	'FileSize'					=> 'Tamanho',
	'FileTotal'					=> 'Total:',

	// Sysinfo module
	'SysInfo'					=> 'Informações da versão:',
	'SysParameter'				=> 'Parâmatro',
	'SysValues'					=> 'Valores',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Última atualização',
	'ServerOS'					=> 'S.O.',
	'ServerName'				=> 'Nome do servidor',
	'WebServer'					=> 'Servidor Web',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'Banco',
	'SqlModesGlobal'			=> 'Modo SQL Global',
	'SqlModesSession'			=> 'Sessão de Modos SQL',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memória',
	'UploadFilesizeMax'			=> 'Upload máximo de arquivos',
	'PostMaxSize'				=> 'Tamanho máximo da postagem',
	'MaxExecutionTime'			=> 'Tempo máximo de execução',
	'SessionPath'				=> 'Caminho de sessão',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'Compressão gzip',
	'PhpExtensions'				=> 'Extensões do PHP',
	'ApacheModules'				=> 'Módulos do Apache',

	// DB repair module
	'DbRepairSection'			=> 'Base de Reparos',
	'DbRepair'					=> 'Base de Reparos',
	'DbRepairInfo'				=> 'Este script pode automaticamente procurar alguns problemas comuns na base de dados e repará-los. Reparar pode demorar um pouco, então, por favor, seja paciente.',

	'DbOptimizeRepairSection'	=> 'Reparar e Otimizar Banco de Dados',
	'DbOptimizeRepair'			=> 'Reparar e Otimizar Banco de Dados',
	'DbOptimizeRepairInfo'		=> 'Este script também pode tentar otimizar o banco de dados. Isso melhora o desempenho em algumas situações. Reparação e otimização do banco de dados pode levar muito tempo e o banco de dados ficará bloqueado enquanto estiver otimizando.',

	'TableOk'					=> 'A mesa %1 está boa.',
	'TableNotOk'				=> 'A tabela %1 não está ok. Ela está relatando o seguinte erro: %2. Este script tentará consertar esta tabela&hellip;',
	'TableRepaired'				=> 'Reparada com sucesso a tabela %1.',
	'TableRepairFailed'			=> 'Falha ao reparar a tabela %1 . <br>Erro: %2',
	'TableAlreadyOptimized'		=> 'A tabela %1 já está otimizada.',
	'TableOptimized'			=> 'Otimizado com sucesso a tabela %1.',
	'TableOptimizeFailed'		=> 'Falha ao otimizar a tabela %1 . <br>Erro: %2',
	'TableNotRepaired'			=> 'Alguns problemas de banco de dados não puderam ser reparados.',
	'RepairsComplete'			=> 'Reparos concluídos',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Exibir e corrigir inconsistências, apagar ou atribuir registros órfãos para um novo usuário / valor.',
	'Inconsistencies'			=> 'Inconsistências',
	'CheckDatabase'				=> 'Banco',
	'CheckDatabaseInfo'			=> 'Verifica se há inconsistências de registro no banco de dados.',
	'CheckFiles'				=> 'arquivos',
	'CheckFilesInfo'			=> 'Verifica arquivos abandonados, arquivos sem referência deixados na tabela de arquivos.',
	'Records'					=> 'registros',
	'InconsistenciesNone'		=> 'Nenhuma inconsistência de dados encontrada.',
	'InconsistenciesDone'		=> 'Inconsistências de dados resolvidas.',
	'InconsistenciesRemoved'	=> 'Inconsistências removidas',
	'Check'						=> 'Verificar',
	'Solve'						=> 'Resolver',

	// Bad Behaviour module
	'BbInfo'					=> 'Detecta e bloqueia acessos indesejados da web, negar acesso automatizado de spambots.<br>Para mais informações, visite a página inicial de %1.',
	'BbEnable'					=> 'Ativar mau comportamento:',
	'BbEnableInfo'				=> 'Todas as outras configurações podem ser alteradas na pasta de configuração %1.',
	'BbStats'					=> 'Bad Behaviour bloqueou tentativas de acesso de %1 nos últimos 7 dias.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Registro',
	'BbSettings'				=> 'Confirgurações',
	'BbWhitelist'				=> 'Lista Branca',

	// --> Log
	'BbHits'					=> 'Acertos',
	'BbRecordsFiltered'			=> 'Exibindo registros %1 de %2 filtrados por',
	'BbStatus'					=> 'SItuação',
	'BbBlocked'					=> 'Bloqueado',
	'BbPermitted'				=> 'Permitido',
	'BbIp'						=> 'PI',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Exibindo todos os registros %1',
	'BbShow'					=> 'Apresentar',
	'BbIpDateStatus'			=> 'IP/Data/Status',
	'BbHeaders'					=> 'Cabeçalhos',
	'BbEntity'					=> 'Entidade',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Opções salvas.',
	'BbWhitelistHint'			=> 'A lista branca inapropriada irá expor você a spam, ou fazer com que o mau comportamento pare de funcionar inteiramente! NÃO FAÇA WHITELIST a não ser que você esteja 100% CERTANTE que deveria.',
	'BbIpAddress'				=> 'Endereço IP',
	'BbIpAddressInfo'			=> 'Endereço IP ou intervalos de endereços de formato CIDR a serem whitelisted (um por linha)',
	'BbUrl'						=> 'URL:',
	'BbUrlInfo'					=> 'Fragmentos de URL que começam com / após o nome do host do seu site (um por linha)',
	'BbUserAgent'				=> 'Agente do usuário',
	'BbUserAgentInfo'			=> 'User agent strings a ser whitelisted (um por linha)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Configurações de mau comportamento atualizadas',
	'BbLogRequest'				=> 'Logging pedido HTTP',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (recomendado)',
	'BbLogOff'					=> 'Não registrar (não recomendado)',
	'BbSecurity'				=> 'Segurança',
	'BbStrict'					=> 'Verificação rigorosa',
	'BbStrictInfo'				=> 'bloqueia mais spam, mas pode bloquear algumas pessoas',
	'BbOffsiteForms'			=> 'Permitir postagens de formulários de outros sites',
	'BbOffsiteFormsInfo'		=> 'necessário para OpenID; aumenta spam recebido',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'Para usar os recursos de Comportamento Ruim http:BL, você deve ter um %1',
	'BbHttpblKey'				=> 'Chave de acesso http:BL',
	'BbHttpblThreat'			=> 'Nível de Ameaça Mínimo (25 é recomendado)',
	'BbHttpblMaxage'			=> 'Idade máxima dos dados (30 é recomendado)',
	'BbReverseProxy'			=> 'Balanço de Proxo/Carga Reverso',
	'BbReverseProxyInfo'		=> 'Se você estiver usando o Bad Behaviour atrás de um proxy reverso, balanceador de carregamento, acelerador de HTTP, cache de conteúdo ou tecnologia similar, ative a opção de Proxy Reverso.<br>' .
									'Se você tiver uma cadeia de dois ou mais proxies reversos entre seu servidor e a Internet pública, deverá especificar <em>todos</em> os intervalos de endereços IP (no formato CIDR) de todos os seus servidores proxy, balanceadores de carga, etc. Caso contrário, o Bad Behaviour pode não conseguir determinar o verdadeiro endereço IP do cliente.<br>' .
									'Além disso, os seus servidores de proxy reverso devem definir o endereço IP do cliente de Internet do qual receberam a solicitação num cabeçalho HTTP. Se você não especificar um cabeçalho, %1 será usado. A maioria dos servidores proxy já suporta X-Forwarded-For e então você só precisa garantir que ele esteja ativado nos seus servidores proxy. Alguns outros nomes de cabeçalho em uso comum incluem %2 e %3.',
	'BbReverseProxyEnable'		=> 'Habilitar Proxy Reverso',
	'BbReverseProxyHeader'		=> 'Cabeçalho contendo o endereço IP dos clientes Internet',
	'BbReverseProxyAddresses'	=> 'Endereço IP ou intervalo de endereços de formato CIDR para os seus servidores de proxy (um por linha)',

];
