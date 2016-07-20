<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class Http
{
	public		$vars			= [];
	public		$page			= '';
	public		$method			= '';
	public		$tls_session;
	public		$real_ip;
	public		$session;						// class Session
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

		$this->tls_session = $this->tls_session();
		$this->real_ip = $this->real_ip();

		if ($db->tls && $this->tls_session)
		{
			$this->secure_base_url();
		}

		$this->session();
		$this->http_security_headers();

		if ($request)
		{
			$router = new UriRouter($db);
			$this->vars = $router->run(['_tls' => $this->tls_session, '_ip' => $this->real_ip]);
			$this->page = $this->vars['page'];
			$this->method = $this->vars['method'];
			$this->check_cache();

			// to be replaced then by no_cache or what
			header('Cache-Control: public');
			header('Pragma: cache');
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

			Ut::dbg('invalidate_page', $page);

			$past = time() - $this->db->cache_ttl - 1;

			foreach ($params as $param)
			{
				$file	= $this->construct_id($page, $param['method'], $param['query']);
				$x		= @touch($file, $past); // touching is faster than unlinking
				if ($x)
				{
					++$n;
				}

				Ut::dbg('invalidate_page', $page, $param['method'], $param['query'], '=>', $x);
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
		return Ut::join_path(CACHE_PAGE_DIR, hash('sha1', ($page . '_' . $method . '_' . $query)));
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
			Ut::dbg('check_http_request', $this->page, $this->method, $this->query, 'found!');

			$gmt	= Ut::http_date($mtime);
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
					Ut::dbg('not modified');
					header('HTTP/1.1 304 Not Modified');
					$this->terminate();
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

				$this->terminate();
			}
		}

		return true;
	}

	private function check_cache()
	{
		if ($this->db->cache && $_SERVER['REQUEST_METHOD'] != 'POST' && $this->method != 'edit' && $this->method != 'watch')
		{
			// cache only for anonymous user
			if (!isset($this->session->userprofile))
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

	private function session()
	{
		if (1) // STS TODO need config'ing
		{
			$sess = new SessionFileStore;
			$sess->cf_file_path = CACHE_SESSION_DIR;
		}
		else
		{
			$sess = new SessionDbalStore($this->db);
			$sess->cf_dbal_table_name = $this->db->table_prefix . 'sessions';
		}

		$sess->cf_cookie_path		= $this->db->cookie_path;
		$sess->cf_cookie_secure		= ($this->db->tls && $this->tls_session);
		$sess->cf_cookie_httponly	= true;

		$sess->cf_ip				= $this->real_ip; // STS hack. need to decide where real_ip should live
		$sess->cf_tls				= $this->tls_session;

		$sess->start($this->db->cookie_prefix . 'Session');
		$this->session = & $sess;

		if (isset($sess->saved_diag_log))
		{
			// recover old dbg messages sabed by self::redirect()
			Diag::$log = array_merge($sess->saved_diag_log, Diag::$log);
		}
	}

	// Set security headers (frame busting, clickjacking/XSS/CSRF protection)
	//		Content-Security-Policy:
	//		Strict-Transport-Security:
	private function http_security_headers()
	{
		if ($this->db->enable_security_headers && !headers_sent())
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

			if ($this->tls_session)
			{
				// HSTS
				header('Strict-Transport-Security: max-age=7776000');
			}

			// prevent clickjacking
			// TODO configure?
			header('X-Frame-Options: SAMEORIGIN');
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

			$this->terminate();
		}
	}

	// safe exit/die for wackowiki
	function terminate()
	{
		if (Diag::$log && isset($this->session))
		{
			// save dbg messages to show in next session..
			$this->session->set_flash('saved_diag_log', Diag::$log);
		}

		die;
	}

	/**
	 * disable caching
	 *
	 * @param boolean $client_only - Disables only client-side caching. Optional, default is TRUE
	 */
	function no_cache($client_only = true)
	{
		// disable browser cache for page
		if (!headers_sent())
		{
			header('Expires: ' . Ut::http_date(-1));				// Date in the past
			header('Last-Modified: ' . Ut::http_date());						// always modified
			header('Cache-Control: no-store, no-cache, must-revalidate');	// HTTP 1.1
			header('Cache-Control: post-check=0, pre-check=0', false);
			header('Pragma: no-cache');										// HTTP 1.0
		}
		// STS: check into session nocache code!

		// disable server cache for page
		if (!$client_only)
		{
			$this->caching = 0;
		}
	}

	private function real_ip()
	{
		$reverse_proxy_addresses = preg_split('/[\s,]+/', $this->db->reverse_proxy_addresses, -1, PREG_SPLIT_NO_EMPTY);

		$x = trim($this->db->reverse_proxy_header);
		$x or $x = 'X-Forwarded-For';
		$reverse_proxy_header = 'HTTP_' . strtoupper(strtr($x, '-', '_'));

		foreach (['HTTP_X_CLUSTER_CLIENT_IP', $reverse_proxy_header, 'HTTP_CLIENT_IP', 'HTTP_X_REMOTE_ADDR', 'REMOTE_ADDR'] as $ip)
		{
			if (isset($_SERVER[$ip]))
			{
				$ips = preg_split('/[\s,]+/', $_SERVER[$ip], -1, PREG_SPLIT_NO_EMPTY);
				$ips = array_diff($ips, $reverse_proxy_addresses);
				$ips = array_filter($ips, function($ip) {
					return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
				});
				if ($ips)
				{
					return $ips[0];
				}
			}
		}

		return '0.0.0.0';
	}

	private function tls_session()
	{
		return ((@$_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off' && $_SERVER['HTTPS'] != '0')
			|| $_SERVER['SERVER_PORT'] == 443
			|| @$_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
			|| @$_SERVER['HTTP_X_FORWARDED_PORT'] == 443);
	}

}
