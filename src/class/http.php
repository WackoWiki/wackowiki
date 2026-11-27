<?php

if (!defined('IN_WACKO'))
{
	exit;
}

class Http
{
	/**
	 * Closing tags of the HTML document.
	 *
	 * SINGLE SOURCE OF TRUTH: the dynamic response gets them from
	 * class/final.php, the cached response appends exactly the same string.
	 * Otherwise the two bodies would differ and the ETag would not identify
	 * the response body (no 304 would ever be possible).
	 */
	public const DOCUMENT_END = "\n</body>\n</html>";

	public			$tls_session;
	public			$request_uri;				// normalized REQUEST_URI - e.g. 'PageOfNoReturn/show?a=1'
	public			$ip;
	public			$sess;						// class Session
	private			$db;
	private			$tls_mark;					// tls mark cookie name
	private			$page;
	public			$method;					// for finalize & diag..
	private			$hash;
	private			$query;
	private			$lang;
	private			$file;
	private			$no_cache		= 0;		// for CSP nonces
	private			$caching		= 0;
	private bool	$security_headers_sent	= false;
	private bool	$cache_hit				= false;
	private bool	$cache_checked			= false;
	private bool	$cache_body_served		= false;
	private bool	$cache_body_complete		= false;
	private ?string	$pending_etag			= null;
	private bool	$finalized				= false;
	private int		$output_buffer_level;

	public function __construct(&$db)
	{
		$this->db			= & $db;
		$this->request_uri	= $this->request_uri();
		$this->tls_session	= $this->tls_session();
		$this->ip			= $this->real_ip();
		$this->tls_mark		= $this->db->cookie_prefix . 'TLS';
		$this->output_buffer_level = ob_get_level();

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

	public function secure_base_url(): void
	{
		if (!isset($this->db->open_url) && $this->db->tls)
		{
			$this->db->open_url		= $this->db->base_url;
			$this->db->base_url		= str_replace('http://', 'https://', $this->db->base_url);
			$this->db->rebase_url();
		}
	}

	public function ensure_tls($url): void
	{
		if (($this->db->tls_implicit || $this->db->tls) && !$this->tls_session)
		{
			// relative addressing
			if (!preg_match('/^(https?):\/\/([^\\s\"<>]+)$/', $url))
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

		$handle = @fopen($this->file, 'rb');

		if ($handle === false)
		{
			return false;
		}

		try {
			$stat = fstat($handle);
			$timestamp = isset($stat['mtime']) ? (int) $stat['mtime'] : null;
			$length = isset($stat['size']) ? (int) $stat['size'] : 0;

			if ($timestamp === null
				|| time() - $timestamp > $this->db->cache_ttl
				|| $length === 0)
			{
				return false;
			}

			// Preserve the legacy empty-body behavior. In particular, the
			// literal body "0" was treated as a cache miss.
			if ($length === 1)
			{
				rewind($handle);
				$first = fread($handle, 1);

				if ($first === '0')
				{
					return false;
				}

				rewind($handle);
			}

			$contents = stream_get_contents($handle);

			return ($contents === false || $contents === '') ? false : $contents;
		}
		finally {
			fclose($handle);
		}
	}

	// Store page content to cache
	private function save_page($data): void
	{
		$query =
			'INSERT INTO ' . $this->db->table_prefix . 'cache (' .
				'hash, ' .
				'method, ' .
				'query, ' .
				'cache_lang, ' .
				'cache_time)' .
			'VALUES (' .
				$this->db->q($this->hash) . ', ' .
				$this->db->q($this->method) . ', ' .
				$this->db->q($this->query) . ', ' .
				$this->db->q($this->lang) . ', ' .	// user lang NOT user agent lang NOR page lang!
				$this->db->utc_dt() . ')';

		// Record the metadata before publishing the artifact. If the database
		// is temporarily locked, no cache file is left behind that could later
		// be served without being invalidated. The metadata row is harmless
		// when the subsequent file publication fails.
		if (method_exists($this->db, 'sql_query_nonfatal'))
		{
			$result = $this->db->sql_query_nonfatal($query);

			if ($result === false)
			{
				throw new RuntimeException('Unable to record the response cache metadata');
			}
		}
		else
		{
			$this->db->sql_query($query);
		}

		$temp = $this->file . '.tmp.' . getmypid() . '.' . bin2hex(random_bytes(6));
		$handle = @fopen($temp, 'x+b');

		if ($handle === false)
		{
			throw new RuntimeException('Unable to create the temporary cache file');
		}

		try {
			$length = strlen($data);
			$written = fwrite($handle, $data);

			if ($written !== $length || !fflush($handle))
			{
				throw new RuntimeException('Unable to write the temporary cache file');
			}

			fclose($handle);
			$handle = null;

			@chmod($temp, CHMOD_SAFE);

			if (!@rename($temp, $this->file))
			{
				throw new RuntimeException('Unable to publish the cache file');
			}
		}
		catch (Throwable $e) {
			if (is_resource($handle))
			{
				fclose($handle);
			}

			@unlink($temp);

			throw $e;
		}
	}

	// Invalidate the page cache
	public function invalidate_page($page): int
	{
		$n = 0;

		if ($this->db->cache)
		{
			[$page, $hash] = $this->normalize_page($page);

			$params = $this->db->load_all(
				'SELECT method, query, cache_lang ' .
				'FROM ' . $this->db->table_prefix . 'cache ' .
				'WHERE hash = ' . $this->db->q($hash));

			if ($params)
			{
				# Ut::dbg('invalidate_page', $page);

				$past = time() - $this->db->cache_ttl - 1;

				foreach ($params as $param)
				{
					$file	= $this->construct_id($page, $param['method'], $param['query'], $param['cache_lang']);
					$x		= @touch($file, $past); // touching is faster than unlinking

					if ($x)
					{
						++$n;
					}

					# Ut::dbg('invalidate_page', $page, $param['method'], $param['query'], '=>', $x);
				}

				$this->db->sql_query(
					'DELETE ' .
					'FROM ' . $this->db->table_prefix . 'cache ' .
					'WHERE hash = ' . $this->db->q($hash));
			}
		}

		return $n;
	}

	private function normalize_page($page): array
	{
		$page = str_replace(['\\', "'", '_'], '', $page);

		return [$page, hash('sha1', $page)];
	}

	private function construct_id($page, $method, $query, $lang)
	{
		return Ut::join_path(CACHE_PAGE_DIR, Ut::http64_encode(hash('sha1', ($page . '_' . $method . '_' . $query . '_' . $lang), true)));
	}

	// Check http-request. May be, output cached version.
	private function check_http_request(): bool
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
		if (!($cached_page = $this->load_page($mtime)))
		{
			// The page key is cache-eligible even when this particular
			// representation has not been stored yet.
			return true;
		}

		# Ut::dbg('check_http_request', $this->page, $this->method, $this->query, 'found!');
		if (in_array($_SERVER['REQUEST_METHOD'] ?? 'GET', ['GET', 'HEAD'], true))
		{
			$this->cache_hit = true;
			$client_etag			= !empty($_SERVER['HTTP_IF_NONE_MATCH'])		? trim($_SERVER['HTTP_IF_NONE_MATCH'])		: null;
			$client_last_modified	= !empty($_SERVER['HTTP_IF_MODIFIED_SINCE'])	? trim($_SERVER['HTTP_IF_MODIFIED_SINCE'])	: null;

			$server_last_modified	= Ut::http_date($mtime);
			$document_end			= $this->document_end();
			$cache_body_complete	= $document_end === '' || str_ends_with($cached_page, $document_end);
			$server_etag_raw		= $cache_body_complete
				? $this->etag($cached_page)
				: $this->etag_with_suffix($cached_page, $document_end);
			$this->pending_etag = $server_etag_raw;

			header('Last-Modified: ' . $server_last_modified);
			// cache policy: anonymous -> private + must revalidate (see cache_policy())
			$this->cache_policy();
			// Diagnostics must not be part of the cached body.
			header('X-Cache: HIT');
			header('X-Cache-Time: ' . gmdate('Y-m-d H:i:s', $mtime) . ' GMT');

			$matching_last_modified	= $client_last_modified == $server_last_modified;
			$matching_etag			= $this->etag_matches($client_etag, $server_etag_raw);

			// If-None-Match takes precedence over If-Modified-Since (RFC 9110 13.1.3)
			$not_modified			= $client_etag ? $matching_etag : $matching_last_modified;

			if ($not_modified)
			{
				# Ut::dbg('not modified');
				$this->discard_response_output();
				$this->pending_etag = $server_etag_raw;
				$this->status(304);

				return true;
			}

			// HTTP header with right Charset settings
			// TODO: other than .html?
			if (str_ends_with($this->method, '.xml'))
			{
				header('Content-Type: text/xml; charset=utf-8');
			}
			else if (($head = strpos($cached_page, '</head>')) !== false)
			{
				$head = substr($cached_page, 0, $head);

				if (preg_match('#<html[^/>]*>#', $head))
				{
					header('Content-Type: text/html; charset=utf-8');
				}
			}

			ini_set('default_charset', null);

			// New cache artifacts contain the complete response. Legacy cache
			// files without the document suffix remain readable and receive
			// the suffix from class/final.php.
			echo $cached_page;
			$this->cache_body_complete = $cache_body_complete;
			$this->cache_body_served = true;
		}

		return true;
	}

	public function check_cache($page, $method): void
	{
		$this->method	= $method;
		$this->cache_checked = true;

		// cache only for anonymous user
		$eligible = ($this->db->cache
			&& ($_SERVER['REQUEST_METHOD'] ?? 'GET') != 'POST'
			&& $method != 'edit'
			&& $method != 'watch'
			&& !$this->is_authenticated());

		if ($eligible)
		{
			$this->page		= $page;
			$this->caching	= $this->check_http_request();
		}

		if (!headers_sent())
		{
			$this->ww_set_response_header('X-Cache', $this->cache_hit ? 'HIT' : ($eligible ? 'MISS' : 'BYPASS'));
		}

	}

	/**
	 * Return whether the cache lookup selected a cached representation.
	 *
	 * A conditional HIT is represented by a bodyless 304 response, so this is
	 * deliberately separate from cache_body_served.
	 */
	public function is_cache_hit(): bool
	{
		return $this->cache_hit;
	}

	/**
	 * Is the current response eligible for the anonymous page cache?
	 *
	 * The flag is set by check_cache() and cleared by no_cache(false).
	 */
	public function is_cacheable_response(): bool
	{
		return $this->caching && !$this->is_authenticated();
	}

	/**
	 * Publish an early JSON response and discard any partial page output.
	 */
	public function json_response(mixed $data, int $status = 200, int $flags = JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES): void
	{
		$json = json_encode($data, $flags);

		if ($json === false)
		{
			throw new RuntimeException('Unable to encode the JSON response');
		}

		$this->discard_response_output();
		$this->status($status);
		$this->no_cache(false);

		if (!headers_sent())
		{
			$this->ww_set_response_header('Content-Type', 'application/json; charset=utf-8');
			$this->ww_set_response_header('X-Content-Type-Options', 'nosniff');
			$this->ww_set_response_header('Content-Length', (string) strlen($json));
		}

		echo $json;
	}

	public function store_cache(): void
	{
		if ($this->is_cacheable_response() && !$this->cache_hit)
		{
			$data = ob_get_contents();

			// Preserve the legacy empty-body behavior. In particular, the
			// literal body "0" was not cached.
			if ($data !== false && $data !== '' && $data !== '0')
			{
				// Cache the exact completed response, including the common
				// document suffix. Anonymous cacheable responses do not contain
				// the HTTP debug console. A cache write failure must not turn a
				// completed response into a fatal error.
				try {
					$this->save_page($data);
				}
				catch (Throwable $e) {
					error_log('[Cache] Unable to publish the response cache: ' . $e->getMessage());
				}
			}
		}
	}

	public function session($route): void
	{
		if ($this->db->session_store == 1)
		{
			$sess = new SessionFileStore();
			$sess->cf_file_path = CACHE_SESSION_DIR;
		}
		else
		{
			$sess = new SessionDbalStore($this->db);
			$sess->cf_dbal_table_name = $this->db->table_prefix . 'session';
		}

		$sess->cf_secret				= $this->db->system_seed_hash;
		$sess->cf_cookie_prefix			= $this->db->cookie_prefix;
		$sess->cf_cookie_persistent		= ($this->db->allow_persistent_cookie? $this->db->session_length : false);
		$sess->cf_cookie_path			= $this->db->cookie_path;
		$sess->cf_cookie_secure			= ($this->db->tls && $this->tls_session);
		$sess->cf_cookie_httponly		= true;
		$sess->cf_enable_cookie_prefix	= true;

		$sess->cf_ip					= $this->ip;
		$sess->cf_tls					= $this->tls_session;

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
	public function http_security_headers(bool $update = false): void
	{
		// The CSP nonce must always be defined: it is read by the templates and
		// by no_cache(). It is only meaningful when CSP is enabled and the
		// policy contains '{nonce}', otherwise it stays empty.
		// NB: isset() does not trigger __get() and therefore no notice.
		if (!isset($this->db->csp_nonce))
		{
			$this->db->csp_nonce = '';
		}

		if ($this->db->enable_security_headers && !headers_sent())
		{
			// Send the full header set only once per request. The $update mode is
			// still allowed to refresh the CSP header (e.g. when no_cache() turns
			// the response into a personalized one with a fresh nonce).
			if ($this->security_headers_sent && !$update)
			{
				return;
			}

			// 1. Content-Security-Policy: https://www.w3.org/TR/CSP3/
			if ($this->db->csp)
			{
				$file_name = match ((int) $this->db->csp)
				{
					1 => 'csp.conf',
					2 => 'csp_custom.conf',
				};

				$csp_header = $this->get_header_conf($file_name);

				// Auto-generate nonce if '{nonce}' is present
				if (str_contains($csp_header, '{nonce}'))
				{
					if (isset($this->sess->user_profile) || $this->no_cache)
					{
						$nonce					= $this->generate_csp_nonce();
						$this->db->csp_nonce	= ' nonce="' . $nonce . '"';
						$csp_header				= str_replace("{nonce}", $nonce, $csp_header);
					}
					else
					{
						$this->db->csp_nonce = '';

						// Cached page: fallback policy without strict-dynamic + nonce
						$csp_header = str_replace(
							["'strict-dynamic'", "'nonce-{nonce}'"],
							['', ''],
							$csp_header
						);
					}
				}

				header($csp_header);
			}

			if ($update)
			{
				return;
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

			$this->security_headers_sent = true;
		}
	}

	// TODO: cache, validate, strip possible comments
	function get_header_conf($file_name)
	{
		$csp_config		= file_get_contents(Ut::join_path(CONFIG_DIR, $file_name));

		return			str_replace(["\r", "\n", "\t"], '', $csp_config);
	}

	/**
	 * Generate a strong CSP nonce (base64url encoded)
	 */
	private function generate_csp_nonce(): string
	{
		return rtrim(strtr(base64_encode(random_bytes(24)), '+/', '-_'), '=');
	}

	/**
	* Immediate redirect to the specified URL
	* note - even though it's output as an HTTP Header, Wacko's output-buffering means that this
	* function still works anywhere in a page
	*
	* @param string $url Target URL
	*/
	function redirect($url, $permanent = false): void
	{
		if (!headers_sent())
		{
			// Make sure no &amp;'s are in, this will break the redirect
			// A redirect response does not need a body.
			$this->discard_response_output();
			$url = Ut::amp_decode($url);

			$this->status($permanent? 301 : 302);
			$this->ww_set_response_header('Location', $url);
			$this->ww_set_response_header('Content-Length', '0');

			$this->terminate();
		}
	}

	// safe exit/die for wackowiki
	function terminate(): void
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
	 * @param bool $client_only - Disables only client-side caching. Optional, default is TRUE
	 */
	function no_cache($client_only = true): void
	{
		// disable browser cache for page
		if (!headers_sent())
		{
			$this->ww_set_response_header('Cache-Control', 'no-store, max-age=0, must-revalidate');
		}
		// STS: check into session nocache code!

		// disable server cache for page
		if (!$client_only)
		{
			$this->caching = 0;

			// CSP nonces
			$this->no_cache = 1;

			// NB:
			// - empty() goes through Settings::__isset(), so a missing config
			//   key does not raise a notice
			// - the CSP refresh is only needed when the CSP header has already
			//   been sent; if it has not been sent yet, the full header set
			//   (sent later) will contain the nonce anyway
			if (empty($this->db->csp_nonce) && $this->security_headers_sent)
			{
				$this->http_security_headers(true);
			}
		}
	}

	/**
	 * Closing tags for the current response ('' for XML responses).
	 */
	public function document_end(): string
	{
		// A current cache artifact already contains the complete response.
		if ($this->cache_body_complete)
		{
			return '';
		}

		if (isset($this->method) && str_contains($this->method, '.xml'))
		{
			return '';
		}

		return self::DOCUMENT_END;
	}

	/**
	 * Discard response bytes without ending buffers below the request buffer.
	 */
	private function discard_response_output(): void
	{
		while (ob_get_level() > $this->output_buffer_level)
		{
			@ob_end_clean();
		}

		if (ob_get_level() === $this->output_buffer_level && ob_get_level() > 0)
		{
			@ob_clean();
		}
	}

	/**
	 * Select the established gzip representation without changing the legacy
	 * thresholds, token order, or case-sensitive matching.
	 */
	private function gzip_encoding(int $length): ?string
	{
		if ($length < 860 || $length > (1 << 20))
		{
			return null;
		}

		$this->add_vary('Accept-Encoding');

		foreach (['x-gzip', 'gzip'] as $candidate)
		{
			if (isset($_SERVER['HTTP_ACCEPT_ENCODING'])
				&& str_contains($_SERVER['HTTP_ACCEPT_ENCODING'], $candidate))
			{
				return $candidate;
			}
		}

		return null;
	}

	/**
	 * Is the current request authenticated?
	 * Wacko::authenticate() must have been called before this is used.
	 */
	public function is_authenticated(): bool
	{
		return isset($this->sess) && isset($this->sess->user_profile);
	}

	/**
	 * Response cache policy.
	 *
	 * Logged in  -> private, no-store    (never stored anywhere; no bfcache)
	 * Anonymous  -> private, no-cache     (may be stored, must revalidate via ETag)
	 * POST etc. -> no-store
	 *
	 * Deliberately no 'Vary: Cookie': WackoWiki rotates the NoReplay cookie on
	 * every request, so the Cookie header is never stable and 'Vary: Cookie'
	 * would force a 100 % browser cache miss rate. Correctness is ensured by
	 * 'private' (shared caches must not store the response), 'no-cache' (the
	 * browser must revalidate), 'no-store' (personalized responses are never
	 * stored), the fact that check_cache() never serves a cached page to an
	 * authenticated user.
	 */
	public function cache_policy(): void
	{
		if (headers_sent())
		{
			return;
		}

		$this->add_vary('Accept-Encoding');

		// never override an explicit "no-store" (e.g. set by no_cache() for the
		// login page or for other personalized output)
		if ($this->has_no_store())
		{
			return;
		}

		$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

		if ($this->is_authenticated() || !in_array($method, ['GET', 'HEAD']))
		{
			header('Cache-Control: private, no-store, max-age=0, must-revalidate');
			return;
		}

		// honour the global session cache limiter, if it asks for no-store
		if (isset($this->sess) && $this->sess->cf_cache_limiter === 'nocache')
		{
			header('Cache-Control: no-store, max-age=0, must-revalidate');
			return;
		}

		header('Cache-Control: private, no-cache, max-age=0, must-revalidate');
	}

	/**
	 * Is a "no-store" directive already present?
	 */
	public function has_no_store(): bool
	{
		foreach (headers_list() as $header)
		{
			if (stripos($header, 'Cache-Control:') === 0 && stripos($header, 'no-store') !== false)
			{
				return true;
			}
		}

		return false;
	}

	/**
	 * Append to the Vary header instead of overwriting it
	 * (header() replaces, and gzip()/sendfile() set Vary as well).
	 */
	public function add_vary(string $token): void
	{
		if (headers_sent())
		{
			return;
		}

		$tokens = [];

		foreach (headers_list() as $header)
		{
			if (stripos($header, 'Vary:') === 0)
			{
				foreach (explode(',', substr($header, 5)) as $t)
				{
					$t = trim($t);
					$t !== '' && $tokens[] = $t;
				}
			}
		}

		if (!in_array($token, $tokens, true))
		{
			$tokens[] = $token;
		}

		header('Vary: ' . implode(', ', $tokens));
	}

	/**
	 * Compute the ETag (strong validator) of a response body.
	 *
	 * The body is hashed together with the request's Accept-Encoding and a
	 * representation identifier, so that different variants (page, method,
	 * query string, language, compression) never share a validator.
	 */
	public function etag(string $body): string
	{
		return $this->etag_with_suffix($body);
	}

	/**
	 * Compute an ETag for a body followed by an optional legacy suffix.
	 *
	 * Kept separate from etag() so the public method retains its historical
	 * one-argument signature for existing subclasses.
	 */
	private function etag_with_suffix(string $body, string $suffix = ''): string
	{
		$identifier = $this->page . '|' . $this->method . '|' . $this->query . '|' . $this->lang;

		// Hash the same byte sequence without materializing a second
		// response-sized concatenation.
		$context = hash_init('sha1');
		hash_update($context, $body);

		if ($suffix !== '')
		{
			hash_update($context, $suffix);
		}

		hash_update($context, $_SERVER['HTTP_ACCEPT_ENCODING'] ?? '');
		hash_update($context, $identifier);

		return hash_final($context);
	}

	/**
	 * Set a response header.
	 *
	 * Kept as a small seam so response tests can record headers without
	 * relying on a web SAPI.
	 */
	protected function ww_set_response_header(string $name, string $value): void
	{
		if (!headers_sent())
		{
			header($name . ': ' . $value, true);
		}
	}

	/**
	 * Return the response headers queued by the SAPI.
	 */
	protected function ww_response_headers(): array
	{
		return headers_list();
	}

	/**
	 * Remove all queued response headers.
	 */
	protected function ww_remove_response_headers(): void
	{
		header_remove();
	}

	/**
	 * Add one complete response header line.
	 */
	protected function ww_add_response_header(string $header, bool $replace = true): void
	{
		header($header, $replace);
	}

	/**
	 * Compare an If-None-Match header value with the server side ETag.
	 * Handles wildcard, comma separated lists and weak validators
	 * (RFC 9110 13.1.2).
	 */
	public function etag_matches(?string $client_etag, string $server_etag_raw): bool
	{
		if (!$client_etag)
		{
			return false;
		}

		$client_etag = trim($client_etag);

		if ($client_etag === '*')
		{
			return true;
		}

		$client_tags = array_map(
			static function ($t) {
				$t = trim($t);

				if (str_starts_with($t, 'W/'))
				{
					$t = substr($t, 2);		// weak validator
				}

				return trim($t, '"');
			},
			explode(',', $client_etag)
		);

		return in_array($server_etag_raw, $client_tags, true);
	}

	/**
	 * Publish the validator for the completed response body.
	 *
	 * MUST be called after the debug console and the closing tags have been
	 * appended (i.e. at the very end of the request), otherwise the ETag would
	 * not identify the bytes that are sent to the client.
	 */
	public function finalize_response(): void
	{
		if ($this->finalized)
		{
			return;
		}

		$this->finalized = true;

		// Drain nested buffers into the request buffer before inspecting the
		// completed response.
		while (ob_get_level() > $this->output_buffer_level)
		{
			@ob_end_flush();
		}

		$status = http_response_code();

		if ($this->pending_etag !== null)
		{
			$this->ww_set_response_header('ETag', '"' . $this->pending_etag . '"');
		}

		if (!$this->response_status_allows_body($status))
		{
			$this->discard_response_output();

			if ($this->response_status_allows_content_length($status))
			{
				$this->ww_set_response_header('Content-Length', '0');
			}

			return;
		}

		// The response length is available without copying the buffer. Keep
		// the body un-materialized unless a validator or a gzip
		// representation actually needs its bytes.
		$length = ob_get_length();
		$length = $length === false ? 0 : $length;
		$body = null;

		$cache_eligible = $this->cache_checked
			? $this->is_cacheable_response()
			: !$this->has_no_store();
		$publish_etag = !$this->is_authenticated()
			&& $cache_eligible
			&& in_array($_SERVER['REQUEST_METHOD'] ?? 'GET', ['GET', 'HEAD'], true)
			&& $length !== 0;

		if ($publish_etag)
		{
			if ($this->pending_etag !== null)
			{
				$digest = $this->pending_etag;
			}
			else
			{
				$body = ob_get_contents();
				$body = $body === false ? '' : $body;
				$digest = $this->etag($body);
			}

			$this->ww_set_response_header('ETag', '"' . $digest . '"');

			$client_etag = !empty($_SERVER['HTTP_IF_NONE_MATCH'])
				? trim($_SERVER['HTTP_IF_NONE_MATCH'])
				: null;

			if ($this->etag_matches($client_etag, $digest))
			{
				$this->status(304);
				$this->discard_response_output();

				return;
			}
		}

		$encoding = $this->gzip_encoding($length);

		if ($encoding !== null)
		{
			if ($body === null)
			{
				$body = ob_get_contents();
				$body = $body === false ? '' : $body;
			}

			$compressed = gzencode($body, 4);

			if ($compressed !== false)
			{
				$this->discard_response_output();
				echo $compressed;
				$length = strlen($compressed);
				$this->ww_set_response_header('Content-Encoding', $encoding);
			}
		}

		$this->ww_set_response_header('Content-Length', (string) $length);

		if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'HEAD')
		{
			$this->discard_response_output();
		}
	}

	private function response_status_allows_body(int $status): bool
	{
		return !(
			($status >= 100 && $status < 200)
			|| ($status >= 300 && $status < 400)
			|| $status === 204
			|| $status === 205
			|| $status === 304
		);
	}

	private function response_status_allows_content_length(int $status): bool
	{
		return !(($status >= 100 && $status < 200)
			|| $status === 204
			|| $status === 205
			|| $status === 304);
	}

	// negotiate language with user's browser
	function user_agent_language()
	{
		$lang = $this->db->language;

		if ($this->db->multilanguage && isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
		{
			$lang_list = $this->available_languages();

			// https://www.rfc-editor.org/rfc/rfc9110.html#section-12.5.4
			preg_match_all('/([[:alpha:]]{1,8})(-([[:alpha:]|-]{1,8}))?' .
				'(\s*;\s*q\s*=\s*(1\.0{0,3}|0\.\d{0,3}))?\s*(,|$)/',
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
	function available_languages($subset = true): array
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
		$proxy_addresses			= $this->db->reverse_proxy_addresses ?? '';
		$proxy_header				= $this->db->reverse_proxy_header ?? '';

		$reverse_proxy_addresses	= preg_split('/[\s,]+/', $proxy_addresses, -1, PREG_SPLIT_NO_EMPTY);

		$x = trim($proxy_header);
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

	private function tls_session(): bool
	{
		if ((@$_SERVER['HTTPS'] && $_SERVER['HTTPS'] != 'off' && $_SERVER['HTTPS'] != '0')
			|| ($_SERVER['SERVER_PORT'] ?? null) == 443)
		{
			return true;
		}

		if (!$this->trusted_reverse_proxy())
		{
			return false;
		}

		$forwarded_proto = strtolower(trim(explode(',', (string) ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? ''))[0]));
		$forwarded_ssl = strtolower(trim(explode(',', (string) ($_SERVER['HTTP_X_FORWARDED_SSL'] ?? ''))[0]));
		$forwarded_port = trim(explode(',', (string) ($_SERVER['HTTP_X_FORWARDED_PORT'] ?? ''))[0]);

		return $forwarded_proto === 'https'
			|| $forwarded_ssl === 'on'
			|| $forwarded_port === '443';
	}

	/**
	 * Return true when the immediate peer is an explicitly trusted proxy.
	 */
	private function trusted_reverse_proxy(): bool
	{
		$addresses = preg_split(
			'/[\s,]+/',
			(string) ($this->db->reverse_proxy_addresses ?? ''),
			-1,
			PREG_SPLIT_NO_EMPTY
		);
		$remote_address = (string) ($_SERVER['REMOTE_ADDR'] ?? '');

		return $remote_address !== '' && in_array($remote_address, $addresses, true);
	}

	function status($code): void
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
			409 => 'Conflict',
			410 => 'Gone',
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
			header(($_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1') . ' ' . $code . ' ' . $text[$code], true, $code);
		}
	}

	function mime_types()
	{
		static $types;

		if (!isset($types))
		{
			$conf_file	= Ut::join_path(CONFIG_DIR, 'mime.types');
			$cache_file	= Ut::join_path(CACHE_CONFIG_DIR, 'mime.types');

			clearstatcache();

			if (!($conftime = @filemtime($conf_file)))
			{
				die($conf_file . ' not found');
			}

			// do not read stale or non-writable cachefile
			if (!((@filemtime($cache_file) >= $conftime)
				&& is_writable($cache_file)
				&& ($text = file_get_contents($cache_file))
				&& ($types = Ut::unserialize($text))))
			{
				$types = [];

				foreach (file($conf_file) as $line)
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
				@file_put_contents($cache_file, $text);
				@chmod($cache_file, CHMOD_FILE);
			}
		}

		return $types;
	}

	function mime_type($path)
	{
		$types	= $this->mime_types();
		$ext	= pathinfo($path, PATHINFO_EXTENSION);

		return $types[$ext] ?? 'application/octet-stream';
	}

	public function sendfile($path, $filename = null, $age = null): void
	{
		// Static responses replace the regular response headers, but session
		// cookies must survive header_remove().
		$cookie_headers = [];

		foreach ($this->ww_response_headers() as $header)
		{
			if (stripos($header, 'Set-Cookie:') === 0)
			{
				$cookie_headers[] = $header;
			}
		}

		$this->ww_remove_response_headers();

		foreach ($cookie_headers as $cookie_header)
		{
			$this->ww_add_response_header($cookie_header, false);
		}

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

		if ($age > 0)
		{
			$age = (int)($age * DAYSECS);
			header('Cache-Control: max-age=' . $age);
		}
		else
		{
			header('Cache-Control: private, no-cache');
		}

		$from = 0;
		$to = $size;

		if ($age >= 0)
		{
			header('Last-Modified: ' . Ut::http_date($mtime));

			if (!empty($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $mtime)
			{
				# Ut::dbg('not modified');
				$this->add_vary('Accept-Encoding');
				$this->status(304);
				return;
			}

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

		// protecting against XSS in SVG
		if ($type == 'image/svg+xml')
		{
			header("Content-Security-Policy: default-src self; script-src 'none'");
		}
		else if ($type == 'application/pdf')
		{
			header("Content-Security-Policy: default-src 'none'; style-src 'unsafe-inline'; sandbox");
		}

		// nosniff only applies to "script" and "style" types.
		if (preg_match('/^text|xml|javascript/i', $type))
		{
			header('X-Content-Type-Options: nosniff');
		}

		if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'HEAD')
		{
			// Describe the same negotiated representation as GET without
			// sending its body. Static gzip is limited to one MiB by the
			// established threshold, so calculating its encoded length here
			// does not introduce an unbounded allocation.
			if ($from == 0 && $to == $size && preg_match('/^text|xml|javascript/i', $type))
			{
				$encoding = $this->gzip_encoding($size);

				if ($encoding !== null)
				{
					$body = file_get_contents($path);
					$compressed = $body === false ? false : gzencode($body, 4);

					if ($compressed !== false)
					{
						$this->ww_set_response_header('Content-Encoding', $encoding);
						$this->ww_set_response_header('Content-Length', (string) strlen($compressed));
					}

					unset($body, $compressed);
				}
			}

			return;
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
	function parse_str($str): array
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
	function gzip(): void
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

		$this->add_vary('Accept-Encoding');

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
