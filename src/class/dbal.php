<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// DATABASE ABSTRACT LAYER

abstract class Dbal // need to be extended by Settings to be usable
{
	const SQL_DATE_FORMAT = 'Y-m-d H:i:s';
	const SQL_DATE_NULL = '0000-00-00 00:00:00';
	private $db = null;
	private $result = null;
	private $sqlfile;
	public $query_time = 0;
	public $query_log = [];
	public $affected_rows;

	function __construct()
	{
		if (!$this->db)
		{
			$this->db = match ($this->db_driver)
			{
				'sqlite'					=> new DbSqlite	($this),
				'mysql_pdo', 'sqlite_pdo'	=> new DbPDO	($this),
				default						=> new DbMysqli	($this),
			};

			// change the current SQL mode at runtime
			$sql_modes = match((int) $this->sql_mode) {
				1		=> SQL_MODE_LAX[$this->db_vendor],
				2		=> SQL_MODE_STRICT[$this->db_vendor],
				default	=> 0, // server SQL mode
			};

			if ($sql_modes)
			{
				$this->db->query("SET SESSION sql_mode = '$sql_modes'");
			}

			// Set database collation
			if ($this->db_collation && $this->db_driver != 'sqlite')
			{
				$this->db->query("SET collation_connection = '$this->db_collation'");
			}
		}
	}

	function quote($string): string
	{
		return $this->db->quote($string);
	}

	function q($data): string
	{
		return "'" . $this->quote($data) . "'";
	}

	function date($t = null): string
	{
		Ut::is_empty($t) && $t = time();
		is_string($t) && $t = strtotime($t);

		return gmdate(self::SQL_DATE_FORMAT, (int) $t);
	}

	function utc_dt()
	{
		return match ($this->db_driver)
		{
			'sqlite', 'sqlite_pdo'	=> "datetime('now')",
			default					=> "UTC_TIMESTAMP()",
		};
	}

	function date_sub(int $value, string $interval): string
	{
		if ($this->sqlite)
		{
			return match ($interval)
			{
				'days'		=> "datetime('now', '-" . $value . " days')",
				'seconds'	=> "datetime('now', '-" . $value . " seconds')",
			};
		}
		else
		{
			return match ($interval)
			{
				'days'		=> 'DATE_SUB(UTC_TIMESTAMP(), INTERVAL ' . $value . ' DAY)',
				'seconds'	=> 'DATE_SUB(UTC_TIMESTAMP(), INTERVAL ' . $value . ' SECOND)',
			};
		}
	}

	function binary()
	{
		return match ($this->db_driver)
		{
			'sqlite', 'sqlite_pdo'	=> 'TEXT', // TODO: https://www.sqlite.org/lang_expr.html#castexpr
			default					=> 'BINARY',
		};
	}

	function collate()
	{
		return match ($this->db_driver)
		{
			'sqlite', 'sqlite_pdo'	=> 'NOCASE',
			default					=> 'utf8mb4_unicode_520_ci',
		};
	}

	function limit()
	{
		return match ($this->db_driver)
		{
			'sqlite', 'sqlite_pdo'	=> '',
			default					=> 'LIMIT 1',
		};
	}

	function is_null_date($t): bool
	{
		return Ut::is_empty($t) || !$t || $t === self::SQL_DATE_NULL;
	}

	function sql_query($query, $debug = 0)
	{
		if ($debug)
		{
			echo "(QUERY: $query)";
		}

		if ($this->debug >= 2)
		{
			$start = microtime(true);
		}

		$result = $this->db->query($query);

		$this->affected_rows = ($result !== false)? $this->db->affected_rows($result) : -1;

		if ($this->debug >= 2)
		{
			$time = microtime(true) - $start;
			$this->query_time += $time;

			if ($this->debug >= 3)
			{
				$this->query_log[] = [
					$query,
					$time,
					$this->affected_rows,
					Ut::backtrace(),
				];
			}
		}

		return $result;
	}

	function load_all($query, $docache = false)
	{
		// retrieving from cache
		if ($this->cache_sql && $docache)
		{
			if ($data = $this->get_cache($query))
			{
				return $data;
			}
		}

		$data = [];

		// retrieving from db
		if ($result = $this->sql_query($query))
		{
			while ($row = $this->db->fetch_assoc($result))
			{
				$data[] = $row;
			}

			$this->db->free_result($result);
		}

		// saving to cache
		if ($this->cache_sql && $docache)
		{
			$this->put_cache($data);
		}

		return $data;
	}

	function load_single($query, $docache = false)
	{
		if ($data = $this->load_all($query, $docache))
		{
			return $data[0];
		}

		return null;
	}

	// sql cache:

	// retrieve and unserialize cached sql data if available
	private function get_cache($query)
	{
		// store data for oncoming put_cache
		$this->sqlfile = $this->sql_cache_id($query);

		clearstatcache();

		if ($timestamp = @filemtime($this->sqlfile))
		{
			if (time() - $timestamp <= $this->cache_sql_ttl)
			{
				if ($text = file_get_contents($this->sqlfile))
				{
					$data = Ut::unserialize($text);
					// re @: if unserialize fails - it's OK and need not propagate further
					$this->affected_rows = @$data['affected_rows'];
					unset($data['affected_rows']);

					return $data;
				}
			}
		}

		return false;
	}

	// save serialized sql results
	private function put_cache($data): void
	{
		$data['affected_rows'] = $this->affected_rows;
		file_put_contents($this->sqlfile, Ut::serialize($data));
		chmod($this->sqlfile, CHMOD_SAFE);
	}

	// Invalidate the SQL cache
	function invalidate_sql_cache(): void
	{
		if ($this->cache_sql)
		{
			$past = time() - $this->cache_sql_ttl - 1;

			foreach (Ut::file_glob(CACHE_SQL_DIR, '*') as $file)
			{
				touch($file, $past); // touching is faster than unlinking
			}
		}
	}

	private function sql_cache_id($query)
	{
		// Remove extra whitespace while protecting quoted data
		$query = preg_replace_callback('/(\s+)|(^[\s;]+|[\s;]+$)|\'(\\\\\'|\\\\\\\\|[^\'])*\'|"(\\\\"|\\\\\\\\|[^"])*"/',
			function ($x)
			{
				if (!empty($x[1]))
				{
					return ' ';
				}

				if (!empty($x[2]))
				{
					return '';
				}

				return $x[0];
			}, $query);

		return Ut::join_path(CACHE_SQL_DIR, Ut::http64_encode(hash('sha1', $query, true)));
	}

	// low level stuff:
	// used (exclusively, as of 20160705) by lib/bad_behaviour/bad-behaviour-wackowiki.php
	function ll_query($query)
	{
		return $this->db->query($query);
	}

	function free_result($results)
	{
		return $this->db->free_result($results);
	}

	function fetch_assoc($results)
	{
		return $this->db->fetch_assoc($results);
	}

	function affected_rows($results)
	{
		return $this->db->affected_rows($results);
	}

}
