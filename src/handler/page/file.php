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
$page_id		= isset($_GET['global'])? 0 : $this->page['page_id'];
$thumbnail		= $_GET['tbn'] ?? '';

if (!preg_match('/^([' . self::PATTERN['ALPHANUM_P'] . '\.]+)$/u', $file_name))
{
	// invalid file name
	$this->http->sendfile(404);
	$this->http->terminate();
}

// 1. check existence
$file = $this->db->load_single(
	'SELECT file_id, user_id, file_name, file_ext ' .
	'FROM ' . $this->prefix . 'file ' .
	'WHERE page_id = ' . (int) $page_id . ' ' .
		'AND file_name = ' . $this->db->q($file_name) . ' ' .
		'AND deleted <> 1 ' .
	'LIMIT 1');

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

	if ($thumbnail)
	{
		[$width, $height]	= explode('x', $thumbnail);
		$file_name			= $this->thumb_name($file['file_name'], $width, $height, $file['file_ext']);
		$directory			= $page_id ? THUMB_LOCAL_DIR : THUMB_DIR;
	}
	else
	{
		$file_name			= $file['file_name'];
		$directory			= $page_id ? UPLOAD_LOCAL_DIR : UPLOAD_GLOBAL_DIR;
	}

	$file_path = Ut::join_path(
		$directory,
		($page_id ? '@' . $this->page['page_id'] . '@' : '') .
		$file_name);
}
else
{
	// no access rights
	$this->http->sendfile(403);
	$this->http->terminate();
}

// 3. passthru
$this->http->sendfile($file_path, $file_name, $age);
$this->http->terminate();
