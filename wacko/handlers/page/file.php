<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($isimage)) $isimage = '';
if (!isset($isplain)) $isplain = '';
if (!isset($desc))$desc  = '';
$error = '';
$file404 = 'images/upload404.gif';
$file403 = 'images/upload403.gif';

// 1. check existence
if (isset($_GET['global']))
{
	$page_id = 0;
}
else
{
	$page_id = $this->page['page_id'];
}

$file = $this->load_single(
	"SELECT u.user_name AS user, f.upload_id, f.file_name, f.file_ext, f.file_size, f.description, f.hits ".
	"FROM ".$this->config['table_prefix']."upload f ".
		"INNER JOIN ".$this->config['table_prefix']."user u ON (f.user_id = u.user_id) ".
	"WHERE f.page_id = '".quote($this->dblink, $page_id)."'".
		"AND f.file_name='".quote($this->dblink, $_GET['get'])."' ".
	"LIMIT 1");

if (count($file) > 0)
{
	// 2. check rights
	if ($this->is_admin() || (isset($desc['upload_id']) && ($this->page['owner_id'] == $this->get_user_id())) ||
	($this->has_access('read')) || ($desc['user_id'] == $this->get_user_id()) )
	{
		$filepath = $this->config['upload_path'.($page_id ? '_per_page' : '')].'/'.
		($page_id ? ('@'.$this->page['page_id'].'@') : '').
		$file['file_name'];
	}
	else
	{
		$error = 403;
	}
}
else
{
	$error = 404;
}

// 3. passthru
$extension = strtolower($file['file_ext']);

if (($extension == 'gif') || ($extension == 'jpg') || ($extension == 'jpeg') || ($extension == 'png'))
{
	$isimage = true;
	header('Content-Type: image/'.$extension);

	if ($error)
	{
		$filepath = 'images/upload'.$error.'.gif';

		if (!headers_sent())
		{
			header('HTTP/1.0 404 Not Found');
		}

	}
}
else if ($extension == 'txt')
{
	$isplain = true;
	header('Content-Type: text/plain');
}
else if ($extension == 'pdf')
{
	header('Cache-control: private');
	header('Content-Type: application/pdf');
}
else
{
	header('Cache-control: private');
	header('Content-Type: application/download');
}

if ($filepath)
{
	header('Content-Disposition:'.($isimage || $isplain ? '' : ' attachment;').' filename="'.$file['file_name'].'"');

	if ($isimage == false)
	{
		// count file download
		$this->sql_query(
			"UPDATE {$this->config['table_prefix']}upload ".
			"SET hits = '".quote($this->dblink, $file['hits'] + 1)."' ".
			"WHERE upload_id = '".quote($this->dblink, $file['upload_id'])."' ".
			"LIMIT 1");
	}

	$f = @fopen($filepath, 'rb');
	@fpassthru ($f);
}
else if ($error == 404)
{
	// Not sure what the point of wrapping it in the conditional was
	// if (function_exists('virtual')) header('HTTP/1.0 404 Not Found');
	if (!headers_sent())
	{
		header('HTTP/1.0 404 Not Found');
	}

	echo $this->get_translation('UploadFileNotFound');
}
else
{
	// Not sure what the point of wrapping it in the conditional was
	// if (function_exists('virtual')) header('HTTP/1.0 403 Forbidden');
	if (!headers_sent())
	{
		header('HTTP/1.0 403 Forbidden');
	}

	echo $this->get_translation('UploadFileForbidden');
}

// 4. die
die();

?>