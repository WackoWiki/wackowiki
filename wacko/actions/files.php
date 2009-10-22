<?php
/*
	Showing uploaded by {{upload}} files

	{{files
		[page="PageName" or global=1]
		[order="time|FILENAME|size|size_desc|ext"]
		[owner="UserName"]
		[pictures=1]
	}}
 */

if (!isset($nomark)) $nomark = "";
if (!isset($order)) $order = "";
if (!isset($global)) $global = "";
if (!isset($tag)) $tag = "";
if (!isset($owner)) $owner = "";
if (!isset($page)) $page = "";
if (!isset($pictures)) $pictures = "";

$orderby = "filename ASC";

if ($order == "time") $orderby = "uploaded_dt DESC";
if ($order == "size") $orderby = "filesize ASC";
if ($order == "size_desc") $orderby = "filesize DESC";
if ($order == "ext") $orderby = "file_ext ASC";

if ($owner) $user_add = "AND ".$this->config["table_prefix"]."users.name='".quote($this->dblink, $owner)."' ";
else		$user_add = "";

// do we allowed to see?
if (!$global)
{
	if ($page == "")	$page = $this->tag;
	else				$page = $this->UnwrapLink($page);

	$can_view   = $this->HasAccess("read", $page) || $this->IsAdmin() || $this->UserIsOwner($page);
	$can_delete = $this->IsAdmin() || $this->UserIsOwner($page);
}
else
{
	$can_view = 1;
	$page = $this->tag;
}

if ($can_view)
{
	if ($global || ($tag == $page)) $filepage = $this->page;
	else $filepage = $this->LoadPage($page);

	if (!$global && !$filepage["id"]) return;

	// load files list
	$files = $this->LoadAll(
		"SELECT ".$this->config["table_prefix"]."upload.id, ".$this->config["table_prefix"]."upload.page_id, ".$this->config["table_prefix"]."upload.user_id, ".$this->config["table_prefix"]."upload.filesize, ".$this->config["table_prefix"]."upload.picture_w, ".$this->config["table_prefix"]."upload.picture_h, ".$this->config["table_prefix"]."upload.filename, ".$this->config["table_prefix"]."upload.description, ".$this->config["table_prefix"]."upload.uploaded_dt, ".$this->config["table_prefix"]."users.name AS user ".
		"FROM ".$this->config["table_prefix"]."upload ".
			"INNER JOIN ".$this->config["table_prefix"]."users ON (".$this->config["table_prefix"]."upload.user_id = ".$this->config["table_prefix"]."users.id)".
		"WHERE page_id = '". ($global ? 0 : $filepage["id"])."' ".$user_add.
		" ORDER BY ".$this->config["table_prefix"]."upload.".$orderby );

	if (!is_array($files)) $files = array();

	if (!isset($nomark))
	{
		$title = $this->GetTranslation("UploadTitle".($global ? "Global" : ""));
		print("<div class=\"layout-box\"><p class=\"layout-box\"><span>".$title.": ".$showpageandpath."</span></p>\n");
	}

	// display
	$kb  = $this->GetTranslation("UploadKB");
	$del = $this->GetTranslation("UploadRemove");

	if (!$global)	$path = "@".str_replace("/", "@", $this->NpjTranslit($page))."@";
	else			$path = "";

	if (!$global) 	$path2 = "file:/".($this->SlimUrl($page))."/";
	else			$path2 = "file:";

	// !!!!! patch link not to show pictures when not needed
	if (!isset($pictures)) $path2 = str_replace("file:", "_file:", $path2);

	if (count($files))
	{
?>
		<table class="upload" cellspacing="0" cellpadding="0" border="0">
<?php
	}

	foreach($files as $file)
	{
		$this->filesCache[$file["page_id"]][$file["filename"]] = &$file;

		$dt = $file["uploaded_dt"];
		$desc = $this->Format($file["description"], "typografica" );

		if ($desc == "") $desc = "&nbsp;";

		$filename = $file["filename"];
		$filesize = ceil($file["filesize"] / 1024);
		$link = $this->Link($path2.$filename, "", $filename);

		if ($this->IsAdmin() || (!isset($is_global) &&
		($this->GetPageOwnerId($page) == $this->GetUserId())) ||
		($file["user_id"] == $this->GetUserId()))
		{
			$remove_mode = 1;
		}
		else
		{
			$remove_mode = 0;
		}

		$remove_href = $this->Href("upload", $page, "remove=".($global ? "global" : "local")."&amp;file=".$filename);
?>
		<tr>
			<td class="dt-"><span class="dt2-"><?php echo $dt ?></span>&nbsp;</td>
<?php
		if ($remove_mode)
		{
?>
			<td class="remove-"><a href="<?php echo $remove_href; ?>" class="remove2-"><?php echo $del; ?></a>&nbsp;</td>
<?php
		}
		else
		{
?>
			<td class="remove-">&nbsp;</td>
<?php
		}
?>
		<td class="size-"><span class="size2-">(<?php echo $filesize; ?>&nbsp;<?php	echo $kb; ?>)</span>&nbsp;</td>
		<td class="file-"><?php echo $link; ?></td>
		<td class="desc-"><?php echo $desc ?></td>
	</tr>
<?php
	}

	if (count($files))
	{
?>
		</table>
<?php
	}

	if (!isset($nomark)) echo "</div>\n";
}
else
{
	echo "<em>".$this->GetTranslation("ActionDenied")."</em> ";
}

?>