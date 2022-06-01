<?php

class SessionFileStore extends Session
{
	// config options:
	public $cf_file_path	= '/tmp';
	public $cf_file_mode	= CHMOD_SAFE;	// should be 0600 in production
	public $cf_file_encrypt	= 1;

	private $prefix = false;
	private $fd = null;
	private $fd_id;
	private $fd_name;
	private $cryptokey = null;

	public function __construct()
	{
		parent::__construct();
	}

	protected function store_open($prefix)
	{
		if ($this->prefix === false && $prefix)
		{
			$dir = $this->cf_file_path;

			if (!is_writable($dir) || is_link($dir) || !is_dir($dir))
			{
				die('SessionFileStore: inaccessible directory "' . $dir . '"');
			}

			if ($this->cf_file_encrypt && extension_loaded('openssl') && extension_loaded('mbstring'))
			{
				$cookie = $prefix . 'Rands';

				$key = Ut::http64_decode((string) $this->get_cookie($cookie));

				if (mb_strlen($key, '8bit') != 64)
				{
					$key = Ut::random_bytes(64); // 32 for encryption and 32 for authentication
					$this->send_cookie($cookie, Ut::http64_encode($key));
				}

				$this->cryptokey = $key;
			}

			$this->prefix = $this->cf_cookie_prefix . $prefix;
		}
	}

	protected function store_close()
	{
		if ($this->fd)
		{
			flock($this->fd, LOCK_UN);
			fclose($this->fd);
			$this->fd = null;
		}
	}

	protected function store_destroy()
	{
		if ($this->fd)
		{
			// ensure no one to use destroyed cache immediately after unlock
			unlink($this->fd_name);
			$this->store_close();
		}
	}

	protected function store_read($id, $create = false)
	{
		if ($this->open_file($id, $create))
		{
			$stat = fstat($this->fd);

			if (!($size = $stat['size']))
			{
				return '';
			}

			if (($text = fread($this->fd, $size)) !== false)
			{
				$text = $this->decrypt($text);
				$text && $text = gzinflate($text);
			}

			return $text;
		}
		// error

		return false;
	}

	protected function store_write($id, $text)
	{
		if ($this->open_file($id, true))
		{
			$text = gzdeflate($text, 9);
			$text = $this->encrypt($text);

			$size = strlen($text);

			if (fwrite($this->fd, $text, $size) == $size
				&& fflush($this->fd)
				&& ftruncate($this->fd, ftell($this->fd)))
			{
				return true;
			}
		}
		// error

		return false;
	}

	protected function store_gc()
	{
		$lvl1 = [];
		$preflen = strlen($this->prefix);

		foreach ((array) scandir($this->cf_file_path, SCANDIR_SORT_NONE) as $file)
		{
			if (!strncmp($file, $this->prefix, $preflen) && strlen($file) == $preflen + 1)
			{
				$lvl1[] = $file;
			}
		}

		shuffle($lvl1);

		$lvl2 = [];

		foreach ($lvl1 as $l1)
		{
			$l1p = Ut::join_path($this->cf_file_path, $l1);

			foreach ((array) scandir($l1p, SCANDIR_SORT_NONE) as $file)
			{
				if (fnmatch('[0-9a-zA-Z][0-9a-zA-Z]', $file))
				{
					$lvl2[] = $l1p . '/' . $file;
				}
			}

			if (count($lvl2) > 500) break;	// TODO magic number
		}

		shuffle($lvl2);

		$nstats = $ndels = 0;
		$past = time() - $this->cf_gc_maxlifetime;

		foreach ($lvl2 as $l2)
		{
			$stats = $dels = 0;

			foreach ((array) scandir($l2, SCANDIR_SORT_NONE) as $file)
			{
				if ($file[0] == '.') continue;
				$full = $l2 . '/' . $file;
				++$stats;
				++$nstats;

				if (filemtime($full) < $past && unlink($full))
				{
					++$dels;
					++$ndels;
				}
			}

			if ($stats == $dels)
			{
				rmdir($l2);
			}

			if ($nstats > 600 || $ndels > 100) break; // TODO magic number
		}

		# Ut::dbg('gc', $nstats, $ndels);

		return $ndels;
	}

	private function open_file($id, $create)
	{
		// check for already opened session file
		if ($this->fd && $this->fd_id === $id)
		{
			rewind($this->fd);
			return true;
		}

		$this->store_close();

		$id1 = Ut::http64_encode(hash_hmac('sha1', $id, $this->cf_secret, true));
		$fname = Ut::join_path($this->cf_file_path, $this->prefix . substr($id1, 0, 1), substr($id1, 1, 2), substr($id1, 3));

		clearstatcache();

		if (@file_exists($fname))
		{
			// we REQUIRE existent session file to be writable usual file and not symlink
			if (!is_writable($fname) || is_link($fname) || !is_file($fname))
			{
				if (!$create)
				{
					return false;
				}

				// destructive fix attempt
				unlink($fname) || rmdir($fname);
				clearstatcache();

				if (@file_exists($fname))
				{
					// to no avail... it's OK, let's try other session id ;)
					return false;
				}
			}
		}
		else
		{
			if (!$create)
			{
				return false;
			}

			$dir = dirname($fname);

			if (@file_exists($dir))
			{
				if (!is_writable($dir) || is_link($dir) || !is_dir($dir))
				{
					// destructive fix attempt
					unlink($dir) || rmdir($dir);
					clearstatcache();

					if (@file_exists($dir))
					{
						return false;
					}
				}
			}

			if (!@file_exists($dir))
			{
				mkdir($dir, ((($this->cf_file_mode >> 2) & 0111) | $this->cf_file_mode), true);
			}
			// delegate all erroring further, to fopen
		}

		// open & lock jar while trying to avoid race condition
		for ($try = 0; $try < 8; ++$try)
		{
			if (!($fd = fopen($fname, ($create? 'c+b' : 'r+b'))))
			{
				break;
			}

			if (!flock($fd, LOCK_EX))
			{
				fclose($fd);
				break;
			}

			// we need to be sure to open and lock one and only session jar
			// this race can be done by unlink/unlock/close in store_destroy
			clearstatcache();

			if (($stat0 = fstat($fd))
				&& ($stat = stat($fname))
				&& $stat0['ino'] == $stat['ino'])
			{
				$this->fd = $fd;
				$this->fd_name = $fname;
				$this->fd_id = $id;
				chmod($fname, $this->cf_file_mode);

				return true;
			}

			flock($fd, LOCK_UN);
			fclose($fd);
		}

		return false;
	}

	// session store encryption	  ====================================================
	// done by Enrico Zimuel (https://github.com/ezimuel/PHP-Secure-Session)
	private function encrypt($data)
	{
		if ($this->cryptokey)
		{
			$iv = Ut::random_bytes(16); // AES block size in CBC mode
			// Encryption
			$ciphertext = openssl_encrypt(
				$data,
				'AES-256-CBC',
				mb_substr($this->cryptokey, 0, 32, '8bit'),
				OPENSSL_RAW_DATA,
				$iv
			);
			// Authentication
			$hmac = hash_hmac(
				'SHA256',
				$iv . $ciphertext,
				mb_substr($this->cryptokey, 32, null, '8bit'),
				true
			);

			$data = $hmac . $iv . $ciphertext;
		}

		return $data;
	}

	private function decrypt($data)
	{
		if ($this->cryptokey)
		{
			$hmac		= mb_substr($data, 0, 32, '8bit');
			$iv			= mb_substr($data, 32, 16, '8bit');
			$ciphertext = mb_substr($data, 48, null, '8bit');
			// Authentication
			$hmacNew = hash_hmac(
				'SHA256',
				$iv . $ciphertext,
				mb_substr($this->cryptokey, 32, null, '8bit'),
				true
			);

			// was (!hash_equals($hmac, $hmacNew)) -- but we need no such strictness
			if ($hmac !== $hmacNew)
			{
				return false; // authentication failed
			}

			// Decrypt
			$data = openssl_decrypt(
				$ciphertext,
				'AES-256-CBC',
				mb_substr($this->cryptokey, 0, 32, '8bit'),
				OPENSSL_RAW_DATA,
				$iv
			);
		}

		return $data;
	}
}
