<?php

if (!defined('IN_WACKO'))
{
	exit;
}

$error			= '';
$file_path		= '';

// https://www.iana.org/assignments/media-types/media-types.xhtml
$extension_map	= array(
	// application
	'bz'		=> array('application', 'application/x-bzip'),
	'bz2'		=> array('application', 'application/x-bzip2'),
	'doc'		=> array('application', 'application/msword'),
	'exe'		=> array('application', 'application/octet-stream'),
	'latex'		=> array('application', 'application/x-latex'),
	'gtar'		=> array('application', 'application/x-gtar'),
	'gz'		=> array('application', 'application/x-gzip'),
	'gzip'		=> array('application', 'application/x-gzip'),
	'pdf'		=> array('application', 'application/pdf'),
	'ppt'		=> array('application', 'application/mspowerpoint'),
	'ps'		=> array('application', 'application/postscript'),
	'tar'		=> array('application', 'application/x-tar'),
	'tgz'		=> array('application', 'application/x-compressed'),
	'torrent'	=> array('application', 'application/x-bittorrent'),
	'xls'		=> array('application', 'application/excel'),
	'zip'		=> array('application', 'application/x-zip-compressed'),
	'7z'		=> array('application', 'application/x-7z-compressed'),

	'odc'		=> array('application', 'application/vnd.oasis.opendocument.chart'),
	#'otc'		=> array('application', 'application/vnd.oasis.opendocument.chart-template'),
	'odb'		=> array('application', 'application/vnd.oasis.opendocument.database'),
	'odf'		=> array('application', 'application/vnd.oasis.opendocument.formula'),
	#'odft'		=> array('application', 'application/vnd.oasis.opendocument.formula-template'),
	'odg'		=> array('application', 'application/vnd.oasis.opendocument.graphics'),
	#'otg'		=> array('application', 'application/vnd.oasis.opendocument.graphics-template'),
	'odi'		=> array('application', 'application/vnd.oasis.opendocument.image'),
	#'oti'		=> array('application', 'application/vnd.oasis.opendocument.image-template'),
	'odp'		=> array('application', 'application/vnd.oasis.opendocument.presentation'),
	#'otp'		=> array('application', 'application/vnd.oasis.opendocument.presentation-template'),
	'ods'		=> array('application', 'application/vnd.oasis.opendocument.spreadsheet'),
	#'ots'		=> array('application', 'application/vnd.oasis.opendocument.spreadsheet-template'),
	'odt'		=> array('application', 'application/vnd.oasis.opendocument.text'),
	#'odm'		=> array('application', 'application/vnd.oasis.opendocument.text-master'),
	#'ott'		=> array('application', 'application/vnd.oasis.opendocument.text-template'),
	#'oth'		=> array('application', 'application/vnd.oasis.opendocument.text-web'),

	// (legacy)
	'pptx'		=> array('application', 'application/vnd.openxmlformats-officedocument.presentationml.presentation'),
	#'sldx'		=> array('application', 'application/vnd.openxmlformats-officedocument.presentationml.slide'),
	#'ppsx'		=> array('application', 'application/vnd.openxmlformats-officedocument.presentationml.slideshow'),
	#'potx'		=> array('application', 'application/vnd.openxmlformats-officedocument.presentationml.template'),
	'xlsx'		=> array('application', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
	#'xltx'		=> array('application', 'application/vnd.openxmlformats-officedocument.spreadsheetml.template'),
	'docx'		=> array('application', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'),
	#'dotx'		=> array('application', 'application/vnd.openxmlformats-officedocument.wordprocessingml.template'),

	'mp3'		=> array('audio', 'audio/x-mpeg-3'),
	'ogg'		=> array('audio', 'audio/ogg'),
	'opus'		=> array('audio', 'audio/ogg'),

	// image
	'gif'		=> array('image', 'image/gif'),
	'ico'		=> array('image', 'image/x-icon'),
	'jpe'		=> array('image', 'image/jpeg'),
	'jpeg'		=> array('image', 'image/jpeg'),
	'jpg'		=> array('image', 'image/jpeg'),
	'png'		=> array('image', 'image/png'),
	'svg'		=> array('image', 'image/svg+xml'),

	// text
	'conf'		=> array('text', 'text/plain'),
	'css'		=> array('text', 'text/css'),
	'htm'		=> array('text', 'text/html'),
	'html'		=> array('text', 'text/html'),
	'rtf'		=> array('text', 'text/richtext'),
	#'sh'		=> array('text', 'text/x-script.sh'),
	'txt'		=> array('text', 'text/plain'),
	'xml'		=> array('text', 'text/xml'),

	// video
	'mp4'		=> array('video', 'video/mp4'),
	'ogv'		=> array('video', 'video/ogg'),
	'webm'		=> array('video', 'video/webm'),
);

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
		// 2. check access rights
		if ($this->is_admin() || (isset($file['upload_id']) && ($this->page['owner_id'] == $this->get_user_id()))
		|| ($this->has_access('read')) || ($file['user_id'] == $this->get_user_id()) )
		{
			$file_path = $this->config['upload_path'.($page_id ? '_per_page' : '')].'/'.
				($page_id
					? '@'.$this->page['page_id'].'@'
					: '').
				$file['file_name'];
		}
		else
		{
			// no access rights
			$error = 403;
		}
	}

	// 3. passthru
	$extension = strtolower($file['file_ext']);

	if (in_array($extension, array_keys($extension_map)))
	{
		header('Content-Type: '.$extension_map[$extension][1]);

		if ($extension_map[$extension][0] == 'application')
		{
			header('Cache-control: private');
		}
		else if ($extension_map[$extension][0] == 'image'
			||	 $extension_map[$extension][0] == 'text'
			||	 $extension_map[$extension][0] == 'video'
			||	 $extension_map[$extension][0] == 'audio')
		{
			$display_inline = true;
		}
	}
	else
	{
		header('Cache-control: private');
		header('Content-Type: application/download');
	}
}
else
{
	// file is not in upload table
	$error = 404;

	if (!headers_sent())
	{
		header('HTTP/1.0 404 Not Found');
	}
}

// file not available in file system
if (!is_file($file_path))
{
		$error = 404;
		#return false;
}
else if (!is_readable($file_path))
{
	$error = 403;
	#return false;
}

#########################################################
if ($error)
{
	$display_inline	= true;
	$extension		= 'png';
	header('Content-Type: image/'.$extension);
	$file_path		= 'image/upload'.$error.'.png';

	if (!headers_sent())
	{
		header('HTTP/1.0 404 Not Found'); // 403
	}
}
#########################################################

if ($file_path)
{
	// https://www.iana.org/assignments/cont-disp/cont-disp.xhtml
	header('Content-Disposition:'.($display_inline ? ' inline;' : ' attachment;').' filename="'.$file['file_name'].'"');

	if ($extension_map[$extension][0] != 'image')
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