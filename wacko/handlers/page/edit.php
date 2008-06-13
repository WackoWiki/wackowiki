<?php

// invoke autocomplete if needed
if ($_GET["_autocomplete"])
{
	include( dirname(__FILE__)."/_autocomplete.php" );
	return;
}

?>
<?php if (!$this->GetConfigValue("edit_table_based")) { ?>

<div class="pageedit">
  <?php } ?>
  <?php
if ($this->HasAccess("write") && $this->HasAccess("read"))
{
	if ($this->GetConfigValue("edit_table_based")) {
		?>
</div>
<table cellspacing="0" cellpadding="0" border="0" width="100%">
  <tr>
    <td style='padding: 0px 20px' width="100%"><?php
}
if ($_POST)
{
	// only if saving:
	if ($_POST["save"])
	{
		// check for overwriting
		if ($this->page)
		if ($this->page["time"] != $_POST["previous"])
		$error = $this->GetResourceValue("OverwriteAlert");

		// store
		if (!$error)
		{
			$body = str_replace("\r", "", $_POST["body"]);

			// add page (revisions)
			$body_r = $this->SavePage($this->tag, $body);

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
}

$this->NoCache();

// fetch fields
if (!$previous = $_POST["previous"]) $previous = $this->page["time"];
if (!$body = $_POST["body"]) $body = $this->page["body"];

{
	// display form
	if ($error)
	{
		$output .= "<div class=\"error\">$error</div>\n";
	}

	// append a comment?
	if ($_REQUEST["appendcomment"])
	{
		$body = trim($body)."\n\n----\n\n--".$this->GetUserName()." (".strftime("%c").")";
	}

	$output .= $this->FormOpen("edit", "", "post", "edit", " cf='true' ");

	if ($_REQUEST["add"]) $output .= '<input name="lang" type="hidden" value="'.$this->pagelang.'" />';
	if ($_REQUEST["add"]) $output .= '<input name="tag" type="hidden" value="'.$this->tag.'" />';
	if ($_REQUEST["add"]) $output .= '<input name="add" type="hidden" value="1" />';

	print($output);
	$output = "";

	// preview?
	if ($_POST["preview"])
	{
		?>
      <input name="save" class="OkBtn"
			onmouseover='this.className=&quot;OkBtn_&quot;;'
			onmouseout='this.className=&quot;OkBtn&quot;;' type="submit" align="top"
			value="<?php echo $this->GetResourceValue("EditStoreButton"); ?>" />
      <img src="<?php echo $this->GetConfigValue("root_url");?>images/z.gif"
			class="buttonsspacer" alt="" border="0" />
      <input name="preview"
			class="OkBtn" onmouseover='this.className=&quot;OkBtn_&quot;;'
			onmouseout='this.className=&quot;OkBtn&quot;;' type="submit" align="top"
			value="<?php echo $this->GetResourceValue("EditPreviewButton"); ?>" />
      <img src="<?php echo $this->GetConfigValue("root_url");?>images/z.gif"
			class="buttonsspacer" alt="" border="0" />
      <input class="CancelBtn"
			onmouseover='this.className=&quot;CancelBtn_&quot;;'
			onmouseout='this.className=&quot;CancelBtn&quot;;' type="button" align="top"
			value="<?php echo $this->GetResourceValue("EditCancelButton"); ?>"
			onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
      <?php

			if ($this->GetConfigValue("edit_table_based"))
			$output .= '<div class="pageBefore"><img src="'.$this->GetConfigValue("root_url").'images/z.gif" width="1" height="1" alt="" style="border-width:0px; display: block; vertical-align:top" /></div><div class="page">';

			$output = "<fieldset class=\"preview\"><legend>".$this->GetResourceValue("EditPreview")."</legend>\n";

			$output .= $this->Format($body);
			$output .= "</fieldset><br />\n";

			print($output);
			$output = "";

}
?>
      <input name="save" class="OkBtn_Top"
			onmouseover='this.className=&quot;OkBtn_Top_&quot;;'
			onmouseout='this.className=&quot;OkBtn_Top&quot;;' type="submit" align="top"
			value="<?php echo $this->GetResourceValue("EditStoreButton"); ?>" />
      <img src="<?php echo $this->GetConfigValue("root_url");?>images/z.gif"
			class="buttonsspacer" alt="" border="0" />
      <input name="preview"
			class="OkBtn_Top" onmouseover='this.className=&quot;OkBtn_Top_&quot;;'
			onmouseout='this.className=&quot;OkBtn_Top&quot;;' type="submit" align="top"
			value="<?php echo $this->GetResourceValue("EditPreviewButton"); ?>" />
      <img src="<?php echo $this->GetConfigValue("root_url");?>images/z.gif"
			class="buttonsspacer" alt="" border="0" />
      <input
			class="CancelBtn_Top" onmouseover='this.className=&quot;CancelBtn_Top_&quot;;'
			onmouseout='this.className=&quot;CancelBtn_Top&quot;;' type="button"
			align="top"
			value="<?php echo str_replace("\n"," ",$this->GetResourceValue("EditCancelButton")); ?>"
			onclick="document.location='<?php echo addslashes($this->href("", "", "", 1))?>';" />
      <br />
      <?php
			$output .= "<input type=\"hidden\" name=\"previous\" value=\"".htmlspecialchars($previous)."\" /><br />";
			$output .= "<textarea id=\"postText\" name=\"body\" rows=\"40\" cols=\"60\" class=\"TextArea\">";
			$output .= htmlspecialchars($body)."</textarea><br />\n";
			print($output);
			if ($this->GetConfigValue("edit_table_based")) {
				?></td>
  </tr>
</table>
<div class="Wrapper" style='margin-top: 0px; padding-top: 0px'>
<div class="page" style='margin-top: 0px; padding-top: 0px'><br />
  <?php
}
?>
  <script language="JavaScript" type="text/javascript">
    wE = new WikiEdit(); 
    <?php
      if ($user = $this->GetUser())       
      if ($user["options"]["autocomplete"])
      {
        ?>if (AutoComplete) { wEaC = new AutoComplete( wE, "<?php echo $this->href("edit");?>" ); }<?php
      }
    ?>
    wE.init('postText','WikiEdit','edname-w','<?php echo $this->GetConfigValue("root_url");?>images/wikiedit/');
  </script>
  <input name="save" class="OkBtn"
	onmouseover='this.className=&quot;OkBtn_&quot;;'
	onmouseout='this.className=&quot;OkBtn&quot;;' type="submit" align="top"
	value="<?php echo $this->GetResourceValue("EditStoreButton"); ?>" />
  &nbsp;
  <input name="preview"
	class="OkBtn" onmouseover='this.className=&quot;OkBtn_&quot;;'
	onmouseout='this.className=&quot;OkBtn&quot;;' type="submit" align="top"
	value="<?php echo $this->GetResourceValue("EditPreviewButton"); ?>" />
  <img src="<?php echo $this->GetConfigValue("root_url");?>images/z.gif"
	class="buttonsspacer" alt="" border="0" />
  <input class="CancelBtn"
	onmouseover='this.className=&quot;CancelBtn_&quot;;'
	onmouseout='this.className=&quot;CancelBtn&quot;;' type="button" align="top"
	value="<?php echo $this->GetResourceValue("EditCancelButton"); ?>"
	onclick="document.location='<?php echo addslashes($this->href(""))?>';" />
  <?php
}

print ( $this->FormClose() );
}
else
{
	print("<div class=\"page\">");
	print($this->GetResourceValue("WriteAccessDenied"));
	print("</div>");
}
?>
</div>
