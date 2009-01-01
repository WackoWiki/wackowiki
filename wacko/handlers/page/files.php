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
$what = $this->LoadAll("SELECT user, id, filename, filesize, description FROM ".$this->config["table_prefix"]."upload WHERE ".
                         "page_id = '".quote($this->dblink, $page_id)."' AND filename='".quote($this->dblink, $_GET["get"])."'");
if (sizeof($what) > 0) 
{
	// 2. check rights
	if ($this->IsAdmin() || ($desc["id"] && ($this->GetPageOwner($this->tag) == $this->GetUserName())) ||
	($this->HasAccess("read")) || ($desc["user"] == $this->GetUserName()) )
	{
		$filepath = $this->config["upload_path".($page_id?"_per_page":"")]."/".
		($page_id?("@".str_replace("/","@",$this->supertag)."@"):"").
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
$ext_array = explode(".", $filepath?$filepath:$_GET["get"]);
$extension = strtolower($ext_array[count($ext_array)-1]);

if ($extension == "gif") {
	$isimage = true;
	header("Content-Type: image/gif");
}

if ($extension == "jpg") {
	$isimage = true;
	header("Content-Type: image/jpeg");
}

if ($extension == "png") {
	$isimage = true;
	header("Content-Type: image/png");
}

if ($isimage && $error) {
	$filepath = "images/upload".$error.".gif";
	header("HTTP/1.0 404 Not Found");
}

if ($filepath)
{
	if (!$isimage)
	{
		header("Cache-control: private");
		header("Content-Type: application/download");
		header("Content-Disposition: attachment; filename=".$what[0]["filename"]);
	}
	$f = @fopen( $filepath, "rb" );
	@fpassthru ($f);
}
else if ($error==404)
{
	if (function_exists("virtual")) header("HTTP/1.0 404 Not Found");
	print($this->GetResourceValue("UploadFileNotFound"));
}
else
{
	if (function_exists("virtual")) header("HTTP/1.0 403 Forbidden");
	print($this->GetResourceValue("UploadFileForbidden"));
}

// 4. die
die();

?>