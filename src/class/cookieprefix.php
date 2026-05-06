<?php

/**
 * RFC 6265bis Cookie Prefix Handler
 *
 * Provides centralized, clean abstraction for cookie prefix management.
 * All prefix logic isolated in one place for maintainability and testability.
 *
 * @see https://datatracker.ietf.org/doc/html/draft-ietf-httpbis-cookie-prefixes-00
 */
class CookiePrefix
{
	private const PREFIX_HOST		= '__Host-';
	private const PREFIX_SECURE		= '__Secure-';
	private const ALL_PREFIXES		= ['__Host-', '__Secure-'];

	/**
	 * Determine which prefix should be applied based on cookie attributes
	 *
	 * Returns exactly ONE prefix or empty string - single source of truth
	 *
	 * @param bool $secure		HTTPS connection?
	 * @param string $path		Cookie path
	 * @param string $domain	Cookie domain
	 * @return string			Prefix to use, or empty string
	 */
	public static function determine(bool $secure, string $path = '/', string $domain = ''): string
	{
		// __Host- requires: HTTPS + root path + no domain
		if ($secure && $path === '/' && empty($domain))
		{
			return self::PREFIX_HOST;
		}

		// __Secure- requires: HTTPS only
		if ($secure)
		{
			return self::PREFIX_SECURE;
		}

		// No HTTPS = no prefix
		return '';
	}

	/**
	 * Add the determined prefix to cookie name
	 *
	 * Removes any existing prefix first to avoid duplication.
	 * This is the ONLY place where prefixes are added.
	 *
	 * @param string $name		Original cookie name
	 * @param bool $secure		HTTPS connection?
	 * @param string $path		Cookie path
	 * @param string $domain	Cookie domain
	 * @return string			Prefixed cookie name
	 */
	public static function apply(string $name, bool $secure, string $path = '/', string $domain = ''): string
	{
		// Remove any existing prefix first (idempotent)
		$name = self::strip($name);

		// Determine and apply the appropriate prefix
		$prefix = self::determine($secure, $path, $domain);

		return $prefix . $name;
	}

	/**
	 * Remove all known RFC 6265bis prefixes from cookie name
	 *
	 * Safe to call on any name, whether prefixed or not.
	 *
	 * @param string $name	Cookie name (possibly prefixed)
	 * @return string		Name without any prefix
	 */
	public static function strip(string $name): string
	{
		foreach (self::ALL_PREFIXES as $prefix)
		{
			if (str_starts_with($name, $prefix))
			{
				return substr($name, strlen($prefix));
			}
		}

		return $name;
	}

	/**
	 * Find a cookie in $_COOKIE by base name, checking all prefix variations
	 *
	 * Search order:
	 * 1. With determined prefix (most specific)
	 * 2. Without any prefix (backward compatibility)
	 * 3. With alternative prefixes (migration scenarios)
	 *
	 * @param string $name				Base cookie name (without prefix)
	 * @param bool $secure				HTTPS connection?
	 * @param string $path				Cookie path
	 * @param string $domain			Cookie domain
	 * @return mixed					Cookie value or null if not found
	 */
	public static function get(string $name, bool $secure, string $path = '/', string $domain = '')
	{
		// 1. Try with determined prefix (most specific - exactly what we should find)
		$effective_prefix = self::determine($secure, $path, $domain);
		$prefixed_name = $effective_prefix . $name;

		if (isset($_COOKIE[$prefixed_name]))
		{
			return $_COOKIE[$prefixed_name];
		}

		// 2. Try unprefixed (backward compatibility or prefix disabled)
		if (isset($_COOKIE[$name]))
		{
			return $_COOKIE[$name];
		}

		// 3. Try alternative prefixes (migration: user had __Secure-, now using __Host-, or vice versa)
		foreach (self::ALL_PREFIXES as $prefix)
		{
			if ($prefix !== $effective_prefix)
			{
				$alt_name = $prefix . $name;
				if (isset($_COOKIE[$alt_name]))
				{
					return $_COOKIE[$alt_name];
				}
			}
		}

		return null;
	}

	/**
	 * Set a cookie in $_COOKIE array by all known names
	 *
	 * Ensures $_COOKIE reflects what the browser will send.
	 *
	 * @param string $name				Base cookie name
	 * @param mixed $value				Cookie value
	 * @param bool $secure				HTTPS connection?
	 * @param string $path				Cookie path
	 * @param string $domain			Cookie domain
	 */
	public static function setLocal(string $name, $value, bool $secure, string $path = '/', string $domain = ''): void
	{
		// Set with effective prefix (what browser will send)
		$prefixed_name = self::apply($name, $secure, $path, $domain);
		$_COOKIE[$prefixed_name] = $value;

		// Also set unprefixed for backward compatibility checks
		if ($prefixed_name !== $name)
		{
			$_COOKIE[$name] = $value;
		}
	}

	/**
	 * Remove cookie from $_COOKIE by all known names
	 *
	 * Cleans up all variations to prevent confusion.
	 *
	 * @param string $name				Base cookie name
	 * @param bool $secure				HTTPS connection?
	 * @param string $path				Cookie path
	 * @param string $domain			Cookie domain
	 */
	public static function deleteLocal(string $name, bool $secure, string $path = '/', string $domain = ''): void
	{
		// Remove all known prefix variations
		unset($_COOKIE[$name]);

		foreach (self::ALL_PREFIXES as $prefix)
		{
			unset($_COOKIE[$prefix . $name]);
		}
	}

	/**
	 * Validate that a cookie name complies with its prefix requirements
	 *
	 * Returns validation result with message for logging.
	 *
	 * @param string $name				Cookie name (with or without prefix)
	 * @param bool $secure				HTTPS connection?
	 * @param string $path				Cookie path
	 * @param string $domain			Cookie domain
	 * @return array					['valid' => bool, 'message' => string]
	 */
	public static function validate(string $name, bool $secure, string $path = '/', string $domain = ''): array
	{
		$prefix = self::determine($secure, $path, $domain);
		$actual_prefix = '';

		// Check if name has a prefix
		foreach (self::ALL_PREFIXES as $p)
		{
			if (str_starts_with($name, $p))
			{
				$actual_prefix = $p;
				break;
			}
		}

		// If we determined a prefix should be used, it should match
		if ($prefix && $actual_prefix === $prefix)
		{
			return ['valid' => true, 'message' => 'Cookie prefix is valid'];
		}

		// If no prefix should be used, there shouldn't be one
		if (!$prefix && !$actual_prefix)
		{
			return ['valid' => true, 'message' => 'No prefix required or used'];
		}

		// Mismatch
		if ($prefix && $actual_prefix !== $prefix)
		{
			return [
				'valid' => false,
				'message' => "Expected prefix '$prefix' but got '$actual_prefix'"
			];
		}

		if (!$prefix && $actual_prefix)
		{
			return [
				'valid' => false,
				'message' => "Prefix '$actual_prefix' used but not allowed (not HTTPS)"
			];
		}

		return ['valid' => false, 'message' => 'Unknown validation state'];
	}
}
