<?php
/*
 {{import
 }}

 http://wackowiki.com/somecluster/import --> {{import}}, to = "Test".
 Will be imported at: http://wackowiki.com/Test/*

 i.e. no relative addressing
 */
//

if (!$_POST["_to"])
{
	// show FORM
	echo $this->FormOpen("", "", "post", "", " enctype='multipart/form-data' ");
	?>

<div class="cssform">
  <p>
    <label><?php echo $this->GetResourceValue("ImportTo"); ?>:</label>
    <input type="text" name="_to" size="40" value="" />
  </p>
  <p>
    <label><?php echo $this->GetResourceValue("ImportWhat"); ?>:</label>
    <input type="file" name="_import" />
  </p>
  <p>
    <input type="submit"
			value="<?php echo $this->GetResourceValue("ImportButtonText"); ?>" />
  </p>
</div>
<?php
	echo $this->FormClose();
}
else
{
	if ($_FILES["_import"]["error"]==0)
	{
		$fd = fopen($_FILES['_import']['tmp_name'], "r");
		if (!$fd)
		{
			echo "<pre>";
			print_r($_FILES);
			print_r($_POST);
			die("</pre><br>IMPORT failed");
		}
		$contents = fread ($fd, filesize ($_FILES['_import']['tmp_name']));
		fclose ($fd);

		require_once("classes/utility.php");

		$base_addr = Utility::untag($contents, "title");

		$items = explode("<item>", $contents);
		array_shift($items);

		foreach ($items as $item)
		{
			$rel_tag = Utility::untag($item, "guid");
			$body = str_replace("]]&gt;", "]]>", Utility::untag($item, "description"));

			$tag = trim($_POST["_to"]."/".$rel_tag, "/");

			$this->SavePage($tag, $body);

		}

		echo $this->GetResourceValue("ImportSuccess");
	}
	else
	{
		echo "<pre>";
		print_r($_FILES);
		print_r($_POST);
		die("</pre><br>IMPORT failed");
	}
}

?>
