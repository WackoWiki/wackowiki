<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class Http
{
	public		$page			= '';
	public		$method			= '';
	public		$tls_session	= false;
	private		$db;
	private		$hash;
	private		$query;
	private		$file;
	private		$caching		= 0;

	public function __construct(&$db, $request = true)
	{
		$this->db = & $db;

		if ($db->is_locked($db->ap_mode? AP_LOCK : SITE_LOCK) || (!$db->ap_mode && RECOVERY_MODE))
		{
			if (!headers_sent())
			{
				header('HTTP/1.1 503 Service Temporarily Unavailable');
			}

			echo 'The site is temporarily unavailable due to system maintenance. Please try again later.';
			exit;
		}

		$this->session();
		$this->http_security_headers();

		if ($request)
		{
			$this->request();
			$this->check_cache();
		}

		// run in tls mode?
		if (@$_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
		{
			$_SERVER['HTTPS'] = 'on'; 
		}

		if ((@$_SERVER['HTTPS'] === 'on' && $db->tls_proxy) || (int)@$_SERVER['SERVER_PORT'] === 443) // STS: why && tls_proxy?
		{
			$this->tls_session = true;
		}

		if ($db->tls && $this->tls_session)
		{
			$this->secure_base_url();
		}
	}

	public function secure_base_url()
	{
		if (!isset($this->db->open_url) && $this->db->tls)
		{
			$this->db->open_url		= $this->db->base_url;
			$this->db->base_url		= str_replace('http://', 'https://' . ($this->db->tls_proxy? $this->db->tls_proxy . '/' : ''), $this->db->base_url);
			$this->db->rebase_url();
		}
	}

	public function ensure_tls($url)
	{
		if ($this->db->tls && !$this->tls_session)
		{
			$this->redirect(str_replace('http://', 'https://' . ($this->db->tls_proxy? $this->db->tls_proxy . '/' : ''), $url));
		}
	}

	// Get page content from cache
	private function load_page(&$timestamp)
	{
		// store data for save_page()
		list($this->page, $this->hash) = $this->normalize_page($this->page);
		$this->file		= $this->construct_id($this->page, $this->method, $this->query);

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
		$n = 0;
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
				if ($x)
				{
					++$n;
				}

				dbg('invalidate_page', $page, $param['method'], $param['query'], '=>', $x);
			}

			$this->db->sql_query(
				"DELETE FROM ".$this->db->table_prefix."cache ".
				"WHERE name = ".$this->db->q($hash));
		}
		return $n;
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
	private function check_http_request()
	{
		if (!$this->page)
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

		$this->query = $query;

		// check cache
		if (($cached_page = $this->load_page($mtime)))
		{
			dbg('check_http_request', $this->page, $this->method, $this->query, 'found!');

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

				if (strpos($this->method, '.xml') === false)
				{
					echo '</body></html>';
				}

				die();
			}
		}

		return true;
	}

	private function check_cache()
	{
		if ($this->db->cache && $_SERVER['REQUEST_METHOD'] != 'POST' && $this->method != 'edit' && $this->method != 'watch')
		{
			// cache only for anonymous user
			if (!isset($_COOKIE[$this->db->cookie_prefix . 'auth' . '_' . $this->db->cookie_hash]))
			{
				$this->caching = $this->check_http_request();
			}
		}
	}

	public function store_cache()
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

	// REQUEST HANDLING
	// Process request string, define $page and $method vars
	private function request()
	{
		if (isset($_SERVER['PATH_INFO']) && function_exists('virtual'))
		{
			$request = $_SERVER['PATH_INFO'];
		}
		else if (isset($_GET['page']))
		{
			$request = $_GET['page'];
		}
		else
		{
			$request = '';
		}

		$request = ltrim($request, '/');

		// check for permalink
		$hashids = new Hashids($this->db->hashid_seed);
		$ids = $hashids->decode((($p = strpos($request, '/')) === false)? $request : substr($request, 0, $p));

		if (count($ids) == 3)
		{
			sscanf(hash('sha1', $ids[0] . $this->db->hashid_seed . $ids[1]), '%7x', $cksum);

			if ($ids[2] == $cksum)
			{
				$this->page = $ids[0] . 'x' . $ids[1];
				$this->method = 'Hashid';
				return;
			}
		}

		// split into page/method
		if (($p = strrpos($request, '/')) === false)
		{
			$this->page = $request;
			$this->method = '';
		}
		else
		{
			$this->page = substr($request, 0, $p);
			$this->method = strtolower(substr($request, $p + 1));

			if (!@file_exists(join_path(HANDLER_DIR, 'page', $this->method . '.php')))
			{
				$this->page	= $request;
				$this->method = '';
			}
			else if (preg_match('#^(.*?)/(' . $this->db->standard_handlers . ')(|/(.*))$#i', $this->page, $match))
			{
				//translit case
				$this->page = $match[1];
				$this->method = strtolower($match[2]);
			}
		}
	}

	// SESSION HANDLING
	private function session()
	{
		$secure = false;

		// run in tls mode?
		if ($this->db->tls && (( (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' && !empty($this->db->tls_proxy)) || $_SERVER['SERVER_PORT'] == '443' ) ))
		{
			$this->db->base_url	= str_replace('http://', 'https://' . ($this->db->tls_proxy ? $this->db->tls_proxy . '/' : ''), $this->db->base_url);
			$secure					= true;
		}

		$_cookie_path = preg_replace('|https?://[^/]+|i', '', $this->db->base_url);

		session_set_cookie_params(0, $_cookie_path, '', $secure, true);
		session_name($this->db->cookie_prefix . SESSION_HANDLER_ID);

		// Save session information where specified or with PHP's default
		session_save_path(SESSION_HANDLER_PATH);

		// Initialize the session
		session_start();
	}


	// Set security headers (frame busting, clickjacking/XSS/CSRF protection)
	//		Content-Security-Policy:
	//		Strict-Transport-Security:
	private function http_security_headers()
	{
		if ($this->db->enable_security_headers)
		{
			if (!headers_sent())
			{
				switch ($this->db->csp)
				{
					case 1:
						// http://www.w3.org/TR/CSP2/
						header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src *;");
						break;

					case 2:
						$csp_custom = str_replace(array("\r", "\n", "\t"), '', CSP_CUSTOM);
						header($csp_custom);
						break;
				}

				if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off')
				{
					header('Strict-Transport-Security: max-age=7776000');
				}
			}
		}
	}

	/**
	* Immediate redirect to the specified URL
	* note - even though it's output as an HTTP Header, Wacko's output-buffering means that this
	* function still works anywhere in a page
	*
	* @param string $url Target URL
	*/
	function redirect($url, $permanent = false)
	{
		if (!headers_sent())
		{
			// Make sure no &amp;'s are in, this will break the redirect
			$url = str_replace('&amp;', '&', $url);

			if ($permanent)
			{
				header('HTTP/1.1 301 Moved Permanently');
			}

			header('Location: ' . $url);
			exit;
		}
	}

	/**
	 * disable caching
	 *
	 * @param boolean $client_only - Disables only client-side caching. Optional, default is TRUE
	 */
	function no_cache($client_only = true)
	{
		// disable browser cache for page
		if ( !headers_sent() )
		{
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');				// Date in the past
			header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');		// always modified
			header('Cache-Control: no-store, no-cache, must-revalidate');	// HTTP 1.1
			header('Cache-Control: post-check=0, pre-check=0', false);
			header('Pragma: no-cache');										// HTTP 1.0
		}

		// disable server cache for page
		if (!$client_only)
		{
			$this->caching = 0;
		}
	}

}
