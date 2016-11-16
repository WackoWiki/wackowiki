<?php

if (!defined('IN_WACKO'))
{
	exit;
}

// Parse & decode QUERY_STRING.
function _parse_query_string()
{
	$get = [];

	foreach ($_GET as $k=>$v)
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
	$s = preg_replace_callback(
		'/% (?: u([A-F0-9]{1,4}) | ([A-F0-9]{1,2})) /sxi',
		"_unescape_callback",
		$s
	);

	return $s;
}

// Inplace entity replacement.
function _unescape_callback($p)
{
	if ($p[1])
	{
		$u = pack('n', $dec=hexdec($p[1]));
		$c = @iconv('UCS-2BE', "windows-1251", $u);

		if (!strlen($c) && $SCRIPT_DECODE_MODE == 'entities')
		{
			$c = '&#' . $dec.';';
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
$q		= $_GET['q'];
$ta_id	= $_GET['ta_id'];


// 1. convert into supertag and unwrap
$q = ltrim($q, '/');
$supertag1 = $this->translit( $this->unwrap_link($q) );
$supertag2 = $this->translit( $q );

// 2. going to DB two times
$limit = 10;

$pages1 = $this->db->load_all(
	"SELECT page_id, tag, supertag " .
	"FROM " . $this->db->table_prefix . "page " .
	"WHERE supertag LIKE " . $this->db->q($supertag1 . '%') . " " .
		"AND comment_on_id = '0' " .
	"ORDER BY supertag ASC LIMIT $limit");

$pages2 = $this->db->load_all(
	"SELECT page_id, tag, supertag " .
	"FROM " . $this->db->table_prefix . "page " .
	"WHERE  supertag LIKE " . $this->db->q($supertag2 . '%') . " " .
		"AND comment_on_id = '0' " .
	"ORDER BY supertag ASC LIMIT $limit");

// 3. stripping by rights
$pages = [];
$cnt = 0;

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
			$pages[$page['tag']] = $page;
			$pages[$page['tag']]['>local'] = true;
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
				$pages[$page['tag']] = $page;
				$pages[$page['tag']]['>local'] = false;
				$cnt++;
			}
		}

		if ($cnt >= $limit) break;
	}
}

// counting context
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$local_supertag_sliced	= explode('/', $this->page['supertag']);
$local_supertag			= $this->page['supertag'] . '/';
$local_context_sliced	= array_slice( $local_supertag_sliced, 0, count($local_supertag_sliced)-1 );
$local_context			= implode('/', $local_context_sliced ) . '/';

// preparing to output
$out = [];

foreach ($pages as $page)
{
	if ($page['>local'])
	{
		$tag_sliced = explode('/', $page['tag'] );

		if (strpos( $page['supertag'], $local_supertag ) === 0)
		{
			$out[] = '!/'.implode('/', array_slice( $tag_sliced, count($local_supertag_sliced) ));
		}
		else
		{
			if (strpos( $page['supertag'], $local_context ) === 0)
			{
				$out[] = implode('/', array_slice( $tag_sliced, count($local_context_sliced) ));
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

if (count($out) > 0)
{
	$found = $out[0];
}

ob_end_clean();

if (!headers_sent())
{
	header('HTTP/1.1 200 Ok');
	//header('Content-type: text/javascript; charset=windows-1251');
	header('Last-Modified: ' . Ut::http_date());
}

echo $ta_id;
echo '~~~';
echo implode('~~~', $out);
die();
