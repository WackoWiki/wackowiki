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
	register_shutdown_function(function () use (&$http) {
		// Inject debug console data before closing tags
		echo Diag::get_debug_console_html();
		// identical closing tags as in the cached response (Http::document_end()),
		// so that both bodies are byte-identical
		echo $http->document_end();
	});
}

// publish the validator for the completed response body
// (must run after the closing tags have been appended, so that the ETag
//  identifies exactly the bytes that are sent to the client)
register_shutdown_function(function () use (&$http) {
	$http->finalize_response();
});

// gzip-compress http response
register_shutdown_function(function () use (&$http)
{
	$http->gzip();
});
