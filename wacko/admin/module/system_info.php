<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	System Information									##
##########################################################
$_mode = 'system_info';

$module[$_mode] = [
		'order'	=> 130,
		'cat'	=> 'basics',
		'status'=> true,
		'mode'	=> $_mode,
		'name'	=> $engine->_t($_mode)['name'],		// System Info
		'title'	=> $engine->_t($_mode)['title'],	// System Information
	];

##########################################################

function admin_system_info(&$engine, &$module)
{
?>
	<h1><?php echo $module['title']; ?></h1>
	<br>
	<?php echo $engine->_t('SysInfo');?>:<br>
	<br>
	<table style="max-width:800px; border-spacing: 1px; border-collapse: separate; padding: 4px;" class="formation lined">
		<tr>
			<th style="width:120px;"><?php echo $engine->_t('SysParameter');?></th>
			<th class="t-left"></th>
			<th class="t-left"><?php echo $engine->_t('SysValues');?></th>
		</tr>
<?php

	// get MariaDB / mysql version
	$_db_version			= $engine->db->load_single("SELECT version()");
	$db_version				= $_db_version['version()'];

	// get SQL mode
	$_sql_mode				= $engine->db->load_single("SELECT @@GLOBAL.sql_mode, @@SESSION.sql_mode");
	$sql_mode_global		= $_sql_mode['@@GLOBAL.sql_mode'];
	$sql_mode_session		= $_sql_mode['@@SESSION.sql_mode'];

	// get_cfg_var()		-> returns whatever is in php.ini
	// ini_get()			-> returns runtime settings
	$upload_max_filesize	= trim(str_replace('M', '', get_cfg_var('upload_max_filesize')));
	$post_max_size			= trim(str_replace('M', '', get_cfg_var('post_max_size')));

	// check if gzip compression is enabled // @extension_loaded('zlib')
	if (function_exists('ob_gzhandler') || ini_get('zlib.output_compression'))
	{
		$gzip_compression = $engine->_t('On');
	}
	else
	{
		$gzip_compression = $engine->_t('Off');
	}

	$memory = trim(str_replace('M', '', ini_get('memory_limit')));

	// fallback if ini_get doesn't work
	if (intval($memory) == 0)
	{
		$memory = trim(str_replace('M', '', get_cfg_var('memory_limit')));
	}

	$_php_ram = $memory;

	// Sysinfo in array
	$sysinfo['app_version']			= [$engine->_t('WackoVersion'), $engine->db->wacko_version];
	$sysinfo['app_updated']			= [$engine->_t('LastWackoUpdate'), $engine->db->maint_last_update];
	$sysinfo['os']					= [$engine->_t('ServerOS'), PHP_OS . ' (' . @php_uname() . ')'];
	$sysinfo['server_name']			= [$engine->_t('ServerName'), $_SERVER['SERVER_NAME']];
	$sysinfo['server_software']		= [$engine->_t('WebServer'), $_SERVER['SERVER_SOFTWARE']];
	$sysinfo['server_protocol']		= [$engine->_t('HttpProtocol'), $_SERVER['SERVER_PROTOCOL']];
	$sysinfo['db_version']			= [$engine->_t('DbVersion'), $db_version];
	$sysinfo['sql_mode_global']		= [$engine->_t('SqlModesGlobal'), wordwrap($sql_mode_global, 80, "\n", true)];
	$sysinfo['sql_mode_session']	= [$engine->_t('SqlModesSession'), wordwrap($sql_mode_session, 80, "\n", true)];
	$sysinfo['php_version']			= [$engine->_t('PhpVersion'), PHP_VERSION];
	$sysinfo['memory']				= [$engine->_t('MemoryLimit'), $engine->binary_multiples($_php_ram * 1024 * 1024, false, true, true)];
	$sysinfo['upload_max_filesize']	= [$engine->_t('UploadFilesizeMax'), $engine->binary_multiples($upload_max_filesize * 1024 * 1024, false, true, true)];
	$sysinfo['post_max_size']		= [$engine->_t('PostMaxSize'), $engine->binary_multiples($post_max_size * 1024 * 1024, false, true, true)];
	$sysinfo['max_execution_time']	= [$engine->_t('MaxExecutionTime'), get_cfg_var('max_execution_time') . ' seconds'];
	$sysinfo['session_save_path']	= [$engine->_t('SessionPath'), CACHE_SESSION_DIR];
	$sysinfo['default_charset']		= [$engine->_t('PhpDefaultCharset'), ini_get('default_charset')];
	$sysinfo['gzip_compression']	= [$engine->_t('GZipCompression'), $gzip_compression];
	$sysinfo['php_extensions']		= [$engine->_t('PhpExtensions'), implode(', ',get_loaded_extensions())];

	if ( function_exists( 'apache_get_modules' ) )
	{
		$sysinfo['apache_modules']		= [$engine->_t('ApacheModules'), implode(', ',apache_get_modules())];
	}

	foreach ($sysinfo as $param => $value)
	{
		echo '<tr>' .
				'<td class="label"><strong>' . $value[0] . '</strong></td>' .
				'<td> </td>' .
				'<td>' . $value[1] . '</td>' .
			#'<tr class="lined"><td colspan="5"></td></tr>' .
			"\n";
	}
?>
	</table>

<?php

# Ut::debug_print_r(ini_get_all());
/*
if ($action == 'phpinfo')
{
	// output phpinfo

	phpinfo();

	exit();
}*/

}
