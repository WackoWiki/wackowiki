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
function output_image($ok)
{
	global $lang, $base_path;

	$text = $ok ? $lang['OK'] : $lang['Problem'];

	return '<img src="' . $base_path . 'image/spacer.png" width="20" height="20" alt="' . $text . '" title="' . $text . '" class="tickcross ' . ($ok ? 'tick' : 'cross') . '">';
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
	catch (Exception $e)
	{
		test($text, false, $error_text);
	}
}

function test_pdo($text, $query, $error_text = '')
{
	global $dblink;

	try
	{
		test($text, $dblink->query($query), $error_text);
	}
	catch (PDOException $e)
	{
		test($text, false, $error_text . '<br>' . $e->getMessage());
	}
	catch (Exception $e)
	{
		test($text, false, $error_text);
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
	global $config_global, $dblink_global;

	switch ($config_global['db_driver'])
	{
		case 'mysqli_legacy':

			return mysqli_real_escape_string($dblink_global, $string);

		default:
		// return $dblink->quote($string);

		return strtr($string, [
			"\x00"	=> '\x00',
			"\n"	=> '\n',
			"\r"	=> '\r',
			'\\'	=> '\\\\',
			"'"		=> "\'",
			'"'		=> '\"',
			"\x1a"	=> '\x1a'
		]);
	}
}
