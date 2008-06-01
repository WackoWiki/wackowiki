<?php

// Parse & decode QUERY_STRING.
function _parseQueryString()
{
	$get = array();
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
      "_unescapeCallback",
	$s
	);
	return $s;
}

// Inplace entity replacement.
function _unescapeCallback($p)
{
	if ($p[1])
	{
		$u = pack('n', $dec=hexdec($p[1]));
		$c = @iconv('UCS-2BE', "windows-1251", $u);
		if (!strlen($c) && $SCRIPT_DECODE_MODE == 'entities')
		{
			$c = '&#'.$dec.';';
		}
	} else
	{
		if ($p[2] === "26" && $SCRIPT_DECODE_MODE == 'entities')
		{
			$c = "&amp;";
		} else
		{
			$c = chr(hexdec($p[2]));
		}
	}
	return $c;
}

// �������� ������.
_parseQueryString();
$q     = $_GET["q"];
$ta_id = $_GET["ta_id"];


// 1. ��������� ����� � �������� � ����������
$q = ltrim($q, "/");
$supertag1 = $this->NpjTranslit( $this->UnwrapLink($q) );
$supertag2 = $this->NpjTranslit( $q );

// 2. ����� � �� ��� ����
$limit = 10;

$pages1 = $this->LoadAll("select ".$this->pages_meta." from ".
$this->config["table_prefix"]."pages where ".
            " supertag like '".quote($this->dblink, $supertag1)."%' and comment_on = '' order by supertag asc limit $limit");
$pages2 = $this->LoadAll("select ".$this->pages_meta." from ".
$this->config["table_prefix"]."pages where ".
            " supertag like '".quote($this->dblink, $supertag2)."%' and comment_on = '' order by supertag asc limit $limit");

// 3. �������� �� ������
$pages = array();
$cnt=0;
if ($pages1)
foreach ($pages1 as $page)
{
	if ($this->config["hide_locked"]) $access = $this->HasAccess("read",$page["tag"]);
	else $access = true;
	if ($access)
	{
		$pages[$page["tag"]] = $page;
		$pages[$page["tag"]][">local"] = true;
		$cnt++;
	}

	if ($cnt >= $limit) break;
}
if ($pages2)
foreach ($pages2 as $page)
{
	if ($this->config["hide_locked"]) $access = $this->HasAccess("read",$page["tag"]);
	else $access = true;
	if ($access)
	{
		if (!isset($pages[$page["tag"]]))
		{
			$pages[$page["tag"]] = $page;
			$pages[$page["tag"]][">local"] = false;
			$cnt++;
		}
	}

	if ($cnt >= $limit) break;
}

// ������� ��������
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
$local_supertag_sliced = explode("/", $this->page["supertag"]);
$local_supertag        = $this->page["supertag"]."/";
$local_context_sliced  = array_slice( $local_supertag_sliced, 0,
sizeof($local_supertag_sliced)-1 );
$local_context  = implode("/", $local_context_sliced )."/";

// �������������� � ������
$out = array();
foreach( $pages as $page )
{
	if ($page[">local"])
	{
		$tag_sliced = explode("/", $page["tag"] );
		if (strpos( $page["supertag"], $local_supertag ) === 0)
		$out[] = "!/".implode("/", array_slice( $tag_sliced, sizeof($local_supertag_sliced) ));
		else
		if (strpos( $page["supertag"], $local_context ) === 0)
		$out[] = implode("/", array_slice( $tag_sliced, sizeof($local_context_sliced) ));
		else
		if ($local_context == "/")
		$out[] = $page["tag"];
		else
		$out[] = "/".$page["tag"];
	}
	else
	{
		if ($local_context == "/")
		$out[] = $page["tag"];
		else
		$out[] = "/".$page["tag"];
	}
}

$found = false;
if (sizeof($out) > 0) $found = $out[0];

ob_end_clean();
header("HTTP/1.0 200 Ok");
//header("Content-type: text/javascript; charset=windows-1251");
header("Last-Modified: ".(string)(gmdate('D, d M Y H:i:s \G\M\T', time()) ));
echo $ta_id;
echo "~~~";
echo implode("~~~", $out);
die();

?>