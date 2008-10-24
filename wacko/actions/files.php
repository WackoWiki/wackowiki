<?php
/*
 Showing uploaded by {{upload}} files

 {{files
 [param0="PageName" or global=1]
 [order="time|FILENAME|size|size_desc|ext"]
 [owner="UserName"]
 [pictures=1]
 }}
 */
$orderby = "filename ASC";
if ($order == "time") $orderby = "uploaded_dt DESC";
if ($order == "size") $orderby = "filesize ASC";
if ($order == "size_desc") $orderby = "filesize DESC";
if ($order == "ext") $orderby = "file_ext ASC";

if ($owner) $user_add = "and user='".quote($this->dblink, $owner)."' ";
else        $user_add = "";

// do we allowed to see?
if (!$global)
{
	if ($vars[0] == "") $vars[0] = $this->tag;
	else
	{
		$showpagename = $vars[0];
		$vars[0] = $this->UnwrapLink($vars[0]);
		$page_href = $this->Href("", $vars[0]);
		$showpageandpath = '<a href="'.$page_href.'">'.$showpagename.'</a>';
	}
	$can_view   = $this->HasAccess("read",$vars[0]) || $this->IsAdmin() || $this->UserIsOwner($vars[0]);
	$can_delete = $this->IsAdmin() || $this->UserIsOwner($vars[0]);
} else
{
	$can_view = 1;
	$vars[0] = $this->tag;
}

if ($can_view)
{

	if ($global || ($tag == $vars[0])) $filepage = $this->page;
	else $filepage = $this->LoadPage($vars[0]);
	if (!$global && !$filepage["id"]) return;

	// load files list
	$files = $this->LoadAll( "SELECT id, page_id, filesize, picture_w, picture_h, filename, description, uploaded_dt, user FROM ".
	$this->config["table_prefix"]."upload WHERE ".
                             " page_id = '". ($global?0:$filepage["id"])."' ".$user_add.
                             " ORDER BY ".$orderby );
	if (!is_array($files)) $files = array();

	if (!$nomark){
		$title = $this->GetResourceValue("UploadTitle".($global?"Global":""));
		print("<fieldset><legend>".$title.": ".$showpageandpath."</legend>\n");
	}
	// display
	$kb  = $this->GetResourceValue("UploadKB");
	$del = $this->GetResourceValue("UploadRemove");
	if (!$global) $path = "@".str_replace("/", "@", $this->NpjTranslit($vars[0]))."@";
	else          $path = "";

	if (!$global) $path2 = "file:/".($this->SlimUrl($vars[0]))."/";
	else          $path2 = "file:";

	// !!!!! patch link not to show pictures when not needed
	if (!$pictures) $path2 = str_replace("file:", "_file:", $path2);

	if (count($files))
	{
		?>
<table class="upload" cellspacing="0" cellpadding="0" border="0">
<?php
}

foreach( $files as $file )
{
	$this->filesCache[$file["page_id"]][$file["filename"]] = &$file;

	$dt = $file["uploaded_dt"];
	$desc = $this->Format( $file["description"], "typografica" );
	if ($desc == "") $desc = "&nbsp;";
	$filename = $file["filename"];
	$filesize = ceil($file["filesize"]/1024);
	$link = $this->Link($path2.$filename, "", $filename );

	if ($this->IsAdmin() || (!$is_global && ($this->GetPageOwner($vars[0]) == $this->GetUserName()))
	|| ($file["user"]                                 == $this->GetUserName()))
	$remove_mode=1;
	else $remove_mode=0;

	$remove_href = $this->Href("upload", $vars[0], "remove=".($global?"global":"local")."&amp;file=".$filename);
	?>
	<tr>
		<td class="dt-" nowrap="nowrap"><span class="dt2-"><?php echo $dt ?></span>&nbsp;</td>
		<?php
		if ($remove_mode)
		{
			?>
		<td class="remove-"><a href="<?php echo $remove_href; ?>"
			class="remove2-"><?php echo $del; ?></a>&nbsp;</td>
			<?php
} else {
	?>
		<td class="remove-">&nbsp;</td>
		<?php
}
?>
		<td class="size-"><span class="size2-">(<?php echo $filesize; ?>&nbsp;<?php
		echo $kb; ?>)</span>&nbsp;</td>
		<td class="file-" nowrap="nowrap"><?php echo $link; ?></td>
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
if (!$nomark) echo "</fieldset>\n";
}
else
echo "<em>".$this->GetResourceValue("ActionDenied")."</em> ";

?>