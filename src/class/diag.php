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
	static function full_disclosure($config, $http, $engine, $cwd): void
	{
		chdir($cwd);

		if ($config['debug'] >= 1
			&& (!(isset($http->method) && str_contains($http->method, '.xml')))
			&& $http->method != 'print'
			&& $http->method != 'wordprocessor')
		{
			if (($config['debug_admin_only'] && $engine->is_admin()) || !$config['debug_admin_only'])
			{
				// [A] Program execution statistics

				$overall_time = microtime(true) - WACKO_STARTED;

				echo '<div id="debug">' .
					 '<p class="debug">Program execution statistics</p>' . "\n<ul>\n";

				// get memory usage
				if (function_exists('memory_get_peak_usage'))
				{
					$execmem = memory_get_peak_usage(true);
				}

				if ($execmem)
				{
					echo "\t<li>Memory allocated: " . $engine->factor_multiples($execmem, 'binary', true, true) . "</li>\n";
				}

				#echo "<li>UTC: " . gmdate('Y-m-d H:i:s', time()) . "</li>\n";
				echo "\t<li>Overall time taken: " . $engine->number_format($overall_time, 3) . " sec. </li>\n";

				if ($config['debug'] >= 2)
				{
					echo "\t<li>Execution time: " . $engine->number_format($overall_time - $config->query_time, 3) . " sec.</li>\n";
					echo "\t<li>SQL time: " . $engine->number_format($config->query_time, 3) . " sec.</li>\n";
				}

				if ($config['debug'] >= 3)
				{
					echo "\t<li>SQL queries: " . $engine->number_format(count($config->query_log)) . "</li>\n";
					echo "\t<li>SQL queries dump follows" .
							($config['debug_sql_threshold'] > 0
								? ' (&gt;' . $config['debug_sql_threshold'] . ' sec.)'
								: '') .
						":\n\t\t<ol>\n";

					foreach ($config->query_log as $one)
					{
						[$query, $time, $affected_rows, $backtrace] = $one;

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
							[$fname, $func] = $one;
							$btext .= '<tr><td>' . $func . NBSP . '</td><td>' . NBSP . $fname . '</td></tr>';
						}

						echo "\t";
						echo '<li class="sqllog">';
						echo str_replace(['<', '>'], ['&lt;', '&gt;'], $query) . '<br>';
						echo '[' . $engine->number_format($time, 4) . ' sec., ' . $affected_rows . ' rows';
						echo '<div class="backtrace">';
						echo '<table>' . $btext . '</table>';
						echo "</div>]</li>\n";
					}

					echo "\t\t</ol>\n\t</li>\n";
				}

				echo "</ul>\n";

				if ($config['debug'] >= 2)
				{
					// [B] Language data

					$user		= $engine->get_user();
					$lang_data	= [
						'Multilanguage: ' . 				($config['multilanguage'] == 1 ? 'true' : 'false'),
						'HTTP_ACCEPT_LANGUAGE set: ' .		(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? 'true' : 'false'),
						'HTTP_ACCEPT_LANGUAGE value: ' .	($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? ''),
						'User agent language: ' .			$http->user_agent_language(),
						'User language set: ' .				(isset($user['user_lang']) ? 'true' : 'false'),
						'User language value: ' .			($user['user_lang'] ?? ''),
						'Local: ' .							$engine->lang['locale'],
						'Page language: ' .					($engine->page['page_lang'] ?? ''),
						'Config language: ' .				$config['language'],
						'User selected language: ' .		($engine->user_lang ?? ''),
						'HTML Entities Charset: ' .			HTML_ENTITIES_CHARSET,
						# 'Disable cache: ' .				($engine->disable_cache ? 'true' : 'false'),
					];

					echo '<p class="debug">Language data</p>' . "\n<ul>\n";

					foreach ($lang_data as $lang_item)
					{
						echo "\t<li>" . $lang_item . "</li>\n";
					}

					echo "</ul>\n";
				}

				if ($config['debug'] >= 3)
				{
					// [C] MySQL character set

					if (!$config['is_sqlite'])
					{
						$query = "SHOW VARIABLES WHERE Variable_name LIKE 'character\_set\_%' OR Variable_name LIKE 'collation\_connection';";

						if ($r = $engine->db->load_all($query, true))
						{
							echo "<p class=\"debug\">MySQL character set</p>\n<ul>\n";

							foreach ($r as $charset_item)
							{
								echo "\t<li>" . $charset_item['Variable_name'] . ': ' . $charset_item['Value'] . "</li>\n";
							}

							echo "</ul>\n";
						}

						$query = 'SELECT @@GLOBAL.sql_mode, @@SESSION.sql_mode;';

						if ($r = $engine->db->load_single($query, true))
						{
							echo "<p class=\"debug\">SQL mode set</p>\n<ul>\n";
							echo "\t<li>" . 'GLOBAL' . ': ' . $r['@@GLOBAL.sql_mode'] . "</li>\n";
							echo "\t<li>" . 'SESSION' . ': ' . $r['@@SESSION.sql_mode'] . "</li>\n";
							echo "</ul>\n";
						}
					}

					// [D] Environment data

					$env_data	= [
						'session_id(): ' .		$engine->sess->id(),
						'Base URL: ' .			$config['base_url'],
						'Rewrite Mode: ' .		($config['rewrite_mode'] ? 'on' : 'off'),
						'HTTP_MOD_ENV: ' .		((getenv('HTTP_MOD_ENV') === 'on') ? 'on' : 'off'),
						'HTTP_MOD_REWRITE: ' .	((getenv('HTTP_MOD_REWRITE') === 'on') ? 'on' : 'off'),
						'HTTPS: ' .				($_SERVER['HTTPS'] ?? 'off'),
						'IP-address: ' .		$http->ip,
						'SERVER_PORT: ' .		$_SERVER['SERVER_PORT'],
						'TLS: ' .				(isset($config['tls']) ? 'on' : 'off'),
						'TLS implicit: ' .		($config['tls_implicit'] ? 'on' : 'off'),
						'Cookie path: ' .		$config['cookie_path'],
						# 'GZIP: ' .			(@extension_loaded('zlib') ? 'On' : 'Off'),
					];

					echo '<p class="debug">Environment data</p>' . "\n<ul>\n";

					foreach ($env_data as $env_item)
					{
						echo "\t<li>" . $env_item . "</li>\n";
					}

					echo "</ul>\n";

					// [E] Session data

					$session = $engine->sess->toArray();
					unset($session['user_profile']['password']);

					echo '<p class="debug">Session data</p>' . "\n<ul>\n";
					Ut::debug_print_r($session);
					Ut::debug_print_r($engine->context);

					if ($engine->is_admin())
					{
						# Ut::debug_print_r($_SERVER);
						# Ut::debug_print_r($config);
					}

					# Ut::debug_print_r($engine->page);
				}

				echo "</div >\n";
			}
		}

		static::dbg_console($config['debug']);
	}

	// NB class http saves/restores log on redirect
	static $log = [];

	// add some debug output to DEBUG file and popup-window in browser
	static function dbg(): void
	{
		static $code = [
			'BLACK'		=> 0,
			'BLUE'		=> 1,
			'GOLD'		=> 2,
			'ORANGE'	=> 3,
			'RED'		=> 4
		];

		if ($args = func_get_args())
		{
			if (($trace = debug_backtrace())
				&& ($callee = (@$trace[0]['file'] === __FILE__)? @$trace[1] : @$trace[0])
				&& @$callee['file'])
			{
				$dir	= dirname(__FILE__, 2) . '/';
				$callee	= str_replace($dir, '', $callee['file']) . ':' . $callee['line'];
			}
			else
			{
				$callee	= '';
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
				microtime(true),
				$type,
				implode(' ', $args),
				$callee,
			];
		}
	}

	private static function dbg_console($debug): void
	{
		if (!($log = static::$log))
		{
			return;
		}

		if ($debug)
		{
			echo <<<'EOD'
	<script>
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
			+ '</head><body onLoad="self.focus()"><table>;
EOD;

			foreach ($log as $one)
			{
				echo '<tr class="logtype' . (int) $one[1] . '">';
				echo '<td>' .		number_format($one[0] - WACKO_STARTED, 4) . '</td>';
				echo '<td><code>' .	Ut::html($one[3]) . '</code></td>';
				echo '<td>' . 		Ut::html($one[2]) .  '</td>';
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
			$output .= date('ymdHis', $time) . sprintf('.%04d ', ($one[0] - $time) * 10000)
				. $one[3] . ': ' . $one[2] . "\n";
		}

		@file_put_contents('DEBUG', $output, FILE_APPEND);
	}
}
