<?php

// Response coordinator for index.php

if (!defined('IN_WACKO'))
{
	exit;
}

$cwd = getcwd();

register_shutdown_function(function () use (&$db, &$http, &$engine, $cwd): void {
	$complete = false;

	try {
		// Preserve the historical diagnostic order: full disclosure first,
		// then the compact debug console.
		if (isset($engine))
		{
			Diag::full_disclosure($db, $http, $engine, $cwd);
		}

		// Full disclosure has rendered the SQL trace. The trace is no longer
		// needed and can retain substantial backtrace data.
		if (isset($db) && is_object($db) && isset($db->query_log))
		{
			$db->query_log = [];
		}

		// Inject debug console data before the closing tags.
		if (!(isset($http->method) && str_contains($http->method, '.xml')))
		{
			echo Diag::get_debug_console_html();
		}

		$complete = true;
	}
	finally {
		try {
			// The cached and dynamic responses use the same document suffix.
			// A diagnostic failure must not turn a partial page into a valid
			// representation, so the suffix is added only after diagnostics
			// completed successfully.
			if ($complete && !(isset($http->method) && str_contains($http->method, '.xml')))
			{
				echo $http->document_end();
			}

			if ($complete)
			{
				// Publish the exact completed representation. Cache writes are
				// atomic and only anonymous cache-eligible responses are stored.
				try {
					$http->store_cache();
				}
				catch (Throwable $e) {
					error_log('[Cache] Unable to store the response cache: ' . $e->getMessage());
				}
			}
		}
		finally {
			// The rendered page is complete. Release the engine and its
			// template/formatter graph before measuring and finalizing the
			// response so the request buffer is not accompanied by a second
			// retained representation.
			$engine = null;
			gc_collect_cycles();

			// Publish the validator for the completed response body and
			// negotiate its representation even if diagnostic rendering failed.
			$http->finalize_response();
		}
	}
});
