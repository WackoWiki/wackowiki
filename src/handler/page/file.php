<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($_GET['get']) || (!isset($_GET['global']) && !$this->page))
{
	$this->show_must_go_on();
}

$file_path		= '';
$file_name		= $_GET['get'];

if (!preg_match('/^([' . self::PATTERN['ALPHANUM_P'] . '\.]+)$/u', $file_name))
{
	// invalid file name
	$this->http->sendfile(404);
	$this->http->terminate();
}

// 1. check existence
$page_id = isset($_GET['global'])? 0 : $this->page['page_id'];

$file = $this->db->load_single(
	"SELECT file_id, user_id, file_name " .
	"FROM " . $this->prefix . "file " .
	"WHERE page_id = " . (int) $page_id . " " .
		"AND file_name = " . $this->db->q($file_name) . " " .
		"AND deleted <> 1 " .
	"LIMIT 1");

if (!$file)
{
	$this->http->sendfile(404);
	$this->http->terminate();
}

// 2. check access rights
if (   $this->is_admin()
	|| (isset($file['file_id']) && ($this->page['owner_id'] == $this->get_user_id()))
	|| ($this->has_access('read'))
	|| ($file['user_id'] == $this->get_user_id()) )
{
	$file_path = Ut::join_path(
		($page_id? UPLOAD_PER_PAGE_DIR : UPLOAD_GLOBAL_DIR),
		($page_id
			? '@' . $this->page['page_id'] . '@'
			: '') .
		$file['file_name']);
}
else
{
	// no access rights
	$this->http->sendfile(403);
	$this->http->terminate();
}

// 3. passthru
$this->http->sendfile($file_path, $file['file_name']);
$this->http->terminate();
