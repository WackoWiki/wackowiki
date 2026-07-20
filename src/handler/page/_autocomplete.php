<?php
/**
 * Autocomplete & Session Heartbeat Handler
 *
 * Endpoints:
 *   - ?_autocomplete=1&q=...&ta_id=...  → page autocomplete (JSON)
 *   - ?_autocomplete=1                  → session heartbeat (JSON)
 */

if (!defined('IN_WACKO'))
{
	exit;
}

/** @var \WackoWiki $this */

// Clean output buffers
while (ob_get_level() > 0)
{
	ob_end_clean();
}

// Heartbeat: no query params → lightweight keep-alive
if (!isset($_GET['q']) || !isset($_GET['ta_id']))
{
	header('Content-Type: application/json; charset=utf-8');
	header('Cache-Control: no-store, max-age=0');
	header('X-Content-Type-Options: nosniff');
	echo json_encode(
		[
			'ok'   => true,
			'time' => time(),
		],
		JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
		);
	exit;
}

// --- Autocomplete -------------------------------------------------------

$q        = (string)($_GET['q'] ?? '');
$ta_id    = (string)($_GET['ta_id'] ?? '');
$limit    = max(1, min((int)($_GET['limit'] ?? 10), 50));

// Normalize query (strip leading slash for "unwrapped" variant)
$q_trimmed = ltrim($q, '/');

$db       = $this->db;
$prefix   = $this->prefix;
$hide_locked = (bool)($db->hide_locked ?? false);
$current_tag = $this->page['tag'] ?? '';

// Single UNION query – fetch candidate tags (access check done in PHP via has_access())
$sql = '
	SELECT DISTINCT p.tag, p.page_id
	FROM (
		SELECT tag, page_id FROM ' . $prefix . 'page
		WHERE tag LIKE ' . $db->q($q_trimmed . '%') . '
		  AND comment_on_id = 0

		UNION

		SELECT tag, page_id FROM ' . $prefix . 'page
		WHERE tag LIKE ' . $db->q($q . '%') . '
		  AND comment_on_id = 0
	) p
	ORDER BY p.tag COLLATE ' . $db->collate() . ' ASC
	LIMIT ' . (int)$limit
	;

	$rows = $db->load_all($sql);

	if (!$rows)
	{
		$results = [];
	}
	else
	{
		// Context prefixes for relative link rendering
		$local_tag     = $current_tag !== '' ? $current_tag . '/' : '';
		$context_parts = $current_tag !== '' ? explode('/', $current_tag) : [];
		array_pop($context_parts);
		$local_context = $context_parts ? implode('/', $context_parts) . '/' : '/';

		$results = [];
		$count   = 0;

		foreach ($rows as $row)
		{
			$tag       = $row['tag'];
			$page_id   = (int)$row['page_id'];
			$is_local  = str_starts_with($tag, $local_tag);

			// Access check – uses standard WackoWiki has_access() (handles ACL, groups, owner, admin)
			if ($hide_locked)
			{
				$access = $this->has_access('read', $page_id);
			}
			else
			{
				$access = true;
			}

			if (!$access)
			{
				continue;
			}

			// Build display tag (relative paths for local pages)
			if ($is_local && str_starts_with($tag, $local_tag))
			{
				$display = '!/' . substr($tag, strlen($local_tag));
			}
			else if ($is_local && str_starts_with($tag, $local_context))
			{
				$display = substr($tag, strlen($local_context));
			}
			else if ($is_local)
			{
				$display = $local_context === '/' ? $tag : '/' . $tag;
			}
			else
			{
				$display = $local_context === '/' ? $tag : '/' . $tag;
			}

			$results[] = [
				'tag'   => $display,
				'local' => $is_local,
			];

			$count++;
			if ($count >= $limit)
			{
				break;
			}
		}
	}

	// JSON response
	header('Content-Type: application/json; charset=utf-8');
	header('Cache-Control: no-store, max-age=0');
	header('X-Content-Type-Options: nosniff');

	echo json_encode(
		[
			'ta_id'       => $ta_id,
			'best_match'  => $results[0] ?? null,
			'suggestions' => $results,
		],
		JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR
		);
	exit;