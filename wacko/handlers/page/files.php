<?php

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

$what = $this->load_all(
	"SELECT u.user_name AS user, f.upload_id, f.file_name, f.file_ext, f.file_size, f.description, f.hits ".
	"FROM ".$this->config['table_prefix']."upload f ".
		"INNER JOIN ".$this->config['table_prefix']."user u ON (f.user_id = u.user_id) ".
	"WHERE f.page_id = '".quote($this->dblink, $page_id)."'".
		"AND f.file_name='".quote($this->dblink, $_GET['get'])."'");

if (sizeof($what) > 0)
{
	// 2. check rights
	if ($this->is_admin() || (isset($desc['upload_id']) && ($this->page['owner_id'] == $this->get_user_id())) ||
	($this->has_access('read')) || ($desc['user_id'] == $this->get_user_id()) )
	{
		$filepath = $this->config['upload_path'.($page_id ? '_per_page' : '')].'/'.
		($page_id ? ('@'.$this->page['page_id'].'@') : '').
		$what[0]['file_name'];
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
$extension = strtolower($what[0]['file_ext']);

if (($extension == 'gif') || ($extension == 'jpg') || ($extension == 'jpeg') || ($extension == 'png'))
{
	$isimage = true;
	header("Content-Type: image/".$extension);

	if ($error)
	{
		$filepath = 'images/upload'.$error.'.gif';
		header("HTTP/1.0 404 Not Found");
	}
}
else if ($extension == 'txt')
{
	$isplain = true;
	header("Content-Type: text/plain");
}
else if ($extension == 'pdf')
{
	header("Cache-control: private");
	header("Content-Type: application/pdf");
}
else
{
	header("Cache-control: private");
	header("Content-Type: application/download");
}

if ($filepath)
{
	header("Content-Disposition:".( $isimage || $isplain ? "" : " attachment;" )." filename=".$what[0]['file_name']);

	if (!isset($isimage))
	{
		// count file download
		$this->query(
			"UPDATE {$this->config['table_prefix']}upload ".
			"SET hits = '".quote($this->dblink, $what[0]['hits'] + 1)."' ".
			"WHERE upload_id = '".quote($this->dblink, $what[0]['upload_id'])."'");
	}

	$f = @fopen( $filepath, 'rb' );
	@fpassthru ($f);
}
else if ($error == 404)
{
	// Not sure what the point of wrapping it in the conditional was
	// if (function_exists('virtual')) header("HTTP/1.0 404 Not Found");
	header("HTTP/1.0 404 Not Found");

	echo $this->get_translation('UploadFileNotFound');
}
else
{
	// Not sure what the point of wrapping it in the conditional was
	// if (function_exists('virtual')) header("HTTP/1.0 403 Forbidden");
	header("HTTP/1.0 403 Forbidden");

	echo $this->get_translation('UploadFileForbidden');
}

// 4. die
die();

?>