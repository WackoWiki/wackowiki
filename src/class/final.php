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

// closing tags with debug console injection
if (!(isset($http->method) && str_contains($http->method, '.xml')))
{
	register_shutdown_function(function () {
		// Inject debug console data before closing tags
		echo Diag::get_debug_console_html();
		echo "\n</body>\n</html>";
	});
}

// gzip-compress http response
register_shutdown_function(function () use (&$http)
{
	$http->gzip();
});
