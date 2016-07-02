<?php

if (!defined('IN_WACKO'))
{
	exit('No direct script access allowed');
}

class Cache
{
	var $cache_ttl	= 600;
	var $page;
	var $hash;
	var $method;
	var $query;
	var $file;
	var $sqlfile;

	// Constructor
	function __construct($cache_ttl)
	{
		$this->cache_ttl	= $cache_ttl;
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
			foreach (file_glob(CACHE_SQL_DIR, '*') as $file)
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

		return join_path(CACHE_SQL_DIR, hash('sha1', $query));
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

			dbg('invalidate_page', $page);

			$past = time() - $this->cache_ttl - 1;
			foreach ($params as $param)
			{
				$file = $this->construct_id($page, $param['method'], $param['query']);

				$x = @touch($file, $past); // touching is faster than unlinking

				dbg('invalidate_page', $page, $param['method'], $param['query'], '=>', $x);
			}

			$this->wacko->sql_query(
				"DELETE FROM ".$this->wacko->config->table_prefix."cache ".
				"WHERE name = ".$this->wacko->q($hash));
		}
	}

	function normalize_page($page)
	{
		$page = strtolower(str_replace('\\', '', str_replace("'", '', str_replace('_', '', $page))));
		return [$page, hash('sha1', $page)];
	}

	function construct_id($page, $method, $query)
	{
		return join_path(CACHE_PAGE_DIR, hash('sha1', ($page . '_' . $method . '_' . $query)));
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

		// check cache
		if (($cached_page = $this->load_page($page, $method, $query, $mtime)))
		{
			dbg('check_http_request', $page, $method, $query, 'found!');

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
					dbg('not modified');
					header('HTTP/1.1 304 Not Modified');
					die();
				}

				// HTTP header with right Charset settings
				// TODO: other than .html?
				if (($head = strpos($cached_page, '</head>')) !== false)
				{
					$head = substr($cached_page, 0, $head);
					if (preg_match('#<html[^/>]*>#', $head) &&
						preg_match('#<meta\s+charset="([^"]+)"\s*/>#', $head, $match))
					{
						header('Content-Type: text/html; charset=' . $match[1]);
					}
				}

				ini_set('default_charset', null);

				header('Last-Modified: '.$gmt);
				header('ETag: "'.$gmt.'"');
				//header('Content-Type: text/xml');
				//header('Content-Length: '.strlen($cached));
				//header('Cache-Control: max-age=0');
				//header('Expires: '.gmdate('D, d M Y H:i:s \G\M\T', time()));

				echo $cached_page;

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

		foreach (file_glob($directory, '*') as $file)
		{
			if ($now - filemtime($file) > $ttl && unlink($file))
			{
				++$n;
			}
		}

		return $n;
	}
}
