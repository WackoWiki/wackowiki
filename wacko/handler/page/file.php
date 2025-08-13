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

// 1. check existence
$page_id = isset($_GET['global'])? 0 : $this->page['page_id'];

$file = $this->db->load_single(
	"SELECT u.user_name AS user, f.user_id, f.file_id, f.file_name, f.file_ext, f.file_size, f.file_description, f.hits " .
	"FROM " . $this->db->table_prefix . "file f " .
		"INNER JOIN " . $this->db->table_prefix . "user u ON (f.user_id = u.user_id) " .
	"WHERE f.page_id = " . (int) $page_id . " " .
		"AND f.file_name = " . $this->db->q($_GET['get']) . " " .
		"AND f.deleted <> 1 " .
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
	// set Cache-Control: max-age (days)
	$age	= $this->has_access('read', $page_id, GUEST) === false ? 0 : 30;

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

$type = $this->http->mime_type($file_path);

if (strncmp($type, 'image/', 6)) // do not count images
{
	// count file download
	$this->db->sql_query(
		"UPDATE " . $this->db->table_prefix . "file SET " .
			"hits = " . (int) ($file['hits'] + 1) . " " .
		"WHERE file_id = " . (int) $file['file_id'] . " " .
		"LIMIT 1");
}

$this->http->sendfile($file_path, $file['file_name'], $age);
$this->http->terminate();
