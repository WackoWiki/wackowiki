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
	static function debug(&$config, &$http, &$engine)
	{
		if ($config['debug'] >= 1 && strpos($http->method, '.xml') === false && $http->method != 'print' && $http->method != 'wordprocessor')
		{
			if (($config['debug_admin_only'] == true && $engine->is_admin() === true) || $config['debug_admin_only'] == false)
			{
				$overall_time = microtime(1) - $config->started;

				echo '<div id="debug">'.
					 '<p class="debug">Program execution statistics</p>'."\n<ul>\n";

				// get memory usage
				if(function_exists('memory_get_peak_usage'))
				{
					$execmem = memory_get_peak_usage(true);
				}

				if ($execmem)
				{
					echo "\t<li>Memory allocated: ".$engine->binary_multiples($execmem, false, true, false)."</li>\n";
				}

				#echo "<li>UTC: ".date('Y-m-d H:i:s', time())."</li>\n";
				echo "\t<li>Overall time taken: ".(number_format(($overall_time), 3))." sec. </li>\n";

				if ($config['debug'] >= 2)
				{
					echo "\t<li>Execution time: ".number_format($overall_time - $config->query_time, 3)." sec.</li>\n";
					echo "\t<li>SQL time: ".number_format($config->query_time, 3)." sec.</li>\n";
				}

				if ($config['debug'] >= 3)
				{
					echo "\t<li>SQL queries: ".count($config->query_log)."</li>\n";
					echo "\t<li>SQL queries dump follows".
							( $config['debug_sql_threshold'] > 0
								? " (&gt;".$config['debug_sql_threshold']." sec.)"
								: "" ).
						":\n\t\t<ol>\n";

					foreach ($config->query_log as $query)
					{
						if ($query['time'] < $config['debug_sql_threshold'])
						{
							continue;
						}

						echo "\t<li>";
						echo str_replace(array('<', '>'), array('&lt;', '&gt;'), $query['query'])."<br />";
						echo "[".number_format($query['time'], 4)." sec.]";
						echo "</li>\n";
					}

					echo "\t\t</ol>\n\t</li>\n";
				}
				echo "</ul>\n";

				if ($config['debug'] >= 2)
				{
					$user = $engine->get_user();
					echo '<p class="debug">Language data</p>'."\n<ul>\n";
					echo "\t<li>Multilanguage: ".($config['multilanguage'] == 1 ? 'true' : 'false')."</li>\n";
					echo "\t<li>HTTP_ACCEPT_LANGUAGE set: ".(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? 'true' : 'false')."</li>\n";
					echo "\t<li>HTTP_ACCEPT_LANGUAGE value: ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."</li>\n";
					echo "\t<li>HTTP_ACCEPT_LANGUAGE chopped value: ".strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))."</li>\n";
					echo "\t<li>User language set: ".(isset($user['user_lang']) ? 'true' : 'false')."</li>\n";
					echo "\t<li>User language value: ".(isset($user['user_lang']) ? $user['user_lang'] : '')."</li>\n";
					echo "\t<li>Page language: ".$engine->page['page_lang'] ."</li>\n";
					echo "\t<li>Config language: ".$config['language']."</li>\n";
					echo "\t<li>User selected language: ".(isset($engine->user_lang) ? $engine->user_lang : '')."</li>\n";
					echo "\t<li>Charset: ".$engine->get_charset()."</li>\n";
					echo "\t<li>HTML Entities Charset: ".HTML_ENTITIES_CHARSET."</li>\n";
					// echo "\t<li>Disable cache: ".($engine->disable_cache === true ? 'true' : 'false')."</li>\n";
					echo "</ul>\n";
				}

				if ($config['debug'] >= 3)
				{
					$query = 'SHOW VARIABLES LIKE "%character_set%";';

					if ($r = $engine->load_all($query, true))
					{
						echo "<p class=\"debug\">MySQL character set</p>\n<ul>\n";

						foreach ($r as $k => $charset_item)
						{
							echo "\t<li>".$charset_item['Variable_name'].": ".$charset_item['Value']."</li>\n";
						}

						echo "</ul>\n";
					}

					$query = 'SELECT @@GLOBAL.sql_mode, @@SESSION.sql_mode;';

					if ($r = $engine->load_single($query, true))
					{
						echo "<p class=\"debug\">SQL mode set</p>\n<ul>\n";
						echo "\t<li>".'GLOBAL'.": ".$r['@@GLOBAL.sql_mode']."</li>\n";
						echo "\t<li>".'SESSION'.": ".$r['@@SESSION.sql_mode']."</li>\n";
						echo "</ul>\n";
					}
				}

				if ($config['debug'] >= 3)
				{
					echo '<p class="debug">Session data</p>'."\n<ul>\n";
					echo "\t<li>session_id(): ".$engine->sess->id()."</li>\n";
					echo "\t<li>Base URL: ".$config['base_url']."</li>\n";
					echo "\t<li>HTTPS: ".(isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : '')."</li>\n";
					echo "\t<li>IP-address: ".$engine->get_user_ip()."</li>\n";
					echo "\t<li>SERVER_PORT: ".$_SERVER['SERVER_PORT']."</li>\n";
					echo "\t<li>TLS: ".(isset($config['tls']) ? 'on' : 'off')."</li>\n";
					echo "\t<li>TLS Proxy: ".(!empty($config['tls_proxy']) ? $config['tls_proxy'] : "false")."</li>\n";
					echo "\t<li>TLS implicit: ".(($config['tls_implicit'] == true) ? 'on' : 'off')."</li>\n";
					echo "\t<li>Cookie hash: ".(isset($config['cookie_hash']) ? $config['cookie_hash'] : '')."</li>\n";
					echo "\t<li>Cookie path: ".$config['cookie_path']."</li>\n";
					// echo "\t<li>GZIP: ".(@extension_loaded('zlib') ? 'On' : 'Off')."</li>\n";
					echo "</ul>\n";
				}

				if ($config['debug'] >= 3)
				{
					Ut::debug_print_r($_SESSION);
					Ut::debug_print_r($engine->context);
					// Ut::debug_print_r($config);
					// Ut::debug_print_r($engine->page);
				}

				echo "</div >\n";
			}
		}
	}
}
