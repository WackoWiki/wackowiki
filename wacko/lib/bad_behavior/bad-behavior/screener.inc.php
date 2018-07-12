<?php if (!defined('BB2_CWD')) die("I said no cheating!");

// Bad Behavior browser screener

// Deprecated. Remove any cookies if they exist.
function bb2_screener_cookie($settings, $package, $cookie_name, $cookie_value)
{
	// Delete existing cookie, if any
	setcookie($cookie_name, $cookie_value, 1, bb2_relative_path());
}

function bb2_screener($settings, $package)
{
	bb2_screener_cookie($settings, $package, BB2_COOKIE, $cookie_value);
}
