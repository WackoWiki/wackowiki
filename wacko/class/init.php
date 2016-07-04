<?php

if (!defined('IN_WACKO'))
{
	exit('No direct script access allowed');
}

// Compatibility with the password_* functions that ship with PHP 5.5
if (version_compare(PHP_VERSION, '5.5.0') < 0)
{
	require_once('lib/php_compatibility/password_compat.php');
}

class Init
{
	// WRAPPER VARIABLES
	var $config;
	var $page;
	var $method;
	var $timer;

	// CONSTRUCTOR
	// Mandatory runs and checks.
	function __construct(&$config)
	{
		$this->config = & $config;

		// setting PHP error reporting
		switch (PHP_ERROR_REPORTING)
		{
			case 0:		error_reporting(0); break;
			case 1:		error_reporting(E_ERROR | E_WARNING | E_PARSE); break;
			case 2:		error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE); break;
			case 3:		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING)); break;
			case 4:		error_reporting(E_ALL ^ E_NOTICE); break;
			case 5:		error_reporting(E_ALL); break;
			case 6:		error_reporting(-1); break; // uber all
			default:	error_reporting(E_ALL);
		}

		//  setting default timezone
		if (function_exists('date_default_timezone_set') && function_exists('date_default_timezone_get'))
		{
			// Set the timezone to whatever date_default_timezone_get() returns.
			date_default_timezone_set(@date_default_timezone_get());
		}

		// start execution timer
		$this->timer = microtime(1);

		// gzip_compression
		if (ini_get('zlib.output_compression'))
		{
			ob_start();
		}
		else if (function_exists('ob_gzhandler'))
		{
			ob_start('ob_gzhandler');
		}

		// don't let cookies ever interfere with request vars
		$_REQUEST = array_merge($_GET, $_POST);

		if (!isset($_REQUEST))
		{
			die('$_REQUEST[] not found. WackoWiki requires PHP_MIN_VERSION or higher!');
		}

		if (strstr($_SERVER['SERVER_SOFTWARE'], 'IIS'))
		{
			$_SERVER['REQUEST_URI'] = $_SERVER['PATH_INFO'];
		}
	}

	// REQUEST HANDLING
	// Process request string, define $page and $method vars
	function request()
	{
		if (isset($_SERVER['PATH_INFO']) && function_exists('virtual'))
		{
			$request = $_SERVER['PATH_INFO'];
		}
		else if (isset($_GET['page']))
		{
			$request = $_GET['page'];
		}
		else
		{
			$request = '';
		}

		$request = ltrim($request, '/');

		// check for permalink
		$hashids = new Hashids($this->config['hashid_seed']);
		$ids = $hashids->decode((($p = strpos($request, '/')) === false)? $request : substr($request, 0, $p));

		if (count($ids) == 3)
		{
			sscanf(hash('sha1', $ids[0] . $this->config['hashid_seed'] . $ids[1]), '%7x', $cksum);

			if ($ids[2] == $cksum)
			{
				$this->page = $ids[0] . 'x' . $ids[1];
				$this->method = 'Hashid';
				return;
			}
		}

		// split into page/method
		if (($p = strrpos($request, '/')) === false)
		{
			$this->page = $request;
			$this->method = '';
		}
		else
		{
			$this->page = substr($request, 0, $p);
			$this->method = strtolower(substr($request, $p + 1));

			if (!@file_exists(join_path(HANDLER_DIR, 'page', $this->method . '.php')))
			{
				$this->page	= $request;
				$this->method = '';
			}
			else if (preg_match('#^(.*?)/(' . $this->config['standard_handlers'] . ')(|/(.*))$#i', $this->page, $match))
			{
				//translit case
				$this->page = $match[1];
				$this->method = strtolower($match[2]);
			}
		}
	}

	// SESSION HANDLING
	function session()
	{
		$_secure = '';

		// run in tls mode?
		if ($this->config['tls'] == true && (( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' && !empty($this->config['tls_proxy'])) || $_SERVER['SERVER_PORT'] == '443' ) ))
		{
			$this->config['base_url']	= str_replace('http://', 'https://'.($this->config['tls_proxy'] ? $this->config['tls_proxy'].'/' : ''), $this->config['base_url']);
			$_secure					= true;
		}

		$_cookie_path = preg_replace('|https?://[^/]+|i', '', $this->config['base_url'].'');

		($_secure == true ? $secure = true : $secure = false );

		session_set_cookie_params(0, $_cookie_path, '', $secure, true);
		session_name($this->config['cookie_prefix'].SESSION_HANDLER_ID);

		// Save session information where specified or with PHP's default
		session_save_path(SESSION_HANDLER_PATH);

		// Initialize the session
		session_start();
		return session_id();
	}

	// INSTALLER
	function installer()
	{
		// compare versions, start installer if necessary
		if (!isset($this->config['wacko_version']) || version_compare($this->config['wacko_version'], WACKO_VERSION, '<'))
		{
			if (!isset($_REQUEST['installAction']) && !strstr($_SERVER['SERVER_SOFTWARE'], 'IIS'))
			{
				$req = $_SERVER['REQUEST_URI'];

				if ($req{strlen($req) - 1} != '/' && strstr($req, '.php') != '.php')
				{
					header('Location: http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'].'/');
					exit;
				}
			}

			// start installer
			//global $config;
			//$config = & $this->config;	// STS: sane $config there already

			if (!($install_action = trim(@$_REQUEST['installAction'])))
			{
				$install_action = 'lang';
			}

			include('setup/header.php');

			if (@file_exists('setup/'.$install_action.'.php'))
			{
				include('setup/'.$install_action.'.php');
			}
			else
			{
				echo '<em>Invalid action</em>';
			}

			include('setup/footer.php');

			exit;
		}
	}

	// Set security headers (frame busting, clickjacking/XSS/CSRF protection)
	//		Content-Security-Policy:
	//		Strict-Transport-Security:
	function http_security_headers()
	{
		if ($this->config['enable_security_headers'])
		{
			if ( !headers_sent() )
			{
				if (isset($this->config['csp']))
				{
					if ($this->config['csp'] == 1)
					{
						// http://www.w3.org/TR/CSP2/
						header( "Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src *;" );
					}
					else if ($this->config['csp'] == 2)
					{
						$csp_custom = str_replace(array("\r", "\n", "\t"), '', CSP_CUSTOM);

						header( $csp_custom );
					}
				}

				if ( isset( $_SERVER['HTTPS'] ) && ( $_SERVER['HTTPS'] != 'off' ) )
				{
					header( 'Strict-Transport-Security: max-age=7776000' );
				}
			}
		}
	}

	// DEBUG INFO
	function debug(&$engine)
	{
		if ($this->config['debug'] >= 1 && strpos($this->method, '.xml') === false && $this->method != 'print' && $this->method != 'wordprocessor')
		{
			if (($this->config['debug_admin_only'] == true && $engine->is_admin() === true) || $this->config['debug_admin_only'] == false)
			{
				$overall_time = microtime(1) - $this->timer;

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

				if ($this->config['debug'] >= 2)
				{
					echo "\t<li>Execution time: ".number_format($overall_time - $this->config->query_time, 3)." sec.</li>\n";
					echo "\t<li>SQL time: ".number_format($this->config->query_time, 3)." sec.</li>\n";
				}

				if ($this->config['debug'] >= 3)
				{
					echo "\t<li>SQL queries: ".count($this->config->query_log)."</li>\n";
					echo "\t<li>SQL queries dump follows".
							( $this->config['debug_sql_threshold'] > 0
								? " (&gt;".$this->config['debug_sql_threshold']." sec.)"
								: "" ).
						":\n\t\t<ol>\n";

					foreach ($this->config->query_log as $query)
					{
						if ($query['time'] < $this->config['debug_sql_threshold'])
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

				if ($this->config['debug'] >= 2)
				{
					$user = $engine->get_user();
					echo '<p class="debug">Language data</p>'."\n<ul>\n";
					echo "\t<li>Multilanguage: ".($this->config['multilanguage'] == 1 ? 'true' : 'false')."</li>\n";
					echo "\t<li>HTTP_ACCEPT_LANGUAGE set: ".(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? 'true' : 'false')."</li>\n";
					echo "\t<li>HTTP_ACCEPT_LANGUAGE value: ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."</li>\n";
					echo "\t<li>HTTP_ACCEPT_LANGUAGE chopped value: ".strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))."</li>\n";
					echo "\t<li>User language set: ".(isset($user['user_lang']) ? 'true' : 'false')."</li>\n";
					echo "\t<li>User language value: ".(isset($user['user_lang']) ? $user['user_lang'] : '')."</li>\n";
					echo "\t<li>Page language: ".$engine->page['page_lang'] ."</li>\n";
					echo "\t<li>Config language: ".$this->config['language']."</li>\n";
					echo "\t<li>User selected language: ".(isset($engine->user_lang) ? $engine->user_lang : '')."</li>\n";
					echo "\t<li>Charset: ".$engine->get_charset()."</li>\n";
					echo "\t<li>HTML Entities Charset: ".HTML_ENTITIES_CHARSET."</li>\n";
					// echo "\t<li>Disable cache: ".($engine->disable_cache === true ? 'true' : 'false')."</li>\n";
					echo "</ul>\n";
				}

				if ($this->config['debug'] >= 3)
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

				if ($this->config['debug'] >= 3)
				{
					echo '<p class="debug">Session data</p>'."\n<ul>\n";
					echo "\t<li>session_id(): ".session_id()."</li>\n";
					echo "\t<li>Base URL: ".$this->config['base_url']."</li>\n";
					echo "\t<li>HTTPS: ".(isset($_SERVER['HTTPS']) ? $_SERVER['HTTPS'] : '')."</li>\n";
					echo "\t<li>IP-address: ".$engine->get_user_ip()."</li>\n";
					echo "\t<li>SERVER_PORT: ".$_SERVER['SERVER_PORT']."</li>\n";
					echo "\t<li>TLS: ".(isset($this->config['tls']) ? 'on' : 'off')."</li>\n";
					echo "\t<li>TLS Proxy: ".(!empty($this->config['tls_proxy']) ? $this->config['tls_proxy'] : "false")."</li>\n";
					echo "\t<li>TLS implicit: ".(($this->config['tls_implicit'] == true) ? 'on' : 'off')."</li>\n";
					echo "\t<li>Cookie hash: ".(isset($this->config['cookie_hash']) ? $this->config['cookie_hash'] : '')."</li>\n";
					echo "\t<li>Cookie path: ".$this->config['cookie_path']."</li>\n";
					// echo "\t<li>GZIP: ".(@extension_loaded('zlib') ? 'On' : 'Off')."</li>\n";
					echo "</ul>\n";
				}

				if ($this->config['debug'] >= 3)
				{
					debug_print_r($_SESSION);
					debug_print_r($engine->context);
					// debug_print_r($this->config);
					// debug_print_r($engine->page);
				}

				echo "</div >\n";
			}
			else
			{
				return;
			}
		}
		else
		{
			return;
		}
	}
}
