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
	'ApHomePageTip'				=> 'Open the home page, you do not quit system administration',
	'ApLogOut'					=> 'Desligar',
	'ApLogOutTip'				=> 'Quit system administration',

	'TimeLeft'					=> 'Tempo restante: %1 minutos',
	'ApVersion'					=> 'versão',

	'SiteOpen'					=> 'Abrir',
	'SiteOpened'				=> 'site aberto',
	'SiteOpenedTip'				=> 'O site está aberto',
	'SiteClose'					=> 'Fechar',
	'SiteClosed'				=> 'site fechado',
	'SiteClosedTip'				=> 'The site is closed',

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
	'MainSection'				=> 'Basic Parameters',

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
		'title'		=> 'Notifications settings',
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
		'title'		=> 'Newly deleted content',
	],

	// Menu module
	'content_menu'		=> [
		'name'		=> 'Menu',
		'title'		=> 'Add, edit or remove default menu items',
	],

	// DB Backup module
	'db_backup'		=> [
		'name'		=> 'Cópia de segurança',
		'title'		=> 'Backing up data',
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
	'MainNote'					=> 'Note: It is recommended that access to the site be temporarily blocked for administrative maintenance.',

	'PurgeSessions'				=> 'Purgar',
	'PurgeSessionsTip'			=> 'Terminar todas as sessões',
	'PurgeSessionsConfirm'		=> 'Tem certeza que deseja terminar todas as sessões? Esta ação terminará as sessões de todos os utilizadores.',
	'PurgeSessionsExplain'		=> 'Eliminar todas as sessões. Isto irá terminar a sessão de todos os utilizadores, truncando a tabela auth_token.',
	'PurgeSessionsDone'			=> 'Sessões eliminadas com sucesso.',

	// Basic settings
	'BasicSettingsInfo'			=> '',
	'BasicSettingsUpdated'		=> 'Definições básicas actualizadas',
	'LogBasicSettingsUpdated'	=> 'Definições básicas actualizadas',

	'SiteName'					=> 'Site Name:',
	'SiteNameInfo'				=> 'The title of this site. Appears on browser title, theme header, email-notification, etc.',
	'SiteDesc'					=> 'Site description:',
	'SiteDescInfo'				=> 'Supplement to the title of the site that appears in the pages header. Explains, in a few words, what this site is about.',
	'AdminName'					=> 'Admin of site:',
	'AdminNameInfo'				=> 'Nome do utilizador, que é responsável pelo apoio geral do sítio. Este nome não é utilizado para determinar os direitos de acesso, mas é desejável que esteja em conformidade com o nome do administrador principal do sítio.',

	'LanguageSection'			=> 'Língua',
	'DefaultLanguage'			=> 'Língua predefinida:',
	'DefaultLanguageInfo'		=> 'Especifica o idioma das mensagens apresentadas aos convidados não registados, bem como as definições de localidade.',
	'MultiLanguage'				=> 'Suporte multilingue:',
	'MultiLanguageInfo'			=> 'Permitir a capacidade de selecionar uma língua numa base página a página.',
	'AllowedLanguages'			=> 'Línguas permitidas:',
	'AllowedLanguagesInfo'		=> 'Recomenda-se que seleccione apenas o conjunto de idiomas que pretende utilizar, caso contrário todos os idiomas são seleccionados.',

	'CommentSection'			=> 'Comentários',
	'AllowComments'				=> 'Allow comments:',
	'AllowCommentsInfo'			=> 'Ativar os comentários apenas para convidados ou utilizadores registados ou desactivá-los em todo o sítio.',
	'SortingComments'			=> 'Ordenar comentários:',
	'SortingCommentsInfo'		=> 'Altera a ordem pela qual os comentários da página são apresentados, com o comentário mais recente OU o mais antigo no topo.',

	'ToolbarSection'			=> 'Toolbar',
	'CommentsPanel'				=> 'Comments panel:',
	'CommentsPanelInfo'			=> 'The default display of comments at the bottom of the page.',
	'FilePanel'					=> 'File panel:',
	'FilePanelInfo'				=> 'The default display of attachments at the bottom of the page.',
	'TagsPanel'					=> 'Tags panel:',
	'TagsPanelInfo'				=> 'The default display of the tags panel at the bottom of the page.',

	'NavigationSection'			=> 'Navigation',
	'ShowPermalink'				=> 'Show permalink:',
	'ShowPermalinkInfo'			=> 'The default display of the permalink for the current version of the page.',
	'TocPanel'					=> 'Table of contents panel:',
	'TocPanelInfo'				=> 'The default display table of contents panel of a page (may need support in the templates).',
	'SectionsPanel'				=> 'Sections panel:',
	'SectionsPanelInfo'			=> 'By default, display the panel of adjacent pages (requires support in the templates).',
	'DisplayingSections'		=> 'Displaying sections:',
	'DisplayingSectionsInfo'	=> 'When the previous options are set, whether to display only subpages of page (<em>lower</em>), only neighbor (<em>top</em>), both, or other (<em>tree</em>).',
	'MenuItems'					=> 'Menu items:',
	'MenuItemsInfo'				=> 'Default number of shown menu items (may need support in the templates).',

	'HandlerSection'			=> 'Handlers',
	'HideRevisions'				=> 'Hide revisions:',
	'HideRevisionsInfo'			=> 'The default display of revisions of the page.',
	'AttachmentHandler'			=> 'Enable attachments handler:',
	'AttachmentHandlerInfo'		=> 'Permite exibir o manipulador de anexos.',
	'SourceHandler'				=> 'Enable source handler:',
	'SourceHandlerInfo'			=> 'Permits the display of the source handler.',
	'ExportHandler'				=> 'Ativar a exportação XML:',
	'ExportHandlerInfo'			=> 'Permits the display of the XML export handler.',

	'DiffModeSection'			=> 'Diff Modes',
	'DefaultDiffModeSetting'	=> 'Modo de comparação padrão:',
	'DefaultDiffModeSettingInfo'=> 'Preselected diff mode.',
	'AllowedDiffMode'			=> 'Allowed diff modes:',
	'AllowedDiffModeInfo'		=> 'Recomenda-se que seleccione apenas o conjunto de modos de diferenças que pretende utilizar; caso contrário, todos os modos de diferenças são seleccionados.',
	'NotifyDiffMode'			=> 'Notify diff mode:',
	'NotifyDiffModeInfo'		=> 'Diff mode used for notifications in the email body.',

	'EditingSection'			=> 'Editing',
	'EditSummary'				=> 'Sumário da edição:',
	'EditSummaryInfo'			=> 'Shows change summary in the edit mode.',
	'MinorEdit'					=> 'Alterações menores:',
	'MinorEditInfo'				=> 'Enables minor edit option in the edit mode.',
	'SectionEdit'				=> 'Edição da secção:',
	'SectionEditInfo'			=> 'Permite a edição apenas de uma secção de uma página.',
	'ReviewSettings'			=> 'Review:',
	'ReviewSettingsInfo'		=> 'Enables review option in the edit mode.',
	'PublishAnonymously'		=> 'Allow anonymous publishing:',
	'PublishAnonymouslyInfo'	=> 'Allow users to publish anonymously (to hide the name).',

	'DefaultRenameRedirect'		=> 'When renaming, create redirection:',
	'DefaultRenameRedirectInfo'	=> 'By default, offer to set a redirect to the old address of the page being renamed.',
	'StoreDeletedPages'			=> 'Keep deleted pages:',
	'StoreDeletedPagesInfo'		=> 'When you delete a page, a comment or a file, keep it in a special section, where it will be available for review and recovery for some period of time (as described below).',
	'KeepDeletedTime'			=> 'Storage time of deleted pages:',
	'KeepDeletedTimeInfo'		=> 'The period in days. It makes sense only with the previous option. Use zero to ensure entities are never deleted (in this case the administrator can clear the "cart" manually).',
	'PagesPurgeTime'			=> 'Storage time of page revisions:',
	'PagesPurgeTimeInfo'		=> 'Elimina automaticamente as versões mais antigas dentro do número de dias indicado. Se introduzir zero, as versões mais antigas não serão removidas.',
	'EnableReferrers'			=> 'Enable referrers:',
	'EnableReferrersInfo'		=> 'Permits creation and display of external referrers.',
	'ReferrersPurgeTime'		=> 'Storage time of referrers:',
	'ReferrersPurgeTimeInfo'	=> 'Manter o histórico de referência de páginas externas não mais do que um determinado número de dias. Zero significa armazenamento eterno, mas para um site visitado activamente isto pode levar ao transbordamento da base de dados.',
	'EnableCounters'			=> 'Hit Counters:',
	'EnableCountersInfo'		=> 'Permite a contagem de acertos por página e permite a exibição de estatísticas simples. As chamadas do proprietário da página não são contadas.',

	// Syndication settings
	'SyndicationSettingsInfo'		=> 'Controlar as definições predefinidas de sindicação da Web para o seu site.',
	'SyndicationSettingsUpdated'	=> 'Definições de sindicação actualizadas.',

	'FeedsSection'				=> 'Atividade',
	'EnableFeeds'				=> 'Enable feeds:',
	'EnableFeedsInfo'			=> 'Liga ou desliga os feeds RSS para todo o wiki.',
	'XmlChangeLink'				=> 'Altera o modo de ligação do feed::',
	'XmlChangeLinkInfo'			=> 'Define o local para onde os itens do feed de Alterações XML estão ligados.',
	'XmlChangeLinkMode'			=> [
		'1'		=> 'visualizar diferenças',
		'2'		=> 'página atual',
		'3'		=> 'lista de revisões',
		'4'		=> 'página revista',
	],

	'XmlSitemap'				=> 'XML sitemap:',
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
	'AppearanceSettingsInfo'	=> 'Control default display settings for your site.',
	'AppearanceSettingsUpdated'	=> 'Updated appearance settings.',

	'LogoOff'					=> 'Desligado',
	'LogoOnly'					=> 'logo',
	'LogoAndTitle'				=> 'logo and title',

	'LogoSection'				=> 'Logo',
	'SiteLogo'					=> 'Site logo:',
	'SiteLogoInfo'				=> 'O seu logótipo aparecerá normalmente no canto superior esquerdo da aplicação. O tamanho máximo é de 2 MiB. As dimensões ideais são 255 píxeis de largura por 55 píxeis de altura.',
	'LogoDimensions'			=> 'Logo dimensions:',
	'LogoDimensionsInfo'		=> 'Largura e altura do logótipo apresentado.',
	'LogoDisplayMode'			=> 'Logo display mode:',
	'LogoDisplayModeInfo'		=> 'Define o aspeto do logótipo. A predefinição é desligado.',

	'FaviconSection'			=> 'Favicon',
	'SiteFavicon'				=> 'Site favicon:',
	'SiteFaviconInfo'			=> 'O seu ícone de atalho, ou favicon, é apresentado na barra de endereço, nos separadores e nos favoritos da maioria dos browsers. Isto irá substituir o favicon do seu tema.',
	'SiteFaviconTooBig'			=> 'O Favicon é maior que 64 × 64px.',
	'ThemeColor'				=> 'Cor do tema para a barra de endereços:',
	'ThemeColorInfo'			=> 'O navegador irá definir a cor da barra de endereço de cada página de acordo com a cor CSS fornecida.',

	'LayoutSection'				=> 'Layout',
	'Theme'						=> 'Theme:',
	'ThemeInfo'					=> 'Template design the site uses by default.',
	'ThemesAllowed'				=> 'Allowed Themes:',
	'ThemesAllowedInfo'			=> 'Select the allowed themes, which the user can choose; otherwise, all available themes are allowed.',
	'ThemesPerPage'				=> 'Themes per page:',
	'ThemesPerPageInfo'			=> 'Allow themes per page, which the page owner can choose via page properties.',

	// System settings
	'SystemSettingsInfo'		=> 'Group of parameters responsible for fine-tuning the site. Do not change them unless you are confident in their actions.',
	'SystemSettingsUpdated'		=> 'Updated system settings',

	'DebugModeSection'			=> 'Debug Mode',
	'DebugMode'					=> 'Debug mode:',
	'DebugModeInfo'				=> 'Extracting and outputting telemetry data about the application\'s execution time. Attention: Full detail mode imposes higher requirements to the allocated memory, especially for resource-intensive operations, such as database backup and restore.',
	'DebugModes'	=> [
		'0'		=> 'debugging is off',
		'1'		=> 'only the total execution time',
		'2'		=> 'full-time',
		'3'		=> 'full detail (DBMS, cache, etc.)',
	],
	'DebugSqlThreshold'			=> 'Threshold performance RDBMS:',
	'DebugSqlThresholdInfo'		=> 'In detailed debug mode, report only the queries that take longer than the number of seconds specified.',
	'DebugAdminOnly'			=> 'Closed diagnosis:',
	'DebugAdminOnlyInfo'		=> 'Show debug data of the program (and DBMS) only for the administrator.',

	'CachingSection'			=> 'Caching Options',
	'Cache'						=> 'Cache rendered pages:',
	'CacheInfo'					=> 'Save rendered pages in the local cache to speed up the subsequent boot. Valid only for unregistered visitors.',
	'CacheTtl'					=> 'Time-to-live for cached pages:',
	'CacheTtlInfo'				=> 'Cache pages no more than a specified number of seconds.',
	'CacheSql'					=> 'Cache DBMS queries:',
	'CacheSqlInfo'				=> 'Maintain a local cache of the results of certain resource-related SQL queries.',
	'CacheSqlTtl'				=> 'Time-to-live for cached SQL queries:',
	'CacheSqlTtlInfo'			=> 'Cache results of SQL queries for no more than the specified number of seconds. Values greater than 1200 are not desirable.',

	'LogSection'				=> 'Log Settings',
	'LogLevelUsage'				=> 'Use logging:',
	'LogLevelUsageInfo'			=> 'The minimum priority of the events recorded in the log.',
	'LogThresholds'	=> [
		'0'		=> 'do not keep a journal',
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high',
		'4'		=> 'on average',
		'5'		=> 'from low',
		'6'		=> 'the minimum level',
		'7'		=> 'record all',
	],
	'LogDefaultShow'			=> 'Display log mode:',
	'LogDefaultShowInfo'		=> 'The minimum priority events displayed in the log by default.',
	'LogModes'	=> [
		'1'		=> 'only the critical level',
		'2'		=> 'from the highest level',
		'3'		=> 'from high-level',
		'4'		=> 'the average',
		'5'		=> 'from a low',
		'6'		=> 'from the minimum level',
		'7'		=> 'show all',
	],
	'LogPurgeTime'				=> 'Storage time of Log:',
	'LogPurgeTimeInfo'			=> 'Remove event log after the specified number of days.',

	'PrivacySection'			=> 'Privacy',
	'AnonymizeIp'				=> 'Anonymize users IP addresses:',
	'AnonymizeIpInfo'			=> 'Anonymize IP addresses where applicable (i.e., page, revision or referrers).',

	'ReverseProxySection'		=> 'Reverse Proxy',
	'ReverseProxy'				=> 'Use reverse proxy:',
	'ReverseProxyInfo'			=> 'Habilitar esta configuração para determinar o endereço IP correcto do cliente remoto,
									examinando a informação armazenada nos cabeçalhos do X-Forwarded-For. X-Forwarded-For headers
									são um mecanismo padrão para identificar sistemas clientes que se ligam através de um servidor
									proxy reverso, como o Squid ou o Pound. Os servidores proxy reversos são frequentemente utilizados
									para melhorar o desempenho de sites muito visitados e podem também proporcionar outros benefícios
									de cache, segurança ou encriptação de sites. Se esta instalação WackoWiki funcionar por detrás de
									um proxy reverso, esta configuração deve ser activada para que a informação correcta do endereço IP
									seja capturada na gestão de sessões, registo, estatísticas e sistemas de gestão de acesso de WackoWiki;
									se não tiver a certeza sobre esta configuração, não tenha um proxy reverso, ou WackoWiki funcione
									num ambiente de alojamento partilhado, esta configuração deve permanecer desactivada.',
	'ReverseProxyHeader'		=> 'Reverse proxy header:',
	'ReverseProxyHeaderInfo'	=> 'Defina este valor se o seu servidor proxy enviar o IP do cliente num cabeçalho
									diferente de X-Forwarded-For. O cabeçalho "X-Forwarded-For" é uma lista de endereços
									IP separada por vírgula+espaço, apenas o último (o mais à esquerda) será utilizado.',
	'ReverseProxyAddresses'		=> 'reverse_proxy accepts an array of IP addresses:',
	'ReverseProxyAddressesInfo'	=> 'Each element of this array is the IP address of any of your reverse
									 proxies. If using this array, WackoWiki will trust the information stored
									 in the X-Forwarded-For headers only if the Remote IP address is one of
									 these, that is, the request reaches the web server from one of your
									 reverse proxies. Otherwise, the client could directly connect to
									 your web server by spoofing the X-Forwarded-For headers.',

	'SessionSection'				=> 'Session Handling',
	'SessionStorage'				=> 'Session storage:',
	'SessionStorageInfo'			=> 'This option defines where the the session data is stored. By default, either file or database session storage is selected.',
	'SessionModes'	=> [
		'1'		=> 'Ficheiro',
		'2'		=> 'Base de dados',
	],
	'SessionNotice'					=> 'Mostrar causa de encerramento da sessão:',
	'SessionNoticeInfo'				=> 'Indica a causa do encerramento da sessão.',
	'LoginNotice'					=> 'Aviso de início de sessão:',
	'LoginNoticeInfo'				=> 'Apresenta um aviso de início de sessão.',

	'RewriteMode'					=> 'Use <code>mod_rewrite</code>:',
	'RewriteModeInfo'				=> 'If your web server supports this feature, enable to "beautify" the page URLs.<br>
										<span class="cite">The value might be  overwritten by the Settings class at runtime, regardless of whether it is switched off, if HTTP_MOD_REWRITE is on.',

	// Permissions settings
	'PermissionsSettingsInfo'		=> 'Parâmetros responsáveis pelo controlo de acesso e permissões.',
	'PermissionsSettingsUpdated'	=> 'Updated permissions settings',

	'PermissionsSection'		=> 'Rights and Privileges',
	'ReadRights'				=> 'Read rights by default:',
	'ReadRightsInfo'			=> 'Default assigned to the created root pages, as well as pages for which parent ACLs cannot be defined.',
	'WriteRights'				=> 'Write rights by default:',
	'WriteRightsInfo'			=> 'Default assigned to the created root pages, as well as pages for which parent ACLs cannot be defined.',
	'CommentRights'				=> 'Comment rights by default:',
	'CommentRightsInfo'			=> 'Default assigned to the created root pages, as well as pages for which parent ACLs cannot be defined.',
	'CreateRights'				=> 'Create rights of a sub page by default:',
	'CreateRightsInfo'			=> 'Define the right for creating root pages and assign them to pages for which parental rights cannot be defined.',
	'UploadRights'				=> 'Upload rights by default:',
	'UploadRightsInfo'			=> 'Default upload rights.',
	'RenameRights'				=> 'Global rename right:',
	'RenameRightsInfo'			=> 'The list of permissions to freely rename (move) pages.',

	'LockAcl'					=> 'Lock all ACLs to read only:',
	'LockAclInfo'				=> '<span class="cite">Overwrites the ACL settings for all pages to read only.</span><br>This might be useful if a project is finished, you want close editing for a period of time for security reasons, or as a emergency response to an exploit or vulnerability.',
	'HideLocked'				=> 'Hide inaccessible pages:',
	'HideLockedInfo'			=> 'If the user does not have permission to read the page, hide it in different page lists (however the link placed in text will still be visible).',
	'RemoveOnlyAdmins'			=> 'Only administrators can delete pages:',
	'RemoveOnlyAdminsInfo'		=> 'Deny all, except administrators, the ability to delete pages. The first limit applies to owners of normal pages.',
	'OwnersRemoveComments'		=> 'Owners of pages can delete comments:',
	'OwnersRemoveCommentsInfo'	=> 'Allow page owners to moderate comments on their pages.',
	'OwnersEditCategories'		=> 'Owners can edit page categories:',
	'OwnersEditCategoriesInfo'	=> 'Allow owners to modify the pages category list of your site (add words, delete words), assigns to a page.',
	'TermHumanModeration'		=> 'Human moderation expiration:',
	'TermHumanModerationInfo'	=> 'Os moderadores só podem editar comentários se tiverem sido criados não mais do que este número de dias atrás (esta limitação não se aplica ao último comentário no tópico).',

	'UserCanDeleteAccount'		=> 'Os utilizadores podem eliminar as suas contas',

	// Security settings
	'SecuritySettingsInfo'		=> 'Parameters responsible for the overall safety of the platform, safety restrictions and additional security subsystems.',
	'SecuritySettingsUpdated'	=> 'Updated security settings',

	'AllowRegistration'			=> 'Register online:',
	'AllowRegistrationInfo'		=> 'Registo de utilizador aberto. A desactivação desta opção impedirá o registo gratuito, no entanto, o próprio administrador do sítio poderá registar outros utilizadores.',
	'ApproveNewUser'			=> 'Approve new users:',
	'ApproveNewUserInfo'		=> 'Allows administrators to approve users once they register. Only approved users will be allowed to log in the site.',
	'PersistentCookies'			=> 'Persistent cookies:',
	'PersistentCookiesInfo'		=> 'Allow persistent cookies.',
	'DisableWikiName'			=> 'Disable WikiName:',
	'DisableWikiNameInfo'		=> 'Disable the the mandatory use of a WikiName for users. Permits user registration with traditional nicknames instead of forced CamelCase-formatted names (i.e., NameSurname).',
	'UsernameLength'			=> 'Username length:',
	'UsernameLengthInfo'		=> 'Minimum and maximum number of characters in usernames.',

	'EmailSection'				=> 'Email',
	'AllowEmailReuse'			=> 'Allow email address re-use:',
	'AllowEmailReuseInfo'		=> 'Different users can register with the same email address.',
	'EmailConfirmation'			=> 'Impor confirmação por correio eletrónico:',
	'EmailConfirmationInfo'		=> 'Requer que o utilizador verifique o seu endereço de correio eletrónico antes de poder iniciar sessão.',
	'AllowedEmailDomains'		=> 'Domínios de correio eletrónico permitidos:',
	'AllowedEmailDomainsInfo'	=> 'Domínios de correio eletrónico permitidos separados por vírgulas, por exemplo, <code>example.com, local.lan</code> etc., caso contrário, todos os domínios de correio eletrónico são permitidos.',
	'ForbiddenEmailDomains'		=> 'Domínios de correio eletrónico proibidos:',
	'ForbiddenEmailDomainsInfo'	=> 'Domínios de correio eletrónico proibidos separados por vírgulas, por exemplo, <code>example.com, local.lan</code> etc. (só é eficaz se a lista de domínios de correio eletrónico permitidos estiver vazia)',

	'CaptchaSection'			=> 'CAPTCHA',
	'EnableCaptcha'				=> 'Enable captcha:',
	'EnableCaptchaInfo'			=> 'If enabled, captcha will be shown in the following cases, or if a security threshold is reached.',
	'CaptchaComment'			=> 'New comment:',
	'CaptchaCommentInfo'		=> 'As protection against spam, unregistered users must complete captcha before comment will be posted.',
	'CaptchaPage'				=> 'New page:',
	'CaptchaPageInfo'			=> 'As protection against spam, unregistered users must complete captcha before creating a new page.',
	'CaptchaEdit'				=> 'Edit page:',
	'CaptchaEditInfo'			=> 'As protection against spam, unregistered users must complete captcha before editing pages.',
	'CaptchaRegistration'		=> 'Criar conta:',
	'CaptchaRegistrationInfo'	=> 'As protection against spam, unregistered users must complete captcha before registering.',

	'TlsSection'				=> 'TLS Settings',
	'TlsConnection'				=> 'TLS-Connection:',
	'TlsConnectionInfo'			=> 'Use TLS-secured connection. <span class="cite">Activate the required pre-installed TLS-certificate on the server, otherwise you will lose access to the admin panel!</span><br>It also determines if the the Cookie Secure Flag is set, the <code>secure</code> flag specifies whether cookies should only be sent over secure connections.',
	'TlsImplicit'				=> 'Mandatory TLS:',
	'TlsImplicitInfo'			=> 'Forcibly reconnect the client from HTTP to HTTPS. With the option disabled, the client can browse the site through an open HTTP channel.',

	'HttpSecurityHeaders'		=> 'HTTP Security Headers',
	'EnableSecurityHeaders'		=> 'Enable security headers:',
	'EnableSecurityHeadersinfo'	=> 'Set security headers (frame busting, clickjacking/XSS/CSRF protection). <br>CSP may cause issues in certain situations (e.g. during development), or when using plugins relying on externally hosted resources such as images or scripts. <br>Disabling Content Security Policy is a security risk!',
	'Csp'						=> 'Content-Security-Policy (CSP):',
	'CspInfo'					=> 'Configuring CSP involves deciding what policies you want to enforce, and then configuring them and using Content-Security-Policy to establish your policy.',
	'PolicyModes'	=> [
		'0'		=> 'disabled',
		'1'		=> 'strict',
		'2'		=> 'custom',
	],
	'PermissionsPolicy'			=> 'Permissions policy:',
	'PermissionsPolicyInfo'		=> 'O cabeçalho HTTP Permissions-Policy fornece um mecanismo para activar ou desactivar explicitamente várias funcionalidades poderosas do navegador.',
	'ReferrerPolicy'			=> 'Referrer policy:',
	'ReferrerPolicyInfo'		=> 'The Referrer-Policy HTTP header governs which referrer information, sent in the Referer header, should be included in responses.',
	'ReferrerPolicyModes'	=> [
		'0'		=> '[off]',
		'1'		=> 'no-referrer',
		'2'		=> 'no-referrer-when-downgrade',
		'3'		=> 'same-origin',
		'4'		=> 'origin',
		'5'		=> 'strict-origin',
		'6'		=> 'origin-when-cross-origin',
		'7'		=> 'strict-origin-when-cross-origin',
		'8'		=> 'unsafe-url'
	],

	'UserPasswordSection'		=> 'Persistence of User Passwords',
	'PwdMinChars'				=> 'Minimum password length:',
	'PwdMinCharsInfo'			=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 12 to 16 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'AdminPwdMinChars'			=> 'Minimum admin password length:',
	'AdminPwdMinCharsInfo'		=> 'Longer passwords are necessarily more secure than shorter passwords (e.g. 15 to 20 characters).<br>The use of passphrases instead of passwords is encouraged.',
	'PwdCharComplexity'			=> 'The required password complexity:',
	'PwdCharClasses'	=> [
		'0'		=> 'not tested',
		'1'		=> 'any letters + numbers',
		'2'		=> 'uppercase and lowercase + numbers',
		'3'		=> 'uppercase and lowercase + numbers + characters',
	],
	'PwdUnlikeLogin'			=> 'Additional complication:',
	'PwdUnlikes'	=> [
		'0'		=> 'not tested',
		'1'		=> 'password is not identical to the login',
		'2'		=> 'password does not contain username',
	],

	'LoginSection'				=> 'Conecte-se',
	'MaxLoginAttempts'			=> 'Maximum number of login attempts per username:',
	'MaxLoginAttemptsInfo'		=> 'The number of login attempts allowed for a single account before the anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered for distinct user accounts.',
	'IpLoginLimitMax'			=> 'Maximum number of login attempts per IP address:',
	'IpLoginLimitMaxInfo'		=> 'The threshold of login attempts allowed from a single IP address before an anti-spambot task is triggered. Enter 0 to prevent the anti-spambot task from being triggered by IP addresses.',

	'FormsSection'				=> 'Forms',
	'FormTokenTime'				=> 'Maximum time to submit forms:',
	'FormTokenTimeInfo'			=> 'O tempo que um utilizador tem de submeter um formulário (em segundos).<br> Note que um formulário pode tornar-se inválido se a sessão expirar, independentemente desta configuração.',

	'SessionLength'				=> 'Session cookie expiration:',
	'SessionLengthInfo'			=> 'The lifetime of the user session cookie by default (in days).',
	'CommentDelay'				=> 'Anti-flood for comments:',
	'CommentDelayInfo'			=> 'The minimum delay between the publication of new user comments (in seconds).',
	'IntercomDelay'				=> 'Anti-flood for personal communications:',
	'IntercomDelayInfo'			=> 'The minimum delay between sending private messages (in seconds).',
	'RegistrationDelay'			=> 'Time threshold for registering:',
	'RegistrationDelayInfo'		=> 'The minimum time threshold for filling out the registration form to tell away bots from humans (in seconds).',

	// Formatter settings
	'FormatterSettingsInfo'		=> 'Group of parameters responsible for fine-tuning the site. Do not change them unless you are confident in their actions.',
	'FormatterSettingsUpdated'	=> 'Updated formatting settings',

	'TextHandlerSection'		=> 'Text Handler:',
	'Typografica'				=> 'Typographical proofreader:',
	'TypograficaInfo'			=> 'Disabling this option will speed up the processes of adding comments and saving pages.',
	'Paragrafica'				=> 'Paragrafica markings:',
	'ParagraficaInfo'			=> 'Similar to the previous option, but will lead to disconnection of inoperable automatic table of contents (<code>{{toc}}</code>).',
	'AllowRawhtml'				=> 'Global HTML support:',
	'AllowRawhtmlInfo'			=> 'This option is potentially unsafe for an open site.',
	'SafeHtml'					=> 'Filtering HTML:',
	'SafeHtmlInfo'				=> 'Prevents saving of dangerous HTML-objects. Turning off the filter on an open site with HTML support is <span class="underline">extremely</span> undesirable!',

	'WackoFormatterSection'		=> 'Wiki Text Formatter (Wacko Formatter)',
	'X11colors'					=> 'X11 colors usage:',
	'X11colorsInfo'				=> 'Extends the available colors for <code>??(color) background??</code> and <code>!!(color) text!!</code>Disabling this option speeds up the processes of adding comments and saving pages.',
	'WikiLinks'					=> 'Disable wiki links:',
	'WikiLinksInfo'				=> 'Desactiva a ligação para <code>CamelCaseWords</code>, as suas Palavras CamelCase não serão mais ligadas directamente a uma nova página. Isto é útil quando se trabalha em diferentes namespaces aks clusters. Por defeito, está desligado.',
	'BracketsLinks'				=> 'Disable bracketed links:',
	'BracketsLinksInfo'			=> 'Disables <code>[[link]]</code> and <code>((link))</code> syntax.',
	'Formatters'				=> 'Desativar formatadores:',
	'FormattersInfo'			=> 'Disables <code>%%code%%</code> syntax, used for highlighters.',

	'DateFormatsSection'		=> 'Date Formats',
	'DateFormat'				=> 'The format of the date:',
	'DateFormatInfo'			=> '(day, month, year)',
	'TimeFormat'				=> 'The format of time:',
	'TimeFormatInfo'			=> '(hour, minute)',
	'TimeFormatSeconds'			=> 'The format of the exact time:',
	'TimeFormatSecondsInfo'		=> '(hours, minutes, seconds)',
	'NameDateMacro'				=> 'The format of the <code>::@::</code> macro:',
	'NameDateMacroInfo'			=> '(name, time), e.g. <code>UserName (17.11.2016 16:48)</code>',
	'Timezone'					=> 'Fuso Horário:',
	'TimezoneInfo'				=> 'Fuso horário a utilizar para mostrar os horários aos utilizadores que não estão ligados (convidados). Os utilizadores com sessão iniciada definem e podem alterar o seu fuso horário nas suas definições de utilizador.',

	'Canonical'					=> 'Usar URLs absolutas:',
	'CanonicalInfo'				=> 'Todos os links são criados como URLs absolutos no formulário %1. Os URLs relativos à raiz do servidor no formulário %2 devem ser preferidos.',
	'LinkTarget'				=> 'Where external links open:',
	'LinkTargetInfo'			=> 'Abre cada ligação externa numa nova janela do navegador. Adiciona <code>target="_blank"</code> à sintaxe do link.',
	'Noreferrer'				=> 'noreferrer:',
	'NoreferrerInfo'			=> 'Requer que o browser não deve enviar um cabeçalho de referência HTTP se o utilizador seguir o hiperlink. Adiciona <code>rel="noreferrer"</code> à sintaxe do link.',
	'Nofollow'					=> 'nofollow:',
	'NofollowInfo'				=> 'Instrua alguns motores de busca que o hiperlink não deve influenciar a classificação dos links alvo no índice dos motores de busca. Adiciona <code>rel="nofollow"</code> à sintaxe da hiperligação.',
	'UrlsUnderscores'			=> 'Form addresses (URLs) with underscores:',
	'UrlsUnderscoresInfo'		=> 'For example, %1 becames %2 with this option.',
	'ShowSpaces'				=> 'Mostrar espaço em WikiNames:',
	'ShowSpacesInfo'			=> 'Show spaces in WikiNames, e.g. <code>MyName</code> being displayed as <code>My Name</code> with this option.',
	'NumerateLinks'				=> 'Enumerate links in print view:',
	'NumerateLinksInfo'			=> 'Enumerates and lists all links at the bottom of the print view with this option.',
	'YouareHereText'			=> 'Disable and visualize self-referencing links:',
	'YouareHereTextInfo'		=> 'Visualize links to the same page, using <code>&lt;b&gt;####&lt;/b&gt;</code>. All links to self lose link formatting, but are displayed as bold text.',

	// Pages settings
	'PagesSettingsInfo'			=> 'Aqui pode definir ou alterar as páginas base do sistema utilizadas dentro do Wiki. Por favor não se esqueça de criar ou alterar as páginas correspondentes no Wiki de acordo com as suas definições aqui.',
	'PagesSettingsUpdated'		=> 'Updated settings base pages',

	'ListCount'					=> 'Number of items per list:',
	'ListCountInfo'				=> 'Number of items displayed on each list for guest, or as default value for new users.',

	'ForumSection'				=> 'Options Forum',
	'ForumCluster'				=> 'Cluster forum:',
	'ForumClusterInfo'			=> 'Root cluster for forum section (action %1).',
	'ForumTopics'				=> 'Number of topics per page:',
	'ForumTopicsInfo'			=> 'Number of topics displayed on each page of the list in the forum sections (action %1).',
	'CommentsCount'				=> 'Number of comments per page:',
	'CommentsCountInfo'			=> 'Number of comments displayed on each page\'s list of comments. This applies to all the comments on the site, not just those posted in the forum.',

	'NewsSection'				=> 'Section News',
	'NewsCluster'				=> 'Cluster for the news:',
	'NewsClusterInfo'			=> 'Root cluster for news section (action %1).',
	'NewsStructure'				=> 'News cluster structure:',
	'NewsStructureInfo'			=> 'Stores the articles optionally in sub-clusters by year/month or week (e.g. <code>[cluster]/[year]/[month]</code>).',

	'LicenseSection'			=> 'Licença',
	'DefaultLicense'			=> 'Default license:',
	'DefaultLicenseInfo'		=> 'Under which license your content can be released.',
	'EnableLicense'				=> 'Enable license:',
	'EnableLicenseInfo'			=> 'Enable to show license information.',
	'LicensePerPage'			=> 'License per page:',
	'LicensePerPageInfo'		=> 'Allow license per page, which the page owner can choose via page properties.',

	'ServicePagesSection'		=> 'Service Pages',
	'RootPage'					=> 'Home page:',
	'RootPageInfo'				=> 'Tag of your main page, opens automatically when a user visits your site.',

	'PrivacyPage'				=> 'Política de privacidade:',
	'PrivacyPageInfo'			=> 'The page with the Privacy Policy of the site.',

	'TermsPage'					=> 'Policies and regulations:',
	'TermsPageInfo'				=> 'The page with the rules of the site.',

	'SearchPage'				=> 'Pesquisa:',
	'SearchPageInfo'			=> 'Page with the search form (action %1).',
	'RegistrationPage'			=> 'CriarConta:',
	'RegistrationPageInfo'		=> 'Page for new user registration (action %1).',
	'LoginPage'					=> 'User login:',
	'LoginPageInfo'				=> 'Login page on the site (action %1).',
	'SettingsPage'				=> 'User Settings:',
	'SettingsPageInfo'			=> 'Page to customize the user profile (action %1).',
	'PasswordPage'				=> 'Change Password:',
	'PasswordPageInfo'			=> 'Page with a form to change / query user password (action %1).',
	'UsersPage'					=> 'User list:',
	'UsersPageInfo'				=> 'Page with a list of registered users (action %1).',
	'CategoryPage'				=> 'Categoria:',
	'CategoryPageInfo'			=> 'Page with a list of categorized pages (action %1).',
	'GroupsPage'				=> 'Grupos:',
	'GroupsPageInfo'			=> 'Page with a list of working groups (action %1).',
	'ChangesPage'				=> 'Recent changes:',
	'ChangesPageInfo'			=> 'Page with a list of the last modified pages (action %1).',
	'CommentsPage'				=> 'Recent comments:',
	'CommentsPageInfo'			=> 'Page with a list of recent comment on the page (action %1).',
	'RemovalsPage'				=> 'Deleted pages:',
	'RemovalsPageInfo'			=> 'Page with a list of recently deleted pages (action %1).',
	'WantedPage'				=> 'Wanted pages:',
	'WantedPageInfo'			=> 'Page with a list of missing pages that are referenced (action %1).',
	'OrphanedPage'				=> 'Orphaned pages:',
	'OrphanedPageInfo'			=> 'Page with a list of existing pages are not related via links to any other page (action %1).',
	'SandboxPage'				=> 'Sandbox:',
	'SandboxPageInfo'			=> 'Page where users can practice their wiki markup skills.',
	'HelpPage'					=> 'Socorro:',
	'HelpPageInfo'				=> 'The documentation section for working with site tools.',
	'IndexPage'					=> 'Index:',
	'IndexPageInfo'				=> 'Página com uma lista de todas as páginas (action %1).',
	'RandomPage'				=> 'Aleatória:',
	'RandomPageInfo'			=> 'Carrega uma página aleatória  (action %1).',


	// Notification settings
	'NotificationSettingsInfo'	=> 'Parameters for notifications of the platform.',
	'NotificationSettingsUpdated'	=> 'Updated notification settings',

	'EmailNotification'			=> 'Email notification:',
	'EmailNotificationInfo'		=> 'Allow email notification. Set to Enabled to enable email notifications, Disabled to disable them. Note that disabling email notifications has no effect on emails generated as part of the user signup process.',
	'Autosubscribe'				=> 'Autosubscribe:',
	'AutosubscribeInfo'			=> 'Automatically sign a new page in the owner\'s notice of its changes.',

	'NotificationSection'		=> 'Default User Notification Settings',
	'NotifyPageEdit'			=> 'Notify page edit:',
	'NotifyPageEditInfo'		=> 'Pending - Send an email notification only for the first change until the user visits the page again.',
	'NotifyMinorEdit'			=> 'Notify minor edit:',
	'NotifyMinorEditInfo'		=> 'Sends notifications also for minor edits.',
	'NotifyNewComment'			=> 'Notify new comment:',
	'NotifyNewCommentInfo'		=> 'Pending - Send an email notification only for the first comment until the user visits the page again.',

	'NotifyUserAccount'			=> 'Notify new user account:',
	'NotifyUserAccountInfo'		=> 'The Admin will to be notified when a new user has been created using the signup form.',
	'NotifyUpload'				=> 'Notify file upload:',
	'NotifyUploadInfo'			=> 'The Moderators will to be notified when a file has been uploaded.',

	'PersonalMessagesSection'	=> 'Mensagens pessoais',
	'AllowIntercomDefault'		=> 'Allow intercom:',
	'AllowIntercomDefaultInfo'	=> 'Enabling this option allows other users to send personal messages to the recipient\'s email address without disclosing the address.',
	'AllowMassemailDefault'		=> 'Allow mass email:',
	'AllowMassemailDefaultInfo'	=> 'Only send messages to those users who have permitted administrators to email them information.',

	// Resync settings
	'Synchronize'				=> 'sincronizar',
	'UserStatsSynched'			=> 'User Statistics synchronized.',
	'PageStatsSynched'			=> 'Page Statistics synchronized.',
	'FeedsUpdated'				=> 'RSS-feeds updated.',
	'SiteMapCreated'			=> 'The new version of the site map created successfully.',
	'ParseNextBatch'			=> 'Parse next batch of pages:',
	'WikiLinksRestored'			=> 'Wiki-links restored.',

	'LogUserStatsSynched'		=> 'Synchronized user statistics',
	'LogPageStatsSynched'		=> 'Synchronized page statistics',
	'LogFeedsUpdated'			=> 'Synchronized RSS feeds',
	'LogPageBodySynched'		=> 'Reparsed page body and links',

	'UserStats'					=> 'User statistics',
	'UserStatsInfo'				=> 'User statistics (number of comments, owned pages, revisions and files) may differ in some situations from actual data. <br>This operation allows updating statistics to match actual data contained in the database.',
	'PageStats'					=> 'Page statistics',
	'PageStatsInfo'				=> 'Page statistics (number of comments, files and revisions) may differ in some situations from actual data. <br>This operation allows updating statistics to match actual data contained in database.',

	'AttachmentsInfo'			=> 'Actualiza o hash do ficheiro para todos os anexos da base de dados.',
	'AttachmentsSynched'		=> 'Reescrever todos os anexos dos ficheiros',
	'LogAttachmentsSynched'		=> 'Reescrever todos os anexos dos ficheiros',

	'Feeds'						=> 'Feeds',
	'FeedsInfo'					=> 'In the case of direct editing of pages in the database, the content of RSS-feeds may not reflect the changes made. <br>This function synchronizes the RSS-channels with the current state of the database.',
	'XmlSiteMap'				=> 'XML-Sitemap',
	'XmlSiteMapInfo'			=> 'This function synchronizes the XML-Sitemap with the current state of the database.',
	'XmlSiteMapPeriod'			=> 'Period %1 days. Last written %2.',
	'XmlSiteMapView'			=> 'Show Sitemap in a new window.',

	'ReparseBody'				=> 'Reparse all pages',
	'ReparseBodyInfo'			=> 'Empties <code>body_r</code> in page table, so that each page gets rendered again on the next page view. This may be useful if you modified the formatter or changed the domain of your wiki.',
	'PreparsedBodyPurged'		=> 'Emptied <code>body_r</code> field in page table.',

	'WikiLinksResync'			=> 'Wiki-links',
	'WikiLinksResyncInfo'		=> 'Performs a re-rendering for all intrasite links and restores the contents of the <code>page_link</code> and <code>file_link</code> tables in the event of damage or relocation (this can take considerable time).',
	'RecompilePage'				=> 'Recopilando todas as páginas (extremamente caras)',
	'ResyncOptions'				=> 'Additional options',
	'RecompilePageLimit'		=> 'Number of pages to parse at once.',

	// Email settings
	'EmaiSettingsInfo'			=> 'Esta informação é usada quando o Fórum envia emails aos Utilizadores. Certifique-se que usa um email válido. Qualquer Mensagem incorreta não será entregue neste endereço. Se o seu serviço de hospedagem não oferece um serviço nativo de email baseado no PHP, pode enviar mensagens através de SMTP. É necessário um Servidor adequado, não especifique qualquer nome antigo aqui! Se o servidor requer autenticação, introduza os nomes e senhas necessários. tenha em atenção que apenas é usada a autenticação básica. Implementações de autenticações diferentes não estão disponíveis.',

	'EmailSettingsUpdated'		=> 'Updated Email settings',

	'EmailFunctionName'			=> 'Nome da Função de email:',
	'EmailFunctionNameInfo'		=> 'Função de email usada para enviar emails através do PHP.',
	'UseSmtpInfo'				=> 'Select <code>SMTP</code> se quer ou tem que enviar os emails recorrendo a um Servidor SMTP em vez da função de email do Servidor.',

	'EnableEmail'				=> 'Enable emails:',
	'EnableEmailInfo'			=> 'Enable sending of emails.',

	'EmailIdentitySettings'		=> 'Website E-mails Identidade',
	'FromEmailName'				=> 'From Name:',
	'FromEmailNameInfo'			=> 'The sender name that is use for the <code>From:</code> header for all email notifications sent from the site.',
	'EmailSubjectPrefix'		=> 'Prefixo do assunto:',
	'EmailSubjectPrefixInfo'	=> 'Prefixo alternativo do assunto do correio eletrónico, por exemplo, <code>[Prefixo] Tópico</code>. Se não for definido, o prefixo predefinido é Nome do sítio: %1.',

	'NoReplyEmail'				=> 'No-reply address:',
	'NoReplyEmailInfo'			=> 'This address, e.g. <code>noreply@example.com</code>, will appear in the <code>From:</code> email address field of all email notifications sent from the site.',
	'AdminEmail'				=> 'Email of the site owner:',
	'AdminEmailInfo'			=> 'This address is used for admin purposes, like new user notification.',
	'AbuseEmail'				=> 'Email abuse service:',
	'AbuseEmailInfo'			=> 'Address requests for urgent matters: registration for a foreign email, etc. It may be the same as the site owner email.',

	'SendTestEmail'				=> 'Enviar um E-mail de Teste',
	'SendTestEmailInfo'			=> 'This will send a test email to the address defined in your account.',
	'TestEmailSubject'			=> 'Your Wiki is correctly configured to send emails',
	'TestEmailBody'				=> 'If you received this email, your Wiki is correctly configured to send emails.',
	'TestEmailMessage'			=> 'The test email has been sent.<br>If you don\'t receive it, please check your email configuration settings.',

	'SmtpSettings'				=> 'Configurações do SMTP',
	'SmtpAutoTls'				=> 'Opportunistic TLS:',
	'SmtpAutoTlsInfo'			=> 'Enables encryption automatically, if it sees that the server is advertising TLS encryption (after you have connected to the server), even if you have not set the connection mode for <code>SMTPSecure</code>.',
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
	'UploadSettingsUpdated'		=> 'Updated upload settings',

	'FileUploadsSection'		=> 'File Uploads',
	'RegisteredUsers'			=> 'utilizadores registados',
	'RightToUpload'				=> 'Permissions to upload files:',
	'RightToUploadInfo'			=> '<code>admins</code> means that only users belonging to the admins group can upload  files. <code>1</code> means that uploading is opened to registered users. <code>0</code> means that upload disabled.',
	'UploadMaxFilesize'			=> 'Tamanho máximo de anexos:',
	'UploadMaxFilesizeInfo'		=> 'Tamanho máximo de cada anexo. Se este valor for 0, o tamanho do ficheiro enviado fica sujeito às permissões do PHP.',
	'UploadQuota'				=> 'Espaço total de Anexos:',
	'UploadQuotaInfo'			=> 'Espaço máximo em disco reservado aos anexos. <code>0</code> = ilimitado. %1 used.',
	'UploadQuotaUser'			=> 'Storage quota per user:',
	'UploadQuotaUserInfo'		=> 'Restriction on the quota of storage that can be uploaded by one user, with <code>0</code> being unlimited.',

	'FileTypes'					=> 'Tipos de ficheiro',
	'UploadOnlyImages'			=> 'Allow only upload of images:',
	'UploadOnlyImagesInfo'		=> 'Allow only uploading of image files on the page.',
	'AllowedUploadExts'			=> 'Tipos de ficheiro permitidos:',
	'AllowedUploadExtsInfo'		=> 'Extensões permitidas para carregar ficheiros, separadas por vírgula, por exemplo <código>png, ogg, mp4</código>, outras extensões de ficheiros não proibidas são todas permitidas.<br>Deve limitar a lista de tipos de ficheiros carregados permitidos ao mínimo necessário para a funcionalidade de conteúdo do seu sítio.',
	'CheckMimetype'				=> 'Verificar ficheiros anexados:',
	'CheckMimetypeInfo'			=> 'Alguns Ficheiros podem obrigar os navegadores e executar funções incorretas. Esta opção permite recusar esses Ficheiros.',
	'SvgSanitizer'				=> 'SVG Sanitizer:',
	'SvgSanitizerInfo'			=> 'Isto permite a higienização dos ficheiros SVG carregados para evitar que ficheiros SVG/XML vulneráveis sejam carregados.',
	'TranslitFileName'			=> 'Transliterate file names:',
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
	'DeletedObjectsInfo'		=> 'List of removed pages, revisions and files.
									Remove or restore the pages, revisions or files from the database by clicking on the link <em>Remove</em>
									or <em>Restore</em> in the corresponding row. (Be careful, no delete confirmation is requested!)',

	// Filter module
	'FilterSettingsInfo'		=> 'Words that will be automatically censored on your Wiki.',
	'FilterSettingsUpdated'		=> 'Updated spam filter settings',

	'WordCensoringSection'		=> 'Word Censoring',
	'SPAMFilter'				=> 'Spam filter:',
	'SPAMFilterInfo'			=> 'Enabling Spam Filter',
	'WordList'					=> 'Word list:',
	'WordListInfo'				=> 'Word or phrase <code>fragment</code> to be blacklisted (one per line)',

	// Log module
	'LogFilterTip'				=> 'Filter events by criteria:',
	'LogLevel'					=> 'Level',
	'LogLevelFilters'	=> [
		'1'		=> 'not less than',
		'2'		=> 'not higher than',
		'3'		=> 'equal',
	],
	'LogNoMatch'				=> 'No events that meet the criteria',
	'LogDate'					=> 'Date',
	'LogEvent'					=> 'Event',
	'LogUsername'				=> 'Nome de utilizador',
	'LogLevels'	=> [
		'1'		=> 'critical',
		'2'		=> 'highest',
		'3'		=> 'high',
		'4'		=> 'medium',
		'5'		=> 'low',
		'6'		=> 'lowest',
		'7'		=> 'debugging',
	],

	// Massemail module
	'MassemailInfo'				=> 'Aqui pode enviar um email a todos os seus Utilizadores ou a todos os Utilizadores de um determinado Grupo, <strong>se tiver a opção de receber emails ativada</strong>. Para isso, uma mensagem será enviada ao endereço de email do administrador a informar, com uma cópia a todos membros. A configuração padrão apenas inclui 20 destinatários por mensagem, sendo que para mais destinatários mais emails serão enviados. Se está a enviar mensagens a um grande grupo de Utilizadores, por favor, seja paciente e não feche a página durante o envio. É normal que o envio em massa de mensagens leve algum tempo: Será avisado quando o processo terminar.',
	'LogMassemail'				=> 'Mass email send %1 to group / user ',
	'MassemailSend'				=> 'Mass email send',

	'NoEmailMessage'			=> 'Tem que introduzir uma mensagem.',
	'NoEmailSubject'			=> 'A sua mensagem tem que ter um assunto.',
	'NoEmailRecipient'			=> 'É necessário especificar pelo menos um utilizador ou grupo de utilizadores.',

	'MassemailSection'			=> 'Mass email',
	'MessageSubject'			=> 'Sujeito:',
	'MessageSubjectInfo'		=> '',
	'YourMessage'				=> 'A sua Mensagem:',
	'YourMessageInfo'			=> 'A mensagem só pode conter texto puro. Todos os códigos serão removidos ao enviar.',

	'NoUser'					=> 'No user',
	'NoUserGroup'				=> 'No user group',

	'SendToGroup'				=> 'Enviar para Grupo:',
	'SendToUser'				=> 'Enviar para Utilizadores:',
	'SendToUserInfo'			=> 'Só envia mensagens aos utilizadores que autorizaram os administradores a enviar-lhes informações por correio eletrónico. Esta opção está disponível nas definições do utilizador em Notificações.',

	// System message module
	'SystemMessageInfo'			=> '',
	'SysMsgUpdated'				=> 'Updated system message',

	'SysMsgSection'				=> 'System message',
	'SysMsg'					=> 'System message:',
	'SysMsgInfo'				=> 'Your text here',

	'SysMsgType'				=> 'Type:',
	'SysMsgTypeInfo'			=> 'Message type (CSS).',
	'SysMsgAudience'			=> 'Público:',
	'SysMsgAudienceInfo'		=> 'O público a quem a mensagem do sistema é apresentada.',
	'EnableSysMsg'				=> 'Enable system message:',
	'EnableSysMsgInfo'			=> 'Show system message.',

	// User approval module
	'ApproveNotExists'			=> 'Seleccione pelo menos um utilizador através do botão Definir.',

	'LogUserApproved'			=> 'User ##%1## approved',
	'LogUserBlocked'			=> 'User ##%1## blocked',
	'LogUserDeleted'			=> 'User ##%1## removed from the database',
	'LogUserCreated'			=> 'Created a new user ##%1##',
	'LogUserUpdated'			=> 'Updated User ##%1##',

	'UserApproveInfo'			=> 'Aprovar novos utilizadores antes de poderem iniciar sessão no sítio.',
	'Approve'					=> 'Aprovar',
	'Deny'						=> 'Recusar',
	'Pending'					=> 'Pendente',
	'Approved'					=> 'Aprovado',
	'Denied'					=> 'Recusado',

	// DB Backup module
	'BackupStructure'			=> 'Structure',
	'BackupData'				=> 'Data',
	'BackupFolder'				=> 'Folder',
	'BackupTable'				=> 'Table',
	'BackupCluster'				=> 'Cluster:',
	'BackupFiles'				=> 'Ficheiros',
	'BackupNote'				=> 'Nota:',
	'BackupSettings'			=> 'Specify the desired scheme of backup.<br>' .
									'The root cluster does not affect the global files backup and cache files backup (if chosen, they are always saved in full).<br>' .
									'<br>' .
									'<strong>Attention</strong>: To avoid loss of information from the database when specifying the root cluster, the tables from this backup will not be restructured, ' .
									'same as when backing up only table structure without saving the data. ' .
									'To make a complete conversion of the tables to the backup format you must make the <em> full database backup (structure and data) without specifying the cluster</em>.',
	'BackupCompleted'			=> 'Backing up and archiving completed.<br>' .
									'The Backup package files were stored in the following sub-directory %1.<br>' .
									'To download it use FTP (maintain the directory structure and file names when copying).<br>' .
									'To restore a backup copy or remove a package, go to <a href="%2">Restore database</a>.',
	'LogSavedBackup'			=> 'Saved backup database ##%1##',
	'Backup'					=> 'Backup',
	'CantReadFile'				=> 'Can\'t read file %1.',

	// DB Restore module
	'RestoreInfo'				=> 'Pode restaurar qualquer um dos pacotes de cópia de segurança encontrados ou removê-los do servidor.',
	'ConfirmDbRestore'			=> 'Você quer restaurar o backup %1?',
	'ConfirmDbRestoreInfo'		=> 'Aguarde, isso pode levar alguns minutos.',
	'RestoreWrongVersion'		=> 'Wrong WackoWiki version!',
	'DirectoryNotExecutable'	=> 'O directório %1 não é executável.',
	'BackupDelete'				=> 'Tens a certeza que queres remover o backup %1?',
	'BackupDeleteInfo'			=> '',
	'RestoreOptions'			=> 'Additional restore options:',
	'RestoreOptionsInfo'		=> '* Before restoring the <strong>cluster backup</strong>, ' .
									'the target tables are not deleted (to prevent loss of information from the clusters that have not been backed up). ' .
									'Thus, during the recovery process duplicate records will occur. ' .
									'In normal mode, all of them will be replaced by the records form backup (using SQL-instruction <code>REPLACE</code>), ' .
									'but if this checkbox is checked, all duplicates are skipped (the current values of records will be kept), ' .
									'and only the records with new keys are added to the table (SQL-instruction <code>INSERT IGNORE</code>).<br>' .
									'<strong>Notice</strong>: When restore complete backup of the site, this option has no value.<br>' .
									'<br>' .
									'** If the backup contains the user files (global and perpage, cache files, etc.), ' .
									'in normal mode they replace the existing files with the same names and are placed in the same directory when being restored. ' .
									'This option allows you to save the current copies of the files and restore from a backup only new files (missing on the server).',
	'IgnoreDuplicatedKeysNr'	=> 'Ignore duplicated table keys (not replace)',
	'IgnoreSameFiles'			=> 'Ignore same files (not overwrite)',
	'NoBackupsAvailable'		=> 'No backups available.',
	'BackupEntireSite'			=> 'Entire site',
	'BackupRestored'			=> 'The backup is restored, a summary report is attached below. To delete this backup package, click',
	'BackupRemoved'				=> 'The selected backup has been successfully removed.',
	'LogRemovedBackup'			=> 'Removed database backup ##%1##',

	'RestoreStarted'			=> 'Initiated Restoration',
	'RestoreParameters'			=> 'Using parameters',
	'IgnoreDuplicatedKeys'		=> 'Ignore duplicated keys',
	'IgnoreDuplicatedFiles'		=> 'Ignore duplicated files',
	'SavedCluster'				=> 'Saved cluster',
	'DataProtection'			=> 'Data Protection - %1 omitted',
	'AssumeDropTable'			=> 'Assume %1',
	'RestoreTableStructure'		=> 'Restoring the structure of the table',
	'RunSqlQueries'				=> 'Perform SQL-instructions:',
	'CompletedSqlQueries'		=> 'Completed. Processed instructions:',
	'NoTableStructure'			=> 'The structure of the tables was not saved - skip',
	'RestoreRecords'			=> 'Restore the contents of tables',
	'ProcessTablesDump'			=> 'Just download and process table dumps',
	'Instruction'				=> 'Instruction',
	'RestoredRecords'			=> 'records:',
	'RecordsRestoreDone'		=> 'Completed. Total entries:',
	'SkippedRecords'			=> 'Data not saved - skip',
	'RestoringFiles'			=> 'Restoring files',
	'DecompressAndStore'		=> 'Decompress and store the contents of directories',
	'HomonymicFiles'			=> 'homonymic files',
	'RestoreSkip'				=> 'skip',
	'RestoreReplace'			=> 'replace',
	'RestoreFile'				=> 'Ficheiro:',
	'RestoredFiles'				=> 'restored:',
	'SkippedFiles'				=> 'skipped:',
	'FileRestoreDone'			=> 'Completed. Total files:',
	'FilesAll'					=> 'todos:',
	'SkipFiles'					=> 'Files are not stored - skip',
	'RestoreDone'				=> 'RESTORATION COMPLETED',

	'BackupCreationDate'		=> 'Creation Date',
	'BackupPackageContents'		=> 'The contents of the package',
	'BackupRestore'				=> 'Restaurar',
	'BackupRemove'				=> 'Remover',
	'RestoreYes'				=> 'Yes',
	'RestoreNo'					=> 'No',
	'LogDbRestored'				=> 'Backup ##%1## of the database restored.',

	'BackupArchived'			=> 'Cópia de segurança %1 arquivada.',
	'BackupArchiveExists'		=> 'O arquivo de cópia de segurança %1 já existe.',
	'LogBackupArchived'			=> 'Cópia de segurança ##%1## arquivada.',

	// User module
	'UsersInfo'					=> 'Here you can change your users information and certain specific options.',

	'UsersAdded'				=> 'User added',
	'UsersDeleteInfo'			=> '[User delete Info here..]',
	'EditButton'				=> 'Editar',
	'UsersAddNew'				=> 'Adicionar novo utilizador',
	'UsersDelete'				=> 'Tens a certeza que queres remover o utilizador %1?',
	'UsersDeleted'				=> 'O utilizador %1 foi eliminado da base de dados.',
	'UsersRename'				=> 'Rename the user %1 to',
	'UsersRenameInfo'			=> '* Nota: A alteração afectará todas as páginas que estão atribuídas a esse utilizador.',
	'UsersUpdated'				=> 'Utilizador atualizado com sucesso.',

	'UserIP'					=> 'IP',
	'UserSignuptime'			=> 'Signuptime',
	'UserActions'				=> 'Actions',
	'NoMatchingUser'			=> 'No users that meet the criteria',

	'UserAccountNotify'			=> 'Notificar usuário',
	'UserNotifySignup'			=> 'informar o usuário sobre a nova conta',
	'UserVerifyEmail'			=> 'definir token de confirmação de e-mail e adicionar link para verificação de e-mail',
	'UserReVerifyEmail'			=> 'Reenviar token de confirmação de e-mail',

	// Groups module
	'GroupsInfo'				=> 'From this panel you can administrate all your usergroups. You can delete, create and edit existing groups. Furthermore, you may choose group leaders, toggle open/hidden/closed group status and set the group name and description.',

	'LogMembersUpdated'			=> 'Updated usergroup members',
	'LogMemberAdded'			=> 'Added member ##%1## to group ##%2##',
	'LogMemberRemoved'			=> 'Removed member ##%1## from group ##%2##',
	'LogGroupCreated'			=> 'Created a new group ##%1##',
	'LogGroupRenamed'			=> 'Group ##%1## renamed to ##%2##',
	'LogGroupRemoved'			=> 'Removed group ##%1##',

	'GroupsMembersFor'			=> 'Members for Group',
	'GroupsDescription'			=> 'Descrição',
	'GroupsModerator'			=> 'Moderator',
	'GroupsOpen'				=> 'Open',
	'GroupsActive'				=> 'Active',
	'GroupsTip'					=> 'Click to edit Group',
	'GroupsUpdated'				=> 'Groups updated',
	'GroupsAlreadyExists'		=> 'Este grupo já existe.',
	'GroupsAdded'				=> 'Grupo adicionado com sucesso.',
	'GroupsRenamed'				=> 'Grupo renomeado com sucesso.',
	'GroupsDeleted'				=> 'The group %1 and all associated pages were deleted from the database.',
	'GroupsAdd'					=> 'Adicionar um novo grupo',
	'GroupsRename'				=> 'Renomear o grupo %1 para',
	'GroupsRenameInfo'			=> '* Note: Change will affect all pages that are assigned to that group.',
	'GroupsDelete'				=> 'Tens a certeza que queres remover o grupo %1?',
	'GroupsDeleteInfo'			=> '* Nota: A mudança afetará todos os membros designados a esse grupo.',
	'GroupsIsSystem'			=> 'O Grupo %1 pertence ao sistema e não pode ser removido.',
	'GroupsStoreButton'			=> 'Save Groups',
	'GroupsEditInfo'			=> 'To edit the groups list select the radio button.',

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
	'DbTable'					=> 'Table',
	'DbRecords'					=> 'Records',
	'DbSize'					=> 'Tamanho',
	'DbIndex'					=> 'Index',
	'DbOverhead'				=> 'Overhead',
	'DbTotal'					=> 'Total',

	'FileStatSection'			=> 'Estatísticas do sistema de ficheiros',
	'FileFolder'				=> 'Folder',
	'FileFiles'					=> 'Ficheiros',
	'FileSize'					=> 'Tamanho',
	'FileTotal'					=> 'Total',

	// Sysinfo module
	'SysInfo'					=> 'Version information:',
	'SysParameter'				=> 'Parameter',
	'SysValues'					=> 'Values',

	'WackoVersion'				=> 'WackoWiki',
	'LastWackoUpdate'			=> 'Last update',
	'ServerOS'					=> 'OS',
	'ServerName'				=> 'Server name',
	'WebServer'					=> 'Web server',
	'HttpProtocol'				=> 'HTTP Protocol',
	'DbVersion'					=> 'MariaDB / MySQL',
	'SqlModesGlobal'			=> 'SQL Modes Global',
	'SqlModesSession'			=> 'SQL Modes Session',
	'IcuVersion'				=> 'ICU',
	'PhpVersion'				=> 'PHP',
	'MemoryLimit'				=> 'Memory',
	'UploadFilesizeMax'			=> 'Upload max filesize',
	'PostMaxSize'				=> 'Post max size',
	'MaxExecutionTime'			=> 'Max execution time',
	'SessionPath'				=> 'Session path',
	'PhpDefaultCharset'			=> 'PHP default charset',
	'GZipCompression'			=> 'GZip compression',
	'PhpExtensions'				=> 'PHP extensions',
	'ApacheModules'				=> 'Apache modules',

	// DB repair module
	'DbRepairSection'			=> 'Reparar base de dados',
	'DbRepair'					=> 'Reparar base de dados',
	'DbRepairInfo'				=> 'Este script pode procurar automaticamente alguns problemas comuns da base de dados e repará-los. A reparação pode demorar algum tempo, por isso, seja paciente.',

	'DbOptimizeRepairSection'	=> 'Reparar e otimizar a base de dados',
	'DbOptimizeRepair'			=> 'Reparar e otimizar a base de dados',
	'DbOptimizeRepairInfo'		=> 'Este script também pode tentar otimizar a base de dados. Isso melhora o desempenho em algumas situações. Reparar e otimizar a base de dados pode demorar muito tempo e a base de dados será bloqueada durante a otimização.',

	'TableOk'					=> 'The %1 table is okay.',
	'TableNotOk'				=> 'The %1 table is not okay. It is reporting the following error: %2. This script will attempt to repair this table&hellip;',
	'TableRepaired'				=> 'Successfully repaired the %1 table.',
	'TableRepairFailed'			=> 'Failed to repair the %1 table. <br>Error: %2',
	'TableAlreadyOptimized'		=> 'The %1 table is already optimized.',
	'TableOptimized'			=> 'Successfully optimized the %1 table.',
	'TableOptimizeFailed'		=> 'Failed to optimize the %1 table. <br>Error: %2',
	'TableNotRepaired'			=> 'Some database problems could not be repaired.',
	'RepairsComplete'			=> 'Repairs complete',

	// Inconsistencies module
	'InconsistenciesInfo'		=> 'Show and fix inconsistencies, delete or assign orphaned records to a new user / value.',
	'Inconsistencies'			=> 'Inconsistências',
	'CheckDatabase'				=> 'Base de dados',
	'CheckDatabaseInfo'			=> 'Checks for record inconsistencies in the database.',
	'CheckFiles'				=> 'Ficheiros',
	'CheckFilesInfo'			=> 'Checks for abandoned files, files with no reference left in the file table.',
	'Records'					=> 'Records',
	'InconsistenciesNone'		=> 'No Data Inconsistencies found.',
	'InconsistenciesDone'		=> 'Data Inconsistencies solved.',
	'InconsistenciesRemoved'	=> 'Removed inconsistencies',
	'Check'						=> 'Check',
	'Solve'						=> 'Solve',

	// Bad Behaviour module
	'BbInfo'					=> 'Detects and blocks unwanted web accesses, deny automated spambots access.<br>For more information, please visit the %1 homepage.',
	'BbEnable'					=> 'Enable Bad Behaviour:',
	'BbEnableInfo'				=> 'All other settings can be changed in the config folder %1.',
	'BbStats'					=> 'Bad Behaviour has blocked %1 access attempts in the last 7 days.',

	'BbSummary'					=> 'Summary',
	'BbLog'						=> 'Log',
	'BbSettings'				=> 'Configurações',
	'BbWhitelist'				=> 'Whitelist',

	// --> Log
	'BbHits'					=> 'Hits',
	'BbRecordsFiltered'			=> 'Displaying %1 of %2 records filtered by',
	'BbStatus'					=> 'Status',
	'BbBlocked'					=> 'Blocked',
	'BbPermitted'				=> 'Permitted',
	'BbIp'						=> 'IP',
	'BbGetPost'					=> 'GET/POST',
	'BbUri'						=> 'URI',
	'BbRecordsAll'				=> 'Displaying all %1 records',
	'BbShow'					=> 'Show',
	'BbIpDateStatus'			=> 'IP/Date/Status',
	'BbHeaders'					=> 'Headers',
	'BbEntity'					=> 'Entity',

	// --> Whitelist
	'BbOptionsSaved'			=> 'Options saved.',
	'BbWhitelistHint'			=> 'Inappropriate whitelisting WILL expose you to spam, or cause Bad Behaviour to stop functioning entirely! DO NOT WHITELIST unless you are 100% CERTAIN that you should.',
	'BbIpAddress'				=> 'IP Address',
	'BbIpAddressInfo'			=> 'IP address or CIDR format address ranges to be whitelisted (one per line)',
	'BbUrl'						=> 'URL',
	'BbUrlInfo'					=> 'URL fragments beginning with the / after your web site hostname (one per line)',
	'BbUserAgent'				=> 'User Agent',
	'BbUserAgentInfo'			=> 'User agent strings to be whitelisted (one per line)',

	// --> Settings
	'BbSettingsUpdated'			=> 'Updated Bad Behaviour settings',
	'BbLogRequest'				=> 'Logging HTTP request',
	'BbLogVerbose'				=> 'Verbose',
	'BbLogNormal'				=> 'Normal (recommended)',
	'BbLogOff'					=> 'Do not log (not recommended)',
	'BbSecurity'				=> 'Segurança',
	'BbStrict'					=> 'Strict checking',
	'BbStrictInfo'				=> 'blocks more spam but may block some people',
	'BbOffsiteForms'			=> 'Allow form postings from other web sites',
	'BbOffsiteFormsInfo'		=> 'required for OpenID; increases spam received',
	'BbHttpbl'					=> 'http:BL',
	'BbHttpblInfo'				=> 'To use Bad Behaviour\'s http:BL features you must have an %1',
	'BbHttpblKey'				=> 'http:BL Access Key',
	'BbHttpblThreat'			=> 'Minimum Threat Level (25 is recommended)',
	'BbHttpblMaxage'			=> 'Maximum Age of Data (30 is recommended)',
	'BbReverseProxy'			=> 'Reverse Proxy/Load Balancer',
	'BbReverseProxyInfo'		=> 'If you are using Bad Behaviour behind a reverse proxy, load balancer, HTTP accelerator, content cache or similar technology, enable the Reverse Proxy option.<br>' .
									'If you have a chain of two or more reverse proxies between your server and the public Internet, you must specify <em>all</em> of the IP address ranges (in CIDR format) of all of your proxy servers, load balancers, etc. Otherwise, Bad Behaviour may be unable to determine the client\'s true IP address.<br>' .
									'In addition, your reverse proxy servers must set the IP address of the Internet client from which they received the request in an HTTP header. If you don\'t specify a header, %1 will be used. Most proxy servers already support X-Forwarded-For and you would then only need to ensure that it is enabled on your proxy servers. Some other header names in common use include %2 and %3.',
	'BbReverseProxyEnable'		=> 'Enable Reverse Proxy',
	'BbReverseProxyHeader'		=> 'Header containing Internet clients IP address',
	'BbReverseProxyAddresses'	=> 'IP address or CIDR format address ranges for your proxy servers (one per line)',

];
