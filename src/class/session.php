<?php

// TODO:
// + do not store session id in filename or db index - store hash instead!
// - log of IP changes and other possible security alerts
// - allocate internal unique session which lives thru lifetime of uber-session
// - do not delete old sessions, but use them as hijack pointers
// - all sids used later than ~5secs of regenerations is hijacks

abstract class Session extends ArrayObject // for concretization extend by some SessionStoreInterface'd class
{
	private bool	$active					= false;
	private int		$regenerated			= 0;
	private string	$name					= '';		// NB [0-9a-zA-Z]+ -- should be short and descriptive (i.e. for users with enabled cookie warnings)
	private $id								= null;		// NB [0-9a-zA-Z,-]+
	private			$user_agent;
	private			$message				= null;

	public			$cf_ip;								// set by http class... STS must decide on bad coupling between session & http class
	public			$cf_tls;							// if !isset - must not act on these values (i.e. from freecap)

	public int		$cf_static				= 0;		// for use in e.g. captcha: do no regenerations
	public string	$cf_secret				= 'adyaiD9+255JeiskPybgisby'; // just for lulz. supply from above!
	public int		$cf_nonce_lifetime		= 7200;
	public int		$cf_prevent_replay		= 1;
	public int		$cf_gc_probability		= 2;
	public int		$cf_gc_maxlifetime		= 1440;
	public int		$cf_max_idle			= 1440;
	public int		$cf_max_session			= 7200;		// time to unconditionally destroy active session
	public int		$cf_regen_time			= 500;		// seconds between forced id regen
	public int		$cf_regen_probability	= 2;		// percentile probability of forced id regen
	public string	$cf_cookie_prefix		= '';
	public bool		$cf_cookie_persistent	= false;
	public int		$cf_cookie_lifetime		= 0;		// lifetime of the cookie in seconds which is sent to the browser. The value 0 means "until the browser is closed."
	public string	$cf_cookie_path			= '/';		// path to set in the session cookie
	public string	$cf_cookie_domain		= '';		// domain to set in the session cookie. '' for host name of the server which generated the cookie, according to cookies specification
														// .php.net - to make cookies visible on all subdomains
	public bool		$cf_cookie_secure		= false;	// cookie should only be sent over secure connections.
	public bool		$cf_cookie_httponly		= true;		// Marks the cookie as accessible only through the HTTP protocol. This means that the cookie won't be accessible by js and such
	public string	$cf_cookie_samesite		= COOKIE_SAMESITE;	// 'Strict' asserting that a particular cookie should only be sent with requests initiated from the same registrable domain
	public string	$cf_referer_check		= '';
	public string	$cf_cache_limiter		= 'none';
	public			$cf_cache_expire		= 180*60;	// ttl for cached session pages in seconds
	public int		$cf_cache_mtime			= 0;		// should be set before start() for cache limiters


	public function __construct()
	{
		register_shutdown_function([$this, 'terminator'], getcwd());
		parent::__construct([], parent::ARRAY_AS_PROPS);

		$ua = $_SERVER['HTTP_USER_AGENT'] ?? '';

		if (str_contains($ua, 'Trident'))
		{
			// microsoft changing ua string anytime
			$ua = 'IE';
		}

		$this->user_agent = $ua;
	}

	public function toArray()
	{
		return $this->getArrayCopy();
	}

	// effectively destroy(true) + start()
	// or... regenerate + filter!
	public function restart(): bool
	{
		if (!$this->regenerate_id(true, 'restart'))
		{
			return false;
		}

		$this->clean_vars();
		$this->populate();

		return true;
	}

	// replace the current session id with a newly generated
	// one, create and lock new file, and keep the current session information
	protected function regenerate_id($delete_old = false, $message = ''): bool
	{
		if (headers_sent($file, $line))
		{
			trigger_error("id regeneration requested after headers flushed at $file:$line", E_USER_WARNING);
			# Ut::dbg("regeneration failed by flush at $file:$line");
		}
		else if ($this->active)
		{
			if ($this->regenerated)
			{
				// single regeneration in one session would be enough
				return true;
			}

			$now = time();
			$this->sticky__log[] = [$now, $message];

			if (count($this->sticky__log) > 15)
			{
				$this->sticky__log = array_slice($this->sticky__log, 0, 1) + ['...'] + array_slice($this->sticky__log, -10, null);
			}

			// let old page live for some seconds to gather missing requests (ajax etc.)
			if (!isset($this->__expire))
			{
				$this->__expire = ($delete_old? 0 : $now + 5); // STS magic number
			}

			$this->write_session();
			unset($this->__expire);

			// and pray so it will stop.. ;)
			do
			{
				$this->set_new_id();
			}
			while ($this->store_read($this->id) !== false);

			// create & lock new jar
			if ($this->store_read($this->id, true) !== '')
			{
				// error!
			}

			$this->__regenerated = $now;
			$this->regenerated = 1;

			return true;
		}

		return false;
	}

	public function start($name = null, $id = null): bool
	{
		if ($this->active)
		{
			return true;
		}

		// allow to reuse original session name on session restarts
		if ($name || !$this->name)
		{
			// filter name
			$name = preg_replace('/[^a-zA-Z\d_\-]+/', '', $name);

			if (!$name || ctype_digit($name))
			{
				$name = 'sesid';
			}

			$this->name = $name;
		}

		$id_from_cookie = (!$id && ($id = $this->get_cookie($this->name)));

		if ($id && $this->cf_referer_check
			&& !str_contains($_SERVER['HTTP_REFERER'], $this->cf_referer_check))
		{
			$id = null;
		}

		if ($id && !$this->store_validate_id($id))
		{
			$id = null;
		}

		$this->store_open($this->name);

		if (!$id || ($text = $this->store_read($id)) === false || !($data = Ut::unserialize($text)))
		{
			// here we generate new session id for utterly new, or stale/evil id offered by client
			// (or file error, per se)
			$this->set_new_id();
			$this->regenerated = 2;

			// create & lock new jar
			if ($this->store_read($this->id, true) !== '')
			{
				// error!
			}

			$data = [];
		}
		else
		{
			// we obtained (from the user or from the cookie) perfectly valid session id..
			$this->id = $id;
			$this->regenerated = 0;

			if (!$id_from_cookie)
			{
				$this->send_cookie($this->name, $this->id);
			}
		}

		$this->exchangeArray($data);
		$this->active = true;

		$this->cache_limiter(); // TODO - why it is in the session?

		$now = time();

		if (isset($this->__started) && !$this->cf_static)
		{
			$message = '';
			$noreplay = null;

			if ($this->cf_prevent_replay && !($noreplay = $this->verify_nonce('NoReplay', $this->get_cookie($this->name . 'NoReplay'), 3)))
			{
				$message = 'replay';
				$destroy = 2;
			}
			else if (isset($this->__expire) && !$this->__expire)
			{
				$message = 'obsolete';
				$destroy = 2;
			}
			else if (isset($this->__expire) && $now > $this->__expire)
			{
				$message = 'reg_expire';
				$destroy = 2;
			}
			else if ($now - $this->__started > $this->cf_max_session)
			{
				$message = 'max_session';
				$destroy = 2;
			}
			else if ($now - $this->__updated > $this->cf_max_idle)
			{
				$message = 'max_idle';
				$destroy = 2;
			}
			else if (!similar_text($this->__user_agent, $this->user_agent, $perc) || $perc < 95)
			{
				$message = 'ua';
				$destroy = 2;
			}
			else if (isset($this->cf_tls) && isset($this->__user_tls) && $this->cf_tls != $this->__user_tls)
			{
				$message = 'tls';
				$destroy = 2;
			}
			else if (isset($this->cf_ip) && isset($this->__user_ip) && $this->cf_ip != $this->__user_ip)
			{
				$message = 'ip';
				$destroy = 1;
				@++$this->sticky__ip[$this->__user_ip]; // strangely it works as intended :)
			}
			else if ($now - $this->__regenerated > $this->cf_regen_time || Ut::rand(0, 99) < $this->cf_regen_probability)
			{
				$destroy = 0;
			}

			// if noreplay nonce was used 2nd time - it is ajax'y fast replay, so leave all active regen stuff till more consistent time
			if ($noreplay === -1)
			{
				$this->cf_prevent_replay = 0;
				$this->regenerated = 3;
			}
			else if (isset($destroy))
			{
				$this->message = $message;
				# Ut::dbg($destroy, $message);
				$this->regenerate_id($destroy, $message);

				if ($destroy == 2)
				{
					$this->clean_vars(); // full reset
				}
			}
		}

		$this->populate();

		return $this->active;
	}

	private function populate()
	{
		$this->prevent_replay();

		if (!isset($this->__started))
		{
			$now = time();
			isset($this->sticky__created)  ||  $this->sticky__created = $now;

			$this->__started =
			$this->__regenerated = $now;
			$this->__user_agent = $this->user_agent;
			isset($this->cf_tls)  &&  $this->__user_tls = $this->cf_tls;
			isset($this->cf_ip)   &&  $this->__user_ip  = $this->cf_ip;
		}
	}

	public function message()
	{
		return $this->message;
	}

	public function active(): bool
	{
		return $this->active;
	}

	public function id()
	{
		return $this->id;
	}

	public function name(): string
	{
		return $this->name;
	}

	private function write_session()
	{
		$this->__updated = time();
		$this->store_write($this->id, Ut::serialize($this->toArray()));
	}

	// write session data, end session
	public function write_close()
	{
		if ($this->active)
		{
			$this->write_session();
			// check error!
			$this->store_close();
			$this->active = false;
		}
	}

	// our little flash data toolkit
	// set variable which can be available in this and NEXT session(s)
	// and then automagically purged
	public function set_flash($name, $value, $lifetime = 2)
	{
		$this[$name] = $value;
		$this->sticky__flash[$name] = $lifetime;
	}

	// shutdown-registered worker
	public function terminator($cwd)
	{
		// expire flashdata
		if (isset($this->sticky__flash))
		{
			foreach ($this->sticky__flash as $var => $age)
			{
				if (!isset($this[$var]))
				{
					unset($this->sticky__flash[$var]);
				}
				else if (--$age <= 0)
				{
					unset($this[$var]);
					unset($this->sticky__flash[$var]);
				}
				else
				{
					$this->sticky__flash[$var] = $age;
				}
			}
		}

		// shutdown functions called with cwd == /
		// this is for Ut::dbg etc.
		chdir($cwd);

		$this->write_close();

		if (Ut::rand(0, 99) < $this->cf_gc_probability)
		{
			$this->store_gc();
			// "purged $returned expired session objects"
		}
	}

	private function prevent_replay()
	{
		if ($this->cf_prevent_replay)
		{
			$this->send_cookie($this->name . 'NoReplay',
				$this->create_nonce('NoReplay', $this->cf_max_session));
		}
	}

	private static function nonce_index($action, $code): string
	{
		return $action . '.' . substr(base64_encode(hash('sha1', (string) $code, true)), 1, 11);
	}

	public function create_nonce($action, $expires = null): string
	{
		$code = Ut::random_token(11);
		$this->__nonces[static::nonce_index($action, $code)] = time() + ($expires ?: $this->cf_nonce_lifetime);
		# Ut::dbg('+++', $action, $code);
		return $code;
	}

	public function verify_nonce($action, $code, $protect = 0)
	{
		# Ut::dbg('???', $action, $code);
		if (!($nonces = @$this->__nonces))
		{
			return false;
		}

		$now = time();

		foreach ($nonces as $index => $expires)
		{
			if ($expires < $now)
			{
				unset($nonces[$index]);
			}
		}

		$index = static::nonce_index($action, $code);

		if ($ret = isset($nonces[$index]))
		{
			if ($protect)
			{
				if ((int) $nonces[$index] == $nonces[$index])
				{
					$nonces[$index] = time() + $protect + 0.01;
				}
				else
				{
					$ret = -1; // repeated usage of protected nonce
				}
			}
			else
			{
				unset($nonces[$index]);
			}
		}

		$this->__nonces = $nonces;

		return $ret;
	}

	// those two are for possible override in store methods
	protected function store_generate_id(): string
	{
		return Ut::random_token(21);
	}

	protected function store_validate_id($id)
	{
		return preg_match('/^[a-zA-Z\d]{21}$/', $id);
	}

	// clean vars on hard reset, leave sticky_ vars in place
	private function clean_vars()
	{
		foreach ($this->toArray() as $var => $val) // do not optimize toArray - php likes it this way
		{
			if (strncmp($var, 'sticky_', 7))
			{
				unset($this[$var]);
			}
		}
	}

	private function cache_limiter()
	{
		if (!headers_sent())
		{
			$age = $this->cf_cache_expire;

			switch ($this->cf_cache_limiter)
			{
				case 'public':
					header("Cache-Control: public, max-age=$age");
					break;

				case 'private':
					header('Cache-Control: max-age=0');
					// FALLTHRU

				case 'private_no_expire':
					header("Cache-Control: private, max-age=$age");
					break;

				case 'nocache':
					header('Cache-Control: no-store, no-cache, must-revalidate');
					return; // suppress last-modified

				default:
				case 'none':
					return;
			}

			if ($this->cf_cache_mtime > 0)
			{
				header('Last-Modified: ' . Ut::http_date($this->cf_cache_mtime));
			}
		}
	}

	private function set_new_id()
	{
		$this->id = $this->store_generate_id();
		$this->send_cookie($this->name, $this->id);
	}

	// legacy get/set/delete from engine
	function get_cookie($name)
	{
		return @$_COOKIE[$this->cf_cookie_prefix . $name];
	}

	// persistent: false, or number of days (0 for config default's days)
	function set_cookie($name, $value, $persistent = false)
	{
		$name = $this->cf_cookie_prefix . $name;
		$this->setcookie($name, $value,
			(($persistent !== false && $this->cf_cookie_persistent !== false)? ($persistent ?: $this->cf_cookie_persistent) * DAYSECS + time() : 0));
		$_COOKIE[$name] = $value;
	}

	function delete_cookie($name)
	{
		$name = $this->cf_cookie_prefix . $name;
		$this->unsetcookie($name);
		unset($_COOKIE[$name]);
	}

	protected function send_cookie($name, $value)
	{
		$this->setcookie($this->cf_cookie_prefix . $name, $value, ($this->cf_cookie_lifetime > 0? time() + $this->cf_cookie_lifetime : 0));
	}

	// just sugar
	public function unsetcookie($name)
	{
		$this->setcookie($name);
	}

	public function setcookie($name, $value = null, $expires = 0, $path = null, $domain = null, $secure = null, $httponly = null, $samesite = null)
	{
		if (headers_sent($file, $line))
		{
			trigger_error("cannot place session cookie $name=$value due to $file:$line", E_USER_WARNING);
			# Ut::dbg("session setcookie $name failed by $file:$line");
			return;
		}

		isset($path)		|| $path		= $this->cf_cookie_path;
		isset($domain)		|| $domain		= $this->cf_cookie_domain;
		isset($secure)		|| $secure		= $this->cf_cookie_secure;
		isset($httponly)	|| $httponly	= $this->cf_cookie_httponly;
		isset($samesite)	|| $samesite	= $this->cf_cookie_samesite;

		// cookie name must be rfc2616 2.2 token:
		$name = Ut::urlencode('/[\x7F\x00-\x1F\s()<>@,;:\\\\"\/\[\]?={}%]/', $name);

		$this->remove_cookie($name);

		if (Ut::is_empty($value))
		{
			$expires	= 1;
			$value		= 'deleted';
		}

		// rfc6265 4.1.1 cookie-octet
		$value = Ut::urlencode('/[\x7F-\xFF\x00-\x1F\s",;%\\\\]/', $value);

		$cookie = 'Set-Cookie: '. $name . '=' . $value;

		if ($expires > 0)
		{
			$expires = (int) $expires;
			$cookie .= '; expires=' . Ut::http_date($expires);

			// max-age cannot start with 0, as per rfc6265 4.1.1
			if (($expires -= time()) > 0)
			{
				$cookie .= '; Max-Age=' . $expires;
			}
		}

		$path		&& $cookie .= '; path=' . $path;
		$domain		&& $cookie .= '; domain=' . $domain;
		$secure		&& $cookie .= '; secure';
		$httponly	&& $cookie .= '; httponly';
		$samesite	&& $cookie .= '; SameSite=' . $samesite;

		header($cookie, false); // false -- add, not replace

		return true;
	}

	private function remove_cookie($cookie)
	{
		if (headers_sent())
		{
			return;
		}

		$set	= 'Set-Cookie';
		$clen	= strlen($cookie);
		$found	= 0;
		$readd	= [];

		foreach (headers_list() as $name => $value)
		{
			if (!strcasecmp((string) $name, $set))
			{
				if (!strncmp($value, $cookie, $clen) && substr($value, $clen, 1) == '=')
				{
					++$found;
				}
				else
				{
					$readd[] = $value;
				}
			}
		}

		if ($found)
		{
			header_remove($set);

			foreach ($readd as $value)
			{
				header($set . ': ' . $value, false);
			}
		}
	}
}
