<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$ap_translation = [

	'CategoryArray'		=> [
		'basics'		=> 'Funções básicas',
		'preferences'	=> 'Preferências',
		'content'		=> 'Conteúdo',
		'users'			=> 'Usuários',
		'maintenance'	=> 'Manutenção',
		'messages'		=> 'Mensagens',
		'extension'		=> 'Extensão',
		'database'		=> 'Base de dados',
	],

	// Admin panel
	'AdminPanel'				=> 'Painel de Administração',
	'RecoveryMode'				=> 'Modo de recuperação',
	'Authorization'				=> 'Autorização',
	'AuthorizationTip'			=> 'Digite a senha administrativa (certifique-se também de que os cookies são permitidos no seu navegador).',
	'NoRecoveryPassword'		=> 'A senha administrativa não é especificada!',
	'NoRecoveryPasswordTip'		=> 'Nota: A ausência de uma senha administrativa é uma ameaça à segurança! Digite sua senha no arquivo de configuração e execute o programa novamente.',

	'ErrorLoadingModule'		=> 'Erro ao carregar o módulo admin %1: não existe.',

	'ApHomePage'				=> 'Página inicial',
	'ApHomePageTip'				=> 'open the home page, you do not quit administration',
	'ApLogOut'					=> 'Desligar',
	'ApLogOutTip'				=> 'quit system administration',

	'TimeLeft'					=> 'Tempo restante: %1 minutos',
	'ApVersion'					=> 'versão',

	'SiteOpen'					=> 'Abrir',
	'SiteOpened'				=> 'site aberto',
	'SiteOpenedTip'				=> 'O site está aberto',
	'SiteClose'					=> 'Fechar',
	'SiteClosed'				=> 'site fechado',
	'SiteClosedTip'				=> 'O site está fechado',

	'System'					=> 'Sistema',

	// Generic
	'Cancel'					=> 'Cancelar',
	'Add'						=> 'Adicionar',
	'Edit'						=> 'Editar',
	'Remove'					=> 'Remover',
	'Enabled'					=> 'Ativado',
	'Disabled'					=> 'Desativado',
	'Mandatory'					=> 'Obrigatório',
	'Admin'						=> 'Administrador',
	'Min'						=> 'Mínimo',
	'Max'						=> 'Máximo',

	'MiscellaneousSection'		=> 'Diversos',
	'MainSection'				=> 'Opções Gerais',

	'DirNotWritable'			=> 'O diretório %1 não pode ser escrito.',
	'FileNotWritable'			=> 'O arquivo %1 não pode ser escrito.',

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
		'title'		=> 'Parâmetros básicos',
	],

	// Config Appearance module
	'config_appearance'		=> [
		'name'		=> 'Aparência',
		'title'		=> 'Configurações de aparência',
	],

	// Config Email module
	'config_email'		=> [
		'name'		=> 'E-mail',
		'title'		=> 'Configurações de e-mail',
	],

	// Config Syndication module
	'config_syndication'		=> [
		'name'		=> 'Sindicação',
		'title'		=> 'Configurações de sindicação',
	],

	// Config Filter module
	'config_filter'		=> [
		'name'		=> 'Filtrar',
		'title'		=> 'Configurações do filtro',
	],

	// Config Formatter module
	'config_formatter'		=> [
		'name'		=> 'Formatador',
		'title'		=> 'Opções de formatação',
	],

	// Config Notifications module
	'config_notifications'		=> [
		'name'		=> 'Notificações',
		'title'		=> 'Configurações de notificações',
	],

	// Config Pages module
	'config_pages'		=> [
		'name'		=> 'Páginas',
		'title'		=> 'Páginas e parâmetros do site',
	],

	// Config Permissions module
	'config_permissions'		=> [
		'name'		=> 'Permissões',
		'title'		=> 'Configurações de permissões',
	],

	// Config Security module
	'config_security'		=> [
		'name'		=> 'Segurança',
		'title'		=> 'Configurações dos subsistemas de segurança',
	],

	// Config System module
	'config_system'		=> [
		'name'		=> 'Sistema',
		'title'		=> 'Opções do sistema',
	],

	// Config Upload module
	'config_upload'		=> [
		'name'		=> 'Enviar',
		'title'		=> 'Definições dos Anexos',
	],

	// Deleted module
	'content_deleted'		=> [
		'name'		=> 'Eliminado',
		'title'		=> 'Conteúdo deletado recentemente',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Adicionar, editar ou remover itens de menu padrão',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Cópia de segurança',
		'title'		=> 'Fazendo backup dos dados',
	],

	// DB Repair module
	'db_repair'		=> [
		'name'		=> 'Reparar',
		'title'		=> 'Reparar e Otimizar o Banco de Dados',
	],

	// DB Restore module
	'db_restore'		=> [
		'name'		=> 'Restaurar',
		'title'		=> 'Restaurar dados da cópia de segurança',
	],

	// Dashboard module
	'main'		=> [
		'name'		=> 'Menu principal',
		'title'		=> 'Administração de WackoWiki',
	],

	// Inconsistencies module
	'maint_inconsistencies'		=> [
		'name'		=> 'Inconsistências',
		'title'		=> 'Correção de inconsistências de dados',
	],

	// Data Synchronization module
	'maint_resync'		=> [
		'name'		=> 'Sincronização de dados',
		'title'		=> 'Sincronização de dados',
	],

	// Mass email module
	'massemail'		=> [
		'name'		=> 'E-mails em massa',
		'title'		=> 'E-mails em massa',
	],

	// System message module
	'messages'		=> [
		'name'		=> 'Mensagem do sistema',
		'title'		=> 'Mensagens do sistema',
	],

	// System Info module
	'system_info'		=> [
		'name'		=> 'Informação do Sistema',
		'title'		=> 'Informação do Sistema',
	],

	// System log module
	'system_log'		=> [
		'name'		=> 'System log',
		'title'		=> 'Log de eventos do sistema',
	],

	// Statistics module
	'system_statistics'		=> [
		'name'		=> 'Estatística',
		'title'		=> 'Mostrar estatísticas',
	],

	// Bad Behaviour module
	'tool_badbehaviour'		=> [
		'name'		=> 'Má conduta',
		'title'		=> 'Má conduta',
	],

	// Registration Approval module
	'user_approve'		=> [
		'name'		=> 'Aprovar',
		'title'		=> 'Registro do Utilizador aprovado',
	],

	// Groups module
	'user_groups'		=> [
		'name'		=> 'Grupos',
		'title'		=> 'Gestão de grupos',
	],

	// User module
	'user_users'		=> [
		'name'		=> 'Usuários',
		'title'		=> 'Gestão de utilizadores',
	],

	// Main module
	'MainNote'					=> 'Nota: É recomendável que o acesso ao site seja temporariamente bloqueado para manutenção administrativa.',

	'PurgeSessions'				=> 'Purgar',
	'PurgeSessionsTip'			=> 'Terminar todas as sessões',
	'PurgeSessionsConfirm'		=> 'Tem certeza que deseja terminar todas as sessões? Esta ação terminará as sessões de todos os utilizadores.',
	'PurgeSessionsExplain'		=> 'Eliminar todas as sessões. Isto irá terminar a sessão de todos os utilizadores, truncando a tabela auth_token.',
	'PurgeSessionsDone'			=> 'Sessões eliminadas com sucesso.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Definições básicas actualizadas',
	'LogBasicSettingsUpdated'	=> 'Definições básicas actualizadas',

	'SiteName'					=> 'Nome do Site:',
	'SiteNameInfo'				=> 'O título deste site. Aparece no título do navegador, cabeçalho do tema, notificação por e-mail, etc.',
	'SiteDesc'					=> 'Descrição do Site:',
	'SiteDescInfo'				=> 'Complemento ao título do site que aparece no cabeçalho das páginas. Explica, em poucas palavras, sobre o que é este site.',
	'AdminName'					=> 'Admin do site:',
	'AdminNameInfo'				=> 'Nome do utilizador, que é responsável pelo apoio geral do sítio. Este nome não é utilizado para determinar os direitos de acesso, mas é desejável que esteja em conformidade com o nome do administrador principal do sítio.',

	'LanguageSection'			=> 'Língua',
	'DefaultLanguage'			=> 'Língua predefinida:',
	'DefaultLanguageInfo'		=> 'Especifica o idioma das mensagens apresentadas aos convidados não registados, bem como as definições de localidade.',
	'MultiLanguage'				=> 'Suporte multilingue:',
	'MultiLanguageInfo'			=> 'Permitir a capacidade de selecionar uma língua numa base página a página.',
	'AllowedLanguages'			=> 'Línguas permitidas:',
	'AllowedLanguagesInfo'		=> 'Recomenda-se que seleccione apenas o conjunto de idiomas que pretende utilizar, caso contrário todos os idiomas são seleccionados.',

	'CommentSection'			=> 'Comentários',
	'AllowComments'				=> 'Permitir comentários:',
	'AllowCommentsInfo'			=> 'Ativar os comentários apenas para convidados ou utilizadores registados ou desactivá-los em todo o sítio.',
	'SortingComments'			=> 'Ordenar comentários:',
	'SortingCommentsInfo'		=> 'Altera a ordem pela qual os comentários da página são apresentados, com o comentário mais recente OU o mais antigo no topo.',

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

	'HandlerSection'			=> 'Handler',
	'HideRevisions'				=> 'Ocultar revisões:',
	'HideRevisionsInfo'			=> 'A exibição padrão de revisões da página.',
	'AttachmentHandler'			=> 'Habilitar manipulador de anexos:',
	'AttachmentHandlerInfo'		=> 'Permite exibir o manipulador de anexos.',
	'SourceHandler'				=> 'Habilitar manipulador de origem:',
	'SourceHandlerInfo'			=> 'Permite a exibição do manipulador de origem.',
	'ExportHandler'				=> 'Ativar a exportação XML:',
	'ExportHandlerInfo'			=> 'Permite a exibição do manipulador de exportação XML.',

	'DiffModeSection'			=> 'Modos de Diff',
	'DefaultDiffModeSetting'	=> 'Modo de comparação padrão:',
	'DefaultDiffModeSettingInfo'=> 'Modo de diff pré-selecionado.',
	'AllowedDiffMode'			=> 'Modos de diferença permitidos:',
	'AllowedDiffModeInfo'		=> 'Recomenda-se que seleccione apenas o conjunto de modos de diferenças que pretende utilizar; caso contrário, todos os modos de diferenças são seleccionados.',
	'NotifyDiffMode'			=> 'Modo diff:',
	'NotifyDiffModeInfo'		=> 'Modo diff usado para as notificações no corpo do e-mail.',

	'EditingSection'			=> 'Editando',
	'EditSummary'				=> 'Sumário da edição:',
	'EditSummaryInfo'			=> 'Mostra o resumo das alterações no modo de edição.',
	'MinorEdit'					=> 'Alterações menores:',
	'MinorEditInfo'				=> 'Habilita a opção de edição menor no modo de edição.',
	'SectionEdit'				=> 'Edição da secção:',
	'SectionEditInfo'			=> 'Permite a edição apenas de uma secção de uma página.',
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
	'PagesPurgeTimeInfo'		=> 'Elimina automaticamente as versões mais antigas dentro do número de dias indicado. Se introduzir zero, as versões mais antigas não serão removidas.',
	'EnableReferrers'			=> 'Habilitar referências:',
	'EnableReferrersInfo'		=> 'Permite criação e exibição de referenciadores externos.',
	'ReferrersPurgeTime'		=> 'Tempo de armazenamento dos indicadores:',
	'ReferrersPurgeTimeInfo'	=> 'Manter o histórico de referência de páginas externas não mais do que um determinado número de dias. Zero significa armazenamento eterno, mas para um site visitado activamente isto pode levar ao transbordamento da base de dados.',
	'EnableCounters'			=> 'Contadores de Vistos:',
	'EnableCountersInfo'		=> 'Permite a contagem de acertos por página e permite a exibição de estatísticas simples. As chamadas do proprietário da página não são contadas.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Controlar as definições predefinidas de sindicação da Web para o seu site.',
	'SyndicationSettingsUpdated'	=> 'Definições de sindicação actualizadas.',

	'FeedsSection'				=> 'Atividade',
	'EnableFeeds'				=> 'Ativar feeds:',
	'EnableFeedsInfo'			=> 'Liga ou desliga os feeds RSS para todo o wiki.',
	'XmlChangeLink'				=> 'Altera o modo de ligação do feed::',
	'XmlChangeLinkInfo'			=> 'Define o local para onde os itens do feed de Alterações XML estão ligados.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'visualizar diferenças',
		'2'		=> 'página atual',
		'3'		=> 'lista de revisões',
		'4'		=> 'página revista',
	],

	'XmlSitemap'				=> 'XML Sitemap:',
	'XmlSitemapInfo'			=> 'Cria um ficheiro XML chamado %1 dentro da pasta xml. Pode adicionar o caminho para o mapa do site no ficheiro robots.txt no seu diretório raiz da seguinte forma:',
	'XmlSitemapGz'				=> 'Compressão do Sitemap XML:',
	'XmlSitemapGzInfo'			=> 'Se desejar, pode comprimir o ficheiro de texto do Sitemap utilizando gzip para reduzir os requisitos de largura de banda.',
	'XmlSitemapTime'			=> 'Tempo de geração do Sitemap XML:',
	'XmlSitemapTimeInfo'		=> 'Gera o Mapa do Sítio apenas uma vez no determinado número de dias, zero significa em cada mudança de página.',

	'SearchSection'				=> 'Pesquisa',
	'OpenSearch'				=> 'OpenSearch:',
	'OpenSearchInfo'			=> 'Cria o ficheiro de descrição OpenSearch na pasta XML e permite a Autodiscovery do plugin de pesquisa no cabeçalho HTML.',
	'SearchEngineVisibility'	=> 'Bloquear os motores de busca (Visibilidade nos motores de busca):',
	'SearchEngineVisibilityInfo'=> 'Bloqueia os motores de busca, mas permite visitantes normais. Substitui as definições da página. <br>Desencorajar os motores de busca de indexar este sítio, cabe aos motores de busca honrar este pedido.',



	// Appearance settings
	'AppearanceSettingsInfo'	=> 'Controle as configurações de exibição padrão do seu site.',
	'AppearanceSettingsUpdated'	=> 'Configurações de aparência atualizadas.',

	'LogoOff'					=> 'Desligado',
	'LogoOnly'					=> 'Logotipo',
	'LogoAndTitle'				=> 'logotipo e título',

	'LogoSection'				=> 'Logotipo',
	'SiteLogo'					=> 'Site Logo:',
	'SiteLogoInfo'				=> 'O seu logótipo aparecerá normalmente no canto superior esquerdo da aplicação. O tamanho máximo é de 2 MiB. As dimensões ideais são 255 píxeis de largura por 55 píxeis de altura.',
	'LogoDimensions'			=> 'Dimensões do logo:',
	'LogoDimensionsInfo'		=> 'Largura e altura do logótipo apresentado.',
	'LogoDisplayMode'			=> 'Modo exibição do logotipo:',
	'LogoDisplayModeInfo'		=> 'Define o aspeto do logótipo. A predefinição é desligado.',

	'FaviconSection'			=> 'Favicon:',
	'SiteFavicon'				=> 'Site Favicon:',
	'SiteFaviconInfo'			=> 'O seu ícone de atalho, ou favicon, é apresentado na barra de endereço, nos separadores e nos favoritos da maioria dos browsers. Isto irá substituir o favicon do seu tema.',
	'SiteFaviconTooBig'			=> 'O Favicon é maior que 64 × 64px.',
	'ThemeColor'				=> 'Cor do tema para a barra de endereços:',
	'ThemeColorInfo'			=> 'O navegador irá definir a cor da barra de endereço de cada página de acordo com a cor CSS fornecida.',

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
	'CacheTtl'					=> 'Term relevance cached pages:',
	'CacheTtlInfo'				=> 'Páginas de cache não mais do que um número específico de segundos.',
	'CacheSql'					=> 'Cache consultas DBMS:',
	'CacheSqlInfo'				=> 'Manter uma cache local dos resultados de certas consultas SQL relacionadas aos recursos.',
	'CacheSqlTtl'				=> 'Tempo-a-vivo para consultas SQL em cache:',
	'CacheSqlTtlInfo'			=> 'Resultado do cache de consultas SQL por não mais do que o número especificado de segundos. Valores maiores do que 1200 não são desejáveis.',

	'LogSection'				=> 'Configurações de Log',
	'LogLevelUsage'				=> 'Use registro:',
	'LogLevelUsageInfo'			=> 'A prioridade mínima dos eventos registrados no log.',
	'LogThresholds'	=> [
		'0'		=> 'não manter um periódico',
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
	'ReverseProxy'				=> 'Use Reverse proxy:',
    'ReverseProxyInfo'			=> 
    'Habilitar esta configuração para determinar o endereço IP correcto do cliente remoto,
									examinando a informação armazenada nos cabeçalhos do X-Forwarded-For. X-Forwarded-For headers
									são um mecanismo padrão para identificar sistemas clientes que se ligam através de um servidor
									proxy reverso, como o Squid ou o Pound. Os servidores proxy reversos são frequentemente utilizados
									para melhorar o desempenho de sites muito visitados e podem também proporcionar outros benefícios
									de cache, segurança ou encriptação de sites. Se esta instalação WackoWiki funcionar por detrás de
									um proxy reverso, esta configuração deve ser activada para que a informação correcta do endereço IP
									seja capturada na gestão de sessões, registo, estatísticas e sistemas de gestão de acesso de WackoWiki;
									se não tiver a certeza sobre esta configuração, não tenha um proxy reverso, ou WackoWiki funcione
									num ambiente de alojamento partilhado, esta configuração deve permanecer desactivada.',
	'ReverseProxyHeader'		=> 'Cabeçalho do proxy revertido:',
	'ReverseProxyHeaderInfo'	=> 'Defina este valor se o seu servidor proxy enviar o IP do cliente num cabeçalho
									diferente de X-Forwarded-For. O cabeçalho "X-Forwarded-For" é uma lista de endereços
									IP separada por vírgula+espaço, apenas o último (o mais à esquerda) será utilizado.',
	'ReverseProxyAddresses'		=> 'reverse_proxy aceita um array de endereços IP:',
	'ReverseProxyAddressesInfo'	=> 'Cada elemento desta matriz é o endereço IP de qualquer um dos seus proxies
									 proxies. Se estiver a usar este array, o WackoWiki confiará na informação armazenada
									 nos cabeçalhos X-Forwarded-For apenas se o endereço IP remoto for um destes
									 destes, ou seja, o pedido chega ao servidor web a partir de um dos seus
									 proxies reversos. Caso contrário, o cliente poderia ligar-se diretamente ao
									 seu servidor Web falsificando os cabeçalhos X-Forwarded-For.',

	'SessionSection'				=> 'Manipulação da Sessão',
	'SessionStorage'				=> 'Armazenamento de sessão:',
	'SessionStorageInfo'			=> 'Esta opção define onde os dados da sessão são armazenados. Por padrão, o armazenamento de arquivos ou da sessão do banco de dados está selecionado.',
	'SessionModes'	=> [
		'1'		=> 'Ficheiro',
		'2'		=> 'Base de dados',
	],
	'SessionNotice'					=> 'Mostrar causa de encerramento da sessão:',
	'SessionNoticeInfo'				=> 'Indica a causa do encerramento da sessão.',
	'LoginNotice'					=> 'Aviso de início de sessão:',
	'LoginNoticeInfo'				=> 'Apresenta um aviso de início de sessão.',

	'RewriteMode'					=> 'Usar <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'Se o seu servidor web suportar esta funcionalidade, ative para "embelezar" os URLs das páginas. <br>
<span class="cite">O valor pode ser substituído pela classe Settings em tempo de execução, independentemente de estar desactivada, se HTTP_MOD_REWRITE estiver activado.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parâmetros responsáveis pelo controlo de acesso e permissões.',
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
	'TermHumanModerationInfo'	=> 'Os moderadores só podem editar comentários se tiverem sido criados não mais do que este número de dias atrás (esta limitação não se aplica ao último comentário no tópico).',

	'UserCanDeleteAccount'		=> 'Os utilizadores podem eliminar as suas contas',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parâmetros responsáveis pela segurança geral da plataforma, restrições de segurança e subsistemas de segurança adicionais.',
	'SecuritySettingsUpdated'	=> 'Configurações de segurança atualizadas',

	'AllowRegistration'			=> 'Registrar online:',
	'AllowRegistrationInfo'		=> 'Registo de utilizador aberto. A desactivação desta opção impedirá o registo gratuito, no entanto, o próprio administrador do sítio poderá registar outros utilizadores.',
	'ApproveNewUser'			=> 'Aprovar novos usuários:',
	'ApproveNewUserInfo'		=> 'Permite que os administradores aprovem usuários após o seu cadastro. Somente usuários aprovados terão permissão para acessar o site.',
	'PersistentCookies'			=> 'Cookies persistentes:',
	'PersistentCookiesInfo'		=> 'Permitir cookies persistentes.',
	'DisableWikiName'			=> 'Desativar WikiName:',
	'DisableWikiNameInfo'		=> 'Desative o uso obrigatório de um WikiName para usuários. Permite o registro de usuários com apelidos tradicionais ao invés de nomes com formatação do CamelCase-formatados (ou seja, NameSurname).',
	'UsernameLength'			=> 'Tamanho do usuário:',
	'UsernameLengthInfo'		=> 'Número mínimo e máximo de caracteres em nomes de usuário.',

	'EmailSection'				=> 'E-mail',
	'AllowEmailReuse'			=> 'Permitir endereço de e-mail reutilização:',
	'AllowEmailReuseInfo'		=> 'Usuários diferentes podem se registrar com o mesmo endereço de e-mail.',
	'EmailConfirmation'			=> 'Impor confirmação por correio eletrónico:',
	'EmailConfirmationInfo'		=> 'Requer que o utilizador verifique o seu endereço de correio eletrónico antes de poder iniciar sessão.',
	'AllowedEmailDomains'		=> 'Domínios de correio eletrónico permitidos:',
	'AllowedEmailDomainsInfo'	=> 'Domínios de correio eletrónico permitidos separados por vírgulas, por exemplo, <code>example.com, local.lan</code> etc., caso contrário, todos os domínios de correio eletrónico são permitidos.',
	'ForbiddenEmailDomains'		=> 'Domínios de correio eletrónico proibidos:',
	'ForbiddenEmailDomainsInfo'	=> 'Domínios de correio eletrónico proibidos separados por vírgulas, por exemplo, <code>example.com, local.lan</code> etc. (só é eficaz se a lista de domínios de correio eletrónico permitidos estiver vazia)',

	'CaptchaSection'			=> 'Carro',
	'EnableCaptcha'				=> 'Ativar captcha:',
	'EnableCaptchaInfo'			=> 'Se ativado, o captcha será exibido nos seguintes casos ou se um limite de segurança for atingido.',
	'CaptchaComment'			=> 'Novo comentário:',
	'CaptchaCommentInfo'		=> 'Como proteção contra spam, usuários não registrados devem completar o captcha antes que o comentário seja publicado.',
	'CaptchaPage'				=> 'Nova página:',
	'CaptchaPageInfo'			=> 'Como proteção contra spam, usuários não registrados devem completar o captcha antes de criar uma nova página.',
	'CaptchaEdit'				=> 'Editar página:',
	'CaptchaEditInfo'			=> 'Como proteção contra spam, usuários não registrados devem completar o captcha antes de editar páginas.',
	'CaptchaRegistration'		=> 'Criar conta:',
	'CaptchaRegistrationInfo'	=> 'Como proteção contra spam, usuários não registrados devem completar o captcha antes de se registrar.',

	'TlsSection'				=> 'Configurações TLS',
	'TlsConnection'				=> 'Conexão TLS:',
	'TlsConnectionInfo'			=> 'Usar conexão segura TLS. <span class="cite">Ativar o certificado TLS pré-instalado no servidor, caso contrário, você perderá o acesso ao painel de administração!</span><br>Também determina se a bandeira segura do Cookie está definida: O sinalizador <code>seguro</code> especifica se os cookies só devem ser enviados através de conexões seguras.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Reconecte forçadamente o cliente de HTTP a HTTPS. Com a opção desativada, o cliente pode navegar no site através de um canal HTTP aberto.',

	'HttpSecurityHeaders'		=> 'Cabeçalhos de Segurança HTTP',
	'EnableSecurityHeaders'		=> 'Habilitar cabeçalhos de segurança:',
	'EnableSecurityHeadersinfo'	=> 'Definir cabeçalhos de segurança (buscando quadros, clickjacking/XSS/CSRF proteção). <br>CSP pode causar problemas em certas situações (por exemplo durante o desenvolvimento), ou ao usar plugins que dependem de recursos hospedados externos, como imagens ou scripts. <br>Desabilitar a Política de Segurança de Conteúdo é um risco de segurança!',
	'Csp'						=> 'Content-Security-Policy (CSP):',
	'CspInfo'					=> 'Configurar o CSP envolve decidir quais políticas você deseja aplicar e, em seguida, configurá-los e usar a Content-Security-Policy para estabelecer a sua política.',
	'PolicyModes'	=> [
		'0'		=> 'desativado',
		'1'		=> 'estrito',
		'2'		=> 'personalizado',
	],
	'PermissionsPolicy'			=> 'Permissions Policy:',
	'PermissionsPolicyInfo'		=> 'O cabeçalho HTTP Permissions-Policy fornece um mecanismo para activar ou desactivar explicitamente várias funcionalidades poderosas do navegador.',
	'ReferrerPolicy'			=> 'Referrer Policy:',
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

	'UserPasswordSection'		=> 'Persistence of user passwords',
	'PwdMinChars'				=> 'Tamanho mínimo da senha:',
	'PwdMinCharsInfo'			=> 'As palavras-passe mais longas são necessariamente mais seguras do que as palavras-passe mais curtas (por exemplo, 12 a 16 caracteres). <br>O uso de frases-palavra-passe em vez de palavras-passe é encorajado.',
	'AdminPwdMinChars'			=> 'Tamanho mínimo da senha de administrador:',
	'AdminPwdMinCharsInfo'		=> 'As palavras-passe mais longas são necessariamente mais seguras do que as palavras-passe mais curtas (por exemplo, 15 a 20 caracteres). <br>O uso de frases-palavra-passe em vez de palavras-passe é encorajado.',
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

	'LoginSection'				=> 'Conecte-se',
	'MaxLoginAttempts'			=> 'Número máximo de tentativas de login por nome de usuário:',
	'MaxLoginAttemptsInfo'		=> 'O número de tentativas de login permitidas para uma única conta antes que a tarefa anti-spambot seja acionada. Digite 0 para impedir que a tarefa anti-spambot seja acionada para contas de usuários distintas.',
	'IpLoginLimitMax'			=> 'Número máximo de tentativas de login por endereço IP:',
	'IpLoginLimitMaxInfo'		=> 'O limite de tentativas de login permitidas a partir de um único endereço IP antes que uma tarefa anti-spambot seja acionada. Digite 0 para evitar que a tarefa anti-spambot seja acionada por endereços IP.',

	'FormsSection'				=> 'Formulários',
	'FormTokenTime'				=> 'Tempo máximo para enviar formulários:',
	'FormTokenTimeInfo'			=> 'O tempo que um utilizador tem de submeter um formulário (em segundos).<br> Note que um formulário pode tornar-se inválido se a sessão expirar, independentemente desta configuração.',

	'SessionLength'				=> 'Term login cookie:',
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
	'X11colorsInfo'				=> 'Estende as cores disponíveis para <code>??(cor) de fundo??</code> e <code>!!(cor) texto!!</code>Desativar esta opção acelera os processos de adicionar comentários e salvar páginas.',
	'WikiLinks'					=> 'Desabilitar links wiki:',
	'WikiLinksInfo'				=> 'Desactiva a ligação para <code>CamelCaseWords</code>, as suas Palavras CamelCase não serão mais ligadas directamente a uma nova página. Isto é útil quando se trabalha em diferentes namespaces aks clusters. Por defeito, está desligado.',
	'BracketsLinks'				=> 'Disable bracketslinks:',
	'BracketsLinksInfo'			=> 'Desativa a sintaxe <code>[[link]]</code> e <code>((link))</code>.',
	'Formatters'				=> 'Desativar formatadores:',
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
	'Timezone'					=> 'Fuso Horário:',
	'TimezoneInfo'				=> 'Fuso horário a utilizar para mostrar os horários aos utilizadores que não estão ligados (convidados). Os utilizadores com sessão iniciada definem e podem alterar o seu fuso horário nas suas definições de utilizador.',

	'Canonical'					=> 'Usar URLs absolutas:',
	'CanonicalInfo'				=> 'Todos os links são criados como URLs absolutos no formulário %1. Os URLs relativos à raiz do servidor no formulário %2 devem ser preferidos.',
	'LinkTarget'				=> 'Onde links externos abrem:',
	'LinkTargetInfo'			=> 'Abre cada ligação externa numa nova janela do navegador. Adiciona <code>target="_blank"</code> à sintaxe do link.',
	'Noreferrer'				=> 'noreferer:',
	'NoreferrerInfo'			=> 'Requer que o browser não deve enviar um cabeçalho de referência HTTP se o utilizador seguir o hiperlink. Adiciona <code>rel="noreferrer"</code> à sintaxe do link.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Instrua alguns motores de busca que o hiperlink não deve influenciar a classificação dos links alvo no índice dos motores de busca. Adiciona <code>rel="nofollow"</code> à sintaxe da hiperligação.',
	'UrlsUnderscores'			=> 'Endereços de formulário (URLs) com sublinhados:',
	'UrlsUnderscoresInfo'		=> 'For example %1 becames %2 with this option.',
	'ShowSpaces'				=> 'Mostrar espaço em WikiNames:',
	'ShowSpacesInfo'			=> 'Mostrar espaços em WikiNames, por exemplo, <code>MeuNome</code> sendo exibido como <code>Meu Nome</code> com esta opção.',
	'NumerateLinks'				=> 'Enumerar links na visualização da impressão:',
	'NumerateLinksInfo'			=> 'Enumera e lista todos os links na parte inferior da visualização impressa com esta opção.',
	'YouareHereText'			=> 'Desativar e visualizar links de auto-referenciamento:',
	'YouareHereTextInfo'		=> 'Visualize links para a mesma página, usando <code>&lt;b&gt;####&lt;/b&gt;</code>. Todos os links para a formatação de link auto-perdido, mas são exibidos como texto em negrito.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Aqui pode definir ou alterar as páginas base do sistema utilizadas dentro do Wiki. Por favor não se esqueça de criar ou alterar as páginas correspondentes no Wiki de acordo com as suas definições aqui.',
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
	'NewsCluster'				=> 'Cluster para as notícias:',
	'NewsClusterInfo'			=> 'Grupo de raiz para a seção de notícias (ação %1).',
	'NewsStructure'				=> 'Estrutura do cluster de notícias:',
	'NewsStructureInfo'			=> 'Armazena os artigos opcionalmente em subclusters por ano/mês ou semana (por exemplo, <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licença',
	'DefaultLicense'			=> 'Licença padrão:',
	'DefaultLicenseInfo'		=> 'Sob o qual a licença seu conteúdo pode ser publicado.',
	'EnableLicense'				=> 'Ativar licença:',
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

	'SearchPage'				=> 'Pesquisa:',
	'SearchPageInfo'			=> 'Página com o formulário de pesquisa (ação %1).',
	'RegistrationPage'			=> 'CriarConta:',
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
	'ChangesPage'				=> 'Alterações recentes:',
	'ChangesPageInfo'			=> 'Página com uma lista das últimas páginas modificadas (ação %1).',
	'CommentsPage'				=> 'Recentemente comentadas:',
	'CommentsPageInfo'			=> 'Página com uma lista de comentários recentes na página (ação %1).',
	'RemovalsPage'				=> 'Páginas excluídas:',
	'RemovalsPageInfo'			=> 'Página com uma lista de páginas excluídas recentemente (ação %1).',
	'WantedPage'				=> 'Páginas desejadas:',
	'WantedPageInfo'			=> 'Página com uma lista de páginas ausentes que são referenciadas (ação %1).',
	'OrphanedPage'				=> 'Páginas órfãs:',
	'OrphanedPageInfo'			=> 'Página com uma lista de páginas existentes não são relacionadas através de links para qualquer outra página (ação %1).',
	'SandboxPage'				=> 'Sandbox:',
	'SandboxPageInfo'			=> 'Página onde os usuários podem praticar suas habilidades de marcação na wiki.',
	'HelpPage'					=> 'Socorro:',
	'HelpPageInfo'				=> 'A seção de documentação para trabalhar com ferramentas de site.',
	'IndexPage'					=> 'Índicede:',
	'IndexPageInfo'				=> 'Página com uma lista de todas as páginas (action %1).',
	'RandomPage'				=> 'Aleatória:',
	'RandomPageInfo'			=> 'Carrega uma página aleatória  (action %1).',


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

	'PersonalMessagesSection'	=> 'Mensagens pessoais',
	'AllowIntercomDefault'		=> 'Permitir intercom:',
	'AllowIntercomDefaultInfo'	=> 'Ativar esta opção permite que outros usuários enviem mensagens pessoais para o endereço de e-mail do destinatário sem divulgar o endereço.',
	'AllowMassemailDefault'		=> 'Permitir e-mail em massa:',
	'AllowMassemailDefaultInfo'	=> 'Enviar mensagens apenas para aqueles usuários que permitiram os administradores enviarem e-mail para as informações.',

	// Resync settings
	'Synchronize'				=> 'sincronizar',
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
	'UserStatsInfo'				=> 'Estatísticas do usuário (número de comentários, páginas de propriedade, revisões e arquivos) podem ser diferentes em algumas situações de dados reais. <br>Esta operação permite a atualização de estatísticas para corresponder aos dados reais contidos no banco de dados.',
	'PageStats'					=> 'Estatísticas da página',
	'PageStatsInfo'				=> 'Estatísticas de página (número de comentários, arquivos e revisões) podem diferir em algumas situações dos dados reais. <br>Esta operação permite a atualização de estatísticas para corresponder aos dados reais da base de dados.',

	'AttachmentsInfo'			=> 'Actualiza o hash do ficheiro para todos os anexos da base de dados.',
	'AttachmentsSynched'		=> 'Reescrever todos os anexos dos ficheiros',
	'LogAttachmentsSynched'		=> 'Reescrever todos os anexos dos ficheiros',

	'Feeds'						=> 'Atividade',
	'FeedsInfo'					=> 'No caso da edição direta de páginas na base de dados, o conteúdo dos feeds RSS pode não reflectir as alterações feitas. <br>Esta função sincroniza os canais RSS-com o estado atual do banco de dados.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'Esta função sincroniza o XML-Sitemap com o estado atual do banco de dados.',
	'XmlSiteMapPeriod'			=> 'Período %1 dias. Último escrito %2.',
	'XmlSiteMapView'			=> 'Exibir o mapa do site em uma nova janela.',

	'ReparseBody'				=> 'Reanalisar todas as páginas',
	'ReparseBodyInfo'			=> 'Vazio <code>body_r</code> na tabela de páginas, para que cada página seja renderizada novamente na próxima exibição de página. Isto pode ser útil se você modificou o formatador ou mudou o domínio da sua wiki.',
	'PreparsedBodyPurged'		=> 'Esvaziado campo <code>body_r</code> na tabela de página.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Executa uma re-renderização para todos os links intrasite e restaura o conteúdo das tabelas <code>page_link</code> e <code>file_link</code> em caso de dano ou deslocalização (isso pode levar um tempo considerável).',
	'RecompilePage'				=> 'Recopilando todas as páginas (extremamente caras)',
	'ResyncOptions'				=> 'Opções adicionais',
	'RecompilePageLimit'		=> 'Número de páginas para analisar de uma vez.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Esta informação é usada quando o Fórum envia emails aos Utilizadores. Certifique-se que usa um email válido. Qualquer Mensagem incorreta não será entregue neste endereço. Se o seu serviço de hospedagem não oferece um serviço nativo de email baseado no PHP, pode enviar mensagens através de SMTP. É necessário um Servidor adequado, não especifique qualquer nome antigo aqui! Se o servidor requer autenticação, introduza os nomes e senhas necessários. tenha em atenção que apenas é usada a autenticação básica. Implementações de autenticações diferentes não estão disponíveis.',

	'EmailSettingsUpdated'		=> 'Configurações de e-mail atualizadas',

	'EmailFunctionName'			=> 'Nome da Função de email:',
	'EmailFunctionNameInfo'		=> 'Função de email usada para enviar emails através do PHP.',
	'UseSmtpInfo'				=> 'Selecione <code>SMTP</code> se você quiser ou tiver que enviar e-mail através de um servidor nomeado em vez de através da função mail local.',

	'EnableEmail'				=> 'Habilitar e-mails:',
	'EnableEmailInfo'			=> 'Ativar o envio de e-mails.',

	'EmailIdentitySettings'		=> 'Website E-mails Identidade',
	'FromEmailName'				=> 'From Name:',
	'FromEmailNameInfo'			=> 'O nome do remetente que é usado para o cabeçalho <code>From:</code> para todas as notificações por e-mail enviadas a partir do site.',
	'EmailSubjectPrefix'		=> 'Prefixo do assunto:',
	'EmailSubjectPrefixInfo'	=> 'Prefixo alternativo do assunto do correio eletrónico, por exemplo, <code>[Prefixo] Tópico</code>. Se não for definido, o prefixo predefinido é Nome do sítio: %1.',

	'NoReplyEmail'				=> 'Endereço para No-resposta:',
	'NoReplyEmailInfo'			=> 'Este endereço, por exemplo, <code>noreply@example.com</code>, aparecerá no campo de endereço de email <code>From:</code> de todas as notificações de email enviadas a partir do site.',
	'AdminEmail'				=> 'E-mail do proprietário do site:',
	'AdminEmailInfo'			=> 'Esse endereço é usado para fins administrativos, como uma nova notificação de usuário.',
	'AbuseEmail'				=> 'Serviço de abuso de e-mail:',
	'AbuseEmailInfo'			=> 'Solicitações de endereço para assuntos urgentes: registro de um e-mail estrangeiro, etc. Pode ser o mesmo que o e-mail do proprietário do site.',

	'SendTestEmail'				=> 'Enviar um E-mail de Teste',
	'SendTestEmailInfo'			=> 'Enviaremos um e-mail de teste para o endereço definido na sua conta.',
	'TestEmailSubject'			=> 'O seu Wiki está configurado corretamente para enviar e-mails',
	'TestEmailBody'				=> 'Se você recebeu este e-mail, o Wiki está configurado corretamente para enviar e-mails.',
	'TestEmailMessage'			=> 'O e-mail de teste foi enviado.<br>Se você não o receber, por favor, verifique as suas configurações de e-mail.',

	'SmtpSettings'				=> 'Configurações do SMTP',
	'SmtpAutoTls'				=> 'TLS Oportunista:',
	'SmtpAutoTlsInfo'			=> 'Habilita a criptografia automaticamente, se ele vir que o servidor está publicitando TLS (depois de ter conectado ao servidor), mesmo se você não configurou o modo de conexão <code>SMTPSecure</code>.',
	'SmtpConnectionMode'		=> 'Método de Autenticação para o SMTP:',
	'SmtpConnectionModeInfo'	=> 'Apenas usado se um Nome/Senha é atribuído, pergunte ao seu ISP se não sabe que método usa.',
	'SmtpPassword'				=> 'Senha do SMTP:',
	'SmtpPasswordInfo'			=> 'Só introduza a Senha se o Servidor de SMTP a pedir.<br><em><strong>Aviso:</strong> Esta senha será armazenada como texto simples na Base de Dados, visível a todos que podem aceder à Base de Dados ou a quem pode ver esta página de configuração.</em>',
	'SmtpPort'					=> 'Porta do Servidor de SMTP:',
	'SmtpPortInfo'				=> 'Mude apenas se tiver a certeza de que seu Servidor de SMTP está numa porta diferente. <br>(default: <code>tls</code> on port 587 (or possibly 25) and <code>ssl</code> on port 465)',
	'SmtpServer'				=> 'Endereço do Servidor de SMTP:',
	'SmtpServerInfo'			=> 'Note que você tem que fornecer o protocolo que o servidor utiliza. Se você estiver usando SSL, isso tem que ser <code>ssl://mail.example.com</code>',
	'SmtpUsername'				=> 'Nome de Utilizador SMTP:',
	'SmtpUsernameInfo'			=> 'Só introduza um Nome se o Servidor de SMTP o pedir.',

	// Upload settings
	'UploadSettingsInfo'		=> 'Aqui pode configurar as Opções Principais para os Anexos e Categorias Especiais associadas.',
	'UploadSettingsUpdated'		=> 'Configurações de envio atualizadas',

	'FileUploadsSection'		=> 'File Uploads',
	'RegisteredUsers'			=> 'utilizadores registados',
	'RightToUpload'				=> 'Permissões para enviar arquivos:',
	'RightToUploadInfo'			=> '<code>admins</code> significa que apenas usuários do grupo de administradores podem fazer upload de arquivos. <code>1</code> significa que o envio é aberto para usuários registrados. <code>0</code> significa que o envio está desativado.',
	'UploadMaxFilesize'			=> 'Tamanho máximo de anexos:',
	'UploadMaxFilesizeInfo'		=> 'Tamanho máximo de cada anexo. Se este valor for 0, o tamanho do ficheiro enviado fica sujeito às permissões do PHP.',
	'UploadQuota'				=> 'Espaço total de Anexos:',
	'UploadQuotaInfo'			=> 'Espaço máximo em disco reservado aos anexos. <code>0</code> = ilimitado. %1 used.',
	'UploadQuotaUser'			=> 'Cota de armazenamento por usuário:',
	'UploadQuotaUserInfo'		=> 'Restrição sobre a cota de armazenamento que pode ser carregada por um usuário, sendo ilimitada <code>0</code>.',

	'FileTypes'					=> 'Tipos de ficheiro',
	'UploadOnlyImages'			=> 'Permitir apenas o envio de imagens:',
	'UploadOnlyImagesInfo'		=> 'Permitir apenas o envio de arquivos de imagem na página.',
	'AllowedUploadExts'			=> 'Tipos de ficheiro permitidos:',
	'AllowedUploadExtsInfo'		=> 'Extensões permitidas para carregar ficheiros, separadas por vírgula, por exemplo <código>png, ogg, mp4</código>, outras extensões de ficheiros não proibidas são todas permitidas.<br>Deve limitar a lista de tipos de ficheiros carregados permitidos ao mínimo necessário para a funcionalidade de conteúdo do seu sítio.',
	'CheckMimetype'				=> 'Verificar ficheiros anexados:',
	'CheckMimetypeInfo'			=> 'Alguns Ficheiros podem obrigar os navegadores e executar funções incorretas. Esta opção permite recusar esses Ficheiros.',
	'SvgSanitizer'				=> 'SVG Sanitizer:',
	'SvgSanitizerInfo'			=> 'Isto permite a higienização dos ficheiros SVG carregados para evitar que ficheiros SVG/XML vulneráveis sejam carregados.',
	'TranslitFileName'			=> 'Transliterar nomes de arquivos:',
	'TranslitFileNameInfo'		=> 'Se for aplicável e não houver necessidade de ter caracteres Unicode, é altamente recomendável aceitar apenas caracteres alfanuméricos.',
	'TranslitCaseFolding'		=> 'Converter nomes de ficheiros para minúsculas:',
	'TranslitCaseFoldingInfo'	=> 'Esta opção só é eficaz com a transliteração ativa.',

	'Thumbnails'				=> 'Thumbnails',
	'CreateThumbnail'			=> 'Criar uma Imagem reduzida:',
	'CreateThumbnailInfo'		=> 'Criar uma Imagem reduzida em todas as situações possíveis.',
	'JpegQuality'				=> 'Qualidade JPEG:',
	'JpegQualityInfo'			=> 'Qualidade ao escalar uma miniatura de um JPEG. Deve ser entre 1 e 100, com 100 indicando 100% de qualidade.',
	'MaxImageArea'				=> 'Maximum Image Area:',
	'MaxImageAreaInfo'			=> 'O número máximo de pixéis que uma imagem de origem pode ter. Isto fornece um limite no uso de memória para o lado da descompressão do escalonador de imagens. <br><code>-1</code> significa que não irá verificar o tamanho da imagem antes de a tentar escalar. <code>0</code> significa que ele determinará o valor automaticamente.',
	'MaxThumbWidth'				=> 'Largura máxima das imagens em miniaturas em píxeis:',
	'MaxThumbWidthInfo'			=> 'A largura das miniaturas geradas não ultrapassará a selecionada.',
	'MinThumbFilesize'			=> 'Tamanho Mínimo de imagem reduzida:',
	'MinThumbFilesizeInfo'		=> 'Não criar imagem reduzida para imagens menores do que o selecionado.',
	'MaxImageWidth'				=> 'Limite de tamanho da imagem nas páginas:',
	'MaxImageWidthInfo'			=> 'A largura máxima que uma imagem pode ter nas páginas, caso contrário é gerada uma miniatura reduzida.',

	// Deleted module
	'DeletedObjectsInfo'		=> 'Lista de páginas, revisões e ficheiros removidos.
 Remova ou restaure as páginas, revisões ou ficheiros da base de dados clicando na ligação <em>Remover</em>
 ou <em>Restaurar</em> na linha correspondente. (Cuidado, não é solicitada qualquer confirmação de eliminação!)',

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
	'LogUsername'				=> 'Nome de utilizador',
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
	'MassemailInfo'				=> 'Aqui pode enviar um email a todos os seus Utilizadores ou a todos os Utilizadores de um determinado Grupo, <strong>se tiver a opção de receber emails ativada</strong>. Para isso, uma mensagem será enviada ao endereço de email do administrador a informar, com uma cópia a todos membros. A configuração padrão apenas inclui 20 destinatários por mensagem, sendo que para mais destinatários mais emails serão enviados. Se está a enviar mensagens a um grande grupo de Utilizadores, por favor, seja paciente e não feche a página durante o envio. É normal que o envio em massa de mensagens leve algum tempo: Será avisado quando o processo terminar.',
	'LogMassemail'				=> 'Enviar e-mail em massa %1 para o grupo / usuário ',
	'MassemailSend'				=> 'E-mail em massa enviar',

	'NoEmailMessage'			=> 'Tem que introduzir uma mensagem.',
	'NoEmailSubject'			=> 'A sua mensagem tem que ter um assunto.',
	'NoEmailRecipient'			=> 'É necessário especificar pelo menos um utilizador ou grupo de utilizadores.',

	'MassemailSection'			=> 'E-mails em massa',
	'MessageSubject'			=> 'Sujeito:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'A sua Mensagem:',
	'YourMessageInfo'			=> 'A mensagem só pode conter texto puro. Todos os códigos serão removidos ao enviar.',

	'NoUser'					=> 'Nenhum usuário',
	'NoUserGroup'				=> 'Nenhum grupo de usuário',

	'SendToGroup'				=> 'Enviar para Grupo:',
	'SendToUser'				=> 'Enviar para Utilizadores:',
	'SendToUserInfo'			=> 'Só envia mensagens aos utilizadores que autorizaram os administradores a enviar-lhes informações por correio eletrónico. Esta opção está disponível nas definições do utilizador em Notificações.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Mensagem do sistema atualizada',

	'SysMsgSection'				=> 'Sistema de Mensagem',
	'SysMsg'					=> 'Mensagem do sistema:',
	'SysMsgInfo'				=> 'Seu texto aqui',

	'SysMsgType'				=> 'Tipo:',
	'SysMsgTypeInfo'			=> 'Tipo de mensagem (CSS).',
	'SysMsgAudience'			=> 'Público:',
	'SysMsgAudienceInfo'		=> 'O público a quem a mensagem do sistema é apresentada.',
	'EnableSysMsg'				=> 'Ativar mensagem do sistema:',
	'EnableSysMsgInfo'			=> 'Mostrar mensagem do sistema.',

	// User approval module
	'ApproveNotExists'			=> 'Seleccione pelo menos um utilizador através do botão Definir.',

	'LogUserApproved'			=> 'Usuário ##%1## aprovado',
	'LogUserBlocked'			=> 'Usuário ##%1## bloqueado',
	'LogUserDeleted'			=> 'Usuário ##%1## removido do banco de dados',
	'LogUserCreated'			=> 'Criou um novo usuário ##%1##',
	'LogUserUpdated'			=> 'Usuário atualizado ##%1##',

	'UserApproveInfo'			=> 'Aprovar novos utilizadores antes de poderem iniciar sessão no sítio.',
	'Approve'					=> 'Aprovar',
	'Deny'						=> 'Recusar',
	'Pending'					=> 'Pendente',
	'Approved'					=> 'Aprovado',
	'Denied'					=> 'Recusado',

	// DB Backup module
	'BackupStructure'			=> 'Estrutura',
	'BackupData'				=> 'Dado',
	'BackupFolder'				=> 'pasta',
	'BackupTable'				=> 'Classificações',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'Ficheiros',
	'BackupNote'				=> 'Nota:',
	'BackupSettings'			=> 'Especifique o esquema de backup desejado.<br>' .
    	'O cluster raiz não afeta o backup dos ficheiros globais e o backup dos ficheiros de cache (se for escolhido, são sempre guardados na íntegra). <br>' .  '<br>' .
		'<strong>Atenção</strong>: Para evitar a perda de informações do banco de dados ao especificar o cluster de raiz, as tabelas deste backup não serão reestruturadas, o mesmo que durante o backup somente da estrutura de tabelas sem salvar os dados. Para fazer uma conversão completa das tabelas para o formato de backup, é necessário fazer o <em> backup completo da base de dados (estrutura e dados) sem especificar o cluster</em>.',
	'BackupCompleted'			=> 'Backup e arquivamento concluído.<br>' .
    	'Os arquivos do pacote de Backup foram armazenados no sub-diretório %1.<br>. Para baixar, use FTP (mantenha a estrutura do diretório e os nomes de arquivos durante a cópia).<br> Para restaurar uma cópia de segurança ou remover um pacote, vá para <a href="%2">Restaurar banco de dados</a>.',
	'LogSavedBackup'			=> 'Banco de dados de backup salvo ##%1##',
	'Backup'					=> 'Cópia de segurança',
	'CantReadFile'				=> 'Não é possível ler o arquivo %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Pode restaurar qualquer um dos pacotes de cópia de segurança encontrados ou removê-los do servidor.',
	'ConfirmDbRestore'			=> 'Você quer restaurar o backup %1?',
	'ConfirmDbRestoreInfo'		=> 'Aguarde, isso pode levar alguns minutos.',
	'RestoreWrongVersion'		=> 'Versão errada do WackoWiki!',
	'DirectoryNotExecutable'	=> 'O directório %1 não é executável.',
	'BackupDelete'				=> 'Tens a certeza que queres remover o backup %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Opções de restauração adicionais:',
	'RestoreOptionsInfo'		=> '* Antes de restaurar o backup do cluster <strong></strong>, ' .
									'as tabelas alvo não são excluídas (para evitar perda de informações dos agrupamentos que não foram salvas). ' .
									'Assim, durante o processo de recuperação de registros duplicados ocorrerão. ' .
									'No modo normal, todas elas serão substituídas pelo backup do formulário de registros (usando SQL <code>REPLACE</code>), ' .
									'mas se esta opção estiver marcada, todas as duplicatas são ignoradas (os valores atuais dos registros serão mantidos), ' .
									'e apenas os registros com novas chaves são adicionados à tabela (SQL <code>INSERT IGNORE</code>).<br>' .
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
	'AssumeDropTable'			=> 'Assumir %1',
	'RestoreTableStructure'		=> 'Restaurando a estrutura da tabela',
	'RunSqlQueries'				=> 'Executar instruções SQL:',
	'CompletedSqlQueries'		=> 'Concluído. Instruções processadas:',
	'NoTableStructure'			=> 'A estrutura das tabelas não foi salva - pule',
	'RestoreRecords'			=> 'Restaurar o conteúdo das tabelas',
	'ProcessTablesDump'			=> 'Apenas baixar e processar dumps de tabela',
	'Instruction'				=> 'Instrução',
	'RestoredRecords'			=> 'registros:',
	'RecordsRestoreDone'		=> 'Total de entradas concluídas:',
	'SkippedRecords'			=> 'Dados não salvos - pular',
	'RestoringFiles'			=> 'Restaurando arquivos',
	'DecompressAndStore'		=> 'Descompactar e armazenar o conteúdo de diretórios',
	'HomonymicFiles'			=> 'arquivos homônimos',
	'RestoreSkip'				=> 'Pular',
	'RestoreReplace'			=> 'substituir',
	'RestoreFile'				=> 'Ficheiro:',
	'RestoredFiles'				=> 'restaurado:',
	'SkippedFiles'				=> 'ignorado:',
	'FileRestoreDone'			=> 'Total de arquivos concluídos:',
	'FilesAll'					=> 'todos:',
	'SkipFiles'					=> 'Os arquivos não são armazenados - pular',
	'RestoreDone'				=> 'RESTAURAÇÃO CONCLUÍDA',

	'BackupCreationDate'		=> 'Data de Criação',
	'BackupPackageContents'		=> 'O conteúdo do pacote',
	'BackupRestore'				=> 'Restaurar',
	'BackupRemove'				=> 'Remover',
	'RestoreYes'				=> 'sim',
	'RestoreNo'					=> 'Não',
	'LogDbRestored'				=> 'Backup ##%1## do banco de dados restaurado.',

	'BackupArchived'			=> 'Cópia de segurança %1 arquivada.',
	'BackupArchiveExists'		=> 'O arquivo de cópia de segurança %1 já existe.',
	'LogBackupArchived'			=> 'Cópia de segurança ##%1## arquivada.',

	// User module
	'UsersInfo'					=> 'Aqui você pode alterar as informações dos usuários e algumas opções específicas.',

	'UsersAdded'				=> 'Usuário adicionado',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> 'Editar',
	'UsersAddNew'				=> 'Adicionar novo utilizador',
	'UsersDelete'				=> 'Tens a certeza que queres remover o utilizador %1?',
	'UsersDeleted'				=> 'O utilizador %1 foi eliminado da base de dados.',
	'UsersRename'				=> 'Renomear o usuário %1 para',
	'UsersRenameInfo'			=> '* Nota: A alteração afectará todas as páginas que estão atribuídas a esse utilizador.',
	'UsersUpdated'				=> 'Utilizador atualizado com sucesso.',

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
	'GroupsDescription'			=> 'Descrição',
	'GroupsModerator'			=> 'Moderador',
	'GroupsOpen'				=> 'Abrir',
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
	'GroupsDelete'				=> 'Tens a certeza que queres remover o grupo %1?',
	'GroupsDeleteInfo'			=> '* Nota: A mudança afetará todos os membros designados a esse grupo.',
	'GroupsIsSystem'			=> 'O Grupo %1 pertence ao sistema e não pode ser removido.',
	'GroupsStoreButton'			=> 'Salvar Grupos',
	'GroupsEditInfo'			=> 'Para editar a lista de grupos, selecione o botão de rádio.',

	'GroupAddMember'			=> 'Adicionar membro',
	'GroupRemoveMember'			=> 'Remover Membro',
	'GroupAddNew'				=> 'Adicionar grupo',
	'GroupEdit'					=> 'Editar grupo',
	'GroupDelete'				=> 'Remover grupo',

	'MembersAddNew'				=> 'Adicionar novo membro',
	'MembersAdded'				=> 'Adicionado um novo membro ao grupo com sucesso.',
	'MembersRemove'				=> 'Tens a certeza que queres remover o membro %1?',
	'MembersRemoved'			=> 'O membro foi retirado do grupo.',

	// Statistics module
	'DbStatSection'				=> 'Estatísticas da base de dados',
	'DbTable'					=> 'Classificações',
	'DbRecords'					=> 'registros',
	'DbSize'					=> 'Tamanho',
	'DbIndex'					=> 'Índicede',
	'DbOverhead'				=> 'Sobrecarga',
	'DbTotal'					=> 'Total:',

	'FileStatSection'			=> 'Estatísticas do sistema de ficheiros',
	'FileFolder'				=> 'pasta',
	'FileFiles'					=> 'Ficheiros',
	'FileSize'					=> 'Tamanho',
	'FileTotal'					=> 'Total:',

	// Sysinfo module
	'SysInfo'					=> 'Version informations:',
	'SysParameter'				=> 'Parâmatro',
	'SysValues'					=> 'Valores',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Última atualização',
	'ServerOS'					=> 'S.O.',
	'ServerName'				=> 'Nome do servidor',
	'WebServer'					=> 'Servidor Web',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
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
	'DbRepairSection'			=> 'Reparar base de dados',
	'DbRepair'					=> 'Reparar base de dados',
	'DbRepairInfo'				=> 'Este script pode procurar automaticamente alguns problemas comuns da base de dados e repará-los. A reparação pode demorar algum tempo, por isso, seja paciente.',

	'DbOptimizeRepairSection'	=> 'Reparar e otimizar a base de dados',
	'DbOptimizeRepair'			=> 'Reparar e otimizar a base de dados',
	'DbOptimizeRepairInfo'		=> 'Este script também pode tentar otimizar a base de dados. Isso melhora o desempenho em algumas situações. Reparar e otimizar a base de dados pode demorar muito tempo e a base de dados será bloqueada durante a otimização.',

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
	'CheckDatabase'				=> 'Base de dados',
	'CheckDatabaseInfo'			=> 'Verifica se há inconsistências de registro no banco de dados.',
	'CheckFiles'				=> 'Ficheiros',
	'CheckFilesInfo'			=> 'Verifica arquivos abandonados, arquivos sem referência deixados na tabela de arquivos.',
	'Records'					=> 'registros',
	'InconsistenciesNone'		=> 'Nenhuma inconsistência de dados encontrada.',
	'InconsistenciesDone'		=> 'Inconsistências de dados resolvidas.',
	'InconsistenciesRemoved'	=> 'Inconsistências removidas',
	'Check'						=> 'Verificar',
	'Solve'						=> 'Resolver',

	// Bad Behaviour module
	'BbInfo'					=> 'Detects and blocks unwanted Web accesses, deny automated spambots access<br>For more information please visit the %1 homepage.',
	'BbEnable'					=> 'Ativar mau comportamento:',
	'BbEnableInfo'				=> 'Todas as outras configurações podem ser alteradas na pasta de configuração %1.',
	'BbStats'					=> 'Bad Behaviour bloqueou tentativas de acesso de %1 nos últimos 7 dias.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Registro',
	'BbSettings'				=> 'Configurações',
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
	'BbUserAgentInfo'			=> 'Cadeias de agentes de utilizador a incluir na lista branca (uma por linha)',

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
									'Se tiver uma cadeia de dois ou mais proxies inversos entre o seu servidor e a Internet pública, deverá especificar <em>todos</em> os intervalos de endereços IP (no formato CIDR) de todos os seus servidores proxy, balanceadores de carga, etc. Caso contrário, o Bad Behaviour poderá não conseguir determinar o verdadeiro endereço IP do cliente. <br>' .
									'Além disso, os seus servidores de proxy reverso devem definir o endereço IP do cliente de Internet do qual receberam a solicitação num cabeçalho HTTP. Se você não especificar um cabeçalho, %1 será usado. A maioria dos servidores proxy já suporta X-Forwarded-For e então você só precisa garantir que ele esteja ativado nos seus servidores proxy. Alguns outros nomes de cabeçalho em uso comum incluem %2 e %3.',
	'BbReverseProxyEnable'		=> 'Habilitar Proxy Reverso',
	'BbReverseProxyHeader'		=> 'Cabeçalho contendo o endereço IP dos clientes Internet',
	'BbReverseProxyAddresses'	=> 'Endereço IP ou intervalo de endereços de formato CIDR para os seus servidores de proxy (um por linha)',

];
