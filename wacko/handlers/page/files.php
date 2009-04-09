<?php

$file404 = "images/upload404.gif";
$file403 = "images/upload403.gif";

// 1. check existence
if ($_GET["global"]) {
	$page_id = 0;
}
else
{
	$page_id = $this->page["id"];
}
$what = $this->LoadAll(
	"SELECT user, id, filename, file_ext, filesize, description ".
	"FROM ".$this->config["table_prefix"]."upload ".
	"WHERE page_id = '".quote($this->dblink, $page_id)."'".
    "AND filename='".quote($this->dblink, $_GET["get"])."'");

if (sizeof($what) > 0)
{
	// 2. check rights
	if ($this->IsAdmin() || ($desc["id"] && ($this->GetPageOwner($this->tag) == $this->GetUserName())) ||
	($this->HasAccess("read")) || ($desc["user"] == $this->GetUserName()) )
	{
		$filepath = $this->config["upload_path".($page_id?"_per_page" : "")]."/".
		($page_id ? ("@".str_replace("/", "@", $this->supertag)."@") : "").
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

	if (!$isimage)
	{
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