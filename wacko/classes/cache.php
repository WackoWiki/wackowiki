<?php

class Cache
{
	var $cache_ttl	= 600;
	var $cache_dir	= '_cache/';
	var $debug		= 0;

	//Constructor
	function __construct($cache_dir, $cache_ttl)
	{
		$this->cache_dir	= $cache_dir;
		$this->cache_ttl	= $cache_ttl;
		$this->timer		= $this->get_micro_time();

		if (isset($this->wacko->config['debug']))
		{
			$this->debug = $this->wacko->config['debug'];
		}
	}

	// save serialized sql results
	function save_sql($query, $data)
	{
		$filename	= $this->sql_cache_id($query);
		$sqldata	= serialize($data);

		file_put_contents($filename, $sqldata);
		chmod($filename, 0644);

		return true;
	}

	// retrieve and unserialize cached sql data
	function load_sql($query)
	{
		$filename = $this->sql_cache_id($query);

		if (!@file_exists($filename))
		{
			return false;
		}

		if ((time() - @filemtime($filename)) > $this->wacko->config['cache_sql_ttl'])
		{
			return false;
		}

		$fp		= fopen($filename, 'r');

		// check for false and empty strings
		if(($data	= fread($fp, filesize($filename))) === '')
		{
			return false;
		}

		fclose($fp);

		return unserialize($data);
	}

	function sql_cache_id($query)
	{
		return $this->cache_dir.CACHE_SQL_DIR.hash('md5', $query);
	}

	//Get page content from cache
	function get_cached($page, $method, $query)
	{
		$filename = $this->construct_id($page, $method, $query);

		if (!@file_exists($filename))
		{
			return false;
		}

		if ((time() - ($timestamp = @filemtime($filename))) > $this->cache_ttl)
		{
			return false;
		}

		$fp			= fopen($filename, 'r');

		// check for false and empty strings
		if(($contents = fread($fp, filesize($filename))) === '')
		{
			return false;
		}

		$contents	= "<!-- WackoWiki Caching Engine: page cached at ".date('Y-m-d H:i:s', $timestamp).", contents follows -->\n".$contents;
		fclose($fp);

		return $contents;
	}

	function construct_id($page, $method, $query)
	{
		$page = strtolower(str_replace('\\', '', str_replace("'", '', str_replace('_', '', rawurldecode($page)))));

		$this->log('construct_id page='.$page);
		$this->log('construct_id md5='.hash('md5', $page.'_'.$method.'_'.$query));

		$filename = $this->cache_dir.CACHE_PAGE_DIR.hash('md5', $page.'_'.$method.'_'.$query);
		return $filename;
	}

	//Get timestamp of content from cache
	function get_cached_time($page, $method, $query)
	{
		$filename = $this->construct_id($page, $method, $query);

		if (!@file_exists($filename))
		{
			return false;
		}

		if ((time() - @filemtime($filename)) > $this->cache_ttl)
		{
			return false;
		}

		return @filemtime($filename);
	}

	//Store content to cache
	function store_to_cache($data, $page = false, $method = false, $query = false)
	{
		if (!$page)
		{
			$page   = $this->page;
		}
		if (!$method)
		{
			$method = $this->method;
		}
		if (!$query)
		{
			$query  = $this->query;
		}

		$page		= strtolower(str_replace('\\', '', str_replace("'", '', str_replace('_', '', $page))));
		$filename	= $this->construct_id($page, $method, $query);

		file_put_contents($filename, $data);

		if ($this->wacko)
		{
			$this->wacko->query(
				"INSERT INTO ".$this->wacko->config['table_prefix']."cache SET ".
				"name  ='".quote($this->wacko->dblink, hash('md5', $page))."', ".
				"method='".quote($this->wacko->dblink, $method)."', ".
				"query ='".quote($this->wacko->dblink, $query)."'");
				// TIMESTAMP type is filled automatically by MySQL
		}

		@chmod($filename, octdec('0644'));

		return true;
	}

	//Invalidate the cache
	function cache_invalidate($page)
	{
		if ($this->wacko)
		{
			$page = strtolower(str_replace('\\', '', str_replace("'", '', str_replace('_', '', $page))));
			$this->log('cache_invalidate page='.$page);
			$this->log('cache_invalidate query='.
				"SELECT * ".
				"FROM ".$this->wacko->config['table_prefix']."cache ".
				"WHERE name ='".quote($this->wacko->dblink, hash('md5', $page))."'");

			$params = $this->wacko->load_all(
				"SELECT * ".
				"FROM ".$this->wacko->config['table_prefix']."cache ".
				"WHERE name ='".quote($this->wacko->dblink, hash('md5', $page))."'");

			$this->log('cache_invalidate count params='.count($params));

			foreach ($params as $param)
			{
				$filename = $this->construct_id($page, $param['method'], $param['query']);

				$this->log('cache_invalidate delete='.$filename);

				if (@file_exists($filename))
				{
					@unlink($filename);
				}
			}

			$this->wacko->query(
				"DELETE FROM ".$this->wacko->config['table_prefix']."cache ".
				"WHERE name ='".quote($this->wacko->dblink, hash('md5', $page))."'");

			$this->log('cache_invalidate end');

			return true;
		}
		else
		{
			return false;
		}
	}

	function log($msg)
	{
		if ($this->debug > 1)
		{
			$filename = $this->cache_dir.'log';

			file_put_contents($filename, $msg."\n", FILE_APPEND);
		}
	}

	//Check http-request. May be, output cached version.
	function check_http_request($page, $method)
	{
		if (!$page)
		{
			return false;
		}

		foreach ($_GET as $k => $v)
		{
			if ($k != 'v' && $k != 'page')
			{
				$_query[$k] = $v;
			}
		}

		if (isset($_query))
		{
			ksort($_query);
			reset($_query);

			foreach($_query as $k => $v)
			{
				if (!isset($query))
				{
					$query = '';
				}

				$query .= urlencode($k).'='.urlencode($v).'&';
			}
		}

		if (!isset($query))
		{
			$query = '';
		}

		$this->log('check_http_request query='.$query);

		//check cache
		if ($mtime = $this->get_cached_time($page, $method, $query))
		{
			$this->log('check_http_request incache mtime='.$mtime);

			$gmt	= gmdate('D, d M Y H:i:s \G\M\T', $mtime);
			$etag	= (isset($_SERVER['HTTP_IF_NONE_MATCH']) ? $_SERVER['HTTP_IF_NONE_MATCH'] : '');
			$lastm	= (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : '');

			if ($p = strpos($lastm, ";"))
			{
				$lastm = substr($lastm, 0, $p);
			}

			if ($_SERVER['REQUEST_METHOD'] == 'GET') //may be we need HEAD support ???
			{
				if (!$lastm && !$etag);
				else if ($lastm && $gmt != $lastm);
				else if ($etag && $gmt != trim($etag, '\"'));
				else
				{
					header ("HTTP/1.1 304 Not Modified");
					die();
				}

				$cached = $this->get_cached($page, $method, $query);
				header ("Last-Modified: ".$gmt);
				header ("ETag: \"".$gmt."\"");
				//header ("Content-Type: text/xml");
				//header ("Content-Length: ".strlen($cached));
				//header ("Cache-Control: max-age=0");
				//header ("Expires: ".gmdate('D, d M Y H:i:s \G\M\T', time()));
				echo ($cached);

				// how much time script take
				if ($this->debug >= 1 && strpos($method, '.xml') === false)
				{
					$ddd = $this->get_micro_time();
					echo ("<div class=\"debug\">cache time: ".(number_format(($ddd-$this->timer),3))." s<br />");
					echo "</div>";
				}

				if (strpos($method, '.xml') === false)
				{
					echo "</body></html>";
				}

				die();
			}
		}

		//We have no valid cached page
		$this->page		= $page;
		$this->method	= $method;
		$this->query	= $query;
		return true;
	}

	function output()
	{
		clearstatcache();

		if (!($mtime = $this->get_cached_time($this->page, $this->method, $this->query)))
		{
			$mtime = time();
		}

		$gmt = gmdate('D, d M Y H:i:s \G\M\T', $mtime);
		$res = &$this->result;
		header ("Last-Modified: ".$gmt);
		header ("ETag: \"".$gmt."\"");
		header ("Content-Type: text/xml");
		//header ("Content-Length: ".strlen($res));
		//header ("Cache-Control: max-age=0");
		//header ("Expires: ".gmdate('D, d M Y H:i:s \G\M\T', time()));

		echo $res;
		die();
	}

	function get_micro_time()
	{
		list($usec, $sec) = explode(' ', microtime());
		return ((float)$usec + (float)$sec);
	}

}

?>