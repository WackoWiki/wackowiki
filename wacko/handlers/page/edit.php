<?php

// invoke autocomplete if needed
if ($_GET["_autocomplete"])
{
	include( dirname(__FILE__)."/_autocomplete.php" );
	return;
}

?>
<div id="pageedit">
<?php

if ($this->HasAccess("write") && $this->HasAccess("read"))
{

if ($_POST)
{

	// only if saving:
	if ($_POST["save"] && $_POST["body"] != "")
	{
		if(isset($_POST["edit_note"]))
        {
            $edit_note = trim($_POST["edit_note"]);
        }

		if(isset($_POST["minor_edit"]))
        {
            $minor_edit = $_POST["minor_edit"];
        }
        
		// check for overwriting
		if ($this->page && $this->page["time"] != $_POST["previous"])
			$error = $this->GetTranslation("OverwriteAlert");

		// check for edit note
		if (($this->GetConfigValue("edit_summary") == 2) && $_POST["edit_note"] == "")
		{
			$error .= $this->GetTranslation("EditNoteMissing");
		}
		
		if(($this->page && $this->GetConfigValue("captcha_edit_page")) || (!$this->page && $this->GetConfigValue("captcha_new_page")))
		{
			// Don't load the captcha at all if the GD extension isn't enabled
			if(extension_loaded('gd'))
			{
				//check whether anonymous user
				//anonymous user has the IP or host name as name
				//if name contains '.', we assume it's anonymous
				if(strpos($this->GetUserName(), '.'))
				{
					//anonymous user, check the captcha
					if(!empty($_SESSION['freecap_word_hash']) && !empty($_POST['word']))
					{
						if($_SESSION['hash_func'](strtolower($_POST['word'])) == $_SESSION['freecap_word_hash'])
						{
							// reset freecap session vars
							// cannot stress enough how important it is to do this
							// defeats re-use of known image with spoofed session id
							$_SESSION['freecap_attempts'] = 0;
							$_SESSION['freecap_word_hash'] = false;

							// now process form
							$word_ok = true;
						}
						else
						{
							$word_ok = false;
						}
					}
					else
					{
						$word_ok = false;
					}

					if(!$word_ok)
					{
						//not the right word
						$error = $this->GetTranslation("SpamAlert");
						$this->SetMessage($this->GetTranslation("SpamAlert"));
					}
				}
			}
		}

		// store
		if (!$error)
		{
			$body = str_replace("\r", "", $_POST["body"]);

			// add page (revisions)
			$body_r = $this->SavePage($this->tag, $body, $edit_note, $minor_edit);
			
			// log event
			if ($this->page == false)
			{
				// new page created
				$this->Log(4, str_replace("%1", $this->tag." ".$_POST["title"], $this->GetTranslation("LogPageCreated")));
			}
			else
			{
				// old page modified
				$this->Log(6, str_replace("%1", $this->tag." ".$this->page["title"], $this->GetTranslation("LogPageEdited")));
			}

			// now we render it internally so we can write the updated link table.
			$this->ClearLinkTable();
			$this->StartLinkTracking();
			$dummy = $this->Format($body_r, "post_wacko");
			$this->StopLinkTracking();
			$this->WriteLinkTable();
			$this->ClearLinkTable();

			// forward
			$this->pageCache[$this->supertag] = "";
			$this->Redirect($this->href("", $this->tag).$this->AddDateTime($this->tag));
		}
	}
	
	// saving blank document
	else if ($_POST["body"] == "")
	{
		$this->Redirect($this->href("", $this->tag).$this->AddDateTime($this->tag));
	}
}

	$this->NoCache();

	// fetch fields
	if (!$previous = 	$_POST["previous"]) $previous 	= $this->page["time"];
	if (!$body = 		$_POST["body"]) 	$body 		= $this->page["body"];
	if (isset($_POST["edit_note"]))			$edit_note	= $_POST["edit_note"];
	if (isset($_POST["minor_edit"]))		$minor_edit	= $_POST["minor_edit"];

	{
	// display form
	if ($error)
	{
		$this->SetMessage("<div class=\"error\">$error</div>\n");
	}

	// append a comment?
   /*
	if ($_REQUEST["appendcomment"])
	{
		$body = trim($body)."\n\n----\n\n--".$this->GetUserName()." (".strftime("%c").")";
	}
   */
	// "cf" attribute: it is for so called "critical fields" in the form. It is used by some javascript code, which is launched onbeforeunload and shows a pop-up dialog "You are going to leave this page, but there are some changes you made but not saved yet." Is used by this script to determine which changes it need to monitor.
	$output .= $this->FormOpen("edit", "", "post", "edit", " cf='true' ");

	if ($_REQUEST["add"])
		$output .=	'<input name="lang" type="hidden" value="'.$this->pagelang.'" />'.
					'<input name="tag" type="hidden" value="'.$this->tag.'" />'.
					'<input name="add" type="hidden" value="1" />';

	print($output);

	$output = "";
	$preview = "";

	// preview?
	if ($_POST["preview"])
	{
?>
		<input name="save" class="OkBtn"
			onmouseover='this.className="OkBtn_";'
			onmouseout='this.className="OkBtn";' type="submit" align="top"
			value="<?php echo $this->GetTranslation("EditStoreButton"); ?>" />
		&nbsp;
		<input name="preview"
			class="OkBtn" onmouseover='this.className="OkBtn_";'
			onmouseout='this.className="OkBtn";' type="submit" align="top"
			value="<?php echo $this->GetTranslation("EditPreviewButton"); ?>" />
		&nbsp;
		<input class="CancelBtn"
			onmouseover='this.className="CancelBtn_";'
			onmouseout='this.className="CancelBtn";' type="button" align="top"
			value="<?php echo $this->GetTranslation("EditCancelButton"); ?>"
			onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
<?php
		$preview = $this->Format($body, "preformat");
		$preview = $this->Format($preview, "wacko");
		$preview = $this->Format($preview, "post_wacko");

		$output = "<div class=\"preview\"><p class=\"preview\"><span>".$this->GetTranslation("EditPreview")."</span></p>\n";
		$output .= $preview;
		$output .= "</div><br />\n";

		print($output);

		// edit
		$output = "";
}
?>
		<input name="save" class="OkBtn_Top"
			onmouseover='this.className="OkBtn_Top_";'
			onmouseout='this.className="OkBtn_Top";' type="submit" align="top"
			value="<?php echo $this->GetTranslation("EditStoreButton"); ?>" />
		&nbsp;
		<input name="preview"
			class="OkBtn_Top" onmouseover='this.className="OkBtn_Top_";'
			onmouseout='this.className="OkBtn_Top";' type="submit" align="top"
			value="<?php echo $this->GetTranslation("EditPreviewButton"); ?>" />
		&nbsp;
		<input
			class="CancelBtn_Top" onmouseover='this.className="CancelBtn_Top_";'
			onmouseout='this.className="CancelBtn_Top";' type="button"
			align="top"
			value="<?php echo str_replace("\n"," ",$this->GetTranslation("EditCancelButton")); ?>"
			onclick="document.location='<?php echo addslashes($this->href("", "", "", 1))?>';" />
		<br />
		<noscript><div class="errorbox_js"><?php echo $this->GetTranslation("WikiEditInactiveJs"); ?></div></noscript>
<?php
		$output .= "<input type=\"hidden\" name=\"previous\" value=\"".htmlspecialchars($previous)."\" /><br />";
		$output .= "<textarea id=\"postText\" name=\"body\" rows=\"40\" cols=\"60\" class=\"TextArea\">";
		$output .= htmlspecialchars($body)."</textarea><br />\n";
		
		// edit note
		if ($this->GetConfigValue("edit_summary") != 0)
		{
			$output .= "<label for=\"edit_note\">".$this->GetTranslation("EditNote").":</label>";
			$output .= "<input id=\"edit_note\" maxlength=\"200\" value=\"".htmlspecialchars($edit_note)."\" size=\"60\" name=\"edit_note\"/>";
			$output .= "<br />";
		}

		// minor edit
		if ($this->GetConfigValue("minor_edit") != 0)
		{
			$output .= "<input id=\"minor_edit\" type=\"checkbox\" value=\"1\" name=\"minor_edit\"/>";
			$output .= "<label for=\"minor_edit\">".$this->GetTranslation("EditMinor")."</label>";
			$output .= "<br />";
		}
		print($output);

		// captcha code starts

		// Only show captcha if the admin enabled it in the config file
		if(($this->page && $this->GetConfigValue("captcha_edit_page")) || (!$this->page && $this->GetConfigValue("captcha_new_page")))
		{
			// Don't load the captcha at all if the GD extension isn't enabled
			if(extension_loaded('gd'))
			{
				if(strpos($this->GetUserName(), '.'))
				{
?>
<p><?php echo $this->GetTranslation("Captcha");?>:</p>
<img src="<?php echo $this->GetConfigValue("base_url");?>lib/captcha/freecap.php" id="freecap" alt="<?php echo $this->GetTranslation("Captcha");?>" /> <a href="" onclick="this.blur(); new_freecap(); return false;" title="<?php echo $this->GetTranslation("CaptchaReload"); ?>"><img src="<?php echo $this->GetConfigValue("base_url");?>images/reload.png" width="18" height="17" alt="<?php echo $this->GetTranslation("CaptchaReload"); ?>" /></a>
<br />
<input type="text" name="word" maxlength="6" style="width: 273px;" />
<br />
<br />
<?php
				}
			}
		}
		// end captcha
?>
	<script type="text/javascript">
		wE = new WikiEdit();
<?php
		if ($user = $this->GetUser())
		if ($user["options"]["autocomplete"])
		{
		?>if (AutoComplete) { wEaC = new AutoComplete( wE, "<?php echo $this->href("edit");?>" ); }<?php
		}
?>
		wE.init('postText','WikiEdit','edname-w','<?php echo $this->GetConfigValue("base_url");?>images/wikiedit/');
	</script>
	<input name="save" class="OkBtn"
		onmouseover='this.className="OkBtn_";'
		onmouseout='this.className="OkBtn";' type="submit" align="top"
		value="<?php echo $this->GetTranslation("EditStoreButton"); ?>" />
	&nbsp;
	<input name="preview"
		class="OkBtn" onmouseover='this.className="OkBtn_";'
		onmouseout='this.className="OkBtn";' type="submit" align="top"
		value="<?php echo $this->GetTranslation("EditPreviewButton"); ?>" />
	&nbsp;
	<input class="CancelBtn"
		onmouseover='this.className="CancelBtn_";'
		onmouseout='this.className="CancelBtn";' type="button" align="top"
		value="<?php echo $this->GetTranslation("EditCancelButton"); ?>"
		onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
<?php
}
	print ($this->FormClose());
}
else
{
	echo "<div id=\"page\">";
	echo $this->GetTranslation("WriteAccessDenied");
	echo "</div>";
}

?>
</div>