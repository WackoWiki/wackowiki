<?php

// setup header
function my_location()
{
	global $config;

	// run in tls mode?
	if ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
		|| (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443')
	)
	{
		$config['base_url'] =	str_replace('http://', 'https://', $config['base_url']);
	}

	[$url, ] = explode('?', $config['base_url']);

	return $url;
}

// setup header
function write_config_hidden_nodes($config_parameters)
{
	if (is_array($config_parameters))
	{
		foreach ($config_parameters as $key => $value)
		{
			if (is_array($value))
			{
				$value = implode(',', $value);
			}

			echo "\t" . '<input type="hidden" name="config[' . $key . ']" value="' . $value . '">' . "\n";
		}
	}
}

function output_error($error_text = '')
{
	echo '<ul class="install_error"><li>' . $error_text . '</li></ul>' . "\n";
}

// Draws a tick or cross next to a result
function output_image($ok)
{
	global $lang;

	return '<img src="' . my_location() . 'setup/image/spacer.png" width="20" height="20" alt="' . ($ok ? $lang['OK'] : $lang['Problem']) . '" title="' . ($ok ? $lang['OK'] : $lang['Problem']) . '" class="tickcross ' . ($ok ? 'tick' : 'cross') . '">';
}

// TODO: same function as in wacko class
// site config
function available_languages()
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
function test($text, $condition, $error_text = '')
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

function test_mysqli($text, $query, $errorText = '')
{
	global $dblink;

	try
	{
		test($text, @mysqli_query($dblink, $query), $errorText);
	}
	catch (mysqli_sql_exception $e)
	{
		test($text, false, $errorText . '<br>' . $e->getMessage());
	}
	catch (Exception $e)
	{
		test($text, false, $errorText);
	}
}

function test_pdo($text, $query, $errorText = '')
{
	global $dblink;

	try
	{
		test($text, $dblink->query($query), $errorText);
	}
	catch (PDOException $e)
	{
		test($text, false, $errorText . '<br>' . $e->getMessage());
	}
	catch (Exception $e)
	{
		test($text, false, $errorText);
	}
}

// write config
function array_to_str ($arr, $name = '')
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

// TODO: same function as in dbpdo class
// default: mysql_pdo -> Manually string quoting since pdo::quote is double escaping single quotes which is causing chaos
function _q($string)
{
	$string ??= '';
	global $config_global, $dblink_global;

	return match ($config_global['db_driver']) {
		'mysqli_legacy'	=> mysqli_real_escape_string($dblink_global, $string),
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
