<?php

class Cache
{
	var $cache_ttl	= 600;
	var $cache_dir	= "_cache/";
	var $debug		= 0;

	//Constructor
	function Cache($cache_dir, $cache_ttl)
	{
		$this->cache_dir	= $cache_dir;
		$this->cache_ttl	= $cache_ttl;
		$this->timer		= $this->GetMicroTime();

		if (isset($this->wacko->config['debug']))
			$this->debug = $this->wacko->config['debug'];
	}

	// save serialized sql results
	function SaveSQL($query, $data)
	{
		$filename	= $this->SQLCacheID($query);
		$sqldata	= serialize($data);

		file_put_contents($filename, $sqldata);
		chmod($filename, 0644);

		return true;
	}

	// retrieve and unserialize cached sql data
	function LoadSQL($query)
	{
		$filename = $this->SQLCacheID($query);

		if (!@file_exists($filename))
			return false;

		if ((time() - @filemtime($filename)) > $this->wacko->config['cache_sql_ttl'])
			return false;

		$fp		= fopen($filename, 'r');
		$data	= fread($fp, filesize($filename));
		fclose($fp);

		return unserialize($data);
	}

	function SQLCacheID($query)
	{
		return $this->cache_dir.CACHE_SQL_DIR.md5($query);
	}

	//Get page content from cache
	function GetCached($page, $method, $query)
	{
		$filename = $this->ConstructID($page, $method, $query);

		if (!@file_exists($filename))
			return false;

		if ((time() - ($timestamp = @filemtime($filename))) > $this->cache_ttl)
			return false;

		$fp			= fopen($filename, "r");
		$contents	= fread($fp, filesize($filename));
		$contents	= "<!-- WackoWiki Caching Engine: page cached at ".date('Y-m-d H:i:s', $timestamp).", contents follows -->\n".$contents;
		fclose($fp);

		return $contents;
	}

	function ConstructID($page, $method, $query)
	{
		$page = strtolower(str_replace("\\", "", str_replace("'", "", str_replace("_", "", rawurldecode($page)))));

		$this->Log("ConstructID page=".$page);
		$this->Log("ConstructID md5=".md5($page."_".$method."_".$query));

		$filename = $this->cache_dir.CACHE_PAGE_DIR.md5($page."_".$method."_".$query);
		return $filename;
	}

	//Get timestamp of content from cache
	function GetCachedTime($page, $method, $query)
	{
		$filename = $this->ConstructID($page, $method, $query);

		if (!@file_exists($filename))
			return false;

		if ((time() - @filemtime($filename)) > $this->cache_ttl)
			return false;

		return @filemtime($filename);
	}

	//Store content to cache
	function StoreToCache($data, $page = false, $method = false, $query = false)
	{
		if (!$page)   $page   = $this->page;
		if (!$method) $method = $this->method;
		if (!$query)  $query  = $this->query;

		$page = strtolower(str_replace("\\", "", str_replace("'", "", str_replace("_", "", $page))));
		$filename = $this->ConstructID($page, $method, $query);

		file_put_contents($filename, $data);

		if ($this->wacko) $this->wacko->Query(
			"INSERT INTO ".$this->wacko->config["table_prefix"]."cache SET ".
			"name  ='".quote($this->wacko->dblink, md5($page))."', ".
			"method='".quote($this->wacko->dblink, $method)."', ".
			"query ='".quote($this->wacko->dblink, $query)."'");
			// TIMESTAMP type is filled automatically by MySQL

		@chmod($filename, octdec('0644'));

		return true;
	}

	//Invalidate the cache
	function CacheInvalidate($page)
	{
		if ($this->wacko)
		{
			$page = strtolower(str_replace("\\", "", str_replace("'", "", str_replace("_", "", $page))));
			$this->Log("CacheInvalidate page=".$page);
			$this->Log("CacheInvalidate query=".
				"SELECT * ".
				"FROM ".$this->wacko->config["table_prefix"]."cache ".
				"WHERE name ='".quote($this->wacko->dblink, md5($page))."'");

			$params = $this->wacko->LoadAll(
				"SELECT * ".
				"FROM ".$this->wacko->config["table_prefix"]."cache ".
				"WHERE name ='".quote($this->wacko->dblink, md5($page))."'");

			$this->Log("CacheInvalidate count params=".count($params));

			foreach ($params as $param)
			{
				$filename = $this->ConstructID($page, $param["method"], $param["query"]);

				$this->Log("CacheInvalidate delete=".$filename);

				if (@file_exists($filename))
					@unlink($filename);
			}

			$this->wacko->Query(
				"DELETE FROM ".$this->wacko->config["table_prefix"]."cache ".
				"WHERE name ='".quote($this->wacko->dblink, md5($page))."'");

			$this->Log("CacheInvalidate end");

			return true;
		}
		else return false;
	}

	function Log($msg)
	{
		if ($this->debug > 1)
		{
			$filename = $this->cache_dir."log";

			file_put_contents($filename, $msg."\n", FILE_APPEND);
		}
	}

	//Check http-request. May be, output cached version.
	function CheckHttpRequest($page, $method)
	{
		if (!$page) return false;

		foreach ($_GET as $k => $v)
		{
			if ($k != "v" && $k != "page")
				$_query[$k] = $v;
		}

		if (isset($_query))
		{
			ksort($_query);
			reset($_query);

			foreach($_query as $k => $v)
			{
				if (!isset($query)) $query = "";
				$query .= urlencode($k)."=".urlencode($v)."&";
			}
		}
		if (!isset($query)) $query = "";
		$this->Log("CheckHttpRequest query=".$query);

		//check cache
		if ($mtime = $this->GetCachedTime($page, $method, $query))
		{
			$this->Log("CheckHttpRequest incache mtime=".$mtime);

			$gmt = gmdate('D, d M Y H:i:s \G\M\T', $mtime);
			$etag = (isset($_SERVER["HTTP_IF_NONE_MATCH"]) ? $_SERVER["HTTP_IF_NONE_MATCH"] : "");
			$lastm = (isset($_SERVER["HTTP_IF_MODIFIED_SINCE"]) ? $_SERVER["HTTP_IF_MODIFIED_SINCE"] : "");

			if ($p = strpos($lastm, ";")) $lastm = substr($lastm, 0, $p);

			if ($_SERVER["REQUEST_METHOD"] == "GET") //may be we need HEAD support ???
			{
				if (!$lastm && !$etag);
				else if ($lastm && $gmt != $lastm);
				else if ($etag && $gmt != trim($etag, '\"'));
				else
				{
					header ("HTTP/1.1 304 Not Modified");
					die();
				}

				$cached = $this->GetCached($page, $method, $query);
				header ("Last-Modified: ".$gmt);
				header ("ETag: \"".$gmt."\"");
				//header ("Content-Type: text/xml");
				//header ("Content-Length: ".strlen($cached));
				//header ("Cache-Control: max-age=0");
				//header ("Expires: ".gmdate('D, d M Y H:i:s \G\M\T', time()));
				echo ($cached);

				// how much time script take
				if ($this->debug >= 1 && strpos($method,".xml") === false)
				{
					$ddd = $this->GetMicroTime();
					echo ("<div class=\"debug\">cache time: ".(number_format(($ddd-$this->timer),3))." s<br />");
					echo "</div>";
				}

				if (strpos($method,".xml") === false)
					echo "</body></html>";

				die();
			}
		}

		//We have no valid cached page
		$this->page = $page;
		$this->method = $method;
		$this->query = $query;
		return true;
	}

	function Output()
	{
		clearstatcache();

		if (!($mtime = $this->GetCachedTime($this->page, $this->method, $this->query)))
			$mtime = time();

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

	function GetMicroTime()
	{
		list($usec, $sec) = explode(" ", microtime());
		return ((float)$usec + (float)$sec);
	}

}

?>