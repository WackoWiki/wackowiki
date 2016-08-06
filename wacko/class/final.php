<?php

// not a class, just finalizer for index.php

if (!defined('IN_WACKO'))
{
	exit;
}

// so we can dbg other shutdown functions
$cwd = getcwd();
register_shutdown_function(function () use (&$db, &$http, &$engine, $cwd)
{
	Diag::full_disclosure($db, $http, $engine, $cwd);
});
//register_shutdown_function(['Diag', 'full_disclosure'], $db, $http, $engine, getcwd());

// closing tags
if (strpos($http->method, '.xml') === false)
{
	register_shutdown_function(function () { echo "\n</body>\n</html>"; });
}

// gzip-compress http response
register_shutdown_function(function () use (&$http)
{
	$http->gzip();
});
