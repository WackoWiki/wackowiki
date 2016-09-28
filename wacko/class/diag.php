<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class Diag
{
	function __construct()
	{
		die('Diag is static');
	}

	// DEBUG INFO
	static function full_disclosure(&$config, &$http, &$engine, $cwd)
	{
		chdir($cwd);

		if ($config['debug'] >= 1 && strpos($http->method, '.xml') === false && $http->method != 'print' && $http->method != 'wordprocessor')
		{
			if (($config['debug_admin_only'] == true && $engine->is_admin() === true) || $config['debug_admin_only'] == false)
			{
				$overall_time = microtime(1) - WACKO_STARTED;

				echo '<div id="debug">'.
					 '<p class="debug">Program execution statistics</p>' . "\n<ul>\n";

				// get memory usage
				if(function_exists('memory_get_peak_usage'))
				{
					$execmem = memory_get_peak_usage(true);
				}

				if ($execmem)
				{
					echo "\t<li>Memory allocated: " . $engine->binary_multiples($execmem, false, true, false) . "</li>\n";
				}

				#echo "<li>UTC: " . date('Y-m-d H:i:s', time()) . "</li>\n";
				echo "\t<li>Overall time taken: " . (number_format(($overall_time), 3)) . " sec. </li>\n";

				if ($config['debug'] >= 2)
				{
					echo "\t<li>Execution time: " . number_format($overall_time - $config->query_time, 3) . " sec.</li>\n";
					echo "\t<li>SQL time: " . number_format($config->query_time, 3) . " sec.</li>\n";
				}

				if ($config['debug'] >= 3)
				{
					echo "\t<li>SQL queries: " . count($config->query_log) . "</li>\n";
					echo "\t<li>SQL queries dump follows" .
							($config['debug_sql_threshold'] > 0
								? ' (&gt;' . $config['debug_sql_threshold'] . ' sec.)'
								: '') .
						":\n\t\t<ol>\n";

					foreach ($config->query_log as $one)
					{
						list ($query, $time, $affected_rows, $backtrace) = $one;

						if ($time < $config['debug_sql_threshold'])
						{
							continue;
						}

						$bt = explode(' -> ', $backtrace);

						foreach ($bt as $i => &$one)
						{
							if (preg_match('/load_single|load_all|sql_query/', $one))
							{
								$bt = array_slice($bt, 0, $i);
								break;
							}
						}

						$bt = array_reverse($bt);

						if (count($bt) & 1)
						{
							$bt[] = '';
						}

						$btext = '';

						foreach (array_chunk($bt, 2) as &$one)
						{
							list ($fname, $func) = $one;
							$btext .= '<tr><td>' . $func . '&nbsp;</td><td>&nbsp;' . $fname . '</td></tr>';
						}

						echo "\t";
						echo '<li class="sqllog">';
						echo str_replace(['<', '>'], ['&lt;', '&gt;'], $query) . '<br />';
						echo '[' . number_format($time, 4) . ' sec., ' . $affected_rows . ' rows';
						echo '<span class="backtrace">';
						echo '<table>' . $btext . '</table>';
						echo "</span>]</li>\n";
					}

					echo "\t\t</ol>\n\t</li>\n";
				}
				echo "</ul>\n";

				if ($config['debug'] >= 2)
				{
					$user = $engine->get_user();
					echo '<p class="debug">Language data</p>'."\n<ul>\n";
					echo "\t<li>Multilanguage: " . ($config['multilanguage'] == 1 ? 'true' : 'false') . "</li>\n";
					echo "\t<li>HTTP_ACCEPT_LANGUAGE set: " . (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? 'true' : 'false') . "</li>\n";
					echo "\t<li>HTTP_ACCEPT_LANGUAGE value: " . $_SERVER['HTTP_ACCEPT_LANGUAGE']."</li>\n";
					echo "\t<li>HTTP_ACCEPT_LANGUAGE chopped value: " . strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2)) . "</li>\n";
					echo "\t<li>User language set: " . (isset($user['user_lang']) ? 'true' : 'false') . "</li>\n";
					echo "\t<li>User language value: " . (isset($user['user_lang']) ? $user['user_lang'] : '') . "</li>\n";
					echo "\t<li>Page language: " . $engine->page['page_lang'] ."</li>\n";
					echo "\t<li>Config language: " . $config['language']."</li>\n";
					echo "\t<li>User selected language: " . (isset($engine->user_lang) ? $engine->user_lang : '') . "</li>\n";
					echo "\t<li>Charset: " . $engine->get_charset() . "</li>\n";
					echo "\t<li>HTML Entities Charset: " . HTML_ENTITIES_CHARSET . "</li>\n";
					// echo "\t<li>Disable cache: " . ($engine->disable_cache === true ? 'true' : 'false') . "</li>\n";
					echo "</ul>\n";
				}

				if ($config['debug'] >= 3)
				{
					$query = 'SHOW VARIABLES LIKE "%character_set%";';

					if ($r = $engine->db->load_all($query, true))
					{
						echo "<p class=\"debug\">MySQL character set</p>\n<ul>\n";

						foreach ($r as $k => $charset_item)
						{
							echo "\t<li>" . $charset_item['Variable_name'] . ": " . $charset_item['Value'] . "</li>\n";
						}

						echo "</ul>\n";
					}

					$query = 'SELECT @@GLOBAL.sql_mode, @@SESSION.sql_mode;';

					if ($r = $engine->db->load_single($query, true))
					{
						echo "<p class=\"debug\">SQL mode set</p>\n<ul>\n";
						echo "\t<li>" . 'GLOBAL' . ": " . $r['@@GLOBAL.sql_mode'] . "</li>\n";
						echo "\t<li>" . 'SESSION' . ": " . $r['@@SESSION.sql_mode'] . "</li>\n";
						echo "</ul>\n";
					}
				}

				if ($config['debug'] >= 3)
				{
					echo '<p class="debug">Session data</p>' . "\n<ul>\n";
					echo "\t<li>session_id(): " . $engine->sess->id() . "</li>\n";
					echo "\t<li>Base URL: " . $config['base_url'] . "</li>\n";
					echo "\t<li>HTTPS: " . (isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : '') . "</li>\n";
					echo "\t<li>IP-address: " . $engine->get_user_ip() . "</li>\n";
					echo "\t<li>SERVER_PORT: " . $_SERVER['SERVER_PORT'] . "</li>\n";
					echo "\t<li>TLS: " . (isset($config['tls']) ? 'on' : 'off') . "</li>\n";
					echo "\t<li>TLS Proxy: " . (!empty($config['tls_proxy']) ? $config['tls_proxy'] : 'false')."</li>\n";
					echo "\t<li>TLS implicit: " . (($config['tls_implicit'] == true) ? 'on' : 'off') . "</li>\n";
					echo "\t<li>Cookie path: " . $config['cookie_path'] . "</li>\n";
					// echo "\t<li>GZIP: " . (@extension_loaded('zlib') ? 'On' : 'Off') . "</li>\n";
					echo "</ul>\n";
				}

				if ($config['debug'] >= 3)
				{
					Ut::debug_print_r($engine->sess->toArray());
					Ut::debug_print_r($engine->context);
					// Ut::debug_print_r($config);
					// Ut::debug_print_r($engine->page);
				}

				echo "</div >\n";
			}
		}

		static::dbg_console($config['debug']);
	}

	// NB class http saves/restores log on redirect
	static $log = [];

	// add some debug output to DEBUG file and popup-window in browser
	static function dbg()
	{
		static $code = ['BLACK' => 0, 'BLUE' => 1, 'GOLD' => 2, 'ORANGE' => 3, 'RED' => 4];

		if (($args = func_get_args()))
		{
			if (($trace = debug_backtrace())
				&& ($callee = (@$trace[0]['file'] === __FILE__)? @$trace[1] : @$trace[0])
				&& @$callee['file'])
			{
				$dir = dirname(dirname(__FILE__)) . '/';
				$callee = str_replace($dir, '', $callee['file']) . ':' . $callee['line'];
			}
			else
			{
				$callee = '';
			}

			$type = (is_string($args[0]) && isset($code[$args[0]]))? $code[array_shift($args)] : 0;

			foreach ($args as &$arg)
			{
				if (!is_string($arg) || $arg === '' || preg_match('/[\x00-\x1f\x7f]/', $arg))
				{
					$arg = Ut::stringify($arg);
				}
			}

			static::$log[] = [
				microtime(1),
				$type,
				implode(' ', $args),
				$callee,
			];
		}
	}

	private static function dbg_console($debug)
	{
		if (!($log = static::$log))
		{
			return;
		}

		if ($debug)
		{
			echo <<<'EOD'
	<script type="text/javascript">
		console = window.open('', 'WackoWikiConsoleWindow', 'height=150,width=450,location=0,menubar=0,status=0,toolbar=0,scrollbars=1');
		console.document.writeln(
			'<html><head><style type=text/css>'
			+ 'body{background-color:#777777}'
			+ '.logtype0{color:black}'
			+ '.logtype1{color:blue}'
			+ '.logtype2{color:gold}'
			+ '.logtype3{color:orange}'
			+ '.logtype4{color:red}'
			+ '</style><title>wackowiki debug console</title>'
			+ '</head><body onLoad="self.focus()"><table>
EOD;

			foreach ($log as $one)
			{
				echo '<tr class="logtype' . (int)$one[1] . '">';
				echo '<td>' . number_format($one[0] - WACKO_STARTED, 4) . '</td>';
				echo '<td><code>' . htmlspecialchars($one[3], ENT_QUOTES | ENT_HTML401, HTML_ENTITIES_CHARSET) . '</code></td>';
				echo '<td>' .  htmlspecialchars($one[2], ENT_QUOTES | ENT_HTML401, HTML_ENTITIES_CHARSET) .  '</td>';
				echo '</tr>';
			}

			echo <<<'EOD'
			</table></body></html>');
		console.document.close();
		</script>
EOD;
		}

		$output = '';

		foreach ($log as $one)
		{
			$time = (int) $one[0];
			$output .= date('ymdHis', $time) . sprintf(".%04d ", ($one[0] - $time) * 10000)
				. $one[3] . ': ' . $one[2] . "\n";
		}

		@file_put_contents('DEBUG', $output, FILE_APPEND);
	}
}
