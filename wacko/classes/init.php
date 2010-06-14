<?php

/*

########################################################
##     Wacko engine initialization API                ##
########################################################

	Calling order (* - mandatory for engine startup):

	1.  Init()*			- constructor, unescape magic quotes, version checks
	2.  Settings()*		- load primary engine config from file: variables and constants
	3.  Settings()*		- load secondary engine config from database (calls DBAL())
	4.  Settings($p,$v)	- set additional config parameters if needed
	5.  Request()		- parse request string if needed for wacko pages processing
	6.  DBAL()*			- establish DBAL for database operations and connect to DB (required by Engine())
	7.  Session()		- start user session
	8.  IsLocked()		- check website for locking
	9.  Installer()		- start installer if necessary
	10. GetMicroTime()	- return precise timer
	11. Cache()			- initialize caching engine
	12. Cache('check')	- process request for caching purposes (required by Cache('store'))
	13. Engine()*		- initialize Wacko engine
	14. Engine('run')	- execute script and open start page (requires Engine())
	15. Cache('store')	- cache page (requires Engine())
	16. Debug()			- print debugging information

	Additional information can be found in class methods' comments.

*/

// constants
if ( @file_exists("config/constants.php") )
{
	require_once("config/constants.php");
}
else
{
	#die("Error loading WackoWiki constants data: file `config/constants.php` is missing.");
}

class Init
{
	// WRAPPER VARIABLES
	var $config		= array();
	var $dblink		= NULL;
	var $cacheval	= NULL;
	var $cache;
	var $engine;
	var $page;
	var $request;
	var $method;
	var $timer;

	// CONSTRUCTOR
	// Mandatory runs and checks.
	function Init()
	{
		error_reporting (E_ALL ^ E_NOTICE);
		# error_reporting (E_ALL);

		// start execution timer
		$this->timer = $this->GetMicroTime();

		if (ini_get("zlib.output_compression"))
			ob_start();
		else
			ob_start("ob_gzhandler");

		if (!isset($_REQUEST)) die('$_REQUEST[] not found. WackoWiki requires PHP 5.2.0 or higher!');

		// Check for function because it is deprecated in PHP 5.3 and removed in PHP 6
		if (function_exists("set_magic_quotes_runtime"))
		{
			@set_magic_quotes_runtime(false);
		}

		if (get_magic_quotes_gpc())
		{
			$this->ParseMQ($_POST);
			$this->ParseMQ($_GET);
			$this->ParseMQ($_COOKIE);
			$this->ParseMQ($_SERVER);
			$this->ParseMQ($_REQUEST);
		}

		if (strstr($_SERVER["SERVER_SOFTWARE"], "IIS")) $_SERVER["REQUEST_URI"] = $_SERVER["PATH_INFO"];
	}

	// INT TIMER
	function GetMicroTime()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

	// Workaround for the amazingly annoying magic quotes.
	function ParseMQ(&$a)
	{
		if (is_array($a))
		{
			foreach ($a as $k => $v)
			{
				if (is_array($v))
					$this->ParseMQ($a[$k]);
				else
					$a[$k] = stripslashes($v);
			}
		}
	}

	// DEFINE WACKO SETTINGS
	// First must be called without parameters to initialize default
	// settings. Additional settings can be added afterwards.
	function Settings($name = "", $value = "", $override = 0)
	{
		// specific definition
		if ($name == true)
		{
			if (!isset($this->config[$name]) || $override == 1)
			{
				return $this->config[$name] = $value;
			}
			else
			{
				return false;
			}
		}
		else
		{
			// primary settings
			if ($this->config == false && !isset($this->dblink))
			{
				$found_rewrite_extension = function_exists("apache_get_modules") ? in_array("mod_rewrite", apache_get_modules()) : false;

			/*
				VERY IMPORTANT NOTE

				The name of the array "wakkaConfig" is very important for backwards compatibility when we are upgrading an ancient wakka install.
				For that reason this can never change although internally the config data is referred to as $this->config
			*/

				// load default configuration values
				if ( @file_exists("config/config_default.inc.php") )
				{
					require_once("config/config_default.inc.php");
				}
				else
				{
					#die("Error loading WackoWiki default config data: file `config/config_default.inc.php` is missing.");
				}

				// load primary config
				if ( @file_exists("wakka.config.php") )
				{
					// It's an old WackoWiki or WakkaWiki install so load the data and start the upgrader.
					if ( @filesize("wakka.config.php") > 0)
					{
						require("wakka.config.php");
						$this->config = $wakkaConfig;
					}
					else
					{
						// Else it's an empty file so use the default settings, this is quite unlikely to occur.
						$this->config = $wackoConfig;
					}
				}
				else if ( @file_exists("config.inc.php") )
				{
					// If the file exists and has some content then we assume it's a proper WackoWiki config file, as of R4.3
					if ( @filesize("config.inc.php") > 0)
					{
						require("config.inc.php");
						$this->config = $wackoConfig;

						if ($wackoConfig["wacko_version"] != "R4.3.rc" && (!$wackoConfig["system_seed"] || strlen($wackoConfig["system_seed"]) < 20))
							die("WackoWiki fatal error: system_seed in config.inc.php is empty or too short. Please, use 20+ *random* characters to define this variable.");

						$wackoConfig["system_seed"]	= sha1($wackoConfig["system_seed"]);
					}
					else
					{
						// Else it's an empty file so use the default settings.  This is typical on a fresh install.
						$this->config = $wackoConfig;
					}
				}
				else
				{
					$this->config = $wackoConfig;
				}

				$this->Installer();
			}
			// secondary settings
			else if ($this->config == true && !isset($this->dblink))
			{
				// connecting to db
				$this->DBAL();

				// retrieving configuration data
				 $wackoDBQuery = "SELECT config_name, value FROM {$this->config["table_prefix"]}config";
				if ($result = query($this->dblink, $wackoDBQuery , 0))
				{
					while ($row = fetch_assoc($result))
					{
						$this->config[$row["config_name"]] = $row["value"];
					}
					free_result($result);
				}
				else
				{
				#	die("Error loading WackoWiki config data: database `config` table is empty.");
				}

				// retrieving usergroups data
				$wackoDBQuery = "SELECT
									g.group_name,
									u.user_name
								FROM
									{$this->config["table_prefix"]}group_member gm
									INNER JOIN {$this->config["table_prefix"]}user u ON (gm.user_id = u.user_id)
									INNER JOIN {$this->config["table_prefix"]}group g ON (gm.group_id = g.group_id)";

				$groups_array = array();

				if ($result = query($this->dblink, $wackoDBQuery, 0))
				{
					while ($row = fetch_assoc($result))
					{
						// Here we join our stuff in a single array
						array_push($groups_array, $row);
					}
					free_result($result);

					if (!empty($groups_array))
					{
						$_groups = array();

						foreach ($groups_array as $user_group_pairs)
						{
							if (!isset($_groups[$user_group_pairs['group_name']])) $_groups[$user_group_pairs['group_name']] = "";

							// Then we make old fashioned UserName1\nUserName2\n lines for each group
							$_groups[$user_group_pairs['group_name']] .= $user_group_pairs['user_name'].'\n';
						}
					}

					foreach ($_groups as $group => $users)
					{
						// Finally we put the proper Group => UserName1\nUserName2\n to the config
						// when we make trim($users, '\n') we get UserName1\nUserName2 without trailing '\n'
						// Made so to prevent system from trimming 'n\n' (like TestMan\n ->  TestMa)
						$trimone = rtrim($users,'n');
						$this->config["aliases"][$group] = trim($trimone,'\\');
					}

				}
				else
				{
					#die("Error loading WackoWiki usergroups data: database `group` table is empty.");
				}

				return $this->config;
			}
		}
	}

	// REQUEST HANDLING
	// Process request string, define $page and $method vars
	function Request()
	{
		// check config data
		if ($this->config == false) die("Error processing request: WackoWiki config data must be initialized.");

		// fetch wacko location
		if (isset($_SERVER["PATH_INFO"]) && function_exists("virtual"))
			$this->request = $_SERVER["PATH_INFO"];
		else
			$this->request = @$_REQUEST["page"];

		// fix win32 apache 1 bug
		if (stristr($_SERVER["SERVER_SOFTWARE"], "Apache/1") && stristr($_SERVER["SERVER_SOFTWARE"], "Win32") && $this->config["rewrite_mode"])
		{
			$dir			= str_replace("http://".$_SERVER["SERVER_NAME"].($_SERVER["SERVER_PORT"] != 80 ? ":".$_SERVER["SERVER_PORT"] : ""), "", $this->config["base_url"]);
			$this->request	= preg_replace("+^".preg_quote(rtrim($dir,"/"))."+i", "", $_SERVER["REDIRECT_URL"]);//$request);
		}

		// remove leading slash
		$this->request	= preg_replace("/^\//", "", $this->request);
		$this->method	= "";

		// split into page/method
		$p = strrpos($this->request, "/");

		if ($p === false)
		{
			$this->page = $this->request;
		}
		else
		{
			$this->page			= substr($this->request, 0, $p);
			$m1	= $this->method = strtolower(substr($this->request, $p - strlen($this->request) + 1));

			if (!@file_exists($this->config["handler_path"]."/page/".$this->method.".php"))
			{
				$this->page		= $this->request;
				$this->method	= "";
			}
			else if (preg_match("/^(.*?)\/(".$this->config["standard_handlers"].")($|\/(.*)$)/i", $this->page, $match))
			{
				//translit case
				$this->page		= $match[1];
				$this->method	= $match[2];
			}
		}
		return true;
	}

	// SESSION HANDLING
	function Session()
	{
		if ($this->config["ssl"] == true) session_set_cookie_params(0, "/", "", true);

		session_name(SESSION_HANDLER_ID);

		// Save session information where specified or with PHP's default
		session_save_path(SESSION_HANDLER_PATH);

		// Initialize the session
		session_start();
		return session_id();
	}

	// DATABASE ABSTRACT LAYER
	// Initialize DBAL for basic DB operations and connect to selected DB.
	// Default DB is 'mysql_database' config value, however any other value may
	// be passed. All DBs must be on the server specified in the config file.
	function DBAL($dbname = "")
	{
		if (isset($this->dblink)) return;

		// check config data
		if ($this->config == false) die("Error loading WackoWiki DBAL: config data must be initialized.");

		// Load the correct database connector
		if (!isset( $this->config["database_driver"] )) $this->Settings("database_driver", "mysql_legacy");

		switch($this->config["database_driver"])
		{
			case "mysql":
				$dbfile = "db/pdo.php";
				break;
			case "mysqli_legacy":
				$dbfile = "db/mysqli.php";
				break;
			default:
				$dbfile = "db/mysql.php";
				break;
		}

		// load DBAL
		if (@file_exists($dbfile))
			require($dbfile);
		else
			die("Error loading WackoWiki DBAL: file ".$dbfile." not found.");

		// connect to DB
		if ($dbname == false) $dbname = $this->config["database_database"];

		$this->dblink = connect($this->config["database_host"], $this->config["database_user"], $this->config["database_password"], $this->config["database_database"], $this->config["database_collation"], $this->config["database_driver"], $this->config["database_port"]);

		if ($this->dblink)
			return $this->dblink;
		else
			die("Error loading WackoWiki DBAL: could not establish database connection.");
	}

	// CHECK WEBSITE LOCKING
	function IsLocked()
	{
		clearstatcache();
		if (@file_exists("lock"))
		{
			$access = file("lock");

			if ($access[0] == "1")
				return true;
			else
				return false;
		}
		else
		{
			return false;
		}
	}

	// INSTALLER
	function Installer()
	{
		// compare versions, start installer if necessary
		if (!isset($this->config["wacko_version"]) || $this->config["wacko_version"] != WACKO_VERSION)
		{
			if (!isset($_REQUEST["installAction"]) && !strstr($_SERVER["SERVER_SOFTWARE"], "IIS"))
			{
				$req = $_SERVER["REQUEST_URI"];
				if ($req{strlen($req) - 1} != "/" && strstr($req, ".php") != ".php")
				{
					header("Location: http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]."/");
					exit;
				}
			}

			// start installer
			global $config;
			$config = $this->config;

			if (!$installAction = trim($_REQUEST["installAction"])) $installAction = "lang";
			include("setup/header.php");

			if (@file_exists("setup/".$installAction.".php"))
			include("setup/".$installAction.".php");

			else print("<em>Invalid action</em>");
			include("setup/footer.php");

			exit;
		}
	}

	// CACHING ENGINE
	// First must be initialized without parameters. Then
	// can be used with these values (for corresponding
	// cache class methods):
	//		log		= Log
	//		check	= CheckHttpRequest
	//		store	= StoreToCache
	function Cache($op = "")
	{
		// check config data
		if ($this->config == false) die("Error starting WackoWiki cache engine: config data must be initialized.");

		if ($this->cache == false || $op == false)
		{
			require("classes/cache.php");
			return $this->cache = new Cache($this->config["cache_dir"], $this->config["cache_ttl"]);
		}
		else if ($this->cache == true && $op == "check")
		{
			if ($this->config["cache"] && $_SERVER["REQUEST_METHOD"] != "POST" && $this->method != "edit" && $this->method != "watch")
			{
				if (!isset($_COOKIE[$this->config["session_prefix"].'_'.$this->config["cookie_prefix"]."auth"]))	// anonymous user
				{
					return $this->cacheval = $this->cache->CheckHttpRequest($this->page, $this->method);
				}
			}
		}
		else if ($this->cache == true && $op == "store")
		{
			if ($this->cacheval == true)
			{
				$data = ob_get_contents();
				return $this->cache->StoreToCache($data);
			}
		}
		else if ($this->cache == true && $op == "log")
		{
			return $this->cache->Log("Before Run WackoWiki=".$this->engine->config["wacko_version"]);
		}
		else
		{
			return false;
		}
	}

	// WACKOWIKI ENGINE
	// First must be initialized without parameters. Then
	// can be used with these values:
	//		run		= Main execution routine (open start page)
	//		res		= Load and register locale string resources
	//				  only (for $lang or for default language)
	function Engine($op = "", $lang = "")
	{
		// check config data
		if ($this->config == false)	die("Error starting WackoWiki engine: config data must be initialized.");

		if ($this->engine == false || $op == false)
		{
			// check DB connection
			if ($this->dblink == false) die("Error starting WackoWiki engine: no database connection established.");

			require("classes/wacko.php");
			$this->engine = new Wacko($this->config, $this->dblink);
			$this->engine->headerCount = 0;

			if ($this->cache == true)
			{
				$this->cache->wacko		= & $this->engine;
				$this->engine->cache	= & $this->cache;
			}
			return $this->engine;
		}
		else if ($this->engine == true && $op == "run")
		{
			return $this->engine->Run($this->page, $this->method);
		}
		else if ($this->engine == true && $op == "res")
		{
			if ($lang == false) $lang = $this->config["language"];

			$this->engine->LoadAllLanguages();
			$this->engine->LoadResource($lang);
			$this->engine->SetResource ($lang);
			$this->engine->SetLanguage ($lang);
			return true;
		}
		else
		{
			return false;
		}
	}

	// DEBUG INFO
	function Debug()
	{
		if ($this->config["debug"] >= 1 && strpos($this->method, ".xml") === false && $this->method != "print" && $this->method != "msword")
		{
			if (($this->config["debug_admin_only"] == true && $this->engine->IsAdmin() === true) || $this->config["debug_admin_only"] == false)
			{
				$overall_time = $this->GetMicroTime() - $this->timer;

				echo "<div id=\"debug\">".
					 "<p class=\"debug\">Program execution statistics</p>\n<ul>\n";

				if (function_exists("memory_get_usage")) if ($execmem = memory_get_usage())
					echo "<li>Memory allocated: ".(number_format(($execmem / (1024*1024)), 3))." MB </li>\n";

				echo "<li>Overall time taken: ".(number_format(($overall_time), 3))." sec. </li>\n";

				if ($this->config["debug"] >= 2)
				{
					echo "<li>Execution time: ".number_format($overall_time - $this->engine->queryTime, 3)." sec.</li>\n";
					echo "<li>SQL time: ".number_format($this->engine->queryTime, 3)." sec.</li>\n";
				}

				if ($this->config["debug"] >= 3)
				{
					echo "<li>SQL queries: ".count($this->engine->queryLog)."</li>\n";
					echo "<li>SQL queries dump follows".( $this->config["debug_sql_threshold"] > 0 ? " (&gt;".$this->config["debug_sql_threshold"]." sec.)" : "" ).":<ol>\n";

					foreach ($this->engine->queryLog as $query)
					{
						if ($query["time"] < $this->config["debug_sql_threshold"]) continue;

						echo "<li>";
						echo str_replace(array("<", ">"), array("&lt;", "&gt;"), $query["query"])."<br />";
						echo "[".number_format($query["time"], 4)." sec.]";
						echo "</li>\n";
					}

					echo "</ol>\n</li>\n";
				}
				echo "</ul>\n";

				if ($this->config["debug"] >= 2)
				{
					$user = $this->engine->GetUser();
					echo "<p class=\"debug\">Language data</p>\n<ul>\n";
					echo "<li>Multilanguage: ".($this->config["multilanguage"] == 1 ? 'true' : 'false')."</li>\n";
					echo "<li>HTTP_ACCEPT_LANGUAGE set: ".(isset($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? 'true' : 'false')."</li>\n";
					echo "<li>HTTP_ACCEPT_LANGUAGE value: ".$_SERVER['HTTP_ACCEPT_LANGUAGE']."</li>\n";
					echo "<li>HTTP_ACCEPT_LANGUAGE chopped value: ".strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2))."</li>\n";
					echo "<li>User language set: ".(isset($user["lang"]) ? 'true' : 'false')."</li>\n";
					echo "<li>User language value: ".(isset($user["lang"]) ? $user["lang"]: "")."</li>\n";
					echo "<li>Config language: ".$this->config["language"]."</li>\n";
					echo "<li>User selected language: ".(isset($this->engine->userlang) ? $this->engine->userlang : "")."</li>\n";
					echo "</ul>\n";
				}
				echo "</div >\n";
			}
			else return;
		}
		else return;
	}
}

?>