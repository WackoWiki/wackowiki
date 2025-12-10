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

			$nodes .= "\t" . '<input type="hidden" name="config[' . $key . ']" value="' . $value . '">' . "\n";
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

	return '<img src="' . $base_path . 'image/spacer.png" width="20" height="20" alt="' . $text . '" title="' . $text . '" class="tickcross ' . ($ok ? 'tick' : 'cross') . '">';
}

// TODO: same function as in wacko class
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

	#Ut::debug_print_r($x);

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
function test($text, $condition, $error_text = ''): bool
{
	echo '<li>' . $text . '   ' . output_image($condition);

	if (!$condition)
	{
		if ($error_text)
		{
			output_error($error_text);
		}

		echo '</li>' . "\n";
		return false;
	}

	echo '</li>' . "\n";
	return true;
}

function test_mysqli($text, $query, $error_text = '')
{
	global $dblink;

	try
	{
		test($text, @mysqli_query($dblink, $query), $error_text);
	}
	catch (mysqli_sql_exception $e)
	{
		test($text, false, $error_text . '<br>' . $e->getMessage());
	}
}

function test_sqlite($text, $query, $error_text = '')
{
	global $dblink;

	try
	{
		test($text, $dblink->exec($query), $error_text);
	}
	catch (Exception $e)
	{
		test($text, false, $error_text . '<br>' . $e->getMessage() . ' ' . $dblink->lastErrorMsg() . ' -> ' . $query);
	}
}

function test_pdo($text, $query, $error_text = '')
{
	global $dblink;

	try
	{
		test($text, $dblink->exec($query), $error_text);
	}
	catch (PDOException $e)
	{
		test($text, false, $error_text . '<br>' . $e->getCode() . ': (' . $e->getMessage() . ': ' . $dblink->errorInfo() . ')');
	}
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
function array_to_str ($arr, $name = ''): string
{
	$entries	= '';
	$arrays		= '';

	$str = "\$wacko_config" . ($name ? "[\"" . $name . "\"]" : "") . " = [\n";

	foreach ($arr as $k => $v)
	{
		if (is_array($v))
		{
			$arrays .= array_to_str($v, $k);
		}
		else
		{
			$entries .= "\t'" . $k . '\' => \'' . str_replace("\n", "\\n", $v) . "',\n";
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
	if (!preg_match("~^[^\\0]*\\.(db|sdb|sqlite)\$~", $name))
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
			return [false, Ut::perc_replace(_t('SqliteDirUnwritable'), $dir)];
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
				$dir,
				dirname($dir),
				basename($dir),
				$webserver_group)];
		}

		return [false, Ut::perc_replace(
			_t('SqliteParentUnwritableNogroup'),
			$dir,
			dirname($dir),
			basename($dir))];
	}

	return [true, ''];
}

function create_db_file(string $file): array
{
	if (file_exists($file))
	{
		if (!is_writable($file))
		{
			return [false, Ut::perc_replace(_t('SqliteReadonly'), $file)];
		}

		return [true, ''];
	}

	$old_mask = umask(0177);

	if (file_put_contents($file, '') === false)
	{
		umask($old_mask);

		return [false, Ut::perc_replace(_t('SqliteCantCreateDb'), $file)];
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
			return [false, Ut::perc_replace(_t('SqliteMkdirError'), $dir)];
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
	$data = base64_decode($value);

	if (!$data)
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

