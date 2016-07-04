<?php

if (!defined('IN_WACKO'))
{
	die('No direct script access allowed');
}

class Settings implements ArrayAccess
{
	private $config = [];
	private $changed = [];
	private $dblink;
	private $cachefile;

	public function __construct($secondary = true)
	{
		$this->cachefile = CACHE_CONFIG_DIR . '/' . 'config.php';

		// retrieve and unserialize cached settings data
		clearstatcache();

		if (!(@fileperms($this->cachefile) & 0111) || !($data = file_get_contents($this->cachefile)) || !($this->config = unserialize($data)))
		{
			// for config_defaults
			$found_rewrite_extension = (function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules()));

			require_once(CONFIG_DEFAULTS);

			if (@filesize(CONFIG_FILE) <= 0)
			{
				$this->config = $wacko_config_defaults;
				return; // ready for installer
			}

			require(CONFIG_FILE);
			$this->config = array_merge($wacko_config_defaults, $wacko_config);

			if (!isset($this->config['wacko_version']))
			{
				return; // ready for installer
			}

			if ($this->wacko_version != WACKO_VERSION && (!$this->system_seed || strlen($this->system_seed) < 20))
			{
				die("WackoWiki fatal error: system_seed in config.php is empty or too short. Please, use 20+ *random* characters to define this variable.");
			}

			$this->system_seed = hash('sha1', $this->system_seed);

			if ($secondary)
			{
				// connecting to db
				$this->dbal();

				// retrieving configuration data from db
				if (!($result = sql_query($this->dblink,
						"SELECT config_name, config_value FROM {$this->table_prefix}config", 0)))
				{
					die("Error loading WackoWiki config data: database `config` table is empty.");
				}

				while (($row = fetch_assoc($result)))
				{
					$this->config[$row['config_name']] = $row['config_value'];
				}

				free_result($result);

				// retrieving usergroups data from db
				if (!($result = sql_query($this->dblink,
						"SELECT
							g.group_name,
							u.user_name
						FROM
							{$this->table_prefix}usergroup_member gm
								INNER JOIN {$this->table_prefix}user u ON (gm.user_id = u.user_id)
								INNER JOIN {$this->table_prefix}usergroup g ON (gm.group_id = g.group_id)", 0)))
				{
					die("Error loading WackoWiki usergroups data: database `group` table is empty.");
				}

				$ug = [];

				while (($row = fetch_assoc($result)))
				{
					$ug[$row['group_name']][] = $row['user_name'];
				}

				free_result($result);

				foreach ($ug as $group => $users)
				{
					$this->config['aliases'][$group] = implode('\n', $users);
				}

				// cache to file
				if ($this->wacko_version == WACKO_VERSION)
				{
					$data = serialize($this->config);
					@file_put_contents($this->cachefile, $data);
					@chmod($this->cachefile, 0755); // mark cache as valid
				}
			}
		}

		$this->dbal();

		// convenient config additions
		$this->theme_url	= $this->base_url . join_path(THEME_DIR, $this->theme) . '/';
		$this->user_table	= $this->table_prefix . 'user';
		$this->cookie_hash	= hash('sha1', $this->base_url . $this->system_seed);
		$this->cookie_path	= preg_replace('|https?://[^/]+|i', '', $this->base_url);
	}

	// { $config['ttt'] = 1; } === { $config->ttt = 1; }
	// furthermore: all [] and -> accesses - get/set/isset/unset - are identical

	public function offsetSet($i, $value)
	{
		$this->__set($i, $value);
	}

	public function offsetExists($i)
	{
		return $this->__isset($i);
	}

	public function offsetUnset($i)
	{
		$this->__unset($i);
	}

	public function offsetGet($i)
	{
		return $this->__get($i);
	}

	public function __get($i)
	{
		//$trace = debug_backtrace();
		//echo 'get property: ' . $i .  ' in ' . $trace[0]['file'] . ':' . $trace[0]['line'] . "\n";
		//return array_key_exists($i, $this->config)?  $this->config[$i] : null;
		return $this->config[$i];
	}

	public function __set($i, $value)
	{
		if (!isset($this->config[$i]) || $this->config[$i] !== $value)
		{
			$this->changed[$i] = 1;
		}

		$this->config[$i] = $value;
	}

	public function __isset($i)
	{
		//return array_key_exists($i, $this->config);
		return isset($this->config[$i]);
	}

	public function __unset($i)
	{
		unset($this->config[$i]);
	}

	function invalidate_cache()
	{
		// we load cache only if x bits set, so clearing 0111 bits will invalidate
		@chmod($this->cachefile, 0644);
	}

	// DATABASE ABSTRACT LAYER
	// Initialize DBAL for basic DB operations and connect to selected DB.
	function dbal()
	{
		if (!$this->dblink)
		{
			switch ($this->database_driver)
			{
				case 'mysql_pdo':
					$db_file = 'db/pdo.php';
					break;
				default:
					$this->database_driver = 'mysqli_legacy';
					// FALLTHRU
				case 'mysqli_legacy':
					$db_file = 'db/mysqli.php';
					break;
			}

			// load DBAL
			require($db_file);

			$this->dblink = connect($this->database_host, $this->database_user, $this->database_password,
					$this->database_database, $this->database_charset, $this->database_driver,
					$this->database_port, $this->sql_mode_strict);

			if (!$this->dblink)
			{
				die("Error loading WackoWiki DBAL: could not establish database connection.");
			}
		}

		return $this->dblink;
	}

	function set($name, $value, $delete_cache = true)
	{
		$config[$name] = $value;
		$this->_set($config, $delete_cache);
	}

	function _set($config, $delete_cache = true)
	{
		$values = [];

		foreach ($config as $name => $value)
		{
			if (!isset($this->config[$name]) || $this->config[$name] != $value || isset($this->changed[$name]))
			{
				$values[]				= "(0, '$name', '" . quote($this->dblink, $value) . "')";
				$this->config[$name]	= $value;

				unset($this->changed[$name]);
			}
		}

		// to update existing values we use INSERT ... ON DUPLICATE KEY UPDATE
		// http://dev.mysql.com/doc/refman/5.5/en/insert-on-duplicate.html

		if ($values)
		{
			sql_query($this->dblink,
				"INSERT INTO {$this->table_prefix}config (config_id, config_name, config_value)
					VALUES " . implode(', ', $values) . "
					ON DUPLICATE KEY UPDATE
						config_name		= VALUES(config_name),
						config_value	= VALUES(config_value)", 0);

			if ($delete_cache)
			{
				$this->invalidate_cache();
			}
		}
	}
}
