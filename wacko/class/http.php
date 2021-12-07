<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class Http
{
	public		$tls_session;
	public		$request_uri;				// normalized REQUEST_URI - e.g. 'PageOfNoReturn/show?a=1'
	public		$ip;
	public		$sess;						// class Session
	private		$db;
	private		$tls_mark;					// tls mark cookie name
	private		$page;
	public		$method;					// for finalize & diag..
	private		$hash;
	private		$query;
	private		$lang;
	private		$file;
	private		$caching		= 0;

	public function __construct(&$db)
	{
		$this->db			= & $db;
		$this->request_uri	= $this->request_uri();
		$this->tls_session	= $this->tls_session();
		$this->ip			= $this->real_ip();
		$this->tls_mark		= $this->db->cookie_prefix . 'TLS';

		// if we have used tls already - do secure session!
		if ($db->tls && !$this->tls_session && @$_COOKIE[$this->tls_mark])
		{
			$this->secure_base_url();
			$this->redirect($this->db->base_url . $this->request_uri, true);
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
			$this->db->base_url		= str_replace('http://', 'https://', $this->db->base_url);
			$this->db->rebase_url();
		}
	}

	public function ensure_tls($url)
	{
		if ($this->db->tls && !$this->tls_session)
		{
			// relative addressing
			if (!preg_match('/^(http|https):\/\/([^\\s\"<>]+)$/', $url))
			{
				$url = 'https://' . $_SERVER['SERVER_NAME'] . $url;
			}

			$this->redirect(str_replace('http://', 'https://', $url));
		}
	}

	// Get page content from cache
	private function load_page(&$timestamp)
	{
		$this->lang					= $this->user_agent_language();

		// store data for save_page()
		[$this->page, $this->hash]	= $this->normalize_page($this->page);
		$this->file					= $this->construct_id($this->page, $this->method, $this->query, $this->lang);

		clearstatcache();

		if ($timestamp = @filemtime($this->file))
		{
			if (time() - $timestamp <= $this->db->cache_ttl)
			{
				if ($contents = file_get_contents($this->file))
				{
					return $contents;
				}
			}
		}

		return false;
	}

	// Store page content to cache
	private function save_page($data)
	{
		file_put_contents($this->file, $data);
		chmod($this->file, CHMOD_SAFE);

		$this->db->sql_query(
			"INSERT INTO " . $this->db->table_prefix . "cache SET " .
				"name		= " . $this->db->q($this->hash) . ", " .
				"method		= " . $this->db->q($this->method) . ", " .
				"query		= " . $this->db->q($this->query) . ", " .
				"cache_lang	= " . $this->db->q($this->lang) . ", " .	// user lang NOT user agent lang NOR page lang!
				"cache_time	= UTC_TIMESTAMP()");

	}

	// Invalidate the page cache
	public function invalidate_page($page)
	{
		$n = 0;

		if ($this->db->cache)
		{
			[$page, $hash] = $this->normalize_page($page);

			$params	= $this->db->load_all(
				"SELECT method, query, cache_lang " .
				"FROM " . $this->db->table_prefix . "cache " .
				"WHERE name = " . $this->db->q($hash));

			// Ut::dbg('invalidate_page', $page);

			$past = time() - $this->db->cache_ttl - 1;

			foreach ($params as $param)
			{
				$file	= $this->construct_id($page, $param['method'], $param['query'], $param['cache_lang']);
				$x		= @touch($file, $past); // touching is faster than unlinking

				if ($x)
				{
					++$n;
				}

				// Ut::dbg('invalidate_page', $page, $param['method'], $param['query'], '=>', $x);
			}

			$this->db->sql_query(
				"DELETE FROM " . $this->db->table_prefix . "cache " .
				"WHERE name = " . $this->db->q($hash));
		}

		return $n;
	}

	private function normalize_page($page)
	{
		$page = str_replace(['\\', "'", '_'], '', $page);
		return [$page, hash('sha1', $page)];
	}

	private function construct_id($page, $method, $query, $lang)
	{
		return Ut::join_path(CACHE_PAGE_DIR, Ut::http64_encode(hash('sha1', ($page . '_' . $method . '_' . $query . '_' . $lang), 1)));
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

		$query = ($this->tls_session? 'TLS&' : '');

		foreach ($_query as $k => $v)
		{
			$query .= urlencode($k) . '=' . urlencode($v) . '&';
		}

		$this->query = $query;

		// check cache
		if ($cached_page = $this->load_page($mtime))
		{
			// Ut::dbg('check_http_request', $this->page, $this->method, $this->query, 'found!');

			$gmt	= Ut::http_date($mtime);
			$etag	= @$_SERVER['HTTP_IF_NONE_MATCH'];
			$lastm	= @$_SERVER['HTTP_IF_MODIFIED_SINCE'];

			if ($lastm && $p = strpos($lastm, ';'))
			{
				$lastm = substr($lastm, 0, $p);
			}

			if ($_SERVER['REQUEST_METHOD'] == 'GET' || $_SERVER['REQUEST_METHOD'] == 'HEAD')
			{
				if (!$lastm && !$etag);
				else if ($lastm && $gmt != $lastm);
				else if ($etag && $gmt != trim($etag, '\"'));
				else
				{
					// Ut::dbg('not modified');
					$this->status(304);
					$this->terminate();
				}

				// HTTP header with right Charset settings
				// TODO: other than .html?
				if (($head = strpos($cached_page, '</head>')) !== false)
				{
					$head = substr($cached_page, 0, $head);

					if (preg_match('#<html[^/>]*>#', $head) &&
						preg_match('#<meta\s+charset="([^"]+)"\s*>#', $head, $match))
					{
						header('Content-Type: text/html; charset=' . $match[1]);
					}
				}

				ini_set('default_charset', null);

				header('Last-Modified: ' . $gmt);
				header('ETag: "' . $gmt . '"');

				//header('Content-Length: '.strlen($cached));
				//header('Cache-Control: max-age=0');

				echo $cached_page;

				if (!str_contains($this->method, '.xml'))
				{
					echo "\n<!-- WackoWiki Caching Engine: page cached at " . date('Y-m-d H:i:s', $mtime) . " -->\n";
					echo "</body>\n</html>";
				}

				$this->gzip();
				$this->terminate();
			}
		}

		return true;
	}

	public function check_cache($page, $method)
	{
		$this->method	= $method;

		if ($this->db->cache && $_SERVER['REQUEST_METHOD'] != 'POST' && $method != 'edit' && $method != 'watch')
		{
			// cache only for anonymous user
			if (!isset($this->sess->userprofile))
			{
				$this->page		= $page;
				$this->caching	= $this->check_http_request();
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

	public function session($route)
	{
		if ($this->db->session_store == 1)
		{
			$sess = new SessionFileStore;
			$sess->cf_file_path = CACHE_SESSION_DIR;
		}
		else
		{
			$sess = new SessionDbalStore($this->db);
			$sess->cf_dbal_table_name = $this->db->table_prefix . 'session';
		}

		$sess->cf_secret			= $this->db->system_seed_hash;
		$sess->cf_cookie_prefix		= $this->db->cookie_prefix;
		$sess->cf_cookie_persistent	= ($this->db->allow_persistent_cookie? $this->db->session_length : false);
		$sess->cf_cookie_path		= $this->db->cookie_path;
		$sess->cf_cookie_secure		= ($this->db->tls && $this->tls_session);
		$sess->cf_cookie_httponly	= true;

		$sess->cf_ip				= $this->ip;
		$sess->cf_tls				= $this->tls_session;

		// for freecap, /file method and alike - do not play in NoReplay & do no simple id regen
		if ($route & 2)
		{
			$sess->cf_static			= 1;
			$sess->cf_prevent_replay	= 0;
		}

		$sess->start('Session');
		$this->sess = & $sess;

		if (isset($sess->saved_diag_log))
		{
			// recover old dbg messages saved by self::redirect()
			Diag::$log = array_merge($sess->saved_diag_log, Diag::$log);
		}

		// if we are in tls-secured session - leave a mark so unsecure sessions do upgrade and find our session!
		if ($this->db->tls && $this->tls_session && !@$_COOKIE[$this->tls_mark])
		{
			// we need to set custom NOT SECURE cookie for tls upgrade mark
			$sess->setcookie($this->tls_mark, 'on', 0, null, null, false);
		}
	}

	// Set security headers (frame busting, clickjacking/XSS/CSRF protection)
	//		1. Content-Security-Policy:
	//		2. Permissions-Policy:
	//		3. Referrer-Policy:
	//		4. Strict-Transport-Security:
	//		5. X-Frame-Options:
	//		6. X-Content-Type-Options:
	public function http_security_headers()
	{
		if ($this->db->enable_security_headers && !headers_sent())
		{
			// 1. Content-Security-Policy: http://www.w3.org/TR/CSP2/
			if ($this->db->csp)
			{
				$file_name = match ((int) $this->db->csp)
				{
					1 => 'csp.conf',
					2 => 'csp_custom.conf',
				};

				$csp_header = $this->get_header_conf($file_name);
				header($csp_header);
			}

			// 2. Permissions-Policy: https://www.w3.org/TR/permissions-policy/
			if ($this->db->permissions_policy)
			{
				$file_name = match ((int) $this->db->permissions_policy)
				{
					1 => 'permissions_policy.conf',
					2 => 'permissions_policy_custom.conf',
				};

				$pp_header = $this->get_header_conf($file_name);
				header($pp_header);
			}

			// 3. Referrer-Policy: https://www.w3.org/TR/referrer-policy/
			if ($this->db->referrer_policy)
			{
				static $policy = [
					0	=> '',
					1	=> 'no-referrer',
					2	=> 'no-referrer-when-downgrade',
					3	=> 'same-origin',
					4	=> 'origin',
					5	=> 'strict-origin',
					6	=> 'origin-when-cross-origin',
					7	=> 'strict-origin-when-cross-origin',
					8	=> 'unsafe-url'
				];

				header('Referrer-Policy: ' . $policy[$this->db->referrer_policy]);
			}

			// 4. Strict-Transport-Security:
			if ($this->tls_session)
			{
				// HSTS
				header('Strict-Transport-Security: max-age=7776000');
			}

			// 5. X-Frame-Options: prevent clickjacking
			// TODO configure?
			header('X-Frame-Options: SAMEORIGIN');

			// 6. X-Content-Type-Options: prevents the browser from doing MIME-type sniffing
			header('X-Content-Type-Options: nosniff');
		}
	}

	// TODO: cache, validate, strip possible comments
	function get_header_conf($file_name)
	{
		$csp_config		= file_get_contents(Ut::join_path(CONFIG_DIR, $file_name));

		return			str_replace(["\r", "\n", "\t"], '', $csp_config);
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
			$url = Ut::amp_decode($url);

			$this->status($permanent? 301 : 302);
			header('Location: ' . $url);

			$this->terminate();
		}
	}

	// safe exit/die for wackowiki
	function terminate()
	{
		if (Diag::$log && isset($this->sess))
		{
			// save dbg messages to show in next session..
			$this->sess->set_flash('saved_diag_log', Diag::$log);
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
			header('Expires: ' . Ut::http_date(-1));						// Date in the past
			header('Last-Modified: ' . Ut::http_date());					// always modified
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

	function cache_promisc()
	{
		// to be replaced then by no_cache or what
		header('Cache-Control: public');
		header('Pragma: cache');
	}

	// negotiate language with user's browser
	function user_agent_language()
	{
		$lang = $this->db->language;

		if ($this->db->multilanguage && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			$lang_list = $this->available_languages();

			// http://www.w3.org/Protocols/rfc2616/rfc2616-sec14.html#sec14.4
			preg_match_all("/([[:alpha:]]{1,8})(-([[:alpha:]|-]{1,8}))?" .
					"(\s*;\s*q\s*=\s*(1\.0{0,3}|0\.\d{0,3}))?\s*(,|$)/",
					strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']),
					$matches, PREG_SET_ORDER);

			$best = 0;

			foreach ($matches as $i)
			{
				$want1 = $want2 = $i[1];

				if ($i[3])
				{
					$want2 = $want1 . '-' . $i[3];
				}

				$q = ($i[5] !== '')? (float)$i[5] : 1;

				if (isset($lang_list[$want2]) && $q > $best)
				{
					$lang = $want2;
					$best = $q;
				}
				else if (isset($lang_list[$want1]) && $q * 0.9 > $best)
				{
					$lang = $want1;
					$best = $q * 0.9;
				}
			}
		}

		return $lang;
	}

	/**
	* Get array of available resource translations
	*
	* @param bool $subset, true for allowed_languages only
	*
	* @return array Array of language codes
	*/
	function available_languages($subset = true)
	{
		$lang_list = &$this->sess->available_languages;

		if (!isset($lang_list))
		{
			$list = [];

			foreach (Ut::file_glob(LANG_DIR, 'wacko.[a-z][a-z]{\-[a-z][a-z],}.php') as $file)
			{
				$lang = substr($file, 11, -4);
				$list[$lang] = $lang;
			}

			ksort($list, SORT_STRING);
			$lang_list[false] = $list;

			if (($allow = preg_split('/[\s,]+/', $this->db->allowed_languages, -1, PREG_SPLIT_NO_EMPTY)) && $allow[0])
			{
				// system language is always allowed
				if (!in_array($this->db->language, $allow))
				{
					$allow[] = $this->db->language;
				}

				$list = array_intersect($list, $allow);
			}

			if (!isset($list[$this->db->language]))
			{
				die('WackoWiki system language is unavailable');
			}

			$lang_list[true] = $list;
		}

		return $lang_list[(bool) $subset];
	}

	private function real_ip()
	{
		$reverse_proxy_addresses = preg_split('/[\s,]+/', $this->db->reverse_proxy_addresses, -1, PREG_SPLIT_NO_EMPTY);

		$x = trim($this->db->reverse_proxy_header);
		$x || $x = 'X-Forwarded-For';
		$reverse_proxy_header = 'HTTP_' . strtoupper(strtr($x, '-', '_'));

		foreach (['HTTP_X_CLUSTER_CLIENT_IP', $reverse_proxy_header, 'HTTP_CLIENT_IP', 'HTTP_X_REMOTE_ADDR', 'REMOTE_ADDR'] as $ip)
		{
			if (isset($_SERVER[$ip]))
			{
				$ips = preg_split('/[\s,]+/', $_SERVER[$ip], -1, PREG_SPLIT_NO_EMPTY);
				$ips = array_diff($ips, $reverse_proxy_addresses);
				$ips = array_filter($ips, function($ip){
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
			|| @$_SERVER['HTTP_X_FORWARDED_SSL'] == 'on'
			|| @$_SERVER['HTTP_X_FORWARDED_PORT'] == 443);
	}

	function status($code)
	{
		static $text = [
			200 => 'OK',
			206 => 'Partial Content',
			301 => 'Moved Permanently',
			302 => 'Moved Temporarily',
			304 => 'Not Modified',
			400 => 'Bad Request',
			401 => 'Unauthorized',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			416 => 'Requested Range Not Satisfiable',
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			503 => 'Service Unavailable',
		];

		if (!isset($text[$code]))
		{
			die('unknown http status code "' . Ut::html($code) . '"');
		}

		if (!headers_sent())
		{
			header(($_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0') . ' ' . $code . ' ' . $text[$code], true, $code);
		}
	}

	function mime_type($path)
	{
		static $types;

		if (!isset($types))
		{
			$conffile	= Ut::join_path(CONFIG_DIR, 'mime.types');
			$cachefile	= Ut::join_path(CACHE_CONFIG_DIR, 'mime.types');

			clearstatcache();

			if (!($conftime = @filemtime($conffile)))
			{
				die($conffile . ' not found');
			}

			// do not read stale or non-writable cachefile
			if (!((@filemtime($cachefile) >= $conftime)
				&& is_writable($cachefile)
				&& ($text = file_get_contents($cachefile))
				&& ($types = Ut::unserialize($text))))
			{
				$types = [];

				foreach (file($conffile) as $line)
				{
					$line = preg_split('/\s+/', $line, -1, PREG_SPLIT_NO_EMPTY);

					if (count($line) > 1 && ctype_alpha($line[0][0]))
					{
						$type = array_shift($line);

						foreach ($line as $ext)
						{
							$types[$ext] = $type;
						}
					}
				}

				// cache to file
				$text = Ut::serialize($types);
				// unable to write cache file considered are 'turn config caching off' feature
				@file_put_contents($cachefile, $text);
				@chmod($cachefile, CHMOD_FILE);
			}
		}

		$ext = pathinfo($path, PATHINFO_EXTENSION);
		return $types[$ext] ?? 'application/octet-stream';
	}

	public function sendfile($path, $filename = null, $age = null)
	{
		header_remove();
		set_time_limit(0);
		isset($this->sess)  &&  $this->sess->write_close();

		// allow to be called sendfile(404)
		if ($code = (defined('HTTP_' . $path)? $path : $this->sendfile0($path, $filename, $age)))
		{
			$this->status($code);

			if (defined('HTTP_' . $code) && $this->sendfile0(constant('HTTP_' . $code), null, -1))
			{
				echo ($code == 404)? 'File not found' : 'File access prohibited';
			}
		}
	}

	private function sendfile0($path, $filename = null, $age = 31)
	{
		clearstatcache();
		$path = realpath($path);

		if (!@file_exists($path))
		{
			return 404;
		}

		if (!($size = @filesize($path))
			|| !($mtime = @filemtime($path))
			|| !@is_readable($path)
			|| !is_file($path)
			|| is_link($path))
		{
			return 403;
		}

		$from = 0;
		$to = $size;

		if ($age >= 0)
		{
			if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $mtime)
			{
				// Ut::dbg('not modified');
				$this->status(304);
				return;
			}

			header('Last-Modified: ' . Ut::http_date($mtime));

			if (isset($_SERVER['HTTP_RANGE']))
			{
				if (!preg_match('@^bytes=(\d*)-(\d*)(,\d*-\d*)*$@', $_SERVER['HTTP_RANGE'], $m)
					|| ($m[1] === '' && $m[2] === '')
					|| ($m[1] !== '' && $m[2] !== '' && (int) $m[1] > (int) $m[2])
					|| ($m[1] !== '' && $m[1] > $size)
					|| ($m[2] !== '' && $m[2] > $size))
				{
					$this->status(416);
					header("Content-Range: bytes */$size"); // Required in 416.
					return;
				}

				if ($m[1] === '')
				{
					$from = $size - (int) $m[2];
				}
				else
				{
					$from = (int) $m[1];
					$m[2] === ''  ||  $to = (int) $m[2] + 1;
				}
			}

			header('Accept-Ranges: bytes');

			if ($from > 0 || $to < $size)
			{
				$this->status(206);
				header('Content-Range: bytes ' . $from . '-' . ($to - 1) . '/' . $size);
			}
		}

		header('X-Served-By: sendfile');
		header('Content-Length: ' . ($to - $from));
		header('Content-Type: ' . ($type = $this->mime_type($path)));
		header('Content-Disposition: inline; filename="' . ($filename ?: basename($path)) . '"');
		header('Date: ' . Ut::http_date());

		if ($age > 0)
		{
			$age = (int)($age * DAYSECS);
			header('Cache-Control: public, max-age=' . $age);
			header('Expires: ' . Ut::http_date(time() + $age));
		}
		else
		{
			header('Expires: ' . Ut::http_date(-1));
			header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
			header('Pragma: no-cache');
		}

		// protecting against XSS in SVG
		if ($type == 'image/svg+xml')
		{
			header("Content-Security-Policy: default-src self; script-src 'none'");
		}

		// nosniff only applies to "script" and "style" types.
		if (preg_match('/^text|xml|javascript/i', $type))
		{
			header('X-Content-Type-Options: nosniff');
		}

		ob_implicit_flush(true);

		if ($from == 0 && $to == $size)
		{
			readfile($path);
			// gzip only text files
			preg_match('/^text|xml|javascript/i', $type) && $this->gzip();
		}
		else
		{
			$fp = fopen($path, 'rb');
			fseek($fp, $from);

			if ($to == $size)
			{
				@fpassthru($fp);
			}
			else
			{
				$size = $to - $from;
				$piece = 1 << 16;

				while ($size > 0 && !feof($fp) && !connection_status())
				{
					$part = fread($fp, (($size < $piece)? $size : $piece));

					if (!($len = strlen($part)))
					{
						break; // error
					}

					echo $part;
					$size -= $len;
				}
			}

			fclose($fp);
		}
	}

	// saved snippet from stackoverflow, to clean up names from php "translations"
	// $_POST   = parse_str(file_get_contents('php://input'));
	// $_GET    = parse_str($_SERVER['QUERY_STRING']);
	// $_COOKIE = parse_str($_SERVER['HTTP_COOKIE']);
	function parse_str($str)
	{
		$str = preg_replace_callback('/(^|(?<=&))[^=[&]+/', function($key) { return bin2hex(urldecode($key[0])); }, $str);
		parse_str($str, $post);
		return array_combine(array_map('hex2bin', array_keys($post)), $post);
	}

	// remove base_url's base from REQUEST_URI
	private function request_uri()
	{
		$base = parse_url($this->db->base_url);
		$base = trim($base['path'], '/');

		$uri = explode('?', $_SERVER['REQUEST_URI'], 2);
		$path = rawurldecode($uri[0]); // %xx not yet decoded in REQUEST_URI

		// sanitize uri wacko-style:
		// remove spaces, multiple slashes, .. path parts, and leading/trailing slashes
		$path = Ut::strip_spaces($path);
		$path .= '/';

		while (($x = str_replace(['/../', '/./', '//'], '/', $path)) !== $path)
		{
			$path = $x;
		}

		$path = trim($path, '/');

		$path = $this->cut_prefix($base, $path);

		isset($uri[1])  &&  $path .= '?' . $uri[1];

		return $path;
	}

	private function cut_prefix($prefix, $path)
	{
		if (($n = strlen($prefix)) && !strncasecmp($path, $prefix, $n) && (!isset($path[$n]) || $path[$n] == '/'))
		{
			$path = (string) substr($path, $n + 1);
		}

		return $path;
	}

	// gzip http stream ourselves (not by zlib output compression or ob_gzhandler), to produce Content-Length header
	function gzip()
	{
		if (headers_sent() || connection_aborted())
		{
			return;
		}

		header('Content-Length: ' . ($len = ob_get_length()));

		if ($len < 860 || $len > (1 << 20))
		{
			return; // do not compress small or too big data
		}

		header('Vary: Accept-Encoding');

		foreach (['x-gzip', 'gzip'] as $x)
		{
			if (isset($_SERVER['HTTP_ACCEPT_ENCODING']) && str_contains($_SERVER['HTTP_ACCEPT_ENCODING'], $x))
			{
				$text = gzencode(ob_get_contents(), 4);
				ob_end_clean();

				header('Content-Encoding: ' . $x);
				header('Content-Length: ' . strlen($text));

				echo $text;
				break;
			}
		}
	}

}
