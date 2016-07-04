<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class Cache
{
	private $db;
	private $page;
	private $hash;
	private $method;
	private $query;
	private $file;
	private $caching;

	public function __construct(&$config)
	{
		$this->db			= & $config;
		$this->timer		= microtime(1);
	}

	// Get page content from cache
	private function load_page($page, $method, $query, &$timestamp)
	{
		// store data for save_page()
		list($this->page, $this->hash) = $this->normalize_page($page);
		$this->method	= $method;
		$this->query	= $query;
		$this->file		= $this->construct_id($this->page, $method, $query);

		clearstatcache();

		if (($timestamp = @filemtime($this->file)))
		{
			if (time() - $timestamp <= $this->db->cache_ttl)
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
	private function save_page($data)
	{
		file_put_contents($this->file, $data);
		chmod($this->file, 0644);

		$this->db->sql_query(
			"INSERT INTO ".$this->db->table_prefix."cache SET ".
				"name	= ".$this->db->q($this->hash).", ".
				"method	= ".$this->db->q($this->method).", ".
				"query	= ".$this->db->q($this->query));
				// TIMESTAMP type is filled automatically by MySQL
	}

	// Invalidate the page cache
	public function invalidate_page($page)
	{
		if ($this->db->cache)
		{
			list($page, $hash) = $this->normalize_page($page);

			$params	= $this->db->load_all(
				"SELECT method, query ".
					"FROM ".$this->db->table_prefix."cache ".
					"WHERE name = ".$this->db->q($hash));

			dbg('invalidate_page', $page);

			$past = time() - $this->db->cache_ttl - 1;

			foreach ($params as $param)
			{
				$file	= $this->construct_id($page, $param['method'], $param['query']);
				$x		= @touch($file, $past); // touching is faster than unlinking

				dbg('invalidate_page', $page, $param['method'], $param['query'], '=>', $x);
			}

			$this->db->sql_query(
				"DELETE FROM ".$this->db->table_prefix."cache ".
				"WHERE name = ".$this->db->q($hash));
		}
	}

	private function normalize_page($page)
	{
		$page = strtolower(str_replace('\\', '', str_replace("'", '', str_replace('_', '', $page))));
		return [$page, hash('sha1', $page)];
	}

	private function construct_id($page, $method, $query)
	{
		return join_path(CACHE_PAGE_DIR, hash('sha1', ($page . '_' . $method . '_' . $query)));
	}

	// Check http-request. May be, output cached version.
	private function check_http_request($page, $method)
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

	// allow main engine to disable caching
	public function disable_cache()
	{
		$this->caching = 0;
	}

	public function check($page, $method)
	{
		$this->caching = 0;
		if ($this->db->cache && $_SERVER['REQUEST_METHOD'] != 'POST' && $method != 'edit' && $method != 'watch')
		{
			// cache only for anonymous user
			if (!isset($_COOKIE[$this->db->cookie_prefix . 'auth' . '_' . $this->db->cookie_hash]))
			{
				$this->caching = $this->check_http_request($page, $method);
			}
		}
	}

	public function store()
	{
		if ($this->caching)
		{
			$data = ob_get_contents();

			if (!empty($data))
			{
				$this->save_page($data);
			}
			else
			{
				// FALSE, then output buffering is not active
			}
		}
	}

}
