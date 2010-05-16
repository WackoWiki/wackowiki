<?php

if (!isset($isimage)) $isimage = "";
if (!isset($isplain)) $isplain = "";
if (!isset($desc))$desc  = "";
$error = "";
$file404 = "images/upload404.gif";
$file403 = "images/upload403.gif";

// 1. check existence
if (isset($_GET["global"]))
{
	$page_id = 0;
}
else
{
	$page_id = $this->page["page_id"];
}
$what = $this->LoadAll(
	"SELECT u.user_name AS user, f.upload_id, f.filename, f.file_ext, f.filesize, f.description, f.hits ".
	"FROM ".$this->config["table_prefix"]."upload f ".
		"INNER JOIN ".$this->config["table_prefix"]."users u ON (f.user_id = u.user_id) ".
	"WHERE f.page_id = '".quote($this->dblink, $page_id)."'".
	"AND f.filename='".quote($this->dblink, $_GET["get"])."'");

if (sizeof($what) > 0)
{
	// 2. check rights
	if ($this->IsAdmin() || (isset($desc["upload_id"]) && ($this->page["owner_id"] == $this->GetUserId())) ||
	($this->HasAccess("read")) || ($desc["user_id"] == $this->GetUserId()) )
	{
		$filepath = $this->config["upload_path".($page_id ? "_per_page" : "")]."/".
		($page_id ? ("@".$this->page["page_id"]."@") : "").
		$what[0]["filename"];
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
$extension = strtolower($what[0]["file_ext"]);

if (($extension == "gif") || ($extension == "jpg") || ($extension == "jpeg") || ($extension == "png"))
{
	$isimage = true;
	header("Content-Type: image/".$extension);

	if ($error)
	{
		$filepath = "images/upload".$error.".gif";
		header("HTTP/1.0 404 Not Found");
	}
}
else if ($extension == "txt")
{
	$isplain = true;
	header("Content-Type: text/plain");
}
else if ($extension == "pdf")
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
	header("Content-Disposition:".( $isimage || $isplain ? "" : " attachment;" )." filename=".$what[0]["filename"]);

	if (!isset($isimage))
	{
		// count file download
		$this->Query(
			"UPDATE {$this->config['table_prefix']}upload ".
			"SET hits = '".quote($this->dblink, $what[0]['hits'] + 1)."' ".
			"WHERE upload_id = '".quote($this->dblink, $what[0]['upload_id'])."'");
	}

	$f = @fopen( $filepath, "rb" );
	@fpassthru ($f);
}
else if ($error == 404)
{
	// Not sure what the point of wrapping it in the conditional was
	// if (function_exists("virtual")) header("HTTP/1.0 404 Not Found");
	header("HTTP/1.0 404 Not Found");

	print($this->GetTranslation("UploadFileNotFound"));
}
else
{
	// Not sure what the point of wrapping it in the conditional was
	// if (function_exists("virtual")) header("HTTP/1.0 403 Forbidden");
	header("HTTP/1.0 403 Forbidden");

	print($this->GetTranslation("UploadFileForbidden"));
}

// 4. die
die();

?>