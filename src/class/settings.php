<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class Settings extends Dbal implements ArrayAccess
{
	private $config = [];
	private $changed = [];
	private $cachefile;

	public function __construct()
	{
		$this->cachefile = Ut::join_path(CACHE_CONFIG_DIR, 'config.php');

		// retrieve and unserialize cached settings data
		clearstatcache();

		// do not read invalidated (by x-bits) or non-writable cachefile
		if (!((@fileperms($this->cachefile) & 0111)
			&& is_writable($this->cachefile)
			&& ($text = file_get_contents($this->cachefile))
			&& ($this->config = Ut::unserialize($text))))
		{
			// for config_defaults
			$found_rewrite_extension = ((function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules()))
										|| ((getenv('HTTP_MOD_ENV') === 'on') && (getenv('HTTP_MOD_REWRITE') === 'on')));

			require_once CONFIG_DEFAULTS;

			if (filesize(CONFIG_FILE) <= 0)
			{
				$this->config = $wacko_config_defaults;
				return; // ready for installer
			}

			require CONFIG_FILE;
			$this->config = array_merge($wacko_config_defaults, $wacko_config);

			if (!isset($this->config['wacko_version']))
			{
				return; // ready for installer
			}

			if ($this->wacko_version != WACKO_VERSION && (!$this->system_seed || strlen($this->system_seed) < 20))
			{
				die('WackoWiki fatal error: system_seed in config.php is empty or too short. Please, use 20+ *random* characters to define this variable.');
			}

			$this->system_seed_hash = hash('sha1', $this->system_seed);

			// support legacy database setting names, XXX: remove it with next major 6.1 release
			if (isset($this->config['wacko_version']) && version_compare($this->config['wacko_version'], '6.0.22', '<'))
			{
				$this->db_driver	= $this->database_driver;
				$this->db_host		= $this->database_host;
				$this->db_port		= $this->database_port;
				$this->db_name		= $this->database_database;
				$this->db_user		= $this->database_user;
				$this->db_password	= $this->database_password;
				$this->db_collation	= $this->database_collation;
				$this->db_charset	= $this->database_charset;
				$this->db_engine	= $this->database_engine;
			}

			if (!RECOVERY_MODE)
			{
				// connecting to db
				parent::__construct();

				// retrieving configuration data from db
				if (!($result = $this->load_all(
					"SELECT config_name, config_value FROM {$this->table_prefix}config")))
				{
					die('Error loading WackoWiki config data: database `config` table is empty.');
				}

				foreach ($result as $row)
				{
					$this->config[$row['config_name']] = $row['config_value'];
				}

				// retrieving system user ID from db
				if (!($result = $this->load_single(
					"SELECT user_id FROM {$this->table_prefix}user WHERE user_name = 'System' LIMIT 1")))
				{
					die("Error loading WackoWiki config data: User 'System' is missing in `user` table.");
				}

				$this->config['system_user_id'] = $result['user_id'];

				// retrieving usergroups data from db
				if (!($result = $this->load_all(
						"SELECT
							g.group_name,
							u.user_id,
							u.user_name
						FROM
							{$this->table_prefix}usergroup_member gm
								INNER JOIN {$this->table_prefix}user u ON (gm.user_id = u.user_id)
								INNER JOIN {$this->table_prefix}usergroup g ON (gm.group_id = g.group_id)")))
				{
					die('Error loading WackoWiki usergroups data: database `usergroup` table is empty.');
				}

				$this->groups	= [];
				$ug				= [];

				foreach ($result as $row)
				{
					// groups array
					$this->config['groups'][$row['group_name']][] = $row['user_id'];

					$ug[$row['group_name']][] = $row['user_name'];
				}

				// legacy for ACL list
				$this->aliases = [];

				foreach ($ug as $group => $members)
				{
					$this->config['aliases'][$group] = implode('\n', $members);
				}

				$prefix = '';

				foreach (explode('.', parse_url($this->base_url, PHP_URL_HOST)) as $part)
				{
					$prefix .= ucfirst(strtolower($part));
				}

				$prefix .= substr(base64_encode(hash('sha1', $this->base_url . $this->system_seed_hash, true)), 1, 6);

				$this->cookie_prefix		= preg_replace('/[^a-z\d]+/i', '', $prefix);
				$this->config['base_path']	= $this->get_base_url($this->canonical);

				// cache to file
				if ($this->wacko_version == WACKO_VERSION)
				{
					ksort($this->config, SORT_STRING);
					$text = Ut::serialize($this->config, JSON_PRETTY_PRINT);
					// unable to write cache file considered are 'turn config caching off' feature
					@file_put_contents($this->cachefile, $text);
					// mark cache as valid - set x-bits by copying r-bits in them, see fileperms() above
					@chmod($this->cachefile, CHMOD_SAFE | ((CHMOD_SAFE >> 2) & 0111));
				}
			}
		}

		parent::__construct(); // open db

		$this->rebase_url();

		// if .htaccess tell us actual info on mod_rewrite status - use it
		if (getenv('HTTP_MOD_ENV') === 'on' && AUTO_REWRITE)
		{
			$this->rewrite_mode = (getenv('HTTP_MOD_REWRITE') === 'on');
		}
	}

	// for setup/ only
	public function steal_config()
	{
		return $this->config;
	}

	public function rebase_url()
	{
		$this->theme_url	= $this->base_path . Ut::join_path(THEME_DIR, $this->theme) . '/';
		$this->cookie_path	= preg_replace('|https?://[^/]+|i', '', $this->base_url);
	}

	// { $config['ttt'] = 1; } === { $config->ttt = 1; }
	// furthermore: all [] and -> accesses - get/set/isset/unset - are identical

	public function offsetSet($i, $value): void
	{
		$this->__set($i, $value);
	}

	public function offsetExists($i): bool
	{
		return $this->__isset($i);
	}

	public function offsetUnset($i): void
	{
		$this->__unset($i);
	}

	public function offsetGet($i)
	{
		return $this->__get($i);
	}

	public function __get($i)
	{
		//return array_key_exists($i, $this->config)? $this->config[$i] : null;
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

	function invalidate_config_cache()
	{
		// we load cache only if x bits set, so clearing 0111 bits will invalidate
		// cachefile may be missing, it's perfectly normal
		@chmod($this->cachefile, CHMOD_SAFE);
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
				$values[]				= "(0, '$name', " . $this->q($value) . ")";
				$this->config[$name]	= $value;

				unset($this->changed[$name]);
			}
		}

		// to update existing values we use INSERT ... ON DUPLICATE KEY UPDATE
		// https://dev.mysql.com/doc/refman/5.7/en/insert-on-duplicate.html

		if ($values)
		{
			$this->sql_query(
				"INSERT INTO {$this->table_prefix}config (config_id, config_name, config_value)
					VALUES " . implode(', ', $values) . "
					ON DUPLICATE KEY UPDATE
						config_name		= VALUES(config_name),
						config_value	= VALUES(config_value)");

			if ($delete_cache)
			{
				$this->invalidate_config_cache();
			}
		}
	}

	// CHECK WEBSITE LOCKING
	function is_locked($file = SITE_LOCK)
	{
		return substr(@file_get_contents($file), 0, 1) === '1';
	}

	// lock / unlock
	// writes value to lock file
	//		file	= lock file in config folder
	function lock($file = SITE_LOCK)
	{
		@file_put_contents($file, ($this->is_locked($file)? '0' : '1'));
	}

	// returns the full absolute or relative URL to the directory where WackoWiki is installed
	function get_base_url($absolute = null)
	{
		$base_url = ($_SERVER['SERVER_PORT'] == 443
				? 'https'
				: 'http'
			) . '://' .
			$_SERVER['SERVER_NAME'] .
			(!in_array($_SERVER['SERVER_PORT'], [80, 443])
				? ':' . $_SERVER['SERVER_PORT']
				: ''
			);
		$base_path = (($path = str_replace('//', '/', trim(strtr(dirname($_SERVER['SCRIPT_NAME']), '\\', '/'), '/')))
				? '/' . $path
				: ''
			) . '/';

		return ($absolute ? $base_url : '') . $base_path;
	}

}
