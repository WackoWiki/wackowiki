<div class="pageBefore">&nbsp;</div>
<div class="page">
<?php
// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href('show'));
  
if ($user = $this->GetUser())
{
	$user = strtolower($this->GetUserName());
	$registered = true;
}
else
$user = "guest@wacko";

if ($registered
&&
(
($this->config["upload"] === true) || ($this->config["upload"] == "1") ||
($this->CheckACL($user,$this->config["upload"]))
)
&&
($this->HasAccess("write") && $this->HasAccess("read") || ($_POST["to"]=="global"))
)
{
	if (!$this->page)
	{
		print(str_replace("%1",$this->href("edit"),$this->GetResourceValue("DoesNotExists")));
	}
	else
	if ($_GET["remove"]) // show the form
	{
		if ($_GET["remove"] == "global") $page_id=0;
		else                             $page_id=$this->page["id"];
		$what = $this->LoadAll( "SELECT user, id, filename, filesize, description FROM ".$this->config["table_prefix"]."upload WHERE ".
                            "page_id = '".quote($this->dblink, $page_id)."' AND filename='".quote($this->dblink, $_GET["file"])."'");
		if (sizeof($what) > 0)
		{
			if ($this->IsAdmin() || ($page_id && ($this->GetPageOwner($this->tag) == $this->GetUserName()))
			|| ($what[0]["user"] == $this->GetUserName()))
			{
				echo "<strong>".$this->GetResourceValue("UploadRemoveConfirm")."</strong>";
				echo $this->FormOpen("upload");
				// !!!!! place here a reference to delete files
				?>
  <br />
  <ul>
    <li><?php echo $this->Link( "file:".$_GET["file"] ); ?></li>
	<?php // place here file description too ?>
  </ul>
  <br />
  <input type="hidden" name="remove" value="<?php echo $_GET["remove"]?>" />
  <input type="hidden" name="file" value="<?php echo $_GET["file"]?>" />
  <input
	name="submit" class="OkBtn_Top"
	onmouseover='this.className="OkBtn_Top_";'
	onmouseout='this.className="OkBtn_Top";' type="submit" align="top"
	value="<?php echo $this->GetResourceValue("RemoveButton"); ?>" />
  &nbsp;
  <input
	class="CancelBtn_Top" onmouseover='this.className="CancelBtn_Top_";'
	onmouseout='this.className="CancelBtn_Top";' type="button" align="top"
	value="<?php echo str_replace("\n"," ",$this->GetResourceValue("EditCancelButton")); ?>"
	onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
  <br />
  <br />
  <?php   echo $this->FormClose();
} else
print($this->GetResourceValue("UploadRemoveDenied"));
} else
print($this->GetResourceValue("UploadFileNotFound"));
echo "</div>";
return true;
}
else
if ($_POST["remove"]) // delete
{
	// 1. where, existence
	if ($_POST["remove"] == "global") $page_id=0;
	else                              $page_id=$this->page["id"];
	$what = $this->LoadAll( "SELECT user, id, filename, filesize, description FROM ".$this->config["table_prefix"]."upload WHERE ".
                            "page_id = '".quote($this->dblink, $page_id)."' AND filename='".quote($this->dblink, $_POST["file"])."'");
	if (sizeof($what) > 0)
	{
		if ($this->IsAdmin() || ($page_id && ($this->GetPageOwner($this->tag) == $this->GetUserName()))
		|| ($what[0]["user"]                             == $this->GetUserName()))
		{
			// 2. remove from DB
			$this->Query( "DELETE FROM ".$this->config["table_prefix"]."upload WHERE ".
                     "id = '". quote($this->dblink, $what[0]["id"])."'" );
			print("<div>".$this->GetResourceValue("UploadRemovedFromDB")."</div>");
			// 3. remove from FS
			$real_filename = ($page_id
			?($this->config["upload_path_per_page"]."/@".str_replace("/","@",$this->supertag)."@")
			:($this->config["upload_path"]."/")
			).$what[0]["filename"];
			if (@unlink($real_filename))
			print("<div>".$this->GetResourceValue("UploadRemovedFromFS")."</div><br /><br /> ");
			else
			print("<div class=\"error\">".$this->GetResourceValue("UploadRemovedFromFSError")."</div><br /><br /> ");
		} else
		print($this->GetResourceValue("UploadRemoveDenied"));
	} else
	print($this->GetResourceValue("UploadRemoveNotFound"));
}
else
{
	$user = $this->GetUser();
	$files = $this->LoadAll( "SELECT id FROM ".$this->config["table_prefix"]."upload WHERE ".
                             " user = '".quote($this->dblink, $user["name"])."'");

	if (!$this->config["upload_max_per_user"] || (sizeof($files) < $this->config["upload_max_per_user"]))
	{
		if (is_uploaded_file($_FILES[ "file" ]["tmp_name"])) // there is file
		{
			// 1. check out $data
			$_data = explode(".", $_FILES[ "file" ]["name"] );
			$ext  = $_data[ sizeof($_data)-1 ];
			unset( $_data[ sizeof($_data)-1 ] );
			$name = implode( ".", $_data );
			$name = str_replace("@", "_", $name);

			// here would be place for translit
			$name = $this->Format($name, "translit");

			// 1.5. +write @PageSupertag@SubPage@ to name
			if ($_POST["to"] != "global")
			$name = "@".str_replace("/", "@", $this->page["supertag"])."@".$name;
			else $is_global=1;

			if ($is_global)
			{
				$dir = $this->config["upload_path"]."/";
				$banned = explode("|", $this->config["upload_banned_exts"]);
				if (in_array(strtolower($ext), $banned))
				$ext = $ext.".txt";
			}
			else
			$dir = $this->config["upload_path_per_page"]."/";

			$_name = $name;
			$count = 1;
			while (file_exists($dir.$name.".".$ext))
			{
				if ($name === $_name) $name = $_name.$count;
				else $name = $_name.(++$count);
			}

			$result_name = $name.".".$ext;
			$file_size = $_FILES["file"]['size'];

			// 1.6. check filesize, if asked
			$maxfilesize = $this->config["upload_max_size"];
			if ($_POST["maxsize"])
			if ($maxfilesize > 1*$_POST["maxsize"]) $maxfilesize = 1*$_POST["maxsize"];
			if ($file_size < $maxfilesize*1024)
			{

				// 1.7. check is image, if asked
				$forbid=0;
				$size = array(0,0);
				$src = $_FILES[ "file" ]["tmp_name"];
				$size = @getimagesize( $src );

				if ($this->config["upload_images_only"])
				{
					if ($size[0] == 0) $forbid=1;
				}
				if (!$forbid)
				{
					// 3. save to permanent location
					move_uploaded_file($_FILES["file"]['tmp_name'],
					$dir.$result_name);
					chmod( $dir.$result_name, 0644 );

					if ($is_global) $small_name = $result_name;
					else {
						$small_name = explode("@", $result_name);
						$small_name = $small_name[ sizeof($small_name) -1 ];
					}

					$description = substr(quote($this->dblink, $_POST["description"]),0,250);
					$description = rtrim( $description, "\\" );

					// Make HTML in the description redundant ;�)
					$description = $this->Format($description, "preformat");
					$description = $this->Format($description, "safehtml");
					$description = htmlentities($description,ENT_COMPAT,$this->GetCharset());

					// 5. insert line into DB
					$this->Query("insert into ".$this->config["table_prefix"]."upload set ".
                   "page_id = '".quote($this->dblink, $is_global?"0":$this->page["id"])."', ".
                   "filename = '".quote($this->dblink, $small_name)."', ".
                   "description = '".quote($this->dblink, $description)."', ".
                   "filesize = '".quote($this->dblink, $file_size)."',".
                   "picture_w = '".quote($this->dblink, $size[0])."',".
                   "picture_h = '".quote($this->dblink, $size[1])."',".
                   "file_ext = '".quote($this->dblink, substr($ext,0,10))."',".
                   "user = '".quote($this->dblink, $user["name"])."',".
                   "uploaded_dt= '".quote($this->dblink, date("Y-m-d H:i:s"))."' ");

					// 4. output link to file
					// !!!!! write after providing filelink syntax
					echo "<strong>".$this->GetResourceValue("UploadDone")."</strong>";
					?>
  <br />
  <ul>
    <li><?php echo $this->Link("file:".$small_name); ?></li>
    <li>&quot;<?php echo $description; ?>&quot;</li>
  </ul>
  <br />
  <?php

}
else //forbid
$error = $this->GetResourceValue("UploadNotAPicture");

}
else //maxsize
$error = $this->GetResourceValue("UploadMaxSizeReached");

} //!is_uploaded_file
else
{
	if ($_FILES["file"]['error']==UPLOAD_ERR_INI_SIZE || $_FILES["file"]['error']==UPLOAD_ERR_FORM_SIZE)
	$error = $this->GetResourceValue("UploadMaxSizeReached");
	else if ($_FILES["file"]['error']==UPLOAD_ERR_PARTIAL || $_FILES["file"]['error']==UPLOAD_ERR_NO_FILE)
	$error = $this->GetResourceValue("UploadNoFile");
	else
	$error = " ";
}

}
else
$error = $this->GetResourceValue("UploadMaxFileCount");
}
if ($error)
{
	echo "<div class=\"error\">".$error."</div><br /><br />";
}
echo $this->Action("upload", array())."<br />";
echo $this->Action("files", array());
//  if (!$error) echo "<br /><hr />".$this->Action("upload", array())."<hr /><br />";
}
else
{
	print($this->GetResourceValue("UploadForbidden"));
}
if (!$this->GetConfigValue("revisions_hide_cancel")) echo "<input type=\"button\" value=\"".$this->GetResourceValue("CancelDifferencesButton")."\" onclick=\"document.location='".addslashes($this->href(""))."';\" />\n";
?>
</div>
