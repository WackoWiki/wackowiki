<div id="page">
<h3><?php echo $this->GetTranslation("ClonePage") ?> <?php echo $this->ComposeLinkToPage($this->tag, "", "", 0) ?></h3>
<br />
<?php

$output = "";

// redirect to show method if page don't exists
if (!$this->page) $this->Redirect($this->href('show'));

// deny for comment
if ($this->page['comment_on_id'])
	$this->Redirect($this->href('', $this->GetCommentOnTag($this->page["comment_on_id"]), 'show_comments=1').'#'.$this->page['tag']);
// and for forum page
else if ($this->forum === true && !$this->IsAdmin())
	$this->Redirect($this->href());

if ($user = $this->GetUser())
{
	$user = strtolower($this->GetUserName());
	$registered = true;
}
else
$user = GUEST;

$edit_note = str_replace("%1", $this->tag, $this->GetTranslation("ClonedFrom"));

if ($this->UserIsOwner() || $this->IsAdmin() || $this->HasAccess("write", $this->page["page_id"]))
{
	if (isset($_POST["newname"]) && $_POST["clone"] == "1")
	{
		// clone or massclone
		$need_massclone = 0;
		if (isset($_POST["massclone"]) && $_POST["massclone"] == "on") $need_massclone = 1;

		// clone
		if ($need_massclone == 0)
		{
			// strip whitespaces
			$new_name		= preg_replace('/\s+/', '', $_POST["newname"]);
			$new_name		= trim($new_name, "/");
			$supernewname	= $this->NpjTranslit($new_name);
			$edit_note = isset($_POST['edit_note']) ? $_POST['edit_note'] : $edit_note;

			if (!preg_match("/^([\_\.\-".$this->language["ALPHANUM_P"]."]+)$/", $new_name))
			{
				print($this->GetTranslation("BadName")."<br />\n");
			}
			//     if ($this->supertag == $supernewname)
			else if ($this->tag == $new_name)
			{
				print(str_replace("%1", $this->ComposeLinkToPage($new_name, "", "", 0), $this->GetTranslation("AlreadyNamed"))."<br />\n");
			}
			else
			{
				if ($this->supertag != $supernewname && $page=$this->LoadPage($supernewname, "", LOAD_CACHE, LOAD_META))
				{
					print(str_replace("%1", $this->ComposeLinkToPage($new_name, "", "", 0), $this->GetTranslation("AlredyExists"))."<br />\n");
				}
				else
				{
					if ($this->ClonePage($this->tag, $new_name, $supernewname, $edit_note))
					{
						// log event
						$this->Log(4, str_replace("%2", $new_name, str_replace("%1", $this->tag, $this->GetTranslation("LogClonedPage"))) );

						if (isset($_POST["redirect"]) && $_POST["redirect"] == "on") $need_redirect = 1;

						if ($need_redirect == 1)
						{
							$this->SetMessage($edit_note);
							$this->Redirect($this->Href('edit', $new_name));
						}
						else
						{
							print(str_replace("%1", $new_name, $this->GetTranslation("PageCloned"))."<br />\n");
						}
					}
				}
			}
		}
		//massclone
		if ($need_massclone == 1)
		{
			// ToDo: clone all sheeps and optional ACLs
			print "<p><b>".$this->GetTranslation("MassCloning")."</b><p>";   //!!!
			#RecursiveMove($this, $this->tag );
		}
	}
	else
	{

	echo $this->GetTranslation("CloneName");
	print($this->FormOpen("clone"));

	?>
	<input type="hidden" name="clone" value="1" />
	<input name="newname" size="40"/><br />
	<?php
	// edit note
	if ($this->config["edit_summary"] != 0)
	{
		$output .= "<label for=\"edit_note\">".$this->GetTranslation("EditNote").":</label><br />";
		$output .= "<input id=\"edit_note\" maxlength=\"200\" value=\"".htmlspecialchars($edit_note)."\" size=\"60\" name=\"edit_note\"/>";

		echo $output;
	}
	?>
	<br />
	<?php echo "<input type=\"checkbox\" id=\"redirect\" name=\"redirect\" ";  echo " /> <label for=\"redirect\">".$this->GetTranslation("ClonedRedirect")."</label>"; ?>
	<br /><br />
	<input name="submit" type="submit" value="<?php echo $this->GetTranslation("CloneButton"); ?>" /> &nbsp;
	<input type="button" value="<?php echo str_replace("\n"," ",$this->GetTranslation("EditCancelButton")); ?>"
	onclick="document.location='<?php echo addslashes($this->href(""))?>';" />

	<?php
	print ($this->FormClose());

	}
}
else
{
	#print("<div class=\"error\">Warning: The page handler \"clone\" is only for Wiki Admin</div>");
	print($this->GetTranslation("ReadAccessDenied"));
}

//$this->Redirect($this->href());

?>
</div>
