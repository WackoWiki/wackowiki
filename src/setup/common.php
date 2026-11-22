<?php

// setup header
function write_config_hidden_nodes($config_parameters, $show = true)
{
	if (is_array($config_parameters))
	{
		$nodes = '';

		foreach ($config_parameters as $key => $value)
		{
			if (is_array($value))
			{
				$value = implode(',', $value);
			}

			$nodes .= "\t" . '<input type="hidden" name="config[' . Ut::html((string) $key) . ']" value="' . Ut::html((string) $value) . '">' . "\n";
		}

		if ($show)
		{
			echo $nodes;
		}
		else
		{
			return $nodes;
		}
	}
}

function output_error($error_text = '')
{
	echo '<ul class="install_error"><li>' . $error_text . '</li></ul>' . "\n";
}

// Draws a tick or cross next to a result
function output_image($ok): string
{
	global $base_path;

	$text = $ok ? _t('OK') : _t('Problem');

	return '<img src="' . Ut::html((string) $base_path) . 'image/spacer.png" width="20" height="20" alt="' . Ut::html($text) . '" title="' . Ut::html($text) . '" class="tickcross ' . ($ok ? 'tick' : 'cross') . '">';
}

// negotiate language with user's browser
function user_agent_language()
{
	global $config;
	$lang = $config['language'];

	if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
	{
		$lang_list = available_languages();

		// https://www.rfc-editor.org/rfc/rfc9110.html#section-12.5.4
		preg_match_all('/([[:alpha:]]{1,8})(-([[:alpha:]|-]{1,8}))?' .
			'(\s*;\s*q\s*=\s*(1\.0{0,3}|0\.\d{0,3}))?\s*(,|$)/',
			strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']),
			$matches, PREG_SET_ORDER);

		$best = 0;

		foreach ($matches as $i)
		{
			$want1 = $want2 = $i[1];

			if ($i[3])
			{
				$want2 = $want1 . '-' . $i[3];
			}

			$q = ($i[5] !== '')? (float)$i[5] : 1;

			if (in_array($want2, $lang_list) && $q > $best)
			{
				$lang = $want2;
				$best = $q;
			}
			else if (in_array($want1, $lang_list) && $q * 0.9 > $best)
			{
				$lang = $want1;
				$best = $q * 0.9;
			}
		}
	}

	return $lang;
}

// TODO: similar function in Http class
// site config
function available_languages(): array
{
	$lang_list = [];

	if ($handle = opendir('lang'))
	{
		while (false !== ($file = readdir($handle)))
		{
			if (   $file != '.'
				&& $file != '..'
				&& $file != 'wacko.all.php'
				&& !is_dir('lang/' . $file)
				&& 1 == preg_match('/^wacko\.(.*?)\.php$/', $file, $match))
			{
				$lang_list[] = $match[1];
			}
		}

		closedir($handle);
	}

	sort($lang_list, SORT_STRING);

	return $lang_list;
}

function set_language($iso): array
{
	require_once 'setup/lang/installer.all.php';

	// The language file name is built from $iso - never allow path separators
	// or any other unexpected characters here.
	if (!is_string($iso) || !preg_match('/^[a-z]{2}(-[a-z]{2})?$/', $iso))
	{
		$iso = 'en';
	}

	if ($iso == 'en')
	{
		require_once 'setup/lang/installer.en.php';
		$x[$iso] = array_merge ($lang, $lang_all);
	}
	else
	{
		require_once 'setup/lang/installer.' . $iso . '.php';
		$x[$iso] = array_merge ($lang, $lang_all);

		require_once 'setup/lang/installer.en.php';
		$x['en'] = array_merge ($lang, $lang_all);
	}

	return $x;
}

function _t($name): array|string
{
	global $config, $translation;
	$lang = $config['language'];

	if (isset($translation[$lang][$name]))
	{
		return $translation[$lang][$name];
	}

	// fall back to English
	if ($lang != 'en')
	{
		if (isset($translation['en'][$name]))
		{
			return $translation['en'][$name];
		}
	}

	return '';
}

// TODO: same function as in wacko class
function sanitize_page_tag(&$tag, $normalize = false)
{
	if (!$tag)
	{
		return;
	}

	// normalizing tag name
	$tag = Ut::normalize($tag);

	// remove invalid characters
	$tag = preg_replace('/[^\p{L}\p{M}\p{Nd}\.\-\/]/u', '', $tag);

	// remove starting/trailing slashes, spaces, and minimize multi-slashes
	$tag = preg_replace_callback('#^/+|/+$|(/{2,})|\s+#u',
		function ($x)
		{
			return @$x[1]? '/' : '';
		}, $tag);

	$cluster = [];

	// parent-tags (cluster recursive)
	foreach (explode('/', $tag) as $string)
	{
		// strip full stop and hyphen-minus from the beginning and end of the string
		$string = utf8_trim($string, '.-');

		// remove multi full stop and hyphen-minus
		$string = preg_replace('/(-{2,})/u', '-', $string);
		$string = preg_replace('/(\.{2,})/u', '.', $string);

		// remove consecutive occurences (.- / -.)
		$string = str_replace(['.-', '-.'], '', $string);

		if ($string)
		{
			$cluster[] = $string;
		}
	}

	$tag = implode('/', $cluster);
}

// database install

// Send installer output immediately. The request buffer otherwise holds
// every line until the script ends, so a hung statement looks like a stall
// on the previous successful check.
function install_stream(): void
{
	@ini_set('zlib.output_compression', '0');
	@ini_set('implicit_flush', '1');
	ob_implicit_flush(true);

	while (ob_get_level() > 0)
	{
		@ob_end_flush();
	}

	// Pad past common proxy / SAPI buffers so the first lines are delivered.
	echo "\n<!--" . str_repeat(' ', 4096) . "-->\n";
	@flush();
}

function install_flush(): void
{
	@flush();
}

function install_step(string $label): void
{
	$GLOBALS['install_step'] = $label;
}

function install_escape(string $text): string
{
	return Ut::html($text);
}

function install_label(string $key, string $fallback): string
{
	$text = _t($key);

	return $text !== '' ? $text : $fallback;
}

function install_sql_excerpt(string $query): string
{
	$query = preg_replace('/\s+/', ' ', trim($query)) ?? '';

	if (strlen($query) > 300)
	{
		$query = substr($query, 0, 300) . '...';
	}

	return install_escape($query);
}

// Text of the last driver error, or '' when the driver has nothing to say.
function install_driver_detail(): string
{
	global $config, $dblink;

	if (!isset($dblink) || !$dblink)
	{
		return '';
	}

	$raw = '';

	switch ($config['db_driver'] ?? '')
	{
		case 'mysqli':
			if (mysqli_errno($dblink))
			{
				$raw = mysqli_errno($dblink) . ': ' . mysqli_error($dblink);
			}
			break;

		case 'sqlite':
			if ($dblink->lastErrorCode())
			{
				$raw = $dblink->lastErrorCode() . ': ' . $dblink->lastErrorMsg();
			}
			break;

		default:
			if (!method_exists($dblink, 'errorInfo'))
			{
				break;
			}

			$info = $dblink->errorInfo();

			if (is_array($info) && ($info[0] ?? '00000') !== '00000' && ($info[0] ?? '') !== '')
			{
				$raw = trim(($info[0] ?? '') . ' ' . ($info[1] ?? '') . ' ' . ($info[2] ?? ''));
			}
			break;
	}

	return $raw === '' ? '' : install_escape($raw);
}

function install_report(string $message): void
{
	$GLOBALS['fatal_error']		= true;
	$GLOBALS['install_failure_reported'] = true;

	$step	= trim(strip_tags((string) ($GLOBALS['install_step'] ?? '')));
	$where	= $step !== '' ? '<br>' . install_escape($step) : '';

	output_error(
		'<strong>' . install_label('InstallAborted', 'Installation stopped because of an unexpected error.') . '</strong><br>'
		. nl2br(install_escape($message), false)
		. $where
	);
	install_flush();
}

function install_guard(): void
{
	register_shutdown_function(static function () {
		if (!empty($GLOBALS['install_failure_reported']))
		{
			return;
		}

		$err = error_get_last();

		if (!$err)
		{
			return;
		}

		$fatal = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR, E_RECOVERABLE_ERROR];

		if (!in_array($err['type'], $fatal, true))
		{
			return;
		}

		install_report($err['message'] . ' in ' . $err['file'] . ':' . $err['line']);
		echo '<button type="button" class="next" data-action="back">' . _t('Back') . '</button>' . "\n";
		echo '<button type="button" class="next" data-action="reload">' . _t('TryAgain') . '</button>' . "\n";
		install_flush();
	});
}

// Metadata locks default to about a year. A stuck DDL then hangs this page
// with no further output. Fail the statement instead and let the caller print why.
function install_fail_fast_locks(): void
{
	global $config, $dblink;

	if (in_array($config['db_driver'], ['sqlite', 'sqlite_pdo'], true))
	{
		if ($config['db_driver'] === 'sqlite' && $dblink instanceof SQLite3)
		{
			$dblink->busyTimeout(15000);
		}
		else if ($dblink instanceof PDO)
		{
			$dblink->setAttribute(PDO::ATTR_TIMEOUT, 15);
		}

		return;
	}

	foreach ([
		'SET SESSION lock_wait_timeout = 15',
		'SET SESSION innodb_lock_wait_timeout = 15',
	] as $sql)
	{
		try
		{
			if ($config['db_driver'] === 'mysqli')
			{
				mysqli_query($dblink, $sql);
			}
			else if ($dblink instanceof PDO)
			{
				$dblink->query($sql);
			}
		}
		catch (Throwable $e)
		{
			// This server has no such session variable. The statement that
			// actually fails is still reported to the user.
		}
	}
}

function test($text, $condition, $error_text = ''): bool
{
	install_step(trim(strip_tags((string) $text)));
	echo '<li>' . $text . '   ' . output_image($condition);

	if (!$condition)
	{
		if ($error_text)
		{
			$detail = install_driver_detail();
			output_error($error_text . ($detail !== '' ? '<br>' . $detail : ''));
		}

		echo '</li>' . "\n";
		install_flush();
		return false;
	}

	echo '</li>' . "\n";
	install_flush();
	return true;
}

function install_run_statement(string $text, string $query, string $error_text, callable $run): void
{
	install_step(trim(strip_tags($text)));
	echo '<li>' . $text . '   ';
	install_flush();

	try
	{
		// PDO::exec() returns 0 when a statement succeeds without changing rows.
		// Only an actual false is a failure.
		$ok = $run() !== false;
		echo output_image($ok);

		if (!$ok && $error_text)
		{
			$detail = install_driver_detail();
			output_error($error_text
				. ($detail !== '' ? '<br>' . $detail : '')
				. '<br><code>' . install_sql_excerpt($query) . '</code>');
		}
	}
	catch (Throwable $e)
	{
		echo output_image(false);
		output_error($error_text
			. '<br>' . install_escape($e->getMessage() . ($e->getCode() ? ' (' . $e->getCode() . ')' : ''))
			. '<br><code>' . install_sql_excerpt($query) . '</code>');
	}

	echo '</li>' . "\n";
	install_flush();
}

function test_mysqli($text, $query, $error_text = '')
{
	global $dblink;

	install_run_statement($text, (string) $query, (string) $error_text,
		static fn () => mysqli_query($dblink, $query));
}

function test_sqlite($text, $query, $error_text = '')
{
	global $dblink;

	install_run_statement($text, (string) $query, (string) $error_text,
		static fn () => $dblink->exec($query));
}

function test_pdo($text, $query, $error_text = '')
{
	global $dblink;

	install_run_statement($text, (string) $query, (string) $error_text,
		static fn () => $dblink->exec($query));
}

// default: mysql_pdo -> Manually string quoting since pdo::quote is double escaping single quotes which is causing chaos
function _q($string): string
{
	$string ??= '';
	global $config_global, $dblink_global;

	return match ($config_global['db_driver']) {
		'mysqli'		=> mysqli_real_escape_string($dblink_global, $string),
		'sqlite'		=> $dblink_global->escapeString($string),
		'sqlite_pdo'	=> strtr((string) $string, [
			"'"		=> "''",
		]),
		default			=> strtr($string, [
			"\x00"	=> '\x00',
			"\n"	=> '\n',
			"\r"	=> '\r',
			'\\'	=> '\\\\',
			"'"		=> "\'",
			'"'		=> '\"',
			"\x1a"	=> '\x1a'
		]),
	};
}

// write config
function array_to_str(array $arr, string $name = ''): string
{
	$entries	= '';
	$arrays		= '';

	$str = '$wacko_config' .
			($name !== '' ? '[' . var_export((string) $name, true) . ']' : '') .
			" = [\n";

	foreach ($arr as $k => $v)
	{
		if (is_array($v))
		{
			$arrays .= array_to_str($v, (string) $k);
		}
		else
		{
			if (is_object($v) || is_resource($v))
			{
				throw new InvalidArgumentException('Unsupported config value type: ' . gettype($v));
			}

			$entries .= "\t" . var_export((string) $k, true) .
						' => ' . var_export($v, true) . ",\n";
		}
	}

	$str .= $entries . "];\n";
	$str .= $arrays;

	return $str;
}

// TODO: same functions as in dbpdo class
function utc_dt(): string
{
	global $config_global;

	return match ($config_global['db_driver'])
	{
		'sqlite', 'sqlite_pdo'	=> "datetime('now')",
		default					=> "UTC_TIMESTAMP()",
	};
}

/**
 * SQLite functions
 */

function check_sqlite_name($name): bool
{
	if (!is_string($name) || !preg_match('~\A[^\x00]*\.(?:db|sdb|sqlite)\z~', $name))
	{
		return false;
	}

	return true;
}

function check_data_dir($dir): array
{
	if (is_dir($dir))
	{
		if (!is_readable($dir) || !is_writable($dir))
		{
			return [false, Ut::perc_replace(_t('SqliteDirUnwritable'), Ut::html($dir))];
		}
	}
	else if (!is_writable(dirname($dir)))
	{
		// Check the parent directory if $dir not exists
		$webserver_group = get_webserver_primary_group();

		if ($webserver_group !== null)
		{
			return [false, Ut::perc_replace(
				_t('SqliteParentUnwritableGroup'),
				Ut::html($dir),
				Ut::html(dirname($dir)),
				Ut::html(basename($dir)),
				Ut::html($webserver_group))];
		}

		return [false, Ut::perc_replace(
			_t('SqliteParentUnwritableNogroup'),
			Ut::html($dir),
			Ut::html(dirname($dir)),
			Ut::html(basename($dir)))];
	}

	return [true, ''];
}

function create_db_file(string $file): array
{
	if (file_exists($file))
	{
		if (!is_writable($file))
		{
			return [false, Ut::perc_replace(_t('SqliteReadonly'), Ut::html($file))];
		}

		return [true, ''];
	}

	$old_mask = umask(0177);

	if (file_put_contents($file, '') === false)
	{
		umask($old_mask);

		return [false, Ut::perc_replace(_t('SqliteCantCreateDb'), Ut::html($file))];
	}

	umask($old_mask);

	return [true, ''];
}

function create_data_dir($dir): array
{
	if (!is_dir($dir))
	{
		$ok = @mkdir($dir, 0700, true);

		if (!$ok)
		{
			return [false, Ut::perc_replace(_t('SqliteMkdirError'), Ut::html($dir))];
		}
	}

	// put a .htaccess file
	file_put_contents("$dir/.htaccess",
		"Require all denied\n" .
		"Satisfy All\n");

	return [true, ''];
}

// On POSIX systems return the primary group of the webserver the program is running under.
function get_webserver_primary_group(): ?string
{
	if (!function_exists('posix_getegid') || !function_exists('posix_getpwuid'))
	{
		return null;
	}

	$gid = posix_getegid();

	return posix_getpwuid($gid)['name'] ?? null;
}

function select_sqlite_db_path(): array
{
	/*
	 Suggest alternative SQLite data directory locations

	 [0]   :  custom data directory (DATA_DIR)
	 [1]   :  web root parent/data/
	 [2]   :  OS-specific safe fallbacks outside project
	 [3]   :  non-public directory inside project (but not in web root)
	 [4]   :  fallback parent directory
	 */

	// [0] set default for SQLite
	$db_path[] = Ut::join_path(DATA_DIR, SQLITE_DB_FILE);

	if ($_SERVER['DOCUMENT_ROOT'])
	{
		// [1] web root parent/data/
		$db_path[] = Ut::join_path(dirname($_SERVER['DOCUMENT_ROOT']), 'data', SQLITE_DB_FILE);
	}

	// [2] OS-specific safe fallbacks outside project
	$db_path[] = match (PHP_OS_FAMILY)
	{
		'Windows'	=> Ut::join_path(getenv('APPDATA'),	APP_NAME,SQLITE_DB_FILE),
		'Linux'		=> Ut::join_path('/var/lib',		APP_NAME,SQLITE_DB_FILE),
		'Darwin'	=> Ut::join_path('/Users/Shared',	APP_NAME,SQLITE_DB_FILE),
	};

	$web_roots		= ['public', 'public_html', 'www', 'web', 'htdocs'];
	$root_basename	= basename(__DIR__);

	// [3] real project root (one level above web root)
	if (in_array($root_basename, $web_roots))
	{
		$parent_dir	= dirname(__DIR__);
		$db_path[]	= Ut::join_path($parent_dir, 'data', SQLITE_DB_FILE);
	}

	// [4] fallback parent directory
	$db_path[] = Ut::join_path(dirname(__DIR__, 2), 'data', SQLITE_DB_FILE);

	return $db_path;
}

function generate_secure_token($secret): string
{
	$expires_in		= 600;
	$time			= time();
	$expires		= $time + $expires_in;
	$token			= bin2hex(random_bytes(32));

	// Create payload: time|expires|token
	$payload = "$time|$expires|$token";

	// Create HMAC signature to prevent tampering
	$hmac = hash_hmac('sha256', $payload, $secret);

	// Combine payload and signature
	return base64_encode($payload . '|' . $hmac);
}

function validate_token($value, $secret)
{
	$data = base64_decode((string) $value, true);

	if ($data === false || $data === '')
	{
		return false;
	}

	$parts = explode('|', $data);

	if (count($parts) !== 4)
	{
		return false;
	}

	[$time, $expires, $token, $received_hmac] = $parts;

	// Re-calculate HMAC
	$expected_payload	= "$time|$expires|$token";
	$expected_hmac		= hash_hmac('sha256', $expected_payload, $secret);

	// Use hash_equals for timing attack resistance
	if (!hash_equals($expected_hmac, $received_hmac))
	{
		return false; // Tampering detected
	}

	// Check expiration
	if (time() > (int) $expires)
	{
		return false; // Token expired
	}

	return [
		'issued_at'		=> (int) $time,
		'expires_at'	=> (int) $expires,
		'token'			=> $token
	];
}

function empty_file($file_name)
{
	if (file_exists($file_name))
	{
		$content = trim(file_get_contents($file_name));

		if (empty($content))
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return true;
	}
}

