<?php

if (!defined('IN_WACKO'))
{
	exit('No direct script access allowed');
}

/*

########################################################
##     Wacko engine initialization API                ##
########################################################

	Calling order (* - mandatory for engine startup):

	1.  init()*				- constructor, unescape magic quotes, version checks
	2.  settings()*			- load primary engine config from file: variables and constants
	3.  settings()*			- load secondary engine config from database (calls dbal())
	4.  settings($p,$v)		- set additional config parameters if needed
	5.  request()			- parse request string if needed for wacko pages processing
	6.  dbal()*				- establish DBAL for database operations and connect to DB (required by engine())
	7.  session()			- start user session
	8.  is_locked()			- check website for locking
	9.  installer()			- start installer if necessary
	10. get_micro_time()	- return precise timer
	11. cache()				- initialize caching engine
	12. cache('check')		- process request for caching purposes (required by cache('store'))
	13. engine()*			- initialize Wacko engine
	14. engine('run')		- execute script and open start page (requires engine())
	15. cache('store')		- cache page (requires engine())
	16. debug()				- print debugging information

	Additional information can be found in class methods' comments.

*/

// mandatory includes
require_once('config/constants.php');

// Compatibility with the password_* functions that ship with PHP 5.5
if (version_compare(PHP_VERSION, '5.5.0') < 0)
{
	require_once('lib/php_compatibility/password_compat.php');
}

class Init
{
	// WRAPPER VARIABLES
	var $config;
	var $cacheval	= null;
	var $cache;
	var $engine;
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

			if (!@file_exists($this->config['handler_path'] . '/page/' . $this->method . '.php'))
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

	// CHECK WEBSITE LOCKING
	function is_locked($file = 'lock')
	{
		return substr(@file_get_contents('config/' . $file), 0, 1) == '1';
	}

	// lock / unlock
	// writes value to lock file
	//		file	= lock file in config folder
	function lock($file = 'lock')
	{
		@file_put_contents('config/' . $file, ($this->is_locked($file)? '0' : '1'));
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
			global $config;
			$config = & $this->config;

			if (!$install_action = (isset($_REQUEST['installAction']) ? trim($_REQUEST['installAction']) : ''))
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

	// CACHING ENGINE
	// First must be initialized without parameters. Then
	// can be used with these values (for corresponding
	// cache class methods):
	//		log		= Log
	//		check	= check_http_request
	//		store	= store_page_cache
	function cache($op = '')
	{
		// check config data
		if (!$this->config)
		{
			die('Error starting WackoWiki cache engine: config data must be initialized.');
		}

		if (!$this->cache || !$op)
		{
			$this->cache = new Cache($this->config['cache_dir'], $this->config['cache_ttl'], $this->config['debug']);
		}

		if ($op == 'check')
		{
			if ($this->config['cache'] && $_SERVER['REQUEST_METHOD'] != 'POST' && $this->method != 'edit' && $this->method != 'watch')
			{
				// cache only for anonymous user
				if (!isset($_COOKIE[$this->config['cookie_prefix'].'auth'.'_'.$this->config['cookie_hash']]))
				{
					$this->cacheval = $this->cache->check_http_request($this->page, $this->method);
				}
			}
		}
		else if ($op == 'store')
		{
			if ($this->cacheval)
			{
				$data = ob_get_contents();

				if (!empty($data) && !$this->engine->disable_cache)
				{
					return $this->cache->store_page_cache($data);
				}
				else
				{
					// FALSE, then output buffering is not active
				}
			}
		}
		else if ($this->config['cache'] && $op == 'log')
		{
			$this->cache->log('Before Run WackoWiki='.$this->engine->config['wacko_version']);
		}
	}

	// WACKOWIKI ENGINE
	// First must be initialized without parameters. Then
	// can be used with these values:
	//		run		= Main execution routine (open start page)
	//		lang	= Load and register locale string resources
	//				  only (for $lang or for default language)
	function engine($op = '', $lang = '')
	{
		// check config data
		if ($this->config == false)
		{
			die("Error starting WackoWiki engine: config data must be initialized.");
		}

		// terminate for banned IPs
		/* if (in_array($_SERVER['REMOTE_ADDR'], $this->config['bans']))
		{
			die();
		} */

		if ($this->engine == false || $op == false)
		{

			$this->engine = new Wacko($this->config);
			$this->engine->header_count = 0;

			// FIXME: add description
			if ($this->cache == true)
			{
				$this->cache->wacko		= & $this->engine;
				$this->engine->cache	= & $this->cache;
			}

			return $this->engine;
		}
		else if ($this->engine == true && $op == 'run')
		{
			return $this->engine->run($this->page, $this->method);
		}
		else if ($this->engine == true && $op == 'lang')
		{
			// registers locale resources for admin panel
			//		call $init->engine('lang');
			if (!$lang)
			{
				$lang = $this->config['language'];
			}

			$this->engine->set_language($lang, true);

			return true;
		}
		else
		{
			return false;
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
	function debug()
	{
		if ($this->config['debug'] >= 1 && strpos($this->method, '.xml') === false && $this->method != 'print' && $this->method != 'wordprocessor')
		{
			if (($this->config['debug_admin_only'] == true && $this->engine->is_admin() === true) || $this->config['debug_admin_only'] == false)
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
					echo "\t<li>Memory allocated: ".$this->engine->binary_multiples($execmem, false, true, false)."</li>\n";
				}

				#echo "<li>UTC: ".date('Y-m-d H:i:s', time())."</li>\n";
				echo "\t<li>Overall time taken: ".(number_format(($overall_time), 3))." sec. </li>\n";

				if ($this->config['debug'] >= 2)
				{
					echo "\t<li>Execution time: ".number_format($overall_time - $this->engine->query_time, 3)." sec.</li>\n";
					echo "\t<li>SQL time: ".number_format($this->engine->query_time, 3)." sec.</li>\n";
				}

				if ($this->config['debug'] >= 3)
				{
					echo "\t<li>SQL queries: ".count($this->engine->query_log)."</li>\n";
					echo "\t<li>SQL queries dump follows".
							( $this->config['debug_sql_threshold'] > 0
								? " (&gt;".$this->config['debug_sql_threshold']." sec.)"
								: "" ).
						":\n\t\t<ol>\n";

					foreach ($this->engine->query_log as $query)
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
					$user = $this->engine->get_user();
					echo '<p class="debug">Language data</p>'."\n<ul>\n";
					echo "\t<li>Multilanguage: ".($this->config['multilanguage'] == 1 ? 'true' : 'false')."</li>\n";
					echo "\t<li>HTTP_ACCEPT_LANGUAGE set: ".(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? 'true' : 'false')."</li>\n";
					echo "\t<li>HTTP_ACCEPT_LANGUAGE value: ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."</li>\n";
					echo "\t<li>HTTP_ACCEPT_LANGUAGE chopped value: ".strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))."</li>\n";
					echo "\t<li>User language set: ".(isset($user['user_lang']) ? 'true' : 'false')."</li>\n";
					echo "\t<li>User language value: ".(isset($user['user_lang']) ? $user['user_lang'] : '')."</li>\n";
					echo "\t<li>Page language: ".$this->engine->page['page_lang'] ."</li>\n";
					echo "\t<li>Config language: ".$this->config['language']."</li>\n";
					echo "\t<li>User selected language: ".(isset($this->engine->user_lang) ? $this->engine->user_lang : '')."</li>\n";
					echo "\t<li>Charset: ".$this->engine->get_charset()."</li>\n";
					echo "\t<li>HTML Entities Charset: ".HTML_ENTITIES_CHARSET."</li>\n";
					echo "\t<li>Disable cache: ".($this->engine->disable_cache === true ? 'true' : 'false')."</li>\n";
					echo "</ul>\n";
				}

				if ($this->config['debug'] >= 3)
				{
					$query = 'SHOW VARIABLES LIKE "%character_set%";';

					if ($r = $this->engine->load_all($query, true))
					{
						echo "<p class=\"debug\">MySQL character set</p>\n<ul>\n";

						foreach ($r as $k => $charset_item)
						{
							echo "\t<li>".$charset_item['Variable_name'].": ".$charset_item['Value']."</li>\n";
						}

						echo "</ul>\n";
					}

					$query = 'SELECT @@GLOBAL.sql_mode, @@SESSION.sql_mode;';

					if ($r = $this->engine->load_single($query, true))
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
					echo "\t<li>IP-address: ".$this->engine->get_user_ip()."</li>\n";
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
					debug_print_r($this->engine->context);
					debug_print_r($this->config);
					// debug_print_r($this->engine->page);
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
