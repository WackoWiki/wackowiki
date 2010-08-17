<?php
/*
	{{import}}
	http://wackowiki.org/somecluster/import --> {{import}}, to = "Test".
	Will be imported at: http://wackowiki.org/Test/*

	i.e. no relative addressing
*/

if (!isset($_POST["_to"]))
{
	// show FORM
	echo $this->FormOpen("", "", "post", "", " enctype='multipart/form-data' ");
	?>

<div class="cssform">
  <p>
    <label for="importto"><?php echo $this->GetTranslation("ImportTo"); ?>:</label>
    <input type="text" id="importto" name="_to" size="40" value="" />
  </p>
  <p>
    <label for="importwhat"><?php echo $this->GetTranslation("ImportWhat"); ?>:</label>
    <input type="file" id="importwhat" name="_import" />
  </p>
  <p>
    <input type="submit"
			value="<?php echo $this->GetTranslation("ImportButtonText"); ?>" />
  </p>
</div>
<?php
	echo $this->FormClose();
}
else
{
		if ($_FILES["_import"]["error"] == 0)
		{
			$fd = fopen($_FILES['_import']['tmp_name'], "r");

			if (!$fd)
			{
				echo "<pre>";
				print_r($_FILES);
				print_r($_POST);
				die("</pre><br />IMPORT failed");
			}

			$contents = fread($fd, filesize($_FILES['_import']['tmp_name']));
			fclose($fd);

			require_once("classes/utility.php");

			$base_addr = Utility::untag($contents, "title");

			$items = explode("<item>", $contents);

			array_shift($items);

			foreach ($items as $item)
			{
				$root_tag	= trim($_POST["_to"], "/ ");
				$rel_tag	= trim(Utility::untag($item, "guid"), "/ ");
				$tag		= $root_tag.( $root_tag && $rel_tag ? "/" : "" ).$rel_tag;
				$page_id	= $this->GetPageId($tag);
				$owner		= Utility::untag($item, "author");
				$owner_id	= $this->GetUserIdByName($user);
				$body = str_replace("]]&gt;", "]]>", Utility::untag($item, "description"));
				$title		= html_entity_decode(Utility::untag($item, "title"));

				$body_r = $this->SavePage($tag, $title, $body, '');
				$this->SetPageOwner($page_id, $owner_id);
				// now we render it internally in the context of imported
				// page so we can write the updated link table
				$this->context[++$this->current_context] = $tag;
				$this->ClearLinkTable();
				$this->StartLinkTracking();
				$dummy = $this->Format($body_r, 'post_wacko');
				$this->StopLinkTracking();
				$this->WriteLinkTable($page_id);
				$this->ClearLinkTable();
				$this->current_context--;

				// log import
				$this->Log(4, str_replace("%1", $tag, $this->GetTranslation("LogPageImported", $this->config['language'])));

				// count page
				$t++;
				$pages[] = $tag;
			}

			echo "<em>".str_replace('%1', $t, $this->GetTranslation("ImportSuccess"))."</em><br />";

			foreach ($pages as $page)
			{
				echo $this->Link('/'.$page, '', '', 0).'<br />';
			}
		}
		else
		{
			echo "<pre>";
			print_r($_FILES);
			print_r($_POST);
			die("</pre><br />IMPORT failed");
		}
}

?>
