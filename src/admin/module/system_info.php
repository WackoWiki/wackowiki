<?php

if (!defined('IN_WACKO'))
{
	exit;
}

##########################################################
##	System Information									##
##########################################################

$module['system_info'] = [
		'order'	=> 130,
		'cat'	=> 'basics',
		'status'=> true,
	];

##########################################################

function admin_system_info(&$engine, $module)
{
?>
	<h1><?php echo $engine->_t($module)['title']; ?></h1>
	<br>
	<?php echo $engine->_t('SysInfo');?><br>
	<br>
	<table class="sysinfo formation lined">
		<tr>
			<th><?php echo $engine->_t('SysParameter');?></th>
			<th><?php echo $engine->_t('SysValues');?></th>
		</tr>
<?php

	// get TLS mode			-> https://httpd.apache.org/docs/2.4/mod/mod_ssl.html#envvars
	$tls_mode				= (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'
									? $engine->_t('On') .
										(isset($_SERVER['SSL_PROTOCOL'])
											? ', '. $_SERVER['SSL_PROTOCOL'] . ' (' . ($_SERVER['SSL_CIPHER'] ?? '') . ')'
											: '')
									: $engine->_t('Off')
								);

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

	// PHP session.save_path
	$session_save_path		= current(array_reverse(explode(';', ini_get('session.save_path'))));

	// check if gzip compression is enabled // @extension_loaded('zlib')
	$gzip_compression		= (function_exists('ob_gzhandler') || ini_get('zlib.output_compression') ? $engine->_t('On') : $engine->_t('Off'));

	$memory					= trim(str_replace('M', '', ini_get('memory_limit')));

	// fallback if ini_get doesn't work
	if (intval($memory) == 0)
	{
		$memory = trim(str_replace('M', '', get_cfg_var('memory_limit')));
	}

	// Sysinfo in array
	$sysinfo['app_version']			= [$engine->_t('WackoVersion'), $engine->db->wacko_version];
	$sysinfo['app_updated']			= [$engine->_t('LastWackoUpdate'), $engine->sql2precisetime($engine->db->maint_last_update)];
	$sysinfo['os']					= [$engine->_t('ServerOS'), PHP_OS . ' (' . @php_uname() . ')'];
	$sysinfo['server_name']			= [$engine->_t('ServerName'), $_SERVER['SERVER_NAME']];
	$sysinfo['server_software']		= [$engine->_t('WebServer'), $_SERVER['SERVER_SOFTWARE']];
	$sysinfo['server_protocol']		= [$engine->_t('HttpProtocol'), $_SERVER['SERVER_PROTOCOL']];
	$sysinfo['tls_mode']			= [$engine->_t('TrafficProtection'), $tls_mode];
	$sysinfo['db_version']			= [$engine->_t('DbVersion'), $db_version];
	$sysinfo['sql_mode_global']		= [$engine->_t('SqlModesGlobal'), wordwrap($sql_mode_global, 80, "\n", true)];
	$sysinfo['sql_mode_session']	= [$engine->_t('SqlModesSession'), wordwrap($sql_mode_session, 80, "\n", true)];
	$sysinfo['icu_version']			= [$engine->_t('IcuVersion'), INTL_ICU_VERSION];
	$sysinfo['php_version']			= [$engine->_t('PhpVersion'), PHP_VERSION];
	$sysinfo['memory']				= [$engine->_t('MemoryLimit'), $engine->binary_multiples($memory * 1024 * 1024, false, true, true)];
	$sysinfo['upload_max_filesize']	= [$engine->_t('UploadFilesizeMax'), $engine->binary_multiples($upload_max_filesize * 1024 * 1024, false, true, true)];
	$sysinfo['post_max_size']		= [$engine->_t('PostMaxSize'), $engine->binary_multiples($post_max_size * 1024 * 1024, false, true, true)];
	$sysinfo['max_execution_time']	= [$engine->_t('MaxExecutionTime'), get_cfg_var('max_execution_time') . ' seconds'];
	$sysinfo['session_save_path']	= [$engine->_t('SessionPath'), CACHE_SESSION_DIR . ' (PHP default: ' . $session_save_path . ')'];
	$sysinfo['default_charset']		= [$engine->_t('PhpDefaultCharset'), ini_get('default_charset')];
	$sysinfo['gzip_compression']	= [$engine->_t('GZipCompression'), $gzip_compression];
	$sysinfo['php_extensions']		= [$engine->_t('PhpExtensions'), implode(', ',get_loaded_extensions())];

	if ( function_exists( 'apache_get_modules' ) )
	{
		$sysinfo['apache_modules']		= [$engine->_t('ApacheModules'), implode(', ',apache_get_modules())];
	}

	foreach ($sysinfo as $value)
	{
		echo
			'<tr>' .
				'<td class="label"><strong>' . $value[0] . '</strong></td>' .
				'<td>' . $value[1] . '</td>' .
			'</tr>' . "\n";
	}
?>
	</table>

<?php

	# Ut::debug_print_r(ini_get_all());

	/* if ($action == 'phpinfo')
	{
		// output phpinfo

		phpinfo();

		exit();
	} */
}
