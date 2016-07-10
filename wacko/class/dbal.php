<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// STS: backward compat, it's here to be removed sometime
function quote($dblink, $string)
{
	return $dblink->quote($string);
}


// DATABASE ABSTRACT LAYER

abstract class Dbal // need to be extended by Settings to be usable
{
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
			switch ($this->database_driver)
			{
				case 'mysql_pdo':
					$this->db = new DbPDO($this);
					break;

				default:
					$this->database_driver = 'mysqli_legacy';
					// FALLTHRU
				case 'mysqli_legacy':
					$this->db = new DbMysqli($this);
					break;
			}

			// Change the current SQL mode at runtime
			$sql_modes = $this->sql_mode_strict?  SQL_MODE_STRICT : SQL_MODE_PERMISSIVE;
			$this->db->query("SET SESSION sql_mode='$sql_modes'");
		}
	}

	function quote($string)
	{
		return $this->db->quote($string);
	}

	function q($data)
	{
		return "'" . $this->quote($data) . "'";
	}

	function sql_query($query, $debug = 0)
	{
		if ($debug)
		{
			echo "(QUERY: $query)";
		}

		if ($this->debug >= 2)
		{
			$start = microtime(1);
		}

		$result = $this->db->query($query);

		if ($this->debug >= 2)
		{
			$time = microtime(1) - $start;
			$this->query_time += $time;

			if ($this->debug >= 3)
			{
				$this->query_log[] = [
					'query'		=> $query,
					'time'		=> $time
				];
			}
		}

		$this->affected_rows = ($result !== false)? $this->db->affected_rows($result) : -1;

		return $result;
	}

	function load_all($query, $docache = false)
	{
		// retrieving from cache
		if ($this->cache_sql && $docache)
		{
			if (($data = $this->get_cache($query)))
			{
				return $data;
			}
		}

		$data = [];

		// retrieving from db
		if (($result = $this->sql_query($query)))
		{
			while (($row = $this->db->fetch_assoc($result)))
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
		if (($data = $this->load_all($query, $docache)))
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

		if (($timestamp = @filemtime($this->sqlfile)))
		{
			if (time() - $timestamp <= $this->cache_sql_ttl)
			{
				if (($text = file_get_contents($this->sqlfile)))
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
	private function put_cache($data)
	{
		$data['affected_rows'] = $this->affected_rows;
		file_put_contents($this->sqlfile, Ut::serialize($data, JSON_PRETTY_PRINT));
		chmod($this->sqlfile, 0644);
	}

	// Invalidate the SQL cache
	function invalidate_sql_cache()
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
					return ' ';
				if (!empty($x[2]))
					return '';
				return $x[0];
			}, $query);

		return Ut::join_path(CACHE_SQL_DIR, hash('sha1', $query));
	}

	// low level stuff:
	// used (exclusively, as of 20160705) by lib/bad_behavior/bad-behavior-wackowiki.php
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
