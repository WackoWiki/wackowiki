<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Parse & decode QUERY_STRING.
function _parse_query_string()
{
	$get = [];

	foreach ($_GET as $k => $v)
	{
		$k = _unescape($k);
		$v = _unescape($v);
		$get[$k] = $v;
	}

	$_GET = $get;
}
// Undo JS's escape() function.
function _unescape($s)
{
	return preg_replace_callback(
		'/% (?: u([A-F\d]{1,4}) | ([A-F\d]{1,2})) /sxi',
		"_unescape_callback",
		$s
	);
}

// Inplace entity replacement.
function _unescape_callback($p)
{
	if ($p[1])
	{
		$u = pack('n', $dec=hexdec($p[1]));
		$c = @iconv('UCS-2BE', 'UTF-8', $u);

		if (!strlen($c) && $SCRIPT_DECODE_MODE == 'entities')
		{
			$c = '&#' . $dec . ';';
		}
	}
	else
	{
		if ($p[2] === '26' && $SCRIPT_DECODE_MODE == 'entities')
		{
			$c = "&amp;";
		}
		else
		{
			$c = chr(hexdec($p[2]));
		}
	}

	return $c;
}

// Getting a query
_parse_query_string();

if(isset($_GET['q']) && isset($_GET['ta_id']))
{
	// Working for autocomplete
	$q		= $_GET['q'];
	$ta_id	= $_GET['ta_id'];
}
else
{
	// Any answer to restart session counter
	echo '1';
	die();
}

// 1. unwrap
$q		= utf8_ltrim($q, '/');
$tag1	= $this->unwrap_link($q);
$tag2	= $q;

// 2. going to DB two times
$limit	= 10;

$pages1 = $this->db->load_all(
	"SELECT page_id, tag " .
	"FROM " . $this->db->table_prefix . "page " .
	"WHERE tag LIKE " . $this->db->q($tag1 . '%') . " " .
		"AND comment_on_id = 0 " .
	"ORDER BY tag COLLATE utf8mb4_unicode_520_ci ASC " .
	"LIMIT " . (int) $limit);

$pages2 = $this->db->load_all(
	"SELECT page_id, tag " .
	"FROM " . $this->db->table_prefix . "page " .
	"WHERE tag LIKE " . $this->db->q($tag2 . '%') . " " .
		"AND comment_on_id = 0 " .
	"ORDER BY tag COLLATE utf8mb4_unicode_520_ci ASC " .
	"LIMIT " . (int) $limit);

// 3. stripping by rights
$pages	= [];
$cnt	= 0;

if ($pages1)
{
	foreach ($pages1 as $page)
	{
		if ($this->db->hide_locked)
		{
			$access = $this->has_access('read', $page['page_id']);
		}
		else
		{
			$access = true;
		}

		if ($access)
		{
			$pages[$page['tag']]			= $page;
			$pages[$page['tag']]['>local']	= true;
			$cnt++;
		}

		if ($cnt >= $limit) break;
	}
}

if ($pages2)
{
	foreach ($pages2 as $page)
	{
		if ($this->db->hide_locked)
		{
			$access = $this->has_access('read', $page['page_id']);
		}
		else
		{
			$access = true;
		}

		if ($access)
		{
			if (!isset($pages[$page['tag']]))
			{
				$pages[$page['tag']]			= $page;
				$pages[$page['tag']]['>local']	= false;
				$cnt++;
			}
		}

		if ($cnt >= $limit) break;
	}
}

// counting context
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$local_tag_sliced		= explode('/', $this->page['tag']);
$local_tag				= $this->page['tag'] . '/';
$local_context_sliced	= array_slice($local_tag_sliced, 0, count($local_tag_sliced) - 1);
$local_context			= implode('/', $local_context_sliced) . '/';

// preparing to output
$out = [];

foreach ($pages as $page)
{
	if ($page['>local'])
	{
		$tag_sliced = explode('/', $page['tag']);

		if (mb_strpos($page['tag'], $local_tag) === 0)
		{
			$out[] = '!/' . implode('/', array_slice($tag_sliced, count($local_tag_sliced)));
		}
		else
		{
			if (mb_strpos( $page['tag'], $local_context ) === 0)
			{
				$out[] = implode('/', array_slice($tag_sliced, count($local_context_sliced)));
			}
			else
			{
				if ($local_context == '/')
				{
					$out[] = $page['tag'];
				}
				else
				{
					$out[] = '/' . $page['tag'];
				}
			}
		}
	}
	else
	{
		if ($local_context == '/')
		{
			$out[] = $page['tag'];
		}
		else
		{
			$out[] = '/' . $page['tag'];
		}
	}
}

$found = false;

if (!empty($out))
{
	$found = $out[0];
}

ob_end_clean();

if (!headers_sent())
{
	header(($_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.0') . ' 200 Ok');
	//header('Content-type: text/javascript; charset=utf-8');
	header('Last-Modified: ' . Ut::http_date());
}

echo $ta_id;
echo '~~~';
echo implode('~~~', $out);
die();
