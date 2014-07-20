<?php

if (!defined('IN_WACKO'))
{
	exit;
}

if (!isset($is_image)) $is_image = '';
if (!isset($is_plain)) $is_plain = '';

$error = '';
$file404 = 'images/upload404.png';
$file403 = 'images/upload403.png';
$file_path = '';

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
	"SELECT u.user_name AS user, f.user_id, f.upload_id, f.file_name, f.file_ext, f.file_size, f.file_description, f.hits ".
	"FROM ".$this->config['table_prefix']."upload f ".
		"INNER JOIN ".$this->config['table_prefix']."user u ON (f.user_id = u.user_id) ".
	"WHERE f.page_id = '".(int)$page_id."'".
		"AND f.file_name='".quote($this->dblink, $_GET['get'])."' ".
	"LIMIT 1");

if ($file)
{
	if (count($file) > 0)
	{
		// 2. check rights
		if ($this->is_admin() || (isset($file['upload_id']) && ($this->page['owner_id'] == $this->get_user_id())) ||
		($this->has_access('read')) || ($file['user_id'] == $this->get_user_id()) )
		{
			$file_path = $this->config['upload_path'.($page_id ? '_per_page' : '')].'/'.
			($page_id ? ('@'.$this->page['page_id'].'@') : '').
			$file['file_name'];
		}
		else
		{
			$error = 403;
		}
	}

	// 3. passthru
	$extension = strtolower($file['file_ext']);

	if (($extension == 'gif') || ($extension == 'jpg') || ($extension == 'jpeg') || ($extension == 'png'))
	{
		$is_image = true;
		header('Content-Type: image/'.$extension);
	}
	else if ($extension == 'txt')
	{
		$is_plain = true;
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
}
else
{
	$error = 404;

	if (!headers_sent())
	{
		header('HTTP/1.0 404 Not Found');
	}
}

#########################################################
if ($error)
{
	$is_image = true;
	$extension = 'png';
	header('Content-Type: image/'.$extension);
	$file_path = 'images/upload'.$error.'.png';

	if (!headers_sent())
	{
		header('HTTP/1.0 404 Not Found'); // 403
	}

}
#########################################################

if ($file_path)
{
	header('Content-Disposition:'.($is_image || $is_plain ? '' : ' attachment;').' filename="'.$file['file_name'].'"');

	if ($is_image == false)
	{
		// count file download
		$this->sql_query(
			"UPDATE {$this->config['table_prefix']}upload ".
			"SET hits = '".($file['hits'] + 1)."' ".
			"WHERE upload_id = '".$file['upload_id']."' ".
			"LIMIT 1");
	}

	$f = @fopen($file_path, 'rb');
	@fpassthru ($f);
}
else if ($error == 404)
{
	if (!headers_sent())
	{
		header('HTTP/1.0 404 Not Found');
	}

	echo $this->get_translation('UploadFileNotFound');
}
else
{
	if (!headers_sent())
	{
		header('HTTP/1.0 403 Forbidden');
	}

	echo $this->get_translation('UploadFileForbidden');
}

// 4. die
die();

?>