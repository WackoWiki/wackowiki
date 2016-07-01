<?php

if (!defined('IN_WACKO'))
{
	exit('No direct script access allowed');
}

class Cache
{
	var $cache_ttl	= 600;
	var $cache_dir	= '_cache/';
	var $debug		= 0;
	var $page;
	var $hash;
	var $method;
	var $query;
	var $file;
	var $sqlfile;

	// Constructor
	function __construct($cache_dir, $cache_ttl, $debug)
	{
		$this->cache_dir	= $cache_dir;
		$this->cache_ttl	= $cache_ttl;
		$this->debug		= $debug;
		$this->timer		= microtime(1);
	}

	// retrieve and unserialize cached sql data if available
	function load_sql($query)
	{
		// store data for oncoming save_sql
		$this->sqlfile = $this->sql_cache_id($query);

		clearstatcache();
		if (($timestamp = @filemtime($this->sqlfile)))
		{
			if (time() - $timestamp <= $this->wacko->config->cache_sql_ttl)
			{
				if (($contents = file_get_contents($this->sqlfile)))
				{
					return unserialize($contents);
				}
			}
		}

		return false;
	}

	// save serialized sql results
	function save_sql($data)
	{
		file_put_contents($this->sqlfile, serialize($data));
		chmod($this->sqlfile, 0644);
	}

	// Invalidate the SQL cache
	function invalidate_sql()
	{
		if ($this->wacko->config->cache_sql)
		{
			$past = time() - $this->wacko->config->cache_sql_ttl - 1;
			foreach (file_glob($this->wacko->config->cache_dir, CACHE_SQL_DIR, '*') as $file)
			{
				touch($file, $past); // touching is faster than unlinking
			}
		}
	}

	function sql_cache_id($query)
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

		return join_path($this->cache_dir, CACHE_SQL_DIR, hash('sha1', $query));
	}

	// http cache =====================================================

	// Get page content from cache
	function load_page($page, $method, $query, &$timestamp)
	{
		// store data for save_page()
		list($this->page, $this->hash) = $this->normalize_page($page);
		$this->method	= $method;
		$this->query	= $query;
		$this->file		= $this->construct_id($this->page, $method, $query);

		clearstatcache();
		if (($timestamp = @filemtime($this->file)))
		{
			if (time() - $timestamp <= $this->cache_ttl)
			{
				if (($contents = file_get_contents($this->file)))
				{
					return $contents."\n<!-- WackoWiki Caching Engine: page cached at ".date('Y-m-d H:i:s', $timestamp)." -->\n";
				}
			}
		}

		return false;
	}

	// Store page content to cache
	function save_page($data)
	{
		file_put_contents($this->file, $data);
		chmod($this->file, 0644);

		$this->wacko->sql_query(
			"INSERT INTO ".$this->wacko->config->table_prefix."cache SET ".
			"name	= ".$this->wacko->q($this->hash).", ".
			"method	= ".$this->wacko->q($this->method).", ".
			"query	= ".$this->wacko->q($this->query));
			// TIMESTAMP type is filled automatically by MySQL
	}

	// Invalidate the page cache
	function invalidate_page($page)
	{
		if ($this->wacko->config->cache)
		{
			list($page, $hash) = $this->normalize_page($page);

			$params	= $this->wacko->load_all(
				"SELECT method, query ".
					"FROM ".$this->wacko->config->table_prefix."cache ".
					"WHERE name = ".$this->wacko->q($hash));

			$this->log('invalidate_page_cache page='.$page);
			$this->log('invalidate_page_cache query='.$sql);
			$this->log('invalidate_page_cache count params='.count($params));

			$past = time() - $this->cache_ttl - 1;
			foreach ($params as $param)
			{
				$file = $this->construct_id($page, $param['method'], $param['query']);

				$this->log('invalidate_page_cache delete='.$file);

				@touch($file, $past); // touching is faster than unlinking
			}

			$this->wacko->sql_query(
				"DELETE FROM ".$this->wacko->config->table_prefix."cache ".
				"WHERE name = ".$this->wacko->q($hash));

			$this->log('invalidate_page_cache end');
		}
	}

	function normalize_page($page)
	{
		$page = strtolower(str_replace('\\', '', str_replace("'", '', str_replace('_', '', $page))));
		return [$page, hash('sha1', $page)];
	}

	function construct_id($page, $method, $query)
	{
		return join_path($this->cache_dir, CACHE_PAGE_DIR, hash('sha1', ($page . '_' . $method . '_' . $query)));
	}

	function log($msg)
	{
		// TODO: avoid unnecessary cache log calls
		// TODO: check if dir is writable
		// Warning: file_put_contents(_cache/log) [function.file-put-contents]: failed to open stream: Permission denied
		if ($this->debug > 5)
		{
			$file = $this->cache_dir . 'log';
			@file_put_contents($file, date('ymdHis ') . $msg . "\n", FILE_APPEND);
		}
	}

	// Check http-request. May be, output cached version.
	function check_http_request($page, $method)
	{
		if (!$page)
		{
			return false;
		}

		$_query = [];
		foreach ($_GET as $k => $v)
		{
			$_query[$k] = $v;
		}
		ksort($_query);

		$query = '';
		foreach ($_query as $k => $v)
		{
			$query .= urlencode($k) . '=' . urlencode($v) . '&';
		}

		$this->log('check_http_request query='.$query);

		// check cache
		if (($cached_page = $this->load_page($page, $method, $query, $mtime)))
		{
			$this->log('check_http_request incache mtime='.$mtime);

			$gmt	= gmdate('D, d M Y H:i:s \G\M\T', $mtime);
			$etag	= @$_SERVER['HTTP_IF_NONE_MATCH'];
			$lastm	= @$_SERVER['HTTP_IF_MODIFIED_SINCE'];

			if (($p = strpos($lastm, ';')))
			{
				$lastm = substr($lastm, 0, $p);
			}

			if ($_SERVER['REQUEST_METHOD'] == 'GET') // may be we need HEAD support ???
			{
				if (!$lastm && !$etag);
				else if ($lastm && $gmt != $lastm);
				else if ($etag && $gmt != trim($etag, '\"'));
				else
				{
					header('HTTP/1.1 304 Not Modified');
					die();
				}

				// HTTP header with right Charset settings
				// TODO: How to determine the right charset in advance?
				// header('Content-Type: text/html; charset='.$this->charset);

				// making the internal charset declaration the sole source of character encoding information
				// (e.g. <meta charset="windows-1252" />)
				ini_set('default_charset', null);

				header('Last-Modified: '.$gmt);
				header('ETag: "'.$gmt.'"');
				//header('Content-Type: text/xml');
				//header('Content-Length: '.strlen($cached));
				//header('Cache-Control: max-age=0');
				//header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time()));

				echo $cached_page;

				// how much time script take
				if ($this->debug >= 1 && strpos($method, '.xml') === false)
				{
					$ddd = microtime(1);
					echo '<div id="debug" class="debug">cache time: '.(number_format(($ddd-$this->timer), 3)).' s<br />';
					echo '</div>';
				}

				if (strpos($method, '.xml') === false)
				{
					echo '</body></html>';
				}

				die();
			}
		}

		return true;
	}

	function purge($directory, $ttl)
	{
		$n = 0;
		$now = time();
		clearstatcache();

		foreach (file_glob($this->wacko->config->cache_dir, $directory, '*') as $file)
		{
			if ($now - filemtime($file) > $ttl && unlink($file))
			{
				++$n;
			}
		}

		return $n;
	}
}
