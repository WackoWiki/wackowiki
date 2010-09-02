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

$page_id = "";

if (!isset($nomark)) $nomark = "";
if (!isset($order)) $order = "";
if (!isset($global)) $global = "";
if (!isset($tag)) $tag = "";
if (!isset($owner)) $owner = "";
if (!isset($page)) $page = "";
if (!isset($pictures)) $pictures = NULL;

$orderby = "filename ASC";
if ($order == "time") $orderby = "uploaded_dt DESC";
if ($order == "size") $orderby = "filesize ASC";
if ($order == "size_desc") $orderby = "filesize DESC";
if ($order == "ext") $orderby = "file_ext ASC";

if ($owner) $user_add = "AND u.user_name='".quote($this->dblink, $owner)."' ";
else		$user_add = "";

// do we allowed to see?
if (!$global)
{
	if ($page == "")
	{
		$page = $this->tag;
		$page_id = $this->page['page_id'];
	}
	else
	{
		$page = $this->unwrap_link($page);
		if ($_page_id = $this->get_page_id($page))
			$page_id = $_page_id;
	}

	$can_view   = $this->has_access("read", $page_id) || $this->is_admin() || $this->user_is_owner($page_id);
	$can_delete = $this->is_admin() || $this->user_is_owner($page_id);
}
else
{
	$can_view = 1;
	$page = $this->tag;
}

if ($can_view)
{
	if ($global || ($tag == $page)) $filepage = $this->page;
	else $filepage = $this->load_page($page);

	if (!$global && !$filepage['page_id']) return;

	// load files list
	$files = $this->load_all(
		"SELECT f.upload_id, f.page_id, f.user_id, f.filesize, f.picture_w, f.picture_h, f.filename, f.description, f.uploaded_dt, u.user_name AS user, f.hits ".
		"FROM ".$this->config['table_prefix']."upload f ".
			"INNER JOIN ".$this->config['table_prefix']."user u ON (f.user_id = u.user_id) ".
		"WHERE f.page_id = '". ($global ? 0 : $filepage['page_id'])."' ".$user_add.
		" ORDER BY f.".$orderby );

	if (!is_array($files)) $files = array();

	if (!$nomark)
	{
		$title = $this->get_translation("UploadTitle".($global ? "Global" : ""));
		print("<div class=\"layout-box\"><p class=\"layout-box\"><span>".$title.": </span></p>\n");
	}

	// display
	$del = $this->get_translation("UploadRemove");

	if (!$global)	$path = "@".$filepage['page_id']."@";
	else			$path = "";

	if (!$global) 	$path2 = "file:/".($this->slim_url($page))."/";
	else			$path2 = "file:";

	// !!!!! patch link not to show pictures when not needed
	if ($pictures == false) $path2 = str_replace("file:", "_file:", $path2);

	if (count($files))
	{
?>
		<table class="upload" cellspacing="0" cellpadding="0" border="0">
<?php
	}

	foreach($files as $file)
	{
		$this->filesCache[$file['page_id']][$file["filename"]] = &$file;

		$dt = $file["uploaded_dt"];
		$desc = $this->format($file['description'], "typografica" );

		if ($desc == "") $desc = "&nbsp;";

		$filename	= $file["filename"];
		$text		= ($pictures == false) ? $filename : '';
		$filesize	= $this->binary_multiples($file['filesize'], true, true, true);
		$fileext	= substr($filename, strrpos($filename, ".") + 1);
		$link		= $this->link($path2.$filename, "", $text);

		if ($fileext != "gif" && $fileext != "jpg" && $fileext != "png")
		{
			$hits	= ", ".$file["hits"]." ".( $file["hits"] === 1 ? "hit" : "hits" );
		}
		else
		{
			$hits	= "";
		}

		if ($this->is_admin() || (!isset($is_global) &&
		($this->get_page_owner_id($page_id) == $this->get_user_id())) ||
		($file['user_id'] == $this->get_user_id()))
		{
			$remove_mode = 1;
		}
		else
		{
			$remove_mode = 0;
		}

		$remove_href = $this->href("upload", $page, "remove=".($global ? "global" : "local")."&amp;file=".$filename);
?>
		<tr>
			<td class="dt-"><span class="dt2-"><?php echo $this->get_time_string_formatted($dt) ?></span>&nbsp;</td>
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
		<td class="size-"><span class="size2-">(<?php echo $filesize; ?>)</span>&nbsp;</td>
		<td class="file-"><?php echo $link; ?></td>
		<td class="desc-"><?php echo $desc; ?></td>
	</tr>
<?php
		unset($link);
		unset($desc);
	}

	if (count($files))
	{
?>
		</table>
<?php
	}

	if (!$nomark) echo "</div>\n";
}
else
{
	echo "<em>".$this->get_translation("ActionDenied")."</em> ";
}

?>